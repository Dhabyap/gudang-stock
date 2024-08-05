<div class="container-fluid">
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Pendapatan (Monthly)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= isset($countData->cash_flow_masuk) ? rupiah($countData->cash_flow_masuk) : 0 ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Pengeluaran (Monthly)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= isset($countData->cash_flow_keluar) ? rupiah($countData->cash_flow_keluar) : 0 ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Unit</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $countData->unit_count ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-home fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div id="chartUnit"></div>
            </div>
        </div>
        <div class="col-12 mt-4">
            <div class="card p-3">
                <div id="chartTransaksi"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $.ajax({
            url: '<?= base_url('dashboard/getChartData') ?>',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                var options = {
                    series: [{
                        data: data.series
                    }],
                    chart: {
                        type: 'bar',
                        height: 380
                    },
                    plotOptions: {
                        bar: {
                            barHeight: '100%',
                            distributed: true,
                            horizontal: true,
                            dataLabels: {
                                position: 'bottom'
                            },
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        textAnchor: 'start',
                        style: {
                            colors: ['#fff']
                        },
                        formatter: function (val, opt) {
                            return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val;
                        },
                        offsetX: 0,
                        dropShadow: {
                            enabled: true
                        }
                    },
                    stroke: {
                        width: 2,
                        colors: ['#fff']
                    },
                    colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e',
                        '#f48024', '#69d2e7'
                    ],
                    xaxis: {
                        categories: data.categories
                    },
                    yaxis: {
                        labels: {
                            show: false
                        }
                    },
                    title: {
                        text: 'Transaksi Unit per Bulan',
                        align: 'center',
                        floating: true
                    },
                    tooltip: {
                        theme: 'dark',
                        x: {
                            show: false
                        },
                        y: {
                            title: {
                                formatter: function () {
                                    return '';
                                }
                            }
                        }
                    }
                };
                var chart = new ApexCharts(document.querySelector("#chartUnit"), options);
                chart.render();
            },
            error: function (error) {
                console.error('Error fetching data:', error);
            }
        });

        $.ajax({
            url: '<?= base_url('dashboard/getChartTransaksi') ?>',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                var options = {
                    series: data.series,
                    chart: {
                        height: 350,
                        type: 'line',
                        dropShadow: {
                            enabled: true,
                            color: '#000',
                            top: 18,
                            left: 7,
                            blur: 10,
                            opacity: 0.2
                        },
                        zoom: {
                            enabled: false
                        },
                        toolbar: {
                            show: false
                        },

                    },
                    colors: ['#14EB17', '#E1341E'],

                    stroke: {
                        curve: 'smooth'
                    },
                    title: {
                        text: 'Cash Flow per Hari Bulan ini',
                        align: 'center'
                    },
                    xaxis: {
                        categories: data.categories,
                        title: {
                            text: 'Date'
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Amount'
                        },
                        min: 0,
                        max: Math.max(...data.series[0].data, ...data.series[1].data) + 10
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                        floating: true,
                        offsetY: -25,
                        offsetX: -5
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function (value) {
                            return formatRupiah(value);
                        }
                    },
                };
                var chart = new ApexCharts(document.querySelector("#chartTransaksi"), options);
                chart.render();
            },
            error: function (error) {
                console.error('Error fetching data:', error);
            }
        });
    })



</script>