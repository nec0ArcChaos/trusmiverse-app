<main class="main mainheight">
    <div class="container-fluid main-container">
        <div class="row gx-4">
            <div class="col-lg-8 px-3">
                <div class="w-100 py-1 py-md-1 py-lg-1 position-relative bg-theme z-index-0 rounded-4">
                    <div class="coverimg w-100 h-100 position-absolute top-0 start-0 opacity-3 z-index-0 rounded-4"
                        id="coverimg_div">
                        <img src="<?= base_url(); ?>assets/img/bga-1.avif" class="" id="coverimg" />
                    </div>
                    <div class="container py-1 py-lg-1 my-lg-5 z-index-1 position-relative rounded-4">
                        <div class="row gx-5 align-items-start">
                            <div class="col-12 col-md-12 col-lg-12 position-relative my-4">
                                <div class="row align-items-center mb-4">
                                    
                                    <div class="col">
                                        <h2>🙌Selamat Datang di tim Trusmi,  <?= $data_karyawan->nama ?></h2>
                                        <p>Senang sekali kamu sudah bergabung. Yuk, kita mulai Onboarding kamu bersama Trusmiverse😎.</p>
                                        <i class="bi bi-briefcase me-1"></i> <?= $data_karyawan->designation_name ?>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col">
                                        <span class="badge bg-light-white h6">📅Hari ke 1</span>
                                        <span class="badge bg-light-white h6">🔥1 dari 20 Tugas selesai</span>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="container mt-4 mt-lg-0">
                    <div class="row mb-4 align-items-start">
                        <div class="col-auto position-relative">
                            <figure
                                class="avatar avatar-160 coverimg rounded-circle top-80 shadow-md border-3 border-light">
                                <img src="https://trusmiverse.com/hr/uploads/profile/PF_34980_1705651590.jpg" alt="" />
                            </figure>

                        </div>
                        <div class="col-12 col-md pt-2">
                            <h2 class="mb-1"><?= $this->session->userdata("nama"); ?> <span
                                    class="badge bg-theme rounded vm fw-normal fs-12"><i
                                        class="bi bi-check-circle me-1"></i>Online</span></h2>
                            <p><span class="text-secondary"><i class="bi bi-briefcase me-1"></i></span>
                            </p>
                            <span class="badge bg-light-theme text-theme">
                                <span class="avatar avatar-20 rounded-circle me-1 vm"><i
                                        class="bi bi-telephone"></i></span>

                            </span>
                            <span class="badge bg-light-theme text-theme">
                                <span class="avatar avatar-20 rounded-circle me-1 vm"><i
                                        class="bi bi-envelope"></i></span>

                            </span>

                        </div>

                    </div>

                </div> -->

                <!-- <div class="d-flex justify-content-between align-items-center mb-4 ">
                    <div>
                        <h3 class="fw-bold mb-1">Selamat Datang, <?= $data_karyawan->nama ?>!</h3>
                        <p class="text-muted mb-0"><?= $data_karyawan->department_name ?> -
                            <?= $data_karyawan->designation_name ?> - Masuk
                            <?= $data_karyawan->date_of_joining ?>
                        </p>
                    </div>
                    <div class="d-none d-md-block" style="min-width: 200px;">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold text-primary">Timeline Onboarding</span>
                            <span class="fw-bold text-primary">10%</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar" role="progressbar" style="width: 10%;" aria-valuenow="10"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="text-end text-muted small mt-1">2 dari 21 tugas selesai</div>
                    </div>
                </div> -->

                <div class="stepper-wrapper">
                    <div class="stepper-item active day-trigger" data-day="1">
                        <div class="step-counter">1</div>
                        <div class="step-name">Day 1</div>
                    </div>
                    <div class="stepper-item day-trigger" data-day="2">
                        <div class="step-counter">2</div>
                        <div class="step-name">Day 2</div>
                    </div>
                    <div class="stepper-item day-trigger" data-day="3">
                        <div class="step-counter">3</div>
                        <div class="step-name">Day 3</div>
                    </div>
                    <div class="stepper-item day-trigger" data-day="50">
                        <div class="step-counter">50</div>
                        <div class="step-name">Day 50</div>
                    </div>
                </div>

                <div id="dynamic-content-area" class="">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold mb-0">Journey Onboarding</h5>
                        <span class="text-muted fw-500">Hari ke-1 dari 50</span>
                    </div>
                    <div id="day-1-content" class="day-content">

                        <!-- <div class="p-3 rounded-3 mb-3 border border-success bg-light-success custom-collapsible">


                            <div class="fw-600 collapsible-trigger">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                                    <span>Guideline-On Boarding Sistem-Trusmiverse</span>
                                    <i class="bi bi-chevron-down ms-auto"></i>


                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;"
                                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <span class="badge bg-success fw-600">Sesuai</span>
                                    <span class="text-muted small">1 modul selesai</span>
                                </div>
                            </div>

                            <div class="collapsible-content rounded-2" style="display: none;">
                                <hr class="my-2">
                                <div class="card rounded-2 shadow-none border-success">
                                    <div class="card-body bg-light rounded-2">
                                        <p class="mb-2 mt-2 small text-muted">Ikuti guideline dan arahan untuk proses On
                                            Boarding di Trusmiverse</p>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 rounded-3 mb-3 border border-success bg-light-success custom-collapsible">
                            <div class="fw-600 collapsible-trigger">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-hourglass-split text-primary me-2 fs-5"></i>
                                    <span>Training Induction</span>
                                    <i class="bi bi-chevron-down ms-auto"></i>


                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 80%;"
                                                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <span class="badge bg-warning fw-600">Progres</span>
                                    <span class="text-muted small">1 modul selesai</span>
                                </div>
                            </div>
                            <div class="collapsible-content rounded-2" style="display: none;">
                                <hr class="my-1">
                                <div id="div_day_1"></div>
                            </div>
                        </div> -->
                        <!-- <div class="p-3 rounded-3 mb-3 border border-success bg-light-success custom-collapsible">
                            <div class="fw-600 collapsible-trigger">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-hourglass-split text-primary me-2 fs-5"></i>
                                    <span>Peraturan Perusahaan</span>
                                    <i class="bi bi-chevron-down ms-auto"></i>


                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 80%;"
                                                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <span class="badge bg-warning fw-600">Progres</span>
                                    <span class="text-muted small">3/5 modul selesai</span>
                                </div>
                            </div>
                            <div class="collapsible-content rounded-2" style="display: none;">
                                <hr class="my-1">
                                <div class="card rounded-2 shadow-none border-success my-2">
                                    <div class="card-header">

                                        <h6 class="title py-0"><i
                                                class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                                            Aturan Kehadiran, Jam kerja dan Comben</h6>
                                    </div>
                                    <div class="card-body bg-light rounded-2">
                                        <div class="row">
                                            <div class="col">

                                                <p class="small text-muted">Modul ini membahas ketentuan kehadiran, jam
                                                    kerja, serta kompensasi dan benefit (Comben) yang berlaku di
                                                    perusahaan. Kamu akan mempelajari jadwal kerja resmi, aturan
                                                    keterlambatan, kebijakan lembur, hingga hak dan fasilitas yang kamu
                                                    terima sebagai karyawan</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card rounded-2 shadow-none border-success my-2">
                                    <div class="card-header">

                                        <h6 class="title py-0"><i
                                                class="bi bi-hourglass-split text-secondary me-2 fs-5"></i>
                                            Lock Absen</h6>
                                    </div>
                                    <div class="card-body bg-light rounded-2">
                                        <div class="row">
                                            <div class="col">

                                                <p class="small text-muted">Modul ini menjelaskan mekanisme ‘Lock Absen’
                                                    yang diterapkan perusahaan untuk memastikan pencatatan kehadiran
                                                    berlangsung akurat. Kamu akan mengetahui batas waktu absensi,
                                                    prosedur jika terlambat melakukan absensi, serta konsekuensi yang
                                                    mungkin timbul.</p>
                                                <button class="btn btn-primary"><i class="bi bi-arrow-right"></i>
                                                    Mulai</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div id="day-2-content" class="day-content" style="display:none">

                        <!-- <div class="p-3 rounded-3 mb-3 border border-success bg-light-success custom-collapsible">
                            <div class="fw-600 collapsible-trigger">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-hourglass-split text-primary me-2 fs-5"></i>
                                    <span>SOP Department Innovation & System Development</span>
                                    <i class="bi bi-chevron-down ms-auto"></i>


                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 60%;"
                                                aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <span class="badge bg-success fw-600">Sesuai</span>
                                    <span class="text-muted small">1 modul selesai</span>
                                </div>
                            </div>
                            <div class="collapsible-content rounded-2" style="display: none;">
                                <hr class="my-1">
                                <div class="card rounded-2 shadow-none border-success my-2">
                                    <div class="card-header">

                                        <h6 class="title py-0"><i
                                                class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                                            Intruksi Kerja</h6>
                                    </div>
                                    <div class="card-body bg-light rounded-2">
                                        <div class="row">
                                            <div class="col">

                                                <p class="small text-muted">Modul ini berisi panduan kerja yang harus
                                                    diikuti, termasuk tata cara pelaksanaan tugas, prosedur operasional
                                                    standar, dan etika kerja yang berlaku di perusahaan. Dengan memahami
                                                    instruksi kerja ini, kamu dapat menjalankan tanggung jawab dengan
                                                    lebih efektif, sesuai standar kualitas yang diharapkan.</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card rounded-2 shadow-none border-success my-2">
                                    <div class="card-header">

                                        <h6 class="title py-0"><i
                                                class="bi bi-hourglass-split text-secondary me-2 fs-5"></i>
                                            SOP Kerja Innovation & System Development</h6>
                                    </div>
                                    <div class="card-body bg-light rounded-2">
                                        <div class="row">
                                            <div class="col">

                                                <p class="small text-muted">Modul ini membahas Standar Operasional
                                                    Prosedur (SOP) di Departemen Innovation & System Development, mulai
                                                    dari alur kerja, tanggung jawab setiap peran, hingga prosedur
                                                    penanganan masalah. Pengetahuan ini akan membantumu bekerja secara
                                                    terstruktur, meminimalkan kesalahan, dan meningkatkan kolaborasi tim
                                                </p>
                                                <button class="btn btn-primary"><i class="bi bi-arrow-right"></i>
                                                    Baca Dokumen</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card rounded-2 shadow-none border-success my-2">
                                    <div class="card-header">

                                        <h6 class="title py-0"><i
                                                class="bi bi-hourglass-split text-secondary me-2 fs-5"></i>
                                            Job Profile</h6>
                                    </div>
                                    <div class="card-body bg-light rounded-2">
                                        <div class="row">
                                            <div class="col">

                                                <p class="small text-muted">Modul ini menjelaskan deskripsi pekerjaan
                                                    (job profile) sesuai posisi yang kamu jalani, mencakup tanggung
                                                    jawab utama, target kinerja, dan keterampilan yang dibutuhkan.
                                                    Dengan memahami profil pekerjaan, kamu dapat mengatur prioritas
                                                    kerja, mengukur pencapaian, dan berkembang sesuai ekspektasi
                                                    perusahaan.</p>
                                                <button class="btn btn-primary"><i class="bi bi-arrow-right"></i>
                                                    Baca Dokumen</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 rounded-3 mb-3 border border-success bg-light-success custom-collapsible">
                            <div class="fw-600 collapsible-trigger">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-hourglass-split text-primary me-2 fs-5"></i>
                                    <span>Peraturan Perusahaan</span>
                                    <i class="bi bi-chevron-down ms-auto"></i>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;"
                                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <span class="badge bg-success fw-600">Sesuai</span>
                                    <span class="text-muted small">1 modul selesai</span>
                                </div>
                            </div>
                            <div class="collapsible-content rounded-2" style="display: none;">
                                <hr class="my-1">
                                <div class="card rounded-2 shadow-none border-success my-2">
                                    <div class="card-header">

                                        <h6 class="title py-0"><i
                                                class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                                            Aturan Kehadiran, Jam kerja dan Comben</h6>
                                    </div>
                                    <div class="card-body bg-light rounded-2">
                                        <div class="row">
                                            <div class="col">

                                                <p class="small text-muted">Modul ini membahas ketentuan kehadiran, jam
                                                    kerja, serta kompensasi dan benefit (Comben) yang berlaku di
                                                    perusahaan. Kamu akan mempelajari jadwal kerja resmi, aturan
                                                    keterlambatan, kebijakan lembur, hingga hak dan fasilitas yang kamu
                                                    terima sebagai karyawan</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card rounded-2 shadow-none border-success my-2">
                                    <div class="card-header">

                                        <h6 class="title py-0"><i
                                                class="bi bi-hourglass-split text-secondary me-2 fs-5"></i>
                                            Lock Absen</h6>
                                    </div>
                                    <div class="card-body bg-light rounded-2">
                                        <div class="row">
                                            <div class="col">

                                                <p class="small text-muted">Modul ini menjelaskan mekanisme ‘Lock Absen’
                                                    yang diterapkan perusahaan untuk memastikan pencatatan kehadiran
                                                    berlangsung akurat. Kamu akan mengetahui batas waktu absensi,
                                                    prosedur jika terlambat melakukan absensi, serta konsekuensi yang
                                                    mungkin timbul.</p>
                                                <button class="btn btn-primary"><i class="bi bi-arrow-right"></i>
                                                    Mulai</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div> -->



                    </div>
                    <div id="day-3-content" class="day-content">

                    </div>
                    <div id="day-50-content" class="day-content">

                    </div>
                </div>

                <h5 class="fw-bold mt-4 mb-3">Kontak Mentor</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card border border-success bg-light-success rounded-3 shadow-none">
                            <div class="card-body bg-none">
                                <div class="row">
                                    <div class="col-auto d-flex align-items-center">
                                        <figure class="avatar avatar-40 rounded-circle coverimg vm"
                                            style="background-image: url(&quot;https://trusmiverse.com/hr/uploads/profile/PF_34980_1705651590.jpg&quot;);">
                                            <img src="https://trusmiverse.com/hr/uploads/profile/PF_34980_1705651590.jpg"
                                                alt="" id="userphotoonboarding2" style="display: none;">
                                        </figure>
                                    </div>
                                    <div class="col">
                                        <h6 class="fw-bold mb-2 title py-0">Inda Sidik</h6>
                                        <p class="text-muted small">Senior Desainer - IT Division</p>
                                    </div>
                                </div>
                                <!-- <img src="https://trusmiverse.com/hr/uploads/profile/PF_34980_1705651590.jpg" class="rounded-circle mb-2"> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border border-success bg-light-success rounded-3 shadow-none">
                            <div class="card-body bg-none">
                                <div class="row">

                                    <div class="col-12">
                                        <h6 class="fw-bold mb-2 title py-0">Detail Mentorship</h6>
                                        <ul class="list-unstyled">
                                            <li class="d-flex align-items-center mb-2"><i
                                                    class="bi bi-calendar4-week me-2 text-primary"></i> <span
                                                    class="small">Durasi: 3 Bulan</span></li>
                                            <li class="d-flex align-items-center mb-2"><i
                                                    class="bi bi-clock me-2 text-primary"></i> <span class="small">Sesi
                                                    mingguan: Jumat, 10:00</span></li>
                                            <li class="d-flex align-items-center"><i
                                                    class="bi bi-person-badge me-2 text-primary"></i> <span
                                                    class="small">Jabatan Mentor: Senior Manager</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border border-success bg-light-success rounded-3 shadow-none">
                            <div class="card-body bg-none">
                                <div class="row">

                                    <div class="col-12">
                                        <h6 class="fw-bold mb-2 title py-0">Lakukan Sesi Mentoring</h6>
                                        <p class="small text-center">Jumat, 10:00</p>
                                        <a class="btn btn-success text-white"><i class="bi bi-whatsapp"></i> Hubungi
                                            Mentor</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-4">
                <?php
                $this->load->view('timeline_onboarding/chat.php');
                ?>

                <h5 class="fw-bold mt-4 mb-2">Pusat Bantuan & Tips</h5>

                <div class="card border border-success bg-light-success">
                    <div class="card-body bg-none">
                        <!-- <h6 class="fw-bold mb-0">Pusat Bantuan & Tips</h6> -->
                        <ul class="nav nav-tabs" id="bantuanTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="bantuan-tab" data-bs-toggle="tab"
                                    data-bs-target="#bantuan-tab-pane" type="button" role="tab"
                                    aria-controls="bantuan-tab-pane" aria-selected="true">Bantuan</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pertanyaan-tab" data-bs-toggle="tab"
                                    data-bs-target="#pertanyaan-tab-pane" type="button" role="tab"
                                    aria-controls="pertanyaan-tab-pane" aria-selected="false">Pertanyaan</button>
                            </li>
                        </ul>

                        <div class="tab-content bg-white pt-3" id="bantuanTabContent"
                            style="border-radius: 0px 0px 10px 10px; ">

                            <div class="tab-pane fade show active" id="bantuan-tab-pane" role="tabpanel"
                                aria-labelledby="bantuan-tab" tabindex="0">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-600 mb-0">Kenali, dan Terhubung</h6>
                                    <div>
                                        <button id="btn-scroll-left"
                                            class="btn btn-sm btn-outline-secondary py-0 px-1"><i
                                                class="bi bi-chevron-left"></i></button>
                                        <button id="btn-scroll-right"
                                            class="btn btn-sm btn-outline-secondary py-0 px-1"><i
                                                class="bi bi-chevron-right"></i></button>
                                    </div>
                                </div>
                                <div class="contact-scroll" id="div_bantuan">

                                </div>
                            </div>

                            <div class="tab-pane fade" id="pertanyaan-tab-pane" role="tabpanel"
                                aria-labelledby="pertanyaan-tab" tabindex="0">
                                <div class="accordion accordion-flush" id="faqAccordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                                Bagaimana cara mengajukan cuti?
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse"
                                            data-bs-parent="#faqAccordion">
                                            <div class="accordion-body small">
                                                Anda dapat mengajukan cuti melalui menu "Pengajuan Cuti" di aplikasi.
                                                Pilih tanggal, jenis cuti, dan isi keterangan jika diperlukan. Pengajuan
                                                akan diteruskan ke atasan Anda untuk persetujuan.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                                Di mana saya bisa melihat slip gaji?
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse"
                                            data-bs-parent="#faqAccordion">
                                            <div class="accordion-body small">
                                                Slip gaji tersedia setiap akhir bulan di menu "Profil Saya", lalu pilih
                                                bagian "Payroll & Gaji". Anda dapat mengunduhnya dalam format PDF.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                                Apa saja benefit yang didapatkan karyawan?
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse"
                                            data-bs-parent="#faqAccordion">
                                            <div class="accordion-body small">
                                                Benefit karyawan meliputi asuransi kesehatan, dana pensiun, bonus
                                                kinerja tahunan, dan program pelatihan pengembangan diri. Detail
                                                lengkapnya ada di dokumen onboarding Anda.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="fw-bold mb-1 mt-4">Perlengkapan Kerja</h5>
                <div id="div_perlengkapan">

                </div>
                <!-- <div class="card border border-success bg-light-success rounded-3 shadow-none my-2">
                    <div class="card-body bg-none">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0">
                                <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                                Absen Pertama Trusmi Ontime
                            </h6>
                            <p class="mb-0">Selesai</p>
                        </div>
                    </div>
                </div>
                <div class="card border border-success bg-light-success rounded-3 shadow-none my-2">
                    <div class="card-body bg-none">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0">
                                <i class="bi bi-hourglass-split text-primary me-2 fs-5"></i>
                                ID Card
                            </h6>
                            <button class="btn btn-sm btn-link" onclick="form_pengajuan('id_card')">Form <i
                                    class="bi bi-arrow-right"></i></button>
                            <p class="mb-0 link-primary" style='cursor:pointer'></p>
                        </div>
                    </div>
                </div>
                <div class="card border border-success bg-light-success rounded-3 shadow-none my-2">
                    <div class="card-body bg-none">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0">
                                <i class="bi bi-hourglass-split text-primary me-2 fs-5"></i>
                                Kursi, Meja, Seragam
                            </h6>
                            <p class="mb-0 link-primary" style='cursor:pointer'>Diproses</p>
                        </div>
                    </div>
                </div>
                <div class="card border border-success bg-light-success rounded-3 shadow-none my-2">
                    <div class="card-body bg-none">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0">
                                <i class="bi bi-hourglass-split text-primary me-2 fs-5"></i>
                                Akun Email
                            </h6>
                            <p class="mb-0 link-primary" style='cursor:pointer'>Diproses</p>
                        </div>
                    </div>
                </div>
                <div class="card border border-success bg-light-success rounded-3 shadow-none my-2">
                    <div class="card-body bg-none">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0">
                                <i class="bi bi-hourglass-split text-primary me-2 fs-5"></i>
                                Laptop & Aksesoris
                            </h6>
                            <p class="mb-0">Isi Form</p>
                        </div>
                    </div>
                </div> -->

            </div>
        </div>
    </div>
</main>
<div class="modal fade" id="modal_welcome" aria-labelledby="modalWelcomeLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Terms and Conditions - Onboarding Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <p>Proses onboarding ini bertujuan untuk memastikan seluruh karyawan memahami hak, kewajiban, dan
                    ketentuan kerja sebelum memulai tugas di lingkungan perusahaan. Mohon untuk membaca dan memahami
                    ketentuan berikut dengan seksama.</p>

                <ol>
                    <li>
                        <strong>Penerimaan Onboarding</strong>
                        <p class="mb-1">Dengan memulai proses onboarding ini, Anda menyatakan:</p>
                        <ul>
                            <li>Bersedia mengikuti seluruh tahapan onboarding sesuai jadwal yang ditentukan.</li>
                            <li>Menyediakan data pribadi yang benar, lengkap, dan dapat dipertanggungjawabkan.</li>
                            <li>Mematuhi instruksi yang diberikan oleh HR maupun atasan terkait proses onboarding.
                            </li>
                        </ul>
                    </li>
                    <li>
                        <strong>Kewajiban Karyawan</strong>
                        <p class="mb-1">Selama masa onboarding, Anda wajib:</p>
                        <ul>
                            <li>Mengikuti setiap sesi pelatihan dan orientasi (Company Profile, SOP, Job Profile,
                                Sistem Kerja, dll).</li>
                            <li>Mematuhi peraturan perusahaan termasuk jam kerja, tata tertib, dan kebijakan
                                internal.</li>
                            <li>Menggunakan fasilitas dan perlengkapan kerja sesuai peruntukan, menjaga keamanan,
                                dan mengembalikannya jika diminta.</li>
                            <li>Menjaga kerahasiaan seluruh informasi, dokumen, dan data perusahaan.</li>
                        </ul>
                    </li>
                    <li>
                        <strong>Kepatuhan Terhadap Peraturan</strong>
                        <p>Segala pelanggaran terhadap peraturan yang disampaikan selama onboarding dapat
                            berpengaruh pada status kepegawaian Anda. Anda berkewajiban memahami dan mematuhi
                            kebijakan Comben & Personalia, Peraturan Perusahaan, Instruksi Kerja (IK), dan Standar
                            Operasional Prosedur (SOP) yang dijelaskan.</p>
                    </li>
                    <li>
                        <strong>Penggunaan Sistem dan Akses</strong>
                        <p>Anda akan menerima akses ke sistem internal (email, aplikasi kerja, akun absensi, dll)
                            dan berkewajiban menggunakannya hanya untuk kepentingan pekerjaan. Kredensial (username,
                            password) bersifat rahasia dan tidak boleh dibagikan kepada pihak lain.</p>
                    </li>
                    <li>
                        <strong>Persetujuan dan Komitmen</strong>
                        <p class="mb-1">Dengan menyetujui syarat ini, Anda menyatakan bahwa:</p>
                        <ul>
                            <li>Telah menerima, memahami, dan siap menjalankan seluruh materi onboarding.</li>
                            <li>Akan mematuhi aturan dan kebijakan perusahaan selama masa kerja.</li>
                            <li>Siap menjalankan tugas dengan penuh tanggung jawab sesuai instruksi yang diberikan.
                            </li>
                        </ul>
                    </li>
                </ol>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-space align-items-center">
                    <div class="form-check me-3">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Saya telah membaca dan setuju dengan Syarat & Ketentuan Onboarding serta seluruh kebijakan
                            perusahaan yang berlaku
                        </label>
                    </div>

                    <button type="button" class="btn btn-md btn-primary" id="btn-setuju" data-id="5" data-link="#"
                        disabled>
                        Setuju
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_pengajuan" aria-labelledby="modalWelcomeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="label_pengajuan">Form Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <form id="form_id_card" class="pengajuan-form" style="display: none;">
                    <div class="mb-3 form-group">
                        <label for="id_nama" class="form-label">Nama</label>
                        <input type="text" class="form-control border-custom" id="id_nama"
                            value="Nama Karyawan (Otomatis)" readonly>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="id_department" class="form-label">Department</label>
                        <input type="text" class="form-control border-custom" id="id_department"
                            value="Departemen (Otomatis)" readonly>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="id_lokasi" class="form-label">Lokasi Kantor</label>
                        <input type="hidden" name="tipe" value="id_card">
                        <input type="hidden" name="id_tipe" value="1">
                        <select class="form-select border-custom" id="id_lokasi" name="lokasi">
                            <option selected disabled>Pilih Lokasi...</option>
                            <option value="jmp1">Kantor Utama JMP 1</option>
                            <option value="tegalsari">Kantor Tegalsari</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send-fill me-2"></i>Submit Pengajuan
                            </button>
                        </div>
                    </div>
                </form>

                <form id="form_kursi" class="pengajuan-form" style="display: none;">
                    <input type="hidden" name="tipe" value="kursi">
                    <input type="hidden" name="id_tipe" value="2">
                    <div class="mb-3 form-group">
                        <label for="kursi_lokasi" class="form-label">Lokasi Penempatan</label>
                        <select class="form-select border-custom" name="lokasi" id="kursi_lokasi">
                            <option selected disabled>Pilih Lokasi...</option>
                            <option value="jmp1">Kantor Utama JMP 1</option>
                            <option value="tegalsari">Kantor Tegalsari</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send-fill me-2"></i>Submit Pengajuan
                            </button>
                        </div>
                    </div>
                </form>

                <form id="form_seragam" class="pengajuan-form" style="display: none;">
                    <input type="hidden" name="tipe" value="seragam">
                    <input type="hidden" name="id_tipe" value="3">
                    <div class="mb-3 form-group">
                        <label for="seragam_pilih" class="form-label">Pilih Seragam</label>
                        <select class="form-select border-custom" name="seragam" id="seragam_pilih">
                            <option selected disabled>Pilih Jenis Seragam...</option>
                            <option value="kemeja_panjang">Kemeja Lengan Panjang</option>
                            <option value="kemeja_pendek">Kemeja Lengan Pendek</option>
                            <option value="polo">Polo Shirt</option>
                        </select>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="seragam_lokasi" class="form-label">Lokasi Pengiriman</label>
                        <select class="form-select border-custom" name="lokasi" id="seragam_lokasi">
                            <option selected disabled>Pilih Lokasi...</option>
                            <option value="jmp1">Kantor Utama JMP 1</option>
                            <option value="tegalsari">Kantor Tegalsari</option>
                        </select>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="seragam_detail" class="form-label">Detail (Ukuran, Catatan, dll)</label>
                        <textarea class="form-control border-custom" name="detail" id="seragam_detail"
                            rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send-fill me-2"></i>Submit Pengajuan
                            </button>
                        </div>
                    </div>
                </form>

                <form id="form_akun_email" class="pengajuan-form" style="display: none;">
                    <input type="hidden" name="tipe" value="akun_email">
                    <input type="hidden" name="id_tipe" value="3">
                    <div class="mb-3 form-group">
                        <label for="email_nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control border-custom" id="email_nama"
                            value="Nama Karyawan (Otomatis)" readonly>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="email_usulan" class="form-label">Usulan Alamat Email</label>
                        <div class="input-group">
                            <input type="text" name="email_usulan" class="form-control border-custom" id="email_usulan"
                                placeholder="contoh: budi.santoso">
                            <span class="input-group-text">@perusahaan.com</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send-fill me-2"></i>Submit Pengajuan
                            </button>
                        </div>
                    </div>
                </form>

                <form id="form_laptop" class="pengajuan-form" style="display: none;">
                    <input type="hidden" name="tipe" value="laptop">
                    <input type="hidden" name="id_tipe" value="4">
                    <div class="mb-3 form-group">
                        <label for="laptop_lokasi" class="form-label">Lokasi Penempatan</label>
                        <select class="form-select border-custom" name="lokasi" id="laptop_lokasi">
                            <option selected disabled>Pilih Lokasi...</option>
                            <option value="Kantor Utama JMP 1">Kantor Utama JMP 1</option>
                            <option value="Kantor Tegalsari">Kantor Tegalsari</option>
                        </select>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="laptop_spek" class="form-label">Detail Spesifikasi</label>
                        <textarea class="form-control border-custom" name="detail" id="laptop_spek" rows="4"
                            placeholder="Contoh: Core i5, RAM 16GB, SSD 512GB untuk kebutuhan Desain Grafis..."></textarea>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send-fill me-2"></i>Submit Pengajuan
                            </button>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>