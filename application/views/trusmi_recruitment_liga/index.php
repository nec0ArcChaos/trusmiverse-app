<?php
// ── Compute Grand Totals dari unit_summary ──
$grand_kebutuhan = $grand_frck_done_unit = $grand_join = $grand_screening = $grand_interview_hr = $grand_interview_user = $grand_offering = 0;
$units_data = [];
foreach ($unit_summary as $u) {
    $grand_kebutuhan      += $u->total_kebutuhan;
    $grand_frck_done_unit += $u->total_frck_done;
    $grand_join           += $u->total_join;
    $grand_screening      += $u->total_screening;
    $grand_interview_hr   += $u->total_interview_hr;
    $grand_interview_user += $u->total_interview_user;
    $grand_offering       += $u->total_offering;
    $units_data[] = [
        'unit' => $u->unit_bisnis, 'kebutuhan' => (int)$u->total_kebutuhan, 'pemenuhan' => (int)$u->total_frck_done,
        'screening' => (int)$u->total_screening, 'interview_hr' => (int)$u->total_interview_hr,
        'interview_user' => (int)$u->total_interview_user, 'offering' => (int)$u->total_offering,
        'join' => (int)$u->total_join, 'pct' => (float)$u->pct_pemenuhan, 'gap' => max(0, (int)$u->gap),
    ];
}
$grand_gap = max(0, $grand_kebutuhan - $grand_frck_done_unit);
$grand_pct = $grand_kebutuhan > 0 ? min(100, round($grand_frck_done_unit / $grand_kebutuhan * 100, 2)) : 0;

// FRCK Done totals (untuk KPI Overview) — sekarang sinkron dengan unit_summary
$grand_frck_done = $grand_frck_done_unit;
$grand_frck_pct  = $grand_pct;
$grand_frck_gap  = $grand_gap;

// Funnel conversion rates
$conv_scr_hr     = $grand_screening > 0      ? round($grand_interview_hr / $grand_screening * 100, 2) : 0;
$conv_hr_user    = $grand_interview_hr > 0   ? round($grand_interview_user / $grand_interview_hr * 100, 2) : 0;
$conv_user_offer = $grand_interview_user > 0 ? round($grand_offering / $grand_interview_user * 100, 2) : 0;
$conv_offer_join = $grand_offering > 0       ? round($grand_join / $grand_offering * 100, 2) : 0;

// Drop rates
$drop_scr_hr     = 100 - $conv_scr_hr;
$drop_hr_user    = 100 - $conv_hr_user;
$drop_user_offer = 100 - $conv_user_offer;
$drop_offer_join = 100 - $conv_offer_join;

// Biggest drop
$drops = ['Interview HR' => $drop_scr_hr, 'Interview User' => $drop_hr_user, 'Offering' => $drop_user_offer, 'Join' => $drop_offer_join];
arsort($drops);
$max_drop_stage = key($drops);
$max_drop_pct   = current($drops);

// PIC status counts
$pic_on_track = $pic_perhatian = $pic_kritis = 0;
$pic_kritis_names = [];
foreach ($pic_performance as $p) {
    if ($p->pct >= 80) $pic_on_track++;
    elseif ($p->pct >= 50) $pic_perhatian++;
    else { $pic_kritis++; $pic_kritis_names[] = $p->pic_name . ' (' . $p->pct . '%)'; }
}

// Open position age buckets
$age_critical = $age_attention = $age_normal = 0;
foreach ($open_positions as $op) {
    if ($op->usia_posisi > 45) $age_critical++;
    elseif ($op->usia_posisi >= 30) $age_attention++;
    else $age_normal++;
}

// Helper functions
function pill_class($pct) { return $pct >= 80 ? 'rc-pill-green' : ($pct >= 50 ? 'rc-pill-yellow' : 'rc-pill-red'); }
function bar_gradient($pct) {
    if ($pct >= 80) return 'linear-gradient(90deg,#05966966,#059669)';
    if ($pct >= 50) return 'linear-gradient(90deg,#d9770666,#d97706)';
    return 'linear-gradient(90deg,#dc262666,#dc2626)';
}
function text_color($pct) { return $pct >= 80 ? 'var(--rc-green)' : ($pct >= 50 ? 'var(--rc-yellow)' : 'var(--rc-red)'); }

// Per-unit S→J ratios
$unit_stj = [];
foreach ($units_data as $ud) {
    $unit_stj[$ud['unit']] = $ud['screening'] > 0 ? round($ud['join'] / $ud['screening'] * 100, 2) : 0;
}

// Sort units by pct asc (worst first) for alerts
$sorted_units = $units_data;
usort($sorted_units, function($a, $b) { return $a['pct'] - $b['pct']; });

// Rejection chart data
$rej_labels = $rej_values = [];
foreach ($rejection_reasons as $r) { $rej_labels[] = $r->alasan; $rej_values[] = (int)$r->frekuensi; }

// PIC data for JS
$pic_js = [];
foreach ($pic_performance as $p) {
    $pic_js[] = ['pic' => $p->pic_name, 'id_pic' => (int)$p->id_pic, 'kebutuhan' => (int)$p->kebutuhan, 'pemenuhan' => (int)$p->pemenuhan, 'pct' => (int)$p->pct];
}

// Kebutuhan detail per PIC for hover tooltip
$kebutuhan_detail_js = [];
foreach ($kebutuhan_detail as $kd) {
    $pid = (int)$kd->id_pic;
    if (!isset($kebutuhan_detail_js[$pid])) $kebutuhan_detail_js[$pid] = [];
    $kebutuhan_detail_js[$pid][] = [
        'job_title'  => $kd->job_title,
        'department' => $kd->department,
        'position'   => $kd->position,
        'id_role'    => (int)$kd->id_role,
        'vacancy'    => (int)$kd->job_vacancy,
    ];
}

// Pemenuhan detail per PIC for hover tooltip
$pemenuhan_detail_js = [];
foreach ($pemenuhan_detail as $pd) {
    $pid = (int)$pd->id_pic;
    if (!isset($pemenuhan_detail_js[$pid])) $pemenuhan_detail_js[$pid] = [];
    $pemenuhan_detail_js[$pid][] = [
        'job_title'  => $pd->job_title,
        'department' => $pd->department,
        'position'   => $pd->position,
        'id_role'    => (int)$pd->id_role,
        'pemenuhan'  => (int)$pd->pemenuhan,
    ];
}

// Open positions data for JS
$open_js = [];
foreach ($open_positions as $op) {
    $status = $op->usia_posisi > 45 ? 'Kritis' : ($op->usia_posisi >= 30 ? 'Perhatian' : 'Monitor');
    $open_js[] = ['no_fpk' => $op->no_fpk, 'target' => (int)$op->target, 'posisi' => $op->posisi, 'unit' => $op->unit_bisnis, 'usia' => (int)$op->usia_posisi, 'pic' => $op->pic_name,'creator' => $op->created_by_name, 'status' => $status, 'gap' => (int)$op->gap];
}

// Funnel width percentages (relative to screening as 100%)
$fw_ihr   = $grand_screening > 0 ? round($grand_interview_hr / $grand_screening * 100, 1) : 0;
$fw_iu    = $grand_screening > 0 ? round($grand_interview_user / $grand_screening * 100, 1) : 0;
$fw_offer = $grand_screening > 0 ? round($grand_offering / $grand_screening * 100, 1) : 0;
$fw_join  = $grand_screening > 0 ? min(100, round($grand_join / $grand_screening * 100, 1)) : 0;

// Date label
$nama_bulan = ['', 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
$date_label = $nama_bulan[(int)$bulan] . ' ' . $tahun;
?>


<main class="main" style="margin-left: 230px; position: fixed; top: 70px; right: 0; bottom: 0; overflow-y: auto; z-index: 10;">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Deskripsi Page</p>
            </div>
            <div class="col col-sm-auto">
                <form method="POST" id="form_filter" class="d-flex gap-2 align-items-center flex-wrap">
                    <select name="bulan" class="form-select form-select-sm" style="width:auto;" onchange="document.getElementById('form_filter').submit();">
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?= str_pad($m, 2, '0', STR_PAD_LEFT) ?>" <?= (int)$bulan == $m ? 'selected' : '' ?>><?= $nama_bulan[$m] ?></option>
                        <?php endfor; ?>
                    </select>
                    <select name="tahun" class="form-select form-select-sm" style="width:auto;" onchange="document.getElementById('form_filter').submit();">
                        <?php for ($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                        <option value="<?= $y ?>" <?= (int)$tahun == $y ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                    <select name="company_id" class="form-select form-select-sm" style="width:auto;" onchange="document.getElementById('form_filter').submit();">
                        <option value="">Semua Company</option>
                        <?php if (!empty($company_list)): foreach ($company_list as $comp): ?>
                        <option value="<?= $comp->user_id ?>" <?= (isset($company_id) && $company_id == $comp->user_id) ? 'selected' : '' ?>><?= $comp->first_name ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </form>
            </div>
        </div>
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle; ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="m-4">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <h6 class="fw-medium mb-0">Dashboard Recruitment Liga</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <!-- ══════════════════════════════════════════
                         CUSTOM STYLES (Light Theme)
                         ══════════════════════════════════════════ -->
                    <style>
                        :root {
                            --rc-green: #059669;
                            --rc-green-bg: #ecfdf5;
                            --rc-yellow: #d97706;
                            --rc-yellow-bg: #fffbeb;
                            --rc-red: #dc2626;
                            --rc-red-bg: #fef2f2;
                            --rc-blue: #2563eb;
                            --rc-blue-bg: #eff6ff;
                            --rc-orange: #ea580c;
                            --rc-orange-bg: #fff7ed;
                            --rc-teal: #0d9488;
                            --rc-surface: #ffffff;
                            --rc-surface-alt: #f8fafc;
                            --rc-border: #e2e8f0;
                            --rc-text: #1e293b;
                            --rc-text-sec: #64748b;
                            --rc-text-muted: #94a3b8;
                        }

                        /* Fix: card jangan sticky/fixed saat scroll */
                        .column-set {
                            position: relative !important;
                            top: auto !important;
                            z-index: 0 !important;
                        }

                        /* Fix: konten tidak menimpa sidebar navigasi */
                        .main.mainheight .m-4 {
                            position: relative;
                            z-index: 0;
                        }
                        .rc-dashboard { font-family: 'Segoe UI', 'Helvetica Neue', sans-serif; color: var(--rc-text); }
                        .rc-kpi-card { border-radius: 12px; border: 1px solid var(--rc-border); text-align: center; padding: 16px 12px; transition: box-shadow .2s; }
                        .rc-kpi-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.06); }
                        .rc-kpi-label { font-size: 11px; font-weight: 700; color: var(--rc-text-sec); letter-spacing: 1.2px; text-transform: uppercase; margin-bottom: 8px; }
                        .rc-kpi-value { font-size: 36px; font-weight: 900; line-height: 1; letter-spacing: -1px; }
                        .rc-kpi-unit { font-size: 12px; color: var(--rc-text-muted); margin-top: 2px; }
                        .rc-kpi-sub { font-size: 11px; color: var(--rc-text-muted); margin-top: 6px; }
                        .rc-sec-title { font-size: 11px; font-weight: 800; color: var(--rc-text-sec); letter-spacing: 1.8px; text-transform: uppercase; margin-bottom: 4px; }
                        .rc-sec-hint { font-size: 11px; color: var(--rc-text-muted); margin-bottom: 14px; }
                        .rc-card { background: var(--rc-surface); border: 1px solid var(--rc-border); border-radius: 12px; padding: 18px 20px; overflow: visible; }
                        .rc-pill { font-size: 10px; font-weight: 700; padding: 3px 10px; border-radius: 20px; display: inline-block; }
                        .rc-pill-green { background: var(--rc-green-bg); color: var(--rc-green); }
                        .rc-pill-yellow { background: var(--rc-yellow-bg); color: var(--rc-yellow); }
                        .rc-pill-red { background: var(--rc-red-bg); color: var(--rc-red); }
                        .rc-pill-blue { background: var(--rc-blue-bg); color: var(--rc-blue); }
                        .rc-progress-track { background: #f1f5f9; border-radius: 5px; height: 10px; position: relative; overflow: visible; }
                        .rc-progress-bar { height: 100%; border-radius: 5px; transition: width .6s ease; }
                        .rc-progress-marker { position: absolute; top: -3px; width: 2px; height: 16px; background: var(--rc-text-muted); border-radius: 1px; z-index: 1; }
                        .rc-table { width: 100%; border-collapse: collapse; font-size: 12px; }
                        .rc-table thead th { padding: 8px 12px; text-align: left; color: var(--rc-text-sec); font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.8px; border-bottom: 2px solid var(--rc-border); }
                        .rc-table tbody tr { border-bottom: 1px solid var(--rc-border); }
                        .rc-table tbody tr:nth-child(even) { background: var(--rc-surface-alt); }
                        .rc-table tbody td { padding: 10px 12px; }
                        .rc-insight-box { border-radius: 8px; padding: 10px 14px; margin-top: 12px; background: var(--rc-surface-alt); border: 1px solid var(--rc-border); }
                        .rc-alert-card { border-radius: 10px; padding: 14px 16px; }
                        .rc-funnel-bar { background: #f1f5f9; border-radius: 4px; height: 9px; }
                        .rc-funnel-fill { height: 100%; border-radius: 4px; }
                        .rc-conv-target { margin-bottom: 12px; }
                        .rc-conv-target .track { background: #f1f5f9; border-radius: 4px; height: 8px; position: relative; }
                        .rc-conv-target .fill { height: 100%; border-radius: 4px; transition: width .6s ease; }
                        .rc-conv-target .marker { position: absolute; top: -3px; width: 2px; height: 14px; background: var(--rc-text-muted); border-radius: 1px; }
                        .rc-rec-card { border-radius: 10px; padding: 16px 18px; margin-bottom: 10px; }
                        .rc-priority-badge { border-radius: 8px; padding: 4px 10px; font-size: 11px; font-weight: 900; color: #fff; white-space: nowrap; display: inline-block; }
                        .rc-nav-tabs .nav-link { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: var(--rc-text-muted); border: none; padding: 11px 18px; border-bottom: 2px solid transparent; border-radius: 0; }
                        .rc-nav-tabs .nav-link.active { color: var(--rc-teal); border-bottom-color: var(--rc-teal); background: transparent; }
                        .rc-nav-tabs .nav-link:hover { color: var(--rc-teal); }
                        .rc-unit-badge { font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 8px; display: inline-block; }
                        .rc-sort-btn { padding: 5px 12px; border-radius: 6px; font-size: 11px; font-weight: 700; cursor: pointer; border: 1px solid var(--rc-border); background: var(--rc-surface-alt); color: var(--rc-text-sec); }
                        .rc-sort-btn.active { background: var(--rc-blue); border-color: var(--rc-blue); color: #fff; }

                        /* Hover tooltip for Kebutuhan detail */
                        .rc-kebutuhan-cell { position: relative; cursor: pointer; }
                        .rc-tooltip-detail {
                            display: none;
                            position: fixed;
                            background: var(--rc-surface);
                            border: 1px solid var(--rc-border);
                            border-radius: 10px;
                            box-shadow: 0 8px 30px rgba(0,0,0,.12);
                            padding: 14px 16px;
                            z-index: 9999;
                            min-width: 320px;
                            max-width: 420px;
                            white-space: normal;
                            pointer-events: none;
                        }
                        .rc-tooltip-detail .rc-tooltip-title {
                            font-size: 12px;
                            font-weight: 800;
                            color: var(--rc-text);
                            margin-bottom: 8px;
                            padding-bottom: 6px;
                            border-bottom: 1px solid var(--rc-border);
                        }
                        .rc-tooltip-detail .rc-tooltip-row {
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            padding: 4px 0;
                            font-size: 11px;
                            border-bottom: 1px dashed #f1f5f9;
                        }
                        .rc-tooltip-detail .rc-tooltip-row:last-child { border-bottom: none; }
                        .rc-tooltip-detail .rc-tooltip-job { font-weight: 600; color: var(--rc-text); flex: 1; }
                        .rc-tooltip-detail .rc-tooltip-dept { color: var(--rc-text-muted); font-size: 10px; }
                        .rc-tooltip-detail .rc-tooltip-vacancy {
                            background: var(--rc-blue-bg);
                            color: var(--rc-blue);
                            font-weight: 800;
                            font-size: 11px;
                            padding: 2px 8px;
                            border-radius: 6px;
                            margin-left: 8px;
                            white-space: nowrap;
                        }
                        .rc-tooltip-detail .rc-tooltip-total {
                            display: flex;
                            justify-content: space-between;
                            margin-top: 6px;
                            padding-top: 6px;
                            border-top: 1px solid var(--rc-border);
                            font-size: 11px;
                            font-weight: 800;
                            color: var(--rc-text);
                        }
                    </style>

                    <div class="rc-dashboard" style="padding: 10px;">

                        <!-- ── HEADER SUMMARY BAR ── -->
                        <div class="d-flex justify-content-between align-items-center p-3 border-bottom" style="background: var(--rc-surface-alt);">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span style="width:7px;height:7px;border-radius:50%;background:var(--rc-green);display:inline-block;"></span>
                                    <span style="font-size:10px;color:var(--rc-green);font-weight:800;letter-spacing:1.8px;">LIVE DATA</span>
                                </div>
                                <div style="font-size:18px;font-weight:900;color:var(--rc-text);letter-spacing:-.5px;">Dashboard Rekrutmen</div>
                                <div style="font-size:11px;color:var(--rc-text-muted);">Laporan <?= $date_label ?> · <?= implode(' · ', array_column($units_data, 'unit')) ?></div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="text-end">
                                    <div id="headerPctTotal" style="font-size:22px;font-weight:900;"><?= $grand_frck_pct ?>%</div>
                                    <div style="font-size:10px;color:var(--rc-text-muted);">Pemenuhan Total</div>
                                </div>
                                <div style="width:1px;height:36px;background:var(--rc-border);"></div>
                                <div class="text-end">
                                    <div style="font-size:22px;font-weight:900;color:var(--rc-text);"><?= $grand_frck_done ?><span style="font-size:14px;color:var(--rc-text-muted);">/ <?= $grand_kebutuhan ?></span></div>
                                    <div style="font-size:10px;color:var(--rc-text-muted);">Posisi Terpenuhi (FRCK)</div>
                                </div>
                            </div>
                        </div>

                        <!-- ── TABS NAVIGATION ── -->
                        <ul class="nav rc-nav-tabs border-bottom px-3" style="background:var(--rc-surface-alt);" id="rcTabs" role="tablist">
                            <li class="nav-item" role="presentation"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabOverview" type="button" role="tab">Overview</button></li>
                            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabFunnel" type="button" role="tab">Funnel & Konversi</button></li>
                            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabPIC" type="button" role="tab">PIC Performance</button></li>
                            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabOpen" type="button" role="tab">Posisi Terbuka</button></li>
                            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabAnalisis" type="button" role="tab">Analisis</button></li>
                        </ul>

                        <!-- ── TAB CONTENT ── -->
                        <div class="tab-content p-3">

                            <!-- ═══════════════════════════════════
                                 TAB 1: OVERVIEW
                                 ═══════════════════════════════════ -->
                            <div class="tab-pane fade show active" id="tabOverview" role="tabpanel">

                                <!-- KPI Row -->
                                <div class="row g-3 mb-3">
                                    <div class="col-6 col-lg-3">
                                        <div class="rc-kpi-card" style="border-left: 3px solid var(--rc-blue);">
                                            <div class="rc-kpi-label">Total Kebutuhan (Date of closing)</div>
                                            <div class="rc-kpi-value" style="color:var(--rc-blue);"><?= $grand_kebutuhan ?></div>
                                            <div class="rc-kpi-unit">posisi</div>
                                            <div class="rc-kpi-sub"><?= $date_label ?></div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-3">
                                        <div class="rc-kpi-card" style="border-left: 3px solid var(--rc-green);">
                                            <div class="rc-kpi-label">Terpenuhi (FRCK Done)</div>
                                            <div class="rc-kpi-value" style="color:var(--rc-green);"><?= $grand_frck_done ?></div>
                                            <div class="rc-kpi-unit">posisi</div>
                                            <div class="rc-kpi-sub"><?= $grand_frck_pct ?>% dari kebutuhan</div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-3">
                                        <div class="rc-kpi-card" style="border-left: 3px solid var(--rc-red);">
                                            <div class="rc-kpi-label">Belum Terpenuhi</div>
                                            <div class="rc-kpi-value" style="color:var(--rc-red);"><?= $grand_frck_gap ?></div>
                                            <div class="rc-kpi-unit">posisi</div>
                                            <div class="rc-kpi-sub">Perlu tindak lanjut</div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-3">
                                        <div class="rc-kpi-card" style="border-left: 3px solid <?= text_color($grand_frck_pct) ?>;">
                                            <div class="rc-kpi-label">Pemenuhan Keseluruhan</div>
                                            <div class="rc-kpi-value" style="color:<?= text_color($grand_frck_pct) ?>;"><?= $grand_frck_pct ?>%</div>
                                            <div class="rc-kpi-sub">Target: 80%</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Chart + Status -->
                                <div class="row g-3 mb-3">
                                    <div class="col-lg-7">
                                        <div class="rc-card h-100">
                                            <div class="rc-sec-title">Pemenuhan per Unit Bisnis</div>
                                            <div class="rc-sec-hint">Kebutuhan vs Pemenuhan per unit bisnis</div>
                                            <div style="position:relative;height:250px;width:100%;">
                                                <canvas id="chartUnitBisnis"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="rc-card h-100">
                                            <div class="rc-sec-title">Unit Bisnis — Status Ringkas</div>
                                            <div class="rc-sec-hint">Status pemenuhan & gap tiap unit</div>

                                            <?php foreach ($units_data as $ud): ?>
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span style="font-size:14px;font-weight:800;"><?= $ud['unit'] ?></span>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span style="font-size:11px;color:var(--rc-text-muted);"><?= $ud['pemenuhan'] ?>/<?= $ud['kebutuhan'] ?></span>
                                                        <span class="rc-pill <?= pill_class($ud['pct']) ?>"><?= $ud['pct'] ?>%</span>
                                                    </div>
                                                </div>
                                                <div class="rc-progress-track">
                                                    <div class="rc-progress-bar" style="width:<?= min($ud['pct'], 100) ?>%;background:<?= bar_gradient($ud['pct']) ?>;"></div>
                                                    <div class="rc-progress-marker" style="left:80%;"></div>
                                                </div>
                                                <!-- <div style="font-size:10px;color:var(--rc-text-muted);margin-top:5px;">Target 80% · Gap: <?= $ud['gap'] ?> posisi belum terpenuhi</div> -->
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Alert Insight Cards -->
                                <div class="row g-3">
                                    <?php foreach ($sorted_units as $su):
                                        if ($su['pct'] < 50) {
                                            $alert_bg = 'var(--rc-red-bg)'; $alert_border = '#fecaca'; $alert_icon = '🔴'; $alert_color = 'var(--rc-red)'; $alert_label = 'Kritis';
                                        } elseif ($su['pct'] < 80) {
                                            $alert_bg = 'var(--rc-yellow-bg)'; $alert_border = '#fde68a'; $alert_icon = '🟡'; $alert_color = 'var(--rc-yellow)'; $alert_label = 'Butuh Perhatian';
                                        } else {
                                            $alert_bg = 'var(--rc-green-bg)'; $alert_border = '#a7f3d0'; $alert_icon = '🟢'; $alert_color = 'var(--rc-green)'; $alert_label = 'Progresif';
                                        }
                                    ?>
                                    <div class="col-lg-4">
                                        <div class="rc-alert-card" style="background:<?= $alert_bg ?>;border:1px solid <?= $alert_border ?>;">
                                            <div style="font-size:13px;font-weight:800;color:<?= $alert_color ?>;margin-bottom:6px;"><?= $alert_icon ?> <?= $su['unit'] ?> <?= $alert_label ?> — <?= $su['pct'] ?>%</div>
                                            <div style="font-size:12px;color:var(--rc-text-sec);line-height:1.6;"><?= $su['pemenuhan'] ?> dari <?= $su['kebutuhan'] ?> posisi terpenuhi. Gap: <?= $su['gap'] ?> posisi belum terpenuhi.</div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>

                            </div><!-- /tabOverview -->

                            <!-- ═══════════════════════════════════
                                 TAB 2: FUNNEL & KONVERSI
                                 ═══════════════════════════════════ -->
                            <div class="tab-pane fade" id="tabFunnel" role="tabpanel">

                                <?php
                                // ── Group funnel_detail by Unit Bisnis → Level → Posisi ──
                                $funnel_grouped = [];
                                foreach ($funnel_detail as $fd) {
                                    $u = $fd->unit_bisnis;
                                    $l = $fd->level_name ?: 'Lainnya';
                                    if (!isset($funnel_grouped[$u])) $funnel_grouped[$u] = [];
                                    if (!isset($funnel_grouped[$u][$l])) $funnel_grouped[$u][$l] = [];
                                    $funnel_grouped[$u][$l][] = $fd;
                                }
                                // Helper: safe percent
                                $pct_safe = function($num, $den) {
                                    return $den > 0 ? round($num / $den * 100, 2) . '%' : '0%';
                                };
                                ?>

                                <div class="rc-card">
                                    <div class="rc-sec-title">Funnel Rekrutmen per Posisi</div>
                                    <div class="rc-sec-hint">Detail konversi per Unit Bisnis, Level, dan Posisi</div>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered mb-0" style="font-size:12px;">
                                            <thead>
                                                <tr style="background:#4472C4;color:#fff;text-align:center;">
                                                    <th style="text-align:left;padding:6px 8px;">Unit Bisnis</th>
                                                    <th style="text-align:left;padding:6px 8px;">Level</th>
                                                    <th style="text-align:left;padding:6px 8px;">Posisi</th>
                                                    <th style="padding:6px 4px;">Kebutuhan</th>
                                                    <th style="padding:6px 4px;">Lolos Screening</th>
                                                    <th style="padding:6px 4px;">Interview HR</th>
                                                    <th style="padding:6px 4px;">Interview User</th>
                                                    <th style="padding:6px 4px;">Offering</th>
                                                    <th style="padding:6px 4px;">Join</th>
                                                    <th style="padding:6px 4px;">Pemenuhan</th>
                                                    <th style="padding:6px 4px;">Terpenuhi</th>
                                                    <th style="padding:6px 4px;">%Screening-Interview</th>
                                                    <th style="padding:6px 4px;">%Interview HR-Interview User</th>
                                                    <th style="padding:6px 4px;">%Interview User-Offering</th>
                                                    <th style="padding:6px 4px;">%Offering-Join</th>
                                                    <th style="padding:6px 4px;">Rasio Screening-Join</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $gt = ['keb'=>0,'scr'=>0,'ihr'=>0,'iu'=>0,'ofr'=>0,'jn'=>0,'pem'=>0]; // Grand total
                                            foreach ($funnel_grouped as $unit => $levels):
                                                $ut = ['keb'=>0,'scr'=>0,'ihr'=>0,'iu'=>0,'ofr'=>0,'jn'=>0,'pem'=>0]; // Unit total
                                                $first_unit = true;
                                                foreach ($levels as $level => $rows):
                                                        // Aggregate rows by posisi
                                                        $posisi_map = [];
                                                        foreach ($rows as $r) {
                                                            $key = $r->posisi;
                                                            if (!isset($posisi_map[$key])) {
                                                                $posisi_map[$key] = [
                                                                    'unit' => $unit,
                                                                    'level' => $level,
                                                                    'posisi' => $r->posisi,
                                                                    'kebutuhan' => 0,
                                                                    'lolos_screening' => 0,
                                                                    'interview_hr' => 0,
                                                                    'interview_user' => 0,
                                                                    'offering' => 0,
                                                                    'total_join' => 0,
                                                                    'pemenuhan' => 0
                                                                ];
                                                            }
                                                            $posisi_map[$key]['kebutuhan'] += $r->kebutuhan;
                                                            $posisi_map[$key]['lolos_screening'] += $r->lolos_screening;
                                                            $posisi_map[$key]['interview_hr'] += $r->interview_hr;
                                                            $posisi_map[$key]['interview_user'] += $r->interview_user;
                                                            $posisi_map[$key]['offering'] += $r->offering;
                                                            $posisi_map[$key]['total_join'] += $r->total_join;
                                                            $posisi_map[$key]['pemenuhan'] += $r->pemenuhan;
                                                        }
                                                        // Sort by posisi
                                                        $sorted_posisi = array_values($posisi_map);
                                                        usort($sorted_posisi, function($a, $b) {
                                                            return strcmp($a['posisi'], $b['posisi']);
                                                        });
                                                        $lt = ['keb'=>0,'scr'=>0,'ihr'=>0,'iu'=>0,'ofr'=>0,'jn'=>0,'pem'=>0]; // Level total
                                                        foreach ($sorted_posisi as $r) {
                                                            $lt['keb'] += $r['kebutuhan'];
                                                            $lt['scr'] += $r['lolos_screening'];
                                                            $lt['ihr'] += $r['interview_hr'];
                                                            $lt['iu']  += $r['interview_user'];
                                                            $lt['ofr'] += $r['offering'];
                                                            $lt['jn']  += $r['total_join'];
                                                            $lt['pem'] += $r['pemenuhan'];
                                                            ?>
                                                            <tr>
                                                                <td style="padding:4px 8px;"><?php if ($first_unit) { echo '<strong>'.$unit.'</strong>'; $first_unit = false; } ?></td>
                                                                <td style="padding:4px 8px;"><?= $level ?></td>
                                                                <td style="padding:4px 8px;"><?= $r['posisi'] ?></td>
                                                                <td class="text-center" style="font-weight:700;color:#0d6efd;"><?= $r['kebutuhan'] ?></td>
                                                                <td class="text-center"><?= $r['lolos_screening'] ?></td>
                                                                <td class="text-center"><?= $r['interview_hr'] ?></td>
                                                                <td class="text-center"><?= $r['interview_user'] ?></td>
                                                                <td class="text-center"><?= $r['offering'] ?></td>
                                                                <td class="text-center"><?= $r['total_join'] ?></td>
                                                                <td class="text-center" style="font-weight:700;color:<?= $r['pemenuhan'] >= $r['kebutuhan'] ? '#198754' : '#dc3545' ?>;"><?= $r['pemenuhan'] ?></td>
                                                                <td class="text-center" style="font-weight:700;color:<?= $r['pemenuhan'] >= $r['kebutuhan'] ? '#198754' : '#dc3545' ?>;"><?= $r['pemenuhan'] >= $r['kebutuhan'] ? '✓' : '✗' ?></td>
                                                                <td class="text-center"><?= $pct_safe($r['interview_hr'], $r['lolos_screening']) ?></td>
                                                                <td class="text-center"><?= $pct_safe($r['interview_user'], $r['interview_hr']) ?></td>
                                                                <td class="text-center"><?= $pct_safe($r['offering'], $r['interview_user']) ?></td>
                                                                <td class="text-center"><?= $pct_safe($r['total_join'], $r['offering']) ?></td>
                                                                <td class="text-center"><?= $pct_safe($r['total_join'], $r['lolos_screening']) ?></td>
                                                            </tr>
                                                            <?php }
                                                        ?>
                                                <!-- Level Subtotal -->
                                                <tr style="background:#D6E4F0;font-weight:700;">
                                                    <td style="padding:4px 8px;"></td>
                                                    <td style="padding:4px 8px;" colspan="2"><?= $level ?> Total</td>
                                                    <td class="text-center" style="font-weight:700;color:#0d6efd;"><?= $lt['keb'] ?></td>
                                                    <td class="text-center"><?= $lt['scr'] ?></td>
                                                    <td class="text-center"><?= $lt['ihr'] ?></td>
                                                    <td class="text-center"><?= $lt['iu'] ?></td>
                                                    <td class="text-center"><?= $lt['ofr'] ?></td>
                                                    <td class="text-center"><?= $lt['jn'] ?></td>
                                                    <td class="text-center" style="font-weight:700;color:<?= $lt['pem'] >= $lt['keb'] ? '#198754' : '#dc3545' ?>;"><?= $lt['pem'] ?></td>
                                                    <td class="text-center" style="font-weight:700;color:<?= $lt['pem'] >= $lt['keb'] ? '#198754' : '#dc3545' ?>;"><?= $lt['pem'] >= $lt['keb'] ? '✓' : '✗' ?></td>
                                                    <td class="text-center"><?= $pct_safe($lt['ihr'], $lt['scr']) ?></td>
                                                    <td class="text-center"><?= $pct_safe($lt['iu'], $lt['ihr']) ?></td>
                                                    <td class="text-center"><?= $pct_safe($lt['ofr'], $lt['iu']) ?></td>
                                                    <td class="text-center"><?= $pct_safe($lt['jn'], $lt['ofr']) ?></td>
                                                    <td class="text-center"><?= $pct_safe($lt['jn'], $lt['scr']) ?></td>
                                                </tr>
                                            <?php
                                                    $ut['scr'] += $lt['scr']; $ut['ihr'] += $lt['ihr']; $ut['iu'] += $lt['iu']; $ut['ofr'] += $lt['ofr']; $ut['jn'] += $lt['jn']; $ut['keb'] += $lt['keb']; $ut['pem'] += $lt['pem'];
                                                endforeach;
                                            ?>
                                                <!-- Unit Total -->
                                                <tr style="background:#B4C6E7;font-weight:800;">
                                                    <td style="padding:4px 8px;" colspan="3"><strong><?= $unit ?> Total</strong></td>
                                                    <td class="text-center" style="font-weight:700;color:#0d6efd;"><?= $ut['keb'] ?></td>
                                                    <td class="text-center"><?= $ut['scr'] ?></td>
                                                    <td class="text-center"><?= $ut['ihr'] ?></td>
                                                    <td class="text-center"><?= $ut['iu'] ?></td>
                                                    <td class="text-center"><?= $ut['ofr'] ?></td>
                                                    <td class="text-center"><?= $ut['jn'] ?></td>
                                                    <td class="text-center" style="font-weight:700;color:<?= $ut['pem'] >= $ut['keb'] ? '#198754' : '#dc3545' ?>;"><?= $ut['pem'] ?></td>
                                                    <td class="text-center" style="font-weight:700;color:<?= $ut['pem'] >= $ut['keb'] ? '#198754' : '#dc3545' ?>;"><?= $ut['pem'] >= $ut['keb'] ? '✓' : '✗' ?></td>
                                                    <td class="text-center"><?= $pct_safe($ut['ihr'], $ut['scr']) ?></td>
                                                    <td class="text-center"><?= $pct_safe($ut['iu'], $ut['ihr']) ?></td>
                                                    <td class="text-center"><?= $pct_safe($ut['ofr'], $ut['iu']) ?></td>
                                                    <td class="text-center"><?= $pct_safe($ut['jn'], $ut['ofr']) ?></td>
                                                    <td class="text-center"><?= $pct_safe($ut['jn'], $ut['scr']) ?></td>
                                                </tr>
                                            <?php
                                                $gt['scr'] += $ut['scr']; $gt['ihr'] += $ut['ihr']; $gt['iu'] += $ut['iu']; $gt['ofr'] += $ut['ofr']; $gt['jn'] += $ut['jn']; $gt['keb'] += $ut['keb']; $gt['pem'] += $ut['pem'];
                                            endforeach;
                                            ?>
                                                <!-- Grand Total -->
                                                <tr style="background:#4472C4;color:#fff;font-weight:900;">
                                                    <td style="padding:6px 8px;" colspan="3"><strong>Grand Total</strong></td>
                                                    <td class="text-center" style="font-weight:700;color:#0d6efd;"><?= $gt['keb'] ?></td>
                                                    <td class="text-center"><?= $gt['scr'] ?></td>
                                                    <td class="text-center"><?= $gt['ihr'] ?></td>
                                                    <td class="text-center"><?= $gt['iu'] ?></td>
                                                    <td class="text-center"><?= $gt['ofr'] ?></td>
                                                    <td class="text-center"><?= $gt['jn'] ?></td>
                                                    <td class="text-center" style="font-weight:700;color:<?= $gt['pem'] >= $gt['keb'] ? '#198754' : '#dc3545' ?>;"><?= $gt['pem'] ?></td>
                                                    <td class="text-center" style="font-weight:700;color:<?= $gt['pem'] >= $gt['keb'] ? '#198754' : '#dc3545' ?>;"><?= $gt['pem'] >= $gt['keb'] ? '✓' : '✗' ?></td>
                                                    <td class="text-center"><?= $pct_safe($gt['ihr'], $gt['scr']) ?></td>
                                                    <td class="text-center"><?= $pct_safe($gt['iu'], $gt['ihr']) ?></td>
                                                    <td class="text-center"><?= $pct_safe($gt['ofr'], $gt['iu']) ?></td>
                                                    <td class="text-center"><?= $pct_safe($gt['jn'], $gt['ofr']) ?></td>
                                                    <td class="text-center"><?= $pct_safe($gt['jn'], $gt['scr']) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <!-- /tabFunnel -->

                            <!-- ═══════════════════════════════════
                                 TAB 3: PIC PERFORMANCE
                                 ═══════════════════════════════════ -->
                            <div class="tab-pane fade" id="tabPIC" role="tabpanel">

                                <div class="row g-3 mb-3">
                                    <div class="col-lg-8">
                                        <div class="rc-card h-100">
                                            <div class="rc-sec-title">Performa PIC Recruiter</div>
                                            <div class="rc-sec-hint">Persentase pemenuhan per PIC Recruiter</div>
                                            <div style="position:relative;height:300px;width:100%;">
                                                <canvas id="chartPIC"></canvas>
                                            </div>
                                            <div style="font-size:10px;color:var(--rc-text-muted);margin-top:6px;">
                                                Target minimum: 80% · Hijau ≥80% · Kuning ≥50% · Merah &lt;50%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="rc-card h-100">
                                            <div class="rc-sec-title">Ringkasan Status PIC</div>
                                            <div class="rc-sec-hint">Distribusi status PIC</div>
                                            <div style="position:relative;height:180px;width:100%;">
                                                <canvas id="chartPIEpic"></canvas>
                                            </div>
                                            <div class="mt-3">
                                                <div class="d-flex justify-content-between mb-2" style="font-size:12px;">
                                                    <span style="color:var(--rc-text-sec);">On Track ≥80%</span>
                                                    <span style="color:var(--rc-green);font-weight:800;"><?= $pic_on_track ?> PIC</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2" style="font-size:12px;">
                                                    <span style="color:var(--rc-text-sec);">Perhatian 50–79%</span>
                                                    <span style="color:var(--rc-yellow);font-weight:800;"><?= $pic_perhatian ?> PIC</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2" style="font-size:12px;">
                                                    <span style="color:var(--rc-text-sec);">Kritis &lt;50%</span>
                                                    <span style="color:var(--rc-red);font-weight:800;"><?= $pic_kritis ?> PIC</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- PIC Detail Table -->
                                <div class="rc-card">
                                    <div class="rc-sec-title">Detail Tabel PIC</div>
                                    <div class="rc-sec-hint">Beban kerja dan capaian setiap PIC</div>
                                    <div class="table-responsive">
                                        <table class="rc-table">
                                            <thead>
                                                <tr>
                                                    <th>PIC</th>
                                                    <th class="text-center">Kebutuhan</th>
                                                    <th class="text-center">Pemenuhan</th>
                                                    <th>Capaian</th>
                                                    <th class="text-center">Gap</th>
                                                    <th>Status</th>
                                                    <th>Catatan</th>
                                                </tr>
                                            </thead>
                                            <tbody id="picTableBody">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div><!-- /tabPIC -->

                            <!-- ═══════════════════════════════════
                                 TAB 4: POSISI TERBUKA
                                 ═══════════════════════════════════ -->
                            <div class="tab-pane fade" id="tabOpen" role="tabpanel">

                                <div class="rc-card mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <div class="rc-sec-title">Watchlist — Posisi Prioritas</div>
                                            <div class="rc-sec-hint mb-0">Posisi yang belum terpenuhi & sudah lama terbuka</div>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button class="rc-sort-btn active" onclick="sortOpenPos('usia')">Sort: Usia Posisi</button>
                                            <button class="rc-sort-btn" onclick="sortOpenPos('posisi')">Sort: Nama</button>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="rc-table">
                                            <thead>
                                                <tr>
                                                    <th>NO FPK</th>
                                                    <th>Job Vacancy</th>
                                                    <th>Posisi</th>
                                                    <th>Unit</th>
                                                    <th>PIC</th>
                                                    <th>Creator</th>
                                                    <th>Usia (Hari)</th>
                                                    <th>Alasan Kendala</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="openPosTableBody">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="margin-top:12px;font-size:11px;color:var(--rc-text-muted);">
                                        ⚠ Kolom <strong style="color:var(--rc-yellow);">Usia Posisi</strong> adalah tambahan yang direkomendasikan — data estimatif. Pada implementasi nyata, kolom ini otomatis dari tanggal buka posisi di ATS.
                                    </div>
                                </div>

                                <!-- Age distribution -->
                                <div class="row g-3">
                                    <div class="col-lg-4">
                                        <div class="rc-card text-center" style="background:var(--rc-red-bg);border-color:#fecaca;">
                                            <div style="font-size:36px;font-weight:900;color:var(--rc-red);"><?= $age_critical ?></div>
                                            <div style="font-size:13px;font-weight:700;color:var(--rc-red);margin:4px 0;">&gt; 45 Hari</div>
                                            <div style="font-size:11px;color:var(--rc-text-sec);">Kritis — eskalasi ke leadership</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="rc-card text-center" style="background:var(--rc-yellow-bg);border-color:#fde68a;">
                                            <div style="font-size:36px;font-weight:900;color:var(--rc-yellow);"><?= $age_attention ?></div>
                                            <div style="font-size:13px;font-weight:700;color:var(--rc-yellow);margin:4px 0;">30–45 Hari</div>
                                            <div style="font-size:11px;color:var(--rc-text-sec);">Perlu tindakan cepat minggu ini</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="rc-card text-center" style="background:var(--rc-blue-bg);border-color:#bfdbfe;">
                                            <div style="font-size:36px;font-weight:900;color:var(--rc-blue);"><?= $age_normal ?></div>
                                            <div style="font-size:13px;font-weight:700;color:var(--rc-blue);margin:4px 0;">&lt; 30 Hari</div>
                                            <div style="font-size:11px;color:var(--rc-text-sec);">Dalam proses normal</div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- /tabOpen -->

                            <!-- ═══════════════════════════════════
                                 TAB 5: ANALISIS & REKOMENDASI
                                 ═══════════════════════════════════ -->
                            <div class="tab-pane fade" id="tabAnalisis" role="tabpanel">

                                <div class="mb-3">
                                    <div style="font-size:14px;font-weight:800;margin-bottom:4px;">Rekomendasi Tindakan Berdasarkan Data Laporan</div>
                                    <div style="font-size:12px;color:var(--rc-text-muted);">Diurutkan berdasarkan dampak & urgensi · P1 = segera, P2 = minggu ini, P3 = bulan ini</div>
                                </div>

                                <?php
                                // Auto-generate recommendations based on data
                                $recs = [];

                                // P1: Unit kritis (< 50%)
                                foreach ($sorted_units as $su) {
                                    if ($su['pct'] < 50) {
                                        $recs[] = [
                                            'priority' => 'P1', 'bg' => 'var(--rc-red-bg)', 'border' => '#fecaca', 'color' => 'var(--rc-red)',
                                            'title' => 'Eskalasi ' . $su['unit'] . ' — Hanya ' . $su['pct'] . '% Terpenuhi',
                                            'desc' => $su['pemenuhan'] . ' dari ' . $su['kebutuhan'] . ' posisi terpenuhi, gap ' . $su['gap'] . ' posisi.',
                                            'action' => 'Review job requirement & salary range. Aktifkan headhunter eksternal. Bawa ke meeting leadership minggu ini.',
                                        ];
                                    }
                                }

                                // P1: Biggest drop stage
                                if ($max_drop_pct > 15) {
                                    $recs[] = [
                                        'priority' => 'P1', 'bg' => 'var(--rc-red-bg)', 'border' => '#fecaca', 'color' => 'var(--rc-red)',
                                        'title' => 'Drop ' . $max_drop_pct . '% di Tahap ' . $max_drop_stage,
                                        'desc' => 'Penurunan terbesar di funnel terjadi di tahap ' . $max_drop_stage . '. Perlu investigasi penyebab.',
                                        'action' => 'Adakan briefing rutin recruiter–hiring manager. Perjelas kriteria kandidat ideal di tahap ini.',
                                    ];
                                }

                                // P2: Units perlu perhatian (50-79%)
                                foreach ($sorted_units as $su) {
                                    if ($su['pct'] >= 50 && $su['pct'] < 80) {
                                        $recs[] = [
                                            'priority' => 'P2', 'bg' => 'var(--rc-orange-bg)', 'border' => '#fed7aa', 'color' => 'var(--rc-orange)',
                                            'title' => $su['unit'] . ' Butuh Perhatian — ' . $su['pct'] . '%',
                                            'desc' => $su['gap'] . ' posisi belum terpenuhi dari total ' . $su['kebutuhan'] . '.',
                                            'action' => 'Tingkatkan sourcing & review strategi rekrutmen untuk unit ' . $su['unit'] . '.',
                                        ];
                                    }
                                }

                                // P2: Open positions > 45 days
                                if ($age_critical > 0) {
                                    $recs[] = [
                                        'priority' => 'P2', 'bg' => 'var(--rc-orange-bg)', 'border' => '#fed7aa', 'color' => 'var(--rc-orange)',
                                        'title' => $age_critical . ' Posisi Terbuka > 45 Hari',
                                        'desc' => 'Posisi ini sudah terlalu lama terbuka dan perlu eskalasi.',
                                        'action' => 'Review beban kerja PIC terkait. Pertimbangkan headhunter untuk posisi sulit.',
                                    ];
                                }

                                // P3: PIC kritis
                                if ($pic_kritis > 0) {
                                    $recs[] = [
                                        'priority' => 'P3', 'bg' => 'var(--rc-yellow-bg)', 'border' => '#fde68a', 'color' => 'var(--rc-yellow)',
                                        'title' => 'Support PIC dengan Capaian < 50%',
                                        'desc' => implode(', ', $pic_kritis_names) . ' — PIC ini menangani posisi yang umumnya sulit terpenuhi.',
                                        'action' => 'Review beban posisi masing-masing. Tambahkan support atau redistribusi posisi.',
                                    ];
                                }

                                // P3: Pemenuhan overall < 80%
                                if ($grand_pct < 80) {
                                    $recs[] = [
                                        'priority' => 'P3', 'bg' => 'var(--rc-yellow-bg)', 'border' => '#fde68a', 'color' => 'var(--rc-yellow)',
                                        'title' => 'Pemenuhan Keseluruhan ' . $grand_pct . '% — Belum Capai Target 80%',
                                        'desc' => 'Masih ada ' . $grand_gap . ' posisi yang perlu dipenuhi.',
                                        'action' => 'Fokuskan effort pada unit & posisi dengan gap terbesar. Review strategi sourcing secara menyeluruh.',
                                    ];
                                }

                                if (empty($recs)) {
                                    $recs[] = [
                                        'priority' => '✓', 'bg' => 'var(--rc-green-bg)', 'border' => '#a7f3d0', 'color' => 'var(--rc-green)',
                                        'title' => 'Semua Target Tercapai',
                                        'desc' => 'Pemenuhan ' . $grand_pct . '% — seluruh unit bisnis dalam kondisi baik.',
                                        'action' => 'Pertahankan momentum. Lakukan continuous improvement.',
                                    ];
                                }

                                foreach ($recs as $rec):
                                ?>
                                <div class="rc-rec-card d-flex flex-column flex-md-row gap-3" style="background:<?= $rec['bg'] ?>;border:1px solid <?= $rec['border'] ?>;">
                                    <div><span class="rc-priority-badge" style="background:<?= $rec['color'] ?>;"><?= $rec['priority'] ?></span></div>
                                    <div class="flex-grow-1">
                                        <div style="font-size:13px;font-weight:800;color:<?= $rec['color'] ?>;margin-bottom:6px;"><?= $rec['title'] ?></div>
                                        <div style="font-size:12px;color:var(--rc-text-sec);line-height:1.6;"><?= $rec['desc'] ?></div>
                                    </div>
                                    <div style="min-width:260px;">
                                        <div style="font-size:11px;color:var(--rc-text-muted);font-weight:700;margin-bottom:4px;text-transform:uppercase;letter-spacing:0.8px;">→ Tindakan</div>
                                        <div style="font-size:12px;line-height:1.6;"><?= $rec['action'] ?></div>
                                    </div>
                                </div>
                                <?php endforeach; ?>

                            </div><!-- /tabAnalisis -->

                        </div><!-- /tab-content -->

                        <!-- ── FOOTER ── -->
                        <div class="d-flex justify-content-between p-3 border-top" style="font-size:11px;color:var(--rc-text-muted);">
                            <span>Sumber: Data Rekrutmen <?= $date_label ?> · Diperbarui: <?= date('d M Y H:i') ?></span>
                            <span>Dashboard Recruitment LIGA — <?= implode(' · ', array_column($units_data, 'unit')) ?></span>
                        </div>

                    </div><!-- /rc-dashboard -->

                    <!-- ══════════════════════════════════════════
                         CHART.JS CDN + SCRIPTS
                         ══════════════════════════════════════════ -->
                    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {

                        /* ── DATA (from PHP) ── */
                        const picData = <?= json_encode($pic_js) ?>;
                        const kebutuhanDetail = <?= json_encode($kebutuhan_detail_js) ?>;
                        const pemenuhanDetail = <?= json_encode($pemenuhan_detail_js) ?>;
                        const openPositions = <?= json_encode($open_js) ?>;
                        const unitsData = <?= json_encode($units_data) ?>;
                        const rejLabels = <?= json_encode($rej_labels) ?>;
                        const rejValues = <?= json_encode($rej_values) ?>;

                        /* ── HELPERS ── */
                        function getStatusPill(status) {
                            const map = {
                                'Kritis':    { cls: 'rc-pill-red',    label: '⚠ Kritis' },
                                'Perhatian': { cls: 'rc-pill-yellow', label: '! Perhatian' },
                                'Monitor':   { cls: 'rc-pill-blue',   label: '· Monitor' },
                                'Aman':      { cls: 'rc-pill-green',  label: '✓ Aman' },
                            };
                            const s = map[status] || map['Monitor'];
                            return '<span class="rc-pill ' + s.cls + '">' + s.label + '</span>';
                        }

                        function getPctPill(pct) {
                            let cls = pct >= 80 ? 'rc-pill-green' : pct >= 50 ? 'rc-pill-yellow' : 'rc-pill-red';
                            return '<span class="rc-pill ' + cls + '" style="font-size:13px;font-weight:800;padding:3px 10px;">' + pct + '%</span>';
                        }

                        function getUnitBadge(unit) {
                            const map = {
                                'TKB': { bg: 'var(--rc-green-bg)', color: 'var(--rc-green)' },
                                'BT':  { bg: 'var(--rc-orange-bg)', color: 'var(--rc-orange)' },
                                'RSP': { bg: 'var(--rc-blue-bg)', color: 'var(--rc-blue)' },
                            };
                            const s = map[unit] || { bg: 'var(--rc-surface-alt)', color: 'var(--rc-text-sec)' };
                            return '<span class="rc-unit-badge" style="background:' + s.bg + ';color:' + s.color + ';">' + unit + '</span>';
                        }

                        function getAgeColor(usia) {
                            if (usia >= 45) return 'var(--rc-red)';
                            if (usia >= 30) return 'var(--rc-yellow)';
                            return 'var(--rc-blue)';
                        }

                        /* ── PIC TABLE ── */
                        function buildKebutuhanTooltip(picId, kebutuhan) {
                            var details = kebutuhanDetail[picId];
                            if (!details || details.length === 0) {
                                return '<td class="text-center" style="color:var(--rc-text-sec);">' + kebutuhan + '</td>';
                            }
                            // Group by job_title + department + position, sum vacancy
                            var grouped = {};
                            details.forEach(function(d) {
                                var key = d.job_title + '||' + d.department + '||' + d.position;
                                if (!grouped[key]) {
                                    grouped[key] = { job_title: d.job_title, department: d.department, position: d.position, vacancy: 0 };
                                }
                                grouped[key].vacancy += d.vacancy;
                            });
                            // Sort: by position then job_title
                            var groupedArr = Object.values(grouped).sort(function(a, b) {
                                var cmp = a.position.localeCompare(b.position);
                                return cmp !== 0 ? cmp : a.job_title.localeCompare(b.job_title);
                            });

                            var tooltip = '<div class="rc-tooltip-detail">'
                                + '<div class="rc-tooltip-title">Detail Kebutuhan</div>';
                            var totalVacancy = 0;
                            groupedArr.forEach(function(d) {
                                totalVacancy += d.vacancy;
                                tooltip += '<div class="rc-tooltip-row">'
                                    + '<div style="flex:1;">'
                                    + '<div class="rc-tooltip-job">' + d.job_title + '</div>'
                                    + '<div class="rc-tooltip-dept">' + d.department + ' · ' + d.position + '</div>'
                                    + '</div>'
                                    + '<div class="rc-tooltip-vacancy">' + d.vacancy + '</div>'
                                    + '</div>';
                            });
                            tooltip += '<div class="rc-tooltip-total">'
                                + '<span>Total Kebutuhan</span>'
                                + '<span>' + totalVacancy + '</span>'
                                + '</div>';
                            tooltip += '</div>';
                            return '<td class="text-center rc-kebutuhan-cell" style="color:var(--rc-text-sec);">'
                                + '<span style="border-bottom:1px dashed var(--rc-text-muted);cursor:pointer;">' + kebutuhan + '</span>'
                                + tooltip + '</td>';
                        }

                        function buildPemenuhanTooltip(picId, pemenuhan) {
                            var details = pemenuhanDetail[picId];
                            if (!details || details.length === 0) {
                                return '<td class="text-center" style="color:var(--rc-text-sec);">' + pemenuhan + '</td>';
                            }
                            var grouped = {};
                            details.forEach(function(d) {
                                var key = d.job_title + '||' + d.department + '||' + d.position;
                                if (!grouped[key]) {
                                    grouped[key] = { job_title: d.job_title, department: d.department, position: d.position, pemenuhan: 0 };
                                }
                                grouped[key].pemenuhan += d.pemenuhan;
                            });
                            var groupedArr = Object.values(grouped).sort(function(a, b) {
                                var cmp = a.position.localeCompare(b.position);
                                return cmp !== 0 ? cmp : a.job_title.localeCompare(b.job_title);
                            });

                            var tooltip = '<div class="rc-tooltip-detail rc-tooltip-pemenuhan">'
                                + '<div class="rc-tooltip-title">Detail Pemenuhan</div>';
                            var totalPemenuhan = 0;
                            groupedArr.forEach(function(d) {
                                totalPemenuhan += d.pemenuhan;
                                tooltip += '<div class="rc-tooltip-row">'
                                    + '<div style="flex:1;">'
                                    + '<div class="rc-tooltip-job">' + d.job_title + '</div>'
                                    + '<div class="rc-tooltip-dept">' + d.department + ' · ' + d.position + '</div>'
                                    + '</div>'
                                    + '<div class="rc-tooltip-vacancy" style="background:var(--rc-green-bg);color:var(--rc-green);">' + d.pemenuhan + '</div>'
                                    + '</div>';
                            });
                            tooltip += '<div class="rc-tooltip-total" style="border-top:2px solid var(--rc-green);color:var(--rc-green);">'
                                + '<span>Total Pemenuhan</span>'
                                + '<span>' + totalPemenuhan + '</span>'
                                + '</div>';
                            tooltip += '</div>';
                            return '<td class="text-center rc-pemenuhan-cell" style="color:var(--rc-text-sec);">'
                                + '<span style="border-bottom:1px dashed var(--rc-green);cursor:pointer;color:var(--rc-green);font-weight:700;">' + pemenuhan + '</span>'
                                + tooltip + '</td>';
                        }

                        function renderPICTable() {
                            let html = '';
                            picData.forEach(function(p) {
                                const gap = p.kebutuhan - p.pemenuhan;
                                const gapColor = gap > 0 ? 'var(--rc-red)' : 'var(--rc-green)';
                                const gapText = gap > 0 ? '-' + gap : '✓';
                                const statusLabel = p.pct >= 80 ? 'Aman' : p.pct >= 50 ? 'Monitor' : 'Kritis';
                                const note = p.pct === 100 ? 'Excellent — semua posisi terpenuhi'
                                    : p.pct >= 70 ? 'Progres baik, perlu sedikit dorongan'
                                    : p.pct >= 50 ? 'Beberapa posisi sulit terpenuhi'
                                    : 'Butuh support & review strategi sourcing';
                                html += '<tr>'
                                    + '<td style="font-weight:700;">' + p.pic + '</td>'
                                    + buildKebutuhanTooltip(p.id_pic, p.kebutuhan)
                                    + buildPemenuhanTooltip(p.id_pic, p.pemenuhan)
                                    + '<td>' + getPctPill(p.pct) + '</td>'
                                    + '<td class="text-center" style="color:' + gapColor + ';font-weight:700;">' + gapText + '</td>'
                                    + '<td>' + getStatusPill(statusLabel) + '</td>'
                                    + '<td style="color:var(--rc-text-muted);font-size:11px;">' + note + '</td>'
                                    + '</tr>';
                            });
                            document.getElementById('picTableBody').innerHTML = html;

                            // Attach hover events for tooltip positioning (kebutuhan + pemenuhan)
                            document.querySelectorAll('.rc-kebutuhan-cell, .rc-pemenuhan-cell').forEach(function(cell) {
                                var tooltip = cell.querySelector('.rc-tooltip-detail');
                                if (!tooltip) return;
                                cell.addEventListener('mouseenter', function(e) {
                                    var rect = cell.getBoundingClientRect();
                                    tooltip.style.display = 'block';
                                    var top = rect.bottom + 8;
                                    var left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2);
                                    if (top + tooltip.offsetHeight > window.innerHeight) {
                                        top = rect.top - tooltip.offsetHeight - 8;
                                    }
                                    if (left < 8) left = 8;
                                    if (left + tooltip.offsetWidth > window.innerWidth - 8) {
                                        left = window.innerWidth - tooltip.offsetWidth - 8;
                                    }
                                    tooltip.style.top = top + 'px';
                                    tooltip.style.left = left + 'px';
                                });
                                cell.addEventListener('mouseleave', function() {
                                    tooltip.style.display = 'none';
                                });
                            });
                        }
                        renderPICTable();

                        /* ── OPEN POSITIONS TABLE ── */
                        let currentSort = 'usia';
                        function renderOpenPosTable() {
                            const sorted = [...openPositions].sort(function(a, b) {
                                return currentSort === 'usia' ? b.usia - a.usia : a.posisi.localeCompare(b.posisi);
                            });
                            let html = '';
                            sorted.forEach(function(p) {
                                html += '<tr>'
                                    + '<td style="font-weight:600;">' + p.no_fpk + '</td>'
                                    + '<td style="text-align:center;">' + p.target + '</td>'
                                    + '<td style="font-weight:600;">' + p.posisi + '</td>'
                                    + '<td>' + getUnitBadge(p.unit) + '</td>'
                                    + '<td style="color:var(--rc-text-sec);">' + p.pic + '</td>'
                                    + '<td style="color:var(--rc-text-sec);">' + p.creator + '</td>'
                                    + '<td><span style="font-size:14px;font-weight:900;color:' + getAgeColor(p.usia) + ';">' + p.usia + '</span> <span style="font-size:10px;color:var(--rc-text-muted);">hari</span></td>'
                                    + '<td style="color:var(--rc-text-muted);font-size:11px;">Gap: ' + p.gap + ' posisi</td>'
                                    + '<td>' + getStatusPill(p.status) + '</td>'
                                    + '</tr>';
                            });
                            document.getElementById('openPosTableBody').innerHTML = html;
                        }
                        renderOpenPosTable();

                        window.sortOpenPos = function(by) {
                            currentSort = by;
                            renderOpenPosTable();
                            document.querySelectorAll('.rc-sort-btn').forEach(function(btn) {
                                btn.classList.toggle('active', btn.textContent.includes(by === 'usia' ? 'Usia' : 'Nama'));
                            });
                        };

                        /* ── CHART: Unit Bisnis (Overview) ── */
                        new Chart(document.getElementById('chartUnitBisnis'), {
                            type: 'bar',
                            data: {
                                labels: unitsData.map(function(u){ return u.unit; }),
                                datasets: [
                                    {
                                        label: 'Kebutuhan',
                                        data: unitsData.map(function(u){ return u.kebutuhan; }),
                                        backgroundColor: 'rgba(37, 99, 235, 0.2)',
                                        borderColor: '#2563eb',
                                        borderWidth: 1,
                                        borderRadius: 4,
                                        barPercentage: 0.6,
                                        categoryPercentage: 0.7
                                    },
                                    {
                                        label: 'Pemenuhan',
                                        data: unitsData.map(function(u){ return u.pemenuhan; }),
                                        backgroundColor: '#2563eb',
                                        borderColor: '#1d4ed8',
                                        borderWidth: 1,
                                        borderRadius: 4,
                                        barPercentage: 0.6,
                                        categoryPercentage: 0.7
                                    },
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { position: 'bottom', labels: { font: { size: 11 }, color: '#64748b', usePointStyle: true, pointStyle: 'rectRounded', padding: 16 } },
                                    tooltip: {
                                        backgroundColor: '#fff',
                                        titleColor: '#1e293b',
                                        bodyColor: '#64748b',
                                        borderColor: '#e2e8f0',
                                        borderWidth: 1,
                                        cornerRadius: 8,
                                        padding: 10,
                                        callbacks: {
                                            afterBody: function(context) {
                                                var idx = context[0].dataIndex;
                                                var keb = unitsData[idx].kebutuhan;
                                                var pem = unitsData[idx].pemenuhan;
                                                return 'Pemenuhan: ' + (keb > 0 ? (pem/keb*100).toFixed(2) : '0.00') + '%';
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: { grid: { display: false }, ticks: { color: '#64748b', font: { size: 12, weight: '600' } } },
                                    y: { beginAtZero: true, grid: { color: '#f1f5f9', drawBorder: false }, ticks: { color: '#94a3b8', font: { size: 11 } } }
                                }
                            }
                        });

                        /* ── CHART: PIC Performance ── */
                        new Chart(document.getElementById('chartPIC'), {
                            type: 'bar',
                            data: {
                                labels: picData.map(function(p){ return p.pic; }),
                                datasets: [{
                                    label: 'Pemenuhan %',
                                    data: picData.map(function(p){ return p.pct; }),
                                    backgroundColor: picData.map(function(p){
                                        return p.pct >= 80 ? 'rgba(5, 150, 105, 0.8)' : p.pct >= 50 ? 'rgba(217, 119, 6, 0.8)' : 'rgba(220, 38, 38, 0.8)';
                                    }),
                                    borderColor: picData.map(function(p){
                                        return p.pct >= 80 ? '#059669' : p.pct >= 50 ? '#d97706' : '#dc2626';
                                    }),
                                    borderWidth: 1,
                                    borderRadius: 6,
                                    barPercentage: 0.7,
                                }]
                            },
                            options: {
                                indexAxis: 'y',
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        backgroundColor: '#fff',
                                        titleColor: '#1e293b',
                                        bodyColor: '#64748b',
                                        borderColor: '#e2e8f0',
                                        borderWidth: 1,
                                        cornerRadius: 8,
                                        padding: 10,
                                        callbacks: {
                                            label: function(ctx) {
                                                var p = picData[ctx.dataIndex];
                                                return p.pic + ': ' + p.pct + '% (' + p.pemenuhan + '/' + p.kebutuhan + ')';
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: { max: 110, beginAtZero: true, grid: { color: '#f1f5f9', drawBorder: false }, ticks: { color: '#94a3b8', font: { size: 11 }, callback: function(v){ return v + '%'; } } },
                                    y: { grid: { display: false }, ticks: { color: '#64748b', font: { size: 12, weight: '600' } } }
                                }
                            }
                        });

                        /* ── CHART: PIC Pie ── */
                        new Chart(document.getElementById('chartPIEpic'), {
                            type: 'doughnut',
                            data: {
                                labels: ['On Track (≥80%)', 'Perlu Perhatian (50–79%)', 'Kritis (<50%)'],
                                datasets: [{
                                    data: [<?= $pic_on_track ?>, <?= $pic_perhatian ?>, <?= $pic_kritis ?>],
                                    backgroundColor: ['rgba(5, 150, 105, 0.85)', 'rgba(217, 119, 6, 0.85)', 'rgba(220, 38, 38, 0.85)'],
                                    borderWidth: 3,
                                    borderColor: '#ffffff',
                                    hoverOffset: 6,
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                cutout: '60%',
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        backgroundColor: '#fff',
                                        titleColor: '#1e293b',
                                        bodyColor: '#64748b',
                                        borderColor: '#e2e8f0',
                                        borderWidth: 1,
                                        cornerRadius: 8,
                                        padding: 10,
                                        callbacks: {
                                            label: function(ctx) {
                                                return ctx.label + ': ' + ctx.raw + ' PIC';
                                            }
                                        }
                                    }
                                }
                            }
                        });

                        /* ── Header Pct Color ── */
                        const headerPct = document.getElementById('headerPctTotal');
                        if (headerPct) {
                            var pctVal = <?= $grand_frck_pct ?>;
                            headerPct.style.color = pctVal >= 80 ? '#059669' : pctVal >= 50 ? '#d97706' : '#dc2626';
                        }

                    });
                    </script>


                </div>
            </div>
        </div>
    </div>
</main>