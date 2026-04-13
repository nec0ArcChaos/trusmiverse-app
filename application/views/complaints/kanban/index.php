<style>
    .description_task p {
        --bs-text-opacity: 1;
        color: rgba(var(--bs-secondary-rgb), var(--bs-text-opacity)) !important;
        font-size: 0.875em !important;
    }

    .bg-light-grey {
        background-color: rgba(196, 196, 196, 1) !important;
    }

    .bg-light-grey i,
    .bg-light-blue .icon {
        color: #c4c4c4;
    }

    .text-grey {
        color: #c4c4c4 !important;
    }

    /* The heart of the matter */
    .kanban-group>.row {
        overflow-x: auto;
        white-space: nowrap;
    }

    .kanban-group>.row>.col-xs-4 {
        display: inline-block;
        float: none;
    }
</style>

<div class="container-fluid">

    <div class="row flex-nowrap overflow-auto">

        <div class="col-lg-4 col-md-4 col-10 mb-3 bg-light-yellow">
            <div class="card border-0 mt-3 mb-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="avatar avatar-40 bg-light-yellow text-yellow rounded">
                                <i class="bi bi-list-task h5"></i>
                            </div>
                        </div>
                        <div class="col">
                            <h6 class="fw-medium mb-0 badge bg-light-yellow text-yellow">Waiting</h6>
                            <p class="text-secondary small">Menunggu Verifikasi</p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="todocolumn" class="dragzonecard">
                <div class="card border-0 mb-2" id="todocolumnone">
                    <div class="card-body">
                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <p class="text-secondary small">10:45 am | 3 hrs</p>
                                <h6>Signup Payment</h6>
                                <p class="text-secondary small mb-2">Create Sign up flow with payment scheduling. Must have bank details.</p>
                                <span class="btn btn-sm btn-link bg-light-red text-red">UIUX</span>
                                <span class="btn btn-sm btn-link bg-light-green text-green">Prototype</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <div class="avatar avatar-30 coverimg rounded-circle me-1" data-bs-toggle="tooltip" style="background-image: url(&quot;assets/img/user-2.jpg&quot;);">
                                    <img src="assets/img/user-2.jpg" alt="" style="display: none;">
                                </div>
                                <div class="avatar avatar-30 coverimg rounded-circle me-1" data-bs-toggle="tooltip" style="background-image: url(&quot;assets/img/user-3.jpg&quot;);">
                                    <img src="assets/img/user-3.jpg" alt="" style="display: none;">
                                </div>
                                <div class="avatar avatar-30 bg-light-theme rounded-circle me-1">
                                    <p class="small">2+</p>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-paperclip avatar avatar-36 bg-light-gray rounded"></i>
                                <i class="bi bi-chat-right-dots avatar avatar-36 bg-light-gray rounded"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 mb-2">
                    <div class="card-body">
                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <p class="text-secondary small">9:30 am | 5 hrs</p>
                                <h6>Searchbar Header</h6>
                                <p class="text-secondary small mb-2">Get the tabbed categories result and clubbed result in main tab.</p>
                                <div class="coverimg rounded h-110 overflow-hidden mb-2" style="background-image: url(&quot;assets/img/tour-guide-2.png&quot;);">
                                    <img src="assets/img/tour-guide-2.png" class="w-100" alt="" style="display: none;">
                                </div>
                                <span class="btn btn-sm btn-link bg-light-blue">Code</span>
                                <span class="btn btn-sm btn-link bg-light-pink text-pink">Development</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <div class="avatar avatar-30 coverimg rounded-circle me-1" data-bs-toggle="tooltip" style="background-image: url(&quot;assets/img/user-2.jpg&quot;);">
                                    <img src="assets/img/user-2.jpg" alt="" style="display: none;">
                                </div>
                                <div class="avatar avatar-30 coverimg rounded-circle me-1" data-bs-toggle="tooltip" style="background-image: url(&quot;assets/img/user-3.jpg&quot;);">
                                    <img src="assets/img/user-3.jpg" alt="" style="display: none;">
                                </div>
                                <div class="avatar avatar-30 bg-light-theme rounded-circle me-1">
                                    <p class="small">2+</p>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-paperclip avatar avatar-36 bg-light-gray rounded"></i>
                                <i class="bi bi-chat-right-dots avatar avatar-36 bg-light-gray rounded"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- NOT STARTED CARD -->
        <div class="col-lg-4 col-md-4 col-10 mb-2">
            <div class="card kanban-card">
                <div class="card-header kanban-header kanban-header-not-started">

                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="">Waiting / <span id="kanban_status_count_not_started">0</span></h6>
                        </div>
                        <div class="col-auto">
                            <div class="dropdown d-inline-block">
                                <a class="btn btn-sqaure btn-link text-secondary dd-arrow-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
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
                <div class="card-body kanban-body" id="waiting_column">

                </div>
            </div>
        </div>
        <!-- NOT STARTED CARD -->

        <!-- WORKING ON CARD -->
        <div class="col-lg-4 col-md-4 col-10 mb-3">
            <div class="card border-0 bg-light-yellow">
                <div class="card-header bg-light-yellow">

                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="">Working On / <span id="kanban_status_count_working_on">0</span></h6>
                        </div>
                        <div class="col-auto">
                            <div class="dropdown d-inline-block">
                                <a class="btn btn-sqaure btn-link text-secondary dd-arrow-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
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
        <div class="col-lg-4 col-md-4 col-10 mb-3">
            <div class="card kanban-card">
                <div class="card-header kanban-header kanban-header-done">

                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="">Done / <span id="kanban_status_count_done">0</span></h6>
                        </div>
                        <div class="col-auto">
                            <div class="dropdown d-inline-block">
                                <a class="btn btn-sqaure btn-link text-secondary dd-arrow-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
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
        <div class="col-lg-4 col-md-4 col-10 mb-3">

            <div class="card kanban-card">
                <div class="card-header kanban-header kanban-header-stuck">

                    <div class="row align-items-center">

                        <div class="col">
                            <h6 class="">Cancel / <span id="kanban_status_count_stuck">0</span></h6>
                        </div>
                        <div class="col-auto">
                            <div class="dropdown d-inline-block">
                                <a class="btn btn-sqaure btn-link text-secondary dd-arrow-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
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