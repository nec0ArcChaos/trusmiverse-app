<div class="modal fade" id="modalEditing" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header border-bottom-0 pb-0">
                <div>
                    <span class="badge bg-success-subtle text-success mb-2">Input Editing</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4 bg-light">

                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3" id="ed_campaign_name">Campaign Title</h5>

                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-calendar me-1"></i> Timeline</label>
                                <div class="fw-semibold" id="ed_timeline">-</div>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-calendar me-1"></i> Deadline</label>
                                <div class="fw-semibold" id="ed_deadline">-</div>
                            </div>
                            <div class="col-md-2">
                                <label class="small text-muted"><i class="bi bi-flag me-1"></i> Priority</label>
                                <div id="ed_priority">-</div>
                            </div>
                            <div class="col-md-2">
                                <label class="small text-muted"><i class="bi bi-person-badge me-1"></i> Placement</label>
                                <div id="ed_placement">-</div>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-people me-1"></i> PIC</label>
                                <div class="d-flex align-items-center" id="ed_pics">-</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion mb-4 shadow-sm" id="accordionEditingHistory">

                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#ed_collapseBrief">
                                <i class="bi bi-megaphone me-2 text-primary"></i> 1. Campaign Brief
                            </button>
                        </h2>
                        <div id="ed_collapseBrief" class="accordion-collapse collapse" data-bs-parent="#accordionEditingHistory">
                            <div class="accordion-body bg-white">
                                <div id="ed_influencer_container" class="mb-3"></div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <small class="text-muted fw-bold d-block">GOALS</small>
                                        <span id="ed_hist_goals" class="small">-</span>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted fw-bold d-block">BIG IDEA</small>
                                        <span id="ed_hist_big_idea" class="small fst-italic">-</span>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted fw-bold d-block">DESKRIPSI</small>
                                        <div id="ed_hist_description" class="fd-textbox">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted fw-bold d-block"><i class="bi bi-link-45deg"></i> Link Ref</small>
                                        <div id="ed_camp_links" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted fw-bold d-block"><i class="bi bi-paperclip"></i> File Ref</small>
                                        <div id="ed_camp_files" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#ed_collapseRiset">
                                <i class="bi bi-search me-2 text-info"></i> 2. Hasil Riset
                            </button>
                        </h2>
                        <div id="ed_collapseRiset" class="accordion-collapse collapse" data-bs-parent="#accordionEditingHistory">
                            <div class="accordion-body bg-white">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted">Riset Report</label>
                                        <div id="ed_riset_report" class="fd-textbox">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted">Trend Analysis</label>
                                        <div id="ed_trend_analysis" class="fd-textbox">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#ed_collapseScript">
                                <i class="bi bi-file-earmark-text me-2 text-warning"></i> 3. Content Script
                            </button>
                        </h2>
                        <div id="ed_collapseScript" class="accordion-collapse collapse" data-bs-parent="#accordionEditingHistory">
                            <div class="accordion-body bg-white">
                                <div class="alert alert-success border-success p-2 mb-2 shadow-sm">
                                    <strong class="small">Note Approval:</strong> <span id="ed_script_note" class="small fst-italic">-</span>
                                </div>
                                <div id="ed_naskah_final" class="p-3 bg-white border rounded small"></div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#ed_collapseKol">
                                <i class="bi bi-people me-2 text-danger"></i> 4. Riset KOL
                            </button>
                        </h2>
                        <div id="ed_collapseKol" class="accordion-collapse collapse" data-bs-parent="#accordionEditingHistory">
                            <div class="accordion-body bg-white">
                                <div class="row g-3" id="ed_kol_container"></div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#ed_collapseBudget">
                                <i class="bi bi-cash me-2 text-success"></i> 5. Budgeting
                            </button>
                        </h2>
                        <div id="ed_collapseBudget" class="accordion-collapse collapse" data-bs-parent="#accordionEditingHistory">
                            <div class="accordion-body bg-white">
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted d-block">Total Budget</small>
                                        <h5 class="fw-bold text-primary" id="ed_total_budget">Rp 0</h5>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted d-block">Keperluan</small>
                                        <span id="ed_keperluan">-</span>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    <!-- </div> -->

                    <div class="accordion-item border-0">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold bg-warning-subtle text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#ed_collapseShooting">
                                <i class="bi bi-camera-reels me-2"></i>Result Shooting
                            </button>
                        </h2>
                        <div id="ed_collapseShooting" class="accordion-collapse collapse show" data-bs-parent="#accordionEditingHistory">
                            <div class="accordion-body bg-white">

                                <div class="alert alert-secondary border-secondary p-2 mb-3">
                                    <strong class="small"><i class="bi bi-chat-quote-fill me-1"></i> Note Approval Shooting:</strong>
                                    <span id="ed_hist_shooting_approve_note" class="small fst-italic text-dark">-</span>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted">Lokasi</label>
                                        <div id="ed_hist_shooting_lokasi" class="fw-semibold small">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted">Output</label>
                                        <div id="ed_hist_shooting_output" class="d-flex flex-wrap gap-1">-</div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="small fw-bold text-muted">Keterangan</label>
                                    <div id="ed_hist_shooting_keterangan" class="p-3 bg-light border rounded small">-</div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted"><i class="bi bi-link-45deg"></i> Link</label>
                                        <div id="ed_hist_shooting_links" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted"><i class="bi bi-paperclip"></i> File Lampiran</label>
                                        <div id="ed_hist_shooting_files" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="card border-0 shadow-sm">
                    <form id="formEditing" class="form-control" enctype="multipart/form-data">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3 border-bottom pb-2 text-primary">
                                <i class="bi bi-pencil-square me-2"></i>Form Hasil Editing
                            </h6>
                            <input type="hidden" id="ed_campaign_id" name="campaign_id" />

                            <div class="mb-3">
                                <label class="fw-bold small mb-2">Catatan / Caption / Description</label>
                                <textarea id="editing_keterangan" class="summernote"></textarea>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="fw-bold small">Link Hasil Editing (GDrive/Youtube/etc)</label>
                                    <button type="button" id="addEditingLink" class="btn btn-xs btn-outline-primary py-0 rounded-pill px-3">+ Tambah Link</button>
                                </div>
                                <div id="editingLinkContainer"></div>
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold small mb-2">File Hasil Editing (Final Video/Image)</label>
                                <div id="dropzoneEditing" class="dropzone border rounded bg-light text-center">
                                    <div class="dz-message" data-dz-message>
                                        <i class="bi bi-cloud-upload display-4 text-muted"></i>
                                        <span class="d-block mt-2">Klik atau Drop file hasil edit di sini</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer border-top-0 pt-0 pb-4 pe-4">
                            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary px-4" id="btnSaveEditing">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalReviewEditing" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 pb-0">
                <div>
                    <span class="badge bg-primary-subtle text-primary mb-2">Approval Editing</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body bg-light pt-4">

                <input type="hidden" id="rv_editing_campaign_id">
                <input type="hidden" id="rv_editing_company_id">

                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3" id="rv_editing_campaign_name">Loading...</h5>

                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-calendar me-1"></i> Timeline</label>
                                <div class="fw-semibold" id="rv_editing_timeline">-</div>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-calendar me-1"></i> Deadline</label>
                                <div class="fw-semibold" id="rv_editing_deadline">-</div>
                            </div>
                            <div class="col-md-2">
                                <label class="small text-muted"><i class="bi bi-flag me-1"></i> Priority</label>
                                <div id="rv_editing_priority">-</div>
                            </div>
                            <div class="col-md-2">
                                <label class="small text-muted"><i class="bi bi-person-badge me-1"></i> Placement</label>
                                <div id="rv_editing_placement">-</div>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted"><i class="bi bi-people me-1"></i> PIC</label>
                                <div class="d-flex align-items-center" id="rv_editing_pics">-</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion mb-3 shadow-sm" id="accordionReviewEditing">
                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#rv_ed_collapseBrief">
                                <i class="bi bi-megaphone me-2 text-primary"></i> 1. Campaign Brief
                            </button>
                        </h2>
                        <div id="rv_ed_collapseBrief" class="accordion-collapse collapse" data-bs-parent="#accordionReviewEditing">
                            <div class="accordion-body bg-white">
                                <div id="rv_ed_influencer_container" class="mb-3"></div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <small class="text-muted fw-bold d-block">GOALS</small>
                                        <span id="rv_ed_hist_goals" class="small">-</span>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted fw-bold d-block">BIG IDEA</small>
                                        <span id="rv_ed_hist_big_idea" class="small fst-italic">-</span>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted fw-bold d-block">DESKRIPSI</small>
                                        <div id="rv_ed_hist_description" class="fd-textbox">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted fw-bold d-block"><i class="bi bi-link-45deg"></i> Link Ref</small>
                                        <div id="rv_ed_camp_links" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted fw-bold d-block"><i class="bi bi-paperclip"></i> File Ref</small>
                                        <div id="rv_ed_camp_files" class="d-flex flex-column gap-1">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#rv_ed_collapseRiset">
                                <i class="bi bi-search me-2 text-info"></i> 2. Hasil Riset
                            </button>
                        </h2>
                        <div id="rv_ed_collapseRiset" class="accordion-collapse collapse" data-bs-parent="#accordionReviewEditing">
                            <div class="accordion-body bg-white">
                                <div class="alert alert-success border-success p-2 mb-2 shadow-sm">
                                    <strong class="small">Note Approval:</strong> <span id="rv_ed_riset_note" class="small fst-italic">-</span>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted">Riset Report</label>
                                        <div id="rv_ed_riset_report" class="fd-textbox">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted">Trend Analysis</label>
                                        <div id="rv_ed_trend_analysis" class="fd-textbox">-</div>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted">Riset Link</label>
                                        <div id="rv_ed_riset_links">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold text-muted">Riset Files</label>
                                        <div id="rv_ed_riset_files">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#rv_ed_collapseScript">
                                <i class="bi bi-file-earmark-text me-2 text-warning"></i> 3. Content Script
                            </button>
                        </h2>
                        <div id="rv_ed_collapseScript" class="accordion-collapse collapse" data-bs-parent="#accordionReviewEditing">
                            <div class="accordion-body bg-white">
                                <div class="alert alert-success border-success p-2 mb-2 shadow-sm">
                                    <strong class="small">Note Approval:</strong> <span id="rv_ed_script_note" class="small fst-italic">-</span>
                                </div>
                                <div id="rv_ed_naskah_final" class="p-3 bg-white border rounded small"></div>
                            </div>
                        </div>
                    </div>



                    <div class="accordion-item border-0">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#rv_ed_collapseShooting">
                                <i class="bi bi-camera-reels me-2 text-dark"></i> Result Shooting
                            </button>
                        </h2>
                        <div id="rv_ed_collapseShooting" class="accordion-collapse" data-bs-parent="#accordionReviewEditing">
                            <div class="accordion-body bg-white">
                                <div class="row g-3">
                                    <div class="col-md-6"><label class="small text-muted">Lokasi</label>
                                        <div id="rv_ed_hist_shooting_lokasi" class="fw-bold small">-</div>
                                    </div>
                                    <div class="col-md-6"><label class="small text-muted">Output</label>
                                        <div id="rv_ed_hist_shooting_output">-</div>
                                    </div>
                                </div>
                                <div class="mt-2 p-2 fd-textbox" id="rv_ed_hist_shooting_keterangan">-</div>
                                <div class="row mt-2 small">
                                    <div class="col-md-6">
                                        <strong>Files:</strong>
                                        <div id="rv_ed_hist_shooting_files" class="mt-1"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Link:</strong>
                                        <div id="rv_ed_hist_shooting_links" class="mt-1"></div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-3 border-start border-5 border-primary">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-pencil-square me-2"></i>HASIL EDITING</h6>

                        <div class="mb-3">
                            <label class="small text-muted fw-bold">Catatan / Caption / Description</label>
                            <div id="rv_res_editing_keterangan" class="p-3 fd-textbox">-</div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="small text-muted fw-bold"><i class="bi bi-link"></i> Link Hasil Editing</label>
                                <div id="rv_res_editing_links">-</div>
                            </div>
                            <div class="col-md-6">
                                <label class="small text-muted fw-bold"><i class="bi bi-paperclip"></i> Thumbnail / Evidence</label>
                                <div id="rv_res_editing_files">-</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body bg-warning-subtle rounded">
                        <h6 class="fw-bold mb-3"><i class="bi bi-pencil-square me-2"></i>Form Approval & Assign Next Phase</h6>

                        <div class="mb-3">
                            <label class="small fw-bold">Catatan Approval</label>
                            <textarea class="form-control" id="rv_editing_note_approve" rows="2" placeholder="Tulis catatan..."></textarea>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="small fw-bold">PIC Next (Posting/Review) <span class="text-danger">*</span></label>
                                <select id="rv_editing_pic_next" multiple></select>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold">Deadline Next <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="rv_editing_deadline_next" placeholder="YYYY-MM-DD">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-3 pb-4 px-4" id="rv_editing_actions">
                        <button type="button" class="btn btn-warning me-auto" id="btnRejectEditing">
                            <i class="bi bi-arrow-counterclockwise"></i> Revisi
                        </button>
                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary px-4" id="btnApproveEditing">
                            <i class="bi bi-check-lg"></i> Approve
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>