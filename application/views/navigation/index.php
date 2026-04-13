<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $title; ?></h5>
            </div>
            <div class="col-auto ps-0">

            </div>
        </div>
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="m-3">
        <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-4">
            <div class="card border-0 theme-red">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class=" col-auto">
                            <i class="bi bi-list-task h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col">
                            <h6 class="fw-medium mb-0"><span class="text-gradient">Navigation</span> - List</h6>
                            <p class="text-secondary small">This menu help you manage your navigation</p>
                        </div>
                        <div class="col-auto ps-0">
                            <button class="btn btn-primary" id="add_navigation"><i class="bi bi-plus"></i> Navigation</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 mb-4">
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_navigation" class="table table-sm table-striped text-nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Level</th>
                                    <th>Urutan</th>
                                    <th>Parent</th>
                                    <th>Menu Name</th>
                                    <th>Menu Url</th>
                                    <th>Menu Icon</th>
                                    <th>Role Id</th>
                                    <th>Company Id</th>
                                    <th>Department Id</th>
                                    <th>Designation Id</th>
                                    <th>User Id</th>
                                    <th>User Id Blocked</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card border-0 mb-4">
                <div class="card-body">
                    <h4>Tree View Navigation</h4>
                    <ul>
                        <?php foreach ($menu_a as $a) { ?>
                            <li>
                                <?= $a->a_menu ?>
                                <?php if ($a->a_url == "#") { ?>
                                    <?php foreach ($menu_b as $b) { ?>
                                        <?php if ($b->b_parent_id == $a->a_id) { ?>
                                            <ul>
                                                <li><?= $b->b_menu; ?></li>
                                                <?php if ($b->b_url == "#") { ?>
                                                    <ul>
                                                        <?php foreach ($menu_c as $c) { ?>
                                                            <?php if ($c->c_parent_id == $b->b_id) { ?>

                                                                <li><?= $c->c_menu; ?></li>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </ul>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                    <?php  } ?>
                                <?php } ?>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal Add -->
<div class="modal fade" id="modal_add_navigation" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalApproveLabel">Form</h6>
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
                <form id="form_navigation">
                    <div class="proses">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" id="menu_nm" name="menu_nm" class="form-control">
                                            <label>Menu Name</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" id="menu_url" name="menu_url" class="form-control">
                                            <label>Menu Url</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" id="menu_icon" name="menu_icon" class="form-control">
                                            <label>Menu Icon</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <label>Parent Id</label>
                                    <select name="parent_id" id="parent_id" class="form-control border-start-0">

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" id="level" name="level" value="1" class="form-control" readonly>
                                            <label>Level</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <label>Role Id</label>
                                    <select name="role_id" id="role_id" class="form-control border-start-0" multiple>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <label>Company Id</label>
                                    <select name="company_id" id="company_id" class="form-control border-start-0" multiple>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <label>Department Id</label>
                                    <select name="department_id" id="department_id" class="form-control border-start-0" multiple>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <label>Designation Id</label>
                                    <select name="designation_id" id="designation_id" class="form-control border-start-0" multiple>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <label>User Id</label>
                                    <select name="user_id" id="user_id" class="form-control border-start-0" multiple>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <label>User Id Blocked</label>
                                    <select name="user_id_blocked" id="user_id_blocked" class="form-control border-start-0" multiple>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn m-1 btn-secondary" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button class="btn m-1 btn-theme" id="store_navigation">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Add -->


<!-- Modal Edit -->
<div class="modal fade" id="modal_edit_navigation" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal_edit_navigation_label">Form</h6>
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
                <form id="e_form_navigation">
                    <div class="proses">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="hidden" id="e_menu_id" name="menu_id" class="form-control" readonly>
                                            <input type="text" id="e_menu_nm" name="menu_nm" class="form-control">
                                            <label>Menu Name</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" id="e_menu_url" name="menu_url" class="form-control">
                                            <label>Menu Url</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" id="e_menu_icon" name="menu_icon" class="form-control">
                                            <label>Menu Icon</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <label>Parent Id</label>
                                    <select name="parent_id" id="e_parent_id" class="form-control border-start-0">

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" id="e_level" name="level" value="1" class="form-control" readonly>
                                            <label>Level</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <label>Role Id</label>
                                    <select name="role_id[]" id="e_role_id" class="form-control border-start-0" multiple>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <label>Company Id</label>
                                    <select name="company_id" id="e_company_id" class="form-control border-start-0" multiple>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <label>Department Id</label>
                                    <select name="department_id" id="e_department_id" class="form-control border-start-0" multiple>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <label>Designation Id</label>
                                    <select name="designation_id" id="e_designation_id" class="form-control border-start-0" multiple>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <label>User Id</label>
                                    <select name="user_id" id="e_user_id" class="form-control border-start-0" multiple>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <label>User Id Blocked</label>
                                    <select name="user_id_blocked" id="e_user_id_blocked" class="form-control border-start-0" multiple>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn m-1 btn-secondary" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button class="btn m-1 btn-theme" id="e_store_navigation">Update</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Edit -->


<!-- Modal -->
<div class="modal fade" id="modal_edit_menu_icon" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalApproveLabel">Form</h6>
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
                <a href="https://icons.getbootstrap.com/" class="btn btn-primary btn-sm mb-2" target="_blank">List Icon...</a>
                <div class="form-group mb-3 position-relative check-valid">
                    <div class="input-group input-group-lg">
                        <div class="form-floating">
                            <input type="text" id="e_menu_icon" name="menu_icon" class="form-control">
                            <input type="text" id="e_menu_id_icon" name="menu_id" class="form-control" readonly>
                            <label>Menu Icon</label>
                        </div>
                    </div>
                </div>
                <small>*contoh : bi bi-house</small>
            </div>
            <div class="modal-footer">
                <button class="btn m-1 btn-secondary" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button class="btn m-1 btn-theme" id="update_menu_icon">Update Icon</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->