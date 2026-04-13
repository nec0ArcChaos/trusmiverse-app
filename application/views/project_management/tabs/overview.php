 <div class="d-flex align-items-center justify-content-center">
     <div class="col-12 col-xl-10 col-lg-10 col-md-10">
         <div class="row">
             <div class="col-12 col-md-4">
                 <div class="card border-0 shadow-sm rounded-4 w-100 text-start h-100">
                     <div class="card-body p-4">
                         <div class="d-flex align-items-start mb-4">
                             <div class="bg-primary-soft text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; min-width: 48px;">
                                 <i class="bi bi-bar-chart-line fs-4"></i>
                             </div>
                             <div>
                                 <h6 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">Rata-rata Progres Mingguan</h6>
                                 <p class="text-muted small mb-0" style="font-size: 0.75rem; line-height: 1.4;">Lihat tren persentase penyelesaian tugas per minggu</p>
                             </div>
                         </div>

                         <div class="mb-4">
                             <div class="d-flex justify-content-between align-items-end mb-2">
                                 <span class="text-muted fw-semibold small d-block mb-1" style="font-size: 0.75rem;">Avg%</span>
                                 <span id="avg-week-percent" class="badge bg-success-soft text-success rounded-pill px-2 py-1 fs-6 fw-bold">0%</span>
                             </div>
                             <div class="progress" style="height: 6px; border-radius: 100px;">
                                 <div id="avg-week-progress" class="progress-bar bg-success" role="progressbar" style="width: 0%; border-radius: 100px;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                             </div>
                         </div>

                         <div id="weekly-progress-container" class="d-flex flex-column gap-3 mt-2">
                             <!-- Weeks data will be rendered here -->
                         </div>
                     </div>
                 </div>
             </div>

             <div class="col-12 col-md-4">
                 <div class="card border-0 shadow-sm rounded-4 w-100 text-start h-100">
                     <div class="card-body p-4 d-flex flex-column">
                         <div class="d-flex align-items-start mb-4">
                             <div class="bg-light text-secondary border rounded text-center d-flex align-items-center justify-content-center me-3" style="width: 44px; height: 44px; min-width: 44px;">
                                 <i class="bi bi-clipboard-data fs-5"></i>
                             </div>
                             <div>
                                 <h6 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">Ringkasan Pekerjaan</h6>
                                 <p class="text-muted small mb-0" style="font-size: 0.75rem; line-height: 1.4;">Akumulasi seluruh Task dan tingkat penyelesaiannya</p>
                             </div>
                         </div>

                         <div class="bg-light bg-opacity-50 border rounded-4 p-3 mb-0 flex-grow-1">
                             <h2 id="summary-overall-percent" class="display-5 fw-bold text-dark mb-0">0%</h2>
                             <p class="text-muted small mb-3">Capaian Task Ontime</p>

                             <hr class="border-secondary border-dashed my-3 opacity-25">

                             <div class="d-flex flex-column gap-3 mt-3">
                                 <div class="d-flex align-items-center justify-content-between">
                                     <span class="text-muted small" style="font-size: 0.8rem;">Ontime Tasks: <span id="summary-ontime-total" class="fw-bold text-dark">0</span></span>
                                     <div class="d-flex align-items-center" style="width: 50%;">
                                         <div class="progress flex-grow-1 position-relative overflow-visible rounded-pill" style="height: 8px;">
                                             <div id="summary-ontime-progress" class="progress-bar bg-success rounded-pill" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                             <div class="bg-white border border-success border-2 rounded-circle position-absolute" style="width: 14px; height: 14px; right: 0; top: 50%; transform: translateY(-50%);"></div>
                                         </div>
                                         <span id="summary-ontime-percent" class="ms-3 fw-bold text-dark" style="font-size: 0.8rem; min-width: 30px;">0%</span>
                                     </div>
                                 </div>

                                 <div class="d-flex align-items-center justify-content-between mt-2 mb-1">
                                     <span class="text-muted small" style="font-size: 0.8rem;">Late Tasks: <span id="summary-late-total" class="fw-bold text-dark">0</span></span>
                                     <div class="d-flex align-items-center" style="width: 50%;">
                                         <div class="progress flex-grow-1 position-relative overflow-visible rounded-pill" style="height: 8px;">
                                             <div id="summary-late-progress" class="progress-bar bg-warning rounded-pill" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                             <div class="bg-white border border-warning border-2 rounded-circle position-absolute" style="width: 14px; height: 14px; right: 0; top: 50%; transform: translateY(-50%);"></div>
                                         </div>
                                         <span id="summary-late-percent" class="ms-3 fw-bold text-dark" style="font-size: 0.8rem; min-width: 30px;">0%</span>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-12 col-md-4">
                 <div class="card border-0 shadow-sm rounded-4 w-100 text-start h-100">
                     <div class="card-body p-4 d-flex flex-column">
                         <div class="d-flex align-items-start mb-4">
                             <div class="bg-light text-secondary border rounded text-center d-flex align-items-center justify-content-center me-3" style="width: 44px; height: 44px; min-width: 44px;">
                                 <i class="bi bi-pie-chart fs-5"></i>
                             </div>
                             <div>
                                 <h6 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">Task by Status</h6>
                                 <p class="text-muted small mb-0" style="font-size: 0.75rem; line-height: 1.4;">Proporsi tugas berdasarkan status pengerjaannya</p>
                             </div>
                         </div>

                         <div id="task-by-status-chart" class="w-100 h-100"></div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>