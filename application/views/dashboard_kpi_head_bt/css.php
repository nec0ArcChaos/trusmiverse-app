<link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet">
<!-- button export -->
<link rel="stylesheet" href="<?= base_url('assets/data-table/css/buttons.dataTables.min.css') ?>">

<style>
    body {
        /* background-color: #f8faff; */
        background-color: #fdfaf7;
        font-family: Arial, sans-serif;
    }

    .bg-container {
        background-image: url('<?= base_url('assets/img/bg-dash-kpi-head-bt.png') ?>'); /* path gambar */
        background-size: cover;       /* supaya menutupi seluruh area */
        background-repeat: no-repeat; /* jangan diulang */
        background-position: center;  /* posisi di tengah */
    }

    .nav-tabs {
        justify-content: center;
        border-bottom: none;
    }

    .nav-tabs .nav-link {
        background-color: white;    
        /* border: none; */
         border-radius: 6px;    
        color: #555;
        font-weight: 500;
        font-size: 1rem;
    }

    .nav-tabs .nav-link.active {
        background-color: transparent;
        color: #000;
        font-weight: 600;
        border-bottom: 3px solid #000;
    }

    /* .nav-tabs .nav-link {
        background-color: white;    
        color: #333;             
        border-radius: 6px;        
        margin: 0 4px;              
    }

    .nav-tabs .nav-link.active {
        background-color: #ffffffff;
        color: white;             
    } */


    .card {
        background-color: rgba(255, 255, 255, 0.7); /* putih transparan 70% */
        backdrop-filter: blur(6px); /* opsional efek blur di belakang */
        border: none; /* opsional: hilangkan border */
        box-shadow: 0 4px 12px rgba(0,0,0,0.1); /* opsional bayangan lembut */
    }

.kpi-card {
    /* background-color: #fff; */
        background-color: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(6px);
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
        min-height: 180px;
    }

    .kpi-icon {
        width: 40px;
        height: 40px;
        background-color: #fff2e6;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }

    .status {
        font-weight: 500;
        font-size: 0.9rem;
    }

    .status-green {
        color: #16a34a;
    }

    .status-red {
        color: #dc2626;
    }

    .kpi-value {
        font-size: 2rem;
        font-weight: bold;
        margin: 0;
    }

    .kpi-change {
        font-size: 0.9rem;
        color: #16a34a;
        font-weight: 500;
        margin-top: auto;
    }

    .text-orange {
        color: #f97316 !important;
    }

    .nav-tabs .nav-link.active {
        color: #f97316 !important;
        border-color: #f97316 #f97316 transparent;
    }
</style>