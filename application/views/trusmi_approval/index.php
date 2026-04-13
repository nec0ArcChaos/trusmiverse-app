<main class="main mainheight">
    <!-- <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 overflow-hidden mb-4">
                <div class="card-body position-relative">
                    <div class="coverimg w-75 h-100 end-0 top-0 position-absolute cover-right-center-img">
                        <img src=" assets/img/offer-1.png" class="w-100" alt="">
                    </div>
                    <div class="row align-items-center justify-content-center h-100">
                        <div class="col-10 py-3 py-xl-5">
                            <h3 class="text-theme mb-1">Refer &amp; Earn 20%</h3>
                            <h5 class="fw-medium">Make your wallet even bigger</h5>
                            <p class="text-secondary">Share your referral code to your friends and earn flat 20% amount.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Deskripsi Page</p>
                <!-- parameter input untuk trigger modal waiting approval open -->
                <input id="modal_open_waiting" type="hidden" value="<?= isset($_GET['m']) ? $_GET['m'] : ''; ?>">
                <input id="no_app_waiting" type="hidden" value="<?= isset($_GET['id']) ? $_GET['id'] : ''; ?>">
            </div>
            <div class="col col-sm-auto">
                <form method="POST" id="form_filter">
                    <div class="input-group input-group-md reportrange">
                        <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                        <input type="hidden" name="start" value="" id="start" />
                        <input type="hidden" name="end" value="" id="end" />
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
                            <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Approval</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                            <?php if (date("H") >= 20 || date("H") <= 6) { ?>
                                <button type="button" class="btn btn-md btn-outline-theme" onclick="alertDiluarJamOperasional()"><i class="bi bi-plus"></i> Request</button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-md btn-outline-theme" data-bs-toggle="modal" data-bs-target="#modalAdd"><i class="bi bi-plus"></i> Request</button>
                            <?php } ?>
                            <button type="button" class="btn btn-md btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalWaitingApproval" onclick="dt_trusmi_waiting_approval()"><i class="bi bi-list"></i> Approval</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dt_trusmi_approval" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No Approve</th>
                                    <th>Subject</th>
                                    <th>Description</th>
                                    <th>Req By</th>
                                    <th>Aprv To</th>
                                    <th>Aprv By</th>
                                    <th>Aprv at</th>
                                    <th>Status Aprv</th>
                                    <th>Status Leadtime</th>
                                    <th>Leadtime</th>
                                    <th>Keterangan</th>
                                    <th>File</th>
                                    <th>Created At</th>
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
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_add">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                        <p class="text-secondary small">Request New Approval</p>
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
                        <h6 class="title">Detail Request <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                        <div class="row">
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-info-square"></i></span>
                                        <div class="form-floating">
                                            <input type="text" placeholder="Subject" name="subject" id="subject" required class="form-control border-start-0">
                                            <label>Subject</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill-up"></i></span>
                                        <div class="form-floating">
                                            <select name="approve_to" id="approve_to" class="form-control border-start-0" onchange="passContact()">
                                            </select>
                                            <label>Approve To</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill-up"></i></span>
                                        <div class="form-floating">
                                            <select name="kategori" id="kategori" class="form-control border-start-0" onchange="is_eaf()">
                                                <option value="Approval">Approval</option>
                                                <option value="Memo">Memo</option>
                                                <option value="BA">BA</option>
                                                <option value="Eaf">Eaf</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <label>Kategori</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div id="field_nominal" class="form-group mb-3 position-relative check-valid d-none">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-info-square"></i></span>
                                        <div class="form-floating">
                                            <input type="number" placeholder="Nominal" name="nominal" id="nominal" class="form-control border-start-0">
                                            <label>Nominal</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <p class="text-center fw-bold mb-0" id="txt_speech">Fitur Speech to Text</p>
                                        <div class='sound-icon disabled'>
                                            <div class='sound-wave'>
                                                <i class='bar-idle'></i>
                                                <i class='bar-idle'></i>
                                                <i class='bar-idle'></i>
                                                <i class='bar-idle'></i>
                                                <i class='bar-idle'></i>
                                                <i class='bar-idle'></i>
                                                <i class='bar-idle'></i>
                                                <i class='bar-idle'></i>
                                                <i class='bar-idle'></i>
                                                <i class='bar-idle'></i>
                                                <i class='bar-idle'></i>
                                                <i class='bar-idle'></i>
                                                <i class='bar-idle'></i>
                                                <i class='bar-idle'></i>
                                                <i class='bar-idle'></i>
                                                <i class='bar-idle'></i>
                                                <i class='bar-idle'></i>
                                                <i class='bar-idle'></i>
                                                <i class='bar-idle'></i>
                                                <i class='bar-idle'></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 d-flex alig-items-center justify-content-center">
                                        <div class="d-flex align-items-center">
                                            <div class="action-buttons">
                                                <button type="button" class="record-btn" id="startRecord"><i class="bi bi-mic"></i></button>
                                                <button type="button" class="action-btn" id="cancelBtn">Cancel</button>
                                                <button type="button" class="action-btn" id="clearBtn">Clear</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <textarea name="description" id="description" class="form-control border-start-0" cols="30" rows="5" style="min-height: 80px;" required></textarea>
                                            <label>Description</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                        </div>

                        <h6 class="title">Related Documents <span class="text-secondary" style="font-size: 9pt;">(*Optional)</span></h6>
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="card border-0 mb-4">
                                    <div class="card-body">
                                        <div class="row gx-3 align-items-center">
                                            <div class="col-auto">
                                                <!-- <div class="col-auto">
                                                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                                                </div> -->
                                                <div class="avatar avatar-40 rounded bg-light-blue text-white">
                                                    <i class="bi bi-file-earmark-text h5 vm"></i>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <h6 class="fw-medium mb-1">Allowed File</h6>
                                                <p class="text-secondary">.pdf, .jpg, .png, .jpeg</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-cloud-upload"></i></span>
                                        <div class="form-floating">
                                            <input type="file" placeholder="Related Documents 1" name="file_1" id="file_1" required class="form-control" onchange="compress('#file_1', '#string_file_1', '#btn_save', '.fa_wait_1', '.fa_done_1')" accept="gambar/*" capture="">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" class="form-control" name="string_file_1" id="string_file_1">
                                <div class="fa_wait_1" style="display: none;"><i class="fa fa-spinner fa-pulse"></i> <label>Copressing File ...</label></div>
                                <div class="fa_done_1" style="display: none;"><i class="fa fa-check-circle" style="color: #689f38;"></i> <label>Copressing Complete.</label></div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-cloud-upload"></i></span>
                                        <div class="form-floating">
                                            <input type="file" placeholder="Related Documents 1" name="file_2" id="file_2" required class="form-control" onchange="compress('#file_2', '#string_file_2', '#btn_save', '.fa_wait_2', '.fa_done_2')" accept="gambar/*" capture="">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" class="form-control" name="string_file_2" id="string_file_2">
                                <div class="fa_wait_2" style="display: none;"><i class="fa fa-spinner fa-pulse"></i> <label>Copressing File ...</label></div>
                                <div class="fa_done_2" style="display: none;"><i class="fa fa-check-circle" style="color: #689f38;"></i> <label>Copressing Complete.</label></div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="contact_approve_to" id="contact_approve_to" readonly>
                    <input type="hidden" name="username" id="username" readonly>
                    <button type="button" class="btn btn-md btn-outline-theme" id="btn_save" onclick="save()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->

<!-- Modal Waiting Approval -->
<div class="modal fade" id="modalWaitingApproval" tabindex="-1" aria-labelledby="modalWaitingApprovalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content d-flex flex-column" style="height: 100vh;">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalWaitingApprovalLabel">List</h6>
                    <p class="text-secondary small">Waiting Approval</p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body flex-grow-1" style="overflow-y: auto;">
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_trusmi_waiting_approval" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No Approve</th>
                                    <th>Subject</th>
                                    <th>Description</th>
                                    <th>Req By</th>
                                    <th>Aprv To</th>
                                    <th>Aprv By</th>
                                    <th>Aprv at</th>
                                    <th>Status Aprv</th>
                                    <th>Status Leadtime</th>
                                    <th>Leadtime</th>
                                    <th>Keterangan</th>
                                    <th>File</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- Footer content jika diperlukan -->
            </div>
        </div>
    </div>
</div>
<!-- Modal Waiting Approval -->


<!-- Modal Approve -->
<div class="modal fade" id="modalApprove" tabindex="-1" aria-labelledby="modalApproveLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalApproveLabel">Form</h6>
                    <p class="text-secondary small">Approval</p>
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
                        <div class="col-12 col-md-12 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-info-square"></i></span>
                                    <div class="form-floating">
                                        <input type="text" placeholder="Subject" name="subject" id="subject_a" required class="form-control border-start-0" readonly>
                                        <label>Subject</label>
                                    </div>
                                </div>
                            </div>
                            <div class="invalid-feedback mb-3">Add valid data </div>
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill-down"></i></span>
                                    <div class="form-floating">
                                        <input type="text" placeholder="Requested By" name="created_by" id="created_by_a" required class="form-control border-start-0" readonly>
                                        <label>Requested By</label>
                                    </div>
                                </div>
                            </div>
                            <div class="invalid-feedback mb-3">Add valid data </div>
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill-up"></i></span>
                                    <div class="form-floating">
                                        <input type="text" placeholder="Approve To" name="approve_to" id="approve_to_a" required class="form-control border-start-0" readonly>
                                        <label>Approve To</label>
                                    </div>
                                </div>
                            </div>
                            <div class="invalid-feedback mb-3">Add valid data </div>
                        </div>
                        <div class="col-12 col-md-12 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                    <div class="form-floating">
                                        <textarea name="description" id="description_a" class="form-control border-start-0" cols="30" rows="5" style="min-height: 80px;" required readonly></textarea>
                                        <label>Description</label>
                                    </div>
                                </div>
                            </div>
                            <div class="invalid-feedback mb-3">Add valid data </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-4 col-lg-4">
                            <h6 class="title">Related Documents</h6>
                            <div id="file_a"></div>
                        </div>
                        <div class="col-12 col-md-8 col-lg-8">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <p class="text-center fw-bold mb-0" id="txt_speechApproval">Fitur Speech to Text</p>
                                    <div class='sound-icon disabled'>
                                        <div class='sound-wave'>
                                            <i class='bar-idle'></i>
                                            <i class='bar-idle'></i>
                                            <i class='bar-idle'></i>
                                            <i class='bar-idle'></i>
                                            <i class='bar-idle'></i>
                                            <i class='bar-idle'></i>
                                            <i class='bar-idle'></i>
                                            <i class='bar-idle'></i>
                                            <i class='bar-idle'></i>
                                            <i class='bar-idle'></i>
                                            <i class='bar-idle'></i>
                                            <i class='bar-idle'></i>
                                            <i class='bar-idle'></i>
                                            <i class='bar-idle'></i>
                                            <i class='bar-idle'></i>
                                            <i class='bar-idle'></i>
                                            <i class='bar-idle'></i>
                                            <i class='bar-idle'></i>
                                            <i class='bar-idle'></i>
                                            <i class='bar-idle'></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 d-flex alig-items-center justify-content-center">
                                    <div class="d-flex align-items-center">
                                        <div class="action-buttons">
                                            <button type="button" class="record-btn" id="startRecordApproval"><i class="bi bi-mic"></i></button>
                                            <button type="button" class="action-btn" id="cancelBtnApproval">Cancel</button>
                                            <button type="button" class="action-btn" id="clearBtnApproval">Clear</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h6 class="title">Action</h6>
                            <form action="" id="formApprove">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <input type="hidden" name="no_app" id="no_app_a" readonly>
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <textarea name="approve_note" id="approve_note" class="form-control border-start-0" cols="30" rows="5" required></textarea>
                                            <label>Note Approve</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" style="text-align: right;">
                                    <button type="button" class="btn btn-md text-white btn-danger" id="btn_reject" onclick="reject()">Reject</button>
                                    <button type="button" class="btn btn-md text-white btn-success" id="btn_approve" onclick="approve()">Approve</button>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<!-- Modal Approve -->



<!-- Modal Resend WA -->
<div class="modal fade" id="modalResendWa" tabindex="-1" aria-labelledby="modalResendWaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalResendWaLabel">Confirmation Needed</h6>
                    <p class="text-secondary small">Resend Request Whatsapp Notification</p>
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
                <p>Apakah anda yakin ingin mengirim ulang notifikasi whatsapp request ?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="no_app_resend_wa" id="no_app_resend_wa" readonly>
                <button class="btn btn-outline-success btn-sm" onclick="resend_wa()"><i class="bi bi-whatsapp"></i> SEND WA</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Resend WA -->