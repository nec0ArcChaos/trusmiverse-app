 <figure class="coverimg w-100 h-300 mb-0 position-relative" style="
 background: linear-gradient(135deg, rgba(2, 62, 115, 0.8), rgba(0, 32, 63, 0.9)), url(&quot;<?= base_url() ?>assets/main_theme/img/bg-22.jpg&quot;) center/cover;">
     <img src="<?= base_url() ?>assets/main_theme/img/bg-22.jpg" class="mw-100" alt="" style="display: none;">
 </figure>
 <div class="container-fluid top-80 mb-4">
     <div class="card shadow-sm border-0 bg-white">
         <div class="card-header d-flex justify-content-between">
             <h4 class="title fs-5 mb-0">Profile</h4>
             <div class="d-flex justify-content-between align-items-center gap-2">
                 <div class="month-nav">
                     <button id="prevMonth"><i class="bi bi-chevron-left"></i></button>
                     <span class="month-label" id="monthLabel" style="cursor: pointer;" title="Pilih Bulan & Tahun">Maret 2026</span>
                     <input type="hidden" id="filter_month" name="filter_month" value="<?= date('Y-m') ?>">
                     <button id="nextMonth"><i class="bi bi-chevron-right"></i></button>
                 </div>
                 <select name="user_id" id="user_id" class="form-select" style="min-height: 36px;min-width: 250px;">
                     <option value="">Pilih Karyawan</option>
                     <option value="<?= $this->session->userdata('user_id') ?>"><?= $this->session->userdata('nama') ?></option>
                 </select>
             </div>
         </div>
         <div class="card-body">
             <div class="row align-items-start">
                 <div class="col-auto position-relative employee-photo">
                     <figure class="avatar avatar-160 coverimg rounded-circle shadow-md border-3 border-light employee-avatar-figure" style="background-image: url(&quot;<?= base_url() ?>assets/main_theme/img/user-1.jpg&quot;);">
                         <img id="employee-avatar" src="<?= base_url() ?>assets/main_theme/img/user-1.jpg" alt="" style="display: none;">
                     </figure>
                 </div>
                 <div class="col-12 col-md-4">
                     <h2 class="mb-1 text-dark fw-bold employee-name">Andre Kurniawan</h2>
                     <h5 class="text-primary mb-1 employee-position">IT Programmer</h5>
                     <p class="text-muted small mb-3 employee-overall-kpi">98.00% Overall KPI</p>
                     <div class="d-flex gap-2 mb-3 employee-companies">
                         <div class="company-badge rounded-pill d-flex align-items-center bg-white border px-3 py-1 shadow-sm">
                             <div class="badge-logo me-2"><i class="bi bi-circle-fill text-primary small"></i></div>
                             <span class="small fw-semibold text-dark text-nowrap">Company RSP</span>
                         </div>
                         <div class="company-badge rounded-pill d-flex align-items-center bg-white border px-3 py-1 shadow-sm">
                             <div class="badge-logo me-2 bg-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 20px; height: 20px;"><i class="bi bi-star-fill text-warning fs-10" style="font-size: 8px;"></i></div>
                             <span class="small fw-semibold text-dark text-nowrap">BT Trusmi</span>
                         </div>
                     </div>
                 </div>
                 <div class="col-12 col-md">
                     <div class="stats-grid-container">
                         <div class="row g-3">
                             <div class="col-4">
                                 <div class="stat-item">
                                     <div class="stat-value" id="overall-kpi"></div>
                                     <div class="stat-label">Capaian KPI Keseluruhan</div>
                                 </div>
                             </div>
                             <div class="col-4">
                                 <div class="stat-item">
                                     <div class="stat-value" id="total-tasklist"></div>
                                     <div class="stat-label">Total Tasklist</div>
                                 </div>
                             </div>
                             <div class="col-4">
                                 <div class="stat-item">
                                     <div class="stat-value" id="total-kehadiran"></div>
                                     <div class="stat-label">Total Kehadiran</div>
                                 </div>
                             </div>
                             <div class="col-4">
                                 <div class="stat-item">
                                     <div class="stat-value" id="total-alfa"></div>
                                     <div class="stat-label">Total Alfa</div>
                                 </div>
                             </div>
                             <div class="col-4">
                                 <div class="stat-item">
                                     <div class="stat-value" id="total-telat"></div>
                                     <div class="stat-label">Total Datang Telat</div>
                                 </div>
                             </div>
                             <div class="col-4">
                                 <div class="stat-item">
                                     <div class="stat-value" id="total-ijin"></div>
                                     <div class="stat-label">Total Ijin</div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <div class="container-fluid mb-4">
     <div class="card shadow-sm border-0">
         <div class="card-header">
             <h4 class="title fs-5 mb-0">Capaian Progres Anda</h4>
         </div>
         <div class="card-body ps-4 pe-4">
             <div class="container">
                 <div class="row g-4 mb-3">
                     <div class="col-12 col-sm-6 col-lg-3">
                         <div class="progress-card-item">
                             <div class="progress-card-header mb-2">
                                 <span class="progress-card-label">%Leadtime</span>
                                 <span class="progress-card-value text-success" id="leadtime-percent">90%</span>
                             </div>
                             <div class="progress-bar-container">
                                 <div class="progress-bar-fill bg-success" style="width: 90%;" id="leadtime-progress"></div>
                             </div>
                         </div>
                     </div>
                     <div class="col-12 col-sm-6 col-lg-3">
                         <div class="progress-card-item">
                             <div class="progress-card-header mb-2">
                                 <span class="progress-card-label">%Achievement</span>
                                 <span class="progress-card-value text-warning" id="achievement-percent">50%</span>
                             </div>
                             <div class="progress-bar-container">
                                 <div class="progress-bar-fill bg-warning" style="width: 50%;" id="achievement-progress"></div>
                             </div>
                         </div>
                     </div>
                     <div class="col-12 col-sm-6 col-lg-3">
                         <div class="progress-card-item">
                             <div class="progress-card-header mb-2">
                                 <span class="progress-card-label">Tasklist Done</span>
                                 <span class="progress-card-value text-danger" id="tasklist-summary">
                                     <span id="tasklist-done">2</span><span class="text-muted fw-normal fs-xs">/<span id="tasklist-total">20</span> Total</span>
                                 </span>
                             </div>
                             <div class="progress-bar-container">
                                 <div class="progress-bar-fill bg-danger" style="width: 10%;" id="tasklist-progress"></div>
                             </div>
                         </div>
                     </div>
                     <div class="col-12 col-sm-6 col-lg-3">
                         <div class="progress-card-item">
                             <div class="progress-card-header mb-2">
                                 <span class="progress-card-label">Ticket Done</span>
                                 <span class="progress-card-value text-success" id="ticket-summary">
                                     <span id="ticket-done">15</span><span class="text-muted fw-normal fs-xs">/<span id="ticket-total">20</span> Total</span>
                                 </span>
                             </div>
                             <div class="progress-bar-container">
                                 <div class="progress-bar-fill bg-success" style="width: 75%;" id="ticket-progress"></div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <div class="container-fluid mb-4">
     <div class="card shadow-sm border-0">
         <div class="card-header">
             <h4 class="title fs-5 mb-0">Project Management</h4>
         </div>
         <div class="card-body">
             <ul class="nav nav-tabs nav-tabs-custom mb-3" id="projectManagementTabs" role="tablist">
                 <li class="nav-item" role="presentation">
                     <a class="nav-link tabs_btn" id="overview-tab" href="javascript:void(0)" onclick="switchTab('tabs', 'overview')" data-tab-value="overview" data-value="overview"><i class="bi bi-grid-1x2 me-2"></i>Overview</a>
                 </li>
                 <li class="nav-item" role="presentation">
                     <a class="nav-link tabs_btn" id="tasklist-project-tab" href="javascript:void(0)" onclick="switchTab('tabs', 'tasklist_project')" data-tab-value="tasklist-project" data-value="tasklist-project"><i class="bi bi-journal-check me-2"></i>Tasklist Project</a>
                 </li>
                 <li class="nav-item" role="presentation">
                     <a class="nav-link tabs_btn" id="tasklist_ticket-tab" href="javascript:void(0)" onclick="switchTab('tabs', 'tasklist_ticket')" data-tab-value="tasklist_ticket" data-value="tasklist_ticket"><i class="bi bi-ticket-perforated me-2"></i>Tasklist Ticket</a>
                 </li>
                 <li class="nav-item" role="presentation">
                     <a class="nav-link tabs_btn" id="tasklist_problem-tab" href="javascript:void(0)" onclick="switchTab('tabs', 'tasklist_problem')" data-tab-value="tasklist_problem" data-value="tasklist_problem"><i class="bi bi-exclamation-triangle me-2"></i>Tasklist Problem</a>
                 </li>
                 <li class="nav-item" role="presentation">
                     <a class="nav-link tabs_btn" id="kpi-tab" href="javascript:void(0)" onclick="switchTab('tabs', 'kpi')" data-tab-value="kpi" data-value="kpi"><i class="bi bi-speedometer2 me-2"></i>KPI</a>
                 </li>
             </ul>
             <div class="tab-content" id="tabs_content">

             </div>
         </div>
     </div>
 </div>