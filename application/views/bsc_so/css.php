    <link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet" />
    <!-- button export -->
    <link rel="stylesheet" href="<?= base_url('assets/data-table/css/buttons.dataTables.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/jquery-confirm/jquery-confirm.min.css') ?>" />

    <!-- Memuat Dropzone.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />
    <style>
        input[type="file"] {
            border: 1px solid #ccc;
            border-radius: 5px;
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
        }

        .filters input {
            width: 100%;
            padding-right: 10px;
            padding-left: 10px;
            padding-top: 3px;
            padding-bottom: 3px;
            box-sizing: border-box;
            border-radius: 5px;
            border: solid 1px #4680FF;
        }

        tfoot {
            display: table-header-group !important;
        }

        /* .input-field {
    padding: 10px;
    font-size: 16px;
    border: 2px solid #3498db;
    border-radius: 4px;
    transition: border-color 0.3s ease;
}

.input-field:focus {
    outline: none;
    border-color: #2ecc71;
    box-shadow: 0 0 5px rgba(46, 204, 113, 0.5);
} */
    </style>