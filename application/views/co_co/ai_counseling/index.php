<main class="main mainheight py-5" style="background-color: #F6F6F8;">
    <!-- <section class="hero-section py-5 py-md-5 px-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="badge-custom bg-primary bg-opacity-10 text-primary mb-4">
                        <i class="bi bi-lightning-charge-fill me-1"></i>
                        HR &amp; People Development Tool
                    </div>
                    <h1 class="display-4 fw-bold mb-4">Coaching &<br>Counseling<br><span class="gradient-text">Powered by AI</span></h1>
                    <p class="fs-5 text-secondary mb-4">Fasilitas eksklusif karyawan untuk bimbingan karir mandiri. Temukan solusi tantangan pekerjaan dan susun IDP (Individual Development Plan) Anda dengan bantuan AI.</p>
                    <div class="d-flex flex-column flex-sm-row gap-3 mb-4">
                        <a href="#demo" class="btn btn-gradient">
                            Mulai Sesi Coaching <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <a href="#how-it-works" class="btn btn-outline-custom">
                            Pelajari Caranya
                        </a>
                    </div>
                    <div class="pt-3 border-top border-secondary-subtle">
                        <p class="small text-secondary fw-medium">Didukung oleh teknologi Learning &amp; Development Perusahaan</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card rotating-card border-secondary-subtle shadow-lg">
                        <div class="card-body p-4">
                            <div class="position-relative">
                                <div class="position-absolute top-0 end-0 w-25 h-25 bg-purple bg-opacity-10 rounded-circle" style="filter: blur(3rem);"></div>
                                <div class="d-flex align-items-center gap-3 pb-3 mb-3 border-bottom border-secondary-subtle">
                                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 3rem; height: 3rem;">
                                        <i class="bi bi-cpu text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h4 class="fw-bold text-dark">Analisis Performa</h4>
                                        <p class="small text-secondary">Berdasarkan KPI Bulanan</p>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="progress mb-2" style="height: 0.5rem;">
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 75%; height: 0.5rem;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="progress mb-2" style="height: 0.5rem;">
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 50%; height: 0.5rem;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="progress" style="height: 0.5rem;">
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 100%; height: 0.5rem;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="bg-primary bg-opacity-10 rounded-3 p-3 border border-primary border-opacity-25">
                                    <p class="small text-primary fw-medium">"Langkah strategis Anda selaras dengan OKR Q3 Perusahaan. Fokus pada peningkatan efisiensi tim."</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <div class="container-lg">
        <div class="mb-2">
            <div class="welcome-card d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <h2>Selamat Pagi, <?= $this->session->userdata('nama'); ?>!</h2>
                    <p>Setiap hari adalah kesempatan baru untuk tumbuh dan belajar.</p>
                </div>
                <button class="btn btn-primary d-flex align-items-center gap-2 rounded" style="padding: 12px 16px;" id="startSessionBtn">
                    <span class="material-symbols-outlined">add_circle</span>
                    <span>Mulai Sesi Coaching Baru</span>
                </button>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="mb-4">
                    <div class="section-title">Sesi Anda Berikutnya</div>
                    <div class="col" id="div_sesi_invitation">
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-4">
                    <div class="section-title">Aktivitas Terbaru</div>
                    <div class="card-session" id="div_last_activity">
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<!-- Modal -->
<div class="modal fade" id="startSessionModal" tabindex="-1" aria-labelledby="startSessionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold" id="startSessionModalLabel">Sesi Coaching</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-auto">
                    <p class="fs-6 text-muted">Pilih topik yang ingin Anda diskusikan untuk memulai.</p>
                </div>
                <form id="startSessionForm">
                    <div class="pt-4 pb-2">
                        <div class="radio-card radio-card-1 border-2 border-gray-200 card rounded-3 cursor-pointer mb-2">
                            <div class="card-body rounded-3 d-flex align-items-center" style="background: url('<?= base_url() ?>assets/icon/career-path.png');background-repeat: no-repeat;background-position: right 20px center;background-size:contain;">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="session_topic" id="flexRadioDefault1" value="Career Development">
                                    <label class="form-check-label ms-2" for="flexRadioDefault1">
                                        <h3 class="mb-0 fs-5">Career Development</h3>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="radio-card radio-card-2 border-2 border-gray-200 card rounded-3 cursor-pointer mb-2">
                            <div class="card-body rounded-3 d-flex align-items-center" style="background: url('<?= base_url() ?>assets/icon/fear.png');background-repeat: no-repeat;background-position: right 20px center;background-size:contain;">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="session_topic" id="flexRadioDefault2" value="Work-Life Balance">
                                    <label class="form-check-label ms-2" for="flexRadioDefault2">
                                        <h3 class="mb-0 fs-5">Work-Life Balance</h3>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="radio-card radio-card-3 border-2 border-gray-200 card rounded-3 cursor-pointer mb-2">
                            <div class="card-body rounded-3 d-flex align-items-center" style="background: url('<?= base_url() ?>assets/icon/efficiency.png');background-repeat: no-repeat;background-position: right 20px center;background-size:contain;">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="session_topic" id="flexRadioDefault3">
                                    <label class="form-check-label ms-2" for="flexRadioDefault3" value="General Professional Growth">
                                        <h3 class="mb-0 fs-5">General Professional Growth</h3>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="radio-card radio-card-4 border-2 border-gray-200 card rounded-3 cursor-pointer mb-2">
                            <div class="card-body rounded-3 d-flex align-items-center" style="background: url('<?= base_url() ?>assets/icon/conversation.png');background-repeat: no-repeat;background-position: right 20px center;background-size:contain;">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="session_topic" id="flexRadioDefault4" value="Leadership & Delegation">
                                    <label class="form-check-label ms-2" for="flexRadioDefault4">
                                        <h3 class="mb-0 fs-5">Leadership & Delegation</h3>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="radio-card radio-card-4 border-2 border-gray-200 card rounded-3 cursor-pointer mb-2">
                            <div class="card-body rounded-3 d-flex align-items-center" style="background: url('<?= base_url() ?>assets/icon/high-performance.png');background-repeat: no-repeat;background-position: right 20px center;background-size:contain;">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="session_topic" id="flexRadioDefault4" value="Work Performance">
                                    <label class="form-check-label ms-2" for="flexRadioDefault4">
                                        <h3 class="mb-0 fs-5">Work Performance</h3>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="radio-card radio-card-5 border-2 border-gray-200 card rounded-3 cursor-pointer mb-2">
                            <div class="card-body rounded-3 d-flex align-items-center" style="background: url('<?= base_url() ?>assets/icon/thought-leadership.png');background-repeat: no-repeat;background-position: right 20px center;background-size:contain;">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="session_topic" id="flexRadioDefault5" value="Other">
                                    <label class="form-check-label ms-2" for="flexRadioDefault5">
                                        <h3 class="mb-0 fs-5">Other Topic</h3>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="otherTopicContainer" class="border-2 border-gray-200 card rounded-3 mb-2 hidden">
                            <div class="form-group position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person"></i></span>
                                    <div class="form-floating">
                                        <textarea id="otherTopicInput" name="other_topic" class="form-control border-start-0" style="min-height: 100px;" placeholder=""></textarea>
                                        <label>Tulis topik lain yang ingin Anda diskusikan...</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- show alert -->
                        <div id="alert-start-session" class="alert alert-danger mt-3 hidden"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary ms-2" id="startSession">Mulai Sesi</button>
            </div>
        </div>
    </div>
</div>