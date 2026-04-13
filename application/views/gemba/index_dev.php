<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Tempat sebenarnya.</p>
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
                            <i class="bi bi-geo h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Genba</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                            <button type="button" class="btn btn-md btn-outline-theme" data-bs-toggle="modal" data-bs-target="#modal_add_plan">Add Plan</button>
                            <button type="button" class="btn btn-md btn-outline-info" onclick="list_proses()">Proses Genba</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="" style="padding: 10px;">
                        <table id="dt_list_gemba" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
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
                                    <!-- <th>Updated At</th>
                                    <th>Updated By</th> -->
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
                            <i class="bi bi-geo h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">Lock Genba 2 Perminggu Dev</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="" style="padding: 10px;">
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

                        <!-- addnew -->
                        

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
                                <div class="form-group mb-1 position-relative check-valid">
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
                                <small class="text-secondary" style="font-size: 9pt !important;">*Jika tidak muncul Tipe Genba, maka belum ada Tipe Genba untuk Department anda.</small>
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
                        <h6 class="title"><input type="checkbox" name="addition" id="addition"> <label for="addition">Membahas Pekerjaan ?</label></h6>
                        <div class="row div_addition" style="display: none;">
                            <!-- addnew -->
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-1 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-list"></i></span>
                                        <div class="form-floating">
                                            <select name="id_project" id="project" class="form-control">
                                                <option value="#" selected disabled>-- Project --</option>
                                                <?php foreach ($project as $row) : ?>
                                                    <option value="<?= $row->id_project ?>"><?= $row->project ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>Project <i class="text-danger">*</i></label>
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
                                                <option value="#" selected disabled>-- Pekerjaan --</option>
                                                <!-- <?php foreach ($pekerjaan as $row) : ?>
                                                    <option value="<?= $row->id ?>"><?= $row->pekerjaan ?></option>
                                                <?php endforeach; ?> -->
                                            </select>
                                            <label>Pekerjaan <i class="text-danger">*</i></label>
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
                                                <option value="#" selected disabled>-- Sub Pekerjaan --</option>
                                            </select>
                                            <label>Sub Pekerjaan <i class="text-danger">*</i></label>
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
                                                <option value=" #" selected disabled>-- Detail Pekerjaan --</option>
                                            </select>
                                            <label>Detail Pekerjaan <i class="text-danger">*</i></label>
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