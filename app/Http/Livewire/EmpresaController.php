<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Empresa;
use DB;

class EmpresaController extends Component
{
	public $nombre, $telefono,$email, $direccion, $logo,$event;
    

    public function mount(){

       $this->event=false;
       $empresa = Empresa::all();
        
       if($empresa->count()>0){
       	   $this->nombre=$empresa[0]->nombre;
	       $this->telefono=$empresa[0]->telefono;
	       $this->direccion=$empresa[0]->direccion;
	       $this->email=$empresa[0]->email;
	       $this->logo=$empresa[0]->logo;
       }
       
    }

    public function render()
    {
        return view('livewire.compagnie.component');
    }

    public function Guardar()//CreateOrUpdate
    {
        $rules=[
        	'nombre'=>'required',
        	'telefono'=>'required',
        	'email'=>'required|email',
        	'direccion'=>'required',
        ];

        $customMessages=[
        	'nombre.required'=>'Le champ nom est requis',
        	'telefono.required'=>'Le champ téléphone est requis',
        	'email.required'=>'Le champ email est requis',
        	'email.email'=>'Le champ email est un email',
        	'direccion.required'=>'Le champ direction est requis',
        ];

        $this->validate($rules,$customMessages);

        DB::table('empresas')->truncate();
        $record = Empresa::create([
           'nombre'=>$this->nombre,
	       'telefono'=>$this->telefono,
	       'direccion'=>$this->direccion,
	       'email'=>$this->email,
        ]);
         
        if($this->logo !=null && $this->event)
        {
            $image = $this->logo;
              $fileName = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
              $moved = \Image::make($image)->save('images/logo/'.$fileName);

              if($moved) 
              {
                $record ->logo = $fileName;
                $record->save();
              }
        }

        $this->emit('msgok','Information enregistrée');
    }

    protected $listeners=[
       'fileUpload'=>'handleFileUpload'
    ];

    public function handleFileUpload($imageData){
      $this->logo=$imageData;
      $this->event=true;
    }
}
