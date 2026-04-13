<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Deskripsi Page</p>
            </div>
            <div class="col col-sm-auto">
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

    <?php if ($check_resignation == true) { ?>
        <div class="m-3">
            <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
                <div class="card border-0">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-auto">
                                <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-theme rounded"></i>
                            </div>
                            <div class="col-auto align-self-center">
                                <h6 class="fw-medium mb-0">Form Approve Exit Clearance</h6>
                            </div>
                            <div class="col-auto ms-auto ps-0">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-lg-12 col-md-12 col-sm-12 fade-in">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-12 col-sm-12 order-2 slide_left">
                                            <div class="table-responsive" style="padding: 10px;">
                                                <table class="table table-sm table-striped" style="width:100%">
                                                    <thead>
                                                        <?php if (in_array($this->session->userdata('user_id'), [1, 778, 979])): ?>
                                                            <tr>
                                                                <th style="width: 150px;">Employee Name</th>
                                                                <th>:</th>
                                                                <th><span id="employee_name"></span></th>
                                                            </tr>
                                                            <tr>
                                                                <th style="width: 150px;">Company</th>
                                                                <th>:</th>
                                                                <th><span id="company_name"></span></th>
                                                            </tr>
                                                            <tr>
                                                                <th style="width: 150px;">Department</th>
                                                                <th>:</th>
                                                                <th><span id="department_name"></span></th>
                                                            </tr>
                                                            <tr>
                                                                <th style="width: 150px;">Designation</th>
                                                                <th>:</th>
                                                                <th><span id="designation_name"></span></th>
                                                            </tr>
                                                            <tr>
                                                                <th style="width: 150px;">SPV</th>
                                                                <th>:</th>
                                                                <th><span id="nama_spv"></span></th>
                                                            </tr>
                                                            <tr>
                                                                <th style="width: 150px;">Manager</th>
                                                                <th>:</th>
                                                                <th><span id="nama_mng"></span></th>
                                                            </tr>
                                                            <tr>
                                                                <th style="width: 150px;">Date Of Joining</th>
                                                                <th>:</th>
                                                                <th><span id="date_of_joining"></span></th>
                                                            </tr>
                                                            <tr>
                                                                <th style="width: 150px;">Masa Kerja</th>
                                                                <th>:</th>
                                                                <th><span id="masa_kerja"></span></th>
                                                            </tr>
                                                            <tr>
                                                                <th style="width: 150px;">Habis Kontrak</th>
                                                                <th>:</th>
                                                                <th><span id="habis_kontrak"></span></th>
                                                            </tr>
                                                            <tr>
                                                                <th style="width: 150px;">Terakhir Absen</th>
                                                                <th>:</th>
                                                                <th><span id="terakhir_absen"></span></th>
                                                            </tr>
                                                            <tr>
                                                                <th>No. Telp</th>
                                                                <th>:</th>
                                                                <th><span id="contact_no"></span></th>
                                                            </tr>
                                                            <tr>
                                                                <th style="vertical-align: top;">Address</th>
                                                                <th style="vertical-align: top;">:</th>
                                                                <th style="vertical-align: top;"><span id="address"></span></th>
                                                            </tr>
                                                            <tr>
                                                                <th>Reason</th>
                                                                <th>:</th>
                                                                <th><span id="reason"></span></th>
                                                            </tr>
                                                            <tr>
                                                                <th style="vertical-align: baseline;">Note</th>
                                                                <th style="vertical-align: baseline;">:</th>
                                                                <th style="text-align: justify;"><span id="note"></span></th>
                                                            </tr>
                                                        <?php else: ?>
                                                            <tr>
                                                                <th style="width: 150px;">Employee Name</th>
                                                                <th>:</th>
                                                                <th><span id="employee_name"></span></th>
                                                            </tr>
                                                            <tr>
                                                                <th style="width: 150px;">Company</th>
                                                                <th>:</th>
                                                                <th><span id="company_name"></span></th>
                                                            </tr>
                                                            <tr>
                                                                <th style="width: 150px;">Department</th>
                                                                <th>:</th>
                                                                <th><span id="department_name"></span></th>
                                                            </tr>
                                                            <tr>
                                                                <th style="width: 150px;">Designation</th>
                                                                <th>:</th>
                                                                <th><span id="designation_name"></span></th>
                                                            </tr>
                                                            <tr>
                                                                <th style="width: 150px;">SPV</th>
                                                                <th>:</th>
                                                                <th><span id="nama_spv"></span></th>
                                                            </tr>
                                                            <tr>
                                                                <th style="width: 150px;">Manager</th>
                                                                <th>:</th>
                                                                <th><span id="nama_mng"></span></th>
                                                            </tr>
                                                            <tr>
                                                                <th style="width: 150px;">Date Of Joining</th>
                                                                <th>:</th>
                                                                <th><span id="date_of_joining"></span></th>
                                                            </tr>
                                                        <?php endif ?>
                                                    </thead>

                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12 col-sm-12 text-right order-1 order-md-12 order-sm-12 slide_right" style="display: block;margin: auto auto;">
                                            <div class="col-auto" style="text-align: center;" id="profile_picture">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($this->session->userdata('user_id') == '1784') { ?>
                            <div class="row mt-3">
                                <div class="col">
                                    <div class="card">
                                        <h5 class="card-header">
                                            <a class="d-flex justify-content-between align-items-center collapsed" data-toggle="collapse" href="#collapse-collapsed" aria-expanded="true" aria-controls="collapse-collapsed" id="heading-collapsed">
                                                <span>List Benefit Karyawan</span>
                                                <i class="bi bi-caret-right-fill collapse-icon"></i>
                                            </a>
                                        </h5>
                                        <div id="collapse-collapsed" class="collapse" aria-labelledby="heading-collapsed">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="dt_list_inventaris" class="table nowrap table-striped" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Jenis Asset</th>
                                                                <th>Item</th>
                                                                <th>Tanggal Recieve</th>
                                                                <th>Recieved By</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- DataTables content -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php } ?>
                        <br>
                        <div class="row" id="div_verify_resignation">
                        </div>
                        <!-- <div class="table-responsive" style="padding: 10px;">
                            <table id="dt_verify_resignation" class="table table-sm table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Pilih Exit Clearance</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>

                            </table>
                        </div>
                        <div class="col-sm-12">
                            <form id="form_exit_clearance">

                            </form>
                        </div> -->
                    </div>
                    <!-- <div class="card-footer" style="text-align: right;">
                        <button class="btn btn-primary" id="btn_approve_exit_clearance" onclick="approveResignation()"><i class="ti-check"></i> Approve</button>
                    </div> -->
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="col-12 align-self-center py-4 text-center">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-7 col-xl-6 col-xxl-4">
                    <h1 class="display-5">No Data Found</h1>
                    <i class="bi bi-search" style="font-size: 100pt;"></i>
                    <br>
                </div>
            </div>
        </div>
    <?php } ?>
</main>
<!-- Modal Add Confirm-->
<div class="modal fade" id="modalAddConfirm" tabindex="-1" aria-labelledby="modalAddConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddConfirmLabel">Form</h6>
                    <p class="text-secondary small">Approval Exit Clearance </p>
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
                <input type="hidden" id="u_id_exit_clearance" name="id_exit_clearance" readonly>
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md" id="btn_save_confirm" onclick="updateApproval()">Yes, Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add Confirm -->

<!-- Modal Confirm Save Reason Atasan -->
<div class="modal fade" id="modal-reason-atasan" tabindex="-1" aria-labelledby="modal-reason-atasan-label" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal-reason-atasan-label">Form</h6>
                    <p class="text-secondary small">Simpan Alasan Resign dari Atasan </p>
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
                <input type="hidden" id="i_reason_atasan" name="i_reason_atasan" readonly>
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md btn-theme" id="btn-save-reason-atasan">Yes, Save</button>
            </div>
        </div>
    </div>
</div>
<!-- // Modal Confirm Save Reason Atasan -->