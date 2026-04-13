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
                        <button class="btn btn-primary" id="btn_modal_add_location">Add Location</button>
                    </div>
                </div>
            </div>
            <div class="card border-0">
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_location" class="table table-striped text-nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Location Name</th>
                                    <th>Location Head</th>
                                    <th>City</th>
                                    <th>Country</th>
                                    <th>Added By</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="modal fade" id="modal_form_location" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="title_form_location">Add Company</h6>
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
                <form id="form_add_location">
                    <input type="hidden" name="location_id" id="location_id">
                    <div class="row mb-2">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="company">Company</label>
                            <select class="form-control slim-select border-custom" name="company" id="company">
                                <option value="#" selected disabled>-- Choose Company --</option>
                                <?php foreach ($companies as $row) : ?>
                                    <option value="<?= $row->company_id ?>"><?= $row->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="location_head">Location Head</label>
                            <select class="form-control slim-select border-custom" name="location_head" id="location_head">
                                <option value="#" selected disabled>-- Choose Head --</option>
                                <?php foreach ($user as $row) : ?>
                                    <option value="<?= $row->user_id ?>"><?= $row->employee_name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="location">Location Name</label>
                            <input type="text" class="form-control border-custom" id="location" name="location">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="address_1">Address 1</label>
                            <input type="text" class="form-control border-custom" id="address_1" name="address_1">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="address_2">Address 2</label>
                            <input type="text" class="form-control border-custom" id="address_2" name="address_2">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="email">Email</label>
                            <input type="text" class="form-control border-custom" id="email" name="email">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="phone">Phone</label>
                            <input type="number" class="form-control border-custom" id="phone" name="phone">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="fax_number">Fax Number</label>
                            <input type="text" class="form-control border-custom" id="fax_number" name="fax_number">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <label class="form-label-custom required small" for="city">City</label>
                            <input type="text" class="form-control border-custom" id="city" name="city">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <label class="form-label-custom required small" for="state">State</label>
                            <input type="text" class="form-control border-custom" id="state" name="state">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <label class="form-label-custom required small" for="zip_code">Zip Code</label>
                            <input type="text" class="form-control border-custom" id="zip_code" name="zip_code">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <label class="form-label-custom required small" for="country">Country</label>
                            <select class="form-control slim-select border-custom" name="country" id="country">
                                <option value="#" selected disabled>-- Choose Country --</option>
                                <?php foreach ($countries as $row) : ?>
                                    <option value="<?= $row->country_id ?>"><?= $row->country_name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="btn_save_location" onclick="save_location()" class="btn btn-md btn-primary">Save
                    <i class="bi bi-card-checklist"></i>
                </button>
                <button type="button" id="btn_update_location" onclick="update_location()" class="btn btn-md btn-primary d-none">Update
                    <i class="bi bi-card-checklist"></i>
                </button>
            </div>
        </div>
    </div>
</div>