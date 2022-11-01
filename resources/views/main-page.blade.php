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
</head>
<body>
    <div id="app">
        <div class="container">
            <div class="row py-5 justify-content-center">
                <div class="col-md-4">
                    <p class="lead">
                        Main Page <br>
                        @if ($message = Session::get('masyarakat'))
                            {{ $message }}
                            <br>
                            <a href="{{ url('/logout') }}">Logout</a>
                        @endif
                        @if ($message = Session::get('petugas'))
                            {{ $message }}
                            <a href="{{ url('/petugas/logout') }}">Logout</a>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
