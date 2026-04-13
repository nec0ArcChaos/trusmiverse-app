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
        overflow-x: auto;
        padding-bottom: 10px;
        /* Memberi ruang untuk scrollbar jika terlihat */
        /* Menyembunyikan scrollbar untuk tampilan lebih bersih */
        scrollbar-width: none;
        /* Firefox */
        -ms-overflow-style: none;
        /* Internet Explorer 10+ */
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


<!-- lutfiambar 17-8-25 css chatbot hr -->
<style>
    body {
        /* background-color: #f3f4f6;
        height: 100vh;
        margin: 0;
        display: flex;
        flex-direction: column; */
        overflow: hidden;
        color: black;
    }

    /* Sidebar: scrollable history */
    #sidebar {
        display: flex;
        flex-direction: column;
        height: 100vh;
        overflow-y: auto;
        padding: 8px;
        background: #f8f9fa;
    }

    /* Chat Area: fixed height */
    .column-set {
        display: flex;
        flex-direction: column;
        height: 100vh;
        /* padding: 10px; */
    }

    .chat-area {
        /* flex-grow: 1; */
        display: flex;
        flex-direction: column;
        background-color: transparent;
        overflow: hidden;
        /* Prevent overflow on the main area */
        min-height: 70vh;
    }

    .chat-messages {
        flex: 1;
        max-height: 50vh;
        /* Batasi tinggi maksimum ke 50% dari tinggi tampilan */
        overflow-y: auto;
        /* Scrollbar jika melebihi tinggi area */
        padding: 10px;
    }

    .message {
        margin-bottom: 15px;
        display: flex;
    }

    .message.user {
        justify-content: flex-end;
        /* Pesan pengguna berada di sisi kanan */
    }

    .message.bot {
        justify-content: flex-start;
        /* Pesan pengguna berada di sisi kanan */
    }

    .message-content {
        max-width: 80%;
        /* Memastikan konten tidak lebih lebar dari area */
        padding: 10px 15px;
        border-radius: 12px;
        color: black;
    }

    .message.loader_chat .message-content {
        background-color: #ffffff;
        /* Warna latar belakang untuk pesan bot */
        text-align: left;
    }

    .message.bot .message-content {
        background-color: #ffffff;
        /* Warna latar belakang untuk pesan bot */
        text-align: left;
    }


    .message.user .message-content {
        background-color: #DDDDDD;
        /* Warna latar belakang untuk pesan pengguna */
        text-align: left;
        white-space: pre-wrap;
        /* Mempertahankan formatting tapi tetap wrap */
        word-wrap: break-word;
        /* Untuk kompatibilitas lama */
        overflow-wrap: break-word;
        /* Standar modern */
        word-break: break-word;
        /* Memecah kata panjang */

        /* Tambahan styling untuk memperjelas */
        max-width: 80%;
        /* Pastikan tidak melebihi container */
    }

    .message-form {
        padding: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        /* Jarak antar elemen dalam form */
    }

    .message-form input {
        flex: 1;
        /* Memastikan input mengisi ruang yang tersedia */
        border-radius: 20px;
        padding: 10px 15px;
        border: 1px solid #ced4da;
    }

    .message-form select {
        max-width: 200px;
        /* Lebar maksimum untuk select */
        border-radius: 20px;
        padding: 10px;
    }

    .message-form button {
        border-radius: 50%;
        width: 45px;
        height: 50px;
        background-color: #CB0E0E;
        border: none;
        color: white;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .message-form button:hover {
        background-color: #AB0606;
        /* Warna saat hover */
    }


    .message-form select {
        max-width: 100%;
        /* Lebar penuh pada layar kecil */
        margin-bottom: 10px;
        /* Jarak bawah pada select */
    }

    .message-form input {
        margin-bottom: 10px;
        /* Jarak bawah pada input */
    }

    .message-form .d-flex {
        flex-direction: row;
        /* Tetap baris pada input dan tombol */
    }

    .message-form button {
        width: auto;
        /* Kembali ke ukuran otomatis untuk tombol */
    }


    /* LOADER*/
    .container-loader {
        --uib-size: 40px;
        --uib-color: black;
        --uib-speed: 2.5s;
        --uib-dot-size: calc(var(--uib-size) * 0.18);
        position: relative;
        top: 15%;
        left: 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: var(--uib-size);
        height: var(--uib-size);
    }

    .dot {
        position: absolute;
        top: 0;
        left: 0;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        width: 100%;
        height: 100%;
    }

    .dot::before {
        content: '';
        display: block;
        height: calc(var(--uib-size) * 0.22);
        width: calc(var(--uib-size) * 0.22);
        border-radius: 50%;
        background-color: var(--uib-color);
        transition: background-color 0.3s ease;
    }

    .dot:nth-child(1) {
        animation: leapFrog var(--uib-speed) ease infinite;
    }

    .dot:nth-child(2) {
        transform: translateX(calc(var(--uib-size) * 0.4));
        animation: leapFrog var(--uib-speed) ease calc(var(--uib-speed) / -1.5) infinite;
        }

    .dot:nth-child(3) {
        transform: translateX(calc(var(--uib-size) * 0.8)) rotate(0deg);
        animation: leapFrog var(--uib-speed) ease calc(var(--uib-speed) / -3) infinite;
    }

    @keyframes leapFrog {
    0% {
        transform: translateX(0) rotate(0deg);
    }

    33.333% {
        transform: translateX(0) rotate(180deg);
    }

    66.666% {
        transform: translateX(calc(var(--uib-size) * -0.38)) rotate(180deg);
    }

    99.999% {
        transform: translateX(calc(var(--uib-size) * -0.78)) rotate(180deg);
    }

    100% {
        transform: translateX(0) rotate(0deg);
    }
    }
</style>
<style>
    .chat-box {
        display: flex;
        flex-direction: column;
        background: #ffffff;
        padding: 10px;
        border-radius: 30px;
        position: relative;
    }

    .chat-input {
        background: transparent;
        border: 1px;
        color: black;
        padding: 10px;
        outline: none;
        width: 100%;

        /* Tambahan untuk auto-grow & scroll */
        max-height: 200px;
        overflow-y: auto;
        resize: none;
        box-sizing: border-box;
        font-size: 1rem;
        line-height: 1.5;
        transition: height 0.2s ease;
    }

    /* .chat-input::placeholder {
    color: black;
    } */

    .chat-buttons {
        display: flex;
        gap: 8px;
        padding-top: 8px;
        justify-content: end;
    }

    .chat-buttons button {
        background: transparent;
        border: 1px solid #444;
        color: black;
        padding: 6px 12px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 14px;
    }

    .chat-buttons button i {
        font-size: 14px;
    }

    /* IMAGE PREVIEW DI ATAS INPUT */
    .image-preview-container {
        display: none;
        margin-bottom: 10px;
    }

    .image-preview {
        display: flex;
        align-items: center;
        background: #1f1f1f;
        border-radius: 10px;
        padding: 4px;
        position: relative;
        max-width: fit-content;
    }

    .image-preview img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 2px;
    }

    .remove-image {
        background: red;
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        right: 0;
        top: 0;
        cursor: pointer;
    }

    #fileInput {
        display: none;
    }

    .list-group-item {
        cursor: pointer !important;
    }

    .chat-preview {
        white-space: pre-wrap;
        /* Mempertahankan formatting tapi tetap wrap */
        word-wrap: break-word;
        /* Untuk kompatibilitas lama */
        overflow-wrap: break-word;
        /* Standar modern */
        word-break: break-word;
        /* Memecah kata panjang */

        /* Tambahan styling untuk memperjelas */
        max-width: 100%;
        /* Pastikan tidak melebihi container */
    }

    @media (min-width: 576px) and (max-width: 991px) {
        .chat-area {
            min-height: 40vh !important;
            /* Batasi tinggi minimum ke 50% dari tinggi tampilan */
        }

        .chat-messages {
            max-height: 40vh !important;
            /* Batasi tinggi maksimum ke 40% dari tinggi tampilan */
        }
    }
</style>