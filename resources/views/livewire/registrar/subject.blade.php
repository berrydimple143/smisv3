<div class="container-fluid">
    <div class="row">
        <div class="col">       
        	@include('livewire.registrar.create-subject') 	
        	@include('livewire.registrar.update-subject')

            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            <div class="card card-accent-success">	
            	<div class="card-header">List of Subjects
			        <div class="card-header-actions">
			            <a class="card-header-action btn-setting" href="#" data-toggle="modal" data-target="#addSubjectModal">
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
			                    <option value="description">Description</option>
			                    <option value="used">Status</option>
			                    <option value="code">Code</option>
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
			                    <th style="width: 130px; color: white;" nowrap>Code</th>
			                    <th style="color: white;" nowrap>Description</th>	
			                    <th style="width: 170px; color: white;" nowrap>Classification</th>		
			                    <th style="width: 80px; color: white;" nowrap>Status</th>	                  
			                    <th style="width: 150px; text-align: center; color: white;" nowrap>Action</th>
			                </tr>
			                </thead>
			                <tbody>			                	
			                    @forelse($subjects as $subject)
			                    	<?php 
			                    		$class = App\Models\Classification::where('id', $subject->classification_id)->first();				                    		    
                                        $status = "unused";
			                    		$color = "success";
			                    		if($subject->used == "yes") {
			                    			$status = "used";
			                    			$color = "danger";
			                    		}               		
			                    	?>			                    	
			                        <tr>				                        
			                            <td>{{ $subject->code }}</td>
			                            <td>{{ $subject->description }}</td>
			                            <td>{{ $class->description }}</td>		
			                            <td><span class="badge bg-{{ $color }}">{{ $status }}</span></td>		                                       
			                            <td>
			                                <button type="button" wire:click="edit({{ $subject->id }})" class="btn btn-sm btn-success" data-toggle="modal" data-target="#editSubjectModal"><i class="cil-pencil"></i>&nbsp;Edit</button>
			                                <button type="button" wire:click="deleteThisId({{ $subject->id }})" data-toggle="modal" data-target="#deleteSubjectModal" class="btn btn-sm btn-danger"><i class="cil-trash"></i>&nbsp;Delete</button>	                                          				                                	
			                            </td>
			                        </tr>	
			                    @empty
			                  		<tr><td colspan="5">No subject yet ...</td></tr>	                        			                        
			                    @endforelse
			                </tbody>
			            </table>
			            {!! $subjects->links() !!}
			        </div>					        
			        
			        <div wire:ignore.self class="modal fade" id="deleteSubjectModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
			            <div class="modal-dialog" role="document">
			                <div class="modal-content">
			                    <div class="modal-header">
			                        <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
			                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                            <span aria-hidden="true close-btn">×</span>
			                        </button>
			                    </div>
			                    <div class="modal-body">
			                        <p>Are you sure want to delete this subject?</p>
			                    </div>
			                    <div class="modal-footer">
			                        <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
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
