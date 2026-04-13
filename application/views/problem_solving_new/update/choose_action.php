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
    <link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.css" />

    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" />

    <link href="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/dropdown.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/nice-select2/css/nice-select2.css" />
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

        .bd-callout {
            --bs-link-color-rgb: var(--bd-callout-link);
            --bs-code-color: var(--bd-callout-code-color);
            padding: 1.25rem;
            margin-top: 1.25rem;
            margin-bottom: 1.25rem;
            color: var(--bd-callout-color, inherit);
            background-color: var(--bd-callout-bg, var(--bs-gray-100));
            border-left: .25rem solid var(--bd-callout-border, var(--bs-gray-300));
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
                                        <h5 class="fw-normal text-dark">Problem Solving</h5>
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
                    <div class="col-lg-8">
                        <div class="card bg-blur">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-auto">
                                        <img src="<?= base_url(); ?>assets/img/logo_trusmiverse.png" alt="" />
                                    </div>
                                    <div class="col ">
                                        <h5 class="fw-normal">Problem Solving Update</h5>
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
                                                <div class="col-lg-4 text-center position-relative py-4">
                                                    <img class="avatar avatar-100 coverimg mb-3 rounded-circle" src="<?= $task['pic_photo'] ?>" alt="" />

                                                    <h5 class="text-truncate mb-0"><?= $task['pic_name'] ?></h5>
                                                    <p class="text-secondary small mb-1"><?= $task['pic_designation'] ?></p>
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
                                                <div class="col-lg-8 col-md-6 col-sm-12 align-self-center py-1">
                                                <div class="row mb-3">
                                                    <div class="col-md-6 mb-2">
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <i class="bi bi-building h5 avatar avatar-40 bg-primary text-white rounded"></i>
                                                            </div>
                                                            <div class="col">
                                                                <h6 class="fw-medium mb-0" id="detail_department"><?=$task['department_name']?></h6>
                                                                <p class="text-secondary small">Divisi</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if (!is_null($task['id_project'])) : ?>
                                                    <div class="col-md-6 mb-2">
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <i class="bi bi-house-fill h5 avatar avatar-40 bg-info text-white rounded"></i>
                                                            </div>
                                                            <div class="col">
                                                                <h6 class="fw-medium mb-0" id="detail_project"><?=$task['project']?></h6>
                                                                <p class="text-secondary small">Project</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endif; ?>
                                                    <div class="col-md-6 mb-2">
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <i class="bi bi-card-list h5 avatar avatar-40 bg-info text-white rounded"></i>
                                                            </div>
                                                            <div class="col">
                                                                <h6 class="fw-medium mb-0" id="detail_category_new"><?=$task['category_new']?></h6>
                                                                <p class="text-secondary small">Category</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <i class="bi bi-bounding-box-circles h5 avatar avatar-40 bg-warning text-white rounded"></i>
                                                            </div>
                                                            <div class="col">
                                                                <h6 class="fw-medium mb-0" id="detail_category"><?=$task['category']?></h6>
                                                                <p class="text-secondary small">Factor</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <i class="bi bi-bell h5 avatar avatar-40 bg-warning text-white rounded"></i>
                                                            </div>
                                                            <div class="col">
                                                                <h6 class="fw-medium mb-0" id="detail_priority"><?=$task['priority']?></h6>
                                                                <p class="text-secondary small">Priority</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <i class="bi bi-person-fill h5 avatar avatar-40 bg-primary text-white rounded"></i>
                                                            </div>
                                                            <div class="col">
                                                                <h6 class="fw-medium mb-0" id="detail_pic"><?=$task['created_by']?></h6>
                                                                <p class="text-secondary small">Created By</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <i class="bi bi-calendar-event h5 avatar avatar-40 bg-danger text-white rounded"></i>
                                                            </div>
                                                            <div class="col">
                                                                <h6 class="fw-medium mb-0" id="detail_deadline">
                                                                    <?=$task['deadline_solution'] == null ? $task['deadline'] : $task['deadline_solution'] ?>
                                                                </h6>
                                                                <p class="text-secondary small">Deadline</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                    <div class="row">

                                                        <div class="col-12 align-self-center py-1">

                                                            <div class="row pt-2">
                                                                <div class="col-md-12 mb-2">
                                                                    <p>Problem Deskripsi</p>
                                                                    <div class="bd-callout bg-warning"> <h6 id="problem_desc"><?=$task['problem']?></h6> </div>
                                                                </div>
                                                                <div class="col-md-12 mb-2">
                                                                    <p>Yang sudah dilakukan</p>
                                                                    <div class="bd-callout bg-warning"> <h6 id="solving_desc"><?=$task['solving']?></h6> </div>
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
                                        <div class="col f-btn text-center p-t-15 p-b-15">
                                        <?php if ($task['status_id'] != 3) : ?>
                                            <button id="btn_update" class="btn btn-theme" style="width:100%" onclick="modal_update_ps('<?= $_GET['id'] ?>')">
                                                <i class="bi bi-clipboard-check vm me-2"></i>
                                                <small>Update</small>
                                            </button>
                                        <?php endif; ?>
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


    <div class="modal fade" id="modal_update_ps" tabindex="-1" aria-labelledby="modalListProsesLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header row align-items-center bg-theme">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light text-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_update_psLabel">Update Proses Problem Solving</h6>
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
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <h6 class="title">Detail <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-building h5 avatar avatar-40 bg-primary text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_department_form">...</h6>
                                    <p class="text-secondary small">Divisi</p>
                                </div>
                            </div>
                        </div>
                        <?php if (!is_null($task['id_project'])) : ?>
                        <div class="col-md-3 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-house-fill h5 avatar avatar-40 bg-info text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_project_form">...</h6>
                                    <p class="text-secondary small">Project</p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="col-md-3 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-card-list h5 avatar avatar-40 bg-info text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_category_new_form">...</h6>
                                    <p class="text-secondary small">Category</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-bounding-box-circles h5 avatar avatar-40 bg-warning text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_category_form">...</h6>
                                    <p class="text-secondary small">Factor</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-bell h5 avatar avatar-40 bg-warning text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_priority_form">...</h6>
                                    <p class="text-secondary small">Priority</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-person-fill h5 avatar avatar-40 bg-primary text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_pic_form">...</h6>
                                    <p class="text-secondary small">Created By</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-calendar-event h5 avatar avatar-40 bg-danger text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_deadline_form">...</h6>
                                    <p class="text-secondary small">Deadline</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                        <form id="form_proses_resume">
                            <input type="hidden" id="id_ps" name="id_ps">
                            <input type="hidden" id="user_id" name="user_id">
                            <input type="hidden" id="department_id_proses">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <p>Problem Deskripsi</p>
                                <div class="bd-callout bg-warning"> <h6 id="problem_desc_form">..</h6> </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <p>Yang sudah dilakukan</p>
                                <div class="bd-callout bg-warning"> <h6 id="solving_desc_form">..</h6> </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <label>Solution <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                    <textarea name="resume" id="resume" cols="30" rows="10" class="form-control border-start-0"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-folder"></i></span>
                                        <div class="form-floating">
                                            <input type="file" accept="application/pdf, .pdf, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, image/jpg, image/png, image/jpeg" id="lampiran" class="form-control lampiran" name="lampiran">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <label>Link </label>
                                    <div class="input-group">
                                        <input type="text" name="link_solution" id="link_solution" class="form-control" placeholder="https://example.com">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-md-4 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-check-square"></i></span>
                                        <div class="form-floating">
                                            <select name="status_akhir" id="status_akhir" class="form-control" onchange="show_tindakan()">
                                                <option value="#">-- Choose Status --</option>
                                                <?php foreach ($status as $sts) : ?>
                                                    <option value="<?= $sts->id; ?>"><?= $sts->status; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>Status <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <?php //if ($task['is_pic'] == true) : ?>
                            <div id="show_tindakan" class="">
                                <h6 class="title"><input type="checkbox" name="check_tindakan" id="check_tindakan"> <label for="check_tindakan">Tindakan?</label></h6>
                                <div class="row div_check_tindakan" style="display: none;">
                                    <p>* Ceklis Tindakan akan membuat tasklist ke IBR Pro</p>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-group mb-1 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-list"></i></span>
                                                <div class="form-floating">
                                                    <select name="tindakan" id="tindakan" class="form-control">
                                                        <option value="Eskalasi">Eskalasi</option>
                                                        <option value="Delegasi">Delegasi</option>
                                                    </select>
                                                    <label>Tindakan</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill-check"></i></span>
                                                <div class="form-floating">
                                                    <select name="delegate_escalate_to" id="delegate_escalate_to" class="form-control">
                                                        <option value="#">-Choose PIC-</option>
                                                    </select>
                                                    <label>Degelasi/Eskalasi <i class="text-danger">*</i></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-event"></i></span>
                                                <div class="form-floating">
                                                    <input type="text" class="form-control border-start-0 bg-white" name="deadline_solution" id="deadline_solution" readonly>
                                                    <label>Deadline <i class="text-danger">*</i></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                                <div class="form-floating">
                                                    <label>Tasklist <i class="text-danger">*</i></label>
                                                </div>
                                            </div>
                                            <textarea name="tasklist" id="tasklist" cols="30" rows="10" class="form-control border-start-0"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <?php //endif; ?>
                        </form>
                </div>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <?php if ($task['status_id'] != 3) : ?>
                    <button type="button" class="btn btn-md btn-outline-theme ms-2" onclick="save_proses_resume()" id="btn_save_proses_resume">Save</button>
                    <?php endif; ?>
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

    <!-- swiper js script -->
    <script src="<?= base_url() ?>assets/vendor/swiper-7.3.1/swiper-bundle.min.js"></script>

    <script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>

    <!-- Jquery Confirm -->
    <script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>

    <script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>

    <script src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>
    <script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>

    <script>
        var currentDate = new Date();
        $(document).ready(function() {
            // delegate = new SlimSelect({
            //     select: "#delegate_escalate_to"
            // });
            $('#deadline_solution').datetimepicker({
                format: 'Y-m-d',
                timepicker: false,
                minDate: 0,
            });

            $('#resume').summernote({
                placeholder: '...',
                tabsize: 2,
                height: 150,
                toolbar: [
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                ]
            });

            $('#tasklist').summernote({
                placeholder: '...',
                tabsize: 2,
                height: 150,
                toolbar: [
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                ]
            });
        });
        $('#check_tindakan').val(0);
        $('#check_tindakan').change(function() {
            if ($(this).is(':checked')) {
            $('.div_check_tindakan').show();
            $(this).val('1');
            } else {
            $('.div_check_tindakan').hide();
            $(this).val('0');
            }
        });

        function modal_update_ps(id) {
            $("#modal_update_ps").modal("show");
            $("#id_ps").val(id);
            $("#user_id").val("<?= $_GET['u'] ?>");
            get_detail_problem(id);
            setTimeout(() => {
                get_pic_delegate();
            }, 300);
        }

        function get_pic_delegate() {
            department_id = $('#department_id_proses').val();
            if (department_id != null) {
                $.ajax({
                    url: "<?= base_url('problem_solving_new/get_pic') ?>",
                    method: "POST",
                    data: {
                        department_id: department_id
                    },
                    dataType: "JSON",
                    success: function(res) {
                        console.log(res);
                        let pic = '<option selected disabled>-Choose PIC-</option>';
                        res.pic.forEach((value, index) => {
                            pic += `<option value = "${value.user_id}"> ${value.employee_name}</option>`;
                        })
                        $('#delegate_escalate_to').html(pic);
                        setTimeout(() => {
                            delegate = NiceSelect.bind(document.getElementById('delegate_escalate_to'), {
                                searchable: true
                            });
                        }, 400);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                })
            }
        }

        function get_detail_problem(id) {
            $.ajax({
            method: "GET",
            url: "<?= base_url("problem_solving_update/get_detail_problem/") ?>" + id,
            dataType: "JSON",
            success: function(res) {
                // console.log(res);
                $("#detail_category_new_form").text(res.category_new);
                $("#detail_category_form").text(res.category);
                $("#detail_priority_form").text(res.priority);
                $("#detail_deadline_form").text(res.deadline);
                $("#detail_department_form").text(res.department_name);
                $("#detail_project_form").text(res.project);
                $("#detail_pic_form").text(res.created_by);
                $("#problem_desc_form").html(res.problem);
                $("#solving_desc_form").html(res.solving);
                $("#department_id_proses").val(res.department_id);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
                jconfirm.instances[0].close();
            }
            });
        }

        function show_tindakan()
        {
            if ($('#status_akhir').val() < 3) {
            $('#show_tindakan').removeClass('d-none');
            } else {
            $('#show_tindakan').addClass('d-none');
            }
        }

        function save_proses_resume() {
            id_ps = $("#id_ps").val();
            user_id = $("#user_id").val();
            // status = $("#status_akhir ").val();
            resume = $("#resume").val();
            check_tindakan = $("#check_tindakan").val();

            // if (status == '#') {
            // $.confirm({
            //     icon: 'fa fa-times-circle',
            //     title: 'Warning',
            //     theme: 'material',
            //     type: 'red',
            //     content: 'Status is empty!',
            //     buttons: {
            //     close: {
            //         actions: function() {}
            //     },
            //     },
            // });
            // } else 
            if (resume == "" || resume == '<p><br></p>' || resume == '<br>' || resume == '<p>&nbsp;</p>') {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Solution is empty!',
                buttons: {
                close: {
                    actions: function() {}
                },
                },
            });
            } else if ($('#check_tindakan').is(':checked') && ($("#tasklist").val() == "" || $("#tasklist").val() == '<p><br></p>' || $("#tasklist").val() == '<br>' || $("#tasklist").val() == '<p>&nbsp;</p>')) {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Tasklist is empty!',
                buttons: {
                close: {
                    actions: function() {}
                },
                },
            });
            } else {
            let lampiran = $(`#lampiran`).prop("files")[0];
            link_solution = $("#link_solution").val();
            let form_proses = new FormData();
            form_proses.append("user_id", user_id);      
            form_proses.append("id_ps", id_ps);
            form_proses.append("resume", resume);
            // form_proses.append("status_akhir", status);
            form_proses.append("link_solution", link_solution);
            form_proses.append("files", lampiran);
            form_proses.append("check_tindakan", check_tindakan);
            if (check_tindakan == 1) {
                form_proses.append("tindakan", $("#tindakan").val());
                form_proses.append("tasklist", $("#tasklist").val());
                form_proses.append("delegate_escalate_to", $("#delegate_escalate_to").val());
                form_proses.append("deadline_solution", $("#deadline_solution").val());
            }

            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: 'Please wait!',
                theme: 'material',
                type: 'blue',
                content: 'Processing...',
                buttons: {
                close: {
                    isHidden: true,
                    actions: function() {}
                },
                },
                onOpen: function() {
                $.ajax({
                    method: "POST",
                    url: "<?= base_url("problem_solving_update/save_proses_resume") ?>",
                    dataType: "JSON",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_proses,
                    // data: $("#form_proses_resume").serialize(),
                    beforeSend: function(res) {
                    $("#btn_save_proses_resume").attr("disabled", true);
                    },
                    success: function(res) {
                    console.log(res);
                    $.confirm({
                        icon: 'fa fa-check',
                        title: 'Success',
                        theme: 'material',
                        type: 'green',
                        content: 'Data has been saved!',
                        buttons: {
                        close: {
                            actions: function() {}
                        },
                        },
                    });
                    $("#form_proses_resume")[0].reset();
                    $("#btn_save_proses_resume").removeAttr("disabled");
                    $('#resume').summernote('reset');
                    $('#tasklist').summernote('reset');
                    // $('#pembahasan_draft').summernote('code', dt.pembahasan);
                    jconfirm.instances[0].close();
                    setTimeout(() => {
                        window.location = '<?= base_url() ?>problem_solving_new';
                    }, 500);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseText);
                    jconfirm.instances[0].close();
                    }
                });
                }
            });
            }
        }
    </script>

</body>

</html>