<link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet">
<!-- button export -->
<link rel="stylesheet" href="<?= base_url('assets/data-table/css/buttons.dataTables.min.css') ?>">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/nice-select2/css/nice-select2.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/nice-select2/css/nice-select2.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/fontawesome/css/all.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/scss/custom_button.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/scss/custom_input.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/nice-select2/css/nice-select2.css" />
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<style>
    .group:hover .group-hover\:opacity-100 {
        opacity: 1 !important;
    }
    .section { display: none; }
    .section.active { display: block; }
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>


<style>
    :root {
        /* Diperbarui: Latar belakang lebih putih (kurang transparan) */
        --glass-bg: rgba(255, 255, 255, 0.3);
        --glass-border-color-start: #ffffff;
        /* Warna awal gradasi (putih) */
        --glass-border-color-end: #a0a0a0;
        /* Warna akhir gradasi (abu-abu) */
        --text-color: #333;
        /* Warna teks diubah agar lebih kontras di atas bg putih */
    }

    .main.mainheight {
        position: relative;
        min-height: 100vh;
        /* supaya memenuhi layar */
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    .main.mainheight::before {
        content: "";
        position: absolute;
        inset: 0;
        /* top, right, bottom, left = 0 */
        background: url("<?= base_url('assets/img/bg-gradient.png'); ?>") center/cover no-repeat;
        opacity: 1;
        /* transparansi */
        filter: blur(5px);
        /* efek blur */
        z-index: -1;
        /* letakkan di belakang konten */
    }

    .glass-card {
        position: relative;
        background: var(--glass-bg) !important;
        /* backdrop-filter: blur(5px); */
        -webkit-backdrop-filter: blur(5px);
        border-radius: 10px;
        padding: 20px;
        color: var(--text-color);
        border: 3px solid rgba(255, 255, 255, 0.5);
        /* Border dibuat sedikit lebih terlihat */
        box-shadow: 0 1px 7px rgba(0, 0, 0, 0.1);

        /* Transisi yang diperbarui untuk hover yang mulus */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        z-index: 1;
        /* Pastikan kartu berada di atas pseudo-element */
    }
    .bg-glass {
        background: var(--glass-bg) !important;
    }
    .bg-glass:hover {
        background: rgba(255, 255, 255, 0.45) !important;
    }
    .w-12 {
        width:3rem !important;
    }
    .w-10 {
        width:2.5rem !important;
    }
    .w-200px {
        width:200px !important;
    }


    /* --- EFEK HOVER YANG SESUAI --- */
    .glass-card:hover {
        background-color: rgba(255, 255, 255, 0.45) !important;
        /* Bayangan yang lebih menonjol dan memberikan efek 'glow' */
        box-shadow: 0 5px 5px rgba(0, 0, 0, 0.1),
        0 0 10px rgba(255, 255, 255, 0.1);
    }


    .negative-kpi {
        color: #ff6b6b;
    }

    .positive-kpi {
        color: #51cf66;
    }

    .custom-list {
        list-style-type: none;
        /* Menghilangkan bullet point */
        padding-left: 0;
        /* Menghilangkan padding kiri default */
    }

    @keyframes pulse-fade {
        0% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: 0.3;
            transform: scale(1.3);
        }

        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Terapkan animasi ke ikon dengan class khusus */
    .loading-icon-pulse {
        animation: pulse-fade 1.5s ease-in-out infinite;
        display: inline-block;
    }

    .kesehatan-kpi {
        max-height: 260px;
        overflow-y: auto;
    }
</style>
<style>
  /* star states */
  #starsContainer .star svg { color: #cbd5e1; } /* default gray */
  #starsContainer .star.filled svg { color: #f6ad55; } /* amber */
  #starsContainer .star { background: transparent; border: none; cursor: pointer; }
  #starsContainer .star:focus { outline: 2px solid rgba(99,102,241,0.25); outline-offset: 2px; }
</style>
<style>
    /* body {
        font-family: 'Inter', sans-serif;
        background-color: #f7f9fc;
    } */
    /* Style for the modal overlay and content */
    #article-modal.modal-overlay {
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 50; /* Above all other content */
    }
    .article-card:hover {
        cursor: pointer;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    /* Custom scrollbar for modal content */
    #article-modal .modal-content-scroll::-webkit-scrollbar {
        width: 8px;
    }
    #article-modal .modal-content-scroll::-webkit-scrollbar-thumb {
        background-color: #9ca3af;
        border-radius: 10px;
    }
    #article-modal .modal-content-scroll::-webkit-scrollbar-track {
        background-color: #e5e7eb;
    }
</style>
<style>
    /* Custom scrollbar for a cleaner look */
    #add-article-page .editor-container::-webkit-scrollbar {
        width: 8px;
    }
    #add-article-page .editor-container::-webkit-scrollbar-thumb {
        background: #d1d5db; /* gray-300 */
        border-radius: 4px;
    }
    #add-article-page .editor-container::-webkit-scrollbar-track {
        background: #f3f4f6; /* gray-100 */
    }
    
    /* Style for contenteditable focus */
    #add-article-page [contenteditable]:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5); /* ring-2 blue-500 */
        background-color: #fff;
    }

    /* Input field focus style */
    #add-article-page .modal-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 1px #3b82f6;
    }

    /* Custom styling for continuous article flow */
    #add-article-page .column-container {
        min-height: 100px;
    }
    
</style>