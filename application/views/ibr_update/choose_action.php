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

    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" />

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
                                        <img src="<?= base_url(); ?>assets/img/logo_trusmiverse.png" class="mx-100" alt="" />
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
                                                    <img class="avatar avatar-100 coverimg mb-3 rounded-circle" src="http://trusmiverse.com/hr/uploads/profile/<?= $profile['photo_profile'] ?>" alt="" />

                                                    <h5 class="text-truncate mb-0"><?= $profile['employee_name'] ?></h5>
                                                    <p class="text-secondary small mb-1"><?= $profile['jabatan'] ?></p>
                                                    <ul class="nav justify-content-center">
                                                        <li class="nav-item">
                                                            <img class="cols avatar avatar-20 coverimg rounded-circle" src="<?= base_url(); ?>assets/img/logo_rumah_ningrat.png" alt="">
                                                        </li>
                                                        <li class="nav-item">
                                                            <img class="cols avatar avatar-20 coverimg rounded-circle" src="<?= base_url(); ?>assets/img/logo_bt.png" alt="">
                                                        </li>
                                                        <li class="nav-item">
                                                            <img class="cols avatar avatar-20 coverimg rounded-circle" src="<?= base_url(); ?>assets/img/logo_tkb.png" alt="">
                                                        </li>
                                                        <li class="nav-item">
                                                            <img class="cols avatar avatar-20 coverimg rounded-circle" src="<?= base_url(); ?>assets/img/fbtlogo.png" alt="">
                                                        </li>
                                                    </ul>



                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 align-self-center py-1">
                                                    <div class="form-group mb-2 position-relative check-valid is-valid">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-award"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" placeholder="Your Goal" value="<?= $profile['goal'] ?>" readonly class="form-control border-start-0" id="goal">
                                                                <label for="goal">Your Goal</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-2 position-relative check-valid is-valid">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-lightbulb"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" placeholder="Strategy" value="<?= $profile['strategy'] ?>" readonly class="form-control border-start-0" id="strategy">
                                                                <label for="goal">Strategy</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-2 position-relative check-valid is-valid">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar2-event"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" placeholder="Type" value="<?= $profile['type'] ?>" readonly class="form-control border-start-0" id="type">
                                                                <label for="goal">Type</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-2 position-relative check-valid is-valid">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-check"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" placeholder="Type" value="<?= $profile['last_update'] ?>" readonly class="form-control border-start-0" id="last_update">
                                                                <label for="last_update">Last Update</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">

                                                        <div class="col-12 align-self-center py-1">

                                                            <div class="row pt-2">
                                                                <div class="col-6 mnw-100 text-center">
                                                                    <i class="bi bi-award-fill h4 avatar avatar-60 bg-light-orange text-orange rounded-circle mb-2"></i>
                                                                    <h5 class="increamentcount mb-0"><?= $profile['target'] ?></h5>
                                                                    <p class="small text-secondary">Target</p>
                                                                </div>
                                                                <div class="col-6 mnw-100 text-center">
                                                                    <i class="bi bi-bookmark-check-fill h4 avatar avatar-60 bg-light-green text-green rounded-circle mb-2"></i>
                                                                    <h5 class="increamentcount mb-0"><?= $profile['actual'] ?></h5>
                                                                    <p class="small text-secondary">Actual</p>
                                                                </div>
                                                            </div>

                                                            <div class="row py-3">
                                                                <div class="col-6 mnw-100 text-center">
                                                                    <i class="bi bi-percent h4 avatar avatar-60 bg-light-yellow text-yellow rounded-circle mb-2"></i>
                                                                    <h5 class="mb-0"><?= $profile['progress'] ?>%</h5>
                                                                    <p class="small text-secondary">Progress</p>
                                                                </div>
                                                                <div class="col-6 mnw-100 text-center">
                                                                    <i class="bi bi-clipboard-check-fill h4 avatar avatar-60 bg-light-cyan text-cyan rounded-circle mb-2"></i>
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
                                            <button id="btn_postpone" class="btn btn-outline-theme me-2" style="width:100%" onclick="show_modal_postpone('<?= $_GET['id'] ?>')">
                                                <i class="bi bi-clock-history vm me-2"></i>
                                                <small>Postpone</small>
                                            </button>
                                        </div>
                                        <div class="col-6 f-btn text-center p-t-15 p-b-15">
                                            <button id="btn_update" class="btn btn-theme" style="width:100%" onclick="modal_update_sub_task('<?= $_GET['id'] ?>')">
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
                                                    <input type="hidden" id="user_id" value="<?= $_GET['u'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-6" id="div_u_history_sub_note">
                                                <input type="hidden" name="id_type_goals" id="id_type_goals">
                                                <div class="mb-1">
                                                    <label class="small text-secondary" for="history_sub_note">Note</label>
                                                    <textarea name="history_sub_note" id="u_history_sub_note" class="form-control" cols="30" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-12">
                                                <div class="mb-1">
                                                    <label class="small text-secondary" for="u_ekspektasi">Ekspektasi</label>
                                                    <textarea id="u_ekspektasi" class="form-control" rows="2" readonly></textarea>
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
                                                    <option value="">Choose Hour</option>
                                                    <?php
                                                for ($hour = 0; $hour < 24; $hour++) {
                                                    for ($minute = 0; $minute < 60; $minute += 15) {
                                                        $time = sprintf("%02d:%02d", $hour, $minute);
                                                        echo "<option value=\"$time\">$time WIB</option>";
                                                    }
                                                }
                                                ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-6">
                                                <div class="mb-1">
                                                    <label class="small text-secondary" for="">Status</label>
                                                    <select class="form-control status_strategy" name="status" id="status">
                                                        <!-- <option value="" selected disabled>-- Pilih Status --</option>
                                                        <option value="1">Jalan Berhasil</option>
                                                        <option value="2">Jalan Tidak Berhasil</option>
                                                        <option value="3">Tidak Berjalan</option> -->
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
                                        <tbody id="body_log_hitory_sub_task" class="body_log_hitory_sub_task">

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


    <div class="modal fade" id="modal_postpone" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modal_postponeLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header row align-items-center bg-theme">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light text-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_postponeLabel">Postpone Strategy</h6>
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
                                    <form id="form_postpone">
                                        <input type="hidden" name="id_sub_task" value="<?= $profile['id_sub_task'] ?>" class="form-control">
                                        <input type="hidden" name="id_task" value="<?= $profile['id_task'] ?>" class="form-control">
                                        <input type="hidden" name="user_id" value="<?= isset($_GET['u']) ? $_GET['u'] : ''; ?>" class="form-control">
                                        <div class="row">
                                            <div class="col-12 col-md-12 col-lg-6">
                                                <div class="mb-1">
                                                    <label class="small text-secondary" for="">Postponed Date</label>
                                                    <input type="text" name="postponed_date" id="postponed_date" value="<?= date("Y-m-d") ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-6">
                                                <div class="mb-1">
                                                    <label class="small text-secondary" for="">Postponed Hour</label>
                                                    <select name="postponed_hour" id="postponed_hour" class="form-control">
                                                        <option value="00:00">00:00 WIB</option>
                                                        <option value="01:00">01:00 WIB</option>
                                                        <option value="02:00">02:00 WIB</option>
                                                        <option value="03:00">03:00 WIB</option>
                                                        <option value="04:00">04:00 WIB</option>
                                                        <option value="05:00">05:00 WIB</option>
                                                        <option value="06:00">06:00 WIB</option>
                                                        <option value="07:00">07:00 WIB</option>
                                                        <option value="08:00">08:00 WIB</option>
                                                        <option value="09:00" selected>09:00 WIB</option>
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
                                            <div class="col-12 col-md-12 col-lg-6">
                                                <div class="mb-1">
                                                    <label class="small text-secondary" for="postponed_note">Note</label>
                                                    <textarea name="postponed_note" id="postponed_note" class="form-control" cols="30" rows="3"></textarea>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-12 col-lg-6">
                                                <div class="mb-1">
                                                    <label class="small text-secondary" for="">Status</label>
                                                    <select class="form-control status_strategy" name="status" id="postponed_status">
                                                        <!-- <option value="" selected disabled>-- Pilih Status --</option>
                                                        <option value="1">Jalan Berhasil</option>
                                                        <option value="2">Jalan Tidak Berhasil</option>
                                                        <option value="3">Tidak Berjalan</option> -->
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-12 col-md-12 text-end">
                                                <div class="mb-1">
                                                    <button type="button" class="btn btn-theme text-white m-1" onclick="postpone_strategy()">Save</button>
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
                                        <tbody id="body_log_hitory_sub_task" class="body_log_hitory_sub_task">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link m-1" data-bs-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="d-none">
        <select id="id_type">
            <option value=""></option>
        </select>
        <select id="id_category">
            <option value=""></option>
        </select>
        <select id="id_object">
            <option value=""></option>
        </select>
        <select id="id_status">
            <option value=""></option>
        </select>
        <select id="id_pic">
            <option value=""></option>
        </select>
        <select id="e_id_status">
            <option value=""></option>
        </select>
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

    <script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>


    <?php $this->load->view('monday/details/js'); ?>

    <script>
        var currentDate = new Date();
        $('#postponed_date').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
            setDate: currentDate,
        });

        function show_modal_postpone(id_sub_task) {
            $('#modal_postpone').modal('show');
            show_log_history_sub_task(id_sub_task);
            get_status_strategy();
        }

        function postpone_strategy() {

            postponed_date = $('#postponed_date').val();
            postponed_hour = $('#postponed_hour').val();
            postponed_note = $('#postponed_note').val();
            postponed_status = $('#postponed_status :selected').val();

            if (postponed_date == '') {
                $.alert({
                    title: 'Postponed Date required!',
                    content: 'Please complete the data.',
                    type: 'orange',
                    buttons: {
                        'ok': function() {
                            $('#postponed_date').focus();
                        }
                    }
                });
            } else if (postponed_hour == '') {
                $.alert({
                    title: 'Postponed Hour required!',
                    content: 'Please complete the data.',
                    type: 'orange',
                    buttons: {
                        'ok': function() {
                            $('#postponed_hour').focus();
                        }
                    }
                });
            } else if (postponed_note == '') {
                $.alert({
                    title: 'Postponed Note required!',
                    content: 'Please complete the data.',
                    type: 'orange',
                    buttons: {
                        'ok': function() {
                            $('#postponed_note').focus();
                        }
                    }
                });
            } else if (postponed_status == '') {
                $.alert({
                    title: 'Postponed Status required!',
                    content: 'Please complete the data.',
                    type: 'orange',
                    buttons: {
                        'ok': function() {
                            $('#postponed_status').focus();
                        }
                    }
                });
            } else {

                form = $('#form_postpone');
                console.info(form.serialize());

                // $.confirm({
                //     title: 'Save Postpone Data',
                //     // content: 'Its smooth to do multiple confirms at a time. <br> Click confirm or cancel for another modal',
                //     icon: 'fa fa-question-circle',
                //     animation: 'scale',
                //     closeAnimation: 'scale',
                //     opacity: 0.5,
                //     buttons: {
                //         'confirm': {
                //             text: 'Proceed',
                //             btnClass: 'btn-blue',
                //             action: function(){
                //                 $.ajax({
                //                     url: "<?= base_url('ibr_update/postpone') ?>",
                //                     type: "POST",
                //                     dataType: 'json',
                //                     data: form.serialize(),
                //                     success: function(response){
                //                         location.reload();
                //                     }
                //                 })
                //             }
                //         },
                //         cancel: function(){
                //             $.alert('you clicked on <strong>cancel</strong>');
                //         },
                //     }
                // });

                $.confirm({
                    icon: 'fa fa-spinner fa-spin',
                    title: 'Please wait..',
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
                        // $('#modal_detail_task').modal('hide');

                        $.ajax({
                            url: `<?= base_url() ?>ibr_update/postpone`,
                            type: 'POST',
                            dataType: 'json',
                            data: form.serialize(),
                            beforeSend: function() {},
                            success: function(response) {},
                            error: function(xhr) {},
                            complete: function() {},
                        }).done(function(response) {
                            console.info(response)

                            setTimeout(() => {
                                location.reload()
                            }, 250);

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



        function modal_update_sub_task(id_sub_task, id_task) {
            $('#modal_detail_task').modal('hide');
            show_log_history_sub_task(id_sub_task);
            $('#u_history_sub_note').val('');
            $('#u_history_link_sub').val('');
            $('#u_history_sub_evaluasi').val('');
            let u_id_task = "";
            let u_sub_id_task = "";

            get_status_strategy();

            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: 'Please wait..',
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
                    $('#modal_detail_task').modal('hide');

                    $.ajax({
                        url: `<?= base_url() ?>monday/get_detail_sub_task`,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id_sub_task: id_sub_task,
                        },
                        beforeSend: function() {},
                        success: function(response) {},
                        error: function(xhr) {},
                        complete: function() {},
                    }).done(function(response) {
                        console.log(response.status)
                        console.log(response.detail)
                        if (response.status == true) {
                            setTimeout(() => {
                                jconfirm.instances[0].close();

                                $('#title_sub_task').text(response.detail.sub_task);
                                $('#u_id_sub_task').val(response.detail.id_sub_task);
                                $('#u_id_task').val(response.detail.id_task);
                                $('#u_ekspektasi').val(response.detail.ekspektasi);
                                $('#u_history_progress').val(response.detail.progress);
                                $('#u_week_number').val(response.detail.week_number);
                                $('#u_week_start_date').val(response.detail.week_start_date);
                                $('#u_week_end_date').val(response.detail.week_end_date);
                                $('#u_jam_notif').val(response.detail.jam_notif);
                                $('#modal_update_sub_task').modal('show');


                                $('#id_type_goals').val(response.detail.id_type_goals);
                                if (response.detail.id_type_goals == 2) {
                                    $('#div_u_history_sub_note').addClass('d-none')
                                } else {
                                    $('#div_u_history_sub_note').removeClass('d-none')
                                }
                            }, 250);
                        } else {
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-check',
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

        function get_status_strategy(){
            var option = `<option value="" selected disabled>-- Pilih Status --</option>`;
            $.ajax({
                url: '<?= base_url('ibr_update/get_status_strategy') ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response){
                    response.forEach((value, index) => {
                        option += `<option value="${value.id}">${value.status}</option>`
                    });
                },
                complete: function(setting, response){
                    $(".status_strategy").html(option);
                }
            })
        }

        function close_update_sub_task() {
            u_close_id_task = $('#u_id_task').val();
            $('#modal_update_sub_task').modal('hide');
        }

        function show_log_history_sub_task(id_sub_task) {
            body_log_hitory = '';
            base_url = "http://trusmiverse.com/hr/uploads/profile";
            $.ajax({
                url: "<?= base_url('monday/log_history_sub_task') ?>",
                type: 'POST',
                dataType: 'json',
                data: {
                    id_sub_task: id_sub_task,
                },
                beforeSend: function() {
                    $('#spinner_loading_sub_task').show();
                },
                success: function(response) {
                    // console.info(response)
                    if (response.log.length > 0) {
                        response.log.forEach((value, index) => {
                            if (value.type_history == 'file') {
                                ket_his = `<a href="<?= base_url() ?>/uploads/monday/history_sub_task/${value.keterangan}" target="_blank">${value.keterangan}</a>`
                            } else if (value.type_history == 'link') {
                                ket_his = `<a href="${value.keterangan}" target="_blank">Go To Link..</a>`
                            } else {
                                ket_his = value.keterangan;
                            }
                            body_log_hitory +=
                                `<tr>
                            <td><small>${calculate_time_history_log_sub_task(value.created_at)}</small></td>
                            <td>
                                <div class="avatar avatar-30 coverimg rounded-circle me-1"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="${value.pic}">
                                    <img src="${base_url}/${value.photo}" alt="">
                                </div>
                            </td>
                            <td><small>${get_jenis_log_sub_task(value.type_history)}</small></td>
                            <td><small>${ket_his}<small></td>
                        </tr>`
                        });
                    } else {
                        body_log_hitory += `<tr>
                                         <td colspan="3" class="text-center">No Activity Log</td>
                                    </tr>`
                    }
                    $('.body_log_hitory_sub_task').html(body_log_hitory)
                },
                complete: function() {
                    setTimeout(() => {
                        $('#spinner_loading_sub_task').hide();
                    }, 500);
                }
            })
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

            let val_id_type_goals = $('#id_type_goals').val();
            var user_id = $('#user_id').val();

            let status = $('#status :selected').val();
            let file_data = $("#u_history_file_sub").prop("files")[0];

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
            } else if (val_u_history_sub_note == "" && val_id_type_goals == 1) {
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
            } else if (val_u_history_sub_evaluasi == "" && val_id_type_goals == 2) {
                $.confirm({
                    icon: 'fa fa-close',
                    title: 'Oops!',
                    theme: 'material',
                    type: 'red',
                    content: 'Oops, evaluasi must be choosed',
                    buttons: {
                        close: {
                            actions: function() {}
                        },
                    },
                });
            } else if (val_u_history_link_sub === "" && (!file_data || file_data === '')) {
                $.confirm({
                    icon: 'fa fa-close',
                    title: 'Oops!',
                    theme: 'material',
                    type: 'red',
                    content: 'Oops, file atau link harus di isi salah satu',
                    buttons: {
                        close: {
                            actions: function() {}
                        },
                    },
                });
            } else if(status == ''){
                $.confirm({
                    icon: 'fa fa-close',
                    title: 'Oops!',
                    theme: 'material',
                    type: 'red',
                    content: 'Oops, Status must be choosed',
                    buttons: {
                        close: {
                            actions: function() {}
                        },
                    },
                });

            } else {

                
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
                form_data_sub.append("status", status);
                form_data_sub.append("user_id", user_id);

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
                                    }, 1000);
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

        function detail_task(id_task) {

            $('#id_task_new_strategy').val(id_task)
            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: 'Please wait..',
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
                        url: `<?= base_url() ?>monday/get_detail_task`,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id_task: id_task
                        },
                        beforeSend: function() {

                        },
                        success: function(response) {},
                        error: function(xhr) {},
                        complete: function() {},
                    }).done(function(response) {
                        // console.log(response.status)
                        // console.log(response.detail)
                        if (response.status == true) {
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                $('#modal_detail_task').modal('show');
                                // show_detail(id_task)
                                dt_detail_sub_task(id_task);
                                get_timeline(id_task);
                                $('#modal_detail_taskLabel').text(response.detail.task);

                                // $('#start_timeline').val(response.detail.start);
                                // $('#end_timeline').val(response.detail.end);
                                $('#e_note').text(response.detail.note);
                                $('#e_progress').val(response.detail.progress);
                                // console.log(Math.round(response.detail.progress * 100) / 100)

                                $('#e_valuation').text(response.detail.evaluation);

                                $('#e_id_task').val(response.detail.id_task);
                                $('#e_task').val(response.detail.task);
                                $('#e_task_text').text(response.detail.task);

                                $('#e_description_div').html(response.detail.description);
                                $('#e_indicator_div').html(response.detail.indicator);
                                $('#e_strategy_div').html(response.detail.strategy);

                                // priority
                                if (response.detail.id_priority == 1) {
                                    prior_class = ` bg-light-blue text-blue`
                                } else if (response.detail.id_priority == 2) {
                                    prior_class = `bg-light-purple text-purple`
                                } else if (response.detail.id_priority == 3) {
                                    prior_class = `bg-light-cyan text-cyan`
                                } else if (response.detail.id_priority == 3) {
                                    prior_class = `bg-light-cyan text-cyan`
                                } else if (response.detail.id_priority == 4) {
                                    prior_class = `bg-light-green text-green`
                                } else {
                                    prior_class = `bg-light text-light`
                                }
                                $('#e_priority_text').addClass(prior_class);
                                $('#e_priority_text').text(response.detail.priority);
                                if (response.detail.jenis_strategy == "Once") {
                                    jenis_strategy_class = ` bg-light-green text-green`
                                } else {
                                    jenis_strategy_class = `bg-light-red text-red`
                                }
                                $('#e_jenis_strategy_text').addClass(jenis_strategy_class);
                                $('#e_jenis_strategy_text').text(response.detail.jenis_strategy);

                                due_div_el = `
                            <span class="btn btn-sm btn-link ${response.detail.due_date_style} ${response.detail.due_date_style_text}"><i class="text-theme bi bi-calendar-date"></i> ${response.detail.due_date}</span>
                            <span class="btn btn-sm btn-link ${response.detail.due_date_style} ${response.detail.due_date_style_text}"><i class="bi bi-clock-history"></i> ${response.detail.due_date_text}</span>
                            `
                                $('#e_due_date_div').html(due_div_el);
                                $('#e_pic_text').text(response.detail.team_name);
                                $('#e_id_status').val(response.detail.id_status);
                                if (response.detail.id_status > 1) {
                                    $('#e_id_status option[value="' + 1 + '"]').attr("disabled", true);
                                }
                                e_sel_id_status.update();

                                page_uri = "<?= $this->uri->segment(1); ?>";
                                if (page_uri == "kanban") {
                                    detail_status_after = $('#detail_status_after').val();
                                    if (detail_status_after != "") {
                                        $('#e_id_status').val(detail_status_after);
                                        if (detail_status_after > 1) {
                                            $('#e_id_status option[value="' + 1 + '"]').attr("disabled", true);
                                        }
                                        e_sel_id_status.update();
                                    }
                                }

                            }, 250);
                            // setTimeout(() => {
                            //     jconfirm.instances[0].close();
                            // }, 750);
                        } else {
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-check',
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


        function calculate_time_history_log_sub_task(time_string) {
            var targetDate = new Date(time_string);
            var currentDate = new Date();
            var timeDifference = currentDate - targetDate;
            var daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
            var hoursDifference = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var monthDifference = (currentDate.getMonth() + 1) - (targetDate.getMonth() + 1);
            var yearDifference = currentDate.getFullYear() - targetDate.getFullYear();

            if (yearDifference > 0) {
                // return `<i class="bi bi-clock"></i> ${yearDifference}y`
                return `<small>${convert_duedate(time_string)}</small>`
            } else if (monthDifference > 0) {
                // return `<i class="bi bi-clock"></i> ${monthDifference}m`
                return `<small>${convert_duedate(time_string)}</small>`
            } else if (daysDifference > 0) {
                // return `<i class="bi bi-clock"></i> ${daysDifference}d`
                return `<small>${convert_duedate(time_string)}</small>`
            } else if (hoursDifference > 0) {
                return `<i class="bi bi-clock"></i> ${hoursDifference}h`
                // return `<small>${convert_duedate(time_string)}</small>`
            } else {
                timeOnly = time_string.split(' ')[1].substring(0, 5);
                // const hours = parseInt(timeOnly.split(':')[0]);
                // let meridiem = 'am';
                // if (hours >= 12) {
                //     meridiem = 'pm';
                // }
                // return `${timeOnly} ${meridiem}`
                return convertTo12HourFormat(timeOnly);
            }
        }

        function get_jenis_log_sub_task(jenis) {
            if (jenis == 'created') {
                jenis_log = `<i class="bi bi-pen"></i> Created`
            } else if (jenis == 'progress') {
                jenis_log = `<i class="bi bi-percent text-success"></i> Progress`
            } else if (jenis == 'status') {
                jenis_log = `<img class="status_img" src="<?= base_url() ?>/assets/img/color_status.png" style="max-width:8%; height:auto"> Status`
            } else if (jenis == 'evaluasi') {
                jenis_log = `<i class="bi bi-clipboard-data"></i> Evaluasi`
            } else if (jenis == 'note') {
                jenis_log = `<i class="bi bi-chat-right-text"></i> Note`
            } else if (jenis == 'file') {
                jenis_log = `<i class="bi bi-image"></i> File`
            } else if (jenis == 'link') {
                jenis_log = `<i class="bi bi-link-45deg"></i> Link`
            } else {
                jenis_log = ``
            }
            return jenis_log;
        }

        function convertTo12HourFormat(time24) {
            // Extract hours and minutes from the time string
            const [hours, minutes] = time24.split(':');

            // Convert hours to 12-hour format
            const hours12 = hours % 12 || 12; // If hours is 0, convert to 12

            // Determine if it's AM or PM
            const period = hours < 12 ? 'am' : 'pm';

            // Create the 12-hour time string
            const time12 = `${String(hours12).padStart(2, '0')}:${minutes} ${period}`;

            return time12;
        }


        function dt_detail_sub_task(id_task) {
            $('#dt_detail_sub_task').DataTable({
                "searching": false,
                "info": false,
                "paging": false,
                "destroy": true,
                "bSort": false,
                "order": [],
                "ajax": {
                    "dataType": 'json',
                    "type": "POST",
                    "data": {
                        id_task: id_task
                    },
                    "url": "<?= base_url(); ?>monday/dt_sub_task",
                },
                "columns": [{
                    "data": "sub_task",
                    "render": function(data, type, row, meta) {
                        if (row['id_type'] == 1) {
                            type_style = 'bg-light-blue text-dark'
                        } else if (row['id_type'] == 2) {
                            type_style = 'bg-light-yellow text-dark'
                        } else if (row['id_type'] == 2) {
                            type_style = 'bg-light-green text-dark'
                        } else if (row['id_type'] == 3) {
                            type_style = 'bg-light-red text-dark'
                        } else {
                            type_style = 'bg-light-purple text-dark'
                        }
                        if (row['jml_progress'] <= 60) {
                            progress_style = 'bg-red text-white'
                        } else if (row['jml_progress'] <= 85 && row['jml_progress'] > 60) {
                            progress_style = 'bg-yellow text-white'
                        } else if (row['jml_progress'] > 85 && row['jml_progress'] < 100) {
                            progress_style = 'bg-blue text-white'
                        } else {
                            progress_style = 'bg-green text-white'
                        }
                        if (row['consistency'] <= 60) {
                            consistency_style = 'bg-red text-white'
                        } else if (row['consistency'] <= 85 && row['consistency'] > 60) {
                            consistency_style = 'bg-yellow text-white'
                        } else if (row['consistency'] > 85 && row['consistency'] < 100) {
                            consistency_style = 'bg-blue text-white'
                        } else {
                            consistency_style = 'bg-green text-white'
                        }
                        if (row['id_status'] == 1) {
                            button_update_sub = `<a role="button" class="btn btn-sm btn-link bg-secondary text-white" disabled>${row['status']}</a>`
                        } else if (row['id_status'] == 3) {
                            button_update_sub = `<a role="button" class="btn btn-sm btn-link bg-green text-white" disabled>${row['status']}</a>`
                        } else {
                            button_update_sub = `<a role="button" class="btn btn-sm btn-link bg-warning text-white" onclick="modal_update_sub_task('${row['id_sub_task']}','${row['id_task']}')">Update</a>`
                        }

                        component_day = ''
                        if (row['day_per_week'].indexOf(',') > -1) {
                            array_day = row['day_per_week'].split(',');
                            for (let index = 0; index < array_day.length; index++) {
                                if (array_day[index] == 0) {
                                    component_day += `<span class="badge m-1 ${type_style}">Sunday</span>`
                                }
                                if (array_day[index] == 1) {
                                    component_day += `<span class="badge m-1 ${type_style}">Monday</span>`
                                }
                                if (array_day[index] == 2) {
                                    component_day += `<span class="badge m-1 ${type_style}">Tuesday</span>`

                                }
                                if (array_day[index] == 3) {
                                    component_day += `<span class="badge m-1 ${type_style}">Wednesday</span>`
                                }
                                if (array_day[index] == 4) {
                                    component_day += `<span class="badge m-1 ${type_style}">Thursday</span>`
                                }
                                if (array_day[index] == 5) {
                                    component_day += `<span class="badge m-1 ${type_style}">Friday</span>`
                                }
                                if (array_day[index] == 6) {
                                    component_day += `<span class="badge m-1 ${type_style}">Saturday</span>`
                                }

                            }
                        }

                        return `<div class="align-items-center">
                                <div class="col-auto ps-0">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <p class="mb-1"><b>${row['sub_task']}</b></p>
                                        </div>
                                        <div class="col-12 col-md-6 text-md-end">
                                            ${button_update_sub}
                                        </div>
                                    </div>
                                    <hr style="margin-top:3px;margin-bottom:3px;">
                                    <div class="row">
                                        <div class="col-12 col-md-8">
                                            <span class="badge m-1 ${type_style}">${row['sub_type']}</span> <span class="badge ${progress_style}">Progress : ${row['jml_progress']}%</span> <span class="badge ${consistency_style}">Consistency : ${row['consistency']}%</span> <br> ${component_day}
                                        </div>
                                        <div class="col-12 col-md-4 text-md-end">
                                            <span class="badge m-1 ${type_style}">${row['periode']}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>`
                    }
                }, ],
                "initComplete": function(settings, json) {
                    console.log(json.data)
                    if (json.data.length > 0) {
                        progress_sum = 0;
                        consistency_sum = 0;
                        jml_data = 0;
                        for (let index = 0; index < json.data.length; index++) {
                            progress_sum = progress_sum + parseInt(json.data[index].jml_progress);
                            consistency_sum = consistency_sum + parseInt(json.data[index].consistency);
                            jml_data = jml_data + parseInt(1);
                        }

                        // console.log(progress_sum);
                        // console.log(jml_data);
                        average_progress = (parseFloat(progress_sum) / parseFloat(jml_data));
                        average_consistency = (parseFloat(consistency_sum) / parseFloat(jml_data));
                        // console.log((parseFloat(progres_sum) / parseFloat(jml_data)));
                        // console.log(Math.round(average_progress));
                        percent_progres = Math.round(average_progress * 1) / 100;
                        percent_consistency = Math.round(average_consistency * 1) / 100;
                        // console.log(percent_progres);
                        $('#e_progress').val(Math.round(average_progress * 100) / 100);
                        $('#div_e_progress').empty().append(`
                            <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: ${Math.round(average_progress * 1) / 1}%;" aria-valuenow="${Math.round(average_progress * 1) / 1}" aria-valuemin="0" aria-valuemax="100">${Math.round(average_progress * 1) / 1}%</div>
                            </div>`);
                    } else {
                        $('#e_progress').val(0)
                        percent_progres = 0;
                        percent_consistency = 0;
                    }
                    $('#progress_goals_strategy').empty();
                    // console.log(percent_progres)
                    setTimeout(() => {
                        intialize_progres_bar_table(`progress_goals_strategy`).animate(percent_consistency.toString());
                    }, 250);
                }
            });
        }

        function convert_duedate(dateString) {
            var dateObject = new Date(dateString);
            var monthNames = [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ];
            var day = dateObject.getDate();
            var month = monthNames[dateObject.getMonth()];
            var formattedDate = day + ' ' + month;
            return formattedDate;
        }
    </script>

</body>

</html>