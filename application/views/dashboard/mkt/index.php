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
                        <div class="row">
                            <div class="col">
                                <div class="chart-container">
                                    <canvas id="chart_bulanan" style="width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="row">
                            <dov class="col">
                                <div id="chartDiv">
                                </div>
                            </dov>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-7 col-xl-8">
                <!-- KPI -->
                <div class="card border-0 mb-4 card status-start border-card-status border-primary w-100" style="padding: 5px;">
                    <div class="card-header" style="padding: 5px;">
                        <div class="row align-items-center">
                            <div class="col-1">
                                <i class="bi bi-key h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                            </div>
                            <div class="col px-0">
                                <h6 class="fw-medium py-0 mb-0">Key Performance Indicator</h6>
                                <small class="py-0 text-secondary fst-italic" style="margin-top: -46%;">Bobot : 85%</small>
                            </div>
                            <div class="col d-flex justify-content-end">
                                <div class="row">
                                    <div class="col text-end" style="border-left: 2px solid rgb(0,0,0,0.2);">
                                        <h5 class="badge bg-red fs-5">42%</h5>
                                    </div>
                                    <div class="col ps-1 text-start align-items-center">
                                        <p class="text-danger small mb-0"><i class="mb-0 bi bi-arrow-down-circle-fill text-danger fs-6"></i> 4%</p>
                                        <p class="text-secondary small" style="font-size: 8px !important;">Last Month</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-1">

                            </div>
                            <div class="col-11 title py-0">

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
                                <div class="row">
                                    <div class="col">
                                        <h6><i class="bi bi-journal-arrow-down me-2 text-primary"></i>Detail</h6>
                                    </div>
                                    <div class="col text-end">
                                        <small class="text-end">Ach. Bobot <span class="badge bg-blue" style="font-size: 10pt;">36%</span></small>
                                    </div>
                                </div>

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
                                            <td colspan="6" class="text-end" id="nilai_kpi" style="font-size: 16pt;
    font-weight: 600;">70%</td>
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
                            <div class="col-1">
                                <i class="bi bi-bookmarks me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                            </div>
                            <div class="col px-0">
                                <h6 class="fw-medium py-0 mb-0">Event</h6>
                                <small class="py-0 text-secondary fst-italic" style="margin-top: -46%;">Bobot : 10%</small>
                            </div>
                            <div class="col d-flex justify-content-end">
                                <div class="row">
                                    <div class="col text-end" style="border-left: 2px solid rgb(0,0,0,0.2);">
                                        <h5 class="badge bg-yellow fs-5">70%</h5>
                                    </div>
                                    <div class="col ps-1 text-start align-items-center">
                                        <p class="text-danger small mb-0"><i class="mb-0 bi bi-arrow-down-circle-fill text-danger fs-6"></i> 4%</p>
                                        <p class="text-secondary small" style="font-size: 8px !important;">Last Month</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-1">

                            </div>
                            <div class="col-11 title py-0">

                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 5px;">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <style>
                                    text.apexcharts-datalabel-value {
                                        fill: #3471b3;
                                    }
                                </style>
                                <div id="event_chart">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <h6><i class="bi bi-journal-arrow-down me-2 text-primary"></i>Detail</h6>
                                            </div>
                                            <div class="col text-end">
                                                <small class="text-end">Ach. Bobot <span class="badge bg-blue" style="font-size: 10pt;">7%</span></small>
                                            </div>
                                        </div>
                                        <!-- <h6><i class="bi bi-journal-arrow-down me-2 text-primary"></i>Detail</h6> -->


                                        <table class="table tabel-xs">
                                            <thead>
                                                <tr>
                                                    <th>Event</th>
                                                    <th align="center">Target</th>
                                                    <th align="center">Actual</th>
                                                    <th align="center">Persen</th>
                                                </tr>
                                            </thead>
                                            <tbody id="body_kpi">
                                                <tr>
                                                    <td><i class="bi bi-square-fill" style="color:#016CA5"></i> Meeting</td>
                                                    <td align="center">2</td>
                                                    <td align="center">1</td>
                                                    <td align="center">50%</td>
                                                </tr>
                                                <tr>
                                                    <td><i class="bi bi-square-fill" style="color:#0396C7"></i> Co&Co</td>
                                                    <td align="center">1</td>
                                                    <td align="center">1</td>
                                                    <td align="center">100%</td>
                                                </tr>
                                                <tr>
                                                    <td><i class="bi bi-square-fill" style="color:#04BBDF"></i> Sharing Leader</td>
                                                    <td align="center">1</td>
                                                    <td align="center">1</td>
                                                    <td align="center">100%</td>
                                                </tr>
                                                <tr>
                                                    <td><i class="bi bi-square-fill" style="color:#55E3EA"></i> Breafing</td>
                                                    <td align="center">20</td>
                                                    <td align="center">18</td>
                                                    <td align="center">90%</td>
                                                </tr>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3" align="right" class="bg-secondary text-white fw-bold">Average&nbsp;&nbsp;</td>
                                                    <td align="center" style="font-size: 16pt;
    font-weight: 600;">70%</td>
                                                </tr>
                                            </tfoot>

                                        </table>

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="card border-0 mb-4 card status-start border-card-status border-info w-100" style="padding: 5px;">
                    <div class="card-header" style="padding: 5px;">
                        <div class="row align-items-center">
                            <div class="col-1">
                                <i class="bi bi-bar-chart-steps me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                            </div>
                            <div class="col px-0">
                                <h6 class="fw-medium py-0 mb-0">Disiplin</h6>
                                <small class="py-0 text-secondary fst-italic" style="margin-top: -46%;">Bobot : 5%</small>
                            </div>
                            <div class="col d-flex justify-content-end">
                                <div class="row">
                                    <div class="col text-end" style="border-left: 2px solid rgb(0,0,0,0.2);">
                                        <h5 class="badge bg-green fs-5">93%</h5>
                                    </div>
                                    <div class="col ps-1 text-start align-items-center">
                                        <p class="text-success small mb-0"><i class="mb-0 bi bi-arrow-up-circle-fill text-success fs-6"></i> 4%</p>
                                        <p class="text-secondary small" style="font-size: 8px !important;">Last Month</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-1">

                            </div>
                            <div class="col-11 title py-0">

                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 5px;">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <style>
                                    .c3-gauge-value {
                                        fill: #3471b3;
                                    }
                                </style>
                                <div id="chart_disiplin" style="fill: #3471b3;"></div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col">
                                        <h6><i class="bi bi-journal-arrow-down me-2 text-primary"></i>Detail</h6>
                                    </div>
                                    <div class="col text-end">
                                        <small class="text-end">Ach. Bobot <span class="badge bg-blue" style="font-size: 10pt;">4%</span></small>
                                    </div>
                                </div>

                                <table class="table tabel-xs">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th align="center">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_kpi">
                                        <tr>
                                            <td>Kehadiran</td>
                                            <td align="center">100%</td>
                                        </tr>
                                        <tr>
                                            <td>Jam Masuk Tidak Sesuai</td>
                                            <td align="center">1</td>
                                        </tr>
                                        <tr>
                                            <td>Jam Pulang Cepat Tdk Izin</td>
                                            <td align="center">0</td>
                                        </tr>
                                        <tr>
                                            <td>Izin Pulan Cepat & Datang Terlamb.</td>
                                            <td align="center">1</td>
                                        </tr>
                                        <tr>
                                            <td>Finger 1x</td>
                                            <td align="center">0</td>
                                        </tr>


                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td align="right" class="bg-secondary text-white fw-bold">Kedisiplinan&nbsp;&nbsp;</td>
                                            <td align="center" style="font-size: 16pt;
    font-weight: 600;">93%</td>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card border-0 mb-4 status-start border-card-status border-success w-100">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-1">
                                    <i class="bi bi-calendar-week h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                                </div>
                                <div class="col ps-0">
                                    <h6 class="fw-medium mb-0">Calendar Event</h6>
                                    <p class="text-secondary small">"The calendar is a roadmap, and your goals are the destination."</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1">

                                </div>
                                <div class="col-11 title py-0">

                                </div>
                            </div>
                        </div>
                        <div class="card-body pb-0">
                            <div class="inner-sidebar-wrap border-bottom">
                                <div class="inner-sidebar-content">
                                    <div id="calendarNew"></div>
                                </div>
                            </div>
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