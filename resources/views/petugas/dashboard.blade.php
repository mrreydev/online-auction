@extends('layouts.app-petugas')

@section('nav-dashboard', 'active')
@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-5">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-white border-primary text-dark mb-4">
                <div class="card-body">
                    <div class="card-title">
                        <button type="button" class="btn btn-primary btn-lg rounded shadow mt-min-50">
                            <i class="fas fa-user"></i>
                        </button>
                        <h5 class="float-right">Pengguna</h5>
                    </div>
                    <p class="card-text">
                        <h2 class="display-4 text-lg-right">{{ $ctPengguna }}</h2>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-white border-warning text-dark mb-4">
                <div class="card-body">
                    <div class="card-title">
                        <button type="button" class="btn btn-warning btn-lg rounded shadow mt-min-50">
                            <i class="fas fa-archive"></i>
                        </button>
                        <h5 class="float-right">Barang</h5>
                    </div>
                    <p class="card-text">
                        <h2 class="display-4 text-lg-right">{{ $ctBarang }}</h2>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-white border-success text-dark mb-4">
                <div class="card-body">
                    <div class="card-title">
                        <button type="button" class="btn btn-success btn-lg rounded shadow mt-min-50">
                            <i class="fas fa-gavel"></i>
                        </button>
                        <h5 class="float-right">Lelang</h5>
                    </div>
                    <p class="card-text">
                        <h2 class="display-4 text-lg-right">{{ $ctLelang }}</h2>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-white border-danger text-dark mb-4">
                <div class="card-body">
                    <div class="card-title">
                        <button type="button" class="btn btn-danger btn-lg rounded shadow mt-min-50 font-weight-bold">
                            Rp
                        </button>
                        <h5 class="float-right">Bid</h5>
                    </div>
                    <p class="card-text">
                        <h2 class="display-4 text-lg-right">{{ $ctBid }}</h2>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white"><i class="fas fa-chart-area mr-1"></i>Banyak Registrasi Pengguna Dalam 7 Hari Terakhir</div>
                <div class="card-body"><canvas id="myAreaChart" width="100%" height="60"></canvas></div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header bg-danger text-white"><i class="fas fa-chart-bar mr-1"></i>Banyak Bid dalam 7 Hari Terakhir</div>
                <div class="card-body"><canvas id="myBarChart" width="100%" height="60"></canvas></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script-plus')
<script>
    function initBarChart(labelnya, datas) {
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#292b2c';

        // Bar Chart Example
        var ctx = document.getElementById("myBarChart");
        var myLineChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labelnya,
            datasets: [{
            label: "Banyak Bid",
            backgroundColor: "rgba(218, 40, 40,0.7)",
            borderColor: "rgba(2,117,216,1)",
            data: datas,
            }],
        },
        options: {
            scales: {
            xAxes: [{
                time: {
                unit: 'month'
                },
                gridLines: {
                display: true
                },
                ticks: {
                maxTicksLimit: 6
                }
            }],
            yAxes: [{
                ticks: {
                min: 0,
                maxTicksLimit: 5
                },
                gridLines: {
                display: true
                }
            }],
            },
            legend: {
                display: false,
            }
        }
        });
    }

    function initLineChart(labels, datas){
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily =
            '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = "#292b2c";

        // Area Chart Example
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Banyak Registrasi",
                        lineTension: 0.3,
                        backgroundColor: "rgba(2,117,216,0.2)",
                        borderColor: "rgba(2,117,216,1)",
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(2,117,216,1)",
                        pointBorderColor: "rgba(255,255,255,0.8)",
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "rgba(2,117,216,1)",
                        pointHitRadius: 50,
                        pointBorderWidth: 2,
                        fill: false,
                        data: datas
                    }
                ]
            },
            options: {
                scales: {
                    xAxes: [
                        {
                            time: {
                                unit: "date"
                            },
                            gridLines: {
                                display: true
                            },
                            ticks: {
                                maxTicksLimit: 7
                            }
                        }
                    ],
                    yAxes: [
                        {
                            ticks: {
                                min: 0,
                                maxTicksLimit: 5
                            },
                            gridLines: {
                                color: "rgba(0, 0, 0, .125)"
                            }
                        }
                    ]
                },
                legend: {
                    display: false
                }
            }
        });
    }
$(document).ready(function(){
    var labels, datas;
    labels = [
        @foreach($barChartData as $data)
        '{{ $data->dateonly }}',
        @endforeach
    ];

    datas = [
        @foreach($barChartData as $data)
        '{{ $data->datas }}',
        @endforeach
    ];

    var arrInt = new Array();
    var limits = 0;
    for(var i = 0; i < datas.length; i++){
        arrInt.push(parseInt(datas[i]));
    }

    initBarChart(labels, arrInt);

    var labels2, datas2;
    labels2 = [
        @foreach($lineChartData as $data)
            '{{ $data->dateonly }}',
        @endforeach
    ];

    datas2 = [
        @foreach($lineChartData as $data)
            '{{ $data->masData }}',
        @endforeach
    ]

    var arrInt2 = new Array();
    for(var i = 0; i < datas2.length; i++){
        arrInt2.push(datas2[i]);
    }
    initLineChart(labels2, arrInt2);
})
</script>
@endsection
