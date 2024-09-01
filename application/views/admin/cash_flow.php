<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Cash Flow</h1>
    <div class="card shadow mb-4">
        <?php if ($auth['level_id'] != 1): ?>
            <div class="card-header py-3">
                <a href="#" data-toggle="modal" onclick="modalCash()" class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Tambah </span>
                </a>
            </div>
        <?php endif; ?>
        <div class="card">
            <div class="card-body">
                <form action="" id="filter-order">
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="mb-1" for="date">Tanggal</label>
                            <input class="form-control" type="text" id="daterange">
                            <input type="text" id="start_date" name="start_date" hidden>
                            <input type="text" id="end_date" name="end_date" hidden>
                        </div>
                        <div class="col-lg-2">
                            <label class="mb-1" for="tipe_filter">Tipe</label>
                            <select class="form-control" name="tipe_filter" id="tipe_filter">
                                <option value="">Pilih...</option>
                                <option value="masuk">Uang Masuk</option>
                                <option value="keluar">Uang Keluar</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="mb-1" for="waktu_filter">Waktu</label>
                            <select class="form-control" name="waktu_filter" id="waktu_filter">
                                <option value="">Pilih...</option>
                                <option value="siang">Siang</option>
                                <option value="malam">Malam</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="mb-1" for="unit_filter">Unit</label>
                            <select class="form-control select2" name="unit_filter" id="unit_filter">
                                <option value="">Pilih...</option>
                                <?php foreach ($units as $unit): ?>
                                    <option value="<?= $unit->id ?>"><?= $unit->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="mb-4"></label>
                            <button type="submit" class="btn btn-info w-100" id="filter-order"><i
                                    class="mdi mdi-filter"></i>CARI
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered nowrap table-striped" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th>Waktu</th>
                            <th>Transaksi</th>
                            <th>Unit</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCashFlow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="myForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" class="form-control" name="jumlah" id="jumlah" required>
                    </div>
                    dhaby_anggika
                    dhabyAnggika
                    <div class="form-group">
                        <label for="unit">Unit</label>
                        <select class="form-control" name="unit" id="unit">
                            <option value="">Pilih...</option>
                            <?php foreach ($units as $unit): ?>
                                <option value="<?= $unit->id ?>"><?= $unit->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Waktu</label>
                        <select class="form-control" name="waktu" id="waktu" required>
                            <option value="">Pilih...</option>
                            <option value="siang">Siang</option>
                            <option value="malam">Malam</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tipe">Tipe</label>
                        <select class="form-control" name="tipe" id="tipe" required>
                            <option value="">Pilih...</option>
                            <option value="masuk">Uang Masuk</option>
                            <option value="keluar">Uang Keluar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan">
                    </div>
                </div>
                <input type="text" id="id" name="id" hidden>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button id="submitBtn" class="btn btn-primary" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function () {
        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('#start_date').val(start.format('YYYY-MM-DD'));
            $('#end_date').val(end.format('YYYY-MM-DD'));
        }

        $('#daterange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

    });
    $(document).ready(function () {
        $('.select2').select2({
            width: '100%',
        });

        $('#unit').select2({
            width: '100%',
            dropdownParent: $('#modalCashFlow')
        });

        var submitBtn = $('#submitBtn');
        var modal = $('#modalCashFlow');

        function initializeDataTable(endpoint) {
            $('#example').DataTable({
                "processing": true,
                "searching": false,
                "aLengthMenu": [
                    [20, 50, 100, 200, -1],
                    [20, 50, 100, 200, "All"]
                ],
                "serverSide": true,
                "order": [[7, 'desc']],
                "ajax": {
                    "url": endpoint,
                    "type": "POST"
                },
                "deferRender": true,
                "columns": [
                    {
                        "data": null,
                        "render": function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { "data": "keterangan" },
                    {
                        "data": null,
                        "createdCell": function (td, rowData) {
                            const number = parseFloat(rowData.jumlah);
                            $(td).html(formatRupiah(number));
                        }
                    },
                    { "data": "waktu" },
                    { "data": "tipe" },
                    { "data": "name_unit" },
                    { "data": "tanggal" },
                    {
                        "data": "id",
                        "render": function (data, type, row) {
                            return `
<div class="text-center">
    <button class="btn btn-primary btn-sm view-details" onclick="modalCash('${data}')"><i class='fas fa-edit'></i> Edit</button>
    <button class="btn btn-danger btn-sm view-details" onclick="deleteRecord('${data}')"><i class='fas fa-trash'></i> Hapus</button>
</div>
`;
                        }
                    }
                ],
                "dom": "Blfrtip",
                "buttons": [
                    {
                        extend: 'excelHtml5',
                        text: '<span class="fa fa-file-excel-o"></span> Download Excel',
                        className: 'btn btn-primary btn-sm',
                        title: 'Report Cash Flow - ' + formattedDate,
                        exportOptions: {
                            modifier: {
                                page: 'all'
                            },
                            format: {
                                body: function (inner, rowidx, colidx, node) {
                                    if (colidx == 0) {
                                        return rowidx + 1;
                                    } else if (colidx == 2) {
                                        return inner.jumlah;
                                    } else {
                                        return node.innerText;
                                    }
                                }
                            },
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    }
                ]
            });
        }

        function handleFormSubmission() {
            $("#filter-order").on("submit", function (event) {
                event.preventDefault();
                $('#example').DataTable().destroy();

                const data = $(this).serialize();
                const params = new URLSearchParams(data);

                initializeDataTable(base_url + 'CashFlow/datatables?' + params.toString());
            });
        }

        initializeDataTable(base_url + 'CashFlow/datatables');
        handleFormSubmission();

        $('#myForm').on('submit', function (event) {
            event.preventDefault();
            submitBtn.prop('disabled', true).text('Waiting...');

            var formData = $(this).serialize();
            $.ajax({
                url: '<?= base_url('CashFlow/insert'); ?>',
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj.n === "SS") {
                        $.notify(obj.m, "success");
                        modal.modal('hide');
                        $('#example').DataTable().ajax.reload();
                    } else {
                        $.notify(obj.m, "danger");

                    }
                    submitBtn.prop('disabled', false).text('Submit');
                },
                error: function (error) {
                    submitBtn.prop('disabled', false).text('Submit');
                }
            });
        });

    });

    function modalCash(id = "") {
        const modal = $('#modalCashFlow');
        const modalTitle = modal.find('.modal-title');

        if (id) {
            $.ajax({
                url: `<?= base_url('CashFlow/detail/'); ?>${id}`,
                method: 'GET',
                success: function (response) {
                    modalTitle.text('Edit Data');
                    var obj = JSON.parse(response)
                    populateForm(obj);
                    modal.modal('show');
                },
                error: function () {
                    alert('Failed to retrieve data.');
                }
            });
        } else {
            modalTitle.text('Tambah Data');

            clearForm();
            modal.modal('show');
        }
    }

    function deleteRecord(id) {
        if (confirm("Are you sure you want to delete this record?")) {
            $.notify("Deleting record...", "info");

            $.ajax({
                url: `<?= base_url('CashFlow/delete/'); ?>${id}`,
                method: 'DELETE',
                success: function (response) {
                    var obj = JSON.parse(response);
                    if (obj.n === "SS") {
                        $.notify(obj.m, "success");
                        $('#example').DataTable().ajax.reload();
                    }
                },
                error: function () {
                    $.notify("Failed to delete record", "error");
                }
            });
        } else {
            $.notify("Deletion canceled", "info");
        }
    }

    function populateForm(data) {
        $('#jumlah').val(data.jumlah);
        $('#unit').val(data.unit).trigger('change');
        $('#waktu').val(data.waktu);
        $('#tipe').val(data.tipe);
        $('#tanggal').val(data.tanggal);
        $('#keterangan').val(data.keterangan);
        $('#id').val(data.id);
    }

    function clearForm() {
        $('#jumlah').val('');
        $('#unit').val('').trigger('change');
        $('#waktu').val('');
        $('#tipe').val('');
        $('#tanggal').val('');
        $('#keterangan').val('');
        $('#id').val('');
    }

</script>