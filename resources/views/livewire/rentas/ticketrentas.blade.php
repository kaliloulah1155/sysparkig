<section id="salidas">
	<div class="row layout-top-spacing">
		<div class="col-xl-12 col-lg-12 col-md-12 layout-spacing" x-data="{ isOpen: true }" @click.away="isOpen=false">

			<div class="widget-one">
				{{-- Titulo y regresar --}}
				<div class="row">
					@include('common.messages')
					<div class="col-2">
						 <button class="btn btn-dark" wire:click="$set('section',1)">
						 	<i class="la la-chevron-left"></i>
						 </button>
					</div>
					<div class="col-8">
						<h5 class="text-center"><b>Billet de retrait</b></h5>
					</div>
					<div class="col-2 text-right">
						<label id="tc"></label>
					</div>
				</div>
				{{-- Buscador--}}
				<div class="row mt-3" x-data="{ isOpen: true }" @click.away="isOpen=false">
					 <div class="col-md-4 ml-auto">
					 	<div class="input-group mb-2 mr-sm-2">
					 		 <div class="input-group-prepend">
					 		 	  <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-search"></i></div>
                                </div>
					 		 	 <input type="text" class="form-control" placeholder="Recherche" wire:model="buscarCliente" 
	                                @focus="isOpen = true" 
	                                @keydown.escape.tab="isOpen = false" 
	                                @keydown.shift.tab="isOpen = false">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i wire:click.prevent="limpiarCliente()" class="la la-trash la-lg"></i></div>
                                </div>
					 		 </div>
					 	</div>
					 	<ul class="list-group" x-show.transition.opacity="isOpen" >
					 	    @if($buscarCliente !='')
					 	     @foreach($clientes as $r)
					 	      <li wire:click="mostrarCliente('{{ $r}}')" class="list-group-item-action" style="cursor: pointer;">
					 	      	<b>{{$r->name}}</b> &nbsp;<h7 class="text-info">Plaque</h7>:{{$r->placa}} &nbsp;<h7 class="text-success">Marque</h7>:{{$r->marca}}  &nbsp; <h7 class="text-success">Couleur</h7>:{{$r->color}}
					 	      </li>
					 	     @endforeach
					 	    @endif
					 	</ul>
					 </div>
				</div>
				 <!-- div datos cliente-->
                    <div class="row">
                        <h5 class="col-sm-12">Données du client</h5>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                            <h7 class="text-info">Nom*</h7>
                            <div class="input-group mb-2-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-user la-lg"></i></div>
                                </div>
                                <input type="text" class="form-control" wire:model.lazy="name" maxlength="30" placeholder="Exple: Pedro">
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-2 col-sm-12">
                            <h7 class="text-info">Téléphone fixe</h7>
                            <div class="input-group mb-2-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-phone la-lg"></i></div>
                                </div>
                                <input type="text" class="form-control" wire:model.lazy="telefono" maxlength="11" placeholder="Exple: 351 115 9550">
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-2 col-sm-12">
                            <h7 class="text-info">Cellulaire</h7>
                            <div class="input-group mb-2-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-mobile la-lg"></i></div>
                                </div>
                                <input type="text" class="form-control" wire:model.lazy="movil" maxlength="11" placeholder="Exple: 351 115 95550">
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                            <h7 class="text-info">Email</h7>
                            <div class="input-group mb-2-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-envelope la-lg"></i></div>
                                </div>
                                <input type="text" class="form-control" wire:model.lazy="email" maxlength="100" placeholder="Exple: pedroincora@gmail.com">
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <h7 class="text-info">Direction</h7>
                            <div class="input-group mb-2-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-home la-lg"></i></div>
                                </div>
                                <input type="text" class="form-control" wire:model.lazy="direccion" maxlength="100" placeholder="...">
                            </div>
                        </div>
                    </div>
                    <!-- datos del vehículo -->
                    <div class="row">
                        <h5 class="col-sm-12">Données du Vehicule</h5>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                            <h7 class="text-info">Plaque*</h7>
                            <div class="input-group mb-2-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-car la-lg"></i></div>
                                </div>
                                <input type="text" class="form-control" wire:model.lazy="placa" maxlength="30" placeholder="exple: CVW-796">
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                            <h7 class="text-info">Description</h7>
                            <div class="input-group mb-2-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-car la-lg"></i></div>
                                </div>
                                <input type="text" class="form-control" wire:model.lazy="nota" maxlength="30" placeholder="Exple: Sirion">
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                            <h7 class="text-info">Modèle</h7>
                            <div class="input-group mb-2-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-calendar la-lg"></i></div>
                                </div>
                                <input type="text" class="form-control" wire:model.lazy="modelo" maxlength="8" placeholder="Exple: 2020">
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                            <h7 class="text-info">Marque</h7>
                            <div class="input-group mb-2-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-copyright la-lg"></i></div>
                                </div>
                                <input type="text" class="form-control" wire:model.lazy="marca" maxlength="30" placeholder="Exple: Daihatsu">
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                            <h7 class="text-info">Couleur</h7>
                            <div class="input-group mb-2-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-tint la-lg"></i></div>
                                </div>
                                <input type="text" class="form-control" wire:model.lazy="color" maxlength="30" placeholder="Exple: Champaña">
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                           
                             <h7 class="text-info">Types</h7>
                            <select  wire:model="tipo_id"  class="form-control">
                                <option value="Choisir" disabled>Choisir</option>
                                 @foreach($tipo as $t)
                                 <option value="{{ $t->id}}">{{ $t->description }}</option>
                                @endforeach 
                            </select>
                        </div>
                    </div>

                <!-- div tiempo, fechas y cálculo del total a cobrar -->
                <hr>
                <div class="row  text-info"> 
                    <div class="col-md-3 col-lg-3 col-sm-12">
                        Temps
                        <select wire:model="tiempo" wire:change="getSalida()" class="form-control text-center">
                            <option value="0">Choisir</option>
                            @for($i = 1; $i <= 12; $i++)
                            @if ($i == 1)
                            <option value="{{ $i }}">{{ $i }} MOIS</option>
                            @else
                            <option value="{{ $i }}">{{ $i }} MOIS</option>    
                            @endif
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2 col-lg-2 col-sm-12">
                        <div class="form-group mb=0">Date d'entrée
                            <input type="text" wire:model="fecha_ini" class="form-control" value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-2 col-lg-2 col-sm-12">
                        <div class="form-group mb=0">Date de fin 
                            <input type="text" wire:model="fecha_fin" class="form-control" value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-2 col-lg-2 col-sm-12">
                        <div class="form-group mb=0">Total Estimé
                            <input type="text" class="form-control" value="${{number_format($total) }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-2 col-lg-2 col-sm-12">
                        <div class="form-group mb=0">Total Manuel
                            <input type="text" wire:model="total" class="form-control" value="${{number_format($total,2) }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-12">
                        @if ($tiempo > 0)
                            <button wire:click.prevent="RegistrarTicketRenta()" class="btn btn-success mt-4">Enregistrer</button>   
                        @endif
                    </div>
                </div>
			</div>
		</div>
	</div>
</section>