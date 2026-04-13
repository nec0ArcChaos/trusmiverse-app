<!-- Create Campaign Modal -->
<div class="modal sub_modal fade" id="create-campaign-modal" tabindex="-1" aria-labelledby="createCampaignModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold" id="createCampaignModalLabel">Create New Campaign</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Form Content -->
            <div class="modal-body p-4">
                <form class="g-3">
                    <!-- Section 1: Basic Info -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3 text-primary">
                            <i class="bi bi-info-circle fs-5"></i>
                            <h6 class="fw-bold text-uppercase mb-0" style="letter-spacing: 0.05em;">Basic Info</h6>
                        </div>
                        <div class="row g-3">
                            <!-- Tema -->
                            <div class="col-md-6">
                                <label class="form-label small fw-medium text-secondary">Tema Campaign</label>
                                <input type="text" class="form-control bg-light border-0"
                                    placeholder="e.g. Summer Vibes 2024">
                            </div>
                            <!-- Brand -->
                            <div class="col-md-6">
                                <label class="form-label small fw-medium text-secondary">Brand</label>
                                <input type="text" class="form-control bg-light border-0" placeholder="Brand Name">
                            </div>
                            <!-- Periode -->
                            <div class="col-12">
                                <label class="form-label small fw-medium text-secondary">Periode Campaign</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0 text-secondary"><i
                                                    class="bi bi-calendar fs-6"></i></span>
                                            <input type="date" class="form-control bg-light border-0 ps-2">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0 text-secondary"><i
                                                    class="bi bi-calendar-event fs-6"></i></span>
                                            <input type="date" class="form-control bg-light border-0 ps-2">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Strategy -->
                    <div class="mb-4 pt-3 border-top">
                        <div class="d-flex align-items-center gap-2 mb-3 text-primary">
                            <i class="bi bi-lightbulb fs-5"></i>
                            <h6 class="fw-bold text-uppercase mb-0" style="letter-spacing: 0.05em;">Strategy & Content
                            </h6>
                        </div>
                        <div class="row g-3">
                            <!-- Pilar Konten -->
                            <div class="col-md-6">
                                <label class="form-label small fw-medium text-secondary">Pilar Konten</label>
                                <input type="text" class="form-control bg-light border-0">
                            </div>
                            <!-- Angle -->
                            <div class="col-md-6">
                                <label class="form-label small fw-medium text-secondary">Angle</label>
                                <input type="text" class="form-control bg-light border-0">
                            </div>
                            <!-- Tujuan Utama -->
                            <div class="col-12">
                                <label class="form-label small fw-medium text-secondary">Tujuan Utama Konten</label>
                                <textarea class="form-control bg-light border-0" rows="2"></textarea>
                            </div>
                            <!-- Target Audiens -->
                            <div class="col-12">
                                <label class="form-label small fw-medium text-secondary">Target Audiens</label>
                                <input type="text" class="form-control bg-light border-0">
                            </div>
                            <!-- Problem & Key Message -->
                            <div class="col-md-6">
                                <label class="form-label small fw-medium text-secondary">Problem</label>
                                <textarea class="form-control bg-light border-0" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-medium text-secondary">Key Message</label>
                                <textarea class="form-control bg-light border-0" rows="3"></textarea>
                            </div>
                            <!-- Reason to Believe & CTA -->
                            <div class="col-md-6">
                                <label class="form-label small fw-medium text-secondary">Reason to Believe</label>
                                <textarea class="form-control bg-light border-0" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-medium text-secondary">CTA</label>
                                <textarea class="form-control bg-light border-0" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Production Output -->
                    <div class="mb-4 pt-3 border-top">
                        <div class="d-flex align-items-center gap-2 mb-3 text-primary">
                            <i class="bi bi-film fs-5"></i>
                            <h6 class="fw-bold text-uppercase mb-0" style="letter-spacing: 0.05em;">Production Output
                            </h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small fw-medium text-secondary">Konten yang dihasilkan</label>
                                <input type="text" class="form-control bg-light border-0">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-medium text-secondary">Format</label>
                                <select class="form-select bg-light border-0">
                                    <option>Video (Reels/TikTok/Shorts)</option>
                                    <option>Static Post (Feed)</option>
                                    <option>Carousel/Slider</option>
                                    <option>Story/Status</option>
                                    <option>Article/Blog</option>
                                </select>
                            </div>
                            <div class="col-md-6"></div> <!-- Spacer -->

                            <!-- Internal Source -->
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded border border-dashed text-center">
                                    <h6 class="text-xs fw-bold text-secondary text-uppercase mb-3"
                                        style="font-size: 0.75rem;">Internal Sources</h6>
                                    <div class="mb-3 text-start">
                                        <label class="form-label text-muted small mb-1"
                                            style="font-size: 0.75rem;">Jumlah Konten</label>
                                        <input type="number" class="form-control form-control-sm bg-white border">
                                    </div>
                                    <div class="text-start">
                                        <label class="form-label text-muted small mb-1"
                                            style="font-size: 0.75rem;">Referensi</label>
                                        <input type="url" class="form-control form-control-sm bg-white border"
                                            placeholder="https://">
                                    </div>
                                </div>
                            </div>

                            <!-- External Source -->
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded border border-dashed text-center">
                                    <h6 class="text-xs fw-bold text-secondary text-uppercase mb-3"
                                        style="font-size: 0.75rem;">External Sources</h6>
                                    <div class="mb-3 text-start">
                                        <label class="form-label text-muted small mb-1"
                                            style="font-size: 0.75rem;">Jumlah Konten</label>
                                        <input type="number" class="form-control form-control-sm bg-white border">
                                    </div>
                                    <div class="text-start">
                                        <label class="form-label text-muted small mb-1"
                                            style="font-size: 0.75rem;">Referensi</label>
                                        <input type="url" class="form-control form-control-sm bg-white border"
                                            placeholder="https://">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Targets & Financials -->
                    <div class="pt-3 border-top">
                        <div class="d-flex align-items-center gap-2 mb-3 text-primary">
                            <i class="bi bi-cursor fs-5"></i>
                            <h6 class="fw-bold text-uppercase mb-0" style="letter-spacing: 0.05em;">Targets & Financials
                            </h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-medium text-secondary">Target Views</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-secondary"><i
                                            class="bi bi-eye fs-6"></i></span>
                                    <input type="number" class="form-control bg-light border-0 ps-2">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-medium text-secondary">Target Leads</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-secondary"><i
                                            class="bi bi-person-plus fs-6"></i></span>
                                    <input type="number" class="form-control bg-light border-0 ps-2">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-medium text-secondary">Target Transaksi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-secondary"><i
                                            class="bi bi-cart fs-6"></i></span>
                                    <input type="number" class="form-control bg-light border-0 ps-2">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-medium text-secondary">Cost Produksi Konten</label>
                                <div class="input-group">
                                    <span
                                        class="input-group-text bg-light border-0 text-secondary fw-semibold">Rp</span>
                                    <input type="text" class="form-control bg-light border-0 ps-2" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-medium text-secondary">Cost Placement</label>
                                <div class="input-group">
                                    <span
                                        class="input-group-text bg-light border-0 text-secondary fw-semibold">Rp</span>
                                    <input type="text" class="form-control bg-light border-0 ps-2" placeholder="0">
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer bg-light border-top-0 rounded-bottom-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-sm shadow-sm px-4">Create Campaign</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sub Detail (Script Drafting) -->
<div class="modal sub_modal fade" id="modal-sub-detail" tabindex="-1" aria-labelledby="sub-detail-title"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header border-bottom">
                <div class="d-flex flex-column gap-2 w-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <input type="hidden" name="target" id="sub-detail-target">
                            <h5 class="modal-title fw-bold text-dark mb-0" id="sub-detail-title">Script Drafting -
                                Series B</h5>
                            <span
                                class="badge bg-danger-subtle text-danger d-flex align-items-center gap-1 text-uppercase fw-bold"
                                style="font-size: 0.65rem; padding: 0.35em 0.65em;">
                                <span class="bi bi-exclamation-circle-fill fs-6"
                                    style="font-size: 14px !important;"></span>
                                High Priority
                            </span>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="d-flex align-items-center gap-3 text-secondary small">
                        <span class="d-flex align-items-center gap-1">
                            <span class="bi bi-folder2-open fs-6"></span> <span id="sub-detail-type">Video
                                Content</span>
                        </span>
                        <span class="d-flex align-items-center gap-1">
                            <span class="bi bi-tags fs-6"></span> <span id="sub-detail-task-code">TASK-1284</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="modal-body p-0">
                <div class="row g-0 h-100">
                    <!-- Left Column -->
                    <div class="col-lg-8 p-4 border-end">
                        <div class="row g-4 mb-4">
                            <!-- Assigned To -->
                            <div class="col-sm-6">
                                <label class="form-label text-secondary fw-bold text-uppercase small"
                                    style="letter-spacing: 0.1em; font-size: 0.7rem;">Assigned To</label>
                                <div class="d-flex align-items-center gap-2" id="sub-detail-assigned-container">
                                    <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuBXbWmvXIq0zgos00HR_6QZpRZPiM9gtTXl-R5i2m_iQUzNOdaM2w8PBVI_ykmHIXrzEmXOYfEw9LonI_Z70sEm8zXcsw-QYLPSiuvrNi1g8jMeQw9eyxePPzG5t2JhvFVkrTC6ze8ZI2zbz3SKYJDgrfC_mPMC_GGQH8VZNoX22K4XYerEAH4t87cEVgJOx3Yljz-zln2K6x16Bi_TjSnEixoe5t4SmkAjJukex8PGlfvtLXFPmKIfHr853ulW2O0BxRVtXGewwmoD"
                                        alt="Avatar" class="rounded-circle border" width="32" height="32">
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold small">Sarah Jenkins</span>
                                        <span class="text-muted" style="font-size: 0.7rem;">Lead Content Creator</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Due Date -->
                            <div class="col-sm-6">
                                <label class="form-label text-secondary fw-bold text-uppercase small"
                                    style="letter-spacing: 0.1em; font-size: 0.7rem;">Due Date</label>
                                <div class="d-flex align-items-center gap-2 text-dark fw-medium small">
                                    <span class="bi bi-calendar3 text-primary fs-5"></span>
                                    <span id="sub-detail-due-date">Oct 24, 2024</span>
                                </div>
                            </div>
                            <!-- Task Description -->
                            <div class="col-12">
                                <label class="form-label text-secondary fw-bold text-uppercase small"
                                    style="letter-spacing: 0.1em; font-size: 0.7rem;">Task Description</label>
                                <p class="text-secondary small mb-0" style="line-height: 1.6;"
                                    id="sub-detail-description">
                                    Draft the full technical script for the Series B feature reveal. Focus on the
                                    integration capabilities and the new security dashboard. Must align with the brand
                                    voice guidelines established in the Q3 handbook.
                                </p>
                            </div>
                        </div>

                        <!-- Progress Section -->
                        <div class="card bg-light border-light-subtle shadow-sm">
                            <div class="card-header bg-transparent border-bottom border-light-subtle py-2">
                                <h6 class="fw-bold text-dark small mb-0 d-flex align-items-center gap-2">
                                    <span class="bi bi-pencil-square text-primary fs-6"></span>
                                    Post Progress Update
                                </h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="row g-3 mb-3">
                                    <div class="col-sm-6">
                                        <label class="form-label text-secondary fw-bold text-uppercase small"
                                            style="font-size: 0.65rem;">Status</label>
                                        <select class="form-select form-select-sm border-0 shadow-sm chosen-select"
                                            id="sub-detail-status-select" data-placeholder="Select Status">
                                            <option value="1">WAITING</option>
                                            <option value="2">ON REVIEW</option>
                                            <option value="3">APPROVED</option>
                                            <option value="4">REJECTED</option>
                                            <option value="5">REVISION</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label text-secondary fw-bold text-uppercase small mb-0"
                                                style="font-size: 0.65rem;">Completion</label>
                                            <span class="text-primary fw-bold small"
                                                id="sub-detail-progress-val">0%</span>
                                        </div>
                                        <input type="range" class="form-range" min="0" max="100" value="0"
                                            id="sub-detail-progress">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-secondary fw-bold text-uppercase small"
                                        style="font-size: 0.65rem;">Progress Update Note</label>
                                    <!-- Use a wrapper for OverType if needed, or target directly -->
                                    <div id="sub-detail-note-container" style="min-height: 100px;"
                                        class="border rounded-2 p-1">
                                        <textarea class="form-control form-control-sm border-0 shadow-sm d-none"
                                            id="sub-detail-note" rows="3"
                                            placeholder="Describe current activities, achievements, or any roadblocks encountered..."></textarea>
                                        <div id="overtype-sub-detail-note"></div>
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label text-secondary fw-bold text-uppercase small"
                                        style="font-size: 0.65rem;">File Attachments</label>
                                    <div class="row g-2 mb-2" id="sub-detail-attachments-container">
                                        <!-- Attachments will be rendered here via JS -->
                                    </div>
                                    <!-- Dropzone -->
                                    <div class="dropzone border border-2 border-dashed rounded-3 p-3 text-center bg-white opacity-75"
                                        id="sub-detail-dropzone" role="button">
                                        <div class="dz-message d-flex flex-column align-items-center gap-1">
                                            <span class="bi bi-cloud-upload text-secondary fs-4"></span>
                                            <span class="text-secondary fw-bold small" style="font-size: 0.65rem;">Drop
                                                files
                                                here or click to upload</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column (Activity Log) -->
                    <div class="col-lg-4 p-4 bg-light">
                        <h6 class="text-secondary fw-bold text-uppercase small mb-4 d-flex align-items-center gap-2"
                            style="letter-spacing: 0.1em; font-size: 0.7rem;">
                            <span class="bi bi-clock-history fs-6"></span> Activity Log
                        </h6>

                        <div class="position-relative ps-3" style="border-left: 2px solid #e9ecef;"
                            id="sub-detail-activity-log">
                            <!-- Activity Item 1 -->
                            <div class="position-relative mb-4 ps-3">
                                <span
                                    class="position-absolute top-0 start-0 translate-middle bg-primary border border-4 border-white rounded-circle"
                                    style="width: 14px; height: 14px; left: 0px !important; margin-top: 4px;"></span>
                                <div>
                                    <p class="mb-1 small text-dark" style="font-size: 0.75rem; line-height: 1.4;">
                                        <span class="fw-bold">Sarah J.</span> added a <span
                                            class="text-primary fw-bold">Progress Note</span>
                                    </p>
                                    <div class="bg-white p-2 border rounded small fst-italic text-secondary mb-1"
                                        style="font-size: 0.7rem;">
                                        "Completed first 5 minutes of technical scripting. Awaiting feedback on security
                                        modules."
                                    </div>
                                    <small class="text-muted" style="font-size: 0.65rem;">15 mins ago</small>
                                </div>
                            </div>
                            <!-- Activity Item 2 -->
                            <div class="position-relative mb-4 ps-3">
                                <span
                                    class="position-absolute top-0 start-0 translate-middle bg-secondary border border-4 border-white rounded-circle"
                                    style="width: 14px; height: 14px; left: 0px !important; margin-top: 4px;"></span>
                                <div>
                                    <p class="mb-1 small text-secondary" style="font-size: 0.75rem; line-height: 1.4;">
                                        <span class="fw-bold text-dark">Sarah J.</span> uploaded 2 <span
                                            class="text-primary fw-bold text-decoration-underline"
                                            role="button">attachments</span>
                                    </p>
                                    <small class="text-muted" style="font-size: 0.65rem;">1 hour ago</small>
                                </div>
                            </div>
                            <!-- Activity Item 3 -->
                            <div class="position-relative mb-4 ps-3">
                                <span
                                    class="position-absolute top-0 start-0 translate-middle bg-secondary border border-4 border-white rounded-circle"
                                    style="width: 14px; height: 14px; left: 0px !important; margin-top: 4px;"></span>
                                <div>
                                    <p class="mb-1 small text-secondary" style="font-size: 0.75rem; line-height: 1.4;">
                                        <span class="fw-bold text-dark">Sarah J.</span> updated status to <span
                                            class="text-primary fw-bold">In Progress</span>
                                    </p>
                                    <small class="text-muted" style="font-size: 0.65rem;">2 hours ago</small>
                                </div>
                            </div>
                            <!-- Activity Item 4 -->
                            <div class="position-relative mb-4 ps-3">
                                <span
                                    class="position-absolute top-0 start-0 translate-middle bg-secondary border border-4 border-white rounded-circle"
                                    style="width: 14px; height: 14px; left: 0px !important; margin-top: 4px;"></span>
                                <div>
                                    <p class="mb-1 small text-secondary" style="font-size: 0.75rem; line-height: 1.4;">
                                        <span class="fw-bold text-dark">System</span> created the task
                                    </p>
                                    <small class="text-muted" style="font-size: 0.65rem;">Yesterday, 4:15 PM</small>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-link btn-sm text-decoration-none fw-bold p-0 text-primary"
                            style="font-size: 0.7rem;">View all history</button>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer bg-light border-top-0 rounded-bottom-2">
                <button type="button" class="btn btn-outline-secondary btn-sm me-2"
                    data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-sm shadow-sm px-4" id="btn-update-task"
                    onclick="updateTask()">Update Task</button>
            </div>
        </div>
    </div>
</div>

<!-- Full Log Modal -->
<div class="modal sub_modal fade" id="modal-full-log" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Activity Log</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pb-4 pt-2">
                <p class="text-muted small mb-4">Detailed history of all activities in this campaign.</p>

                <div class="position-relative ps-3 my-2">
                    <!-- Vertical line -->
                    <div class="position-absolute top-0 start-0 h-100 bg-light" style="width: 2px; margin-left: 9px;">
                    </div>

                    <!-- Log Items -->
                    <div class="position-relative mb-4 ps-4">
                        <div class="position-absolute start-0 top-0 bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center border border-4 border-white"
                            style="width: 24px; height: 24px;">
                            <i class="bi bi-check-lg" style="font-size: 12px; font-weight: bold;"></i>
                        </div>
                        <div>
                            <p class="small mb-1"><span class="fw-bold">Mike Ross</span> completed <span
                                    class="fw-medium">Outreach</span>.</p>
                            <p class="text-muted" style="font-size: 10px;">2 hours ago</p>
                        </div>
                    </div>

                    <div class="position-relative mb-4 ps-4">
                        <div class="position-absolute start-0 top-0 bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center border border-4 border-white"
                            style="width: 24px; height: 24px;">
                            <i class="bi bi-file-earmark-arrow-up" style="font-size: 12px; font-weight: bold;"></i>
                        </div>
                        <div>
                            <p class="small mb-1"><span class="fw-bold">Sarah J.</span> uploaded a file.</p>
                            <p class="text-muted" style="font-size: 10px;">3 hours ago</p>
                        </div>
                    </div>

                    <div class="position-relative mb-4 ps-4">
                        <div class="position-absolute start-0 top-0 bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center border border-4 border-white"
                            style="width: 24px; height: 24px;">
                            <i class="bi bi-chat-left-text" style="font-size: 12px; font-weight: bold;"></i>
                        </div>
                        <div>
                            <p class="small mb-1"><span class="fw-bold">Mike Ross</span> commented on <span
                                    class="fw-medium">Series B Script</span>.</p>
                            <p class="text-muted" style="font-size: 10px;">5 hours ago</p>
                        </div>
                    </div>

                    <div class="position-relative ps-4 text-start">
                        <div class="position-absolute start-0 top-0 bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center border border-4 border-white"
                            style="width: 24px; height: 24px;">
                            <i class="bi bi-plus-lg" style="font-size: 12px; font-weight: bold;"></i>
                        </div>
                        <div>
                            <p class="small mb-1"><span class="fw-bold">System</span> created the campaign.</p>
                            <p class="text-muted" style="font-size: 10px;">Yesterday</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>