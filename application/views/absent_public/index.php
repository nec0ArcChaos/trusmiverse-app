<main class="main mainheight">

    <div class="m-3">

        <div class="row">

            <div class="col-lg-5 col-xl-5 col-xxl-5 col-sm-12 col-md-12">
                <div class="card border-0">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-auto">
                                <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-theme rounded"></i>
                            </div>
                            <div class="col-auto">
                                <h6 class="fw-medium">Department</h6>
                            </div>
                            <div class="col-5">
                            </div>
                            <div class="col-auto float-right">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-filter"></i></span>
                                        <div class="form-floating">
                                            <select class="form-select border-0" id="status" onchange="select_status()">
                                                <option value="" selected="">All</option>
                                                <option value="1">Allow</option>
                                                <option value="0">Deny</option>
                                            </select>
                                            <label for="filter_by">Status</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="padding: 10px;">
                            <table id="dt_list_department" class="table table-sm table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Department</th>
                                        <th>Company</th>
                                        <th>Public</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-7 col-xl-7 col-xxl-7 col-sm-12 col-md-12">
                <div class="card border-0">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-auto">
                                <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-theme rounded"></i>
                            </div>
                            <div class="col-auto align-self-center">
                                <h6 class="fw-medium">Employees</h6>
                            </div>
                            <div class="col-7 align-self-center">
                            </div>
                            <div class="col-auto float-right">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-filter"></i></span>
                                        <div class="form-floating">
                                            <select class="form-select border-0" id="status_employee" onchange="select_status_employee()">
                                                <option value="" selected="">All</option>
                                                <option value="1">Allow</option>
                                                <option value="0">Deny</option>
                                            </select>
                                            <label for="filter_by">Status</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="padding: 10px;">
                            <table id="dt_list_employees" class="table table-sm table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Designation</th>
                                        <th>Department</th>
                                        <th>Company</th>
                                        <th>Public</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card border-0">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-building h5 avatar avatar-40 bg-light-theme rounded"></i>
                            </div>
                            <div class="col-auto">
                                <h6 class="fw-medium">Company</h6>
                            </div>
                            <div class="col text-end">
                                <button type="button" class="btn btn-primary btn-sm" onclick="bulk_update_company(1)">
                                    <i class="bi bi-check-circle"></i> Set Allow
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="bulk_update_company(0)">
                                    <i class="bi bi-x-circle"></i> Set Deny
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="padding: 10px;">
                            <table id="dt_list_companies" class="table table-sm table-hover table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width: 5px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="check_all_company">
                                            </div>
                                        </th>
                                        <th>Company Name</th>
                                        <th>Total Department</th>
                                        <th>Total Karyawan</th>
                                        <th>Public</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-geo-alt h5 avatar avatar-40 bg-light-theme rounded"></i>
                            </div>
                            <div class="col-auto">
                                <h6 class="fw-medium">Working Location</h6>
                            </div>
                            <div class="col text-end">
                                <button type="button" class="btn btn-primary btn-sm" onclick="bulk_update_location(1)">
                                    <i class="bi bi-check-circle"></i> Set Allow
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="bulk_update_location(0)">
                                    <i class="bi bi-x-circle"></i> Set Deny
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="padding: 10px;">
                            <table id="dt_list_working_locations" class="table table-sm table-hover table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width: 5px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="check_all_location">
                                            </div>
                                        </th>
                                        <th>Location Name</th>
                                        <th>Total Employees</th>
                                        <th>Current Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</main>