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

    <!-- page loader ends -->

    <!-- background -->
    <div class="coverimg w-100 top-0 start-0 main-bg">
        <div class="bg-blur main-bg-overlay"></div>
        <img src="<?= base_url(); ?>assets/img/bg-19.jpg" alt="" style="width: 100%; height:700px; object-fit: cover;" />
    </div>
    <!-- background ends  -->

    <!-- Begin page content -->
    <main class="main h-100 container-fluid bg-blur">
        <!-- image swiper -->
        <div class="swiper image-swiper h-100 w-100 position-absolute z-index-0 start-0 top-0">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="coverimg w-100 top-0 start-0 position-absolute">
                        <img src="<?= base_url(); ?>assets/img/bg-19.jpg" alt="" style="width: 100%; height:700px; object-fit: cover;" />
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
                                    <div class="col-auto"><img src="<?= base_url(); ?>assets/img/logo_trusmiverse.png" class="mx-100" alt="" /></div>
                                    <div class="col ps-0 align-self-center">
                                        <h5 class="fw-normal text-white">Trusmiverse</h5>
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
            <div class="col-12  align-self-start pb-4 pt-1">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-11 col-lg-10 col-xl-7 col-xxl-6">
                        <div class="card bg-blur">
                            <?php if ($ticket['status'] == 12 && ($session == $ticket['created_by'] || ($session == 476 && $ticket['type'] == 3))) { ?>
                                <div class="card-header bg-info">
                                    <div class="row">
                                        <div class="col-auto align-self-center text-center">
                                            <h5 class="fw-bold text-white">UAT (User Acceptance Testing)</h5>
                                        </div>
                                    </div>
                                    <p class="text-white">Your ticket is complete. Please review it at your earliest convenience.</p>
                                    <hr style="margin: 0px; color:white">
                                </div>
                                <div class="card-body">
                                    <form id="form_input_uat">
                                        <input type="hidden" id="id_ticket" name="id_ticket" readonly value="<?= $ticket['id_task'] ?>">
                                        <input type="hidden" id="status_before" name="status_before" readonly value="<?= $ticket['status'] ?>">
                                        <input type="hidden" id="progress" name="progress" readonly value="<?= $ticket['progress'] ?>">
                                        <div class="row mb-4">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <label for="title" class="form-label-custom"><b>Ticket Title</b></label>
                                                <input type="text" class="form-control border-custom" id="title" value="<?= $ticket['task'] ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <label for="description" class="form-label-custom"><b>Ticket Description</b></label>
                                                <textarea type="text" class="form-control border-custom" id="description" readonly><?= $ticket['description'] ?></textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <label for="note_uat" class="form-label-custom"><b>UAT Note</b></label>
                                                <textarea type="text" class="form-control border-custom" id="note_uat" readonly><?= $ticket['note'] ?></textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                                <label for="done_date" class="form-label-custom"><b>Due Date UAT</b></label>
                                                <input type="text" class="form-control border-custom" id="done_date" value="<?= $ticket['uat_leadtime'] ?>" readonly>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                                <label for="pic" class="form-label-custom"><b>PIC</b></label>
                                                <input type="text" class="form-control border-custom" id="pic" value="<?= $ticket['pic'] ?>" readonly>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                                <label for="user" class="form-label-custom"><b>User</b></label>
                                                <input type="text" class="form-control border-custom" id="user" value="<?= $ticket['requester'] ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <label for="note" class="form-label-custom"><b>Note</b><small class="text-danger">*</small></label>
                                                <textarea name="note" id="note" class="form-control border-custom" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                                <label for="attachment" class="form-label-custom"><b>Files</b></label>
                                                <input type="file" name="attachment" class="form-control border-custom" id="attachment">
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="col-12">
                                                    <label class="form-label-custom"><b>Status</b><small class="text-danger">*</small></label>
                                                </div>
                                                <!-- <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                                    <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" value="1">
                                                    <label class="btn btn-outline-primary" for="btnradio1">Sesuai</label>
                                                    <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off" value="0">
                                                    <label class="btn btn-outline-danger" for="btnradio2" id="label_btn_radio2">Tidak Sesuai</label>
                                                </div> -->
                                                <div class="col-12 d-flex align-items-center">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="btnradio" id="inlineRadio1" value="1">
                                                        <label class="form-check-label" for="inlineRadio1">Sesuai</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="btnradio" id="inlineRadio2" value="0">
                                                        <label class="form-check-label" for="inlineRadio2">Tidak Sesuai</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-end">
                                                <button class="btn btn-primary" id="btn_save_uat">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php } else if ($ticket['status'] == 12 && ($session != $ticket['created_by'])) { ?>
                                <div class="card-header bg-info">
                                    <div class="row">
                                        <div class="col-auto align-self-center text-center">
                                            <h5 class="fw-bold text-white">UAT (User Acceptance Testing)</h5>
                                        </div>
                                    </div>
                                    <p class="text-white">Sorry, The Ticket you're trying to access is <span class="fw-bolder">not yours</span>.</p>
                                    <hr style="margin: 0px; color:white">
                                </div>
                            <?php } else if (($ticket['status'] == 15 || $ticket['status'] == 16) && $session == $ticket['created_by']) { ?>
                                <div class="card-header bg-info">
                                    <div class="row">
                                        <div class="col-auto align-self-center text-center">
                                            <h5 class="fw-bold text-white">UAT (User Acceptance Testing)</h5>
                                        </div>
                                    </div>
                                    <p class="text-white">Appreciate the quick reply. We'll get on this <span class="fw-bolder">ASAP</span>.</p>
                                    <hr style="margin: 0px; color:white">
                                </div>
                            <?php } else { ?>
                                <div class="card-header bg-info">
                                    <div class="row">
                                        <div class="col-auto align-self-center text-center">
                                            <h5 class="fw-bold text-white">UAT (User Acceptance Testing)</h5>
                                        </div>
                                    </div>
                                    <p class="text-white">Sorry, The Ticket you're trying to access is <span class="fw-bolder">not currently in UAT status</span>.</p>
                                    <hr style="margin: 0px; color:white">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>




    </main>
    <!-- Required jquery and libraries -->
    <script src="<?= base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/popper.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/bootstrap-5/dist/js/bootstrap.bundle.js"></script>
    <script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>

    <script>
        $('#btn_save_uat').on('click', function(e) {
            e.preventDefault();
            note = $('#note').val();
            ticket = $('#id_ticket').val();
            status = $('input[name="btnradio"]:checked').val();
            attachment = $("#attachment").prop("files")[0];
            status_before = $('#status_before').val();
            progress = $('#progress').val();
            let form_data = new FormData();
            form_data.append("attachment", attachment);
            form_data.append("ticket", ticket);
            form_data.append("status", status);
            form_data.append("note", note);
            form_data.append("status_before", status_before);
            form_data.append("progress", progress);
            // console.log('Files : ' + files);
            if (note.trim() == '') {
                $.alert({
                    title: 'Opps!',
                    content: 'Note harus diisi.',
                    type: 'red',
                    theme: 'material',
                    autoClose: 'ok|3000',
                });
            } else if (status == 'undefined') {
                $.alert({
                    title: 'Opps!',
                    content: 'Harus memilih salah satu status.',
                    type: 'red',
                    theme: 'material',
                    autoClose: 'ok|3000',
                });
            } else {
                if (status == 1) {
                    content = "Hasil UAT Sesuai";
                } else {
                    content = "Hasil UAT Tidak Sesuai";
                }
                $.confirm({
                    title: 'Alert!',
                    content: `${content}, apakah anda yakin ?`,
                    type: 'blue',
                    theme: 'material',
                    typeAnimated: true,
                    closeIcon: false, // explicitly show the close icon
                    animation: 'opacity',
                    buttons: {
                        close: function() {},
                        confirm: {
                            text: 'Yakin',
                            btnClass: 'btn-blue',
                            action: function() {
                                $.ajax({
                                    url: "<?= base_url('uat_form/insert_uat'); ?>",
                                    type: "POST",
                                    data: form_data,
                                    dataType: "json",
                                    processData: false, // Prevent jQuery from processing the data
                                    contentType: false, // Prevent jQuery from setting the content type
                                    beforeSend: function() {
                                        $('#btn_save_uat').attr("disabled", true);
                                    },
                                    success: function(response) {
                                        console.log(response);
                                        $.alert({
                                            title: 'Success',
                                            content: 'Berhasil di update!',
                                            type: 'blue',
                                            theme: 'material',
                                            autoClose: 'ok|3000',
                                        });
                                    },
                                    complete: function() {
                                        setTimeout(() => {
                                            location.reload();
                                        }, 3001);
                                    }
                                });
                            }
                        },
                    }
                });
            }
        })
        $('#btnradio2').on('click', function() {
            $('#label_btn_radio2').addClass('text-white');
        })
        $('#btnradio1').on('click', function() {
            $('#label_btn_radio2').removeClass('text-white');
        })
    </script>

</body>

</html>