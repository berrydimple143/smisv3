<!-- Modal For Create-->
<div wire:ignore.self class="modal fade" id="formUpdateModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
{{--<div wire:ignore.self class="modal fade" id="formUpdateModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">--}}
    <div class="modal-dialog modal-success modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Update Registration</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- ********************************************************************************** -->
                <!-- *** Start: Registration -->
                <!-- ********************************************************************************** -->

                <form wire:submit.prevent="submit" autocomplete="off">
                    <!-- ***************************************** -->
                    <!-- *** Begin: Student Status -->
                    <!-- ***************************************** -->

                    <div class="form-row  mb-3">
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <label>Student Status {!! $requiredlbl !!}</label>
                            <select wire:model.debounce.1s="status" name="status" class="form-control @if($errors->has('status')) is-invalid @endif" required>
                                <option value=''></option>
                                @foreach($listOfStatus as $status)
                                    <option value={{ $status->id }}>{{ $status->description }}</option>
                                @endforeach
                            </select>
                            @error('status') <span class="invalid-feedback">{{ $message }}</span>@enderror
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
                            <label>Last name {!! $requiredlbl !!}</label>
                            <input wire:model.debounce.1s="last_name" type="text" class="form-control @if($errors->has('last_name')) is-invalid @endif" required>
                            @error('last_name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>First name {!! $requiredlbl !!}</label>
                            <input wire:model.debounce.1s="first_name" type="text" class="form-control @if($errors->has('first_name')) is-invalid @endif " required>
                            @error('first_name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Middle name (Optional)</label>
                            <input wire:model.debounce.1s="middle_name" type="text" class="form-control">
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
                            <label>Gender {!! $requiredlbl !!}</label>
                            <select wire:model.debounce.1s="gender" class="form-control @if($errors->has('gender')) is-invalid @endif " required>
                                <option label=""></option>
                                <option label="Male" value="1"></option>
                                <option label="Female" value="2"></option>
                            </select>
                            @error('gender') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-2 mb-3">
                            <label>Civil Status {!! $requiredlbl !!}</label>
                            <select wire:model.debounce.1s="civil_status" class="form-control @if($errors->has('civil_status')) is-invalid @endif " required>
                                <option label=""></option>
                                <option label="Single" value="1"></option>
                                <option label="Married" value="2"></option>
                                <option label="Divorced" value="3"></option>
                                <option label="Separated" value="4"></option>
                                <option label="Widowed" value="5"></option>
                            </select>
                            @error('civil_status') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-2 mb-3">
                            <label>Date of Birth {!! $requiredlbl !!}</label>
                            <input wire:model.debounce.1s="date_of_birth" type="date" class="form-control @if($errors->has('date_of_birth')) is-invalid @endif " format="yyyy-MM-dd" value-format="yyyy-MM-dd" required>
                            @error('date_of_birth') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-2 mb-3">
                            <label>Citizenship {!! $requiredlbl !!}</label>
                            <select wire:model.debounce.1s="citizenship_id" class="form-control @if($errors->has('citizenship_id')) is-invalid @endif " required>
                                <option value=''></option>
                                @foreach($lisOfCitizenship as $citizenship)
                                    <option value={{ $citizenship->id }}>{{ $citizenship->description }}</option>
                                @endforeach
                            </select>
                            @error('citizenship_id') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-2 mb-3">
                            <label>Religion (Optional)</label>
                            <select wire:model.debounce.1s="religion_id" class="form-control">
                                <option value=''></option>
                                @foreach($listOfReligion as $religion)
                                    <option value={{ $religion->id }}>{{ $religion->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label>Blood Type {!! $requiredlbl !!}</label>
                            <select wire:model.debounce.1s="blood_type" class="form-control @if($errors->has('blood_type')) is-invalid @endif " required>
                                <option value=""></option>
                                <option label="O" value="1"></option>
                                <option label="A" value="2"></option>
                                <option label="B" value="3"></option>
                                <option label="AB" value="4"></option>
                            </select>
                            @error('blood_type') <span class="invalid-feedback">{{ $message }}</span>@enderror
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
                            <label>Email {!! $requiredlbl !!}</label>
                            <input wire:model.debounce.1s="email" type="email" class="form-control @if($errors->has('email')) is-invalid @endif " required readonly>
                            @error('email') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Contact {!! $requiredlbl !!}</label>
                            <input wire:model.debounce.1s="contact_number" type="text" class="form-control @if($errors->has('contact_number')) is-invalid @endif " required>
                            @error('contact_number') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-2 mb-3">
                            <label>Height (ft/inch) {!! $requiredlbl !!}</label>
                            <input wire:model.debounce.1s="height" type="text" class="form-control @if($errors->has('height')) is-invalid @endif " required>
                            @error('height') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-2 mb-3">
                            <label>Weight (kg) {!! $requiredlbl !!}</label>
                            <input wire:model.debounce.1s="weight" type="text" class="form-control @if($errors->has('weight')) is-invalid @endif " required>
                            @error('weight') <span class="invalid-feedback">{{ $message }}</span>@enderror
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
                            <label>Current Address {!! $requiredlbl !!}</label>
                            <input wire:model.debounce.1s="current_address" type="text" class="form-control @if($errors->has('current_address')) is-invalid @endif " required>
                            @error('current_address') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Permanent Address {!! $requiredlbl !!}</label>
                            <input wire:model.debounce.1s="permanent_address" type="text" class="form-control @if($errors->has('permanent_address')) is-invalid @endif " required>
                            @error('permanent_address') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                    </div>

                    <!-- ***************************************** -->
                    <!-- *** End: Address -->
                    <!-- ***************************************** -->

                    <!-- ***************************************** -->
                    <!-- *** Begin: Father -->
                    <!-- ***************************************** -->
                    <div class="form-row">
                        <div class="col-md-12 mb-12">
                            <label><font face="Verdana, Geneva, sans-serif" size="+1">Father:</font></label>
                        </div>
                    </div>
                        
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label>First Name {!! $requiredlbl !!}</label>
                            <input wire:model.debounce.1s="father_first_name" type="text" class="form-control @if($errors->has('father_first_name')) is-invalid @endif " required>
                            @error('father_first_name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label>Last Name {!! $requiredlbl !!}</label>
                            <input wire:model.debounce.1s="father_last_name" type="text" class="form-control @if($errors->has('father_last_name')) is-invalid @endif " required>
                            @error('father_last_name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Middle Name (Optional)</label>
                            <input wire:model.debounce.1s="father_middle_name" type="text" class="form-control">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label>Extension (ex. Jr., II, III) (Optional)</label>
                            <input wire:model.debounce.1s="father_ext_name" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-12">
                            <label>Complete Address:</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label>Province {!! $requiredlbl !!}</label>
                            <select wire:model.debounce.1s="father_province" name="father_province" class="form-control @if($errors->has('father_province')) is-invalid @endif" required>
                                <option value=''></option>
                                @foreach($listOfProvinces as $province)
                                    <option value={{ $province->PROVINCE_C }}>{{ $province->PROVINCE }}</option>
                                @endforeach
                            </select>
                            @error('father_province') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>City/Municipality {!! $requiredlbl !!}</label>
                            <select wire:model.debounce.1s="father_municipality" name="father_municipality" class="form-control @if($errors->has('father_municipality')) is-invalid @endif " required>
                                <option value=''></option>
                                @if(!empty($listOfCityMunsFather))
                                    @foreach($listOfCityMunsFather as $fm)
                                        <option value={{ $fm->CITYMUN_C }}>{{ $fm->CITYMUN }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('father_municipality') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Barangay {!! $requiredlbl !!}</label>
                            <select wire:model.debounce.1s="father_barangay" name="father_barangay" class="form-control @if($errors->has('father_barangay')) is-invalid @endif " required>
                                <option value=''></option>
                                @if(!empty($listOfBarangaysFather))
                                    @foreach($listOfBarangaysFather as $br)
                                        <option value={{ $br->Name }}>{{ $br->Name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('father_barangay') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>LotNo./BlkNo./Street (Optional)</label>
                            <input wire:model.debounce.1s="father_street" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label>Occupation (Optional)</label>
                            <input wire:model.debounce.1s="father_occupation" type="text" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Contact Number {!! $requiredlbl !!}</label>
                            <input wire:model.debounce.1s="father_contact" type="text" class="form-control @if($errors->has('father_contact')) is-invalid @endif " required>
                            @error('father_contact') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <!-- ***************************************** -->
                    <!-- *** End: Father -->
                    <!-- ***************************************** -->

                    <!-- ***************************************** -->
                    <!-- *** Begin: Mother -->
                    <!-- ***************************************** -->
                    <div class="form-row">
                        <div class="col-md-12 mb-12">
                            <label><font face="Verdana, Geneva, sans-serif" size="+1">Mother:</font></label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label>First Name {!! $requiredlbl !!}</label>
                            <input wire:model.debounce.1s="mother_first_name" type="text" class="form-control @if($errors->has('mother_first_name')) is-invalid @endif " required>
                            @error('mother_first_name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Last Name {!! $requiredlbl !!}</label>
                            <input wire:model.debounce.1s="mother_last_name" type="text" class="form-control @if($errors->has('mother_last_name')) is-invalid @endif " required>
                            @error('mother_last_name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Middle Name (Optional)</label>
                            <input wire:model.debounce.1s="mother_middle_name" type="text" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Extension (ex. Jr., II, III) (Optional)</label>
                            <input wire:model.debounce.1s="mother_ext_name" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-12">
                            <div class="form-inline">
                                <label>Complete Address: </label>&nbsp;&nbsp;&nbsp;
                                <input wire:model.debounce.1s="fatherAddress" wire:click="$emit('addressClicked')" class="form-check-input" type="checkbox" id="sameAsFatherAddress">
                                <label class="form-check-label" for="sameAsFatherAddress">Same as father</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label>Province {!! $requiredlbl !!}</label>
                            <select wire:model.debounce.1s="mother_province" name="mother_province" class="form-control @if($errors->has('mother_province')) is-invalid @endif" required>
                                <option value=''></option>
                                @foreach($listOfProvinces as $province)
                                    <option value={{ $province->PROVINCE_C }}>{{ $province->PROVINCE }}</option>
                                @endforeach
                            </select>
                            @error('mother_province') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>City/Municipality {!! $requiredlbl !!}</label>
                            <select wire:model.debounce.1s="mother_municipality" name="mother_municipality" class="form-control @if($errors->has('mother_municipality')) is-invalid @endif" required>
                                <option value=''></option>
                                @if(!empty($listOfCityMunsMother))
                                    @foreach($listOfCityMunsMother as $mm)
                                        <option value={{ $mm->CITYMUN_C }}>{{ $mm->CITYMUN }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('mother_municipality') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Barangay {!! $requiredlbl !!}</label>
                            <select wire:model.debounce.1s="mother_barangay" name="mother_barangay" class="form-control @if($errors->has('mother_barangay')) is-invalid @endif " required>
                                <option value=''></option>
                                @if(!empty($listOfBarangaysMother))
                                    @foreach($listOfBarangaysMother as $br)
                                        <option value={{ $br->Name }}>{{ $br->Name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('mother_barangay') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>LotNo./BlkNo./Street (Optional)</label>
                            <input wire:model.debounce.1s="mother_street" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label>Occupation (Optional)</label>
                            <input wire:model.debounce.1s="mother_occupation" type="text" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Contact Number</label>
                            <input wire:model.debounce.1s="mother_contact" type="text" class="form-control @if($errors->has('mother_contact')) is-invalid @endif " required>
                            @error('mother_contact') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <!-- ***************************************** -->
                    <!-- *** End: Mother -->
                    <!-- ***************************************** -->

                    <!-- ***************************************** -->
                    <!-- *** Begin: Guardian -->
                    <!-- ***************************************** -->

                    <div class="form-row">
                        <div class="col-md-12 mb-12">
                            <div class="form-inline">
                                  <label><font face="Verdana, Geneva, sans-serif" size="+1">Guardian:</font></label>&nbsp;&nbsp;&nbsp;
                                  <input wire:model.debounce.1s="fatherDetails" wire:click="$emit('detailsClicked')" id="fatherD" name="fatherDetails" type="radio" value="Father Details" class="form-check-input">
                                  <label class="form-check-label" for="fatherD">Same as father details</label>&nbsp;&nbsp;&nbsp;
                                  <input wire:model.debounce.1s="fatherDetails" wire:click="$emit('detailsClicked')" id="motherD" name="fatherDetails" type="radio" value="Mother Details" class="form-check-input">
                                  <label class="form-check-label" for="motherD">Same as mother details</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label>First Name {!! $requiredlbl !!}</label>
                            <input wire:model.debounce.1s="guardian_first_name" type="text" class="form-control @if($errors->has('guardian_first_name')) is-invalid @endif " required>
                            @error('guardian_first_name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Last Name {!! $requiredlbl !!}</label>
                            <input wire:model.debounce.1s="guardian_last_name" type="text" class="form-control @if($errors->has('guardian_last_name')) is-invalid @endif " required>
                            @error('guardian_last_name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Middle Name (Optional)</label>
                            <input wire:model.debounce.1s="guardian_middle_name" type="text" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Extension (ex. Jr., II, III) (Optional)</label>
                            <input wire:model.debounce.1s="guardian_ext_name" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-12">
                            <label>Complete Address:</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label>Province {!! $requiredlbl !!}</label>
                            <select wire:model.debounce.1s="guardian_province" name="guardian_province" class="form-control @if($errors->has('guardian_province')) is-invalid @endif" required>
                                <option value=''></option>
                                @foreach($listOfProvinces as $province)
                                    <option value={{ $province->PROVINCE_C }}>{{ $province->PROVINCE }}</option>
                                @endforeach
                            </select>
                            @error('guardian_province') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>City/Municipality {!! $requiredlbl !!}</label>
                            <select wire:model.debounce.1s="guardian_municipality" name="guardian_municipality" class="form-control @if($errors->has('guardian_municipality')) is-invalid @endif" required>
                                <option value=''></option>
                                @if(!empty($listOfCityMunsGuardian))
                                    @foreach($listOfCityMunsGuardian as $gm)
                                        <option value={{ $gm->CITYMUN_C }}>{{ $gm->CITYMUN }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('guardian_municipality') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Barangay {!! $requiredlbl !!}</label>
                            <select wire:model.debounce.1s="guardian_barangay" name="guardian_barangay" class="form-control @if($errors->has('guardian_barangay')) is-invalid @endif " required>
                                <option value=''></option>
                                @if(!empty($listOfBarangaysGuardian))
                                    @foreach($listOfBarangaysGuardian as $br)
                                        <option value={{ $br->Name }}>{{ $br->Name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('guardian_barangay') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>LotNo./BlkNo./Street (Optional)</label>
                            <input wire:model.debounce.1s="guardian_street" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label>Occupation (Optional)</label>
                            <input wire:model.debounce.1s="guardian_occupation" type="text" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Contact Number {!! $requiredlbl !!}</label>
                            <input wire:model.debounce.1s="guardian_contact_number" type="text" class="form-control @if($errors->has('guardian_contact_number')) is-invalid @endif " required>
                            @error('guardian_contact_number') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Relationship {!! $requiredlbl !!}</label>
                            <input wire:model.debounce.1s="guardian_relation" type="text" class="form-control @if($errors->has('guardian_relation')) is-invalid @endif " required>
                            @error('guardian_relation') <span class="invalid-feedback">{{ $message }}</span>@enderror
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
                            <label>Learner's Reference Number (Optional)</label>
                            <input wire:model.debounce.1s="lrn" type="text" class="form-control">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Registration Date</label>
                            <input wire:model.debounce.1s="admission_date" type="date" class="form-control" format="yyyy-MM-dd" value-format="yyyy-MM-dd" readonly>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Classifications</label>
                            <select wire:model.lazy="classification" class="form-control" required>
                                <option value=''>Select Classification {{$classification}}</option>
                                @foreach($listOfClassification as $classifications)
                                    <option value={{ $classifications->id }}>{{ $classifications->description }}</option>
                                @endforeach
                            </select>
                            @error('classification') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Level/Program/Course</label>
                            <select wire:model.lazy="course_id" class="form-control" required>
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
                </form>

                <!-- ********************************************************************************** -->
                <!-- *** End: Registration -->
                <!-- ********************************************************************************** -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" wire:click="resetInput" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-secondary" wire:click="resetInput">Reset</button>
                {{--<button type="button" wire:click.prevent="store()" class="btn btn-primary close-modal">Save changes</button>--}}
                <button class="btn btn-primary close-modal px-5"  wire:click="update" wire:loading.attr="disabled" @click="scrollTo({top: 0, behavior: 'smooth'})"><div wire:loading wire:target="update"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div> Update</button>
            </div>
        </div>
    </div>
</div>
