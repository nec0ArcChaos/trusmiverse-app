<!-- button export -->
<link rel="stylesheet" href="<?= base_url('assets/data-table/css/buttons.dataTables.min.css') ?>">
<link rel="stylesheet" href="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/fontawesome/css/all.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/scss/custom_button.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/scss/custom_input.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/dragula/dragula.min.css" />
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
<!-- Fancybox untuk preview file/image -->
<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.1/dist/fancybox/fancybox.css" />



<style>
    /* Tabs */
    .windoor-tabs .nav-link {
        font-size: 14px;
        padding: 8px 14px;
        color: #6c757d;
        border: none;
    }

    .windoor-tabs .nav-link.active {
        font-weight: 600;
        color: #0d6efd;
        border-bottom: 2px solid #0d6efd;
        background: none;
    }

    /* Kanban */
    .kanban-wrapper {
        display: flex;
        overflow-x: auto;
        padding-bottom: 20px;
        gap: 15px;

        /* Agar scroll di HP mulus */
        -webkit-overflow-scrolling: touch;

        /* (Opsional) Snap effect agar kartu berhenti pas di tengah saat di-swipe */
        scroll-snap-type: x mandatory;
    }

    .kanban-col {
        /* Desktop: Lebar fix agar tidak gepeng */
        min-width: 320px;
        width: 320px;
        flex-shrink: 0;
        /* Mencegah kolom mengecil */
        scroll-snap-align: start;
        /* Snap position */
    }

    .kanban-body {
        min-height: 300px;
        max-height: 70vh;
        overflow-y: auto;
        border: 1px solid #f1f1f1;
        border-radius: 10px;
        padding: 10px;
        background: white;
    }

    .kanban-title {
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .bg-light-pending {
        background: #fff4f4;
    }

    .bg-light-progress {
        background: #fff8e6;
    }

    .bg-light-review {
        background: #fff3e6;
    }

    .bg-light-complete {
        background: #e9f5ff;
    }

    .kanban-card {
        background: #fff;
        border-radius: 14px;
        padding: 14px;
        border: 1px solid #f0f0f0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        margin-bottom: 12px;
        cursor: grab;
    }

    .kanban-count {
        background: #ff4d4d;
        color: #fff;
        font-size: 11px;
        border-radius: 50%;
        padding: 2px 7px;
        margin-left: 4px;
        font-weight: 600;
    }


    .badge-event {
        background: #ffe8d0;
        color: #d38300;
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 6px;
    }

    .campaignList {
        display: grid;
        /* Default Desktop: 3 Kolom */
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .campaign-card {
        border-radius: 14px;
        border: 1px solid #e9e9e9;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        width: 100%;
        height: 100%;
        /* Agar tinggi kartu seragam */
        background: #fff;
    }

    .event-label {
        background: #C9EBFB;
        color: #015EC2;
        font-size: 10px;
        padding: 4px 10px;
        border-radius: 8px;
        font-weight: 600;
    }

    .campaign-icon {
        font-size: 18px;
        cursor: pointer;
        color: #a5a5a5;
    }

    .label-gray {
        color: #7b7b7b;
        font-size: 12px;
        font-weight: 500;
    }

    .priority-badge {
        font-size: 11px;
        background: #ffe5e5;
        color: #c0392b;
        padding: 3px 10px;
        border-radius: 10px;
        font-weight: 600;
    }

    .pic-avatar {
        width: 26px;
        height: 26px;
        max-width: 26px !important;
        border-radius: 50%;
        border: 2px solid #fff;
        object-fit: cover;
        margin-left: -5px;
        box-shadow: 0 0 0 1px #e0e0e0;
    }

    .avatar-more {
        width: 26px;
        height: 26px;
        background: #eaf1ff;
        color: #476bb6;
        font-size: 12px;
        border-radius: 50%;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #fff;
        margin-left: -5px;
    }

    .custom-progress {
        width: 100%;
        height: 8px;
        border-radius: 6px;
        background: #f0f4ff;
    }

    .custom-progress .progress-bar {
        background: #3282f6;
        border-radius: 6px;
    }

    .desc-box {
        border: 1px solid #e8e8e8;
        border-radius: 10px;
        background: #f8f9fb;
        max-height: 100px;
        overflow-y: auto;
    }

    #fd_description,
    #r_description,
    #rv_description,
    #s_description,
    #rvs_description,
    #k_description,
    #rvk_description,
    #bg_description,
    #rvb_hist_description,
    #rv_riset_report,
    #rv_trend_analysis,
    #h_script_riset_report,
    #h_script_trend_analysis,
    #k_riset_report,
    #k_trend_analysis,
    #k_naskah_final,
    #rvk_hist_riset_report,
    #rvk_hist_trend,
    #bg_riset_report,
    #bg_trend_analysis,
    #bg_naskah_final,
    #rvb_riset_report,
    #rvb_trend_analysis,
    #rvb_naskah_final,
    #shooting_riset_report,
    #shooting_trend_analysis,
    #shooting_naskah_final,
    #rv_shooting_riset_report,
    #rv_shooting_trend_analysis,
    #rv_shooting_hist_description,
    #rv_shooting_naskah_final {
        border: 1px solid #e8e8e8;
        border-radius: 10px;
        background: #f8f9fb;
        max-height: 200px;
        overflow-y: auto;
        padding: 12px;
    }

    /* Container teks panjang (read-only) */
    .fd-textbox {
        border: 1px solid #e8e8e8;
        border-radius: 10px;
        background: #f8f9fb;
        max-height: 120px;
        overflow-y: auto;
        padding: 12px;
        font-size: 0.85rem;
        line-height: 1.5;
    }

    /* Khusus konten besar */
    .fd-textbox.lg {
        max-height: 200px;
    }


    .kanban-desc {
        max-height: 100px;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 8px;
    }

    .desc-text {
        font-size: 12px;
        color: #6b6b6b;
        margin: 0;
    }



    .badge-priority {
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-high {
        background: #ffe6e6;
        color: #c62828;
    }

    .badge-medium {
        background: #fff4d6;
        color: #bf8100;
    }

    .badge-low {
        background: #e6f5ff;
        color: #0077c2;
    }

    .modal-campaign {
        border-radius: 20px;
        padding: 20px 20px 10px;
    }

    .campaign-title-input {
        border: none;
        font-size: 22px;
        font-weight: 600;
        padding-left: 0;
    }

    .campaign-title-input::placeholder {
        color: #D0D0D0;
    }

    .grey-input {
        border: 1px solid #eaeaea;
        border-radius: 10px;
        cursor: pointer;
        color: #a0a0a0;
        font-size: 14px;
        display: flex;
        align-items: center;
    }

    .grey-input:hover {
        border-color: #cfcfcf;
    }

    .btn-outline-cust {
        background: #F9FAFB;
        border: 1px solid #E5E7EB;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        color: #4B5563;
    }

    .attach-link-box {
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1px dashed #dcdcdc;
        padding: 10px;
        border-radius: 10px;
    }

    .attach-file-box {
        background: #F8F9FB;
        border: 1px solid #e0e0e0;
        padding: 8px 12px;
        border-radius: 10px;
    }

    .upload-box {
        border: 1px dashed #cfd8e0;
        border-radius: 10px;
        background: #fafbfc;
        cursor: pointer;
    }

    .upload-box:hover {
        border-color: #a6b4c2;
    }

    .priority-item {
        display: block;
        padding: 6px;
        cursor: pointer;
        border-radius: 6px;
        font-size: 14px;
    }

    .priority-item:hover {
        background: #eef5ff;
    }

    /* Pastikan dropdown tampil di atas Modal Bootstrap */
    .ss-content {
        z-index: 1060 !important;
        /* Harus > 1055 (z-index modal bootstrap) */
    }

    /* Opsional: Memperbaiki tampilan input container agar selaras */
    .ss-main {
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        /* Sesuaikan dengan style bootstrap form-control-sm */
        padding: 2px;
        /* Sesuaikan padding */
    }

    .fancybox__container {
        z-index: 999999 !important;
    }

    .form-control-sm {
        border: 1px solid rgba(52, 49, 49, 0.68);
        border-radius: 5px;
    }

    ::-webkit-scrollbar {
        height: 10px !important;
    }

    /* responsive */
    /* Tampilan Mobile Khusus (< 768px) */
    @media (max-width: 768px) {
        .kanban-col {
            /* Di HP, kolom mengambil 85% lebar layar agar user tahu ada kolom lain di sebelahnya */
            min-width: 85vw;
            width: 85vw;
        }
    }

    /* Tablet (max-width 992px): 2 Kolom */
    @media (max-width: 992px) {
        .campaignList {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Mobile (max-width 576px): 1 Kolom */
    @media (max-width: 576px) {
        .campaignList {
            grid-template-columns: 1fr;
        }

        /* Penyesuaian margin di HP */
        .campaign-card {
            margin-bottom: 15px;
        }
    }
</style>
<style>
    .custom-loader-overlay {
        position: relative;
    }

    .custom-loader-overlay.with-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.35);
        backdrop-filter: blur(3px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2000;
    }

    /* Loader box */
    .custom-loader-box {
        background: #fff;
        padding: 20px 28px;
        border-radius: 12px;
        min-width: 150px;
    }

    /* Dot loader */
    .loading-dots span {
        animation: blink 1.4s infinite both;
        font-size: 1.5rem;
    }

    .loading-dots span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .loading-dots span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes blink {
        0% {
            opacity: 0.2;
        }

        50% {
            opacity: 1;
        }

        100% {
            opacity: 0.2;
        }
    }
</style>