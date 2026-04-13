<div class="modal fade" id="modalShooting" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 pb-0">
                <div>
                    <span class="badge bg-success-subtle text-success mb-2">Review Budgeting</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body bg-light pt-4">

                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3" id="shooting_campaign_name">Campaign Title</h5>

                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-calendar me-1"></i> Timeline</label>
                                <div class="fw-semibold" id="shooting_timeline">-</div>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-calendar me-1"></i> Deadline</label>
                                <div class="fw-semibold" id="shooting_deadline">-</div>
                            </div>
                            <div class="col-md-2">
                                <label class="small text-muted"><i class="bi bi-flag me-1"></i> Priority</label>
                                <div id="shooting_priority">-</div>
                            </div>
                            <div class="col-md-2">
                                <label class="small text-muted"><i class="bi bi-person-badge me-1"></i> Placement</label>
                                <div id="shooting_placement">-</div>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-people me-1"></i> PIC</label>
                                <div class="d-flex align-items-center" id="shooting_pics">-</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion mb-3 shadow-sm" id="accordionBudgetHistory">

                    <!-- Campaign Brief -->
                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKolCamp">
                                <i class="bi bi-megaphone me-2 text-primary"></i> 1. Campaign Brief
                            </button>
                        </h2>
                        <div id="collapseKolCamp" class="accordion-collapse collapse" data-bs-parent="#accordionBudgetHistory">
                            <div class="accordion-body bg-white">
                                <div class="row g-3">

                                    <div class="col-12" id="shooting_influencer_container"></div>

                                    <div class="mt-3 pt-3 border-top">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <small class="text-muted fw-bold d-block mb-1" style="font-size:11px;">GOALS</small>
                                                <span class="small text-dark" id="shooting_hist_goals">-</span>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted fw-bold d-block mb-1" style="font-size:11px;">BIG IDEA</small>
                                                <span class="small text-dark fst-italic" id="shooting_hist_big_idea">-</span>
                                            </div>
                                            <div class="col-12">
                                                <small class="text-muted fw-bold d-block mb-1" style="font-size:11px;">DESKRIPSI</small>
                                                <div class="small text-secondary bg-light p-2 rounded border" id="shooting_hist_description">-</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted mb-1"><i class="bi bi-link-45deg"></i> Link Referensi</label>
                                        <div id="shooting_camp_links" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted mb-1"><i class="bi bi-paperclip"></i> File Referensi</label>
                                        <div id="shooting_camp_files" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Riset Campaign -->
                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKolRiset">
                                <i class="bi bi-search me-2 text-info"></i> 2. Hasil Riset Campaign
                            </button>
                        </h2>
                        <div id="collapseKolRiset" class="accordion-collapse collapse" data-bs-parent="#accordionBudgetHistory">
                            <div class="accordion-body bg-white">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted">Riset Report</label>
                                        <div class="p-2 bg-light border rounded small" id="shooting_riset_report">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted">Trend Analysis</label>
                                        <div class="p-2 bg-light border rounded small" id="shooting_trend_analysis">-</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="alert alert-warning py-1 px-2 small mb-0">
                                            <strong>Note SPV:</strong> <span id="shooting_riset_note">-</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted mb-1"><i class="bi bi-link-45deg"></i> Link Referensi</label>
                                        <div id="shooting_riset_links" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted mb-1"><i class="bi bi-paperclip"></i> File Referensi</label>
                                        <div id="shooting_riset_files" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Script -->
                    <div class="accordion-item border-0">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKolScript">
                                <i class="bi bi-file-earmark-text me-2 text-warning"></i> 3. Content Script
                            </button>
                        </h2>
                        <div id="collapseKolScript" class="accordion-collapse collapse" data-bs-parent="#accordionBudgetHistory">
                            <div class="accordion-body bg-white">
                                <div class="alert alert-success border-success p-2 mb-3 shadow-sm">
                                    <strong class="small">Catatan Approval Script:</strong>
                                    <span id="shooting_script_note" class="small fst-italic">-</span>
                                </div>
                                <div class="p-3 bg-white border rounded" id="shooting_naskah_final"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Riset KOL -->
                    <div class="accordion-item border-0">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKolRisetKol">
                                <i class="bi bi-search me-2 text-info"></i> 4. Riset KOL
                            </button>
                        </h2>
                        <div id="collapseKolRisetKol" class="accordion-collapse collapse" data-bs-parent="#accordionBudgetHistory">
                            <div class="accordion-body bg-white">
                                <div class="alert alert-success border-success p-2 mb-3 shadow-sm">
                                    <strong class="small">Catatan Approval:</strong>
                                    <span id="shooting_kol_note" class="small fst-italic">-</span>
                                </div>

                                <div class="row g-3" id="shooting_kol_container"></div>

                                <div class="col-md-6 mt-3">
                                    <label class="small fw-bold text-muted mb-1"><i class="bi bi-paperclip"></i> File</label>
                                    <div id="shooting_kol_files" class="d-flex flex-column gap-1">-</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Budgeting -->
                    <div class="accordion-item border-0">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKolBudgeting">
                                <i class="bi bi-cash me-2 text-success"></i> 5. Budgeting
                            </button>
                        </h2>
                        <div id="collapseKolBudgeting" class="accordion-collapse collapse" data-bs-parent="#accordionBudgetHistory">
                            <div class="accordion-body bg-white">
                                <div id="shooting_approval_history" class="mb-4" style="display:none;"></div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4"><label class="small text-muted mb-1">Penerima</label>
                                        <div class="form-control form-control-sm bg-light" id="shooting_penerima">-</div>
                                    </div>
                                    <div class="col-md-4"><label class="small text-muted mb-1">Pengaju</label>
                                        <div class="form-control form-control-sm bg-light" id="shooting_pengaju">-</div>
                                    </div>
                                    <div class="col-md-4"><label class="small text-muted mb-1">Kategori</label>
                                        <div class="form-control form-control-sm bg-light" id="shooting_kategori">-</div>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4"><label class="small text-muted mb-1">Tipe Bayar</label>
                                        <div class="form-control form-control-sm bg-light" id="shooting_tipe_bayar">-</div>
                                    </div>
                                    <div class="col-md-4"><label class="small text-muted mb-1">Bank</label>
                                        <div class="form-control form-control-sm bg-light" id="shooting_bank">-</div>
                                    </div>
                                    <div class="col-md-4"><label class="small text-muted mb-1">Rekening</label>
                                        <div class="form-control form-control-sm bg-light" id="shooting_rekening">-</div>
                                    </div>
                                </div>
                                <div class="p-3 border rounded bg-white mb-3 border-start border-5 border-primary">
                                    <div class="row align-items-center">
                                        <div class="col-md-4"><small class="text-muted d-block">Total Budget</small>
                                            <h4 class="fw-bold text-primary mb-0" id="shooting_total">Rp 0</h4>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Keperluan</small>
                                            <span class="fw-semibold text-dark" id="shooting_keperluan">-</span>
                                            <div class="small text-muted mt-1 fst-italic" id="shooting_note">

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Company</small>
                                            <span class="fw-semibold text-dark" id="shooting_company">-</span>
                                            <div class="small text-muted mt-1 fst-italic" id="shooting_project">-</div>
                                        </div>
                                        <div class="mb-3"><label class="small fw-bold mb-1">Lampiran</label>
                                            <div id="shooting_file_container"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="card border-0 shadow-sm">
                    <form id="formShooting" class="form-control" enctype="multipart/form-data">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3 border-bottom pb-2">Form Shooting</h6>
                            <input type="hidden" id="shooting_campaign_id" name="campaign_id" />
                            <div class="row g-3 mb-3">
                                <div class="col-12"><label class="small text-muted mb-1">Lokasi</label>
                                    <input type="text" class="form-control form-control-sm" name="lokasi" id="lokasi" placeholder="Lokasi Shooting">
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-12">
                                    <label class="small text-muted mb-1">Output</label>
                                    <select id="outputSelect" name="output[]" multiple>
                                        <?php foreach ($akun as $data) : ?>
                                            <option value="<?= $data->id ?>"><?= $data->username ?> | <?= $data->type; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold small mb-2">Keterangan</label>
                                <textarea id="keterangan" class="summernote"></textarea>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="fw-bold small">Link Riset</label>
                                    <button type="button" id="addShootingLink" class="btn btn-xs btn-outline-primary py-0">+ Tambah Link</button>
                                </div>
                                <div id="shootingLinkContainer"></div>
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold small mb-2">File Riset (Lampiran)</label>
                                <div id="dropzoneShooting" class="dropzone border rounded bg-light text-center">
                                    <div class="dz-message" data-dz-message><span>Klik atau Drop file di sini</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-top-0 pt-0 pb-4 pe-4">
                            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary px-4" id="btnSaveShooting">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalReviewShooting" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 pb-0">
                <div>
                    <span class="badge bg-primary-subtle text-primary mb-2">Approval Shooting</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body bg-light pt-4">

                <input type="hidden" id="rv_shooting_campaign_id">
                <input type="hidden" id="rv_shooting_company_id">

                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3" id="rv_shooting_campaign_name">Loading...</h5>

                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-calendar me-1"></i> Timeline</label>
                                <div class="fw-semibold" id="rv_shooting_timeline">-</div>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-calendar me-1"></i> Deadline</label>
                                <div class="fw-semibold" id="rv_shooting_deadline">-</div>
                            </div>
                            <div class="col-md-2">
                                <label class="small text-muted"><i class="bi bi-flag me-1"></i> Priority</label>
                                <div id="rv_shooting_priority">-</div>
                            </div>
                            <div class="col-md-2">
                                <label class="small text-muted"><i class="bi bi-person-badge me-1"></i> Placement</label>
                                <div id="rv_shooting_placement">-</div>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-people me-1"></i> PIC</label>
                                <div class="d-flex align-items-center" id="rv_shooting_pics">-</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion mb-3 shadow-sm" id="accordionReviewShooting">

                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#rv_collapseCamp">
                                <i class="bi bi-megaphone me-2 text-primary"></i> 1. Campaign Brief
                            </button>
                        </h2>
                        <div id="rv_collapseCamp" class="accordion-collapse collapse" data-bs-parent="#accordionReviewShooting">
                            <div class="accordion-body bg-white">
                                <div id="rv_shooting_influencer_container" class="mb-3"></div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <small class="text-muted fw-bold d-block">GOALS</small>
                                        <span id="rv_shooting_hist_goals" class="small">-</span>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted fw-bold d-block">BIG IDEA</small>
                                        <span id="rv_shooting_hist_big_idea" class="small fst-italic">-</span>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted fw-bold d-block">DESKRIPSI</small>
                                        <div id="rv_shooting_hist_description" class="p-2 bg-light border rounded small">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted fw-bold d-block"><i class="bi bi-link-45deg"></i> Link Ref</small>
                                        <div id="rv_shooting_camp_links" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted fw-bold d-block"><i class="bi bi-paperclip"></i> File Ref</small>
                                        <div id="rv_shooting_camp_files" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#rv_collapseRiset">
                                <i class="bi bi-search me-2 text-info"></i> 2. Hasil Riset Campaign
                            </button>
                        </h2>
                        <div id="rv_collapseRiset" class="accordion-collapse collapse" data-bs-parent="#accordionReviewShooting">
                            <div class="accordion-body bg-white">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted">Riset Report</label>
                                        <div id="rv_shooting_riset_report" class="p-2 bg-light border rounded small">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted">Trend Analysis</label>
                                        <div id="rv_shooting_trend_analysis" class="p-2 bg-light border rounded small">-</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="alert alert-warning py-1 px-2 small mb-0">
                                            <strong>Note SPV:</strong> <span id="rv_shooting_riset_note">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#rv_collapseScript">
                                <i class="bi bi-file-earmark-text me-2 text-warning"></i> 3. Content Script
                            </button>
                        </h2>
                        <div id="rv_collapseScript" class="accordion-collapse collapse" data-bs-parent="#accordionReviewShooting">
                            <div class="accordion-body bg-white">
                                <div class="alert alert-success border-success p-2 mb-2 shadow-sm">
                                    <strong class="small">Note Approval:</strong> <span id="rv_shooting_script_note" class="small fst-italic">-</span>
                                </div>
                                <div id="rv_shooting_naskah_final" class="p-3 bg-white border rounded small"></div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#rv_collapseKol">
                                <i class="bi bi-people me-2 text-danger"></i> 4. Riset KOL
                            </button>
                        </h2>
                        <div id="rv_collapseKol" class="accordion-collapse collapse" data-bs-parent="#accordionReviewShooting">
                            <div class="accordion-body bg-white">
                                <div class="row g-3" id="rv_shooting_kol_container"></div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#rv_collapseBudget">
                                <i class="bi bi-cash me-2 text-success"></i> 5. Budgeting
                            </button>
                        </h2>
                        <div id="rv_collapseBudget" class="accordion-collapse collapse" data-bs-parent="#accordionReviewShooting">
                            <div class="accordion-body bg-white">
                                <div id="rv_shooting_approval_history_budget" class="mb-3"></div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted d-block">Total Budget</small>
                                        <h5 class="fw-bold text-primary" id="rv_shooting_total_budget">Rp 0</h5>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted d-block">Keperluan</small>
                                        <span id="rv_shooting_keperluan">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                </div>

                <div class="card border-0 shadow-sm mb-3 border-start border-5 border-primary">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-camera-reels me-2"></i>HASIL SHOOTING</h6>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="small text-muted fw-bold">Lokasi</label>
                                <div id="rv_res_lokasi" class="fw-semibold">-</div>
                            </div>
                            <div class="col-md-6">
                                <label class="small text-muted fw-bold">Output</label>
                                <div id="rv_res_output" class="d-flex flex-wrap gap-1">-</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small text-muted fw-bold">Keterangan / Laporan</label>
                            <div id="rv_res_keterangan" class="p-3 bg-white border rounded">-</div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="small text-muted fw-bold"><i class="bi bi-link"></i> Link Hasil</label>
                                <div id="rv_res_links" class="d-flex flex-column gap-1">-</div>
                            </div>
                            <div class="col-md-6">
                                <label class="small text-muted fw-bold"><i class="bi bi-paperclip"></i> File Lampiran</label>
                                <div id="rv_res_files" class="d-flex flex-column gap-1">-</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body bg-warning-subtle rounded">
                        <h6 class="fw-bold mb-3"><i class="bi bi-pencil-square me-2"></i>Form Approval & Assign Editing</h6>

                        <div class="mb-3">
                            <label class="small fw-bold">Catatan Approval</label>
                            <textarea class="form-control" id="rv_shooting_note_approve" rows="2" placeholder="Tulis catatan..."></textarea>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="small fw-bold">PIC Editing (Next) <span class="text-danger">*</span></label>
                                <select id="rv_shooting_pic_next" multiple></select>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold">Deadline Editing <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="rv_shooting_deadline_next" name="deadline_editing" placeholder="YYYY-MM-DD">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-3 pb-4 px-4" id="rv_shooting_actions">
                        <button type="button" class="btn btn-outline-danger me-auto" id="btnRejectShooting">
                            <i class="bi bi-arrow-counterclockwise"></i> Revisi
                        </button>
                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary px-4" id="btnApproveShooting">
                            <i class="bi bi-check-lg"></i> Approve
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>