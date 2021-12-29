<div class="container-fluid">
    <div class="row">
        <div class="col">       	
        	@include('livewire.registrar.add-student')
        	@include('livewire.registrar.update-student')
            <div class="card card-accent-success">	
            	<div class="card-header"><h3>Manage Students</h3> 
            	    <div class="card-header-actions">
			            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addStudentModal" {{ $addBtnClass }}><i class="cil-pencil"></i>&nbsp;Add Student</button>
			        </div>
			        <p>@if((!empty($course_id)) and (!empty($section_id))) {{ $course->name }} {{ $section->name }} @endif</p>
            	</div>		    
			    <div class="card-body">
			    	<div class="row mb-3">	
			    	    <div class="col-3">
			                <select wire:model="course_id" class="form-control"  id="grid-state">
			                    <option value=''>Select level here ...</option>
			                    @if(!empty($listOfLevels))
                                    @foreach($listOfLevels as $level)                                    
                                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                                    @endforeach
                                @endif
			                </select>			                
			            </div>
			            <div class="col-3">
			                <select wire:model="section_id" class="form-control"  id="grid-state">
			                    <option value=''>Select section here ...</option>
			                    @if(!empty($listOfSections))
                                    @foreach($listOfSections as $section)                                    
                                        <option value="{{ $section->id }}">{{ $section->name }}</option>
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
			                    <th style="color: white;" nowrap>Last Name</th>
			                    <th style="color: white;" nowrap>First Name</th>
			                    <th style="color: white;" nowrap>Student Number</th>
			                    <th style="color: white;" nowrap>Level/Course</th>
			                    <th style="color: white;" nowrap>Section</th>            				                    		                    			                    			                  
			                    <th style="width: 150px; text-align: center; color: white;" nowrap>Action</th>
			                </tr>
			                </thead>
			                <tbody>
			                    @forelse($students as $student)		
			                    <?php
			                    	$sect = $level = "not set";			
			                    	if(!empty($student->course_id) or $student->course_id != null or $student->course_id != "") {
				                    	$lvl = App\Models\Course::where('id', $student->course_id)->first(); 			                    	
				                    	$level = $lvl->name;                    			                 
			                    	}   	
			                    	if(!empty($student->section_id) or $student->section_id != null or $student->section_id != "") {
			                    		$sc = App\Models\Section::where('id', $student->section_id)->first();    
			                    		$sect = $sc->name;   			                    		
			                    	}	
			                    ?>		                                      
		                        <tr>				                        
		                            <td>{{ $student->last_name  }}</td>
		                            <td>{{ $student->first_name }}</td> 
		                            <td>{{ $student->student_number }}</td> 
		                            <td>{{ $level }}</td> 
		                            <td>{{ $sect }}</td>  	                                     
		                            <td>
		                            	<button type="button" wire:click="edit({{ $student->id }})" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editStudentModal"><i class="cil-pencil"></i>&nbsp;Edit</button>
		                                <button type="button" wire:click="deleteThisId({{ $student->id }})" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteStudentModal"><i class="cil-pencil"></i>&nbsp;Delete</button>		                                	                                          				                                	
		                            </td>
		                        </tr>		
		                        @empty
		                        	<tr><td colspan="6">No students yet ...</td></tr>	                    			                        
			                    @endforelse
			                </tbody>
			            </table>
			            {!! $students->links() !!}
			        </div>	
                    <div wire:ignore.self class="modal fade" id="deleteStudentModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
			            <div class="modal-dialog" role="document">
			                <div class="modal-content">
			                    <div class="modal-header">
			                        <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
			                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                            <span aria-hidden="true close-btn">×</span>
			                        </button>
			                    </div>
			                    <div class="modal-body">
			                        <p>Are you sure want to delete this student?</p>
			                    </div>
			                    <div class="modal-footer">
			                        <button wire:click="$emit('resetInputs')" type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
			                        <button type="button" wire:click.prevent="deleteNow" class="btn btn-danger" data-dismiss="modal">Yes, Delete it</button>
			                    </div>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>
              
        </div>
    </div>
</div>
