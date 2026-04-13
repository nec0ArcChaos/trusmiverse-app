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

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

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

    <!-- fancybox -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/fancybox/jquery.fancybox.min.css" />

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

    <link rel="stylesheet" href="<?= base_url(); ?>assets/owl_carousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/owl_carousel/assets/owl.theme.default.min.css">


    <?php if (isset($css)) {
        $this->load->view($css);
    } ?>
    <!-- css Chatbot Bubble -->
    <style>
        .chatbot-bubble.text-dark {
            max-width: 320px;
            padding: 12px;
            border-radius: 12px;
            background: var(--glass) !important;
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.03);
            color: #dbeafe;
            box-shadow: 0 10px 30px rgba(2, 6, 23, 0.6)
        }

        .chatbot-bubble h3 {
            margin: 0;
            font-size: 15px
        }

        .chatbot-bubble p {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: 13px
        }
    </style>
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

        .highlight {
            font-weight: bold;
            background-color: #cddbea;
        }

        .hidden {
            display: none;
        }

        .disabled-link {
            pointer-events: none;
            color: gray;
            cursor: default;
            text-decoration: none;
        }

        .input-wrapper {
            position: relative;
            display: inline-block;
        }

        .input-wrapper::after {
            content: '';
            position: absolute;
            top: -4px;
            left: -4px;
            right: -4px;
            bottom: -4px;
            border-radius: 12px;
            border: 2px solid transparent;
            background: linear-gradient(90deg, #000, #fff, #000, #fff, #000, #fff);
            background-size: 400% 100%;
            z-index: 1;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        /* Saat animasi aktif */
        .input-wrapper.animate-border::after {
            animation: borderMove 2s linear;
            opacity: 1;
        }

        /* Animasi berjalan */
        @keyframes borderMove {
            0% {
                background-position: 100% 0;
            }

            100% {
                background-position: 0 0;
            }
        }

        .menu-item {
            padding: 12px 12px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
        }

        /* hide by default (desktop) */
        #divsearchmobile {
            display: none;
        }

        /* show only on mobile (<=425px) */
        @media only screen and (max-width: 430px) {
            #divsearchmobile {
                display: block;
            }
            #searchbtnmobile {
                top: 13px;
                left: 5px;
                z-index: 20;
                cursor: pointer;
            }
        }
    </style>
</head>

<body class="d-flex flex-column h-100 sidebar-pushcontent theme-blue" data-sidebarstyle="sidebar-pushcontent" data-theme="theme-blue">
    <!-- sidebar-pushcontent, sidebar-overlay , sidebar-fullscreen  are classes to switch UI here-->

    <!-- page loader -->
    <!-- <div class="container-fluid h-100 position-fixed loader-wrap bg-blur">
        <div class="row justify-content-center h-100">
            <div class="col-auto align-self-center text-center">
                <h5 class="mb-0">Thanks for the patience</h5>
                <p class="text-secondary small">Amazing things coming from the <span class="text-dark">WinDOORS</span></p>
                <div class="spinner-border text-primary mt-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div> -->
    <!-- page loader ends -->

    <!-- background -->
    <div class="coverimg h-100 w-100 top-0 start-0 main-bg">
        <div class="bg-blur main-bg-overlay"></div>
        <img src="<?= base_url(); ?>assets/img/bg-14.jpg" alt="" />
    </div>
    <!-- background ends  -->

    <!-- Header -->
    <header class="header">
        <!-- Fixed navbar -->
        <nav class="navbar fixed-top">
            <div class="container-fluid">
                <div class="sidebar-width">
                    <button class="btn btn-link btn-square menu-btn" type="button">
                        <i class="bi bi-list fs-4"></i>
                    </button>
                    <a class="navbar-brand ms-2" href="<?= base_url(); ?>">
                        <div class="row">
                            <div class="col-auto"><img src="<?= base_url(); ?>assets/img/logo_trusmiverse.png" class="mx-100 logo-mobile" alt="" /></div>
                            <div class="col ps-0 align-self-center d-none d-sm-block">
                                <h5 class="fw-normal text-dark mb-0">Trusmiverse</h5>
                                <!-- <p class="small text-secondary">Admin App UI</p> -->
                            </div>
                        </div>
                    </a>
                    <div id="divsearchmobile">
                        <div class="d-inline-block dropdown" id="searchbtnmobile" data-bs-toggle="modal" data-bs-target="#modal_search_mobile">
                            <h5><i class="bi bi-search"></i></h5>
                        </div>
                    </div>
                </div>
                <div class="search-header d-none d-xl-block">
                    <div class="input-wrapper">
                        <div class="input-group input-group-md w-250" style="z-index: 2;">
                            <span class="input-group-text text-theme"><i class="bi bi-search"></i></span>
                            <input class="form-control pe-0" type="search" placeholder="Cari Menu disini..." id="searchglobal">

                            <span class="input-group-text d-flex d-xl-none" id="searchclose"><i class="bi bi-x-lg vm"></i></span>
                        </div>
                    </div>

                    <div style="max-width: 300px; min-width: 300px;position: fixed;">
                        <ul id="menu-container" class="list-group mt-3 hidden" style="max-height: 300px;overflow-y: auto;background-color: #fff; "></ul>
                    </div>
                    <div class="dropdown-menu dropdown-dontclose mt-2 mw-600 w-auto" id="searchresultglobal">
                        <ul class="nav nav-WinDOORS" id="searchtab1" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="searchall1-tab" data-bs-toggle="tab" data-bs-target="#searchall1" type="button" role="tab" aria-controls="searchall1" aria-selected="true">All <span class="badge rounded-pill bg-success ml-2 vm">12</span></button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="searchorders1-tab" data-bs-toggle="tab" data-bs-target="#searchorders1" type="button" role="tab" aria-controls="searchorders1" aria-selected="false">Orders <span class="badge rounded-pill bg-primary ml-2 vm">8</span></button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="searchcontacts1-tab" data-bs-toggle="tab" data-bs-target="#searchcontacts1" type="button" role="tab" aria-controls="searchcontacts1" aria-selected="false">Contacts <span class="badge rounded-pill bg-warning ml-2 vm">4</span></button>
                            </li>
                        </ul>
                        <div class="tab-content py-3" id="searchtabContent1">
                            <div class="tab-pane fade show active mh-500 overflow-y-auto" id="searchall1" role="tabpanel" aria-labelledby="searchall1-tab">
                                <div class="container-fluid">
                                    <div class="row mb-2">
                                        <div class="col align-self-center">
                                            <h6>Application</h6>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="btn btn-sm btn-outline-secondary border">View all</a>
                                        </div>
                                    </div>
                                    <div class="row g-0 text-center mb-3">
                                        <div class="col-4 col-sm-2 col-md-2">
                                            <a class="dropdown-item square-item" href="#">
                                                <div class="avatar avatar-40 rounded mb-2">
                                                    <i class="bi bi-bank fs-4"></i>
                                                </div>
                                                <p class="mb-0">Finance</p>
                                                <p class="fs-12 text-muted">Accounting</p>
                                            </a>
                                        </div>
                                        <div class="col-4 col-sm-2 col-md-2">
                                            <a class="dropdown-item square-item" href="#">
                                                <div class="avatar avatar-40 rounded mb-2">
                                                    <i class="bi bi-globe fs-4"></i>
                                                </div>
                                                <p class="mb-0">Network</p>
                                                <p class="fs-12 text-muted">Stabilize</p>
                                            </a>
                                        </div>
                                        <div class="col-4 col-sm-2 col-md-2">
                                            <a class="dropdown-item square-item" href="#">
                                                <div class="avatar avatar-40 rounded mb-2">
                                                    <i class="bi bi-box fs-4"></i>
                                                </div>
                                                <p class="mb-0">Inventory</p>
                                                <p class="fs-12 text-muted">Assuring</p>
                                            </a>
                                        </div>
                                        <div class="col-4 col-sm-2 col-md-2">
                                            <a class="dropdown-item square-item" href="#">
                                                <div class="avatar avatar-40 rounded mb-2">
                                                    <i class="bi bi-folder fs-4"></i>
                                                </div>
                                                <p class="mb-0">Project</p>
                                                <p class="fs-12 text-muted">Management</p>
                                            </a>
                                        </div>
                                        <div class="col-4 col-sm-2 col-md-2">
                                            <a class="dropdown-item square-item" href="#">
                                                <div class="avatar avatar-40 rounded mb-2">
                                                    <i class="bi bi-people fs-4"></i>
                                                </div>
                                                <p class="mb-0">Social</p>
                                                <p class="fs-12 text-muted">Tracking</p>
                                            </a>
                                        </div>
                                        <div class="col-4 col-sm-2 col-md-2">
                                            <a class="dropdown-item square-item" href="#">
                                                <div class="avatar avatar-40 rounded mb-2">
                                                    <i class="bi bi-journal-bookmark fs-4"></i>
                                                </div>
                                                <p class="mb-0">Learning</p>
                                                <p class="fs-12 text-muted">Make-easy</p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col align-self-center">
                                            <h6>Orders Placed</h6>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="btn btn-sm btn-outline-secondary border">View all</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="row mb-3">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-50 rounded bg-light-theme">
                                                        <i class="bi bi-bag fs-5"></i>
                                                    </div>
                                                </div>
                                                <div class="col-8 ps-0 align-self-center">
                                                    <a href="#" class="text-truncate">#EDR0021 by John Merchant</a>
                                                    <p class="text-truncate text-secondary small">2 items, $250.00, 09 December 2021</p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-50 rounded bg-light-theme">
                                                        <i class="bi bi-basket fs-5"></i>
                                                    </div>
                                                </div>
                                                <div class="col-8 ps-0 align-self-center">
                                                    <a href="#" class="text-truncate">#EDR0026 by Will Smith</a>
                                                    <p class="text-truncate text-secondary small">4 items, $530.00, 18 December 2021</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="row mb-3">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-50 rounded bg-light-theme">
                                                        <i class="bi bi-cart fs-5"></i>
                                                    </div>
                                                </div>
                                                <div class="col-8 ps-0 align-self-center">
                                                    <a href="#" class="text-truncate">#EDR0030 by Switty David</a>
                                                    <p class="text-truncate text-secondary small">1 items, $50.00, 20 December 2021</p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-50 rounded bg-light-theme">
                                                        <i class="bi bi-cart4 fs-5"></i>
                                                    </div>
                                                </div>
                                                <div class="col-8 ps-0 align-self-center">
                                                    <a href="#" class="text-truncate">#EDR0041 by Mr.Walk Wolf</a>
                                                    <p class="text-truncate text-secondary small">3 items, $130.00, 16 December 2021</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col align-self-center">
                                            <h6>Contacts</h6>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="btn btn-sm btn-outline-secondary border">View all</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="row mb-3">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-50 rounded bg-light-theme coverimg">
                                                        <img src="<?= base_url(); ?>assets/img/user-2.jpg" alt="" />
                                                    </div>
                                                </div>
                                                <div class="col-8 ps-0 align-self-center">
                                                    <a href="#" class="text-truncate">Ms. Switty David</a>
                                                    <p class="text-truncate text-secondary small">US, UK Recruiter</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-50 rounded bg-light-theme coverimg">
                                                        <img src="<?= base_url(); ?>assets/img/user-3.jpg" alt="" />
                                                    </div>
                                                </div>
                                                <div class="col-8 ps-0 align-self-center">
                                                    <a href="#" class="text-truncate">Dyna Roosevelt</a>
                                                    <p class="text-truncate text-secondary small">Marketing Head at Linmongas</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="row mb-3">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-50 rounded bg-light-theme coverimg">
                                                        <img src="<?= base_url(); ?>assets/img/user-4.jpg" alt="" />
                                                    </div>
                                                </div>
                                                <div class="col-8 ps-0 align-self-center">
                                                    <a href="#" class="text-truncate">Mr. Freddy Johnson</a>
                                                    <p class="text-truncate text-secondary small">Project Manager</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-50 rounded bg-light-theme coverimg">
                                                        <img src="<?= base_url(); ?>assets/img/user-1.jpg" alt="" />
                                                    </div>
                                                </div>
                                                <div class="col-8 ps-0 align-self-center">
                                                    <a href="#" class="text-truncate">The Maxartkiller</a>
                                                    <p class="text-truncate text-secondary small">CEO Maxartkiller</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="searchorders1" role="tabpanel" aria-labelledby="searchorders1-tab">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="row mb-3">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-50 rounded bg-light-theme">
                                                        <i class="bi bi-bag fs-5"></i>
                                                    </div>
                                                </div>
                                                <div class="col-8 ps-0 align-self-center">
                                                    <a href="#" class="text-truncate">#EDR0021 by John Merchant</a>
                                                    <p class="text-truncate text-secondary small">2 items, $250.00, 09 December 2021</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-50 rounded bg-light-theme">
                                                        <i class="bi bi-basket fs-5"></i>
                                                    </div>
                                                </div>
                                                <div class="col-8 ps-0 align-self-center">
                                                    <a href="#" class="text-truncate">#EDR0026 by Will Smith</a>
                                                    <p class="text-truncate text-secondary small">4 items, $530.00, 18 December 2021</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="row mb-3">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-50 rounded bg-light-theme">
                                                        <i class="bi bi-cart fs-5"></i>
                                                    </div>
                                                </div>
                                                <div class="col-8 ps-0 align-self-center">
                                                    <a href="#" class="text-truncate">#EDR0030 by Switty David</a>
                                                    <p class="text-truncate text-secondary small">1 items, $50.00, 20 December 2021</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-50 rounded bg-light-theme">
                                                        <i class="bi bi-cart4 fs-5"></i>
                                                    </div>
                                                </div>
                                                <div class="col-8 ps-0 align-self-center">
                                                    <a href="#" class="text-truncate">#EDR0041 by Mr.Walk Wolf</a>
                                                    <p class="text-truncate text-secondary small">3 items, $130.00, 16 December 2021</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="searchcontacts1" role="tabpanel" aria-labelledby="searchcontacts1-tab">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="row mb-3">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-50 rounded bg-light-theme coverimg">
                                                        <img src="<?= base_url(); ?>assets/img/user-2.jpg" alt="" />
                                                    </div>
                                                </div>
                                                <div class="col-8 ps-0 align-self-center">
                                                    <a href="#" class="text-truncate">Ms. Switty David</a>
                                                    <p class="text-truncate text-secondary small">US, UK Recruiter</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-50 rounded bg-light-theme coverimg">
                                                        <img src="<?= base_url(); ?>assets/img/user-3.jpg" alt="" />
                                                    </div>
                                                </div>
                                                <div class="col-8 ps-0 align-self-center">
                                                    <a href="#" class="text-truncate">Dyna Roosevelt</a>
                                                    <p class="text-truncate text-secondary small">Marketing Head at Linmongas</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="row mb-3">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-50 rounded bg-light-theme coverimg">
                                                        <img src="<?= base_url(); ?>assets/img/user-4.jpg" alt="" />
                                                    </div>
                                                </div>
                                                <div class="col-8 ps-0 align-self-center">
                                                    <a href="#" class="text-truncate">Mr. Freddy Johnson</a>
                                                    <p class="text-truncate text-secondary small">Project Manager</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-50 rounded bg-light-theme coverimg">
                                                        <img src="<?= base_url(); ?>assets/img/user-1.jpg" alt="" />
                                                    </div>
                                                </div>
                                                <div class="col-8 ps-0 align-self-center">
                                                    <a href="#" class="text-truncate">The Maxartkiller</a>
                                                    <p class="text-truncate text-secondary small">CEO Maxartkiller</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="navbar-expand-xl d-none d-xxxl-block ms-3">
                    <div class="collapse navbar-collapse" id="mainheaderNavbar">

                    </div>
                </div>
                <div class="ms-auto">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- <div class="col-auto align-self-center d-none d-xxxl-block">
                            </div> -->
                            <!-- <div class="col-auto align-self-center px-0 d-none d-xxxl-block">
                                <i class="bi bi-three-dots-vertical opacity-3 text-secondary"></i>
                            </div> -->
                            <div class="col-auto">
                                <div class="d-none d-md-inline-block mt-1">
                                    <div class="d-flex justify-content-between">
                                        <p class="d-none" id="text-pembelajar" style="font-size: 6pt;margin-right:10px;text-align:justify;margin-bottom: 0px;"><span style="margin-top: 10px;margin-right: 10px;">Pembelajar !!!</span></p>
                                        <p class="d-none" id="text-proaktif" style="font-size: 6pt;margin-right:10px;text-align:justify;margin-bottom: 0px;"><span style="margin-top: 10px;margin-right: 10px;">Proaktif !!!</span></p>
                                        <p class="d-none" id="text-positif" style="font-size: 6pt;margin-right:10px;text-align:justify;margin-bottom: 0px;"><span style="margin-top: 10px;margin-right: 10px;">Penebar Energi Positif !!!</span></p>
                                        <img src="<?= base_url(); ?>assets/img/860398-removebg.png" alt="" class="img-fluid" style="max-height: 35px;">
                                        <p style="font-size: 6pt;margin-left:10px;margin-right:10px;text-align:justify;margin-bottom: 0px;">Fungsi Leader : Plan, Delegasi, Monitoring,<br> Controling, Evaluasi & Problem Solving</p>
                                        <label class="toggle-switchy custom-dark-mode-icon" for="btn-layout-modes-dark-nav" data-size="sm" data-style="rounded">
                                            <input type="checkbox" id="btn-layout-modes-dark-nav">
                                            <span class="toggle">
                                                <span class="switch"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="d-inline-block dropdown">
                                    <a class="btn btn-square btn-link text-center dd-arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="true"><i class="bi bi-grid"></i></a>
                                    <div class="dropdown-menu dropdown-menu-center w-300" data-bs-popper="static">
                                        <div class="dropdown-info text-center bg-theme">
                                            <h6 class="mb-0">Applications</h6>
                                            <p class="text-muted small">Portal Trusmiverse</p>
                                        </div>
                                        <div class="row g-0 text-center mb-3" style="max-height:400px;overflow-y:scroll;">
                                            <div class="col-6">
                                                <a class="dropdown-item square-item" target="_blank" href="https://trusmicorp.com/e-training/login/logout">
                                                    <div class="avatar avatar-40 rounded mb-2">
                                                        <i class="fs-4"><img src="https://trusmicorp.com/e-training/assets/img/favicon/favicon-train_dev.png" alt=""></i>
                                                    </div>
                                                    <p class="mb-0">E-Learning</p>
                                                    <p class="fs-12 text-muted">Training</p>
                                                </a>
                                            </div>
                                            <div class="col-6">
                                                <a class="dropdown-item square-item" target="_blank" href="https://trusmicorp.com/pobox/login">
                                                    <div class="avatar avatar-40 rounded mb-2">
                                                        <i class="fs-4"><img src="https://trusmicorp.com/pobox/assets/img/logo_trusmiverse.png" alt=""></i>
                                                    </div>
                                                    <p class="mb-0">PO BOX</p>
                                                    <p class="fs-12 text-muted">Asset</p>
                                                </a>
                                            </div>
                                            <div class="col-6">
                                                <a class="dropdown-item square-item" target="_blank" href="https://trusmicorp.com/rspproject/login">
                                                    <div class="avatar avatar-40 rounded mb-2">
                                                        <i class="fs-4"><img src="https://trusmicorp.com/rspproject/assets/berkas_bic/img/logo_no_bg.png" alt=""></i>
                                                    </div>
                                                    <p class="mb-0">Rumah Ningrat</p>
                                                    <p class="fs-12 text-muted">Rsp Project</p>
                                                </a>
                                            </div>
                                            <div class="col-6">
                                                <a class="dropdown-item square-item" target="_blank" href="https://mail.rumahningrat.id/rc/">
                                                    <div class="avatar avatar-90 rounded mb-2">
                                                        <i class="fs-4"><img src="<?= base_url() ?>/assets/img/rumahningrat_mail.png" alt=""></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-6">
                                                <a class="dropdown-item square-item" target="_blank" href="http://10.10.11.82/purchasing_new/login">
                                                    <div class="avatar avatar-40 rounded mb-2">
                                                        <i class="fs-4"><img src="<?= base_url() ?>assets/img/logo_tkb.png" alt=""></i>
                                                    </div>
                                                    <p class="mb-0">Purchasing</p>
                                                    <p class="fs-12 text-muted">The Keranjang Bali</p>
                                                </a>
                                            </div>
                                            <div class="col-6">
                                                <a class="dropdown-item square-item" target="_blank" href="http://192.168.10.150/purchasing/login">
                                                    <div class="avatar avatar-40 rounded mb-2">
                                                        <i class="fs-4"><img src="<?= base_url() ?>assets/img/logo_bt.png" alt=""></i>
                                                    </div>
                                                    <p class="mb-0">Purchasing</p>
                                                    <p class="fs-12 text-muted">Batik Trusmi</p>
                                                </a>
                                            </div>
                                            <div class="col-6">
                                                <a class="dropdown-item square-item" target="_blank" href="https://trusmicorp.com/eaf/">
                                                    <div class="avatar avatar-40 rounded mb-2">
                                                        <i class="fs-4"><img src="<?= base_url() ?>assets/img/logo_bt.png" alt=""></i>
                                                    </div>
                                                    <p class="mb-0">Pengajuan EAF</p>
                                                    <p class="fs-12 text-muted">Batik Trusmi</p>
                                                </a>
                                            </div>
                                            <div class="col-6">
                                                <a class="dropdown-item square-item" target="_blank" href="http://13.228.160.89/aset_digital/">
                                                    <div class="avatar avatar-40 rounded mb-2">
                                                        <i class="fs-4"><img src="https://trusmicorp.com/pobox/assets/img/logo_trusmiverse.png" alt=""></i>
                                                    </div>
                                                    <p class="mb-0">Aset Digital</p>
                                                    <p class="fs-12 text-muted">Sekdir</p>
                                                </a>
                                            </div>
                                            <div class="col-6">
                                                <a class="dropdown-item square-item" target="_blank" href="https://trusmiverse.com/dashboard_mm/">
                                                    <div class="avatar avatar-40 rounded mb-2">
                                                        <i class="fs-4"><img src="https://trusmicorp.com/pobox/assets/img/logo_trusmiverse.png" alt=""></i>
                                                    </div>
                                                    <p class="mb-0">Dashboard Divisi</p>
                                                    <p class="fs-12 text-muted">Dashboard</p>
                                                </a>
                                            </div>
                                        </div>
                                        <!-- <div class="text-center"><a class="btn btn-link text-center" href="#">View all <i class="bi bi-arrow-right"></i></a></div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto align-self-center px-0  d-none d-xxxl-block">
                                <i class="bi bi-three-dots-vertical opacity-3 text-secondary"></i>
                            </div>
                            <div class="col-auto">
                                <div class="dropdown">
                                    <a class="dd-arrow-none dropdown-toggle tempdata" id="userprofiledd" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                                        <div class="row">
                                            <div class="col-auto align-self-center">
                                                <figure class="avatar avatar-40 rounded-circle coverimg vm">
                                                    <img src="https://trusmiverse.com/hr/uploads/profile/<?= $this->session->userdata('profile_picture'); ?>" alt="" id="userphotoonboarding2" />
                                                </figure>
                                            </div>
                                            <div class="col ps-0 align-self-center d-none d-lg-block">
                                                <p class="mb-0">
                                                    <span class="text-dark username"><?= $this->session->userdata('nama'); ?></span><br>
                                                    <small class="small"><?= $this->session->userdata('jabatan'); ?></small>
                                                </p>
                                            </div>
                                            <div class="col ps-0 align-self-center d-none d-lg-block">
                                                <i class="bi bi-chevron-down small vm"></i>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end w-300" aria-labelledby="userprofiledd">
                                        <div class="dropdown-info bg-theme">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <figure class="avatar avatar-50 rounded-circle coverimg vm">
                                                        <img src="https://trusmiverse.com/hr/uploads/profile/<?= $this->session->userdata('profile_picture'); ?>" alt="" id="userphotoonboarding3" />
                                                    </figure>
                                                </div>
                                                <div class="col align-self-center ps-0">
                                                    <h6 class="mb-0"><span class="username"><?= $this->session->userdata('nama'); ?></span></h6>
                                                    <p class="text-muted small"><?= $this->session->userdata('jabatan'); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div><a class="dropdown-item" href="#"><i class="bi bi-person-fill-gear"></i> My Profile</a></div>
                                        <div><a class="dropdown-item" href="<?= base_url(); ?>theme"><i class="bi bi-palette"></i> Change Theme</a></div>
                                        <div><a class="dropdown-item" href="<?= base_url('login/logout'); ?>"><i class="bi bi-door-open"></i>Logout</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- Header ends -->

    <!-- Sidebar -->
    <div class="sidebar-wrap">
        <div class="sidebar">
            <div class="container">
                <div class="row mb-4">
                    <div class="col align-self-center">
                        <h6>Main navigation</h6>
                    </div>
                    <div class="col-auto">
                        <a class="" data-bs-toggle="collapse" data-bs-target="#usersidebarprofile" aria-expanded="false" role="button" aria-controls="usersidebarprofile">
                            <i class="bi bi-person-circle"></i>
                        </a>
                    </div>
                </div>

                <!-- user information -->
                <div class="row text-center collapse " id="usersidebarprofile">
                    <div class="col-12">
                        <div class="avatar avatar-100 rounded-circle shadow-sm mb-3 bg-white">
                            <figure class="avatar avatar-90 rounded-circle coverimg">
                                <img src="https://trusmiverse.com/hr/uploads/profile/<?= $this->session->userdata('profile_picture'); ?>" alt="" id="userphotoonboarding">
                            </figure>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <h6 class="mb-1" id="usernamedisplay"><?= $this->session->userdata('nama'); ?></h6>
                        <!-- <p class="text-secondary small">United States</p> -->
                    </div>
                </div>

                <!-- user menu navigation -->
                <?php
                // if ($this->session->userdata("user_id") == "2063" || $this->session->userdata("user_id") == "61") {
                $this->load->view('layout/navigation_new.php');
                // } else {
                // $this->load->view('layout/navigation.php');
                // }
                ?>
                <!-- end user menu navigation -->

            </div>
        </div>
    </div>
    <!-- Sidebar ends -->

    <!-- Begin page content -->
    <?php if (isset($content)) {
        $this->load->view($content);
    } ?>

    <!-- Modal Rekening -->
    <div class="modal fade" id="modal_search_mobile" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-login-rsp">Cari Menu disini...</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <div class="input-group input-group-md" style="z-index: 2;">
                            <span class="input-group-text text-theme"><i class="bi bi-search"></i></span>
                            <input class="form-control pe-0" type="search" placeholder="Cari Menu disini..." id="searchglobalmobile">
                        </div>
                    <br>
                    <ul id="menu-container-mobile" class="list-group mt-3 hidden" style="max-height: 300px;overflow-y: auto;background-color: #fff; "></ul>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <footer class="footer mt-auto">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md col-lg py-2">
                    <span class="text-secondary small">Copyright @2022, IT Trusmi Group</span>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer ends -->

    <!-- Rightbar -->
    <div class="rightbar-wrap">
        <div class="rightbar">

            <!-- chat window -->
            <div class="chatwindow d-none" id="chatwindow">
                <div class="card border-0 h-100">
                    <div class="input-group input-group-md">
                        <span class="input-group-text text-theme"><i class="bi bi-person-plus"></i></span>
                        <input type="text" class="form-control" placeholder="Start searching... " value="" />
                        <div class="dropdown input-group-text rounded px-0">
                            <button class="btn btn-sm btn-link dd-arrow-none" type="button" id="statuschat" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="statuschat">
                                <li><a class="dropdown-item" href="javascript:void(0)"><span class="vm me-1 bg-success rounded-circle d-inline-block p-1"></span> Online</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)"><span class="vm me-1 bg-warning rounded-circle d-inline-block p-1"></span> Away</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)"><span class="vm me-1 bg-danger rounded-circle d-inline-block p-1"></span> Offline</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)"><span class="vm me-1 bg-secondary rounded-circle d-inline-block p-1"></span> Disabled</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-header">
                        <div class="row">
                            <div class="col d-grid">
                                <button class="btn btn-outline-secondary border" type="button"><i class="bi bi-camera-video me-2"></i> Meet</button>
                            </div>
                            <div class="col d-grid">
                                <button class="btn btn-outline-secondary border" type="button"><i class="bi bi-chat-right-text me-2"></i> Chat</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body h-100 overflow-y-auto p-0">
                        <ul class="list-group list-group-flush bg-none rounded-0 ">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-44 coverimg rounded-circle">
                                            <img src="<?= base_url(); ?>assets/img/user-2.jpg" alt="" />
                                        </figure>
                                    </div>
                                    <div class="col-9 align-self-center ps-0">
                                        <div class="row g-0">
                                            <div class="col-8">
                                                <p class="text-truncate mb-0">Angelina Devid</p>
                                            </div>
                                            <div class="col-4 text-end"><small class="text-muted fs-10 mb-1"><i class="bi bi-check"></i> 2:00 am</small></div>
                                        </div>
                                        <p class="text-secondary small text-truncate">Spread love and spread this template</p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-44 rounded-circle bg-theme">
                                            <span class="h6 vm">JM</span>
                                        </figure>
                                    </div>
                                    <div class="col-9 align-self-center ps-0">
                                        <div class="row g-0">
                                            <div class="col-8">
                                                <p class="text-truncate mb-0">Mr. Jack Mario</p>
                                            </div>
                                            <div class="col-4 text-end"><small class="text-muted fs-10 mb-1"><i class="bi bi-check-all"></i> 2:00 am</small></div>
                                        </div>
                                        <p class="text-secondary small text-truncate">Spread love and spread this template</p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-44 coverimg rounded-circle">
                                            <img src="<?= base_url(); ?>assets/img/user-4.jpg" alt="" />
                                        </figure>
                                    </div>
                                    <div class="col-9 align-self-center ps-0">
                                        <div class="row g-0">
                                            <div class="col-8">
                                                <p class="text-truncate mb-0">Roberto Carlos</p>
                                            </div>
                                            <div class="col-4 text-end"><small class="text-muted fs-10 mb-1"><i class="bi bi-check-all text-info"></i> 2:00 am</small></div>
                                        </div>
                                        <p class="text-secondary small text-truncate">Spread love and spread this template</p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-44 coverimg rounded-circle">
                                            <img src="<?= base_url(); ?>assets/img/user-1.jpg" alt="" />
                                        </figure>
                                    </div>
                                    <div class="col-9 align-self-center ps-0">
                                        <div class="row g-0">
                                            <div class="col-8">
                                                <p class="text-truncate mb-0">The Maxartkiller</p>
                                            </div>
                                            <div class="col-4 text-end"><small class="text-muted fs-10 mb-1"><i class="bi bi-check-all text-success"></i> 2 days ago</small></div>
                                        </div>
                                        <p class="text-secondary small text-truncate">Spread love and spread this template</p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-44 rounded-circle bg-warning text-white">
                                            <span class="h6 vm">JC</span>
                                        </figure>
                                    </div>
                                    <div class="col-9 align-self-center ps-0">
                                        <div class="row g-0">
                                            <div class="col-8">
                                                <p class="text-truncate mb-0">Ms. Jully CTO</p>
                                            </div>
                                            <div class="col-4 text-end"><small class="text-muted fs-10 mb-1"><i class="bi bi-check-all"></i> 4 days ago</small></div>
                                        </div>
                                        <p class="text-secondary small text-truncate">Spread love and spread this template</p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item disabled" data-bs-toggle="modal" data-bs-target="#chatmodalwindow">
                                <div class="row">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-44 rounded-circle bg-success text-white">
                                            <span class="h6 vm">JC</span>
                                        </figure>
                                    </div>
                                    <div class="col-9 align-self-center ps-0">
                                        <div class="row g-0">
                                            <div class="col-8">
                                                <p class="text-truncate mb-0">Aswatthma D-Plan</p>
                                            </div>
                                            <div class="col-4 text-end"><small class="text-muted fs-10 mb-1"><i class="bi bi-check"></i> 1 mo ago</small></div>
                                        </div>
                                        <p class="text-secondary small text-truncate">Spread love and spread this template</p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-44 coverimg rounded-circle bg-theme">
                                            <img src="<?= base_url(); ?>assets/img/favicon72.png" alt="" />
                                        </figure>
                                    </div>
                                    <div class="col-9 align-self-center ps-0">
                                        <div class="row g-0">
                                            <div class="col-8">
                                                <p class="text-truncate mb-0">getWinDOORS Support</p>
                                            </div>
                                            <div class="col-4 text-end"><small class="text-muted fs-10 mb-1"><i class="bi bi-check"></i> 2:00 am</small></div>
                                        </div>
                                        <p class="text-secondary small text-truncate">Thank you for connecting</p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-44 rounded-circle bg-theme">
                                            <span class="h6 vm">JM</span>
                                        </figure>
                                    </div>
                                    <div class="col-9 align-self-center ps-0">
                                        <div class="row g-0">
                                            <div class="col-8">
                                                <p class="text-truncate mb-0">Mr. Jack Mario</p>
                                            </div>
                                            <div class="col-4 text-end"><small class="text-muted fs-10 mb-1"><i class="bi bi-check-all"></i> 2:00 am</small></div>
                                        </div>
                                        <p class="text-secondary small text-truncate">Spread love and spread this template</p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-44 coverimg rounded-circle">
                                            <img src="<?= base_url(); ?>assets/img/user-4.jpg" alt="" />
                                        </figure>
                                    </div>
                                    <div class="col-9 align-self-center ps-0">
                                        <div class="row g-0">
                                            <div class="col-8">
                                                <p class="text-truncate mb-0">Roberto Carlos</p>
                                            </div>
                                            <div class="col-4 text-end"><small class="text-muted fs-10 mb-1"><i class="bi bi-check-all text-info"></i> 2:00 am</small></div>
                                        </div>
                                        <p class="text-secondary small text-truncate">Spread love and spread this template</p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-44 coverimg rounded-circle">
                                            <img src="<?= base_url(); ?>assets/img/user-1.jpg" alt="" />
                                        </figure>
                                    </div>
                                    <div class="col-9 align-self-center ps-0">
                                        <div class="row g-0">
                                            <div class="col-8">
                                                <p class="text-truncate mb-0">The Maxartkiller</p>
                                            </div>
                                            <div class="col-4 text-end"><small class="text-muted fs-10 mb-1"><i class="bi bi-check-all text-success"></i> 2 days ago</small></div>
                                        </div>
                                        <p class="text-secondary small text-truncate">Spread love and spread this template</p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-44 rounded-circle bg-warning text-white">
                                            <span class="h6 vm">JC</span>
                                        </figure>
                                    </div>
                                    <div class="col-9 align-self-center ps-0">
                                        <div class="row g-0">
                                            <div class="col-8">
                                                <p class="text-truncate mb-0">Ms. Jully CTO</p>
                                            </div>
                                            <div class="col-4 text-end"><small class="text-muted fs-10 mb-1"><i class="bi bi-check-all"></i> 4 days ago</small></div>
                                        </div>
                                        <p class="text-secondary small text-truncate">Spread love and spread this template</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- chat window ends -->

            <!-- notifications window -->
            <div class="notificationwindow d-none h-100 overflow-y-auto" id="notificationwindow">
                <div class="card border-0 mb-2">
                    <div class="input-group input-group-md">
                        <span class="input-group-text text-theme"><i class="bi bi-calendar-event"></i></span>
                        <input type="text" class="form-control" value="" id="notificationdaterange" />
                    </div>
                    <div class="card-body p-0 calendarwindow" id="calendardisplay">
                    </div>
                </div>
                <div class="card border-0 mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <figure class="avatar avatar-40 coverimg rounded-circle">
                                    <img src="<?= base_url(); ?>assets/img/user-2.jpg" alt="" />
                                </figure>
                            </div>
                            <div class="col ps-0">
                                <p><a href="#">Angelina David</a>, <a href="#">John McMillan</a> and <span class="fw-medium">36 others</span> are also order from same website</p>
                                <p class="text-secondary small">2:14 pm <a href="javascript:void(0)" class="float-end text-secondary text-muted"><i class="bi bi-trash"></i></a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <figure class="avatar avatar-40 rounded-circle bg-theme">
                                    <span class="h6 vm">JM</span>
                                </figure>
                            </div>
                            <div class="col ps-0">
                                <p><a href="#">Jack Mario</a> commented: "This one is most usable design with great user experience. w..."</p>
                                <p class="text-secondary small">2 days ago <a href="javascript:void(0)" class="float-end text-secondary text-muted"><i class="bi bi-trash"></i></a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alert alert-warning mb-2">
                    <div class="row">
                        <div class="col-auto">
                            <figure class="avatar avatar-40 rounded-circle bg-warning text-white">
                                <i class="bi bi-bell"></i>
                            </figure>
                        </div>
                        <div class="col ps-0">
                            <p>Your subscription going to expire soon. Please <a href="#">upgrade</a> to get service interrupt free.</p>
                            <p class="text-secondary small">4 days ago <a href="javascript:void(0)" class="float-end text-secondary text-muted"><i class="bi bi-trash"></i></a></p>
                        </div>
                    </div>
                </div>
                <div class="card border-0 mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <figure class="avatar avatar-40 coverimg rounded-circle">
                                    <img src="<?= base_url(); ?>assets/img/user-4.jpg" alt="" />
                                </figure>
                            </div>
                            <div class="col ps-0">
                                <p><a href="#">Roberto Carlos</a> has requested to send $120.00 money.</p>
                                <p class="text-secondary small">4 days ago <a href="javascript:void(0)" class="float-end text-secondary text-muted"><i class="bi bi-trash"></i></a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <figure class="avatar avatar-40 rounded-circle bg-light-theme">
                                    <i class="bi bi-calendar-event"></i>
                                </figure>
                            </div>
                            <div class="col ps-0">
                                <p class="h6 fw-medium">WINUX: getWinDOORS</p>
                                <p>Learning for better user experience on Universal app. development</p>
                                <div class="mb-3">
                                    <figure class="avatar avatar-24 coverimg rounded-circle" data-bs-toggle="tooltip" title="Angelina David">
                                        <img src="<?= base_url(); ?>assets/img/user-2.jpg" alt="" />
                                    </figure>
                                    <figure class="avatar avatar-24 coverimg rounded-circle" data-bs-toggle="tooltip" title="Switty Johnson">
                                        <img src="<?= base_url(); ?>assets/img/user-3.jpg" alt="" />
                                    </figure>
                                    <div class="avatar avatar-24 bg-light-theme rounded-circle">
                                        <small class="fs-10 vm">9+</small>
                                    </div>
                                    <span class="text-secondary small"> are attending</span>
                                </div>
                                <p class="text-secondary small">4 days ago <a href="javascript:void(0)" class="float-end text-secondary text-muted"><i class="bi bi-trash"></i></a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <figure class="avatar avatar-40 coverimg rounded-circle bg-theme">
                                    <img src="<?= base_url(); ?>assets/img/favicon72.png" alt="" />
                                </figure>
                            </div>
                            <div class="col ps-0">
                                <p><a href="#">The Maxartkiller</a> commented: "Thank you so much for this deep view at getWinDOORS..."</p>
                                <p class="text-secondary small">6 days ago <a href="javascript:void(0)" class="float-end text-secondary text-muted"><i class="bi bi-trash"></i></a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- notifications window ends -->

        </div>
    </div>
    <!-- Rightbar ends -->

    <!-- chat window -->
    <div class="chatboxes w-auto align-right mb-2" style="display: none;">
        <!-- dropdown for each user  -->
        <div class="dropstart">
            <div class="dd-arrow-none dropdown-toggle" id="thefirstchat" data-bs-display="static" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="button">
                <span class="position-absolute top-0 start-100 p-1 bg-danger border border-light rounded-circle">
                    <span class="visually-hidden">New alerts</span>
                </span>
                <figure class="avatar avatar-40 coverimg rounded-circle shadow">
                    <img src="<?= base_url(); ?>assets/img/user-2.jpg" alt="">
                </figure>
            </div>
            <div class="dropdown-menu dropdown-menu-middle w-300 mb-2 p-0">
                <!-- chat box here  -->
                <div class="card shadow-none border-0">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col align-self-center">
                                <p class="mb-0">Angelina Devid</p>
                                <p class="text-secondary small">1 hr ago</p>
                            </div>
                            <div class="col-auto">
                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-sm btn-square btn-outline-secondary border"><i class="bi bi-camera-video"></i></button>
                                    <button type="button" class="btn btn-sm btn-square btn-outline-secondary border"><i class="bi bi-person-plus"></i></button>
                                </div>
                            </div>
                            <div class="col-auto ps-0 align-self-center">
                                <div class="dropdown d-inline-block">
                                    <a class="dd-arrow-none" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false" role="button">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="javascript:void(0)">Add Contact</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)">Search</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)">Clear Chat</a></li>
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)">Report</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body overflow-y-auto h-250 chat-list">
                        <div class="row no-margin left-chat">
                            <div class="col-12">
                                <div class="chat-block">
                                    <div class="row">
                                        <div class="col">
                                            Hi!
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="text-secondary small time"><i class="bi bi-check"></i> 9:00 pm</p>
                            </div>
                        </div>
                        <div class="row no-margin right-chat">
                            <div class="col-12">
                                <div class="chat-block">
                                    <div class="row">
                                        <div class="col">
                                            Hi!<br>Yes please tell us your query.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <p class="text-secondary small time"><i class="bi bi-check"></i> 9:10 pm</p>
                            </div>
                        </div>
                        <div class="row no-margin">
                            <div class="col-12 text-center">
                                <span class="alert-warning text-secondary mx-auto btn btn-sm py-1 mb-3">26 November
                                    2021</span>
                            </div>
                        </div>
                        <div class="row no-margin left-chat">
                            <div class="col-12">
                                <div class="chat-block">
                                    <div class="row">
                                        <div class="col">
                                            WinDOORS is amazing and we thank you. How can we buy?
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i> 8:00 pm
                                </p>
                            </div>
                        </div>
                        <div class="row no-margin right-chat">
                            <div class="col-12">
                                <div class="chat-block">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mw-100 position-relative mb-2 figure">
                                                <div class="position-absolute end-0 top-0">
                                                    <button class="avatar avatar-36 rounded-circle p-0 btn btn-info text-white shadow-sm m-2">
                                                        <i class="bi bi-download"></i>
                                                    </button>
                                                </div>
                                                <img src="<?= base_url(); ?>assets/img/news-4.jpg" alt="" class="mw-100">
                                            </div>
                                            Thank you too. You can buy it from preview page and click on buy now.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i> 8:00 pm
                                </p>
                            </div>
                        </div>
                        <div class="row no-margin">
                            <div class="col-12  text-center">
                                <span class="alert-warning text-secondary mx-auto btn btn-sm py-1 mb-3">25 November
                                    2019</span>
                            </div>
                        </div>
                        <div class="row no-margin left-chat">
                            <div class="col-12">
                                <div class="chat-block">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mw-100 position-relative mb-2 figure">
                                                <video src="<?= base_url(); ?>https://maxartkiller.com/website/maxartkiller.mp4" controls="" preload="none"></video>
                                            </div>
                                            We also love this small presentation.
                                        </div>

                                    </div>
                                </div>
                                <div class="col-12">
                                    <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i> 8:00
                                        pm
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row no-margin right-chat">
                            <div class="col-12">
                                <div class="chat-block">
                                    <div class="row">
                                        <div class="col">
                                            <p>Ohh... Thats great. WinDOORS is HTML template can be used in various business domains like
                                                Manufacturing, inventory, IT, administration etc.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i> 8:00 pm
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-0">
                        <div class="input-group input-group-md">
                            <button class="btn btn-sm btn-link px-2"><i class="bi bi-emoji-smile"></i></button>
                            <button class="btn btn-sm btn-link px-2"><i class="bi bi-paperclip"></i></button>
                            <input type="text" class="form-control" placeholder="Type your message... " value="">
                            <button class="btn btn-sm btn-link px-2" type="button">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <button class="chat-close btn btn-danger text-white"><i class="bi bi-x"></i></button>
        </div>
        <!-- dropdown for each user  -->
        <div class="dropstart">
            <div class="dd-arrow-none dropdown-toggle" data-bs-display="static" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="button">
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle">
                    <span class="visually-hidden">New alerts</span>
                </span>
                <figure class="avatar avatar-40 coverimg rounded-circle shadow">
                    <img src="<?= base_url(); ?>assets/img/user-4.jpg" alt="">
                </figure>
            </div>
            <div class="dropdown-menu dropdown-menu-middle w-300 mb-2 p-0">
                <!-- chat box here  -->
                <div class="card shadow-none border-0">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col align-self-center">
                                <p class="mb-0">Roberto Carlos</p>
                                <p class="text-secondary small">10 min ago</p>
                            </div>
                            <div class="col-auto">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-sm btn-outline-secondary border"><i class="bi bi-camera-video"></i></button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary border"><i class="bi bi-person-plus"></i></button>
                                </div>
                            </div>
                            <div class="col-auto ps-0 align-self-center">
                                <div class="dropdown d-inline-block">
                                    <a class="dd-arrow-none" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false" role="button">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="javascript:void(0)">Add Contact</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)">Search</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)">Clear Chat</a></li>
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)">Report</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body overflow-y-auto h-250 chat-list">
                        <div class="row no-margin left-chat">
                            <div class="col-12">
                                <div class="chat-block">
                                    <div class="row">
                                        <div class="col">
                                            Hi!
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="text-secondary small time"><i class="bi bi-check"></i> 9:00 pm</p>
                            </div>
                        </div>
                        <div class="row no-margin right-chat">
                            <div class="col-12">
                                <div class="chat-block">
                                    <div class="row">
                                        <div class="col">
                                            Hi!<br>Yes please tell us your query.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <p class="text-secondary small time"><i class="bi bi-check"></i> 9:10 pm</p>
                            </div>
                        </div>
                        <div class="row no-margin">
                            <div class="col-12 text-center">
                                <span class="alert-warning text-secondary mx-auto btn btn-sm py-1 mb-3">26 November
                                    2021</span>
                            </div>
                        </div>
                        <div class="row no-margin left-chat">
                            <div class="col-12">
                                <div class="chat-block">
                                    <div class="row">
                                        <div class="col">
                                            WinDOORS is amazing and we thank you. How can we buy?
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i> 8:00 pm
                                </p>
                            </div>
                        </div>
                        <div class="row no-margin right-chat">
                            <div class="col-12">
                                <div class="chat-block">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mw-100 position-relative mb-2 figure">
                                                <div class="position-absolute end-0 top-0">
                                                    <button class="avatar avatar-36 rounded-circle p-0 btn btn-info text-white shadow-sm m-2">
                                                        <i class="bi bi-download"></i>
                                                    </button>
                                                </div>
                                                <img src="<?= base_url(); ?>assets/img/news-4.jpg" alt="" class="mw-100">
                                            </div>
                                            Thank you too. You can buy it from preview page and click on buy now.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i> 8:00 pm
                                </p>
                            </div>
                        </div>
                        <div class="row no-margin">
                            <div class="col-12  text-center">
                                <span class="alert-warning text-secondary mx-auto btn btn-sm py-1 mb-3">25 November
                                    2019</span>
                            </div>
                        </div>
                        <div class="row no-margin left-chat">
                            <div class="col-12">
                                <div class="chat-block">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mw-100 position-relative mb-2 figure">
                                                <video src="<?= base_url(); ?>https://maxartkiller.com/website/maxartkiller.mp4" controls="" preload="none"></video>
                                            </div>
                                            We also love this small presentation.
                                        </div>

                                    </div>
                                </div>
                                <div class="col-12">
                                    <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i> 8:00
                                        pm
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row no-margin right-chat">
                            <div class="col-12">
                                <div class="chat-block">
                                    <div class="row">
                                        <div class="col">
                                            <p>Ohh... Thats great. WinDOORS is HTML template can be used in various business domains like
                                                Manufacturing, inventory, IT, administration etc.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i> 8:00 pm
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-0">
                        <div class="input-group input-group-md">
                            <button class="btn btn-sm btn-link px-2"><i class="bi bi-emoji-smile"></i></button>
                            <button class="btn btn-sm btn-link px-2"><i class="bi bi-paperclip"></i></button>
                            <input type="text" class="form-control" placeholder="Type your message... " value="">
                            <button class="btn btn-sm btn-link px-2" type="button">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <button class="chat-close btn btn-danger text-white"><i class="bi bi-x"></i></button>
        </div>
    </div>
    <!-- chat window -->
    <div class="chatboxes w-auto align-right bottom-0 mb-2" style="display: none;" id="chatbot-hr">
        <!-- dropdown for each user  -->
        <div class="dropup">
            <div id="chatbot-bubble" class="chatbot-bubble text-dark" role="status" aria-live="polite">
                <h3 id="chatbot-bubbleTypewriter"></h3>
                <p id="chatbot-bubbleTypewriterP"></p>
            </div>
            <div class="dd-arrow-none dropdown-toggle" id="thefirstchat" data-bs-display="static" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="button">
                <span class="position-absolute top-0 start-100 translate-end p-1 bg-success border border-light rounded-circle">
                    <span class="visually-hidden">New alerts</span>
                </span>
                <figure class="avatar avatar-50 coverimg rounded-circle shadow"
                    style="box-shadow: 0 12px 40px rgba(2, 6, 23, 0.6) !important;
                ">
                    <img src="<?= base_url(); ?>assets/img/laras-chatbot.jpg" alt="">
                    <!-- <i class="ti-comments"></i> -->
                </figure>
            </div>
            <div class="dropdown-menu dropdown-menu-end w-300 mb-2 p-0">
                <!-- chat box here  -->
                <div class="card shadow-none border-0">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col align-self-center">

                                <p class="mb-0"> <i class="bi bi-stars me-2"></i>Laras - AI HR Assistant</p>
                                <p class="text-secondary small" id="last-message"></p>
                            </div>
                            <!-- <div class="col-auto">
                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-sm btn-square btn-outline-secondary border"><i class="bi bi-camera-video"></i></button>
                                    <button type="button" class="btn btn-sm btn-square btn-outline-secondary border"><i class="bi bi-person-plus"></i></button>
                                </div>
                            </div> -->
                            <!-- <div class="col-auto ps-0 align-self-center">
                                <div class="dropdown d-inline-block">
                                    <a class="dd-arrow-none" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false" role="button">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="javascript:void(0)">Add Contact</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)"><i class="bi bi-search"></i>Search</a></li>
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)"><i class="bi bi-x-circle text-danger"></i>Clear Chat</a></li>
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)">Report</a></li>
                                    </ul>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="card-body w-300 overflow-y-auto h-400 chat-list">

                    </div>
                    <div class="card-footer w-300 p-0">
                        <div class="input-group input-group-md">
                            <!-- <button class="btn btn-sm btn-link px-2"><i class="bi bi-emoji-smile"></i></button> -->
                            <!-- <button class="btn btn-sm btn-link px-2"><i class="bi bi-paperclip"></i></button> -->
                            <textarea id="chatbot-message" class="form-control" rows="1" style="resize: none;max-height: 75px;overflow-y: auto;" placeholder="Tanyakan sesuatu... "></textarea>
                            <button class="btn btn-sm btn-link px-2" type="button" onclick="chatbotSendMessage()">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <button class="chat-close btn btn-danger text-white"><i class="bi bi-x"></i></button>
        </div>
    </div>

    <!-- dropdown for support  -->
    <div class="chatboxes w-auto align-right bottom-0 mb-2" style="margin-right: 4rem !important;">

        <!-- dropdown for support  -->
        <div class="dropup">
            <div role="button" id="tothetop" class="dd-arrow-none dropdown-toggle" onclick='window.scrollTo({top: 0, behavior: "smooth"});' style="display: none;">

                <div class="avatar avatar-50 h5 bg-green text-white rounded-circle">
                    <i class="bi bi-rocket"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- dropdown for support  -->
    <div class="chatboxes w-auto align-right bottom-0 mb-2" style="display: none;">

        <!-- dropdown for support  -->
        <div class="dropup">
            <div class="dd-arrow-none dropdown-toggle" data-bs-display="static" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" id="supportdd" role="button">
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle">
                    <span class="visually-hidden">New alerts</span>
                </span>
                <figure class="avatar avatar-40 coverimg rounded-circle shadow bg-primary">
                    <img src="<?= base_url(); ?>assets/img/favicon72.png" alt="">
                </figure>
            </div>
            <div class="dropdown-menu dropdown-menu-end w-300 p-0">
                <!-- chat box here  -->
                <div class="card shadow-none border-0">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col align-self-center">
                                <p class="mb-0">Trusmiverse Support</p>
                                <p class="text-secondary small">Just now</p>
                            </div>
                            <div class="col-auto">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-sm btn-outline-secondary border"><i class="bi bi-person-plus"></i></button>
                                </div>
                            </div>
                            <div class="col-auto ps-0 align-self-center">
                                <div class="dropdown d-inline-block">
                                    <a class="dd-arrow-none" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false" role="button">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="statuschat">
                                        <li><a class="dropdown-item" href="javascript:void(0)">Add Contact</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)">Search</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)">Clear Chat</a></li>
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)">Repor <p class="mb-0">Trusmiverse Support</p>
                                                <p class="text-secondary small">Just now</p>
                                </div>
                                <div class="col-auto">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-sm btn-outline-secondary border"><i class="bi bi-person-plus"></i></button>
                                    </div>
                                </div>
                                <div class="col-auto ps-0 align-self-center">
                                    <div class="dropdown d-inline-block">
                                        <a class="dd-arrow-none" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false" role="button">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="statuschat">
                                            <li><a class="dropdown-item" href="javascript:void(0)">Add Contact</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)">Search</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)">Clear Chat</a></li>
                                            <li><a class="dropdown-item text-danger" href="javascript:void(0)">Report</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body overflow-y-auto h-250 chat-list">
                            <div class="row no-margin left-chat">
                                <div class="col-12">
                                    <div class="chat-block">
                                        <div class="row">
                                            <div class="col">
                                                Hi!
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <p class="text-secondary small time"><i class="bi bi-check"></i> <?= date("h:i"); ?></p>
                                </div>
                            </div>
                            <div class="row no-margin right-chat">
                                <div class="col-12">
                                    <div class="chat-block">
                                        <div class="row">
                                            <div class="col">
                                                Hi!<br> can i help you?
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 text-end">
                                    <p class="text-secondary small time"><i class="bi bi-check"></i> <?= date("h:i"); ?></p>
                                </div>
                            </div>
                            <div class="row no-margin">
                                <div class="col-12 text-center">
                                    <span class="alert-warning text-secondary mx-auto btn btn-sm py-1 mb-3"><?= date('d'); ?> <?= date('M'); ?>
                                        <?= date('Y'); ?></span>
                                </div>
                            </div>
                            <div class="row no-margin left-chat">
                                <div class="col-12">
                                    <div class="chat-block">
                                        <div class="row">
                                            <div class="col">
                                                WinDOORS is amazing and we thank you. How can we buy?
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i> 8:00 pm
                                    </p>
                                </div>
                            </div>
                            <div class="row no-margin right-chat">
                                <div class="col-12">
                                    <div class="chat-block">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mw-100 position-relative mb-2 figure">
                                                    <div class="position-absolute end-0 top-0">
                                                        <button class="avatar avatar-36 rounded-circle p-0 btn btn-info text-white shadow-sm m-2">
                                                            <i class="bi bi-download"></i>
                                                        </button>
                                                    </div>
                                                    <img src="<?= base_url(); ?>assets/img/news-4.jpg" alt="" class="mw-100">
                                                </div>
                                                Thank you too. You can buy it from preview page and click on buy now.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 text-end">
                                    <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i> 8:00 pm
                                    </p>
                                </div>
                            </div>
                            <div class="row no-margin">
                                <div class="col-12  text-center">
                                    <span class="alert-warning text-secondary mx-auto btn btn-sm py-1 mb-3">25 November
                                        2019</span>
                                </div>
                            </div>
                            <div class="row no-margin left-chat">
                                <div class="col-12">
                                    <div class="chat-block">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mw-100 position-relative mb-2 figure">
                                                    <video src="https://maxartkiller.com/website/maxartkiller.mp4" controls="" preload="none"></video>
                                                </div>
                                                We also love this small presentation.
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i> 8:00
                                            pm
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row no-margin right-chat">
                                <div class="col-12">
                                    <div class="chat-block">
                                        <div class="row">
                                            <div class="col">
                                                <p>Ohh... Thats great. WinDOORS is HTML template can be used in various business domains like
                                                    Manufacturing, inventory, IT, administration etc.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 text-end">
                                    <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i> 8:00 pm
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer p-0">
                            <div class="input-group input-group-md">
                                <button class="btn btn-sm btn-link px-2"><i class="bi bi-emoji-smile"></i></button>
                                <button class="btn btn-sm btn-link px-2"><i class="bi bi-paperclip"></i></button>
                                <input type="text" class="form-control" placeholder="Type your message... " value="">
                                <button class="btn btn-sm btn-link px-2" type="button">
                                    <i class="bi bi-send"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="chat-close btn btn-danger text-white"><i class="bi bi-x"></i></button>
            </div>
        </div>
        <!-- chat window ends -->


        <!-- Modal -->
        <div class="modal fade" id="modal-login-rsp" tabindex="-1" aria-labelledby="modal-login-rsp" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-login-rsp">Confirm Authentification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span>anda harus login, sebelum melanjutkan!</span>
                        <!-- <div class="col-12 col-lg-12 col-xl-12 col-xxl-12">
                        <div class="card border-0 mb-12">
                            <div class="coverimg w-100 h-180 position-relative" style="background-image: url('assets/img/bg-20.jpg');">
                                <div class="position-absolute bottom-0 start-0 w-100 mb-3 px-3 z-index-1">
                                    <div class="row">
                                        <div class="col">
                                            <button class="btn btn-sm btn-outline-light btn-rounded">Share this</button>
                                        </div>
                                        <div class="col-auto">
                                            <div class="dropup d-inline-block">
                                                <a class="btn btn-square btn-sm rounded-circle btn-outline-light dd-arrow-none" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="javascript:void(0)"><i class="bi bi-hand-thumbs-up me-1 text-green"></i> Recommendation this</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)"><i class="bi bi-hand-thumbs-down me-1 text-danger"></i> Don't recommend</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)"><i class="bi bi-star text-yellow"></i> Add to favorite</a></li>
                                                    <li><a class="dropdown-item text-danger" href="javascript:void(0)">Report this</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <img src="assets/img/bg-20.jpg" class="mw-100" alt="" style="display: none;">
                            </div>
                            <div class="card-body">
                                <h6 class="fw-medium">Demo image card without header</h6>
                                <h5 class="mb-3">We all are artist in our field. We all are able to find symmetry in our routine</h5>
                                <p class="text-secondary">We have added useful and wider-range of widgets fully flexible with wrapper container. We have added useful and wider-range of widgets fully flexible with wrapper container. If you still reading this, you are in love with this design. <a href="blog-4.html">Read more...</a> </p>
                            </div>
                        </div>
                    </div> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary m-1" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-theme m-1">Login</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Required jquery and libraries -->
        <script src="<?= base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
        <!-- <script src="<?= base_url(); ?>assets/js/popper.min.js"></script> -->
        <!-- <script src="<?= base_url(); ?>assets/js/bootstrap.min.js"></script> -->
        <!-- <script src="<?= base_url(); ?>assets/vendor/bootstrap-5/dist/js/bootstrap.bundle.js"></script> -->
        <!-- HARUS pakai BUNDLE agar modal dan popper.js bekerja -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



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

        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

        <script>
            $(document).ready(function() {
                var owl = $('.owl-carousel');
                owl.owlCarousel({
                    loop: false,
                    autoplay: false,
                    autoplayTimeout: 1500,
                    autoplayHoverPause: false,
                    responsiveClass: true,
                    responsive: {
                        0: {
                            items: 4,
                            margin: 10,
                            nav: false
                        },
                        600: {
                            items: 4,
                            margin: 10,
                            nav: false
                        },
                        1000: {
                            items: 4,
                            margin: 10,
                            nav: false,
                        }
                    }
                });
                paramInterval_b = 0;
                $("#text-pembelajar").fadeIn();
                $("#text-proaktif").hide();
                $("#text-positif").hide();
                setInterval(() => {
                    if (paramInterval_b == 1) {
                        $("#text-pembelajar").removeClass('d-flex').addClass('d-none').hide();
                        $("#text-proaktif").removeClass('d-none').addClass('d-flex').fadeIn();
                        $("#text-positif").removeClass('d-flex').addClass('d-none').hide();
                    }
                    if (paramInterval_b == 2) {
                        $("#text-pembelajar").removeClass('d-flex').addClass('d-none').hide();
                        $("#text-proaktif").removeClass('d-flex').addClass('d-none').hide();
                        $("#text-positif").removeClass('d-none').addClass('d-flex').fadeIn();
                    }
                    if (paramInterval_b == 3) {
                        $("#text-pembelajar").removeClass('d-none').addClass('d-flex').fadeIn();
                        $("#text-proaktif").removeClass('d-flex').addClass('d-none').hide();
                        $("#text-positif").removeClass('d-flex').addClass('d-none').hide();
                    }
                    paramInterval_b += 1;
                    if (paramInterval_b == 4) {
                        paramInterval_b = 1;
                    }
                }, 3000);

                $('.input-wrapper').addClass('animate-border');

                setTimeout(function() {
                    $('.input-wrapper').removeClass('animate-border');
                }, 2000); // Waktu animasi

                setInterval(function() {
                    $('.input-wrapper').addClass('animate-border');

                    setTimeout(function() {
                        $('.input-wrapper').removeClass('animate-border');
                    }, 2000); // Waktu animasi
                }, 15000);

                window.onscroll = function() {
                    scrollFunction()
                };

                function scrollFunction() {
                    let mybutton = document.getElementById("tothetop");
                    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                        mybutton.style.display = "block";
                    } else {
                        mybutton.style.display = "none";
                    }
                }

                $('#chatbot-hr').show();
                load_chats();
                typeWriterEffect();
            });

            // format currency
            function toCurrency(angka) {
                const currency = new Intl.NumberFormat('id', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(angka);

                return currency;
            }

            // function generateMenu(menuList, parent = $("#menu-container")) {
            //     parent.empty(); // Kosongkan sebelum diisi ulang
            //     if (typeof menuList?.length !== "undefined") {
            //         menuList.forEach(item => {
            //             let listItem = $("<li class='list-group-item'></li>");
            //             let link = $(`<a href="<?= base_url(); ?>${item.url}" class="menu-item">${item.menu}</a>`);

            //             // Cek jika URL adalah "#", nonaktifkan klik
            //             if (item.url === "#") {
            //                 link.addClass("disabled-link");
            //             }

            //             listItem.append(link);

            //             if (item.has_child && item.child) {
            //                 // If child is not array, wrap it
            //                 let childArr = Array.isArray(item.child) ? item.child : [item.child];
            //                 let childContainer = $("<ul class='list-group mt-2 ms-3'></ul>");
            //                 setTimeout(() => {
            //                     generateMenu(childArr, childContainer);
            //                     listItem.append(childContainer);
            //                 }, 500);
            //             }

            //             parent.append(listItem);
            //         });
            //     }
            // }

            // function searchMenu(query) {
            //     let found = false;
            //     $(".list-group-item").each(function() {
            //         let menuItem = $(this).find(".menu-item").first();
            //         let text = menuItem.text().toLowerCase();

            //         if (text.includes(query.toLowerCase())) {
            //             menuItem.addClass("highlight");
            //             $(this).show();
            //             $(this).parents(".list-group-item").show();
            //             found = true;
            //         } else {
            //             menuItem.removeClass("highlight");
            //             $(this).hide();
            //         }
            //     });
            //     return found;
            // }

            // $(document).ready(function() {
            //     $.ajax({
            //         url: "https://trusmiverse.com/apps/navigation_search",
            //         method: "GET",
            //         dataType: "json",
            //         success: function(data) {
            //             setTimeout(() => {
            //                 console.log(data);
            //                 generateMenu(data); // Generate menu saat halaman dimuat
            //                 $("#searchglobal").on("input", function() {
            //                     let query = $(this).val().trim();
            //                     if (query === "") {
            //                         $("#menu-container").addClass("hidden");
            //                         $(".menu-item").removeClass("highlight");
            //                     } else {
            //                         let found = searchMenu(query);
            //                         if (found) {
            //                             $("#menu-container").removeClass("hidden");
            //                         } else {
            //                             $("#menu-container").addClass("hidden");
            //                         }
            //                     }
            //                 });
            //             }, 500);
            //         },
            //         error: function(xhr, status, error) {
            //             console.error("Error fetching menu data:", error);
            //         }
            //     });
            // });

            function getAllMenuPaths() {
                let result = [];
                // Cari semua ul.dropdown-menu yang parent-nya bukan ul.dropdown-menu (root menu)
                $('ul.dropdown-menu').each(function() {
                    if (!$(this).parent().closest('ul.dropdown-menu').length) {
                        result = result.concat(getMenuPaths($(this)));
                    }
                });
                return result;
            }

            function getMenuPaths($ul, path = []) {
                let result = [];
                $ul.children('li').each(function() {
                    const $a = $(this).children('a[href]');
                    if ($a.length) {
                        const href = $a.attr('href');
                        const $col = $a.find('.col, .col.align-self-center');
                        const text = $col.length ? $col.text().trim() : $a.text().trim();
                        const newPath = [...path, text];
                        if (href !== '#' && href !== 'home.html#' && href !== 'javascript:void(0)') {
                            result.push({
                                path: newPath.join(' > '),
                                href
                            });
                        }
                        const $submenu = $(this).children('ul.dropdown-menu');
                        if ($submenu.length) {
                            result = result.concat(getMenuPaths($submenu, newPath));
                        }
                    }
                });
                return result;
            }

            $(function() {
                const menuData = getAllMenuPaths();
                $('#searchglobal').on('input', function() {
                    const keyword = $(this).val().toLowerCase();
                    const $results = $('#menu-container');
                    $results.empty();
                    if (keyword.length < 2) {
                        $("#menu-container").addClass("hidden");
                        $(".menu-item").removeClass("highlight");
                    } else {
                        $("#menu-container").removeClass("hidden");
                        menuData.filter(item => item.path.toLowerCase().includes(keyword))
                            .forEach(item => {
                                let cleanPath = item.path.replace(/[.,]/g, '').trim();
                                $results.append(`<li class="menu-item"><a href="${item.href}">${cleanPath}</a></li>`);
                                $(".menu-item").addClass("highlight");
                            });
                    }
                });

                $('#searchglobalmobile').on('input', function() {
                    const keyword = $(this).val().toLowerCase();
                    const $results = $('#menu-container-mobile');
                    $results.empty();
                    if (keyword.length < 2) {
                        $("#menu-container-mobile").addClass("hidden");
                        $(".menu-item").removeClass("highlight");
                    } else {
                        $("#menu-container-mobile").removeClass("hidden");
                        menuData.filter(item => item.path.toLowerCase().includes(keyword))
                            .forEach(item => {
                                let cleanPath = item.path.replace(/[.,]/g, '').trim();
                                $results.append(`<li class="menu-item"><a href="${item.href}">${cleanPath}</a></li>`);
                                $(".menu-item").addClass("highlight");
                            });
                    }
                });
            });

            $.ajax({
                    url: '<?php echo base_url() ?>login/history',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        menu: '<?php echo $this->uri->segment(1) ?>',
                        title: '<?php echo $pageTitle ?>',
                        link: '<?php echo current_url() ?>',
                    },
                })
                .done(function() {
                    console.log("success");
                })
                .fail(function() {
                    console.log("error");
                })
                .always(function() {
                    console.log("complete");
                });
        </script>
        <!-- BUBBLE CHAT START -->
        <style>
            #chatbot-hr .chat-list .left-chat .chat-block {
                background-color: #ffffff;
                color: #111111;
                padding: 15px;
                border-radius: var(--WinDOORS-rounded) var(--WinDOORS-rounded) var(--WinDOORS-rounded) 0px;
                margin-right: 3px;
                position: relative;
                width: auto;
                display: inline-block;
                margin-bottom: 5px;
                box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.05);
                -webkit-box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.05);
                -moz-box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.05);
                max-width: 90%;
            }

            #chatbot-hr .chat-list .left-chat .chat-block:before {
                content: "";
                position: absolute;
                left: 0px;
                bottom: -16px;
                height: 8px;
                width: 8px;
                border-radius: 0;
                border-color: transparent;
                border-style: solid;
                border-width: 10px;
                z-index: 1;
                border-top-color: #ffffff;
                border-left-color: #ffffff;
            }

            #chatbot-hr .chat-list .right-chat .chat-block {
                text-align: left;
                background-color: #015ec2;
                color: #ffffff;
                padding: 15px;
                border-radius: var(--WinDOORS-rounded) var(--WinDOORS-rounded) 0px var(--WinDOORS-rounded);
                margin-left: 3px;
                position: relative;
                width: auto;
                display: inline-block;
                margin-bottom: 5px;
                box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.05);
                -webkit-box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.05);
                -moz-box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.05);
                max-width: 90%;
            }

            #chatbot-hr .chat-list .right-chat .chat-block:before {
                content: "";
                position: absolute;
                right: 0px;
                bottom: -16px;
                height: 8px;
                width: 8px;
                border-radius: 0;
                border-color: transparent;
                border-style: solid;
                border-width: 10px;
                border-right-color: #015ec2;
                border-top-color: #015ec2;
                z-index: 0;
            }
        </style>
        <script>
            const chatbotMessage = document.getElementById('chatbot-message');

            chatbotMessage.addEventListener('input', () => {
                chatbotMessage.style.height = "auto"; // reset first
                chatbotMessage.style.height = chatbotMessage.scrollHeight + "px"; // then fit content
            });

            function timeAgo(dateStr) {
                // Convert string to Date (replace space with 'T' for ISO compliance)
                const past = new Date(dateStr.replace(" ", "T"));
                const now = new Date();

                const diffMs = now - past; // difference in ms
                const diffSec = Math.floor(diffMs / 1000);
                const diffMin = Math.floor(diffSec / 60);
                const diffHr = Math.floor(diffMin / 60);
                const diffDay = Math.floor(diffHr / 24);

                if (diffSec < 60) return `${diffSec} detik yang lalu`;
                if (diffMin < 60) return `${diffMin} menit yang lalu`;
                if (diffHr < 24) return `${diffHr} jam yang lalu`;
                return `${diffDay} hari yang lalu`;
            }

            function load_chats() {
                $.ajax({
                    url: "<?= base_url('chatbot/chatbot_history') ?>",
                    type: "get",
                    // data: {
                    //     message: message,
                    //     user_id: user_id,
                    //     session_id: session_id,
                    //     role: role
                    // },
                    dataType: "json",
                    success: function(res) {
                        let chats = res.chats;
                        if (chats.length == 0) return;
                        let tglchats = []
                        let chatList = $("#chatbot-hr .chat-list");
                        $(`#last-message`).html(`${timeAgo(chats[chats.length-1].created_at)}`);
                        chats.forEach(chat => {
                            let tglchat = new Date(chat.created_at.replace(" ", "T")).toLocaleDateString("id-ID", {
                                day: "numeric",
                                month: "long",
                                year: "numeric"
                            });
                            if (!tglchats.includes(tglchat)) {
                                tglchats.push(tglchat);
                                chatList.append(`
                                    <div class="row no-margin">
                                        <div class="col-12 text-center">
                                            <span class="alert-warning text-secondary mx-auto btn btn-sm py-1 mb-3 tglchats">${tglchat}</span>
                                        </div>
                                    </div>
                                `);
                            }
                            chatList.append(`
                                <div class="row no-margin right-chat">
                                    <div class="col-12">
                                        <div class="chat-block">
                                            <div class="row">
                                                <div class="col">
                                                    ${chat.pertanyaan}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-secondary small time"><i class="bi bi-check"></i>${chat.created_at.split(" ")[1].slice(0, 5)}</p>
                                    </div>
                                </div>
                                <div class="row no-margin left-chat">
                                    <div class="col-12">
                                        <div class="chat-block">
                                            <div class="row">
                                                <div class="col">
                                                    ${chat.jawaban}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-secondary small time"><i class="bi bi-check"></i>${chat.created_at.split(" ")[1].slice(0, 5)}</p>
                                    </div>
                                </div>
                            `);
                        });
                        chatList.scrollTop(chatList[chatList.length - 1].scrollHeight);
                        // console.log($(`#chatbot-hr .tglchats`).map(function() {
                        //     return $(this).text().trim();
                        // }).get());

                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error, xhr.responseText);
                    }
                });
            }

            $(document).on('shown.bs.dropdown', '#thefirstchat', function() {
                const chatList = $("#chatbot-hr .chat-list");
                if (!chatList) return;
                requestAnimationFrame(() => {
                    chatList.scrollTop(chatList[chatList.length - 1].scrollHeight);
                });
                bubble.style.display = 'none';
                // bubble.style.opacity = '0';
                // bubble.style.transition = 'opacity 100ms';
                // setTimeout(() => bubble.style.display = 'none', 100);
            });
            ["click", "keydown", "scroll"].forEach(evt => {
                document.addEventListener(evt, function() {
                    document.getElementById('chatbot-bubble').style.display = 'none';
                });
            });

            function chatbotSendMessage() {
                var message = $("#chatbot-message").val();
                var user_id = <?= $this->session->userdata("user_id") ?>;
                var chatList = $("#chatbot-hr .chat-list");
                var session_id = "<?= $this->session->session_id; ?>"; // fungsi untuk generate session ID
                var role = "user"; // default role

                if (message.trim() === "") return; // cegah insert kosong

                let tglchats = $(`#chatbot-hr .tglchats`).map(function() {
                    return $(this).text().trim();
                }).get();
                let tglchat = new Date().toLocaleDateString("id-ID", {
                    day: "numeric",
                    month: "long",
                    year: "numeric"
                });
                if (!tglchats.includes(tglchat)) {
                    tglchats.push(tglchat);
                    chatList.append(`
                        <div class="row no-margin">
                            <div class="col-12 text-center">
                                <span class="alert-warning text-secondary mx-auto btn btn-sm py-1 mb-3 tglchats">${tglchat}</span>
                            </div>
                        </div>
                    `);
                }
                // tampilkan pesan user langsung
                chatList.append(`
                    <div class="row no-margin right-chat">
                        <div class="col-12">
                            <div class="chat-block">
                                <div class="row">
                                    <div class="col">
                                        ${message}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <p class="text-secondary small time"><i class="bi bi-check"></i>${new Date().toTimeString().slice(0,5)}</p>
                        </div>
                    </div>
                `);

                // Tampilkan loading indicator
                chatList.append(`
                    <div class="row no-margin left-chat" id="loading-indicator">
                        <div class="col-12">
                            <div class="chat-block">
                                <div class="row">
                                    <div class="col">
                                        <i class="fas fa-spinner fa-spin"></i> Thinking...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
                chatList.scrollTop(chatList[chatList.length - 1].scrollHeight);
                // Run after the DOM and Bootstrap JS are loaded
                // ['keydown','keypress','keyup','input'].forEach(ev => {
                // document.getElementById('chatbot-message')
                //     ?.addEventListener(ev, e => e.stopPropagation());
                // });

                $.ajax({
                    url: "<?= base_url('api/insert_chatbot_hr/save_chatbot_hr') ?>",
                    type: "POST",
                    data: {
                        message: message,
                        user_id: user_id,
                        session_id: session_id,
                        role: role
                    },
                    dataType: "json",
                    success: function(res) {
                        // Hapus loading indicator
                        $("#loading-indicator").remove();

                        if (res.status === 'success' && res.jawaban) {
                            // console.log(res);

                            chatList.append(`
                                <div class="row no-margin left-chat">
                                    <div class="col-12">
                                        <div class="chat-block">
                                            <div class="row">
                                                <div class="col">
                                                    ${res.jawaban}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-secondary small time"><i class="bi bi-check"></i>${res.updated_at.split(" ")[1].slice(0, 5)}</p>
                                    </div>
                                </div>
                            `);
                            $(`#last-message`).html(`Baru saja`);
                        } else {
                            chatList.append(`
                                <div class="row no-margin left-chat">
                                    <div class="col-12">
                                        <div class="chat-block">
                                            <div class="row">
                                                <div class="col">
                                                    ${res.jawaban || 'Terjadi Kesalahan'}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-secondary small time"><i class="bi bi-check"></i>${res.updated_at ? res.updated_at.split(" ")[1].slice(0, 5) : ''}</p>
                                    </div>
                                </div>
                            `);
                            $(`#last-message`).html(`Baru saja`);
                        }
                        chatList.scrollTop(chatList[chatList.length - 1].scrollHeight);
                    },
                    error: function(xhr, status, error) {
                        $("#loading-indicator").remove();
                        chatList.append(`
                            <div class="row no-margin left-chat">
                                <div class="col-12">
                                    <div class="chat-block">
                                        <div class="row">
                                            <div class="col">
                                                Error: Terjadi kesalahan koneksi
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);
                        chatList.scrollTop(chatList[chatList.length - 1].scrollHeight);
                        $(`#last-message`).html(`Baru saja`);
                        console.error("Error:", error, xhr.responseText);
                    }
                });

                $("#chatbot-message").val(""); // kosongkan input
            }

            // Fungsi untuk generate session ID
            function generateSessionId() {
                return 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            }

            let full_name = "<?= $this->session->userdata('nama'); ?>"
            const bubble = document.getElementById('chatbot-bubble');

            const jikoshoukaiList = [
                "Halo " + full_name + ", senang kenalan denganmu!",
                "Aku adalah partner HR-mu yang selalu siap menjawab pertanyaan soal cuti, izin, jam kerja, sampai aturan kantor.",
                "Panggil aku Laras! AI HR Assistant ramah yang ngerti banget dunia kerja, tanpa ribet dan selalu kasih info jelas. 🌸🤖",
                "Bersama kita bikin suasana kerja lebih transparan dan nyaman, biar semua tahu hak & kewajiban mereka.",
                "Butuh tahu cara ajukan cuti? Atau aturan lembur? Laras siap kasih jawaban cepat dan enak dibaca. 🕒➡✅",
                "Misi utamaku? Biar kamu nggak perlu bongkar-bongkar aturan HR atau tanya sana-sini. Aku yang bantu, kamu tinggal fokus kerja. 💼✨"
            ];

            let currentText = "";
            let charIndex = 0;
            let jikoIndex = 0;

            let typeTimer = null,
                holdTimer = null,
                isTyping = false;

            function typeWriterEffect() {
                const el = document.getElementById("chatbot-bubbleTypewriter");

                if (jikoIndex >= jikoshoukaiList.length) {
                    /* fade out... */
                    return;
                }

                // mulai kalimat baru
                if (!isTyping && charIndex === 0) el.textContent = "";

                isTyping = true;
                if (typeTimer) clearTimeout(typeTimer);
                typeTimer = setTimeout(() => {
                    currentText += jikoshoukaiList[jikoIndex].charAt(charIndex);
                    el.textContent = currentText;
                    charIndex++;

                    if (charIndex < jikoshoukaiList[jikoIndex].length) {
                        typeWriterEffect();
                    } else {
                        isTyping = false;
                        // jeda baca
                        if (holdTimer) clearTimeout(holdTimer);
                        holdTimer = setTimeout(() => {
                            jikoIndex++; // naik SETELAH selesai render
                            currentText = "";
                            charIndex = 0;
                            typeWriterEffect();
                            if (jikoIndex >= jikoshoukaiList.length) {
                                // Fade out lalu remove
                                bubble.style.transition = 'opacity 500ms';
                                bubble.style.opacity = '0';
                                bubble.style.pointerEvents = 'none';
                                bubble.addEventListener('transitionend', () => bubble.remove(), {
                                    once: true
                                });
                                return;
                            }
                        }, 1500);
                    }
                }, 40);

            }
            // function typeWriterEffect() {
            //     if (jikoIndex < jikoshoukaiList.length) {
            //         if (charIndex < jikoshoukaiList[jikoIndex].length) {
            //             currentText += jikoshoukaiList[jikoIndex].charAt(charIndex);
            //             document.getElementById("bubbleTypewriter").innerHTML = currentText;
            //             charIndex++;
            //             setTimeout(typeWriterEffect, 40);
            //         } else {
            //             setTimeout(() => {
            //                 jikoIndex++;
            //                 console.log(jikoIndex);

            //                 if (jikoIndex < jikoshoukaiList.length) {
            //                     currentText = "";
            //                     charIndex = 0;
            //                     typeWriterEffect();
            //                 } else {
            //                     bubble.style.opacity = '0';
            //                     bubble.style.transition = 'opacity 500ms';
            //                     setTimeout(() => bubble.style.display = 'none', 500);
            //                 }
            //             }, 1500);
            //         }
            //     }
            // }

            // window.onload = typeWriterEffect;
        </script>
        <!-- BUBBLE CHAT END -->

</body>

</html>