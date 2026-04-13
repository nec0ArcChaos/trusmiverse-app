<main class="main mainheight">
        <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-lg-3 col-md-3 mb-2 mb-sm-0">
                <div class="form-group mb-3 position-relative check-valid">
                    <div class="input-group input-group-lg">
                        <?php $accessable = array(1, 979, 323, 1161, 778, 5684, 329, 8446); ?>
                        <?php if (in_array($this->session->userdata('user_id'), $accessable)) { ?>
                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-building"></i></span>
                            <div class="form-floating">
                                <select name="company" id="company" class="form-control border-start-0">
                                    <option value="0">All Companies</option>
                                    <?php foreach ($get_company as $cmp) : ?>
                                        <option value="<?php echo $cmp->company_id ?>"><?php echo $cmp->company ?></option>
                                    <?php endforeach ?>
                                </select>
                                <label>Company</label>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 mb-2 mb-sm-0">
                <div class="form-group mb-3 position-relative check-valid">
                    <div class="input-group input-group-lg">
                        <?php if (in_array($this->session->userdata('user_id'), $accessable)) { ?>
                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-rolodex"></i></span>
                            <div class="form-floating">
                                <select name="department" id="department" class="form-control border-start-0">
                                    <option value="0">All Departments</option>
                                </select>
                                <label>Department</label>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- <?php if (in_array($this->session->userdata('user_id'), $accessable)) { ?>
            <div class="col-lg-3 col-md-3 mb-2 mb-sm-0">
                <div class="form-group mb-3 position-relative check-valid">
                    <div class="input-group input-group-lg">

                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill"></i></span>
                            <div class="form-floating">
                                <select name="employee" id="employee" class="form-control border-start-0">
                                    <option value="0">All Employees</option>
                                </select>
                                <label>Employee</label>
                            </div>
                            
                        </div>
                    </div>
                </div>
            <?php } ?> -->
            <div class="col-lg-3 col-md-3 mb-2 mb-sm-0">
                <div class="form-group mb-3 position-relative check-valid">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar"></i></span>
                        <div class="form-floating">
                            <input type="text" class="form-control" name="periode" id="periode" value="<?php echo date('Y-m') ?>" />
                            <label>Periode</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- addnew Cutoff -->
            <?php //if (in_array($this->session->userdata('user_id'), $accessable)) { ?>
            <div class="col-lg-2 col-md-3 mb-2 mb-sm-0">
                <div class="form-group mb-3 position-relative check-valid">
                    <div class="input-group input-group-lg">
                        
                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-range"></i></span>
                            <div class="form-floating">
                                <select name="cutoff" id="cutoff" class="form-control border-start-0">
                                    <!-- <option value="0">All Companies</option> -->
                                    <option value="1" <?= ($id_cutoff == 1) ? 'selected' : '' ?>>21-20</option>
                                    <option value="2" <?= ($id_cutoff == 2) ? 'selected' : '' ?>>16-15</option>
                                    <option value="3" <?= ($id_cutoff == 3) ? 'selected' : '' ?>><?= date("01") ?>-<?= date("t") ?></option>
                                </select>
                                <label>Cutoff</label>
                            </div>

                        </div>
                    </div>
                </div>
            <?php //} ?>

            <div class="col-lg-1 col-md-1 mb-2 mb-sm-0">
                <span class="btn btn-primary" id="btn_filter" style="width: 100%;" data-toggle="tooltip" data-placement="top" title="Tooltip on top">Filter</span>
            </div>
            <div class="col-auto ps-0">

            </div>
        </div>

        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle; ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-blockquote-left h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Jadwal Shift</h6>
                            <small  style="color:black">
                                Pilih <b style="color:red">Company, Department</b> dan <b style="color:red"> Cutoff</b> terlebih dahulu sebelum download template.
                            </small>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                            <button type="button" class="btn btn-md btn-outline-primary" onclick="show_jam_shift()">
                                Cek Jam Shift
                            </button>
                            <button type="button" class="btn btn-md btn-outline-theme" onclick="call_download_template()">Download Template</button>
                            <button type="button" class="btn btn-md btn-outline-success" onclick="call_upload_template()">Upload Jadwal</button>
                            <input type="file" id="file_jadwal" accept=".xlsx,.xls" style="display:none">
                        </div>
                        
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="d-flex flex-column flex-md-row justify-content-between gap-2">

                                <div class="d-flex flex-column flex-sm-row gap-2">

                                    <select id="filter_fullname" class="form-select w-auto">
                                        <option value="">Full Name</option>
                                    </select>

                                    <select id="filter_shift" class="form-select w-auto">
                                        <option value="">Shift</option>
                                    </select>

                                    <select id="filter_hari" class="form-select w-auto">
                                        <option value="">Hari</option>
                                    </select>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="" style="padding: 10px;">
                        <table id="dt_jadwal_shift" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Company</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Full name</th>
                                    <th>Tanggal</th>
                                    <th>Hari</th>
                                    <th>Shift</th>
                                    <th>Cutoff</th>
                                    <th>Jam</th>
                                    <th>Input At</th>
                                    <th>Input By</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal Add -->
<div class="modal fade" id="modal_edit_shift" >
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Shift</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="edit_id_jadwal">

                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="text" id="edit_tanggal" class="form-control" readonly>
                </div>

                <div class="form-group mt-3">
                    <label>Shift Before</label>
                    <input type="text" id="edit_shift_before" class="form-control" readonly></select>
                </div>

                <div class="form-group mt-3">
                    <label>Shift After</label>
                    <select id="edit_shift" class="form-control"></select>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" onclick="update_shift()">Save</button>
            </div>

        </div>
    </div>
</div>
<!-- Modal Add -->

<div class="modal fade" id="modal_jam_shift" >
    <div class="modal-dialog modal-xl">
    <div class="modal-content">

    <div class="modal-header">
    <h5 class="modal-title">Jam Shift</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

    <div class="row mb-3">

    <div class="col-md-3">
    <select id="filter_grup_shift" class="form-select">
    <option value="">Semua Grup</option>
    </select>
    </div>

    <div class="col-md-3">
    <select id="filter_shift_name" class="form-select">
    <option value="">Semua Shift</option>
    </select>
    </div>

    </div>

    <table id="table_jam_shift" class="table table-striped dt-responsive" style="width:100%">
    <thead>
    <tr>
    <th>Grup</th>
    <th>Shift Name</th>
    <th>Designation</th>
    <th>Senin</th>
    <th>Selasa</th>
    <th>Rabu</th>
    <th>Kamis</th>
    <th>Jumat</th>
    <th>Sabtu</th>
    <th>Minggu</th>
    </tr>
    </thead>
    <tbody></tbody>
    </table>

    </div>
    </div>
    </div>
</div>
<script type="text/javascript">
    // OVERRIDE BOOTSTRAP MODAL FOCUS TRAP
    // Menjalankan script ini secara global untuk memastikan input pada SlimSelect bisa di-klik di dalam Modal
    document.addEventListener('focusin', function (e) {
        if (e.target.closest('.ss-main') || e.target.closest('.ss-content')) {
            e.stopImmediatePropagation();
        }
    });
</script>