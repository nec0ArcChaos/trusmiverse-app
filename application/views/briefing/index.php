<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Pembelajar | Proaktif | Penebar Energi Positif</p>
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
                            <i class="bi bi-blockquote-left h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Briefing</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                            <button type="button" class="btn btn-md btn-outline-theme" data-bs-toggle="modal" data-bs-target="#modal_add_briefing" onclick="modal_add_briefing()">Add Briefing</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="" style="padding: 10px;">
                        <table id="dt_list_briefing" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id Briefing</th>
                                    <th>Review</th>
                                    <th>Plan</th>
                                    <th>Informasi</th>
                                    <th>Motivasi</th>
                                    <th>Peserta</th>
                                    <th>Sanksi</th>
                                    <th>Foto</th>
                                    <th>Feedback BM</th>
                                    <th>Review BM</th>
                                    <th>Keputusan BM</th>
                                    <th>Feedback Head</th>
                                    <th>User</th>
                                    <th>Company</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set d-none" id="div_detail_briefing">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-blockquote-left h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">Detail Sales Briefing</h6>
                        </div>
                        <div class="ms-auto col col-sm-auto bg-light">
                            <form method="POST" id="form_filter_detail">
                                <div class="input-group input-group-md reportrange_detail">
                                    <input type="text" class="form-control range_detail bg-none px-0" style="cursor: pointer;" id="titlecalendardetail">
                                    <input type="hidden" name="start_detail" value="" id="start_detail" readonly />
                                    <input type="hidden" name="end_detail" value="" id="end_detail" readonly />
                                    <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="" id="detail_briefing">
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-blockquote-left h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">lock Briefing Daily</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="" style="padding: 10px;">
                        <table id="tbl_lock_brif_d_3" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Company</th>
                                    <th>Jabatan</th>
                                    <th>Total Lock</th>
                                    <th>Lock Today</th>

                                    
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-blockquote-left h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">lock Briefing Weekly</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                        </div>
                    </div>
                </div>
                <div class="card-body" style="width: 100%;">
                    <div class="" style="padding: 10px; overflow:scroll;">
                        <table id="dt_resume_pembelajar_3" class="table table-sm table-striped text-nowrap" style="width:100%">
                            <thead id="dt_resume_head_3">
                                <!-- <tr>
                                    <th>Nama</th>
                                    <th>Company</th>
                                    <th>Jabatan</th>
                                    <th>W1</th>
                                    <th>W2</th>
                                    <th>W3</th>
                                    <th>W4</th>
                                    <th>W5</th>
                                    
                                </tr> -->
                            </thead>
                            <tbody id="dt_resume_body_3"></tbody>
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
                            <i class="bi bi-blockquote-left h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">Resume Ketercapaian Event Project</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                        </div>
                    </div>
                </div>
                <div class="card-body" style="width: 100%;">
                    <div class="" style="padding: 10px; overflow:scroll;">
                        <table id="dt_resume_ketercapaian" class="table table-sm table-striped text-nowrap" style="width:100%">
                            <thead id="dt_resume_ketercapaian_head">
                                <!-- <tr>
                                    <th>Nama</th>
                                    <th>Company</th>
                                    <th>Jabatan</th>
                                    <th>W1</th>
                                    <th>W2</th>
                                    <th>W3</th>
                                    <th>W4</th>
                                    <th>W5</th>
                                    
                                </tr> -->
                            </thead>
                            <tbody id="dt_resume_ketercapaian_body"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<!-- Modal Add -->
<div class="modal fade" id="modal_add_briefing" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form_briefing">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-blockquote-left h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                        <p class="text-secondary small">Add Briefing</p>
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
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person"></i></span>
                                        <div class="form-floating">
                                            <div class="ui form">
                                                <div class="field">
                                                    <label>Peserta <i class="text-danger">*</i></label>
                                                    <select name="peserta" id="peserta" class="ui search dropdown" multiple="">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2 d-none" id="div_sales_preview">
                                <div id="sales_preview" class="d-none table-responsive">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journal-album"></i></span>
                                        <div class="form-floating">
                                            <textarea name="review" id="review" cols="30" rows="10" class="form-control border-start-0" placeholder="Review Kemarin"></textarea>
                                            <label>Review Kemarin <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journal-text"></i></span>
                                        <div class="form-floating">
                                            <textarea name="plan" id="plan" cols="30" rows="10" class="form-control border-start-0" placeholder="Plan Hari ini"></textarea>
                                            <label>Plan Hari ini <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <button id="btn_show_memo" type="button" class="btn btn-outline-primary btn-sm mb-2 d-none" onclick="modal_list_memo()">Lihat Memo</button>
                                <button id="btn_show_sop" type="button" class="btn btn-outline-primary btn-sm mb-2 d-none" onclick="modal_list_sop()">Lihat Sop</button>
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journal-bookmark"></i></span>
                                        <div class="form-floating">
                                            <textarea name="informasi" id="informasi" cols="30" rows="10" class="form-control border-start-0" placeholder="Informasi atau SOP"></textarea>
                                            <label>Informasi atau SOP <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journal-check"></i></span>
                                        <div class="form-floating">
                                            <textarea name="motivasi" id="motivasi" cols="30" rows="10" class="form-control border-start-0" placeholder="Motivasi"></textarea>
                                            <label>Motivasi <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-folder-check"></i></span>
                                        <div class="form-floating">
                                            <input type="file" class="form-control border-start-0" id="foto" name="foto" autocomplete="off" accept="image/*" capture="environment">
                                            <label><i class="text-danger">*</i> File extension yang di perbolehkan [gif|jpg|png|jpeg|pdf]</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-exclamation-square"></i></span>
                                        <div class="form-floating">
                                            <textarea name="sanksi" id="sanksi" cols="30" rows="10" class="form-control border-start-0" placeholder="Sanksi"></textarea>
                                            <label>Sanksi</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h6 class="title"><input type="checkbox" name="addition" id="addition"> <label for="addition">Membahas Pekerjaan ?</label></h6>
                        <div class="row div_addition" style="display: none;">
                            <!-- addnew -->
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-1 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-list"></i></span>
                                        <div class="form-floating">
                                            <select name="id_project" id="project" class="form-control">
                                                <option value="#" selected disabled>-- Pilih Divisi --</option>
                                                <?php foreach ($project as $row) : ?>
                                                    <option value="<?= $row->id_project ?>"><?= $row->project ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>Divisi <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-6 mb-2">
                                <div class="form-group mb-1 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-list"></i></span>
                                        <div class="form-floating">
                                            <select name="id_pekerjaan" id="pekerjaan" class="form-control">
                                                <option value="#" selected disabled>-- Pilih SO --</option>

                                            </select>
                                            <label>SO <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-6 mb-2">
                                <div class="form-group mb-1 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-list"></i></span>
                                        <div class="form-floating">
                                            <select name="id_sub_pekerjaan" id="sub_pekerjaan" class="form-control">
                                                <option value="#" selected disabled>-- Pilih SI --</option>
                                            </select>
                                            <label>SI <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-1 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-list"></i></span>
                                        <div class="form-floating">
                                            <select name="id_detail_pekerjaan[]" id="detail_pekerjaan" class="form-control ui search dropdown" multiple>

                                            </select>
                                            <label>Tasklist <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-md btn-outline-theme" id="btn_save" onclick="save_briefing()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->

<!-- Modal Add Feedback BM -->
<div class="modal fade" id="modal_feedback_bm" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="form_briefing">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-blockquote-left h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                        <p class="text-secondary small">Feedback BM</p>
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
                            <input type="hidden" name="id_briefing_bm" id="id_briefing_bm">
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journal-album"></i></span>
                                        <div class="form-floating">
                                            <textarea name="review_bm" id="review_bm" cols="30" rows="10" class="form-control border-start-0" placeholder="Review BM"></textarea>
                                            <label>Review BM <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journal-text"></i></span>
                                        <div class="form-floating">
                                            <textarea name="keputusan_bm" id="keputusan_bm" cols="30" rows="10" class="form-control border-start-0" placeholder="Keputusan BM"></textarea>
                                            <label>Keputusan BM <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-md btn-outline-theme" id="btn_simpan_feedback_bm" onclick="simpan_feedback_bm()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add Feedback BM -->

<!-- Modal List Proses -->
<div class="modal fade" id="modal_list_proses" tabindex="-1" aria-labelledby="modalListProsesLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-list h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalListProsesLabel">List Proses</h6>
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
<!-- Modal List Proses -->

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


<!-- Modal List Memo -->
<div class="modal fade" id="modal_list_memo" tabindex="-1" aria-labelledby="modal_list_memo_label" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-list h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal_list_memo_label">List Memo</h6>
                    <p class="text-secondary small"></p>
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
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_list_memo" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID Memo</th>
                                    <th>Status</th>
                                    <th>Jenis</th>
                                    <th>Note</th>
                                    <th>BA</th>
                                    <th>Divisi</th>
                                    <th class="text-nowrap">Jabatan</th>
                                    <th class="text-nowrap">Tanggal</th>
                                    <th class="text-nowrap">Created By</th>
                                    <th class="text-nowrap">Updated By</th>
                                    <th>Note Update</th>
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
<!-- Modal List Memo -->

<!-- Modal List Sop -->
<div class="modal fade" id="modal_list_sop" tabindex="-1" aria-labelledby="modal_list_sop_label" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-list h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal_list_sop_label">List Memo</h6>
                    <p class="text-secondary small"></p>
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
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_list_sop" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-small text-uppercase">Jenis Dokumen</th>
                                    <th scope="col" class="text-small text-uppercase">Nama Document</th>
                                    <th scope="col" class="text-small text-uppercase">Department</th>
                                    <th scope="col" class="text-small text-uppercase">Designation</th>
                                    <th scope="col" class="text-small text-uppercase">No Document</th>
                                    <th scope="col" class="text-small text-uppercase">Tgl Upload</th>
                                    <th scope="col" class="empty">&nbsp;</th>
                                </tr>
                            </thead>
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

<div class="modal fade" id="modal_pdf" role="dialog">
    <div class="modal-dialog modal-lg center" role="document">
        <div class="modal-content">
            <div class="card-block">
                <div style="width: 100%; height: 100%; position: relative;" id="embed">
                </div>
            </div>
            <div class="modal-footer" style="padding:10px">
                <button class="btn btn-outline-danger" data-bs-dismiss="modal" id="cls">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal List Sop -->