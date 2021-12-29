<div wire:ignore.self class="modal fade" id="addPermissionModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Permission Creator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>                    
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Name</label>
                            <input wire:model.lazy="name" type="text" class="form-control @if($errors->has('name')) is-invalid @endif" required>
                            @error('name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>  
                    </div>
                    <div class="form-row">  
                        <div class="col-md-12 mb-3">
                            <label>Title (Optional)</label>
                            <input wire:model.lazy="title" type="text" class="form-control @if($errors->has('title')) is-invalid @endif">
                            @error('title') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>                      
                    </div>         
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Guard</label>
                            <input wire:model.lazy="guard_name" type="text" class="form-control @if($errors->has('guard_name')) is-invalid @endif" required>
                            @error('guard_name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>  
                    </div>  
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Module</label>
                            <input wire:model.lazy="module" type="text" class="form-control @if($errors->has('module')) is-invalid @endif" required>
                            @error('module') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>  
                    </div>  
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Description (Optional)</label>
                            <textarea wire:model.lazy="description" type="textarea" class="form-control @if($errors->has('description')) is-invalid @endif"></textarea>
                            @error('description') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>                      
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