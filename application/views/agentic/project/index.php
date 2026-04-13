<main class="main mainheight" style="margin-top:70px">
    <div class="container-fluid mb-4">
        <div class="row pt-4 pb-2">
            <div class="col">
                <h1>Dashboard Analisa Agentic AI</h1>
                <span class="text-muted small">Tuesday, September 29</span>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
            <div class="col">
                <span class="badge bg-light-blue small px-1 fw-bold text-dark rounded-5 me-2">
                    <div class="avatar avatar-20 rounded-5 bg-white">
                        <i class="bi bi-diagram-3"></i>
                    </div> Case: Project Housing - Unit <span id="label_project"></span>
                </span>
                <span class="badge bg-light-blue small px-1 fw-bold text-dark rounded-5 me-2">
                    <div class="avatar avatar-20 rounded-5 bg-white">
                        <i class="bi bi-person"></i>
                    </div> PIC <span id="label_pic"></span>
                </span>

            </div>
            <div class="col-auto">
                <?php 

                if($tipe_agetnci == 'project_housing'){

                }else{
                    
                    $this->load->view('agentic/main/_filter');
                }
                // if($tipe_agetnci == 'project_housing'){

                //     $this->load->view('agentic/main/_filter');
                // }
                // if($tipe_agetnci == 'project_housing'){

                //     $this->load->view('agentic/main/_filter');
                // }
                ?>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12 col-md-8 col-lg-8 mb-2">
                <div class="glass-card w-100">
                    <div class="row justify-content-between align-items-top">
                        <div id="kpi">

                        </div>



                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4 col-md-4 mb-2">
                <div class="glass-card w-100">
                    <div class="row justify-content-between align-items-center">
                        <div class="col">
                            <h5>Kesehatan KPI</h5>
                            <div id="kesehatan_kpi">

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
                    <div class="table-responsive">
                        <table id="data_timeline" class="table">
                            <thead>
                                <tr>
                                    <th>Rencana & Deskripsi</th>
                                    <th>Status Plan</th>
                                    <th>Owner & Due Date</th>
                                    <th>PIC</th>
                                    <th>Status Aktual</th>
                                    <th>Catatan</th>
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
                        <select name="action" class="form-control border-custom" id="action" required>
                            <option value="" selected disabled>-- Pilih Action --</option>
                            <option value="1">Take</option>
                            <option value="2">Reject</option>
                        </select>
                    </div>
                    <div class="row" id="row_take" style="display:none">
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