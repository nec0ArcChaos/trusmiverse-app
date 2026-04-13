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

    <link href="<?= base_url(); ?>assets/scss/custom_button.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/scss/custom_input.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/nice-select2/css/nice-select2.css" />

    <link rel="stylesheet" href="<?= base_url(); ?>assets/filepond/filepond-plugin-image-preview.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/filepond/filepond.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/filepond/filepond-plugin-image-edit.css" />

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
        <img src="<?= base_url(); ?>assets/img/bg-5.jpg" alt="" />
    </div>
    <!-- background ends  -->

    <!-- Begin page content -->
    <main class="main h-100 container-fluid bg-blur">
        <!-- image swiper -->
        <div class="swiper image-swiper h-100 w-100 position-absolute z-index-0 start-0 top-0">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
                        <img src="<?= base_url(); ?>assets/img/bg-13.jpg" alt="" />
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
                        <img src="<?= base_url(); ?>assets/img/bg-2.jpg" alt="" class="w-100" />
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
                        <img src="<?= base_url(); ?>assets/img/bg-4.jpg" alt="" />
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
                            <a class="navbar-brand" href="<?= base_url(); ?>">
                                <div class="row">
                                    <div class="col-auto"><img src="<?= base_url(); ?>assets/img/logo_trusmiverse.png" class="mx-100" alt="" /></div>
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
            <div class="col-12  align-self-center py-4">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-11 col-lg-10 col-xl-7 col-xxl-6">
                        <div class="card bg-blur">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-auto align-self-center text-center">
                                        <h5 class="fw-normal">Detail Registrasi Calon Karyawan</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                <!-- content  -->
                                <div id="smartwizard" class="mb-4 sw sw-theme-default sw-justified">
                                    <ul class="nav nav-fill">
                                        <li class="nav-item">
                                            <a class="nav-link inactive active" href="#step-1">
                                                <div class="avatar avatar-40 d-none d-md-inline-block rounded-circle mb-1"><i class="bi bi-person mb-1"></i></div>
                                                <p class="d-none d-md-block">Identitas</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link inactive" href="#step-2">
                                                <div class="avatar avatar-40 d-none d-md-inline-block rounded-circle mb-1"><i class="bi bi-people mb-1"></i></div>
                                                <p class="d-none d-md-block">Keluarga</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link inactive" href="#step-3">
                                                <div class="avatar avatar-40 d-none d-md-inline-block rounded-circle mb-1"><i class="bi bi-mortarboard mb-1"></i></div>
                                                <p class="d-none d-md-block">Pendidikan</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link inactive" href="#step-4">
                                                <div class="avatar avatar-40 d-none d-md-inline-block rounded-circle mb-1"><i class="bi bi-signpost-split mb-1"></i></div>
                                                <p class="d-none d-md-block">Pengalaman</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link inactive" href="#step-5">
                                                <div class="avatar avatar-40 d-none d-md-inline-block rounded-circle mb-1"><i class="bi bi-window-stack mb-1"></i></div>
                                                <p class="d-none d-md-block">Lain-lain</p>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content mb-4">
                                        <div id="step-1" class="tab-pane" role="tabpanel" style="display: block;">
                                            <div class="card border-0">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="mb-3 col-12 col-md-6">
                                                            <label for="employee_name" class="form-label-custom required">Nama Lengkap</label>
                                                            <input disabled type="text" class="form-control border-custom" id="employee_name" value="<?= $ck['full_name'] ?? ''; ?>">
                                                            <div class="valid-feedback">

                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid data.
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label for="gender" class="form-label-custom required">Jenis Kelamin</label>
                                                            <select disabled id="nice-select-gender" class="wide mb-3">
                                                                <option value="Pria" <?= ($ck['gender'] == 'Pria') ? 'selected' : '' ?>>Pria</option>
                                                                <option value="Wanita" <?= ($ck['gender'] == 'Wanita') ? 'selected' : '' ?>>Wanita</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3 col-12 col-md-6">
                                                            <label for="no_ktp" class="form-label-custom required">No KTP</label>
                                                            <input disabled type="text" class="form-control border-custom only-nummber" id="no_ktp" value="<?= $ck['no_ktp']; ?>">
                                                            <div class="valid-feedback">

                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid data.
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 col-12 col-md-6">
                                                            <label for="no_kk" class="form-label-custom required">No KK</label>
                                                            <input disabled type="text" class="form-control border-custom only-nummber" id="no_kk" value="<?= $ck['no_kk']; ?>">
                                                            <div class="valid-feedback">

                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid data.
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 col-12 col-md-4">
                                                            <label for="no_npwp" class="form-label-custom">No NPWP</label>
                                                            <input disabled type="text" class="form-control border-custom only-nummber" id="no_npwp" value="<?= $ck['no_npwp']; ?>">
                                                            <div class="valid-feedback">

                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid data.
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 col-12 col-md-4">
                                                            <label for="tempat_lahir" class="form-label-custom required">Tempat Lahir</label>
                                                            <input disabled type="text" class="form-control border-custom" id="tempat_lahir" value="<?= $ck['tempat_lahir'] ?? ''; ?>">
                                                            <div class="valid-feedback">

                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid data.
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 col-12 col-md-4">
                                                            <label for="tgl_lahir" class="form-label-custom required">Tanggal Lahir</label>
                                                            <input disabled type="tel" pattern="\d*" class="form-control border-custom" id="tgl_lahir" placeholder="____-__-__" value="<?= $ck['tgl_lahir'] ?? ''; ?>">
                                                            <span class="badge text-dark small">Contoh : 2000-08-28</span>
                                                            <div class="valid-feedback">

                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid data.
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 col-12 col-md-6">
                                                            <label for="alamat_ktp" class="form-label-custom required">Alamat KTP</label>
                                                            <textarea disabled name="alamat_ktp" id="alamat_ktp" class="form-control border-custom" cols="30" rows="5"><?= $ck['alamat_ktp'] ?? ''; ?></textarea>
                                                            <div class="valid-feedback">

                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid data.
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 col-12 col-md-6">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <label for="alamat_saat_ini" class="form-label-custom required">Alamat Saat ini</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-check">
                                                                        <label class="form-check-label small" for="sama_dengan_ktp">
                                                                            Sama dengan KTP
                                                                        </label>
                                                                        <input disabled class="form-check-input" type="checkbox" id="sama_dengan_ktp">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <textarea disabled name="alamat_saat_ini" id="alamat_saat_ini" class="form-control border-custom" cols="30" rows="5"><?= $ck['alamat_saat_ini'] ?? ''; ?></textarea>
                                                        </div>
                                                        <div class="mb-3 col-12 col-md-6">
                                                            <label for="no_hp" class="form-label-custom required">Nomor Telepon/Handphone</label>
                                                            <input disabled type="text" class="form-control border-custom only-nummber" id="no_hp" value="<?= $ck['no_hp'] ?? ''; ?>">
                                                            <div class="valid-feedback">

                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid data.
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 col-12 col-md-6">
                                                            <label for="email" class="form-label-custom required">Email address</label>
                                                            <input disabled type="email" class="form-control border-custom" id="email" placeholder="name@example.com" value="<?= $ck['email'] ?? ''; ?>">
                                                            <div class="valid-feedback">

                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid data.
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-4">
                                                            <label for="agama" class="form-label-custom required">Agama</label>
                                                            <select disabled id="nice-select-agama" name="agama" class="wide mb-3">
                                                                <?php foreach ($agama as $agm) {  ?>
                                                                    <option value="<?= $agm->id_agama; ?>" <?= $agm->id_agama == $ck['id_agama'] ? 'selected' : ''; ?>><?= $agm->agama; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-md-4">
                                                            <label for="kewarganegaraan" class="form-label-custom required">Kewarganegaraan</label>
                                                            <select disabled id="nice-select-kewarganegaraan" class="wide mb-3">
                                                                <option value="WNI">Warga Negara Indonesia</option>
                                                                <option value="WNA">Warga Negara Asing</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-12 col-md-4">
                                                            <label for="status" class="form-label-custom required">Status</label>
                                                            <select disabled id="nice-select-status" name="status" id="status" class="wide mb-3">
                                                                <option value="Single" <?= "Single" == $ck['status_pernikahan'] ? 'selected' : ''; ?>>Lajang</option>
                                                                <option value="Married" <?= "Married" == $ck['status_pernikahan'] ? 'selected' : ''; ?>>Menikah</option>
                                                                <option value="Divorced or Separated" <?= "Divorced or Separated" == $ck['status_pernikahan'] ? 'selected' : ''; ?>>Cerai</option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3 col-12 col-md-4 kondisi-status-menikah">
                                                            <label for="tempat_status" class="form-label-custom" id="label_tempat_status">Tempat</label>
                                                            <input disabled type="text" class="form-control border-custom" id="tempat_status">
                                                            <div class="valid-feedback">

                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid data.
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 col-12 col-md-4 kondisi-status-menikah">
                                                            <label for="tgl_status" class="form-label-custom" id="label_tgl_status">Tgl</label>
                                                            <input disabled type="text" class="form-control border-custom" id="tgl_status">
                                                            <span class="badge text-dark small">Contoh : 2023-01-01</span>
                                                            <div class="valid-feedback">

                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid data.
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 col-12 col-md-4 kondisi-status-cerai">
                                                            <label for="tahun_status" class="form-label-custom" id="label_tahun_status">Tahun</label>
                                                            <input disabled type="text" class="form-control border-custom" id="tahun_status">
                                                            <div class="valid-feedback">

                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid data.
                                                            </div>
                                                        </div>


                                                        <div class="mb-3">
                                                            <label for="file" class="form-label-custom required">Pas Foto</label><br>
                                                            <img src="<?= base_url(); ?>uploads/fack/pas_foto/<?= $ck['pas_foto']; ?>" alt="" class="img-fluid" style="max-width:150px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="step-2" class="tab-pane" role="tabpanel" style="display: none;">
                                            <div class="card border-0">
                                                <div class="card-body">
                                                    <h4><u>Daftar Keluarga</u></h4>
                                                    <p>Mohon isi informasi keluarga Anda dengan lengkap.</p>
                                                    <div class="col-12 text-end">
                                                    </div>
                                                    <div class="col-12">
                                                        <table id="dt_daftar_keluarga" class="table table-striped" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10%;"></th>
                                                                    <th style="width: 30%;">Status</th>
                                                                    <th style="width: 50%;">Nama</th>
                                                                    <th style="width: 10%;"></th>
                                                                    <th>Jenis Kelamin</th>
                                                                    <th>Tempat, Tgl Lahir</th>
                                                                    <th>Pendidikan</th>
                                                                    <th>Pekerjaan</th>
                                                                    <th>Nomor Telepon/Hp</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="step-3" class="tab-pane" role="tabpanel" style="display: none;">
                                            <div class="card border-0">
                                                <div class="card-body">
                                                    <h4><u>Pendidikan</u></h4>
                                                    <p>Mohon isi informasi pendidikan Anda dengan lengkap.</p>
                                                    <div class="col-12 text-end">
                                                    </div>
                                                    <div class="col-12">
                                                        <table id="dt_daftar_pendidikan" class="table table-striped" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10%;"></th>
                                                                    <th style="width: 30%;">Pendidikan</th>
                                                                    <th style="width: 50%;">Nama Instansi</th>
                                                                    <th style="width: 10%;"></th>
                                                                    <th>Tempat</th>
                                                                    <th>Jurusan</th>
                                                                    <th>Status</th>
                                                                    <th>Nilai</th>
                                                                    <th>Thn. Masuk - Keluar</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="step-4" class="tab-pane" role="tabpanel" style="display: none;">
                                            <div class="card border-0">
                                                <div class="card-body">
                                                    <h4><u>Pengalaman Kerja</u></h4>
                                                    <p>Mohon isi informasi jika ada pengalaman kerja.</p>
                                                    <div class="col-12 text-end">
                                                    </div>
                                                    <div class="col-12">
                                                        <table id="dt_daftar_pengalaman_kerja" class="table table-striped" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10%;"></th>
                                                                    <th style="width: 40%;">Nama Perusahaan</th>
                                                                    <th style="width: 40%;">Posisi</th>
                                                                    <th style="width: 10%;"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                    <hr>
                                                    <h4><u>Pengalaman Organisasi</u></h4>
                                                    <p>Mohon isi informasi jika ada pengalaman berorganisasi.</p>
                                                    <div class="col-12 text-end">
                                                    </div>
                                                    <div class="col-12">
                                                        <table id="dt_daftar_pengalaman_organisasi" class="table table-striped" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10%;"></th>
                                                                    <th style="width: 40%;">Nama Organisasi</th>
                                                                    <th style="width: 40%;">Posisi</th>
                                                                    <th style="width: 10%;"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="step-5" class="tab-pane" role="tabpanel" style="display: none;">
                                            <div class="card border-0">
                                                <div class="card-body">
                                                    <h4><u>Penguasaan Bahasa Asing</u></h4>
                                                    <p>Mohon isi informasi jika ada bahasa asing yang Anda kuasai.</p>
                                                    <div class="col-12 text-end">
                                                    </div>
                                                    <div class="col-12">
                                                        <table id="dt_daftar_bahasa" class="table table-striped" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10%;"></th>
                                                                    <th style="width: 80%;">Bahasa</th>
                                                                    <th style="width: 10%;"></th>
                                                                    <th>Lisan</th>
                                                                    <th>Tulisan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                    <hr>
                                                    <h4><u>Kursus / Training</u></h4>
                                                    <p>Mohon isi informasi jika anda pernah mengikuti kursus atau training tertentu.</p>
                                                    <div class="col-12 text-end">
                                                    </div>
                                                    <div class="col-12">
                                                        <table id="dt_daftar_training" class="table table-striped" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10%;"></th>
                                                                    <th style="width: 80%;">Training/Kursus</th>
                                                                    <th style="width: 10%;"></th>
                                                                    <th>Penyelenggara</th>
                                                                    <th>Tempat</th>
                                                                    <th>Tahun</th>
                                                                    <th>Di Biayai Oleh</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                    <hr>
                                                    <h4><u>Pekerjaan yang diminati</u></h4>
                                                    <p>Mohon isi informasi jika ada pekerjaan tertentu yang paling anda minati.</p>
                                                    <div class="col-12 text-end">
                                                    </div>
                                                    <div class="col-12">
                                                        <table id="dt_daftar_pekerjaan_favorit" class="table table-striped" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10%;"></th>
                                                                    <th style="width: 80%;">Bidang/Posisi</th>
                                                                    <th style="width: 10%;"></th>
                                                                    <th>Gaji yang diharapkan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                    <hr>
                                                    <h4><u>Motivasi</u></h4>
                                                    <p class="required">Sebutkan Faktor yang mendorong anda untuk melamar pekerjaan di Trusmi Group!</p>
                                                    <div class="col-12 mb-3">
                                                        <textarea disabled name="motivasi" id="motivasi" cols="30" rows="4" class="form-control border-custom"><?= $ck['motivasi'] ?? ''; ?></textarea>
                                                    </div>
                                                    <hr>
                                                    <h4><u>Kesediaan</u></h4>
                                                    <p class="required">Kapan Anda dapat memulai pekerjaan baru ?</p>
                                                    <div class="col-12 mb-3">
                                                        <input disabled type="tel" pattern="\d*" name="kesediaan_1" class="form-control border-custom tgl tanggal" id="kesediaan_1" value="<?= $ck['kesediaan_1'] ?? ''; ?>">
                                                    </div>
                                                    <p class="required">Bersediakah Anda menitipkan Ijazah di perusahaan ini ?</p>
                                                    <div class="col-12 mb-3">
                                                        <textarea disabled name="kesediaan_2" id="kesediaan_2" cols="30" rows="4" class="form-control border-custom"><?= $ck['kesediaan_2'] ?? ''; ?></textarea>
                                                    </div>
                                                    <p class="required">Bersediakah membawa kendaraan pribadi/ motor untuk kepentingan pekerjaan ?(Mohon sertakan Nopol)</p>
                                                    <div class="col-12 mb-3">
                                                        <textarea disabled name="kesediaan_3" id="kesediaan_3" cols="30" rows="4" class="form-control border-custom"><?= $ck['kesediaan_3'] ?? ''; ?></textarea>
                                                    </div>
                                                    <p class="required">Bersediakah membawa laptop pribadi untuk kebutuhan pekerjaan ?</p>
                                                    <div class="col-12 mb-3">
                                                        <textarea disabled name="kesediaan_4" id="kesediaan_4" cols="30" rows="4" class="form-control border-custom"><?= $ck['kesediaan_4'] ?? ''; ?></textarea>
                                                    </div>
                                                    <p class="required">Bersediakah Anda ditempatkan di luar kota ?</p>
                                                    <div class="col-12 mb-3">
                                                        <textarea disabled name="kesediaan_5" id="kesediaan_5" cols="30" rows="4" class="form-control border-custom"><?= $ck['kesediaan_5'] ?? ''; ?></textarea>
                                                    </div>
                                                    <h4><u>HOBBY & KEGIATAN DI WAKTU LUANG</u></h4>
                                                    <p class="required">Sebutkan Hobby dan kegiatan apa yang anda lakukan di waktu luang!</p>
                                                    <div class="col-12 mb-3">
                                                        <textarea disabled name="hobi" id="hobi" cols="30" rows="4" class="form-control border-custom"><?= $ck['hobi'] ?? ''; ?></textarea>
                                                    </div>
                                                    <hr>
                                                    <h4><u>Referensi (Kecuali Keluarga)</u></h4>
                                                    <div class="col-12 text-end">
                                                    </div>
                                                    <div class="col-12">
                                                        <table id="dt_daftar_referensi" class="table table-striped" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10%;"></th>
                                                                    <th style="width: 80%;">Nama</th>
                                                                    <th style="width: 10%;"></th>
                                                                    <th>Jabatan & Perusahaan</th>
                                                                    <th>Hubungan dgn Anda</th>
                                                                    <th>No. Telp/Hp</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="toolbar toolbar-bottom" role="toolbar" style="text-align: right;">
                                        <button class="btn sw-btn-prev disabled" type="button">Previous</button>
                                        <button class="btn sw-btn-next" type="button">Next</button>
                                    </div>
                                </div>
                                <!-- content ends -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-12 mt-auto">
                <!-- footer -->
                <footer class="footer row">
                    <div class="col-12 col-md-12 col-lg py-2">
                        <span class="text-secondary small">Copyright @2022, Trusmi Group</span>
                    </div>
                    <div class="col-12 col-md-12 col-lg-auto align-self-center">
                        <p>Page Rendered in {elapsed_time} seconds, Memory Usage {memory_usage}.</p>
                    </div>
                </footer>
                <!-- footer ends -->
            </div>

        </div>

    </main>

    <?php $this->load->view('fack/detail_js'); ?>
</body>

</html>