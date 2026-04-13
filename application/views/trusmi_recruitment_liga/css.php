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
