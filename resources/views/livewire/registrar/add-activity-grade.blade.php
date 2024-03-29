<div wire:ignore.self class="modal fade" id="addActivityGradeModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">{{ $activity_name }} Grade - Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">

                <form>                    
                    <input wire:model="section_id" type="hidden" id="section_id" value="{{ $section_id }}">
                    <input wire:model="subject_id" type="hidden" id="subject_id" value="{{ $subject_id }}">
                    <input wire:model="student_id" type="hidden" id="student_id" value="{{ $student_id }}">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>{{ $activity_name }} Number:</label>
                            <input wire:model.lazy="activity_number" type="text" class="form-control @if($errors->has('activity_number')) is-invalid @endif" required>
                            @error('activity_number') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>                        
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Item</label>
                            <input wire:model.lazy="item" type="text" class="form-control @if($errors->has('item')) is-invalid @endif" required>
                            @error('item') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>                        
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Score</label>
                            <input wire:model.lazy="score" type="text" class="form-control @if($errors->has('score')) is-invalid @endif" required>
                            @error('score') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>                        
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button wire:click="$emit('resetAllInputs')" type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                <button wire:click.prevent="store" wire:loading.attr="disabled" type="button" class="btn btn-success px-4" data-dismiss="modal"><div wire:loading wire:target="store"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div> Add Now</button>
            </div>
        </div>
    </div>
</div>