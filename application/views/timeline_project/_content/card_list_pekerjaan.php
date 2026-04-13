<div class="col-12 col-md-12 col-lg-12 col-xxl-12 mb-3">
    <div id="list_pekerjaan"></div>
</div>
<div class="modal fade" id="modal_detail_pekerjaan" tabindex="-1" aria-labelledby="modal_detail_pekerjaan_label" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-light-blue">
                <div class="col-auto">
                    <i class="bi bi-newspaper h5 avatar avatar-40 bg-light text-purple rounded"></i>
                </div>
                <div class="col">
                    <h5 class="fw-bold mb-0" id="modal-list-waiting-resignationLabel">Detail Pekerjaan</h5>
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
                                        <h6 class="fw-medium mb-0" id="t_pekerjaan">Pekerjaan utama</h6>
                                        <p class="text-secondary small" id="t_sub_pekerjaan">Sub pekerjaan</p>
                                    </div>

                                    <div class="col-sm-6 col-lg-4 col-12 text-end">
                                        <p class="text-secondary small mb-1">Status</p>
                                        <span class="badge bg-success fs-6" id="t_status">Done</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <p class="title"><i class="bi bi-quote"></i> Detail Pekerjaan</p>
                                        <p id="t_detail"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <p class="text-secondary small mb-1">Project</p>
                                        <h6 class="small" id="t_project">RN Sampora</h6>
                                    </div>
                                    <div class="col mb-2">
                                        <p class="text-secondary small mb-1">Departement</p>
                                        <span class="badge bg-light-blue text-dark" id="t_department">


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
                                    <input type="hidden" name="id_detail_pekerjaan">
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
                            <label for="">Project</label>
                            <input type="text" name="project" class="form-control" value="" readonly>
                        </div>
                        <div class="col-6 mb-2">
                            <label for="">Pekerjaan</label>
                            <input type="text" name="nama_pekerjaan" class="form-control" value="" readonly>
                        </div>
                        <div class="col-6 mb-2">
                            <label for="">Sub Pekerjaan</label>
                            <input type="text" name="sub_pekerjaan" class="form-control" value="" readonly>
                        </div>
                        <div class="col-12 mb-2">
                            <label for="">Detail Pekerjaan</label>
                            <input type="text" name="detail_pekerjaan" class="form-control" value="" readonly>
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
