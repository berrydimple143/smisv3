<div wire:ignore.self class="modal fade" id="addGradingCriteriaModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Grade Criteria Creator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input wire:model="grading_system_id" type="hidden" id="grading_system_id" value="{{ $grading_system_id }}">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Criteria</label>
                            <select wire:model.lazy="criteria_id" class="form-control" required>
                                <option value=''>Select Criteria Here</option>
                                @foreach($listOfCriteria as $crt)
                                    <option value="{{ $crt->id }}">{{ $crt->description }}</option>
                                @endforeach
                            </select>
                            @error('criteria_id') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>                            
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Percentage (%)</label>
                            <input wire:model.lazy="percent" type="text" class="form-control @if($errors->has('percent')) is-invalid @endif" required>
                            @error('percent') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>                     
                        <div class="col-md-6 mb-3">&nbsp;</div>                
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button wire:click="$emit('resetAllInputs')" type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                <button wire:click.prevent="store" wire:loading.attr="disabled" type="button" class="btn btn-success px-4" data-dismiss="modal"><div wire:loading wire:target="store"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div> Create</button>
            </div>
        </div>
    </div>
</div>