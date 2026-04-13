<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/nice-select2/css/nice-select2.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.min.css" />
<!-- <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/jquery-timepicker/jquery.timepicker.min.css"> -->


<style>
    select option[disabled] {
        display: none;
    }

    .nice-select-dropdown .disabled {
        display: none;
    }

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