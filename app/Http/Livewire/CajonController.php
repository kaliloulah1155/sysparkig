<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Cajon;
use App\Tipo;

class CajonController extends Component
{
	use WithPagination;
     protected $paginationTheme = 'bootstrap';
     
	public $tipo ='Choisir',$description,$estatus="DISPONIBLE",$tipos;
	public $selected_id, $search;
	public $action=1,$pagination=5;

	public function mount(){
      // $this->name='konate';
	}

    public function render()
    {
    	 $this->tipos=Tipo::all();

    	 if(strlen($this->search)>0){
    	 	 //dd('1');
	    	 	$info=Cajon::leftjoin('tipos as t','t.id','cajones.tipo_id')
		    	 ->select('cajones.*','t.description as tipo')
		    	 ->where('cajones.description','=',$this->search)
		    	 ->orWhere('cajones.estatus','=',$this->search)
		    	 ->paginate($this->pagination);
	    	 return view('livewire.cajones.component',[
	    	 	'info'=>$info
	    	 ]);
    	 }else{

    	 	// dd('2');
    	 	$info=Cajon::leftjoin('tipos as t','t.id','cajones.tipo_id')
		    	 ->select('cajones.*','t.description as tipo')
		    	 ->orderBy('cajones.id','desc')
		    	 ->paginate($this->pagination);
	    	 return view('livewire.cajones.component',[
	    	 	'info'=>$info
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
      $this->description='';
      $this->tipo='Choisir';
      $this->estatus='DISPONIBLE';
      $this->selected_id=null;
      $this->action=1;
      $this->search='';
    }

    public function edit($id){
    	$record=Cajon::findOrFail($id);
    	$this->selected_id=$record->id;
    	$this->tipo=$record->tipo_id;
    	$this->description=$record->description;
    	$this->estatus=$record->estatus;
    	$this->action=2;
    }

     public function StoreOrUpdate(){
    	$this->validate([
    		'tipo'=>'required',
    		'description'=>'required',
    		'estatus'=>'required'
    	]);

    	if($this->selected_id <=0 ){

    		$cajon=Cajon::create([
    			'description'=>$this->description,
    			'tipo_id'=>$this->tipo,
    			'estatus'=>$this->estatus
    		]);

    		 
    	}else{

           
    		$record=Cajon::find($this->selected_id);
    		 $record->update([
    		 	'description'=>$this->description,
    		 	'tipo_id'=>$this->tipo,
    		 	'estatus'=>$this->estatus
    		 ]);
    	}

    	
    	if($this->selected_id)
    		$this->emit('msgok','Boite actualisée');
    	else
    		$this->emit('message','Boite créé');

    	$this->resetInput();


    }
    public function destroy($id){
    	if($id){
    		$record=Cajon::where('id',$id);
    		$record->delete();
    		$this->resetInput();
    		$this->emit('msgok','Enregistrement supprimé');
    	}
    }

    protected $listeners=[
       'deleteRow'=>'destroy'
    ];
}
