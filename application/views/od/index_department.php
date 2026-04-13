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
                                    <h6 class="fw-medium" id="title_form">Add Department</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="form_department">
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label class="me-sm-2">Name</label>
                                        <input type="text" name="department_name" id="department_name" class="form-control" placeholder="Department name..">
                                        <input type="hidden" name="department_id" id="department_id" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label class="me-sm-2">Company</label>
                                        <select class="form-control select2" name="company_id" id="company_id" required>
                                            <option value="">- Select Company -</option>
                                            <?php foreach ($companies as $row): ?>
                                                <option value="<?php echo $row->company_id ?>"><?php echo $row->name ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label class="me-sm-2">Location</label>
                                        <select class="form-control select2" name="location_id" id="location_id" required>
                                            <option value="" disabled selected>- Select Location -</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label class="me-sm-2">Department Head</label>
                                        <select class="form-control select2" name="head_id" id="head_id" required>
                                            <option value="" disabled selected>- Select Department Head -</option>
                                            <?php foreach ($department_head as $row): ?>
                                                <option value="<?php echo $row->user_id ?>"><?php echo $row->employee_name ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label class="me-sm-2">Break</label>
                                        <select class="form-control select2" name="break" id="break" required>
                                            <option value="0">Non Aktif</option>
                                            <option value="1" selected>Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label class="me-sm-2">Kode</label>
                                        <input type="text" name="department_kode" id="department_kode" class="form-control" placeholder="Department code..">
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
                                    <i class="bi bi-building h5 avatar avatar-40 bg-light-theme rounded"></i>
                                </div>
                                <div class="col-auto align-self-center">
                                    <h6 class="fw-medium">List Department</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="padding: 10px;">
                                <table id="dt_department" class="table table-sm table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
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
        </div>
    </div>
</main>
