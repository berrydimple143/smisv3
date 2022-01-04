      <div class="c-sidebar-brand">
            <img src="{{ asset('img/logo.jpg') }}" style='width:100%;'>
      </div>
        <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item item"><a class="c-sidebar-nav-link" href="{{config('app.url')}}">
            <i class="c-icon cil-speedometer c-sidebar-nav-icon"></i> Dashboard</a>
        </li>
        <li class="c-sidebar-nav-title">Modules</li>

        
        @if(Auth::user()->type != "student")
        <li class="c-sidebar-nav-dropdown"><a class="c-sidebar-nav-dropdown-toggle" href="#">
            <i class="c-icon cil-user c-sidebar-nav-icon"></i> Admission</a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">Registration</a></li>
            </ul>
        </li>
        
        <li class="c-sidebar-nav-dropdown"><a class="c-sidebar-nav-dropdown-toggle" href="#">
            <i class="c-icon cil-pen-alt c-sidebar-nav-icon"></i> Registrar</a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="{{ route('student.grade') }}">Student Grades</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="{{ route('subject') }}">Subjects</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="{{ route('section') }}">Sections</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="{{ route('class.activities') }}">Class Activities</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">Courses Offered</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">Courses Curriculum</a></li>
                <li class="c-sidebar-nav-item "><a class="c-sidebar-nav-link sub-nav" href="#"> Curriculum Management</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#"> Subject Units Creditation</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">Add/Drop Subject</a></li>
            </ul>
        </li>
        
        <li class="c-sidebar-nav-dropdown"><a class="c-sidebar-nav-dropdown-toggle" href="#">
            <i class="c-icon cil-pen-alt c-sidebar-nav-icon"></i> Grade Criteria</a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="{{ route('criteria') }}">Criteria</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="{{ route('grading.system') }}">Grading System</a></li>
                <!--<li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="{{ route('summative.assessment') }}">Summative Assessments</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="{{ route('performance.task') }}">Performance Task</a></li>-->
            </ul>
        </li>
       
        <li class="c-sidebar-nav-dropdown"><a class="c-sidebar-nav-dropdown-toggle" href="#">
            <i class="c-icon cil-education c-sidebar-nav-icon"></i> Academics</a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">Class Programs</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">Advise Student</a></li>
            </ul>
        </li>
        
        <li class="c-sidebar-nav-dropdown"><a class="c-sidebar-nav-dropdown-toggle" href="#">
            <i class="c-icon cil-cash c-sidebar-nav-icon"></i> Finance</a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">Fee Collection</a></li>
            </ul>
        </li>
        
        <li class="c-sidebar-nav-dropdown"><a class="c-sidebar-nav-dropdown-toggle" href="#">
            <i class="c-icon cil-voice-over-record c-sidebar-nav-icon"></i> Faculty Portal</a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="{{ route('teachers') }}">Teachers</a></li>                
                <!-- <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="{{config('app.url')}}facultyportal/grade-encoding">Grade Encoding</a></li>            -->
            </ul>
        </li>
        @endif
                
        @if(Auth::user()->type == "student")
        <li class="c-sidebar-nav-dropdown"><a class="c-sidebar-nav-dropdown-toggle" href="#">
            <i class="c-icon cil-contact c-sidebar-nav-icon"></i> Student Portal</a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">Course Evaluation</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">Advise</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">Academic Calendar</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">Student Load</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">COR</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">Student Leger</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">Profile</a></li>
            </ul>
        </li>
        @endif
       

        @if(Auth::user()->type != "student")
        <li class="c-sidebar-nav-title">Administration</li>
        
        <li class="c-sidebar-nav-dropdown"><a class="c-sidebar-nav-dropdown-toggle" a href="#">
            <i class="c-icon cil-people c-sidebar-nav-icon"></i> User Management</a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">Users</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">Roles</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">Permissions</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">Departments</a></li>
            </ul>
        </li>
        
        <li class="c-sidebar-nav-dropdown"><a class="c-sidebar-nav-dropdown-toggle" href="#">
            <i class="c-icon cil-equalizer c-sidebar-nav-icon"></i> Information Mgt. Settings</a>
            <ul class="c-sidebar-nav-dropdown-items">
               
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">Fee Settings</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">Term of Payment</a></li>
               
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">School Year/Term Settings</a></li>
               
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">Section Management</a></li>
               
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">Room Management</a></li>
               
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">Student Req. Settings</a></li>
                
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link sub-nav" href="#">Email Templates</a></li>
               
            </ul>
        </li>
        @endif
    </div>