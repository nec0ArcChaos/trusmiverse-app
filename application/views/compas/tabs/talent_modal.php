<!-- Talent Form Modal -->
<div class="modal fade sub_modal" id="addTalentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4 bg-soft-blue">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-1" id="talent-modal-title">Add Talent</h5>
                    <p class="text-muted small mb-0">Fill in the details for the talent collaboration.</p>
                </div>
                <button type="button" class="ms-auto btn-close shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-soft-blue">
                <form id="formAddTalent">
                    <input type="hidden" name="campaign_id" id="talent_campaign_id">
                    <input type="hidden" name="talent_id" id="talent_id">
                    <input type="hidden" name="master_talent_id" id="talent_master_id">

                    <div class="row g-3">

                        <!-- Section: Linked Content -->
                        <div class="col-12">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Linked Content</h6>
                        </div>
                        <div class="col-12">
                            <label for="talent_content_id"
                                class="form-label small text-uppercase fw-bold text-secondary">Assign to Content <span
                                    class="text-danger">*</span></label>
                            <select class="form-select chosen-select" id="talent_content_id" name="content_id" required
                                data-placeholder="Select Content...">
                            </select>
                            <small class="text-muted fst-italic">Talent will be linked to the selected content
                                piece.</small>
                            <!-- Selected Content Info Card -->
                            <div id="talent_content_info" class="card bg-light border-0 d-none mt-2 rounded-4">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-info-circle-fill fs-5 text-primary me-2"></i>
                                        <h6 class="fw-bold mb-0 text-dark">Informasi Content</h6>
                                    </div>
                                    <div class="row g-2 mt-1">
                                        <div class="col-12">
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">Script
                                                Content</small>
                                            <span class="fw-medium text-dark" id="info-content-script">-</span>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <small class="text-muted d-block"
                                                style="font-size: 0.75rem;">Storyboard</small>
                                            <span class="fw-medium text-dark" id="info-content-storyboard">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section: Talent Mode Toggle -->
                        <div class="col-12 mt-3">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-2">Talent Source</h6>
                            <div class="d-flex gap-2 mt-2 mb-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="talent_mode" id="talent_mode_new"
                                        value="new" checked>
                                    <label class="form-check-label fw-semibold" for="talent_mode_new">
                                        <i class="bi bi-person-plus me-1"></i> New Talent
                                    </label>
                                </div>
                                <div class="form-check ms-3">
                                    <input class="form-check-input" type="radio" name="talent_mode"
                                        id="talent_mode_existing" value="existing">
                                    <label class="form-check-label fw-semibold" for="talent_mode_existing">
                                        <i class="bi bi-person-check me-1"></i> Existing Talent
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Existing Talent Search (shown in existing mode) -->
                        <div class="col-12" id="existing_talent_search_row" style="display:none;">
                            <label for="talent_existing_select"
                                class="form-label small text-uppercase fw-bold text-secondary">Select Existing Talent
                                <span class="text-danger">*</span></label>
                            <select class="form-select chosen-select" id="talent_existing_select"
                                data-placeholder="Search & select talent from master list...">
                                <option value=""></option>
                            </select>
                            <small class="text-muted fst-italic">Selecting will auto-fill fields below. You may override
                                any field.</small>
                        </div>

                        <!-- Section: Identitas Talent -->
                        <div class="col-12 mt-2" id="talent_identity_section">
                            <div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-3">
                                <h6 class="fw-bold text-dark mb-0">Identitas Talent</h6>
                                <button type="button" class="btn btn-warning btn-sm rounded-2 px-3 text-white"
                                    id="btnSurpriseMeTalent">
                                    <i class="bi bi-stars me-1"></i> Surprise Me
                                </button>
                            </div>
                        </div>

                        <!-- Talent Name -->
                        <div class="col-md-6">
                            <label for="talent_name" class="form-label small text-uppercase fw-bold text-secondary">Nama
                                Talent <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="talent_name" name="talent_name"
                                placeholder="Talent Name" required>
                        </div>

                        <!-- Content Niche -->
                        <div class="col-md-6">
                            <label for="talent_niche"
                                class="form-label small text-uppercase fw-bold text-secondary">Niche Konten</label>
                            <input type="text" class="form-control" id="talent_niche" name="content_niche"
                                placeholder="Content Niche">
                        </div>

                        <!-- Usernames -->
                        <div class="col-md-6">
                            <label for="talent_tiktok"
                                class="form-label small text-uppercase fw-bold text-secondary">Username TikTok</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-tiktok"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="talent_tiktok"
                                    name="username_tiktok" placeholder="TikTok Username">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="talent_ig"
                                class="form-label small text-uppercase fw-bold text-secondary">Username IG</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i
                                        class="bi bi-instagram"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="talent_ig"
                                    name="username_ig" placeholder="Instagram Username">
                            </div>
                        </div>


                        <!-- Section: Karakter & Gaya -->
                        <div class="col-12 mt-4">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Karakter & Gaya</h6>
                        </div>

                        <!-- Persona -->
                        <div class="col-12">
                            <label for="talent_persona"
                                class="form-label small text-uppercase fw-bold text-secondary">Persona <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control d-none" name="persona" id="talent_persona" rows="3"
                                required></textarea>
                            <div id="talent_overtype_persona" style="height: 150px;"></div>
                        </div>

                        <!-- Communication Style -->
                        <div class="col-12">
                            <label for="talent_communication_style"
                                class="form-label small text-uppercase fw-bold text-secondary">Gaya Komunikasi</label>
                            <input type="text" class="form-control" id="talent_communication_style"
                                name="communication_style" placeholder="Describe communication style">
                        </div>


                        <!-- Section: Budget & Tim -->
                        <div class="col-12 mt-4">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Budget & Tim</h6>
                        </div>

                        <!-- Rate -->
                        <div class="col-md-6">
                            <label for="talent_rate" class="form-label small text-uppercase fw-bold text-secondary">Rate
                                <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">Rp</span>
                                <input type="text" class="form-control border-start-0 ps-0" id="talent_rate" name="rate"
                                    placeholder="0" required onkeyup="formatRupiah(this)">
                            </div>
                        </div>

                        <!-- PIC -->
                        <div class="col-md-6">
                            <label for="talent_pic" class="form-label small text-uppercase fw-bold text-secondary">PIC
                                <span class="text-danger">*</span></label>
                            <select class="form-select chosen-select" id="talent_pic" name="pic[]" multiple
                                data-placeholder="Pilih PIC..." required>
                            </select>
                            <select id="talent_status" name="status" class="d-none"></select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-soft-blue">
                <button type="button" class="btn btn-light rounded-2 px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="ms-2 btn btn-primary rounded-2 px-4" id="btnSaveTalent">Save
                    Talent</button>
            </div>
        </div>
    </div>
</div>

<!-- Strategy Detail Modal -->
<div class="modal fade sub_modal" id="strategyTalentDetailModal" tabindex="-1"
    aria-labelledby="strategyTalentDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 bg-soft-purple">
                <h5 class="modal-title fw-bold text-purple" id="strategyTalentDetailModalLabel">Strategy Detail</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 bg-soft-purple">
                <div id="strategyTalentDetailContent">
                    <div class="text-center">
                        <div class="spinner-border text-purple" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-soft-purple">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Invite Talent Team Modal -->
<div class="modal fade sub_modal" id="inviteTalentTeamModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 bg-white">
                <h5 class="modal-title fw-bold" id="inviteTalentTeamModalLabel">Invite Talent Team</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-white">
                <form id="formInviteTalentTeam">
                    <input type="hidden" name="campaign_id" id="invite_talent_campaign_id">
                    <div class="mb-3">
                        <label class="form-label small text-uppercase fw-bold text-secondary">Team Members</label>
                        <select class="form-select chosen-select" name="team[]" id="invite_talent_team_select" multiple
                            data-placeholder="Choose members...">
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-white border-top-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" id="btnSaveTalentTeam">Save
                    Changes</button>
            </div>
        </div>
    </div>
</div>


<!-- View Talent Detail Modal -->
<div class="modal sub_modal fade" id="viewTalentDetailModal" tabindex="-1" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 bg-soft-blue">
                <div class="d-flex align-items-center gap-3 w-100">
                    <h5 class="modal-title fw-bold" id="viewTalentDetailModalLabel">Talent Detail</h5>
                    <span class="badge bg-light text-secondary border rounded-pill px-2 py-1"
                        id="view_talent_status_badge">-</span>
                    <button type="button" class="btn-close ms-auto shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body px-4 bg-soft-blue">
                <div class="row g-4">
                    <!-- Main Content -->
                    <div class="col-lg-8">
                        <!-- Header Meta -->
                        <div class="d-flex align-items-center mb-4 text-muted small">
                            <i class="bi bi-person-video2 me-2"></i> <span id="view_talent_niche_meta">Niche</span>
                            <span class="mx-2">•</span>
                            <span id="view_talent_id_meta">#ID</span>
                        </div>

                        <!-- General Info -->
                        <div class="row ps-3 pe-3">
                            <div class="col-12">
                                <p class="title mb-4 text-uppercase fw-bold text-muted mb-2 mt-2 fs-14">General
                                    Information</p>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Name</label>
                                <p class="text-secondary fw-bold" id="view_talent_name">-</p>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Rate</label>
                                <p class="text-theme fw-bold" id="view_talent_rate">-</p>
                            </div>
                        </div>

                        <!-- Socials -->
                        <div class="row ps-3 pe-3">
                            <div class="col-12 mt-3">
                                <p class="title mb-3 text-uppercase fw-bold text-muted mb-2 fs-14">Linked Content</p>
                            </div>
                            <div class="col-12 mb-3">
                                <div id="view_talent_linked_content" class="p-2">
                                    <span class="text-muted small fst-italic">Loading...</span>
                                </div>
                            </div>
                        </div>

                        <!-- Socials -->
                        <div class="row ps-3 pe-3">
                            <div class="col-12 mt-3">
                                <p class="title mb-3 text-uppercase fw-bold text-muted mb-2 fs-14">Social Media</p>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">TikTok</label>
                                <p class="text-secondary" id="view_talent_tiktok">-</p>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Instagram</label>
                                <p class="text-secondary" id="view_talent_ig">-</p>
                            </div>
                        </div>

                        <!-- Character & Style -->
                        <div class="row ps-3 pe-3">
                            <div class="col-12 mt-3">
                                <p class="title mb-3 text-uppercase fw-bold text-muted mb-2 fs-14">Character & Style</p>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Persona</label>
                                <div class="text-secondary bg-light p-3 rounded" id="view_talent_persona"
                                    style="white-space: pre-line;">-</div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Communication
                                    Style</label>
                                <div class="text-secondary" id="view_talent_style">-</div>
                            </div>
                        </div>

                        <!-- AI Analysis Section -->
                        <div class="card bg-dark text-white border-0 shadow-lg text-start mb-4 position-relative overflow-hidden rounded-4 mt-4"
                            id="talent_ai_analysis_card"
                            style="background: linear-gradient(145deg, #1a1f3c 0%, #111425 100%);">
                            <!-- Background Glow Effect -->
                            <div class="position-absolute top-0 start-0 w-100 h-100"
                                style="background: radial-gradient(circle at 10% 10%, rgba(139, 92, 246, 0.15) 0%, transparent 40%); pointer-events: none;">
                            </div>

                            <!-- Before Analysis State -->
                            <div id="talent_ai_analysis_empty" class="card-body bg-none p-5 text-center">
                                <div class="mb-3">
                                    <i class="bi bi-stars text-warning display-4"></i>
                                </div>
                                <h5 class="fw-bold mb-2">AI Talent Analysis</h5>
                                <p class="text-white-50 mb-4">Get instant insights, potential risks, and optimization
                                    recommendations for this talent.</p>
                                <button class="btn btn-primary px-4 py-2 rounded-pill shadow-lg"
                                    id="btn_run_talent_analysis">
                                    <i class="bi bi-cpu me-2"></i> Run AI Analysis
                                </button>
                            </div>

                            <!-- After Analysis State (Hidden by default) -->
                            <div id="talent_ai_analysis_content" class="card-body bg-none p-4 d-none">
                                <!-- Header & Score -->
                                <div
                                    class="d-flex justify-content-between align-items-center mb-4 border-bottom border-white border-opacity-10 pb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-stars text-primary fs-4"></i>
                                        <h6 class="fw-bold mb-0 text-uppercase letter-spacing-1">AI Talent Analysis</h6>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 bg-white bg-opacity-10 px-3 py-1 rounded-pill"
                                        id="talent_ai_score_container">
                                        <span class="h5 fw-bold mb-0" id="talent_ai_score">0</span>
                                        <span class="small text-white-50 text-uppercase"
                                            style="font-size: 10px;">Score</span>
                                        <button class="btn btn-primary btn-sm rounded-pill shadow-lg ms-2"
                                            id="btn_reanalyze_talent">
                                            <i class="bi bi-arrow-repeat me-1"></i> Re-Analyze
                                        </button>
                                    </div>
                                </div>

                                <!-- Final Decision Banner -->
                                <div class="mb-4 p-3 rounded-3" id="talent_ai_decision_banner"
                                    style="background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.15);">
                                    <div class="d-flex align-items-start gap-3">
                                        <i class="bi bi-patch-check-fill fs-3 text-warning flex-shrink-0 mt-1"></i>
                                        <div>
                                            <p class="fw-bold text-white mb-1 small text-uppercase"
                                                style="letter-spacing:.05em;">Final Decision</p>
                                            <p class="fw-bold fs-6 mb-1 text-white" id="talent_ai_keputusan_akhir">-</p>
                                            <p class="text-white-50 small mb-0" id="talent_ai_alasan_keputusan">-</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Executive Summary -->
                                <div class="alert bg-white bg-opacity-10 border-0 text-white-50 mb-4 p-3 rounded-3">
                                    <h6 class="text-white fw-bold text-uppercase small mb-2"><i
                                            class="bi bi-card-text me-2"></i> Executive Summary</h6>
                                    <ul class="mb-0 small ps-3" id="talent_ai_executive_summary"></ul>
                                </div>

                                <!-- Match Score Metrics -->
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <div
                                            class="p-3 rounded h-100 bg-black bg-opacity-25 border border-white border-opacity-10">
                                            <h6 class="text-info fw-bold text-uppercase small mb-3"><i
                                                    class="bi bi-bullseye me-2"></i>Fit & Alignment</h6>
                                            <div id="talent_ai_fit_alignment_stats"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="p-3 rounded h-100 bg-black bg-opacity-25 border border-white border-opacity-10">
                                            <h6 class="text-warning fw-bold text-uppercase small mb-3"><i
                                                    class="bi bi-person-heart me-2"></i>Audience & Impact</h6>
                                            <div id="talent_ai_audience_delivery_stats"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Risk Analysis -->
                                <h6 class="text-uppercase fw-bold text-white-50 mb-3 small letter-spacing-1"><i
                                        class="bi bi-shield-exclamation me-2"></i>Talent Risk Analysis</h6>
                                <div class="row g-3 mb-4" id="talent_ai_risk_grid"></div>

                                <!-- Usage Recommendations -->
                                <div class="p-3 rounded position-relative"
                                    style="background: rgba(139, 92, 246, 0.1); border: 1px solid rgba(139, 92, 246, 0.2);">
                                    <h6 class="text-primary fw-bold text-uppercase small mb-3">
                                        <i class="bi bi-lightbulb-fill me-2"></i> Talent Usage Recommendations
                                    </h6>
                                    <div class="row g-3" id="talent_ai_recommendations_grid"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4 border-start">
                        <div class="ps-3 pe-3 mb-4">
                            <h6 class="text-uppercase small fw-bold text-muted mb-4"><i
                                    class="bi bi-person-fill me-2"></i>Created By</h6>
                            <div class="d-flex align-items-center" id="view_talent_assigned">
                                <div class="row avatar-group">
                                    <!-- Avatars will be injected here -->
                                    <div
                                        class="avatar avatar-xs rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ps-3 pe-3 d-flex align-items-center justify-content-between mb-4">
                            <h6 class="fw-bold text-uppercase text-muted small mb-0"><i
                                    class="bi bi-clock-history me-2"></i> Activity Log</h6>
                        </div>
                        <div class="timeline-sm ps-3 border-start border-2 ms-2 gap-3 d-flex flex-column"
                            id="talent_activity_log">
                            <!-- JS Injects here -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-soft-blue border-top-0">
                <button type="button" class="btn btn-light rounded-3 px-4 me-auto"
                    data-bs-dismiss="modal">Close</button>

                <button type="button" class="btn btn-outline-danger rounded-3 px-4 d-none me-2"
                    id="btnCancelApproveTalent">
                    <i class="bi bi-x-circle me-2"></i>Cancel Approval
                </button>
                <button type="button" class="btn btn-warning rounded-3 px-4 text-white me-2" id="btnRejectTalentPlan">
                    <i class="bi bi-arrow-return-left me-2"></i>Revise / Reject
                </button>
                <button type="button" class="btn btn-success rounded-3 px-4 me-2" id="btnApproveTalentPlan" disabled>
                    <i class="bi bi-check-circle me-2"></i>Approve Plan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Talent Analysis Modal -->
<div class="modal sub_modal fade" id="modal-talent-analysis" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content rounded-4 border-0 shadow-lg bg-light">
            <div class="modal-header border-bottom-0 pb-0 bg-white rounded-top-4 pt-4 px-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-1" id="talent-analysis-modal-title">Talent Analysis</h5>
                    <p class="text-muted small mb-0" id="talent-analysis-modal-subtitle">AI-Powered Strategic Insights
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" id="talent-analysis-modal-body">
                <div class="card border-0 shadow-none bg-transparent">
                    <div class="card-body p-0">
                        <div class="bg-dark rounded-4 overflow-hidden"
                            style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important;">
                            <!-- Background Glow Effect -->
                            <div class="position-absolute top-0 start-0 w-100 h-100"
                                style="background: radial-gradient(circle at 10% 10%, rgba(139, 92, 246, 0.15) 0%, transparent 40%); pointer-events: none;">
                            </div>

                            <!-- Before Analysis State -->
                            <div id="talent_ai_analysis_empty" class="card-body bg-none p-5 text-center">
                                <div class="mb-3">
                                    <i class="bi bi-stars text-warning display-4"></i>
                                </div>
                                <h5 class="fw-bold mb-2 text-white">AI Talent Analysis</h5>
                                <p class="text-white-50 mb-4">Get instant insights, potential risks, and strategic
                                    recommendations for this talent collaboration.</p>
                                <button class="btn btn-primary px-4 py-2 rounded-pill shadow-lg"
                                    id="btn_run_talent_analysis">
                                    <i class="bi bi-cpu me-2"></i> Run AI Analysis
                                </button>
                            </div>

                            <!-- After Analysis State (Hidden by default) -->
                            <div id="talent_ai_analysis_content"
                                class="card-body bg-none p-4 d-none text-white position-relative">
                                <div
                                    class="d-flex justify-content-between align-items-center mb-4 border-bottom border-white border-opacity-10 pb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-stars text-primary fs-4"></i>
                                        <h6 class="fw-bold mb-0 text-uppercase letter-spacing-1 text-white">AI Talent
                                            Analysis</h6>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 bg-white bg-opacity-10 px-3 py-1 rounded-pill"
                                        id="talent_ai_score_container">
                                        <span class="h5 fw-bold mb-0 text-white" id="talent_ai_score">0</span>
                                        <span class="small text-white-50 text-uppercase" style="font-size: 10px;">AI
                                            Strategic Score</span>
                                        <button class="btn btn-primary btn-sm rounded-pill shadow-lg ms-2"
                                            id="btn_reanalyze_talent">
                                            <i class="bi bi-arrow-repeat me-1"></i> Re-Analyze
                                        </button>
                                    </div>
                                </div>

                                <!-- Final Decision Banner -->
                                <div class="mb-4 p-3 rounded-3"
                                    style="background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.15);">
                                    <div class="d-flex align-items-start gap-3">
                                        <i class="bi bi-patch-check-fill fs-3 text-warning flex-shrink-0 mt-1"></i>
                                        <div>
                                            <p class="fw-bold text-white mb-1 small text-uppercase"
                                                style="letter-spacing:.05em;">Final Decision</p>
                                            <p class="fw-bold fs-6 mb-1 text-white" id="talent_ai_keputusan_akhir">-</p>
                                            <p class="text-white-50 small mb-0" id="talent_ai_alasan_keputusan">-</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Executive Summary -->
                                <div class="alert bg-white bg-opacity-10 border-0 text-white-50 mb-4 p-3 rounded-3">
                                    <h6 class="text-white fw-bold text-uppercase small mb-2"><i
                                            class="bi bi-card-text me-2"></i> Executive Summary</h6>
                                    <ul class="mb-0 small ps-3" id="talent_ai_executive_summary"></ul>
                                </div>

                                <!-- Match Score Metrics -->
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <div
                                            class="p-3 rounded h-100 bg-black bg-opacity-25 border border-white border-opacity-10">
                                            <h6 class="text-info fw-bold text-uppercase small mb-3"><i
                                                    class="bi bi-bullseye me-2"></i>Fit & Alignment</h6>
                                            <div id="talent_ai_fit_alignment_stats"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="p-3 rounded h-100 bg-black bg-opacity-25 border border-white border-opacity-10">
                                            <h6 class="text-warning fw-bold text-uppercase small mb-3"><i
                                                    class="bi bi-person-heart me-2"></i>Audience & Impact</h6>
                                            <div id="talent_ai_audience_delivery_stats"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Risk Analysis -->
                                <h6 class="text-uppercase fw-bold text-white-50 mb-3 small letter-spacing-1"><i
                                        class="bi bi-shield-exclamation me-2"></i>Talent Risk Analysis</h6>
                                <div class="row g-3 mb-4" id="talent_ai_risk_grid"></div>

                                <!-- Usage Recommendations -->
                                <div class="p-3 rounded position-relative"
                                    style="background: rgba(139, 92, 246, 0.1); border: 1px solid rgba(139, 92, 246, 0.2);">
                                    <h6 class="text-primary fw-bold text-uppercase small mb-3">
                                        <i class="bi bi-lightbulb-fill me-2"></i> Talent Usage Recommendations
                                    </h6>
                                    <div class="row g-3" id="talent_ai_recommendations_grid"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0 bg-white rounded-bottom-4 px-4 py-3 justify-content-between">
                <span class="text-muted small fst-italic">Generated on <span id="talent-analysis-date">-</span></span>
                <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Revision Talent -->
<div class="modal fade" id="revisionTalentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Revision Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted small mb-3">Please provide a reason or note for revision/rejection.</p>
                <textarea id="talent_revision_note" class="form-control rounded-3" rows="4"
                    placeholder="Type your note here..."></textarea>
            </div>
            <div class="modal-footer border-top-0 px-4 pb-4 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger rounded-pill px-4" id="btnConfirmRejectTalent">Confirm
                    Revision</button>
            </div>
        </div>
    </div>
</div>