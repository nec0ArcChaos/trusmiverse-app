<div class="modal fade sub_modal" id="addContentPlanModal" tabindex="-1" aria-labelledby="addContentPlanModalLabel"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-1" id="addContentPlanModalLabel">Add Content Plan</h5>
                    <p class="text-muted small mb-0">Fill in the details for the content plan.</p>
                </div>
                <button type="button" class="ms-auto btn btn-warning rounded-2 text-white btn-sm"
                    id="btnSurpriseMeContent"><i class="bi bi-stars me-1"></i> Surprise Me</button>
                <button type="button" class="ms-2 btn-close shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Wizard Progress -->
                <div class="content-wizard-progress mb-4">
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 20%;" aria-valuenow="20"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <form id="formAddContentPlan" action="#" method="POST">
                    <input type="hidden" name="campaign_id" id="content_plan_campaign_id" value="">
                    <input type="hidden" name="content_id" id="content_plan_content_id" value="">

                    <!-- Step 1: Identity & Context -->
                    <div class="content-wizard-step" data-step="1">
                        <p class="fw-medium title" style="line-height: 1.5;">Identity & Context<br>
                            <small class="text-muted">Basic details about this content plan.</small>
                        </p>
                        <div class="row g-3">

                            <div class="col-12">
                                <div class="form-group position-relative check-valid mb-2">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <select class="form-select chosen-select border-start-0"
                                                id="content_plan_activation_id" name="activation_id"
                                                data-placeholder="Select Activation Strategy">
                                                <option value="">Select Activation Strategy</option>
                                            </select>
                                            <label for="content_plan_activation_id">Activation Strategy</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Selected Activation Info Card -->
                                <div id="content_activation_info" class="card bg-light border-0 d-none mt-2 rounded-4">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-info-circle-fill fs-5 text-primary me-2"></i>
                                            <h6 class="fw-bold mb-0 text-dark">Informasi Activation</h6>
                                        </div>
                                        <div class="row g-2 mt-1">
                                            <div class="col-sm-6">
                                                <small class="text-muted d-block"
                                                    style="font-size: 0.75rem;">Title</small>
                                                <span class="fw-medium text-dark"
                                                    id="info-content-activation-title">-</span>
                                            </div>
                                            <!-- <div class="col-sm-6">
                                                <small class="text-muted d-block"
                                                    style="font-size: 0.75rem;">Periode</small>
                                                <span class="fw-medium text-dark"
                                                    id="info-content-activation-period">-</span>
                                            </div>
                                            <div class="col-sm-6 mt-2">
                                                <small class="text-muted d-block"
                                                    style="font-size: 0.75rem;">Budget</small>
                                                <span class="fw-medium text-dark"
                                                    id="info-content-activation-budget">-</span>
                                            </div>
                                            <div class="col-sm-6 mt-2">
                                                <small class="text-muted d-block" style="font-size: 0.75rem;">Content
                                                    Type</small>
                                                <span class="fw-medium text-dark"
                                                    id="info-content-activation-content-type">-</span>
                                            </div>
                                            <div class="col-sm-6 mt-2">
                                                <small class="text-muted d-block"
                                                    style="font-size: 0.75rem;">Platform</small>
                                                <span class="fw-medium text-dark"
                                                    id="info-content-activation-platform">-</span>
                                            </div> -->
                                            <div class="col-6 mt-2">
                                                <small class="text-muted d-block"
                                                    style="font-size: 0.75rem;">Description</small>
                                                <span class="fw-medium text-dark"
                                                    id="info-content-activation-desc">-</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0"
                                                id="content_plan_title" name="title" placeholder="Content Title"
                                                required>
                                            <label for="content_plan_title">Title <sup
                                                    class="text-danger">*</sup></label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <select class="form-select chosen-select border-start-0"
                                                id="content_plan_format" name="format[]"
                                                data-placeholder="Select Format" multiple>
                                                <option value="">Select Format</option>
                                            </select>
                                            <label for="content_plan_format">Format</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Research Audience & Behavior -->
                    <div class="content-wizard-step" data-step="2" style="display: none;">
                        <p class="fw-medium title" style="line-height: 1.5;">Research Audience & Behavior<br>
                            <small class="text-muted">Research audience and their behavior.</small>
                        </p>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-group position-relative check-valid">
                                    <textarea class="form-control d-none" id="content_plan_pain_point" name="pain_point"
                                        rows="2"></textarea>
                                    <div class="overtype-section">
                                        <div class="overtype-header">
                                            <p class="fw-medium mb-0">Pain Point</p>
                                        </div>
                                        <div id="content_overtype_pain_point" style="height: 120px;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group position-relative check-valid">
                                    <textarea class="form-control d-none" id="content_plan_trigger_emotion"
                                        name="trigger_emotion" rows="2"></textarea>
                                    <div class="overtype-section">
                                        <div class="overtype-header">
                                            <p class="fw-medium mb-0">Trigger Emotion</p>
                                        </div>
                                        <div id="content_overtype_trigger_emotion" style="height: 120px;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group position-relative check-valid">
                                    <textarea class="form-control d-none" id="content_plan_consumption_behavior"
                                        name="consumption_behavior" rows="2"></textarea>
                                    <div class="overtype-section">
                                        <div class="overtype-header">
                                            <p class="fw-medium mb-0">Consumption Behavior</p>
                                        </div>
                                        <div id="content_overtype_consumption_behavior" style="height: 120px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Content Strategy -->
                    <div class="content-wizard-step" data-step="3" style="display: none;">
                        <p class="fw-medium title" style="line-height: 1.5;">Content Strategy<br>
                            <small class="text-muted">Strategy, hook, and target psychology.</small>
                        </p>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <select class="form-select chosen-select border-start-0"
                                                id="content_plan_content_pillar" name="content_pillar[]"
                                                data-placeholder="Select Content Pillar" multiple>
                                                <option value="">Select Content Pillar</option>
                                            </select>
                                            <label for="content_plan_content_pillar">Content Pillar</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0"
                                                id="content_plan_duration_desc" name="duration_desc"
                                                placeholder="e.g. 1 min, 30 sec">
                                            <label for="content_plan_duration_desc">Duration</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group position-relative check-valid">
                                    <textarea class="form-control d-none" id="content_plan_reference_link"
                                        name="reference_link" rows="2"></textarea>
                                    <div class="overtype-section">
                                        <div class="overtype-header">
                                            <p class="fw-medium mb-0">Reference Link</p>
                                        </div>
                                        <div id="content_overtype_reference_link" style="height: 120px;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group position-relative check-valid">
                                    <textarea class="form-control d-none" id="content_plan_hook" name="hook"
                                        rows="2"></textarea>
                                    <div class="overtype-section">
                                        <div class="overtype-header">
                                            <p class="fw-medium mb-0">Hook</p>
                                        </div>
                                        <div id="content_overtype_hook" style="height: 120px;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group position-relative check-valid">
                                    <div class="overtype-section">
                                        <div class="overtype-header">
                                            <p class="fw-medium mb-0">Script Content</p>
                                        </div>
                                        <div id="content_plan_script_content" style="height: 150px;"></div>
                                        <input type="hidden" name="script_content" id="content_plan_script_content_val">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group position-relative check-valid">
                                    <div class="overtype-section">
                                        <div class="overtype-header">
                                            <p class="fw-medium mb-0">Storyboard</p>
                                        </div>
                                        <div id="content_plan_storyboard" style="height: 150px;"></div>
                                        <input type="hidden" name="storyboard" id="content_plan_storyboard_val">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group position-relative check-valid">
                                    <textarea class="form-control d-none" id="content_plan_audio_notes"
                                        name="audio_notes" rows="2"></textarea>
                                    <div class="overtype-section">
                                        <div class="overtype-header">
                                            <p class="fw-medium mb-0">Audio Notes</p>
                                        </div>
                                        <div id="content_overtype_audio_notes" style="height: 120px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Talent & Details -->
                    <div class="content-wizard-step" data-step="4" style="display: none;">
                        <p class="fw-medium title" style="line-height: 1.5;">Talent & Details<br>
                            <small class="text-muted">Talent specifications and production details.</small>
                        </p>
                        <div class="row g-3">

                            <div class="col-6">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <select class="form-select chosen-select border-start-0"
                                                id="content_plan_talent_type" name="talent_type[]"
                                                data-placeholder="Select Talent Type" multiple>
                                                <option value="">Select Talent Type</option>
                                            </select>
                                            <label for="content_plan_talent_type">Talent Type</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span
                                            class="input-group-text bg-white border-end-0 fw-bold text-muted">Rp</span>
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0"
                                                id="content_plan_talent_cost" name="talent_cost"
                                                placeholder="Talent Budget" onkeyup="formatRupiah(this)">
                                            <label for="content_plan_talent_cost">Talent Budget</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="number" class="form-control border-start-0"
                                                id="content_plan_talent_target" name="talent_target"
                                                placeholder="Talent Target" min="0">
                                            <label for="content_plan_talent_target">Talent Target
                                                <i class="bi bi-info-circle ms-1 text-muted"
                                                    title="Number of talents to assign for this content"
                                                    data-bs-toggle="tooltip"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group position-relative check-valid">
                                    <textarea class="form-control d-none" id="content_plan_talent_persona"
                                        name="talent_persona" rows="2"></textarea>
                                    <div class="overtype-section">
                                        <div class="overtype-header">
                                            <p class="fw-medium mb-0">Talent Persona</p>
                                        </div>
                                        <div id="content_overtype_talent_persona" style="height: 150px;"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Step 5: Internal Production & Distribution -->
                    <div class="content-wizard-step" data-step="5" style="display: none;">
                        <p class="fw-medium title" style="line-height: 1.5;">Internal Production & Distribution<br>
                            <small class="text-muted">Internal production & distribution details.</small>
                        </p>
                        <div class="row g-3">

                            <div class="col-6">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0 tanggal"
                                                id="content_plan_publish_date" name="publish_date"
                                                placeholder="Publish Date">
                                            <label for="content_plan_publish_date">Publish Date</label>
                                        </div>
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0 tanggal"
                                                id="content_plan_deadline" name="deadline_publish"
                                                placeholder="Deadline Publish">
                                            <label for="content_plan_deadline">Deadline Publish</label>
                                        </div>
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-calendar-check"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <select class="form-select chosen-select border-start-0"
                                                id="content_plan_platform" name="platform[]"
                                                data-placeholder="Select Platform" multiple>
                                                <option value="">Select Platform</option>
                                            </select>
                                            <label for="content_plan_platform">Platform</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <select class="form-select chosen-select border-start-0"
                                                id="content_plan_placement" name="placement_type[]"
                                                data-placeholder="Select Placement" multiple>
                                                <option value="">Select Placement</option>
                                            </select>
                                            <label for="content_plan_placement">Placement Type</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer border-top-0 px-4 pb-4 pt-0 justify-content-between">
                <button type="button" class="btn btn-secondary content-btn-prev rounded-pill px-4"
                    disabled>Previous</button>
                <div>
                    <button type="button" class="btn btn-primary content-btn-next rounded-pill px-4">Next</button>
                    <button type="button" class="btn btn-success content-btn-finish rounded-pill px-4"
                        style="display: none;" id="btnSaveContentPlan">Create Plan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Strategy Detail Modal -->
<div class="modal fade sub_modal" id="strategyContentDetailModal" tabindex="-1"
    aria-labelledby="strategyContentDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 bg-soft-purple">
                <h5 class="modal-title fw-bold text-purple" id="strategyContentDetailModalLabel">Strategy Detail</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 bg-soft-purple">
                <div id="strategyContentDetailContent">
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
<div class="modal fade sub_modal" id="inviteContentTeamModal" tabindex="-1"
    aria-labelledby="inviteContentTeamModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 bg-white">
                <h5 class="modal-title fw-bold" id="inviteContentTeamModalLabel">Invite Content Team</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 bg-white">
                <form id="formInviteContentTeam">
                    <div class="mb-3">
                        <label for="invite_content_team_select"
                            class="form-label small text-uppercase fw-bold text-secondary">Select Team Members</label>
                        <select class="form-select chosen-select" id="invite_content_team_select" name="team[]" multiple
                            data-placeholder="Choose employees...">
                            <!-- Options will be populated by JS -->
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-white border-top-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" id="btnSaveContentTeam">Save
                    Changes</button>
            </div>
        </div>
    </div>
</div>


<!-- View Content Plan Modal -->
<div class="modal sub_modal fade" id="viewContentPlanModal" tabindex="-1" aria-labelledby="viewContentPlanModalLabel"
    aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 bg-soft-blue">
                <div class="d-flex align-items-center gap-3 w-100">
                    <h5 class="modal-title fw-bold" id="viewContentPlanModalLabel">Plan Detail</h5>
                    <span class="badge bg-light-green text-success px-3 rounded-3 py-2"
                        id="view_content_plan_priority">-</span>
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
                            <i class="bi bi-folder2-open me-2"></i> <span id="view_content_plan_category">Content
                                Content</span>
                            <span class="mx-2">•</span>
                            <span id="view_content_plan_id">#TASK-000</span>
                        </div>

                        <!-- Detail Event Activation -->
                        <div class="row ps-3 pe-3 mb-4">
                            <label class="text-uppercase small fw-bold text-muted mb-2">Activation Strategy</label>
                            <p class="text-secondary" id="view_content_plan_activation_desc">-</p>
                        </div>

                        <!-- Additional Details Grid -->
                        <div class="row ps-3 pe-3">
                            <div class="col-12">
                                <p class="title mb-4 text-uppercase fw-bold text-muted mb-2 mt-2 fs-14">
                                    General Information</p>
                            </div>

                            <div class="col-6 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Title</label>
                                <p class="text-secondary" id="view_content_plan_title">-</p>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Status</label>
                                <span class="badge bg-light text-dark" id="view_content_plan_status">-</span>
                            </div>

                            <div class="col-6 mb-3">
                                <label class="text-uppercase small fw-bold text-muted mb-2">Publish Date</label>
                                <div class="d-flex align-items-center text-dark fw-medium">
                                    <i class="bi bi-calendar4 me-2 text-primary"></i>
                                    <span id="view_content_plan_publish_date">-</span>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="text-uppercase small fw-bold text-muted mb-2">Deadline</label>
                                <div class="d-flex align-items-center text-dark fw-medium">
                                    <i class="bi bi-calendar-check me-2 text-danger"></i>
                                    <span id="view_content_plan_deadline">-</span>
                                </div>
                            </div>

                            <!-- Platform & Spec -->
                            <div class="col-12 mt-3">
                                <p class="title mb-3 text-uppercase fw-bold text-muted mb-2 fs-14">Platform &
                                    Specification</p>
                            </div>
                            <div class="col-4 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Platform</label>
                                <p class="text-secondary" id="view_content_plan_platform">-</p>
                            </div>
                            <div class="col-4 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Placement</label>
                                <p class="text-secondary" id="view_content_plan_placement">-</p>
                            </div>
                            <div class="col-4 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Format</label>
                                <p class="text-secondary" id="view_content_plan_format">-</p>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Content
                                    Pillar</label>
                                <p class="text-secondary" id="view_content_plan_content_pillar">-</p>
                            </div>

                            <!-- Talent & Details -->
                            <div class="col-12 mt-3">
                                <p class="title mb-3 text-uppercase fw-bold text-muted mb-2 fs-14">Talent & Details</p>
                            </div>
                            <div class="col-4 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Talent Type</label>
                                <p class="text-secondary" id="view_content_plan_talent_type">-</p>
                            </div>
                            <div class="col-4 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Talent Cost</label>
                                <p class="text-secondary" id="view_content_plan_talent_cost">-</p>
                            </div>
                            <div class="col-4 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Duration</label>
                                <p class="text-secondary" id="view_content_plan_duration">-</p>
                            </div>
                            <div class="col-4 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">
                                    Talent Target
                                    <span class="badge bg-info-soft text-info border-info ms-1"
                                        id="view_content_plan_talent_target_badge">-</span>
                                </label>
                                <p class="text-secondary fw-bold" id="view_content_plan_talent_target">-</p>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Talent
                                    Persona</label>
                                <div class="text-secondary bg-light p-3 rounded" id="view_content_plan_talent_persona">-
                                </div>
                            </div>

                            <!-- Content Strategy -->
                            <div class="col-12 mt-3">
                                <p class="title mb-3 text-uppercase fw-bold text-muted mb-2 fs-14">Content Strategy</p>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Pain Point</label>
                                <div class="text-secondary small" id="view_content_plan_pain_point">-</div>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Trigger
                                    Emotion</label>
                                <div class="text-secondary small" id="view_content_plan_trigger_emotion">-</div>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Consumption
                                    Behavior</label>
                                <div class="text-secondary small" id="view_content_plan_consumption_behavior">-</div>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Hook</label>
                                <div class="text-secondary small" id="view_content_plan_hook">-</div>
                            </div>

                            <!-- Creative Assets -->
                            <div class="col-12 mt-3">
                                <p class="title mb-3 text-uppercase fw-bold text-muted mb-2 fs-14">Creative Assets</p>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Script
                                    Content</label>
                                <div class="text-secondary bg-light p-3 rounded" id="view_content_plan_script_content">-
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Storyboard</label>
                                <div class="text-secondary bg-light p-3 rounded" id="view_content_plan_storyboard">-
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Audio Notes</label>
                                <div class="text-secondary bg-light p-3 rounded" id="view_content_plan_audio_notes">-
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="d-block small text-muted text-uppercase fw-bold mb-1">Reference
                                    Link</label>
                                <div class="text-secondary" id="view_content_plan_reference_link">-</div>
                            </div>

                        </div>

                        <!-- AI Analysis Section -->
                        <div class="card bg-dark text-white border-0 shadow-lg text-start mb-4 position-relative overflow-hidden rounded-4"
                            id="content_ai_analysis_card"
                            style="background: linear-gradient(145deg, #1a1f3c 0%, #111425 100%);">
                            <!-- Background Glow Effect -->
                            <div class="position-absolute top-0 start-0 w-100 h-100"
                                style="background: radial-gradient(circle at 10% 10%, rgba(139, 92, 246, 0.15) 0%, transparent 40%); pointer-events: none;">
                            </div>

                            <!-- Before Analysis State -->
                            <div id="content_ai_analysis_empty" class="card-body bg-none p-5 text-center">
                                <div class="mb-3">
                                    <i class="bi bi-stars text-warning display-4"></i>
                                </div>
                                <h5 class="fw-bold mb-2">AI Task Analysis</h5>
                                <p class="text-white-50 mb-4">Get instant insights, potential risks, and optimization
                                    recommendations for this content plan.</p>
                                <button class="btn btn-primary px-4 py-2 rounded-pill shadow-lg"
                                    id="btn_run_content_analysis">
                                    <i class="bi bi-cpu me-2"></i> Run AI Analysis
                                </button>
                            </div>

                            <!-- After Analysis State (Hidden by default) -->
                            <div id="content_ai_analysis_content" class="card-body bg-none p-4 d-none">
                                <!-- Header & Score -->
                                <div
                                    class="d-flex justify-content-between align-items-center mb-4 border-bottom border-white border-opacity-10 pb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-stars text-primary fs-4"></i>
                                        <h6 class="fw-bold mb-0 text-uppercase letter-spacing-1">AI Task Analysis</h6>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 bg-white bg-opacity-10 px-3 py-1 rounded-pill"
                                        data-bs-toggle="tooltip" data-bs-placement="left" title=""
                                        id="content_ai_score_container">
                                        <span class="h5 fw-bold mb-0" id="content_ai_score">0</span>
                                        <span class="small text-white-50 text-uppercase"
                                            style="font-size: 10px;">Score</span>
                                        <button class="btn btn-primary btn-sm rounded-pill shadow-lg ms-2"
                                            id="btn_reanalyze_content">
                                            <i class="bi bi-arrow-repeat me-1"></i> Re-Analyze
                                        </button>
                                    </div>
                                </div>

                                <!-- Executive Summary -->
                                <div class="alert bg-white bg-opacity-10 border-0 text-white-50 mb-4 p-3 rounded-3">
                                    <h6 class="text-white fw-bold text-uppercase small mb-2"><i
                                            class="bi bi-card-text me-2"></i> Executive Summary</h6>
                                    <ul class="mb-0 small ps-3" id="content_ai_executive_summary"></ul>
                                </div>

                                <!-- Detailed Analysis Tabs/Grid -->
                                <div class="row g-3 mb-4">
                                    <!-- Strategic & Funnel -->
                                    <div class="col-md-6">
                                        <div
                                            class="p-3 rounded h-100 bg-black bg-opacity-25 border border-white border-opacity-10">
                                            <h6 class="text-info fw-bold text-uppercase small mb-3">Strategy & Funnel
                                            </h6>
                                            <div id="content_ai_strategy_funnel_stats"></div>
                                        </div>
                                    </div>
                                    <!-- Hook & Script -->
                                    <div class="col-md-6">
                                        <div
                                            class="p-3 rounded h-100 bg-black bg-opacity-25 border border-white border-opacity-10">
                                            <h6 class="text-warning fw-bold text-uppercase small mb-3">Hook & Persuasion
                                            </h6>
                                            <div id="content_ai_hook_script_stats"></div>
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
                                                id="content_ai_swot_strengths"></ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 rounded h-100"
                                            style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2);">
                                            <h6 class="text-danger fw-bold text-uppercase small mb-2"><i
                                                    class="bi bi-bandaid-fill me-2"></i> Weaknesses</h6>
                                            <ul class="list-unstyled mb-0 small text-white-50 d-flex flex-column gap-2"
                                                id="content_ai_swot_weaknesses"></ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 rounded h-100"
                                            style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2);">
                                            <h6 class="text-primary fw-bold text-uppercase small mb-2"><i
                                                    class="bi bi-graph-up-arrow me-2"></i> Opportunities</h6>
                                            <ul class="list-unstyled mb-0 small text-white-50 d-flex flex-column gap-2"
                                                id="content_ai_swot_opportunities"></ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 rounded h-100"
                                            style="background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.2);">
                                            <h6 class="text-warning fw-bold text-uppercase small mb-2"><i
                                                    class="bi bi-shield-exclamation me-2"></i> Threats</h6>
                                            <ul class="list-unstyled mb-0 small text-white-50 d-flex flex-column gap-2"
                                                id="content_ai_swot_threats"></ul>
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
                                            <div id="content_ai_performance_stats" class="small text-white-50"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div
                                            class="p-3 rounded h-100 bg-black bg-opacity-25 border border-white border-opacity-10">
                                            <h6 class="text-warning fw-bold text-uppercase small mb-3">Cost Analysis
                                            </h6>
                                            <div id="content_ai_cost_stats" class="small text-white-50"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div
                                            class="p-3 rounded h-100 bg-black bg-opacity-25 border border-white border-opacity-10">
                                            <h6 class="text-danger fw-bold text-uppercase small mb-3">Risk Assessment
                                            </h6>
                                            <div id="content_ai_risk_stats" class="small text-white-50"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Strategic Recommendations -->
                                <div class="p-3 rounded position-relative"
                                    style="background: rgba(139, 92, 246, 0.1); border: 1px solid rgba(139, 92, 246, 0.2);">
                                    <h6 class="text-primary fw-bold text-uppercase small mb-3">
                                        <i class="bi bi-lightbulb-fill me-2"></i> Strategic Recommendations
                                    </h6>
                                    <div class="row g-3" id="content_ai_recommendations_grid">
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
                                    class="bi bi-person-fill me-2"></i>Created By</h6>
                            <div class="d-flex align-items-center" id="view_content_plan_assigned">
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

                <button type="button" class="btn btn-outline-danger rounded-3 px-4 d-none me-2"
                    id="btnCancelApproveContent">
                    <i class="bi bi-x-circle me-2"></i>Cancel Approval
                </button>
                <button type="button" class="btn btn-warning rounded-3 px-4 text-white me-2" id="btnRejectContentPlan">
                    <i class="bi bi-arrow-return-left me-2"></i>Revise / Reject
                </button>
                <button type="button" class="btn btn-success rounded-3 px-4 me-2" id="btnApproveContentPlan" disabled>
                    <i class="bi bi-check-circle me-2"></i>Approve Plan
                </button>
            </div>
        </div>
    </div>
</div>