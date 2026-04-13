<div class="container-fluid">
    <div class="row align-items-center page-title">

    </div>
    <div class="row">
        <nav aria-label="breadcrumb" class="breadcrumb-theme">
            <div class="col text-center">
                <h4><span class="text-gradient"><?= $pageTitle; ?></span> - Don't let poor communication <span class="text-gradient">manipulate progress</span>, while you can track it better</h4>
                <p class="text-secondary">Manage tasks and status updates. Add comments and set evaluations. then release it completely. Keep forward.</p>
            </div>
        </nav>
    </div>
</div>
<div class="container-fluid mt-4">
    <!-- summary -->
    <div class="row">
        <div class="col-12 col-md-12 col-lg-4 col-xl column-set mb-4">
            <div class="card border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="avatar avatar-40 rounded bg-secondary text-white">
                                <i class="bi bi-people h5"></i>
                            </div>
                        </div>
                        <div class="col">
                            <p class="small text-secondary mb-1">Team Member</p>
                            <h6 class="fw-medium mb-0" id="total_team_solver"></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-4 col-xl column-set mb-4">
            <div class="card border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="avatar avatar-40 rounded bg-yellow text-white">
                                <i class="bi bi-clock h5"></i>
                            </div>
                        </div>
                        <div class="col">
                            <p class="small text-secondary mb-1">Task in Progress</p>
                            <h6 class="fw-medium mb-0" id="task_in_progress"></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-4 col-xl column-set mb-4">
            <div class="card border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="avatar avatar-40 rounded bg-green text-white">
                                <i class="bi bi-check2-square h5"></i>
                            </div>
                        </div>
                        <div class="col">
                            <p class="small text-secondary mb-1">Done</p>
                            <h6 class="fw-medium mb-0" id="total_done"></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-4 col-xl column-set mb-4">
            <div class="card border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="avatar avatar-40 rounded bg-red text-white">
                                <i class="bi bi-clock h5"></i>
                            </div>
                        </div>
                        <div class="col">
                            <p class="small text-secondary mb-1">Late</p>
                            <h6 class="fw-medium mb-0" id="total_late"></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-4 col-xl column-set mb-4">
            <div class="card border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="avatar avatar-40 rounded bg-blue text-white">
                                <i class="bi bi-journal-check h5"></i>
                            </div>
                        </div>
                        <div class="col">
                            <p class="small text-secondary mb-1">Total Tasks</p>
                            <h6 class="fw-medium mb-0" id="total_task_card"></h6>
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
                            <a href="#" class="monday-item btn btn-link btn-sm" onclick="add_new_task()"><i class="bi bi-plus"></i> New Ticket</a>
                        </li>
                        <li class="p-2">
                            <a href="<?= base_url(); ?>tickets/main/view/table" class="monday-item btn btn-link btn-sm"><i class="bi bi-table"></i> Table</a>
                        </li>
                        <li class="p-2">
                            <a href="<?= base_url(); ?>tickets/main/view/kanban" class="monday-item btn btn-link btn-sm"><i class="bi bi-kanban"></i> Kanban</a>
                        </li>
                        <li class="p-2">
                            <a href="<?= base_url(); ?>tickets/main/view/gantt" class="monday-item btn btn-link btn-sm"><i class="bi bi-kanban"></i> Gantt Chart</a>
                        </li>
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
        <div class="col-md-9 col-12">
            <div class="my-3">
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="ui form">
                            <div class="field">
                                <select name="filter_type" id="filter_type" class="ui search dropdown">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="ui form">
                            <div class="field">
                                <select name="filter_pic" id="filter_pic" class="ui search dropdown">
                                    <option value="all">All Tickets</option>
                                    <option value="<?= $this->session->userdata('user_id'); ?>" selected>My Tickets</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="ui form">
                            <div class="field">
                                <select name="filter_status" id="filter_status" class="ui search dropdown" multiple="">
                                    <option value="all">All Status</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="progress h-30 my-3">
                <div class="progress-bar bg-secondary" id="progres_bar_not_started" style="width:25%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-yellow" id="progres_bar_working_on" style="width:25%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-green" id="progres_bar_done" style="width:25%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-red" id="progres_bar_stuck" style="width:25%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
</div>