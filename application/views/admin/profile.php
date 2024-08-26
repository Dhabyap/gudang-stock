<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Profile</h1>
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card shadow mb-4 p-4">
                <div class="card-body">
                    <h1 class="text-center"><?= strtoupper($auth['name']) ?></h1>
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
                                <input type="text" value="" class="form-control" name="password"
                                    id="password" required>
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