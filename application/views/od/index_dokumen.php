<main class="main mainheight">
    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-person-lines-fill h5 avatar avatar-40 bg-light-theme rounded"></i>
                                </div>
                                <div class="col-auto align-self-center">
                                    <h6 class="fw-medium">Dokumen OD</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row justify-content-end">
                                <div class="col-auto">
                                    <select class="form-control" id="sel_dept">
                                        <option value="" disabled selected>Select Department</option>
                                        <option value="0">All</option>
                                        <?php foreach ($get_departments as $key) { ?>
                                        <option value="<?= $key->department_id ?>"><?= $key->department_name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group input-group-md" id="reportrange">
                                        <input type="text" class="form-control" id="range" style="cursor: pointer;" autocomplete="off">
                                        <input type="hidden" name="datestart" id="datestart">
                                        <input type="hidden" name="dateend" id="dateend">
                                        <button class="btn btn-theme" onclick="show_data()">
                                            <i class="bi bi-search"></i> Filter
                                        </button>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <a href="<?= base_url('od_dokumen/form_add') ?>" class="btn btn-theme">
                                        <i class="bi bi-plus-circle"></i> Add Data
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_job_profile" class="table table-sm table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>No. ID</th>
                                <th>Judul</th>
                                <th>Jenis</th>
                                <th>Category</th>
                                <th>Priority</th>
                                <th>Department</th>
                                <th>Company</th>
                                <th>Status</th>
                                <th>Tgl. Buat</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
