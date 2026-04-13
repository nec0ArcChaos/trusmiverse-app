<link
    href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"
    rel="stylesheet" />
<link rel="stylesheet" type="text/css"
    href="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.min.css" />

<link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/fontawesome/css/all.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/scss/custom_button.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/scss/custom_input.css">
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
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/dragula/dragula.min.css" />
<link rel="stylesheet" href="https://unpkg.com/tippy.js@6/animations/scale.css" />


<style>
    .text-white {
        color: #ffffff;
    }

    .text-green {
        color: #8EB156;
    }

    .text-yellow {
        color: #E8AA00;
    }

    .text-red {
        color: #F2001F;
    }

    .text-grey {
        color: #5A5A5C;
    }

    .text-purple {
        color: #B46BF2;
    }

    .bg-soft-green {
        background-color: #BFEC78;
    }

    .bg-soft-yellow {
        background-color: #FFE97B;
    }

    .bg-soft-red {
        background-color: #FD97A4;
    }

    .bg-soft-grey {
        background-color: #F3F2F2 !important;
    }

    .bg-super-soft-grey {
        background-color: #F6FAFD !important;
    }

    .bg-soft-purple {
        background-color: #B46BF2;
    }

    .bg-blue_1 {
        background-color: #081226;
    }

    .bg-blue_2 {
        background-color: #0B3281;
    }

    .bg-blue_3 {
        background-color: #2D6DEF;
    }

    .bg-blue_4 {
        background-color: #8AA6DE;
    }

    .progress-tab .progress-text {
        color: black;
        /* Default text color */
        font-weight: bold;
    }

    .progress-tab .progress-white {
        color: white;
        /* Default text color */
        font-weight: bold;
    }

    .progress-tab.selected .progress-text {
        color: white;
        /* Text color when selected */
    }

    .profile-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        /* Adjust text size */
        font-weight: bold;
        color: white;
        /* Text color */
        /* background-color: purple; */
        text-transform: uppercase;
    }

    .required:after {
        content: " *";
        color: red;
    }

    .scrollable-column {
        max-height: 300px;
        /* Set your desired height */
        overflow-y: auto;
        /* Enable vertical scrolling if content overflows */
        padding-right: 10px;
        /* Add padding to avoid cutting off scrollbar */
        scrollbar-width: thin;
        /* For Firefox (optional) */
        scrollbar-color: #ccc transparent;
        /* For Firefox (optional) */
    }

    /* Optional: Customize scrollbar for WebKit browsers (Chrome, Edge, etc.) */
    .scrollable-column::-webkit-scrollbar {
        width: 6px;
        /* Scrollbar width */
    }

    .scrollable-column::-webkit-scrollbar-thumb {
        background-color: #ccc;
        /* Scrollbar thumb color */
        border-radius: 10px;
        /* Rounded scrollbar thumb */
    }

    .scrollable-column::-webkit-scrollbar-track {
        background-color: transparent;
        /* Scrollbar track color */
    }

    .circle-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #E4E4E4;
        /* Grey */
        color: white;
        border: none;
        cursor: pointer;
    }

    .circle-btn:hover {
        background-color: #D6D6D6;
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
        background-color: #FFE97B !important;
        color: white !important;
    }

    .kanban-header-done {
        background-color: #BFEC78 !important;
        color: white !important;
    }

    .kanban-header-feedback {
        background-color: #e1a1ff !important;
        color: white !important;
    }

    .kanban-header-revisi {
        background-color: #FD97A4 !important;
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

    .kanban-container {
        overflow-x: auto;
        white-space: nowrap;
        padding-bottom: 10px;
        /* Opsional, untuk ruang bawah */
    }

    .kanban-container::-webkit-scrollbar {
        height: 8px;
    }

    .kanban-container::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 4px;
    }

    .wrapper {
        display: flex;
        flex-wrap: nowrap;
    }
</style>

<style>
    .chart-container {
        width: 120px;
        height: 60px;
    }

    .chart-line {
        stroke-width: 3;
        fill: none;
        stroke-linecap: round;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.25));
    }

    /* Warna untuk grafik dan teks perubahan */
    .chart-green-line {
        stroke: #22c55e;
        /* Hijau untuk grafik */
    }

    .text-green-indicator {
        color: #14b8a6;
        /* Hijau untuk teks "vs last month" */
    }

    .chart-red-line {
        stroke: #ef4444;
        /* Merah untuk grafik */
    }

    .text-red-indicator {
        chart-container color: #ef4444;
        /* Merah untuk teks "vs last month" */
    }

.dots {
    display: flex;
    gap: 6px; /* jarak antar dot */
    align-items: center;
}

.dot {
    width: 12px;       /* lebar dot */
    height: 12px;      /* tinggi dot */
    border-radius: 50%; /* bikin lingkaran */
    background-color: gray; /* default */
}

/* warna khusus */
.dot.green {
    background-color: #22c55e;
}
.dot.red {
    background-color: #ef4444;
}
.dot.yellow {
    background-color: #facc15;
}
 .spinner {
            width: 24px;
            height: 24px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #4CAF50;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 10px;
        }


        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
</style>


<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    .graph {
        height: 80px;
        width: 100%;
        position: relative;
    }

    .graph svg {
        width: 100%;
        height: 100%;
        overflow: visible;
    }
</style>