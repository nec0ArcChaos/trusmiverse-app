<!-- date range picker -->
<link rel="stylesheet" href="<?= base_url() ?>assets/compas/main_theme/vendor/daterangepicker/daterangepicker.css">
<style>
    /* Font override if needed, assuming Bootstrap 5 base */
    :root {
        --purple-subtle: #f3e8ff;
        --purple-text: #9333ea;
    }

    .text-purple {
        color: var(--purple-text) !important;
    }

    .bg-purple-subtle {
        background-color: var(--purple-subtle) !important;
    }

    /* Animations */
    .fade-in-up {
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    .animation-delay-1 {
        animation-delay: 0.2s;
    }

    .animation-delay-2 {
        animation-delay: 0.4s;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Base custom styles */
    .mainheight {
        min-height: calc(100vh - 100px);
        background-color: #f8f9fa;
        /* slightly off white */
        padding-top: 1rem;
    }

    .top-nav-tabs .nav-link.active,
    .top-nav-tabs .btn-nav-tab.active {
        background-color: #ffffff !important;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05) !important;
        color: #212529 !important;
        font-weight: 600 !important;
    }

    .top-nav-tabs .nav-link,
    .top-nav-tabs .btn-nav-tab {
        transition: all 0.2s ease-in-out;
        color: #6c757d;
    }

    /* Hide scrollbar for navs */
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .hide-scrollbar {
        -ms-overflow-style: none;
        /* IE and Edge */
        scrollbar-width: none;
        /* Firefox */
    }

    /* Hero Banner Gradient */
    .hero-banner {
        background-color: #ffffff;
        border: 1px solid #e9ecef !important;
    }

    .hero-bg-gradient {
        /* Create a smooth blurred liquid gradient overlay */
        background: radial-gradient(circle at 75% 50%, rgba(13, 110, 253, 0.2) 0%, rgba(13, 110, 253, 0.05) 30%, transparent 60%);
        z-index: 0;
    }

    /* Metric Cards */
    .metric-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
    }

    .metric-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08) !important;
    }

    /* Table Tabs */
    .table-nav-tabs .btn-light {
        background-color: #f8f9fa;
        border: 1px solid transparent;
    }

    .table-nav-tabs .btn-light:hover {
        background-color: #e9ecef;
    }

    /* Custom Table */
    .custom-table th {
        font-weight: 600;
        color: #6c757d;
        border-bottom: 1px solid #f1f3f5;
    }

    .custom-table td {
        padding: 1.25rem 0.5rem;
        border-bottom: 1px solid #f1f3f5;
        vertical-align: middle;
    }

    .custom-table tbody tr {
        transition: background-color 0.2s;
    }

    .custom-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    /* Ensure placeholder styling */
    .form-control::placeholder {
        color: #adb5bd;
    }

    /* Skeleton Loading */
    .skeleton-text {
        background: #e9ecef;
        border-radius: 4px;
        display: inline-block;
        animation: skeleton-blink 1.5s infinite ease-in-out;
    }

    @keyframes skeleton-blink {
        0% {
            opacity: 0.3;
        }

        50% {
            opacity: 0.6;
        }

        100% {
            opacity: 0.3;
        }
    }

    .d-opacity-0 {
        opacity: 0 !important;
    }

    .text-green {
        color: #28a745 !important;
    }

    .text-red {
        color: #dc3545 !important;
    }

    /* Timeline & Schedule Styles */
    .date-card {
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid #e9ecef !important;
    }

    .date-card:hover:not(.active) {
        background-color: #f8f9fa !important;
        color: #0d6efd !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .date-card.active {
        border-color: transparent !important;
        color: #0d6efd;
    }

    .shadow-sm-hover:hover {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        transform: translateY(-1px);
    }

    .last-child-no-border:last-child {
        border-bottom: none !important;
    }

    .timeline-row {
        transition: background-color 0.2s;
    }

    .timeline-row:hover {
        background-color: #fafafa;
    }

    .activity-entry {
        transition: all 0.2s ease;
        border: 1px solid #e9ecef !important;
    }

    .activity-entry:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06) !important;
        background-color: #ffffff !important;
    }

    .transition-all {
        transition: all 0.2s ease-in-out;
    }

    /* Scrollbar customization for timeline */
    .hide-scrollbar::-webkit-scrollbar {
        height: 4px;
    }

    .hide-scrollbar:hover::-webkit-scrollbar-thumb {
        background: #dee2e6;
        border-radius: 10px;
    }

    /* Skeleton Loader */
    .skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: skeleton-loading 1.5s infinite;
        border-radius: 4px;
    }

    @keyframes skeleton-loading {
        0% {
            background-position: 200% 0;
        }

        100% {
            background-position: -200% 0;
        }
    }

    /* Animations */
    .fadeInUp {
        animation: fadeInUp 0.4s ease-out forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .time-marker-dot {
        position: absolute;
        right: -6px;
        top: 50%;
        transform: translateY(-50%);
        width: 12px;
        height: 12px;
        background-color: #ffffff;
        border: 3px solid #0d6efd;
        border-radius: 50%;
        z-index: 2;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
    }

    .activity-container {
        position: relative;
        z-index: 1;
    }

    .activity-entry {
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid #f1f3f5 !important;
    }

    .activity-entry:hover {
        transform: translateX(5px);
        background-color: #ffffff !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
    }

    .badge-primary-subtle {
        background-color: #e7f1ff;
        color: #0d6efd;
    }

    .badge-success-subtle {
        background-color: #e1f5ea;
        color: #198754;
    }

    .badge-info-subtle {
        background-color: #e0f7fa;
        color: #0dcaf0;
    }

    .badge-warning-subtle {
        background-color: #fff9e6;
        color: #ffc107;
    }

    .badge-danger-subtle {
        background-color: #fce8e8;
        color: #dc3545;
    }

    .border-blue {
        --bs-border-opacity: 1;
        border-color: rgba(var(--bs-primary-rgb), var(--bs-bg-opacity)) !important;
    }

    .border-orange {
        --bs-border-opacity: 1;
        border-color: rgba(255, 165, 0, var(--bs-bg-opacity)) !important;
    }

    .border-yellow {
        --bs-border-opacity: 1;
        border-color: rgba(255, 255, 0, var(--bs-bg-opacity)) !important;
    }

    .border-green {
        --bs-border-opacity: 1;
        border-color: rgba(40, 167, 69, var(--bs-bg-opacity)) !important;
    }

    .border-teal {
        --bs-border-opacity: 1;
        border-color: rgba(32, 201, 151, var(--bs-bg-opacity)) !important;
    }
</style>