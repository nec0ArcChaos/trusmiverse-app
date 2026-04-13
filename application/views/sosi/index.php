<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
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
                    <div class="row mb-2">
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <label for="">Filter Tanggal</label>
                        </div>
                        <div class="col col-sm-auto">
                            <div class="input-group input-group-md border rounded reportrange">
                                <span class="input-group-text text-secondary bg-none"><i class="bi bi-calendar-event"></i></span>
                                <input type="text" class="form-control range bg-none" style="cursor: pointer;margin-right: 10px;margin-left: 5px;" id="titlecalendar">
                                <input type="hidden" name="start" value="" id="start" />
                                <input type="hidden" name="end" value="" id="end" />
                            </div>
                        </div>
                        <div class="col text-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_strategi_objektif">Add Strategy</button>
                        </div>
                    </div>
                    <div class="table-responsive" style="padding: 10px;">
                        <div class="row">

                            <div class="col-12 col-md-12 col-lg-12 mb-2">
                                <label for="">Group Table</label>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mb-2">
                                <select id="search-periode" multiple>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mb-2">
                                <select id="search-week" multiple>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mb-2">
                                <select id="search-nama" multiple>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mb-2">
                                <select id="search-objektif" multiple>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mb-2">
                                <select id="search-inisiatif" multiple>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mb-2">
                                <select id="search-task" multiple>
                                </select>
                            </div>
                        </div>
                        <table id="dt_sosi" class="table table-sm table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>Week</th>
                                    <th>Tgl</th>
                                    <th>Nama</th>
                                    <th>Objektif</th>
                                    <th>Inisiatif</th>
                                    <th>Task</th>
                                    <th>Ketercapaian</th>
                                    <th>Target</th>
                                    <th>Actual</th>
                                    <th>Status</th>
                                    <th>Resume</th>
                                    <th>File</th>
                                    <th>Link</th>
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

<!-- Modal Strategi Objektif -->
<div class="modal fade" id="modal_strategi_objektif" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header d-block bg-light-theme">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Daftar Strategi Objektif</h6>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-sm" id="dt_strategi_objektif">
                        <thead>
                            <tr>
                                <th>Strategi</th>
                                <th>Objektif</th>
                                <th>Inisiatif</th>
                                <th>Actual</th>
                                <th>%</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_strategi_objektif">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Strategi Inisiatif -->
<div class="modal fade" id="modal_strategi_inisiatif" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header d-block bg-light-orange">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-orange rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Daftar Strategi Inisiatif</h6>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">

                    <table class="table table-hover table-striped" id="dt_strategi_inisiatif">
                        <thead>
                            <tr>
                                <th>Inisiatif</th>
                                <th>Task</th>
                                <th>Actual</th>
                                <th>%</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_strategi_inisiatif">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" data-bs-dismiss="modal">Back</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Strategi Task -->
<div class="modal fade" id="modal_strategi_task" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header d-block bg-light-purple">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-purple rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Daftar Task</h6>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="dt_strategi_task">
                        <thead>
                            <tr>
                                <th>Task</th>
                                <th>Ketercapaian</th>
                                <th>Actual</th>
                                <th>%</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_strategi_task">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" data-bs-dismiss="modal">Back</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Strategi Ketercapaian -->
<div class="modal fade" id="modal_strategi_ketercapaian" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header d-block bg-light-theme">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Daftar Ketercapaian</h6>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="dt_strategi_ketercapaian">
                        <thead>
                            <tr>
                                <th>Ketercapaian</th>
                                <th>Target</th>
                                <th>Actual</th>
                                <th>%</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_strategi_ketercapaian">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" data-bs-dismiss="modal">Back</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Input Ketercapaian -->
<div class="modal fade" id="modal_input_ketercapaian" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header d-block bg-light-purple">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-purple rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Input Pencapaian</h6>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="" class="small">Ketercapaian :</label>
                            <input type="hidden" name="ketercapaian" id="ketercapaian" class="form-control" readonly>
                            <p id="ketercapaian_text"></p>
                        </div>
                        <div class="mb-3">
                            <label for="" class="small">Status</label>
                            <div class="col-12 mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="status_inline_radio_1" value="Jalan" checked>
                                    <label class="form-check-label" for="status_inline_radio_1">Jalan</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="status_inline_radio_2" value="Tidak Jalan">
                                    <label class="form-check-label" for="status_inline_radio_2">Tidak Jalan</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="small">Resume</label>
                            <textarea class="form-control border" type="text" name="resume" id="resume" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="mb-3">
                            <label for="" class="small">Actual</label>
                            <input class="form-control border" type="number" name="actual" id="actual">
                        </div>
                        <div class="mb-2">
                            <label for="" class="small">File</label>
                            <input class="form-control border" type="file" name="file" id="file">
                        </div>
                        <div class="mb-2">
                            <label for="" class="small">Link</label>
                            <input class="form-control border" type="text" name="link" id="link">
                        </div>
                        <div class="mb-2 text-end">
                            <button class="btn btn-primary" onclick="save()">Simpan</button>

                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="dt_detail_ketercapaian" width="100%">
                        <thead>
                            <tr>
                                <th>Periode</th>
                                <th>Week</th>
                                <th>Created By</th>
                                <th>Ketercapaian</th>
                                <th>Status</th>
                                <th>Actual</th>
                                <th>Resume</th>
                                <th>File</th>
                                <th>Link</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" data-bs-dismiss="modal">Back</button>
            </div>
        </div>
    </div>
</div>