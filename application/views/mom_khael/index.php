<main class="main mainheight">
    <div class="container-fluid">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <!-- <p class="text-secondary">Deskripsi Page</p> -->
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
            <div class="col-auto ps-0"></div>
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
                        <div class="col-auto mb-2">
                            <i class="bi bi-journal-text h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center mb-2">
                            <h6 class="fw-medium">List Notulen</h6>
                        </div>
                        <div class="col-auto-right" align="right">
                            <button type="button" class="btn btn-md btn-outline-info mb-2" onclick="list_meeting_owner()"><i class="bi bi-bookmark"></i> List Meeting Owner</button>
                            <?php
                            $user_allow = [1, 8204, 803];
                            $user_id = $this->session->userdata('user_id');
                            ?>
                            <?php if (in_array($user_id, $user_allow)) : ?>
                                <button type="button" class="btn btn-md btn-outline-danger mb-2" onclick="list_verif(2)"><i class="bi bi-bookmark"></i> List Verif Owner</button>
                            <?php endif; ?>
                            <button type="button" class="btn btn-md btn-outline-danger mb-2" onclick="list_verif(1)"><i class="bi bi-bookmark"></i> List Verif PDCA</button>
                            <button type="button" class="btn btn-md btn-outline-secondary mb-2" onclick="list_eskalasi()"><i class="bi bi-people"></i> List Delegasi</button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-md btn-outline-primary dropdown-toggle mb-2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-bookmark-star"></i> Plan
                                </button>
                                <ul class="dropdown-menu">
                                    <li><button class="dropdown-item" onclick="list_plan_mom()">List Plan</button></li>
                                    <li><button class="dropdown-item" onclick="add_plan_mom()">Add Plan</button></li>
                                </ul>
                            </div>

                            <button type="button" class="btn btn-md btn-outline-warning mb-2" onclick="open_list_draft('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>')"><i class="bi bi-bookmark-star"></i> List Draft</button>
                            <button type="button" class="btn btn-md btn-outline-theme mb-2" onclick="add_mom()"><i class="bi bi-journal-plus"></i> Add Notulen</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_list_mom" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="150px">#</th>
                                    <th>No MoM</th>
                                    <th width="170px">Judul</th>
                                    <th>Meeting</th>
                                    <th>Department</th>
                                    <th>Peserta</th>
                                    <th>Agenda</th>
                                    <th>Pembahasan</th>
                                    <th>Tempat</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>

                                    <!-- addnew -->
                                    <th>List Peserta</th>

                                    <th>Created By</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-journals h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">Resume MoM</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0"></div>
                    </div>
                </div>
                <div class="card-body">
                    <p><span class="text-danger">*Note</span> : Check Detail Lock di Kolom <b>Progres</b></p>
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_list_rekap" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center align-middle">User</th>
                                    <th rowspan="2" class="text-center align-middle">Jabatan</th>
                                    <th rowspan="2" class="text-center align-middle">W1</th>
                                    <th rowspan="2" class="text-center align-middle">W2</th>
                                    <th rowspan="2" class="text-center align-middle">W3</th>
                                    <th rowspan="2" class="text-center align-middle">W4</th>
                                    <th rowspan="2" class="text-center align-middle">W5</th>
                                    <th rowspan="2" class="text-center align-middle">W6</th>
                                    <th colspan="2" class="text-center">Tasklist</th>
                                    <th colspan="3" class="text-center">Consistency</th>
                                    <th rowspan="2" class="text-center align-middle bg-light-yellow">Progres</th>
                                    <th rowspan="2" class="text-center align-middle bg-light-red">Revisi PDCA</th>
                                    <th rowspan="2" class="text-center align-middle bg-light-red">Revisi Owner</th>
                                    <th rowspan="2" class="text-center align-middle bg-light-green">Done</th>
                                    <th rowspan="2" class="text-center align-middle bg-light-green">Ontime</th>
                                    <th rowspan="2" class="text-center align-middle bg-light-red">Late</th>
                                    <th rowspan="2" class="text-center align-middle bg-light-red">Freq Revisi</th>
                                    <th rowspan="2" class="text-center align-middle bg-light-red">Freq Lock</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Tasklist</th>
                                    <th class="text-center">GRD</th>
                                    <th class="text-center">Daily</th>
                                    <th class="text-center">Weekly</th>
                                    <th class="text-center">Monthly</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-journals h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">Resume MoM Weekly</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0"></div>
                    </div>
                </div>
                <div class="card-body">
                    <p><span class="text-danger">*Note</span> : Lock Absen Setiap Sabtu Perminggunya <b></b></p>
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_resume_pembelajar_3" class="table table-sm table-striped text-nowrap" style="width:100%">
                            <thead id="dt_resume_head_3">
                                <tr>
                                    <th>Nama</th>
                                    <th>Company</th>
                                    <th>Jabatan</th>
                                    <th>W1</th>
                                    <th>W2</th>
                                    <th>W3</th>
                                    <th>W4</th>
                                    <th>W5</th>
                                </tr>
                            </thead>
                            <tbody id="dt_resume_body_3"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal Add -->
<div class="modal fade" id="modal_add_mom" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-journal-text h5 avatar avatar-40 bg-light text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                    <p class="text-white small">Add Notulen</p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-white dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" onclick="cancel()" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <h6 class="title">Notulen <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                    <div id="smartwizard2" class="mb-4">
                        <ul class="nav nav-fill">
                            <li class="nav-item">
                                <!-- <a class="nav-link" href="#step-111"> -->
                                <a class="nav-link">
                                    <div class="avatar avatar-40 rounded-circle mb-1">
                                        <i class="bi bi-card-text mb-1"></i>
                                    </div>
                                    <p>Detail</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <!-- <a class="nav-link" href="#step-121"> -->
                                <a class="nav-link">
                                    <div class="avatar avatar-40 rounded-circle mb-1">
                                        <i class="bi bi-columns mb-1"></i>
                                    </div>
                                    <p>Result</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <!-- <a class="nav-link" href="#step-131"> -->
                                <a class="nav-link">
                                    <div class="avatar avatar-40 rounded-circle mb-1">
                                        <i class="bi bi-check-circle mb-1"></i>
                                    </div>
                                    <p>Closing</p>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content mb-4">
                            <input type="hidden" id="id_mom_global" name="id_mom_global" value="">
                            <input type="hidden" id="id_meeting" name="id_meeting" value="">
                            <input type="hidden" id="id_plan_global" name="id_plan_global" value="">
                            <div id="step-111" class="tab-pane" role="tabpanel">
                                <div class="card border-0">
                                    <div class="card-body">
                                        <!-- Step content 1 -->
                                        <form id="form_detail">
                                            <input type="hidden" id="id_mom" name="id_mom" value="">
                                            <input type="hidden" id="closed" name="closed" value="">
                                            <input type="hidden" id="id_plan" name="id_plan" value="">
                                            <div class="row">
                                                <div class="col-12 col-md-6 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid judul">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-align-top"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control border-start-0" name="judul" id="judul" placeholder="Judul">
                                                                <label>Judul <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                                <div class="col-12 col-md-6 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid tempat">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-building"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control border-start-0" name="tempat" id="tempat" placeholder="Tempat">
                                                                <label>Tempat <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-4 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid tgl">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-event"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control border-start-0 bg-white" name="tanggal" id="tanggal" placeholder="Date" readonly>
                                                                <label><i class="bi bi-info-circle" title="Date from Created At (Auto Today)"></i> Date (Today)<b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                                <div class="col-12 col-md-4 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid start">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-clock"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control border-start-0 waktu" name="start_time" id="start_time" placeholder="Start Time">
                                                                <label>Start Time <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                                <div class="col-12 col-md-4 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid end">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-clock-history"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control border-start-0 waktu" name="end_time" id="end_time" placeholder="End Time">
                                                                <label>End Time <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-4 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid meeting">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-people-fill"></i></span>
                                                            <div class="form-control spesial">
                                                                <label style="font-size:12px;">Meeting <b class="text-danger small">*</b></label>
                                                                <select name="meeting" id="meeting" class="form-control" style="font-size:17px !important; padding-left:0px !important; padding-top:0px !important;">
                                                                    <option value="" selected disabled>-Choose-</option>
                                                                    <option value="Internal GM">Internal GM</option>
                                                                    <option value="Internal Manager">Internal Manager</option>
                                                                    <option value="Koordinasi">Koordinasi</option>
                                                                    <option value="Owner">Owner</option>
                                                                    <option value="Jobdesk">Jobdesk</option>
                                                                    <option value="Antar Divisi">Antar Divisi</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                                <div class="col-12 col-md-4 mb-2 hidden_department d-none">
                                                    <div class="form-group mb-3 position-relative check-valid department">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-buildings"></i></span>
                                                            <div class="form-control spesial">
                                                                <label style="font-size:12px;">Department <b class="text-danger small">*</b></label>
                                                                <select name="department" id="department" class="form-control" multiple>
                                                                    <option data-placeholder="true">-- Choose Department --</option>
                                                                    <?php foreach ($department as $row) : ?>
                                                                        <option value="<?= $row->id ?>"><?= $row->department ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <input type="hidden" id="list_department" name="list_department" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                                <div class="col mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid peserta">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-lines-fill"></i></span>
                                                            <div class="form-control spesial">
                                                                <label style="font-size:12px;">Peserta <b class="text-danger small">*</b></label>
                                                                <select name="peserta" id="peserta" class="form-control" multiple>
                                                                    <option data-placeholder="true">-- Choose Employee --</option>
                                                                    <?php foreach ($karyawan as $row) : ?>
                                                                        <option value="<?= $row->user_id ?>"><?= $row->employee_name ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <input type="hidden" id="user" name="user" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-3 mb-2">
                                                    <div class="mb-3 position-relative check-valid project">
                                                        <div class="input-group input-group-lg d-flex align-items-center">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-square" id="btn_show_pekerjaan" style="cursor: pointer;"></i></span>
                                                            <label style="font-size:12px;" for="btn_show_pekerjaan">Membahas Pekerjaan ?</label>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-none" id="pekerjaan_row">
                                                <div class="col-12 col-md-3 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid project">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-people-fill"></i></span>
                                                            <div class="form-control spesial">
                                                                <label style="font-size:12px;">Divisi</label>
                                                                <select name="project" id="project" class="form-control" style="font-size:17px !important; padding-left:0px !important; padding-top:0px !important;" onchange="get_pekerjaan()">
                                                                    <option data-placeholder="true">-- Choose Divisi --</option>
                                                                    <?php foreach ($project as $row) : ?>
                                                                        <option value="<?= $row->id_project ?>"><?= $row->project ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                                <div class="col-12 col-md-3 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid pekerjaan">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-people-fill"></i></span>
                                                            <div class="form-control spesial">
                                                                <label style="font-size:12px;">SO</label>
                                                                <select name="pekerjaan" id="pekerjaan" class="form-control" style="font-size:17px !important; padding-left:0px !important; padding-top:0px !important;" onchange="get_sub_pekerjaan()">
                                                                    <!-- <option data-placeholder="true">-- Choose Pekerjaan --</option>
                                                                    <?php foreach ($pekerjaan as $row) : ?>
                                                                        <option value="<?= $row->id ?>"><?= $row->pekerjaan ?></option>
                                                                    <?php endforeach; ?> -->
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                                <div class="col-12 col-md-3 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid sub_pekerjaan">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-people-fill"></i></span>
                                                            <div class="form-control spesial">
                                                                <label style="font-size:12px;">SI</label>
                                                                <select name="sub_pekerjaan" id="sub_pekerjaan" class="form-control" style="font-size:17px !important; padding-left:0px !important; padding-top:0px !important;" onchange="get_detail_pekerjaan()">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                                <div class="col-12 col-md-3 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid detail_pekerjaan">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-people-fill"></i></span>
                                                            <div class="form-control spesial">
                                                                <label style="font-size:12px;">Tasklist</label>
                                                                <select name="detail_pekerjaan[]" id="detail_pekerjaan" class="form-control" style="font-size:17px !important; padding-left:0px !important; padding-top:0px !important;" multiple>
                                                                </select>
                                                                <input type="hidden" id="list_det_pekerjaan" name="list_det_pekerjaan" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-12 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid agenda">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-receipt"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control border-start-0" name="agenda" id="agenda" placeholder="Agenda">
                                                                <label>Agenda <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-12 col-lg-12 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid pembahasan">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                                            <div class="form-floating">
                                                                <label class="form-check-label">Pembahasan <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                        <textarea name="pembahasan" id="pembahasan" class="form-control border-start-0 editor" cols="30" rows="5" style="min-height: 80px;" required></textarea>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="step-121" class="tab-pane" role="tabpanel">
                                <div class="card border-0">
                                    <div class="card-body">
                                        <!-- Result -->
                                        <div class="row mb-4">
                                            <div class="col-lg-12">
                                                <p class="text-danger">*Note: untuk Hasil/Topik/Judul bisa memilih sesuai divisi dengan format <b>divisi - goal</b>.</p>
                                                <p class="text-dark">Jika tidak ada maka pilih <b>Free Text</b></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <input type="hidden" id="total_issue" value="1">
                                                <table id="dt_mom_result" class="table table-bordered" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th width="15%">Hasil/Topik/Judul</th>
                                                            <th width="15%">Issue</th>
                                                            <th width="20%" colspan="2">Strategy</th>
                                                            <th width="10%">Kategorisasi</th>
                                                            <th width="10%">SI</th>
                                                            <th width="10%">Level</th>
                                                            <th width="10%">Deadline</th>
                                                            <th width="10%" class="div_ekspektasi">Ekspektasi</th>
                                                            <th width="10%">PIC</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="data_result"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="step-131" class="tab-pane" role="tabpanel">
                                <div class="card border-0 ">
                                    <div class="card-body">
                                        <!-- Closing -->
                                        <form id="form_closing">
                                            <div class="row">
                                                <div class="col-12 col-md-12 col-lg-12 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid closing">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-bookmark-star"></i></span>
                                                            <div class="form-floating">
                                                                <label>Closing Statement <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                        <textarea name="closing" id="closing" class="form-control border-start-0 editor ml-2" cols="30" rows="5" style="min-height: 80px;" required></textarea>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid cc">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-lines-fill"></i></span>
                                                            <div class="form-control spesial">
                                                                <label style="font-size:12px;">CC <b class="text-danger small">*</b></label>
                                                                <select name="cc" id="cc" class="form-control" multiple>
                                                                    <option data-placeholder="true">-- Choose Employee --</option>
                                                                    <?php foreach ($karyawan as $row) : ?>
                                                                        <option value="<?= $row->user_id ?>"><?= $row->employee_name ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <input type="hidden" id="user" name="user" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-warning" style="margin-right:10px;" id="btn_draft" onclick="draft(0)">Draft</button>
                <button type="button" class="btn btn-md btn-outline-success" style="margin-right:10px;" id="btn_finish" onclick="finish(1)">Finish</button>
                <button type="button" class="btn btn-md btn-outline-danger" id="btn_cancel" onclick="cancel()">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add -->

<!-- Modal Detail -->
<div class="modal fade" id="modal_detail_mom" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content" style="overflow-y: auto;">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-journal-text h5 avatar avatar-40 bg-light text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                    <p class="text-white small">Edit Result Meeting</p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-white dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <h6 class="title">Notulen</h6>
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="hidden" id="total_issue" value="1">
                                    <table id="dt_mom_result_e" class="table table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="15%">Hasil/Topik/Judul</th>
                                                <th width="15%">Issue</th>
                                                <th width="20%">Strategy</th>
                                                <th width="10%">Kategorisasi</th>
                                                <!-- <th width="10%">SI</th> -->
                                                <th width="10%">Level</th>
                                                <th width="10%">Deadline</th>
                                                <th width="10%">PIC</th>
                                                <th width="10%">Ekspektasi</th>
                                                <th width="10%">Verified</th>
                                                <th width="10%">Verified By</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Detail -->

<!-- Modal Detail Rekap -->
<div class="modal fade" id="modal_detail_rekap" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content" style="overflow-y: auto;">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-journals h5 avatar avatar-40 bg-light text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                    <p class="text-white small">Resume MoM</p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-white dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <h6 class="title">Detail Rekap</h6>
                    <p><span class="text-danger">*Note Lock</span> :</p>
                    <ol>
                        <li>Jika <b>Deadline Strategy</b> <u>kurang dari atau sama dengan</u> hari ini dan <b>Progres</b> <u>kurang dari</u> 100%</li>
                        <li>Jika <b>Deadline Goals</b> <u>kurang dari atau sama dengan</u> hari ini dan <b>Status</b> <u>belum</u> Done</li>
                        <li>Tasklist MoM di Lock mulai dari Deadline Tanggal <b>(05 Jan 2024)</b></li>
                    </ol>
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_detail_rekap" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Locked</th>
                                    <th>ID MOM</th>
                                    <th>Tgl Meeting</th>
                                    <th>User</th>
                                    <th>Topik</th>
                                    <th>Issue</th>
                                    <th>Strategy</th>
                                    <th>Kategori</th>
                                    <th>Level</th>
                                    <th>Deadline Goals</th>
                                    <th>Deadline Strategy</th>
                                    <th>Done</th>
                                    <th>Leadtime</th>
                                    <th>Status</th>
                                    <th>Progres %</th>
                                    <th>Evaluation</th>
                                    <th>File</th>
                                    <th>Link</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                    <th>Verified Note</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Detail Rekap -->

<!-- Modal List Draft -->
<div class="modal fade" id="modal_list_draft" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content" style="overflow-y: auto;">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-journals h5 avatar avatar-40 bg-light text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                    <p class="text-white small">List Draft</p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-white dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <div class="row align-items-center page-title pt-0">
                        <div class="col-12 col-md mb-sm-0">
                            <h5 class="title">List Draft</h5>
                        </div>
                        <!-- <div class="col col-sm-auto">
                                <form method="POST" id="form_filter_draft">
                                    <div class="input-group input-group-md reportrange_draft border border-1 rounded ps-3">
                                        <input type="text" class="form-control range_draft bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                                        <input type="hidden" name="start_draft" value="" id="start_draft" readonly/>
                                        <input type="hidden" name="end_draft" value="" id="end_draft" readonly/>
                                        <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </form>
                            </div> -->
                    </div>
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_list_draft" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="170px">Judul</th>
                                    <th>Meeting</th>
                                    <th>Department</th>
                                    <th>Peserta</th>
                                    <th>Agenda</th>
                                    <th>Tempat</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Created By</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal List Draft -->

<!-- Modal Proses Draft -->
<div class="modal fade" id="modal_proses_draft" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content" style="overflow-y: auto;">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-journal-text h5 avatar avatar-40 bg-light text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                    <p class="text-white small">Add Notulen</p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-white dd-arrow-none dropdown-toggle" data-bs-dismiss="modal" role="button" aria-expanded="false" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <h6 class="title">Notulen <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                    <div id="smartwizard3" class="mb-4">
                        <ul class="nav nav-fill">
                            <li class="nav-item">
                                <a class="nav-link">
                                    <div class="avatar avatar-40 rounded-circle mb-1">
                                        <i class="bi bi-card-text mb-1"></i>
                                    </div>
                                    <p>Detail</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link">
                                    <div class="avatar avatar-40 rounded-circle mb-1">
                                        <i class="bi bi-columns mb-1"></i>
                                    </div>
                                    <p>Result</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link">
                                    <div class="avatar avatar-40 rounded-circle mb-1">
                                        <i class="bi bi-check-circle mb-1"></i>
                                    </div>
                                    <p>Closing</p>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content mb-4">
                            <input type="hidden" id="id_mom_global_draft" name="id_mom_global_draft" value="">
                            <div id="step-311" class="tab-pane" role="tabpanel">
                                <div class="card border-0">
                                    <div class="card-body">
                                        <!-- Step content 1 -->
                                        <form id="form_detail_draft">
                                            <input type="hidden" id="id_mom_draft" name="id_mom_draft" value="">
                                            <input type="hidden" id="closed_draft" name="closed_draft" value="">
                                            <div class="row">
                                                <div class="col-12 col-md-6 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid judul_draft">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-align-top"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control border-start-0" name="judul_draft" id="judul_draft" placeholder="Judul">
                                                                <label>Judul <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                                <div class="col-12 col-md-6 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid tempat_draft">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-building"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control border-start-0" name="tempat_draft" id="tempat_draft" placeholder="Tempat">
                                                                <label>Tempat <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-4 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid tgl_draft">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-event"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control border-start-0 bg-white" name="tanggal_draft" id="tanggal_draft" placeholder="Date" readonly>
                                                                <label>Date <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                                <div class="col-12 col-md-4 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid start_draft">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-clock"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control border-start-0 waktu" name="start_time_draft" id="start_time_draft" placeholder="Start Time">
                                                                <label>Start Time <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                                <div class="col-12 col-md-4 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid end_draft">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-clock-history"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control border-start-0 waktu" name="end_time_draft" id="end_time_draft" placeholder="End Time">
                                                                <label>End Time <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-4 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid meeting_draft">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-people-fill"></i></span>
                                                            <div class="form-control spesial">
                                                                <label style="font-size:12px;">Meeting <b class="text-danger small">*</b></label>
                                                                <select name="meeting_draft" id="meeting_draft" class="form-control" style="font-size:17px !important; padding-left:0px !important; padding-top:0px !important;">
                                                                    <option value="" selected disabled>-- Choose Meeting --</option>
                                                                    <option value="Internal GM">Internal GM</option>
                                                                    <option value="Internal Manager">Internal Manager</option>
                                                                    <option value="Koordinasi">Koordinasi</option>
                                                                    <option value="Owner">Owner</option>
                                                                    <option value="Jobdesk">Jobdesk</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                                <div class="col-12 col-md-4 mb-2 hidden_department_draft d-none">
                                                    <div class="form-group mb-3 position-relative check-valid department_draft">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-buildings"></i></span>
                                                            <div class="form-control spesial">
                                                                <label style="font-size:12px;">Department <b class="text-danger small">*</b></label>
                                                                <select name="department_draft" id="department_draft" class="form-control" multiple>
                                                                    <option data-placeholder="true">-- Choose Department --</option>
                                                                    <?php foreach ($department as $row) : ?>
                                                                        <option value="<?= $row->id ?>"><?= $row->department ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <input type="hidden" id="list_department_draft" name="list_department_draft" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                                <div class="col mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid peserta_draft">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-lines-fill"></i></span>
                                                            <div class="form-control spesial">
                                                                <label style="font-size:12px;">Peserta <b class="text-danger small">*</b></label>
                                                                <select name="peserta_draft" id="peserta_draft" class="form-control" multiple>
                                                                    <option data-placeholder="true">-- Choose Employee --</option>
                                                                    <?php foreach ($karyawan as $row) : ?>
                                                                        <option value="<?= $row->user_id ?>"><?= $row->employee_name ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <input type="hidden" id="user_draft" name="user_draft" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-3 mb-2">
                                                    <div class="mb-3 position-relative check-valid project">
                                                        <div class="input-group input-group-lg d-flex align-items-center">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-square" id="e_btn_show_pekerjaan" style="cursor: pointer;"></i></span>
                                                            <label style="font-size:12px;">Membahas Pekerjaan</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-none" id="e_pekerjaan_row">
                                                <div class="col-12 col-md-3 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid project">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-people-fill"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control border-start-0" id="e_project" placeholder="Project" readonly>
                                                                <input type="hidden" class="form-control border-start-0" name="project" id="draft_project" placeholder="Project" readonly>
                                                                <label>Divisi</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                                <div class="col-12 col-md-3 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid pekerjaan">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-people-fill"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control border-start-0" id="e_pekerjaan" placeholder="Pekerjaan" readonly>
                                                                <input type="hidden" class="form-control border-start-0" name="pekerjaan" id="draft_pekerjaan" placeholder="Pekerjaan" readonly>
                                                                <label>SO</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                                <div class="col-12 col-md-3 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid sub_pekerjaan">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-people-fill"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control border-start-0" id="e_sub_pekerjaan" placeholder="Sub Pekerjaan" readonly>
                                                                <input type="hidden" class="form-control border-start-0" name="sub_pekerjaan" id="draft_sub_pekerjaan" placeholder="Sub Pekerjaan" readonly>
                                                                <label>SI</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                                <div class="col-12 col-md-3 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid detail_pekerjaan">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-people-fill"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control border-start-0" id="e_detail_pekerjaan" placeholder="Detail Pekerjaan" readonly>
                                                                <input type="hidden" class="form-control border-start-0" name="list_det_pekerjaan" id="draft_detail_pekerjaan" placeholder="Detail Pekerjaan" readonly>
                                                                <label>Tasklist</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-12 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid agenda_draft">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-receipt"></i></span>
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control border-start-0" name="agenda_draft" id="agenda_draft" placeholder="Agenda">
                                                                <label>Agenda <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-12 col-lg-12 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid pembahasan_draft">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                                            <div class="form-floating">
                                                                <label class="form-check-label">Pembahasan <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                        <textarea name="pembahasan_draft" id="pembahasan_draft" class="form-control border-start-0 editor_draft" cols="30" rows="5" style="min-height: 80px;"></textarea>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="step-321" class="tab-pane" role="tabpanel">
                                <div class="card border-0">
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <div class="col-lg-12">
                                                <p class="text-danger">*Note: untuk Hasil/Topik/Judul bisa memilih sesuai divisi dengan format <b>divisi - goal</b>.</p>
                                                <p class="text-dark">Jika tidak ada maka pilih <b>Free Text</b></p>
                                            </div>
                                        </div>
                                        <!-- Result -->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <input type="hidden" id="total_issue_draft" value="1">
                                                <table id="dt_mom_result_draft" class="table table-bordered" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th width="15%">Hasil/Topik/Judul</th>
                                                            <th width="15%">Issue</th>
                                                            <th width="20%" colspan="2">Strategy</th>
                                                            <th width="10%">Kategorisasi</th>
                                                            <th width="10%">SI</th>
                                                            <th width="5%">Level</th>
                                                            <th width="5%">Deadline</th>
                                                            <th width="10%" class="div_ekspektasi">Ekspektasi</th>
                                                            <th width="10%">PIC</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="data_issue">
                                                        <tr id="div_issue_draft_1">
                                                            <input type="hidden" id="total_action_draft_1" value="1">
                                                            <td class="kolom_modif" id="td_issue_draft_1" data-id="issue_draft_1_1" rowspan="2">
                                                                <select class="form-control goals_draft" id="val_goals_draft_2_1" onchange="handle_goals_draft_change('goals_draft_1_1')">
                                                                    <option>- Choose goal -</option>
                                                                    <?php foreach ($goals as $goal) : ?>
                                                                        <option value="<?php echo $goals->id_goal ?>"><?php echo $goals->goal ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                                <span id="issue_draft_1_1">&nbsp;</span>
                                                                <textarea class="form-control" id="val_issue_draft_1_1" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea_draft('val_issue_draft_1_1')" onfocusout="submit_update_draft('issue_draft_1_1')"></textarea>
                                                            </td>
                                                            <td width="1%" id="no_draft_1_1">1.</td>
                                                            <td class="kolom_modif" id="td_action_draft_1_1" data-id="action_draft_1_1">
                                                                <span id="action_draft_1_1">&nbsp;</span>
                                                                <textarea class="form-control" id="val_action_draft_1_1" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea_draft('val_action_draft_1_1')" onfocusout="submit_update_draft('action_draft_1_1')"></textarea>
                                                            </td>
                                                            <td class="kolom_modif" id="td_kategori_draft_1_1" data-id="kategori_draft_1_1">
                                                                <select class="form-control" id="val_kategori_draft_1_1" onchange="submit_update_draft('kategori_draft_1_1')">
                                                                    <option>- Choose -</option>
                                                                    <?php foreach ($kategori as $ktg) : ?>
                                                                        <option value="<?php echo $ktg->id ?>"><?php echo $ktg->kategori ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </td>
                                                            <td class="kolom_modif" id="td_deadline_draft_1_1" data-id="deadline_draft_1_1">
                                                                <span id="deadline_draft_1_1">&nbsp;</span>
                                                                <textarea class="form-control" id="val_deadline_draft_1_1" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea_draft('val_deadline_draft_1_1')" onfocusout="submit_update('deadline_draft_1_1')"></textarea>
                                                                <input type="text" class="form-control tanggal" id="val_date_deadline_draft_1_1" style="display: none;" onfocusout="submit_update_draft('deadline_draft_1_1')">
                                                            </td>
                                                            <td id="td_pic_draft_1_1">
                                                                <select id="val_pic_draft_1_1" class="form-control pic_draft" multiple onchange="submit_update_draft('pic_draft_1_1')">
                                                                    <option data-placeholder="true">-- Choose Employee --</option>
                                                                    <?php foreach ($pic as $row) : ?>
                                                                        <option value="<?= $row->user_id ?>"><?= $row->employee_name ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr id="div_issue_action_draft_1">
                                                            <td style="cursor: pointer;" colspan="6">
                                                                <span class="btn btn-md btn-outline-success" onclick="add_action_draft(1)"><i class="bi bi-list-ol"></i> Add Strategy</span>
                                                            </td>
                                                        </tr>
                                                        <tr id="div_issue_draft">
                                                            <td style="cursor: pointer;" colspan="7">
                                                                <span class="btn btn-md btn-outline-success" onclick="add_issue_draft(1)"><i class="bi bi-plus-square"></i> </i> Add Issue</span>
                                                            </td>
                                                        </tr>
                                                        <div id="div_custom_draft"></div>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="step-331" class="tab-pane" role="tabpanel">
                                <div class="card border-0 ">
                                    <div class="card-body">
                                        <!-- Closing -->
                                        <form id="form_closing_draft">
                                            <div class="row">
                                                <div class="col-12 col-md-12 col-lg-12 mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid closing_draft">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-bookmark-star"></i></span>
                                                            <div class="form-floating">
                                                                <label>Closing Statement <b class="text-danger small">*</b></label>
                                                            </div>
                                                        </div>
                                                        <textarea name="closing_draft" id="closing_draft" class="form-control border-start-0 editor ml-2" cols="30" rows="5" style="min-height: 80px;" required></textarea>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-2">
                                                    <div class="form-group mb-3 position-relative check-valid cc">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-lines-fill"></i></span>
                                                            <div class="form-control spesial">
                                                                <label style="font-size:12px;">CC <b class="text-danger small">*</b></label>
                                                                <select name="cc_draft" id="cc_draft" class="form-control" multiple>
                                                                    <option data-placeholder="true">-- Choose Employee --</option>
                                                                    <?php foreach ($karyawan as $row) : ?>
                                                                        <option value="<?= $row->user_id ?>"><?= $row->employee_name ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <input type="hidden" id="user" name="user" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-warning" style="margin-right:10px;" id="btn_draft_e" onclick="draft_e(0)">Draft</button>
                <button type="button" class="btn btn-md btn-outline-success" style="margin-right:10px;" id="btn_finish_e" onclick="finish_draft(1)">Finish</button>
            </div>
        </div>
    </div>
</div>
<!-- test -->
<!-- Modal Proses Draft -->

<!-- Modal Add Plan MoM -->
<div class="modal fade" id="modal_add_plan_mom" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content" style="overflow-y: auto;">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-journal-text h5 avatar avatar-40 bg-light text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                    <p class="text-white small">Add Plan MoM</p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-white dd-arrow-none dropdown-toggle" data-bs-dismiss="modal" role="button" aria-expanded="false" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <h6 class="title">Plan MoM <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                    <div class="card border-0">
                        <div class="card-body">
                            <form id="form_plan">
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid judul_plan">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-align-top"></i></span>
                                                <div class="form-floating">
                                                    <input type="text" class="form-control border-start-0" name="judul_plan" id="judul_plan" placeholder="Judul">
                                                    <label>Judul <b class="text-danger small">*</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid tempat_plan">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-building"></i></span>
                                                <div class="form-floating">
                                                    <input type="text" class="form-control border-start-0" name="tempat_plan" id="tempat_plan" placeholder="Tempat">
                                                    <label>Tempat <b class="text-danger small">*</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid tgl_plan">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme border-end-0"><i class="bi bi-calendar-event"></i></span>
                                                <div class="form-floating">
                                                    <input type="text" class="form-control border-start-0 tanggal_plan" name="tanggal_plan" id="tanggal_plan" placeholder="Date">
                                                    <label>Date <b class="text-danger small">*</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid meeting_plan">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-people-fill"></i></span>
                                                <div class="form-control spesial">
                                                    <label style="font-size:12px;">Meeting <b class="text-danger small">*</b></label>
                                                    <select name="meeting_plan" id="meeting_plan" class="form-control" style="font-size:17px !important; padding-left:0px !important; padding-top:0px !important;">
                                                        <option value="" selected disabled>-Choose-</option>
                                                        <option value="Internal">Internal</option>
                                                        <option value="Koordinasi">Koordinasi</option>
                                                        <option value="Owner">Owner</option>
                                                    </select>
                                                    <-3 position-relative check-valid meeting_plan">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-people-fill"></i></span>
                                                            <div class="form-control spesial">
                                                                <label style="font-size:12px;">Meeting <b class="text-danger small">*</b></label>
                                                                <select name="meeting_plan" id="meeting_plan" class="form-control" style="font-size:17px !important; padding-left:0px !important; padding-top:0px !important;">
                                                                    <option value="" selected disabled>-Choose-</option>
                                                                    <option value="Internal">Internal</option>
                                                                    <option value="Koordinasi">Koordinasi</option>
                                                                    <option value="Owner">Owner</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="invalid-feedback mb-3">Add valid data </div>
                                            </div>
                                            <div class="col-12 col-md-6 mb-2 hidden_department_plan d-none">
                                                <div class="form-group mb-3 position-relative check-valid department_plan">
                                                    <div class="input-group input-group-lg">
                                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-buildings"></i></span>
                                                        <div class="form-control spesial">
                                                            <label style="font-size:12px;">Department <b class="text-danger small">*</b></label>
                                                            <select name="department_plan" id="department_plan" class="form-control" multiple>
                                                                <option data-placeholder="true">-- Choose Employee --</option>
                                                                <?php foreach ($department as $row) : ?>
                                                                    <option value="<?= $row->id ?>"><?= $row->department ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <input type="hidden" id="list_department_plan" name="list_department_plan" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback mb-3">Add valid data </div>
                                            </div>
                                            <div class="col mb-2">
                                                <div class="form-group mb-3 position-relative check-valid peserta_plan">
                                                    <div class="input-group input-group-lg">
                                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-lines-fill"></i></span>
                                                        <div class="form-control spesial">
                                                            <label style="font-size:12px;">Peserta <b class="text-danger small">*</b></label>
                                                            <select name="peserta_plan" id="peserta_plan" class="form-control" multiple>
                                                                <option data-placeholder="true">-- Choose Employee --</option>
                                                                <?php foreach ($karyawan as $row) : ?>
                                                                    <option value="<?= $row->user_id ?>"><?= $row->employee_name ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <input type="hidden" id="user_plan" name="user_plan" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback mb-3">Add valid data </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 mb-2">
                                                <div class="form-group mb-3 position-relative check-valid note_plan">
                                                    <div class="input-group input-group-lg">
                                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journal-text"></i></span>
                                                        <div class="form-floating">
                                                            <textarea name="note_plan" id="note_plan" cols="30" rows="10" class="form-control start-0" placeholder="Note"></textarea>
                                                            <label>Note</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback mb-3">Add valid data </div>
                                            </div>
                                        </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-md btn-outline-success" id="btn_save_plan" onclick="save_plan()">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- test sampai plan -->
</div>
</div>
<!-- Modal Add Plan MoM -->

<!-- Modal List Plan MoM -->
<div class="modal fade" id="modal_list_plan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content" style="overflow-y: auto;">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-journals h5 avatar avatar-40 bg-light text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                    <p class="text-white small">List Plan MoM</p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-white dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <h6 class="title">List Plan MoM</h6>
                    <p><span class="text-danger">*Note Lock</span> :</p>
                    <ol>
                        <li>Check Bahan MoM di Kolom <b>Status Bahan</b></li>
                        <li>Jika <b>File/Link</b> <u>belum di upload</u> dan Deadline <u>kurang dari atau sama dengan</u> hari ini</li>
                        <li>Upload File/Materi untuk Plan MoM di Lock mulai dari Deadline Tanggal <b>(22 Jan 2024)</b></li>
                    </ol>
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_list_plan" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="170px">Judul</th>
                                    <th>Tempat</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Meeting</th>
                                    <th>Department</th>
                                    <th>Peserta</th>
                                    <th>Note</th>
                                    <th>Created By</th>
                                    <th>Deadline Bahan</th>
                                    <th>Status Bahan</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal List Plan MoM -->

<!-- Modal List Bahan Plan MoM -->
<div class="modal fade" id="modal_list_plan_bahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content" style="overflow-y: auto;">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-journals h5 avatar avatar-40 bg-light text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                    <p class="text-white small">List Bahan MoM</p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-white dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <h6 class="title">List Bahan MoM</h6>
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_list_plan_bahan" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>PIC</th>
                                    <th>File</th>
                                    <th>Link</th>
                                    <th>Note</th>
                                    <th>Updated By</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal List Bahan Plan MoM -->

<div class="modal fade" id="modal_list_verif" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content" style="overflow-y: auto;">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-journal-text h5 avatar avatar-40 bg-light text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal_title_list_verif">List Verified Owner</h6>
                    <p class="text-white small"></p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-white dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <label for="">Filter : </label>
                                </div>
                                <div class="col">
                                    <form>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="filter_verif" value="" id="all_filter">
                                            <label class="form-check-label fw-bold" for="all_filter">
                                                All
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="filter_verif" value="<?= date('Y-m-d') ?>" id="hari_ini_filter" checked>
                                            <label class="form-check-label fw-bold" for="hari_ini_filter">
                                                Hari Ini
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="filter_verif" value="<?= date('Y-m-d', strtotime('+1 day')) ?>" id="besok_filter">
                                            <label class="form-check-label fw-bold" for="besok_filter">
                                                Besok
                                            </label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="hidden" id="input_verif_form" value="">
                                    <input type="hidden" id="input_verif_tipe" value="">
                                    <input type="hidden" id="input_verif_url" value="">
                                    <div class="table-responsive">
                                        <table id="dt_list_verif" class="table table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th width="15%">ID Mom </th>
                                                    <th width="15%">Hasil/Topik/Judul</th>
                                                    <th width="15%">Issue</th>
                                                    <th width="20%">Strategy</th>
                                                    <th width="5%">Kategorisasi</th>
                                                    <!-- <th width="10%">SI</th> -->
                                                    <th width="5%">Level</th>
                                                    <th width="5%">Deadline</th>
                                                    <th width="10%">PIC</th>
                                                    <th width="10%">Ekspektasi</th>
                                                    <th width="15%">Evaluasi</th>
                                                    <th width="10%">Created By</th>
                                                    <th width="10%">Verified</th>
                                                    <th width="10%">Verified By</th>
                                                    <th width="10%">Verified At</th>
                                                    <th width="10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_list_meeting_owner" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content" style="overflow-y: auto;">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-journal-text h5 avatar avatar-40 bg-light text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal_title_list_verif">List Meeting Owner</h6>
                    <p class="text-white small"></p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-white dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="hidden" id="input_verif_form" value="">
                                    <input type="hidden" id="input_verif_tipe" value="">
                                    <input type="hidden" id="input_verif_url" value="">
                                    <div class="table-responsive">
                                        <table id="dt_list_meeting_owner" class="table table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th width="15%">ID Mom </th>
                                                    <th width="15%">Hasil/Topik/Judul</th>
                                                    <th width="15%">Issue</th>
                                                    <th width="20%">Strategy</th>
                                                    <th width="5%">Kategorisasi</th>
                                                    <!-- <th width="10%">SI</th> -->
                                                    <th width="5%">Level</th>
                                                    <th width="5%">Deadline</th>
                                                    <th width="10%">PIC</th>
                                                    <th width="10%">Ekspektasi</th>
                                                    <th width="15%">Evaluasi</th>
                                                    <th width="10%">Created By</th>
                                                    <th width="10%">Verified</th>
                                                    <th width="10%">Verified By</th>
                                                    <th width="10%">Verified At</th>
                                                    <th width="10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_list_eskalasi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content" style="overflow-y: auto;">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-journal-text h5 avatar avatar-40 bg-light text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddLabel">List Eskalasi</h6>
                    <p class="text-white small"></p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-white dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table id="dt_list_eskalasi" class="table table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="15%">ID MOM</th>
                                                <th width="15%">Issue</th>
                                                <th width="20%">Strategy</th>
                                                <!-- <th width="5%">Kategorisasi</th> -->
                                                <th width="5%">Deadline</th>
                                                <th width="10%">PIC</th>
                                                <th width="10%">Status</th>
                                                <th width="5%">Progres</th>
                                                <th width="15%">Evaluasi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>