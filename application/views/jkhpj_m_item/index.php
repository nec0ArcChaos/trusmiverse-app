<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-8 col-md mb-2 mb-sm-0">
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
                <div class="row">
                    <div class="col-12 col-md-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle; ?></li>
                        </ol>
                    </div>

                </div>

            </nav>
        </div>
    </div>

    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto-right" align="right">
                            <?php if (in_array($user_id, [1, 2, 6466, 4498, 2521, 3651, 4770, 4954, 5121, 6717, 8305, 3690, 1186, 321, 4499])): ?>
                                <button type="button" class="btn btn-md btn-outline-theme mb-2" onclick="add_task()"><i class="bi bi-journal-plus"></i> Add Tasklist</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_jkhpj_m_item" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Designation</th>
                                    <!-- <th>Jadwal</th>
                                    <th>Tasklist</th>
                                    <th>Deskripsi</th>
                                    <th>Menggunakan File?</th> -->
                                    <th></th>
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

<!-- Add Item -->
<div class="modal fade" id="modal_add_item" role="dialog">
    <div class="modal-dialog center" style="max-width: 90%;position:absolute;top: 60px;bottom:0;left:0;right:0;margin:auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add JKHPJ Item</h4>
                <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
                <form id="form_item">
                    <div class="row">
                        <div class="col-12 col-md-4 mb-2">
                            <label class="form-label-custom required small" for="company">Company</label>
                            <div class="input-group mb-3">
                                <select name="company" id="company" class="form-control" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" onchange="get_department();">
                                    <option selected disable> --Pilih Company-- </option>
                                    <?php foreach ($companies as $company) : ?>
                                        <option value="<?= $company->company_id ?>"><?= $company->company_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-2">
                            <label class="form-label-custom required small" for="department">Department</label>
                            <div class="input-group mb-3">
                                <select name="department" id="department" class="form-control" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" onchange="get_designation()">
                                    <option selected disable> --Pilih Department-- </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-2">
                            <label class="form-label-custom required small" for="designation">Designation <i class="text-danger">*</i></label>
                            <div class="input-group mb-3">
                                <select name="designation_id" id="designation" class="form-control" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                    <option selected disable> --Pilih Designation-- </option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12 col-md-6 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <label>Tasklist <i class="text-danger">*</i></label>
                                <div class="input-group">
                                    <input type="text" name="tasklist[]" id="tasklist" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <label>Description <i class="text-danger">*</i></label>
                                <div class="input-group">
                                    <textarea class="form-control input_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" name="description[]" id="description" rows="5" required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <label>Jam Mulai <i class="text-danger">*</i></label>
                                <div class="input-group">
                                    <input type="text" name="time_start[]" id="time_start" class="form-control timepicker">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <label>Jam Selesai <i class="text-danger">*</i></label>
                                <div class="input-group">
                                    <input type="text" name="time_end[]" id="time_end" class="form-control timepicker">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mb-2">
                            <label class="form-label-custom required small" for="is_file">Menggunakan File?</label>
                            <div class="input-group mb-3">
                                <select name="is_file[]" id="is_file" class="form-control" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                    <option value="0" selected>Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                        </div>

                        <div id="tasklist-container">
                            <!-- Dynamic Tasklist Items Will Be Appended Here -->
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-sm btn-outline-theme" onclick="addTask()">Add Task</button>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-md btn-outline-theme" id="btn_save_item" onclick="simpan_item()">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- End Add Item -->

<!-- Add Item -->
<div class="modal fade" id="modal_table_tasklist" role="dialog">
    <div class="modal-dialog center" style="max-width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tasklist</h4>
                <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
                <div class="table-responsive" style="padding: 10px;">
                    <table id="dt_jkhpj_m_item_detail" class="table table-striped dt-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th>Designation</th>
                                <th>Jadwal</th>
                                <th>Tasklist</th>
                                <th>Deskripsi</th>
                                <th>Menggunakan File?</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Add Item -->


<div class="modal fade" id="modal_edit_item" role="dialog">
    <div class="modal-dialog center" style="max-width: 70%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit JKHPJ Item</h4>
                <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
                <form id="form_edit_item">
                    <input type="hidden" name="id_jkhpj_item" id="edit_id_jkhpj_item">

                    <div class="row">
                        <div class="col-12 col-md-6 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <label>Tasklist <i class="text-danger">*</i></label>
                                <div class="input-group">
                                    <input type="text" name="tasklist" id="edit_tasklist" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <label>Description <i class="text-danger">*</i></label>
                                <div class="input-group">
                                    <textarea class="form-control" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" name="description" id="edit_description" rows="5" required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <label>Jam Mulai <i class="text-danger">*</i></label>
                                <div class="input-group">
                                    <input type="text" name="time_start" id="edit_time_start" class="form-control timepicker">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <label>Jam Selesai <i class="text-danger">*</i></label>
                                <div class="input-group">
                                    <input type="text" name="time_end" id="edit_time_end" class="form-control timepicker">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mb-2">
                            <label class="form-label-custom required small" for="is_file">Menggunakan File?</label>
                            <div class="input-group mb-3">
                                <select name="is_file" id="edit_is_file" class="form-control" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-md btn-outline-theme" id="btn_update_item" onclick="update_item()">Update</button>
            </div>
        </div>
    </div>
</div>