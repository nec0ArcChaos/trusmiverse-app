<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle; ?></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container-fluid mb-4">

    </div>

    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-bookmark-check h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0"><?php echo $pageTitle ?></h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col col-sm-auto">
                            <form method="POST" id="form_filter">
                                <div class="input-group input-group-md reportrange">
                                    <span class="input-group-text text-secondary bg-none"><i class="bi bi-calendar-event"></i></span>
                                    <input type="text" class="form-control" value="" name="periode" id="periode" placeholder="<?= date('Y') ?>-<?= date('m') ?>">
                                    <input type="hidden" name="period" id="period" value="" />
                                    <a href="javascript:void(0);" class="btn btn-primary" id="filter_period"><i class="ti-search"></i>Filter</a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_report_budget" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>EAF Comp</th>
                                    <th>Jenis Biaya</th>
                                    <th>User</th>
                                    <th>Minggu ke</th>
                                    <th>Budget Awal</th>
                                    <th>Total Penambahan</th>
                                    <th>Cash Out</th>
                                    <th>Actual Budget</th>
                                    <th>Presentase</th>
                                    <th>Sudah LPJ</th>
                                    <th>Belum LPJ</th>
                                    <th>Reimburse</th>
                                    <th>Sisa Budget</th>
                                    <th>Over Budget</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-center" colspan="5" style="font-size: 14px;">TOTAL : </th>
                                    <th class="text-right" id="total_budget"></th>
                                    <th class="text-right" id="total_penambahan"></th>
                                    <th class="text-right" id="total_pengeluaran"></th>
                                    <th class="text-right" id="total_act_budget"></th>
                                    <th class="text-right"></th>
                                    <th class="text-right" id="total_sudah_lpj"></th>
                                    <th class="text-right" id="total_belum_lpj"></th>
                                    <th class="text-right" id="total_reimburse"></th>
                                    <th class="text-right" id="total_sisa_budget"></th>
                                    <th class="text-right" id="total_over_budget"></th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="modal_detail_budget" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddLabel">Detail Budget</h6>
                    <p class="text-secondary small"></p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="dt_detail_budget">
                        <thead>
                            <tr>
                                <th>Id Pengajuan</th>
                                <th>User</th>
                                <th>Tanggal Input</th>
                                <th>Tanggal Approve</th>
                                <th>Penerima</th>
                                <th>Pengaju</th>
                                <th>Department</th>
                                <th>Kategori</th>
                                <th>Type</th>
                                <th>Pengajuan</th>
                                <th>Keperluan</th>
                                <th>Budget</th>
                                <th>Note User</th>
                                <th>Note Finance</th>
                                <th>Status</th>
                                <th>Status LPJ</th>
                                <th>Tanggal LPJ</th>
                                <th>Nominal LPJ</th>
                                <th>Deviasi</th>
                                <th>Cash Out</th>
                                <th>Actual Budget</th>
                                <th>Status Approve</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center" colspan="9" style="font-size: 14px;">TOTAL : </th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>