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
                                <h6 class="fw-medium mb-0">Detail User Exit Clearance</h6>
                            </div>
                            <div class="col-auto ms-auto ps-0">
                                <?php
                                $user_id = $this->session->userdata("user_id");
                                $user_role_id = $this->session->userdata("user_role_id");
                                if ($user_role_id == 1 || $user_id == 2063 || $user_id == 61 || $user_id == 979) { ?>
                                    <a class="btn btn-success text-white d-none" href="<?= base_url(); ?>trusmi_resignation/print_paklaring/<?= $id_resignation; ?>" target="_blank" id="btn_print_paklaring">Print Paklaring</a>
                                    <button class="btn btn-theme d-none" type="button" id="btn_approve_hrd">Approve HRD</button>
                                <?php } ?>
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
                                                            <th style="width: 150px;">Head Name</th>
                                                            <th>:</th>
                                                            <th><span id="head_name"></span></th>
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
                                                            <th>Note</th>
                                                            <th>:</th>
                                                            <th><span id="note"></span></th>
                                                        </tr>
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
                        <br>
                        <div class="row" id="div_verify_resignation">
                        </div>
                    </div>
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
<div class="modal fade" id="modal_approve_hrd" tabindex="-1" aria-labelledby="modal_approve_hrdLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal_approve_hrdLabel">Form</h6>
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
                <button type="button" class="btn btn-md btn-theme" id="btn_save_confirm_hrd" onclick="updateApprovalHrd()">Yes, Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add Confirm -->