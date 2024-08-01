<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="<?= staticPath() ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- Custom styles for this template-->
    <link href="<?= staticPath() ?>css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-secondary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-10 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row text-center justify-content-center">
                            <div class="col-lg-8">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Property</h1>
                                    </div>
                                    <form class="user" id="loginForm">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password">
                                        </div>
                                        <button type="submit" class="btn btn-secondary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= staticPath() ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= staticPath() ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= staticPath() ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= staticPath() ?>js/sb-admin-2.min.js"></script>
    <script src="<?= staticPath() ?>js/notify.min.js"></script>


    <script>
        $(document).ready(function () {
            $('#loginForm').on('submit', function (event) {
                event.preventDefault();

                var email = $('#exampleInputEmail').val();
                var password = $('#exampleInputPassword').val();

                $.ajax({
                    url: '<?= base_url('login/insert'); ?>',
                    method: 'POST',
                    data: {
                        email: email,
                        password: password
                    },
                    success: function (response) {
                        var obj = JSON.parse(response);
                        if (obj.n === "SS") {
                            $.notify(obj.m, "success");
                            window.location.href = 'dashboard'
                        } else {
                            $.notify(obj.m, "danger");

                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
        });

    </script>

</body>

</html>