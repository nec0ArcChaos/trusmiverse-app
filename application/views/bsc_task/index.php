<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
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
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <label for="">Periode</label>
                        </div>
                        <div class="col-12 col-md-6 col-lg-2">
                            <div class="input-group input-group-md border rounded reportrange">
                                <span class="input-group-text text-secondary bg-none"><i class="bi bi-calendar-event"></i></span>
                                <input type="text" class="form-control" name="periode" id="periode" value="<?php echo date('Y-m') ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-8"></div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <button class="btn btn-theme" id="btn_tasklist" style="width: 100%;">Update Tasklist</button>
                        </div>
                    </div>
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="tbl_all_task" class="table table-sm table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>Unit Bisnis</th>
                                    <th>Perspektive</th>
                                    <th>Sub Perspektive</th>
                                    <th>Strategi Objective</th>
                                    <th>Strategi Inisiatif</th>
                                    <th>Tasklist</th>
                                    <th>Target</th>
                                    <th>Actual</th>
                                    <th>Deviasi</th>
                                    <th>Persentase</th>
                                    <th>Lampiran</th>
                                    <th>Resume</th>
                                    <th>Updated By</th>
                                    <th>Updated At</th>
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

<div class="modal fade" id="modal_tasklist" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header d-block bg-light-theme">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Daftar Tasklist</h6>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-2 col-md-12 mb-3">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="input-group input-group-md">
                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-check"></i></span>
                                <div class="form-floating">
                                    <input type="text" class="form-control border-start-0" name="periode" id="periode_2" value="<?php echo date('Y-m') ?>"/>
                                    <label for="periode_2">Periode</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-12 mb-3">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="input-group input-group-md">
                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-filter-square"></i></span>
                                <div class="form-floating">
                                    <select class="form-select border-0" id="frekuensi" required="">
                                        <option value="All">All</option>
                                        <option value="Monthly">Monthly</option>
                                        <option value="Weekly">Weekly</option>
                                        <option value="Daily">Daily</option>
                                    </select>
                                    <label for="frekuensi">Frekuensi</label>
                                </div>
                            </div>
                        </div>
                        <div class="invalid-feedback mb-3">Add valid data </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tbl_task" class="table table-sm table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Periode</th>
                                <th>Unit BIsnis</th>
                                <th>Strategi Objective</th>
                                <th>Strategi Inisiatif</th>
                                <th>Tasklist</th>
                                <th>Jabatan</th>
                                <th>Frekuensi</th>
                                <th>Target</th>
                                <th>Actual</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Input Ketercapaian -->
<div class="modal fade" id="modal_input_tasklist" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header d-block bg-light-purple">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-purple rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Input Actual</h6>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="" class="small">Ketercapaian :</label>
                            <input type="hidden" name="task_id_task" id="task_id_task" class="form-control" readonly>
                            <input type="hidden" name="task_periode" id="task_periode" class="form-control" readonly>
                            <input type="hidden" name="task_target" id="task_target" class="form-control" readonly>
                            <p id="ketercapaian_text"></p>
                        </div>
                        <div class="mb-3">
                            <label for="" class="small">Status</label>
                            <div class="col-12 mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="task_status" id="task_status_inline_radio_1" value="Berhasil" checked>
                                    <label class="form-check-label" for="status_inline_radio_1">Berhasil</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="task_status" id="task_status_inline_radio_2" value="Tdk Berhasil">
                                    <label class="form-check-label" for="status_inline_radio_2">Tidak Berhasil</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="small">Resume</label>
                            <textarea class="form-control border" type="text" name="task_resume" id="task_resume" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="mb-3">
                            <label for="" class="small">Target</label>
                            <input class="form-control border" type="number" readonly id="task_target_val">
                        </div>
                        <div class="mb-3">
                            <label for="" class="small">Actual</label>
                            <input class="form-control border" type="number" name="task_actual" id="task_actual">
                        </div>
                        <div class="mb-2">
                            <label for="" class="small">File</label>
                            <input class="form-control border" type="file" name="task_file" id="task_file">
                        </div>
                        <div class="mb-2">
                            <label for="" class="small">Link</label>
                            <input class="form-control border" type="text" name="task_link" id="task_link">
                        </div>
                        <div class="mb-2 text-end">
                            <button class="btn btn-primary" onclick="save_actual_task()">Simpan</button>

                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="tbl_task_item_history" width="100%">
                        <thead>
                            <tr>
                                <th>Periode</th>
                                <th>Created By</th>
                                <th>Status</th>
                                <th>Actual</th>
                                <th>Resume</th>
                                <th>File</th>
                                <th>Link</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" data-bs-dismiss="modal">Back</button>
            </div>
        </div>
    </div>
</div>