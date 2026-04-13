<main class="main mainheight" style="margin-top:70px">
    <div class="container-fluid mb-4">
        <div class="row pt-4 pb-2 justify-content-between">
            <div class="col">
                <h3>Dashboard Refreshment</h3>
                <span class="text-muted small">Menyajikan Insight Performa Refreshment Training untuk mendukung kemudahan
                    analisis dalam mengambil kesimpulan</span>
            </div>
            <div class="col-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center gap-1">
                        <i class="bi bi-exclamation-circle-fill text-secondary"></i>
                        <span style="font-size: 0.875rem;">Not Started</span>
                    </div>

                    <div class="d-flex align-items-center gap-1">
                        <i class="bi bi-check-circle-fill text-warning"></i>
                        <span style="font-size: 0.875rem;">In Progress</span>
                    </div>

                    <div class="d-flex align-items-center gap-1">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <span style="font-size: 0.875rem;">Completed</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="d-flex justify-content-between align-items-center flex-wrap mb-2"> -->

        <div class="row g-3 align-items-end mb-4">

            <div class="col-2">
                <label class="form-label small fw-bold text-secondary mb-1">Periode</label>
                <div class="input-group">
                    <button type="button" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-calendar"></i> <span id="periodeBtn">Periode</span>
                    </button>
                    <style>
                        #periode-list {
                            max-height: 280px;
                            /* Atur tinggi maksimal dropdown */
                            overflow-y: auto;
                            /* Tampilkan scrollbar vertikal jika perlu */
                        }
                    </style>
                    <ul class="dropdown-menu" id="periode-list">
                        <?php
                        $startYear = 2025;
                        $startMonth = 8; // Agustus
                        $endYear = 2026;
                        $endMonth = 12; // Desember
                        $currentPeriod = date('Y-m');
                        $bulanIndonesia = [
                            1 => 'Januari',
                            'Februari',
                            'Maret',
                            'April',
                            'Mei',
                            'Juni',
                            'Juli',
                            'Agustus',
                            'September',
                            'Oktober',
                            'November',
                            'Desember'
                        ];

                        // Mulai looping
                        for ($year = $startYear; $year <= $endYear; $year++) {
                            $loopStartMonth = ($year == $startYear) ? $startMonth : 1;
                            $loopEndMonth = ($year == $endYear) ? $endMonth : 12;

                            for ($month = $loopStartMonth; $month <= $loopEndMonth; $month++) {
                                $value = sprintf('%d-%02d', $year, $month);
                                $text = $bulanIndonesia[$month] . ' ' . $year;
                                $activeClass = ($value == $currentPeriod) ? 'active' : '';
                                echo "<li><button class=\"dropdown-item {$activeClass}\" value=\"{$value}\">{$text}</button></li>";
                            }
                            if ($year < $endYear) {
                                echo '<li><hr class="dropdown-divider"></li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>

            <!-- <div class="col-2">
                <label for="filterDepartemen" class="form-label small fw-bold text-secondary mb-1">Departemen</label>
                <select class="form-select" id="filterDepartemen">
                    <option value="all" selected>(All)</option>
                    <option value="hr">HR</option>
                    <option value="it">IT</option>
                    <option value="finance">Finance</option>
                </select>
            </div>

            <div class="col-2">
                <label for="filterJabatan" class="form-label small fw-bold text-secondary mb-1">Level
                    Jabatan</label>
                <select class="form-select" id="filterJabatan">
                    <option value="all" selected>(All)</option>
                    <option value="staff">Staff</option>
                    <option value="supervisor">Supervisor</option>
                    <option value="manager">Manager</option>
                </select>
            </div>

            <div class="col-2">
                <label for="filterDesignation" class="form-label small fw-bold text-secondary mb-1">Designation</label>
                <select class="form-select" id="filterDesignation">
                    <option value="all" selected>(All)</option>
                    <option value="des1">Designation 1</option>
                    <option value="des2">Designation 2</option>
                </select>
            </div>

            <div class="col-2">
                <label for="filterStatus" class="form-label small fw-bold text-secondary mb-1">Onboarding
                    Status</label>
                <select class="form-select" id="filterStatus">
                    <option value="not_started" selected>Not Started</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                    <option value="all">(All)</option>
                </select>
            </div> -->

        </div>
        <!-- </div> -->
        <div class="row mb-4">
            <div class="col-12 col-md-12 col-lg-12 mb-2">
                <div class="glass-card w-100 p-3">
                    <div class="row align-items-center text-start g-3">

                        <div class="col-12 col-xl px-3 border-end">
                            <div class="text-secondary small mb-2 text-truncate" title="Total Karyawan Underperform">
                                <i class="bi bi-people text-primary me-1"></i> Total Karyawan Underperform
                            </div>
                            <h4 class="mb-0 fw-bold" id="val-total-under">0</h4>
                        </div>

                        <div class="col-12 col-xl px-3 border-end">
                            <div class="text-secondary small mb-2 text-truncate" title="TNA Completed">
                                <i class="bi bi-journal-text text-primary me-1"></i> TNA Completed
                            </div>
                            <div class="d-flex align-items-baseline gap-2">
                                <span class="text-secondary small" id="ratio-tna">(0/0)</span>
                                <h4 class="mb-0 fw-bold" id="val-tna">0</h4>
                            </div>
                        </div>

                        <div class="col-12 col-xl px-3 border-end">
                            <div class="text-secondary small mb-2 text-truncate" title="Training Materials Prepared">
                                <i class="bi bi-file-earmark-text text-primary me-1"></i> Materials Prepared
                            </div>
                            <div class="d-flex align-items-baseline gap-2">
                                <span class="text-secondary small" id="ratio-prepare">(0/0)</span>
                                <h4 class="mb-0 fw-bold" id="val-prepare">0</h4>
                            </div>
                        </div>

                        <div class="col-12 col-xl px-3 border-end">
                            <div class="text-secondary small mb-2 text-truncate" title="Materials Approved">
                                <i class="bi bi-check2-circle text-primary me-1"></i> Materials Approved
                            </div>
                            <div class="d-flex align-items-baseline gap-2">
                                <span class="text-secondary small" id="ratio-approved">(0/0)</span>
                                <h4 class="mb-0 fw-bold" id="val-approved">0</h4>
                            </div>
                        </div>

                        <div class="col-12 col-xl px-3 border-end">
                            <div class="text-secondary small mb-2 text-truncate" title="Training Implementations">
                                <i class="bi bi-arrow-repeat text-primary me-1"></i> Training Implementations
                            </div>
                            <div class="d-flex align-items-baseline gap-2">
                                <span class="text-secondary small" id="ratio-implement">(0/0)</span>
                                <h4 class="mb-0 fw-bold" id="val-implement">0</h4>
                            </div>
                        </div>

                        <div class="col-12 col-xl px-3">
                            <div class="text-danger small mb-2 text-truncate" title="Growth After Training">
                                <i class="bi bi-graph-up-arrow text-primary me-1"></i> Growth After Training
                            </div>
                            <div class="d-flex align-items-baseline gap-2">
                                <span class="text-secondary small">(0/0)</span>
                                <h4 class="mb-0 fw-bold">0</h4>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="glass-card p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold text-dark mb-0">Upcoming Training</h5>
                    </div>

                    <div class="d-flex flex-column" id="upcoming-container">
                    </div>

                </div>
            </div>

            <div class="col-lg-6">
                <div class="glass-card p-4 h-100">
                    <h5 class="fw-bold mb-4 text-danger">Overall Progress</h5>

                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h6 class="small fw-bold text-muted mb-3">Detail</h6>
                            <div class="progress-list-item">
                                <span>Training Need Analysis</span>
                                <span><span class="fw-bold text-primary">50/50</span> <i
                                        class="bi bi-check-square-fill text-primary ms-1"></i></span>
                            </div>
                            <div class="progress-list-item">
                                <span>Training Materials Progressed</span>
                                <span><span class="fw-bold text-primary">50/50</span> <i
                                        class="bi bi-check-square-fill text-primary ms-1"></i></span>
                            </div>
                            <div class="progress-list-item">
                                <span>Materials Approved</span>
                                <span><span class="fw-bold text-primary">50/50</span> <i
                                        class="bi bi-check-square-fill text-primary ms-1"></i></span>
                            </div>
                            <div class="progress-list-item">
                                <span>Scheduled Finalized</span>
                                <span><span class="fw-bold">30/45</span> <i
                                        class="bi bi-circle text-muted ms-1"></i></span>
                            </div>
                            <div class="progress-list-item">
                                <span>Training Conducted</span>
                                <span><span class="fw-bold">35/45</span> <i
                                        class="bi bi-circle text-muted ms-1"></i></span>
                            </div>
                            <div class="progress-list-item">
                                <span>Laporan Onboarding</span>
                                <span><span class="fw-bold">25/45</span> <i
                                        class="bi bi-circle text-muted ms-1"></i></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="chart-container">
                                <div class="chart-center-text">
                                    <h3 class="fw-bold text-success mb-0" style="font-size: 2.2rem;">62%</h3>
                                    <div class="small text-muted" style="line-height: 1.2;">
                                        Selesai <span class="fw-bold text-dark">62%</span>, sisa <span
                                            class="fw-bold text-danger">38%</span><br>menuju target <span
                                            class="fw-bold text-dark">100%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="glass-card p-4 mb-4">
            <h5 class="fw-bold mb-4">Detail Training</h5>
            <div class="table-responsive">
                <table id="table-monitoring" class="table table-hover nowrap align-middle w-100">
                <!-- <table id="table-monitoring" class="table table-hover align-middle w-100 nowrap"> -->
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Status</th>
                            <th>Class Koordinator</th>
                            <th>Training Program</th>
                            <th>Training Name</th>
                            <th>Batch</th>
                            <th>Materi / Modul</th>
                            <th>Divisi</th>
                            <th>Departemen</th>
                            <th>Participant Target</th>
                            <th>Objective</th>
                            <th>Outline</th>
                            <th>Metode Training</th>
                            <th>Plan Trainer</th>
                            <th>Actual Trainer</th>
                            <th>Kategori Trainer</th>
                            <th>Tempat</th>
                            <th>Month</th>
                            <th>Week</th>
                            <th>Plan Start</th>
                            <th>Plan End</th>
                            <th>Actual</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai (Actual)</th>
                            <th>Learning Hours</th>
                            <!-- <th>Skala LH</th> -->
                            <th>Plan Peserta</th>
                            <th>Actual Peserta</th>
                            <th>Keterangan</th>
                            <th>Foto Aktivitas</th>
                            <th>Avg Nilai Pre Learning</th>
                            <th>Avg Nilai Post Learning</th>
                            <th>Avg Feedback Trusmi</th>
                            <th>Avg Feedback Workshop</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>


        </div>


    </div>
</main>