    <!-- <link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet"> -->
    <!-- SlimSelect CSS -->
    <link href="https://cdn.jsdelivr.net/npm/slim-select@2.8.1/dist/slimselect.min.css" rel="stylesheet" />

    <!-- button export -->
    <link rel="stylesheet" href="<?= base_url('assets/data-table/css/buttons.dataTables.min.css') ?>">
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css"> -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/nice-select2/css/nice-select2.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/scss/custom_button.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/scss/custom_input.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.css">



    <style>
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

        .border-bottom-warning>td {
            border-bottom: 5px solid #F8D20D;
        }

        .custom-style .current {
            max-width: 600px;
            display: inline-block;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }

        .custom-style-sm .current {
            max-width: 200px;
            display: inline-block;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }

        @media only screen and (max-width: 767px) {
            .custom-style .current {
                max-width: 400px;
            }

            .custom-style-sm .current {
                max-width: 200px;
            }
        }

        @media only screen and (max-width: 480px) {

            /* smartphones, iPhone, portrait 480x320 phones */
            .custom-style .current {
                max-width: 200px;
            }

            .custom-style-sm .current {
                max-width: 200px;
            }
        }

        .jconfirm .jconfirm-box div.jconfirm-content-pane .jconfirm-content {
            overflow: hidden;
        }

        .leave_categories_div::-webkit-scrollbar {
            width: 10px;
        }

        /* Paksa tampilkan tombol hapus addnew */
        /* .ss-main .ss-values .ss-value .ss-value-delete {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        } */
    </style>