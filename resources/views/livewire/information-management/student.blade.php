<div class="container-fluid">
    <div class="row">
        <div class="col">
            
            <div class="card card-accent-success">	
            	<div class="card-header"><font size="5">Manage Students</font><div class="card-header-actions"><input wire:model.debounce.300ms="search" class="form-control" style="width: 300px;" type="search" placeholder="Search..."></div></div>		    
			    <div class="card-body">
			        <form>
    			        <div class="row mb-3">
    			            <div class="col-3">
    			                School Year:
    			                <select wire:model="school_year_id" class="form-control"  id="school-year" required>
    			                    @foreach($listOfSchoolYear as $sy)
    			                        <option value="{{ $sy->id }}">{{ $sy->description }}</option>
    			                    @endforeach
    			                </select>
    			            </div>
    			            <div class="col-3">
    			                Semester:
    			                <input wire:model.lazy="semester_description" type="text" class="form-control @if($errors->has('semester_description')) is-invalid @endif" required readonly>
                                @error('semester_description') <span class="invalid-feedback">{{ $message }}</span>@enderror
    			            </div>
    			            <div class="col-3">&nbsp;</div>
    			            <div class="col-3">
    			                <div class="btn-group" role="group" aria-label="Basic example">
                                      <button type="button" class="btn btn-success"><i class="cil-pencil"></i>&nbsp;Add</button>
                                      <button type="button" class="btn btn-info"><i class="cil-pencil"></i>&nbsp;Edit</button>
                                      <button type="button" class="btn btn-danger"><i class="cil-pencil"></i>&nbsp;Delete</button>
                                </div>
    			            </div>
    			        </div>
    			        <div class="row mb-3">
    			            <div class="col-3">
    			                Grade Level:
    			                <select wire:model="course_id" class="form-control"  id="grade" required>
    			                    @if(!empty($listOfGradeLevel))
    			                        @foreach($listOfGradeLevel as $grlv)
        			                        <option value="{{ $grlv->id }}">{{ $grlv->name }}</option>
        			                    @endforeach
    			                    @endif
    			                </select>
    			                @error('course_id') <span class="invalid-feedback">{{ $message }}</span>@enderror
    			            </div>
    			            <div class="col-3">
    			                Section:
    			                <select wire:model="section_id" class="form-control"  id="semester">
    			                    @if(!empty($listOfSections))
        			                    @foreach($listOfSections as $section)
        			                        <option value="{{ $section->id }}">{{ $section->name }}</option>
        			                    @endforeach
    			                    @endif
    			                </select>
    			                @error('section_id') <span class="invalid-feedback">{{ $message }}</span>@enderror
    			            </div>
    			        </div>
    			        <div class="row mb-3">
    			            <div class="col-3">
    			                Teacher:
    			                <select wire:model="teacher_id" class="form-control"  id="grade">
    			                    @if(!empty($listOfTeachers))
        			                    @foreach($listOfTeachers as $teacher)
        			                        <option value="{{ $teacher->id }}">{{ $teacher->first_name." ".$teacher->last_name }}</option>
        			                    @endforeach
    			                    @endif
    			                </select>
    			            </div>
    			            <div class="col-3">
    			                Subject Code:
    			                <select wire:model="subject_id" class="form-control"  id="semester">
    			                    @if(!empty($listOfSubjects))
        			                    @foreach($listOfSubjects as $subject)
        			                        <option value="{{ $subject->id }}">{{ $subject->code }}</option>
        			                    @endforeach
    			                    @endif
    			                </select>
    			            </div>
    			            <div class="col-3">
    			                Subject Name:
    			                <select wire:model="subject_id" class="form-control"  id="semester">
    			                    @if(!empty($listOfSubjects))
        			                    @foreach($listOfSubjects as $subject)
        			                        <option value="{{ $subject->id }}">{{ $subject->description }}</option>
        			                    @endforeach
    			                    @endif
    			                </select>
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
    			                </tr>
			                </thead>
			                <tbody>
			                    @forelse($students as $class)		
		                        <tr>    
		                        	<td>&nbsp;</td>                        
		                            <td>&nbsp;</td>    	                            
		                            <td>&nbsp;</td>
		                            <td>&nbsp;</td>    	                            
		                            <td>&nbsp;</td>
		                        </tr>	
		                        @empty
		                            <tr><td colspan="5">No classes yet ...</td></tr>
			                    @endforelse
			                </tbody>
			            </table>
			            {!! $students->links() !!}
			        </div>
			    </div>
			</div>
              
        </div>
    </div>
</div>
