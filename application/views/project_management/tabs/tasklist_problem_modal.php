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

<!-- Modal Update Status Only -->
<div class="modal fade" id="modalUpdateStatus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header bg-soft-blue">
                <h6 class="modal-title fw-bold">Update Status</h6>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formUpdateStatus">
                <div class="modal-body py-2">
                    <input type="hidden" name="task_id" id="updateTaskId">
                    <input type="hidden" name="status" id="updateProblemStatus">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Catatan (Opsional)</label>
                                <textarea class="form-control form-control-sm border-light-subtle shadow-none" name="note" rows="4" placeholder="Tulis catatan perubahan status..."></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Update Estimasi</label>
                                <input type="text" class="form-control tanggal-menit form-control-sm border-light-subtle shadow-none" name="est_date" id="editEstDate" placeholder="YYYY-MM-DD HH:mm" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm py-2 px-3 rounded-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm py-2 px-3 rounded-2" id="btnSaveStatus">
                        <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                        <span>Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>