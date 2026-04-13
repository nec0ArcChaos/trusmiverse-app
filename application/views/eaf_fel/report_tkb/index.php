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
                    <div class="row mt-3 d-flex justify-content-end">
                        <div class="col col-sm-auto">
                            <form method="POST" id="form_filter">
                                <div class="input-group input-group-button reportrange">
                                    <input type="text" class="form-control range" style="cursor: pointer;" id="periode_range">
                                    <button type="button" class="btn btn-primary" id="btn_filter">
                                        <span class="">Filter</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_detail_budget" class="table nowrap table-striped dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>ID Pengajuan</th>
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
                                    <th class="text-center" colspan="7" style="font-size: 14px;">TOTAL : </th>
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
                                    <th class="text-right"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>