<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Integritas | Objektifitas | Independensi</p>
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
                            <h6 class="fw-medium mb-0">List Audit Findings</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                            <button type="button" class="btn btn-md btn-outline-theme" onclick="add_findings()">Add Audit Findings</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="" style="padding: 10px;">
                        <table id="dt_list_findings" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id Findings</th>
                                    <th>Id Plan</th>
                                    <th>Kategori</th>
                                    <th>User</th>
                                    <th>Company</th>
                                    <th>Department</th>
                                    <th>Proses Kerja</th>
                                    <th>Sub Proses Kerja</th>
                                    <th>Temuan</th>
                                    <th>Level Temuan</th>
                                    <th>Root Cause</th>
                                    <th>Waktu Kejadian</th>
                                    <th>Aturan SOP</th>
                                    <th>Status</th>
                                    <th>Alat Bukti</th>
                                    <th>Lampiran</th>
                                    <th>Auditor</th>
                                    <th>Waktu Input</th>
                                    <th>Feedback</th>
                                    <th>Lampiran Feedback</th>
                                    <th>Status Corrective</th>
                                    <th>Deadline Corrective</th>
                                    <th>Corrective</th>
                                    <th>Lampiran Corrective</th>
                                    <th>Status Preventive</th>
                                    <th>Deadline Preventive</th>
                                    <th>Preventive</th>
                                    <th>Lampiran Preventive</th>
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
<div class="modal fade" id="modal_add_findings" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form_findings">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-blockquote-left h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                        <p class="text-secondary small">Add Audit Findings</p>
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
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-bounding-box"></i></span>
                                        <div class="form-floating">
                                            <select name="plan" id="plan" class="form-control" onchange="get_periode()">
                                                <option value="#" selected disabled>-Choose Plan-</option>
                                                <option value="Special Case">Special Case</option>
                                                <?php foreach ($plan as $p) { ?>
                                                    <option value="<?= $p->id_plan; ?>"><?= $p->id_plan; ?> | <?= strip_tags($p->object) ?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Plan
                                                <i class="text-danger">*</i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-columns"></i></span>
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0" name="periode" id="periode" placeholder="Periode" readonly>
                                            <label>Periode
                                                <!-- <i class="text-danger">*</i> -->
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-building-check"></i></span>
                                        <div class="form-floating">
                                            <select name="department" id="department" class="form-control" onchange="change_department()">
                                                <option value="#" selected disabled>-Choose Department-</option>
                                                <?php foreach ($department as $dep) { ?>
                                                    <option value="<?= $dep->department_id; ?>|<?= $dep->company_id; ?>"><?= $dep->show_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Department <i class="text-danger">*</i></label>
                                            <input type="hidden" id="department_id" name="department_id">
                                            <input type="hidden" id="company_id" name="company_id">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-bounding-box"></i></span>
                                        <div class="form-floating">
                                            <select name="karyawan" id="karyawan" class="form-control"></select>
                                            <label>User <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-columns"></i></span>
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0" name="proses_kerja" id="proses_kerja" placeholder="Proses Kerja">
                                            <label>Proses Kerja <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-columns-gap"></i></span>
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0" name="sub_proses_kerja" id="sub_proses_kerja" placeholder="Proses Sub Kerja">
                                            <label>Sub Proses Kerja <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journal-check"></i></span>
                                        <div class="form-floating">
                                            <textarea name="temuan" id="temuan" cols="30" rows="5" class="form-control border-start-0" placeholder="Temuan"></textarea>
                                            <label>Temuan <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-activity"></i></span>
                                        <div class="form-floating">
                                            <textarea name="root_cause" id="root_cause" cols="30" rows="5" class="form-control border-start-0" placeholder="Root Cause"></textarea>
                                            <label>Root Cause <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2 change_kategori">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-view-stacked"></i></span>
                                        <div class="form-floating">
                                            <select name="kategori_temuan" id="kategori_temuan" class="form-control" onchange="change_kategori()">
                                                <option value="#" selected disabled>-Choose-</option>
                                                <option value="Temuan Audit">Temuan Audit</option>
                                                <option value="Konfirmasi Audit">Konfirmasi Audit</option>
                                            </select>
                                            <label>Kategori <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2 hidden_level_temuan">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-view-list"></i></span>
                                        <div class="form-floating">
                                            <select name="level_temuan" id="level_temuan" class="form-control">
                                                <option value="#" selected disabled>-Choose-</option>
                                                <option value="Minor">Minor</option>
                                                <option value="Mayor">Mayor</option>
                                            </select>
                                            <label>Level Temuan <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-event"></i></span>
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0 bg-white" name="tanggal_kejadian" id="tanggal_kejadian" placeholder="Tanggal Kejadian">
                                            <label>Tanggal Kejadian<i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-list-stars"></i></span>
                                        <div class="form-floating">
                                            <select name="aturan" id="aturan" class="form-control">
                                                <option value="#">-Choose Aturan-</option>
                                            </select>
                                            <label>Aturan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-columns-gap"></i></span>
                                                <div class="form-floating">
                                                    <input type="text" class="form-control border-start-0 alat_bukti" name="alat_bukti[]" placeholder="Alat Bukti">
                                                    <label>Alat Bukti <i class="text-danger">*</i></label>
                                                </div>
                                                <input type="hidden" id="jml_alat_bukti" value="1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tempat_alat_bukti"></div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group">
                                            <span class="btn btn-sm btn-danger" onclick="hapus_alat_bukti()"><i class="bi bi-node-minus text-white"></i></span>
                                            <span class="btn btn-sm btn-success" onclick="tambah_alat_bukti()"><i class="bi bi-node-plus text-white"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-folder"></i></span>
                                                <div class="form-floating">
                                                    <input type="file" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" id="lampiran_1" class="form-control lampiran" onchange="input_lampiran('#lampiran_1')">
                                                </div>
                                                <input type="hidden" name="lampiran[]" id="input_lampiran_1" value="">
                                                <input type="hidden" id="jml_lampiran" value="1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <a data-fancybox="gallery" id="a_preview_lampiran_1" class="gallery a_lampiran">
                                            <i class="fa fa-spinner fa-spin fa-2x mt-2" id="loading_lampiran_1" hidden></i>
                                            <img class="preview" src="" alt=" " id="preview_lampiran_1" width="50" height="50" hidden>
                                        </a>
                                    </div>
                                </div>
                                <div id="tempat_lampiran">
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group">
                                            <span class="btn btn-sm btn-danger" onclick="hapus_lampiran()"><i class="bi bi-file-minus text-white"></i></span>
                                            <span class="btn btn-sm btn-success" onclick="tambah_lampiran()"><i class="bi bi-file-plus text-white"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-md btn-outline-theme" id="btn_save" onclick="save_findings()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->

<!-- Modal Keterangan Audit -->
<div class="modal fade" id="modal_keterangan_audit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalKeteranganAudit">Feedback Audit</h6>
                    <p class="text-secondary small">Keterangan Auditor</p>
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
                    <h6 class="title">Detail Feedback User</h6>
                    <div class="row align-items-center mb-3">
                        <div class="col-12 col-md-3 col-lg-3 col-xl-3 col-xxl-3 mb-3">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-person h5 avatar avatar-40 bg-purple text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="employee_name">...</h6>
                                    <span class="badge bg-light-purple text-dark" id="company" class="small">...</span>
                                    <span class="badge bg-light-yellow text-dark" id="department_name" class="small">...</span>
                                    <span class="badge bg-light-red text-dark" id="designation" class="small">...</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3 col-xl-3 col-xxl-3 mb-3">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-distribute-vertical h5 avatar avatar-40 text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <p class="text-secondary small mb-0">Status</p>
                                    <span class="style_status_feedback" id="status_feedback">...</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3 col-xl-3 col-xxl-3 mb-3">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-back h5 avatar avatar-40 bg-info text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <p class="text-secondary small mb-0">Feedback</p>
                                    <p class="small" id="feedback">...</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3 col-xl-3 col-xxl-3 mb-3">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-file-earmark-text h5 avatar avatar-40 bg-pink text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <p class="text-secondary small mb-0">Attachment</p>
                                    <p class="small" id="attachment_feedback">...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-xl-6 col-xxl-6">
                            <h6 class="title">Detail Corrective</h6>
                            <div class="row align-items-center mb-3">
                                <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-3">
                                    <div class="row">
                                        <div class="col-auto">
                                            <i class="bi bi-check-square h5 avatar avatar-40 bg-success text-white rounded"></i>
                                        </div>
                                        <div class="col">
                                            <p class="text-secondary small mb-0">Status</p>
                                            <span class="badge bg-light-red text-dark small" id="status_corrective">...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-3">
                                    <div class="row">
                                        <div class="col-auto">
                                            <i class="bi bi-calendar-check h5 avatar avatar-40 bg-danger text-white rounded"></i>
                                        </div>
                                        <div class="col">
                                            <p class="text-secondary small mb-0">Deadline</p>
                                            <span class="badge bg-light-red text-dark small" id="deadline_corrective">...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-3">
                                    <div class="row">
                                        <div class="col-auto">
                                            <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-info text-white rounded"></i>
                                        </div>
                                        <div class="col">
                                            <p class="text-secondary small mb-0">Action</p>
                                            <p class="small" id="action_corrective">...</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-3">
                                    <div class="row">
                                        <div class="col-auto">
                                            <i class="bi bi-file-break h5 avatar avatar-40 bg-pink text-white rounded"></i>
                                        </div>
                                        <div class="col">
                                            <p class="text-secondary small mb-0">Attachment</p>
                                            <p class="small" id="attachment_corrective">...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-6 col-xxl-6">
                            <h6 class="title">Detail Preventive</h6>
                            <div class="row align-items-center mb-3">
                                <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-3">
                                    <div class="row">
                                        <div class="col-auto">
                                            <i class="bi bi-check2-square h5 avatar avatar-40 bg-success text-white rounded"></i>
                                        </div>
                                        <div class="col">
                                            <p class="text-secondary small mb-0">Status</p>
                                            <span class="badge bg-light-red text-dark small" id="status_preventive">...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-3">
                                    <div class="row">
                                        <div class="col-auto">
                                            <i class="bi bi-calendar-week h5 avatar avatar-40 bg-danger text-white rounded"></i>
                                        </div>
                                        <div class="col">
                                            <p class="text-secondary small mb-0">Deadline</p>
                                            <span class="badge bg-light-red text-dark small" id="deadline_preventive">...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-3">
                                    <div class="row">
                                        <div class="col-auto">
                                            <i class="bi bi-clipboard-pulse h5 avatar avatar-40 bg-info text-white rounded"></i>
                                        </div>
                                        <div class="col">
                                            <p class="text-secondary small mb-0">Action</p>
                                            <p class="small" id="action_preventive">...</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-3">
                                    <div class="row">
                                        <div class="col-auto">
                                            <i class="bi bi-file-earmark-zip h5 avatar avatar-40 bg-pink text-white rounded"></i>
                                        </div>
                                        <div class="col">
                                            <p class="text-secondary small mb-0">Attachment</p>
                                            <p class="small" id="attachment_preventive">...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6 class="title">Keterangan Audit <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                    <div class="row">
                        <input type="hidden" id="id_temuan" name="id_temuan">
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journal-text"></i></span>
                                    <div class="form-floating">
                                        <textarea name="keterangan_audit" id="keterangan_audit" cols="30" rows="10" class="form-control border-start-0" placeholder="Evaluasi"></textarea>
                                        <label>Keterangan <i class="text-danger">*</i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-check-square"></i></span>
                                    <div class="form-floating">
                                        <select name="status_audit" id="status_audit" class="form-control">
                                            <option value="#" selected disabled>-- Choose Status --</option>
                                            <?php foreach ($status_audit as $key) : ?>
                                                <option value="<?= $key->id; ?>"><?= $key->status; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label>Status <i class="text-danger">*</i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px !important;" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-md btn-outline-theme" id="btn_save_keterangan_audit" onclick="save_keterangan_audit()">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Keterangan Audit -->