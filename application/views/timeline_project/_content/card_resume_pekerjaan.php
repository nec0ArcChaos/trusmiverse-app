<div class="col-12 col-md-6 col-lg-6 col-xxl-3 mb-3" style="margin-right: -10px;">
    <div class="card bg-light" style="border-radius: 25px;">
        <div class="card-header" style="border-radius: 25px 25px 0 0;">
            <div class="row align-items-center d-flex justify-content-between">
                <div class="col col-sm-auto" style="margin-right: -10px;">
                    <h6 class="mb-0">
                        Pekerjaan <span class="fw-bold text-success small">+2% bln lalu</span>
                    </h6>

                </div>
                <div class="col" align="right">

                    <p class="fw-bold text-success h5" id="t_all_progres">0%</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                </div>
                <!-- <div class="col" align="right">
                    <span class="badge bg-white text-dark" style="border: 1px solid #ddd; border-radius: 10px; height: 37px;">
                        <form method="POST" id="form_filter">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control month_aktivitas px-2" style="cursor: pointer; width: 70px; border: none;" id="titlecalendar" placeholder="11-2024">
                                <span class="input-group-text bg-transparent border-0">
                                    <i class="bi bi-calendar-event"></i>
                                </span>
                            </div>
                        </form>
                    </span>
                </div> -->
            </div>
        </div>
        <div class="card-body" style="border-radius: 0 0 25px 25px;">
            <div class="row">
                <div class="col-12 col-lg-7 col-sm-12">
                    <div class="row mt-2">
                        <div class="col-6">
                            <div class="" id="div_pekerjaan_pie" style="width: 65px;"></div>
                        </div>
                        <div class="col-6" style="border-right: 0.5px solid grey;">
                            <div class="row mt-1">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6 p-0">
                                            <p style="font-size: 8px;" class="mb-1"><i class="bi bi-circle-fill text-success"></i> Done</p>
                                            <p style="font-size: 8px;" class="mb-1"><i class="bi bi-circle-fill text-warning"></i> Working</p>
                                            <p style="font-size: 8px;" class="mb-1"><i class="bi bi-circle-fill text-danger"></i> Cancel</p>
                                            <p style="font-size: 8px;" class="mb-1"><i class="bi bi-circle-fill text-secondary"></i> Not Start</p>
                                        </div>
                                        <div class="col-6 p-0">
                                            <p style="font-size: 8px;" class="mb-1" id="d_status_done">0 (0%)</p>
                                            <p style="font-size: 8px;" class="mb-1" id="d_status_working_on">0 (0%)</p>
                                            <p style="font-size: 8px;" class="mb-1" id="d_status_cancel">0 (0%)</p>
                                            <p style="font-size: 8px;" class="mb-1" id="d_status_waiting">0 (0%)</p>

                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row mt-1">
                        <div class="col">
                            <div class="progress position-relative h-10">

                                <div class="progress-bar bg-success" id="p_ontime" style="width:50%;" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="50">
                                </div>
                                <div class="progress-bar bg-danger" id="p_late" style="width:50%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="small text-secondary" style="font-size: 10px;"><span id="t_ontime"></span>Ontime</p>
                        </div>
                        <div class="col">
                            <p class="small text-secondary" style="font-size: 10px;"><span id="p_leadtime">0/0</span></p>
                            
                        </div>
                        <div class="col" align="right">
                            <p class="small text-secondary" style="font-size: 10px;"><span id="t_late"></span>Late</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5 col-sm-12">
                    <div class="row">
                        <div class="col-12">
                            <p class="fw-bold text-secondary small">Progress</p>
                            <div class="" style="overflow-x: auto;">
                                <canvas id="div_progress" style="height: 80px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-7" style="border-right: 0.5px solid grey;">
                    <p class="fw-bold text-secondary small">Komplain</p>
                    <div class="" id="div_komplain" style="margin-top: -5px;">
                    </div>
                </div>
                <div class="col-5">
                    <p class="fw-bold text-secondary small">Leadtime</p>
                    <div class="" style="margin-top: 20px; overflow-x: auto;
            white-space: nowrap;">
                        <canvas id="div_leadtime" style="height: 80px;"></canvas>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>