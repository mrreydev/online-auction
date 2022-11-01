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
</head>
<body>
    <div class="bg-login">
        <div class="container">
            <div class="row full-height justify-content-center">
                <div class="col-md-6 mt-auto mb-auto text-center">
                </div>
                <div class="col-md-6 mt-auto mb-auto text-center">
                    <h1 class="display-1">404</h1>
                    <h2>Halaman yang kamu cari tidak ada</h2>
                    <button type="button" class="btn btn-dark mt-3" id="kembali">Kembali ke Halaman Sebelumnya</button>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#kembali").click(function(){
            window.history.back();
        })
    });
</script>
</body>
</html>
