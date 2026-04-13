<div class="modal fade" id="modalRisetKOL" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Input Riset KOL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bg-light">
                <input type="hidden" id="kol_campaign_id">

                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3" id="k_campaign_name">Campaign Title</h5>

                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-calendar me-1"></i> Timeline</label>
                                <div class="fw-semibold" id="k_timeline">-</div>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-calendar me-1"></i> Deadline</label>
                                <div class="fw-semibold" id="k_deadline">-</div>
                            </div>
                            <div class="col-md-2">
                                <label class="small text-muted"><i class="bi bi-flag me-1"></i> Priority</label>
                                <div id="k_priority">-</div>
                            </div>
                            <div class="col-md-2">
                                <label class="small text-muted"><i class="bi bi-person-badge me-1"></i> Placement</label>
                                <div id="k_placement">-</div>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-people me-1"></i> PIC</label>
                                <div class="d-flex align-items-center" id="k_pic_list">
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

                                    <div class="col-12" id="k_influencer_container"></div>
                                    <div class="mt-3 mb-3 pt-3 border-top">
                                        <div class="row g-3">
                                            <div class="col-md-6"><small class="text-muted fw-bold d-block mb-1" style="font-size: 11px;">GOALS</small><span class="small text-dark" id="k_goals">-</span></div>
                                            <div class="col-md-6"><small class="text-muted fw-bold d-block mb-1" style="font-size: 11px;">BIG IDEA</small><span class="small text-dark fst-italic" id="k_big_idea">-</span></div>
                                            <div class="col-12"><small class="text-muted fw-bold d-block mb-1" style="font-size: 11px;">DESKRIPSI</small>
                                                <div class="small text-secondary bg-light p-2 rounded border" id="k_description">-</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted mb-1"><i class="bi bi-link-45deg"></i> Link Referensi</label>
                                        <div id="k_camp_links" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted mb-1"><i class="bi bi-paperclip"></i> File Referensi</label>
                                        <div id="k_camp_files" class="d-flex flex-column gap-1">-</div>
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
                                        <div class="p-2 bg-light border rounded small" id="k_riset_report">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted">Trend Analysis</label>
                                        <div class="p-2 bg-light border rounded small" id="k_trend_analysis">-</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="alert alert-warning py-1 px-2 small mb-0">
                                            <strong>Note SPV:</strong> <span id="k_riset_note">-</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted mb-1"><i class="bi bi-link-45deg"></i> Link Referensi</label>
                                        <div id="k_riset_links" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted mb-1"><i class="bi bi-paperclip"></i> File Referensi</label>
                                        <div id="k_riset_files" class="d-flex flex-column gap-1">-</div>
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
                        <div id="collapseKolScript" class="accordion-collapse collapse show" data-bs-parent="#accordionKOLHistory">
                            <div class="accordion-body bg-white">

                                <div class="alert alert-success border-success p-2 mb-3 shadow-sm">
                                    <div class="d-flex gap-2">
                                        <i class="bi bi-check-circle-fill mt-1"></i>
                                        <div>
                                            <strong class="small d-block">Catatan Approval Script:</strong>
                                            <span id="k_script_note" class="small fst-italic text-dark">-</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 bg-white border rounded" id="k_naskah_final"></div>
                            </div>
                        </div>
                    </div>

                </div>

                <div id="kolItemsContainer">
                </div>

                <button type="button" class="btn btn-outline-primary w-100 border-dashed mb-4" id="btnAddKOLItem">
                    <i class="bi bi-plus-circle me-2"></i> Tambah KOL
                </button>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3 small text-muted">Upload File</h6>
                        <div id="dropzoneRisetKOL" class="dropzone border rounded bg-light text-center p-3">
                            <div class="dz-message"><span>Klik atau Drop file disini</span></div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary px-4" id="btnSaveRisetKOL">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalReviewRisetKOL" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header border-bottom-0 pb-0">
                <div>
                    <span class="badge bg-info-subtle text-info mb-2">Review Riset KOL</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body pt-4">

                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3" id="rvk_campaign_name">Campaign Title</h5>

                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-calendar me-1"></i> Timeline</label>
                                <div class="fw-semibold" id="rvk_timeline">-</div>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-calendar me-1"></i> Deadline</label>
                                <div class="fw-semibold" id="rvk_deadline">-</div>
                            </div>
                            <div class="col-md-2">
                                <label class="small text-muted"><i class="bi bi-flag me-1"></i> Priority</label>
                                <div id="rvk_priority">-</div>
                            </div>
                            <div class="col-md-2">
                                <label class="small text-muted"><i class="bi bi-person-badge me-1"></i> Placement</label>
                                <div id="rvk_placement">-</div>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-people me-1"></i> PIC</label>
                                <div class="d-flex align-items-center" id="rvk_pics">
                                    -
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion mb-4 shadow-sm border-0" id="accordionRvkHistory">

                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRvkBrief">
                                <i class="bi bi-megaphone me-2 text-primary"></i> 1. Campaign Brief
                            </button>
                        </h2>
                        <div id="collapseRvkBrief" class="accordion-collapse collapse" data-bs-parent="#accordionRvkHistory">
                            <div class="accordion-body bg-white">
                                <div class="col-12" id="rvk_influencer_container"></div>
                                <div class="mt-3 mb-3 pt-3 border-top">
                                    <div class="row g-3">
                                        <div class="col-md-6"><small class="text-muted fw-bold d-block mb-1" style="font-size: 11px;">GOALS</small><span class="small text-dark" id="rvk_hist_goals">-</span></div>
                                        <div class="col-md-6"><small class="text-muted fw-bold d-block mb-1" style="font-size: 11px;">BIG IDEA</small><span class="small text-dark fst-italic" id="rvk_hist_big_idea">-</span></div>
                                        <div class="col-12"><small class="text-muted fw-bold d-block mb-1" style="font-size: 11px;">DESKRIPSI</small>
                                            <div class="small text-secondary bg-light p-2 rounded border" id="rvk_description">-</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="small fw-bold text-muted">Link Referensi Campaign</label>
                                    <div id="rvk_campaign_links" class="d-flex flex-wrap gap-2 mt-1">-</div>
                                </div>
                                <div class="col-12">
                                    <label class="small fw-bold text-muted">File Referensi Campaign</label>
                                    <div id="rvk_campaign_files" class="d-flex flex-wrap gap-2 mt-1">-</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRvkRiset">
                                <i class="bi bi-search me-2 text-info"></i> 2. Hasil Riset Campaign
                            </button>
                        </h2>
                        <div id="collapseRvkRiset" class="accordion-collapse collapse" data-bs-parent="#accordionRvkHistory">
                            <div class="accordion-body bg-white">

                                <div class="row g-2 mb-2">
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted mb-1">Report</label>
                                        <div class="p-2 bg-light border rounded small" id="rvk_hist_riset_report"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted mb-1">Analysis</label>
                                        <div class="p-2 bg-light border rounded small" id="rvk_hist_trend"></div>
                                    </div>
                                </div>

                                <div class="row g-2 border-top pt-2 mt-2">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-start gap-2">
                                            <i class="bi bi-link-45deg text-primary mt-1"></i>
                                            <div>
                                                <small class="fw-bold text-muted d-block">Link Riset:</small>
                                                <div id="rvk_hist_riset_links" class="d-flex flex-wrap gap-1"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-start gap-2">
                                            <i class="bi bi-paperclip text-danger mt-1"></i>
                                            <div>
                                                <small class="fw-bold text-muted d-block">File Lampiran:</small>
                                                <div id="rvk_hist_riset_files" class="d-flex flex-wrap gap-1"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRvkScript">
                                <i class="bi bi-file-earmark-check me-2 text-success"></i> 3. Content Script
                            </button>
                        </h2>
                        <div id="collapseRvkScript" class="accordion-collapse collapse" data-bs-parent="#accordionRvkHistory">
                            <div class="accordion-body bg-white">
                                <div class="alert alert-success py-1 px-2 small mb-2"><strong>Note Script:</strong> <span id="rvk_hist_script_note">-</span></div>
                                <div class="p-3 bg-light border rounded small" id="rvk_naskah_final"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="fw-bold mb-3"><i class="bi bi-people me-2"></i>Kandidat KOL</h5>

                <div class="row g-3 mb-4" id="rvk_items_container"></div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h6 class="mb-0 fw-bold">Bukti Lampiran</h6>
                    </div>
                    <div class="card-body">
                        <div id="rvk_files_list" class="d-flex flex-wrap gap-2"></div>
                    </div>
                </div>

                <div class="mt-4 p-3 bg-warning-subtle rounded border border-warning">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="fw-bold text-dark mb-2">Catatan Approval</label>
                            <textarea class="form-control" id="approve_kol_note" rows="2" placeholder="Catatan..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-dark mb-2">Next PIC (Budgeting)</label>
                            <select name="pic[]" id="picSelectReviewKOL" multiple></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <label class="fw-bold text-dark mb-2">Deadline Next Progress</label>
                            <input type="date" class="form-control" name="deadline_budgeting" id="deadline_budgeting">
                        </div>
                    </div>
                    <input type="hidden" id="rvk_hidden_campaign_id">
                    <input type="hidden" id="rvk_hidden_riset_id">
                </div>

            </div>

            <div class="modal-footer border-top-0 pt-0 pb-4 pe-4">
                <button type="button" class="btn btn-warning text-white me-auto" id="btnRejectRisetKOL" style="display:none;">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Revisi
                </button>
                <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary px-4" id="btnApproveRisetKOL">
                    <i class="bi bi-check-lg me-2"></i> Approve
                </button>
            </div>
        </div>
    </div>
</div>