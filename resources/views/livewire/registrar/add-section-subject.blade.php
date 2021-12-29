<div wire:ignore.self class="modal fade" id="addSectionSubjectModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Section Subject - Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">

                <form>                    
                    <input wire:model="section_id" type="hidden" id="section_id" value="{{ $section_id }}">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Subject</label>
                            <select wire:model.lazy="subject_id" class="form-control" required>
                                <option value=''>Select Student Here</option>
                                @foreach($listOfSubjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->description }}</option>
                                @endforeach
                            </select>
                            @error('subject_id') <span class="text-danger error">{{ $message }}</span>@enderror
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