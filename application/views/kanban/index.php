<main class="main mainheight">

    <!-- <div class="container-fluid">

        <div class="row align-items-center page-title">
            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modal_detail_task" id="detail_task_btn"
                hidden></a>

            <div class="col-12 col-md mb-2 mb-sm-0">
                <div class="card">
                    <div class="card-header">

                        <div class="row mb-4 py-2">
                            <div class="col text-center">
                                <h4>Don't let poor communication <span class="text-gradient">manipulate progress</span>,
                                    while you can track it better</h4>
                                <p class="text-secondary">Manage task an update status. Add comment and assign tester.
                                    Get approval after complete release. Move ahead.</p>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col">
                                <div class="float-end">
                                    <div class="progress h-30 my-3">
                                        <div class="progress-bar bg-blue w-110" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        <div class="progress-bar bg-yellow w-80px" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                        <div class="progress-bar bg-red w-10" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                        <div class="progress-bar bg-light-blue w-10" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        

                    </div>
                </div>
            </div>

        </div>
    </div> -->

    <?php $this->load->view('monday/header') ?>

    <div class="container-fluid">
        <div class="row wrapper">

            <!-- NOT STARTED CARD -->
            <div class="col-12 col-md-4 col-lg-3 mb-3">
                <div class="card kanban-card">
                    <div class="card-header kanban-header kanban-header-not-started">

                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="">Not Started / <span id="kanban_status_count_not_started">0</span></h6>
                            </div>
                            <div class="col-auto">
                                <div class="dropdown d-inline-block">
                                    <a class="btn btn-sqaure btn-link text-secondary dd-arrow-none dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static"
                                        role="button">
                                        <i class="bi bi-three-dots-vertical text-white"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="javascript:void(0)">Edit</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:void(0)">Move</a>
                                        </li>
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)">Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body kanban-body" id="not_started_column">

                    </div>
                </div>
            </div>
            <!-- NOT STARTED CARD -->

            <!-- WORKING ON CARD -->
            <div class="col-12 col-md-4 col-lg-3 mb-3">
                <div class="card kanban-card">
                    <div class="card-header kanban-header kanban-header-working-on">

                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="">Working On / <span id="kanban_status_count_working_on">0</span></h6>
                            </div>
                            <div class="col-auto">
                                <div class="dropdown d-inline-block">
                                    <a class="btn btn-sqaure btn-link text-secondary dd-arrow-none dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static"
                                        role="button">
                                        <i class="bi bi-three-dots-vertical text-white"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="javascript:void(0)">Edit</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:void(0)">Move</a>
                                        </li>
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)">Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body kanban-body" id="working_on_column">


                    </div>
                </div>
            </div>
            <!-- WORKING ON CARD -->

            <!-- DONE CARD -->
            <div class="col-12 col-md-4 col-lg-3 mb-3">
                <div class="card kanban-card">
                    <div class="card-header kanban-header kanban-header-done">

                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="">Done / <span id="kanban_status_count_done">0</span></h6>
                            </div>
                            <div class="col-auto">
                                <div class="dropdown d-inline-block">
                                    <a class="btn btn-sqaure btn-link text-secondary dd-arrow-none dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static"
                                        role="button">
                                        <i class="bi bi-three-dots-vertical text-white"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="javascript:void(0)">Edit</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:void(0)">Move</a>
                                        </li>
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)">Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body kanban-body" id="done_column">

                    </div>
                </div>
            </div>
            <!-- DONE CARD -->

            <!-- STUCK CARD -->
            <div class="col-12 col-md-4 col-lg-3 mb-3">

                <div class="card kanban-card">
                    <div class="card-header kanban-header kanban-header-stuck">

                        <div class="row align-items-center">

                            <div class="col">
                                <h6 class="">Stuck / <span id="kanban_status_count_stuck">0</span></h6>
                            </div>
                            <div class="col-auto">
                                <div class="dropdown d-inline-block">
                                    <a class="btn btn-sqaure btn-link text-secondary dd-arrow-none dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static"
                                        role="button">
                                        <i class="bi bi-three-dots-vertical text-white"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="javascript:void(0)">Edit</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:void(0)">Move</a>
                                        </li>
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)">Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body kanban-body" id="stuck_column">


                    </div>
                </div>

            </div>
            <!-- DONE CARD -->

        </div>
    </div>


    <!-- Footer -->
    <div class="container-fluid footer-page mt-4 py-5">

    </div>
</main>


<!-- Modal Detail Task -->
<div class="modal fade" id="modal_detail_task" tabindex="-1" aria-labelledby="modal_detail_taskLabel"
    aria-hidden="true">
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
                <!-- <button type="button" class="btn btn-link m-1" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-link btn-monday m-1" onclick="save_object()">Save</button> -->
            </div>
        </div>
    </div>
</div>



<?php $this->load->view('monday/details/detail_page'); ?>