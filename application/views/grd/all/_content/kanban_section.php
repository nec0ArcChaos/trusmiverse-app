<div class="custom-pane" id="section_kanban">
    <!-- <p>Kanban View Content Goes Here</p> -->
    <div class="kanban-container">
        <div class="row flex-nowrap wrapper mt-3">

            <!-- NOT STARTED CARD -->
            <div class="col-12 col-md-5 col-lg-4 mb-3">
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
            <div class="col-12 col-md-5 col-lg-4 mb-3">
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
            <div class="col-12 col-md-5 col-lg-4 mb-3">
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

            <!-- FEEDBACK CARD -->
            <div class="col-12 col-md-5 col-lg-4 mb-3">

                <div class="card kanban-card">
                    <div class="card-header kanban-header kanban-header-feedback">

                        <div class="row align-items-center">

                            <div class="col">
                                <h6 class="">Feedback / <span id="kanban_status_count_feedback">0</span></h6>
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
                    <div class="card-body kanban-body" id="feedback_column">


                    </div>
                </div>

            </div>
            <!-- FEEDBACK CARD -->

            <!-- REVISI CARD -->
            <div class="col-12 col-md-5 col-lg-4 mb-3">

                <div class="card kanban-card">
                    <div class="card-header kanban-header kanban-header-revisi">

                        <div class="row align-items-center">

                            <div class="col">
                                <h6 class="">Revisi / <span id="kanban_status_count_revisi">0</span></h6>
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
                    <div class="card-body kanban-body" id="revisi_column">


                    </div>
                </div>

            </div>
            <!-- REVISI CARD -->

        </div>
    </div>
</div>