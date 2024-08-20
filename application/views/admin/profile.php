<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Profile</h1>
    <div class="card shadow mb-4 p-4 justify-content-center text-center">
        <h1><?= strtoupper($auth['name']) ?></h1>
        <div class="card-body">
            <div class="row justify-content-center text-center">
                <div class="col-lg-4 col-12">
                    Email :<?= $auth['email'] ?>
                </div>
                <div class="col-lg-6 col-12">
                    <?php var_dump($auth); ?>
                </div>
            </div>
        </div>
    </div>
</div>