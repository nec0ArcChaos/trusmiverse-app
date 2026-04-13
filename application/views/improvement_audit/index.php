<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <!-- <p class="text-secondary">Perintah Kerja di Hari Libur</p> -->
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
                            <i class="bi bi-person-workspace h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List <?= $pageTitle ?></h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">

                            <div style="display: flex;justify-content: space-between;">
                                <div>
                                    <button type="button" class="btn btn-primary" onclick="add_improvement()"><i class="bi bi-person-workspace"></i>
                                        Add Improvement Audit</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dt_ia" class="table table-sm table-striped dataTable no-footer" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-nowrap th-goals">ID Improvement</th>
                                    <th class="text-nowrap small text-center">ID Plan</th>
                                    <th class="text-nowrap small text-center">Tanggal</th>
                                    <th class="text-nowrap small text-center">Pemeriksaan</th>
                                    <th class="text-nowrap small text-center">Tindak Lanjut</th>
                                    <th class="text-nowrap small text-center">Improvement</th>
                                    <th class="text-nowrap small text-center">Attach<br>ment</th>
                                    <th class="text-nowrap small text-center">Created at</th>
                                    <th class="text-nowrap small text-center">Created by</th>
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

<!-- Modal Add -->
<div class="modal fade" id="modal_add_improvement" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form_improvement" enctype="multipart/form-data">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-blockquote-left h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                        <p class="text-secondary small">Add Improvement Audit</p>
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
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-bounding-box"></i></span>
                                        <div class="form-floating">
                                            <select name="plan" id="plan" class="form-control" onchange="get_plan()">
                                                <option value="#" selected disabled>-Pilih Plan-</option>
                                                <?php foreach ($plan as $p) { ?>
                                                    <option value="<?= $p->id_plan; ?>"><?= $p->id_plan; ?> | <?= strip_tags($p->object) ?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Plan
                                                <i class="text-danger">*</i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-columns"></i></span>
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0" name="plan_periode" id="plan_periode" placeholder="Periode" readonly>
                                            <label>Periode
                                                <!-- <i class="text-danger">*</i> -->
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-building-check"></i></span>
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0" name="company" id="company" placeholder="Company" readonly>
                                            <label>Company</label>
                                            <input type="hidden" id="company_id" name="company_id">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-building-check"></i></span>
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0" name="department" id="department" placeholder="Department" readonly>
                                            <label>Department</label>
                                            <input type="hidden" id="department_id" name="department_id">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <label>Tindak Lanjut <i class="text-danger">*</i></label>
                                    <div class="input-group">
                                            <textarea class="form-control input_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" name="tindak_lanjut" id="tindak_lanjut" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <label>Improvement <i class="text-danger">*</i></label>
                                    <div class="input-group">
                                        <textarea class="form-control input_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" name="improvement" id="improvement" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-folder"></i></span>
                                                <div class="form-floating">
                                                    <input type="file" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" id="attachment" class="form-control lampiran" name="attachment">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tempat_lampiran">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-md btn-outline-theme" id="btn_save" onclick="save_improvement()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->