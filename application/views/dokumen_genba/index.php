<main class="main mainheight">
<div class="container-fluid">
<div class="row" style="margin-top: 10px;">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="col-6">
                    <h4 class="card-title">Dokumen Genba</h4>
                </div>
                <div class="col-6">
                    <a class="btn btn-rounded btn-primary btn-sm" href="<?= base_url('dokumen_genba/add_genba') ?>" style="float:right;margin-left:4px">
                        <i class="fa fa-plus-circle color-primary"></i>
                        Add Data</a>
                </div>
            </div>

            <div class="card-body">
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-lg-3 col-md-12 col-sm-12">
                        <form method="POST" id="form_filter">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group input-group-button" id="reportrange">
                                        <input type="text" class="form-control" id="range" style="cursor: pointer;">
                                        <input type="hidden" name="datestart" value="" id="datestart" />
                                        <input type="hidden" name="dateend" value="" id="dateend" />
                                        <button type="button" class="btn btn-info btn-outline-info" onclick="show_filter()">
                                            <span class="">Filter</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="list_dokumen_genba" class="table table-striped display nowrap" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th class="text-center">ID Genba</th>
                                <th>PIC</th>
                                <th>Tanggal</th>
                                <th>Divisi</th>
                                <th>Company</th>
                                <th>Departmen</th>
                                <th>Narasumber</th>
                                <th>Dokumen</th>
                                <th>Temuan</th>
                                <th>Analisa</th>
                                <th>Solusi</th>
                                <th>Rekomendasi</th>
                                <th>Masalah</th>
                                <th>Keluhan</th>
                                <th>Keinginan</th>
                                <th>Bukti Pelaksanaan</th>
                                <th>Evaluasi</th>
                                <th>Created at</th>
                                <th>Created By</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</main>
