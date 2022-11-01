@extends('layouts.app-masyarakat')

@section('menu', 'Lelang')
@section('nav-lelang', 'active')
@section('content')
<div class="container-fluid mt-5 py-4 px-4">
    <div id="app" class="row">
        <div class="col-md-12 mb-5">
            <h3 class="font-weight-bold text-center mb-3">Daftar Lelang</h3>
            <div class="blue-underline"></div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Filter
                        <span class="float-right"><i class="fas fa-sort-amount-up-alt"></i></span>
                    </h5>
                    <form action="{{ url('/lelang/filter') }}" method="post" id="form-filter">
                        @csrf
                        <div class="custom-control custom-radio mb-1">
                            <input type="radio" id="radioOne" name="customRadio" class="custom-control-input" value="rendah-ke-tinggi">
                            <label class="custom-control-label" for="radioOne">Terendah ke Tertinggi</label>
                        </div>
                        <div class="custom-control custom-radio mb-1">
                            <input type="radio" id="radioTwo" name="customRadio" class="custom-control-input" value="tinggi-ke-rendah">
                            <label class="custom-control-label" for="radioTwo">Tertinggi ke Terendah</label>
                        </div>
                        <div class="custom-control custom-radio mb-1">
                            <input type="radio" id="radioThree" name="customRadio" class="custom-control-input" value="baru-ke-lama">
                            <label class="custom-control-label" for="radioThree">Terbaru ke Terlama</label>
                        </div>
                        <div class="custom-control custom-radio mb-1">
                            <input type="radio" id="radioFour" name="customRadio" class="custom-control-input" value="lama-ke-baru">
                            <label class="custom-control-label" for="radioFour">Terlama ke Terbaru</label>
                        </div>
                        <hr>
                        <div class="custom-control custom-radio mb-1">
                            <input type="radio" id="radioFive" name="customRadio" class="custom-control-input" value="range">
                            <label class="custom-control-label" for="radioFive">Jangkauan Harga</label>
                        </div>
                        <div class="form-group">
                            <div class="input-group mt-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp.</div>
                                </div>
                                <input type="number" name="harga_awal" id="harga_awal" placeholder="Harga Awal" class="form-control" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp.</div>
                                </div>
                                <input type="number" name="harga_akhir" id="harga_akhir" placeholder="Harga Akhir" class="form-control" disabled="disabled">
                            </div>
                        </div>
                        <a href="{{ url('/lelang') }}" class="btn btn-link btn-block mb-3">Reset</a>
                        <button type="submit" class="btn btn-block btn-primary" id="btnTerapkan">Terapkan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
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
                <div class="col-md-12 text-center">
                    {{ $dataLelang->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script-plus')
<script>
    $(document).ready(function(){
        var global_url = '{{ url("/lelang/filter") }}';
        @if($message = Session::get('filter-type') == 'rendah-ke-tinggi')
            $('#radioOne').attr('checked', 'checked');
            $('#form-filter').attr('action', global_url+'/'+'rendah-ke-tinggi');
        @endif

        @if($message = Session::get('filter-type') == 'tinggi-ke-rendah')
            $('#radioTwo').attr('checked', 'checked');
            $('#form-filter').attr('action', global_url+'/'+'tinggi-ke-rendah');
        @endif

        @if($message = Session::get('filter-type') == 'baru-ke-lama')
            $('#radioThree').attr('checked', 'checked');
            $('#form-filter').attr('action', global_url+'/'+'baru-ke-lama');
        @endif

        @if($message = Session::get('filter-type') == 'lama-ke-baru')
            $('#radioFour').attr('checked', 'checked');
            $('#form-filter').attr('action', global_url+'/'+'lama-ke-baru');
        @endif

        @if($message = Session::get('filter-type') == 'range')
            $('#radioFive').attr('checked', 'checked');
            $('#form-filter').attr('action', global_url+'/'+'range');
            $('#harga_awal').removeAttr('disabled');
            $('#harga_akhir').removeAttr('disabled');
            $('#harga_awal').val('{{Session::get("harga-awal")}}');
            $('#harga_akhir').val('{{Session::get("harga-akhir")}}');
        @endif

        $('#form-filter').change(function(e){
            var form = $(this);
            var form_url = '{{ url("/lelang/filter") }}';
            var filter_type;
            if(form.find('#radioOne').is(':checked')){
                filter_type = form.find('#radioOne').val();
                form.attr('action', form_url+'/'+filter_type);
            }

            if(form.find('#radioTwo').is(':checked')){
                filter_type = form.find('#radioTwo').val();
                form.attr('action', form_url+'/'+filter_type);
            }

            if(form.find('#radioThree').is(':checked')){
                filter_type = form.find('#radioThree').val();
                form.attr('action', form_url+'/'+filter_type);
            }

            if(form.find('#radioFour').is(':checked')){
                filter_type = form.find('#radioFour').val();
                form.attr('action', form_url+'/'+filter_type);
            }

            if(form.find('#radioFive').is(':checked')){
                filter_type = form.find('#radioFive').val();
                form.attr('action', form_url+'/'+filter_type);
                $('#harga_awal').removeAttr('disabled');
                $('#harga_akhir').removeAttr('disabled');
            }
            else{
                $('#harga_awal').attr('disabled', 'disabled');
                $('#harga_akhir').attr('disabled', 'disabled');
                $('#harga_awal').val('');
                $('#harga_akhir').val('');
            }
        })

        $('#form-filter').submit(function(e){
            if($('#radioFive').is(':checked')){
                if($('#harga_awal').val() == '' || $('harga_akhir').val() == ''){
                    e.preventDefault();
                    swal.fire({
                        icon: 'error',
                        title: 'Oops..',
                        text: 'Harap Isi Kolom Jangkauan Harga di Bagian Filter'
                    })
                }

                if($('#harga_awal').val() <= 0 || $('harga_akhir').val() <= 0){
                    e.preventDefault();
                    swal.fire({
                        icon: 'error',
                        title: 'Oops..',
                        text: 'Jangkauan Harga harus lebih dari 0'
                    })
                }
            }
        })
    })
</script>
@endsection
