<div class="container-fluid">
    <div class="row">
        <div class="col">       
            @include('livewire.faculty.add-grade')
            <div class="card card-accent-success">	
			    <div class="card-header">List of Performance Tasks Grades for "{{ App\Http\Controllers\HelperController::getFieldValue('StudentRecord', 'first_name', $student_id) }} {{ App\Http\Controllers\HelperController::getFieldValue('StudentRecord', 'last_name', $student_id) }}"
			        <div class="card-header-actions">
			            <font size="3">
    			            <a class="card-header-action btn-setting" href="{{ config('app.url') }}faculty/class-record?school_year_id={{ $school_year_id }}&semester_id={{ $semester_id }}&course_id={{ $course_id }}&section_id={{ $section_id }}&teacher_id={{ $teacher_id }}&subject_id={{ $subject_id }}">
    			                << Back to class record
    			            </a>
			            </font>
			        </div>
			    </div>	
			    <div class="card-body">
			    	<div class="row mb-3">	
			    	    <div class="col-4">
			                <input wire:model.debounce.300ms="search" class="form-control" type="search" placeholder="Search...">	                
			            </div>
			        </div>
			        <div class="table-responsive">
			            <table class="table table-sm">
			                <thead>
			                <tr>		                    
			                    <th style="width: 150px; color: white;" nowrap>Code</th>
			                    <th style="color: white;" nowrap>Description</th>
			                    <th style="color: white; text-align: center;" nowrap>Total Items</th>
			                    <th style="color: white; text-align: center;" nowrap>Total Score</th>
			                    <th style="color: white; text-align: center;" nowrap>Total Grade (%)</th>
			                    <th style="width: 250px; text-align: center; color: white;" nowrap>Action</th>
			                </tr>
			                </thead>
			                <tbody>
			                    @forelse($tasks as $tsk)
			                    <?php
			                        $items = App\Models\ClassRecord::where('section_id', $section_id)
		                                    ->where('subject_id', $subject_id)
		                                    ->where('student_id', $student_id)
		                                    ->where('teacher_id', $teacher_id)
		                                    ->where('course_id', $course_id)
		                                    ->where('school_year_id', $school_year_id)
		                                    ->where('semester_id', $semester_id)
		                                    ->where('criteria_id', $criteria_id)
		                                    ->where('subject_criteria_id', $tsk->id)->sum('item');
		                            $scores = App\Models\ClassRecord::where('section_id', $section_id)
		                                    ->where('subject_id', $subject_id)
		                                    ->where('student_id', $student_id)
		                                    ->where('teacher_id', $teacher_id)
		                                    ->where('course_id', $course_id)
		                                    ->where('school_year_id', $school_year_id)
		                                    ->where('semester_id', $semester_id)
		                                    ->where('criteria_id', $criteria_id)
		                                    ->where('subject_criteria_id', $tsk->id)->sum('score');
		                            $allScores = App\Models\ClassRecord::where('section_id', $section_id)
		                                    ->where('subject_id', $subject_id)
		                                    ->where('student_id', $student_id)
		                                    ->where('teacher_id', $teacher_id)
		                                    ->where('course_id', $course_id)
		                                    ->where('school_year_id', $school_year_id)
		                                    ->where('semester_id', $semester_id)
		                                    ->where('criteria_id', $criteria_id)
		                                    ->where('subject_criteria_id', $tsk->id)->get();
		                            $total = App\Http\Controllers\HelperController::getTotal($allScores);
		                            $total_grades = 0;
		                            if($items > 0) {
		                                $total_grades = round($total, 2); 
		                            }
			                    ?>
			                    <tr>
			                        <td>{{ $tsk->code }}</td>
		                            <td>{{ $tsk->description }}</td>
		                            <td style="text-align: center;">{{ $items }}</td>
		                            <td style="text-align: center;">{{ $scores }}</td>
		                            <td style="text-align: center;">{{ $total_grades }} %</td>
		                            <td style="text-align: right;">
		                                <button type="button" wire:click="$emit('addGrade', {{ $tsk->id }})" data-toggle="modal" data-target="#addGradeModal" class="btn btn-sm btn-success"><i class="cil-pencil"></i>&nbsp;Add Grade</button>
		                                <button type="button" wire:click="view({{ $tsk->id }})" class="btn btn-sm btn-info"><i class="cil-trash"></i>&nbsp;View Grades</button>		                                          	
		                            </td>
		                        </tr>		
		                        @empty
		                            <tr><td colspan="6">No subject criteria yet ...</td></tr>
			                    @endforelse
			                </tbody>
			            </table>
			            {!! $tasks->links() !!}
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
