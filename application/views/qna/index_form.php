<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Give your best answer to build this company.</p>
            </div>
            <div class="col col-sm-auto">
                <form method="POST" id="form_filter">
                    <div class="input-group input-group-md reportrange">
                        <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                        <input type="hidden" name="start" value="" id="start" readonly/>
                        <input type="hidden" name="end" value="" id="end" readonly/>
                        <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
                    </div>
                </form>
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
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-question-square-fill h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List QnA</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                            <button type="button" class="btn btn-md btn-outline-theme" onclick="add_qna()">Add QnA</button>
                            <button type="button" class="btn btn-md btn-outline-info" onclick="list_proses()">Proses QnA</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card mb-2">
                        <div class="card-body bg-gradient-theme-light theme-blue">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="rounded bg-theme text-white p-3">
                                        <p>Start <i class="bi bi-play vm"></i></p>
                                    </div>
                                </div>
                                <div class="col align-self-center">
                                    <div class="row">
                                        <div class="col-12 col-lg">
                                            <p class="mb-0">Engagement Karyawan</p>
                                            <p class="text-secondary small">Pengantar : QnA Engagement Karyawan,QnA Engagement Karyawan,QnA Engagement Karyawan,QnA Engagement Karyawan,QnA Engagement Karyawan,QnA Engagement Karyawan,QnA Engagement Karyawan,QnA Engagement Karyawan,QnA Engagement Karyawan</p>
                                        </div>
                                        <div class="col-12 col-lg-auto text-start text-xl-end">
                                            <p class="text-secondary small mb-0">Author:</p>
                                            <p>Maxartkiller</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- List Result QnA -->
         <style>
            th .sorting, .sorting_asc, .sorting_desc {
                background : none !important;
            }
         </style>
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header"> 
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-card-list h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Result QnA</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="" style="padding: 10px;">
                        <table id="dt_list_gemba" class="table table-striped dt-responsive" style="width:100%">
                            <!-- <thead>
                                <tr>
                                    <th>Id Genba</th>
                                    <th>Date Plan</th>
                                    <th>Type Genba</th>
                                    <th>Lokasi</th>
                                    <th>Evaluasi</th>
                                    <th>Jml Peserta</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                </tr>
                            </thead> -->
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal Add -->
<div class="modal fade" id="modal_add_plan" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_plan">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                        <p class="text-secondary small">Add Plan Genba</p>
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
                    <div class="col-12 col-lg-12 col-xl-12 mb-4">
                        <h6 class="title">Detail <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                        <div class="row">
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-date"></i></span>
                                        <div class="form-floating">
                                            <input type="text" id="tgl_plan" name="tgl_plan" class="form-control border-start-0" placeholder="Tgl Plan">
                                            <label>Plan Date <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-list"></i></span>
                                        <div class="form-floating">
                                            <select name="tipe_gemba" id="tipe_gemba" class="form-control">
                                                <option value="#" selected disabled>-- Choose Tipe --</option>
                                                <?php foreach ($tipe as $row) : ?>
                                                    <option value="<?= $row->id ?>"><?= $row->tipe_gemba ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>Tipe <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-geo"></i></span>
                                        <div class="form-floating">
                                            <input type="text" id="lokasi" name="lokasi" class="form-control border-start-0" placeholder="Lokasi">
                                            <label>Location <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-md btn-outline-theme" id="btn_save" onclick="save_gemba()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->

<!-- Modal List Proses QnA -->
<div class="modal fade" id="modal_list_proses" tabindex="-1" aria-labelledby="modalListProsesLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-list h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalListProsesLabel">List Proses</h6>
                    <p class="text-secondary small">Question and Answer (QnA)</p>
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
                <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="" style="padding: 10px;">
                                <table id="dt_list_proses" class="table table-striped dt-responsive" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Id Genba</th>
                                            <th>Date Plan</th>
                                            <th>Type Genba</th>
                                            <th>Lokasi</th>
                                            <th>Evaluasi</th>
                                            <th>Jml Peserta</th>
                                            <th>Created At</th>
                                            <th>Created By</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal List Proses QnA -->

<!-- Modal Proses Gemba -->
<div class="modal fade" id="modal_proses_gemba" tabindex="-1" aria-labelledby="modalListProsesLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalListProsesLabel">Proses</h6>
                    <p class="text-secondary small">Plan Genba</p>
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
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <h6 class="title"><span id="detail_tipe_gemba">...</span></h6>
                    <div class="row align-items-center mb-3">
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-calendar-event h5 avatar avatar-40 bg-warning text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_plan_date">...</h6>
                                    <p class="text-secondary small">Plan Date</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-geo h5 avatar avatar-40 bg-danger text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_location">...</h6>
                                    <p class="text-secondary small">Location</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6 class="title">Detail Evaluation <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                    <div class="row">
                        <input type="hidden" id="id_gemba" name="id_gemba">
                        <div class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-people"></i></span>
                                    <div class="form-floating">
                                        <input type="number" id="peserta" name="peserta" class="form-control border-start-0" placeholder="Tgl Plan" onkeypress="return hanyaAngka(event)">
                                        <label>Jumlah Peserta <i class="text-danger">*</i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journal-text"></i></span>
                                    <div class="form-floating">
                                        <textarea name="evaluasi" id="evaluasi" cols="30" rows="10" class="form-control border-start-0" placeholder="Evaluasi"></textarea>
                                        <label>Evaluation <i class="text-danger">*</i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-check-square"></i></span>
                                    <div class="form-floating">
                                        <select name="status_akhir" id="status_akhir" class="form-control">
                                            <option value="#" selected disabled>-- Choose Status --</option>
                                            <?php foreach ($status_strategy as $key) : ?>
                                                <option value="<?= $key->id; ?>"><?= $key->status; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label>Status <i class="text-danger">*</i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-md btn-outline-theme mb-3" onclick="save_proses_evaluasi()" id="btn_save_proses_evaluasi">Save</button>
                    <h6 class="title">List Checklist <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                </div>
                <div id="list_detail_gemba" class="row"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Proses Gemba -->

<!-- Modal Result Gemba -->
<div class="modal fade" id="modal_result_gemba" tabindex="-1" aria-labelledby="modalResultGembaLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-list h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalResultGembaLabel">List Result</h6>
                    <p class="text-secondary small">Plan Genba</p>
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
                <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="" style="padding: 10px;">
                                <table id="dt_result_gemba" class="table table-striped dt-responsive" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Concern</th>
                                            <th>Monitoring</th>
                                            <th>Status</th>
                                            <th>File</th>
                                            <th>Link</th>
                                            <th>Progres</th>
                                            <th>Updated At</th>
                                            <th>Updated By</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Result Gemba -->

<!-- Modal Show QnA -->
<div class="modal fade" id="modal_show_qna" tabindex="-1" aria-labelledby="modalShowQnALabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-question-circle h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalShowQnALabel">Engagement Karyawan</h6>
                    <p class="text-secondary small">Question and Answer (QnA)</p>
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
                <!-- <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <h6 class="title"><span id="detail_tipe_gemba">...</span></h6>
                    <div class="row align-items-center mb-3">
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-calendar-event h5 avatar avatar-40 bg-warning text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_plan_date">...</h6>
                                    <p class="text-secondary small">Plan Date</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-geo h5 avatar avatar-40 bg-danger text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_location">...</h6>
                                    <p class="text-secondary small">Location</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6 class="title">Detail Evaluation <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                    <div class="row">
                        <input type="hidden" id="id_gemba" name="id_gemba">
                        <div class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-people"></i></span>
                                    <div class="form-floating">
                                        <input type="number" id="peserta" name="peserta" class="form-control border-start-0" placeholder="Tgl Plan" onkeypress="return hanyaAngka(event)">
                                        <label>Jumlah Peserta <i class="text-danger">*</i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journal-text"></i></span>
                                    <div class="form-floating">
                                        <textarea name="evaluasi" id="evaluasi" cols="30" rows="10" class="form-control border-start-0" placeholder="Evaluasi"></textarea>
                                        <label>Evaluation <i class="text-danger">*</i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-check-square"></i></span>
                                    <div class="form-floating">
                                        <select name="status_akhir" id="status_akhir" class="form-control">
                                            <option value="#" selected disabled>-- Choose Status --</option>
                                            <?php foreach ($status_strategy as $key) : ?>
                                                <option value="<?= $key->id; ?>"><?= $key->status; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label>Status <i class="text-danger">*</i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-md btn-outline-theme mb-3" onclick="save_proses_evaluasi()" id="btn_save_proses_evaluasi">Save</button>
                    <h6 class="title">List Checklist <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                </div>
                <div id="list_detail_gemba" class="row"></div> -->
                <div class="row h-100 z-index-1 position-relative">
                    <div class="col-12 mb-auto">
                        <!-- header -->
                        <header class="header">
                            <!-- Fixed navbar -->
                            <nav class="navbar">
                                <div class="container-fluid">
                                    <a class="navbar-brand" href="onboarding.html#">
                                        <div class="row">
                                            <div class="col-auto"><img src="assets/img/favicon48.png" class="mx-100" alt="" /></div>
                                            <div class="col ps-0 align-self-center">
                                                <h5 class="fw-normal text-dark">WinDOORS</h5>
                                                <p class="small text-secondary">Admin App UI</p>
                                            </div>
                                        </div>
                                    </a>
                                    <div>
                                        <button type="button" class="btn btn-link text-secondary text-center" id="addtohome"><i class="bi bi-cloud-download-fill me-0 me-lg-1"></i> <span class="d-none d-lg-inline-block">Install</span></button>
                                        <a href="signup.html" class="btn btn-link text-secondary text-center"><i class="bi bi-person-circle me-0 me-lg-1"></i> <span class="d-none d-lg-inline-block">Sign up</span></a>
                                    </div>
                                </div>
                            </nav>
                        </header>
                        <!-- header ends -->
                    </div>
                    <div class="col-12  align-self-center py-4">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-11 col-lg-10 col-xl-7 col-xxl-6">
                                <div class="card bg-blur">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-auto">
                                                <img src="assets/img/favicon32.png" alt="" />
                                            </div>
                                            <div class="col align-self-center text-center">
                                                <h5 class="fw-normal">User Onboarding</h5>
                                            </div>
                                            <div class="col-auto">
                                                <a href="home.html">Skip <i class="bi bi-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!-- content swiper -->
                                        <div class="swiper onboarding-swiper swiper-no-swiping h-100 w-100">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6 text-center position-relative py-4">
                                                            <img src="https://getwindoors.com/html/assets/img/onboarding1.png" alt="" class="mw-100 mb-4" />

                                                            <div class="avatar avatar-120 coverimg rounded-circle ms-4 absoluteuploaduser-4">
                                                                <i class="bi bi-upload bg-theme avatar avatar-40 rounded-circle"></i>
                                                                <input type="file" accept="image/*" id="userphotoonboarding">
                                                                <img src="assets/img/user-1.jpg" alt="" id="journeyuserpic" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 align-self-center py-5">
                                                            <p class="h4 fw-light mb-3">Who is going to use this app?</p>
                                                            <p class="text-secondary small mb-4">
                                                                Please share your <b>Name</b> and <b>Photo</b> to display in application. This will be logged in user name wherever mentioned. This is just to make more intuitive communication with interface.
                                                            </p>
                                                            <form class="">
                                                                <!-- Form elements -->
                                                                <div class="form-group mb-2 position-relative check-valid is-valid">
                                                                    <div class="input-group input-group-lg">
                                                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-circle"></i></span>
                                                                        <div class="form-floating">
                                                                            <input type="text" placeholder="Username" value="Maxartkiller" required class="form-control border-start-0" autofocus id="usernamevalue">
                                                                            <label for="usernamevalue">Your good name</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6 text-center position-relative py-2">
                                                            <img src="https://getwindoors.com/html/assets/img/onboarding-2.png" alt="" class="mw-100" />
                                                        </div>
                                                        <div class="col-12 col-md-6 align-self-center">
                                                            <p class="h4 fw-light mb-3">What's your<br>Industries or Business Domain?</p>
                                                            <p class="text-secondary small mb-4">
                                                                Selection of Industry or Business domain helps us to choose demo layout or formatting you would like as most of the preferences and based on market standard practices.
                                                            </p>
                                                            <div class="row gx-3" id="domain-select">
                                                                <div class="col-auto">
                                                                    <div class="select-box text-center mb-3" data-title="finance">
                                                                        <div class="avatar avatar-60">
                                                                            <i class="bi bi-coin"></i>
                                                                        </div>
                                                                        <p class="small">Finance</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="select-box text-center mb-3" data-title="network">
                                                                        <div class="avatar avatar-60">
                                                                            <i class="bi bi-wifi"></i>
                                                                        </div>
                                                                        <p class="small">Network</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="select-box text-center mb-3" data-title="social">
                                                                        <div class="avatar avatar-60">
                                                                            <i class="bi bi-people"></i>
                                                                        </div>
                                                                        <p class="small">Social</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="select-box text-center mb-3" data-title="inventory">
                                                                        <div class="avatar avatar-60">
                                                                            <i class="bi bi-basket"></i>
                                                                        </div>
                                                                        <p class="small">Inventory</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="select-box text-center mb-3" data-title="learning">
                                                                        <div class="avatar avatar-60">
                                                                            <i class="bi bi-book"></i>
                                                                        </div>
                                                                        <p class="small">Learing</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="row h-100">
                                                        <div class="col-12 col-md-6 text-center align-self-center position-relative py-3">
                                                            <img src="https://getwindoors.com/html/assets/img/onboarding-3.png" alt="" class="mw-100" />
                                                        </div>
                                                        <div class="col-12 col-md-6 align-self-center pt-4">
                                                            <p class="h4 fw-light mb-3">Best brand color<br>It create identity as well as trust.</p>
                                                            <p class="text-secondary small mb-4">
                                                                Our template comes with Unlimited customized color scheme possibility. Here some color set are predefined to choose from.
                                                            </p>
                                                            <div class="row gx-3" id="theme-select">
                                                                <div class="col-auto">
                                                                    <div class="select-box text-center mb-2" data-title="theme-blue">
                                                                        <div class="avatar avatar-50">
                                                                            <span class="avatar avatar-40 bg-blue"></span>
                                                                        </div>
                                                                        <p class="small">Blue</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="select-box text-center mb-2" data-title="theme-indigo">
                                                                        <div class="avatar avatar-50">
                                                                            <span class="avatar avatar-40 bg-indigo"></span>
                                                                        </div>
                                                                        <p class="small">Indigo</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="select-box text-center mb-2" data-title="theme-purple">
                                                                        <div class="avatar avatar-50">
                                                                            <span class="avatar avatar-40 bg-purple"></span>
                                                                        </div>
                                                                        <p class="small">Purple</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="select-box text-center mb-2" data-title="theme-pink">
                                                                        <div class="avatar avatar-50">
                                                                            <span class="avatar avatar-40 bg-pink"></span>
                                                                        </div>
                                                                        <p class="small">Pink</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="select-box text-center mb-2" data-title="theme-red">
                                                                        <div class="avatar avatar-50">
                                                                            <span class="avatar avatar-40 bg-red"></span>
                                                                        </div>
                                                                        <p class="small">Red</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="select-box text-center mb-2" data-title="theme-orange">
                                                                        <div class="avatar avatar-50">
                                                                            <span class="avatar avatar-40 bg-orange"></span>
                                                                        </div>
                                                                        <p class="small">Orange</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="select-box text-center mb-2" data-title="theme-yellow">
                                                                        <div class="avatar avatar-50">
                                                                            <span class="avatar avatar-40 bg-yellow"></span>
                                                                        </div>
                                                                        <p class="small">Yellow</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="select-box text-center mb-2" data-title="theme-green">
                                                                        <div class="avatar avatar-50">
                                                                            <span class="avatar avatar-40 bg-green"></span>
                                                                        </div>
                                                                        <p class="small">Green</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="select-box text-center mb-2" data-title="theme-teal">
                                                                        <div class="avatar avatar-50">
                                                                            <span class="avatar avatar-40 bg-teal"></span>
                                                                        </div>
                                                                        <p class="small">Teal</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="select-box text-center mb-2" data-title="theme-cyan">
                                                                        <div class="avatar avatar-50">
                                                                            <span class="avatar avatar-40 bg-cyan"></span>
                                                                        </div>
                                                                        <p class="small">Cyan</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row align-items-center mb-4">
                                                                <div class="col-auto">
                                                                    <div class="avatar avatar-70 my-3 text-center rounded">
                                                                        <img src="https://getwindoors.com/html/assets/img/logo.png" alt="" class="mw-100" id="companylogolight" />
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div>
                                                                        <label for="companylogolightinput" class="form-label">Upload company logo </label><br>
                                                                        <input class="form-control d-none" accept="image/*" type="file" id="companylogolightinput">
                                                                        <button class="btn btn-theme" onclick="$(this).prev().click()"><i class="bi bi-camera"></i> Upload</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- content ends -->
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-auto">
                                                <button class="btn btn-theme btn-square btn-prev"><i class="bi bi-arrow-left"></i></button>
                                            </div>
                                            <div class="col align-self-center">
                                                <div class="swiper-pagination pagination-smallline position-relative bottom-0"></div>
                                            </div>
                                            <div class="col-auto">
                                                <button class="btn btn-theme btn-square btn-next"><i class="bi bi-arrow-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Show QnA -->