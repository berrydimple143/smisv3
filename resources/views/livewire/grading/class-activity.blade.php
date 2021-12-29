<div class="container-fluid">
    <div class="row">
        <div class="col">       
        	@include('livewire.grading.create-activity') 	
        	@include('livewire.grading.update-activity')
            
            <div class="card card-accent-success">	
            	<div class="card-header">List of Class Activities
			        <div class="card-header-actions">
			            <a class="card-header-action btn-setting" href="#" data-toggle="modal" data-target="#addActivityModal">
			                <i class="c-icon cil-pen-alt c-sidebar-nav-icon"></i> Add Activity
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
			                    <option value="name">Name</option>
			                    <option value="criteria_id">Criteria</option>			                    
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
			                    <th style="color: white;" nowrap>Name</th>
			                    <th style="color: white;" nowrap>Criteria</th>	
			                    <th style="color: white;" nowrap>Status</th>	
			                    <th style="color: white;" nowrap>Date Created</th>			                  
			                    <th style="width: 150px; text-align: center; color: white;" nowrap>Action</th>
			                </tr>
			                </thead>
			                <tbody>
			                    @foreach($activities as $activity)		
			                    <?php
			                    	$crt = App\Models\Criteria::where('id', $activity->criteria_id)->first();			                
		                    		$date = new Carbon\Carbon($activity->created_at);
		                    		$dc = $date->toFormattedDateString();		     
		                    		$status = "unused";
		                    		$color = "success";
		                    		if($activity->used == "yes") {
		                    			$status = "used";
		                    			$color = "danger";
		                    		}       
			                    ?>	                               	
		                        <tr>
		                            <td>{{ $activity->name }}</td>
		                            <td>{{ $crt->description }}</td>	
		                            <td><span class="badge bg-{{ $color }}">{{ $status }}</span></td>	                            
		                            <td>{{ $dc }}</td>                          
		                            <td>
		                                <button type="button" wire:click="edit({{ $activity->id }})" class="btn btn-sm btn-success" data-toggle="modal" data-target="#editActivityModal"><i class="cil-pencil"></i>&nbsp;Edit</button>
		                                <button type="button" wire:click="deleteThisId({{ $activity->id }})" data-toggle="modal" data-target="#deleteActivityModal" class="btn btn-sm btn-danger"><i class="cil-trash"></i>&nbsp;Delete</button>		                                          	
		                            </td>
		                        </tr>				                    			                        
			                    @endforeach
			                </tbody>
			            </table>
			            {!! $activities->links() !!}
			        </div>					        
			        
			        <div wire:ignore.self class="modal fade" id="deleteActivityModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
			            <div class="modal-dialog" role="document">
			                <div class="modal-content">
			                    <div class="modal-header">
			                        <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
			                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                            <span aria-hidden="true close-btn">×</span>
			                        </button>
			                    </div>
			                    <div class="modal-body">
			                        <p>Are you sure want to delete this section?</p>
			                    </div>
			                    <div class="modal-footer">
			                        <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
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
