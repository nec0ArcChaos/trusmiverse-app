<link href="<?php echo base_url() ?>assets/fancybox/jquery.fancybox.min.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />

<style>
    .spinner-dashboard {
        --bs-spinner-width: 1rem;
        --bs-spinner-height: 1rem;
        --bs-spinner-vertical-align: -0.125em;
        --bs-spinner-border-width: 0.10em;
        --bs-spinner-animation-speed: 0.75s;
        --bs-spinner-animation-name: spinner-border;
        border: var(--bs-spinner-border-width) solid currentcolor;
        border-right-color: transparent;
    }

    .border-late {
        border: solid 2px #FFB64D;
    }

    .border-ontime {
        border: solid 2px #DEEDB3;
    }

    .active-4 {
        appearance: none;
        background-color: white !important;
        border: 1px solid rgba(27, 31, 35, 0.15) !important;
        border-radius: 4px !important;
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
        /* padding: 5px 12px; */
        position: relative;
        transition: background-color 0.2s cubic-bezier(0.3, 0, 0.5, 1);
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        vertical-align: middle;
        white-space: nowrap;
        word-wrap: break-word;
    }


    .dark-mode .active-4 {
        background-color: #292929;
        color: #ffffff;
        border: solid 1px #666666;
    }

    .dark-mode .active-4:hover {
        background-color: #323334;
    }

    .active-4:hover {
        background-color: #f3f4f6;
        text-decoration: none;
        transition-duration: 0.2s;
    }

    .active-4:active {
        background-color: #edeff2;
        box-shadow: rgba(225, 228, 232, 0.2) 0 1px 0 inset;
        transition: none 0s;
    }

    .active-4:focus {
        outline: 1px transparent;
    }

    .active-4:before {
        display: none;
    }

    .action-4:-webkit-details-marker {
        display: none;
    }

    .nice-select .current {
        color: black;
    }

    .nice-select-dropdown .list li {
        color: black;
    }

    .h-1-rem {
        height: 1rem !important;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    @media screen and (max-width: 768px) {
        .fc-header-toolbar .fc-toolbar .fc-toolbar-ltr {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 0;
            display: flex;
            flex-wrap: wrap;
            margin-top: calc(-1 * var(--bs-gutter-y));
            margin-right: calc(-0.5 * var(--bs-gutter-x));
            margin-left: calc(-0.5 * var(--bs-gutter-x));
        }

        .fc-toolbar-chunk {
            flex: 0 0 auto;
            width: 100%;
        }
    }
</style>


<link href="<?= base_url(); ?>assets/scss/custom_button.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/scss/custom_input.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url(); ?>assets/selectize/selectize.bootstrap5.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/font_awesome/css/all.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/nice-select2/css/nice-select2.css" />