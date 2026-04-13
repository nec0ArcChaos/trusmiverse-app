        <!-- Tambahan CSS -->
        <style>
            #send-chat {
                display: flex;
                justify-content: space-between;
                gap: 4px;
            }

            .send-input {
                width: 100%;
                height: 38px;
                margin-top: 4px;
            }

            .send-input input {
                border-radius: 10px;
            }

            .border-10 {
                border-radius: 10px !important;
            }

            .btn-send-custom {
                width: 40px;
                height: 34px;
                border: none;
                cursor: pointer;
                background-color: #7D89B3;
                box-sizing: border-box;
                padding: 4px;
                position: relative;
                top: 5px;
            }

            #rekomendasi-chat {
                display: flex;
                gap: 8px;
                padding-bottom: 12px;
                flex-wrap: nowrap;
                color: #fff;
                /* HAPUS PROPERTI OVERFLOW DARI SINI */
                cursor: grab;
            }

            .scroll-wrapper {
                display: flex;
                overflow-x: auto;
                /* PERBAIKI 1: Pastikan overflow di handle oleh wrapper */
                gap: 8px;
                padding: 5px 0;
                width: 100%;
                /* PERBAIKI 2: Pastikan lebar penuh */
                scrollbar-width: none;
                -ms-overflow-style: none;
                -webkit-overflow-scrolling: touch;
                /* Untuk smooth scroll mobile */
            }

            .scroll-wrapper::-webkit-scrollbar {
                width: 0px;
                background: transparent;
            }

            .item-shortcut {
                flex-shrink: 0;
                border: 1px solid #fff;
                cursor: pointer;
                align-content: center;
                padding: 4px 8px 4px 8px;
                border: #ffffff 3px solid;
                border-radius: 20px !important;
            }

            .scroll-wrapper,
            .item-shortcut {
                user-select: none;
                /* Mencegah teks terseleksi saat drag */
                -webkit-user-select: none;
                -ms-user-select: none;
            }

            .text-purple {
                color: #9B9197;
            }
        </style>

        <style>
            body {
                /* background-color: #f3f4f6;
            height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column; */
                /* overflow: hidden; */
                color: black;
            }

            /* Sidebar: scrollable history */
            .sidebar {
                display: flex;
                flex-direction: column;
                height: 100vh;
                overflow-y: auto;
                /* Enable scrolling */
                padding: 10px;
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
                /* min-height: 70vh; */
                height: 318px;
            }

            .chat-messages {
                flex: 1;
                /* max-height: 50vh; */
                max-height: 240px;
                /* Batasi tinggi maksimum ke 50% dari tinggi tampilan */
                /* overflow-y: auto; */
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
                text-align: right;
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
                border: none;
                color: black;
                padding: 10px;
                outline: none;
                width: 100%;
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
                border: 0px solid #444;
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

        <div class="col-md-4 my-2">
            <div class="card">
                <div class="card-body" style="background: rgb(241,230,238); background: linear-gradient(90deg, rgba(241,230,238,1) 0%, rgba(236,233,243,1) 35%, rgba(232,235,247,1) 100%);">
                    <div class="chat-area">
                        <div class="chat-messages-container" style="overflow-y:auto; height: 100%; max-height: calc(50vh - 130px);">
                            <div class="text-center mb-3 mt-3">
                                <h6>Hello, <?php echo $this->session->userdata('nama'); ?> </h6>
                                <p class="small text-purple">I'm Nira AI, ready to assist you with anything you need, from answering questions to providing recommendation. Let's get started! </p>
                            </div>
                            <div class="message bot d-none" id="awalanChatting">
                                <div class="message-content">Halo! Apa yang bisa saya bantu hari ini?</div>
                            </div>
                            <div class="chat-messages mb-2" id="chatMessages">
                                <div class="message bot">
                                    <div class="message-content">Halo! Apa yang bisa saya bantu hari ini?</div>
                                </div>
                            </div>
                        </div>
                        <div id="rekomendasi-chat" class="small mt-3">

                            <div class="scroll-wrapper">
                                <div class="item-shortcut text-purple" data-value="1" onclick="shortcutChat(this)">
                                    <i class="bi bi-brightness-high"></i>&nbsp;Motivasi Harian
                                </div>
                                <div class="item-shortcut text-purple" data-value="2" onclick="shortcutChat(this)">
                                    <i class="bi bi-lightbulb"></i>&nbsp;Cara Meningkatkan Produktivitas
                                </div>
                                <div class="item-shortcut text-purple" data-value="3" onclick="shortcutChat(this)">
                                    <i class="bi bi-card-image"></i>&nbsp;Analisis Gambar ini
                                </div>
                                <!-- Tambahkan lebih banyak item jika perlu -->
                            </div>

                            <script>
                                function shortcutChat(el) {
                                    $('.item-shortcut').removeClass('active');
                                    $(el).addClass('active');

                                    let text = $(el).text().trim();
                                    $('#userMessage').val(text);
                                }
                            </script>
                        </div>

                        <div class="chat-box">
                            <form id="messageForm" enctype="multipart/form-data">
                                <!-- Preview Gambar DI ATAS INPUT -->
                                <div id="imagePreviewContainer" class="image-preview-container">
                                    <div class="image-preview">
                                        <img id="imagePreview" src="" alt="Preview" />
                                        <button class="remove-image" onclick="removeImage('preview')">
                                            &times;
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" id="sessionId" name="session_id" />
                                <div class="row">
                                    <div class="col">
                                        <textarea
                                            type="text"
                                            class="chat-input"
                                            id="userMessage"
                                            placeholder="Tanyakan apa saja....."
                                            rows="1"
                                            style="resize: none"></textarea>
                                    </div>
                                    <div class="col-auto ps-0">
                                        <!-- Navigasi Tombol -->
                                        <div class="chat-buttons">
                                            <button style="background-color: #7D89B3; color: white;" onclick="document.getElementById('fileInput').click();">
                                                <i class="bi bi-upload"></i>
                                            </button>
                                            <button style="background-color: #7D89B3; color: white;"><i class="bi bi-send-fill icon-send"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <!-- File Input untuk Upload Gambar -->
                                <input
                                    type="file"
                                    id="fileInput"
                                    accept="image/*"
                                    onchange="previewImage(event)" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>