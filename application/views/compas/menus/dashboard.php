<div class="content mt-0 pt-2">
    <div class="row">
        <div class="col">
            <h1 class="title dash-title mt-0">Performance <span>Overview</span></h1>
        </div>
        <div class="col-auto d-flex align-items-center">
            <div class="input-group input-group-md px-2 rounded-3" style="border: solid 0.5px #dfe0e1;">
                <input type="text" class="form-control range bg-none px-0" value="" id="rangecalendar">
                <span class="input-group-text text-secondary bg-none" id="rangecalshow"><i
                        class="bi bi-calendar-event"></i></span>
            </div>
        </div>
    </div>
    <div class="summary-row anim a1">
        <div class="panel stat-card">
            <div class="stat-label">All Campaign</div>
            <div class="stat-value" id="val-all-campaign">0</div>
            <div class="stat-desc">Total campaign approved periode ini</div>
            <span class="tag tag-g"><span id="val-all-campaign-change">▲ +0</span> dari bulan lalu</span>
        </div>

        <div class="panel stat-card">
            <div class="stat-label">Completed</div>
            <div class="stat-value" id="val-completed">0</div>
            <div class="stat-desc">Campaign selesai periode ini</div>
            <span class="tag tag-g" style="margin-top:10px;"><span id="val-completed-on-time">0</span> On Time</span>
            <span class="tag tag-r" style="margin-top:10px;"><span id="val-completed-delayed">0</span> Delayed</span>
        </div>

        <div class="panel stat-card">
            <div class="stat-label">On Progress</div>
            <div class="stat-value" id="val-on-progress">0</div>
            <div class="stat-desc">Campaign berjalan + plan approved</div>
            <span class="tag tag-g" style="margin-top:10px;"><span id="val-on-progress-on-track">0</span> On
                Track</span>
            <span class="tag tag-y" style="margin-top:10px;"><span id="val-on-progress-at-risk">0</span> At Risk</span>
        </div>

        <div class="panel stat-card">
            <div class="stat-label">Avg Ai Score</div>
            <div class="stat-value" id="val-avg-ai">0</div>
            <div class="stat-desc">Rata-rata performa campaign</div>
            <span class="tag tag-g" style="margin-top:10px;"><span id="val-avg-ai-text">-</span></span>
        </div>
    </div>

    <div class="anim a4" id="section-campaign-stage-pipeline">
        <h1 class="title dash-title mt-0">Performance <span>Pipeline</span></h1>
        <div class="stage-grid">
            <!-- ACTIVATION -->
            <div class="panel stage-card">
                <div class="stage-header">
                    <div class="stage-icon si-blue">🚀</div>
                    <div>
                        <div class="stage-name">Activation</div>
                        <div class="stage-desc">Plan &amp; eksekusi aktivasi</div>
                    </div>
                </div>
                <div class="stage-metrics">
                    <div class="stage-metric">
                        <div class="sm-label">Approved</div>
                        <div class="sm-value"><span id="val-act-approved-actual">0</span> / <span
                                id="val-act-approved-target">0</span></div>
                        <hr>
                        <div class="sm-label">Avg. SLA</div>
                        <div class="sm-value" id="val-act-sla">0h 0m</div>
                    </div>
                    <div class="stage-metric">
                        <div class="sm-label mb-0 text-center">Avg. Ai Score</div>
                        <div class="col-auto d-flex align-items-center justify-content-center h-100">
                            <div class="circle-small-80">
                                <div id="divCircleActivationAvgAiScore"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="stage-cpr">
                    <span class="cpr-label">Completion Rate</span>
                    <span class="cpr-value" style="color:var(--green);"><span id="val-act-cpr">0</span>%</span>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="panel stage-card">
                <div class="stage-header">
                    <div class="stage-icon si-purple">🎨</div>
                    <div>
                        <div class="stage-name">Content</div>
                        <div class="stage-desc">Produksi &amp; approval konten</div>
                    </div>
                </div>
                <div class="stage-metrics">
                    <div class="stage-metric">
                        <div class="sm-label">Approved</div>
                        <div class="sm-value"><span id="val-cnt-approved-actual">0</span> / <span
                                id="val-cnt-approved-target">0</span></div>
                        <hr>
                        <div class="sm-label">Avg. SLA</div>
                        <div class="sm-value" id="val-cnt-sla">-</div>
                    </div>
                    <div class="stage-metric">
                        <div class="sm-label mb-0 text-center">Avg. Ai Score</div>
                        <div class="col-auto d-flex align-items-center justify-content-center h-100">
                            <div class="circle-small-80">
                                <div id="divCircleContentAvgAiScore">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="stage-cpr">
                    <span class="cpr-label">Completion Rate</span>
                    <span class="cpr-value" style="color:var(--green);"><span id="val-cnt-cpr">0</span>%</span>
                </div>
            </div>

            <!-- TALENT -->
            <div class="panel stage-card">
                <div class="stage-header">
                    <div class="stage-icon si-teal">⭐</div>
                    <div>
                        <div class="stage-name">Talent</div>
                        <div class="stage-desc">Seleksi &amp; briefing talent</div>
                    </div>
                </div>
                <div class="stage-metrics">
                    <div class="stage-metric">
                        <div class="sm-label">Approved</div>
                        <div class="sm-value"><span id="val-tln-approved-actual">0</span> / <span
                                id="val-tln-approved-target">0</span></div>
                        <hr>
                        <div class="sm-label">Avg. SLA</div>
                        <div class="sm-value" id="val-tln-sla">-</div>
                    </div>
                    <div class="stage-metric">
                        <div class="sm-label mb-0 text-center">Avg. Ai Score</div>
                        <div class="col-auto d-flex align-items-center justify-content-center h-100">
                            <div class="circle-small-80">
                                <div id="divCircleTalentAvgAiScore">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="stage-cpr">
                    <span class="cpr-label">Completion Rate</span>
                    <span class="cpr-value" style="color:var(--green);"><span id="val-tln-cpr">0</span>%</span>
                </div>
            </div>

            <!-- DISTRIBUTION -->
            <div class="panel stage-card">
                <div class="stage-header">
                    <div class="stage-icon si-orange">📡</div>
                    <div>
                        <div class="stage-name">Distribution</div>
                        <div class="stage-desc">Penyebaran &amp; publish konten</div>
                    </div>
                </div>
                <div class="stage-metrics">
                    <div class="stage-metric">
                        <div class="sm-label">Approved</div>
                        <div class="sm-value"><span id="val-dst-approved-actual">0</span> / <span
                                id="val-dst-approved-target">0</span></div>
                        <hr>
                        <div class="sm-label">Avg. SLA</div>
                        <div class="sm-value" id="val-dst-sla">-</div>
                    </div>
                    <div class="stage-metric">
                        <div class="sm-label mb-0 text-center">Avg. Ai Score</div>
                        <div class="col-auto d-flex align-items-center justify-content-center h-100">
                            <div class="circle-small-80">
                                <div id="divCircleDistributionAvgAiScore">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="stage-cpr">
                    <span class="cpr-label">Completion Rate</span>
                    <span class="cpr-value" style="color:var(--green);"><span id="val-dst-cpr">0</span>%</span>
                </div>
            </div>

            <!-- OPTIMIZATION -->
            <div class="panel stage-card">
                <div class="stage-header">
                    <div class="stage-icon si-green">⚙️</div>
                    <div>
                        <div class="stage-name">Optimization</div>
                        <div class="stage-desc">Evaluasi &amp; optimasi performa</div>
                    </div>
                </div>
                <div class="stage-metrics">
                    <div class="stage-metric">
                        <div class="sm-label">Approved</div>
                        <div class="sm-value"><span id="val-opt-approved-actual">0</span> / <span
                                id="val-opt-approved-target">0</span></div>
                        <hr>
                        <div class="sm-label">Avg. SLA</div>
                        <div class="sm-value" id="val-opt-sla">-</div>
                    </div>
                    <div class="stage-metric">
                        <div class="sm-label mb-0 text-center">Avg. Ai Score</div>
                        <div class="col-auto d-flex align-items-center justify-content-center h-100">
                            <div class="circle-small-80">
                                <div id="divCircleOptimizationAvgAiScore">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="stage-cpr">
                    <span class="cpr-label">Completion Rate</span>
                    <span class="cpr-value" style="color:var(--green);"><span id="val-opt-cpr">0</span>%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="anim a4" id="section-campaign-stage-list">
        <h1 class="title dash-title mt-0">Performance <span>Campaign</span></h1>
        <div class="panel anim a3">
            <div class="panel-head">
                <div>
                    <div class="font-body">Performance Per Campaign</div>
                </div>
                <div class="col-2 ms-auto">
                    <select class="form-select period-select font-body border" style="font-size: 12px;">
                        <option>Semua Status</option>
                        <option>Completed</option>
                        <option>On Progress</option>
                    </select>
                </div>
            </div>
            <div class="cp-table-wrap p-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTable no-footer" id="dt_campaign_stage_list">
                        <thead>
                            <tr>
                                <th>Campaign</th>
                                <th class="text-center"><i class="fas fa-rocket"
                                        style="margin-right:4px;color:var(--WinDOORS-theme)"></i>Activation</th>
                                <th class="text-center"><i class="fas fa-pen-nib"
                                        style="margin-right:4px;color:#dd0093"></i>Content</th>
                                <th class="text-center"><i class="fas fa-star"
                                        style="margin-right:4px;color:#c98f00"></i>Talent</th>
                                <th class="text-center"><i class="fas fa-layer-group"
                                        style="margin-right:4px;color:#00a870"></i>Distribution</th>
                                <th class="text-center"><i class="fas fa-sliders"
                                        style="margin-right:4px;color:#e07000"></i>Optimization</th>
                                <th class="text-center">Avg. SLA</th>
                                <th class="text-center">Avg. Ai Score</th>
                                <th class="text-center">Completion Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="camp-name">Ramadan Series</td>
                                <td class="text-center">actual/target</td>
                                <td class="text-center">actual/target</td>
                                <td class="text-center">actual/target</td>
                                <td class="text-center">actual/target</td>
                                <td class="text-center">actual/target</td>
                                <td class="text-center">actual/target</td>
                                <td class="text-center">5.3%</td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="mini-bar">
                                            <div class="mini-track">
                                                <div class="mini-fill mf-g" style="width:91%;"></div>
                                            </div><span class="tg">91%</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="anim a4" id="section-campaign-pic-list">
        <h1 class="title dash-title mt-0">Performance <span>PIC</span></h1>
        <div class="pic-grid anim a4">
            <div class="panel">
                <div class="panel-head">
                    <div>
                        <div class="panel-title">Activation Performance</div>
                        <div class="panel-sub">Performa PIC Activation · AI Scoring</div>
                    </div>
                </div>
                <table class="table table-bordered table-striped dataTable no-footer" id="dt_pic_activation_list">
                    <thead>
                        <tr>
                            <th>PIC</th>
                            <th class="text-center">Act/Trgt</th>
                            <th class="text-center">Avg. SLA</th>
                            <th class="text-center">Avg. Ai Score</th>
                            <th class="text-center">Completion Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <div class="panel">
                <div class="panel-head">
                    <div>
                        <div class="panel-title">Content Performance</div>
                        <div class="panel-sub">Performa PIC Creative · AI Scoring</div>
                    </div>
                </div>
                <table class="table table-bordered table-striped dataTable no-footer" id="dt_pic_content_list">
                    <thead>
                        <tr>
                            <th>PIC</th>
                            <th class="text-center">Act/Trgt</th>
                            <th class="text-center">Avg. SLA</th>
                            <th class="text-center">Avg. Ai Score</th>
                            <th class="text-center">Completion Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <div class="panel">
                <div class="panel-head">
                    <div>
                        <div class="panel-title">Talent Performance</div>
                        <div class="panel-sub">Performa PIC Talent · AI Scoring</div>
                    </div>
                </div>
                <table class="table table-bordered table-striped dataTable no-footer" id="dt_pic_talent_list">
                    <thead>
                        <tr>
                            <th>PIC</th>
                            <th class="text-center">Act/Trgt</th>
                            <th class="text-center">Avg. SLA</th>
                            <th class="text-center">Avg. Ai Score</th>
                            <th class="text-center">Completion Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <div class="panel">
                <div class="panel-head">
                    <div>
                        <div class="panel-title">Distribution Performance</div>
                        <div class="panel-sub">Performa PIC Distribution · AI Scoring</div>
                    </div>
                </div>
                <table class="table table-bordered table-striped dataTable no-footer" id="dt_pic_distribution_list">
                    <thead>
                        <tr>
                            <th>PIC</th>
                            <th class="text-center">Act/Trgt</th>
                            <th class="text-center">Avg. SLA</th>
                            <th class="text-center">Avg. Ai Score</th>
                            <th class="text-center">Completion Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <div class="panel">
                <div class="panel-head">
                    <div>
                        <div class="panel-title">Optimization Performance</div>
                        <div class="panel-sub">Performa PIC Optimization · AI Scoring</div>
                    </div>
                </div>
                <table class="table table-bordered table-striped dataTable no-footer" id="dt_pic_optimization_list">
                    <thead>
                        <tr>
                            <th>PIC</th>
                            <th class="text-center">Act/Trgt</th>
                            <th class="text-center">Avg. SLA</th>
                            <th class="text-center">Avg. Ai Score</th>
                            <th class="text-center">Completion Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>