<link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet">
<!-- button export -->
<link rel="stylesheet" href="<?= base_url('assets/data-table/css/buttons.dataTables.min.css') ?>">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/nice-select2/css/nice-select2.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/nice-select2/css/nice-select2.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/fontawesome/css/all.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/scss/custom_button.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/scss/custom_input.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.css">
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />


<style>
    :root {
        /* Diperbarui: Latar belakang lebih putih (kurang transparan) */
        --glass-bg: rgba(255, 255, 255, 0.3);
        --glass-border-color-start: #ffffff;
        /* Warna awal gradasi (putih) */
        --glass-border-color-end: #a0a0a0;
        /* Warna akhir gradasi (abu-abu) */
        --text-color: #333;
        /* Warna teks diubah agar lebih kontras di atas bg putih */
    }

    .main.mainheight {
        position: relative;
        min-height: 100vh;
        /* supaya memenuhi layar */
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    .main.mainheight::before {
        content: "";
        position: absolute;
        inset: 0;
        /* top, right, bottom, left = 0 */
        background: url("<?= base_url('assets/img/bg-gradient.png'); ?>") center/cover no-repeat;
        opacity: 1;
        /* transparansi */
        filter: blur(5px);
        /* efek blur */
        z-index: -1;
        /* letakkan di belakang konten */
    }

    .glass-card {
        position: relative;
        background: var(--glass-bg);
        /* backdrop-filter: blur(5px); */
        -webkit-backdrop-filter: blur(5px);
        border-radius: 10px;
        padding: 20px;
        color: var(--text-color);
        border: 3px solid rgba(255, 255, 255, 0.5);
        /* Border dibuat sedikit lebih terlihat */
        box-shadow: 0 1px 7px rgba(0, 0, 0, 0.1);

        /* Transisi yang diperbarui untuk hover yang mulus */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        z-index: 1;
        /* Pastikan kartu berada di atas pseudo-element */
    }



    /* --- EFEK HOVER YANG SESUAI --- */
    .glass-card:hover {
        background-color: rgba(255, 255, 255, 0.45);
        /* Bayangan yang lebih menonjol dan memberikan efek 'glow' */
        /* box-shadow: 0 5px 5px rgba(0, 0, 0, 0.1), */
        /* 0 0 10px rgba(255, 255, 255, 0.1); */
    }


    .negative-kpi {
        color: #ff6b6b;
    }

    .positive-kpi {
        color: #51cf66;
    }

    .custom-list {
        list-style-type: none;
        /* Menghilangkan bullet point */
        padding-left: 0;
        /* Menghilangkan padding kiri default */
    }

    @keyframes pulse-fade {
        0% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: 0.3;
            transform: scale(1.3);
        }

        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Terapkan animasi ke ikon dengan class khusus */
    .loading-icon-pulse {
        animation: pulse-fade 1.5s ease-in-out infinite;
        display: inline-block;
    }

    .kesehatan-kpi {
        max-height: 260px;
        overflow-y: auto;
    }
</style>