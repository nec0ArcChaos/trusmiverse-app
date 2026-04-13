<link href="<?= base_url() ?>assets/vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
<style>
#modal_add_berkas {
    overflow-y: scroll;
}

li {
    list-style: inherit;
}

ul {
    padding: 0;
    margin: 1rem;
}
</style>

</style>
<div class="row">
    <div class="col-sm-6">
    </div>
    <div class="col-sm-3 mb-3">
        <select class="form-control" id="sel_dept">
            <option value="" disabled selected>Select Department</option>
            <option value="0">All</option>
            <?php foreach ($get_departments as $key) { ?>
            <option value="<?= $key->department_id ?>"><?= $key->department_name ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-sm-3">
        <div class="input-group mb-3 input-primary" id="reportrange">
            <input type="text" class="form-control" id="range" style="cursor: pointer;" autocomplete="off">
            <input type="hidden" name="datestart" id="datestart">
            <input type="hidden" name="dateend" id="dateend">
            <span style="cursor: pointer;" onclick="show_data()" class="input-group-text">Filter</span>
        </div>
    </div>

</div>

<div class="row" style="margin-top: 10px;">
    <div class="col-12">
    <div class="card">
            <div class="card-header">
                <h4 class="card-title">Monitoring Job Profile</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10">
                    </div>
                    <div class="col-md-2 ms-auto">
                        <button type="button" class="btn btn-rounded btn-primary btn-sm" style="margin-bottom: 10px;" data-bs-toggle="modal" data-bs-target="#modal_add_interview">
                            <span class="btn-icon-start text-primary"><i class="fa fa-plus color-primary"></i>
                            </span>Add Data</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="dt_job_profile" class="table table-striped display nowrap" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Draft</th>
                                <!-- <th>Review</th> -->
                                <th>No. Document</th>
                                <th>Job Position</th>
                                <th>Grade</th>
                                <th>Department</th>
                                <th>Report To</th>
                                <th>Prepared By</th>
                                <th>Created Date</th>
                                <th>Release Date</th>
                                <th>Status Doc</th>
                                <th>Status Progress</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Interview-->
<div class="modal fade" id="modal_add_interview">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Interview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <form id="form_add_interview">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="me-sm-2">Document Type</label>
                            <select class="form-control select2" name="doc_type_id" id="doc_type_id" required>
                                <option value="" disabled selected>Select Document Type</option>
                                <option value="SM">Standar Mutu</option>
                                <option value="PR">Standar Operating Procedure</option>
                                <option value="IK">Work Instruction</option>
                                <option value="FM">Formulir</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="me-sm-2">Division</label>
                            <select class="form-control select2" name="div_id" id="div_id" required>
                                <option value="" disabled selected>Select Division</option>
                                <option value="OP">Operation</option>
                                <option value="PD">Production</option>
                                <option value="SP">Support</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="me-sm-2">Company</label>
                            <select class="form-control select2" name="company_id" id="company_id" required>
                                <option value="" disabled selected>Select Company</option>
                                <option value="0">All</option>
                                <?php foreach ($companies as $key) { ?>
                                <option value="<?= $key->company_id ?>"><?= $key->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="me-sm-2">Department</label>
                            <select class="form-control select2" name="departement_id" id="departement_id" required>
                                <option value="" disabled selected>Select Department</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="me-sm-2">Designation</label>
                            <select class="form-control select2" name="designation_id" id="designation_id" required>
                                <option value="" disabled selected>Select Designation</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="me-sm-2">Golongan</label>
                            <select class="form-control select2" name="add_golongan" id="add_golongan" required>
                                <option value="" disabled selected>Select Class</option>
                                <?php foreach ($golongan as $key) { ?>
                                <option value="<?= $key->level ?>"><?= $key->level ?> (<?= $key->role_name ?>)</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="me-sm-2">Report To</label>
                            <select class="form-control select2" name="add_report_to" id="add_report_to" required>
                                <option value="" disabled selected>Select Employee</option>
                                <?php foreach ($employee as $key) { ?>
                                <option value="<?= $key->user_id ?>"><?= $key->employee_name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="me-sm-2">Prepared By</label>
                            <select class="form-control select2" name="add_prepared_by" id="add_prepared_by" required>
                                <option value="" disabled selected>Select Employee</option>
                                <?php foreach ($employee as $key) { ?>
                                <option value="<?= $key->user_id ?>"><?= $key->employee_name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="me-sm-2">No. Document</label>
                            <input type="text" name="no_dok" id="no_doc" class="form-control input-default " placeholder="No. Document" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="me-sm-2">Release Date</label>
                            <input type="text" name="add_release_date" id="add_release_date" class="form-control input-default " placeholder="Release Date" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label class="me-sm-2">Note</label>
                            <input type="text" class="form-control input-default" name="note" placeholder="Input Note" id="note">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary" onclick="save_interview()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal add Berkas-->
<div class="modal fade" id="modal_add_berkas">
<div class="modal-dialog modal-lg" role="document" style="position: absolute;max-width: 75%;top: 0;bottom: 0;left: 0;right: 0;margin: auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Berkas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <form id="form_add_berkas">
                    <input type="hidden" id="no_jp" name="no_jp" value readonly>
                    <input type="hidden" id="input_report_to" name="report_to" value>
                    <input type="hidden" id="designation_id_" value>
                    <div class="card-body mb-3" style="margin-top: -20px;">
                        <p>No. Doc: <strong id="no_doc_e"></strong></p>
                        <div class="row">
                            <div class="col-sm-6">
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Job Position</strong>
                                        <span class="mb-0" id="jp_e"></span>
                                    </li>
                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Grade</strong>
                                        <span class="mb-0" id="grade_e"></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Department</strong>
                                        <span class="mb-0" id="dept_e"></span>
                                    </li>
                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Report To</strong>
                                        <span class="mb-0" id="report_to"></span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <h4 class="fs-20 mb-1">TUJUAN JABATAN</h4>
                                <textarea class="form-control input-default" name="tujuan" id="tujuan" placeholder="Uraikan tujuan jabatan" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label class="me-sm-2">Jumlah Bawahan</label>
                                <input class="form-control input-default" type="text" name="bawahan" id="bawahan"
                                    placeholder="contoh: >2">
                            </div>
                            <div class="col-sm-6">
                                <label class="me-sm-2">Area Coverage</label>
                                <input class="form-control input-default" type="text" name="area" id="area"
                                    placeholder="contoh: Nasional">
                            </div>
                        </div>

                        <!-- <div class="row mb-3">
                            <h4 class="fs-20 mb-1">WORK RELATIONSHIP</h4>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <label class="me-sm-2">Internal Relation</label>
                                    <textarea class="form-control ck" name="internal_relation" id="internal_relation"> </textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label class="me-sm-2">External Relation</label>
                                    <textarea class="form-control ck" name="external_relation" id="external_relation"> </textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <label class="me-sm-2">Tujuan Internal</label>
                                    <textarea class="form-control ck" name="tujuan_internal" id="tujuan_internal"> </textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label class="me-sm-2">Tujuan External</label>
                                    <textarea class="form-control ck" name="tujuan_external" id="tujuan_external"> </textarea>
                                </div>
                            </div>
                        </div> -->

                        <div class="row mb-3">
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <label class="me-sm-2">Pendidikan</label>
                                    <input class="form-control input-default" name="pendidikan" id="pendidikan"
                                        placeholder="contoh: S1 Jurusan Bisnis">
                                    <label class="me-sm-2 mt-3">Pengalaman</label>
                                    <textarea class="form-control ck" name="pengalaman" id="pengalaman"> </textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label class="me-sm-2">Kompetensi</label>
                                    <textarea class="form-control ck" name="kompetensi" id="kompetensi"> </textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <!-- <div class="col-sm-6">
                                    <label class="me-sm-2">Key Performance Indicator</label>
                                    <textarea class="form-control ck" name="kpi" id="kpi"> </textarea>
                                </div> -->
                                <div class="col-sm-6">
                                    <label class="me-sm-2">Authority</label>
                                    <textarea class="form-control ck" name="authority" id="authority"> </textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <h4 class="fs-20 mb-1">SCOPE OF RELATIONSHIP INTERNAL</h4>
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <button type="button" class="btn btn-sm btn-rounded btn-success"
                                                onclick="view_internal()">
                                                <span class="btn-icon-start text-success"> <i
                                                        class="fa fa-eye color-success"></i> </span>View Data
                                            </button>
                                        </div>
                                        <div class="col-sm-5">
                                            <button type="button" class="btn btn-sm btn-rounded btn-secondary"
                                                onclick="add_internal()">
                                                <span class="btn-icon-start text-secondary"> <i
                                                        class="fa fa-plus color-secondary"></i> </span>Add Data
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <h4 class="fs-20 mb-1">SCOPE OF RELATIONSHIP EXSTERNAL</h4>
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <button type="button" class="btn btn-sm btn-rounded btn-success"
                                                onclick="view_external()">
                                                <span class="btn-icon-start text-success"> <i
                                                        class="fa fa-eye color-success"></i> </span>View Data
                                            </button>
                                        </div>
                                        <div class="col-sm-5">
                                            <button type="button" class="btn btn-sm btn-rounded btn-secondary"
                                                onclick="add_external()">
                                                <span class="btn-icon-start text-secondary"> <i
                                                        class="fa fa-plus color-secondary"></i> </span>Add Data
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <h4 class="fs-20 mb-1">SCOPE OF RESPONSIBILITIES</h4>
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <button type="button" class="btn btn-sm btn-rounded btn-success"
                                                onclick="view_job_task()">
                                                <span class="btn-icon-start text-success"> <i
                                                        class="fa fa-eye color-success"></i> </span>View Data
                                            </button>
                                        </div>
                                        <div class="col-sm-5">
                                            <button type="button" class="btn btn-sm btn-rounded btn-secondary"
                                                onclick="add_job_task()">
                                                <span class="btn-icon-start text-secondary"> <i
                                                        class="fa fa-plus color-secondary"></i> </span>Add Data
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <h4 class="fs-20 mb-1">SCOPE OF KPI</h4>
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <button type="button" class="btn btn-sm btn-rounded btn-success" onclick="view_kpi()">
                                                <span class="btn-icon-start text-success"> <i class="fa fa-eye color-success"></i> </span>View Data
                                            </button>
                                        </div>
                                        <div class="col-sm-5">
                                            <button type="button" class="btn btn-sm btn-rounded btn-secondary" onclick="add_kpi()">
                                                <span class="btn-icon-start text-secondary"> <i class="fa fa-plus color-secondary"></i> </span>Add Data
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary" onclick="update_interview()">Save Draft</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_review">
    <div class="modal-dialog modal-lg" role="document"
        style="position: absolute;max-width: 75%;top: 0;bottom: 0;left: 0;right: 0;margin: auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Review Job Profile <span id="label_review"></span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item d-flex px-0 justify-content-between">
                                <strong>No Dok.</strong>
                                <input type="hidden" id="departement_id_rv" value="" name="departement_id_rv">
                                <input type="hidden" id="no_jp_rv" value="">
                                <input type="hidden" id="prepared_by" value="">
                                <span class="mb-0" id="rv_no_jp">5436346346</span>
                            </li>
                            <li class="list-group-item d-flex px-0 justify-content-between">
                                <strong>Job Position</strong>
                                <span class="mb-0" id="rv_desig">IT Programmer</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item d-flex px-0 justify-content-between">
                                <strong>Departement</strong>
                                <span class="mb-0" id="rv_dept">Bisnis Improve</span>
                            </li>
                            <li class="list-group-item d-flex px-0 justify-content-between">
                                <strong>Grade</strong>
                                <span class="mb-0" id="rv_grade">SUpervisor</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-6">

                    </div>
                    <div class="col-sm-6">

                        <div class="row">
                            <div class="col-9">
                            <select class="form-control select2" name="pic" id="pic_rev" required>
                                <option value="sdfa" disabled selected>Select PIC</option>
                                

                            </select>
                            </div>
                            <div class="col-3">
                            <button type="button" class="btn btn-primary btn-sm" disabled id="set_pic" onclick="set_pic()">Set</button>
                            </div>
                        </div>
                            
                            
                        
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-responsive-md table-bordered table-striped" id="dt_review">
                            <thead>
                                <tr>
                                    <th class="text-center"><strong>Status</strong></th>
                                    <th class="text-center"><strong>Nama</strong></th>
                                    <th class="text-center"><strong>Note</strong></th>
                                    <th class="text-center"><strong>Created at</strong></th>
                                    <th class="text-center"><strong>Aksi</strong></th>
                                </tr>
                            </thead>
                            <!-- <tbody id="v_job_task">
                        </tbody> -->
                        </table>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm light" data-bs-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-sm btn-primary" onclick="bagikan()">Bagikan</button> -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_history">
    <div class="modal-dialog modal-xs" role="document"
        style="position: absolute;top: 0;bottom: 0;left: 0;right: 0;margin: auto;z-index:200">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">History Review</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div>
                        <p>Nama : <span id="label_history"></span></p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-responsive-md table-bordered table-striped table-sm" id="dt_history">
                            <thead>
                                <tr>
                                    <th class="text-center"><strong>Status</strong></th>
                                    <th class="text-center"><strong>Note</strong></th>
                                    <th class="text-center"><strong>Created at</strong></th>
                                    <!-- <th class="text-center"><strong>Aksi</strong></th> -->
                                </tr>
                            </thead>
                            <!-- <tbody id="v_job_task">
                        </tbody> -->
                        </table>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm light" data-bs-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-sm btn-primary" onclick="bagikan()">Bagikan</button> -->
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Scope Of Responsibilty-->
<div class="modal fade" id="modal_add_resp">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Scope Of Responsibilty</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body" style="margin-top: -20px;">
                <form id="form_add_resp">
                    <input type="hidden" id="no_jp_resp" name="no_jp">
                    <input type="hidden" id="id_designation_resp" name="designation_id">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label class="me-sm-2">Tugas</label>
                            <input class="form-control input-default" name="tugas" id="tugas"
                                placeholder="Uraikan tugas pokok disni">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label class="me-sm-2">Aktifitas</label>
                            <textarea class="form-control ck" name="aktifitas" id="aktifitas"> </textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary" onclick="save_job_task()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal View Scope Of Responsibilty-->
<div class="modal fade" id="modal_view_resp">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Scope Of Responsibilty</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body" style="margin-top: -20px;">
                <input type="hidden" id="no_jp_v">
                <div class="table-responsive">
                    <table class="table table-responsive-md table-bordered table-striped" id="dt_job_task">
                        <thead>
                            <tr>
                                <th class="text-center"><strong>#</strong></th>
                                <th class="text-center"><strong>Tugas</strong></th>
                                <th class="text-center"><strong>Aktifitas</strong></th>
                            </tr>
                        </thead>
                        <!-- <tbody id="v_job_task">
                        </tbody> -->
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Scope Of Key Performance Indicator-->
<div class="modal fade" id="modal_add_kpi">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Scope Of Key Performance Indicator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body" style="margin-top: -20px;">
                <form id="form_add_kpi">
                    <input type="hidden" id="no_jp_kpi" name="no_jp" readonly>
                    <input type="hidden" id="id_designation_kpi" name="designation_id">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label class="me-sm-2">Nama KPI</label>
                            <textarea class="form-control ck" name="nama_kpi" id="nama_kpi"> </textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label class="me-sm-2">Bobot</label>
                            <input class="form-control input-default" name="bobot_kpi" id="bobot_kpi"
                                placeholder="Bobot hanya angka">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary" onclick="save_kpi()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal View Scope Of Key Performance Indicator-->
<div class="modal fade" id="modal_view_kpi">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Scope Of Key Performance Indicator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body" style="margin-top: -20px;">
                <input type="hidden" id="no_jp_v" readonly>
                <div class="table-responsive">
                    <table class="table table-responsive-md table-bordered table-striped" id="dt_kpi">
                        <thead>
                            <tr>
                                <th class="text-center"><strong>#</strong></th>
                                <th class="text-center"><strong>Nama KPI</strong></th>
                                <th class="text-center"><strong>Bobot</strong></th>
                            </tr>
                        </thead>
                        <!-- <tbody id="v_job_task">
                        </tbody> -->
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Scope Of Relationship Internal-->
<div class="modal fade" id="modal_add_internal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Scope Of Relationship Internal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body" style="margin-top: -20px;">
                <form id="form_add_internal">
                    <input type="hidden" id="no_jp_internal" name="no_jp" readonly>
                    <input type="hidden" id="id_designation_internal" name="designation_id">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label class="me-sm-2">Hubungan</label>
                            <input class="form-control input-default" name="hubungan_internal" id="hubungan_internal"
                                placeholder="Hubungan dengan..">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label class="me-sm-2">Tujuan</label>
                            <textarea class="form-control ck" name="tujuan_internal" id="tujuan_internal"> </textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary" onclick="save_internal()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal View Scope Of Relationship Internal-->
<div class="modal fade" id="modal_view_internal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Scope Of Relationship Internal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body" style="margin-top: -20px;">
                <input type="hidden" id="no_jp_v" readonly>
                <div class="table-responsive">
                    <table class="table table-responsive-md table-bordered table-striped" id="dt_internal">
                        <thead>
                            <tr>
                                <th class="text-center"><strong>#</strong></th>
                                <th class="text-center"><strong>Hubungan</strong></th>
                                <th class="text-center"><strong>Tujuan</strong></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Scope Of Relationship External-->
<div class="modal fade" id="modal_add_external">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Scope Of Relationship External</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body" style="margin-top: -20px;">
                <form id="form_add_external">
                    <input type="hidden" id="no_jp_external" name="no_jp" readonly>
                    <input type="hidden" id="id_designation_external" name="designation_id">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label class="me-sm-2">Hubungan</label>
                            <input class="form-control input-default" name="hubungan_external" id="hubungan_external"
                                placeholder="Hubungan dengan..">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label class="me-sm-2">Tujuan</label>
                            <textarea class="form-control ck" name="tujuan_external" id="tujuan_external"> </textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary" onclick="save_external()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal View Scope Of Relationship External-->
<div class="modal fade" id="modal_view_external">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Scope Of Relationship External</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body" style="margin-top: -20px;">
                <input type="hidden" id="no_jp_v" readonly>
                <div class="table-responsive">
                    <table class="table table-responsive-md table-bordered table-striped" id="dt_external">
                        <thead>
                            <tr>
                                <th class="text-center"><strong>#</strong></th>
                                <th class="text-center"><strong>Hubungan</strong></th>
                                <th class="text-center"><strong>Tujuan</strong></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>