<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Reporting</h1>
    <div class="card shadow mb-4">
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

                    <div class="col-md-2">
                        <label class="mb-4"></label>
                        <button type="submit" class="btn btn-info w-100" id="filter-order"><i
                                class="mdi mdi-filter"></i>CARI</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="report" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Unit</th>
                            <th>Tipe</th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        let globalParams = '';

        function initializeDataTable(url) {
            $('#report').DataTable({
                processing: true,
                searching: false,
                serverSide: true,
                deferRender: true,
                order: [[0, 'desc']],
                aLengthMenu: [
                    [20, 50, 100, 200, -1],
                    [20, 50, 100, 200, "All"]
                ],
                ajax: {
                    url: url,
                    type: "POST"
                },
                columns: [
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: "name",
                        createdCell: function (td, cellData, rowData) {
                            let url = '<?= base_url('report/detail/'); ?>' + rowData.id_unit + '?' + globalParams;
                            $(td).html('<a href="' + url + '">' + cellData + '</a>');
                        }
                    },
                    { data: "type" },
                    {
                        data: "total_masuk",
                        render: function (data, type, row) {
                            return formatRupiah(parseFloat(data));
                        }
                    },
                    {
                        data: "total_keluar",
                        render: function (data, type, row) {
                            return formatRupiah(parseFloat(data));
                        }
                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            const number = parseFloat(row.total_masuk) - parseFloat(row.total_keluar);
                            return formatRupiah(number);
                        }
                    }
                ],
                "dom": "Blfrtip",
                "buttons": [
                    {
                        extend: 'excelHtml5',
                        text: '<span class="fa fa-file-excel-o"></span> Download Excel',
                        className: 'btn btn-primary btn-sm',
                        title: 'Report Unit - ' + formattedDate,
                        exportOptions: {
                            modifier: {
                                page: 'all'
                            },
                            format: {
                                body: function (inner, rowidx, colidx, node) {
                                    if (colidx == 0) {
                                        return rowidx + 1;
                                    } else {
                                        return node.innerText;
                                    }
                                }
                            },
                            columns: [0, 1, 2, 3, 4]
                        }
                    }
                ]
            });
        }


        function handleFormSubmission() {
            $("#filter-order").on("submit", function (event) {
                event.preventDefault();
                const data = $(this).serialize();
                globalParams = new URLSearchParams(data).toString(); // Store params in the global variable

                $('#report').DataTable().destroy();
                initializeDataTable("<?= base_url('report/datatables?'); ?>" + globalParams);
            });
        }

        handleFormSubmission();
        initializeDataTable("<?= base_url('report/datatables'); ?>");
    });



</script>