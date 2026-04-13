    <!-- button export -->
    <link rel="stylesheet" href="<?= base_url('assets/data-table/css/buttons.dataTables.min.css') ?>">
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css"> -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/scss/custom_button.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/scss/custom_input.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.css">

    <style>
        .dashboard-header {
            background: linear-gradient(135deg, rgb(240, 29, 29), #9f6afc);
        }

        .dashboard-input {
            border-radius: 12px;
            border: none;
        }

        .dashboard-btn {
            background: linear-gradient(135deg, rgb(252, 3, 3), #8c5dff);
            color: white;
            border-radius: 12px;
            border: none;
        }

        .dashboard-btn:hover {
            opacity: 0.9;
            color: white;
        }

        .kpi-card {
            background: linear-gradient(135deg, rgb(240, 29, 29), #a06bff);
            color: white;
            border-radius: 20px;
            padding: 25px;
            min-height: 180px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .kpi-title {
            font-size: 13px;
            letter-spacing: 1px;
            opacity: 0.85;
        }

        .kpi-number {
            font-size: 36px;
            font-weight: 700;
        }

        .dashboard-card {
            border-radius: 18px;
            background: linear-gradient(135deg, rgb(240, 29, 29), #9f6aff) !important;
            color: white;
        }

        .card-header {
            background: linear-gradient(135deg, rgb(240, 29, 29), #9f6aff) !important;
            color: white;
            border-top-left-radius: 18px;
            border-top-right-radius: 18px;
        }

        .dashboard-card .card-body {
            background: white;
            color: #333;
            border-radius: 18px;
        }

        .role-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            color: white;
        }

        .role-admin {
            background: #28a745;
        }

        .role-editor {
            background: #17a2b8;
        }

        .role-superadmin {
            background: #6f42c1;
        }

        .stats-pill {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            color: white;
            display: inline-block;
            margin-right: 5px;
        }

        .pill-views {
            background: #0dcaf0;
        }

        .pill-likes {
            background: #dc3545;
        }

        .pill-comments {
            background: #ffc107;
            color: #000;
        }

        .pill-shares {
            background: #198754;
        }

        .platform-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            color: white;
        }

        .badge-ig {
            background: linear-gradient(135deg, #fd1d1d, #833ab4);
        }

        .badge-tt {
            background: #000;
        }

        .stats-wrapper {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .stat-pill {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            color: white;
        }

        .stat-views {
            background: #0dcaf0;
        }

        .stat-likes {
            background: #dc3545;
        }

        .stat-comments {
            background: #ffc107;
            color: #000;
        }

        .stat-shares {
            background: #198754;
        }

        .user-stat-wrapper {
            display: flex;
            flex-direction: column;
            gap: 2px;
            /* lebih tight */
        }

        .user-stat-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            /* lebih kecil */
            font-weight: 500;
        }

        .user-stat-item i {
            font-size: 12px;
            opacity: 0.7;
        }

        .stat-view {
            color: #6c757d;
            /* muted grey */
        }

        .stat-like {
            color: #dc3545;
        }
    </style>