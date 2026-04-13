<!-- <style>
    .container {
        position: relative;
        text-align: center;
        color: white;
    }

    .top-right {
        position: absolute;
        top: 8px;
        right: 16px;
    }

    .rotate_image {
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        -o-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style> -->
<main class="main mainheight">
    <div class="container-fluid">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0">My Dashboard</h5>
                <p class="text-secondary">This is your personal dashboard</p>
            </div>
        </div>
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="https://trusmiverse.com">Trusmiverse</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-12 col-md-6 col-lg-5 col-xl-4">
                <!-- intro -->
                <div class="card border-0 mb-4">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-person-circle h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                            </div>
                            <div class="col ps-0">
                                <h6 class="fw-medium mb-0">Profile</h6>
                                <p class="text-secondary small">"Merangkul Resiko & Mencapai Keberhasilan"</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <!-- <div class="container">
                                <img src="img_snow_wide.jpg" alt="Snow" style="width:100%;">
                                <div class="bottom-left">Bottom Left</div>
                                <div class="top-left">Top Left</div>
                                <div class="top-right">Top Right</div>
                                <div class="bottom-right">Bottom Right</div>
                                <div class="centered">Centered</div>
                            </div> -->
                            <img src="https://trusmiverse.com/apps/assets/img/consistent.png" alt="" width="100px;">
                            <figure class="avatar avatar-150 coverimg mb-3 rounded-circle">
                                <!-- <img src="https://trusmiverse.com/apps/assets/img/pp_ceo.jpg" alt="" /> -->
                                <img src="https://trusmiverse.com/hr/uploads/profile/default_male.jpg" alt="" />
                            </figure>

                            <h5 class="text-truncate mb-0">Abdul Goffar</h5>
                            <p class="text-secondary small mb-1">General Manager Marketing</p>
                            <ul class="nav justify-content-center">
                                <li class="nav-item">
                                    <figure class="cols avatar avatar-20 coverimg rounded-circle" style="background-image: url(&quot;assets/img/logo_rumah_ningrat.png&quot;);">
                                        <img src="<?= base_url(); ?>assets/img/logo_rumah_ningrat.png" alt="" style="display: none;">
                                    </figure>
                                </li>
                                <li class="nav-item">
                                    <figure class="cols avatar avatar-20 coverimg rounded-circle" style="background-image: url(&quot;assets/img/logo_bt.png&quot;);">
                                        <img src="<?= base_url(); ?>assets/img/logo_bt.png" alt="" style="display: none;">
                                    </figure>
                                </li>
                                <li class="nav-item">
                                    <figure class="cols avatar avatar-20 coverimg rounded-circle" style="background-image: url(&quot;assets/img/logo_tkb.png&quot;);">
                                        <img src="<?= base_url(); ?>assets/img/logo_tkb.png" alt="" style="display: none;">
                                    </figure>
                                </li>
                                <li class="nav-item">
                                    <figure class="cols avatar avatar-20 coverimg rounded-circle" style="background-image: url(&quot;assets/img/fbtlogo.png&quot;);">
                                        <img src="<?= base_url(); ?>assets/img/fbtlogo.png" alt="" style="display: none;">
                                    </figure>
                                </li>
                            </ul>
                        </div>
                        <hr>
                        <div class="row align-items-center mb-3">
                            <div class="col-6">
                                <h6>Goal <span class="float-end badge badge-sm bg-blue">2</span></h6>
                            </div>
                            <div class="col-6">
                                <h6>Strategy <span class="float-end badge badge-sm bg-purple">7</span></h6>
                            </div>
                        </div>
                        <hr>
                        <div class="row align-items-center mb-1">
                            <div class="col">
                                <h4 class="fw-medium mb-0">Consistency</h4>
                            </div>
                            <div class="col-auto">
                                <div class="circle-medium">
                                    <div id="circleprogressgreen">
                                        <svg viewBox="0 0 100 100" style="display: block; width: 100%;">
                                            <path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90" stroke="rgba(120, 195, 0, 0.15)" stroke-width="10" fill-opacity="0"></path>
                                            <path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90" stroke="rgb(145,195,0)" stroke-width="10" fill-opacity="0" style="stroke-dasharray: 282.783, 282.783; stroke-dashoffset: 42.4175;"></path>
                                        </svg>
                                    </div>
                                    <div class="avatar h4 bg-light-green rounded-circle">
                                        <b class="small">85%</b>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pertama -->
                        <hr>
                        <div class="card">
                            <div class="card-body">
                                <div class="task-primary mb-3">
                                    <div class="row mt-0">
                                        <div class="col mb-1">
                                            <h6>Menjadi Pribadi yang lebih baik </h6>
                                        </div>
                                        <div class="col-auto mb-0">
                                            <p class="float-end badge badge-sm bg-green small">77%</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="task-daily mb-2">
                                    <div class="row mt-0">
                                        <div class="col mb-1">
                                            <p class="small"><b class="btn btn-sm btn-link bg-light-theme theme-cyan">D</b> Mendengarkan Video Motivasi </p>
                                        </div>
                                        <div class="col-auto mb-0">
                                            <p class="float-end badge badge-sm bg-red small">60%</p>
                                        </div>
                                    </div>
                                    <div class="progress h-5 mb-0 bg-light-theme">
                                        <div class="progress-bar bg-theme theme-red" role="progressbar" style="width: 60%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span>&nbsp;</span>
                                    <p class="small text-secondary bi bi-clock float-end"> 24 Nov</p>
                                </div>
                                <div class="task-weekly mb-2">
                                    <div class="row mt-0">
                                        <div class="col mb-1">
                                            <p class="small"><b class="btn btn-sm btn-link bg-light-theme theme-yellow">W</b> 1 Minggu sekali baca buku </p>
                                        </div>
                                        <div class="col-auto mb-0">
                                            <p class="float-end badge badge-sm bg-yellow small">70%</p>
                                        </div>
                                    </div>
                                    <div class="progress h-5 mb-0 bg-light-theme">
                                        <div class="progress-bar bg-theme theme-yellow" role="progressbar" style="width: 70%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span>&nbsp;</span>
                                    <p class="small text-secondary bi bi-clock float-end"> 24 Nov</p>
                                </div>
                                <div class="task-monthly mb-2">
                                    <div class="row mt-0">
                                        <div class="col mb-1">
                                            <p class="small"><b class="btn btn-sm btn-link bg-light-theme theme-green">M</b> 1 Bulan sekali ketemu mentor </p>
                                        </div>
                                        <div class="col-auto mb-0">
                                            <p class="float-end badge badge-sm bg-green small">100%</p>
                                        </div>
                                    </div>
                                    <div class="progress h-5 mb-0 bg-light-theme">
                                        <div class="progress-bar bg-theme theme-green" role="progressbar" style="width: 100%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span>&nbsp;</span>
                                    <p class="small text-secondary bi bi-clock float-end"> 24 Nov</p>
                                </div>
                                <div class="task-evaluasi mb-2">
                                    <div class="row mt-0">
                                        <div class="col mb-1">
                                            <p class="small">Evaluasi </p>
                                        </div>
                                    </div>
                                    <blockquote><q>Tingkatkan agar menjadi lebih baik</q></blockquote>
                                </div>
                            </div>
                        </div>

                        <!-- Kedua -->
                        <hr>
                        <div class="card">
                            <div class="card-body">
                                <div class="task-primary mb-3">
                                    <div class="row mt-0">
                                        <div class="col mb-1">
                                            <h6>Berlin lari marathon </h6>
                                        </div>
                                        <div class="col-auto mb-0">
                                            <p class="float-end badge badge-sm bg-success small">85%</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="task-daily mb-2">
                                    <div class="row mt-0">
                                        <div class="col mb-1">
                                            <p class="small"><b class="btn btn-sm btn-link bg-light-theme theme-cyan">D</b> Lari keliling kampung </p>
                                        </div>
                                        <div class="col-auto mb-0">
                                            <p class="float-end badge badge-sm bg-green small">100%</p>
                                        </div>
                                    </div>
                                    <div class="progress h-5 mb-0 bg-light-theme">
                                        <div class="progress-bar bg-theme theme-green" role="progressbar" style="width: 100%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span>&nbsp;</span>
                                    <p class="small text-secondary bi bi-clock float-end"> 24 Nov</p>
                                </div>
                                <div class="task-weekly mb-2">
                                    <div class="row mt-0">
                                        <div class="col mb-1">
                                            <p class="small"><b class="btn btn-sm btn-link bg-light-theme theme-yellow">W</b> Lari 2 Kilometer </p>
                                        </div>
                                        <div class="col-auto mb-0">
                                            <p class="float-end badge badge-sm bg-yellow small">70%</p>
                                        </div>
                                    </div>
                                    <div class="progress h-5 mb-0 bg-light-theme">
                                        <div class="progress-bar bg-theme theme-yellow" role="progressbar" style="width: 70%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span>&nbsp;</span>
                                    <p class="small text-secondary bi bi-clock float-end"> 24 Nov</p>
                                </div>
                                <div class="task-evaluasi mb-2">
                                    <div class="row mt-0">
                                        <div class="col mb-1">
                                            <p class="small">Evaluasi </p>
                                        </div>
                                    </div>
                                    <blockquote><q>Cukupkan dengan makan sayuran dan buah</q></blockquote>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-7 col-xl-8">
                <!-- Experience -->
                <div class="card border-0 mb-4 status-start border-card-status border-primary w-100">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-calendar-week h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                            </div>
                            <div class="col ps-0">
                                <h6 class="fw-medium mb-0">Calendar</h6>
                                <p class="text-secondary small">"The calendar is a roadmap, and your goals are the destination."</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <!-- Start -->
                        <div class="inner-sidebar-wrap border-bottom">
                            <div class="inner-sidebar-content">
                                <div id="calendarNew"></div>
                            </div>
                        </div>
                        <!-- End -->
                    </div>
                </div>
                <!-- Tambahan untuk KPI -->
                <div class="card border-0 mb-4 card status-start border-card-status border-info w-100">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-person-circle h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                            </div>
                            <div class="col ps-0">
                                <h6 class="fw-medium mb-0">Key Performance Indicator</h6>
                                <p class="text-secondary small">"If you can't measure it, you can't improve it."</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Dougnutchart -->
                        <div class="row">
                            <div class="col-sm-12 col-lg-6">
                                <div class="row align-items-center mb-2">
                                    <div class="col">
                                        <h6 class="title">Abdul Goffar - GM Marketing</h6>
                                    </div>
                                </div>
                                <ul class="list-group list-group-flush bg-none">
                                    <li class="list-group-item text-secondary">
                                        <div class="row">
                                            <div class="col-auto">
                                                <i class="bi bi-calendar2-date text-muted"></i>
                                            </div>
                                            <div class="col-auto ps-0">
                                                Joined at <b>01 Jun 2022</b>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item text-secondary">
                                        <div class="row">
                                            <div class="col-auto">
                                                <i class="bi bi-calendar-week text-muted"></i>
                                            </div>
                                            <div class="col-auto ps-0">
                                                Joining periode for <b>1 Year 2 Month</b>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item text-secondary">
                                        <div class="row">
                                            <div class="col-auto">
                                                <i class="bi bi-trophy text-muted"></i>
                                            </div>
                                            <div class="col-auto ps-0">
                                                Grade KPI is <b class="text-success">Good</b>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <div class="card-body text-center">
                                    <div class="semidoughnutchart mb-4">
                                        <div class="expensedatasemidoughnut">
                                            <p class="text-secondary small mb-0">Total KPI</p>
                                            <h5>90 <small>%</small></h5>
                                        </div>
                                        <canvas id="semidoughnutchart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card-body p-0">
                            <table class="table table-responsive footable" data-show-toggle="true">
                                <thead>
                                    <tr class="text-muted">
                                        <th class="w-12"></th>
                                        <th class="w-20">Sasaran Kinerja</th>
                                        <th>Key Performance</th>
                                        <th data-breakpoints="xs sm md lg">Target</th>
                                        <th data-breakpoints="xs sm md lg">Actual</th>
                                        <th data-breakpoints="xs sm md lg">Ach %</th>
                                        <th data-breakpoints="xs sm md">Bobot</th>
                                        <th data-breakpoints="xs">KPI %</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td>Revenue Booking</td>
                                        <td>Pemenuhan Target Booking</td>
                                        <td>100</td>
                                        <td>90</td>
                                        <td>90</td>
                                        <td>50</td>
                                        <td>
                                            <p>45 <i class="bi bi-record-fill text-warning w-200 h-200"></i></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Revenue Akad</td>
                                        <td>Pemenuhan Target Akad</td>
                                        <td>100</td>
                                        <td>100</td>
                                        <td>100</td>
                                        <td>40</td>
                                        <td>
                                            <p>40 <i class="bi bi-record-fill text-success w-200 h-200"></i></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Revenue SDM</td>
                                        <td>Pemenuhan Tim Marketing</td>
                                        <td>100</td>
                                        <td>50</td>
                                        <td>50</td>
                                        <td>10</td>
                                        <td>
                                            <p>5 <i class="bi bi-record-fill text-danger w-200 h-200"></i></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php $this->load->view('layout/_footer'); ?>
</main>


<!-- Modal Update Sub Task -->
<div class="modal fade" id="modal_detail_sub_task" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modal_detail_sub_taskLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light text-theme rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="detail_title_sub_task">Detail Strategy</h6>
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
                <div class="d-flex align-items-center">
                    <div class="col-12 col-md-12 col-lg-12">
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
                <button type="button" class="btn btn-link m-1" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>