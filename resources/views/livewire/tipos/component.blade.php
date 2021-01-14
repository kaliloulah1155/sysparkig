    <div class="row layout-top-spacing">    
    	<div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
           @if($action == 1)                

           <div class="widget-content-area br-4">
             <div class="widget-header">
                <div class="row">
                   <div class="col-xl-12 text-center">
                      <h5><b>Type de véhicules</b></h5>
                  </div> 
              </div>
          </div>
          @include('common.search') <!-- búsqueda y botón para nuevos registros -->
          @include('common.alerts') <!-- mensajes -->

          <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
               <thead>
                  <tr>                                                   
                     <th class="">ID</th>
                     <th class="">DESCRIPTION</th>
                     <th class="text-center">IMAGE</th>
                     <th class="">DATE DE CREATION</th>
                     <th class="text-center">ACTIONS</th>
                 </tr>
             </thead>
             <tbody>
              @foreach($info as $r) <!-- iteración para llenar la tabla-->
              <tr>

                 <td><p class="mb-0">{{$r->id}}</p></td>
                 <td>{{$r->description}}</td>
                  <td class="text-center">
                     <img class="rounded" src="images/{{$r->imagen}}" alt=""  height="40" />
                  </td>
                 <td>{{$r->created_at}}</td>
                 <td class="text-center">
                    @include('common.actions') <!-- botons editar y eliminar -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$info->links()}} <!--paginado de tabla -->
</div>

</div>     

@elseif($action == 2)
	@include('livewire.tipos.form')		
@endif  
</div>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('fileChoosen', () => {
            let inputField = document.getElementById('image')
            let file = inputField.files[0]
            let reader = new FileReader();
            reader.onloadend = ()=> {
                window.livewire.emit('fileUpload', reader.result)
            }
            reader.readAsDataURL(file);
        }); 

    });


    function Confirm(id)
    {

     let me = this
     swal({
        title: 'CONFIRMER',
        text: 'VOUS-VOULEZ SUPPRIMER CET ENREGISTREMENT ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Valider',
        cancelButtonText: 'Annuler',
        closeOnConfirm: false
    },
    function() {
       /// console.log('ID', id);
    				window.livewire.emit('deleteRow', id)    //emitimos evento deleteRow
    				toastr.success('info', 'Enregistrement supprimé avec succès') //mostramos mensaje de confirmación 
    				swal.close()   //cerramos la modal
    			})


 }

</script>