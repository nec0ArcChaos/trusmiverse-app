<main class="main mainheight">
    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-diagram-2 h5 avatar avatar-40 bg-light-theme rounded"></i>
                                </div>
                                <div class="col-auto align-self-center">
                                    <h6 class="fw-medium">Report To</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_employee" class="table table-sm table-striped" style="width:100%">
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
</main>

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
