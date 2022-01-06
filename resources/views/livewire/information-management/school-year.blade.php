<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card card-accent-success">
                <div class="card-header"><font size="5">Manage School Year</font></div>	
            	<div class="card-header">
            	        @if($mode == "add")
            	            <button wire:click.prevent="store" wire:loading.attr="disabled" type="button" class="btn btn-success"><div wire:loading wire:target="store"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div><i class="cil-pencil"></i>&nbsp;Add</button>
            	        @elseif($mode == "edit")
            	            <button wire:click.prevent="update" wire:loading.attr="disabled" type="button" class="btn btn-success"><div wire:loading wire:target="update"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div><i class="cil-pencil"></i>&nbsp;Save Changes</button>
            	        @endif
            	        <div class="card-header-actions">
            	            <input wire:model.debounce.300ms="search" class="form-control" style="width: 300px;" type="search" placeholder="Search...">
            	        </div>
            	</div>		    
			    <div class="card-body">
			        <form>
			        <div class="row mb-3">
			            <div class="col-3">
			                School Year: <input wire:model.debounce.100ms="description" type="text" class="form-control @if($errors->has('description')) is-invalid @endif" required>
			                @error('description') <span class="invalid-feedback">{{ $message }}</span>@enderror
			            </div>
			            <div class="col-9">&nbsp;</div>
			        </div>
			        <div class="row mb-3">
			            <div class="col-3">
			                School Year Start:
			                <input wire:model.lazy="start_date" type="date" class="form-control @if($errors->has('start_date')) is-invalid @endif" format="yyyy-MM-dd" value-format="yyyy-MM-dd" required>
                            @error('start_date') <span class="invalid-feedback">{{ $message }}</span>@enderror
			            </div>
			            <div class="col-3">
			                School Year End:
			                <input wire:model.lazy="end_date" type="date" class="form-control @if($errors->has('end_date')) is-invalid @endif" format="yyyy-MM-dd" value-format="yyyy-MM-dd" required>
                            @error('end_date') <span class="invalid-feedback">{{ $message }}</span>@enderror
			            </div>
			        </div>
			        <div class="row mb-3"><font size="5">Semester</font></div>
			        
    			        <div class="row mb-3">
    			            <div class="col-3">School Year: {{ $description }}</div>
    			            <div class="col-9">&nbsp;</div>
    			        </div>
    			        <div class="row mb-3">
    			            <div class="col-3">1st Semester:&nbsp;<input wire:change="addSemester($event.target.id)" type="checkbox" id="semester1" value="1st"> Set Active</div>
    			            <div class="col-3">&nbsp;</div>
    			            <div class="col-3">2nd Semester:&nbsp;<input wire:change="addSemester($event.target.id)" type="checkbox" id="semester2" value="2nd"> Set Active</div>
    			        </div>
    			        <div class="row mb-3">
    			            <div class="col-3">
    			                Start Date
            			        <input wire:model.lazy="semester1_start_date" type="date" class="form-control @if($errors->has('semester1_start_date')) is-invalid @endif" format="yyyy-MM-dd" value-format="yyyy-MM-dd" required>
                                @error('semester1_start_date') <span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-3">
                                End Date
            			        <input wire:model.lazy="semester1_end_date" type="date" class="form-control @if($errors->has('semester1_end_date')) is-invalid @endif" format="yyyy-MM-dd" value-format="yyyy-MM-dd" required>
                                @error('semester1_end_date') <span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-3">
    			                Start Date
            			        <input wire:model.lazy="semester2_start_date" type="date" class="form-control @if($errors->has('semester2_start_date')) is-invalid @endif" format="yyyy-MM-dd" value-format="yyyy-MM-dd" required>
                                @error('semester2_start_date') <span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-3">
                                End Date
            			        <input wire:model.lazy="semester2_end_date" type="date" class="form-control @if($errors->has('semester2_end_date')) is-invalid @endif" format="yyyy-MM-dd" value-format="yyyy-MM-dd" required>
                                @error('semester2_end_date') <span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="row mb-3">
    			            <div class="col-3">3rd Semester:&nbsp;<input wire:change="addSemester($event.target.id)" type="checkbox" id="semester3" value="3rd"> Set Active</div>
    			            <div class="col-9">&nbsp;</div>
    			        </div>
                        <div class="row mb-3">
    			            <div class="col-3">
    			                Start Date
            			        <input wire:model.lazy="semester3_start_date" type="date" class="form-control @if($errors->has('semester3_start_date')) is-invalid @endif" format="yyyy-MM-dd" value-format="yyyy-MM-dd" required>
                                @error('semester3_start_date') <span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-3">
                                End Date
            			        <input wire:model.lazy="semester3_end_date" type="date" class="form-control @if($errors->has('semester3_end_date')) is-invalid @endif" format="yyyy-MM-dd" value-format="yyyy-MM-dd" required>
                                @error('semester3_end_date') <span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </form>
			        <div class="table-responsive">
			            <table class="table table-sm">
			                <thead>
    			                <tr>	
    			                	<th style="color: white;" nowrap>School Year</th>			                    
    			                    <th style="color: white;" nowrap>Start Date</th>				                    		                    			                    
    			                    <th style="color: white;" nowrap>End Date</th>
    			                    <th style="width: 190px; color: white;" nowrap>Status</th>
    			                    <th style="width: 190px; color: white;" nowrap>Action</th>
    			                </tr>
			                </thead>
			                <tbody>
			                    @forelse($schoolyears as $scyear)
			                    <?php
			                        $sdate = $edate = 'Not set';
		                    		if($scyear->start_date) { $sdate = App\Http\Controllers\HelperController::convertDateToString($scyear->start_date); }
		                    		if($scyear->end_date) { $edate = App\Http\Controllers\HelperController::convertDateToString($scyear->end_date); }
		                    		$status = "Inactive";
		                    		$status_class = "danger";
		                    		if($scyear->status == 1 or $scyear->status == '1') {
		                    		    $status = "Active"; 
		                    		    $status_class = "success";
		                    		}
			                    ?>
		                        <tr>    
		                        	<td>{{ $scyear->description }}</td>                        
		                            <td>{{ $sdate }}</td>    	                            
		                            <td>{{ $edate }}</td> 
		                            <td>
		                                <button type="button" wire:click="$emit('changeStatus', {{ $scyear->id }})" class="btn btn-{{ $status_class }}" data-toggle="modal" data-target="#changeStatusModal">{{ $status }}</button>
		                            </td> 
		                            <td>
		                                <button wire:click="edit({{ $scyear->id }})" type="button" class="btn btn-info"><i class="cil-pencil"></i>&nbsp;Edit</button>
                                        <button type="button" wire:click="deleteThisId({{ $scyear->id }})" class="btn btn-danger" data-toggle="modal" data-target="#deleteSchoolYearModal"><i class="cil-trash"></i>&nbsp;Delete</button>
		                            </td>
		                        </tr>	
		                        @empty
		                            <tr><td colspan="5">No school year yet ...</td></tr>
			                    @endforelse
			                </tbody>
			            </table>
			            {!! $schoolyears->links() !!}
			        </div>
			        
			        <div wire:ignore.self class="modal fade" id="changeStatusModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
			            <div class="modal-dialog" role="document">
			                <div class="modal-content">
			                    <div class="modal-header">
			                        <h5 class="modal-title" id="deleteModalLabel">Change Status</h5>
			                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                            <span aria-hidden="true close-btn">×</span>
			                        </button>
			                    </div>
			                    <div class="modal-body">
			                        <p>{{ $stat_modal_content }}</p>
			                    </div>
			                    <div class="modal-footer">
			                        <button type="button" wire:click.prevent="changeNow" class="btn btn-{{ $stat_btn_style }}" data-dismiss="modal">{{ $stat_btn_txt }}</button>
			                    </div>
			                </div>
			            </div>
			        </div>
			        
			        <div wire:ignore.self class="modal fade" id="deleteSchoolYearModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
			            <div class="modal-dialog" role="document">
			                <div class="modal-content">
			                    <div class="modal-header">
			                        <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
			                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                            <span aria-hidden="true close-btn">×</span>
			                        </button>
			                    </div>
			                    <div class="modal-body">
			                        <p>Are you sure want to delete this school year?</p>
			                    </div>
			                    <div class="modal-footer">
			                        <button wire:click="$emit('resetAllInputs')" type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
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
