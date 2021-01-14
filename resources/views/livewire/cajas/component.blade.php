<div class="main-content">
 
     @if($action == 1)
     <div class="layout-pc-spacing">
     	<div class="row layout-top-spacing">
     		<div class="col-xs-12 col-lg-12 col-md-12 col-sm-12 layout-spacing">
     			<div class="widget-content-area br-4">
     				<div class="widget-one">
     					<h3>Mouvement de la boite</h3>
     					@include('common.search')
     					@include('common.alerts')
     					<div class="table-responsive">
     						<table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
     							<thead>
     								<tr>
     									<th class="text-center">DESCRIPTION</th>
     									<th class="text-center">TYPES</th>
     									<th class="text-center">MONTANT</th>
     									<th class="text-center">IMAGE</th>
     									<th class="text-center">DATE</th>
     									<th class="text-center">ACTIONS</th>
     								</tr>
     							</thead>
     							<tbody>   
     								@foreach($info as $r)
     								  <tr>
     								  	 <td class="text-center">{{ $r->concepto }}</td>
     								  	 <td class="text-center">{{ $r->tipo }}</td>
     								  	 <td class="text-center">{{ $r->monto }}</td>
     								  	 <td class="text-center">
     								  	 	 <img class="rounded" src="images/movs/{{$r->comprobante}}" alt=""  height="40" />
     								  	 </td>
     								  	 <td class="text-center">{{ $r->created_at }}</td>
     								  	  <td class="text-center">
     								  	  	@include('common.actions')
     								  	  </td>
     								  </tr>
     								@endforeach
     							</tbody>
     						</table>
     						{{ $info->links() }}
     					</div>
     				</div>

     			</div>
     		</div>
     	</div>
     </div>

     @elseif($action > 1)
     	@include('livewire.cajas.form')
     @endif
</div>

<script>
	document.addEventListener('DOMContentLoaded',function(){
		window.livewire.on('fileChoosen',()=>{
			let inputField=document.getElementById('image');
			let file =inputField.files[0] ;
			let reader = new FileReader();
			reader.onloadend=()=>{
				window.livewire.emit('fileUpload',reader.result)
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
    				window.livewire.emit('deleteRow', id)    //emitimos evento deleteRow
    				toastr.success('info', 'Enregistrement supprimé avec succès') //mostramos mensaje de confirmación 
    				swal.close()   //cerramos la modal
    			})


     }
</script>
    