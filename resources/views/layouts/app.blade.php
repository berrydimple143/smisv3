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
                window.livewire.on('userStore', csid => {
                    var myArray = csid.split("|@|");
                    var cid = myArray[0];
                    var sid = myArray[1];
                    $('.modal-backdrop').remove();
                    swal("Done!", "Student record created successfully.", "success");
                    window.location = "https://smisv2.altustechit.com/registrar/students?cid=" + cid + "&sid=" + sid;
                });
                window.livewire.on('studentUpdated', csid => {
                    var myArray = csid.split("|@|");
                    var cid = myArray[0];
                    var sid = myArray[1];
                    $('.modal-backdrop').remove();
                    swal("Done!", "Student record updated successfully.", "success");
                    window.location = "https://smisv2.altustechit.com/registrar/students?cid=" + cid + "&sid=" + sid;
                });
                window.livewire.on('studentDeleted', csid => {
                    var myArray = csid.split("|@|");
                    var cid = myArray[0];
                    var sid = myArray[1];
                    $('.modal-backdrop').remove();
                    swal("Done!", "Student record deleted successfully.", "success");
                    window.location = "https://smisv2.altustechit.com/registrar/students?cid=" + cid + "&sid=" + sid;
                });
                window.livewire.on('userStoreFailed', errmsg => {    
                    $('#addStudentModal').modal('hide');
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", errmsg, "error");           
                });
                window.livewire.on('assessmentCreated', () => {
                    $('#AddAssessmentModal').modal('hide');
                    $('.modal-backdrop').remove();
                    swal("Done!", "Summative assessment created successfully.", "success");           
                    window.location = "{{ route('summative.assessment') }}";         
                });
                window.livewire.on('assessmentUpdated', () => {
                    $('#AddAssessmentModal').modal('hide');
                    $('#updateAssessmentModal').modal('hide');
                    $('.modal-backdrop').remove();
                    swal("Done!", "Summative assessment updated successfully.", "success");
                    window.location = "{{ route('summative.assessment') }}";                      
                });
                window.livewire.on('assessmentDeleted', () => {
                    $('#deleteAssessmentModal').modal('hide');
                    $('.modal-backdrop').remove();
                    swal("Sorry!", "Summative assessment deleted successfully.", "success");                    
                });

                window.livewire.on('taskCreated', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Done!", "Performance task created successfully.", "success");                         
                });
                window.livewire.on('taskFailed', errmsg => {                    
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", errmsg, "error");           
                    window.location = "{{ route('performance.task') }}";         
                });
                window.livewire.on('taskUpdated', () => {                                       
                    $('.modal-backdrop').remove();
                    swal("Done!", "Performance task updated successfully.", "success");                                       
                });
                window.livewire.on('taskDeleted', () => {                    
                    $('.modal-backdrop').remove();
                    swal("Sorry!", "Summative assessment deleted successfully.", "success");                    
                });
                window.livewire.on('subjectCreated', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Done!", "Subject created successfully.", "success");                             
                });
                window.livewire.on('subjectFailed', errmsg => {                    
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", errmsg, "error");           
                    window.location = "{{ route('subject') }}";         
                });   
                window.livewire.on('subjectUpdated', () => {                                       
                    $('.modal-backdrop').remove();
                    swal("Done!", "Subject updated successfully.", "success"); 
                    //window.location = "{{ route('subject') }}";                                      
                });    
                window.livewire.on('subjectDeleted', () => {                    
                    $('.modal-backdrop').remove();
                    swal("Sorry!", "Subject deleted successfully.", "success");                    
                });
                window.livewire.on('usedSubject', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", "This subject is already in use. Cannot be deleted.", "error");                             
                });

                window.livewire.on('criteriaCreated', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Done!", "Criteria created successfully.", "success");                             
                });
                window.livewire.on('criteriaUpdated', () => {            
                    $('.modal-backdrop').remove();
                    swal("Done!", "Criteria updated successfully.", "success");                             
                });
                window.livewire.on('criteriaFailed', errmsg => {                    
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", errmsg, "error");           
                    window.location = "{{ route('criteria') }}";         
                });
                window.livewire.on('criteriaDeleted', () => {               
                    $('.modal-backdrop').remove();
                    swal("Sorry!", "Criteria deleted successfully.", "success");                    
                });
                window.livewire.on('usedCriteria', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", "This criteria is already in use. Cannot be deleted.", "error");                             
                });
                window.livewire.on('criteriaExist', () => {             
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", "This criteria already exist.", "error");                             
                });
                window.livewire.on('systemCreated', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Done!", "Grading system created successfully.", "success");                             
                });
                window.livewire.on('systemUpdated', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Done!", "Grading system updated successfully.", "success");                             
                });
                window.livewire.on('systemFailed', errmsg => {                    
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", errmsg, "error");           
                    window.location = "{{ route('grading.system') }}";         
                });   
                window.livewire.on('usedSystem', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", "This grading system is already in use. Cannot be deleted.", "error");                             
                });
                window.livewire.on('systemDeleted', () => {               
                    $('.modal-backdrop').remove();
                    swal("Sorry!", "Grading system deleted successfully.", "success");                    
                });

                window.livewire.on('gradeCriteriaCreated', grcId => {                 
                    $('.modal-backdrop').remove();
                    swal("Done!", "Grade criteria created successfully.", "success");   
                    Livewire.emit('checkCriteriaLimit', grcId);                          
                });
                window.livewire.on('limitAvailable', percent => { 
                    var toastMixin = Swal.mixin({
                        toast: true,
                        icon: 'success',
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
                        title: "You still have " + percent + "% remaining."
                    });                                                              
                });
                window.livewire.on('gradeCriteriaFailed', cid => {                    
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", "There was an error in the process.", "error");      
                    window.location = "https://smisv2.altustechit.com/grading-criteria/grade-criteria/" + cid;         
                });
                window.livewire.on('gradeCriteriaLimit', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", "Grade criteria percentage limit exceeded.", "error");                             
                });
                window.livewire.on('gradeCriteriaDeleted', () => {               
                    $('.modal-backdrop').remove();
                    swal("Sorry!", "Grade criteria deleted successfully.", "success");                    
                });

                window.livewire.on('criteriaLimitExceeded', () => {                                     
                    swal("Oooppsss!", "Grade criteria percentage limit exceeded. Nothing's changed.", "error");                             
                });

                window.livewire.on('sectionCreated', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Done!", "Section created successfully.", "success");                             
                });
                window.livewire.on('sectionFailed', errmsg => {                    
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", errmsg, "error");           
                    window.location = "{{ route('section') }}";       
                });
                window.livewire.on('sectionDeleted', () => {               
                    $('.modal-backdrop').remove();
                    swal("Sorry!", "Section deleted successfully.", "success");                    
                });
                window.livewire.on('sectionUpdated', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Done!", "Section updated successfully.", "success");                             
                });

                window.livewire.on('activityCreated', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Done!", "Class activity created successfully.", "success");                             
                });
                window.livewire.on('activityUpdated', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Done!", "Class activity updated successfully.", "success");                             
                });
                window.livewire.on('activityFailed', errmsg => {                
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", errmsg, "error");           
                    window.location = "{{ route('class.activities') }}";       
                });
                window.livewire.on('activityDeleted', () => {                    
                    $('.modal-backdrop').remove();
                    swal("Sorry!", "Activity deleted successfully.", "success");                    
                });
                window.livewire.on('usedActivity', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", "This activity is already in use. Cannot be deleted.", "error");                             
                });

                window.livewire.on('sectionActivityCreated', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Done!", "Section activity added successfully.", "success");                             
                });
                window.livewire.on('sectionActivityFailed', sid => {             
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", "There was an error in the process.", "error");           
                    window.location = "https://smisv2.altustechit.com/registrar/section-activities/" + sid;    
                });
                window.livewire.on('sectionActivityDeleted', () => {                    
                    $('.modal-backdrop').remove();
                    swal("Sorry!", "Section activity deleted successfully.", "success");                    
                });
                window.livewire.on('alreadyExist', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", "This activity already exist.", "error");                             
                });

                window.livewire.on('sectionAdded', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Done!", "Section added for the student successfully.", "success");                             
                });
                window.livewire.on('sectionAdditionFailed', errmsg => {                
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", errmsg, "error");           
                    window.location = "{{ route('students') }}";       
                });

                window.livewire.on('roleCreated', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Done!", "Role created successfully.", "success");                             
                });
                window.livewire.on('roleUpdated', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Done!", "Role updated successfully.", "success");                             
                });
                window.livewire.on('roleFailed', errmsg => {                
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", errmsg, "error");           
                    window.location = "{{ route('roles') }}";       
                });
                window.livewire.on('roleDeleted', () => {                    
                    $('.modal-backdrop').remove();
                    swal("Sorry!", "Role deleted successfully.", "success");                    
                });

                window.livewire.on('permissionCreated', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Done!", "Permission created successfully.", "success");                             
                });
                window.livewire.on('permissionUpdated', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Done!", "Permission updated successfully.", "success");                             
                });
                window.livewire.on('permissionFailed', errmsg => {                
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", errmsg, "error");           
                    window.location = "{{ route('permissions') }}";       
                });
                window.livewire.on('permissionDeleted', () => {                    
                    $('.modal-backdrop').remove();
                    swal("Sorry!", "Permission deleted successfully.", "success");                    
                });


                window.livewire.on('userCreated', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Done!", "User created successfully.", "success");                             
                });
                window.livewire.on('userRoleCreated', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Done!", "User role was added successfully.", "success");                             
                });
                window.livewire.on('userUpdated', () => {                 
                    $('.modal-backdrop').remove();
                    swal("Done!", "User updated successfully.", "success");                             
                });
                window.livewire.on('addRoleFailed', errmsg => {                
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", "Error adding a role to this user.", "error");           
                    window.location = "{{ route('users') }}";       
                });
                window.livewire.on('userFailed', errmsg => {                
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", errmsg, "error");           
                    window.location = "{{ route('users') }}";       
                });
                window.livewire.on('userDeleted', () => {                    
                    $('.modal-backdrop').remove();
                    swal("Sorry!", "User deleted successfully.", "success");                    
                });
                window.livewire.on('userRoleRemoved', () => {     
                    $('.modal-backdrop').remove();
                    $('#removeUserRoleModal').modal('hide');
                    swal("Sorry!", "User role removed successfully.", "success");                    
                });
                
                window.livewire.on('studentSectionCreated', () => {                 
                    $('.modal-backdrop').remove();
                    $('#addSectionStudentModal').modal('hide');
                    swal("Done!", "Student has been added to this section successfully.", "success");                             
                });
                
                window.livewire.on('studentSectionFailed', sid => {      
                    $('.modal-backdrop').remove();
                    $('#deleteStudentSectionModal').modal('hide');
                    swal("Oooppsss!", "There was an error in the process.", "error");           
                    window.location = "https://smisv2.altustechit.com/registrar/section-students/" + sid;   
                });
                
                window.livewire.on('studentAlreadyExist', () => {                 
                    $('.modal-backdrop').remove();
                    $('#addSectionStudentModal').modal('hide');
                    swal("Oooppsss!", "This student already exist in this section.", "error");                             
                });
                
                window.livewire.on('studentHasSection', () => {                 
                    $('.modal-backdrop').remove();
                    $('#addSectionStudentModal').modal('hide');
                    swal("Oooppsss!", "This student already belongs to the other section.", "error");                             
                });
                
                window.livewire.on('sectionSubjectCreated', () => {
                    $('.modal-backdrop').remove();
                    swal("Done!", "Section subject was added successfully.", "success");                             
                });
                window.livewire.on('sectionSubjectFailed', sid => {
                    $('.modal-backdrop').remove();
                    $('#deleteSectionSubjectModal').modal('hide');
                    swal("Oooppsss!", "There was an error in the process.", "error");           
                    window.location = "https://smisv2.altustechit.com/registrar/section-subjects/" + sid;   
                });
                window.livewire.on('sectionSubjectDeleted', () => {      
                    $('.modal-backdrop').remove();
                    swal("Sorry!", "Subject removed from this section successfully.", "success");                    
                });
                window.livewire.on('sectionSubjectExist', () => {           
                    $('.modal-backdrop').remove();
                    $('#addSectionSubjectModal').modal('hide');
                    swal("Oooppsss!", "This subject already exist in this section.", "error");                             
                });
                window.livewire.on('subjectActivityExist', () => {         
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", "This activity already exist for this subject.", "error");                             
                });
                window.livewire.on('subjectActivityCreated', () => {               
                    $('.modal-backdrop').remove();
                    swal("Done!", "Subject activity created successfully.", "success");                             
                });
                window.livewire.on('subjectActivityFailed', errmsg => {      
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", errmsg, "error");
                });
                window.livewire.on('subjectActivityDeleted', () => {   
                    $('.modal-backdrop').remove();
                    swal("Sorry!", "Activity was removed from the subject successfully.", "success");                    
                });
                
                window.livewire.on('activityGradeAdded', () => {
                    $('.modal-backdrop').remove();
                    swal("Done!", "Activity grade was added successfully.", "success");                             
                });
                window.livewire.on('activityGradeFailed', errmsg => {      
                    $('.modal-backdrop').remove();
                    swal("Oooppsss!", errmsg, "error");
                });
                window.livewire.on('activityGradeDeleted', () => {
                    $('.modal-backdrop').remove();
                    swal("Sorry!", "Activity grade was deleted successfully.", "success");                    
                });
                window.livewire.on('passwordUpdated', () => {
                    swal("Done!", "Password was changed successfully.", "success");  
                    Livewire.emit('redirectToHome');
                });
                window.livewire.on('passwordUpdateFailed', errmsg => {
                    swal("Oooppsss!", "There was an error while changing the password: " + errmsg, "error");
                });
                window.livewire.on('passwordNotFound', () => {
                    swal("Oooppsss!", "Password is not the same as the old one.", "error");
                });
                window.livewire.on('semesterNotSelected', () => {
                    swal("Oooppsss!", "No active semester for this school year. Please choose one.", "error");
                });
                window.livewire.on('passCourseValue', cVal => {
                    if ($('#levels' + cVal).is(":checked")) {
                        var val = $('#levels' + cVal).val();
                        Livewire.emit('addCourseId', val);
                    }                
                });            
                window.livewire.on('semesterValue', sInput => {
                    if ($('#' + sInput).is(":checked")) {
                        var val = $('#' + sInput).val();
                        $("#semester1").prop("checked", false);
                        $("#semester2").prop("checked", false);
                        $("#semester3").prop("checked", false);
                        $('#' + sInput).prop("checked", true);
                        Livewire.emit('addSemesterValue', val);
                    }
                }); 
                window.livewire.on('resetCheckbox', () => {
                    $("#semester1").prop("checked", false);
                    $("#semester2").prop("checked", false);
                    $("#semester3").prop("checked", false);
                }); 
                window.livewire.on('checkSemester', sInput => {
                    var val = $('#' + sInput).val();
                    $('#' + sInput).prop("checked", true);
                    Livewire.emit('addSemesterValue', val);
                }); 
                window.livewire.on('schoolyearCreated', () => {
                    var toastMixin = Swal.mixin({
                        toast: true,
                        icon: 'success',
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
                        title: "School year created successfully."
                    });                                                              
                });
                window.livewire.on('schoolyearUpdated', () => {
                    var toastMixin = Swal.mixin({
                        toast: true,
                        icon: 'success',
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
                        title: "School year updated successfully."
                    });                                                              
                });
                window.livewire.on('schoolyearDeleted', () => {
                    var toastMixin = Swal.mixin({
                        toast: true,
                        icon: 'success',
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
                        title: "School year deleted successfully."
                    });                                                              
                });
                window.livewire.on('schoolyearFailed', errmsg => {
                    swal("Oooppsss!", errmsg, "error");
                });
                window.livewire.on('schoolyearExist', () => {
                    swal("Oooppsss!", "This school year exist already.", "error");                             
                });
                window.livewire.on('invalidFormat', () => {
                    swal("Oooppsss!", "Invalid school year format. It should be like (2000-2001)", "error");                             
                });
            </script>
        </body>
</html>
