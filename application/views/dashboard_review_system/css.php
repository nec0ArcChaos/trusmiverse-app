<link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet">
<!-- button export -->
<link rel="stylesheet" href="<?= base_url('assets/data-table/css/buttons.dataTables.min.css') ?>">

<style>
    body {
        background-color: #f8faff;
        font-family: Arial, sans-serif;
    }

    #example th, #example td {
        white-space: nowrap; /* biar teks nggak turun ke bawah */
    }

    .card {
        background: rgba(255, 255, 255, 0);
        /* transparan */
        border: none;
        border-radius: 15px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        display: flex;
        flex-direction: column;
    }

    .search-box {
        border-radius: 10px;
        border: 1px solid #ddd;
        padding: 8px 12px;
        width: 100%;
    }

    .progress-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: conic-gradient(#007bff 0% 30%, #e9ecef 30% 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
    }

    .dashboard-wrapper {
        background: url('<?= base_url('assets/img/dash_review_system/hero_section.png') ?>') no-repeat center center;
        background-size: cover;
        border-radius: 20px;
        padding: 30px;
    }

    canvas {
        background-color: transparent !important;
    }

    /* Tabel traffic system overview */
    .table-card {
        background: #fff;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        font-size: 14px;
    }

    .table thead th {
        font-weight: 600;
        color: #555;
        border-bottom: 2px solid #f0f0f0;
        padding: 10px;
    }

    .table tbody td {
        vertical-align: middle;
        padding: 10px;
        border-bottom: 1px solid #f5f5f5;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .badge-status {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-green {
        background: rgba(0, 200, 83, 0.15);
        color: #00c853;
    }

    .badge-yellow {
        background: rgba(255, 193, 7, 0.15);
        color: #ff9800;
    }

    .badge-red {
        background: rgba(244, 67, 54, 0.15);
        color: #f44336;
    }

    .text-blue {
        color: #0d6efd;
        font-weight: 500;
    }

    .pagination-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 10px;
    }

    /* Tabel ticket per divisi */

    /* Statistik progres tiket */
    .ticket-card {
        background: url('<?= base_url('assets/img/dash_review_system/ticket_card.png') ?>') no-repeat center center;
        background-size: cover;
        border-radius: 20px;
        padding: 20px;
        /* color: #ffffffff; */
        height: 100%;
    }

    .ticket-card h6 {
        font-weight: 600;
    }

    .ticket-card .total-tickets {
        font-size: 2rem;
        font-weight: bold;
    }

    .badge-custom {
        border-radius: 12px;
        padding: 4px 10px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    /* Table Resume PIC */
    .table-resume-pic {
        border-radius: 15px;
    }

    .table-resume-pic thead th {
        font-size: 14px;
        color: #6c757d;
    }

    .table-resume-pic tbody td {
        font-size: 14px;
    }

    .progress-bar .bg-gradient {
        background: linear-gradient(90deg, #00c6ff, #0072ff);
        /* background: #00c853; */
    }


    /* Tracking System Error Card */
    .tracking-card {
        background: #fff;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        font-family: sans-serif;
        max-width: 400px;
        display: flex;
        flex-direction: column;
    }

    .tracking-card h4 {
        margin-bottom: 12px;
    }

    .progress-section {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
    }

    .error-percentage {
        font-weight: bold;
        color: #d9534f;
    }

    .progress-bar {
        flex: 1;
        height: 6px;
        background: #eaeaea;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-fill {
        width: 0%;
        height: 100%;
        background: linear-gradient(to right, #28a745, #007bff);
    }

    .done-info {
        font-size: 12px;
        color: #666;
    }

    .error-list {
        max-height: 350px;
        /* Tinggi scroll */
        overflow-y: auto;
        padding-right: 4px;
    }

    .error-item {
        border: 1px solid #f0f0f0;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 12px;
        background: #fff;
    }

    .error-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .error-header h5 {
        margin: 0;
        font-size: 14px;
    }

    .error-date {
        font-size: 12px;
        color: #888;
        margin: 4px 0;
    }

    .badge {
        padding: 4px 8px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: bold;
        color: #fff;
    }

    .badge.urgent {
        background: #f8d7da;
        color: #d9534f;
    }

    .badge.normal {
        background: #d4edda;
        color: #28a745;
    }

    .badge.blue {
        background: #d4e5edff;
        color: #2872a7ff;
    }

    .error-meta {
        font-size: 12px;
        margin-top: 6px;
    }

    .error-meta div {
        margin-bottom: 4px;
    }

    .status {
        padding: 2px 6px;
        border-radius: 8px;
        font-size: 11px;
    }

    .status.progress {
        background: #d1ecf1;
        color: #0c5460;
    }

    /* Scrollbar styling */
    .error-list::-webkit-scrollbar {
        width: 6px;
    }

    .error-list::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 4px;
    }


    /* Dua kolom di error-meta */
    .error-meta.two-column {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .error-meta.two-column .meta-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .error-meta.two-column .meta-label {
        font-size: 0.85rem;
        color: #555;
    }

    .error-meta.two-column .meta-value {
        font-size: 0.85rem;
        text-align: right;
    }

    .badge.blue {
        background-color: #e0f0ff;
        color: #0d6efd;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
    }

    /* Kepuasan Pengguna */
    .kepuasan-card {
        display: flex;
        justify-content: space-between;
        background: url('background.png') no-repeat center/cover;
        padding: 20px;
        border-radius: 15px;
        position: relative;
        overflow: hidden;
    }

    .kepuasan-left {
        flex: 1;
        z-index: 2;
    }

    .kepuasan-right {
        position: absolute;
        right: -20px;
        bottom: -20px;
        width: 220px;
        height: 220px;
    }

    .chart-text {
        position: absolute;
        top: 55%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        z-index: 3;
    }

    .detail-box table {
        width: 100%;
        border-collapse: collapse;
    }

    .detail-box td,
    .detail-box th {
        padding: 5px 10px;
        text-align: left;
    }
</style>