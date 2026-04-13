<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-auto mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
            </div>
            <div class="col-auto"></div>
            <!-- <div class="col-auto ps-0"></div> -->
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
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set mb-2">
            <div class="card border-0">
                <div class="card-header"> 
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-question-circle-fill h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List QnA</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">                            
                            <div class="input-group input-group-md border rounded">
                                <span class="input-group-text text-theme"><i class="bi bi-calendar"></i></span>
                                <input type="text" class="form-control" style="cursor: pointer;" id="periode" name="periode" value="<?= $periode; ?>" onchange="filter_list_qna()">
                            </div>                        
                            <?php if($_SESSION['user_role_id'] == 1 || $_SESSION['user_id'] == 2) { ?>
                                <!-- <button type="button" class="btn btn-md btn-outline-theme" onclick="add_qna()">Add QnA</button> -->
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="dt_list_qna" class="table table-striped dt-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th>QnA</th>
                                <th>Judul</th>
                                <th>Pengantar</th>
                                <th>Kategori</th>
                                <th>Company</th>
                                <th>Department</th>
                                <th>Level</th>
                                <th>List User</th>
                                <th>Total Question</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php 
        $allowed_roles = [1, 11];
        $allowed_users = [2, 6466, 1139, 5121, 10127];

        if (in_array($_SESSION['user_role_id'], $allowed_roles) || in_array($_SESSION['user_id'], $allowed_users)) { ?>
        <hr>
        <!-- List Result QnA -->
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header"> 
                    <div class="row">
                        <div class="col-auto">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-card-list h5 avatar avatar-40 bg-light-theme rounded"></i>
                                </div>
                                <div class="col-auto align-self-center">
                                    <h6 class="fw-medium mb-0">List Result QnA</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto ms-auto">
                            <div class="input-group input-group-md border rounded reportrange">
                                <span class="input-group-text text-theme"><i class="bi bi-calendar"></i></span>
                                <input type="text" class="form-control range bg-none" style="cursor: pointer;" id="titlecalendar">
                                <input type="hidden" name="start" value="" id="start" readonly/>
                                <input type="hidden" name="end" value="" id="end" readonly/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="" style="padding: 10px;">
                        <table id="dt_list_result_qna" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id Answer</th>
                                    <th>Judul QnA</th>
                                    <th>Nilai</th>
                                    <th>Indikator</th>
                                    <th>Week</th>
                                    <th>Periode</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                    <th>Company</th>
                                    <th>Department</th>
                                    <th>Level</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>    
        <hr>
        <!-- Resume QnA by Sub -->
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header"> 
                    <div class="row">
                        <div class="col-auto">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-card-list h5 avatar avatar-40 bg-light-theme rounded"></i>
                                </div>
                                <div class="col-auto align-self-center">
                                    <h6 class="fw-medium mb-0">Resume QnA by Sub</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto ms-auto">
                            <div class="input-group input-group-md border rounded reportrange_sub">
                                <span class="input-group-text text-theme"><i class="bi bi-calendar"></i></span>
                                <input type="text" class="form-control range_sub bg-none" style="cursor: pointer;">
                                <input type="hidden" name="start_sub" value="" id="start_sub" readonly/>
                                <input type="hidden" name="end_sub" value="" id="end_sub" readonly/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="" style="padding: 10px;">
                        <table id="dt_resume_qna_by_sub" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Sub</th>
                                    <th>Nilai</th>
                                    <th>Indikator</th>
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                    <th>4</th>
                                    <th>5</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <!-- Resume QnA by Question -->
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header"> 
                    <div class="row">
                        <div class="col-auto">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-card-list h5 avatar avatar-40 bg-light-theme rounded"></i>
                                </div>
                                <div class="col-auto align-self-center">
                                    <h6 class="fw-medium mb-0">Resume QnA by Question</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto ms-auto">
                            <div class="input-group input-group-md border rounded reportrange_question">
                                <span class="input-group-text text-theme"><i class="bi bi-calendar"></i></span>
                                <input type="text" class="form-control range_question bg-none" style="cursor: pointer;">
                                <input type="hidden" name="start_question" value="" id="start_question" readonly/>
                                <input type="hidden" name="end_question" value="" id="end_question" readonly/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="" style="padding: 10px;">
                        <table id="dt_resume_qna_by_question" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Sub</th>
                                    <th>Question</th>
                                    <th>Nilai</th>
                                    <th>Indikator</th>
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                    <th>4</th>
                                    <th>5</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</main>

<!-- Modal Result Gemba -->
<div class="modal fade" id="modal_result_qna" tabindex="-1" aria-labelledby="modalResultqnaLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-list h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalResultqnaLabel">Detail Result</h6>
                    <p class="text-secondary small">Question and Answer</p>
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
                <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="" style="padding: 10px;">
                                <table id="dt_result_qna" class="table table-striped dt-responsive" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Id Answer</th>
                                            <th>Question</th>
                                            <th>Answer</th>
                                            <th>Bobot</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Result qna -->

<!-- Modal Add -->
<!-- <div class="modal fade" id="modal_add_plan" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_plan">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                        <p class="text-secondary small">Add Plan Genba</p>
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
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-date"></i></span>
                                        <div class="form-floating">
                                            <input type="text" id="tgl_plan" name="tgl_plan" class="form-control border-start-0" placeholder="Tgl Plan">
                                            <label>Plan Date <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-list"></i></span>
                                        <div class="form-floating">
                                            <select name="tipe_gemba" id="tipe_gemba" class="form-control">
                                                <option value="#" selected disabled>-- Choose Tipe --</option>
                                                <?php foreach ($tipe as $row) : ?>
                                                    <option value="<?= $row->id ?>"><?= $row->tipe_gemba ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>Tipe <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-geo"></i></span>
                                        <div class="form-floating">
                                            <input type="text" id="lokasi" name="lokasi" class="form-control border-start-0" placeholder="Lokasi">
                                            <label>Location <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-md btn-outline-theme" id="btn_save" onclick="save_gemba()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div> -->
<!-- Modal Add -->