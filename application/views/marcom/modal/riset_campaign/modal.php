<!-- Modal Tambahkan Campaign -->
<div class="modal fade" id="campaignModal" aria-labelledby="campaignModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">

        <form id="campaignForm" class="modal-content modal-campaign" enctype="multipart/form-data">

            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Tambahkan Campaign</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="text" name="campaign_name" class="form-control campaign-title-input" placeholder="Buat titel campaign disini">

                <div class="grey-input px-3 py-2 mt-3">
                    <i class="bi bi-list-check me-2"></i>
                    <input type="text" name="goals" class="form-control border-0 bg-transparent p-0 m-0" style="box-shadow:none;outline:none;font-size:14px;color:#212529;" placeholder="Tambahkan goals">
                </div>

                <div class="grey-input px-3 py-2 mt-2">
                    <i class="bi bi-lightbulb me-2"></i>
                    <input type="text" name="big_idea" class="form-control border-0 bg-transparent p-0 m-0" style="box-shadow:none;outline:none;font-size:14px;color:#212529;" placeholder="Tambahkan konsep besar">
                </div>

                <div class="mt-4">
                    <label class="small fw-semibold text-muted mb-1">Company</label>
                    <select id="companySelect" name="company_id" class="form-select form-select-sm w-100">
                        <option value="">-- Pilih Company --</option>
                        <?php foreach ($companies as $c) { ?>
                            <option value="<?= $c->company_id ?>"><?= $c->name ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mt-3">
                    <label class="small fw-semibold text-muted mb-1">PIC</label>
                    <select name="pic[]" id="picSelect" multiple></select>
                </div>

                <div class="mt-4">
                    <label class="small fw-semibold text-muted mb-1">Deskripsi Campaign</label>
                    <textarea id="descriptionInput" name="description" class="summernote"></textarea>
                </div>

                <div class="mt-3">
                    <label class="small fw-semibold text-muted mb-1">Timeline</label>
                    <input type="text" id="timelinePicker" class="form-control form-control-sm">
                </div>
                <input type="hidden" id="start_date" name="start_date">
                <input type="hidden" id="end_date" name="end_date">

                <div class="mt-3">
                    <label class="small fw-semibold text-muted mb-1">Prioritas</label>
                    <select id="priority" name="priority" class="form-select form-select-sm">
                        <option value="">-- Pilih Prioritas --</option>
                        <option value="1">Low</option>
                        <option value="2">Medium</option>
                        <option value="3">High</option>
                    </select>
                </div>

                <div class="mt-3 mb-3">
                    <label class="small fw-semibold text-muted mb-1">Placement</label>
                    <select id="placementSelect" name="placement[]" multiple>
                        <option value="" disabled>-- Pilih Placement --</option>
                        <option value="1">Instagram</option>
                        <option value="2">TikTok</option>
                        <option value="3">Influencer</option>
                        <option value="4">Mediagram</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end mb-2">
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btnAddKol">
                        <i class="bi bi-plus-circle"></i> Tambah Master KOL
                    </button>
                </div>


                <div class="d-none" id="kolContainer">
                    <label class="small fw-semibold text-muted mb-1">Referensi KOL</label>
                    <div class="table-responsive">
                        <table id="tableKOL" class="table table-bordered" style="width: 100% ;">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Akun</th>
                                    <th>Ratecard</th>
                                    <th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

                <input type="hidden" id="kol_id" name="kol_id">
                <label for="kol_name">KOL Name (Opsional)</label>
                <div class="grey-input px-3 py-2 mt-3">
                    <i class="bi bi-user me-2"></i>
                    <input type="text" name="kol_name" id="kol_name" class="form-control border-0 bg-transparent p-0 m-0" style="box-shadow:none;outline:none;font-size:14px;color:#212529;" readonly>
                </div>

                <label for="kol_budget">KOL Budget (Opsional)</label>
                <div class="grey-input px-3 py-2 mt-3">
                    <i class="bi bi-cash me-2"></i>
                    <input type="text" name="kol_budget" id="kol_budget" class="form-control border-0 bg-transparent p-0 m-0" style="box-shadow:none;outline:none;font-size:14px;color:#212529;" oninput="formatInputNumber(this)">
                </div>

                <!-- <label for="mediagram_name">Mediagram (Opsional)</label>
                <div class="grey-input px-3 py-2 mt-3">
                    <i class="bi bi-user me-2"></i>
                    <input type="text" name="mediagram_name" id="mediagram_name" class="form-control border-0 bg-transparent p-0 m-0" style="box-shadow:none;outline:none;font-size:14px;color:#212529;" readonly>
                </div>

                <input type="hidden" id="mediagram_id" name="mediagram_id">
                <label for="mediagram_budget">Mediagram Budget (Opsional)</label>
                <div class="grey-input px-3 py-2 mt-3">
                    <i class="bi bi-cash me-2"></i>
                    <input type="text" name="mediagram_budget" id="mediagram_budget" class="form-control border-0 bg-transparent p-0 m-0" style="box-shadow:none;outline:none;font-size:14px;color:#212529;" oninput="formatInputNumber(this)">
                </div> -->

                <div class="fw-semibold small text-muted mt-4">Lampiran Link</div>
                <div id="linkWrapper">
                    <div class="attach-link-box mt-2 d-flex align-items-center">
                        <i class="bi bi-link-45deg me-2"></i>
                        <span class="small me-2">Benchmarking</span>
                        <input type="text" name="reference_url[]" class="form-control form-control-sm" placeholder="Tempel URL lengkap">
                    </div>
                </div>

                <button type="button" id="addLink" class="btn btn-outline-secondary btn-sm mt-2">
                    + Tambah Link
                </button>

                <div class="fw-semibold small text-muted mt-4">Lampiran File</div>
                <div id="marcomDropzone" class="dropzone mt-2 border rounded bg-light p-3 text-center small text-muted">
                    <span>Seret file atau klik untuk upload<br>Max 3 file</span>
                </div>

                <input type="hidden" name="uploaded_files[]" id="uploaded_files">
            </div>

            <div class="modal-footer border-0 pt-0">
                <button class="btn btn-primary px-4" type="submit">Buat Campaign</button>
            </div>

        </form>
    </div>
</div>

<!-- Modal Riset SPV -->
<div class="modal fade" id="modalRisetSPV" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">Input Data Riset Campaign</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="riset_campaign_id" name="campaign_id">
                <div class="alert alert-secondary p-3 mb-4 rounded-3 border-0" style="background-color: #f8f9fa;">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <h5 class="fw-bold mb-1" id="r_campaign_name" style="color: #0d6efd;">-</h5>
                        </div>
                        <div class="col-md-6 text-sm">
                            <p class="mb-1 small text-muted">Timeline</p>
                            <span class="fw-semibold" id="r_timeline">-</span>
                        </div>
                        <div class="col-md-6 text-sm">
                            <p class="mb-1 small text-muted">Goals</p>
                            <span class="fw-semibold" id="r_goals">-</span>
                        </div>
                        <div class="col-md-6 mt-2 text-sm">
                            <p class="mb-1 small text-muted">Big Idea</p>
                            <p class="fw-semibold fst-italic mb-0" id="r_big_idea">-</p>
                        </div>
                        <div class="col-md-6 mt-2 text-sm">
                            <p class="mb-1 small text-muted">PIC</p>
                            <div class="d-flex align-items-center" id="r_pic">-</div>
                        </div>
                        <div class="col-md-6 mt-2 text-sm">
                            <p class="mb-1 small text-muted">Deadline</p>
                            <span class="fw-semibold" id="r_deadline">-</span>
                        </div>
                    </div>
                </div>

                <div class="accordion mb-3 shadow-sm" id="accordionRisetHistory">
                    <div class="accordion-item border-0">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRisetCampBrief">
                                <i class="bi bi-megaphone me-2 text-primary"></i> Campaign Brief (Detail)
                            </button>
                        </h2>
                        <div id="collapseRisetCampBrief" class="accordion-collapse collapse" data-bs-parent="#accordionRisetHistory">
                            <div class="accordion-body bg-white">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <small class="fw-bold text-muted d-block mb-1">Placement</small>
                                        <div id="r_placement"></div>
                                    </div>
                                    <div class="col-12">
                                        <small class="fw-bold text-muted d-block mb-1">DESKRIPSI</small>
                                        <div id="r_description" class="p-2 bg-light border rounded small">-</div>
                                    </div>

                                    <!-- Influencer/Mediagram Info -->
                                    <div class="col-12" id="r_influencer_container"></div>

                                    <!-- Links -->
                                    <div class="col-md-6">
                                        <small class="fw-bold text-muted d-block mb-2">
                                            <i class="bi bi-link-45deg me-1"></i> LINK REFERENSI
                                        </small>
                                        <div id="r_camp_links"></div>
                                    </div>

                                    <!-- Files -->
                                    <div class="col-md-6">
                                        <small class="fw-bold text-muted d-block mb-2">
                                            <i class="bi bi-paperclip me-1"></i> FILE REFERENSI
                                        </small>
                                        <div id="r_camp_files"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="fw-bold small mb-2">Riset Report</label>
                    <textarea id="riset_report" class="summernote"></textarea>
                </div>

                <div class="mb-3">
                    <label class="fw-bold small mb-2">Trend Analysis</label>
                    <textarea id="trend_analysis" class="summernote"></textarea>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="fw-bold small">Link Riset</label>
                        <button type="button" id="addRisetLink" class="btn btn-xs btn-outline-primary py-0">+ Tambah Link</button>
                    </div>
                    <div id="risetLinkArea">

                    </div>
                </div>

                <div class="mb-3">
                    <label class="fw-bold small mb-2">File Riset (Lampiran)</label>
                    <div id="dropzoneRiset" class="dropzone border rounded bg-light text-center">
                        <div class="dz-message" data-dz-message><span>Klik atau Drop file di sini</span></div>
                    </div>
                </div>

            </div>

            <div class="modal-footer border-0 d-flex gap-2">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveRisetSPV">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalReviewRiset" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0" style="border-radius: 12px; overflow:hidden;">
            <div class="modal-header border-bottom-0 pb-0">
                <div>
                    <span class="badge bg-primary-subtle text-primary mb-2" id="rv_badge_id">ID: -</span>
                    <h4 class="modal-title fw-bold" id="rv_campaign_name">Campaign Title</h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body bg-light pt-4">
                <div class="alert alert-light border mb-3">
                    <div class="row g-3">
                        <div class="col-md-3"><small class="text-muted d-block fw-bold">Timeline</small><span class="fw-semibold" id="rv_timeline">-</span></div>
                        <div class="col-md-3"><small class="text-muted d-block fw-bold">Priority</small>
                            <div id="rv_priority">-</div>
                        </div>
                        <div class="col-md-6"><small class="text-muted d-block fw-bold">Placement</small>
                            <div id="rv_placement">-</div>
                        </div>
                        <div class="col-md-6"><small class="text-muted d-block fw-bold">PIC</small>
                            <div id="rv_pics" class="small">-</div>
                        </div>
                    </div>
                </div>

                <div class="accordion mb-3 shadow-sm" id="accordionRvHist1">
                    <div class="accordion-item border-0">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRvHistBrief">
                                <i class="bi bi-megaphone me-2 text-primary"></i> Campaign Brief
                            </button>
                        </h2>
                        <div id="collapseRvHistBrief" class="accordion-collapse collapse" data-bs-parent="#accordionRvHist1">
                            <div class="accordion-body bg-white">
                                <div class="row g-3">

                                    <div class="col-md-6"><small class="text-muted d-block fw-bold">GOALS</small>
                                        <div id="rv_hist_goals">-</div>
                                    </div>
                                    <div class="col-md-6"><small class="text-muted d-block fw-bold">BIG IDEA</small>
                                        <div id="rv_hist_big_idea">-</div>
                                    </div>
                                    <div class="col-md-6"><small class="text-muted d-block fw-bold">Description</small>
                                        <div id="rv_description" class="small">-</div>
                                    </div>

                                    <!-- Influencer/Mediagram Info -->
                                    <div class="col-sm-12 col-md-6" id="rv_influencer_container"></div>

                                    <!-- Links -->
                                    <div class="col-md-6">
                                        <small class="fw-bold text-muted d-block mb-2">
                                            <i class="bi bi-link-45deg me-1"></i> LINK REFERENSI
                                        </small>
                                        <div id="rv_hist_links"></div>
                                    </div>

                                    <!-- Files -->
                                    <div class="col-md-6">
                                        <small class="fw-bold text-muted d-block mb-2">
                                            <i class="bi bi-paperclip me-1"></i> FILE REFERENSI
                                        </small>
                                        <div id="rv_hist_files"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h6 class="mb-0 fw-bold">Hasil Riset & Analisa</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="fw-bold text-dark small">Riset Report</h6>
                            <div class="p-3 border rounded bg-light" id="rv_riset_report"></div>
                        </div>
                        <div class="mb-3">
                            <h6 class="fw-bold text-dark small">Trend Analysis</h6>
                            <div class="p-3 border rounded bg-light" id="rv_trend_analysis"></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h6 class="fw-bold small text-muted">Lampiran File</h6>
                                <div id="rv_files_list" class="d-flex flex-column gap-2"></div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold small text-muted">Lampiran Link</h6>
                                <div id="rv_links_list" class="d-flex flex-column gap-2"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 p-3 bg-warning-subtle rounded border border-warning">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="fw-bold text-dark mb-2">Catatan Approval (Note)</label>
                            <textarea class="form-control" id="approve_note" rows="3" placeholder="Masukkan catatan approval..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-dark mb-2">Next PIC (Content Script)</label>
                            <select name="pic[]" id="picSelectReviewSpv" multiple></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <label class="fw-bold text-dark mb-2">Deadline Next Progress</label>
                            <input type="date" class="form-control" name="deadline_naskah" id="deadline_naskah">
                        </div>
                    </div>

                    <input type="hidden" id="rv_hidden_campaign_id">
                    <input type="hidden" id="rv_hidden_riset_id">
                </div>

            </div>
            <div class="modal-footer border-top-0 pt-0 pb-4 pe-4">
                <button type="button" class="btn btn-warning text-white me-auto" id="btnRejectRiset" style="display:none;"><i class="bi bi-arrow-counterclockwise me-1"></i> Revisi</button>
                <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary px-4" id="btnApproveRiset"><i class="bi bi-check-circle-fill me-2"></i> Approve</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalFullDetailCampaign" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header border-bottom pb-3 bg-light">
                <div class="w-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <!-- <span class="badge bg-primary mb-2">Campaign Detail</span> -->
                            <h4 class="modal-title fw-bold text-dark" id="fd_campaign_name">Title</h4>
                            <h5 class="fw-semibold text-dark" style="font-size: 0.8rem;"><span id="fd_campaign_id">-</span></h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="d-flex gap-4 mt-2 align-items-center flex-wrap">
                        <div class="d-flex align-items-center text-muted small">
                            <i class="bi bi-calendar-range me-2"></i>
                            <span id="fd_timeline">-</span>
                        </div>
                        <div id="fd_priority"></div>
                        <div class="d-flex align-items-center text-muted small">
                            <i class="bi bi-people me-2"></i>
                            <div class="d-flex align-items-center" id="fd_pics">-</div>
                        </div>
                        <div id="fd_placement"></div>
                    </div>
                </div>
            </div>

            <div class="modal-body p-0">

                <div class="accordion accordion-flush" id="accordionDetail">

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBrief">
                                <i class="bi bi-info-circle me-2 text-primary"></i> Campaign Brief
                            </button>
                        </h2>
                        <div id="collapseBrief" class="accordion-collapse collapse show" data-bs-parent="#accordionDetail">
                            <div class="accordion-body bg-light-subtle">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <small class="fw-bold text-muted d-block">GOALS</small>
                                        <div id="fd_goals" class="fd-textbox">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="fw-bold text-muted d-block">BIG IDEA</small>
                                        <div id="fd_big_idea" class="fd-textbox fst-italic">-</div>
                                    </div>

                                    <div class="col-12" id="fd_brief_influencer_row" style="display:none;">

                                    </div>
                                    <div class="col-12">
                                        <small class="fw-bold text-muted d-block">DESCRIPTION</small>
                                        <div id="fd_description" class="fd-textbox lg">-</div>

                                    </div>
                                    <div class="col-sm-12 col-md-6" id="fd_brief_link_container"></div>
                                    <div class="col-sm-12 col-md-6" id="fd_brief_file_container"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRiset">
                                <i class="bi bi-search me-2 text-info"></i> Riset Campaign
                            </button>
                        </h2>
                        <div id="collapseRiset" class="accordion-collapse collapse" data-bs-parent="#accordionDetail">
                            <div class="accordion-body">

                                <div class="d-flex justify-content-between align-items-start mb-3 border-bottom pb-2">
                                    <div>
                                        <small class="text-muted d-block fw-bold">PIC Riset:</small>
                                        <div id="fd_riset_pic" class="d-flex align-items-center mt-1">-</div>
                                    </div>
                                    <div class="text-end" style="max-width: 60%;">
                                        <small class="text-muted d-block fw-bold">Note Approval:</small>
                                        <span id="fd_riset_note" class="small fst-italic">-</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <h6 class="fw-bold small text-muted">RISET REPORT</h6>
                                    <div id="fd_riset_report" class="fd-textbox lg">-</div>
                                </div>
                                <div class="mb-3">
                                    <h6 class="fw-bold small text-muted">TREND ANALYSIS</h6>
                                    <div id="fd_trend_analysis" class="fd-textbox lg">-</div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="fw-bold small text-muted"><i class="bi bi-link-45deg"></i> Link Riset</h6>
                                        <div id="fd_riset_links" class="d-flex flex-column gap-1"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="fw-bold small text-muted"><i class="bi bi-paperclip"></i> File Riset</h6>
                                        <div id="fd_riset_files" class="d-flex flex-column gap-1"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseScript">
                                <i class="bi bi-file-earmark-text me-2 text-warning"></i> Content Script
                            </button>
                        </h2>
                        <div id="collapseScript" class="accordion-collapse collapse" data-bs-parent="#accordionDetail">
                            <div class="accordion-body">

                                <div class="d-flex justify-content-between align-items-start mb-3 border-bottom pb-2">
                                    <div>
                                        <small class="text-muted d-block fw-bold">PIC Script:</small>
                                        <div id="fd_script_pic" class="d-flex align-items-center mt-1">-</div>
                                    </div>
                                    <div class="text-end" style="max-width: 60%;">
                                        <small class="text-muted d-block fw-bold">Note Approval:</small>
                                        <span id="fd_script_note" class="small fst-italic">-</span>
                                    </div>
                                </div>
                                <div id="fd_naskah_final" class="fd-textbox lg">
                                    <span class="text-muted fst-italic">Belum ada naskah final.</span>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKOL">
                                <i class="bi bi-people-fill me-2 text-danger"></i> Riset KOL
                            </button>
                        </h2>
                        <div id="collapseKOL" class="accordion-collapse collapse" data-bs-parent="#accordionDetail">
                            <div class="accordion-body bg-light-subtle">

                                <div class="card border-0 shadow-sm mb-3">
                                    <div class="card-body p-2">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <small class="text-muted d-block fw-bold">PIC Riset KOL:</small>
                                                <div id="fd_kol_pic" class="d-flex align-items-center mt-1">-</div>
                                            </div>
                                            <div class="text-end" style="max-width: 50%;">
                                                <small class="text-muted d-block fw-bold">Note Approval:</small>
                                                <span id="fd_kol_note" class="small fst-italic">-</span>
                                            </div>
                                        </div>
                                        <hr class="my-1">
                                        <div>
                                            <small class="text-muted d-block fw-bold mb-1">Bukti / File Lampiran:</small>
                                            <div id="fd_kol_files" class="d-flex flex-wrap gap-2">-</div>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="small fw-bold text-muted mb-2">Kandidat KOL Approved:</h6>
                                <div class="row g-3" id="fd_kol_container"></div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBudget">
                                <i class="bi bi-cash-stack me-2 text-success"></i> Budgeting
                            </button>
                        </h2>
                        <div id="collapseBudget" class="accordion-collapse collapse" data-bs-parent="#accordionDetail">
                            <div class="accordion-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <small class="text-muted d-block fw-bold">PIC Budget:</small>
                                        <div id="fd_budget_pic" class="d-flex align-items-center mt-1">-</div>
                                    </div>
                                    <div class="text-end" style="max-width: 50%;">
                                        <small class="text-muted d-block fw-bold">Note Approval:</small>
                                        <span id="fd_budget_note" class="small fst-italic">-</span>
                                    </div>
                                </div>
                                <hr class="my-1">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="p-3 bg-success-subtle border border-success rounded text-center">
                                            <small class="text-success d-block fw-bold">TOTAL BUDGET</small>
                                            <h3 class="fw-bold text-success mb-0" id="fd_total_budget">Rp 0</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <table class="table table-sm table-bordered mb-0">
                                            <tr>
                                                <th width="30%">No Eaf</th>
                                                <td id="fd_no_eaf">-</td>
                                            </tr>
                                            <tr>
                                                <th width="30%">Penerima</th>
                                                <td id="fd_penerima">-</td>
                                            </tr>
                                            <tr>
                                                <th>Keperluan</th>
                                                <td id="fd_keperluan">-</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td id="fd_status_budget">-</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tambahkan History Shooting -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseShooting">
                                <i class="bi bi-camera-video me-2 text-primary"></i> Shooting History
                            </button>
                        </h2>
                        <div id="collapseShooting" class="accordion-collapse collapse" data-bs-parent="#accordionDetail">
                            <div class="accordion-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <small class="text-muted d-block fw-bold">PIC Shooting:</small>
                                        <div id="fd_shooting_pic" class="d-flex align-items-center mt-1">-</div>
                                    </div>
                                    <div class="text-end" style="max-width: 50%;">
                                        <small class="text-muted d-block fw-bold">Note Approval:</small>
                                        <span id="fd_shooting_note" class="small fst-italic">-</span>
                                    </div>
                                </div>
                                <hr class="my-1">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <small class="fw-bold text-muted d-block">Lokasi</small>
                                        <div id="fd_shooting_lokasi" class="d-flex align-items-center">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="fw-bold text-muted d-block">Output</small>
                                        <div id="fd_shooting_output" class="d-flex align-items-center gap-2">-</div>
                                    </div>
                                    <div class="col-12">
                                        <small class="fw-bold text-muted d-block">Keterangan Shooting</small>
                                        <div id="fd_shooting_keterangan" class="fd-textbox">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="fw-bold text-muted d-block">Lampiran File Shooting</small>
                                        <div id="fd_shooting_files">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="fw-bold text-muted d-block">Link Shooting</small>
                                        <div id="fd_shooting_link">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tambahkan History Editing -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEditing">
                                <i class="bi bi-pencil-square me-2 text-info"></i> Editing History
                            </button>
                        </h2>
                        <div id="collapseEditing" class="accordion-collapse collapse" data-bs-parent="#accordionDetail">
                            <div class="accordion-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <small class="text-muted d-block fw-bold">PIC Shooting:</small>
                                        <div id="fd_editing_pic" class="d-flex align-items-center mt-1">-</div>
                                    </div>
                                    <div class="text-end" style="max-width: 50%;">
                                        <small class="text-muted d-block fw-bold">Note Approval:</small>
                                        <span id="fd_editing_note" class="small fst-italic">-</span>
                                    </div>
                                </div>
                                <hr class="my-1">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <small class="fw-bold text-muted d-block">Catatan / Caption / Description</small>
                                        <div id="fd_editing_caption" class="fd-textbox">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="fw-bold text-muted d-block">Link Editing</small>
                                        <div id="fd_editing_link">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="fw-bold text-muted d-block">Thumbnail</small>
                                        <div id="fd_editing_thumbnail">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>