<!-- title bar -->
<div class="container-fluid">
    <div class="row align-items-center page-title">
        <div class="col-12 col-md mb-2 mb-sm-0">
            <h5 class="mb-0">COMPAS</h5>
            <p class="text-secondary">Campaign Optimization & Management Professional Assistant.</p>
        </div>
    </div>
    <div class="row">
        <nav aria-label="breadcrumb" class="breadcrumb-theme">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Trusmiverse</a></li>
                <li class="breadcrumb-item active">Campaign</li>
            </ol>
        </nav>
    </div>
</div>
<div class="container-fluid absolute bg-gradient-theme-light pb-4" style="min-height: 300px;">
</div>
<div class="container" style="margin-top: -280px;">
    <div class="row mb-4 py-2">
        <div class="col text-center">
            <h4>Don't let poor communication <span class="text-gradient">manipulate progress</span>, while you
                can track it better</h4>
            <p class="text-secondary">Manage tasks and update statuses. Add comments and assign responsibility. Get
                approval upon completion and many more.</p>
        </div>
    </div>
</div>
<div class="container mb-5">
    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
        <div class="card border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="row">
                        <div class="col col-sm-auto d-flex">
                            <div class="input-group input-group-md px-2 rounded-3 reportrange"
                                style="border: solid 0.5px #dfe0e1;">
                                <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;"
                                    id="rangeCalendar">
                                <input type="hidden" name="start_date" value="<?= date('Y-m-01'); ?>" id="start_date">
                                <input type="hidden" name="end_date" value="<?= date('Y-m-t'); ?>" id="end_date">
                                <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i
                                        class="bi bi-calendar-event"></i></span>
                            </div>
                            <div class="ms-2 dropdown d-inline-block rounded-3" style="border: solid 0.5px #dfe0e1;">
                                <a class="btn btn-sqaure btn-link text-secondary dd-arrow-none dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static"
                                    role="button">
                                    <i class="bi bi-menu-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="javascript:void(0)"><i
                                                class="bi bi-kanban me-2"></i>
                                            Kanban</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)"><i
                                                class="bi bi-list me-2"></i>
                                            List</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)"><i
                                                class="bi bi-calendar me-2"></i> Calendar</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                            data-bs-target="#addCampaignModal">Add Campaign</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Content -->
<?php if ($this->uri->segment(4) != "") {
    $this->load->view('compas/campaign/' . $this->uri->segment(4) . '/kanban');
} else {
    echo "<div class='container d-flex align-items-center justify-content-center' style='height: 100%;'>
            <div class='text-center'>
                <h1 class='display-4'>Invalid URL</h1>
                <p class='lead'>Please select a valid URL to view details.</p>
            </div>
        </div>";
} ?>
<!-- /Content -->

<!-- Footer -->
<div class="container-fluid footer-page mt-4 py-5">
    <div class="row mb-5">
        <div class="col-12 col-xxl-11 mx-auto">
            <div class="row">
                <div class="col-12 col-xxl-4 mb-5 mb-xxl-0">
                    <h2 class="mb-3"><span class="text-gradient">#1 TrusmiGroup</span><br /><span
                            class="text-gradient">Experience </span> the trust of the universe with <span
                            class="text-gradient">Trusmiverse</span>.</h2>
                    <h5 class="mb-2">Trusmiverse is committed to providing an experience that builds trust.</h5>
                    <h5 class="mb-4">Campaign Optimization & Management Professional Assistant.</h5>
                    <p class="text-secondary">WinDOORS is creative and multipurpose template. You can use it for
                        CRM, Business application, Intranet Application, Portal service and Many more.
                        It comes with unlimited possibilities and 10+ predefined styles which you can also mix
                        up and create new style. Do support and spread a word for us. </p>
                </div>
                <div class="col-12 col-md-4 col-xxl-3">
                    <p class="mb-2"><b>Main office:</b></p>
                    <p class="mb-1"><a href="https://trusmigroup.com/" target="_blank">www.trusmigroup.com</a></p>
                    <p class="mb-4 text-secondary">Jl. H. Abas No.48, Trusmi Kulon, Kec. Weru, Kabupaten Cirebon, Jawa
                        Barat 45154</p>
                </div>
                <div class="col-12 col-md-4 col-xl-3 col-xxl-3 mb-3">
                    <div class="row align-items-center mb-3">
                        <div class="col-auto"><i class="bi bi-clock text-theme"></i></div>
                        <div class="col ps-0"><span class="text-secondary">Mon - Sat, 9:00 WIB - 16:00 WIB</span></div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-auto"><i class="bi bi-telephone text-theme"></i></div>
                        <div class="col ps-0"><span class="text-secondary">(0231) 8304766</span></div>
                    </div>
                    <div class="row">
                        <div class="col item text-center">
                            <figure class="cols avatar avatar-40 coverimg rounded-circle"
                                style="background-image: url(&quot;<?= base_url(); ?>assets/img/logo_rumah_ningrat.png&quot;);">
                                <img src="<?= base_url(); ?>assets/img/logo_rumah_ningrat.png" alt=""
                                    style="display: none;">
                            </figure>
                        </div>
                        <div class="col item text-center">
                            <figure class="cols avatar avatar-40 coverimg rounded-circle"
                                style="background-image: url(&quot;<?= base_url(); ?>assets/img/logo_bt.png&quot;);">
                                <img src="<?= base_url(); ?>assets/img/logo_bt.png" alt="" style="display: none;">
                            </figure>
                        </div>
                        <div class="col item text-center">
                            <figure class="cols avatar avatar-40 coverimg rounded-circle"
                                style="background-image: url(&quot;<?= base_url(); ?>assets/img/logo_tkb.png&quot;);">
                                <img src="<?= base_url(); ?>assets/img/logo_tkb.png" alt="" style="display: none;">
                            </figure>
                        </div>
                        <div class="col item text-center">
                            <figure class="cols avatar avatar-40 coverimg rounded-circle"
                                style="background-image: url(&quot;<?= base_url(); ?>assets/img/fbtlogo.png&quot;);">
                                <img src="<?= base_url(); ?>assets/img/fbtlogo.png" alt="" style="display: none;">
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-xxl-3">
                    <ul class="nav justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="https://twitter.com/TrusmiGroup" target="_blank">
                                <i class="bi bi-twitter h5"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary"
                                href="https://www.linkedin.com/company/trusmigroup/mycompany/" target="_blank">
                                <i class="bi bi-linkedin h5"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="https://www.instagram.com/trusmigroup/"
                                target="_blank">
                                <i class="bi bi-instagram h5"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xxl-11 mx-auto">
            <div class="row align-items-center">
                <div class="col-12 col-md-auto mb-4 mb-md-0">
                    <ul class="nav justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="https://www.facebook.com/maxartkiller/"
                                target="_blank">
                                <i class="bi bi-facebook h5"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="https://twitter.com/maxartkiller" target="_blank">
                                <i class="bi bi-twitter h5"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="https://linkedin.com/company/maxartkiller"
                                target="_blank">
                                <i class="bi bi-linkedin h5"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="https://www.instagram.com/maxartkiller/"
                                target="_blank">
                                <i class="bi bi-instagram h5"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="https://www.youtube.com/get-windoors/"
                                target="_blank">
                                <i class="bi bi-youtube h5"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-md-auto ms-auto">
                    <ul class="nav justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="bi bi-microsoft h4 text-secondary"></i>
                                    </div>
                                    <div class="col ps-0">
                                        <p class="mb-0 small text-secondary">Get this on</p>
                                        <p>Microsoft Store</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="bi bi-play-fill h3 text-secondary"></i>
                                    </div>
                                    <div class="col ps-0">
                                        <p class="mb-0 small text-secondary">Get this on</p>
                                        <p>Google Play</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="bi bi-apple h4 text-secondary"></i>
                                    </div>
                                    <div class="col ps-0">
                                        <p class="mb-0 small text-secondary">Get this on</p>
                                        <p>App Store</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Footer -->
</main>