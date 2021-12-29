<div wire:ignore.self class="modal fade" id="addSectionModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Section - Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">

                <form>                            
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Section Name</label>
                            <select wire:model.lazy="section_id" class="form-control" required>
                                <option value=''>Select section here ...</option>
                                @foreach($listOfSections as $section)                                    
                                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                                @endforeach
                            </select>
                            @error('section_id') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>                        
                    </div> 
                </form>

            </div>
            <div class="modal-footer">
                <button wire:click="$emit('resetAllInputs')" type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                <button wire:click.prevent="storeSection" wire:loading.attr="disabled" type="button" class="btn btn-success px-4" data-dismiss="modal"><div wire:loading wire:target="storeSection"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div> Add Now</button>
            </div>
        </div>
    </div>
</div>