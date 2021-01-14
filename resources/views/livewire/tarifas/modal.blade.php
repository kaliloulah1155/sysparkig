<!-- Modal -->
<div class="modal fade" id="modalTarifa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 
                </button>
            </div>
            <input type="hidden" id="id">

            <div class="modal-body">
                <div class="widget-content-area">
					<div class="widget-one">
						<form>
							@include('common.messages')
							<div class="row">
								<div class="form-group col-lg-4 col-md-4 col-sm-12">
									<label>Temps</label>
									<select id="tiempo" class="form-control text-center">
										<option value="Choisir">Choisir</option>
										<option value="Fraction">Fraction</option>
										<option value="Heure">Heure</option>
										<option value="Jour">Jour</option>
										<option value="Semaine">Semaine</option>
										<option value="Quinzaine">Quinzaine</option>
										<option value="Mois">Mois</option>
									</select>
								</div>
								<div class="form-group col-lg-4 col-md-4 col-sm-12">
									<label>Type</label>
									<select id="tipo" class="form-control text-center">
										<option value="Choisir">Choisir</option>
										@foreach ($tipos as $t)
											<option value="{{ $t->id }}">{{ $t->description }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group col-lg-4 col-md-4 col-sm-12">
									<label>Cout</label>
									<input type="number" id="costo" class="form-control text-center" value="0" placeholder="1.00">
								</div>
								<div class="form-group col-lg-8 mb-8 col-sm-12">
									<label>Description</label>
									<input type="text" id="description" class="form-control text-center" placeholder="...">
								</div>
								 
								<div class="form-group col-lg-4 col-md-4 col-sm-12">
									<label>Hierarchie</label>
									<input type="text" id="jerarquia" class="form-control text-center" disabled value="{{ $jerarquia }}">
								</div>
								 
							</div>
						</form>
					</div>
				</div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-dark" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Annuler</button>
                <button type="button" onclick="save()" class="btn btn-primary">Sauvegarder</button>
            </div>
        </div>
    </div>
</div>