<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Tarifa;
use App\Tipo;
use DB;

class TarifaController extends Component
{
	use WithPagination;
    protected $paginationTheme='bootstrap';

    public $tiempo="Choisir",$tipo="Choisir",$description,$costo,$jerarquia;
    public $selected_id,$search;
    public $action=1;
    public $pagination=5;
    public $tipos;

    public function mount(){
    	$this->getJerarquia();
    }
    public function getJerarquia(){
    	$tarifa = Tarifa::count();
    	if($tarifa > 0){
    		$tarifa = Tarifa::select('jerarquia')->orderBy('jerarquia','desc')->first();
    		$this->jerarquia=$tarifa->jerarquia + 1;
    	}
    }

    public function render()
    {
    	$this->tipos=Tipo::all();

    	if(strlen($this->search) >0){
    		$info=Tarifa::leftjoin('tipos as t','t.id','tarifas.tipo_id')
    		->where('tarifas.description','=',$this->search)
    		->orWhere('tarifas.tiempo','=',$this->search)
    		->select('tarifas.*','t.description as tipo')
    		->orderBy('tarifas.tiempo','desc')
    		->orderBy('t.description')
    		->paginate($this->pagination);
    		return view('livewire.tarifas.component',[
    			'info'=>$info
    		]);
    	}else{
    		$info=Tarifa::leftjoin('tipos as t','t.id','tarifas.tipo_id')
    		->select('tarifas.*','t.description as tipo')
    		->orderBy('tarifas.tiempo','desc')
    		->orderBy('t.description')
    		->paginate($this->pagination);
    		return view('livewire.tarifas.component',[
    			'info'=>$info
    		]);
    	}
        
    }


    public function updatingSearch(){
    	$this->gotoPage(1);
    }

    public function doAction($action){
     $this->resetInput();
      $this->action=$action;
    }

    public function resetInput(){
      $this->description='';
      $this->tiempo='';
      $this->costo='';
      $this->tipo='Choisir';
      $this->selected_id=null;
      $this->action=1;
      $this->search='';
    }

    public function edit($id){
    	$record=Tarifa::findOrFail($id);
    	$this->selected_id=$record->id;
    	$this->tipo=$record->tipo_id;
    	$this->description=$record->description;
    	$this->tiempo=$record->tiempo;
    	$this->costo=$record->costo;
    	$this->jerarquia=$record->jerarquia;
    	$this->action=2;
    }

    public function CreateOrUpdate(){

    	$this->validate([
    		'tiempo'=>'required',
    		'costo'=>'required',
    		'tipo'=>'required',
    	]);
    	if($this->selected_id >0){
    		$existe=Tarifa::where('tiempo',$this->tiempo)
    		->where('tipo_id',$this->tipo)
    		->where('id','<>',$this->selected_id)
    		->select('tiempo')
    		->count();
    	}else{
    		$existe=Tarifa::where('tiempo',$this->tiempo)
    		->where('tipo_id',$this->tipo)
    		->select('tiempo')
    		->count();
    	}

    	if($existe >0){
    		$this->emit('msg-error','Le forfait existe ');
    		$this->resetInput();
    		return;
    	}

    	if($this->selected_id<=0){

    		$tarifa=Tarifa::create([
    			'tiempo'=>$this->tiempo,
    			'description'=>$this->description,
    			'costo'=>$this->costo,
    			'tipo_id'=>$this->tipo,
    			'jerarquia'=>$this->jerarquia
    		]);
    		
    		
    	}else{
    		$tarifa = Tarifa::find($this->selected_id);
    		$tarifa->update([
    			'tiempo'=>$this->tiempo,
    			'description'=>$this->description,
    			'costo'=>$this->costo,
    			'tipo_id'=>$this->tipo,
    			'jerarquia'=>$this->jerarquia
    		]);
    	}

    	if($this->jerarquia==1){
    		Tarifa::where('id','<>',$tarifa->id)->update([
    			'jerarquia'=>0
    		]);
    	}

    	if($this->selected_id)
    		$this->emit('msg-ok','Forfait actualisé');
    	else
    		$this->emit('msg-ok','Forfait créé');

    	$this->resetInput();
    	$this->getJerarquia();
    }

    protected $listeners=[
    	'deleteRow'=>'destroy',
    	'createFromModal'=>'createFromModal'
    ];

    public function createFromModal($info){
    	$data=json_decode($info);
    	$this->selected_id=$data->id;
    	$this->tipo=$data->tipo;
    	$this->description=$data->description;
    	$this->tiempo=$data->tiempo;
    	$this->costo=$data->costo;
    	$this->jerarquia=$data->jerarquia;

    	$this->CreateOrUpdate();


    }
    public function destroy($id){
    	if($id){
    		$record=Tarifa::where('id',$id);
    		$record->delete();
    		$this->resetInput();
    		$this->emit('msgok','Enregistrement supprimé');
    	}
    }

}
