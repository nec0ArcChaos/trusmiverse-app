<div class="row mt-3 <?php if($id_company != 5){ echo 'd-none'; } ?>">
    <div class="col-12 mb-3" style="margin-right: -10px;">
        <div class="card" style="border-radius: 25px;">
            <div class="card-header bg-super-soft-grey d-flex justify-content-center align-items-center" style="border-radius: 25px 25px 0 0;">
                <h6 class="mb-0 fw-bold">
                    Pelanggaran Manpower
                </h6>
            </div>
            <div class="card-body bg-super-soft-grey" style="border-radius: 0 0 25px 25px;">
                <div class="row d-flex justify-content-between">
                    <div class="col-4">
                        <div class="card" style="border-radius: 15px; margin-right: -8px;">
                            <div class="card-body" style="border-radius: 15px; background-color: #DC1943; text-align: center;">
                                <p class="fw-bold text-white small" style="font-size: 12px;">Lock Absen</p>
                                <p class="fw-bold text-white h4 mb-0" id="total_lock">0</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card" style="border-radius: 15px; margin-left: -10px; margin-right: -4px;">
                            <div class="card-body" style="border-radius: 15px; background-color: #A76EAE; text-align: center;">
                                <p class="fw-bold text-white small" style="font-size: 12px;">Auto ST</p>
                                <p class="fw-bold text-white h4 mb-0" id="total_st">0</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card" style="border-radius: 15px; margin-left: -13px;">
                            <div class="card-body" style="border-radius: 15px; background-color: #9B6B6B; text-align: center;">
                                <p class="fw-bold text-white small" style="font-size: 12px;">Auto SP</p>
                                <p class="fw-bold text-white h4 mb-0" id="total_sp">0</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card" style="border-radius: 15px; margin-top: 3px;">
                            <div class="card-body" style="border-radius: 15px; background-color: #ED7A00; text-align: center;">
                                <div class="row">
                                    <div class="col-5 text-center" style="border-right: 1px solid white;">
                                        <p class="fw-bold text-white small" style="font-size: 12px;">Denda</p>
                                        <p class="fw-bold text-white h4 mb-0" id="total_denda">0</p>
                                    </div>

                                    <div class="col-7 d-flex flex-column justify-content-center">
                                        <p style="color: white; font-size: 12px; font-weight: bold; margin-bottom: 4px;">
                                            Total Nominal Denda
                                        </p>
                                        <p style="color: white; font-size: 16px; font-weight: bold; margin-bottom: -2px;" id="total_nominal">
                                            Rp.0
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="card" style="border-radius: 25px;">
                            <div class="card-body bg-light" style="border-radius: 0 0 25px 25px; margin-top: -7px;">
                                <div class="row">
                                    <div class="col" style="margin-right: -7px;">
                                        <p style="font-size: 12px; font-weight: bold;" class="text-grey mb-2">
                                            Kehadiran
                                        </p>

                                        <div class="progress position-relative" id="div_kehadiran" style="height: 25px; width: 100%;">
                                            <span class="position-absolute w-100 text-center fw-bold h6 mt-1 text-green">78%</span>
                                            <div class="progress-bar bg-soft-green" style="width:78%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                            <div class="progress-bar bg-soft-grey" style="width:0%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col" style="margin-left: -7px;">
                                        <p style="font-size: 12px; font-weight: bold;" class="text-grey mb-2">
                                            Task Undone & Late
                                        </p>

                                        <div class="progress position-relative" id="div_undone" style="height: 25px; width: 100%;">
                                            <span class="position-absolute w-100 text-center fw-bold h6 mt-1 text-red">20%</span>
                                            <div class="progress-bar bg-soft-red" style="width:20%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                            <div class="progress-bar bg-soft-grey" style="width:0%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <p style="font-size: 12px; font-weight: bold;" class="text-grey mb-2">
                                        Detail Pelanggaran
                                    </p>

                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover table-stiped" id="table_detail_warning" style="white-space: nowrap;" nowrap>
                                            <thead>
                                                <tr>
                                                    <!-- <th class="small" nowrap></th> -->
                                                    <th class="small" nowrap>Nama</th>
                                                    <th class="small" nowrap>Kehadiran</th>
                                                    <th class="small" nowrap>Temuan</th>
                                                    <th class="small" nowrap>ST</th>
                                                    <th class="small" nowrap>SP</th>
                                                    <th class="small" nowrap>Lock</th>
                                                    <th class="small" nowrap>Denda</th>
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
            </div>
        </div>
    </div>

    <div class="col-12 mb-3" style="margin-right: -10px;">
        <div class="card" style="border-radius: 25px;">
            <div class="card-header bg-super-soft-grey d-flex justify-content-center align-items-center" style="border-radius: 25px 25px 0 0;">
                <h6 class="mb-0 fw-bold">
                    Rekomendasi Tindakan
                </h6>
            </div>
            <div class="card-body bg-super-soft-grey" style="border-radius: 0 0 25px 25px;">
                <div class="row d-flex justify-content-between">
                    <div class="col-12">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body d-flex align-items-center justify-content-center" style="border-radius: 15px; background-color: #081226; height: 25px;">
                                <p class="fw-bold text-white text-center small" style="font-size: 12px;">By Aturan/SOP</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="card mt-1" style="border-radius: 15px;">
                            <div class="card-body" style="border-radius: 15px; background-color: #ffffff;">
                                <div class="row">
                                    <div class="col">
                                        <p class="fw-bold text-grey small" style="font-size: 12px;">[Lock Absen]</p>
                                        <p class="fw-bold text-grey small" style="font-size: 12px;">Rekomendasi 1 ...</p>
                                    </div>
                                    <div class="col d-flex justify-content-end">
                                        <button class="circle-btn">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-1" style="border-radius: 15px;">
                            <div class="card-body" style="border-radius: 15px; background-color: #ffffff;">
                                <div class="row">
                                    <div class="col">
                                        <p class="fw-bold text-grey small" style="font-size: 12px;">[Auto ST]</p>
                                        <p class="fw-bold text-grey small" style="font-size: 12px;">Rekomendasi 2 ...</p>
                                    </div>
                                    <div class="col d-flex justify-content-end">
                                        <button class="circle-btn">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-1" style="border-radius: 15px;">
                            <div class="card-body" style="border-radius: 15px; background-color: #ffffff;">
                                <div class="row">
                                    <div class="col">
                                        <p class="fw-bold text-grey small" style="font-size: 12px;">[Auto SP]</p>
                                        <p class="fw-bold text-grey small" style="font-size: 12px;">Rekomendasi 3 ...</p>
                                    </div>
                                    <div class="col d-flex justify-content-end">
                                        <button class="circle-btn">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row d-flex justify-content-between mt-3">
                    <div class="col-12">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body d-flex align-items-center justify-content-center" style="border-radius: 15px; background-color: #0B3281; height: 25px;">
                                <p class="fw-bold text-white text-center small" style="font-size: 12px;">By Improve Head</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="card mt-1" style="border-radius: 15px;">
                            <div class="card-body" style="border-radius: 15px; background-color: #ffffff;">
                                <div class="row">
                                    <div class="col">
                                        <p class="fw-bold text-grey small" style="font-size: 12px;">[Lock Absen]</p>
                                        <p class="fw-bold text-grey small" style="font-size: 12px;">Rekomendasi 1 ...</p>
                                    </div>
                                    <div class="col d-flex justify-content-end">
                                        <button class="circle-btn">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-1" style="border-radius: 15px;">
                            <div class="card-body" style="border-radius: 15px; background-color: #ffffff;">
                                <div class="row">
                                    <div class="col">
                                        <p class="fw-bold text-grey small" style="font-size: 12px;">[Auto ST]</p>
                                        <p class="fw-bold text-grey small" style="font-size: 12px;">Rekomendasi 2 ...</p>
                                    </div>
                                    <div class="col d-flex justify-content-end">
                                        <button class="circle-btn">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>