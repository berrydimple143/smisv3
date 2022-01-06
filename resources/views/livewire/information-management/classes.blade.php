<div class="container-fluid">
    <div class="row">
        <div class="col">
            
            <div class="card card-accent-success">	
            	<div class="card-header"><font size="5">Manage Classes</font><div class="card-header-actions"><input wire:model.debounce.300ms="search" class="form-control" style="width: 300px;" type="search" placeholder="Search..."></div></div>		    
			    <div class="card-body">
			        <form>
    			        <div class="row mb-3">
    			            <div class="col-3">
    			                School Year:
    			                <select wire:model.lazy="school_year_id" name="school-year" class="form-control @if($errors->has('school_year_id')) is-invalid @endif" required>
                                    @foreach($listOfSchoolYear as $sy)
    			                        <option value="{{ $sy->id }}">{{ $sy->description }}</option>
    			                    @endforeach
                                </select>
                                @error('school_year_id') <span class="invalid-feedback">{{ $message }}</span>@enderror
    			            </div>
    			            <div class="col-3">
    			                Semester:
    			                <select wire:model.lazy="semester_id" name="semester" class="form-control @if($errors->has('semester_id')) is-invalid @endif" required>
                                    @foreach($listOfSemester as $sem)
    			                        <option value="{{ $sem->id }}">{{ $sem->description }}</option>
    			                    @endforeach
                                </select>
                                @error('semester_id') <span class="invalid-feedback">{{ $message }}</span>@enderror
    			            </div>
    			            <div class="col-3">&nbsp;</div>
    			            <div class="col-3">
    			                <button wire:click.prevent="store" wire:loading.attr="disabled" type="button" class="btn btn-success pull-right"><div wire:loading wire:target="store"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div><i class="cil-pencil"></i>&nbsp;Add</button>
    			            </div>
    			        </div>
    			        <div class="row mb-3">
    			            <div class="col-3">
    			                Grade Level:
    			                <select wire:model.lazy="course_id" name="grade" class="form-control @if($errors->has('course_id')) is-invalid @endif" required>
    			                    <option value="">Select grade level here</option>
                                    @foreach($listOfGradeLevel as $grlv)
    			                        <option value="{{ $grlv->id }}">{{ $grlv->name }}</option>
    			                    @endforeach
                                </select>
                                @error('course_id') <span class="invalid-feedback">{{ $message }}</span>@enderror
    			            </div>
    			            <div class="col-3">
    			                Section:
    			                <select wire:model.lazy="section_id" name="section" class="form-control @if($errors->has('section_id')) is-invalid @endif" required>
    			                    <option value="">Select section here</option>
    			                    @foreach($listOfSections as $section)
    			                        <option value="{{ $section->id }}">{{ $section->name }}</option>
    			                    @endforeach
                                </select>
                                @error('section_id') <span class="invalid-feedback">{{ $message }}</span>@enderror
    			            </div>
    			        </div>
    			        <div class="row mb-3">
    			            <div class="col-3">
    			                Teacher:
    			                <select wire:model.lazy="teacher_id" name="teacher" class="form-control @if($errors->has('teacher_id')) is-invalid @endif" required>
    			                    <option value="">Select teacher here</option>
    			                    @foreach($listOfTeachers as $teacher)
    			                        <option value="{{ $teacher->id }}">{{ $teacher->first_name." ".$teacher->last_name }}</option>
    			                    @endforeach
                                </select>
                                @error('teacher_id') <span class="invalid-feedback">{{ $message }}</span>@enderror
    			            </div>
    			            <div class="col-3">
    			                Subject Code:
    			                <select wire:model.lazy="subject_id" name="subject-code" class="form-control @if($errors->has('subject_id')) is-invalid @endif" required>
    			                    <option value="">Select subject code here</option>
    			                    @foreach($listOfSubjects as $subject)
    			                        <option value="{{ $subject->id }}">{{ $subject->code }}</option>
    			                    @endforeach
                                </select>
                                @error('subject_id') <span class="invalid-feedback">{{ $message }}</span>@enderror
    			            </div>
    			            <div class="col-3">
    			                Subject Name:
    			                <select wire:model.lazy="subject_id" name="subject" class="form-control @if($errors->has('subject_id')) is-invalid @endif" required>
    			                    <option value="">Select subject here</option>
    			                    @foreach($listOfSubjects as $subject)
    			                        <option value="{{ $subject->id }}">{{ $subject->description }}</option>
    			                    @endforeach
                                </select>
                                @error('subject_id') <span class="invalid-feedback">{{ $message }}</span>@enderror
    			            </div>
    			        </div>
			        </form>
			        <div class="table-responsive">
			            <table class="table table-sm">
			                <thead>
    			                <tr>	
    			                	<th style="color: white;" nowrap>Grade Level</th>			                    
    			                    <th style="color: white;" nowrap>Section</th>				                    		                    			                    
    			                    <th style="color: white;" nowrap>Teacher</th>
    			                    <th style="color: white;" nowrap>Subject Code</th>
    			                    <th style="color: white;" nowrap>Subject</th>
    			                    <th style="text-align: center; width: 90px; color: white;" nowrap>Action</th>
    			                </tr>
			                </thead>
			                <tbody>
			                    @forelse($classes as $class)		
		                        <tr>    
		                        	<td>{{ App\Http\Controllers\HelperController::getFieldValue('Course', 'name', $class->course_id) }}</td>                        
		                            <td>{{ App\Http\Controllers\HelperController::getFieldValue('Section', 'name', $class->section_id) }}</td>    	                            
		                            <td>{{ App\Http\Controllers\HelperController::getFieldValue('User', 'name', $class->teacher_id) }}</td> 
		                            <td>{{ App\Http\Controllers\HelperController::getFieldValue('Subject', 'code', $class->subject_id) }}</td>                           
		                            <td>{{ App\Http\Controllers\HelperController::getFieldValue('Subject', 'description', $class->subject_id) }}</td>
		                            <td>
                                        <button type="button" wire:click="deleteThisId({{ $class->id }})" class="btn btn-danger" data-toggle="modal" data-target="#deleteClassModal"><i class="cil-trash"></i>&nbsp;Delete</button>
		                            </td>
		                        </tr>	
		                        @empty
		                            <tr><td colspan="5">No classes yet ...</td></tr>
			                    @endforelse
			                </tbody>
			            </table>
			            {!! $classes->links() !!}
			        </div>
			        
			        <div wire:ignore.self class="modal fade" id="deleteClassModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
			            <div class="modal-dialog" role="document">
			                <div class="modal-content">
			                    <div class="modal-header">
			                        <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
			                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                            <span aria-hidden="true close-btn">×</span>
			                        </button>
			                    </div>
			                    <div class="modal-body">
			                        <p>Are you sure want to delete this class?</p>
			                    </div>
			                    <div class="modal-footer">
			                        <button wire:click="$emit('resetInputs')" type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
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
