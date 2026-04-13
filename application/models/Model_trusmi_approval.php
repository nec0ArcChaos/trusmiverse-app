<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_trusmi_approval extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function dt_trusmi_approval($id_status, $start, $end)
    {
        $department_id = $this->session->userdata('department_id');
        $user_id = $this->session->userdata('user_id');
        $user_role_id = $this->session->userdata('user_role_id');
        if ($id_status == 'all') {
            // 323 Pak Hendra
            // 68 Busines Improvement
            $where = "WHERE SUBSTR(trusmi_approval.created_at,1,10) BETWEEN '$start' AND '$end' AND (trusmi_approval.created_by = '$user_id' OR trusmi_approval.approve_to = '$user_id')";
            if (in_array($department_id, ['68', '1','117'])) {
                $where = "WHERE SUBSTR(trusmi_approval.created_at,1,10) BETWEEN '$start' AND '$end'";
            }
            if (in_array($user_id, ['323', '1139', '6486'])) {
                $where = "WHERE SUBSTR(trusmi_approval.created_at,1,10) BETWEEN '$start' AND '$end'";
            }
            // if ($user_role_id == 1) {
            //     $where = "WHERE SUBSTR(trusmi_approval.created_at,1,10) BETWEEN '$start' AND '$end'";
            // }
        } else {
            $where = "WHERE trusmi_approval.status IN ('1','4','5','6') AND (trusmi_approval.created_by = '$user_id' OR trusmi_approval.approve_to = '$user_id')";
            if (in_array($department_id, ['68', '1','117'])) {
                $where = "WHERE trusmi_approval.status IN ('1','4','5','6')";
            }
            if (in_array($user_id, ['323', '1139', '6486'])) {
                $where = "WHERE trusmi_approval.status IN ('1','4','5','6')";
            }
            // if ($user_role_id == 1 && $user_id != '801') {
            //     $where = "WHERE trusmi_approval.status IN ('1','4','5','6')";
            // }
        }
        return $this->db->query("SELECT
        no_app,
        `subject`,
        `description`,
        file_1,
        file_2,
        trusmi_approval.created_by AS id_approve_by,
        CONCAT( pic_approve_to.first_name, ' ', pic_approve_to.last_name ) AS approve_to,
        pic_approve_to.profile_picture AS approve_to_pic,
        trusmi_approval.created_at AS created_at_hour,
        SUBSTR( trusmi_approval.created_at, 1, 10 ) AS created_at,
        SUBSTR( trusmi_approval.created_at, 12, 5 ) AS created_hour,
        CONCAT( pic_request.first_name, ' ', pic_request.last_name ) AS created_by,
        pic_request.profile_picture AS created_by_pic,
        trusmi_approval.`status` AS id_status,
        trusmi_m_status.`status`,
        trusmi_approval.`kategori`,
        trusmi_approval.`nominal`,
        trusmi_approval.`id_eaf`,
        SUBSTR( approve_at, 1, 10 ) AS approve_at,
        SUBSTR( approve_at, 12, 5 ) AS approve_hour,
        CONCAT( pic_approve_by.first_name, ' ', pic_approve_by.last_name ) AS approve_by,
        pic_approve_by.profile_picture AS approve_by_pic,
        approve_note,
        IF( TIMESTAMPDIFF(HOUR, trusmi_approval.created_at,if(trusmi_approval.approve_at is NULL,CURRENT_TIMESTAMP(),trusmi_approval.approve_at)) > 12 , 12 , TIMESTAMPDIFF(HOUR, trusmi_approval.created_at,if(trusmi_approval.approve_at is NULL,CURRENT_TIMESTAMP(),trusmi_approval.approve_at)) )  AS leadtime,
        if(TIMESTAMPDIFF(HOUR, trusmi_approval.created_at,if(trusmi_approval.approve_at is NULL,CURRENT_TIMESTAMP(),trusmi_approval.approve_at)) > 9,'Late','Ontime') AS keterangan,
        trusmi_approval.old_no_app
        FROM
        trusmi_approval
        LEFT JOIN xin_employees pic_request ON pic_request.user_id = trusmi_approval.created_by
        LEFT JOIN xin_employees pic_approve_to ON pic_approve_to.user_id = trusmi_approval.approve_to
        LEFT JOIN xin_employees pic_approve_by ON pic_approve_by.user_id = trusmi_approval.approve_by
        LEFT JOIN trusmi_m_status ON trusmi_m_status.id = trusmi_approval.status
        $where ORDER BY trusmi_approval.created_at DESC
        ");
    }


    function get_trusmi_approval_by_no_app($no_app)
    {
        return $this->db->query("SELECT
        no_app,
        `subject`,
        `description`,
        file_1,
        file_2,
        pic_approve_to.user_id AS user_id_approve_to,
        CONCAT( pic_approve_to.first_name, ' ', pic_approve_to.last_name ) AS approve_to,
        pic_approve_to.profile_picture AS approve_to_pic,
        SUBSTR( trusmi_approval.created_at, 1, 10 ) AS created_at,
        SUBSTR( trusmi_approval.created_at, 12, 5 ) AS created_hour,
        CONCAT( pic_request.first_name, ' ', pic_request.last_name ) AS created_by,
        trusmi_approval.created_by AS created_by_id,
        pic_request.profile_picture AS created_by_pic,
        pic_request.contact_no AS created_by_contact,
        pic_approve_to.contact_no AS approve_to_contact,
        pic_approve_to.username AS approve_to_username,
        pic_approve_to.user_id AS approve_to_user_id,
        trusmi_approval.`status` AS id_status,
        trusmi_approval.`kategori`,
        trusmi_approval.`nominal`,
        trusmi_m_status.`status`,
        SUBSTR( approve_at, 1, 10 ) AS approve_at,
        trusmi_approval.approve_by AS id_approve_by,
        CONCAT( pic_approve_by.first_name, ' ', pic_approve_by.last_name ) AS approve_by,
        pic_approve_by.profile_picture AS approve_by_pic,
        approve_note,
        TIMESTAMPDIFF(HOUR, trusmi_approval.created_at,if(trusmi_approval.approve_at is NULL,CURRENT_DATE(),trusmi_approval.approve_at)) AS leadtime,
        if(TIMESTAMPDIFF(HOUR, trusmi_approval.created_at,if(trusmi_approval.approve_at is NULL,CURRENT_DATE(),trusmi_approval.approve_at)) > 9,'Late','Ontime') AS keterangan
        FROM
        trusmi_approval
        LEFT JOIN xin_employees pic_request ON pic_request.user_id = trusmi_approval.created_by
        LEFT JOIN xin_employees pic_approve_to ON pic_approve_to.user_id = trusmi_approval.approve_to
        LEFT JOIN xin_employees pic_approve_by ON pic_approve_by.user_id = trusmi_approval.approve_by
        LEFT JOIN trusmi_m_status ON trusmi_m_status.id = trusmi_approval.status
        WHERE trusmi_approval.no_app = '$no_app'
        ");
    }

    function no_app()
    {
        $q = $this->db->query("SELECT
        MAX( RIGHT ( trusmi_approval.no_app, 3 ) ) AS kd_max 
        FROM
        trusmi_approval 
        WHERE
        SUBSTR( trusmi_approval.created_at, 1, 10 ) = CURDATE( )");
        $kd = "";

        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }
        return 'AP' . date('ymd') . $kd;
    }

    public function save($data)
    {
        return $this->db->insert('trusmi_approval', $data);
    }

    function get_pengaju_eaf()
    {
        $query = "SELECT
                        em.user_id AS id_user,
                        CONCAT( em.first_name, ' ', em.last_name, '( ',dp.department_name,' )' ) AS employee_name,
                        dp.department_name AS divisi
                    FROM
                        xin_employees AS em
                        LEFT JOIN xin_departments as dp ON dp.department_id = em.department_id
                    WHERE
                        ( em.company_id IN ( 1, 2 ) OR em.user_id = 1543 ) 
                        AND em.is_active = 1 AND em.user_id <> 1
                        OR em.`user_id` = 2493";

        return $this->db->query($query);
    }

    function get_kategori_eaf()
    {
        return $this->db->query("SELECT * from rsp_project_live.e_kategori ek WHERE ek.id_kategori IN (17,18,20,21)");
    }

    function jenis_biaya_eaf()
    {
        $query = "SELECT
            e_jenis.id_jenis,
            e_jenis.id_tipe_biaya,
            e_biaya.id_budget AS id_biaya,
            e_jenis.jenis,
            e_biaya.budget_awal,
            IF ( e_jenis.id_tipe_biaya = 4, e_biaya.budget_awal, COALESCE ( e_biaya.budget, 'Unlimited' ) ) AS budget,
            e_biaya.tahun_budget,
            e_biaya.bulan,
            e_biaya.minggu,
            e_jenis.id_user_approval,
            e_jenis.project,
            e_jenis.blok,
            e_jenis.id_user_verified,
            e_jenis.ba,
            usr.id_divisi,
            IF(usr.employee_name = 'RI 2', 'Hendra Arya Cahyadi', usr.employee_name) AS employee
        FROM
            rsp_project_live.e_jenis_biaya e_jenis
            JOIN rsp_project_live.e_biaya e_biaya ON e_jenis.id_budget = e_biaya.id_budget 
            JOIN rsp_project_live.`user` usr ON e_jenis.id_user_approval = usr.id_user
        WHERE
            e_jenis.jenis NOT LIKE 'XXX%' AND 
        (
            (
                e_biaya.tahun_budget = DATE_FORMAT( CURDATE( ), '%Y' ) 
                AND e_biaya.bulan = DATE_FORMAT( CURDATE( ), '%m' ) 
                AND e_biaya.minggu IS NULL 
            ) 
            OR 
            (
                e_biaya.tahun_budget = DATE_FORMAT( CURDATE( ), '%Y' ) 
                AND e_biaya.bulan = DATE_FORMAT( CURDATE( ), '%m' ) 
                AND e_biaya.minggu = WEEK ( CURDATE( ), 1 ) - WEEK ( DATE_FORMAT( CURDATE( ), '%Y-%m-01' ), 1 ) + 1 
            )
        ) AND e_jenis.id_jenis != 711 AND e_jenis.list_dlk_department_id IS NULL";
        // Note : jenis_biaya yang digunakan untuk DLK Uang Makan tidak di munculkan untuk yang Manual
        return $this->db->query($query);
    }

    function get_project_eaf()
    {
        // Hidden Project TL Kayangan (not used) dan RN Kondangsari (NA)
        return $this->db->query("SELECT mp.id_project, mp.project FROM rsp_project_live.m_project mp WHERE mp.active = 1")->result();
    }

    function get_blok_eaf($id, $type, $id_jenis)
    {
        $blok_1 = "SELECT
                        all_in.id_project,
                        all_in.blok 
                    FROM
                        ( SELECT * FROM rsp_project_live.m_project_unit unit WHERE unit.id_project = '$id' ) AS all_in
                        LEFT JOIN (
                        SELECT
                            det.id_project,
                            unit.blok 
                        FROM
                            rsp_project_live.m_project_unit AS unit
                            LEFT JOIN rsp_project_live.e_detail_keperluan AS det ON det.id_project = unit.id_project 
                            AND FIND_IN_SET( unit.blok, det.blok )
                            LEFT JOIN rsp_project_live.e_pengajuan AS aju ON aju.id_pengajuan = det.id_pengajuan 
                        WHERE
                            aju.`status` NOT IN ( 4, 5, 11 ) 
                            AND unit.id_project= '$id' 
                            AND aju.jenis = '$id_jenis'
                        ) AS used ON used.id_project = all_in.id_project 
                        AND used.blok = all_in.blok 
                    WHERE
                        used.blok IS NULL
                    ORDER BY
                        all_in.blok";
        $blok_2 = "SELECT
                        sp3k.id_project,
                        sp3k.blok 
                    FROM
                        (
                        SELECT
                            x.id_project,
                            x.blok 
                        FROM
                            (
                            SELECT
                                gci.id_project,
                                gci.blok 
                            FROM
                                rsp_project_live.t_interview interview
                                JOIN rsp_project_live.t_gci gci ON gci.id_gci = interview.id_gci 
                            WHERE
                                interview.hasil_int = 1 
                                AND gci.id_kategori IN ( 3, 4, 5 ) 
                                AND SUBSTR( gci.blok, 1, 2 ) != 'RD' 
                                AND gci.id_project = '$id' UNION ALL
                            SELECT
                                spr.id_project,
                                spr.blok 
                            FROM
                                rsp_project_live.t_spr spr
                            WHERE
                                spr.jenis LIKE 'CASH%' 
                                AND DATE( spr.created_at ) > '2021-01-01'		
                            GROUP BY
                                spr.id_project,
                                spr.blok 
                            ) AS x 
                        WHERE
                            spr.id_project = '$id' 
                        ) AS sp3k
                        LEFT JOIN (
                        SELECT
                            x.id_project,
                            x.blok 
                        FROM
                            (
                            SELECT
                                gci.id_project,
                                gci.blok 
                            FROM
                                rsp_project_live.t_interview interview
                                JOIN rsp_project_live.t_gci gci ON gci.id_gci = interview.id_gci 
                            WHERE
                                interview.hasil_int = 1 
                                AND gci.id_kategori IN ( 3, 4, 5 ) 
                                AND SUBSTR( gci.blok, 1, 2 ) != 'RD' 
                                AND gci.id_project = '$id' UNION ALL
                            SELECT
                                spr.id_project,
                                spr.blok 
                            FROM
                                rsp_project_live.t_spr spr
                            WHERE
                                spr.jenis LIKE 'CASH%' 
                                AND DATE( spr.created_at ) > '2021-01-01' 
                            ) AS x
                            LEFT JOIN rsp_project_live.e_detail_keperluan AS det ON det.id_project = x.id_project 
                            AND FIND_IN_SET( x.blok, det.blok )
                            LEFT JOIN rsp_project_live.e_pengajuan AS aju ON aju.id_pengajuan = det.id_pengajuan 
                        WHERE
                            aju.`status` NOT IN ( 4, 5, 11 ) 
                            AND x.id_project = '$id' 
                            AND aju.jenis = '$id_jenis' 
                        ) AS used ON used.id_project = sp3k.id_project 
                        AND used.blok = sp3k.blok 
                    WHERE
                        used.blok IS NULL 
                    ORDER BY
                        sp3k.blok";
        $blok_3 = "SELECT
                        akad.id_project,
                        akad.blok
                    FROM
                        (
                        SELECT
                            gci.id_project,
                            gci.blok 
                        FROM
                            rsp_project_live.t_akad t_akad
                            JOIN rsp_project_live.t_gci gci ON gci.id_konsumen = t_akad.id_konsumen 
                        WHERE
                            t_akad.hasil_akad = 1 
                            AND gci.id_kategori IN ( 3, 4, 5 ) 
                            AND SUBSTR( gci.blok, 1, 2 ) != 'RD' 
                            AND gci.id_project = '$id' 
                        GROUP BY gci.blok
                        ) AS akad
                        LEFT JOIN (
                        SELECT
                            t_gci.id_project,
                            t_gci.blok 
                        FROM
                            rsp_project_live.t_akad t_akad
                            JOIN rsp_project_live.t_gci gci ON gci.id_konsumen = t_akad.id_konsumen
                            LEFT JOIN rsp_project_live.e_detail_keperluan AS det ON det.id_project = gci.id_project 
                            AND FIND_IN_SET( gci.blok, det.blok )
                            LEFT JOIN rsp_project_live.e_pengajuan AS aju ON aju.id_pengajuan = det.id_pengajuan 
                        WHERE
                            aju.`status` NOT IN ( 4, 5, 11 ) 
                            AND t_akad.hasil_akad = 1 
                            AND gci.id_kategori IN ( 3, 4, 5 ) 
                            AND SUBSTR( gci.blok, 1, 2 ) != 'RD' 
                            AND gci.id_project = '$id' 
                            AND aju.jenis = '$id_jenis'
                        GROUP BY t_gci.blok
                        ) AS used ON used.id_project = akad.id_project 
                        AND used.blok = akad.blok 
                    WHERE
                        used.blok IS NULL 
                    ORDER BY
                        akad.blok";

        if ($type == 1) {
            return $this->db->query($blok_1)->result();
        } else if ($type == 2) {
            return $this->db->query($blok_2)->result();
        } else if ($type == 3) {
            return $this->db->query($blok_3)->result();
        }
    }

    function cek_dlk_new_eaf($id_hr)
    {
        $query = "SELECT
            dlk.leave_id,
            dlk.id_pengajuan,
            dlk.from_date,
            dlk.to_date,
            dlk.start_time,
            dlk.end_time,
            dlk.reason,
            dlk.total_makan,
            dlk.zona,
            dlk.uang_makan,
            dlk.total_makan * dlk.uang_makan AS total_eaf,
            dlk.kota,
            dlk.department_id,
            dlk.department_name
        FROM
            (
            SELECT
                hris.xin_leave_applications.leave_id,
                hris.xin_leave_applications.from_date,
                hris.xin_leave_applications.to_date,
                hris.xin_leave_applications.start_time,
                hris.xin_leave_applications.end_time,
                hris.xin_leave_applications.reason,
                CAST( ( DATEDIFF( hris.xin_leave_applications.to_date, hris.xin_leave_applications.from_date ) + 1 ) * 3 AS UNSIGNED ) - 
                CAST(
                    ( CASE
                        WHEN hris.xin_leave_applications.start_time BETWEEN '01:00:00' AND '10:00:00' THEN 0 
                        WHEN hris.xin_leave_applications.start_time BETWEEN '10:01:00' AND '15:00:00' THEN 1 
                        WHEN hris.xin_leave_applications.start_time BETWEEN '15:01:00' AND '24:00:00' THEN 2 
                    END ) + ( CASE
                        WHEN hris.xin_leave_applications.end_time BETWEEN '01:00:00' AND '10:00:00' THEN 2 
                        WHEN hris.xin_leave_applications.end_time BETWEEN '10:01:00' AND '15:00:00' THEN 1 
                        WHEN hris.xin_leave_applications.end_time BETWEEN '15:01:00' AND '24:00:00' THEN 0 
                    END ) 
                AS UNSIGNED ) AS total_makan,
                hris.trusmi_kota.zona,
                CASE
                    WHEN hris.trusmi_kota.zona = 1 THEN hris.xin_user_roles.zona_1 
                    WHEN hris.trusmi_kota.zona = 2 THEN hris.xin_user_roles.zona_2 
                    WHEN hris.trusmi_kota.zona = 3 THEN hris.xin_user_roles.zona_3 
                END AS uang_makan,
                eaf.id_pengajuan,
                hris.trusmi_kota.city AS kota,
                hris.xin_employees.department_id,
                hris.xin_departments.department_name
            FROM
                hris.xin_leave_applications
                JOIN hris.xin_employees ON hris.xin_leave_applications.employee_id = hris.xin_employees.user_id
                JOIN hris.xin_user_roles ON hris.xin_employees.ctm_posisi = hris.xin_user_roles.role_name
                JOIN hris.trusmi_kota ON hris.xin_leave_applications.kota = hris.trusmi_kota.id 
                LEFT JOIN rsp_project_live.e_pengajuan AS eaf ON hris.xin_leave_applications.leave_id = eaf.leave_id AND eaf.`status` != 10                
                LEFT JOIN hris.xin_departments ON hris.xin_departments.department_id = hris.xin_employees.department_id
            WHERE
                hris.xin_leave_applications.leave_type_id = 13 
                AND hris.xin_leave_applications.`status` = 2 
                AND hris.xin_leave_applications.employee_id = $id_hr 
                AND ( eaf.id_pengajuan IS NULL OR eaf.`status` IN (4,5,11) )
            ORDER BY
                hris.xin_leave_applications.leave_id
            ) AS dlk";

        return $this->db->query($query);
    }

    function jenis_biaya_dlk_new($department_id)
    {
        $query = "SELECT
            e_jenis_biaya.id_jenis,
            e_jenis_biaya.id_tipe_biaya,
            e_biaya.id_budget AS id_biaya,
            e_jenis_biaya.jenis,
            e_biaya.budget_awal,
            IF ( e_jenis_biaya.id_tipe_biaya = 4, e_biaya.budget_awal, COALESCE ( e_biaya.budget, 'Unlimited' ) ) AS budget,
            e_biaya.tahun_budget,
            e_biaya.bulan,
            e_biaya.minggu,
            e_jenis_biaya.id_user_approval,
            e_jenis_biaya.project,
            e_jenis_biaya.blok,
            e_jenis_biaya.id_user_verified,
            usr.id_divisi,
            IF(usr.employee_name = 'RI 2', 'Hendra Arya Cahyadi', usr.employee_name) AS employee
        FROM
            rsp_project_live.e_jenis_biaya e_jenis_biaya
            JOIN rsp_project_live.e_biaya as e_biaya ON e_jenis_biaya.id_budget = e_biaya.id_budget 
            JOIN rsp_project_live.`user` as usr ON e_jenis_biaya.id_user_approval = usr.id_user
        WHERE
            e_jenis_biaya.jenis NOT LIKE 'XXX%' AND 
        (
            (
                e_biaya.tahun_budget = DATE_FORMAT( CURDATE( ), '%Y' ) 
                AND e_biaya.bulan = DATE_FORMAT( CURDATE( ), '%m' ) 
                AND e_biaya.minggu IS NULL 
            )
            OR 
            (
                e_biaya.tahun_budget = DATE_FORMAT( CURDATE( ), '%Y' ) 
                AND e_biaya.bulan = DATE_FORMAT( CURDATE( ), '%m' ) 
                AND e_biaya.minggu = WEEK ( CURDATE( ), 1 ) - WEEK ( DATE_FORMAT( CURDATE( ), '%Y-%m-01' ), 1 ) + 1 
            )
        ) AND FIND_IN_SET($department_id,e_jenis_biaya.list_dlk_department_id)";
        return $this->db->query($query);
    }

    function get_follow_up_notif()
    {
        $query = $this->db->query(
            "SELECT
                t_fu.no_app,
                `subject`,
                `description`,
                CONCAT( pic_approve_to.first_name, ' ', pic_approve_to.last_name ) AS approve_to,
                pic_approve_to.user_id    AS approve_to_userid,
                pic_approve_to.username   AS approve_to_username,
                pic_approve_to.contact_no AS approve_to_contact,
                SUBSTR( trusmi_approval.created_at, 1, 10 ) AS requested_at,
                SUBSTR( trusmi_approval.created_at, 12, 5 ) AS requested_hour,
                CONCAT( pic_request.first_name, ' ', pic_request.last_name ) AS requested_by,
                trusmi_approval.`status`  AS id_status,
                trusmi_m_status.`status`,
                SUBSTR( approve_at, 1, 10 ) AS approve_at,
                CONCAT( pic_approve_by.first_name, ' ', pic_approve_by.last_name ) AS approve_by,
                approve_note,
                CONCAT( leadtime, ' jam' ) AS leadtime,
                ket_wa
            FROM (
                -- Status 1 (Pending) → FU1 setelah >= 3 jam
                SELECT
                    no_app,
                    TIMESTAMPDIFF(HOUR, created_at, IF(approve_at IS NULL, CURRENT_TIMESTAMP(), approve_at)) AS leadtime,
                    IF(TIMESTAMPDIFF(HOUR, created_at, IF(approve_at IS NULL, CURRENT_TIMESTAMP(), approve_at)) >= 3, 'FU1', 'DONE') AS ket_wa
                FROM trusmi_approval
                WHERE `status` = 1
 
                UNION
 
                -- Status 4 (FU1) → FU2 setelah >= 6 jam
                SELECT
                    no_app,
                    TIMESTAMPDIFF(HOUR, created_at, IF(approve_at IS NULL, CURRENT_TIMESTAMP(), approve_at)) AS leadtime,
                    IF(TIMESTAMPDIFF(HOUR, created_at, IF(approve_at IS NULL, CURRENT_TIMESTAMP(), approve_at)) >= 6, 'FU2', 'DONE') AS ket_wa
                FROM trusmi_approval
                WHERE `status` = 4
 
                UNION
 
                -- Status 5 (FU2) → FU3 setelah >= 9 jam
                SELECT
                    no_app,
                    TIMESTAMPDIFF(HOUR, created_at, IF(approve_at IS NULL, CURRENT_TIMESTAMP(), approve_at)) AS leadtime,
                    IF(TIMESTAMPDIFF(HOUR, created_at, IF(approve_at IS NULL, CURRENT_TIMESTAMP(), approve_at)) >= 9, 'FU3', 'DONE') AS ket_wa
                FROM trusmi_approval
                WHERE `status` = 5
 
                UNION
 
                -- Status 6 (FU3) → End setelah >= 12 jam
                SELECT
                    no_app,
                    TIMESTAMPDIFF(HOUR, created_at, IF(approve_at IS NULL, CURRENT_TIMESTAMP(), approve_at)) AS leadtime,
                    IF(TIMESTAMPDIFF(HOUR, created_at, IF(approve_at IS NULL, CURRENT_TIMESTAMP(), approve_at)) >= 12, 'End', 'DONE') AS ket_wa
                FROM trusmi_approval
                WHERE `status` = 6
 
            ) AS t_fu
            LEFT JOIN trusmi_approval     ON trusmi_approval.no_app       = t_fu.no_app
            LEFT JOIN xin_employees pic_request    ON pic_request.user_id   = trusmi_approval.created_by
            LEFT JOIN xin_employees pic_approve_to ON pic_approve_to.user_id = trusmi_approval.approve_to
            LEFT JOIN xin_employees pic_approve_by ON pic_approve_by.user_id = trusmi_approval.approve_by
            LEFT JOIN trusmi_m_status ON trusmi_m_status.id = trusmi_approval.`status`"
        );
 
        return $query->result_array();
    }
}
