    <link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet">
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
        .select_permintaan {
            width: 100%;
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

        .nice-select.invalid {
            border-color: red;
        }

        /* mini card */
        .mini {
            padding: 16px;
            border-radius: 12px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0.01));
            border: 1px solid rgba(255, 255, 255, 0.03)
        }

        .status-line {
            display: flex;
            align-items: center;
            gap: 10px
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%
        }

        .dot.green {
            background: var(--success)
        }

        .dot.gray {
            background: #64748b
        }

        .muted {
            color: var(--muted);
            font-size: 13px
        }

        .stat-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 12px
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .stat-item strong {
            font-size: 18px
        }

        /* floating avatar */
        .floating {
            position: fixed;
            right: 28px;
            bottom: 28px;
            z-index: 12000;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 10px;
        }

        .floating.scrolled {
            bottom: 70px;
        }

        .card.item {
            padding: 18px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.02)
        }

        .avatar-btn {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fff 0%, rgba(255, 255, 255, 0.9) 60%);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 12px 40px rgba(2, 6, 23, 0.6);
            border: 4px solid rgba(255, 255, 255, 0.06);
        }

        .avatar-btn img {
            width: 58px;
            height: 58px;
            border-radius: 50%
        }

        .bubble {
            max-width: 320px;
            padding: 12px;
            border-radius: 12px;
            background: var(--glass);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.03);
            color: #dbeafe;
            box-shadow: 0 10px 30px rgba(2, 6, 23, 0.6)
        }

        .bubble h3 {
            margin: 0;
            font-size: 15px
        }

        .bubble p {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: 13px
        }

        /* panel */
        .panel {
            position: fixed;
            right: 28px;
            bottom: 110px;
            width: 360px;
            border-radius: 12px;
            padding: 14px;
            background: var(--glass);
            backdrop-filter: blur(12px);
            box-shadow: 0 10px 20px rgba(2, 6, 23, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.03);
            z-index: 1200;
            display: none
        }

        .panel .header {
            display: flex;
            align-items: center;
            gap: 12px
        }

        .panel h4 {
            margin: 0
        }

        .panel .meta {
            color: var(--muted);
            font-size: 12px
        }

        .panel .items {
            margin-top: 12px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-height: 320px;
            overflow: auto;
            padding-right: 6px
        }

        .panel .item {
            background: rgba(255, 255, 255, 0.02);
            padding: 10px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.02)
        }

        .panel .cta {
            display: flex;
            gap: 8px;
            margin-top: 12px
        }

        .btn {
            padding: 8px 12px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600
        }

        .btn.primary {
            background: linear-gradient(90deg, var(--accent), #7c3aed);
            color: #061226
        }

        .btn.ghost {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.04);
            color: var(--muted)
        }

        /* responsive */
        @media (max-width:900px) {
            .grid {
                grid-template-columns: 1fr;
            }

            .panel {
                right: 12px;
                left: 12px;
                width: auto;
                bottom: 100px
            }

            .floating {
                right: 12px;
                bottom: 12px
            }
        }
    </style>
    <style>
        /* Custom CSS for the modal */
        .avatar {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .score-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .match-list li,
        .missing-list li {
            padding: 5px 0;
        }

        .modal-content {
            border: none;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .w-100{
            width: 100%;
        }
    </style>