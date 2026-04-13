<main class="main mainheight">
    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-file-earmark-text h5 avatar avatar-40 bg-light-theme rounded"></i>
                                </div>
                                <div class="col-auto align-self-center">
                                    <h6 class="fw-medium">Dokumen Genba</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row justify-content-end">
                                <div class="col-auto">
                                    <form method="POST" id="form_filter">
                                        <div class="input-group input-group-md" id="reportrange">
                                            <input type="text" class="form-control" id="range" style="cursor: pointer;">
                                            <input type="hidden" name="datestart" value="" id="datestart" />
                                            <input type="hidden" name="dateend" value="" id="dateend" />
                                            <button type="button" class="btn btn-theme" onclick="show_filter()">
                                                <i class="bi bi-search"></i> Filter
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-auto">
                                    <a class="btn btn-theme" href="<?= base_url('od_dokumen_genba/add_genba') ?>">
                                        <i class="bi bi-plus-circle"></i> Add Data
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="list_dokumen_genba" class="table table-sm table-striped" style="width:100%">
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
</main>
