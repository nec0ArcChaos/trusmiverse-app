<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Deskripsi Page</p>
            </div>
            <div class="col col-sm-auto">
                <form method="POST" id="form_filter">
                    <div class="input-group input-group-md reportrange">
                        <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                        <input type="hidden" name="start" value="" id="start" readonly />
                        <input type="hidden" name="end" value="" id="end" readonly />
                        <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
                    </div>
                </form>
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
                            <i class="bi bi-key h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Lock Absen</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                            <!-- IT, Hendra, Fafricony, Viky, Farhan, Andre, Siti Cahyati, Irfannudin, Prima, Palkrisman dan PDCA, HRBP, Nining27, saeroh -->
                            <?php // if (in_array($this->session->userdata('user_id'), array(1, 323, 78, 1139, 68, 321, 2735, 340, 272, 4303, 4138, 3613, 3820, 4770, 2951, 5197, 2378, 2729, 70, 1784, 637, 2117, 778, 979, 3648, 5647))) { ?>
                                <button type="button" class="btn btn-md btn-outline-theme" data-bs-toggle="modal" data-bs-target="#modal_add_lock"><i class="bi bi-plus"></i> Add Lock</button>
                            <?php // } ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_lock_absen" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Employee Name</th>
                                    <th>Lock Type</th>
                                    <th>Lock Reason</th>
                                    <th>Status</th>
                                    <th>Locked Date</th>
                                    <th>Locked By</th>
                                    <th>Unlocked Date</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal Add -->
<div class="modal fade" id="modal_add_lock" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_lock">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                        <p class="text-secondary small">Add Lock Employee</p>
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
                        <h6 class="title">Detail Lock <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                        <div class="row">
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill-up"></i></span>
                                        <div class="form-floating">
                                            <select name="lock_type" id="lock_type" class="form-control">
                                                <option value="#" selected disabled>-- Choose Lock Type --</option>
                                                <option value="video">Video</option>
                                                <option value="other">Other</option>
                                            </select>
                                            <label>*Lock Type</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill-up"></i></span>
                                        <div class="form-floating">
                                            <select name="karyawan" id="karyawan" class="form-control" multiple>
                                                <option data-placeholder="true">-- Choose Employee --</option>
                                                <?php foreach ($karyawan as $row) : ?>
                                                    <option value="<?= $row->user_id ?>"><?= $row->employee_name ?> | <?= $row->company ?> | <?= $row->department ?> | <?= $row->designation ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>*Employee Name</label>
                                            <input type="hidden" id="user" name="user" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <textarea name="alasan" id="alasan" class="form-control border-start-0" cols="30" rows="5" style="min-height: 80px;" required></textarea>
                                            <label>*Reason</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <textarea name="activity" id="activity" class="form-control border-start-0" cols="30" rows="5" style="min-height: 80px;" required></textarea>
                                            <label>*Activity</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-theme" id="btn_save">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->

<!-- Modal Update -->
<div class="modal fade" id="modal_unlock" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_unlock">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                        <p class="text-secondary small">Unlock Employee</p>
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
                        <h6 class="title">Detail Lock <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                        <div class="row">
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill-up"></i></span>
                                        <input type="hidden" id="e_id" name="e_id" class="form-control border-start-0" readonly>
                                        <div class="form-floating">
                                            <input type="text" id="e_karyawan" name="e_karyawan" class="form-control border-start-0" readonly>
                                            <label>*Employee Name</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <textarea name="e_alasan" id="e_alasan" class="form-control border-start-0" cols="30" rows="5" style="min-height: 80px;" readonly></textarea>
                                            <label>*Reason</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <textarea name="e_activity" id="e_activity" class="form-control border-start-0" cols="30" rows="5" style="min-height: 80px;" readonly></textarea>
                                            <label>*Activity</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-theme" onclick="save_unlock()" id="btn_unlock">Unlock</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Update -->