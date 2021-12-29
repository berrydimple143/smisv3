<div wire:ignore.self class="modal fade" id="removeUserRoleModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">User Role - Remove</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>                    
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Role</label>
                            <select wire:model.lazy="role2" class="form-control" required>
                                <option value=''>Select role to remove from here ...</option>
                                @if(!empty($listOfRolesToRemove))
                                    @foreach($listOfRolesToRemove as $rl)
                                        <option value="{{ $rl}}">{{ $rl }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('role2') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>  
                    </div>                    
                </form>
            </div>
            <div class="modal-footer">
                <button wire:click="$emit('resetAllInputs')" type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                <button wire:click.prevent="removeRoleNow" wire:loading.attr="disabled" type="button" class="btn btn-success px-4" data-dismiss="modal"><div wire:loading wire:target="removeRoleNow"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div> Remove Now</button>
            </div>
        </div>
    </div>
</div>