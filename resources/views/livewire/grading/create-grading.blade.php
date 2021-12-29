<div wire:ignore.self class="modal fade" id="addGradingModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Grading System Creator</h5>
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
                                <option value=''>Select a teacher here ...</option>
                                @foreach($listOfTeachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->last_name.", ".$teacher->first_name }}</option>
                                @endforeach
                            </select>
                            @error('user_id') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Course</label>
                            <select wire:model.lazy="course_id" class="form-control" required>
                                <option value=''>Select a course here ...</option>
                                @foreach($listOfCourses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                            @error('course_id') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>                                     
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label>Section</label>
                            <select wire:model.lazy="section_id" class="form-control" required>
                                <option value=''>Select a section here ...</option>
                                @foreach($listOfSections as $section)
                                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                                @endforeach
                            </select>
                            @error('section_id') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Subject</label>
                            <select wire:model.lazy="subject_id" class="form-control" required>
                                <option value=''>Select a subject here ...</option>
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
                <button wire:click.prevent="store" wire:loading.attr="disabled" type="button" class="btn btn-success px-4" data-dismiss="modal"><div wire:loading wire:target="store"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div> Create</button>
            </div>
        </div>
    </div>
</div>