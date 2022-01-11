<div class="container-fluid">
    <div class="row">
        <div class="col">       
        	@include('livewire.faculty.create-subject-criteria') 	
        	@include('livewire.faculty.update-subject-criteria')
            
            <div class="card card-accent-success">	
			    <div class="card-header"><h3>List of Subject Criteria</h3> 
            	    <div class="card-header-actions">
			            <button type="button" class="btn btn-sm btn-{{ $addBtnStyle }}" data-toggle="modal" data-target="#addSubjectCriteriaModal" {{ $addBtnClass }}><i class="cil-pencil"></i>&nbsp;Add Subject Criteria</button>
			        </div>
			        <p>@if((!empty($course_id)) and (!empty($subject_id))) {{ $course->name }} {{ $subject->description }} @endif</p>
            	</div>	
			    <div class="card-body">
			    	<div class="row mb-3">	
			    	    <div class="col-3">
			                <select wire:model="course_id" class="form-control"  id="grid-state">
			                    <option value=''>Select level here ...</option>
			                    @if(!empty($listOfGradeLevel))
                                    @foreach($listOfGradeLevel as $level)                                    
                                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                                    @endforeach
                                @endif
			                </select>			                
			            </div>
			            <div class="col-3">
			                <select wire:model="subject_id" class="form-control"  id="grid-state">
			                    <option value=''>Select subject here ...</option>
			                    @if(!empty($listOfSubjects))
                                    @foreach($listOfSubjects as $subject)                                    
                                        <option value="{{ $subject->id }}">{{ $subject->description }}</option>
                                    @endforeach
                                @endif
			                </select>			                
			            </div>
			            <div class="col-2">&nbsp;</div>
			            <div class="col-4">
			                <input wire:model.debounce.300ms="search" class="form-control" type="search" placeholder="Search...">
			            </div>
			        </div>
			        <div class="table-responsive">
			            <table class="table table-sm">
			                <thead>
			                <tr>		                    
			                    <th style="color: white;" nowrap>Description</th>
			                    <th style="color: white;" nowrap>Criteria</th>	
			                    <th style="color: white;" nowrap>Grade Level</th>			  
			                    <th style="color: white;" nowrap>Subject</th>
			                    <th style="width: 150px; text-align: center; color: white;" nowrap>Action</th>
			                </tr>
			                </thead>
			                <tbody>
			                    @forelse($criteria as $criterium)
			                    <tr>
		                            <td>{{ $criterium->description }}</td>
		                            <td>{{ App\Http\Controllers\HelperController::getFieldValue('Criteria', 'description', $criterium->criteria_id) }}</td>	
		                            <td>{{ App\Http\Controllers\HelperController::getFieldValue('Course', 'name', $criterium->course_id) }}</td>	                 
		                            <td>{{ App\Http\Controllers\HelperController::getFieldValue('Subject', 'description', $criterium->subject_id) }}</td>                          
		                            <td>
		                                <button type="button" wire:click="edit({{ $criterium->id }})" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editSubjectCriteriaModal"><i class="cil-pencil"></i>&nbsp;Edit</button>
		                                <button type="button" wire:click="deleteThisId({{ $criterium->id }})" data-toggle="modal" data-target="#deleteSubjectCriteriaModal" class="btn btn-sm btn-danger"><i class="cil-trash"></i>&nbsp;Delete</button>		                                          	
		                            </td>
		                        </tr>		
		                        @empty
		                            <tr><td colspan="5">No subject criteria yet ...</td></tr>
			                    @endforelse
			                </tbody>
			            </table>
			            {!! $criteria->links() !!}
			        </div>					        
			        
			        <div wire:ignore.self class="modal fade" id="deleteSubjectCriteriaModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
			            <div class="modal-dialog" role="document">
			                <div class="modal-content">
			                    <div class="modal-header">
			                        <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
			                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                            <span aria-hidden="true close-btn">×</span>
			                        </button>
			                    </div>
			                    <div class="modal-body">
			                        <p>Are you sure want to delete this subject criteria?</p>
			                    </div>
			                    <div class="modal-footer">
			                        <button wire:click="$emit('resetInputs')" type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
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
