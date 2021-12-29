<div class="container-fluid">
    <div class="row">
        <div class="col">
            
            <div class="card card-accent-success">	
            	<div class="card-header">List of grades for "{{ $subject->description }}" subject of {{ $student->first_name." ".$student->last_name }} in section "{{ $section->name }}" for {{ $activity->name }}
            	    <div class="card-header-actions">
			            <a class="card-header-action btn-setting" href="{{ config('app.url') }}registrar/activity-grades/{{ $student->id }}/{{ $ssid }}">
			                << Back to subjects
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
			                    <option value="id">ID</option>
			                    <option value="section_id">Section</option>
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
			                    <th style="color: white; text-align: center;" nowrap>Item</th>
			                    <th style="color: white; text-align: center;" nowrap>Score</th>
			                    <th style="color: white; text-align: center;" nowrap>Grade</th>
			                    <th style="width: 100px; text-align: center; color: white;" nowrap>Action</th>
			                </tr>
			                </thead>
			                <tbody>
			                    @forelse($grades as $grade)
			                    <?php
			                        $item = $grade->item;
			                        $score = $grade->score;
			                    	$initialGrade = 0;
			                    	if($item) {
			                    	    $initialGrade = round(((($score/$item) * 50) + 50), 2); 
			                    	}
			                    ?>                 	
		                        <tr>
		                            <td style="text-align: center;">{{ $item }}</td>     
		                            <td style="text-align: center;">{{ $score }}</td>      
		                            <td style="text-align: center;">{{ $initialGrade }}</td>   
		                            <td>		                                
		                                <button type="button" wire:click="deleteThisId({{ $grade->id }})" data-toggle="modal" data-target="#deleteGradeModal" class="btn btn-sm btn-danger"><i class="cil-trash"></i>&nbsp;Delete</button>
		                            </td>
		                        </tr>		
		                        @empty
		                        	<tr><td colspan="4">No grades for this activity yet ...</td></tr>		                    			                        
			                    @endforelse
			                </tbody>
			            </table>
			            {!! $grades->links() !!}
			        </div>					        
                    
                    <div wire:ignore.self class="modal fade" id="deleteGradeModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
			            <div class="modal-dialog" role="document">
			                <div class="modal-content">
			                    <div class="modal-header">
			                        <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
			                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                            <span aria-hidden="true close-btn">×</span>
			                        </button>
			                    </div>
			                    <div class="modal-body">
			                        <p>Are you sure want to delete this grade?</p>
			                    </div>
			                    <div class="modal-footer">
			                        <button wire:click="$emit('resetAllInputs')" type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
			                        <button type="button" wire:click.prevent="deleteNow" class="btn btn-danger" data-dismiss="modal">Yes, delete it</button>
			                    </div>
			                </div>
			            </div>
			        </div>
                    
			    </div>
			</div>
              
        </div>
    </div>
</div>
