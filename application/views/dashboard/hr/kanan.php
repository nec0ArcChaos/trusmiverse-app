<div class="col-12 col-md-6 col-lg-7 col-xl-8">
    <!-- KPI -->
    <div class="card mb-3 border-0 border-left-3 border-primary">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-key h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                </div>
                <div class="col px-0">
                    <h6 class="fw-medium py-0 mb-0">Key Performance Indicator</h6>
                    <small class="py-0 text-secondary fst-italic" style="margin-top: -46%;">Bobot : 85%</small>
                </div>
                <div class="col d-flex justify-content-end">
                    <div class="row">
                        <div class="col text-end" style="border-left: 2px solid rgb(0,0,0,0.2);">
                            <h5 class="badge bg-green fs-5">36%</h5>
                        </div>
                        <div class="col ps-1 text-start align-items-center">
                            <p class="text-danger small mb-0"><i class="mb-0 bi bi-arrow-down-circle-fill text-danger fs-6"></i> 4%</p>
                            <p class="text-secondary small" style="font-size: 8px !important;">Last Month</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-sm-12 col-xs-12">
                    <div id="chartdivKpi">

                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 col-xs-12">
                    <div class="row mb-2">
                        <div class="col">
                            <h6><i class="bi bi-journal-arrow-down me-2 text-primary"></i>Detail</h6>

                            <table class="table tabel-xs" id="dt_kpi">
                                <thead>
                                    <tr>
                                        <th>KPI</th>
                                        <th>Target</th>
                                        <th>Actual</th>
                                        <th>Achieve</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tbody id="body_kpi">
                                    <tr>
                                        <td>Booking</td>
                                        <td class="text-center">273</td>
                                        <td class="text-center">133</td>
                                        <td class="text-center">49%</td>
                                        <td class="text-center">15</td>
                                    </tr>
                                    <tr>
                                        <td>Akad</td>
                                        <td class="text-center">180</td>
                                        <td class="text-center">34</td>
                                        <td class="text-center">19%</td>
                                        <td class="text-center">6</td>
                                    </tr>
                                    <tr>
                                        <td>BIC ACC</td>
                                        <td class="text-center">66</td>
                                        <td class="text-center">92</td>
                                        <td class="text-center">50%</td>
                                        <td class="text-center">8</td>
                                    </tr>
                                    <tr>
                                        <td>BIC ACC - Proses</td>
                                        <td class="text-center">32</td>
                                        <td class="text-center">13</td>
                                        <td class="text-center">48%</td>
                                        <td class="text-center">7</td>
                                    </tr>
                                    <tr>
                                        <td>Produktifitas Sales</td>
                                        <td class="text-center">130</td>
                                        <td class="text-center">56</td>
                                        <td class="text-center">43%</td>
                                        <td class="text-center">6</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" align="right" class="bg-secondary text-white fw-bold">Total &nbsp;&nbsp;</td>
                                        <td align="center">70</td>
                                    </tr>
                                </tfoot>

                            </table>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <h6><i class="bi bi-journal-text me-2 text-primary"></i>Evaluasi</h6>
                            <p>KPI januari turun 5% dari periode sebelumnya di karena pemenuhan SDM kurang</p>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- Konsistensi -->
    <div class="card mb-3 border-0 border-left-3 border-primary">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-bookmarks me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                </div>
                <div class="col px-0">
                    <h6 class="fw-medium py-0 mb-0">Event</h6>
                    <small class="py-0 text-secondary fst-italic" style="margin-top: -46%;">Bobot : 10%</small>
                </div>
                <div class="col d-flex justify-content-end">
                    <div class="row">
                        <div class="col text-end" style="border-left: 2px solid rgb(0,0,0,0.2);">
                            <h5 class="badge bg-green fs-5">8%</h5>
                        </div>
                        <div class="col ps-1 text-start align-items-center">
                            <p class="text-danger small mb-0"><i class="mb-0 bi bi-arrow-down-circle-fill text-danger fs-6"></i> 4%</p>
                            <p class="text-secondary small" style="font-size: 8px !important;">Last Month</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" style="padding: 5px;">
            <div class="row">
                <div class="col-lg-6 col-sm-12 col-xs-12">
                    <div id="event_chart">
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col">
                            <h6><i class="bi bi-journal-arrow-down me-2 text-primary"></i>Detail</h6>


                            <table class="table tabel-xs">
                                <thead>
                                    <tr>
                                        <th>Event</th>
                                        <th align="center">Target</th>
                                        <th align="center">Actual</th>
                                        <th align="center">Persen</th>
                                    </tr>
                                </thead>
                                <tbody id="body_kpi">
                                    <tr>
                                        <td><i class="bi bi-square-fill" style="color:#1ab7ea"></i> Meeting</td>
                                        <td align="center">2</td>
                                        <td align="center">1</td>
                                        <td align="center">50%</td>
                                    </tr>
                                    <tr>
                                        <td><i class="bi bi-square-fill" style="color:#0084ff"></i> Co&Co</td>
                                        <td align="center">1</td>
                                        <td align="center">1</td>
                                        <td align="center">100%</td>
                                    </tr>
                                    <tr>
                                        <td><i class="bi bi-square-fill" style="color:#39539E"></i> Sharing Leader</td>
                                        <td align="center">1</td>
                                        <td align="center">1</td>
                                        <td align="center">100%</td>
                                    </tr>
                                    <tr>
                                        <td><i class="bi bi-square-fill" style="color:#393D4B"></i> Breafing</td>
                                        <td align="center">20</td>
                                        <td align="center">18</td>
                                        <td align="center">90%</td>
                                    </tr>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" align="right" class="bg-secondary text-white fw-bold">Average&nbsp;&nbsp;</td>
                                        <td align="center">70%</td>
                                    </tr>
                                </tfoot>

                            </table>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="card mb-3 border-0 border-left-3 border-primary">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-bar-chart-steps me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                </div>
                <div class="col px-0">
                    <h6 class="fw-medium py-0 mb-0">Disiplin</h6>
                    <small class="py-0 text-secondary fst-italic" style="margin-top: -46%;">Bobot : 5%</small>
                </div>
                <div class="col d-flex justify-content-end">
                    <div class="row">
                        <div class="col text-end" style="border-left: 2px solid rgb(0,0,0,0.2);">
                            <h5 class="badge bg-green fs-5">4%</h5>
                        </div>
                        <div class="col ps-1 text-start align-items-center">
                            <p class="text-success small mb-0"><i class="mb-0 bi bi-arrow-up-circle-fill text-success fs-6"></i> 4%</p>
                            <p class="text-secondary small" style="font-size: 8px !important;">Last Month</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id='myChart'></div>
        <div class="card-body" style="padding: 5px;">
            <div class="row">
                <div class="col-lg-6 col-sm-12 col-xs-12">
                    <div id="chart_disiplin"></div>
                </div>
                <div class="col-lg-6 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col">
                            <h6><i class="bi bi-journal-arrow-down me-2 text-primary"></i>Detail</h6>
                        </div>
                    </div>

                    <table class="table tabel-xs">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th align="center">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody id="body_kpi">
                            <tr>
                                <td>Kehadiran</td>
                                <td align="center">100%</td>
                            </tr>
                            <tr>
                                <td>Jam Masuk Tidak Sesuai</td>
                                <td align="center">1</td>
                            </tr>
                            <tr>
                                <td>Jam Pulang Cepat Tdk Izin</td>
                                <td align="center">0</td>
                            </tr>
                            <tr>
                                <td>Izin Pulan Cepat & Datang Terlamb.</td>
                                <td align="center">1</td>
                            </tr>
                            <tr>
                                <td>Finger 1x</td>
                                <td align="center">0</td>
                            </tr>


                        </tbody>
                        <tfoot>
                            <tr>
                                <td align="right" class="bg-secondary text-white fw-bold">Kedisiplinan&nbsp;&nbsp;</td>
                                <td align="center">93%</td>
                            </tr>
                        </tfoot>

                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- <div class="col-12">
        <div class="card mb-3 border-0 border-left-3 border-primary">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-calendar-week h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                    </div>
                    <div class="col ps-0">
                        <h6 class="fw-medium mb-0">Calendar</h6>
                        <p class="text-secondary small">"The calendar is a roadmap, and your goals are the destination."</p>
                    </div>
                </div>
            </div>
            <div class="card-body pb-0">
                <div class="inner-sidebar-wrap border-bottom">
                    <div class="inner-sidebar-content">
                        <div id="calendarNew"></div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</div>