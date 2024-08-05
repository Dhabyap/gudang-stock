<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Account</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="#" data-toggle="modal" onclick="modalAccount()" class="btn btn-success btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah </span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tableAccount" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Level</th>
                            <th>Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAccount" tabindex="-1" role="dialog" aria-hidden="true">
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
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="appartement">Unit</label>
                        <select class="form-control" name="appartement" id="appartement" required>
                            <option value="">Pilih...</option>
                            <?php foreach ($appartements as $appartement): ?>
                                <option value="<?= $appartement->id ?>"><?= $appartement->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="level">Level</label>
                        <select class="form-control" name="level" id="level" required>
                            <option value="">Pilih...</option>
                            <?php foreach ($levels as $level): ?>
                                <option value="<?= $level->id ?>"><?= $level->name ?></option>
                            <?php endforeach; ?>
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
        var modal = $('#modalAccount');

        $('#tableAccount').DataTable({
            "processing": true,
            "searching": false,
            "aLengthMenu": [
                [20, 50, 100, 200, -1],
                [20, 50, 100, 200, "All"]
            ],

            "serverSide": true,
            "order": [[5, 'desc']],
            "ajax": {
                "url": "<?= base_url('Account/datatables'); ?>",
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
                { "data": "email" },
                { "data": "level_id" },
                {
                    "data": "id",
                    "render": function (data, type, row) {
                        return `
                        <div class="text-center">
                            <button class="btn btn-primary btn-sm view-details" onclick="modalAccount('${data}')"><i class='fas fa-edit'></i> Edit</button>
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
                url: '<?= base_url('account/insert'); ?>',
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj.n === "SS") {
                        $.notify(obj.m, "success");
                        modal.modal('hide');
                        $('#tableAccount').DataTable().ajax.reload();
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

    function modalAccount(id = "") {
        const modal = $('#modalAccount');
        const modalTitle = modal.find('.modal-title');

        if (id) {
            $.ajax({
                url: `<?= base_url('Account/detail/'); ?>${id}`,
                method: 'GET',
                success: function (response) {
                    modalTitle.text('Edit Data');

                    var obj = JSON.parse(response)
                    console.log(obj);
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
                url: `<?= base_url('account/delete/'); ?>${id}`,
                method: 'DELETE',
                success: function (response) {
                    var obj = JSON.parse(response);
                    if (obj.n === "SS") {
                        $.notify(obj.m, "success");
                        $('#tableAccount').DataTable().ajax.reload();
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
        $('#email').val(data.email);
        $('#appartement').val(data.id_appartement);
        $('#id').val(data.id);
    }

    function clearForm() {
        $('#name').val('');
        $('#email').val('');
        $('#appartement').val('');
        $('#id').val('');
    }

</script>