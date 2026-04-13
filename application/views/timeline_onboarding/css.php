<link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet">
<!-- button export -->
<link rel="stylesheet" href="<?= base_url('assets/data-table/css/buttons.dataTables.min.css') ?>">
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css"> -->
<link rel="stylesheet" href="<?= base_url(); ?>assets/nice-select2/css/nice-select2.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/fontawesome/css/all.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/scss/custom_button.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/scss/custom_input.css">


<style>
    .bg-light-success {
        background-color: var(--bs-success-light);
    }

    .bg-light-danger {
        background-color: var(--bs-danger-light);
    }

    .bg-light-primary {
        background-color: var(--bs-primary-light);
    }

    .bg-light-warning {
        background-color: var(--bs-warning-light);
    }

    .bg-light-info {
        background-color: var(--bs-info-light);
    }

    .bg-light-gray {
        background-color: var(--bs-light-gray);
    }

    :root {
        --bs-primary-rgb: 37, 99, 235;
        /* Custom primary blue */
        --bs-primary: rgb(var(--bs-primary-rgb));
        --bs-light-blue: #F0F9FF;
        --bs-light-gray: #F3F4F6;
        --bs-text-muted: #6B7280;
        --bs-success-light: #E0F2F1;
        --bs-warning-light: #f3efe0ff;
    }

    body {
        background-color: var(--bs-light-gray);
        font-family: 'Poppins', sans-serif;
        color: #374151;
    }

    .main-container {
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    .card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    }

    /* Progress Stepper */
    .stepper-wrapper {
        display: flex;
        justify-content: space-between;
        margin: 2.5rem 0;
    }

    .stepper-item {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
    }

    .stepper-item::before {
        position: absolute;
        content: "";
        border-bottom: 2px dashed #E0E0E0;
        width: 100%;
        top: 15px;
        left: -50%;
        z-index: 2;
    }

    .stepper-item::after {
        position: absolute;
        content: "";
        border-bottom: 2px dashed #E0E0E0;
        width: 100%;
        top: 15px;
        left: 50%;
        z-index: 2;
    }

    .stepper-item .step-counter {
        position: relative;
        z-index: 5;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #E0E0E0;
        margin-bottom: 6px;
        font-weight: 500;
    }

    .stepper-item .step-name {
        font-size: 0.875rem;
        color: var(--bs-text-muted);
        font-weight: 500;
    }

    .stepper-item.active .step-counter {
        background-color: var(--bs-primary);
        color: white;
        border-color: var(--bs-primary);
    }

    .stepper-item.active .step-name {
        color: var(--bs-primary);
        font-weight: 600;
    }

    .stepper-item:first-child::before {
        content: none;
    }

    .stepper-item:last-child::after {
        content: none;
    }

    /* Journey Onboarding Accordion */
    .accordion-item {
        background-color: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem !important;
        margin-bottom: 1rem;
    }

    .accordion-button {
        border-radius: 0.75rem !important;
    }

    .accordion-button:not(.collapsed) {
        background-color: var(--bs-light-blue);
        color: var(--bs-primary);
        box-shadow: none;
    }

    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(0, 0, 0, .125);
    }

    .accordion-button::after {
        display: none;
        /* Hide default chevron */
    }

    .custom-chevron {
        transition: transform 0.2s ease-in-out;
    }

    .accordion-button:not(.collapsed) .custom-chevron {
        transform: rotate(180deg);
    }

    /* Custom Cards */
    .mentor-card {
        background: linear-gradient(135deg, var(--bs-light-blue) 0%, #E0E7FF 100%);
    }

    /* Right Sidebar */
    .sidebar-card {
        margin-bottom: 1.5rem;
    }

    .chat-input-wrapper {
        position: relative;
    }

    .chat-input-wrapper .form-control {
        padding-right: 3rem;
    }

    .chat-input-wrapper .btn-send {
        position: absolute;
        right: 0.5rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--bs-primary);
    }

    /* Styling untuk horizontal scroll kontak */
    .contact-scroll {
        display: flex;
        overflow-x: hidden;
        padding-bottom: 10px;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .contact-scroll::-webkit-scrollbar {
        display: none;
        /* Safari and Chrome */
    }

    .contact-item {
        flex: 0 0 auto;
        /* Mencegah item menyusut */
        width: 90px;
        text-align: center;
        margin-right: 15px;
    }

    .contact-item img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 8px;
    }

    .contact-item .name {
        font-size: 0.8rem;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Utilities */
    .fw-600 {
        font-weight: 600;
    }

    .text-primary {
        color: var(--bs-primary) !important;
    }

    .text-muted {
        color: var(--bs-text-muted) !important;
    }

    .collapsible-trigger {
        cursor: pointer;
    }

    /* Memberi animasi transisi yang mulus untuk ikon panah */
    .collapsible-trigger .bi-chevron-down {
        transition: transform 0.3s ease;
    }

    /* Kelas 'rotated' akan ditambahkan oleh jQuery untuk memutar ikon */
    .collapsible-trigger .bi-chevron-down.rotated {
        transform: rotate(180deg);
    }

    
</style>