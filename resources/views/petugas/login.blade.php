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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
<style type="text/css">
    .fulls{
        min-height: 100vh;
    }
</style>
</head>
<body>
    <div id="app">
        <div class="container">
            <div class="row fulls py-5 justify-content-center">
                <div class="col-md-6 mt-auto mb-auto">
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button class="close" data-dismiss="alert">&times;</button>
                            {{ $message }}
                        </div>
                    @endif
                    <div class="card border-0 shadow">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src="{{ asset('images/web/petugas-img.jpg') }}" class="card-img">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Lelang Online | Petugas | Login</h5>
                                    <p class="card-text">
                                        <form action="{{ url('/petugas/login') }}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label for="">Username</label>
                                                <input type="text" name="username" id="username" placeholder="Username" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Password</label>
                                                <input type="password" name="password" id="password" placeholder="Password" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-block">Login</button>
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
    </div>
</body>
</html>
