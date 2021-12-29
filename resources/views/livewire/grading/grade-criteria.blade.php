<div class="container-fluid">
    <div class="row">
        <div class="col">       
        	@include('livewire.grading.create-grade-criteria') 	
        	@include('livewire.grading.update-grade-criteria')
            
            <div class="card card-accent-success">	
            	<div class="card-header">List of Grading Criteria for {{ $gradingType }}
			        <div class="card-header-actions">
			            <a class="card-header-action btn-setting" href="#" data-toggle="modal" data-target="#addGradingCriteriaModal">
			                <i class="c-icon cil-pen-alt c-sidebar-nav-icon"></i> Add Grade Criteria
			            </a>
			        </div>
			    </div>		    
			    <div class="card-body">			    	
			        <div class="table-responsive">
			            <table class="table table-sm">
			                <thead>
			                <tr>		                    
			                    <th style="color: white;" nowrap>Criteria</th>			                    
			                    <th style="color: white;" nowrap>Grading Type</th>
			                    <th style="color: white; text-align: center;" nowrap>Percentage (%)</th>	                  
			                    <th style="width: 150px; text-align: center; color: white;" nowrap>Action</th>
			                </tr>
			                </thead>
			                <tbody>
			                    @forelse($gradecriteria as $grading)	
			                    <?php
			                    	$cr = App\Models\Criteria::where('id', $grading->criteria_id)->first();
			                    	$grs = App\Models\GradingSystem::where('id', $grading->grading_system_id)->first();
			                    ?>	                    
		                        <tr>				                        
		                            <td>{{ $cr->description }}</td>		                            
		                            <td>{{ $grs->type }}</td>     
		                            <td style="text-align: center;">{{ $grading->percent }}</td>                       
		                            <td>
		                                <button type="button" wire:click="edit({{ $grading->id }})" class="btn btn-sm btn-success" data-toggle="modal" data-target="#editGradeCriteriaModal"><i class="cil-pencil"></i>&nbsp;Edit</button>
		                                <button type="button" wire:click="deleteThisId({{ $grading->id }})" data-toggle="modal" data-target="#deleteGradingCriteriaModal" class="btn btn-sm btn-danger"><i class="cil-trash"></i>&nbsp;Delete</button>		                                       
		                            </td>
		                        </tr>		
		                        @empty
		                        <tr><td>No grade criteria yet ...</td></tr>	                    			                        
			                    @endforelse
			                </tbody>
			            </table>
			            {!! $gradecriteria->links() !!}
			        </div>					        
			        
			        <div wire:ignore.self class="modal fade" id="deleteGradingCriteriaModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
			            <div class="modal-dialog" role="document">
			                <div class="modal-content">
			                    <div class="modal-header">
			                        <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
			                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                            <span aria-hidden="true close-btn">×</span>
			                        </button>
			                    </div>
			                    <div class="modal-body">
			                        <p>Are you sure want to delete this grade criteria?</p>
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
