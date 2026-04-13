<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/scss/custom_button.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/scss/custom_input.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/data-table/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.min.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/nice-select2/css/nice-select2.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/dropzone5-9-3/dropzone.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/dragula/dragula.min.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/font_awesome/css/all.min.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/slimselect/slimselect.css">
<link rel="stylesheet" href="https://unpkg.com/tippy.js@6/animations/scale.css" />

<style>
    .form-control {
        display: block;
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: 0.25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    #body_get_comment,
    p {
        margin: 0px;
    }

    .btn-monday {
        background-color: rgba(var(--WinDOORS-theme-rgb), 0.1);
        border-radius: 5px;
    }

    .dark-mode .modal-content {
        background: rgba(var(--WinDOORS-theme-bg-rgb), 0.8) !important;
    }

    .dark-mode .nice-select-dropdown {
        background-color: rgba(var(--WinDOORS-theme-bg-rgb), 1);
        border: 2px solid white;
        padding: 2px
    }

    .dark-mode .nice-select-search {
        background-color: black;
        color: white;
    }

    .dark-mode .note-editing-area {
        background: black;
        color: white;
    }

    .dark-mode .nice-select .option:hover,
    .dark-mode .nice-select .option.focus,
    .dark-mode .nice-select .option.selected.focus {
        background-color: black;
    }

    .dark-mode .nice-select {
        background-color: black;
    }

    .dark-mode .ss-multi-selected {
        background-color: black;
    }

    .dark-mode .ss-content {
        background-color: black;
    }

    .dark-mode .ss-disabled {
        background-color: black;
    }

    .dark-mode .ss-option-selected {
        --bs-bg-opacity: 1;
        background-color: rgba(var(--bs-dark-rgb), var(--bs-bg-opacity)) !important;
    }

    select optgroup {
        margin-left: 5px;
    }

    .optgroup {
        margin-left: 5px;
    }

    .mt-4-5 {
        margin-top: 1.7rem;
    }

    .w-90 {
        width: 95% !important;
    }

    .monday-breadcrumb-item+.monday-breadcrumb-item {
        padding-left: var(--bs-breadcrumb-item-padding-x);
    }

    .monday-breadcrumb-item+.monday-breadcrumb-item::after {
        float: left;
        padding-right: var(--bs-breadcrumb-item-padding-x);
        color: var(--bs-breadcrumb-divider-color);
        content: '|';
    }

    .monday-item::before {
        content: '';
        display: block;
        width: 0;
        height: 2px;
        border-bottom: solid 2px #015EC2;
        border-radius: 1px;
        margin-bottom: 1px;
        transition: width .2s ease-in;
    }

    .monday-item:hover::before {
        width: 100%;
    }

    .monday-active {
        background-color: rgba(var(--WinDOORS-theme-rgb), 0.1);
    }

    .monday-hover {
        background-color: rgba(var(--WinDOORS-theme-rgb), 0.1);
        border-radius: 5px;
    }

    .dark-mode .jconfirm-box {
        background-color: rgba(var(--WinDOORS-theme-bg-rgb), 1) !important;
        color: white !important;
    }

    .dark-mode .jconfirm-title-c {
        color: white !important;
    }

    .dark-mode .jconfirm-content {
        color: white !important;
    }
</style>

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
        min-height: 200px;
        margin-bottom: 20px;
    }

    .dragzonecard>div {
        cursor: move;
        cursor: grab;
        cursor: pointer;
        cursor: -webkit-grab;
    }


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
        height: 50vh;
        /* Set the height of the container */
    }


    /* .progress-bar {
      transition: width 0.5s ease-in-out;
    } */


    .spinner_upload {
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

<style>
    @media screen and (min-width: 1000px) {}

    /* .modal-dialog {
        margin-right: 0 !important;
        margin-top: 0 !important;
    } */

    .modal.show.modal-right .modal-dialog {
        transform: none;
    }

    .datetimepicker {
        z-index: 1060;
    }

    .modal.right .modal-dialog {
        transform: translate(125%, 0px);
        margin-right: 0 !important;
        margin-top: 0 !important;
        position: relative;
        width: 320px;
        height: 100%;
        /* -webkit-transform: translate3d(0%, 0, 0);
        -ms-transform: translate3d(0%, 0, 0);
        -o-transform: translate3d(0%, 0, 0);
        transform: translate3d(0%, 0, 0); */
    }

    .modal.right .modal-content {
        height: 100%;
        overflow-y: auto;
    }

    /* .modal.right.fade .modal-dialog {
        -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
        -o-transition: opacity 0.3s linear, right 0.3s ease-out;
        transition: opacity 0.3s linear, right 0.3s ease-out;
    }

    .modal.right.fade.in .modal-dialog {
        right: 0;
    } */

    .text-turncate-custom {
        max-width: 200px;
    }

    .th-goals {
        min-width: 300px;
        max-width: 300px;
    }
</style>

<style>
    @media (min-width: 768px) {
        .animate {
            animation-duration: 0.5s;
            -webkit-animation-duration: 0.5s;
            animation-fill-mode: both;
            -webkit-animation-fill-mode: both;
        }
    }

    @keyframes slideIn {
        0% {
            transform: translateY(1rem);
            opacity: 0;
        }

        100% {
            transform: translateY(0rem);
            opacity: 1;
        }

        0% {
            transform: translateY(1rem);
            opacity: 0;
        }
    }

    @-webkit-keyframes slideIn {
        0% {
            -webkit-transform: transform;
            -webkit-opacity: 0;
        }

        100% {
            -webkit-transform: translateY(0);
            -webkit-opacity: 1;
        }

        0% {
            -webkit-transform: translateY(1rem);
            -webkit-opacity: 0;
        }
    }

    .slideIn {
        -webkit-animation-name: slideIn;
        animation-name: slideIn;
    }


    .monday-breadcrumb-item+.monday-breadcrumb-item {
        padding-left: var(--bs-breadcrumb-item-padding-x);
    }

    .monday-breadcrumb-item+.monday-breadcrumb-item::after {
        float: left;
        padding-right: var(--bs-breadcrumb-item-padding-x);
        color: var(--bs-breadcrumb-divider-color);
        content: '|';
    }

    .monday-item::before {
        content: '';
        display: block;
        width: 0;
        height: 2px;
        border-bottom: solid 2px #015EC2;
        border-radius: 1px;
        margin-bottom: 1px;
        transition: width .2s ease-in;
    }

    .monday-item:hover::before {
        width: 100%;
    }

    .monday-active {
        background-color: rgba(var(--WinDOORS-theme-rgb), 0.1);
    }

    .monday-hover {
        background-color: rgba(var(--WinDOORS-theme-rgb), 0.1);
        border-radius: 5px;
    }

    @media screen and (max-width: 768px) {
        .text-turncate-custom {
            max-width: 150px;
        }

        .th-goals {
            min-width: 100px;
            max-width: 100px;
        }
    }

    .modal.show.modal-right .modal-dialog {
        transform: none;
    }

    .modal.right .modal-dialog {
        transform: translate(125%, 0px);
        margin-right: 0 !important;
        margin-top: 0 !important;
        position: relative;
        width: 320px;
        height: 100%;
    }

    .modal.right .modal-content {
        height: 100%;
        overflow-y: auto;
    }

    select optgroup {
        margin-left: 5px;
    }

    .optgroup {
        margin-left: 5px;
    }

    .btn-monday {
        background-color: rgba(var(--WinDOORS-theme-rgb), 0.1);
        border-radius: 5px;
    }

    .btn-monday:hover {
        background-color: rgba(var(--WinDOORS-theme-rgb), 0.5);
    }

    .required:after {
        content: " *";
        color: red;
    }

    .modal-content {
        /* background: rgba(255, 255, 255, 0.8) !important; */
        background: rgba(var(--WinDOORS-theme-bg-rgb), 0.8) !important;
    }

    .dark-mode .modal-content {
        background: rgba(var(--WinDOORS-theme-bg-rgb), 0.8) !important;
    }

    .dark-mode .nice-select-dropdown {
        background-color: rgba(var(--WinDOORS-theme-bg-rgb), 1);
        border: 2px solid white;
        padding: 2px
    }

    .dark-mode .nice-select-search {
        background-color: black;
        color: white;
    }

    .dark-mode .note-editing-area {
        background: black;
        color: white;
    }

    .dark-mode .nice-select .option:hover,
    .dark-mode .nice-select .option.focus,
    .dark-mode .nice-select .option.selected.focus {
        background-color: black;
    }

    .dark-mode .nice-select {
        background-color: #000;
    }

    .dark-mode .jconfirm-box {
        background-color: rgba(var(--WinDOORS-theme-bg-rgb), 1) !important;
    }

    .Critical {
        background: #1E4E79;
    }

    .High {
        background: #2E75B5;
    }

    .Medium {
        background: #9CC2E5;
    }

    .Low {
        background: #DEEAF6;
    }

    .mt-4-5 {
        margin-top: 1.7rem;
    }

    .w-90 {
        width: 95% !important;
    }

    .badge-4 {
        appearance: none;
        /* background-color: white; */
        border: 1px solid rgba(27, 31, 35, 0.15);
        border-radius: 4px;
        box-shadow: rgba(27, 31, 35, 0.04) 0 1px 0,
            rgba(255, 255, 255, 0.25) 0 1px 0 inset;
        box-sizing: border-box;
        color: #242424;
        cursor: pointer;
        display: inline-block;
        font-family: "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji",
            "Segoe UI Emoji";
        font-size: 14px;
        font-weight: 500;
        line-height: 20px;
        min-width: 96px;
        list-style: none;
        padding: 5px 12px;
        position: relative;
        transition: background-color 0.2s cubic-bezier(0.3, 0, 0.5, 1);
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        vertical-align: middle;
        white-space: nowrap;
        word-wrap: break-word;
    }

    .tooltip {
        --bs-tooltip-zindex: 1080;
        --bs-tooltip-max-width: 200px;
        --bs-tooltip-padding-x: 0.5rem;
        --bs-tooltip-padding-y: 0.25rem;
        --bs-tooltip-margin: ;
        --bs-tooltip-font-size: 0.875rem;
        --bs-tooltip-color: #fff;
        --bs-tooltip-bg: #000;
        --bs-tooltip-border-radius: 0.375rem;
        --bs-tooltip-opacity: 0.9;
        --bs-tooltip-arrow-width: 0.8rem;
        --bs-tooltip-arrow-height: 0.4rem;
        z-index: var(--bs-tooltip-zindex);
        display: block;
        padding: var(--bs-tooltip-arrow-height);
        margin: var(--bs-tooltip-margin);
        font-family: var(--bs-font-sans-serif);
        font-style: normal;
        font-weight: 400;
        line-height: 1.5;
        text-align: left;
        text-align: start;
        text-decoration: none;
        text-shadow: none;
        text-transform: none;
        letter-spacing: normal;
        word-break: normal;
        white-space: normal;
        word-spacing: normal;
        line-break: auto;
        font-size: var(--bs-tooltip-font-size);
        word-wrap: break-word;
        opacity: 0;
    }

    .tooltip.show {
        opacity: var(--bs-tooltip-opacity);
    }

    .tooltip .tooltip-arrow {
        display: block;
        width: var(--bs-tooltip-arrow-width);
        height: var(--bs-tooltip-arrow-height);
    }

    .tooltip .tooltip-arrow::before {
        position: absolute;
        content: "";
        border-color: transparent;
        border-style: solid;
    }

    .bs-tooltip-top .tooltip-arrow,
    .bs-tooltip-auto[data-popper-placement^=top] .tooltip-arrow {
        bottom: 0;
    }

    .bs-tooltip-top .tooltip-arrow::before,
    .bs-tooltip-auto[data-popper-placement^=top] .tooltip-arrow::before {
        top: -1px;
        border-width: var(--bs-tooltip-arrow-height) calc(var(--bs-tooltip-arrow-width) * 0.5) 0;
        border-top-color: var(--bs-tooltip-bg);
    }
</style>

<!-- Css Rating -->
<style>
    .rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: start;
    }

    .rating:not(:checked)>input {
        position: absolute;
        appearance: none;
    }

    .rating:not(:checked)>label {
        cursor: pointer;
        font-size: 15px;
        color: #666;
    }

    .rating:not(:checked)>label:before {
        content: '★';
    }

    .rating>input:checked+label:hover,
    .rating>input:checked+label:hover~label,
    .rating>input:checked~label:hover,
    .rating>input:checked~label:hover~label,
    .rating>label:hover~input:checked~label {
        color: #e58e09;
    }

    .rating:not(:checked)>label:hover,
    .rating:not(:checked)>label:hover~label {
        color: #ff9e0b;
    }

    .rating>input:checked~label {
        color: #ffa723;
    }
</style>
<!-- /Css Rating -->


<!-- CSS Custom -->
<style>
    .custom-style-sm .current {
        display: flex;
        overflow-x: hidden;
        max-width: 150px;
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