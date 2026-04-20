<main class="main mainheight">
    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-archive h5 avatar avatar-40 bg-light-theme rounded"></i>
                                </div>
                                <div class="col-auto align-self-center">
                                    <h6 class="fw-medium">Inventory</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row justify-content-end">
                                <div class="col-auto">
                                    <button type="button" class="btn btn-theme" data-bs-toggle="modal" data-bs-target="#modal_request">
                                        <i class="bi bi-card-text"></i> Request
                                    </button>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-theme" data-bs-toggle="modal" data-bs-target="#modal_add">
                                        <i class="bi bi-plus-circle"></i> Add Inven.
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="table_sop" class="table table-sm table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>REVIEW</th>
                                <th>COMPANY</th>
                                <th style="width:20%">DEPARTMENT</th>
                                <th>DESIGNATION</th>
                                <th>JENIS DOC</th>
                                <th>NO DOC</th>
                                <th>TGL TERBIT</th>
                                <th>TGL UPDATE</th>
                                <th>NAMA DOC</th>
                                <th>STATUS</th>
                                <th>FILE</th>
                                <th>WORD</th>
                                <th>DESC.</th>
                                <th>DISCCUSS</th>
                                <th>DRAFT</th>
                                <th>CREATED BY</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="modal_review">
    <div class="modal-dialog modal-lg" role="document" style="position: absolute;max-width: 75%;top: 0;bottom: 0;left: 0;right: 0;margin: auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Review SOP Inventory<span id="label_review"></span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item d-flex px-0 justify-content-between">
                                <strong>Nama Dokumen</strong>
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
                                <strong>Jenis</strong>
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
    <div class="modal-dialog modal-xs" role="document" style="position: absolute;top: 0;bottom: 0;left: 0;right: 0;margin: auto;z-index:200">
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

<!-- Modal Add SOP-->
<div class="modal fade" id="modal_add">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add Inventory</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <form id="form_sop">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Company</label>
                        <div class="col-sm-4">
                            <select class="form-control select2" name="company" id="select_company">
                                <option value="" disabled selected>-- Select Company --</option>
                                <?php foreach ($companies as $row) : ?>
                                    <option value="<?php echo $row->company_id ?>"><?php echo $row->name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <label class="col-sm-2 col-form-label">Type Department</label>
                        <div class="col-sm-4">
                            <select class="form-control select2" name="type_department" id="type_department">
                                <option value="1" selected>Single Department</option>
                                <option value="2">Multi Department</option>
                                <option value="3">All Department</option>
                            </select>
                            <input type="hidden" id="tot_sd">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label single_department">Department</label>
                        <div class="col-sm-10 single_department">
                            <select class="form-control select2" name="department" id="select_department">
                                <option value="" disabled selected>-- Select Department --</option>
                            </select>
                            <input type="hidden" id="tot_sd">
                        </div>

                        <label class="col-sm-2 col-form-label multi_department d-none">Department</label>
                        <div class="col-sm-10 multi_department d-none">
                            <select class="form-control select2" name="department_multi[]" id="select_department_multi" multiple>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label single_designation">Designation</label>
                        <div class="col-sm-10 single_designation">
                            <select class="form-control select2" name="designation[]" id="select_designation" multiple>
                            </select>
                            <input type="hidden" id="tot_ssd">
                        </div>

                        <label class="col-sm-2 col-form-label label-designation-multi d-none">Designation</label>
                        <div class="col-sm-10 col-designation-multi mt-1 d-none">
                            <select class="form-control select2" name="designation_multi[]" id="select_designation_multi_dept" multiple>
                            </select>
                            <input type="hidden" id="tot_ssd_multi_dept">
                        </div>
                    </div>

                    <hr>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Jenis Dokumen</label>
                        <div class="col-sm-4">
                            <select class="form-control select2" name="jenis_doc">
                                <option value="" disabled selected>-- Pilih Jenis Dokumen --</option>
                                <option value="Instruksi Kerja">Instruksi Kerja</option>
                                <option value="Standar">Standar</option>
                                <option value="SOP">SOP</option>
                                <option value="Form">Form</option>
                                <option value="Memo">Memo</option>
                                <option value="Job Profile">Job Profile</option>
                                <option value="Flowchart">Flowchart</option>
                            </select>
                        </div>
                        <label class="col-sm-2 col-form-label">No Dokumen</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="no_doc">
                        </div>
                    </div>



                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tgl Terbit</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="tgl_terbit" id="tbt">
                        </div>
                        <label class="col-sm-2 col-form-label">Tgl Update</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="tgl_update" id="upd">
                        </div>
                    </div>

                    <div class="form-group row" id="memo_add">
                        <label class="col-sm-2 col-form-label">Start Date</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="start_date" id="start_date">
                        </div>
                        <label class="col-sm-2 col-form-label">End Date</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="end_date" id="end_date">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nama Dok</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama_doc">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">File</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" name="file">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Word</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" name="word" accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="save_add">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_request" style="overflow-y: auto;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Request Permohonan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <form id="form_request">

                    <div class="row mb-3 bg-primary py-3">
                        <div class="col-sm-12">
                            <label class="me-sm-2 text-white" for="#pilih_dokumen"><b>Pilih Dokumen</b></label>
                            <select class="form-control select2" name="pilih_dokumen" id="pilih_dokumen">
                                <option value="" disabled selected>-- Pilih Dokumen --</option>
                                <option value="1">Standar Operasi Prosedur (SOP)</option>
                                <option value="2">Job Profile (JP)</option>
                                <option value="3">Intruksi Kerja (IK)</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row company mb-3" style="display:none;">
                        <label class="col-sm-2 col-form-label" for="#select_company_req"><b>Company</b></label>
                        <div class="col-sm-4">
                            <select class="form-control select2 bg-primary text-white" name="company_req" id="select_company_req">
                                <option value="" disabled selected>-- Select Company --</option>
                                <?php foreach ($companies as $row) : ?>
                                    <option value="<?php echo $row->company_id ?>"><?php echo $row->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <input type="hidden" name="no_jp" value="<?= $no_jp ?>">
                            <input type="hidden" name="no_doc_jp" value="">
                            <!-- <small class="text-danger invalid" hidden>Please provide a valid input.</small> -->
                        </div>

                        <label class="col-sm-2 col-form-label type_dept"><b>Type Department</b></label>
                        <div class="col-sm-4 type_dept">
                            <select class="form-control select2" name="type_department_req" id="type_department_req">
                                <option value="" selected disabled>-- Type Departemen --</option>
                                <option value="1">Single Department</option>
                                <!-- <option value="2">Multi Department</option>
                                <option value="3">All Department</option> -->
                            </select>
                            <input type="hidden" id="tot_sd_req">
                        </div>
                    </div>
                    <div class="form-group row mb-3 row_dept" style="display:none">
                        <label class="col-sm-2 col-form-label multi_department_req"><b>Department</b></label>
                        <div class="col-sm-4 multi_department_req">

                            <select class="form-control select2" name="department_multi_req[]" id="select_department_multi_req" multiple>
                                <!-- <option value="" disabled selected>Select Department</option> -->
                            </select>
                        </div>
                        <label class="col-sm-2 col-form-label single_department_req" style="display:none">
                            <b>Department</b>
                        </label>
                        <div class="col-sm-4 single_department_req">
                            <select class="form-control select2" name="department_req" id="select_department_req">
                                <option value="" selected disabled>-- Pilih Department --</option>
                            </select>
                        </div>
                        <label class="col-sm-2 designation col-form-label"><b>Designation</b></label>
                        <div class="col-sm-4 designation">
                            <select class="form-control select2" name="designation_req" id="select_designation_req">
                                <option value="" disabled selected>-- Select Designation --</option>
                            </select>
                            <input type="hidden" id="tot_ssd_req">

                        </div>
                    </div>
                    <div class="form-group row grade mb-3" style="display:none">
                        <label class="col-sm-2 col-form-label"><b>Division</b></label>
                        <div class="col-sm-4">

                            <select class="form-control select2 grade" name="division" id="division" required>
                                <option value="" disabled selected>Select Division</option>
                                <option value="OP">Operation</option>
                                <option value="PD">Production</option>
                                <option value="SP">Support</option>
                            </select>
                        </div>
                        <label class="col-sm-2 col-form-label"><b>Golongan</b></label>
                        <div class="col-sm-4">

                            <select class="form-control select2 grade" name="grade" id="grade" required>
                                <option value="" disabled selected>Select Class</option>
                                <?php foreach ($golongan as $key) { ?>
                                    <option value="<?= $key->level ?>"><?= $key->level ?> (<?= $key->role_name ?>)</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group row grade" style="display:none">
                        <label class="col-sm-2 col-form-label"><b>Document Type</b></label>
                        <div class="col-sm-10">
                            <select class="form-control select2" name="doc_type_id" id="doc_type_id" required>
                                <option value="" disabled selected>Select Document Type</option>
                                <option value="SM">Standar Mutu</option>
                                <option value="PR">Standar Operating Procedure</option>
                                <option value="IK">Work Instruction</option>
                                <option value="FM">Formulir</option>
                            </select>
                        </div>
                    </div>
                    <hr class="nama_dokumen" style="display:none">
                    <div class="row nama_dokumen mb-3" style="display:none">
                        <div class="col-sm-6">
                            <label class="me-sm-2" for="#nama_dokumen"><b>Nama Dokumen</b> </label>
                            <input type="text" id="nama_dokumen" name="nama_dokumen" class="form-control" value="" style="border-width:1.5px; border-color: #D1CCCF; border-radius:20px" placeholder="Tulisankan Nama Dokumen">
                        </div>
                        <div class="col-sm-6">
                            <label class="me-sm-2" for="#jadwal_diskusi"><b>Jadwal Diskusi</b> <span data-bs-toggle="popover" data-bs-title="Jadwal diskusi" data-bs-content="jadwal diskusi itu min. 3 hari setelah pengajuan">
                                    <i class="bi bi-info-circle"></i>
                                </span></label>
                            <input type="date" id="jadwal_diskusi" class="form-control" value="<?= date('Y-m-d', strtotime('+3 Days')) ?>" style="border-width:1.5px; border-color: #D1CCCF; border-radius:20px" min="<?= date('Y-m-d', strtotime('+3 Days')) ?>" name="jadwal_diskusi">
                        </div>
                    </div>
                    <div class="row penjelasan mb-3" style="display:none">
                        <div class="col-sm-12">
                            <label class="me-sm-2" for="#penjelasan"><b>Penjelasan</b> <span data-bs-toggle="popover" data-bs-title="Penjelasan" data-bs-content="Jelaskan dokumen apa yang sedang di ajukan">
                                    <i class="bi bi-info-circle"></i>
                                </span></label>
                            <input type="text" name="penjelasan" id="penjelasan" class="form-control" value="" style="border-width:1.5px; border-color: #D1CCCF; border-radius:20px">
                        </div>
                    </div>
                    <div class="row draf mb-3" style="display:none">


                        <label class="col-sm-2 col-form-label"><b>Upload Draf</b> </label>
                        <div class="col-sm-4">
                            <input type="file" name="draf" id="draf" class="form-control">
                        </div>

                    </div>
                    <div class="row jobprofile mb-3" style="display:none">
                        <div class="col-sm-12">
                            <label class="me-sm-2" for="#tujuan"><b>Tujuan Jabatan</b> </label>
                            <textarea type="text" id="tujuan" name="tujuan" class="form-control" rows="3" value="" style="border-width:1.5px; border-color: #D1CCCF; border-radius:20px; height:auto"></textarea>
                        </div>
                    </div>
                    <div class="row jobprofile mb-3" style="display:none">
                        <div class="col-sm-6">
                            <label class="me-sm-2" for="#jumlah_bawahan"><b>Jumah Bawahan</b> </label>
                            <input type="text" id="jumlah_bawahan" name="jumlah_bawahan" class="form-control" value="" style="border-width:1.5px; border-color: #D1CCCF; border-radius:20px" placeholder="contoh: >2">
                        </div>
                        <div class="col-sm-6">
                            <label class="me-sm-2" for="#area"><b>Area Coverage</b> </label>
                            <input type="text" id="area" name="area" class="form-control" value="" style="border-width:1.5px; border-color: #D1CCCF; border-radius:20px" placeholder="contoh: Nasional">
                        </div>
                    </div>
                    <div class="row jobprofile mb-3" style="display:none">
                        <div class="col-sm-6">
                            <label class="me-sm-2" for="#pendidikan"><b>Pendidikan</b> </label>
                            <input type="text" id="pendidikan" name="pendidikan" class="form-control mb-3" value="" style="border-width:1.5px; border-color: #D1CCCF; border-radius:20px" placeholder="contoh : S1 Jurusan Bisnis">
                            <label class="me-sm-2" for="#pengalaman"><b>Pengalaman</b> </label>
                            <textarea name="pengalaman" id="pengalaman" class="form-control ck"></textarea>
                        </div>
                        <div class="col-sm-6">
                            <label class="me-sm-2" for="#kompetensi"><b>Kompetensi</b> </label>
                            <textarea name="kompetensi" id="kompetensi" class="form-control ck"></textarea>
                        </div>
                    </div>
                    <div class="row jobprofile mb-3" style="display:none">
                        <div class="col-sm-6">
                            <label class="me-sm-2" for="#authority"><b>Authority</b> <span data-bs-toggle="popover" data-bs-title="Authority" data-bs-content="Kekuatan atau hak yang diberikan kepada individu dalam sebuah perusahaan untuk membuat keputusan, mengambil tindakan, dan mengarahkan aktivitas sesuai dengan tujuan organisasi.">
                                    <i class="bi bi-info-circle"></i>
                                </span></label>
                            <textarea name="authority" id="authority" class="form-control ck"></textarea>
                        </div>
                        <div class="col-sm-6">


                        </div>
                    </div>
                </form>


            </div>
            <div class="modal-footer">
                <button class="btn" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="save_request" disabled>Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit SOP-->
<div class="modal fade" id="modal_edit">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Inventory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <form id="form_edit_sop">
                    <input type="hidden" class="form-control" name="id_sop" id="id_sop">
                    <input type="hidden" class="form-control" name="data_pic" value="">
                    <!-- <input type="hidden" class="form-control" name="created_by" value=""> -->

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Company</label>
                        <div class="col-sm-4">
                            <select class="form-control select2" name="company" id="select_company_edit">
                                <option value="" id="company" selected>-- Select Company --</option>
                                <?php foreach ($companies as $row) : ?>
                                    <option value="<?php echo $row->company_id ?>"><?php echo $row->name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <label class="col-sm-2 col-form-label">Type Department</label>
                        <div class="col-sm-4">
                            <select class="form-control select2" name="type_department" id="type_department_edit">
                                <option value="1" selected>Single Department</option>
                                <option value="2">Multi Department</option>
                                <option value="3">All Department</option>
                            </select>
                            <input type="hidden" id="tot_sd">
                        </div>

                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label multi_department_edit" style="display: none;">Department multi</label>
                        <div class="col-sm-4 multi_department_edit" style="display: none;">
                            <select class="form-control select2" name="department_multi[]" id="select_department_multi_edit" multiple>
                            </select>
                        </div>

                        <label class="col-sm-2 col-form-label single_department_edit">Department single</label>
                        <div class="col-sm-4 single_department_edit">
                            <select class="form-control select2" name="department" id="select_department_edit">
                            </select>
                        </div>

                        <label class="col-sm-2 col-form-label single_designation_edit">Designation</label>
                        <div class="col-sm-4 single_designation_edit">
                            <!-- edit by Ade -->
                            <select class="form-control select2" name="designation[]" id="select_designation_edit" multiple>
                                <!-- <option value="" id="designation" selected>-- Pilih Designation --</option> -->
                            </select>
                        </div>

                        <!-- add by Ade -->
                        <label class="col-sm-2 col-form-label multi_designation_edit" style="display: none;">Designation multi</label>
                        <div class="col-sm-4 multi_designation_edit" style="display: none;">
                            <select class="form-control select2x" name="designation_multi[]" id="select_designation_multi_edit" multiple="multiple">
                            </select>
                        </div>
                    </div>

                    <!-- <div class="form-group row">
                        <div class="col-sm-6"></div>
                        <label class="col-sm-2 col-form-label">TEST</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="ade_designations" id="ade_designations">
                        </div>
                    </div> -->

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Jenis Dokumen</label>
                        <div class="col-sm-4">
                            <select class="form-control select2" name="jenis_doc" id="jenis_doc_edit">
                                <option value="" selected>-- Pilih Jenis Dokumen --</option>
                                <option value="Instruksi Kerja">Instruksi Kerja</option>
                                <option value="Standar">Standar</option>
                                <option value="SOP">SOP</option>
                                <option value="Form">Form</option>
                                <option value="Memo">Memo</option>
                                <option value="Job Profile">Job Profile</option>
                                <option value="Flowchart">Flowchart</option>
                            </select>
                        </div>
                        <label class="col-sm-2 col-form-label">No Dokumen</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="no_doc" id="no_doc">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tgl Terbit</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="tgl_terbit" id="tbt_e">
                        </div>
                        <label class="col-sm-2 col-form-label">Tgl Update</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="tgl_update" id="upd_e">
                        </div>
                    </div>

                    <div class="form-group row" id="memo_edit">
                        <label class="col-sm-2 col-form-label">Start Date</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="start_date" id="start_date_e">
                        </div>
                        <label class="col-sm-2 col-form-label">End Date</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="end_date" id="end_date_e">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nama Dok</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama_doc" id="nama_doc">
                            <input type="hidden" class="form-control" name="status" id="status" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">File</label>
                        <div class="col-sm-4">
                            <small class="text-danger" id="label_file"></small>
                            <input type="file" class="form-control" name="file" id="file" accept="application/pdf">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Word</label>
                        <div class="col-sm-4">
                            <small class="text-danger" id="label_word"></small>
                            <input type="file" class="form-control" name="word" id="word" accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="save_edit">Save & Review</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal fitur blast -->

<div class="modal fade" id="modal_blast">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Blast</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <form id="form_blast">
                    <div class="form-group row">
                        <input type="hidden" id="link_dokument" value="" name="link_dokument" readonly>
                        <input type="hidden" id="nama_dokument" value="" name="nama_dokument" readonly>
                        <label class="col-sm-2 col-form-label">Karyawan</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="no_hp[]" id="select_employee" multiple>
                                <?php foreach ($employees as $row) : ?>
                                    <option value="<?php echo $row->no_hp ?>" data-nama="<?= $row->employee_name; ?>"><?php echo $row->employee_name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label class="me-sm-2" for="#tujuan">Text Message</label>
                            <textarea type="text" id="message" name="message" value="" class="form-control" placeholder="isi pesan anda..." rows="3" style="border-width:1.5px; border-color: #D1CCCF; border-radius:20px; height:150px;">Terlampir document rilis Organization Development (BPM, SOP, JP, IK)

PT RAJA SUKSES PROPERTINDO

STANDAR OPERASIONAL PROSEDUR (SESUAI DENGAN JENIS DOKUMEN)

Divisi 	: (Sesuai Dengan Divisi Yang dipilih)
Departement	: (Sesuai Dengan Divisi Yang dipilih)</textarea>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button class="btn" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="save_blast">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- end modal fitur blast -->

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
                            <input class="form-control input-default" name="hubungan_internal" id="hubungan_internal" placeholder="Hubungan dengan..">
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
<!-- modal view internal -->
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
                <button type="button" class="btn btn-danger btn-sm light" data-bs-dismiss="modal" onclick="close()">Close</button>
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
                            <input class="form-control input-default" name="hubungan_external" id="hubungan_external" placeholder="Hubungan dengan..">
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
                            <input class="form-control input-default" name="tugas" id="tugas" placeholder="Uraikan tugas pokok disni">
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
                            <input class="form-control input-default" name="bobot_kpi" id="bobot_kpi" placeholder="Bobot hanya angka">
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

<!-- Modal Detail SOP-->
<div class="modal fade" id="modal_detail">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Inventory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <table id="t_detail" class="table table-striped" style="width: 100%">
                    <thead>
                        <th>No Dokumen</th>
                        <th>Nama Dokumen</th>
                        <th></th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Link-->
<div class="modal fade" id="modal_link">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Relasi Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <form id="form_add_link">
                    <input type="hidden" class="form-control" name="id_sop" id="id_sop_link">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Dokumen</label>
                        <div class="col-sm-9">
                            <input type="text" id="nk" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Relasi Dokumen</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="nama_dokumen_link[]" id="rd_1">
                                <option value="" disabled selected>-- Pilih Dokumen --</option>
                                <?php foreach ($dd as $row) : ?>
                                    <option value="<?= $row->id_sop ?>"><?= $row->nama_dokumen ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" value="1" name="tot_inp" id="total_spo">
                    <div id="new_spo"></div>
                </form>
            </div>
            <script type="text/javascript">
                function add_link() {
                    var new_inp_no = parseInt($('#total_spo').val()) + 1;
                    var new_input = `<div class="form-group row" id="new_` + new_inp_no + `">` +
                        `<label class="col-sm-3 col-form-label"></label>` +
                        `<div class="col-sm-9">` +
                        `<select class="form-control" name="nama_dokumen_link[]" id="rd_` + new_inp_no + `">` +
                        `<option value="" disabled selected>-- Pilih Dokumen --</option>` +
                        `<?php foreach ($dd as $row) : ?>` +
                        `<option value="<?= $row->id_sop ?>"><?= $row->nama_dokumen ?></option>` +
                        `<?php endforeach ?>` +
                        `</select>` +
                        `</div>` +
                        `</div>` +
                        `<script type="text/javascript">$(document).ready(function() { $('#rd_` + new_inp_no +
                        `').select2({ dropdownParent: $("#modal_link") }); });</` + `script>`;
                    $('#new_spo').append(new_input);
                    $('#total_spo').val(new_inp_no)
                }

                function del_link() {
                    var last_chq_no = $('#total_spo').val();
                    if (last_chq_no > 1) {
                        $('#new_' + last_chq_no).remove();
                        $('#hr_' + last_chq_no).remove();
                        $('#total_spo').val(last_chq_no - 1);
                    }
                }
            </script>

            <div class="modal-footer">
                <a id="add_link" class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="add_link()" style="padding-right: 11px; padding-top: 11px; padding-bottom: 11px; padding-left: 11px; font-size: 15px;"><i class="ti-plus"></i></a>
                <a id="del_link" class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="del_link()" style="padding-right: 11px; padding-top: 11px; padding-bottom: 11px; padding-left: 11px; font-size: 15px;"><i class="ti-minus"></i></a>
                <button class="btn" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="save_link">Save</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Progress-->
<div class="modal fade" id="modal_progress">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-footer">
                <div class="col">
                    <div class="progress">
                        <div class="progress-bar" id="bar_upload_1" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                            <span id="status_upload_1"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>