<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Deskripsi Page</p>
            </div>
            <div class="col col-sm-auto">
                <form method="POST" id="form_filter">
                    <!-- <div class="input-group input-group-md reportrange"> -->
                    <!-- <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar"> -->
                    <!-- <input type="hidden" name="start" value="" id="start" readonly />
                        <input type="hidden" name="end" value="" id="end" readonly /> -->

                    <!-- <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span> -->
                    <!-- </div> -->
                    <div class="form-floating">
                        <input type="text" class="form-control" name="periode" id="periode"
                            value="<?php echo date('Y-m') ?>" />
                        <label>Periode</label>
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
                            <i class="bi bi-wallet h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Denda & Reward</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                            <!-- addnew -->
                            <button type="button" class="btn btn-md btn-outline-theme" id="btn_rekomendasi_denda"><i
                                    class="bi bi-list"></i> Rekomen Denda</button>
                            <button type="button" class="btn btn-md btn-outline-theme" data-bs-toggle="modal"
                                data-bs-target="#modal_add_lock"><i class="bi bi-plus"></i> Add</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_list_denda" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Tipe</th>
                                    <th>Employee Name</th>
                                    <th>Company</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Nominal</th>
                                    <th>Reason</th>
                                    <th>Dokumen</th>
                                    <th>Jenis Input</th>
                                    <th>Periode</th>
                                    <th>Created at</th>
                                    <th>Created By</th>

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
<div class="modal fade" id="modal_add_lock" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_denda" enctype="multipart/form-data">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                        <p class="text-secondary small">Add Denda Karyawan</p>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="dropdown d-inline-block">
                            <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle"
                                role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="col-12 col-lg-12 col-xl-12 mb-4">
                        <h6 class="title">Detail Denda <span class="text-danger" style="font-size: 9pt;">(*Wajib
                                diisi)</span></h6>
                        <div class="row">
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-person-fill-up"></i></span>
                                        <div class="form-floating">
                                            <select name="tipe" id="tipe" class="form-control">
                                                <option value="">-- Pilih Tipe</option>
                                                <option value="Konsekuensi Proaktif">Konsekuensi Proaktif</option>
                                                <option value="Konsekuensi Kelalaian">Konsekuensi Kelalaian</option>
                                                <option value="Konsekuensi Meeting">Konsekuensi Meeting</option>
                                            </select>
                                            <label>*Tipe</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-person-fill-up"></i></span>
                                        <div class="form-floating">
                                            <select name="karyawan" id="karyawan" class="form-control">
                                                <option value="#" data-placeholder="true">-- Choose Employee --</option>
                                                <?php foreach ($karyawan as $row): ?>
                                                    <option value="<?= $row->user_id ?>"
                                                        data-department_name="<?= $row->department_name ?>"
                                                        data-designation_name="<?= $row->designation_name ?>"
                                                        data-nominal="<?= $row->nominal ?>"><?= $row->employee_name ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>*Employee Name</label>
                                            <input type="hidden" id="user" name="user" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-building"></i></span>
                                        <div class="form-floating">
                                            <input type="text" name="department_name" id="department_name"
                                                class="form-control border-start-0" required readonly>
                                            <label>*Company & Department</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-person"></i></span>
                                        <div class="form-floating">
                                            <input type="text" name="designation_name" id="designation_name"
                                                class="form-control border-start-0" required readonly>
                                            <label>*Designation</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-wallet2"></i></span>
                                        <div class="form-floating">
                                            <input type="text" name="periode_denda" id="periode_denda"
                                                class="form-control border-start-0" value="<?php echo date('Y-m') ?>"
                                                required>
                                            <label>*Periode Denda</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-wallet2"></i></span>
                                        <div class="form-floating">
                                            <input type="text" name="nominal_denda" id="nominal_denda"
                                                class="form-control border-start-0"
                                                onkeyup="updateRupiah('nominal_denda')" required readonly>
                                            <label>*Nominal</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <textarea name="alasan" id="alasan" class="form-control border-start-0"
                                                cols="30" rows="5" style="min-height: 80px;" required></textarea>
                                            <label>*Reason</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <!-- devnew -->
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-files"></i></span>
                                        <div class="form-floating">
                                            <input type="file" name="dokumen" id="dokumen"
                                                class="form-control border-start-0">
                                            <label>*Document</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-theme" id="btn_save">Save</button>
                </div>
            </form>
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
                            <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle"
                                role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="col-12 col-lg-12 col-xl-12 mb-4">
                        <h6 class="title">Detail Lock <span class="text-danger" style="font-size: 9pt;">(*Wajib
                                diisi)</span></h6>
                        <div class="row">
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-person-fill-up"></i></span>
                                        <input type="hidden" id="e_id" name="e_id" class="form-control border-start-0"
                                            readonly>
                                        <div class="form-floating">
                                            <input type="text" id="e_karyawan" name="e_karyawan"
                                                class="form-control border-start-0" readonly>
                                            <label>*Employee Name</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <textarea name="e_alasan" id="e_alasan" class="form-control border-start-0"
                                                cols="30" rows="5" style="min-height: 80px;" readonly></textarea>
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
                    <button type="button" class="btn btn-md btn-outline-theme" onclick="save_unlock()"
                        id="btn_unlock">Unlock</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Update -->

<!-- addnew -->
<div class="modal fade" id="modal_list_rekomendasi" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="title_form_warning">Rekomendasi Denda</h6>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button"
                            aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="dt_rekomendasi_denda" class="table nowrap table-striped" width="100%">
                        <thead>
                            <tr>
                                <th>Karyawan</th>
                                <th>Status</th>
                                <th>Company</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Date of Join</th>
                                <th>Denda</th>
                                <th>Masa Kerja</th>
                                <th>Denda</th>
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

<div class="modal fade" id="modal_form_rekom_denda" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="title_form_warning">Add Denda (Rekomendasi)</h6>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button"
                            aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form id="form_add_denda_rekom" enctype="multipart/form-data">
                    <input type="hidden" name="penalty_id" id="penalty_id">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body">
                                    <figure class="coverimg rounded w-100 h-150 mb-3" id="profil">
                                        <img id="img_profil" class="w-100" alt="" style="display: none;">
                                    </figure>
                                    <h5 class="mb-1" id="text_karyawan"></h5>
                                    <p class="text-secondary mb-3" id="text_designation"></p>
                                    <div class="row gx-2 mb-2">
                                        <div class="col-lg-8">
                                            <div class="col-lg-12 col-sm-12 mb-2">
                                                <p class="text-secondary"><i
                                                        class="bi bi-book avatar avatar-24 me-1"></i> Company <br>
                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b
                                                            id="text_company">...</b></span>
                                                </p>
                                            </div>
                                            <div class="col-lg-12 col-sm-12 mb-2">
                                                <p class="text-secondary"><i
                                                        class="bi bi-clock avatar avatar-24 me-1"></i> Department <br>
                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b
                                                            id="text_department">...</b></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="col-lg-12 col-sm-12 mb-2">
                                                <p class="text-secondary"><i
                                                        class="bi bi-clock avatar avatar-24 me-1"></i> Date of Join <br>
                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b
                                                            id="text_date_of_joining">...</b></span>
                                                </p>
                                            </div>
                                            <div class="col-lg-12 col-sm-12 mb-2">
                                                <p class="text-secondary"><i
                                                        class="bi bi-clock avatar avatar-24 me-1"></i> Masa Kerja <br>
                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b
                                                            id="text_masa_kerja">...</b></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="row">
                                <div class="col-lg-12">

                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i
                                                    class="bi bi-wallet2"></i></span>
                                            <div class="form-floating">
                                                <select class="form-control slim-select border-custom"
                                                    name="status_denda" id="status_denda_rekom">
                                                    <option value="0">Waiting</option>
                                                    <option value="1">Accepted</option>
                                                    <option value="2">Rejected</option>
                                                </select>
                                                <label>*Status Rekomendasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 mt-2" id="div_reject_note"
                                    style="display: none;">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i
                                                    class="bi bi-card-text"></i></span>
                                            <div class="form-floating">
                                                <textarea name="reject_note" id="reject_note"
                                                    class="form-control border-start-0" cols="30" rows="5"
                                                    style="min-height: 80px;" required=""></textarea>
                                                <label>*Reject Note</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>


                                <div id="div_rekom" style="display: none;">
                                    <div class="col-12 col-md-12 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i
                                                        class="bi bi-wallet2"></i></span>
                                                <div class="form-floating">
                                                    <input type="text" name="periode_denda_rekom"
                                                        id="periode_denda_rekom" class="form-control border-start-0"
                                                        value="2025-03" required="">
                                                    <label>*Periode Denda</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>

                                    <div class="col-12 col-md-12 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i
                                                        class="bi bi-wallet2"></i></span>
                                                <div class="form-floating">
                                                    <input type="text" name="nominal_denda_rekom"
                                                        id="nominal_denda_rekom" class="form-control border-start-0"
                                                         required="" readonly>
                                                    <label>*Nominal Denda</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>

                                    <div class="col-12 col-md-12 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i
                                                        class="bi bi-card-text"></i></span>
                                                <div class="form-floating">
                                                    <textarea name="alasan_rekom" id="alasan_rekom"
                                                        class="form-control border-start-0" cols="30" rows="5"
                                                        style="min-height: 80px;" required=""></textarea>
                                                    <label>*Reason</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>

                                    <input type="hidden" name="id_user_denda_rekom" id="id_user_denda_rekom">
                                    <input type="hidden" name="id_rekomendasi" id="id_rekomendasi">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;"
                    data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="btn_save_denda_rekom" onclick="save_denda_rekom()"
                    class="btn btn-md btn-primary" style="display: none;">Save
                    <i class="bi bi-card-checklist"></i>
                </button>
            </div>
        </div>
    </div>
</div>