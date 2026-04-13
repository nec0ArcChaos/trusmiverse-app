<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <!-- <p class="text-secondary">Perintah Kerja di Hari Libur</p> -->
            </div>
            <div class="col col-sm-auto">
                <div class="input-group input-group-md reportrange">
                    <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;">
                    <input type="hidden" name="startdate" value="" id="start" />
                    <input type="hidden" name="enddate" value="" id="end" />
                    <span class="input-group-text text-secondary bg-none" id="btn_filter"><i class="bi bi-calendar-event"></i></span>
                </div>
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
                            <i class="bi bi-person-workspace h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Lolos <?= $pageTitle ?></h6>
                        </div>
                        <div class="col justify-content-end d-flex">
                            <button type="button" class="btn btn-primary" onclick="show_daftar_psikotes();"><i class="bi bi-box-arrow-in-right"></i>
                                Daftar Interview HR</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dt_lp" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Position</th>
                                    <th>Candidate Name</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Apply Date</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- Gagal Psikotes -->
    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-person-workspace h5 avatar avatar-40 bg-danger rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Gagal <?= $pageTitle ?></h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dt_gp" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Position</th>
                                    <th>Candidate Name</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Apply Date</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Modal Detail Psikotes -->
<div class="modal" id="modal_detail_psikotes" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" style="color: white;"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <h5 class="text-bold mb-3">Hasil Psikotes</h5>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        IQ
                    </div>
                    <div class="col-8 d-flex">
                        <div class="me-2">:</div><span id="detail_iq">14</span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        DISC
                    </div>
                    <div class="col-8 d-flex">
                        <div class="me-2">:</div>
                        <div><span id="detail_current" class="me-3">(Current : )</span><span id="detail_presure" class="me-3">(Presure : )</span><span id="detail_self">(Self : )</span></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        Keterangan
                    </div>
                    <div class="col-8 d-flex">
                        <div class="me-2">:</div><span id="detail_ket">tidak lanjut interview, karena gagal melakukan test psikotes dan proses tidak dilanjutkan</span>
                    </div>
                </div>
            </div>
            <div class=" modal-footer">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Edit Status -->
<div class="modal" id="modal_status" tabindex="-1" style="z-index: 1101;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="modal-title" style="color: white;">Ubah Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_status">
                    <div class="row mb-2">
                        <div class="col">
                            <label for="score" class="form-label-custom required small">Score</label>
                        </div>
                        <div class="col">
                            <label for="disc1" class="form-label-custom required small">DISC</label>
                        </div>
                        <input type="hidden" id="app_id" name="app_id">
                        <input type="hidden" id="status_app" name="status_app">
                        <input type="hidden" id="job_id_before" name="job_id_before">
                        <div class="col"></div>
                        <div class="col"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="input-group">
                                <input type="number" class="form-control" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" readonly id="score" name="score">
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group">
                                <input type="text" class="form-control" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" id="disc1" name="disc1" readonly>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group">
                                <input type="text" class="form-control" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" id="disc2" name="disc2" readonly>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group">
                                <input type="text" class="form-control" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" id="disc3" name="disc3" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="loker" class="form-label-custom required small">Loker</label>
                        <!-- <div class="select_loker col-sm-12 " style="overflow: hidden;">
                            <select name="loker" class=" form-control wide text-wrap" id="loker"></select>
                        </div> -->
                        <div class="select_loker col-sm-12 ">
                            <select name="loker" class="" id="loker"></select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-7">
                            <label for="keterangan" class="form-label-custom required small">Keterangan/Rekomendasi HR</label>
                            <div class="input-group">
                                <textarea type="text" class="form-control" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" rows="5" id="keterangan" name="keterangan"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <label for="status" class="form-label-custom required small">Status</label>
                            <div class="input-group">
                                <select name="status" id="status" onchange="updateKeterangan()">
                                    <option value="" disabled selected>--Pilih Status--</option>
                                    <option value="3">Interview User</option>
                                    <option value="4">Gagal Psikotes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12" id="alasan" style="display:none;">
                            <label for="select_alasan" class="form-label-custom required small mt-2">Alasan</label>
                            <div class="input-group">
                                <select id="select_alasan" name="select_alasan" class="form-control" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                    <option value="" disabled selected>- Alasan -</option>
                                    <?php foreach ($alasan as $key => $value) { ?>
                                        <option value="<?= $value->id; ?>"><?= $value->reason; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class=" modal-footer">
                <button type="button" class="btn btn-primary me-2" onclick="save_status()" id="btn_save_status">Simpan</button>
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal List Interview HR -->
<div class="modal" id="modal_daftar_psikotes" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="modal-title" style="color: white;">Interview HR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="m-3">
                    <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
                        <div class="card border-0">
                            <div class="card-header d-flex justify-content-between">
                                <div class="row">
                                    <div class="col-auto">
                                        <i class="bi bi-person-workspace h5 avatar avatar-40 bg-light-theme rounded"></i>
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <h6 class="fw-medium mb-0">List Interview HR</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-sm-auto">
                                        <div class="input-group input-group-md reportrange">
                                            <input type="text" class="form-control range2 bg-none px-0" style="cursor: pointer;" onchange="filter_permintaan()">
                                            <input type="hidden" name="startdate_permintaan" value="" id="start_permintaan" />
                                            <input type="hidden" name="enddate_permintaan" value="" id="end_permintaan" />
                                            <span class="input-group-text text-secondary bg-none" style="cursor: pointer;" onclick="filter_permintaan()"><i class="bi bi-calendar-event"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="dt_dp" class="table nowrap table-striped" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Position</th>
                                                <th>Candidate Name</th>
                                                <th>Contact</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Apply Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" modal-footer">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>