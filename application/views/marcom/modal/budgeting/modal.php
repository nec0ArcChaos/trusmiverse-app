<div class="modal fade" id="modalBudgeting" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 pb-0">
                <div>
                    <span class="badge bg-warning-subtle text-warning mb-2">Input Budgeting</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bg-light pt-4">
                <input type="hidden" id="bg_campaign_id" />
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3" id="bg_campaign_name">Campaign Title</h5>

                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-calendar me-1"></i> Timeline</label>
                                <div class="fw-semibold" id="bg_timeline">-</div>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-calendar me-1"></i> Deadline</label>
                                <div class="fw-semibold" id="bg_deadline">-</div>
                            </div>
                            <div class="col-md-2">
                                <label class="small text-muted"><i class="bi bi-flag me-1"></i> Priority</label>
                                <div id="bg_priority">-</div>
                            </div>
                            <div class="col-md-2">
                                <label class="small text-muted"><i class="bi bi-person-badge me-1"></i> Placement</label>
                                <div id="bg_placement">-</div>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-people me-1"></i> PIC</label>
                                <div class="d-flex align-items-center" id="bg_pics">
                                    -
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion mb-3 shadow-sm" id="accordionKOLHistory">

                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKolCamp">
                                <i class="bi bi-megaphone me-2 text-primary"></i> 1. Campaign Brief
                            </button>
                        </h2>
                        <div id="collapseKolCamp" class="accordion-collapse collapse" data-bs-parent="#accordionKOLHistory">
                            <div class="accordion-body bg-white">
                                <div class="row g-3">

                                    <div class="col-12" id="bg_influencer_container"></div>
                                    <div class="mt-3 mb-3 pt-3 border-top">
                                        <div class="row g-3">
                                            <div class="col-md-6"><small class="text-muted fw-bold d-block mb-1" style="font-size: 11px;">GOALS</small><span class="small text-dark" id="bg_goals">-</span></div>
                                            <div class="col-md-6"><small class="text-muted fw-bold d-block mb-1" style="font-size: 11px;">BIG IDEA</small><span class="small text-dark fst-italic" id="bg_big_idea">-</span></div>
                                            <div class="col-12"><small class="text-muted fw-bold d-block mb-1" style="font-size: 11px;">DESKRIPSI</small>
                                                <div class="small text-secondary bg-light p-2 rounded border" id="bg_description">-</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted mb-1"><i class="bi bi-link-45deg"></i> Link Referensi</label>
                                        <div id="bg_camp_links" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted mb-1"><i class="bi bi-paperclip"></i> File Referensi</label>
                                        <div id="bg_camp_files" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKolRiset">
                                <i class="bi bi-search me-2 text-info"></i> 2. Hasil Riset Campaign
                            </button>
                        </h2>
                        <div id="collapseKolRiset" class="accordion-collapse collapse" data-bs-parent="#accordionKOLHistory">
                            <div class="accordion-body bg-white">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted">Riset Report</label>
                                        <div class="p-2 bg-light border rounded small" id="bg_riset_report">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted">Trend Analysis</label>
                                        <div class="p-2 bg-light border rounded small" id="bg_trend_analysis">-</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="alert alert-warning py-1 px-2 small mb-0">
                                            <strong>Note SPV:</strong> <span id="bg_riset_note">-</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted mb-1"><i class="bi bi-link-45deg"></i> Link Referensi</label>
                                        <div id="bg_riset_links" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted mb-1"><i class="bi bi-paperclip"></i> File Referensi</label>
                                        <div id="bg_riset_files" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKolScript">
                                <i class="bi bi-file-earmark-text me-2 text-warning"></i> 3. Content Script
                            </button>
                        </h2>
                        <div id="collapseKolScript" class="accordion-collapse collapse" data-bs-parent="#accordionKOLHistory">
                            <div class="accordion-body bg-white">

                                <div class="alert alert-success border-success p-2 mb-3 shadow-sm">
                                    <div class="d-flex gap-2">
                                        <i class="bi bi-check-circle-fill mt-1"></i>
                                        <div>
                                            <strong class="small d-block">Catatan Approval Script:</strong>
                                            <span id="bg_script_note" class="small fst-italic text-dark">-</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 bg-white border rounded" id="bg_naskah_final"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div
                        class="card-header bg-white py-2"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseKolRef"
                        style="cursor: pointer">
                        <span class="fw-bold text-primary small"><i class="bi bi-people me-2"></i>Referensi: Hasil Riset KOL</span>
                    </div>
                    <div id="collapseKolRef" class="collapse">
                        <div class="card-body bg-light-subtle">
                            <div class="alert alert-success border-success p-2 mb-3 shadow-sm">
                                <div class="d-flex gap-2">
                                    <i class="bi bi-check-circle-fill mt-1"></i>
                                    <div>
                                        <strong class="small d-block">Catatan Approval:</strong>
                                        <span id="bg_kol_note" class="small fst-italic text-dark">-</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3" id="bg_kol_container"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="small fw-bold text-muted mb-1"><i class="bi bi-paperclip"></i> File</label>
                                    <div id="bg_kol_files" class="d-flex flex-column gap-1">-</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3 border-bottom pb-2">Form Pengajuan Dana</h6>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="small fw-bold mb-1">Nama Penerima</label>
                                <input type="text" id="bg_nama_penerima" class="form-control form-control-sm" placeholder="Nama Penerima">
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold mb-1">Yang Mengajukan</label>
                                <select id="bg_pengaju"></select>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold mb-1">Nama Kategori</label>
                                <select id="bg_kategori" class="form-select form-select-sm"></select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="small fw-bold mb-1">Tipe Pembayaran</label>
                                <select id="bg_tipe_bayar" class="form-select form-select-sm">
                                    <option value="">-- Tipe Pembayaran --</option>
                                    <option value="1">Tunai</option>
                                    <option value="2">Transfer Bank</option>
                                    <option value="3">Giro</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold mb-1">Nama Bank</label>
                                <input type="text" id="bg_nama_bank" class="form-control form-control-sm bg-light" placeholder="Nama Bank" disabled>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold mb-1">Rekening</label>
                                <input type="text" id="bg_rekening" class="form-control form-control-sm bg-light" placeholder="Nomor Rekening" disabled>
                            </div>
                        </div>

                        <div class="mb-2"><label class="small fw-bold text-muted">Detail Keperluan</label></div>
                        <div class="p-3 border rounded bg-light mb-3">

                            <div class="row g-3 mb-3">
                                <div class="col-md-2">
                                    <label class="small text-muted mb-1">Total</label>
                                    <input type="text" id="bg_total" class="form-control form-control-sm fw-bold" placeholder="Rp 0" oninput="formatInputCurrency(this)">
                                    <small class="text-danger" style="font-size:10px">*Input angka saja</small>
                                </div>
                                <div class="col-md-3">
                                    <label class="small text-muted mb-1">Company</label>
                                    <select id="bg_company" class="form-select form-select-sm" disabled>
                                        <option value="">-- Pilih Company --</option>
                                    </select>
                                </div>
                                <div class="col-md-7">
                                    <label class="small text-muted mb-1">Nama Keperluan (EAF)</label>
                                    <select id="bg_keperluan"></select>
                                </div>
                                <div class="col-md-7" id="bg_project_container" style="display:none">
                                    <label class="small text-muted mb-1">Project</label>
                                    <select id="bg_project"></select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <label class="small text-muted mb-1">Note</label>
                                    <textarea id="bg_note" class="form-control form-control-sm" rows="2" placeholder="Catatan tambahan..."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold mb-1">Lampiran</label>
                            <div id="dropzoneBudget" class="dropzone border rounded bg-white p-2 text-center" style="min-height: 80px;">
                                <div class="dz-message"><small>Klik/Drop file (PDF/Img)</small></div>
                            </div>
                            <small class="text-muted" style="font-size:10px">Diperbolehkan: .pdf, .jpg, .png</small>
                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer border-top-0 pt-0 pb-4 pe-4">
                <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary px-4" id="btnSaveBudget">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalReviewBudget" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 pb-0">
                <div><span class="badge bg-success-subtle text-success mb-2">Review Budgeting</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body bg-light pt-4">

                <div id="rvb_approval_history" class="mb-4" style="display:none;"></div>

                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3" id="rvb_campaign_name">Campaign Title</h5>

                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-calendar me-1"></i> Timeline</label>
                                <div class="fw-semibold" id="rvb_timeline">-</div>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-calendar me-1"></i> Deadline</label>
                                <div class="fw-semibold" id="rvb_deadline">-</div>
                            </div>
                            <div class="col-md-2">
                                <label class="small text-muted"><i class="bi bi-flag me-1"></i> Priority</label>
                                <div id="rvb_priority">-</div>
                            </div>
                            <div class="col-md-2">
                                <label class="small text-muted"><i class="bi bi-person-badge me-1"></i> Placement</label>
                                <div id="rvb_placement">-</div>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-people me-1"></i> PIC</label>
                                <div class="d-flex align-items-center" id="rvb_pics">
                                    -
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion mb-3 shadow-sm" id="accordionKOLHistory">

                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKolCamp">
                                <i class="bi bi-megaphone me-2 text-primary"></i> 1. Campaign Brief
                            </button>
                        </h2>
                        <div id="collapseKolCamp" class="accordion-collapse collapse" data-bs-parent="#accordionKOLHistory">
                            <div class="accordion-body bg-white">
                                <div class="row g-3">

                                    <div class="col-12" id="rvb_influencer_container"></div>

                                    <div class="mt-3 pt-3 border-top">
                                        <div class="row g-3">
                                            <div class="col-md-6"><small class="text-muted fw-bold d-block mb-1" style="font-size: 11px;">GOALS</small><span class="small text-dark" id="rvb_hist_goals">-</span></div>
                                            <div class="col-md-6"><small class="text-muted fw-bold d-block mb-1" style="font-size: 11px;">BIG IDEA</small><span class="small text-dark fst-italic" id="rvb_hist_big_idea">-</span></div>
                                            <div class="col-12"><small class="text-muted fw-bold d-block mb-1" style="font-size: 11px;">DESKRIPSI</small>
                                                <div class="small text-secondary bg-light p-2 rounded border" id="rvb_hist_description">-</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted mb-1"><i class="bi bi-link-45deg"></i> Link Referensi</label>
                                        <div id="rvb_camp_links" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted mb-1"><i class="bi bi-paperclip"></i> File Referensi</label>
                                        <div id="rvb_camp_files" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKolRiset">
                                <i class="bi bi-search me-2 text-info"></i> 2. Hasil Riset Campaign
                            </button>
                        </h2>
                        <div id="collapseKolRiset" class="accordion-collapse collapse" data-bs-parent="#accordionKOLHistory">
                            <div class="accordion-body bg-white">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted">Riset Report</label>
                                        <div class="p-2 bg-light border rounded small" id="rvb_riset_report">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted">Trend Analysis</label>
                                        <div class="p-2 bg-light border rounded small" id="rvb_trend_analysis">-</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="alert alert-warning py-1 px-2 small mb-0">
                                            <strong>Note SPV:</strong> <span id="rvb_riset_note">-</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted mb-1"><i class="bi bi-link-45deg"></i> Link Referensi</label>
                                        <div id="rvb_riset_links" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted mb-1"><i class="bi bi-paperclip"></i> File Referensi</label>
                                        <div id="rvb_riset_files" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKolScript">
                                <i class="bi bi-file-earmark-text me-2 text-warning"></i> 3. Content Script
                            </button>
                        </h2>
                        <div id="collapseKolScript" class="accordion-collapse collapse" data-bs-parent="#accordionKOLHistory">
                            <div class="accordion-body bg-white">

                                <div class="alert alert-success border-success p-2 mb-3 shadow-sm">
                                    <div class="d-flex gap-2">
                                        <i class="bi bi-check-circle-fill mt-1"></i>
                                        <div>
                                            <strong class="small d-block">Catatan Approval Script:</strong>
                                            <span id="rvb_script_note" class="small fst-italic text-dark">-</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 bg-white border rounded" id="rvb_naskah_final"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div
                        class="card-header bg-white py-2"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseKolRef"
                        style="cursor: pointer">
                        <span class="fw-bold text-primary small"><i class="bi bi-people me-2"></i>Referensi: Hasil Riset KOL</span>
                    </div>
                    <div id="collapseKolRef" class="collapse">
                        <div class="card-body bg-light-subtle">
                            <div class="alert alert-success border-success p-2 mb-3 shadow-sm">
                                <div class="d-flex gap-2">
                                    <i class="bi bi-check-circle-fill mt-1"></i>
                                    <div>
                                        <strong class="small d-block">Catatan Approval:</strong>
                                        <span id="rvb_kol_note" class="small fst-italic text-dark">-</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3" id="rvb_kol_container"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="small fw-bold text-muted mb-1"><i class="bi bi-paperclip"></i> File</label>
                                    <div id="rvb_kol_files" class="d-flex flex-column gap-1">-</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3 border-bottom pb-2">Detail Pengajuan Dana</h6>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4"><label class="small text-muted mb-1">Penerima</label>
                                <div class="form-control form-control-sm bg-light" id="rvb_penerima">-</div>
                            </div>
                            <div class="col-md-4"><label class="small text-muted mb-1">Pengaju</label>
                                <div class="form-control form-control-sm bg-light" id="rvb_pengaju">-</div>
                            </div>
                            <div class="col-md-4"><label class="small text-muted mb-1">Kategori</label>
                                <div class="form-control form-control-sm bg-light" id="rvb_kategori">-</div>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4"><label class="small text-muted mb-1">Tipe Bayar</label>
                                <div class="form-control form-control-sm bg-light" id="rvb_tipe_bayar">-</div>
                            </div>
                            <div class="col-md-4"><label class="small text-muted mb-1">Bank</label>
                                <div class="form-control form-control-sm bg-light" id="rvb_bank">-</div>
                            </div>
                            <div class="col-md-4"><label class="small text-muted mb-1">Rekening</label>
                                <div class="form-control form-control-sm bg-light" id="rvb_rekening">-</div>
                            </div>
                        </div>
                        <div class="p-3 border rounded bg-white mb-3 border-start border-5 border-primary">
                            <div class="row align-items-center">
                                <div class="col-md-4"><small class="text-muted d-block">Total Budget</small>
                                    <h4 class="fw-bold text-primary mb-0" id="rvb_total">Rp 0</h4>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted d-block">Keperluan</small>
                                    <span class="fw-semibold text-dark" id="rvb_keperluan">-</span>
                                    <div class="small text-muted mt-1 fst-italic" id="rvb_note">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted d-block">Company</small>
                                    <span class="fw-semibold text-dark" id="rvb_company">-</span>
                                    <div class="small text-muted mt-1 fst-italic" id="rvb_project">-</div">
                                    </div>
                                </div>
                                <div class="mb-3"><label class="small fw-bold mb-1">Lampiran</label>
                                    <div id="rvb_file_container"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 p-3 bg-warning-subtle rounded border border-warning">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fw-bold text-dark mb-2">Catatan Approval</label>
                                    <textarea class="form-control" id="approve_budget_note" rows="2" placeholder="Catatan..."></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-bold text-dark mb-2">Next PIC (Shooting)</label>
                                    <select name="pic[]" id="picSelectReviewBudget" multiple></select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <label class="fw-bold text-dark mb-2">Deadline Next</label>
                                    <input type="date" class="form-control" name="deadline_shooting" id="deadline_shooting">
                                </div>
                            </div>
                            <input type="hidden" id="rvb_hidden_campaign_id">
                            <input type="hidden" id="rvb_hidden_budget_id">
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0 pb-4 pe-4">
                        <button type="button" class="btn btn-warning text-white me-auto" id="btnRejectBudget" style="display:none;"><i class="bi bi-arrow-counterclockwise me-1"></i> Revisi</button>
                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success px-4" id="btnApproveBudget"><i class="bi bi-check-lg me-2"></i> Approve</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>