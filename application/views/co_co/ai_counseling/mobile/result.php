<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Konsultasi & Rencana Aksi</title>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css">
    <style>
        :root {
            --background: 0 0% 100%;
            --foreground: 222.2 84% 4.9%;
            --card: 0 0% 100%;
            --card-foreground: 222.2 84% 4.9%;
            --popover: 0 0% 100%;
            --popover-foreground: 222.2 84% 4.9%;
            --primary: 221.2 83.2% 53.3%;
            --primary-foreground: 210 40% 98%;
            --secondary: 210 40% 96%;
            --secondary-foreground: 222.2 84% 4.9%;
            --muted: 210 40% 96%;
            --muted-foreground: 215.4 16.3% 46.9%;
            --accent: 210 40% 96%;
            --accent-foreground: 222.2 84% 4.9%;
            --destructive: 0 84.2% 60.2%;
            --destructive-foreground: 210 40% 98%;
            --border: 214.3 31.8% 91.4%;
            --input: 214.3 31.8% 91.4%;
            --ring: 221.2 83.2% 53.3%;
            --radius: 0.5rem;
            --chart-1: 12 76% 61%;
            --chart-2: 173 58% 39%;
            --chart-3: 197 37% 24%;
            --chart-4: 43 74% 66%;
            --chart-5: 27 87% 67%;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: hsl(var(--background));
            color: hsl(var(--foreground));
            line-height: 1.6;
            font-size: 14px;
        }

        .cv-container {
            max-width: 1200px;
            margin: 0 auto;
            background: hsl(var(--card));
            min-height: 100vh;
            display: grid;
            grid-template-columns: 320px 1fr;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.05);
        }

        /* Sidebar */
        .sidebar {
            background: linear-gradient(180deg, hsl(var(--primary)) 0%, hsl(221, 83%, 48%) 100%);
            color: white;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .sidebar::before {
            content: "";
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .profile-section {
            position: relative;
            z-index: 1;
            text-align: center;
            margin-bottom: 2rem;
        }

        .avatar {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 48px;
            font-weight: 700;
            border: 4px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            background-size: cover;
            background-position: center;
        }

        .profile-name {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .profile-title {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 0.25rem;
        }

        .profile-dept {
            font-size: 13px;
            opacity: 0.8;
        }

        .session-info {
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--radius);
            padding: 1rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
        }

        .session-info h3 {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.75rem;
            opacity: 0.9;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            font-size: 13px;
        }

        .info-item i {
            margin-right: 0.5rem;
            width: 16px;
        }

        .stats-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--radius);
            padding: 1rem;
            margin-bottom: 1rem;
            backdrop-filter: blur(10px);
        }

        .stats-card h4 {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1.25rem;
            opacity: 0.9;
        }

        /* Gauge Chart Styles */
        .gauge-container {
            position: relative;
            width: 100%;
            height: 140px;
            margin-bottom: 1.5rem;
        }

        .gauge-svg {
            width: 100%;
            height: 100%;
        }

        .gauge-background {
            fill: none;
            stroke: rgba(255, 255, 255, 0.2);
            stroke-width: 12;
        }

        .gauge-progress {
            fill: none;
            stroke-width: 12;
            stroke-linecap: round;
            transition: stroke-dashoffset 1.5s ease-in-out;
        }

        .gauge-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .gauge-value {
            font-size: 28px;
            font-weight: 700;
            line-height: 1;
        }

        .gauge-label {
            font-size: 11px;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 4px;
        }

        .gauge-indicator {
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .progress-container {
            margin-bottom: 1rem;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 0.25rem;
        }

        .progress-bar {
            height: 6px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: white;
            border-radius: 3px;
            transition: width 1s ease-out;
        }

        /* Main Content */
        .main-content {
            padding: 2rem;
            overflow-y: auto;
        }

        .content-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid hsl(var(--border));
        }

        .content-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: hsl(var(--foreground));
            margin-bottom: 0.5rem;
        }

        .content-header p {
            color: hsl(var(--muted-foreground));
            font-size: 14px;
        }

        /* Tab Navigation */
        .tab-navigation {
            display: flex;
            border-bottom: 2px solid hsl(var(--border));
            margin-bottom: 2rem;
        }

        .tab-button {
            background: none;
            border: none;
            padding: 1rem 1.5rem;
            font-size: 15px;
            font-weight: 500;
            color: hsl(var(--muted-foreground));
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: all 0.2s ease;
        }

        .tab-button:hover {
            color: hsl(var(--foreground));
        }

        .tab-button.active {
            color: hsl(var(--primary));
            border-bottom-color: hsl(var(--primary));
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .problem-alert {
            background: hsl(var(--destructive) / 0.1);
            border: 1px solid hsl(var(--destructive) / 0.2);
            border-radius: var(--radius);
            padding: 1rem;
            margin-bottom: 2rem;
        }

        .problem-alert-header {
            display: flex;
            align-items: center;
            color: hsl(var(--destructive));
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .problem-alert-header i {
            margin-right: 0.5rem;
        }

        .grow-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .grow-card {
            background: hsl(var(--card));
            border: 1px solid hsl(var(--border));
            border-radius: var(--radius);
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .grow-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }

        .grow-card-header {
            padding: 1rem;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid hsl(var(--border));
        }

        .grow-card-header i {
            margin-right: 0.5rem;
        }

        .goal-header {
            background: hsl(var(--chart-2) / 0.1);
            color: hsl(var(--chart-2));
        }

        .reality-header {
            background: hsl(var(--primary) / 0.1);
            color: hsl(var(--primary));
        }

        .options-header {
            background: hsl(var(--chart-4) / 0.1);
            color: hsl(var(--chart-4));
        }

        .will-header {
            background: hsl(var(--chart-5) / 0.1);
            color: hsl(var(--chart-5));
        }

        .grow-card-content {
            padding: 1rem;
        }

        .grow-card-content p {
            font-size: 13px;
            line-height: 1.6;
            color: hsl(var(--foreground));
        }

        .grow-card-content ul {
            list-style: none;
            padding: 0;
        }

        .grow-card-content li {
            font-size: 13px;
            line-height: 1.6;
            padding-left: 1.5rem;
            position: relative;
            margin-bottom: 0.5rem;
        }

        .grow-card-content li::before {
            content: "•";
            position: absolute;
            left: 0.5rem;
            color: hsl(var(--primary));
        }

        .insights-section {
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 0.5rem;
            color: hsl(var(--primary));
        }

        .insights-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
        }

        .insight-card {
            background: hsl(var(--card));
            border: 1px solid hsl(var(--border));
            border-radius: var(--radius);
            padding: 1.25rem;
            transition: all 0.2s ease;
        }

        .insight-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .insight-card h4 {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
        }

        .insight-card h4 i {
            margin-right: 0.5rem;
            color: hsl(var(--primary));
        }

        .insight-card p {
            font-size: 13px;
            line-height: 1.6;
            color: hsl(var(--muted-foreground));
        }

        .takeaways-list {
            background: hsl(var(--muted) / 0.5);
            border-radius: var(--radius);
            padding: 1.25rem;
        }

        .takeaway-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }

        .takeaway-item:last-child {
            margin-bottom: 0;
        }

        .takeaway-item i {
            color: hsl(var(--primary));
            margin-right: 0.75rem;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .takeaway-item span {
            font-size: 13px;
            line-height: 1.6;
        }

        /* Advisor Tab Specific Styles */
        .action-plan-timeline {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .timeline-column {
            background: hsl(var(--muted) / 0.5);
            border-radius: var(--radius);
            padding: 1.5rem;
            border-top: 5px solid hsl(var(--primary));
        }

        .timeline-column h3 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 1.2em;
            color: hsl(var(--primary));
        }

        .timeline-column h3 i {
            display: block;
            font-size: 2em;
            margin-bottom: 10px;
        }

        .resource-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .resource-item:last-child {
            margin-bottom: 0;
        }

        .resource-item i {
            font-size: 1.5em;
            margin-right: 15px;
            color: hsl(var(--primary));
            margin-top: 5px;
            flex-shrink: 0;
        }

        .resource-details h4 {
            margin: 0 0 5px 0;
            font-size: 15px;
            font-weight: 600;
        }

        .resource-details p {
            margin: 0;
            font-size: 13px;
            color: hsl(var(--muted-foreground));
        }

        #disclaimer {
            background: #fffbe6;
            border-left: 5px solid var(--warning-color);
            padding: 1.5rem;
            margin-top: 2rem;
            border-radius: 0 8px 8px 0;
        }

        #disclaimer h2 {
            border: none;
            padding: 0;
            margin: 0 0 10px 0;
            color: var(--warning-color);
            font-size: 18px;
        }

        .footer {
            margin-top: 3rem;
            padding-top: 1rem;
            border-top: 1px solid hsl(var(--border));
            text-align: center;
            font-size: 12px;
            color: hsl(var(--muted-foreground));
        }

        @media (max-width: 768px) {
            .cv-container {
                grid-template-columns: 1fr;
            }

            .sidebar {
                padding: 1.5rem;
            }

            .main-content {
                padding: 1.5rem;
            }

            .grow-grid {
                grid-template-columns: 1fr;
            }

            .tab-button {
                padding: 0.75rem 1rem;
                font-size: 14px;
            }
        }

        @media print {
            .cv-container {
                box-shadow: none;
                max-width: 100%;
            }

            .sidebar {
                background: hsl(var(--primary)) !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .tab-navigation {
                display: none;
            }

            .tab-content {
                display: block !important;
            }

            .tab-content:not(:first-child) {
                page-break-before: always;
            }
        }
    </style>
</head>

<body>
    <div class="cv-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="profile-section">
                <!-- Ganti dengan dinamis dari backend -->
                <div class="avatar"
                    style="background-image: url('https://trusmiverse.com/hr/uploads/profile/<?= $counselling['profile_picture'] ?>');">
                </div>
                <h2 class="profile-name">
                    <?= $counselling['karyawan'] ?>
                </h2>
                <p class="profile-title">
                    <?= $counselling['department_name'] ?>
                </p>
                <p class="profile-dept">
                    <?= $counselling['designation_name'] ?>
                </p>
            </div>

            <div class="session-info">
                <h3>Informasi Sesi</h3>
                <div class="info-item"><i class="me-2" data-lucide="file-text"></i><span class="ms-2">ID:
                        <?= $counselling['id_coaching'] ?>
                    </span></div>
                <div class="info-item"><i class="me-2" data-lucide="calendar"></i><span class="ms-2">
                        <?= $counselling['tanggal'] ?>
                    </span></div>
                <div class="info-item"><i class="me-2" data-lucide="target"></i><span class="ms-2">Metode GROW</span></div>
                <div class="info-item"><i class="me-2" data-lucide="clock"></i><span class="ms-2">Durasi:
                        <?= $counselling['duration'] ?> menit
                    </span></div>
            </div>

            <div class="stats-card">
                <h4>Metrik Kinerja</h4>
                <div class="gauge-container">
                    <svg class="gauge-svg" viewBox="0 0 200 120">
                        <path class="gauge-background" d="M 30 90 A 60 60 0 0 1 170 90"></path>
                        <path class="gauge-progress" id="burnoutGauge" d="M 30 90 A 60 60 0 0 1 170 90"
                            stroke="url(#gaugeGradient)" stroke-dasharray="188.5" stroke-dashoffset="188.5"></path>
                        <defs>
                            <linearGradient id="gaugeGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" style="stop-color:#06ffa5;stop-opacity:1" />
                                <stop offset="50%" style="stop-color:#ffbe0b;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#fb5607;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                    </svg>
                    <div class="gauge-text mt-2">
                        <div class="gauge-value" id="burnoutValue">0%</div>
                        <div class="gauge-label">Burnout</div>
                    </div>
                    <div class="gauge-indicator" id="burnoutIndicator">Rendah</div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="content-header">
                <h1>Laporan Konsultasi & Rencana Aksi</h1>
                <p>Analisis komprehensif dan rencana tindakan lanjutan</p>
            </div>

            <!-- Tab Navigation -->
            <div class="tab-navigation">
                <button class="tab-button active" onclick="showTab('summary-tab', this)">📄 Ringkasan Sesi
                    (GROW)</button>
                <button class="tab-button" onclick="showTab('action-tab', this)"> Rencana Aksi & Solusi</button>
            </div>

            <!-- Tab 1: Resumer Content -->
            <div id="summary-tab" class="tab-content active">
                <div class="problem-alert">
                    <div class="problem-alert-header"><i class="me-2" data-lucide="alert-triangle"></i><span class="ms-2">Masalah
                            Utama</span></div>
                    <p>
                        <?= $counselling['review_problem'] ?>
                    </p>
                </div>

                <div class="grow-grid">
                    <div class="grow-card">
                        <div class="grow-card-header goal-header"><i class="me-2" data-lucide="target"></i><span class="ms-2">Goal
                                (Tujuan)</span></div>
                        <div class="grow-card-content">
                            <p>
                                <?= $counselling['goals'] ?>
                            </p>
                        </div>
                    </div>
                    <div class="grow-card">
                        <div class="grow-card-header reality-header"><i class="me-2" data-lucide="eye"></i><span class="ms-2">Reality
                                (Realita)</span></div>
                        <div class="grow-card-content">
                            <p>
                                <?= $counselling['reality'] ?>
                            </p>
                        </div>
                    </div>
                    <div class="grow-card">
                        <div class="grow-card-header options-header"><i class="me-2" data-lucide="lightbulb"></i><span
                                class="ms-2">Options (Opsi)</span></div>
                        <div class="grow-card-content">
                            <?= $counselling['option'] ?>
                        </div>
                    </div>
                    <div class="grow-card">
                        <div class="grow-card-header will-header"><i class="me-2" data-lucide="rocket"></i><span class="ms-2">Will
                                (Rencana Aksi)</span></div>
                        <div class="grow-card-content">
                            <?= $counselling['will'] ?>
                        </div>
                    </div>
                </div>

                <div class="insights-section">
                    <h3 class="section-title"><i class="me-2" data-lucide="brain"></i><span class="ms-2">Analisis & Insight</span>
                    </h3>
                    <div class="insights-grid">
                        <div class="insight-card mb-2">
                            <h4><i class="me-2" data-lucide="highlighter"></i> Isu Utama</h4>
                            <p>
                                <?= $counselling['main_issue_highlight'] ?>
                            </p>
                        </div>
                        <div class="insight-card mb-2">
                            <h4><i class="me-2" data-lucide="flame"></i> Indikasi Burnout</h4>
                            <p>
                                <?= $counselling['reasoning_burnout'] ?>
                            </p>
                        </div>
                        <div class="insight-card mb-2">
                            <h4><i class="me-2" data-lucide="search"></i> Hipotesis Akar Masalah</h4>
                            <p>
                                <?= $counselling['root_cause_hypothesis'] ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="insights-section">
                    <h3 class="section-title"><i class="me-2" data-lucide="key"></i><span class="ms-2">Poin-poin Penting</span></h3>
                    <div class="takeaways-list">
                        <?= $counselling['key_takeaways'] ?>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Advisor Content -->
            <div id="action-tab" class="tab-content">
                <section id="strategic-recommendations">
                    <h2 class="section-title"><i class="me-2" data-lucide="lightbulb"></i> Rekomendasi Strategis</h2>
                    <div id="recommendations-list">
                        <!-- Content will be generated by JavaScript -->
                    </div>
                </section>

                <section id="action-plan">
                    <h2 class="section-title"><i class="me-2" data-lucide="tasks"></i> Rencana Aksi</h2>
                    <div class="action-plan-timeline" id="action-plan-timeline">
                        <!-- Content will be generated by JavaScript -->
                    </div>
                </section>

                <section id="recommended-resources">
                    <h2 class="section-title"><i class="me-2" data-lucide="book-open"></i> Sumber Daya yang Direkomendasikan</h2>
                    <div id="resources-list">
                        <!-- Content will be generated by JavaScript -->
                    </div>
                </section>

                <section id="disclaimer">
                    <h2><i class="me-2" data-lucide="alert-triangle"></i> Penting untuk Diperhatikan</h2>
                    <p id="disclaimer-text">
                        <!-- Content will be generated by JavaScript -->
                    </p>
                </section>
            </div>

            <div class="footer">
                <p>&copy; 2025 Sistem Laporan Konsultasi | Dicetak: <span id="print-date"></span></p>
            </div>
        </main>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Set current date
        document.getElementById('print-date').textContent = new Date().toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        // --- Tab Switching Logic ---
        function showTab(tabId, buttonElement) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });

            // Show the specific tab content
            document.getElementById(tabId).classList.add('active');
            // Add active class to the clicked button
            buttonElement.classList.add('active');
        }

        // --- Gauge Chart Animation ---
        function animateGauge() {
            const gauge = document.getElementById('burnoutGauge');
            const valueElement = document.getElementById('burnoutValue');
            const indicatorElement = document.getElementById('burnoutIndicator');

            // Ganti dengan nilai dinamis dari backend
            const targetValue = <?= str_replace('%', '', $counselling['percentage_burnout']) ?>;
            const circumference = 188.5;
            const targetOffset = circumference - (circumference * targetValue / 100);

            setTimeout(() => {
                gauge.style.strokeDashoffset = targetOffset;
                let currentValue = 0;
                const increment = targetValue / 50;
                const timer = setInterval(() => {
                    currentValue += increment;
                    if (currentValue >= targetValue) {
                        currentValue = targetValue;
                        clearInterval(timer);
                    }
                    valueElement.textContent = Math.round(currentValue) + '%';
                }, 30);

                if (targetValue <= 33) {
                    indicatorElement.textContent = 'Rendah';
                    indicatorElement.style.background = 'rgba(6, 255, 165, 0.3)';
                } else if (targetValue <= 66) {
                    indicatorElement.textContent = 'Sedang';
                    indicatorElement.style.background = 'rgba(255, 190, 11, 0.3)';
                } else {
                    indicatorElement.textContent = 'Tinggi';
                    indicatorElement.style.background = 'rgba(251, 86, 7, 0.3)';
                }
            }, 500);
        }

        // --- Data for Advisor Tab (would come from API) ---
        const strategicRecommendations = JSON.parse(JSON.stringify(<?php echo $strategic_recommendations; ?>));
        const actionPlan = JSON.parse(JSON.stringify(<?php echo $action_plan; ?>));
        const recommendedResources = JSON.parse(JSON.stringify(<?php echo $recommended_resources; ?>));
        const disclaimer = "<?php echo $disclaimer; ?>";
        const reportData = {
            "strategic_recommendations": strategicRecommendations,
            "action_plan": actionPlan,
            "recommended_resources": recommendedResources,
            "disclaimer": disclaimer
        };

        // --- JavaScript to Render Advisor Tab Content ---
        function renderRecommendations(data) {
            const container = document.getElementById('recommendations-list');
            data.forEach(item => {
                const card = `
                    <div class="insight-card mb-2">
                        <h4><i class="me-2" data-lucide="star"></i> ${item.title}</h4>
                        <p><em>${item.rationale}</em></p>
                        <p><strong>Fokus Utama:</strong></p>
                        <ul>
                            ${item.key_focus_areas.map(area => `<li>${area}</li>`).join('')}
                        </ul>
                    </div>
                `;
                container.innerHTML += card;
            });
            lucide.createIcons();
        }

        function renderActionPlan(data) {
            const container = document.getElementById('action-plan-timeline');
            const iconMap = {
                'Langkah Segera (Minggu Ini)': 'fa-rocket',
                'Tujuan Jangka Pendek (1 Bulan)': 'fa-calendar-check'
            };
            data.forEach(plan => {
                const icon = iconMap[plan.category] || 'fa-tasks';
                const column = `
                    <div class="timeline-column">
                        <h3><i class="me-2" data-lucide="zap"></i>${plan.category}</h3>
                        ${plan.actions.map(action => `
                            <div class="insight-card mb-2">
                                <h4>${action.task}</h4>
                                <p><em>Tujuan: ${action.purpose}</em></p>
                            </div>
                        `).join('')}
                    </div>
                `;
                container.innerHTML += column;
            });
            lucide.createIcons();
        }

        function renderResources(data) {
            const container = document.getElementById('resources-list');
            const iconMap = {
                'Buku': 'book',
                'Artikel': 'file-text',
                'Framework': 'activity'
            };
            data.forEach(resource => {
                const icon = iconMap[resource.type] || 'link';
                const item = `
                    <div class="resource-item">
                        <i class="me-2" data-lucide="${icon}"></i>
                        <div class="resource-details">
                            <h4>${resource.title}</h4>
                            <p>${resource.description}</p>
                        </div>
                    </div>
                `;
                container.innerHTML += item;
            });
            lucide.createIcons();
        }

        function renderDisclaimer(text) {
            document.getElementById('disclaimer-text').innerText = text;
        }

        // --- Main Execution on Page Load ---
        window.addEventListener('load', function() {
            setTimeout(() => {
                document.querySelectorAll('.progress-fill').forEach(bar => {
                    const width = bar.style.width;
                    bar.style.width = '0';
                    setTimeout(() => {
                        bar.style.width = width;
                    }, 100);
                });
                animateGauge();
            }, 300);

            // Render content for the Advisor tab
            renderRecommendations(reportData.strategic_recommendations);
            renderActionPlan(reportData.action_plan);
            renderResources(reportData.recommended_resources);
            renderDisclaimer(reportData.disclaimer);
        });
    </script>
</body>

</html>