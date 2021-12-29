<div wire:ignore.self class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">User Editor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">

                <form>                    
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>First Name</label>
                            <input wire:model.lazy="first_name" type="text" class="form-control @if($errors->has('first_name')) is-invalid @endif" required>
                            @error('first_name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>  
                    </div>
                    <div class="form-row">  
                        <div class="col-md-12 mb-3">
                            <label>Last Name</label>
                            <input wire:model.lazy="last_name" type="text" class="form-control @if($errors->has('last_name')) is-invalid @endif" required>
                            @error('last_name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>                      
                    </div>         
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Email Address</label>
                            <input wire:model.lazy="email" type="text" class="form-control @if($errors->has('email')) is-invalid @endif" required readonly>
                            @error('email') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>  
                    </div>  
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Mobile (Optional)</label>
                            <input wire:model.lazy="mobile" type="text" class="form-control @if($errors->has('mobile')) is-invalid @endif">
                            @error('mobile') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>  
                    </div>  
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Type</label>
                            <input wire:model.lazy="type" type="text" class="form-control @if($errors->has('type')) is-invalid @endif">
                            @error('type') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>  
                    </div>  
                </form>

            </div>
            <div class="modal-footer">
                <button wire:click="$emit('resetAllInputs')" type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                <button wire:click.prevent="update" wire:loading.attr="disabled" type="button" class="btn btn-success px-4" data-dismiss="modal"><div wire:loading wire:target="update"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div> Save changes</button>
            </div>
        </div>
    </div>
</div>