<link rel="stylesheet" href="<?= base_url('assets/vendor/dragula/dragula.min.css') ?>"/>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/scss/custom_button.css') ?>"/>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/scss/custom_input.css') ?>"/>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/data-table/css/buttons.dataTables.min.css') ?>"/>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/fontawesome/css/all.min.css') ?>"/>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/vendor/datetimepicker/jquery.datetimepicker.min.css') ?>"/>
<link rel="stylesheet" href="<?= base_url('assets/font_awesome/css/all.min.css') ?>"/>

<style>

    .kanban-header {
        padding: 0px 10px 0px 10px !important;
    }

    .kanban-header-not-started {
        background-color: #c4c4c4 !important;
        color: white !important;
    }

    .kanban-header-working-on {
        background-color: #fdab3d !important;
        color: white !important;
    }

    .kanban-header-done {
        background-color: #00c875 !important;
        color: white !important;
    }

    .kanban-header-stuck {
        background-color: #e2445c !important;
        color: white !important;
    }

    .kanban-body {
        background-color: #f6f7fb !important;
        min-height: 300px !important;
    }
    
    .dark-mode .kanban-body {
        background-color: #000a12 !important;
        min-height: 300px !important;
    }

    .kanban-body.is-hovered {
        background-color: rgba(173, 216, 230, 0.5) !important;
        box-shadow: 0px 2px 2px 2px rgba(211, 211, 211, 0.5) !important;
        transition: background-color 0.5s ease;
    }
    
    .dark-mode .kanban-body.is-hovered {
        background-color: rgba(25, 25, 25, 0.5) !important;
        box-shadow: 0px 2px 2px 2px rgba(50, 50, 50, 0.5) !important;
        transition: background-color 0.5s ease;
        color: #fff; /* Set text color to white or another light color for better visibility */
    }

    .kanban-body:not(.is-hovered) {
        transition: background-color 0.5s ease, box-shadow 0.5s ease;
    }

    .dark-mode .kanban_due_date{
        color: white;
    }







    .dragzonecard {
        min-height: 300px;
    }

    .dragzonecard>div {
        cursor: move;
        cursor: grab;
        cursor: -webkit-grab;
    }

</style>

<?php $this->load->view('monday/details/css'); ?>
<?php $this->load->view('kanban/details/css'); ?>