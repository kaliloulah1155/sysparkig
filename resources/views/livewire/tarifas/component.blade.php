<div class="row layout-top-spacing">
    
    <div class="col-sm-12 col-md-12 col-lg-12 layout-spacing">
     
     
     	<div class="widget-content-area br-4">
     		<div class="widget-header">
     			 <div class="row">
     			 	 <div class="col-sm-12 text-center">
     			 	 	<h5><b>Forfaits du systèmes</b></h5>
     			 	</div>
     			 </div>
     		</div>
     		{{-- begin search --}}
     		<div class="row justify-content-between mb-4 mt-3" >
				<div class="col-4">
				 	<div class="input-group">
				 		 <div class="input-group-prepend">
				              <span class="input-group-text" id="basic-addon1">
				              	 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
			                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
			                                        stroke-linejoin="round" class="feather feather-search">
			                                        <circle cx="11" cy="11" r="8"></circle>
			                                       
			                                    </svg>

				              </span>
						</div>
						  <input type="text" wire:model.lazy="search" class="form-control" placeholder="Rechercher" aria-label="notification">
					</div>
				</div>

				<div class="col-2 mt-2 mb-2 text-right mr-2">
					 <button type="button" onclick="openModal()" class="btn btn-btn-dark" style="background:black">
					 	  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file" style="background:white"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
					 </button>
				</div>
				
			</div>
			{{-- end search --}}

     		 <div class="table-responsive">
     		 	<table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
     		 		<thead>
     		 			<tr>
     		 				<th>ID</th>
     		 				<th>TEMPS</th>
     		 				<th>DESCRIPTION</th>
     		 				<th>COUT</th>
     		 				<th>TYPE</th>
     		 				<th>HIERARCHIE</th>
     		 				<th>ACTIONS</th>
     		 			</tr>
     		 		</thead>
     		 		<tbody>
     		 			@foreach($info as $r)
     		 			  <tr>
     		 			  	<td>{{ $r->id }}</td>
     		 			  	<td>{{ $r->tiempo }}</td>
     		 			  	<td>{{ $r->description }}</td>
     		 			  	<td>{{ $r->costo }}</td>
     		 			  	<td>{{ $r->tipo }}</td>
     		 			  	<td>{{ $r->jerarquia }}</td>
     		 			  	<td>
     		 			  		{{-- begin action --}}
     		 			  		 <ul class="table-controls">
									    <li>
									    	<a href="javascript:void(0);" onclick="editTarifa('{{ $r}}')" data-toggle="tooltip" data-placement="top" title="Edit">
									    	 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2" style="color:blue"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
									    </li>
									    <li>
									    {{--	@if($r->renta->count() <=0) --}}
									    	<a href="javascript:void(0);"  onclick="Confirm('{{ $r->id}}')" data-toggle="tooltip" data-placement="top" title="Delete">
									           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 table-cancel" style="color:red"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
									    	</a>
									    	{{--@endif--}}
									    </li>
									</ul>
     		 			  		{{-- end action --}}
     		 			  		
     		 			  	</td>
     		 			  </tr>
     		 			@endforeach
     		 		</tbody>
     		 	</table>
     		 	{{ $info->links()}}
     		 </div>
     	</div>
       @include('livewire.tarifas.modal') 
        <input type="hidden" id="id" value="0">
	</div>
</div>


<script type="text/javascript">
	 function Confirm(id)
    {
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

    function editTarifa(row){
    	var info=JSON.parse(row);
        
       // console.log(info.costo);
    	$('#id').val(info.id);
    	$('#costo').val(info.costo);
    	$('#description').val(info.description);
    	$('#tiempo').val(info.tiempo);
    	$('#jerarquia').val(info.jerarquia);
    	$('#tipo').val(info.tipo_id),

    	$('.modal-title').text('Editer le forfait');

    	$('#modalTarifa').modal('show');
    }

    function openModal(){

    	$('#id').val(0);
    	
    	$('.modal-title').text('Créer le forfait');
    	$('#modalTarifa').modal('show')  ;
    }

    function save(){
    	if( $('#tiempo option:selected').val()=='Choisir' ){
    		toastr.error('Choisissez une option pour le temps');
    		return;
    	}
    	if( $('#tipo option:selected').val()=='Choisir' ){
    		toastr.error('Choisissez une option pour le type');
    		return;
    	}
    	if( $.trim($('#costo').val())=='' ){
    		toastr.error('Saisissez un cout valide');
    		return;
    	}

    	var data=JSON.stringify({
    		'id':$('#id').val(),
    		'tiempo':$('#tiempo option:selected').val(),
    		'tipo':$('#tipo option:selected').val(),
    		'costo':$('#costo').val(),
    		'description':$('#description').val(),
    		'jerarquia':$('#jerarquia').val(),
    	});

    	window.livewire.emit('createFromModal',data);

    }

    document.addEventListener('DOMContentLoaded',function(){
    	window.livewire.on('msg-ok',dataMsg=>{
    		$('#modalTarifa').modal('hide');
    	});
    	window.livewire.on('msg-error',dataMsg=>{
    		$('#modalTarifa').modal('hide');
    	});
    });
</script>
