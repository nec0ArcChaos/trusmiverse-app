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
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.3.1/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">

    <!-- PNOTIFY -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/icon/icofont/css/icofont.css">
    <link rel="stylesheet" type="text/css"
        href="<?php echo base_url(); ?>assets/bower_components/pnotify/css/pnotify.css">
    <link rel="stylesheet" type="text/css"
        href="<?php echo base_url(); ?>assets/bower_components/pnotify/css/pnotify.brighttheme.css">
    <link rel="stylesheet" type="text/css"
        href="<?php echo base_url(); ?>assets/bower_components/pnotify/css/pnotify.buttons.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/pages/pnotify/notify.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/toogle-switch/toggle-switchy.css">
    <!-- PNOTIFY -->

    <!-- style css for this template -->
    <link href="<?= base_url(); ?>assets/scss/style.css" rel="stylesheet">

    <link href="<?= base_url(); ?>assets/scss/custom_button.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/scss/custom_input.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/nice-select2/css/nice-select2.css" />


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

        .swiperauto .swiper-wrapper {
            -webkit-transition-timing-function: linear !important;
            -o-transition-timing-function: linear !important;
            transition-timing-function: linear !important;
        }
    </style>

    <link rel="stylesheet" href="<?= base_url(); ?>assets/owl_carousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/owl_carousel/assets/owl.theme.default.min.css">
    <link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />



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


            .swiperauto .swiper-wrapper {
                width: 300px;
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

        .required:after {
            content: " *";
            color: red;
        }
    </style>
</head>

<body class="d-flex flex-column h-100 sidebar-pushcontent theme-blue" data-sidebarstyle="sidebar-pushcontent"
    data-theme="theme-blue">
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
        <img src="<?= base_url(); ?>assets/img/bg-21.jpg" alt="" />
    </div>
    <!-- background ends  -->

    <!-- Begin page content -->
    <main class="main h-100 container-fluid bg-blur">
        <!-- image swiper -->
        <div class="swiper image-swiper h-100 w-100 position-absolute z-index-0 start-0 top-0">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
                        <img src="<?= base_url(); ?>assets/img/bg-21.jpg" alt="" />
                    </div>
                </div>
            </div>
        </div>
        <!-- image swiper ends -->

        <div class="row h-100 z-index-1 position-relative">
            <div class="col-12 mb-auto">
                <!-- header -->
                <header class="header">
                    <!-- Fixed navbar -->
                    <nav class="navbar">
                        <div class="container-fluid">
                            <a class="navbar-brand" href="#">
                                <div class="row">
                                    <div class="col-auto"><img src="<?= base_url(); ?>assets/img/logo_trusmiverse.png"
                                            class="mx-100" alt="" /></div>
                                    <div class="col ps-0 align-self-center">
                                        <h5 class="fw-normal text-dark">Trusmiverse</h5>
                                        <!-- <p class="small text-secondary">F.R.C.K</p> -->
                                    </div>
                                </div>
                            </a>
                            <div>
                                <!-- <a href="#" class="btn btn-link text-secondary text-center"><i class="bi bi-person-circle me-0 me-lg-1"></i> <span class="d-none d-lg-inline-block">Help</span></a> -->
                            </div>
                        </div>
                    </nav>
                </header>
                <!-- header ends -->
            </div>
            <?php if ($karyawan['status'] != 3): ?>

                <div class="col-12  align-self-start pb-4 pt-1">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-11 col-lg-10 col-xl-7 col-xxl-6">
                            <div class="card bg-blur">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-auto align-self-center text-center">
                                            <h5 class="fw-normal">Formulir Dokumen Karyawan</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="smartwizard" class="mb-4 sw sw-theme-default sw-justified">
                                        <ul class="nav nav-fill">
                                            <li class="nav-item">
                                                <a class="nav-link inactive active" href="#step-0">
                                                    <div
                                                        class="avatar avatar-40 d-none d-md-inline-block rounded-circle mb-1">
                                                        <i class="bi bi-envelope-open-fill mb-1"></i>
                                                    </div>
                                                    <p class="d-none d-md-block">Welcome</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link inactive active" href="#step-1">
                                                    <div
                                                        class="avatar avatar-40 d-none d-md-inline-block rounded-circle mb-1">
                                                        <i class="bi bi-file-richtext-fill mb-1"></i>
                                                    </div>
                                                    <p class="d-none d-md-block">Dokumen Wajib</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link inactive active" href="#step-2">
                                                    <div
                                                        class="avatar avatar-40 d-none d-md-inline-block rounded-circle mb-1">
                                                        <i class="bi bi-file-richtext mb-1"></i>
                                                    </div>
                                                    <p class="d-none d-md-block">Dokumen Optional</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link inactive active" href="#step-3">
                                                    <div
                                                        class="avatar avatar-40 d-none d-md-inline-block rounded-circle mb-1">
                                                        <i class="bi bi-bookmark-check-fill mb-1"></i>
                                                    </div>
                                                    <p class="d-none d-md-block">Selesai</p>
                                                </a>
                                            </li>

                                        </ul>
                                        <div class="tab-content mb-4">
                                            <div id="step-0" class="tab-pane" role="tabpanel" style="display: block;">
                                                <div class="card border-0">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 text-center position-relative py-4">
                                                                <div class="swiper-container swiperauto mb-3 mb-lg-4">
                                                                    <div class="swiper-wrapper">
                                                                        <div class="swiper-slide pb-2">
                                                                            <div class="border-0">
                                                                                <div class="border-0 shadow-none">
                                                                                    <img src="<?= base_url(); ?>assets/img/Pembelajar.png"
                                                                                        alt="perusahaan holding company yang begerak di bidang Industri Batik, Pariwisata, Properti, Food and Beverage. Trusmi group maju bersama tim manajemen yang profesional, penuh semangat, mencintai budaya dan berjiwa muda."
                                                                                        class="rounded mw-200 lazy-load">
                                                                                </div>
                                                                                <div
                                                                                    class="text-start border-0 shadow-none">
                                                                                    <div class="row align-items-center">
                                                                                        <div class="col text-center">
                                                                                            <p>Semakin Tumbuh, Semakin
                                                                                                Berilmu Dan Sejahtera</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="swiper-slide pb-2">
                                                                            <div class="border-0">
                                                                                <div class="border-0 shadow-none">
                                                                                    <img src="<?= base_url(); ?>assets/img/Proaktif.png"
                                                                                        alt="perusahaan holding company yang begerak di bidang Industri Batik, Pariwisata, Properti, Food and Beverage. Trusmi group maju bersama tim manajemen yang profesional, penuh semangat, mencintai budaya dan berjiwa muda."
                                                                                        class="rounded mw-200 lazy-load">
                                                                                </div>
                                                                                <div
                                                                                    class="text-start border-0 shadow-none">
                                                                                    <div class="row align-items-center">
                                                                                        <div class="col text-center">
                                                                                            <p>Berani Berencana, Berani Aksi
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="swiper-slide pb-2">
                                                                            <div class="border-0">
                                                                                <div class="border-0 shadow-none">
                                                                                    <img src="<?= base_url(); ?>assets/img/Penebar-energi-positif.png"
                                                                                        alt="perusahaan holding company yang begerak di bidang Industri Batik, Pariwisata, Properti, Food and Beverage. Trusmi group maju bersama tim manajemen yang profesional, penuh semangat, mencintai budaya dan berjiwa muda."
                                                                                        class="rounded mw-200 lazy-load">
                                                                                </div>
                                                                                <div
                                                                                    class="text-start border-0 shadow-none">
                                                                                    <div class="row align-items-center">
                                                                                        <div class="col text-center">
                                                                                            <p>Ber-mindset Positif,
                                                                                                Berperilaku Positif</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 align-self-center py-4">
                                                                <p class="h4 fw-light mb-3">Saudara/i yang Terhormat,</p>
                                                                <p class="text-secondary small mb-4"
                                                                    style="text-align: justify;">
                                                                    &nbsp;&nbsp;&nbsp;
                                                                    Kepada Saudara/i karyawan yang baru bergabung,
                                                                    <b>Selamat Datang di Trusmi Group. </b>
                                                                    <br>
                                                                    Kami ingin mengajak Saudara/i untuk melengkapi
                                                                    dokumen-dokumen yang diperlukan untuk <b>memverifikasi
                                                                        data</b> pada inputan Form Registrasi Calon
                                                                    Karyawan.

                                                                    Proses ini tidak hanya membantu kami memperoleh
                                                                    informasi yang penting, tetapi juga menunjukkan komitmen
                                                                    Saudara/i terhadap standar perfesionalisme yang tinggi.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="step-1" class="tab-pane" role="tabpanel" style="display: none;">
                                                <div class="card border-0">
                                                    <div class="card-body">
                                                        <div class="mb-3 row">
                                                            <h4><u>Dokumen Wajib</u></h4>
                                                            <p>Mohon di upload dokumen dengan jelas dan benar.</p>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-6">
                                                                <label for="nama" class="form-label-custom">Nama
                                                                    Karyawan</label>
                                                                <input type="text" class="form-control border-custom"
                                                                    id="nama" value="<?= $karyawan['full_name'] ?>"
                                                                    accept="image/*" data-max-files="1" required readonly>
                                                                <input type="hidden" id="type_sales"
                                                                    value="<?= $karyawan['sales_type'] ?>">


                                                            </div>

                                                            <div class=" col-6">
                                                                <label for="departemen"
                                                                    class="form-label-custom">Designation</label>
                                                                <input type="text" class="form-control border-custom"
                                                                    id="departemen"
                                                                    value="<?= $karyawan['designation_name'] ?>"
                                                                    accept="image/*" data-max-files="1" required readonly>

                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <label for="ktp"
                                                                    class="form-label-custom required">KTP</label>
                                                                <?php if ($karyawan['ktp_status'] == null || $karyawan['ktp_status'] == 1): ?>

                                                                    <input type="file" class="form-control border-custom"
                                                                        id="ktp" accept="image/*" data-max-files="1" name="ktp"
                                                                        onchange="cek_file_image('ktp')">
                                                                <?php else: ?>
                                                                    <small class="text-primary" id="label_ktp">
                                                                        <li class="fa fa-check-circle"></li>
                                                                        <?= $karyawan['ktp'] ?>&nbsp;&nbsp;&nbsp;
                                                                    </small>

                                                                    <input type="file" class="form-control border-custom"
                                                                        id="ktp" accept="image/*" data-max-files="1" name="ktp"
                                                                        disabled>
                                                                <?php endif; ?>
                                                                <div class="valid-feedback">
                                                                </div>
                                                                <div class="invalid-feedback">
                                                                    Please provide a valid document.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class=" col-12">
                                                                <label for="kk" class="form-label-custom required">Kartu
                                                                    Keluarga</label>
                                                                <?php if ($karyawan['kk_status'] == null || $karyawan['kk_status'] == 1): ?>
                                                                    <input type="file" class="form-control border-custom"
                                                                        id="kk" accept="image/*" data-max-files="1" name="kk"
                                                                        onchange="cek_file_image('kk')">
                                                                <?php else: ?>
                                                                    <small class="text-primary" id="label_kk">
                                                                        <li class="fa fa-check-circle"></li>
                                                                        <?= $karyawan['kk'] ?>&nbsp;&nbsp;&nbsp;
                                                                    </small>

                                                                    <input type="file" class="form-control border-custom"
                                                                        id="kk" accept="image/*" data-max-files="1" name="kk"
                                                                        disabled>
                                                                <?php endif; ?>

                                                                <div class="valid-feedback">

                                                                </div>

                                                                <div class="invalid-feedback">
                                                                    Please provide a valid document.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class=" row mb-3">
                                                            <div class="col-12">
                                                                <label for="lamaran"
                                                                    class="form-label-custom  <?= ($karyawan['sales_type'] == 'Sales Freelance') ? '' : 'required' ?>">Surat
                                                                    Lamaran</label>
                                                                <?php if ($karyawan['lamaran_status'] == null || $karyawan['lamaran_status'] == 1): ?>
                                                                    <input type="file" class="form-control border-custom"
                                                                        id="lamaran" accept="image/*" data-max-files="1"
                                                                        name="lamaran" onchange="cek_file_image('lamaran')">
                                                                <?php else: ?>
                                                                    <small class="text-primary" id="label_lamaran">
                                                                        <li class="fa fa-check-circle"></li>
                                                                        <?= $karyawan['lamaran'] ?>&nbsp;&nbsp;&nbsp;
                                                                    </small>
                                                                    <input type="file" class="form-control border-custom"
                                                                        id="lamaran" accept="image/*" data-max-files="1"
                                                                        name="lamaran" disabled>
                                                                <?php endif; ?>
                                                                <div class="valid-feedback">

                                                                </div>
                                                                <div class="invalid-feedback">
                                                                    Please provide a valid document.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <label for="cv"
                                                                    class="form-label-custom <?= ($karyawan['sales_type'] == 'Sales Freelance') ? '' : 'required' ?>">CV</label>

                                                                <?php
                                                                // Cek apakah sudah ada CV di FDK
                                                                $has_cv_fdk = !empty($karyawan['cv']);
                                                                // Cek apakah ada CV di web karir
                                                                $has_cv_karir = !empty($profile->cv);
                                                                ?>

                                                                <?php if ($karyawan['cv_status'] == null || $karyawan['cv_status'] == 1): ?>

                                                                    <?php if (!$has_cv_fdk && $has_cv_karir): ?>
                                                                        <div class="mb-2">
                                                                            <small class="text-success" id="label_cv_karir">
                                                                                <i class="fa fa-check-circle"></i> CV ditemukan dari
                                                                                data Karir:
                                                                                <a href="https://karir.trusmigroup.com/storage/file/<?= $profile->cv ?>"
                                                                                    target="_blank">Lihat CV Karir</a>
                                                                            </small>
                                                                        </div>
                                                                        <input type="hidden" name="cv_existing_karir"
                                                                            value="https://karir.trusmigroup.com/storage/file/<?= $profile->cv ?>">
                                                                        <small class="text-muted">Abaikan form upload di bawah jika
                                                                            ingin menggunakan CV dari data Karir.</small>
                                                                    <?php endif; ?>

                                                                    <input type="file" class="form-control border-custom"
                                                                        id="cv" accept="image/*" data-max-files="1" name="cv"
                                                                        onchange="cek_file_image('cv')">

                                                                <?php else: ?>

                                                                    <small class="text-primary" id="label_cv">
                                                                        <i class="fa fa-check-circle"></i>
                                                                        <?= (strpos($karyawan['cv'], 'http') !== false) ? 'Tautan CV Karir' : $karyawan['cv'] ?>&nbsp;&nbsp;&nbsp;
                                                                    </small>
                                                                    <input type="file" class="form-control border-custom"
                                                                        id="cv" accept="image/*" data-max-files="1" name="cv"
                                                                        disabled>

                                                                <?php endif; ?>

                                                                <div class="valid-feedback"></div>
                                                                <div class="invalid-feedback">
                                                                    Please provide a valid document.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <label for="ijazah"
                                                                    class="form-label-custom <?= ($karyawan['sales_type'] == 'Sales Freelance') ? '' : 'required' ?>">Ijazah</label>
                                                                <?php if ($karyawan['ijazah_status'] == null || $karyawan['ijazah_status'] == 1): ?>
                                                                    <input type="file" class="form-control border-custom"
                                                                        id="ijazah" accept="image/*" data-max-files="1"
                                                                        name="ijazah" onchange="cek_file_image('ijazah')">
                                                                <?php else: ?>
                                                                    <small class="text-primary" id="label_ijazah">
                                                                        <li class="fa fa-check-circle"></li>
                                                                        <?= $karyawan['ijazah'] ?>&nbsp;&nbsp;&nbsp;
                                                                    </small>
                                                                    <input type="file" class="form-control border-custom"
                                                                        id="ijazah" accept="image/*" data-max-files="1"
                                                                        name="ijazah" disabled>
                                                                <?php endif; ?>
                                                                <div class="valid-feedback">

                                                                </div>
                                                                <div class="invalid-feedback">
                                                                    Please provide a valid document.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- hanya untuk sales -->
                                                        <?php if ($karyawan['designation_id'] == '731'): ?>
                                                            <div class="row mb-3">
                                                                <div class="col-12">
                                                                    <label for="kontak" class="form-label-custom required">
                                                                        Daftar Kontak
                                                                    </label>
                                                                    <!-- Icon popover untuk petunjuk -->
                                                                    <span class="small" tabindex="0" data-bs-toggle="popover"
                                                                        data-bs-trigger="hover"
                                                                        data-bs-content="Export kontak Anda dengan cara : buka Aplikasi <b>Kontak</b> HP anda <b>Setting > Export Kontak > Pilih ke Memori Internal</b> Anda. Setelah mengekspor, unggah file .vcf di sini.">
                                                                        <i class="fa fa-circle-info text-secondary"></i> Help
                                                                    </span>

                                                                    <?php if ($karyawan['contact'] == null): ?>
                                                                        <!-- Jika belum ada kontak yang diunggah -->
                                                                        <input type="file" class="form-control border-custom"
                                                                            id="kontak" accept=".vcf" data-max-files="1"
                                                                            name="kontak">
                                                                        <small>Hanya digunakan sebagai keperluan perusahaan dan
                                                                            tidak akan disalahgunakan.</small>

                                                                    <?php else: ?>
                                                                        <!-- Jika kontak sudah diunggah -->
                                                                        <small class="text-primary" id="label_kontak">
                                                                            <li class="fa fa-check-circle"></li>
                                                                        </small>
                                                                        <input type="file" class="form-control border-custom"
                                                                            id="kontak" accept=".vcf" data-max-files="1"
                                                                            name="kontak" disabled>
                                                                    <?php endif; ?>

                                                                    <div class="valid-feedback">
                                                                    </div>
                                                                    <div class="invalid-feedback">
                                                                        Please provide a valid document.
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        <?php endif; ?>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <small class="text-danger">* Wajib di isi (.jpg |
                                                                    .png)</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div id="step-2" class="tab-pane" role="tabpanel" style="display: none;">
                                                <div class="card-body">
                                                    <div class="mb-3 row">
                                                        <h4><u>Dokumen Optional</u></h4>
                                                        <p>Mohon di upload dokumen dengan jelas dan benar.</p>
                                                    </div>

                                                    <div class="mb-3 row">
                                                        <div class="col-12">
                                                            <label for="transkip" class="form-label-custom">Transkip
                                                                Nilai</label>
                                                            <?php if ($karyawan['transkip_status'] == null || $karyawan['transkip_status'] == 1): ?>
                                                                <input type="file" class="form-control border-custom"
                                                                    id="transkip" accept="image/*" data-max-files="1"
                                                                    name="transkip" onchange="cek_file_image('transkip')">
                                                            <?php else: ?>
                                                                <small class="text-primary" id="label_transkip">
                                                                    <li class="fa fa-check-circle"></li>
                                                                    <?= $karyawan['transkip'] ?>&nbsp;&nbsp;&nbsp;
                                                                    <!-- <a                                 href="javascript:void();" -->
                                                                    <!-- onclick="reset_file('ktp')">Ubah</a> -->
                                                                </small>
                                                                <input type="file" class="form-control border-custom"
                                                                    id="transkip" accept="image/*" data-max-files="1"
                                                                    name="transkip" disabled>
                                                            <?php endif; ?>

                                                            <small>isi dengan transkip nilai terakhir</small>
                                                            <div class="valid-feedback">

                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid document.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class=" col-12">
                                                            <label for="npwp" class="form-label-custom">NPWP</label>

                                                            <?php if ($karyawan['npwp_status'] == null || $karyawan['npwp_status'] == 1): ?>
                                                                <input type="file" class="form-control border-custom" id="npwp"
                                                                    accept="image/*" data-max-files="1" name="npwp"
                                                                    onchange="cek_file_image('npwp')">
                                                            <?php else: ?>
                                                                <small class="text-primary" id="label_npwp">
                                                                    <li class="fa fa-check-circle"></li>
                                                                    <?= $karyawan['npwp'] ?>&nbsp;&nbsp;&nbsp;
                                                                    <!-- <a                                 href="javascript:void();" -->
                                                                    <!-- onclick="reset_file('ktp')">Ubah</a> -->
                                                                </small>
                                                                <input type="file" class="form-control border-custom" id="npwp"
                                                                    accept="image/*" data-max-files="1" name="npwp" disabled>
                                                            <?php endif; ?>
                                                            <div class="valid-feedback">

                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid document.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-12">
                                                            <label for="surat_lulus" class="form-label-custom">Surat
                                                                Keterangan Lulus</label>
                                                            <?php if ($karyawan['surat_lulus_status'] == null || $karyawan['surat_lulus_status'] == 1): ?>
                                                                <input type="file" class="form-control border-custom"
                                                                    id="surat_lulus" accept="image/*" data-max-files="1"
                                                                    name="surat_lulus" onchange="cek_file_image('surat_lulus')">
                                                            <?php else: ?>
                                                                <small class="text-primary" id="label_surat_lulus">
                                                                    <li class="fa fa-check-circle"></li>
                                                                    <?= $karyawan['surat_lulus'] ?>&nbsp;&nbsp;&nbsp;
                                                                    <!-- <a                                 href="javascript:void();" -->
                                                                    <!-- onclick="reset_file('ktp')">Ubah</a> -->
                                                                </small>
                                                                <input type="file" class="form-control border-custom"
                                                                    id="surat_lulus" accept="image/*" data-max-files="1"
                                                                    name="surat_lulus" disabled>
                                                            <?php endif; ?>
                                                            <div class="valid-feedback">

                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid document.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class=" col-12">
                                                            <label for="Sertifikat"
                                                                class="form-label-custom">Sertifikat</label>
                                                            <?php if ($karyawan['sertifikat_status'] == null || $karyawan['sertifikat_status'] == 1): ?>
                                                                <input type="file" class="form-control border-custom"
                                                                    id="sertifikat" accept="image/*" data-max-files="1"
                                                                    name="sertifikat" onchange="cek_file_image('sertifikat')">
                                                            <?php else: ?>
                                                                <small class="text-primary" id="label_sertifikat">
                                                                    <li class="fa fa-check-circle"></li>
                                                                    <?= $karyawan['sertifikat'] ?>&nbsp;&nbsp;&nbsp;
                                                                    <!-- <a                                 href="javascript:void();" -->
                                                                    <!-- onclick="reset_file('ktp')">Ubah</a> -->
                                                                </small>
                                                                <input type="file" class="form-control border-custom"
                                                                    id="sertifikat" accept="image/*" data-max-files="1"
                                                                    name="sertifikat" disabled>
                                                            <?php endif; ?>
                                                            <div class="valid-feedback">

                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid document.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-12">
                                                            <label for="verklaring"
                                                                class="form-label-custom">Paklaring</label>
                                                            <?php if ($karyawan['verklaring_status'] == null || $karyawan['verklaring_status'] == 1): ?>
                                                                <input type="file" class="form-control border-custom"
                                                                    id="verklaring" accept="image/*" data-max-files="1"
                                                                    name="verklaring" onchange="cek_file_image('verklaring')">
                                                            <?php else: ?>
                                                                <small class="text-primary" id="label_verklaring">
                                                                    <li class="fa fa-check-circle"></li>
                                                                    <?= $karyawan['verklaring'] ?>&nbsp;&nbsp;&nbsp;
                                                                    <!-- <a                                 href="javascript:void();" -->
                                                                    <!-- onclick="reset_file('ktp')">Ubah</a> -->
                                                                </small>
                                                                <input type="file" class="form-control border-custom"
                                                                    id="verklaring" accept="image/*" data-max-files="1"
                                                                    name="verklaring" disabled>
                                                            <?php endif; ?>
                                                            <div class="valid-feedback">

                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid document.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <label for="dokumen_lain" class="form-label-custom">Dokumen
                                                                Pendukung Lainnya</label>
                                                            <?php if ($karyawan['dokumen_lain_status'] == null || $karyawan['dokumen_lain_status'] == 1): ?>
                                                                <input type="file" class="form-control border-custom"
                                                                    id="dokumen_lain" accept="image/*" data-max-files="1"
                                                                    name="dokumen_lain"
                                                                    onchange="cek_file_image('dokumen_lain')">
                                                            <?php else: ?>
                                                                <small class="text-primary" id="label_dokumen_lain">
                                                                    <li class="fa fa-check-circle"></li>
                                                                    <?= $karyawan['dokumen_lain'] ?>&nbsp;&nbsp;&nbsp;
                                                                    <!-- <a                                 href="javascript:void();" -->
                                                                    <!-- onclick="reset_file('ktp')">Ubah</a> -->
                                                                </small>
                                                                <input type="file" class="form-control border-custom"
                                                                    id="dokumen_lain" accept="image/*" data-max-files="1"
                                                                    name="dokumen_lain" disabled>
                                                            <?php endif; ?>
                                                            <div class="valid-feedback">

                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid document.
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                            <div id="step-3" class="tab-pane" role="tabpanel" style="display: none;">
                                                <div class="card border-0">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-center">
                                                            <div class="col-10 py-2">
                                                                <p><strong>Terimakasih</strong> atas partisipasi dan waktu
                                                                    yang sudah Saudara/i luangkan untuk mengisi Formulir
                                                                    Dokumen Karyawan. Hal tersebut menggambarkan komitmen
                                                                    dan minat Saudara/i untuk menjadi bagian dari tim kami.
                                                                </p>
                                                                <br>
                                                                <br>
                                                                <?php if ($karyawan['status'] == null || $karyawan['status'] == 1 || $karyawan['status'] == 2): ?>
                                                                    <div class="confirm">

                                                                        <div class="form-check" style="cursor: pointer;">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                value="" id="checkSyarat">
                                                                            <label class="form-check-label" for="checkSyarat">
                                                                                Dengan ini saya menyatakan bahwa data dan
                                                                                keterangan
                                                                                di atas
                                                                                adalah benar, dan saya bersedia
                                                                                mempertanggungjawabkan
                                                                                kebenaran data dan keterangan tersebut.
                                                                            </label>
                                                                        </div>
                                                                        <div class="d-flex justify-content-center mt-4">
                                                                            <button class="btn btn-block btn-success text-white"
                                                                                id="btn-submit-form" type="button"
                                                                                disabled>Submit
                                                                                Formulir</button>
                                                                        </div>
                                                                    </div>
                                                                <?php else: ?>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                </div>

                            </div>

                        </div>


                    </div>
                </div>
            <?php else: ?>
                <div class="col-12  align-self-start pb-4 pt-1">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-11 col-lg-10 col-xl-7 col-xxl-6">
                            <div class="card bg-blur">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-auto align-self-center text-center">
                                            <h5 class="fw-normal">Formulir Dokumen Karyawan</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="smartwizard" class="mb-4 sw sw-theme-default sw-justified">
                                        <ul class="nav nav-fill">
                                            <li class="nav-item">
                                                <a class="nav-link inactive active" href="#step-0">
                                                    <div
                                                        class="avatar avatar-40 d-none d-md-inline-block rounded-circle mb-1">
                                                        <i class="bi bi-envelope-open-fill mb-1"></i>
                                                    </div>
                                                    <p class="d-none d-md-block">Selesai</p>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content mb-4">
                                            <div id="step-0" class="tab-pane" role="tabpanel" style="display: none;">
                                                <div class="card border-0">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-center">
                                                            <div class="col-10 py-2">
                                                                <p><strong>Terimakasih</strong> atas partisipasi dan waktu
                                                                    yang sudah Saudara/i luangkan untuk mengisi Formulir
                                                                    Dokumen Karyawan. Hal tersebut menggambarkan komitmen
                                                                    dan minat Saudara/i untuk menjadi bagian dari tim kami.
                                                                </p>
                                                                <br>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
        </div>


        </div>

    </main>

    <?php $this->load->view('fdk/js_form'); ?>
</body>

</html>