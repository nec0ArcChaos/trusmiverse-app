    <link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet">
    <!-- button export -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/scss/custom_button.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/scss/custom_input.css">
    <link rel="stylesheet" href="<?= base_url('assets/data-table/css/buttons.dataTables.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.css" />

    <!-- Select 2 css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/select2/css/select2.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/nice-select2/css/nice-select2.css" />
    </link>
    <style>
        input[type="file"] {
            border: 1px solid #ccc;
            border-radius: 5px;
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
        }
    </style>
    <style>
        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }

        /* Pastikan NiceSelect mengisi ruang kosong di sebelah tombol */
        .input-group .nice-select {
            flex: 1 1 auto;
            width: 80% !important;
            /* Trik agar flexbox bekerja dengan benar */
            min-width: 0;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        /* Rapikan sudut tombol agar menyatu dengan input */
        .input-group .btn {
            z-index: 2;
            /* Agar border tombol terlihat di atas border input */
        }
    </style>