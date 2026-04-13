<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lock_konsistensi_report_finance extends CI_Controller
{

    // private $user = 5840;
    private $user = 76; // set user bu Yeyen untuk di lock
    private $user_contact = "6281290092040";

    // private $created_by = 4770; // set Dewi Anggraeni yang ngelock
    // private $lock_by = 'Dewi Anggraeni';
    private $created_by = 5121; // set Dhewana yang ngelock
    private $lock_by = 'Dhewana Alnafis Han';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function index()
    {
        echo $this->user;
        echo $this->created_by;
        echo "Cronjob insert to lock manual";
    }

    function insert_lock()
    {
        $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES ('test', 5840, 'Plan vs actual cashflow RSP sebulan lalu - By IT', 1, '" . date('Y-m-d H:i:s') . "', 1, NULL, NULL)");

        // Send notif
//         $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

//         $data_text = array(
//             "channelID" => "2225082380",
//             "phone" => $this->user_contact, // ganti no
//             "messageType" => "text",
//             "body" => "🛰 *Reminder Konsistensi Report Finance* 🛰

// Reminder untuk segera mengirimkan *Data PPh21* bulan ini ke divisi Finance paling lambat tanggal 5. Pastikan semua data telah diperiksa dan akurat untuk memudahkan proses pengolahan lebih lanjut.

// Terima kasih atas kerjasamanya!",
//             "withCase" => true
//         );

//         $options_text = array(
//             'http' => array(
//                 "method"  => 'POST',
//                 "content" => json_encode($data_text),
//                 "header" =>  "Content-Type: application/json\r\n" .
//                     "Accept: application/json\r\n" .
//                     "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
//             )
//         );

//         $context_text   = stream_context_create($options_text);
//         $result_text['wa_api']    = file_get_contents($url, false, $context_text);

//         echo json_encode($result_text['wa_api']);
    }

    function call_lock()
    {
        $this->insert_lock();
    }


    function insert_lock_1()
    {
        // $user = 76; // Bu Yeyen
        // $created_by = 4770; // Dewi Anggraeni

        $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES ('cashflow', $this->user, 'Plan vs actual cashflow RSP sebulan lalu - By $this->lock_by', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        echo $insert_lock;

        // Send notif
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

        $data_text = array(
            "channelID" => "2225082380",
            "phone" => $this->user_contact, // ganti no
            "messageType" => "text",
            "body" => "🛰 *Reminder Konsistensi Report Finance* 🛰

Reminder untuk segera mengirimkan *Report Plan vs actual cashflow RSP sebulan lalu* hari ini, berlaku Lock Absen.

Terima kasih atas kerjasamanya!",
            "withCase" => true
        );

        $options_text = array(
            'http' => array(
                "method"  => 'POST',
                "content" => json_encode($data_text),
                "header" =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
            )
        );

        $context_text   = stream_context_create($options_text);
        $result_text['wa_api']    = file_get_contents($url, false, $context_text);

        echo json_encode($result_text['wa_api']);
    }

    // Lock bulanan setiap tanggal 4
    function insert_lock_monthly_4th()
    {
        $employee_id = $this->user;

        // 1 -----------------------------
        $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES ('cashflow', $this->user, 'Proyeksi Cashflow bulan depan - By $this->lock_by', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        // 2 -----------------------------
        $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
        VALUES ('laba_rugi', $this->user, 'Resume & Poin rekomendasi Laba Rugi - By $this->lock_by', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        // 3 -----------------------------
        $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
        VALUES ('laba_rugi', $this->user, 'Laporan hasil Omset, HPP, Kenaikan Biaya - By $this->lock_by', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        // 4 -----------------------------
        $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
        VALUES ('laba_rugi', $this->user, 'Report Budget vs actual sebulan lalu (beserta bandingkan poin-poin krusialnya) - By $this->lock_by', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        // 5 -----------------------------
        $kategori = 'laba_rugi';
        $alasan_lock = 'Report actual biaya SDM' . ' - By ' . $this->lock_by;
        $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                VALUES
                                ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        // 6 -----------------
        $kategori = 'laba_rugi';
        $alasan_lock = 'AR SPH menunggak' . ' - By ' . $this->lock_by;

        $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        // 7 ------------------
        $kategori = 'neraca';
        $alasan_lock = 'Tren DER, ROA, ROE, ROI' . ' - By ' . $this->lock_by;

        $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        // 8 -----
        $kategori = 'neraca';
        $alasan_lock = 'Report Asset' . ' - By ' . $this->lock_by;

        $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                VALUES
                                ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        // 8.2 -----
        $kategori = 'neraca';
        $alasan_lock = 'Report Neraca' . ' - By ' . $this->lock_by;

        $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");
        

        // 9 ---------
        $kategori = 'hpp';
        $alasan_lock = 'Laporan proyeksi LR new project eksisting' . ' - By ' . $this->lock_by;

        $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        // 10 --------
        $kategori = 'hpp';
        $alasan_lock = 'Report aktual memo TK vs kuncian TK' . ' - By ' . $this->lock_by;

        $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                            (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                            VALUES
                            ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        // 11 --------
        $kategori = 'hpp';
        $alasan_lock = 'Report Average TK' . ' - By ' . $this->lock_by;

        $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                            (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                            VALUES
                            ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        // 12 ------
        $kategori = 'hpp';
        $alasan_lock = 'Report diskon per proyek' . ' - By ' . $this->lock_by;

        $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                            (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                            VALUES
                            ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        // 13 -----
        $kategori = 'hpp';
        $alasan_lock = 'Report TAC & biaya Ops marketing' . ' - By ' . $this->lock_by;

        $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        // 14 -----
        $kategori = 'hpp';
        $alasan_lock = 'Produktivitas karyawan Marketing' . ' - By ' . $this->lock_by;

        $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        // 15 -----
        $kategori = 'hpp';
        $alasan_lock = 'Report bunga KYG KPL' . ' - By ' . $this->lock_by;

        $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        // 16 ------
        $kategori = 'analis_risk';
        $alasan_lock = 'Perencanaan pinjaman dana batik / pinjaman lainnya di proyeksi cash flow bulanan' . ' - By ' . $this->lock_by;

        $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        // 17 ----
        $kategori = 'analis_risk';
        $alasan_lock = 'Rekap analisa keputusan CEO' . ' - By ' . $this->lock_by;

        $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        // 18 ------
        $kategori = 'idp';
        $alasan_lock = 'Keterlaksanaan IDP' . ' - By ' . $this->lock_by;

        $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        // 19 -----
        $kategori = 'idp';
        $alasan_lock = 'Timeline IDP bulan berikutnya' . ' - By ' . $this->lock_by;

        $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        // 20 -----
        $kategori = 'hpp';
        $alasan_lock = 'Report aktual pembayaran lahan disertai luasan & tgl jatuh tempo seharusnya' . ' - By ' . $this->lock_by;

        $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        // 21 ------
        $kategori = 'hpp';
        $alasan_lock = 'Produktivitas support (buspro)' . ' - By ' . $this->lock_by;

        $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        // 22 -----
        $kategori = 'hpp';
        $alasan_lock = 'Produktivitas project' . ' - By ' . $this->lock_by;

        $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");



        // Send notif
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

        $data_text = array(
            "channelID" => "2225082380",
            "phone" => $this->user_contact, // ganti no
            "messageType" => "text",
            "body" => "🛰 *Reminder Konsistensi Report Finance* 🛰

Reminder untuk segera mengirimkan *Konsistensi Report Finance* bulanan, berlaku *Lock Absen*. 

Berikut report yang harus di kirimkan hari ini:
1. Proyeksi Cashflow bulan depan
2. Resume & Poin rekomendasi Laba Rugi
3. Laporan hasil Omset, HPP, Kenaikan Biaya
4. Report Budget vs actual sebulan lalu (beserta bandingkan poin-poin krusialnya)
5. Report actual biaya SDM 
6. AR SPH menunggak
7. Tren DER, ROA, ROE, ROI
8. Report asset
9. Laporan proyeksi LR new project eksisting
10. Report aktual memo TK vs kuncian TK
11. Report average TK  
12. Report diskon per proyek
13. Report TAC & biaya Ops marketing
14. Produktivitas karyawan Marketing
15. Report bunga KYG KPL 
16. Perencanaan pinjaman dana batik / pinjaman lainnya di proyeksi cash flow bulanan 
17. Rekap analisa keputusan CEO 
18. Keterlaksanaan IDP 
19. Timeline IDP bulan berikutnya
20. Report aktual pembayaran lahan disertai luasan & tgl jatuh tempo seharusnya
21. Produktivitas support (buspro)
22. Produktivitas project

Terima kasih atas kerjasamanya!",
            "withCase" => true
        );

        $options_text = array(
            'http' => array(
                "method"  => 'POST',
                "content" => json_encode($data_text),
                "header" =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
            )
        );

        $context_text   = stream_context_create($options_text);
        $result_text['wa_api']    = file_get_contents($url, false, $context_text);

        echo json_encode($result_text['wa_api']);
    }

    // function insert_lock_2()
    // {
    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES ('cashflow', $this->user, 'Proyeksi Cashflow bulan depan - By $this->lock_by', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    // function insert_lock_3()
    // {
    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES ('laba_rugi', $this->user, 'Resume & Poin rekomendasi Laba Rugi - By $this->lock_by', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    // function insert_lock_4()
    // {
    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES ('laba_rugi', $this->user, 'Laporan hasil Omset, HPP, Kenaikan Biaya - By $this->lock_by', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    // function insert_lock_5()
    // {
    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES ('laba_rugi', $this->user, 'Report Budget vs actual sebulan lalu (beserta bandingkan poin-poin krusialnya) - By $this->lock_by', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    // function lock_report_actual()
    // {
    //     $kategori = 'laba_rugi';
    //     $employee_id = $this->user;
    //     $alasan_lock = 'Report actual biaya SDM' . ' - By ' . $this->lock_by;

    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES
    //                                     ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    // function lock_ar_sph()
    // {
    //     $kategori = 'laba_rugi';
    //     $employee_id = $this->user;
    //     $alasan_lock = 'AR SPH menunggak' . ' - By ' . $this->lock_by;

    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES
    //                                     ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    // function lock_tren_der_roa()
    // {
    //     $kategori = 'neraca';
    //     $employee_id = $this->user;
    //     $alasan_lock = 'Tren DER, ROA, ROE, ROI' . ' - By ' . $this->lock_by;

    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES
    //                                     ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    // function lock_report_asset()
    // {
    //     $kategori = 'neraca';
    //     $employee_id = $this->user;
    //     $alasan_lock = 'Report Asset' . ' - By ' . $this->lock_by;

    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES
    //                                     ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    function lock_report_neraca()
    {
        $kategori = 'neraca';
        $employee_id = $this->user;
        $alasan_lock = 'Report Neraca' . ' - By ' . $this->lock_by;

        $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        echo $insert_lock;
    }

    // function lock_report_aktual_memo()
    // {
    //     $kategori = 'hpp';
    //     $employee_id = $this->user;
    //     $alasan_lock = 'Report aktual memo TK vs kuncian TK' . ' - By ' . $this->lock_by;

    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES
    //                                     ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    // function lock_laporan_proyeksi()
    // {
    //     $kategori = 'hpp';
    //     $employee_id = $this->user;
    //     $alasan_lock = 'Laporan proyeksi LR new project eksisting' . ' - By ' . $this->lock_by;

    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES
    //                                     ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    // function lock_report_average()
    // {
    //     $kategori = 'hpp';
    //     $employee_id = $this->user;
    //     $alasan_lock = 'Report Average TK' . ' - By ' . $this->lock_by;

    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES
    //                                     ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    // function lock_report_diskon()
    // {
    //     $kategori = 'hpp';
    //     $employee_id = $this->user;
    //     $alasan_lock = 'Report diskon per proyek' . ' - By ' . $this->lock_by;

    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES
    //                                     ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    // function lock_report_tac()
    // {
    //     $kategori = 'hpp';
    //     $employee_id = $this->user;
    //     $alasan_lock = 'Report TAC & biaya Ops marketing' . ' - By ' . $this->lock_by;

    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES
    //                                     ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    // function lock_produktivitas_karyawan()
    // {
    //     $kategori = 'hpp';
    //     $employee_id = $this->user;
    //     $alasan_lock = 'Produktivitas karyawan Marketing' . ' - By ' . $this->lock_by;

    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES
    //                                     ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    // function lock_report_bunga()
    // {
    //     $kategori = 'hpp';
    //     $employee_id = $this->user;
    //     $alasan_lock = 'Report bunga KYG KPL' . ' - By ' . $this->lock_by;

    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES
    //                                     ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    // function lock_perencanaan_pinjaman()
    // {
    //     $kategori = 'analis_risk';
    //     $employee_id = $this->user;
    //     $alasan_lock = 'Perencanaan pinjaman dana batik / pinjaman lainnya di proyeksi cash flow bulanan' . ' - By ' . $this->lock_by;

    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES
    //                                     ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    // function lock_rekap_analisa()
    // {
    //     $kategori = 'analis_risk';
    //     $employee_id = $this->user;
    //     $alasan_lock = 'Rekap analisa keputusan CEO' . ' - By ' . $this->lock_by;

    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES
    //                                     ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    // function lock_keterlaksanaan_idp()
    // {
    //     $kategori = 'idp';
    //     $employee_id = $this->user;
    //     $alasan_lock = 'Keterlaksanaan IDP' . ' - By ' . $this->lock_by;

    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES
    //                                     ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    // function lock_timeline_idp()
    // {
    //     $kategori = 'idp';
    //     $employee_id = $this->user;
    //     $alasan_lock = 'Timeline IDP bulan berikutnya' . ' - By ' . $this->lock_by;

    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES
    //                                     ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    function lock_mom_hasil_koordinasi()
    {
        $kategori = 'analisa_risiko';
        $employee_id = $this->user;
        $alasan_lock = 'MoM hasil koordinasi' . ' - By ' . $this->lock_by;

        $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        echo $insert_lock;

        // Send notif
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

        $data_text = array(
            "channelID" => "2225082380",
            "phone" => $this->user_contact, // ganti no
            "messageType" => "text",
            "body" => "🛰 *Reminder Konsistensi Report Finance* 🛰

Reminder untuk segera mengirimkan *Report MoM Hasil Koordinasi* minggu ini, berlaku Lock Absen.

Terima kasih atas kerjasamanya!",
            "withCase" => true
        );

        $options_text = array(
            'http' => array(
                "method"  => 'POST',
                "content" => json_encode($data_text),
                "header" =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
            )
        );

        $context_text   = stream_context_create($options_text);
        $result_text['wa_api']    = file_get_contents($url, false, $context_text);

        echo json_encode($result_text['wa_api']);
    }

    function lock_plan_actual()
    {
        $kategori = 'cashflow';
        $employee_id = $this->user;
        $alasan_lock = 'Plan vs Actual Cashflow mingguan' . ' - By ' . $this->lock_by;

        $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        echo $insert_lock;

        // Send notif
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

        $data_text = array(
            "channelID" => "2225082380",
            "phone" => $this->user_contact, // ganti no
            "messageType" => "text",
            "body" => "🛰 *Reminder Konsistensi Report Finance* 🛰

Reminder untuk segera mengirimkan *Report Plan vs Actual Cashflow mingguan* untuk minggu ini, berlaku Lock Absen.

Terima kasih atas kerjasamanya!",
            "withCase" => true
        );

        $options_text = array(
            'http' => array(
                "method"  => 'POST',
                "content" => json_encode($data_text),
                "header" =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
            )
        );

        $context_text   = stream_context_create($options_text);
        $result_text['wa_api']    = file_get_contents($url, false, $context_text);

        echo json_encode($result_text['wa_api']);
    }

    // function lock_report_aktual_pembayaran()
    // {
    //     $kategori = 'hpp';
    //     $employee_id = $this->user;
    //     $alasan_lock = 'Report aktual pembayaran lahan disertai luasan & tgl jatuh tempo seharusnya' . ' - By ' . $this->lock_by;

    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES
    //                                     ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    function lock_list_target()
    {
        $kategori = 'idp';
        $employee_id = $this->user;
        $alasan_lock = 'Buat list target improvement IT (jobdec yang berulang)' . ' - By ' . $this->lock_by;

        $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        echo $insert_lock;

        // Send notif
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

        $data_text = array(
            "channelID" => "2225082380",
            "phone" => $this->user_contact, // ganti no
            "messageType" => "text",
            "body" => "🛰 *Reminder Konsistensi Report Finance* 🛰

Reminder untuk segera mengirimkan *Konsistensi Report Finance* bulanan, berlaku *Lock Absen*. 

Berikut report yang harus di kirimkan hari ini:
1. Buat list target improvement IT (jobdec yang berulang)

Terima kasih atas kerjasamanya!",
            "withCase" => true
        );

        $options_text = array(
            'http' => array(
                "method"  => 'POST',
                "content" => json_encode($data_text),
                "header" =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
            )
        );

        $context_text   = stream_context_create($options_text);
        $result_text['wa_api']    = file_get_contents($url, false, $context_text);

        echo json_encode($result_text['wa_api']);
    }

    // function lock_produktivitas_support()
    // {
    //     $kategori = 'hpp';
    //     $employee_id = $this->user;
    //     $alasan_lock = 'Produktivitas support (buspro)' . ' - By ' . $this->lock_by;

    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES
    //                                     ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    // function lock_produktivitas_project()
    // {
    //     $kategori = 'hpp';
    //     $employee_id = $this->user;
    //     $alasan_lock = 'Produktivitas project' . ' - By ' . $this->lock_by;

    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES
    //                                     ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    function lock_analisa_bursa()
    {
        if (date("l") === "Wednesday") { // jika hari Rabu
            $kategori = 'idp';
            $employee_id = $this->user;
            $alasan_lock = 'Analisa bursa' . ' - By ' . $this->lock_by;

            $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

            echo $insert_lock;

            // Send notif
            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

            $data_text = array(
                "channelID" => "2225082380",
                "phone" => $this->user_contact, // ganti no
                "messageType" => "text",
                "body" => "🛰 *Reminder Konsistensi Report Finance* 🛰

    Reminder untuk segera mengirimkan *Report Analisa Bursa* minggu ini, berlaku Lock Absen.

    Terima kasih atas kerjasamanya!",
                "withCase" => true
            );

            $options_text = array(
                'http' => array(
                    "method"  => 'POST',
                    "content" => json_encode($data_text),
                    "header" =>  "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n" .
                        "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
                )
            );

            $context_text   = stream_context_create($options_text);
            $result_text['wa_api']    = file_get_contents($url, false, $context_text);

            echo json_encode($result_text['wa_api']);
        }
    }

    // function lock_plan_actual_cashflow()
    // {
    //     $kategori = 'cashflow';
    //     $employee_id = $this->user;
    //     $alasan_lock = 'Plan  vs Actual Cashflow mingguan' . ' - By ' . $this->lock_by;

    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES
    //                                     ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    function lock_budget_vs_actual()
    {
        if (date("l") === "Wednesday") { // jika hari Rabu
            $kategori = 'laba_rugi';
            $employee_id = $this->user;
            $alasan_lock = 'budget vs actual biaya pengeluaran (HPP dan OPEX)' . ' - By ' . $this->lock_by;

            $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

            echo $insert_lock;

            // Send notif
            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

            $data_text = array(
                "channelID" => "2225082380",
                "phone" => $this->user_contact, // ganti no
                "messageType" => "text",
                "body" => "🛰 *Reminder Konsistensi Report Finance* 🛰

    Reminder untuk segera mengirimkan *Report budget vs actual biaya pengeluaran (HPP dan OPEX)* minggu ini, berlaku Lock Absen.

    Terima kasih atas kerjasamanya!",
                "withCase" => true
            );

            $options_text = array(
                'http' => array(
                    "method"  => 'POST',
                    "content" => json_encode($data_text),
                    "header" =>  "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n" .
                        "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
                )
            );

            $context_text   = stream_context_create($options_text);
            $result_text['wa_api']    = file_get_contents($url, false, $context_text);

            echo json_encode($result_text['wa_api']);
        }
    }

    // function lock_mom_cashflow()
    // {
    //     $kategori = 'cashflow';
    //     $employee_id = $this->user;
    //     $alasan_lock = 'MoM hasil koordinasi' . ' - By ' . $this->lock_by;

    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES
    //                                     ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    function lock_review_dan_feedback()
    {
        $kategori = 'idp';
        $employee_id = $this->user;
        $alasan_lock = 'Review dan feedback case system dan non system' . ' - By ' . $this->lock_by;

        $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        echo $insert_lock;

        // Send notif
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

        $data_text = array(
            "channelID" => "2225082380",
            "phone" => $this->user_contact, // ganti no
            "messageType" => "text",
            "body" => "🛰 *Reminder Konsistensi Report Finance* 🛰

Reminder untuk segera mengirimkan *Review dan feedback case system dan non system* untuk bulan ini, berlaku Lock Absen.

Terima kasih atas kerjasamanya!",
            "withCase" => true
        );

        $options_text = array(
            'http' => array(
                "method"  => 'POST',
                "content" => json_encode($data_text),
                "header" =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
            )
        );

        $context_text   = stream_context_create($options_text);
        $result_text['wa_api']    = file_get_contents($url, false, $context_text);

        echo json_encode($result_text['wa_api']);
    }

    function lock_update_keterlaksanaan()
    {
        if (date("l") === "Wednesday") { // jika hari Rabu
            $kategori = 'idp';
            $employee_id = $this->user;
            $alasan_lock = 'Update Keterlaksanaan IDP' . ' - By ' . $this->lock_by;

            $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

            echo $insert_lock;

            // Send notif
            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

            $data_text = array(
                "channelID" => "2225082380",
                "phone" => $this->user_contact, // ganti no
                "messageType" => "text",
                "body" => "🛰 *Reminder Konsistensi Report Finance* 🛰

    Reminder untuk segera mengirimkan *Report Update Keterlaksanaan IDP* minggu ini, berlaku Lock Absen.

    Terima kasih atas kerjasamanya!",
                "withCase" => true
            );

            $options_text = array(
                'http' => array(
                    "method"  => 'POST',
                    "content" => json_encode($data_text),
                    "header" =>  "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n" .
                        "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
                )
            );

            $context_text   = stream_context_create($options_text);
            $result_text['wa_api']    = file_get_contents($url, false, $context_text);

            echo json_encode($result_text['wa_api']);
        }
    }

    function lock_report_plan_act_pemb_prod()
    {
        if (date("l") === "Wednesday") { // jika hari Rabu
            $kategori = 'hpp';
            $employee_id = $this->user;
            $alasan_lock = 'Report Plan vs actual pembayaran production' . ' - By ' . $this->lock_by;

            $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                            (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                            VALUES
                                            ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

            echo $insert_lock;

            // Send notif
            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

            $data_text = array(
                "channelID" => "2225082380",
                "phone" => $this->user_contact, // ganti no
                "messageType" => "text",
                "body" => "🛰 *Reminder Konsistensi Report Finance* 🛰

    Reminder untuk segera mengirimkan *Report Plan vs actual pembayaran production* minggu ini, berlaku Lock Absen.

    Terima kasih atas kerjasamanya!",
                "withCase" => true
            );

            $options_text = array(
                'http' => array(
                    "method"  => 'POST',
                    "content" => json_encode($data_text),
                    "header" =>  "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n" .
                        "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
                )
            );

            $context_text   = stream_context_create($options_text);
            $result_text['wa_api']    = file_get_contents($url, false, $context_text);

            echo json_encode($result_text['wa_api']);
        }
    }

    function lock_report_stock()
    {
        if (date("l") === "Wednesday") { // jika hari Rabu
            $kategori = 'hpp';
            $employee_id = $this->user;
            $alasan_lock = 'Report stock dan penggunaanya  production' . ' - By ' . $this->lock_by;

            $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

            echo $insert_lock;

             // Send notif
             $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

             $data_text = array(
                 "channelID" => "2225082380",
                 "phone" => $this->user_contact, // ganti no
                 "messageType" => "text",
                 "body" => "🛰 *Reminder Konsistensi Report Finance* 🛰
 
     Reminder untuk segera mengirimkan *Report stock dan penggunaanya  production* minggu ini, berlaku Lock Absen.
 
     Terima kasih atas kerjasamanya!",
                 "withCase" => true
             );
 
             $options_text = array(
                 'http' => array(
                     "method"  => 'POST',
                     "content" => json_encode($data_text),
                     "header" =>  "Content-Type: application/json\r\n" .
                         "Accept: application/json\r\n" .
                         "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
                 )
             );
 
             $context_text   = stream_context_create($options_text);
             $result_text['wa_api']    = file_get_contents($url, false, $context_text);
 
             echo json_encode($result_text['wa_api']);
        }
    }

    function lock_report_distribusi()
    {
        if (date("l") === "Wednesday") { // jika hari Rabu
            $kategori = 'hpp';
            $employee_id = $this->user;
            $alasan_lock = 'Report Distribusi aset barang jadi' . ' - By ' . $this->lock_by;

            $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

            echo $insert_lock;

             // Send notif
             $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

             $data_text = array(
                 "channelID" => "2225082380",
                 "phone" => $this->user_contact, // ganti no
                 "messageType" => "text",
                 "body" => "🛰 *Reminder Konsistensi Report Finance* 🛰
 
     Reminder untuk segera mengirimkan *Report Distribusi aset barang jadi* minggu ini, berlaku Lock Absen.
 
     Terima kasih atas kerjasamanya!",
                 "withCase" => true
             );
 
             $options_text = array(
                 'http' => array(
                     "method"  => 'POST',
                     "content" => json_encode($data_text),
                     "header" =>  "Content-Type: application/json\r\n" .
                         "Accept: application/json\r\n" .
                         "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
                 )
             );
 
             $context_text   = stream_context_create($options_text);
             $result_text['wa_api']    = file_get_contents($url, false, $context_text);
 
             echo json_encode($result_text['wa_api']);
        }
    }

    function lock_report_penggunaan()
    {
        if (date("l") === "Wednesday") { // jika hari Rabu
            $kategori = 'hpp';
            $employee_id = $this->user;
            $alasan_lock = 'Report Pengunaan aset production' . ' - By ' . $this->lock_by;

            $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

            echo $insert_lock;

             // Send notif
             $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

             $data_text = array(
                 "channelID" => "2225082380",
                 "phone" => $this->user_contact, // ganti no
                 "messageType" => "text",
                 "body" => "🛰 *Reminder Konsistensi Report Finance* 🛰
 
     Reminder untuk segera mengirimkan *Report Pengunaan aset production* minggu ini, berlaku Lock Absen.
 
     Terima kasih atas kerjasamanya!",
                 "withCase" => true
             );
 
             $options_text = array(
                 'http' => array(
                     "method"  => 'POST',
                     "content" => json_encode($data_text),
                     "header" =>  "Content-Type: application/json\r\n" .
                         "Accept: application/json\r\n" .
                         "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
                 )
             );
 
             $context_text   = stream_context_create($options_text);
             $result_text['wa_api']    = file_get_contents($url, false, $context_text);
 
             echo json_encode($result_text['wa_api']);
        }
    }

    // function lock_plan_actual_cashflow()
    // {
    //     $kategori = 'cashflow';
    //     $employee_id = $this->user;
    //     $alasan_lock = 'Plan vs actual cashflow mingguan' . ' - By ' . $this->lock_by;

    //     $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
    //                                     (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
    //                                     VALUES
    //                                     ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

    //     echo $insert_lock;
    // }

    function lock_discuss()
    {
        $kategori = 'idp';
        $employee_id = $this->user;
        $alasan_lock = 'discuss tiap bulan bersama bu Yeyen, bu Fany, bu Secil, dan ka ical untuk membahas pajak' . ' - By ' . $this->lock_by;

        $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        echo $insert_lock;

        // Send notif
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

        $data_text = array(
            "channelID" => "2225082380",
            "phone" => $this->user_contact, // ganti no
            "messageType" => "text",
            "body" => "🛰 *Reminder Konsistensi Report Finance* 🛰

Reminder untuk segera *discuss tiap bulan bersama bu Fany, bu Secil, dan ka ical untuk membahas pajak* hari ini, berlaku Lock Absen.

Terima kasih atas kerjasamanya!",
            "withCase" => true
        );

        $options_text = array(
            'http' => array(
                "method"  => 'POST',
                "content" => json_encode($data_text),
                "header" =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
            )
        );

        $context_text   = stream_context_create($options_text);
        $result_text['wa_api']    = file_get_contents($url, false, $context_text);

        echo json_encode($result_text['wa_api']);
    }

    function lock_()
    {
        $kategori = '';
        $employee_id = $this->user;
        $alasan_lock = '' . ' - By ' . $this->lock_by;

        $insert_lock = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES
                                        ('$kategori', $employee_id, '$alasan_lock', 1, '" . date('Y-m-d H:i:s') . "', $this->created_by, NULL, NULL)");

        echo $insert_lock;
    }
}
