<?php $data_status = $this->db->query("SELECT id AS id_status, `status`, `color` FROM td_status")->result(); ?>

<div class="col-12 col-md-12 col-lg-6 border-end">
    <div class="row g-3 mb-3 align-items-center d-none">
        <div class="col">
            <input type="text" name="e_id_task" id="e_id_task" readonly>
        </div>
    </div>
    <div class="row g-3 mb-3 align-items-center">
        <div class="col-4">
            <label class="form-label-custom small" for="e_task"><i class="text-theme bi bi-check2-square"></i> Goals</label>
        </div>
        <div class="col-8">
            <p id="e_task_text"></p>
            <input type="text" class="form-control d-none" name="e_task" id="e_task" readonly>
        </div>
    </div>
    <!-- <div class="row g-3 mb-3 align-items-center">
        <div class="col-4">
            <label class="form-label-custom small" for="e_description"><i class="text-theme bg-white bi bi-list-columns-reverse"></i> Description</label>
        </div>
        <div class="col-8">
            <div id="e_description_div"></div>
        </div>
    </div>
    <div class="row g-3 mb-3 align-items-center">
        <div class="col-4">
            <label class="form-label-custom small" for="e_id_priority"><i class="text-theme bi bi-1-square"></i> Priority</label>
        </div>
        <div class="col-8">
            <span class="btn btn-sm btn-link" id="e_priority_text"></span>
        </div>
    </div> -->
    <div class="row g-3 mb-3 align-items-center">
        <div class="col-4">
            <label class="form-label-custom small" for="e_indicator"><i class="text-theme bi bi-speedometer2"></i> Indicator</label>
        </div>
        <div class="col-8">
            <div id="e_indicator_div"></div>
        </div>
    </div>
    <div class="row g-3 mb-3 align-items-center">
        <!-- <div class="col-4">
            <label class="form-label-custom small" for="e_strategy"><i class="text-theme bg-white bi bi-dpad"></i> Strategy</label>
        </div> -->
        <input type="hidden" id="id_task_new_strategy" readonly>
        <div class="col-12 text-end">
            <a role="button" class="btn btn-sm btn-link bg-primary text-white" onclick="add_new_strategy()">Add Strategy</a>
        </div>
        <div class="col-12">
            <table id="dt_detail_sub_task" class="table table-sm table-bordered table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th class="text-nowrap">
                            <div class="d-flex justify-content-between">
                                <div class="col" style="display: flex;align-items:center;">
                                    <i class="text-theme bi bi-dpad"></i>&nbsp;&nbsp;Strategy
                                </div>
                                <div class="col text-end">
                                    <div class="circle-small float-end">
                                        <div id="progress_goals_strategy"></div>
                                    </div>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row g-3 mb-3 align-items-center">
        <div class="col-4">
            <label class="form-label-custom small" for="strategy"><i class="text-theme bi bi-bar-chart-line"></i> Jenis Strategy</label>
        </div>
        <div class="col-8">
            <span class="btn btn-sm btn-link" id="e_jenis_strategy_text"></span>
        </div>
    </div>
    <div class="row g-3 mb-3 align-items-center">
        <div class="col-4">
            <label class="form-label-custom small" for="e_due_date"><i class="text-theme bi bi-calendar-date"></i> Due Date</label>
        </div>
        <div class="col-8">
            <div id="e_due_date_div">
            </div>
        </div>
    </div>
    <div class="row g-3 mb-3 align-items-center">
        <div class="col-4">
            <label class="form-label-custom small" for="e_id_pic"><i class="text-theme bi bi-person-fill-check"></i> PIC</label>
        </div>
        <div class="col-8">
            <span id="e_pic_text"></span>
        </div>
    </div>
    <div class="row g-3 mb-3 align-items-center">
        <div class="col-4">
            <label class="form-label-custom required small" for="e_start"><i class="text-theme bi bi-calendar-range"></i> Timeline</label>
        </div>
        <div class="col-8">
            <div class="input-group input-group-md">
                <input type="text" name="start_timeline" class="form-control border" placeholder="Start Timeline" id="start_timeline" autocomplete="off" readonly />
                <input type="text" name="end_timeline" class="form-control border" placeholder="End Timeline" id="end_timeline" autocomplete="off" readonly />
                <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-3 align-items-center">
        <div class="col-4">
            <label class="form-label-custom small required" for="e_id_status"><i class="text-theme bi bi-2-square"></i> Status</label>
        </div>
        <div class="col-8">
            <select name="e_id_status" id="e_id_status" class="wide" style="display: none;">
                <?php foreach ($data_status as $stat) { ?>
                    <option value="<?= $stat->id_status; ?>" class="bg-primary"><?= $stat->status; ?></option>
                <?php  } ?>
            </select>
            <span id="text_e_id_status"></span>
        </div>
    </div>
    <div class="row g-3 mb-3 align-items-center">
        <div class="col-4">
            <label class="form-label-custom required small" for="e_progress"><i class="text-theme bi bi-bar-chart-line"></i> Progress</label>
        </div>
        <div class="col-8">
            <div id="div_e_progress">
            </div>
            <input type="hidden" name="progress" id="e_progress" class="form-control" autocomplete="off" readonly>
        </div>
    </div>
    <div class="row g-3 mb-3 align-items-center">
        <div class="col-4">
            <label class="form-label-custom small" for="e_evaluation"><i class="text-theme bi bi-clipboard2-data"></i> Evaluasi Goals</label>
        </div>
        <div class="col-8">
            <textarea name="e_evaluation" id="e_evaluation" class="form-control" style="height: 100px;"></textarea>
        </div>
    </div>
    <div class="row g-3 mb-3 align-items-center" id="div_e_note">
        <div class="col-4">
            <label class="form-label-custom small" for="e_note"><i class="text-theme bi bi-card-heading"></i> Note Update</label>
        </div>
        <div class="col-8">
            <textarea name="e_note" id="e_note" class="form-control" style="height: 100px;"></textarea>
        </div>
    </div>
    <div class="row g-3 mb-3 align-items-center">
        <div class="col text-end">
            <button type="button" class="btn btn-link btn-monday m-1" onclick="update_task()">Update</button>
        </div>
    </div>
</div>