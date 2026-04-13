<main class="main mainheight">
    <div class="container-fluid mb-4">
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
                        <div class="col-12">
                            <div class="float-start">
                                <div class="row">
                                    <div class="col-auto">
                                        <i class="bi bi-book h5 avatar avatar-40 bg-light-theme rounded"></i>
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <h6 class="fw-medium mb-0"><?= $pageTitle; ?></h6>
                                    </div>
                                </div>

                            </div>


                            <!-- data-bs-toggle="modal" data-bs-target="#modal_add_pembelajar"  -->
                            <div class="col-sm-12 col-md-12 col-lg-3 float-lg-end">
                                <button type="button" class="btn btn-md btn-primary mt-2" onclick="add_pembelajar()" style="width:100%">
                                    <i class="bi bi-plus"></i> Add New
                                </button>
                            </div>

                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col col-sm-auto">
                            <form method="POST" id="form_filter">
                                <div class="input-group input-group-md reportrange">
                                    <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                                    <input type="hidden" name="start" value="<?= date("Y-m-01"); ?>" id="start" />
                                    <input type="hidden" name="end" value="<?= date("Y-m-t"); ?>" id="end" />
                                    <a href="javascript:void(0)" class="input-group-text text-secondary bg-none" id="titlecalandershow" onclick="filter_data()"><i class="bi bi-search"></i></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_sharing_leader" class="table table-sm table-striped dataTable no-footer" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="small text-nowrap">#</th>
                                    <th class="small text-nowrap">ID</th>
                                    <th class="small text-nowrap">Periode</th>
                                    <th class="small text-nowrap">Nama</th>
                                    <th class="small text-nowrap">Jabatan</th>
                                    <th class="small text-nowrap">Judul Materi</th>
                                    <th class="small text-nowrap">Klasifikasi</th>
                                    <th class="small text-nowrap">Point yg diterapkan di pekerjaan</th>
                                    <th class="small text-nowrap">Evidence</th>
                                    <th class="small text-nowrap">Peserta</th>
                                    <th class="small text-nowrap">File Materi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>

                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- <div class="mt-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-start">
                                <div class="row">
                                    <div class="col-auto">
                                        <i class="bi bi-book h5 avatar avatar-40 bg-light-theme rounded"></i>
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <h6 class="fw-medium mb-0">Resume</h6>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_resume_pembelajar" class="table table-sm table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>W1</th>
                                    <th>W2</th>
                                    <th>W3</th>
                                    <th>W4</th>
                                    <th>W5</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div> -->

    <!-- <div class="mt-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-start">
                                <div class="row">
                                    <div class="col-auto">
                                        <i class="bi bi-book h5 avatar avatar-40 bg-light-theme rounded"></i>
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <h6 class="fw-medium mb-0">Resume v.2</h6>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_resume_pembelajar_2" class="table table-sm table-striped text-nowrap" style="width:100%">
                            <thead id="dt_resume_head">
                                <tr>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>W1</th>
                                    <th>W2</th>
                                    <th>W3</th>
                                    <th>W4</th>
                                    <th>W5</th>
                                </tr>
                            </thead>
                            <tbody id="dt_resume_body"></tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div> -->
    <?php //if ($this->session->userdata('user_id') == 1) {
    ?>
    <div class="mt-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-start">
                                <div class="row">
                                    <div class="col-auto">
                                        <i class="bi bi-book h5 avatar avatar-40 bg-light-theme rounded"></i>
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <h6 class="fw-medium mb-0">Resume v.3</h6>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_resume_pembelajar_3" class="table table-sm table-striped text-nowrap" style="width:100%">
                            <thead id="dt_resume_head_3">
                                <tr>
                                    <th>Nama</th>
                                    <th>Company</th>
                                    <th>Jabatan</th>
                                    <th>W1</th>
                                    <th>W2</th>
                                    <th>W3</th>
                                    <th>W4</th>
                                    <th>W5</th>
                                </tr>
                            </thead>
                            <tbody id="dt_resume_body_3"></tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php //}
    ?>


</main>

<!-- Modal Add -->
<div class="modal fade" id="modal_add_pembelajar" aria-labelledby="modal_add_pembelajar_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_add_pembelajar">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_add_pembelajar_label">Form</h6>
                        <p class="text-secondary small">Sharing Leader </p>
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
                    <!-- <div class="row">

                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="mb-2">
                                <select name="soft_skill" id="soft_skill" class="">
                                </select>
                                <label class="form-label-custom required small" for="soft_skill">PIC</label>
                            </div>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-12 col-lg-12 col-xl-12 mb-4">
                            <label class="form-label-custom required small" for="judul">Sharing Title</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text bi bi-file-earmark-font" style="background-color: #F5F5F5;border: 1px solid #ddd;"></span>
                                <input type="text" class="form-control" name="judul" id="judul" placeholder="Title" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                            </div>

                            <label class="form-label-custom required small" for="klasifikasi">Classification</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text bi bi-person-check-fill" style="background-color: #F5F5F5;border: 1px solid #ddd;"></span>
                                <select name="klasifikasi" id="klasifikasi" class="" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;width:100% !important;">
                                </select>
                            </div>
                            <label class="form-label-custom required small" for="klasifikasi">Peserta</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text bi bi-person-check-fill" style="background-color: #F5F5F5;border: 1px solid #ddd;"></span>
                                <select name="peserta[]" id="peserta" class="" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;width:100% !important;" multiple>
                                    <!-- <option value="" selected disabled>-- Pilih Peserta --</option> -->
                                    <?php foreach($peserta as $item) :?>
                                        <option value="<?= $item->user_id ?>"><?= $item->nama ?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>

                            <label class="form-label-custom required small" for="impact">Impact</label>
                            <textarea name="impact" id="impact" class="form-control" style="height: 100px;"></textarea>

                            <label class="form-label-custom required small" for="lampiran">Photo</label>
                            <div id="input_lampiran">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="">File Materi</label>
                            <input type="file" name="file_materi" class="form-control">
                        </div>
                    </div>
                    <h6 class="title"><input type="checkbox" name="addition" id="addition"> <label for="addition">Berhubungan dengan pekerjaan ?</label></h6>
                    <div class="row div_addition" style="display: none;">
                        <!-- addnew -->
                        <div class="col-12 col-md-12 mb-2">
                            <div class="form-group mb-1 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-list"></i></span>
                                    <div class="form-floating">
                                        <select name="id_project" id="project" class="form-control">
                                            <option value="#">-- Divisi --</option>
                                            <?php foreach ($project as $row) : ?>
                                                <option value="<?= $row->id_project ?>"><?= $row->project ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label>Divisi <i class="text-danger">*</i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-6 mb-2">
                            <div class="form-group mb-1 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-list"></i></span>
                                    <div class="form-floating">
                                        <select name="id_pekerjaan" id="pekerjaan" class="form-control">
                                            <option value="#" selected disabled>-- SO --</option>

                                        </select>
                                        <label>SO <i class="text-danger">*</i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-6 mb-2">
                            <div class="form-group mb-1 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-list"></i></span>
                                    <div class="form-floating">
                                        <select name="id_sub_pekerjaan" id="sub_pekerjaan" class="form-control">
                                            <option value="#" selected disabled>-- SI --</option>
                                        </select>
                                        <label>SI <i class="text-danger">*</i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 mb-2">
                            <div class="form-group mb-1 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-list"></i></span>
                                    <div class="form-floating">
                                        <select name="id_detail_pekerjaan[]" id="detail_pekerjaan" class="form-control" multiple>

                                        </select>
                                        <label>Tasklist <i class="text-danger">*</i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-md btn-primary" id="btn_save" onclick="save_pembelajar()">Save <i class="bi bi-clipboard-check-fill"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->




<!-- Modal Add Confirm-->
<div class="modal fade" id="modalAddConfirm" tabindex="-1" aria-labelledby="modalAddConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddConfirmLabel">Form</h6>
                    <p class="text-secondary small">Overtime Request </p>
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
                    <h6 class="title">Are you sure ?</h6>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md btn-outline-theme" id="btn_save_confirm" onclick="save_request()">Yes, Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add Confirm -->


<!-- Modal Update Confirm-->
<div class="modal fade" id="modalUpdateConfirm" tabindex="-1" aria-labelledby="modalUpdateConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalUpdateConfirmLabel">Form</h6>
                    <p class="text-secondary small">Overtime Request </p>
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
                    <h6 class="title">Are you sure ?</h6>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md btn-outline-theme" id="btn_udpate_confirm" onclick="confirm_update_request()">Yes, Update</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Update Confirm -->

<!-- Modal Delete Confirm-->
<div class="modal fade" id="modalDeleteConfirm" tabindex="-1" aria-labelledby="modalDeleteConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalDeleteConfirmLabel">Form</h6>
                    <p class="text-secondary small">Delete Request </p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-danger dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <h6 class="title">Are you sure ?</h6>
                    <input type="hidden" id="d_time_request_id">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md btn-danger" id="btn_udpate_confirm" onclick="confirm_delete_request()">Yes, Delete</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Delete Confirm -->



<!-- Modal Request List -->
<div class="modal fade" id="modal_list_request" aria-labelledby="modal_list_request_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_list_request">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_list_request_label">List</h6>
                        <p class="text-secondary small">Overtime Request</p>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="dropdown d-inline-block">
                            <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">

                    <div class="row mt-3">
                        <div class="col col-sm-auto">
                            <div class="input-group input-group-md reportrange">
                                <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;">
                                <input type="hidden" name="start" value="" id="start_list" />
                                <input type="hidden" name="end" value="" id="end_list" />
                                <a href="javascript:void(0)" class="input-group-text text-secondary bg-none" onclick="dt_pembelajar_list(1)"><i class="bi bi-search"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" style="padding: 10px;">
                                <table id="dt_pembelajar_list" class="table table-sm table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Overtime Requests</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Request List -->


<!-- Modal Approve Confirm-->
<div class="modal fade" id="modalApproveConfirm" tabindex="-1" aria-labelledby="modalApproveConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalApproveConfirmLabel">Form</h6>
                    <p class="text-secondary small">Approve Request </p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-danger dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <h6 class="title">Are you sure ?</h6>
                    <input type="hidden" id="d_time_request_id">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md btn-danger" id="btn_udpate_confirm" onclick="confirm_approve_request()">Yes, Approve</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Approve Confirm -->