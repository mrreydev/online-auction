<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Petugas | Login') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <link href="{{ url('/dashboard/dist/css/styles.css') }}" rel="stylesheet">
    <link href="{{ url('/dashboard/dist/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @yield('style')
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ url('/barang/dashboard') }}">Lelang Online</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button
        ><!-- Navbar Search-->
        <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        </div>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if ($username = Session::get('username'))
                        {{ $username }}
                        <br>
                        @if ($level = Session::get('level') == 'administrator')
                            <span class="badge badge-success">Admin</span>
                        @elseif($level = Session::get('level') == 'petugas')
                            <span class="badge badge-success">Petugas</span>
                        @endif
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="{{ url('/petugas/logout') }}">Logout
                        <span class="float-right"><i class="fas fa-power-off"></i></span>
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link @yield('nav-dashboard')" href="{{ url('/petugas/dashboard') }}"
                            ><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard</a
                        >
                        <a class="nav-link @yield('nav-barang')" href="{{ url('/petugas/barang') }}"
                            ><div class="sb-nav-link-icon"><i class="fas fa-archive"></i></div>
                            Barang</a
                        >
                        @if ($admin = Session::get('level') == 'administrator')
                        <a class="nav-link @yield('nav-petugas')" href="{{ url('/petugas/manage-petugas') }}"
                            ><div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Petugas</a
                        >
                        @endif
                        <a class="nav-link @yield('nav-lelang')" href="{{ url('/petugas/lelang') }}"
                            ><div class="sb-nav-link-icon"><i class="fas fa-gavel"></i></div>
                            Lelang</a
                        >
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    @if ($username = Session::get('username'))
                        {{ $username }}
                    @endif
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                @yield('content')
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; WInG</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{url('dashboard/dist/js/scripts.js')}}"></script>
    <script src="{{url('dashboard/dist/js/Chart.min.js')}}"></script>
    <script src="{{url('dashboard/dist/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('dashboard/dist/js/dataTables.bootstrap4.min.js')}}"></script>
    @if ($username = !Session::get('username'))
    <script>
        $(document).ready(function(){
            window.history.back();
        });
    </script>
    @endif
    @yield('script-plus')
</body>
</html>
