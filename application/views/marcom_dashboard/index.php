<main class="main mainheight">

    <div class="container-fluid p-3">

        <!-- HEADER -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="dashboard-header p-4 rounded-4 text-white">

                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-bar-chart-line-fill fs-3 me-2"></i>
                        <div>
                            <h4 class="mb-0 fw-bold">Web Statistik</h4>
                            <small>Rumah Ningrat - Social Media Analytics</small>
                        </div>
                    </div>

                    <!-- FILTER -->
                    <div class="row g-3 align-items-end">

                        <div class="col-md-4">
                            <label class="form-label text-white">Start Date</label>
                            <input type="date"
                                id="filter_start_date"
                                class="form-control dashboard-input">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label text-white">End Date</label>
                            <input type="date"
                                id="filter_end_date"
                                class="form-control dashboard-input">
                        </div>

                        <div class="col-md-4">
                            <button class="btn dashboard-btn w-100"
                                id="btn_filter_dashboard">
                                <i class="bi bi-funnel-fill me-1"></i>
                                Filter Data
                            </button>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <!-- KPI SECTION -->
        <div class="row g-4">

            <!-- INSTAGRAM -->
            <div class="col-lg-4">
                <div class="kpi-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="kpi-title">INSTAGRAM TOTAL</span>
                        <i class="bi bi-instagram fs-4 opacity-75"></i>
                    </div>

                    <h2 class="kpi-number" id="ig_total_views">0</h2>

                    <div class="row mt-3 small">
                        <div class="col-6">
                            ❤️ Likes
                            <div class="fw-bold" id="ig_total_likes">0</div>
                        </div>
                        <div class="col-6">
                            💬 Comments
                            <div class="fw-bold" id="ig_total_comments">0</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TIKTOK -->
            <div class="col-lg-4">
                <div class="kpi-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="kpi-title">TIKTOK TOTAL</span>
                        <i class="bi bi-tiktok fs-4 opacity-75"></i>
                    </div>

                    <h2 class="kpi-number" id="tt_total_views">0</h2>

                    <div class="row mt-3 small">
                        <div class="col-4">
                            ❤️ Likes
                            <div class="fw-bold" id="tt_total_likes">0</div>
                        </div>
                        <div class="col-4">
                            🔁 Shares
                            <div class="fw-bold" id="tt_total_shares">0</div>
                        </div>
                        <div class="col-4">
                            💾 Saves
                            <div class="fw-bold" id="tt_total_saves">0</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ADMIN / CUSTOMER SERVICE -->
            <!-- <div class="col-lg-4">
                <div class="kpi-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="kpi-title">CUSTOMER SERVICE</span>
                        <i class="bi bi-headset fs-4 opacity-75"></i>
                    </div>

                    <h2 class="kpi-number" id="cs_total_ticket">0</h2>

                    <div class="row mt-3 small">
                        <div class="col-6">
                            ✔️ Ceklok
                            <div class="fw-bold" id="cs_total_ceklok">0</div>
                        </div>
                        <div class="col-6">
                            📦 Booking
                            <div class="fw-bold" id="cs_total_booking">0</div>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="col-lg-4">
                <div class="card dashboard-card border-0">
                    <div class="card-header">
                        <i class="bi bi-trophy-fill me-2"></i>
                        Top 3 User
                    </div>
                    <div class="card-body" id="top_pic_container">
                    </div>
                </div>
            </div>

        </div>

        <div class="row mt-5">
            <div class="col-lg-6">
                <div class="card dashboard-card border-0">
                    <div class="card-header">
                        <i class="bi bi-graph-up me-2"></i>
                        Statistik Periode
                    </div>
                    <div class="card-body">
                        <div id="chart_periode"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card dashboard-card border-0">
                    <div class="card-header">
                        <i class="bi bi-bar-chart-fill me-2"></i>
                        IG vs TikTok
                    </div>
                    <div class="card-body">
                        <div id="chart_platform_comparison"></div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mt-5">
            <div class="col-lg-6">

                <div class="card dashboard-card border-0">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-people-fill me-2"></i>
                            <strong>User Performance</strong>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="table_user_performance"
                                class="table table-hover align-middle w-100">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Total Posts</th>
                                        <th>Instagram</th>
                                        <th>TikTok</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-lg-6">
                <div class="card dashboard-card border-0">
                    <div class="card-header">
                        <i class="bi bi-activity me-2"></i>
                        Engagement Rate per Account
                    </div>
                    <div class="card-body">
                        <div id="chart_er_account"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</main>
<div class="modal fade" id="modalUserDetail">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-bar-chart-line-fill me-2"></i>
                    Postingan Media Sosial
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="table-responsive">
                    <table id="table_user_detail"
                        class="table table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Platform</th>
                                <th>Account</th>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Stats</th>
                                <th>Link</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>