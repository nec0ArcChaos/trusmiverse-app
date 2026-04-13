<main class="main mainheight">
    <!-- <div class="container-fluid mb-4">
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
    </div> -->

    <div class="m-3">
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
                                                        <input type="text" class="form-control border-start-0" name="laporan" id="laporan" placeholder="Judul">
                                                        <label>Judul Laporan <b class="text-danger small">*</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback mb-3">Add valid data </div>
                                        </div>
                                        <div class="col-12 col-md-4 mb-2">
                                            <div class="form-group mb-3 position-relative check-valid department_id">
                                                <div class="input-group input-group-lg">
                                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-buildings"></i></span>
                                                    <div class="form-control spesial">
                                                        <label style="font-size:12px;">Department <b class="text-danger small">*</b></label>
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
                                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-lines-fill"></i></span>
                                                    <div class="form-control spesial">
                                                        <label style="font-size:12px;">Employee <b class="text-danger small">*</b></label>
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
                                                        <input type="date" class="form-control border-start-0 bg-white" name="tgl_temuan" id="tgl_temuan" placeholder="Date">
                                                        <label><i class="bi bi-info-circle"></i> Tanggal Temuan<b class="text-danger small">*</b></label>
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
                                                        <label style="font-size:12px;">Aktivitas <b class="text-danger small">*</b></label>
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
                                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                                    <div class="form-floating">
                                                        <label class="form-check-label">Note Lainnya <b class="text-danger small">*</b></label>
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
                                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                                    <div class="form-floating">
                                                        <label class="form-check-label">Kronologi <b class="text-danger small">*</b></label>
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
                                                        <label>Lokasi <b class="text-danger small">*</b></label>
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
                                                        <label>Kota <b class="text-danger small">*</b></label>
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
                                                    <label style="font-size:12px;">Hubungan dengan Divisi / Perusahaan</label>
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
                                                        <label style="font-size:12px;">Company</label>
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
                                                        <label style="font-size:12px;">Department (Opsional)</label>
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
                                                        <label class="form-check-label">Informasi <b class="text-danger small">*</b></label>
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
                                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-geo-alt"></i></span>
                                                    <div class="form-floating">
                                                        <input type="file" class="form-control border-start-0" name="bukti" id="bukti">
                                                        <label>Bukti <b class="text-danger small">*</b></label>
                                                    </div>
                                                </div>
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
        <div class="col-12 col-lg-12 col-xl-12 mb-4 text-end">
            <button type="button" class="btn btn-md btn-outline-success" style="margin-right:10px;" id="btn_finish" onclick="finish()">Finish</button>
            <button type="button" class="btn btn-md btn-outline-danger" id="btn_cancel" data-bs-dismiss="modal">Cancel</button>
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
                                                                <input type="text" class="form-control border-start-0" name="laporan" id="laporan" placeholder="Judul">
                                                                <label>Judul Laporan <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                                <div class="col-12 col-md-4 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid department_id">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-buildings"></i></span>
                                                            <div class="form-control spesial">
                                                                <label style="font-size:12px;">Department <b class="text-danger small">*</b></label>
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
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-lines-fill"></i></span>
                                                            <div class="form-control spesial">
                                                                <label style="font-size:12px;">Employee <b class="text-danger small">*</b></label>
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
                                                                <input type="date" class="form-control border-start-0 bg-white" name="tgl_temuan" id="tgl_temuan" placeholder="Date">
                                                                <label><i class="bi bi-info-circle"></i> Tanggal Temuan<b class="text-danger small">*</b></label>
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
                                                                <label style="font-size:12px;">Aktivitas <b class="text-danger small">*</b></label>
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
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                                            <div class="form-floating">
                                                                <label class="form-check-label">Note Lainnya <b class="text-danger small">*</b></label>
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
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                                            <div class="form-floating">
                                                                <label class="form-check-label">Kronologi <b class="text-danger small">*</b></label>
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
                                                                <label>Lokasi <b class="text-danger small">*</b></label>
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
                                                                <label>Kota <b class="text-danger small">*</b></label>
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
                                                            <label style="font-size:12px;">Hubungan dengan Divisi / Perusahaan</label>
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
                                                                <label style="font-size:12px;">Company</label>
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
                                                                <label style="font-size:12px;">Department (Opsional)</label>
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
                                                                <label class="form-check-label">Informasi <b class="text-danger small">*</b></label>
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
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-geo-alt"></i></span>
                                                            <div class="form-floating">
                                                                <input type="file" class="form-control border-start-0" name="bukti" id="bukti">
                                                                <label>Bukti <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
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