<style>
    .description_task p {
        --bs-text-opacity: 1;
        color: rgba(var(--bs-secondary-rgb), var(--bs-text-opacity)) !important;
        font-size: 0.875em !important;
    }

    .bg-light-grey {
        background-color: rgba(196, 196, 196, 1) !important;
    }
    .bg-light-grey i, .bg-light-blue .icon {
        color: #c4c4c4;
    }

    .text-grey {
        color: #c4c4c4 !important;
    }
</style>

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
                            <h6 class="">Cancel / <span id="kanban_status_count_stuck">0</span></h6>
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