<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use App\Caja ;

class CajaController extends Component
{
	use WithPagination;
   protected $paginationTheme = 'bootstrap';

	public $tipo="Choisir",$concepto,$monto,$comprobante,$event;
	public $selected_id,$search;
	public $action=1,$pagination=5;

  public function mount(){
     $this->event=false;
  }

    public function render()
    {

    	if(strlen($this->search)>0){
           $infos=Caja::where('tipo','=',$this->search)
          ->orWhere('concepto','=',$this->search)
          ->paginate($this->pagination) ;

    		 return view('livewire.cajas.component',[
    		 	'info'=>$infos
    		 ]);
    	}else{
    		$cajas=Caja::leftjoin('users as u','u.id','cajas.user_id')
    		->select('cajas.*','u.name')
    		->orderBy('id','desc')
    		->paginate($this->pagination);

    		return view('livewire.cajas.component',[
    		 	'info'=>$cajas
    		 ]);
    	}
       
    }

     // pour rechercher avec la pagination
    public function updatingSearch():void {
    	$this->gotoPage(1);
    }

    public function doAction($action){
     $this->resetInput();
      $this->action=$action;
    }

     public function resetInput(){
      $this->concepto='';
      $this->tipo='Choisir';
      $this->monto='';
      $this->comprobante='';
      $this->selected_id=null;
      $this->action=1;
      $this->search='';
    }

     public function edit($id){
    	$record=Caja::findOrFail($id);
    	$this->selected_id=$record->id;
    	$this->tipo=$record->tipo_id;
    	$this->concepto=$record->concepto;
    	$this->monto=$record->monto;
    	$this->comprobante=$record->comprobante;
    	$this->action=2;
    }

    public function StoreOrUpdate(){
   
        $this->validate([
            'tipo' => 'required',
            'monto' => 'required',
            'concepto' => 'required'
        ]);
        
        // condicional para crear o actualizar en Tabla Cajas
        if ($this->selected_id <= 0) 
        {
            $record = Caja::create([
                'monto' => $this->monto,
                'tipo' => $this->tipo,
                'concepto' => $this->concepto,
                'user_id' => Auth::user()->id // auth()->user()->id
            ]); 

            if($this->comprobante !=null && $this->event)
            {
                $image = $this->comprobante;
                  $fileName = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                  $moved = \Image::make($image)->save('images/movs/'.$fileName);

                  if($moved) 
                  {
                    $record ->comprobante = $fileName;
                    $record->save();
                  }
                }
       }
        else 
        {
            $record = Caja::find($this->selected_id);
           // dd($record);
            $record->update([
                'monto' => $this->monto,
                'tipo' => $this->tipo,
                'concepto' => $this->concepto,
                'user_id' => Auth::user()->id
            ]);


           if($this->comprobante !=null && $this->event )
            {
                $image = $this->comprobante ;
                
                $fileName = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                $moved = \Image::make($image)->save('images/movs/'.$fileName);

                if ($moved) 
                {
                    $record->comprobante = $fileName;
                    $record->save();
                } 
            }
        }

        if ($this->selected_id) {
            $this->emit('msgok', 'Movimiento de Caja Actualizado con Éxito');
        } else {
            $this->emit('msgok', 'Movimiento de Caja fué creado con Éxito');
        }

        $this->resetInput();

    }

     public function destroy($id){
      if($id){
        $record=Caja::where('id',$id);
        $record->delete();
        $this->resetInput();
        $this->emit('msgok','Enregistrement supprimé');
      }
    }

     protected $listeners=[
       'deleteRow'=>'destroy',
       'fileUpload'=>'handleFileUpload'
    ];

    public function handleFileUpload($imageData){
      $this->comprobante=$imageData;
      $this->event=true;
    }



}
