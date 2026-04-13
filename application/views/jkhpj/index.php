<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-8 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Deskripsi Page</p>
            </div>
            <div class="col col-sm-auto">
                <div class="input-group input-group-md reportrange">
                    <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                    <input type="hidden" name="start" value="" id="start" />
                    <input type="hidden" name="end" value="" id="end" />
                    <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
                </div>
            </div>
            <div class="col-auto ps-0">

            </div>
        </div>
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle; ?></li>
                        </ol>
                    </div>

                </div>

            </nav>
        </div>
    </div>

    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto-right" align="right">
                            <?php //if($is_head || $is_manager) : ?>
                            <button type="button" class="btn btn-md btn-outline-info mb-2" onclick="list_feedback()"><i class="bi bi-chat-left-dots"></i> Feedback</button>
                            <?php //endif; ?>
                            <button type="button" class="btn btn-md btn-outline-theme mb-2" onclick="add_task()"><i class="bi bi-journal-plus"></i> Add Task</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_resume_tasklist" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID Task</th>
                                    <th>Created By</th>
                                    <th>Designation</th>
                                    <th>Tasklist (%)</th>
                                    <!-- <th>Avg Rating</th> -->
                                    <th>Created at</th>
                                    <th>Feedback</th>
                                    <th>File Feedback</th>
                                    <th>Link Feedback</th>
                                    <th>Status Feedback</th>
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

<!-- List Feedback JKHPJ -->
<div class="modal fade" id="modal_feedback_jkhpj" role="dialog">
    <div class="modal-dialog center" style="max-width: 90%;position:absolute;top:0;bottom:0;left:0;right:0;margin:auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Feedback</h4>
                <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
                <div class="table-responsive">
                    <table id="feedback_jkhpj" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID Task</th>
                                <th>Created By</th>
                                <th>Designation</th>
                                <th>Tasklist (%)</th>
                                <!-- <th>Avg Rating</th> -->
                                <th>Created at</th>
                                <th>Feedback</th>
                                    <th>File Feedback</th>
                                    <th>Link Feedback</th>
                                    <th>Status Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End List Feedback -->

<!-- Add Feedback -->
<div class="modal fade" id="modal_add_feedback" role="dialog">
    <div class="modal-dialog center" style="max-width: 90%;position:absolute;top: 60px;bottom:0;left:0;right:0;margin:auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Feedback</h4>
                <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
                <div class="row">
                    <div class="col-md-12">
                        <h5>Tasklist</h5><hr>
                            <table class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Tasklist</th>
                                        <th>Deskripsi</th>
                                        <th>Jadwal</th>
                                        <th>Status</th>
                                        <th>Link</th>
                                        <th>File</th>
                                        <th>Note</th>
                                    </tr>
                                </thead>
                                <tbody id="list_tasklist">

                                </tbody>
                            </table>
                            <br><br>
                    </div>
                    <div class="col-md-12">
                        <form id="form_feedback" enctype="multipart/form-data">
                            <input type="hidden" id="id_task_feedback" value="">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <label>Feedback <i class="text-danger">*</i></label>
                                        <div class="input-group">
                                            <textarea class="form-control input_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" name="feedback" id="feedback" rows="5" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="input-group input-group-lg">
                                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-folder"></i></span>
                                                    <div class="form-floating">
                                                        <input type="file" accept="application/pdf, .pdf, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, image/jpg, image/png, image/jpeg" id="file_feedback" class="form-control lampiran" name="file_feedback">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <label>Link </label>
                                        <div class="input-group">
                                            <input type="text" name="link_feedback" id="link_feedback" class="form-control" placeholder="https://example.com">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <label>Status<i class="text-danger">*</i></label>
                                        <div class="input-group">
                                            <select class="form-control" name="status_feedback" id="status_feedback" required>
                                                <option value="#" selected="" disabled="">-- Pilih Status --</option>
                                                <option>Jalan Berhasil</option>
                                                <option>Jalan Tidak Berhasil</option>
                                                <option>Tidak Berjalan</option>
                                                <option>Progress</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="button" class="btn btn-md btn-outline-theme" id="btn_save_feedback" onclick="simpan_feedback()">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Add Feedback MEMO -->