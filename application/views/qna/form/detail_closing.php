<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>Trusmiverse - Form QnA</title>

    <!-- manifest meta -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="<?= base_url(); ?>manifest" href="manifest.json" />

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="180x180">
    <link rel="icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="32x32" type="image/png">
    <link rel="icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="16x16" type="image/png">

    <!-- Google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- bootstrap icons -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/node_modules/bootstrap-icons/font/bootstrap-icons.css">

    <!-- swiper carousel css -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/swiper-7.3.1/swiper-bundle.min.css">

    <!-- style css for this template -->
    <link href="<?= base_url() ?>assets/scss/style.css" rel="stylesheet" id="style">

    <?php $this->load->view('mom/plan_bahan/detail_css'); ?>

    <style>
        .loader {
            display: inline-block;
            text-align: center;
            line-height: 86px;
            text-align: center;
            position: relative;
            padding: 0 48px;
            font-size: 48px;
            font-family: Arial, Helvetica, sans-serif;
            color: #fff;
        }

        .loader:before,
        .loader:after {
            content: "";
            display: block;
            width: 15px;
            height: 15px;
            background: currentColor;
            position: absolute;
            animation: load .7s infinite alternate ease-in-out;
            top: 0;
        }

        .loader:after {
            top: auto;
            bottom: 0;
        }

        @keyframes load {
            0% {
                left: 0;
                height: 43px;
                width: 15px;
                transform: translateX(0)
            }

            50% {
                height: 10px;
                width: 40px
            }

            100% {
                left: 100%;
                height: 43px;
                width: 15px;
                transform: translateX(-100%)
            }
        }
    </style>
</head>

<body class="d-flex flex-column h-100 sidebar-pushcontent" data-sidebarstyle="sidebar-pushcontent">
    <!-- sidebar-pushcontent, sidebar-overlay , sidebar-fullscreen  are classes to switch UI here-->

    <!-- page loader -->
    <div class="container-fluid h-100 position-fixed loader-wrap bg-dark">
        <div class="row justify-content-center h-100">
            <div class="col-auto align-self-center text-center">
                <h5 class="mb-0 text-white text-center">Thanks for the patience</h5>
                <p class="text-white text-center small">Amazing things coming from the <span class="text-white">Trusmiverse</span></p>
                <span class="loader">Loading</span>
            </div>
        </div>
    </div>
    <!-- page loader ends -->

    <!-- background -->
    <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
        <img src="<?= base_url() ?>assets/img/bg-14.jpg" alt="" />
    </div>
    <!-- background ends  -->


    <!-- Begin page content -->
    <main class="main h-100 container-fluid bg-blur rounded-0">
        <div class="row h-100">
            <!-- left block-->
            <div class="col-12 col-md-12 h-100 overflow-y-auto">
                <div class="row">
                    <div class="col-12 mb-auto">
                        <!-- header -->
                        <header class="header">
                            <!-- Fixed navbar -->
                            <nav class="navbar">
                                <div class="container-fluid">
                                    <a class="navbar-brand" href="#">
                                        <div class="row">
                                            <div class="col-auto">
                                                <img src="https://trusmiverse.com/apps/assets/img/logo_trusmiverse.png" class="mx-100 logo-mobile" alt="">
                                            </div>
                                            <div class="col ps-0 align-self-center">
                                                <h5 class="mb-0">Trusmi QnA</h5>
                                            </div>
                                        </div>
                                    </a>
                                    <div>
                                        <a href="<?= base_url(); ?>" class="btn btn-link text-secondary text-center"><i class="bi bi-person-circle me-0 me-lg-1"></i> <span class="d-none d-lg-inline-block"> Dashboard</span></a>
                                    </div>
                                </div>
                            </nav>
                        </header>
                        <!-- header ends -->
                    </div>
                    <div class="col-12 align-self-center py-2 text-center">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-3 col-lg-3 col-xl-3 col-xxl-3"></div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mt-2">
                                <!-- <hr> -->
                                <div class="row" style="display:none" id="spinner_loading">
                                    <div class="col text-center center-spinner">
                                        <div class="spinner-border text-primary mt-3" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Main Page Detail -->
                                <div class="card border-0 mb-4" style="border-radius: 15px !important;">
                                    <div class="card-header" style="border-radius: 15px !important;">
                                        <!-- New -->
                                        <div class="coverimg w-100 h-130 position-relative mb-3 bg-blur" style="border-radius: 15px 15px 0px 0px !important; background-image: url(&quot;<?= base_url(); ?>assets/img/bg-20.jpg&quot;);">
                                            <img src="<?= base_url(); ?>assets/img/bg-20.jpg" class="mw-100" alt="" style="display: none;">
                                        </div>
                                        <!-- End New -->
                                        <h3 class="fw-medium mb-2 text-gradient text-center">Terima Kasih</h3>
                                        <h6 class="text-secondary small mb-2">Anda telah meluangkan waktu untuk menyelesaikan QnA <b><?= $qna['judul']; ?></b>. Kontribusi Anda sangat berharga bagi kami dan akan membantu dalam mengembangkan perusahaan ini.</h6>
                                    </div>
                                </div>
                            </div>                            
                            <div class="col-12 col-md-3 col-lg-3 col-xl-3 col-xxl-3"></div>
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




    <!-- Required jquery and libraries -->
    <script src="<?= base_url() ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url() ?>assets/js/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/bootstrap-5/dist/js/bootstrap.bundle.js"></script>

    <!-- Customized jquery file  -->
    <script src="<?= base_url() ?>assets/js/main.js"></script>
    <script src="<?= base_url() ?>assets/js/color-scheme.js"></script>

    <!-- Chart js script -->
    <script src="<?= base_url() ?>assets/vendor/chart-js-3.3.1/chart.min.js"></script>

    <!-- Progress circle js script -->
    <script src="<?= base_url() ?>assets/vendor/progressbar-js/progressbar.min.js"></script>

    <!-- swiper js script -->
    <script src="<?= base_url() ?>assets/vendor/swiper-7.3.1/swiper-bundle.min.js"></script>


    <script type="text/javascript" src="<?= base_url(); ?>assets/data-table/js/jszip.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/vendor/dragula/dragula.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/vendor/dropzone5-9-3/dropzone.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/paging.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/vendor/progressbar-js/progressbar.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/slimselect/slimselect.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>


    <!-- page level script -->
    <?php $this->load->view('qna/form/detail_js'); ?>

</body>

</html>