<div class="container-fluid">
    <div class="row align-items-center page-title">

    </div>
    <div class="row">
        <nav aria-label="breadcrumb" class="breadcrumb-theme">
            <div class="col text-center">
                <h4><span class="text-gradient"><?= $pageTitle; ?></span> - Ensure every concern <span class="text-gradient">effectively</span>, through transparent tracking.</h4>
                <p class="text-secondary">Manage customer complaints effectively, offer insights, assessments and evaluations. Resolve complaints swiftly and stay on track.</p>
            </div>
        </nav>
    </div>
</div>
<div class="container-fluid mt-4">
    <!-- summary -->
    <div class="row">

        <div class="col-12 col-md-5 column-set mb-4">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-exclamation-diamond h5 avatar avatar-40 bg-light-pink text-pink rounded"></i>
                        </div>
                        <div class="col-auto ps-0">
                            <div class="row gx-0">
                                <div class="col">
                                    <p class="small text-secondary">Verification</p>
                                </div>
                                <div class="col-auto">
                                    <p class="small text-green"></p>
                                </div>
                            </div>
                            <p id="header_total_verification"></p>
                        </div>
                        <div class="col-4 ms-auto">
                            <div class="smallchart40">
                                <canvas id="barchartpink2" width="128" height="40" style="display: block; box-sizing: border-box; height: 40px; width: 128px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col">
                            <p class="text-secondary small mb-1">Waiting</p>
                            <p class="text-yellow" id="header_waiting">-</p>
                        </div>
                        <div class="col border-left-dashed">
                            <p class="text-secondary small mb-1">Verified</p>
                            <p class="text-success" id="header_verified">-</p>
                        </div>
                        <div class="col border-left-dashed">
                            <p class="text-secondary small mb-1">Reject</p>
                            <p class="text-danger" id="header_reject">-</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-7 column-set mb-4">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-calendar4-week h5 avatar avatar-40 bg-light-green text-green rounded"></i>
                        </div>
                        <div class="col-auto ps-0">
                            <div class="row gx-0">
                                <div class="col">
                                    <p class="small text-secondary">Escalation</p>
                                </div>
                                <div class="col-auto">
                                    <p class="small text-green"></p>
                                </div>
                            </div>
                            <p id="header_total_escalation"></p>
                        </div>
                        <div class="col-4 ms-auto">
                            <div class="smallchart40">
                                <canvas id="barchartblue2" width="128" height="40" style="display: block; box-sizing: border-box; height: 40px; width: 128px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col">
                            <p class="text-secondary small mb-1">Waiting</p>
                            <p class="text-warning" id="header_waiting_2">-</p>
                        </div>
                        <div class="col">
                            <p class="text-secondary small mb-1">Working On</p>
                            <p class="text-warning" id="header_working_on">-</p>
                        </div>
                        <div class="col border-left-dashed">
                            <p class="text-secondary small mb-1">Reject</p>
                            <p class="text-danger" id="header_reject_2">-</p>
                        </div>
                        <div class="col border-left-dashed">
                            <p class="text-secondary small mb-1">Done</p>
                            <p class="text-success" id="header_done">-</p>
                        </div>
                        <div class="col border-left-dashed">
                            <p class="text-secondary small mb-1">Unsolved</p>
                            <p class="text-secondary" id="header_unsolved">-</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card border-0 h-100">
                <nav aria-label="breadcrumb" class="breadcrumb-theme bg-white">
                    <ol class="breadcrumb">
                        <li class="p-2 monday-hover">
                            <a href="#" class="monday-item btn btn-link btn-sm" onclick="add_new_task()"><i class="bi bi-plus"></i> New Complaints</a>
                        </li>
                        <li class="p-2">
                            <a href="<?= base_url(); ?>complaints/main/view/table" class="monday-item btn btn-link btn-sm"><i class="bi bi-table"></i> Table</a>
                        </li>
                        <!-- <li class="p-2">
                            <a href="<?= base_url(); ?>complaints/main/view/kanban" class="monday-item btn btn-link btn-sm"><i class="bi bi-kanban"></i> Kanban</a>
                        </li> -->
                        <li class="col text-end">
                            <div class="float-end">
                                <div class="input-group input-group-md reportrange">
                                    <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="rangeCalendar">
                                    <input type="hidden" name="start" value="" id="start" />
                                    <input type="hidden" name="end" value="" id="end" />
                                    <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-12 col-md-8">
            <div class="my-3">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="ui form">
                            <div class="field">
                                <select name="filter_category" id="filter_category" class="ui search dropdown">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="ui form">
                            <div class="field">
                                <select name="filter_pic" id="filter_pic" class="ui search dropdown">
                                    <option value="all">All Tickets</option>
                                    <option value="<?= $this->session->userdata('user_id'); ?>" selected>My Tickets</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="progress h-30 my-3">
                <div class="progress-bar bg-yellow" id="progres_bar_waiting" style="width:20%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-orange" id="progres_bar_verified" style="width:20%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-red" id="progres_bar_reject" style="width:20%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-blue" id="progres_bar_working_on" style="width:20%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-green" id="progres_bar_done" style="width:20%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-secondary" id="progres_bar_unsolved" style="width:20%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
</div>