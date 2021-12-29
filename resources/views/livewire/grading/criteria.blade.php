<div class="container-fluid">
    <div class="row">
        <div class="col">       
        	@include('livewire.grading.create-criteria') 	
        	@include('livewire.grading.update-criteria')
            
            <div class="card card-accent-success">	
            	<div class="card-header">List of Criteria
			        <div class="card-header-actions">
			            <a class="card-header-action btn-setting" href="#" data-toggle="modal" data-target="#addCriteriaModal">
			                <i class="c-icon cil-pen-alt c-sidebar-nav-icon"></i> Add Criteria
			            </a>
			        </div>
			    </div>		    
			    <div class="card-body">
			    	<div class="row mb-3">
			            <div class="col-7">
			                <input wire:model.debounce.300ms="search" class="form-control" type="search" placeholder="Search...">
			            </div>
			            <div class="col-2">
			                <select wire:model="orderBy" class="form-control"  id="grid-state">
			                    <option value="description">Description</option>			                    
			                    <option value="created_at">Date Created</option>
			                </select>
			            </div>
			            <div class="col-2">
			                <select wire:model="orderAsc" class="form-control" id="grid-state">
			                    <option value="1">Ascending</option>
			                    <option value="0">Descending</option>
			                </select>			                
			            </div>
			            <div class="col">
			                <select wire:model="perPage" class="form-control" id="grid-state">
			                    <option value="10">10</option>
			                    <option value="25">25</option>
			                    <option value="50">50</option>
			                    <option value="75">75</option>
			                    <option value="100">100</option>			                    
			                </select>			                
			            </div>
			        </div>
			        <div class="table-responsive">
			            <table class="table table-sm">
			                <thead>
			                <tr>		                    
			                    <th style="color: white;" nowrap>Description</th>		
			                    <th style="color: white;" nowrap>Status</th>		                    
			                    <th style="width: 110px; color: white;" nowrap>Date Created</th>			                  
			                    <th style="width: 150px; text-align: center; color: white;" nowrap>Action</th>
			                </tr>
			                </thead>
			                <tbody>
			                    @forelse($criteria as $criterium)			
			                    <?php			       
			                    	$status = "unused";             	
		                    		$color = "success";
		                    		if($criterium->status == "used") {		                    			
		                    			$color = "danger";
		                    			$status = "used";  
		                    		} 
		                    		$date = new Carbon\Carbon($criterium->created_at);
		                    		$dc = $date->toFormattedDateString();
			                    ?>                    
		                        <tr>				                        
		                            <td>{{ $criterium->description }}</td>	
		                            <td><span class="badge bg-{{ $color }}">{{ $status }}</span></td>   	                            
		                            <td>{{ $dc }}</td>                          
		                            <td>
		                                <button type="button" wire:click="edit({{ $criterium->id }})" class="btn btn-sm btn-success" data-toggle="modal" data-target="#editCriteriaModal"><i class="cil-pencil"></i>&nbsp;Edit</button>
		                                <button type="button" wire:click="deleteThisId({{ $criterium->id }})" data-toggle="modal" data-target="#deleteCriteriaModal" class="btn btn-sm btn-danger"><i class="cil-trash"></i>&nbsp;Delete</button>	                                          				                                	
		                            </td>
		                        </tr>		
		                        @empty
		                        <tr><td>No criteria yet ...</td></tr>	                    			                        
			                    @endforelse
			                </tbody>
			            </table>
			            {!! $criteria->links() !!}
			        </div>					        
			        
			        <div wire:ignore.self class="modal fade" id="deleteCriteriaModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
			            <div class="modal-dialog" role="document">
			                <div class="modal-content">
			                    <div class="modal-header">
			                        <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
			                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                            <span aria-hidden="true close-btn">×</span>
			                        </button>
			                    </div>
			                    <div class="modal-body">
			                        <p>Are you sure want to delete this criteria?</p>
			                    </div>
			                    <div class="modal-footer">
			                        <button wire:click="$emit('resetAllInputs')" type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
			                        <button type="button" wire:click.prevent="deleteNow" class="btn btn-danger" data-dismiss="modal">Yes, Delete</button>
			                    </div>
			                </div>
			            </div>
			        </div>

			    </div>
			</div>
              
        </div>
    </div>
</div>
