@extends('layouts.app-petugas')

@section('nav-barang', 'active')
@section('content')
<div class="container-fluid">
    <a href="{{ url('/petugas/barang') }}" class="btn btn-primary mt-4 mb-4 btn-backs"><i class="fas fa-chevron-left"></i> Kembali</a>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                @foreach ($dataBarang as $row)
                    <div class="card-header">
                        <i class="fas fa-archive"></i> Barang ID = <span id="id-barang">{{$row->id_barang}}</span>
                    </div>
                    <form action="{{ url('petugas/barang/update/'.$row->id_barang.'') }}" method="post" id="formUpdateDataBarang" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Barang</label>
                                        <input type="text" name="nama_barang" id="nama_barang" class="form-control" value="{{ $row->nama_barang }}" placeholder="Nama Barang">
                                    </div>
                                    <div class="form-group">
                                        <label>Harga Awal</label>
                                        <input type="number" name="harga_awal" id="harga_awal" class="form-control" value="{{ $row->harga_awal }}" placeholder="Harga Awal">
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea name="deskripsi_barang" id="deskripsi_barang" rows="5" class="form-control" placeholder="Deskripsi Barang">{{ $row->deskripsi_barang }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @if (count($fotoBarang) != 0)
                                    <div class="form-group">
                                        <label>Gambar</label>
                                        <br>
                                        @foreach ($fotoBarang as $foto)
                                            <button type="button" class="btn btn-gambar" data-toggle="modal" data-target="#modalGambar">
                                                <input type="hidden" class="nama-gambar" value="{{ $foto->foto }}">
                                                <img src="{{ $foto->url }}" class="img-fluid mb-3 img-berantai" style="max-width:200px;">
                                            </button>
                                        @endforeach
                                    </div>
                                    @endif
                                    @if (count($fotoBarang) == 0)
                                        <div class="form-group">
                                            <label for="">Gambar</label>
                                            <input type="file" id="imgInp" name="imageBarang[]" accept=".png, .jpg, .jpeg" multiple class="form-control">
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                    <span class="float-right">
                                        <a href="{{ url('/petugas/barang') }}" class="btn btn-dark">Batal</a>
                                        <button type="submit" class="btn btn-primary text-white">Simpan</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                @endforeach
            </div>
        </div>
    </div>
</div>
{{-- Modal Gambar --}}
<div class="modal fade" id="modalGambar" tabindex="-1" aria-labelledby="modalGambar" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalGambar">Edit Gambar</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="" method="post" enctype="multipart/form-data" id="formEditGambar">
                @csrf
                <div class="modal-body">
                    <div class="row no-gutters">
                        <div class="col-md-12 text-center">
                            <img src="" alt="" class="img-fluid" style="max-width:200px;" id="modalGambarUpdate">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit">Edit Gambar</label>
                                <input type="hidden" name="nama-gambar" id="modalNamaGambar" value="">
                                <input type="file" name="gambarBaru" id="editGambar" accept=".png, .jpg, .jpeg">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group text-lg-right">
                                <br>
                                <a href="" class="btn btn-danger" id="btnHapusGambar">Hapus Gambar</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script-plus')
<script type="text/javascript">
    $(document).ready(function(){

        // Global Variable
        var urlGambar, namaGambar;

        $(".btn-gambar").on('click', function(){
            var button = $(this);
            urlGambar = button.find('.img-berantai').attr('src');
            namaGambar = button.find('.nama-gambar').val();
        });

        $("#modalGambar").on('show.bs.modal', function(){
            var modal = $(this);
            var id = $('#id-barang').text();
            var urlAction = '{{ url("/petugas/barang/gambar") }}';
            var urlDelete = urlAction+'/deletes/'+id+'/'+namaGambar;
            urlAction = urlAction+'/edit/'+id;
            modal.find('#modalGambarUpdate').attr('src', urlGambar);
            modal.find('#modalNamaGambar').attr('value', namaGambar);
            modal.find('#formEditGambar').attr('action', urlAction);
            modal.find('#btnHapusGambar').attr('href', urlDelete);
        });

        $("#formUpdateDataBarang").submit(function(e){
            var form = $(this);
            if($('imgInp')){
                if(form.find('#nama_barang').val() == '' || form.find('#harga_awal').val() == '' || form.find('#deskripsi_barang').val() == '' || form.find('#imgInp').val() == ''){
                    e.preventDefault();
                    swal.fire({
                        icon: 'error',
                        title: 'Oops..',
                        text: 'Harap Isi Semua Form'
                    })
                }

                if(form.find('#harga_awal').val() != ''){
                    if(form.find('#harga_awal').val() <= 0){
                        e.preventDefault(e);
                        swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Harga harus lebih dari 0'
                        });
                    }
                }
            }
            else{
                if(form.find('#nama_barang').val() == '' || form.find('#harga_awal').val() == '' || form.find('#deskripsi_barang').val() == ''){
                    e.preventDefault();
                    swal.fire({
                        icon: 'error',
                        title: 'Oops..',
                        text: 'Harap Isi Semua Form'
                    })
                }

                if(form.find('#harga_awal').val() != ''){
                    if(form.find('#harga_awal').val() <= 0){
                        e.preventDefault(e);
                        swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Harga harus lebih dari 0'
                        });
                    }
                }
            }
        });

        $('.btn-backs').on('click', function(e){
            if($('#imgInp').val() == ''){
                e.preventDefault();
                swal.fire({
                    icon: 'error',
                    title: 'Oops..',
                    text: 'Barang Harus memiliki minimal 1 gambar'
                })
            }
        })
    });
</script>
@endsection
