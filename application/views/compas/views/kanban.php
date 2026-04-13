<!-- Event Activation Kanban -->
<div class="row wrapper">
    <!-- Waiting Column -->
    <div class="col-12 col-md-4 col-lg-4 mb-3">
        <div class="row align-items-center mb-3">
            <div class="col-auto">
                <div class="avatar avatar-40 bg-warning text-white rounded">
                    <i class="bi bi-hourglass-split h5"></i>
                </div>
            </div>
            <div class="col">
                <h6 class="fw-medium mb-0">Waiting</h6>
                <p class="text-secondary small">New Tasks</p>
            </div>
            <div class="col-auto">
                <div class="dropdown d-inline-block">
                    <a class="btn btn-sqaure btn-link text-secondary dd-arrow-none dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
                        <i class="bi bi-three-dots-vertical"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="javascript:void(0)">Sort by Date</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0)">Sort by Status</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="waitingcolumn" class="dragzonecard">

        </div>
    </div>

    <!-- On Review Column -->
    <div class="col-12 col-md-4 col-lg-4 mb-3">
        <div class="row align-items-center mb-3">
            <div class="col-auto">
                <div class="avatar avatar-40 bg-blue text-white rounded">
                    <i class="bi bi-search h5"></i>
                </div>
            </div>
            <div class="col">
                <h6 class="fw-medium mb-0">On Review</h6>
                <p class="text-secondary small">Active review</p>
            </div>
            <div class="col-auto">
                <div class="dropdown d-inline-block">
                    <a class="btn btn-sqaure btn-link text-secondary dd-arrow-none dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
                        <i class="bi bi-three-dots-vertical"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="javascript:void(0)">Sort by Date</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0)">Sort by Status</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="onreviewcolumn" class="dragzonecard">
            <!-- Card 3 -->
            <!-- <div class="card border-0 mb-4 border-start border-4 border-primary" onclick="loadDetails(3)">
                <div class="card-body">
                    <div class="row align-items-center gx-2">
                        <div class="col">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-light-primary text-primary">Active Review</span>
                                <i class="bi bi-grip-vertical text-muted cursor-grab"></i>
                            </div>
                            <h6>Tech Conference 2024</h6>
                            <div class="text-secondary small mb-2">
                                <i class="bi bi-calendar me-1"></i> Nov 05, 2023
                            </div>
                            <div class="text-secondary small mb-2">
                                <i class="bi bi-geo-alt me-1"></i> San Francisco, CA
                            </div>
                            <div class="text-secondary small mb-3">
                                <i class="bi bi-currency-dollar me-1"></i> $45,000 Budget
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row align-items-center gx-2">
                        <div class="col">
                            <div class="d-flex align-items-center">
                                <span class="small text-muted me-2">PIC: Jordan K.</span>
                                <div class="avatar avatar-30 bg-light-purple rounded-circle text-purple fw-bold">JK
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex align-items-center text-secondary small">
                                <i class="bi bi-chat-dots me-1"></i> 12
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>

    <!-- Approved Column -->
    <div class="col-12 col-md-4 col-lg-4 mb-3">
        <div class="row align-items-center mb-3">
            <div class="col-auto">
                <div class="avatar avatar-40 bg-success text-white rounded">
                    <i class="bi bi-check-lg h5"></i>
                </div>
            </div>
            <div class="col">
                <h6 class="fw-medium mb-0">Approved</h6>
                <p class="text-secondary small">Ready for launch</p>
            </div>
            <div class="col-auto">
                <div class="dropdown d-inline-block">
                    <a class="btn btn-sqaure btn-link text-secondary dd-arrow-none dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
                        <i class="bi bi-three-dots-vertical"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="javascript:void(0)">Sort by Date</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0)">Sort by Status</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="approvedcolumn" class="dragzonecard">

        </div>
    </div>
</div>