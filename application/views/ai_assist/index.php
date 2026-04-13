<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle; ?> <img src="https://trusmicorp.com/rspproject/assets/icon/ai-black.png"></h5>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-3 col-lg-2 sidebar bg-light d-none d-md-block" id="sidebar">
                <button id="closeSidebar" class="btn mb-3 d-none" style="background-color: #ffffff; margin-left: 15px;">x Close</button>
                <button id="newChatButton" class="btn mb-3 text-white" style="background-color: #CB0E0E; margin-left: 15px;">+ New Chat</button>
                <ul class="list-group" id="chatSessions" style="margin-left: 15px; margin-bottom: 30vh;"></ul>
            </div>

            <!-- Chat Area -->
            <div class="col-12 col-md-9 col-lg-10 col-xl-10 col-xxl-10 column-set">
                <div class="container" style="overflow-y: auto;">
                    <div class="row" style="margin-top: -30px;">
                        <div class="col">
                            <!-- Mobile Toggle Button -->
                            <button id="toggleSidebar" class="btn btn-lg d-md-none position-absolute text-start" style="margin-left: -10px; width: 20%; background-color: transparent; text-align: left;"><i class="bi bi-clock-history"></i></button>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 50px;">
                        <div class="col">
                            <div class="chat-area">
                                <div class="chat-messages mb-2" id="chatMessages">
                                    <div class="message bot">
                                        <div class="message-content">Halo! Apa yang bisa saya bantu hari ini?</div>
                                    </div>
                                </div>
                                <!-- <form id="messageForm" enctype="multipart/form-data">
                                <input type="hidden" id="sessionId" name="session_id">
                                <div class="form-group row">
                                    <div class="col-8 col-sm-10">
                                        <textarea class="form-control me-2" id="userMessage" style="border-radius: 1.25rem; height: 45px;" rows="1" placeholder="Tulis pertanyaanmu di sini..."></textarea>
                                        <p id="fileNameDisplay" class="ms-2 me-2" style="margin-top: 5px; font-size: 14px; color: #555;"></p>
                                    </div>
                                    <div class="col-2 col-sm-1" style="margin-right: -15px;">
                                        <input type="file" id="fileInput" name="file" accept="image/*" class="d-none">
                                        <button type="button" id="uploadBtn" class="btn" style="border-radius: 1.25rem; width: 100%; background-color: #CB0E0E;">
                                            <i class="bi bi-upload" style="color: white;"></i>
                                        </button>
                                    </div>
                                    <div class="col-2 col-sm-1">
                                        <button type="submit" class="btn " style="border-radius: 1.25rem; width: 100%; line-height: normal; background-color: #CB0E0E;">
                                            <img src="https://trusmicorp.com/rspproject/assets/icon/send.png" style="filter: invert(1); height: 20px;">
                                        </button>
                                    </div>
                                </div>
                            </form> -->
                                    <div class="chat-box">
                                        <form id="messageForm" enctype="multipart/form-data">
                                            <!-- Preview Gambar DI ATAS INPUT -->
                                            <div id="imagePreviewContainer" class="image-preview-container">
                                                <div class="image-preview">
                                                    <img id="imagePreview" src="" alt="Preview" />
                                                    <button class="remove-image" onclick="removeImage()">
                                                        &times;
                                                    </button>
                                                </div>
                                            </div>
                                            <input type="hidden" id="sessionId" name="session_id" />
                                            <textarea
                                                type="text"
                                                class="chat-input"
                                                id="userMessage"
                                                placeholder="Tanyakan apa saja....."
                                                rows="1"
                                                style="resize: none"></textarea>
                                            <!-- Navigasi Tombol -->
                                            <div class="chat-buttons">
                                                <button onclick="document.getElementById('fileInput').click();">
                                                    <i class="bi bi-plus-lg"></i>
                                                </button>
                                                <button><i class="bi bi-send"></i> Submit</button>
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

            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="editChatModal" tabindex="-1" aria-labelledby="editChatModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editChatModalLabel">Edit Chat Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editChatId">
                <input type="text" class="form-control" id="editChatTitle" placeholder="Enter new title">
            </div>
            <div class="modal-footer gap-1">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn" id="saveChatTitle" style="background-color: #CB0E0E; color: white;">Save</button>
            </div>
        </div>
    </div>
</div>