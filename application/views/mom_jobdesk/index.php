<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Deskripsi Page</p>
            </div>
            <div class="col col-sm-auto">
                <form method="POST" id="form_filter">
                    <div class="input-group input-group-md reportrange">
                        <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                        <input type="hidden" name="start" value="" id="start" readonly />
                        <input type="hidden" name="end" value="" id="end" readonly />
                        <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
                    </div>
                </form>
            </div>
            <div class="col-auto ps-0"></div>
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
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto mb-2">
                            <i class="bi bi-journal-text h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center mb-2">
                            <h6 class="fw-medium">List Notulen</h6>
                        </div>
                        <div class="col-auto-right" align="right">
                            <?php
                            $user_allow = [1, 8204, 803];
                            $user_id = $this->session->userdata('user_id');
                            ?>
                            <?php if (in_array($user_id, $user_allow)) : ?>
                                <button type="button" class="btn btn-md btn-outline-danger mb-2" onclick="list_verif(2)"><i class="bi bi-bookmark"></i> List Verif Owner</button>
                                <?php endif; ?>
                            <button type="button" class="btn btn-md btn-outline-danger mb-2" onclick="list_verif(1)"><i class="bi bi-bookmark"></i> List Verif PDCA</button>
                            <button type="button" class="btn btn-md btn-outline-secondary mb-2" onclick="list_eskalasi()"><i class="bi bi-people"></i> List Delegasi</button>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_list_mom" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="150px">#</th>
                                    <th>No MoM</th>
                                    <th width="170px">Judul</th>
                                    <th>Meeting</th>
                                    <th>Department</th>
                                    <th>Peserta</th>
                                    <th>Agenda</th>
                                    <th>Pembahasan</th>
                                    <th>Tempat</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>

                                    <!-- addnew -->
                                    <th>List Peserta</th>

                                    <th>Created By</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-journals h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">Resume MoM Jobdesk</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0"></div>
                    </div>
                </div>
                <div class="card-body">
                    <p><span class="text-danger">*Note</span> : Check Detail Lock di Kolom <b>Progres</b></p>
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_list_rekap" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center align-middle">User</th>
                                    <th rowspan="2" class="text-center align-middle">Jabatan</th>
                                    <th rowspan="2" class="text-center align-middle">W1</th>
                                    <th rowspan="2" class="text-center align-middle">W2</th>
                                    <th rowspan="2" class="text-center align-middle">W3</th>
                                    <th rowspan="2" class="text-center align-middle">W4</th>
                                    <th rowspan="2" class="text-center align-middle">W5</th>
                                    <th colspan="5" class="text-center">Kategori</th>
                                    <th rowspan="2" class="text-center align-middle bg-light-yellow">Progres</th>
                                    <th rowspan="2" class="text-center align-middle bg-light-red">Revisi</th>
                                    <th rowspan="2" class="text-center align-middle bg-light-green">Done</th>
                                    <th rowspan="2" class="text-center align-middle bg-light-green">Ontime</th>
                                    <th rowspan="2" class="text-center align-middle bg-light-red">Late</th>
                                    <th rowspan="2" class="text-center align-middle bg-light-red">Freq Revisi</th>
                                    <th rowspan="2" class="text-center align-middle bg-light-red">Freq Lock</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Tasklist</th>
                                    <th class="text-center">Keputusan</th>
                                    <th class="text-center">Consistency Daily</th>
                                    <th class="text-center">Consistency Weekly</th>
                                    <th class="text-center">Consistency Monthly</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-journals h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">Resume MoM Jobdesk Weekly</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0"></div>
                    </div>
                </div>
                <div class="card-body">
                    <p><span class="text-danger">*Note</span> : Lock Absen Setiap Sabtu Perminggunya <b></b></p>
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_resume_pembelajar_3" class="table table-sm table-striped text-nowrap" style="width:100%">
                            <thead id="dt_resume_head_3">
                                <tr>
                                    <th>Nama</th>
                                    <th>Company</th>
                                    <th>Jabatan</th>
                                    <th>W1</th>
                                    <th>W2</th>
                                    <th>W3</th>
                                    <th>W4</th>
                                    <th>W5</th>
                                </tr>
                            </thead>
                            <tbody id="dt_resume_body_3"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal Detail -->
<div class="modal fade" id="modal_detail_mom" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content" style="overflow-y: auto;">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-journal-text h5 avatar avatar-40 bg-light text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                    <p class="text-white small">Edit Result Meeting</p>
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
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <h6 class="title">Notulen</h6>
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="hidden" id="total_issue" value="1">
                                    <table id="dt_mom_result_e" class="table table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="15%">Hasil/Topik/Judul</th>
                                                <th width="15%">Issue</th>
                                                <th width="20%">Strategy</th>
                                                <th width="10%">Kategorisasi</th>
                                                <!-- <th width="10%">SI</th> -->
                                                <th width="10%">Level</th>
                                                <th width="10%">Deadline</th>
                                                <th width="10%">PIC</th>
                                                <th width="10%">Ekspektasi</th>
                                                <th width="10%">Verified</th>
                                                <th width="10%">Verified By</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Detail -->

<!-- Modal Detail Rekap -->
<div class="modal fade" id="modal_detail_rekap" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content" style="overflow-y: auto;">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-journals h5 avatar avatar-40 bg-light text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                    <p class="text-white small">Resume MoM</p>
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
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <h6 class="title">Detail Rekap</h6>
                    <p><span class="text-danger">*Note Lock</span> :</p>
                    <ol>
                        <li>Jika <b>Deadline Strategy</b> <u>kurang dari atau sama dengan</u> hari ini dan <b>Progres</b> <u>kurang dari</u> 100%</li>
                        <li>Jika <b>Deadline Goals</b> <u>kurang dari atau sama dengan</u> hari ini dan <b>Status</b> <u>belum</u> Done</li>
                        <li>Tasklist MoM di Lock mulai dari Deadline Tanggal <b>(05 Jan 2024)</b></li>
                    </ol>
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_detail_rekap" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Locked</th>
                                    <th>ID MOM</th>
                                    <th>Tgl Meeting</th>
                                    <th>User</th>
                                    <th>Topik</th>
                                    <th>Issue</th>
                                    <th>Strategy</th>
                                    <th>Kategori</th>
                                    <th>Level</th>
                                    <th>Deadline Goals</th>
                                    <th>Deadline Strategy</th>
                                    <th>Done</th>
                                    <th>Leadtime</th>
                                    <th>Status</th>
                                    <th>Progres %</th>
                                    <th>Evaluation</th>
                                    <th>File</th>
                                    <th>Link</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                    <th>Verified Note</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Detail Rekap -->

<div class="modal fade" id="modal_list_verif" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content" style="overflow-y: auto;">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-journal-text h5 avatar avatar-40 bg-light text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal_title_list_verif">List Verified Owner</h6>
                    <p class="text-white small"></p>
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
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table id="dt_list_verif" class="table table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="15%">Hasil/Topik/Judul</th>
                                                <th width="15%">Issue</th>
                                                <th width="20%">Strategy</th>
                                                <th width="5%">Kategorisasi</th>
                                                <!-- <th width="10%">SI</th> -->
                                                <th width="5%">Level</th>
                                                <th width="5%">Deadline</th>
                                                <th width="10%">PIC</th>
                                                <th width="10%">Ekspektasi</th>
                                                <th width="15%">Evaluasi</th>
                                                <th width="10%">Created By</th>
                                                <th width="10%">Verified</th>
                                                <th width="10%">Verified By</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_list_eskalasi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content" style="overflow-y: auto;">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-journal-text h5 avatar avatar-40 bg-light text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddLabel">List Eskalasi</h6>
                    <p class="text-white small"></p>
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
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table id="dt_list_eskalasi" class="table table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <!-- <th width="15%">Hasil/Topik/Judul</th> -->
                                                <th width="15%">Issue</th>
                                                <th width="20%">Strategy</th>
                                                <!-- <th width="5%">Kategorisasi</th> -->
                                                <th width="5%">Deadline</th>
                                                <th width="10%">PIC</th>
                                                <th width="10%">Status</th>
                                                <th width="5%">Progres</th>
                                                <th width="15%">Evaluasi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>