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
                        <button class="btn btn-primary" id="btn_modal_add_company">Add Company</button>
                    </div>
                </div>
            </div>
            <div class="card border-0">
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_company" class="table table-striped text-nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th style="min-width: 200px;">Company</th>
                                    <th>Email</th>
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
<div class="modal fade" id="modal_form_company" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="title_form_company">Add Company</h6>
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
                <form id="form_add_company">
                    <input type="hidden" name="company_id" id="company_id">
                    <div class="row mb-2">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="company_name">Company Name</label>
                            <input type="text" class="form-control border-custom" id="company_name" name="company_name">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="tax_number">Tax Number / EIN</label>
                            <input type="text" class="form-control border-custom" id="tax_number" name="tax_number">
                        </div>

                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="company_type">Company Type</label>
                            <select class="form-control slim-select border-custom" name="company_type" id="company_type">
                                <option value="#" selected disabled>-- Choose Type --</option>
                                <?php foreach ($company_type as $row) : ?>
                                    <option value="<?= $row->type_id ?>"><?= $row->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="legal">Legal / Trading Name</label>
                            <input type="text" class="form-control border-custom" id="legal" name="legal">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="address_1">Address</label>
                            <input type="text" class="form-control border-custom" id="address_1" name="address_1">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="registration_number">Registration Number</label>
                            <input type="text" class="form-control border-custom" id="registration_number" name="registration_number">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="contact">Contact Number</label>
                            <input type="number" class="form-control border-custom" id="contact" name="contact">
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
                            <label class="form-label-custom required small" for="website">Website</label>
                            <input type="text" class="form-control border-custom" id="website" name="website">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="city">City</label>
                            <input type="text" class="form-control border-custom" id="city" name="city">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="state">State</label>
                            <input type="text" class="form-control border-custom" id="state" name="state">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="zipcode">Zip Code</label>
                            <input type="number" class="form-control border-custom" id="zipcode" name="zipcode">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="country">Country</label>
                            <select class="form-control slim-select border-custom" name="country" id="country">
                                <option value="#" selected disabled>-- Choose Type --</option>
                                <?php foreach ($countries as $row) : ?>
                                    <option value="<?= $row->country_id ?>"><?= $row->country_name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="username">Username</label>
                            <input type="text" class="form-control border-custom" id="username" name="username">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="password">Password</label>
                            <input type="text" class="form-control border-custom" id="password" name="password">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="company_logo">Company Logo</label>
                            <input type="file" class="form-control border-custom" id="company_logo" name="company_logo" accept="image/*">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="btn_save_company" onclick="save_company()" class="btn btn-md btn-primary">Save
                    <i class="bi bi-card-checklist"></i>
                </button>
                <button type="button" id="btn_update_company" onclick="update_company()" class="btn btn-md btn-primary d-none">Update
                    <i class="bi bi-card-checklist"></i>
                </button>
            </div>
        </div>
    </div>
</div>