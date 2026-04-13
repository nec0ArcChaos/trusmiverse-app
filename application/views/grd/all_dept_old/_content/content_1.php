<style>
    .progress-bar {
        white-space: nowrap;   /* Prevent text from wrapping */
        overflow: visible;     /* Allow text to be shown outside the bar */
        text-overflow: clip;   /* Avoid cutting off text */
    }


    .gantt-container {
        background-color: #081226;  
        overflow-x: auto;
        padding: 20px;
        border-radius: 8px;
    }

    /* Timeline Header */
    .gantt-header {
        display: flex;
        position: relative;
        margin-bottom: 30px;
        align-items: center; /* Aligns circles and text */

    }

    /* Dotted Line BELOW the month names */
    .gantt-header::after {
        content: "";
        position: absolute;
        top: 25px; /* Moves the line below the text */
        left: 0;
        width: 100%;
        height: 2px;
        background: white;
        z-index: 0; /* Keep it below the circles */
    }

    /* Month Container */
    .gantt-header div {
        flex: 1;
        text-align: center;
        position: relative;
        color: white; 
        font-weight: bold;
        font-size: 14px;
    }

    /* Large Circles */
    .gantt-header div::after {
        content: "";
        width: 14px;
        height: 14px;
        background-color: white; 
        border-radius: 50%;
        position: absolute;
        top: 18px; /* Adjusted so the circle overlaps the line */
        left: 50%;
        transform: translateX(-50%);
        z-index: 1; /* Ensure circles are on top */
    }

    /* Month Names (placed ABOVE the line) */
    .gantt-header div::before {
        content: attr(data-month);
        position: absolute;
        top: -5px; /* Moves the text above the dotted line */
        left: 50%;
        transform: translateX(-50%);
    }


    .gantt-row {
        display: flex;
        align-items: center;
    }

    .gantt-row div {
        flex: 1;
        text-align: center;
        padding: 2px;
    }

    .gantt-bar {
        height: 20px;
        line-height: 20px;
        color: white;
        text-align: center;
        border-radius: 5px;
    }

    .gantt-bar-blue { background-color: #007bff; }
    .gantt-bar-green { background-color: #28a745; }
    .gantt-bar-yellow { background-color: #ffc107; }

</style>

<div class="row mb-3">

    <div class="col-md-9 col-sm-12 mb-2">
        <div class="card" style="border-radius: 25px; margin-right: -10px;">
            <div class="card-header d-flex justify-content-center align-items-center text-center" style="border-radius: 25px 25px 0 0; background-color: #081226;">
                <h5 class="text-white mt-3 fw-bold"><i class="bi bi-substack"></i>Misi & Milestone 2025 | <?= $company_name; ?></h5>
            </div>
            <div class="card-body" style="border-radius: 0 0 25px 25px; background-color: #081226;">

                <div class="gantt-container">
                    <!-- Timeline Header (Months with Dotted Line) -->
                    <div class="gantt-header">
                        <div data-month="Jan"></div>
                        <div data-month="Feb"></div>
                        <div data-month="Mar"></div>
                        <div data-month="Apr"></div>
                        <div data-month="May"></div>
                        <div data-month="Jun"></div>
                        <div data-month="Jul"></div>
                        <div data-month="Aug"></div>
                        <div data-month="Sep"></div>
                        <div data-month="Oct"></div>
                        <div data-month="Nov"></div>
                        <div data-month="Dec"></div>
                    </div>
                    <!-- Gantt Content from content_1_js.php -->
                    <div id="gantt-content"></div>
                </div>
                        
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-12 mb-2">
        <div class="card" style="border-radius: 25px; margin-right: 0px;">
            <div class="card-header bg-white d-flex justify-content-center align-items-center" style="border-radius: 25px 25px 0 0;">
                <h6 class="mb-0 fw-bold">
                    Budget vs Aktual
                </h6>
            </div>
            <div class="card-body bg-white" style="border-radius: 0 0 25px 25px;">
                <div class="row">
                    <div class="col-5 d-flex align-items-center justify-content-center">
                        <div id="chart_pie_budget" style="width: 110px;"></div>
                    </div>
                    <div class="col-7">
                        <div class="d-flex align-items-center">
                            <div class="progress mb-2" style="height: 45px; width: 80%;">
                                <div class="progress-bar bg-blue_1 text-white text-start" id="eaf_pengeluaran_bar" style="width: 80%; font-size: 12px;">
                                    <span style="margin-left: 10px;">
                                        <b>Pengeluaran/Cost</b>
                                        <br>
                                        <p id="eaf_pengeluaran">Rp. 0 / 0</p>

                                    </span>
                                </div>
                            </div>
                            <span class="ms-2 fw-bold text-grey" style="font-size: 14px;" id="eaf_pengeluaran_p">0%</span>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="progress mb-2" style="height: 45px; width: 80%;">
                                <div class="progress-bar bg-blue_2 text-white text-start" id="eaf_sdm_bar" style="width: 50%; font-size: 12px;">
                                    <span style="margin-left: 10px;">
                                        <b>Biaya SDM</b>
                                        <br>
                                        <p id="eaf_sdm">Rp.0 / 0</p>
                                    </span>
                                </div>
                            </div>
                            <span class="ms-2 fw-bold text-grey" style="font-size: 14px;" id="eaf_sdm_p">0%</span>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="progress" style="height: 45px; width: 80%;">
                                <div class="progress-bar bg-blue_3 text-white text-start" id="eaf_produksi_bar" style="width: 80%; font-size: 12px;">
                                    <span style="margin-left: 10px;">
                                        <b>Biaya Produksi</b>
                                        <br>
                                        <p id="eaf_produksi">Rp.0 / 0<p>
                                    </span>
                                </div>
                            </div>
                            <span class="ms-2 fw-bold text-grey" style="font-size: 14px;" id="eaf_produksi_p">0%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<!-- MODAL DETAIL MILESTONE -->
<div class="modal fade" id="modal_detail_milestone" tabindex="-1" aria-labelledby="modal_detail_milestone_label" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-light-blue">
                <div class="col-auto">
                    <i class="bi bi-newspaper h5 avatar avatar-40 bg-light text-purple rounded"></i>
                </div>
                <div class="col">
                    <h5 class="fw-bold mb-0">Milestone</h5>
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
                    <div class="col-12 col-lg-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="comingsoonbi bi bi-list-task h5 avatar avatar-40 bg-light-green text-green text-green rounded "></i>
                                    </div>
                                    <div class="col-sm-6 col-6 col-lg-6">
                                        <h6 class="fw-medium mb-0" id="t_nama_milestone">Milestone</h6>
                                        <p class="small mb-1" id="t_mile_company">Company</p>
                                    </div>

                                    <div class="col-sm-6 col-lg-4 col-12 text-end">
                                        <p class="text-secondary small mb-1">Progress</p>
                                        <span class="badge bg-success fs-6" id="t_mile_progress">0%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- <div class="row mb-2">
                                    <div class="col-12 mb-2">
                                        <p class="title"><i class="bi bi-quote"></i> Detail Milestone</p>
                                    </div>
                                </div> -->
                                
                                <div class="row">
                                    <div class="col-3 col-md-7 mb-2">
                                        <p class="text-secondary small mb-1">Deadline </p>
                                        <h6 class="small d-inline" id="t_mile_start"></h6><i class="bi bi-arrow-right-short"></i>
                                        <h6 class="small d-inline" id="t_mile_deadline"></h6>
                                    </div>
                                    <div class="col-3 col-md-2 mb-2">
                                        <p class="text-secondary small mb-1">Target</p>
                                        <h6 class="small" id="t_mile_target"></h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-12 col-lg-4 col-sm-12">
                        <div class="row mb-2">
                            <div class="col-12">
                                <ul class="nav detail_tabs nav-WinDOORS">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="javascript:void(0)" id="nav_update_milestone" onclick="activateTab('update_milestone')">
                                            Update Progres
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab_update_milestone">
                                <form id="form_update_milestone" enctype="multipart/form-data" class="mt-2">
                                    <input type="hidden" name="t_id_milestone">
                                    <input type="hidden" name="t_target">
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label class="form-label-custom small">Actual</label>
                                            <div class="input-group border-custom">
                                                <span class="input-group-text"><i class="bi bi-hourglass-split"></i></span>
                                                <input type="number" name="actual" id="t_mile_actual" class="form-control border-custom" max="100" min="0" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col" align="right">
                                            <button type="submit" class="m-1 btn btn-block btn-primary">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div> -->
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <p class="title"><i class="bi bi-quote"></i> Tasklist Milestone</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="table_task_milestone">
                                        <thead class="table-dark">
                                            <tr>
                                                <!-- <th>#</th> -->
                                                <th>Milestone</th>
                                                <th>Detail</th>
                                                <th>PIC</th>
                                                <th>Start</th>
                                                <th>End</th>
                                                <th>Output</th>
                                                <th>Target</th>
                                                <th>Actual</th>
                                                <th>Status</th>
                                                <th>Done At</th>
                                                <th>Leadtime</th>
                                                <th>Note</th>
                                                <th>Evidence</th>
                                                <th>Created by</th>
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

<!-- MODAL DETAIL TASKLIST MILESTONE -->
<div class="modal fade" id="modal_tasklist_milestone" tabindex="-1" aria-labelledby="modal_tasklist_milestone_label" data-bs-backdrop="false" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-light-blue">
                <div class="col-auto">
                    <i class="bi bi-newspaper h5 avatar avatar-40 bg-light text-purple rounded"></i>
                </div>
                <div class="col">
                    <h5 class="fw-bold mb-0" id="det_nama_milestone">Nama Milestone</h5>
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
                                        <!-- <h6 class="fw-medium mb-0" id="det_nama_company">Company</h6> -->
                                        <p class="text-secondary small" id="det_divisi">Divisi</p>
                                    </div>

                                    <div class="col-sm-6 col-lg-4 col-12 text-end">
                                        <p class="text-secondary small mb-1">Status</p>
                                        <span class="badge bg-success fs-6" id="det_status">Done</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-12 mb-2">
                                        <p class="title"><i class="bi bi-quote"></i> Detail Tasklist</p>
                                        <p id="det_detail"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3 col-md-3 mb-2">
                                        <p class="text-secondary small mb-1">PIC</p>
                                        <h6 class="small" id="det_pic"></h6>
                                    </div>

                                    <div class="col-3 col-md-4 mb-2">
                                        <p class="text-secondary small mb-1">Deadline </p>
                                        <h6 class="small d-inline" id="det_start"></h6><i class="bi bi-arrow-right-short"></i>
                                        <h6 class="small d-inline" id="det_deadline"></h6>
                                    </div>
                                    <div class="col-3 col-md-3 mb-2">
                                        <p class="text-secondary small mb-1">Output</p>
                                        <h6 class="small" id="det_output"></h6>
                                    </div>
                                    <div class="col-3 col-md-2 mb-2">
                                        <p class="text-secondary small mb-1">Target</p>
                                        <h6 class="small" id="det_target"></h6>
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
                                        <a class="nav-link active" href="javascript:void(0)" id="nav_update_det" onclick="activateTab('update_det')">
                                            Update Progres
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="javascript:void(0)" id="nav_activity_det" onclick="activateTab('activity_det')">
                                            History
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="javascript:void(0)" id="nav_files_det" onclick="activateTab('files_det')">
                                            Files
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content">
                            <!-- Tab Content for Update Progres -->
                            <div class="tab-pane fade show active" id="tab_update_det">
                                <form id="form_update_tasklist_milestone" enctype="multipart/form-data" class="mt-2">
                                    <input type="hidden" name="det_id_tasklist">
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label class="form-label-custom required small">Status</label>
                                            <div class="input-group border-custom">
                                                <span class="input-group-text"><i class="bi bi-alexa"></i></span>
                                                <select name="status" id="det_status" class="form-control border-custom" required>
                                                    <?php foreach ($status as $item) : ?>
                                                        <option value="<?= $item->id ?>"><?= $item->nama ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <input type="hidden" name="status_before" id="det_status_before">
                                                <input type="hidden" name="target_milestone" id="det_target_milestone">
                                                <input type="hidden" name="target_milestone_type" id="det_target_milestone_type">
                                                <input type="hidden" name="actual_milestone_type" id="det_actual_milestone_type">

                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label-custom small">Actual</label>
                                            <div class="input-group border-custom">
                                                <span class="input-group-text"><i class="bi bi-hourglass-split"></i></span>
                                                <input type="number" name="actual" id="det_actual" class="form-control border-custom" max="100" min="0" value="0">
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
                                                <textarea name="note" id="det_note" class="form-control border-custom" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label-custom small">Evidence</label>
                                            <div class="input-group border-custom">
                                                <span class="input-group-text"><i class="bi bi-file-earmark-image"></i></span>
                                                <input type="file" name="evidence" id="det_evidence" class="form-control border-custom">
                                            </div>                                           
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label-custom small">Evidence Link</label>                                           
                                            <div class="input-group border-custom">
                                                <span class="input-group-text"><i class="bi bi-journals"></i></span>
                                                <input type="text" name="evidence_link" id="det_evidence_link" class="form-control border-custom">
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
                            <div class="tab-pane fade" id="tab_activity_det">
                                <div style="height: 250px; overflow-y: scroll;">

                                    <table class="table table-striped table-borderless mt-2" id="tabel_activity_detail">
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Tab Content for Files -->
                            <div class="tab-pane fade" id="tab_files_det">
                                <div style="height: 250px; overflow-y: scroll;">
                                    <div class="row mt-2">
                                        <div class="col-6" id="tabel_files_detail">

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