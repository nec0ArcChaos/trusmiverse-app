<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">

    <link rel="manifest" href="manifest.json">
    <script>
        //if browser support service worker
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('assets/js/sw.js');
        };
    </script>

    <title>Trusmiverse</title>

    <!-- manifest meta -->
    <!-- <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="manifest" href="manifest.json" /> -->

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="180x180">
    <link rel="icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="32x32" type="image/png">
    <link rel="icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="16x16" type="image/png">

    <!-- Google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- bootstrap icons -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css"> -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/node_modules/bootstrap-icons/font/bootstrap-icons.css">

    <!-- swiper carousel css -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/swiper-7.3.1/swiper-bundle.min.css">

    <!-- style css for this template -->
    <link href="<?= base_url(); ?>assets/scss/style.css" rel="stylesheet" id="style">

    <!-- PNOTIFY -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/icon/icofont/css/icofont.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bower_components/pnotify/css/pnotify.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bower_components/pnotify/css/pnotify.brighttheme.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bower_components/pnotify/css/pnotify.buttons.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/pages/pnotify/notify.css">
    <!-- PNOTIFY -->

    <!-- owl carousel -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/owl_carousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/owl_carousel/assets/owl.theme.default.min.css">
    <!-- end owl carousel -->


    <!-- Fomantic Ui Or Semantic Ui -->
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/dropdown.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/transition.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/image.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/form.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/button.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/input.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/label.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/icon.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/loader.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/popup.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/toast.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/progress.css">
</head>

<body class="d-flex flex-column h-100 sidebar-pushcontent" data-sidebarstyle="sidebar-pushcontent">
    <!-- sidebar-pushcontent, sidebar-overlay , sidebar-fullscreen  are classes to switch UI here-->

    <!-- page loader -->
    <!-- <div class="container-fluid h-100 position-fixed loader-wrap bg-blur">
        <div class="row justify-content-center h-100">
            <div class="col-auto align-self-center text-center">
                <img src="assets/img/logo_trusmiverse.png" style="height: 100px;width: auto;" alt="" />
                <h5 class="mb-0">Thanks for the patience</h5>
                <p class="text-secondary small">Amazing things coming from the <span class="text-dark">Trusmiverse</span></p>
                <div class="spinner-border text-primary mt-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div> -->
    <!-- page loader ends -->

    <!-- background -->
    <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
        <img src="assets/img/bg-1.jpg" alt="" class="w-100" />
    </div>
    <!-- background ends  -->


    <!-- Begin page content -->
    <main class="main h-100 container-fluid bg-blur rounded-0">
        <div class="row h-100">
            <!-- left block-->
            <div class="col-12 col-md-6 h-100 overflow-y-auto">
                <div class="row h-100">
                    <div class="col-12 mb-auto">
                        <!-- header -->
                        <header class="header">
                            <!-- Fixed navbar -->
                            <nav class="navbar">
                                <div class="container-fluid">
                                    <a class="navbar-brand" href="javascript:void(0)">
                                        <div class="row">
                                            <div class="col-auto"><img src="assets/img/logo_trusmiverse.png" class="mx-100" alt="" /></div>
                                            <div class="col ps-0 align-self-center">
                                                <h5 class="fw-normal text-dark">Trusmiverse</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </nav>
                        </header>
                        <!-- header ends -->
                    </div>
                    <div class="col-12  align-self-center py-1">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-11 col-lg-10 col-xl-8 col-xxl-6">
                                <h1 class="display-4">Welcome,</h1>
                                <p class="h4 fw-light mb-4">Experience the trust of the universe with Trusmiverse.</p>

                                <p class="h4 fw-light mb-4">Start your day now</p>

                                <form class="mb-4" id="form_login">
                                    <!-- alert messages -->
                                    <div class="alert alert-danger fade show d-none mb-2 global-alert" role="alert">
                                        <div class="row">
                                            <div class="col"><strong>Requierd!</strong> Please enter valid data.</div>
                                        </div>
                                    </div>
                                    <div class="alert alert-success fade show d-none mb-2 global-success" role="alert">
                                        <div class="row">
                                            <div class="col-auto align-self-center">
                                                <div class="spinner-border spinner-border-sm text-success me-2" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <strong>Awesome!</strong> Taking you to the next page.
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Form elements -->
                                    <div class="form-group mb-2 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-envelope"></i></span>
                                            <div class="form-floating">
                                                <input type="text" placeholder="Username" value="" required class="form-control border-start-0" autofocus id="username">
                                                <label>Username</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-2 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-key"></i></span>
                                            <div class="form-floating">
                                                <input type="password" placeholder="Enter Password" value="" required class="form-control border-start-0" autofocus id="password">
                                                <label for="password">Password</label>
                                            </div>
                                            <span class="input-group-text text-secondary bg-white border-end-0" id="viewpassword"><i class="bi bi-eye"></i></span>
                                        </div>
                                    </div>
                                    <div style="text-align: right;">
                                        <a class="btn btn-link me-auto" href="<?= base_url() ?>lupa_password/reset_password">Lupa Password</a>
                                        <button class="btn btn-lg btn-theme mb-2" type="button" id="submitbtn">Login <i class="bi bi-arrow-right"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="row col-12 col-md-11 col-lg-10 col-xl-8 col-xxl-6">
                            <div class="col item text-center" id="installApp">
                                <figure class="cols avatar avatar-40 coverimg rounded-circle" style="background-image: url(&quot;assets/img/logo_rumah_ningrat.png&quot;);">
                                    <img src="<?= base_url(); ?>assets/img/logo_rumah_ningrat.png" alt="" style="display: none;">
                                </figure>
                            </div>
                            <div class="col item text-center">
                                <figure class="cols avatar avatar-40 coverimg rounded-circle" style="background-image: url(&quot;assets/img/logo_bt.png&quot;);">
                                    <img src="<?= base_url(); ?>assets/img/logo_bt.png" alt="" style="display: none;">
                                </figure>
                            </div>
                            <div class="col item text-center">
                                <figure class="cols avatar avatar-40 coverimg rounded-circle" style="background-image: url(&quot;assets/img/logo_tkb.png&quot;);">
                                    <img src="<?= base_url(); ?>assets/img/logo_tkb.png" alt="" style="display: none;">
                                </figure>
                            </div>
                            <div class="col item text-center">
                                <figure class="cols avatar avatar-40 coverimg rounded-circle" style="background-image: url(&quot;assets/img/fbtlogo.png&quot;);">
                                    <img src="<?= base_url(); ?>assets/img/fbtlogo.png" alt="" style="display: none;">
                                </figure>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-auto">
                        <!-- footer -->
                        <footer class="footer row">
                            <div class="col-12 col-md-12 col-lg py-2">
                                <span class="text-secondary small">Copyright @2022, IT Trusmi Group
                            </div>
                        </footer>
                        <!-- footer ends -->
                    </div>
                </div>
            </div>

            <!-- right block-->
            <div class="col-12 col-md-6 vh-100">
                <div class="row h-100">
                    <div class="col-12 h-50 position-relative">
                        <!-- time and temperature -->
                        <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
                            <!-- <iframe class="elementor-background-video-embed w-100 h-100" frameborder="0" allowfullscreen="1" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" title="BASUNDARI FINALE REV" src="https://www.youtube.com/embed/fMIrxc8CqX4?controls=0&amp;rel=0&amp;playsinline=1&amp;enablejsapi=1&amp;origin=https%3A%2F%2Ftrusmigroup.com&amp;widgetid=1" id="widget2"></iframe> -->
                            <!-- id="image-daytime" -->
                            <!-- <iframe class="h-100 w-100" src="https://www.youtube.com/embed/zrGlPWBuDeQ?autoplay=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe> -->
                            <!-- <img src="<?= base_url(); ?>assets/img/logo_login_trusmi.png" alt="" class="w-100" /> -->
                            <img src="<?= base_url(); ?>assets/img/logo_company_white.png" alt="" class="w-100" />
                        </div>
                        <div class="row text-white mt-2">
                            <div class="col">
                                <p class="display-3 mb-0"><span id="time"></span><small><span class="h4 text-uppercase" id="ampm"></span></small></p>
                                <p class="lead fw-normal" id="date"></p>
                            </div>
                            <div class="col-auto text-end">
                                <!-- <p class="display-3 mb-0">
                                    <img src="assets/img/cloud-sun.png" alt="" class="vm me-0 tempimage" id="tempimage" />
                                    <span id="temperature">46</span><span class="h4 text-uppercase"> <sup>0</sup>C</span>
                                </p> -->

                                <a href="javascript:void()" class="btn btn-link text-white dd-arrow-none dropdown-toggle">
                                    <span class="h5 fw-normal" id="city">Cirebon</span>
                                    <!-- <i class="bi bi-pencil-square small fw-light"></i> -->
                                </a>
                            </div>
                        </div>
                        <!-- time and temperature ends -->
                    </div>
                    <div class="col-12 col-md-12 col-lg-7 col-xl-6 h-50 position-relative px-0">
                        <div class="row position-absolute start-0 top-0 mx-0 z-index-9 py-4">
                            <div class="col-auto">
                                <img src="<?= base_url(); ?>assets/img/newsicon.png" alt="" />
                            </div>
                            <div class="col align-self-center"></div>
                        </div>
                        <!-- news swiper -->
                        <div class="swiper news-swiper h-100 w-100 text-white">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="overlay"></div>
                                    <div class="row h-100 position-relative mx-0 pb-5">
                                        <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
                                            <img src="<?= base_url(); ?>assets/img/Pembelajar.png" alt="" class="w-100" />
                                        </div>
                                        <div class="col-12"></div>
                                        <div class="col-12 mt-auto">
                                            <!-- <h3 class="fw-normal mb-3">BT - Batik Trusmi</h3>
                                            <p>Konsep one stop shopping dalam toko batik terbesar dan terlengkap yang menyediakan fashion, aksesoris batik, camilan tradisional dengan menggabungkan eduwisata museum pembatikan Cirebon.</p> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="overlay"></div>
                                    <div class="row h-100 position-relative mx-0 pb-5">
                                        <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
                                            <img src="<?= base_url(); ?>assets/img/Proaktif.png" alt="" class="w-100" />
                                        </div>
                                        <div class="col-12"></div>
                                        <div class="col-12 mt-auto">
                                            <!-- <h3 class="fw-normal mb-3">The Keranjang Bali</h3>
                                            <p>Tempat wisata belanja dengan arsitektur yang menarik menggabungkan budaya, hiburan dan edukasi khas Bali dalam satu tempat. Pengalaman yang seru untuk berbelanja oleh-oleh di Bali, menghadirkan “Bali dalam satu Keranjang”.</p> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="overlay"></div>
                                    <div class="row h-100 position-relative mx-0 pb-5">
                                        <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
                                            <img src="<?= base_url(); ?>assets/img/Penebar-energi-positif.png" alt="" />
                                        </div>
                                        <div class="col-12"></div>
                                        <div class="col-12 mt-auto">
                                            <!-- <h3 class="fw-normal mb-3">TrusmiLand</h3>
                                            <p>Kawasan hunian modern mitra terpercaya untuk pembangunan konsep hunian masa depan. Karena dengan Trusmiland semua berhak punya rumah.</p> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-pagination pagination-smallline white text-start px-2"></div>
                        </div>
                        <!-- news swiper ends -->
                    </div>
                    <div class="col-12 col-md-6 col-lg-5 col-xl-6 d-none d-lg-block h-50 position-relative px-0">
                        <!-- image swiper -->
                        <div class="swiper image-swiper h-100 w-100">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
                                        <img src="<?= base_url(); ?>assets/img/bg_login_1.jpg" alt="" />
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
                                        <img src="<?= base_url(); ?>assets/img/bg_login_5.jpg" alt="" />
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="coverimg h-100 w-100 top-0 start-0 position-absolute">
                                        <img src="<?= base_url(); ?>assets/img/bg_login_6.jpg" alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- image swiper ends -->
                    </div>
                </div>
            </div>
        </div>

        <div class="ui blue toast" id="domtoast">
            <div class="content">
                <div class="ui header">Notice</div>
                A Toast can be generated out of existing DOM Nodes
            </div>
        </div>
        <p></p>

    </main>




    <!-- Required jquery and libraries -->
    <script src="<?= base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/popper.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/bootstrap-5/dist/js/bootstrap.bundle.js"></script>

    <!-- Customized jquery file  -->
    <script src="<?= base_url(); ?>assets/js/main.js"></script>
    <script src="<?= base_url(); ?>assets/js/color-scheme.js"></script>

    <!-- PWA app service registration and works -->
    <!-- <script src="assets/js/pwa-services.js"></script> -->

    <!-- Chart js script -->
    <script src="<?= base_url(); ?>assets/vendor/chart-js-3.3.1/chart.min.js"></script>

    <!-- Progress circle js script -->
    <script src="<?= base_url(); ?>assets/vendor/progressbar-js/progressbar.min.js"></script>

    <!-- swiper js script -->
    <script src="<?= base_url(); ?>assets/vendor/swiper-7.3.1/swiper-bundle.min.js"></script>

    <!-- page level script -->
    <!-- <script src="assets/js/login.js"></script> -->


    <!-- Pnotify -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/pnotify/js/pnotify.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/pnotify/js/pnotify.buttons.js"></script>

    <!-- Fomantic Or Semantic Ui -->
    <script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/dropdown.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/transition.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/form.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/popup.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/toast.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/progress.js"></script>

    <!-- owl carousel -->
    <script src="<?= base_url(); ?>assets/owl_carousel/owl.carousel.min.js"></script>

    <script type="text/javascript">
        let deferredPrompt;
        window.addEventListener('beforeinstallprompt', (e) => {
            deferredPrompt = e;
        });

        const installApp = document.getElementById('installApp');
        installApp.addEventListener('click', async () => {
            if (deferredPrompt !== null) {
                deferredPrompt.prompt();
                const {
                    outcome
                } = await deferredPrompt.userChoice;
                if (outcome === 'accepted') {
                    deferredPrompt = null;
                }
            }
        });


        $(document).ready(function() {
            $(document).keydown(function(event) {
                if (event.which === 13) {
                    // Enter key was pressed
                    $('#submitbtn').click();
                    // You can add your code to submit the form or perform an action here.
                }
            });
        });

        $(document).ready(function() {
            var owl = $('.owl-carousel');
            owl.owlCarousel({
                loop: false,
                autoplay: false,
                autoplayTimeout: 1500,
                autoplayHoverPause: false,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 4,
                        margin: 10,
                        nav: false
                    },
                    600: {
                        items: 4,
                        margin: 10,
                        nav: false
                    },
                    1000: {
                        items: 4,
                        margin: 10,
                        nav: false,
                    }
                }
            });
        });

        $(window).on('load', function() {

            /* get date and time */
            var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

            function startTime() {
                var date = new Date;
                var day = date.getDate();
                var month = monthNames[date.getMonth()];
                var year = date.getFullYear();
                var hours = date.getHours();
                var minutes = date.getMinutes();
                var ampm = hours >= 12 ? 'pm' : 'am';
                hours = hours % 12;
                hours = hours ? hours : 12; // the hour '0' should be '12'
                minutes = minutes < 10 ? '0' + minutes : minutes;
                var strTime = hours + ':' + minutes;
                $('#time').text(strTime);
                $('#ampm').text(" " + ampm);
                $('#date').text(day + ' ' + month + ' ' + year);
            }
            setInterval(function() {
                startTime()
            }, 500);

            /* change images based on time zones */
            var date = new Date;
            if (date.getHours() < 12 && date.getHours() >= 7) {
                $('#image-daytime').parent().css('background-image', 'url("assets/img/bg-13.jpg")');
            } else if (date.getHours() >= 12 && date.getHours() <= 19) {
                $('#image-daytime').parent().css('background-image', 'url("assets/img/bg-3.jpg")');
            } else {
                $('#image-daytime').parent().css('background-image', 'url("assets/img/bg-12.jpg")');
            }

            /* temperature data */
            // var cityname = 'Cirebon';
            // $('#citychange li').on('click', function() {
            //     if ($(this).text() != '') {
            //         $('#citychange li').removeClass('active');
            //         $(this).addClass('active')
            //         cityname = $(this).text();
            //         dataload();
            //     }
            // })
            // dataload();

            // function dataload() {
            //     fetch('https://api.openweathermap.org/data/2.5/weather?q=' + cityname + '&APPID=ce2008ef871845f77c7f03aafe2d54eb&units=metric')
            //         /* change app id= "ce2008ef871845f77c7f03aafe2d54eb" with your id create from https://openweathermap.org/api current weather data */
            //         .then(function(response) {
            //             return response.json();
            //         })
            //         .then(function(data) {
            //             appendData(data);
            //         })
            //         .catch(function(err) {
            //             console.log(err);
            //         });
            // }

            // function appendData(data) {
            //     $('#temperature').text(data.main.temp);
            //     $('#city').text(data.name);
            //     $('#tempimage').attr('src', 'assets/img/openweather-icon/light/' + data.weather[0].icon + '@2x.png');
            // }

            /* swiper sliders */
            var swiperNews = new Swiper(".news-swiper", {
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                },
            });
            var swiperImage = new Swiper(".image-swiper", {
                effect: "fade",
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
            });

            $('#viewpassword').on('click', function() {
                var passInput = $(this).closest('.form-group').find('.form-control');
                if (passInput.attr('type') === 'password') {
                    $(this).find('i').attr('class', 'bi-eye-slash');
                    passInput.attr('type', 'text');
                } else {
                    $(this).find('i').attr('class', 'bi bi-eye');
                    passInput.attr('type', 'password');
                }
            });
            $('#viewpassword2').on('click', function() {
                var passInput = $(this).closest('.form-group').find('.form-control');
                if (passInput.attr('type') === 'password') {
                    $(this).find('i').attr('class', 'bi-eye-slash');
                    passInput.attr('type', 'text');
                } else {
                    $(this).find('i').attr('class', 'bi bi-eye');
                    passInput.attr('type', 'password');
                }
            })

            /* verify */
            if ($('#timer').length > 0) {
                $('#timer').innerHTML = '0' + ':' + '20';
                startTimer();

                function startTimer() {
                    var presentTime = $('#timer').html();
                    var timeArray = presentTime.split(/[:]+/);
                    var m = timeArray[0];
                    var s = checkSecond((timeArray[1] - 1));
                    if (s == 59) {
                        m = m - 1
                    }
                    if (m < 0) {
                        return
                    }

                    $('#timer').html(m + ":" + s);
                    setTimeout(startTimer, 1000);
                }

                function checkSecond(sec) {
                    if (sec < 10 && sec >= 0) {
                        sec = "0" + sec
                    }; // add zero in front of numbers < 10
                    if (sec < 0) {
                        sec = "59"
                    };
                    return sec;
                }
            }
        });
        $(document).ready(function() {

        });
        $('#submitbtn').on('click', function() {
            username = $('#username').val();
            password = $('#password').val();
            if (username == '' || password == '') {
                $('.global-alert').removeClass('d-none');
                setTimeout(function() {
                    $('.global-alert').addClass('d-none');
                }, 2000)
            } else {
                $.ajax({
                    url: '<?php echo base_url() ?>login/auth',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        username: username,
                        password: password
                    },
                    success: function(response) {
                        console.log(response);
                        console.log(response.result);
                        if (response.result == 1) {
                            $.toast({
                                showImage: `https://trusmiverse.com/hr/uploads/profile/${response.profile_picture}`,
                                class: 'image bg-white',
                                classImage: 'tiny',
                                title: 'Login Success',
                                message: `Welcome back, ${response.nama}`,
                                showProgress: 'bottom',
                                classProgress: 'green'
                            });
                            // console.log(response.link);
                            $('.global-success').removeClass('d-none');
                            setTimeout(function() {
                                window.location.href = `<?php echo base_url() ?>${response.link}`;
                            }, 1000)
                        } else {
                            $.toast({
                                title: 'Login Failed',
                                // class: 'error text-white',
                                message: 'Username/Password Salah',
                                pauseOnHover: false,
                                showProgress: 'bottom',
                                classProgress: 'red'
                            });
                            // new PNotify({
                            //     title: 'Gagal',
                            //     text: `Username/Password Salah`,
                            //     icon: 'icofont icofont-info-circle',
                            //     type: 'error'
                            // });
                        }
                    }
                });

            }
        });
    </script>

</body>

</html>