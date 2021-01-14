<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\User;
use Livewire\WithPagination;

class UsuarioController extends Component
{
	use WithPagination;

    protected $paginationTheme = 'bootstrap';

	public $tipo="Choisir",$name,$telefono,$movil,$email,$direccion,$password ;
	public $selected_id,$search ;
	public $action=1, $pagination=5;

	protected $rules = [
        'name' => 'required|min:6',
        'email' => 'required|email',
        'telefono' => 'required|min:8',
        'password' => 'required',
        'tipo' => "not_in:Choisir",
    ];
     protected $messages = [
        'email.required' => 'Veuillez renseigner le champ email.',
        'email.email' => 'Veuillez renseigner un email valide',
        'name.required' => 'Veuillez renseigner un nom et prénoms.',
        'name.min' => "Veuillez saisir un nom d'au moins 6 caractères.",
        'telefono.required' => 'Veuillez renseigner un numéro de télephone.',
        'telefono.min' => "Veuillez saisir un numéro de télephone d'au moins 8 caractères.",
        'password.required' => 'Veuillez renseigner un mot de passe.',
        'tipo.not_in' => 'Veuillez choisir un type .',
    ];

	 public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
    	if (strlen($this->search)>0) {

     		$info=User::where('name','=',$this->search)
    		      ->orWhere('telefono','=',$this->search)
    		      ->paginate($this->pagination);
    		     
    		 return view('livewire.usuarios.component',[
    		 	'info'=>$info
    		 ]);

    	}else{

    		$info=User::orderBy('id','desc')
    		      ->paginate($this->pagination);

    		 return view('livewire.usuarios.component',[
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
    	$this->name='';
    	$this->tipo='Choisir';
    	$this->telefono='';
    	$this->movil='';
    	$this->email='';
    	$this->direccion='';
    	$this->password='';
    	$this->selected_id=null;
    	$this->action=1;
    	$this->search='';
    }

    public function edit($id){
    	$record=User::find($id);
    	$this->name=$record->name;
    	$this->tipo=$record->tipo;
    	$this->telefono=$record->telefono;
    	$this->movil=$record->movil;
    	$this->email=$record->email;
    	$this->direccion=$record->direccion;
    	//$this->password=$record->tipo;
    	$this->selected_id=$record->id;
    	$this->action=2;
    	$this->search='';

    	 
    }

    public function StoreOrUpdate(){

    	 $validatedData = $this->validate(); 

    	 
    	 if($this->selected_id <=0){
    	 	$user=User::create([
    	 		'name'=>$this->name,
    	 		'telefono'=>$this->telefono,
    	 		'movil'=>$this->movil,
    	 		'tipo'=>$this->tipo,
    	 		'email'=>$this->email,
    	 		'direccion'=>$this->direccion,
    	 		'password'=>bcrypt($this->password),

    	 	]);
    	 }else{

    	 	 $user=User::find($this->selected_id);

    	 	 $user->update([
    	 	 	'name'=>$this->name,
    	 		'telefono'=>$this->telefono,
    	 		'movil'=>$this->movil,
    	 		'tipo'=>$this->tipo,
    	 		'email'=>$this->email,
    	 		'direccion'=>$this->direccion,
    	 		'password'=>bcrypt($this->password),
    	 	 ]);
    	 }

    	 if($this->selected_id)
    		$this->emit('msgok','Utilisateur actualisé');
    	else
    		$this->emit('message','Utilisateur créé');

    	$this->resetInput();


    }

    public function destroy($id){
    	if($id){
    		$record=User::where('id',$id);
    		$record->delete();
    		$this->resetInput();
    		$this->emit('msgok','Enregistrement supprimé');
    	}
    }

     protected $listeners=[
       'deleteRow'=>'destroy'
    ];



    
}
