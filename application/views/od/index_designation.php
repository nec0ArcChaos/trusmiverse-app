
<main class="main mainheight">
<div class="container-fluid">
<div class="row" style="margin-top: 10px;">
    <div class="col-5">


        <div class="card">
            <div class="card-header">
                <h4 class="card-title" id="title_form">Add Designation</h4>
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
                <h4 class="card-title">List Designation</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dt_designation" class="table table-striped display nowrap" style="min-width: 100%">
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
</main>
