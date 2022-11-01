@extends('layouts.app-petugas')

@section('nav-barang', 'active')
@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Barang</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Barang</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            @if($message = Session::get('success'))
                <div class="alert alert-success alert-block alert-dismisible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            @if($message = Session::get('error'))
                <div class="alert alert-danger alert-block alert-dismisible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-archive"></i> Barang
                    <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modalTambah">Tambah Barang <i class="fas fa-plus"></i></button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Tanggal Input</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $row)
                                    <tr>
                                        <td>{{ $row->id_barang }}</td>
                                        <td>{{ $row->nama_barang }}</td>
                                        <td>{{ $row->date }}</td>
                                        <td>
                                            <button type="button" id="detailBtn" class="btn btn-sm btn-primary detailBtn" data-toggle="modal" data-target="#modalAksi" value="{{ $row->id_barang }}"><i class="fas fa-bars"></i></button>
                                            <a href="{{ url('/petugas/barang/update/'.$row->id_barang.'') }}" class="btn btn-sm btn-success"><i class="fas fa-pen"></i></a>
                                            <a href="{{ url('/petugas/barang/delete/'.$row->id_barang.'') }}" class="btn btn-sm btn-danger deleteBtn" id="{{ $row->id_barang }}"><i class="fas fa-trash"></i></a>
                                        </td>
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
{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambah" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="modalTambah">Tambah Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ url('/petugas/barang/post') }}" method="POST" id="postBarang" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Barang</label>
                                <input type="text" name="nama_barang" id="nama_barang" class="form-control" placeholder="Nama Barang">
                            </div>
                            <div class="form-group">
                                <label>Harga Awal</label>
                                <input type="number" name="harga_awal" id="harga_awal" class="form-control" placeholder="Harga Awal">
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi_barang" id="deskripsi_barang" rows="5" class="form-control" placeholder="Deskripsi Barang"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Upload Gambar</label>
                                <input type="file" id="imgInp" name="imageBarang[]" accept=".png, .jpg, .jpeg" multiple>
                            </div>
                            <img id="blah" src="https://www.tutsmake.com/wp-content/uploads/2019/01/no-image-tut.png" class="img-fluid" width="200" height="150"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Tambah--}}

{{-- Modal Action --}}
<div class="modal fade" id="modalAksi" tabindex="-1" role="dialog" aria-labelledby="modalAksi" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="modalTambah">Detail Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row no-gutters">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row no-gutters">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">ID Barang</label>
                                    <p class="lead">1</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Nama Barang</label>
                                    <p class="lead">Sabun</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row no-gutters">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Tanggal Input</label>
                                    <p class="lead">21-02-2020</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Harga Awal</label>
                                    <p class="lead">Rp.1000</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Deskripsi</label>
                            <p class="lead">Ini adalah Sabun Alpha Romeo</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Gambar</label>
                            <p>
                                <img src="#" class="img-fluid" style="max-width:120px;">
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </div>
</div>
{{-- End Modal Action --}}
@endsection

@section('script-plus')
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

        $("#postBarang").submit(function(e){
            var modal = $('#modalTambah');
            if(modal.find('#nama_barang').val() == '' || modal.find('#harga_awal').val() == '' || modal.find('#deskripsi_barang').val() == ''  || modal.find('#imgInp').val() == ''){
                e.preventDefault(e);
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Harap isi Semua Form'
                });
            }

            if(modal.find('#harga_awal').val() != ''){
                if(modal.find('#harga_awal').val() <= 0){
                    e.preventDefault(e);
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Harga harus lebih dari 0'
                    });
                }
            }
        });
    $(document).ready(function(){
        $('#dataTable').DataTable();
        $("#modalTambah").on('hidden.bs.modal', function(){
            var modal = $(this);
            modal.find('#nama_barang').val('');
            modal.find('#harga_awal').val('');
            modal.find('#deskripsi_barang').val('');
            modal.find('#imgInp').val('');
            modal.find('#blah').attr('src', 'https://www.tutsmake.com/wp-content/uploads/2019/01/no-image-tut.png');
        });


        $("#imgInp").change(function() {
            readURL(this);
        });

        var id_barang;
        $(".detailBtn").click(function(){
            id_barang = 0;
            id_barang = $(this).val();
        });

        $("#modalAksi").on('show.bs.modal', function(){
            var modal = $(this);
            var url = '{{ url("/petugas/barang") }}';
            url = url+'/'+id_barang;
            modal.find('.modal-body').html('');
            $.ajax({
                url: url,
                success: function(data){
                    modal.find('.modal-body').html(`
                    <div class="row no-gutters">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="row no-gutters">
                                    <div class="col-md-6">
                                        <label class="font-weight-bold">ID Barang</label>
                                        <p class="lead">`+data[0].id_barang+`</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="font-weight-bold">Nama Barang</label>
                                        <p class="lead">`+data[0].nama_barang+`</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row no-gutters">
                                    <div class="col-md-6">
                                        <label class="font-weight-bold">Tanggal Input</label>
                                        <p class="lead">`+data[0].date+`</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="font-weight-bold">Harga Awal</label>
                                        <p class="lead">Rp.`+data[0].harga_awal+`</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Deskripsi</label>
                                <p class="lead">`+data[0].deskripsi_barang+`</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Gambar</label>
                                <p id="sectionGambar">
                                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <img class="d-block w-100" src="..." alt="First slide">
                                            </div>
                                            <div class="carousel-item">
                                                <img class="d-block w-100" src="..." alt="Second slide">
                                            </div>
                                            <div class="carousel-item">
                                                <img class="d-block w-100" src="..." alt="Third slide">
                                            </div>
                                        </div>
                                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                </p>
                            </div>
                        </div>
                    </div>
                    `);

                    var carousel = $('#carouselExampleControls');
                    carousel.find('.carousel-inner').html('');
                    for(var i = 0; i < data.length; i++){
                        if(i == 0){
                            carousel.find('.carousel-inner').append(`
                                <div class="carousel-item active">
                                    <img class="d-block w-100" src="`+ data[i].foto +`" alt="Second slide">
                                </div>
                            `);
                        }
                        else{
                            carousel.find('.carousel-inner').append(`
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="`+ data[i].foto +`" alt="Second slide">
                                </div>
                            `);
                        }
                    }
                }
            })
        });



        $(".deleteBtn").click(function(event){
            var value = $(this).attr('id');
            console.log(value);
            event.preventDefault();
            swal.fire({
                title: 'Anda yakin ?',
                text: "Hapus Data Barang dengan ID = "+value,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus'
            }).then((result) =>{
                if(result.value){
                    window.location = $(this).attr('href');
                }
            })

        });
    });
  </script>
@endsection
