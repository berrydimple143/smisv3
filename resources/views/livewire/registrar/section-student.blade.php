<div class="container-fluid">
    <div class="row">
        <div class="col">       
        	@include('livewire.registrar.add-section-student')
            <input wire:model="section_id" type="hidden" id="section_id" value="{{ $section_id }}">
            <div class="card card-accent-success">	
            	<div class="card-header">List of students for the section "{{ $sectionName }}"
			        <div class="card-header-actions">
			            <a class="card-header-action btn-setting" href="#" data-toggle="modal" data-target="#addSectionStudentModal">
			                <i class="c-icon cil-pen-alt c-sidebar-nav-icon"></i> Add Student
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
			                    <option value="first_name">First Name</option>
			                    <option value="last_name">Last Name</option>			                    
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
			                    <th style="color: white;" nowrap>First Name</th>				                    
			                    <th style="color: white;" nowrap>Last Name</th>			                  
			                    <th style="width: 390px; text-align: center; color: white;" nowrap>Action</th>
			                </tr>
			                </thead>
			                <tbody>
			                    @forelse($students as $student)
			                                       	
		                        <tr>				                        
		                            <th>{{ (($students->currentPage() * $students->perPage()) - $students->perPage()) + $loop->iteration  }}</th>
		                            <td>{{ $student->first_name }}</td>                     
		                            <td>{{ $student->last_name }}</td>                           
		                            <td>
		                                <button type="button" wire:click="viewGrades({{ $student->id }})" class="btn btn-sm btn-success"><i class="cil-trash"></i>&nbsp;View grades per subject</button>		                                
		                                <button type="button" wire:click="deleteThisId({{ $student->id }})" data-toggle="modal" data-target="#deleteStudentSectionModal" class="btn btn-sm btn-danger"><i class="cil-trash"></i>&nbsp;Remove from this section</button>		                                 	
		                            </td>
		                        </tr>		
		                        @empty
		                        	<tr><td colspan="4">No student yet for this section ...</td></tr>		                    			                        
			                    @endforelse
			                </tbody>
			            </table>
			            {!! $students->links() !!}
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
			                        <p>Are you sure want to remove this student from section "{{ $sectionName }}"?</p>
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
