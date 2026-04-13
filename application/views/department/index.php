
<div class="row" style="margin-top: 10px;">
    <div class="col-5">


        <div class="card">
            <div class="card-header">
                <h4 class="card-title" id="title_form">Add Department</h4>
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
                        <button class="btn btn-sm btn-success" id="btn_add">Add</button>
                        <button class="btn btn-sm btn-primary" id="btn_update" style="display: none;">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-7">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">List Department</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dt_department" class="display" style="min-width: 100%">
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