    <link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet">
    <!-- button export -->
    <link rel="stylesheet" href="<?= base_url('assets/data-table/css/buttons.dataTables.min.css') ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.css" />


    <style>

        /* Memastikan dropdown SlimSelect selalu tampil paling depan di atas Modal Bootstrap */
.ss-content {
    z-index: 99999 !important;
}

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

    .ss-content .form-control .border-start-0 .ss-open-below {
        width: 500px;
    }

    a.dt-button.biru {
        border: 1px solid #00C2FF;
        color: #fff;
        background-color: #00C2FF;
        background-image: -webkit-linear-gradient(top, #00C2FF 0%, #00C2FF 100%);
        background-image: linear-gradient(to bottom, #00C2FF 0%, #00C2FF 100%);
    }

    a.dt-button.hijau {
        border: 1px solid #91C300;
        color: #fff;
        background-color: #91C300;
        background-image: -webkit-linear-gradient(top, #91C300 0%, #91C300 100%);
        background-image: linear-gradient(to bottom, #91C300 0%, #91C300 100%);
    }





    </style>