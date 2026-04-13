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
                                    <button type="button" class="btn btn-primary" id="btn_list_audit"><i class="bi bi-person-workspace"></i>
                                        List Plan</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_actual" class="table table-sm table-striped dataTable no-footer" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Auditor</th>
                                    <th>SOP/IK/MEMO</th>
                                    <th>Subject Audit</th>
                                    <th>Object Audit</th>
                                    <th>Tools</th>
                                    <th>PIC</th>
                                    <th>Company</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Pemeriksaan</th>
                                    <th>Output</th>
                                    <th>Target</th>
                                    <th>Bobot %</th>
                                    <!-- <th>Hasil %</th>  -->
                                    <th>Analisa</th>
                                    <th>Konfirmasi</th>
                                    <th>Hasil Pemeriksaan & Rekomendasi (30%)</th>
                                    <th>Improvement (10%)</th>
                                    <th>Note</th>
                                    <th>PIC Name</th>
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
<!-- Modal Input Plan Audit -->
<div class="modal" id="modal_edit_audit" tabindex="-1" style="z-index: 1101;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Isi Actual Audit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_edit_audit">
                    <input type="hidden" id="id_plan" name="id_plan">
                    <div class="col-lg-12 d-lg-flex d-sm-block justify-content-around">
                        <div class="col-lg-5">
                            <label class="form-label-custom required small" for="output">Output</label>
                            <div class="input-group mb-3">
                                <textarea class="form-control input_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" name="output" id="output"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <label class="form-label-custom required small" for="analisa">Analisa</label>
                            <div class="input-group mb-3">
                                <textarea class="form-control input_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" name="analisa" id="analisa"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 d-lg-flex d-sm-block justify-content-around">
                        <div class="col-lg-5">
                            <label class="form-label-custom required small" for="konfirmasi">Konfirmasi</label>
                            <div class="input-group mb-3">
                                <textarea class="form-control input_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" name="konfirmasi" id="konfirmasi" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <label class="form-label-custom required small" for="improvement">Improvement</label>
                            <div class="input-group mb-3">
                                <textarea class="form-control input_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" name="improvement" id="improvement"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 d-lg-flex d-sm-block justify-content-around">
                        <div class="col-lg-5">
                            <label class="form-label-custom required small" for="rekomendasi">Hasil pemeriksaan dan rekomendasi</label>
                            <div class="input-group mb-3">
                                <textarea class="form-control input_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" name="rekomendasi" id="rekomendasi" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <label class="form-label-custom required small" for="note">Note</label>
                            <div class="input-group mb-3">
                                <textarea class="form-control input_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" name="note" id="note" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class=" modal-footer">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="save_audit()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal List Audit -->
<div class="modal" id="modal_list_audit" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">List Plan Audit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive" style="padding: 10px;">
                    <table id="dt_pa" class="table table-sm table-striped dataTable no-footer" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Auditor</th>
                                <th>PIC</th>
                                <th>Target</th>
                                <th>SOP/IK/MEMO</th>
                                <th>Subject Audit</th>
                                <th>Object Audit</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class=" modal-footer">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>