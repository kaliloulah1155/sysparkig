<div class="widget-content-area">
     <div class="widget-one">
     	<div class="row">
            @include('common.messages')
            
            <div class="col-12">
            	 <h4 class="text-center">Données de la compagnie</h4>
            </div>
          
            <div class="form-group col-sm-12 col-md-4">
            	<label>Nom</label>
            	<input type="text" wire:model.lazy="nombre" class="form-control text-left">
            </div>
            <div class="form-group col-sm-12 col-md-4">
            	<label>Telephone</label>
            	<input type="text" wire:model.lazy="telefono" maxlength="12" class="form-control text-left">
            </div>
             <div class="form-group col-sm-12 col-md-4">
            	<label>Email</label>
            	<input type="text" wire:model.lazy="email" maxlength="65" class="form-control text-left">
            </div>
            <div class="form-group col-sm-12 col-md-4">
            	<label>Logo</label>
            	<input type="file" id="image" wire:change="$emit('fileChoosen',this)" class="form-control text-center" accept="image/x-png,image/gif,image/jpeg">
            </div>
             <div class="form-group col-sm-12 col-md-4">
            	<label>Direction</label>
            	<input type="text" wire:model.lazy="direccion" class="form-control text-left">
            </div>
            <div class="col-sm-12 offset-5">
				<button type="button" class="btn btn-primary ml-2" wire:click.prevent="Guardar">
					 <i class="mbri-success"></i>
					Valider
				</button>
			</div>
		</div>
	</div>
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
</script>
