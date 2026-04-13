    <link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet">
    <!-- button export -->
    <link rel="stylesheet" href="<?= base_url('assets/data-table/css/buttons.dataTables.min.css') ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
    <link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?= base_url('assets/clockpicker/jquery-clockpicker.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/jquery-confirm/jquery-confirm.min.css') ?>">


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
        

        /*.m-buttons__btn:focus,*/
        .btn:hover {
            transform: translateY(1px);
        }

        /*.btn:focus:before,*/
        .btn:hover:before {
            transform: translateY(-1px);
        }

        .btn:active {
            transform: translateY(5px);
            transition: none;
        }

        .btn:active:before {
            transform: translateY(-5px);
            transition: none;
        }

        .btn,
        .btn:before,
        .btn:after {
            transition: all 0.5s cubic-bezier(0, 1, 0.2, 1);
        }


        .popover{
            z-index: 3010 !important;
        }

        
        
.modal {
    z-index: 10599 !important; /* lebih tinggi dari DataTables buttons */
}
.modal-backdrop {
    z-index: 10598 !important;
}
.dt-button-collection {
    z-index: 10597 !important; /* agar dropdown buttons tetap di bawah modal */
}
.modal-body {
    max-height: 70vh; /* sesuaikan tinggi modal */
    overflow-y: auto;
}



    </style>