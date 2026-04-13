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
                    <div class="text-center mb-8 mt-4 animate-fade-in-up">
                        <div class="w-20 h-20 bg-gradient-to-tr from-teal-400 to-blue-500 rounded-3xl mx-auto flex items-center justify-center text-white shadow-lg shadow-blue-200 mb-5 transform rotate-3"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-open" aria-hidden="true">
                                <path d="M12 7v14"></path>
                                <path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"></path>
                            </svg></div>
                        <h2 class="text-lg font-bold text-slate-800">Selamat Datang di Lumina</h2>
                        <p class="text-sm text-slate-500 leading-relaxed max-w-[250px] mx-auto mt-2">Platform coaching dan konseling digital personal untuk kesehatan mental dan performa kerjamu.</p>
                    </div>
                    <div class="space-y-4">
                        <div class="bg-white/40 backdrop-blur-md border border-white/50 shadow-lg rounded-2xl p-5 transition-all duration-200  flex gap-4 items-start p-5 transition-transform hover:scale-[1.02] duration-300">
                            <div class="bg-teal-50 text-teal-600 w-12 h-12 rounded-2xl flex items-center justify-center shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-circle-heart" aria-hidden="true">
                                    <path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"></path>
                                    <path d="M7.828 13.07A3 3 0 0 1 12 8.764a3 3 0 0 1 5.004 2.224 3 3 0 0 1-.832 2.083l-3.447 3.62a1 1 0 0 1-1.45-.001z"></path>
                                </svg></div>
                            <div>
                                <h3 class="font-bold text-slate-800 mb-1">Mulai Konseling</h3>
                                <p class="text-xs text-slate-500 leading-relaxed">Ceritakan masalahmu pada dr. Sarah. AI akan mendengarkan dan memberikan respon suportif serta objektif.</p>
                            </div>
                        </div>
                        <div class="bg-white/40 backdrop-blur-md border border-white/50 shadow-lg rounded-2xl p-5 transition-all duration-200  flex gap-4 items-start p-5 transition-transform hover:scale-[1.02] duration-300">
                            <div class="bg-rose-50 text-rose-500 w-12 h-12 rounded-2xl flex items-center justify-center shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-heart" aria-hidden="true">
                                    <path d="M12.127 22H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v5.125"></path>
                                    <path d="M14.62 18.8A2.25 2.25 0 1 1 18 15.836a2.25 2.25 0 1 1 3.38 2.966l-2.626 2.856a.998.998 0 0 1-1.507 0z"></path>
                                    <path d="M16 2v4"></path>
                                    <path d="M3 10h18"></path>
                                    <path d="M8 2v4"></path>
                                </svg></div>
                            <div>
                                <h3 class="font-bold text-slate-800 mb-1">Atur Jadwal</h3>
                                <p class="text-xs text-slate-500 leading-relaxed">Lihat jadwal sesi wajib dari atasan atau buat jadwal mandiri sesuai waktu luangmu.</p>
                            </div>
                        </div>
                        <div class="bg-white/40 backdrop-blur-md border border-white/50 shadow-lg rounded-2xl p-5 transition-all duration-200  flex gap-4 items-start p-5 transition-transform hover:scale-[1.02] duration-300">
                            <div class="bg-blue-50 text-blue-600 w-12 h-12 rounded-2xl flex items-center justify-center shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-list" aria-hidden="true">
                                    <rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect>
                                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                    <path d="M12 11h4"></path>
                                    <path d="M12 16h4"></path>
                                    <path d="M8 11h.01"></path>
                                    <path d="M8 16h.01"></path>
                                </svg></div>
                            <div>
                                <h3 class="font-bold text-slate-800 mb-1">Pantau Kesehatan</h3>
                                <p class="text-xs text-slate-500 leading-relaxed">Lihat riwayat sesi dan hasil analisis metode G.R.O.W. untuk memantau kemajuan mentalmu.</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white/40 backdrop-blur-md border border-white/50 shadow-lg rounded-2xl p-5 transition-all duration-200  bg-gradient-to-r from-slate-800 to-slate-900 text-white mt-6 border-none shadow-xl shadow-slate-200">
                        <div class="flex items-center gap-3 mb-3"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check text-teal-400" aria-hidden="true">
                                <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            <h3 class="font-bold">Privasi &amp; Keamanan</h3>
                        </div>
                        <p class="text-xs text-slate-300 leading-relaxed opacity-90">Semua percakapan Anda dengan dr. Sarah bersifat rahasia. Data medis hanya dapat diakses oleh Anda dan profesional yang berwenang jika diperlukan untuk tindakan lanjut.</p>
                    </div><button class="w-full bg-teal-500 text-white py-4 rounded-2xl font-bold shadow-lg shadow-teal-200 active:scale-95 hover:bg-teal-600 transition-all mt-6 mb-8">Mengerti, Mulai Sekarang</button>
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