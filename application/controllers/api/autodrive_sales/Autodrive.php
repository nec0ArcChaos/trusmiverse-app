<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autodrive extends CI_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        $this->load->model('Model_autodrive', 'model');
    }

    // 23-8-25
// public function check_nomor()
// {
//     $nomor = $this->input->post('number'); // Nomor dari n8n
//     // $nomor = str_replace('@c.us', '', $nomor); // Bersihkan format WA

    //     $mpm = $this->model->check_nomor($nomor); // SEHARUSNYA MENGIRIM $nomor ke fungsi Model
//     // ...
// }

    public function check_nomor()
    {
        header('Content-Type: application/json');

        $json = file_get_contents('php://input');
        $body = json_decode($json, true);

        $nomor = isset($body['number']) ? trim($body['number']) : null;

        if (!$nomor) {
            echo json_encode([
                "error" => "nomor tidak ditemukan",
                "received_raw" => $body
            ]);
            return;
        }

        $nomor_62 = preg_replace('/^(\+?62)/', '62', $nomor);
        $nomor_0 = preg_replace('/^62/', '0', $nomor_62);
        $nomor_8 = preg_replace('/^(62|0)/', '', $nomor_62);
        $nomor_plus = '+' . $nomor_62;

        $result = $this->model->check_nomor_multi([
            $nomor_62,
            $nomor_0,
            $nomor_8,
            $nomor_plus
        ]);

        if (is_array($result)) {

            $nama = $result['full_name'];
            $booking = $result['booking'];
            $target = $result['target'];
            $achieve = $result['achieve'];
            $sisa = $result['sisa'];

            $list_booking = $result['list_booking'] ?? "    Belum ada booking.";

            // FOLLOW UP
            $contact_no = $result['contact_no'];

            $sql_fu = "SELECT
            'fu1' AS kategori,
            g.id_konsumen,
            k.nama_konsumen,
            -- convert nomor hp
            CASE
                WHEN (SUBSTR(REPLACE(k.no_hp,'-',''),1,1)='0') THEN CONCAT('62', SUBSTR(REPLACE(k.no_hp,'-',''),2))
                WHEN SUBSTR(REPLACE(k.no_hp,'-',''),1,3)='+62' THEN SUBSTR(REPLACE(k.no_hp,'-',''),2)
                WHEN SUBSTR(REPLACE(k.no_hp,'-',''),1,2)='62' THEN REPLACE(k.no_hp,'-','')
                ELSE REPLACE(k.no_hp,' ','')
            END AS no_telp,
            p.project,
            DATE(g.created_at) AS tgl_gci
            FROM rsp_project_live.t_gci g
            LEFT JOIN rsp_project_live.m_project p ON p.id_project = g.id_project
            LEFT JOIN rsp_project_live.m_konsumen k ON k.id_konsumen = g.id_konsumen
            LEFT JOIN (
                SELECT
                tfu.id_gci,
                COUNT(tfu.id_gci) AS frekuensi,
                DATEDIFF(CURRENT_DATE, DATE(MAX(tfu.created_at))) AS datedif
                FROM rsp_project_live.t_follow_up_mkt tfu
                JOIN rsp_project_live.`user` usr
                ON usr.id_user = tfu.created_by
                AND usr.join_hr = (SELECT user_id FROM xin_employees WHERE contact_no = $contact_no)
                GROUP BY tfu.id_gci
            ) AS f ON f.id_gci = g.id_gci
            WHERE
            DATE(g.created_at) BETWEEN '2025-05-27' AND CURDATE() - INTERVAL 1 DAY
            AND g.wa_aktif = 1
            AND g.created_by = (SELECT id_user FROM rsp_project_live.`user` WHERE join_hr = (SELECT user_id FROM xin_employees WHERE contact_no = $contact_no))
            AND COALESCE(f.frekuensi,0) = 0
            AND g.id_kategori NOT IN (0,3)

            UNION ALL

            SELECT
            'fu2',
            g.id_konsumen,
            k.nama_konsumen,
            CASE
                WHEN (SUBSTR(REPLACE(k.no_hp,'-',''),1,1)='0') THEN CONCAT('62', SUBSTR(REPLACE(k.no_hp,'-',''),2))
                WHEN SUBSTR(REPLACE(k.no_hp,'-',''),1,3)='+62' THEN SUBSTR(REPLACE(k.no_hp,'-',''),2)
                WHEN SUBSTR(REPLACE(k.no_hp,'-',''),1,2)='62' THEN REPLACE(k.no_hp,'-','')
                ELSE REPLACE(k.no_hp,' ','')
            END,
            p.project,
            DATE(g.created_at)
            FROM rsp_project_live.t_gci g
            LEFT JOIN rsp_project_live.m_project p ON p.id_project = g.id_project
            LEFT JOIN rsp_project_live.m_konsumen k ON k.id_konsumen = g.id_konsumen
            LEFT JOIN (
                SELECT
                tfu.id_gci,
                COUNT(tfu.id_gci) AS frekuensi,
                DATEDIFF(CURRENT_DATE, DATE(MAX(tfu.created_at))) AS datedif
                FROM rsp_project_live.t_follow_up_mkt tfu
                JOIN rsp_project_live.`user` usr
                ON usr.id_user = tfu.created_by
                AND usr.join_hr = (SELECT user_id FROM xin_employees WHERE contact_no = $contact_no)
                GROUP BY tfu.id_gci
            ) AS f ON f.id_gci = g.id_gci
            LEFT JOIN rsp_project_live.t_gci_fu gfu ON gfu.id_gci = g.id_gci
            WHERE
            DATE(g.created_at) BETWEEN '2025-05-27' AND CURDATE() - INTERVAL 1 DAY
            AND COALESCE(f.frekuensi,0) = 1
            AND f.datedif >= 3
            AND gfu.warm_at IS NULL
            AND gfu.hotprospact_at IS NULL
            AND g.id_kategori NOT IN (0,3,'2.1')

            UNION ALL

            SELECT
            'fu3',
            g.id_konsumen,
            k.nama_konsumen,
            CASE
                WHEN (SUBSTR(REPLACE(k.no_hp,'-',''),1,1)='0') THEN CONCAT('62', SUBSTR(REPLACE(k.no_hp,'-',''),2))
                WHEN SUBSTR(REPLACE(k.no_hp,'-',''),1,3)='+62' THEN SUBSTR(REPLACE(k.no_hp,'-',''),2)
                WHEN SUBSTR(REPLACE(k.no_hp,'-',''),1,2)='62' THEN REPLACE(k.no_hp,'-','')
                ELSE REPLACE(k.no_hp,' ','')
            END,
            p.project,
            DATE(g.created_at)
            FROM rsp_project_live.t_gci g
            LEFT JOIN rsp_project_live.m_project p ON p.id_project = g.id_project
            LEFT JOIN rsp_project_live.m_konsumen k ON k.id_konsumen = g.id_konsumen
            LEFT JOIN (
                SELECT
                tfu.id_gci,
                COUNT(tfu.id_gci) AS frekuensi,
                DATEDIFF(CURRENT_DATE, DATE(MAX(tfu.created_at))) AS datedif
                FROM rsp_project_live.t_follow_up_mkt tfu
                JOIN rsp_project_live.`user` usr
                ON usr.id_user = tfu.created_by
                AND usr.join_hr = (SELECT user_id FROM xin_employees WHERE contact_no = $contact_no)
                GROUP BY tfu.id_gci
            ) AS f ON f.id_gci = g.id_gci
            LEFT JOIN rsp_project_live.t_gci_fu gfu ON gfu.id_gci = g.id_gci
            WHERE
            DATE(g.created_at) BETWEEN '2025-05-27' AND CURDATE() - INTERVAL 1 DAY
            AND COALESCE(f.frekuensi,0) = 2
            AND f.datedif > 4
            AND gfu.warm_at IS NULL
            AND gfu.hotprospact_at IS NULL
            AND g.id_kategori NOT IN (0,3,'2.1')
            ";


            // ===============================
// QUERY AREA – POI dalam 1 KM
// ===============================
            $area_sql = "SELECT 
                    poi.id,
                    poi.category,
                    poi.subcategory,
                    poi.poi_name,
                    poi.latitude,
                    poi.longitude,
                    (
                        6371 * ACOS(
                            COS(RADIANS(lokasi.latitude)) *
                            COS(RADIANS(poi.latitude)) *
                            COS(RADIANS(poi.longitude) - RADIANS(lokasi.longitude)) +
                            SIN(RADIANS(lokasi.latitude)) *
                            SIN(RADIANS(poi.latitude))
                        )
                    ) AS distance_km
                FROM rsp_project_live.m_poi AS poi
                JOIN (
                    SELECT 
                        act.longitude AS longitude,
                        act.latitude AS latitude
                    FROM xin_employees
                    LEFT JOIN rsp_project_live.`user` AS `user`
                        ON `user`.join_hr = xin_employees.user_id
                    LEFT JOIN rsp_project_live.t_activity_marketing AS mkt
                        ON mkt.id_mkt = `user`.id_user
                    JOIN rsp_project_live.t_activity AS act
                        ON act.id_activity = mkt.id_activity
                    AND DATE(act.tanggal) = CURDATE()
                    WHERE xin_employees.contact_no = $contact_no
                    LIMIT 1
                ) AS lokasi
                WHERE 
                    (
                        6371 * ACOS(
                            COS(RADIANS(lokasi.latitude)) *
                            COS(RADIANS(poi.latitude)) *
                            COS(RADIANS(poi.longitude) - RADIANS(lokasi.longitude)) +
                            SIN(RADIANS(lokasi.latitude)) *
                            SIN(RADIANS(poi.latitude))
                        )
                    ) <= 1
                ORDER BY distance_km ASC
            ";

            $area = $this->db->query($area_sql)->result_array();

            // simpan ke result biar bisa dipakai di pesan
            $result['poi_nearby'] = $area;
            // ===============================
            $poi_list = $result['poi_nearby'] ?? [];

            if (count($poi_list) > 0) {
                $text_poi = "🔥 *Area Potensial Ramai – Jangan Lewatkan!*\n";

                foreach ($poi_list as $poi) {
                    $distance = number_format($poi['distance_km'], 2);
                    $text_poi .= "• *{$poi['poi_name']}* – {$poi['category']} ({$distance} km)\n";
                }

            } else {
                $text_poi = "🔥 *Area Potensial:* Belum ada POI dalam radius 1 km.";
            }

            $result['poi_text'] = $text_poi;


            $canvasing_sql = "SELECT
                    kelurahan.kelurahan,
                    act.jam,
                    act.longitude,
                    act.latitude,
                    CONCAT('https://www.google.com/maps?q=', act.latitude, ',', act.longitude) AS link
                FROM xin_employees
                    LEFT JOIN rsp_project_live.`user` AS `user` 
                        ON `user`.join_hr = xin_employees.user_id
                    LEFT JOIN rsp_project_live.t_activity_marketing AS mkt 
                        ON mkt.id_mkt = `user`.id_user
                    JOIN rsp_project_live.t_activity AS act 
                        ON act.id_activity = mkt.id_activity
                    AND DATE(act.tanggal) = CURDATE()
                    JOIN rsp_project_live.r_kelurahan_new AS kelurahan 
                        ON kelurahan.id_kelurahan = act.kelurahan
                WHERE xin_employees.contact_no = $contact_no
                LIMIT 1
            ";

            $canvasing = $this->db->query($canvasing_sql)->row_array();
            $result['activity_today'] = $canvasing;

            $act = $result['activity_today'] ?? null;

            if ($act) {
                $pesan_canvasing = "
📍 *CANVASING Hari ini:*
* Lokasi : {$act['kelurahan']}
* Waktu  : {$act['jam']} WIB
* Google Maps: 👉 {$act['link']}
";
            } else {
                $pesan_canvasing = "📍 *CANVASING:* Tidak ada aktivitas hari ini.";
            }


            $list_booking_sql = "SELECT
                konsumen.nama_konsumen,
                project.project,
                gci.blok
                FROM xin_employees
                LEFT JOIN rsp_project_live.`user` usr 
                    ON usr.join_hr = xin_employees.user_id
                LEFT JOIN rsp_project_live.t_gci AS gci 
                    ON LEFT(gci.created_at, 7) = LEFT(CURDATE(), 7)
                    AND gci.created_by = usr.id_user
                    AND gci.id_kategori IN (3, 4)
                LEFT JOIN rsp_project_live.m_konsumen AS konsumen 
                    ON konsumen.id_konsumen = gci.id_konsumen
                LEFT JOIN rsp_project_live.m_project AS project 
                    ON project.id_project = gci.id_project
                WHERE contact_no = $contact_no
            ";

            $list_booking_data = $this->db->query($list_booking_sql)->result_array();

            if (count($list_booking_data) > 0) {
                $booking_lines = [];
                foreach ($list_booking_data as $bk) {
                    $booking_lines[] = "• {$bk['nama_konsumen']} – {$bk['project']} ({$bk['blok']})";
                }
                $list_booking = implode("\n", $booking_lines);
            } else {
                $list_booking = "• Tidak ada booking bulan ini.";
            }

            $result['list_booking'] = $list_booking;

            $rekap_booking = "SELECT
                -- TARGET
                CASE 
                    WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) >= 12 THEN 4
                    WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) BETWEEN 6 AND 11 THEN 3
                    WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) BETWEEN 3 AND 5 THEN 2
                    WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) BETWEEN 1 AND 2 THEN 1
                    ELSE 1
                END AS target,

                -- TOTAL BOOKING (kategori gci 3 dan 4)
                COUNT(gci.id_gci) AS booking,

                -- SISA BOOKING
                (
                    CASE 
                        WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) >= 12 THEN 4
                        WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) BETWEEN 6 AND 11 THEN 3
                        WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) BETWEEN 3 AND 5 THEN 2
                        WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) BETWEEN 1 AND 2 THEN 1
                        ELSE 1
                    END
                    - COUNT(gci.id_gci)
                ) AS sisa,

                -- ACHIEVE %
                ROUND(
                    (
                        COUNT(gci.id_gci) /
                        (
                            CASE 
                                WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) >= 12 THEN 4
                                WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) BETWEEN 6 AND 11 THEN 3
                                WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) BETWEEN 3 AND 5 THEN 2
                                WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) BETWEEN 1 AND 2 THEN 1
                                ELSE 1
                            END
                        )
                    ) * 100
                ) AS achieve

            FROM xin_employees xe
            LEFT JOIN rsp_project_live.`user` usr 
                ON usr.join_hr = xe.user_id
            LEFT JOIN rsp_project_live.t_gci gci 
                ON LEFT(gci.created_at, 7) = LEFT(CURDATE(), 7)
                AND gci.created_by = usr.id_user
                AND gci.id_kategori IN (3,4)

            WHERE xe.contact_no = $contact_no
            ";
            $rekap_booking_data = $this->db->query($rekap_booking)->row_array();

            $rb = $this->db->query($rekap_booking)->row_array();

            $booking = $rb['booking'];
            $target = $rb['target'];
            $sisa = $rb['sisa'];
            $achieve = $rb['achieve'];
            $result['booking'] = $booking;
            $result['target'] = $target;
            $result['sisa'] = $sisa;
            $result['achieve'] = $achieve;
            $fu_data = $this->db->query($sql_fu)->result_array();

            $fu1 = $result['fu1'] ?? [];
            $fu2 = $result['fu2'] ?? [];
            $fu3 = $result['fu3'] ?? [];

            // $total_fu = count($fu1) + count($fu2) + count($fu3);
            // $target_fu = $total_fu; // 6/6


            foreach ($fu_data as $d) {
                $line = "{$d['nama_konsumen']} - {$d['no_telp']} ({$d['project']})";

                if ($d['kategori'] == 'fu1')
                    $fu1[] = $line;

                if ($d['kategori'] == 'fu2')
                    $fu2[] = $line;

                if ($d['kategori'] == 'fu3')
                    $fu3[] = $line;
            }

            $total_fu = count($fu1) + count($fu2) + count($fu3);   // <-- pindahin ke sini


            $list_fu1 = count($fu1) ? "    " . implode("\n    ", $fu1) : "    Tidak ada FU1.";
            $list_fu2 = count($fu2) ? "    " . implode("\n    ", $fu2) : "    Tidak ada FU2.";
            $list_fu3 = count($fu3) ? "    " . implode("\n    ", $fu3) : "    Tidak ada FU3.";

            $result['list_fu1'] = $list_fu1;
            $result['list_fu2'] = $list_fu2;
            $result['list_fu3'] = $list_fu3;


            $act = $result['activity_today'];

            $pesan_canvasing = "
📍 *CANVASING Hari ini:*
* Lokasi : {$act['kelurahan']}
* Waktu  : {$act['jam']} WIB
* Google Maps: 👉 {$act['link']}
";

            $poi_list = $result['poi_nearby'] ?? [];

            if (count($poi_list) > 0) {
                $text_poi = "🔥 *Area Potensial Ramai – Jangan Lewatkan!*\n";

                $no = 1;
                foreach ($poi_list as $poi) {
                    $text_poi .= "* {$poi['poi_name']}* → {$poi['category']} ({$poi['distance_km']} km)\n";
                    $no++;
                }

            } else {
                $text_poi = "🔥 *Area Potensial:* Belum ada POI dalam radius 1 km.";
            }


            $pesan = "
👋 *Halo $nama The Campion*, Jadikan hari ini panggung kemenanganmu. Fokus, jalani dengan hati, dan kejar CLOSING sampai dapat!

🚀 *DAILY SALES RECAP* “Finish line sudah dekat, ayo gaspol!”

🎯 *BOOKING: $booking/$target ($achieve%)* 💡 $sisa closing lagi tembus target! Sikat!

$list_booking

📞 *FOLLOW UP ($total_fu)* Belum ada pergerakan? Bahan closingan ada di daftar ini, hubungi sekarang!

🔥 *FU 1 (New Leads)*

$list_fu1

⚡ *FU 2 (Prospek)*  

$list_fu2

🤝 *FU 3 (Hot buat Closing)*  

$list_fu3

$pesan_canvasing

{$result['poi_text']}

“Setiap pintu adalah peluang. Semangat cari Closingan!” 🏆

🌟 Spirit Hari Ini

> “Setiap langkah kecil hari ini adalah alasan besar untuk tersenyum nanti.
> Kamu pejuang terbaik untuk closingmu sendiri!” 🏆
        ";

        } else {
            $pesan = "Nomor tidak ditemukan di database.";
        }

        echo json_encode([
            "input" => $nomor,
            "nama" => $result['full_name'] ?? null,
            "booking" => $result['booking'] ?? null,
            "target" => $result['target'] ?? null,
            "achieve" => $result['achieve'] ?? null,
            "sisa" => $result['sisa'] ?? null,
            "hasil" => $result,
            "pesan" => $pesan
        ], JSON_UNESCAPED_UNICODE);

    }




}