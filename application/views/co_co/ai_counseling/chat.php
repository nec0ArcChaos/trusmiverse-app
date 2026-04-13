<main class="main mainheight">
    <div class="flex w-full flex-1 justify-center py-8">
        <section class="flex-1 flex flex-col max-w-5xl bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800">
            <div class="flex flex-col h-full">
                <!-- PageHeading & Session Actions -->
                <div class="p-6 border-b border-slate-200 dark:border-slate-800">
                    <div class="flex flex-wrap justify-between items-start gap-4">
                        <div class="flex flex-col gap-1">
                            <p class="text-slate-900 dark:text-white text-3xl font-black leading-tight tracking-[-0.033em]">Selamat Datang, <?= $counselling['karyawan'] ?>!</p>
                            <div class="flex items-center gap-2">
                                <p class="text-slate-500 dark:text-slate-400 text-base font-normal leading-normal">Sesi Anda bersifat pribadi dan rahasia.</p>
                                <span class="material-symbols-outlined text-slate-400 text-base">lock</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <?php if ($counselling['status'] == 1) { ?>
                                <a href="<?= base_url() ?>ai_counseling" class="flex items-center justify-center gap-2 min-w-[84px] max-w-[480px] cursor-pointer overflow-hidden rounded-lg h-10 px-4 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 text-sm font-bold leading-normal tracking-[0.015em] hover:bg-slate-200 dark:hover:bg-slate-700">
                                    <span class="material-symbols-outlined text-lg">arrow_back</span>
                                    <span class="truncate">Kembali</span>
                                </a>
                            <?php } else { ?>
                                <a href="<?= base_url() ?>ai_counseling" class="flex items-center justify-center gap-2 min-w-[84px] max-w-[480px] cursor-pointer overflow-hidden rounded-lg h-10 px-4 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 text-sm font-bold leading-normal tracking-[0.015em] hover:bg-slate-200 dark:hover:bg-slate-700">
                                    <span class="material-symbols-outlined text-lg">save</span>
                                    <span class="truncate">Simpan &amp; Keluar</span>
                                </a>
                                <button id="btn_akhiri_sesi" class="flex items-center justify-center gap-2 min-w-[84px] max-w-[480px] cursor-pointer overflow-hidden rounded-lg h-10 px-4 bg-red-500/10 dark:bg-red-500/20 text-red-600 dark:text-red-400 text-sm font-bold leading-normal tracking-[0.015em] hover:bg-red-500/20 dark:hover:bg-red-500/30">
                                    <span class="material-symbols-outlined text-lg">power_settings_new</span>
                                    <span class="truncate">Akhiri Sesi</span>
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- SectionHeader -->
                <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800">
                    <h2 class="text-slate-800 dark:text-slate-100 text-lg font-bold leading-tight tracking-[-0.015em]">Fokus Sesi: Pengembangan Karir</h2>
                </div>
                <!-- Chat Area -->
                <div id="chat" class="flex-1 p-6 space-y-6 overflow-y-auto" style="min-height: 300px;">
                </div>
                <?php if ($counselling['status'] == 1) { ?>
                    <div class="col-12">
                        <div class="card bg-secondary border-0">
                            <div class="card-body">
                                <!-- Session Closed -->
                                <div class="session-card bg-white rounded-3 p-5 text-center">
                                    <div class="mb-4">
                                        <div class="success-icon">
                                            <span class="material-symbols-outlined text-success" style="font-size: 40px;">check_circle</span>
                                        </div>
                                        <h1 class="h2 fw-bold text-dark mb-2">Sesi Telah Berakhir</h1>
                                        <p class="text-muted">Terima kasih telah menggunakan layanan konseling AI kami. Sesi Anda telah disimpan dan dapat diakses kembali kapan saja.</p>
                                    </div>

                                    <div class="session-summary mb-4">
                                        <h2 class="h5 fw-semibold text-dark mb-3">Ringkasan Sesi</h2>
                                        <div class="row">
                                            <div class="col-6 mb-2">
                                                <span class="text-muted">Topik:</span>
                                                <span class="fw-medium d-block"><?= $counselling['review'] ?></span>
                                            </div>
                                            <div class="col-6 mb-2">
                                                <span class="text-muted">Durasi:</span>
                                                <span class="fw-medium d-block"><?= $counselling['duration'] ?> menit</span>
                                            </div>
                                            <div class="col-6 mb-2">
                                                <span class="text-muted">Peserta:</span>
                                                <span class="fw-medium d-block"><?= $counselling['karyawan'] ?></span>
                                            </div>
                                            <div class="col-6 mb-2">
                                                <span class="text-muted">Status:</span>
                                                <span class="fw-medium text-success d-block">Selesai</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                                        <a href="<?= base_url() ?>ai_counseling/result/<?= $counselling['id_coaching'] ?>" target="_blank" class="btn btn-primary d-flex align-items-center justify-content-center gap-2">
                                            <span class="material-symbols-outlined">download</span>
                                            <span>Lihat Hasil</span>
                                        </a>
                                        <a href="<?= base_url() ?>ai_counseling" class="btn btn-outline-secondary d-flex align-items-center justify-content-center gap-2">
                                            <span class="material-symbols-outlined">home</span>
                                            <span>Kembali ke Beranda</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <!-- Chat Input -->
                    <div class="p-6 border-t border-slate-200 dark:border-slate-800 mt-auto">
                        <div class="flex items-center gap-4">
                            <input id="message" name="message" class="form-input flex-1 w-full rounded-lg border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/50 text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:ring-primary focus:border-primary" placeholder="Ketik pesan Anda..." type="text" />
                            <button type="button" id="btn_send_message" class="flex items-center justify-center size-10 rounded-lg bg-primary text-white hover:bg-blue-600 dark:hover:bg-blue-500 flex-shrink-0">
                                <span class="material-symbols-outlined">send</span>
                            </button>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
    </div>
</main>