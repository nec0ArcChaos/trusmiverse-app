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
</style>

<style>
    .custom-bg-red {
        background-color: #ED0000;
    }

    /* Wrapper */
    #myTab {
      background-color: #f1f5fd;
      padding: 10px 20px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    /* Default */
    #myTab .nav-link {
      border: none !important;
      background: none !important;
      padding: 0;
      font-size: 14px;
      font-weight: 500;
      color: #111;
      display: flex;
      align-items: center;
      position: relative;
    }

    #myTab .nav-link::before {
        content: attr(data-step);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        margin-right: 6px;
        font-size: 14px;
        font-weight: 600;
    }

    .step-completed::before {
      content: "✔";
      background-color: #28c76f;
      color: white;
    }

    .step-current::before {
      background-color: white;
      border: 1px solid #ccc;
      color: #111;
    }

    .step-upcoming::before {
      background-color: #e5e5e5;
      color: #666;
    }

    #myTab .nav-item {
      display: flex;
      align-items: center;
    }

    #myTab .nav-item:not(:last-child)::after {
      content: "—";
      color: #bbb;
      margin-left: 10px;
      font-weight: bold;
    }
</style>
