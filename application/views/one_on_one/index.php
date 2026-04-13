<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h6 class="mb-0"><u><span class="text-secondary">Rule of The Game</span></u> <?= $pageTitle; ?></h6>
            </div>
            <div class="col col-sm-auto">
                <!-- <form method="POST" id="form_filter">
                    <div class="input-group input-group-md reportrange">
                        <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                        <input type="hidden" name="start" value="" id="start" readonly />
                        <input type="hidden" name="end" value="" id="end" readonly />
                        <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
                    </div>
                </form> -->
            </div>
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
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row align-items-center page-title">
                        <div class="col-auto">
                            <i class="bi bi-list-columns h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">Resume Sales</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0 border border-1 rounded">
                            <form method="POST" id="form_filter" style="margin-left: 15px !important;">
                                <div class="input-group input-group-md reportrange_resume_sales">
                                    <input type="text" class="form-control range_resume_sales bg-none px-0" style="cursor: pointer;" id="titlecalendar_resume_sales">
                                    <input type="hidden" name="start_resume_sales" value="" id="start_resume_sales" readonly />
                                    <input type="hidden" name="end_resume_sales" value="" id="end_resume_sales" readonly />
                                    <span class="input-group-text text-secondary bg-none" id="titlecalandershow_resume_sales"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </form>
                        </div>
                        <div class="col-auto ps-0">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="" style="padding: 10px;">
                        <table id="dt_list_resume_sales" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sales</th>
                                    <th>Ass.BM</th>
                                    <th>BM</th>
                                    <th>Booking</th>
                                    <th>Database</th>
                                    <th>FU</th>
                                    <th>Ceklok</th>
                                    <th>One on One</th>
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
                    <div class="row align-items-center page-title">
                        <div class="col-auto">
                            <i class="bi bi-repeat-1 h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List One on One</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0 border border-1 rounded">
                            <form method="POST" id="form_filter" style="margin-left: 15px !important;">
                                <div class="input-group input-group-md reportrange">
                                    <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                                    <input type="hidden" name="start" value="" id="start" readonly />
                                    <input type="hidden" name="end" value="" id="end" readonly />
                                    <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </form>
                        </div>
                        <div class="col-auto ps-0">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <!-- <i class="bi bi-repeat-1 h5 avatar avatar-40 bg-light-theme rounded"></i> -->
                        </div>
                        <div class="col-auto align-self-center">
                            <!-- <h6 class="fw-medium mb-0">List One on One</h6> -->
                        </div>
                        <div class="col-auto ms-auto ps-0">
                            <button type="button" class="btn btn-md btn-outline-theme" onclick="add_coaching()"><i class="bi bi-plus-square"></i>&nbsp;&nbsp;Tambah</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="" style="padding: 10px;">
                        <table id="dt_list_coaching" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id One</th>
                                    <th>Karyawan</th>
                                    <th>Tempat</th>
                                    <th>Tanggal</th>
                                    <th>Atasan</th>
                                    <th width="20%">Indikator (Act/Tgt)</th>
                                    <th>Foto</th>
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
                    <div class="row align-items-center page-title">
                        <div class="col-auto">
                            <i class="bi bi-list-columns h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">Resume One on One</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0 border border-1 rounded">
                            <form method="POST" id="form_filter" style="margin-left: 15px !important;">
                                <div class="input-group input-group-md reportrange_resume">
                                    <input type="text" class="form-control range_resume bg-none px-0" style="cursor: pointer;" id="titlecalendar_resume">
                                    <input type="hidden" name="start_resume" value="" id="start_resume" readonly />
                                    <input type="hidden" name="end_resume" value="" id="end_resume" readonly />
                                    <span class="input-group-text text-secondary bg-none" id="titlecalandershow_resume"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </form>
                        </div>
                        <div class="col-auto ps-0">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="" style="padding: 10px;">
                        <table id="dt_list_resume" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id One</th>
                                    <th>Karyawan</th>
                                    <th>Tanggal</th>
                                    <th style="min-width: 150px;">Indikator (Act/Tgt)</th>
                                    <th>Identifikasi</th>
                                    <th>Solusi</th>
                                    <th>Target Solusi</th>
                                    <th>Deadline Solusi</th>
                                    <th>Komitmen</th>
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

<!-- Modal Add -->
<div class="modal fade" id="modal_add_coaching" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form_coaching">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-blockquote-left h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                        <p class="text-secondary small">Add One on One</p>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="dropdown d-inline-block">
                            <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close" onclick="cancel_one()">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="col-12 col-lg-12 col-xl-12 mb-4">
                        <h6 class="title">Detail <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                        <input type="hidden" id="id_one_header" name="id_one_header">
                        <input type="hidden" id="target_1" name="target_1">
                        <input type="hidden" id="actual_1" name="actual_1">
                        <input type="hidden" id="target_2" name="target_2">
                        <input type="hidden" id="actual_2" name="actual_2">
                        <input type="hidden" id="target_3" name="target_3">
                        <input type="hidden" id="actual_3" name="actual_3">
                        <input type="hidden" id="target_4" name="target_4">
                        <input type="hidden" id="actual_4" name="actual_4">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-bounding-box"></i></span>
                                        <div class="form-floating">
                                            <select name="karyawan" id="karyawan" class="form-control" onchange="change_karyawan()">
                                                <option value="#">-Choose Employee-</option>
                                                <?php foreach ($karyawan as $kar) { ?>
                                                    <option value="<?= $kar->user_id; ?>|<?= $kar->kode; ?>|<?= $kar->designation_id; ?>|<?= $kar->id_user; ?>"><?= $kar->employee_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Karyawan <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-up"></i></span>
                                        <div class="form-floating">
                                            <select name="atasan" id="atasan" class="form-control">
                                                <option value="#">-Choose Employee-</option>
                                                <?php foreach ($atasan as $up) { ?>
                                                    <option value="<?= $up->user_id; ?>"><?= $up->employee_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Atasan Langsung <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-geo-alt"></i></span>
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0" name="tempat" id="tempat" placeholder="Tempat">
                                            <label>Tempat <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-event"></i></span>
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0 bg-white" name="tanggal" id="tanggal" readonly>
                                            <label>Tanggal <small>(Auto Today)</small><i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Start Game One on One -->
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2">
                                <div class="card">
                                    <div class="card-header">
                                        <p><b>Indikator</b> | <b>Actual/Target</b></p>
                                    </div>
                                    <div class="card-body" id="list_indikator">
                                        <p>1. Booking | 0/0 &nbsp;<i class="bi bi-plus-square text-success text-end" onclick="add_identifikasi(1)" style="cursor:pointer;"></i></p>
                                        <div class="row" id="list_feedback_1"></div>
                                        <p>2. Database | 0/0 &nbsp;<i class="bi bi-plus-square text-success" onclick="add_identifikasi(2)" style="cursor:pointer;"></i></p>
                                        <div class="row" id="list_feedback_2"></div>
                                        <p>3. FU | 0%/0% &nbsp;<i class="bi bi-plus-square text-success" onclick="add_identifikasi(3)" style="cursor:pointer;"></i></p>
                                        <div class="row" id="list_feedback_3"></div>
                                        <p>4. Ceklok | 0%/0% &nbsp;<i class="bi bi-plus-square text-success" onclick="add_identifikasi(4)" style="cursor:pointer;"></i></p>
                                        <div class="row" id="list_feedback_4"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Game One on One -->
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-folder-check"></i></span>
                                        <div class="form-floating">
                                            <label>Foto <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                    <input type="file" class="form-control border-start-0" id="foto" name="foto" autocomplete="off" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="checkbox" name="" id="ceklis_pekerjaan">
                            <label for="ceklis_pekerjaan">Berhubungan dengan pekerjaan ? </label>
                        </div>
                    </div>
                    <div class="row row_pekerjaan" style="display: none;">
                        <div class="mb-3 col-12">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme border-end-0"><i class="bi bi-house"></i></span>
                                    <div class="form-floating bg-white">
                                        <select name="project" id="id_project" class="mb-2 mt-4-5 w-90 border-0" style="display: none;">
                                            <option value="" disabled selected>- Pilih Divisi -</option>
                                            <?php foreach ($project as $item) : ?>
                                                <option value="<?= $item->id_project ?>"><?= $item->project ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label class="form-label-custom required small" for="id_pic">Divisi</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme border-end-0"><i class="bi bi-circle-fill"></i></span>
                                    <div class="form-floating bg-white">
                                        <select name="pekerjaan" id="id_pekerjaan" class="mb-2 mt-4-5 w-90 border-0" style="display: none;">
                                        </select>
                                        <label class="form-label-custom required small" for="id_pic">SO</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme border-end-0"><i class="bi bi-circle"></i></span>
                                    <div class="form-floating bg-white">
                                        <select name="sub_pekerjaan" id="id_sub_pekerjaan" class="mb-2 mt-4-5 w-90 border-0" style="display: none;">
                                        </select>
                                        <label class="form-label-custom required small" for="id_pic">SI</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme border-end-0"><i class="bi bi-dash-circle"></i></span>
                                    <div class="form-floating bg-white">
                                        <select name="detail_pekerjaan" id="id_detail_pekerjaan" class="mb-2 mt-4-5 w-90 border-0" style="display: none;" multiple>
                                        </select>
                                        <label class="form-label-custom required small" for="id_pic">Tasklist</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-danger" style="margin-right:10px;" onclick="cancel_one()" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-md btn-outline-theme" id="btn_save" onclick="save_one()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->

<!-- Modal Add Identifikasi -->
<div class="modal fade" id="modal_add_identifikasi" tabindex="-1" aria-labelledby="modalAddIdentifikasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddIdentifikasiLabel">Add Feedback</h6>
                    <p class="text-secondary small">Indikator <b id="txt_indikator">Booking</b></p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form id="form_indikator">
                    <input type="hidden" id="total_feedback" name="total_feedback" value="1">
                    <input type="hidden" id="indikator_feedback" name="indikator_feedback" value="1">
                    <input type="hidden" id="id_one_feedback" name="id_one_feedback" value="">
                    <input type="hidden" id="target_indikator" name="target_indikator" value="">
                    <input type="hidden" id="actual_indikator" name="actual_indikator" value="">
                    <div class="col-12 col-lg-12 col-xl-12 mb-4" id="feedback_1">
                        <h6 class="title">1. Detail Feedback <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                        <div class="row">
                            <div class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <input type="text" id="identifikasi_1" name="identifikasi[]" class="form-control border-start-0" placeholder="Identifikasi">
                                            <label>Identifikasi <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-lightbulb"></i></span>
                                        <div class="form-floating">
                                            <input type="text" id="solusi_1" name="solusi[]" class="form-control border-start-0" placeholder="Solusi">
                                            <label>Solusi <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-app-indicator"></i></span>
                                        <div class="form-floating">
                                            <input type="text" id="target_solusi_1" name="target_solusi[]" class="form-control border-start-0" placeholder="Target">
                                            <label>Target <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-date"></i></span>
                                        <div class="form-floating">
                                            <input type="text" id="deadline_solusi_1" name="deadline_solusi[]" class="form-control border-start-0 tanggal" placeholder="Deadline">
                                            <label>Deadline <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journal-text"></i></span>
                                        <div class="form-floating">
                                            <input type="text" id="komitmen_1" name="komitmen[]" class="form-control border-start-0" placeholder="Komitmen">
                                            <label>Komitmen <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="list_identifikasi"></div>
                </form>
                <button type="button" class="btn btn-md btn-outline-success mb-3" style="margin-right:5px;" onclick="plus_identifikasi()" id="btn_plus_identifikasi"><i class="bi bi-plus-square"></i></button>
                <button type="button" class="btn btn-md btn-outline-danger mb-3" style="display:none;" onclick="minus_identifikasi()" id="btn_minus_identifikasi"><i class="bi bi-dash-square"></i></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-md btn-outline-theme" id="btn_save_indikator" onclick="save_indikator()">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add Identifikasi -->