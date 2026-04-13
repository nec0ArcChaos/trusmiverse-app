<main class="main mainheight">
    <div class="container-fluid">
        <div class="row align-items-center page-title">
            <div class="col-8 col-md">
                <form action="<?= base_url(); ?>leave">
                    <button type="submit" class="btn btn-theme text-dinamis btn-sm" id="back_to_leave"><i class="bi bi-arrow-left"></i> Back</button>
                </form>
            </div>
        </div>
        <div class="row breadcrumb-theme align-items-center">
            <h5 class="mb-0">Manage Leave</h5>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="row mb-4">
                    <div class="col-12 ">
                        <hr>
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="circle-small">
                                            <div id="circleprogressred"></div>
                                            <div class="avatar h5 bg-light-theme text-theme rounded-circle">
                                                <i class="bi bi-exclamation-diamond"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <p class="text-secondary small mb-1"><?= $detail_leave['type_name']; ?></p>
                                        <p><?= $detail_leave['employee_name']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 col-md-6 mb-1 border-right-dashed">
                                <div class="card">
                                    <div class="card-header">
                                        <p>Last Taken Leave</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-12 col-md-12 mb-1">
                                            <div class="d-flex justify-content-between">
                                                <p class="text-dinamis text-muted small mb-1">Leave Type</p>
                                                <p class="text-dinamis text-dark"><?= $last_detail_leave['type_name']; ?></p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p class="text-dinamis text-muted small mb-1">Applied On</p>
                                                <p class="text-dinamis text-dark"><?= $last_detail_leave['applied_on']; ?></p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p class="text-dinamis text-muted small mb-1">Total Days</p>
                                                <p class="text-dinamis text-dark"><?= $last_detail_leave['total_day']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-1">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <p>Leave Statistics</p>
                                        <button class="button-4 text-dinamis" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_available_leave" aria-expanded="false" aria-controls="collapse_available_leave">View Statistics</button>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush bg-none" id="available_leave">

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-1">
                                <div class="card">
                                    <div class="card-header">
                                        <p>Leave Details</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-12 col-md-12 mb-1">
                                            <div class="d-flex justify-content-between">
                                                <p class="text-dinamis text-muted small mb-1">Employee Name</p>
                                                <p class="text-dinamis text-dark"><?= $detail_leave['employee_name']; ?></p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p class="text-dinamis text-muted small mb-1">Type Leave</p>
                                                <p class="text-dinamis text-dark"><?= $detail_leave['type_name']; ?></p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p class="text-dinamis text-muted small mb-1">Company</p>
                                                <p class="text-dinamis text-dark"><?= $detail_leave['company_name']; ?></p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p class="text-dinamis text-muted small mb-1">Department</p>
                                                <p class="text-dinamis text-dark"><?= $detail_leave['department_name']; ?></p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p class="text-dinamis text-muted small mb-1">Applied On</p>
                                                <p class="text-dinamis text-dark"><?= $detail_leave['applied_on']; ?></p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p class="text-dinamis text-muted small mb-1">From s/d To</p>
                                                <p class="text-dinamis text-dark"><?= $detail_leave['from_date']; ?> s/d <?= $detail_leave['to_date']; ?></p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p class="text-dinamis text-muted small mb-1">Total Days</p>
                                                <p class="text-dinamis text-dark"><?= $detail_leave['total_day']; ?></p>
                                            </div>
                                            <div class="row col-12">
                                                <p class="text-dinamis text-muted small m-0">Reason</p>
                                                <p class="text-dinamis text-dark"><?= $detail_leave['reason']; ?></p>
                                            </div>
                                            <div class="row col-12">
                                                <p class="text-dinamis text-muted small m-0">Attachment</p>
                                                <?php if ($detail_leave['leave_attachment'] != "") { ?>
                                                    <p class="text-dinamis text-dark"><a target="_blank" href="https://trusmiverse.com/hr/uploads/leave/<?= $detail_leave['leave_attachment']; ?>">File Attachment</a></p>
                                                <?php } else { ?>
                                                    <p>no file</p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <p>Form Approve</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-12 col-md-12 mb-1">
                                            <div class="row justify-content-between">
                                                <div class="col-12 col-md-6 mb-1">
                                                    <p class="text-dinamis text-muted small mb-1">Status</p>
                                                </div>
                                                <div class="col-12 col-md-6 mb-1 text-end">
                                                    <span class="badge <?= $detail_leave['bg_status']; ?> text-white"><?= $detail_leave['status']; ?></span>
                                                    <input type="hidden" readonly class="form-control border-custom" name="leave_type_id" id="leave_type_id" value="<?= $detail_leave['leave_type_id']; ?>">
                                                    <input type="hidden" readonly class="form-control border-custom" name="id_status" id="id_status" value="<?= $detail_leave['id_status']; ?>">
                                                </div>
                                            </div>
                                            <?php if (in_array($this->session->userdata('user_id'), [1, 979, 78])) { ?>
                                                <div class="row justify-content-between">
                                                    <div class="col-12 col-md-6 mb-1">
                                                        <p class="text-dinamis text-muted small mb-1">Leave Type</p>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-1">
                                                        <div class="col-12">
                                                            <select id="leave_type" name="leave_type" class="wide mb-3 leave_type custom-style">
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="row justify-content-between">
                                                <div class="col-12 col-md-6 mb-1">
                                                    <p class="text-dinamis text-muted small mb-1">Start Date</p>
                                                </div>
                                                <div class="col-12 col-md-6 mb-1">
                                                    <input type="text" class="form-control border-custom tgl tanggal" name="start_date" id="start_date" placeholder="yyyy-mm-dd" value="<?= $detail_leave['start_date']; ?>">
                                                </div>
                                            </div>
                                            <div class="row justify-content-between">
                                                <div class="col-12 col-md-6 mb-1">
                                                    <p class="text-dinamis text-muted small mb-1">End Date</p>
                                                </div>
                                                <div class="col-12 col-md-6 mb-1">
                                                    <input type="text" class="form-control border-custom tgl tanggal" name="end_date" id="end_date" placeholder="yyyy-mm-dd" value="<?= $detail_leave['end_date']; ?>">
                                                </div>
                                            </div>
                                            <div class="row justify-content-between">
                                                <div class="col-12 col-md-6 mb-1">
                                                    <p class="text-secondary small mb-1">Remarks</p>
                                                </div>
                                                <div class="col-12 col-md-6 mb-1">
                                                    <textarea name="remarks" id="remarks" cols="30" rows="5" class="form-control border-custom"><?= $detail_leave['remarks']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="row justify-content-between">
                                                <div class="col-12 col-md-6 mb-1"></div>
                                                <div class="col-12 col-md-6 mb-1 d-flex justify-content-between">
                                                    <button class="button-4 bg-danger text-white" onclick="reject_leave('<?= $detail_leave['leave_id'] ?>')">Reject</button>
                                                    <?php if (in_array($this->session->userdata('user_id'), [1, 979, 78])) { ?>
                                                        <button class="button-4 bg-primary text-white" onclick="update_leave_hr('<?= $detail_leave['leave_id'] ?>')">Update</button>
                                                    <?php } ?>
                                                    <button class="button-4 bg-success text-white" onclick="approve_leave('<?= $detail_leave['leave_id'] ?>')">Approved</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Footer -->
    <div class="container-fluid footer-page mt-4 py-5">

    </div>
</main>