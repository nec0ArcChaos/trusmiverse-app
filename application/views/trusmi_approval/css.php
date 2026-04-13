    <link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet" />
    <!-- button export -->
    <link rel="stylesheet" href="<?= base_url('assets/data-table/css/buttons.dataTables.min.css') ?>" />
    <!-- Date-range picker css  -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/css/bootstrap-datepicker3.css" />
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
        .voice-indicator {
            background: #f0f0f0;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            position: relative;
            transition: all 0.3s ease;
        }

        .sound-icon {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sound-wave {
            width: 200px;
            height: 100px;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .sound-wave .bar {
            display: block;
            width: 5px;
            margin-right: 1px;
            height: 10px;
            background: #7C93BF;
            animation: sound 0ms -800ms linear infinite alternate;
            transition: height 0.8s;
        }

        .sound-wave .bar-idle {
            display: block;
            width: 20px;
            margin-right: 1px;
            height: 5px;
            background: #7C93BF;
        }

        .sound-wave .bar2 {
            display: block;
            width: 2px;
            margin-right: 1px;
            height: 120px;
            background: #7C93BF;
            animation: sound2 0ms -800ms linear infinite alternate;
            transition: height 0.8s;
        }

        @keyframes sound {
            0% {
                opacity: .35;
                height: 6px;
            }

            100% {
                opacity: 1;
                height: 46px;
            }
        }

        @keyframes sound2 {
            0% {
                opacity: .35;
                height: 6px;
            }

            100% {
                opacity: 1;
                height: 120px;
            }
        }

        .bar:nth-child(1) {
            height: 2px;
            animation-duration: 474ms;
        }

        .bar:nth-child(2) {
            height: 10px;
            animation-duration: 433ms;
        }

        .bar:nth-child(3) {
            height: 18px;
            animation-duration: 407ms;
        }

        .bar:nth-child(4) {
            height: 26px;
            animation-duration: 458ms;
        }

        .bar:nth-child(5) {
            height: 30px;
            animation-duration: 400ms;
        }

        .bar:nth-child(6) {
            height: 32px;
            animation-duration: 427ms;
        }

        .bar:nth-child(7) {
            height: 34px;
            animation-duration: 441ms;
        }

        .bar:nth-child(8) {
            height: 36px;
            animation-duration: 419ms;
        }

        .bar:nth-child(9) {
            height: 40px;
            animation-duration: 487ms;
        }

        .bar:nth-child(10) {
            height: 46px;
            animation-duration: 442ms;
        }

        .bar:nth-child(11) {
            height: 2px;
            animation-duration: 474ms;
        }

        .bar:nth-child(12) {
            height: 10px;
            animation-duration: 433ms;
        }

        .bar:nth-child(13) {
            height: 18px;
            animation-duration: 407ms;
        }

        .bar:nth-child(14) {
            height: 26px;
            animation-duration: 458ms;
        }

        .bar:nth-child(15) {
            height: 30px;
            animation-duration: 400ms;
        }

        .bar:nth-child(16) {
            height: 32px;
            animation-duration: 427ms;
        }

        .bar:nth-child(17) {
            height: 34px;
            animation-duration: 441ms;
        }

        .bar:nth-child(18) {
            height: 36px;
            animation-duration: 419ms;
        }

        .bar:nth-child(19) {
            height: 40px;
            animation-duration: 487ms;
        }

        .bar:nth-child(20) {
            height: 46px;
            animation-duration: 442ms;
        }




        .bar-idle:nth-child(1) {
            height: 5px;
            animation-duration: 474ms;
        }

        .bar-idle:nth-child(2) {
            height: 5px;
            animation-duration: 433ms;
        }

        .bar-idle:nth-child(3) {
            height: 5px;
            animation-duration: 407ms;
        }

        .bar-idle:nth-child(4) {
            height: 5px;
            animation-duration: 458ms;
        }

        .bar-idle:nth-child(5) {
            height: 5px;
            animation-duration: 400ms;
        }

        .bar-idle:nth-child(6) {
            height: 5px;
            animation-duration: 427ms;
        }

        .bar-idle:nth-child(7) {
            height: 5px;
            animation-duration: 441ms;
        }

        .bar-idle:nth-child(8) {
            height: 5px;
            animation-duration: 419ms;
        }

        .bar-idle:nth-child(9) {
            height: 5px;
            animation-duration: 487ms;
        }

        .bar-idle:nth-child(10) {
            height: 5px;
            animation-duration: 442ms;
        }

        .bar-idle:nth-child(11) {
            height: 5px;
            animation-duration: 474ms;
        }

        .bar-idle:nth-child(12) {
            height: 5px;
            animation-duration: 433ms;
        }

        .bar-idle:nth-child(13) {
            height: 5px;
            animation-duration: 407ms;
        }

        .bar-idle:nth-child(14) {
            height: 5px;
            animation-duration: 458ms;
        }

        .bar-idle:nth-child(15) {
            height: 5px;
            animation-duration: 400ms;
        }

        .bar-idle:nth-child(16) {
            height: 5px;
            animation-duration: 427ms;
        }

        .bar-idle:nth-child(17) {
            height: 5px;
            animation-duration: 441ms;
        }

        .bar-idle:nth-child(18) {
            height: 5px;
            animation-duration: 419ms;
        }

        .bar-idle:nth-child(19) {
            height: 5px;
            animation-duration: 487ms;
        }

        .bar-idle:nth-child(20) {
            height: 5px;
            animation-duration: 442ms;
        }





        .voice-indicator.active {
            background: #e3f2fd;
        }

        .result-display {
            background: white;
            min-height: 150px;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border: 2px solid #eee;
            overflow-y: auto;
            max-height: 300px;
        }

        .record-btn {
            background: #4a90e2;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            /* font-size: 1.1rem; */
            border-radius: 25px;
            cursor: pointer;
            display: block;
            margin: 0 auto;
            transition: all 0.3s ease;
            position: relative;
        }

        .record-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(74, 144, 226, 0.4);
        }

        .record-btn.recording {
            background: #ff4757;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .action-btn {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            background: #f0f0f0;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            background: #4a90e2;
            color: white;
        }
    </style>