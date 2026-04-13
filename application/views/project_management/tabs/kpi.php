<div id="kpi-empty-state" class="d-none">
    <!-- empty state -->
    <div class="text-center py-5">
        <i class="bi bi-speedometer2 fs-1 text-muted mb-3"></i>
        <h5 class="text-muted">Belum ada data KPI</h5>
        <p class="text-muted">Data KPI akan muncul di sini</p>
    </div>
</div>


<div class="p-3" id="kpi-content">
    <div class="d-flex justify-content-between mb-4">
        <ul class="nav nav-pills nav-pills-custom" id="kpiWeeksTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="week1-tab" data-bs-toggle="pill" data-bs-target="#week1" type="button" role="tab">Week 1</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="week2-tab" data-bs-toggle="pill" data-bs-target="#week2" type="button" role="tab">Week 2</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="week3-tab" data-bs-toggle="pill" data-bs-target="#week3" type="button" role="tab">Week 3</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="week4-tab" data-bs-toggle="pill" data-bs-target="#week4" type="button" role="tab">Week 4</button>
            </li>
        </ul>
        <div class="d-flex gap-2">
            <!-- button input/edit review -->
            <button class="btn btn-primary" id="showKpiReviewBtn">Show Review</button>
            <button class="btn btn-warning" id="editKpiReviewBtn">Edit Review</button>
        </div>
    </div>

    <div class="tab-content" id="kpiWeeksTabsContent">
        <?php for ($w = 1; $w <= 4; $w++): ?>
            <div class="tab-pane fade <?php echo $w == 1 ? 'show active' : ''; ?>" id="week<?php echo $w; ?>" role="tabpanel">
                <!-- Metrics Overview -->
                <div class="row g-3 border-bottom pb-4 mb-4 mt-3">
                    <div class="col-12 col-md-4">
                        <div class="border rounded-3 h-100 py-3 px-4 bg-white" style="border-color: #e5e7eb !important;">
                            <div class="text-success mb-2 d-flex align-items-center">
                                <i class="bi bi-graph-up-arrow me-2 fs-5"></i>
                                <div class="text-secondary fw-medium" style="font-size: 0.85rem;">Achievement</div>
                            </div>
                            <h3 class="fw-bold text-dark mb-0"><span id="kpi-total-ach-<?php echo $w; ?>">0</span>%</h3>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="border rounded-3 h-100 py-3 px-4 bg-white" style="border-color: #e5e7eb !important;">
                            <div class="text-danger mb-2 d-flex align-items-center">
                                <i class="bi bi-award-fill me-2 fs-5"></i>
                                <div class="text-secondary fw-medium" style="font-size: 0.85rem;">Final Score</div>
                            </div>
                            <h3 class="fw-bold text-dark mb-0" id="kpi-total-final-score-<?php echo $w; ?>">0</h3>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="border rounded-3 h-100 py-3 px-4 bg-white" style="border-color: #e5e7eb !important;">
                            <div class="text-primary mb-2 d-flex align-items-center">
                                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                                <div class="text-secondary fw-medium" style="font-size: 0.85rem;">KPI Met</div>
                            </div>
                            <h3 class="fw-bold text-dark mb-0" id="kpi-total-met-<?php echo $w; ?>">0 / 0</h3>
                        </div>
                    </div>
                </div>

                <!-- Table Data -->
                <div class="table-responsive">
                    <table class="table table-borderless align-middle w-100" style="min-width: 800px;">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th class="fw-semibold py-3 px-3 rounded-start" style="font-size: 0.85rem;">KPI & Bobot</th>
                                <th class="fw-semibold text-center py-3" style="font-size: 0.85rem;">Target</th>
                                <th class="fw-semibold text-center py-3" style="font-size: 0.85rem;">Aktual</th>
                                <th class="fw-semibold text-center py-3" style="font-size: 0.85rem;">Ach</th>
                                <th class="fw-semibold text-center py-3" style="font-size: 0.85rem;">Bobot</th>
                                <th class="fw-semibold text-center py-3" style="font-size: 0.85rem;">Final Ach</th>
                                <th class="fw-semibold text-center py-3" style="font-size: 0.85rem;">Score</th>
                                <th class="fw-semibold text-center py-3" style="font-size: 0.85rem;">Final Score</th>
                                <th class="fw-semibold py-3 rounded-end" style="width: 50px;">#</th>
                            </tr>
                        </thead>
                        <tbody id="kpi-tbody-<?php echo $w; ?>">
                            <!-- Data will be loaded here via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</div>

<?php $this->load->view('project_management/tabs/kpi_modal'); ?>