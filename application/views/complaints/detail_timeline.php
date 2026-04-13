<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>Trusmiverse - Complaints</title>

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

    <?php $this->load->view('complaints/detail_timeline_css'); ?>

    <style>
        .dark-mode .form-control {
            border: 1px solid rgba(255, 255, 255, 0.15);
            background: #1b1c1d;
            color: rgba(255, 255, 255, 0.8);
        }

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

    <style>
        .emoji-rating-respons {
            cursor: pointer;
            transition: transform 0.2s ease-in-out, color 0.2s;
            display: inline-block;
            color: gray;
        }

        .emoji-rating-respons:hover,
        .emoji-rating-respons.active-icon {
            transform: scale(1.5);
        }

        .emoji-rating-respons[data-value="1"]:hover,
        .emoji-rating-respons[data-value="1"].active-icon {
            color: #f03d4f;
        }

        .emoji-rating-respons[data-value="2"]:hover,
        .emoji-rating-respons[data-value="2"].active-icon {
            color: #fd7e14;
        }

        .emoji-rating-respons[data-value="3"]:hover,
        .emoji-rating-respons[data-value="3"].active-icon {
            color: #ffe607;
        }

        .emoji-rating-respons[data-value="4"]:hover,
        .emoji-rating-respons[data-value="4"].active-icon {
            color: #015EC2;
        }

        .emoji-rating-respons[data-value="5"]:hover,
        .emoji-rating-respons[data-value="5"].active-icon {
            color: #2ecc71;
        }




        .emoji-rating-pelayanan {
            cursor: pointer;
            transition: transform 0.2s ease-in-out, color 0.2s;
            display: inline-block;
            color: gray;
        }

        .emoji-rating-pelayanan:hover,
        .emoji-rating-pelayanan.active-icon {
            transform: scale(1.5);
        }

        .emoji-rating-pelayanan[data-value="1"]:hover,
        .emoji-rating-pelayanan[data-value="1"].active-icon {
            color: #f03d4f;
        }

        .emoji-rating-pelayanan[data-value="2"]:hover,
        .emoji-rating-pelayanan[data-value="2"].active-icon {
            color: #fd7e14;
        }

        .emoji-rating-pelayanan[data-value="3"]:hover,
        .emoji-rating-pelayanan[data-value="3"].active-icon {
            color: #ffe607;
        }

        .emoji-rating-pelayanan[data-value="4"]:hover,
        .emoji-rating-pelayanan[data-value="4"].active-icon {
            color: #015EC2;
        }

        .emoji-rating-pelayanan[data-value="5"]:hover,
        .emoji-rating-pelayanan[data-value="5"].active-icon {
            color: #2ecc71;
        }



        .emoji-rating-kualitas {
            cursor: pointer;
            transition: transform 0.2s ease-in-out, color 0.2s;
            display: inline-block;
            color: gray;
        }

        .emoji-rating-kualitas:hover,
        .emoji-rating-kualitas.active-icon {
            transform: scale(1.5);
        }

        .emoji-rating-kualitas[data-value="1"]:hover,
        .emoji-rating-kualitas[data-value="1"].active-icon {
            color: #f03d4f;
        }

        .emoji-rating-kualitas[data-value="2"]:hover,
        .emoji-rating-kualitas[data-value="2"].active-icon {
            color: #fd7e14;
        }

        .emoji-rating-kualitas[data-value="3"]:hover,
        .emoji-rating-kualitas[data-value="3"].active-icon {
            color: #ffe607;
        }

        .emoji-rating-kualitas[data-value="4"]:hover,
        .emoji-rating-kualitas[data-value="4"].active-icon {
            color: #015EC2;
        }

        .emoji-rating-kualitas[data-value="5"]:hover,
        .emoji-rating-kualitas[data-value="5"].active-icon {
            color: #2ecc71;
        }


        .emoji-rating-rekomendasi {
            cursor: pointer;
            transition: transform 0.2s ease-in-out, color 0.2s;
            display: inline-block;
            color: gray;
        }

        .emoji-rating-rekomendasi:hover,
        .emoji-rating-rekomendasi.active-icon {
            transform: scale(1.5);
        }

        .emoji-rating-rekomendasi[data-value="1"]:hover,
        .emoji-rating-rekomendasi[data-value="1"].active-icon {
            color: #f03d4f;
        }

        .emoji-rating-rekomendasi[data-value="3"]:hover,
        .emoji-rating-rekomendasi[data-value="3"].active-icon {
            color: #015EC2;
        }

        .emoji-rating-rekomendasi[data-value="5"]:hover,
        .emoji-rating-rekomendasi[data-value="5"].active-icon {
            color: #2ecc71;
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
                <!-- <div class="spinner-border text-primary mt-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div> -->
                <span class="loader">Loading</span>
            </div>
        </div>
    </div>
    <!-- page loader ends -->

    <!-- background -->
    <div class="coverimg h-100 w-100 top-0 start-0">
        <img src="<?= base_url() ?>assets/img/bg-13.jpg" alt="" />
    </div>
    <!-- background ends  -->


    <!-- Begin page content -->
    <main class="main h-100 container-fluid bg-blur rounded-0" style="height:max-content!important;">
        <div class="container">
            <div class="row h-100">
                <input type="hidden" id="detail_id_task" value="<?= $id_task; ?>">
                <!-- left block-->
                <div class="col-12 col-md-12 h-100 overflow-y-auto">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <!-- header -->
                            <header class="header">
                                <!-- Fixed navbar -->
                                <nav class="navbar">
                                    <div class="container-fluid">
                                        <a class="navbar-brand" href="#">
                                            <div class="row">
                                                <div class="col-auto"><img src="https://trusmiverse.com/apps/assets/img/rumah_ningrat/logo_rn_no_bg.png" class="mx-100 logo-mobile" alt=""></div>
                                                <div class="col ps-0 align-self-center d-none d-sm-block">
                                                    <h5 class="fw-normal text-dark mb-0"></h5>
                                                </div>
                                            </div>
                                        </a>
                                        <div></div>
                                    </div>
                                </nav>
                            </header>
                            <!-- header ends -->
                        </div>
                        <div class="col-12 col-md-12 col-lg-9 col-xl-9 mb-4">
                            <h5 class="title"><span id="timer"></span></h5>
                            <div class="card border-0">
                                <div class="card-body">
                                    <h5 class="text-center fw-medium mb-0" id="e_task_text">-</h5>
                                    <p class="text-center text-secondary small" id="e_object_text">-</p>
                                    <h6 class="mt-4 mb-0">Di Input Oleh :</h6>
                                    <p>- <span id="e_requested_by_text"></span></p>
                                    <div class="row">
                                        <div class="col-auto ms-2 me-0 pe-0">
                                            <span class="small badge bg-light-purple text-dark" id="e_requested_company_text">-</span>
                                        </div>
                                        <div class="col-auto me-0 pe-0">
                                            <span class="small badge bg-light-yellow text-dark" id="e_requested_department_text">-</span>
                                        </div>
                                        <div class="col-auto me-0 pe-0">
                                            <span class="small badge bg-light-red text-dark" id="e_requested_designation_text">-</span>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <h6 class="mt-4 mb-1">Status Keluhan :</h6>
                                            <span id="e_status_text" class="badge"></span>
                                            <div id="div_e_progress_text" class="mt-2 col-4"></div>
                                            <h6 class="mt-4 mb-0">Tgl Aftersales :</h6>
                                            <p id="e_tgl_aftersales" class="small">-</p>
                                            <h6 class="mt-4 mb-0">Tgl Keluhan :</h6>
                                            <p id="e_requested_at_text" class="small">-</p>
                                            <h6 class="mt-4 mb-0">Project Site :</h6>
                                            <p class="mb-0">- <span class="small" id="e_project_text">-</span> <span class="small" id="e_blok_text">-</span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="mt-4 mb-1">Tgl Serah Terima Kunci :</h6>
                                            <span id="e_tgl_kunci_text" class="badge"></span>
                                            <h6 class="mt-4 mb-0">Tgl KWH Listrik :</h6>
                                            <p id="e_tgl_kwh_text" class="small">-</p>
                                            <h6 class="mt-4 mb-0">Tgl QC :</h6>
                                            <p id="e_tgl_selesai_qc_text" class="small">-</p>
                                            <h6 class="mt-4 mb-0">Umur Bangunan :</h6>
                                            <p id="e_umur_bangunan_text" class="small">-</p>
                                            <h6 class="mt-4 mb-0">Vendor :</h6>
                                            <p id="e_nama_vendor_text" class="small">-</p>
                                        </div>
                                    </div>
                                    <h6 class="mt-4 mb-0">Deskripsi Keluhan :</h6>
                                    <p style="text-align: justify;" class="mt-2"><span id="e_description_text" class="small">-</span></p>
                                    <div class="row mt-4" id="body_files_page">

                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-none mb-5" id="div_done_rating">
                                <h5 class="mt-2 title">Feedback / Rating</h5>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="col-12 col-lg-6 text-start">
                                                <p>Kualitas Layanan : <span class="float-end" id="e_rating_kualitas_text"></span></p>
                                                <p>Respon Tim : <span class="float-end" id="e_rating_respon_text"></span></p>
                                                <p>Rekomendasi : <span class="float-end" id="e_rating_rekomendasi_text"></span></p>
                                                <p>Avg Rating : <span class="float-end" id="e_rating_avg_rating_text"></span></p>
                                                <br>
                                                <p>Feedback : <span id="e_rating_feedback_text"></span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="col text-center">
                                                    <h1>Terima Kasih</h1>
                                                    <i class="fa fa-check main-content__checkmark" id="checkmark" style="font-size: 4.0625rem;line-height: 1;color: #24b663;"></i>
                                                    <div class="d-flex justify-content-center">
                                                        <p style="word-break: break-word; max-width: 300px;text-align: justify;" class="mt-2">Terima kasih atas feedback dan rating Anda! Masukan Anda sangat berharga bagi kami untuk terus meningkatkan layanan. 😊🙏</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="div_form_rating" class="d-none">
                                <h5 class="mt-2 title">Silahkan Nilai Pelayanan Kami Setelah Penyelesaian Keluhan Anda</h5>
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6 col-xl-6 mb-4">
                                        <div class="card border-0">
                                            <div class="card-header text-center">
                                                <h6>Seberapa puas Anda dengan respons kami terhadap keluhan Anda?</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row mb-3 align-items-center justify-content-center text-secondary">
                                                    <div class="col-auto">
                                                        <i class="bi bi-emoji-angry emoji-rating-respons h2" data-value="1"></i>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="bi bi-emoji-frown emoji-rating-respons h2" data-value="2"></i>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="bi bi-emoji-neutral emoji-rating-respons h2" data-value="3"></i>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="bi bi-emoji-smile emoji-rating-respons h2" data-value="4"></i>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="bi bi-emoji-heart-eyes emoji-rating-respons h2" data-value="5"></i>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <p class="text-secondary">Tidak Puas</p>
                                                    </div>
                                                    <div class="col-auto ms-auto">
                                                        <p class="text-secondary">Sangat Puas</p>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="selected-rating-respons" name="rating" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-12 col-md-6 col-lg-6 col-xl-6 mb-4">
                                        <div class="card border-0">
                                            <div class="card-header text-center">
                                                <h6>Seberapa puas Anda dengan pelayanan kami terhadap keluhan Anda?</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row mb-3 align-items-center justify-content-center text-secondary">
                                                    <div class="col-auto">
                                                        <i class="bi bi-emoji-angry emoji-rating-pelayanan h2" data-value="1"></i>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="bi bi-emoji-frown emoji-rating-pelayanan h2" data-value="2"></i>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="bi bi-emoji-neutral emoji-rating-pelayanan h2" data-value="3"></i>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="bi bi-emoji-smile emoji-rating-pelayanan h2" data-value="4"></i>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="bi bi-emoji-heart-eyes emoji-rating-pelayanan h2" data-value="5"></i>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <p class="text-secondary">Tidak Puas</p>
                                                    </div>
                                                    <div class="col-auto ms-auto">
                                                        <p class="text-secondary">Sangat Puas</p>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="selected-rating-pelayanan" name="selected-rating-pelayanan" value="">
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="col-12 col-md-6 col-lg-6 col-xl-6 mb-4">
                                        <div class="card border-0">
                                            <div class="card-header text-center">
                                                <h6>Seberapa puas Anda dengan Kualitas pelayanan kami terhadap keluhan Anda?</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row mb-3 align-items-center justify-content-center text-secondary">
                                                    <div class="col-auto">
                                                        <i class="bi bi-emoji-angry h2 emoji-rating emoji-rating-kualitas" data-value="1"></i>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="bi bi-emoji-frown h2 emoji-rating emoji-rating-kualitas" data-value="2"></i>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="bi bi-emoji-neutral h2 emoji-rating emoji-rating-kualitas" data-value="3"></i>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="bi bi-emoji-smile h2 emoji-rating emoji-rating-kualitas" data-value="4"></i>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="bi bi-emoji-heart-eyes h2 emoji-rating emoji-rating-kualitas" data-value="5"></i>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <p class="text-secondary">Tidak Puas</p>
                                                    </div>
                                                    <div class="col-auto ms-auto">
                                                        <p class="text-secondary">Sangat Puas</p>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="selected-rating-kualitas" name="selected-rating-kualitas" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 col-xl-6 mb-4">
                                        <div class="card border-0">
                                            <div class="card-header text-center">
                                                <h6>Bagaimana pengalaman Anda dengan Produk Kami, Apakah akan merekomendasikan ini kepada orang lain?</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row align-items-center justify-content-center text-center text-secondary">
                                                    <div class="col">
                                                        <i class="bi bi-hand-thumbs-down h2 mb-3 d-inline-block emoji-rating-rekomendasi" data-value="1"></i>
                                                        <p class="text-secondary small">Tidak</p>
                                                    </div>
                                                    <div class="col">
                                                        <i class="bi bi-clock h2 mb-3 d-inline-block emoji-rating-rekomendasi" data-value="3"></i>
                                                        <p class="text-secondary small">Mungkin</p>
                                                    </div>
                                                    <div class="col">
                                                        <i class="bi bi-hand-thumbs-up h2 mb-3 d-inline-block emoji-rating-rekomendasi" data-value="5"></i>
                                                        <p class="small">Ya, Tentu</p>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="selected-rating-rekomendasi" name="selected-rating-rekomendasi" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 mb-2">
                                        <div class="card border-0">
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="feedback" class="form-label">Kritik & Saran</label>
                                                    <textarea class="form-control" id="feedback" name="feedback" rows="3"></textarea>
                                                </div>
                                                <div class="mb-3 text-end">
                                                    <button class="btn btn-theme" type="button" id="btn-send-feedback"><i class="bi bi-send"></i> Kirim Feedback</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Right Side -->
                        <div class="col-12 col-md-12 col-lg-3 ms-auto">
                            <h5 class="title">Timeline</h5>
                            <ul class="timeline-windoors left-only" id="body_timeline_history">
                                <li class="theme-blue left-timeline">
                                    <div class="card border-0 mb-4 mb-lg-5">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-40 bg-light-theme text-theme rounded-circle">
                                                        <i class="bi bi-clock h4"></i>
                                                    </div>
                                                </div>
                                                <div class="col ps-0 ms-0">
                                                    <p class="text-theme mb-0">Tgl Input</p>
                                                    <p class="mb-0 small">15 Feb 25 | 17:38 WIB</p>
                                                    <hr class="m-1">
                                                    <p class="mb-0 small">Rustaman</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="theme-blue left-timeline">
                                    <div class="card border-0 mb-4 mb-lg-5">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-40 bg-light-theme text-theme rounded-circle">
                                                        <i class="bi bi-clock h4"></i>
                                                    </div>
                                                </div>
                                                <div class="col ps-0 ms-0">
                                                    <p class="text-theme mb-0">Verifikasi</p>
                                                    <h6 id="e_verified_at_text" class="small">-</h6>
                                                    <hr class="m-1">
                                                    <h6 id="e_verified_by_text" class="small" style="margin-bottom: 3px;">-</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
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
    <?php $this->load->view('complaints/detail_timeline_js'); ?>

</body>

</html>