<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>Trusmiverse - Review and Rating Form</title>

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

    <!-- Star Style -->
    <style>
        /* Star */
        /* Rating Star Widgets Style */
        .rating-stars ul {
            list-style-type: none;
            padding: 0;

            -moz-user-select: none;
            -webkit-user-select: none;
        }

        .rating-stars ul>li.star {
            display: inline-block;

        }

        /* Idle State of the stars */
        .rating-stars ul>li.star>i.fa {
            font-size: 1em;
            /* Change the size of the stars */
            color: #ccc;
            /* Color on idle state */
        }

        /* Hover state of the stars */
        .rating-stars ul>li.star.hover>i.fa {
            color: #FFCC36;
        }

        /* Selected state of the stars */
        .rating-stars ul>li.star.selected>i.fa {
            color: #FF912C;
        }
        /* End Star */
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
    <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
        <img src="<?= base_url() ?>assets/img/bg-13.jpg" alt="" />
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
                                            <div class="col-auto"><img src="https://trusmiverse.com/apps/assets/img/logo_trusmiverse.png" class="mx-100 logo-mobile" alt=""></div>
                                            <div class="col ps-0 align-self-center d-none d-sm-block">
                                                <h5 class="fw-normal text-dark mb-0">Trusmiverse</h5>
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
                            <div class="col-12 col-md-2 col-lg-2 col-xl-2 col-xxl-2"></div>
                            <div class="col-12 col-md-8 col-lg-8 col-xl-8 col-xxl-8 mt-2">
                                <!-- <hr> -->
                                <div class="row" style="display:none" id="spinner_loading">
                                    <div class="col text-center center-spinner">
                                        <div class="spinner-border text-primary mt-3" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Main Page Detail -->
                                <div class="card border-0 mb-4">
                                    <div class="card-header">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <i class="comingsoonbi bi-stars h5 avatar avatar-40 bg-light-orange text-orange text-orange rounded "></i>
                                            </div>
                                            <div class="col text-start">
                                                <h6 class="fw-medium mb-0">Review and Rating</h6>
                                                <p class="text-secondary small" id="category">Ticket Development</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6 text-start mb-3">
                                                <p class="text-secondary small mb-1">User</p>
                                                <h6 id="usere" class="small">-</h6>
                                                <span class="badge bg-light-purple text-dark" id="company" class="small">-</span>
                                                <span class="badge bg-light-yellow text-dark" id="department" class="small">-</span>
                                                <span class="badge bg-light-red text-dark" id="designation" class="small">-</span>
                                            </div>
                                            <div class="col-6 mb-3 text-start">
                                                <p class="text-secondary small mb-1">Note UAT</p>
                                                <h6 id="note_uat" class="small">-</h6>
                                            </div>
                                            <div class="col-6 col-md-3 mb-3 text-start">
                                                <p class="text-secondary small mb-1">Status UAT</p>
                                                <h6 id="status_uat" class="small"></h6>
                                            </div>
                                            <div class="col-6 col-md-3 mb-3 text-start">
                                                <p class="text-secondary small mb-1">Date of UAT</p>
                                                <h6 id="tgl_uat" class="small badge bg-light-green text-dark"></h6>
                                            </div>
                                            <div class="col-6 col-md-3 text-start mb-3">
                                                <p class="text-secondary small mb-1">Lampiran</p>
                                                <div id="lampiran_uat">a</div>
                                            </div>
                                            <div class="col-6 col-md-3 text-start mb-3">
                                                <p class="text-secondary small mb-1">Status</p>
                                                <span id="status" class="badge bg-warning text-white">Waiting</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer" id="footer-update">
                                        <form id="form_feedback">
                                        <input type="hidden" name="id_task" id="id_task" readonly>
                                        <div class="row g-3 mb-3 text-start">
                                            <div class="col-3">
                                                <label class="form-label-custom small" for="ekspektasi"><i class="text-theme bi bi-bar-chart-steps"></i> Sudah sesuai ekspektasi?</label>
                                            </div>
                                            <div class="col-9">
                                                <div class="form-check form-check-inline small">
                                                    <input class="form-check-input" type="radio" name="ekspektasi" id="ekspektasi_1" value="Sudah">
                                                    <label class="form-check-label text-secondary" for="ekspektasi_1">Sudah</label>
                                                </div>
                                                <div class="form-check form-check-inline small">
                                                    <input class="form-check-input" type="radio" name="ekspektasi" id="ekspektasi_2" value="Belum">
                                                    <label class="form-check-label text-secondary" for="ekspektasi_2">Belum</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-3 mb-3 text-start">
                                            <div class="col-3">
                                                <label class="form-label-custom small" for="rating_kesesuaian"><i class="text-theme bi bi-clipboard-check-fill"></i> Kesesuaian Data</label>
                                            </div>
                                            <div class="col-9">                                                
                                                <div class='rating-stars text-right'>
                                                    <ul id='stars'>
                                                        <li class='star selected' title='Poor' data-value='1'>
                                                            <i class='fa fa-star fa-fw'></i>
                                                        </li>
                                                        <li class='star selected' title='Fair' data-value='2'>
                                                            <i class='fa fa-star fa-fw'></i>
                                                        </li>
                                                        <li class='star selected' title='Good' data-value='3'>
                                                            <i class='fa fa-star fa-fw'></i>
                                                        </li>
                                                        <li class='star selected' title='Excellent' data-value='4'>
                                                            <i class='fa fa-star fa-fw'></i>
                                                        </li>
                                                        <li class='star selected' title='WOW!!!' data-value='5'>
                                                            <i class='fa fa-star fa-fw'></i>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <input type="hidden" class="form-control" value="5" id="rating_kesesuaian" name="rating_kesesuaian">
                                            </div>
                                        </div>
                                        <div class="row g-3 mb-3 text-start">
                                            <div class="col-3">
                                                <label class="form-label-custom small" for="rating_uiux"><i class="text-theme bi bi-window"></i> UI/UX</label>
                                            </div>
                                            <div class="col-9">                                               
                                                <div class='rating-stars text-right'>
                                                    <ul id='stars_uiux'>
                                                        <li class='star selected' title='Poor' data-value='1'>
                                                            <i class='fa fa-star fa-fw'></i>
                                                        </li>
                                                        <li class='star selected' title='Fair' data-value='2'>
                                                            <i class='fa fa-star fa-fw'></i>
                                                        </li>
                                                        <li class='star selected' title='Good' data-value='3'>
                                                            <i class='fa fa-star fa-fw'></i>
                                                        </li>
                                                        <li class='star selected' title='Excellent' data-value='4'>
                                                            <i class='fa fa-star fa-fw'></i>
                                                        </li>
                                                        <li class='star selected' title='WOW!!!' data-value='5'>
                                                            <i class='fa fa-star fa-fw'></i>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <input type="hidden" class="form-control" value="5" id="rating_uiux" name="rating_uiux">
                                            </div>
                                        </div>
                                        <div class="row g-3 mb-3 text-start">
                                            <div class="col-3">
                                                <label class="form-label-custom small" for="saran"><i class="text-theme bi bi-text-left"></i> Saran</label>
                                            </div>
                                            <div class="col-9">
                                                <textarea name="saran" style="font-size: 10pt !important;" id="saran" class="form-control change_disabled" style="height: 100px;" placeholder="..."></textarea>
                                            </div>
                                        </div>
                                        <div class="row g-3 mb-3 text-start">
                                            <div class="col-3">
                                                <label class="form-label-custom small" for="kelengkapan_fitur"><i class="text-theme bi bi-card-checklist"></i> Kelengkapan Fitur</label>
                                            </div>
                                            <div class="col-9">
                                                <textarea name="kelengkapan_fitur" style="font-size: 10pt !important;" id="kelengkapan_fitur" class="form-control change_disabled" style="height: 100px;" placeholder="..."></textarea>
                                            </div>
                                        </div>
                                        <div class="row g-3 mb-3 text-start">
                                            <div class="col-3">
                                                <label class="form-label-custom small" for="kecepatan_akses"><i class="text-theme bi bi-fast-forward"></i> Kecepatan Akses</label>
                                            </div>
                                            <div class="col-9">
                                                <div class="form-check form-check-inline small">
                                                    <input class="form-check-input" type="radio" name="kecepatan_akses" id="kecepatan_akses_1" value="Cepat">
                                                    <label class="form-check-label text-secondary" for="kecepatan_akses_1">Cepat</label>
                                                </div>
                                                <div class="form-check form-check-inline small">
                                                    <input class="form-check-input" type="radio" name="kecepatan_akses" id="kecepatan_akses_2" value="Sedang">
                                                    <label class="form-check-label text-secondary" for="kecepatan_akses_2">Sedang</label>
                                                </div>
                                                <div class="form-check form-check-inline small">
                                                    <input class="form-check-input" type="radio" name="kecepatan_akses" id="kecepatan_akses_3" value="Lambat">
                                                    <label class="form-check-label text-secondary" for="kecepatan_akses_3">Lambat</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-3 mb-3 text-start">
                                            <div class="col-3">
                                                <label class="form-label-custom small" for="impact"><i class="text-theme bi bi-list-stars"></i> Impact</label>
                                            </div>
                                            <div class="col-9">
                                                <select name="impact" multiple style="font-size: 10pt !important;" id="impact" class="change_disabled" onchange="change_status()">
                                                    <option data-placeholder="true">-Choose Impact-</option>
                                                    <?php foreach ($impact as $row) : ?>
                                                        <option value="<?= $row->id; ?>"><?= $row->impact; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <input type="hidden" id="list_impact" name="list_impact">
                                            </div>
                                        </div>
                                        
                                        </form>
                                        <div class="row gx-2">
                                            <div class="col text-end">
                                                <a class="btn btn-theme btn-md" role="button" id="btn_save_feedback" onclick="save_feedback()">Save</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="position-fixed right-0 bottom-0 end-0 p-3" style="z-index: 99999999">
                                    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
                                        <div class="toast-header">
                                            <i class="bi bi-check-circle-fill text-success" id="upload_check" style="display:none"></i>
                                            <div class="spinner-border spinner_upload text-success" id="spinner_upload" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            &nbsp;
                                            <strong class="me-auto" id="uploaded_status">Uploaded 1 file</strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close" onclick="hide_upload_toast()"></button>
                                        </div>
                                        <div class="toast-body">
                                            <div class="row">
                                                <div class="col-auto" id="col_preview">
                                                    <img class="coverimg" id="uploaded_preview" src="" alt="" width="70">
                                                </div>
                                                <div class="col ps-0">
                                                    <h6 class="fw-medium mb-0" id="uploaded_name"></h6>
                                                    <p class="text-secondary small" id="uploaded_date"></p>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <div class="progress h-5 mb-1 bg-light-green">
                                                    <div id="myProgressBar" class="progress-bar bg-green" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                            <div class="col-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2"></div>
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
    <?php $this->load->view('tickets/review_rating_form/detail_js'); ?>

</body>

</html>