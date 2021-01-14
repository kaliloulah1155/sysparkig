<section id="salidas">
	<div class="row layout-top-spacing">
		<div class="col-xs-12 col-lg-12 col-sm-12 col-md-12 layout-spacing">
			<div class="widget-content-area br-4">
				<div class="widget-one">
					
				  {{-- row header--}}
				   <div class="row">
				   	   <div class="col-2">
				   	   	 <button class="btn btn-dark" wire:click="$set('section',1)">
				   	   	 	 <i class="la la-chevron-left"></i>
				   	   	 </button>
				   	   </div>
					   <div class="col-8">
					   	  <h5 class="text-center"><b>ENREGISTRER LES SORTIES</b></h5>
					   </div>
					   <div class="col-2 text-right">
					   	   <label id="tc"></label>
					   </div>
					</div>
					{{-- row header--}}
					 <div class="row">
 						<div class="col-12">
 							@if(count($errors)>0)
 								@foreach($errors->all() as $error)
 								   <small class="text-danger">{{$error}}</small>
 								@endforeach
 							@endif
 							<div class="input-group mb-4">
 								<div class="input-group-prepend">
 									<span class="input-group-text"><i class="la la-barcode"></i></span>
 									<input type="text" id="code" wire:keydown.enter="BuscarTicket()" wire:model="barcode" class="form-control" maxlength="9" placeholder="entrer le code barre" autofocus>
 									<span wire:click="BuscarTicket()" class="input-group-text" style="cursor: pointer;"><i class="la la-print la-sm"></i></span>
 								</div>
 							</div>
 						</div>
					 </div>
					 {{-- row info pago--}}
					 <div class="row">
					 	<div class="col-lg-8 col-md-8 col-sm-12">
					 		<div class="col-sm-12">
					 			<h5><b>Folio</b>: {{ $obj->id }}</h5>
					 			<input type="hidden" id="ticketid" value="{{ $obj->id }}">
					 		</div>
					 		<div class="col-sm-12">
					 			<h5><b>Statuts</b>: {{ $obj->estatus }}</h5>
					 		</div>
					 		<div class="col-sm-12">
					 		  <h5><b>Forfait</b>: {{ number_format($fraction ,2) }}</h5> 
					 		</div>
					 		<div class="col-sm-12">
					 			<h5><b>Accès</b>: {{ \Carbon\Carbon::parse($obj->acceso)->format('d/m/Y h:m:s') }}</h5>
					 		</div>
					 		<div class="col-sm-12">
					 			<h5><b>Code barre</b>: {{ $obj->barcode }}</h5>
					 		</div>
					 	</div>
					 	<div class="col-lg-4 col-md-4 col-sm-12">
					 		<blockquote class="blockquote text-center">
					 			<h5>Paiement actuel</h5>
					 			<h6>Temps écoulé : {{ $obj->tiempo }}</h6>
					 			<h6>Total : {{ number_format($obj->total,2) }}</h6>
					 		</blockquote>
					 	</div>
					 </div>
			</div>
		</div>
	</div>	
</section>