<main class="main mainheight py-lg-5 py-4 bg-light-bluemorph">
    <div class="hero-section px-4">
        <div class="container">
            <div class="row align-items-center bg-white rounded-3 glass py-2 ">
                <h1 class="fs-6 fw-bold mb-0">Selamat Pagi, <span class="text-gradient"><?= $this->session->userdata('nama'); ?>!</span></h1>
                <p class="fs-7">Setiap hari adalah kesempatan baru untuk tumbuh dan belajar.</p>
            </div>
        </div>
    </div>
    <section class="hero-section py-4 py-md-5 px-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-12 mb-0 left-card">
                    <div class="d-flex align-items-center mb-lg-4 mb-0">
                        <img src="<?= base_url('assets/icon/increase.png') ?>" alt="" srcset="" style="max-height: 32px;" class="me-2">
                        <span class="fw-bold fs-6">#GrowthWith<span class="text-gradient">AI</span>
                    </div>
                    <h1 class="fs-3 fw-bold py-3 mb-0">Coaching &amp; Counseling <br><span class="text-gradient">Powered by AI</span></h1>
                    <p class="fs-6 text-secondary mb-4">Fasilitas eksklusif karyawan untuk bimbingan mandiri. Temukan solusi tantangan pekerjaan dan susun IDP (Individual Development Plan) Anda dengan bantuan AI.</p>
                    <div class="d-flex flex-column flex-sm-row gap-3 mb-4">
                        <a href="#" type="button" class="btn btn-gradient" id="startSessionBtn">
                            Mulai Coaching <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <a href="#" class="btn btn-outline-custom" data-bs-toggle="modal" data-bs-target="#howItWorksModal">
                            Pelajari Caranya
                        </a>
                    </div>
                    <div class="pt-3 border-top border-secondary-subtle">
                        <p class="small text-secondary fw-medium">Didukung oleh teknologi Learning &amp; Development Perusahaan</p>
                    </div>
                </div>
                <div class="col-lg-6 col-12 d-none d-md-block">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="col-6">
                            <div class="card rotating-card border-secondary-subtle shadow-lg rounded-5" style="min-height: 300px;min-width: 280px;">
                                <div class="card-body p-4 rounded-5" style="background-image: url('<?= base_url() ?>assets/icon/nira.png');background-size: 150px;background-repeat: no-repeat;background-position-x: right;background-position-y: bottom;">
                                    <div class="position-relative">
                                        <div class="position-absolute top-0 end-0 w-25 h-25 bg-purple bg-opacity-10 rounded-circle" style="filter: blur(3rem);"></div>
                                        <div class="d-flex align-items-center gap-3 pb-3 mb-3 border-bottom border-secondary-subtle">
                                            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 3rem; height: 3rem;">
                                                <i class="bi bi-cpu text-primary fs-4"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold text-dark mb-0">Analisis Coaching</h5>
                                                <p class="small text-secondary">Berdasarkan Masalah Anda</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-4">
                                                    <P>Goals</P>
                                                    <div class="progress mb-2" style="height: 0.5rem;">
                                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 75%; height: 0.5rem;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="progress mb-2" style="height: 0.5rem;">
                                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 50%; height: 0.5rem;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-4">
                                                    <p>Reality</p>
                                                    <div class="progress mb-2" style="height: 0.5rem;">
                                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 75%; height: 0.5rem;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="progress mb-2" style="height: 0.5rem;">
                                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 50%; height: 0.5rem;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-4">
                                                    <p>Options</p>
                                                    <div class="progress mb-2" style="height: 0.5rem;">
                                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 75%; height: 0.5rem;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="progress mb-2" style="height: 0.5rem;">
                                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 50%; height: 0.5rem;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-4">
                                                    <p>Will</p>
                                                    <div class="progress mb-2" style="height: 0.5rem;">
                                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 75%; height: 0.5rem;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="progress mb-2" style="height: 0.5rem;">
                                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 50%; height: 0.5rem;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="container-lg">
        <div class="row">
            <div class="COL-12 col-lg-8">
                <div class="mb-4">
                    <div class="section-title">Jadwal Coaching</div>
                    <div class="col" id="div_sesi_invitation">
                    </div>
                </div>
            </div>

            <div class="COL-12 col-lg-4">
                <div class="mb-4">
                    <div class="section-title">Aktivitas Terbaru</div>
                    <div class="card-session" id="div_last_activity">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="py-1 px-1">
        <div class="container">
            <div class="card glassy-blue shadow-sm py-3 px-3 d-flex flex-column flex-md-row align-items-center justify-content-between">

                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:56px; height:56px;">
                        <i class="bi bi-heart-pulse text-primary fs-3"></i>
                    </div>

                    <div>
                        <h4 class="mb-1 fw-bold">Rasakan Capek yang Berbeda? Bisa Jadi Burnout.</h4>
                        <p class="mb-0 text-secondary">
                            Ikuti tes singkat untuk mengetahui apakah Anda mengalami tanda-tanda burnout.
                            Tes ini hanya butuh ~5 menit dan membantu memberi rekomendasi langkah selanjutnya.
                        </p>
                    </div>
                </div>

                <div class="mt-3 mt-md-0">
                    <a href="https://trusmiverse.com/apps/ai_burnout/main" class="btn btn-gradient" id="learnBurnoutBtn" target="_blank" style="white-space: nowrap;">Mulai Tes <i class="bi bi-clipboard-check ms-2"></i></a>
                </div>
            </div>
        </div>
    </section>
</main>


<!-- Modal -->
<div class="modal fade" id="howItWorksModal" tabindex="-1" aria-labelledby="howItWorksModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold" id="howItWorksModalLabel">Sesi Coaching</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="flex-1 overflow-y-auto no-scrollbar px-6 pb-24 space-y-6">
                    <img src="<?= base_url('assets/icon/co_n_co.png') ?>" alt="" srcset="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</div>
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