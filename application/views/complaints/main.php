<main class="main mainheight">

    <!-- Header -->
    <?php $this->load->view('complaints/_main_header'); ?>
    <!-- /Header -->

    <!-- Content -->
    <?php if ($this->uri->segment(4) != "") {
        $this->load->view('complaints/' . $this->uri->segment(4) . '/index');
    } ?>
    <!-- /Content -->

    <!-- Footer -->
    <?php $this->load->view('complaints/_main_footer'); ?>
    <!-- /Footer -->

</main>


<!-- Modal Add Task -->
<div class="modal fade" id="modal_add_task" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modal_add_task_label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-slack h5 avatar avatar-40 bg-light-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Form Complaints</h6>
                        <p class="small text-secondary">Input Complaints From Customer</p>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form id="form_complaint">
                    <div class="row mb-2">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="col-auto">
                                <div class="card border-0">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-12 col-md-6 col-lg-6 mb-2">
                                                <div class="ui mini form">
                                                    <div class="field">
                                                        <label class="required">Pilih Project</label>
                                                        <select name="id_project" id="id_project" class="ui search dropdown" onchange="select_project()">
                                                        </select>
                                                        <input type="hidden" name="project" id="project">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-6 mb-2">
                                                <div class="ui mini form">
                                                    <div class="field">
                                                        <label class="required">Pilih Blok</label>
                                                        <select name="blok" id="blok" class="ui disabled search dropdown">
                                                            <option value="Pilih Project Dahulu">Pilih Project Dahulu</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-12 mb-2">
                                                <div class="ui mini form">
                                                    <div class="field">
                                                        <label class="required">Nama Konsumen</label>
                                                        <div class="ui input icon">
                                                            <input type="hidden" name="id_konsumen" id="id_konsumen" class="form-control" readonly>
                                                            <input type="text" name="konsumen" id="konsumen" class="form-control">
                                                            <i class="icon"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-6 mb-2">
                                                <div class="ui mini form">
                                                    <div class="field">
                                                        <label class="required">Pilih Kategori Komplain ?</label>
                                                        <select name="id_category" id="id_category" class="ui search dropdown">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-6 mb-2">
                                                <div class="ui mini form">
                                                    <div class="field">
                                                        <label class="required d-none">Harus Verifikasi Komplain ke</label>
                                                        <input type="hidden" name="head_requester_id" id="head_requester_id" class="form-control bg-light-blue d-none" value="<?= $user->head_requester_id ?? 1; ?>" readonly>
                                                        <input type="text" name="head_requester_name" id="head_requester_name" class="form-control bg-light-blue d-none" value="<?= $user->head_requester_name ?? 'Super Administrator'; ?>" readonly>
                                                        <label class="required mt-2">Sebelum Komplain diteruskan ke</label>
                                                        <input type="hidden" name="escalation_by" id="escalation_by" class="form-control bg-light-blue" readonly>
                                                        <input type="text" name="escalation_name" id="escalation_name" class="form-control bg-light-blue" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-12 mb-2">
                                                <div class="ui mini form">
                                                    <div class="field">
                                                        <label class="required">Judul Keluhan/Komplain</label>
                                                        <input type="text" name="task" id="task" class="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-12 mb-2">
                                                <div class="ui mini form">
                                                    <div class="field">
                                                        <label class="required">Deskripsikan Keluhan/Komplain secara detail</label>
                                                        <textarea name="description" id="description" class="form-control" style="height: 100px;"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-12 mb-2">
                                                <div class="ui mini form">
                                                    <div class="field">
                                                        <label class="required">File Attachment</label>
                                                    </div>
                                                </div>
                                                <div class="ui file input mini form" id="input_foto">
                                                    <!-- <input type="file" id="file_complaints" style="cursor: pointer;"> -->
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-12 mb-2">
                                                <div class="ui mini form">
                                                    <div class="field">
                                                        <label class="">Link</label>
                                                        <input type="text" name="link" id="link" class="" placeholder="link video atau eviden">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="ui mini form">
                                                    <input type="checkbox" class="" name="" id="ceklis_pekerjaan" value="">
                                                    <label class="" for="ceklis_pekerjaan">Berhubungan dengan pekerjaan ?</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row row_pekerjaan" style="display: none;">
                                            <div class="col-4 col-md-4 col-lg-4 mb-2">
                                                <div class="ui mini form">
                                                    <div class="field">
                                                        <label class="required">Pekerjaan</label>
                                                        <select name="pekerjaan" id="pekerjaan" class="ui search dropdown">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 col-md-4 col-lg-4 mb-2">
                                                <div class="ui mini form">
                                                    <div class="field">
                                                        <label class="required">Sub Pekerjaan</label>
                                                        <select name="sub_pekerjaan" id="sub_pekerjaan" class="ui search dropdown">

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 col-md-4 col-lg-4 mb-2">
                                                <div class="ui mini form">
                                                    <div class="field">
                                                        <label class="required">Detail</label>
                                                        <select name="detail_pekerjaan[]" id="detail_pekerjaan" class="ui search dropdown" multiple>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="m-1 btn btn-link" data-bs-dismiss="modal">Close</button>
                <button type="button" class="m-1 btn btn-theme" onclick="save_task()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Type -->
<div class="modal fade" id="modal_add_type" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modal_add_type_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_add_type_label">Add Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col">
                    <label for="type_name">Type Name</label>
                    <input type="text" name="type_name" id="type_name" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link m-1" onclick="close_type()">Close</button>
                <button type="button" class="btn btn-link btn-monday m-1" onclick="save_type()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Category -->
<div class="modal fade" id="modal_add_category" tabindex="-1" aria-labelledby="modal_add_category_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_add_category_label">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col">
                    <label for="category_name">Category Name</label>
                    <input type="text" name="category_name" id="category_name" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link m-1" onclick="close_category()">Close</button>
                <button type="button" class="btn btn-link btn-monday m-1" onclick="save_category()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Object -->
<div class="modal fade" id="modal_add_object" tabindex="-1" aria-labelledby="modal_add_object_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_add_object_label">Add Object</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col">
                    <label for="object_name">Object Name</label>
                    <input type="text" name="object_name" id="object_name" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link m-1" onclick="close_object()">Close</button>
                <button type="button" class="btn btn-link btn-monday m-1" onclick="save_object()">Save</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Detail Task -->
<div class="modal fade" id="modal_detail_task" tabindex="-1" aria-labelledby="modal_detail_task_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_detail_task_label">Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Detail Start -->
                    <div class="col-12 col-md-12 col-lg-6 col-xxl-6">
                        <div class="card border-0 mb-4">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="comingsoonbi bi-calendar-event h5 avatar avatar-40 bg-light-green text-green text-green rounded "></i>
                                    </div>
                                    <div class="col">
                                        <h6 class="fw-medium mb-0" id="e_task_text">Ticket Title</h6>
                                        <p class="text-secondary small" id="e_category_second_title">Object</p>
                                    </div>
                                    <div class="col-auto" id="div_resend_notif">
                                        <a role="button" class="btn btn-link bg-light-green text-green" onclick="resend_notif()">
                                            Resend Notif <i class="bi bi-whatsapp h5 avatar avatar-30 bg-light-green text-green text-green rounded "></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6 text-start mb-3">
                                        <p class="text-secondary small mb-1">Requested By</p>
                                        <h6 id="e_requested_by_text" class="small" style="margin-bottom: 3px;">-</h6>
                                        <h6 id="e_requested_at_text" class="small">-</h6>
                                    </div>
                                    <div class="col-6 text-start mb-3">
                                        <p class="text-secondary small mb-1">Requested Divisi</p>
                                        <h6 class="small">
                                            <span style="margin-bottom: 3px;" class="badge bg-light-purple text-dark" id="e_requested_company_text">-</span>
                                            <span style="margin-bottom: 3px;" class="badge bg-light-yellow text-dark" id="e_requested_department_text">-</span>
                                            <span style="margin-bottom: 3px;" class="badge bg-light-red text-dark" id="e_requested_designation_text">-</span>
                                        </h6>
                                    </div>
                                    <div class="col-6 text-start mb-3">
                                        <p class="text-secondary small mb-1">Verified By</p>
                                        <h6 id="e_verified_by_text" class="small" style="margin-bottom: 3px;">-</h6>
                                        <h6 id="e_verified_at_text" class="small">-</h6>
                                    </div>
                                    <div class="col-6 text-start mb-3">
                                        <p class="text-secondary small mb-1">Escalation To</p>
                                        <h6 id="e_escalation_by_text" class="small" style="margin-bottom: 3px;">-</h6>
                                        <h6 id="e_escalation_at_text" class="small">-</h6>
                                    </div>
                                    <div class="col-6 col-md-3 mb-3">
                                        <p class="text-secondary small mb-1">Batas Akhir Pengerjaan</p>
                                        <h6 id="e_due_date_text" class="small">-</h6>
                                    </div>
                                    <div class="col-6 col-md-3 mb-3">
                                        <p class="text-secondary small mb-1">Mulai - Selesai</p>
                                        <h6 id="e_timeline_text" class="small"></h6>
                                    </div>
                                    <div class="col-6 col-md-3 mb-3">
                                        <p class="text-secondary small mb-1">Priority</p>
                                        <span id="e_priority_text" class="badge">-</span>
                                    </div>
                                    <div class="col-6 col-md-3 mb-3">
                                        <p class="text-secondary small mb-1">Level</p>
                                        <span id="e_level_text" class="badge"></span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <p class="text-secondary small mb-1">Status</p>
                                        <span id="e_status_text" class="badge"></span>
                                        <div id="div_e_progress_text" class="mt-2">
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <p class="text-secondary small mb-1">Pic</p>
                                        <h6 id="e_pic_text" class="small">-</h6>
                                    </div>
                                    <div class="col-6 mb-1 text-start">
                                        <p class="text-secondary small mb-1">Project : <br>
                                            <span class="small" id="e_project_text">-</span>
                                        </p>
                                    </div>
                                    <div class="col-6 mb-1 text-start">
                                        <p class="text-secondary small mb-1">Tgl Serah Terima Kunci : <br>
                                            <span class="small" id="e_tgl_kunci_text">-</span>
                                        </p>
                                    </div>
                                    <div class="col-6 mb-1 text-start">
                                        <p class="text-secondary small mb-1">Blok : <br>
                                            <span class="small" id="e_blok_text">-</span>
                                        </p>
                                    </div>
                                    <div class="col-6 mb-1 text-start">
                                        <p class="text-secondary small mb-1">Tgl KWH Listrik : <br>
                                            <span class="small" id="e_tgl_kwh_text">-</span>
                                        </p>
                                    </div>
                                    <div class="col-6 mb-1">
                                        <p class="text-secondary small mb-1">Category Complaints : <br>
                                            <span class="small" id="e_category_text">-</span>
                                        </p>
                                    </div>
                                    <div class="col-6 mb-1 text-start">
                                        <p class="text-secondary small mb-1">Tgl QC : <br>
                                            <span class="small" id="e_tgl_selesai_qc_text">-</span>
                                        </p>
                                    </div>
                                    <div class="col-6 mb-1 text-start">
                                        <p class="text-secondary small mb-1">Tanggal After Sales : <br>
                                            <span class="small" id="e_tgl_aftersales">-</span>
                                        </p>
                                    </div>
                                    <div class="col-6 mb-1 text-start">
                                        <p class="text-secondary small mb-1">Umur Bangunan : <br>
                                            <span class="small" id="e_umur_bangunan_text">-</span>
                                        </p>
                                    </div>
                                    <div class="col-12 mb-1 text-start">
                                        <p class="text-secondary small mb-1">Vendor : <br>
                                            <span class="small" id="e_nama_vendor_text">-</span>
                                        </p>
                                    </div>
                                    <div class="col-12 mb-1">
                                        <p class="text-secondary small mb-1">Description</p>
                                        <h6 id="e_description_text" class="small">-</h6>
                                    </div>
                                    <div class="row mt-4" id="body_files_page_detail">

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer" id="footer-update">
                                <input type="hidden" name="e_id_task" id="e_id_task" readonly>
                                <div id="div_footer">
                                    <p id="title_update" class="title"></p>
                                    <div class="row g-3 mb-3 align-items-center" id="div_e_id_status">
                                        <div class="col-12 col-md-3">
                                            <label class="form-label-custom small required" for="e_id_status"><i class="spinner icon"></i> Status</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <div class="ui mini form">
                                                <div class="field">
                                                    <select name="e_id_status" id="e_id_status" class="ui search dropdown">
                                                    </select>
                                                    <input type="hidden" name="e_id_status_old" id="e_id_status_old">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3 align-items-center" id="div_e_id_priority">
                                        <div class="col-12 col-md-3">
                                            <label class="form-label-custom small required" for="e_id_priority"><i class="balance scale priority icon"></i> Priority</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <div class="ui mini form">
                                                <div class="field">
                                                    <select name="e_id_priority" id="e_id_priority" class="ui search dropdown">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3 align-items-center" id="div_e_level">
                                        <div class="col-12 col-md-3">
                                            <label class="form-label-custom small required" for="e_id_level"><i class="sort amount up icon"></i> Level</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <div class="ui form">
                                                <div class="field">
                                                    <select name="e_id_level" id="e_id_level" class="ui search dropdown">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3 align-items-center" id="div_e_id_pic">
                                        <div class="col-12 col-md-3">
                                            <label class="form-label-custom small required" for="e_id_pic"><i class="user md icon"></i> PIC</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <div class="ui form">
                                                <div class="field">
                                                    <select name="e_id_pic" id="e_id_pic" class="ui search dropdown" multiple>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="div_e_timeline">
                                        <p class="title">Timeline Pengerjaan</p>
                                        <div class="row g-3 mb-3 align-items-center">
                                            <div class="col-12 col-md-3">
                                                <label class="form-label-custom small required" for="e_due_date"><i class="clock outline icon"></i> Due Date</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <div class="row">
                                                    <div class="col">
                                                        <input type="text" name="e_due_date" id="e_due_date" class="tanggal form-control" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-3 mb-3 align-items-center">
                                            <div class="col-12 col-md-3">
                                                <label class="form-label-custom required small" for="start_timeline"><i class="calendar alternate outline icon"></i> Start</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <input type="text" name="start_timeline" class="form-control border tanggal-menit" placeholder="Start Timeline" id="e_start_timeline" autocomplete="off" />
                                            </div>
                                        </div>
                                        <div class="row g-3 mb-3 align-items-center">
                                            <div class="col-12 col-md-3">
                                                <label class="form-label-custom required small" for="end_timeline"><i class="calendar alternate outline icon"></i> End</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <input type="text" name="end_timeline" class="form-control border tanggal-menit" placeholder="End Timeline" id="e_end_timeline" autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3 align-items-center" id="div_e_progress">
                                        <div class="col-12 col-md-3">
                                            <label class="form-label-custom required small" for="e_progress"><i class="chart bar outline icon"></i> Progress</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="number" name="progress" id="e_progress" class="form-control mt-2" autocomplete="off" min="0" max="100">
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3 align-items-center" id="div_e_verified_note">
                                        <div class="col-12 col-md-3">
                                            <label class="form-label-custom small required" for="e_verified_note"><i class="sticky note outline icon"></i> Note Verifikasi</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <textarea name="e_verified_note" id="e_verified_note" class="form-control" style="height: 100px;"></textarea>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3 align-items-center" id="div_e_escalation_note">
                                        <div class="col-12 col-md-3">
                                            <label class="form-label-custom small required" for="e_escalation_note"><i class="sticky note outline icon"></i> Note Eskalasi</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <textarea name="e_escalation_note" id="e_escalation_note" class="form-control" style="height: 100px;"></textarea>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3 align-items-center" id="div_e_pic_note">
                                        <div class="col-12 col-md-3">
                                            <label class="form-label-custom small required" for="e_pic_note"><i class="sticky note outline icon"></i> Note Update</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <textarea name="e_pic_note" id="e_pic_note" class="form-control" style="height: 100px;"></textarea>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3" id="div_e_evidence">
                                        <div class="col-12 col-md-3">
                                            <label class="form-label-custom small required" for="evidence"><i class="sticky file outline icon"></i> Evidence</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <!-- <input type="file" name="value_evidence" id="value_evidence" class="form-control"> -->
                                            <input type="file" name="evidence" id="evidence" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3 d-none" id="div_e_id_project_detail">
                                        <div class="col-12 col-md-3">
                                            <label class="form-label-custom small required" for="id_project_detail"><i class="bi bi-house"></i> Pilih Project</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <select name="id_project" id="id_project_detail" class="ui search dropdown" onchange="select_project_detail()">
                                            </select>
                                            <input type="hidden" name="project" id="project_detail">
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3 d-none" id="div_e_blok_detail">
                                        <div class="col-12 col-md-3">
                                            <label class="form-label-custom small required" for="blok_detail"><i class="bi bi-house"></i> Pilih Blok</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <select name="blok" id="blok_detail" class="ui search dropdown">
                                                    <option value="Pilih Project Dahulu">Pilih Project Dahulu</option>
                                                </select>
                                        </div>
                                    </div>
                                    <!-- <input type="hidden" name="id_category" id="id_category_detail"> -->
                                    <div class="row g-3 mb-3 d-none" id="div_e_id_category_detail">
                                        <div class="ui mini form">
                                            <div class="col-12 col-md-9">
                                                <label class="required">Pilih Kategori Komplain ?</label>
                                                <select name="id_category" id="id_category_detail" class="ui search dropdown">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="escalation_by" id="escalation_by_detail">
                                    <input type="hidden" name="escalation_name" id="escalation_name_detail">
                                    <div class="row gx-2">
                                        <div class="col text-end">
                                            <a class="btn btn-theme btn-md" role="button" id="btn_update_task" onclick="">-</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Detail End -->
                    <!-- Log Start -->
                    <div class="col-12 col-md-12 col-lg-6">
                        <div class="row">
                            <div class="col">
                                <ul class="nav detail_tabs nav-WinDOORS">
                                    <li class="nav-item">
                                        <a class="nav-link" href="javascript:void(0)" id="nav_comment" onclick="activateTab('comment')">
                                            Comment
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="javascript:void(0)" id="nav_activity" onclick="activateTab('activity')">
                                            Activity Log
                                        </a>
                                    </li>
                                    <li class=" nav-item">
                                        <a class="nav-link" href="javascript:void(0)" id="nav_files" onclick="activateTab('files')">
                                            Files
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <hr>

                        <input type="hidden" id="detail_id_task">
                        <input type="hidden" id="detail_status_before">
                        <input type="hidden" id="detail_status_after">

                        <div class="row" style="display:none" id="spinner_loading">
                            <div class="col text-center center-spinner">
                                <div class="spinner-border text-primary mt-3" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>

                        <!-- ACTIVITY LOG PAGE -->
                        <div class="row detail_pages" id="activity_page">
                            <div class="col">
                                <div class="table-responsive" style="padding: 10px;">
                                    <table id="dt_log_history" class="table table-borderless table-striped footable" style="width:100%" data-filtering="false">
                                        <!-- <thead>
                                            <tr class="text-muted">
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead> -->
                                        <tbody id="body_log_history">

                                        </tbody>
                                    </table>
                                </div>
                                <div class="row align-items-center mx-0 detail_pages">
                                    <div class="col-6">
                                        <span class="hide-if-no-paging">
                                            Showing <span class="footablestot"></span> page
                                        </span>
                                    </div>
                                    <div class="col-6 footable-pagination"></div>
                                </div>
                            </div>
                        </div>
                        <!-- ACTIVITY LOG PAGE -->

                        <!-- COMMENT PAGE -->
                        <div class="row detail_pages" id="comment_page">
                            <div class="col-12">
                                <div class="card border-0 mb-2">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 mt-2">
                                                <textarea name="e_comment" id="e_comment" cols="30" rows="5"></textarea>
                                            </div>
                                            <div class="col text-end mt-2">
                                                <button class="btn btn-sm btn-theme" onclick="save_comment()"><i class="bi bi-send"></i> Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="body_get_comment" class="overflow-y-auto" style="max-height: 400px;">

                                </div>
                            </div>
                        </div>
                        <!-- COMMENT PAGE -->

                        <!-- FILES PAGE -->
                        <div class="row detail_pages" id="files_page" style="display:none">
                            <div class="row align-items-center mb-3">
                                <div class="col-auto">
                                    <i class="bi bi-file-earmark-richtext h5 avatar avatar-40 bg-light-green text-green rounded"></i>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0">Files</h6>
                                    <p class="small text-secondary">Recently</p>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-link text-secondary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Attach New File <i class="bi bi-plus"></i></button>
                                </div>
                            </div>
                            <div class="collapse" id="collapseExample">
                                <div class="row mb-3" style="margin-top: auto;">
                                    <div class="col">
                                        <form id="fileForm">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="input-group input-group-lg">
                                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                                    <div class="form-floating">
                                                        <input type="text" name="nama_file" id="nama_file" placeholder="File Name" value="" required="" class="form-control border-start-0" onchange="remove_invalid('nama_file')" oninput="remove_invalid('nama_file')">
                                                        <label>File Name</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="input-group input-group-lg">
                                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-upload"></i></span>
                                                    <div class="form-floating">
                                                        <input type="file" name="file" id="fileInput" hidden onchange="file_selected()">
                                                        <input type="text" id="file_string" placeholder="Click to select file" class="form-control border-start-0" onclick="addFileInput()" onchange="remove_invalid('file_string')" oninput="remove_invalid('file_string')">
                                                        <label>Click to select file</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 text-end">
                                                <button type="button" class="btn btn-theme" id="btn_save_upload" onclick="upload_file()">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="body_files_page">

                            </div>
                        </div>
                        <!-- FILES PAGE -->


                        <div class="position-fixed right-0 bottom-0 end-0 p-3" style="z-index: 99999999">
                            <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header">
                                    <i class="bi bi-check-circle-fill text-success" id="upload_check" style="display:none"></i>
                                    <div class="spinner-border spinner_upload text-success" id="spinner_upload" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    &nbsp;
                                    <strong class="me-auto" id="uploaded_status">Uploaded 1 file</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close" onclick="hide_upload_toast()"></button>
                                </div>
                                <div class="toast-body">
                                    <div class="row">
                                        <div class="col-auto" id="col_preview">
                                            <img class="coverimg" id="uploaded_preview" src="" alt="" width="70">
                                        </div>
                                        <div class="col ps-0">
                                            <h6 class="fw-medium mb-0" id="uploaded_name"></h6>
                                            <p class="text-secondary small" id="uploaded_date"></p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <div class="progress h-5 mb-1 bg-light-green">
                                            <div id="myProgressBar" class="progress-bar bg-green" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Log End -->

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link m-1" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_confirm_resend_notif" tabindex="-1" aria-labelledby="modal_confirm_resend_notif" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_confirm_resend_notif">Resend Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure to resend notification?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary ms-3" id="btn_resend_notif">Resend</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Change Category -->
<div class="modal fade" id="modal_change_category" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modal_change_category_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_change_category_label">Change Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_change_category">
                    <input type="hidden" name="id_task" id="id_task_category">
                    <div class="row g-3 mb-3 align-items-center">
                        <div class="col">
                            <label for="type_name">Category</label>
                            <select name="id_category" id="category_change" class="form-select">
                                <option value="" selected="" disabled>Select Category</option>
                                <option value="10">Aftersales</option>
                                <option value="5">Artesis</option>
                                <option value="13">Buspro (Berkas)</option>
                                <option value="12">Estate</option>
                                <option value="11">Finance</option>
                                <option value="4">Infrastruktur</option>
                                <option value="1">Kunci Rumah</option>
                                <option value="8">KWH Listrik</option>
                                <option value="14">Legal (Perizinan/Sertifikat)</option>
                                <option value="6">PDAM</option>
                                <option value="2">Plester</option>
                                <option value="3">Progres Bangunan</option>
                                <option value="15">Sales/Mkt (Area Cirebon)</option>
                                <option value="16">Sales/Mkt (Area Diluar Cirebon, Indramayu, Bekasi ,Kendal)</option>
                                <option value="17">Sales/Mkt (Area Indramayu, Bekasi, Kendal)</option>
                                <option value="7">Sanyo</option>
                                <option value="18">Sosmed</option>
                                <option value="9">Tiang listrik</option>
                            </select>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link m-1" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-link btn-monday m-1" onclick="save_change_category()">Save</button>
            </div>
        </div>
    </div>
</div>