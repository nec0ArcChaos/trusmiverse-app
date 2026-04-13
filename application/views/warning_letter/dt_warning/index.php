<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
            </div>
            <div class="col col-sm-auto">
                <div class="input-group input-group-md reportrange">
                    <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;">
                    <input type="hidden" name="startdate" value="" id="start" />
                    <input type="hidden" name="enddate" value="" id="end" />
                    <span class="input-group-text text-secondary bg-none" id="btn_filter"><i class="bi bi-calendar-event"></i></span>
                </div>
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
                    <div class="row mb-4">
                        <div class="col-auto">
                            <i class="bi bi-person-workspace h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">Warning Letter</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto ps-0">
                            <div style="display: flex;justify-content: start; padding-left:10px;">
                                <input type="hidden" id="level_sto" value="<?= $sto['level_sto'] ?>" readonly>
                                <div class="me-1">
                                    <select class="form-select" aria-label="Default select example" style="border-width: 2px; height:44px" id="company">
                                        <option value="#" selected disabled>-- Pilih Perusahaan --</option>
                                        <option value="null">All</option>
                                        <?php foreach ($companies as $row) : ?>
                                            <option value="<?= $row->company_id ?>"><?= $row->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="me-3">
                                    <select class="form-select" aria-label="Default select example" style="border-width: 2px; height:44px" id="department">
                                        <option value="null">All</option>
                                    </select>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-info" onclick="show_warning_letter();"><i class="bi bi-search"></i>
                                    Find</button>
                                </div>

                            </div>
                        </div>
                        <div class="col"></div>
                        <?php if (in_array($this->session->userdata('user_id'), $dt_head_id) || $this->session->userdata('user_id') == 1): ?>
                            <div class="col-lg-2 col-md-2 col-sm-12 d-flex justify-content-end">
                                <button class="btn btn-warning" id="btn_rekomendasi_warning">Rekomen. Warning</button>
                            </div>
                        <?php endif ?>
                        <?php if ($sto['level_sto'] >= 4) { ?>
                            <div class="col-lg-2 col-md-2 col-sm-12 d-flex justify-content-end">
                                <button class="btn btn-primary" id="btn_modal_add_letter" style="width: 100%;">Add Warning </button>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dt_warning_letter" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Employee</th>
                                    <th>Warning</th>
                                    <th>Status</th>
                                    <th>Company</th>
                                    <th>Warning Date</th>
                                    <th>Created At</th>
                                    <th>Subject</th>
                                    <th>Warning By</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="modal_form_warning" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="title_form_warning">Add Warning Letter</h6>
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
                <form id="form_add_warning" enctype="multipart/form-data">
                    <input type="hidden" name="warning_id" id="warning_id">
                    <input type="hidden" name="warning_to" id="warning_to">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div id="for_add">
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <label class="form-label-custom required small" for="company_form">Company</label>
                                        <select class="form-control slim-select border-custom" name="company_form" id="company_form">
                                            <option value="#" selected disabled>-- Choose Company --</option>
                                            <?php foreach ($companies as $row) : ?>
                                                <option value="<?= $row->company_id ?>"><?= $row->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <label class="form-label-custom required small" for="employee">Employee</label>
                                        <select class="form-control slim-select border-custom" name="employee" id="employee">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="for_edit">
                                <div class="col-12">
                                    <label class="form-label-custom required small" for="chronological">Chronological</label>
                                    <textarea class="form-control slim-select border-custom" name="chronological" id="chronological" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <label class="form-label-custom required small" for="corrective">Corrective Action</label>
                                    <textarea class="form-control slim-select border-custom" name="corrective" id="corrective" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <label class="form-label-custom required small" for="warning_type">Warning Type</label>
                                    <select class="form-control slim-select border-custom" name="warning_type" id="warning_type" disabled>
                                        <option value="#" selected disabled>-- Choose Warning Type --</option>
                                        <?php foreach ($warning_type as $row) : ?>
                                            <option value="<?= $row->warning_type_id ?>"><?= $row->type ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <label class="form-label-custom required small" for="subject">Subject</label>
                                    <input type="text" class="form-control slim-select border-custom" id="subject" name="subject">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <label class="form-label-custom required small" for="warning_date">Warning Date</label>
                                    <input type="date" class="form-control slim-select border-custom" id="warning_date" name="warning_date">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="row mb-2">
                                <div class="col-12">
                                    <label class="form-label-custom required small" for="result_investigation">Result Investigation</label>
                                    <textarea class="form-control slim-select border-custom" name="result_investigation" id="result_investigation" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <label class="form-label-custom required small" for="another_note">Another Note</label>
                                    <textarea class="form-control slim-select border-custom" name="another_note" id="another_note" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label-custom required small" for="status">Status</label>
                                    <select class="form-control slim-select border-custom" name="status" id="status">
                                        <option value="#" selected disabled></option>
                                        <option value="0">Pending</option>
                                        <option value="1">Accepted</option>
                                        <option value="2">Rejected</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="col-12">
                                        <label class="form-label-custom required small" for="attachment">Attachment</label>
                                        <input type="file" class="form-control" id="attachment" name="attachment">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="btn_save_warning" onclick="save_warning()" class="btn btn-md btn-primary">Save
                    <i class="bi bi-card-checklist"></i>
                </button>
                <button type="button" id="btn_update_warning" onclick="update_warning()" class="btn btn-md btn-primary d-none">Update
                    <i class="bi bi-card-checklist"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_list_rekomendasi" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="title_form_warning">Rekomendasi Warning</h6>
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
             <div class="table-responsive">
                <table id="dt_rekomendasi_warning" class="table nowrap table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>Karyawan</th>
                            <th>Status</th>
                            <th>Company</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Date of Join</th>
                            <th>Masa Kerja</th>
                            <th>Penalty</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="modal_form_rekom_warning" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="title_form_warning">Add Warning Letter (Rekomendasi)</h6>
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
                <form id="form_add_warning_rekom" enctype="multipart/form-data">
                    <input type="hidden" name="penalty_id" id="penalty_id">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body">
                                    <figure class="coverimg rounded w-100 h-150 mb-3" id="profil">
                                        <img id="img_profil" class="w-100" alt="" style="display: none;">
                                    </figure>
                                    <h5 class="mb-1" id="text_karyawan"></h5>
                                    <p class="text-secondary mb-3" id="text_designation"></p>
                                    <div class="row gx-2 mb-2">
                                        <div class="col-lg-8">
                                            <div class="col-lg-12 col-sm-12 mb-2">
                                                <p class="text-secondary"><i class="bi bi-book avatar avatar-24 me-1"></i> Company <br>
                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b id="text_company">...</b></span>
                                                </p>
                                            </div>
                                            <div class="col-lg-12 col-sm-12 mb-2">
                                                <p class="text-secondary"><i class="bi bi-clock avatar avatar-24 me-1"></i> Department <br>
                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b id="text_department">...</b></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="col-lg-12 col-sm-12 mb-2">
                                                <p class="text-secondary"><i class="bi bi-clock avatar avatar-24 me-1"></i> Date of Join <br>
                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b id="text_date_of_joining">...</b></span>
                                                </p>
                                            </div>
                                            <div class="col-lg-12 col-sm-12 mb-2">
                                                <p class="text-secondary"><i class="bi bi-clock avatar avatar-24 me-1"></i> Masa Kerja <br>
                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b id="text_masa_kerja">...</b></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label class="form-label-custom required small">Status Rekomendasi</label>
                                    <select class="form-control slim-select border-custom" name="status_penalty" id="status_penalty_rekom">
                                        <option value="0">Waiting</option>
                                        <option value="1">Accepted</option>
                                        <option value="2">Rejected</option>
                                    </select>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 d-none" id="div_reject_note">
                                    <label class="form-label-custom required small">Reject Note</label>
                                    <textarea class="form-control slim-select border-custom" name="reject_note" id="reject_note" rows="5"></textarea>
                                </div>
                            </div>


                        </div>
                        
                    </div>
                    <div class="row d-none" id="data_rekom">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div id="for_add">
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <label class="form-label-custom required small">Company</label>
                                        <input type="text" class="form-control" id="company_form_name" readonly>
                                        <input type="hidden" name="company_form" id="company_form_rekom">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <label class="form-label-custom required small">Employee</label>
                                        <input type="text" class="form-control" id="employee_name" readonly>
                                        <input type="hidden" name="employee" id="employee_rekom">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <label class="form-label-custom required small">Corrective Action</label>
                                    <textarea class="form-control slim-select border-custom" name="corrective" id="corrective_rekom" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <label class="form-label-custom required small">Warning Typex</label>
                                    <select class="form-control slim-select border-custom" name="warning_type" id="warning_type_rekom">
                                        <option value="#" selected disabled>-- Choose Warning Type --</option>
                                        <?php foreach ($warning_type as $row) : ?>
                                            <option value="<?= $row->warning_type_id ?>"><?= $row->type ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <label class="form-label-custom required small">Subject</label>
                                    <input type="text" class="form-control slim-select border-custom" id="subject_rekom" name="subject">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <label class="form-label-custom required small">Warning Date</label>
                                    <input type="date" class="form-control slim-select border-custom" id="warning_date_rekom" name="warning_date">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="row mb-2">
                                <div class="col-12">
                                    <label class="form-label-custom required small">Result Investigation</label>
                                    <textarea class="form-control slim-select border-custom" name="result_investigation" id="result_investigation_rekom" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <label class="form-label-custom required small">Another Note</label>
                                    <textarea class="form-control slim-select border-custom" name="another_note" id="another_note_rekom" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label-custom required small">Status</label>
                                    <select class="form-control slim-select border-custom" name="status" id="status_rekom">
                                        <option value="#" selected disabled></option>
                                        <option value="0">Pending</option>
                                        <option value="1">Accepted</option>
                                        <option value="2">Rejected</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="col-12">
                                        <label class="form-label-custom required small" for="attachment_rekom">Attachment</label>
                                        <input type="file" class="form-control" id="attachment_rekom" name="attachment">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="btn_save_warning_rekom" onclick="save_warning_rekom()" class="btn btn-md btn-primary d-none">Save
                    <i class="bi bi-card-checklist"></i>
                </button>
            </div>
        </div>
    </div>
</div>