@extends('layouts.app-masyarakat')

@section('menu', 'Bid')
@section('nav-lelang', 'active')
@section('content')
<div class="container py-5 mt-4">
    <div class="row">
        <div class="col-md-12 mb-3">
            <h1>Laman Bid</h1>
        </div>
        @if ($message = Session::get('error'))
        <div class="col-md-12 mb-3">
            <div class="alert alert-danger alert-dismisible show fade" role="alert">
                <button class="close" data-dismiss="alert">&times;</button>
                {{ $message }}
            </div>
        </div>
        @endif
        @if ($message = Session::get('success'))
        <div class="col-md-12 mb-3">
            <div class="alert alert-success alert-dismisible show fade" role="alert">
                <button class="close" data-dismiss="alert">&times;</button>
                {{ $message }}
            </div>
        </div>
        @endif
        <div class="col-md-4">
            <div id="carouselViewBidd" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($fotoBarang as $foto)
                        @php
                            $i++;
                        @endphp
                        @if ($i == 1)
                            <div class="carousel-item active">
                                <img src="{{ $foto->urlFoto }}" class="d-block w-100">
                            </div>
                        @else
                            <div class="carousel-item">
                                <img src="{{ $foto->urlFoto }}" class="d-block w-100">
                            </div>
                        @endif
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselViewBidd" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselViewBidd" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">Keterangan Lelang</h5>
                    @foreach ($dataLelang as $row)
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Barang</label>
                            <p class="lead">{{ $row->nama_barang }}</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Deskripsi Barang</label>
                            <p class="lead">{{ $row->deskripsi_barang }}</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Harga</label>
                            <p class="lead">Rp.
                                <span id="hargaLelang">{{ $row->harga_akhir }}</span></p>
                        </div>
                        <form action="{{ url('/lelang/bidding').'/'.$row->id_lelang }}" method="post" id="postBid">
                            @csrf
                            <input type="hidden" name="id_lelang" value="{{ $row->id_lelang }}">
                            <input type="hidden" name="id_barang" value="{{ $row->id_barang }}">
                            <input type="hidden" name="id_user" value="{{ $id_user = Session::get('id_user') }}">
                            <div class="form-group">
                                <label class="font-weight-bold">Tambah Bid Baru</label>
                                <div class="form-inline">
                                    <input type="number" name="bid_baru" id="bid_baru" class="form-control mr-2">
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                            </div>
                        </form>
                    @endforeach
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Riwayat Bid</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Bidder</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($historyLelang as $history)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>Rp. {{ $history->penawaran_harga }}</td>
                                        <td>{{ $history->nama_lengkap }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script-plus')
<script>
$(document).ready(function(){
    $("#postBid").submit(function(e){
        if($('#bid_baru').val() == ''){
            e.preventDefault();
            swal.fire({
                icon: 'error',
                title: 'Oops..',
                text: 'Isi Kolom Bid !!'
            })
        }
        else{
            var harga_lelang = parseInt($('#hargaLelang').text());
            if($('#bid_baru').val() <= harga_lelang){
                e.preventDefault();
                swal.fire({
                    icon: 'info',
                    title: 'Oops..',
                    text: 'Harga Bid Harus Lebih Tinggi Dari Harga Awal'
                })
            }
        }

        if($('#bid_baru').val() <= 0){
            e.preventDefault();
            swal.fire({
                icon: 'error',
                title: 'Oops..',
                text: 'Harga Bid Harus lebih dari 0'
            })
        }
    })
})
</script>
@endsection
