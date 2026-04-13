 <main class="main mainheight">
     <div class="container-fluid p-4">
         <div class="dashboard-wrapper">
             <!-- Search & Filters -->
             <div class="row mb-4">
                 <div class="col-md-4">
                     <input type="text" placeholder="Search" class="search-box">
                 </div>
                 <div class="col-md-5"></div>
                 <div class="col-md-3">
                 <!-- <div class="col-md-8 text-end"> -->
                     <!-- <button class="btn btn-outline-secondary me-2">All time ×</button>
                     <button class="btn btn-outline-secondary">More filters</button> -->
                     <form method="POST" id="form_filter">
                        <div class="input-group input-group-md reportrange">
                            <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                            <input type="hidden" name="start" value="" id="start" readonly />
                            <input type="hidden" name="end" value="" id="end" readonly />
                            <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
                        </div>
                    </form>
                    <!-- <input type="month" class="form-control" id="periode" name="periode" value="2025-09"> -->
                 </div>

                <div class="col-md-4 d-none" style="margin-left: 0px;">
                    <form id="form_filterx">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-12 input-group date" id="datetimepicker9" style="padding-right: 10px;">
                                    <input type="text" class="form-control" value="2025-09" name="periode" id="periode" placeholder="2025-09">
                                    <!-- <input type="hidden" name="period" id="period" value="" readonly> -->
                                    <button type="button" class="btn btn-info btn-outline-info" id="filter_period">
                                        <span class="">filterr</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

             </div>

             <!-- Dashboard Cards -->
             <div class="row g-4 align-items-stretch">
                 <!-- Traffic System Overview -->
                 <div class="col-md-3">
                     <!-- <div class="card text-center h-100">
                        <h6>Traffic System Overview</h6>
                        <canvas id="gaugeChart" height="180"></canvas>
                        <h4 class="mt-3">77% <small class="text-success">▲ 2%</small></h4>
                        <small>(441/575)</small>
                        <p class="text-muted small mb-0 mt-auto">Often • Not Used</p>
                    </div> -->

                     <!-- <div class="card text-center h-100 d-flex flex-column justify-content-center">
                        <h6 class="mb-2">Traffic System Overview</h6>
                        <div>
                            <span class="badge bg-success px-3 py-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-arrow-up me-1" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 12a.5.5 0 0 0 .5-.5V4.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4-.007-.007a.498.498 0 0 0-.7.007l-4 4a.5.5 0 0 0 .708.708L7.5 4.707V11.5a.5.5 0 0 0 .5.5z" />
                                </svg>
                                2%
                            </span>
                        </div>
                        <canvas id="gaugeChart" height="180"></canvas>
                        <div class="mt-2 small">
                            <span class="text-primary">● Often</span>
                            <span class="text-secondary ms-3">● Not Used</span>
                        </div>
                    </div> -->

                     <div class="card text-center h-100">
                         <h6>Traffic System Overview</h6>
                         <canvas id="gaugeChart" height="180"></canvas>
                         <div class="mt-3 small">
                             <span class="text-primary">● Often</span>
                             <span class="text-secondary ms-3">● Not Used</span>
                         </div>
                     </div>
                 </div>

                 <!-- Line Chart -->
                 <div class="col-md-3">
                     <div class="card h-100">
                         <h6>Chart Traffic</h6>
                         <canvas id="trafficChart" height="180"></canvas>
                         <div class="mt-2 small mt-auto">
                             <span class="text-primary">● Sering</span>
                             <span class="text-secondary ms-3">● Jarang</span>
                             <span class="text-danger ms-3">● Tidak Sama Sekali</span>
                         </div>
                     </div>
                 </div>

                 <!-- Progress Review -->
                 <div class="col-md-3">
                     <div class="card h-100">
                         <h6>Progress Review System</h6>
                         <div class="d-flex align-items-center flex-grow-1">
                             <!-- <div class="progress-circle me-3">30%</div> -->
                              <canvas id="progressChart" width="150" height="150"></canvas>
                             <div class="ms-4 flex-grow-2">
                                 <p class="mb-1">Kepuasan: <span id="p_kepuasan"></span>%</p>
                                 <div class="progress mb-2" style="height:6px;">
                                     <div class="progress-bar bg-primary" style="width: 30%"></div>
                                 </div>
                                 <p class="mb-1">Kesesuaian: <span id="p_kesesuaian"></span>%</p>
                                 <div class="progress" style="height:6px;">
                                     <div class="progress-bar bg-success" style="width: 30%"></div>
                                 </div>
                             </div>
                         </div>
                         <div class="mt-auto">
                             <small class="text-primary" style="margin-right: 22px;">● Reviewed</small>
                             <small class="text-muted ms-5">● Belum Review</small>
                         </div>
                         <div class="mt-auto">
                             <small class="text-muted" style="font-size: smaller;" id="list_reviewed"></small>
                             <small class="text-muted ms-3" style="font-size: smaller;" id="list_not_reviewed"></small>
                         </div>
                     </div>
                 </div>

                 <!-- User Satisfaction -->
                 <div class="col-md-3">
                    <div class="kepuasan-card h-100">
                        <div class="kepuasan-left">
                            <h5>Kepuasan Pengguna</h5>
                            <div class="detail-box">
                                <table>
                                    <tbody id="list_kepuasan">
                                        <!-- <tr><td>UI</td><td>3,94</td></tr>
                                        <tr><td>Kecepatan</td><td>3,94</td></tr>
                                        <tr><td>Akurasi</td><td>3,94</td></tr>
                                        <tr><td>Kesesuaian</td><td>3,94</td></tr>
                                        <tr><td>Relevansi</td><td>3,94</td></tr>
                                        <tr><td>Efisien</td><td>3,94</td></tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    
                        <div class="kepuasan-right">
                            <canvas id="kepuasanChart" style="margin-top: 20px;"></canvas>
                            <div class="chart-text">
                                <h2>3,94</h2>
                                <p>Tingkat kepuasan dari total <b>65</b> Review, <b>464</b> Responden</p>
                            </div>
                        </div>
                    </div>
                     <!-- <div class="card h-100">
                         <h6>Kepuasan Pengguna</h6>
                         <table class="table table-sm mb-0">
                             <tbody>
                                 <tr>
                                     <td>UI</td>
                                     <td>3,94</td>
                                 </tr>
                                 <tr>
                                     <td>Kecepatan</td>
                                     <td>3,94</td>
                                 </tr>
                                 <tr>
                                     <td>Akuarasi</td>
                                     <td>3,94</td>
                                 </tr>
                                 <tr>
                                     <td>Kesesuaian</td>
                                     <td>3,94</td>
                                 </tr>
                                 <tr>
                                     <td>Relevansi</td>
                                     <td>3,94</td>
                                 </tr>
                                 <tr>
                                     <td>Efisien</td>
                                     <td>3,94</td>
                                 </tr>
                             </tbody>
                         </table>
                         <div class="text-center mt-3 mt-auto">
                             <h4>3,94</h4>
                             <small>Tingkat kepuasan dari total 65 Review, 464 Responden</small>
                         </div>
                     </div> -->
                 </div>
             </div>
         </div>

         <!-- Row untuk tabel -->
         <div class="row mt-4">
             <div class="col-md-6">
                 <div class="table-card">
                     <h6 class="mb-3 fw-bold">Traffic System Overview</h6>
                     <table id="dt_traffic_system" class="table mb-0">
                         <thead>
                             <tr>
                                 <th>Divisi</th>
                                 <th>Sistem & Traffic</th>
                                 <th>Kepuasan</th>
                                 <th>Kesesuaian</th>
                                 <th>Rating</th>
                                 <th>Score</th>
                             </tr>
                         </thead>
                         <tbody>
                             <!-- <tr>
                                 <td><strong>Sales</strong></td>
                                 <td><span class="text-blue">69</span>/82 sistem <br> <span class="badge-status badge-yellow">60% Jarang</span></td>
                                 <td>80% <br><small>Puas</small></td>
                                 <td>80% <br><small>Puas</small></td>
                                 <td>80% <br><small>Puas</small></td>
                                 <td><span class="badge-status badge-green">80%</span></td>
                             </tr>
                             <tr>
                                 <td><strong>Analys</strong></td>
                                 <td><span class="text-blue">69</span>/82 sistem <br> <span class="badge-status badge-green">60% Sering</span></td>
                                 <td>70% <br><small>Cukup Puas</small></td>
                                 <td>70% <br><small>Cukup Puas</small></td>
                                 <td>70% <br><small>Cukup Puas</small></td>
                                 <td><span class="badge-status badge-yellow">70% Puas</span></td>
                             </tr>
                             <tr>
                                 <td><strong>Perencana</strong></td>
                                 <td><span class="text-blue">69</span>/82 sistem <br> <span class="badge-status badge-red">70% Tidak Digunakan</span></td>
                                 <td>70% <br><small>Cukup Puas</small></td>
                                 <td>70% <br><small>Cukup Puas</small></td>
                                 <td>70% <br><small>Cukup Puas</small></td>
                                 <td><span class="badge-status badge-yellow">70% Puas</span></td>
                             </tr>
                             <tr>
                                 <td><strong>Purchasing</strong></td>
                                 <td><span class="text-blue">69</span>/82 sistem <br> <span class="badge-status badge-green">60% Sering</span></td>
                                 <td>80% <br><small>Puas</small></td>
                                 <td>80% <br><small>Puas</small></td>
                                 <td>80% <br><small>Puas</small></td>
                                 <td><span class="badge-status badge-green">80% Puas</span></td>
                             </tr>
                             <tr>
                                 <td><strong>Project</strong></td>
                                 <td><span class="text-blue">69</span>/82 sistem <br> <span class="badge-status badge-yellow">60% Jarang</span></td>
                                 <td>40% <br><small>Tidak Puas</small></td>
                                 <td>40% <br><small>Tidak Puas</small></td>
                                 <td>40% <br><small>Tidak Puas</small></td>
                                 <td><span class="badge-status badge-red">40% Puas</span></td>
                             </tr>
                             <tr>
                                 <td><strong>Finance</strong></td>
                                 <td><span class="text-blue">69</span>/82 sistem <br> <span class="badge-status badge-green">60% Sering</span></td>
                                 <td>80% <br><small>Puas</small></td>
                                 <td>80% <br><small>Puas</small></td>
                                 <td>80% <br><small>Puas</small></td>
                                 <td><span class="badge-status badge-yellow">70% Puas</span></td>
                             </tr>
                             <tr>
                                 <td><strong>Admin Marketing</strong></td>
                                 <td><span class="text-blue">69</span>/82 sistem <br> <span class="badge-status badge-yellow">60% Jarang</span></td>
                                 <td>40% <br><small>Tidak Puas</small></td>
                                 <td>40% <br><small>Tidak Puas</small></td>
                                 <td>40% <br><small>Tidak Puas</small></td>
                                 <td><span class="badge-status badge-red">40% Puas</span></td>
                             </tr> -->
                         </tbody>
                     </table>

                     <!-- Pagination -->
                     <div class="d-flex justify-content-between align-items-center mt-3">
                         <div>
                             <button class="btn btn-outline-secondary btn-sm">Previous</button>
                             <button class="btn btn-outline-secondary btn-sm">Next</button>
                         </div>
                         <small>Page 1 of 10</small>
                     </div>
                 </div>
             </div>
             <div class="col-md-6">
                 <!-- Tabel Ticket Per Divisi -->
                 <div class="table-card table-responsive" style="paddingx: 20px;">
                     <h6 class="mb-3">Ticket Per Divisi</h6>
                     <table id="dt_ticket_perdivisi" class="table align-middle">
                         <thead>
                             <tr>
                                 <th style="width: 300px;">Divisi</th>
                                 <th>Pengajuan</th>
                                 <th>Not Started</th>
                                 <th>Progress</th>
                                 <th>UAT</th>
                                 <th>Done</th>
                                 <th>Cancel</th>
                                 <th>Hold</th>
                                 <th>Waiting</th>
                             </tr>
                         </thead>
                         <tbody>
                             <tr>
                                 <td><strong>Sales</strong><br><br></td>
                                 <td>10</td>
                                 <td>
                                     <span class="text-primary">24</span>/<span class="text-muted">40</span> On Progress
                                     <div class="progressx mt-1" style="height:6px;">
                                         <div class="progress-barx bg-info" style="width: 60%"></div>
                                     </div>
                                 </td>
                                 <td>80%</td>
                                 <td>80%</td>
                                 <td>80%</td>
                                 <td>80%</td>
                             </tr>
                             <tr>
                                 <td><strong>Analys</strong></td>
                                 <td>14</td>
                                 <td>
                                     <span class="text-primary">24</span>/<span class="text-muted">40</span> On Progress
                                     <div class="progress mt-1" style="height:6px;">
                                         <div class="progress-bar bg-info" style="width: 60%"></div>
                                     </div>
                                 </td>
                                 <td>70%</td>
                                 <td>70%</td>
                                 <td>70%</td>
                                 <td>70%</td>
                             </tr>
                             <tr>
                                 <td><strong>Perencana</strong></td>
                                 <td>12</td>
                                 <td>
                                     <span class="text-primary">24</span>/<span class="text-muted">40</span> On Progress
                                     <div class="progress mt-1" style="height:6px;">
                                         <div class="progress-bar bg-info" style="width: 60%"></div>
                                     </div>
                                 </td>
                                 <td>80%</td>
                                 <td>80%</td>
                                 <td>80%</td>
                                 <td>80%</td>
                             </tr>
                             <tr>
                                 <td><strong>Purchasing</strong></td>
                                 <td>10</td>
                                 <td>
                                     <span class="text-primary">24</span>/<span class="text-muted">40</span> On Progress
                                     <div class="progress mt-1" style="height:6px;">
                                         <div class="progress-bar bg-info" style="width: 60%"></div>
                                     </div>
                                 </td>
                                 <td>70%</td>
                                 <td>70%</td>
                                 <td>70%</td>
                                 <td>70%</td>
                             </tr>
                             <tr>
                                 <td><strong>Project</strong></td>
                                 <td>14</td>
                                 <td>
                                     <span class="text-primary">24</span>/<span class="text-muted">40</span> On Progress
                                     <div class="progress mt-1" style="height:6px;">
                                         <div class="progress-bar bg-info" style="width: 60%"></div>
                                     </div>
                                 </td>
                                 <td>80%</td>
                                 <td>80%</td>
                                 <td>80%</td>
                                 <td>80%</td>
                             </tr>
                             <tr>
                                 <td><strong>Finance</strong></td>
                                 <td>19</td>
                                 <td>
                                     <span class="text-primary">24</span>/<span class="text-muted">40</span> On Progress
                                     <div class="progress mt-1" style="height:6px;">
                                         <div class="progress-bar bg-info" style="width: 60%"></div>
                                     </div>
                                 </td>
                                 <td>70%</td>
                                 <td>70%</td>
                                 <td>70%</td>
                                 <td>70%</td>
                             </tr>
                             <tr>
                                 <td><strong>Admin Marketing</strong></td>
                                 <td>20</td>
                                 <td>
                                     <span class="text-primary">24</span>/<span class="text-muted">40</span> On Progress
                                     <div class="progress mt-1" style="height:6px;">
                                         <div class="progress-bar bg-info" style="width: 60%"></div>
                                     </div>
                                 </td>
                                 <td>80%</td>
                                 <td>80%</td>
                                 <td>80%</td>
                                 <td>80%</td>
                             </tr>
                         </tbody>
                     </table>

                     <!-- Pagination -->
                     <div class="d-flex justify-content-between align-items-center mt-3">
                         <div>
                             <button class="btn btn-outline-secondary btn-sm">Previous</button>
                             <button class="btn btn-outline-secondary btn-sm">Next</button>
                         </div>
                         <span class="text-muted small">Page 1 of 10</span>
                     </div>
                 </div>

             </div>
         </div>

         <div class="row mt-4">
             <!-- Statistik Progres Tiket -->
             <div class="col-md-3">
                 <div class="ticket-card">
                     <h5>Statistik Progres Tiket</h5>
                     <!-- <canvas id="progressGauge" height="200"></canvas> -->
                        <div style="display: flex; justify-content: center; align-items: center; height: 200px;">
                          <canvas id="progressChartTicket" width="150" height="150"></canvas>
                        </div>

                     <div class="mt-2" style="color: #fff;">
                         <div class="total-tickets" id="spt_total_tiket">0</div>
                         <small>Total Tiket IT Team</small>
                     </div>

                     <div class="mt-3" style="color: #fff;">
                         <div class="d-flex justify-content-between align-items-center mb-2">
                             <div>
                                 <span class="me-2" style="color: #757575ff;">●</span> On Progress <br>
                                 <small><span id="spt_total_tiket_progres">0</span> Ticket</small>
                             </div>
                             <span class="badge-custom" style="background-color: rgba(246, 243, 234, 0.6); color: #f0ad4e;"><span id="spt_persen_progres"></span>%</span>
                         </div>
                         <div class="d-flex justify-content-between align-items-center">
                             <div>
                                 <span class="me-2" style="color:#28a745;">●</span> Done <br>
                                 <small><span id="spt_total_tiket_done">0</span> Ticket</small>
                             </div>
                             <span class="badge-custom" style="background-color: rgba(220, 235, 224, 0.6); color: #28a745;"><span id="spt_persen_done">0</span>%</span>
                         </div>
                     </div>
                 </div>
             </div>

             <!-- Resume Ticket By PIC -->
             <div class="col-md-6">
                 <div class="card table-resume-pic p-3">
                     <h6 class="mb-3">Resume Ticket By PIC</h6>
                     <table id="dt_resume_ticket_by_pic" class="table table-borderless align-middle">
                         <thead>
                             <tr>
                                 <th>PIC</th>
                                 <th>Total Ticket</th>
                                 <th>Ticket Done</th>
                                 <th>%Ticket</th>
                                 <th>%Done</th>
                                 <th>%Leadtime</th>
                             </tr>
                         </thead>
                         <tbody>
                             <tr>
                                 <td><strong>Fuji</strong></td>
                                 <td>40</td>
                                 <td>37</td>
                                 <td>90%</td>
                                 <td>
                                     <span class="text-primary">98% Good</span>
                                     <div class="progress mt-1" style="height:6px;">
                                         <div class="progress-bar bg-gradient" style="width: 98%;"></div>
                                     </div>
                                 </td>
                                 <td>80%</td>
                             </tr>
                             <tr>
                                 <td><strong>Lutfie</strong></td>
                                 <td>30</td>
                                 <td>28</td>
                                 <td>90%</td>
                                 <td>
                                     <span class="text-primary">98% Good</span>
                                     <div class="progress mt-1" style="height:6px;">
                                         <div class="progress-bar bg-gradient" style="width: 98%;"></div>
                                     </div>
                                 </td>
                                 <td>70%</td>
                             </tr>
                             <tr>
                                 <td><strong>Ambar</strong></td>
                                 <td>40</td>
                                 <td>37</td>
                                 <td>90%</td>
                                 <td>
                                     <span class="text-primary">98% Good</span>
                                     <div class="progress mt-1" style="height:6px;">
                                         <div class="progress-bar bg-gradient" style="width: 98%;"></div>
                                     </div>
                                 </td>
                                 <td>70%</td>
                             </tr>
                             <tr>
                                 <td><strong>Bahrul</strong></td>
                                 <td>23</td>
                                 <td>20</td>
                                 <td>90%</td>
                                 <td>
                                     <span class="text-primary">98% Good</span>
                                     <div class="progress mt-1" style="height:6px;">
                                         <div class="progress-bar bg-gradient" style="width: 98%;"></div>
                                     </div>
                                 </td>
                                 <td>80%</td>
                             </tr>
                             <tr>
                                 <td><strong>Aris</strong></td>
                                 <td>22</td>
                                 <td>19</td>
                                 <td>85%</td>
                                 <td>
                                     <span class="text-primary">98% Good</span>
                                     <div class="progress mt-1" style="height:6px;">
                                         <div class="progress-bar bg-gradient" style="width: 98%;"></div>
                                     </div>
                                 </td>
                                 <td>40%</td>
                             </tr>
                         </tbody>
                     </table>

                     <!-- Pagination -->
                     <div class="d-flex justify-content-between align-items-center mt-3">
                         <div>
                             <button class="btn btn-outline-secondary btn-sm">Previous</button>
                             <button class="btn btn-outline-secondary btn-sm">Next</button>
                         </div>
                         <small class="text-muted">Page 1 of 10</small>
                     </div>
                 </div>
             </div>

             <!-- Tracking System Error Card -->
             <div class="col-md-3">
                 <div class="tracking-card">
                     <h5>Tracking System Error</h5>
                     <h5 class="error-percentage"><span id="persen_solved"></span>%</h5>
                     <div class="progress-section">
                         <div class="progress-bar">
                             <div class="progress-fill"></div>
                         </div>
                         <span class="done-info"><span id="total_solved">0</span>/<span id="total_error">0</span> DONE</span>
                     </div>

                     <!-- Scrollable Error List -->
                     <div class="error-list">
                         <!-- <div class="error-item">
                             <div class="error-header">
                                 <h5>Tidak bisa input</h5>
                                 <span class="badge urgent">Urgent Priority</span>
                             </div>
                             <p class="error-date">19 Juli - 15:30 WIB</p>
                             <div class="error-meta">
                                 <div>👤 User: <strong>Budi Sudarsono</strong></div>
                                 <div>🧑‍💼 PIC: <strong>Muhammad Ade Kurnia</strong></div>
                                 <div>⚡ Status: <span class="statusx progressx badge blue">Progress</span></div>
                             </div>
                         </div> -->

                         <!-- <div class="error-item">
                             <div class="error-header">
                                 <h5>Tidak bisa input</h5>
                                 <span class="badge urgent">Urgent Priority</span>
                             </div>
                             <p class="error-date">19 Juli - 15:30 WIB</p>
                             <div class="error-meta two-column">
                                 <div class="meta-row">
                                     <span class="meta-label">👤 User:</span>
                                     <span class="meta-value"><strong>Budi Sudarsono</strong></span>
                                 </div>
                                 <div class="meta-row">
                                     <span class="meta-label">🧑‍💼 PIC:</span>
                                     <span class="meta-value"><strong>Muhammad Ade Kurnia</strong></span>
                                 </div>
                                 <div class="meta-row">
                                     <span class="meta-label">⚡ Status:</span>
                                     <span class="meta-value"><span class="badge blue">Progress</span></span>
                                 </div>
                             </div>
                         </div> -->

                         <!-- <div class="error-item">
                             <div class="error-header">
                                 <h5>Tidak bisa input</h5>
                                 <span class="badge normal">Normal Priority</span>
                             </div>
                             <p class="error-date">19 Juli - 15:30 WIB</p>
                             <div class="error-meta two-column">
                                 <div class="meta-row">
                                     <span class="meta-label">👤 User:</span>
                                     <span class="meta-value"><strong>Madun Saputra</strong></span>
                                 </div>
                                 <div class="meta-row">
                                     <span class="meta-label">🧑‍💼 PIC:</span>
                                     <span class="meta-value"><strong>Fujiyanto Hasan</strong></span>
                                 </div>
                                 <div class="meta-row">
                                     <span class="meta-label">⚡ Status:</span>
                                     <span class="meta-value"><span class="badge blue">Progress</span></span>
                                 </div>
                             </div>
                         </div> -->

                         <!-- <div class="error-item">
                             <div class="error-header">
                                 <h5>Tidak bisa input</h5>
                                 <span class="badge urgent">Urgent</span>
                             </div>
                             <p class="error-date">19 Juli - 15:30 WIB</p>
                             <div class="error-meta two-column">
                                 <div class="meta-row">
                                     <span class="meta-label">👤 User:</span>
                                     <span class="meta-value"><strong>Nama User</strong></span>
                                 </div>
                                 <div class="meta-row">
                                     <span class="meta-label">🧑‍💼 PIC:</span>
                                     <span class="meta-value"><strong>Nama PIC</strong></span>
                                 </div>
                                 <div class="meta-row">
                                     <span class="meta-label">⚡ Status:</span>
                                     <span class="meta-value"><span class="badge blue">Progress</span></span>
                                 </div>
                             </div>
                         </div> -->
                     </div>
                 </div>

             </div>
         </div>
     </div>
 </main>