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
    <link rel="stylesheet" href="assets/vendor/swiper-7.3.1/swiper-bundle.min.css">

    <!-- style css for this template -->
    <link href="assets/scss/style.css" rel="stylesheet" id="style">
</head>

<body class="d-flex flex-column h-100 sidebar-pushcontent" data-sidebarstyle="sidebar-pushcontent">
    <!-- sidebar-pushcontent, sidebar-overlay , sidebar-fullscreen  are classes to switch UI here-->

    <!-- page loader -->
     
    <div class="container-fluid h-100 position-fixed loader-wrap bg-blur">
        <div class="row justify-content-center h-100">
            <div class="col-auto align-self-center text-center">
                <div class="doors animated mb-4">
                    <div class="left-door"></div>
                    <div class="right-door"></div>
                </div>
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
    <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
        <img src="assets/img/bg-1.jpg" alt="" class="w-100" />
    </div>
    <!-- background ends  -->


    <!-- Begin page content -->
    <main class="main h-100 container-fluid bg-blur">
        <!-- image swiper -->
        <div class="swiper image-swiper h-100 w-100 position-absolute z-index-0 start-0 top-0">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
                        <img src="assets/img/bg-5.jpg" alt="" />
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
                        <img src="assets/img/bg-2.jpg" alt="" class="w-100" />
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
                        <img src="assets/img/bg-4.jpg" alt="" />
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
                                <!-- content swiper -->
                                <div class="swiper onboarding-swiper swiper-no-swiping h-100 w-100">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12 text-center position-relative py-4">

                                                    <img class="avatar avatar-100 coverimg mb-3 rounded-circle"
                                                        src="http://trusmiverse.com/hr/uploads/profile/profile_1698469559.png"
                                                        alt="" />

                                                    <h5 class="text-truncate mb-0">IT Trusmi Group</h5>
                                                    <p class="text-secondary small mb-1">IT Manager</p>
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
                                                    <!-- <p class="h4 fw-light mb-3">Who is going to use this app?</p>
                                                    <p class="text-secondary small mb-4">
                                                        Please share your <b>Name</b> and <b>Photo</b> to display in application. This will be logged in user name wherever mentioned. This is just to make more intuitive communication with interface.
                                                    </p> -->
                                                        <!-- Form elements -->
                                                    <div class="form-group mb-2 position-relative check-valid is-valid">
                                                        <div class="input-group input-group-lg">
                                                            <span
                                                                class="input-group-text text-theme bg-white border-end-0"><i
                                                                    class="bi bi-award"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" placeholder="Your Goal"
                                                                    value="Menjadi pribadi yang lebih baik" readonly
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
                                                                    value="Sharing Session once a week" readonly
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
                                                                <input type="text" placeholder="Type" value="Weekly" readonly class="form-control border-start-0" id="type">
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
                                                                    <h5 class="increamentcount mb-0">2</h5>
                                                                    <p class="small text-secondary">Target</p>
                                                                </div>
                                                                <div class="col-6 mnw-100 text-center">
                                                                    <i
                                                                        class="bi bi-bookmark-check-fill h4 avatar avatar-60 bg-light-green text-green rounded-circle mb-2"></i>
                                                                    <h5 class="increamentcount mb-0">1</h5>
                                                                    <p class="small text-secondary">Actual</p>
                                                                </div>
                                                            </div>

                                                            <div class="row py-3">
                                                                <div class="col-6 mnw-100 text-center">
                                                                    <i
                                                                        class="bi bi-percent h4 avatar avatar-60 bg-light-yellow text-yellow rounded-circle mb-2"></i>
                                                                    <h5 class="mb-0">50%</h5>
                                                                    <p class="small text-secondary">Progress</p>
                                                                </div>
                                                                <div class="col-6 mnw-100 text-center">
                                                                    <i
                                                                        class="bi bi-clipboard-check-fill h4 avatar avatar-60 bg-light-cyan text-cyan rounded-circle mb-2"></i>
                                                                    <h5 class="mb-0">50%</h5>
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
                                            <button class="btn btn-outline-theme me-2" style="width:100%">
                                                <i class="bi bi-clock-history vm me-2"></i> 
                                                Postphone
                                            </button>
                                        </div>
                                        <div class="col-6 f-btn text-center p-t-15 p-b-15">
                                            <button class="btn btn-theme" style="width:100%">
                                                <i class="bi bi-clipboard-check vm me-2"></i> 
                                                Update
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




    <!-- Required jquery and libraries -->
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/vendor/bootstrap-5/dist/js/bootstrap.bundle.js"></script>

    <!-- Customized jquery file  -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/color-scheme.js"></script>

    <!-- PWA app service registration and works -->
    <script src="assets/js/pwa-services.js"></script>

    <!-- Chart js script -->
    <script src="assets/vendor/chart-js-3.3.1/chart.min.js"></script>

    <!-- Progress circle js script -->
    <script src="assets/vendor/progressbar-js/progressbar.min.js"></script>

    <!-- swiper js script -->
    <script src="assets/vendor/swiper-7.3.1/swiper-bundle.min.js"></script>

    <!-- page level script -->
    <script src="assets/js/onboarding.js"></script>

</body>

</html>