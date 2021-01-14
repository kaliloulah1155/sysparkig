<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Tipo;

class TiposController extends Component
{
	use WithPagination;

    protected $paginationTheme = 'bootstrap';

	//public properties
	public $description ,$logo,$event;
	public $selected_id,$search;
	public $action=1;
	private $pagination=5;

    
	public function mount(){
		// intialisation des variables
	}

    public function render()
    {

       
    	if(strlen($this->search)>0){

    		$info=Tipo::where('description','=',$this->search)->paginate($this->pagination);

    		 return view('livewire.tipos.component',[
    		 	'info'=>$info,
    		 ]);
    	}else{
    		$info=Tipo::paginate($this->pagination);
    		 return view('livewire.tipos.component',[
    		 	'info'=>$info,
    		 ]);
    	}
       
    }
    // pour rechercher avec la pagination
    public function updatingSearch():void {
    	$this->gotoPage(1);
    }

    public function doAction($action){

      $this->action=$action;
    }

    public function resetInput(){
      $this->description='';
      $this->selected_id=null;
      $this->action=1;
      $this->search='';
    }

    public function edit($id){


    	$record=Tipo::findOrFail($id);
    	$this->description=$record->description;
    	$this->selected_id=$record->id;
    	$this->action=2;
    }

    public function StoreOrUpdate(){
    	$this->validate([
    		'description'=>'required|min:4'
    	]);

    	if($this->selected_id >0 ){
    		$existe=Tipo::where('description',$this->description)->where('id','<>',$this->selected_id)->select('description')->get();

    		if($existe->count() >0){
    			session()->flash('msg-error','Il existe déjà un enregistrement');
    			$this->resetInput();
    			return ;
    		}
    	}else{

    		$existe=Tipo::where('description',$this->description)->select('description')->get();
    		if($existe->count() >0){
    			session()->flash('msg-error','Il existe déjà un enregistrement');
    			$this->resetInput();
    			return ;
    		}
    	}

    	if($this->selected_id <=0){
    		$record=Tipo::create([
    			'description'=>$this->description
    		]);
            if($this->logo !=null && $this->event)
            {
            $image = $this->logo;
            $fileName = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
              $moved = \Image::make($image)->save('images/'.$fileName);

              if($moved) 
              {
                $record ->imagen = $fileName;
                $record->save();
              }
            }
    	//session()->flash('message','Type créé');
    	}else{

    		$record=Tipo::find($this->selected_id);
    		 
    		$record->update([
    			'description'=>$this->description
    		]);
            if($this->logo !=null && $this->event)
            {
            $image = $this->logo;
            $fileName = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
              $moved = \Image::make($image)->save('images/'.$fileName);

              if($moved) 
              {
                $record ->imagen = $fileName;
                $record->save();
              }
            }



    	}

    	if($this->selected_id)
    		session()->flash('message','Type actualisé');
    	else
    		session()->flash('message','Type créé');

    	$this->resetInput();


    }

    public function destroy($id){
    	if($id){
    		$record=Tipo::find($id);
    		$record->delete();
    		$this->resetInput();
    	}
    }

    protected $listeners=[
       'deleteRow'=>'destroy',
       'fileUpload'=>'handleFileUpload'
    ];

    public function handleFileUpload($imageData){
      $this->logo=$imageData;
      $this->event=true;
    }

}

