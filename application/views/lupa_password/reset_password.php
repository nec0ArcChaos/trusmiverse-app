<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>Trusmiverse</title>

    <!-- manifest meta -->
    <meta name="trusmiverse" content="yes">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="180x180">
    <link rel="icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="32x32" type="image/png">
    <link rel="icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="16x16" type="image/png">

    <!-- Google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- bootstrap icons -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css"> -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/node_modules/bootstrap-icons/font/bootstrap-icons.css">

    <!-- swiper carousel css -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/swiper-7.3.1/swiper-bundle.min.css">

    <!-- style css for this template -->
    <link href="<?= base_url(); ?>assets/scss/style.css" rel="stylesheet" id="style">
</head>

<body class="d-flex flex-column h-100 sidebar-pushcontent" data-sidebarstyle="sidebar-pushcontent">
    <!-- sidebar-pushcontent, sidebar-overlay , sidebar-fullscreen  are classes to switch UI here-->

    <!-- page loader -->
    <!-- <div class="container-fluid h-100 position-fixed loader-wrap bg-blur">
        <div class="row justify-content-center h-100">
            <div class="col-auto align-self-center text-center">
                <h5 class="mb-0">Terimakasih sudah menunggu</h5>
                <p class="text-secondary small">Amazing things coming from the <span class="text-dark">Trusmiverse</span></p>
                <div class="spinner-border text-primary mt-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div> -->
    <!-- page loader ends -->

    <!-- background -->
    <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
        <img src="<?= base_url() ?>assets/img/bg-1.jpg" alt="" class="w-100" />
    </div>
    <!-- background ends  -->


    <!-- Begin page content -->
    <main class="main h-100 container-fluid bg-blur rounded-0">
        <div class="row h-100">
            <!-- left block-->
            <div class="col-12 col-md-12 h-100 overflow-y-auto">
                <div class="row h-100">
                    <div class="col-12 mb-auto">
                        <!-- header -->
                        <header class="header">
                            <!-- Fixed navbar -->
                            <nav class="navbar">
                                <div class="container-fluid">
                                    <a class="navbar-brand" href="<?= base_url() ?>login">
                                        <div class="row">
                                            <div class="col-auto"><img src="<?= base_url() ?>assets/img/logo_trusmiverse.png" class="mx-100" alt="" /></div>
                                            <div class="col ps-0 align-self-center">
                                                <h5 class="fw-normal text-dark">Trusmiverse</h5>
                                                <p class="small text-secondary">Recovery Account</p>
                                            </div>
                                        </div>
                                    </a>
                                    <div>
                                    </div>
                                </div>
                            </nav>
                        </header>
                        <!-- header ends -->
                    </div>
                    <div class="col-12 align-self-center py-4">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-11 col-lg-10 col-xl-4 col-xxl-4">
                                <p class="mb-4">
                                    <a href="<?= base_url() ?>login"><i class="bi bi-arrow-left"></i> Kembali ke Login</a>
                                </p>
                                <p class="h4 fw-light mb-4">Reset Password Akun Anda</p>
                                <p class="text-secondary small mb-4">
                                    Mohon masukkan username Anda yang terdaftar pada sistem kami. Kami akan mengirimkan kode OTP ke nomor yang terdaftar untuk membantu Anda mereset kata sandi akun Anda.
                                </p>
                                <form class="mb-4 was-validated" method="post" action="<?= base_url('lupa_password/send_otp') ?>">
                                    <?php if ($this->session->flashdata('error')): ?>
                                        <div class="alert alert-danger fade show mb-2" role="alert">
                                            <div class="row">
                                                <div class="col"><strong><?= $this->session->flashdata('error') ?></strong></div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($this->session->flashdata('success')): ?>
                                        <div class="alert alert-success fade show mb-2" role="alert">
                                            <div class="row">
                                                <div class="col"><strong><?= $this->session->flashdata('success') ?></strong></div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <!-- alert messages -->
                                    <div class="alert alert-danger fade show d-none mb-2 global-alert" role="alert">
                                        <div class="row">
                                            <div class="col"><strong>Wajib!</strong> Harap masukkan data yang valid.</div>
                                        </div>
                                    </div>

                                    <div class="alert alert-success fade show d-none mb-2 global-success" role="alert">
                                        <div class="row">
                                            <div class="col-auto align-self-center">
                                                <div class="spinner-border spinner-border-sm text-success me-2" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </div>
                                            <div class="col ps-0 align-self-center">
                                                <strong>Proses mengirim Kode OTP!</strong><br>Check pesan masuk Whatsapp anda.
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form elements -->
                                    <div class="form-group mb-2 position-relative check-valid is-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-envelope"></i></span>
                                            <div class="form-floating">
                                                <input type="text" placeholder="username" id="username" name="username" required class="form-control border-start-0" required autofocus>
                                                <label>Username</label>
                                            </div>
                                            <!-- submit button -->
                                            <button class="btn btn-lg btn-theme z-index-5 btn-square-lg" type="submit" id="submitforgetpassbtn"><i class="bi bi-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-auto">
                        <!-- footer -->
                        <footer class="footer row">
                            <div class="col-12 col-md-12 col-lg py-2">
                                <span class="text-secondary small">Copyright @2022, IT Trusmi Group
                            </div>
                        </footer>
                        <!-- footer ends -->
                    </div>
                </div>
            </div>
        </div>

    </main>




    <!-- Required jquery and libraries -->
    <script src="<?= base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/popper.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/bootstrap-5/dist/js/bootstrap.bundle.js"></script>

    <!-- Customized jquery file  -->
    <script src="<?= base_url(); ?>assets/js/main.js"></script>
    <script src="<?= base_url(); ?>assets/js/color-scheme.js"></script>

    <script>
        $('#submitforgetpassbtn').on('click', function(e) {
            e.preventDefault();
            if ($('#username').val() == "") {
                $(this).closest('form').find('.global-alert').removeClass('d-none');
                setTimeout(function() {
                    $('.global-alert').addClass('d-none');
                }, 3000)
            } else {
                $(this).prop('disabled', true);
                $(this).empty().append(`<div class="spinner-border" role="status">
                    <span class="sr-only"></span>
                </div>`);
                $(this).closest('form').find('.global-success').removeClass('d-none');
                $(this).closest('form').find('.global-alert').addClass('d-none');
                $(this).closest('form').submit();
            }
        });
    </script>
</body>

</html>