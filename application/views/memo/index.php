<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-8 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Deskripsi Page</p>
            </div>
            <div class="col col-sm-auto">
                <div class="input-group input-group-md reportrange">
                    <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                    <input type="hidden" name="start" value="" id="start" />
                    <input type="hidden" name="end" value="" id="end" />
                    <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
                </div>
            </div>
            <div class="col-auto ps-0">

            </div>
        </div>
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle; ?></li>
                        </ol>
                    </div>

                </div>

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
                            <h6 class="fw-medium">List Memo</h6>
                        </div>
                        <div class="col-auto-right" align="right">
                        <?php if ($user_id == 1 || $user_id == 2516 || $user_id == 2729 || $user_id == 803) { ?>
                            <!-- wbdev -->
                            <button type="button" class="btn btn-md btn-outline-info mb-2" onclick="list_memo_feedback()"><i class="bi bi-chat-left-dots"></i> List Feedback Memo</button>

                            <button type="button" class="btn btn-md btn-outline-warning mb-2" onclick="list_memo_waiting()"><i class="bi bi-clock"></i> List Memo Waiting</button>

                            <button type="button" class="btn btn-md btn-outline-danger mb-2" onclick="list_memo_reject()"><i class="bi bi-x-circle"></i> List Memo Reject</button>

                            <button type="button" class="btn btn-md btn-outline-theme mb-2" onclick="add_memo()"><i class="bi bi-journal-plus"></i> Add Memo</button>
                        <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                <?php if ($user_id == 1 || $user_id == 2516 || $user_id == 2729 || $user_id == 803) { ?>
                            <input type="hidden" readonly id="user_id" name="user_id" value="<?= $user_id ?>">
                <?php } ?>
                <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_memo" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID Memo</th>
                                    <th>Status</th>
                                    <th>Jenis</th>
                                    <th>Note</th>
                                    <th>BA</th>
                                    <th>Company</th>
                                    <th>Department</th>
                                    <th>Role/Jabatan</th>
                                    <th>Tanggal</th>
                                    <th>Created By</th>
                                    <th>Updated By</th>
                                    <th>Note Update</th>
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
<div class="modal fade" id="modal_add_memo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form_memo" enctype="multipart/form-data">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-blockquote-left h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                        <p class="text-secondary small">Add Memo</p>
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
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-bounding-box"></i></span>
                                        <div class="form-floating">
                                            <select id="tipe_memo" name="tipe_memo" class="form-control" required>
                                                <option value="#" selected disabled>--Choose Type --</option>
                                                <option value="BA">BA</option>
                                                <option value="Memo">Memo</option>
                                                <option value="SK">SK</option>
                                            </select>
                                            <label>Type
                                                <i class="text-danger">*</i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <label>Note <i class="text-danger">*</i></label>
                                    <div class="input-group">
                                        <textarea class="form-control input_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" name="note" id="note" rows="5" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-bounding-box"></i></span>
                                        <div class="form-floating">
                                            <select id="company_id" name="company_id" class="form-control" multiple onchange="get_department(this.value)" required>
                                                <option value="#" selected disabled>--Choose Company--</option>
                                                <?php foreach ($companies as $company) { ?>
                                                    <option value="<?= $company->company_id; ?>"><?= $company->name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Company
                                                <i class="text-danger">*</i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-bounding-box"></i></span>
                                        <div class="form-floating">
                                            <select id="department_id" name="department_id" class="form-control" multiple required>
                                                
                                            </select>
                                            <label>Department
                                                <i class="text-danger">*</i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-bounding-box"></i></span>
                                        <div class="form-floating">
                                            <select id="role_id" name="role_id" class="form-control" multiple required>
                                                <option value="#" selected disabled>--Choose Role--</option>
                                                <?php foreach ($roles as $role) { ?>
                                                    <option value="<?= $role->role_id; ?>"><?= $role->role_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Role/Jabatan
                                                <i class="text-danger">*</i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-folder"></i><i class="text-danger small">*</i></span>
                                                <div class="form-floating">
                                                    <input type="file" accept="application/pdf, .pdf, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" id="file_memo" class="form-control lampiran" name="file_memo">
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
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-md btn-outline-theme" id="btn_save" onclick="simpan_memo()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->

<!-- Waiting MEMO -->
<div class="modal fade" id="modal_waiting_memo" role="dialog">
    <div class="modal-dialog center" style="max-width: 90%;position:absolute;top:0;bottom:0;left:0;right:0;margin:auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Waiting Memo</h4>
                <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
                <div class="table-responsive">
                    <table id="waiting_memo" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID Memo</th>
                                <th>Status</th>
                                <th>Jenis</th>
                                <th>Note</th>
                                <th>BA</th>
                                <th>Company</th>
                                <th>Department</th>
                                <th>Role/Jabatan</th>
                                <th>Tanggal</th>
                                <th>Created By</th>
                                <th>Updated By</th>
                                <th>Note Update</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Waiting MEMO -->

<!-- Reject MEMO -->
<div class="modal fade" id="modal_reject_memo" role="dialog">
    <div class="modal-dialog center" style="max-width: 90%;position:absolute;top:0;bottom:0;left:0;right:0;margin:auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reject Memo</h4>
                <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
                <div class="table-responsive">
                    <table id="reject_memo" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID Memo</th>
                                <th>Status</th>
                                <th>Jenis</th>
                                <th>Note</th>
                                <th>BA</th>
                                <th>Company</th>
                                <th>Department</th>
                                <th>Role/Jabatan</th>
                                <th>Tanggal</th>
                                <th>Created By</th>
                                <th>Updated By</th>
                                <th>Note Update</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Reject MEMO -->

<!-- List Feedback MEMO -->
<div class="modal fade" id="modal_feedback_memo" role="dialog">
    <div class="modal-dialog center" style="max-width: 90%;position:absolute;top:0;bottom:0;left:0;right:0;margin:auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Feedback Memo</h4>
                <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
                <div class="table-responsive">
                    <table id="feedback_memo" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID Memo</th>
                                <th>Status</th>
                                <th>Jenis</th>
                                <th>Note</th>
                                <th>BA</th>
                                <th>Company</th>
                                <th>Department</th>
                                <th>Role/Jabatan</th>
                                <th>Tanggal</th>
                                <th>Created By</th>
                                <th>Updated By</th>
                                <th>Note Update</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End List Feedback MEMO -->

<!-- Edit MEMO -->
<div class="modal fade" id="modal_edit_memo" role="dialog">
    <div class="modal-dialog center">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Memo</h4>
                <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
                <div class="row mt-2">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="row d-flex align-items-center">
                                <div class="col-lg-2 col-md-2 col-sm-12">
                                    <label>ID Memo</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-12">
                                    <input type="text" class="form-control" readonly id="edit_id_memo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="row d-flex align-items-center">
                                <div class="col-lg-2 col-md-2 col-sm-12">
                                    <label>Company</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-12">
                                    <input type="text" class="form-control" readonly id="edit_company">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="row d-flex align-items-center">
                                <div class="col-lg-2 col-md-2 col-sm-12">
                                    <label>Department</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-12">
                                    <input type="text" class="form-control" readonly id="edit_department">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="row d-flex align-items-center">
                                <div class="col-lg-2 col-md-2 col-sm-12">
                                    <label>Role</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-12">
                                    <input type="text" class="form-control" readonly id="edit_role">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="row d-flex align-items-center">
                                <div class="col-lg-2 col-md-2 col-sm-12">
                                    <label>Note Memo</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-12">
                                    <textarea name="edit_note" id="edit_note" rows="5" style="width: 100%;" class="form-control" readonly></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="row d-flex align-items-center">
                                <div class="col-lg-2 col-md-2 col-sm-12">
                                    <label>Status<small class="text-danger">*</small></label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-12">
                                    <select id="status_memo" class="form-control">
                                        <option value="#">-- Pilih Status --</option>
                                        <option value="1">Approve</option>
                                        <option value="2">Reject</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="row d-flex align-items-center">
                                <div class="col-lg-2 col-md-2 col-sm-12">
                                    <label>Note Update<small class="text-danger">*</small></label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-12">
                                    <textarea name="note_update" id="note_update" rows="5" style="width: 100%;" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-success" id="btn_edit_memo" onclick="edit_memo()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- End Edit MEMO -->

<!-- Add Feedback MEMO -->
<div class="modal fade" id="modal_add_feedback_memo" role="dialog">
    <div class="modal-dialog center" style="max-width: 90%;position:absolute;top: 60px;bottom:0;left:0;right:0;margin:auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Feedback Memo</h4>
                <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
                <div class="row">
                    <div class="col-md-12">
                        <form id="form_feedback" enctype="multipart/form-data">
                            <input type="hidden" id="id_memo_feedback" value="">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <label>Feedback <i class="text-danger">*</i></label>
                                        <div class="input-group">
                                            <textarea class="form-control input_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" name="feedback" id="feedback" rows="5" required></textarea>
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
                                                        <input type="file" accept="application/pdf, .pdf, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, image/jpg, image/png, image/jpeg" id="file_feedback" class="form-control lampiran" name="file_feedback">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <label>Link </label>
                                        <div class="input-group">
                                            <input type="text" name="link_feedback" id="link_feedback" class="form-control" placeholder="https://example.com">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <label>Status<i class="text-danger">*</i></label>
                                        <div class="input-group">
                                            <select class="form-control" name="status_feedback" id="status_feedback" required>
                                                <option value="#" selected="" disabled="">-- Pilih Status --</option>
                                                <option>Jalan Berhasil</option>
                                                <option>Jalan Tidak Berhasil</option>
                                                <option>Tidak Berjalan</option>
                                                <option>Progress</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="button" class="btn btn-md btn-outline-theme" id="btn_save_feedback" onclick="simpan_feedback()">Save</button>
                            </div>
                        </form>
                        <br><br>
                    </div>
                    <div class="col-md-12">
                        <h5>History</h5><hr>
                            <table class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Feedback</th>
                                        <th>File</th>
                                        <th>Link</th>
                                        <th>Status</th>
                                        <th>Feedback By</th>
                                    </tr>
                                </thead>
                                <tbody id="history_feedback">

                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Add Feedback MEMO -->

<!-- Add Feedback MEMO -->
<div class="modal fade" id="modal_history_feedback_memo" role="dialog">
    <div class="modal-dialog center" style="max-width: 90%;position:absolute;top: 60px;bottom:0;left:0;right:0;margin:auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">History Feedback Memo</h4>
                <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
                    <table class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Feedback</th>
                                <th>File</th>
                                <th>Link</th>
                                <th>Status</th>
                                <th>Feedback By</th>
                            </tr>
                        </thead>
                        <tbody id="history_feedback_memo">

                        </tbody>
                    </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Add Feedback MEMO -->

<!-- Edit File MEMO -->
<div class="modal fade" id="modal_change_file_memo" role="dialog">
    <div class="modal-dialog center">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit File Memo</h4>
                <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
                <form id="form_change_file_memo" enctype="multipart/form-data">
                    <input type="hidden" id="id_memo_file" value="">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-folder"></i></span>
                                            <div class="form-floating">
                                                <input type="file" accept="application/pdf, .pdf, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" id="change_file_memo" class="form-control lampiran" name="change_file_memo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-md btn-outline-theme" id="btn_save_file" onclick="edit_file_memo()">Edit</button>
            </div>
        </div>
    </div>
</div>
<!-- End Edit File MEMO -->