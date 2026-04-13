<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
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
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Office Shift</h6>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-end mb-3">
                        <div class="col-12 col-md-2">
                            <button class="btn btn-primary" style="width: 100%;" id="btnAddShift" title="add Shift" data-bs-toggle="modal" data-bs-target="#modalAddShift">
                                Add New
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="table_shift" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>Option</th>
                                    <th>Company</th>
                                    <th>Day</th>
                                    <th>Monday</th>
                                    <th>Tuesday</th>
                                    <th>Wednesday</th>
                                    <th>Thursday</th>
                                    <th>Friday</th>
                                    <th>Saturday</th>
                                    <th>Sunday</th>
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

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Shift</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formUpdateShift">
                <div class="modal-body">
                    <div class="container-fluid py-3">
                        <input type="hidden" id="office_shift_id" name="office_shift_id">
                        <div class="row mb-3">
                            <label for="aj_company" class="col-md-2 col-form-label">Company</label>
                            <div class="col-md-4">
                                <select class="form-select" name="company_id" id="aj_company">
                                    <?php foreach ($companies as $company) : ?>
                                        <option value="<?= $company->company_id; ?>"><?= $company->company; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-2 col-form-label">Shift Name</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Shift Name" name="shift_name" id="name">
                            </div>
                        </div>

                        <!-- Senin -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label">Monday</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-1" placeholder="In Time" name="monday_in_time" readonly>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-1" placeholder="Out Time" name="monday_out_time" readonly>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-primary w-100 clear-time" data-clear-id="1">Clear</button>
                            </div>
                        </div>
                        <!-- Selasa -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label">Tuesday</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-2" placeholder="In Time" name="tuesday_in_time" readonly>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-2" placeholder="Out Time" name="tuesday_out_time" readonly>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-primary w-100 clear-time" data-clear-id="2">Clear</button>
                            </div>
                        </div>
                        <!-- Rabu -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label">Wednesday</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-3" placeholder="In Time" name="wednesday_in_time" readonly>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-3" placeholder="Out Time" name="wednesday_out_time" readonly>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-primary w-100 clear-time" data-clear-id="3">Clear</button>
                            </div>
                        </div>
                        <!-- Kamis -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label">Thursday</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-4" placeholder="In Time" name="thursday_in_time" readonly>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-4" placeholder="Out Time" name="thursday_out_time" readonly>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-primary w-100 clear-time" data-clear-id="4">Clear</button>
                            </div>
                        </div>
                        <!-- Jumat -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label">Friday</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-5" placeholder="In Time" name="friday_in_time" readonly>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-5" placeholder="Out Time" name="friday_out_time" readonly>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-primary w-100 clear-time" data-clear-id="5">Clear</button>
                            </div>
                        </div>
                        <!-- Sabtu -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label">Saturday</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-6" placeholder="In Time" name="saturday_in_time" readonly>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-6" placeholder="Out Time" name="saturday_out_time" readonly>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-primary w-100 clear-time" data-clear-id="6">Clear</button>
                            </div>
                        </div>
                        <!-- Minggu -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label">Sunday</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-7" placeholder="In Time" name="sunday_in_time" readonly>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-7" placeholder="Out Time" name="sunday_out_time" readonly>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-primary w-100 clear-time" data-clear-id="7">Clear</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="gap: 14px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="btn-update" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Add Shift -->
<div class="modal fade" id="modalAddShift" tabindex="-1" aria-labelledby="modalAddShiftLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddShiftLabel">Add New Shift</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAddShift">
                <div class="modal-body">
                    <div class="container-fluid py-3">
                        <input type="hidden" id="office_shift_id" name="office_shift_id">
                        <div class="row mb-3">
                            <label for="aj_company" class="col-md-2 col-form-label">Company</label>
                            <div class="col-md-4">
                                <select class="form-select" name="company_id" id="comp_add_shift">
                                    <?php foreach ($companies as $company) : ?>
                                        <option value="<?= $company->company_id; ?>"><?= $company->company; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-2 col-form-label">Shift Name</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Shift Name" name="shift_name" id="add_shift_name">
                            </div>
                        </div>

                        <!-- Senin -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label">Monday</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-1" placeholder="In Time" name="monday_in_time" readonly>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-1" placeholder="Out Time" name="monday_out_time" readonly>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-primary w-100 clear-time" data-clear-id="1">Clear</button>
                            </div>
                        </div>
                        <!-- Selasa -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label">Tuesday</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-2" placeholder="In Time" name="tuesday_in_time" readonly>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-2" placeholder="Out Time" name="tuesday_out_time" readonly>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-primary w-100 clear-time" data-clear-id="2">Clear</button>
                            </div>
                        </div>
                        <!-- Rabu -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label">Wednesday</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-3" placeholder="In Time" name="wednesday_in_time" readonly>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-3" placeholder="Out Time" name="wednesday_out_time" readonly>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-primary w-100 clear-time" data-clear-id="3">Clear</button>
                            </div>
                        </div>
                        <!-- Kamis -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label">Thursday</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-4" placeholder="In Time" name="thursday_in_time" readonly>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-4" placeholder="Out Time" name="thursday_out_time" readonly>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-primary w-100 clear-time" data-clear-id="4">Clear</button>
                            </div>
                        </div>
                        <!-- Jumat -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label">Friday</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-5" placeholder="In Time" name="friday_in_time" readonly>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-5" placeholder="Out Time" name="friday_out_time" readonly>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-primary w-100 clear-time" data-clear-id="5">Clear</button>
                            </div>
                        </div>
                        <!-- Sabtu -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label">Saturday</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-6" placeholder="In Time" name="saturday_in_time" readonly>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-6" placeholder="Out Time" name="saturday_out_time" readonly>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-primary w-100 clear-time" data-clear-id="6">Clear</button>
                            </div>
                        </div>
                        <!-- Minggu -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label">Sunday</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-7" placeholder="In Time" name="sunday_in_time" readonly>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control timepicker clear-7" placeholder="Out Time" name="sunday_out_time" readonly>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-primary w-100 clear-time" data-clear-id="7">Clear</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="gap: 14px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="btn-update" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>