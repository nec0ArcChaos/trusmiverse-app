<link href="<?php echo base_url() ?>assets/fancybox/jquery.fancybox.min.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<!-- app tour css -->
<link rel="stylesheet" href="<?= base_url() ?>assets/vendor/Product-Tour-jQuery/lib.css">
<style>
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

            .chatbot-bubble.text-dark {
                max-width: 320px;
                padding: 12px;
                border-radius: 12px;
                background: var(--glass) !important;
                backdrop-filter: blur(6px);
                border: 1px solid rgba(255, 255, 255, 0.03);
                color: #dbeafe;
                box-shadow: 0 10px 30px rgba(2, 6, 23, 0.6)
            }

            .chatbot-bubble h3 {
                margin: 0;
                font-size: 15px
            }

            .chatbot-bubble p {
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
    </style>
<style>
    /* html {
        zoom: 100%;
    } */


    .modal-backdrop {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-color: transparent;
        /* Ubah nilai alpha sesuai kebutuhan */
    }

    .spinner-dashboard {
        --bs-spinner-width: 1rem;
        --bs-spinner-height: 1rem;
        --bs-spinner-vertical-align: -0.125em;
        --bs-spinner-border-width: 0.10em;
        --bs-spinner-animation-speed: 0.75s;
        --bs-spinner-animation-name: spinner-border;
        border: var(--bs-spinner-border-width) solid currentcolor;
        border-right-color: transparent;
    }

    .border-late {
        border: solid 2px #FFB64D;
    }

    .border-ontime {
        border: solid 2px #DEEDB3;
    }

    .active-4 {
        appearance: none;
        background-color: white !important;
        border: 1px solid rgba(27, 31, 35, 0.15) !important;
        border-radius: 4px !important;
        box-shadow: rgba(27, 31, 35, 0.04) 0 1px 0,
            rgba(255, 255, 255, 0.25) 0 1px 0 inset;
        box-sizing: border-box;
        color: #242424;
        cursor: pointer;
        display: inline-block;
        font-family: "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji",
            "Segoe UI Emoji";
        font-size: 14px;
        font-weight: 500;
        line-height: 20px;
        min-width: 96px;
        list-style: none;
        /* padding: 5px 12px; */
        position: relative;
        transition: background-color 0.2s cubic-bezier(0.3, 0, 0.5, 1);
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        vertical-align: middle;
        white-space: nowrap;
        word-wrap: break-word;
    }

    .dark-mode .active-4 {
        background-color: #292929;
        color: #ffffff;
        border: solid 1px #666666;
    }

    .dark-mode .active-4:hover {
        background-color: #323334;
    }

    .active-4:hover {
        background-color: #f3f4f6;
        text-decoration: none;
        transition-duration: 0.2s;
    }

    .active-4:active {
        background-color: #edeff2;
        box-shadow: rgba(225, 228, 232, 0.2) 0 1px 0 inset;
        transition: none 0s;
    }

    .active-4:focus {
        outline: 1px transparent;
    }

    .active-4:before {
        display: none;
    }

    .action-4:-webkit-details-marker {
        display: none;
    }

    .nice-select .current {
        color: black;
    }

    .nice-select-dropdown .list li {
        color: black;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .confetti {
        position: absolute;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        opacity: 0.7;
        animation: fall linear infinite;
        z-index: 10;
    }

    @keyframes fall {
        0% {
            transform: translateY(0) rotate(0deg);
            opacity: 1;
        }

        100% {
            transform: translateY(100vh) rotate(360deg);
            opacity: 0;
        }
    }

    #signature-pad-container {
        border: 2px dashed #ccc;
        width: 100%;
        height: 250px;
    }

    /* #signature-pad {
        width: 100% !important;
        height: 100% !important;
    } */
</style>


<link href="<?= base_url(); ?>assets/scss/custom_button.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/scss/custom_input.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url(); ?>assets/selectize/selectize.bootstrap5.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/font_awesome/css/all.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/nice-select2/css/nice-select2.css" />