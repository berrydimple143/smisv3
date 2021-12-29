<div class="container-fluid">
    <div class="row">
        <div class="col">       
        	@include('livewire.registrar.create-subject-activity') 	
        	@include('livewire.registrar.update-subject-activity')

            <div class="card card-accent-success">	
            	<div class="card-header">List of activities for subject "{{ $subject->description }}" in section "{{ $section->name }}"
			        <div class="card-header-actions">
			            <a class="card-header-action btn-setting" href="#" data-toggle="modal" data-target="#addSubjectActivityModal">
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
			                    <option value="class_activity_id">Activity</option>			                    
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
			                	<th style="width: 40px; color: white;" nowrap>#</th>
			                    <th style="color: white;" nowrap>Activity</th>				                    
			                    <th style="color: white;" nowrap>Date Created</th>			                  
			                    <th style="width: 90px; text-align: center; color: white;" nowrap>Action</th>
			                </tr>
			                </thead>
			                <tbody>
			                    @forelse($activities as $activity)
			                    <?php 
			                    	$act = App\Models\ClassActivity::where('id', $activity->class_activity_id)->first();
			                    	$date = new Carbon\Carbon($activity->created_at);
		                    		$dc = $date->toFormattedDateString();			                    	
			                    ?>	                    	
		                        <tr>				                        
		                            <th>{{ (($activities->currentPage() * $activities->perPage()) - $activities->perPage()) + $loop->iteration  }}</th>
		                            <td>{{ $act->name }}</td>                     
		                            <td>{{ $dc }}</td>                          
		                            <td>		                                
		                                <button type="button" wire:click="deleteThisId({{ $activity->id }})" data-toggle="modal" data-target="#deleteSubjectActivityModal" class="btn btn-sm btn-danger"><i class="cil-trash"></i>&nbsp;Delete</button>		                                 	
		                            </td>
		                        </tr>		
		                        @empty
		                        	<tr><td colspan="4">No activity yet for this section ...</td></tr>		                    			                        
			                    @endforelse
			                </tbody>
			            </table>
			            {!! $activities->links() !!}
			        </div>					        
			        
			        <div wire:ignore.self class="modal fade" id="deleteSubjectActivityModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
			            <div class="modal-dialog" role="document">
			                <div class="modal-content">
			                    <div class="modal-header">
			                        <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
			                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                            <span aria-hidden="true close-btn">×</span>
			                        </button>
			                    </div>
			                    <div class="modal-body">
			                        <p>Are you sure want to delete this activity for this subject?</p>
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
