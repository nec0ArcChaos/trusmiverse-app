<div class="container-fluid">
    <div class="row gx-1">
        <!-- Faisal -->
        <?php $this->load->view('dashboard/to_do/nira_ai'); ?>
        <!-- End Faisal -->
        <div class="col-md-4 my-2">
            <div class="card">
                <div class="card-body" style="background: #f6fafd; min-height: 343px;">
                    <div class="card-title row">
                        <h5 class="col-9">Today Progress <span id="total_all_progress"></span></h5>
                        <div class="col-3">
                            <h4 class="float-end" id="total_all_progress_percent"></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col scrollable-column" style="max-height: 280px; overflow-y: auto;" id="row_progress">
                            <div class="row gx-1 gy-2" id="list_today_progress">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 my-2">
            <div class="card">
                <div class="card-body" style="background: #f6fafd; min-height: 343px;">
                    <h5 class="card-title">Lock Absent</h5>

                    <div class="progress h-20 mt-3">
                        <!-- Section 1 Tab -->
                        <div class="progress-bar progress-tab selected" id="progress_section_1" style="width:50%; background-color: #7D89B3; cursor: pointer;" role="progressbar" data-target="#section_running">
                            <span style="font-size: 12px; font-weight: bold;" class="progress-text" id="lock_run_count">Running (0)</span>
                        </div>
                        <!-- Section 2 Tab -->
                        <div class="progress-bar progress-tab" id="progress_section_2" style="width:50%; background-color: #ffffff; cursor: pointer;" role="progressbar" data-target="#section_history">
                            <span style="font-size: 12px; font-weight: bold;" class="progress-text" id="lock_his_count">History</span>
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content mt-3">
                        <!-- Section 1 Content -->
                        <div class="custom-pane active" id="section_running">
                            <div class="row">
                                <div class="col scrollable-column" style="max-height: 240px; overflow-y: auto;" id="row_running">
                                    <!-- <div class="card mb-2" style="border-radius: 10px;">
                                        <div class="card-body bg-super-soft-grey" style="border-radius: 15px; text-align: left;">
                                            <div class="row">
                                                <div class="col-6">
                                                    <span class="badge rounded-pill" style="background-color:#E6EAED;color:black;">
                                                        Tasklist IBR Pro
                                                    </span>
                                                    <span class="badge rounded-pill" style="background-color:#FFB2B2;color:#E11616;">
                                                        <i class="bi bi-lock-fill text-danger"></i> Locked
                                                    </span>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <span class="badge rounded-pill float-end" style="background-color:#FFFFFF; color:black; border: 0.5px solid grey;">
                                                        31 Mar 2025 <i class="bi bi-calendar"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-9">
                                                    <p class="fw-bold small mb-0 mt-2">
                                                        Strategy
                                                    </p>
                                                    <p class="text-dark small mb-0" style="font-size:13px">
                                                        Koordinasi Verifikasi IBR Pro (Deskripsi Tasklistnya)
                                                    </p>
                                                </div>
                                                <div class="col-3 text-end d-flex justify-content-end align-items-end">
                                                    <h5><a href="#"><i class="bi bi-arrow-right"></i></a></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-2" style="border-radius: 10px;">
                                        <div class="card-body bg-super-soft-grey" style="border-radius: 15px; text-align: left;">
                                            <div class="row">
                                                <div class="col-6">
                                                    <span class="badge rounded-pill" style="background-color:#E6EAED;color:black;">
                                                        Tasklist IBR Pro
                                                    </span>
                                                    <span class="badge rounded-pill" style="background-color:#FFB2B2;color:#E11616;">
                                                        <i class="bi bi-lock-fill text-danger"></i> Locked
                                                    </span>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <span class="badge rounded-pill float-end" style="background-color:#FFFFFF; color:black; border: 0.5px solid grey;">
                                                        31 Mar 2025 <i class="bi bi-calendar"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-9">
                                                    <p class="fw-bold small mb-0 mt-2">
                                                        Strategy
                                                    </p>
                                                    <p class="text-dark small mb-0" style="font-size:13px">
                                                        Koordinasi Verifikasi IBR Pro (Deskripsi Tasklistnya)
                                                    </p>
                                                </div>
                                                <div class="col-3 text-end d-flex justify-content-end align-items-end">
                                                    <h5><a href="#"><i class="bi bi-arrow-right"></i></a></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-2" style="border-radius: 10px;">
                                        <div class="card-body bg-super-soft-grey" style="border-radius: 15px; text-align: left;">
                                            <div class="row">
                                                <div class="col-6">
                                                    <span class="badge rounded-pill" style="background-color:#E6EAED;color:black;">
                                                        Tasklist IBR Pro
                                                    </span>
                                                    <span class="badge rounded-pill" style="background-color:#FFB2B2;color:#E11616;">
                                                        <i class="bi bi-lock-fill text-danger"></i> Locked
                                                    </span>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <span class="badge rounded-pill float-end" style="background-color:#FFFFFF; color:black; border: 0.5px solid grey;">
                                                        31 Mar 2025 <i class="bi bi-calendar"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-9">
                                                    <p class="fw-bold small mb-0 mt-2">
                                                        Strategy
                                                    </p>
                                                    <p class="text-dark small mb-0" style="font-size:13px">
                                                        Koordinasi Verifikasi IBR Pro (Deskripsi Tasklistnya)
                                                    </p>
                                                </div>
                                                <div class="col-3 text-end d-flex justify-content-end align-items-end">
                                                    <h5><a href="#"><i class="bi bi-arrow-right"></i></a></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <!-- Section 2 Content -->
                        <div class="custom-pane" id="section_history">
                            <div class="row">
                                <div class="col scrollable-column" style="max-height: 240px; overflow-y: auto;" id="row_history"></div>
                                <!-- <div class="card mb-2" style="border-radius: 10px;">
                                    <div class="card-body bg-super-soft-grey" style="border-radius: 15px; text-align: left;">
                                        <div class="row">
                                            <div class="col-6">
                                                <span class="badge rounded-pill" style="background-color:#E6EAED;color:black;">
                                                    Tasklist IBR Pro
                                                </span>
                                                <span class="badge rounded-pill" style="background-color:#FFB2B2;color:#E11616;">
                                                    <i class="bi bi-lock-fill text-danger"></i> Locked
                                                </span>
                                            </div>
                                            <div class="col-6 text-end">
                                                <span class="badge rounded-pill float-end" style="background-color:#FFFFFF; color:black; border: 0.5px solid grey;">
                                                    31 Mar 2025 <i class="bi bi-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <p class="fw-bold small mb-0 mt-2">
                                                    Strategy
                                                </p>
                                                <p class="text-dark small mb-0" style="font-size:13px">
                                                    Koordinasi Verifikasi IBR Pro (Deskripsi Tasklistnya)
                                                </p>
                                            </div>
                                            <div class="col-3 text-end d-flex justify-content-end align-items-end">
                                                <h5><a href="#"><i class="bi bi-arrow-right"></i></a></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>