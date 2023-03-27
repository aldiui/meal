<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Login</title>
    <link rel="icon" href="<?= base_url();?>assets/images/logo.webp" class="rounded" />
    <link href="<?= base_url();?>assets/css/pace.min.css" rel="stylesheet" />
    <script src="assets/js/pace.min.js"></script>
    <link rel="stylesheet" href="<?= base_url();?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&family=Roboto&display=swap" />
    <link rel="stylesheet" href="<?= base_url();?>assets/css/icons.css" />
    <link rel="stylesheet" href="<?= base_url();?>assets/css/app.css" />
</head>

<body class="bg-login">
    <div class="wrapper">
        <div class="section-authentication-login d-flex align-items-center justify-content-center mt-4">
            <div class="row">
                <div class="col-12 col-lg-8 mx-auto">
                    <div class="card radius-15 overflow-hidden">
                        <div class="row g-0 justify-content-center align-items-center">
                            <div class="col-xl-6 h-auto">
                                <div class="card-body p-5">
                                    <div class="text-center">
                                        <img src="<?= base_url();?>assets/images/logo.webp" class="rounded shadow"
                                            width="200" alt="" />
                                        <h3 class="mt-4 fw-bold">Selamat Datang</h3>
                                    </div>
                                    <div class="">
                                        <?= $this->session->flashdata('pesan'); ?>
                                        <div class="login-separater text-center mb-4">
                                            <span>Masuk Menggunakan Username</span>
                                            <hr />
                                        </div>
                                        <div class="form-body">
                                            <form actiion="" class="row g-3" method="POST">
                                                <div class="col-12">
                                                    <label for="username" class="form-label">Masukan Username</label>
                                                    <input type="text" class="form-control" id="username"
                                                        placeholder="Username ..." name="username" />
                                                    <?= form_error("username", '<small class="text-danger">', '</small>');?>
                                                </div>
                                                <div class="col-12">
                                                    <label for="password" class="form-label">Masukan Password</label>
                                                    <div class="input-group" id="show_hide_password">
                                                        <input type="password" class="form-control border-end-0"
                                                            id="password" name="password" placeholder="Password ..." />
                                                        <a href="javascript:;" class="input-group-text bg-transparent">
                                                            <i class="bx bx-hide"></i>
                                                        </a>
                                                    </div>
                                                    <?= form_error("password", '<small class="text-danger">', '</small>');?>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-grid">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="bx bxs-lock-open me-1"></i>Masuk
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 bg-login-color d-flex align-items-center justify-content-center">
                                <img src="<?= base_url();?>assets/images/login-images/login-frent-img.jpg"
                                    class="img-fluid" alt="..." />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="<?= base_url();?>assets/js/jquery.min.js"></script>
<script src="<?= base_url();?>assets/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    $("#show_hide_password a").on("click", function(event) {
        event.preventDefault();
        if ($("#show_hide_password input").attr("type") == "text") {
            $("#show_hide_password input").attr("type", "password");
            $("#show_hide_password i").addClass("bx-hide");
            $("#show_hide_password i").removeClass("bx-show");
        } else if ($("#show_hide_password input").attr("type") == "password") {
            $("#show_hide_password input").attr("type", "text");
            $("#show_hide_password i").removeClass("bx-hide");
            $("#show_hide_password i").addClass("bx-show");
        }
    });
});
</script>

</html>