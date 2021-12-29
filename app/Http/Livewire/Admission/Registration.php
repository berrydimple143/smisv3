<?php

namespace App\Http\Livewire\Admission;

use App\Models\Curriculum;
use App\Models\StudentRecord;
use App\Models\StudentStatus;
use App\Models\Citizenship;
use App\Models\Religion;
use App\Models\Classification;
use App\Models\Course;
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
use App\Notifications\EmailVerification;
use DB;
use Exception;
use Illuminate\Foundation\Auth\RegistersUsers;

class Registration extends Component
{
    use RegistersUsers;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    use WithFileUploads;
    
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;
    //////////////////////////////
    // Data Collection Container
    //////////////////////////////

    public $listOfStudents, $listOfStatus, $lisOfCitizenship, $listOfReligion, $listOfClassification, $listOfCourse;
    public $listOfProvinces, $listOfCityMunsMother, $listOfCityMunsFather, $listOfCityMunsGuardian, $listOfBarangays;
    public $listOfBarangaysFather, $listOfBarangaysMother, $listOfBarangaysGuardian;
    //////////////////////////////
    // Student Record Model
    //////////////////////////////
    public $create = [];
    public $selected_id, $deleteId;
    public $crud = false;
    public $requiredlbl = '<font color="red">*</font>';
    public $status, $last_name, $first_name, $middle_name, $student_number;
    public $gender, $civil_status, $date_of_birth, $citizenship_id, $religion_id, $blood_type;
    public $email, $contact_number, $height, $weight, $photo, $birth;
    public $current_address, $permanent_address, $qrcode_size = 70;
    public $father_last_name, $father_first_name, $father_middle_name, $father_occupation, $father_contact, $father_ext_name, $father_street, $father_barangay, $father_municipality, $father_province;
    public $mother_last_name, $mother_first_name, $mother_middle_name, $mother_occupation, $mother_contact, $mother_ext_name, $mother_street, $mother_barangay, $mother_municipality, $mother_province;
    public $guardian_last_name, $guardian_relation, $guardian_first_name, $guardian_middle_name, $guardian_occupation, $guardian_ext_name, $guardian_contact_number, $guardian_street, $guardian_barangay, $guardian_municipality, $guardian_province;
    public $lrn, $admission_date, $classification, $course_id, $fileName, $birthCertificate, $currentAddress = false;
    public $sameAsFatherAddress, $fatherAddress = false, $showButtons = true, $showBirth = true, $showStudentNo = false;
    
    protected $listeners = ['addressClicked' => 'changeMotherAddress', 'detailsClicked' => 'changeGuardianDetails', 'currentClicked' => 'changeCurrentAddress'];
    
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
            'email' => ['required', 'string', 'email', 'max:255'],
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
            'admission_date' => 'required',
            'course_id' => 'required',
            'fileName' => ['nullable'],
            'birthCertificate' => ['nullable'],
            'classification' => 'required',
        ];
    }
    
    public function changeMotherAddress() {
            $this->mother_barangay = $this->father_barangay;
            $this->mother_street = $this->father_street;
            $this->mother_municipality = $this->father_municipality;
            $this->mother_province = $this->father_province;
    }
    
    public function changeCurrentAddress() {
        if($this->currentAddress){
            $this->permanent_address = $this->current_address;
        } else {
            $this->permanent_address = '';
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
    
    public function mount() {
        $this->listOfStatus = StudentStatus::all();
        $this->listOfProvinces = Province::orderBy('PROVINCE')->get();
        $this->lisOfCitizenship = Citizenship::all();
        $this->listOfReligion = Religion::orderBy('description')->get();
        $this->listOfClassification = Classification::all();
    }
    
    public function render()
    {
        $this->admission_date = Carbon::now();
        
        /*if(!empty($this->father_province)) {
            $this->listOfCityMunsFather = CityMun::where('PROVINCE_C', $this->father_province)->orderBy('CITYMUN')->get();
        }
        if(!empty($this->mother_province)) {
            $this->listOfCityMunsMother = CityMun::where('PROVINCE_C', $this->mother_province)->orderBy('CITYMUN')->get();
        }
        if(!empty($this->guardian_province)) {
            $this->listOfCityMunsGuardian = CityMun::where('PROVINCE_C', $this->guardian_province)->orderBy('CITYMUN')->get();
        }
        if(!empty($this->father_municipality)) {
            $str = substr($this->father_municipality, 1, 5);
            $this->listOfBarangaysFather = Barangay::where('Code', 'LIKE', '%'.$str.'%')->orderBy('Name')->get();
        }
        if(!empty($this->mother_municipality)) {
            $str1 = substr($this->mother_municipality, 1, 5);
            $this->listOfBarangaysMother = Barangay::where('Code', 'LIKE', '%'.$str1.'%')->orderBy('Name')->get();
        }
        if(!empty($this->guardian_municipality)) {
            $str2 = substr($this->guardian_municipality, 1, 5);
            $this->listOfBarangaysGuardian = Barangay::where('Code', 'LIKE', '%'.$str2.'%')->orderBy('Name')->get();
        }*/
        
        if(!empty($this->classification)) {
            $this->listOfCourse = Course::where('classification_id',$this->classification)->get();
        }

        return view('livewire.admission.registration', [
            'admission' => StudentRecord::search($this->search)
            ->with('student', 'StudentStatus', 'course.classification', 'enrolment', 'creditedsubject')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ]);

    }
    
    public function updated($propertyName)
    {
        if($propertyName == "status") {
            $stat = StudentStatus::where('id', $this->status)->first();
            if($stat->description == "Old Student") {
                $this->showBirth = false;
                $this->showStudentNo = true;
            } else {
                $this->showBirth = true;
                $this->showStudentNo = false;
            }
        }
        /*if($propertyName == "father_province") {
            $this->emit('focusFatherAddress');
        }
        if($propertyName == "father_municipality") {
            $this->emit('focusFatherBarangay');
        }*/
        $this->validateOnly($propertyName);
    }

    public function resetInput()
    {
       //$this->sameAsFatherAddress = ''; 
       //$this->fatherAddress = false;
       //$this->fatherDetails = '';
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
       $this->course_id = '';
       $this->photo = '';
       $this->fileName = '';
       $this->student_number = ''; 
       $this->birthCertificate = '';
       $this->birth = '';
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
        $curriculum = Curriculum::where('course_id', $this->course_id)->first();
        if(empty($this->student_number)) {
            $this->student_number = uniqid();
        }
        $now = Carbon::now();
        $refno = (string)$now . $this->course_id;
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
            'curriculum_id'=> $curriculum->id,
            'course_id' => $this->course_id,
            'photo' => $filename,
            'birth' => $birth
        ];

        try {
            DB::beginTransaction();

                $StudentRecord = StudentRecord::Create($data);
                $User = User::Create([
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

                $User->notify(new EmailVerification($this->email));
                $SemesterRegistration = SemesterRegistration::create([
                    'student_record_id' => $StudentRecord->id,
                    'school_year_id' => 1,
                    'term_id' => 1,
                    'limit' => 24,
                    'level_id' => 1,
                    'course_id' => $this->course_id,
                    'curriculum_id' => $curriculum->id,
                ]);

            DB::commit();
            $this->resetInput();
            $this->emit('userStore');
            
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error in saving registration form!'.$e->getMessage());
            $this->emit('userStore');
            return $e->getMessage();
        }
    }
    
    private function generateQRCode($appId, $fullname, $birthday) {
        $msg = $appId . ', ' . $fullname . ', ' . $birthday;
        $qr = \QrCode::size($this->qrcode_size)->format('png')->generate($msg, public_path('images/qrcodes/'.$appId.'.png'));
        return asset('images/qrcodes/'.$appId.'.png');
    }
    
    private function printpdf($img, $appId, $fullname, $guardian, $address, $contact, $grade) {
        $data = [
            'ref_no' => $appId,
            'fullname' => $fullname,
            'address' => $address,
            'contact' => $contact,
            'guardian' => $guardian,
            'grade' => $grade,
            'qrcode_size' => $this->qrcode_size,
            'img' => $img
        ];
        $flname = 'Student Application Form'.'.pdf';
        $pdfContent = PDF::loadView('modules.admission.registration-pdf', $data)->output();
        return response()->streamDownload(function() use ($pdfContent) {
            print($pdfContent);
        }, $flname);
    }
    
    /*public function create() {
        if($this->crud == 'create') $this->crud = '';
        else{
            $this->crud = 'create';
            if(empty($this->listOfStatus)) {
                $this->listOfStatus = StudentStatus::all();
                $this->lisOfCitizenship = Citizenship::all();
                $this->listOfReligion = Religion::all();
                $this->listOfClassification = Classification::all();
            }

        }
    }*/
    
    public function openModal(){
        $this->resetInput();
//        $this->emit('userStoreOpen');
    }
    
    public function show($id)
    {
        $student = StudentRecord::with('student', 'StudentStatus', 'course.classification', 'enrolment')->where('id',$id)->first();

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
        $this->father_occupation = $student->father_occupation;
        $this->mother_last_name = $student->mother_last_name;
        $this->mother_first_name = $student->mother_first_name;
        $this->mother_middle_name = $student->mother_middle_name;
        $this->mother_occupation = $student->mother_occupation;
        $this->guardian_last_name = $student->guardian_last_name;
        $this->guardian_first_name = $student->guardian_first_name;
        $this->guardian_middle_name = $student->guardian_middle_name;
        $this->guardian_relation = $student->guardian_relation;
        $this->guardian_contact_number = $student->guardian_contact_number;
        $this->guardian_address = $student->guardian_address;
        $this->lrn = $student->lrn;
        $this->admission_date = $student->admission_date;
        $this->classification = $student->course->classification->id;
        $this->course_id = $student->course_id;

//        $this->crud = 'edit';
//        dd($student->admission_date);
    }
    
    public function edit($id)
    {
        $student = StudentRecord::with('student', 'StudentStatus', 'course.classification', 'enrolment')->where('id',$id)->first();

        $this->selected_id = $student->id;
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
        $this->father_occupation = $student->father_occupation;
        $this->mother_last_name = $student->mother_last_name;
        $this->mother_first_name = $student->mother_first_name;
        $this->mother_middle_name = $student->mother_middle_name;
        $this->mother_occupation = $student->mother_occupation;
        $this->guardian_last_name = $student->guardian_last_name;
        $this->guardian_first_name = $student->guardian_first_name;
        $this->guardian_middle_name = $student->guardian_middle_name;
        $this->guardian_relation = $student->guardian_relation;
        $this->guardian_contact_number = $student->guardian_contact_number;
        $this->guardian_address = $student->guardian_address;
        $this->lrn = $student->lrn;
        $this->admission_date = $student->admission_date;
        $this->classification = (!empty($student->course->classification->id)) ? $student->course->classification->id : '';
        $this->course_id = $student->course_id;

//        $this->crud = 'edit';
//        dd($student->admission_date);
    }

    public function update()
    {

        $validate = $this->validate([
            'status' => 'required',
            'last_name' => 'required',
            'first_name' => 'required',
            'middle_name' => 'required',
            'gender' => 'required',
            'civil_status' => 'required',
            'date_of_birth' => 'required',
            'citizenship_id' => 'required',
            'religion_id' => 'required',
            'blood_type' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->selected_id, 'account_id'),],
            'contact_number' => 'required',
            'height' => 'required',
            'weight' => 'required',
            'current_address' => ['required', 'string', 'max:255'],
            'permanent_address' => ['required', 'string', 'max:255'],
            'father_last_name' => 'required',
            'father_first_name' => 'required',
            'father_middle_name' => 'required',
            'father_occupation' => 'required',
            'mother_last_name' => 'required',
            'mother_first_name' => 'required',
            'mother_middle_name' => 'required',
            'mother_occupation' => 'required',
            'guardian_last_name' => 'required',
            'guardian_first_name' => 'required',
            'guardian_middle_name' => 'required',
            'guardian_relation' => 'required',
            'guardian_contact_number' => 'required',
            'guardian_address' => 'required',
            'lrn' => 'required',
            'admission_date' => 'required',
            'classification' => 'required',
            'course_id' => 'required',
        ]);

        $curriculum = Curriculum::where('course_id',  $this->course_id)->first();

        $data = [
            'status' => $this->status,
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
            'mother_last_name' => $this->mother_last_name,
            'mother_first_name' => $this->mother_first_name,
            'mother_middle_name' => $this->mother_middle_name,
            'mother_occupation' => $this->mother_occupation,
            'guardian_last_name' => $this->guardian_last_name,
            'guardian_first_name' => $this->guardian_first_name,
            'guardian_middle_name' => $this->guardian_middle_name,
            'guardian_relation' => $this->guardian_relation,
            'guardian_contact_number' => $this->guardian_contact_number,
            'guardian_address' => $this->guardian_address,
            'lrn' => $this->lrn,
            'admission_date' => $this->admission_date,
            'curriculum_id'=> (!empty($curriculum->id) ? $curriculum->id : ''),
            'course_id' => $this->course_id
        ];

        $UserCredentialsData = [
            'name' => $this->first_name." ".$this->last_name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'mobile' => $this->contact_number
        ];

        $SemesterRegistrationData = [
            'course_id' => $this->course_id,
            'curriculum_id'=> (!empty($curriculum->id) ? $curriculum->id : ''),
        ];


        try {
            DB::beginTransaction();
                $StudentRecord = StudentRecord::findOrFail($this->selected_id)->update($data);
                $User = User::where('account_id', $this->selected_id)->update($UserCredentialsData);
                $SemesterRegistration = SemesterRegistration::where('student_record_id', $this->selected_id)->update($SemesterRegistrationData);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error in updating registration form!'.$e->getMessage());
            return $e->getMessage();
        }

        $this->resetInput();
        session()->flash('message', 'Student registration updated successfully.');
        $this->emit('userUpdate');
    }

    public function destroy($id)
    {
        if ($id) {
            dd($id);
        }
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }
    
    public function delete()
    {
        $id = $this->deleteId;
        $student = StudentRecord::with( 'enrolment')->where('id', $id)->first();
        if(empty($student->enrolment)){
            $student->delete();
            SemesterRegistration::where('student_record_id', $id)->delete();
            User::where('account_id', $id)->delete();

            session()->flash('message', 'Student registration deleted successfully.');

            $this->mount();
            $this->render();
        }else{
            session()->flash('error', 'Error deleting Student registration!');
        }
    }

}
