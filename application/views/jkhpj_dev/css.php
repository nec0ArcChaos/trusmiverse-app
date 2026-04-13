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
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/dragula/dragula.min.css" />

    <style>
        .note-editor {
            width: 100% !important;
        }

        .select_permintaan {
            width: 100%;
        }

        input[type="file"] {
            border: 1px solid #ccc;
            border-radius: 5px;
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
        }

        .filters input {
            width: 100%;
            padding-right: 10px;
            padding-left: 10px;
            padding-top: 3px;
            padding-bottom: 3px;
            box-sizing: border-box;
            border-radius: 5px;
            border: solid 1px #4680FF;
        }

        tfoot {
            display: table-header-group !important;
        }

        /*.m-buttons__btn:focus,*/
        .btn:hover {
            transform: translateY(1px);
        }

        /*.btn:focus:before,*/
        .btn:hover:before {
            transform: translateY(-1px);
        }

        .btn:active {
            transform: translateY(5px);
            transition: none;
        }

        .btn:active:before {
            transform: translateY(-5px);
            transition: none;
        }

        .btn,
        .btn:before,
        .btn:after {
            transition: all 0.5s cubic-bezier(0, 1, 0.2, 1);
        }

        .fade-in {
            animation: fadeIn ease 5s;
            -webkit-animation: fadeIn ease 5s;
            -moz-animation: fadeIn ease 5s;
            -o-animation: fadeIn ease 5s;
            -ms-animation: fadeIn ease 5s;
        }


        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @-moz-keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @-webkit-keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @-o-keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @-ms-keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }


        .slide_left {
            left: 0;
            /* background: #D2E3AB; */
            animation: slide-in-left 5s ease-out infinite;
        }

        .slide_right {
            right: 0;
            /* background: #2A7689; */
            animation: slide-in-right 5s ease-out infinite;
        }

        .slide_in_top {
            animation: myAnim 2s ease 0s 1 normal forwards;
        }


        @keyframes myAnim {
            0% {
                opacity: 0;
                transform: translateY(-250px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hide {
            display: none;
        }


        .ribbon::after {
            position: absolute;
            content: attr(data-label);
            top: 11px;
            right: -14px;
            padding: 0.5rem;
            width: 10rem;
            background: #3949ab;
            color: white;
            text-align: center;
            font-family: 'Roboto', sans-serif;
            box-shadow: 4px 4px 15px rgba(26, 35, 126, 0.2);
        }

        .card-header .fa {
            transition: .3s transform ease-in-out;
        }

        .card-header .collapsed .fa {
            transform: rotate(90deg);
        }

        /* Animasi rotasi untuk ikon */
        .collapse-icon {
            transition: transform 0.3s ease;
        }

        /* Ketika link TIDAK memiliki kelas 'collapsed', berarti card terbuka, ikon diputar ke bawah */
        a:not(.collapsed) .collapse-icon {
            transform: rotate(90deg);
        }

        /* Media query untuk tampilan mobile */
        @media (max-width: 767px) {
            .btn-md {
                font-size: 8px;
                padding: 2px;
            }

        }

        /* Style dari referensi kanban_section.php Anda */
        .kanban-container {
            overflow-x: auto;
            /* Memungkinkan scroll horizontal */
        }

        .wrapper {
            min-width: 100%;
            /* Memastikan row lebih lebar dari layar jika perlu */
        }

        .kanban-card {
            height: 100%;
        }

        .kanban-body {
            background-color: #f6fafd;
            overflow-y: auto;
            /* Scroll vertikal jika kartu terlalu banyak */
            max-height: 70vh;
            /* Batasi tinggi body card */
        }

        /* Styling untuk kartu saat di-drag */
        .gu-mirror {
            position: fixed !important;
            margin: 0 !important;
            z-index: 9999 !important;
            opacity: 0.8;
        }

        .gu-transit {
            opacity: 0.2;
        }
    </style>