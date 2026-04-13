<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title><?= $pageTitle; ?></title>

    <!-- manifest meta -->
    <!-- <meta name="apple-mobile-web-app-capable" content="yes"> -->
    <!-- <link rel="manifest" href="manifest.json" /> -->

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

    <!-- simple lightbox css -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/simplelightbox/simple-lightbox.min.css">

    <!-- app tour css -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/Product-Tour-Plugin-jQuery/lib.css">

    <!-- Data Table Css -->
    <!-- https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap.min.css">
    <!-- https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/dataTables.bootstrap5.min.css">
    <!-- https://cdn.datatables.net/rowreorder/1.3.1/css/rowReorder.dataTables.min.css -->
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.3.1/css/rowReorder.dataTables.min.css">
    <!-- https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">

    <!-- PNOTIFY -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/icon/icofont/css/icofont.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bower_components/pnotify/css/pnotify.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bower_components/pnotify/css/pnotify.brighttheme.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bower_components/pnotify/css/pnotify.buttons.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/pages/pnotify/notify.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/toogle-switch/toggle-switchy.css">
    <!-- PNOTIFY -->

    <!-- style css for this template -->
    <link href="<?= base_url(); ?>assets/scss/style.css" rel="stylesheet">


    <style>
        .dataTables_filter .form-control {
            border: 1px solid #F1F1F1;
        }

        .dataTables_length .form-select {
            border: 1px solid #F1F1F1;
        }

        .mywrapper {
            width: 100%;
            max-width: 100%;
            display: flex;
            justify-content: space-around;
            white-space: nowrap;
        }

        .rows {
            height: 33.333333333333333333%;
        }

        .cols {
            width: 25vw;
            height: 25vw;
            /*float: right;*/
            /*height: 100%;*/
            text-align: center;
            vertical-align: middle;
            display: inline-block;
        }
    </style>


    <?php if (isset($css)) {
        $this->load->view($css);
    } ?>


    <style>
        @media only screen and (max-width: 767px) {
            .mywrapper {
                overflow-x: scroll;
            }

            /* .navbar-brand {
                display: none;
            } */

            .btn-nav-app-2 {
                display: none;
            }

            .btn-nav-search-2 {
                display: none;
            }

            #searchtoggle {
                display: none;

            }

            .mobile-dark-mode {
                max-width: 80px;
                max-height: 40px;
            }

            .logo-mobile {
                max-height: 26px !important;
                margin-top: 5px;
            }
        }

        .custom-dark-mode-icon>input+.toggle::before {
            font-family: "Font Awesome 5 Free";
            content: "\f186";
            padding-right: 3px;
            vertical-align: middle;
            font-weight: 100;
        }

        .custom-dark-mode-icon>input+.toggle::after {
            font-family: "Bootstrap-icons";
            content: "\F1D2";
            padding-left: 3px;
            vertical-align: middle;
            font-weight: 100;
        }

        .dark-mode .ui.form .field>label:not(.button) {
            color: white;
            font-weight: normal;
        }

        .ui.form .field>label:not(.button) {
            font-weight: normal;
        }

        /* .dark-mode .ui.selection.dropdown {
            color: #d8dadd;
        }

        .dark-mode .ui.dropdown.selection {
            background: #474b52;
        }

        .dark-mode .ui.dropdown .menu>.item {
            background: #474b52;
            color: #b2b5b4;
            border-top: 1px solid #2e3035;
        }

        .dark-mode .ui.dropdown .menu>.item:hover {
            color: #d8dadd;
            z-index: 13;
            background: #3d4047;
        }

        .dark-mode .ui.dropdown.selected,
        .dark-mode .ui.dropdown .menu .selected.item {
            color: #d8dadd;
            z-index: 13;
            background: #3d4047;
        }

        .dark-mode .ui.selection.dropdown .menu>.item {
            border-top: 1px solid #2e3035;
        }

        .dark-mode .ui.selection.visible.dropdown>.text:not(.default) {
            font-weight: normal;
            color: #d8dadd;
        } */

        .highlight { font-weight: bold; background-color: #cddbea; }
        .hidden { display: none; }
        .disabled-link { 
            pointer-events: none; 
            color: gray; 
            cursor: default; 
            text-decoration: none; 
        }
    </style>
</head>

<body class="d-flex flex-column h-100 sidebar-pushcontent theme-blue" data-sidebarstyle="sidebar-pushcontent" data-theme="theme-blue">

    <!-- background -->
    <div class="coverimg h-100 w-100 top-0 start-0 main-bg">
        <div class="bg-blur main-bg-overlay"></div>
        <img src="<?= base_url(); ?>assets/img/bg-14.jpg" alt="" />
    </div>
    <!-- background ends  -->

    <!-- Header -->
    <!-- Header ends -->

    <!-- Sidebar -->
    <!-- Sidebar ends -->

    <!-- Begin page content -->
    <?php if (isset($content)) {
        $this->load->view($content);
    } ?>

    <!-- footer -->
    <!-- footer ends -->

    <!-- Rightbar -->
    <!-- Rightbar ends -->


    <!-- Modal -->

    <!-- Required jquery and libraries -->
    <script src="<?= base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/popper.min.js"></script>
    <!-- <script src="<?= base_url(); ?>assets/js/bootstrap.min.js"></script> -->
    <script src="<?= base_url(); ?>assets/vendor/bootstrap-5/dist/js/bootstrap.bundle.js"></script>


    <!-- Customized jquery file  -->
    <script src="<?= base_url(); ?>assets/js/main.js"></script>
    <script src="<?= base_url(); ?>assets/js/color-scheme.js"></script>

    <!-- PWA app service registration and works -->
    <!-- <script src="<?= base_url(); ?>assets/js/pwa-services.js"></script> -->

    <!-- date range picker -->
    <!-- <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> -->
    <script src="<?= base_url(); ?>assets/js/moment.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/daterangepicker/daterangepicker.js"></script>

    <!-- chosen script -->
    <script src="<?= base_url(); ?>assets/vendor/chosen_v1.8.7/chosen.jquery.min.js"></script>

    <!-- Chart js script -->
    <script src="<?= base_url(); ?>assets/vendor/chart-js-3.3.1/chart.min.js"></script>

    <!-- Progress circle js script -->
    <script src="<?= base_url(); ?>assets/vendor/progressbar-js/progressbar.min.js"></script>

    <!-- swiper js script -->
    <script src="<?= base_url(); ?>assets/vendor/swiper-7.3.1/swiper-bundle.min.js"></script>

    <!-- Simple lightbox script -->
    <script src="<?= base_url(); ?>assets/js/simple-lightbox.jquery.min.js"></script>

    <!-- app tour script-->
    <script src="<?= base_url(); ?>assets/js/lib.js"></script>

    <!-- page level script here -->
    <!-- <script src="<?= base_url(); ?>assets/js/header-title.js"></script> -->

    <!-- data-table js -->
    <!-- <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script> -->


    <!-- fancybox -->
    <script src="<?php echo base_url() ?>assets/fancybox/jquery.fancybox.min.js"></script>

    <!-- Pnotify -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/pnotify/js/pnotify.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/pnotify/js/pnotify.buttons.js"></script>
    <script src="<?= base_url(); ?>assets/owl_carousel/owl.carousel.min.js"></script>

    <script>
        $("#btn-modal-login-rsp").on("click", function() {
            $("#modal-login-rsp").modal("show");
        });
    </script>

    <script src="<?= base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.3.1/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script> -->
    <script src="<?= base_url(); ?>assets/js/dataTables.bootstrap5.min.js"></script>

    <?php if (isset($js)) {
        $this->load->view($js);
    } ?>

</body>

</html>