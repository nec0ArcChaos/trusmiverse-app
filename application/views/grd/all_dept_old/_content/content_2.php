<style>
    .progress-bar {
        white-space: nowrap;   /* Prevent text from wrapping */
        overflow: visible;     /* Allow text to be shown outside the bar */
        text-overflow: clip;   /* Avoid cutting off text */
    }
</style>

<div class="row">

    <div class="col-md-9 col-sm-12">
        <!-- Card Operasional per Divisi -->
        <div class="row <?php if($id_company != 5){ echo 'd-none'; } ?>">
            <div class="col-12 col-md-12 col-lg-12 col-xxl-12 mb-12">
                <div class="row g-3" id="list_content2">

                    <div class="col-md-6">
                        <div class="card h-100 d-flex flex-column" style="border-radius: 15px; margin-right: 0px;">
                            <div class="card-header bg-white d-flex justify-content-center align-items-center" style="border-radius: 25px 25px 0 0;">
                                <h6 class="mb-0 fw-bold">
                                    Operasional
                                </h6>
                            </div>
                            <div class="card-body bg-white flex-grow-1" style="border-radius: 0 0 15px 15px;">
                                <div class="row">
                                    <div class="col-2 d-flex align-items-center justify-content-center">
                                        <div id="chart_pie_operasional" style="width: 80px;"></div>
                                    </div>
                                    <div class="col-5">
                                        <p class="mb-0" style="font-size: 12px;" id="prs_sales"></p>
                                        <div class="progress mb-2" style="height: 20px;">
                                            <div class="progress-bar text-grey" style="width: 0%; font-size: 12px;" id="sales" >0</div>
                                        </div>

                                        <p class="mb-0" style="font-size: 12px;" id="prs_basket"></p>
                                        <div class="progress mb-2" style="height: 20px;">
                                            <div class="progress-bar text-grey" style="width: 0%; font-size: 12px;" id="basket_size">0</div>
                                        </div>

                                        <p class="mb-0" style="font-size: 12px;" id="prs_transaksi"></p>
                                        <div class="progress mb-2" style="height: 20px;">
                                            <div class="progress-bar text-grey" style="width: 0%; font-size: 12px;" id="transaksi">0</div>
                                        </div>
                                    </div>

                                    <div class="col-5">
                                        <p class="mb-0" style="font-size: 12px;" id="prs_sales_l"></p>
                                        <div class="progress mb-2" style="height: 20px;">
                                            <div class="progress-bar text-grey" style="width: 0%; font-size: 12px;" id="sales_l">0</div>
                                        </div>

                                        <p class="mb-0" style="font-size: 12px;" id="prs_sales_y"></p>
                                        <div class="progress mb-2" style="height: 20px;">
                                            <div class="progress-bar text-grey" style="width: 0%; font-size: 12px;" id="sales_y">0</div>
                                        </div>

                                        <p class="mb-0" style="font-size: 12px;" id="prs_sales_m"></p>
                                        <div class="progress mb-2" style="height: 20px;">
                                            <div class="progress-bar text-grey" style="width: 0%; font-size: 12px;" id="sales_m">0</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card h-100 d-flex flex-column" style="border-radius: 15px; margin-right: 0px;">
                            <div class="card-header bg-white d-flex justify-content-center align-items-center" style="border-radius: 25px 25px 0 0;">
                                <h6 class="mb-0 fw-bold">
                                    Produksi
                                </h6>
                            </div>
                            <div class="card-body bg-white flex-grow-1" style="border-radius: 0 0 15px 15px;">
                                <div class="row">
                                    <div class="col-5 d-flex align-items-center justify-content-center">
                                        <div id="chart_pie_produksi" style="width: 80px;"></div>
                                    </div>
                                    <div class="col-7">
                                        <p class="mb-0" style="font-size: 12px;" id="prs_keamanan"></p>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar text-grey" style="width: 0%; font-size: 12px;" id="keamanan_stok">0</div>
                                        </div>

                                        <p class="mb-0" style="font-size: 12px;" id="prs_leadtime_po"></p>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar text-grey" style="width: 0%; font-size: 12px;" id="leadtime_po">0</div>
                                        </div>

                                        <p class="mb-0" style="font-size: 12px;" id="prs_tingkat_reject"></p>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar text-grey" style="width: 0%; font-size: 12px;" id="tingkat_reject">0</div>
                                        </div>

                                        <p class="mb-0" style="font-size: 12px;" id="prs_produk_baru"></p>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar text-grey" style="width: 0%; font-size: 12px;" id="produk_baru">0</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card h-100 d-flex flex-column" style="border-radius: 15px; margin-right: 0px;">
                            <div class="card-header bg-white d-flex justify-content-center align-items-center" style="border-radius: 25px 25px 0 0;">
                                <h6 class="mb-0 fw-bold">
                                    HR
                                </h6>
                            </div>
                            <div class="card-body bg-white flex-grow-1" style="border-radius: 0 0 15px 15px;">
                                <div class="row">
                                    <div class="col-5 d-flex align-items-center justify-content-center">
                                        <div id="chart_pie_hr" style="width: 80px;"></div>
                                    </div>
                                    <div class="col-7">
                                        <p class="mb-0" style="font-size: 12px;" id="prs_recruitment"></p>
                                        <div class="progress mb-2" style="height: 20px;">
                                            <div class="progress-bar bg-soft-red text-grey" style="width: 0%; font-size: 12px;" id="recruitment">0</div>
                                        </div>

                                        <p class="mb-0" style="font-size: 12px;" id="prs_training"></p>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-soft-red text-grey" style="width: 0%; font-size: 12px;" id="training">0</div>
                                        </div>

                                        <p class="mb-0" style="font-size: 12px;" id="prs_od"></p>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-soft-red text-grey" style="width: 0%; font-size: 12px;" id="od">0</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mt-1">

                    <div class="col-md-3">
                        <div class="card h-100 d-flex flex-column" style="border-radius: 15px; margin-right: 0px;">
                            <div class="card-header bg-white d-flex justify-content-center align-items-center" style="border-radius: 25px 25px 0 0;">
                                <h6 class="mb-0 fw-bold">
                                    E-Commerce
                                </h6>
                            </div>
                            <div class="card-body bg-white flex-grow-1" style="border-radius: 0 0 15px 15px;">
                                <div class="row">
                                    <div class="col-5 d-flex align-items-center justify-content-center">
                                        <div id="chart_pie_ecommerce" style="width: 80px;"></div>
                                    </div>
                                    <div class="col-7">
                                        <p class="mb-0" style="font-size: 12px;" id="prs_sales_e"></p>
                                        <div class="progress mb-2" style="height: 20px;">
                                            <div class="progress-bar bg-soft-red text-grey" style="width: 0%; font-size: 12px;" id="sales_e">0</div>
                                        </div>

                                        <p class="mb-0" style="font-size: 12px;" id="prs_transaksi_e"></p>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-soft-red text-grey" style="width: 0%; font-size: 12px;" id="transaksi_e">0</div>
                                        </div>

                                        <p class="mb-0" style="font-size: 12px;" id="prs_basket_e"></p>
                                        <div class="progress mb-2" style="height: 20px;">
                                            <div class="progress-bar bg-soft-red text-grey" style="width: 0%; font-size: 12px;" id="basket_size_e">0</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card h-100 d-flex flex-column" style="border-radius: 15px; margin-right: 0px;">
                            <div class="card-header bg-white d-flex justify-content-center align-items-center" style="border-radius: 25px 25px 0 0;">
                                <h6 class="mb-0 fw-bold">
                                    Marcomm
                                </h6>
                            </div>
                            <div class="card-body bg-white flex-grow-1" style="border-radius: 0 0 15px 15px;">
                                <div class="row">
                                    <div class="col-5 d-flex align-items-center justify-content-center">
                                        <div id="chart_pie_marcomm" style="width: 80px;"></div>
                                    </div>
                                    <div class="col-7">
                                        <p class="mb-0" style="font-size: 12px;" id="prs_awarness"></p>
                                        <div class="progress mb-2" style="height: 20px;">
                                            <div class="progress-bar bg-soft-red text-grey" style="width: 0%; font-size: 12px;" id="awarness">0</div>
                                        </div>

                                        <p class="mb-0" style="font-size: 12px;" id="prs_traffic"></p>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-soft-red text-grey" style="width: 0%; font-size: 12px;" id="traffic">0</div>
                                        </div>

                                        <p class="mb-0" style="font-size: 12px;" id="prs_lead"></p>
                                        <div class="progress mb-2" style="height: 20px;">
                                            <div class="progress-bar bg-soft-red text-grey" style="width: 0%; font-size: 12px;" id="lead">0</div>
                                        </div>

                                        <p class="mb-0" style="font-size: 12px;" id="prs_cost"></p>
                                        <div class="progress mb-2" style="height: 20px;">
                                            <div class="progress-bar bg-soft-red text-grey" style="width: 0%; font-size: 12px;" id="cost">0</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card h-100 d-flex flex-column" style="border-radius: 15px; margin-right: 0px;">
                            <div class="card-header bg-white d-flex justify-content-center align-items-center" style="border-radius: 25px 25px 0 0;">
                                <h6 class="mb-0 fw-bold">
                                    Mini Factory
                                </h6>
                            </div>
                            <div class="card-body bg-white flex-grow-1" style="border-radius: 0 0 15px 15px;">
                                <div class="row">
                                    <div class="col-5 d-flex align-items-center justify-content-center">
                                        <div id="chart_pie_mini" style="width: 80px;"></div>
                                    </div>
                                    <div class="col-7">
                                        <p class="mb-0" style="font-size: 12px;" id="prs_jml_produksi"></p>
                                        <div class="progress mb-2" style="height: 20px;">
                                            <div class="progress-bar bg-soft-red text-grey" style="width: 0%; font-size: 12px;" id="jml_produksi">0</div>
                                        </div>

                                        <p class="mb-0" style="font-size: 12px;" id="prs_leadtime_po_m"></p>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-soft-red text-grey" style="width: 0%; font-size: 12px;" id="leadtime_po_m">0</div>
                                        </div>

                                        <p class="mb-0" style="font-size: 12px;" id="prs_tingkat_reject_m"></p>
                                        <div class="progress mb-2" style="height: 20px;">
                                            <div class="progress-bar bg-soft-red text-grey" style="width: 0%; font-size: 12px;" id="tingkat_reject_m">0</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card h-100 d-flex flex-column" style="border-radius: 15px; margin-right: 0px;">
                            <div class="card-header bg-white d-flex justify-content-center align-items-center" style="border-radius: 25px 25px 0 0;">
                                <h6 class="mb-0 fw-bold">
                                    Riset
                                </h6>
                            </div>
                            <div class="card-body bg-white flex-grow-1" style="border-radius: 0 0 15px 15px;">
                                <div class="row">
                                    <div class="col-5 d-flex align-items-center justify-content-center">
                                        <div id="chart_pie_riset" style="width: 80px;"></div>
                                    </div>
                                    <div class="col-7">
                                    <p class="mb-0" style="font-size: 12px;" id="prs_leadtime"></p>
                                        <div class="progress mb-2" style="height: 20px;">
                                            <div class="progress-bar text-grey" style="width: 0%; font-size: 12px;" id="leadtime">0</div>
                                        </div>

                                        <p class="mb-0" style="font-size: 12px;" id="prs_keberhasilan"></p>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-soft-yellow text-grey" style="width: 0%; font-size: 12px;" id="keberhasilan">0</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                
            </div>
        </div>
        <!-- Card GRD Operasional -->
        <?php 
        $this->load->view('grd/all/_content/content_3_kiri');
        ?>
    </div>

    <div class="col-md-3 col-sm-12">
        <!-- Card Support -->
        <div class="card" style="border-radius: 25px; margin-right: 0px;">
            <div class="card-header bg-super-soft-grey d-flex justify-content-center align-items-center" style="border-radius: 25px 25px 0 0;">
                <h6 class="mb-0 fw-bold">
                    Support
                </h6>
            </div>
            <div class="card-body bg-super-soft-grey" style="border-radius: 0 0 25px 25px;">
                <div class="row d-flex justify-content-between mb-2" style="margin-top: -5px;">
                    <div class="col-8">
                        <div class="card" style="border-radius: 15px; margin-right: -7px;">
                            <div class="card-body" style="border-radius: 15px; background-color: #255CCD;">
                                <div class="row">
                                    <div class="col-4 text-center" style="border-right: 1px solid white;">
                                        <p class="fw-bold text-white h3 mb-0" style="margin-top: 20px;" id="t_ibr">54</p>
                                        <p class="fw-bold text-white small" style="font-size: 12px;">IBR Pro</p>
                                    </div>

                                    <div class="col-2 px-1 py-0">
                                        <p class="text-white small mb-1" style="font-size:8px" id="prs_ibr_jln_berhasil">
                                            24%
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px" id="prs_ibr_tdk_berhasil">
                                            9%
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px" id="prs_ibr_tdk_jln">
                                            10%
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px" id="prs_ibr_progres">
                                            24%
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px" id="prs_ibr_belum">
                                            24%
                                        </p>
                                    </div>
        
                                    <div class="col-3 px-1 py-0">
                                        <p class="text-white small mb-1" style="font-size:8px">
                                            Berhasil
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px">
                                            Tdk Berhasil
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px">
                                            Tdk Berjalan
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px">
                                            Progress
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px">
                                            Not Started
                                        </p>
                                    </div>

                                    <div class="col-2 px-1 py-1 text-end">
                                        <p class="text-white small mb-1" style="font-size:8px" id="d_ibr_jln_berhasil">
                                            15
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px" id="d_ibr_tdk_berhasil">
                                            4
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px" id="d_ibr_tdk_jalan">
                                            5
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px" id="d_ibr_progres">
                                            5
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px" id="d_ibr_belum">
                                            15
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card" style="border-radius: 15px; margin-left: -10px;">
                            <div class="card-header" style="border-radius: 15px 15px 0 0; text-align: center; height: 30px; line-height: 6px; background-color: #8DA9E3;">
                                <div class="row">
                                    <div class="col">
                                        <p style="font-size: 12px; font-weight: bold;" class="text-white">
                                            MOM
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="border-radius: 0 0 15px 15px; text-align: center; border: 3px solid #8DA9E3;">
                                <div class="row justify-content-center">
                                    <div class="col-auto">
                                        <div id="chart_pie_mom" style="width: 55px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-between mb-2">
                    <div class="col-4">
                        <div class="card" style="border-radius: 15px; margin-right: -8px;">
                            <div class="card-header" style="border-radius: 15px 15px 0 0; text-align: center; height: 30px; line-height: 6px; background-color: #FFA459;">
                                <div class="row">
                                    <div class="col">
                                        <p style="font-size: 12px; font-weight: bold;" class="text-white">
                                            P. Solving
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="border-radius: 0 0 15px 15px; text-align: center; border: 3px solid #FFA459;">
                                <div class="row justify-content-center">
                                    <div class="col-auto">
                                        <div id="chart_pie_problem" style="width: 55px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="card" style="border-radius: 15px; margin-left: -10px;">
                            <div class="card-body" style="border-radius: 15px; background-color: #988759;">
                                <div class="row">
                                    <div class="col-5 text-center" style="border-right: 1px solid white;">
                                        <p class="fw-bold text-white h3 mb-0" style="margin-top: 20px;" id="t_tt">66</p>
                                        <p class="fw-bold text-white small" style="font-size: 12px;">TeamTalk</p>
                                    </div>

                                    <div class="col-7">
                                        <p style="color: white; font-size: 11px; margin-bottom: 4px;">
                                            Rating ⭐⭐⭐⭐
                                        </p>
                                        <p style="color: white; font-size: 10px; margin-bottom: 2px; margin-top: 2px;">
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
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-soft-green" id="progres_bar_ontime" style="width:70%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                <span class="small text-green fw-bold">35/50</span>
                                            </div>
                                            <div class="progress-bar bg-soft-red" id="progres_bar_late" style="width:30%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                <span class="small text-red fw-bold">15/50</span>
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
                            <div class="card-body" style="border-radius: 15px; background-color: #4E6187; text-align: center;">
                                <p class="fw-bold text-white small mt-2" style="font-size: 14px;">Briefing</p>
                                <p class="fw-bold text-white h3 mb-2" id="t_brief">34</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card" style="border-radius: 15px; margin-left: -10px; margin-right: -7px;">
                            <div class="card-header" style="border-radius: 15px 15px 0 0; text-align: center; height: 30px; line-height: 6px; background-color: #B46BF2;">
                                <div class="row">
                                    <div class="col">
                                        <p style="font-size: 12px; font-weight: bold;" class="text-white">
                                            One by One
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="border-radius: 0 0 15px 15px; text-align: center; border: 3px solid #B46BF2;">
                                <div class="row justify-content-center">
                                    <div class="col-auto">
                                        <div id="chart_pie_one" style="width: 55px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card" style="border-radius: 15px; margin-left: -10px;">
                            <div class="card-body" style="border-radius: 15px; background-color: #964441; text-align: center;">
                                <p class="fw-bold text-white small" style="font-size: 14px;">Sharing Leader</p>
                                <p class="fw-bold text-white h3" id="t_sharing">34</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row d-flex justify-content-between mb-2">
                    <div class="col-8">
                        <div class="card" style="border-radius: 15px; margin-right: -7px; margin-top: 10px;">
                            <div class="card-body" style="border-radius: 15px; background-color: #4D8765;">
                                <div class="row">
                                    <div class="col-4 text-center" style="border-right: 1px solid white;">
                                        <p class="fw-bold text-white h3 mb-0" style="margin-top: 20px;" id="t_genba">66</p>
                                        <p class="fw-bold text-white small" style="font-size: 12px;">Genba</p>
                                    </div>

                                    <div class="col-2 px-1 py-0">
                                        <p class="text-white small mb-1" style="font-size:8px" id="prs_genba_jln_berhasil">
                                            24%
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px" id="prs_genba_tdk_berhasil">
                                            9%
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px" id="prs_genba_tdk_jln">
                                            10%
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px" id="prs_genba_progres">
                                            24%
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px" id="prs_genba_belum">
                                            24%
                                        </p>
                                    </div>
        
                                    <div class="col-3 px-1 py-0">
                                        <p class="text-white small mb-1" style="font-size:8px">
                                            Berhasil
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px">
                                            Tdk Berhasil
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px">
                                            Tdk Berjalan
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px">
                                            Progress
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px">
                                            Not Started
                                        </p>
                                    </div>

                                    <div class="col-2 px-1 py-1 text-end">
                                        <p class="text-white small mb-1" style="font-size:8px" id="d_genba_jln_berhasil">
                                            15
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px" id="d_genba_tdk_berhasil">
                                            4
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px" id="d_genba_tdk_jalan">
                                            5
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px" id="d_genba_progres">
                                            5
                                        </p>
                                        <p class="text-white small mb-1" style="font-size:8px" id="d_genba_belum">
                                            15
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card" style="border-radius: 15px; margin-left: -10px; margin-top: 10px;">
                            <div class="card-body" style="border-radius: 15px; background-color: #E65281; text-align: center;">
                                <p class="fw-bold text-white small mt-2" style="font-size: 14px;">Training</p>
                                <p class="fw-bold text-white h3 mb-2" id="t_training">55</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Card Pelanggaran ManPower -->
        <?php 
        $this->load->view('grd/all/_content/content_3_kanan');
        ?>
    </div>

</div>
