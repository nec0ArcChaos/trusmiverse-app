<div class="col-12 col-md-6 col-lg-6 col-xxl-3 mb-3" style="margin-right: -10px;">
    <div class="card bg-light" style="border-radius: 25px;">
        <div class="card-header" style="border-radius: 25px 25px 0 0;">
            <div class="row align-items-center d-flex justify-content-between">
                <div class="col col-sm-auto" style="margin-right: -10px;">
                    <h6 class="mb-0">
                        Resume Data
                    </h6>
                </div>
                <!-- <div class="col col-sm-auto">
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
        <div class="card-body" style="border-radius: 0 0 25px 25px; margin-top: -7px;">
            <div class="row">
                <div class="col" style="margin-right: -7px;">
                    <p style="font-size: 12px; font-weight: bold;" class="text-grey mb-2">
                        Booking <span class="text-dark" id="booking_persen">0%</span>
                    </p>

                    <div class="progress position-relative h-30">
                        <span class="position-absolute w-100 text-center fw-bold h6 mt-1" id="booking_jumlah">0/0</span>
                        <div class="progress-bar " id="booking_progres" style="width:0%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                        <div class="progress-bar bg-soft-grey" style="width:0%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>

                </div>
                <div class="col" style="margin-left: -7px;">
                    <p style="font-size: 12px; font-weight: bold;" class="text-grey mb-2">
                        Akad <span class="text-dark" id="akad_persen">0%</span>
                    </p>

                    <div class="progress position-relative h-30">
                        <span class="position-absolute w-100 text-center fw-bold h6 mt-1" id="akad_jumlah">0/0</span>
                        <div class="progress-bar " id="akad_progres" style="width:0%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                        <div class="progress-bar bg-soft-grey" style="width:0%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-header bg-soft-grey" style="border-radius: 15px 15px 0 0; text-align: center; height: 30px; line-height: 6px;">
                            <div class="row">
                                <div class="col">
                                    <p style="font-size: 12px; font-weight: bold;" class="text-grey">
                                        Total Unit
                                    </p>
                                </div>
                                <div class="col">
                                    <p style="font-size: 12px; font-weight: bold;" class="text-grey">
                                        Ready
                                    </p>
                                </div>
                                <div class="col">
                                    <p style="font-size: 12px; font-weight: bold;" class="text-grey">
                                        Sisa 
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="border-radius: 0 0 15px 15px; text-align: center;">
                            <div class="row">
                                <div class="col">
                                    <p class="text-grey fw-bold h5" id="value_jumlah">
                                        0
                                    </p>
                                </div>
                                <div class="col">
                                    <p class="text-grey fw-bold h5" id="value_ready">
                                        0
                                    </p>
                                </div>
                                <div class="col">
                                    <p class="text-grey fw-bold h5" id="value_sisa">
                                        0
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col" style="margin-right: -7px;">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-header bg-soft-grey" style="border-radius: 15px 15px 0 0; text-align: center; height: 30px; line-height: 6px;">
                            <div class="row">
                                <div class="col">
                                    <p style="font-size: 12px; font-weight: bold;" class="text-grey">
                                        Ceklok
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="border-radius: 0 0 15px 15px; text-align: center;">
                            <div class="row">
                                <div class="col">
                                    <p class="text-grey fw-bold h5" id="value_ceklok">
                                        0
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col" style="margin-left: -7px; margin-right: -7px;">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-header bg-soft-grey" style="border-radius: 15px 15px 0 0; text-align: center; height: 30px; line-height: 6px;">
                            <div class="row">
                                <div class="col">
                                    <p style="font-size: 12px; font-weight: bold;" class="text-grey">
                                        SP3K
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="border-radius: 0 0 15px 15px; text-align: center;">
                            <div class="row">
                                <div class="col">
                                    <p class="text-grey fw-bold h5" id="value_sp3k">
                                        0
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col" style="margin-left: -7px;">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-header bg-soft-grey" style="border-radius: 15px 15px 0 0; text-align: center; height: 30px; line-height: 6px;">
                            <div class="row">
                                <div class="col">
                                    <p style="font-size: 12px; font-weight: bold;" class="text-grey">
                                        Bank
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="border-radius: 0 0 15px 15px; text-align: center;">
                            <div class="row">
                                <div class="col">
                                    <p class="text-grey fw-bold h5" id="value_bank">
                                        0
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>