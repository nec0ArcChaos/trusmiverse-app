<style>
    body {
        background-color: #f4f7f6;
    }

    .modal-content {
        border-radius: 12px;
        overflow: hidden;
        border: none;
    }

    .modal-header {
        background-color: #0056b3;
        color: white;
        padding: 12px 20px;
    }

    /* Sidebar Styles */
    .sidebar {
        border-right: 1px solid #eee;
        min-height: 450px;
        background: white;
        padding: 0;
    }

    .nav-link {
        color: #666;
        padding: 12px 20px;
        border-bottom: 1px solid #f8f9fa;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .nav-link.active {
        background-color: #f0f7ff;
        color: #0056b3;
        font-weight: 600;
        border-right: 3px solid #0056b3;
    }

    .loading-spinner {
        width: 18px;
        height: 18px;
        border: 2px solid #ccc;
        border-top: 2px solid #0056b3;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    /* Dropzone Styles */
    .upload-area {
        border: 2px dashed #e0e0e0;
        border-radius: 10px;
        padding: 60px 20px;
        text-align: center;
        background-color: #fff;
        cursor: pointer;
        transition: 0.3s;
        margin-top: 40px;
    }

    .upload-area:hover {
        border-color: #0056b3;
        background-color: #fbfcfe;
    }

    .upload-icon {
        font-size: 40px;
        color: #0056b3;
        background: #f0f7ff;
        width: 70px;
        height: 70px;
        line-height: 70px;
        border-radius: 50%;
        margin: 0 auto 15px;
    }

    /* Progress Bar Footer */
    .footer-progress {
        padding: 15px 20px;
        border-top: 1px solid #eee;
        background: #fff;
    }

    .progress {
        height: 8px;
        border-radius: 10px;
        background-color: #e9ecef;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* File Uploaded View (Hidden by default) */
    #uploaded-view {
        display: none;
    }

    .file-card {
        border: 1px solid #dee2e6;
        padding: 15px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fff;
    }
</style>
<div class="container mt-5">
    <div class="modal-dialog modal-xl shadow">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title fs-6"><i class="bi bi-plus-square-fill me-2"></i> Input Data Event</h5>
                <button type="button" class="btn-close btn-close-white" aria-label="Close"></button>
            </div>

            <div class="row g-0">
                <div class="col-md-3 sidebar">
                    <div class="nav flex-column">
                        <a class="nav-link active" href="#">GRD <div class="loading-spinner"></div></a>
                        <a class="nav-link" href="#">Interview <i class="bi bi-dash-circle text-muted"
                                style="font-size: 14px;"></i></a>
                        <a class="nav-link" href="#">MoM <i class="bi bi-dash-circle text-muted"></i></a>
                        <a class="nav-link" href="#">Genba <i class="bi bi-dash-circle text-muted"></i></a>
                        <a class="nav-link" href="#">co&co <i class="bi bi-dash-circle text-muted"></i></a>
                        <a class="nav-link" href="#">Sharing Leader <i class="bi bi-dash-circle text-muted"></i></a>
                        <a class="nav-link" href="#">Improvement Sistem <i class="bi bi-dash-circle text-muted"></i></a>
                        <a class="nav-link" href="#">Briefing <i class="bi bi-dash-circle text-muted"></i></a>
                    </div>
                </div>

                <div class="col-md-9 p-4 bg-white">
                    <h6 class="fw-bold mb-1">Unggah Dokumen GRD</h6>
                    <p class="text-muted small">Silakan unggah 1 file GRD untuk kebutuhan inputan data analisis Event
                        Head.</p>

                    <div id="dropzone-view" class="upload-area" onclick="document.getElementById('fileInput').click()">
                        <div class="upload-icon">
                            <i class="bi bi-cloud-arrow-up"></i>
                        </div>
                        <p class="mb-0">
                            <span class="text-primary fw-bold">Klik untuk Unggah</span> atau tarik dan lepas file nya
                            disini
                        </p>
                        <small class="text-muted">PDF, Excel, Spreadsheet (max. 10mb)</small>
                        <input type="file" id="fileInput" name="file_grd" hidden onchange="handleFileUpload()">

                    </div>

                    <div id="uploaded-view" class="mt-4">
                        <div class="file-card">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-file-earmark-excel-fill text-success fs-3 me-3"></i>
                                <div>
                                    <div id="file-name" class="fw-bold small">dokumen_grd_2023.xlsx</div>
                                    <small class="text-muted">2.4 MB</small>
                                </div>
                            </div>
                            <button class="btn btn-sm btn-outline-danger" onclick="resetUpload()">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </div>
                        <div class="mt-4 text-end">
                            <button id="btn-proses" class="btn btn-primary">
                                Proses Data
                            </button>

                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-progress">
                <div class="row align-items-center">
                    <div class="col-3">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <small class="text-muted fw-bold">60% Total Progress</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>



    function handleFileUpload() {
        const input = document.getElementById('fileInput');
        const dropzone = document.getElementById('dropzone-view');
        const uploadedView = document.getElementById('uploaded-view');
        const fileNameDisplay = document.getElementById('file-name');

        if (input.files.length > 0) {
            fileNameDisplay.innerText = input.files[0].name;
            dropzone.style.display = 'none';
            uploadedView.style.display = 'block';
        }
    }



    function resetUpload() {
        document.getElementById('fileInput').value = "";
        document.getElementById('dropzone-view').style.display = 'block';
        document.getElementById('uploaded-view').style.display = 'none';
    }
</script>