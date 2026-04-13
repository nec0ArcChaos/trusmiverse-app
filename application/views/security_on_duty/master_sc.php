<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle; ?></li>
                </ol>
            </nav>
        </div>
    </div>


    <div class="m-3 item-center">

        <!-- <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">

                </div>

                <div class="card-body">
                    
                </div>
            </div>
        </div> -->

        <div class="row mb-3">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <label class="form-label-custom required small" for="project">Project</label>
                <div class="input-group border-custom">
                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                    <select name="project" id="project" class="form-control border-custom">
                        <option data-placeholder="true" value="#">- Pilih Project -</option>
                        <?php foreach ($projects as $p) : ?>
                            <option value="<?= $p->id_project ?>"><?= $p->project ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <label class="form-label-custom required small" for="shift">Shift</label>
                <div class="input-group border-custom">
                    <span class="input-group-text"><i class="bi bi-clock"></i></span>
                    <select name="shift" id="shift" class="form-control border-custom">
                        <option data-placeholder="true" value="#">- Pilih Shift -</option>
                        <?php foreach ($shifts as $s) : ?>
                            <option value="<?= $s->id_shift ?>"><?= $s->shift ?> (<?= $s->time_start ?> - <?= $s->time_end ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <button class="btn btn-sm btn-primary" onclick="add_site()">Add Site</button>
            </div>
        </div>

    </div>
</main>


<!-- Modal Add -->
<div class="modal fade" id="modal_add_request" aria-labelledby="modal_add_request_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_add_request">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_add_request_label">Form</h6>
                        <p class="text-secondary small">Overtime Request For </p>
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
                    <div class="col-12 col-lg-12 col-xl-12 mb-4">
                        <h6 class="title">Detail Request</h6>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-event-fill"></i></span>
                                        <div class="form-floating">
                                            <input type="text" placeholder="Date" name="request_date" id="request_date" value="<?= date('Y-m-d') ?>" required class="form-control border-start-0">
                                            <label>Date</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg clockpicker">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-hourglass-top"></i></span>
                                        <div class="form-floating">
                                            <input type="text" name="in_time" id="in_time" class="form-control border-start-0" required placeholder="--:--">
                                            <label>In Time</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg clockpicker">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-hourglass-bottom"></i></span>
                                        <div class="form-floating">
                                            <input type="text" name="out_time" id="out_time" class="form-control border-start-0" required placeholder="--:--">
                                            <label>Out Time</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <textarea name="reason" id="reason" class="form-control border-start-0" cols="30" rows="5" style="min-height: 80px;" required></textarea>
                                            <label>Reason</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-md btn-primary" id="btn_save" onclick="save()">Save Request <i class="bi bi-floppy"></i></button>
                    <button type="button" style="display:none" class="btn btn-md btn-success" id="btn_update" onclick="update_request()">Update Request <i class="bi bi-floppy"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->

<!-- Modal Request List -->
<div class="modal fade" id="modal_list_request" aria-labelledby="modal_list_request_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_list_request">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_list_request_label">List</h6>
                        <p class="text-secondary small">Overtime Request</p>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="dropdown d-inline-block">
                            <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">

                    <div class="row mt-3">
                        <div class="col col-sm-auto">
                            <div class="input-group input-group-md reportrange">
                                <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;">
                                <input type="hidden" name="start" value="" id="start_list" />
                                <input type="hidden" name="end" value="" id="end_list" />
                                <a href="javascript:void(0)" class="input-group-text text-secondary bg-none" onclick="dt_overtime_request_list(1)"><i class="bi bi-search"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" style="padding: 10px;">
                                <table id="dt_overtime_request_list" class="table table-sm table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Overtime Requests</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Request List -->