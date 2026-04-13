<main class="main mainheight">
    <div class="container-fluid mb-4">
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
                        <div class="col-12">
                            <div class="float-start">
                                <div class="row">
                                    <div class="col-auto">
                                        <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-theme rounded"></i>
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <h6 class="fw-medium mb-0">Overtime Request</h6>
                                    </div>
                                </div>

                            </div>

                            <?php

                            $user_id = $_SESSION['user_id'];
                            $super_user = [1, 979, 778];

                            $staff_helper_list = [7, 8]; // 7 : Staff, 8 : Helper
                            $staff_helper_list2 = ['Staff','Helper']; // 7 : Staff, 8 : Helper

                            $user_role_id = $_SESSION['user_role_id'];
                            $posisi = $_SESSION['posisi'];

                            // if (in_array($user_role_id, $staff_helper_list)) 
                            if (in_array($posisi, $staff_helper_list2) || in_array($user_id, $super_user)) 
                            { ?>

                                <div class="col-sm-12 col-md-12 col-lg-3 float-lg-end">
                                    <button type="button" class="btn btn-md btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#modal_add_request" onclick="add_request()" style="width:100%">
                                        <i class="bi bi-plus"></i> Add New
                                    </button>
                                </div>

                            <?php } else if (in_array($user_id, $list_head) || in_array($user_id, $super_user) || $level_sto >= 4) { ?>

                                <div class="col-sm-12 col-md-12 col-lg-3 float-lg-end">
                                    <button type="button" class="btn btn-md btn-outline-theme mt-2" data-bs-toggle="modal" data-bs-target="#modal_list_request" onclick="dt_overtime_request_list(1)" style="width:100%">
                                        <i class="bi bi-list"></i> List Request
                                    </button>
                                </div>

                            <?php } ?>

                            <?= $_SESSION['jabatan'] ?>


                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col col-sm-auto">
                            <form method="POST" id="form_filter">
                                <div class="input-group input-group-md reportrange">
                                    <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                                    <input type="hidden" name="start" value="" id="start" />
                                    <input type="hidden" name="end" value="" id="end" />
                                    <a href="javascript:void(0)" class="input-group-text text-secondary bg-none" id="titlecalandershow" onclick="filter_date()"><i class="bi bi-search"></i></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_overtime_request" class="table table-sm table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width:7%">Action</th>
                                    <th>Employee</th>
                                    <th>Company</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Date</th>
                                    <th>In Time</th>
                                    <th>Out Time</th>
                                    <th>Total Hours</th>
                                    <th>Status</th>
                                    <th>Reason</th>
                                    <!-- devnew -->
                                    <th>File</th>
                                    <th>Created at</th>
                                    <th>Approve GM</th>
                                    <th>Approve at</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<!-- Modal Add -->
<div class="modal fade" id="modal_add_request" aria-labelledby="modal_add_request_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_add_request" enctype="multipart/form-data">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_add_request_label">Form</h6>
                        <p class="text-secondary small">Overtime Request For </p>
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
                        <h6 class="title">Detail Request</h6>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-event-fill"></i></span>
                                        <div class="form-floating">
                                            <input type="text" placeholder="Date" name="request_date" id="request_date" value="<?= date('Y-m-d') ?>" required class="form-control border-start-0">
                                            <label>Date</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg clockpicker">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-hourglass-top"></i></span>
                                        <div class="form-floating">
                                            <input type="text" name="in_time" id="in_time" class="form-control border-start-0" required placeholder="--:--">
                                            <label>In Time</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg clockpicker">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-hourglass-bottom"></i></span>
                                        <div class="form-floating">
                                            <input type="text" name="out_time" id="out_time" class="form-control border-start-0" required placeholder="--:--">
                                            <label>Out Time</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <textarea name="reason" id="reason" class="form-control border-start-0" cols="30" rows="5" style="min-height: 80px;" required></textarea>
                                            <label>Reason</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                        </div>
                        <!-- devnew -->
                        <div class="row">
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-2 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <input type="file" placeholder="Doc File" name="dokumen" id="dokumen" class="form-control border-start-0 is-invalidx">
                                            <label>Document</label>
                                            <div class="invalid-feedback mb-3">Jenis File yang diizinkan hanya Gambar(JPG/JPEG/PNG), PDF dan Dokumen(DOC/DOCX)</div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <span style="font-size: small; font-style: italic;">- Ukuran <b>Maksimal</b> File <b>5 MB</b> </span><br>
                                    <span style="font-size: small; font-style: italic;">- Jenis File yang diizinkan hanya <b>Gambar(JPG/JPEG/PNG), PDF dan Dokumen(DOC/DOCX)</b></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-md btn-primary" id="btn_save" onclick="save()">Save Request <i class="bi bi-floppy"></i></button>
                    <button type="button" style="display:none" class="btn btn-md btn-success" id="btn_update" onclick="update_request()">Update Request <i class="bi bi-floppy"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->




<!-- Modal Add Confirm-->
<div class="modal fade" id="modalAddConfirm" tabindex="-1" aria-labelledby="modalAddConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddConfirmLabel">Form</h6>
                    <p class="text-secondary small">Overtime Request </p>
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
                    <h6 class="title">Are you sure ?</h6>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md btn-outline-theme" id="btn_save_confirm" onclick="save_request()">Yes, Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add Confirm -->


<!-- Modal Update Confirm-->
<div class="modal fade" id="modalUpdateConfirm" tabindex="-1" aria-labelledby="modalUpdateConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalUpdateConfirmLabel">Form</h6>
                    <p class="text-secondary small">Overtime Request </p>
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
                    <h6 class="title">Are you sure ?</h6>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md btn-outline-theme" id="btn_udpate_confirm" onclick="confirm_update_request()">Yes, Update</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Update Confirm -->

<!-- Modal Delete Confirm-->
<div class="modal fade" id="modalDeleteConfirm" tabindex="-1" aria-labelledby="modalDeleteConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalDeleteConfirmLabel">Form</h6>
                    <p class="text-secondary small">Delete Request </p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-danger dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <h6 class="title">Are you sure ?</h6>
                    <input type="hidden" id="d_time_request_id">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md btn-danger" id="btn_udpate_confirm" onclick="confirm_delete_request()">Yes, Delete</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Delete Confirm -->



<!-- Modal Request List -->
<div class="modal fade" id="modal_list_request" aria-labelledby="modal_list_request_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_list_request">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_list_request_label">List</h6>
                        <p class="text-secondary small">Overtime Request</p>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="dropdown d-inline-block">
                            <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">

                    <div class="row mt-3">
                        <div class="col col-sm-auto">
                            <div class="input-group input-group-md reportrange">
                                <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;">
                                <input type="hidden" name="start" value="" id="start_list" />
                                <input type="hidden" name="end" value="" id="end_list" />
                                <a href="javascript:void(0)" class="input-group-text text-secondary bg-none" onclick="dt_overtime_request_list(1)"><i class="bi bi-search"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" style="padding: 10px;">
                                <table id="dt_overtime_request_list" class="table table-sm table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Overtime Requests</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Request List -->


<!-- Modal Approve Confirm-->
<div class="modal fade" id="modalApproveConfirm" tabindex="-1" aria-labelledby="modalApproveConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalApproveConfirmLabel">Form</h6>
                    <p class="text-secondary small">Approve Request </p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-danger dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <h6 class="title">Are you sure ?</h6>
                    <input type="hidden" id="d_time_request_id">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md btn-danger" id="btn_udpate_confirm" onclick="confirm_approve_request()">Yes, Approve</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Approve Confirm -->

<!-- Modal edit request by Ade -->
<div class="modal fade" id="modal_edit_request" aria-labelledby="modal_edit_request_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_edit_request">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_add_request_label">Form</h6>
                        <p class="text-secondary small">Edit Request For Personalia </p>
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
                        <h6 class="title">Detail Request</h6>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-event-fill"></i></span>
                                        <div class="form-floating">
                                            <input type="text" placeholder="Date" name="edit_request_date" id="edit_request_date" value="<?= date('Y-m-d') ?>" required class="form-control border-start-0">
                                            <label>Date</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg clockpicker">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-hourglass-top"></i></span>
                                        <div class="form-floating">
                                            <input type="text" name="edit_in_time" id="edit_in_time" class="form-control border-start-0" required placeholder="--:--">
                                            <label>In Time</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg clockpicker">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-hourglass-bottom"></i></span>
                                        <div class="form-floating">
                                            <input type="text" name="edit_out_time" id="edit_out_time" class="form-control border-start-0" required placeholder="--:--">
                                            <label>Out Time</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <textarea name="edit_reason" id="edit_reason" class="form-control border-start-0" cols="30" rows="5" style="min-height: 80px;" required></textarea>
                                            <label>Reason</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-md btn-primary" id="btn_save" onclick="edit()">Edit Request <i class="bi bi-floppy"></i></button>
                    <button type="button" style="display:none" class="btn btn-md btn-success" id="btn_update" onclick="update_request()">Update Request <i class="bi bi-floppy"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Edit -->

<!-- Modal Update Confirm New by Ade-->
<div class="modal fade" id="modalUpdateConfirmNew" tabindex="-1" aria-labelledby="modalUpdateConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalUpdateConfirmLabel">Form</h6>
                    <p class="text-secondary small">Overtime Request </p>
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
                    <h6 class="title">Are you sure ?</h6>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md btn-outline-theme" id="btn_udpate_confirm_new" onclick="confirm_update_request_new()">Yes, Update</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Update Confirm New -->