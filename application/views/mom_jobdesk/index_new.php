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
                        <input type="hidden" name="start" value="" id="start" readonly/>
                        <input type="hidden" name="end" value="" id="end" readonly/>
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
                            <i class="bi bi-journal-text h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Notulen</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                            <button type="button" class="btn btn-md btn-outline-theme" onclick="add_mom()"><i class="bi bi-journal-plus"></i> Add Notulen</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_list_mom" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
									<th>Id</th>
									<th>Judul</th>
									<th>Peserta</th>
									<th>Agenda</th>
									<th>Tempat</th>
									<th>Tanggal</th>
									<th>Waktu</th>
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
<div class="modal fade" id="modal_add_mom" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content" style="overflow-y: auto;">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                        <i class="bi bi-journal-text h5 avatar avatar-40 bg-light text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                        <p class="text-white small">Add Notulen</p>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="dropdown d-inline-block">
                            <a class="btn btn-link btn-square text-white dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" onclick="cancel()" aria-label="Close">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="col-12 col-lg-12 col-xl-12 mb-4">
                        <h6 class="title">Notulen <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                        <div id="smartwizard2" class="mb-4">
                            <ul class="nav nav-fill">
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-111">
                                        <div class="avatar avatar-40 rounded-circle mb-1">
                                            <i class="bi bi-card-text mb-1"></i>
                                        </div>
                                        <p>Detail</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-121">
                                        <div class="avatar avatar-40 rounded-circle mb-1">
                                            <i class="bi bi-columns mb-1"></i>
                                        </div>
                                        <p>Result</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-131">
                                        <div class="avatar avatar-40 rounded-circle mb-1">
                                            <i class="bi bi-check-circle mb-1"></i>
                                        </div>
                                        <p>Closing</p>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content mb-4">                                
                                <input type="hidden" id="id_mom_global" name="id_mom_global" value="">
                                <div id="step-111" class="tab-pane" role="tabpanel">
                                    <div class="card border-0">
                                        <div class="card-body">
                                            <!-- Step content 1 -->
                                            <form id="form_detail">
                                                <input type="hidden" id="id_mom" name="id_mom" value="">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 mb-2">
                                                        <div class="form-group mb-3 position-relative check-valid judul">
                                                            <div class="input-group input-group-lg">
                                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-align-top"></i></span>
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control border-start-0" name="judul" id="judul" placeholder="Judul">
                                                                    <label>Judul <b class="text-danger small">*</b></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-2">
                                                        <div class="form-group mb-3 position-relative check-valid tempat">
                                                            <div class="input-group input-group-lg">
                                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-building"></i></span>
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control border-start-0" name="tempat" id="tempat" placeholder="Tempat">
                                                                    <label>Tempat <b class="text-danger small">*</b></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-4 mb-2">
                                                        <div class="form-group mb-3 position-relative check-valid tgl">
                                                            <div class="input-group input-group-lg">
                                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-event"></i></span>
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control border-start-0 tanggal" name="tanggal" id="tanggal" placeholder="Date">
                                                                    <label>Date <b class="text-danger small">*</b></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 mb-2">
                                                        <div class="form-group mb-3 position-relative check-valid start">
                                                            <div class="input-group input-group-lg">
                                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-clock"></i></span>
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control border-start-0 waktu" name="start_time" id="start_time" placeholder="Start Time">
                                                                    <label>Start Time <b class="text-danger small">*</b></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 mb-2">
                                                        <div class="form-group mb-3 position-relative check-valid end">
                                                            <div class="input-group input-group-lg">
                                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-clock-history"></i></span>
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control border-start-0 waktu" name="end_time" id="end_time" placeholder="End Time">
                                                                    <label>End Time <b class="text-danger small">*</b></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-6 mb-2">
                                                        <div class="form-group mb-3 position-relative check-valid agenda">
                                                            <div class="input-group input-group-lg">
                                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-receipt"></i></span>
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control border-start-0" name="agenda" id="agenda" placeholder="Agenda">
                                                                    <label>Agenda <b class="text-danger small">*</b></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-2">
                                                        <div class="form-group mb-3 position-relative check-valid peserta">
                                                            <div class="input-group input-group-lg">
                                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-lines-fill"></i></span>
                                                                <div class="form-floating">
                                                                    <select name="peserta" id="peserta" class="form-control" multiple>
                                                                        <option data-placeholder="true">-- Choose Employee --</option>
                                                                        <?php foreach ($karyawan as $row) : ?>
                                                                            <option value="<?= $row->user_id ?>"><?= $row->employee_name ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                    <label>Peserta <b class="text-danger small">*</b></label>
                                                                    <input type="hidden" id="user" name="user" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-12 col-lg-12 mb-2">
                                                        <div class="form-group mb-3 position-relative check-valid pembahasan">
                                                            <div class="input-group input-group-lg">
                                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                                                <div class="form-floating">
                                                                    <label class="form-check-label">Pembahasan <b class="text-danger small">*</b></label>
                                                                </div>
                                                            </div>
                                                            <textarea name="pembahasan" id="pembahasan" class="form-control border-start-0 editor" cols="30" rows="5" style="min-height: 80px;" required></textarea>
                                                        </div>
                                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div id="step-121" class="tab-pane" role="tabpanel">
                                    <div class="card border-0">
                                        <div class="card-body">
                                            <!-- Result -->
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <input type="hidden" id="total_issue" value="1">
                                                    <table id="dt_mom_result" class="table table-bordered" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th width="15%">Issue</th>
                                                                <th width="45%" colspan="2">Action</th>
                                                                <th width="10%">Kategorisasi</th>
                                                                <th width="15%">Deadline</th>
                                                                <th width="15%">PIC</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr id="div_issue_1">
                                                                <input type="hidden" id="total_action_1" value="1">
                                                                <td class="kolom_modif" id="td_issue_1" data-id="issue_1_1" rowspan="2">
                                                                    <span id="issue_1_1">&nbsp;</span>
                                                                    <textarea class="form-control" id="val_issue_1_1" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea('val_issue_1_1')" onfocusout="submit_update('issue_1_1')"></textarea>
                                                                </td>
                                                                <td width="1%" id="no_1_1">1.</td>
                                                                <td class="kolom_modif" id="td_action_1_1" data-id="action_1_1">
                                                                    <span id="action_1_1">&nbsp;</span>
                                                                    <textarea class="form-control" id="val_action_1_1" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea('val_action_1_1')" onfocusout="submit_update('action_1_1')"></textarea>
                                                                </td>
                                                                <td class="kolom_modif" id="td_kategori_1_1" data-id="kategori_1_1">
                                                                    <select class="form-control" id="val_kategori_1_1" onchange="submit_update('kategori_1_1')">
                                                                        <option>- Choose -</option>
                                                                        <?php foreach ($kategori as $ktg): ?>
                                                                            <option value="<?php echo $ktg->id ?>"><?php echo $ktg->kategori ?></option>
                                                                        <?php endforeach ?>
                                                                    </select>
                                                                </td>
                                                                <td class="kolom_modif" id="td_deadline_1_1" data-id="deadline_1_1">
                                                                    <span id="deadline_1_1">&nbsp;</span>
                                                                    <textarea class="form-control" id="val_deadline_1_1" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea('val_deadline_1_1')" onfocusout="submit_update('deadline_1_1')"></textarea>
                                                                    <input type="text" class="form-control tanggal" id="val_date_deadline_1_1" style="display: none;" onfocusout="submit_update('deadline_1_1')">
                                                                </td>
                                                                <td id="td_pic_1_1">
                                                                    <select id="val_pic_1_1" class="form-control pic" multiple onchange="submit_update('pic_1_1')">
                                                                        <option data-placeholder="true">-- Choose Employee --</option>
                                                                        <?php foreach ($pic as $row) : ?>
                                                                            <option value="<?= $row->user_id ?>"><?= $row->employee_name ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr id="div_issue_action_1">
                                                                <td style="cursor: pointer;" colspan="5">
                                                                    <span class="btn btn-md btn-outline-success" onclick="add_action(1)"><i class="bi bi-list-ol"></i> Add Action</span>
                                                                </td>
                                                            </tr>
                                                            <tr id="div_issue">
                                                                <td style="cursor: pointer;" colspan="6">
                                                                    <span class="btn btn-md btn-outline-success" onclick="add_issue(1)"><i class="bi bi-plus-square"></i>  </i> Add Issue</span>
                                                                </td>
                                                            </tr>
                                                            <div id="div_custom"></div>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="step-131" class="tab-pane" role="tabpanel">
                                    <div class="card border-0 ">
                                        <div class="card-body">
                                            <!-- Closing -->
                                            <form id="form_closing">                                                
                                                <div class="row">
                                                    <div class="col-12 col-md-12 col-lg-12 mb-2">
                                                        <div class="form-group mb-3 position-relative check-valid closing">
                                                            <div class="input-group input-group-lg">
                                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-bookmark-star"></i></span>
                                                                <div class="form-floating">
                                                                    <label>Closing Statement <b class="text-danger small">*</b></label>
                                                                </div>
                                                            </div>
                                                            <textarea name="closing" id="closing" class="form-control border-start-0 editor ml-2" cols="30" rows="5" style="min-height: 80px;" required></textarea>
                                                        </div>
                                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-success" style="margin-right:10px;" id="btn_finish" onclick="finish()">Finish</button>
                    <button type="button" class="btn btn-md btn-outline-danger" id="btn_cancel" onclick="cancel()">Cancel</button>
                </div>
        </div>
    </div>
</div>
<!-- Modal Add -->