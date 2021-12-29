<div class="container-fluid">
    <div class="row">
        <div class="col">
            <input wire:model="section_id" type="hidden" id="section_id" value="{{ $section_id }}">
            <div class="card card-accent-success">	
            	<div class="card-header">List of grades per subject for "{{ $student->first_name." ".$student->last_name }}"</div>		    
			    <div class="card-body">
			    	<div class="row mb-3">
			            <div class="col-7">
			                <input wire:model.debounce.300ms="search" class="form-control" type="search" placeholder="Search...">
			            </div>
			            <div class="col-2">
			                <select wire:model="orderBy" class="form-control"  id="grid-state">
			                    <option value="description">Subject Description</option>
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
			                    <th style="color: white;" nowrap>Subject</th>	
			                    <th style="color: white;" nowrap>Final Grade</th>
			                    <th style="width: 150px; text-align: center; color: white;" nowrap>Action</th>
			                </tr>
			                </thead>
			                <tbody>
			                    @forelse($subjects as $subject)
			                    <?php $subj = App\Models\Subject::where('id', $subject->subject_id)->first(); ?>                      	
		                        <tr>
		                            <td>{{ $subj->description }}</td>   
		                            <td>&nbsp;</td>   
		                            <td>
		                                <button type="button" wire:click="activityGrades({{ $student->id }}, {{ $subject->id }})" class="btn btn-sm btn-success"><i class="cil-trash"></i>&nbsp;Activity Grades</button>
		                            </td>
		                        </tr>		
		                        @empty
		                        	<tr><td colspan="3">No subjects yet for "{{ $student->first_name." ".$student->last_name }}" ...</td></tr>		                    			                        
			                    @endforelse
			                </tbody>
			            </table>
			            {!! $subjects->links() !!}
			        </div>					        
			        
			        <div wire:ignore.self class="modal fade" id="deleteStudentSectionModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
			            <div class="modal-dialog" role="document">
			                <div class="modal-content">
			                    <div class="modal-header">
			                        <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
			                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                            <span aria-hidden="true close-btn">×</span>
			                        </button>
			                    </div>
			                    <div class="modal-body">
			                        <p>Are you sure want to remove this student from section "{{ $student->first_name." ".$student->last_name }}"?</p>
			                    </div>
			                    <div class="modal-footer">
			                        <button wire:click="$emit('resetAllInputs')" type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
			                        <button type="button" wire:click.prevent="deleteNow" class="btn btn-danger" data-dismiss="modal">Yes, remove</button>
			                    </div>
			                </div>
			            </div>
			        </div>

			    </div>
			</div>
              
        </div>
    </div>
</div>
