    <link href="<?= base_url(); ?>assets/nice-select2/css/nice-select2.css" rel="stylesheet">
    <!-- button export -->
    <link rel="stylesheet" href="<?= base_url('assets/data-table/css/buttons.dataTables.min.css') ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
    <link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/font_awesome/css/all.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/clockpicker/jquery-clockpicker.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/jquery-confirm/jquery-confirm.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.min.css" />

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