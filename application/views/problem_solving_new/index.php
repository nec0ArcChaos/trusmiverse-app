<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle ?></h5>
                <p class="text-secondary">Problem | Thinking | Solution</p>
            </div>
            <div class="col col-sm-auto">
                <form method="POST" id="form_filter">
                    <div class="input-group input-group-md reportrange">
                        <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;"
                            id="titlecalendar">
                        <input type="hidden" name="start" value="" id="start" readonly />
                        <input type="hidden" name="end" value="" id="end" readonly />
                        <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i
                                class="bi bi-calendar-event"></i></span>
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
                    <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle ?></li>
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
                            <button type="button" class="btn btn-md btn-outline-success" onclick="list_feedback()"><i
                                    class="bi bi-123"></i> Feedback</button>
                            <button type="button" class="btn btn-md btn-outline-theme" onclick="add_problem()"><i
                                    class="bi bi-node-plus-fill"></i> New Problem</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="" style="padding: 10px;">
                        <table id="dt_list_problem" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No Masalah</th>
                                    <th>Problem</th>
                                    <th>Yang sudah dilakukan</th>
                                    <th>File</th>
                                    <th>Link</th>
                                    <th>Divisi</th>
                                    <th>Category</th>
                                    <th>Factor</th>
                                    <th>Priority</th>
                                    <th>PIC</th>
                                    <th>Deadline</th>
                                    <th>Project</th>
                                    <th>Tindakan</th>
                                    <th>Solution</th>
                                    <th>Delegate/Escalate to</th>
                                    <th>Tasklist</th>
                                    <th>Deadline Tasklist</th>
                                    <th>Status</th>
                                    <th>Repetisi Masalah</th>
                                    <th>Rating Feedback</th>
                                    <th>Feedback</th>
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
            <form id="form_problem" enctype="multipart/form-data">
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
                            <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle"
                                role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="col-12 col-lg-12 col-xl-12 mb-4">
                        <h6 class="title">Detail <span class="text-danger" style="font-size: 9pt;">(*Wajib
                                diisi)</span></h6>
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <label>Problem Hari ini <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                    <textarea name="problem" id="problem" cols="30" rows="10" class="form-control border-start-0"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <label>Yang sudah dilakukan <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                    <textarea name="solving" id="solving" cols="30" rows="10" class="form-control border-start-0"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-folder"></i></span>
                                        <div class="form-floating">
                                            <input type="file"
                                                accept="application/pdf, .pdf, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, image/jpg, image/png, image/jpeg"
                                                id="file_problem" class="form-control lampiran" name="file_problem">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <label>Link </label>
                                    <div class="input-group">
                                        <input type="text" name="link_problem" id="link_problem"
                                            class="form-control" placeholder="https://example.com">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-card-list"></i></span>
                                        <div class="form-floating">
                                            <select name="department_id" id="department_id" class="form-control" onchange="get_pic()">
                                                <option value="#">-Choose Divisi-</option>
                                                <?php foreach ($department as $depa) { ?>
                                                <option value="<?= $depa->department_id ?>">
                                                    <?= $depa->department_name ?> - <?= $depa->company_name ?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Divisi <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-card-list"></i></span>
                                        <div class="form-floating">
                                            <select name="category_new" id="category_new" class="form-control">
                                                <option value="#">-Choose Category-</option>
                                                <?php foreach ($category_new as $ct) { ?>
                                                <option value="<?= $ct->id ?>"><?= $ct->category ?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Category <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-card-list"></i></span>
                                        <div class="form-floating">
                                            <select name="category" id="category" class="form-control">
                                                <option value="#">-Choose Factor/Framework-</option>
                                                <?php foreach ($category as $ct) { ?>
                                                <option value="<?= $ct->id ?>"><?= $ct->category ?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Factor/Framework <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-bell"></i></span>
                                        <div class="form-floating">
                                            <select name="priority" id="priority" class="form-control">
                                                <option value="#">-Choose Priority-</option>
                                                <?php foreach ($priority as $pt) { ?>
                                                <option value="<?= $pt->id ?>"><?= $pt->priority ?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Priority <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-person-fill-check"></i></span>
                                        <div class="form-floating">
                                            <select name="pic" id="pic" class="form-control">
                                                <option value="#">-Choose PIC-</option>
                                            </select>
                                            <label>PIC <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-calendar-event"></i></span>
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0 bg-white"
                                                name="deadline" id="deadline" readonly>
                                            <label>Deadline <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="form-group mb-1 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-list"></i></span>
                                        <div class="form-floating">
                                            <select name="repetisi" id="repetisi" class="form-control">
                                                <option value="Baru" selected>Baru</option>
                                                <option value="Berulang">Berulang</option>
                                            </select>
                                            <label>Repetisi Masalah <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        
                        <h6 class="title"><input type="checkbox" name="addition_area" id="addition_area"> <label
                                for="addition_area">Berkaitan dengan Area ?</label></h6>
                        <div class="row div_addition_area" style="display: none;">
                            <div class="col-md-6 mb-2">
                                <div class="form-group mb-1 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-list"></i></span>
                                        <div class="form-floating">
                                            <select name="id_project" id="id_project" class="form-control">
                                                <option value="#" disabled>-- Pilih Project --</option>
                                                <?php foreach ($project as $row) : ?>
                                                <option value="<?= $row->id_project ?>"><?= $row->project ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>Project <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-md btn-outline-theme" id="btn_save"
                        onclick="save_problem()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->

<!-- Modal Proses Gemba -->
<div class="modal fade" id="modal_proses_resume" tabindex="-1" aria-labelledby="modalListProsesLabel"
    aria-hidden="true">
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
                        <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button"
                            aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <h6 class="title">Detail <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span>
                    </h6>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-building h5 avatar avatar-40 bg-primary text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_department">...</h6>
                                    <p class="text-secondary small">Divisi</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2 d-none" id="div_project">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-house-fill h5 avatar avatar-40 bg-info text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_project">...</h6>
                                    <p class="text-secondary small">Project</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-card-list h5 avatar avatar-40 bg-info text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_category_new">...</h6>
                                    <p class="text-secondary small">Category</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-bounding-box-circles h5 avatar avatar-40 bg-warning text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_category">...</h6>
                                    <p class="text-secondary small">Factor</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
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
                        <div class="col-md-3 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-person-fill-check h5 avatar avatar-40 bg-primary text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_pic">...</h6>
                                    <p class="text-secondary small">Created By</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
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
                    </div>
                    <hr>
                    <form id="form_proses_resume">
                        <input type="hidden" id="id_ps" name="id_ps">
                        <input type="hidden" id="department_id_proses">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <p>Problem Deskripsi</p>
                                <div class="bd-callout bg-warning">
                                    <h6 id="problem_desc">..</h6>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <p>Yang sudah dilakukan</p>
                                <div class="bd-callout bg-warning">
                                    <h6 id="solving_desc">..</h6>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <label>Solution <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                    <textarea name="resume" id="resume" cols="30" rows="10" class="form-control border-start-0"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-folder"></i></span>
                                        <div class="form-floating">
                                            <input type="file"
                                                accept="application/pdf, .pdf, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, image/jpg, image/png, image/jpeg"
                                                id="lampiran" class="form-control lampiran" name="lampiran">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <label>Link </label>
                                    <div class="input-group">
                                        <input type="text" name="link_solution" id="link_solution"
                                            class="form-control" placeholder="https://example.com">
                                    </div>
                                </div>
                            </div>
                            

                            <div id="show_tindakan" class="">
                                <h6 class="title"><input type="checkbox" name="check_tindakan" id="check_tindakan">
                                    <label for="check_tindakan">Tindakan?</label></h6>
                                <div class="row div_check_tindakan" style="display: none;">
                                <p>* Ceklis Tindakan akan membuat tasklist ke IBR Pro</p>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-group mb-1 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i
                                                        class="bi bi-list"></i></span>
                                                <div class="form-floating">
                                                    <select name="tindakan" id="tindakan" class="form-control">
                                                        <option value="Eskalasi">Eskalasi</option>
                                                        <option value="Delegasi">Delegasi</option>
                                                    </select>
                                                    <label>Tindakan</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i
                                                        class="bi bi-person-fill-check"></i></span>
                                                <div class="form-floating">
                                                    <select name="delegate_escalate_to" id="delegate_escalate_to"
                                                        class="form-control">
                                                        <option value="#">-Choose PIC-</option>
                                                    </select>
                                                    <label>Degelasi/Eskalasi <i class="text-danger">*</i></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i
                                                        class="bi bi-calendar-event"></i></span>
                                                <div class="form-floating">
                                                    <input type="text" class="form-control border-start-0 bg-white"
                                                        name="deadline_solution" id="deadline_solution" readonly>
                                                    <label>Deadline <i class="text-danger">*</i></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i
                                                        class="bi bi-card-text"></i></span>
                                                <div class="form-floating">
                                                    <label>Tasklist <i class="text-danger">*</i></label>
                                                </div>
                                            </div>
                                            <textarea name="tasklist" id="tasklist" cols="30" rows="10" class="form-control border-start-0"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary"
                    data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-md btn-outline-theme ms-2" onclick="save_proses_resume()"
                    id="btn_save_proses_resume">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Proses Resume -->

<!-- Modal Proses Gemba -->
<div class="modal fade" id="modal_proses_feedback" aria-labelledby="modalListProsesFeedbackLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-lightbulb-fill h5 avatar avatar-40 bg-light-orange text-orange rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalListProsesFeedbackLabel">Feedback</h6>
                    <p class="text-secondary small">Problem Solving</p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button"
                            aria-expanded="false" data-bs-dismiss="modal" aria-label="Close" onclick="list_feedback()">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <h6 class="title">Detail <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span>
                    </h6>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-building h5 avatar avatar-40 bg-primary text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_department_feedback">...</h6>
                                    <p class="text-secondary small">Divisi</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2 d-none" id="div_project_feedback">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-house-fill h5 avatar avatar-40 bg-info text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_project_feedback">...</h6>
                                    <p class="text-secondary small">Project</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-card-list h5 avatar avatar-40 bg-info text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_category_new_feedback">...</h6>
                                    <p class="text-secondary small">Category</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-bounding-box-circles h5 avatar avatar-40 bg-warning text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_category_feedback">...</h6>
                                    <p class="text-secondary small">Factor</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-bell h5 avatar avatar-40 bg-warning text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_priority_feedback">...</h6>
                                    <p class="text-secondary small">Priority</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-person-fill-check h5 avatar avatar-40 bg-primary text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_pic_feedback">...</h6>
                                    <p class="text-secondary small">Created By</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-calendar-event h5 avatar avatar-40 bg-danger text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_deadline_feedback">...</h6>
                                    <p class="text-secondary small">Deadline</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <form id="form_proses_feedback">
                        <input type="hidden" id="id_ps_feedback" name="id_ps_feedback">
                        <input type="hidden" id="is_escalate" name="is_escalate" value="">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <p>Problem Deskripsi</p>
                                <div class="bd-callout bg-warning">
                                    <h6 id="problem_desc_feedback">..</h6>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <p>Yang sudah dilakukan</p>
                                <div class="bd-callout bg-warning">
                                    <h6 id="solving_desc_feedback">..</h6>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <p>Solution</p>
                                <div class="bd-callout bg-warning">
                                    <h6 id="solution_desc_feedback">..</h6>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2" id="div_lampiran_feedback">
                                <p>File</p>
                                <a href="" id="lampiran_feedback"><i class="bi bi-cloud-arrow-down-fill"></i>
                                    Download File</a>
                            </div>
                            <div class="col-md-4 mb-2" id="div_link_feedback">
                                <p>Link</p>
                                <a href="" id="link_feedback" target="_blank"></a>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i
                                                    class="bi bi-card-text"></i></span>
                                            <div class="form-floating">
                                                <label>Feedback <i class="text-danger">*</i></label>
                                            </div>
                                        </div>
                                        <textarea name="note_review" id="note_review" cols="30" rows="10" class="form-control border-start-0"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <label>Rating <i class="text-danger">*</i></label><br><br>
                                        <div class="input-group input-group-lg">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input custom-radio" type="radio" name="hasil_review" id="hasil_review_1" value="1">
                                                    <label class="form-check-label custom-label" for="hasil_review_1">1</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input custom-radio" type="radio" name="hasil_review" id="hasil_review_2" value="2">
                                                    <label class="form-check-label custom-label" for="hasil_review_2">2</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input custom-radio" type="radio" name="hasil_review" id="hasil_review_3" value="3">
                                                    <label class="form-check-label custom-label" for="hasil_review_3">3</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input custom-radio" type="radio" name="hasil_review" id="hasil_review_4" value="4">
                                                    <label class="form-check-label custom-label" for="hasil_review_4">4</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input custom-radio" type="radio" name="hasil_review" id="hasil_review_5" value="5">
                                                    <label class="form-check-label custom-label" for="hasil_review_5">5</label>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2" id="div_status_feedback">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i
                                                    class="bi bi-check-square"></i></span>
                                            <div class="form-floating">
                                                <select name="status_akhir" id="status_akhir" class="form-control">
                                                    <option value="#">-- Choose Status --</option>
                                                    <option value="3">Done</option>
                                                    <option value="4">Unsolved</option>
                                                </select>
                                                <label>Status <i class="text-danger">*</i></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary"
                    data-bs-dismiss="modal" onclick="list_feedback()">Close</button>
                <button type="button" class="btn btn-md btn-outline-theme ms-2" onclick="save_proses_feedback()"
                    id="btn_save_feedback">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Proses Resume -->

<!-- Modal Proses Gemba -->
<div class="modal fade" id="modal_list_feedback" tabindex="-1" aria-labelledby="modallistfeedbacklabel"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-lightbulb-fill h5 avatar avatar-40 bg-light-orange text-orange rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modallistfeedbacklabel">List Feedback</h6>
                    <p class="text-secondary small">Problem Solving</p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button"
                            aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="" style="padding: 10px;">
                    <table id="dt_list_problem_feedback" class="table table-striped dt-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th>No Masalah</th>
                                <th>Problem</th>
                                <th>Yang sudah dilakukan</th>
                                <th>File</th>
                                <th>Link</th>
                                <th>Divisi</th>
                                <th>Category</th>
                                <th>Factor</th>
                                <th>Priority</th>
                                <th>PIC</th>
                                <th>Deadline</th>
                                <th>Project</th>
                                <th>Tindakan</th>
                                <th>Solution</th>
                                <th>Delegate/Escalate to</th>
                                <th>Tasklist</th>
                                <th>Deadline Tasklist</th>
                                <th>Status</th>
                                <th>Repetisi Masalah</th>
                                <th>Rating Feedback</th>
                                <th>Feedback</th>
                                <th>Created By</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary"
                    data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Proses Resume -->


<!-- Modal Proses Gemba -->
<div class="modal fade" id="modal_history_delegate" tabindex="-1" aria-labelledby="modallistdelegatelabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-lightbulb-fill h5 avatar avatar-40 bg-light-orange text-orange rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modallistdelegatelabel">List Delegate Escalate History</h6>
                    <p class="text-secondary small">Problem Solving</p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button"
                            aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="" style="padding: 10px;">
                    <table id="dt_list_history_delegate" class="table table-striped dt-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th>No Masalah</th>
                                <th>Delegate/Escalate to</th>
                                <th>Created By</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary"
                    data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Proses Resume -->
