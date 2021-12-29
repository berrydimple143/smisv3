<div class="container-fluid">
    <div class="row">
        <div class="col">       	

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
            	<div class="card-header">List of Teachers</div>		    
			    <div class="card-body">
			    	<div class="row mb-3">
			            <div class="col-7">
			                <input wire:model.debounce.300ms="search" class="form-control" type="search" placeholder="Search...">
			            </div>
			            <div class="col-2">
			                <select wire:model="orderBy" class="form-control"  id="grid-state">
			                    <option value="id">ID</option>
			                    <option value="name">Name</option>	
			                    <option value="first_name">First Name</option>
			                    <option value="last_name">Last Name</option>
			                    <option value="email">Email</option>
			                    <option value="mobile">Mobile #</option>			                    
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
			                    <th style="color: white;" nowrap>Teacher</th>	
			                    <th style="color: white;" nowrap>Email Address</th>
			                    <th style="color: white;" nowrap>Mobile</th>				                    		                    			                    			                  
			                    <th style="width: 150px; text-align: center; color: white;" nowrap>Action</th>
			                </tr>
			                </thead>
			                <tbody>
			                    @forelse($teachers as $teacher)				                                      
		                        <tr>				                        
		                            <td>{{ $teacher->first_name. ' '.$teacher->last_name  }}</td>    
		                            <td>{{ $teacher->email }}</td>         
		                            <td>{{ $teacher->mobile }}</td>          
		                            <td>
		                                <button type="button" wire:click="{{ route('students') }}" class="btn btn-sm btn-success"><i class="cil-pencil"></i>&nbsp;View Students</button>	                                          				                                	
		                            </td>
		                        </tr>		
		                        @empty
		                        <tr><td>No teachers yet ...</td></tr>	                    			                        
			                    @endforelse
			                </tbody>
			            </table>
			            {!! $teachers->links() !!}
			        </div>	

			    </div>
			</div>
              
        </div>
    </div>
</div>
