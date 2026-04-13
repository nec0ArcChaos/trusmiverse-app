<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Pembelajar | Proaktif | Penebar Energi Positif</p>
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
                            <i class="bi bi-blockquote-left h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Co & Co</h6>
                        </div>
                        <div class="col-auto ps-0 ms-auto">
                            <?php if (in_array($this->session->userdata('user_role_id'), array(1, 2, 3, 4, 5)) == 1) { ?>
                                <button type="button" class="btn btn-md btn-outline-danger me-2" onclick="add_coaching_ai()">Jadwalkan Co & Co AI</button>
                            <?php } ?>
                            <button type="button" class="btn btn-md btn-outline-theme" onclick="add_coaching()">Add Co & Co</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_list_coaching" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id Coaching</th>
                                    <th>Karyawan</th>
                                    <th>Tempat</th>
                                    <th>Tanggal</th>
                                    <th>Atasan</th>
                                    <th style="min-width: 150px;text-align:justify;">Review</th>
                                    <th style="min-width: 150px;text-align:justify;">Goals</th>
                                    <th style="min-width: 150px;text-align:justify;">Reality</th>
                                    <th style="min-width: 150px;text-align:justify;">Option</th>
                                    <th style="min-width: 150px;text-align:justify;">Will</th>
                                    <th style="min-width: 150px;text-align:justify;">Komitmen</th>
                                    <th>Foto</th>
                                    <th>Poin Utama</th>
                                    <th>Isu</th>
                                    <th>% Burnout</th>
                                    <th>Hipotesis Akar Permasalahan</th>
                                    <th style="min-width: 150px;text-align:justify;">Created By</th>
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
                            <i class="bi bi-blockquote-left h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">Resume Coaching & Counseling Weekly</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                        </div>
                    </div>
                </div>
                <div class="card-body" style="width: 100%;">
                    <div class="" style="padding: 10px; overflow:scroll;">
                        <table id="dt_resume_pembelajar_3" class="table table-sm table-striped text-nowrap" style="width:100%">
                            <thead id="dt_resume_head_3">
                                <!-- <tr>
                                    <th>Nama</th>
                                    <th>Company</th>
                                    <th>Jabatan</th>
                                    <th>W1</th>
                                    <th>W2</th>
                                    <th>W3</th>
                                    <th>W4</th>
                                    <th>W5</th>
                                    
                                </tr> -->
                            </thead>
                            <tbody id="dt_resume_body_3"></tbody>
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
                            <i class="bi bi-blockquote-left h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">Resume Coaching & Counseling Monthly</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="" style="padding: 10px;">
                        <table id="dt_resume_pembelajar_m_3" class="table table-sm table-striped text-nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Company</th>
                                    <th>Jabatan</th>
                                    <th>Coaching</th>
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
                            <i class="bi bi-blockquote-left h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">Resume Ketercapaian Event Project</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                        </div>
                    </div>
                </div>
                <div class="card-body" style="width: 100%;">
                    <div class="" style="padding: 10px; overflow:scroll;">
                        <table id="dt_resume_ketercapaian" class="table table-sm table-striped text-nowrap" style="width:100%">
                            <thead id="dt_resume_ketercapaian_head">
                                <!-- <tr>
                                    <th>Nama</th>
                                    <th>Company</th>
                                    <th>Jabatan</th>
                                    <th>W1</th>
                                    <th>W2</th>
                                    <th>W3</th>
                                    <th>W4</th>
                                    <th>W5</th>
                                    
                                </tr> -->
                            </thead>
                            <tbody id="dt_resume_ketercapaian_body"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<!-- Modal Add -->
<div class="modal fade" id="modal_add_coaching" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form_coaching">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-blockquote-left h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                        <p class="text-secondary small">Add Coaching & Counselling</p>
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
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-bounding-box"></i></span>
                                        <div class="form-floating">
                                            <select name="karyawan" id="karyawan" class="form-control" onchange="change_karyawan()">
                                                <option value="#">-Choose Employee-</option>
                                                <?php foreach ($karyawan as $kar) { ?>
                                                    <option value="<?= $kar->user_id; ?>|<?= $kar->kode; ?>"><?= $kar->employee_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Karyawan <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-up"></i></span>
                                        <div class="form-floating">
                                            <select name="atasan" id="atasan" class="form-control">
                                                <option value="#">-Choose Employee-</option>
                                                <?php foreach ($atasan as $up) { ?>
                                                    <option value="<?= $up->user_id; ?>"><?= $up->employee_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Atasan Langsung <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-geo-alt"></i></span>
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0" name="tempat" id="tempat" placeholder="Tempat">
                                            <label>Tempat <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-event"></i></span>
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0 bg-white" name="tanggal" id="tanggal" readonly>
                                            <label>Tanggal <small>(Auto Today)</small><i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journal-album"></i></span>
                                        <div class="form-floating">
                                            <label>Review <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                    <textarea name="review" id="review" cols="30" rows="10" class="form-control border-start-0" placeholder="Review"></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journal-text"></i></span>
                                        <div class="form-floating">
                                            <label>Goals <small>(Apa yang ingin dicapai)</small><i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                    <textarea name="goals" id="goals" cols="30" rows="10" class="form-control border-start-0" placeholder="Goals"></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journal-bookmark"></i></span>
                                        <div class="form-floating">
                                            <label>Reality <small>(Dimana anda pada saat ini)</small><i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                    <textarea name="reality" id="reality" cols="30" rows="10" class="form-control border-start-0" placeholder="Reality"></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journals"></i></span>
                                        <div class="form-floating">
                                            <label>Option <small>(Apa yang bisa anda lakukan)</small><i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                    <textarea name="option" id="option" cols="30" rows="5" class="form-control border-start-0" placeholder="Option"></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journal-medical"></i></span>
                                        <div class="form-floating">
                                            <label>Will <small>(Apa yang akan anda lakukan)</small><i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                    <textarea name="will" id="will" cols="30" rows="5" class="form-control border-start-0"></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journal-check"></i></span>
                                        <div class="form-floating">
                                            <label>Komitmen & Afirmasi <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                    <textarea name="komitmen" id="komitmen" cols="30" rows="5" class="form-control border-start-0"></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-folder-check"></i></span>
                                        <div class="form-floating">
                                            <label>Foto <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                    <input type="file" class="form-control border-start-0" id="foto" name="foto" autocomplete="off" accept="image/*">
                                </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-folder-check"></i></span>
                                        <div class="form-floating">
                                            <label>Link Video <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control border-start-0" id="link_video" name="link_video" autocomplete="off" accept="image/*">
                                </div>
                            </div>
                        </div>
                        <!-- add pekerjaan umam -->
                        <div class="row">
                            <div class="col">
                                <input type="checkbox" name="" id="ceklis_pekerjaan">
                                <label for="ceklis_pekerjaan">Berhubungan dengan pekerjaan ? </label>
                            </div>
                        </div>
                        <div class="row row_pekerjaan" style="display: none;">
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-house"></i></span>
                                        <div class="form-floating">
                                            <select name="project" id="id_project" class="form-control" style="display: none;">
                                                <option value="" disabled>-Pilih Project-</option>
                                                <?php foreach ($project as $item) : ?>
                                                    <option value="<?= $item->id_project ?>"><?= $item->project ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>Project <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-house"></i></span>
                                        <div class="form-floating">
                                            <select name="id_pekerjaan" id="id_pekerjaan" class="form-control" style="display: none;">
                                                <option value="" disabled>-Pilih Pekerjaan-</option>
                                                <?php foreach ($pekerjaan as $item) : ?>
                                                    <option value="<?= $item->id ?>"><?= $item->pekerjaan ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>Pekerjaan <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-circle-fill"></i></span>
                                        <div class="form-floating">
                                            <select name="id_sub_pekerjaan" id="id_sub_pekerjaan" class="form-control" style="display: none;">

                                            </select>
                                            <label>Sub Pekerjaan <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-dash-circle"></i></span>
                                        <div class="form-floating">
                                            <select name="id_detail_pekerjaan[]" id="id_detail_pekerjaan" class="form-control" style="display: none;" multiple>

                                            </select>
                                            <label>Detail <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end add pekerjaan -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-md btn-outline-theme" id="btn_save" onclick="save_coaching()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->


<!-- Modal Add AI -->
<div class="modal fade" id="modal_add_coaching_ai" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form_coaching_ai">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-blockquote-left h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                        <p class="text-secondary small">Add Coaching & Counselling</p>
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
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-bounding-box"></i></span>
                                        <div class="form-floating">
                                            <select name="karyawan_ai" id="karyawan_ai" class="form-control" onchange="change_karyawan_ai()">
                                                <option value="#">-Choose Employee-</option>
                                                <?php foreach ($karyawan as $kar) { ?>
                                                    <option value="<?= $kar->user_id; ?>|<?= $kar->kode; ?>"><?= $kar->employee_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Karyawan <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-up"></i></span>
                                        <div class="form-floating">
                                            <select name="atasan_ai" id="atasan_ai" class="form-control">
                                                <option value="#">-Choose Employee-</option>
                                                <?php foreach ($atasan as $up) { ?>
                                                    <option value="<?= $up->user_id; ?>"><?= $up->employee_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Atasan Langsung <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-geo-alt"></i></span>
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0" name="tempat_ai" id="tempat_ai" placeholder="Tempat" value="AI Counseling" readonly>
                                            <label>Tempat <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-event"></i></span>
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0 bg-white" name="tanggal_ai" id="tanggal_ai">
                                            <label>Tanggal <small>(Auto Today)</small><i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journal-album"></i></span>
                                        <div class="form-floating">
                                            <label>Tema Counseling / Tema Masalah<i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                    <textarea name="review_ai" id="review_ai" cols="30" rows="10" class="form-control border-start-0" placeholder="Tema Konseling/Tema Coaching"></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                <div id="div_review_ai"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-md btn-outline-theme" id="btn_save_ai" onclick="save_coaching_ai()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add AI -->

<!-- Modal List Proses -->
<div class="modal fade" id="modal_list_proses" tabindex="-1" aria-labelledby="modalListProsesLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-list h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalListProsesLabel">List Proses</h6>
                    <p class="text-secondary small">Plan Genba</p>
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
                <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="" style="padding: 10px;">
                                <table id="dt_list_proses" class="table table-striped dt-responsive" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Id Genba</th>
                                            <th>Date Plan</th>
                                            <th>Type Genba</th>
                                            <th>Lokasi</th>
                                            <th>Evaluasi</th>
                                            <th>Jml Peserta</th>
                                            <th>Created At</th>
                                            <th>Created By</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal List Proses -->

<!-- Modal Proses Gemba -->
<div class="modal fade" id="modal_proses_gemba" tabindex="-1" aria-labelledby="modalListProsesLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalListProsesLabel">Proses</h6>
                    <p class="text-secondary small">Plan Genba</p>
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
                    <h6 class="title"><span id="detail_tipe_gemba">...</span></h6>
                    <div class="row align-items-center mb-3">
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-calendar-event h5 avatar avatar-40 bg-warning text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_plan_date">...</h6>
                                    <p class="text-secondary small">Plan Date</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-geo h5 avatar avatar-40 bg-danger text-white rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0" id="detail_location">...</h6>
                                    <p class="text-secondary small">Location</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6 class="title">Detail Evaluation <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                    <div class="row">
                        <input type="hidden" id="id_gemba" name="id_gemba">
                        <div class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-people"></i></span>
                                    <div class="form-floating">
                                        <input type="number" id="peserta" name="peserta" class="form-control border-start-0" placeholder="Tgl Plan" onkeypress="return hanyaAngka(event)">
                                        <label>Jumlah Peserta <i class="text-danger">*</i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journal-text"></i></span>
                                    <div class="form-floating">
                                        <textarea name="evaluasi" id="evaluasi" cols="30" rows="10" class="form-control border-start-0" placeholder="Evaluasi"></textarea>
                                        <label>Evaluation <i class="text-danger">*</i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-check-square"></i></span>
                                    <div class="form-floating">
                                        <select name="status_akhir" id="status_akhir" class="form-control">
                                            <option value="#" selected disabled>-- Choose Status --</option>
                                            <?php foreach ($status_strategy as $key) : ?>
                                                <option value="<?= $key->id; ?>"><?= $key->status; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label>Status <i class="text-danger">*</i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-md btn-outline-theme mb-3" onclick="save_proses_evaluasi()" id="btn_save_proses_evaluasi">Save</button>
                    <h6 class="title">List Checklist <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                </div>
                <div id="list_detail_gemba" class="row"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Proses Gemba -->

<!-- Modal Result Gemba -->
<div class="modal fade" id="modal_result_gemba" tabindex="-1" aria-labelledby="modalResultGembaLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-list h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalResultGembaLabel">List Result</h6>
                    <p class="text-secondary small">Plan Genba</p>
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
                <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="" style="padding: 10px;">
                                <table id="dt_result_gemba" class="table table-striped dt-responsive" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Concern</th>
                                            <th>Monitoring</th>
                                            <th>Status</th>
                                            <th>File</th>
                                            <th>Link</th>
                                            <th>Progres</th>
                                            <th>Updated At</th>
                                            <th>Updated By</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Result Gemba -->