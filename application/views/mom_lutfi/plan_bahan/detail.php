<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>Trusmiverse - Tickets</title>

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
                            <div class="col-12 col-md-8 col-lg-7 col-xl-6 col-xxl-4 mb-2">
                                <div class="row gx-2 justify-content-center align-items-center mb-2">
                                    <p>Due Date :</p>
                                    <div class="col-auto">
                                        <span id="days" class="display-3 fw-medium"></span>
                                        <br>
                                        <small class="text-secondary">Days</small>
                                    </div>
                                    <div class="col-auto fw-medium">:</div>
                                    <div class="col-auto">
                                        <span id="hrs" class="display-3 fw-medium"></span>
                                        <br>
                                        <small class="text-secondary">Hours</small>
                                    </div>
                                    <div class="col-auto fw-medium">:</div>
                                    <div class="col-auto">
                                        <span id="min" class="display-3 fw-medium"></span>
                                        <br>
                                        <small class="text-secondary">Minutes</small>
                                    </div>
                                    <div class="col-auto fw-medium">:</div>
                                    <div class="col-auto">
                                        <span id="sec" class="display-3 fw-medium"></span>
                                        <br>
                                        <small class="text-secondary">seconds</small>
                                    </div>
                                </div>
                                <h1 class="display-3" id="timer">&nbsp;</h1>
                            </div>
                            <div class="col-12 mt-2">
                                <!-- <div class="row">
                                    <div class="col">
                                        <ul class="nav detail_tabs nav-WinDOORS">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="javascript:void(0)" id="nav_ticket" onclick="activateTab('ticket')">
                                                    Detail
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="javascript:void(0)" id="nav_comment" onclick="activateTab('comment')">
                                                    Comment
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="javascript:void(0)" id="nav_activity" onclick="activateTab('activity')">
                                                    Activity Log
                                                </a>
                                            </li>
                                            <li class=" nav-item">
                                                <a class="nav-link" href="javascript:void(0)" id="nav_files" onclick="activateTab('files')">
                                                    Files
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div> -->
                                <hr>

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
                                                <i class="comingsoonbi bi-calendar-event h5 avatar avatar-40 bg-light-green text-green text-green rounded "></i>
                                            </div>
                                            <div class="col text-start">
                                                <h6 class="fw-medium mb-0" id="judul_plan">Plan MoM</h6>
                                                <p class="text-secondary small" id="e_object_text">Tasklist Upload File Bahan MoM</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6 col-md-3 mb-3 text-start">
                                                <p class="text-secondary small mb-1">Place</p>
                                                <h6 id="tempat_plan" class="small">-</h6>
                                            </div>
                                            <div class="col-6 col-md-3 mb-3 text-start">
                                                <p class="text-secondary small mb-1">Date</p>
                                                <h6 id="tanggal_plan" class="small badge bg-light-green text-dark"></h6>
                                                <h6 id="waktu_plan" class="small badge bg-light-red text-dark"></h6>
                                            </div>
                                            <div class="col-6 col-md-3 text-start mb-3">
                                                <p class="text-secondary small mb-1">Peserta/PIC</p>
                                                <h6 id="peserta_plan" class="small">-</h6>
                                            </div>
                                            <div class="col-6 col-md-3 text-start mb-3">
                                                <p class="text-secondary small mb-1">Note</p>
                                                <h6 id="note_plan" class="small">-</h6>
                                            </div>
                                            <div class="col-6 text-start mb-3">
                                                <p class="text-secondary small mb-1">Created By</p>
                                                <h6 id="created_by" class="small">-</h6>
                                                <h6 id="created_at" class="small">-</h6>
                                                <h6 id="created_location" class="small">-</h6>
                                            </div>
                                            <div class="col-6 text-start mb-3">
                                                <p class="text-secondary small mb-1">Created Divisi</p>
                                                <span class="badge bg-light-purple text-dark" id="created_company" class="small">-</span>
                                                <span class="badge bg-light-yellow text-dark" id="created_department" class="small">-</span>
                                                <span class="badge bg-light-red text-dark" id="created_designation" class="small">-</span>
                                            </div>
                                            <div class="col-6 text-start mb-3">
                                                <p class="text-secondary small mb-1">Uploaded By</p>
                                                <h6 id="uploaded_by" class="small">-</h6>
                                                <h6 id="uploaded_at" class="small">@</h6>
                                                <h6 id="uploaded_designation" class="small badge bg-light-red text-dark">-</h6>
                                            </div>
                                            <div class="col-6 text-start mb-3">
                                                <p class="text-secondary small mb-1">Status</p>
                                                <span id="uploaded_status" class="badge text-dark">-</span>
                                                <div id="uploaded_progres" class="mt-2"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer" id="footer-update">
                                        <form id="form_bahan">
                                        <input type="hidden" name="id_plan" id="id_plan" readonly>
                                        <input type="hidden" name="id_pic" id="id_pic" readonly>
                                        <div class="row g-3 mb-3 align-items-center">
                                            <div class="col-3">
                                                <label class="form-label-custom required small" for="e_progress"><i class="text-theme bi bi-file-earmark"></i> File</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="file" name="file_bahan" id="file_bahan" class="form-control mt-2" autocomplete="off" accept="*">
                                            </div>
                                        </div>
                                        <div class="row g-3 mb-3 align-items-center">
                                            <div class="col-3">
                                                <label class="form-label-custom required small" for="e_progress"><i class="text-theme bi bi-link"></i> Link</label>
                                            </div>
                                            <div class="col-9">
                                            <input type="text" name="link_bahan" id="link_bahan" class="form-control mt-2" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="row g-3 mb-3 align-items-center">
                                            <div class="col-3">
                                                <label class="form-label-custom small" for="e_note"><i class="text-theme bi bi-card-heading"></i> Note</label>
                                            </div>
                                            <div class="col-9">
                                                <textarea name="note_bahan" id="note_bahan" class="form-control" style="height: 100px;"></textarea>
                                            </div>
                                        </div>
                                        </form>
                                        <div class="row gx-2">
                                            <div class="col text-end">
                                                <a class="btn btn-theme btn-md" role="button" id="btn_update_bahan" onclick="update_bahan()">Update</a>
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
    <?php $this->load->view('mom/plan_bahan/detail_js'); ?>

</body>

</html>