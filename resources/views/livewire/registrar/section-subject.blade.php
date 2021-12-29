<div class="container-fluid">
    <div class="row">
        <div class="col">       
        	@include('livewire.registrar.add-section-subject')

            <div class="card card-accent-success">	
            	<div class="card-header">List of subjects for the section "{{ $section->name }}"
			        <div class="card-header-actions">
			            <a class="card-header-action btn-setting" href="#" data-toggle="modal" data-target="#addSectionSubjectModal">
			                <i class="c-icon cil-pen-alt c-sidebar-nav-icon"></i> Add Subject
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
			                    <option value="first_name">Subject</option>
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
			                    <th style="color: white;" nowrap>Subject Name</th>				                    
			                    <th style="width: 370px; text-align: center; color: white;" nowrap>Action</th>
			                </tr>
			                </thead>
			                <tbody>
			                    @forelse($subjects as $subject)
			                    <?php 
			                        $sub = App\Models\Subject::where('id', $subject->subject_id)->first(); 
			                        $counter = App\Models\SubjectActivity::where('subject_id', $subject->subject_id)->where('section_id', $subject->section_id)->count();
			                    ?>
		                        <tr>				                        
		                            <th>{{ (($subjects->currentPage() * $subjects->perPage()) - $subjects->perPage()) + $loop->iteration  }}</th>
		                            <td>{{ $sub->description }}</td>                           
		                            <td>
		                                <button type="button" wire:click="activities({{ $subject->subject_id }}, {{ $section->id }})" class="btn btn-sm btn-info"><i class="cil-plus"></i>&nbsp;Activities ({{ $counter }})</button>
		                                <button type="button" wire:click="deleteThisId({{ $subject->id }})" data-toggle="modal" data-target="#deleteSectionSubjectModal" class="btn btn-sm btn-danger"><i class="cil-trash"></i>&nbsp;Remove subject from this section</button>		                                 	
		                            </td>
		                        </tr>		
		                        @empty
		                        	<tr><td colspan="3">No subjects yet for this section ...</td></tr>		                    			                        
			                    @endforelse
			                </tbody>
			            </table>
			            {!! $subjects->links() !!}
			        </div>					        
			        
			        <div wire:ignore.self class="modal fade" id="deleteSectionSubjectModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
			            <div class="modal-dialog" role="document">
			                <div class="modal-content">
			                    <div class="modal-header">
			                        <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
			                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                            <span aria-hidden="true close-btn">×</span>
			                        </button>
			                    </div>
			                    <div class="modal-body">
			                        <p>Are you sure want to remove this subject from section "{{ $section->name }}"?</p>
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
