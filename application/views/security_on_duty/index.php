<body>

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

    <!-- Add Adhi -->
    <div class="row m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-start">
                                <div class="row">
                                    <div class="col-auto">
                                        <i class="bi bi-shield h5 avatar avatar-40 bg-light-theme rounded"></i>
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <h6 class="fw-medium mb-0">Resume Tasklist</h6>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-3 float-lg-end">
                                <a href="<?= site_url('security_on_duty/add_task') ?>" class="btn btn-primary mt-2"
                                    style="width: 100%;">
                                    <i class="bi bi-plus"></i> Add Task
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row" style="margin-leftx: 10px;">
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3">
                            <form method="POST" id="form_filter">
                                <div class="input-group input-group-md reportrange">
                                    <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;"
                                        id="titlecalendar">
                                    <input type="hidden" name="start" value="" id="start" readonly />
                                    <input type="hidden" name="end" value="" id="end" readonly />
                                    <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i
                                            class="bi bi-calendar-event"></i></span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_resume_tasklist" class="table table-md table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width:7%">ID Task</th>
                                    <th>Project</th>
                                    <th>Shift</th>
                                    <th>Tasklist (%)</th>
                                    <th>Avg Rating</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>



            </div>
        </div>





        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-start">
                                <div class="row">
                                    <div class="col-auto">
                                        <i class="bi bi-list h5 avatar avatar-40 bg-light-theme rounded"></i>
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <h6 class="fw-medium mb-0">List Detail Tasklist</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_list_detail_task" class="table table-sm table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width:7%">ID Task</th>
                                    <th style="width:10%">Project</th>
                                    <th>Shift</th>
                                    <th style="width:25%">Tasklist</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Actual</th>
                                    <th>Status</th>
                                    <th>Photo</th>
                                    <th>Note</th>
                                    <th style="width:10%">Created At</th>
                                    <th>Created By</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- <div class="modal fade" id="modalDetailTask" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Detail Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered" id="tableDetailTask">
                    <thead>
                        <tr>
                            <th>Tasklist</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Actual</th>
                            <th>Status</th>
                            <th>Photo</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

        </div>
    </div>
</div> -->

<div class="modal fade" id="modalDetailTask" tabindex="-1" aria-labelledby="modalDetailTaskLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">


<!-- <div class="modal fade" id="modalDetailTask" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> -->
                <h5 class="modal-title" id="modalDetailLabel">Detail Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" id="tableDetailTask">
                    <thead>
                        <tr>
                            <th>Tasklist</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Actual</th>
                            <th>Status</th>
                            <th>Photo</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-detail-top"
     id="modal_detail_taskk"
     tabindex="-1"
     aria-labelledby="modalDetailTaskkLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <form id="form_detail_task">
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-person-workspace h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                        <h6 class="fw-medium mb-0" id="modalDetailTaskkLabel">
                            Detail Task Security
                        </h6>
                    </div>

                    <!-- ✅ CLOSE BUTTON BENAR -->
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>

                <div class="modal-body" style="background-color:#f6fafd;">

                    <input type="hidden" id="id_task_item" name="id_task_item">
                    <input type="hidden" id="id_task" name="id_task">

                    <div class="row mb-3">

                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom small">
                                <strong>Jadwal</strong>
                            </label>
                            <div class="input-group border-custom">
                                <span id="det_time_start"></span>
                                &nbsp;–&nbsp;
                                <span id="det_time_end"></span>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom small">
                                <strong>Tasklist</strong>
                            </label>
                            <div class="input-group border-custom">
                                <span id="det_tasklist"></span>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom small">
                                <strong>Status</strong>
                            </label>
                            <div class="input-group border-custom">
                                <select name="status" id="status" class="form-control">
                                    <option value="" disabled>- Pilih Status -</option>
                                    <option value="0">Belum</option>
                                    <option value="1">Sudah</option>
                                </select>
                            </div>
                            <input type="hidden" id="old_photo">
                        </div>

                        <div class="col-md-6 mb-3 div-photo d-none">
                            <label class="form-label-custom small">
                                <strong>Foto</strong>
                            </label>
                            <br>
                            <img id="preview_photo" class="mb-2" width="300" alt="foto_sc">
                            <input type="hidden" id="is_photo">
                            <input type="file" name="photo" id="photo" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label-custom small">
                                <strong>Note</strong>
                            </label>
                            <textarea name="note"
                                      id="note"
                                      class="form-control"
                                      rows="4"
                                      required></textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="button"
                            class="btn btn-primary"
                            id="btn_update_task_item"
                            onclick="update_task_item()">
                        Update
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


</main>

</body>