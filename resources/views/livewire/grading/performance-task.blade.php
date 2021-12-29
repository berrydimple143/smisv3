<div class="container-fluid">
    <div class="row">
        <div class="col">
        	@include('livewire.grading.create-task')
        	@include('livewire.grading.update-task')

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
			    <div class="card-header">Mini Task/Performance Task
			        <div class="card-header-actions">
			            <a class="card-header-action btn-setting" href="#" data-toggle="modal" data-target="#AddTaskModal">
			                <i class="c-icon cil-pen-alt c-sidebar-nav-icon"></i> Task
			            </a>
			        </div>
			    </div>
			    <div class="card-body">
			        <div class="table-responsive">
			            <table class="table table-sm">
			                <thead>
			                <tr>
			                    <th style="color: white;" nowrap>Type</th>
			                    <th style="color: white;" nowrap>MT1</th>
			                    <th style="color: white;" nowrap>MT2</th>
			                    <th style="color: white;" nowrap>MT3</th>
			                    <th style="color: white;" nowrap>PT</th>
			                    <th style="color: white;" nowrap>TOTAL</th>			                    
			                    <th style="width: 150px; text-align: center; color: white;" nowrap>Action</th>
			                </tr>
			                </thead>
			                <tbody>
			                    @foreach($tasks as $task)
			                    	<?php $sum = (int)$task->MT1 + (int)$task->MT2 + (int)$task->MT3 + (int)$task->PT; ?>
			                        <tr>
			                            <td>{{ $task->type }}</td>
			                            <td>{{ $task->MT1 }}</td>
			                            <td>{{ $task->MT2 }}</td>
			                            <td>{{ $task->MT3 }}</td>
			                            <td>{{ $task->PT }}</td>	
			                            <td>{{ $sum }}</td>		                            
			                            <td>
			                                <button type="button" wire:click="edit({{ $task->id }})" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#updateTaskModal"><i class="cil-pencil"></i>&nbsp;Edit</button>
			                                <button type="button" wire:click="deleteThisId({{ $task->id }})" data-toggle="modal" data-target="#deleteTaskModal" class="btn btn-sm btn-danger"><i class="cil-trash"></i>&nbsp;Delete</button>			                                
			                            </td>
			                        </tr>
			                    @endforeach
			                </tbody>
			            </table>
			            {!! $tasks->links() !!}
			        </div>		        
			        
			        <div wire:ignore.self class="modal fade" id="deleteTaskModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
			            <div class="modal-dialog" role="document">
			                <div class="modal-content">
			                    <div class="modal-header">
			                        <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
			                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                            <span aria-hidden="true close-btn">×</span>
			                        </button>
			                    </div>
			                    <div class="modal-body">
			                        <p>Are you sure want to delete this one?</p>
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
