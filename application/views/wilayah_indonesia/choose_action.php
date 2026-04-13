<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>
        <?= $pageTitle; ?>
    </title>

    <!-- manifest meta -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="manifest" href="manifest.json" />

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="180x180">
    <link rel="icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="32x32" type="image/png">
    <link rel="icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="16x16" type="image/png">

    <!-- Google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <!-- swiper carousel css -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/swiper-7.3.1/swiper-bundle.min.css">

    <!-- style css for this template -->
    <link href="<?= base_url(); ?>assets/scss/style.css" rel="stylesheet" id="style">

    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.css" />

    <style>
    .form-control {
        display: block;
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: 0.25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .btn-monday {
        background-color: rgba(var(--WinDOORS-theme-rgb), 0.1);
        border-radius: 5px;
    }

    .dark-mode .modal-content {
        background: rgba(var(--WinDOORS-theme-bg-rgb), 0.8) !important;
    }

    .dark-mode .nice-select-dropdown {
        background-color: rgba(var(--WinDOORS-theme-bg-rgb), 1);
        border: 2px solid white;
        padding: 2px
    }

    .dark-mode .nice-select-search {
        background-color: black;
        color: white;
    }

    .dark-mode .note-editing-area {
        background: black;
        color: white;
    }

    .dark-mode .nice-select .option:hover,
    .dark-mode .nice-select .option.focus,
    .dark-mode .nice-select .option.selected.focus {
        background-color: black;
    }

    .dark-mode .nice-select {
        background-color: black;
    }

    select optgroup {
        margin-left: 5px;
    }

    .optgroup {
        margin-left: 5px;
    }

    .mt-4-5 {
        margin-top: 1.7rem;
    }

    .w-90 {
        width: 95% !important;
    }

    .monday-breadcrumb-item+.monday-breadcrumb-item {
        padding-left: var(--bs-breadcrumb-item-padding-x);
    }

    .monday-breadcrumb-item+.monday-breadcrumb-item::after {
        float: left;
        padding-right: var(--bs-breadcrumb-item-padding-x);
        color: var(--bs-breadcrumb-divider-color);
        content: '|';
    }

    .monday-item::before {
        content: '';
        display: block;
        width: 0;
        height: 2px;
        border-bottom: solid 2px #015EC2;
        border-radius: 1px;
        margin-bottom: 1px;
        transition: width .2s ease-in;
    }

    .monday-item:hover::before {
        width: 100%;
    }

    .monday-active {
        background-color: rgba(var(--WinDOORS-theme-rgb), 0.1);
    }

    .monday-hover {
        background-color: rgba(var(--WinDOORS-theme-rgb), 0.1);
        border-radius: 5px;
    }

    .dark-mode .jconfirm-box {
        background-color: rgba(var(--WinDOORS-theme-bg-rgb), 1) !important;
        color: white !important;
    }

    .dark-mode .jconfirm-title-c {
        color: white !important;
    }

    .dark-mode .jconfirm-content {
        color: white !important;
    }
</style>


</head>

<body class="d-flex flex-column h-100 sidebar-pushcontent" data-sidebarstyle="sidebar-pushcontent">
    <!-- sidebar-pushcontent, sidebar-overlay , sidebar-fullscreen  are classes to switch UI here-->

    <!-- page loader -->
    <div class="container-fluid h-100 position-fixed loader-wrap bg-blur">
        <div class="row justify-content-center h-100">
            <div class="col-auto align-self-center text-center">
                <!-- <div class="doors animated mb-4">
                    <div class="left-door"></div>
                    <div class="right-door"></div>
                </div> -->
                <h5 class="mb-0">Thanks for the patience</h5>
                <p class="text-secondary small">Amazing things coming from the <span class="text-dark">IBR Pro</span>
                </p>
                <div class="spinner-border text-primary mt-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    <!-- page loader ends -->

    <!-- background -->
    <!-- <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
        <img src="<?= base_url() ?>assets/img/bg-1.jpg" alt="" class="w-100" />
    </div> -->
    <!-- background ends  -->


    <!-- Begin page content -->
    <main class="main h-100 container-fluid">
        <!-- image swiper -->
        <div class="swiper image-swiper h-100 w-100 position-absolute z-index-0 start-0 top-0">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
                        <img src="<?= base_url() ?>assets/img/bg-5.jpg" alt="" />
                    </div>
                </div>
                <!-- <div class="swiper-slide">
                    <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
                        <img src="<?= base_url() ?>assets/img/bg-2.jpg" alt="" class="w-100" />
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
                        <img src="<?= base_url() ?>assets/img/bg-4.jpg" alt="" />
                    </div>
                </div> -->
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
                                    <div class="col-auto">
                                        <img src="<?= base_url(); ?>assets/img/logo_trusmiverse.png" class="mx-100"
                                            alt="" />
                                    </div>
                                    <div class="col ps-0 align-self-center">
                                        <h5 class="fw-normal text-dark">IBR Pro</h5>
                                        <p class="small text-secondary"></p>
                                    </div>
                                </div>
                            </a>
                            <div>
                                <!-- <button type="button" class="btn btn-link text-secondary text-center" id="addtohome"><i class="bi bi-cloud-download-fill me-0 me-lg-1"></i> <span class="d-none d-lg-inline-block">Install</span></button>
                                <a href="signup.html" class="btn btn-link text-secondary text-center"><i class="bi bi-person-circle me-0 me-lg-1"></i> <span class="d-none d-lg-inline-block">Sign up</span></a> -->
                            </div>
                        </div>
                    </nav>
                </header>
                <!-- header ends -->
            </div>
            <div class="col-12  align-self-center py-1">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-11 col-lg-10 col-xl-7 col-xxl-6">
                        <div class="card bg-blur">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-auto">
                                        <img src="<?= base_url(); ?>assets/img/logo_trusmiverse.png" alt="" />
                                    </div>
                                    <div class="col ">
                                        <h5 class="fw-normal">IBR Pro Update</h5>
                                    </div>
                                    <!-- <div class="col-auto">
                                        <a href="home.html">Skip <i class="bi bi-arrow-right"></i></a>
                                    </div> -->
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="swiper ibr_pro_swiper swiper-no-swiping h-100 w-100">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12 text-center position-relative py-4">
                                                    <img class="avatar avatar-100 coverimg mb-3 rounded-circle"
                                                        src="http://trusmiverse.com/hr/uploads/profile/<?= $profile['photo_profile'] ?>"
                                                        alt="" />

                                                    <h5 class="text-truncate mb-0"><?= $profile['employee_name'] ?></h5>
                                                    <p class="text-secondary small mb-1"><?= $profile['jabatan'] ?></p>
                                                    <ul class="nav justify-content-center">
                                                        <li class="nav-item">
                                                            <img class="cols avatar avatar-20 coverimg rounded-circle"
                                                                src="<?= base_url(); ?>assets/img/logo_rumah_ningrat.png"
                                                                alt="">
                                                        </li>
                                                        <li class="nav-item">
                                                            <img class="cols avatar avatar-20 coverimg rounded-circle"
                                                                src="<?= base_url(); ?>assets/img/logo_bt.png" alt="">
                                                        </li>
                                                        <li class="nav-item">
                                                            <img class="cols avatar avatar-20 coverimg rounded-circle"
                                                                src="<?= base_url(); ?>assets/img/logo_tkb.png" alt="">
                                                        </li>
                                                        <li class="nav-item">
                                                            <img class="cols avatar avatar-20 coverimg rounded-circle"
                                                                src="<?= base_url(); ?>assets/img/fbtlogo.png" alt="">
                                                        </li>
                                                    </ul>



                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 align-self-center py-1">
                                                    <div class="form-group mb-2 position-relative check-valid is-valid">
                                                        <div class="input-group input-group-lg">
                                                            <span
                                                                class="input-group-text text-theme bg-white border-end-0"><i
                                                                    class="bi bi-award"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" placeholder="Your Goal"
                                                                    value="<?= $profile['goal'] ?>" readonly
                                                                    class="form-control border-start-0" id="goal">
                                                                <label for="goal">Your Goal</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-2 position-relative check-valid is-valid">
                                                        <div class="input-group input-group-lg">
                                                            <span
                                                                class="input-group-text text-theme bg-white border-end-0"><i
                                                                    class="bi bi-lightbulb"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" placeholder="Strategy"
                                                                    value="<?= $profile['strategy'] ?>" readonly
                                                                    class="form-control border-start-0"
                                                                    id="strategy">
                                                                <label for="goal">Strategy</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-2 position-relative check-valid is-valid">
                                                        <div class="input-group input-group-lg">
                                                            <span
                                                                class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar2-event"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" placeholder="Type" value="<?= $profile['type'] ?>" readonly class="form-control border-start-0" id="type">
                                                                <label for="goal">Type</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">

                                                        <div class="col-12 align-self-center py-1">

                                                            <div class="row pt-2">
                                                                <div class="col-6 mnw-100 text-center">
                                                                    <i
                                                                        class="bi bi-award-fill h4 avatar avatar-60 bg-light-orange text-orange rounded-circle mb-2"></i>
                                                                    <h5 class="increamentcount mb-0"><?= $profile['target'] ?></h5>
                                                                    <p class="small text-secondary">Target</p>
                                                                </div>
                                                                <div class="col-6 mnw-100 text-center">
                                                                    <i
                                                                        class="bi bi-bookmark-check-fill h4 avatar avatar-60 bg-light-green text-green rounded-circle mb-2"></i>
                                                                    <h5 class="increamentcount mb-0"><?= $profile['actual'] ?></h5>
                                                                    <p class="small text-secondary">Actual</p>
                                                                </div>
                                                            </div>

                                                            <div class="row py-3">
                                                                <div class="col-6 mnw-100 text-center">
                                                                    <i
                                                                        class="bi bi-percent h4 avatar avatar-60 bg-light-yellow text-yellow rounded-circle mb-2"></i>
                                                                    <h5 class="mb-0"><?= $profile['progress'] ?>%</h5>
                                                                    <p class="small text-secondary">Progress</p>
                                                                </div>
                                                                <div class="col-6 mnw-100 text-center">
                                                                    <i
                                                                        class="bi bi-clipboard-check-fill h4 avatar avatar-60 bg-light-cyan text-cyan rounded-circle mb-2"></i>
                                                                    <h5 class="mb-0"><?= $profile['consistency'] ?>%</h5>
                                                                    <p class="small text-secondary">Consistency</p>
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
                            <div class="card-footer">
                                <div class="b-t-default">
                                    <div class="row m-0">
                                        <div class="col-6 f-btn text-center b-r-default p-t-15 p-b-15 ">
                                            <button id="btn_postpone" class="btn btn-outline-theme me-2" style="width:100%">
                                                <i class="bi bi-clock-history vm me-2"></i> 
                                                <small>Postpone</small>
                                            </button>
                                        </div>
                                        <div class="col-6 f-btn text-center p-t-15 p-b-15">
                                            <button id="btn_update" class="btn btn-theme" style="width:100%" onclick="update_task()">
                                                <i class="bi bi-clipboard-check vm me-2"></i> 
                                                <small>Update</small>
                                            </button>
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
            </div>

        </div>

    </main>





    <div class="modal fade" id="modal_update_sub_task" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modal_update_sub_taskLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header row align-items-center bg-theme">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light text-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_update_sub_taskLabel">Update Strategy</h6>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="dropdown d-inline-block">
                            <a class="btn btn-link btn-square text-white dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="title" id="title_sub_task"><?= $profile['goal'] ?></h6>
                                    <form id="form-update-sub-task">
                                        <div class="row">
                                            <div class="col-12 col-md-12 d-none">
                                                <div class="mb-1">
                                                    <label class="small text-secondary" for="sub_task">Strategy</label>
                                                    <input type="text" name="u_id_sub_task" id="u_id_sub_task" value="<?= $profile['id_sub_task'] ?>" class="form-control" readonly>
                                                    <input type="text" name="u_id_task" id="u_id_task" value="<?= $profile['id_task'] ?>" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-6">
                                                <div class="mb-1">
                                                    <label class="small text-secondary" for="history_sub_note">Note</label>
                                                    <textarea name="history_sub_note" id="u_history_sub_note" class="form-control" cols="30" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-6">
                                                <div class="mb-1">
                                                    <label class="small text-secondary" for="history_sub_evaluasi">Evaluasi Strategy</label>
                                                    <textarea name="history_sub_evaluasi" id="u_history_sub_evaluasi" class="form-control" cols="30" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-6">
                                                <div class="mb-1">
                                                    <label class="small text-secondary" for="u_history_progress">Progress</label>
                                                    <input type="text" name="history_progress" id="u_history_progress" value="<?= $profile['next_progress'] ?>" class="form-control" readonly>
                                                    <input type="hidden" name="week_number" id="u_week_number" class="form-control" value="<?= $profile['week_number'] ?>" readonly>
                                                    <input type="hidden" name="week_start_date" id="u_week_start_date" class="form-control" value="<?= $profile['week_start_date'] ?>" readonly>
                                                    <input type="hidden" name="week_end_date" id="u_week_end_date" class="form-control" value="<?= $profile['week_end_date'] ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-6">
                                                <div class="mb-1">
                                                    <label class="small text-secondary" for="">File</label>
                                                    <input type="file" name="history_file_sub" id="u_history_file_sub" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-6">
                                                <div class="mb-1">
                                                    <label class="small text-secondary" for="">Link</label>
                                                    <input type="text" name="history_link_sub" id="u_history_link_sub" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-6">
                                                <div class="mb-1">
                                                    <label class="small text-secondary" for="">Notification Hour</label>
                                                    <select name="u_jam_notif" id="u_jam_notif" class="form-control">
                                                        <option value="05:00">05:00 WIB</option>
                                                        <option value="06:00">06:00 WIB</option>
                                                        <option value="07:00">07:00 WIB</option>
                                                        <option value="08:00">08:00 WIB</option>
                                                        <option value="09:00">09:00 WIB</option>
                                                        <option value="10:00">10:00 WIB</option>
                                                        <option value="11:00">11:00 WIB</option>
                                                        <option value="12:00">12:00 WIB</option>
                                                        <option value="13:00">13:00 WIB</option>
                                                        <option value="14:00">14:00 WIB</option>
                                                        <option value="15:00">15:00 WIB</option>
                                                        <option value="16:00">16:00 WIB</option>
                                                        <option value="17:00">17:00 WIB</option>
                                                        <option value="18:00">18:00 WIB</option>
                                                        <option value="19:00">19:00 WIB</option>
                                                        <option value="20:00">20:00 WIB</option>
                                                        <option value="21:00">21:00 WIB</option>
                                                        <option value="22:00">22:00 WIB</option>
                                                        <option value="23:00">23:00 WIB</option>
                                                        <option value="24:00">24:00 WIB</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 text-end">
                                                <div class="mb-1">
                                                    <button type="button" class="btn btn-theme text-white m-1" onclick="save_update_sub_task()">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="title">Activity Log</h6>
                                    <table id="dt_log_history_sub_task" class="table table-sm table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="body_log_hitory_sub_task">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link m-1" onclick="close_update_sub_task()">Close</button>
                </div>
            </div>
        </div>
    </div>





    <!-- Required jquery and libraries -->
    <script src="<?= base_url() ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url() ?>assets/js/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/bootstrap-5/dist/js/bootstrap.bundle.js"></script>

    <!-- Customized jquery file  -->
    <script src="<?= base_url() ?>assets/js/main.js"></script>
    <script src="<?= base_url() ?>assets/js/color-scheme.js"></script>

    <!-- PWA app service registration and works -->
    <script src="<?= base_url() ?>assets/js/pwa-services.js"></script>

    <!-- Chart js script -->
    <script src="<?= base_url() ?>assets/vendor/chart-js-3.3.1/chart.min.js"></script>

    <!-- Progress circle js script -->
    <script src="<?= base_url() ?>assets/vendor/progressbar-js/progressbar.min.js"></script>

    <!-- swiper js script -->
    <script src="<?= base_url() ?>assets/vendor/swiper-7.3.1/swiper-bundle.min.js"></script>

    <!-- page level script -->
    <!-- <script src="<?= base_url() ?>assets/js/onboarding.js"></script> -->


    <?php $this->load->view('monday/details/js'); ?>

    <script>
        function update_task() {
            u_close_id_task = $('#u_id_task').val();
            $('#modal_update_sub_task').modal('show');
            setTimeout(() => {
                detail_task(u_close_id_task);
            }, 250);
            
        }

        function close_update_sub_task() {
            u_close_id_task = $('#u_id_task').val();
            $('#modal_update_sub_task').modal('hide');
            setTimeout(() => {
                detail_task(u_close_id_task);
            }, 250);
        }

        function save_update_sub_task() {
        let val_u_id_task = $('#u_id_task').val();
        let val_u_id_sub_task = $('#u_id_sub_task').val();
        let val_u_history_sub_note = $('#u_history_sub_note').val();
        let val_u_history_sub_evaluasi = $('#u_history_sub_evaluasi').val();
        let val_u_history_progress = $('#u_history_progress').val();
        let val_u_history_link_sub = $('#u_history_link_sub').val();
        let val_u_week_number = $('#u_week_number').val();
        let val_u_week_start_date = $('#u_week_start_date').val();
        let val_u_week_end_date = $('#u_week_end_date').val();
        let val_u_jam_notif = $('#u_jam_notif').val();

        if (val_u_id_task == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, id task is not found',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_u_id_sub_task == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, id sub task must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_u_history_sub_note == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, note must be choosed',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else {

            let file_data = $("#u_history_file_sub").prop("files")[0];
            let form_data_sub = new FormData();
            form_data_sub.append("id_task", val_u_id_task);
            form_data_sub.append("id_sub_task", val_u_id_sub_task);
            form_data_sub.append("history_sub_note", val_u_history_sub_note);
            form_data_sub.append("history_sub_evaluasi", val_u_history_sub_evaluasi);
            form_data_sub.append("history_progress", val_u_history_progress);
            form_data_sub.append("week_number", val_u_week_number);
            form_data_sub.append("history_file_sub", file_data);
            form_data_sub.append("history_link_sub", val_u_history_link_sub);
            form_data_sub.append("week_start_date", val_u_week_start_date);
            form_data_sub.append("week_end_date", val_u_week_end_date);
            form_data_sub.append("jam_notif", val_u_jam_notif);

            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: 'Please Wait!',
                theme: 'material',
                type: 'blue',
                content: 'Loading...',
                buttons: {
                    close: {
                        isHidden: true,
                        actions: function() {}
                    },
                },
                onOpen: function() {

                    $.ajax({
                        url: `<?= base_url() ?>monday/update_sub_task`,
                        type: 'POST',
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data_sub, // Setting the data attribute of ajax with file_data
                        type: 'post',
                        beforeSend: function() {

                        },
                        success: function(response) {},
                        error: function(xhr) {},
                        complete: function() {},
                    }).done(function(response) {
                        if (response.save_sub_task == true) {
                            jconfirm.instances[0].close();
                            $('#modal_update_sub_task').modal('hide');
                            setTimeout(() => {
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Success!',
                                    theme: 'material',
                                    type: 'blue',
                                    content: 'Strategy updated!',
                                    buttons: {
                                        close: {
                                            actions: function() {}
                                        },
                                    },
                                });
                                setTimeout(() => {
                                    jconfirm.instances[0].close();
                                    detail_task(response.id_task);
                                }, 250);
                            }, 250);
                        } else {
                            // modal_sub_task(id_task)
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-close',
                                    title: 'Oops!',
                                    theme: 'material',
                                    type: 'red',
                                    content: 'Server Busy, Try Again Later!',
                                    buttons: {
                                        close: {
                                            actions: function() {}
                                        },
                                    },
                                });
                            }, 250);
                        }
                    }).fail(function(jqXHR, textStatus) {
                        setTimeout(() => {
                            jconfirm.instances[0].close();
                            $.confirm({
                                icon: 'fa fa-close',
                                title: 'Oops!',
                                theme: 'material',
                                type: 'red',
                                content: 'Failed!' + textStatus,
                                buttons: {
                                    close: {
                                        actions: function() {}
                                    },
                                },
                            });
                        }, 250);
                    });
                },
            });
        }

    }

    </script>

</body>

</html>