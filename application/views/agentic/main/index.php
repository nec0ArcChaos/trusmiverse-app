<main class="main mainheight" style="margin-top:70px">
    <div class="container-fluid mb-4">
        <div class="row pt-4 pb-2 justify-content-between">
            <div class="col">
                <h3>Dashboard Analisa Agentic AI <?= in_array($tipe_agentic, ['crm']) ? strtoupper(str_replace('_', ' ', $tipe_agentic)) : ucwords(str_replace('_', ' ', $tipe_agentic)) ?> </h3>
                <span class="text-muted small"><?= date('D, d F Y') ?></span>
            </div>
            <div class="col-3">
                <select name="tipe_agentic" class="form-control px-3 border-custom border-1" id="tipe_agentic" style="min-width: 280px;">
                    <?php foreach ($tipe_agentics as $tipe): ?>
                        <option value="<?= $tipe ?>" <?= ($tipe == $tipe_agentic ) ? 'selected' : '' ?>><?= in_array($tipe, ['crm']) ? strtoupper(str_replace('_', ' ', $tipe)) : ucwords(str_replace('_', ' ', $tipe)) ?></option>
                    <?php endforeach; ?>
                </select> 
            </div>
        </div>
        <?php
        if ($tipe_agentic == 'project_housing') {
            $this->load->view('agentic/main/header/project_housing');
        } elseif ($tipe_agentic == 'booking') {
            $this->load->view('agentic/main/header/booking');
        } elseif ($tipe_agentic == 'sp3k') {
            $this->load->view('agentic/main/header/sp3k');
        } elseif ($tipe_agentic == 'akad') {
            $this->load->view('agentic/main/header/akad');
        } elseif ($tipe_agentic == 'drbm') {
            $this->load->view('agentic/main/header/drbm');
        } elseif ($tipe_agentic == 'plan_infra') {
            $this->load->view('agentic/main/header/plan_infra');
        } elseif ($tipe_agentic == 'plan_housing') {
            $this->load->view('agentic/main/header/plan_housing');
        } elseif ($tipe_agentic == 'crm') {
            $this->load->view('agentic/main/header/crm');
        } elseif ($tipe_agentic == 'pemberkasan') {
            $this->load->view('agentic/main/header/pemberkasan');
        } elseif ($tipe_agentic == 'proses_bank') {
            $this->load->view('agentic/main/header/proses_bank');
        } elseif ($tipe_agentic == 'purchasing') {
            $this->load->view('agentic/main/header/purchasing');
        } elseif ($tipe_agentic == 'aftersales') {
            $this->load->view('agentic/main/header/aftersales');
        } elseif ($tipe_agentic == 'qc') {
            $this->load->view('agentic/main/header/qc');
        } elseif ($tipe_agentic == 'perencana') {
            $this->load->view('agentic/main/header/perencana');
        } else {
            $this->load->view('agentic/main/header/project_housing');
        }
        ?>
        <div class="row mb-4">
            <div class="col-12 col-md-8 col-lg-8 mb-2">
                <div class="glass-card w-100">
                    <div class="row justify-content-between align-items-top">
                        <div id="kpi">

                        </div>
                        <input type="hidden" id="kpi_id">


                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4 col-md-4 mb-2">
                <div class="glass-card w-100">
                    <div class="row justify-content-between align-items-center ">
                        <div class="col">
                            <h5>Kesehatan KPI</h5>
                            <div class="kesehatan-kpi" id="kesehatan_kpi">

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12 col-lg-6">
                <div class="glass-card w-100">
                    <div class="row justify-content-between align-items-center">
                        <div class="col">
                            <h5>Analisa Sistem</h5>
                            <div class="card border-1 broder-dark bg-none rounded-3 shadow-none">
                                <div class="card-body rounded-3">
                                    <ul class="custom-list">
                                        <div id="analisa_sistem">

                                        </div>
                                    </ul>

                                </div>
                            </div>
                            <hr>
                            <h5>Governance & Leadership Check</h5>
                            <div class="row">
                                <div id="governance">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="glass-card w-100">
                    <div class="row justify-content-between align-items-center">
                        <div class="col">
                            <h5>4M Analisa</h5>
                            <div class="row">
                                <div class="col mb-2">
                                    <div class="card border-1 broder-dark bg-none rounded-3 shadow-none">
                                        <div class="card-body rounded-3">
                                            <span
                                                class="badge bg-light-blue small px-1 fw-bold text-dark rounded-5 me-2 h6">
                                                <div class="avatar avatar-20 rounded-5 bg-white">
                                                    <i class="bi bi-gear-fill"></i>
                                                </div> <span class="px-2">4M Machine</span>
                                            </span>
                                            <ul class="custom-list">
                                                <div id="4_machine">

                                                </div>


                                            </ul>

                                        </div>
                                    </div>
                                </div>
                                <div class="col mb-2">
                                    <div class="card border-1 broder-dark bg-none rounded-3 shadow-none">
                                        <div class="card-body rounded-3">
                                            <span
                                                class="badge bg-light-yellow small px-1 fw-bold text-dark rounded-5 me-2 h6">
                                                <div class="avatar avatar-20 rounded-5 bg-white">
                                                    <i class="bi bi-cash"></i>
                                                </div>
                                                <span class="px-2">4M Money</span>
                                            </span>
                                            <ul class="custom-list">
                                                <div id="4_money">

                                                </div>
                                            </ul>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col mb-2">
                                    <div class="card border-1 broder-dark bg-none rounded-3 shadow-none">
                                        <div class="card-body rounded-3">
                                            <span
                                                class="badge bg-light-purple small px-1 fw-bold text-dark rounded-5 me-2 h6">
                                                <div class="avatar avatar-20 rounded-5 bg-white">
                                                    <i class="bi bi-people"></i>
                                                </div>
                                                <span class="px-2">4M Man</span>
                                            </span>
                                            <ul class="custom-list">
                                                <div id="4_man">

                                                </div>

                                            </ul>

                                        </div>
                                    </div>
                                </div>
                                <div class="col mb-2">
                                    <div class="card border-1 broder-dark bg-none rounded-3 shadow-none">
                                        <div class="card-body rounded-3">
                                            <span
                                                class="badge bg-light-red small px-1 fw-bold text-dark rounded-5 me-2 h6">
                                                <div class="avatar avatar-20 rounded-5 bg-white">
                                                    <i class="bi bi-box"></i>
                                                </div> <span class="px-2">4M Material</span>
                                            </span>
                                            <ul class="custom-list">
                                                <div id="4_material">

                                                </div>

                                            </ul>

                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row mb-4">
            <div class="col-12">
                <div class="glass-card w-100">
                    <h5>Timeline Action & Tracking</h5>
                    
                    <!-- <div class="row">
                        <div class="col-md-12"></div>

                        <div class="col-auto">
                            <div class="input-group">

                                <button type="button" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-calendar-week"></i>
                                    <span id="weekText">Week</span>
                                </button>
                                <ul class="dropdown-menu" id="week-list"></ul>

                                <button type="button" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span id="statusText">Status Plan</span>
                                </button>
                                <ul class="dropdown-menu" id="status_plan-list">
                                    <li value="-- All Status --">-- All Status --</li>
                                    <li value="Waiting">Waiting</li>
                                    <li value="Take">Take</li>
                                    <li value="Reject">Reject</li>
                                </ul>

                            </div>
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-info float-end" id="btn_add_task" onclick="add_task_head()"> Add Strategi</button>
                        </div>
                    </div> -->

                    <div class="row align-items-center mb-3">

                        <div class="col-12 d-flex justify-content-end">
                            <div class="btn-group gap-2">

                                <!-- WEEK -->
                                <div class="dropdown">
                                    <button type="button"
                                        class="btn btn-outline-dark dropdown-toggle"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="bi bi-calendar-week"></i>
                                        <span id="weekText">All Week</span>
                                    </button>
                                    <ul class="dropdown-menu" id="week-list"></ul>
                                </div>

                                <!-- STATUS PLAN -->
                                <div class="dropdown">
                                    <button type="button"
                                        class="btn btn-outline-dark dropdown-toggle"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <span id="statusText">All Status</span>
                                    </button>

                                    <ul class="dropdown-menu" id="p_status-list">
                                        <li>
                                            <button class="dropdown-item active" data-status="">
                                                All Status
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item" data-status="Waiting">
                                                Waiting
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item" data-status="Take">
                                                Take
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item" data-status="Reject">
                                                Reject
                                            </button>
                                        </li>
                                    </ul>

                                </div>

                                <!-- ADD STRATEGI -->
                                <button class="btn btn-info" id="btn_add_task" onclick="add_task_head()">
                                    <i class="bi bi-plus-circle"></i> Add Strategi
                                </button>

                            </div>
                        </div>

                    </div>
                    
                    <br>
                    
                    <div class="table-responsive">
                        <table id="data_timeline" class="table">
                            <thead>
                                <tr>
                                    <th>By</th>
                                    <th>RM</th>
                                    <th>Problem</th>
                                    <th>Rencana & Deskripsi</th>
                                    <th>Catatan</th>
                                    <th>Status Plan</th>
                                    <th>Created at</th>
                                    <th>Week</th>
                                    <th>Owner & Due Date</th>
                                    <th>PIC</th>
                                    <th>Status Aktual</th>
                                </tr>
                            </thead>
                            <!-- TBODY SEKARANG KOSONG, AKAN DIISI OLEH JAVASCRIPT -->
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12 col-lg-4 mb-2">
                <div class="glass-card w-100">

                    <span class="badge bg-light-cyan small px-1 fw-bold text-dark rounded-5 me-2 h6">
                        <div class="avatar avatar-20 rounded-5 bg-white">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <span class="px-2">Rule & Consequence</span>
                    </span>
                    <ul class="custom-list">
                        <div id="rule">

                        </div>

                    </ul>
                </div>
            </div>
            <div class="col-12 col-lg-4 mb-2">
                <div class="glass-card w-100">

                    <span class="badge bg-light-yellow small px-1 fw-bold text-dark rounded-5 me-2 h6">
                        <div class="avatar avatar-20 rounded-5 bg-white">
                            <i class="bi bi-trophy"></i>
                        </div>
                        <span class="px-2">Reward</span>
                    </span>
                    <ul class="custom-list">
                        <div id="reward">

                        </div>


                    </ul>
                    <!-- <div class="row justify-content-between align-items-center">
                        <div class="col">
                            <p class="text-muted">Status Bonus : </p>

                        </div>
                        <div class="col-auto">
                            <span class="badge bg-light-red text-dark h6">Belum Memenuhi</span>
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="col-12 col-lg-4 mb-2">
                <div class="glass-card w-100">

                    <span class="badge bg-light-red small px-1 fw-bold text-dark rounded-5 me-2 h6">
                        <div class="avatar avatar-20 rounded-5 bg-white">
                            <i class="bi bi-trophy"></i>
                        </div>
                        <span class="px-2">Teknologi, CCP & Akuntabilitas</span>
                    </span>
                    <ul class="custom-list">
                        <div id="teknologi">

                        </div>


                    </ul>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="glass-card w-100">
                    <h5>Ringkasan Esklusif</h5>
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <p>Status KPI</p>
                            <div id="summary_kpi">

                                <!-- <div class="card border-1 broder-dark bg-none rounded-3 shadow-none">
                                    <div class="card-body rounded-3">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col">
                                                <p>Ontime</p>
                                            </div>
                                            <div class="col-auto">
                                                <p>65%</p>
                                            </div>
                                        </div>
                                        <div class="progress mb-3" style="height: 10px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 80%;"
                                                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                            <div class="progress-bar bg-secondary" role="progressbar" style="width: 0%;"
                                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <p>Resiko Kritis</p>
                            <div class="card border-1 broder-dark bg-none rounded-3 shadow-none">
                                <div class="card-body rounded-3">
                                    <ul class="custom-list">
                                        <div id="summary_risk">

                                        </div>
                                        <!-- <li class="mb-2">
                                            <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                                            <span class="text-dark">Material pasir kosong</span>
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                                            <span class="text-dark">MPP < 70%</span>
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                                            <span class="text-dark">Cuaca ganggu 20% jadwal</span>
                                        </li> -->

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <p>Fokus Minggu Ini</p>
                            <div class="card border-1 broder-dark bg-none rounded-3 shadow-none">
                                <div class="card-body rounded-3">
                                    <ul class="custom-list">
                                        <div id="summary_focus">

                                        </div>
                                        <!-- <li class="mb-2">
                                            <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                                            <span class="text-dark">Tambahan 5 tukang (deadline 25/08)</span>
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                                            <span class="text-dark">Mitigasi banjir & percepat kirim pasir</span>
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                                            <span class="text-dark">Implementasi shift pagi</span>
                                        </li> -->

                                    </ul>
                                </div>
                            </div>
                        </div>
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

<div class="modal fade" id="modal_take_tasklist_add" role="dialog">
    <div class="modal-dialog center">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Strategi </h4>
                <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button"
                    aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <form id="form_add_task">
                <input type="hidden" name="kpi_id" id="kpi_id_add" value="">
                <div class="modal-body">
                    <!-- <div class="form-group mb-2 position-relative check-valid">
                        <label>Rencana & Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi_add" class="form-control border-custom"></textarea>
                    </div> -->
                    <div class="row">
                        <hr>
                        <div class="col-12 mb-2">
                            <div class="form-group mb-1 position-relative check-valid">
                                <label>Goals <b class="text-danger small">*</b></label>
                                <textarea name="goal" id="goal_add" class="form-control border-custom"></textarea>
                            </div>
                        </div>

                        <div class="col-12 mb-2">
                            <div class="form-group mb-1 position-relative check-valid">
                                <label>Problem </label>
                                <textarea name="problem" id="problem_add" class="form-control border-custom"></textarea>
                            </div>
                        </div>

                        <div class="col-12 mb-2">
                            <div class="form-group mb-1 position-relative check-valid">
                                <label>Poin KPI</label>
                                <textarea name="poin_kpi" id="poin_kpi_add" class="form-control border-custom"></textarea>
                            </div>
                        </div>

                        <div id="kpi_detail_wrapper" style="display:none;">
                            <!-- <div class="col-12 mb-2">
                                <div class="form-group mb-1 position-relative check-valid">
                                    <label>Target Corporate <b class="text-danger">*</b></label>
                                    <textarea name="target_corporate" id="target_corporate_add"
                                        class="form-control border-custom"></textarea>
                                </div>
                            </div>

                            <div class="col-12 mb-2">
                                <div class="form-group mb-1 position-relative check-valid">
                                    <label>Actual Corporate <b class="text-danger">*</b></label>
                                    <textarea name="actual_corporate" id="actual_corporate_add"
                                        class="form-control border-custom"></textarea>
                                </div>
                            </div> -->

                            <div class="col-12 mb-2">
                                <div class="form-group mb-1 position-relative check-valid">
                                    <label>Target Value <b class="text-danger">*</b></label>
                                    <textarea name="target_value" id="target_value_add"
                                        class="form-control border-custom"></textarea>
                                </div>
                            </div>

                            <div class="col-12 mb-2">
                                <div class="form-group mb-1 position-relative check-valid">
                                    <label>Actual Value <b class="text-danger">*</b></label>
                                    <textarea name="actual_value" id="actual_value_add" class="form-control border-custom"></textarea>
                                </div>
                            </div>

                            <!-- <div class="col-12 mb-2">
                                <div class="form-group mb-1 position-relative check-valid">
                                    <label>Target Persentase <b class="text-danger">*</b></label>
                                    <textarea name="target_persentase" id="target_persentase_add" class="form-control border-custom"></textarea>
                                </div>
                            </div> -->
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
                                <select name="pic[]" multiple class="form-control border-custom" id="pic_add">
                                    <option value="">-- Pilih PIC --</option>
                                    <?php foreach ($pic as $item): ?>
                                        <option value="<?= $item->user_id ?>"><?= $item->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 mb-2">
                            <div class="form-group mb-1 position-relative check-valid">
                                <label>Kategori <b class="text-danger small">*</b></label>
                                <select name="kategori" id="kategori" class="form-control border-custom">
                                    <option value="" selected disabled>-- Pilih --</option>
                                    <option value="1">Timeline Action & Tracking</option>
                                    <option value="2">Rule & Consequence</option>
                                    <option value="3">Reward</option>
                                    <option value="4">Teknologi, CCP & Akuntabilitas</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 mb-2 d-none" id="wrapper_rule_consequence">
                            <div class="form-group mb-1 position-relative check-valid">
                                <label>Tipe Rule & Consequence <b class="text-danger small">*</b></label>
                                <select name="tipe_rule_consequence" id="tipe_rule_consequence" class="form-control border-custom">
                                    <option value="" selected disabled>-- Pilih --</option>
                                    <option value="surat_teguran">Surat Teguran</option>
                                    <option value="lock_absen">Lock Absen</option>
                                    <option value="denda">Denda</option>
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

<div class="modal fade" id="modal_take_denda_reward" role="dialog">
    <div class="modal-dialog center">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Take Consequence And Reward</h4>
                <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button"
                    aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <form id="form_take_denda_reward">
                <div class="modal-body">

                    <div class="form-group mb-2 position-relative check-valid">
                        <label>Rencana & Deskripsi</label>
                        <input type="text" class="form-control hidden id_db" name="id" readonly value="">
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
                            <div class="form-group mb-1 check-valid">
                                <label>Tipe <b class="text-danger small">*</b></label>
                                <select name="tipe" class="form-control border-custom tipe_consequence" readonly disabled>
                                    <option value="Denda">Denda</option>
                                    <option value="Reward">Reward</option>
                                </select>
                            </div>

                        </div>
                        <div class="col-12 mb-2">
                            <div class="form-group mb-1 check-valid">
                                <label>Reason <b class="text-danger small">*</b></label>
                                <textarea name="reason" class="form-control border-custom deskripsi" rows="3"></textarea>
                            </div>

                        </div>
                        <div class="col-12 mb-2">
                            <div class="form-group mb-1 check-valid">
                                <label>Employee<b class="text-danger small">*</b></label>
                                <select name="employee[]" multiple class="form-control border-custom employee">
                                    <option value="">-- Pilih --</option>
                                    <?php foreach ($pic as $item): ?>
                                        <option value="<?= $item->user_id ?>"><?= $item->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
                        <div class="col mb-2">
                            <div class="form-group mb-1 check-valid">
                                <label>Nominal <b class="text-danger small">*</b></label>
                                <input type="number" name="nominal" class="form-control border-custom">
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
<div class="modal fade" id="modal_take_warning" role="dialog">
    <div class="modal-dialog center">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Take Warning Letter</h4>
                <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button"
                    aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <form id="form_take_warning">
                <div class="modal-body">

                    <div class="form-group mb-2 position-relative check-valid">
                        <label>Rencana & Deskripsi</label>
                        <input type="text" class="form-control hidden id_db" name="id" readonly value="">
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
                            <div class="form-group mb-1 check-valid">
                                <label>Warning to Employee<b class="text-danger small">*</b></label>
                                <select name="employee" class="form-control border-custom employee">
                                    <option value="">-- Pilih --</option>
                                    <?php foreach ($pic as $item): ?>
                                        <option value="<?= $item->user_id ?>" data-company_id="<?= $item->company_id ?>"><?= $item->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
                        <div class="col-12 mb-2">
                            <div class="form-group mb-1 check-valid">
                                <label>Warning Type <b class="text-danger small">*</b></label>

                                <select name="warning_type" class="form-control border-custom">
                                    <option value="#" selected="" disabled="">-- Choose Warning Type --</option>
                                    <option value="1">Surat Teguran ( ST )</option>
                                    <option value="2">Surat Peringatan Satu ( SP1 )</option>
                                    <option value="3">Surat Peringatan Dua ( SP2 )</option>
                                    <option value="4">Surat Peringatan Tiga ( SP3 )</option>
                                    <option value="5">Surat Pemutusan Hubungan Kerja (SPHK)</option>
                                </select>
                            </div>

                        </div>
                        <div class="col-12 mb-2">
                            <div class="form-group mb-1 check-valid">
                                <label>Result Investigation <b class="text-danger small">*</b></label>
                                <textarea name="result_investigation" class="form-control border-custom deskripsi" rows="3">
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="form-group mb-1 check-valid">
                                <label>Corrective Action <b class="text-danger small">*</b></label>
                                <textarea name="corrective" class="form-control border-custom"></textarea>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="form-group mb-1 check-valid">
                                <label>Another Note <b class="text-danger small">*</b></label>
                                <textarea name="another_note" class="form-control border-custom"></textarea>
                            </div>
                        </div>

                        <div class="col mb-2">
                            <div class="form-group mb-1 check-valid">
                                <label>Subject <b class="text-danger small">*</b></label>
                                <input type="text" name="subject" class="form-control border-custom">
                            </div>
                        </div>
                        <div class="col mb-2">
                            <div class="form-group mb-1 check-valid">
                                <label>Warning Date <b class="text-danger small">*</b></label>
                                <input type="date" name="warning_date" class="form-control border-custom">
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
<div class="modal fade" id="modal_take_lock" role="dialog">
    <div class="modal-dialog center">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Take Lock Absen Manual</h4>
                <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button"
                    aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <form id="form_take_lock">
                <div class="modal-body">

                    <div class="form-group mb-2 position-relative check-valid">
                        <label>Rencana & Deskripsi</label>
                        <input type="text" class="form-control hidden id_db" name="id" readonly value="">
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
                            <div class="form-group mb-1 check-valid">
                                <label>Reason <b class="text-danger small">*</b></label>
                                <textarea name="reason" class="form-control border-custom deskripsi" rows="3"></textarea>
                            </div>

                        </div>
                        <div class="col-12 mb-2">
                            <div class="form-group mb-1 check-valid">
                                <label>Lock to Employee<b class="text-danger small">*</b></label>
                                <select name="employee[]" multiple class="form-control border-custom employee">
                                    <option value="">-- Pilih --</option>
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


<style>
    #week-list {
        max-height: 280px;
        /* Atur tinggi maksimal dropdown */
        overflow-y: auto;
        /* Tampilkan scrollbar vertikal jika perlu */
    }
</style>
<ul class="dropdown-menu" id="week-list">
    <?php
        $week = [
            'Week 1',
            'Week 2',
            'Week 3',
            'Week 4',
            'Week 5',
        ];
    ?>
</ul>