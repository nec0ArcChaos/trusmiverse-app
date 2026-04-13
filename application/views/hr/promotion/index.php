<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col col-md mb-2 mb-sm-0">
                <div class="form-group mb-3 position-relative check-valid">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                class="bi bi-building"></i></span>
                        <div class="form-floating">
                            <select name="company" id="company" class="form-control border-start-0">
                                <option value="0">All Companies</option>
                                <?php foreach ($get_company as $cmp): ?>
                                    <option value="<?php echo $cmp->company_id ?>"><?php echo $cmp->company ?></option>
                                <?php endforeach ?>
                            </select>
                            <label>Company</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-md mb-2 mb-sm-0">
                <div class="form-group mb-3 position-relative check-valid">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                class="bi bi-person-rolodex"></i></span>
                        <div class="form-floating">
                            <select name="department" id="department" class="form-control border-start-0">
                                <option value="0">All Departments</option>
                            </select>
                            <label>Department</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md mb-2 mb-sm-0">
                <div class="form-group mb-3 position-relative check-valid">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                class="bi bi-calendar3"></i></span>
                        <div class="form-floating bg-white">
                            <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;"
                                id="titlecalendar">
                            <input type="hidden" name="start" value="" id="start" />
                            <input type="hidden" name="end" value="" id="end" />
                            <label>Periode</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-1 col-md mb-2 mb-sm-0">
                <button class="btn btn-primary" id="btn_filter">Filter</button>
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
                            <i class="bi bi-capslock-fill h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0"><?= $pageTitle; ?></h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                            <div style="display: flex;justify-content: space-between;">
                                <div id="btn_my_resignation" class="hide" style="padding: 5px;">

                                </div>
                                <div style="padding: 5px;">
                                    <button type="button" class="btn btn-md btn-outline-theme" id="add_promotion"><i
                                            class="bi bi-plus"></i> Perubahan Jabatan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_promotion" class="table table-sm table-striped table-bordered" style="width:100%">
                            <thead>
                                <th>Action</th>
                                <th>Employee</th>
                                <th>Description</th>
                                <th>Company</th>
                                <th>Status</th>
                                <th>Type</th>
                                <th>Promotion Title</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Last Target</th>
                                <th>Actual Target</th>
                                <th>Promotion Date</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Approved By</th>
                                <th>Approved At</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</main>


<!-- Modal Add Promotion-->
<div class="modal fade" id="modal_add_promotion" tabindex="-1" aria-labelledby="modal_add_promotionLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #ffc107;">
                <div class="row align-items-center" style="width: -webkit-fill-available;">
                    <div class="col-auto">
                        <i class="bi bi-eye h5 avatar avatar-40 bg-light-white text-white rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0 text-white" id="modal_add_promotionLabel">Form</h6>
                        <p class="text-white small">Add Promotion </p>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="dropdown d-inline-block">
                            <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle"
                                role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form id="form_add_promotion">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                            <div class="form-group mb-3 position-relative from_company check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i
                                            class="bi bi-building-down"></i></span>
                                    <div class="form-floating">
                                        <select name="from_company" id="from_company"
                                            class="form-control from_company border-start-0">
                                            <option value="0" selected>Choose...</option>
                                            <?php foreach ($get_company as $cmp): ?>
                                                <option value="<?php echo $cmp->company_id ?>"><?php echo $cmp->company ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <label>From Company</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-12 col-sm-12 mb-2">
                            <div class="form-group mb-3 position-relative promotion_title check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i
                                            class="bi bi-person-vcard"></i></span>
                                    <div class="form-floating">
                                        <input type="text" placeholder="Promotion Title" name="title"
                                            id="promotion_title" required
                                            class="form-control promotion_title border-start-0">
                                        <label>Promotion Title</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-12 col-sm-12 mb-2">
                            <div class="form-group mb-3 position-relative promotion_date check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i
                                            class="bi bi-calendar-event"></i></span>
                                    <div class="form-floating">
                                        <input type="text" placeholder="Promotion Date" name="promotion_date"
                                            id="promotion_date" required
                                            class="form-control promotion_date border-start-0">
                                        <label>Promotion Date</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                    <div class="form-group mb-3 position-relative employee check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i
                                                    class="bi bi-person-bounding-box"></i></span>
                                            <div class="form-floating">
                                                <select name="employee" id="employee"
                                                    class="form-control employee border-start-0">
                                                    <option value="0" selected>Choose...</option>
                                                </select>
                                                <label>Promotion For</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>

                                <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                    <div class="form-group mb-3 position-relative type check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i
                                                    class="bi bi-circle-square"></i></span>
                                            <div class="form-floating">
                                                <select name="type" id="type" class="form-control type border-start-0">
                                                    <option value="0" selected>Choose...</option>
                                                    <option value="1">Promosi</option>
                                                    <option value="2">Demosi</option>
                                                    <option value="3">Rotasi</option>
                                                    <option value="4">Mutasi</option>
                                                    <option value="5">Assignment</option>
                                                </select>
                                                <label>Type</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                    <div class="form-group mb-3 position-relative to_company check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i
                                                    class="bi bi-building-up"></i></span>
                                            <div class="form-floating">
                                                <select name="to_company" id="to_company"
                                                    class="form-control to_company border-start-0">
                                                    <option value="0" selected>Choose...</option>
                                                    <?php foreach ($get_company as $cmp): ?>
                                                        <option value="<?php echo $cmp->company_id ?>">
                                                            <?php echo $cmp->company ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                                <label>To Company</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>

                                <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                    <div class="form-group mb-3 position-relative designation check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i
                                                    class="bi bi-bookmark-star"></i></span>
                                            <div class="form-floating">
                                                <select name="designation" id="designation"
                                                    class="form-control designation border-start-0">
                                                    <option value="0" selected>Choose...</option>
                                                </select>
                                                <label>Designation</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                    <div class="form-group mb-3 position-relative target check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i
                                                    class="bi bi-bookmark-star"></i></span>
                                            <div class="form-floating">
                                                <input type="text" placeholder="Promotion Date" name="last_target"
                                                    id="last_target_ap" required
                                                    class="form-control last_target border-start-0">
                                                <label>Last Target</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <div class="form-group mb-3 position-relative description check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <textarea placeholder="Description" name="description" id="description"
                                                class="form-control description border-start-0"
                                                style="height: 140px;"></textarea>
                                            <label>Description</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-default" style="margin-right: 10px;"
                    data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md btn-outline-success" id="btn_save_promotion">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add Promotion -->

<!-- Modal View Promotion-->
<div class="modal fade" id="modal_view_promotion" tabindex="-1" aria-labelledby="modal_view_promotionLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #87bc0d;">
                <div class="row align-items-center" style="width: -webkit-fill-available;">
                    <div class="col-auto">
                        <i class="bi bi-eye-fill h5 avatar avatar-40 bg-light-white text-white rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0 text-white" id="modal_view_promotionLabel">Form</h6>
                        <p class="text-white small">View Promotion </p>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="dropdown d-inline-block">
                            <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle"
                                role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text text-theme bg-white border-end-0"><i
                                    class="bi bi-building-check"></i></span>
                            <div class="form-floating">
                                <input type="text" placeholder="Company" id="view_company" required
                                    class="form-control border-start-0" readonly>
                                <label>Company</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text text-theme bg-white border-end-0"><i
                                    class="bi bi-person-fill-check"></i></span>
                            <div class="form-floating">
                                <input type="text" placeholder="Promotion For" id="view_employee" required
                                    class="form-control border-start-0" readonly>
                                <label>Promotion For</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text text-theme bg-white border-end-0"><i
                                    class="bi bi-person-vcard"></i></span>
                            <div class="form-floating">
                                <input type="text" placeholder="Promotion Title" id="view_title" required
                                    class="form-control border-start-0" readonly>
                                <label>Promotion Title</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text text-theme bg-white border-end-0"><i
                                    class="bi bi-bookmark-check"></i></span>
                            <div class="form-floating">
                                <input type="text" placeholder="Designation" id="view_designation" required
                                    class="form-control border-start-0" readonly>
                                <label>Designation</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text text-theme bg-white border-end-0"><i
                                    class="bi bi-calendar2-check"></i></span>
                            <div class="form-floating">
                                <input type="text" placeholder="Promotion Date" id="view_date" required
                                    class="form-control border-start-0" readonly>
                                <label>Promotion Date</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text text-theme bg-white border-end-0"><i
                                    class="bi bi-card-text"></i></span>
                            <div class="form-floating">
                                <input type="text" placeholder="Description" id="view_description" required
                                    class="form-control border-start-0" readonly>
                                <label>Description</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-primary" style="margin-right: 10px;"
                    data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal View Promotion -->

<!-- Modal Edit Promotion-->
<div class="modal fade" id="modal_edit_promotion" tabindex="-1" aria-labelledby="modal_edit_promotionLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #00bbfb;">
                <div class="row align-items-center" style="width: -webkit-fill-available;">
                    <div class="col-auto">
                        <i class="bi bi-pencil-fill h5 avatar avatar-40 bg-light-white text-white rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0 text-white" id="modal_edit_promotionLabel">Form</h6>
                        <p class="text-white small">Edit Promotion </p>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="dropdown d-inline-block">
                            <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle"
                                role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form id="form_edit_promotion">
                    <input type="hidden" name="promotion_id" id="edit_promotion_id">
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text text-theme bg-white border-end-0"><i
                                        class="bi bi-person-fill-check"></i></span>
                                <div class="form-floating">
                                    <input type="text" placeholder="Promotion For" id="edit_employee" required
                                        class="form-control border-start-0" readonly>
                                    <label>Promotion For</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text text-theme bg-white border-end-0"><i
                                        class="bi bi-person-vcard"></i></span>
                                <div class="form-floating">
                                    <input type="text" placeholder="Promotion Title" name="title" id="edit_title"
                                        required class="form-control border-start-0">
                                    <label>Promotion Title</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text text-theme bg-white border-end-0"><i
                                        class="bi bi-calendar2-check"></i></span>
                                <div class="form-floating">
                                    <input type="text" placeholder="Promotion Date" name="date" id="edit_date" required
                                        class="form-control border-start-0">
                                    <label>Promotion Date</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text text-theme bg-white border-end-0"><i
                                        class="bi bi-card-text"></i></span>
                                <div class="form-floating">
                                    <input type="text" placeholder="Description" name="description"
                                        id="edit_description" required class="form-control border-start-0">
                                    <label>Description</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-primary" style="margin-right: 10px;"
                    data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md btn-outline-info" id="btn_edit_promotion">Update</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Edit Promotion -->


<!-- Modal Print Promotion-->
<div class="modal fade" id="modal_print_promotion" tabindex="-1" aria-labelledby="modal_print_promotionLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #015ec2;">
                <div class="row align-items-center" style="width: -webkit-fill-available;">
                    <div class="col-auto">
                        <i class="bi bi-printer h5 avatar avatar-40 bg-light-white text-white rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0 text-white" id="modal_print_promotionLabel">Form</h6>
                        <p class="text-white small">Print Promotion </p>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="dropdown d-inline-block">
                            <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle"
                                role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <input type="hidden" id="val_nama">
                <input type="hidden" id="val_nik">
                <input type="hidden" id="val_jabatan">
                <input type="hidden" id="val_divisi">
                <input type="hidden" id="val_jabatan_lalu">
                <input type="hidden" id="val_divisi_lalu">
                <input type="hidden" id="val_tanggal_promosi">
                <input type="hidden" name="promotion_id" id="edit_promotion_id">
                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text text-theme bg-white border-end-0"><i
                                    class="bi bi-building-fill-lock"></i></span>
                            <div class="form-floating">
                                <select class="form-control" id="val_kop_surat">
                                    <option value="kop_surat_1">PT. Raja Trusmi Group</option>
                                    <option value="kop_surat_2">PT. Batik Sukses Sejahtera</option>
                                    <option value="kop_surat_3">PT. Trusmi Sukses Selalu</option>
                                    <option value="kop_surat_4">PT. Keranjang Sukses Indonesia</option>
                                    <option value="kop_surat_5">PT. Lenso Sukses Indonesia</option>
                                    <option value="kop_surat_6">PT. Toba Sukses Selalu</option>
                                    <option value="kop_surat_7">PT. Raja Sukses Propertindo</option>
                                </select>
                                <label>Kop Surat</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text text-theme bg-white border-end-0"><i
                                    class="bi bi-circle-square"></i></span>
                            <div class="form-floating">
                                <select class="form-control" id="val_sp_tipe">
                                    <option value="PROMOSI">PROMOSI</option>
                                    <option value="MUTASI">MUTASI</option>
                                    <option value="ROTASI">ROTASI</option>
                                    <option value="DEMOSI">DEMOSI</option>
                                </select>
                                <label>Tipe Surat</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text text-theme bg-white border-end-0"><i
                                    class="bi bi-postcard-fill"></i></span>
                            <div class="form-floating">
                                <input type="text" id="val_no_sp" class="form-control"
                                    placeholder="contoh: 010/TRSM-HO/HR/SK/VII/2021">
                                <label>No Surat <small
                                        class="pull-right"><i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;contoh:
                                            010/TRSM-HO/HR/SK/VII/2021</i></small></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text text-theme bg-white border-end-0"><i
                                    class="bi bi-calendar2-check-fill"></i></span>
                            <div class="form-floating">
                                <input type="text" id="val_tanggal" class="form-control" placeholder="Tanggal Surat">
                                <label>Tanggal Surat</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-default" style="margin-right: 10px;"
                    data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md btn-outline-primary" onclick="sertifikat(this)">Cetak
                    Surat</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Print Promotion -->


<!-- Modal Delete Promotion-->
<div class="modal fade" id="modal_delete_promotion" tabindex="-1" aria-labelledby="modal_delete_promotionLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #e03f57;">
                <div class="row align-items-center" style="width: -webkit-fill-available;">
                    <div class="col-auto">
                        <i class="bi bi-trash h5 avatar avatar-40 bg-light-white text-white rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0 text-white" id="modal_delete_promotionLabel">Form</h6>
                        <p class="text-white small">Delete Promotion </p>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="dropdown d-inline-block">
                            <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle"
                                role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <input type="hidden" id="promotion_id">
                <span id="text_delete_promotion">...</span>
                <div class="text-center">
                    <hr>
                    <small>
                        Data yang dihapus tidak bisa dikembalikan lagi.
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-primary" style="margin-right: 10px;"
                    data-bs-dismiss="modal">Batalkan</button>
                <button type="button" class="btn btn-md btn-outline-danger" id="btn_delete_promotion">Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Delete Promotion -->

<!-- Modal Approval Promotion-->
<div class="modal fade" id="modal_approval_promotion" tabindex="-1" aria-labelledby="modal_approval_promotionLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #87bc0d;">
                <div class="row align-items-center" style="width: -webkit-fill-available;">
                    <div class="col-auto">
                        <i
                            class="bi bi-exclamation-square-fill h5 avatar avatar-40 bg-light-white text-white rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0 text-white" id="modal_approval_promotionLabel">Form</h6>
                        <p class="text-white small">Approval Promotion</p>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="dropdown d-inline-block">
                            <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle"
                                role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form id="form_approval_promotion">
                    <input type="hidden" id="approval_promotion_id" name="promotion_id">
                    <input type="hidden" id="approval_no_kontak" name="no_kontak">
                    <input type="hidden" id="approval_nama">
                    <input type="hidden" id="approval_nik">
                    <input type="hidden" id="approval_jabatan">
                    <input type="hidden" id="approval_divisi">
                    <input type="hidden" id="approval_jabatan_lalu">
                    <input type="hidden" id="approval_divisi_lalu">
                    <input type="hidden" id="approval_tanggal_promosi">
                    <input type="hidden" id="approval_user_id" name="user_id">
                    <input type="hidden" id="approval_company_id" name="company_id">
                    <input type="hidden" id="approval_department_id" name="department_id">
                    <input type="hidden" id="approval_designation_id" name="designation_id">
                    <input type="hidden" id="approval_location_id" name="location_id">
                    <span id="text_approval_promotion">...</span>

                    <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                        <div class="form-group mb-3 position-relative approval_status check-valid">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text text-theme bg-white border-end-0"><i
                                        class="bi bi-clipboard-check-fill"></i></span>
                                <div class="form-floating">
                                    <select class="form-control approval_status" id="approval_status" name="status">
                                        <option value="0" selected>Choose...</option>
                                        <option value="1">Approve</option>
                                        <option value="2">Reject</option>
                                    </select>
                                    <label>Status Approval</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row div_com" style="display: none;">
                        <div class="col-lg-4">
                            <div class="form-group mb-3 position-relative com_id check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i
                                            class="bi bi-building"></i></span>
                                    <div class="form-floating">
                                        <select class="form-control com_id" id="com_id" name="com_id">
                                            <option value="0" selected>Choose...</option>
                                            <?php foreach ($get_company as $data): ?>
                                                <option value="<?= $data->company_id ?>"><?= $data->company ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label>Company</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group mb-3 position-relative dep_id check-valid">

                                <div class="form-floating">
                                    <select class="form-control dep_id" id="dep_id" name="dep_id">
                                        <option value="0" selected>Choose...</option>
                                    </select>
                                    <label>Department</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group mb-3 position-relative des_id check-valid">

                                <div class="form-floating">
                                    <select class="form-control des_id" id="des_id" name="des_id">
                                        <option value="0" selected>Choose...</option>
                                    </select>
                                    <label>Designation</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                        <div class="form-group mb-3 position-relative user_role_id check-valid">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text text-theme bg-white border-end-0"><i
                                        class="bi bi-circle-square"></i></span>
                                <div class="form-floating">
                                    <select name="type" id="approval_id_type" class="form-control type border-start-0">
                                        <option value="0" selected>Choose...</option>
                                        <option value="1">Promosi</option>
                                        <option value="2">Demosi</option>
                                        <option value="3">Rotasi</option>
                                        <option value="4">Mutasi</option>
                                        <option value="5">Assignment</option>
                                    </select>
                                    <label>Type</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                        <div class="form-group mb-3 position-relative user_role_id check-valid">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text text-theme bg-white border-end-0"><i
                                        class="bi bi-arrow-up-square-fill"></i></span>
                                <div class="form-floating">
                                    <select class="form-control user_role_id" id="user_role_id" name="user_role_id">
                                        <option value="0" selected>Choose...</option>
                                        <?php foreach ($get_roles as $rl): ?>
                                            <option value="<?= $rl->role_id ?>"><?= $rl->role_name ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <input type="hidden" name="ctm_posisi" id="ctm_posisi">
                                    <label>Role</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row div_tgl_loc" style="display: none;">
                        <div class="col-6">
                            <div class="form-group mb-3 position-relative approval_tanggal check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i
                                            class="bi bi-geo-alt-fill"></i></span>
                                    <div class="form-floating">
                                        <select class="form-control loc_id" id="loc_id" name="loc_id">
                                            <option value="0" selected>Choose...</option>
                                            <?php foreach ($get_location as $item): ?>
                                                <option value="<?= $item->location_id ?>"
                                                    data-company="<?= $item->company_id ?>"><?= $item->location_name ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <label>Location</small></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3 position-relative approval_tanggal check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i
                                            class="bi bi-calendar2-check-fill"></i></span>
                                    <div class="form-floating">
                                        <input type="text" id="approval_tanggal"
                                            class="form-control approval_tanggal border-start-0"
                                            placeholder="Tanggal Surat">
                                        <label>Tanggal Surat</small></label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row div_target" style="display: none;">
                        <div class="col-6">
                            <div class="form-group mb-3 position-relative target check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i
                                            class="bi bi-record-circle-fill"></i></span>
                                    <div class="form-floating">
                                        <input type="text" id="last_target_ap" name="target_before" readonly
                                            class="form-control border-start-0">
                                        <label>Target before</small></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3 position-relative target check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i
                                            class="bi bi-record-circle-fill"></i></span>
                                    <div class="form-floating">
                                        <input type="text" id="actual_target_ap" name="target_actual"
                                            class="form-control border-start-0">
                                        <label>Target actual</small></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>



                    <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                        <div class="form-group mb-3 position-rela check-valid">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text text-theme bg-white border-end-0"><i
                                        class="bi bi-stickies-fill"></i></span>
                                <div class="form-floating">
                                    <input type="text" placeholder="Note" name="approve_note"
                                        class="form-control border-start-0">
                                    <label>Note</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-primary" style="margin-right: 10px;"
                    data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-md btn-outline-success" id="btn_approval_promotion">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Approval Promotion -->


<!-- Div Print Promotion -->
<div style="display: none;">
    <div class="container" id="div_print">
        <img src="http://trusmiverse.com/kop_company/raja_trusmi_group.jpg" style="width: 100%;" id="kop_surat_1">
        <img src="http://trusmiverse.com/kop_company/batik_sukses_sejahtera.jpg" style="width: 100%;" id="kop_surat_2">
        <img src="http://trusmiverse.com/kop_company/trusmi_sukses_selalu.jpg" style="width: 100%;" id="kop_surat_3">
        <img src="http://trusmiverse.com/kop_company/keranjang_sukses_indonesia.jpg" style="width: 100%;"
            id="kop_surat_4">
        <img src="http://trusmiverse.com/kop_company/lenso_sukses_indonesia.jpg" style="width: 100%;" id="kop_surat_5">
        <img src="http://trusmiverse.com/kop_company/toba_sukses_selalu.jpg" style="width: 100%;" id="kop_surat_6">
        <img src="http://trusmiverse.com/kop_company/raja_sukses_propertindo.jpg" style="width: 100%;" id="kop_surat_7">
        <div><span
                style="font-size: 22px; font-family: 'Times New Roman'; position: absolute; top: 17%; left: 50%; transform: translate(-50%, -50%); text-align: center; font-weight: 650;"><u>SURAT
                    KEPUTUSAN</u></span></div>
        <div
            style="font-size: 21px; font-family: 'Times New Roman'; position: absolute; top: 19%; left: 50%; transform: translate(-50%, -50%); text-align: center; font-weight: 650;">
            No. : <span id="no_sp"></span></div>
        <div
            style="font-size: 18px; font-family: 'Times New Roman'; position: absolute; top: 22%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
            Tentang : <b><span id="sp_tipe"></span></b></div>
        <div
            style="font-size: 18px; font-family: 'Times New Roman'; position: absolute; top: 23%; margin-left: 80px; margin-right: 80px; text-align: justify; text-justify: inter-word;">
            <p>
                Dalam rangka efektifitas, efesiensi dan mengoptimalkan potensi tenaga kerja yang ada. Sesuai dengan
                kebutuhan dan perkembangan perusahaan, maka dengan ini kami selaku:
            <table border="0" style="width: 100%; margin-left: -2px; font-size: 18px;">
                <tr>
                    <td align="center" colspan="3"><b>MANAGEMENT <br> <span id="text_kop_surat">TRUSMI GROUP</span> <br>
                            MEMUTUSKAN</b></td>
                </tr>
                <tr>
                    <td width="15%">Nama</td>
                    <td width="1%">:</td>
                    <td><span id="nama"></span></td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>:</td>
                    <td><span id="nik"></span></td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td><span id="jabatan_lalu"></span></td>
                </tr>
                <tr>
                    <td>Divisi</td>
                    <td>:</td>
                    <td><span id="divisi_lalu"></span></td>
                </tr>
                <tr>
                    <td colspan="3"><br>Untuk selanjutnya Saudara terhitung <span id="tanggal_promosi"></span>
                        ditugaskan di :<br><br></td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td><span id="jabatan"></span></td>
                </tr>
                <tr>
                    <td>Divisi</td>
                    <td>:</td>
                    <td><span id="divisi"></span></td>
                </tr>
            </table>
            <br>
            Dengan ketentuan apabila dikemudian hari terjadi perubahan atau kekeliruan akan diperbaharui dan ditinjau
            kembali.
            <br>
            <br>
            <table border="0" style="width: 100%; font-size: 18px;">
                <tr>
                    <td colspan="5">Cirebon, <span id="tanggal">12 Oktober 2021</span></td>
                </tr>
                <tr>
                    <td width="33%" valign="top" align="center">
                        Dibuat Oleh,
                        <br><br><br><br>
                        <!-- <u><b><?php //echo $manager['first_name'] . ' ' . $manager['last_name'] 
                        ?></b></u>
                            <br><?php //echo $manager['designation_name'] 
                            ?> -->
                        <u><b>Fafricony Ristiara Devi</b></u>
                        <br>Compensation & Benefit Supervisor
                    </td>
                    <td width="33%" valign="top" align="center"></td>
                    <td width="33%" valign="top" align="center">
                        <!-- Diketahui Oleh,
                            <br><br><br><br>
                            <u><b><span id="nama_diketahui">Bambang</span></b></u>
                            <br><span id="jabatan_diketahui">Manager Option</span> -->
                    </td>
                </tr>
            </table>
            </p>

        </div>
    </div>
</div>
<!-- Div Print Promotion -->


<script type="text/javascript">
    function sertifikat(id) {

        var divToPrint = document.getElementById('div_print');

        document.getElementById("kop_surat_1").style.display = "none";
        document.getElementById("kop_surat_2").style.display = "none";
        document.getElementById("kop_surat_3").style.display = "none";
        document.getElementById("kop_surat_4").style.display = "none";
        document.getElementById("kop_surat_5").style.display = "none";
        document.getElementById("kop_surat_6").style.display = "none";
        document.getElementById("kop_surat_7").style.display = "none";

        val_kop_surat = document.getElementById('val_kop_surat').value;

        if (val_kop_surat == 'kop_surat_1') {
            text_kop_surat = "RAJA TRUSMI GROUP";
        } else if (val_kop_surat == 'kop_surat_2') {
            text_kop_surat = "BATIK SUKSES SEJAHTERA";
        } else if (val_kop_surat == 'kop_surat_3') {
            text_kop_surat = "TRUSMI SUKSES SELALU";
        } else if (val_kop_surat == 'kop_surat_4') {
            text_kop_surat = "KERANJANG SUKSES INDONESIA";
        } else if (val_kop_surat == 'kop_surat_5') {
            text_kop_surat = "LENSO SUKSES INDONESIA";
        } else if (val_kop_surat == 'kop_surat_6') {
            text_kop_surat = "TOBA SUKSES SELALU";
        } else if (val_kop_surat == 'kop_surat_7') {
            text_kop_surat = "RAJA SUKSES PROPERTINDO";
        } else {
            text_kop_surat = "TRUSMI GROUP";
        }

        document.getElementById(document.getElementById('val_kop_surat').value).style.display = "block";

        nama = document.getElementById('val_nama').value;

        document.getElementById('nama').innerHTML = nama;
        document.getElementById('text_kop_surat').innerHTML = text_kop_surat;
        document.getElementById('sp_tipe').innerHTML = document.getElementById('val_sp_tipe').value;
        document.getElementById('no_sp').innerHTML = document.getElementById('val_no_sp').value;
        document.getElementById('nik').innerHTML = document.getElementById('val_nik').value;
        document.getElementById('jabatan_lalu').innerHTML = document.getElementById('val_jabatan_lalu').value;
        document.getElementById('jabatan').innerHTML = document.getElementById('val_jabatan').value;
        document.getElementById('divisi_lalu').innerHTML = document.getElementById('val_divisi_lalu').value;
        document.getElementById('divisi').innerHTML = document.getElementById('val_divisi').value;
        document.getElementById('tanggal_promosi').innerHTML = document.getElementById('val_tanggal_promosi').value;
        document.getElementById('tanggal').innerHTML = document.getElementById('val_tanggal').value;
        // diketahui = document.getElementById('val_diketahui').value.split(' | ');
        // document.getElementById('nama_diketahui').innerHTML = diketahui[0];
        // document.getElementById('jabatan_diketahui').innerHTML = diketahui[1];

        var htmlToPrint = '' +
            '<style type="text/css">' +
            '@page {' +
            'size: portrait;' +
            'margin: 0mm;  /* this affects the margin in the printer settings */' +
            '}' +
            '* {' +
            '-webkit-print-color-adjust: exact !important;   /* Chrome, Safari, Edge */' +
            'color-adjust: exact !important;                 /*Firefox*/' +
            '}' +
            '@media print {' +
            'html, body {' +
            'border: 1px solid white;' +
            'height: 99%;' +
            'page-break-after: avoid;' +
            'page-break-before: avoid;' +
            '}' +
            '}' +
            '.container {' +
            'position: relative;' +
            // 'border-left: 100px solid red;'+
            // 'border-right: 10px solid red;'+
            // 'margin-left:-100px;'+
            '}' +
            '</style>';

        htmlToPrint += divToPrint.outerHTML;
        newWin = window.open("");
        newWin.document.write(htmlToPrint);
        setTimeout(function () {
            newWin.print();
            newWin.close();
        }, 2000);
    }
</script>