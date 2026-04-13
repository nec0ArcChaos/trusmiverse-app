<!-- Evidence Modal -->
    <div class="modal fade" id="modal-evidence" tabindex="-1" style="z-index: 10000; background:rgba(15,23,42,0.6); backdrop-filter: blur(4px);">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border:1px solid rgba(255,255,255,0.2); box-shadow:0 10px 30px rgba(0,0,0,0.2); border-radius:12px; overflow:hidden;">
                <div class="modal-header" style="background:#f8fafc; border-bottom:1px solid #e2e8f0; padding:16px 20px;">
                    <h5 class="modal-title" style="font-weight:700; color:#0f172a; font-size:15px; display:flex; align-items:center; gap:8px;">
                        <i class="bi bi-paperclip" style="color:var(--accent);"></i> Manage Task Evidence
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding:24px; background:#fff;">
                    <form id="form-evidence" enctype="multipart/form-data">
                        <input type="hidden" id="ev-task-id" name="task_id">
                        <input type="hidden" id="ev-project-id" name="project_id">
                        
                        <div style="background:#f8fafc; padding:16px; border-radius:8px; border:1px solid #e2e8f0; margin-bottom:20px;">
                            <label style="font-size:11px; font-weight:700; text-transform:uppercase; color:#64748b; margin-bottom:8px; display:block;">Add New Evidence</label>
                            
                            <div style="display:flex; gap:12px; align-items:flex-end;">
                                <div style="width:130px;">
                                    <select class="form-select form-select-sm" id="ev-type" name="type" style="font-size:12px; font-weight:500; cursor:pointer;" onchange="toggleEvType()">
                                        <option value="file">📁 File/Image</option>
                                        <option value="url">🔗 Web URL</option>
                                    </select>
                                </div>
                                
                                <div style="flex:1;" id="ev-input-container">
                                    <input type="file" id="ev-file" name="evidence_file" class="form-control form-control-sm" style="font-size:12px; cursor:pointer;">
                                    <input type="url" id="ev-url" name="evidence_url" class="form-control form-control-sm" placeholder="https://example.com" style="display:none; font-size:12px;">
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-sm" id="btn-save-evidence" style="font-size:12px; font-weight:600; padding:4px 16px; border-radius:6px; display:inline-flex; align-items:center; gap:6px;">
                                    <i class="bi bi-cloud-arrow-up"></i> Upload
                                </button>
                            </div>
                            <div id="ev-upload-progress" style="display:none; margin-top:12px; margin-bottom:4px;">
                                <div style="height:4px; background:#e2e8f0; border-radius:4px; overflow:hidden;">
                                    <div id="ev-progress-bar" style="height:100%; width:0%; background:var(--green); transition:width 0.2s;"></div>
                                </div>
                                <div style="font-size:10px; color:#64748b; margin-top:4px; text-align:right;" id="ev-progress-text">Uploading...</div>
                            </div>
                        </div>
                    </form>

                    <label style="font-size:11px; font-weight:700; text-transform:uppercase; color:#64748b; margin-bottom:8px; display:block;">Attached Evidence (<span id="ev-count-label">0</span>)</label>
                    <div id="ev-list-container" style="min-height:100px; max-height:240px; overflow-y:auto; border:1px solid #e2e8f0; border-radius:8px; background:#fefefe;">
                        <!-- List populated by AJAX -->
                        <div style="padding:40px; text-align:center; color:#94a3b8; font-size:12px; font-weight:500;">
                            <div class="spinner-border spinner-border-sm" role="status" style="color:var(--accent);"></div> Loading evidence...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Add/Update Problem -->
<div class="modal fade" id="modalAddProblem" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header bg-soft-blue">
                <h5 class="modal-title fw-bold" id="modalProblemTitle">Input / Update Kendala</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAddProblem">
                <div class="modal-body">
                    <div class="mb-3 d-none" id="taskSelectorGroup">
                        <label class="form-label fw-bold small text-muted">Pilih Task / Project</label>
                        <select class="form-control form-control-sm select2-task-search w-100" name="task_id" id="task_id"></select>
                    </div>
                    <div class="mb-3" id="taskNameGroup">
                        <label class="form-label fw-bold small text-muted">Task</label>
                        <input type="text" class="form-control form-control-sm bg-light" id="displayTaskName" readonly>
                        <input type="hidden" name="task_id_hidden" id="task_id_hidden">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Deskripsi Kendala *</label>
                        <textarea class="form-control form-control-sm border-light-subtle shadow-none" name="problem_desc" id="problem_desc" rows="4" required placeholder="Jelaskan detail kendala..."></textarea>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label fw-bold small text-muted">Update Note <small class="text-muted">(Opsional)</small></label>
                            <textarea class="form-control form-control-sm border-light-subtle shadow-none" name="problem_note" id="problem_note" rows="4" placeholder="Catatan progress..."></textarea>
                        </div>
                        <div class="col-3 mb-3">
                            <label class="form-label fw-bold small text-muted">Estimasi Selesai <small class="text-muted">(Opsional)</small></label>
                            <input type="text" class="form-control form-control-sm tanggal-menit border-light-subtle shadow-none" name="est_date" id="est_date" placeholder="YYYY-MM-DD HH:mm" autocomplete="off">
                        </div>
                        <div class="col-3 mb-3">
                            <label class="form-label fw-bold small text-muted">Status</label>
                            <select class="form-select form-select-sm border-light-subtle shadow-none" name="status" id="problem_status">
                                <option value="Belum Solved">Belum Solved</option>
                                <option value="Diproses">Diproses</option>
                                <option value="Solved">Solved</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer gap-2">
                    <button type="button" class="btn btn-secondary btn-sm py-2 px-3 rounded-2 min-w-100px" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm py-2 px-3 rounded-2 min-w-100px" id="btnSaveProblem">
                        <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                        <span>Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="modal-details" tabindex="-1" aria-hidden="true" style="z-index: 10001; background:rgba(15,23,42,0.6); backdrop-filter: blur(4px);">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0" style="border-radius:16px; overflow:hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-bottom: 1px solid #e2e8f0; padding: 20px 24px;">
                <h5 class="modal-title" style="font-weight:800; color:#1e293b; font-size:18px; display:flex; align-items:center; gap:10px;">
                    <i class="bi bi-info-circle-fill" style="color:var(--accent);"></i> Item Details
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 32px; background: #fff;">
                <div class="row g-4">
                    <div class="col-md-7">
                        <div class="mb-4">
                            <label class="details-label">Title / Name</label>
                            <div class="details-value" id="det-text" style="font-size:18px; font-weight:700; color:#0f172a;">-</div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-6">
                                <label class="details-label">Company</label>
                                <div class="details-value" id="det-company">-</div>
                            </div>
                            <div class="col-6">
                                <label class="details-label">Category</label>
                                <div class="details-value" id="det-category">-</div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="details-label">Status</label>
                            <div id="det-status-badge" class="badge-status" style="font-size:12px; padding:6px 12px;">-</div>
                        </div>
                    </div>
                    <div class="col-md-5" style="border-left: 1px solid #f1f5f9; padding-left: 24px;">
                        <div class="mb-4">
                            <label class="details-label">PERSON IN CHARGE</label>
                            <div id="det-pic-container" style="margin-top:8px;">-</div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-6">
                                <label class="details-label">Start Date</label>
                                <div class="details-value" id="det-start">-</div>
                            </div>
                            <div class="col-6">
                                <label class="details-label">End Date</label>
                                <div class="details-value" id="det-end">-</div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="details-label">Completion</label>
                            <div class="d-flex align-items-center gap-3 mt-2">
                                <div style="flex:1; height:8px; background:#f1f5f9; border-radius:10px; overflow:hidden;">
                                    <div id="det-progress-bar" style="height:100%; width:0%; background:var(--accent); transition:width 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);"></div>
                                </div>
                                <span id="det-progress-text" style="font-family:var(--head); font-weight:800; font-size:16px; color:var(--accent);">0%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background:#f8fafc; border-top:1px solid #e2e8f0; padding:16px 24px;">
                <button type="button" class="btn btn-secondary px-4 fw-bold" data-bs-dismiss="modal" style="font-size:12px; border-radius:8px;">Close</button>
            </div>
        </div>
    </div>
</div>