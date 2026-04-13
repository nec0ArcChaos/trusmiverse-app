<main class="main mainheight">
    <div class="container-fluid mb-4 fade-in-up pb-5">

        <!-- Top Tabs -->
        <div class="top-nav-tabs mt-2 mb-4 mx-auto" style="max-width: 600px;">
            <ul class="nav nav-pills d-flex bg-light rounded-3 p-1 border border-light-subtle m-0" id="adsosTab"
                role="tablist">
                <li class="nav-item flex-fill text-center" role="presentation">
                    <button class="nav-link active w-100 rounded-3 py-2 border-0 fw-semibold" id="admin-sosmed-tab"
                        data-bs-toggle="pill" data-bs-target="#admin-sosmed" type="button" role="tab" data-type="admin_sosial_media"
                        aria-controls="admin-sosmed" aria-selected="true" onclick="reinitiate_data()">Admin Sosial Media</button>
                </li>
                <li class="nav-item flex-fill text-center" role="presentation">
                    <button class="nav-link w-100 rounded-3 py-2 fw-semibold border-0" id="engage-tab"
                        data-bs-toggle="pill" data-bs-target="#engage" type="button" role="tab" data-type="engage_instagram"
                        aria-controls="engage" aria-selected="false" onclick="reinitiate_data()">Engage Instagram</button>
                </li>
            </ul>
        </div>

        <!-- Header Section -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4">
            <div class="ms-2 mb-3 mb-md-0">
                <h2 class="fw-bold fs-3 mb-1 text-dark">Selamat datang kembali,
                    <?= $this->session->userdata('nama') ?: 'Olivia' ?>
                </h2>
                <p class="text-muted mb-0">Pantau ringkasan dan capaian target harian Admin Sosial Media kamu di
                    sini.</p>
            </div>
            <div class="d-flex gap-2">
                <select name="company_id" id="company_id"
                    class="form-select rounded-3 px-3 d-flex align-items-center gap-2 bg-white fw-semibold shadow-none border border-light-subtle">
                    <?php foreach ($account as $key => $value): ?>
                        <option value="<?= $value->company_id; ?>" data-owner_id='<?= $value->owner_id; ?>' data-account_id='<?= $value->account_id; ?>'>
                            <?= $value->account_name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="input-group input-group-md px-3 rounded-3 bg-white fw-semibold shadow-none border-light-subtle reportrange"
                    style="border: solid 0.5px #dfe0e1;">
                    <input type="text" class="form-control range bg-none px-0 fw-semibold" style="cursor: pointer;"
                        id="rangeCalendar">
                    <input type="hidden" name="start_date" value="<?= date('Y-m-d'); ?>" id="start_date">
                    <input type="hidden" name="end_date" value="<?= date('Y-m-d'); ?>" id="end_date">
                    <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i
                            class="bi bi-calendar-event"></i></span>
                </div>
            </div>
        </div>


        <div class="tab-content" id="adsosTabContent">
            <!-- ADMIN SOSIAL MEDIA TAB -->
            <div class="tab-pane fade show active" id="admin-sosmed" role="tabpanel" aria-labelledby="admin-sosmed-tab"
                tabindex="0">

                <!-- Hero Banner -->
                <div class="hero-banner card rounded-3 mb-4 overflow-hidden position-relative shadow-none border-light-subtle">
                    <div class="hero-bg-gradient position-absolute w-100 h-100 top-0 start-0"></div>
                    <div class="card-body p-4 position-relative z-1 d-flex justify-content-between align-items-center">
                        <div class="row col-12">
                            <div class="col-auto">
                                <div class="d-flex justify-content-center align-items-center h-100 position-relative" style="width: 130px; height: 130px;">
                                    <div id="profile_picture_skeleton" class="skeleton-text rounded-circle w-100 h-100 position-absolute top-0 start-0" style="z-index: 2;"></div>
                                    <a href="#" target="_blank" id="profile_link_banner">
                                        <img src="" class="img-fluid rounded-circle border shadow-sm d-opacity-0" alt="Profile" style="width: 130px; height: 130px; object-fit: cover;" id="profile_picture_banner">
                                    </a>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="row mb-2 mt-2">
                                    <div class="col-auto">
                                        <h6 class="mb-0 fw-bold" id="profile_name_banner">
                                            <div class="skeleton-text" style="width: 150px; height: 20px;"></div>
                                        </h6>
                                        <p class="text-muted fw-semibold mb-0" id="profile_username_banner">
                                        <div class="skeleton-text" style="width: 100px; height: 16px;"></div>
                                        </p>
                                    </div>
                                </div>
                                <div class="row" id="resume-container">
                                    <div class="col">
                                        <div class="rounded-3 shadow-none border-end">
                                            <div class="rounded-3">
                                                <div class="d-flex flex-column justify-content-between gap-2 text-wrap">
                                                    <div>
                                                        <strong style="font-size: 14px !important">Total Konten</strong><br>
                                                    </div>
                                                    <div>
                                                        <strong style="font-size: 20px !important" id="total_konten">
                                                            <div class="skeleton-text" style="width: 40px; height: 24px;"></div>
                                                        </strong>
                                                        <div id="totalKontenDiffContainer" class="d-inline">
                                                            <span style="font-size: 9px; font-weight: bold;" class="progress-text" id="totalKontenDiff"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="rounded-3 shadow-none border-end">
                                            <div class="rounded-3">
                                                <div class="d-flex flex-column justify-content-between gap-2 text-wrap">
                                                    <div>
                                                        <strong style="font-size: 14px !important">Total Views</strong><br>
                                                    </div>
                                                    <div>
                                                        <strong style="font-size: 20px !important" id="total_views">
                                                            <div class="skeleton-text" style="width: 60px; height: 24px;"></div>
                                                        </strong>
                                                        <div id="totalViewsDiffContainer" class="d-inline">
                                                            <span style="font-size: 9px; font-weight: bold;" class="progress-text" id="totalViewsDiff"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="rounded-3 shadow-none border-end">
                                            <div class="rounded-3">
                                                <div class="d-flex flex-column justify-content-between gap-2 text-wrap">
                                                    <div>
                                                        <strong style="font-size: 14px !important">Followers</strong><br>
                                                    </div>
                                                    <div>
                                                        <strong style="font-size: 20px !important" id="total_followers">
                                                            <div class="skeleton-text" style="width: 60px; height: 24px;"></div>
                                                        </strong>
                                                        <div id="totalFollowersDiffContainer" class="d-inline">
                                                            <span style="font-size: 9px; font-weight: bold;" class="progress-text" id="totalFollowersDiff"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="fw-bold mb-1 fs-6 text-dark mt-2">Total Capaian Aktifitas Harian</h6>
                                <p class="text-muted mb-2 small" id="total_capaian_desc">
                                <div class="skeleton-text" style="width: 80%; height: 14px;"></div>
                                </p>
                                <h1 class="display-5 fw-bold text-primary mb-0" id="total_capaian_pct" style="font-weight: 800 !important;">
                                    <div class="skeleton-text" style="width: 60px; height: 40px;"></div>
                                </h1>
                                <!-- Optional illustration area -->
                            </div>
                            <div class="col-auto">
                                <div class="hero-illustration d-none d-md-block pe-4 position-relative">
                                    <div class="d-flex align-items-center justify-content-center"
                                        style="width: 120px; height: 100px;">
                                        <!-- Using an icon stack to simulate the girl illustration if no image is provided -->
                                        <i class="bi bi-person-workspace text-primary"
                                            style="font-size: 5rem; opacity: 0.8;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Metric Cards -->
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-3 mb-4 animation-delay-1" id="admin-sosmed-metrics-container">
                    <!-- Skeletons will be displayed here while loading -->
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <div class="col skeleton-card">
                            <div class="card h-100 border border-light-subtle rounded-3 shadow-none metric-card bg-white p-3 placeholder-glow">
                                <div class="icon-square rounded-circle mb-3 placeholder col-3" style="width:44px;height:44px; opacity: 0.5;"></div>
                                <h6 class="placeholder col-8 mb-1 rounded"></h6>
                                <p class="placeholder col-6 small mb-3 rounded" style="opacity: 0.5;"></p>
                                <div class="mt-auto">
                                    <span class="placeholder col-6 mb-2 d-block rounded" style="opacity: 0.5;"></span>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-secondary border-0 rounded-3 placeholder" style="width: 100%; opacity: 0.2;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>

                <!-- Table Section -->
                <div class="card border-light-subtle rounded-3 shadow-none animation-delay-2 p-3 p-md-4 bg-white mb-5">
                    <div
                        class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                        <div>
                            <h5 class="fw-bold mb-1 text-dark fs-5">Table List Inputan Admin Harian by Kategori</h5>
                            <p class="text-muted mb-0 small">Pantau pencapaian target harian dan validasi tautan.</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button id="btn-add-adsos" class="btn btn-primary rounded-pill px-3 py-1 small shadow-sm d-flex align-items-center gap-2" style="font-size: 0.75rem;">
                                <i class="bi bi-plus-lg"></i> Tambah Data
                            </button>
                        </div>
                    </div>

                    <div
                        class="d-flex flex-column flex-xl-row justify-content-between align-items-xl-center mb-4 gap-3">
                        <!-- Table Tabs -->
                        <div class="d-flex gap-2 flex-wrap table-nav-tabs">
                            <!-- Tabs will be rendered here dynamically -->
                        </div>

                        <div class="d-flex gap-2 align-items-center flex-sm-row flex-column w-sm-100 bg-white fw-semibold shadow-none border-light-subtle">
                            <div class="input-group">
                                <div class="input-group-prepend d-flex align-items-center me-3 ms-3">
                                    <i class="bi bi-search text-muted"></i>
                                </div>
                                <input type="text" id="adsos_search" class="py-2 form-control rounded-3 bg-light border-light-subtle"
                                    placeholder="Cari data..." style="min-width: 220px;">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle custom-table mb-0" id="table-adsos">
                            <thead class="text-muted small">
                                <tr>
                                    <th class="border-0 fw-semibold pb-3 text-center">Tanggal</th>
                                    <th class="border-0 fw-semibold pb-3 text-center">Created By</th>
                                    <th class="border-0 fw-semibold pb-3 text-center">Category</th>
                                    <th class="border-0 fw-semibold pb-3">Nama Akun</th>
                                    <th class="border-0 fw-semibold pb-3">Link Profile</th>
                                    <th class="border-0 fw-semibold pb-3">DM</th>
                                    <th class="border-0 pb-3 text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                <!-- Rows will be rendered here dynamically -->
                            </tbody>
                        </table>
                    </div>

                </div>

            </div> <!-- End Tab Admin -->

            <!-- ENGAGE INSTAGRAM TAB -->
            <div class="tab-pane fade" id="engage" role="tabpanel" aria-labelledby="engage-tab" tabindex="0">
                <!-- Top Metric Cards -->
                <div class="row row-cols-1 row-cols-md-3 g-3 mb-4 animation-delay-1" id="engage-top-metrics-container">
                    <!-- Skeletons will be displayed here while loading -->
                    <?php for ($i = 0; $i < 3; $i++): ?>
                        <div class="col skeleton-card">
                            <div class="card h-100 border border-light-subtle rounded-3 shadow-none metric-card bg-white p-3 placeholder-glow">
                                <div class="icon-square rounded-circle mb-3 placeholder col-3" style="width:44px;height:44px; opacity: 0.5;"></div>
                                <h6 class="placeholder col-4 mb-1 rounded"></h6>
                                <div class="mt-auto">
                                    <span class="placeholder col-6 mb-2 d-block rounded" style="opacity: 0.5;"></span>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-secondary border-0 rounded-3 placeholder" style="width: 100%; opacity: 0.2;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>

                <!-- Hero Banner -->
                <div
                    class="hero-banner card rounded-3 mb-4 overflow-hidden position-relative shadow-none border-light-subtle animation-delay-1">
                    <div class="hero-bg-gradient position-absolute w-100 h-100 top-0 start-0"></div>
                    <div class="card-body p-4 position-relative z-1 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold mb-1 fs-6 text-dark">Total Capaian Aktifitas Harian</h6>
                            <p class="text-muted mb-2 small" id="total_capaian_engage_desc">
                            <div class="skeleton-text" style="width: 80%; height: 14px;"></div>
                            </p>
                            <h1 class="display-5 fw-bold text-primary mb-0" id="total_capaian_engage_pct" style="font-weight: 800 !important;">
                                <div class="skeleton-text" style="width: 60px; height: 40px;"></div>
                            </h1>
                        </div>
                        <div class="hero-illustration d-none d-md-block pe-4 position-relative">
                            <div class="d-flex align-items-center justify-content-center"
                                style="width: 120px; height: 100px;">
                                <i class="bi bi-person-workspace text-primary"
                                    style="font-size: 5rem; opacity: 0.8;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 5 Metrics Card -->
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-3 mb-4 animation-delay-2" id="engage-activities-container">
                    <!-- Skeletons will be displayed here while loading -->
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <div class="col skeleton-card">
                            <div class="card h-100 border border-light-subtle rounded-3 shadow-none metric-card bg-white p-3 placeholder-glow">
                                <div class="icon-square rounded-circle mb-3 placeholder col-3" style="width:44px;height:44px; opacity: 0.5;"></div>
                                <h6 class="placeholder col-4 mb-1 rounded"></h6>
                                <div class="mt-auto">
                                    <span class="placeholder col-6 mb-2 d-block rounded" style="opacity: 0.5;"></span>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-secondary border-0 rounded-3 placeholder" style="width: 100%; opacity: 0.2;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>

                <!-- Timeline Activity Section -->
                <div class="card border-0 rounded-4 shadow-sm animation-delay-2 bg-white mb-5">
                    <div class="card-body p-4">
                        <!-- Timeline Header -->
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="dropdown">
                                    <button class="btn btn-transparent p-0 d-flex align-items-center gap-2 border-0 shadow-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <h3 class="fw-bold mb-0 text-dark" id="display_month_year">Oktober 2026</h3>
                                        <i class="bi bi-chevron-down text-muted fs-5"></i>
                                    </button>
                                    <ul class="dropdown-menu border-0 shadow-lg rounded-4 p-2 overflow-auto" style="max-height: 300px; min-width: 200px;" id="month_dropdown_menu">
                                        <!-- Will be populated by JS -->
                                    </ul>
                                </div>
                                <div class="btn-group bg-light p-1 rounded-pill" role="group" id="timeline_view_toggle">
                                    <button type="button" class="btn btn-sm btn-white shadow-sm rounded-pill px-3 border-0 fw-bold text-primary" data-view="week">Minggu</button>
                                    <button type="button" class="btn btn-sm btn-transparent rounded-pill px-3 border-0 fw-semibold text-muted" data-view="month">Bulan</button>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-light text-dark rounded-circle p-2 d-flex align-items-center justify-content-center border-light-subtle prev-date-nav" style="width: 32px; height: 32px;">
                                    <i class="bi bi-chevron-left" style="font-size: 0.8rem;"></i>
                                </button>
                                <button class="btn btn-outline-light text-dark rounded-circle p-2 d-flex align-items-center justify-content-center border-light-subtle next-date-nav" style="width: 32px; height: 32px;">
                                    <i class="bi bi-chevron-right" style="font-size: 0.8rem;"></i>
                                </button>
                                <button id="btn-add-engage" class="btn btn-primary text-white rounded-lg p-2 d-flex align-items-center justify-content-center border-light-subtle" style="width: 32px; height: 32px;">
                                    <i class="bi bi-plus fs-5" style="font-size: 0.8rem;"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Date Cards Horizontal Scroll -->
                        <div class="d-flex gap-3 overflow-auto pb-3 mb-4 hide-scrollbar" id="timeline_date_cards">
                            <!-- Populated dynamically by adsos_js.php -->
                        </div>

                        <!-- Team Selection -->
                        <div class="d-flex align-items-center gap-3 mb-4 pb-2 border-bottom border-light-subtle">
                            <span class="text-muted fw-bold small text-uppercase" style="letter-spacing: 1px; font-size: 0.65rem;">Tim :</span>
                            <div class="d-flex gap-2 overflow-auto hide-scrollbar py-1">
                                <button class="btn btn-primary rounded-pill px-4 py-1 small fw-bold shadow-sm team-filter active" data-user-id="all" style="font-size: 0.75rem;">Semua Tim</button>
                                <?php
                                $colors = ['#0d6efd', '#198754', '#dc3545', '#ffc107', '#0dcaf0', '#6610f2', '#fd7e14'];
                                foreach ($team as $index => $t) :
                                    $color = $colors[$index % count($colors)];
                                ?>
                                    <button class="btn btn-outline-light text-dark bg-white rounded-pill px-3 py-1 small shadow-sm-hover team-filter"
                                        data-user-id="<?= $t->user_id ?>"
                                        style="font-size: 0.75rem; border: 1px solid #e9ecef;">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                                style="width: 18px; height: 18px; font-size: 0.55rem; background-color: <?= $color ?>;">
                                                <?= $t->initial ?>
                                            </div>
                                            <?= $t->name ?>
                                        </div>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Timeline Schedule Grid -->
                        <div class="timeline-grid rounded-4 border border-light-subtle overflow-hidden">
                            <div class="timeline-header d-flex bg-light border-bottom border-light-subtle">
                                <div class="time-col p-3 text-center border-end border-light-subtle bg-light" style="width: 100px;">
                                    <span class="small fw-bold text-muted text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px;">Waktu</span>
                                </div>
                                <div class="activity-col p-3 ps-4 flex-grow-1 bg-light">
                                    <span class="small fw-bold text-muted text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px;">Detail Aktivitas Tim</span>
                                </div>
                            </div>

                            <div class="timeline-body" id="timeline_content_body">
                                <!-- Populated dynamically by adsos_js.php -->
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- End Tab Engage IG -->
        </div>

    </div>
</main>

<!-- Delete Confirmation Modal Adsos -->
<div class="modal fade" id="modal-delete-adsos" tabindex="-1" aria-labelledby="modalDeleteAdsosLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white border-0 py-3">
                <h5 class="modal-title fw-bold" id="modalDeleteAdsosLabel"><i class="bi bi-exclamation-triangle me-2"></i> Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-danger-subtle p-3 rounded-circle text-danger fs-1">
                        <i class="bi bi-trash3-fill"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold fs-5 mb-1 text-dark">Hapus Data Ini?</h6>
                        <p class="text-muted mb-0">Data yang dihapus tidak dapat dikembalikan. Yakin ingin melanjutkan?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0 pb-4 px-4 bg-light rounded-bottom">
                <button type="button" class="btn btn-light border border-secondary-subtle px-4 fw-medium text-dark bg-white shadow-none" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btn-confirm-delete-adsos" class="btn btn-danger px-4 fw-medium shadow-none d-flex align-items-center gap-2">
                    <i class="bi bi-trash"></i> Hapus Data
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add/Edit Adsos -->
<div class="modal fade" id="modal-form-adsos" tabindex="-1" aria-labelledby="modalFormAdsosLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white border-0 py-3">
                <h5 class="modal-title fw-bold" id="modalFormAdsosLabel">Tambah Data Adsos</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-adsos">
                <div class="modal-body py-4 px-4">
                    <input type="hidden" id="adsos_id" name="adsos_id">

                    <div class="mb-3">
                        <label for="adsos_category" class="form-label fw-semibold text-dark">Kategori</label>
                        <select class="form-select border border-secondary-subtle bg-light shadow-none" id="adsos_category" name="adsos_category" required>
                            <!-- Options rendered via JS -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="adsos_date" class="form-label fw-semibold text-dark">Tanggal Selesai</label>
                        <input type="datetime-local" class="form-control border border-secondary-subtle bg-light shadow-none" id="adsos_date" name="adsos_date" required>
                    </div>

                    <div class="mb-3">
                        <label for="adsos_account_name" class="form-label fw-semibold text-dark">Nama Akun</label>
                        <input type="hidden" class="form-control border border-secondary-subtle bg-light shadow-none" id="adsos_account_id" name="adsos_account_id" placeholder="Masukkan ID Akun" required>
                        <input type="text" class="form-control border border-secondary-subtle bg-light shadow-none" id="adsos_account_name" name="adsos_account_name" placeholder="Masukkan Nama Akun" required readonly>
                    </div>

                    <div class="mb-3">
                        <label for="adsos_profile_link" class="form-label fw-semibold text-dark">Link Profile</label>
                        <input type="url" class="form-control border border-secondary-subtle bg-light shadow-none" id="adsos_profile_link" name="adsos_profile_link" placeholder="https://instagram.com/..." required>
                    </div>

                    <div class="mb-3 form-check d-flex align-items-center gap-2 mt-4 ps-0">
                        <input class="form-check-input border border-secondary-subtle fs-4 m-0 shadow-none" type="checkbox" id="adsos_is_dm" name="adsos_is_dm" value="1" style="cursor: pointer;">
                        <label class="form-check-label fw-semibold text-dark mb-0 pt-1" for="adsos_is_dm" style="cursor:pointer;">
                            Sudah DM?
                        </label>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4 bg-light rounded-bottom">
                    <button type="button" class="btn btn-light border border-secondary-subtle px-4 fw-medium text-dark bg-white shadow-none" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="btn-save-adsos" class="btn btn-primary px-4 fw-medium shadow-none d-flex align-items-center gap-2">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Add/Edit Engage IG -->
<div class="modal fade" id="modal-form-engage" tabindex="-1" aria-labelledby="modalFormEngageIgLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white border-0 py-3">
                <h5 class="modal-title fw-bold" id="modalFormEngageIgLabel">Tambah Data Engage IG</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-engage">
                <div class="modal-body py-4 px-4">
                    <input type="hidden" id="engage_id" name="engage_id">

                    <div class="mb-3">
                        <label for="engage_category" class="form-label fw-semibold text-dark">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select border border-secondary-subtle bg-light shadow-none" id="engage_category" name="adsos_category" required>
                            <!-- Options rendered via JS -->
                        </select>
                        <div class="invalid-feedback">Kategori wajib dipilih.</div>
                        <div class="valid-feedback">Looks good!</div>
                    </div>

                    <div class="mb-3">
                        <label for="engage_date" class="form-label fw-semibold text-dark">Tanggal Selesai <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control border border-secondary-subtle bg-light shadow-none" id="engage_date" name="adsos_date" required>
                        <div class="invalid-feedback">Tanggal selesai wajib diisi.</div>
                        <div class="valid-feedback">Looks good!</div>
                    </div>

                    <div class="mb-3">
                        <label for="engage_account_name" class="form-label fw-semibold text-dark">Nama Akun <span class="text-danger">*</span></label>
                        <input type="hidden" class="form-control border border-secondary-subtle bg-light shadow-none" id="engage_account_id" name="engage_account_id" placeholder="Masukkan ID Akun" required>
                        <input type="text" class="form-control border border-secondary-subtle bg-light shadow-none" id="engage_account_name" name="engage_account_name" placeholder="Masukkan Nama Akun" required readonly>
                        <div class="invalid-feedback">Nama akun wajib diisi.</div>
                        <div class="valid-feedback">Looks good!</div>
                    </div>

                    <div class="mb-3">
                        <label for="engage_evidence_link" class="form-label fw-semibold text-dark">Evidence Link <span class="text-danger">*</span></label>
                        <textarea type="url" class="form-control border border-secondary-subtle bg-light shadow-none" id="engage_evidence_link" rows="3" name="engage_evidence_link" placeholder="https://instagram.com/..." required></textarea>
                        <div class="invalid-feedback">Evidence link wajib diisi.</div>
                        <div class="valid-feedback">Looks good!</div>
                    </div>

                    <div class="mb-3">
                        <label for="engage_note" class="form-label fw-semibold text-dark">Catatan</label>
                        <textarea class="form-control border border-secondary-subtle bg-light shadow-none" id="engage_note" name="engage_note" rows="5" placeholder="Masukkan catatan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4 bg-light rounded-bottom gap-2">
                    <button type="button" class="btn btn-light border border-secondary-subtle px-4 fw-medium text-dark bg-white shadow-none" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="btn-save-engage" class="btn btn-primary px-4 fw-medium shadow-none d-flex align-items-center gap-2">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>