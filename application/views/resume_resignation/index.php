<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-8 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Deskripsi Page</p>
            </div>
            <div class="col-4 col-sm-auto">
                <select name="company" id="company" class="form-control">
                    <option value="all" selected>Semua Company</option>
                    <?php foreach ($companies as $company) { ?>
                        <option value="<?= $company->company_id; ?>"><?= $company->name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col col-sm-auto">
                <div class="input-group input-group-md reportrange">
                    <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                    <input type="hidden" name="start" value="" id="start" />
                    <input type="hidden" name="end" value="" id="end" />
                    <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
                </div>
            </div>
            <div class="col-auto ps-0">

            </div>
        </div>
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle; ?></li>
                        </ol>
                    </div>
                    <div class="col-12 col-md-6 text-end">
                        <?php if ($this->session->userdata('user_id') == '2063' || $this->session->userdata('user_id') == '61' || $this->session->userdata('role') == '1' || $this->session->userdata('user_id') == '1' || $this->session->userdata('user_id') == '979') { ?>
                            <button type="button" class="btn btn-md btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalReportDetail" onclick="dt_report_detail()" id="btn_report_detail"><i class="bi bi-file-earmark-text"></i> Report Detail</button>
                        <?php } ?>
                    </div>
                </div>

            </nav>
        </div>
    </div>

    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">Dashboard 1 </h6>
                        </div>
                    </div>
                    <div class="table-responsive" style="padding: 10px;">
                        <table class="table table-sm table-striped" id="dt_dashboard_1" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Masa Kerja</th>
                                    <th>Company</th>
                                    <th>Departement</th>
                                    <th>MP</th>
                                </tr>
                            </thead>
                            <tbody id="dashboard_1"></tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">Dashboard 2 </h6>
                        </div>
                    </div>
                    <div class="table-responsive" style="padding: 10px;">
                        <table class="table table-sm table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Departement</th>
                                    <th>Contract - Perusahaan</th>
                                    <th>End Contract - Perusahaan</th>
                                    <th>End Contract - Pribadi</th>
                                    <th>Resign</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="dashboard_2"></tbody>
                            <tfoot id="foot_dashboard_2"></tfoot>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">Dashboard 3 </h6>
                        </div>
                    </div>
                    <div class="table-responsive" style="padding: 10px;">
                        <table class="table table-sm table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th>MP</th>
                                    <th>%</th>
                                </tr>
                            </thead>
                            <tbody id="dashboard_3"></tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">Dashboard 4 </h6>
                        </div>
                    </div>
                    <div class="table-responsive" style="padding: 10px;">
                        <table class="table table-sm table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th>Alasan</th>
                                    <th>MP</th>
                                    <th>%</th>
                                </tr>
                            </thead>
                            <tbody id="dashboard_4"></tbody>
                            <tfoot id="foot_dashboard_4"></tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>