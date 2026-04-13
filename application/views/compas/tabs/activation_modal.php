<!-- Activation Analysis Modal -->
<div class="modal sub_modal fade" id="modal-activation-analysis" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content rounded-4 border-0 shadow-lg bg-light">
            <div class="modal-header border-bottom-0 pb-0 bg-white rounded-top-4 pt-4 px-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-1" id="analysis-modal-title">Activation Analysis</h5>
                    <p class="text-muted small mb-0" id="analysis-modal-subtitle">AI-Powered Strategic Insights</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="analysis-modal-body">
                <!-- Content will be injected here via JS -->
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted">Analyzing Activation Data...</p>
                </div>
            </div>
            <div class="modal-footer border-top-0 bg-white rounded-bottom-4 px-4 py-3 justify-content-between">
                <span class="text-muted small fst-italic">Generated on <span id="analysis-date">-</span></span>
                <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Activation Form Modal -->
<div class="modal sub_modal fade" id="modal-activation-form" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-1" id="activation-modal-title">Add Activation</h5>
                    <p class="text-muted small mb-0">Fill in the details for the activation task.</p>
                </div>

                <button type="button" class="ms-auto btn btn-warning rounded-2 text-white btn-sm"
                    id="btnSurpriseMeActivation"><i class="bi bi-stars me-1"></i> Surprise Me</button>
                <button type="button" class="ms-2 btn-close shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Wizard Progress -->
                <div class="wizard-progress mb-4">
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 33%;" aria-valuenow="33"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <form class="g-3" id="activation-form">
                    <input type="hidden" name="activation_id" id="form-activation-id"> <!-- Added for Edit -->
                    <input type="hidden" name="campaign_id" id="form-campaign-id">
                    <input type="hidden" name="activation_target" id="form-activation-target">

                    <!-- Step 1: Identitas & Konteks -->
                    <div class="wizard-step" data-step="1">
                        <p class="fw-medium title" style="line-height: 1.5;">Identitas & Konteks<br>
                            <small class="text-muted">Informasi dasar mengenai aktivasi ini.</small>
                        </p>
                        <div class="row">
                            <!-- Campaign Info Card -->
                            <div class="col-12 mb-3">
                                <div class="card bg-light border-0 rounded-4">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-megaphone fs-5 text-primary me-2"></i>
                                            <h6 class="fw-bold mb-0 text-dark">Informasi Campaign</h6>
                                        </div>
                                        <div class="row g-2 mt-1">
                                            <div class="col-sm-4">
                                                <small class="text-muted d-block" style="font-size: 0.75rem;">Judul
                                                    Campaign</small>
                                                <span class="fw-medium text-dark" id="info-campaign-name">-</span>
                                            </div>
                                            <div class="col-sm-4">
                                                <small class="text-muted d-block" style="font-size: 0.75rem;">Periode
                                                    Campaign</small>
                                                <span class="fw-medium text-dark" id="info-campaign-period">-</span>
                                            </div>
                                            <div class="col-sm-4 mt-2">
                                                <small class="text-muted d-block"
                                                    style="font-size: 0.75rem;">Objective</small>
                                                <span class="fw-medium text-dark" id="info-campaign-objective">-</span>
                                            </div>
                                            <div class="col-sm-6 mt-2 d-none">
                                                <small class="text-muted d-block" style="font-size: 0.75rem;">Pilar
                                                    Konten</small>
                                                <span class="fw-medium text-dark" id="info-campaign-pillar">-</span>
                                            </div>
                                            <div class="col-12 mt-2 d-none">
                                                <small class="text-muted d-block" style="font-size: 0.75rem;">Content
                                                    Angle</small>
                                                <span class="fw-medium text-dark" id="info-campaign-angle">-</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Hide the standard campaign name input structure but keep ID for JS if needed -->
                                <input type="hidden" id="form-campaign-name">
                            </div>

                            <!-- Target Audiens -->
                            <div class="col-12 mb-3">
                                <div class="form-group position-relative check-valid">
                                    <textarea placeholder="Target Audiens" name="target_audience"
                                        id="form-target-audience" class="form-control d-none rounded-4"
                                        required></textarea>
                                    <div class="overtype-section">
                                        <div class="overtype-header">
                                            <p class="fw-medium mb-0">Target Audiens <sup class="text-danger">*</sup>
                                            </p>
                                        </div>
                                        <div id="overtype-target-audience" style="height: 150px;"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Judul -->
                            <div class="col-12 mb-3">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0"
                                                id="form-activation-title" name="title" placeholder="Judul" required>
                                            <label for="form-activation-title">Judul <sup
                                                    class="text-danger">*</sup></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Periode Aktivasi -->
                            <div class="col-6 mb-3">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0 tanggal"
                                                id="form-activation-period-start" name="period_start"
                                                placeholder="Activation Start Date" required>
                                            <label for="form-activation-period-start">Activation Start Date <sup
                                                    class="text-danger">*</sup></label>
                                        </div>
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 mb-3">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0 tanggal"
                                                id="form-activation-period-end" name="period_end"
                                                placeholder="Activation End Date" required>
                                            <label for="form-activation-period-end">Activation End Date <sup
                                                    class="text-danger">*</sup></label>
                                        </div>
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Aktivasi -->
                    <div class="wizard-step" data-step="2" style="display: none;">
                        <p class="fw-medium title" style="line-height: 1.5;">Aktivasi<br>
                            <small class="text-muted">Detail pelaksanaan aktivasi.</small>
                        </p>
                        <div class="row">
                            <!-- Aktivasi yang Berjalan -->
                            <div class="col-12 mb-3">
                                <div class="form-group position-relative check-valid">
                                    <textarea placeholder="Aktivasi yang Berjalan" name="description"
                                        id="form-current-activation" class="form-control d-none rounded-4"
                                        required></textarea>
                                    <div class="overtype-section">
                                        <div class="overtype-header">
                                            <p class="fw-medium mb-0">Aktivasi yang Berjalan <sup
                                                    class="text-danger">*</sup></p>
                                        </div>
                                        <div id="overtype-current-activation" style="height: 300px;"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- PIC -->
                            <div class="col-6 mb-3">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <!-- Using standard select but with chosen-select class to be initialized in JS -->
                                            <select class="chosen-select form-select border-start-0" id="form-pic"
                                                name="pic[]" multiple data-placeholder="Pilih PIC..." required>
                                            </select>
                                            <label for="form-pic">PIC <sup class="text-danger">*</sup></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Budget -->
                            <div class="col-6 mb-3">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0" id="form-budget"
                                                name="budget" placeholder="Budget" required>
                                            <label for="form-budget">Budget <sup class="text-danger">*</sup></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Konten -->
                    <!-- <div class="wizard-step" data-step="3" style="display: none;">
                        <p class="fw-medium title" style="line-height: 1.5;">Konten<br>
                            <small class="text-muted">Output konten dan platform tujuan.</small>
                        </p>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <select class="chosen-select form-select border-start-0" id="content-result"
                                                name="content_result[]" multiple
                                                data-placeholder="Pilih Konten yang dihasilkan" required>
                                            </select>
                                            <label for="content-result">Konten yang Dihasilkan <sup
                                                    class="text-danger">*</sup></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 mb-3">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <select class="chosen-select form-select border-start-0"
                                                id="platform-tujuan" name="platform[]" multiple
                                                data-placeholder="Pilih Platform Tujuan" required>
                                            </select>
                                            <label for="platform-tujuan">Platform Tujuan <sup
                                                    class="text-danger">*</sup></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </form>
            </div>
            <div class="modal-footer border-top-0 px-4 pb-4 pt-0 justify-content-between">
                <button type="button" class="btn btn-secondary btn-prev rounded-pill px-4" disabled>Previous</button>
                <div>
                    <button type="button" class="btn btn-primary btn-next rounded-pill px-4">Next</button>
                    <button type="button" class="btn btn-success btn-finish rounded-pill px-4" style="display: none;"
                        onclick="submitActivationForm()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Invite Team Modal -->
<div class="modal fade sub_modal" id="inviteActivationTeamModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-1">Invite Activation Team</h5>
                    <p class="text-muted small mb-0">Select members to join the activation team.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formInviteActivationTeam">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Team Members</label>
                        <select class="form-select chosen-select" id="invite_activation_team_select" name="team[]"
                            multiple data-placeholder="Select team members...">
                            <!-- Populated by JS -->
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 px-4 pb-4 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" id="btnSaveActivationTeam">Save
                    Team</button>
            </div>
        </div>
    </div>
</div>
<!-- View Activation Detail Modal -->
<div class="modal sub_modal fade" id="viewActivationDetailModal" tabindex="-1"
    aria-labelledby="viewActivationDetailModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 bg-soft-blue">
                <div class="d-flex align-items-center gap-3 w-100">
                    <h5 class="modal-title fw-bold" id="viewActivationDetailModalLabel">Activation Detail</h5>
                    <span class="badge bg-light-green text-success px-3 rounded-3 py-2"
                        id="view_activation_priority">-</span>
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
                            <i class="bi bi-folder2-open me-2"></i> <span id="view_activation_category">Activation
                                Task</span>
                            <span class="mx-2">•</span>
                            <span id="view_activation_id">#ACT-000</span>
                        </div>

                        <div class="row ps-3 pe-3">
                            <div class="col-12">
                                <p class="title mb-4 text-uppercase fw-bold text-muted mb-2 mt-2 fs-14">
                                    General Information</p>
                            </div>

                            <div class="col-6 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Title</label>
                                <p class="text-secondary" id="view_activation_title">-</p>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Status</label>
                                <span class="badge bg-light text-dark" id="view_activation_status">-</span>
                            </div>

                            <div class="col-6 mb-3">
                                <label class="text-uppercase small fw-bold text-muted mb-2">Start Date</label>
                                <div class="d-flex align-items-center text-dark fw-medium">
                                    <i class="bi bi-calendar4 me-2 text-primary"></i>
                                    <span id="view_activation_period_start">-</span>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="text-uppercase small fw-bold text-muted mb-2">End Date</label>
                                <div class="d-flex align-items-center text-dark fw-medium">
                                    <i class="bi bi-calendar-check me-2 text-danger"></i>
                                    <span id="view_activation_period_end">-</span>
                                </div>
                            </div>

                            <!-- Additional Details -->
                            <div class="col-12 mt-3">
                                <p class="title mb-3 text-uppercase fw-bold text-muted mb-2 fs-14">Details</p>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Budget</label>
                                <p class="text-secondary" id="view_activation_budget">-</p>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Platform</label>
                                <p class="text-secondary" id="view_activation_platform">-</p>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Content
                                    Generated</label>
                                <p class="text-secondary" id="view_activation_content_generated">-</p>
                            </div>

                            <!-- Text Areas -->
                            <div class="col-12 mt-3">
                                <p class="title mb-3 text-uppercase fw-bold text-muted mb-2 fs-14">Description & Context
                                </p>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Target
                                    Audience</label>
                                <div class="text-secondary bg-light p-3 rounded" id="view_activation_target_audience">-
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Current Activation
                                    Description</label>
                                <div class="text-secondary bg-light p-3 rounded" id="view_activation_description">-
                                </div>
                            </div>

                        </div>

                        <!-- AI Analysis Section -->
                        <div class="card bg-dark text-white border-0 shadow-lg text-start mb-4 position-relative overflow-hidden rounded-4"
                            id="activation_ai_analysis_card"
                            style="background: linear-gradient(145deg, #1a1f3c 0%, #111425 100%);">

                            <!-- Background Glow Effect -->
                            <div class="position-absolute top-0 start-0 w-100 h-100"
                                style="background: radial-gradient(circle at 10% 10%, rgba(139, 92, 246, 0.15) 0%, transparent 40%); pointer-events: none;">
                            </div>

                            <!-- Before Analysis State -->
                            <div id="activation_ai_analysis_empty" class="card-body bg-none p-5 text-center">
                                <div class="mb-3">
                                    <i class="bi bi-stars text-warning display-4"></i>
                                </div>
                                <h5 class="fw-bold mb-2">AI Activation Analysis</h5>
                                <p class="text-white-50 mb-4">Get instant insights, potential risks, and optimization
                                    recommendations for this activation plan.</p>
                                <button class="btn btn-primary px-4 py-2 rounded-pill shadow-lg"
                                    id="btn_run_activation_analysis">
                                    <i class="bi bi-cpu me-2"></i> Run AI Analysis
                                </button>
                            </div>

                            <!-- After Analysis State (Hidden by default) -->
                            <div id="activation_ai_analysis_content" class="card-body bg-none p-4 d-none">
                                <!-- Header & Score -->
                                <div
                                    class="d-flex justify-content-between align-items-center mb-4 border-bottom border-white border-opacity-10 pb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-stars text-primary fs-4"></i>
                                        <h6 class="fw-bold mb-0 text-uppercase letter-spacing-1">AI Activation Analysis
                                        </h6>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 bg-white bg-opacity-10 px-3 py-1 rounded-pill"
                                        data-bs-toggle="tooltip" data-bs-placement="left" title=""
                                        id="activation_ai_score_container">
                                        <span class="h5 fw-bold mb-0" id="activation_ai_score">0</span>
                                        <span class="small text-white-50 text-uppercase"
                                            style="font-size: 10px;">Score</span>
                                        <button class="btn btn-primary btn-sm rounded-pill shadow-lg ms-2"
                                            id="btn_reanalyze_activation">
                                            <i class="bi bi-arrow-repeat me-1"></i> Re-Analyze
                                        </button>
                                    </div>
                                </div>

                                <!-- Executive Summary -->
                                <div class="alert bg-white bg-opacity-10 border-0 text-white-50 mb-4 p-3 rounded-3">
                                    <h6 class="text-white fw-bold text-uppercase small mb-2"><i
                                            class="bi bi-card-text me-2"></i> Executive Summary</h6>
                                    <ul class="mb-0 small ps-3" id="activation_ai_executive_summary"></ul>
                                </div>

                                <!-- Detailed Analysis Tabs/Grid -->
                                <div class="row g-3 mb-4">
                                    <!-- Strategic & Funnel -->
                                    <div class="col-md-6">
                                        <div
                                            class="p-3 rounded h-100 bg-black bg-opacity-25 border border-white border-opacity-10">
                                            <h6 class="text-info fw-bold text-uppercase small mb-3">Strategy & Funnel
                                            </h6>
                                            <div id="activation_ai_strategy_funnel_stats"></div>
                                        </div>
                                    </div>
                                    <!-- Hook & Script (Renamed for Activation? Keep same for now) -->
                                    <div class="col-md-6">
                                        <div
                                            class="p-3 rounded h-100 bg-black bg-opacity-25 border border-white border-opacity-10">
                                            <h6 class="text-warning fw-bold text-uppercase small mb-3">Engagement &
                                                Impact
                                            </h6>
                                            <div id="activation_ai_engagement_stats"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- SWOT Analysis -->
                                <h6 class="text-uppercase fw-bold text-white-50 mb-3 small letter-spacing-1">SWOT
                                    Analysis</h6>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <div class="p-3 rounded h-100"
                                            style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2);">
                                            <h6 class="text-success fw-bold text-uppercase small mb-2"><i
                                                    class="bi bi-lightning-fill me-2"></i> Strengths</h6>
                                            <ul class="list-unstyled mb-0 small text-white-50 d-flex flex-column gap-2"
                                                id="activation_ai_swot_strengths"></ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 rounded h-100"
                                            style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2);">
                                            <h6 class="text-danger fw-bold text-uppercase small mb-2"><i
                                                    class="bi bi-bandaid-fill me-2"></i> Weaknesses</h6>
                                            <ul class="list-unstyled mb-0 small text-white-50 d-flex flex-column gap-2"
                                                id="activation_ai_swot_weaknesses"></ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 rounded h-100"
                                            style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2);">
                                            <h6 class="text-primary fw-bold text-uppercase small mb-2"><i
                                                    class="bi bi-graph-up-arrow me-2"></i> Opportunities</h6>
                                            <ul class="list-unstyled mb-0 small text-white-50 d-flex flex-column gap-2"
                                                id="activation_ai_swot_opportunities"></ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 rounded h-100"
                                            style="background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.2);">
                                            <h6 class="text-warning fw-bold text-uppercase small mb-2"><i
                                                    class="bi bi-shield-exclamation me-2"></i> Threats</h6>
                                            <ul class="list-unstyled mb-0 small text-white-50 d-flex flex-column gap-2"
                                                id="activation_ai_swot_threats"></ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Projections, Costs & Risks -->
                                <div class="row g-3 mb-4">
                                    <div class="col-md-4">
                                        <div
                                            class="p-3 rounded h-100 bg-black bg-opacity-25 border border-white border-opacity-10">
                                            <h6 class="text-success fw-bold text-uppercase small mb-3">Performance Est.
                                            </h6>
                                            <div id="activation_ai_performance_stats" class="small text-white-50"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div
                                            class="p-3 rounded h-100 bg-black bg-opacity-25 border border-white border-opacity-10">
                                            <h6 class="text-warning fw-bold text-uppercase small mb-3">Cost Analysis
                                            </h6>
                                            <div id="activation_ai_cost_stats" class="small text-white-50"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div
                                            class="p-3 rounded h-100 bg-black bg-opacity-25 border border-white border-opacity-10">
                                            <h6 class="text-danger fw-bold text-uppercase small mb-3">Risk Assessment
                                            </h6>
                                            <div id="activation_ai_risk_stats" class="small text-white-50"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Strategic Recommendations -->
                                <div class="p-3 rounded position-relative"
                                    style="background: rgba(139, 92, 246, 0.1); border: 1px solid rgba(139, 92, 246, 0.2);">
                                    <h6 class="text-primary fw-bold text-uppercase small mb-3">
                                        <i class="bi bi-lightbulb-fill me-2"></i> Strategic Recommendations
                                    </h6>
                                    <div class="row g-3" id="activation_ai_recommendations_grid">
                                        <!-- Populated by JS -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Activity Log -->
                    <div class="col-lg-4 border-start">
                        <div class="ps-3 pe-3 mb-4">
                            <h6 class="text-uppercase small fw-bold text-muted mb-4"><i
                                    class="bi bi-person-fill me-2"></i>Assigned Team</h6>
                            <div class="d-flex align-items-center" id="view_activation_assigned">
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
                            id="activation-activity-log-container">
                            <!-- Logs will be loaded here via JS -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-soft-blue border-top-0">
                <button type="button" class="btn btn-light rounded-2 px-4 me-auto"
                    data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-danger rounded-3 px-4 d-none me-2"
                    id="btnCancelApproveActivation">
                    <i class="bi bi-x-circle me-2"></i>Cancel Approval
                </button>
                <button type="button" class="btn btn-warning rounded-3 px-4 text-white me-2" id="btnRejectActivation">
                    <i class="bi bi-arrow-return-left me-2"></i>Revise / Reject
                </button>
                <button type="button" class="btn btn-success rounded-3 px-4 me-2" id="btnApproveActivation" disabled>
                    <i class="bi bi-check-circle me-2"></i>Approve Activation
                </button>
            </div>
        </div>
    </div>
</div>