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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                            <!-- Campaign -->
                            <div class="col-12 mb-3">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0"
                                                id="form-campaign-name" placeholder="Campaign" readonly
                                                style="background-color: #e9ecef;">
                                            <label for="form-campaign-name">Campaign</label>
                                        </div>
                                    </div>
                                </div>
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
                                        <div id="overtype-current-activation" style="height: 120px;"></div>
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
                    <div class="wizard-step" data-step="3" style="display: none;">
                        <p class="fw-medium title" style="line-height: 1.5;">Konten<br>
                            <small class="text-muted">Output konten dan platform tujuan.</small>
                        </p>
                        <div class="row">
                            <!-- Konten yang Dihasilkan -->
                            <div class="col-6 mb-3">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <!-- Using standard select but with chosen-select class to be initialized in JS -->
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

                            <!-- Platform Tujuan -->
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
                    </div>
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