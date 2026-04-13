<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_pengajuan_dev extends CI_Model
{

    function __construct()
    {
        parent::__construct();

        $this->load->library('upload');
        $this->load->database();
    }

    function get_list_eaf($id_user, $id_div, $start, $end, $tipe)
    {

        $id_user = $this->session->userdata('user_id');
        $cek_param_tkb = $this->get_e_parameter_fitur(10, $id_user)->row_array();
        if (
            $this->session->userdata('user_id') == 1 
            || $_SESSION['user_id'] == 801 
            || $_SESSION['user_id'] == 61 
            || $this->session->userdata('user_id') == 68
            || $this->session->userdata('user_id') == 7477

        ) {
            if ($tipe == 1) {
                $where = "AND e_pengajuan.`status` IN ( 1, 2, 3, 6, 7, 8, 10, 13 )";
            } else if ($tipe == 2) {
                $where = "AND e_pengajuan.`status` IN ( 9, 12 )";
            } else {
                $where = "AND e_pengajuan.`status` IN ( 4, 5, 11 )";
            }
        } else if ($cek_param_tkb['id'] == 10) {
            if ($tipe == 1) {
                $where = "AND e_pengajuan.`status` IN ( 1, 2, 3, 6, 7, 8, 10, 13 ) AND (e_company.company_id = 3 OR e_pengajuan.id_user = $id_user)";
            } else if ($tipe == 2) {
                $where = "AND e_pengajuan.`status` IN ( 9, 12 ) AND (e_company.company_id = 3 OR e_pengajuan.id_user = $id_user)";
            } else {
                $where = "AND e_pengajuan.`status` IN ( 4, 5, 11 ) AND (e_company.company_id = 3 OR e_pengajuan.id_user = $id_user)";
            }
        } else {
            if ($tipe == 1) {
                $where = "AND e_pengajuan.id_user = $id_user AND e_pengajuan.`status` IN ( 1, 2, 3, 6, 7, 8, 10, 13 )";
            } else if ($tipe == 2) {
                $where = "AND e_pengajuan.id_user = $id_user AND e_pengajuan.`status` IN ( 9, 12 )";
            } else {
                $where = "AND e_pengajuan.id_user = $id_user AND e_pengajuan.`status` IN ( 4, 5, 11 )";
            }
        }



        $query = $this->db->query("SELECT
            e_pengajuan.id_pengajuan,
            SUBSTR( e_pengajuan.tgl_input, 1, 16 ) AS tgl_input,
            e_pengajuan.nama_penerima,
            e_pengajuan.`status`,
            m_divisi.divisi AS nama_divisi,

            COALESCE(REPLACE(CONCAT(TRIM(emp.first_name), ' ', TRIM(emp.last_name)),',',', '),'') AS `name`,
            desg.designation_name,
            dept.department_name,
            comp.name AS company_name,

            CONCAT(pengaju.first_name, ' ', pengaju.last_name) AS pengaju,
            pengaju_desg.designation_name AS pengaju_desg_name,
            pengaju_dept.department_name AS pengaju_dept_name,
            pengaju_comp.name AS pengaju_comp_name,

            e_kategori.nama_kategori,
            e_pengajuan.flag,
            e_pengajuan.temp,
            e_pengajuan.id_kategori,
            e_m_status.nama_status,
            e_m_status.warna,
            e_budget.budget,
            e_company.company_kode,
            IF(m_project.project IS NULL,e_detail_keperluan.nama_keperluan,CONCAT(e_detail_keperluan.nama_keperluan,' ',m_project.project,' ',COALESCE(e_detail_keperluan.blok,''))) as nama_keperluan,
            e_detail_keperluan.nominal_uang,
            e_detail_keperluan.note,
            e_detail_keperluan.id_project,
            m_project.project,
            e_detail_keperluan.blok,
            CASE
                WHEN e_pengajuan.id_kategori = 17 
                AND SUBSTR( e_pengajuan.tgl_input, 1, 10 ) > e_detail_keperluan.tgl_nota THEN
                    1 ELSE 0 
            END AS stt_bawa 
        FROM
            e_eaf.e_pengajuan
            LEFT JOIN rsp_project_live.m_divisi ON e_pengajuan.id_divisi = m_divisi.id_divisi
            LEFT JOIN hris.xin_employees AS emp ON emp.user_id = e_pengajuan.id_user
            LEFT JOIN hris.xin_designations AS desg ON desg.designation_id = emp.designation_id 
            LEFT JOIN hris.xin_departments AS dept ON dept.department_id = emp.department_id
            LEFT JOIN hris.xin_companies AS comp ON comp.company_id = emp.company_id

            LEFT JOIN hris.xin_employees AS pengaju ON e_pengajuan.pengaju = pengaju.user_id
            LEFT JOIN hris.xin_designations AS pengaju_desg ON pengaju_desg.designation_id = pengaju.designation_id 
            LEFT JOIN hris.xin_departments AS pengaju_dept ON pengaju_dept.department_id = pengaju.department_id
            LEFT JOIN hris.xin_companies AS pengaju_comp ON pengaju_comp.company_id = pengaju.company_id


            LEFT JOIN e_eaf.e_kategori ON e_pengajuan.id_kategori = e_kategori.id_kategori
            LEFT JOIN e_eaf.e_m_status ON e_m_status.id_status = e_pengajuan.`status`
            LEFT JOIN e_eaf.e_budget ON e_pengajuan.budget = e_budget.id_budget
            LEFT JOIN e_eaf.e_company ON e_company.company_id = e_budget.company_id


            LEFT JOIN e_eaf.e_detail_keperluan ON e_pengajuan.id_pengajuan = e_detail_keperluan.id_pengajuan
            LEFT JOIN rsp_project_live.m_project ON m_project.id_project = e_detail_keperluan.id_project
        WHERE
            e_pengajuan.id_kategori IN ( 17, 18, 19, 20 ) 
            AND DATE( e_pengajuan.tgl_input ) BETWEEN '$start' 
            AND '$end' 
            $where
        GROUP BY
            e_pengajuan.id_pengajuan");

        $data['data'] = $query->result();
        return $data;
    }

    function get_pengaju()
    {
        // $query = "SELECT
        //     hris.xin_employees.user_id AS id_user,
        //     CONCAT( hris.xin_employees.first_name, ' ', hris.xin_employees.last_name ) AS employee_name 
        // FROM
        //     hris.xin_employees 
        // WHERE
        //     ( company_id IN ( 1, 2 ) OR user_id = 1543 )
        //     AND is_active = 1  OR `user_id` = 2493";

        $query = "SELECT
                        em.user_id AS id_user,
                        CONCAT( em.first_name, ' ', em.last_name, '( ',dp.department_name,' )' ) AS employee_name,
                        dp.department_name AS divisi, em.company_id, com.name AS company_name

                    FROM
                        hris.xin_employees AS em
                        LEFT JOIN hris.xin_departments as dp ON dp.department_id = em.department_id
                        LEFT JOIN hris.xin_companies as com ON com.company_id = em.company_id

                    WHERE
                        ( em.company_id IN ( 1, 2,3,4,5,6 ) ) 
                        AND em.is_active = 1 AND em.user_id <> 1
                        ";

        return $this->db->query($query);
    }

    function get_kategori()
    {
        // $kondisi = "WHERE id_kategori IN (17,18)";
        // if ($_SESSION['id_user'] == 1 || $_SESSION['id_user'] == 747) {
        //     $kondisi = "WHERE id_kategori IN (17,18,20)";
        // }
        // return $this->db->query("SELECT * from e_kategori $kondisi");
        return $this->db->query("SELECT * from e_eaf.e_kategori WHERE id_kategori IN (17,18,20)");
    }

    function jenis_biaya()
    {
        $id_divisi = $this->session->userdata('id_divisi');
        $query = "SELECT
            e_jenis_biaya.id_jenis,
            e_jenis_biaya.id_tipe_biaya,
            e_biaya.id_budget AS id_biaya,
            e_jenis_biaya.jenis,
            -- CONCAT(e_jenis_biaya.jenis, ' ' ,CASE WHEN e_jenis_biaya.id_tipe_biaya = 1 THEN '(Unlimited)'
            -- WHEN e_jenis_biaya.id_tipe_biaya = 2 THEN '(Limited by Week)'
            -- WHEN e_jenis_biaya.id_tipe_biaya = 3 THEN '(Limited by Month)'
            -- WHEN e_jenis_biaya.id_tipe_biaya = 4 THEN '(Limited by Pengajuan)' END) AS jenis,
            e_biaya.budget_awal,
            IF ( e_jenis_biaya.id_tipe_biaya = 4, e_biaya.budget_awal, COALESCE ( e_biaya.budget, 'Unlimited' ) ) AS budget,
            e_biaya.tahun_budget,
            e_biaya.bulan,
            e_biaya.minggu,
            e_jenis_biaya.id_user_approval,
            e_jenis_biaya.project,
            e_jenis_biaya.blok,
            e_jenis_biaya.id_user_verified,
            e_jenis_biaya.ba,
            -- `user`.id_divisi,
            -- IF(`user`.employee_name = 'RI 2', 'Hendra Arya Cahyadi', `user`.employee_name) AS employee
            emp.designation_id,
            COALESCE(REPLACE(CONCAT(TRIM(emp.first_name), ' ', TRIM(emp.last_name)),',',', '),'') AS employee

        FROM
            e_eaf.e_jenis_biaya
            JOIN e_eaf.e_biaya ON e_jenis_biaya.id_budget = e_biaya.id_budget 
            -- JOIN `user` ON e_jenis_biaya.id_user_approval = `user`.id_user
            JOIN hris.xin_employees AS emp ON emp.user_id = e_jenis_biaya.id_user_approval
        WHERE
            -- ( `user`.id_divisi = $id_divisi OR `user`.id_divisi IN (0,1) ) AND
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
        ) AND e_jenis_biaya.id_jenis != 81";
        return $this->db->query($query);
    }

    function jenis_biaya_by_company($company_id, $nominal)
    {
        $id_divisi = $this->session->userdata('id_divisi');
        $query = "SELECT
                        e_jenis.id_jenis,
                        e_jenis.id_tipe_biaya,
                        e_jenis.id_biaya,
                        e_jenis.jenis,
                        e_jenis.budget_awal,
                        e_jenis.budget,
                        e_jenis.tahun_budget,
                        e_jenis.minggu,
                        e_jenis.bulan,
                        e_jenis.project,
                        e_jenis.blok,
                        e_jenis.id_user_verified,
                        e_jenis.ba,
                        e_jenis.id_divisi,
                        pengajuan.nominal_total,
                    IF
                        (
                            e_jenis.user_approval_2 IS NULL 
                            OR e_jenis.max_approve IS NULL,
                            e_jenis.user_approval_1,
                        IF
                            (
                                ( $nominal > e_jenis.nominal_app_2 ) 
                                OR (
                                $nominal + COALESCE ( pengajuan.nominal_total, 0 )) > max_approve,
                                e_jenis.user_approval_2,
                                e_jenis.user_approval_1 
                            ) 
                        ) AS id_user_approval,
                    IF
                        (
                            e_jenis.user_approval_2 IS NULL 
                            OR e_jenis.max_approve IS NULL,
                            e_jenis.employee_1,
                        IF
                            (
                                ( $nominal > e_jenis.nominal_app_2 ) 
                                OR (
                                $nominal + COALESCE ( pengajuan.nominal_total, 0 )) > max_approve,
                                e_jenis.employee_2,
                                e_jenis.employee_1 
                            ) 
                        ) AS employee 
                    FROM
                        (
                        SELECT
                            emp.user_id AS user_approval_1,
                            emp2.user_id AS user_approval_2,
                            COALESCE ( REPLACE ( CONCAT( TRIM( emp.first_name ), ' ', TRIM( emp.last_name )), ',', ', ' ), '' ) AS employee_1,
                            COALESCE ( REPLACE ( CONCAT( TRIM( emp2.first_name ), ' ', TRIM( emp2.last_name )), ',', ', ' ), '' ) AS employee_2,
                            e_jenis_biaya.id_jenis,
                            e_jenis_biaya.id_tipe_biaya,
                            e_biaya.id_budget AS id_biaya,
                            e_jenis_biaya.jenis,
                            e_jenis_biaya.max_approve,
                            e_jenis_biaya.nominal_app_2,
                            e_biaya.budget_awal,
                        IF
                            ( e_jenis_biaya.id_tipe_biaya = 4, e_biaya.budget_awal, COALESCE ( e_biaya.budget, 'Unlimited' ) ) AS budget,
                            e_biaya.tahun_budget,
                            e_biaya.bulan,
                            e_biaya.minggu,
                            e_jenis_biaya.project,
                            COALESCE ( e_jenis_biaya.blok, '' ) AS blok,
                            COALESCE ( e_jenis_biaya.id_user_verified, '' ) AS id_user_verified,
                            e_jenis_biaya.ba,
                            0 AS id_divisi 
                        FROM
                            e_eaf.e_jenis_biaya
                            JOIN e_eaf.e_biaya ON e_jenis_biaya.id_budget = e_biaya.id_budget
                            JOIN hris.xin_employees AS emp ON e_jenis_biaya.id_user_approval = emp.user_id
                            LEFT JOIN hris.xin_employees AS emp2 ON e_jenis_biaya.id_user_approval2 = emp2.user_id 
                        WHERE
                            e_jenis_biaya.jenis NOT LIKE 'XXX%' 
                            AND (
                                (
                                    e_biaya.tahun_budget = DATE_FORMAT( CURDATE( ), '%Y' ) 
                                    AND e_biaya.bulan = DATE_FORMAT( CURDATE( ), '%m' ) 
                                    AND e_biaya.minggu IS NULL 
                                ) 
                                OR (
                                    e_biaya.tahun_budget = DATE_FORMAT( CURDATE( ), '%Y' ) 
                                    AND e_biaya.bulan = DATE_FORMAT( CURDATE( ), '%m' ) 
                                    AND e_biaya.minggu = WEEK ( CURDATE( ), 1 ) - WEEK ( DATE_FORMAT( CURDATE( ), '%Y-%m-01' ), 1 ) + 1 
                                ) 
                            ) 
                            AND e_jenis_biaya.company_id = '$company_id' 
                        ) e_jenis
                        LEFT JOIN (
                        SELECT
                            ep.jenis,
                            ea.id_user_approval,
                            SUM( edk.nominal_uang ) AS nominal_total 
                        FROM
                            e_eaf.e_pengajuan ep
                            JOIN e_eaf.e_detail_keperluan edk ON edk.id_pengajuan = ep.id_pengajuan
                            JOIN e_eaf.e_approval ea ON ea.id_pengajuan = ep.id_pengajuan 
                        WHERE
                            ((
                                    -- ep.`status` = 3 
                                    ep.`status` IN (1,2,3) 
                                    AND ep.id_kategori = 17 
                                    ) 
                            OR ( ep.`status` = 8 AND ep.id_kategori = 18 )) 
                            -- AND ea.id_user_approval IS NOT NULL 
                            AND ep.tgl_input BETWEEN DATE_FORMAT( CURDATE(), '%Y-%m-01' ) 
                            AND LAST_DAY(
                            CURDATE()) 
                        GROUP BY
                            ep.jenis,
                            ea.id_user_approval 
                        ) pengajuan ON pengajuan.jenis = e_jenis.id_jenis 
                        AND pengajuan.id_user_approval = e_jenis.user_approval_1";
        return $this->db->query($query);
    }

    function jenis_biaya_dlk()
    {
        $id_divisi = $this->session->userdata('id_divisi');
        $query = "SELECT
            e_jenis_biaya.id_jenis,
            e_jenis_biaya.id_tipe_biaya,
            e_biaya.id_budget AS id_biaya,
            e_jenis_biaya.jenis,
            -- CONCAT(e_jenis_biaya.jenis, ' ' ,CASE WHEN e_jenis_biaya.id_tipe_biaya = 1 THEN '(Unlimited)'
            -- WHEN e_jenis_biaya.id_tipe_biaya = 2 THEN '(Limited by Week)'
            -- WHEN e_jenis_biaya.id_tipe_biaya = 3 THEN '(Limited by Month)'
            -- WHEN e_jenis_biaya.id_tipe_biaya = 4 THEN '(Limited by Pengajuan)' END) AS jenis,
            e_biaya.budget_awal,
            IF ( e_jenis_biaya.id_tipe_biaya = 4, e_biaya.budget_awal, COALESCE ( e_biaya.budget, 'Unlimited' ) ) AS budget,
            e_biaya.tahun_budget,
            e_biaya.bulan,
            e_biaya.minggu,
            e_jenis_biaya.id_user_approval,
            e_jenis_biaya.project,
            e_jenis_biaya.blok,
            78 as id_user_verified, -- Fafricony for user_verified DLK,
            -- `user`.id_divisi,
            -- IF(`user`.employee_name = 'RI 2', 'Hendra Arya Cahyadi', `user`.employee_name) AS employee
            emp.designation_id,
            COALESCE(REPLACE(CONCAT(TRIM(emp.first_name), ' ', TRIM(emp.last_name)),',',', '),'') AS employee

        FROM
            e_eaf.e_jenis_biaya
            JOIN e_eaf.e_biaya ON e_jenis_biaya.id_budget = e_biaya.id_budget 

            -- JOIN `user` ON e_jenis_biaya.id_user_approval = `user`.id_user
            JOIN hris.xin_employees AS emp ON emp.user_id = e_jenis_biaya.id_user_approval
        WHERE
            -- ( `user`.id_divisi = $id_divisi OR `user`.id_divisi IN (0,1) ) AND
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
        ) AND e_jenis_biaya.id_jenis = 81";
        return $this->db->query($query);
    }

    function getideaf()
    {
        $q = $this->db->query("SELECT
            MAX( RIGHT ( id_pengajuan, 4 ) ) AS kd_max 
        FROM
            e_eaf.e_pengajuan_dev 
        WHERE
            DATE( created_at ) = CURDATE( )");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }

        date_default_timezone_set('Asia/Jakarta');
        return 'EAF' . date('ymd') . $kd;
    }

    function detail_pengajuan($id_pengajuan)
    {
        if (substr($id_pengajuan, 0, 3) == "LPJ") {
            $join       = "JOIN e_eaf.e_pengajuan AS eaf ON eaf.temp = e_pengajuan.id_pengajuan";
            $left_join  = "LEFT JOIN e_eaf.e_detail_keperluan ON e_detail_keperluan.id_pengajuan = eaf.id_pengajuan
                            LEFT JOIN rsp_project_live.m_project ON m_project.id_project = e_detail_keperluan.id_project";
            $nota       = "IF(eaf.temp IS NOT NULL AND e_pengajuan.`status` = 6,'edit','no') AS edit_nota";
        } else {
            $join       = "";
            $left_join  = "LEFT JOIN e_eaf.e_detail_keperluan ON e_detail_keperluan.id_pengajuan = e_pengajuan.id_pengajuan 
                            LEFT JOIN rsp_project_live.m_project ON m_project.id_project = e_detail_keperluan.id_project";
            $nota       = "'' AS edit_nota";
        }
        $query = "SELECT
                e_pengajuan.id_pengajuan,
                e_pengajuan.tgl_input,
                e_pengajuan.id_departemen,
                e_pengajuan.bukti_tf,
                e_pengajuan.nama_penerima,
                e_pengajuan.`status`,
                m_divisi.divisi AS nama_divisi,
                
                -- `user`.employee_name AS `name`,
                COALESCE(REPLACE(CONCAT(TRIM(emp.first_name), ' ', TRIM(emp.last_name)),',',', '),'') AS `name`,
                desg.designation_name,
                dept.department_name,
                comp.name AS company_name,
    
                e_pengajuan.id_kategori,
                e_kategori.nama_kategori,
                e_tipe_pembayaran.nama_bank,
                e_tipe_pembayaran.no_rek,
                e_tipe_pembayaran.nama_tipe,
                e_pengajuan.id_biaya,
                e_biaya.nama_biaya,
                CASE
                    WHEN e_pengajuan.id_kategori = 17 
                    AND SUBSTR( e_pengajuan.tgl_input, 1, 10 ) > e_detail_keperluan.tgl_nota THEN
                    1 ELSE 0 
                END AS stt_bawa,
                IF(m_project.project IS NULL,e_detail_keperluan.nama_keperluan,CONCAT(e_detail_keperluan.nama_keperluan,' ',m_project.project,' ',COALESCE(e_detail_keperluan.blok,''))) as nama_keperluan,
                e_detail_keperluan.note,
                e_detail_keperluan.nominal_uang,
                e_photo_acc.photo_acc,
                $nota
            FROM
                e_eaf.e_pengajuan
                $join
                LEFT JOIN rsp_project_live.m_divisi ON e_pengajuan.id_divisi = m_divisi.id_divisi
                -- LEFT JOIN `user` ON `user`.id_user = e_pengajuan.id_user
                LEFT JOIN hris.xin_employees emp ON emp.user_id = e_pengajuan.id_user
                LEFT JOIN hris.xin_designations AS desg ON desg.designation_id = emp.designation_id 
                LEFT JOIN hris.xin_departments AS dept ON dept.department_id = emp.department_id
                LEFT JOIN hris.xin_companies AS comp ON comp.company_id = emp.company_id

                LEFT JOIN e_eaf.e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
                LEFT JOIN e_eaf.e_tipe_pembayaran ON e_tipe_pembayaran.id_pengajuan = e_pengajuan.id_pengajuan
                LEFT JOIN e_eaf.e_biaya ON e_biaya.id_biaya = e_pengajuan.id_biaya
                LEFT JOIN e_eaf.e_photo_acc ON e_photo_acc.id_pengajuan = e_pengajuan.id_pengajuan
                $left_join
        WHERE
            e_pengajuan.id_pengajuan = '$id_pengajuan'";

        return $this->db->query($query)->row_array();
    }

    function tracking_approval($id_pengajuan)
    {
        $query = "SELECT
            e_approval.id_approval,
            e_approval.id_pengajuan,
            e_approval.id_user_approval,
            COALESCE ( e_approval.`status`, 'Waiting' ) AS `status`,
            e_approval.update_approve,
            e_approval.note_approve,
            CASE 
            WHEN e_approval.`status` IS NULL AND e_approval.id_user_approval = 1709
            THEN 'Finance'
            WHEN e_approval.`status` IS NULL
            THEN 	COALESCE(REPLACE(CONCAT(TRIM(usr.first_name), ' ', TRIM(usr.last_name)),',',', '),'') 
						ELSE 	COALESCE(REPLACE(CONCAT(TRIM(approved.first_name), ' ', TRIM(approved.last_name)),',',', '),'')
						END AS employee_name
        FROM
            e_eaf.e_approval
            -- LEFT JOIN `user` AS usr ON usr.id_user = e_approval.id_user_approval 
            -- LEFT JOIN `user` AS approved ON approved.id_user = e_approval.id_user
            LEFT JOIN hris.xin_employees usr ON usr.user_id = e_approval.id_user_approval
            LEFT JOIN hris.xin_employees approved ON approved.user_id = e_approval.id_user
        WHERE
            e_approval.id_pengajuan = '$id_pengajuan'";

        return $this->db->query($query)->result();
    }

    function get_list_lpj($id_user)
    {
        // Akun IT dan Audit (Farhan)
        // if ($this->session->userdata('id_user') == 1 || $_SESSION['id_user'] == 801 || $_SESSION['id_user'] == 61 || $this->session->userdata('id_user') == 68 || $this->session->userdata('id_user') == 1358) {
        //     $where = "";
        // } else {
        //     $where = "AND e_pengajuan.id_user = $id_user";
        // }

        $id_user = $this->session->userdata('user_id');
        $cek_param_all = $this->get_e_parameter_fitur(3, $id_user)->row_array();
        $cek_param_tkb = $this->get_e_parameter_fitur(10, $id_user)->row_array();

        if ($this->session->userdata('user_id') == 1 || $cek_param_all['id'] != Null) {
            $where = "";
        } else if ($cek_param_tkb['id'] != Null) {
            $where = "AND (e_pengajuan.id_user = $id_user OR e_company.company_id = 3)";
        } else {
            $where = "AND e_pengajuan.id_user = $id_user";
        }

        $query = "SELECT
            e_pengajuan.id_pengajuan,
            e_company.company_kode,
            e_pengajuan.tgl_input,
            e_pengajuan.nama_penerima,
            e_detail_keperluan.note,
            e_pengajuan.`status`,
            m_divisi.divisi AS nama_divisi,
            COALESCE(REPLACE(CONCAT(TRIM(emp.first_name), ' ', TRIM(emp.last_name)),',',', '),'') AS `employee_name`,
            emp_desg.designation_name AS admin_desg_name,
            emp_dept.department_name AS admin_dept_name,
            emp_comp.name AS admin_company_name,

            e_biaya.nama_biaya,
            e_pengajuan.id_biaya,
            e_pengajuan.id_sub_biaya as id_jenis,
            TIMESTAMPDIFF( HOUR, approval.update_approve, NOW( ) ) - COALESCE (
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
                    y.tgl BETWEEN DATE( approval.update_approve ) 
                    AND CURDATE( ) 
                ),
                0 
            ) AS leadtime_old,
            CASE 
                WHEN e_pengajuan.id_sub_biaya = 711 
                AND e_pengajuan.leave_id <> 0 THEN
                    TIMESTAMPDIFF( HOUR, CONCAT(lv.to_date,' ',lv.end_time), NOW( ) ) - COALESCE (
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
                            y.tgl BETWEEN lv.to_date
                            AND CURDATE( ) 
                        ),
                        0 
                        ) ELSE TIMESTAMPDIFF( HOUR, approval.update_approve, NOW( ) ) - COALESCE (
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
                            y.tgl BETWEEN DATE( approval.update_approve ) 
                            AND CURDATE( ) 
                        ),
                        0 
                    ) 
            END AS leadtime
        FROM
            e_eaf.e_pengajuan
            LEFT JOIN rsp_project_live.m_divisi ON e_pengajuan.id_divisi = m_divisi.id_divisi
            LEFT JOIN hris.xin_employees AS emp ON emp.user_id = e_pengajuan.id_user
            LEFT JOIN hris.xin_designations AS emp_desg ON emp_desg.designation_id = emp.designation_id 
            LEFT JOIN hris.xin_departments AS emp_dept ON emp_dept.department_id = emp.department_id
            LEFT JOIN hris.xin_companies AS emp_comp ON emp_comp.company_id = emp.company_id

            LEFT JOIN e_eaf.e_biaya ON e_biaya.id_biaya = e_pengajuan.id_biaya
            LEFT JOIN e_eaf.e_detail_keperluan ON e_detail_keperluan.id_pengajuan = e_pengajuan.id_pengajuan 
            LEFT JOIN e_eaf.e_budget ON e_budget.id_budget = e_pengajuan.budget
            LEFT JOIN e_eaf.e_company ON e_company.company_id = e_budget.company_id

            LEFT JOIN (SELECT
                e_approval.id_pengajuan,
                e_approval.update_approve 
            FROM
                e_eaf.e_approval 
            WHERE
                e_approval.id_pengajuan IN (
                    (
                    SELECT
                        e_pengajuan.id_pengajuan 
                    FROM
                        e_eaf.e_pengajuan 
                    WHERE
                        e_pengajuan.`status` = 3 
                        AND ( e_pengajuan.temp NOT LIKE 'lpj%' OR e_pengajuan.temp IS NULL ) 
                        AND e_pengajuan.id_kategori = '18' 
                    ) 
                ) 
                AND e_approval.`level` = 5) AS approval ON e_pengajuan.id_pengajuan = approval.id_pengajuan
            LEFT JOIN hris.xin_leave_applications AS lv ON lv.leave_id = e_pengajuan.leave_id
        WHERE
            e_pengajuan.`status` = 3 
            AND ( e_pengajuan.temp NOT LIKE 'lpj%' OR e_pengajuan.temp IS NULL )
            AND id_kategori = '18'
            $where";

        return $this->db->query($query)->result();
    }

    function getidtemp()
    {
        $q = $this->db->query("SELECT
            MAX( RIGHT ( id_temp, 4 ) ) AS kd_max 
        FROM
            e_eaf.e_temp 
        WHERE
            DATE( tanggal ) = CURDATE( )");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return date('ymd') . time() . $kd;
    }

    function get_detail_keperluan($id_lpj)
    {
        $query = $this->db->query("SELECT
                                        e_detail_keperluan.id_detail_keperluan,                                   
                                        e_detail_keperluan.nama_keperluan,                                           
                                        m_project.project,
                                        e_detail_keperluan.nominal_uang,
                                        e_detail_keperluan.note,
                                        e_detail_keperluan.tgl_nota,
                                        e_detail_keperluan.id_pengajuan,
                                        e_detail_keperluan.id_lpj,
                                        e_detail_keperluan.id_biaya_lpj,
                                        e_detail_keperluan.id_project,
                                        e_detail_keperluan.blok 
                                    FROM
                                        e_eaf.e_detail_keperluan
                                        LEFT JOIN rsp_project_live.m_project ON m_project.id_project = e_detail_keperluan.id_project 
                                    WHERE
                                        id_lpj = '$id_lpj'");
        $data = $query->result();
        return $data;
    }

    function get_nama($id_lpj)
    {
        return $this->db->query("SELECT
            e_pengajuan.nama_penerima,
            e_pengajuan.tgl_input 
        FROM
            e_eaf.e_pengajuan 
        WHERE
            e_pengajuan.temp = '$id_lpj'")->row_array();
    }

    function get_kategori_2()
    {
        $query = $this->db->query("SELECT * from e_eaf.e_kategori WHERE id_kategori IN (19)");
        return $query;
    }

    function get_id_biayaa_lpj($id_pengajuan)
    {
        $query = "SELECT DISTINCT
            id_biaya_lpj 
        FROM
            e_eaf.e_detail_keperluan 
        WHERE
            id_lpj = '$id_pengajuan'";
        return $this->db->query($query);
    }

    function get_divisi($id_user)
    {
        $query = $this->db->query("SELECT
            m_divisi.divisi AS nama_divisi 
        FROM
            rsp_project_live.m_divisi
            LEFT JOIN `user` ON m_divisi.id_divisi = `user`.id_divisi 
        WHERE
            `user`.id_user = '$id_user'");
        return $query;
    }

    public function getidlpj()
    {
        $q = $this->db->query("SELECT
            Max( RIGHT ( id_pengajuan, 4 ) ) AS kd_max 
        FROM
            e_eaf.e_pengajuan 
        WHERE
            DATE( created_at ) = CURDATE( )");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }

        date_default_timezone_set('Asia/Jakarta');
        return 'LPJ' . date('ymd') . $kd;
    }

    function eaf_usera($id_temp)
    {
        $query = "SELECT
            eaf.id_pengajuan,
            eaf.`user`,
            eaf.jenis,
            eaf.sub_biaya,
            6 AS `status`,
            eaf.budget 
        FROM
            (
            SELECT
                e_pengajuan.id_pengajuan,
                e_jenis_biaya.id_user_approval AS `user`,
                e_pengajuan.jenis,
                e_pengajuan.sub_biaya,
                e_pengajuan.budget 
            FROM
                e_eaf.e_pengajuan
                LEFT JOIN e_eaf.e_jenis_biaya ON e_jenis_biaya.id_jenis = e_pengajuan.id_sub_biaya 
            WHERE
                e_pengajuan.temp = '$id_temp' 
            ) AS eaf
            -- JOIN `user` ON `user`.id_user = eaf.`user`
            JOIN hris.xin_employees AS `user` ON `user`.user_id = eaf.`user`
            ";
        return $this->db->query($query)->row_array();
    }

    function get_photo_acc($id_lpj)
    {

        $query = $this->db->query("SELECT * FROM e_eaf.e_photo_acc where id_pengajuan='$id_lpj' and flag='ACC-Reject'");
        $data = $query->result();
        return $data;
    }

    function get_detail_eaf($id_pengajuan)
    {

        $query = $this->db->query("SELECT
                e_pengajuan.id_pengajuan,
                e_pengajuan.tgl_input,
                e_pengajuan.id_departemen,
                e_pengajuan.bukti_tf,
                e_pengajuan.nama_penerima,
                e_pengajuan.`status`,
                m_divisi.divisi AS nama_divisi,

                -- `user`.employee_name AS `name`,
                COALESCE(REPLACE(CONCAT(TRIM(`user`.first_name), ' ', TRIM(`user`.last_name)),',',', '),'') AS `name`,

                e_pengajuan.id_kategori,
                e_kategori.nama_kategori,
                e_tipe_pembayaran.nama_bank,
                e_tipe_pembayaran.no_rek,
                e_tipe_pembayaran.nama_tipe,
                e_pengajuan.id_biaya,
                e_biaya.nama_biaya,
                CASE
                    WHEN e_pengajuan.id_kategori = 17 
                    AND SUBSTR( e_pengajuan.tgl_input, 1, 10 ) > e_detail_keperluan.tgl_nota THEN
                        1 ELSE 0 
                END AS stt_bawa,
                CONCAT(pengaju.first_name,' ',pengaju.last_name) AS pengaju
            FROM
                e_eaf.e_pengajuan
                LEFT JOIN hris.xin_employees AS pengaju ON pengaju.user_id = e_pengajuan.pengaju

                LEFT JOIN rsp_project_live.m_divisi ON e_pengajuan.id_divisi = m_divisi.id_divisi
                -- LEFT JOIN `user` ON `user`.id_user = e_pengajuan.id_user
                LEFT JOIN hris.xin_employees AS `user` ON `user`.user_id = e_pengajuan.id_user
                
                LEFT JOIN e_eaf.e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
                LEFT JOIN e_eaf.e_tipe_pembayaran ON e_tipe_pembayaran.id_pengajuan = e_pengajuan.id_pengajuan
                LEFT JOIN e_eaf.e_biaya ON e_biaya.id_biaya = e_pengajuan.id_biaya
                LEFT JOIN e_eaf.e_detail_keperluan ON e_detail_keperluan.id_pengajuan = e_pengajuan.id_pengajuan
        WHERE
            e_pengajuan.id_pengajuan = '$id_pengajuan'");

        $data = $query->result();
        return $data;
    }

    function get_revisi_approval($id_pengajuan)
    {
        $query = "SELECT
            e_approval.id_user_approval,
            e_approval.`level` 
        FROM
            e_eaf.e_approval 
        WHERE
            e_approval.id_pengajuan = '$id_pengajuan' 
            AND e_approval.`status` = 'Revisi' 
        ORDER BY
            e_approval.id_approval DESC 
            LIMIT 1";

        return $this->db->query($query)->row_array();
    }

    function get_detail_keperluan_4($id_pengajuan)
    {
        $query = $this->db->query("SELECT
                                        e_detail_keperluan.id_detail_keperluan,
                                        REPLACE (
                                        IF
                                            (
                                                m_project.project IS NOT NULL,
                                                CONCAT( e_jenis_biaya.jenis, ' ', m_project.project, ' ', COALESCE ( e_detail_keperluan.blok, '' ) ),
                                                e_jenis_biaya.jenis 
                                            ),
                                            ',',
                                            ', ' 
                                        ) AS nama_keperluan,
                                        e_detail_keperluan.nominal_uang,
                                        e_detail_keperluan.note,
                                        e_detail_keperluan.tgl_nota,
                                        e_detail_keperluan.id_pengajuan,
                                        e_detail_keperluan.id_lpj,
                                        e_detail_keperluan.id_biaya_lpj,
                                        e_detail_keperluan.id_project,
                                        e_detail_keperluan.blok,
                                        e_pengajuan.id_kategori,
                                        cr.nominal AS nominal_termin,
                                        CONCAT(cr.awal_periode,' s/d ',cr.akhir_periode) AS periode_termin
                                    FROM
                                        e_eaf.e_detail_keperluan
                                        JOIN e_eaf.e_pengajuan ON e_pengajuan.id_pengajuan = e_detail_keperluan.id_pengajuan
                                        JOIN e_eaf.e_jenis_biaya ON e_jenis_biaya.id_jenis = e_pengajuan.id_sub_biaya
                                        LEFT JOIN rsp_project_live.m_project ON m_project.id_project = e_detail_keperluan.id_project  
                                        LEFT JOIN (
                                            SELECT
                                                id_pengajuan,
                                                nominal,
                                                MIN( periode ) AS awal_periode,
                                                MAX( periode ) AS akhir_periode 
                                            FROM
                                                e_eaf.e_pinjaman_karyawan 
                                            WHERE
                                                id_pengajuan = '$id_pengajuan' 
                                            GROUP BY
                                                id_pengajuan
                                        ) AS cr on cr.id_pengajuan = e_pengajuan.id_pengajuan
                                    WHERE
                                        e_detail_keperluan.id_pengajuan = '$id_pengajuan'");
        $data = $query->result();
        return $data;
    }

    function get_sub_total($id_pengajuan)
    {
        $sql = "SELECT SUM(nominal_uang) as sub_total from e_eaf.e_detail_keperluan where id_pengajuan = '$id_pengajuan'";
        $data = $this->db->query($sql)->row();
        return $data;
    }

    function get_approval_2($pengajuan_id, $id_user_approval)
    {
        $sql = "SELECT e_approval.id_user_approval, 
                    COALESCE(REPLACE(CONCAT(TRIM(emp.first_name), ' ', TRIM(emp.last_name)),',',', '),'') AS `name`
                    from e_approval 
                    -- LEFT JOIN user ON user.id_user = e_approval.id_user
                    LEFT JOIN hris.xin_employees AS emp ON e_approval.id_user = emp.user_id
                     where e_approval.id_pengajuan = '$pengajuan_id' and e_approval.id_user_approval='$id_user_approval' 
                     and e_approval.`status`='Approve' ";
        return $this->db->query($sql);
    }

    function get_nama_penerima($pengajuan_id)
    {
        $sql = "SELECT e_pengajuan.nama_penerima from e_eaf.e_pengajuan
        where e_pengajuan.id_pengajuan = '$pengajuan_id' ";
        return $this->db->query($sql);
    }

    function get_nama_pembuat_new($id_pengajuan)
    {
        return $this->db->query("SELECT
                                    -- usr.employee_name AS nama_penerima,
                                    COALESCE(REPLACE(CONCAT(TRIM(emp.first_name), ' ', TRIM(emp.last_name)),',',', '),'') AS nama_penerima,
                                    SUBSTR( e_pengajuan.tgl_input, 1, 16 ) AS tgl_input 
                                FROM
                                    e_eaf.e_pengajuan
                                     LEFT JOIN hris.xin_employees AS emp ON e_pengajuan.id_user = emp.user_id
                                WHERE
                                    e_pengajuan.id_pengajuan = '$id_pengajuan'");
    }

    function get_nama_approve($id_pengajuan)
    {
        return $this->db->query("SELECT
                                    IF(e_approval.id_user IS NULL,
                                    -- usr_approve.employee_name,
                                    COALESCE(REPLACE(CONCAT(TRIM(usr_approve.first_name), ' ', TRIM(usr_approve.last_name)),',',', '),''),
                                    COALESCE(REPLACE(CONCAT(TRIM(usr_finance.first_name), ' ', TRIM(usr_finance.last_name)),',',', '),'')
                                    -- usr_finance.employee_name
                                    ) as `name`,
                                    SUBSTR( e_approval.update_approve, 1, 16 ) AS update_approve 
                                FROM
                                    e_eaf.e_approval
                                    -- JOIN `user` as usr_approve ON usr_approve.id_user = e_approval.id_user_approval
                                    -- JOIN `user` as usr_finance ON usr_finance.id_user = e_approval.id_user

                                    LEFT JOIN hris.xin_employees AS usr_approve ON usr_approve.user_id = e_approval.id_user_approval
                                    LEFT JOIN hris.xin_employees AS usr_finance ON usr_finance.user_id = e_approval.id_user

                                WHERE
                                    e_approval.id_pengajuan = '$id_pengajuan' 
                                    AND `level` = 1 AND `status` = 'Approve'");
    }

    function get_nama_approve_finance($id_pengajuan)
    {
        return $this->db->query("SELECT
                                    -- IF(e_approval.id_user IS NULL,usr_approve.employee_name,usr_finance.employee_name) as `name`,
                                    IF(e_approval.id_user IS NULL,
                                    -- usr_approve.employee_name,
                                    COALESCE(REPLACE(CONCAT(TRIM(usr_approve.first_name), ' ', TRIM(usr_approve.last_name)),',',', '),''),
                                    COALESCE(REPLACE(CONCAT(TRIM(usr_finance.first_name), ' ', TRIM(usr_finance.last_name)),',',', '),'')
                                    -- usr_finance.employee_name
                                    ) as `name`,
                                    SUBSTR( e_approval.update_approve, 1, 16 ) AS update_approve,
                                    e_approval.note_approve
                                FROM
                                    e_eaf.e_approval
                                    -- JOIN `user` as usr_approve ON usr_approve.id_user = e_approval.id_user_approval
                                    -- JOIN `user` as usr_finance ON usr_finance.id_user = e_approval.id_user
                                    LEFT JOIN hris.xin_employees AS usr_approve ON usr_approve.user_id = e_approval.id_user_approval
                                    LEFT JOIN hris.xin_employees AS usr_finance ON usr_finance.user_id = e_approval.id_user
                                WHERE
                                    e_approval.id_pengajuan = '$id_pengajuan' 
                                    AND e_approval.id_user_approval = 1709
                                    AND e_approval.`level` = 5");
    }

    function get_approval($pengajuan_id)
    {
        $sql = "SELECT * from e_eaf.e_approval where id_pengajuan = '$pengajuan_id'";
        return $this->db->query($sql);
    }

    function get_detail_eaf_lpj($id_pengajuan)
    {

        $query = $this->db->query("SELECT
            e_pengajuan.id_pengajuan,
            e_pengajuan.tgl_input,
            e_pengajuan.id_departemen,
            e_pengajuan.nama_penerima,
            e_pengajuan.STATUS,
            m_divisi.divisi AS nama_divisi,
            -- `user`.employee_name AS `name`,
            COALESCE(REPLACE(CONCAT(TRIM(`user`.first_name), ' ', TRIM(`user`.last_name)),',',', '),'') AS `name`,
            e_kategori.nama_kategori 
        FROM
            e_eaf.e_pengajuan
            LEFT JOIN rsp_project_live.m_divisi ON e_pengajuan.id_divisi = m_divisi.id_divisi
            -- LEFT JOIN `user` ON `user`.id_user = e_pengajuan.id_user
            LEFT JOIN hris.xin_employees AS `user` ON `user`.user_id = e_pengajuan.id_user
            LEFT JOIN e_eaf.e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori 
        WHERE
            e_pengajuan.id_pengajuan = '$id_pengajuan'");

        $data = $query->result();
        return $data;
    }

    function get_kep_lpj($id_lpj)
    {

        $query = $this->db->query("SELECT * FROM e_eaf.e_header_lpj WHERE id_lpj = '$id_lpj'");
        $data = $query->result();
        return $data;
    }

    function get_sub_total_lpj($id_pengajuan)
    {
        $sql = "SELECT SUM(nominal_lpj) as sub_total_2 from e_eaf.e_header_lpj where id_lpj = '$id_pengajuan'";
        $data = $this->db->query($sql)->row();
        return $data;
    }

    function get_nota_lpj($id_lpj)
    {

        $query = $this->db->query("SELECT * FROM e_eaf.e_photo_acc where id_pengajuan = '$id_lpj' and flag = 'LPJ-BUKTI-NOTA'");
        $data = $query->result();
        return $data;
    }

    function get_owner_lpj($id_lpj)
    {

        $query = $this->db->query("SELECT * FROM e_eaf.e_photo_acc where id_pengajuan = '$id_lpj' and flag = 'LPJ-BUKTI-ACC'");
        $data = $query->result();
        return $data;
    }

    function get_approval_peng($pengajuan_id)
    {
        $sql = "SELECT * from e_eaf.e_approval where id_temp_lpj = '$pengajuan_id'";
        return $this->db->query($sql);
    }

    function get_ba_reimbust($id_pengajuan)
    {

        $query = $this->db->query("SELECT * FROM e_eaf.e_photo_acc where id_pengajuan = '$id_pengajuan' and flag='BERITA_ACARA'");
        $data = $query->result();
        return $data;
    }

    function get_nota_reimbust($id_pengajuan)
    {

        $query = $this->db->query("SELECT * FROM e_eaf.e_photo_acc where id_pengajuan = '$id_pengajuan' and flag = 'BUKTI_NOTA'");
        $data = $query->result();
        return $data;
    }

    function get_acc_reimbust($id_pengajuan)
    {

        $query = $this->db->query("SELECT * FROM e_eaf.e_photo_acc where id_pengajuan = '$id_pengajuan' and flag = 'ACC_CEO'");
        $data = $query->result();
        return $data;
    }

    function get_no_last_pengajuan()
    {
        return $this->db->query("SELECT MAX(id_pengajuan) as id_pengajuan FROM e_eaf.e_pengajuan_dev WHERE id_kategori <> 19")->row_array();
    }

    function get_pengajuan_for_wa($id, $level)
    {
        return $this->db->query("SELECT
                                    e_pengajuan.id_pengajuan AS no_eaf,
                                    e_kategori.nama_kategori AS type,
                                    e_detail_keperluan.nama_keperluan AS need,
                                    e_detail_keperluan.note AS description,
                                    e_detail_keperluan.nominal_uang AS amount,
                                    COALESCE ( e_biaya.budget, '~' ) AS remaining_budget,
                                    e_approval.id_user_approval,
                                    IF ( e_approval.id_user_approval = 78, 'Fafricony Ristiara Devi', CONCAT( approval.first_name, ' ', approval.last_name ) ) AS approve_to,
                                    IF ( e_approval.id_user_approval = 78, '081120012145', approval.contact_no ) AS approve_contact,
                                    e_pengajuan.pengaju,
                                    CONCAT( emp.first_name, ' ', emp.last_name ) AS requested_by,
                                    e_pengajuan.created_at AS requested_at,
                                    e_pengajuan.jenis,
                                    kt.city
                                FROM
                                    e_eaf.e_pengajuan
                                    JOIN e_eaf.e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
                                    JOIN e_eaf.e_detail_keperluan ON e_detail_keperluan.id_pengajuan = e_pengajuan.id_pengajuan
                                    JOIN (
                                    SELECT
                                        id_biaya,
                                        nama_biaya,
                                        budget,
                                        id_budget 
                                    FROM
                                        e_eaf.e_biaya 
                                    WHERE
                                        (
                                            minggu IS NULL 
                                            OR minggu = WEEK ( CURDATE( ), 1 ) - WEEK ( DATE_FORMAT( CURDATE( ), '%Y-%m-01' ), 1 ) + 1 
                                        ) 
                                        AND bulan = DATE_FORMAT( CURDATE( ), '%m' ) 
                                        AND tahun_budget = DATE_FORMAT( CURDATE( ), '%Y' ) 
                                    ) e_biaya ON e_biaya.id_budget = e_pengajuan.budget
                                    JOIN e_eaf.e_approval ON e_approval.id_pengajuan = e_pengajuan.id_pengajuan 
                                    AND e_approval.`level` = '$level' AND e_approval.`status` IS NULL
                                    -- JOIN `user` AS usr ON usr.id_user = e_approval.id_user_approval
                                    -- LEFT JOIN hris.xin_employees AS approval ON approval.user_id = usr.id_hr
                                    
                                    JOIN hris.xin_employees AS usr ON usr.user_id = e_approval.id_user_approval
                                    LEFT JOIN hris.xin_employees AS approval ON approval.user_id = usr.user_id

                                    JOIN hris.xin_employees AS emp ON emp.user_id = e_pengajuan.pengaju 
                                    LEFT JOIN hris.xin_leave_applications AS lv ON lv.leave_id = e_pengajuan.leave_id
                                    LEFT JOIN hris.trusmi_kota AS kt ON kt.id = lv.kota
                                WHERE
                                    e_pengajuan.id_pengajuan = '$id'")->row();
    }

    function get_level($id)
    {
        return $this->db->query("SELECT `level` FROM e_eaf.e_approval WHERE id_pengajuan = '$id' AND `status` IS NULL")->row_array();
    }

    function get_project()
    {
        // Hidden Project TL Kayangan (not used) dan RN Kondangsari (NA)
        return $this->db->query("SELECT id_project, project FROM rsp_project_live.m_project WHERE id_project NOT IN (41,60) AND (`status` <> 2 OR `status` IS NULL)")->result();
    }

    function get_blok($id, $type, $id_jenis)
    {
        $blok_1 = "SELECT
                        all_in.id_project,
                        all_in.blok 
                    FROM
                        ( SELECT * FROM rsp_project_live.m_project_unit WHERE id_project = '$id' ) AS all_in
                        LEFT JOIN (
                        SELECT
                            det.id_project,
                            unit.blok 
                        FROM
                            rsp_project_live.m_project_unit AS unit
                            LEFT JOIN e_detail_keperluan AS det ON det.id_project = unit.id_project 
                            AND FIND_IN_SET( unit.blok, det.blok )
                            LEFT JOIN e_pengajuan AS aju ON aju.id_pengajuan = det.id_pengajuan 
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
        // $blok_2 = "SELECT
        //                 sp3k.id_project,
        //                 sp3k.blok 
        //             FROM
        //                 (
        //                 SELECT
        //                     x.id_project,
        //                     x.blok 
        //                 FROM
        //                     (
        //                     SELECT
        //                         t_gci.id_project,
        //                         t_gci.blok 
        //                     FROM
        //                         t_interview
        //                         JOIN t_gci ON t_gci.id_gci = t_interview.id_gci 
        //                     WHERE
        //                         t_interview.hasil_int = 1 
        //                         AND t_gci.id_kategori IN ( 3, 4, 5 ) 
        //                         AND SUBSTR( t_gci.blok, 1, 2 ) != 'RD' 
        //                         AND t_gci.id_project = '$id' UNION ALL
        //                     SELECT
        //                         id_project,
        //                         blok 
        //                     FROM
        //                         t_spr 
        //                     WHERE
        //                         jenis LIKE 'CASH%' 
        //                         AND blok IN ( 'N15', 'Q12', 'C22', 'C27', 'H76', 'I91', 'I81', 'O10', 'H58', 'H19', 'B58', 'N14', 'H61', 'H51', 'H38', 'H30', 'A20', 'H20', 'O03', 'O02', 'H72', 'Q15', 'D07', 'E04', 'Q08', 'C32', 'N18', 'N19', 'I68', 'H01', 'I104', 'D07', 'N03' ) 
        //                         AND id_project IN ( '20', '29', '33', '31', '18', '26', '27', '3' ) 
        //                     GROUP BY id_project, blok
        //                     ) AS x 
        //                 WHERE
        //                     id_project = '$id' 
        //                 ) AS sp3k
        //                 LEFT JOIN (
        //                 SELECT
        //                     x.id_project,
        //                     x.blok 
        //                 FROM
        //                     (
        //                     SELECT
        //                         t_gci.id_project,
        //                         t_gci.blok 
        //                     FROM
        //                         t_interview
        //                         JOIN t_gci ON t_gci.id_gci = t_interview.id_gci 
        //                     WHERE
        //                         t_interview.hasil_int = 1 
        //                         AND t_gci.id_kategori IN ( 3, 4, 5 ) 
        //                         AND SUBSTR( t_gci.blok, 1, 2 ) != 'RD' 
        //                         AND t_gci.id_project = '$id' UNION ALL
        //                     SELECT
        //                         id_project,
        //                         blok 
        //                     FROM
        //                         t_spr 
        //                     WHERE
        //                         jenis LIKE 'CASH%' 
        //                         AND blok IN ( 'N15', 'Q12', 'C22', 'C27', 'H76', 'I91', 'I81', 'O10', 'H58', 'H19', 'B58', 'N14', 'H61', 'H51', 'H38', 'H30', 'A20', 'H20', 'O03', 'O02', 'H72', 'Q15', 'D07', 'E04', 'Q08', 'C32', 'N18', 'N19', 'I68', 'H01', 'I104', 'D07', 'N03' ) 
        //                         AND id_project IN ( '20', '29', '33', '31', '18', '26', '27', '3' ) 
        //                     ) AS x
        //                     LEFT JOIN e_detail_keperluan AS det ON det.id_project = x.id_project 
        //                     AND FIND_IN_SET( x.blok, det.blok )
        //                     LEFT JOIN e_pengajuan AS aju ON aju.id_pengajuan = det.id_pengajuan 
        //                 WHERE
        //                     aju.`status` IN ( 1, 2, 3 ) 
        //                     AND x.id_project = '$id' 
        //                     AND aju.jenis = '$id_jenis'
        //                 ) AS used ON used.id_project = sp3k.id_project 
        //                 AND used.blok = sp3k.blok 
        //             WHERE
        //                 used.blok IS NULL 
        //             ORDER BY
        //                 sp3k.blok";
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
                                t_gci.id_project,
                                t_gci.blok 
                            FROM
                                t_interview
                                JOIN t_gci ON t_gci.id_gci = t_interview.id_gci 
                            WHERE
                                t_interview.hasil_int = 1 
                                AND t_gci.id_kategori IN ( 3, 4, 5 ) 
                                AND SUBSTR( t_gci.blok, 1, 2 ) != 'RD' 
                                AND t_gci.id_project = '$id' UNION ALL
                            SELECT
                                id_project,
                                blok 
                            FROM
                                t_spr 
                            WHERE
                                jenis LIKE 'CASH%' 
                                AND DATE( created_at ) > '2021-01-01'		
                            GROUP BY
                                id_project,
                                blok 
                            ) AS x 
                        WHERE
                            id_project = '$id' 
                        ) AS sp3k
                        LEFT JOIN (
                        SELECT
                            x.id_project,
                            x.blok 
                        FROM
                            (
                            SELECT
                                t_gci.id_project,
                                t_gci.blok 
                            FROM
                                t_interview
                                JOIN t_gci ON t_gci.id_gci = t_interview.id_gci 
                            WHERE
                                t_interview.hasil_int = 1 
                                AND t_gci.id_kategori IN ( 3, 4, 5 ) 
                                AND SUBSTR( t_gci.blok, 1, 2 ) != 'RD' 
                                AND t_gci.id_project = '$id' UNION ALL
                            SELECT
                                id_project,
                                blok 
                            FROM
                                t_spr 
                            WHERE
                                jenis LIKE 'CASH%' 
                                AND DATE( created_at ) > '2021-01-01' 
                            ) AS x
                            LEFT JOIN e_detail_keperluan AS det ON det.id_project = x.id_project 
                            AND FIND_IN_SET( x.blok, det.blok )
                            LEFT JOIN e_pengajuan AS aju ON aju.id_pengajuan = det.id_pengajuan 
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
                            t_gci.id_project,
                            t_gci.blok 
                        FROM
                            t_akad
                            JOIN t_gci ON t_gci.id_konsumen = t_akad.id_konsumen 
                        WHERE
                            t_akad.hasil_akad = 1 
                            AND t_gci.id_kategori IN ( 3, 4, 5 ) 
                            AND SUBSTR( t_gci.blok, 1, 2 ) != 'RD' 
                            AND t_gci.id_project = '$id' 
                        GROUP BY t_gci.blok
                        ) AS akad
                        LEFT JOIN (
                        SELECT
                            t_gci.id_project,
                            t_gci.blok 
                        FROM
                            t_akad
                            JOIN t_gci ON t_gci.id_konsumen = t_akad.id_konsumen
                            LEFT JOIN e_detail_keperluan AS det ON det.id_project = t_gci.id_project 
                            AND FIND_IN_SET( t_gci.blok, det.blok )
                            LEFT JOIN e_pengajuan AS aju ON aju.id_pengajuan = det.id_pengajuan 
                        WHERE
                            aju.`status` NOT IN ( 4, 5, 11 ) 
                            AND t_akad.hasil_akad = 1 
                            AND t_gci.id_kategori IN ( 3, 4, 5 ) 
                            AND SUBSTR( t_gci.blok, 1, 2 ) != 'RD' 
                            AND t_gci.id_project = '$id' 
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

    function get_lpj_for_wa($id)
    {
        return $this->db->query("SELECT
                                    e_pengajuan.id_pengajuan as no_eaf,
                                    'Pembawaan' as type,
                                    e_header_lpj.nama_lpj as need,
                                    e_header_lpj.note_lpj as description,
                                    e_header_lpj.nominal_lpj as amount,
                                    COALESCE ( e_biaya.budget, '~' ) as remaining_budget,
                                    e_jenis_biaya.id_user_approval,

                                    -- CONCAT( approval.first_name, ' ', approval.last_name ) AS approve_to,
                                    -- approval.contact_no AS approve_contact,

                                    IF(COALESCE(e_jenis_biaya.is_dlk,0) = 1, 'Fafricony Ristiara Devi', CONCAT( approval.first_name, ' ', approval.last_name )) AS approve_to,
                                    IF(COALESCE(e_jenis_biaya.is_dlk,0) = 1, '081120012145', approval.contact_no) AS approve_contact,
                                    -- IF(COALESCE(e_jenis_biaya.is_dlk,0) = 1, '087829828061', approval.contact_no) AS approve_contact,

                                    ajuan.pengaju,
                                    CONCAT( emp.first_name, ' ', emp.last_name ) AS requested_by,
                                    e_pengajuan.created_at AS requested_at,
                                    ajuan.total_pengajuan as nominal_pengajuan,
                                    e_photo_acc.flag as used_ba
                                FROM
                                    e_eaf.e_pengajuan as e_pengajuan
                                    LEFT JOIN e_eaf.e_pengajuan as ajuan ON ajuan.temp = e_pengajuan.id_pengajuan
                                    LEFT JOIN e_eaf.e_header_lpj as e_header_lpj ON e_header_lpj.id_lpj = e_pengajuan.id_pengajuan
                                    LEFT JOIN e_eaf.e_biaya as e_biaya ON e_biaya.id_biaya = e_pengajuan.id_biaya_lpj
                                    LEFT JOIN e_eaf.e_jenis_biaya as e_jenis_biaya ON e_jenis_biaya.id_jenis = ajuan.id_sub_biaya
                                    -- LEFT JOIN rsp_project_live.`user` AS usr ON usr.id_user = e_jenis_biaya.id_user_approval
                                    LEFT JOIN hris.xin_employees AS approval ON approval.user_id = e_jenis_biaya.id_user_approval
                                    LEFT JOIN hris.xin_employees AS emp ON emp.user_id = ajuan.pengaju
                                    LEFT JOIN e_eaf.e_photo_acc ON e_photo_acc.id_pengajuan = e_pengajuan.id_pengajuan
                                WHERE
                                    e_pengajuan.id_pengajuan = '$id'")->row();
    }

    function cek_dlk($id_hr)
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
            COALESCE(dlk.total_makan * dlk.uang_makan,0) AS total_eaf,
            dlk.kota 
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
                hris.trusmi_kota.city AS kota
            FROM
                hris.xin_leave_applications
                JOIN hris.xin_employees ON hris.xin_leave_applications.employee_id = hris.xin_employees.user_id
                JOIN hris.xin_user_roles ON hris.xin_employees.ctm_posisi = hris.xin_user_roles.role_name
                JOIN hris.trusmi_kota ON hris.xin_leave_applications.kota = hris.trusmi_kota.id 
                LEFT JOIN e_eaf.e_pengajuan AS eaf ON hris.xin_leave_applications.leave_id = eaf.leave_id AND eaf.`status` != 10
            WHERE
                hris.xin_leave_applications.leave_type_id = 13 
                AND hris.xin_leave_applications.`status` = 2 
                AND hris.xin_leave_applications.employee_id = $id_hr 
                AND ( eaf.id_pengajuan IS NULL OR eaf.`status` IN (4,5,11) )
            ORDER BY
                hris.xin_leave_applications.leave_id 
            -- LIMIT 1 
            ) AS dlk";

        return $this->db->query($query);
    }

    // Start | Tambah Edit Blok & Note Setelah Pengajuan
    function edit_blok($id)
    {
        return $this->db->query("SELECT
                                    det.id_pengajuan,
                                    det.nama_keperluan,
                                    det.note,
                                    det.id_project,
                                    pro.project,
                                    det.blok,
                                    aju.jenis AS id_jenis,
                                    jen.blok AS tipe_blok,
                                    det.note
                                FROM
                                    e_detail_keperluan AS det
                                    JOIN e_pengajuan AS aju ON aju.id_pengajuan = det.id_pengajuan
                                    JOIN e_jenis_biaya AS jen ON jen.id_jenis = aju.jenis 
                                    AND jen.blok IS NOT NULL 
                                    JOIN m_project as pro ON pro.id_project = det.id_project
                                WHERE
                                    det.id_pengajuan = '$id'")->result();
    }
    // End | Tambah Edit Blok & Note Setelah Pengajuan

    function cek_validasi_pinjaman($user_id)
    {
        return $this->db->query("SELECT
                                    em.user_id,
                                    CONCAT( em.first_name, ' ', em.last_name ) AS employee_name,
                                    em.date_of_joining,
                                    TIMESTAMPDIFF( MONTH, date_of_joining, CURDATE()) AS masa_kerja,
                                    IF(kt.contract_type_id IN (1,2,4,5),'reguler','non-reguler') AS jenis_karyawan,
                                    kt.contract_type_id AS jenis_kontrak,
                                    tp.`name` AS kontrak,
                                    DAYOFMONTH(CURDATE()) AS tgl_pinjam,
                                    pj.`status`
                                FROM
                                    hris.xin_employees AS em
                                    JOIN hris.xin_employee_contract AS kt ON kt.employee_id = em.user_id 
                                    AND kt.is_active = 1
                                    JOIN hris.xin_contract_type AS tp ON tp.contract_type_id = kt.contract_type_id
                                    LEFT JOIN (
                                    SELECT
                                        pk.id_pengajuan,
                                        pk.id_hr,
                                        pk.nominal,
                                        pk.periode,
                                        pk.`status` 
                                    FROM
                                        rsp_project_live.e_pinjaman_karyawan AS pk
                                        JOIN ( SELECT MAX( id ) AS id FROM rsp_project_live.e_pinjaman_karyawan WHERE id_hr = $user_id GROUP BY id_hr ) AS mx ON mx.id = pk.id 
                                    ) AS pj ON pj.id_hr = em.user_id
                                WHERE
                                    em.user_id = $user_id 
                                    AND em.is_active = 1")->row_array();
    }

    function get_e_parameter($id_user, $id_param)
    {
        return $this->db->query("SELECT * FROM e_eaf.e_parameter WHERE id = $id_param AND FIND_IN_SET($id_user,user_id) ")->result();
    }

    function get_e_parameter_fitur($id_param, $id_user)
    {
        return $this->db->query("SELECT * FROM e_eaf.e_parameter WHERE id = $id_param AND FIND_IN_SET($id_user,user_id) LIMIT 1");
    }

    // function get_company()
    // {
    //     return $this->db->query("SELECT
    //                                 company_id, `name`
    //                             FROM
    //                                 xin_companies
    //                            ");
    // }

    function get_company()
    {
        return $this->db->query("SELECT company_id,
                                    company_name,
                                    company_master,
                                    company_kode
                                    FROM 
                                    e_eaf.e_company
                               ");
    }

    function get_no_reservasi()
    {
        $db_tour_leader = $this->load->database('db_tour_leader', TRUE);
        $sql = "SELECT reservasi.no_reservasi, reservasi.kode_kasir, reservasi.id_pengajuan 
                FROM tbl_reservasi reservasi
                LEFT JOIN tbl_komisi komisi ON reservasi.no_reservasi = komisi.no_reservasi 
                WHERE reservasi.id_pengajuan IS NULL 
                AND komisi.no_reservasi IS NULL
                ORDER BY reservasi.created_at DESC";
                
        return $db_tour_leader->query($sql)->result();
    }
    
    function get_pic_marketing(){
        $sql = "SELECT
                    em.user_id AS id_user,
                    CONCAT( em.first_name, ' ', em.last_name, '( ',dp.department_name,' )' ) AS employee_name,
                    dp.department_name AS divisi, em.company_id, com.name AS company_name
                FROM
                    hris.xin_employees AS em
                    LEFT JOIN hris.xin_departments as dp ON dp.department_id = em.department_id
                    LEFT JOIN hris.xin_companies as com ON com.company_id = em.company_id
                WHERE
                    ( em.company_id = 5 ) 
                    AND em.is_active = 1 AND em.user_id <> 1
                                        ";

        return $this->db->query($sql)->result();
    }
}

/* End of file model_eaf.php */
/* Location: ./application/models/model_divisi.php */