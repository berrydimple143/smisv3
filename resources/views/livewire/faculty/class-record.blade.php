<div class="container-fluid">
    <div class="row">
        <div class="col">
            
            <div class="card card-accent-success">	
            	<div class="card-header"><font size="5">Manage Class Record</font><div class="card-header-actions"><input wire:model.debounce.300ms="search" class="form-control" style="width: 300px;" type="search" placeholder="Search..."></div></div>		    
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
    			                    @if(!empty($listOfTeachers))
        			                    @foreach($listOfTeachers as $teacher)
        			                        <option value="{{ $teacher->id }}">{{ $teacher->first_name." ".$teacher->last_name }}</option>
        			                    @endforeach
    			                    @endif
                                </select>
                                @error('teacher_id') <span class="invalid-feedback">{{ $message }}</span>@enderror
    			            </div>
    			            <div class="col-3">
    			                Subject Name:
    			                <select wire:model.lazy="subject_id" name="subject" class="form-control @if($errors->has('subject_id')) is-invalid @endif" required>
    			                    <option value="">Select subject here</option>
    			                    @if(!empty($listOfSubjects))
        			                    @foreach($listOfSubjects as $subject)
        			                        <option value="{{ $subject->id }}">{{ $subject->description }}</option>
        			                    @endforeach
    			                    @endif
                                </select>
                                @error('subject_id') <span class="invalid-feedback">{{ $message }}</span>@enderror
    			            </div>
    			        </div>
			        </form>
			        <div class="table-responsive">
			            <table class="table table-sm">
			                <thead>
    			                <tr>	
    			                	<th style="width: 200px; color: white;" nowrap>Student Name</th>		
    			                	@foreach($listOfCriteria as $criterium)
    			                	    <th style="color: white;" nowrap>{{ $criterium->description }} ({{ $criterium->percent }}%)</th>
    			                	@endforeach
    			                	<th style="color: white;" nowrap>Final Grade</th>
    			                    <th style="text-align: center; width: 400px; color: white;" nowrap>Action</th>
    			                </tr>
			                </thead>
			                <tbody>
			                    @forelse($students as $student)		
    		                        <tr>    
    		                        	<td>{{ $student->last_name }}, {{ $student->first_name }}</td>                        
    		                            <td>
    		                                @foreach($listOfCriteria as $criterium)
        		                                <?php
            		                                $items = App\Models\ClassRecord::where('section_id', $section_id)
            		                                    ->where('subject_id', $subject_id)
            		                                    ->where('student_id', $student->id)
            		                                    ->where('teacher_id', $teacher_id)
            		                                    ->where('course_id', $course_id)
            		                                    ->where('school_year_id', $school_year_id)
            		                                    ->where('semester_id', $semester_id)
            		                                    ->where('criteria_id', $criterium->id)->sum('item');
        		                                    $allScores = App\Models\ClassRecord::where('section_id', $section_id)
            		                                    ->where('subject_id', $subject_id)
            		                                    ->where('student_id', $student->id)
            		                                    ->where('teacher_id', $teacher_id)
            		                                    ->where('course_id', $course_id)
            		                                    ->where('school_year_id', $school_year_id)
            		                                    ->where('semester_id', $semester_id)
            		                                    ->where('criteria_id', $criterium->id)->get();
            		                                $total = App\Http\Controllers\HelperController::getTotal($allScores);
            		                                $total_grades = 0;
                		                            if($items > 0) {
                		                                $total_grades = round($total, 2); 
                		                            }
        		                                ?>
    		                                @endforeach
    		                            </td>
    		                            <td></td>
    		                            <td></td>
    		                            <td style="text-align: right;">
                                            <?php $stl = "primary"; ?>
                                            @if($showButton)
                                                @foreach($listOfCriteria as $criterium)
                                                    <?php
                                                        $data = [
                                                            'school_year_id' => $school_year_id,
                                                            'semester_id' => $semester_id,
                                                            'subject_id' => $subject_id,
                                                            'course_id' => $course_id,
                                                            'section_id' => $section_id,
                                                            'teacher_id' => $teacher_id,
                                                            'student_id' => $student->id,
                                                            'criteria_id' => $criterium->id
                                                        ];
                                                        $url = "performance.task";
                                                        if(Illuminate\Support\Str::contains($criterium->description, "Written")) {
                                                            $url = "written.work";
                                                        }
                                                    ?>
                                                    <a href="{{ route($url, $data) }}"><button type="button" class="btn btn-sm btn-{{ $stl }}"><i class="cil-pencil"></i>&nbsp;{{ $criterium->description }} Grades</button>&nbsp;
                                                    <?php $stl = "info"; ?>
                                                @endforeach
                                            @endif
    		                            </td>
    		                        </tr>
    		                    @empty
    		                        <tr><td colspan="5">No students yet ...</td></tr>
		                        @endforelse
			                </tbody>
			            </table>
			            {!! $students->links() !!}
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
