<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ucfirst(strtolower($content->judul)) ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/node_modules/bootstrap-icons/font/bootstrap-icons.css'); ?>">
    <link rel="apple-touch-icon" href="https://trusmiverse.com/apps/assets/img/logo_trusmiverse.png" sizes="180x180">
    <link rel="icon" href="https://trusmiverse.com/apps/assets/img/logo_trusmiverse.png" sizes="32x32" type="image/png">
    <link rel="icon" href="https://trusmiverse.com/apps/assets/img/logo_trusmiverse.png" sizes="16x16" type="image/png">
    <style>
        /* Mengatur dasar halaman agar kontras dengan kertas A4 */
        body {
            background-color: #f0f0f0;
            /* Warna latar belakang abu-abu muda */
            margin: 0;
            padding: 0;

            line-height: 1.5;
        }

        /* Kontainer utama untuk halaman kertas */
        .page {
            font-family: 'Times New Roman', Times, serif;
            background-color: white;
            width: 210mm;
            /* Lebar kertas A4 */
            min-height: 297mm;
            /* Tinggi minimum kertas A4 */
            margin: 15px auto;
            /* Posisi di tengah dengan margin atas/bawah */
            padding: 20mm 20mm 20mm 20mm;
            /* Padding: atas, kanan, bawah, kiri */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            /* Efek bayangan agar terlihat seperti kertas */
            box-sizing: border-box;
            /* Memastikan padding tidak menambah ukuran total */
            position: relative;
            /* Diperlukan untuk posisi kop surat */
        }

        /* Style untuk kop surat (background image) */
        .page::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 35mm;
            /* Sesuaikan tinggi ini dengan tinggi kop surat pada gambar Anda */
            background-image: url('<?= $content->header_memo ?>');
            background-size: cover;
            /* Memastikan gambar pas tanpa terpotong atau distorsi */
            background-repeat: no-repeat;
            background-position: top center;
        }

        /* Area konten utama di dalam halaman */
        .content-area {
            padding-top: 20mm;
            /* Beri jarak dari atas agar tidak tertimpa kop surat. Sesuaikan nilainya */
        }

        /* Aturan untuk mencetak (print) */
        @media print {
            body {
                background-color: white;
                /* Hapus background saat print */
            }

            .page {
                margin: 0;
                box-shadow: none;
                /* Hapus bayangan saat print */
                width: auto;
                min-height: auto;
                padding: 10mm 15mm;
                /* Sesuaikan padding untuk print */
            }

            .content-area {
                padding-top: 45mm;
                /* Pastikan padding atas tetap ada saat print */
            }

            /* Ini akan membantu browser membagi halaman dengan lebih baik */
            .page {
                page-break-after: always;
            }
        }

        /* Style tambahan untuk elemen di dalam konten dari TinyMCE agar lebih rapi */
        .content-area table {
            width: 100%;
            border-collapse: collapse;
        }

        .content-area th,
        .content-area td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .content-area h1,
        .content-area h2,
        .content-area h3 {
            margin-top: 24px;
        }

        .approval-area table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            /* Ensures columns are of equal width */
        }

        .approval-area td {
            /* border: 1px solid #ddd; */
            padding: 15px;
            text-align: center;
            vertical-align: top;
        }

        /* CRITICAL: Both the image and the placeholder must have the same height and margin */
        .approval-area img,
        .approval-area .signature-placeholder {
            display: block;
            height: 80px;
            /* Set a fixed height for the signature area */
            width: auto;
            max-width: 150px;
            margin: 0px auto;
            /* Provides vertical spacing and horizontal centering */
            object-fit: contain;
        }

        .pic-name {
            font-weight: bold;
            text-decoration: underline;
        }

        .lampiran-area {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #eee;
            page-break-before: always;
        }

        /* .lampiran-area h2 {
            margin-bottom: 20px;
            font-size: 1.5em;
            color: #333;
        } */

        .lampiran-item {
            margin-bottom: 30px;
            /* Jarak antar lampiran jika ada lebih dari satu */
        }

        /* Membuat gambar responsif dan rapi */
        .lampiran-area img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
        }

        /* Styling untuk frame PDF */
        .lampiran-area iframe {
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .controlled-stamp {
            position: absolute;
            top: 25mm;
            right: 45mm;
            z-index: 1000;
            /* opacity: 0.7; */
        }

        .controlled-stamp img {
            width: 100px;
            /* Sesuaikan ukuran cap sesuai kebutuhan Anda */
            height: auto;
        }

        .ttd-sekdir {
            position: absolute;
            top: 20mm;
            right: 15mm;
            z-index: 1000;
            /* opacity: 0.7; */
        }

        .ttd-sekdir img {
            width: 150px;
            /* Sesuaikan ukuran cap sesuai kebutuhan Anda */
            height: auto;
        }

        .watermark-corner {
            position: absolute;
            top: 1.5cm;
            right: 1.5cm;
            border: 2px solid #555555;
            padding: 5px 10px;
            font-size: 10pt;
            color: #333333;
            text-align: left;
            z-index: 100;
            opacity: 0.4;
        }

        .watermark-corner p {
            margin: 0;
            padding: 1px 0;
            font-family: 'Courier New', Courier, monospace;
            /* Font yang mirip mesin tik/stempel */
        }
    </style>
</head>

<body>
    <!-- <div class="container">
        <div class="row">
            <div class="col">
                <button class="btn btn-primary">Approve</button>
            </div>
        </div>
    </div> -->
    <div class="page">
        <?php
        // 2. MODIFIKASI HTML di dalam Logika PHP
        // Logika tetap sama: Muncul HANYA jika status_memo BUKAN 4
        if ($content->status_memo != 4):
            // GANTI INI: Sesuaikan dengan cara Anda mengambil session username
            $username = $this->session->userdata('username'); // Ganti dengan variabel sesi Anda
            ?>
            <div class="watermark-corner">
                <p>Nomer Memo : <?= htmlspecialchars($content->id_memo) ?></p>
                <p>Username : <?= htmlspecialchars(strtolower($username)) ?></p>
            </div>
        <?php endif; ?>
        <?php if ($content->status_memo == 4): ?>
            <div class="controlled-stamp">
                <p class="m-0 small"><?= $content->approve_at ?></p>
                <img src="https://trusmiverse.com/apps/uploads/controlled.png" alt="Controlled Stamp">
            </div>
            <div class="ttd-sekdir">
                <img src="https://trusmiverse.com/apps/<?= $content->ttd_sekdir ?>">
                <p class="m-0 small"><?= $content->approve_by ?></p>
            </div>
        <?php endif; ?>
        <div class="content-area">
            <h6 class="text-center fw-bold mb-0 text-decoration-underline"><?= $content->jenis ?? 'Memo Internal' ?>
            </h6>
            <?php if ($content->status_memo == 5): ?>
                <p class="text-center fst-italic text-danger">Rejected Memo</p>
            <?php else: ?>
                <?php if ($content->nomer == null || $content->nomer == ''): ?>
                    <p class="text-center fst-italic text-muted">Draf / Unpublish</p>
                <?php elseif ($content->status_memo == 5): ?>
                <?php else: ?>
                    <p class="text-center"><?= $content->nomer ?></p>
                <?php endif; ?>
            <?php endif; ?>

            <p class="mb-0">Perihal : <b><?= $content->judul ?></b></p>
            <p class="">Tgl Rilis :
                <strong><?= ($content->publish == null) ? '-' : date('d F Y', strtotime($content->publish)) ?></strong>
            </p>
            <?php
            if (isset($content) && !empty($content->content)) {
                echo $content->content;
            } else {
                // Ini adalah contoh konten jika $content kosong
                // Anda bisa menghapus bagian 'else' ini nanti
                echo '<h1>Contoh Konten Memo</h1><p>Ini adalah area di mana isi memo dari database akan ditampilkan. Jika kontennya sangat panjang, saat Anda mencoba mencetak halaman ini (Ctrl + P), browser akan secara otomatis membaginya menjadi halaman 2, 3, dan seterusnya, dengan tetap mempertahankan kop surat di halaman pertama.</p>';
            }
            ?>
        </div>
        <div class="approval-area">
            <?php
            $approval_rows = array_chunk($approval, 3);
            ?>

            <table style="width: 100%; text-align: center; border-collapse: separate; border-spacing: 0 15px;">

                <!-- Lakukan iterasi untuk setiap grup (setiap baris) -->
                <?php foreach ($approval_rows as $row_items): ?>
                    <tr>
                        <!-- Lakukan iterasi untuk setiap item di dalam grup (setiap kolom) -->
                        <?php foreach ($row_items as $item): ?>
                            <td style="width: 33.33%; padding: 0 10px;">
                                <p class="mb-0"><?= htmlspecialchars($item->tipe_approval) ?></p>

                                <?php if ($item->status_approval == 1 && !empty($item->ttd_digital)): ?>
                                    <img src="<?= base_url($item->ttd_digital) ?>" alt="Tanda Tangan Digital"
                                        style="height: 50px; display: block; margin: 5px auto;">
                                <?php elseif($item->status_approval == 2): ?>
                                    <div class="signature-placeholder"
                                        style="height: 50px; border: 2px solid #ff0000; margin: 5px auto; width: 100px;">
                                        <span class="d-block text-danger"
                                            style="font-size: 14px; color: #ff0000; line-height: 50px;">Revisi</span>
                                    </div>
                                    <small class="text-danger">Note : <?= $item->note_revisi ?></small>
                                <?php else: ?>
                                    <div class="signature-placeholder"
                                        style="height: 50px; border: 1px dashed #ccc; margin: 5px auto; width: 100px;"></div>
                                <?php endif; ?>

                                <span class="pic-name d-block"
                                    style="font-weight: bold;"><?= htmlspecialchars($item->pic_approval) ?></span>
                                <i class="small"><?= htmlspecialchars($item->designation_name) ?></i>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>

            </table>
        </div>
        <div class="lampiran-area <?= (isset($content->lampiran) == true) ? '' : 'd-none' ?>">
            <!-- <h2>Lampiran</h2> -->

            <?php
            if (isset($content->lampiran) && !empty($content->lampiran)):

                // Bangun URL lengkap ke file
                $file_url = base_url('uploads/files_memo/' . $content->lampiran);
                $file_extension = strtolower(pathinfo($file_url, PATHINFO_EXTENSION));
                ?>
                <div class="lampiran-item">
                    <?php
                    if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])):
                        ?>
                        <img src="<?= $file_url ?>" alt="Lampiran Gambar">
                        <?php
                        // Jika file adalah PDF, gunakan tag <iframe>
                    elseif ($file_extension === 'pdf'):
                        ?>
                        <iframe src="<?= $file_url ?>" width="100%" height="800px">
                            <p>Browser Anda tidak mendukung pratinjau PDF. Silakan <a href="<?= $file_url ?>"
                                    target="_blank">unduh PDF di sini</a>.</p>
                        </iframe>

                        <?php
                    else:
                        ?>
                        <p>Pratinjau tidak tersedia untuk tipe file ini. <a href="<?= $file_url ?>" target="_blank">Unduh
                                file</a>.</p>

                    <?php endif; ?>
                </div>
                <?php
            else:
                // Pesan jika tidak ada lampiran
                // echo "<p>Tidak ada lampiran.</p>";
            endif;
            ?>
        </div>
    </div>
    <script src="<?= base_url('/'); ?>assets/js/jquery-3.3.1.min.js"></script>
    <script>
        $(document).ready(function () {

        });
    </script>
</body>

</html>