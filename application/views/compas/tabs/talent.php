<!-- Talent Tab View -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-soft-purple rounded-3 border-0">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-check-circle text-purple fs-5"></i>
                    <h6 class="fw-bold text-dark mb-0"><span class="text-purple">Incoming Briefs / Approved
                            Strategy</span></h6>
                </div>
                <p class="text-purple small mb-3 opacity-75">The following strategies have been approved in Content
                    phase. Please use them as reference.</p>
                <div id="incoming-briefs-container-talent">
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row g-4" id="talent-content-section">
    <!-- Header: Talent Team -->
    <div class="col-12">
        <div class="card mb-0 rounded-3">
            <div class="card-body px-4 rounded-3">
                <div class="row">
                    <div class="col-auto d-flex align-items-center">
                        <h6 class="fw-bold text-dark mb-1">Talent Team</h6>
                    </div>
                    <div class="ms-auto col-auto d-flex align-items-center">
                        <button class="btn btn-theme btn-sm rounded-1 px-3 d-flex align-items-center action-restricted"
                            data-bs-toggle="modal" data-bs-target="#inviteTalentTeamModal">
                            <i class="bi bi-plus-lg me-1"></i> Invite Team
                        </button>
                    </div>
                    <div class="col-auto ps-0 avatar-group" id="avatar-talent-team">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Left Column: Plan and Discussion -->
    <div class="col-lg-8">
        <!-- Talent List -->
        <div class="card mb-4 rounded-3">
            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-bold">Talent List</h6>
                <button type="button" id="btnAddTalent"
                    class="btn btn-theme btn-sm rounded-1 px-3 d-flex align-items-center action-restricted"
                    data-bs-toggle="modal" data-bs-target="#addTalentModal">
                    <i class="bi bi-plus-lg me-1"></i> Add Talent
                </button>
            </div>
            <div class="card-body p-2">
                <div class="table-responsive">
                    <table id="dt_talent_list" class="table table-bordered table-striped no-footer dataTable"
                        width="100%">
                        <thead class="bg-light text-secondary small text-uppercase fw-bold">
                            <tr>
                                <th class="ps-4" style="width: 30%">Talent Name</th>
                                <th style="width: 25%">Linked Content</th>
                                <th style="width: 15%" class="text-center">Assigned</th>
                                <th style="width: 15%" class="text-center">Status</th>
                                <th style="width: 15%" class="text-center">Score AI</th>
                                <th class="text-end pe-4" style="width: 15%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="talent-table-body">
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
                <div id="comments-container-talent"></div>
            </div>
        </div>
    </div>

    <!-- Right Column: Activity & Performance -->
    <div class="col-lg-4">
        <!-- Team Performance -->
        <div class="card rounded-3 bg-theme text-white mb-4">
            <div class="card-body bg-none p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold mb-0 text-white text-uppercase small">Team Performance</h6>
                    <span class="badge bg-white bg-opacity-20 text-black small fst-italic"
                        id="team_perf_content_label">campaign total</span>
                </div>

                <!-- Content Filter -->
                <div class="mb-3">
                    <select class="form-select form-select-sm bg-opacity-10 border-0" id="team_perf_content_filter"
                        style="color: black !important;">
                        <option value="">── All Contents ──</option>
                    </select>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="p-3 bg-white bg-opacity-10 rounded-3">
                            <h2 class="fw-bold mb-0" id="team_efficiency_talent">-</h2>
                            <small class="xx-small text-uppercase">Efficiency</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-white bg-opacity-10 rounded-3">
                            <h2 class="fw-bold mb-0" id="team_done_talent">-</h2>
                            <small class="xx-small text-uppercase">Done / Target</small>
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
            <div class="card-body pt-0">
                <div class="timeline-sm ps-3 border-start border-2 ms-2 gap-3 d-flex flex-column activity-timeline">
                    <div class="position-relative ps-4 mb-3">
                        <div class="position-absolute top-0 start-0 translate-middle-x bg-success rounded-circle border border-white"
                            style="width: 12px; height: 12px; margin-top: 6px; margin-left: -1px;"></div>
                        <p class="mb-1 small text-dark"><span class="fw-bold">Mike Ross</span> completed <span
                                class="fw-bold">Outreach</span>.</p>
                        <span class="text-muted small" style="font-size: 11px;">2 hours ago</span>
                    </div>
                    <div class="position-relative ps-4 mb-3">
                        <div class="position-absolute top-0 start-0 translate-middle-x bg-primary rounded-circle border border-white"
                            style="width: 12px; height: 12px; margin-top: 6px; margin-left: -1px;"></div>
                        <p class="mb-1 small text-dark"><span class="fw-bold">Sarah J.</span> uploaded a file.</p>
                        <span class="text-muted small" style="font-size: 11px;">3 hours ago</span>
                    </div>
                    <div class="position-relative ps-4 mb-3">
                        <div class="position-absolute top-0 start-0 translate-middle-x bg-warning rounded-circle border border-white"
                            style="width: 12px; height: 12px; margin-top: 6px; margin-left: -1px;"></div>
                        <p class="mb-1 small text-dark"><span class="fw-bold">System</span> updated status.</p>
                        <span class="text-muted small" style="font-size: 11px;">5 hours ago</span>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>