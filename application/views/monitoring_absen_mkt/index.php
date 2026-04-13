<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <!-- <p class="text-secondary">Menu Monitoring Absen MKT 5 hari terakhir</p> -->
            </div>
            <!-- <div class="col col-sm-auto">
                <form method="POST" id="form_filter">
                    <div class="input-group input-group-md reportrange">
                        <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                        <input type="hidden" name="start" value="" id="start" />
                        <input type="hidden" name="end" value="" id="end" />
                        <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
                    </div>
                </form>
            </div> -->
            <div class="col-auto ps-0">

            </div>
        </div>
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle; ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="m-3">
        <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">Note !</h4>
            <p class="mb-0">Selamat Datang di Menu Monitoring Absen 5 hari terakhir dari Marketing RSP </p>
            <hr class="m-1">
            <p>Marketing yang tidak absen lebih dari 3x dalam 5 hari terakhir (tanpa input izin di menu manage leave) maka akun absen mkt akan auto non aktif!</p>
        </div>
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Absen Marketing RSP dalam 5 Hari Terakhir</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_monitoring_absen_mkt" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Mkt</th>
                                    <th>SPV</th>
                                    <th>BM</th>
                                    <th>RM</th>
                                    <th>Harus Absen</th>
                                    <th>Total Absen</th>
                                    <th>Total Tidak Absen</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Absen Marketing RSP yang terkena Auto Nonaktif</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_monitoring_absen_mkt_nonaktif" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Mkt</th>
                                    <th>SPV</th>
                                    <th>BM</th>
                                    <th>RM</th>
                                    <th>Status</th>
                                    <th>Tgl Non Aktif</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="modal_detail_absen" tabindex="-1" aria-labelledby="modal_detail_absenLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_detail_absenLabel">Detail Absen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="body_detail_absen">
                    <div class="card mb-1 mt-1">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="circle-small">
                                        <div id="circleprogressblue"></div>
                                        <div class="avatar h5 bg-light-blue rounded-circle">
                                            <i class="bi bi-calendar2-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <p class="text-dark small mb-1 col-12 col-md-6" style="font-weight: bold;">Tgl</p>
                                        <p class="text-dark small mb-1 col-12 col-md-6">Shift : <span>In</span> s/d <span>Out</span> </p>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                            <p class="text-secondary small mb-1">Photo In</p>
                                            <h5 class="fw-medium">-<small></small></h5>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                            <p class="text-secondary small mb-1">Clock In</p>
                                            <h5 class="fw-medium">-<small></small></h5>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                            <p class="text-secondary small mb-1">Photo Out</p>
                                            <h5 class="fw-medium">-<small></small></h5>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                            <p class="text-secondary small mb-1">Clock Out</p>
                                            <h5 class="fw-medium">-<small></small></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-theme" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>