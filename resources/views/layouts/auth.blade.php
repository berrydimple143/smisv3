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
        </body>
</html>
