<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
            </div>
            <div class="col col-sm-auto">
                <div class="input-group input-group-md reportrange">
                    <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;">
                    <input type="hidden" name="startdate" value="" id="start" />
                    <input type="hidden" name="enddate" value="" id="end" />
                    <span class="input-group-text text-secondary bg-none" id="btn_filter"><i class="bi bi-calendar-event"></i></span>
                </div>
            </div>
            <div class="col-auto ps-0">

            </div>
        </div>
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle; ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-card-list h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">Resume Attendance Trusmi Group</h6>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dt_dash_attendance_all" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Company</th>
                                    <th>Total Present</th>
                                    <th>Total Employee</th>
                                    <th>% Present</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
            <div class="card border-0 mt-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-card-list h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">Resume Attendance Department</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dt_dash_attendance_dept" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Department</th>
                                    <th>Company</th>
                                    <th>Total Present</th>
                                    <th>Total Employee</th>
                                    <th>% Present</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>
</main>
<!-- modal Detail Attendance -->
<div class="modal fade" id="modal_detail" aria-labelledby="modal_detailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_add_pembelajar">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_detailLabel">Detail Attendance</h6>
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
                    <div class="table-responsive">
                        <table id="dt_detail_company" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>Tanggal Absen</th>
                                    <th>Hari</th>
                                    <th>Employee</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Clock In</th>
                                    <th>Shift In</th>
                                    <th>Clock Out</th>
                                    <th>Shift Out</th>
                                    <th>Break Out</th>
                                    <th>Break In</th>
                                    <th>Total Break</th>
                                    <th>Late</th>
                                    <th>Total Work</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal Detail Attendance -->


<!-- modal Detail Attendance -->
<div class="modal fade" id="modal_detail_dept" aria-labelledby="modal_detail_deptLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_add_pembelajar">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_detail_deptLabel">Detail Attendance</h6>
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
                    <div class="table-responsive">
                        <table id="dt_detail_dept" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>Tanggal Absen</th>
                                    <th>Hari</th>
                                    <th>Employee</th>
                                    <th>Designation</th>
                                    <th>Clock In</th>
                                    <th>Clock Out</th>
                                    <th>Late</th>
                                    <th>Total Work</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal Detail Attendance -->