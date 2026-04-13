<main class="main mainheight">
    <div class="m-3">
        <div class="row">
            <div class="col-lg-5 col-md-12 col-sm-12">
                <div class="col-12 position-relative column-set">
                    <div class="card border-0">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-plus-circle h5 avatar avatar-40 bg-light-theme rounded"></i>
                                </div>
                                <div class="col-auto align-self-center">
                                    <h6 class="fw-medium" id="title_form">Add Designation</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="form_designation">
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label class="me-sm-2">Company</label>
                                        <select class="form-control select2" name="company_id" id="company_id" required>
                                            <option value="">-- Pilih Company --</option>
                                            <?php foreach ($companies as $row): ?>
                                                <option value="<?php echo $row->company_id ?>"><?php echo $row->name ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label class="me-sm-2">Main Department</label>
                                        <select class="form-control select2" name="department_id" id="department_id" required>
                                            <option value="0" disabled selected>Select Department</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label class="me-sm-2">Designation</label>
                                        <input type="hidden" name="designation_id" id="designation_id" class="form-control">
                                        <input type="text" name="designation_name" id="designation_name" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label class="me-sm-2">Report To</label>
                                        <select class="form-control select2" name="report_to" id="report_to" required>
                                            <option value="0" disabled selected>Select Designation</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <div class="row mb-3" align="right">
                                <div class="col-12">
                                    <button class="btn btn-md btn-outline-success" id="btn_add"><i class="bi bi-plus-lg"></i> Add</button>
                                    <button class="btn btn-md btn-outline-primary" id="btn_update" style="display: none;"><i class="bi bi-pencil"></i> Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 col-md-12 col-sm-12">
                <div class="col-12 position-relative column-set">
                    <div class="card border-0">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-person-badge h5 avatar avatar-40 bg-light-theme rounded"></i>
                                </div>
                                <div class="col-auto align-self-center">
                                    <h6 class="fw-medium">List Designation</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="padding: 10px;">
                                <table id="dt_designation" class="table table-sm table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Designation</th>
                                            <th>Company</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
