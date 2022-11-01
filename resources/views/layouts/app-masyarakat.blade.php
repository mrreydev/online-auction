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
    <link href="{{ asset('css/simple-sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @yield('style')
</head>
<body>
    <div class="d-flex toggled" id="wrapper">

        <!-- Sidebar -->
        <div class="bg-white border-right position-fixed border-0 shadow" id="sidebar-wrapper">
            <div class="sidebar-heading">
              Lelang Online
              <button type="button" class="close tutup-sidebar">&times;</button>
            </div>
          <div class="list-group list-group-flush">
            <a href="{{ url('/beranda') }}" class="list-group-item list-group-item-action @yield('nav-beranda')"><i class="fas fa-home mr-3"></i>Beranda</a>
            <a href="{{ url('/lelang') }}" class="list-group-item list-group-item-action @yield('nav-lelang')"><i class="fas fa-gavel mr-3"></i>Lelang</a>
            <a href="{{ url('/riwayat') }}" class="list-group-item list-group-item-action @yield('nav-riwayat')"><i class="fas fa-history mr-3"></i>Riwayat</a>
            <a href="{{ url('/logout') }}" class="list-group-item list-group-item-action"><i class="fas fa-power-off mr-3"></i>Keluar</a>
          </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">

          <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light border-bottom">
            <p class="lead mt-auto mb-auto">
                <button class="btn" id="menu-toggle"><i class="fas fa-bars"></i></button> <span class="ml-3 font-weight-bold">Lelang Online / @yield('menu')</span>
            </p>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link btn btn-sm btn-primary text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell mr-1"></i>
                        <span class="badge badge-light">1</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('/logout') }}">Logout</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    @if ($username = Session::get('username_mas'))
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ $username }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('/logout') }}">Logout</a>
                        </div>
                    @endif
                </li>
              </ul>
            </div>
          </nav>


            @yield('content')

            {{-- <div class="container-fluid bg-dark">
                <div class="row">
                    <div class="col-md-12 mt-3 text-center">
                        <p class="text-white">Copyright &copy; <a href="https://www.instagram.com/_mrrey/" class="text-light">Rey Muhamad Rifqi</a>
                            <script>
                                var year = new Date()
                                document.write(year.getFullYear());
                            </script>
                        </p>
                    </div>
                </div>
            </div> --}}
        </div>
        <!-- /#page-content-wrapper -->

      </div>
      <!-- /#wrapper -->

      <!-- Menu Toggle Script -->
      <script>
        $("#menu-toggle").click(function(e) {
          e.preventDefault();
          $("#wrapper").toggleClass("toggled");
        //   if($("#wrapper").toggleClass("toggled")){
        //       $("#sidebar-wrapper").removeClass('border-0');
        //   }
        });

        $('.tutup-sidebar').click(function(e){
            $("#wrapper").toggleClass("toggled");
        })
      </script>

      @yield('script-plus')
</body>
</html>
