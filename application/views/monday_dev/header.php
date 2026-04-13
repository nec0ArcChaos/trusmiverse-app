<div class="container-fluid">
    <div class="row align-items-center page-title">

    </div>
    <div class="row">
        <nav aria-label="breadcrumb" class="breadcrumb-theme">
            <div class="col text-center">
                <h4>IBR Pro - Don't let poor communication <span class="text-gradient">manipulate progress</span>, while you can track it better</h4>
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
                <div class="card-body bg-light-white">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="avatar avatar-40 rounded bg-light-cyan">
                                <i class="bi bi-check-all h5"></i>
                            </div>
                        </div>
                        <div class="col">
                            <?php
                            $user_id = $this->session->userdata('user_id');
                            $not_started = $this->db->query("SELECT ROUND(( SUM(IF(`status`=1,1,0)) / COUNT(id_task) ) * 100,1) AS persen FROM `td_task` WHERE FIND_IN_SET('$user_id', td_task.pic) OR td_task.created_by = '$user_id'")->row(); ?>
                            <p class="small text-secondary mb-1">Not Started</p>
                            <h6 class="fw-medium mb-0"><?= $not_started->persen; ?>%</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-4 col-xl column-set mb-4">
            <div class="card border-0">
                <div class="card-body bg-light-yellow">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="avatar avatar-40 rounded bg-light-yellow">
                                <i class="bi bi-clock h5"></i>
                            </div>
                        </div>
                        <div class="col">
                            <?php
                            $working_on = $this->db->query("SELECT ROUND(( SUM(IF(`status`=2,1,0)) / COUNT(id_task) ) * 100,1) AS persen FROM `td_task` WHERE FIND_IN_SET('$user_id', td_task.pic) OR td_task.created_by = '$user_id'")->row(); ?>
                            <p class="small text-secondary mb-1">Working On</p>
                            <h6 class="fw-medium mb-0"><?= $working_on->persen; ?>%</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-4 col-xl column-set mb-4">
            <div class="card border-0">
                <div class="card-body bg-light-green">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="avatar avatar-40 rounded bg-light-green">
                                <i class="bi bi-people h5"></i>
                            </div>
                        </div>
                        <div class="col">
                            <?php $done = $this->db->query("SELECT ROUND(( SUM(IF(`status`=3,1,0)) / COUNT(id_task) ) * 100,1) AS persen FROM `td_task` WHERE FIND_IN_SET('$user_id', td_task.pic) OR td_task.created_by = '$user_id'")->row(); ?>
                            <p class="small text-secondary mb-1">Done</p>
                            <h6 class="fw-medium mb-0"><?= $done->persen; ?>%</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-4 col-xl column-set mb-4">
            <div class="card border-0">
                <div class="card-body bg-light-red">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="avatar avatar-40 rounded bg-light-red">
                                <i class="bi bi-journal-check h5"></i>
                            </div>
                        </div>
                        <div class="col">
                            <?php $stuck = $this->db->query("SELECT ROUND(( SUM(IF(`status`=4,1,0)) / COUNT(id_task) ) * 100,1) AS persen FROM `td_task` WHERE FIND_IN_SET('$user_id', td_task.pic) OR td_task.created_by = '$user_id'")->row(); ?>
                            <p class="small text-secondary mb-1">Stuck</p>
                            <h6 class="fw-medium mb-0"><?= $stuck->persen; ?>%</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-4 col-xl column-set mb-4">
            <div class="card border-0">
                <div class="card-body bg-light-blue">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="avatar avatar-40 rounded bg-light-blue">
                                <i class="bi bi-journal-check h5"></i>
                            </div>
                        </div>
                        <div class="col">
                            <?php $total_task = $this->db->query("SELECT COUNT(id_task) jml_task FROM `td_task` WHERE FIND_IN_SET('$user_id', td_task.pic) OR td_task.created_by = '$user_id'")->row(); ?>
                            <p class="small text-secondary mb-1">Total</p>
                            <h6 class="fw-medium mb-0"><?= $total_task->jml_task; ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12 col-xl-12 mb-4">
            <div class="card border-0 h-100">
                <nav aria-label="breadcrumb" class="breadcrumb-theme bg-white">
                    <ol class="breadcrumb">
                        <li class="p-2 monday-hover">
                            <a href="#" class="monday-item btn btn-link btn-sm" onclick="add_new_task()"><i class="bi bi-plus"></i> New Task</a>
                        </li>
                        <li class="p-2">
                            <a href="<?= base_url(); ?>monday" class="monday-item btn btn-link btn-sm"><i class="bi bi-table"></i> Table</a>
                        </li>
                        <li class="p-2">
                            <a href="<?= base_url(); ?>kanban" class="monday-item btn btn-link btn-sm"><i class="bi bi-kanban"></i> Kanban</a>
                        </li>
                        <!-- <li class="monday-breadcrumb-item p-2 active dropdown" aria-current="page">
                                <a class="monday-item text-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Visualize
                                </a>
                                <ul class="dropdown-menu animate slideIn mt-lg-4" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <div class="d-flex justify-content-around">
                                            <span class="small text-secondary">Board Views</span>
                                            <a role="button"><i class="bi bi-info-circle" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Visualize Data"></i></a>
                                        </div>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="<?= base_url(); ?>monday"><i class="bi bi-table"></i> Table</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url(); ?>kanban"><i class="bi bi-kanban"></i> Kanban</a></li>
                                </ul>
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
    </div>
</div>