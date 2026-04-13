<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $title; ?></h5>
            </div>
            <div class="col-auto ps-0">

            </div>
        </div>
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="m-3">
        <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-4">
            <div class="card border-0 theme-red">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class=" col-auto">
                            <i class="bi bi-list-task h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col">
                            <h6 class="fw-medium mb-0"><span class="text-gradient">Task list</span> - Waiting / Progress</h6>
                            <p class="text-secondary small">Do your best</p>
                        </div>
                    </div>
                </div>
            </div>

            <div id="my_tasklist" class="mb-4" style="min-height: 300px;">
            </div>


            <div class="card border-0 theme-red">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-auto mb-2">
                            <i class="bi bi-list-task h5 avatar avatar-40 bg-light-blue rounded"></i>
                        </div>
                        <div class="col mb-2">
                            <h6 class="fw-medium mb-0"><span class="text-gradient">Task list</span> - All</h6>
                            <p class="text-secondary small">Good Job</p>
                        </div>
                        <div class="col-12 col-sm-auto mb-2">
                            <div class="input-group input-group-md reportrange" style="border-bottom: solid 2px #5087FF;">
                                <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                                <input type="hidden" name="start" value="" id="start" />
                                <input type="hidden" name="end" value="" id="end" />
                                <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-2 mt-2" id="div_dt_tasklist_done">
                <div class="card-body">
                    <table id="dt_tasklist_done" class="table table-sm table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>No. PH</th>
                                <th>Project</th>
                                <th>Pekerjaan</th>
                                <th>Detail Pekerjaan</th>
                                <th>Item</th>
                                <th>Tgl Pengerjaan</th>
                                <th>Helper</th>
                                <th>Equipment</th>
                                <th>Foto Start</th>
                                <th>Note Start</th>
                                <th>Foto End</th>
                                <th>Note End</th>
                            </tr>
                        </thead>
                        <tbody></tbody>

                    </table>
                </div>
            </div>

            <div id="my_tasklist_done" class="mb-4 hide" style="min-height: 300px;">
            </div>

        </div>
    </div>
</main>

<!-- Modal Tasklist -->
<div class="modal fade" id="modal_tasklist" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalApproveLabel">Form</h6>
                    <p class="text-secondary small">Input Progress Tasklist</p>
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
                <form id="form_tasklist">
                    <input type="hidden" id="status" name="status" value="0" readonly>
                    <div class="proses">
                        <input type="hidden" id="no_ph_proses" name="no_ph_proses" readonly>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" id="project_proses" name="project_proses" class="form-control" readonly>
                                            <label>Project</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" id="pekerjaan_proses" name="pekerjaan_proses" class="form-control" readonly>
                                            <label>Pekerjaan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <textarea class="form-control" name="detail_proses" id="detail_proses" cols="30" rows="3" readonly></textarea>
                                            <label>Detail Pekerjaan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <textarea class="form-control" name="equipment_proses" id="equipment_proses" cols="30" rows="3" readonly></textarea>
                                            <label>Equipment</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" id="tanggal_proses" name="tanggal_proses" class="form-control" readonly>
                                            <label>Tanggal Pekerjaan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12" align="left" id="foto_start_hidden">
                                <label>Foto Start</label>
                                <br>
                                <a href="" id="foto_start_proses" class="btn btn-sm btn-outline-warning bi bi-image" data-fancybox></a>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <textarea class="form-control" name="helper_proses" id="helper_proses" cols="30" rows="3" readonly></textarea>
                                            <label>Helper</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Foto</label>
                                    <input style="padding: .4rem .75rem;" type="file" id="image_proses" class="form-control" onchange="compress('#image_proses', '#foto_proses', '#save_tasklist', '.fa_wait_proses', '.fa_done_proses')" accept=".jpg,.jpeg,.png" required>
                                    <input type="hidden" class="form-control" name="foto_proses" id="foto_proses">
                                    <div class="fa_wait_proses" style="display: none;"><i class="fa fa-spinner fa-pulse"></i> <label>Uploading File ...</label></div>
                                    <div class="fa_done_proses" style="display: none;"><i class="fa fa-check-circle" style="color: #689f38;"></i> <label>Upload Complete.</label></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <textarea class="form-control" name="note_proses" id="note_proses" cols="30" rows="3"></textarea>
                                            <label>Note</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn m-1 btn-secondary" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button class="btn m-1 btn-theme" id="update_tasklist">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Input Tasklist -->