 <main class="main mainheight">
     <div class="container-fluid p-4 bg-container">
         <!-- Tabs at top center -->
         <ul class="nav nav-tabs pt-3">
             <li class="nav-item">
                 <button class="nav-link active" data-bs-toggle="tab" type="button">Overview</button>
             </li>
             <li class="nav-item">
                 <button class="nav-link" data-bs-toggle="tab" type="button">Operasional</button>
             </li>
             <li class="nav-item">
                 <button class="nav-link" data-bs-toggle="tab" type="button">Marketing</button>
             </li>
             <li class="nav-item">
                 <button class="nav-link" data-bs-toggle="tab" type="button">Produksi</button>
             </li>
         </ul>

         <!-- Row judul & KPI cards sejajar -->
         <div class="row g-3 py-4">
             <!-- Judul sejajar dengan KPI Cards -->
             <div class="col-md-3 d-flex flex-column justify-content-center">
                 <h3 class="fw-bold mb-1">Dashboard KPI BT</h3>
                 <p class="text-muted mb-0">Tinjauan eksekutif atas metrik utama</p>
             </div>

             <div class="col-md-3">
                 <div class="kpi-card">
                     <div class="d-flex justify-content-between align-items-start">
                         <div class="kpi-icon">
                             <span class="text-warning fs-4">⟳</span>
                         </div>
                         <span class="status status-green">Sesuai Target</span>
                     </div>
                     <p class="mt-3 mb-1 text-muted">KPI Skor Operasional</p>
                     <!-- KPI value & change sejajar -->
                     <div class="d-flex justify-content-between align-items-end">
                         <div class="kpi-value">83.56%</div>
                         <div class="kpi-change">↑ 8% Compared to last month</div>
                     </div>
                 </div>
             </div>

             <div class="col-md-3">
                 <div class="kpi-card">
                     <div class="d-flex justify-content-between align-items-start">
                         <div class="kpi-icon">
                             <span class="text-warning fs-4">⟳</span>
                         </div>
                         <span class="status status-red">Perlu Perbaikan</span>
                     </div>
                     <p class="mt-3 mb-1 text-muted">KPI Skor Marketing</p>
                     <div class="d-flex justify-content-between align-items-end">
                         <div class="kpi-value">55.30%</div>
                         <div class="kpi-change">↑ 8% Compared to last month</div>
                     </div>
                 </div>
             </div>

             <div class="col-md-3">
                 <div class="kpi-card">
                     <div class="d-flex justify-content-between align-items-start">
                         <div class="kpi-icon">
                             <span class="text-warning fs-4">⟳</span>
                         </div>
                         <span class="status status-green">Sesuai Target</span>
                     </div>
                     <p class="mt-3 mb-1 text-muted">KPI Skor Produksi</p>
                     <div class="d-flex justify-content-between align-items-end">
                         <div class="kpi-value">89.10%</div>
                         <div class="kpi-change">↑ 8% Compared to last month</div>
                     </div>
                 </div>
             </div>
         </div>

         <!-- Tambahkan setelah row KPI Cards -->
         <div class="row g-3">
             <!-- Chart kiri col-8 -->
             <div class="col-md-8">
                <!-- background-color: rgba(255,255,255,0.7); backdrop-filter: blur(6px); -->
                 <div class="card h-100 p-3" style="background-color: rgba(255,255,255,0.2); backdrop-filter: blur(6px);border-radius:1rem;box-shadow:0 0 8px rgba(0,0,0,0.05);">
                     <h5 class="fw-bold mb-3">Chart Trend Progress Divisi</h5>
                     <canvas id="trendChart" height="250"></canvas>
                     <div class="mt-3 d-flex gap-4">
                         <div class="d-flex align-items-center">
                             <span class="me-2 rounded-circle" style="width:10px;height:10px;background:#ff4d4d;"></span> Operational
                         </div>
                         <div class="d-flex align-items-center">
                             <span class="me-2 rounded-circle" style="width:10px;height:10px;background:#9b59b6;"></span> Marketing
                         </div>
                         <div class="d-flex align-items-center">
                             <span class="me-2 rounded-circle" style="width:10px;height:10px;background:#3498db;"></span> Production
                         </div>
                     </div>
                 </div>
             </div>

             <!-- Chart kanan col-4 -->
             <div class="col-md-4">
                 <!-- <div class="card h-100 p-3" style="background-color: #fff7f0;border-radius:1rem;box-shadow:0 0 8px rgba(0,0,0,0.05);"> -->
                 <div class="card h-100 p-3" style="background-color: rgba(255,255,255,0.2); backdrop-filter: blur(6px);border-radius:1rem;box-shadow:0 0 8px rgba(0,0,0,0.05);">
                     <!-- Tab judul kanan -->
                     <ul class="nav nav-tabs mb-3" id="kpiTab" role="tablist">
                         <li class="nav-item" role="presentation">
                             <button class="nav-link active fw-bold text-orange" id="top-tab" data-bs-toggle="tab" data-bs-target="#topKpi" type="button" role="tab">Top 5 KPI Insight</button>
                         </li>
                         <li class="nav-item" role="presentation">
                             <button class="nav-link fw-bold" id="bottom-tab" data-bs-toggle="tab" data-bs-target="#bottomKpi" type="button" role="tab">Bottom 5 KPI Insight</button>
                         </li>
                     </ul>

                     <div class="tab-content">
                         <!-- Top KPI -->
                         <div class="tab-pane fade show active" id="topKpi" role="tabpanel">
                             <!-- KPI 1 -->
                             <div class="mb-4 d-flex justify-content-between align-items-center">
                                 <div class="progress flex-grow-1 me-2" style="height:30px;background:#fde7d3;">
                                     <div class="progress-bar" role="progressbar"
                                         style="width:100%;background:#f97316; text-align: left; padding-left: 5px;">
                                         Revenue Sales
                                     </div>
                                 </div>
                                 <span>100%</span>
                             </div>

                             <!-- KPI 2 -->
                             <div class="mb-4 d-flex justify-content-between align-items-center">
                                 <div class="progress flex-grow-1 me-2" style="height:30px;background:#fde7d3;">
                                     <div class="progress-bar" role="progressbar"
                                         style="width:90%;background:#f97316; text-align: left; padding-left: 5px;">
                                         Cost
                                     </div>
                                 </div>
                                 <span>90%</span>
                             </div>

                             <!-- KPI 3 -->
                             <div class="mb-4 d-flex justify-content-between align-items-center">
                                 <div class="progress flex-grow-1 me-2" style="height:30px;background:#fde7d3;">
                                     <div class="progress-bar" role="progressbar"
                                         style="width:80%;background:#f97316; text-align: left; padding-left: 5px;">
                                         Production Quality
                                     </div>
                                 </div>
                                 <span>80%</span>
                             </div>

                             <!-- KPI 4 -->
                             <div class="mb-4 d-flex justify-content-between align-items-center">
                                 <div class="progress flex-grow-1 me-2" style="height:30px;background:#fde7d3;">
                                     <div class="progress-bar" role="progressbar"
                                         style="width:100%;background:#f97316; text-align: left; padding-left: 5px;">
                                         E-commerce (Operational)
                                     </div>
                                 </div>
                                 <span>100%</span>
                             </div>

                             <!-- KPI 5 -->
                             <div class="mb-4 d-flex justify-content-between align-items-center">
                                 <div class="progress flex-grow-1 me-2" style="height:30px;background: #fff7f0;">
                                     <div class="progress-bar" role="progressbar"
                                         style="width:63%;background: #fde7d3; text-align: left; padding-left: 5px;">
                                         Reduce HPP
                                     </div>
                                 </div>
                                 <span>63%</span>
                             </div>
                         </div>

                         <!-- Bottom KPI -->
                         <div class="tab-pane fade" id="bottomKpi" role="tabpanel">
                             <!-- KPI 1 -->
                             <div class="mb-4 d-flex justify-content-between align-items-center">
                                 <div class="progress flex-grow-1 me-2" style="height:30px;background:#fde7d3;">
                                     <div class="progress-bar" role="progressbar"
                                         style="width:25%;background:#f97316; text-align: left; padding-left: 5px;">
                                         Customer Complaint
                                     </div>
                                 </div>
                                 <span>25%</span>
                             </div>

                             <!-- KPI 2 -->
                             <div class="mb-4 d-flex justify-content-between align-items-center">
                                 <div class="progress flex-grow-1 me-2" style="height:30px;background:#fde7d3;">
                                     <div class="progress-bar" role="progressbar"
                                         style="width:30%;background:#f97316; text-align: left; padding-left: 5px;">
                                         Return Items
                                     </div>
                                 </div>
                                 <span>30%</span>
                             </div>

                             <!-- KPI 3 -->
                             <div class="mb-4 d-flex justify-content-between align-items-center">
                                 <div class="progress flex-grow-1 me-2" style="height:30px;background:#fde7d3;">
                                     <div class="progress-bar" role="progressbar"
                                         style="width:40%;background:#f97316; text-align: left; padding-left: 5px;">
                                         Lead Conversion
                                     </div>
                                 </div>
                                 <span>40%</span>
                             </div>

                             <!-- KPI 4 -->
                             <div class="mb-4 d-flex justify-content-between align-items-center">
                                 <div class="progress flex-grow-1 me-2" style="height:30px;background:#fde7d3;">
                                     <div class="progress-bar" role="progressbar"
                                         style="width:45%;background:#f97316; text-align: left; padding-left: 5px;">
                                         Stock Accuracy
                                     </div>
                                 </div>
                                 <span>45%</span>
                             </div>

                             <!-- KPI 5 -->
                             <div class="mb-4 d-flex justify-content-between align-items-center">
                                 <div class="progress flex-grow-1 me-2" style="height:30px;background:#fde7d3;">
                                     <div class="progress-bar" role="progressbar"
                                         style="width:50%;background:#f97316; text-align: left; padding-left: 5px;">
                                         Delivery On Time
                                     </div>
                                 </div>
                                 <span>50%</span>
                             </div>
                         </div>
                     </div>

                 </div>
             </div>
         </div>

         <div class="row mt-4">
            <!-- Rincian Operasional -->
             <div class="col-md-4">
                 <div class="card shadow-sm rounded-4 p-3" style="background-color: rgba(255,255,255,0.2); backdrop-filter: blur(6px);"> <!-- ganti warna -->
                     <h6 class="mb-4 mt-2">Rincian Operasional</h6>

                     <!-- garis full width -->
                     <hr class="mt-0 mb-3" style="border-top:2px solid rgba(0,0,0,0.1);">

                     <div class="d-flex align-items-center mb-3">
                         <span class="fs-1 fw-bold me-2">91%</span>
                         <span class="text-successx text-muted d-flex align-items-center">
                             <span class="badge" style="background-color: #D1D5DB; color: #10B981;"><i class="bi bi-arrow-up"></i>8%</span>&nbsp; vs last week
                         </span>
                     </div>

                     <!-- progress bar bobot -->
                     <div class="d-flex mb-3">
                         <div class="me-2 flex-fill" style="height:15px;background-color:#6366F1;border-radius:10px;width:40%;"></div>
                         <div class="me-2 flex-fill" style="height:15px;background-color:#10B981;border-radius:10px;width:10%;"></div>
                         <div class="me-2 flex-fill" style="height:15px;background-color:#D1D5DB;border-radius:10px;width:20%;"></div>
                         <div class="flex-fill" style="height:15px;background-color:#3B82F6;border-radius:10px;width:30%;"></div>
                     </div>

                     <!-- legenda bobot -->
                     <div class="d-flex justify-content-between mb-4">
                         <div class="text-center">
                             <small class="d-block"><span class="rounded-circle me-2" style="width:8px;height:8px;background:#6366F1;display:inline-block;"></span> Revenue Sales<br><span class="text-muted">Bobot: 40%</span></small>
                         </div>
                         <div class="text-center">
                             <small class="d-block"><span class="rounded-circle me-2" style="width:8px;height:8px;background:#10B981;display:inline-block;"></span> Cost<br><span class="text-muted">Bobot: 10%</span></small>
                         </div>
                         <div class="text-center">
                             <!-- <span class="badge" style="background-color:#D1D5DB;">&nbsp;</span> -->
                             <small class="d-block"><span class="rounded-circle me-2" style="width:8px;height:8px;background:#D1D5DB;display:inline-block;"></span> Service Excellent<br><span class="text-muted">Bobot: 20%</span></small>
                         </div>
                         <div class="text-center">
                             <small class="d-block"><span class="rounded-circle me-2" style="width:8px;height:8px;background:#3B82F6;display:inline-block;"></span> E-commerce<br><span class="text-muted">Bobot: 30%</span></small>
                         </div>
                     </div>

                     <!-- tabel rincian -->
                     <table class="table table-sm mb-0">
                         <thead>
                             <tr>
                                 <th>Detail</th>
                                 <th>Target</th>
                                 <th>Actual</th>
                                 <th>Achive</th>
                             </tr>
                         </thead>
                         <tbody>
                             <tr>
                                 <td>Revenue Sales</td>
                                 <td>100% <span class="text-warning"> - </span><br><small class="text-muted">Last Month: 100</small></td>
                                 <td>87% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 2.653%</small></td>
                                 <td>9,34% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 2.653%</small></td>
                             </tr>
                             <tr>
                                 <td>Cost</td>
                                 <td>100% <span class="text-warning"> - </span><br><small class="text-muted">Last Month: 100</small></td>
                                 <td>100% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 0%</small></td>
                                 <td>5% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 0%</small></td>
                             </tr>
                             <tr>
                                 <td>Service Excellent</td>
                                 <td>33% <br><small class="text-muted">Last Month: 100</small></td>
                                 <td>94% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 95%</small></td>
                                 <td>3,8% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 95%</small></td>
                             </tr>
                             <tr>
                                 <td>E-commerce</td>
                                 <td>20% <span class="text-danger">▼</span><br><small class="text-muted">Last Month: 22.611</small></td>
                                 <td>90% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 1.517</small></td>
                                 <td>3,52% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 1.517</small></td>
                             </tr>
                         </tbody>
                     </table>
                 </div>
             </div>

             <!-- Rincian Marketing -->
              <div class="col-md-4">
                 <div class="card shadow-sm rounded-4 p-3" style="background-color: rgba(255,255,255,0.2); backdrop-filter: blur(6px);"> <!-- ganti warna -->
                     <h6 class="mb-4 mt-2">Rincian Marketing</h6>

                     <!-- garis full width -->
                     <hr class="mt-0 mb-3" style="border-top:2px solid rgba(0,0,0,0.1);">

                     <div class="d-flex align-items-center mb-3">
                         <span class="fs-1 fw-bold me-2">62%</span>
                         <span class="text-successx text-muted d-flex align-items-center">
                             <span class="badge" style="background-color: #D1D5DB; color: #10B981;"><i class="bi bi-arrow-up"></i>8%</span>&nbsp; vs last week
                         </span>
                     </div>

                     <!-- progress bar bobot -->
                     <div class="d-flex mb-3">
                         <div class="me-2 flex-fill" style="height:15px;background-color:#6366F1;border-radius:10px;width:50%;"></div>
                         <div class="me-2 flex-fill" style="height:15px;background-color:#10B981;border-radius:10px;width:20%;"></div>
                         <div class="me-2 flex-fill" style="height:15px;background-color:#D1D5DB;border-radius:10px;width:15%;"></div>
                         <div class="flex-fill" style="height:15px;background-color:#3B82F6;border-radius:10px;width:15%;"></div>
                     </div>

                     <!-- legenda bobot -->
                     <div class="d-flex justify-content-between mb-4">
                         <div class="text-center">
                             <small class="d-block"><span class="rounded-circle me-2" style="width:8px;height:8px;background:#6366F1;display:inline-block;"></span> Traffic<br><span class="text-muted">Bobot: 60%</span></small>
                         </div>
                         <div class="text-center">
                             <small class="d-block"><span class="rounded-circle me-2" style="width:8px;height:8px;background:#10B981;display:inline-block;"></span> Event<br><span class="text-muted">Bobot: 10%</span></small>
                         </div>
                         <div class="text-center">
                             <!-- <span class="badge" style="background-color:#D1D5DB;">&nbsp;</span> -->
                             <small class="d-block"><span class="rounded-circle me-2" style="width:8px;height:8px;background:#D1D5DB;display:inline-block;"></span> CRM<br><span class="text-muted">Bobot: 10%</span></small>
                         </div>
                         <div class="text-center">
                             <small class="d-block"><span class="rounded-circle me-2" style="width:8px;height:8px;background:#3B82F6;display:inline-block;"></span> E-commerce<br><span class="text-muted">Bobot: 20%</span></small>
                         </div>
                     </div>

                     <!-- tabel rincian -->
                     <table class="table table-sm mb-0">
                         <thead>
                             <tr>
                                 <th>Detail</th>
                                 <th>Target</th>
                                 <th>Actual</th>
                                 <th>Achive</th>
                             </tr>
                         </thead>
                         <tbody>
                             <tr>
                                 <td>Traffic</td>
                                 <td>100% <span class="text-warning"> - </span><br><small class="text-muted">Last Month: 100</small></td>
                                 <td>87% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 2.653%</small></td>
                                 <td>9,34% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 2.653%</small></td>
                             </tr>
                             <tr>
                                 <td>Event</td>
                                 <td>100% <span class="text-warning"> - </span><br><small class="text-muted">Last Month: 100</small></td>
                                 <td>100% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 0%</small></td>
                                 <td>5% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 0%</small></td>
                             </tr>
                             <tr>
                                 <td>CRM</td>
                                 <td>33% <br><small class="text-muted">Last Month: 100</small></td>
                                 <td>94% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 95%</small></td>
                                 <td>3,8% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 95%</small></td>
                             </tr>
                             <tr>
                                 <td>E-commerce</td>
                                 <td>20% <span class="text-danger">▼</span><br><small class="text-muted">Last Month: 22.611</small></td>
                                 <td>90% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 1.517</small></td>
                                 <td>3,52% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 1.517</small></td>
                             </tr>
                         </tbody>
                     </table>
                 </div>
             </div>

             <!-- Rincian Produksi -->
              <div class="col-md-4">
                 <div class="card shadow-sm rounded-4 p-3" style="background-color: rgba(255,255,255,0.2); backdrop-filter: blur(6px);"> <!-- ganti warna -->
                     <h6 class="mb-4 mt-2">Rincian Produksi</h6>

                     <!-- garis full width -->
                     <hr class="mt-0 mb-3" style="border-top:2px solid rgba(0,0,0,0.1);">

                     <div class="d-flex align-items-center mb-3">
                         <span class="fs-1 fw-bold me-2">89%</span>
                         <span class="text-successx text-muted d-flex align-items-center">
                             <span class="badge" style="background-color: #D1D5DB; color: #10B981;"><i class="bi bi-arrow-up"></i>8%</span>&nbsp; vs last week
                         </span>
                     </div>

                     <!-- progress bar bobot -->
                     <div class="d-flex mb-3">
                         <div class="me-2 flex-fill" style="height:15px;background-color:#6366F1;border-radius:10px;width:50%;"></div>
                         <div class="me-2 flex-fill" style="height:15px;background-color:#10B981;border-radius:10px;width:20%;"></div>
                         <div class="me-2 flex-fill" style="height:15px;background-color:#D1D5DB;border-radius:10px;width:15%;"></div>
                         <div class="flex-fill" style="height:15px;background-color:#3B82F6;border-radius:10px;width:15%;"></div>
                     </div>

                     <!-- legenda bobot -->
                     <div class="d-flex justify-content-between mb-4">
                         <div class="text-center">
                             <small class="d-block"><span class="rounded-circle me-2" style="width:8px;height:8px;background:#6366F1;display:inline-block;"></span> Safety Stock<br><span class="text-muted">Bobot: 60%</span></small>
                         </div>
                         <div class="text-center">
                             <small class="d-block"><span class="rounded-circle me-2" style="width:8px;height:8px;background:#10B981;display:inline-block;"></span> Production Quality<br><span class="text-muted">Bobot: 10%</span></small>
                         </div>
                         <div class="text-center">
                             <!-- <span class="badge" style="background-color:#D1D5DB;">&nbsp;</span> -->
                             <small class="d-block"><span class="rounded-circle me-2" style="width:8px;height:8px;background:#D1D5DB;display:inline-block;"></span> HPP Position<br><span class="text-muted">Bobot: 10%</span></small>
                         </div>
                         <div class="text-center">
                             <small class="d-block"><span class="rounded-circle me-2" style="width:8px;height:8px;background:#3B82F6;display:inline-block;"></span> Biaya<br><span class="text-muted">Bobot: 20%</span></small>
                         </div>
                     </div>

                     <!-- tabel rincian -->
                     <table class="table table-sm mb-0">
                         <thead>
                             <tr>
                                 <th>Detail</th>
                                 <th>Target</th>
                                 <th>Actual</th>
                                 <th>Achive</th>
                             </tr>
                         </thead>
                         <tbody>
                             <tr>
                                 <td>Safety Stock</td>
                                 <td>100% <span class="text-warning"> - </span><br><small class="text-muted">Last Month: 100</small></td>
                                 <td>87% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 2.653%</small></td>
                                 <td>9,34% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 2.653%</small></td>
                             </tr>
                             <tr>
                                 <td>Production Quality</td>
                                 <td>100% <span class="text-warning"> - </span><br><small class="text-muted">Last Month: 100</small></td>
                                 <td>100% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 0%</small></td>
                                 <td>5% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 0%</small></td>
                             </tr>
                             <tr>
                                 <td>HPP Position</td>
                                 <td>33% <br><small class="text-muted">Last Month: 100</small></td>
                                 <td>94% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 95%</small></td>
                                 <td>3,8% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 95%</small></td>
                             </tr>
                             <tr>
                                 <td>Biaya</td>
                                 <td>20% <span class="text-danger">▼</span><br><small class="text-muted">Last Month: 22.611</small></td>
                                 <td>90% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 1.517</small></td>
                                 <td>3,52% <span class="text-success">▲</span><br><small class="text-muted">Last Month: 1.517</small></td>
                             </tr>
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>


     </div>
 </main>