<div class="widget-content-area">
	<div class="widget-on">
		@include('common.messages')
		 <div class="row">
		 	 <div class="form-group col-lg-4 col-md-4 col-sm-12">
		 	 	 <label>Nom et Prénoms</label>
		 	 	 <input type="text" wire:model.lazy="name" class="form-control" placeholder="Nom et Prénoms">
		 	 </div>
		 	 <div class="form-group col-lg-4 col-md-4 col-sm-12">
		 	 	 <label>Téléphone</label>
		 	 	 <input type="text" wire:model.lazy="telefono" class="form-control" placeholder="Téléphone" maxlength="10">
		 	 </div>
		 	  <div class="form-group col-lg-4 col-md-4 col-sm-12">
		 	 	 <label>Mobile</label>
		 	 	 <input type="text" wire:model.lazy="movil" class="form-control" placeholder="Mobile" maxlength="10">
		 	 </div>
		 	  <div class="form-group col-lg-4 col-md-4 col-sm-12">
		 	 	 <label>E-mail</label>
		 	 	 <input type="text" wire:model.lazy="email" class="form-control" placeholder="ibson@mail.com">
		 	 </div>
		 	 <div class="form-group col-lg-4 col-md-4 col-sm-12">
				<label for="Type">Type</label>
				<select wire:model="tipo" class="form-control text-center">
					<option value="Choisir">Choisir</option>
					<option value="Admin">Admin</option>
					<option value="Employe">Employ&eacute;</option>
					<option value="Client">Client</option>
				</select>
			</div>
			 <div class="form-group col-lg-4 col-md-4 col-sm-12">
		 	 	 <label>Mot de passe</label>
		 	 	 <input type="password" wire:model.lazy="password" class="form-control" placeholder="azerty">
		 	 </div>
		 	 <div class="form-group col-lg-4 col-md-4 col-sm-12 text-left">
		 	 	 <label>Direction</label>
		 	 	 <input type="text" wire:model.lazy="direccion" class="form-control" placeholder="alix...">
		 	 </div>
		 </div>

		  <div class="row offset-lg-5">
				<div class="col-lg-5 mt-2 text-left">
				<button type="button" class="btn btn-dark mr-1" wire:click="doAction(1)">
					<i class="mbri-left"></i>
					Annuler
				</button>
				<button wire:click.prevent="StoreOrUpdate()" type="button" class="btn btn-primary ml-2" >
					 <i class="mbri-success"></i>
					Valider
				</button>
			</div>
			</div>


	</div>
</div>