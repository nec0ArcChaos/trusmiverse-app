<main class="main mainheight">
    <div class="container-fluid">
        <div class="row align-items-center page-title">
            <div class="col-8 col-md">
                <h5 class="mb-0">Manage Leave</h5>
            </div>
        </div>
        <div class="row breadcrumb-theme align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage Leave</li>
            </ol>
        </div>
    </div>

    <div class="m-3">
        <div class="row">

            <div class="col-12 mb-2">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col">
                                <h6 class="title">Available Leave</h6>
                            </div>
                            <div class="col-auto align-items-center align-self-center">
                                <button class="btn btn-outline-info text-dinamis" id="toggle_available_leave" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_available_leave" aria-expanded="false" aria-controls="collapse_available_leave" style="font-size: 8pt;">View More</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-12">
                                <ul class="list-group list-group-flush bg-none" id="available_leave">

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col">
                                <h6 class="title">Applied Leave</h6>
                            </div>
                            <div class="col-auto align-items-center align-self-center">
                                <!-- <button class="btn btn-outline-info text-dinamis" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_leave" aria-expanded="false" aria-controls="collapse_filter_leave"> Filter</button> -->
                                <button class="btn btn-outline-primary text-dinamis" type="button" data-bs-toggle="modal" data-bs-target="#modal_add_leave"> Add Leave</button>
                                <?php if ($txz == true || $spv == true) { ?>
                                    <!-- <button class="btn btn-outline-warning text-dinamis" type="button" data-bs-toggle="modal" data-bs-target="#modal_pending_leave" onclick="get_pending_leave()"> Pending</button> -->
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col align-items-center align-self-center">
                                <div class="row mb-2">
                                    <div class="col-6 col-md-4 mb-1 mt-1 custom-style-sm">
                                        <div class="input-group input-group-md border rounded reportrange">
                                            <span class="input-group-text text-theme"><i class="bi bi-calendar"></i></span>
                                            <input type="text" class="form-control range bg-none" style="cursor: pointer;" id="titlecalendar">
                                            <input type="hidden" name="start" value="<?= date("Y-m-01"); ?>" id="start" />
                                            <input type="hidden" name="end" value="<?= date("Y-m-t"); ?>" id="end" />
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4 mb-1 mt-1 custom-style-sm <?= $select_class; ?>">
                                        <select <?= $select_stat; ?> name="company_id" id="company_id" class="wide" style="width:100%; font-size: 8pt;display:none;">
                                            <option value="all">All Companies</option>
                                            <?php foreach ($company as $com) { ?>
                                                <option value="<?= $com->company_id; ?>" <?= $user['company_id'] == $com->company_id ? 'selected' : ''; ?>><?= $com->company_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-4 mb-1 mt-1 custom-style-sm <?= $select_class; ?>">
                                        <select <?= $select_stat; ?> name="department_id" id="department_id" class="wide" style="width:100%; font-size: 8pt;display:none;">
                                            <?php if ($this->session->userdata('user_role_id') == 1) { ?>
                                                <option value="all">All Department</option>
                                            <?php } else { ?>
                                                <option value="<?= $user['department_id']; ?>" selected><?= $user['department_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-4 mb-1 mt-1 custom-style-sm <?= $select_class; ?>">
                                        <select <?= $select_stat; ?> name="employee_id" id="employee_id" class="wide" style="width:100%; font-size: 8pt;display:none;">
                                            <?php if ($this->session->userdata('user_role_id') == 1) { ?>
                                                <option value="all">All Employee</option>
                                            <?php } else { ?>
                                                <option value="<?= $user['user_id']; ?>" selected><?= $user['employee_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-4 mb-1 mt-1 custom-style-sm">
                                        <select name="status_leave" id="status_leave" class="wide" style="width:100%; font-size: 8pt;display:none;">
                                            <option value="all">All Status</option>
                                            <option value="1" selected>Pending</option>
                                            <option value="2">Approved</option>
                                            <option value="3">Reject</option>
                                        </select>
                                    </div>
                                    <!-- <div class="col-6 col-md-4 mb-1 mt-1 custom-style-sm">
                                        <select name="year" id="year-leave" class="wide" style="width:100%; font-size: 8pt;display:none;">
                                            <?php for ($i = date("m") == 12 ? date('Y', strtotime('+1 year')) : date("Y") + 1; $i >= 2018; $i--) { ?>
                                                <option value="<?= $i ?>" <?= date('Y') ? (date('Y') == $i ? 'selected' : '') : '' ?>><?= $i ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-4 mb-1 mt-1 custom-style-sm">
                                        <select name="month" id="month-leave" class="wide" style="width:100%; font-size: 8pt;display:none;">
                                            <option value="01" <?= date("m") == '01' ? 'selected' : ''; ?>>Januari</option>
                                            <option value="02" <?= date("m") == '02' ? 'selected' : ''; ?>>Februari</option>
                                            <option value="03" <?= date("m") == '03' ? 'selected' : ''; ?>>Maret</option>
                                            <option value="04" <?= date("m") == '04' ? 'selected' : ''; ?>>April</option>
                                            <option value="05" <?= date("m") == '05' ? 'selected' : ''; ?>>Mei</option>
                                            <option value="06" <?= date("m") == '06' ? 'selected' : ''; ?>>Juni</option>
                                            <option value="07" <?= date("m") == '07' ? 'selected' : ''; ?>>Juli</option>
                                            <option value="08" <?= date("m") == '08' ? 'selected' : ''; ?>>Agustus</option>
                                            <option value="09" <?= date("m") == '09' ? 'selected' : ''; ?>>September</option>
                                            <option value="10" <?= date("m") == '10' ? 'selected' : ''; ?>>Oktober</option>
                                            <option value="11" <?= date("m") == '11' ? 'selected' : ''; ?>>November</option>
                                            <option value="12" <?= date("m") == '12' ? 'selected' : ''; ?>>Desember</option>
                                        </select>
                                    </div> -->
                                </div>
                                <div class="col-12 text-end align-self-center">
                                    <button class="button-4" onclick="get_applied_leave()" style="font-size: 8pt;">Search</button>
                                </div>
                            </div>
                            <div class="collapse" id="collapse_filter_leave">
                                <div class="row mb-3">
                                    <div class="col">
                                        <h6 class="title">Filter Leave</h6>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dt_applied_leave" class="table table-striped text-nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <!-- <th></th> -->
                                        <th>Created At</th>
                                        <th>Leave Type</th>
                                        <th>Company</th>
                                        <th>Department</th>
                                        <th>Employee Name</th>
                                        <th>Status</th>
                                        <th>Day Off</th>
                                        <th>Request Leave Date</th>
                                        <th>Request Leave Hour</th>
                                        <th>Total</th>
                                        <th>Reason</th>
                                        <th>Kota</th>
                                        <th>Approve At</th>
                                        <th>Approve By</th>
                                        <th>Verified At</th>
                                        <th>Verified By</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row breadcrumb-theme mb-2 d-block d-md-none">
            <br>
        </div>
    </div>



    <!-- Footer -->
    <div class="container-fluid footer-page mt-4 py-5">

    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modal_add_leave" tabindex="-1" aria-labelledby="modal_add_leaveLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card">
            <div class="modal-header card-header">
                <div class="col-12">
                    <div class="row">
                        <div class="col">
                            <h6 class="modal-title title">Add Leave</h6>
                        </div>
                        <div class="col-auto d-flex align-items-center align-self-center">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body card-body">
                <form action="" id="form-add-leave" class="formName" enctype="multipart/form-data">
                    <div class="row align-items-center m-1">
                        <div class="mb-3 col-12">
                            <label for="leave_type" class="form-label-custom required">Leave Type</label>
                            <select id="leave_type" name="leave_type" class="wide mb-3 leave_type custom-style">
                            </select>
                        </div>
                        <div class="mb-3 col-12 col-md-6" id="div_kota">
                            <label for="kota" class="form-label-custom required">Kota</label>
                            <select id="kota" name="kota" class="wide mb-3 kota custom-style">

                            </select>
                        </div>
                        <div class="mb-3 col-6 col-md-6 col-lg-6" id="div_tgl_ph">
                            <label for="tgl_ph" class="form-label-custom required">Pilih Tgl Libur</label>
                            <input type="text" class="form-control border-custom tgl tanggal" name="tgl_ph" id="tgl_ph" aria-describedby="tgl_ph" placeholder="yyyy-mm-dd">
                            <span class="small" style="font-size: 7pt;">*yang seharusnya anda libur tapi masuk</span>
                        </div>
                        <div class="mb-3 col-6 col-md-6 col-lg-6">
                            <label for="start_date" class="form-label-custom required" id="label_start_date">Start Date</label>
                            <input type="text" class="form-control border-custom tgl tanggal" name="start_date" id="start_date" aria-describedby="start_date" placeholder="yyyy-mm-dd" autocomplete="off">
                        </div>
                        <div class="mb-3 col-6 col-md-6 col-lg-6" id="div_tgl_ph_end_date">
                            <label for="end_date" class="form-label-custom required">End Date</label>
                            <input type="text" class="form-control border-custom tgl tanggal" name="end_date" id="end_date" aria-describedby="end_date" placeholder="yyyy-mm-dd" autocomplete="off">
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label for="attachment" class="form-label-custom required">Attachment</label>
                            <input type="file" class="form-control border-custom" name="attachment" id="attachment" aria-describedby="attachment" placeholder="">
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label for="leave_reason" class="form-label-custom required">Reason</label>
                            <textarea name="leave_reason" class="form-control border-custom" id="leave_reason" cols="30" rows="5"></textarea>
                        </div>
                        <div class="mb-3 col-12 text-end">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer card-footer">
                <button type="button" class="btn btn-outline-theme m-1" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-theme m-1" onclick="add_leave()">Submit Request</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal_pending_leave" tabindex="-1" aria-labelledby="modal_pending_leaveLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card">
            <div class="modal-header card-header">
                <div class="col-12">
                    <div class="row">
                        <div class="col">
                            <h6 class="modal-title title">Pending Leave</h6>
                        </div>
                        <div class="col-auto d-flex align-items-center align-self-center">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body card-body">
                <table id="dt_pending_leave" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Applied On</th>
                            <th>Employee Name</th>
                            <th>Department</th>
                            <th>Description</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th>Day Off</th>
                            <th>Request Duration</th>
                            <th>Total</th>
                            <th>Approve At</th>
                            <th>Approve By</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer card-footer">
                <button type="button" class="btn btn-outline-theme m-1" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>