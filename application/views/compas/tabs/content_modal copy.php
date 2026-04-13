<!-- Content Form Modal -->
<div class="modal sub_modal fade" id="modal-content-form" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-1" id="content-modal-title">Add Content Plan</h5>
                    <p class="text-muted small mb-0">Outline your content strategy and production details.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Wizard Progress -->
                <div class="wizard-progress mb-4">
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <form class="g-3" id="content-form">
                    <input type="hidden" name="content_id" id="form-content-id">
                    <input type="hidden" name="campaign_id" id="form-content-campaign-id">

                    <!-- Step 1: Identity & Platform -->
                    <div class="wizard-step" data-step="1">
                        <p class="fw-medium title" style="line-height: 1.5;">Identity & Platform<br>
                            <small class="text-muted">Basic content information and platform selection.</small>
                        </p>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0"
                                                id="form-content-campaign-name" readonly
                                                style="background-color: #e9ecef;">
                                            <label>Campaign</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0" id="form-title"
                                                name="title" placeholder="Title" required>
                                            <label for="form-title">Content Title <sup
                                                    class="text-danger">*</sup></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 mb-3">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <select class="form-select border-start-0" id="form-format" name="format"
                                                required>
                                                <option value="" selected disabled>Select Format</option>
                                                <option value="Reels">Reels</option>
                                                <option value="TikTok">TikTok</option>
                                                <option value="Post">Post (Image/Carousel)</option>
                                                <option value="Story">Story</option>
                                                <option value="Long Video">Long Video</option>
                                            </select>
                                            <label for="form-format">Format <sup class="text-danger">*</sup></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 mb-3">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <!-- Assuming platform ID or Name. Using text for flexibility or select if fetched -->
                                            <select class="form-select border-start-0" id="form-platform"
                                                name="platform" required>
                                                <option value="" selected disabled>Select Platform</option>
                                                <option value="Instagram">Instagram</option>
                                                <option value="TikTok">TikTok</option>
                                                <option value="YouTube">YouTube</option>
                                                <option value="Facebook">Facebook</option>
                                            </select>
                                            <label for="form-platform">Platform <sup class="text-danger">*</sup></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 mb-3">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="date" class="form-control border-start-0"
                                                id="form-publish-date" name="publish_date" placeholder="Publish Date">
                                            <label for="form-publish-date">Publish Date</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 mb-3">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0"
                                                id="form-content-pillar" name="content_pillar"
                                                placeholder="Content Pillar">
                                            <label for="form-content-pillar">Content Pillar</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Strategy & Script -->
                    <div class="wizard-step" data-step="2" style="display: none;">
                        <p class="fw-medium title" style="line-height: 1.5;">Strategy & Script<br>
                            <small class="text-muted">Define the hook, script, and strategic elements.</small>
                        </p>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0" id="form-hook"
                                                name="hook" placeholder="Hook">
                                            <label for="form-hook">Hook / Angle</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold small text-muted text-uppercase mb-1">Script
                                    Content</label>
                                <div class="form-group position-relative check-valid">
                                    <textarea name="script_content" id="form-script-content" class="d-none"></textarea>
                                    <div class="overtype-section">
                                        <div class="overtype-header">
                                            <p class="fw-medium mb-0">Script Draft</p>
                                        </div>
                                        <div id="overtype-script" style="height: 200px;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="fw-bold small text-muted text-uppercase mb-1">Pain Point & Emotion</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="pain_point" id="form-pain-point"
                                            placeholder="Pain Point">
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="trigger_emotion"
                                            id="form-trigger-emotion" placeholder="Trigger Emotion">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <input type="text" class="form-control" name="consumption_behavior"
                                    id="form-consumption-behavior" placeholder="Consumption Behavior">
                            </div>
                            <div class="col-12 mb-3">
                                <input type="text" class="form-control" name="reference_link" id="form-reference-link"
                                    placeholder="Reference Link (URL)">
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Production Details -->
                    <div class="wizard-step" data-step="3" style="display: none;">
                        <p class="fw-medium title" style="line-height: 1.5;">Production Details<br>
                            <small class="text-muted">Storyboard, audio, and technical details.</small>
                        </p>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label
                                    class="form-label fw-bold small text-muted text-uppercase mb-1">Storyboard</label>
                                <div class="form-group position-relative check-valid">
                                    <textarea name="storyboard" id="form-storyboard" class="d-none"></textarea>
                                    <div class="overtype-section">
                                        <div class="overtype-header">
                                            <p class="fw-medium mb-0">Visual Flow</p>
                                        </div>
                                        <div id="overtype-storyboard" style="height: 150px;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Audio Notes" id="form-audio-notes"
                                        name="audio_notes" style="height: 100px"></textarea>
                                    <label for="form-audio-notes">Audio Notes / BGM</label>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="form-duration-desc" name="duration_desc"
                                        placeholder="Duration">
                                    <label for="form-duration-desc">Duration Description (e.g. 15s)</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Talent & Deadline -->
                    <div class="wizard-step" data-step="4" style="display: none;">
                        <p class="fw-medium title" style="line-height: 1.5;">Talent & Deadline<br>
                            <small class="text-muted">Resource allocation and production timeline.</small>
                        </p>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="form-talent-type" name="talent_type"
                                        placeholder="Talent Type">
                                    <label for="form-talent-type">Talent Type</label>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="form-talent-persona"
                                        name="talent_persona" placeholder="Talent Persona">
                                    <label for="form-talent-persona">Talent Persona</label>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="form-talent-cost" name="talent_cost"
                                        placeholder="Talent Cost">
                                    <label for="form-talent-cost">Talent Cost (Est.)</label>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="form-placement-type"
                                        name="placement_type" placeholder="Placement Type">
                                    <label for="form-placement-type">Placement Type</label>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="form-deadline-publish"
                                        name="deadline_publish">
                                    <label for="form-deadline-publish">Publish Deadline</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 px-4 pb-4 pt-0 justify-content-between">
                <button type="button" class="btn btn-secondary btn-prev rounded-pill px-4" disabled>Previous</button>
                <div>
                    <button type="button" class="btn btn-primary btn-next rounded-pill px-4">Next</button>
                    <button type="button" class="btn btn-success btn-finish rounded-pill px-4" style="display: none;"
                        onclick="submitContentForm()">Save Plan</button>
                </div>
            </div>
        </div>
    </div>
</div>