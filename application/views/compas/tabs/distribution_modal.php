<!-- Add Plan Modal -->
<div class="modal fade sub_modal" id="addDistributionPlanModal" data-bs-backdrop="static" data-bs-keyboard="false"
    data-bs-focus="false" aria-labelledby="addDistributionPlanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 bg-soft-blue">
                <h5 class="modal-title fw-bold" id="addDistributionPlanModalLabel">Add Distribution Plan</h5>
                <button type="button" class="ms-auto btn btn-warning rounded-2 px-4 text-white btn-sm"
                    id="btnDistributionSurpriseMe"><i class="bi bi-stars me-1"></i> Surprise Me</button>
                <button type="button" class="ms-2 btn-close shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 bg-soft-blue">
                <form id="formAddPlan" action="#" method="POST">
                    <input type="hidden" name="campaign_id" id="plan_campaign_id" value="">
                    <input type="hidden" name="distribution_id" id="plan_distribution_id" value="">

                    <div class="row g-3">
                        <!-- Content Strategy -->
                        <div class="col-12">
                            <label for="plan_content_id"
                                class="form-label small text-uppercase fw-bold text-secondary">Content
                                <span class="text-danger">*</span></label>
                            <select class="form-select chosen-select" id="plan_content_id" name="content_id"
                                data-placeholder="Select Content" required>
                                <option value="">Select Content</option>
                                <!-- Populated by JS -->
                            </select>

                            <!-- Content Detail Container -->
                            <div id="content_detail_container" class="mt-3 d-none">
                                <div class="card bg-light border-0 rounded-3">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-info-circle-fill text-primary me-2"></i>
                                            <h6 class="fw-bold small text-uppercase mb-0 text-primary">Content Strategy
                                                Detail</h6>
                                        </div>
                                        <div class="row g-3 small" id="content_detail_body">
                                            <!-- Dynamic Content -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Platform & Placement (Chosen JS) -->
                        <div class="col-md-6">
                            <label for="plan_platform"
                                class="form-label small text-uppercase fw-bold text-secondary">Platform <span
                                    class="text-danger">*</span></label>
                            <select class="form-select chosen-select" id="plan_platform" name="platform_id[]"
                                data-placeholder="Select Platform" multiple>
                                <option value="">Select Platform</option>
                                <!-- Populated by JS -->
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="plan_placement"
                                class="form-label small text-uppercase fw-bold text-secondary">Placement Type <span
                                    class="text-danger">*</span></label>
                            <select class="form-select chosen-select" id="plan_placement" name="placement_id[]"
                                data-placeholder="Select Placement" multiple>
                                <option value="">Select Placement</option>
                                <!-- Populated by JS -->
                            </select>
                        </div>

                        <!-- Collaboration -->
                        <div class="col-md-6">
                            <label for="plan_collaboration"
                                class="form-label small text-uppercase fw-bold text-secondary">Collaboration
                                Type <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="plan_collaboration" name="collaboration_type"
                                placeholder="e.g. Barter, Paid, Organic" required>
                        </div>

                        <!-- Cost & Deadline -->
                        <div class="col-md-6">
                            <label for="plan_cost" class="form-label small text-uppercase fw-bold text-secondary">Ads
                                Budget Allocation <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">Rp</span>
                                <input type="text" class="form-control border-start-0 ps-0" id="plan_cost"
                                    name="ads_budget_allocation" placeholder="0" onkeyup="formatRupiah(this)" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="plan_deadline"
                                class="form-label small text-uppercase fw-bold text-secondary">Deadline Publish <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control tanggal" id="plan_deadline" name="deadline_publish"
                                placeholder="00-00-0000 00:00:00" required>
                        </div>

                        <!-- Audience Demographics -->
                        <div class="col-12 mt-4">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Target Audience</h6>
                        </div>

                        <div class="col-md-6">
                            <label for="plan_age"
                                class="form-label small text-uppercase fw-bold text-secondary">Audience Age <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="plan_age" name="audience_age"
                                placeholder="e.g. 18-24, 25-34" required>
                        </div>
                        <div class="col-md-6">
                            <label for="plan_location"
                                class="form-label small text-uppercase fw-bold text-secondary">Audience Location <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="plan_location" name="audience_location"
                                placeholder="e.g. Jakarta, Surabaya" required>
                        </div>

                        <div class="col-12">
                            <label for="plan_segment"
                                class="form-label small text-uppercase fw-bold text-secondary">Audience Segment <span
                                    class="text-danger">*</span></label>
                            <div id="audience_segment" style="height: 200px;"></div>
                            <input type="hidden" name="audience_segment_val" id="audience_segment_val"
                                style="height: 200px;">
                        </div>
                        <div class="col-12">
                            <label for="audience_characteristics"
                                class="form-label small text-uppercase fw-bold text-secondary">Audience
                                Characteristics <span class="text-danger">*</span></label>
                            <div id="audience_characteristics" style="height: 200px;"></div>
                            <input type="hidden" name="audience_characteristics_val" id="audience_characteristics_val"
                                style="height: 200px;" required>
                        </div>

                        <!-- Communication Tone -->
                        <div class="col-12 mt-4">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Communication Style</h6>
                        </div>
                        <div class="col-12">
                            <label for="tone_of_communication"
                                class="form-label small text-uppercase fw-bold text-secondary">Tone of
                                Communication <span class="text-danger">*</span></label>
                            <div id="tone_of_communication" style="height: 200px;"></div>
                            <input type="hidden" name="tone_of_communication_val" id="tone_of_communication_val"
                                style="height: 200px;" required>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer bg-soft-blue">
                <button type="button" class="btn btn-light rounded-2 px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="ms-2 btn btn-primary rounded-2 px-4" id="btnSavePlan">Create Plan</button>
            </div>
        </div>
    </div>
</div>

<!-- Approved Content Detail Modal -->
<div class="modal fade sub_modal" id="approvedContentDistributionDetailModal" tabindex="-1"
    aria-labelledby="approvedContentDistributionDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 bg-soft-purple">
                <h5 class="modal-title fw-bold text-purple" id="approvedContentDistributionDetailModalLabel">Approved
                    Content Detail</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 bg-soft-purple">
                <div id="approvedContentDistributionDetailContent">
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

<!-- Invite Team Modal -->
<div class="modal fade sub_modal" id="inviteTeamDistributionModal" tabindex="-1"
    aria-labelledby="inviteTeamDistributionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 bg-white">
                <h5 class="modal-title fw-bold" id="inviteTeamDistributionModalLabel">Invite Distribution Team</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 bg-white">
                <form id="formInviteTeam">
                    <div class="mb-3">
                        <label for="invite_team_select"
                            class="form-label small text-uppercase fw-bold text-secondary">Select Team Members</label>
                        <select class="form-select chosen-select" id="invite_team_select" name="team[]" multiple
                            data-placeholder="Choose employees...">
                            <!-- Options will be populated by JS -->
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-white border-top-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" id="btnSaveTeam">Save Changes</button>
            </div>
        </div>
    </div>
</div>


<!-- View Distribution Plan Modal -->
<div class="modal fade sub_modal" id="viewPlanDistributionModal" data-bs-backdrop="static" data-bs-keyboard="false"
    data-bs-focus="false" tabindex="-1" aria-labelledby="viewPlanDistributionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 bg-soft-blue">
                <div class="d-flex align-items-center gap-3 w-100">
                    <h5 class="modal-title fw-bold" id="viewPlanDistributionModalLabel">Plan Detail</h5>
                    <span class="badge bg-light-green text-success px-3 rounded-3 py-2" id="view_plan_priority">-</span>
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
                            <i class="bi bi-folder2-open me-2"></i> <span id="view_plan_category">Distribution
                                Content</span>
                            <span class="mx-2">•</span>
                            <span id="view_plan_id"></span>
                        </div>

                        <!-- Detail Content -->
                        <div class="row ps-3 pe-3">
                            <label class="text-uppercase small fw-bold text-muted mb-2">Detail Content</label>
                            <p class="text-secondary" id="view_plan_desc"></p>
                        </div>

                        <!-- Additional Details Grid -->
                        <div class="row ps-3 pe-3">
                            <div class="col-12">
                                <p class="title mb-4 text-uppercase fw-bold text-muted mb-2 mt-2 fs-14">
                                    Distribution Plan</p>
                            </div>
                            <div class="col-4 mb-3 text-break">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Audience Age</label>
                                <p class="text-secondary" id="view_plan_audience_age">-</p>
                            </div>
                            <div class="col-4 mb-3 text-break">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Audience
                                    Location</label>
                                <p class="text-secondary" id="view_plan_audience_location">-</p>
                            </div>
                            <div class="col-4 mb-3 text-break">
                                <label class="text-uppercase small fw-bold text-muted mb-2">Collaboration Type</label>
                                <p class="text-secondary" id="view_plan_collaboration_type">
                                    -
                                </p>
                            </div>
                            <div class="col-4 mb-3 text-break">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Platform</label>
                                <p class="text-secondary" id="view_plan_platform">-</p>
                            </div>
                            <div class="col-4 mb-3 text-break">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Placement</label>
                                <p class="text-secondary" id="view_plan_placement">-</p>
                            </div>
                            <div class="col-4 mb-3 text-break">
                                <label class="text-uppercase small fw-bold text-muted mb-2">Ads Budget
                                    Allocation</label>
                                <p class="text-secondary" id="view_plan_ads_budget_allocation">
                                    -
                                </p>
                            </div>
                            <div class="col-8 mb-3">
                                <label class="text-uppercase small fw-bold text-muted mb-2">Audience Segment</label>
                                <p class="text-secondary" id="view_plan_audience_segment">
                                    -
                                </p>
                            </div>
                            <div class="col-4 mb-3 text-break">
                                <label class="text-uppercase small fw-bold text-muted mb-2">Due Date</label>
                                <div class="d-flex align-items-center text-dark fw-medium">
                                    <i class="bi bi-calendar4 me-2 text-primary"></i>
                                    <span id="view_plan_duedate">Oct 24, 2024</span>
                                </div>
                            </div>
                            <div class="col-6 mb-3 text-break">
                                <label class="text-uppercase small fw-bold text-muted mb-2">Audience
                                    Characteristics</label>
                                <p class="text-secondary" id="view_plan_audience_characteristics">
                                    -
                                </p>
                            </div>
                            <div class="col-6 mb-3 text-break">
                                <label class="text-uppercase small fw-bold text-muted mb-2">Tone of
                                    Communication</label>
                                <p class="text-secondary" id="view_plan_tone_of_communication">
                                    -
                                </p>
                            </div>
                        </div>

                        <!-- AI Analysis Section -->
                        <div class="card bg-dark text-white border-0 shadow-lg text-start mb-4 position-relative overflow-hidden rounded-4"
                            id="ai_analysis_card"
                            style="background: linear-gradient(145deg, #1a1f3c 0%, #111425 100%);">
                            <!-- Background Glow Effect -->
                            <div class="position-absolute top-0 start-0 w-100 h-100"
                                style="background: radial-gradient(circle at 10% 10%, rgba(139, 92, 246, 0.15) 0%, transparent 40%); pointer-events: none;">
                            </div>

                            <!-- Before Analysis State -->
                            <div id="ai_analysis_empty" class="card-body bg-none p-5 text-center">
                                <div class="mb-3">
                                    <i class="bi bi-stars text-warning display-4"></i>
                                </div>
                                <h5 class="fw-bold mb-2">AI Task Analysis</h5>
                                <p class="text-white-50 mb-4">Get instant insights, potential risks, and optimization
                                    recommendations for this distribution plan.</p>
                                <button class="btn btn-primary px-4 py-2 rounded-pill shadow-lg"
                                    id="btn_distribution_run_analysis">
                                    <i class="bi bi-cpu me-2"></i> Run AI Analysis
                                </button>
                            </div>

                            <div id="ai_analysis_content" class="card-body bg-none p-4 d-none">
                                <div
                                    class="d-flex justify-content-between align-items-center mb-4 border-bottom border-white border-opacity-10 pb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-stars text-primary fs-4"></i>
                                        <h6 class="fw-bold mb-0 text-uppercase letter-spacing-1">AI Task Analysis</h6>
                                    </div>
                                    <div
                                        class="d-flex align-items-center gap-2 bg-white bg-opacity-10 px-3 py-1 rounded-pill">
                                        <span class="h5 fw-bold mb-0" id="ai_score">0</span>
                                        <span class="small text-white-50 text-uppercase" style="font-size: 10px;">AI
                                            Efficiency Score</span>
                                        <button class="btn btn-primary btn-sm rounded-pill shadow-lg"
                                            id="btn_distribution_reanalyze">
                                            <i class="bi bi-arrow-repeat me-2"></i> Re-Analyze
                                        </button>
                                    </div>
                                </div>

                                <!-- Justification -->
                                <div class="mb-4">
                                    <h6 class="text-white fw-bold text-uppercase small mb-2"><i
                                            class="bi bi-card-text me-2"></i>Analysis Justification</h6>
                                    <p class="small text-white-50 mb-0" id="ai_justification">-</p>
                                </div>

                                <div class="row g-3 mb-4">
                                    <!-- Strengths -->
                                    <div class="col-md-6">
                                        <div class="p-3 rounded h-100 position-relative"
                                            style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2);">
                                            <h6 class="text-success fw-bold text-uppercase small mb-3">
                                                <i class="bi bi-hand-thumbs-up-fill me-2"></i> Pros & Strengths
                                            </h6>
                                            <ul class="list-unstyled mb-0 small text-white-50 d-flex flex-column gap-2"
                                                id="ai_strengths_list">
                                                <!-- Dynamic Content -->
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- Risks -->
                                    <div class="col-md-6">
                                        <div class="p-3 rounded h-100 position-relative"
                                            style="background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.2);">
                                            <h6 class="text-warning fw-bold text-uppercase small mb-3">
                                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Risks & Bottlenecks
                                            </h6>
                                            <ul class="list-unstyled mb-0 small text-white-50 d-flex flex-column gap-2"
                                                id="ai_risks_list">
                                                <!-- Dynamic Content -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Recommendation -->
                                <div class="p-3 rounded position-relative mb-4"
                                    style="background: rgba(139, 92, 246, 0.1); border: 1px solid rgba(139, 92, 246, 0.2);">
                                    <h6 class="text-primary fw-bold text-uppercase small mb-3">
                                        <i class="bi bi-lightbulb-fill me-2"></i> AI Recommendations
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <p class="small text-uppercase text-primary fw-bold mb-1">Timing</p>
                                            <p class="small text-white-50 mb-0" id="ai_rec_timing">-</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="small text-uppercase text-primary fw-bold mb-1">Creative</p>
                                            <p class="small text-white-50 mb-0" id="ai_rec_creative">-</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="small text-uppercase text-primary fw-bold mb-1">Tactical</p>
                                            <p class="small text-white-50 mb-0" id="ai_rec_tactical">-</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Optimization Example -->
                                <div class="p-3 rounded position-relative"
                                    style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2);">
                                    <h6 class="text-info fw-bold text-uppercase small mb-3">
                                        <i class="bi bi-graph-up-arrow me-2"></i> Optimization Example
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-6 border-end border-secondary border-opacity-25">
                                            <p class="small text-uppercase text-white-50 fw-bold mb-1">Before</p>
                                            <p class="small text-white-50 mb-2 fst-italic" id="ai_opt_before">-</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="small text-uppercase text-success fw-bold mb-1">After (Optimized)
                                            </p>
                                            <p class="small text-white mb-2 fw-medium" id="ai_opt_after">-</p>
                                        </div>
                                        <div class="col-12 border-top border-secondary border-opacity-25 pt-2">
                                            <p class="small mb-0"><span class="text-info fw-bold">Reason:</span> <span
                                                    class="text-white-50" id="ai_opt_reason">-</span></p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Activity Log -->
                    <div class="col-lg-4 border-start">
                        <div class="ps-3 pe-3 mb-4">
                            <h6 class="text-uppercase small fw-bold text-muted mb-4"><i
                                    class="bi bi-person-fill me-2"></i>Created By</h6>
                            <div class="d-flex align-items-center" id="view_plan_assigned">
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

                        <div class="timeline-sm ps-3 border-start border-2 ms-2 gap-3 d-flex flex-column">
                            <div class="position-relative ps-4">
                                <div class="position-absolute top-0 start-0 translate-middle-x bg-primary rounded-circle border border-white"
                                    style="width: 12px; height: 12px; margin-top: 6px; margin-left: -1px;"></div>
                                <p class="mb-1 small text-dark"><span class="fw-bold">AI Assistant</span> generated a
                                    new <a href="#" class="text-decoration-none">Analysis</a></p>
                                <span class="text-muted small" style="font-size: 11px;">Just now</span>
                            </div>
                            <div class="position-relative ps-4">
                                <div class="position-absolute top-0 start-0 translate-middle-x bg-info rounded-circle border border-white"
                                    style="width: 12px; height: 12px; margin-top: 6px; margin-left: -1px;"></div>
                                <p class="mb-1 small text-dark"><span class="fw-bold">Sarah J.</span> added a <a
                                        href="#" class="text-decoration-none">Progress Note</a></p>
                                <div class="p-2 bg-light border rounded mb-1 fst-italic text-secondary small">
                                    "Completed first 5 minutes of technical scripting. Awaiting feedback on security
                                    modules."
                                </div>
                                <span class="text-muted small" style="font-size: 11px;">15 mins ago</span>
                            </div>
                            <div class="position-relative ps-4 mb-4">
                                <div class="position-absolute top-0 start-0 translate-middle-x bg-secondary rounded-circle border border-white"
                                    style="width: 12px; height: 12px; margin-top: 6px; margin-left: -1px;"></div>
                                <p class="mb-1 small text-dark"><span class="fw-bold">Sarah J.</span> uploaded 2 <a
                                        href="#" class="text-decoration-none">attachments</a></p>
                                <span class="text-muted small" style="font-size: 11px;">1 hour ago</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-soft-blue border-top-0">
                <button type="button" class="btn btn-light rounded-3 px-4 me-auto"
                    data-bs-dismiss="modal">Close</button>

                <button type="button" class="btn btn-outline-danger rounded-3 px-4 d-none me-2" id="btnCancelApprove">
                    <i class="bi bi-x-circle me-2"></i>Cancel Approval
                </button>
                <button type="button" class="btn btn-warning rounded-3 px-4 text-white me-2"
                    id="btnDistributionRejectPlan">
                    <i class="bi bi-arrow-return-left me-2"></i>Revise / Reject
                </button>
                <button type="button" class="btn btn-success rounded-3 px-4 me-2" id="btnDistributionApprovePlan"
                    disabled>
                    <i class="bi bi-check-circle me-2"></i>Approve Plan
                </button>
            </div>
        </div>
    </div>
</div>