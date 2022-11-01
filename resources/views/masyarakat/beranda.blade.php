@extends('layouts.app-masyarakat')

@section('style')

@endsection
@section('menu', 'Beranda')
@section('nav-beranda', 'active')
@section('content')
<div class="bg-beranda">
    <div class="filter-dark">
        <div class="container-fluid px-4 py-5">
            <div class="row height-60 justify-content-center">
                <div class="col-md-12 mb-auto mt-auto text-center">
                    <h1 class="display-4 text-white">Beli Barang dengan Lelang Paling Mudah</h1>
                    <p class="lead text-white">#lelangitumudah</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-12 mb-5">
            <h3 class="font-weight-bold text-center mb-3">Baru dilelang</h3>
            <div class="blue-underline"></div>
        </div>
        @foreach ($dataLelang as $data)
        <div class="col-md-3 mb-3">
            <div class="card card-lelang">
                <div class="card-body">
                    <div class="card-img-top custom-thumnail" style="background-image: url('/barang/image/{{ $data->foto }}');"></div>
                    <h5 class="card-title mt-3">{{ $data->nama_barang }}</h5>
                    <p class="card-text">
                        {{ $data->limitText }}
                    </p>
                </div>
                <div class="card-footer bg-white">
                    <span class="float-left mt-2"><span class="font-weight-bold">Rp</span> {{ $data->harga_akhir }}</span>
                    <a href="{{ url('/lelang/bidding'.'/'.$data->id_lelang.'') }}" class="btn btn-info circle-border text-white float-right"><i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
        @endforeach
        <div class="col-md-12 text-center mt-3">
            <a href="{{ url('/lelang') }}" class="btn btn-lg btn-outline-dark mt-auto mb-auto">Lebih Banyak</a>
        </div>
    </div>
</div>
<div class="container-fluid bg-dark">
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
</div>
@endsection
