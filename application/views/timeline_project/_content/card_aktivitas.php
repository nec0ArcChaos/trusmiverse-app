<div class="col-12 col-md-6 col-lg-6 col-xxl-3 mb-3" style="margin-right: 0px;">
    <div class="card bg-light" style="border-radius: 25px; margin-right: 0px;">
        <div class="card-header" style="border-radius: 25px 25px 0 0;">
            <div class="row align-items-center d-flex justify-content-between">
                <div class="col col-sm-auto" style="margin-right: -10px;">
                    <h6 class="mb-0">
                        Aktivitas
                    </h6>
                </div>
                <!-- <div class="col col-sm-auto">
                    <span class="badge bg-white text-dark" style="border: 1px solid #ddd; border-radius: 10px; height: 37px;">
                        <form method="POST" id="form_filter">
                            <div class="input-group input-group-sm">
                                <input type="text" 
                                    class="form-control month_aktivitas px-2" 
                                    style="cursor: pointer; width: 70px; border: none;" 
                                    id="titlecalendar" 
                                    placeholder="11-2024">
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
            <div class="row d-flex justify-content-between mb-2" style="margin-top: -5px;">
                <div class="col-8">
                    <div class="card" style="border-radius: 15px; margin-right: -7px;">
                        <div class="card-body" style="border-radius: 15px; background-color: #255CCD;">
                            <div class="row">
                                <div class="col-4 text-center" style="border-right: 1px solid white;">
                                    <p class="fw-bold text-white h5 mb-0" id="t_ibr">0</p>
                                    <p class="fw-bold text-white small" style="font-size: 12px;">IBR Pro</p>
                                </div>
    
                                <div class="col-4 px-1 py-0">
                                    <p class="text-white small mb-1" style="font-size:8px">
                                        Berhasil
                                    </p>
                                    <p class="text-white small mb-1" style="font-size:8px">
                                        Tdk Berhasil
                                    </p>
                                    <p class="text-white small mb-1" style="font-size:8px">
                                        Tdk Jalan
                                    </p>
                                    <p class="text-white small mb-1" style="font-size:8px">
                                        Progress
                                    </p>
                                    <p class="text-white small mb-1" style="font-size:8px">
                                        Blm Mulai
                                    </p>
                                </div>

                                <div class="col-4 px-1 py-0 text-end">
                                    <p class="text-white small mb-1" style="font-size:8px" id="d_ibr_jln_berhasil">
                                        0 (0%)
                                    </p>
                                    <p class="text-white small mb-1" style="font-size:8px" id="d_ibr_tdk_berhasil">
                                        0 (0%)
                                    </p>
                                    <p class="text-white small mb-1" style="font-size:8px" id="d_ibr_tdk_jalan">
                                        0 (0%)
                                    </p>
                                    <p class="text-white small mb-1" style="font-size:8px" id="d_ibr_progres">
                                        0 (0%)
                                    </p>
                                    <p class="text-white small mb-1" style="font-size:8px" id="d_ibr_belum">
                                        0 (0%)
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card" style="border-radius: 15px; margin-left: -10px;">
                        <div class="card-body" style="border-radius: 15px; background-color: #8DA9E3; text-align: center;">
                            <p class="fw-bold text-white h5 mb-0" id="t_mom">0</p>
                            <p class="fw-bold text-white small" style="font-size: 12px;">Meeting</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-between mb-2">
                <div class="col-4">
                    <div class="card" style="border-radius: 15px; margin-right: -7px;">
                        <div class="card-body" style="border-radius: 15px; background-color: #FF9A62; text-align: center;">
                            <p class="fw-bold text-white h5 mb-0" id="t_comp">0</p>
                            <p class="fw-bold text-white small" style="font-size: 12px;">Komplain</p>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card" style="border-radius: 15px; margin-left: -10px;">
                        <div class="card-body" style="border-radius: 15px; background-color: #988759;">
                            <div class="row">
                                <div class="col-5 text-center" style="border-right: 1px solid white;">
                                    <p class="fw-bold text-white h5 mb-0" id="t_tt">0</p>
                                    <p class="fw-bold text-white small" style="font-size: 12px;">TeamTalk</p>
                                </div>

                                <div class="col-7">
                                    <p style="color: white; font-size: 11px; margin-bottom: 4px;">
                                        Rating ⭐⭐⭐⭐
                                    </p>
                                    <p style="color: white; font-size: 10px; margin-bottom: -2px;">
                                        Response:
                                    </p>
                                    <div class="row" style="margin-bottom: 4px;">
                                        <div class="col">
                                            <p style="color: white; font-size: 9px; margin: 0;">
                                                Fast<br>70%
                                            </p>
                                        </div>
                                        <div class="col text-end">
                                            <p style="color: white; font-size: 9px; margin: 0;">
                                                Slow<br>30%
                                            </p>
                                        </div>
                                    </div>
                                    <div class="progress h-15">
                                        <div class="progress-bar bg-success" id="progres_bar_ontime" style="width:70%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <span class="small text-white fw-bold">35/50</span>
                                        </div>
                                        <div class="progress-bar bg-danger" id="progres_bar_late" style="width:30%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <span class="small text-white fw-bold">15/50</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-between">
                <div class="col-4">
                    <div class="card" style="border-radius: 15px; margin-right: -8px;">
                        <div class="card-body" style="border-radius: 15px; background-color: #85D1A4; text-align: center;">
                            <p class="fw-bold text-white h5 mb-0" id="t_gen">0</p>
                            <p class="fw-bold text-white small" style="font-size: 12px;">Genba</p>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card" style="border-radius: 15px; margin-left: -10px; margin-right: -4px;">
                        <div class="card-body" style="border-radius: 15px; background-color: #E65281; text-align: center;">
                            <p class="fw-bold text-white h5 mb-0" id="t_training">0</p>
                            <p class="fw-bold text-white small" style="font-size: 12px;">Training</p>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card" style="border-radius: 15px; margin-left: -13px;">
                        <div class="card-body" style="border-radius: 15px; background-color: #B46BF2; text-align: center;">
                            <p class="fw-bold text-white h5 mb-0" id="t_coac">0</p>
                            <p class="fw-bold text-white small" style="font-size: 12px;">Co & Co</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
