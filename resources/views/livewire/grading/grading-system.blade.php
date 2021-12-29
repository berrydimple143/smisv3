<div class="container-fluid">
    <div class="row">
        <div class="col">       
        	@include('livewire.grading.create-grading') 	
        	@include('livewire.grading.update-grading')

            <div class="card card-accent-success">	
            	<div class="card-header">List of Grading Criteria
			        <div class="card-header-actions">
			            <a class="card-header-action btn-setting" href="#" data-toggle="modal" data-target="#addGradingModal">
			                <font color="#000" size="3"><i class="c-icon cil-pen-alt c-sidebar-nav-icon"></i> Add Grade Criteria</font>
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
			                    <option value="selected">Selected</option>			                    
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
			                	<th style="color: white;" nowrap>Teacher</th>
			                    <th style="color: white;" nowrap>Level/Course</th>
			                    <th style="color: white;" nowrap>Section</th>
			                    <th style="color: white;" nowrap>Subject</th>			                    
			                    <th style="color: white;" nowrap>Status</th>
			                    <th style="color: white; text-align: center;" nowrap>No. of Criteria</th>					                    	                  
			                    <th style="width: 270px; text-align: center; color: white;" nowrap>Action</th>
			                </tr>
			                </thead>
			                <tbody>
			                    @forelse($gradings as $grading)	
			                    <?php		 
			                    	$teacher = $course = $section = $subject = "not set";                   	
			                    	$status = "unused";
		                    		$color = "success";
		                    		if($grading->selected == "yes") {
		                    			$status = "used";
		                    			$color = "danger";
		                    		}
		                    		if(!empty($grading->user_id)) {
		                    			$tchr = App\Models\User::where('id', $grading->user_id)->first();
		                    			$teacher = $tchr->first_name." ".$tchr->last_name;
		                    		}
		                    		if(!empty($grading->course_id)) {
		                    			$crs = App\Models\Course::where('id', $grading->course_id)->first();		
		                    			$course = $crs->name;                    			
		                    		}
		                    		if(!empty($grading->section_id)) {
		                    			$sect = App\Models\Section::where('id', $grading->section_id)->first();		
		                    			$section = $sect->name;               			
		                    		}
		                    		if(!empty($grading->subject_id)) {
		                    			$subj = App\Models\Subject::where('id', $grading->subject_id)->first();	
		                    			$subject = $subj->description;	                    			
		                    		}
			                    ?>		                    
		                        <tr>				                        
		                            <td>{{ $teacher }}</td>		      
		                            <td>{{ $course }}</td>		     
		                            <td>{{ $section }}</td>		 
		                            <td>{{ $subject }}</td>	                
		                            <td><span class="badge bg-{{ $color }}">{{ $status }}</span></td>   
		                            <td style="text-align: center;">{{ $grading->gradecriterias->count() }}</td>   		                                              
		                            <td>
		                                <button type="button" wire:click="edit({{ $grading->id }})" class="btn btn-sm btn-success" data-toggle="modal" data-target="#editGradingModal"><i class="cil-pencil"></i>&nbsp;Edit</button>
		                                <button type="button" wire:click="deleteThisId({{ $grading->id }})" data-toggle="modal" data-target="#deleteGradingModal" class="btn btn-sm btn-danger"><i class="cil-trash"></i>&nbsp;Delete</button>
		                                <button type="button" wire:click="view({{ $grading->id }})" class="btn btn-sm btn-info"><i class="cil-search"></i>&nbsp;View Criteria</button>		                                
		                            </td>
		                        </tr>		
		                        @empty
		                        <tr><td colspan="7">No grading system yet ...</td></tr>	                    			                        
			                    @endforelse
			                </tbody>
			            </table>
			            {!! $gradings->links() !!}
			        </div>					        
			        
			        <div wire:ignore.self class="modal fade" id="deleteGradingModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
