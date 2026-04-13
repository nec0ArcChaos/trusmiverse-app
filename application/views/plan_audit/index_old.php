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
                                    <button type="button" class="btn btn-primary" id="btn_add_audit"><i class="bi bi-person-workspace"></i>
                                        Add Audit Plan</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_pa" class="table table-sm table-striped dataTable no-footer" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Auditor</th>
                                    <th>SOP/IK/MEMO</th>
                                    <th>Subject Audit</th>
                                    <th>Object Audit</th>
                                    <!-- <th>Tools</th> -->
                                    <th>PIC</th>
                                    <th>Company</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Target</th>
                                    <th>Bobot %</th>
                                    <th>Tool</th>
                                    <th>Pemeriksaan</th>
                                    <th>PIC Name</th>
                                    <!-- <th>Improvement (10%)</th> -->
                                    <!-- <th>Note</th> -->
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
<div class="modal" id="modal_add_audit" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Plan Audit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_add_audit">
                    <div class="col-lg-12 d-lg-flex d-sm-block justify-content-between">
                        <div class="col-lg-2">
                            <label class="form-label-custom required small" for="periode">Periode</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control input_permintaan" name="periode" id="periode" value="<?= date("Y-m") ?>" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label-custom required small" for="auditor">Auditor</label>
                            <div class="input-group mb-3">
                                <select name="auditor" id="auditor" class="select_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label-custom required small" for="company">Perusahaan</label>
                            <div class="input-group mb-3">
                                <select name="company" id="company" class=" select_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" onchange="get_department()">
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label-custom required small" for="department">Departemen</label>
                            <div class="input-group mb-3">
                                <select name="department" id="department" class=" select_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" onchange="get_posisi()">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 d-lg-flex d-sm-block justify-content-between">
                        <div class="col-lg-2">
                            <label class="form-label-custom required small" for="target">Target</label>
                            <div class="input-group mb-3">
                                <select name="target" id="target" class="select_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                    <option selected disable> --Pilih Target-- </option>
                                    <option value="weekly"> Weekly </option>
                                    <option value="monthly"> Monthly </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label-custom required small" for="posisi">Posisi</label>
                            <div class="input-group mb-3">
                                <select name="posisi" id="posisi" class=" select_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" onchange="get_pic();get_dokumen_audit();">
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label-custom required small" for="pic">PIC</label>
                            <div class="input-group mb-3">
                                <select name="pic" id="pic" class=" select_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" multiple>
                                </select>
                                <input type="hidden" id="pic_hidden" name="pic_hidden">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label-custom required small" for="dokumen">Dokumen</label>
                            <div class="input-group mb-3">
                                <select name="dokumen" id="dokumen" class="select_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" multiple>
                                </select>
                                <input type="hidden" id="dokumen_hidden" name="dokumen_hidden">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 d-lg-flex d-sm-block justify-content-between">
                        <div class="col-lg-2">
                            <label class="form-label-custom required small" for="bobot">Bobot</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control input_permintaan" name="bobot" id="bobot" placeholder="bobot" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" min="0" max="100">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label-custom required small" for="subject">Subject</label>
                            <div class="input-group mb-3">
                                <textarea class="form-control input_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" name="subject" id="subject" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label-custom required small" for="object">Object</label>
                            <div class="input-group mb-3">
                                <textarea class="form-control input_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" name="object" id="object" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 d-lg-flex d-sm-block">
                        <div class="col-lg-4 offset-md-3">
                            <label class="form-label-custom required small" for="tools">Tools</label>
                            <div class="input-group mb-3">
                                <textarea class="form-control input_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" name="tools" id="tools"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4 offset-md-1">
                            <label class="form-label-custom required small" for="pemeriksaan">Pemeriksaan</label>
                            <div class="input-group mb-3">
                                <textarea class="form-control input_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" name="pemeriksaan" id="pemeriksaan" rows="5"></textarea>
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