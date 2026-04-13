<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_verified extends CI_Model
{

    function __construct()
    {
        parent::__construct();

        $this->load->library('upload');
    }

    // New Query for Reject and Approval Verifikatur
    function get_list_approval($start, $end, $status = NULL)
    {
        $id_user    = $this->session->userdata('id_user');
        $user       = $this->get_user_verified();
        $list_verifikatur = [1, 237, 61, 73, 1358, 22348, 344, 495, 188, 601, 42, 1093]; // Finance
        foreach ($user as $row) {
            array_push($list_verifikatur, $row->id_user_verified);
        }
        // echo $list_verifikatur;
        if (in_array($id_user, $list_verifikatur)) {
            if ($status == 'Reject') {
                // Reject
                $kondisi = 'AND e_pengajuan.`status` IN (11)';
            } else {
                // Approve
                $kondisi = 'AND e_pengajuan.`status` IN (1,2,3,6,7,8)';
            }
        } else {
            $kondisi = "AND e_pengajuan.`status` IN (0)";
        }
        return $this->db->query("SELECT
                                    e_pengajuan.id_pengajuan,
                                    e_pengajuan.tgl_input,
                                    e_m_status.nama_status,
                                    e_m_status.warna,
                                    e_pengajuan.nama_penerima,
                                    e_pengajuan.pengaju as id_pengaju,
                                    CONCAT(pengaju.first_name,' ',pengaju.last_name) as pengaju,
                                    e_kategori.nama_kategori,
                                    e_kategori.id_kategori,
                                    e_pengajuan.flag,
                                    CONCAT(e_detail_keperluan.nama_keperluan,' ',COALESCE(m_project.project,''), ' ',COALESCE(e_detail_keperluan.blok,'')) as nama_keperluan,
                                    COALESCE(e_detail_keperluan.blok,'') AS blok,
                                    m_divisi.divisi AS nama_divisi,
                                    `user`.employee_name AS `name`,
                                    e_pengajuan.`status`,
                                    e_pengajuan.temp,
                                    e_tipe_pembayaran.nama_tipe
                                FROM
                                    e_pengajuan
                                    LEFT JOIN e_m_status ON e_m_status.id_status = e_pengajuan.`status`
                                    JOIN e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
                                    LEFT JOIN e_detail_keperluan ON e_detail_keperluan.id_pengajuan = e_pengajuan.id_pengajuan
                                    LEFT JOIN m_divisi ON m_divisi.id_divisi = e_pengajuan.id_divisi
                                    LEFT JOIN `user` ON `user`.id_user = e_pengajuan.id_user 
                                    LEFT JOIN hris.xin_employees as pengaju ON pengaju.user_id = e_pengajuan.pengaju
                                    LEFT JOIN e_tipe_pembayaran ON e_tipe_pembayaran.id_pengajuan = e_pengajuan.id_pengajuan
                                    LEFT JOIN m_project ON m_project.id_project = e_detail_keperluan.id_project
                                WHERE
                                    DATE( e_pengajuan.tgl_input ) BETWEEN '$start' 
                                    AND '$end'
                                    $kondisi")->result();
    }

    function get_detail_list_approval($id)
    {
        return $this->db->query("SELECT
                                    e_pengajuan.id_pengajuan,
                                    e_biaya.nama_biaya,
                                    e_biaya.budget,
                                    CONCAT(e_detail_keperluan.nama_keperluan,' ',COALESCE(m_project.project,''), ' ',COALESCE(e_detail_keperluan.blok,'')) as nama_keperluan,
                                    e_detail_keperluan.note,
                                    e_detail_keperluan.nominal_uang,
                                    e_photo_acc.photo_acc,
                                    e_jenis_biaya.id_tipe_biaya,
                                    e_tipe_pembayaran.nama_tipe
                                FROM
                                    e_pengajuan
                                    LEFT JOIN e_biaya ON e_biaya.id_biaya = e_pengajuan.id_biaya 
                                    LEFT JOIN e_detail_keperluan ON e_detail_keperluan.id_pengajuan = e_pengajuan.id_pengajuan
                                    LEFT JOIN e_photo_acc ON e_photo_acc.id_pengajuan = e_pengajuan.id_pengajuan
                                    LEFT JOIN e_jenis_biaya ON e_jenis_biaya.id_jenis = e_pengajuan.id_sub_biaya
                                    LEFT JOIN e_tipe_pembayaran ON e_tipe_pembayaran.id_pengajuan = e_pengajuan.id_pengajuan
                                    LEFT JOIN m_project ON m_project.id_project = e_detail_keperluan.id_project
                                WHERE
                                    e_pengajuan.id_pengajuan = '$id'")->row_array();
    }

    function get_detail_list_approval_lpj($id)
    {
        return $this->db->query("SELECT
                                    e_pengajuan.id_pengajuan,
                                    e_biaya.nama_biaya,
                                    e_biaya.budget,
                                    e_detail_keperluan.nama_keperluan,
                                    e_detail_keperluan.note,
                                    e_detail_keperluan.nominal_uang,
                                    e_photo_acc.photo_acc,
                                    e_jenis_biaya.id_tipe_biaya
                                FROM
                                    e_pengajuan
                                    LEFT JOIN e_biaya ON e_biaya.id_biaya = e_pengajuan.id_biaya_lpj
                                    -- LEFT JOIN e_header_lpj ON e_header_lpj.id_lpj = e_pengajuan.id_pengajuan
                                    LEFT JOIN e_detail_keperluan ON e_detail_keperluan.id_lpj = e_pengajuan.id_pengajuan
                                    LEFT JOIN e_photo_acc ON e_photo_acc.id_pengajuan = e_pengajuan.id_pengajuan
                                    LEFT JOIN e_jenis_biaya ON e_jenis_biaya.id_jenis = e_pengajuan.jenis 
                                WHERE
                                    e_pengajuan.id_pengajuan = '$id'")->row_array();
    }
    // End Query for Reject and Approval Verifikatur

    // New Query for EAF and LPJ Verifikatur
    function get_list_my_approval($id_user, $id_div, $status, $datestart, $dateend)
    {
        if ($this->session->userdata('id_user') == 1 || $_SESSION['id_user'] == 237 || $this->session->userdata('id_user') == 61 || $_SESSION['id_user'] == 73 || $this->session->userdata('id_user') == 1358 || $this->session->userdata('id_user') == 22348) {
            $kondisi = "";
        } else {
            // Ade, Noni, Mona, Rika, Laela
            $finance = array(344, 495, 188, 601, 42, 1093); //User Finance Akses Data Verification
            $jenis = array(368, 711, 719, 720); //jenis biaya DLK
            if (in_array($id_user, $finance)) {
                $kondisi = "AND apr.id_user_approval = 737";
            } else if ($_SESSION['id_user'] == 1066) {
                $kondisi = "AND apr.id_user_approval = '$id_user' OR ( apr.id_user_approval = 747 AND aju.jenis IN (368,711,719,720))";
            } else {
                $kondisi = "AND apr.id_user_approval = '$id_user'";
            }
        }
        return $this->db->query("SELECT
                                    aju.id_pengajuan,
                                    aju.tgl_input,
                                    aju.`status`,
                                    sts.nama_status,
                                    sts.warna,
                                    aju.nama_penerima,
                                    aju.pengaju AS id_pengaju,
                                    CONCAT( em.first_name, ' ', em.last_name ) AS pengaju,
                                    kat.nama_kategori,
                                    CONCAT(
                                        det.nama_keperluan,
                                        ' ',
                                        COALESCE ( pro.project, '' ),
                                        ' ',
                                    COALESCE ( det.blok, '' )) AS nama_keperluan,
                                    det.note,
                                    det.nominal_uang,
                                    aju.id_divisi,
                                    dv.divisi as nama_divisi,
                                    aju.id_user,
                                    usr.employee_name AS `name`,
                                    CONCAT(
                                        (
                                            TIMESTAMPDIFF( HOUR, aju.tgl_input, NOW( ) ) - COALESCE (
                                                (
                                                SELECT
                                                    COUNT( y.tgl ) * 24 AS total 
                                                FROM
                                                    (
                                                    SELECT
                                                        x.acara,
                                                        x.tgl 
                                                    FROM
                                                        (
                                                        SELECT
                                                            weekend_name AS acara,
                                                            weekend_date AS tgl 
                                                        FROM
                                                            hris.trusmi_weekend 
                                                        WHERE
                                                            weekend_name = 'Sunday' 
                                                            AND LEFT ( weekend_date, 4 ) = LEFT ( CURDATE( ), 4 ) UNION ALL
                                                        SELECT
                                                            event_name,
                                                            start_date 
                                                        FROM
                                                            hris.xin_holidays 
                                                        WHERE
                                                            LEFT ( start_date, 4 ) = LEFT ( CURDATE( ), 4 ) 
                                                        ) AS x 
                                                    GROUP BY
                                                        x.tgl 
                                                    ) AS y 
                                                WHERE
                                                    y.tgl BETWEEN DATE( aju.tgl_input ) 
                                                    AND CURDATE( ) 
                                                ),
                                                0 
                                            ) 
                                        ),
                                        ' Jam' 
                                    ) AS leadtime,
                                    pt.photo_acc as photo,
                                    pt.flag,
                                    tp.nama_tipe,
                                    COALESCE(det.blok,'') AS blok,
                                    COALESCE(aju.jumlah_termin,'') AS jumlah_termin,
                                    COALESCE(aju.nominal_termin,'') AS nominal_termin
                                FROM
                                    e_pengajuan AS aju
                                    JOIN e_kategori AS kat ON kat.id_kategori = aju.id_kategori
                                    JOIN e_m_status AS sts ON sts.id_status = aju.`status`
                                    LEFT JOIN hris.xin_employees AS em ON em.user_id = aju.pengaju
                                    JOIN m_divisi AS dv ON dv.id_divisi = aju.id_divisi
                                    LEFT JOIN `user` AS usr ON usr.id_user = aju.id_user
                                    LEFT JOIN e_detail_keperluan AS det ON det.id_pengajuan = aju.id_pengajuan
                                    LEFT JOIN m_project AS pro ON pro.id_project = det.id_project
                                    JOIN e_approval AS apr ON apr.id_pengajuan = aju.id_pengajuan 
                                    AND apr.`level` IN ( 10 ) 
                                    AND apr.`status` IS NULL
                                    LEFT JOIN e_photo_acc as pt ON pt.id_pengajuan = aju.id_pengajuan
                                    LEFT JOIN e_tipe_pembayaran as tp ON tp.id_pengajuan = aju.id_pengajuan 
                                WHERE
                                    aju.`status` IN ( 10, 6 ) 
                                    AND aju.id_kategori IS NOT NULL $kondisi")->result();
    }

    function get_detail_verified($id)
    {
        return $this->db->query("SELECT
                                    aju.id_pengajuan,
                                    jen.id_jenis,
                                    jen.jenis,
                                    jen.id_tipe_biaya,
                                    jen.id_user_approval,
                                    bya.budget AS sisa_budget,
                                    bya.id_biaya,
                                    apr.id_approval
                                FROM
                                    e_pengajuan AS aju
                                    JOIN e_jenis_biaya AS jen ON jen.id_jenis = aju.jenis
                                    JOIN e_biaya AS bya ON bya.id_budget = aju.budget 
                                    AND bya.tahun_budget = YEAR (
                                    CURDATE()) 
                                    AND bya.bulan = SUBSTR( CURDATE(), 6, 2 ) 
                                    AND ( minggu IS NULL OR minggu = WEEK ( CURDATE( ), 1 ) - WEEK ( DATE_FORMAT( CURDATE( ), '%Y-%m-01' ), 1 ) + 1 ) 
                                    JOIN e_approval as apr ON apr.id_pengajuan = aju.id_pengajuan AND apr.`level` = 10 AND apr.`status` IS NULL
                                WHERE
                                    aju.id_pengajuan = '$id'")->result();
    }

    function get_lpj($id)
    {
        $query = $this->db->query("SELECT
                                        e_header_lpj.id_lpj,
                                        e_header_lpj.id_pengajuan,
                                        IF(ajuan.id_sub_biaya = ajuan.jenis,e_header_lpj.nama_lpj,e_jenis_biaya.jenis) AS nama_lpj,
                                        e_header_lpj.note_lpj,
                                        ajuan.total_pengajuan,
                                        e_header_lpj.nominal_lpj,
                                        e_jenis_biaya.id_user_approval,
                                        ajuan.total_pengajuan - e_header_lpj.nominal_lpj AS sisa_lpj,
                                        ajuan.pengaju,
                                        CONCAT(em.first_name,' ',em.last_name) as employee_name,
                                        CONCAT(lv.from_date,' ',lv.start_time) as awal,
                                        CONCAT(lv.to_date,' ',lv.end_time) as akhir
                                    FROM
                                        e_pengajuan
                                        LEFT JOIN e_header_lpj ON e_header_lpj.id_lpj = e_pengajuan.id_pengajuan
                                        LEFT JOIN e_pengajuan AS ajuan ON ajuan.id_pengajuan = e_header_lpj.id_pengajuan 
                                        LEFT JOIN e_jenis_biaya ON e_jenis_biaya.id_jenis = ajuan.id_sub_biaya
                                        LEFT JOIN hris.xin_employees as em ON em.user_id = ajuan.pengaju
                                        LEFT JOIN hris.xin_leave_applications as lv ON lv.leave_id = ajuan.leave_id
                                    WHERE
                                        e_pengajuan.id_pengajuan = '$id'");
        $data['data'] = $query->result();
        return $data;
    }

    function get_id_approval_null($id)
    {
        return $this->db->query("SELECT id_approval, id_user_approval FROM e_approval WHERE id_pengajuan = '$id' AND `status` IS NULL")->row_array();
    }

    function get_leave_id($id)
    {
        return $this->db->query("SELECT id_pengajuan, temp, leave_id FROM e_pengajuan WHERE temp = '$id'")->row_array();
    }
    // End New Query

    // function get_list_eaf_my_approval($id_user, $id_div, $status, $datestart, $dateend)
    // {
    //     if ($this->session->userdata('id_user') == 1 || $_SESSION['id_user'] == 237 || $this->session->userdata('id_user') == 61 || $_SESSION['id_user'] == 73) {
    //         $where = "";
    //     } else {
    //         // Ade, Noni, Mona, Rika, Laela
    //         $finance = array(344, 495, 188, 601, 42, 1093); //User Finance Akses Data Verification
    //         if (in_array($id_user, $finance)) {
    //             $where = "AND e_approval.id_user_approval = 737";
    //         } else {
    //             $where = "AND e_approval.id_user_approval = '$id_user'";
    //         }
    //     }
    //     $query = $this->db->query("SELECT
    //                                     e_pengajuan.id_pengajuan,
    //                                     e_pengajuan.tgl_input,
    //                                     m_divisi.divisi AS nama_divisi,
    //                                     e_kategori.nama_kategori,
    //                                     e_tipe_pembayaran.nama_tipe,
    //                                     e_pengajuan.nama_penerima,
    //                                     e_biaya.nama_biaya,
    //                                     e_biaya.budget,
    //                                 IF
    //                                     (
    //                                         e_detail_keperluan.id_project IS NULL,
    //                                         e_detail_keperluan.nama_keperluan,
    //                                         CONCAT( e_detail_keperluan.nama_keperluan, ' ', m_project.project, ' ', COALESCE ( e_detail_keperluan.blok, '' ) ) 
    //                                     ) AS nama_keperluan,
    //                                     e_detail_keperluan.note,
    //                                     e_detail_keperluan.nominal_uang,
    //                                     e_detail_keperluan.id_project,
    //                                     m_project.project,
    //                                     e_detail_keperluan.blok,
    //                                     e_approval.id_approval,
    //                                     e_photo_acc.photo_acc,
    //                                     e_jenis_biaya.id_tipe_biaya,
    //                                     e_jenis_biaya.id_user_approval,
    //                                     e_biaya.id_biaya,
    //                                     e_pengajuan.budget AS id_budget,
    //                                     e_pengajuan.jenis AS id_jenis,
    //                                     e_pengajuan.`status`,
    //                                     e_m_status.warna,
    //                                     e_m_status.nama_status,
    //                                     usr.employee_name AS `name`,
    //                                     CONCAT( pengaju.first_name, ' ', pengaju.last_name ) AS pengaju,
    //                                     CONCAT(
    //                                         (
    //                                             TIMESTAMPDIFF( HOUR, e_pengajuan.tgl_input, NOW( ) ) - COALESCE (
    //                                                 (
    //                                                 SELECT
    //                                                     COUNT( y.tgl ) * 24 AS total 
    //                                                 FROM
    //                                                     (
    //                                                     SELECT
    //                                                         x.acara,
    //                                                         x.tgl 
    //                                                     FROM
    //                                                         (
    //                                                         SELECT
    //                                                             weekend_name AS acara,
    //                                                             weekend_date AS tgl 
    //                                                         FROM
    //                                                             hris.trusmi_weekend 
    //                                                         WHERE
    //                                                             weekend_name = 'Sunday' 
    //                                                             AND LEFT ( weekend_date, 4 ) = LEFT ( CURDATE( ), 4 ) UNION ALL
    //                                                         SELECT
    //                                                             event_name,
    //                                                             start_date 
    //                                                         FROM
    //                                                             hris.xin_holidays 
    //                                                         WHERE
    //                                                             LEFT ( start_date, 4 ) = LEFT ( CURDATE( ), 4 ) 
    //                                                         ) AS x 
    //                                                     GROUP BY
    //                                                         x.tgl 
    //                                                     ) AS y 
    //                                                 WHERE
    //                                                     y.tgl BETWEEN DATE( e_pengajuan.tgl_input ) 
    //                                                     AND CURDATE( ) 
    //                                                 ),
    //                                                 0 
    //                                             ) 
    //                                         ),
    //                                         ' Jam' 
    //                                     ) AS leadtime
    //                                 FROM
    //                                     e_pengajuan
    //                                     LEFT JOIN m_divisi ON m_divisi.id_divisi = e_pengajuan.id_divisi
    //                                     LEFT JOIN e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
    //                                     LEFT JOIN e_tipe_pembayaran ON e_tipe_pembayaran.id_pengajuan = e_pengajuan.id_pengajuan
    //                                     LEFT JOIN (
    //                                     SELECT
    //                                         id_biaya,
    //                                         nama_biaya,
    //                                         budget,
    //                                         id_budget 
    //                                     FROM
    //                                         e_biaya 
    //                                     WHERE
    //                                         (
    //                                             minggu IS NULL 
    //                                             OR minggu = WEEK ( CURDATE( ), 1 ) - WEEK ( DATE_FORMAT( CURDATE( ), '%Y-%m-01' ), 1 ) + 1 
    //                                         ) 
    //                                         AND bulan = SUBSTR( CURDATE( ), 6, 2 ) 
    //                                     ) AS e_biaya ON e_biaya.id_budget = e_pengajuan.budget
    //                                     LEFT JOIN e_detail_keperluan ON e_detail_keperluan.id_pengajuan = e_pengajuan.id_pengajuan
    //                                     LEFT JOIN ( SELECT id_approval, id_pengajuan, id_user_approval FROM e_approval WHERE `level` = 10 AND `status` IS NULL ) AS e_approval ON e_approval.id_pengajuan = e_pengajuan.id_pengajuan
    //                                     LEFT JOIN e_photo_acc ON e_photo_acc.id_pengajuan = e_pengajuan.id_pengajuan
    //                                     LEFT JOIN e_jenis_biaya ON e_jenis_biaya.id_jenis = e_pengajuan.jenis
    //                                     LEFT JOIN `user` AS usr ON usr.id_user = e_pengajuan.id_user
    //                                     LEFT JOIN hris.xin_employees AS pengaju ON e_pengajuan.pengaju = pengaju.user_id
    //                                     LEFT JOIN e_m_status ON e_m_status.id_status = e_pengajuan.`status`
    //                                     LEFT JOIN m_project ON m_project.id_project = e_detail_keperluan.id_project 
    //                                 WHERE
    //                                     e_pengajuan.`status` IN ( 10 ) 
    //                                     $where
    //                                     AND e_pengajuan.id_kategori IN ( 17, 18 )");
    //     $data['data'] = $query->result();
    //     return $data;
    // }

    // function get_list_eaf_list_approval($id_user, $id_div, $status, $datestart, $dateend)
    // {
    //     if ($this->session->userdata('id_user') == 1 || $_SESSION['id_user'] == 237 || $this->session->userdata('id_user') == 61 || $_SESSION['id_user'] == 73) {
    //         $where = "";
    //     } else {
    //         // Ade, Noni, Mona, Rika, Laela
    //         $finance = array(344, 495, 188, 601, 42, 1093); //User Finance Akses Data Verification
    //         if (in_array($id_user, $finance)) {
    //             $where = "AND e_approval.id_user_approval = 737";
    //         } else {
    //             $where = "AND e_approval.id_user_approval = '$id_user'";
    //         }
    //     }
    //     $query = $this->db->query("SELECT
    //                                     e_pengajuan.id_pengajuan,
    //                                     e_pengajuan.tgl_input,
    //                                     m_divisi.divisi AS nama_divisi,
    //                                     e_kategori.nama_kategori,
    //                                     e_tipe_pembayaran.nama_tipe,
    //                                     e_pengajuan.nama_penerima,
    //                                     e_biaya.nama_biaya,
    //                                     e_biaya.budget,
    //                                 IF
    //                                     (
    //                                         e_detail_keperluan.id_project IS NULL,
    //                                         e_detail_keperluan.nama_keperluan,
    //                                         CONCAT( e_detail_keperluan.nama_keperluan, ' ', m_project.project, ' ', COALESCE ( e_detail_keperluan.blok, '' ) ) 
    //                                     ) AS nama_keperluan,
    //                                     e_detail_keperluan.note,
    //                                     e_detail_keperluan.nominal_uang,
    //                                     e_detail_keperluan.id_project,
    //                                     m_project.project,
    //                                     e_detail_keperluan.blok,
    //                                     e_approval.id_approval,
    //                                     e_photo_acc.photo_acc,
    //                                     e_jenis_biaya.id_tipe_biaya,
    //                                     e_jenis_biaya.id_user_approval,
    //                                     e_biaya.id_biaya,
    //                                     e_pengajuan.budget AS id_budget,
    //                                     e_pengajuan.jenis AS id_jenis,
    //                                     e_pengajuan.`status`,
    //                                     e_m_status.warna,
    //                                     e_m_status.nama_status,
    //                                     usr.employee_name AS `name`,
    //                                     CONCAT( pengaju.first_name, ' ', pengaju.last_name ) AS pengaju,
    //                                     CONCAT(
    //                                     IF
    //                                         (
    //                                             DAYNAME( CURDATE( ) ) = 'Monday',
    //                                         IF
    //                                             (
    //                                                 HOUR ( TIMEDIFF( NOW( ), e_pengajuan.tgl_input ) ) - 24 < 0,
    //                                                 0,
    //                                                 HOUR ( TIMEDIFF( NOW( ), e_pengajuan.tgl_input ) ) - 24 
    //                                             ),
    //                                             HOUR ( TIMEDIFF( NOW( ), e_pengajuan.tgl_input ) ) 
    //                                         ),
    //                                         ' Jam' 
    //                                     ) AS leadtime 
    //                                 FROM
    //                                     e_pengajuan
    //                                     LEFT JOIN m_divisi ON m_divisi.id_divisi = e_pengajuan.id_divisi
    //                                     LEFT JOIN e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
    //                                     LEFT JOIN e_tipe_pembayaran ON e_tipe_pembayaran.id_pengajuan = e_pengajuan.id_pengajuan
    //                                     LEFT JOIN (
    //                                     SELECT
    //                                         id_biaya,
    //                                         nama_biaya,
    //                                         budget,
    //                                         id_budget 
    //                                     FROM
    //                                         e_biaya 
    //                                     WHERE
    //                                         (
    //                                             minggu IS NULL 
    //                                             OR minggu = WEEK ( CURDATE( ), 1 ) - WEEK ( DATE_FORMAT( CURDATE( ), '%Y-%m-01' ), 1 ) + 1 
    //                                         ) 
    //                                         AND bulan = SUBSTR( CURDATE( ), 6, 2 ) 
    //                                     ) AS e_biaya ON e_biaya.id_budget = e_pengajuan.budget
    //                                     LEFT JOIN e_detail_keperluan ON e_detail_keperluan.id_pengajuan = e_pengajuan.id_pengajuan
    //                                     LEFT JOIN ( SELECT id_approval, id_pengajuan, id_user_approval FROM e_approval WHERE `level` = 10 AND `status` = 'Approve' ) AS e_approval ON e_approval.id_pengajuan = e_pengajuan.id_pengajuan
    //                                     LEFT JOIN e_photo_acc ON e_photo_acc.id_pengajuan = e_pengajuan.id_pengajuan
    //                                     LEFT JOIN e_jenis_biaya ON e_jenis_biaya.id_jenis = e_pengajuan.jenis
    //                                     LEFT JOIN `user` AS usr ON usr.id_user = e_pengajuan.id_user
    //                                     LEFT JOIN hris.xin_employees AS pengaju ON e_pengajuan.pengaju = pengaju.user_id
    //                                     LEFT JOIN e_m_status ON e_m_status.id_status = e_pengajuan.`status`
    //                                     LEFT JOIN m_project ON m_project.id_project = e_detail_keperluan.id_project 
    //                                 WHERE
    //                                     e_pengajuan.`status` IN ( 1,2,3,6,7,8 ) 
    //                                     $where
    //                                     AND e_pengajuan.id_kategori IN ( 17, 18 )");
    //     $data['data'] = $query->result();
    //     return $data;
    // }

    // function get_list_eaf_reject_approval($id_user, $id_div, $status, $datestart, $dateend)
    // {
    //     if ($this->session->userdata('id_user') == 1 || $_SESSION['id_user'] == 237 || $this->session->userdata('id_user') == 61 || $_SESSION['id_user'] == 73) {
    //         $where = "";
    //     } else {
    //         // Ade, Noni, Mona, Rika, Laela
    //         $finance = array(344, 495, 188, 601, 42, 1093); //User Finance Akses Data Verification
    //         if (in_array($id_user, $finance)) {
    //             $where = "AND e_approval.id_user_approval = 737";
    //         } else {
    //             $where = "AND e_approval.id_user_approval = '$id_user'";
    //         }
    //     }
    //     $query = $this->db->query("SELECT
    //                                     e_pengajuan.id_pengajuan,
    //                                     e_pengajuan.tgl_input,
    //                                     m_divisi.divisi AS nama_divisi,
    //                                     e_kategori.nama_kategori,
    //                                     e_tipe_pembayaran.nama_tipe,
    //                                     e_pengajuan.nama_penerima,
    //                                     e_biaya.nama_biaya,
    //                                     e_biaya.budget,
    //                                 IF
    //                                     (
    //                                         e_detail_keperluan.id_project IS NULL,
    //                                         e_detail_keperluan.nama_keperluan,
    //                                         CONCAT( e_detail_keperluan.nama_keperluan, ' ', m_project.project, ' ', COALESCE ( e_detail_keperluan.blok, '' ) ) 
    //                                     ) AS nama_keperluan,
    //                                     e_detail_keperluan.note,
    //                                     e_detail_keperluan.nominal_uang,
    //                                     e_detail_keperluan.id_project,
    //                                     m_project.project,
    //                                     e_detail_keperluan.blok,
    //                                     e_approval.id_approval,
    //                                     e_photo_acc.photo_acc,
    //                                     e_jenis_biaya.id_tipe_biaya,
    //                                     e_jenis_biaya.id_user_approval,
    //                                     e_biaya.id_biaya,
    //                                     e_pengajuan.budget AS id_budget,
    //                                     e_pengajuan.jenis AS id_jenis,
    //                                     e_pengajuan.`status`,
    //                                     e_m_status.warna,
    //                                     e_m_status.nama_status,
    //                                     usr.employee_name AS `name`,
    //                                     CONCAT( pengaju.first_name, ' ', pengaju.last_name ) AS pengaju,
    //                                     CONCAT(
    //                                     IF
    //                                         (
    //                                             DAYNAME( CURDATE( ) ) = 'Monday',
    //                                         IF
    //                                             (
    //                                                 HOUR ( TIMEDIFF( NOW( ), e_pengajuan.tgl_input ) ) - 24 < 0,
    //                                                 0,
    //                                                 HOUR ( TIMEDIFF( NOW( ), e_pengajuan.tgl_input ) ) - 24 
    //                                             ),
    //                                             HOUR ( TIMEDIFF( NOW( ), e_pengajuan.tgl_input ) ) 
    //                                         ),
    //                                         ' Jam' 
    //                                     ) AS leadtime 
    //                                 FROM
    //                                     e_pengajuan
    //                                     LEFT JOIN m_divisi ON m_divisi.id_divisi = e_pengajuan.id_divisi
    //                                     LEFT JOIN e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
    //                                     LEFT JOIN e_tipe_pembayaran ON e_tipe_pembayaran.id_pengajuan = e_pengajuan.id_pengajuan
    //                                     LEFT JOIN (
    //                                     SELECT
    //                                         id_biaya,
    //                                         nama_biaya,
    //                                         budget,
    //                                         id_budget 
    //                                     FROM
    //                                         e_biaya 
    //                                     WHERE
    //                                         (
    //                                             minggu IS NULL 
    //                                             OR minggu = WEEK ( CURDATE( ), 1 ) - WEEK ( DATE_FORMAT( CURDATE( ), '%Y-%m-01' ), 1 ) + 1 
    //                                         ) 
    //                                         AND bulan = SUBSTR( CURDATE( ), 6, 2 ) 
    //                                     ) AS e_biaya ON e_biaya.id_budget = e_pengajuan.budget
    //                                     LEFT JOIN e_detail_keperluan ON e_detail_keperluan.id_pengajuan = e_pengajuan.id_pengajuan
    //                                     LEFT JOIN ( SELECT id_approval, id_pengajuan, id_user_approval FROM e_approval WHERE `level` = 10 AND `status` = 'Reject' ) AS e_approval ON e_approval.id_pengajuan = e_pengajuan.id_pengajuan
    //                                     LEFT JOIN e_photo_acc ON e_photo_acc.id_pengajuan = e_pengajuan.id_pengajuan
    //                                     LEFT JOIN e_jenis_biaya ON e_jenis_biaya.id_jenis = e_pengajuan.jenis
    //                                     LEFT JOIN `user` AS usr ON usr.id_user = e_pengajuan.id_user
    //                                     LEFT JOIN hris.xin_employees AS pengaju ON e_pengajuan.pengaju = pengaju.user_id
    //                                     LEFT JOIN e_m_status ON e_m_status.id_status = e_pengajuan.`status`
    //                                     LEFT JOIN m_project ON m_project.id_project = e_detail_keperluan.id_project 
    //                                 WHERE
    //                                     e_pengajuan.`status` IN ( 11 ) 
    //                                     $where
    //                                     AND e_pengajuan.id_kategori IN ( 17, 18 )");
    //     $data['data'] = $query->result();
    //     return $data;
    // }

    function get_tracking($id)
    {
        $query = $this->db->query("SELECT
                                        e_approval.id_approval,
                                        id_pengajuan,
                                        id_user_approval,
                                        `status`,
                                        update_approve,
                                        note_approve,
                                        usr.employee_name
                                    FROM
                                        e_approval
                                        JOIN `user` AS usr ON usr.id_user = e_approval.id_user
                                    WHERE
                                        id_pengajuan = '$id' 
                                        AND update_approve IS NOT NULL");
        $data['data'] = $query->result();
        return $data;
    }

    function get_verified_idham($id)
    {
        return $this->db->query("SELECT
                                    e_pengajuan.id_pengajuan,
                                    e_pengajuan.pengaju,
                                    e_jenis_biaya.id_user_approval 
                                FROM
                                    e_pengajuan
                                    JOIN e_jenis_biaya ON e_jenis_biaya.id_jenis = e_pengajuan.jenis 
                                WHERE
                                    e_pengajuan.id_pengajuan = '$id'")->row_array();
    }

    function get_verified_for_wa($id, $pengaju, $user_approval)
    {
        $id_user = $this->session->userdata('id_user');
        // Jika pengaju Nida & User Approval Pak Ibnu maka Verified Idham
        if ($pengaju = "1483" && $user_approval == "237") {
            $new_join = "JOIN `user` AS usr_ver ON usr_ver.id_user = 286";
        } else {
            $new_join = "JOIN `user` AS usr_ver ON usr_ver.id_user = IF ( e_jenis_biaya.id_user_verified = 737, $id_user, e_jenis_biaya.id_user_verified )";
        }
        return $this->db->query("SELECT
                                    e_pengajuan.id_pengajuan AS no_eaf,
                                    e_kategori.nama_kategori AS type,
                                    e_detail_keperluan.nama_keperluan AS need,
                                    e_detail_keperluan.note AS description,
                                    e_detail_keperluan.nominal_uang AS amount,
                                    COALESCE ( e_biaya.budget, '~' ) AS remaining_budget,
                                    e_jenis_biaya.id_user_approval,
                                    CONCAT( approval.first_name, ' ', approval.last_name ) AS approve_to,
                                    approval.contact_no AS approve_contact,
                                    e_jenis_biaya.id_user_verified,
                                    CONCAT( ver.first_name, ' ', ver.last_name ) AS verified_by,
                                    e_pengajuan.pengaju,
                                    emp.contact_no AS requested_contact,
                                    CONCAT( emp.first_name, ' ', emp.last_name ) AS requested_by,
                                    e_pengajuan.created_at AS requested_at,
                                    e_jenis_biaya.id_jenis,
                                    kt.city
                                FROM
                                    e_pengajuan
                                    JOIN e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
                                    JOIN e_detail_keperluan ON e_detail_keperluan.id_pengajuan = e_pengajuan.id_pengajuan
                                    JOIN (
                                    SELECT
                                        id_biaya,
                                        nama_biaya,
                                        budget,
                                        id_budget 
                                    FROM
                                        e_biaya 
                                    WHERE
                                        (
                                            minggu IS NULL 
                                            OR minggu = WEEK ( CURDATE( ), 1 ) - WEEK ( DATE_FORMAT( CURDATE( ), '%Y-%m-01' ), 1 ) + 1 
                                        ) 
                                        AND bulan = DATE_FORMAT( CURDATE( ), '%m' ) 
                                        AND tahun_budget = DATE_FORMAT( CURDATE( ), '%Y' ) 
                                    ) e_biaya ON e_biaya.id_budget = e_pengajuan.budget
                                    JOIN e_jenis_biaya ON e_jenis_biaya.id_jenis = e_pengajuan.jenis
                                    JOIN `user` AS usr ON usr.id_user = e_jenis_biaya.id_user_approval
                                    $new_join
                                    JOIN hris.xin_employees AS approval ON approval.user_id = usr.id_hr
                                    JOIN hris.xin_employees AS ver ON ver.user_id = usr_ver.id_hr
                                    JOIN hris.xin_employees AS emp ON emp.user_id = e_pengajuan.pengaju 
                                    LEFT JOIN hris.xin_leave_applications AS lv ON lv.leave_id = e_pengajuan.leave_id
                                    LEFT JOIN hris.trusmi_kota AS kt ON kt.id = lv.kota
                                WHERE
                                    e_pengajuan.id_pengajuan = '$id'")->row();
    }

    function get_history($id)
    {
        $id_user = $this->session->userdata('id_user');
        $query = $this->db->query("SELECT
            e_pengajuan.id_pengajuan,
            e_pengajuan.nama_penerima,
            e_kategori.nama_kategori,
            -- e_jenis_biaya.jenis AS nama_keperluan,
            IF(m_project.project IS NULL,e_jenis_biaya.jenis,CONCAT(e_jenis_biaya.jenis,' ',m_project.project,' ',COALESCE(e_detail_keperluan.blok,''))) as nama_keperluan,
            approve.tgl_approve,
            CASE
                WHEN e_kategori.id_kategori = 17 THEN
                'Tidak LPJ' 
                WHEN LEFT ( e_pengajuan.temp, 3 ) = 'LPJ' THEN
                'Sudah LPJ' ELSE 'Belum LPJ'
            END AS status_lpj,
            COALESCE ( lpj.total_pengajuan, e_pengajuan.total_pengajuan ) AS total_pengajuan,
            e_pengajuan.id_kategori,
            approve.id_user 
        FROM
            e_pengajuan
            JOIN e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
            JOIN e_detail_keperluan ON e_pengajuan.id_pengajuan = e_detail_keperluan.id_pengajuan
            JOIN e_jenis_biaya ON e_pengajuan.id_sub_biaya = e_jenis_biaya.id_jenis
            JOIN (
            SELECT
                e_approval.id_pengajuan,
                SUBSTR( MAX( e_approval.update_approve ), 1, 10 ) AS tgl_approve,
                COALESCE ( e_approval.id_user, e_approval.id_user_approval ) AS id_user 
            FROM
                e_approval 
            WHERE
                e_approval.`level` = 1 
                AND SUBSTR( e_approval.update_approve, 1, 7 ) = SUBSTR( CURDATE( ), 1, 7 ) 
            GROUP BY
                e_approval.id_pengajuan 
            ) AS approve ON approve.id_pengajuan = e_pengajuan.id_pengajuan
            LEFT JOIN ( SELECT e_pengajuan.id_pengajuan, e_pengajuan.total_pengajuan FROM e_pengajuan WHERE LEFT ( e_pengajuan.id_pengajuan, 3 ) = 'LPJ' ) AS lpj ON lpj.id_pengajuan = e_pengajuan.temp 
            LEFT JOIN m_project ON m_project.id_project = e_detail_keperluan.id_project
        WHERE
            e_pengajuan.id_biaya = $id
            AND approve.id_user = $id_user 
            AND SUBSTR( e_pengajuan.tgl_input, 1, 7 ) = SUBSTR( CURDATE( ), 1, 7 ) 
            AND e_pengajuan.id_kategori != 19");
        $data['data'] = $query->result();
        return $data;
    }

    function cek_verified($id)
    {
        return $this->db->query("SELECT * FROM e_approval WHERE id_pengajuan = '$id' AND `level` = 10 AND `status` = 'Approve'");
    }

    function get_ba($id)
    {
        return $this->db->query("SELECT
                                    e_pengajuan.id_pengajuan,
                                    e_pengajuan.nama_penerima,
                                    e_pengajuan.tgl_input,
                                    e_pengajuan.note,
                                    e_header_lpj.nominal_lpj,
                                    e_header_lpj.nama_lpj,
                                    approval.id_user_approval,
                                    usr.employee_name 
                                FROM
                                    e_pengajuan
                                    LEFT JOIN e_header_lpj ON e_header_lpj.id_lpj = e_pengajuan.id_pengajuan
                                    LEFT JOIN ( SELECT id_pengajuan, id_user_approval FROM e_approval WHERE id_pengajuan = '$id' AND `level` = 10 AND `status` = 'Approve' ) AS approval ON approval.id_pengajuan = e_pengajuan.id_pengajuan
                                    LEFT JOIN `user` AS usr ON usr.id_user = approval.id_user_approval 
                                WHERE
                                    e_pengajuan.id_pengajuan = '$id'")->row_array();
    }

    function cek_dlk($id)
    {
        return $this->db->query("SELECT
                                    aju.id_sub_biaya AS id_jenis,
                                    COALESCE(ph.photo_acc,'') AS nota
                                FROM
                                    e_pengajuan AS aju
                                    JOIN e_photo_acc AS ph ON ph.id_pengajuan = aju.temp 
                                WHERE
                                    aju.temp = '$id'")->row_array();
    }

    function cek_pengajuan_dlk($id)
    {
        return $this->db->query("SELECT
                                    aju.jenis AS id_jenis,
                                    COALESCE(ph.photo_acc,'') AS nota
                                FROM
                                    e_pengajuan AS aju
                                    LEFT JOIN e_photo_acc AS ph ON ph.id_pengajuan = aju.id_pengajuan 
                                WHERE
                                    aju.id_pengajuan = '$id'")->row_array();
    }

    function get_verified_for_wa_pengaju($id)
    {
        return $this->db->query("SELECT
                                    e_pengajuan.id_pengajuan AS no_eaf,
                                    e_kategori.nama_kategori AS `type`,
                                    e_detail_keperluan.nama_keperluan AS need,
                                    e_detail_keperluan.note AS `description`,
                                    e_detail_keperluan.nominal_uang AS amount,
                                    e_approval.`status`,
                                    e_approval.note_approve AS note,
                                    e_jenis_biaya.id_user_verified,
                                    e_approval.id_user AS id_user_verif,
                                    CONCAT( apr.first_name, ' ', apr.last_name ) AS verified_by,
                                    e_approval.update_approve AS verified_at,
                                    e_pengajuan.pengaju,
                                    CONCAT( emp.first_name, ' ', emp.last_name ) AS requested_by,
                                    emp.contact_no AS requested_contact 
                                FROM
                                    e_pengajuan
                                    JOIN e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
                                    JOIN e_detail_keperluan ON e_detail_keperluan.id_pengajuan = e_pengajuan.id_pengajuan
                                    JOIN e_jenis_biaya ON e_jenis_biaya.id_jenis = e_pengajuan.jenis
                                    JOIN (
                                    SELECT
                                        e_approval.id_pengajuan,
                                        e_approval.id_user_approval,
                                        e_approval.`status`,
                                        e_approval.update_approve,
                                        e_approval.note_approve,
                                        e_approval.id_user 
                                    FROM
                                        e_approval
                                        JOIN ( SELECT MAX( id_approval ) AS id_approval FROM e_approval WHERE `level` = 10  GROUP BY id_pengajuan ) AS max_apr ON e_approval.id_approval = max_apr.id_approval 
                                        AND `status` IS NOT NULL 
                                    ) AS e_approval ON e_approval.id_user_approval = e_jenis_biaya.id_user_verified 
                                    AND e_approval.id_pengajuan = e_pengajuan.id_pengajuan
                                    JOIN `user` AS usr ON usr.id_user = e_approval.id_user
                                    JOIN hris.xin_employees AS apr ON apr.user_id = usr.id_hr
                                    JOIN hris.xin_employees AS emp ON emp.user_id = e_pengajuan.pengaju 
                                WHERE
                                    e_pengajuan.id_pengajuan = '$id'")->row();
    }

    function get_user_verified()
    {
        return $this->db->query("SELECT id_user_verified FROM e_jenis_biaya WHERE id_user_verified IS NOT NULL GROUP BY id_user_verified")->result();
    }

    function get_detail_dlk($id)
    {
        return $this->db->query("SELECT
                                    aju.id_pengajuan,
                                    aju.jenis,
                                    aju.leave_id,
                                    IF(dlk.from_date = dlk.to_date,dlk.from_date,CONCAT(dlk.from_date,' s/d ',dlk.to_date)) AS tgl_dlk
                                FROM
                                    e_pengajuan AS aju
                                    LEFT JOIN hris.xin_leave_applications AS dlk ON dlk.leave_id = aju.leave_id
                                WHERE
                                    aju.id_pengajuan = '$id'")->row_array();
    }
}

/* End of file model_eaf.php */
/* Location: ./application/models/model_divisi.php */