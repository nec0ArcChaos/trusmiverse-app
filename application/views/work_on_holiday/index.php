<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Perintah Kerja di Hari Libur</p>
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

                            <div style="display: flex;justify-content: space-between;">
                                <div>
                                    <?php if($is_spv_up > 0 ) :?>

                                        <button type="button" class="btn btn-success" onclick="approval()"><i class="bi bi-card-checklist"></i>
                                            Approval</button>
                                        <!-- <button type="button" class="btn btn-warning" onclick="input_progres()"><i class="bi bi-card-checklist"></i>
                                            Progres Tasklist</button> -->
                                        <button type="button" class="btn btn-primary" onclick="input_perintah()"><i class="bi bi-person-workspace"></i>
                                            Input</button>
                                    <?php else: ?>

                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dt_pk" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Company</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>PIC</th>
                                    <th>Tgl. Masuk</th>
                                    <th>Status</th>
                                    <th>Note</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                    <th>Verified At</th>
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
<div class="modal fade" id="modal_input" aria-labelledby="modal_input_dokumen" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_add_pembelajar">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-person-workspace h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_input_dokumen">Input <?= $pageTitle ?></h6>
                        <p class="text-secondary small">Perintah Kerja di Hari Libur</p>
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

                                <!-- revnew -->
                                <select name="karyawan" id="karyawan" class="form-control border-custom" multiple>
                                    <option data-placeholder="true">-- Choose Employee --</option>
                                </select>
                            </div>

                        </div>
                        <div class="col-6">
                            <label class="form-label-custom required small" for="tgl_masuk">Tanggal Masuk</label>
                            <input type="date" class="form-control border-custom" name="tgl_masuk" id="tgl_masuk">
                            <!-- <div class="input-group ">
                            </div> -->
                        </div>

                    </div>
                    <!-- <div class="row mb-3">

                    </div> -->

                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label required small" for="note">Note</label>
                            <textarea name="note" id="note" rows="2"></textarea>
                        </div>

                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <label class="form-label required small" for="list_job">List Pekerjaan <span class="text-secondary small"> *tekan enter untuk tambah list</span></label>
                            <div class="row row_list" id="row_list1">
                                <div class="col">
                                    <div class="input-group border-custom mb-2">
                                        <span class="input-group-text bi bi-card-checklist"></span>
                                        <input type="text" class="form-control border-custom key_list" name="list_job[]" id="list_job" placeholder="List Pekerjaan 1">

                                    </div>
                                </div>
                            </div>
                            <div id="tempat_list"></div>
                            <input type="hidden" id="jml_list" value="1">
                        </div>
                    </div>
                    <div class="row">
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
                    <button type="button" class="btn btn-md btn-primary" id="btn_save" onclick="save()">Save
                        <i class="bi bi-person-workspace"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->
<div class="modal fade" id="modal_list" aria-labelledby="modal_list_dokumen" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_add_pembelajar">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_list_dokumen">List </h6>
                        <p class="text-secondary small">Perintah Kerja di Hari Libur</p>
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
                <input type="hidden" name="id_pk_list" value="">
                
                    <div class="row" id="joblist">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                    <!-- <button type="button" class="btn btn-md btn-primary" id="btn_save_notif" onclick="send_notif()">Save
                        <i class="bi bi-card-checklist"></i></button> -->
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->
<div class="modal fade" id="modal_list_app" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_add_pembelajar">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" >List Job</h6>
                        <p class="text-secondary small">Detail Job <span id="pic_app">pic</span></p>
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
                    <div class="row" id="joblist_app">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                    <!-- <button type="button" class="btn btn-md btn-primary" id="btn_save" >Save
                        <i class="bi bi-card-checklist"></i></button> -->
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_approval" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_add_pembelajar">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Approval Job</h6>
                        <p class="text-secondary small" id="detail"></p>
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
                    <div class="table-responsive">
                        <table id="dt_approval" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>PIC</th>
                                    <th>Jumlah Job</th>
                                    <th>Done Job</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                    <!-- <button type="button" class="btn btn-md btn-primary" id="btn_save" onclick="save()">Update
                        <i class="bi bi-card-checklist"></i></button> -->
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->
<div class="modal fade" id="modal_approval_detail" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_add_pembelajar">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Approval Job <span id="pic_job"></span></h6>
                        <p class="text-secondary small" id="detail"></p>
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
                    <div class="table-responsive">
                        <table id="dt_approval" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>PIC</th>
                                    <th>Jumlah Job</th>
                                    <th>Done Job</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-md btn-primary" id="btn_save" onclick="save()">Update
                        <i class="bi bi-card-checklist"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->