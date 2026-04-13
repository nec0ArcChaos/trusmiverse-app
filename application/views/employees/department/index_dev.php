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
                        <button class="btn btn-primary" id="btn_modal_add_department">Add Department</button>
                    </div>
                </div>
            </div>
            <div class="card border-0">
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_department" class="table table-striped text-nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Department Name</th>
                                    <th>Working Location</th>
                                    <th>Location</th>
                                    <th>Company</th>
                                    <th>Total Emp</th>
                                    <th>Head</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="modal fade" id="modal_form_department" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="title_form_department">Add Department</h6>
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
                <form id="form_add_department">
                    <input type="hidden" name="department_id" id="department_id">
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
                            <label class="form-label-custom required small" for="location">location</label>
                            <select class="form-control slim-select border-custom" name="location" id="location">
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="department_head">Department Head</label>
                            <select class="form-control slim-select border-custom" name="department_head" id="department_head">
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="break">Break</label>
                            <select class="form-control slim-select border-custom" name="break" id="break">
                                <option value="#" selected disabled>-- Choose Break --</option>
                                <option value="1">Aktif</option>
                                <option value="0">Non Aktif</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="work_location">Working Location</label>
                            <div class="input-group">
                                <select class="form-control slim-select border-custom" name="work_location" id="work_location">
                                    <option value="" selected disabled>-- Choose Working Location --</option>
                                    <?php foreach ($working_locations as $wl) : ?>
                                        <option value="<?= $wl->id ?>"><?= $wl->lokasi ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <button class="btn btn-primary" type="button" onclick="open_modal_new_location()" title="Add New Location">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="btn_save_department" onclick="save_department()" class="btn btn-md btn-primary">Save
                    <i class="bi bi-card-checklist"></i>
                </button>
                <button type="button" id="btn_update_department" onclick="update_department()" class="btn btn-md btn-primary d-none">Update
                    <i class="bi bi-card-checklist"></i>
                </button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal_add_location" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Add Working Location</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_new_location">
                    <div class="mb-3">
                        <label class="form-label small required">Location Name</label>
                        <input type="text" class="form-control" name="new_location_name" id="new_location_name" placeholder="e.g. TGS, JMP, TKB">
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="new_location_public" name="new_location_public" value="1">
                        <label class="form-check-label small" for="new_location_public">Set as Public (Allow)</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary m-1" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm btn-primary" onclick="save_new_location()">Save Location</button>
            </div>
        </div>
    </div>
</div>