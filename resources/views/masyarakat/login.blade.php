<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Masyarakat | Login') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
<style type="text/css">
    .fulls{
        min-height: 100vh;
    }
</style>
</head>
<body>
    <div id="app" class="bg-login">
        <div class="filter-dark">
            <div class="container">
                <div class="row fulls py-5 align-items-center">
                    <div class="col-md-6">
                        <h1 class="mb-auto text-white"><i class="fas fa-door-open"></i></h1>
                        <br><br><br><br>
                        <h2 class="mt-auto mb-auto text-white display-4 font-weight-bold">Lelang Online</h2>
                        <h4 class="text-white mt-3">Beli barang dengan cara lelang paling mudah, cepat dan terpercaya</h4>
                        <br><br><br><br><br><br><br>
                        <p class="lead text-white">Lelang Online | Sejak 2020.</p>
                    </div>
                    <div class="col-md-6">
                        @if($message = Session::get('error'))
                            <div class="alert alert-danger alert-block alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        <div class="card border-0 shadow px-3 py-4">
                            <div class="card-body">
                                <h2 class="text-center font-weight-bold card-title">Login</h2>
                                <p class="card-text">
                                    <form action="{{ url('/login') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Username</label>
                                            <input type="text" name="username" id="username" placeholder="Username" class="form-control form-control-lg">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Password</label>
                                            <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Password">
                                        </div>
                                        <div class="form-group text-lg-right">
                                            <p>
                                                Belum punya akun ?<a href="{{ url('/register') }}"> Register disini</a>
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-info btn-lg btn-block text-white mt-3">Login</button>
                                        </div>
                                    </form>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
