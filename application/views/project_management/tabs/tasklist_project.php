<div id="tasklist_project-empty-state" class="d-none">
    <!-- empty state -->
    <div class="text-center py-5">
        <i class="bi bi-speedometer2 fs-1 text-muted mb-3"></i>
        <h5 class="text-muted">Belum ada data Tasklist Project</h5>
        <p class="text-muted">Data Tasklist Project akan muncul di sini</p>
    </div>
</div>

<div id="tasklist_project-data" class="">
    <!-- Detail Pekerjaan Proyek -->
    <div class="anim a3" id="gantt-page">
        <div class="gantt-panel anim a1">

            <!-- ── Toolbar ── -->
            <div class="gantt-toolbar">
                <div style="display:flex; align-items:center; gap:10px;">
                    <div class="stage-icon si-blue" style="font-size:15px; width:36px; height:36px; flex-shrink:0;">🗂️</div>
                    <div>
                        <div class="font-head" style="font-size:11px; font-weight:700; letter-spacing:1.8px; text-transform:uppercase; color:var(--accent);">Project List & Gantt Chart</div>
                        <div class="panel-sub">Hierarchical view of projects, tasks, and interactive timeline visualization</div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button class="gantt-nav-btn" id="g-prev-week"><i class="bi bi-chevron-left"></i></button>
                    <div class="gantt-week-label" id="g-week-label">
                        <span id="g-week-num">W1</span>
                        <small id="g-week-range">Mar 29 – Apr 4</small>
                    </div>
                    <button class="gantt-nav-btn" id="g-next-week"><i class="bi bi-chevron-right"></i></button>
                    <span style="width:1px; height:20px; background:#e4e4e7; display:inline-block; margin:0 4px;"></span>
                    <button class="gantt-nav-btn" id="g-today-btn" title="Jump to today" style="width:auto; padding:0 10px; font-size:11px; font-weight:700; color:#ef4444; border-color:#fecaca;">Today</button>
                    <div class="col-auto d-flex align-items-center ms-2" style="height:28px;">
                        <div class="input-group input-group-sm px-2 rounded-3" style="border: solid 0.5px #dfe0e1; background:#fff; height:28px;">
                            <input type="text" class="form-control range bg-none px-0" style="font-size:11px; font-weight:600; width:130px; border:none; height:26px;" value="" id="gantt-range-picker">
                            <span class="input-group-text text-secondary bg-none border-0" style="padding:0 4px;"><i class="bi bi-calendar-event" style="font-size:12px;"></i></span>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-sm ms-1" id="g-add-project" style="font-size:11px; font-weight:600; border-radius:6px; height:28px; display:inline-flex; align-items:center; gap:4px;">
                        <i class="bi bi-plus-lg"></i> Add Project
                    </button>
                    <button class="gantt-nav-btn gantt-refresh-btn ms-1" id="g-refresh-btn" title="Refresh Data" style="width:28px; height:28px; display:inline-flex; align-items:center; justify-content:center; padding:0; color:#64748b; border:1px solid #e2e8f0; border-radius:6px;">
                        <i class="bi bi-arrow-repeat"></i>
                    </button>
                </div>
            </div>

            <!-- ── Filter bar ── -->
            <div class="gantt-filter-bar">
                <div class="gf-search-wrap">
                    <i class="bi bi-search"></i>
                    <input type="text" id="g-search" class="gf-input" placeholder="Search…" style="width:180px;">
                </div>
                <select id="g-filter-company" class="gf-select">
                    <option value="all">All Companies</option>
                </select>
                <select id="g-filter-status" class="gf-select">
                    <option value="all">All Status</option>
                </select>
                <select id="g-filter-category" class="gf-select">
                    <option value="all">All Categories</option>
                </select>
                <select id="g-filter-pic" class="gf-select" style="display: none !important;">
                    <option value="all">All PIC</option>
                </select>
                <button id="g-reset-filters" class="btn btn-link text-decoration-none p-0">
                    <i class="bi bi-x-circle"></i> Reset
                </button>
                <button id="g-view-settings-btn" title="Column Settings" style="margin-left:auto; background:none; border:1px solid #e4e4e7; border-radius:6px; padding:3px 8px; font-size:12px; color:#64748b; cursor:pointer; display:flex; align-items:center; gap:4px;">
                    <i class="bi bi-layout-three-columns"></i> Columns
                </button>
            </div>

            <!-- ── Main Gantt body ── -->
            <div class="gantt-body" id="gantt-body">
                <!-- Loader -->
                <div id="gantt-loader">
                    <div class="g-loader-content">
                        <div class="g-loader-spinner"></div>
                        <div class="g-loader-text">Loading Projects and Tasks...</div>
                    </div>
                </div>

                <!-- LEFT grid -->
                <div class="gantt-grid" id="gantt-grid">
                    <div class="gantt-grid-scroll" id="gantt-grid-scroll">
                        <div class="gantt-col-header" id="gantt-col-header"></div>
                        <div id="gantt-grid-rows"></div>
                        <button class="add-row-btn" id="g-add-project-btn2" style="position: absolute; bottom: 0; left: 0; z-index: 100; border-top: 1px solid #e2e8f0; background: #fff; width: fit-content; min-width: 100%;">
                            <i class="bi bi-plus-circle"></i> Add Project
                        </button>
                    </div>
                </div>

                <!-- SPLITTER -->
                <div class="gantt-splitter" id="gantt-splitter"></div>

                <!-- RIGHT timeline -->
                <div class="gantt-tl-scroll" id="gantt-tl-scroll">
                    <div class="gantt-tl-header" id="gantt-tl-header">
                        <div class="gantt-th-weeks" id="gantt-th-weeks"></div>
                        <div class="gantt-th-days" id="gantt-th-days"></div>
                    </div>
                    <div class="gantt-timeline-rows" id="gantt-timeline-rows"></div>
                    <!-- Spacer to match the left-side 'Add Project' button so scrollHeight remains perfectly synced -->
                    <div style="height: 48px; border-top: 1px solid transparent; width: 100%; display: block;"></div>
                </div>

            </div><!-- /.gantt-body -->

        </div><!-- /.gantt-panel -->

        <!-- Column Settings Panel -->
        <div id="gantt-view-settings" style="display:none; position:fixed; top:0; right:0; width:290px; height:100vh; background:#fff; border-left:1px solid #e4e4e7; box-shadow:-8px 0 24px rgba(0,0,0,0.08); z-index:10000; display:flex; flex-direction:column; overflow:hidden;">
            <div style="padding:16px 20px 14px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
                <span style="font-weight:700; font-size:13px; color:#1e293b;"><i class="bi bi-layout-three-columns" style="margin-right:6px;"></i>Column Settings</span>
                <button id="g-settings-close" style="background:none; border:none; cursor:pointer; color:#94a3b8; font-size:16px;"><i class="bi bi-x-lg"></i></button>
            </div>
            <div style="padding:12px 16px; border-bottom:1px solid #f1f5f9; font-size:11px; color:#94a3b8;">Drag columns to reorder &bull; Toggle to show/hide &bull; Right-click to freeze</div>
            <div id="g-col-settings-list" style="flex:1; overflow-y:auto; padding:8px 0;"></div>
            <div style="padding:12px 16px; border-top:1px solid #f1f5f9; display:flex; gap:8px;">
                <button id="g-reset-view" style="flex:1; background:#f8fafc; border:1px solid #e4e4e7; border-radius:6px; padding:7px; font-size:12px; font-weight:600; color:#64748b; cursor:pointer;"><i class="bi bi-arrow-counterclockwise"></i> Reset</button>
                <button id="g-save-view" style="flex:1; background:var(--accent); border:none; border-radius:6px; padding:7px; font-size:12px; font-weight:600; color:#fff; cursor:pointer;"><i class="bi bi-floppy"></i> Save</button>
            </div>
        </div>
        <div id="gantt-view-settings-overlay" style="display:none; position:fixed; inset:0; z-index:9999; background:transparent;"></div>
    </div>
    <!-- End Detail Pekerjaan Proyek -->


    <!-- Avatar Tooltip -->
    <div id="gantt-av-tooltip" style="display:none; position:fixed; pointer-events:none; z-index:999999; background:#1e293b; color:#fff; padding:4px 10px; font-size:11px; font-weight:500; border-radius:6px; white-space:nowrap; box-shadow:0 4px 6px -1px rgba(0,0,0,0.1); transform:translateX(-50%);">
        <span id="gantt-av-tooltip-text"></span>
        <div style="position:absolute; top:100%; left:50%; margin-left:-5px; border-width:5px; border-style:solid; border-color:#1e293b transparent transparent transparent;"></div>
    </div>

    <!-- Tooltip -->
    <div id="gantt-tooltip">
        <div class="tt-title"><i class="bi bi-info-circle-fill" style="color:var(--accent);"></i> <span id="gtt-title"></span></div>
        <div class="tt-row">
            <span class="tt-label"><i class="bi bi-building"></i> Company</span>
            <span class="tt-val" id="gtt-company"></span>
        </div>
        <div class="tt-row">
            <span class="tt-label"><i class="bi bi-tag"></i> Category</span>
            <span class="tt-val" id="gtt-category"></span>
        </div>
        <div class="tt-row">
            <span class="tt-label"><i class="bi bi-check2-circle"></i> Status</span>
            <span class="tt-val" id="gtt-status"></span>
        </div>
        <div class="tt-row">
            <span class="tt-label"><i class="bi bi-people"></i> PIC</span>
            <span class="tt-val" id="gtt-pic"></span>
        </div>
        <div class="tt-divider"></div>
        <div class="tt-row">
            <span class="tt-label"><i class="bi bi-calendar-event"></i> Start</span>
            <span class="tt-val" id="gtt-start"></span>
        </div>
        <div class="tt-row">
            <span class="tt-label"><i class="bi bi-calendar-check"></i> End</span>
            <span class="tt-val" id="gtt-end"></span>
        </div>
        <div class="tt-divider"></div>
        <div class="tt-row" style="margin-bottom:0;">
            <span class="tt-label"><i class="bi bi-speedometer2"></i> Progress</span>
            <span class="tt-val" id="gtt-progress" style="color:var(--green);"></span>
        </div>
    </div>

    <!-- Note Popover Base -->
    <div id="gantt-note-pop" style="display:none; position:fixed; z-index:9998; background:#fff; border:1px solid #cbd5e1; border-radius:8px; box-shadow:0 10px 25px rgba(0,0,0,0.15); width:280px; padding:12px; transition:opacity 0.2s;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:10px; font-weight:700; text-transform:uppercase; color:#64748b; letter-spacing:1px;"><i class="bi bi-journal-text"></i> Task Note</span>
            <button id="gnp-close" style="background:none; border:none; color:#a1a1aa; cursor:pointer;" onclick="window.ganttCloseNotePop()"><i class="bi bi-x-lg"></i></button>
        </div>
        <textarea id="gnp-text" class="form-control" style="font-size:12px; height:80px; resize:none; border-color:#e2e8f0; border-radius:6px; padding:8px;" placeholder="Type progress note or details here..."></textarea>
        <div style="text-align:right; margin-top:8px;">
            <span id="gnp-status" style="font-size:10px; color:#10b981; margin-right:8px; font-weight:600; opacity:0; transition:opacity 0.3s;"><i class="bi bi-check-circle"></i> Saved!</span>
            <button id="gnp-save" class="btn btn-sm btn-primary" style="font-size:10px; font-weight:600; padding:3px 12px; border-radius:4px; box-shadow:0 2px 4px rgba(0,102,204,0.2);">Save Note</button>
        </div>
        <div id="gnp-arrow" style="position:absolute; width:12px; height:12px; background:#fff; border-left:1px solid #cbd5e1; border-top:1px solid #cbd5e1; transform:rotate(-45deg); top:16px; left:-7px;"></div>
    </div>

    <!-- Context menu -->
    <div id="gantt-ctx-menu">
        <button id="gctx-add-task"><i class="bi bi-plus-circle"></i> Add Sub-task</button>
        <button id="gctx-input-problem"><i class="bi bi-pencil-square"></i> Input Kendala</button>
        <button id="gctx-duplicate"><i class="bi bi-files"></i> Duplicate</button>
        <hr>
        <button id="gctx-details"><i class="bi bi-info-circle"></i> See Details</button>
        <button id="gctx-toggle-all"><i class="bi bi-arrows-expand"></i> Expand All Projects</button>
        <hr>
        <button id="gctx-delete" class="danger"><i class="bi bi-trash3"></i> Delete</button>
    </div>

    <!-- Progress popover -->
    <div id="gantt-progress-pop" style="width:240px; padding:12px; border-radius:10px; border:1px solid #cbd5e1; box-shadow:0 12px 30px rgba(0,0,0,0.18);">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
            <span style="font-size:10px; font-weight:700; text-transform:uppercase; color:#64748b; letter-spacing:1px;"><i class="bi bi-speedometer2"></i> Update Progress</span>
            <button style="background:none; border:none; color:#a1a1aa; cursor:pointer;" onclick="window.ganttClosePop()"><i class="bi bi-x-lg"></i></button>
        </div>

        <label>Set Progress</label>
        <input type="range" id="gp-slider" min="0" max="100" value="0">
        <div class="pop-val"><span id="gp-val">0</span>%</div>

        <div style="margin-top:12px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                <label style="margin-bottom:0;">Progress Note / Daily Log</label>
                <div id="gp-word-count" style="font-size:9.5px; color:#94a3b8; font-weight:600;">0 / 3 words</div>
            </div>
            <textarea id="gp-note" class="form-control" style="font-size:11px; height:60px; resize:none; border-color:#e2e8f0; border-radius:6px; padding:8px;" placeholder="Apa yang sudah dikerjakan?"></textarea>
        </div>

        <div style="text-align:right; margin-top:12px;">
            <span id="gp-msg" style="font-size:10px; color:#10b981; margin-right:8px; font-weight:600; display:none;"><i class="bi bi-check-circle"></i> Saved!</span>
            <button id="gp-save" class="btn btn-sm btn-primary" style="font-size:11px; font-weight:600; padding:4px 14px; border-radius:6px; box-shadow:0 3px 6px rgba(0,102,204,0.2);">Save Progress</button>
        </div>
    </div>

    <!-- Inline Custom Dropdown -->
    <div id="gantt-inline-dropdown" class="gantt-dropdown dropdown-animate" style="display:none; position:fixed; z-index:9999; width:220px; background:#fff; border:1px solid #e5e7eb; border-radius:8px; box-shadow:0 10px 25px -5px rgba(0,0,0,0.1); padding:8px;">
        <div style="position:relative; margin-bottom:8px;">
            <i class="bi bi-search" style="position:absolute; left:10px; top:50%; transform:translateY(-50%); color:#9ca3af; font-size:12px;"></i>
            <input type="text" id="gantt-dd-search" placeholder="Search..." style="width:100%; padding:6px 10px 6px 28px; font-size:12px; border:1px solid #e5e7eb; border-radius:6px; outline:none; background:#f9fafb;">
        </div>
        <div id="gantt-dd-list" style="max-height:220px; overflow-y:auto; display:flex; flex-direction:column; gap:2px;">
            <!-- Options here -->
        </div>
    </div>

    <!-- End Detail Pekerjaan Proyek -->

</div>