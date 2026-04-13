<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title><?= $pageTitle; ?></title>


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

    <!-- chosen css -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/chosen_v1.8.7/chosen.min.css">

    <!-- date range picker -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/daterangepicker/daterangepicker.css">

    <!-- swiper carousel css -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/swiper-7.3.1/swiper-bundle.min.css">

    <!-- style css for this template -->
    <link href="<?= base_url(); ?>assets/scss/style.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100 sidebar-pushcontent" data-sidebarstyle="sidebar-pushcontent">
    <!-- sidebar-pushcontent, sidebar-overlay , sidebar-fullscreen  are classes to switch UI here-->

    <!-- page loader -->
    <div class="container-fluid h-100 position-fixed loader-wrap bg-blur">
        <div class="row justify-content-center h-100">
            <div class="col-auto align-self-center text-center">
                <div class="doors animated mb-4">
                    <div class="left-door"></div>
                    <div class="right-door"></div>
                </div>
                <h5 class="mb-0">Thanks for the patience</h5>
                <p class="text-secondary small">Amazing things coming from the <span class="text-dark">WinDOORS</span></p>
                <div class="spinner-border text-primary mt-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    <!-- page loader ends -->

    <!-- background -->
    <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
        <img src="<?= base_url(); ?>assets/img/under-construction.jpg" alt="" />
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
                        </header>
                        <!-- header ends -->
                    </div>
                    <div class="col-12 align-self-center py-4 text-center">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-8 col-lg-7 col-xl-6 col-xxl-4">
                                <!-- <img src="<?= base_url(); ?>assets/img/under-construction1.png" alt="" class="mw-400" /> -->

                                <h1 class="display-5"><?= $pageTitle; ?></h1>
                                <p class="h4 fw-light mb-4">Anda tidak punya hak akses untuk mengakses halaman ini.</p>

                                <p class="text-secondary mt-3 mt-lg-4">Kembali ke halaman dashboard</p>
                                <ul class="nav justify-content-center">
                                    <li class="nav-item">
                                        <a class="btn btn-theme" href="<?= base_url(); ?>">
                                            <i class="bi bi-house h5"></i> Dashboard
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-auto">
                        <!-- footer -->
                        <!-- footer ends -->
                    </div>
                </div>
            </div>

        </div>
    </main>
    <!-- chat window ends -->


    <!-- Required jquery and libraries -->
    <script src="<?= base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/popper.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/bootstrap-5/dist/js/bootstrap.bundle.js"></script>

    <!-- Customized jquery file  -->
    <script src="<?= base_url(); ?>assets/js/main.js"></script>
    <script src="<?= base_url(); ?>assets/js/color-scheme.js"></script>

    <!-- date range picker -->
    <script src="<?= base_url(); ?>assets/js/moment.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/daterangepicker/daterangepicker.js"></script>

    <!-- chosen script -->
    <script src="<?= base_url(); ?>assets/vendor/chosen_v1.8.7/chosen.jquery.min.js"></script>

    <!-- Progress circle js script -->
    <script src="<?= base_url(); ?>assets/vendor/progressbar-js/progressbar.min.js"></script>

    <!-- swiper js script -->
    <script src="<?= base_url(); ?>assets/vendor/swiper-7.3.1/swiper-bundle.min.js"></script>

</body>

</html>