<div class="container-fluid">
    <div class="row">
        <div class="col"> 
            @include('livewire.registrar.add-activity-grade')
            <div class="card card-accent-success">	
            	<div class="card-header">List of activities for "{{ $subject->description }}" subject of {{ $student->first_name." ".$student->last_name }} in section "{{ $section->name }}"
            	    <div class="card-header-actions">
			            <a class="card-header-action btn-setting" href="{{ config('app.url') }}registrar/activity-grades/{{ $student->id }}/">
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
			                    <th style="color: white; text-align: center;" nowrap># of Activity</th>
			                    <th style="color: white; text-align: center;" nowrap>Total Item</th>
			                    <th style="color: white; text-align: center;" nowrap>Total Score</th>
			                    <th style="color: white; text-align: center;" nowrap>Initial Grade</th>
			                    <th style="width: 240px; text-align: center; color: white;" nowrap>Action</th>
			                </tr>
			                </thead>
			                <tbody>
			                    @forelse($activities as $activity)
			                    <?php 
			                    	$act = App\Models\ClassActivity::where('id', $activity->class_activity_id)->first();
			                    	$counter = App\Models\ActivityGrade::where('activity_id', $activity->id)
			                    	                ->where('student_id', $student->id)->where('subject_id', $subject->id)->where('section_id', $section->id)
			                    	                ->count();
			                    	$items = App\Models\ActivityGrade::where('activity_id', $activity->id)
			                    	                ->where('student_id', $student->id)->where('subject_id', $subject->id)->where('section_id', $section->id)
			                    	                ->sum('item');
			                    	$scores = App\Models\ActivityGrade::where('activity_id', $activity->id)
			                    	                ->where('student_id', $student->id)->where('subject_id', $subject->id)->where('section_id', $section->id)
			                    	                ->sum('score');
			                    	$initialGrade = 0;
			                    	if($items) {
			                    	    $initialGrade = round(((($scores/$items) * 50) + 50), 2); 
			                    	}
			                    ?>	                    	
		                        <tr>				                        
		                            <th>{{ (($activities->currentPage() * $activities->perPage()) - $activities->perPage()) + $loop->iteration  }}</th>
		                            <td>{{ $act->name }}</td>  
		                            <td style="text-align: center;">{{ $counter }}</td>
		                            <td style="text-align: center;">{{ $items }}</td>     
		                            <td style="text-align: center;">{{ $scores }}</td>      
		                            <td style="text-align: center;">{{ $initialGrade }}</td>   
		                            <td>		                                
		                                <button type="button" wire:click="addGrade({{ $activity->id }}, {{ $activity->class_activity_id }})" data-toggle="modal" data-target="#addActivityGradeModal" class="btn btn-sm btn-success"><i class="cil-trash"></i>&nbsp;Add Grade</button>
		                                <button type="button" wire:click="viewGrades({{ $student->id }}, {{ $section->id }}, {{ $subject->id }}, {{ $activity->class_activity_id }})" class="btn btn-sm btn-info"><i class="cil-trash"></i>&nbsp;View Grades</button>
		                            </td>
		                        </tr>		
		                        @empty
		                        	<tr><td colspan="7">No activity yet for this subject ...</td></tr>		                    			                        
			                    @endforelse
			                </tbody>
			            </table>
			            {!! $activities->links() !!}
			        </div>					        

			    </div>
			</div>
              
        </div>
    </div>
</div>
