    <link href="<?= base_url(); ?>assets/nice-select2/css/nice-select2.css" rel="stylesheet">
    <!-- button export -->
    <link rel="stylesheet" href="<?= base_url('assets/data-table/css/buttons.dataTables.min.css') ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
    <link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/font_awesome/css/all.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/clockpicker/jquery-clockpicker.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/jquery-confirm/jquery-confirm.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.min.css" />

    <!-- Fomantic Ui Or Semantic Ui -->
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/dropdown.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/transition.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/form.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/button.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/input.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/label.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/icon.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/loader.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/popup.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/toast.css">
    <!-- CSS Custom -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />


    <style>
        .custom-style-sm .current {
            display: flex;
            overflow-x: hidden;
            max-width: 150px;
        }

        .f-custom {
            font-size: 7pt;
        }



        @media only screen and (max-width: 767px) {
            .custom-style .current {
                max-width: 400px;
            }

            .custom-style-sm .current {
                display: flex;
                overflow-x: hidden;
                max-width: 150px;
            }

        }

        @media only screen and (max-width: 480px) {

            /* smartphones, iPhone, portrait 480x320 phones */
            .custom-style .current {
                max-width: 200px;
            }

            .custom-style-sm .current {
                display: flex;
                overflow-x: hidden;
                max-width: 150px;
            }
        }
    </style>
    <!-- /CSS Custom -->

    <style>
        /* 
        .ss-arrow{
            display: none !important;
        }
 */


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


        /* .m-buttons__btn:focus, */

        .popover {
            z-index: 3010 !important;
        }

        .mt-4-5 {
            margin-top: 1.7rem;
        }

        .w-90 {
            width: 95% !important;
        }

        .required:after {
            content: " *";
            color: red;
        }
    </style>