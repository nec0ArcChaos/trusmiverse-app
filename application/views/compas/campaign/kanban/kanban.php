<div class="container">
    <!-- project progress list -->
    <div class="row wrapper">
        <div class="col-12 col-md-4 col-lg-3 mb-3">
            <div class="row align-items-center mb-3">
                <div class="col-auto">
                    <div class="avatar avatar-40 bg-yellow text-white rounded">
                        <i class="bi bi-megaphone h5"></i>
                    </div>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0">Draft</h6>
                    <p class="text-secondary small">Manage a campaign</p>
                </div>
                <div class="col-auto">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-sqaure btn-link text-secondary dd-arrow-none dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
                            <i class="bi bi-funnel"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="javascript:void(0)"
                                    onclick="loadDraftCampaigns(1, '')">All Priorities</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)"
                                    onclick="loadDraftCampaigns(1, 'Low')">Low</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)"
                                    onclick="loadDraftCampaigns(1, 'Medium')">Medium</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)"
                                    onclick="loadDraftCampaigns(1, 'High')">High</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)"
                                    onclick="loadDraftCampaigns(1, 'Urgent')">Urgent</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Filters -->
            <div class="input-group mb-2">
                <input type="text" id="draft_filter_title" class="form-control form-control-lg"
                    placeholder="Search Title...">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
            </div>

            <div id="draftcolumn" class="dragzonecard">
                <div id="draft_items_container"></div>

                <!-- Pagination -->
                <nav aria-label="Page navigation" class="mt-3" id="draft_pagination_container" style="display:none;">
                    <ul class="pagination pagination-sm justify-content-center mb-0" id="draft_pagination">
                    </ul>
                </nav>
            </div>
        </div>

        <div class="col-12 col-md-4 col-lg-3 mb-3">
            <div class="row align-items-center mb-3">
                <div class="col-auto">
                    <div class="avatar avatar-40 bg-blue text-white rounded">
                        <i class="bi bi-calendar-event h5"></i>
                    </div>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0">Event Activations</h6>
                    <p class="text-secondary small">Manage an event</p>
                </div>
                <div class="col-auto">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-sqaure btn-link text-secondary dd-arrow-none dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
                            <i class="bi bi-three-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="javascript:void(0)"
                                    onclick="loadActivationsCampaigns(1, '')">All Priorities</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)"
                                    onclick="loadActivationsCampaigns(1, 'Low')">Low</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)"
                                    onclick="loadActivationsCampaigns(1, 'Medium')">Medium</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)"
                                    onclick="loadActivationsCampaigns(1, 'High')">High</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)"
                                    onclick="loadActivationsCampaigns(1, 'Urgent')">Urgent</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="eventactivationcolumn" class="dragzonecard">
                <div id="activation_items_container"></div>
                <!-- Pagination -->
                <nav aria-label="Page navigation" class="mt-3" id="activation_pagination_container"
                    style="display:none;">
                    <ul class="pagination pagination-sm justify-content-center mb-0" id="activation_pagination">
                    </ul>
                </nav>
            </div>
        </div>

        <div class="col-12 col-md-4 col-lg-3 mb-3">
            <div class="row align-items-center mb-3">
                <div class="col-auto">
                    <div class="avatar avatar-40 bg-green text-white rounded">
                        <i class="bi bi-clipboard-check h5"></i>
                    </div>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0">Pre Production</h6>
                    <p class="text-secondary small">Manage pre production</p>
                </div>
                <div class="col-auto">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-sqaure btn-link text-secondary dd-arrow-none dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
                            <i class="bi bi-three-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="javascript:void(0)"
                                    onclick="loadPreProductionCampaigns(1, '')">All Priorities</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)"
                                    onclick="loadPreProductionCampaigns(1, 'Low')">Low</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)"
                                    onclick="loadPreProductionCampaigns(1, 'Medium')">Medium</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)"
                                    onclick="loadPreProductionCampaigns(1, 'High')">High</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)"
                                    onclick="loadPreProductionCampaigns(1, 'Urgent')">Urgent</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="preproductioncolumn" class="dragzonecard">
                <div id="preproduction_items_container"></div>
                <!-- Pagination -->
                <nav aria-label="Page navigation" class="mt-3" id="preproduction_pagination_container"
                    style="display:none;">
                    <ul class="pagination pagination-sm justify-content-center mb-0" id="preproduction_pagination">
                    </ul>
                </nav>
            </div>
        </div>

        <div class="col-12 col-md-4 col-lg-3 mb-3">
            <div class="row align-items-center mb-3">
                <div class="col-auto">
                    <div class="avatar avatar-40 bg-pink text-white rounded">
                        <i class="bi bi-archive h5"></i>
                    </div>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0">Archived</h6>
                    <p class="text-secondary small">Manage archived</p>
                </div>
                <div class="col-auto">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-sqaure btn-link text-secondary dd-arrow-none dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
                            <i class="bi bi-three-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="javascript:void(0)"
                                    onclick="loadArchivedCampaigns(1, '')">All Priorities</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)"
                                    onclick="loadArchivedCampaigns(1, 'Low')">Low</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)"
                                    onclick="loadArchivedCampaigns(1, 'Medium')">Medium</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)"
                                    onclick="loadArchivedCampaigns(1, 'High')">High</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)"
                                    onclick="loadArchivedCampaigns(1, 'Urgent')">Urgent</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="archivedcolumn" class="dragzonecard">
                <div id="archived_items_container"></div>
                <!-- Pagination -->
                <nav aria-label="Page navigation" class="mt-3" id="archived_pagination_container" style="display:none;">
                    <ul class="pagination pagination-sm justify-content-center mb-0" id="archived_pagination">
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>