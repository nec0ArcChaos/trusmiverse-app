<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>Trusmiverse - Campaign Management System</title>

    <!-- manifest meta -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <!-- <link rel="manifest" href="manifest.json" /> -->

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="https://trusmiverse.com/apps/assets/img/logo_trusmiverse.png" sizes="180x180">
    <link rel="icon" href="https://trusmiverse.com/apps/assets/img/logo_trusmiverse.png" sizes="32x32" type="image/png">
    <link rel="icon" href="https://trusmiverse.com/apps/assets/img/logo_trusmiverse.png" sizes="16x16" type="image/png">

    <!-- Google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <!-- chosen css -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/compas/main_theme/vendor/chosen_v1.8.7/chosen.min.css">

    <!-- date range picker -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/compas/main_theme/vendor/daterangepicker/daterangepicker.css">

    <!-- swiper carousel css -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/compas/main_theme/vendor/swiper-7.3.1/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/compas/main_theme/vendor/dragula/dragula.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/compas/main_theme/vendor/dropzone5-9-3/dropzone.min.css">


    <!-- style css for this template -->
    <link href="<?= base_url() ?>assets/compas/main_theme/scss/style.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>assets/compas/main_theme/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/compas/main_theme/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/compas/main_theme/css/responsive.dataTables.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/compas/css/jquery-comments.css') ?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link
        href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700;900&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <style>
        .jquery-comments .textarea-wrapper .control-row>span {
            border-radius: var(--bs-border-radius-lg);
            margin-bottom: 0.5rem;
            margin-top: 0.5rem;
        }

        .jquery-comments .attachments .tag {
            display: table-cell;
            vertical-align: middle;
            padding: 0.05em 0.5em;
        }

        .jquery-comments .attachments .tag>i:first-child {
            font-size: 12px;
            margin-top: 0.25rem;
            margin-left: 0.15rem;
        }
    </style>

    <?php //if (isset($css)): ?>
    <?php //$this->load->view($css); ?>
    <?php //endif; ?>
    <style>
        .custom-loader-overlay {
            position: relative;
        }

        .custom-loader-overlay.with-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(3px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
        }

        /* Loader box */
        .custom-loader-box {
            /* background: #fff; */
            padding: 20px 28px;
            border-radius: 12px;
            min-width: 150px;
        }

        /* Dot loader */
        .loading-dots span {
            animation: blink 1.4s infinite both;
            font-size: 2rem;
        }

        .loading-dots span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .loading-dots span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes blink {
            0% {
                opacity: 0.2;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0.2;
            }
        }

        .bg-soft-blue {
            background-color: #E6EFF8;
        }
    </style>
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
                <p class="text-secondary small">Amazing things coming from the <span class="text-dark">WinDOORS</span>
                </p>
                <div class="spinner-border text-primary mt-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    <!-- page loader ends -->

    <!-- background -->
    <div class="coverimg h-100 w-100 top-0 start-0 main-bg">
        <div class="bg-blur main-bg-overlay"></div>
        <img src="<?= base_url() ?>assets/compas/main_theme/img/bg-14.jpg" alt="" />
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
                    <a class="navbar-brand ms-2" href="https://trusmiverse.com/apps/">
                        <div class="row">
                            <div class="col-auto"><img
                                    src="https://trusmiverse.com/apps/assets/img/logo_trusmiverse.png"
                                    class="mx-100 logo-mobile" alt=""></div>
                            <div class="col ps-0 align-self-center d-none d-sm-block">
                                <h5 class="fw-bold text-dark mb-0">CAMPAIGN</h5>
                                <h5 class="text-dark fw-normal small">Management System</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="search-header d-none d-xl-block">
                </div>
                <div class="navbar-expand-xl d-none d-xxxl-block ms-3">
                </div>
                <div class="ms-auto">
                    <div class="row">
                        <div class="col-auto">
                            <button type="button" class="btn btn-square btn-link text-center" id="showNotification"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Notifications">
                                <span class="bi bi-bell position-relative">
                                    <span
                                        class="position-absolute top-0 start-100 p-1 bg-danger border border-light rounded-circle">
                                        <span class="visually-hidden">New alerts</span>
                                    </span>
                                </span>
                            </button>
                        </div>
                        <div class="col-auto align-self-center px-0  d-none d-xxxl-block">
                            <i class="bi bi-three-dots-vertical opacity-3 text-secondary"></i>
                        </div>
                        <div class="col-auto">
                            <div class="dropdown">
                                <a class="dd-arrow-none dropdown-toggle tempdata" id="userprofiledd"
                                    data-bs-toggle="dropdown" aria-expanded="false" role="button">
                                    <div class="row">
                                        <div class="col-auto align-self-center">
                                            <figure class="avatar avatar-40 rounded-circle coverimg vm"
                                                style="background-image: url(&quot;https://trusmiverse.com/hr/uploads/profile/<?= $this->session->userdata('profile_picture') ?>&quot;);">
                                                <img src="https://trusmiverse.com/hr/uploads/profile/<?= $this->session->userdata('profile_picture') ?>"
                                                    alt="" id="userphotoonboarding2" style="display: none;">
                                            </figure>
                                        </div>
                                        <div class="col ps-0 align-self-center d-none d-lg-block">
                                            <p class="mb-0">
                                                <span class="text-dark username">
                                                    <?= $this->session->userdata('nama') ?>
                                                </span><br>
                                                <small class="small">
                                                    <?= $this->session->userdata('jabatan') ?>
                                                </small>
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
                                                <figure class="avatar avatar-50 rounded-circle coverimg vm"
                                                    style="background-image: url(&quot;https://trusmiverse.com/hr/uploads/profile/<?= $this->session->userdata('profile_picture') ?>&quot;);">
                                                    <img src="https://trusmiverse.com/hr/uploads/profile/<?= $this->session->userdata('profile_picture') ?>"
                                                        alt="" id="userphotoonboarding3" style="display: none;">
                                                </figure>
                                            </div>
                                            <div class="col align-self-center ps-0">
                                                <h6 class="mb-0"><span class="username">
                                                        <?= $this->session->userdata('nama') ?>
                                                    </span></h6>
                                                <p class="text-muted small">
                                                    <?= $this->session->userdata('jabatan') ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div><a class="dropdown-item" href="#"><i class="bi bi-person-fill-gear"></i> My
                                            Profile</a></div>
                                    <div><a class="dropdown-item" href="https://trusmiverse.com/apps/theme"><i
                                                class="bi bi-palette"></i> Change Theme</a></div>
                                    <div><a class="dropdown-item" href="https://trusmiverse.com/apps/login/logout"><i
                                                class="bi bi-door-open"></i>Logout</a></div>
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
                <!-- back to main menu navigation -->
                <div class="row mb-4">
                    <div class="col-12 px-0">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="<?= base_url() ?>">
                                    <div class=" avatar avatar-40 icon"><i class="bi bi-arrow-left"></i>
                                    </div>
                                    <div class="col">Back to Main App</div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col align-self-center">
                        <h6>Mini App Campaign</h6>
                    </div>
                    <div class="col-auto">
                        <a class="" data-bs-toggle="collapse" data-bs-target="#usersidebarprofile" aria-expanded="true"
                            role="button" aria-controls="usersidebarprofile">
                            <i class="bi bi-person-circle"></i>
                        </a>
                    </div>
                </div>

                <!-- user information -->
                <div class="row text-center collapse show" id="usersidebarprofile">
                    <div class="col-12">
                        <div class="avatar avatar-100 rounded-circle shadow-sm mb-3 bg-white">
                            <figure class="avatar avatar-90 rounded-circle coverimg">
                                <img src="<?= $this->session->userdata('profile_picture') ? base_url('hr/uploads/profile/' . $this->session->userdata('profile_picture')) : base_url('hr/uploads/profile/anonim.jpg') ?>"
                                    alt="" id="userphotoonboarding">
                            </figure>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <h6 class="mb-1" id="usernamedisplay"><?= $this->session->userdata('nama') ?></h6>
                        <p class="text-secondary small">
                            <?= $this->session->userdata('jabatan') ?>
                        </p>
                    </div>
                </div>

                <!-- campaign menu navigation -->
                <div class="row mb-4">
                    <div class="col-12 px-0">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link menus-btn active" href="javascript:void(0)"
                                    onclick="switchMenu('Dashboard')" data-value="dashboard">
                                    <div class="avatar avatar-40 icon"><i class="bi bi-speedometer2"></i></div>
                                    <div class="col">Dashboard</div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menus-btn active" href="javascript:void(0)"
                                    onclick="switchMenu('Campaign')" data-value="campaign">
                                    <div class="avatar avatar-40 icon"><i class="bi bi-megaphone"></i></div>
                                    <div class="col">Campaign</div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menus-btn" href="javascript:void(0)"
                                    onclick="switchMenu('Activation')" data-value="activation">
                                    <div class="avatar avatar-40 icon"><i class="bi bi-calendar"></i></div>
                                    <div class="col">Event Activations</div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menus-btn" href="javascript:void(0)" onclick="switchMenu('Content')"
                                    data-value="content">
                                    <div class="avatar avatar-40 icon"><i class="bi bi-pen"></i></div>
                                    <div class="col">Content Plan</div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menus-btn" href="javascript:void(0)" onclick="switchMenu('Talent')"
                                    data-value="talent">
                                    <div class="avatar avatar-40 icon"><i class="bi bi-people"></i></div>
                                    <div class="col">Talent Acquisition</div>
                                    <div class="arrow"><i class="bi bi-chevron-right"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menus-btn" href="javascript:void(0)"
                                    onclick="switchMenu('Distribution')" data-value="distribution">
                                    <div class="avatar avatar-40 icon"><i class="bi bi-share"></i></div>
                                    <div class="col">Distribution Plan</div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menus-btn" href="javascript:void(0)"
                                    onclick="switchMenu('Optimization')" data-value="optimization">
                                    <div class="avatar avatar-40 icon"><i class="bi bi-graph-up"></i></div>
                                    <div class="col">Optimization Plan</div>
                                    <div class="arrow"><i class="bi bi-chevron-right"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menus-btn" href="javascript:void(0)" onclick="switchMenu('Settings')"
                                    data-value="settings">
                                    <div class="avatar avatar-40 icon"><i class="bi bi-gear"></i></div>
                                    <div class="col">General Settings</div>
                                    <div class="arrow"><i class="bi bi-chevron-right"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sidebar ends -->

    <!-- Begin page content -->
    <main class="main mainheight">
        <!-- title bar -->
        <div class="container-fluid">
            <div class="row align-items-center page-title">
                <div class="col-12 col-md mb-2 mb-sm-0">
                    <h5 class="mb-0">COMPAS</h5>
                    <p class="text-secondary">Campaign Optimization & Management Professional Assistant.</p>
                </div>
            </div>
            <input type="hidden" id="detail_id">
            <input type="hidden" id="active_menu">
            <input type="hidden" id="active_tab">
            <div class="row">
                <nav aria-label="breadcrumb" class="breadcrumb-theme">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Trusmiverse</a></li>
                        <li class="breadcrumb-item active" id="active-breadcrumb">Campaign</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- content -->
        <div class="container-fluid" id="menus-content">
        </div>

        <!-- Footer -->
        <div class="container-fluid footer-page mt-4 mb-4 py-5">
            <!-- <div class="row mb-2">
                <div class="col-12 col-xxl-11 mx-auto">
                    <div class="row">
                        <div class="col-12 col-xl-3 col-xxl-3 mb-2 mb-xl-0">
                            <h2 class="mb-3"><span class="text-gradient">#1 Trusmiverse</span></h2>
                            <h5 class="mb-2">Trusmiverse is committed to providing an experience that builds
                                trust. Clean & Trending UI design with a great user experience</h5>
                        </div>
                        <div class="col-12 col-md-4 col-xl-3 col-xxl-3">
                            <p class="mb-2"><b>Main office:</b></p>
                            <p class="mb-1"><a href="https://trusmigroup.com/" target="_blank">www.trusmigroup.com</a>
                            </p>
                            <p class="mb-4 text-secondary">Jl. H. Abas No.48, Trusmi Kulon, Kec. Weru, Kabupaten
                                Cirebon, Jawa Barat 45154</p>
                        </div>
                        <div class="col-12 col-md-4 col-xl-3 col-xxl-3 mb-3">
                            <div class="row align-items-center mb-3">
                                <div class="col-auto"><i class="bi bi-clock text-theme"></i></div>
                                <div class="col ps-0"><span class="text-secondary">Mon - Sat, 9:00 WIB - 16:00
                                        WIB</span></div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <div class="col-auto"><i class="bi bi-telephone text-theme"></i></div>
                                <div class="col ps-0"><span class="text-secondary">(0231) 8304766</span></div>
                            </div>
                            <div class="row">
                                <div class="col item text-center">
                                    <figure class="cols avatar avatar-40 coverimg rounded-circle"
                                        style="background-image: url(&quot;<?= base_url(); ?>assets/img/logo_rumah_ningrat.png&quot;);">
                                        <img src="<?= base_url(); ?>assets/img/logo_rumah_ningrat.png" alt=""
                                            style="display: none;">
                                    </figure>
                                </div>
                                <div class="col item text-center">
                                    <figure class="cols avatar avatar-40 coverimg rounded-circle"
                                        style="background-image: url(&quot;<?= base_url(); ?>assets/img/logo_bt.png&quot;);">
                                        <img src="<?= base_url(); ?>assets/img/logo_bt.png" alt=""
                                            style="display: none;">
                                    </figure>
                                </div>
                                <div class="col item text-center">
                                    <figure class="cols avatar avatar-40 coverimg rounded-circle"
                                        style="background-image: url(&quot;<?= base_url(); ?>assets/img/logo_tkb.png&quot;);">
                                        <img src="<?= base_url(); ?>assets/img/logo_tkb.png" alt=""
                                            style="display: none;">
                                    </figure>
                                </div>
                                <div class="col item text-center">
                                    <figure class="cols avatar avatar-40 coverimg rounded-circle"
                                        style="background-image: url(&quot;<?= base_url(); ?>assets/img/fbtlogo.png&quot;);">
                                        <img src="<?= base_url(); ?>assets/img/fbtlogo.png" alt=""
                                            style="display: none;">
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-xl-3 col-xxl-3">
                            <ul class="nav justify-content-center">
                                <li class="nav-item">
                                    <a class="nav-link text-secondary" href="https://twitter.com/TrusmiGroup"
                                        target="_blank">
                                        <i class="bi bi-twitter h5"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-secondary"
                                        href="https://www.linkedin.com/company/trusmigroup/mycompany/" target="_blank">
                                        <i class="bi bi-linkedin h5"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-secondary" href="https://www.instagram.com/trusmigroup/"
                                        target="_blank">
                                        <i class="bi bi-instagram h5"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </main>

    <div id="modal-content" style="display: contents;"></div>

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
                            <button class="btn btn-sm btn-link dd-arrow-none" type="button" id="statuschat"
                                data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="statuschat">
                                <li><a class="dropdown-item" href="javascript:void(0)"><span
                                            class="vm me-1 bg-success rounded-circle d-inline-block p-1"></span>
                                        Online</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)"><span
                                            class="vm me-1 bg-warning rounded-circle d-inline-block p-1"></span>
                                        Away</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)"><span
                                            class="vm me-1 bg-danger rounded-circle d-inline-block p-1"></span>
                                        Offline</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)"><span
                                            class="vm me-1 bg-secondary rounded-circle d-inline-block p-1"></span>
                                        Disabled</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-header">
                        <div class="row">
                            <div class="col d-grid">
                                <button class="btn btn-outline-secondary border" type="button"><i
                                        class="bi bi-camera-video me-2"></i> Meet</button>
                            </div>
                            <div class="col d-grid">
                                <button class="btn btn-outline-secondary border" type="button"><i
                                        class="bi bi-chat-right-text me-2"></i> Chat</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body h-100 overflow-y-auto p-0">
                        <ul class="list-group list-group-flush bg-none rounded-0 ">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-44 coverimg rounded-circle">
                                            <img src="<?= base_url() ?>assets/compas/main_theme/img/user-2.jpg"
                                                alt="" />
                                        </figure>
                                    </div>
                                    <div class="col-9 align-self-center ps-0">
                                        <div class="row g-0">
                                            <div class="col-8">
                                                <p class="text-truncate mb-0">Angelina Devid</p>
                                            </div>
                                            <div class="col-4 text-end"><small class="text-muted fs-10 mb-1"><i
                                                        class="bi bi-check"></i> 2:00 am</small></div>
                                        </div>
                                        <p class="text-secondary small text-truncate">Spread love and spread this
                                            template</p>
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
                                            <div class="col-4 text-end"><small class="text-muted fs-10 mb-1"><i
                                                        class="bi bi-check-all"></i> 2:00 am</small></div>
                                        </div>
                                        <p class="text-secondary small text-truncate">Spread love and spread this
                                            template</p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-44 coverimg rounded-circle">
                                            <img src="<?= base_url() ?>assets/compas/main_theme/img/user-4.jpg"
                                                alt="" />
                                        </figure>
                                    </div>
                                    <div class="col-9 align-self-center ps-0">
                                        <div class="row g-0">
                                            <div class="col-8">
                                                <p class="text-truncate mb-0">Roberto Carlos</p>
                                            </div>
                                            <div class="col-4 text-end"><small class="text-muted fs-10 mb-1"><i
                                                        class="bi bi-check-all text-info"></i> 2:00 am</small></div>
                                        </div>
                                        <p class="text-secondary small text-truncate">Spread love and spread this
                                            template</p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-44 coverimg rounded-circle">
                                            <img src="<?= base_url() ?>assets/compas/main_theme/img/user-1.jpg"
                                                alt="" />
                                        </figure>
                                    </div>
                                    <div class="col-9 align-self-center ps-0">
                                        <div class="row g-0">
                                            <div class="col-8">
                                                <p class="text-truncate mb-0">The Maxartkiller</p>
                                            </div>
                                            <div class="col-4 text-end"><small class="text-muted fs-10 mb-1"><i
                                                        class="bi bi-check-all text-success"></i> 2 days ago</small>
                                            </div>
                                        </div>
                                        <p class="text-secondary small text-truncate">Spread love and spread this
                                            template</p>
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
                                            <div class="col-4 text-end"><small class="text-muted fs-10 mb-1"><i
                                                        class="bi bi-check-all"></i> 4 days ago</small></div>
                                        </div>
                                        <p class="text-secondary small text-truncate">Spread love and spread this
                                            template</p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item disabled" data-bs-toggle="modal"
                                data-bs-target="#chatmodalwindow">
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
                                            <div class="col-4 text-end"><small class="text-muted fs-10 mb-1"><i
                                                        class="bi bi-check"></i> 1 mo ago</small></div>
                                        </div>
                                        <p class="text-secondary small text-truncate">Spread love and spread this
                                            template</p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-44 coverimg rounded-circle bg-theme">
                                            <img src="<?= base_url() ?>assets/compas/main_theme/img/favicon72.png"
                                                alt="" />
                                        </figure>
                                    </div>
                                    <div class="col-9 align-self-center ps-0">
                                        <div class="row g-0">
                                            <div class="col-8">
                                                <p class="text-truncate mb-0">getWinDOORS Support</p>
                                            </div>
                                            <div class="col-4 text-end"><small class="text-muted fs-10 mb-1"><i
                                                        class="bi bi-check"></i> 2:00 am</small></div>
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
                                            <div class="col-4 text-end"><small class="text-muted fs-10 mb-1"><i
                                                        class="bi bi-check-all"></i> 2:00 am</small></div>
                                        </div>
                                        <p class="text-secondary small text-truncate">Spread love and spread this
                                            template</p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-44 coverimg rounded-circle">
                                            <img src="<?= base_url() ?>assets/compas/main_theme/img/user-4.jpg"
                                                alt="" />
                                        </figure>
                                    </div>
                                    <div class="col-9 align-self-center ps-0">
                                        <div class="row g-0">
                                            <div class="col-8">
                                                <p class="text-truncate mb-0">Roberto Carlos</p>
                                            </div>
                                            <div class="col-4 text-end"><small class="text-muted fs-10 mb-1"><i
                                                        class="bi bi-check-all text-info"></i> 2:00 am</small></div>
                                        </div>
                                        <p class="text-secondary small text-truncate">Spread love and spread this
                                            template</p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-44 coverimg rounded-circle">
                                            <img src="<?= base_url() ?>assets/compas/main_theme/img/user-1.jpg"
                                                alt="" />
                                        </figure>
                                    </div>
                                    <div class="col-9 align-self-center ps-0">
                                        <div class="row g-0">
                                            <div class="col-8">
                                                <p class="text-truncate mb-0">The Maxartkiller</p>
                                            </div>
                                            <div class="col-4 text-end"><small class="text-muted fs-10 mb-1"><i
                                                        class="bi bi-check-all text-success"></i> 2 days ago</small>
                                            </div>
                                        </div>
                                        <p class="text-secondary small text-truncate">Spread love and spread this
                                            template</p>
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
                                            <div class="col-4 text-end"><small class="text-muted fs-10 mb-1"><i
                                                        class="bi bi-check-all"></i> 4 days ago</small></div>
                                        </div>
                                        <p class="text-secondary small text-truncate">Spread love and spread this
                                            template</p>
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
                        <input type="text" class="form-control" value="" id="notificationdaterange"
                            placeholder="Filter by Date" />
                    </div>
                </div>
                <div class="card border-0 mb-2">
                    <div class="input-group input-group-md">
                        <span class="input-group-text text-theme"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="searchNotification"
                            placeholder="Search Activity Log...">
                    </div>
                </div>
                <div id="activity-log-container">
                    <!-- Content will be loaded here -->
                </div>
            </div>
            <!-- notifications window ends -->

        </div>
    </div>
    <!-- Rightbar ends -->

    <!-- chat window -->
    <div class="chatboxes w-auto align-right mb-2">
        <!-- dropdown for each user  -->
        <div class="dropstart">
            <div class="dd-arrow-none dropdown-toggle" id="thefirstchat" data-bs-display="static"
                data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="button">
                <span class="position-absolute top-0 start-100 p-1 bg-danger border border-light rounded-circle">
                    <span class="visually-hidden">New alerts</span>
                </span>
                <figure class="avatar avatar-40 coverimg rounded-circle shadow">
                    <img src="<?= base_url() ?>assets/compas/main_theme/img/user-2.jpg" alt="">
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
                                    <button type="button" class="btn btn-sm btn-square btn-outline-secondary border"><i
                                            class="bi bi-camera-video"></i></button>
                                    <button type="button" class="btn btn-sm btn-square btn-outline-secondary border"><i
                                            class="bi bi-person-plus"></i></button>
                                </div>
                            </div>
                            <div class="col-auto ps-0 align-self-center">
                                <div class="dropdown d-inline-block">
                                    <a class="dd-arrow-none" data-bs-toggle="dropdown" data-bs-auto-close="true"
                                        aria-expanded="false" role="button">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="javascript:void(0)">Add Contact</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)">Search</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)">Clear Chat</a></li>
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)">Report</a>
                                        </li>
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
                                <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i> 8:00
                                    pm
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
                                                    <button
                                                        class="avatar avatar-36 rounded-circle p-0 btn btn-info text-white shadow-sm m-2">
                                                        <i class="bi bi-download"></i>
                                                    </button>
                                                </div>
                                                <img src="<?= base_url() ?>assets/compas/main_theme/img/news-4.jpg"
                                                    alt="" class="mw-100">
                                            </div>
                                            Thank you too. You can buy it from preview page and click on buy now.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i> 8:00
                                    pm
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
                                                <video src="https://maxartkiller.com/website/maxartkiller.mp4"
                                                    controls="" preload="none"></video>
                                            </div>
                                            We also love this small presentation.
                                        </div>

                                    </div>
                                </div>
                                <div class="col-12">
                                    <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i>
                                        8:00
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
                                            <p>Ohh... Thats great. WinDOORS is HTML template can be used in various
                                                business domains like
                                                Manufacturing, inventory, IT, administration etc.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i> 8:00
                                    pm
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
            <div class="dd-arrow-none dropdown-toggle" data-bs-display="static" data-bs-toggle="dropdown"
                data-bs-auto-close="outside" aria-expanded="false" role="button">
                <span
                    class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle">
                    <span class="visually-hidden">New alerts</span>
                </span>
                <figure class="avatar avatar-40 coverimg rounded-circle shadow">
                    <img src="<?= base_url() ?>assets/compas/main_theme/img/user-4.jpg" alt="">
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
                                    <button type="button" class="btn btn-sm btn-outline-secondary border"><i
                                            class="bi bi-camera-video"></i></button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary border"><i
                                            class="bi bi-person-plus"></i></button>
                                </div>
                            </div>
                            <div class="col-auto ps-0 align-self-center">
                                <div class="dropdown d-inline-block">
                                    <a class="dd-arrow-none" data-bs-toggle="dropdown" data-bs-auto-close="true"
                                        aria-expanded="false" role="button">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="javascript:void(0)">Add Contact</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)">Search</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)">Clear Chat</a></li>
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)">Report</a>
                                        </li>
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
                                <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i> 8:00
                                    pm
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
                                                    <button
                                                        class="avatar avatar-36 rounded-circle p-0 btn btn-info text-white shadow-sm m-2">
                                                        <i class="bi bi-download"></i>
                                                    </button>
                                                </div>
                                                <img src="<?= base_url() ?>assets/compas/main_theme/img/news-4.jpg"
                                                    alt="" class="mw-100">
                                            </div>
                                            Thank you too. You can buy it from preview page and click on buy now.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i> 8:00
                                    pm
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
                                                <video src="https://maxartkiller.com/website/maxartkiller.mp4"
                                                    controls="" preload="none"></video>
                                            </div>
                                            We also love this small presentation.
                                        </div>

                                    </div>
                                </div>
                                <div class="col-12">
                                    <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i>
                                        8:00
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
                                            <p>Ohh... Thats great. WinDOORS is HTML template can be used in various
                                                business domains like
                                                Manufacturing, inventory, IT, administration etc.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i> 8:00
                                    pm
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

    <!-- dropdown for support  -->
    <div class="chatboxes w-auto align-right bottom-0 mb-2">

        <!-- dropdown for support  -->
        <div class="dropup">
            <div class="dd-arrow-none dropdown-toggle" data-bs-display="static" data-bs-toggle="dropdown"
                data-bs-auto-close="outside" aria-expanded="false" id="supportdd" role="button">
                <span
                    class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle">
                    <span class="visually-hidden">New alerts</span>
                </span>
                <figure class="avatar avatar-40 coverimg rounded-circle shadow bg-primary">
                    <img src="<?= base_url() ?>assets/compas/main_theme/img/favicon72.png" alt="">
                </figure>
            </div>
            <div class="dropdown-menu dropdown-menu-end w-300 p-0">
                <!-- chat box here  -->
                <div class="card shadow-none border-0">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col align-self-center">
                                <p class="mb-0">WinDOORS Support</p>
                                <p class="text-secondary small">Just now</p>
                            </div>
                            <div class="col-auto">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-sm btn-outline-secondary border"><i
                                            class="bi bi-person-plus"></i></button>
                                </div>
                            </div>
                            <div class="col-auto ps-0 align-self-center">
                                <div class="dropdown d-inline-block">
                                    <a class="dd-arrow-none" data-bs-toggle="dropdown" data-bs-auto-close="true"
                                        aria-expanded="false" role="button">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="statuschat">
                                        <li><a class="dropdown-item" href="javascript:void(0)">Add Contact</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)">Search</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)">Clear Chat</a></li>
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)">Report</a>
                                        </li>
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
                                <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i> 8:00
                                    pm
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
                                                    <button
                                                        class="avatar avatar-36 rounded-circle p-0 btn btn-info text-white shadow-sm m-2">
                                                        <i class="bi bi-download"></i>
                                                    </button>
                                                </div>
                                                <img src="<?= base_url() ?>assets/compas/main_theme/img/news-4.jpg"
                                                    alt="" class="mw-100">
                                            </div>
                                            Thank you too. You can buy it from preview page and click on buy now.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i> 8:00
                                    pm
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
                                                <video src="https://maxartkiller.com/website/maxartkiller.mp4"
                                                    controls="" preload="none"></video>
                                            </div>
                                            We also love this small presentation.
                                        </div>

                                    </div>
                                </div>
                                <div class="col-12">
                                    <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i>
                                        8:00
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
                                            <p>Ohh... Thats great. WinDOORS is HTML template can be used in various
                                                business domains like
                                                Manufacturing, inventory, IT, administration etc.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <p class="text-secondary small time"><i class="bi bi-check-all text-primary"></i> 8:00
                                    pm
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


    <!-- Required jquery and libraries -->
    <script src="<?= base_url() ?>assets/compas/main_theme/js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url() ?>assets/compas/main_theme/js/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/compas/main_theme/vendor/bootstrap-5/dist/js/bootstrap.bundle.js"></script>

    <!-- Customized jquery file  -->
    <script src="<?= base_url() ?>assets/compas/main_theme/js/main.js"></script>
    <script src="<?= base_url() ?>assets/compas/main_theme/js/color-scheme.js"></script>

    <!-- PWA app service registration and works -->
    <script src="<?= base_url() ?>assets/compas/main_theme/js/pwa-services.js"></script>

    <!-- date range picker -->
    <script src="<?= base_url() ?>assets/compas/js/moment-with-locales.min.js"></script>
    <script src="<?= base_url() ?>assets/compas/main_theme/vendor/daterangepicker/daterangepicker.js"></script>

    <!-- chosen script -->
    <script src="<?= base_url() ?>assets/compas/main_theme/vendor/chosen_v1.8.7/chosen.jquery.min.js"></script>

    <!-- Chart js script -->
    <script src="<?= base_url() ?>assets/compas/main_theme/vendor/chart-js-3.3.1/chart.min.js"></script>

    <!-- Progress circle js script -->
    <script src="<?= base_url() ?>assets/compas/main_theme/vendor/progressbar-js/progressbar.min.js"></script>

    <!-- swiper js script -->
    <script src="<?= base_url() ?>assets/compas/main_theme/vendor/swiper-7.3.1/swiper-bundle.min.js"></script>

    <!-- Simple lightbox script -->
    <script
        src="<?= base_url() ?>assets/compas/main_theme/vendor/simplelightbox/simple-lightbox.jquery.min.js"></script>

    <!-- app tour script-->
    <script src="<?= base_url() ?>assets/compas/main_theme/vendor/Product-Tour-Plugin-jQuery/lib.js"></script>

    <!-- Footable table master script-->
    <script src="<?= base_url() ?>assets/compas/main_theme/vendor/fooTable/js/footable.min.js"></script>

    <!-- dragula script-->
    <script src="<?= base_url() ?>assets/compas/main_theme/vendor/dragula/dragula.js"></script>
    <script src="<?= base_url() ?>assets/compas/main_theme/vendor/dragula/example.js"></script>

    <!-- page level script here -->
    <script src="<?= base_url() ?>assets/compas/main_theme/js/header-title.js"></script>

    <link rel="stylesheet"
        href="<?= base_url(); ?>assets/compas/main_theme/vendor/datetimepicker/jquery.datetimepicker.min.css" />
    <script
        src="<?= base_url(); ?>assets/compas/main_theme/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
    <script src="<?= base_url(); ?>assets/compas/js/overtype.min.js"></script>
    <script src="<?= base_url(); ?>assets/compas/js/jquery.mask.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/showdown/dist/showdown.min.js"></script>
    <script src="<?= base_url() ?>assets/compas/main_theme/vendor/dropzone5-9-3/dropzone.min.js"></script>
    <script src="<?= base_url() ?>assets/compas/main_theme/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>assets/compas/main_theme/js/dataTables.rowReorder.min.js"></script>
    <script src="<?= base_url() ?>assets/compas/main_theme/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url() ?>assets/compas/main_theme/js/dataTables.bootstrap5.min.js"></script>
    <script src="<?= base_url() ?>assets/compas/main_theme/js/jszip.min.js"></script>
    <script src="<?= base_url() ?>assets/compas/main_theme/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url() ?>assets/compas/main_theme/js/buttons.html5.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.textcomplete/1.8.0/jquery.textcomplete.js"></script>
    <script src="<?= base_url('assets/compas/js/jquery-comments.js') ?>"></script>

    <?php //if (isset($js)): ?>
    <?php //$this->load->view($js); ?>
    <?php //endif; ?>

    <?php //if (isset($sub_js)): ?>
    <?php //$this->load->view($sub_js); ?>
    <?php //endif; ?>
</body>
<script>
    function transformArrayToObject(data, options = {}) {
        const {
            keyField = null,          // field yang dijadikan key (default: key pertama)
            exclude = [],             // field yang mau dibuang
            rename = {},              // rename field {old: new}
            parseKeyToNumber = false, // convert key jadi number
            nested = null             // nested transform { fieldName: keyField }
        } = options;

        return data.reduce((acc, item) => {
            const keys = Object.keys(item);
            const primaryKey = keyField || keys[0];

            let key = item[primaryKey];
            if (parseKeyToNumber) key = Number(key);

            let newItem = {};

            for (const k of keys) {
                if (k === primaryKey) continue;
                if (exclude.includes(k)) continue;

                const newKey = rename[k] || k;

                if (nested && nested[k] && Array.isArray(item[k])) {
                    newItem[newKey] = transformArrayToObject(item[k], {
                        keyField: nested[k]
                    });
                } else {
                    newItem[newKey] = item[k];
                }
            }

            acc[key] = newItem;
            return acc;
        }, {});
    }
    function transformObjectToArray(obj, keyName = "id") {
        return Object.entries(obj).map(([key, value]) => ({
            [keyName]: key,
            ...value
        }));
    }
</script>
<script>
    // Tab Management
    let tab;
    let tabSC;
    let prevTab;
    let megaphonePromoIcon = "<?= base_url('assets/images/megaphone_promo.png') ?>";
    let initCategory;
    let timeversion;
    const $activeMenu = document.getElementById('active_menu');
    const $activeTab = document.getElementById('active_tab');
    const $detailId = document.getElementById('detail_id');
    const BASE_URL = "<?= base_url() ?>";
    const KANBAN_STATUS = transformArrayToObject(<?= json_encode($kanban_status) ?>);
    const SUB_STATUS = transformArrayToObject(<?= json_encode($sub_status) ?>, { rename: { sub_status_name: 'name' } });

    // Helper for fade animation
    function fadeIn(element, duration = 250) {
        return new Promise(resolve => {
            element.style.opacity = 0;
            element.style.display = 'block';
            element.style.transition = `opacity ${duration}ms`;
            // Trigger reflow
            void element.offsetWidth;
            element.style.opacity = 1;
            setTimeout(resolve, duration);
        });
    }

    function loadDetails(id) {
        $detailId.value = id;
        switchMenu('Detail');
    }

    function switchMenu(tabName) {
        prevTab = tab;
        tab = tabName;
        tabSC = toSnakeCase(tabName);

        // Update tab buttons
        updateMenuButton(tabSC);

        // Update content
        loadTab('menus', tabSC);
    }

    function switchTab(tabName) {
        prevTab = tab;
        tab = tabName;

        // Update tab buttons
        tabSC = toSnakeCase(tabName);
        const buttons = document.querySelectorAll('.tab-btn');
        buttons.forEach(btn => {
            if (toSnakeCase(btn.dataset.value || '') === tabSC) {
                // Active state - varying based on theme, using Bootstrap utilities as fallback
                btn.classList.add('active');
                // You can add border/color classes here if needed to match the original design
                // btn.classList.add('border-primary', 'text-primary'); 
            } else {
                btn.classList.remove('active');
            }
        });

        // Update content
        return loadTab('tabs', tabSC);
    }

    function switchView(tabName) {
        prevTab = tab;
        tab = tabName;
        // console.log(tabName)
        // Update tab buttons
        tabSC = toSnakeCase(tabName);
        const buttons = document.querySelectorAll('.view-btn');
        buttons.forEach(btn => {
            if (toSnakeCase(btn.dataset.value || '') === tabSC) {
                // Active state - varying based on theme, using Bootstrap utilities as fallback
                btn.classList.add('active', 'text-primary', 'fw-bold');
                btn.classList.remove('text-secondary');
                // You can add border/color classes here if needed to match the original design
                // btn.classList.add('border-primary', 'text-primary'); 
            } else {
                btn.classList.remove('active', 'text-primary', 'fw-bold');
                btn.classList.add('text-secondary');
            }
        });

        // Update content
        loadTab('views', tabSC);
    }

    function updateMenuButton(tabName) {
        // console.log('1');

        const buttons = document.querySelectorAll('.menus-btn');
        if (tabName != 'detail') {
            buttons.forEach(btn => {
                if (toSnakeCase(btn.dataset.value || '') === tabName) {
                    // Active state - varying based on theme, using Bootstrap utilities as fallback
                    btn.classList.add('active');
                    // You can add border/color classes here if needed to match the original design
                    // btn.classList.add('border-primary', 'text-primary'); 
                } else {
                    btn.classList.remove('active');
                }
            });
        }
        // console.log(tabName);

    }

    function toSnakeCase(text) {
        if (!text) return '';
        // convert "&" to space // replace non-alphanumeric with underscore // trim leading/trailing underscores
        return text.toLowerCase().replace(/&/g, ' ').replace(/[^a-z0-9]+/g, '_').replace(/^_+|_+$/g, '');
    }

    function fromSnakeCase(snakeText) {
        if (!snakeText) return '';
        // replace underscores with spaces and capitalize each word
        return snakeText.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
    }

    // Initialize with Overview tab
    document.addEventListener('DOMContentLoaded', function () {
        let menuQuery = '<?= $menu ?>';
        let detailIdQuery = '<?= $detail_id ?>';
        tab = menuQuery || 'Campaign';
        tabSC = toSnakeCase(tab);
        if (detailIdQuery) {
            updateMenuButton(tabSC);
            updateBreadcrumb(tabSC);
            loadDetails(detailIdQuery);
            return;
        }
        switchMenu(tab);
    });
</script>
<script>
    function loadCss(href) {
        if (document.querySelector(`link[href="${href}"]`)) return;
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = href;
        document.head.appendChild(link);
    }

    function loadJs(src) {
        return new Promise((resolve, reject) => {
            if (document.querySelector(`script[src="${src}"]`)) return resolve();

            const s = document.createElement('script');
            s.src = src;
            s.onload = () => resolve();
            s.onerror = reject;
            document.body.appendChild(s);
        });
    }

    async function loadTab(group_tab, name, options = {}) {
        const {
            position = 'replace', // replace | append | prepend | before | after
            target = null         // optional selector or element
        } = options;

        let container;
        if (target) {
            container = (typeof target === 'string') ? document.querySelector(target) : target;
        } else {
            container = document.getElementById(`${group_tab}-content`);
            showLoader({ target: `#${group_tab}-content`, position: 'replace', overlay: false });
        }
        if (group_tab == 'menus') {
            $activeMenu.value = name;
            document.querySelectorAll('.sub_modal').forEach(el => el.remove());
            // Update Breadcrumb
            updateBreadcrumb(name);
            document.querySelectorAll(`script[src*="/assets/compas/js/views"]`).forEach(el => el.remove());
            document.querySelectorAll(`link[href*="/assets/compas/css/views"]`).forEach(el => el.remove());
            document.querySelectorAll(`script[src*="/assets/compas/js/tabs"]`).forEach(el => el.remove());
            document.querySelectorAll(`link[href*="/assets/compas/css/tabs"]`).forEach(el => el.remove());
        } else if (group_tab == 'tabs') {
            $activeTab.value = name;
        }
        // Loading indication can be added here

        try {
            // Ensure this route exists in your CodeIgniter controller
            const res = await fetch(`${BASE_URL}compas/load/${group_tab}/${name}`);
            if (!res.ok) throw new Error(`Failed to load tab: ${name}`);

            const data = await res.json();

            let prevTabSC = toSnakeCase(prevTab ?? '');

            // Remove previous Scripts/CSS
            // Note: This relies on naming conventions.
            let prevTabJS = `<?= base_url('assets/compas/js/') ?>${group_tab}/${prevTabSC}.js`;
            // Attempt to find and remove scripts that match the previous tab
            document.querySelectorAll(`script[src*="/assets/compas/js/${group_tab}"]`).forEach(el => el.remove());
            document.querySelectorAll(`link[href*="/assets/compas/css/${group_tab}"]`).forEach(el => el.remove());

            // load CSS
            (data.styles || []).forEach(href => {
                if (href.includes(`${name}.css`)) href += '?v=' + (timeversion || new Date().getTime());
                loadCss(href)
            });

            // Insert HTML
            const $container = $(container);
            switch (position) {
                case 'prepend':
                    $container.prepend(data.html);
                    break;
                case 'before':
                    $container.before(data.html);
                    break;
                case 'after':
                    $container.after(data.html);
                    break;
                case 'append':
                    $container.append(data.html);
                    break;
                case 'replace':
                default:
                    container.innerHTML = data.html;
                    break;
            }
            if (position === 'replace') {
                await fadeIn(container, 250);
            }
            if (data.modal) {
                document.body.insertAdjacentHTML('beforeend', data.modal);
                listModalId = [];
                document.querySelectorAll('.sub_modal').forEach(el => {
                    if (listModalId.includes(el.id)) {
                        el.remove();
                        return;
                    }
                    listModalId.push(el.id);
                });
            }

            // load JS
            for (let src of data.scripts || []) {
                timeversion = new Date().getTime();
                if (src.includes(`${name}.js`)) src += '?v=' + timeversion;
                await loadJs(src);
            }
            // Optional: call init function
            if (window.LoadInit && window.LoadInit[group_tab] && typeof window.LoadInit[group_tab][name] === 'function') {
                window.LoadInit[group_tab][name](container);
            }
        } catch (error) {
            console.error('Error loading tab:', error);
        }
    }
</script>
<script>
    function updateBreadcrumb(text) {
        const el = document.getElementById('active-breadcrumb');
        const menu = document.querySelector('.menus-btn.active');
        if (el) {
            const extra = document.getElementById('breadcrumb-extra');
            if (extra) {
                extra.remove();
                el.onclick = null;
                el.style.cursor = 'default';
                el.classList.remove('text-primary');
                el.classList.add('active');
            }

            if (text.toLowerCase() == 'detail') {
                el.classList.remove('active');
                el.onclick = () => switchMenu(el.textContent);
                el.style.cursor = 'pointer';
                el.classList.add('text-primary');

                const newLi = document.createElement('li');
                newLi.className = 'breadcrumb-item active';
                newLi.id = 'breadcrumb-extra';
                newLi.textContent = 'Detail';
                el.parentElement.appendChild(newLi);

                history.pushState(null, '', `?menu=${menu?.dataset.value}&detail_id=${$detailId.value || 1}`);
            } else {
                el.textContent = fromSnakeCase(text);
                history.pushState(null, '', `?menu=${menu?.dataset.value}`);
            }
        }
    }

    function ucfirst(str) {
        if (!str) return str; // Handle empty or null strings
        return str.charAt(0).toUpperCase() + str.slice(1);
    }
</script>
<script>
    function showLoader({
        text = 'Loading...',
        type = 'spinner',          // spinner | dots | border
        position = 'append',       // append | prepend | before | after
        target = 'body',           // where to insert
        overlay = true,            // overlay background
        shadow = false,             // shadow box
        id = 'global_loader'       // unique ID for closing later
    } = {}) {

        // Remove old loader with same ID if exists
        $('#' + id).remove();

        // Loader styles
        const loaderMap = {
            spinner: '<div class="spinner-border text-primary" role="status"></div>',
            border: '<div class="spinner-grow text-primary" role="status"></div>',
            dots: `
                <div class="loading-dots">
                    <span>.</span><span>.</span><span>.</span>
                </div>
            `
        };

        const loaderIcon = loaderMap[type] || loaderMap.spinner;

        const $loader = $(`
            <div id="${id}" class="custom-loader-overlay w-100 ${overlay ? 'with-overlay' : ''}" >
                <div class="custom-loader-box ${shadow ? 'shadow-sm' : ''} text-center ${overlay ? 'bg-white' : 'bg-transparent'}">
                    ${loaderIcon}
                    <div class="mt-2 fw-semibold">${text}</div>
                </div>
            </div>
        `);

        // Insert loader
        const $target = $(target);
        switch (position) {
            case 'prepend':
                $loader.prependTo($target);
                break;
            case 'before':
                $loader.insertBefore($target);
                break;
            case 'after':
                $loader.insertAfter($target);
                break;
            case 'replace':
                $target.html($loader);
                break;
            default:
                $loader.appendTo($target);
                break;
        }
    }

    function hideLoader(id = 'global_loader') {
        $('#' + id).fadeOut(300, function () {
            $(this).remove();
        });
    }

    const CURRENT_USER_ID = '<?= $this->session->userdata('user_id'); ?>';
    const CURRENT_USER_FULLNAME = "<?= $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') ?>";
    const CURRENT_USER_PROFILE_URL = "<?= $this->session->userdata('profile_picture') ? base_url('hr/uploads/profile/' . $this->session->userdata('profile_picture')) : base_url('hr/uploads/profile/anonim.jpg') ?>";
</script>

<script>
    $(document).ready(function () {
        // Search input
        $('#searchNotification').on('keyup', function () {
            loadActivityLogs();
        });

        // Add missing daterangepicker if needed or rely on existing init
        if ($('#notificationdaterange').length) {
            $('#notificationdaterange').on('change', function () {
                loadActivityLogs();
            });
        }

        loadActivityLogs();
    });

    function loadActivityLogs() {
        let date_range = $('#notificationdaterange').val();
        let search = $('#searchNotification').val();

        $('#activity-log-container').html('<div class="text-center p-3 text-muted"><div class="spinner-border text-primary" role="status"></div></div>');

        $.ajax({
            url: '<?= base_url('compas/main/get_global_activity_logs') ?>',
            method: 'POST',
            data: {
                search: search,
                date_range: date_range
            },
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    let html = '';
                    if (response.data.length > 0) {
                        response.data.forEach(function (log) {
                            let timeAgo = moment ? moment(log.created_at).fromNow() : log.created_at;
                            // Determine icon/color based on action_type
                            let icon = 'bi-bell';
                            let bgClass = 'bg-light-theme';
                            let textClass = 'text-dark';

                            let action = (log.action_type || '').toUpperCase();
                            if (action.includes('CREATED') || action.includes('ADD')) { icon = 'bi-plus-lg'; bgClass = 'bg-success text-white'; textClass = 'text-white'; }
                            else if (action.includes('UPDATED') || action.includes('EDIT')) { icon = 'bi-pencil'; bgClass = 'bg-warning text-white'; textClass = 'text-white'; }
                            else if (action.includes('DELETED') || action.includes('REMOVE')) { icon = 'bi-trash'; bgClass = 'bg-danger text-white'; textClass = 'text-white'; }

                            let userName = log.first_name ? log.first_name + ' ' + (log.last_name || '') : 'System';

                            html += `
                        <div class="card border-0 mb-2">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-40 rounded-circle ${bgClass} d-flex align-items-center justify-content-center">
                                            <i class="bi ${icon} ${textClass}"></i>
                                        </figure>
                                    </div>
                                    <div class="col ps-0">
                                        <p class="mb-0 fw-medium">${log.action_type}</p>
                                        <span class="text-secondary small fw-normal">${userName}</span>
                                        <p class="small text-muted mb-1">${log.description}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                             <p class="text-secondary small mb-0">${timeAgo}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                        });
                    } else {
                        html = '<div class="text-center p-3 text-muted">No activity logs found.</div>';
                    }
                    $('#activity-log-container').html(html);
                }
            },
            error: function () {
                $('#activity-log-container').html('<div class="text-center text-danger p-3">Failed to load logs.</div>');
            }
        });
    }
</script>


</html>