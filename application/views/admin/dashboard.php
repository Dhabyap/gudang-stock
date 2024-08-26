<div class="container-fluid">
    <!-- <div class="row mb-2">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="" id="filter-order">
                        <div class="row">
                            <div class="col-lg-3">
                                <label class="mb-1" for="month_filter">Bulan</label>
                                <select class="form-control select2" name="month_filter" id="month_filter">
                                    <option value="">Pilih...</option>
                                    <?php foreach ($months as $key => $month): ?>
                                        <option value="<?= $key ?>" <?= ($key == $current_month) ? 'selected' : '' ?>>
                                            <?= $month ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label class="mb-1" for="year_filter">Tahun</label>
                                <select class="form-control select2" name="year_filter" id="year_filter">
                                    <option value="">Pilih...</option>
                                    <option value="2024" selected>2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> -->

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
        // Function to update the URL with selected values and reload the page
        function updateURL() {
            let month = $('#month_filter').val();
            let year = $('#year_filter').val();

            let queryParams = new URLSearchParams(window.location.search);

            // Update or delete the query parameters based on the selected values
            if (month) {
                queryParams.set('month_filter', month);
            } else {
                queryParams.delete('month_filter');
            }

            if (year) {
                queryParams.set('year_filter', year);
            } else {
                queryParams.delete('year_filter');
            }

            // Reload the page with the updated query parameters
            window.location.search = queryParams.toString();
        }

        // Attach the change event handler using jQuery
        $('#month_filter').on('change', function () {
            $(this).prop('selected', true);  // Ensure the selected value is set
            updateURL();  // Update URL and reload the page
        });

        $('#year_filter').on('change', function () {
            $(this).prop('selected', true);  // Ensure the selected value is set
            updateURL();  // Update URL and reload the page
        });
    })


</script>