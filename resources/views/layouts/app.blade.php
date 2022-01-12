<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
        <link href="{{ asset('icons/css/free.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">

        @livewireStyles        
        <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">      
        <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">         
        <link rel="stylesheet" href="{{ asset('css/coreui.min.css') }}" crossorigin="anonymous">         
        <link rel="stylesheet" href="{{ asset('css/index.css') }}">
        <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">        
        <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">        
        <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>        
    </head>
        @guest
            <body class="c-app flex-row align-items-center">
        @else
            <body class="c-app">
        @endguest

            @guest
                @yield('content')
            @else

                <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">

                    @include('shared.nav-builder')
                    @include('shared.header')

                    <div class="c-body">
                        <main class="c-main">
                            <div id="app">                                
                                @yield('content')
                            </div>
                        </main>
                        @include('shared.footer')
                    </div>
                </div>
            @endguest

            <script src="{{ asset('js/app.js') }}" defer></script>            
            <script src="{{ asset('js/perfect-scrollbar.js') }}"></script>
            <script src="{{ asset('js/popper.min.js') }}"></script>
            <script src="{{ asset('js/coreui.min.js') }}"></script>
            <script language="JavaScript" src="{{ asset('js/jquery-3.5.1.js') }}" type="text/javascript"></script>
            <script language="JavaScript" src="{{ asset('js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
            <script language="JavaScript" src="{{ asset('js/dataTables.bootstrap4.min.js') }}" type="text/javascript"></script>            
            <script src="{{ asset('js/alpinejs.cdn.min.js') }}" defer></script>                            
            @yield('javascript')           
            @livewireScripts        
            <script type="text/javascript">   
                document.addEventListener('livewire:load', function () {
                    var url = "{{ config('app.url') }}"; 
                    function showToastMessage(msg, icn) {
                        var toastMixin = Swal.mixin({
                            toast: true,
                            icon: icn,
                            title: 'General Title',
                            animation: false,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                              toast.addEventListener('mouseenter', Swal.stopTimer)
                              toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });       
                        toastMixin.fire({
                            animation: true,
                            title: msg
                        });  
                    }
                    Livewire.on('classCreated', () => {
                        showToastMessage("Class created successfully.", 'success');
                    });
                    Livewire.on('userStore', csid => {
                        var myArray = csid.split("|@|");
                        var cid = myArray[0];
                        var sid = myArray[1];
                        $('.modal-backdrop').remove();
                        swal("Done!", "Student record created successfully.", "success");
                        window.location = url + "registrar/students?cid=" + cid + "&sid=" + sid;
                    });
                    Livewire.on('studentUpdated', csid => {
                        var myArray = csid.split("|@|");
                        var cid = myArray[0];
                        var sid = myArray[1];
                        $('.modal-backdrop').remove();
                        swal("Done!", "Student record updated successfully.", "success");
                        window.location = url + "registrar/students?cid=" + cid + "&sid=" + sid;
                    });
                    Livewire.on('studentDeleted', csid => {
                        var myArray = csid.split("|@|");
                        var cid = myArray[0];
                        var sid = myArray[1];
                        $('.modal-backdrop').remove();
                        swal("Done!", "Student record deleted successfully.", "success");
                        window.location = url + "registrar/students?cid=" + cid + "&sid=" + sid;
                    });
                    Livewire.on('userStoreFailed', errmsg => {    
                        $('#addStudentModal').modal('hide');
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", errmsg, "error");           
                    });
                    Livewire.on('assessmentCreated', () => {
                        $('#AddAssessmentModal').modal('hide');
                        $('.modal-backdrop').remove();
                        swal("Done!", "Summative assessment created successfully.", "success");           
                        window.location = "{{ route('summative.assessment') }}";         
                    });
                    Livewire.on('assessmentUpdated', () => {
                        $('#AddAssessmentModal').modal('hide');
                        $('#updateAssessmentModal').modal('hide');
                        $('.modal-backdrop').remove();
                        swal("Done!", "Summative assessment updated successfully.", "success");
                        window.location = "{{ route('summative.assessment') }}";                      
                    });
                    Livewire.on('assessmentDeleted', () => {
                        $('#deleteAssessmentModal').modal('hide');
                        $('.modal-backdrop').remove();
                        swal("Sorry!", "Summative assessment deleted successfully.", "success");                    
                    });
    
                    Livewire.on('taskCreated', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Done!", "Performance task created successfully.", "success");                         
                    });
                    Livewire.on('taskFailed', errmsg => {                    
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", errmsg, "error");           
                        window.location = "{{ route('performance.task') }}";         
                    });
                    Livewire.on('taskUpdated', () => {                                       
                        $('.modal-backdrop').remove();
                        swal("Done!", "Performance task updated successfully.", "success");                                       
                    });
                    Livewire.on('taskDeleted', () => {                    
                        $('.modal-backdrop').remove();
                        swal("Sorry!", "Summative assessment deleted successfully.", "success");                    
                    });
                    Livewire.on('subjectCreated', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Done!", "Subject created successfully.", "success");                             
                    });
                    Livewire.on('subjectFailed', errmsg => {                    
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", errmsg, "error");           
                        window.location = "{{ route('subject') }}";         
                    });   
                    Livewire.on('subjectUpdated', () => {                                       
                        $('.modal-backdrop').remove();
                        swal("Done!", "Subject updated successfully.", "success"); 
                        //window.location = "{{ route('subject') }}";                                      
                    });    
                    Livewire.on('subjectDeleted', () => {                    
                        $('.modal-backdrop').remove();
                        swal("Sorry!", "Subject deleted successfully.", "success");                    
                    });
                    Livewire.on('usedSubject', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", "This subject is already in use. Cannot be deleted.", "error");                             
                    });
    
                    Livewire.on('criteriaCreated', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Done!", "Criteria created successfully.", "success");  
                        window.location = "{{ route('criteria') }}";
                    });
                    Livewire.on('criteriaUpdated', () => {            
                        $('.modal-backdrop').remove();
                        swal("Done!", "Criteria updated successfully.", "success");                             
                    });
                    Livewire.on('criteriaFailed', errmsg => {                    
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", errmsg, "error");           
                        window.location = "{{ route('criteria') }}";         
                    });
                    Livewire.on('criteriaDeleted', () => {               
                        $('.modal-backdrop').remove();
                        swal("Sorry!", "Criteria deleted successfully.", "success");                    
                    });
                    Livewire.on('usedCriteria', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", "This criteria is already in use. Cannot be deleted.", "error");                             
                    });
                    Livewire.on('criteriaExist', () => {             
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", "This criteria already exist.", "error");                             
                    });
                    Livewire.on('systemCreated', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Done!", "Grading system created successfully.", "success");                             
                    });
                    Livewire.on('systemUpdated', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Done!", "Grading system updated successfully.", "success");                             
                    });
                    Livewire.on('systemFailed', errmsg => {                    
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", errmsg, "error");           
                        window.location = "{{ route('grading.system') }}";         
                    });   
                    Livewire.on('usedSystem', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", "This grading system is already in use. Cannot be deleted.", "error");                             
                    });
                    Livewire.on('systemDeleted', () => {               
                        $('.modal-backdrop').remove();
                        swal("Sorry!", "Grading system deleted successfully.", "success");                    
                    });
    
                    Livewire.on('gradeCriteriaCreated', grcId => {                 
                        $('.modal-backdrop').remove();
                        swal("Done!", "Grade criteria created successfully.", "success");   
                        Livewire.emit('checkCriteriaLimit', grcId);                          
                    });
                    Livewire.on('limitAvailable', percent => { 
                        showToastMessage("You still have " + percent + "% remaining.", 'success');
                    });
                    Livewire.on('gradeCriteriaFailed', cid => {                    
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", "There was an error in the process.", "error");      
                        window.location = url + "grading-criteria/grade-criteria/" + cid;         
                    });
                    Livewire.on('gradeCriteriaLimit', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", "Grade criteria percentage limit exceeded.", "error");                             
                    });
                    Livewire.on('gradeCriteriaDeleted', () => {               
                        $('.modal-backdrop').remove();
                        swal("Sorry!", "Grade criteria deleted successfully.", "success");                    
                    });
    
                    Livewire.on('criteriaLimitExceeded', () => {                                     
                        swal("Oooppsss!", "Grade criteria percentage limit exceeded. Nothing's changed.", "error");                             
                    });
    
                    Livewire.on('sectionCreated', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Done!", "Section created successfully.", "success");                             
                    });
                    Livewire.on('sectionFailed', errmsg => {                    
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", errmsg, "error");           
                        window.location = "{{ route('section') }}";       
                    });
                    Livewire.on('sectionDeleted', () => {               
                        $('.modal-backdrop').remove();
                        swal("Sorry!", "Section deleted successfully.", "success");                    
                    });
                    Livewire.on('sectionUpdated', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Done!", "Section updated successfully.", "success");                             
                    });
    
                    Livewire.on('activityCreated', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Done!", "Class activity created successfully.", "success");                             
                    });
                    Livewire.on('activityUpdated', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Done!", "Class activity updated successfully.", "success");                             
                    });
                    Livewire.on('activityFailed', errmsg => {                
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", errmsg, "error");           
                        window.location = "{{ route('class.activities') }}";       
                    });
                    Livewire.on('activityDeleted', () => {                    
                        $('.modal-backdrop').remove();
                        swal("Sorry!", "Activity deleted successfully.", "success");                    
                    });
                    Livewire.on('usedActivity', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", "This activity is already in use. Cannot be deleted.", "error");                             
                    });
    
                    Livewire.on('sectionActivityCreated', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Done!", "Section activity added successfully.", "success");                             
                    });
                    Livewire.on('sectionActivityFailed', sid => {             
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", "There was an error in the process.", "error");           
                        window.location = url + "registrar/section-activities/" + sid;    
                    });
                    Livewire.on('sectionActivityDeleted', () => {                    
                        $('.modal-backdrop').remove();
                        swal("Sorry!", "Section activity deleted successfully.", "success");                    
                    });
                    Livewire.on('alreadyExist', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", "This activity already exist.", "error");                             
                    });
    
                    Livewire.on('sectionAdded', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Done!", "Section added for the student successfully.", "success");                             
                    });
                    Livewire.on('sectionAdditionFailed', errmsg => {                
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", errmsg, "error");           
                        window.location = "{{ route('students') }}";       
                    });
    
                    Livewire.on('roleCreated', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Done!", "Role created successfully.", "success");                             
                    });
                    Livewire.on('roleUpdated', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Done!", "Role updated successfully.", "success");                             
                    });
                    Livewire.on('roleFailed', errmsg => {                
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", errmsg, "error");           
                        window.location = "{{ route('roles') }}";       
                    });
                    Livewire.on('roleDeleted', () => {                    
                        $('.modal-backdrop').remove();
                        swal("Sorry!", "Role deleted successfully.", "success");                    
                    });
    
                    Livewire.on('permissionCreated', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Done!", "Permission created successfully.", "success");                             
                    });
                    Livewire.on('permissionUpdated', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Done!", "Permission updated successfully.", "success");                             
                    });
                    Livewire.on('permissionFailed', errmsg => {                
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", errmsg, "error");           
                        window.location = "{{ route('permissions') }}";       
                    });
                    Livewire.on('permissionDeleted', () => {                    
                        $('.modal-backdrop').remove();
                        swal("Sorry!", "Permission deleted successfully.", "success");                    
                    });
    
    
                    Livewire.on('userCreated', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Done!", "User created successfully.", "success");                             
                    });
                    Livewire.on('userRoleCreated', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Done!", "User role was added successfully.", "success");                             
                    });
                    Livewire.on('userUpdated', () => {                 
                        $('.modal-backdrop').remove();
                        swal("Done!", "User updated successfully.", "success");                             
                    });
                    Livewire.on('addRoleFailed', errmsg => {                
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", "Error adding a role to this user.", "error");           
                        window.location = "{{ route('users') }}";       
                    });
                    Livewire.on('userFailed', errmsg => {                
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", errmsg, "error");           
                        window.location = "{{ route('users') }}";       
                    });
                    Livewire.on('userDeleted', () => {                    
                        $('.modal-backdrop').remove();
                        swal("Sorry!", "User deleted successfully.", "success");                    
                    });
                    Livewire.on('userRoleRemoved', () => {     
                        $('.modal-backdrop').remove();
                        $('#removeUserRoleModal').modal('hide');
                        swal("Sorry!", "User role removed successfully.", "success");                    
                    });
                    
                    Livewire.on('studentSectionCreated', () => {                 
                        $('.modal-backdrop').remove();
                        $('#addSectionStudentModal').modal('hide');
                        swal("Done!", "Student has been added to this section successfully.", "success");                             
                    });
                    
                    Livewire.on('studentSectionFailed', sid => {      
                        $('.modal-backdrop').remove();
                        $('#deleteStudentSectionModal').modal('hide');
                        swal("Oooppsss!", "There was an error in the process.", "error");           
                        window.location = url + "registrar/section-students/" + sid;   
                    });
                    
                    Livewire.on('studentAlreadyExist', () => {                 
                        $('.modal-backdrop').remove();
                        $('#addSectionStudentModal').modal('hide');
                        swal("Oooppsss!", "This student already exist in this section.", "error");                             
                    });
                    
                    Livewire.on('studentHasSection', () => {                 
                        $('.modal-backdrop').remove();
                        $('#addSectionStudentModal').modal('hide');
                        swal("Oooppsss!", "This student already belongs to the other section.", "error");                             
                    });
                    
                    Livewire.on('sectionSubjectCreated', () => {
                        $('.modal-backdrop').remove();
                        swal("Done!", "Section subject was added successfully.", "success");                             
                    });
                    Livewire.on('sectionSubjectFailed', sid => {
                        $('.modal-backdrop').remove();
                        $('#deleteSectionSubjectModal').modal('hide');
                        swal("Oooppsss!", "There was an error in the process.", "error");           
                        window.location = url + "registrar/section-subjects/" + sid;   
                    });
                    Livewire.on('sectionSubjectDeleted', () => {      
                        $('.modal-backdrop').remove();
                        swal("Sorry!", "Subject removed from this section successfully.", "success");                    
                    });
                    Livewire.on('sectionSubjectExist', () => {           
                        $('.modal-backdrop').remove();
                        $('#addSectionSubjectModal').modal('hide');
                        swal("Oooppsss!", "This subject already exist in this section.", "error");                             
                    });
                    Livewire.on('subjectActivityExist', () => {         
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", "This activity already exist for this subject.", "error");                             
                    });
                    Livewire.on('subjectActivityCreated', () => {               
                        $('.modal-backdrop').remove();
                        swal("Done!", "Subject activity created successfully.", "success");                             
                    });
                    Livewire.on('subjectActivityFailed', errmsg => {      
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", errmsg, "error");
                    });
                    Livewire.on('subjectActivityDeleted', () => {   
                        $('.modal-backdrop').remove();
                        swal("Sorry!", "Activity was removed from the subject successfully.", "success");                    
                    });
                    
                    Livewire.on('activityGradeAdded', () => {
                        $('.modal-backdrop').remove();
                        swal("Done!", "Activity grade was added successfully.", "success");                             
                    });
                    Livewire.on('activityGradeFailed', errmsg => {      
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", errmsg, "error");
                    });
                    Livewire.on('activityGradeDeleted', () => {
                        $('.modal-backdrop').remove();
                        swal("Sorry!", "Activity grade was deleted successfully.", "success");                    
                    });
                    Livewire.on('passwordUpdated', () => {
                        swal("Done!", "Password was changed successfully.", "success");  
                        Livewire.emit('redirectToHome');
                    });
                    Livewire.on('passwordUpdateFailed', errmsg => {
                        swal("Oooppsss!", "There was an error while changing the password: " + errmsg, "error");
                    });
                    Livewire.on('passwordNotFound', () => {
                        swal("Oooppsss!", "Password is not the same as the old one.", "error");
                    });
                    Livewire.on('semesterNotSelected', () => {
                        swal("Oooppsss!", "No active semester for this school year. Please choose one.", "error");
                    });
                    Livewire.on('passCourseValue', cVal => {
                        if ($('#levels' + cVal).is(":checked")) {
                            var val = $('#levels' + cVal).val();
                            Livewire.emit('addCourseId', val);
                        }                
                    });            
                    Livewire.on('semesterValue', sInput => {
                        if ($('#' + sInput).is(":checked")) {
                            var val = $('#' + sInput).val();
                            $("#semester1").prop("checked", false);
                            $("#semester2").prop("checked", false);
                            $("#semester3").prop("checked", false);
                            $('#' + sInput).prop("checked", true);
                            Livewire.emit('addSemesterValue', val);
                        }
                    }); 
                    Livewire.on('resetCheckbox', () => {
                        $("#semester1").prop("checked", false);
                        $("#semester2").prop("checked", false);
                        $("#semester3").prop("checked", false);
                    }); 
                    Livewire.on('checkSemester', sInput => {
                        var val = $('#' + sInput).val();
                        $('#' + sInput).prop("checked", true);
                        Livewire.emit('addSemesterValue', val);
                    }); 
                    Livewire.on('schoolyearCreated', () => {
                        showToastMessage("School year created successfully.", 'success');
                    });
                    Livewire.on('schoolyearUpdated', () => {
                        showToastMessage("School year updated successfully.", 'success');
                    });
                    Livewire.on('schoolyearDeleted', () => {
                        showToastMessage("School year deleted successfully.", 'success');
                    });
                    Livewire.on('schoolyearFailed', errmsg => {
                        swal("Oooppsss!", errmsg, "error");
                    });
                    Livewire.on('schoolyearExist', () => {
                        swal("Oooppsss!", "This school year exist already.", "error");                             
                    });
                    Livewire.on('invalidFormat', () => {
                        swal("Oooppsss!", "Invalid school year format. It should be like (2000-2001)", "error");                             
                    });
                    Livewire.on('schoolyearStatusUpdated', () => {
                        $('.modal-backdrop').remove();
                        swal("Great!", "School year status was changed successfully.", "success");                    
                    });
                    
                    Livewire.on('classFailed', errmsg => {
                        swal("Oooppsss!", errmsg, "error");
                    });
                    Livewire.on('classDeleted', () => {
                        showToastMessage("Class deleted successfully.", 'success');
                    });
                    Livewire.on('classExist', () => {
                        swal("Oooppsss!", "This class exist already.", "error");                             
                    });
                    Livewire.on('subjectCriteriaCreated', csid => {
                        $('#addSubjectCriteriaModal').modal('hide');
                        $('.modal-backdrop').remove();
                        var myArray = csid.split("|@|");
                        var cid = myArray[0];
                        var sid = myArray[1];
                        swal("Done!", "Subject criteria was added successfully.", "success"); 
                        window.location = url + "faculty/subject-criteria?cid=" + cid + "&sid=" + sid;
                    });
                    Livewire.on('subjectCriteriaFailed', errmsg => {
                        $('#addSubjectCriteriaModal').modal('hide');
                        swal("Oooppsss!", errmsg, "error");
                    });
                    Livewire.on('subjectCriteriaDeleted', () => {
                        $('#deleteSubjectCriteriaModal').modal('hide');
                        showToastMessage("Subject criteria was deleted successfully.", 'success');
                    });
                    Livewire.on('subjectCriteriaExist', csid => {
                        $('#addSubjectCriteriaModal').modal('hide');
                        $('.modal-backdrop').remove();
                        var myArray = csid.split("|@|");
                        var cid = myArray[0];
                        var sid = myArray[1];
                        swal("Oooppsss!", "Subject criteria exist already.", "error"); 
                        window.location = url + "faculty/subject-criteria?cid=" + cid + "&sid=" + sid;
                    });
                    Livewire.on('subjectCriteriaUpdated', csid => {
                        $('#editSubjectCriteriaModal').modal('hide');
                        $('.modal-backdrop').remove();
                        var myArray = csid.split("|@|");
                        var cid = myArray[0];
                        var sid = myArray[1];
                        swal("Done!", "Subject criteria was changed successfully.", "success");  
                        window.location = url + "faculty/subject-criteria?cid=" + cid + "&sid=" + sid;
                    });
                    Livewire.on('criteriaStatusUpdated', () => {
                        $('.modal-backdrop').remove();
                        swal("Great!", "Criteria status was changed successfully.", "success");                    
                    });
                    Livewire.on('percentExceeded', () => {  
                        $('.modal-backdrop').remove();
                        swal("Oooppsss!", "Criteria percentage limit exceeded.", "error");       
                        window.location = "{{ route('criteria') }}";
                    });
                });
            </script>
        </body>
</html>
