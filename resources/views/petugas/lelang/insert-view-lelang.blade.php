@extends('layouts.app-petugas')

@section('nav-lelang', 'active')
@section('content')
<div class="container-fluid">
    <a href="{{ url('/petugas/lelang') }}" class="btn btn-primary mt-4 mb-4"><i class="fas fa-chevron-left"></i> Kembali</a>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">Tambah Lelang</h5>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Barang yang dilelang</label>
                                <div class="col-sm-8">
                                    <select name="barang-lelang" id="barang-lelang" class="form-control">
                                        <option value="tes">Tes</option>
                                        <option value="tes">Tes</option>
                                        <option value="tes">Tes</option>
                                        <option value="tes">Tes</option>
                                        <option value="tes">Tes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">Durasi</label>
                                <div class="col-sm-6">
                                    <select name="durasi-lelang" id="durasi-lelang" class="form-control">
                                        <option value="1">1 Hari</option>
                                        <option value="2">2 Hari</option>
                                        <option value="3">3 Hari</option>
                                    </select>
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-8 mt-2">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadio1">Mulai Lelang saat Data ini dimasukan</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadio2">Tentukan Jadwal Mulai</label>
                                    </div>
                                    <input type="date" name="custom-time-lelang" id="" class="form-control mt-2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Harga</label>
                                <div class="col-sm-8">
                                    <input type="number" name="harga-akhir" id="harga-akhir" class="form-control" placeholder="Harga Barang">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
