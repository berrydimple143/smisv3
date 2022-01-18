<div class="container-fluid">
    <div class="row">
        <div class="col">
            @include('livewire.faculty.add-grade')
            @include('livewire.faculty.update-grade')
            <div class="card card-accent-success">	
            	<div class="card-header">{{ $table_title }}
            	    <div class="card-header-actions">
            	        <font size="3">
			            <a class="card-header-action btn-setting" href="{{ $route_link }}">
			                << {{ $back_text }}
			            </a>
			            </font>
			        </div>
            	</div>
			    <div class="card-body">
			    	<div class="row mb-3">
			            <div class="col-5">
			                <input wire:model.debounce.300ms="search" class="form-control" type="search" placeholder="Search...">
			            </div>
			            <div class="col-2">
			                <select wire:model="orderBy" class="form-control"  id="grid-state">
			                    <option value="activity_name">Activity Name</option>
			                    <option value="item">Items</option>
			                    <option value="score">Score</option>			                    
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
			            <div class="col-2" style="text-align: right;">
			                <button type="button" data-toggle="modal" data-target="#addGradeModal" class="btn btn-success"><i class="cil-pencil"></i>&nbsp;Add Grade</button>		                
			            </div>
			        </div>
			        <div class="table-responsive">
			            <table class="table table-sm">
			                <thead>
			                <tr>
			                    <th style="width: 130px; color: white;" nowrap>Activity Name</th>
			                    <th style="color: white; text-align: center;" nowrap>Items</th>
			                    <th style="color: white; text-align: center;" nowrap>Score</th>
			                    <th style="color: white; text-align: center;" nowrap>Grade(%)</th>
			                    <th style="width: 160px; text-align: center; color: white;" nowrap>Action</th>
			                </tr>
			                </thead>
			                <tbody>
			                    <?php $total_grade = 0; $cntr = 0; ?>
			                    @forelse($activityGrades as $grade)
			                    <?php
			                        $item = $grade->item;
			                        $score = $grade->score;
			                    	$initialGrade = $rawGrade = 0;
			                    	if($item) {
			                    	    $initialGrade = round(((($score/$item) * 50) + 50), 2); 
			                    	    $rawGrade = (($score/$item) * 50) + 50;
			                    	}
			                    	$total_grade += $rawGrade;
			                    	$cntr++;
			                    ?>                 	
		                        <tr>
		                            <td style="text-align: center;">{{ $grade->activity_name }}</td>
		                            <td style="text-align: center;">{{ $item }}</td>     
		                            <td style="text-align: center;">{{ $score }}</td>      
		                            <td style="text-align: center;">{{ $initialGrade }}%</td>   
		                            <td style="text-align: right;">	
		                                <button type="button" wire:click="edit({{ $grade->id }})" data-toggle="modal" data-target="#editGradeModal" class="btn btn-sm btn-info"><i class="cil-pencil"></i>&nbsp;Edit</button>&nbsp;
		                                <button type="button" wire:click="deleteThisId({{ $grade->id }})" data-toggle="modal" data-target="#deleteGradeModal" class="btn btn-sm btn-danger"><i class="cil-trash"></i>&nbsp;Delete</button>
		                            </td>
		                        </tr>		
		                        @empty
		                        	<tr><td colspan="4">No grades for this activity yet ...</td></tr>		                    			                        
			                    @endforelse
			                    @if($activityGrades)
			                        <?php $sum = round(($total_grade/$cntr), 2); ?>
    			                    <tr style="background-color: #ffff00;">
        			                    <th style="width: 130px;" nowrap>Total Grade</th>
        			                    <th colspan="2">&nbsp;</th>
        			                    <th style="text-align: center;" nowrap>{{ $sum }}%</th>
        			                    <th style="width: 100px; text-align: center;" nowrap>&nbsp;</th>
        			                </tr>
    			                @endif
			                </tbody>
			            </table>
			            {!! $activityGrades->links() !!}
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
