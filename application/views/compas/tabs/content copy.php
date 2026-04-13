<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!-- Empty State -->
<div class="row" id="content-empty-state" style="display: none;">
    <div class="col-12" id="content-empty-state">
        <div class="card rounded-4 shadow-1 border-0">
            <div class="card-body rounded-4 d-flex flex-column align-items-center justify-content-center text-center py-5"
                style="min-height: 400px;">
                <div class="rounded-circle bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center mb-3"
                    style="width: 72px; height: 72px;">
                    <i class="bi bi-file-earmark-play display-6 text-secondary"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Content Production</h5>
                <p class="text-muted small mb-4" style="max-width: 320px;">
                    Plan, create, and manage content for your campaigns.
                </p>
                <button class="btn btn-primary border-0 rounded-3 px-4 py-2 fw-bold shadow-sm small"
                    onclick="showContentForm()">
                    + Add Content
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Active State -->
<div class="row" id="content-content-section" style="display: none;">
    <div class="col-8">
        <!-- Content List -->
        <div class="card rounded-4 mb-4 shadow-1 border-0">
            <div
                class="card-header rounded-4 px-4 py-3 bg-white border-bottom d-flex justify-content-between align-items-center">
                <p class="text-uppercase fw-bold mb-0">Content Plan</p>
                <button class="btn btn-primary btn-sm rounded-pill px-3 d-flex align-items-center gap-1"
                    onclick="showContentForm()">
                    <i class="bi bi-plus-lg"></i>
                    Add Content
                </button>
            </div>
            <div class="card-body rounded-4 p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3 text-uppercase text-muted small fw-bold border-0">Title / Format
                                </th>
                                <th class="px-4 py-3 text-uppercase text-muted small fw-bold border-0">Publish Date</th>
                                <th class="px-4 py-3 text-uppercase text-muted small fw-bold border-0 text-center">
                                    Status</th>
                                <th class="px-4 py-3 text-uppercase text-muted small fw-bold border-0 text-end">Action
                                </th>
                            </tr>
                        </thead>
                        <tbody id="content-table-body">
                            <!-- Helper / Mock Data -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Discussion -->
        <div class="card rounded-4 mb-4 shadow-1 border-0" style="height: 500px;">
            <div
                class="card-header rounded-4 px-4 py-3 bg-white border-bottom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-chat-left-text text-primary fs-5"></i>
                    <p class="text-uppercase fw-bold mb-0">Discussion</p>
                </div>
                <span class="badge bg-light text-secondary text-uppercase">Participants</span>
            </div>
            <div class="card-body rounded-4 px-4 overflow-auto d-flex flex-column gap-3" id="chat-container">
                <!-- Chat content -->
            </div>
            <div class="card-footer bg-transparent border-top px-4 py-3">
                <div class="position-relative">
                    <input type="text" class="form-control bg-light border-0 rounded-3 ps-3 pe-5 py-2 small"
                        id="chat-input" placeholder="Write a message..."
                        onkeypress="window.handleChatKeyPress(event)" />
                    <button
                        class="btn btn-link text-primary position-absolute top-50 end-0 translate-middle-y text-decoration-none p-2"
                        onclick="window.chatSimulation()">
                        <i class="bi bi-send"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-4">
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