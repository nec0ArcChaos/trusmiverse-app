<div id="tasklist_problem-empty-state" class="d-none">
    <!-- empty state -->
    <div class="text-center py-5">
        <i class="bi bi-speedometer2 fs-1 text-muted mb-3"></i>
        <h5 class="text-muted">Belum ada data Kendala</h5>
        <p class="text-muted">Data Kendala akan muncul di sini</p>
    </div>
</div>

<div class="p-3">
    <!-- Header with Add Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0 fw-bold">Daftar Kendala Task</h5>
        <button type="button" class="btn btn-primary btn-sm" id="btn-add-problem">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kendala
        </button>
    </div>

    <!-- Mini Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-2-4">
            <div class="mini-metric-card">
                <div class="mm-header mb-1"><span class="dot bg-danger"></span>Task Melewati Deadline</div>
                <div class="mm-value" id="metric-past-deadline">0 Task</div>
                <div class="mm-footer text-danger"><i class="bi bi-exclamation-triangle-fill"></i> Butuh penanganan</div>
            </div>
        </div>
        <div class="col-12 col-md-2-4">
            <div class="mini-metric-card">
                <div class="mm-header mb-1"><span class="dot bg-warning"></span>Task Berpotensi Telat</div>
                <div class="mm-value" id="metric-potential-late">0 Task</div>
                <div class="mm-footer text-warning"><i class="bi bi-compass"></i> Butuh Dianalisis</div>
            </div>
        </div>
        <div class="col-12 col-md-2-4">
            <div class="mini-metric-card">
                <div class="mm-header mb-1"><span class="dot bg-danger-dark"></span>Kendala Belum Solved</div>
                <div class="mm-value" id="metric-unsolved-problem">0 Task</div>
                <div class="mm-footer text-danger-dark"><i class="bi bi-chat-right-dots-fill"></i> Butuh Followup</div>
            </div>
        </div>
        <div class="col-12 col-md-2-4">
            <div class="mini-metric-card">
                <div class="mm-header mb-1"><span class="dot bg-success-light"></span>Kendala di Proses</div>
                <div class="mm-value" id="metric-processing-problem">0 Task</div>
                <div class="mm-footer text-danger"><i class="bi bi-exclamation-triangle-fill"></i> Butuh penanganan</div>
            </div>
        </div>
        <div class="col-12 col-md-2-4">
            <div class="mini-metric-card">
                <div class="mm-header mb-1"><span class="dot bg-success"></span>Kendala Solved</div>
                <div class="mm-value" id="metric-solved-problem">0 Task</div>
                <div class="mm-footer text-success"><i class="bi bi-check-circle-fill"></i> Selesai ditangani</div>
            </div>
        </div>
    </div>

    <!-- Accordions -->
    <div class="accordion custom-accordion" id="problemAccordion">
        <!-- Sudah Telat Section -->
        <div class="accordion-item border-0 mb-3">
            <div class="accordion-header" id="headingLate">
                <button class="accordion-button bg-white shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLate" aria-expanded="true">
                    <span class="dot bg-danger me-2"></span>
                    <span class="fw-bold text-danger me-2">Sudah Telat - Deadline Terlewat</span>
                    <span class="badge rounded-pill bg-light text-dark fw-normal" id="badge-late-count">0 Task</span>
                </button>
            </div>
            <div id="collapseLate" class="accordion-collapse collapse show" aria-labelledby="headingLate">
                <div class="accordion-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom align-middle">
                            <thead>
                                <tr>
                                    <th>Nama Task</th>
                                    <th>Kategori</th>
                                    <th>PIC</th>
                                    <th>Deadline Req</th>
                                    <th>Progress</th>
                                    <th>Kendala</th>
                                    <th>Status</th>
                                    <th>Estimasi Selesai</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-late-tasks">
                                <!-- Populated by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Proyeksi Telat Section -->
        <div class="accordion-item border-0">
            <div class="accordion-header" id="headingProjection">
                <button class="accordion-button bg-white shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProjection" aria-expanded="true">
                    <span class="dot bg-warning me-2"></span>
                    <span class="fw-bold text-warning me-2">Proyeksi Telat - Berpotensi Melewati Deadline</span>
                    <span class="badge rounded-pill bg-light text-dark fw-normal" id="badge-projection-count">0 Task</span>
                </button>
            </div>
            <div id="collapseProjection" class="accordion-collapse collapse show" aria-labelledby="headingProjection">
                <div class="accordion-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom align-middle">
                            <thead>
                                <tr>
                                    <th>Nama Task</th>
                                    <th>Kategori</th>
                                    <th>PIC</th>
                                    <th>Deadline Req</th>
                                    <th>Progress</th>
                                    <th>Kendala</th>
                                    <th>Status</th>
                                    <th>Estimasi Selesai</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-projection-tasks">
                                <!-- Populated by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>