<link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url(); ?>assets/scss/custom_button.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/scss/custom_input.css">

<style>
    .form-floating > label {
        z-index: 1;
    }

    .ss-main {
        min-height: 58px;
        border-radius: 0 0.375rem 0.375rem 0;
    }

    .input-group-lg .ss-main {
        padding: 0.5rem 0.75rem;
    }

    .border-custom {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
    }

    #form_add_dokumen label {
        font-weight: 500;
    }

    /* Smooth horizontal slide-in untuk No. Dokumen.
       Default: lebar 0 → Priority menempel di sebelah Categori.
       .show: lebar normal col-md-4 → Priority otomatis ter-dorong ke kanan. */
    #wrap_no_dokumen {
        overflow: hidden;
        opacity: 0;
        width: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-bottom: 0 !important;
        transition:
            width 0.4s cubic-bezier(0.4, 0, 0.2, 1),
            opacity 0.3s ease 0.1s,
            padding 0.4s cubic-bezier(0.4, 0, 0.2, 1),
            margin 0.4s ease;
    }

    /* Jaga agar konten di dalam wrap tidak ikut "mengecil" saat lebar = 0,
       sehingga tidak ada reflow internal — hanya wrap-nya saja yang clip. */
    #wrap_no_dokumen > .form-group {
        min-width: 280px;
    }

    #wrap_no_dokumen.show {
        opacity: 1;
        padding-left: calc(var(--bs-gutter-x) * 0.5) !important;
        padding-right: calc(var(--bs-gutter-x) * 0.5) !important;
        margin-bottom: 0.5rem !important;
    }

    /* Lebar target sesuai breakpoint (menyamai col-6 / col-md-4) */
    @media (max-width: 767.98px) {
        #wrap_no_dokumen.show {
            width: 50% !important;
        }
    }

    @media (min-width: 768px) {
        #wrap_no_dokumen.show {
            width: 33.33333% !important;
        }
    }

    /* Priority juga dikasih transition halus agar pergeseran horizontal-nya terasa */
    .col-priority {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ===== Tab navigation tweak ===== */
    #jpTab .nav-link {
        color: #6c757d;
        font-weight: 500;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 0.5rem 1rem;
    }

    #jpTab .nav-link:hover {
        color: var(--bs-primary);
        border-bottom-color: rgba(var(--bs-primary-rgb), 0.3);
    }

    #jpTab .nav-link.active {
        color: var(--bs-primary);
        background: transparent;
        border-bottom-color: var(--bs-primary);
    }

    /* Pastikan TinyMCE editor tidak terlalu mepet di tab */
    #content-pane .tox-tinymce {
        border-radius: 0.375rem;
    }
</style>
