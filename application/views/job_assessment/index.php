<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Evaluasi Kesesuaian Jabatan</p>
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
                            <h6 class="fw-medium mb-0">List <?= $pageTitle ?></h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">

                            <div style="display: flex;justify-content: space-between; gap:4px">
                                <div>
                                    <button type="button" class="btn btn-success" onclick="list_panelis()"><i class="bi bi-pen"></i>
                                        Panelis</button>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-primary" onclick="input()"><i class="bi bi-person-workspace"></i>
                                        Input</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dt_assm" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Company</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Level</th>
                                    <th>Hasil Psikotest</th>
                                    <th>Hasil Panelis</th>
                                    <th>Kesimpulan</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
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

<!-- Modal Add -->
<div class="modal fade" id="modal_input" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_input">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-person-workspace h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_input_dokumen">Input <?= $pageTitle ?></h6>
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

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label-custom required small" for="karyawan">Karyawan</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text">@</span>

                                <select name="karyawan" id="karyawan" class="form-control border-custom">
                                    <option data-placeholder="true">-- Choose Employee --</option>
                                </select>
                            </div>

                        </div>

                        <div class="col-6">
                            <label class="form-label-custom required small" for="due_date">Due Date</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>


                                <input type="date" name="due_date" class="form-control" value="" title="">

                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label-custom required small" for="karyawan">From</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-record"></i></span>

                                <select name="level_from" class="form-control border-custom">
                                    <?php foreach ($level as $item) : ?>
                                        <?php if ($item->label == 'from') : ?>
                                            <option value="<?= $item->role_id ?>"><?= $item->role_name ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <label class="form-label-custom required small" for="karyawan">To</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-box-arrow-in-up"></i></span>

                                <select name="level_to" class="form-control border-custom">
                                    <?php foreach ($level as $item) : ?>
                                        <?php if ($item->label == 'to') : ?>
                                            <option value="<?= $item->role_id ?>"><?= $item->role_name ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row mb-3">

                    </div> -->

                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label-custom required small" for="panelis">Panelis</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-people"></i></span>
                                <select name="panelis[]" id="panelis" class="form-control border-custom" multiple>
                                    <option data-placeholder="true">-- Choose Employee --</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <label class="form-label required small" for="poin_kompetensi">List Poin Kompetensi
                                <!-- <span class="text-secondary small"> *tekan enter untuk tambah list</span> -->
                            </label>
                            <div class="row row_list" id="row_list1">
                                <div class="col">
                                    <div class="input-group border-custom mb-2">
                                        <span class="input-group-text bi bi-card-checklist"></span>
                                        <input type="text" class="form-control border-custom key_list" name="poin_kompetensi[]" id="poin_kompetensi" placeholder="Poin Kompetensi 1">

                                    </div>
                                </div>
                            </div>
                            <div id="tempat_list"></div>
                            <input type="hidden" id="jml_list" value="1">
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-12">
                            <button type="button" class="btn btn-sm btn-primary" onclick="tambah_list()" style="float:right; margin-left:2px">
                                <li class="fa fa-plus"></li> Add
                            </button>
                            <button type="button" id="btn_hapus_list" class="btn btn-sm btn-danger text-white" onclick="hapus_list()" disabled style="float:right">
                                <li class="fa fa-minus "></li> Del.
                            </button>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-md btn-primary">Save
                        <i class="bi bi-person-workspace"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->
<div class="modal fade" id="modal_psikotest" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_psikotest">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Input Hasil Psikotest</h6>
                        <p class="text-secondary small">Assessment</p>
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
                    <div class="row">
                        <div class="col">

                            <input type="hidden" name="id_assessment" class="form-control" value="">

                            <label class="form-label-custom required small" for="nama">Nama</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-person-exclamation"></i></span>
                                <input type="text" name="nama" class="form-control border-custom" readonly>
                            </div>
                        </div>
                        <div class="col">
                            <label class="form-label-custom required small" for="cfit">Company</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-person-exclamation"></i></span>
                                <input type="text" name="company" class="form-control border-custom" readonly>
                            </div>
                        </div>
                        <div class="col">
                            <label class="form-label-custom required small" for="army">Level</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-person-exclamation"></i></span>
                                <input type="text" name="level" class="form-control border-custom" min="0" max="100" value="0" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col nilai">
                            <label class="form-label-custom required small" for="army">Army Alpha</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-123"></i></span>
                                <input type="number" name="army_alpha" class="form-control progress-input validasi_number border-custom" min="0" max="100" value="0" required>
                            </div>
                            <input type="range" class="form-range progress-range" min="0" max="100" value="0" step="5">
                        </div>
                        <div class="col nilai">
                            <label class="form-label-custom required small" for="cfit">CFIT</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-123"></i></span>
                                <input type="number" name="cfit" class="form-control progress-input validasi_number border-custom" min="0" max="100" value="0" required>
                            </div>
                            <input type="range" class="form-range progress-range" min="0" max="100" value="0" step="5">
                        </div>
                        <div class="col nilai">
                            <label class="form-label-custom required small" for="army">IQ</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-123"></i></span>
                                <input type="number" name="iq" class="form-control progress-input validasi_number border-custom" min="0" max="200" value="0" required>
                            </div>
                            <input type="range" class="form-range progress-range" min="0" max="200" value="0" step="5">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <label class="form-label-custom required small" for="cfit">TIU</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-123"></i></span>
                                <input type="text" name="tiu" class="form-control border-custom" required readonly>
                            </div>
                        </div>
                        <div class="col">
                            <label class="form-label-custom required small" for="cfit">DISC</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-slash-circle"></i></span>
                                <input type="text" name="disc" id="" class="form-control" required readonly>
                            </div>

                        </div>
                        <div class="col">
                            <label class="form-label-custom required small" for="cfit">MBTI</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-slash-circle"></i></span>
                                <input type="text" name="mbti" id="" class="form-control" required readonly>
                            </div>

                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <label class="form-label-custom required small">Keterangan Hasil</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-check-circle-fill"></i></span>
                                <select name="keterangan" class="form-control border-custom" required>
                                    <option value="" selected disabled>-- Pilih Hasil --</option>
                                    <?php foreach ($m_assessment as $item) : ?>
                                        <?php if ($item->psikotest != null) : ?>
                                            <option value="<?= $item->id ?>"><?= $item->psikotest ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-md btn-primary">Save
                        <i class="bi bi-card-checklist"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_panelis" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form_review_panelis">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Review Hasil Panelis</h6>
                        <p class="text-secondary small">Assessment</p>
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
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive">
                                <div id="panelis_review">

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row mt-1">

                        <input type="hidden" name="id_assessment" class="form-control" value="">

                        <div class="col-4 nilai">
                            <label class="form-label-custom required small" for="army">Penilaian Akhir</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-123"></i></span>
                                <input type="number" name="avg_panelis" class="form-control progress-input validasi_number border-custom" min="0" max="100" value="0" required>
                            </div>
                            <input type="range" class="form-range progress-range" min="0" max="100" value="0" step="5">
                        </div>
                        <div class="col-4">
                            <label class="form-label-custom required small" for="army">Spesifikasi Teknis</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-fonts"></i></span>
                                <input type="text" name="spesifikasi_teknis" class="form-control border-custom" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label-custom required small">Keterangan Hasil</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-check-circle-fill"></i></span>
                                <select name="hasil_panelis" class="form-control border-custom" required>
                                    <option value="" selected disabled>-- Pilih Hasil --</option>
                                    <?php foreach ($m_assessment as $item) : ?>
                                        <?php if ($item->panelis != null) : ?>
                                            <option value="<?= $item->id ?>"><?= $item->panelis ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-md btn-primary">Save
                        <i class="bi bi-card-checklist"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_list_panelis" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form_psikotest">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">List Penilaian Panelis</h6>
                        <p class="text-secondary small">Assessment</p>
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
                    <div class="row">
                        <div class="col">
                            <table id="dt_list_panelis" class="table nowrap table-striped" width="100%">

                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Kandidat</th>
                                        <th>Level</th>
                                        <th>Nama Panelis</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Created By</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Close</button>

                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_penilaian" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_panelis">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Input Hasil Panelis</h6>
                        <p class="text-secondary small">Assessment</p>
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

                    <input type="hidden" name="id_assessment" class="form-control" value="">
                    <input type="hidden" name="panelis_id" class="form-control" value="">

                    <div class="row" id="list_poin">
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <label class="form-label-custom required small">Konfimasi</label>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="konfirmasi" id="" value="checkedValue" required>
                                    Apakah anda yakin?
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-md btn-primary">Update
                            <i class="bi bi-cursor-fill"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_detail" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-person-workspace h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal_detail_dokumen">Detail <?= $pageTitle ?></h6>
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
                <div class="row">
                    <!-- Detail Start -->
                    <div class="col-12 col-md-12 col-lg-12 col-xxl-12">
                        <div class="card border-0 mb-4">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="comingsoonbi bi-people h5 avatar avatar-40 bg-light-green text-green text-green rounded "></i>
                                    </div>
                                    <div class="col">
                                        <h6 class="fw-medium mb-0" id="d_nama">Inda Sidik</h6>
                                        <p class="text-secondary small" id="d_level">Officer To Supervisor</p>
                                    </div>
                                    <div class="col-4 text-end">
                                        <p class="text-secondary small mb-1">Hasil</p>
                                        <span class="badge bg-light-purple text-dark" id="hasil_psikotest" class="small">Psikotest : </span>
                                        <span class="badge bg-light-yellow text-dark" id="hasil_panelis" class="small">Panelis : </span>
                                        <span class="badge bg-light-red text-dark" id="kesimpulan" class="small">Kesimpulan</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3 col-md-3 mb-2">
                                        <p class="text-secondary small mb-1">Due Date</p>
                                        <h6 id="d_due_date" class="small">-</h6>
                                    </div>
                                    <div class="col-3 col-md-3 mb-2">
                                        <p class="text-secondary small mb-1">Actual Date</p>
                                        <h6 id="d_actual_date" class="small">-</h6>
                                    </div>
                                    <div class="col-3 col-md-3 mb-2">
                                        <p class="text-secondary small mb-1">Created At</p>
                                        <h6 id="d_created_at" class="small"></h6>
                                    </div>
                                    <div class="col-3 col-md-3 mb-2">
                                        <p class="text-secondary small mb-1">Created By</p>
                                        <h6 id="d_created_by" class="small">-</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p class="title">Detail Hasil Psikotest</p>
                                <table class="table table-striped table-bordered" id="detail_hasil_psikotest">
                                </table>
                                <p class="title">Detail Hasil Panelis</p>
                                <div class="table-responsive">
                                    <div id="detail_hasil_panelis"></div>
                                </div>
                                <p class="title mb-0" id="d_avg_panelis"></p>
                                <p class="title" id="d_spesifikasi_teknis"></p>
                                <form id="form_kesimpulan">
                                    <input type="hidden" name="id_assessment" class="form-control">
                                    <p class="title">Kesimpulan</p>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="input-group border-custom">
                                                <span class="input-group-text"><i class="bi bi-check-circle-fill"></i></span>
                                                <select name="keterangan" class="form-control border-custom" required>
                                                    <option value="" selected disabled>-- Pilih Hasil --</option>
                                                    <?php foreach ($m_assessment as $item) : ?>
                                                        <?php if ($item->kesimpulan != null) : ?>
                                                            <option value="<?= $item->id ?>"><?= $item->kesimpulan ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="konfirmasi" id="" value="checkedValue" required>
                                                Konfirmasi
                                            </label>
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>