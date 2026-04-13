<div class="col-12 col-md-3 col-lg-3 col-xxl-3 mb-3" style="margin-right: -10px;">
    <div class="card bg-light" style="border-radius: 25px;">
        <div class="card-header" style="border-radius: 25px 25px 0 0;">
            <div class="row align-items-center d-flex justify-content-between">
                <div class="col col-sm-auto" style="margin-right: -10px;">
                    <h6 class="mb-0">
                        Resume HR
                    </h6>

                </div>
            </div>
        </div>
        <div class="card-body" style="border-radius: 0 0 25px 25px;">
            <div class="row">
                <div class="col-6 px-1">
                    <div class="row">
                        <div class="col-12 text-center">
                            <span class="badge bg-light-blue text-dark"><i class="bi bi-person-up"></i> Recruitment</span>

                        </div>
                        <div class="col-12 mt-1">
                            <div class="row">
                                <div class="col-6" align="right">
                                    <small class="text-secondary" style="font-size: 10px;">Sales : </small>
                                </div>
                                <div class="col-6">
                                    <span class="badge bg-secondary" id="jumlah_sales">0</span>
                                </div>
                            </div>

                        </div>
                        <div class="col-12 mt-2">
                            <p class="text-secondary text-center small">Pemenuhan Sales</p>
                        </div>
                        <div class="col-12 mt-1">
                            <div class="row ">
                                <div class="col-auto text-center">
                                    <span class="badge bg-secondary" id="persen_sales">0%</span>
                                </div>
                                <div class="col text-center">
                                    <p class="text-secondary fw-bold small" id="pemenuhan_sales">0/0</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <p class="text-secondary text-center small">Leadtime</p>
                        </div>
                        <div class="col-12 mt-1">
                            <div class="row">
                                <div class="col">
                                    <div id="div_recruit_pie" style="height: 80px !important;">
                                        <canvas id="recruit_pie"></canvas>
                                    </div>
                                </div>
                                <div class="col">
                                    <p style="font-size: 8px;" class="mb-1"><i class="bi bi-circle-fill text-success"></i> Ontime</p>
                                    <p style="font-size: 8px;" class="mb-1"><i class="bi bi-circle-fill text-danger"></i> Late</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-6  px-1" style="border-left: 0.5px solid grey">
                    <div class="row">
                        <div class="col-12 text-center">
                            <span class="badge bg-light-blue text-dark"><i class="bi bi-book"></i> Training</span>
                        </div>
                        <div class="col-12 mt-1">
                            <div class="row">
                                <div class="col-6" align="right">
                                    <small class="text-secondary" style="font-size: 10px;">Training : </small>
                                </div>
                                <div class="col-6">
                                    <span class="badge bg-secondary" id="jumlah_training">0</span>
                                </div>
                            </div>

                        </div>
                        <div class="col-12 mt-2">
                            <div class="row">
                                <div class="col-6">
                                    <div id="div_training_pretest" style="height: 80px !important;">
                                        <canvas id="training_pretest"></canvas>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <span class="badge bg-secondary" id="rasio_training">0%</span>
                                    <p class="text-secondary text-center small">Ratio</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-1">
                            <div class="row">
                                <div class="col-6">

                                    <p class="text-secondary text-center small">Top</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-secondary text-center small">Low</p>

                                </div>
                            </div>
                            <div class="row" id="row_deparment">
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-hover" id="table_resume_hr" style="white-space: nowrap;" nowrap>
                            <thead>
                                <tr>
                                    <th class="small" nowrap>Training</th>
                                    <th class="small" nowrap>Actual</th>
                                    <th class="small" nowrap>Lulus</th>
                                    <th class="small" nowrap>Pretest</th>
                                    <th class="small" nowrap>Postest</th>
                                    <th class="small" nowrap>Rasio</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>