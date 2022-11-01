@extends('layouts.app-petugas')

@section('nav-petugas', 'active')
@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Petugas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Petugas | Seluruh Petugas</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block alert-dismisible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ $message }}
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block alert-dismisible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ $message }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user"></i> Petugas
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modalTambahPetugas">Tambah Petugas <i class="fas fa-plus"></i></button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <th>ID Petugas</th>
                                <th>Nama Petugas</th>
                                <th>Level</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                @foreach ($data as $row)
                                    <tr>
                                        <td>{{ $row->id_petugas }}</td>
                                        <td>{{ $row->nama_petugas }}</td>
                                        <td>{{ $row->level }}</td>
                                        @if (Session::get('username') == $row->username)
                                        <td><span class="badge badge-success">Ini Kamu</span></td>
                                        @endif
                                        @if (!$sessions = Session::get('username') == $row->username)
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm btn-edit" value="{{ $row->id_petugas }}" data-toggle="modal" data-target="#modalAksi"><i class="fas fa-pen"></i></button>
                                            <a href="{{ url('/petugas/manage-petugas/delete/'.$row->id_petugas.'') }}" class="btn btn-danger btn-sm btn-hapus" id="{{ $row->id_petugas }}"><i class="fas fa-trash"></i></a>
                                        </td>
                                        @endif
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
{{-- Modal Tambah Petugas --}}
<div class="modal fade" tabindex="-1" id="modalTambahPetugas" role="dialog" aria-hidden="true" aria-labelledby="Petugas">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Petugas</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ url('/petugas/manage-petugas/post') }}" method="post" id="formTambahPetugas">
                @csrf
                <div class="modal-body">
                    
                    <div class="form-group">
                        <label>Nama Petugas</label>
                        <input type="text" name="nama_petugas" id="nama_petugas" placeholder="Nama Petugas" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" id="username" placeholder="Username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi</label>
                        <input type="password" name="confirm" id="confirm" class="form-control" placeholder="Konfirmasi Password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Aksi --}}
<div class="modal fade" tabindex="-1" id="modalAksi" role="dialog" aria-labelledby="Aksi" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Petugas</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ url('/petugas/manage-petugas/update') }}" method="post" id="modalEditForm">
                @csrf
                <div class="modal-body" id="modalAksiBody">
                    ....
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary edit-ptg">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('script-plus')
<script type="text/javascript">
    $(document).ready(function(){
        $('#dataTable').DataTable();
        // Global Variable
        var id_petugas;
        $("#formTambahPetugas").submit(function(e){
            var form = $(this);
            if(form.find('#nama_petugas').val() == '' || form.find('#username').val() == '' ||form.find('#password').val() == '' || form.find('#confirm') == ''){
                e.preventDefault();
                swal.fire({
                    icon: 'error',
                    title: 'Oops..',
                    text: 'Harap Isi Semua Form'
                });
            }

            if(form.find('#password').val() != form.find('#confirm').val()){
                e.preventDefault();
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Konfirmasi Password  Tidak Sama'
                });
            }
        });

        $("#modalTambahPetugas").on('hidden.bs.modal', function(){
            var modal = $(this);
            modal.find('#nama_petugas').val('');
            modal.find('#username').val('');
            modal.find('#password').val('');
            modal.find('#confirm').val('');
        });

        $(".btn-edit").on('click', function(){
            id_petugas = $(this).attr('value');
            $("#modalAksi").on('show.bs.modal', function(){
                var modal = $(this);
                var urls = '{{ url("/petugas/manage-petugas") }}';
                var urlAction = urls+'/update/'+id_petugas;
                modal.find('#modalEditForm').attr('action', urlAction);
                urls = urls+'/'+id_petugas;
                modal.find('#modalAksiBody').html('');
                $.ajax({
                    url: urls,
                    success: function(data){
                        console.log(data);
                        for(var i = 0; i < data.length; i++){
                            modal.find('#modalAksiBody').append(`
                                <div class="form-group">
                                    <label>Nama Petugas</label>
                                    <input type="text" name="nama_petugas" id="nama_petugas" placeholder="Nama Petugas" class="form-control nama_petugas" value="`+ data[i].nama_petugas +`">
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name="username" id="username" placeholder="Username" class="form-control username" value="`+ data[i].username +`">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" id="password" class="form-control password" placeholder="Masukan Password Baru" value="">
                                </div>
                            `);
                        }
                    }
                })
            });
        });

        $(".edit-ptg").click(function(e){
            if($('.username').val() == '' || $('.nama_petugas').val() == '' || $('.password').val() == ''){
                e.preventDefault();
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Harap isi form password baru'
                });
            }
        });

        $(".btn-hapus").click(function(e){
            var id_petugas = $(this).attr('id');
            e.preventDefault();
            swal.fire({
                title: 'Anda yakin ?',
                text: "Hapus Data Petugas dengan ID = "+id_petugas,
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
        })
    });
</script>
@endsection
