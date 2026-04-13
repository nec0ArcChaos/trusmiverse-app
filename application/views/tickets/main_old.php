<main class="main mainheight">

    <!-- Header -->
    <?php $this->load->view('tickets/_main_header'); ?>
    <!-- /Header -->

    <!-- Content -->
    <?php if ($this->uri->segment(4) != "") {
        $this->load->view('tickets/' . $this->uri->segment(4) . '/index');
    } ?>
    <!-- /Content -->

    <!-- Footer -->
    <?php $this->load->view('tickets/_main_footer'); ?>
    <!-- /Footer -->

</main>


<!-- Modal Add Task -->
<div class="modal fade" id="modal_add_task" tabindex="-1" aria-labelledby="modal_add_task_label" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal-list-waiting-resignationLabel">Add Form</h6>
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
                <div class="row mb-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="ui form">
                            <div class="field">
                                <label class="required">Type</label>
                                <select name="id_type" id="id_type" class="ui search dropdown">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="ui form">
                            <div class="field">
                                <label class="required">Category</label>
                                <select name="id_category" id="id_category" class="ui search dropdown">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2 mb-2 d-none" id="alert-div">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <div class="row">
                                <div class="col">
                                    <p style="text-align: justify;"><strong>Info!</strong></p>
                                    <p style="text-align: justify;">Khusus Pengajuan <b>Ticket terkait Development</b> saat ini ditutup karena sudah melewati batas akhir pengajuan development (tgl 6) akan dibuka kembali di awal bulan selanjutnya.</p>
                                    <br>
                                    <p style="text-align: justify;">Untuk pengajuan <b>Ticket Lainnya</b> masih dapat dilakukan.</p>
                                    <br>
                                    <p style="text-align: justify;">Kami berusaha menyelesaikan proyek-proyek yang ada dengan sebaik mungkin. <br>
                                        Terima kasih atas pengertian dan kesabaran Anda. Kami akan memberitahukan segera ketika pengajuan development dibuka kembali.
                                    </p>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="ui form">
                            <div class="field">
                                <label class="required">Object</label>
                                <select name="id_object" id="id_object" class="ui search dropdown">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="ui form">
                            <div class="field">
                                <label class="required">Priority</label>
                                <select name="id_priority" id="id_priority" class="ui search dropdown">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12 mb-2">
                        <div class="ui form">
                            <div class="field">
                                <label class="required">PIC</label>
                                <select name="id_pic" id="id_pic" class="ui search dropdown" multiple="">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-2 col-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="div_id_requester" class="mb-2">
                                    <div class="ui form">
                                        <div class="field">
                                            <label class="required">Reporter</label>
                                            <select name="id_requester" id="id_requester" class="ui search dropdown">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <label class="form-label-custom required small" for="task">Title</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bi bi-file-earmark-font" style="background-color: #F5F5F5;border: 1px solid #ddd;"></span>
                                    <input type="text" class="form-control" name="task" id="task" placeholder="Title" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                </div>
                                <!-- <label class="form-label-custom required small" for="location">Location</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bi bi-geo-alt" style="background-color: #F5F5F5;border: 1px solid #ddd;"></span>
                                    <input type="text" class="form-control" name="location" id="location" placeholder="*Contoh : JMP1, JMP2, TGS" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                </div> -->
                                <label class="form-label-custom required small" for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" style="height: 100px;"></textarea>
                                <label class="form-label-custom small mt-2" for="file_ticket">File Attachment</label>
                                <input type="file" name="file_ticket" id="file_ticket" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
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
                                        <p class="text-secondary small" id="e_object_text">Object</p>
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
                                    <div class="col-6 col-md-3 mb-3">
                                        <p class="text-secondary small mb-1">Due Date</p>
                                        <h6 id="e_due_date_text" class="small">-</h6>
                                    </div>
                                    <div class="col-6 col-md-3 mb-3">
                                        <p class="text-secondary small mb-1">Timeline</p>
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
                                    <div class="col-6 text-start mb-3">
                                        <p class="text-secondary small mb-1">Requested By</p>
                                        <h6 id="e_requested_by_text" class="small">-</h6>
                                        <h6 id="e_requested_at_text" class="small">-</h6>
                                        <h6 id="e_requested_location_text" class="small">-</h6>
                                    </div>
                                    <div class="col-6 text-start mb-3">
                                        <p class="text-secondary small mb-1">Requested Divisi</p>
                                        <span class="badge bg-light-purple text-dark" id="e_requested_company_text" class="small">-</span>
                                        <span class="badge bg-light-yellow text-dark" id="e_requested_department_text" class="small">-</span>
                                        <span class="badge bg-light-red text-dark" id="e_requested_designation_text" class="small">-</span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <p class="text-secondary small mb-1">Status</p>
                                        <span id="e_status_text" class="badge"></span>
                                        <div id="div_e_progress" class="mt-2">
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <p class="text-secondary small mb-1">Pic</p>
                                        <h6 id="e_pic_text" class="small">-</h6>
                                    </div>
                                    <div class="col-12 mb-1">
                                        <p class="text-secondary small mb-1">Description</p>
                                        <h6 id="e_description_text" class="small">-</h6>
                                    </div>
                                </div>
                                <p>
                                    <span class="small" id="e_type_text">-</span>
                                    <span class="small" id="e_category_text">-</span>
                                </p>
                            </div>
                            <div class="card-footer" id="footer-update">
                                <input type="hidden" name="e_id_task" id="e_id_task" readonly>
                                <div id="div_not_started">
                                    <p class="title">Kategori Ticket</p>
                                    <div class="row g-3 mb-3 align-items-center">
                                        <div class="col-12 col-md-3">
                                            <label class="form-label-custom small" for="e_id_type"><i class="bullhorn icon"></i> Type</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <div class="ui form">
                                                <div class="field">
                                                    <select name="e_id_type" id="e_id_type" class="ui search dropdown">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3 align-items-center">
                                        <div class="col-12 col-md-3">
                                            <label class="form-label-custom small" for="e_id_category"><i class="tags icon"></i> Category</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <div class="ui form">
                                                <div class="field">
                                                    <select name="e_id_category" id="e_id_category" class="ui search dropdown">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3 align-items-center">
                                        <div class="col-12 col-md-3">
                                            <label class="form-label-custom small" for="e_id_object"><i class="crosshairs icon"></i> Object</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <div class="ui form">
                                                <div class="field">
                                                    <select name="e_id_object" id="e_id_object" class="ui search dropdown">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3 align-items-center">
                                        <div class="col-12 col-md-3">
                                            <label class="form-label-custom small" for="e_id_priority"><i class="balance scale priority icon"></i> Priority</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <div class="ui form">
                                                <div class="field">
                                                    <select name="e_id_priority" id="e_id_priority" class="ui search dropdown">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3 align-items-center">
                                        <div class="col-12 col-md-3">
                                            <label class="form-label-custom small" for="e_id_level"><i class="sort amount up icon"></i> Level</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <div class="ui form">
                                                <div class="field">
                                                    <select name="e_id_level" id="e_id_level" class="ui search dropdown" onchange="hitung_lsa()">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3 align-items-center">
                                        <div class="col-12 col-md-3">
                                            <label class="form-label-custom small" for="e_id_pic"><i class="user md icon"></i> PIC</label>
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
                                    <p class="title">Timeline Pengerjaan</p>
                                    <div id="div_lsa"></div>
                                    <div class="row g-3 mb-3 align-items-center">
                                        <div class="col-12 col-md-3">
                                            <label class="form-label-custom small" for="e_due_date"><i class="clock outline icon"></i> Due Date</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <div class="row">
                                                <div class="col">
                                                    <input type="text" name="e_due_date" id="e_due_date" class="tanggal form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3 align-items-center">
                                        <div class="col-12 col-md-3">
                                            <label class="form-label-custom required small" for="e_start"><i class="calendar alternate outline icon"></i> Start</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="text" name="start_timeline" class="form-control border tanggal-menit" placeholder="Start Timeline" id="e_start_timeline" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3 align-items-center">
                                        <div class="col-12 col-md-3">
                                            <label class="form-label-custom required small" for="e_start"><i class="calendar alternate outline icon"></i> End</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="text" name="end_timeline" class="form-control border tanggal-menit" placeholder="End Timeline" id="e_end_timeline" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <p class="title">Status Progress</p>
                                <div class="row g-3 mb-3 align-items-center">
                                    <div class="col-12 col-md-3">
                                        <label class="form-label-custom small required" for="e_id_status"><i class="spinner icon"></i> Status</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <div class="ui form">
                                            <div class="field">
                                                <select name="e_id_status" id="e_id_status" class="ui search dropdown">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3 align-items-center">
                                    <div class="col-12 col-md-3">
                                        <label class="form-label-custom required small" for="e_progress"><i class="chart bar outline icon"></i> Progress</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="number" name="progress" id="e_progress" class="form-control mt-2" autocomplete="off" min="0" max="100">
                                    </div>
                                </div>
                                <div class="row g-3 mb-3 align-items-center">
                                    <div class="col-12 col-md-3">
                                        <label class="form-label-custom required small" for="e_note"><i class="sticky note outline icon"></i> Note Update</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <textarea name="e_note" id="e_note" class="form-control" style="height: 100px;"></textarea>
                                    </div>
                                </div>
                                <div class="row gx-2">
                                    <div class="col text-end">
                                        <?php if ($this->session->userdata('user_id') == '2063') { ?>
                                            <a class="btn btn-theme btn-md" role="button" onclick="hitung_lsa()">test</a>
                                        <?php } ?>
                                        <a class="btn btn-theme btn-md" role="button" onclick="update_task()">Update</a>
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