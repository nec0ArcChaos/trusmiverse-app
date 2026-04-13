
<div class="row mt-3">
    <div class="col-12">
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-3">
                <h5 class="mb-0 fw-bold">
                    OKR Operasional
                </h5>
            </div>

            <div class="col-9 text-end">
                <div class="row">
                    <div class="col-5">
                        <div class="progress" style="height: 100%; width: 100%; display: none;">
                            <!-- List Tab -->
                            <div class="progress-bar progress-tab selected" id="progress_list" style="width:33%; background-color: #081226; cursor: pointer;" role="progressbar" data-target="#section_list">
                                <span style="font-size: 12px; font-weight: bold;" class="progress-text"><i class="bi bi-list"></i> List</span>
                            </div>
                            <!-- Kanban Tab -->
                            <div class="progress-bar progress-tab" id="progress_kanban" style="width:33%; background-color: #ffffff; cursor: pointer;" role="progressbar" data-target="#section_kanban">
                                <span style="font-size: 12px; font-weight: bold;" class="progress-text"><i class="bi bi-kanban"></i> Kanban</span>
                            </div>
                            <!-- Calendar Tab -->
                            <div class="progress-bar progress-tab" id="progress_calendar" style="width:34%; background-color: #ffffff; cursor: pointer;" role="progressbar" data-target="#section_calendar">
                                <span style="font-size: 12px; font-weight: bold;" class="progress-text"><i class="bi bi-calendar-date"></i> Calendar</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <select class="form-control form-control-md border-custom" id="select_divisi">
                            <option value="" disabled>-- Pilih Divisi --</option>
                            <option value="Operasional" selected>Operasional</option>
                        </select>
                    </div>
                    <!-- <div class="col-3">
                        <div class="input-group input-group-sm border-custom">
                            <input type="text" class="form-control form-control-md monthpicker px-2 border-custom" style="cursor: pointer;" id="select_month" placeholder="<?= date('m-Y') ?>" value="<?= date('m-Y') ?>">
                            <span class="input-group-text bg-transparent border-0">
                                <i class="bi bi-calendar-event"></i>
                            </span>
                        </div>
                    </div> -->                    
                    <div class="col-4">
                        <div class="input-group input-group-md reportrange border-custom">
                            <input type="text" class="form-control text-center range px-0" style="cursor: pointer;" id="rangeCalendar">
                            <input type="hidden" name="start" value="" id="startCalendar" />
                            <input type="hidden" name="end" value="" id="endCalendar" />
                            <span class="input-group-text text-secondary" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3 px-2">
            <div class="col">

                <div id="progressBarContainer">
                    <div class="progress" style="height: 35px; width: 100%;">
                        <?php
                        $index = 1;
                        ?>
                        <?php foreach ($goals as $goal): ?>
                            <div class="progress-bar bg-blue_<?= $index ?>" style="width:<?= $goal->done_prs ?>%;" role="progressbar">
                                <span style="font-size: 12px; font-weight: bold;" class="text-white"><?= $goal->nama_goal ?> (<?= $goal->done_prs ?>%)</span>
                            </div>
                            <?php $index++; ?>
                        <?php endforeach; ?>

                        <?php
                        $not_started_prs = array_sum(array_column($goals, 'not_started_prs')); // Calculate remaining %
                        if ($not_started_prs > 0):
                        ?>
                            <div class="progress-bar" style="width:<?= $not_started_prs ?>%; background-color: #D4D4D8;" role="progressbar">
                                <span style="font-size: 12px; font-weight: bold;" class="text-grey">Not Started (<?= $not_started_prs ?>%)</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

        <!-- Tab Content -->
        <div class="tab-content">
            <div class="custom-pane active" id="section_list">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12 col-xxl-12 mb-3">
                        <div id="list_grd"></div>
                    </div>
                </div>
            </div>
            <?php include 'kanban_section.php'; ?>
            <div class="custom-pane" id="section_calendar">
                <p>Calendar View Content Goes Here</p>
            </div>
        </div>



    </div>
</div>


<!-- MODAL DETAIL TASKLIST -->
<div class="modal fade" id="modal_detail_tasklist" tabindex="-1" aria-labelledby="modal_detail_tasklist_label" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-light-blue">
                <div class="col-auto">
                    <i class="bi bi-newspaper h5 avatar avatar-40 bg-light text-purple rounded"></i>
                </div>
                <div class="col">
                    <h5 class="fw-bold mb-0" id="t_nama_goal">Nama Coorporate</h5>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-lg-8 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="comingsoonbi bi bi-list-task h5 avatar avatar-40 bg-light-green text-green text-green rounded "></i>
                                    </div>
                                    <div class="col-sm-6 col-6 col-lg-6">
                                        <h6 class="fw-medium mb-0" id="t_so">Project</h6>
                                        <p class="text-secondary small" id="t_si">Objective</p>
                                    </div>

                                    <div class="col-sm-6 col-lg-4 col-12 text-end">
                                        <p class="text-secondary small mb-1">Status</p>
                                        <span class="badge bg-success fs-6" id="t_status">Done</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-12 mb-2">
                                        <p class="title"><i class="bi bi-quote"></i> Detail Key Result
                                            <!-- <i class="bi bi-pencil" onclick="edit_tasklist()" style="cursor:pointer;"></i> -->
                                            <i class="bi bi-pencil" id="edit_icon" style="cursor:pointer;"></i>
                                        </p>
                                        <p id="t_detail"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <p class="text-secondary small mb-1">Divisi</p>
                                        <h6 class="small" id="t_divisi">Operasional</h6>
                                    </div>
                                    <div class="col mb-2">
                                        <p class="text-secondary small mb-1">Company</p>
                                        <span class="badge bg-light-blue text-dark" id="t_company">


                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3 col-md-3 mb-2">
                                        <p class="text-secondary small mb-1">PIC</p>
                                        <h6 class="small" id="t_pic"></h6>
                                    </div>

                                    <div class="col-3 col-md-4 mb-2">
                                        <p class="text-secondary small mb-1">Deadline </p>
                                        <h6 class="small d-inline" id="t_start"></h6><i class="bi bi-arrow-right-short"></i>
                                        <h6 class="small d-inline" id="t_deadline"></h6>
                                    </div>
                                    <div class="col-3 col-md-3 mb-2">
                                        <p class="text-secondary small mb-1">Output</p>
                                        <h6 class="small" id="t_output"></h6>
                                    </div>
                                    <div class="col-3 col-md-2 mb-2">
                                        <p class="text-secondary small mb-1">Target</p>
                                        <h6 class="small" id="t_target"></h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 col-sm-12">
                        <div class="row mb-2">
                            <div class="col-12">
                                <ul class="nav detail_tabs nav-WinDOORS">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="javascript:void(0)" id="nav_update" onclick="activateTab('update')">
                                            Update Progres
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="javascript:void(0)" id="nav_activity" onclick="activateTab('activity')">
                                            History
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="javascript:void(0)" id="nav_files" onclick="activateTab('files')">
                                            Files
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content">
                            <!-- Tab Content for Update Progres -->
                            <div class="tab-pane fade show active" id="tab_update">
                                <form id="form_update" enctype="multipart/form-data" class="mt-2">
                                    <input type="hidden" name="id_tasklist" id="id_tasklist">
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label class="form-label-custom required small">Status</label>
                                            <div class="input-group border-custom">
                                                <span class="input-group-text"><i class="bi bi-alexa"></i></span>
                                                <select name="status" id="status" class="form-control border-custom" required>
                                                    <?php foreach ($status as $item) : ?>
                                                        <option value="<?= $item->id ?>"><?= $item->nama ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <input type="hidden" name="status_before" id="status_before">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label-custom small">Actual</label>
                                            <div class="input-group border-custom">
                                                <span class="input-group-text"><i class="bi bi-hourglass-split"></i></span>
                                                <input type="number" name="actual" id="actual" class="form-control border-custom" max="100" min="0" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">

                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label-custom required small">Note</label>
                                            <div class="input-group border-custom">
                                                <span class="input-group-text"><i class="bi bi-journals"></i></span>
                                                <textarea name="note" id="note" class="form-control border-custom" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label-custom small">Evidence</label>
                                            <div class="input-group border-custom">
                                                <span class="input-group-text"><i class="bi bi-file-earmark-image"></i></span>
                                                <input type="file" name="evidence" id="evidence" class="form-control border-custom">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label-custom small">Evidence Link</label>
                                            <div class="input-group border-custom">
                                                <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
                                                <input type="text" name="evidence_link" id="evidence_link" class="form-control border-custom">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col" align="right">
                                            <button type="button" class="m-1 btn btn-default" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="m-1 btn btn-block btn-primary">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Tab Content for History -->
                            <div class="tab-pane fade" id="tab_activity">
                                <div style="height: 250px; overflow-y: scroll;">

                                    <table class="table table-striped table-borderless mt-2" id="tabel_activity">
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Tab Content for Files -->
                            <div class="tab-pane fade" id="tab_files">
                                <div style="height: 250px; overflow-y: scroll;">
                                    <div class="row mt-2">
                                        <div class="col-6" id="tabel_files">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <p class="title"><i class="bi bi-quote"></i> Meeting</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="table_mom">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Judul</th>
                                                <th>Meeting</th>
                                                <th>Department</th>
                                                <th>Peserta</th>
                                                <th>Agenda</th>
                                                <th>Pembahasan</th>
                                                <th>Tempat</th>
                                                <th>Tanggal</th>
                                                <th>Waktu</th>
                                                <th>Created by</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <p class="title"><i class="bi bi-quote"></i> Tasklist</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="table_ibr">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Goals</th>
                                                <th>PIC</th>
                                                <th>Type</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                                <th>Strategy</th>
                                                <th>Jenis Strategy</th>
                                                <th>Progres</th>
                                                <th>Timeline</th>
                                                <th>Evaluation</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <p class="title"><i class="bi bi-quote"></i> Genba</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="table_gen">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Date Plan</th>
                                                <th>Type Genba</th>
                                                <th>Lokasi</th>
                                                <th>Evaluasi</th>
                                                <th>Jml Peserta</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th>Created by</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <p class="title"><i class="bi bi-quote"></i> Co & Co</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="table_conco">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Karyawan</th>
                                                <th>Tempat</th>
                                                <th>Tanggal</th>
                                                <th>Atasan</th>
                                                <th>Review</th>
                                                <th>Goals</th>
                                                <th>Reality</th>
                                                <th>Option</th>
                                                <th>Will</th>
                                                <th>Komitmen</th>
                                                <th>Foto</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <p class="title"><i class="bi bi-quote"></i> Complaint</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="table_comp">
                                        <thead class="table-dark">
                                            <tr>
                                                <th class="text-nowrap small d-table-cell d-md-none">#</th>
                                                <th class="text-nowrap small th-goals">Complaints</th>
                                                <th class="text-nowrap small text-center">Category</th>
                                                <th class="text-nowrap small text-center">Project</th>
                                                <th class="text-nowrap small text-center">Blok</th>
                                                <th class="text-nowrap small" style="min-width: 90px;">Status</th>
                                                <th class="text-nowrap small text-center">Priority</th>
                                                <th class="text-nowrap small text-center" style="min-width: 150px;">Reported By</th>
                                                <th class="text-nowrap small text-center" style="min-width: 150px;">Verified To</th>
                                                <th class="text-nowrap small text-center" style="min-width: 150px;">Escalation To</th>
                                                <th class="text-nowrap small text-center" style="min-width: 150px;">Solver</th>
                                                <th class="text-nowrap small text-center">Due Date</th>
                                                <th class="text-nowrap small text-center">Progress</th>
                                                <th class="text-nowrap small text-center">Timeline</th>
                                                <th class="text-nowrap small text-center">Lt. Process</th>
                                                <th class="text-nowrap small text-center">Lt. Progress</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <p class="title"><i class="bi bi-quote"></i> TeamTalk</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="table_teamtalk">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Id Chat</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Informasi yang di berikan jelas dan mudah dipahami</th>
                                                <th>Masalah saya teratasi dengan baik</th>
                                                <th>Pelayanan yang saya terima cepat dan efisien</th>
                                                <th>Created At</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- MODAL CHANGE -->
<div class="modal fade" id="modal_change" tabindex="-1" aria-labelledby="modal_change" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-light-red">
                <div class="col-auto">
                    <i class="bi bi-journal-arrow-up h5 avatar avatar-40 bg-light text-purple rounded"></i>
                </div>
                <div class="col">
                    <h5 class="fw-bold mb-0" id="modal-list-waiting-resignationLabel">Request Change Deadline</h5>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <form id="request_change">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <input type="hidden" value="" name="id_detail">
                            <label for="">Divisi</label>
                            <input type="text" name="divisi" class="form-control" value="" readonly>
                        </div>
                        <div class="col-12 mb-2">
                            <input type="hidden" value="" name="id_detail">
                            <label for="">Goals</label>
                            <input type="text" name="nama_goal" class="form-control" value="" readonly>
                        </div>
                        <div class="col-6 mb-2">
                            <label for="">SO</label>
                            <input type="text" name="so" class="form-control" value="" readonly>
                        </div>
                        <div class="col-6 mb-2">
                            <label for="">SI</label>
                            <input type="text" name="si" class="form-control" value="" readonly>
                        </div>
                        <div class="col-12 mb-2">
                            <label for="">Detail Tasklist</label>
                            <input type="text" name="detail" class="form-control" value="" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6 mb-2">
                            <label class="required">Start</label>
                            <input type="date" name="start" class="form-control border-custom" value="" required="required">
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 mb-2">
                            <label class="required">End</label>
                            <input type="date" name="end" class="form-control border-custom" value="" required="required">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label class="required">Note</label>
                            <textarea name="note" class="form-control border-custom" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="m-1 btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="m-1 btn btn-danger text-white">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DETAIL SI -->
<div class="modal fade" id="modal_detail_si" tabindex="-1" aria-labelledby="modal_detail_si_label" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-light-blue">
                <div class="col-auto">
                    <i class="bi bi-newspaper h5 avatar avatar-40 bg-light text-purple rounded"></i>
                </div>
                <div class="col">
                    <h5 class="fw-bold mb-0" id="t_nama_si">Nama Goal</h5>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-lg-8 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="comingsoonbi bi bi-list-task h5 avatar avatar-40 bg-light-green text-green text-green rounded "></i>
                                    </div>
                                    <div class="col-sm-6 col-6 col-lg-6">
                                        <h6 class="fw-medium mb-0" id="t_si_si">SO</h6>
                                        <p class="text-secondary small" id="t_so_si">SI</p>
                                    </div>

                                    <div class="col-sm-6 col-lg-4 col-12 text-end">
                                        <p class="text-secondary small mb-1">Status</p>
                                        <span class="badge bg-success fs-6" id="t_status_si">Done</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-12 mb-2">
                                        <p class="title"><i class="bi bi-quote"></i> Detail Tasklist</p>
                                        <p id="t_detail_si"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <p class="text-secondary small mb-1">Divisi</p>
                                        <h6 class="small" id="t_divisi_si">Operasional</h6>
                                    </div>
                                    <div class="col mb-2">
                                        <p class="text-secondary small mb-1">Company</p>
                                        <span class="badge bg-light-blue text-dark" id="t_company_si">


                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3 col-md-3 mb-2">
                                        <p class="text-secondary small mb-1">PIC</p>
                                        <h6 class="small" id="t_pic_si"></h6>
                                    </div>

                                    <div class="col-3 col-md-4 mb-2">
                                        <p class="text-secondary small mb-1">Deadline </p>
                                        <h6 class="small d-inline" id="t_start_si"></h6><i class="bi bi-arrow-right-short"></i>
                                        <h6 class="small d-inline" id="t_deadline_si"></h6>
                                    </div>
                                    <div class="col-3 col-md-3 mb-2">
                                        <p class="text-secondary small mb-1">Output</p>
                                        <h6 class="small" id="t_output_si"></h6>
                                    </div>
                                    <div class="col-3 col-md-2 mb-2">
                                        <p class="text-secondary small mb-1">Target</p>
                                        <h6 class="small" id="t_target_si"></h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 col-sm-12">
                        <div class="row mb-2">
                            <div class="col-12">
                                <ul class="nav detail_tabs nav-WinDOORS">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#tab_update_si" id="nav_update_si">
                                            Update Progres
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tab_activity_si" id="nav_activity_si">
                                            History
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tab_files_si" id="nav_files_si">
                                            Files
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content">
                            <!-- Tab Content for Update Progres -->
                            <div class="tab-pane fade show active" id="tab_update_si">
                                <form id="form_update_si" enctype="multipart/form-data" class="mt-2">
                                    <input type="hidden" name="id_si">
                                    <input type="hidden" name="target" id="target_si">
                                    <input type="hidden" name="actual_tipe" id="actual_tipe_si">
                                    <input type="hidden" name="target_tipe" id="target_tipe_si">
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label class="form-label-custom required small">Status</label>
                                            <div class="input-group border-custom">
                                                <span class="input-group-text"><i class="bi bi-alexa"></i></span>
                                                <select name="status" id="status_si" class="form-control border-custom" required>
                                                    <?php foreach ($status as $item) : ?>
                                                        <option value="<?= $item->id ?>"><?= $item->nama ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <input type="hidden" name="status_before" id="status_si_before">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label-custom small">Actual</label>
                                            <div class="input-group border-custom">
                                                <span class="input-group-text"><i class="bi bi-hourglass-split"></i></span>
                                                <input type="number" name="actual" id="actual_si" class="form-control border-custom" min="0" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">

                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label-custom required small">Note</label>
                                            <div class="input-group border-custom">
                                                <span class="input-group-text"><i class="bi bi-journals"></i></span>
                                                <textarea name="note" id="note_si" class="form-control border-custom" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label-custom small">Evidence</label>
                                            <div class="input-group border-custom">
                                                <span class="input-group-text"><i class="bi bi-file-earmark-image"></i></span>
                                                <input type="file" name="evidence" id="evidence_si" class="form-control border-custom">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label-custom small">Evidence Link</label>
                                            <div class="input-group border-custom">
                                                <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
                                                <input type="text" name="evidence_link" id="evidence_link_si" class="form-control border-custom">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col" align="right">
                                            <button type="button" class="m-1 btn btn-default" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="m-1 btn btn-block btn-primary">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Tab Content for History -->
                            <div class="tab-pane fade" id="tab_activity_si">
                                <div style="height: 250px; overflow-y: scroll;">
                                    <table class="table table-striped table-borderless mt-2" id="tabel_activity_si">
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Tab Content for Files -->
                            <div class="tab-pane fade" id="tab_files_si">
                                <div style="height: 250px; overflow-y: scroll;">
                                    <div class="row mt-2">
                                        <div class="col-6" id="tabel_files_si">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <p class="title"><i class="bi bi-quote"></i> Meeting</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="table_mom_si">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Judul</th>
                                                <th>Meeting</th>
                                                <th>Department</th>
                                                <th>Peserta</th>
                                                <th>Agenda</th>
                                                <th>Pembahasan</th>
                                                <th>Tempat</th>
                                                <th>Tanggal</th>
                                                <th>Waktu</th>
                                                <th>Created by</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <p class="title"><i class="bi bi-quote"></i> Tasklist</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="table_ibr_si">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Goals</th>
                                                <th>PIC</th>
                                                <th>Type</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                                <th>Strategy</th>
                                                <th>Jenis Strategy</th>
                                                <th>Progres</th>
                                                <th>Timeline</th>
                                                <th>Evaluation</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <p class="title"><i class="bi bi-quote"></i> Genba</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="table_gen_si">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Date Plan</th>
                                                <th>Type Genba</th>
                                                <th>Lokasi</th>
                                                <th>Evaluasi</th>
                                                <th>Jml Peserta</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th>Created by</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <p class="title"><i class="bi bi-quote"></i> Co & Co</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="table_conco_si">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Karyawan</th>
                                                <th>Tempat</th>
                                                <th>Tanggal</th>
                                                <th>Atasan</th>
                                                <th>Review</th>
                                                <th>Goals</th>
                                                <th>Reality</th>
                                                <th>Option</th>
                                                <th>Will</th>
                                                <th>Komitmen</th>
                                                <th>Foto</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <p class="title"><i class="bi bi-quote"></i> Complaint</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="table_comp_si">
                                        <thead class="table-dark">
                                            <tr>
                                                <th class="text-nowrap small d-table-cell d-md-none">#</th>
                                                <th class="text-nowrap small th-goals">Complaints</th>
                                                <th class="text-nowrap small text-center">Category</th>
                                                <th class="text-nowrap small text-center">Project</th>
                                                <th class="text-nowrap small text-center">Blok</th>
                                                <th class="text-nowrap small" style="min-width: 90px;">Status</th>
                                                <th class="text-nowrap small text-center">Priority</th>
                                                <th class="text-nowrap small text-center" style="min-width: 150px;">Reported By</th>
                                                <th class="text-nowrap small text-center" style="min-width: 150px;">Verified To</th>
                                                <th class="text-nowrap small text-center" style="min-width: 150px;">Escalation To</th>
                                                <th class="text-nowrap small text-center" style="min-width: 150px;">Solver</th>
                                                <th class="text-nowrap small text-center">Due Date</th>
                                                <th class="text-nowrap small text-center">Progress</th>
                                                <th class="text-nowrap small text-center">Timeline</th>
                                                <th class="text-nowrap small text-center">Lt. Process</th>
                                                <th class="text-nowrap small text-center">Lt. Progress</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <p class="title"><i class="bi bi-quote"></i> TeamTalk</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="table_teamtalk_si">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Id Chat</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Informasi yang di berikan jelas dan mudah dipahami</th>
                                                <th>Masalah saya teratasi dengan baik</th>
                                                <th>Pelayanan yang saya terima cepat dan efisien</th>
                                                <th>Created At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- MODAL DETAIL SO -->
<div class="modal fade" id="modal_detail_so" tabindex="-1" aria-labelledby="modal_detail_so_label" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-light-blue">
                <div class="col-auto">
                    <i class="bi bi-newspaper h5 avatar avatar-40 bg-light text-purple rounded"></i>
                </div>
                <div class="col">
                    <h5 class="fw-bold mb-0" id="t_nama_so">Nama Goal</h5>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-lg-8 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="comingsoonbi bi bi-list-task h5 avatar avatar-40 bg-light-green text-green text-green rounded "></i>
                                    </div>
                                    <div class="col-sm-6 col-6 col-lg-6">
                                        <h6 class="fw-medium mb-0" id="t_so_so">SO</h6>
                                    </div>

                                    <div class="col-sm-6 col-lg-4 col-12 text-end">
                                        <p class="text-secondary small mb-1">Status</p>
                                        <span class="badge bg-success fs-6" id="t_status_so">Done</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-12 mb-2">
                                        <p class="title"><i class="bi bi-quote"></i> Detail Tasklist</p>
                                        <p id="t_detail_so"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <p class="text-secondary small mb-1">Divisi</p>
                                        <h6 class="small" id="t_divisi_so">Operasional</h6>
                                    </div>
                                    <div class="col mb-2">
                                        <p class="text-secondary small mb-1">Company</p>
                                        <span class="badge bg-light-blue text-dark" id="t_company_so">


                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3 col-md-3 mb-2">
                                        <p class="text-secondary small mb-1">PIC</p>
                                        <h6 class="small" id="t_pic_so"></h6>
                                    </div>

                                    <div class="col-3 col-md-4 mb-2">
                                        <p class="text-secondary small mb-1">Deadline </p>
                                        <h6 class="small d-inline" id="t_start_so"></h6><i class="bi bi-arrow-right-short"></i>
                                        <h6 class="small d-inline" id="t_deadline_so"></h6>
                                    </div>
                                    <div class="col-3 col-md-3 mb-2">
                                        <p class="text-secondary small mb-1">Output</p>
                                        <h6 class="small" id="t_output_so"></h6>
                                    </div>
                                    <div class="col-3 col-md-2 mb-2">
                                        <p class="text-secondary small mb-1">Target</p>
                                        <h6 class="small" id="t_target_so"></h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 col-sm-12">
                        <div class="row mb-2">
                            <div class="col-12">
                                <ul class="nav detail_tabs nav-WinDOORS">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#tab_update_so" id="nav_update_so">
                                            Update Progres
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tab_activity_so" id="nav_activity_so">
                                            History
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tab_files_so" id="nav_files_so">
                                            Files
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content">
                            <!-- Tab Content for Update Progres -->
                            <div class="tab-pane fade show active" id="tab_update_so">
                                <form id="form_update_so" enctype="multipart/form-data" class="mt-2">
                                    <input type="hidden" name="id_so">
                                    <input type="hidden" name="target" id="target_so">
                                    <input type="hidden" name="actual_tipe" id="actual_tipe_so">
                                    <input type="hidden" name="target_tipe" id="target_tipe_so">
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label class="form-label-custom required small">Status</label>
                                            <div class="input-group border-custom">
                                                <span class="input-group-text"><i class="bi bi-alexa"></i></span>
                                                <select name="status" id="status_so" class="form-control border-custom" required>
                                                    <?php foreach ($status as $item) : ?>
                                                        <option value="<?= $item->id ?>"><?= $item->nama ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <input type="hidden" name="status_before" id="status_so_before">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label-custom small">Actual</label>
                                            <div class="input-group border-custom">
                                                <span class="input-group-text"><i class="bi bi-hourglass-split"></i></span>
                                                <input type="number" name="actual" id="actual_so" class="form-control border-custom" min="0" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">

                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label-custom required small">Note</label>
                                            <div class="input-group border-custom">
                                                <span class="input-group-text"><i class="bi bi-journals"></i></span>
                                                <textarea name="note" id="note_so" class="form-control border-custom" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label-custom small">Evidence</label>
                                            <div class="input-group border-custom">
                                                <span class="input-group-text"><i class="bi bi-file-earmark-image"></i></span>
                                                <input type="file" name="evidence" id="evidence_so" class="form-control border-custom">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label-custom small">Evidence Link</label>
                                            <div class="input-group border-custom">
                                                <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
                                                <input type="text" name="evidence_link" id="evidence_link_so" class="form-control border-custom">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col" align="right">
                                            <button type="button" class="m-1 btn btn-default" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="m-1 btn btn-block btn-primary">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Tab Content for History -->
                            <div class="tab-pane fade" id="tab_activity_so">
                                <div style="height: 250px; overflow-y: scroll;">
                                    <table class="table table-striped table-borderless mt-2" id="tabel_activity_so">
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Tab Content for Files -->
                            <div class="tab-pane fade" id="tab_files_so">
                                <div style="height: 250px; overflow-y: scroll;">
                                    <div class="row mt-2">
                                        <div class="col-6" id="tabel_files_so">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- 8-3-25 Edit detail tasklist -->
<div class="modal fade" id="modal_edit_detail_tasklist" aria-labelledby="modal_edit_detail_tasklist" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content">

            <form id="form_edit_tasklist" enctype="multipart/form-data">
                <input type="hidden" name="edit_id_tasklist" id="edit_id_tasklist">

                <div class="modal-header row align-items-center bg-blue_2">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light text-purple rounded"></i>
                    </div>
                    <div class="col">
                        <h5 class="fw-bold mb-0 text-white" id="modal-list-waiting-resignationLabel">Edit Tasklist GRD</h5>
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
                <div class="row" id="edit_id_detail_row">
                        <div class="mb-2 col-12 col-md-12" id="edit_id_detail_div0">
                            <div class="card">
                                <div class="card-body">
                                
                                    <div class="row">
                                        <div class="col-3 col-md-12 mb-2">
                                            <label class="form-label-custom required small mb-1" for="pic">PIC</label>
                                            <div class="input-group mb-3 border-custom">
                                                <select name="id_pic" id="edit_id_pic" class="form-control border-custom" multiple="">
                                                    <!-- <option value="#" disabled>-- Pilih PIC --</option> -->
                                                    <option data-placeholder="true">-- Choose Employee --</option>
                                                        <?php foreach ($pic_edit as $row) : ?>
                                                            <option value="<?= $row->user_id ?>"><?= $row->pic_name ?></option>
                                                        <?php endforeach; ?>
                                                </select>
                                                <input type="hidden" id="user_edit_pic" name="user_edit_pic" readonly>
                                            </div>
                                        </div>

                                        <?php if ($this->session->userdata('user_id') == 1 || $this->session->userdata('user_id') == 118 || $this->session->userdata('user_id') == 2729 || $this->session->userdata('user_id') == 3690) { ?>

                                            <div class="col-3 col-md-12 mb-2">
                                                <label class="form-label-custom required small mb-1" for="tgl_start">Tanggal Mulai</label>
                                                <div class="input-group mb-3 border-custom">
                                                    <input type="text" class="form-control datepicker border-custom" name="tgl_start" id="edit_tgl_start" placeholder="Tanggal Mulai">
                                                </div>
                                            </div>

                                            <div class="col-3 col-md-12 mb-2">
                                                <label class="form-label-custom required small mb-1" for="tgl_end">Deadline</label>
                                                <div class="input-group mb-3 border-custom">
                                                    <input type="text" class="form-control datepicker border-custom" name="tgl_end" id="edit_tgl_end" placeholder="Deadline">
                                                </div>
                                            </div>

                                        <?php } else { ?>

                                            <div class="col-3 col-md-12 mb-2">
                                                <label class="form-label-custom required small mb-1" for="tgl_start">Tanggal Mulai</label>
                                                <div class="input-group mb-3 border-custom">
                                                    <input type="text" class="form-control border-custom" name="tgl_start" id="edit_tgl_start_pic" placeholder="Tanggal Mulai" readonly>
                                                </div>
                                            </div>

                                            <div class="col-3 col-md-12 mb-2">
                                                <label class="form-label-custom required small mb-1" for="tgl_end">Deadline</label>
                                                <div class="input-group mb-3 border-custom">
                                                    <input type="text" class="form-control border-custom" name="tgl_end" id="edit_tgl_end_pic" placeholder="Deadline" readonly>
                                                </div>
                                            </div>

                                        <?php } ?>

                                        <div class="col-3 col-md-12 mb-2">
                                            <label class="form-label-custom required small mb-1" for="detail" id="label_detail">Detail Pekerjaan</label>
                                            <div class="input-group border-custom mb-3">
                                                <input type="text" class="form-control border-custom" name="detail" id="edit_detail" placeholder="Detail Pekerjaan">
                                                <input type="hidden" class="form-control border-custom" name="before_detail" id="before_detail" placeholder="Detail Pekerjaan">
                                            </div>
                                        </div>

                                        <div class="col-3 col-md-12 mb-2">
                                            <label class="form-label-custom required small mb-1" for="output">Output</label>
                                            <div class="input-group mb-3 border-custom">
                                                <input type="text" class="form-control border-custom" name="output" id="edit_output" placeholder="Output Pekerjaan">
                                            </div>
                                        </div>

                                        <div class="col-3 col-md-12 mb-2">
                                            <label class="form-label-custom small mb-1" for="target">Target</label>
                                            <div class="input-group mb-3 border-custom">
                                                <input type="number" class="form-control border-custom" name="target" id="edit_target" placeholder="Target Pencapaian Pekerjaan, contoh: 100">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="mfoot_div">
                    <button type="button" class="m-1 btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="m-1 btn bg-blue_2" style="border-radius: 5px; color: white;" onmouseover="this.style.color='black'" onmouseout="this.style.color='white'">Save</button>
                </div>

            </form>
            
        </div>
        
    </div>
</div>