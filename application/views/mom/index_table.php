
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
                            <button type="button" class="btn btn-md btn-outline-theme" data-bs-toggle="modal" data-bs-target="#modal_add_lock"><i class="bi bi-journal-plus"></i> Add Notulen</button>
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
<div class="modal fade" id="modal_add_lock" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                        <a class="btn btn-link btn-square text-white dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form id="form_lock">
                    <div class="col-12 col-lg-12 col-xl-12 mb-4">
                        <h6 class="title">Detail Notulen <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="text" id="id_mom_global" value="MOM231207001">
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
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-theme" id="btn_save">Save</button>
                </div>
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