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
        <img src="<?= base_url(); ?>assets/img/bg-16.jpg" alt="" style="width: 100%; height:700px; object-fit: cover;"/>
    </div>
    <!-- background ends  -->

    <!-- Begin page content -->
    <main class="main h-100 container-fluid bg-blur">
        <!-- image swiper -->
        <div class="swiper image-swiper h-100 w-100 position-absolute z-index-0 start-0 top-0">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="coverimg w-100 top-0 start-0 position-absolute">
                        <img src="<?= base_url(); ?>assets/img/bg-16.jpg" alt="" style="width: 100%; height:700px; object-fit: cover;" />
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
                            <div class="card-header bg-danger">
                                <div class="row">
                                    <div class="col-auto align-self-center text-center">
                                        <h5 class="fw-bold text-white">Warning Letter</h5>
                                    </div>
                                </div>
                                <p class="text-white">Mohon untuk mengisi kronologi</p>
                                <hr style="margin: 0px; color:white">
                            </div>
                            <div class="card-body">
                                <form action="" id="form_kronologi" method="POST">
                                    <input type="hidden" name="id_warning" value="<?= $warning->warning_id ?>">
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="nama" class="form-label-custom">Nama
                                                Karyawan</label>
                                            <input type="text" class="form-control border-custom" id="nama" value="<?= $warning->name ?> | <?= $warning->designation_name ?> | <?= $warning->department_name ?>" required readonly>

                                        </div>

                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label for="nama" class="form-label-custom">Jenis</label>
                                            <input type="text" class="form-control border-custom" id="nama" value="<?= $warning->type ?>" readonly>
                                        </div>
                                        <div class="col-6">
                                            <label for="nama" class="form-label-custom">Masa Berlaku</label>
                                            <input type="text" class="form-control border-custom" id="nama" value="<?= $warning->masa_berlaku ?> bulan" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="nama" class="form-label-custom">Investigasi</label>
                                            <textarea name="" id="" class="form-control border-custom" readonly rows="4"><?= $warning->hasil_investigasi ?></textarea>
                                        </div>

                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="nama" class="form-label-custom">Kronologi</label>
                                            <textarea name="kronologi" id="" required class="form-control border-custom" rows="4" <?= ($warning->kronologis == null) ? '' : 'readonly' ?>><?= ($warning->kronologis == null) ? '' : $warning->kronologis ?></textarea>
                                        </div>

                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-12">
                                            <?php if ($warning->kronologis == null) : ?>

                                                <button type="submit" class="btn btn-block btn-danger text-white" style="float: right;"><i class="fa fa-chevron-circle-right"></i> Submit</button>
                                            <?php else : ?>
                                                <button class="btn btn-block btn-danger text-white" style="float: right;" disabled>Submited</button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
        $('#form_kronologi').on('submit', function(e) {
            e.preventDefault();
            var krono = $('[name="kronologi"]').val();
            if (krono.length < 3) {
                $.alert({
                    title: 'Opps!',
                    content: 'Kronologi harus lebih dari 3 huruf',
                    type: 'red',
                    theme: 'material',
                    autoClose: 'ok|3000',
                });
            }else{
                $.confirm({
                    title: 'Alert!',
                    content: 'Apakah anda yakin ?',
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
                                // update_dokumen(type, dokumen, user_id);
                                $.ajax({
                                    url: "<?= base_url('warning_letter/update_kronologi'); ?>",
                                    type: "POST",
                                    data: $('#form_kronologi').serialize(),
                                    dataType: "json",
                                    success: function(response) {
                                        $.alert({
                                            title: 'Success',
                                            content: 'Berhasil di update!',
                                            type: 'blue',
                                            theme: 'material',
                                            autoClose: 'ok|3000',
                                        });
                                        location.reload();
                                    }
                                });
                            }
                        },
                    }
                });
            }
        });
    </script>

</body>

</html>