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
            <?php if (in_array($this->session->userdata('user_id'), $accessable)) { ?>
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
            <?php } ?>
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
                            <i class="bi bi-calendar4-range h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0"><?= $pageTitle; ?></h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;" id="table_rekap_absen">
                    </div>
                </div>
                <div class="card-footer">
                    <p>Kode Absensi : </p>
                    <ul style="font-size: 10pt;text-align: justify;">
                        <li>A : Absen / Libur Mingguan</li>
                        <li>H : Hari Libur Nasional / Pergantian hari libur nasional/Pergantian hari libur</li>
                        <li>C : Cuti Tahunan</li>
                        <li>T : Terlambat</li>
                        <li>PC : Pulang Cepat</li>
                        <li>DT : Datang Terlambat</li>
                        <li>R : Resign</li>
                        <li>F : Absen 1x</li>
                        <li>CB : Cuti Bersalin / Keguguran / Istri Bersalin / Istri Keguguran</li>
                        <li>KL : Kematian Keluarga</li>
                        <li>DL : Dinas Luar Kota (Non Driver)</li>
                        <li>DD : Dinas Luar Kota Driver</li>
                        <li>M : Karyawan Menikah</li>
                        <li>S : Karyawan Sakit</li>
                        <li>PR : Pernikahan Anak Kandung Karyawan / Pernikahan Saudara Kandung Karyawan</li>
                        <li>KA : Khitan Anak</li>
                        <li>SK : Keluarga Sakit (Anak / Suami / Istri / Orang Tua)</li>
                        <li>SW : Skripsi / Wisuda</li>
                        <li>CL : Cuti Tahun Lalu</li>
                        <li>P : Present</li>
                        <li>NP : Pulang Cepat Tanpa Izin</li>
                        <li>LV : Lock Video</li>
                        <li>LT : Lock Tasklist</li>
                        <li>LE : Lock EAF</li>
                        <li>LR : Lock Training</li>
                        <li>LA : Lock Lain-lain</li>
                    </ul>
                    <ul style="font-size: 10pt;text-align: justify;">
                        <li>Kehadiran = Total Hadir / Harus Hadir</li>
                        <li>Kedisiplinan = ( Total Hadir - Jam Masuk Tdk Sesuai - Jam Pulang Cepat Tdk Ijin - Total Ijin Pulang Cepat & Datang Terlambat - Finger 1x ) / Harus Hadir</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>


<!-- Modal Import Haris Hadir-->
<div class="modal fade" id="modal_import_harus_hadir" tabindex="-1" aria-labelledby="modalAddConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddConfirmLabel">Import Harus Hadir</h6>
                    <p class="text-secondary small">Pastikan tidak ada data kosong pada file lampiran !</p>
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
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <form id="form_harus_hadir">
                        <div class="mb-3 col-12 col-md-12">
                            <label for="attachment" class="form-label-custom required">Excel File (xls, xlsx)</label>
                            <input type="file" class="form-control border-custom" name="attachment" id="attachment" aria-describedby="attachment" placeholder="">
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md btn-outline-theme" id="btn_save_confirm">Yes, Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Import Haris Hadir -->