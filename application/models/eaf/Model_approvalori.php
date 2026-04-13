<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_approval extends CI_Model
{

    function __construct()
    {
        parent::__construct();

        $this->load->library('upload');
    }

    function get_list_eaf($id_user, $id_div, $status, $datestart, $dateend)
    {
        if ($status == 2) {
            if ($this->session->userdata('id_user') == 1 || $this->session->userdata('id_user') == 73) {
                $kondisi = "AND DATE(e_pengajuan.tgl_input) BETWEEN '$datestart' AND '$dateend' AND e_pengajuan.`status` IN ($status)";
            } else {
                $kondisi = "AND DATE(e_pengajuan.tgl_input) BETWEEN '$datestart' AND '$dateend' AND e_pengajuan.`status` IN ($status) AND e_approval.id_user_approval = $id_user";
            }
        } else if ($status == 4) {
            if ($this->session->userdata('id_user') == 1 || $this->session->userdata('id_user') == 73) {
                $kondisi = "AND e_pengajuan.`status` IN ($status) AND e_approval.id_user_approval <> 737";
            } else {
                $kondisi = "AND e_pengajuan.`status` IN ($status) AND e_approval.id_user_approval = $id_user";
            }
        } else {
            if ($this->session->userdata('id_user') == 1 || $this->session->userdata('id_user') == 73) {
                $kondisi = "AND e_pengajuan.`status` IN ($status) AND e_approval.status IS NULL AND e_approval.id_user_approval <> 737";
            } else {
                $kondisi = "AND e_pengajuan.`status` IN ($status) AND e_approval.status IS NULL AND e_approval.id_user_approval = $id_user";
            }
        }
        $query = $this->db->query("SELECT
                                        e_pengajuan.id_pengajuan,
                                        SUBSTR( e_pengajuan.tgl_input, 1, 16 ) AS tgl_input,
                                        e_pengajuan.nama_penerima,
                                        e_pengajuan.`status`,
                                        m_divisi.divisi AS nama_divisi,
                                        `user`.employee_name AS `name`,
                                        CONCAT(pengaju.first_name, ' ', pengaju.last_name) AS pengaju,
                                        e_kategori.nama_kategori,
                                        e_pengajuan.flag,
                                        e_pengajuan.temp,
                                        e_pengajuan.id_kategori,
                                        e_m_status.nama_status,
                                        e_biaya.nama_biaya,
                                        IF ( e_jenis_biaya.id_tipe_biaya = 2, budget.budget, e_biaya.budget ) AS budget,
                                        e_jenis_biaya.id_tipe_biaya,
                                        IF(e_detail_keperluan.nama_keperluan IS NULL,e_header_lpj.nama_lpj,e_detail_keperluan.nama_keperluan) as nama_keperluan,
                                        e_header_lpj.nama_lpj,
                                        e_detail_keperluan.nominal_uang,
                                        e_header_lpj.nominal_lpj,
                                        e_detail_keperluan.note,
                                        e_header_lpj.note_lpj,
                                        e_tipe_pembayaran.nama_tipe,
                                        e_approval.id_approval,
                                        e_approval.id_user_approval,
                                        e_photo_acc.photo_acc,
                                    CASE
                                            WHEN e_pengajuan.id_kategori = 17 
                                            AND SUBSTR( e_pengajuan.tgl_input, 1, 10 ) > e_detail_keperluan.tgl_nota THEN
                                                1 ELSE 0 
                                                END AS stt_bawa 
                                        FROM
                                            e_pengajuan
                                            LEFT JOIN m_divisi ON e_pengajuan.id_divisi = m_divisi.id_divisi
                                            LEFT JOIN `user` ON e_pengajuan.id_user = `user`.id_user
                                            LEFT JOIN hris.xin_employees AS pengaju ON e_pengajuan.pengaju = pengaju.user_id
                                            LEFT JOIN e_kategori ON e_pengajuan.id_kategori = e_kategori.id_kategori
                                            LEFT JOIN e_m_status ON e_m_status.id_status = e_pengajuan.`status`
                                            LEFT JOIN e_jenis_biaya ON e_pengajuan.jenis = e_jenis_biaya.id_jenis
                                            LEFT JOIN e_biaya ON e_jenis_biaya.id_budget = e_biaya.id_budget
                                            LEFT JOIN e_detail_keperluan ON e_pengajuan.id_pengajuan = e_detail_keperluan.id_pengajuan 
                                            LEFT JOIN e_tipe_pembayaran ON e_pengajuan.id_pengajuan = e_tipe_pembayaran.id_pengajuan
                                            LEFT JOIN e_approval ON e_approval.id_pengajuan = e_pengajuan.id_pengajuan
                                            LEFT JOIN ( SELECT MAX( id_approval ) AS id_approval FROM e_approval WHERE id_user_approval IS NOT NULL GROUP BY id_pengajuan ) AS approve ON e_approval.id_approval = approve.id_approval
                                            LEFT JOIN e_photo_acc ON e_pengajuan.id_pengajuan = e_photo_acc.id_pengajuan
                                            LEFT JOIN e_header_lpj ON e_pengajuan.id_pengajuan = e_header_lpj.id_lpj
                                            LEFT JOIN (
                                            SELECT
                                                e_biaya.id_budget,
                                                e_biaya.budget 
                                            FROM
                                                e_biaya 
                                            WHERE
                                                e_biaya.minggu = WEEK ( CURDATE( ), 1 ) - WEEK ( DATE_FORMAT( CURDATE( ), '%Y-%m-01' ), 1 ) + 1 
                                            ) AS budget ON budget.id_budget = e_pengajuan.budget 
                                        WHERE
                                            e_pengajuan.id_kategori IN ( 17, 18, 19 ) 
                                            $kondisi
                                    GROUP BY
                                        e_pengajuan.id_pengajuan");
        $data['data'] = $query->result();
        return $data;
    }

    function get_list_eaf_my_approval($id_user, $id_div, $status, $datestart, $dateend)
    {
        if ($this->session->userdata('superuser') == 1 && ($this->session->userdata('id_user') == 1 || $this->session->userdata('id_user') == 61 || $this->session->userdata('id_user') == 1358 || $this->session->userdata('id_user') == 73)) {
            $where = "";
        } else {
            $where = "AND e_approval.id_user_approval = '$id_user'";
        }
        $query = $this->db->query("SELECT
                                        e_pengajuan.id_pengajuan,
                                        e_pengajuan.tgl_input,
                                        m_divisi.divisi AS nama_divisi,
                                        e_kategori.nama_kategori,
                                        e_tipe_pembayaran.nama_tipe,
                                        e_pengajuan.nama_penerima,
                                        e_biaya.nama_biaya,
                                        e_biaya.budget,
                                        IF(e_detail_keperluan.id_project IS NULL,e_detail_keperluan.nama_keperluan,CONCAT(e_detail_keperluan.nama_keperluan,' ',m_project.project,' ',COALESCE(e_detail_keperluan.blok,''))) as nama_keperluan,
                                        e_detail_keperluan.note,
                                        e_detail_keperluan.nominal_uang,
                                        e_detail_keperluan.id_project,
                                        m_project.project,
                                        e_detail_keperluan.blok,
                                        e_approval.id_approval,
                                        COALESCE(e_verified.note_approve,'') AS note_approve,
                                        e_photo_acc.photo_acc,
                                        e_jenis_biaya.id_tipe_biaya,
                                        e_jenis_biaya.id_user_verified,
                                        e_biaya.id_biaya,
                                        e_pengajuan.budget AS id_budget,
                                        e_pengajuan.jenis AS id_jenis,
                                        e_pengajuan.`status`,
                                        e_m_status.warna,
                                        e_m_status.nama_status,
                                        usr.employee_name AS `name`,
                                        usr_apr.employee_name AS user_approval,
                                        CONCAT(pengaju.first_name, ' ', pengaju.last_name) AS pengaju,
                                        CONCAT(
                                            (
                                                TIMESTAMPDIFF( HOUR, COALESCE(e_verified.update_approve, e_pengajuan.tgl_input), NOW( ) ) - COALESCE (
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
                                                        y.tgl BETWEEN DATE( COALESCE(e_verified.update_approve, e_pengajuan.tgl_input) ) 
                                                        AND CURDATE( ) 
                                                    ),
                                                    0 
                                                ) 
                                            ),
                                            ' Jam' 
                                        ) AS leadtime
                                    FROM
                                        e_pengajuan
                                        LEFT JOIN m_divisi ON m_divisi.id_divisi = e_pengajuan.id_divisi
                                        LEFT JOIN e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
                                        LEFT JOIN e_tipe_pembayaran ON e_tipe_pembayaran.id_pengajuan = e_pengajuan.id_pengajuan
                                        LEFT JOIN (
                                        SELECT
                                            id_biaya,
                                            nama_biaya,
                                            budget,
                                            id_budget 
                                        FROM
                                            e_biaya 
                                        WHERE
                                            (minggu IS NULL 
                                            OR minggu = WEEK ( CURDATE( ), 1 ) - WEEK ( DATE_FORMAT( CURDATE( ), '%Y-%m-01' ), 1 ) + 1 )
                                            AND bulan = SUBSTR(CURDATE(),6,2) AND tahun_budget = YEAR (CURDATE()) 
                                        ) AS e_biaya ON e_biaya.id_budget = e_pengajuan.budget
                                        LEFT JOIN e_detail_keperluan ON e_detail_keperluan.id_pengajuan = e_pengajuan.id_pengajuan
                                        LEFT JOIN ( SELECT id_approval, id_pengajuan, id_user_approval, note_approve FROM e_approval WHERE `level` = 1 AND `status` IS NULL ) AS e_approval ON e_approval.id_pengajuan = e_pengajuan.id_pengajuan
                                        LEFT JOIN ( SELECT id_approval, id_pengajuan, id_user_approval, note_approve, update_approve FROM e_approval WHERE `level` = 10 AND `status` = 'Approve' ) AS e_verified ON e_verified.id_pengajuan = e_pengajuan.id_pengajuan
                                        LEFT JOIN e_photo_acc ON e_photo_acc.id_pengajuan = e_pengajuan.id_pengajuan
                                        LEFT JOIN e_jenis_biaya ON e_jenis_biaya.id_jenis = e_pengajuan.jenis
                                        LEFT JOIN `user` AS usr ON usr.id_user = e_pengajuan.id_user
                                        LEFT JOIN `user` AS usr_apr ON usr_apr.id_user = e_approval.id_user_approval
                                        LEFT JOIN hris.xin_employees AS pengaju ON e_pengajuan.pengaju = pengaju.user_id
                                        LEFT JOIN e_m_status ON e_m_status.id_status = e_pengajuan.`status`
                                        LEFT JOIN m_project ON m_project.id_project = e_detail_keperluan.id_project 
                                    WHERE
                                        e_pengajuan.`status` IN ( 1 ) 
                                        $where
                                        AND e_pengajuan.id_kategori IN ( 17, 18, 20 )
                                        
                                        
                                         UNION ALL
                                    SELECT
                                        e_pengajuan.id_pengajuan,
                                        e_pengajuan.tgl_input,
                                        m_divisi.divisi AS nama_divisi,
                                        e_kategori.nama_kategori,
                                        '' AS nama_tipe,
                                        e_pengajuan.nama_penerima,
                                        e_biaya.nama_biaya,
                                        e_biaya.budget,
                                        e_jenis_biaya.jenis AS nama_keperluan,
                                        e_header_lpj.note_lpj AS note,
                                        e_header_lpj.nominal_lpj AS nominal_uang,
                                        '' as id_project,
                                        '' as project,
                                        '' as blok,
                                        e_approval.id_approval,
                                        '' as note_approve,
                                        e_photo_acc.photo_acc,
                                        e_jenis_biaya.id_tipe_biaya,
                                        e_jenis_biaya.id_user_verified,
                                        e_biaya.id_biaya AS new_id_biaya,
                                        e_pengajuan.budget AS new_id_budget,
                                        e_pengajuan.jenis AS new_id_jenis,
                                        e_pengajuan.`status`,
                                        e_m_status.warna,
                                        e_m_status.nama_status,
                                        usr.employee_name AS `name`,
                                        usr_apr.employee_name AS user_approval,
                                        CONCAT(pengaju.first_name, ' ', pengaju.last_name) AS pengaju,
                                        CONCAT(
                                            (
                                                TIMESTAMPDIFF( HOUR, e_pengajuan.tgl_input, NOW( ) ) - COALESCE (
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
                                                        y.tgl BETWEEN DATE( e_pengajuan.tgl_input ) 
                                                        AND CURDATE( ) 
                                                    ),
                                                    0 
                                                ) 
                                            ),
                                            ' Jam' 
                                        ) AS leadtime
                                    FROM
                                        e_pengajuan
                                        JOIN e_pengajuan AS ajuan ON ajuan.temp = e_pengajuan.id_pengajuan
                                        JOIN `user` AS usr ON usr.id_user = e_pengajuan.id_user
                                        LEFT JOIN hris.xin_employees AS pengaju ON e_pengajuan.pengaju = pengaju.user_id
                                        JOIN m_divisi ON m_divisi.id_divisi = e_pengajuan.id_divisi
                                        JOIN e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
                                        JOIN e_biaya ON e_biaya.id_biaya = ajuan.id_biaya
                                        JOIN e_header_lpj ON e_header_lpj.id_lpj = e_pengajuan.id_pengajuan
                                        JOIN ( SELECT id_approval, id_pengajuan, id_user_approval, note_approve FROM e_approval WHERE `level` = 1 AND `status` IS NULL ) AS e_approval ON e_approval.id_pengajuan = e_pengajuan.id_pengajuan
                                        JOIN e_photo_acc ON e_photo_acc.id_pengajuan = e_pengajuan.id_pengajuan                                        
                                        LEFT JOIN `user` AS usr_apr ON usr_apr.id_user = e_approval.id_user_approval
                                        JOIN e_jenis_biaya ON e_jenis_biaya.id_jenis = ajuan.id_sub_biaya
                                        LEFT JOIN e_m_status ON e_m_status.id_status = e_pengajuan.`status` 
                                    WHERE
                                        e_pengajuan.`status` IN ( 6 ) 
                                        $where
                                        AND e_pengajuan.id_kategori IN ( 19 )");
        $data['data'] = $query->result();
        return $data;
    }

    function get_list_eaf_my_approval_test($id_user, $id_div, $status, $datestart, $dateend)
    {
        if ($this->session->userdata('superuser') == 1 && ($this->session->userdata('id_user') == 1 || $this->session->userdata('id_user') == 61 || $this->session->userdata('id_user') == 1358 || $this->session->userdata('id_user') == 73)) {
            $where = "";
        } else {
            $where = "AND e_approval.id_user_approval = '$id_user'";
        }
        $query = $this->db->query("SELECT
                                        e_pengajuan.id_pengajuan,
                                        e_pengajuan.tgl_input,
                                        m_divisi.divisi AS nama_divisi,
                                        e_kategori.nama_kategori,
                                        e_tipe_pembayaran.nama_tipe,
                                        e_pengajuan.nama_penerima,
                                        e_biaya.nama_biaya,
                                        e_biaya.budget,
                                        IF(e_detail_keperluan.id_project IS NULL,e_detail_keperluan.nama_keperluan,CONCAT(e_detail_keperluan.nama_keperluan,' ',m_project.project,' ',COALESCE(e_detail_keperluan.blok,''))) as nama_keperluan,
                                        e_detail_keperluan.note,
                                        e_detail_keperluan.nominal_uang,
                                        e_detail_keperluan.id_project,
                                        m_project.project,
                                        e_detail_keperluan.blok,
                                        e_approval.id_approval,
                                        -- e_approval.note_approve,
                                        COALESCE(e_verified.note_approve,'') AS note_approve,
                                        e_photo_acc.photo_acc,
                                        e_jenis_biaya.id_tipe_biaya,
                                        e_jenis_biaya.id_user_verified,
                                        e_biaya.id_biaya,
                                        e_pengajuan.budget AS id_budget,
                                        e_pengajuan.jenis AS id_jenis,
                                        e_pengajuan.`status`,
                                        e_m_status.warna,
                                        e_m_status.nama_status,
                                        usr.employee_name AS `name`,
                                        CONCAT(pengaju.first_name, ' ', pengaju.last_name) AS pengaju,
                                        CONCAT(
                                            (
                                                TIMESTAMPDIFF( HOUR, COALESCE ( e_verified.update_approve, e_pengajuan.tgl_input ), NOW( ) ) - COALESCE (
                                                    (
                                                    SELECT
                                                        COUNT( x.tgl ) * 24 AS total 
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
                                                    WHERE
                                                        x.tgl BETWEEN DATE( e_pengajuan.tgl_input ) 
                                                        AND CURDATE( ) 
                                                    GROUP BY
                                                        x.tgl 
                                                    ),
                                                    0 
                                                ) 
                                            ),
                                            ' Jam' 
                                        ) AS leadtime
                                        -- CONCAT(
                                        -- IF
                                        --     (
                                        --         DAYNAME( CURDATE( ) ) = 'Monday',
                                        --         TIMESTAMPDIFF( HOUR, COALESCE ( e_verified.update_approve, e_pengajuan.tgl_input ), NOW( ) ) - 24 - (
                                        --         SELECT
                                        --             COUNT( holidays.holiday_id ) * 24 AS total 
                                        --         FROM
                                        --             hris.xin_holidays AS holidays 
                                        --         WHERE
                                        --             holidays.start_date BETWEEN COALESCE ( e_verified.update_approve, e_pengajuan.tgl_input ) 
                                        --             AND NOW( ) 
                                        --         ),
                                        --         TIMESTAMPDIFF( HOUR, COALESCE ( e_verified.update_approve, e_pengajuan.tgl_input ), NOW( ) ) - (
                                        --         SELECT
                                        --             COUNT( holidays.holiday_id ) * 24 AS total 
                                        --         FROM
                                        --             hris.xin_holidays AS holidays 
                                        --         WHERE
                                        --             holidays.start_date BETWEEN COALESCE ( e_verified.update_approve, e_pengajuan.tgl_input ) 
                                        --             AND NOW( ) 
                                        --         ) 
                                        --     ),
                                        --     ' Jam' 
                                        -- ) AS leadtime 
                                    FROM
                                        e_pengajuan
                                        LEFT JOIN m_divisi ON m_divisi.id_divisi = e_pengajuan.id_divisi
                                        LEFT JOIN e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
                                        LEFT JOIN e_tipe_pembayaran ON e_tipe_pembayaran.id_pengajuan = e_pengajuan.id_pengajuan
                                        LEFT JOIN (
                                        SELECT
                                            id_biaya,
                                            nama_biaya,
                                            budget,
                                            id_budget 
                                        FROM
                                            e_biaya 
                                        WHERE
                                            (minggu IS NULL 
                                            OR minggu = WEEK ( CURDATE( ), 1 ) - WEEK ( DATE_FORMAT( CURDATE( ), '%Y-%m-01' ), 1 ) + 1 )
                                            AND bulan = SUBSTR(CURDATE(),6,2) AND tahun_budget = YEAR (CURDATE())
                                        ) AS e_biaya ON e_biaya.id_budget = e_pengajuan.budget
                                        LEFT JOIN e_detail_keperluan ON e_detail_keperluan.id_pengajuan = e_pengajuan.id_pengajuan
                                        LEFT JOIN ( SELECT id_approval, id_pengajuan, id_user_approval, note_approve FROM e_approval WHERE `level` = 1 AND `status` IS NULL ) AS e_approval ON e_approval.id_pengajuan = e_pengajuan.id_pengajuan
                                        LEFT JOIN ( SELECT id_approval, id_pengajuan, id_user_approval, note_approve, update_approve FROM e_approval WHERE `level` = 10 AND `status` = 'Approve' ) AS e_verified ON e_verified.id_pengajuan = e_pengajuan.id_pengajuan
                                        LEFT JOIN e_photo_acc ON e_photo_acc.id_pengajuan = e_pengajuan.id_pengajuan
                                        LEFT JOIN e_jenis_biaya ON e_jenis_biaya.id_jenis = e_pengajuan.jenis
                                        LEFT JOIN `user` AS usr ON usr.id_user = e_pengajuan.id_user
                                        LEFT JOIN hris.xin_employees AS pengaju ON e_pengajuan.pengaju = pengaju.user_id
                                        LEFT JOIN e_m_status ON e_m_status.id_status = e_pengajuan.`status`
                                        LEFT JOIN m_project ON m_project.id_project = e_detail_keperluan.id_project 
                                    WHERE
                                        e_pengajuan.`status` IN ( 1 ) 
                                        $where
                                        AND e_pengajuan.id_kategori IN ( 17, 18 ) UNION ALL
                                    SELECT
                                        e_pengajuan.id_pengajuan,
                                        e_pengajuan.tgl_input,
                                        m_divisi.divisi AS nama_divisi,
                                        e_kategori.nama_kategori,
                                        '' AS nama_tipe,
                                        e_pengajuan.nama_penerima,
                                        e_biaya.nama_biaya,
                                        e_biaya.budget,
                                        e_jenis_biaya.jenis AS nama_keperluan,
                                        e_header_lpj.note_lpj AS note,
                                        e_header_lpj.nominal_lpj AS nominal_uang,
                                        '' as id_project,
                                        '' as project,
                                        '' as blok,
                                        e_approval.id_approval,
                                        '' as note_approve,
                                        e_photo_acc.photo_acc,
                                        e_jenis_biaya.id_tipe_biaya,
                                        e_jenis_biaya.id_user_verified,
                                        e_biaya.id_biaya AS new_id_biaya,
                                        e_pengajuan.budget AS new_id_budget,
                                        e_pengajuan.jenis AS new_id_jenis,
                                        e_pengajuan.`status`,
                                        e_m_status.warna,
                                        e_m_status.nama_status,
                                        usr.employee_name AS `name`,
                                        CONCAT(pengaju.first_name, ' ', pengaju.last_name) AS pengaju,
                                        CONCAT(
                                            (
                                                TIMESTAMPDIFF( HOUR, e_pengajuan.tgl_input, NOW( ) ) - COALESCE (
                                                    (
                                                    SELECT
                                                        COUNT( x.tgl ) * 24 AS total 
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
                                                    WHERE
                                                        x.tgl BETWEEN DATE( e_pengajuan.tgl_input ) 
                                                        AND CURDATE( ) 
                                                    GROUP BY
                                                        x.tgl 
                                                    ),
                                                    0 
                                                ) 
                                            ),
                                            ' Jam' 
                                        ) AS leadtime
                                        -- CONCAT(IF(
                                        --         DAYNAME( CURDATE( ) ) = 'Monday',
                                        --         HOUR( TIMEDIFF( NOW( ), e_pengajuan.tgl_input )) - 24,
                                        --         HOUR( TIMEDIFF( NOW( ), e_pengajuan.tgl_input )) 
                                        --     ),' Jam') AS leadtime 
                                    FROM
                                        e_pengajuan
                                        JOIN e_pengajuan AS ajuan ON ajuan.temp = e_pengajuan.id_pengajuan
                                        JOIN `user` AS usr ON usr.id_user = e_pengajuan.id_user
                                        LEFT JOIN hris.xin_employees AS pengaju ON e_pengajuan.pengaju = pengaju.user_id
                                        JOIN m_divisi ON m_divisi.id_divisi = e_pengajuan.id_divisi
                                        JOIN e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
                                        JOIN e_biaya ON e_biaya.id_biaya = ajuan.id_biaya
                                        JOIN e_header_lpj ON e_header_lpj.id_lpj = e_pengajuan.id_pengajuan
                                        JOIN ( SELECT id_approval, id_pengajuan, id_user_approval, note_approve FROM e_approval WHERE `level` = 1 AND `status` IS NULL ) AS e_approval ON e_approval.id_pengajuan = e_pengajuan.id_pengajuan
                                        JOIN e_photo_acc ON e_photo_acc.id_pengajuan = e_pengajuan.id_pengajuan
                                        JOIN e_jenis_biaya ON e_jenis_biaya.id_jenis = ajuan.id_sub_biaya
                                        LEFT JOIN e_m_status ON e_m_status.id_status = e_pengajuan.`status` 
                                    WHERE
                                        e_pengajuan.`status` IN ( 6 ) 
                                        $where
                                        AND e_pengajuan.id_kategori IN ( 19 )");
        $data['data'] = $query->result();
        return $data;
    }

    function get_list_eaf_all($id_user, $id_div, $status, $datestart, $dateend)
    {
        if ($this->session->userdata('superuser') == 1 && ($this->session->userdata('id_user') == 1 || $this->session->userdata('id_user') == 61 || $this->session->userdata('id_user') == 1358 || $this->session->userdata('id_user') == 73)) {
            $where = "AND DATE(e_pengajuan.tgl_input) BETWEEN '$datestart' AND '$dateend'";
        } else {
            $where = "AND DATE(e_pengajuan.tgl_input) BETWEEN '$datestart' AND '$dateend' AND e_approval.id_user_approval = '$id_user'";
        }
        $query = $this->db->query("SELECT
                                        e_pengajuan.id_pengajuan,
                                        e_pengajuan.tgl_input,
                                        m_divisi.divisi AS nama_divisi,
                                        e_kategori.nama_kategori,
                                        e_tipe_pembayaran.nama_tipe,
                                        e_pengajuan.nama_penerima,
                                        e_biaya.nama_biaya,
                                        e_biaya.budget,
                                        IF(e_detail_keperluan.id_project IS NULL,e_detail_keperluan.nama_keperluan,CONCAT(e_detail_keperluan.nama_keperluan,' ',m_project.project,' ',COALESCE(e_detail_keperluan.blok,''))) as nama_keperluan,
                                        e_detail_keperluan.note,
                                        e_detail_keperluan.nominal_uang,
                                        e_detail_keperluan.id_project,
                                        m_project.project,
                                        e_detail_keperluan.blok,
                                        e_approval.id_approval,
                                        -- e_approval.note_approve,
                                        COALESCE(e_verified.note_approve,'') AS note_approve,
                                        e_photo_acc.photo_acc,
                                        e_jenis_biaya.id_tipe_biaya,
                                        e_jenis_biaya.id_user_verified,
                                        e_biaya.id_biaya,
                                        e_pengajuan.budget AS id_budget,
                                        e_pengajuan.jenis AS id_jenis,
                                        e_pengajuan.`status`,
                                        e_m_status.warna,
                                        e_m_status.nama_status,
                                        usr.employee_name AS `name`,
                                        CONCAT(pengaju.first_name, ' ', pengaju.last_name) AS pengaju,
                                        CONCAT(IF(
                                                DAYNAME( CURDATE( ) ) = 'Monday',
                                                IF(HOUR( TIMEDIFF( NOW( ), e_pengajuan.tgl_input )) - 24 < 0, 0, HOUR( TIMEDIFF( NOW( ), e_pengajuan.tgl_input )) - 24),
                                                HOUR( TIMEDIFF( NOW( ), e_pengajuan.tgl_input )) 
                                            ),' Jam') AS leadtime
                                    FROM
                                        e_pengajuan
                                        LEFT JOIN m_divisi ON m_divisi.id_divisi = e_pengajuan.id_divisi
                                        LEFT JOIN e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
                                        LEFT JOIN e_tipe_pembayaran ON e_tipe_pembayaran.id_pengajuan = e_pengajuan.id_pengajuan
                                        LEFT JOIN (
                                        SELECT
                                            id_biaya,
                                            nama_biaya,
                                            budget,
                                            id_budget 
                                        FROM
                                            e_biaya 
                                        WHERE
                                            (minggu IS NULL 
                                            OR minggu = WEEK ( CURDATE( ), 1 ) - WEEK ( DATE_FORMAT( CURDATE( ), '%Y-%m-01' ), 1 ) + 1 )
                                            AND bulan = SUBSTR(CURDATE(),6,2) AND tahun_budget = YEAR (CURDATE())
                                        ) AS e_biaya ON e_biaya.id_budget = e_pengajuan.budget
                                        LEFT JOIN e_detail_keperluan ON e_detail_keperluan.id_pengajuan = e_pengajuan.id_pengajuan
                                        LEFT JOIN ( SELECT id_approval, id_pengajuan, id_user_approval, note_approve FROM e_approval WHERE `level` = 1 AND `status` = 'Approve' ) AS e_approval ON e_approval.id_pengajuan = e_pengajuan.id_pengajuan
                                        LEFT JOIN ( SELECT id_approval, id_pengajuan, id_user_approval, note_approve FROM e_approval WHERE `level` = 10 AND `status` = 'Approve' ) AS e_verified ON e_verified.id_pengajuan = e_pengajuan.id_pengajuan
                                        LEFT JOIN e_photo_acc ON e_photo_acc.id_pengajuan = e_pengajuan.id_pengajuan
                                        LEFT JOIN e_jenis_biaya ON e_jenis_biaya.id_jenis = e_pengajuan.jenis
                                        LEFT JOIN `user` AS usr ON usr.id_user = e_pengajuan.id_user
                                        LEFT JOIN hris.xin_employees AS pengaju ON e_pengajuan.pengaju = pengaju.user_id
                                        LEFT JOIN e_m_status ON e_m_status.id_status = e_pengajuan.`status`
                                        LEFT JOIN m_project ON m_project.id_project = e_detail_keperluan.id_project 
                                    WHERE
                                        e_pengajuan.`status` IN ( 2,3 ) 
                                        $where
                                        AND e_pengajuan.id_kategori IN ( 17, 18 ) UNION ALL
                                    SELECT
                                        e_pengajuan.id_pengajuan,
                                        e_pengajuan.tgl_input,
                                        m_divisi.divisi AS nama_divisi,
                                        e_kategori.nama_kategori,
                                        '' AS nama_tipe,
                                        e_pengajuan.nama_penerima,
                                        e_biaya.nama_biaya,
                                        e_biaya.budget,
                                        e_jenis_biaya.jenis AS nama_keperluan,
                                        e_header_lpj.note_lpj AS note,
                                        e_header_lpj.nominal_lpj AS nominal_uang,
                                        '' as id_project,
                                        m_project.project as project,
                                        '' as blok,
                                        e_approval.id_approval,
                                        '' as note_approve,
                                        e_photo_acc.photo_acc,
                                        e_jenis_biaya.id_tipe_biaya,
                                        e_jenis_biaya.id_user_verified,
                                        e_biaya.id_biaya AS new_id_biaya,
                                        e_pengajuan.budget AS new_id_budget,
                                        e_pengajuan.jenis AS new_id_jenis,
                                        e_pengajuan.`status`,
                                        e_m_status.warna,
                                        e_m_status.nama_status,
                                        usr.employee_name AS `name`,
                                        CONCAT(pengaju.first_name, ' ', pengaju.last_name) AS pengaju,
                                        CONCAT(IF(
                                                DAYNAME( CURDATE( ) ) = 'Monday',
                                                HOUR( TIMEDIFF( NOW( ), e_pengajuan.tgl_input )) - 24,
                                                HOUR( TIMEDIFF( NOW( ), e_pengajuan.tgl_input )) 
                                            ),' Jam') AS leadtime 
                                    FROM
                                        e_pengajuan
                                        JOIN e_pengajuan AS ajuan ON ajuan.temp = e_pengajuan.id_pengajuan
                                        JOIN `user` AS usr ON usr.id_user = e_pengajuan.id_user
                                        LEFT JOIN hris.xin_employees AS pengaju ON e_pengajuan.pengaju = pengaju.user_id
                                        JOIN m_divisi ON m_divisi.id_divisi = e_pengajuan.id_divisi
                                        JOIN e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
                                        JOIN e_biaya ON e_biaya.id_biaya = ajuan.id_biaya
                                        JOIN e_header_lpj ON e_header_lpj.id_lpj = e_pengajuan.id_pengajuan
                                        LEFT JOIN e_detail_keperluan ON e_detail_keperluan.id_lpj = e_pengajuan.id_pengajuan
                                        LEFT JOIN m_project ON e_detail_keperluan.id_project = m_project.id_project
                                        JOIN ( SELECT id_approval, id_pengajuan, id_user_approval FROM e_approval WHERE id_user_approval = 737 AND `status` IS NULL ) AS e_approval ON e_approval.id_pengajuan = e_pengajuan.id_pengajuan
                                        LEFT JOIN ( SELECT id_approval, id_pengajuan, id_user_approval, note_approve FROM e_approval WHERE `level` = 1 AND `status` = 'Approve' ) AS e_verified ON e_verified.id_pengajuan = e_pengajuan.id_pengajuan
                                        JOIN e_photo_acc ON e_photo_acc.id_pengajuan = e_pengajuan.id_pengajuan
                                        JOIN e_jenis_biaya ON e_jenis_biaya.id_jenis = ajuan.id_sub_biaya
                                        LEFT JOIN e_m_status ON e_m_status.id_status = e_pengajuan.`status` 
                                    WHERE
                                        e_pengajuan.`status` IN ( 6,7,8 ) 
                                        $where
                                        AND e_pengajuan.id_kategori IN ( 19 )");
        $data['data'] = $query->result();
        return $data;
    }

    function get_detail_approval($id_pengajuan)
    {
        $query = "SELECT
            e_pengajuan.id_pengajuan,
            e_pengajuan.tgl_input,
            m_divisi.divisi AS nama_divisi,
            e_kategori.nama_kategori,
            e_tipe_pembayaran.nama_tipe,
            e_pengajuan.nama_penerima,
            e_biaya.nama_biaya,
            e_biaya.budget,
            e_detail_keperluan.nama_keperluan,
            e_detail_keperluan.note,
            e_detail_keperluan.nominal_uang,
            e_approval.id_approval,
            e_photo_acc.photo_acc,
            e_jenis_biaya.id_tipe_biaya,
            e_biaya.id_biaya,
            e_pengajuan.budget AS id_budget,
            e_pengajuan.jenis AS id_jenis,
            e_pengajuan.`status`,
            e_m_status.warna,
            e_m_status.nama_status,
            usr.employee_name AS `name`,
            CONCAT( pengaju.first_name, ' ', pengaju.last_name ) AS pengaju,
            CONCAT(
            IF
                (
                    DAYNAME( CURDATE( ) ) = 'Monday',
                    HOUR ( TIMEDIFF( NOW( ), e_pengajuan.tgl_input ) ) - 24,
                    HOUR ( TIMEDIFF( NOW( ), e_pengajuan.tgl_input ) ) 
                ),
                ' Jam' 
            ) AS leadtime 
        FROM
            e_pengajuan
            LEFT JOIN m_divisi ON m_divisi.id_divisi = e_pengajuan.id_divisi
            LEFT JOIN e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
            LEFT JOIN e_tipe_pembayaran ON e_tipe_pembayaran.id_pengajuan = e_pengajuan.id_pengajuan
            LEFT JOIN (
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
                AND bulan = SUBSTR( CURDATE( ), 6, 2 ) AND tahun_budget = YEAR (CURDATE())
            ) AS e_biaya ON e_biaya.id_budget = e_pengajuan.budget
            LEFT JOIN e_detail_keperluan ON e_detail_keperluan.id_pengajuan = e_pengajuan.id_pengajuan
            LEFT JOIN ( SELECT id_approval, id_pengajuan, id_user_approval FROM e_approval WHERE id_user_approval <> 737 AND `status` IS NULL ) AS e_approval ON e_approval.id_pengajuan = e_pengajuan.id_pengajuan
            LEFT JOIN e_photo_acc ON e_photo_acc.id_pengajuan = e_pengajuan.id_pengajuan
            LEFT JOIN e_jenis_biaya ON e_jenis_biaya.id_jenis = e_pengajuan.jenis
            LEFT JOIN `user` AS usr ON usr.id_user = e_pengajuan.id_user
            LEFT JOIN hris.xin_employees AS pengaju ON e_pengajuan.pengaju = pengaju.user_id
            LEFT JOIN e_m_status ON e_m_status.id_status = e_pengajuan.`status` 
        WHERE
            e_pengajuan.`status` IN ( 1 ) 
            AND e_pengajuan.id_pengajuan = '$id_pengajuan' 
            AND e_pengajuan.id_kategori IN ( 17, 18 ) UNION ALL
        SELECT
            e_pengajuan.id_pengajuan,
            e_pengajuan.tgl_input,
            m_divisi.divisi AS nama_divisi,
            e_kategori.nama_kategori,
            '' AS nama_tipe,
            e_pengajuan.nama_penerima,
            e_biaya.nama_biaya,
            e_biaya.budget,
            e_jenis_biaya.jenis AS nama_keperluan,
            e_header_lpj.note_lpj AS note,
            e_header_lpj.nominal_lpj AS nominal_uang,
            e_approval.id_approval,
            e_photo_acc.photo_acc,
            e_jenis_biaya.id_tipe_biaya,
            e_biaya.id_biaya AS new_id_biaya,
            e_pengajuan.budget AS new_id_budget,
            e_pengajuan.jenis AS new_id_jenis,
            e_pengajuan.`status`,
            e_m_status.warna,
            e_m_status.nama_status,
            usr.employee_name AS `name`,
            CONCAT( pengaju.first_name, ' ', pengaju.last_name ) AS pengaju,
            CONCAT(
            IF
                (
                    DAYNAME( CURDATE( ) ) = 'Monday',
                    HOUR ( TIMEDIFF( NOW( ), e_pengajuan.tgl_input ) ) - 24,
                    HOUR ( TIMEDIFF( NOW( ), e_pengajuan.tgl_input ) ) 
                ),
                ' Jam' 
            ) AS leadtime 
        FROM
            e_pengajuan
            JOIN e_pengajuan AS ajuan ON ajuan.temp = e_pengajuan.id_pengajuan
            JOIN `user` AS usr ON usr.id_user = e_pengajuan.id_user
            LEFT JOIN hris.xin_employees AS pengaju ON e_pengajuan.pengaju = pengaju.user_id
            JOIN m_divisi ON m_divisi.id_divisi = e_pengajuan.id_divisi
            JOIN e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
            JOIN e_biaya ON e_biaya.id_biaya = ajuan.id_biaya
            JOIN e_header_lpj ON e_header_lpj.id_lpj = e_pengajuan.id_pengajuan
            JOIN ( SELECT id_approval, id_pengajuan, id_user_approval FROM e_approval WHERE id_user_approval <> 737 AND `status` IS NULL ) AS e_approval ON e_approval.id_pengajuan = e_pengajuan.id_pengajuan
            JOIN e_photo_acc ON e_photo_acc.id_pengajuan = e_pengajuan.id_pengajuan
            JOIN e_jenis_biaya ON e_jenis_biaya.id_jenis = ajuan.id_sub_biaya
            LEFT JOIN e_m_status ON e_m_status.id_status = e_pengajuan.`status` 
        WHERE
            e_pengajuan.`status` IN ( 6 ) 
            AND e_pengajuan.id_pengajuan = '$id_pengajuan' 
            AND e_pengajuan.id_kategori IN ( 19 )";

        return $this->db->query($query)->row_array();
    }

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

    function get_lpj($id)
    {
        $query = $this->db->query("SELECT
                                        e_header_lpj.id_lpj,
                                        e_header_lpj.id_pengajuan,
                                        -- e_jenis_biaya.jenis as nama_lpj,
                                        IF(ajuan.id_sub_biaya = ajuan.jenis,e_header_lpj.nama_lpj,e_jenis_biaya.jenis) AS nama_lpj,
                                        e_header_lpj.note_lpj,
                                        ajuan.total_pengajuan,
                                        e_header_lpj.nominal_lpj,
                                        ajuan.total_pengajuan - e_header_lpj.nominal_lpj AS sisa_lpj 
                                    FROM
                                        e_pengajuan
                                        JOIN e_header_lpj ON e_header_lpj.id_lpj = e_pengajuan.id_pengajuan
                                        JOIN e_pengajuan AS ajuan ON ajuan.id_pengajuan = e_header_lpj.id_pengajuan 
                                        JOIN e_jenis_biaya ON e_jenis_biaya.id_jenis = ajuan.id_sub_biaya
                                    WHERE
                                        e_pengajuan.id_pengajuan = '$id'");
        $data['data'] = $query->result();
        return $data;
    }

    function get_id_approval_null($id)
    {
        return $this->db->query("SELECT id_approval, id_user_approval FROM e_approval WHERE id_pengajuan = '$id' AND `status` IS NULL")->row_array();
    }

    // function get_ba_old($id)
    // {
    //     return $this->db->query("SELECT
    //                                 e_pengajuan.id_pengajuan,
    //                                 e_pengajuan.nama_penerima,
    //                                 e_pengajuan.tgl_input,
    //                                 e_pengajuan.note,
    //                                 e_header_lpj.nominal_lpj,
    //                                 e_header_lpj.nama_lpj,
    //                                 approval.id_user_approval,
    //                                 usr.employee_name 
    //                             FROM
    //                                 e_pengajuan
    //                                 LEFT JOIN e_header_lpj ON e_header_lpj.id_lpj = e_pengajuan.id_pengajuan
    //                                 LEFT JOIN ( SELECT id_pengajuan, id_user_approval FROM e_approval WHERE id_pengajuan = '$id' AND `level` = 1 AND `status` = 'Approve' ) AS approval ON approval.id_pengajuan = e_pengajuan.id_pengajuan
    //                                 LEFT JOIN `user` AS usr ON usr.id_user = approval.id_user_approval 
    //                             WHERE
    //                                 e_pengajuan.id_pengajuan = '$id'")->row_array();
    // }

    // Tambahan BA DLK Uang Makan Diketahui Fafri, langsung ke Finance
    function get_ba($id)
    {
        return $this->db->query("SELECT
                                    e_pengajuan.id_pengajuan,
                                    e_pengajuan.nama_penerima,
                                    e_pengajuan.tgl_input,
                                    e_pengajuan.note,
                                    e_header_lpj.nominal_lpj,
                                    e_header_lpj.nama_lpj,
                                    COALESCE ( approval.id_user_approval, verified.id_user_approval ) AS id_user_approval,
                                    COALESCE ( usr.employee_name, usr_ver.employee_name ) AS employee_name 
                                FROM
                                    e_pengajuan
                                    LEFT JOIN e_header_lpj ON e_header_lpj.id_lpj = e_pengajuan.id_pengajuan
                                    LEFT JOIN ( SELECT id_pengajuan, id_user_approval FROM e_approval WHERE id_pengajuan = '$id' AND `level` = 1 AND `status` = 'Approve' ) AS approval ON approval.id_pengajuan = e_pengajuan.id_pengajuan
                                    LEFT JOIN `user` AS usr ON usr.id_user = approval.id_user_approval
                                    LEFT JOIN ( SELECT id_pengajuan, id_user_approval FROM e_approval WHERE id_pengajuan = '$id' AND `level` = 10 AND `status` = 'Approve' ) AS verified ON verified.id_pengajuan = e_pengajuan.id_pengajuan
                                    LEFT JOIN `user` AS usr_ver ON usr_ver.id_user = verified.id_user_approval 
                                WHERE
                                    e_pengajuan.id_pengajuan = '$id'")->row_array();
    }

    function get_ba_reimburse($id)
    {
        return $this->db->query("SELECT
                                    e_pengajuan.id_pengajuan,
                                    e_pengajuan.nama_penerima,
                                    e_pengajuan.tgl_input,
                                    e_pengajuan.note,
                                    e_detail_keperluan.nominal_uang AS nominal_lpj,
                                    e_detail_keperluan.nama_keperluan AS nama_lpj,
                                    COALESCE ( approval.id_user_approval, verified.id_user_approval ) AS id_user_approval,
                                    COALESCE ( usr.employee_name, usr_ver.employee_name ) AS employee_name 
                                FROM
                                    e_pengajuan
                                    LEFT JOIN e_detail_keperluan ON e_detail_keperluan.id_pengajuan = e_pengajuan.id_pengajuan
                                    LEFT JOIN ( SELECT id_pengajuan, id_user_approval FROM e_approval WHERE id_pengajuan = '$id' AND `level` = 1 AND `status` = 'Approve' ) AS approval ON approval.id_pengajuan = e_pengajuan.id_pengajuan
                                    LEFT JOIN `user` AS usr ON usr.id_user = approval.id_user_approval
                                    LEFT JOIN ( SELECT id_pengajuan, id_user_approval FROM e_approval WHERE id_pengajuan = '$id' AND `level` = 10 AND `status` = 'Approve' ) AS verified ON verified.id_pengajuan = e_pengajuan.id_pengajuan
                                    LEFT JOIN `user` AS usr_ver ON usr_ver.id_user = verified.id_user_approval 
                                WHERE
                                    e_pengajuan.id_pengajuan = '$id'")->row_array();
    }

    function get_approval_for_wa($id)
    {
        return $this->db->query("SELECT
                                    e_pengajuan.id_pengajuan as no_eaf,
                                    e_kategori.nama_kategori as `type`,
                                    e_detail_keperluan.nama_keperluan as need,
                                    e_detail_keperluan.note as `description`,
                                    e_detail_keperluan.nominal_uang as amount,
                                    e_approval.`status`,
                                    e_approval.note_approve as note,
                                    e_jenis_biaya.id_user_approval,
                                    e_approval.id_user AS id_user_approve,
                                    CONCAT(apr.first_name,' ',apr.last_name) AS approve_to,
                                    e_approval.update_approve as approved_at,
                                    e_pengajuan.pengaju,
                                    CONCAT( emp.first_name, ' ', emp.last_name ) AS requested_by,
                                    emp.contact_no as requested_contact
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
                                        JOIN ( SELECT MAX( id_approval ) AS id_approval FROM e_approval WHERE `level` IN (1,4) GROUP BY id_pengajuan ) AS max_apr ON e_approval.id_approval = max_apr.id_approval AND `status` IS NOT NULL
                                    ) AS e_approval ON e_approval.id_user_approval = e_jenis_biaya.id_user_approval 
                                    AND e_approval.id_pengajuan = e_pengajuan.id_pengajuan
                                    JOIN `user` AS usr ON usr.id_user = e_approval.id_user_approval
                                    JOIN hris.xin_employees AS apr ON apr.user_id = usr.id_hr
                                    JOIN hris.xin_employees AS emp ON emp.user_id = e_pengajuan.pengaju 
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

    function cek_approval($id)
    {
        return $this->db->query("SELECT * FROM e_approval WHERE id_pengajuan = '$id' AND `level` = 1 AND `status` = 'Approve'");
    }

    function cek_sisa_budget($id_pengajuan)
    {
        return $this->db->query("SELECT
                                    COALESCE(mingguan.budget,bulanan.id_biaya) AS id_biaya,
                                    IF ( jb.id_tipe_biaya IN ( 1, 4 ), 'Unlimited', 'Limited' ) AS jenis,
                                    IF ( jb.id_tipe_biaya = 2, mingguan.budget, bulanan.budget ) AS budget,
                                    jb.id_tipe_biaya
                                FROM
                                    e_pengajuan AS aju
                                    JOIN e_jenis_biaya AS jb ON jb.id_budget = aju.budget 
                                    AND jb.id_jenis = aju.jenis
                                    LEFT JOIN (
                                    SELECT
                                        id_biaya,
                                        id_budget,
                                        budget
                                    FROM
                                        e_biaya 
                                    WHERE
                                        bulan = SUBSTR( CURDATE(), 6, 2 ) 
                                        AND tahun_budget = YEAR (
                                        CURDATE()) 
                                        AND minggu IS NULL
                                    ) AS bulanan ON bulanan.id_budget = jb.id_budget 
                                    LEFT JOIN (
                                    SELECT
                                        id_biaya,
                                        id_budget,
                                        budget
                                    FROM
                                        e_biaya 
                                    WHERE
                                        minggu = WEEK ( CURDATE( ), 1 ) - WEEK ( DATE_FORMAT( CURDATE( ), '%Y-%m-01' ), 1 ) + 1 
                                        AND bulan = SUBSTR( CURDATE(), 6, 2 ) 
                                        AND tahun_budget = YEAR (
                                        CURDATE()) 
                                    ) AS mingguan ON mingguan.id_budget = jb.id_budget 
                                WHERE
                                    aju.id_pengajuan = '$id_pengajuan'")->row_array();
    }
}

/* End of file model_eaf.php */
/* Location: ./application/models/model_divisi.php */