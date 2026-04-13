<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>Documentation - Trusmiverse</title>

    <!-- manifest meta -->
    <meta name="apple-mobile-web-app-capable" content="yes">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="<?= base_url() ?>assets/img/favicon180.png" sizes="180x180">
    <link rel="icon" href="<?= base_url() ?>assets/img/favicon32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="<?= base_url() ?>assets/img/favicon16.png" sizes="16x16" type="image/png">

    <!-- Google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <!-- code highlighter css -->
    <link href="<?= base_url() ?>assets/vendor/highlight/monokai-sublime.min.css" rel="stylesheet">

    <!-- style css for this template -->
    <link href="<?= base_url() ?>assets/scss/style.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100 sidebar-pushcontent scrollspy-example" data-sidebarstyle="sidebar-pushcontent"
    data-bs-spy="scroll" data-bs-target="#docmenu" data-bs-root-margin="0px 100px -50%" data-bs-smooth-scroll="true"
    tabindex="0">
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
                <p class="text-secondary small">Amazing things coming from the <span class="text-dark">WinDOORS</span>
                </p>
                <div class="spinner-border text-primary mt-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    <!-- page loader ends -->

    <!-- background -->
    <div class="coverimg h-100 w-100 top-0 start-0 main-bg">
        <div class="bg-blur main-bg-overlay"></div>
        <img src="<?= base_url() ?>assets/img/bg-14.jpg" alt="" />
    </div>
    <!-- background ends  -->

    <!-- Header -->
    <header class="header">
        <!-- Fixed navbar -->
        <nav class="navbar fixed-top">
            <div class="container-fluid">
                <div class="sidebar-width">
                    <button class="btn btn-link btn-square menu-btn" type="button">
                        <i class="bi bi-list fs-4"></i>
                    </button>
                    <a class="navbar-brand ms-2" href="home.html">
                        <div class="row">
                            <div class="col-auto"><img src="<?= base_url() ?>assets/img/favicon48.png" class="mx-100"
                                    alt="" /></div>
                            <div class="col ps-0 align-self-center d-none d-sm-block">
                                <h5 class="fw-normal text-dark mb-0">WinDOORS</h5>
                                <p class="small text-secondary">Admin App UI</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <h5 class="mb-0">Documentation</h5>
                    <p class="text-secondary">Overview of folders, Components, styling etc. </p>
                </div>
                <div class="ms-auto">
                    <div class="row">
                        <div class="col-auto">
                            <ul class="nav justify-content-center">
                                <li class="nav-item">
                                    <a class="nav-link text-secondary" href="javascript:void(0)" target="_blank">
                                        <i class="bi bi-facebook h5"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-secondary" href="javascript:void(0)" target="_blank">
                                        <i class="bi bi-twitter h5"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-secondary" href="javascript:void(0)" target="_blank">
                                        <i class="bi bi-linkedin h5"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-secondary" href="javascript:void(0)" target="_blank">
                                        <i class="bi bi-instagram h5"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- Header ends -->

    <!-- Sidebar -->
    <div class="sidebar-wrap ">
        <div class="sidebar">
            <div class="container">
                <div class="row mb-4">
                    <div class="col align-self-center">
                        <h6>Main navigation</h6>
                    </div>
                </div>

                <!-- user menu navigation -->
                <div class="row mb-4">
                    <div class="col-12 px-0">
                        <ul class="nav nav-pills" id="docmenu">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="<?= base_url() ?>/docs">
                                    <div class="avatar avatar-40 icon"><i class="bi bi-house-door"></i></div>
                                    <div class="col">Introduction</div>
                                    <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="false"
                                    data-bs-display="static" href="#" role="button" aria-expanded="false">
                                    <div class="avatar avatar-40 icon"><i class="bi bi-archive"></i></div>
                                    <div class="col">Components</div>
                                    <div class="arrow"><i class="bi bi-chevron-right plus"></i> <i
                                            class="bi bi-chevron-down minus"></i>
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item nav-link" href="<?= base_url() ?>docs/accordions">
                                            <div class="avatar avatar-40 icon" style="margin-left: 8px;"><i
                                                    class="bi bi-view-stacked"></i>
                                            </div>
                                            <div class="col align-self-center">accordions</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item nav-link" href="<?= base_url() ?>docs/alerts">
                                            <div class="avatar avatar-40 icon" style="margin-left: 8px;"><i
                                                    class="bi bi-exclamation-triangle"></i>
                                            </div>
                                            <div class="col align-self-center">alerts</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sidebar ends -->

    <!-- Begin page content -->
    <main class="main mainheight">
        <?php $this->load->view($content) ?? ""; ?>
    </main>

    <!-- footer -->
    <footer class="footer mt-auto">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md col-lg py-2">
                    <span class="text-secondary small">Copyright @2022, Creatively designed by <a
                            href="https://maxartkiller.com" target="_blank">Maxartkiller</a> on Earth ❤️</span>
                </div>
                <div class="col-12 col-md-auto col-lg-auto align-self-center">
                    <ul class="nav small">
                        <li class="nav-item"><a class="nav-link" href="#help">Help</a></li>
                        <li class="nav-item">|</li>
                        <li class="nav-item"><a class="nav-link" href="">Support us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer ends -->



    <!-- Required jquery and libraries -->
    <script src="<?= base_url() ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url() ?>assets/js/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/bootstrap-5/dist/js/bootstrap.bundle.js"></script>

    <!-- Customized jquery file  -->
    <script src="<?= base_url() ?>assets/js/main.js"></script>
    <script src="<?= base_url() ?>assets/js/color-scheme.js"></script>

    <!-- Code highlighter js  -->
    <script src="<?= base_url() ?>assets/vendor/highlight/highlight.min.js"></script>

    <!-- page level script -->
    <script>
    // first, find all the div.code blocks
    document.querySelectorAll('code.language-html').forEach(el => {
        // then highlight each
        hljs.highlightElement(el);
    });
    </script>

</body>

</html>