<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="sub-title" style="font-size: 12pt;"><strong><?= $pageTitle ?></strong></h4>

                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-sm-8"></div>
                        <div class="col-sm-4 m-b-5">
                            <form action="">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group input-group-button" id="reportrange">
                                            <input type="text" class="form-control" id="range" style="cursor: pointer;">
                                            <input type="hidden" name="datestart" id="datestart" value="" />
                                            <input type="hidden" name="dateend" id="dateend" value="" />
                                            <button type="button" id="filter_date" class="btn btn-info btn-outline-info">
                                                <span class="ti-search"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive dt-responsive">
                        <table class="table table-striped table-bordered dt-responsive display" id="dt_report">
                            <thead>
                                <tr>
                                    <th>Id Pengajuan</th>
                                    <th>User</th>
                                    <th>Tanggal Input</th>
                                    <th>Tanggal Approve</th>
                                    <th>Pengaju</th>
                                    <th>Penerima</th>
                                    <th>Kategori</th>
                                    <th>Type</th>
                                    <th>Keperluan</th>
                                    <th>Budget</th>
                                    <th>Note</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Status LPJ</th>
                                    <th>Tanggal LPJ</th>
                                    <th>Nominal</th>
                                    <th>Deviasi</th>
                                    <th>Actual Budget</th>
                                    <th>Status Approve</th>
                                    <th>Leadtime LPJ</th>
                                    <th>Status Leadtime</th>
                                    <th>Tanggal Nota</th>
                                    <th>Finance</th>
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