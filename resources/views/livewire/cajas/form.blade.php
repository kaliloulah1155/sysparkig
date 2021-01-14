<div class="widget-content-area">
	<div class="wdget-one">
		<form>
			 <h3>Créer /Modifier un mouvement</h3>
			 @include('common.messages')
			 <div class="row">
			 	 <div class="form-group col-lg-4 col-md-4 col-sm-12">
			 	 	 <label>Type</label>
			 	 	 <select wire:model="tipo">
			 	 	 	<option value="Choisir" disabled>Choisir</option>
			 	 	 	<option value="Recette">Recette</option>
			 	 	 	<option value="Frais">Frais</option>
			 	 	 	<option value="Paiement de loyer">Paiement de loyer</option>
			 	 	 </select>
			 	 </div>

			 	 <div class="form-group col-lg-4 col-md-4 col-sm-12">
			 	 	<label>Montant</label>
			 	 	<input type="number" wire:model.lazy="monto" class="form-control text-center" placeholder="Ex:100.000">
			 	 </div>
			 	 <div class="form-group col-lg-4 col-md-4 col-sm-12">
			 	 	<label>Bon</label>
			 	 	<input type="file" id="image" wire:change="$emit('fileChoosen',this)" class="form-control text-center" accept="image/x-png,image/gif,image/jpeg">
 						

			 	 </div>
			 	  <div class="form-group col-lg-12  col-sm-12 mb-8">
			 	  	 <label>Description de la recette</label>
			 	  	 <input type="text" wire:model.lazy="concepto" class="form-control" placeholder="...">
			 	  </div>
			 </div>
			 <div class="row">
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
			

		</form>
	</div>
</div>