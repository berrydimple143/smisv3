<div wire:ignore.self class="modal fade" id="addSubjectModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Subject Creator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>                  
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Classification</label>
                            <select wire:model.lazy="classification" class="form-control" required>
                                <option value=''>Select Classification</option>
                                @foreach($listOfClassifications as $classif)
                                    <option value="{{ $classif->id }}">{{ $classif->description }}</option>
                                @endforeach
                            </select>
                            @error('classification') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>                        
                    </div>                 
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Code (Optional)</label>
                            <input wire:model.lazy="code" type="text" class="form-control @if($errors->has('code')) is-invalid @endif">
                            @error('code') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Description</label>
                            <input wire:model.lazy="description" type="text" class="form-control @if($errors->has('description')) is-invalid @endif " required>
                            @error('description') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>                                        
                    </div>
                    @if($showInputs)                    
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label>Lecture Unit (Optional)</label>
                                <input wire:model.lazy="lec_unit" type="text" class="form-control @if($errors->has('lec_unit')) is-invalid @endif">
                                @error('lec_unit') <span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label>Lab Unit (Optional)</label>
                                <input wire:model.lazy="lab_unit" type="text" class="form-control @if($errors->has('lab_unit')) is-invalid @endif">
                                @error('lab_unit') <span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>                                        
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label>Pre-requisite Subject</label>
                                <input wire:model.lazy="pre_requisite_subject_id" type="text" class="form-control @if($errors->has('pre_requisite_subject_id')) is-invalid @endif">
                                @error('pre_requisite_subject_id') <span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>                                                                  
                        </div>
                    @endif
                </form>
            </div>
            <div class="modal-footer">
                <button wire:click="$emit('resetAllInputs')" type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                <button wire:click.prevent="store" wire:loading.attr="disabled" type="button" class="btn btn-success px-4" data-dismiss="modal"><div wire:loading wire:target="store"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div> Create</button>
            </div>
        </div>
    </div>
</div>