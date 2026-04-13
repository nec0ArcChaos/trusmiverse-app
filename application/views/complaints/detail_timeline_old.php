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
        <div class="container">
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
                        <div class="col-12 align-self-center py-2 text-center">
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-8 col-lg-7 col-xl-6 col-xxl-4 mb-2">
                                    <p style="font-size: 24pt;" id="timer">&nbsp;</p>
                                    <div class="row gx-2 justify-content-center align-items-center mb-2" id="div_timer">
                                        <p>Due Date :</p>
                                        <div class="col-auto">
                                            <span id="days" class="display-4 fw-medium"></span>
                                            <br>
                                            <small class="text-secondary">Days</small>
                                        </div>
                                        <div class="col-auto fw-medium">:</div>
                                        <div class="col-auto">
                                            <span id="hrs" class="display-4 fw-medium"></span>
                                            <br>
                                            <small class="text-secondary">Hours</small>
                                        </div>
                                        <div class="col-auto fw-medium">:</div>
                                        <div class="col-auto">
                                            <span id="min" class="display-4 fw-medium"></span>
                                            <br>
                                            <small class="text-secondary">Minutes</small>
                                        </div>
                                        <div class="col-auto fw-medium">:</div>
                                        <div class="col-auto">
                                            <span id="sec" class="display-4 fw-medium"></span>
                                            <br>
                                            <small class="text-secondary">seconds</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="row">
                                        <div class="col">
                                            <ul class="nav detail_tabs nav-WinDOORS">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="javascript:void(0)" id="nav_complaints" onclick="activateTab('complaints')">
                                                        Detail
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="javascript:void(0)" id="nav_activity" onclick="activateTab('activity')">
                                                        Activity Log
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <hr>

                                    <input type="hidden" id="detail_id_task" value="<?= $id_task; ?>">

                                    <div class="row" style="display:none" id="spinner_loading">
                                        <div class="col text-center center-spinner">
                                            <div class="spinner-border text-primary mt-3" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TICKET PAGE -->
                                    <div class="detail_pages" id="complaints_page">
                                        <div class="card border-0 mb-4">
                                            <div class="card-header">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <i class="comingsoonbi bi-calendar-event h5 avatar avatar-40 bg-light-green text-green text-green rounded "></i>
                                                    </div>
                                                    <div class="col text-start">
                                                        <h6 class="fw-medium mb-0" id="e_task_text">Ticket Title</h6>
                                                        <p class="text-secondary small" id="e_object_text">Object</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-3 col-6 text-start mb-3">
                                                        <p class="text-secondary small mb-1">Requested By</p>
                                                        <h6 id="e_requested_by_text" class="small" style="margin-bottom: 3px;">-</h6>
                                                        <h6 id="e_requested_at_text" class="small">-</h6>
                                                    </div>
                                                    <div class="col-xl-3 col-6 text-start mb-3">
                                                        <p class="text-secondary small mb-1">Requested Divisi</p>
                                                        <h6 class="small">
                                                            <span style="margin-bottom: 3px;" class="badge bg-light-purple text-dark" id="e_requested_company_text">-</span>
                                                            <span style="margin-bottom: 3px;" class="badge bg-light-yellow text-dark" id="e_requested_department_text">-</span>
                                                            <span style="margin-bottom: 3px;" class="badge bg-light-red text-dark" id="e_requested_designation_text">-</span>
                                                        </h6>
                                                    </div>
                                                    <div class="col-xl-3 col-6 text-start mb-3">
                                                        <p class="text-secondary small mb-1">Verified By</p>
                                                        <h6 id="e_verified_by_text" class="small" style="margin-bottom: 3px;">-</h6>
                                                        <h6 id="e_verified_at_text" class="small">-</h6>
                                                    </div>
                                                    <div class="col-xl-3 col-6 text-start mb-3">
                                                        <p class="text-secondary small mb-1">Escalation To</p>
                                                        <h6 id="e_escalation_by_text" class="small" style="margin-bottom: 3px;">-</h6>
                                                        <h6 id="e_escalation_at_text" class="small">-</h6>
                                                    </div>
                                                    <div class="col-xl-3 col-md-3 col-6 text-start mb-3">
                                                        <p class="text-secondary small mb-1">Due Date</p>
                                                        <h6 id="e_due_date_text" class="small">-</h6>
                                                    </div>
                                                    <div class="col-xl-3 col-md-3 col-6 text-start mb-3">
                                                        <p class="text-secondary small mb-1">Timeline</p>
                                                        <h6 id="e_timeline_text" class="small"></h6>
                                                    </div>
                                                    <div class="col-xl-3 col-md-3 col-6 text-start mb-3">
                                                        <p class="text-secondary small mb-1">Priority</p>
                                                        <span id="e_priority_text" class="badge">-</span>
                                                    </div>
                                                    <div class="col-xl-3 col-md-3 col-6 text-start mb-3">
                                                        <p class="text-secondary small mb-1">Level</p>
                                                        <span id="e_level_text" class="badge"></span>
                                                    </div>
                                                    <div class="col-xl-3 col-md-3 col-6 text-start mb-3">
                                                        <p class="text-secondary small mb-1">Status</p>
                                                        <span id="e_status_text" class="badge"></span>
                                                        <div id="div_e_progress_text" class="mt-2">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-6 text-start mb-3">
                                                        <p class="text-secondary small mb-1">Pic</p>
                                                        <h6 id="e_pic_text" class="small">-</h6>
                                                    </div>
                                                    <div class="col-12 mb-1 text-start">
                                                        <p class="text-secondary small mb-1">Project : <br>
                                                            <span class="small" id="e_project_text">-</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-12 mb-1 text-start">
                                                        <p class="text-secondary small mb-1">Blok : <br>
                                                            <span class="small" id="e_blok_text">-</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-12 mb-1 text-start">
                                                        <p class="text-secondary small mb-1">Category Complaints : <br>
                                                            <span class="small" id="e_category_text">-</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-12 mb-1 text-start">
                                                        <p class="text-secondary small mb-1">Tanggal After Sales : <br>
                                                            <span class="small" id="e_tgl_aftersales">-</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-12 mb-1 text-start">
                                                        <p class="text-secondary small mb-1">Description</p>
                                                        <h6 id="e_description_text" class="small">-</h6>
                                                    </div>
                                                    <div class="row mt-4" id="body_files_page">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- TICKET PAGE -->

                                    <!-- ACTIVITY LOG PAGE -->
                                    <div class="row detail_pages" id="activity_page">
                                        <div class="col">
                                            <div class="table-responsive" style="padding: 10px;">
                                                <table id="dt_log_history" class="table table-borderless table-striped footable" style="width:100%" data-filtering="false">
                                                    <tbody id="body_log_history">

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row align-items-center mx-0 detail_pages">
                                                <div class="col-6">
                                                    <span class="hide-if-no-paging">
                                                        Showing <span class="footablestot"></span> page
                                                    </span>
                                                </div>
                                                <div class="col-6 footable-pagination"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ACTIVITY LOG PAGE -->
                                </div>
                            </div>
                        </div>
                        <?php // $this->load->view('layout/_footer'); 
                        ?>
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