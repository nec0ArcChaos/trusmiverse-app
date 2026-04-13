<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Gemba</title>
    <link rel="icon" href="https://trusmiverse.com/apps/assets/img/logo_trusmiverse.png" sizes="32x32" type="image/png">

    <link rel="stylesheet" href="<?= base_url('/'); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('/'); ?>assets/node_modules/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f4f7f6;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        .page-title {
            color: #333;
            font-weight: 300;
        }

        /* Kartu Header Utama (Info Gemba) */
        .header-card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07);
            margin-bottom: 2rem;
            overflow: hidden;
            background-color: #ffffff;
        }

        .header-card .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #e9ecef;
            padding: 1.75rem;
        }

        .info-list dt {
            font-weight: 600;
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }

        .info-list dd {
            font-weight: 500;
            color: #212529;
            font-size: 1.05rem;
            margin-bottom: 1rem;
        }

        .header-card .card-footer {
            background-color: #fcfcfc;
            border-top: 1px solid #e9ecef;
        }


        /* --- CSS BARU UNTUK KARTU ITEM CEKLIS --- */
        
        .checklist-grid {
            /* Ini akan membuat item-item menjadi kolom */
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); /* Ukuran minimum 380px */
            gap: 1.5rem; /* Jarak antar kartu */
        }

        /* Kartu individu untuk setiap item ceklis */
        .item-card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            background-color: #fff;
            display: flex;
            flex-direction: column; /* Membuat footer menempel di bawah */
            height: 100%; /* Memastikan kartu sama tinggi jika dalam grid */
            /* Border kiri berwarna berdasarkan 'warna' */
            border-left-width: 5px;
            border-left-style: solid;
        }
        
        .item-card .card-body {
            padding: 1.25rem;
            flex-grow: 1; /* Mendorong footer ke bawah */
        }
        
        .item-card .item-concern {
            font-size: 1.1rem;
            font-weight: 600;
            color: #343a40;
            display: flex;
            align-items: center;
        }
        .item-card .item-concern i {
            font-size: 1.2rem;
            margin-right: 0.5rem;
        }

        .item-card .item-monitoring {
            font-size: 0.95rem;
            color: #495057;
            margin-top: 0.75rem;
            margin-bottom: 1.25rem;
            line-height: 1.5;
        }

        /* Metadata (Status, Progres, File, Link) */
        .item-metadata {
            margin-top: 1rem;
        }
        .item-metadata .label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            display: block;
            margin-bottom: 0.25rem;
        }
        .item-metadata .value {
            font-size: 0.9rem;
            font-weight: 500;
            color: #212529;
            display: flex;
            align-items: center;
            /* Memastikan teks tidak terlalu panjang */
            word-break: break-all;
        }
        .item-metadata .value i {
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }

        .item-card .card-footer {
            background-color: #fdfdfd;
            border-top: 1px solid #f1f1f1;
            font-size: 0.8rem;
            color: #6c757d;
            padding: 0.75rem 1.25rem;
        }
    </style>
</head>

<body>

    <?php
    // Asumsi variabel controller Anda adalah $data
    // $data['header'] adalah array, kita ambil elemen [0]
    
    // $data['ceklis'] adalah array item
    $ceklis_items = $ceklis;

    // (Opsional) Buat fungsi helper untuk format tanggal
    if (!function_exists('format_tanggal')) {
        function format_tanggal($date_string, $format = 'd M Y') {
            if (empty($date_string) || $date_string == '0000-00-00 00:00:00' || $date_string == '0000-00-00') {
                return '-';
            }
            $date = new DateTime($date_string);
            if (strpos($date_string, ':') !== false) {
                // Jika ada jam, format lengkap
                return $date->format('d M Y, H:i');
            }
            return $date->format($format);
        }
    }
    
    // Fungsi untuk menentukan ikon berdasarkan concern (dari kode sebelumnya)
    function get_icon_by_concern($concern) {
        if (stripos($concern, 'Location') !== false) return 'bi-geo-alt-fill';
        if (stripos($concern, 'Rules') !== false) return 'bi-shield-check';
        if (stripos($concern, 'Tools') !== false) return 'bi-tools';
        if (stripos($concern, 'Result') !== false) return 'bi-flag-fill';
        return 'bi-list-check'; // Default
    }
    ?>
    <div class="container">
        <header class="d-flex flex-wrap justify-content-between align-items-center pb-1 mb-1 border-bottom">
            <img src="https://trusmiverse.com/apps/assets/img/logo-trusmi-group-no-bg.png" alt="Logo Trusmi Group" width="100">
            <h3 class="h3 page-title mb-0">Laporan Gemba</h3>
        </header>
    </div>

    <div class="container-fluid my-2">
        <div class="card header-card">
            <div class="card-header">
                <div class="row g-4">
                    <div class="col-md-4">
                        <dl class="info-list mb-0">
                            <dt><i class="bi bi-hash me-2"></i>ID Gemba</dt>
                            <dd><?= $header->id_gemba ?></dd>
                            <dt><i class="bi bi-tags-fill me-2"></i>Tipe Gemba</dt>
                            <dd><?= $header->tipe_gemba ?></dd>
                            <dt><i class="bi bi-people-fill me-2"></i>Jumlah Peserta</dt>
                            <dd><?= $header->peserta ?> Orang</dd>
                        </dl>
                    </div>
                    <div class="col-md-4">
                        <dl class="info-list mb-0">
                            <dt><i class="bi bi-calendar-event-fill me-2"></i>Tanggal Rencana</dt>
                            <dd><?= format_tanggal($header->tgl_plan) ?></dd>
                            <dt><i class="bi bi-pin-map-fill me-2"></i>Lokasi</dt>
                            <dd><?= $header->lokasi ?></dd>
                            <dt><i class="bi bi-flag-fill me-2"></i>Status Akhir</dt>
                            <dd>
                                <span class="badge bg-<?= $header->color_akhir ?>"><?= $header->status_akhir ?></span>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-md-4">
                        <dl class="info-list mb-0">
                            <dt><i class="bi bi-clipboard2-check-fill me-2"></i>Evaluasi / Catatan</dt>
                            <dd>
                                <p class="mb-0" style="font-size: 1rem; line-height: 1.4;"><?= $header->evaluasi ?></p>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between text-muted">
                <small>
                    Terakhir diupdate: <strong><?= $header->updated_by ?></strong> (<?= format_tanggal($header->updated_at) ?>)
                </small>
                <small>
                    Dibuat oleh: <strong><?= $header->created_by ?></strong> (<?= format_tanggal($header->created_at) ?>)
                </small>
            </div>
        </div>
        <div class="checklist-grid">

            <?php
            // Loop data ceklis (bukan data dummy lagi)
            foreach ($ceklis_items as $item) :
            
                // AMBIL DATA DARI OUTPUT ANDA
                $concern = $item->concern;
                $monitoring = $item->monitoring;
                $warna = $item->warna; // 'info', 'primary', dll.
                $icon = get_icon_by_concern($concern); // Panggil fungsi helper ikon
                
                // DATA YANG "HILANG" (SAYA TAMBAHKAN SEBAGAI PLACHOLDER)
                // Di masa depan, data ini harusnya ada di query 'ceklis' Anda
                $status_item = (isset($item->status_item)) ? $item->status_item : "Waiting";
                $warna_status = (isset($item->warna_item)) ? $item->warna_item : "warning";
                $progres = (isset($item->progres)) ? $item->progres : 0;
                $file = (isset($item->file) && !empty($item->file)) ? $item->file : null;
                $link = (isset($item->link) && !empty($item->link)) ? $item->link : null;
                $updated_at = (isset($item->updated_at)) ? format_tanggal($item->updated_at) : "Belum update";
                $updated_by = (isset($item->updated_by)) ? $item->updated_by : "-";
                
            ?>

                <div class="item-card border-<?= $warna ?>">
                    <div class="card-body">
                        <h5 class="item-concern text-<?= $warna ?>">
                            <i class="bi <?= $icon ?>"></i> <?= $concern ?>
                        </h5>
                        
                        <p class="item-monitoring"><?= $monitoring ?></p>

                        <div class="row g-3 item-metadata">
                            <div class="col-6">
                                <span class="label">Status</span>
                                <span class="value">
                                    <span class="badge bg-<?= $warna_status ?>"><?= $status_item ?></span>
                                </span>
                            </div>
                            <div class="col-6">
                                <span class="label">Progres</span>
                                <span class="value">
                                    <i class="bi bi-bar-chart-line-fill text-primary"></i> <?= $progres ?>%
                                </span>
                            </div>
                            <div class="col-6">
                                <span class="label">File</span>
                                <span class="value">
                                    <?php if ($file) : ?>
                                        <a href="<?= base_url('uploads/gemba/') . $file ?>" target="_blank" class="text-decoration-none">
                                            <i class="bi bi-file-earmark-arrow-down-fill text-success"></i> <?= $file ?>
                                        </a>
                                    <?php else : ?>
                                        <span class="text-muted"><i class="bi bi-x-circle text-muted"></i> Tidak ada</span>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <div class="col-6">
                                <span class="label">Link</span>
                                <span class="value">
                                    <?php if ($link) : ?>
                                        <a href="<?= $link ?>" target="_blank" class="text-decoration-none">
                                            <i class="bi bi-link-45deg text-info"></i> Lihat Link
                                        </a>
                                    <?php else : ?>
                                        <span class="text-muted"><i class="bi bi-x-circle text-muted"></i> Tidak ada</span>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="card-footer">
                        Update: <strong><?= $updated_by ?></strong> (<?= $updated_at ?>)
                    </div>
                </div>
                <?php endforeach; ?>
            
        </div>
        </div>

    <script src="<?= base_url('/'); ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url('/'); ?>assets/vendor/bootstrap-5/dist/js/bootstrap.bundle.js"></script>

</body>
</html>