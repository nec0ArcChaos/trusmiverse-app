<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <!-- <p class="text-secondary">Report Audit Finance</p> -->
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

    <!-- CARD LIST USER -->
    <div class="container-fluid mb-4 breadcrumb-theme">
        <div class="row">
            <div class="col-12 mb-4 column-set">
                <div class="row align-items-center mb-3">
                    <div class="col-auto">
                        <i class="bi bi-people h5 avatar avatar-40 bg-light-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Resume Ticket Development</h6>
                        <p class="text-secondary small">Usage and Restrictions applied to users</p>
                    </div>
                    <div class="col-auto">
                        <div class="dropdown d-inline-block">
                            <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                <i class="bi bi-columns"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div class="dropdown-item text-center">
                                    <div class="row gx-3 mb-3">
                                        <div class="col-6">
                                            <div class="row select-column-size gx-1">
                                                <div class="col-8" data-title="8"><span></span></div>
                                                <div class="col-4" data-title="4"><span></span></div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row select-column-size gx-1">
                                                <div class="col-9" data-title="9"><span></span></div>
                                                <div class="col-3" data-title="3"><span></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row gx-3">
                                        <div class="col-6">
                                            <div class="row select-column-size gx-1">
                                                <div class="col-6" data-title="6"><span></span></div>
                                                <div class="col-6" data-title="6"><span></span></div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row select-column-size gx-1">
                                                <div class="col-12" data-title="12"><span></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid" id="div_cards_resume">

                </div>

            </div>
        </div>
    </div>
    <!-- END LIST USER -->

    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-files h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Resume Ticket</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="" style="padding: 10px;">
                        <!-- <table id="dt_tbl_resume_tiket" class="table table-striped table-bordered dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">Nama</th>
                                    <th rowspan="2">Jabatan</th>
                                    <th colspan="3">Komitmen</th>
                                    <th rowspan="2">Development</th>
                                    <th rowspan="3">Ticket</th>
                                    <th rowspan="2">Undone</th>
                                </tr>
                                <tr>
                                    <th>Target</th>
                                    <th>Actual</th>
                                    <th>Ach Komitmen</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table> -->
                        <table id="dt_tbl_resume_tiket" class="table table-striped table-bordered dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Komitmen Target</th>
                                    <th>Komitmen Actual</th>
                                    <th>Ach Komitmen</th>
                                    <th>Development</th>
                                    <th>Ticket</th>
                                    <th>Undone</th>
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
<div class="modal fade" id="modal_add_report" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_add_report">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-lightbulb-fill h5 avatar avatar-40 bg-light-blue text-cyan rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                        <p class="text-secondary small">Add new Report</p>
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
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-files"></i></span>
                                        <div class="form-floating">
                                            <label>Attachment (PDF/Image) <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                    <!-- <textarea name="problem" id="problem" cols="30" rows="10" class="form-control border-start-0"></textarea> -->
                                    <input type="file" name="attachment" id="attachment" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <label>Note</label>
                                        </div>
                                    </div>
                                    <input type="text" name="note" id="note" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-md btn-outline-theme" id="btn_save" onclick="save_report()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->

<!-- Modal list pph for verified -->
<div class="modal fade" id="modal_list_waiting_report" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-lightbulb-fill h5 avatar avatar-40 bg-light-blue text-cyan rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddLabel">List Review Report Audit</h6>
                    <!-- <p class="text-secondary small">PPH 21</p> -->
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
                <div class="" style="padding: 10px;">
                    <table id="dt_waiting_report" class="table table-striped dt-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id Report</th>
                                <th>Attachment</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Created By</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal list pph for verified -->

<!-- Modal Verifikasi -->
<div class="modal fade" id="modal_verifikasi" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_verifikasi_report">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-lightbulb-fill h5 avatar avatar-40 bg-light-blue text-cyan rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form Verifikasi Report Audit</h6>
                        <!-- <p class="text-secondary small"></p> -->
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
                            <!-- <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-files"></i></span>
                                        <div class="form-floating">
                                            <label>Bukti File (Bukti Chat)<i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                    <input type="file" name="file_verif" id="file_verif" class="form-control">
                                    <input type="hidden" name="id_pajak" id="id_pajak">
                                </div>
                            </div> -->
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <label>Note<i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                    <!-- <input type="text" name="note_verif" id="note_verif" class="form-control"> -->
                                    <textarea name="note_verif" id="note_verif" class="form-control"></textarea>
                                    <input type="hidden" name="id_report" id="id_report">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-md btn-outline-theme" id="btn_save_verif" onclick="verif_report(2)">Approve</button> -->
                    <button type="button" class="btn btn-success btn-md" style="margin-right:5px;" id="btn_approve" onclick="save_verif_report(2)">Approve</button>
                    <button type="button" class="btn btn-danger btn-md" id="btn_reject" onclick="save_verif_report(3)">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal verifikasi pph21 -->