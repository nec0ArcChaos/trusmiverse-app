<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/scss/custom_button.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/scss/custom_input.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/data-table/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/fontawesome/css/all.min.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/font_awesome/css/all.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/mind-wired/dist/mind-wired.css" />

<style>
    /* START: out of box css*/

    .wrapper {
        position: relative;
        font-size: 12px;
    }

    .wrapper .logo {
        position: absolute;
        top: 16px;
        left: 16px;
        z-index: 1;
        display: flex;
        align-items: center;
        column-gap: 8px;
        padding: 8px;
    }

    .wrapper .logo i {
        font-size: 2.25rem;
    }

    .wrapper .logo .link {
        display: flex;
        flex-direction: column;
        text-decoration: none;
        color: #444;
        background-color: white;
    }

    .wrapper .logo .link:visit {
        text-decoration: none;
    }

    .wrapper .help {
        position: absolute;
        top: 16px;
        right: 16px;
        padding: 8px;
        z-index: 1;
        display: table;
        font-size: 1.1rem;
    }

    .wrapper .help .tip {
        display: table-row;
        margin-bottom: 2px;
    }

    .wrapper .help .tip>div {
        display: table-cell;
        text-align: right;
        padding: 4px;
        border: 1px solid transparent;
    }

    .wrapper .help .tip>div.desc {
        text-align: left;
    }

    .wrapper .help .tip>div .key {
        background-color: #eee;
        color: #444;
        padding: 2px 4px;
        border: 4px;
        border-radius: 4px;
    }

    .dimmer {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #0000004d;
        z-index: 50;
    }

    .dimmer .output {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 400px;
        transform: translate(-50%, -50%);
        padding: 16px;
        display: flex;
        flex-direction: column;
        background-color: white;
    }

    .dimmer .output textarea {
        height: 300px;
        resize: none;
    }

    .dimmer .output button {
        width: 100%;
    }

    /* END: out of box css */
    #mmap-root {
        background-color: #efefef;
        display: flex;
        justify-content: center;
        padding: 16px;
        font-family: "Poppins", sans-serif;
    }

    [data-mind-wired-viewport] .mwd-body.level-0 {
        border: 1px solid #777;
        border-radius: 4px;
        font-size: 1.2rem;
        text-align: center;
        padding: 2px;
    }

    [data-mind-wired-viewport] .mwd-body.level-1 {
        border-radius: 4px;
        font-size: 1rem;
        background-color: #e5f6ff;
        color: #034375;
    }

    [data-mind-wired-viewport] .mwd-body.level-2 {
        font-size: 0.9rem;
        color: #9b175a;
    }

    [data-mind-wired-viewport] .mwd-node .mwd-body.memo {
        font-size: 0.9rem;
        background-color: #fffc89;
        font-style: italic;
        padding: 4px;
    }
</style>