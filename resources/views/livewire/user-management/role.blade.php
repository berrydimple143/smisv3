<div class="container-fluid">
    <div class="row">
        <div class="col">       
        	@include('livewire.user-management.create-role') 	
        	@include('livewire.user-management.update-role')
        	@include('livewire.user-management.add-role-permission') 
            @include('livewire.user-management.remove-role-permission') 
           
            <div class="card card-accent-success">	
            	<div class="card-header">List of User Roles
			        <div class="card-header-actions">
			            <a class="card-header-action btn-setting" href="#" data-toggle="modal" data-target="#addRoleModal">
			                <i class="c-icon cil-pen-alt c-sidebar-nav-icon"></i> Add Role
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
			                    <option value="name">Name</option>			                    
			                    <option value="title">Title</option>
			                    <option value="guard_name">Guard</option>
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
			                    <th style="color: white;" nowrap>Name</th>		
			                    <th style="color: white;" nowrap>Title</th>
			                    <th style="width: 90px; color: white;" nowrap>Guard</th>		                  
			                    <th style="width: 450px; text-align: center; color: white;" nowrap>Action</th>
			                </tr>
			                </thead>
			                <tbody>
			                    @forelse($roles as $role)			                                      
		                        <tr>				                        
		                            <td>{{ $role->name }}</td>	
		                            <td>{{ $role->title }}</td>	                   
		                            <td>{{ $role->guard_name }}</td>                  
		                            <td>
		                                <button type="button" wire:click="edit({{ $role->id }})" class="btn btn-sm btn-success" data-toggle="modal" data-target="#editRoleModal"><i class="cil-pencil"></i>&nbsp;Edit</button>
		                                <button type="button" wire:click="addPermission({{ $role->id }})" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addRolePermissionModal"><i class="cil-pencil"></i>&nbsp;Add Permission</button>
		                                <button type="button" wire:click="removePermission({{ $role->id }})" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#removeRolePermissionModal"><i class="cil-pencil"></i>&nbsp;Remove Permission</button>
		                                <button type="button" wire:click="deleteThisId({{ $role->id }})" data-toggle="modal" data-target="#deleteRoleModal" class="btn btn-sm btn-danger"><i class="cil-trash"></i>&nbsp;Delete</button>	                                          				                                	
		                            </td>
		                        </tr>		
		                        @empty
		                        <tr><td colspan="5">No role yet ...</td></tr>	                    			                        
			                    @endforelse
			                </tbody>
			            </table>
			            {!! $roles->links() !!}
			        </div>					        
			        
			        <div wire:ignore.self class="modal fade" id="deleteRoleModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
			            <div class="modal-dialog" role="document">
			                <div class="modal-content">
			                    <div class="modal-header">
			                        <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
			                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                            <span aria-hidden="true close-btn">×</span>
			                        </button>
			                    </div>
			                    <div class="modal-body">
			                        <p>Are you sure want to delete this role?</p>
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
