<div wire:ignore.self class="modal fade" id="editSectionModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Section Editor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">

                <form>                    
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label>Teacher</label>
                            <select wire:model.lazy="user_id" class="form-control" required>
                                <option value=''>Select Teacher</option>
                                @foreach($listOfTeachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->first_name." ".$teacher->last_name }}</option>
                                @endforeach
                            </select>
                            @error('user_id') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Subject</label>
                            <select wire:model.lazy="offered_subject_id" class="form-control" required>
                                <option value=''>Select Subject</option>
                                @foreach($listOfSubjects as $subject)
                                    <?php
                                        $lvl = App\Models\Course::where('id', $subject->course_id)->first();
                                        $gradeName = $subject->description . " for " . $lvl->name;
                                    ?>
                                    <option value="{{ $subject->id }}">{{ $gradeName }}</option>
                                @endforeach
                            </select>
                            @error('offered_subject_id') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>         
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label>Section Name</label>
                            <input wire:model.lazy="name" type="text" class="form-control @if($errors->has('name')) is-invalid @endif" required>
                            @error('name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>                        
                        <div class="col-md-6 mb-3">
                            <label>Grading System</label>
                            <select wire:model.lazy="grading_system_id" class="form-control" required>
                                <option value=''>Select Grading System</option>
                                @foreach($listOfGradingSystems as $system)
                                    <option value="{{ $system->id }}">{{ $system->type }}</option>
                                @endforeach
                            </select>
                            @error('grading_system_id') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>                                        
                    </div>                  
                    <div class="form-row">                        
                        <div class="col-md-6 mb-3">
                            <label>Student Limit (Optional)</label>
                            <input wire:model.lazy="student_limit" type="text" class="form-control @if($errors->has('student_limit')) is-invalid @endif">
                            @error('student_limit') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Color (Optional)</label>
                            <input wire:model.lazy="color" type="text" class="form-control @if($errors->has('color')) is-invalid @endif">
                            @error('color') <span class="invalid-feedback">{{ $message }}</span>@enderror
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