<div wire:ignore.self class="modal fade" id="updateAssessmentModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Summative Assessment - Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">

                <form wire:submit.prevent="submit">
                    
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label>SA1</label>
                            <input wire:model.lazy="SA1" type="text" class="form-control @if($errors->has('SA1')) is-invalid @endif" required>
                            @error('SA1') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>SA2</label>
                            <input wire:model.lazy="SA2" type="text" class="form-control @if($errors->has('SA2')) is-invalid @endif " required>
                            @error('SA2') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>SA3</label>
                            <input wire:model.lazy="SA3" type="text" class="form-control @if($errors->has('SA3')) is-invalid @endif " required>
                            @error('SA3') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>SA4</label>
                            <input wire:model.lazy="SA4" type="text" class="form-control @if($errors->has('SA4')) is-invalid @endif " required>
                            @error('SA4') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label>SA5</label>
                            <input wire:model.lazy="SA5" type="text" class="form-control @if($errors->has('SA5')) is-invalid @endif" required>
                            @error('SA5') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>SA6</label>
                            <input wire:model.lazy="SA6" type="text" class="form-control @if($errors->has('SA6')) is-invalid @endif " required>
                            @error('SA6') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>SA7</label>
                            <input wire:model.lazy="SA7" type="text" class="form-control @if($errors->has('SA7')) is-invalid @endif " required>
                            @error('SA7') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>SA8</label>
                            <input wire:model.lazy="SA8" type="text" class="form-control @if($errors->has('SA8')) is-invalid @endif " required>
                            @error('SA8') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label>Type</label>
                            <input wire:model.lazy="type" type="text" class="form-control @if($errors->has('type')) is-invalid @endif " required>
                            @error('type') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-offset-6 mb-3">&nbsp;</div>
                    </div>
                    
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                <button wire:click.prevent="update" wire:loading.attr="disabled" type="button" class="btn btn-success close-modal px-4"><div wire:loading wire:target="update"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div> Save changes</button>
            </div>
        </div>
    </div>
</div>