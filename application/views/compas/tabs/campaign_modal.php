<div class="modal fade sub_modal" id="modalScoreDetail" tabindex="-1" aria-labelledby="modalScoreDetailLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalScoreDetailLabel">Viability Score Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <h1 class="display-4 fw-bold text-primary mb-0" id="modal_overall_score">0</h1>
                    <p class="text-muted">Overall Viability Score</p>
                </div>
                <div class="card mt-2 mb-2 rounded-3 p-3">
                    <div class="card-body">
                        <h6 class="fw-bold text-uppercase mb-2">Conclusion</h6>
                        <p id="modal_conclusion" class="small mb-0">-</p>
                    </div>
                </div>
                <div class="row g-3" id="modal_score_breakdown">
                    <!-- Breakdown items will be injected here -->
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Campaign -->
<div class="modal sub_modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="editCampaignModal"
    aria-labelledby="editCampaignModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCampaignModalLabel">Edit Campaign</h5>
                <button type="button" class="btn btn-outline-primary btn-sm ms-auto me-2" id="btnCampaignSurpriseMe">
                    <i class="bi bi-magic"></i> Surprise Me
                </button>
                <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <!-- Wizard Progress -->
                    <div class="wizard-progress mb-4">
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <form id="editCampaignForm">
                        <!-- Step 1: Strategy & Concept -->
                        <div class="wizard-step" data-step="1">
                            <p class="fw-medium title" style="line-height: 1.5;">Strategy &amp; Concept<br>
                                <small class="text-muted">Tentukan Strategi dan Konsep Anda untuk kampanye
                                    ini.</small>
                            </p>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="form-group position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <div class="form-floating">
                                                <input type="text" placeholder="Campaign Name" value="" required=""
                                                    name="campaign_name" id="campaign_name"
                                                    class="form-control border-start-0">
                                                <label>Tema Campaign <sup class="text-danger">*</sup></label>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="small text-muted ms-3">e.g. Summer Launch 2024</span>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-group position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <div class="form-floating">
                                                <select data-placeholder="Pilih Brand..."
                                                    class="chosen-select form-select" style="width: 100%;" id="brand_id"
                                                    name="brand_id" required="">
                                                    <option value="">-- Pilih Brand --</option>
                                                </select>
                                                <label>Brand <sup class="text-danger">*</sup></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-group position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <div class="form-floating">
                                                <input type="text" placeholder="Start Date" value="" required=""
                                                    name="start_date" id="start_date"
                                                    class="form-control border-start-0 tanggal">
                                                <label>Start Date <sup class="text-danger">*</sup></label>
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
                                                <input type="text" placeholder="End Date" value="" required=""
                                                    name="end_date" id="end_date"
                                                    class="form-control border-start-0 tanggal">
                                                <label>End Date <sup class="text-danger">*</sup></label>
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
                                                <select data-placeholder="Pilih Pilar Konten..." multiple
                                                    class="chosen-select form-select" style="width: 100%;" id="cp_id"
                                                    name="cp_id[]" required="">
                                                </select>
                                                <label>Pilar Konten <sup class="text-danger">*</sup></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-group position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <div class="form-floating">
                                                <select data-placeholder="Pilih Objective..." multiple
                                                    class="chosen-select form-select" style="width: 100%;"
                                                    id="objective_id" name="objective_id[]" required="">
                                                </select>
                                                </select>
                                                <label>Objective <sup class="text-danger">*</sup></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-3 mb-3">
                                    <div class="form-group position-relative check-valid">
                                        <textarea placeholder="..." value="" required="" name="campaign_desc"
                                            id="campaign_desc_val" class="form-control d-none rounded-4"
                                            style="height: 200px;"></textarea>
                                        <div class="overtype-section">
                                            <div class="overtype-header">
                                                <p class="fw-medium mb-0">Description <sup class="text-danger">*</sup>
                                                </p>
                                            </div>
                                            <div id="campaign_desc" style="height: 200px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-3 mb-3">
                                    <div class="form-group position-relative check-valid">
                                        <textarea placeholder="..." value="" required="" name="angle" id="angle_val"
                                            class="form-control d-none rounded-4"></textarea>
                                        <div class="overtype-section">
                                            <div class="overtype-header">
                                                <p class="fw-medium mb-0">Angle <sup class="text-danger">*</sup></p>
                                            </div>
                                            <div id="angle" style="height: 200px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Message & Audience -->
                        <div class="wizard-step" data-step="2" style="display: none;">
                            <p class="fw-medium title" style="line-height: 1.5;">Message & Audience<br>
                                <small class="text-muted">Tentukan target audiens Anda dan proposisi nilai inti dari
                                    kampanye ini.</small>
                            </p>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <textarea placeholder="Target Audiens" value="" required="" name="target_audiens"
                                        id="target_audiens_val" class="form-control d-none rounded-4"></textarea>
                                    <div class="overtype-section">
                                        <div class="overtype-header">
                                            <p class="fw-medium mb-0">Target Audiens <sup class="text-danger">*</sup>
                                            </p>
                                        </div>
                                        <div id="target_audiens" style="height: 200px;"></div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <textarea placeholder="Problem" value="" required="" name="problem" id="problem_val"
                                        class="form-control d-none rounded-4"></textarea>
                                    <div class="overtype-section">
                                        <div class="overtype-header">
                                            <p class="fw-medium mb-0">Problem <sup class="text-danger">*</sup></p>
                                        </div>
                                        <div id="problem" style="height: 200px;"></div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <textarea placeholder="Key Message" value="" required="" name="key_message"
                                        id="key_message_val" class="form-control d-none rounded-4"></textarea>
                                    <div class="overtype-section">
                                        <div class="overtype-header">
                                            <p class="fw-medium mb-0">Key Message <sup class="text-danger">*</sup>
                                            </p>
                                        </div>
                                        <div id="key_message" style="height: 200px;"></div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <textarea placeholder="Reason to Believe" value="" required=""
                                        name="reason_to_believe" id="reason_to_believe_val"
                                        class="form-control d-none rounded-4"></textarea>
                                    <div class="overtype-section">
                                        <div class="overtype-header">
                                            <p class="fw-medium mb-0">Reason to Believe <sup class="text-danger">*</sup>
                                            </p>
                                        </div>
                                        <div id="reason_to_believe" style="height: 200px;"></div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <textarea placeholder="CTA (Call to Action)" value="" required="" name="cta"
                                        id="cta_val" class="form-control d-none rounded-4"></textarea>
                                    <div class="overtype-section">
                                        <div class="overtype-header">
                                            <p class="fw-medium mb-0">CTA (Call to Action) <sup
                                                    class="text-danger">*</sup></p>
                                        </div>
                                        <div id="cta" style="height: 200px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Creative & Direction -->
                        <div class="wizard-step" data-step="3" style="display: none;">
                            <p class="fw-medium title" style="line-height: 1.5;">Creative &amp; Direction<br>
                                <small class="text-muted">Arahan Kreatif dan Visual untuk kampanye ini.</small>
                            </p>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="form-group position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <div class="form-floating">
                                                <select data-placeholder="Pilih Content Type..." multiple
                                                    class="chosen-select form-select" style="width: 100%;" id="cg_id"
                                                    name="cg_id[]" required="">
                                                </select>
                                                <label>Content Result *</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-group position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <div class="form-floating">
                                                <select data-placeholder="Pilih Content Type..." multiple
                                                    class="chosen-select form-select" style="width: 100%;" id="cf_id"
                                                    name="cf_id[]" required="">
                                                </select>
                                                <label>Content Format <sup class="text-danger">*</sup></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-group position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <div class="form-floating">
                                                <input type="text" placeholder="Jumlah Konten Internal" value=""
                                                    required="" name="jumlah_konten_internal"
                                                    id="jumlah_konten_internal" class="form-control border-start-0">
                                                <label>Jumlah Konten Internal <sup class="text-danger">*</sup></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-group position-relative check-valid">
                                        <textarea placeholder="Link Referensi Internal" value="" required=""
                                            name="link_referensi_internal" id="link_referensi_internal_val"
                                            class="form-control d-none rounded-4"></textarea>
                                        <div class="overtype-section">
                                            <div class="overtype-header">
                                                <p class="fw-medium mb-0">Link Referensi Internal <sup
                                                        class="text-danger">*</sup></p>
                                            </div>
                                            <div id="link_referensi_internal" style="height: 200px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-group position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <div class="form-floating">
                                                <input type="text" placeholder="Jumlah Konten Eksternal" value=""
                                                    required="" name="jumlah_konten_eksternal"
                                                    id="jumlah_konten_eksternal" class="form-control border-start-0">
                                                <label>Jumlah Konten Eksternal <sup class="text-danger">*</sup></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-group position-relative check-valid">
                                        <textarea placeholder="Link Referensi Eksternal" value="" required=""
                                            name="link_referensi_eksternal" id="link_referensi_eksternal_val"
                                            class="form-control d-none rounded-4"></textarea>
                                        <div class="overtype-section">
                                            <div class="overtype-header">
                                                <p class="fw-medium mb-0">Link Referensi Eksternal <sup
                                                        class="text-danger">*</sup></p>
                                            </div>
                                            <div id="link_referensi_eksternal" style="height: 200px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: KPI & Budget -->
                        <div class="wizard-step" data-step="4" style="display: none;">
                            <p class="fw-medium title" style="line-height: 1.5;">KPI &amp; Budget<br>
                                <small class="text-muted">KPI dan Budget untuk kampanye ini.</small>
                            </p>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="form-group position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <div class="form-floating">
                                                <input type="text" placeholder="Views" value="" required="" name="views"
                                                    id="views" class="form-control border-start-0">
                                                <label>Views <sup class="text-danger">*</sup></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-group position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <div class="form-floating">
                                                <input type="text" placeholder="Leads" value="" required="" name="leads"
                                                    id="leads" class="form-control border-start-0">
                                                <label>Leads <sup class="text-danger">*</sup></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-group position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <div class="form-floating">
                                                <input type="text" placeholder="Transaksi" value="" required=""
                                                    name="transaction" id="transaction"
                                                    class="form-control border-start-0">
                                                <label>Transaksi <sup class="text-danger">*</sup></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-group position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <div class="form-floating">
                                                <input type="text" placeholder="Cost Production" value="" required=""
                                                    name="cost_production" id="cost_production"
                                                    class="form-control border-start-0">
                                                <label>Cost Production <sup class="text-danger">*</sup></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-group position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <div class="form-floating">
                                                <input type="text" placeholder="Cost Placement" value="" required=""
                                                    name="cost_placement" id="cost_placement"
                                                    class="form-control border-start-0">
                                                <label>Cost Placement <sup class="text-danger">*</sup></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 5: Assign Team -->
                        <div class="wizard-step" data-step="5" style="display: none;">
                            <p class="fw-medium title" style="line-height: 1.5;">Assign Team<br>
                                <small class="text-muted">Assign team untuk kampanye ini.</small>
                            </p>
                            <div class="row">
                                <!-- Team Fields -->
                                <div class="col-6 mb-3">
                                    <div class="form-group position-relative">
                                        <div class="input-group input-group-lg">
                                            <div class="form-floating">
                                                <select data-placeholder="Pilih Activation Team..." multiple
                                                    class="chosen-select form-select" style="width: 100%;"
                                                    id="activation_team" name="activation_team[]">
                                                </select>
                                                <label>Assign Activation Team</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-group position-relative">
                                        <div class="input-group input-group-lg">
                                            <div class="form-floating">
                                                <input type="number" min="1" value="1" placeholder="Target Event"
                                                    required="" name="activation_target" id="activation_target"
                                                    class="form-control border-start-0">
                                                <label>Min Task Event</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-group position-relative">
                                        <div class="input-group input-group-lg">
                                            <div class="form-floating">
                                                <select data-placeholder="Pilih Team Content..." multiple
                                                    class="chosen-select form-select" style="width: 100%;"
                                                    id="content_team" name="content_team[]">
                                                </select>
                                                <label>Assign Team Content</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-group position-relative">
                                        <div class="input-group input-group-lg">
                                            <div class="form-floating">
                                                <input type="number" min="1" value="1" placeholder="Target Content"
                                                    required="" name="content_target" id="content_target"
                                                    class="form-control border-start-0">
                                                <label>Min Task Content</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <div class="form-group position-relative">
                                        <div class="input-group input-group-lg">
                                            <div class="form-floating">
                                                <select data-placeholder="Pilih Team Talent Acquisition..." multiple
                                                    class="chosen-select form-select" style="width: 100%;"
                                                    id="talent_team" name="talent_team[]">
                                                </select>
                                                <label>Assign Team Talent Acquisition </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 mb-3">
                                    <div class="form-group position-relative">
                                        <div class="input-group input-group-lg">
                                            <div class="form-floating">
                                                <select data-placeholder="Pilih Team Distribusi..." multiple
                                                    class="chosen-select form-select" style="width: 100%;"
                                                    id="distribution_team" name="distribution_team[]">
                                                </select>
                                                <label>Assign Team Distribution</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-group position-relative">
                                        <div class="input-group input-group-lg">
                                            <div class="form-floating">
                                                <input type="number" min="1" value="1" placeholder="Target Distribusi"
                                                    required="" name="distribution_target" id="distribution_target"
                                                    class="form-control border-start-0">
                                                <label>Min Task Distribusi</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-group position-relative">
                                        <div class="input-group input-group-lg">
                                            <div class="form-floating">
                                                <select data-placeholder="Pilih Team Optimasi..." multiple
                                                    class="chosen-select form-select" style="width: 100%;"
                                                    id="optimization_team" name="optimization_team[]">
                                                </select>
                                                <label>Assign Team Optimization</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-group position-relative">
                                        <div class="input-group input-group-lg">
                                            <div class="form-floating">
                                                <input type="number" min="1" value="1" placeholder="Target Optimization"
                                                    required="" name="optimization_target" id="optimization_target"
                                                    class="form-control border-start-0">
                                                <label>Min Task Optimization</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Wizard Controls -->
                        <div class="wizard-controls d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary btn-prev" disabled>Previous</button>
                            <div>
                                <button type="button" class="btn btn-primary btn-next">Next</button>
                                <button type="submit" class="btn btn-success btn-finish"
                                    style="display: none;">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Approve Campaign -->
<div class="modal sub_modal fade" id="approveCampaignModal" tabindex="-1" aria-labelledby="approveCampaignModalLabel"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveCampaignModalLabel">Approve Campaign</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="approveCampaignForm">
                    <input type="hidden" id="approve_campaign_id" name="campaign_id">

                    <div class="alert alert-info mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        Please assign the Teams (PIC) before approving this campaign.
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="col-6">
                            <label>Assign
                                Activation Team (PIC) <sup class="text-danger">*</sup></label>
                            <div class="form-group position-relative check-valid mb-3">
                                <div class="input-group input-group-lg">
                                    <div class="form-floating">
                                        <select data-placeholder="Pilih Activation Team..."
                                            class="chosen-select form-select" style="width: 100%;"
                                            id="approve_activation_team" name="activation_team[]" required="" multiple>
                                            <option value="">-- Pilih Activation Team --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 mb-3">
                            <label for="approve_activation_target" class="form-label fw-medium">Min Task
                                Event</label>
                            <input type="number" min="1" value="1" class="form-control" id="approve_activation_target"
                                name="activation_target" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="col-6">
                            <label>Assign
                                Content Team (PIC) <sup class="text-danger">*</sup></label>
                            <div class="form-group position-relative check-valid mb-3">
                                <div class="input-group input-group-lg">
                                    <div class="form-floating">
                                        <select data-placeholder="Pilih Content Team..."
                                            class="chosen-select form-select" style="width: 100%;"
                                            id="approve_content_team" name="content_team[]" required="" multiple>
                                            <option value="">-- Pilih Content Team --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 mb-3">
                            <label for="approve_content_target" class="form-label fw-medium">Min Task
                                Content</label>
                            <input type="number" min="1" value="1" class="form-control" id="approve_content_target"
                                name="content_target" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="col-6">
                            <label>Assign
                                Talent Team (PIC) <sup class="text-danger">*</sup></label>
                            <div class="form-group position-relative check-valid mb-3">
                                <div class="input-group input-group-lg">
                                    <div class="form-floating">
                                        <select data-placeholder="Pilih Talent Team..."
                                            class="chosen-select form-select" style="width: 100%;"
                                            id="approve_talent_team" name="talent_team[]" required="" multiple>
                                            <option value="">-- Pilih Talent Team --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 mb-3">
                            <label for="approve_talent_target" class="form-label fw-medium">Min Task
                                Talent</label>
                            <input type="number" min="1" value="1" class="form-control" id="approve_talent_target"
                                name="talent_target" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="col-6">
                            <label>Assign
                                Distribution Team (PIC) <sup class="text-danger">*</sup></label>
                            <div class="form-group position-relative check-valid mb-3">
                                <div class="input-group input-group-lg">
                                    <div class="form-floating">
                                        <select data-placeholder="Pilih Distribution Team..."
                                            class="chosen-select form-select" style="width: 100%;"
                                            id="approve_distribution_team" name="distribution_team[]" required=""
                                            multiple>
                                            <option value="">-- Pilih Distribution Team --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 mb-3">
                            <label for="approve_distribution_target" class="form-label fw-medium">Min Task
                                Distribution</label>
                            <input type="number" min="1" value="1" class="form-control" id="approve_distribution_target"
                                name="distribution_target" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="col-6">
                            <label>Assign
                                Optimization Team (PIC) <sup class="text-danger">*</sup></label>
                            <div class="form-group position-relative check-valid mb-3">
                                <div class="input-group input-group-lg">
                                    <div class="form-floating">
                                        <select data-placeholder="Pilih Optimization Team..."
                                            class="chosen-select form-select" style="width: 100%;"
                                            id="approve_optimization_team" name="optimization_team[]" required=""
                                            multiple>
                                            <option value="">-- Pilih Optimization Team --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 mb-3">
                            <label for="approve_optimization_target" class="form-label fw-medium">Min Task
                                Optimization</label>
                            <input type="number" min="1" value="1" class="form-control" id="approve_optimization_target"
                                name="optimization_target" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i>Approve Campaign
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>