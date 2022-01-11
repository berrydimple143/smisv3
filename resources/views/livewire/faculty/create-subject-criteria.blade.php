<div wire:ignore.self class="modal fade" id="addSubjectCriteriaModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Subject Criteria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>                    
                    <input wire:model="course_id" type="hidden" value="{{ $course_id }}">
                    <input wire:model="subject_id" type="hidden" value="{{ $subject_id }}">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Description:</label>
                            <input wire:model.lazy="description" type="text" class="form-control @if($errors->has('description')) is-invalid @endif" required>
                            @error('description') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>                        
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Criteria</label>
                            <select wire:model.lazy="criteria_id" class="form-control @if($errors->has('criteria_id')) is-invalid @endif" required>
                                <option value="">Select a criteria here ...</option>
                                @foreach($listOfCriteria as $crt)
			                        <option value="{{ $crt->id }}">{{ $crt->description }}</option>
			                    @endforeach
                            </select>
                            @error('criteria_id') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button wire:click="$emit('resetInputs')" type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                <button wire:click.prevent="store" wire:loading.attr="disabled" type="button" class="btn btn-success px-4"><div wire:loading wire:target="store"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div> Add Now</button>
            </div>
        </div>
    </div>
</div>
