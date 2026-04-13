<main class="main mainheight">

    <div class="container-fluid mb-4">
        <!-- <div class="row align-items-center page-title">
            
        </div> -->
        <!-- <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle; ?></li>
                </ol>
            </nav>
        </div> -->
    </div>

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

                            <div class="col col-md mb-2 mb-sm-0">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <?php $accessable = array(1, 979, 323, 1161, 778, 2378, 7477, 2903, 8446, 118); ?>
                                        <?php if (in_array($this->session->userdata('user_id'), $accessable)) { ?>
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-building"></i></span>
                                            <div class="form-floating">
                                                <select name="company" id="company" class="form-control border-start-0">
                                                    <option value="0" selected>All Companies</option>
                                                    <?php foreach ($get_company as $cmp) : ?>
                                                        <option value="<?php echo $cmp->company_id ?>"><?php echo $cmp->company ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                                <label>Company</label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-md mb-2 mb-sm-0">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <?php if (in_array($this->session->userdata('user_id'), $accessable)) { ?>
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-rolodex"></i></span>
                                            <div class="form-floating">
                                                <select name="department" id="department" class="form-control border-start-0">
                                                    <option value="0" selected>All Departments</option>
                                                </select>
                                                <label>Department</label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-md mb-2 mb-sm-0">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <?php if (in_array($this->session->userdata('user_id'), $accessable)) { ?>
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill"></i></span>
                                            <div class="form-floating">
                                                <select name="employee" id="employee" class="form-control border-start-0">
                                                    <option value="0" selected>All Employees</option>
                                                </select>
                                                <label>Employee</label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md mb-2 mb-sm-0">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar3"></i></span>
                                        <div class="form-floating bg-white">
                                            <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                                            <input type="hidden" name="start" value="" id="start" />
                                            <input type="hidden" name="end" value="" id="end" />
                                            <label>Periode</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-1 col-md mb-2 mb-sm-0">
                                <span class="btn btn-primary" id="btn_filter" style="width: 100%;" data-toggle="tooltip" data-placement="top" title="Tooltip on top" onclick="filter_attendance()">
                                    Filter <i class="bi bi-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="padding: 10px;">
                            <table id="dt_attendance" class="table table-sm table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th nowrap class="text-center" scope="col">#</th>
                                        <th nowrap class="text-center" scope="col">Tanggal Absen</th>
                                        <th nowrap class="text-left" scope="col">Employee</th>
                                        <th nowrap class="text-left" scope="col">Designation</th>
                                        <th nowrap class="text-left" scope="col">Clock In</th>
                                        <th nowrap class="text-left" scope="col">Photo In</th>
                                        <th nowrap class="text-left" scope="col">Clock Out </th>
                                        <th nowrap class="text-left" scope="col">Photo Out </th>
                                        <th nowrap class="text-center" scope="col">Late</th>
                                        <th nowrap class="text-center" scope="col">Total Work</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- PEMBATALAN ABSEN -->
    <?php if (!in_array((int)$this->session->userdata('user_id'), [7477, 8446, 118])): ?>
        <div class="m-3">
            <div class="row">
                <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
                    <div class="card border-0">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-trash h5 avatar avatar-40 bg-light-red rounded"></i>
                                </div>
                                <div class="col-auto">
                                    <h6 class="fw-medium">List Pembatalan Absensi</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="padding: 10px;">
                                <table id="dt_pembatalan_absensi" class="table table-sm table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th nowrap class="text-center" scope="col">Tanggal Absen</th>
                                            <th nowrap class="text-left" scope="col">Employee</th>
                                            <th nowrap class="text-left" scope="col">Designation</th>
                                            <th nowrap class="text-left" scope="col">Clock In</th>
                                            <th nowrap class="text-left" scope="col">Clock Out </th>
                                            <th nowrap class="text-center" scope="col">Late</th>
                                            <th nowrap class="text-center" scope="col">Total Work</th>
                                            <th nowrap class="text-center" scope="col">Tanggal Hapus</th>
                                            <th nowrap class="text-center" scope="col">User Hapus</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    <?php endif ?>
</main>


<div class="modal fade" id="modalConfirm" tabindex="-1" aria-labelledby="modalConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-trash h5 avatar avatar-40 bg-light-red text-red rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalConfirmLabel">Pembatalan Absen</h6>
                    <!-- <p class="text-secondary small">Batalkan Absen </p> -->
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
                <h6 class="title">Hapus Absen ?</h6>
                <div class="row">
                    <div class="col-12 col-lg-12 col-xl-12 mb-4">
                        <h6 id="nama_hapus"></h6>
                        <input type="hidden" id="time_attendance_id">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Kembali</button>
                <button type="button" class="btn btn-md btn-outline-danger" id="btn_hapus_absen" onclick="hapus_absen()">Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>