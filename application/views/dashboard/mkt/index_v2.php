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

    <div class="container">
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
                            <figure class="avatar avatar-150 coverimg mb-3 rounded-circle" id="profile_figure">
                                <!-- <img src="https://trusmiverse.com/apps/assets/img/pp_ceo.jpg" alt="" /> -->
                                <img src="https://trusmiverse.com/hr/uploads/profile/default_male.jpg" id="profile_picture" alt="" />
                            </figure>

                            <h5 class="text-truncate mb-0" id="profile_name">Abdul Goffar</h5>
                            <p class="text-secondary small mb-1" id="profile_designation">General Manager Marketing</p>
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
                        <div class="card theme-yellow bg-radial-gradiant text-white border-0 text-center">
                            <div class="card-body bg-none py-3">
                                <div class="row">
                                    <div class="col-6">
                                        <i class="bi bi-trophy avatar avatar-80 bg-theme rounded-circle h4 mb-3 d-inline-block"></i>
                                    </div>
                                    <div class="col-6 d-flex align-items-center">
                                        <div class="col-12">
                                            <h4 class="mb-1">85 <br>Excellence</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <p class="text-center">Kehadiran</p>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="circle-small">
                                        <div id="circleprogressgreen1"><svg viewBox="0 0 100 100" style="display: block; width: 100%;">
                                                <path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90" stroke="#eaf4d8" stroke-width="10" fill-opacity="0"></path>
                                                <path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90" stroke="rgb(145,195,0)" stroke-width="10" fill-opacity="0" style="stroke-dasharray: 282.783, 282.783; stroke-dashoffset: 42.4175;"></path>
                                            </svg>
                                            <div class="progressbar-text" style="position: absolute; left: 50%; top: 50%; padding: 0px; margin: 0px; transform: translate(-50%, -50%); color: rgb(145, 195, 0);">85<small>%<small></small></small></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <p class="text-center">Kedisiplinan</p>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="circle-small">
                                        <div id="circleprogressyellow1"><svg viewBox="0 0 100 100" style="display: block; width: 100%;">
                                                <path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90" stroke="#fff2ce" stroke-width="10" fill-opacity="0"></path>
                                                <path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90" stroke="rgb(253,186,0)" stroke-width="10" fill-opacity="0" style="stroke-dasharray: 282.783, 282.783; stroke-dashoffset: 80.4175;"></path>
                                            </svg>
                                            <div class="progressbar-text" style="position: absolute; left: 50%; top: 50%; padding: 0px; margin: 0px; transform: translate(-50%, -50%); color: rgb(253, 186, 0);">65<small>%<small></small></small></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <table class="table tabel-sm" style="font-size: 10pt;">
                            <thead>
                                <tr>
                                    <th>Target Hadir</th>
                                    <th class="text-end">20 (hr)</th>

                                </tr>
                                <tr>
                                    <th>Actual Hadir</th>
                                    <th class="text-end">19 (hr)</th>
                                </tr>
                                <tr>
                                    <th>Jumlah Telat</th>
                                    <th class="text-end">8 (mnt)</th>
                                </tr>
                                <tr>
                                    <th>Lock Absen</th>
                                    <th class="text-end">1x</th>
                                </tr>
                                <tr>
                                    <th>Warning Lock</th>
                                    <th class="text-end">8x</th>
                                </tr>
                            </thead>
                        </table>
                        <table class="table tabel-sm" style="font-size: 10pt;">
                            <thead>
                                <tr>
                                    <th>Izin</th>
                                    <th class="text-end">2x</th>

                                </tr>
                                <tr>
                                    <th>Sakit</th>
                                    <th class="text-end">1x</th>
                                </tr>
                            </thead>
                        </table>
                        <hr>
                        <p class="text-center">Event</p>
                        <div id="chartdivEvent"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-7 col-xl-8">
                <!-- KPI -->
                <div class="card border-0 mb-4 card status-start border-card-status border-primary w-100" style="padding: 5px;">
                    <div class="card-header" style="padding: 5px;">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-person-circle h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                            </div>
                            <div class="col ps-0">
                                <h6 class="fw-medium title">Key Performance Indicator</h6>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div id='myChart'></div>
                    <div class="card-body" style="padding: 5px;">
                        <div class="row">
                            <div class="col-sm-12 col-lg-6">
                                <div class="text-center">
                                    <!-- <canvas id="gauge-ps-kpi"></canvas> -->
                                    <div id="chartdivKpi"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <table class="table tabel-sm" style="font-size: 10pt;" id="dt_kpi">
                                    <thead>
                                        <tr>
                                            <th>KPI</th>
                                            <th>Target</th>
                                            <th>Actual</th>
                                            <th>Achieve</th>
                                            <th>Bobot</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_kpi">
                                        <!-- <tr>
                                            <td>Booking</td>
                                            <td>1000</td>
                                            <td>800</td>
                                            <td>40</td>
                                            <td>80%</td>
                                        </tr>
                                        <tr>
                                            <td>Akad</td>
                                            <td>500</td>
                                            <td>300</td>
                                            <td>35</td>
                                            <td>60%</td>
                                        </tr>
                                        <tr>
                                            <td>SDM</td>
                                            <td>300</td>
                                            <td>210</td>
                                            <td>25</td>
                                            <td>70%</td>
                                        </tr> -->
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6" class="text-end" id="nilai_kpi">70%</td>
                                        </tr>
                                        <tr>
                                            <td>Evaluasi</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">"KPI januari turun 5% dari periode sebelumnya di karena pemenuhan SDM kurang"</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Konsistensi -->
                <div class="card border-0 mb-4 card status-start border-card-status border-warning w-100" style="padding: 5px;">
                    <div class="card-header" style="padding: 5px;">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-person-circle h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                            </div>
                            <div class="col ps-0">
                                <h6 class="fw-medium title">Konsistensi</h6>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div id='myChart'></div>
                    <div class="card-body" style="padding: 5px;">
                        <div class="row">
                            <div class="col-sm-12 col-lg-6">
                                <div class="card-body text-center">
                                    <div class="semidoughnutchart mb-4">
                                        <div class="expensedatasemidoughnut">
                                            <p class="text-secondary small mb-0">Total Konsistensi</p>
                                            <h5>50 <small>%</small></h5>
                                        </div>
                                        <canvas id="semidoughnutchart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <table class="table tabel-sm" style="font-size: 10pt;">
                                    <thead>
                                        <tr>
                                            <th>Jumlah Goal</th>
                                            <th>3</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th>Jumlah Strategy</th>
                                            <th>8</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="4">Meningkakan booking dengan Event</td>
                                            <td class="text-end">30%</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">Meningkatkan leadtime pemberkasan</td>
                                            <td class="text-end">20%</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td class="text-end">50%</td>
                                        </tr>
                                        <tr>
                                            <td>Evaluasi</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">"berkas terlambat karena libur nataru"</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 mb-4 card status-start border-card-status border-info w-100" style="padding: 5px;">
                    <div class="card-header" style="padding: 5px;">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-person-circle h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                            </div>
                            <div class="col ps-0">
                                <h6 class="fw-medium title">Standar</h6>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 5px;">
                        <div class="row">
                            <div class="col-4">
                                <div class="row">
                                    <div class="col">
                                        <div id="chart_standar"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <p>Evaluasi</p>
                                        <p>"Leadtime terlambat karena libur nataru"</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div id="chart_rasio_leadtime"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <!-- Experience -->
                    <div class="card border-0 mb-4 status-start border-card-status border-success w-100">
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