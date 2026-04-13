<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Problem | Thinking | Solution</p>
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
                            <i class="bi bi-lightbulb h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Problem Solving</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                            <button type="button" class="btn btn-md btn-outline-theme" onclick="add_problem()"><i class="bi bi-node-plus-fill"></i> New Problem</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="" style="padding: 10px;">
                        <table id="dt_list_problem" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id PS</th>
                                    <th>Problem</th>
                                    <th>Category</th>
                                    <th>Priority</th>
                                    <th>Deadline</th>
                                    <th>Factor</th>
                                    <th>PIC</th>
                                    <th>Status</th>
                                    <th>Resume</th>
                                    <th>Created By</th>
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
<div class="modal fade" id="modal_add_problem" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form_problem">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-lightbulb-fill h5 avatar avatar-40 bg-light-blue text-cyan rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                        <p class="text-secondary small">Add Problem</p>
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
                        <h6 class="title">Detail <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <label>Problem <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                    <textarea name="problem" id="problem" cols="30" rows="10" class="form-control border-start-0"></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-list"></i></span>
                                        <div class="form-floating">
                                            <select name="category" id="category" class="form-control">
                                                <option value="#">-Choose Category-</option>
                                                <?php foreach ($category as $ct) { ?>
                                                    <option value="<?= $ct->id; ?>"><?= $ct->category; ?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Category <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-bell"></i></span>
                                        <div class="form-floating">
                                            <select name="priority" id="priority" class="form-control">
                                                <option value="#">-Choose Priority-</option>
                                                <?php foreach ($priority as $pt) { ?>
                                                    <option value="<?= $pt->id; ?>"><?= $pt->priority; ?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Priority <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-event"></i></span>
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0 bg-white" name="deadline" id="deadline" readonly>
                                            <label>Deadline <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-bounding-box-circles"></i></span>
                                        <div class="form-floating">
                                            <select name="factor" id="factor" class="form-control">
                                                <option value="#">-Choose Factor-</option>
                                                <option value="Internal">Internal</option>
                                                <option value="Eksternal">Eksternal</option>
                                            </select>
                                            <label>Factor <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill-check"></i></span>
                                        <div class="form-floating">
                                            <select name="pic" id="pic" class="form-control">
                                                <option value="#">-Choose PIC-</option>
                                                <?php foreach ($pic as $p) { ?>
                                                    <option value="<?= $p->user_id; ?>"><?= $p->employee_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <label>PIC <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h6 class="title"><input type="checkbox" name="addition" id="addition"> <label for="addition">Membahas Pekerjaan ?</label></h6>
                        <div class="row div_addition" style="display: none;">
                            <!-- addnew -->
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-1 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-list"></i></span>
                                        <div class="form-floating">
                                            <select name="id_project" id="project" class="form-control">
                                                <option value="#" disabled>-- Pilih Divisi --</option>
                                                <?php foreach ($project as $row) : ?>
                                                    <option value="<?= $row->id_project ?>"><?= $row->project ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>Divisi <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-6 mb-2">
                                <div class="form-group mb-1 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-list"></i></span>
                                        <div class="form-floating">
                                            <select name="id_pekerjaan" id="pekerjaan" class="form-control">
                                                <option value="#" selected disabled>-- SO --</option>

                                            </select>
                                            <label>SO <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-6 mb-2">
                                <div class="form-group mb-1 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-list"></i></span>
                                        <div class="form-floating">
                                            <select name="id_sub_pekerjaan" id="sub_pekerjaan" class="form-control">
                                                <option value="#" selected disabled>-- SI --</option>
                                            </select>
                                            <label>SI <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-1 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-list"></i></span>
                                        <div class="form-floating">
                                            <select name="id_detail_pekerjaan[]" id="detail_pekerjaan" class="form-control" multiple>

                                            </select>
                                            <label>Tasklist <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-md btn-outline-theme" id="btn_save" onclick="save_problem()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->

<!-- Modal Proses Gemba -->
<div class="modal fade" id="modal_proses_resume" tabindex="-1" aria-labelledby="modalListProsesLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-lightbulb-fill h5 avatar avatar-40 bg-light-orange text-orange rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalListProsesLabel">Proses</h6>
                    <p class="text-secondary small">Problem Solving</p>
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
                    <h6 class="title">Detail <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                    <div class="row align-items-center mb-3">
                        <div class="col-12 col-md-4 col-lg-4 col-xl-2 col-xxl-2 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-card-list h5 avatar avatar-40 bg-info text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_category">...</h6>
                                    <p class="text-secondary small">Category</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4 col-xl-2 col-xxl-2 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-bell h5 avatar avatar-40 bg-warning text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_priority">...</h6>
                                    <p class="text-secondary small">Priority</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4 col-xl-3 col-xxl-3 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-calendar-event h5 avatar avatar-40 bg-danger text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_deadline">...</h6>
                                    <p class="text-secondary small">Deadline</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4 col-xl-2 col-xxl-2 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-bounding-box-circles h5 avatar avatar-40 bg-warning text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_factor">...</h6>
                                    <p class="text-secondary small">Factor</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 col-xl-3 col-xxl-3 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-person-fill-check h5 avatar avatar-40 bg-primary text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_pic">...</h6>
                                    <p class="text-secondary small">PIC</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <form id="form_proses_resume">
                            <input type="hidden" id="id_ps" name="id_ps">
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-check-square"></i></span>
                                        <div class="form-floating">
                                            <select name="status_akhir" id="status_akhir" class="form-control">
                                                <option value="#">-- Choose Status --</option>
                                                <?php foreach ($status as $sts) : ?>
                                                    <option value="<?= $sts->id; ?>"><?= $sts->status; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>Status <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <label>Resume <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                    <textarea name="resume" id="resume" cols="30" rows="10" class="form-control border-start-0"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-md btn-outline-theme ms-2" onclick="save_proses_resume()" id="btn_save_proses_resume">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Proses Resume -->