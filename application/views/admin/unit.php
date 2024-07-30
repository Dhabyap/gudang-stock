<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Unit</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="#" data-toggle="modal" onclick="modalUnit()" class="btn btn-success btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah </span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUnitFlow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="myForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="tipe">Tipe</label>
                        <select class="form-control" name="tipe" id="tipe" required>
                            <option value="">Pilih...</option>
                            <option value="studio">Studio</option>
                            <option value="1br">1 Bedroom</option>
                            <option value="2br">2 Bedroom</option>
                        </select>
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
    $(document).ready(function () {
        var submitBtn = $('#submitBtn');
        var modal = $('#modalUnitFlow');

        $('#example').DataTable({
            "processing": true,
            "searching": false,
            "aLengthMenu": [
                [20, 50, 100, 200, -1],
                [20, 50, 100, 200, "All"]
            ],

            "serverSide": true,
            "order": [[0, 'desc']],
            "ajax": {
                "url": "<?= base_url('unit/datatables'); ?>",
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
                { "data": "name" },
                { "data": "type" },
                {
                    "data": "id",
                    "render": function (data, type, row) {
                        return `
                        <div class="text-center">
                            <button class="btn btn-primary btn-sm view-details" onclick="modalUnit('${data}')"><i class='fas fa-edit'></i> Edit</button>
                            <button class="btn btn-danger btn-sm view-details" onclick="deleteRecord('${data}')"><i class='fas fa-trash'></i> Hapus</button>
                        </div>
                        `;
                    }
                }
            ]
        });

        $('#myForm').on('submit', function (event) {
            event.preventDefault();
            submitBtn.prop('disabled', true).text('Waiting...');

            var formData = $(this).serialize();
            $.ajax({
                url: '<?= base_url('unit/insert'); ?>',
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj.n === "SS") {
                        $.notify(obj.m, "success");
                        modal.modal('hide');
                        $('#example').DataTable().ajax.reload();
                    }
                    submitBtn.prop('disabled', false).text('Submit');
                },
                error: function (error) {
                    submitBtn.prop('disabled', false).text('Submit');
                }
            });
        });
    });

    function modalUnit(id = "") {
        const modal = $('#modalUnitFlow');
        if (id) {
            $.ajax({
                url: `<?= base_url('unit/detail/'); ?>${id}`,
                method: 'GET',
                success: function (response) {
                    var obj = JSON.parse(response)
                    populateForm(obj);
                    modal.modal('show');
                },
                error: function () {
                    alert('Failed to retrieve data.');
                }
            });
        } else {
            clearForm();
            modal.modal('show');
        }
    }

    function deleteRecord(id) {
        if (confirm("Are you sure you want to delete this record?")) {
            $.notify("Deleting record...", "info");

            $.ajax({
                url: `<?= base_url('unit/delete/'); ?>${id}`,
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
        $('#name').val(data.name);
        $('#tipe').val(data.type);
        $('#id').val(data.id);
    }

    function clearForm() {
        $('#name').val('');
        $('#tipe').val('');
        $('#id').val('');
    }

</script>