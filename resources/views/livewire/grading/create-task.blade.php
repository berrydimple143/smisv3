<div wire:ignore.self class="modal fade" id="AddTaskModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Performance Task - Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>                    
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label>MT1</label>
                            <input wire:model="MT1" type="text" class="form-control @if($errors->has('MT1')) is-invalid @endif" required>
                            @error('MT1') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>MT2</label>
                            <input wire:model="MT2" type="text" class="form-control @if($errors->has('MT2')) is-invalid @endif" required>
                            @error('MT2') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>                                            
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label>MT3</label>
                            <input wire:model="MT3" type="text" class="form-control @if($errors->has('MT3')) is-invalid @endif " required>
                            @error('MT3') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>    
                        <div class="col-md-6 mb-3">
                            <label>PT</label>
                            <input wire:model="PT" type="text" class="form-control @if($errors->has('PT')) is-invalid @endif " required>
                            @error('PT') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>                        
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label>Type</label>
                            <input wire:model="type" type="text" class="form-control @if($errors->has('type')) is-invalid @endif " required>
                            @error('type') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>    
                    </div>                                  
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                <button wire:click.prevent="store" wire:loading.attr="disabled" type="button" class="btn btn-success px-4" data-dismiss="modal"><div wire:loading wire:target="store"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div> Create</button>
            </div>
        </div>
    </div>
</div>