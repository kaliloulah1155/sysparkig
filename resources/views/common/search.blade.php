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
		 <button type="button" wire:click="doAction(2)" class="btn btn-btn-dark" style="background:black">
		 	  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file" style="background:white"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
		 </button>
	</div>
	
</div>