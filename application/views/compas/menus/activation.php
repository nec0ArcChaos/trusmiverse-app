<!-- <div class="container-fluid absolute bg-gradient-theme-light pb-4" style="min-height: 300px;">
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
</div> -->
<div class="row bg-gradient-theme-light mb-4 py-2">
    <div class="col text-center">
        <h4>Event Activation <span class="text-gradient">Orchestration</span></h4>
        <p class="text-secondary">Orchestrate and track event lifecycles across stages. Manage offline events, booth
            setups, and on-ground activation details.</p>
    </div>
</div>

<!-- Navigation Bar -->
<div class="row mb-3">
    <!-- ── Stat Cards ───────────────────────────────────────── -->
    <div class="col-12 mb-4" id="activation-stat-cards">
        <div class="row g-3">

            <!-- AVG SLA TIME -->
            <div class="col-6 col-md-3">
                <div class="card border-0 rounded-4 h-100 text-dark overflow-hidden stat-card-activation"
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
                <div class="card border-0 rounded-4 h-100 text-dark overflow-hidden stat-card-activation"
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
                <div class="card border-0 rounded-4 h-100 text-dark overflow-hidden stat-card-activation"
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
                <div class="card border-0 rounded-4 h-100 text-dark overflow-hidden stat-card-activation"
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
    <!-- ── / Stat Cards ──────────────────────────────────────── -->
    <div class="col-12">
        <div class="card border-0 d-flex flex-row align-items-center justify-content-between p-2">
            <nav aria-label="breadcrumb" class="breadcrumb-theme bg-white">
                <ol class="breadcrumb mb-0">
                    <li class="p-2">
                        <a href="javascript:void(0)" data-value="kanban"
                            class="monday-item view-btn btn btn-link btn-sm active text-primary fw-bold"
                            onclick="switchView('kanban')"><i class="bi bi-kanban"></i> Board View</a>
                    </li>
                    <li class="p-2">
                        <a href="javascript:void(0)" data-value="list"
                            class="monday-item view-btn btn btn-link btn-sm text-secondary"
                            style="text-decoration: none;" onclick="switchView('list')"><i class="bi bi-list-ul"></i>
                            List View</a>
                    </li>
                    <li class="p-2">
                        <a href="javascript:void(0)" data-value="calendar"
                            class="monday-item view-btn btn btn-link btn-sm text-secondary"
                            style="text-decoration: none;" onclick="switchView('calendar')"><i
                                class="bi bi-calendar3"></i> Calendar</a>
                    </li>
                </ol>
            </nav>
            <div class="input-group input-group-md px-2 rounded-3" style="border: solid 0.5px #dfe0e1; width: auto;">
                <input type="hidden" id="start_date" value="">
                <input type="hidden" id="end_date" value="">
                <input type="text" class="form-control range bg-none px-0 border-0" value="" id="rangecalendar"
                    style="width: 200px;" />
                <span class="input-group-text text-secondary bg-none border-0" id="rangecalshow"><i
                        class="bi bi-calendar-event"></i></span>
            </div>
        </div>
    </div>
</div>

<div id="views-content">

</div>