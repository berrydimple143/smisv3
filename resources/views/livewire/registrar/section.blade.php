<div class="container-fluid">
    <div class="row">
        <div class="col">       
        	@include('livewire.registrar.create-section') 	
        	@include('livewire.registrar.update-section')

            <div class="card card-accent-success">	
            	<div class="card-header">List of Sections
			        <div class="card-header-actions">
			            <a class="card-header-action btn-setting" href="#" data-toggle="modal" data-target="#addSectionModal">
			                <i class="c-icon cil-pen-alt c-sidebar-nav-icon"></i> Add Section
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
			                    <option value="name">Section</option>
			                    <option value="student_limit">Student Limit</option>
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
    			                	<th style="color: white;" nowrap>Level/Course</th>			                    
    			                    <th style="color: white;" nowrap>Section Name</th>				                    		                    			                    
    			                    <th style="color: white;" nowrap>Student Limit</th>
    			                    <th style="width: 380px; text-align: center; color: white;" nowrap>Action</th>
    			                </tr>
			                </thead>
			                <tbody>
			                    @forelse($sections as $section)		
			                    <?php 
			                    	$course = "Not set";
			                    	if(!empty($section->course_id)) {
				                    	$crs = App\Models\Course::where('id', $section->course_id)->first(); 
				                    	$course = $crs->name;
				                    }
			                    ?>	                                      	
		                        <tr>    
		                        	<td>{{ $course }}</td>                        
		                            <td>{{ $section->name }}</td>		                            
		                            <td>{{ $section->student_limit }}</td>
		                            <td>
		                                <button type="button" wire:click="edit({{ $section->id }})" class="btn btn-sm btn-success" data-toggle="modal" data-target="#editSectionModal"><i class="cil-pencil"></i>&nbsp;Edit</button>
		                                <button type="button" wire:click="deleteThisId({{ $section->id }})" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteSectionModal"><i class="cil-trash"></i>&nbsp;Delete</button>
		                                <button type="button" wire:click="subjects({{ $section->id }})" class="btn btn-sm btn-warning"><i class="cil-plus"></i>&nbsp;Subjects ({{ $section->sectionsubjects->count() }})</button>
		                                <button type="button" wire:click="students({{ $section->id }})" class="btn btn-sm btn-primary"><i class="cil-plus"></i>&nbsp;Students ({{ $section->sectionstudents->count() }})</button>	  
		                            </td>
		                        </tr>	
		                        @empty
		                            <tr><td colspan="4">No sections yet ...</td></tr>
			                    @endforelse
			                </tbody>
			            </table>
			            {!! $sections->links() !!}
			        </div>					        
			        
			        <div wire:ignore.self class="modal fade" id="deleteSectionModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
			            <div class="modal-dialog" role="document">
			                <div class="modal-content">
			                    <div class="modal-header">
			                        <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
			                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                            <span aria-hidden="true close-btn">×</span>
			                        </button>
			                    </div>
			                    <div class="modal-body">
			                        <p>Are you sure want to delete this section?</p>
			                    </div>
			                    <div class="modal-footer">
			                        <button wire:click="$emit('resetAllInputs')" type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
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
