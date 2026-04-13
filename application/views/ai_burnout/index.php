<!-- <body class="bg-gray-50 min-h-screen"> -->
<main class="main mainheight" style="margin-top:70px">
    <div class="container-fluid px-0">

        <!-- Landing Page Section -->
        <section id="landing-page" class="section active">
            <!-- Header -->
            <header class="container mx-auto px-4 mt-4">
                <div class="bg-white/80 backdrop-blur-lg shadow-md border border-gray-200 rounded-full flex items-center justify-between p-2 glass-card">
                    <!-- Logo Section -->
                    <div class="flex items-center">
                        <a href="/" class="flex items-center ml-2">
                            <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                </path>
                            </svg>
                            <span class="text-xl sm:text-2xl font-bold text-gray-900 pl-2 hidden sm:block">BurnoutDetect</span>
                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <nav class="hidden lg:flex items-center space-x-6">
                        <button onclick="navigateTo('education-page')" class="text-gray-700 hover:text-blue-600 transition-colors font-medium">
                            Edukasi
                        </button>
                        <button onclick="navigateTo('history-page')" class="text-gray-700 hover:text-blue-600 transition-colors font-medium">
                            Riwayat
                        </button>
                        <!-- <button onclick="navigateTo('admin-page')" class="text-gray-700 hover:text-blue-600 transition-colors font-medium">
                            Admin
                        </button> -->
                    </nav>

                    <!-- Right side (Login + Mobile Menu) -->
                    <div class="flex items-center gap-2 pr-2">
                        <a onclick="navigateTo('questionnaire-page')"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-full transition-colors flex items-center gap-2">
                            Diagnosa
                            <span class="mdi mdi-login"></span>
                        </a>
                        <div class="lg:hidden">
                            <button id="mobile-menu-button" class="text-gray-700 focus:outline-none bg-gray-200 rounded-full p-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16m-7 6h7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <div id="mobile-menu-panel"
                    class="hidden lg:hidden mt-2 bg-white shadow-lg rounded-lg border border-gray-200 overflow-hidden">
                    <button onclick="navigateTo('education-page')"
                        class="block w-full text-left px-4 py-3 text-gray-700 hover:text-blue-600 transition-colors font-medium border-b">
                        Edukasi
                    </button>
                    <button onclick="navigateTo('history-page')"
                        class="block w-full text-left px-4 py-3 text-gray-700 hover:text-blue-600 transition-colors font-medium border-b">
                        Riwayat
                    </button>
                    <!-- <button onclick="navigateTo('admin-page')"
                        class="block w-full text-left px-4 py-3 text-gray-700 hover:text-blue-600 transition-colors font-medium">
                        Admin
                    </button> -->
                </div>
            </header>


            <!-- Hero Section -->
            <section class="py-20 px-4">
                <div class="max-w-7xl mx-auto text-center">
                    <div class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-full mb-4">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Sistem Pakar Berbasis AI
                    </div>
                    <h1 class="text-5xl font-bold text-gray-900 mb-6">
                        Deteksi Dini <span class="text-blue-600">Burnout Karyawan</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                        Sistem pakar dengan metode Certainty Factor untuk mengidentifikasi tingkat stres karyawan
                        secara akurat dan memberikan solusi yang tepat
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button onclick="navigateTo('questionnaire-page')" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                            Mulai Diagnosa
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>
                        <button onclick="navigateTo('education-page')" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 rounded-lg hover:bg-gray-50 border border-gray-300 font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Pelajari Lebih Lanjut
                        </button>
                    </div>
                </div>
            </section>

            <div class="w-full h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>

            <!-- Features Section -->
            <section class="py-20 px-4">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Mengapa Memilih BurnoutDetect?</h2>
                        <p class="text-lg text-gray-600">Teknologi canggih dengan metode teruji untuk hasil yang akurat</p>
                    </div>

                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="glass-card p-6 text-center">
                            <div class="mx-auto w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">Metode CF</h3>
                            <p class="text-gray-600">Certainty Factor memberikan hasil diagnosa dengan tingkat kepastian yang akurat</p>
                        </div>

                        <div class="glass-card p-6 text-center">
                            <div class="mx-auto w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">43 Gejala</h3>
                            <p class="text-gray-600">Komprehensif dengan 43 gejala stres yang telah divalidasi oleh para ahli</p>
                        </div>

                        <div class="glass-card p-6 text-center">
                            <div class="mx-auto w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">Real-time</h3>
                            <p class="text-gray-600">Hasil diagnosa langsung dengan rekomendasi solusi yang personal</p>
                        </div>

                        <div class="glass-card p-6 text-center">
                            <div class="mx-auto w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">HR Dashboard</h3>
                            <p class="text-gray-600">Monitor kesehatan mental seluruh karyawan dalam satu dashboard</p>
                        </div>
                    </div>
                </div>
            </section>

            <div class="w-full h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>

            <!-- Statistics Section -->
            <section class="py-20 px-4">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Dukungan untuk Kesehatan Mental</h2>
                        <p class="text-lg text-gray-600">Statistik tentang burnout di lingkungan kerja</p>
                    </div>

                    <div class="grid md:grid-cols-3 gap-8">
                        <div class="bg-white rounded-lg shadow p-6 text-center">
                            <div class="text-4xl font-bold text-blue-600 mb-2">76%</div>
                            <h3 class="text-xl font-semibold mb-2">Karyawan Mengalami Burnout</h3>
                            <p class="text-gray-600">Menurut survei global, sebagian besar karyawan mengalami tingkat stres yang tinggi</p>
                        </div>

                        <div class="bg-white rounded-lg shadow p-6 text-center">
                            <div class="text-4xl font-bold text-green-600 mb-2">4x</div>
                            <h3 class="text-xl font-semibold mb-2">Lebih Produktif</h3>
                            <p class="text-gray-600">Karyawan dengan kesehatan mental baik 4x lebih produktif dan engagement</p>
                        </div>

                        <div class="bg-white rounded-lg shadow p-6 text-center">
                            <div class="text-4xl font-bold text-purple-600 mb-2">89%</div>
                            <h3 class="text-xl font-semibold mb-2">Rekomendasi Positif</h3>
                            <p class="text-gray-600">Pengguna melaporkan peningkatan kesehatan mental setelah mengikuti rekomendasi</p>
                        </div>
                    </div>
                </div>
            </section>

            <div class="w-full h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>

            <!-- Process Section -->
            <section class="py-20 px-4">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Cara Kerja Sistem</h2>
                        <p class="text-lg text-gray-600">3 langkah mudah untuk mendeteksi tingkat stres Anda</p>
                    </div>

                    <div class="grid md:grid-cols-3 gap-8">
                        <div class="text-center">
                            <div class="mx-auto w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                                <span class="text-2xl font-bold text-blue-600">1</span>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">Isi Kuesioner</h3>
                            <p class="text-gray-600">Jawab 43 pertanyaan tentang gejala stres yang Anda alami</p>
                        </div>

                        <div class="text-center" onclick="updateDiagnose()">
                            <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                                <span class="text-2xl font-bold text-green-600">2</span>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">Analisis CF</h3>
                            <p class="text-gray-600">Sistem menganalisis jawaban dengan metode Certainty Factor</p>
                        </div>

                        <div class="text-center">
                            <div class="mx-auto w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                                <span class="text-2xl font-bold text-purple-600">3</span>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">Dapatkan Hasil</h3>
                            <p class="text-gray-600">Lihat hasil diagnosa dan dapatkan rekomendasi solusi yang tepat</p>
                        </div>
                    </div>
                </div>
            </section>

            <div class="w-full h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>

            <!-- Testimonials Section -->
            <section class="py-20 px-4">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Apa Kata Pengguna?</h2>
                        <p class="text-lg text-gray-600">Testimoni dari karyawan yang telah menggunakan sistem ini</p>
                    </div>

                    <div class="grid md:grid-cols-3 gap-8" id="top_rate_testimoni">
                        
                    </div>
                </div>
            </section>

            <div class="w-full h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>

            <!-- CTA Section -->
            <section class="py-20 px-4">
                <div class="max-w-4xl mx-auto text-center">
                    <h2 class="text-3xl font-bold mb-4">Siap Memeriksa Kesehatan Mental Anda?</h2>
                    <p class="text-xl text-blue-400 mb-8">Mulai diagnosa sekarang dan dapatkan rekomendasi solusi yang tepat untuk Anda</p>
                    <button onclick="navigateTo('questionnaire-page')" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 rounded-lg hover:bg-gray-100 font-medium text-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                        Mulai Diagnosa Gratis
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </button>
                </div>
            </section>

            <!-- Footer -->
            <footer class="bg-gray-900 text-white py-12 px-4">
                <div class="max-w-7xl mx-auto text-center">
                    <div class="flex items-center justify-center space-x-2 mb-4">
                        <svg class="h-8 w-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                        <span class="text-2xl font-bold">BurnoutDetect</span>
                    </div>
                    <p class="text-gray-400 mb-8">Sistem pakar untuk deteksi dini burnout karyawan dengan metode Certainty Factor</p>
                    <!-- <div class="border-t border-gray-800 pt-8">
                        <p class="text-gray-400">&copy; 2024 BurnoutDetect. All rights reserved.</p>
                    </div> -->
                </div>
            </footer>
        </section>

        <!-- Questionnaire Page Section -->
        <section id="questionnaire-page" class="section">
            <div class="min-h-screen py-8">
                <div class="max-w-7xl mx-auto px-4">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center space-x-4">
                            <button id="questionnaireBerandaBtn" class="inline-flex items-center px-4 py-2 bg-white rounded-lg hover:bg-gray-50 shadow save-questionnaire">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Beranda
                            </button>
                        </div>
                        <div class="flex items-center space-x-3">
                            <!-- <button onclick="navigateTo('questionnaire-page')" class="inline-flex items-center px-4 py-2 bg-white rounded-lg hover:bg-gray-50 shadow">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Diagnosa Baru
                        </button>
                        <button onclick="exportHistory()" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 shadow">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Export
                        </button> -->
                        </div>
                    </div>
                    <div class="max-w-4xl mx-auto px-4">
                        <!-- Header -->
                        <div class="text-center mb-8">
                            <div class="flex items-center justify-center mb-4">
                                <svg class="h-8 w-8 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                                <h1 class="text-3xl font-bold text-gray-900">Kuesioner Deteksi Stres</h1>
                            </div>
                            <p class="text-gray-600">Jawab pertanyaan berikut berdasarkan kondisi Anda selama 1 bulan terakhir</p>
                        </div>

                        <!-- Progress Card -->
                        <div class="glass-card p-6 mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center space-x-2">
                                    <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700">
                                        Pertanyaan <span id="current-question-num">1</span> dari <span id="total-questions">43</span>
                                    </span>
                                </div>
                                <span class="text-sm font-medium text-blue-600" id="progress-percentage">0%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div id="progress-bar" class="bg-blue-600 h-2 rounded-full transition-all" style="width: 0%"></div>
                            </div>
                        </div>


                        <!-- Question Card -->
                        <div class="glass-card p-6 mb-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-2" id="question-text"></h2>
                            <!-- <p class="text-gray-600 mb-6">Pilih jawaban yang paling sesuai dengan kondisi Anda</p> -->

                            <div id="answer-options" class="space-y-3">
                                <!-- Answer options will be inserted here -->
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div id="navigation-buttons" class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 space-y-3 sm:space-y-0">

                            <!-- Prev Button -->
                            <button id="prev-btn" onclick="previousQuestion()"
                                class="w-auto inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                <span id="prev-btn-text">Sebelumnya</span>
                            </button>

                            <!-- Counter -->
                            <div class="flex items-center justify-center space-x-2 text-sm text-gray-600">
                                <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span><span id="answered-count">0</span> pertanyaan terjawab</span>
                            </div>

                            <!-- Next Button -->
                            <button id="next-btn" onclick="nextQuestion()"
                                class="w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                <span id="next-btn-text">Selanjutnya</span>
                                <svg class="h-4 w-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>

                        </div>

                        <!-- Quick Navigation Card -->
                        <div class="glass-card p-6 mb-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Navigasi Cepat</h2>
                            <!-- <div id="quick-navigation" class="grid grid-cols-10 gap-2">

                        </div> -->
                            <div class="overflow-x-auto py-2 -mx-4 px-4 sm:mx-0 sm:px-0" aria-label="Quick navigation">
                                <div id="quick-navigation" class="flex space-x-2 md:space-x-0 w-max sm:grid sm:grid-cols-10 sm:gap-2 sm:w-full">

                                </div>
                            </div>
                        </div>


                        <!-- Back to Home -->
                        <div class="text-center">
                            <button id="backHomeBtn" class="text-blue-600 hover:text-blue-700 save-questionnaire">
                                ← Kembali ke Beranda
                            </button>
                        </div>
                    </div>
                </div>
        </section>

        <!-- Result Page Section -->
        <section id="result-page" class="section">
            <div class="min-h-screen py-8">
                <div class="max-w-6xl mx-auto px-4">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-8">
                        <button onclick="navigateTo('landing-page')" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Beranda
                        </button>
                    </div>

                    <!-- Result Header -->
                    <div class="bg-white rounded-lg shadow p-8 mb-6 text-center">
                        <div class="mx-auto w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="h-10 w-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">Hasil Diagnosa Stres</h1>
                        <p class="text-gray-600">Berdasarkan analisis dengan metode Certainty Factor</p>
                    </div>

                    <!-- Main Result -->
                    <div class="grid lg:grid-cols-2 gap-6 mb-6">
                        <!-- Diagnosis Result -->
                        <div id="diagnosis-card" class="bg-white rounded-lg shadow p-6 border-2">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-xl font-semibold">Tingkat Stres</h2>
                                <div class="text-4xl" id="stress-emoji"></div>
                            </div>
                            <div class="text-center mb-6">
                                <div class="text-3xl font-bold mb-2" id="diagnosis-name"></div>
                                <div class="text-5xl font-bold text-blue-600 mb-2" id="diagnosis-percentage"></div>
                                <div class="text-sm text-gray-600">Tingkat Keyakinan</div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3 mb-4">
                                <div id="result-progress-bar" class="bg-blue-600 h-3 rounded-full transition-all"></div>
                            </div>
                            <!-- <div class="text-center text-sm text-gray-600">
                                CF Combined: <span id="cf-combined"></span>
                            </div> -->
                        </div>

                        <!-- Patient Info -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-xl font-semibold mb-4 flex items-center">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Informasi Karyawan
                            </h2>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Nama:</span>
                                    <span class="font-medium" id="employee-name">User</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Departemen:</span>
                                    <span class="font-medium" id="employee-dept">General</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tanggal Tes:</span>
                                    <span class="font-medium" id="test-date"></span>
                                    <input type="hidden" id="test-id">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Solutions -->
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <h2 class="text-xl font-semibold mb-4 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Rekomendasi Solusi
                        </h2>
                        <div id="solutions-list" class="space-y-3">
                            <!-- Solutions will be inserted here -->
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-center space-x-4 mb-6">
                        <button onclick="navigateTo('questionnaire-page')" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Ulangi Diagnosa
                        </button>
                        <!-- onclick="downloadResult()" -->
                        <button class="open-modal-btn inline-flex items-center px-6 py-3 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 17.75l-6.16 3.73 1.64-7.03L2 9.51l7.19-.62L12 2.5l2.81 6.39L22 9.51l-5.48 4.94 1.64 7.03z" />
                            </svg>
                            Beri Penilaian
                        </button>
                    </div>

                    <!-- Important Notice -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex">
                            <svg class="h-5 w-5 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <div>
                                <strong class="text-yellow-800">Penting:</strong>
                                <span class="text-yellow-700"> Hasil diagnosa ini bersifat informasional dan bukan pengganti konsultasi dengan profesional kesehatan mental. Jika Anda mengalami stres berat, segera hubungi dokter atau psikolog.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- History Page Section -->
        <section id="history-page" class="section">
            <div class="min-h-screen py-8">
                <div class="max-w-7xl mx-auto px-4">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center space-x-4">
                            <button onclick="navigateTo('landing-page')" class="inline-flex items-center px-4 py-2 bg-white rounded-lg hover:bg-gray-50 shadow">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Beranda
                            </button>
                            <h1 class="text-2xl font-bold text-gray-900">Riwayat Diagnosa</h1>
                        </div>
                        <div class="flex items-center space-x-3">
                            <?php 
                            $allowed_akses = ['2063', '1', '979'];
                            $class_none = "hidden";
                            $user_id = $this->session->userdata("user_id");

                            if (in_array($user_id, $allowed_akses)) {
                                $class_none = "";
                            }
                            ?>
                            <select 
                                name="employee_id" 
                                id="employee_id"
                                class="w-200px text-dark <?= $class_none; ?>"
                                onchange="loadHistory(this.value)">
                            </select>

                            <button onclick="navigateTo('questionnaire-page')" 
                                class="inline-flex items-center h-11 px-4 bg-white text-gray-700 rounded-lg hover:bg-gray-50 border border-gray-200 shadow-sm transition">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg>
                                Diagnosa Baru
                            </button>

                            <button onclick="exportHistory()" 
                                class="inline-flex items-center h-11 px-4 bg-gray-700 text-white rounded-lg hover:bg-gray-800 shadow-sm transition">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                                    </path>
                                </svg>
                                Export
                            </button>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
                        <div class="glass-card p-6 text-center">
                            <div class="text-4xl font-bold text-blue-600 mb-2" id="stat-total">0</div>
                            <div class="text-sm text-gray-600">Total Diagnosa</div>
                        </div>
                        <div class="glass-card p-6 text-center">
                            <div class="text-4xl font-bold text-green-600 mb-2" id="stat-tidak-stres">0</div>
                            <div class="text-sm text-gray-600">Tidak Stres</div>
                        </div>
                        <div class="glass-card p-6 text-center">
                            <div class="text-4xl font-bold text-yellow-500 mb-2" id="stat-stres-rendah">0</div>
                            <div class="text-sm text-gray-600">Stres Rendah</div>
                        </div>
                        <div class="glass-card p-6 text-center">
                            <div class="text-4xl font-bold text-orange-500 mb-2" id="stat-stres-sedang">0</div>
                            <div class="text-sm text-gray-600">Stres Sedang</div>
                        </div>
                        <div class="glass-card p-6 text-center">
                            <div class="text-4xl font-bold text-red-600 mb-2" id="stat-stres-tinggi">0</div>
                            <div class="text-sm text-gray-600">Stres Tinggi</div>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="glass-card p-6 mb-8">
                        <div class="flex items-center mb-4">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            <h2 class="text-lg font-semibold">Filter</h2>
                        </div>
                        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">

                            <!-- <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                            <div class="relative">
                                <input type="text" id="search-input" placeholder="Cari nama, email, atau diagnosa..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" onkeyup="filterHistory()">
                                <svg class="absolute right-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div> -->

                            <!-- LEFT SIDE: grid for selects -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 flex-1">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tingkat Stres</label>
                                    <select id="stress-filter"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg cursor-pointer hover:ring-2 hover:ring-blue-500 hover:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        onchange="filterHistory()">
                                        <option value="">Semua Level</option>
                                        <option value="D1">Tidak Stres</option>
                                        <option value="D2">Stres Rendah</option>
                                        <option value="D3">Stres Sedang</option>
                                        <option value="D4">Stres Tinggi</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Rentang Waktu</label>
                                    <select id="time-filter"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg cursor-pointer hover:ring-2 hover:ring-blue-500 hover:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        onchange="filterHistory()">
                                        <option value="">Semua Waktu</option>
                                        <option value="today">Hari Ini</option>
                                        <option value="week">Minggu Ini</option>
                                        <option value="month">Bulan Ini</option>
                                        <option value="year">Tahun Ini</option>
                                    </select>
                                </div>

                            </div>

                            <!-- RIGHT SIDE: reset button -->
                            <div class="flex justify-end md:justify-end">
                                <button onclick="resetFilters()"
                                    class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                    Reset Filter
                                </button>
                            </div>

                        </div>
                    </div>

                    <!-- Results Section -->
                    <div class="glass-card overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-xl font-semibold">Hasil Diagnosa (<span id="result-count">0</span>)</h2>
                                <div class="text-sm text-gray-600">Rata-rata: <span id="average-percentage" class="font-semibold">0.0%</span></div>
                            </div>
                            <div id="history-list">
                                <div class="flex flex-col items-center justify-center py-16">
                                    <svg class="h-24 w-24 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    <p class="text-gray-500 text-center mb-2">Tidak ada hasil diagnosa yang ditemukan</p>
                                    <p class="text-gray-400 text-sm text-center">Coba ubah filter atau lakukan diagnosa baru</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Education Page Section -->
        <section id="education-page" class="section">
            <div class="min-h-screen py-8">
                <div class="max-w-7xl mx-auto px-4">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-8">
                        <button onclick="navigateTo('landing-page')" class="inline-flex items-center px-4 py-2 bg-white rounded-lg hover:bg-gray-50 shadow">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Beranda
                        </button>
                        <div class="flex items-center space-x-2">
                            <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <h1 class="text-3xl font-bold text-gray-900">Pusat Edukasi</h1>
                            <?php if ($this->session->userdata('user_id') == 1) { ?>
                                <button onclick="addNewArticle()" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:bg-blue-700 shadow">
                                    <i class="bi bi-save mr-2"></i>
                                    Artikel Baru
                                </button>
                                
                                <!-- <button class="saveAndPreviewArticle px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-150 shadow-lg flex items-center">
                                    <i data-lucide="save" class="w-5 h-5 mr-2"></i> Save & Preview
                                </button> -->
                            <?php } ?>
                        </div>
                    </div>
                    
                    <div id="main-education-page">
                        <!-- Hero Section -->
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg shadow p-8 mb-8 text-center">
                            <h2 class="text-3xl font-bold mb-4">Pelajari Tentang Kesehatan Mental Kerja</h2>
                            <p class="text-xl text-blue-100">Dapatkan wawasan mendalam tentang burnout, stres, dan cara menjaga keseimbangan kerja-hidup</p>
                        </div>

                        <!-- Articles Grid -->
                        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        
                            <!-- Article 1: Burnout -->
                            <div id="article-burnout" data-article-id="burnout" class="article-card bg-white rounded-xl shadow-lg p-6 transition-all duration-300 border-b-4 border-blue-500">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">Tentang Burnout</span>
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Pemula</span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Apa Itu Burnout dan Bagaimana Mengenalinya?</h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">Burnout adalah kondisi kelelahan emosional, fisik, dan mental yang disebabkan oleh stres berkepanjangan di tempat kerja.</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">⏱ 5 menit</span>
                                    <span class="text-sm text-blue-600 font-medium">Baca Artikel &rarr;</span>
                                </div>
                            </div>

                            <!-- Article 2: Relaksasi -->
                            <div id="article-relaksasi" data-article-id="relaksasi" class="article-card bg-white rounded-xl shadow-lg p-6 transition-all duration-300 border-b-4 border-purple-500">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="px-3 py-1 bg-purple-100 text-purple-800 text-xs font-semibold rounded-full">Manajemen Stres</span>
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Pemula</span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">10 Teknik Relaksasi untuk Mengurangi Stres</h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">Pelajari teknik-teknik relaksasi sederhana yang dapat membantu mengurangi stres dan meningkatkan kesejahteraan mental.</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">⏱ 7 menit</span>
                                    <span class="text-sm text-purple-600 font-medium">Baca Artikel &rarr;</span>
                                </div>
                            </div>

                            <!-- Article 3: Keseimbangan -->
                            <div id="article-keseimbangan" data-article-id="keseimbangan" class="article-card bg-white rounded-xl shadow-lg p-6 transition-all duration-300 border-b-4 border-yellow-500">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">Tips Sehat</span>
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">Menengah</span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Menjaga Keseimbangan Kerja-Hidup di Era Digital</h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">Tips praktis untuk mencapai keseimbangan yang sehat antara pekerjaan dan kehidupan pribadi di era digital.</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">⏱ 6 menit</span>
                                    <span class="text-sm text-yellow-600 font-medium">Baca Artikel &rarr;</span>
                                </div>
                            </div>
                        </div>

                        <!-- CTA Section -->
                        <div class="mt-8 bg-gradient-to-r from-green-50 to-blue-50 rounded-lg shadow p-8 text-center">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Siap untuk Mendiagnosa Tingkat Stres Anda?</h3>
                            <p class="text-gray-600 mb-6">Gunakan sistem pakar kami untuk mendapatkan hasil yang akurat dan personal</p>
                            <button onclick="navigateTo('questionnaire-page')" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                                Mulai Diagnosa Sekarang
                            </button>
                        </div>
                    </div>
                    <div id="add-article-page" style="display: none;">
                        <!-- Main Editor Area -->
                        <div class="max-w-7xl mx-auto">
                            <!-- Controls Panel: Add New Row -->
                            <div id="controls-panel" class="mb-8 p-6 bg-blue-50 border border-blue-200 rounded-xl shadow-md">
                                <h2 class="text-xl font-semibold text-blue-700 mb-4">Tambah baris baru (jumlah kolom)</h2>
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <button data-add-row="1" class="add-row-columns flex-1 px-4 py-3 bg-white text-blue-600 border border-blue-400 rounded-lg hover:bg-blue-100 transition duration-150 shadow-sm font-medium">
                                        <i data-lucide="square" class="w-5 h-5 inline-block mr-2"></i> 1 Kolom
                                    </button>
                                    <button data-add-row="2" class="add-row-columns flex-1 px-4 py-3 bg-white text-blue-600 border border-blue-400 rounded-lg hover:bg-blue-100 transition duration-150 shadow-sm font-medium">
                                        <i data-lucide="columns-2" class="w-5 h-5 inline-block mr-2"></i> 2 Kolom
                                    </button>
                                    <button data-add-row="3" class="add-row-columns flex-1 px-4 py-3 bg-white text-blue-600 border border-blue-400 rounded-lg hover:bg-blue-100 transition duration-150 shadow-sm font-medium">
                                        <i data-lucide="columns-3" class="w-5 h-5 inline-block mr-2"></i> 3 Kolom
                                    </button>
                                </div>
                            </div>

                            <!-- Save and Preview Button -->
                            <div class="flex justify-end mb-8">
                            </div>

                            <!-- Article Content Container -->
                            <div id="article-editor" class="space-y-6">
                                <!-- Rows will be injected here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Admin Page Section -->
        <section id="admin-page" class="section">
            <div class="min-h-screen py-8">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="flex items-center justify-between mb-8">
                        <button onclick="navigateTo('landing-page')" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Beranda
                        </button>
                        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
                    </div>

                    <div class="bg-white rounded-lg shadow p-8 text-center">
                        <svg class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">Admin Dashboard</h2>
                        <p class="text-gray-600">Fitur admin dashboard akan segera hadir</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<!-- Modal -->
<div id="modal_rate_testimoni" class="fixed inset-0 z-50 hidden" aria-hidden="true" aria-modal="true" role="dialog">
    <!-- Backdrop -->
    <div class="modal-backdrop absolute inset-0 bg-black/50 z-40" data-close="true"></div>

    <!-- Centered panel -->
    <div class="fixed inset-0 flex items-center justify-center p-4 z-50">
        <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl ring-1 ring-black/5 overflow-hidden">

            <!-- Header -->
            <div class="flex items-start gap-4 p-6 border-b">
                <div class="brand-icon shrink-0">
                    <svg class="w-8 h-8 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                </div>

                <div class="flex-1">
                    <h2 class="text-lg font-semibold text-gray-900">Kami menghargai masukan Anda</h2>
                    <p class="text-sm text-gray-600 mt-1">Bantu kami tingkatkan layanan dengan bagikan pengalaman Anda.</p>
                </div>

                <button type="button" class="ml-4 p-2 rounded-md text-gray-500 hover:text-gray-700" aria-label="Close modal" id="modalCloseBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Main Card -->
            <div class="p-6">

                <!-- Form View -->
                <div id="formView" class="card-content">
                    <form id="feedbackForm" class="space-y-4" novalidate>
                        <!-- Rating Section -->
                        <div class="flex justify-center">
                            <div>
                                <div class="flex justify-center">
                                    <label class="text-sm font-medium text-gray-700 mb-2"> Bagaimana pengalaman anda? </label>
                                </div>  

                                <div class="flex items-center gap-4">
                                    <div id="starsContainer" class="flex items-center gap-1" role="radiogroup" aria-label="Rating">
                                        <!-- Five star buttons (SVG) -->
                                        <button type="button" class="star empty p-2 rounded-md" data-rating="1" aria-label="1 star" role="radio" aria-checked="false">
                                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                            </svg>
                                        </button>
                                        <button type="button" class="star empty p-2 rounded-md" data-rating="2" aria-label="2 stars" role="radio" aria-checked="false">
                                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                            </svg>
                                        </button>
                                        <button type="button" class="star empty p-2 rounded-md" data-rating="3" aria-label="3 stars" role="radio" aria-checked="false">
                                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                            </svg>
                                        </button>
                                        <button type="button" class="star empty p-2 rounded-md" data-rating="4" aria-label="4 stars" role="radio" aria-checked="false">
                                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                            </svg>
                                        </button>
                                        <button type="button" class="star empty p-2 rounded-md" data-rating="5" aria-label="5 stars" role="radio" aria-checked="false">
                                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                            </svg>
                                        </button>
                                    </div>

                                </div>
                                <div class="flex justify-center">
                                    <div class="text-sm text-gray-600" id="ratingText" aria-live="polite"></div>
                                </div>
                            </div>
                        </div>  

                        <!-- Text Inputs -->
                        <!-- <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" required placeholder="John Doe" class="mt-1 block w-full border rounded-md px-3 py-2 focus:ring-indigo-400 focus:outline-none" />
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" name="email" placeholder="john@example.com" class="mt-1 block w-full border rounded-md px-3 py-2 focus:ring-indigo-400 focus:outline-none" />
                            </div>
                        </div> -->

                        <div>
                            <!-- <label for="comment" class="block text-sm font-medium text-gray-700">Your Review <span class="text-red-500">*</span></label> -->
                            <textarea id="comment" name="comment" rows="4" required placeholder="Beritahu kami yang anda suka atau yang bisa kami tingkatkan..." class="mt-1 block w-full border rounded-md px-3 py-2 focus:ring-blue-400 focus:outline-none"></textarea>
                        </div>

                        <!-- Submit -->
                        <div class="flex items-center justify-between gap-4">
                            <p class="text-xs text-gray-500 m-0">Terima kasih untuk testimoni anda.</p>
                            <button id="submitBtn" type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-400 focus:ring-2 focus:ring-blue-300">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                <span>Berikan Testimoni</span>
                            </button>
                        </div>

                        <p id="errorMessage" class="text-sm text-red-500 hidden mt-2">Mohon coba lagi.</p>
                    </form>
                </div>

                <!-- Success View -->
                <div id="successView" class="success-view hidden text-center space-y-4">
                    <div class="flex items-center justify-center">
                        <svg class="w-12 h-12 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>

                    <h3 class="text-lg font-semibold">Terima kasih!</h3>
                    <p class="text-sm text-gray-600">Testimoni anda kami terima.</p>

                    <div id="aiResponseBox" class="mt-2 p-4 bg-gray-50 rounded-md text-left">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zM0 21v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151C7.562 5.26 6 7.98 6 10.191H10v10H0z"></path>
                            </svg>

                            <div>
                                <h4 class="text-sm font-medium mb-1">Dari Tim Kami</h4>
                                <p id="aiResponseText" class="text-sm text-gray-700">Kami menghargai masukan dan testimoni Anda.</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button id="resetBtn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Berikan testimoni lain</button>
                    </div>
                </div>

            </div> <!-- end p-6 -->

        </div> <!-- end panel -->
    </div>
</div>
<!-- Article Modal (Initially Hidden) -->
<div id="article-modal" class="hidden fixed inset-0 modal-overlay flex items-center justify-center p-4 transition-opacity duration-300" aria-modal="true" role="dialog">
    
    <!-- Modal Content Container -->
    <!-- KEY CHANGE: Added 'flex flex-col' here to enable vertical layout for scrolling -->
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col transform transition-all duration-300">
        
        <!-- Modal Header -->
        <div class="p-6 border-b border-gray-200 flex justify-between items-start">
            <div>
                <h2 class="modal-title text-2xl font-bold text-gray-900">Judul Artikel</h2>
                <div class="mt-2 flex items-center space-x-3 text-sm">
                    <span class="modal-tag px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Tag</span>
                    <span class="modal-level px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Level</span>
                    <span class="modal-duration text-gray-500"></span>
                </div>
            </div>
            <button class="closeArticleModal text-gray-400 hover:text-gray-600 transition duration-150 p-1 rounded-full hover:bg-gray-100">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Body (Scrollable) -->
        <!-- KEY CHANGE: Replaced 'h-full' with 'flex-1' to take up all remaining space -->
        <div class="modal-content p-6 overflow-y-auto modal-content-scroll text-gray-700 space-y-4 text-base flex-1">
            <!-- Article content, image, and video will be inserted here -->
        </div>

        <!-- Modal Footer -->
        <div class="p-4 border-t border-gray-200 text-right">
            <button class="closeArticleModal px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 font-medium transition duration-150">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal for Content Editing (Image/Video URL/Upload) -->
<div id="content-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 transform transition-all">
        <h3 class="modal-title text-xl font-semibold mb-4 text-gray-800">Edit Content Source</h3>
        
        <div class="mb-4">
            <p class="text-sm font-medium text-gray-700 mb-2">Choose Source Type:</p>
            <div class="flex space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="source_type" value="URL" checked 
                            data-source-type="URL" class="source-url content-source-type form-radio text-blue-600 h-4 w-4">
                    <span class="ml-2 text-gray-700">Input URL</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="source_type" value="UPLOAD" 
                            data-source-type="UPLOAD" class="source-upload content-source-type form-radio text-blue-600 h-4 w-4">
                    <span class="ml-2 text-gray-700">Upload File (Simulated)</span>
                </label>
            </div>
        </div>

        <!-- URL Input Section -->
        <div class="url-section mb-4">
            <input type="url" class="modal-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Enter URL (Image or Video Embed)">
            <p class="text-xs text-gray-500 mt-1">For videos, please use an embed URL (e.g., from YouTube's Share > Embed option).</p>
        </div>
        
        <!-- Upload Section (Simulated) -->
        <div class="upload-section mb-4 hidden">
            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-800">
                <p class="font-semibold">File Upload Simulation</p>
                <p class="text-sm">In a live environment, you would use this button to upload a file to a server/storage service. For this demo, selecting this option will use a generic placeholder image/video.</p>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <button id="closeModalContent" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Cancel</button>
            <button id="saveModalContent" class="modal-save-btn px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">Save Changes</button>
        </div>
    </div>
</div>