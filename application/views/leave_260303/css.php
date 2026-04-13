<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/scss/custom_button.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/scss/custom_input.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/nice-select2/css/nice-select2.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/data-table/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/fontawesome/css/all.min.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.min.css" />


<style>
    /* page level style */
    /* .less {
        overflow: hidden;
        height: 3em;
    } */

    .text-dinamis {
        font-size: 10pt;
    }

    .custom-style .current {
        max-width: 600px;
        display: inline-block;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }

    .custom-style-sm .current {
        max-width: 200px;
        display: inline-block;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }

    @media only screen and (max-width: 767px) {
        .custom-style .current {
            max-width: 400px;
        }

        .custom-style-sm .current {
            max-width: 200px;
        }
    }

    @media only screen and (max-width: 480px) {

        /* smartphones, iPhone, portrait 480x320 phones */
        .custom-style .current {
            max-width: 200px;
        }

        .custom-style-sm .current {
            max-width: 100px;
        }

        .text-dinamis {
            font-size: 8pt;
        }
    }

    /* 
    .dt-buttons {
        display: none;
    }

    .dataTables_filter {
        display: none;
    } */
</style>