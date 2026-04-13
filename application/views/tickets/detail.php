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

    <?php $this->load->view('tickets/detail_css'); ?>

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
                                <!-- <h1 class="display-3" id="timer">&nbsp;</h1> -->
                            </div>
                            <div class="col-12 mt-2">
                                <div class="row">
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
                                <div class="row detail_pages" id="ticket_page">
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
                                                <div class="col-6 col-md-3 mb-3 text-start">
                                                    <p class="text-secondary small mb-1">Due Date</p>
                                                    <h6 id="e_due_date_text" class="small">-</h6>
                                                </div>
                                                <div class="col-6 col-md-3 mb-3 text-start">
                                                    <p class="text-secondary small mb-1">Timeline</p>
                                                    <h6 id="e_timeline_text" class="small"></h6>
                                                </div>
                                                <div class="col-6 col-md-3 mb-3 text-start">
                                                    <p class="text-secondary small mb-1">Priority</p>
                                                    <span id="e_priority_text" class="badge">-</span>
                                                </div>
                                                <div class="col-6 col-md-3 mb-3 text-start">
                                                    <p class="text-secondary small mb-1">Level</p>
                                                    <span id="e_level_text" class="badge"></span>
                                                </div>
                                                <div class="col-6 text-start mb-3">
                                                    <p class="text-secondary small mb-1">Requested By</p>
                                                    <h6 id="e_requested_by_text" class="small">-</h6>
                                                    <h6 id="e_requested_at_text" class="small">-</h6>
                                                    <h6 id="e_requested_location_text" class="small">-</h6>
                                                </div>
                                                <div class="col-6 text-start mb-3">
                                                    <p class="text-secondary small mb-1">Requested Divisi</p>
                                                    <span class="badge bg-light-purple text-dark" id="e_requested_company_text" class="small">-</span>
                                                    <span class="badge bg-light-yellow text-dark" id="e_requested_department_text" class="small">-</span>
                                                    <span class="badge bg-light-red text-dark" id="e_requested_designation_text" class="small">-</span>
                                                </div>
                                                <!-- <div class="col-4 col-md-4 text-start mb-3">
                                                    <p class="text-secondary small mb-1">Requested At</p>
                                                </div> -->
                                                <div class="col-6 text-start mb-3">
                                                    <p class="text-secondary small mb-1">Status</p>
                                                    <span id="e_status_text" class="badge"></span>
                                                    <div id="div_e_progress" class="mt-2">
                                                    </div>
                                                </div>
                                                <div class="col-6 text-start mb-3">
                                                    <p class="text-secondary small mb-1">Pic</p>
                                                    <h6 id="e_pic_text" class="small">-</h6>
                                                </div>
                                                <div class="col-12 text-start mb-3">
                                                    <p class="text-secondary small mb-1">Description</p>
                                                    <h6 id="e_description_text" class="small">-</h6>
                                                </div>
                                            </div>
                                            <p class="text-start">
                                                <span class="small" id="e_type_text">-</span>
                                                <span class="small" id="e_category_text">-</span>
                                            </p>
                                        </div>
                                        <div class="card-footer" id="footer-update">
                                            <input type="hidden" name="e_id_task" id="e_id_task" readonly>
                                            <div id="div_not_started">
                                                <div class="row g-3 mb-3 align-items-center">
                                                    <div class="col-4">
                                                        <label class="form-label-custom small" for="e_id_priority"><i class="text-theme bi bi-1-square"></i> Priority</label>
                                                    </div>
                                                    <div class="col-8">
                                                        <select name="e_id_priority" id="e_id_priority" class="wide mb-2">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row g-3 mb-3 align-items-center">
                                                    <div class="col-4">
                                                        <label class="form-label-custom small" for="e_id_level"><i class="text-theme bi bi-1-square"></i> Level</label>
                                                    </div>
                                                    <div class="col-8">
                                                        <select name="e_id_level" id="e_id_level" class="wide mb-2" style="display: none;">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row g-3 mb-3 align-items-center">
                                                    <div class="col-4">
                                                        <label class="form-label-custom small" for="e_due_date"><i class="text-theme bi bi-calendar-date"></i> Due Date</label>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="row">
                                                            <div class="col">
                                                                <input type="text" name="e_due_date" id="e_due_date" class="tanggal form-control">
                                                            </div>
                                                            <div class="col-auto d-none d-md-block">
                                                                <div id="e_due_date_div">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-3 mb-3 align-items-center">
                                                    <div class="col-4">
                                                        <label class="form-label-custom small" for="e_id_pic"><i class="text-theme bi bi-person-fill-check"></i> PIC</label>
                                                    </div>
                                                    <div class="col-8">
                                                        <select name="e_id_pic" id="e_id_pic" class="" multiple>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row g-3 mb-3 align-items-center">
                                                    <div class="col-4">
                                                        <label class="form-label-custom required small" for="e_start"><i class="text-theme bi bi-calendar-range"></i> Timeline</label>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="input-group input-group-md">
                                                            <input type="text" name="start_timeline" class="form-control border tanggal-menit" placeholder="Start Timeline" id="e_start_timeline" autocomplete="off" />
                                                            <input type="text" name="end_timeline" class="form-control border tanggal-menit" placeholder="End Timeline" id="e_end_timeline" autocomplete="off" />
                                                            <span class="input-group-text text-secondary bg-light-blue" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 mb-3 align-items-center">
                                                <div class="col-4">
                                                    <label class="form-label-custom small required" for="e_id_status"><i class="text-theme bi bi-2-square"></i> Status</label>
                                                </div>
                                                <div class="col-8">
                                                    <select name="e_id_status" id="e_id_status" class="wide" style="display: none;">
                                                        <?php $data_status = $this->db->query("SELECT id AS id_status, `status`, `color` FROM ticket_status")->result(); ?>
                                                        <?php foreach ($data_status as $stat) { ?>
                                                            <option value="<?= $stat->id_status; ?>" class="bg-primary"><?= $stat->status; ?></option>
                                                        <?php  } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row g-3 mb-3 align-items-center">
                                                <div class="col-4">
                                                    <label class="form-label-custom required small" for="e_progress"><i class="text-theme bi bi-bar-chart-line"></i> Progress</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="number" name="progress" id="e_progress" class="form-control mt-2" autocomplete="off" min="0" max="100">
                                                </div>
                                            </div>
                                            <div class="row g-3 mb-3 align-items-center">
                                                <div class="col-4">
                                                    <label class="form-label-custom small" for="e_note"><i class="text-theme bi bi-card-heading"></i> Note Update</label>
                                                </div>
                                                <div class="col-8">
                                                    <textarea name="e_note" id="e_note" class="form-control" style="height: 100px;"></textarea>
                                                </div>
                                            </div>
                                            <div class="row gx-2">
                                                <div class="col text-end">
                                                    <a class="btn btn-theme btn-md" role="button" onclick="update_task()">Update</a>
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

                                <!-- COMMENT PAGE -->
                                <div class="row detail_pages" id="comment_page">
                                    <div class="col-12 text-start">
                                        <div class="card border-0 mb-2" id="header_get_comment">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 mt-2">
                                                        <textarea name="e_comment" id="e_comment" cols="30" rows="5"></textarea>
                                                    </div>
                                                    <div class="col text-end mt-2">
                                                        <button class="btn btn-sm btn-theme" onclick="save_comment()"><i class="bi bi-send"></i> Send</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="body_get_comment" class="overflow-y-auto" style="max-height: 400px;">

                                        </div>
                                    </div>
                                </div>
                                <!-- COMMENT PAGE -->

                                <!-- FILES PAGE -->
                                <div class="row detail_pages" id="files_page" style="display:none">
                                    <div class="row text-start mb-3">
                                        <div class="col-auto">
                                            <i class="bi bi-file-earmark-richtext h5 avatar avatar-40 bg-light-green text-green rounded"></i>
                                        </div>
                                        <div class="col">
                                            <h6 class="fw-medium mb-0">Files</h6>
                                            <p class="small text-secondary">Recently</p>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" id="btn-attach-new-file" class="btn btn-link text-secondary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Attach New File <i class="bi bi-plus"></i></button>
                                        </div>
                                    </div>
                                    <div class="collapse" id="collapseExample">
                                        <div class="row mb-3" style="margin-top: auto;">
                                            <div class="col">
                                                <form id="fileForm">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" name="nama_file" id="nama_file" placeholder="File Name" value="" required="" class="form-control border-start-0" onchange="remove_invalid('nama_file')" oninput="remove_invalid('nama_file')">
                                                                <label>File Name</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-upload"></i></span>
                                                            <div class="form-floating">
                                                                <input type="file" name="file" id="fileInput" hidden onchange="file_selected()">
                                                                <input type="text" id="file_string" placeholder="Click to select file" class="form-control border-start-0" onclick="addFileInput()" onchange="remove_invalid('file_string')" oninput="remove_invalid('file_string')">
                                                                <label>Click to select file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 text-end">
                                                        <button type="button" class="btn btn-theme" id="btn_save_upload" onclick="upload_file()">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="body_files_page">

                                    </div>
                                </div>
                                <!-- FILES PAGE -->


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
    <?php $this->load->view('tickets/detail_js'); ?>

</body>

</html>