<div class="widget-content-area">
	<div class="widget-one">
		@include('common.messages')
		<div class="row">
			<div class="form-group col-lg-4 col-md-4 col-sm-12">
				<label for="">Libellé</label>
				<input type="text" wire:model.lazy="description" class="form-control" placeholder="Libellé">
			</div>
			<div class="form-group col-lg-4 col-md-4 col-sm-12">
				<label for="">Types</label>
				<select name="" id="" wire:model="tipo">
					<option value="Choisir" disabled>Choisir</option>
					 @foreach($tipos as $t)
					 <option value="{{ $t->id}}">{{ $t->description }}</option>
					@endforeach 
				</select>
			</div>
			<div class="form-group col-lg-4 col-md-4 col-sm-12">
				<label for="Estatus">Status</label>
				<select name="" id="" wire:model="estatus">
					<option value="DISPONIBLE">DISPONIBLE</option>
					<option value="OCCUPE">OCCUP&Eacute;</option>
				</select>
			</div>
			<div class="row">
				
			</div>
			<div class="col-lg-5 mt-2 text-left">
				<button type="button" class="btn btn-dark mr-1" wire:click="doAction(1)">
					<i class="mbri-left"></i>
					Annuler
				</button>
				<button type="button" class="btn btn-primary ml-2" wire:click.prevent="StoreOrUpdate()">
					 <i class="mbri-success"></i>
					Valider
				</button>
			</div>

		</div>

	</div>
</div>