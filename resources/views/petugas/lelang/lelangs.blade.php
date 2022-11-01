@extends('layouts.app-petugas')

@section('nav-lelang', 'active')
@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Lelang</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Lelang | Semua Lelang</li>
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
                    <i class="fas fa-gavel"></i> Lelang
                    <span class="float-right">
                        <button class="btn btn-success mr-2" data-toggle="modal" data-target="#modal-export">Export <i class="fas fa-file-export"></i></button>
                        @if ($level = Session::get('level') == 'petugas')
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">Tambah Lelang <i class="fas fa-plus"></i></button>
                        @endif
                    </span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <th>ID_Lelang</th>
                                <th>Barang</th>
                                <th>Tanggal Mulai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                @foreach ($dataLelang as $row)
                                <tr>
                                    <td>{{ $row->id_lelang }}</td>
                                    <td>{{ $row->nama_barang }}</td>
                                    <td>{{ $row->start_lelang }}</td>
                                    @if ($row->status == 'dibuka')
                                        <td><span class="badge badge-success">{{ $row->status }}</span></td>
                                    @endif
                                    @if ($row->status == 'ditutup')
                                        <td><span class="badge badge-danger">{{ $row->status }}</span></td>
                                    @endif
                                    @if ($row->status == null)
                                        <td><span class="badge badge-primary">Tersedia</span></td>
                                    @endif
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm btn-detail" data-toggle="modal" data-target="#modalAksi" value="{{ $row->id_lelang }}"><i class="fas fa-bars"></i></button>
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
{{-- Modal Insert --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modalTambah" aria-hidden="true" aria-labelledby="modalAksis">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Lelang</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ url('/petugas/lelang/post') }}" method="post" id="formTambahLelang">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Barang</label>
                        <div class="col-sm-8">
                            <select name="barang-lelang" id="barang-lelang" class="form-control">
                                <option selected value="none">Pilih Barang</option>
                                @foreach ($dataBarang as $item)
                                    <option value="{{ $item->id_barang }}">{{ $item->nama_barang }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Durasi</label>
                        <div class="col-sm-6">
                            <select name="durasi-lelang" id="durasi-lelang" class="form-control">
                                <option selected value="none">Pilih Durasi</option>
                                <option value="1">1 Hari</option>
                                <option value="2">2 Hari</option>
                                <option value="3">3 Hari</option>
                            </select>
                        </div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8 mt-2">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="config-1" name="config-durasi" class="custom-control-input" value="config-1" checked>
                                <label class="custom-control-label" for="config-1">Mulai Lelang saat Data ini dimasukan</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="config-2" name="config-durasi" class="custom-control-input" value="config-2">
                                <label class="custom-control-label" for="config-2">Tentukan Jadwal Mulai</label>
                            </div>
                            <input type="date" name="custom-time-lelang" id="custom-time-lelang" class="form-control mt-2" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Harga</label>
                        <div class="col-sm-8">
                            <input type="number" name="harga-akhir" id="harga-akhir" class="form-control" placeholder="Harga Barang" readonly>
                        </div>
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
<div class="modal fade" id="modalAksi" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Lelang</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">ID Lelang</label>
                            <p class="lead">1</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Barang yang Dilelang</label>
                            <p class="lead">Liquid</p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-bold">Tanggal Entri</label>
                            <p class="lead">12-12-2020</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Tanggal Mulai Lelang</label>
                            <p class="lead">12-12-2020</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Tanggal Akhir Lelang</label>
                            <p class="lead">15-12-2020</p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-bold">Harga Akhir</label>
                            <p class="lead">Rp 2000</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Terakhir Bid</label>
                            <p class="lead">Rey</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Penanggung Jawab</label>
                            <p class="lead">petugas1</p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-bold">Status</label>
                            <p>
                                <span class="badge badge-success badge-lg">Dibuka</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup Detail</button>
            </div>
        </div>
    </div>
</div>
{{-- End Modal Aksi --}}

{{-- Modal Export --}}
<div class="modal fade" id="modal-export" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-file-export"></i>
                    Export
                </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ url('/petugas/lelang/export') }}" method="post" id="form-export">
                @csrf
                <div class="modal-body">
                    <div class="custom-control custom-radio mb-1">
                        <input type="radio" id="radioOne" name="customRadio" class="custom-control-input" value="semuaData">
                        <label class="custom-control-label" for="radioOne">Semua Data Lelang</label>
                    </div>
                    <div class="custom-control custom-radio mb-1">
                        <input type="radio" id="radioTwo" name="customRadio" class="custom-control-input" value="tahunIni">
                        <label class="custom-control-label" for="radioTwo">Tahun Ini</label>
                    </div>
                    <div class="custom-control custom-radio mb-1">
                        <input type="radio" id="radioThree" name="customRadio" class="custom-control-input" value="bulanIni">
                        <label class="custom-control-label" for="radioThree">Bulan Ini</label>
                    </div>
                    <div class="custom-control custom-radio mb-1">
                        <input type="radio" id="radioFour" name="customRadio" class="custom-control-input" value="hariIni">
                        <label class="custom-control-label" for="radioFour">Hari Ini</label>
                    </div>
                    <hr>
                    <div class="custom-control custom-radio mb-1">
                        <input type="radio" id="radioFive" name="customRadio" class="custom-control-input" value="custom">
                        <label class="custom-control-label" for="radioFive">Kustom</label>
                    </div>
                    <div class="form-group mt-3">
                        <label for="tgl_awal">Tanggal Awal</label>
                        <input type="date" name="tgl_awal" id="tgl_awal" class="form-control" placeholder="Tanggal Awal" disabled="disabled">
                    </div>
                    <div class="form-group">
                        <label for="tgl_akhir">Tanggal Akhir</label>
                        <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" placeholder="Tanggal Akhir" disabled="disabled">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success btn-export">Export</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Export --}}
@endsection

@section('script-plus')
<script type="text/javascript">
    $(document).ready(function(){
        $('#dataTable').DataTable();

        $("#formTambahLelang").submit(function(e){
            var form = $(this);
            if(form.find('#config-1').is(':checked')){
                if(form.find('#barang-lelang').val() == 'none' || form.find('#durasi-lelang').val() == 'none' || form.find('#harga-akhir').val() == undefined){
                e.preventDefault();
                    swal.fire({
                        icon: 'error',
                        title: 'Oops',
                        text: 'Isi Semua Kolom'
                    })
                }
            }

            if(form.find('#config-2').is(':checked')){
                if(form.find('#barang-lelang').val() == 'none' || form.find('#custom-time-lelang').val() == 'none' || form.find('#harga-akhir').val() == undefined){
                e.preventDefault();
                    swal.fire({
                        icon: 'error',
                        title: 'Oops',
                        text: 'Isi Semua Kolom'
                    })
                }
            }
        })

        $('#modalTambah').on('show.bs.modal', function(){
            var form = $('#formTambahLelang');
            form.find('#config-1').prop('checked', true);
        })

        $('#modalTambah').on('hidden.bs.modal', function(){
            var form = $('#formTambahLelang');
            form.find('#barang-lelang').val('none');
            form.find('#durasi-lelang').val('none');
            form.find('#custom-time-lelang').val('');
            form.find('#harga-akhir').val('');
        })

        $('input[name=config-durasi]').change(function(){
            var form = $('#formTambahLelang');
            console.log($(this).val());
            var radValue = $(this).val();

            if(radValue == 'config-1'){
                form.find('#durasi-lelang').removeAttr('disabled');
                form.find('#custom-time-lelang').attr('disabled', 'disabled');
                form.find('#custom-time-lelang').val('');
            }
            else{
                form.find('#durasi-lelang').attr('disabled', 'disabled');
                form.find('#durasi-lelang').val('none');
                form.find('#custom-time-lelang').removeAttr('disabled');
            }
        })

        $('#barang-lelang').change(function(){
            var form = $('#formTambahLelang');
            var id_barang = this.value;
            console.log(id_barang);
            var url = '{{ url("/petugas/barang") }}';
            url = url+'/'+id_barang;
            $.ajax({
                url: url,
                success: function(data){
                    form.find('#harga-akhir').attr('value', data[0].harga_awal);
                }
            })
        })

        // View One Lelang
        var id_lelang;
        $(".btn-detail").click(function(){
            id_lelang = $(this).val();
        });

        $("#modalAksi").on('show.bs.modal', function(){
            var modal = $(this);
            var url = '{{ url("/petugas/lelang") }}';
            url = url+'/'+id_lelang;

            var urls = '{{ url("/petugas/lelang/tutup-lelang") }}';
            urls = urls+'/'+id_lelang;
            modal.find('a').attr('href', urls);
            var levelUser = '{{$level = Session::get("level")}}';
            console.log(levelUser);

            modal.find('.modal-body').html('');
            $.ajax({
                type:'GET',
                url: url,
                success: function(data){
                    console.table(data);
                    for(var i = 0; i < data.length; i++){
                        modal.find('.modal-body').append(`
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">ID Lelang</label>
                                    <p class="lead">`+data[i].id_lelang+`</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Barang yang Dilelang</label>
                                    <p class="lead">`+data[i].nama_barang+`</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">Tanggal Entri</label>
                                    <p class="lead">`+data[i].tgl_lelang+`</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Tanggal Mulai Lelang</label>
                                    <p class="lead">`+data[i].start_lelang+`</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Tanggal Akhir Lelang</label>
                                    <div class="lead tgl-akhir">
                                        `+data[i].end_lelang+`
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">Harga Akhir</label>
                                    <p class="lead">Rp `+data[i].harga_akhir+`</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Terakhir Bid</label>
                                    <div class="detPemenang">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Penanggung Jawab</label>
                                    <p class="lead">`+data[i].nama_petugas+`</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">Status</label>
                                    <div class="detailStats">
                                    </div>
                                </div>
                            </div>
                        </div>
                        `);

                        if(data[i].status == 'ditutup'){
                            if(!(data[i].id_user)){
                                modal.find('.detailStats').append(`
                                    <span class="badge badge-danger">`+data[i].status+`</span>
                                `);
                                if(levelUser != 'administrator'){
                                    modal.find('.modal-footer').html('');
                                    modal.find('.modal-footer').append(`
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup Detail</button>
                                        <a href="{{ url('/petugas/lelang/buka-lelang/') }}/`+data[i].id_lelang+`" class="btn btn-primary" id="btn-buka-lelang">Buka Lelang</a>
                                    `);
                                }
                            }
                            else{
                                modal.find('.detailStats').append(`
                                    <span class="badge badge-danger">`+data[i].status+`</span>
                                `);
                                if(levelUser != 'administrator'){
                                    modal.find('.modal-footer').html('');
                                    modal.find('.modal-footer').append(`
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup Detail</button>
                                    `);
                                }
                            }
                        }
                        else if(data[i].status == 'dibuka'){
                            modal.find('.detailStats').append(`
                                <span class="badge badge-success">`+data[i].status+`</span>
                            `);
                            if(levelUser != 'administrator'){
                                modal.find('.modal-footer').html('');
                                modal.find('.modal-footer').append(`
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup Detail</button>
                                    <a href="{{ url('/petugas/lelang/tutup-lelang/') }}/`+data[i].id_lelang+`" class="btn btn-danger" id="btn-tutup-lelang">Tutup Lelang</a>
                                `);
                            }
                        }
                        else if(!(data[i].status)){
                            modal.find('.detailStats').append(`
                                <span class="badge badge-primary">Tersedia</span>
                            `);
                            if(levelUser != 'administrator'){
                                modal.find('.modal-footer').html('');
                                modal.find('.modal-footer').append(`
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup Detail</button>
                                    <a href="{{ url('/petugas/lelang/buka-lelang/') }}/`+data[i].id_lelang+`" class="btn btn-primary" id="btn-buka-lelang">Buka Lelang</a>
                                `);
                            }
                        }

                        if(!(data[i].id_user)){
                            modal.find('.detPemenang').append(`
                                <p class="lead">Belum Ada Pemenang</p>
                            `);
                        }
                        else{
                            modal.find('.detPemenang').append(`
                                <p class="lead">`+data[i].nama_lengkap+`</p>
                            `);
                        }

                        if(!(data[i].end_lelang)){
                            modal.find('.tgl-akhir').html('');
                            modal.find('.tgl-akhir').append('Lelang Berakhir Saat anda menutup lelang');
                        }


                    }
                }
            })
        })

        $('#btn-tutup-lelang').click(function(e){
            e.preventDefault();
            swal.fire({
                title: 'Anda yakin menutup Lelang ID '+id_lelang+' ?',
                text: "Lelang ini tidak bisa dibuka kembali",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Tutup'
            }).then((result) =>{
                if(result.value){
                    window.location = $(this).attr('href');
                }
            })
        });

        var radFive;
        $('#form-export').on('change', function(){
            if($('#radioFive').is(':checked')){
                $('#tgl_awal').removeAttr('disabled', 'disabled');
                $('#tgl_akhir').removeAttr('disabled', 'disabled');
                radFive = true;
            }
            else{
                radFive = false;
                $('#tgl_awal').attr('disabled', 'disabled');
                $('#tgl_akhir').attr('disabled', 'disabled');
                $('#tgl_awal').val('');
                $('#tgl_akhir').val('');
            }
        })

        $('.btn-export').click(function(e){
            var check;
            if($("input:radio[name=customRadio]:checked").length == 0){
                check = false;
            }

            if(check == false){
                e.preventDefault();
                swal.fire({
                    icon: 'warning',
                    title: 'Oops..!!',
                    text: 'Pilih Tipe Export'
                })
            }
            else{
                if(radFive == true){
                    console.log(radFive);
                    if($('#tgl_awal').val() == '' || $('#tgl_akhir').val() == ''){
                        e.preventDefault();
                        swal.fire({
                            icon: 'warning',
                            title: 'Oops..!!',
                            text: 'Harap isi Kolom Form Tanggal Awal dan Akhir'
                        })
                    }
                }
            }
        })
    });
</script>
@endsection
