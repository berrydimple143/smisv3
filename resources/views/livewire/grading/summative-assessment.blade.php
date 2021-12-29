<div class="container-fluid">
    <div class="row">
        <div class="col">
        	@include('livewire.grading.create-assessment')
        	@include('livewire.grading.update-assessment')

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
			    <div class="card-header">Summative Assessment
			        <div class="card-header-actions">
			            <a class="card-header-action btn-setting" href="#" data-toggle="modal" data-target="#AddAssessmentModal">
			                <i class="c-icon cil-pen-alt c-sidebar-nav-icon"></i> Assessment
			            </a>
			        </div>
			    </div>
			    <div class="card-body">
			        <div class="table-responsive">
			            <table class="table table-sm">
			                <thead>
			                <tr>
			                    <th style="color: white;" nowrap>Type</th>
			                    <th style="color: white;" nowrap>SA1</th>
			                    <th style="color: white;" nowrap>SA2</th>
			                    <th style="color: white;" nowrap>SA3</th>
			                    <th style="color: white;" nowrap>SA4</th>
			                    <th style="color: white;" nowrap>SA5</th>
			                    <th style="color: white;" nowrap>SA6</th>
			                    <th style="color: white;" nowrap>SA7</th>
			                    <th style="color: white;" nowrap>SA8</th>
			                    <th style="color: white;" nowrap>TOTAL</th>
			                    <th style="width: 150px; text-align: center; color: white;" nowrap>Action</th>
			                </tr>
			                </thead>
			                <tbody>
			                    @foreach($assessments as $assessment)
			                    	<?php $sum = (int)$assessment->SA1 + (int)$assessment->SA2 + (int)$assessment->SA3 + (int)$assessment->SA5 + (int)$assessment->SA6 + (int)$assessment->SA7 + (int)$assessment->SA8 + (int)$assessment->SA4; ?>
			                        <tr>
			                            <td>{{ $assessment->type }}</td>
			                            <td>{{ $assessment->SA1 }}</td>
			                            <td>{{ $assessment->SA2 }}</td>
			                            <td>{{ $assessment->SA3 }}</td>
			                            <td>{{ $assessment->SA4 }}</td>
			                            <td>{{ $assessment->SA5 }}</td>
			                            <td>{{ $assessment->SA6 }}</td>
			                            <td>{{ $assessment->SA7 }}</td>
			                            <td>{{ $assessment->SA8 }}</td>
			                            <td>{{ $sum }}</td>
			                            <td>
			                                <button type="button" wire:click="edit({{ $assessment->id }})" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#updateAssessmentModal"><i class="cil-pencil"></i>&nbsp;Edit</button>
			                                <button type="button" wire:click="deleteThisId({{ $assessment->id }})" data-toggle="modal" data-target="#deleteAssessmentModal" class="btn btn-sm btn-danger"><i class="cil-trash"></i>&nbsp;Delete</button>			                                
			                            </td>
			                        </tr>
			                    @endforeach
			                </tbody>
			            </table>
			            {!! $assessments->links() !!}
			        </div>		        
			        
			        <div wire:ignore.self class="modal fade" id="deleteAssessmentModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
			            <div class="modal-dialog" role="document">
			                <div class="modal-content">
			                    <div class="modal-header">
			                        <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
			                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                            <span aria-hidden="true close-btn">×</span>
			                        </button>
			                    </div>
			                    <div class="modal-body">
			                        <p>Are you sure want to delete?</p>
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
