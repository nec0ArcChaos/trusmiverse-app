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
            <div class="row d-flex justify-content-end mb-2">
                <div class="col-8 d-flex justify-content-end">
                    <div class="col-3 mr-1">
                        <button class="btn btn-primary" id="btn_modal_add_designation">Add designation</button>
                    </div>
                </div>
            </div>
            <div class="card border-0">
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_designation" class="table table-striped text-nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Designation</th>
                                    <th>Department</th>
                                    <th>Company</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="modal fade" id="modal_form_designation" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="title_form_designation">Add Designation</h6>
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
                <form id="form_add_designation">
                    <input type="hidden" name="designation_id" id="designation_id">
                    <div class="row mb-2">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="name">Name</label>
                            <input type="text" class="form-control slim-select border-custom" name="name" id="name">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="company">Company</label>
                            <select class="form-control slim-select border-custom" name="company" id="company">
                                <option value="#" selected disabled>-- Choose Company --</option>
                                <?php foreach ($companies as $row) : ?>
                                    <option value="<?= $row->company_id ?>"><?= $row->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="department">Department</label>
                            <select class="form-control slim-select border-custom" name="department" id="department">
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="shift">Shift</label>
                            <select class="form-control slim-select border-custom" name="shift" id="shift">
                                <option value="#" selected disabled>-- Choose Shift --</option>
                                <?php foreach ($shift as $row) : ?>
                                    <option value="<?= $row->id_trusmi_shift ?>"><?= $row->shift ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="btn_save_designation" onclick="save_designation()" class="btn btn-md btn-primary">Save
                    <i class="bi bi-card-checklist"></i>
                </button>
                <button type="button" id="btn_update_designation" onclick="update_designation()" class="btn btn-md btn-primary d-none">Update
                    <i class="bi bi-card-checklist"></i>
                </button>
            </div>
        </div>
    </div>
</div>