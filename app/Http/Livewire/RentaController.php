<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\ClienteVehiculo;
use App\Cajon;
use App\Renta;
use App\Tarifa;
use App\Tipo;
use App\User;
use App\Vehiculo;
use Carbon\Carbon;
use DB;
    
class RentaController extends Component
{
	use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $selected_id,$search,$buscarCliente,$barcode,$obj,$clienteSelected, $clientes;
    public $name,$telefono,$movil,$email,$placa,$tipo,$tipo_id=1,$total,$tiempo,$direccion,$modelo,$marca,$color,$fecha_fin,$nota,$arrayTarifas,$tarifaSelected,$status,$fecha_ini,$fraction;
    public $pagination=5,$section=1;

    public function mount(){
        $this->arrayTarifas=Tarifa::all();

        if($this->arrayTarifas->count()>0) $this->tarifaSelected=$this->arrayTarifas[0]->id ;
    }

    //primer metodo que sd carga de nuestro 
    public function render()
    {

        $this->tipo=Tipo::all();

        $clientes = null;
        $cajones = Cajon::join('tipos as t','t.id','cajones.tipo_id')
            ->select('cajones.*','t.description as tipo','t.id as tipo_id','t.imagen',
                DB::RAW("'' as tarifa_id "),DB::RAW("'' as barcode "),DB::RAW("0 as folio "),DB::RAW("'' as description_coche "))
            ->get();
        // buscar clientes
        if(strlen($this->buscarCliente) > 0)
        {
            $clientes = ClienteVehiculo::leftjoin('users as u','u.id','cliente_vehiculos.user_id')
                ->leftjoin('vehiculos as v','v.id','cliente_vehiculos.vehiculo_id')
                ->select('v.id as vehiculo_id','v.placa','v.marca','v.color','v.nota','v.modelo','u.id as cliente_id','name','telefono','movil','email','direccion')
                ->where('name','like','%'.$this->buscarCliente.'%')
                ->get();
        }
        else
        {
            $clientes = User::where('tipo','Cliente')->select('id','name','telefono','movil','email','direccion', DB::RAW("'' as vehiculos"))
            ->take(1)->get();
        }
        $this->clientes = $clientes;

        foreach ($cajones as $c) {
            
            $tarifa = Tarifa::where('tipo_id', $c->tipo_id)->select('id')->first();
            $c->tarifa_id = $tarifa['id'];
            
            $renta = Renta::where('cajon_id', $c->id)
                ->select('barcode','id','description as description_coche')
                ->where('estatus','OUVRIR')
                ->orderBy('id','desc')
                ->first();
            // $c->barcode = isset($renta['barcode']) ? ($renta['barcode']) : '' ;
           // $c->barcode = ($renta['barcode'] ?? '');
            $c->barcode = ($renta['barcode'] == null ? '' : $renta['barcode']);
            $c->folio = ($renta['id'] == null ? '' : $renta['id']);
            $c->description_coche = ($renta['description_coche'] == null ? '' : $renta['description_coche']);

        }

        return view('livewire.rentas.component', [
            'cajones' => $cajones
        ]);
    }


     protected $listeners=[
        'RegistrarEntrada'=>'RegistrarEntrada',
        'doCheckOut'=>'doCheckOut',
        'doCheckIn'=>'doCheckIn',
     ];

     //consultar info de un ticket dato
     public function doCheckOut($barcode,$section=2){


        $bcode= $barcode=='' ? $this->barcode : $barcode ;


         
       $obj=Renta::where('barcode',(int)$bcode)->select('*',DB::RAW("'' as tiempo"),DB::RAW("'' as total"))->first();
         
        if($obj !=null){

            $this->section=$section;
            $this->barcode=$bcode;
    
            $start=\Carbon\Carbon::parse($obj->acceso);
            $end=new \DateTime(\Carbon\Carbon::now());

            $obj->tiempo=$start->diffInHours($end) .':'.$start->diff($end)->format('%I:%S');
            $obj->total=$this->calculateTotal($obj->acceso,$obj->tarifa_id);

            $tarifa=Tarifa::where('id',$obj->tarifa_id)->first();

            $this->fraction=$tarifa->costo ;
            $this->obj=$obj;

        }else{

            $this->emit('msg-error','No existe el codigo de barras');
            $this->barcode='';

            return;
        }
         
     }

     public function calculateTotal($fromDate,$tarifaId,$toDate=''){

        $fraction=0;

        $tarifa=Tarifa::where('id',$tarifaId)->first();


        $start=\Carbon\Carbon::parse($fromDate);

        $end=new \DateTime(\Carbon\Carbon::now());

        if($toDate=='') $end=\Carbon\Carbon::parse($toDate);

        $tiempo =$start->diffInHours($end).':'.$start->diff($end)->format('%I:%S');
        $minutos=$start->diffInMinutes($end);

        $horasCompletas=$start->diffInHours($end);

        //tarifa $13

        if($minutos <=65){ // de 0 à 65 minutos se cobra tarifa completa ($13.0)

            $fraction=$tarifa->costo;
        }else{
            $m=($minutos%60);
            if(in_array($m,range(0,5))) //5 minutos de tolerancia in para sacar el coche
            {

            }else if(in_array($m,range(6,30))){//depues de la ira hora , de 6 à 30 minutos se cobra media tarifa ($6,50)

                $fraction = $tarifa->costo/2 ;
            }else if(in_array($m,range(31,59))){ //depues de la ira hora , de 31 à 59 minutos se cobra media tarifa completa
                $fraction = $tarifa->costo ;
            }
        }

         //retourna el total cobra

         $total=(($horasCompletas*$tarifa->costo)+$fraction);

         return $total;

     }

     public function RegistrarTicketRenta()
    {

         

        // reglas de validación
        $rules = [
            'name' => 'required|min:3',
            'direccion' => 'required',
            'placa' => 'required',
            'email' => 'nullable|email'
        ];
        // mensajes personalizados
        $customMessages = [
            'name.required' => 'Le champ nom est requis',
            'direccion.required' => 'Le champ direction est requis',
            'placa.required' => 'Le champ plaque est requis'
        ];
        // ejecutar las validaciones
        $this->validate($rules, $customMessages);

        // verificamos que el vehículo no tenga tickets abiertos
        $exist = Renta::where('placa', $this->placa)->where('vehiculo_id', '>', '0')->where('estatus', 'OUVRIR')->count();
         if($exist > 0)
        {
            $this->emit('msg-error', 'La plaque $this->placa a été alloué avec une durée de validation');
            return;
        }

        // iniciar transacción 
       // DB::beginTransaction();
        try
        {
             
            //$tip = Tipo::find($this->tipo);
             $tip=$this->tipo_id ;


           // dd($this->clienteSelected);
            if($this->clienteSelected > 0)
            {
                $cliente = User::find($this->clienteSelected);
            }
            else
            {
                
                // validar si se ingresó correo o generamos uno 
                if(empty($this->email)) $this->email = str_replace(' ', '_',$this->name) . '_' . uniqid() . '_@sysparking.com';
                
                  $cliente = User::create([
                    'name' => $this->name,
                   // 'rut' => $this->rut,
                    'telefono' => $this->telefono,
                    'movil' => $this->movil,
                    'direccion' => $this->direccion,
                    'tipo' => 'Client',
                    'email' => $this->email,
                    'password' => bcrypt('password')
                ]);
               /* if($this->foto !=null && $this->event)
                {
                    $image = $this->foto;
                    $fileName = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                    $moved = \Image::make($image)->save('images/users/'.$fileName);

                    if($moved)
                    {
                        $cliente->foto = $fileName;
                        $cliente->save();
                    }
                }*/
                
            }
        
            // registrar el vehículo
          $vehiculo = Vehiculo::create([
                'placa' => $this->placa,
                'modelo' => $this->modelo,
                'marca' => $this->marca,
                'color' => $this->color,
                'nota' => $this->nota,
                'tipo_id' => $tip,
            ]);

            // registrar la asociación vehículos y clientes
           $cv = ClienteVehiculo::create([
                'user_id' => $cliente->id,
                'vehiculo_id' => $vehiculo->id
            ]);
            
            $data1=[
                'acceso' => Carbon::parse($this->fecha_ini),
                'salida' => Carbon::parse($this->fecha_fin),
                'user_id' => auth()->user()->id,
                'tarifa_id' => $this->tarifaSelected,
                'placa' => $this->placa,
                'modelo' => $this->modelo,
                'marca' => $this->marca,
                'color' => $this->color,
                'description' => $this->nota,
                'direccion' => $this->direccion,
                'vehiculo_id' => $vehiculo->id,
                'total' => $this->total,
                'hours' => $this->tiempo,  
                //'barcode'   => sprintf('$7d', $this->barcode) 
                'barcode'   =>uniqid()

            ];

            //dd($data1);
            
            // registrar ticket en rentas 
            $renta = DB::table('rentas')->insert($data1); 
       
            // generar el barcode
           // $renta->barcode = sprintf('$07d', $renta->id);
           // $renta->save();

            // enviar feedback al user 
            $this->barcode = '';
            $this->emit('msgok', 'Le client a été enregistré dans le système');
           // $this->emit('print-pension', $renta->id);
            $this->section = 1;
            $this->limpiarCliente();

            // confirmar la transacción 
           // DB::commit();
        }
        catch (\Exception $e)
        {
            // en caso de error deshacemos para no generar inconsistencia en la info 
           // DB::roolback();
            $status = $e->getMessage();
            // dd($e);
        }
       
         
    }

     // método para obtener tarifa, fecha de salida y total a cobrar en tickets de renta
    public function getSalida()
    {
        if($this->tiempo <= 0)
        {
            $this->total = number_format(0,2);
            $this->fecha_fin = '';

        }
        else
        {
             $this->fecha_ini =\Carbon\Carbon::now()->format('d-m-Y') ;
            $this->fecha_fin = Carbon::now()->addMonths($this->tiempo)->format('d-m-Y');
            $tarifa = Tarifa::where('tiempo', 'Mois')->select('costo')->first();

             if($tarifa->count())
             {
                 //  calcular total meses*tarifa
                 $this->total = $this->tiempo * $tarifa->costo;
             }
        }
    }

     public function mostrarCliente($cliente)
    {
        $this->clientes = '';
        $this->buscarCliente = '';
        $clienteJson = json_decode($cliente);
      
        $this->name = $clienteJson->name;
        // // $this->rut = $clienteJson-> rut;
        $this->telefono = $clienteJson->telefono;
        $this->movil = $clienteJson->movil;
        $this->email = $clienteJson->email;
        $this->direccion = $clienteJson->direccion;

        $this->placa = $clienteJson->placa;
        $this->modelo = $clienteJson->modelo;
        $this->color = $clienteJson->color;
        $this->marca = $clienteJson->marca;
        $this->nota = $clienteJson->nota;
        $this->clienteSelected = $clienteJson->cliente_id;
    }
     public function limpiarCliente()
    {
        $this->name = '';
        $this->telefono = '';
        $this->movil = '';
        $this->email = '';
        $this->direccion = '';
        $this->placa = '';
        $this->modelo = '';
        $this->color = '';
        $this->marca = '';
        $this->nota = '';
        $this->clienteSelected = null;
    }


    // método para emitir ticket rápido de entrada de vehículo
    public function TicketVisita()
    {
         // obtener las tarifas
        $tarifas = Tarifa::select('jerarquia', 'tipo_id', 'id')->orderBy('jerarquia', 'desc')->get();
        $tarifaID= '';

         // obtenemos el siguiente cajón  disponible
        foreach ($tarifas as $j)
        {
           $cajon = Cajon::where('estatus', 'DISPONIBLE')->select('tipo_id')->first();
           // $cajon = Cajon::where('estatus', 'DISPONIBLE')->get()->first();
           
            if($cajon)
            {
                $tarifaID = $j->id;
                break;
            }

        }
        if($cajon == null)
        {
            $this->emit('msg-error', 'Tous les espaces sont occupés');
            return;
        }

        // poner cajón ocupado
        $cajon->estatus='OCCUPE';
        $cajon->save();
        // registrar entrada
        $renta = Renta::create([
            'acceso' => Carbon::now(),
            'user_id' => auth()->user()->id,
            'tarifa_id' => $tarifaID,
            'cajon_id' => $cajon->id
        ]);
         // generamos el barcode a 7 dígitos

        $renta->barcode = sprintf('%7d',$renta->id);
        $renta->save();

        // feedback al user
        $this->barcode = '';
        $this->emit('msgok', 'Information enregistré dans le système');
       
       
    }

     // método para calcular el tiempo de estancia del vehículo
    public function CalcularTiempo($fechaEntrada)
    {
        $start = Carbon::parse($fechaEntrada);
        $end = new \DateTime(Carbon::now());
        $tiempo = $start->diffInHours($end) . ':' . $start->diff($end)->format('%I:%S');
        return $tiempo;
    }

    public function BuscarTicker()
    {
        $nuevoTotal = 0;

        // reglas de validación 
        $rules = ['barcode' => 'required'];

        // mensajes personalizados
        $customMessages = ['barcode.required' => 'Ingresa o escanea el código de barras'];

        // ejecutamos la validación
        $this->validate($rules, $customMessages);

        $ticket = Renta::where('barcode', $this->barcode)->select('*')->first();
        if($ticket)
        {
            if($ticket->estatus == 'FERMER')
            {
                $this->emit('msg-ops', 'El ticket ya tiene registrada la salida');
                $this->barcode = '';
                return;
            }
        }
        else
        {
            $this->emit('msg-ops', 'El código no existe en el sistema');
            $this->barcode = '';
            return;
        }

        // obtenemos la tarifa
        $tarifa = Tarifa::where('id', $ticket->tarifa_id)->first();

        // obtenemos tiempo
        $tiempo = $this->CalcularTiempo($ticket->acceso);

        // obtener el total
        $nuevoTotal = $this->calculateTotal($ticket->acceso, $ticket->tarifa_id);

        $ticket->salida = Carbon::now();
        $ticket->estatus = 'FERMER';
        $ticket->total = $nuevoTotal;
        $ticket->hours = $tiempo;
        $ticket->save();

        // ponemos el cajón disponible
        $cajon = Cajon::where('id', $ticket->cajon_id)->first();
        $cajon->estatus = 'DISPONIBLE';
        $cajon->save(); 

        // feedback al user 
        if($ticket)
        {
            $this->barcode = '';
            $this->section = 1;
            $this->emit('msgok','Salida Registrada con éxito');
        }
        else
        {
            $this->barcode = '';
            $this->section = 1;
            $this->emit('msg-error','No se pudo registrar la salida :/');
        }
    }

    // método para registrar entradas de vehículos al estacionamiento
    public function RegistrarEntrada($tarifa_id, $cajon_id, $estatus = '', $comment = '') 
    {
        if($estatus == 'OCCUPE')
        {
            $this->emit('msg-ok', 'El Cajón ya está ocupado');
            return;
        }
        
        // ponemos cajón ocupado
        $cajon = Cajon::where('id', $cajon_id)->first();
        $cajon->estatus = 'OCCUPE';
        $cajon->save();

        // registrar entrada
        $renta = Renta::create([
            'acceso' => Carbon::now(),
            'user_id' => auth()->user()->id,
            'tarifa_id' => $tarifa_id,
            'cajon_id' => $cajon_id,
            'description' => $comment
        ]);

        // generamos código a 7 dígito para su posterior impresión con el estandar code 39
        $renta->barcode = sprintf('%7d', $renta->id);
        $renta->save();

        // enviamos feedback al user
        $this->barcode = '';
        $this->emit('msg-ok', 'Entrada registrada en Sistema');
        $this->emit('msg-error', $renta->id);
    }
} 
