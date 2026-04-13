<main class="main mainheight">
    <style>
        /* Custom Styles untuk Komponen Event */
        .mainheight {
            min-height: 500vh;
            background-color: #f8f9fa;
        }

        .event-wrapper {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 2px solid #0d6efd;
            margin-top: 1rem;
        }

        /* Header */
        .event-header {
            background-color: #0d6efd;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Sidebar */
        .event-sidebar {
            border-right: 1px solid #eee;
            padding: 0;
            background: #fff;
        }

        .event-sidebar .nav-link {
            color: #6c757d;
            padding: 14px 20px;
            border-bottom: 1px solid #f8f9fa;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .event-sidebar .nav-link:hover {
            background-color: #f8f9fa;
        }

        .event-sidebar .nav-link.active {
            background-color: #e7f1ff;
            color: #0d6efd;
            border-right: 4px solid #0d6efd;
            font-weight: 600;
        }

        /* Content Area */
        .event-content {
            padding: 25px;
            min-height: 550px;
        }

        .section-card {
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            background: #fff;
        }

        /* Table Styling */
        .table-container {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            border: 1px solid #eee;
        }

        .table-custom {
            background: white;
            font-size: 0.85rem;
        }

        /* Avatar Stack */
        .avatar-group {
            display: flex;
            align-items: center;
        }

        .avatar-item {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 2px solid white;
            margin-left: -10px;
            object-fit: cover;
        }

        .avatar-item:first-child {
            margin-left: 0;
        }

        .avatar-counter {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #ffebee;
            color: #f44336;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: -10px;
            border: 2px solid white;
            font-weight: bold;
        }

        /* Footer Action */
        .event-footer {
            padding: 15px 25px;
            border-top: 1px dashed #0d6efd;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
        }

        .progress-w {
            width: 150px;
            height: 8px;
        }
    </style>

    <main class="main mainheight pb-5">
        <div class="event-wrapper">
            <div class="event-header">
                <div class="d-flex align-items-center">
                    <i class="bi bi-plus-square-fill me-2"></i>
                    <span class="fw-bold">Input Data Event</span>
                </div>
                <a href="#" class="text-white"><i class="bi bi-x-circle fs-5"></i></a>
            </div>

            <div class="row g-0">
                <div class="col-md-1 event-sidebar">
                    <div class="nav flex-column">
                        <a class="nav-link d-flex justify-content-between align-items-center" href="#">GRD <i
                                class="bi bi-check2-circle text-success"></i></a>
                        <a class="nav-link d-flex justify-content-between align-items-center" href="#">Interview <i
                                class="bi bi-check2-circle text-success"></i></a>
                        <a class="nav-link d-flex justify-content-between align-items-center" href="javascript:void(0)"
                            onclick="switchContent('mom-content', this)">
                            MoM <i class="bi bi-record-circle text-primary"></i>
                        </a>
                        <a class="nav-link d-flex justify-content-between align-items-center" href="javascript:void(0)"
                            onclick="switchContent('genba-content', this)">
                            Genba <i class="bi bi-circle text-muted" style="opacity: 0.3;"></i>
                        </a>
                        <a class="nav-link d-flex justify-content-between align-items-center" href="#">co&co <i
                                class="bi bi-circle text-muted" style="opacity: 0.3;"></i></a>
                        <a class="nav-link d-flex justify-content-between align-items-center" href="#">Sharing Leader <i
                                class="bi bi-circle text-muted" style="opacity: 0.3;"></i></a>
                        <a class="nav-link d-flex justify-content-between align-items-center" href="#">Improvement
                            Sistem <i class="bi bi-circle text-muted" style="opacity: 0.3;"></i></a>
                        <a class="nav-link d-flex justify-content-between align-items-center" href="#">Briefing <i
                                class="bi bi-circle text-muted" style="opacity: 0.3;"></i></a>
                    </div>
                </div>

                <div class="col-md-11 event-content ps-md-4">

                    <div id="mom-content" class="section-item">
                        <h5 class="mb-3 text-primary"><i class="bi bi-file-earmark-text me-2"></i>Data Minutes of
                            Meeting</h5>

                        <div class="accordion" id="accordionMoM">
                            <div class="accordion-item mb-3 border-0 shadow-sm">
                                <h2 class="accordion-header">
                                    <button class="accordion-button bg-white" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#momW1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" checked
                                                onclick="return false;">
                                            <label class="form-check-label fw-bold">Input Data MoM Week 1</label>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapseWeek1" class="accordion-collapse collapse show">

                                    <div class="accordion-body bg-white pt-0">
                                        <div id="mom_selected_1" class="p-3 border rounded bg-light mb-3">

                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-file-earmark-text fs-4 me-3 text-secondary"></i>
                                                    <div>
                                                        <div class="fw-bold text-primary" id="mom_no_1">MOM251201004
                                                        </div>
                                                        <div class="text-muted small" id="mom_judul_1">Meeting
                                                            Koordinasi
                                                            Manager dan GM Legal</div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-link btn-sm text-decoration-none p-0">
                                                    <i class="bi bi-arrow-clockwise"></i> Ubah Data
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item mb-3 border-0 shadow-sm">
                                <h2 class="accordion-header">
                                    <button class="accordion-button bg-white collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseWeek2">
                                        <div class="form-check">
                                            <input class="form-check-input week-check" type="checkbox"
                                                id="check_status_2" <?= !empty($mom_week2) ? 'checked' : '' ?>
                                                onclick="return false;">
                                            <label class="form-check-label fw-bold">Input Data MoM Week 2</label>
                                        </div>
                                    </button>
                                </h2>

                                <div id="collapseWeek2" class="accordion-collapse collapse">
                                    <div class="accordion-body bg-white pt-0">

                                        <div id="container_input_2" class="<?= !empty($mom_week2) ? 'd-none' : '' ?>">
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="bi bi-pencil-square text-primary me-2"></i>
                                                <span class="fw-bold">Pilih Data MoM Week 2</span>
                                            </div>
                                            <div class="table-responsive rounded border shadow-sm bg-white">
                                                <table class="table table-hover align-middle mb-0" id="dt_mom"
                                                    style="width:100%">
                                                    <thead class="table-light">
                                                        <tr style="font-size: 12px;">
                                                            <th width="40"></th>
                                                            <th>No MoM</th>
                                                            <th width="170px">Judul</th>
                                                            <th>Meeting</th>
                                                            <th>Department</th>
                                                            <th>Peserta</th>
                                                            <th>Agenda</th>
                                                            <th>Pembahasan</th>
                                                            <th>Tempat</th>
                                                            <th>Tanggal</th>
                                                            <th>Waktu</th>
                                                            <th>List Peserta</th>
                                                            <th>Created By</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div id="container_summary_2" class="<?= empty($mom_week2) ? 'd-none' : '' ?>">
                                            <div id="mom_selected_2" class="p-3 border rounded bg-light mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-file-earmark-text fs-4 me-3 text-secondary"></i>
                                                        <div>
                                                            <div class="fw-bold text-primary" id="sum_no_2">
                                                                <?= $mom_week2['id_mom'] ?? '' ?>
                                                            </div>
                                                            <div class="text-muted small" id="sum_judul_2">
                                                                <?= $mom_week2['judul'] ?? '' ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="button"
                                                        class="btn btn-link btn-sm text-decoration-none p-0"
                                                        onclick="editSelection(2)">
                                                        <i class="bi bi-arrow-clockwise"></i> Ubah Data
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item mb-3 border-0 shadow-sm">
                                <h2 class="accordion-header">
                                    <button class="accordion-button bg-white collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseWeek2">
                                        <div class="form-check">
                                            <input class="form-check-input week-check" type="checkbox">
                                            <label class="form-check-label fw-bold">Input Data MoM Week 2</label>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapseWeek2" class="accordion-collapse collapse">
                                    <div class="accordion-body bg-white pt-0">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="bi bi-pencil-square text-primary me-2"></i>
                                            <span class="fw-bold">Pilih Data MoM Week 2</span>
                                        </div>
                                        <div class="table-responsive rounded border shadow-sm bg-white">
                                            <table class="table table-hover align-middle mb-0" id="dt_mom"
                                                style="width:100%">
                                                <thead class="table-light">
                                                    <tr style="font-size: 12px;">
                                                        <th width="40"></th>
                                                        <th>No MoM</th>
                                                        <th width="170px">Judul</th>
                                                        <th>Meeting</th>
                                                        <th>Department</th>
                                                        <th>Peserta</th>
                                                        <th>Agenda</th>
                                                        <th>Pembahasan</th>
                                                        <th>Tempat</th>
                                                        <th>Tanggal</th>
                                                        <th>Waktu</th>
                                                        <th>List Peserta</th>
                                                        <th>Created By</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item mb-3 border-0 shadow-sm">
                                <h2 class="accordion-header">
                                    <button class="accordion-button bg-white collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseWeek3">
                                        <div class="form-check">
                                            <input class="form-check-input week-check" type="checkbox">
                                            <label class="form-check-label fw-bold">Input Data MoM Week 3</label>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapseWeek3" class="accordion-collapse collapse">
                                    <div class="accordion-body bg-white pt-0">
                                        <div class="table-responsive rounded border shadow-sm">
                                            <table class="table table-hover align-middle mb-0" id="dt_mom_3"
                                                style="width:100%">
                                                <thead class="table-light">
                                                    <tr style="font-size: 12px;">
                                                        <th width="40"></th>
                                                        <th>No MoM</th>
                                                        <th>Judul</th>
                                                        <th>...</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item mb-3 border-0 shadow-sm">
                                <h2 class="accordion-header">
                                    <button class="accordion-button bg-white collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseWeek4">
                                        <div class="form-check">
                                            <input class="form-check-input week-check" type="checkbox">
                                            <label class="form-check-label fw-bold">Input Data MoM Week 4</label>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapseWeek4" class="accordion-collapse collapse">
                                    <div class="accordion-body bg-white pt-0">
                                        <div class="table-responsive rounded border shadow-sm">
                                            <table class="table table-hover align-middle mb-0" id="dt_mom_4"
                                                style="width:100%">
                                                <thead class="table-light">
                                                    <tr style="font-size: 12px;">
                                                        <th width="40"></th>
                                                        <th>No MoM</th>
                                                        <th>Judul</th>
                                                        <th>...</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div id="genba-content" class="section-item" style="display: none;">
                            <h5 class="mb-3 text-success"><i class="bi bi-eye me-2"></i>Data Genba Report</h5>

                            <div class="accordion" id="accordionGenba">
                                <div class="accordion-item mb-3 border-0 shadow-sm">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button bg-white" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#genbaW1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox">
                                                <label class="form-check-label fw-bold">Input Data Genba Week 1</label>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="genbaCollapse1" class="accordion-collapse collapse show">
                                        <div class="accordion-body bg-white pt-0">
                                            <div class="p-3 border rounded bg-light">Belum ada data Genba.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>



                        <div class="event-footer">
                            <div class="d-flex align-items-center">
                                <div class="progress progress-w me-3">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar" style="width: 60%"></div>
                                </div>
                                <span class="small fw-bold text-muted">60% Total Progress</span>
                            </div>
                            <div>
                                <button type="button" class="btn btn-light btn-sm px-3 me-2 border text-muted">Reset
                                    Form</button>
                                <button type="button" class="btn btn-primary btn-sm px-4 fw-bold shadow-sm">Simpan
                                    Data</button>
                            </div>
                        </div>
                    </div>
    </main>
    <script>
        function switchContent(targetId, element) {
            // 1. Sembunyikan SEMUA section terlebih dahulu
            const sections = document.querySelectorAll('.section-item');
            sections.forEach(s => {
                s.style.display = 'none';
            });

            // 2. Tampilkan section yang dituju
            const target = document.getElementById(targetId);
            if (target) {
                target.style.display = 'block';
            }

            // 3. Update style tombol di sidebar
            const links = document.querySelectorAll('.nav-link');
            links.forEach(l => {
                l.classList.remove('active');
                // Reset icon ke circle kosong
                const icon = l.querySelector('i');
                if (icon) {
                    icon.className = 'bi bi-circle text-muted';
                    icon.style.opacity = '0.3';
                }
            });

            // 4. Highlight tombol yang baru diklik
            element.classList.add('active');
            const activeIcon = element.querySelector('i');
            if (activeIcon) {
                activeIcon.className = 'bi bi-record-circle text-primary';
                activeIcon.style.opacity = '1';
            }
        }
    </script>