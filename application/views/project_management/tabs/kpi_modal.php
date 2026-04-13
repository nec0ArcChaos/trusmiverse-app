<div class="modal fade" id="modalDetailKpi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-body p-0 position-relative">
                <div style="height: 120px; background: linear-gradient(135deg, rgba(2, 62, 115, 0.8), rgba(0, 32, 63, 0.9)), url(&quot;<?= base_url() ?>assets/main_theme/img/bg-22.jpg&quot;) center/cover; border-radius: 0.3rem 0.3rem 0 0;">
                    <div class="position-absolute top-0 end-0 m-3 d-flex gap-2" style="z-index: 10;">
                        <button type="button" class="btn btn-sm btn-light btn-print-pdf bg-white fw-medium border-0 shadow-sm" onclick="printKpiModal()" style="opacity: 0.9; padding: 0.35rem 0.75rem; border-radius: 6px;">
                            <i class="bi bi-file-earmark-pdf-fill text-danger me-1"></i> Print PDF
                        </button>
                        <button type="button" class="btn-close bg-white bg-dark rounded-circle p-2 shadow-sm" data-bs-dismiss="modal" aria-label="Close" style="opacity: 0.9; width: 10px; height: 10px;"></button>
                    </div>
                </div>

                <div class="px-4 pb-4 position-relative" style="margin-top: -10px;">

                    <!-- Profile Header -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex flex-column align-items-start" style="margin-top: -30px;">
                            <img src="https://ui-avatars.com/api/?name=Ande+Kurniawan&background=333&color=fff" id="view_user_avatar" alt="Avatar" class="rounded-circle border border-4 border-white shadow-sm mb-2" style="width: 80px; height: 80px; object-fit: cover; background:#fff;">
                            <h5 class="mb-0 fw-bold text-dark mt-2 fs-4" style="font-size: 1.05rem;" id="view_employee_name"></h5>
                            <div class="text-secondary small" id="view_department_name"></div>
                        </div>
                        <div class="d-flex gap-2 mt-4">
                            <span class="badge bg-white text-secondary border px-3 py-2 rounded-1 fw-normal text-dark" style="font-size: 0.75rem; border-color: #e5e7eb !important;"><i class="bi bi-person-circle me-2 text-theme"></i> <span id="view_badge1">Officer</span></span>
                            <span class="badge bg-white text-secondary border px-3 py-2 rounded-1 fw-normal text-dark" style="font-size: 0.75rem; border-color: #e5e7eb !important;"><i class="bi bi-calendar4 me-2 text-theme"></i> <span id="view_badge2">10 Bulan, 50 Hari</span></span>
                        </div>
                    </div>

                    <!-- Review summary card -->
                    <div class="card border-0 rounded-3 mb-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f1f5fd 50%, #c4dbfb 100%); border: 1px solid #f0f0f0 !important;">
                        <div class="card-body p-3 px-4 d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-1 text-dark fs-6" id="view_review_title">Review Atasan</h6>
                                <div class="text-secondary text-dark small" id="view_review_subtitle">Week 1 - Maret 2026</div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="text-center">
                                    <div class="text-warning mb-1" id="view_rating_stars" style="font-size: 1rem; color: #ffc107;">
                                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill" style="color: #e4e5e9;"></i>
                                    </div>
                                    <div class="fw-bold text-dark" style="font-size: 0.7rem;" id="view_rating_text">Sangat Baik</div>
                                </div>
                                <img src="https://img.freepik.com/free-vector/employees-giving-hands-helping-colleagues-walk-upstairs_74855-5236.jpg" alt="Illustration" style="height: 50px; mix-blend-mode: multiply;">
                            </div>
                        </div>
                    </div>

                    <!-- Metrics Row -->
                    <div class="row g-2 mb-4">
                        <div class="col-4">
                            <div class="border rounded-3 h-100 text-start py-2 bg-white p-3" style="border-color: #e5e7eb !important;">
                                <div class="text-success mb-1 d-flex align-items-center">
                                    <i class="bi bi-graph-up-arrow me-2"></i>
                                    <div class="text-secondary fw-medium mb-1" style="font-size: 0.7rem;">Achievement</div>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark mt-2 fs-4" id="view_total_achievement">0%</h6>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded-3 h-100 text-start py-2 bg-white p-3" style="border-color: #e5e7eb !important;">
                                <div class="text-danger mb-1 d-flex align-items-center">
                                    <i class="bi bi-award-fill me-2"></i>
                                    <div class="text-secondary fw-medium mb-1" style="font-size: 0.7rem;">Final Score</div>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark mt-2 fs-4" id="view_total_final_score">0</h6>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded-3 h-100 text-start py-2 bg-white p-3" style="border-color: #e5e7eb !important;">
                                <div class="text-primary mb-1 d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    <div class="text-secondary fw-medium mb-1" style="font-size: 0.7rem;">KPI Met</div>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark mt-2 fs-4" id="view_total_kpi_met">0 / 0</h6>
                            </div>
                        </div>
                    </div>

                    <!-- KPI Items List -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3 fs-6">Detail Pencapaian KPI</h6>
                        <div id="view_kpi_items_container" class="d-flex flex-column gap-3">
                            <!-- Items will be injected here via JS -->
                        </div>
                    </div>

                    <!-- Feedback Section -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3 fs-6">Feedback & Review Week <span id="view_header_week">1</span></h6>
                        <div class="border rounded-2 p-3 text-dark bg-white small text-justify" id="view_feedback">
                            <p class="mb-3">Pada Week 1, kinerja pada KPI Pengerjaan Task UI/UX berbasis Design Thinking, Kepatuhan Leadtime Desain, serta Usability &amp; User Acceptance Desain (Review Sistem) menunjukkan capaian yang sangat baik dengan achievement 100% dan melampaui target yang telah ditetapkan.</p>
                            <p class="mb-0">Meskipun demikian, capaian yang konsisten tinggi menunjukkan bahwa pengukuran kinerja masih cukup activity-based, sehingga ruang evaluasi terhadap peningkatan kualitas desain masih dapat diperkuat.</p>
                        </div>
                    </div>

                    <!-- Gap Utama Section -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3 fs-6">Gap Utama</h6>
                        <div id="view_gap_utama" class="d-flex flex-column gap-3">
                            <div class="d-flex gap-3 align-items-start">
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 22px; height: 22px; font-weight: 600; font-size: 0.75rem; background-color: #ffe5e5; color: #dc3545;">1</div>
                                <div class="text-dark small text-justify">KPI desain masih lebih berfokus pada penyelesaian task dan kepatuhan timeline, belum sepenuhnya mengukur dampak desain terhadap pengalaman pengguna.</div>
                            </div>
                            <div class="d-flex gap-3 align-items-start">
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 22px; height: 22px; font-weight: 600; font-size: 0.75rem; background-color: #ffe5e5; color: #dc3545;">2</div>
                                <div class="text-dark small text-justify">Evaluasi terhadap efektivitas usability dan user experience setelah implementasi desain masih terbatas.</div>
                            </div>
                            <div class="d-flex gap-3 align-items-start">
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 22px; height: 22px; font-weight: 600; font-size: 0.75rem; background-color: #ffe5e5; color: #dc3545;">3</div>
                                <div class="text-dark small text-justify">Belum terdapat indikator yang mengukur adoption atau kemudahan penggunaan sistem oleh user setelah implementasi desain.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Kendala Saat Ini Section -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3 fs-6">Kendala Saat Ini</h6>
                        <div class="row g-3" id="view_kendala">
                            <div class="col-md-6">
                                <div class="border rounded-2 p-3 h-100 bg-white" style="border-color: #fd7e14 !important; border-width: 1px;">
                                    <h6 class="fw-bold mb-2 text-dark small text-justify"></h6>
                                    <div class="text-secondary small text-justify"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded-2 p-3 h-100 bg-white" style="border-color: #fd7e14 !important; border-width: 1px;">
                                    <h6 class="fw-bold mb-2 text-dark small text-justify"></h6>
                                    <div class="text-secondary small text-justify"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded-2 p-3 h-100 bg-white" style="border-color: #fd7e14 !important; border-width: 1px;">
                                    <h6 class="fw-bold mb-2 text-dark small text-justify"></h6>
                                    <div class="text-secondary small text-justify"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded-2 p-3 h-100 bg-white" style="border-color: #fd7e14 !important; border-width: 1px;">
                                    <h6 class="fw-bold mb-2 text-dark small text-justify"></h6>
                                    <div class="text-secondary small text-justify"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Plan Perbaikan Section -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3 fs-6">Plan Perbaikan</h6>
                        <div class="bg-white border p-3 rounded-2" style="border-color: #f0f0f0 !important; background-color: #fafbfc !important;">
                            <div class="d-flex flex-column gap-3" id="view_plan">
                                <div class="d-flex gap-2 align-items-start">
                                    <div class="text-danger small" style="margin-top: 1px;"><i class="bi bi-bullseye"></i></div>
                                    <div class="text-secondary small text-justify">Menambahkan indikator evaluasi desain yang lebih impact-based, seperti tingkat kemudahan penggunaan sistem atau feedback user terhadap UI/UX.</div>
                                </div>
                                <div class="d-flex gap-2 align-items-start">
                                    <div class="text-danger small" style="margin-top: 1px;"><i class="bi bi-bullseye"></i></div>
                                    <div class="text-secondary small text-justify">Menambahkan indikator evaluasi desain yang lebih impact-based, seperti tingkat kemudahan penggunaan sistem atau feedback user terhadap UI/UX.</div>
                                </div>
                                <div class="d-flex gap-2 align-items-start">
                                    <div class="text-danger small" style="margin-top: 1px;"><i class="bi bi-bullseye"></i></div>
                                    <div class="text-secondary small text-justify">Menambahkan indikator evaluasi desain yang lebih impact-based, seperti tingkat kemudahan penggunaan sistem atau feedback user terhadap UI/UX.</div>
                                </div>
                                <div class="d-flex gap-2 align-items-start">
                                    <div class="text-danger small" style="margin-top: 1px;"><i class="bi bi-bullseye"></i></div>
                                    <div class="text-secondary small text-justify">Menambahkan indikator evaluasi desain yang lebih impact-based, seperti tingkat kemudahan penggunaan sistem atau feedback user terhadap UI/UX.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Target Week Berikutnya Section -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3 fs-6">Target Week Berikutnya</h6>
                        <div id="view_target" class="d-flex flex-column gap-2">
                            <div class="border rounded-2 p-2 px-3 d-flex gap-2 align-items-center bg-white" style="border-color: #0d6efd !important; border-width: 1px; background-color: #f8fbff !important;">
                                <div class="text-primary small"><i class="bi bi-bullseye"></i></div>
                                <div class="text-secondary mb-0 small text-justify">Terdapat mekanisme evaluasi usability setelah implementasi desain.</div>
                            </div>
                            <div class="border rounded-2 p-2 px-3 d-flex gap-2 align-items-center bg-white" style="border-color: #0d6efd !important; border-width: 1px; background-color: #f8fbff !important;">
                                <div class="text-primary small"><i class="bi bi-bullseye"></i></div>
                                <div class="text-secondary mb-0 small text-justify">Adanya feedback user terhadap UI/UX sistem sebagai dasar improvement desain.</div>
                            </div>
                            <div class="border rounded-2 p-2 px-3 d-flex gap-2 align-items-center bg-white" style="border-color: #0d6efd !important; border-width: 1px; background-color: #f8fbff !important;">
                                <div class="text-primary small"><i class="bi bi-bullseye"></i></div>
                                <div class="text-secondary mb-0 small text-justify">KPI desain mulai mengarah pada pengukuran impact terhadap pengalaman pengguna.</div>
                            </div>
                            <div class="border rounded-2 p-2 px-3 d-flex gap-2 align-items-center bg-white" style="border-color: #0d6efd !important; border-width: 1px; background-color: #f8fbff !important;">
                                <div class="text-primary small"><i class="bi bi-bullseye"></i></div>
                                <div class="text-secondary mb-0 small text-justify">KPI desain mulai mengarah pada pengukuran impact terhadap pengalaman pengguna.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Signature -->
                    <div class="d-flex justify-content-between align-items-end mt-4">
                        <div class="text-center bg-white p-3 py-4 rounded-2 d-flex justify-content-center align-items-center" style="border: 1px dashed #ced4da; width: 25%; background-color: #f8f9fa !important;">
                            <img id="view_signature_img" class="img-fluid" src="https://trusmiverse.com/apps/uploads/ttd_digital/ttd_68f6fa8b30265.png" alt="" srcset="">
                        </div>
                        <div class="text-end" style="width: 45%;">
                            <h6 class="fw-bold mb-1" style="font-size: 0.85rem; color: #333;" id="view_signature_name"></h6>
                            <div class="text-secondary mb-1" style="font-size: 0.75rem;" id="view_signature_role"></div>
                            <div class="text-muted" style="font-size: 0.7rem;">Tanggal: <span id="view_signature_date"></span></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Input/Update Review -->
<div class="modal fade" id="modalInputKpiFeedback" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header bg-light border-bottom-0 pt-4 pb-3 px-4">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-pencil-square me-2 text-primary"></i> Input Feedback & Review KPI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 py-3 bg-light bg-opacity-50">
                <form id="formKpiFeedback">
                    <input type="hidden" name="employee_id" id="input_employee_id">
                    <input type="hidden" name="kpi_id" id="input_kpi_id">
                    <input type="hidden" name="kpi_name" id="input_kpi_name">
                    <input type="hidden" name="periode" id="input_periode">
                    <input type="hidden" name="week" id="input_week">
                    <input type="hidden" name="snapshot_achievement" id="input_snapshot_achievement">
                    <input type="hidden" name="snapshot_final_score" id="input_snapshot_final_score">
                    <input type="hidden" name="snapshot_kpi_met" id="input_snapshot_kpi_met">


                    <div class="mb-3">
                        <div class="d-flex gap-2">
                            <span class="fw-bold text-dark fs-6 text-muted mb-1">Employee : </span>
                            <span class="" id="input_employee_name_display"></span>
                        </div>
                        <div class="d-flex gap-2">
                            <span class="fw-bold text-dark fs-6 text-muted mb-1">Week : </span>
                            <span class="" id="input_week_display"></span>
                        </div>
                        <div class="d-flex gap-2">
                            <span class="fw-bold text-dark fs-6 text-muted mb-1">KPI : </span>
                            <span class="" id="input_kpi_name_display"></span>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <div class="border rounded-3 h-100 text-start py-2 bg-white p-3" style="border-color: #e5e7eb !important;">
                                <div class="text-success mb-1 d-flex align-items-center">
                                    <i class="bi bi-graph-up-arrow me-2"></i>
                                    <div class="text-secondary fw-medium mb-1" style="font-size: 0.7rem;">Achievement</div>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark mt-2 fs-4" id="input_kpi_total_achievement_display">0%</h6>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded-3 h-100 text-start py-2 bg-white p-3" style="border-color: #e5e7eb !important;">
                                <div class="text-danger mb-1 d-flex align-items-center">
                                    <i class="bi bi-award-fill me-2"></i>
                                    <div class="text-secondary fw-medium mb-1" style="font-size: 0.7rem;">Final Score</div>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark mt-2 fs-4" id="input_kpi_total_final_score_display">0</h6>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded-3 h-100 text-start py-2 bg-white p-3" style="border-color: #e5e7eb !important;">
                                <div class="text-primary mb-1 d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    <div class="text-secondary fw-medium mb-1" style="font-size: 0.7rem;">KPI Met</div>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark mt-2 fs-4" id="input_kpi_total_met_display">0 / 0</h6>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-sm align-middle text-sm mb-0" style="font-size: 0.85rem;">
                            <thead class="table-light">
                                <tr>
                                    <th>KPI Name</th>
                                    <th class="text-center">Target</th>
                                    <th class="text-center">Aktual</th>
                                    <th class="text-center">Ach</th>
                                    <th class="text-center">Bobot</th>
                                    <th class="text-center">Final Ach</th>
                                    <th class="text-center">Score</th>
                                    <th class="text-center">Final Score</th>
                                    <th class="text-center">Tercapai</th>
                                </tr>
                            </thead>
                            <tbody id="input_kpi_scores_table">
                                <!-- Populated via JS -->
                            </tbody>
                        </table>
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-dark fs-6">Rating (1-5) Keseluruhan <span class="text-danger">*</span></label>
                            <div class="d-flex gap-2 mt-1">
                                <label class="btn btn-outline-warning rating-select-btn fw-bold" data-val="1"><input type="radio" name="rating" value="1" class="d-none" required> <i class="bi bi-star-fill"></i> 1</label>
                                <label class="btn btn-outline-warning rating-select-btn fw-bold" data-val="2"><input type="radio" name="rating" value="2" class="d-none"> <i class="bi bi-star-fill"></i> 2</label>
                                <label class="btn btn-outline-warning rating-select-btn fw-bold" data-val="3"><input type="radio" name="rating" value="3" class="d-none"> <i class="bi bi-star-fill"></i> 3</label>
                                <label class="btn btn-outline-warning rating-select-btn fw-bold" data-val="4"><input type="radio" name="rating" value="4" class="d-none"> <i class="bi bi-star-fill"></i> 4</label>
                                <label class="btn btn-outline-warning rating-select-btn fw-bold" data-val="5"><input type="radio" name="rating" value="5" class="d-none"> <i class="bi bi-star-fill"></i> 5</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold text-dark">Feedback & Review Keseluruhan <span class="text-danger">*</span></label>
                            <textarea class="form-control summernote-editor" name="feedback" id="input_feedback" required></textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold text-dark">Gap Utama</label>
                            <textarea class="form-control summernote-editor" name="gap_utama" id="input_gap_utama"></textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold text-dark">Kendala Saat Ini</label>
                            <p class="text-muted fst-italic">*hint: Enter untuk membuat poin baru</p>
                            <textarea class="form-control summernote-editor" name="kendala_saat_ini" id="input_kendala_saat_ini"></textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold text-dark">Plan Perbaikan</label>
                            <p class="text-muted fst-italic">*hint: Enter untuk membuat poin baru</p>
                            <textarea class="form-control summernote-editor" name="plan_perbaikan" id="input_plan_perbaikan"></textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold text-dark">Target Week Berikutnya</label>
                            <p class="text-muted fst-italic">*hint: Enter untuk membuat poin baru</p>
                            <textarea class="form-control summernote-editor" name="target_week_berikutnya" id="input_target_week_berikutnya"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-top-0 px-4 py-3 gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm py-2 px-3 rounded-2" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-sm py-2 px-3 rounded-2" id="btnSaveKpiFeedback" onclick="saveKpiFeedback()">Simpan Review</button>
            </div>
        </div>
    </div>
</div>