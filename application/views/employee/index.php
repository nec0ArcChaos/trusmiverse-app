
<div class="row" style="margin-top: 10px;">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">List Employee - Report To</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dt_employee" class="display" style="min-width: 100%">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Employee</th>
                                <th>Company</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Report To</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_edit_emp">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form id="form_report_to">
                    <label>Report To</label>
                    <input type="hidden" name="user_id" id="user_id">
                    <select class="form-control select2" name="report_to" id="report_to">
                        <option value="0" selected disabled>Select Report To</option>
                        <?php foreach ($emp as $row): ?>
                            <option value="<?php echo $row->user_id ?>"><?php echo $row->employee . ' | ' . $row->designation_name ?></option>
                        <?php endforeach ?>
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary" id="btn_update">Update</button>
            </div>
        </div>
    </div>
</div>
