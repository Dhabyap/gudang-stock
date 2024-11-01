<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Profile</h1>
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card shadow mb-4 p-4">
                <div class="card-body">
                    <h2 class="text-center"><?= strtoupper($appartement->name) ?>
                        (<?= strtoupper($appartement->owner) ?>)</h2>
                    <form id="myForm">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama">Name</label>
                                <input type="text" value="<?= $auth['name'] ?>" class="form-control" name="nama"
                                    id="nama" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" value="<?= $auth['email'] ?>" class="form-control" name="email"
                                    id="email" disabled>
                            </div>
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" value="" class="form-control" name="password" id="password"
                                    required>
                            </div>
                        </div>
                        <input type="text" id="id" name="id" value="<?= encrypt($auth['id']) ?>" hidden>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <button id="submitBtn" class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#myForm').on('submit', function (event) {
            event.preventDefault();

            var formData = $(this).serialize();
            $.ajax({
                url: '<?= base_url('Profile/update'); ?>',
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj.n == "SS") {
                        $.notify(obj.m, "success");
                        window.location.reload()
                    } else {
                        $.notify(obj.m, "danger");

                    }
                },
                error: function (error) {
                    submitBtn.prop('disabled', false).text('Submit');
                }
            });
        });
    })

</script>