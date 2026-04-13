<link rel="stylesheet" href="<?= base_url('assets/vendor/dropzone5-9-3/dropzone.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/vendor/footable/footable.bootstrap.min.css') ?>">

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

    .kanban-body.is-hovered {
        background-color: rgba(173, 216, 230, 0.5) !important;
        box-shadow: 0px 2px 2px 2px rgba(211, 211, 211, 0.5) !important;
        transition: background-color 0.5s ease;
    }

    .kanban-body:not(.is-hovered) {
        transition: background-color 0.5s ease, box-shadow 0.5s ease;
    }

    .dragzonecard {
        min-height: 300px;
        margin-bottom: 20px;
    }

    .dragzonecard>div {
        cursor: move;
        cursor: grab;
        cursor: -webkit-grab;
    }

</style>

<style>
    .detail_tabs li:hover {
        background-color: #f0f0f0 !important;
    }

    .detail_tabs li:hover a {
        color: #007bff !important; 
    }

    /* @media (max-width: 512px) {
        .status_img {
            max-width: 30% !important;
            height: auto;
        }
    } */


    .center-spinner {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 50vh; /* Set the height of the container */
    }


    /* .progress-bar {
      transition: width 0.5s ease-in-out;
    } */


    .spinner_upload{
        width: 20px !important;
        height: 20px !important;
    }

    .paging-nav {
        text-align: right;
        padding-top: 2px;
    }

    .paging-nav a {
        margin: auto 1px;
        text-decoration: none;
        display: inline-block;
        padding: 1px 7px;
        background: #91b9e6;
        color: white;
        border-radius: 3px;
    }

    .paging-nav .selected-page {
        background: #187ed5;
        font-weight: bold;
    }


</style>