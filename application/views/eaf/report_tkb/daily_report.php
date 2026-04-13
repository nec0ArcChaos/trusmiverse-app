<div class="row">
    <div class="col"></div>
    <div class="col-sm-4 m-b-5">
        <form action="">
            <div class="row">
                <div class="col-sm-12">
                    <div class="input-group input-group-button" id="reportrange">
                        <input type="text" class="form-control" id="range" style="cursor: pointer;">
                        <input type="hidden" name="datestart" id="datestart" value="2021-09-01">
                        <input type="hidden" name="dateend" id="dateend" value="2021-09-30">
                        <button type="button" id="filter_date" class="btn btn-info btn-outline-info">
                            <span class="ti-search"></span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="row" id="data_daily"></div>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h5>Pembawaan</h5>
                <div class="card-header-right">
                    <i class="icofont icofont-spinner-alt-5"></i>
                </div>
            </div>
            <div class="card-block">
                <div class="table-responsive dt-responsive">
                    <table class="table table-striped table-bordered dt-responsive display" id="dt_pembawaan">
                        <thead>
                            <tr>
                                <th>Tgl</th>
                                <th>Qty</th>
                                <th>Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h5>Reimbursment</h5>
                <div class="card-header-right">
                    <i class="icofont icofont-spinner-alt-5"></i>
                </div>
            </div>
            <div class="card-block">
                <div class="table-responsive dt-responsive">
                    <table class="table table-striped table-bordered dt-responsive display" id="dt_reimburs">
                        <thead>
                            <tr>
                                <th>Tgl</th>
                                <th>Qty</th>
                                <th>Nominal</th>
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

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h5>LPJ</h5>
                <div class="card-header-right">
                    <i class="icofont icofont-spinner-alt-5"></i>
                </div>
            </div>
            <div class="card-block">
                <div class="table-responsive dt-responsive">
                    <table class="table table-striped table-bordered dt-responsive display" id="dt_lpj">
                        <thead>
                            <tr>
                                <th>Tgl</th>
                                <th>Qty</th>
                                <th>Pembawaan</th>
                                <th>LPJ</th>
                                <th>Sisa</th>
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

<!-- Modal detail budget -->

<div class="modal fade" id="modal_detail_budget" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 1300px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Budget</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="table-responsive dt-responsive">
                    <table class="table table-striped table-bordered" id="dt_detail_budget">
                        <thead>
                            <tr>
                                <th>Id Pengajuan</th>
                                <th>User</th>
                                <th>Tanggal Input</th>
                                <th>Tanggal Approve</th>
                                <th>Divisi</th>
                                <th>Penerima</th>
                                <th>Kategori</th>
                                <th>Type</th>
                                <th>Pengajuan</th>
                                <th>Keperluan</th>
                                <th>Budget</th>
                                <th>Note</th>
                                <th>Note Keperluan</th>
                                <th>Status</th>
                                <th>Status LPJ</th>
                                <th>Tanggal LPJ</th>
                                <th>Nominal LPJ</th>
                                <th>Deviasi</th>
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
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #eee7e7;">
                <button class="btn btn-default" style="margin-right: 30px;" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>