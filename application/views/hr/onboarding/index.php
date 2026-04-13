<main class="main mainheight" style="margin-top:70px">
    <div class="container-fluid mb-4">
        <div class="row pt-4 pb-2 justify-content-between">
            <div class="col">
                <h3>Dashboard Onboarding </h3>
                <span class="text-muted small">Menyajikan Insight Performa Onboarding Training untuk mendukung kemudahan
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
            <div class="col">
                <div class="glass-card p-3 h-100">
                    <h5 class="fw-bold">Onboarding Funnel</h5>
                    <div style="height: 250px;">
                        <canvas id="funnelChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="glass-card p-3 h-100 d-flex flex-column">
                    <h5 class="fw-bold">Overall Progress</h5>
                    <div class="flex-grow-1 position-relative d-flex justify-content-center align-items-center">
                        <div style="width: 100%; max-width: 250px;">
                            <canvas id="gaugeChart"></canvas>
                        </div>
                        <div class="position-absolute text-center"
                            style="top: 75%; left: 50%; transform: translate(-50%, -50%);">
                            <span class="badge bg-success px-3 py-2 fs-6 mb-1" id="value_overall">60%</span>
                            <div class="small fw-bold text-muted" style="font-size: 0.75rem;">
                                Goal <i class="bi bi-check2 text-success"></i> 100%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row g-3 mb-4">


            <div class="col-12">
                <div class="glass-card p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold">Total Activity lewat SLA</h5>
                        <!-- <button class="btn btn-sm btn-light border-0"><i class="bi bi-filter"></i></button> -->
                    </div>
                    <div style="width: 100%; height:250px">
                        <canvas id="slaChart"></canvas>
                    </div>

                    <!-- <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3 d-flex align-items-center justify-content-center"
                                style="width: 35px; height: 35px;">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="small fw-bold mb-0">List Calon Karyawan Onboarding</div>
                            </div>
                            <div class="text-end ms-2">
                                <i class="bi bi-check-square-fill text-primary fs-5"></i>
                                <div class="text-muted" style="font-size: 0.65rem;">2 hari lalu</div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3 d-flex align-items-center justify-content-center"
                                style="width: 35px; height: 35px;">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="small fw-bold mb-0">List Final Peserta Onboarding</div>
                            </div>
                            <div class="text-end ms-2">
                                <i class="bi bi-check-square-fill text-primary fs-5"></i>
                                <div class="text-muted" style="font-size: 0.65rem;">2 hari lalu</div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3 d-flex align-items-center justify-content-center"
                                style="width: 35px; height: 35px;">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="small fw-bold mb-0">Materi & Absensi Training</div>
                            </div>
                            <div class="text-end ms-2">
                                <i class="bi bi-check-square-fill text-primary fs-5"></i>
                                <div class="text-muted" style="font-size: 0.65rem;">2 hari lalu</div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3 d-flex align-items-center justify-content-center"
                                style="width: 35px; height: 35px;">
                                <i class="bi bi-image"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="small fw-bold mb-0">Dokumen Standar Kerja Karyawan Baru</div>
                            </div>
                            <div class="text-end ms-2 text-center">
                                <i class="bi bi-arrow-repeat text-secondary fs-5 d-inline-block"
                                    style="animation: spin 2s linear infinite;"></i>
                                <div class="text-muted" style="font-size: 0.65rem;">Progress</div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>

        </div>
        <div class="row mb-4">
            <div class="col-12">
                <div class="glass-card w-100 p-3">
                    <h5>On Boarding Training Process Tracker</h5>
                    <div class="row mb-4">
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="card bg-white w-100 p-3">
                                <div class="row align-items-center text-start g-3">

                                    <div class="col-12 col-md px-3 border-end">
                                        <div class="text-secondary small mb-2">
                                            <i class="bi bi-people text-primary me-1"></i> Total Peserta Onboarding
                                        </div>
                                        <h4 class="mb-0 fw-bold" id="total_karyawan">0</h4>
                                    </div>

                                    <div class="col-12 col-md px-3 border-end">
                                        <div class="text-secondary small mb-2">
                                            <i class="bi bi-arrow-repeat text-primary me-1"></i> % Onboarding Completed
                                        </div>
                                        <div class="d-flex align-items-baseline gap-2">
                                            <span class="text-secondary small" id="ratio_complete">(0/0)</span>
                                            <h4 class="mb-0 fw-bold" id="persen_complete">0%</h4>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md px-3 border-end">
                                        <div class="text-secondary small mb-2">
                                            <i class="bi bi-person-gear text-primary me-1"></i> Peserta InProgress
                                        </div>
                                        <div class="d-flex align-items-baseline gap-2">
                                            <span class="text-secondary small" id="ratio_inprogress">(0/0)</span>
                                            <h4 class="mb-0 fw-bold" id="peserta_count">0</h4>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md px-3 border-end">
                                        <div class="text-secondary small mb-2">
                                            <i class="bi bi-exclamation-circle text-primary me-1"></i> Peserta Belum
                                            Mulai
                                        </div>
                                        <div class="d-flex align-items-baseline gap-2">
                                            <span class="text-secondary small" id="ratio_not_started">(0/0)</span>
                                            <h4 class="mb-0 fw-bold" id="not_started">0</h4>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md px-3">
                                        <div class="text-secondary small mb-2">
                                            <i class="bi bi-journal-check text-primary me-1"></i> BA Serah Terima
                                        </div>
                                        <h4 class="mb-2 fw-bold" id="progres_val">0</h4>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="progress flex-grow-1" style="height: 6px;">
                                                <div id="progress_bar" class="progress-bar bg-primary"
                                                    style="width: 0%"></div>
                                            </div>
                                            <span id="persen_progres" class="badge rounded-pill text-primary"
                                                style="background-color: #e6f2ff;">
                                                0%
                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="data_proses" class="table table-bordered bg-white nowrap">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center align-middle">No</th>
                                    <th rowspan="2" class="text-center align-middle">Nama Karyawan</th>
                                    <th rowspan="2" class="text-center align-middle">Company</th>
                                    <th rowspan="2" class="text-center align-middle">Department</th>
                                    <th rowspan="2" class="text-center align-middle">Join Date</th>
                                    <th rowspan="2" class="text-center align-middle">Resign Date</th>
                                    <th rowspan="2" class="text-center align-middle">Status Onboarding</th>
                                    <th colspan="3" class="text-center">Training Class</th>
                                    <th colspan="3" class="text-center">Assignment</th>
                                    <th colspan="3" class="text-center">Office Tour</th>
                                    <th colspan="3" class="text-center">BA Serah Terima</th>
                                    <th rowspan="2" class="text-center align-middle">Status Kelulusan</th>
                                    <!-- <th rowspan="2" class="text-center align-middle">Action</th> -->
                                </tr>
                                <tr>
                                    <th class="text-center">Due Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actual Date</th>
                                    <th class="text-center">Due Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actual Date</th>
                                    <th class="text-center">Due Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actual Date</th>
                                    <th class="text-center">Due Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actual Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
</main>

<div class="modal fade" id="modal_take_tasklist" role="dialog">
    <div class="modal-dialog center">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Take Tasklist</h4>
                <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button"
                    aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <form id="form_take">
                <div class="modal-body">

                    <div class="form-group mb-2 position-relative check-valid">
                        <label>Rencana & Deskripsi</label>
                        <input type="text" class="form-control hidden" name="id" id="id_task" readonly value="">
                        <input type="text" class="form-control border-custom deskripsi" readonly>
                    </div>
                    <div class="form-group mb-2 position-relative check-valid">
                        <label>Action <b class="text-danger small">*</b></label>
                        <select name="action" class="form-control border-custom action_take" required>
                            <option value="" selected disabled>-- Pilih Action --</option>
                            <option value="1">Take</option>
                            <option value="2">Reject</option>
                        </select>
                    </div>
                    <div class="row row_take" style="display:none">
                        <hr>
                        <div class="col-12 mb-2">
                            <div class="form-group mb-1 position-relative check-valid">
                                <label>Goals <b class="text-danger small">*</b></label>
                                <input type="text" name="goal" class="form-control border-custom deskripsi">
                            </div>

                        </div>
                        <div class="col mb-2">
                            <div class="form-group mb-1 position-relative check-valid">
                                <label>Priority <b class="text-danger small">*</b></label>
                                <select name="priority" class="form-control border-custom">
                                    <option value="" selected disabled>-- Pilih --</option>
                                    <option value="1">Critical</option>
                                    <option value="2">High</option>
                                    <option value="3">Medium</option>
                                    <option value="4">Low</option>
                                </select>
                            </div>

                        </div>
                        <div class="col mb-2">
                            <div class="form-group mb-1 position-relative check-valid">
                                <label>Due Date <b class="text-danger small">*</b></label>
                                <input type="date" name="due_date" class="form-control border-custom">
                            </div>

                        </div>
                        <div class="col-12 mb-2">
                            <div class="form-group mb-1 position-relative check-valid">
                                <label>PIC<b class="text-danger small">*</b></label>
                                <select name="pic[]" multiple class="form-control border-custom" id="pic">
                                    <option value="">-- Pilih PIC --</option>
                                    <?php foreach ($pic as $item): ?>
                                        <option value="<?= $item->user_id ?>"><?= $item->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary  me-1"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-md btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>