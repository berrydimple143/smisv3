<?php

namespace App\Http\Livewire\Registrar;

use App\Http\Controllers\HelperController;

use App\Models\StudentRecord;
use App\Models\Section;
use App\Models\Course;
use App\Models\Curriculum;
use App\Models\StudentStatus;
use App\Models\Citizenship;
use App\Models\Religion;
use App\Models\Classification;
use App\Models\User;
use App\Models\SemesterRegistration;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\CityMun;
use App\Models\Province; 
use App\Models\Barangay;
use Carbon\Carbon;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Notifications\EmailVerification;
use DB;
use Exception;

class Student extends Component
{
	use WithPagination;
	use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'first_name';
    public $orderAsc = true;
    public $selected_id, $deleteId;
    public $course_id = '', $section_id = '';
    public $listOfLevels, $listOfSections;
    public $addBtnClass = "disabled";
    
    public $requiredlbl = '<font color="red">*</font>';
    public $status, $last_name, $first_name, $middle_name, $student_number;
    public $gender, $civil_status, $date_of_birth, $citizenship_id, $religion_id, $blood_type;
    public $email, $contact_number, $height, $weight, $courseName;
    public $current_address, $permanent_address, $qrcode_size = 70;
    public $father_last_name, $father_first_name, $father_middle_name, $father_occupation, $father_contact, $father_ext_name, $father_street, $father_barangay, $father_municipality, $father_province;
    public $mother_last_name, $mother_first_name, $mother_middle_name, $mother_occupation, $mother_contact, $mother_ext_name, $mother_street, $mother_barangay, $mother_municipality, $mother_province;
    public $guardian_last_name, $guardian_relation, $guardian_first_name, $guardian_middle_name, $guardian_occupation, $guardian_ext_name, $guardian_contact_number, $guardian_street, $guardian_barangay, $guardian_municipality, $guardian_province;
    public $lrn, $admission_date, $classification, $fileName, $birthCertificate, $currentAddress = false;
    public $sameAsFatherAddress = false, $fatherDetails, $fatherAddress = false, $showButtons = true, $showBirth = true, $showStudentNo = false;
    
    public $listOfStudents, $listOfStatus, $lisOfCitizenship, $listOfReligion, $listOfClassification, $listOfCourse;
    public $listOfFatherProvinces, $listOfMotherProvinces, $listOfGuardianProvinces, $listOfCityMunsMother, $listOfCityMunsFather, $listOfCityMunsGuardian, $listOfBarangays;
    public $listOfBarangaysFather, $listOfBarangaysMother, $listOfBarangaysGuardian;
    
    protected $listeners = ['resetInputs', 'hideModal', 'addressClicked' => 'changeMotherAddress', 'currentClicked' => 'changeCurrentAddress'];
    
    protected function rules() {
        return [
            'status' => 'required',
            'last_name' => 'required',
            'first_name' => 'required',
            'gender' => 'required',
            'civil_status' => 'required',
            'date_of_birth' => 'required',
            'citizenship_id' => 'required',
            'religion_id' => ['nullable', 'max:255'],
            'blood_type' => ['string', 'nullable', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email', 'max:255'],
            'contact_number' => 'required',
            'height' => 'required',
            'weight' => 'required',
            'current_address' => ['required', 'string', 'max:255'],
            'permanent_address' => ['required', 'string', 'max:255'],
            'father_last_name' => 'required',
            'father_first_name' => 'required',
            'father_middle_name' => ['string', 'nullable', 'max:255'],
            'father_contact' => 'required',
            'father_occupation' => ['string', 'nullable', 'max:255'],
            'father_barangay' => 'required',
            'father_municipality' => 'required',
            'father_province' => 'required',
            'father_ext_name' => ['string', 'nullable', 'max:255'],
            'father_street' => ['string', 'nullable', 'max:255'],
            'mother_last_name' => 'required',
            'mother_first_name' => 'required',
            'mother_middle_name' => ['string', 'nullable', 'max:255'],
            'mother_contact' => 'required',
            'mother_barangay' => 'required',
            'mother_municipality' => 'required',
            'mother_province' => 'required',
            'mother_ext_name' => ['string', 'nullable', 'max:255'],
            'mother_street' => ['string', 'nullable', 'max:255'],
            'mother_occupation' => ['string', 'nullable', 'max:255'],
            'guardian_last_name' => 'required',
            'guardian_first_name' => 'required',
            'guardian_middle_name' => ['string', 'nullable', 'max:255'],
            'guardian_relation' => 'required',
            'guardian_contact_number' => 'required',
            'guardian_occupation' => ['string', 'nullable', 'max:255'],
            'guardian_barangay' => 'required',
            'guardian_municipality' => 'required',
            'guardian_province' => 'required',
            'guardian_ext_name' => ['string', 'nullable', 'max:255'],
            'guardian_street' => ['string', 'nullable', 'max:255'],
            'lrn' => ['string', 'nullable', 'max:255'],
            'admission_date' => ['required', 'date'],
            'fileName' => ['nullable'],
            'birthCertificate' => ['nullable'],
        ];
    }
    
    public function checkAddressValue($id) {
        if($this->currentAddress) {
            if($id == "current"){
                $this->permanent_address = $this->current_address;
            } elseif($id == "permanent") {
                $this->current_address = $this->permanent_address;
            }
        }
    }
    
    public function changeMotherAddress() {
        if($this->sameAsFatherAddress) {
            $this->mother_barangay = $this->father_barangay;
            $this->mother_street = $this->father_street;
            $this->mother_municipality = $this->father_municipality;
            $this->mother_province = $this->father_province;
        } else {
            $this->mother_barangay = '';
            $this->mother_street = '';
            $this->mother_municipality = '';
            $this->mother_province = '';
        }
    }
    
    public function changeCurrentAddress() {
        if($this->currentAddress){
            $this->permanent_address = $this->current_address;
        }
    }
    
    public function changeGuardianDetails($parent) {
        if($parent == "father") {
            $this->guardian_barangay = $this->father_barangay;
            $this->guardian_street = $this->father_street;
            $this->guardian_municipality = $this->father_municipality;
            $this->guardian_province = $this->father_province;
            $this->guardian_last_name = $this->father_last_name;
            $this->guardian_first_name = $this->father_first_name;
            $this->guardian_middle_name = $this->father_middle_name;
            $this->guardian_contact_number = $this->father_contact;
            $this->guardian_occupation = $this->father_occupation;
            $this->guardian_ext_name = $this->father_ext_name;
            $this->guardian_relation = 'Father';
        } elseif($parent == "mother") {
            $this->guardian_barangay = $this->mother_barangay;
            $this->guardian_street = $this->mother_street;
            $this->guardian_municipality = $this->mother_municipality;
            $this->guardian_province = $this->mother_province;
            $this->guardian_last_name = $this->mother_last_name;
            $this->guardian_first_name = $this->mother_first_name;
            $this->guardian_middle_name = $this->mother_middle_name;
            $this->guardian_contact_number = $this->mother_contact;
            $this->guardian_occupation = $this->mother_occupation;
            $this->guardian_ext_name = $this->mother_ext_name;
            $this->guardian_relation = 'Mother';
        } else {
            $this->guardian_barangay = '';
            $this->guardian_street = '';
            $this->guardian_municipality = '';
            $this->guardian_province = '';
            $this->guardian_last_name = '';
            $this->guardian_first_name = '';
            $this->guardian_middle_name = '';
            $this->guardian_contact_number = '';
            $this->guardian_occupation = '';
            $this->guardian_ext_name = '';
            $this->guardian_relation = '';
        }
    }
    
    public function mount(Request $request) {
        if($request->input('cid')) {
            $this->course_id = $request->input('cid');
        }
        if($request->input('sid')) {
            $this->section_id = $request->input('sid');
        }
    }
    
    public function render()
    {      
      $now = Carbon::now();
      $this->admission_date = Carbon::parse($now)->format('Y-m-d');
      $course = "";
      if((!empty($this->course_id)) and (!empty($this->section_id))) {
        $this->addBtnClass = "";
        $course = Course::where('id', $this->course_id)->first();
        $this->courseName = $course->name;
      }
      if(!empty($this->father_province)) {
          $this->listOfCityMunsFather = CityMun::where('PROVINCE_C', strtolower($this->father_province))->orderBy('CITYMUN')->get();
      }
      if(!empty($this->mother_province)) {
          $this->listOfCityMunsMother = CityMun::where('PROVINCE_C', strtolower($this->mother_province))->orderBy('CITYMUN')->get();
      }
      if(!empty($this->guardian_province)) {
          $this->listOfCityMunsGuardian = CityMun::where('PROVINCE_C', strtolower($this->guardian_province))->orderBy('CITYMUN')->get();
      }
      if(!empty($this->father_municipality)) {
          $str = strtolower(substr($this->father_municipality, 1, 5));
          $this->listOfBarangaysFather = Barangay::where('Code', 'LIKE', '%'.$str.'%')->orderBy('Name')->get();
      }
      if(!empty($this->mother_municipality)) {
          $str1 = strtolower(substr($this->mother_municipality, 1, 5));
          $this->listOfBarangaysMother = Barangay::where('Code', 'LIKE', '%'.$str1.'%')->orderBy('Name')->get();
      }
      if(!empty($this->guardian_municipality)) {
          $str2 = strtolower(substr($this->guardian_municipality, 1, 5));
          $this->listOfBarangaysGuardian = Barangay::where('Code', 'LIKE', '%'.$str2.'%')->orderBy('Name')->get();
      }
      $this->listOfStatus = StudentStatus::all();
      $this->listOfFatherProvinces = Province::orderBy('PROVINCE')->get();
      $this->listOfMotherProvinces = Province::orderBy('PROVINCE')->get();
      $this->listOfGuardianProvinces = Province::orderBy('PROVINCE')->get();
      $this->lisOfCitizenship = Citizenship::all();
      $this->listOfReligion = Religion::orderBy('description')->get();
      $this->listOfClassification = Classification::all();
      $this->listOfLevels = Course::orderBy('name')->get();
      $this->listOfSections = Section::orderBy('name')->get();
      return view('livewire.registrar.student', [
            'course' => $course,
            'section' => Section::where('id', $this->section_id)->first(),
            'students' => StudentRecord::where('course_id', $this->course_id)->where('section_id', $this->section_id)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
      ])->extends('layouts.app');
    }
    
    public function checkStudentNumber($value) {
        $stat = StudentStatus::where('id', $value)->first();
        if($stat->description == "Old Student") {
            $this->showBirth = false;
            $this->showStudentNo = true;
        } else {
            $this->showBirth = true;
            $this->showStudentNo = false;
        }
    }
    
    public function validateInputs() {
        $this->validate();
    }

    public function store() {
        $dataValid = $this->validate();
        $filename = $birth = "";
        if($dataValid['fileName']) {
            $now = (string)Carbon::now();
            $str = str_replace(" ", "", $now);
            $str2 = str_replace("-", "", $str);
            $str3 = str_replace(":", "", $str2);
            $filename = $this->last_name.$str3.'.png';
            $dataValid['fileName'] = $this->fileName->storeAs('profiles', $filename);
        }
        if($dataValid['birthCertificate']) {
            $dataValid['birthCertificate'] = $this->birthCertificate->store('certificates');
        }
        //$curriculum = Curriculum::where('course_id', $this->course_id)->first();
        if(empty($this->student_number)) {
            $this->student_number = uniqid();
        }
        $now = Carbon::now();
        $rn = HelperController::removePunctuations((string)$now, '-', ':', ' ');
        $refno = $rn . $this->course_id;
        $csid = $this->course_id . '|@|' . $this->section_id;
        $data = [
            'status' => $this->status,
            'student_number'=> $this->student_number,
            'reference_number'=> $refno,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'gender' => $this->gender,
            'civil_status' => $this->civil_status,
            'date_of_birth' => $this->date_of_birth,
            'citizenship_id' => $this->citizenship_id,
            'religion_id' => $this->religion_id,
            'blood_type' => $this->blood_type,
            'email' => $this->email,
            'contact_number' => $this->contact_number,
            'height' => $this->height,
            'weight' => $this->weight,
            'current_address' => $this->current_address,
            'permanent_address' => $this->permanent_address,
            'father_last_name' => $this->father_last_name,
            'father_first_name' => $this->father_first_name,
            'father_middle_name' => $this->father_middle_name,
            'father_occupation' => $this->father_occupation,
            'father_ext_name' => $this->father_ext_name,
            'father_contact' => $this->father_contact,
            'father_barangay' => $this->father_barangay,
            'father_street' => $this->father_street,
            'father_municipality' => $this->father_municipality,
            'father_province' => $this->father_province,
            'mother_last_name' => $this->mother_last_name,
            'mother_first_name' => $this->mother_first_name,
            'mother_middle_name' => $this->mother_middle_name,
            'mother_occupation' => $this->mother_occupation,
            'mother_ext_name' => $this->mother_ext_name,
            'mother_contact' => $this->mother_contact,
            'mother_barangay' => $this->mother_barangay,
            'mother_street' => $this->mother_street,
            'mother_municipality' => $this->mother_municipality,
            'mother_province' => $this->mother_province,
            'guardian_last_name' => $this->guardian_last_name,
            'guardian_first_name' => $this->guardian_first_name,
            'guardian_middle_name' => $this->guardian_middle_name,
            'guardian_relation' => $this->guardian_relation,
            'guardian_contact_number' => $this->guardian_contact_number,
            'guardian_occupation' => $this->guardian_occupation,
            'guardian_ext_name' => $this->guardian_ext_name,
            'guardian_barangay' => $this->guardian_barangay,
            'guardian_street' => $this->guardian_street,
            'guardian_municipality' => $this->guardian_municipality,
            'guardian_province' => $this->guardian_province,
            'lrn' => $this->lrn,
            'admission_date' => $this->admission_date,
            'course_id' => $this->course_id,
            'section_id' => $this->section_id,
            'photo' => $filename,
            'birth' => $birth
        ];
        //'curriculum_id'=> $curriculum->id,
        try {
            DB::beginTransaction();
                $StudentRecord = StudentRecord::create($data);
                $User = User::create([
                    'name' => $this->first_name.' '.$this->last_name,
                    'first_name' => $this->first_name,
                    'last_name' => $this->last_name,
                    'email' => $this->email,
                    'mobile' => $this->contact_number,
                    'status' => 'pending',
                    'password' => Hash::make('123pass'),
                    'account_id' => $StudentRecord->id,
                ]);
                $role1 = Role::where('name','student')->first();
                $role1->givePermissionTo('student');
                $User->assignRole($role1);
                $User->givePermissionTo('student');
                $User->notify(new EmailVerification($StudentRecord, $this->courseName));
            DB::commit();
            $this->resetInputs();
            $this->emit('userStore', $csid);
        } catch (Exception $e) {
            DB::rollBack();
            $this->emit('userStoreFailed', $e->getMessage());
            return $e->getMessage();
        }
    }

    public function edit($id) {
       $this->selected_id = $id;
       $student = StudentRecord::where('id', $id)->first();
       $this->status = $student->status;
       $this->last_name = $student->last_name;
       $this->first_name = $student->first_name;
       $this->middle_name = $student->middle_name;
       $this->gender = $student->gender;
       $this->civil_status = $student->civil_status;
       $this->date_of_birth = $student->date_of_birth;
       $this->citizenship_id = $student->citizenship_id;
       $this->religion_id = $student->religion_id;
       $this->blood_type = $student->blood_type;
       $this->email = $student->email;
       $this->contact_number = $student->contact_number;
       $this->height = $student->height;
       $this->weight = $student->weight;
       $this->current_address = $student->current_address;
       $this->permanent_address = $student->permanent_address;
       $this->father_last_name = $student->father_last_name;
       $this->father_first_name = $student->father_first_name;
       $this->father_middle_name = $student->father_middle_name;
       $this->father_ext_name = $student->father_ext_name;
       $this->father_occupation = $student->father_occupation;
       $this->father_contact = $student->father_contact;
       $this->father_barangay = $student->father_barangay;
       $this->father_street = $student->father_street;
       $this->father_municipality = $student->father_municipality;
       $this->father_province = $student->father_province;
       $this->mother_last_name = $student->mother_last_name;
       $this->mother_first_name = $student->mother_first_name;
       $this->mother_middle_name = $student->mother_middle_name;
       $this->mother_ext_name = $student->mother_ext_name;
       $this->mother_occupation = $student->mother_occupation;
       $this->mother_contact = $student->mother_contact;
       $this->mother_barangay = $student->mother_barangay;
       $this->mother_street = $student->mother_street;
       $this->mother_municipality = $student->mother_municipality;
       $this->mother_province = $student->mother_province;
       $this->guardian_last_name = $student->guardian_last_name;
       $this->guardian_first_name = $student->guardian_first_name;
       $this->guardian_middle_name = $student->guardian_middle_name;
       $this->guardian_ext_name = $student->guardian_ext_name;
       $this->guardian_relation = $student->guardian_relation;
       $this->guardian_contact_number = $student->guardian_contact_number;
       $this->guardian_barangay = $student->guardian_barangay;
       $this->guardian_street = $student->guardian_street;
       $this->guardian_municipality = $student->guardian_municipality;
       $this->guardian_province = $student->guardian_province;
       $this->lrn = $student->lrn;
       $this->admission_date = $student->admission_date;
       $stat = StudentStatus::where('id', $student->status)->first();
       if($stat->description == "Old Student") {
            $this->showStudentNo = true;
       } else {
            $this->showStudentNo = false;
       }
       $this->student_number = $student->student_number;
    }
    
    public function update()
    {
        $validate = $this->validate([
            'status' => 'required',
            'last_name' => 'required',
            'first_name' => 'required',
            'gender' => 'required',
            'civil_status' => 'required',
            'date_of_birth' => 'required',
            'citizenship_id' => 'required',
            'religion_id' => ['nullable', 'max:255'],
            'blood_type' => ['string', 'nullable', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->selected_id, 'account_id')],
            'contact_number' => 'required',
            'height' => 'required',
            'weight' => 'required',
            'current_address' => ['required', 'string', 'max:255'],
            'permanent_address' => ['required', 'string', 'max:255'],
            'father_last_name' => 'required',
            'father_first_name' => 'required',
            'father_middle_name' => ['string', 'nullable', 'max:255'],
            'father_contact' => 'required',
            'father_occupation' => ['string', 'nullable', 'max:255'],
            'father_barangay' => 'required',
            'father_municipality' => 'required',
            'father_province' => 'required',
            'father_ext_name' => ['string', 'nullable', 'max:255'],
            'father_street' => ['string', 'nullable', 'max:255'],
            'mother_last_name' => 'required',
            'mother_first_name' => 'required',
            'mother_middle_name' => ['string', 'nullable', 'max:255'],
            'mother_contact' => 'required',
            'mother_barangay' => 'required',
            'mother_municipality' => 'required',
            'mother_province' => 'required',
            'mother_ext_name' => ['string', 'nullable', 'max:255'],
            'mother_street' => ['string', 'nullable', 'max:255'],
            'mother_occupation' => ['string', 'nullable', 'max:255'],
            'guardian_last_name' => 'required',
            'guardian_first_name' => 'required',
            'guardian_middle_name' => ['string', 'nullable', 'max:255'],
            'guardian_relation' => 'required',
            'guardian_contact_number' => 'required',
            'guardian_occupation' => ['string', 'nullable', 'max:255'],
            'guardian_barangay' => 'required',
            'guardian_municipality' => 'required',
            'guardian_province' => 'required',
            'guardian_ext_name' => ['string', 'nullable', 'max:255'],
            'guardian_street' => ['string', 'nullable', 'max:255'],
            'lrn' => ['string', 'nullable', 'max:255'],
            'admission_date' => ['required', 'date'],
        ]);
        $csid = $this->course_id . '|@|' . $this->section_id;
        $data = [
            'status' => $this->status,
            'student_number'=> $this->student_number,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'gender' => $this->gender,
            'civil_status' => $this->civil_status,
            'date_of_birth' => $this->date_of_birth,
            'citizenship_id' => $this->citizenship_id,
            'religion_id' => $this->religion_id,
            'blood_type' => $this->blood_type,
            'email' => $this->email,
            'contact_number' => $this->contact_number,
            'height' => $this->height,
            'weight' => $this->weight,
            'current_address' => $this->current_address,
            'permanent_address' => $this->permanent_address,
            'father_last_name' => $this->father_last_name,
            'father_first_name' => $this->father_first_name,
            'father_middle_name' => $this->father_middle_name,
            'father_occupation' => $this->father_occupation,
            'father_ext_name' => $this->father_ext_name,
            'father_contact' => $this->father_contact,
            'father_barangay' => $this->father_barangay,
            'father_street' => $this->father_street,
            'father_municipality' => $this->father_municipality,
            'father_province' => $this->father_province,
            'mother_last_name' => $this->mother_last_name,
            'mother_first_name' => $this->mother_first_name,
            'mother_middle_name' => $this->mother_middle_name,
            'mother_occupation' => $this->mother_occupation,
            'mother_ext_name' => $this->mother_ext_name,
            'mother_contact' => $this->mother_contact,
            'mother_barangay' => $this->mother_barangay,
            'mother_street' => $this->mother_street,
            'mother_municipality' => $this->mother_municipality,
            'mother_province' => $this->mother_province,
            'guardian_last_name' => $this->guardian_last_name,
            'guardian_first_name' => $this->guardian_first_name,
            'guardian_middle_name' => $this->guardian_middle_name,
            'guardian_relation' => $this->guardian_relation,
            'guardian_contact_number' => $this->guardian_contact_number,
            'guardian_occupation' => $this->guardian_occupation,
            'guardian_ext_name' => $this->guardian_ext_name,
            'guardian_barangay' => $this->guardian_barangay,
            'guardian_street' => $this->guardian_street,
            'guardian_municipality' => $this->guardian_municipality,
            'guardian_province' => $this->guardian_province,
            'lrn' => $this->lrn,
            'admission_date' => $this->admission_date,
        ];

        $UserCredentialsData = [
            'name' => $this->first_name." ".$this->last_name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'mobile' => $this->contact_number
        ];

        try {
            DB::beginTransaction();
                $StudentRecord = StudentRecord::findOrFail($this->selected_id)->update($data);
                $User = User::where('account_id', $this->selected_id)->update($UserCredentialsData);
            DB::commit();
            $this->resetInputs();
            $this->emit('studentUpdated', $csid);
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    
    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }
    
    public function deleteThisId($id)
    {
        $this->deleteId = $id;
    }
    
    public function deleteNow()
    {
        $csid = $this->course_id . '|@|' . $this->section_id;
        $id = $this->deleteId;        
        $sa = StudentRecord::where('id', $id)->delete();
        $us = User::where('account_id', $id)->delete();
        $this->emit('studentDeleted', $csid);
    }

    public function resetInputs()
    {
       $this->fatherDetails = false;
       $this->sameAsFatherAddress = false;
       $this->currentAddress = false;
       $this->status = '';
       $this->last_name = '';
       $this->first_name = '';
       $this->middle_name = '';
       $this->gender = '';
       $this->civil_status = '';
       $this->date_of_birth = '';
       $this->citizenship_id = '';
       $this->religion_id = '';
       $this->blood_type = '';
       $this->email = '';
       $this->contact_number = '';
       $this->height = '';
       $this->weight = '';
       $this->current_address = '';
       $this->permanent_address = '';
       $this->father_last_name = '';
       $this->father_first_name = '';
       $this->father_middle_name = '';
       $this->father_ext_name = '';
       $this->father_occupation = '';
       $this->father_contact = '';
       $this->father_barangay = '';
       $this->father_street = '';
       $this->father_municipality = '';
       $this->father_province = '';
       $this->mother_last_name = '';
       $this->mother_first_name = '';
       $this->mother_middle_name = '';
       $this->mother_ext_name = '';
       $this->mother_occupation = '';
       $this->mother_contact = '';
       $this->mother_barangay = '';
       $this->mother_street = '';
       $this->mother_municipality = '';
       $this->mother_province = '';
       $this->guardian_last_name = '';
       $this->guardian_first_name = '';
       $this->guardian_middle_name = '';
       $this->guardian_ext_name = '';
       $this->guardian_relation = '';
       $this->guardian_contact_number = '';
       $this->guardian_barangay = '';
       $this->guardian_street = '';
       $this->guardian_municipality = '';
       $this->guardian_province = '';
       $this->lrn = '';
       $this->admission_date = '';
       $this->fileName = '';
       $this->student_number = ''; 
       $this->birthCertificate = '';
       $this->birth = '';
    }
}
