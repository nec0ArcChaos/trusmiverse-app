<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Deskripsi Page</p>
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
            <div class="col-auto ps-0"></div>
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

    <!-- addnew wbdev -->
    <?php if (in_array($this->session->userdata('user_id'), [1, 61, 64, 68, 803])): ?>
        <div class="container-fluid">
            <!-- summary -->
            <div class="row">
                <div class="col-12 col-md-12 col-lg-4 col-xl column-set mb-4">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar avatar-40 rounded bg-secondary text-white">
                                        <i class="bi bi-people h5"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <p class="small text-secondary mb-1">Total Aduan</p>
                                    <h6 class="fw-medium mb-0" id="total_aduan"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4 col-xl column-set mb-4">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar avatar-40 rounded bg-yellow text-white">
                                        <i class="bi bi-clock h5"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <p class="small text-secondary mb-1">Waiting</p>
                                    <h6 class="fw-medium mb-0" id="total_aduan_waiting"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4 col-xl column-set mb-4">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar avatar-40 rounded bg-blue text-white">
                                        <i class="bi bi-clock h5"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <p class="small text-secondary mb-1">Working On</p>
                                    <h6 class="fw-medium mb-0" id="total_aduan_progres"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4 col-xl column-set mb-4">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar avatar-40 rounded bg-green text-white">
                                        <i class="bi bi-check2-square h5"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <p class="small text-secondary mb-1">Done</p>
                                    <h6 class="fw-medium mb-0" id="total_aduan_done"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4 col-xl column-set mb-4">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar avatar-40 rounded bg-red text-white">
                                        <i class="bi bi-x-square h5"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <p class="small text-secondary mb-1">Reject</p>
                                    <h6 class="fw-medium mb-0" id="total_aduan_reject"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4 col-xl column-set mb-4">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar avatar-40 rounded bg-blue text-white">
                                        <i class="bi bi-journal-check h5"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <p class="small text-secondary mb-1">Avg LT Done</p>
                                    <h6 class="fw-medium mb-0" id="avg_lt_done"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>

    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto mb-2">
                            <i class="bi bi-journal-text h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center mb-2">
                            <h6 class="fw-medium">List <?= $pageTitle; ?></h6>
                        </div>
                        <div class="col-auto-right" align="right">
                            <!-- wbdev -->
                            <!-- munculkan di akun yg xin_employes.whistleblower = 1 -->
                            <?php if (in_array($this->session->userdata('user_id'), $wb_pic_eskalasi)) : ?>
                                <button type="button" class="btn btn-md btn-outline-theme mb-2" onclick="list_wb_progres()"><i class="bi bi-hourglass-bottom"></i> List WB Progress</button>
                            <?php endif; ?>

                            <!-- munculkan hanya di akun pak Farhan -->
                            <?php if ($this->session->userdata('user_id') == 68 || $this->session->userdata('user_id') == 1 || $this->session->userdata('user_id') == 64) : ?>
                                <button type="button" class="btn btn-md btn-outline-warning mb-2" onclick="list_wb_waiting()"><i class="bi bi-clock"></i> List WB Waiting</button>
                            <?php endif; ?>

                            <button type="button" class="btn btn-md btn-outline-theme mb-2" onclick="add_wb()"><i class="bi bi-journal-plus"></i> Add <?= $pageTitle; ?></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_list_wb" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No WB</th>
                                    <th>Kategori</th>
                                    <th>Judul Laporan</th>
                                    <th>Department</th>
                                    <th>Employee</th>
                                    <th>Tgl Temuan</th>
                                    <th>Aktivitas</th>
                                    <th>Kronologi</th>
                                    <th>Lokasi</th>
                                    <th>Berhubungan</th>
                                    <th>Informasi</th>
                                    <th>Bukti</th>
                                    <th>Ekspektasi Akhir Penyelesaian</th>
                                    <th>Keterkaitan & Dampak</th>
                                    <th class="none">Pertanyaan</th>
                                    <!-- wbdev -->
                                    <th>Status Progres</th>
                                    <th>Kategori Aduan</th>
                                    <th>Status FU</th>
                                    <th>PIC Eskalasi</th>
                                    <th>Keterangan</th>
                                    <th>Dokumen Penyelesaian Eskalasi</th>
                                    <th>Alasan Reject</th>
                                    <th class="none">Created By</th>
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

<!-- add WB -->
<div class="modal fade" id="modal_add_wb" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-journal-text h5 avatar avatar-40 bg-light text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                    <p class="text-white small">Add <?= $pageTitle; ?></p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <!-- <a class="btn btn-link btn-square text-white dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" onclick="cancel()" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a> -->
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <div id="smartwizard2" class="mb-4">
                        <ul class="nav nav-fill">
                            <li class="nav-item">
                                <a class="nav-link">
                                    <div class="avatar avatar-40 rounded-circle mb-1">
                                        <i class="bi bi-1-square"></i>
                                    </div>
                                    <p>Tahap 1</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link">
                                    <div class="avatar avatar-40 rounded-circle mb-1">
                                        <i class="bi bi-2-square"></i>
                                    </div>
                                    <p>Tahap 2</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link">
                                    <div class="avatar avatar-40 rounded-circle mb-1">
                                        <i class="bi bi-3-square"></i>
                                    </div>
                                    <p>Tahap 3</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link">
                                    <div class="avatar avatar-40 rounded-circle mb-1">
                                        <i class="bi bi-4-square"></i>
                                    </div>
                                    <p>Tahap 4</p>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content mb-4">
                            <div id="step-1" class="tab-pane" role="tabpanel">
                                <div class="card border-0">
                                    <div class="card-body">
                                        <!-- Step content 1 -->
                                        <form id="form_tahap_1">
                                            <input type="hidden" name="id_wb" id="id_wb" value="">
                                            <div class="row">
                                                <div class="col-12 col-md-4 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid laporan">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-align-top"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control border-start-0 mt-2" name="laporan" id="laporan" placeholder="Judul">
                                                                <label style="font-weight: bold;">Judul Laporan <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                                <div class="col-12 col-md-4 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid department_id">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0 mt-2"><i class="bi bi-buildings"></i></span>
                                                            <div class="form-control spesial">
                                                                <label style="font-size:14px; font-weight: bold;">Department <b class="text-danger small">*</b></label>
                                                                <select name="department_id" id="department_id" class="form-control">
                                                                    <option data-placeholder="true" value="">-- Choose Department --</option>
                                                                    <?php foreach ($department as $item) { ?>
                                                                        <option value="<?= $item->department_id; ?>"><?= $item->nama_dep; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                                <div class="col-12 col-md-4 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid employee_id">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0 mt-2"><i class="bi bi-person-lines-fill"></i></span>
                                                            <div class="form-control spesial">
                                                                <label style="font-size:14px; font-weight: bold;">Employee <b class="text-danger small">*</b></label>
                                                                <select name="employee_id" id="employee_id" class="form-control">
                                                                    <option data-placeholder="true" value="">-- Choose Employee --</option>

                                                                </select>
                                                                <input type="hidden" id="user" name="user" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-6 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid tgl_temuan">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-event"></i></span>
                                                            <div class="form-floating">
                                                                <input type="date" class="form-control border-start-0 bg-white mt-2" name="tgl_temuan" id="tgl_temuan" placeholder="Date">
                                                                <label style="font-size: large; font-weight: bold;"><i class="bi bi-info-circle"></i> Tanggal Temuan<b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                                <div class="col-12 col-md-6 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid id_aktivitas">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-checklist"></i></span>
                                                            <div class="form-control spesial">
                                                                <label style="font-size:14px; font-weight: bold;">Aktivitas <b class="text-danger small">*</b></label>
                                                                <select name="id_aktivitas" id="id_aktivitas" class="form-control">
                                                                    <option data-placeholder="true">-- Choose Activity --</option>
                                                                    <?php foreach ($wb_aktivitas as $item) { ?>
                                                                        <option value="<?= $item->id_aktivitas; ?>"><?= $item->aktivitas; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                            <div class="row d-none" id="row_aktivitas_lainnya">
                                                <div class="col-12 col-md-12">
                                                    <div class="form-group mb-3 position-relative check-valid note_other">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0 mt-2"><i class="bi bi-pencil-square"></i></span>
                                                            <div class="form-floating">
                                                                <label class="form-check-label" style="font-weight: bold;">Note Lainnya <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                        <textarea name="note_other" id="note_other" class="form-control border-start-0 editor" cols="30" rows="5" style="min-height: 80px;" required></textarea>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-12">
                                                    <div class="form-group mb-3 position-relative check-valid kronologi">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0 mt-2"><i class="bi bi-pencil-square"></i></span>
                                                            <div class="form-floating">
                                                                <label class="form-check-label" style="font-weight: bold;">Kronologi <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                        <textarea name="kronologi" id="kronologi" class="form-control border-start-0 editor" cols="30" rows="5" style="min-height: 80px;" required></textarea>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="step-2" class="tab-pane" role="tabpanel">
                                <div class="card border-0">
                                    <div class="card-body">
                                        <!-- Step content 2 -->
                                        <form id="form_tahap_2" enctype="multipart/form-data">
                                            <input type="hidden" name="id_wb" id="id_wb_2">
                                            <div class="row">
                                                <div class="col-12 col-md-6 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid lokasi">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-geo-alt"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control border-start-0" name="lokasi" id="lokasi" placeholder="Lokasi">
                                                                <label style="font-weight: bold;">Lokasi <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                                <div class="col-12 col-md-6 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid kota">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-geo-alt"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control border-start-0" name="kota" id="kota" placeholder="Kota">
                                                                <label style="font-weight: bold;">Kota <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-3 mb-2">
                                                    <div class="mb-3 position-relative check-valid project">
                                                        <div class="input-group input-group-lg d-flex align-items-center">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-square" id="btn_show_hubungan" style="cursor: pointer;"></i></span>
                                                            <label style="font-size:13px; font-weight: bold;">Hubungan dengan Divisi / Perusahaan</label>
                                                            <input type="hidden" name="hubungan" id="hubungan" value="0">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-none" id="row_hubungan">
                                                <div class="col-12 col-md-6 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid company_terkait">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-people-fill"></i></span>
                                                            <div class="form-control spesial">
                                                                <label style="font-size:14px; font-weight: bold;">Company</label>
                                                                <select name="company_terkait" id="company_terkait" class="form-control" style="font-size:17px !important; padding-left:0px !important; padding-top:0px !important;">
                                                                    <option data-placeholder="true" value="">-- Choose Company --</option>
                                                                    <?php foreach ($company as $row) : ?>
                                                                        <option value="<?= $row->company_id ?>"><?= $row->nama_com ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                                <div class="col-12 col-md-6 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid department_terkait">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-people-fill"></i></span>
                                                            <div class="form-control spesial">
                                                                <label style="font-size:14px; font-weight: bold;">Department (Opsional)</label>
                                                                <select name="department_terkait" id="department_terkait" class="form-control" style="font-size:17px !important; padding-left:0px !important; padding-top:0px !important;">
                                                                    <option data-placeholder="true" value="">-- Choose Department --</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-12">
                                                    <div class="form-group mb-3 position-relative check-valid informasi">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                                            <div class="form-floating">
                                                                <label class="form-check-label" style="font-weight: bold;">Informasi <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                        <textarea name="informasi" id="informasi" class="form-control border-start-0 editor" cols="30" rows="5" style="min-height: 80px;" required></textarea>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-12 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid bukti">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-file-earmark"></i></span>
                                                            <div class="form-floating">
                                                                <input type="file" class="form-control border-start-0 mt-3" name="bukti" id="bukti">
                                                                <label style="font-size: large; font-weight: bold;">Bukti <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                            <!-- revnew -->
                                            <div class="row">
                                                <div class="col-12 col-md-12">
                                                    <div class="form-group mb-3 position-relative check-valid ekspektasi_akhir">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                                            <div class="form-floating">
                                                                <label class="form-check-label" style="font-weight: bold;">Ekspektasi Akhir Penyelesaian <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                        <textarea name="ekspektasi_akhir" id="ekspektasi_akhir" class="form-control border-start-0 editor" cols="30" rows="5" style="min-height: 80px;" required></textarea>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-12">
                                                    <div class="form-group mb-3 position-relative check-valid keterkaitan_dampak">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                                            <div class="form-floating">
                                                                <label class="form-check-label" style="font-weight: bold;">Keterkaitan & Dampak Dengan Saya <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                        <textarea name="keterkaitan_dampak" id="keterkaitan_dampak" class="form-control border-start-0 editor" cols="30" rows="5" style="min-height: 80px;" required></textarea>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="step-3" class="tab-pane" role="tabpanel">
                                <div class="card border-0">
                                    <div class="card-body">
                                        <!-- Step content 3 -->
                                        <form id="form_tahap_3">
                                            <input type="hidden" name="id_wb" id="id_wb_3">
                                            <div class="row">
                                                <div class="col-12 col-md-12 mb-2">
                                                    <div class="d-flex flex-column gap-3" id="container-pertanyaan">

                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="step-4" class="tab-pane" role="tabpanel">
                                <div class="card border-0">
                                    <div class="card-body" style="min-height: 50vh;">
                                        <!-- Step content 4 -->
                                        <form id="form_tahap_4">
                                            <input type="hidden" name="id_wb" id="id_wb_4">
                                            <div class="container-persetujuan">
                                                <div class="label-persetujuan">
                                                    <label for="persetujuan"><strong>Jika Anda membiarkan kotak di bawah ini tetap dicentang, laporan Anda akan dikirim secara anonim. Namun, jika Anda memilih setuju untuk memberikan informasi profil Anda, informasi tersebut akan terlihat oleh tim wistherblower</strong></label>
                                                </div>
                                                <div>
                                                    <input class="form-check-input" type="checkbox" id="persetujuan" name="persetujuan" value="1">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-success" style="margin-right:10px;" id="btn_finish" onclick="finish()">Finish</button>
                <button type="button" class="btn btn-md btn-outline-danger" id="btn_cancel" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- end add WB -->

<!-- Modal list wb waiting wbdev -->
<div class="modal fade" id="modal_list_wb_waiting" aria-labelledby="modal_add_request_label" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal_add_request_label">List</h6>
                    <p class="text-secondary small">Whistleblower Waiting</p>
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
                <div class="col-12 col-lg-12 col-xl-12 mb-0">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_list_wb_waiting" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No WB</th>
                                    <th>Status</th>
                                    <th>Kategori</th>
                                    <th>Judul Laporan</th>
                                    <th>Department</th>
                                    <th>Employee</th>
                                    <th>Bukti</th>
                                    <!-- <th>Kategori Aduan</th>
                                    <th>Status FU</th>
                                    <th>PIC Eskalasi</th> -->
                                    <th>Keterangan</th>
                                    <th>Proses At</th>
                                    <th>Proses By</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<!-- Modal list wb Progress wbdev -->
<div class="modal fade" id="modal_list_wb_progres" aria-labelledby="modal_add_request_label" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal_add_request_label">List</h6>
                    <p class="text-secondary small">Whistleblower Progress</p>
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
                <div class="col-12 col-lg-12 col-xl-12 mb-0">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_list_wb_progres" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No WB</th>
                                    <th>Status</th>
                                    <th>Kategori</th>
                                    <th>Judul Laporan</th>
                                    <th>Department</th>
                                    <th>Employee</th>
                                    <th>Bukti</th>
                                    <th>Kategori Aduan</th>
                                    <th>Status FU</th>
                                    <th>PIC Eskalasi</th>
                                    <th>Keterangan</th>
                                    <th>Dokumen Penyelesaian Eskalasi</th>
                                    <th>Proses At</th>
                                    <th>Proses By</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<!-- Modal  by Ade -->
<div class="modal fade" id="modal_detail_employee" aria-labelledby="modal_add_request_label" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="form_pass">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-eye h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_add_request_label">Show</h6>
                        <p class="text-secondary small">Detail Employee </p>
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
                    <div class="col-12 col-lg-12 col-xl-12 mb-0">
                        <h6 class="title title-form-emp">Input Password to Show</h6>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <!-- <input type="hidden" name="ed_id_task" id="ed_id_task" readonly> -->
                                <div id="show-form-pass">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-lock"></i></span>
                                            <div class="form-floating">
                                                <input type="password" name="password" id="password" required class="form-control border-start-0">
                                                <label>Password</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>
                                <div id="show-detail-emp" class="text-center d-none">
                                    Name : <strong><span id="emp_name"></span></strong><br>
                                    Username : <strong><span id="emp_username"></span></strong>
                                    <br><br>
                                    <img id="emp_foto" src="" alt="" style="width: 200px;">
                                </div>
                            </div>
                            <!-- <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-event"></i></span>
                                        <div class="form-floating">
                                            <input type="text" placeholder="Date" name="ed_end_date" id="ed_end_date" value="2024-12-19" required class="form-control border-start-0 edit-date">
                                            <label>End Date</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-md btn-primary" id="btn_submit" onclick="submit_pass()">Submit <i class="bi bi-floppy"></i></button>
                    <!-- <button type="button" style="display:none" class="btn btn-md btn-success" id="btn_update" onclick="update_request()">Update Request <i class="bi bi-floppy"></i></button> -->
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->

<!-- Modal update progres wbdev -->
<div class="modal fade" id="modal_update_progres_wb" tabindex="-1" aria-labelledby="modal_add_request_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_update_progres_wb" enctype="multipart/form-data">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_add_request_label">Update</h6>
                        <p class="text-secondary small">Progress Whistleblower </p>
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
                    <div class="col-12 col-lg-12 col-xl-12 mb-0">
                        <h6 class="title">Form</h6>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <input type="hidden" name="id_wb" id="id_wb_up" readonly>
                                <input type="hidden" id="list_wb_status" readonly>
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-clock"></i></span>
                                        <div class="form-floating">
                                            <select name="status_progres" id="status_progres" class="form-control border-start-0">
                                                <?php foreach ($wb_status as $row) { ?>
                                                    <option value="<?= $row->id ?>"><?= $row->status ?></option>
                                                <?php } ?>
                                            </select>
                                            <label style="font-size: large; font-weight: bold;">Status Progress <b class="text-danger small">*</b></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <!-- revnew -->
                            <div class="inputan-approve">
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-list"></i></span>
                                            <div class="form-floating">
                                                <select name="kategori_aduan" id="kategori_aduan" class="form-control border-start-0 kategori_aduan">
                                                    <option data-placeholder="true" value="">-- Pilih Kategori Aduan --</option>
                                                    <?php foreach ($wb_kategori_aduan as $row) { ?>
                                                        <option value="<?= $row->id ?>"><?= $row->kategori ?></option>
                                                    <?php } ?>
                                                </select>
                                                <label style="font-size: large; font-weight: bold;">Kategori Aduan <b class="text-danger small">*</b></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>
                                <div class="col-12 col-md-12 mb-2">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-lines-fill"></i></span>
                                            <div class="form-control">
                                                <label style="font-size:14px; font-weight: bold; color: gray;">PIC Eskalasi <b class="text-danger small">*</b></label>
                                                <select name="pic_escalation" id="pic_escalation" class="form-control">
                                                    <option data-placeholder="true" value="">-- Pilih PIC --</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-send"></i></span>
                                            <div class="form-floating">
                                                <select name="status_fu" id="status_fu" class="form-control border-start-0">
                                                    <option data-placeholder="true" value="">-- Pilih Status FU --</option>
                                                    <?php foreach ($wb_status_fu as $row) { ?>
                                                        <option value="<?= $row->id ?>"><?= $row->status_fu ?></option>
                                                    <?php } ?>
                                                </select>
                                                <label style="font-size: large; font-weight: bold;">Status FU <b class="text-danger small">*</b></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                            <div class="form-floating">
                                                <textarea name="keterangan" id="keterangan" class="form-control" cols="30" rows="10" style="min-height: 100px;" required></textarea>
                                                <label style="font-size: large; font-weight: bold;">Keterangan <b class="text-danger small">*</b></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>
                                <!-- updev -->
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-file-earmark"></i></span>
                                            <div class="form-floating">
                                                <input type="file" class="form-control border-start-0 mt-3" name="dokumen_penyelesaian" id="dokumen_penyelesaian">
                                                <label style="font-size: large; font-weight: bold;">Dokumen Penyelesaian Eskalasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>

                            </div>
                            <div class="inputan-reject">
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-list"></i></span>
                                            <div class="form-floating">
                                                <select name="alasan_reject" id="alasan_reject" class="form-control border-start-0 alasan_reject">
                                                    <option data-placeholder="true" value="">-- Pilih Alasan Reject --</option>
                                                    <?php foreach ($wb_alasan_reject as $row) { ?>
                                                        <option value="<?= $row->id ?>"><?= $row->alasan ?></option>
                                                    <?php } ?>
                                                </select>
                                                <label style="font-size: large; font-weight: bold;">Alasan Reject <b class="text-danger small">*</b></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-md btn-primary" id="btn_update" onclick="update_progres_wb()">Update <i class="bi bi-floppy"></i></button>
                    <button type="button" class="btn btn-md btn-danger revnew" id="btn_reject" onclick="reject_progres_wb()">Reject <i class="bi bi-floppy"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal update -->

<!-- Modal list History WB wbdev -->
<div class="modal fade" id="modal_history_wb" aria-labelledby="modal_add_request_label" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal_add_request_label">History</h6>
                    <p class="text-secondary small">Whistleblower</p>
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
                <div class="col-12 col-lg-12 col-xl-12 mb-0">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_history_wb" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No WB</th>
                                    <th>Status</th>
                                    <th>Kategori Aduan</th>
                                    <th>Status FU</th>
                                    <th>PIC Eskalasi</th>
                                    <th>Keterangan</th>
                                    <th>Proses At</th>
                                    <th>Proses By</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->