<div class="modal fade" id="modalContentScript" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold">Content Script Input</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bg-light">

                <input type="hidden" id="script_campaign_id">
                <input type="hidden" id="script_campaign_name_hid">
                <input type="hidden" id="script_goals_hid">
                <input type="hidden" id="script_big_idea_hid">



                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3" id="s_campaign_name">Campaign Title</h5>

                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-calendar me-1"></i> Timeline</label>
                                <div class="fw-semibold" id="s_timeline">-</div>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-calendar me-1"></i> Deadline</label>
                                <div class="fw-semibold" id="s_deadline">-</div>
                            </div>
                            <div class="col-md-2">
                                <label class="small text-muted"><i class="bi bi-flag me-1"></i> Priority</label>
                                <div id="s_priority">-</div>
                            </div>
                            <div class="col-md-2">
                                <label class="small text-muted"><i class="bi bi-person-badge me-1"></i> Placement</label>
                                <div id="s_placement">-</div>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-people me-1"></i> PIC</label>
                                <div class="d-flex align-items-center" id="s_pic">
                                    -
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion mb-3 shadow-sm" id="accordionScriptHistory">

                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHistCampaign">
                                <i class="bi bi-megaphone me-2 text-primary"></i> Detail Campaign (Brief)
                            </button>
                        </h2>
                        <div id="collapseHistCampaign" class="accordion-collapse collapse" data-bs-parent="#accordionScriptHistory">
                            <div class="accordion-body bg-white">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted">Goals</label>
                                        <p class="small mb-0" id="h_script_goals">-</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted">Big Idea</label>
                                        <p class="small mb-0 fst-italic" id="h_script_big_idea">-</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted">Description</label>
                                        <div class="small mb-0 fst-italic" id="s_description">-</div>
                                    </div>
                                    <!-- Influencer/Mediagram Info -->
                                    <div class="col-12" id="h_influencer_container"></div>
                                    <div class="col-12">
                                        <label class="small fw-bold text-muted">Link Referensi Campaign</label>
                                        <div id="h_script_camp_links" class="d-flex flex-wrap gap-2 mt-1">-</div>
                                    </div>
                                    <div class="col-12">
                                        <label class="small fw-bold text-muted">File Referensi Campaign</label>
                                        <div id="h_script_camp_files" class="d-flex flex-wrap gap-2 mt-1">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHistRisetSPV">
                                <i class="bi bi-search me-2 text-info"></i> Hasil Riset Campaign & Note
                            </button>
                        </h2>
                        <div id="collapseHistRisetSPV" class="accordion-collapse collapse show" data-bs-parent="#accordionScriptHistory">
                            <div class="accordion-body bg-white">

                                <div class="alert alert-warning border-warning p-2 mb-3">
                                    <strong class="small d-block"><i class="bi bi-chat-quote-fill me-1"></i> Note Approval (Riset):</strong>
                                    <span id="h_script_riset_note" class="small fst-italic text-dark">-</span>
                                </div>

                                <div class="mb-3">
                                    <label class="small fw-bold text-muted">Riset Report</label>
                                    <div class="p-3 bg-light border rounded small" id="h_script_riset_report">-</div>
                                </div>
                                <div class="mb-3">
                                    <label class="small fw-bold text-muted">Trend Analysis</label>
                                    <div class="p-3 bg-light border rounded small" id="h_script_trend_analysis">-</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted mb-1">Link Riset</label>
                                        <div id="h_script_riset_links" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted mb-1">File Riset</label>
                                        <div id="h_script_riset_files" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="fw-bold text-danger small">Hasil Naskah *</label>

                            <button type="button" class="btn btn-sm btn-outline-primary" id="btnGenerateAI">
                                <i class="bi bi-stars"></i> Generate Naskah (AI)
                            </button>
                        </div>

                        <div class="mb-3">
                            <textarea id="naskah_1" class="summernote"></textarea>
                        </div>

                        <div id="wrap_naskah_2" class="mb-3" style="display:none;">
                            <label class="fw-bold text-muted small mb-1">Opsi Naskah 2</label>
                            <div class="position-relative">
                                <button type="button" class="btn btn-xs btn-danger position-absolute top-0 end-0 m-1 z-index-1 remove-naskah" data-target="2" style="z-index:10">X</button>
                                <textarea id="naskah_2" class="summernote"></textarea>
                            </div>
                        </div>

                        <div id="wrap_naskah_3" class="mb-3" style="display:none;">
                            <label class="fw-bold text-muted small mb-1">Opsi Naskah 3</label>
                            <div class="position-relative">
                                <button type="button" class="btn btn-xs btn-danger position-absolute top-0 end-0 m-1 remove-naskah" data-target="3" style="z-index:10">X</button>
                                <textarea id="naskah_3" class="summernote"></textarea>
                            </div>
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-secondary w-100 border-dashed" id="btnAddNaskah">
                            + Tambah Opsi Naskah
                        </button>

                    </div>
                </div>



            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary px-4" id="btnSaveScript">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalReviewScript" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0">
            <div class="modal-header border-bottom-0 pb-0">
                <div>
                    <span class="badge bg-success-subtle text-success mb-2">Review Content Script</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body bg-light pt-4">

                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3" id="rvs_campaign_name">Campaign Title</h5>

                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-calendar me-1"></i> Timeline</label>
                                <div class="fw-semibold" id="rvs_timeline">-</div>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-calendar me-1"></i> Deadline</label>
                                <div class="fw-semibold" id="rvs_deadline">-</div>
                            </div>
                            <div class="col-md-2">
                                <label class="small text-muted"><i class="bi bi-flag me-1"></i> Priority</label>
                                <div id="rvs_priority">-</div>
                            </div>
                            <div class="col-md-2">
                                <label class="small text-muted"><i class="bi bi-person-badge me-1"></i> Placement</label>
                                <div id="rvs_placement">-</div>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-people me-1"></i> PIC</label>
                                <div class="d-flex align-items-center" id="rvs_pic">
                                    -
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion mb-3 shadow-sm" id="accordionScriptHistory">

                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHistCampaign">
                                <i class="bi bi-megaphone me-2 text-primary"></i> Detail Campaign (Brief)
                            </button>
                        </h2>
                        <div id="collapseHistCampaign" class="accordion-collapse collapse" data-bs-parent="#accordionScriptHistory">
                            <div class="accordion-body bg-white">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted">Goals</label>
                                        <p class="small mb-0" id="rvs_hist_goals">-</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted">Big Idea</label>
                                        <p class="small mb-0 fst-italic" id="rvs_hist_big_idea">-</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted">Description</label>
                                        <div class="small mb-0 fst-italic" id="rvs_description">-</div>
                                    </div>
                                    <!-- Influencer/Mediagram Info -->
                                    <div class="col-12" id="rvs_influencer_container"></div>
                                    <div class="col-12">
                                        <label class="small fw-bold text-muted">Link Referensi Campaign</label>
                                        <div id="rvs_hist_links" class="d-flex flex-wrap gap-2 mt-1">-</div>
                                    </div>
                                    <div class="col-12">
                                        <label class="small fw-bold text-muted">File Referensi Campaign</label>
                                        <div id="rvs_hist_files" class="d-flex flex-wrap gap-2 mt-1">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHistRisetSPV">
                                <i class="bi bi-search me-2 text-info"></i> Hasil Riset Campaign & Note
                            </button>
                        </h2>
                        <div id="collapseHistRisetSPV" class="accordion-collapse collapse show" data-bs-parent="#accordionScriptHistory">
                            <div class="accordion-body bg-white">

                                <div class="alert alert-warning border-warning p-2 mb-3">
                                    <strong class="small d-block"><i class="bi bi-chat-quote-fill me-1"></i> Note Approval (Riset):</strong>
                                    <span id="rvs_riset_note" class="small fst-italic text-dark">-</span>
                                </div>

                                <div class="mb-3">
                                    <label class="small fw-bold text-muted">Riset Report</label>
                                    <div class="p-3 bg-light border rounded small" id="rvs_riset_report">-</div>
                                </div>
                                <div class="mb-3">
                                    <label class="small fw-bold text-muted">Trend Analysis</label>
                                    <div class="p-3 bg-light border rounded small" id="rvs_trend_analysis">-</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted mb-1">Link Riset</label>
                                        <div id="rvs_riset_links" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted mb-1">File Riset</label>
                                        <div id="rvs_riset_files" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="fw-bold mb-3"><i class="bi bi-check2-square me-2"></i>Pilih Naskah Final</h5>
                <div class="row g-3" id="naskahContainer"></div>

                <div class="mt-4 p-3 bg-warning-subtle rounded border border-warning">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="fw-bold text-dark mb-2">Catatan Approval</label>
                            <textarea class="form-control" id="approve_script_note" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-dark mb-2">Next PIC (Riset KOL)</label>
                            <select name="pic[]" id="picSelectReviewScript" multiple></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <label class="fw-bold text-dark mb-2">Deadline Next Progress</label>
                            <input type="date" class="form-control" name="deadline_kol" id="deadline_kol">
                        </div>
                    </div>
                    <input type="hidden" id="rvs_hidden_campaign_id">
                    <input type="hidden" id="rvs_hidden_script_id">
                    <input type="hidden" id="selected_naskah_content">
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0 pb-4 pe-4">
                <button type="button" class="btn btn-warning text-white me-auto" id="btnRejectScript" style="display:none;"><i class="bi bi-arrow-counterclockwise me-1"></i> Revisi</button>
                <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success px-4" id="btnApproveScript"><i class="bi bi-check-lg me-2"></i> Approve</button>
            </div>
        </div>
    </div>
</div>