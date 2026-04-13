<!-- Modal Update Sub Task -->
<div class="modal fade" id="modal_update_sub_task" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modal_update_sub_taskLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light text-theme rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal_update_sub_taskLabel">Update Strategy</h6>
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
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="title" id="title_sub_task"></h6>
                                <form id="form-update-sub-task">
                                    <div class="row">
                                        <div class="col-12 col-md-12 d-none">
                                            <div class="mb-1">
                                                <label class="small text-secondary" for="sub_task">Strategy</label>
                                                <input type="text" name="u_id_sub_task" id="u_id_sub_task" class="form-control" readonly>
                                                <input type="text" name="u_id_task" id="u_id_task" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-6" id="div_u_history_sub_note">
                                            <input type="hidden" name="id_type_goals" id="id_type_goals">
                                            <div class="mb-1">
                                                <label class="small text-secondary" for="history_sub_note">Note</label>
                                                <textarea name="history_sub_note" id="u_history_sub_note" class="form-control" cols="30" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-12" id="div_ekspektasi">
                                            <div class="mb-1">
                                                <label class="small text-secondary" for="history_ekspektasi">Ekspektasi</label>
                                                <textarea name="history_ekspektasi" id="u_history_ekspektasi" class="form-control" cols="30" rows="3" readonly></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-6">
                                            <div class="mb-1">
                                                <label class="small text-secondary" for="history_sub_evaluasi">Evaluasi Strategy</label>
                                                <textarea name="history_sub_evaluasi" id="u_history_sub_evaluasi" class="form-control" cols="30" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-6">
                                            <div class="mb-1">
                                                <label class="small text-secondary" for="u_history_progress">Progress</label>
                                                <input type="text" name="history_progress" id="u_history_progress" class="form-control" readonly>
                                                <input type="hidden" name="week_number" id="u_week_number" class="form-control" readonly>
                                                <input type="hidden" name="week_start_date" id="u_week_start_date" class="form-control" readonly>
                                                <input type="hidden" name="week_end_date" id="u_week_end_date" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-6">
                                            <div class="mb-1">
                                                <label class="small text-secondary" for="">File</label>
                                                <input type="file" name="history_file_sub" id="u_history_file_sub" class="form-control" accept="image/*" capture="environment">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-6">
                                            <div class="mb-1">
                                                <label class="small text-secondary" for="">Link</label>
                                                <input type="text" name="history_link_sub" id="u_history_link_sub" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-6">
                                            <div class="mb-1">
                                                <label class="small text-secondary" for="">Notification Hour</label>
                                                <select name="u_jam_notif" id="u_jam_notif" class="form-control">
                                                <?php
                                                for ($hour = 0; $hour < 24; $hour++) {
                                                    for ($minute = 0; $minute < 60; $minute += 15) {
                                                        $time = sprintf("%02d:%02d", $hour, $minute);
                                                        echo "<option value=\"$time\">$time WIB</option>";
                                                    }
                                                }
                                                ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-6">
                                            <div class="mb-1">
                                                <label class="small text-secondary" for="">Status</label>
                                                <select class="form-control status_strategy" name="status" id="status">
                                                    <!-- <option value="" selected disabled>-- Pilih Status --</option>
                                                    <option value="1">Jalan Berhasil</option>
                                                    <option value="2">Jalan Tidak Berhasil</option>
                                                    <option value="3">Tidak Berjalan</option> -->
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-12 text-end">
                                            <div class="mb-1">
                                                <button type="button" class="btn btn-theme text-white m-1" onclick="save_update_sub_task()">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="title">Activity Log</h6>
                                <table id="dt_log_history_sub_task" class="table table-sm table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_log_hitory_sub_task">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link m-1" onclick="close_update_sub_task()">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal New Task -->
<div class="modal fade" id="modal_add_task" tabindex="-1" aria-labelledby="modal_add_taskLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal-list-waiting-resignationLabel">Add Goals</h6>
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
                    <div class="col-12 col-md-6 d-none">
                        <div class="mb-2">
                            <label class="form-label-custom required small" for="id_type">Group</label>
                            <select name="id_type" id="id_type" class="wide mb-2" onchange="get_category()">

                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 d-none">
                        <div class="mb-2">
                            <label class="form-label-custom required small" for="id_category">Category</label>
                            <select name="id_category" id="id_category" class="wide mb-2" onchange="get_object()" disabled>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 d-none">
                        <div class="mb-2">
                            <label class="form-label-custom required small" for="id_object">Object</label>
                            <select name="id_object" id="id_object" class="wide mb-2" disabled>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 d-none">
                        <div class="mb-2">
                            <label class="form-label-custom required small" for="id_status">Status</label>
                            <select name="id_status" id="id_status" class="wide mb-2">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-2 col-12 col-md-12">
                        <div class="form-group position-relative check-valid">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text text-theme border-end-0"><i class="bi bi-check2-square"></i></span>
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="task" id="task" placeholder="Goals">
                                    <label class="form-label-custom required small" for="task">Goals</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <label class="form-label-custom small" for="description"><i class="text-theme bg-white bi bi-list-columns-reverse"></i> Description</label>
                                <textarea name="description" id="description"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-12">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-1-square"></i></span>
                                <div class="form-floating bg-white">
                                    <select name="id_priority" id="id_priority" class="mb-2 mt-4-5 w-90 border-0" style="display: none;">
                                    </select>
                                    <label class="form-label-custom small" for="id_priority">Priority</label>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="mb-3 col-12 col-md-12">
                        <div class="mb-2 col-12 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <label class="form-label-custom required small" for="indicator"><i class="text-theme bi bi-bar-chart-line"></i> Indicator</label>
                                    <textarea name="indicator" id="indicator" class="form-control" style="height: 100px;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="mb-3 col-12 col-md-12">
                        <div class="mb-3">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme border-end-0"><i class="bi bi-person-fill-check"></i></span>
                                    <div class="form-floating bg-white">
                                        <select name="id_pic" id="id_pic" class="mb-2 mt-4-5 w-90 border-0" style="display: none;" multiple>
                                        </select>
                                        <label class="form-label-custom required small" for="id_pic">PIC</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <div class="mb-3 d-none" id="goals_div">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-heading"></i></span>
                                    <div class="form-floating bg-white">
                                        <div style="margin-top: 2.5rem;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="jenis_strategy" id="jenis_strategy1" checked value="Once" style="cursor: pointer;">
                                                <label class="form-check-label" for="jenis_strategy1" style="cursor: pointer;">
                                                    Once
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="jenis_strategy" id="jenis_strategy2" value="Consistency" style="cursor: pointer;">
                                                <label class="form-check-label" for="jenis_strategy2" style="cursor: pointer;">
                                                    Consistency
                                                </label>
                                            </div>
                                        </div>
                                        <label class="form-label-custom required small" for="strategy">Jenis Strategy</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <div class="mb-3">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-date"></i></span>
                                    <div class="form-floating">
                                        <input type="text" class="form-control tanggal" name="due_date" id="due_date" placeholder="YYYY-MM-DD" autocomplete="off">
                                        <label class="form-label-custom required small" for="due_date">Due Date</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <input type="checkbox" name="" id="ceklis_pekerjaan">
                        <label for="ceklis_pekerjaan">Berhubungan dengan pekerjaan ? </label>
                    </div>
                </div>
                <div class="row row_pekerjaan" style="display: none;">
                    <div class="mb-3 col-12">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text text-theme border-end-0"><i class="bi bi-house"></i></span>
                                <div class="form-floating bg-white">
                                    <select name="project" id="id_project" class="mb-2 mt-4-5 w-90 border-0" style="display: none;">
                                        <option value="" disabled selected>- Pilih Divisi -</option>
                                        <?php foreach ($project as $item) : ?>
                                            <option value="<?= $item->id_project ?>"><?= $item->project ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label class="form-label-custom required small" for="id_pic">Divisi</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-6">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text text-theme border-end-0"><i class="bi bi-circle-fill"></i></span>
                                <div class="form-floating bg-white">
                                    <select name="pekerjaan" id="id_pekerjaan" class="mb-2 mt-4-5 w-90 border-0" style="display: none;">
                                    </select>
                                    <label class="form-label-custom required small" for="id_pic">SO</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-6">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text text-theme border-end-0"><i class="bi bi-circle"></i></span>
                                <div class="form-floating bg-white">
                                    <select name="sub_pekerjaan" id="id_sub_pekerjaan" class="mb-2 mt-4-5 w-90 border-0" style="display: none;">
                                    </select>
                                    <label class="form-label-custom required small" for="id_pic">SI</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-6">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text text-theme border-end-0"><i class="bi bi-dash-circle"></i></span>
                                <div class="form-floating bg-white">
                                    <select name="detail_pekerjaan" id="id_detail_pekerjaan" class="mb-2 mt-4-5 w-90 border-0" style="display: none;" multiple>
                                    </select>
                                    <label class="form-label-custom required small" for="id_pic">Tasklist</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="m-1 btn btn-link" data-bs-dismiss="modal">Close</button>
                <!-- <button type="button" class="m-1 btn btn-theme" onclick="save_task()">Save</button> -->
                <button type="button" class="m-1 btn btn-theme" onclick="save_task()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sub Task -->
<div class="modal fade" id="modal_sub_task" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modal_sub_taskLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light text-theme rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal-list-waiting-resignationLabel">Strategy</h6>
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
                <!-- <div class="card">
                    <div class="card-body">
                        <div class="col-12 text-end mb-2">
                            <button class="btn btn-theme text-white" onclick="modal_add_sub_task()"> Add Strategy Task</button>
                        </div>
                        <div class="table-responsive">
                            <table id="dt_sub_task" class="table table-bordered table-striped" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap th-goals">Strategy</th>
                                        <th class="text-nowrap">Type</th>
                                        <th class="text-nowrap">Periode</th>
                                        <th class="text-nowrap">File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> -->


                <div class="card mt-1 mb-1">
                    <div class="card-body">
                        <div class="col-12 text-end">
                            <button class="btn btn-theme text-white" data-bs-toggle="collapse" data-bs-target="#collapse_form_strategy" aria-expanded="false" aria-controls="collapse_form_strategy"> Add Strategy</button>
                        </div>
                        <div class="collapse mt-2" id="collapse_form_strategy">
                            <div class="card card-body">
                                <form id="form-add-sub-task">
                                    <div class="row text-start">
                                    <div class="col-12 col-md-4">
                                            <div class="mb-3">
                                                <label class="small text-secondary" for="id_mom_text">ID MOM</label>
                                                <input type="text" id="id_mom_text" class="form-control" name="id_mom_text" readonly>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <div class="mb-3">
                                                <label class="small text-secondary" for="sub_task">Strategy</label>
                                                <input type="text" name="sub_task" id="sub_task" class="form-control">
                                                <input type="hidden" name="id_mom" id="id_mom" class="form-control">
                                                <input type="hidden" name="id_task" id="id_task" class="form-control" readonly>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-md-12">
                                            <div class="col-4 col-md-12">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="flexSwitcIndicator1" name="sub_type_indicator" value="1" style="cursor: pointer;">
                                                    <label class="form-check-label" for="flexSwitcIndicator1" style="cursor: pointer;">Indicator</label>
                                                </div>
                                            </div>
                                            <div class="d-none" id="div_indicator">
                                                <div class="mb-3">
                                                    <label class="small text-secondary" for="indicator">Indicator</label>
                                                    <textarea name="sub_indicator" id="sub_indicator" cols="30" rows="5"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12">
                                            <div class="mb-3">
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <label class="small text-secondary">Type</label><br>
                                                        <div class="row col-12 mt-2 mb-2">
                                                            <div class="col-4 col-md-12">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" id="flexSwitc1" name="sub_type_check" value="1" style="cursor: pointer;">
                                                                    <label class="form-check-label" for="flexSwitc1" style="cursor: pointer;">Daily</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 col-md-12">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" id="flexSwitc2" name="sub_type_check" value="2" style="cursor: pointer;">
                                                                    <label class="form-check-label" for="flexSwitc2" style="cursor: pointer;">Weekly</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 col-md-12">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" id="flexSwitc3" name="sub_type_check" value="3" style="cursor: pointer;">
                                                                    <label class="form-check-label" for="flexSwitc3" style="cursor: pointer;">Monthly</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="sub_type" id="sub_type" readonly>
                                                        <input type="hidden" name="sub_day" id="sub_day" readonly>
                                                        <input type="hidden" name="jml_sub_day" id="jml_sub_day" readonly>
                                                    </div>
                                                    <div class="col-12 col-md-6 d-none" id="choose_day_of_weeks">
                                                        <label class="small text-secondary">Choose Day of Weeks</label><br>
                                                        <div class="row col-12 mt-2 mb-2">
                                                            <div class="col-6">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" id="flexSwitcDay1" name="sub_type_day" value="0" style="cursor: pointer;">
                                                                    <label class="form-check-label" for="flexSwitcDay1" style="cursor: pointer;">Monday</label>
                                                                </div>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" id="flexSwitcDay2" name="sub_type_day" value="1" style="cursor: pointer;">
                                                                    <label class="form-check-label" for="flexSwitcDay2" style="cursor: pointer;">Tuesday</label>
                                                                </div>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" id="flexSwitcDay3" name="sub_type_day" value="2" style="cursor: pointer;">
                                                                    <label class="form-check-label" for="flexSwitcDay3" style="cursor: pointer;">Wednesday</label>
                                                                </div>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" id="flexSwitcDay4" name="sub_type_day" value="3" style="cursor: pointer;">
                                                                    <label class="form-check-label" for="flexSwitcDay4" style="cursor: pointer;">Thrusday</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" id="flexSwitcDay5" name="sub_type_day" value="4" style="cursor: pointer;">
                                                                    <label class="form-check-label" for="flexSwitcDay5" style="cursor: pointer;">Friday</label>
                                                                </div>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" id="flexSwitcDay6" name="sub_type_day" value="5" style="cursor: pointer;">
                                                                    <label class="form-check-label" for="flexSwitcDay6" style="cursor: pointer;">Saturday</label>
                                                                </div>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" id="flexSwitcDay7" name="sub_type_day" value="6" style="cursor: pointer;">
                                                                    <label class="form-check-label" for="flexSwitcDay7" style="cursor: pointer;">Sunday</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="mb-3">
                                                <label class="small text-secondary" for="">Start Date</label>
                                                <input type="text" name="start_date" id="start_date" onchange="set_min_date()" class="form-control tanggal" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="mb-3">
                                                <label class="small text-secondary" for="">End Date</label>
                                                <input type="text" name="end_date" id="end_date" class="form-control tanggal" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="mb-3">
                                                <label class="small text-secondary" for="">Notification Hour</label>
                                                <select name="jam_notif" id="jam_notif" class="form-control">
                                                    <option value="">Choose Hour</option>
                                                    <?php
                                                for ($hour = 0; $hour < 24; $hour++) {
                                                    for ($minute = 0; $minute < 60; $minute += 15) {
                                                        $time = sprintf("%02d:%02d", $hour, $minute);
                                                        echo "<option value=\"$time\">$time WIB</option>";
                                                    }
                                                }
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 d-none">
                                            <div class="mb-3">
                                                <label class="small text-secondary" for="">File</label>
                                                <input type="file" name="file_sub" id="file_sub" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12">
                                            <div class="mb-3">
                                                <label class="small text-secondary" for="sub_note">Note</label>
                                                <textarea name="sub_note" id="sub_note" class="form-control" cols="30" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 text-end">
                                            <button type="button" class="btn btn-theme text-white m-1" onclick="save_add_sub_task()">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12" id="dt_sub_task_card">

                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-link m-1" onclick="close_sub_task()">Close</button> -->
                <button type="button" class="btn btn-theme text-white m-1" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Sub Task -->
<div class="modal fade" id="modal_add_sub_task" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modal_add_sub_taskLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light text-theme rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal-list-waiting-resignationLabel">Add Strategy</h6>
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
                <div class="card">
                    <div class="card-body">
                        <!-- <form id="form-add-sub-task">
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="mb-3">
                                        <label class="small text-secondary" for="sub_task">Strategy</label>
                                        <input type="text" name="sub_task" id="sub_task" class="form-control">
                                        <input type="hidden" name="id_task" id="id_task" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="mb-3">
                                        <label class="small text-secondary">Type</label><br>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="inlineCheckbox1" style="cursor: pointer;">Daily</label>
                                            <input type="checkbox" class="radio form-check-input" value="1" name="sub_type_check" checked id="inlineCheckbox1" />
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="inlineCheckbox2" style="cursor: pointer;">Weekly</label>
                                            <input type="checkbox" class="radio form-check-input" value="2" name="sub_type_check" id="inlineCheckbox2" />
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="inlineCheckbox3" style="cursor: pointer;">Montly</label>
                                            <input type="checkbox" class="radio form-check-input" value="3" name="sub_type_check" id="inlineCheckbox3" />
                                        </div>
                                        <div class="form-check form-check-inline d-none">
                                            <label class="form-check-label" for="inlineCheckbox4" style="cursor: pointer;">Twice</label>
                                            <input type="checkbox" class="radio form-check-input" value="4" name="sub_type_check" id="inlineCheckbox4" />
                                        </div>
                                        <input type="hidden" name="sub_type" id="sub_type" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="small text-secondary" for="">Start Date</label>
                                        <input type="text" name="start_date" id="start_date" onchange="set_min_date()" class="form-control tanggal">
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="small text-secondary" for="">End Date</label>
                                        <input type="text" name="end_date" id="end_date" class="form-control tanggal">
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="small text-secondary" for="">Notification Hour</label>
                                        <select name="jam_notif" id="jam_notif" class="form-control">
                                            <option value="05:00">05:00 WIB</option>
                                            <option value="06:00">06:00 WIB</option>
                                            <option value="07:00">07:00 WIB</option>
                                            <option value="08:00">08:00 WIB</option>
                                            <option value="09:00">09:00 WIB</option>
                                            <option value="10:00">10:00 WIB</option>
                                            <option value="11:00">11:00 WIB</option>
                                            <option value="12:00">12:00 WIB</option>
                                            <option value="13:00">13:00 WIB</option>
                                            <option value="14:00">14:00 WIB</option>
                                            <option value="15:00">15:00 WIB</option>
                                            <option value="16:00">16:00 WIB</option>
                                            <option value="17:00">17:00 WIB</option>
                                            <option value="18:00">18:00 WIB</option>
                                            <option value="19:00">19:00 WIB</option>
                                            <option value="20:00">20:00 WIB</option>
                                            <option value="21:00">21:00 WIB</option>
                                            <option value="22:00">22:00 WIB</option>
                                            <option value="23:00">23:00 WIB</option>
                                            <option value="24:00">24:00 WIB</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 d-none">
                                    <div class="mb-3">
                                        <label class="small text-secondary" for="">File</label>
                                        <input type="file" name="file_sub" id="file_sub" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="mb-3">
                                        <label class="small text-secondary" for="sub_note">Note</label>
                                        <textarea name="sub_note" id="sub_note" class="form-control" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form> -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link m-1" onclick="close_add_sub_task()">Close</button>
                <button type="button" class="btn btn-theme text-white m-1" onclick="save_add_sub_task()">Save</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal Add Type -->
<div class="modal fade" id="modal_add_type" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modal_add_typeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_add_typeLabel">Add Group</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col">
                    <label for="type_name">Group Name</label>
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
<div class="modal fade" id="modal_add_category" tabindex="-1" aria-labelledby="modal_add_categoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_add_categoryLabel">Add Category</h5>
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
<div class="modal fade" id="modal_add_object" tabindex="-1" aria-labelledby="modal_add_objectLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_add_objectLabel">Add Object</h5>
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
<div class="modal fade" id="modal_detail_task" tabindex="-1" aria-labelledby="modal_detail_taskLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_detail_taskLabel">Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php $this->load->view('monday/details/page'); ?>
                    <?php $this->load->view('kanban/details/page'); ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link m-1" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal New Task -->
<div class="modal fade" id="modal_list_verif" tabindex="-1" aria-labelledby="modal_add_taskLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal-list-waiting-resignationLabel">List Verifikasi Task</h6>
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
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless" id="list_verif">
                                <thead>
                                    <tr>
                                        <th>Goals</th>
                                        <th>Jenis</th>
                                        <th>Strategy</th>
                                        <th>PIC</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Progres</th>
                                        <th>Evaluation</th>
                                        <th>Created by</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="m-1 btn btn-link" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>