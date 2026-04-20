<!-- Date-range picker css -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bower_components/bootstrap-daterangepicker/css/daterangepicker.css" />
<!-- SweetAlert2 -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<!-- Fancybox -->
<link rel="stylesheet" href="<?= base_url() ?>assets/fancybox/jquery.fancybox.min.css" />
<style>
    #modal_add_berkas { overflow-y: scroll; }
    li { list-style: inherit; }
    ul { padding: 0; margin: 1rem; }

    /* === Fix Modal Add Inventory === */

    /* Modal body scrollable */
    #modal_add .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }

    /* Spacing antar form-group rows */
    #modal_add .form-group {
        margin-bottom: 1rem;
    }

    /* Border pada semua form controls */
    #modal_add .form-control {
        border: 1px solid #ced4da;
        border-radius: 6px;
    }

    /* Border pada Select2 containers */
    #modal_add .select2-container--default .select2-selection--single,
    #modal_add .select2-container--default .select2-selection--multiple {
        border: 1px solid #ced4da;
        border-radius: 6px;
        min-height: 38px;
    }

    /* Vertical alignment arrow untuk single select */
    #modal_add .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
    }
    #modal_add .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }

    /* Designation dropdown results list lebih tinggi agar mudah di-scroll */
    #modal_add .select2-results__options {
        max-height: 280px;
    }
</style>