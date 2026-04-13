<main class="main mainheight">
    <div class="container-fluid mb-4">
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
                        <div class="col-12">
                            <div class="float-start">
                                <div class="row">
                                    <div class="col-auto">
                                        <i class="bi bi-book h5 avatar avatar-40 bg-light-theme rounded"></i>
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <h6 class="fw-medium mb-0"><?= $pageTitle; ?></h6>
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-3 float-lg-end">
                                <button type="button" class="btn btn-md btn-primary mt-2" onclick="modal_add_workshop()" style="width:100%">
                                    <i class="bi bi-plus"></i> Add New
                                </button>
                            </div>

                        </div>
                    </div>

                    <div class="ui special popup">
                        <div class="header">Custom Header</div>
                        <div class="ui button">Click Me</div>
                    </div>

                    <div class="row mt-3">
                        <div class="col col-sm-auto">
                            <div class="input-group input-group-md border rounded reportrange">
                                <span class="input-group-text text-theme"><i class="bi bi-calendar"></i></span>
                                <input type="text" class="form-control range bg-none" style="cursor: pointer;" id="titlecalendar">
                                <input type="hidden" name="start" value="<?= date("Y-m-01"); ?>" id="start" />
                                <input type="hidden" name="end" value="<?= date("Y-m-t"); ?>" id="end" />
                                <!-- <a href="javascript:void(0)" class="input-group-text text-secondary bg-none" id="titlecalandershow" onclick="filter_data()"><i class="bi bi-search"></i></a> -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_workshop" class="table table-sm table-striped table-hover table-bordered text-nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <!-- <th class="small text-nowrap">#</th> -->
                                    <th class="small text-nowrap">Tgl Workshop</th>
                                    <th class="small text-nowrap">Jam Workshop</th>
                                    <th class="small text-nowrap">Title</th>
                                    <th class="small text-nowrap">Status</th>
                                    <th class="small text-nowrap">Type</th>
                                    <th class="small text-nowrap">Trainer</th>
                                    <th class="small text-nowrap">Company - Department</th>
                                    <th class="small text-nowrap" style="min-width: 150px;">Participant Plan</th>
                                    <th class="small text-nowrap">Participant Actual</th>
                                    <th class="small text-nowrap">Commitment</th>
                                    <th class="small text-nowrap">Documentation</th>
                                    <th class="small text-nowrap">Created System</th>
                                    <th class="small text-nowrap">Created By</th>
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

<!-- Modal Tambah Workshop -->
<div class="modal fade" id="modal_add_workshop" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header d-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Form Workshop</h6>
                        <p class="small text-secondary">Tambah Data Workshop</p>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form action="" id="form_add_workshop">
                    <div class="row">
                        <div class="col-4 mb-2">
                            <label class="small">Tanggal Plan Workshop</label>
                            <div class="input-group input-group-md border rounded">
                                <span class="input-group-text text-theme"><i class="bi bi-calendar-date"></i></span>
                                <input class="form-control tanggal mask-date" type="text" id="workshop_at" name="workshop_at" autocomplete="OFF" placeholder="Tanggal Workshop">
                            </div>
                        </div>
                        <div class="col-4 mb-2">
                            <label class="small">Tanggal End Workshop</label>
                            <div class="input-group input-group-md border rounded">
                                <span class="input-group-text text-theme"><i class="bi bi-calendar-date"></i></span>
                                <input class="form-control tanggal mask-date" type="text" id="workshop_end" name="workshop_end" autocomplete="OFF" placeholder="Tanggal End Workshop">
                            </div>
                        </div>
                        <div class="col-4 mb-2">
                            <label class="small">Waktu Workshop</label>
                            <div class="input-group input-group-md border rounded">
                                <span class="input-group-text text-theme"><i class="bi bi-calendar-date"></i></span>
                                <input class="form-control" type="time" id="workshop_time" name="workshop_time" autocomplete="OFF" placeholder="Waktu Workshop">
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <label class="small">Tipe Workshop</label>
                            <div class="input-group input-group-md border rounded">
                                <span class="input-group-text text-theme"><i class="bi bi-tags"></i></span>
                                <select id="workshop_type" name="workshop_type" class="ui selection dropdown col border-0">
                                </select>
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <label class="small">Department</label>
                            <div class="input-group input-group-md border rounded">
                                <span class="input-group-text text-theme"><i class="bi bi-buildings"></i></span>
                                <select id="department_id" name="department_id" class="ui mini search dropdown col border-0" multiple="">
                                </select>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <label class="small">Peserta</label>
                            <div class="input-group input-group-md border rounded">
                                <span class="input-group-text text-theme"><i class="bi bi-people"></i></span>
                                <select id="participant_plan" name="participant_plan" class="ui mini search dropdown col border-0" multiple="">
                                </select>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <label class="small">Materi</label>
                            <div class="input-group input-group-md border rounded">
                                <span class="input-group-text text-theme"><i class="bi bi-clipboard"></i></span>
                                <select id="title_id" name="title_id" class="ui search dropdown col border-0">
                                </select>
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <label class="small">Sumber Pemateri</label>
                            <div class="input-group input-group-md border rounded">
                                <span class="input-group-text text-theme"><i class="bi bi-geo-alt"></i></span>
                                <select id="source" name="source" class="ui selection dropdown col border-0" onchange="check_source_trainer()">
                                    <option value="Internal">Internal</option>
                                    <option value="Eksternal">Eksternal</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6 mb-2" id="div_trainer_select">
                            <label class="small">Pemateri</label>
                            <div class="input-group input-group-md border rounded">
                                <span class="input-group-text text-theme"><i class="bi bi-person-video3"></i></span>
                                <select id="trainer_id" name="trainer_id" class="ui search dropdown col border-0">
                                </select>
                            </div>
                        </div>
                        <div class="col-6 mb-2" id="div_trainer_name">
                            <label class="small">Pemateri</label>
                            <div class="input-group input-group-md border rounded">
                                <span class="input-group-text text-theme"><i class="bi bi-person-video3"></i></span>
                                <input class="form-control" type="text" id="trainer_name" name="trainer_name" placeholder="Pemateri">
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <label class="small">Tempat</label>
                            <div class="input-group input-group-md border rounded">
                                <span class="input-group-text text-theme"><i class="bi bi-geo-alt"></i></span>
                                <input class="form-control" type="text" id="workshop_place" name="workshop_place" placeholder="Tempat Workshop">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" id="btn_save_workshop" onclick="save_workshop()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update Workshop -->
<div class="modal fade" id="modal_update_workshop" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" id="dialog_modal_update_workshop">
        <div class="modal-content">
            <div class="modal-header d-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Form Workshop</h6>
                        <p class="small text-secondary">Update Data Workshop</p>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg">
                        <div class="card border-0 bg-gradient-theme-light theme-yellow" id="div_detail_workshop">
                            <div class="card-header bg-none">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <p class="small text-secondary mb-1">Workshop Date</p>
                                        <p><i class="bi bi-calendar-date"></i> <span id="p_workshop_at"></span> <i class="bi bi-clock"></i> <span id="p_workshop_time"></span></p>
                                    </div>
                                    <div class="col-auto" id="div_resend_notif">
                                        <a role="button" class="btn btn-link bg-light-green text-green" onclick="resend_notif()">
                                            Resend Notif <i class="bi bi-whatsapp h5 avatar avatar-30 bg-light-green text-green text-green rounded "></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body bg-none">
                                <h5 class="text-center mb-1" id="p_title">-</h5>
                                <p class="text-muted text-center mb-4" id="p_trainer_name"></p>
                                <span class="btn btn-sm btn-link bg-light-pink text-pink" id="p_status">-</span>
                                <span class="btn btn-sm btn-link bg-light-green text-green" id="p_type_name">-</span>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <p class="small text-secondary m-0 p-0">Department :</p>
                                        <p class="small m-0 p-0" id="p_department_name"></p>
                                    </div>
                                    <div class="col-6">
                                        <p class="small text-secondary mb-3 mt-2">Participant Plan :</p>
                                        <div id="p_participant"></div>
                                    </div>
                                    <div class="col-6">
                                        <p class="small text-secondary mb-3 mt-2">Participant Actual :</p>
                                        <div id="p_participant_actual"></div>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <p class="small text-secondary m-0 p-0">Commitment :</p>
                                        <p class="small m-0 p-0" id="p_commitment"></p>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <p class="small text-secondary m-0 p-0">Documentation :</p>
                                        <p class="small m-0 p-0" id="p_documentation"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg" id="div_form_update_workshop">
                        <form action="" id="form_update_workshop">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <label class="small">Peserta yang hadir</label>
                                    <div class="input-group input-group-md border rounded">
                                        <span class="input-group-text text-theme"><i class="bi bi-people"></i></span>
                                        <select id="e_participant_actual" name="participant_actual" class="ui mini search dropdown col border-0" multiple="">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <label class="small">Commitment</label>
                                    <div class="input-group input-group-md border rounded">
                                        <span class="input-group-text text-theme"><i class="bi bi-check"></i></span>
                                        <textarea name="e_commitment" id="e_commitment" class="form-control" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                                <input type="hidden" id="e_workshop_id" readonly>
                                <div class="col-12 mb-2">
                                    <label class="small">Dokumentasi</label>
                                    <div class="input-group input-group-md border rounded">
                                        <span class="input-group-text text-theme"><i class="bi bi-geo-alt"></i></span>
                                        <input type="file" class="col" name="e_documentation" id="e_documentation">
                                    </div>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-theme" onclick="update_workshop()">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="modal-footer text-end">
            </div>
        </div>
    </div>
</div>