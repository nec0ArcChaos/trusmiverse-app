<!-- button export -->
<link rel="stylesheet" href="<?= base_url('assets/data-table/css/buttons.dataTables.min.css') ?>">

<!-- Datetimepicker -->
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.min.css" />

<!-- Font Awesome -->
<link rel="stylesheet" href="<?= base_url(); ?>assets/fontawesome/css/all.min.css" />

<style>
/* Styling Custom */
.bg-soft-success { background-color: rgba(25, 135, 84, 0.1); }
.x-small { font-size: 0.75rem; }
.mainheight { min-height: 85vh; background-color: #f8f9fa; padding-top: 20px; }
.page-title h5 { letter-spacing: 1px; }
.card { border-radius: 12px; }
.table thead th { font-size: 0.85rem; text-transform: uppercase; font-weight: 600; }
/* Memperbaiki tampilan search DataTables agar lebih Bootstrap 5 */
.dataTables_filter input { border-radius: 20px; padding: 5px 15px; border: 1px solid #dee2e6; }

#container-buttons .dt-buttons {
    margin-bottom: 0;
}
.btn-outline-success:hover {
    color: white !important;
}
</style>