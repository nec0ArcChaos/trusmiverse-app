<!-- Empty State -->
<div class="row" id="activation-empty-state" style="display: none;">
    <div class="col-12" id="activation-empty-state">
        <div class="card rounded-4 shadow-1 border-0">
            <div class="card-body rounded-4 d-flex flex-column align-items-center justify-content-center text-center py-5"
                style="min-height: 400px;">
                <div class="rounded-circle bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center mb-3"
                    style="width: 72px; height: 72px;">
                    <i class="bi bi-calendar-event display-6 text-secondary"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Event Activation</h5>
                <p class="text-muted small mb-4" style="max-width: 320px;">
                    Manage offline events, booth setups, and on-ground activation details here.
                </p>
                <button class="btn btn-primary border-0 rounded-3 px-4 py-2 fw-bold shadow-sm small action-restricted"
                    onclick="showActivationForm()">
                    + Add Event
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Active State -->
<div class="row" id="activation-content-section" style="display: none;">

    <!-- Team Section -->

    <div class="col-12 mb-4">
        <div class="card mb-0 rounded-3">
            <div class="card-body px-4 rounded-3">
                <div class="row">
                    <div class="col-auto d-flex align-items-center">
                        <h6 class="fw-bold text-dark mb-1">Activation Team</h6>
                    </div>
                    <div class="ms-auto col-auto d-flex align-items-center">
                        <button class="btn btn-theme btn-sm rounded-1 px-3 d-flex align-items-center action-restricted"
                            data-bs-toggle="modal" data-bs-target="#inviteActivationTeamModal">
                            <i class="bi bi-plus-lg me-1"></i> Invite Team
                        </button>
                    </div>
                    <div class="col-auto ps-0 avatar-group" id="avatar-activation-team">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-8">
        <!-- Activation Tasks -->
        <div class="card rounded-4 mb-4 shadow-1 border-0">
            <div
                class="card-header rounded-4 px-4 py-3 bg-white border-bottom d-flex justify-content-between align-items-center">
                <p class="text-uppercase fw-bold mb-0">Activation Tasks</p>
                <button
                    class="btn btn-primary btn-sm rounded-pill px-3 d-flex align-items-center gap-1 action-restricted"
                    onclick="showActivationForm()">
                    <i class="bi bi-plus-lg"></i>
                    Add Task
                </button>
            </div>
            <div class="card-body rounded-4 p-2">
                <div class="table-responsive">
                    <table id="dt_activation" class="table table-bordered table-striped no-footer dataTable"
                        width="100%">
                        <thead class="bg-light text-secondary small text-uppercase fw-bold">
                            <tr>
                                <th class="ps-4" style="width: 40%">Task Name</th>
                                <th style="width: 20%" class="text-center">Assigned</th>
                                <th style="width: 20%" class="text-center">Status</th>
                                <th style="width: 20%" class="text-center">Score AI</th>
                                <th class="text-end pe-4" style="width: 20%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="activation-table-body">
                            <!-- Populated by JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="card rounded-3 p-3">
            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center py-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-chat-left-text text-primary fs-5"></i>
                    <h6 class="mb-0 fw-bold">Discussion</h6>
                </div>
            </div>
            <div class="card-body">
                <div id="comments-container-activation"></div>
            </div>
        </div>
    </div>

    <div class="col-4">

        <!-- Team Performance -->
        <div class="card rounded-3 bg-theme text-white container-performance-activation mb-4">
            <div class="card-body bg-none p-4">
                <h6 class="fw-bold mb-4 text-white text-uppercase small">Team Performance</h6>

                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="p-3 bg-white bg-opacity-10 rounded-3 text-center">
                            <h2 class="fw-bold mb-0" id="team_efficiency_activation">0%</h2>
                            <small class="xx-small text-uppercase">Efficiency</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-white bg-opacity-10 rounded-3 text-center">
                            <h2 class="fw-bold mb-0" id="team_done_activation">0/0</h2>
                            <small class="xx-small text-uppercase">Done</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Activity Log -->
        <div class="card rounded-4 mb-4 shadow-1 border-0">
            <div class="card-header rounded-4 px-4 py-3 bg-white border-bottom d-flex align-items-center gap-2">
                <i class="bi bi-clock-history text-primary fs-5"></i>
                <p class="text-uppercase fw-bold mb-0">Activity Log</p>
            </div>
            <div class="card-body rounded-4 px-4">
                <div class="position-relative ps-3 my-2" id="global-activity-log-container">
                    <!-- Vertical line -->
                    <div class="position-absolute top-0 start-0 h-100 bg-light" style="width: 2px; margin-left: 9px;">
                    </div>
                    <!-- Logs will be loaded here -->
                    <div class="text-center py-3">
                        <div class="spinner-border spinner-border-sm text-secondary" role="status"></div>
                    </div>
                </div>
                <button class="btn btn-outline-secondary w-100 btn-sm text-uppercase fw-bold mt-3"
                    style="font-size: 10px; letter-spacing: 1px;" onclick="openViewFullLog()">
                    View Full Log
                </button>
            </div>
        </div>
    </div>
</div>