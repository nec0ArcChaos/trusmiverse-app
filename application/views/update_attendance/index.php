<main class="main mainheight">
    <div class="m-3">
        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
                <div class="card border-0">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-auto">
                                <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-theme rounded"></i>
                            </div>
                            <div class="col-auto">
                                <h6 class="fw-medium">Attendance</h6>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-sm-12 col-lg-3 mb-2 mb-sm-0">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-building"></i></span>
                                        <div class="form-floating">
                                            <select name="company" id="company" class="form-control border-start-0">
                                                <option value="0" selected>Pilih Companies</option>
                                                <?php foreach ($get_company as $cmp) : ?>
                                                    <option value="<?php echo $cmp->company_id ?>"><?php echo $cmp->company ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <label>Company</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-3 mb-2 mb-sm-0">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-rolodex"></i></span>
                                        <div class="form-floating">
                                            <select name="department" id="department" class="form-control border-start-0">
                                                <option value="0" selected>Pilih Departments</option>
                                            </select>
                                            <label>Department</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-3 mb-2 mb-sm-0">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill"></i></span>
                                        <div class="form-floating">
                                            <select name="employee" id="employee" class="form-control border-start-0">
                                                <option value="0" selected>Pilih Employees</option>
                                            </select>
                                            <label>Employee</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12 mb-2 mb-sm-0 d-flex align-items-center">
                                <div class="form-group mb-3 position-relative check-valid flex-grow-1 me-2">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar3"></i></span>
                                        <div class="form-floating bg-white">
                                            <input type="date" class="form-control" id="date" value="<?= date('Y-m-d') ?>" style="cursor: pointer;">
                                            <label>Date</label>
                                        </div>
                                    </div>
                                </div>
                                <span class="btn btn-primary" id="btn_filter" style="width: auto; min-width: 80px;" data-toggle="tooltip" data-placement="top" title="Filter Employees" onclick="filter_attendance()">
                                    Filter
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-end">
                            <div class="col-sm-12 col-md-2">
                                <button class="btn btn-primary d-none" style="width: 100%;" id="btnAddAbsen" title="add absensi" data-bs-toggle="modal" data-bs-target="#modalForm">
                                    Add New
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive p-4">
                            <table id="dt_attendance" class="table table-sm table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th nowrap>Action</th>
                                        <th nowrap>In Time</th>
                                        <th nowrap>Out Time</th>
                                        <th nowrap>Total Work</th>
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


<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-plus h5 avatar avatar-40 bg-light-red text-red rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalFormLabel">Form Absen</h6>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form id="formAbsen">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="date">Attendance Date</label>
                                <input type="hidden" name="time_attendance_id" id="time_attendance_id">
                                <input type="hidden" name="employee_id" id="employee_id">
                                <input type="hidden" name="type" id="type">
                                <input class="form-control" placeholder="Attendance Date" id="attendance_date_e" name="attendance_date_e" type="date">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="clock_in">Office In Time</label>
                                <input class="form-control timepicker" placeholder="Office In Time" name="clock_in" id="clock_in" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="clock_out">Office Out Time</label>
                                <input class="form-control timepicker" placeholder="Office Out Time" name="clock_out" id="clock_out" type="text">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Kembali</button>
                <button type="button" class="btn btn-md btn-success" id="btn_save_absen" onclick="prosesAbsen()">Simpan</button>
            </div>
        </div>
    </div>
</div>