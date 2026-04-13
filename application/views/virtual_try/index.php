<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Try-On</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .product-card {
            transition: transform 0.2s;
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-card.selected {
            border: 3px solid #0d6efd;
            box-shadow: 0 0 15px rgba(13, 110, 253, 0.3);
        }

        .preview-image {
            max-height: 300px;
            object-fit: cover;
        }

        .loading-spinner {
            display: none;
        }

        #resultContainer {
            display: none;
        }

        .result-image-container {
            position: relative;
        }

        .result-image-container img {
            max-height: 400px;
            object-fit: contain;
        }

        .download-btn {
            margin-top: 15px;
        }

        .limit-info-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .limit-counter {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .limit-reached-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .limit-reached-modal {
            background: white;
            padding: 30px;
            border-radius: 15px;
            max-width: 500px;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Overlay untuk limit reached -->
    <div class="limit-reached-overlay" id="limitReachedOverlay">
        <div class="limit-reached-modal">
            <i class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
            <h3>Batas Try-On Tercapai</h3>
            <p class="text-muted">Anda telah mencapai batas maksimal 2x virtual try-on.</p>
            <p>Silakan hapus riwayat try-on sebelumnya jika ingin mencoba lagi.</p>
            <div class="mt-4">
                <a href="<?= base_url('virtual_try/history') ?>" class="btn btn-primary me-2">
                    <i class="fas fa-history"></i> Lihat Riwayat
                </a>
                <button class="btn btn-outline-secondary" onclick="$('#limitReachedOverlay').fadeOut()">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Virtual Try-On</h1>
            <a href="<?= base_url('virtual_try/history') ?>" class="btn btn-outline-primary">
                <i class="fas fa-history"></i> Riwayat Try-On
            </a>
        </div>

        <!-- Limit Info Box -->
        <div class="limit-info-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5><i class="fas fa-info-circle"></i> Kuota Virtual Try-On Anda</h5>
                    <p class="mb-0">Anda dapat melakukan virtual try-on hingga <strong>2 kali</strong>. Hapus riwayat untuk mencoba lagi.</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="limit-counter" id="limitCounter">
                        <span id="remainingCount"><?= $user_limit_info['remaining'] ?></span> / 2
                    </div>
                    <small>Tersisa</small>
                </div>
            </div>

            <?php if ($user_limit_info['is_limit_reached']): ?>
                <div class="alert alert-warning mt-3 mb-0">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Kuota Habis!</strong> Silakan hapus riwayat try-on untuk mencoba lagi.
                </div>
            <?php endif; ?>
        </div>

        <!-- Alert untuk Notifikasi -->
        <div id="alertContainer"></div>

        <div class="row">
            <!-- Kolom Kiri: Input Model & Preview -->
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">1. Upload Foto Model</h5>
                    </div>
                    <div class="card-body">
                        <form id="uploadForm" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="modelImage" class="form-label">Pilih Foto Model</label>
                                <input class="form-control" type="file" id="modelImage" name="model_image" accept="image/jpeg,image/png" required <?= $user_limit_info['is_limit_reached'] ? 'disabled' : '' ?>>
                                <div class="form-text">
                                    Format yang didukung: JPG, PNG. Maksimal 2MB.
                                </div>
                            </div>

                            <!-- Preview Gambar Model -->
                            <div class="mb-3">
                                <label class="form-label">Preview Foto Model</label>
                                <div id="modelPreview" class="text-center border rounded p-3 bg-light">
                                    <span class="text-muted">Preview akan muncul di sini</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Pilihan Pakaian -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">2. Pilih Pakaian</h5>
                    </div>
                    <div class="card-body">
                        <div class="row" id="productGrid">
                            <!-- Produk akan dimuat via JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Proses & Hasil -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <button id="processBtn" class="btn btn-warning btn-lg px-5" disabled>
                    <span class="spinner-border spinner-border-sm loading-spinner" role="status"></span>
                    <i class="fas fa-magic"></i> Proses Virtual Try-On
                </button>
                <p class="text-muted mt-2" id="processingInfo" style="display: none;">
                    <small>Sedang memproses... Ini mungkin memakan waktu hingga 45 detik</small>
                </p>
            </div>
        </div>

        <!-- Container Hasil -->
        <div id="resultContainer" class="mt-5">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-check-circle"></i> Hasil Virtual Try-On</h5>
                </div>
                <div class="card-body text-center">
                    <div id="resultContent">
                        <!-- Hasil akan ditampilkan di sini -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Data limit dari PHP
            let userLimitInfo = {
                is_limit_reached: <?= $user_limit_info['is_limit_reached'] ? 'true' : 'false' ?>,
                current_count: <?= $user_limit_info['current_count'] ?>,
                max_limit: <?= $user_limit_info['max_limit'] ?>,
                remaining: <?= $user_limit_info['remaining'] ?>
            };

            // Data produk pakaian
            const products = [{
                    id: 1,
                    name: "HEM Batik",
                    image: "https://trusmiverse.com/apps/assets/uploads/batik/batik4.png",
                    price: "Rp 299.000",
                    category: "Atasan"
                }, {
                    id: 2,
                    name: "Batik 1",
                    image: "https://trusmiverse.com/apps/assets/uploads/batik/batik2.jpg",
                    price: "Rp 299.000",
                    category: "Atasan"
                },
                {
                    id: 3,
                    name: "Batik 2",
                    image: "https://trusmiverse.com/apps/assets/uploads/batik/batik3.jpg",
                    price: "Rp 399.000",
                    category: "Atasan"
                },
                {
                    id: 4,
                    name: "Batik 3",
                    image: "https://trusmiverse.com/apps/assets/uploads/batik/batik1.jpg",
                    price: "Rp 259.000",
                    category: "Atasan"
                }
            ];

            let selectedProduct = null;
            let modelImageFile = null;
            let currentTryonId = null;

            // Update UI limit info
            function updateLimitUI(limitInfo) {
                userLimitInfo = limitInfo;
                $('#remainingCount').text(limitInfo.remaining);

                if (limitInfo.is_limit_reached) {
                    $('#modelImage').prop('disabled', true);
                    $('.select-product').prop('disabled', true);
                    $('#processBtn').prop('disabled', true).html('<i class="fas fa-ban"></i> Kuota Habis');

                    // Tampilkan alert di limit box
                    if ($('.limit-info-box .alert-warning').length === 0) {
                        $('.limit-info-box').append(`
                            <div class="alert alert-warning mt-3 mb-0">
                                <i class="fas fa-exclamation-triangle"></i> 
                                <strong>Kuota Habis!</strong> Silakan hapus riwayat try-on untuk mencoba lagi.
                            </div>
                        `);
                    }
                } else {
                    $('#modelImage').prop('disabled', false);
                    $('.select-product').prop('disabled', false);
                    $('.limit-info-box .alert-warning').remove();
                }
            }

            // Render produk ke grid
            function renderProducts() {
                const productGrid = $('#productGrid');
                productGrid.empty();

                products.forEach(product => {
                    const isDisabled = userLimitInfo.is_limit_reached ? 'disabled' : '';
                    const productCard = `
                        <div class="col-sm-6 mb-3">
                            <div class="card product-card" data-product-id="${product.id}">
                                <img src="${product.image}" class="card-img-top" alt="${product.name}" style="height: 200px; object-fit: fill;">
                                <div class="card-body">
                                    <h6 class="card-title">${product.name}</h6>
                                    <p class="card-text">
                                        <small class="text-muted">${product.category}</small><br>
                                        <strong class="text-primary">${product.price}</strong>
                                    </p>
                                    <button class="btn btn-outline-primary btn-sm select-product" 
                                            data-product-id="${product.id}" ${isDisabled}>
                                        Pilih
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    productGrid.append(productCard);
                });
            }

            // Preview gambar model
            $('#modelImage').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Validasi file
                    if (file.size > 2 * 1024 * 1024) {
                        showAlert('Ukuran file maksimal 2MB', 'danger');
                        $(this).val('');
                        return;
                    }

                    if (!file.type.match('image/jpeg') && !file.type.match('image/png')) {
                        showAlert('Format file harus JPG atau PNG', 'danger');
                        $(this).val('');
                        return;
                    }

                    modelImageFile = file;

                    // Tampilkan preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#modelPreview').html(`
                            <img src="${e.target.result}" class="img-fluid preview-image rounded" alt="Preview Model">
                            <div class="mt-2">
                                <small class="text-success"><i class="fas fa-check-circle"></i> Gambar berhasil diupload</small>
                            </div>
                        `);
                    };
                    reader.readAsDataURL(file);
                    checkProcessButton();
                }
            });

            // Pilih produk
            $(document).on('click', '.select-product', function() {
                if (userLimitInfo.is_limit_reached) {
                    $('#limitReachedOverlay').fadeIn();
                    return;
                }

                const productId = $(this).data('product-id');
                selectedProduct = products.find(p => p.id === productId);

                // Update UI
                $('.product-card').removeClass('selected');
                $(this).closest('.product-card').addClass('selected');
                $(this).html('<i class="fas fa-check"></i> Terpilih').removeClass('btn-outline-primary').addClass('btn-success');

                $('.select-product').not(this).html('Pilih').removeClass('btn-success').addClass('btn-outline-primary');

                checkProcessButton();
            });

            // Cek apakah tombol proses bisa diaktifkan
            function checkProcessButton() {
                if (userLimitInfo.is_limit_reached) {
                    $('#processBtn').prop('disabled', true).html('<i class="fas fa-ban"></i> Kuota Habis');
                    return;
                }

                if (modelImageFile && selectedProduct) {
                    $('#processBtn').prop('disabled', false).html('<i class="fas fa-magic"></i> Proses Virtual Try-On');
                } else {
                    $('#processBtn').prop('disabled', true).html('<i class="fas fa-magic"></i> Proses Virtual Try-On');
                }
            }

            // Proses Virtual Try-On
            $('#processBtn').on('click', function() {
                if (userLimitInfo.is_limit_reached) {
                    $('#limitReachedOverlay').fadeIn();
                    return;
                }

                if (!modelImageFile || !selectedProduct) {
                    showAlert('Silakan lengkapi foto model dan pilih pakaian', 'warning');
                    return;
                }

                // Tampilkan loading
                const btn = $(this);
                btn.prop('disabled', true);
                $('.loading-spinner').show();
                $('#processingInfo').show();
                $('#resultContainer').hide();

                // Siapkan FormData
                const formData = new FormData();
                formData.append('model_image', modelImageFile);
                formData.append('garment_image_url', selectedProduct.image);
                formData.append('product_id', selectedProduct.id);

                // Kirim ke controller
                $.ajax({
                    url: '<?= base_url("virtual_try_dev/process") ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    timeout: 60000,
                    success: function(response) {
                        $('.loading-spinner').hide();
                        $('#processingInfo').hide();
                        btn.prop('disabled', false);

                        if (response.success) {
                            currentTryonId = response.tryon_id;
                            showResult(response);

                            // Update limit info
                            if (response.limit_info) {
                                updateLimitUI(response.limit_info);
                            }

                            showAlert('Virtual try-on berhasil! Hasil telah disimpan.', 'success');
                        } else {
                            if (response.limit_reached) {
                                updateLimitUI(response.limit_info);
                                $('#limitReachedOverlay').fadeIn();
                            }
                            showAlert(response.error || 'Terjadi kesalahan saat memproses', 'danger');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('.loading-spinner').hide();
                        $('#processingInfo').hide();
                        btn.prop('disabled', false);
                        showAlert('Terjadi kesalahan: ' + error, 'danger');
                    }
                });
            });

            // Tampilkan hasil
            function showResult(response) {
                const resultContent = $('#resultContent');

                const limitWarning = response.limit_info && response.limit_info.remaining === 0 ?
                    '<div class="alert alert-warning mt-3"><i class="fas fa-exclamation-triangle"></i> Ini adalah try-on terakhir Anda. Hapus riwayat untuk mencoba lagi.</div>' : '';

                resultContent.html(`
                    <div class="row">
                        <div class="col-md-4">
                            <h6>Foto Model Asli</h6>
                            <div class="result-image-container">
                                <img src="${response.original_model_url}" class="img-fluid rounded shadow" alt="Model Original">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6>Pakaian yang Dipilih</h6>
                            <div class="result-image-container">
                                <img src="${selectedProduct.image}" class="img-fluid rounded shadow" alt="Pakaian">
                            </div>
                            <p class="mt-2"><strong>${selectedProduct.name}</strong></p>
                            <p class="text-primary">${selectedProduct.price}</p>
                        </div>
                        <div class="col-md-4">
                            <h6>Hasil Try-On</h6>
                            <div class="result-image-container">
                                <img src="${response.result_image_url}" class="img-fluid rounded shadow" alt="Hasil Try-On">
                            </div>
                            <div class="mt-3 d-flex flex-column gap-2">
                                <a href="<?= base_url('virtual_try/download/') ?>${response.tryon_id}" 
                                   class="btn btn-success download-btn" target="_blank">
                                    <i class="fas fa-download"></i> Download Hasil
                                </a>
                                <button class="btn btn-outline-secondary" onclick="location.reload()">
                                    <i class="fas fa-redo"></i> Coba Lagi
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    ${limitWarning}
                    
                    <div class="mt-4 p-3 bg-light rounded">
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> 
                            ID Try-On: <strong>${response.tryon_id}</strong> | 
                            Hasil telah disimpan dan dapat diakses melalui menu Riwayat Try-On
                        </small>
                    </div>
                `);

                // Tampilkan container hasil
                $('#resultContainer').show();

                // Scroll ke view hasil
                $('html, body').animate({
                    scrollTop: $('#resultContainer').offset().top - 20
                }, 800);
            }

            // Fungsi untuk menampilkan alert
            function showAlert(message, type) {
                const alert = `
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
                $('#alertContainer').html(alert);

                setTimeout(function() {
                    $('.alert').fadeOut('slow', function() {
                        $(this).remove();
                    });
                }, 5000);
            }

            // Inisialisasi
            renderProducts();
            checkProcessButton();
        });
    </script>
</body>

</html>