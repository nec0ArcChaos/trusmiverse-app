<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title mb-3">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="fw-bold mb-0 text-uppercase tracking-wider">
                    <?= $pageTitle; ?>
                </h5>
                <p class="text-muted small">Monitoring Auto Notif Pesan Ulang Tahun Karyawan</p>
            </div>

            <div class="col-12 col-md-auto">
                <form method="POST" id="form_filter">
                    <div class="input-group input-group-md reportrange">
                        <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                        <input type="hidden" name="start" value="" id="start" readonly />
                        <input type="hidden" name="end" value="" id="end" readonly />
                        <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
                    </div>
                </form>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-light p-2 px-3 rounded shadow-sm" style="--bs-breadcrumb-divider: '>';">
                <li class="breadcrumb-item small"><a href="#"
                        class="text-decoration-none text-secondary">Trusmiverse</a></li>
                <li class="breadcrumb-item active small text-primary" aria-current="page fw-bold">
                    <?= $pageTitle; ?>
                </li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm h-100">

                    <div class="card-header bg-white py-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0 fw-bold text-dark"><i class="bi bi-list-stars me-2"></i>Log Pengiriman Pesan</h6>
                            </div>
                            <div class="col-md-auto col-12 d-flex gap-2 mt-2 mt-md-0">
                                <button type="button" id="btnBlastHariIni" class="btn btn-primary btn-sm shadow-sm px-3">
                                    <i class="bi bi-send-fill me-1"></i> Blast Notif Hari Ini
                                </button>
                                
                                <div class="input-group input-group-sm" style="width: 200px;">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                                    <input type="text" id="customSearch" class="form-control bg-light border-start-0" placeholder="Cari data...">
                                </div>
                                <div id="container-buttons"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dt_birthday_log" class="table table-hover align-middle" style="width:100%">
                                <thead class="table-light text-secondary">
                                    <tr>
                                        <th>Waktu</th>
                                        <th>Karyawan</th>
                                        <th>No. WhatsApp</th>
                                        <th>Pratinjau Gambar</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm bg-white">
                    <div class="card-body">
                        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-info-circle-fill text-primary me-2"></i>Panduan
                            Monitoring Notifikasi</h6>
                        <div class="row">
                            <div class="col-md-6 border-end">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="badge bg-soft-primary text-primary rounded-circle p-2 me-3">1</div>
                                    <div>
                                        <p class="mb-1 fw-bold">Pengiriman Massal (Hari Ini)</p>
                                        <p class="text-muted small mb-0">
                                            Secara default, sistem menampilkan data <b>Hari Ini</b>. Jika status masih <span
                                                class="badge bg-warning text-dark px-2" style="font-size: 10px;">PENDING</span>,
                                            gunakan tombol <span class="text-primary fw-bold">"Blast Notif Hari Ini"</span>.
                                            Tombol ini hanya aktif pada filter tanggal hari ini untuk mencegah salah kirim data
                                            lama.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="badge bg-soft-primary text-primary rounded-circle p-2 me-3">2</div>
                                    <div>
                                        <p class="mb-1 fw-bold">Pengiriman Ulang Per Karyawan</p>
                                        <p class="text-muted small mb-0">
                                            Jika ingin mengirim ulang untuk <b>satu orang saja</b>, klik ikon <span
                                                class="text-primary fw-bold"><i class="bi bi-arrow-clockwise"></i> Resend</span>
                                            di kolom aksi. Tombol ini tersedia pada setiap baris yang berstatus pending,
                                            terlepas dari filter tanggal yang dipilih.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>