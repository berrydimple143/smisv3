<!-- Modal For Create-->
<div
    x-data="{
        guardianInfo: '',
        fatherFname: '',
        fatherLname: '',
        fatherMname: '',
        fatherXname: '',
        fatherProvince: '',
        fatherCity: '',
        fatherBarangay: '',
        fatherStreet: '',
        fatherOccupation: '',
        fatherContact: '',
        motherFname: '',
        motherLname: '',
        motherMname: '',
        motherXname: '',
        motherProvince: '',
        motherCity: '',
        motherBarangay: '',
        motherStreet: '',
        motherOccupation: '',
        motherContact: '',
        guardianFname: '',
        guardianLname: '',
        guardianMname: '',
        guardianXname: '',
        guardianProvince: '',
        guardianCity: '',
        guardianBarangay: '',
        guardianStreet: '',
        guardianOccupation: '',
        guardianContact: '',
        guardianRelation: '',
        
        changeGuardianInfo () {
            if(this.guardianInfo == 'father') {
                this.guardianFname = this.fatherFname;
                this.guardianLname = this.fatherLname;
                this.guardianMname = this.fatherMname;
                this.guardianXname = this.fatherXname;
                this.guardianProvince = this.fatherProvince;
                this.guardianCity = this.fatherCity;
                this.guardianBarangay = this.fatherBarangay;
                this.guardianStreet = this.fatherStreet;
                this.guardianOccupation = this.fatherOccupation;
                this.guardianContact = this.fatherContact;
                this.guardianRelation = 'Father';
            } else if(this.guardianInfo == 'mother') {
                this.guardianFname = this.motherFname;
                this.guardianLname = this.motherLname;
                this.guardianMname = this.motherMname;
                this.guardianXname = this.motherXname;
                this.guardianProvince = this.motherProvince;
                this.guardianCity = this.motherCity;
                this.guardianBarangay = this.motherBarangay;
                this.guardianStreet = this.motherStreet;
                this.guardianOccupation = this.motherOccupation;
                this.guardianContact = this.motherContact;
                this.guardianRelation = 'Mother';
            }
        }
    }"
wire:ignore.self class="modal fade" id="formCreateModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Registration</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- ********************************************************************************** -->
                <!-- *** Start: Registration -->
                <!-- ********************************************************************************** -->

                <form wire:submit.prevent="submit">
                    <!-- ***************************************** -->
                    <!-- *** Begin: Student Status -->
                    <!-- ***************************************** -->

                    <div class="form-row  mb-3">
                        <div class="col-md-4 mb-3">
                            <label>Student Status {!! $requiredlbl !!}</label>
                            <select wire:model.lazy="status" name="status" class="form-control @if($errors->has('status')) is-invalid @endif" required>
                                <option value=''></option>
                                @foreach($listOfStatus as $status)
                                    <option value={{ $status->id }}>{{ $status->description }}</option>
                                @endforeach
                            </select>
                            @error('status') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        
                        @if($showStudentNo)
                            <div class="col-md-4 mb-3">
                                <label>Student Number {!! $requiredlbl !!} (yyyy-xxxxxx)</label>
                                <input wire:model.lazy="student_number" type="text" class="form-control">
                            </div>
                        @endif
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
                            <input wire:model.lazy="last_name" type="text" class="form-control @if($errors->has('last_name')) is-invalid @endif" required>
                            @error('last_name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>First name {!! $requiredlbl !!}</label>
                            <input wire:model.lazy="first_name" type="text" class="form-control @if($errors->has('first_name')) is-invalid @endif " required>
                            @error('first_name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Middle name (Optional)</label>
                            <input wire:model.lazy="middle_name" type="text" class="form-control">
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
                            <select wire:model.lazy="gender" class="form-control @if($errors->has('gender')) is-invalid @endif " required>
                                <option label=""></option>
                                <option label="Male" value="1"></option>
                                <option label="Female" value="2"></option>
                            </select>
                            @error('gender') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-2 mb-3">
                            <label>Civil Status {!! $requiredlbl !!}</label>
                            <select wire:model.lazy="civil_status" class="form-control @if($errors->has('civil_status')) is-invalid @endif " required>
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
                            <input wire:model.lazy="date_of_birth" type="date" class="form-control @if($errors->has('date_of_birth')) is-invalid @endif " format="yyyy-MM-dd" value-format="yyyy-MM-dd" required>
                            @error('date_of_birth') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-2 mb-3">
                            <label>Citizenship {!! $requiredlbl !!}</label>
                            <select wire:model.lazy="citizenship_id" class="form-control @if($errors->has('citizenship_id')) is-invalid @endif " required>
                                <option value=''></option>
                                @foreach($lisOfCitizenship as $citizenship)
                                    <option value={{ $citizenship->id }}>{{ $citizenship->description }}</option>
                                @endforeach
                            </select>
                            @error('citizenship_id') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-2 mb-3">
                            <label>Religion (Optional)</label>
                            <select wire:model.lazy="religion_id" class="form-control">
                                <option value=''></option>
                                @foreach($listOfReligion as $religion)
                                    <option value={{ $religion->id }}>{{ $religion->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label>Blood Type (Optional)</label>
                            <select wire:model.lazy="blood_type" class="form-control">
                                <option value=""></option>
                                <option label="O" value="1"></option>
                                <option label="A" value="2"></option>
                                <option label="B" value="3"></option>
                                <option label="AB" value="4"></option>
                            </select>
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
                            <input wire:model.lazy="email" type="email" class="form-control @if($errors->has('email')) is-invalid @endif " required>
                            @error('email') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Contact {!! $requiredlbl !!}</label>
                            <input wire:model.lazy="contact_number" type="text" class="form-control @if($errors->has('contact_number')) is-invalid @endif " required>
                            @error('contact_number') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-2 mb-3">
                            <label>Height (ft/inch e.g. 5’3”) {!! $requiredlbl !!}</label>
                            <input wire:model.lazy="height" type="text" class="form-control @if($errors->has('height')) is-invalid @endif " required>
                            @error('height') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-2 mb-3">
                            <label>Weight (kg) {!! $requiredlbl !!}</label>
                            <input wire:model.lazy="weight" type="text" class="form-control @if($errors->has('weight')) is-invalid @endif " required>
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
                            <input wire:model.lazy="current_address" type="text" class="form-control @if($errors->has('current_address')) is-invalid @endif" required>
                            @error('current_address') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Permanent Address {!! $requiredlbl !!}</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input wire:model="currentAddress" wire:click="$emit('currentClicked')" class="form-check-input" type="checkbox" id="sameAsCurrentAddress">
                            <label class="form-check-label" for="sameAsCurrentAddress">Same as current address</label>
                            <input wire:model.lazy="permanent_address" type="text" class="form-control @if($errors->has('permanent_address')) is-invalid @endif" required>
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
                            <input wire:model.lazy="father_first_name" x-model="fatherFname" type="text" class="form-control @if($errors->has('father_first_name')) is-invalid @endif " required>
                            @error('father_first_name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label>Last Name {!! $requiredlbl !!}</label>
                            <input wire:model.lazy="father_last_name" x-model="fatherLname" type="text" class="form-control @if($errors->has('father_last_name')) is-invalid @endif " required>
                            @error('father_last_name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Middle Name (Optional)</label>
                            <input wire:model.lazy="father_middle_name" x-model="fatherMname" type="text" class="form-control">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label>Extension (ex. Jr., II, III) (Optional)</label>
                            <input wire:model.lazy="father_ext_name" x-model="fatherXname" type="text" class="form-control">
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
                            <select wire:model.lazy="father_province" x-model="fatherProvince" @change="alert('Hello')" name="father_province" id="father_province" class="form-control @if($errors->has('father_province')) is-invalid @endif" required>
                                <option x-bind:value=''></option>
                                @foreach($listOfProvinces as $province)
                                    <option x-bind:value={{ $province->PROVINCE_C }}>{{ $province->PROVINCE }}</option>
                                @endforeach
                            </select>
                            @error('father_province') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>City/Municipality {!! $requiredlbl !!}</label>
                            <select wire:model.lazy="father_municipality" x-model="fatherCity" name="father_municipality" id="father_municipality" class="form-control @if($errors->has('father_municipality')) is-invalid @endif " required>
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
                            <select wire:model.lazy="father_barangay" x-model="fatherBarangay" name="father_barangay" id="father_barangay" class="form-control @if($errors->has('father_barangay')) is-invalid @endif " required>
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
                            <input wire:model.lazy="father_street" x-model="fatherStreet" id="father_street" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label>Occupation (Optional)</label>
                            <input wire:model.lazy="father_occupation" x-model="fatherOccupation" type="text" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Contact Number {!! $requiredlbl !!}</label>
                            <input wire:model.lazy="father_contact" x-model="fatherContact" type="text" class="form-control @if($errors->has('father_contact')) is-invalid @endif " required>
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
                            <input wire:model.lazy="mother_first_name" x-model="motherFname" type="text" class="form-control @if($errors->has('mother_first_name')) is-invalid @endif " required>
                            @error('mother_first_name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Last Name {!! $requiredlbl !!}</label>
                            <input wire:model.lazy="mother_last_name" x-model="motherLname" type="text" class="form-control @if($errors->has('mother_last_name')) is-invalid @endif " required>
                            @error('mother_last_name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Middle Name (Optional)</label>
                            <input wire:model.lazy="mother_middle_name" x-model="motherMname" type="text" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Extension (ex. Jr., II, III) (Optional)</label>
                            <input wire:model.lazy="mother_ext_name" x-model="motherXname" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-12">
                            <div class="form-inline">
                                <label>Complete Address: </label>&nbsp;&nbsp;&nbsp;
                                <input wire:click="$emitSelf('addressClicked')" class="form-check-input" type="checkbox" id="sameAsFatherAddress">
                                <label class="form-check-label" for="sameAsFatherAddress">Same as father</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label>Province {!! $requiredlbl !!}</label>
                            <select wire:model.lazy="mother_province" x-model="motherProvince" name="mother_province" id="mother_province" class="form-control @if($errors->has('mother_province')) is-invalid @endif" required>
                                <option value=''></option>
                                @foreach($listOfProvinces as $province)
                                    <option value={{ $province->PROVINCE_C }}>{{ $province->PROVINCE }}</option>
                                @endforeach
                            </select>
                            @error('mother_province') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>City/Municipality {!! $requiredlbl !!}</label>
                            <select wire:model.lazy="mother_municipality" x-model="motherCity" name="mother_municipality" id="mother_municipality" class="form-control @if($errors->has('mother_municipality')) is-invalid @endif" required>
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
                            <select wire:model.lazy="mother_barangay" x-model="motherBarangay" name="mother_barangay" id="mother_barangay" class="form-control @if($errors->has('mother_barangay')) is-invalid @endif " required>
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
                            <input wire:model.lazy="mother_street" x-model="motherStreet" id="mother_street" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label>Occupation (Optional)</label>
                            <input wire:model.lazy="mother_occupation" x-model="motherOccupation" type="text" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Contact Number</label>
                            <input wire:model.lazy="mother_contact" x-model="motherContact" type="text" class="form-control @if($errors->has('mother_contact')) is-invalid @endif " required>
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
                                  <input x-model="guardianInfo" x-on:change="changeGuardianInfo" id="fatherD" name="fatherDetails" type="radio" value="father" class="form-check-input">
                                  <label class="form-check-label" for="fatherD">Same as father details</label>&nbsp;&nbsp;&nbsp;
                                  <input x-model="guardianInfo" x-on:change="changeGuardianInfo" id="motherD" name="fatherDetails" type="radio" value="mother" class="form-check-input">
                                  <label class="form-check-label" for="motherD">Same as mother details</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label>First Name {!! $requiredlbl !!}</label>
                            <input wire:model.lazy="guardian_first_name" x-model="guardianFname" type="text" class="form-control @if($errors->has('guardian_first_name')) is-invalid @endif " required>
                            @error('guardian_first_name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Last Name {!! $requiredlbl !!}</label>
                            <input wire:model.lazy="guardian_last_name" x-model="guardianLname" type="text" class="form-control @if($errors->has('guardian_last_name')) is-invalid @endif " required>
                            @error('guardian_last_name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Middle Name (Optional)</label>
                            <input wire:model.lazy="guardian_middle_name" x-model="guardianMname" type="text" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Extension (ex. Jr., II, III) (Optional)</label>
                            <input wire:model.lazy="guardian_ext_name" x-model="guardianXname" type="text" class="form-control">
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
                            <select wire:model.lazy="guardian_province" x-model="guardianProvince" name="guardian_province" class="form-control @if($errors->has('guardian_province')) is-invalid @endif" required>
                                <option value=''></option>
                                @foreach($listOfProvinces as $province)
                                    <option value={{ $province->PROVINCE_C }}>{{ $province->PROVINCE }}</option>
                                @endforeach
                            </select>
                            @error('guardian_province') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>City/Municipality {!! $requiredlbl !!}</label>
                            <select wire:model.lazy="guardian_municipality" x-model="guardianCity" name="guardian_municipality" class="form-control @if($errors->has('guardian_municipality')) is-invalid @endif" required>
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
                            <select wire:model.lazy="guardian_barangay" x-model="guardianBarangay" name="guardian_barangay" class="form-control @if($errors->has('guardian_barangay')) is-invalid @endif " required>
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
                            <input wire:model.lazy="guardian_street" x-model="guardianStreet" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label>Occupation (Optional)</label>
                            <input wire:model.lazy="guardian_occupation" x-model="guardianOccupation" type="text" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Contact Number {!! $requiredlbl !!}</label>
                            <input wire:model.lazy="guardian_contact_number" x-model="guardianContact" type="text" class="form-control @if($errors->has('guardian_contact_number')) is-invalid @endif " required>
                            @error('guardian_contact_number') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Relationship {!! $requiredlbl !!}</label>
                            <input wire:model.lazy="guardian_relation" x-model="guardianRelation" type="text" class="form-control @if($errors->has('guardian_relation')) is-invalid @endif " required>
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
                            <input wire:model.lazy="lrn" type="text" class="form-control">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Registration Date {!! $requiredlbl !!}</label>
                            <input wire:model.lazy="admission_date" type="date" class="form-control @if($errors->has('admission_date')) is-invalid @endif" format="yyyy-MM-dd" value-format="yyyy-MM-dd" required>
                            @error('admission_date') <span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Classifications {!! $requiredlbl !!}</label>
                            <select wire:model.lazy="classification" class="form-control" required>
                                <option value=''>Select Classification</option>
                                @foreach($listOfClassification as $classifications)
                                    <option value={{ $classifications->id }}>{{ $classifications->description }}</option>
                                @endforeach
                            </select>
                            @error('classification') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Level/Program/Course {!! $requiredlbl !!}</label>
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
                    
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label>Upload Picture (2x2)</label>
                            <input wire:model="fileName" type="file" class="form-control">
                        </div>
                        @if($showBirth)
                            <div class="col-md-3 mb-3">
                                <label>Upload Birth Certificate</label>
                                <input wire:model="birthCertificate" type="file" class="form-control">
                            </div>
                        @endif
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
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" wire:click.prevent="resetInput">Reset</button>
                <button class="btn btn-primary close-modal px-5" wire:click.prevent="store" wire:loading.attr="disabled" @click="scrollTo({top: 0, behavior: 'smooth'})"><div wire:loading wire:target="store"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div> Submit</button>
            </div>
        </div>
    </div>
</div>
