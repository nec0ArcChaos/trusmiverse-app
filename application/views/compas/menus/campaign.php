<!-- title bar -->
<div class="container-fluid absolute bg-gradient-theme-light pb-4" style="min-height: 300px;">
</div>
<div class="container" style="margin-top: -280px;">
    <div class="row mb-4 py-2">
        <div class="col text-center">
            <h4>Don't let poor communication <span class="text-gradient">manipulate progress</span>, while you
                can track it better</h4>
            <p class="text-secondary">Manage tasks and update statuses. Add comments and assign responsibility. Get
                approval upon completion and many more.</p>
        </div>
    </div>
</div>
<div class="container mb-5">
    <div class="col-12 col-md-12 col-lg-12 col-xl-12 mb-4">
        <div class="card border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="row">
                        <div class="col col-sm-auto d-flex align-items-center">
                            <div class="input-group input-group-md px-2 rounded-3" style="border: solid 0.5px #dfe0e1;">
                                <input type="text" class="form-control range bg-none px-0" value=""
                                    id="rangecalendar" />
                                <span class="input-group-text text-secondary bg-none" id="rangecalshow"><i
                                        class="bi bi-calendar-event"></i></span>
                            </div>
                            <div class="ms-2 dropdown d-inline-block rounded-3" style="border: solid 0.5px #dfe0e1;">
                                <a class="btn btn-sqaure btn-link text-secondary dd-arrow-none dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static"
                                    role="button" id="campaign_view_btn" title="Switch View">
                                    <i class="bi bi-kanban" id="campaign_view_icon"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item campaign-view-toggle active" href="javascript:void(0)"
                                            data-view="kanban" data-icon="bi-kanban">
                                            <i class="bi bi-kanban me-2"></i>Kanban
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item campaign-view-toggle" href="javascript:void(0)"
                                            data-view="table" data-icon="bi-list-ul">
                                            <i class="bi bi-list-ul me-2"></i>List / Table
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- Search (visible in table view) -->
                            <div class="col-5 ms-2 d-none" id="campaign_table_search_wrap">
                                <div class="input-group input-group-md rounded-3" style="border: solid 0.5px #dfe0e1;">
                                    <span class="input-group-text bg-none text-secondary"><i
                                            class="bi bi-search"></i></span>
                                    <input type="text" class="form-control bg-none px-1" id="campaign_table_search"
                                        placeholder="Search campaign...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCampaignModal">
                            <i class="bi bi-plus-lg me-1"></i>Add Campaign
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ── Campaign Stat Cards ─────────────────────────────────── -->
    <div class="col-12 mb-4" id="campaign-stat-cards">
        <div class="row g-3">
            <!-- AVG SLA TIME -->
            <div class="col-6 col-md-3">
                <div class="card border-0 rounded-4 h-100 text-dark overflow-hidden stat-card-campaign"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <p class="text-uppercase fw-bold mb-3 opacity-80 stat-card-label"
                            style="font-size: 10px; letter-spacing: 1.5px;">AVG SLA Time</p>
                        <div>
                            <h2 class="fw-bold mb-1 stat-card-value" id="stat-avg-sla"
                                style="font-size: 2rem; letter-spacing: -1px;">—</h2>
                            <p class="mb-0 opacity-75 stat-card-sub" style="font-size: 11px;">Completion time</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AVG AI SCORE -->
            <div class="col-6 col-md-3">
                <div class="card border-0 rounded-4 h-100 text-dark overflow-hidden stat-card-campaign"
                    style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <p class="text-uppercase fw-bold mb-3 opacity-80 stat-card-label"
                            style="font-size: 10px; letter-spacing: 1.5px;">AVG AI Score</p>
                        <div>
                            <h2 class="fw-bold mb-1 stat-card-value" id="stat-avg-ai"
                                style="font-size: 2rem; letter-spacing: -1px;">—</h2>
                            <p class="mb-0 opacity-75 stat-card-sub" style="font-size: 11px;">Quality rating</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TOTAL SUBMISSIONS -->
            <div class="col-6 col-md-3">
                <div class="card border-0 rounded-4 h-100 text-dark overflow-hidden stat-card-campaign"
                    style="background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <p class="text-uppercase fw-bold mb-3 opacity-80 stat-card-label"
                            style="font-size: 10px; letter-spacing: 1.5px;">Total Submissions</p>
                        <div>
                            <h2 class="fw-bold mb-1 stat-card-value" id="stat-total-submissions"
                                style="font-size: 2rem; letter-spacing: -1px;">—</h2>
                            <p class="mb-0 opacity-75 stat-card-sub" style="font-size: 11px;">All completed work</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- APPROVED PLANS -->
            <div class="col-6 col-md-3">
                <div class="card border-0 rounded-4 h-100 text-dark overflow-hidden stat-card-campaign"
                    style="background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <p class="text-uppercase fw-bold mb-3 opacity-80 stat-card-label"
                            style="font-size: 10px; letter-spacing: 1.5px;">Approved Plans</p>
                        <div>
                            <h2 class="fw-bold mb-1 stat-card-value" id="stat-approved-plans"
                                style="font-size: 2rem; letter-spacing: -1px;">—</h2>
                            <p class="mb-0 opacity-75 stat-card-sub" style="font-size: 11px;">Score &gt; 70</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- =================== KANBAN VIEW =================== -->
<div id="campaign_view_kanban">
    <?php $this->load->view('compas/campaign/kanban/kanban'); ?>
</div>

<!-- =================== TABLE VIEW =================== -->
<div id="campaign_view_table" class="d-none">
    <?php $this->load->view('compas/campaign/table/table'); ?>
</div>