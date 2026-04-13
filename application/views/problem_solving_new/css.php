<link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet">
<!-- button export -->
<link rel="stylesheet" href="<?= base_url('assets/data-table/css/buttons.dataTables.min.css') ?>">
<!-- Datetimepicker -->
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.min.css" />
<!-- Jquery Confirm -->
<link rel="stylesheet" href="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.css" />
<!-- Font Awesome -->
<link rel="stylesheet" href="<?= base_url(); ?>assets/fontawesome/css/all.min.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/semantic/components/dropdown.css">

</link>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/nice-select2/css/nice-select2.css" />
<style>
    input[type="file"] {
        border: 1px solid #ccc;
        border-radius: 5px;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
    }

    .bd-callout {
        --bs-link-color-rgb: var(--bd-callout-link);
        --bs-code-color: var(--bd-callout-code-color);
        padding: 1.25rem;
        margin-top: 1.25rem;
        margin-bottom: 1.25rem;
        color: var(--bd-callout-color, inherit);
        background-color: var(--bd-callout-bg, var(--bs-gray-100));
        border-left: .25rem solid var(--bd-callout-border, var(--bs-gray-300));
    }

    .custom-radio {
        display: none; /* Hide the default radio button */
    }

    .custom-label {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 40px;
        height: 40px;
        border: 2px solid #007bff;
        border-radius: 50%;
        font-size: 16px;
        font-weight: bold;
        color: #007bff;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .custom-radio:checked + .custom-label {
        background-color: #007bff;
        color: #fff;
    }
</style>