<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <!-- <p class="text-secondary">Tempat sebenarnya.</p> -->
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
                <div class="card-body">
                    <div class="" style="padding: 10px;">
                        <table id="dt_list_path" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="10%">Action</th>
                                    <th>Point</th>
                                    <th>Type</th>
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

<!-- Modal Proses Path -->
<div class="modal fade" id="modal_proses_path" tabindex="-1" aria-labelledby="modalResultGembaLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-bar-chart-steps h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalResultGembaLabel">Check Genba Canvas</h6>
                    <p class="text-secondary small">Process Travel Path</p>
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
                            <!-- <ul class="progress-stepbar mb-3 overflow-scroll"> -->
                            <ul class="progress-stepbar mb-3" style="overflow-x:scroll !important;">
                                <!-- Get Detail Path -->
                            </ul>
                        </div>
                    </div>
                    <hr>                    
                    <!-- Detail Form -->
                    <div class="card border-0 mb-4 status-start border-card-status border-primary w-100">
                        <div class="card-header">   
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <i class="bi bi-hourglass-top h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                                </div>
                                <div class="col ps-0">
                                    <h6 class="fw-medium mb-0 text_category">Place & People | Poin 4</h6>
                                    <p class="text-secondary small text_path">Sales Marketing (personil & jumlah) dan Lokasi sesuai dengan plan canvasing</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="form_path">
                                <input type="hidden" name="tp_id" id="tp_id">
                                <input type="hidden" name="path_id" id="path_id">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-check-square"></i></span>
                                                <div class="form-floating">
                                                    <select class="form-select border-0" id="status" name="status" required="">
                                                        <option value="#">Status...</option>
                                                        <option value="Sesuai">Sesuai</option>
                                                        <option value="Tidak Sesuai">Tidak Sesuai</option>
                                                    </select>
                                                    <label for="status">Status <b class="text-danger">*</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group mb-0 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <a href="#" target="_blanks" class="foto_standar input-group-text text-theme bg-white border-end-0"><i class="bi bi-image"></i></a>
                                                <div class="form-floating align-self-center">
                                                    <input type="file" class="evidence_input form-control border-start-0" id="evidence" name="evidence" autocomplete="off" accept="*">
                                                    <a href="javascript:void(0);" target="_blanks" class="badge bg-info evidence_show">File Evidence</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-secondary"> <b class="text-danger">*</b> Foto Standar Klik Icon Image</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-justify"></i></span>
                                                <div class="form-floating">
                                                    <select class="form-select border-0" id="tipe" name="tipe" required="">
                                                        <option value="#">Tipe...</option>
                                                        <option value="Keputusan">Keputusan</option>
                                                        <option value="Regulasi">Regulasi</option>
                                                    </select>
                                                    <label for="tipe">Tipe <b class="text-danger">*</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journals"></i></span>
                                                <div class="form-floating">
                                                    <textarea name="evaluasi" id="evaluasi" cols="30" rows="10" class="form-control border-start-0" placeholder="Evaluasi"></textarea>
                                                    <label>Evaluasi <b class="text-danger">*</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journal-text"></i></span>
                                                <div class="form-floating">
                                                    <textarea name="note" id="note" cols="30" rows="10" class="form-control border-start-0" placeholder="Note"></textarea>
                                                    <label>Note <b class="text-danger">*</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-md btn-outline-theme" onclick="save_travel_path()" id="btn_save_travel_path">Save</button>
                            </form>
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
<!-- Modal Proses Path -->

<!-- Modal Loading -->
<div class="modal fade" id="modal_loading" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-centered">
        <div class="modal-content bg-none border-0">
            <div class="modal-body">
                <div class="mx-auto align-items-center text-center" style="margin-top: 10% !important;">
                    <span class="spinner-border spinner-border-lg mb-2" role="status" aria-hidden="true"></span>
                    <h6>L o a d i n g...</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Loading -->