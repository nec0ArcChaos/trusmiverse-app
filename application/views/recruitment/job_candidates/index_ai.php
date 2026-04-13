<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <!-- <p class="text-secondary">Perintah Kerja di Hari Libur</p> -->
            </div>
            <div class="col col-sm-auto">
                <div class="input-group input-group-md reportrange">
                    <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;">
                    <input type="hidden" name="startdate" value="" id="start" />
                    <input type="hidden" name="enddate" value="" id="end" />
                    <span class="input-group-text text-secondary bg-none" id="btn_filter"><i
                            class="bi bi-calendar-event"></i></span>
                </div>
            </div>
            <div class="col-auto ps-0">
                <?php
                if (isset($job_id)) { ?>
                    <input type="hidden" value="<?= $job_id ?>" id="jc_job_id">
                <?php
                }
                ?>
            </div>
        </div>
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle; ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="row g-4">
                <!-- Formula Card -->
                <div class="col-lg-12">
                    <div class="card border-0 h-100 shadow-hover">
                        <div class="card-header bg-gradient-info text-white">
                            <h5 class="mb-0"><i class="fas fa-calculator me-2"></i> Scoring Formula</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="alert border-info border-opacity-25 bg-light-blue">
                                        <h6 class="d-flex align-items-center text-dark">
                                            <i class="fas fa-user-tie me-2 mb-1" style="font-size: 10pt;"></i> Profile
                                            Matching Score
                                        </h6>
                                        <div class="formula-box bg-white rounded-2 p-2 mb-2">
                                            <small class="text-muted d-block">Formula:</small>
                                            <code class="text-dark font-weight-bold"
                                                style="white-space: break-spaces;text-align: justify;">weighted average of criteria Usia (5%), Status (menikah/belum) (3%), Gender (2%), Pendidikan (10%), Pengalaman Kerja (20%), Sertifikasi / Pelatihan (2%), Portofolio/Proyek (3%)</code>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="alert border-warning border-opacity-25 bg-light-yellow">
                                        <h6 class="d-flex align-items-center text-dark">
                                            <i class="fas fa-tools me-2 mb-1" style="font-size: 10pt;"></i> Skills
                                            Matching Score
                                        </h6>
                                        <div class="formula-box bg-white rounded-2 p-2 mb-2">
                                            <small class="text-muted d-block">Formula:</small>
                                            <code class="text-dark font-weight-bold"
                                                style="white-space: break-spaces;">weighted average of criteria Soft Skills (10%), Keahlian Utama (Hard Skills) (25%), Kesesuaian Job Desc (20%)</code>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="alert border-light border-opacity-25 bg-light-green">
                                        <h6 class="d-flex align-items-center text-dark">
                                            <i class="fas fa-star me-2 mb-1" style="font-size: 10pt;"></i> Total
                                            Matching Score
                                        </h6>
                                        <div class="formula-box bg-white rounded-2 p-2 mb-2">
                                            <small class="text-muted d-block">Formula:</small>
                                            <code class="text-dark font-weight-bold"
                                                style="white-space: break-spaces;">sum of (score × weight / 100) across all criteria</code>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                /* Custom Styles */
                .card {
                    border-radius: 0.75rem;
                    transition: all 0.3s ease;
                }

                .shadow-hover:hover {
                    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
                }

                .hover-shadow-sm:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
                }

                .bg-gradient-primary {
                    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
                }

                .bg-gradient-info {
                    background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
                }

                .icon-circle {
                    width: 36px;
                    height: 36px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .bg-primary-light {
                    background-color: rgba(78, 115, 223, 0.1);
                }

                .formula-card {
                    border-left: 3px solid;
                    transition: all 0.3s ease;
                }

                .formula-card:hover {
                    transform: translateX(5px);
                }

                .formula-card:nth-child(2) {
                    border-left-color: #4e73df;
                }

                .formula-card:nth-child(3) {
                    border-left-color: #f6c23e;
                }

                .formula-card:nth-child(4) {
                    border-left-color: #1cc88a;
                }

                .table-align-middle td {
                    vertical-align: middle;
                }
            </style>
            <div class="card border-0 mt-2">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-person-workspace h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List <?= $pageTitle ?></h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dt_jc" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Status</th>
                                    <th>Cover Letter</th>
                                    <th>Status Score</th>
                                    <th>Total Score</th>
                                    <th>Profile Score</th>
                                    <th>Skill Score</th>
                                    <th>Simulation Score</th>
                                    <th>Simulation Grade</th>
                                    <th>Company</th>
                                    <th>Job Category</th>
                                    <th>Job Title</th>
                                    <th>Role</th>
                                    <th>Candidate Name</th>
                                    <th>Gender</th>
                                    <th>No Telp</th>
                                    <th>Email</th>
                                    <th>Usia</th>
                                    <th>Domisili</th>
                                    <th>Edu</th>
                                    <th>Jurusan</th>
                                    <th>Tempat Pendidikan</th>
                                    <th>Kerja Terakhir</th>
                                    <th>Tempat Kerja</th>
                                    <th>Masa Kerja</th>
                                    <th>Gaji Diharapkan</th>
                                    <th>Informasi</th>
                                    <th>Bersedia</th>
                                    <th>TIU</th>
                                    <th>DISC</th>
                                    <th>Most D</th>
                                    <th>Most I</th>
                                    <th>Most S</th>
                                    <th>Most C</th>
                                    <th>Least D</th>
                                    <th>Least I</th>
                                    <th>Least S</th>
                                    <th>Least C</th>
                                    <th>Change D</th>
                                    <th>Change I</th>
                                    <th>Change S</th>
                                    <th>Change C</th>
                                    <th>MBTI</th>
                                    <th>Ekstrovert (%)</th>
                                    <th>Introvert (%)</th>
                                    <th>Sensing (%)</th>
                                    <th>Intuition (%)</th>
                                    <th>Thinking (%)</th>
                                    <th>Feeling (%)</th>
                                    <th>Perceiving (%)</th>
                                    <th>Judging (%)</th>
                                    <th>CFIT</th>
                                    <th>Apply Date</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>

    <!-- Floating avatar & panel -->
    <div class="floating" aria-hidden="false">
        <div id="bubble" class="bubble text-dark" role="status" aria-live="polite">
            <h3 id="bubbleTypewriter"></h3>
            <p id="bubbleTypewriterP"></p>
        </div>

        <div class="avatar-btn" id="avatarBtn" title="Ella Screener — open panel" aria-label="Open Ella panel">
            <!-- simple avatar svg -->
            <img src="https://openstream.ai/hubfs/Customer-Service.png" alt="Ella avatar" />
        </div>
    </div>

    <div class="panel" id="panel" role="dialog" aria-label="Ella panel">
        <div class="header ms-1">
            <div
                style="width:44px;height:44px;border-radius:10px;background:aliceblue;display:flex;align-items:center;justify-content:center;color:#061226;font-weight:700">
                ES</div>
            <div>
                <h5 class="mb-0">Ella is on duty</h5>
                <div class="meta">Status - Active</div>
            </div>
        </div>

        <div class="items">
            <div class="item">
                <div style="display:flex;justify-content:space-between;align-items:center">
                    <div><strong>Candidates screened today</strong>
                        <div class="muted" style="font-size:12px">Results updated in real-time</div>
                    </div>
                    <div style="text-align:right"><strong id="countScreened">20</strong>
                        <div class="muted" style="font-size:12px" id="lastScan">since 07:00</div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="m-0">
        <div class="items">
            <div class="item pb-0 pt-0">
                <div style="display:flex;justify-content:space-between;align-items:center">
                    <div><strong>Top Candidates</strong></div>
                </div>
            </div>
        </div>

        <div class="items" id="panelItems">
            <!-- JS will populate items -->
        </div>
    </div>
</main>
<!-- Modal Cover Letter -->
<div class="modal" id="modal_cover_letter" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cover_leter_title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class=" modal-footer">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal_akses_test" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Akses Test</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="update_akses_test">
                <div class="modal-body">
                    <input type="hidden" name="id_user" value="" id="id_user_talent">
                    <input type="hidden" name="email" value="" id="email_talent">
                    <p>Pilih tes yang akan diakses oleh Candidat:</p>
                    <?php foreach ($assessment as $item): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="<?= $item->id ?>"
                                id="test<?= $item->id ?>" name="access[]">
                            <label class="form-check-label" for="test<?= $item->id ?>">
                                <?= $item->nama_test ?>
                            </label>
                        </div>
                    <?php endforeach; ?>

                </div>
                <div class=" modal-footer">
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary me-2">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Edit Status -->
<div class="modal" id="modal_edit_status" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="cover_leter_title">Edit Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Candidate Summary -->
                <div class="d-flex align-items-center gap-3 mb-4 p-3 bg-light rounded-3">
                    <div class="flex-shrink-0">
                        <div class="avatar avatar-lg bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                            id="candidate_avatar">
                            <i class="fas fa-user fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1" id="candidate_name">Nama Kandidat</h5>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="py-2 px-2 badge bg-secondary" id="candidate_id">ID: KAN2023-001</span>
                            <span class="py-2 px-2 badge bg-info text-dark" id="candidate_position">Posisi: Backend
                                Developer</span>
                            <span class="py-2 px-2 badge bg-light text-dark border" id="candidate_date">Tanggal: 13 Aug
                                2023</span>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="button" id="btn_re_scan_candidate"><i
                            class="fas fa-redo me-2"></i> Re-scan</button>
                </div>

                <p class="mt-4 py-2 px-2" id="candidate_reason" style="text-align: justify;">Reason: Pending Review</p>

                <!-- Scores Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="mb-0 fw-bold"><i class="fas fa-chart-bar text-primary me-2"></i>Application
                            Scores</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="p-3 bg-warning bg-opacity-10 rounded-3 text-center"
                                    id="div_candidate_score">
                                    <div class="score-circle mx-auto bg-warning text-white mb-2" id="candidate_score">
                                        82%</div>
                                    <h6 class="mb-1 fw-bold">Overall Score</h6>
                                    <small class="text-muted">Total Nilai</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-success bg-opacity-10 rounded-3 text-center"
                                    id="div_candidate_profile">
                                    <div class="score-circle mx-auto bg-success text-white mb-2" id="candidate_profile">
                                        85%</div>
                                    <h6 class="mb-1 fw-bold">Profile Match</h6>
                                    <small class="text-muted">Kesesuaian Profil</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-info bg-opacity-10 rounded-3 text-center" id="div_candidate_skill">
                                    <div class="score-circle mx-auto bg-info text-white mb-2" id="candidate_skill">78%
                                    </div>
                                    <h6 class="mb-1 fw-bold">Skills Match</h6>
                                    <small class="text-muted">Kesesuaian Skill</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- radar chart -->
                <div class="row mb-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0 fw-bold"><i class="fas fa-chart-polar-area text-primary me-2"></i>CV
                                    Score</h6>
                            </div>
                            <div class="card-body">
                                <div id="chart_cv_score" style="min-height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0 fw-bold"><i class="fas fa-chart-pie text-primary me-2"></i>Simulation
                                    Score</h6>
                            </div>
                            <div class="card-body">
                                <div id="chart_simulation_score" style="min-height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Profile Matches -->
                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="card h-100 border-success border-opacity-25">
                            <div class="card-header bg-success bg-opacity-10 border-success border-opacity-25">
                                <h6 class="mb-0 fw-bold"><i class="fas fa-check-circle text-success me-2"></i>Matched
                                    Profile Items</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush" id="matchedProfileItems">
                                    <li class="list-group-item d-flex align-items-center border-0 py-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Usia sesuai
                                    </li>
                                    <li class="list-group-item d-flex align-items-center border-0 py-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Pendidikan minimal S1
                                    </li>
                                    <li class="list-group-item d-flex align-items-center border-0 py-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Pengalaman > 3 tahun
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border-danger border-opacity-25">
                            <div class="card-header bg-danger bg-opacity-10 border-danger border-opacity-25">
                                <h6 class="mb-0 fw-bold"><i class="fas fa-times-circle text-danger me-2"></i>Missing
                                    Profile Items</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush" id="missingProfileItems">
                                    <li class="list-group-item d-flex align-items-center border-0 py-2">
                                        <i class="fas fa-times-circle text-danger me-2"></i>
                                        Sertifikasi tertentu
                                    </li>
                                    <li class="list-group-item d-flex align-items-center border-0 py-2">
                                        <i class="fas fa-times-circle text-danger me-2"></i>
                                        Kemampuan bahasa Inggris fluent
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Skills Matches -->
                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="card h-100 border-success border-opacity-25">
                            <div class="card-header bg-success bg-opacity-10 border-success border-opacity-25">
                                <h6 class="mb-0 fw-bold"><i class="fas fa-check-circle text-success me-2"></i>Matched
                                    Skills</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush" id="matchedSkillsItems">
                                    <li class="list-group-item d-flex align-items-center border-0 py-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Laravel
                                    </li>
                                    <li class="list-group-item d-flex align-items-center border-0 py-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        MySQL
                                    </li>
                                    <li class="list-group-item d-flex align-items-center border-0 py-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        API Development
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border-danger border-opacity-25">
                            <div class="card-header bg-danger bg-opacity-10 border-danger border-opacity-25">
                                <h6 class="mb-0 fw-bold"><i class="fas fa-times-circle text-danger me-2"></i>Missing
                                    Skills</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush" id="missingSkillsItems">
                                    <li class="list-group-item d-flex align-items-center border-0 py-2">
                                        <i class="fas fa-times-circle text-danger me-2"></i>
                                        Docker
                                    </li>
                                    <li class="list-group-item d-flex align-items-center border-0 py-2">
                                        <i class="fas fa-times-circle text-danger me-2"></i>
                                        Kubernetes
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scoring Details -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="mb-0 fw-bold"><i class="fas fa-file-alt text-primary me-2"></i>Scoring Details
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Category</th>
                                        <th class="ps-4">Kriteria</th>
                                        <th class="text-center">Bobot</th>
                                        <th class="text-center">Nilai</th>
                                        <th class="pe-4 text-center">Skor (%)</th>
                                        <th class="pe-4 text-center">Reason</th>
                                    </tr>
                                </thead>
                                <tbody id="scoringDetails">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="job_id" readonly>
                <div class="row mt-3">
                    <div class="col"></div>
                    <div class="col-6">
                        <div class="card shadow-sm py-2 px-4">
                            <div class="card-body p-0">
                                <label class="form-label required small" for="select_status">Status</label>
                                <div class="input-group mb-3">
                                    <select id="select_status" class="w-100" onchange="updateKeterangan()"
                                        style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;width:100% !important;">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" id="alasan" style="display: none;">
                        <label class="form-label required small" for="select_alasan">Alasan</label>
                        <div class="input-group mb-3">
                            <select id="select_alasan" class="form-control"
                                style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;width:1000px;">
                                <option value="" selected disabled>- Alasan -</option>
                                <?php foreach ($alasan as $key => $value) { ?>
                                    <option value="<?= $value->id; ?>"><?= $value->reason; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>
                </div>
            </div>
            <div class=" modal-footer">
                <button type="button" class="btn btn-primary me-2" onclick="save_status()"
                    id="btn_save_status">Simpan</button>
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Kandidat -->
<div class="modal fade" id="detailModalScreener" tabindex="-1" aria-labelledby="detailModalScreenerLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white rounded-top-3">
                <div class="w-100 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="modal-title fw-bold" id="detailModalScreenerLabel">Detail Penilaian Kandidat</h5>
                        <p class="mb-0 small opacity-75">Review lengkap hasil penilaian kandidat</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body p-4">

            </div>
            <div class="modal-footer bg-light rounded-bottom-3">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>