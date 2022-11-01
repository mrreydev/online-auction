@extends('layouts.app-masyarakat')

@section('menu', 'Riwayat')
@section('nav-riwayat', 'active')
@section('content')
<div class="container py-5 mt-5">
    <div class="row">
        <div class="col-md-12 mb-3">
            <h3 class="font-weight-bold text-center mb-3">Riwayat Lelang</h3>
            <div class="blue-underline"></div>
        </div>
        <div class="col-md-12">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-menang-tab" data-toggle="tab" href="#nav-menang-lelang" role="tab" aria-controls="nav-menang-lelang" aria-selected="true">Menang Lelang</a>
                    <a class="nav-item nav-link" id="nav-diikuti-tab" data-toggle="tab" href="#nav-diikuti" role="tab" aria-controls="nav-diikuti" aria-selected="false">Yang Pernah Anda Ikuti</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade py-3 show active" id="nav-menang-lelang" role="tabpanel" aria-labelledby="nav-menang-tab">
                    {{-- Riwayat Menang Lelang --}}
                    <div class="container-fluid">
                        <div class="row">
                            @if (count($menangLelang) != 0)
                                @foreach ($menangLelang as $data)
                                    <div class="col-md-3 mb-3">
                                        <div class="card card-lelang">
                                            <div class="card-body">
                                                <div class="card-img-top custom-thumnail" style="background-image: url('/barang/image/{{ $data->foto }}');"></div>
                                                <h5 class="card-title mt-3">{{ $data->nama_barang }}</h5>
                                                <p class="card-text">
                                                    {{ $data->deskripsi_barang }}
                                                </p>
                                            </div>
                                            <div class="card-footer bg-white">
                                                <span class="float-left mt-2"><span class="font-weight-bold">Rp</span> {{ $data->harga_akhir }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @if (count($menangLelang) == 0)
                                <div class="col-md-12 text-center mt-5">
                                    <img src="{{ url('/images/web/undraw_empty_1.svg') }}" alt="" srcset="" class="img-fluid" style="max-width: 300px;">
                                    <p class="lead mt-3">Anda Belum Memenangkan Lelang Apapun</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- End Riwayat Menang Lelang --}}
                </div>
                <div class="tab-pane fade py-3" id="nav-diikuti" role="tabpanel" aria-labelledby="nav-diikuti-tab">
                    {{-- Riwayat Lelang --}}
                    <div class="container-fluid">
                        <div class="row">
                            @if (count($ikutiLelang) != 0)
                                @foreach ($ikutiLelang as $data)
                                    <div class="col-md-3 mb-3">
                                        <div class="card card-lelang">
                                            <div class="card-body">
                                                <div class="card-img-top custom-thumnail" style="background-image: url('/barang/image/{{ $data->foto }}');"></div>
                                                <h5 class="card-title mt-3">{{ $data->nama_barang }}</h5>
                                                <p class="card-text">
                                                    {{ $data->deskripsi_barang }}
                                                </p>
                                            </div>
                                            <div class="card-footer bg-white">
                                                <span class="float-left mt-2"><span class="font-weight-bold">Rp</span> {{ $data->harga_akhir }}</span>
                                                @if ($data->status == 'dibuka')
                                                <a href="{{ url('/lelang/bidding'.'/'.$data->id_lelang.'') }}" class="btn btn-info circle-border text-white float-right"><i class="fas fa-arrow-right"></i></a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @if (count($ikutiLelang) == 0)
                                <div class="col-md-12 text-center mt-5">
                                    <img src="{{ url('/images/web/undraw_empty_2.svg') }}" alt="" srcset="" class="img-fluid" style="max-width: 300px;">
                                    <p class="lead mt-3">Anda Belum Mengikuti Lelang Apapun</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- End Riwayat Lelang --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
