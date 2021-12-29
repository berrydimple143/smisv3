<!-- Modal For Create-->
<div wire:ignore.self class="modal fade" id="formShowModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-success modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">View Registration Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- ********************************************************************************** -->
                <!-- *** Start: Registration -->
                <!-- ********************************************************************************** -->

                    <!-- ***************************************** -->
                    <!-- *** Begin: Student Status -->
                    <!-- ***************************************** -->

                    <div class="form-row  mb-3">
                        <div class="col-2">
                            <label>Student Status</label>
                            <select wire:model="status" name="status" class="form-control" disabled>
                                <option value=''>Student Status</option>
                                @foreach($listOfStatus as $status)
                                    <option value={{ $status->id }}>{{ $status->description }}</option>
                                @endforeach
                            </select>
                            @error('status') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <!-- ***************************************** -->
                    <!-- *** End: Student Status -->
                    <!-- ***************************************** -->

                    <!-- ***************************************** -->
                    <!-- *** Begin: Name -->
                    <!-- ***************************************** -->

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label>Last name</label>
                            <input wire:model="last_name" type="text" class="form-control" placeholder="Last name" disabled>
                            @error('last_name') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>First name</label>
                            <input wire:model="first_name" type="text" class="form-control" placeholder="First name" disabled>
                            <div class="invalid-tooltip">
                                First Name is Empty!
                            </div>
                            @error('first_name') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Middle name</label>
                            <input wire:model="middle_name" type="text" class="form-control" placeholder="Middle name" disabled>
                            @error('middle_name') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <!-- ***************************************** -->
                    <!-- *** End: Name -->
                    <!-- ***************************************** -->

                    <!-- ***************************************** -->
                    <!-- *** Begin: Gender, Date of Birth, Citizenship, Religion, Blood Type -->
                    <!-- ***************************************** -->

                    <div class="form-row">

                        <div class="col-md-2 mb-3">
                            <label>Gender</label>
                            <select wire:model="gender" class="form-control" placeholder="Gender" disabled>
                                <option label="Male" value="1"></option>
                                <option label="Female" value="2"></option>
                            </select>
                            @error('gender') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-2 mb-3">
                            <label>Civil Status</label>
                            <select wire:model="civil_status" class="form-control" placeholder="Civil Status" disabled>
                                <option label="Single" value="1"></option>
                                <option label="Married" value="2"></option>
                                <option label="Divorced" value="3"></option>
                                <option label="Separated" value="4"></option>
                                <option label="Widowed" value="5"></option>
                            </select>
                            @error('civil_status') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-2 mb-3">
                            <label>Date of Birth</label>
                            <input wire:model="date_of_birth" type="date" class="form-control" format="yyyy-MM-dd" value-format="yyyy-MM-dd" disabled>
                            @error('date_of_birth') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-2 mb-3">
                            <label>Citizenship</label>
                            <select wire:model="citizenship_id" class="form-control" disabled>
                                <option value=''>Select Citizenship</option>
                                @foreach($lisOfCitizenship as $citizenship)
                                    <option value={{ $citizenship->id }}>{{ $citizenship->description }}</option>
                                @endforeach
                            </select>
                            @error('citizenship_id') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-2 mb-3">
                            <label>Religion</label>
                            <select wire:model="religion_id" placeholder="Religion" class="form-control" disabled>
                                <option value=''>Select Religion</option>
                                @foreach($listOfReligion as $religion)
                                    <option value={{ $religion->id }}>{{ $religion->description }}</option>
                                @endforeach
                            </select>
                            @error('religion_id') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-2 mb-3">
                            <label>Blood Type</label>
                            <select wire:model="blood_type" class="form-control" placeholder="Blood Type" disabled>
                                <option label="O" value="1"></option>
                                <option label="A" value="2"></option>
                                <option label="B" value="3"></option>
                                <option label="AB" value="4"></option>
                            </select>
                            @error('blood_type') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                    </div>

                    <!-- ***************************************** -->
                    <!-- *** End: Gender, Date of Birth, Citizenship, Religion, Blood Type -->
                    <!-- ***************************************** -->

                    <!-- ***************************************** -->
                    <!-- *** Begin: Email, Contact, Height, Weight -->
                    <!-- ***************************************** -->

                    <div class="form-row">

                        <div class="col-md-4 mb-3">
                            <label>Email</label>
                            <input wire:model="email" type="email" class="form-control" placeholder="Email" disabled>
                            @error('email') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Contact</label>
                            <input wire:model="contact_number" type="number" class="form-control" placeholder="Contact" disabled>
                            @error('contact_number') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-2 mb-3">
                            <label>Height</label>
                            <input wire:model="height" type="number" class="form-control" placeholder="Height" disabled>
                            @error('height') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-2 mb-3">
                            <label>Weight</label>
                            <input wire:model="weight" type="number" class="form-control" placeholder="Weight" disabled>
                            @error('weight') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                    </div>

                    <!-- ***************************************** -->
                    <!-- *** End: Email, Contact, Height, Weight -->
                    <!-- ***************************************** -->

                    <!-- ***************************************** -->
                    <!-- *** Begin: Address -->
                    <!-- ***************************************** -->

                    <div class="form-row">

                        <div class="col-md-6 mb-3">
                            <label>Current Address</label>
                            <input wire:model="current_address" type="text" class="form-control" placeholder="Current Address" disabled>
                            @error('current_address') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Permanent Address</label>
                            <input wire:model="permanent_address" type="text" class="form-control" placeholder="Permanent Address" disabled>
                            @error('permanent_address') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                    </div>

                    <!-- ***************************************** -->
                    <!-- *** End: Address -->
                    <!-- ***************************************** -->

                    <!-- ***************************************** -->
                    <!-- *** Begin: Father -->
                    <!-- ***************************************** -->

                    <div class="form-row">

                        <div class="col-md-3 mb-3">
                            <label>Father Last name</label>
                            <input wire:model="father_last_name" type="text" class="form-control" placeholder="Last name" disabled>
                            @error('father_last_name') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Father First name</label>
                            <input wire:model="father_first_name" type="text" class="form-control" placeholder="First name" disabled>
                            @error('father_first_name') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Father Middle name</label>
                            <input wire:model="father_middle_name" type="text" class="form-control" placeholder="Middle name" disabled>
                            @error('father_middle_name') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Father Occupation</label>
                            <input wire:model="father_occupation" type="text" class="form-control" placeholder="Occupation" disabled>
                            @error('father_occupation') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                    </div>

                    <!-- ***************************************** -->
                    <!-- *** End: Father -->
                    <!-- ***************************************** -->

                    <!-- ***************************************** -->
                    <!-- *** Begin: Mother -->
                    <!-- ***************************************** -->

                    <div class="form-row">

                        <div class="col-md-3 mb-3">
                            <label>Mother Last name</label>
                            <input wire:model="mother_last_name" type="text" class="form-control" placeholder="Last name" disabled>
                            @error('mother_last_name') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Mother First name</label>
                            <input wire:model="mother_first_name" type="text" class="form-control" placeholder="First name" disabled>
                            @error('mother_first_name') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Mother Middle name</label>
                            <input wire:model="mother_middle_name" type="text" class="form-control" placeholder="Middle name" disabled>
                            @error('mother_middle_name') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Mother Occupation</label>
                            <input wire:model="mother_occupation" type="text" class="form-control" placeholder="Occupation" disabled>
                            @error('mother_occupation') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                    </div>

                    <!-- ***************************************** -->
                    <!-- *** End: Mother -->
                    <!-- ***************************************** -->

                    <!-- ***************************************** -->
                    <!-- *** Begin: Guardian -->
                    <!-- ***************************************** -->

                    <div class="form-row">

                        <div class="col-md-3 mb-3">
                            <label>Guardian Last name</label>
                            <input wire:model="guardian_last_name" type="text" class="form-control" placeholder="Last name" disabled>
                            @error('guardian_last_name') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Guardian First name</label>
                            <input wire:model="guardian_first_name" type="text" class="form-control" placeholder="First name" disabled>
                            @error('guardian_first_name') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Guardian Middle name</label>
                            <input wire:model="guardian_middle_name" type="text" class="form-control" placeholder="Middle name" disabled>
                            @error('guardian_middle_name') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Guardian Relation</label>
                            <input wire:model="guardian_relation" type="text" class="form-control" placeholder="Relation" disabled>
                            @error('guardian_relation') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Guardian Contact</label>
                            <input wire:model="guardian_contact_number" type="number" class="form-control" placeholder="Contact" disabled>
                            @error('guardian_contact_number') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-9 mb-3">
                            <label>Guardian Address</label>
                            <input wire:model="guardian_address" type="text" class="form-control" placeholder="Address" disabled>
                            @error('guardian_address') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                    </div>

                    <!-- ***************************************** -->
                    <!-- *** End: Guardian -->
                    <!-- ***************************************** -->

                    <!-- ***************************************** -->
                    <!-- *** Begin: Others -->
                    <!-- ***************************************** -->

                    <div class="form-row">

                        <div class="col-md-3 mb-3">
                            <label>Learner's Reference Number</label>
                            <input wire:model="lrn" type="text" class="form-control" placeholder="Learner's Reference Number" disabled>
                            @error('lrn') <span class="text-danger error">{{ $message }}</span>@enderror
                            <div class="invalid-tooltip">
                                Citizenship is Empty!
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Admission Date</label>
                            <input wire:model="admission_date" type="date" class="form-control" format="yyyy-MM-dd" value-format="yyyy-MM-dd" disabled>
                            @error('admission_date') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Classifications</label>
                            <select wire:model="classification" class="form-control" disabled>
                                <option value=''>Select Classification {{$classification}}</option>
                                @foreach($listOfClassification as $classifications)
                                    <option value={{ $classifications->id }}>{{ $classifications->description }}</option>
                                @endforeach
                            </select>
                            @error('classification') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Level/Program/Course</label>
                            <select wire:model="course_id" class="form-control" disabled>
                                <option value=''>Select Course</option>
                                @if(!empty($listOfCourse))
                                    @foreach($listOfCourse as $course)
                                        <option value={{ $course->id }}>{{ $course->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('course_id') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                    </div>

                    <!-- ***************************************** -->
                    <!-- *** End: Others -->
                    <!-- ***************************************** -->

                <!-- ********************************************************************************** -->
                <!-- *** End: Registration -->
                <!-- ********************************************************************************** -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn px-5" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
