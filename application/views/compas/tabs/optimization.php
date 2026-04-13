<!-- Update: optimization.php -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-soft-purple rounded-3 border-0">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-check-circle text-purple fs-5"></i>
                    <h6 class="fw-bold text-dark mb-0"><span class="text-purple">Incoming Briefs / Approved
                            Strategy</span></h6>
                </div>
                <p class="text-purple small mb-3 opacity-75">The following strategies have been approved in Activation
                    phase. Please use them as reference.</p>

                <div id="incoming-briefs-container">
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row g-4">
    <div class="col-12">
        <div class="card mb-0 rounded-3">
            <div class="card-body px-4 rounded-3">
                <div class="row">
                    <div class="col-auto d-flex align-items-center">
                        <h6 class="fw-bold text-dark mb-1">Optimization Team</h6>
                    </div>
                    <div class="ms-auto col-auto d-flex align-items-center">
                        <button class="btn btn-theme btn-sm rounded-1 px-3 d-flex align-items-center action-restricted"
                            data-bs-toggle="modal" data-bs-target="#inviteTeamOptimizationModal">
                            <i class="bi bi-plus-lg me-1"></i> Invite Team
                        </button>
                    </div>
                    <div class="col-auto ps-0 avatar-group" id="avatar-optimization-team">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Left Column: Plan and Discussion -->
    <div class="col-lg-8">
        <!-- Optimization Plan -->
        <div class="card mb-4 rounded-3">
            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-bold">Optimization Plan</h6>
                <button type="button" id="btnAddPlanOptimization"
                    class="btn btn-theme btn-sm rounded-1 px-3 d-flex align-items-center action-restricted"
                    data-bs-toggle="modal" data-bs-target="#addOptimizationPlanModal">
                    <i class="bi bi-plus-lg me-1"></i> Add Plan
                </button>
            </div>
            <div class="card-body p-2">
                <div class="table-responsive">
                    <table id="dt_optimization_plan" class="table table-bordered table-striped no-footer dataTable"
                        width="100%">
                        <thead class="bg-light text-secondary small text-uppercase fw-bold">
                            <tr>
                                <th class="ps-4" style="width: 10%">ID</th>
                                <th class="ps-4" style="width: 40%">Optimization Plan</th>
                                <th style="width: 20%" class="text-center">Assigned</th>
                                <th style="width: 20%" class="text-center">Status</th>
                                <th style="width: 20%" class="text-center">Viability Score</th>
                                <th class="text-end pe-4" style="width: 20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
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
                <div id="comments-container"></div>
            </div>
        </div>
    </div>

    <!-- Right Column: Activity & Performance -->
    <div class="col-lg-4">
        <!-- Team Performance -->
        <div class="card rounded-3 bg-theme text-white mb-4">
            <div class="card-body bg-none p-4">
                <h6 class="fw-bold mb-4 text-white text-uppercase small">Team Performance</h6>

                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="p-3 bg-white bg-opacity-10 rounded-3">
                            <h2 class="fw-bold mb-0" id="team_efficiency">-</h2>
                            <small class=" xx-small text-uppercase">Efficiency</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-white bg-opacity-10 rounded-3">
                            <h2 class="fw-bold mb-0" id="team_done">-</h2>
                            <small class=" xx-small text-uppercase">Done</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Activity Log -->
        <div class="card rounded-3 mb-4">
            <div class="card-header bg-transparent border-0 py-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-clock-history text-primary fs-5"></i>
                    <h6 class="mb-0 fw-bold">Activity Log</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="activity-timeline ms-3">
                    <div class="timeline-item pb-4">
                        <div class="timeline-dot bg-success"></div>
                        <p class="mb-1 text-dark small">
                            <span class="fw-bold">Mike Ross</span> completed <span class="fw-bold">Outreach</span>.
                        </p>
                        <small class="text-muted xx-small">2 hours ago</small>
                    </div>
                    <div class="timeline-item pb-4">
                        <div class="timeline-dot bg-primary"></div>
                        <p class="mb-1 text-dark small">
                            <span class="fw-bold">Sarah J.</span> uploaded a file.
                        </p>
                        <small class="text-muted xx-small">3 hours ago</small>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot bg-warning"></div>
                        <p class="mb-1 text-dark small">
                            <span class="fw-bold">System</span> updated status.
                        </p>
                        <small class="text-muted xx-small">5 hours ago</small>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>