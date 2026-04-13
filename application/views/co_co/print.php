<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coaching & Counseling</title>
    <link rel="icon" href="https://trusmiverse.com/apps/assets/img/logo_trusmiverse.png" sizes="32x32" type="image/png">
    <link rel="icon" href="https://trusmiverse.com/apps/assets/img/logo_trusmiverse.png" sizes="16x16" type="image/png">

    <link rel="stylesheet" href="<?= base_url('/'); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('/'); ?>assets/node_modules/bootstrap-icons/font/bootstrap-icons.css">

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> -->

    <style>
        /* Latar belakang halaman yang sedikit berbeda untuk 'mengangkat' kartu */
        body {
            background-color: #f4f7f6;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        /* Judul halaman utama */
        .page-title {
            color: #333;
            font-weight: 300;
        }

        /* Kartu utama untuk membungkus semua konten */
        .coaching-card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07);
            /* Shadow lebih halus */
            margin-top: 2rem;
            margin-bottom: 2rem;
            overflow: hidden;
            /* Memastikan border-radius konsisten */
        }

        /* Header kartu untuk metadata */
        .coaching-card .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #e9ecef;
            /* Garis batas lebih tipis */
            padding: 1.75rem;
        }

        /* Kustomisasi untuk daftar deskripsi (metadata) */
        .info-list dt {
            font-weight: 600;
            color: #6c757d;
            /* Warna label lebih redup */
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }

        .info-list dd {
            font-weight: 500;
            color: #212529;
            /* Data lebih menonjol */
            font-size: 1.05rem;
            margin-bottom: 1rem;
        }

        .info-list .col-md-6:last-child dl dd:last-child {
            margin-bottom: 0;
            /* Menghapus margin bawah ekstra */
        }

        /* ------------- Gaya Baru (Tanpa Accordion) ------------- */

        /* Bagian konten individual */
        .content-section {
            padding: 1.5rem 0;
            margin: 0 1.75rem;
            /* Menyamakan padding horizontal dengan card-header */
            border-bottom: 1px solid #e9ecef;
            /* Pemisah antar bagian */
        }

        /* Menghapus garis di bagian terakhir */
        .coaching-card .card-body>.content-section:last-child {
            border-bottom: none;
            padding-bottom: 0.5rem;
            /* Mengurangi padding di akhir */
        }

        /* Judul setiap bagian (Review, Goals, dll.) */
        .content-section h4 {
            font-weight: 600;
            color: #343a40;
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }

        /* Ikon di sebelah judul */
        .content-section h4 i {
            color: #0d6efd;
            /* Warna primer Bootstrap */
            font-size: 1.3rem;
            line-height: 1;
        }

        /* Area untuk teks HTML (paragraf, list) */
        .content-area {
            line-height: 1.2;
            color: #333;
        }

        .content-area p,
        .content-area ol,
        .content-area ul {
            margin-bottom: 0.5rem;
        }

        .content-area>*:last-child {
            margin-bottom: 0;
            /* Tidak ada margin di elemen terakhir */
        }

        /* Placeholder untuk Logo */
        .logo-placeholder {
            width: 150px;
            height: 50px;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-weight: 600;
            border-radius: 0.25rem;
        }
    </style>
</head>

<body>

    <div class="container">
        <header class="d-flex flex-wrap justify-content-between align-items-center pb-1 mb-1 border-bottom">
            <!-- <div class="logo-placeholder">
                </div> -->
            <img src="https://trusmiverse.com/apps/assets/img/logo-trusmi-group-no-bg.png" alt="Gambar" width="100">

            <h3 class="h3 page-title mb-0">Coaching & Counseling</h3>
        </header>
    </div>

    <div class="container-fluid my-2">



        <div class="card coaching-card">

            <div class="card-header">
                <div class="row g-4">
                    <div class="col-6">
                        <dl class="info-list mb-0">
                            <dt>Karyawan</dt>
                            <dd><?= $karyawan ?></dd>

                            <dt>Jabatan</dt>
                            <dd><?= $designation_name ?> | <?= $department_name ?></dd>

                            <dt>Perusahaan</dt>
                            <dd><?= $company_name ?></dd>
                        </dl>
                    </div>
                    <div class="col-6">
                        <dl class="info-list mb-0">
                            <dt>ID Coaching</dt>
                            <dd><?= $id_coaching ?></dd>

                            <dt>Atasan (Coach)</dt>
                            <dd><?= $atasan ?></dd>

                            <dt>Tanggal & Tempat</dt>
                            <dd><?= $tanggal . ' di ' . $tempat ?></dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="card-body pt-2 pb-2">

                <div class="content-section">
                    <h4><i class="bi bi-search me-3"></i> Review (Kendala Saat Ini)</h4>
                    <div class="content-area"><?= $review ?>
                    </div>
                </div>

                <div class="content-section">
                    <h4><i class="bi bi-bullseye me-3"></i> Goals (Tujuan)</h4>
                    <div class="content-area"><?= $goals ?>
                    </div>
                </div>

                <div class="content-section">
                    <h4><i class="bi bi-lightbulb me-3"></i> Reality (Kenyataan)</h4>
                    <div class="content-area"><?= $reality ?>
                    </div>
                </div>

                <div class="content-section">
                    <h4><i class="bi bi-list-check me-3"></i> Options (Pilihan)</h4>
                    <div class="content-area"><?= $option ?>
                    </div>
                </div>

                <div class="content-section">
                    <h4><i class="bi bi-rocket-takeoff me-3"></i> Will (Rencana Aksi)</h4>
                    <div class="content-area"><?= $will ?>
                    </div>
                </div>

                <div class="content-section">
                    <h4><i class="bi bi-patch-check-fill me-3"></i> Komitmen</h4>
                    <div class="content-area"><?= $komitmen ?>
                    </div>
                </div>
                <div class="content-section">
                    <h4><i class="bi bi-camera me-3"></i> Foto</h4>
                    <img src="<?= base_url('/uploads/coaching/') . $foto; ?>" alt="Foto Coaching"
                        class="img-fluid rounded" style="max-width: 300px; height: auto;">
                </div>
            </div>
            <div class="card-footer text-end text-muted" style="background-color: #fcfcfc;">
                <small>
                    Dibuat oleh: <strong><?= $created_by ?></strong> pada <strong><?= $created_at ?></strong>
                </small>

            </div>
        </div>

    </div>

    <script src="<?= base_url('/'); ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url('/'); ?>assets/vendor/bootstrap-5/dist/js/bootstrap.bundle.js"></script>


    <script>
        // Data JSON Anda
        const data = {
            "id_coaching": "CC2510280001",
            "karyawan": "Eni Nuryati",
            "tempat": "Ruang Perpustakaan",
            "tanggal": "28 Oct 2025",
            "atasan": "Aris Kurniawan ",
            "review": "<p>Kendala Job Profile Admin Oprasional After Sales yang ada sekarang&nbsp;</p><p><br></p>",
            "goals": "<p>1. Target balas chat dari konsumen (Respon pelayanan ke konsumen)</p><p>2. Admin oprasional After Sales kewalahan terkait job profile yang ada sekarang, jadi ingin dibagi menjadi 2 job profile admin</p><p>3. Memaksimalkan jobdesk yang sudah diatur kedepannya</p>",
            "reality": "<p>1.Pembagian stock material dan kebutuhan project perbaikan, dikarenakan kekurangan stock material</p><p>2. Distribusi permintaan kunci untuk unit perbaikan</p><p>3. SPV menyiapkan jadwal tukang After Sales mendadak yaitu dipagi hari</p><p><br></p>",
            "option": "<p>1. Distribusi material ke mpp After Sales</p><p>2. Distribusi kunci ke mpp After Sales</p><p>3. Koordinasi ke marketing terkait kunci yang sudah diserah terima ke konsumen</p><p>4. Menjawab chat dari konsumen</p><p>5. Menginformasikan terkait perbiakan ke konsumen</p>",
            "will": "<p>1. Pembagian jobdesk menjadi 2 admin yaitu admin purchasing dan staff warehouse</p><p>2. Teliti dan bertanggung jawab atas jobdesk yang sudah dibagi ke admin baru</p><p>3. Membuat report harian dan mingguan.</p>",
            "komitmen": "<p>1. Jika sudah ada admin baru, admin oprasional yaitu Eni Nuryati berkomitmen memaksimalkan jobdesk yang sudah ditetapkan</p><p>2. Tidak ada keterlambatan ketersediaan atau pembelanjaan material</p><p>3. Membuat report harian dan mingguan.</p>",
            "foto": "CC2510280001_1761625739.jpg",
            "company_id": "2",
            "company_name": "Raja Sukses Propertindo",
            "department_id": "161",
            "department_name": "After Sales & Swakelola",
            "designation_id": "896",
            "designation_name": "Admin After Sales",
            "role_id": "7",
            "role_name": "Staff",
            "created_at": "2025-10-28 11:28:59",
            "created_by": "Aris Kurniawan "
        };

        // Menggunakan jQuery untuk mengisi data ke HTML saat dokumen siap
        $(document).ready(function () {
            // Mengisi Metadata
            $('#karyawan-nama').text(data.karyawan);
            $('#karyawan-jabatan').text(data.designation_name + ' / ' + data.department_name);
            $('#karyawan-perusahaan').text(data.company_name);

            $('#coaching-id').text(data.id_coaching);
            $('#coaching-atasan').text(data.atasan.trim());
            $('#coaching-lokasi').text(data.tanggal + ' di ' + data.tempat);

            // Mengisi Konten (langsung ke div masing-masing)
            $('#review-content').html(data.review);
            $('#goals-content').html(data.goals);
            $('#reality-content').html(data.reality);
            $('#option-content').html(data.option);
            $('#will-content').html(data.will);
            $('#komitmen-content').html(data.komitmen);
        });
    </script>
</body>

</html>