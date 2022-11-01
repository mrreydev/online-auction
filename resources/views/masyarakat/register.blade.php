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
    <div id="app" class="bg-register">
        <div class="filter-dark">
            <div class="container">
                <div class="row full-height py-3 align-items-center justify-content-center">
                    <div class="col-md-6">
                        <h1 class="mb-auto text-white"><i class="fas fa-door-open"></i></h1>
                        <br><br><br><br>
                        <h2 class="mt-auto mb-auto text-white display-4 font-weight-bold">Keuntungan dimulai disini</h2>
                        <h4 class="text-white mt-3">Beli barang dengan cara lelang paling mudah, cepat dan terpercaya</h4>
                        <br><br><br><br><br><br><br>
                        <p class="lead text-white">Lelang Online | Sejak 2020.</p>
                    </div>
                    <div class="col-md-6">
                        @if($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        <div class="card border-0 shadow py-3 px-3">
                            <div class="card-body">
                            <h2 class="card-title text-center font-weight-bold mb-4">Gabung ke Lelang Online</h2>
                            <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="{{ url('/register') }}" method="POST" id="formRegister">
                                            @csrf
                                            <div class="form-row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Nama Lengkap</label>
                                                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" placeholder="Nama Lengkap">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Username</label>
                                                        <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Password</label>
                                                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Konfirmasi</label>
                                                        <input type="password" name="confirm" id="confirm" class="form-control" placeholder="Konfirmasi">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Telepon</label>
                                                <input type="number" name="telepon" class="form-control" id="number" placeholder="Telepon">
                                            </div>
                                            <p class="float-right">Sudah punya akun ? <a href="{{ url('/') }}">Login disini</a></p>
                                            <button type="submit" class="btn btn-info btn-block  btn-lg text-white">Gabung</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#formRegister').submit(function(e){
                var form = $(this);
                if(form.find('#nama_lengkap').val() == '' || form.find('#username').val() == '' || form.find('#password').val() == '' || form.find('#confirm').val() == '' || form.find('#number').val() == ''){
                    e.preventDefault();
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Harap isi Semua Form'
                    })
                }

                if(form.find('#password').val() != form.find('#confirm').val()){
                    e.preventDefault();
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Cek Kembali Password anda'
                    })
                }
            })
        });
    </script>
</body>
</html>
