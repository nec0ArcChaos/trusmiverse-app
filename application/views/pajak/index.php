<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Reminder Admin Pajak</p>
            </div>
            <div class="col col-sm-auto">
                <form method="POST" id="form_filter">
                    <div class="input-group input-group-md reportrange">
                        <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                        <input type="hidden" name="start" value="" id="start" readonly />
                        <input type="hidden" name="end" value="" id="end" readonly />
                        <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
                    </div>
                </form>
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
                            <i class="bi bi-currency-dollar h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Pajak</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                            <!-- Mba Fafri -->
                            <?php if ($this->session->userdata('user_id') == 78 || $this->session->userdata('user_id') == 1 || $this->session->userdata('user_id') == 5840  || $this->session->userdata('user_id') == 81   || $this->session->userdata('user_id') == 466   || $this->session->userdata('user_id') == 4302   || $this->session->userdata('user_id') == 1680) : ?>
                                <button type="button" class="btn btn-md btn-outline-theme" onclick="add_pph21()"><i class="bi bi-node-plus"></i> Add New</button>
                            <?php endif; ?>

                            <!-- Bu Fani -->
                            <!-- addnew 3961: Benny S, 1436: Sofian N, 4347: Siti Nur M  -->
                            <?php if ($this->session->userdata('user_id') == 77 || $this->session->userdata('user_id') == 3961 || $this->session->userdata('user_id') == 1436 || $this->session->userdata('user_id') == 4347 || $this->session->userdata('user_id') == 1 || $this->session->userdata('user_id') == 81 || $this->session->userdata('user_id') == 4302) : ?>
                                <button type="button" class="btn btn-md btn-outline-theme" onclick="list_verif_pph21()"><i class="bi bi-list"></i> List Pajak</button>
                            <?php endif; ?>

                            <!-- Mba Eka -->
                            <?php if ($this->session->userdata('user_id') == 81 || $this->session->userdata('user_id') == 1) : ?>
                                <button type="button" class="btn btn-md btn-outline-theme" onclick="list_paid_pph21()"><i class="bi bi-files"></i> Paid Pajak</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="" style="padding: 10px;">
                        <table id="dt_list_pph21" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id Pajak</th>
                                    <th>Attachment</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                    <th>Note</th>
                                    <th>Category</th>
                                    <th>Verified File</th>
                                    <th>Verified At</th>
                                    <th>Verified By</th>
                                    <th>Paid File</th>
                                    <th>Paid At</th>
                                    <th>Paid By</th>
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
<div class="modal fade" id="modal_add_pph21" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_input_pph21">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-lightbulb-fill h5 avatar avatar-40 bg-light-blue text-cyan rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                        <p class="text-secondary small">Input Pajak</p>
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
                        <h6 class="title">Detail <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-files"></i></span>
                                        <div class="form-floating">
                                            <label>Attachment (Bukti Chat) <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                    <!-- <textarea name="problem" id="problem" cols="30" rows="10" class="form-control border-start-0"></textarea> -->
                                    <input type="file" name="attachment" id="attachment" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2">
                            <!-- <div class="text-center mb-2">
                                <i class="bi bi-grid-3x3-gap text-theme" style="font-size: 1.7rem;"></i>
                            </div> -->
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                <span class="input-group-text text-theme bg-white border-end-0">
                                    <i class="bi bi-tags-fill"></i>
                                </span>
                                <div class="form-floating">
                                    <select name="kategori" id="kategori" class="form-select border-start-0" required>
                                    <option value="" disabled selected>Loading...</option>
                                    </select>
                                    <label>Kategori <i class="text-danger">*</i></label>
                                </div>
                                </div>
                            </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <label>Note</label>
                                        </div>
                                    </div>
                                    <input type="text" name="note" id="note" class="form-control">
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-md btn-outline-theme" id="btn_save" onclick="save_pph21()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->

<!-- Modal list pph for verified -->
<div class="modal fade" id="modal_list_verif_pph21" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_input_pph21">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-lightbulb-fill h5 avatar avatar-40 bg-light-blue text-cyan rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">List Waiting Pajak</h6>
                        <!-- <p class="text-secondary small">PPH 21</p> -->
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
                    <div class="" style="padding: 10px;">
                        <table id="dt_verif_pph21" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id Pajak</th>
                                    <th>Attachment</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                    <th>Note</th>
                                    <th>Category</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal list pph for verified -->

<!-- Modal Verifikasi -->
<div class="modal fade" id="modal_verifikasi" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_verifikasi_pph21">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-lightbulb-fill h5 avatar avatar-40 bg-light-blue text-cyan rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form Verifikasi Pajak</h6>
                        <!-- <p class="text-secondary small"></p> -->
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
                        <h6 class="title">Detail <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-files"></i></span>
                                        <div class="form-floating">
                                            <label>Bukti File (Bukti Chat)<i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                    <input type="file" name="file_verif" id="file_verif" class="form-control">
                                    <input type="hidden" name="id_pajak" id="id_pajak">
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <label>Note</label>
                                        </div>
                                    </div>
                                    <input type="text" name="note_verif" id="note_verif" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-md btn-outline-theme" id="btn_save_verif" onclick="verif_pph21()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal verifikasi pph21 -->

<!-- Modal List PAID PPH 21 -->
<div class="modal fade" id="modal_list_paid_pph21" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_input_pph21">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-lightbulb-fill h5 avatar avatar-40 bg-light-blue text-cyan rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">List Verified Pajak</h6>
                        <!-- <p class="text-secondary small">PPH 21</p> -->
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
                    <div class="" style="padding: 10px;">
                        <table id="dt_paid_pph21" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id Pajak</th>
                                    <th>Attachment</th>
                                    <th>Status</th>
                                    <th>Verified At</th>
                                    <th>Verified By</th>
                                    <th>Note</th>
                                    <th>Category</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal list PAID PPH 21 -->

<!-- Modal PAID -->
<div class="modal fade" id="modal_paid" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_paid_pph21">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-lightbulb-fill h5 avatar avatar-40 bg-light-blue text-cyan rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form Paid Pajak</h6>
                        <!-- <p class="text-secondary small"></p> -->
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
                        <h6 class="title">Detail <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-files"></i></span>
                                        <div class="form-floating">
                                            <label>Bukti File kirim Pajak<i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                    <input type="file" name="file_paid" id="file_paid" class="form-control">
                                    <input type="hidden" name="id_pajak_paid" id="id_pajak_paid">
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <label>Note</label>
                                        </div>
                                    </div>
                                    <input type="text" name="note_paid" id="note_paid" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-md btn-outline-theme" id="btn_save_paid" onclick="save_paid_pph21()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal PAID pph21 -->

<!-- Modal Proses Gemba -->
<div class="modal fade" id="modal_proses_resume" tabindex="-1" aria-labelledby="modalListProsesLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-lightbulb-fill h5 avatar avatar-40 bg-light-orange text-orange rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalListProsesLabel">Proses</h6>
                    <p class="text-secondary small">Problem Solving</p>
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
                    <h6 class="title">Detail <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                    <div class="row align-items-center mb-3">
                        <div class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-card-list h5 avatar avatar-40 bg-info text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_category">...</h6>
                                    <p class="text-secondary small">Category</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-bell h5 avatar avatar-40 bg-warning text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_priority">...</h6>
                                    <p class="text-secondary small">Priority</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-calendar-event h5 avatar avatar-40 bg-danger text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_deadline">...</h6>
                                    <p class="text-secondary small">Deadline</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <form id="form_proses_resume">
                            <input type="hidden" id="id_ps" name="id_ps">
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-check-square"></i></span>
                                        <div class="form-floating">
                                            <select name="status_akhir" id="status_akhir" class="form-control">
                                                <option value="#">-- Choose Status --</option>
                                                <?php foreach ($status as $sts) : ?>
                                                    <option value="<?= $sts->id; ?>"><?= $sts->status; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>Status <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <label>Resume <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                    <textarea name="resume" id="resume" cols="30" rows="10" class="form-control border-start-0"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-md btn-outline-theme ms-2" onclick="save_proses_resume()" id="btn_save_proses_resume">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Proses Resume -->