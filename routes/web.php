<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admission\OnlineRegistration;
use App\Http\Livewire\Admission\Registration;
use App\Http\Livewire\Grading\SummativeAssessment;
use App\Http\Livewire\Grading\PerformanceTask;
use App\Http\Livewire\Grading\Criteria;
use App\Http\Livewire\Grading\GradingSystem;
use App\Http\Livewire\Grading\GradeCriteria;
use App\Http\Livewire\Grading\ClassActivity;
use App\Http\Livewire\Registrar\SectionActivity;
use App\Http\Livewire\Registrar\SubjectActivity;
use App\Http\Livewire\Registrar\SubjectGrade;
use App\Http\Livewire\Registrar\SectionStudent;
use App\Http\Livewire\Registrar\SectionSubject;
use App\Http\Livewire\Registrar\StudentGrade;
use App\Http\Livewire\Registrar\ViewGrade;
use App\Http\Livewire\Registrar\Subject;
use App\Http\Livewire\Registrar\Section;
use App\Http\Livewire\Registrar\Student;
use App\Http\Livewire\Faculty\Teacher;
use App\Http\Livewire\Faculty\SubjectCriteria;
use App\Http\Livewire\Faculty\ClassRecord;
use App\Http\Livewire\UserManagement\User;
use App\Http\Livewire\UserManagement\Role;
use App\Http\Livewire\UserManagement\Permission;
use App\Http\Controllers\HomeController;
use App\Http\Livewire\Profile\Password;
use App\Http\Livewire\InformationManagement\Classes;
use App\Http\Livewire\InformationManagement\SchoolYear;

Auth::routes(['verify' => true]);

Route::middleware('auth')->group(function () {	
	Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/logout', [HomeController::class, 'logout'])->name('app.logout');
    Route::get('/change-password', Password::class)->name('change.password');
	Route::prefix('grading-criteria')->group(function() {
		Route::get('summative-assessment', SummativeAssessment::class)->name('summative.assessment');
		Route::get('performance-task', PerformanceTask::class)->name('performance.task');	
      	Route::get('criteria', Criteria::class)->name('criteria'); 
      	Route::get('grading-system', GradingSystem::class)->name('grading.system'); 
      	Route::get('grade-criteria/{id}', GradeCriteria::class)->name('grade.criteria'); 
      	Route::get('class-activities', ClassActivity::class)->name('class.activities'); 
	});   	
	Route::prefix('registrar')->group(function() {
	    Route::get('student-grade', StudentGrade::class)->name('student.grade');	
		Route::get('subject', Subject::class)->name('subject');	
      	Route::get('section', Section::class)->name('section');
      	Route::get('section-activities/{id}', SectionActivity::class)->name('section.activities');
      	Route::get('section-students/{id}', SectionStudent::class)->name('section.students');
      	Route::get('section-subjects/{id}', SectionSubject::class)->name('section.subjects');
      	Route::get('student-grades-per-subject/{student_id}/{section_id}', StudentGrade::class)->name('student.grades');
      	Route::get('subject-activities/{subjectId}/{sectionId}', SubjectActivity::class)->name('subject.activities');
      	Route::get('activity-grades/{studentID}/{ssid}', SubjectGrade::class)->name('activity.grades');
      	Route::get('view-grades/{studentId}/{sectionId}/{subjectId}/{activityId}', ViewGrade::class)->name('view.grades');
      	Route::get('students', Student::class)->name('students');
	});
	Route::prefix('faculty')->group(function() {
		Route::get('teachers', Teacher::class)->name('teachers');
		Route::get('subject-criteria', SubjectCriteria::class)->name('subject.criteria');
		Route::get('class-record', ClassRecord::class)->name('class.record');
	});
	Route::prefix('user-management')->group(function() {
		Route::get('users', User::class)->name('users');
		Route::get('roles', Role::class)->name('roles');
		Route::get('permissions', Permission::class)->name('permissions');
	});
	Route::prefix('information-management')->group(function() {
	    Route::get('classes', Classes::class)->name('classes');	
	    Route::get('school-year-and-semester', SchoolYear::class)->name('school.year');
	});
});
