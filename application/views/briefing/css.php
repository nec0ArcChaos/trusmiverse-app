<link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet">
<!-- button export -->
<link rel="stylesheet" href="<?= base_url('assets/data-table/css/buttons.dataTables.min.css') ?>">
<!-- Datetimepicker -->
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.min.css" />
<!-- Jquery Confirm -->
<link rel="stylesheet" href="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.css" />
<!-- Font Awesome -->
<link rel="stylesheet" href="<?= base_url(); ?>assets/fontawesome/css/all.min.css" />

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

<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.css">



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

    .feedback {
        border-width: 1px !important;
    }

    /* HTML: <div class="loader"></div> */
    .loader {
        width: 50px;
        aspect-ratio: 1;
        display: grid;
        border: 4px solid #0000;
        border-radius: 50%;
        border-color: #ccc #0000;
        animation: l16 1s infinite linear;
    }

    .loader::before,
    .loader::after {
        content: "";
        grid-area: 1/1;
        margin: 2px;
        border: inherit;
        border-radius: 50%;
    }

    .loader::before {
        border-color: #f03355 #0000;
        animation: inherit;
        animation-duration: .5s;
        animation-direction: reverse;
    }

    .loader::after {
        margin: 8px;
    }

    @keyframes l16 {
        100% {
            transform: rotate(1turn)
        }
    }
</style>