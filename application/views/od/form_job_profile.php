<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-8 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Form tambah data Job Profile</p>
            </div>
        </div>
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url('od_job_profile') ?>">Job Profile</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                        </ol>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <i class="bi bi-file-earmark-plus h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col">
                            <ul class="nav nav-tabs card-header-tabs" id="jpTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="detail-tab" data-bs-toggle="tab"
                                        data-bs-target="#detail-pane" type="button" role="tab"
                                        aria-controls="detail-pane" aria-selected="true">
                                        Detail
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="content-tab" data-bs-toggle="tab"
                                        data-bs-target="#content-pane" type="button" role="tab"
                                        aria-controls="content-pane" aria-selected="false">
                                        Isi Job Profile
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="approval-tab" data-bs-toggle="tab"
                                        data-bs-target="#approval-pane" type="button" role="tab"
                                        aria-controls="approval-pane" aria-selected="false">
                                        Approval
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="form_add_job_profile">
                        <div class="tab-content" id="jpTabContent">
                            <!-- ========== TAB: DETAIL ========== -->
                            <div class="tab-pane fade show active" id="detail-pane" role="tabpanel"
                                aria-labelledby="detail-tab" tabindex="0">
                                <div class="row">
                                    <!-- Judul -->
                                    <div class="col-12 col-md-8 mb-2">
                                        <div class="form-group mb-1 position-relative check-valid judul">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Masukkan judul utama untuk job profile ini">
                                                    <i class="bi bi-align-top"></i>
                                                </span>
                                                <div class="form-floating">
                                                    <input type="text" class="form-control border-start-0" name="judul"
                                                        id="judul" placeholder="Judul">
                                                    <label>Judul <b class="text-danger small">*</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Jenis (static) -->
                                    <div class="col-6 col-md-4 mb-2">
                                        <div class="form-group mb-1 position-relative check-valid judul">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Pilih jenis dokumen">
                                                    <i class="bi bi-broadcast"></i>
                                                </span>
                                                <div class="form-floating">
                                                    <select name="jenis" id="jenis" class="form-control">
                                                        <option value="" selected disabled>-Choose-</option>
                                                        <option value="SOP">SOP</option>
                                                        <option value="JP">Job Profile</option>
                                                        <option value="IK">Instruksi Kerja (IK)</option>
                                                    </select>
                                                    <label>Jenis <b class="text-danger small">*</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Categori (static) -->
                                    <div class="col-6 col-md-4 mb-2">
                                        <div class="form-group mb-1 position-relative check-valid judul">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"
                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                    title="Pilih kategori dokumen">
                                                    <i class="bi bi-broadcast"></i>
                                                </span>
                                                <div class="form-floating">
                                                    <select name="category" id="category" class="form-control">
                                                        <option value="" selected disabled>-Choose-</option>
                                                        <option value="Baru">Baru</option>
                                                        <option value="Revisi">Revisi</option>
                                                    </select>
                                                    <label>Categori <b class="text-danger small">*</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- No. Dokumen (hanya muncul jika Categori = Revisi) -->
                                    <div class="col-6 col-md-4" id="wrap_no_dokumen">
                                        <div class="form-group mb-1 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"
                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                    title="Masukkan No. Dokumen yang direvisi">
                                                    <i class="bi bi-file-earmark-text"></i>
                                                </span>
                                                <div class="form-floating">
                                                    <input type="text" class="form-control border-start-0"
                                                        name="no_dokumen" id="no_dokumen" placeholder="No. Dokumen">
                                                    <label>No. Dokumen <b class="text-danger small">*</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Priority -->
                                    <div class="col-6 col-md-4 mb-2 col-priority">
                                        <div class="form-group mb-1 position-relative check-valid judul">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"
                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                    title="Pilih prioritas">
                                                    <i class="bi bi-subtract"></i>
                                                </span>
                                                <div class="form-floating">
                                                    <select name="priority" id="priority" class="form-control">
                                                        <option value="" selected disabled>-Choose-</option>
                                                        <?php foreach ($master as $item): ?>
                                                            <?php if ($item->priority !== null): ?>
                                                                <option value="<?= $item->id ?>"><?= $item->priority ?></option>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <label>Priority <b class="text-danger small">*</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Company -->
                                    <div class="col-12 col-md-4 mb-2">
                                        <div class="form-group mb-1 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"
                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                    title="Pilih Company">
                                                    <i class="bi bi-building"></i>
                                                </span>
                                                <div class="form-floating">
                                                    <select id="company_id" name="company_id" class="form-control"
                                                        required>
                                                        <option value="" selected disabled>--Choose Company--</option>
                                                        <?php foreach ($companies as $company) { ?>
                                                            <option value="<?= $company->company_id; ?>">
                                                                <?= $company->name; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                    <label>Company <i class="text-danger">*</i></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Department -->
                                    <div class="col-12 col-md-8 mb-2">
                                        <div class="form-group mb-1 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"
                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                    title="Pilih Department">
                                                    <i class="bi bi-person-bounding-box"></i>
                                                </span>
                                                <div class="form-floating">
                                                    <select id="department_id" name="department_id[]"
                                                        class="form-control" multiple required>
                                                    </select>
                                                    <label>Department <i class="text-danger">*</i></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Role/Jabatan -->
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="form-group mb-1 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"
                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                    title="Pilih Role/Jabatan">
                                                    <i class="bi bi-person-bounding-box"></i>
                                                </span>
                                                <div class="form-floating">
                                                    <select id="role_id" name="role_id[]" class="form-control" multiple>
                                                        <?php foreach ($roles as $role) { ?>
                                                            <option value="<?= $role->role_id; ?>"><?= $role->role_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <label>Role/Jabatan</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- CC -->
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="form-group mb-1 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"
                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                    title="Pilih CC (Employee)">
                                                    <i class="bi bi-people"></i>
                                                </span>
                                                <div class="form-floating">
                                                    <select id="cc" name="cc[]" class="form-control" multiple>
                                                    </select>
                                                    <label>CC</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Expected Outcome -->
                                    <div class="col-12 mb-2">
                                        <div class="form-group mb-1 position-relative check-valid judul">
                                            <label>Expected Outcome <b class="text-danger small">*</b></label>
                                            <textarea name="tujuan" class="form-control border-custom" id="tujuan"
                                                rows="4" placeholder="Isikan tujuan atau expected outcome"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ========== TAB: ISI JOB PROFILE ========== -->
                            <div class="tab-pane fade" id="content-pane" role="tabpanel"
                                aria-labelledby="content-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-12">
                                        <textarea id="content-editor" name="content"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- ========== TAB: APPROVAL ========== -->
                            <div class="tab-pane fade" id="approval-pane" role="tabpanel"
                                aria-labelledby="approval-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="form-group mb-1 position-relative check-valid judul">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    title="Pilih Master Approval yang sudah ada">
                                                    <i class="bi bi-person-rolodex"></i>
                                                </span>
                                                <div class="form-floating">
                                                    <select name="approval" id="approval"
                                                        class="form-control border-start-0"></select>
                                                    <label>Approval <i class="text-danger">*</i></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2 d-flex align-items-center">
                                        <button type="button" class="btn btn-link mb-1" onclick="add_approval()"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Jika tidak ada, tambahkan manual dan pilih PIC Approval terkait">
                                            <i class="bi bi-patch-plus"></i> Baru Master Approval
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <div class="form-group mb-1 position-relative check-valid judul">
                                            <div class="input-group input-group-lg">
                                                <div class="form-floating">
                                                    <input type="text" name="diverifikasi" id="diverifikasi"
                                                        class="form-control border-start-0" readonly>
                                                    <label>Diverifikasi</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group mb-1 position-relative check-valid judul">
                                            <div class="input-group input-group-lg">
                                                <div class="form-floating">
                                                    <input type="text" name="disetujui" id="disetujui"
                                                        class="form-control border-start-0" readonly>
                                                    <label>Disetujui</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group mb-1 position-relative check-valid judul">
                                            <div class="input-group input-group-lg">
                                                <div class="form-floating">
                                                    <input type="text" name="mengetahui" id="mengetahui"
                                                        class="form-control border-start-0" readonly>
                                                    <label>Mengetahui</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="form-group mb-1 position-relative check-valid judul">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"
                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                    title="Tambahkan lampiran jika diperlukan (PDF/PNG/JPG/JPEG max 2MB)">
                                                    <i class="bi bi-file-arrow-up-fill"></i>
                                                </span>
                                                <div class="form-floating">
                                                    <input type="file" accept="application/pdf,.pdf,.png,.jpg,.jpeg"
                                                        id="file_lampiran" class="form-control lampiran"
                                                        name="file_lampiran">
                                                    <label>Lampiran (optional)</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-end">
                    <a href="<?= base_url('od_job_profile') ?>" class="btn btn-danger btn-sm light">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                    <button type="button" class="btn btn-sm btn-primary" onclick="save_form()">
                        <i class="bi bi-check2-circle"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal Baru Master Approval -->
<div class="modal fade" id="modal_add_approval" tabindex="-1" aria-labelledby="modalApprovalLabel" aria-hidden="true"
    data-bs-focus="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalApprovalLabel">Tambah Master Approval Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_add_approval">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="namaApproval" class="form-label">
                            Nama Approval <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control border-custom" id="namaApproval" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="diverifikasiOleh" class="form-label">Diverifikasi Oleh</label>
                        <select id="diverifikasiOleh" name="diverifikasi[]" multiple></select>
                    </div>
                    <div class="mb-3">
                        <label for="disetujuiOleh" class="form-label">Disetujui Oleh</label>
                        <select id="disetujuiOleh" name="disetujui[]" multiple></select>
                    </div>
                    <div class="mb-3">
                        <label for="mengetahuiOleh" class="form-label">Mengetahui Oleh</label>
                        <select id="mengetahuiOleh" name="mengetahui[]" multiple></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary me-1" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
