<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Virtual Try-On</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .history-card {
            transition: transform 0.2s;
        }

        .history-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .history-image {
            height: 200px;
            object-fit: cover;
        }

        .thumbnail-container {
            position: relative;
            overflow: hidden;
        }

        .thumbnail-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
            padding: 10px;
            color: white;
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
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-history"></i> Riwayat Virtual Try-On</h1>
            <a href="<?= base_url('virtual_try') ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Try-On Baru
            </a>
        </div>

        <!-- Limit Info Box -->
        <div class="limit-info-box" id="limitInfoBox">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5><i class="fas fa-info-circle"></i> Kuota Virtual Try-On Anda</h5>
                    <p class="mb-0">Anda telah menggunakan <strong id="usedCount"><?= $user_limit_info['current_count'] ?></strong> dari <strong>2</strong> kuota try-on.
                        <?php if ($user_limit_info['is_limit_reached']): ?>
                            <br><strong>Hapus riwayat untuk mendapatkan kuota kembali.</strong>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="limit-counter">
                        <span id="remainingCount"><?= $user_limit_info['remaining'] ?></span> / 2
                    </div>
                    <small>Tersisa</small>
                </div>
            </div>

            <?php if ($user_limit_info['is_limit_reached']): ?>
                <div class="alert alert-warning mt-3 mb-0">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Kuota Habis!</strong> Hapus minimal 1 riwayat untuk mencoba lagi.
                </div>
            <?php else: ?>
                <div class="alert alert-success mt-3 mb-0">
                    <i class="fas fa-check-circle"></i>
                    Anda masih memiliki <strong><?= $user_limit_info['remaining'] ?></strong> kuota tersisa.
                </div>
            <?php endif; ?>
        </div>

        <div id="alertContainer"></div>

        <?php if (empty($history)): ?>
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-5x text-muted mb-3"></i>
                <h4 class="text-muted">Belum ada riwayat try-on</h4>
                <p class="text-muted">Mulai coba pakaian virtual untuk melihat riwayatnya di sini</p>
                <a href="<?= base_url('virtual_try') ?>" class="btn btn-primary mt-3">
                    <i class="fas fa-magic"></i> Mulai Virtual Try-On
                </a>
            </div>
        <?php else: ?>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Total: <span class="badge bg-primary"><?= count($history) ?></span> riwayat</h5>
                <?php if (count($history) > 0): ?>
                    <button class="btn btn-outline-danger btn-sm" id="deleteAllBtn">
                        <i class="fas fa-trash-alt"></i> Hapus Semua
                    </button>
                <?php endif; ?>
            </div>

            <div class="row" id="historyGrid">
                <?php foreach ($history as $item): ?>
                    <div class="col-md-4 mb-4 history-item" data-id="<?= $item->id ?>">
                        <div class="card history-card">
                            <div class="thumbnail-container">
                                <img src="<?= base_url('assets/uploads/tryon_results/' . $item->result_image) ?>"
                                    class="card-img-top history-image"
                                    alt="Try-On Result">
                                <div class="thumbnail-overlay">
                                    <small>
                                        <i class="fas fa-calendar"></i>
                                        <?= date('d M Y H:i', strtotime($item->created_at)) ?>
                                    </small>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <small class="text-muted">Model</small><br>
                                        <img src="<?= base_url('assets/uploads/tryon/' . $item->model_image) ?>"
                                            class="img-thumbnail"
                                            style="height: 80px; width: 80px; object-fit: cover;"
                                            alt="Model">
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Pakaian</small><br>
                                        <img src="<?= base_url('assets/uploads/tryon/' . $item->garment_image) ?>"
                                            class="img-thumbnail"
                                            style="height: 80px; width: 80px; object-fit: cover;"
                                            alt="Garment">
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <a href="<?= base_url('virtual_try/download/' . $item->id) ?>"
                                        class="btn btn-success btn-sm" target="_blank">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                    <button class="btn btn-outline-danger btn-sm delete-btn"
                                        data-id="<?= $item->id ?>">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>

                                <div class="mt-2 text-center">
                                    <small class="text-muted">
                                        ID: <?= $item->id ?> | <?= ucfirst($item->garment_type) ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Update limit UI
            function updateLimitUI(limitInfo) {
                $('#usedCount').text(limitInfo.current_count);
                $('#remainingCount').text(limitInfo.remaining);

                // Update alert
                const limitBox = $('#limitInfoBox');
                limitBox.find('.alert').remove();

                if (limitInfo.is_limit_reached) {
                    limitBox.append(`
                        <div class="alert alert-warning mt-3 mb-0">
                            <i class="fas fa-exclamation-triangle"></i> 
                            <strong>Kuota Habis!</strong> Hapus minimal 1 riwayat untuk mencoba lagi.
                        </div>
                    `);
                } else {
                    limitBox.append(`
                        <div class="alert alert-success mt-3 mb-0">
                            <i class="fas fa-check-circle"></i> 
                            Anda masih memiliki <strong>${limitInfo.remaining}</strong> kuota tersisa.
                        </div>
                    `);
                }
            }

            // Handle single delete
            $('.delete-btn').on('click', function() {
                const tryonId = $(this).data('id');
                const card = $(this).closest('.history-item');

                if (confirm('Apakah Anda yakin ingin menghapus riwayat try-on ini?')) {
                    $.ajax({
                        url: '<?= base_url("virtual_try/delete/") ?>' + tryonId,
                        type: 'POST',
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                // Update limit info
                                if (response.limit_info) {
                                    updateLimitUI(response.limit_info);
                                }

                                // Animate and remove card
                                card.fadeOut(400, function() {
                                    $(this).remove();

                                    // Update total count
                                    const remaining = $('.history-item').length;
                                    $('.badge.bg-primary').text(remaining);

                                    // Check if no more items
                                    if (remaining === 0) {
                                        location.reload();
                                    }
                                });

                                showAlert(response.message + ' Kuota tersisa: ' + response.limit_info.remaining, 'success');
                            } else {
                                showAlert(response.error, 'danger');
                            }
                        },
                        error: function() {
                            showAlert('Terjadi kesalahan saat menghapus', 'danger');
                        }
                    });
                }
            });

            // Handle delete all
            $('#deleteAllBtn').on('click', function() {
                if (!confirm('Apakah Anda yakin ingin menghapus SEMUA riwayat try-on? Tindakan ini tidak dapat dibatalkan.')) {
                    return;
                }

                const allIds = [];
                $('.history-item').each(function() {
                    allIds.push($(this).data('id'));
                });

                let deletedCount = 0;
                let errors = [];

                // Delete satu per satu
                allIds.forEach((id, index) => {
                    $.ajax({
                        url: '<?= base_url("virtual_try/delete/") ?>' + id,
                        type: 'POST',
                        dataType: 'json',
                        async: true,
                        success: function(response) {
                            if (response.success) {
                                deletedCount++;
                                $(`.history-item[data-id="${id}"]`).fadeOut(300);
                            } else {
                                errors.push(`ID ${id}: ${response.error}`);
                            }

                            // Jika sudah selesai semua
                            if (index === allIds.length - 1) {
                                setTimeout(() => {
                                    if (errors.length > 0) {
                                        showAlert(`Berhasil menghapus ${deletedCount} item. Error: ${errors.join(', ')}`, 'warning');
                                    } else {
                                        showAlert(`Berhasil menghapus ${deletedCount} item`, 'success');
                                        setTimeout(() => location.reload(), 1500);
                                    }
                                }, 500);
                            }
                        },
                        error: function() {
                            errors.push(`ID ${id}: Network error`);
                        }
                    });
                });
            });

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
                }, 3000);
            }
        });
    </script>
</body>

</html>