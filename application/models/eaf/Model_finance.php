<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_finance extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('upload');
        $this->load->database();
    }

    // Untuk Finance Status Reject dan Approve 
    function get_list_approval($start, $end, $status = NULL)
    {
        if ($status == 'Reject') {
            // Reject
            $kondisi = 'AND e_pengajuan.`status` IN (5)';
        } else {
            // Approve
            $kondisi = 'AND e_pengajuan.`status` IN (3,7,8)';
        }
        return $this->db->query("SELECT
                                    e_pengajuan.id_pengajuan,
                                    e_pengajuan.tgl_input,
                                    e_m_status.nama_status,
                                    e_m_status.warna,
                                    e_pengajuan.nama_penerima,
                                    e_pengajuan.bukti_tf,
                                    e_pengajuan.pengaju as id_pengaju,
                                    -- `user`.employee_name AS `name`,
                                    -- CONCAT(pengaju.first_name,' ',pengaju.last_name) as pengaju,
                                    
                                     COALESCE(REPLACE(CONCAT(TRIM(emp.first_name), ' ', TRIM(emp.last_name)),',',', '),'') AS `name`,
                                    emp_desg.designation_name AS admin_desg_name,
                                        emp_dept.department_name AS admin_dept_name,
                                        emp_comp.name AS admin_company_name,

                                    COALESCE(REPLACE(CONCAT(TRIM(pengaju.first_name), ' ', TRIM(pengaju.last_name)),',',', '),'') AS pengaju,
                                    pengaju_desg.designation_name AS pengaju_desg_name,
                                    pengaju_dept.department_name AS pengaju_dept_name,
                                    pengaju_comp.name AS pengaju_comp_name,

                                    e_kategori.nama_kategori,
                                    e_kategori.id_kategori,
                                    e_pengajuan.flag,
                                    CONCAT(e_jenis_biaya.jenis,' ',COALESCE(m_project.project,''), ' ',COALESCE(e_detail_keperluan.blok,'')) as nama_keperluan,
                                    COALESCE(e_detail_keperluan.blok,'') AS blok,
                                    m_divisi.divisi AS nama_divisi,
                                    e_pengajuan.`status`,
                                    e_pengajuan.temp,
                                    e_tipe_pembayaran.nama_tipe,
                                    COALESCE(e_pengajuan.jurnal_eces, '') AS jurnal_eces,
                                    COALESCE(e_pengajuan.ju_id_eces, '') AS ju_id_eces,
                                    e_company.company_kode

                                FROM
                                    e_eaf.e_pengajuan
                                    LEFT JOIN e_eaf.e_m_status ON e_m_status.id_status = e_pengajuan.`status`
                                    LEFT JOIN e_eaf.e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
                                    LEFT JOIN e_eaf.e_detail_keperluan ON e_detail_keperluan.id_pengajuan = e_pengajuan.id_pengajuan
                                    LEFT JOIN rsp_project_live.m_divisi ON m_divisi.id_divisi = e_pengajuan.id_divisi
                                    -- LEFT JOIN `user` ON `user`.id_user = e_pengajuan.id_user 
                                    LEFT JOIN hris.xin_employees as emp ON emp.user_id = e_pengajuan.id_user
                                    LEFT JOIN hris.xin_designations AS emp_desg ON emp_desg.designation_id = emp.designation_id 
                                    LEFT JOIN hris.xin_departments AS emp_dept ON emp_dept.department_id = emp.department_id
                                    LEFT JOIN hris.xin_companies AS emp_comp ON emp_comp.company_id = emp.company_id

                                    LEFT JOIN hris.xin_employees as pengaju ON pengaju.user_id = e_pengajuan.pengaju
                                    LEFT JOIN hris.xin_designations AS pengaju_desg ON pengaju_desg.designation_id = pengaju.designation_id 
                                    LEFT JOIN hris.xin_departments AS pengaju_dept ON pengaju_dept.department_id = pengaju.department_id
                                    LEFT JOIN hris.xin_companies AS pengaju_comp ON pengaju_comp.company_id = pengaju.company_id

                                    LEFT JOIN e_eaf.e_tipe_pembayaran ON e_tipe_pembayaran.id_pengajuan = e_pengajuan.id_pengajuan
                                    LEFT JOIN rsp_project_live.m_project ON m_project.id_project = e_detail_keperluan.id_project
                                    LEFT JOIN e_eaf.e_jenis_biaya ON e_jenis_biaya.id_jenis = e_pengajuan.id_sub_biaya
                                    LEFT JOIN e_eaf.e_budget ON e_budget.id_budget = e_pengajuan.budget 
                                	LEFT JOIN e_eaf.e_company ON e_company.company_id = e_budget.company_id 

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
                                    e_biaya.id_biaya,
                                    CONCAT(e_jenis_biaya.jenis,' ',COALESCE(m_project.project,''), ' ',COALESCE(e_detail_keperluan.blok,'')) as nama_keperluan,
                                    e_detail_keperluan.note,
                                    e_detail_keperluan.nominal_uang,
                                    e_photo_acc.photo_acc,
                                    e_jenis_biaya.id_tipe_biaya,
                                    e_tipe_pembayaran.nama_tipe
                                FROM
                                    e_eaf.e_pengajuan
                                    LEFT JOIN e_eaf.e_biaya ON e_biaya.id_biaya = e_pengajuan.id_biaya 
                                    LEFT JOIN e_eaf.e_detail_keperluan ON e_detail_keperluan.id_pengajuan = e_pengajuan.id_pengajuan
                                    LEFT JOIN e_eaf.e_photo_acc ON e_photo_acc.id_pengajuan = e_pengajuan.id_pengajuan
                                    LEFT JOIN e_eaf.e_jenis_biaya ON e_jenis_biaya.id_jenis = e_pengajuan.id_sub_biaya
                                    LEFT JOIN e_eaf.e_tipe_pembayaran ON e_tipe_pembayaran.id_pengajuan = e_pengajuan.id_pengajuan
                                    LEFT JOIN rsp_project_live.m_project ON m_project.id_project = e_detail_keperluan.id_project
                                WHERE
                                    e_pengajuan.id_pengajuan = '$id'")->row_array();
    }

    function get_detail_list_approval_lpj($id)
    {
        return $this->db->query("SELECT
                                    e_pengajuan.id_pengajuan,
                                    e_biaya.nama_biaya,
                                    e_biaya.budget,
                                    e_biaya.id_biaya,
                                    e_detail_keperluan.nama_keperluan,
                                    e_detail_keperluan.note,
                                    e_detail_keperluan.nominal_uang,
                                    e_photo_acc.photo_acc,
                                    e_jenis_biaya.id_tipe_biaya
                                FROM
                                    e_eaf.e_pengajuan
                                    -- LEFT JOIN e_header_lpj ON e_header_lpj.id_lpj = e_pengajuan.id_pengajuan
                                    LEFT JOIN e_eaf.e_detail_keperluan ON e_detail_keperluan.id_lpj = e_pengajuan.id_pengajuan
                                    LEFT JOIN e_eaf.e_biaya ON e_biaya.id_biaya = e_detail_keperluan.id_biaya_lpj
                                    LEFT JOIN e_eaf.e_photo_acc ON e_photo_acc.id_pengajuan = e_pengajuan.id_pengajuan
                                    LEFT JOIN e_eaf.e_jenis_biaya ON e_jenis_biaya.id_jenis = e_pengajuan.jenis 
                                WHERE
                                    e_pengajuan.id_pengajuan = '$id'")->row_array();
    }

    function get_list_eaf($id_user, $id_div, $status, $datestart, $dateend)
    {
        if ($status == 3) {
            $kondisi = "AND DATE(e_pengajuan.tgl_input) BETWEEN '$datestart' AND '$dateend' AND e_pengajuan.`status` IN ($status)";
            // } else if ($status == '3,7,8') {
            //     $kondisi = "AND DATE(e_pengajuan.tgl_input) BETWEEN '$datestart' AND '$dateend' AND e_pengajuan.`status` IN ($status)";
        } else {
            $kondisi = "AND e_pengajuan.`status` IN ($status) AND e_approval.id_user_approval = 737";
        }
        $query      = $this->db->query("SELECT
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
                                        e_m_status.warna,
                                        IF(budget.id_biaya IS NULL,e_biaya.id_biaya,budget.id_biaya) as id_biaya,
                                        e_biaya.id_budget,
                                        e_biaya.nama_biaya,
                                        IF ( e_jenis_biaya.id_tipe_biaya = 2, budget.budget, e_biaya.budget ) AS budget,
                                        e_jenis_biaya.id_tipe_biaya,
                                        e_jenis_biaya.id_jenis,
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
                                        e_photo_acc.flag AS flag_photo,
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
                                                e_biaya.id_biaya,
                                                e_biaya.id_budget,
                                                e_biaya.budget 
                                            FROM
                                                e_biaya 
                                            WHERE
                                                e_biaya.minggu = WEEK ( CURDATE( ), 1 ) - WEEK ( DATE_FORMAT( CURDATE( ), '%Y-%m-01' ), 1 ) + 1 
                                            ) AS budget ON budget.id_budget = e_pengajuan.budget 
                                        WHERE
                                            e_pengajuan.id_divisi = 1
                                            $kondisi
                                            AND e_pengajuan.id_kategori IN ( 17, 18, 19 ) 
                                    GROUP BY
                                        e_pengajuan.id_pengajuan");


        $data['data'] = $query->result();
        return $data;
    }

    function get_list_eaf_my_approval($id_user, $id_div, $status, $datestart, $dateend, $tipe)
    {
        $query1      = "SELECT
                            e_pengajuan.id_pengajuan,
                            e_pengajuan.tgl_input,
                            e_pengajuan.tgl_jtp,
                            m_divisi.divisi AS nama_divisi,
                            e_kategori.nama_kategori,
                            e_tipe_pembayaran.nama_tipe,
                            CONCAT(e_tipe_pembayaran.nama_bank,' - ',e_tipe_pembayaran.no_rek) AS rekening,
                            e_pengajuan.nama_penerima,
                            e_biaya.nama_biaya,
                            e_biaya.budget,
                            IF(m_project.project IS NULL,e_detail_keperluan.nama_keperluan,CONCAT(e_detail_keperluan.nama_keperluan,' ',m_project.project,' ',COALESCE(e_detail_keperluan.blok,''))) as nama_keperluan,
                            e_detail_keperluan.note,
                            e_pengajuan.note AS note_peng,
                            e_detail_keperluan.nominal_uang,
                            e_detail_keperluan.id_project,
                            m_project.prj_eces AS id_project_eces,
                            m_project.project,
                            e_detail_keperluan.blok,
                            e_approval.id_approval,
                            e_verified.note_approve,
                            e_verified.update_approve,
                            e_photo_acc.photo_acc,
                            e_jenis_biaya.id_tipe_biaya,
                            e_biaya.id_biaya,
                            e_pengajuan.budget AS id_budget,
                            e_pengajuan.jenis AS id_jenis,
                            e_pengajuan.`status`,
                            e_m_status.warna,
                            e_m_status.nama_status,

                            -- usr.employee_name AS `name`,
                            -- CONCAT(pengaju.first_name, ' ', pengaju.last_name) AS pengaju,
                            -- appr.employee_name as nama_approval,

                            COALESCE(REPLACE(CONCAT(TRIM(pengaju.first_name), ' ', TRIM(pengaju.last_name)),',',', '),'') AS `pengaju`,
                            pengaju_desg.designation_name AS pengaju_desg_name,
                            pengaju_dept.department_name AS pengaju_dept_name,
                            pengaju_comp.name AS pengaju_comp_name,

                            COALESCE(REPLACE(CONCAT(TRIM(usr.first_name), ' ', TRIM(usr.last_name)),',',', '),'') AS `name`,
                            admin_desg.designation_name AS admin_desg_name,
                            admin_dept.department_name AS admin_dept_name,
                            admin_comp.name AS admin_comp_name,
                            COALESCE(REPLACE(CONCAT(TRIM(appr.first_name), ' ', TRIM(appr.last_name)),',',', '),'') AS `nama_approval`,


                            e_jenis_biaya.id_user_approval,
                            COALESCE(verify.note_approve,'') as note_verify,
                            COALESCE(fnc.note_approve,'') AS note_fnc,
                            e_pengajuan.jumlah_termin,
                            e_pengajuan.nominal_termin,
                            e_pengajuan.periode_awal_termin,
                            e_pengajuan.total_pengajuan,
                            e_company.company_kode

                        FROM
                            e_eaf.e_pengajuan
                            LEFT JOIN rsp_project_live.m_divisi ON m_divisi.id_divisi = e_pengajuan.id_divisi
                            LEFT JOIN e_eaf.e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
                            LEFT JOIN e_eaf.e_tipe_pembayaran ON e_tipe_pembayaran.id_pengajuan = e_pengajuan.id_pengajuan
                            LEFT JOIN (
                            SELECT
                                id_biaya,
                                nama_biaya,
                                budget,
                                id_budget 
                            FROM
                                e_eaf.e_biaya 
                            WHERE
                                (minggu IS NULL 
                                OR minggu = WEEK ( CURDATE( ), 1 ) - WEEK ( DATE_FORMAT( CURDATE( ), '%Y-%m-01' ), 1 ) + 1)
                                AND bulan = SUBSTR(CURDATE(),6,2) AND tahun_budget = YEAR (CURDATE())
                            ) AS e_biaya ON e_biaya.id_budget = e_pengajuan.budget
                            LEFT JOIN e_eaf.e_detail_keperluan ON e_detail_keperluan.id_pengajuan = e_pengajuan.id_pengajuan
                            LEFT JOIN ( SELECT id_approval, id_pengajuan, id_user_approval FROM e_eaf.e_approval WHERE `level` = 5 AND `status` IS NULL ) AS e_approval ON e_approval.id_pengajuan = e_pengajuan.id_pengajuan
                            LEFT JOIN ( SELECT id_approval, id_pengajuan, id_user_approval, note_approve, update_approve FROM e_eaf.e_approval WHERE `level` = 1 AND `status` = 'Approve' ) AS e_verified ON e_verified.id_pengajuan = e_pengajuan.id_pengajuan
                            LEFT JOIN ( SELECT id_approval, id_pengajuan, id_user_approval, note_approve, update_approve FROM e_eaf.e_approval WHERE `level` = 10 AND `status` = 'Approve' ) AS verify ON verify.id_pengajuan = e_pengajuan.id_pengajuan
                            LEFT JOIN (SELECT id_approval, id_pengajuan, id_user_approval, note_approve, update_approve FROM e_eaf.e_approval WHERE FIND_IN_SET(e_approval.id_user_approval,(SELECT user_id FROM e_eaf.e_parameter WHERE id = 8)) AND level is null ) AS fnc ON fnc.id_pengajuan = e_pengajuan.id_pengajuan
                            LEFT JOIN e_eaf.e_photo_acc ON e_photo_acc.id_pengajuan = e_pengajuan.id_pengajuan
                            LEFT JOIN e_eaf.e_jenis_biaya ON e_jenis_biaya.id_jenis = e_pengajuan.jenis
                            LEFT JOIN e_eaf.e_budget ON e_budget.id_budget = e_pengajuan.budget 
                            LEFT JOIN e_eaf.e_company ON e_company.company_id = e_budget.company_id 

                            LEFT JOIN hris.xin_employees AS pengaju ON pengaju.user_id = e_pengajuan.pengaju
                            LEFT JOIN hris.xin_designations AS pengaju_desg ON pengaju_desg.designation_id = pengaju.designation_id 
                            LEFT JOIN hris.xin_departments AS pengaju_dept ON pengaju_dept.department_id = pengaju.department_id
                            LEFT JOIN hris.xin_companies AS pengaju_comp ON pengaju_comp.company_id = pengaju.company_id

                            LEFT JOIN hris.xin_employees AS usr ON usr.user_id = e_pengajuan.id_user
                            LEFT JOIN hris.xin_designations AS admin_desg ON admin_desg.designation_id = usr.designation_id 
                            LEFT JOIN hris.xin_departments AS admin_dept ON admin_dept.department_id = usr.department_id
                            LEFT JOIN hris.xin_companies AS admin_comp ON admin_comp.company_id = usr.company_id

                            LEFT JOIN e_eaf.e_m_status ON e_m_status.id_status = e_pengajuan.`status` 
                            -- LEFT JOIN  `user` AS appr ON appr.id_user = e_jenis_biaya.id_user_approval
                            LEFT JOIN hris.xin_employees AS appr ON appr.user_id = e_jenis_biaya.id_user_approval
                            LEFT JOIN rsp_project_live.m_project ON m_project.id_project = e_detail_keperluan.id_project 
                        WHERE
                            e_pengajuan.`status` IN ( 2 ) 
                            AND e_pengajuan.id_kategori IN ( 17, 18, 20 )";

        $query2      = "SELECT
        
                                            e_pengajuan.id_pengajuan,
                                            e_pengajuan.tgl_input,
                                            e_pengajuan.tgl_jtp,
                                            ajuan.lpj_pertama,
											reject.update_approve AS reject_lpj,
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
                                            e_verified.update_approve,
                                            e_photo_acc.photo_acc,
                                            e_jenis_biaya.id_tipe_biaya,
                                            e_biaya.id_biaya AS new_id_biaya,
                                            e_pengajuan.budget AS new_id_budget,
                                            e_pengajuan.jenis AS new_id_jenis,
                                            e_pengajuan.`status`,
                                            e_pengajuan.note AS note_peng,
                                            e_m_status.warna,
                                            e_m_status.nama_status,
                                            e_jenis_biaya.id_user_approval,

                                            -- usr.employee_name AS `name`,
                                            -- CONCAT(pengaju.first_name, ' ', pengaju.last_name) AS pengaju,
                                            -- appr.employee_name as nama_approval,

                                            COALESCE(REPLACE(CONCAT(TRIM(pengaju.first_name), ' ', TRIM(pengaju.last_name)),',',', '),'') AS `pengaju`,
                                            pengaju_desg.designation_name AS pengaju_desg_name,
                                            pengaju_dept.department_name AS pengaju_dept_name,
                                            pengaju_comp.name AS pengaju_comp_name,

                                            COALESCE(REPLACE(CONCAT(TRIM(usr.first_name), ' ', TRIM(usr.last_name)),',',', '),'') AS `name`,
                                            admin_desg.designation_name AS admin_desg_name,
                                            admin_dept.department_name AS admin_dept_name,
                                            admin_comp.name AS admin_comp_name,
                                            COALESCE(REPLACE(CONCAT(TRIM(appr.first_name), ' ', TRIM(appr.last_name)),',',', '),'') AS `nama_approval`,

                                            COALESCE(ajuan.lpj_pertama,'') AS lpj_pertama,
                                            ajuan.jurnal_eces,
                                            e_pengajuan.total_pengajuan,
                                            e_company.company_kode

                                        FROM
                                            e_eaf.e_pengajuan
                                            JOIN e_eaf.e_pengajuan AS ajuan ON ajuan.temp = e_pengajuan.id_pengajuan
                                            -- JOIN `user` AS usr ON usr.id_user = e_pengajuan.id_user                                           

                                            LEFT JOIN hris.xin_employees AS pengaju ON pengaju.user_id = e_pengajuan.pengaju
                                            LEFT JOIN hris.xin_designations AS pengaju_desg ON pengaju_desg.designation_id = pengaju.designation_id 
                                            LEFT JOIN hris.xin_departments AS pengaju_dept ON pengaju_dept.department_id = pengaju.department_id
                                            LEFT JOIN hris.xin_companies AS pengaju_comp ON pengaju_comp.company_id = pengaju.company_id

                                            LEFT JOIN hris.xin_employees AS usr ON usr.user_id = e_pengajuan.id_user
                                            LEFT JOIN hris.xin_designations AS admin_desg ON admin_desg.designation_id = usr.designation_id 
                                            LEFT JOIN hris.xin_departments AS admin_dept ON admin_dept.department_id = usr.department_id
                                            LEFT JOIN hris.xin_companies AS admin_comp ON admin_comp.company_id = usr.company_id

                                            LEFT JOIN rsp_project_live.m_divisi ON m_divisi.id_divisi = e_pengajuan.id_divisi
                                            JOIN e_eaf.e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
                                            JOIN e_eaf.e_biaya ON e_biaya.id_biaya = ajuan.id_biaya
                                            JOIN e_eaf.e_header_lpj ON e_header_lpj.id_lpj = e_pengajuan.id_pengajuan
                                            JOIN ( 
                                                SELECT id_approval, id_pengajuan, id_user_approval 
                                                FROM e_eaf.e_approval WHERE 
                                                FIND_IN_SET(e_approval.id_user_approval,(SELECT user_id FROM e_eaf.e_parameter WHERE id = 8)) AND `status` IS NULL 
                                            ) AS e_approval ON e_approval.id_pengajuan = e_pengajuan.id_pengajuan
                                            LEFT JOIN ( SELECT id_approval, id_pengajuan, id_user_approval, note_approve, update_approve FROM e_eaf.e_approval WHERE `level` = 1 AND `status` = 'Approve' ) AS e_verified ON e_verified.id_pengajuan = e_pengajuan.id_pengajuan
                                            JOIN e_eaf.e_photo_acc ON e_photo_acc.id_pengajuan = e_pengajuan.id_pengajuan
                                            JOIN e_eaf.e_jenis_biaya ON e_jenis_biaya.id_jenis = ajuan.id_sub_biaya
                                            LEFT JOIN e_eaf.e_budget ON e_budget.id_budget = e_pengajuan.budget 
                                            LEFT JOIN e_eaf.e_company ON e_company.company_id = e_budget.company_id 

                                            LEFT JOIN e_eaf.e_m_status ON e_m_status.id_status = e_pengajuan.`status`

                                            -- LEFT JOIN  `user` AS appr ON appr.id_user = e_jenis_biaya.id_user_approval
                                            LEFT JOIN hris.xin_employees AS appr ON appr.user_id = e_jenis_biaya.id_user_approval

                                            LEFT JOIN e_eaf.e_approval reject ON reject.id_pengajuan = ajuan.lpj_pertama AND FIND_IN_SET(reject.id_user_approval,(SELECT user_id FROM e_eaf.e_parameter WHERE id = 8)) AND reject.`status` = 'Reject'
                                        WHERE
                                            e_pengajuan.`status` IN ( 6 ) 
                                            AND e_pengajuan.id_kategori IN ( 19 )";

        // Query Konfirmasi LPJ
        $query3      = "SELECT
                                            e_pengajuan.id_pengajuan,
                                            e_pengajuan.tgl_input,
                                            e_pengajuan.tgl_jtp,
                                            ajuan.lpj_pertama,
											reject.update_approve AS reject_lpj,
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
                                            e_verified.update_approve,
                                            e_photo_acc.photo_acc,
                                            e_jenis_biaya.id_tipe_biaya,
                                            e_biaya.id_biaya AS new_id_biaya,
                                            e_pengajuan.budget AS new_id_budget,
                                            e_pengajuan.jenis AS new_id_jenis,
                                            e_pengajuan.`status`,
                                            e_pengajuan.note AS note_peng,
                                            e_m_status.warna,
                                            e_m_status.nama_status,
                                            usr.employee_name AS `name`,
                                            CONCAT(pengaju.first_name, ' ', pengaju.last_name) AS pengaju,
                                            e_jenis_biaya.id_user_approval,
                                            appr.employee_name as nama_approval,
                                            COALESCE(ajuan.lpj_pertama,'') AS lpj_pertama,
                                            e_pengajuan.total_pengajuan,
                                            e_company.company_kode

                                        FROM
                                            e_pengajuan
                                            JOIN e_pengajuan AS ajuan ON ajuan.temp = e_pengajuan.id_pengajuan
                                            JOIN `user` AS usr ON usr.id_user = e_pengajuan.id_user
                                            LEFT JOIN hris.xin_employees AS pengaju ON e_pengajuan.pengaju = pengaju.user_id
                                            JOIN m_divisi ON m_divisi.id_divisi = e_pengajuan.id_divisi
                                            JOIN e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
                                            JOIN e_biaya ON e_biaya.id_biaya = ajuan.id_biaya
                                            JOIN e_header_lpj ON e_header_lpj.id_lpj = e_pengajuan.id_pengajuan
                                            JOIN ( SELECT id_approval, id_pengajuan, id_user_approval FROM e_approval WHERE id_user_approval = 737 AND `status` IS NULL ) AS e_approval ON e_approval.id_pengajuan = e_pengajuan.id_pengajuan
                                            LEFT JOIN ( SELECT id_approval, id_pengajuan, id_user_approval, note_approve, update_approve FROM e_approval WHERE `level` = 1 AND `status` = 'Approve' ) AS e_verified ON e_verified.id_pengajuan = e_pengajuan.id_pengajuan
                                            JOIN e_photo_acc ON e_photo_acc.id_pengajuan = e_pengajuan.id_pengajuan
                                            JOIN e_jenis_biaya ON e_jenis_biaya.id_jenis = ajuan.id_sub_biaya
                                            LEFT JOIN e_eaf.e_budget ON e_budget.id_budget = e_pengajuan.budget 
                                            LEFT JOIN e_eaf.e_company ON e_company.company_id = e_budget.company_id 

                                            LEFT JOIN e_m_status ON e_m_status.id_status = e_pengajuan.`status`
                                            LEFT JOIN  `user` AS appr ON appr.id_user = e_jenis_biaya.id_user_approval
                                            LEFT JOIN e_approval reject ON reject.id_pengajuan = ajuan.lpj_pertama AND reject.id_user_approval = 737 AND reject.`status` = 'Reject'
                                        WHERE
                                            e_pengajuan.`status` IN ( 13 ) 
                                            AND e_pengajuan.id_kategori IN ( 19 )";

        if ($tipe == 1) {
            $data['data'] = $this->db->query($query1)->result();
        } else if ($tipe == 2) {
            $data['data'] = $this->db->query($query2)->result();
        } else if ($tipe == 3) { // My Konfirmasi LPJ
            $data['data'] = $this->db->query($query3)->result();
        }
        return $data;
    }

    function get_list_eaf_all($id_user, $id_div, $status, $datestart, $dateend)
    {
        $query      = $this->db->query("SELECT
                                            e_pengajuan.id_pengajuan,
                                            e_pengajuan.tgl_input,
                                            m_divisi.divisi AS nama_divisi,
                                            e_kategori.id_kategori,
                                            e_pengajuan.flag,
                                            e_kategori.nama_kategori,
                                            e_tipe_pembayaran.nama_tipe,
                                            e_pengajuan.nama_penerima,
                                            e_biaya.nama_biaya,
                                            e_biaya.budget,
                                            IF(m_project.project IS NULL,e_detail_keperluan.nama_keperluan,CONCAT(e_detail_keperluan.nama_keperluan,' ',m_project.project,' ',COALESCE(e_detail_keperluan.blok,''))) as nama_keperluan,
                                            e_detail_keperluan.note,
                                            e_detail_keperluan.nominal_uang,
                                            e_detail_keperluan.id_project,
                                            m_project.project,
                                            e_detail_keperluan.blok,
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
                                            CONCAT(pengaju.first_name, ' ', pengaju.last_name) AS pengaju,
                                            e_jenis_biaya.id_user_approval,
                                            appr.employee_name as nama_approval
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
                                                OR minggu = WEEK ( CURDATE( ), 1 ) - WEEK ( DATE_FORMAT( CURDATE( ), '%Y-%m-01' ), 1 ) + 1)
                                                AND bulan = SUBSTR(CURDATE(),6,2) AND tahun_budget = YEAR (CURDATE())
                                            ) AS e_biaya ON e_biaya.id_budget = e_pengajuan.budget
                                            LEFT JOIN e_detail_keperluan ON e_detail_keperluan.id_pengajuan = e_pengajuan.id_pengajuan
                                            LEFT JOIN ( SELECT id_approval, id_pengajuan, id_user_approval FROM e_approval WHERE id_user_approval = 737 AND `status` = 'Approve' AND `level` = 5 ) AS e_approval ON e_approval.id_pengajuan = e_pengajuan.id_pengajuan
                                            LEFT JOIN e_photo_acc ON e_photo_acc.id_pengajuan = e_pengajuan.id_pengajuan
                                            LEFT JOIN e_jenis_biaya ON e_jenis_biaya.id_jenis = e_pengajuan.jenis
                                            LEFT JOIN `user` AS usr ON usr.id_user = e_pengajuan.id_user
                                            LEFT JOIN hris.xin_employees AS pengaju ON e_pengajuan.pengaju = pengaju.user_id
                                            LEFT JOIN e_m_status ON e_m_status.id_status = e_pengajuan.`status` 
                                            LEFT JOIN  `user` AS appr ON appr.id_user = e_jenis_biaya.id_user_approval
                                            LEFT JOIN m_project ON m_project.id_project = e_detail_keperluan.id_project 
                                        WHERE
                                            e_pengajuan.`status` IN ( 3 ) 
                                            AND e_pengajuan.id_kategori IN ( 17, 18 )
                                            AND DATE( e_pengajuan.tgl_input ) BETWEEN '$datestart' 
                                            AND '$dateend' UNION ALL
                                        SELECT
                                            e_pengajuan.id_pengajuan,
                                            e_pengajuan.tgl_input,
                                            m_divisi.divisi AS nama_divisi,
                                            e_kategori.id_kategori,
                                            e_pengajuan.flag,
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
                                            e_photo_acc.photo_acc,
                                            e_jenis_biaya.id_tipe_biaya,
                                            e_biaya.id_biaya AS new_id_biaya,
                                            e_pengajuan.budget AS new_id_budget,
                                            e_pengajuan.jenis AS new_id_jenis,
                                            e_pengajuan.`status`,
                                            e_m_status.warna,
                                            e_m_status.nama_status,
                                            usr.employee_name AS `name`,
                                            CONCAT(pengaju.first_name, ' ', pengaju.last_name) AS pengaju,
                                            e_jenis_biaya.id_user_approval,
                                            appr.employee_name as nama_approval
                                        FROM
                                            e_pengajuan
                                            JOIN e_pengajuan AS ajuan ON ajuan.temp = e_pengajuan.id_pengajuan
                                            JOIN `user` AS usr ON usr.id_user = e_pengajuan.id_user
                                            LEFT JOIN hris.xin_employees AS pengaju ON e_pengajuan.pengaju = pengaju.user_id
                                            JOIN m_divisi ON m_divisi.id_divisi = e_pengajuan.id_divisi
                                            JOIN e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
                                            JOIN e_biaya ON e_biaya.id_biaya = ajuan.id_biaya
                                            JOIN e_header_lpj ON e_header_lpj.id_lpj = e_pengajuan.id_pengajuan
                                            JOIN ( SELECT id_approval, id_pengajuan, id_user_approval FROM e_approval WHERE id_user_approval = 737 AND `status` IS NOT NULL ) AS e_approval ON e_approval.id_pengajuan = e_pengajuan.id_pengajuan
                                            JOIN e_photo_acc ON e_photo_acc.id_pengajuan = e_pengajuan.id_pengajuan
                                            JOIN e_jenis_biaya ON e_jenis_biaya.id_jenis = ajuan.id_sub_biaya
                                            LEFT JOIN e_m_status ON e_m_status.id_status = e_pengajuan.`status`
                                            LEFT JOIN  `user` AS appr ON appr.id_user = e_jenis_biaya.id_user_approval
                                        WHERE
                                            e_pengajuan.`status` IN ( 7,8 ) 
                                            AND e_pengajuan.id_kategori IN ( 19 )
                                            AND DATE( e_pengajuan.tgl_input ) BETWEEN '$datestart' 
                                            AND '$dateend'");


        $data['data'] = $query->result();
        return $data;
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
                                        e_eaf.e_approval
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
                                        e_jenis_biaya.jenis as nama_lpj,
                                        e_header_lpj.note_lpj,
                                        ajuan.total_pengajuan,
                                        e_header_lpj.nominal_lpj,
                                        ajuan.total_pengajuan - e_header_lpj.nominal_lpj AS sisa_lpj 
                                    FROM
                                        e_eaf.e_pengajuan
                                        JOIN e_eaf.e_header_lpj ON e_header_lpj.id_lpj = e_pengajuan.id_pengajuan
                                        JOIN e_eaf.e_pengajuan AS ajuan ON ajuan.id_pengajuan = e_header_lpj.id_pengajuan 
                                        JOIN e_eaf.e_jenis_biaya ON e_jenis_biaya.id_jenis = ajuan.id_sub_biaya
                                    WHERE
                                        e_pengajuan.id_pengajuan = '$id'");
        $data['data'] = $query->result();
        return $data;
    }

    function get_id_approval_null($id)
    {
        return $this->db->query("SELECT id_approval, id_user_approval FROM e_eaf.e_approval WHERE id_pengajuan = '$id' AND `status` IS NULL")->row_array();
        // $query = $this->db->query("SELECT id_approval FROM e_approval WHERE id_pengajuan = '$id' AND `status` IS NULL;");
        // $data['data'] = $query->row_array();
        // return $data;
    }

    function get_id_approval_print($id)
    {
        return $this->db->query("SELECT id_approval FROM e_approval WHERE id_pengajuan = '$id' AND `level` = 1 AND `status` = 'Approve'")->row_array();
        // $query = $this->db->query("SELECT id_approval FROM e_approval WHERE id_pengajuan = '$id' AND `status` IS NULL;");
        // $data['data'] = $query->row_array();
        // return $data;
    }

    function check_id_budget($id_jenis)
    {
        $query = "SELECT
            e_jenis_biaya.id_budget 
        FROM
            e_eaf.e_jenis_biaya 
        WHERE
            e_jenis_biaya.id_jenis = $id_jenis
        LIMIT 1";

        $data = $this->db->query($query)->row_array();
        return $data['id_budget'];
    }

    function get_biaya($id_budget = null)
    {
        if ($id_budget == null) {
            $where = "(
                e_biaya.tahun_budget = DATE_FORMAT( CURDATE( ), '%Y' ) 
                AND e_biaya.bulan = DATE_FORMAT( CURDATE( ), '%m' ) 
                AND e_biaya.minggu IS NULL 
            ) 
            OR (
                e_biaya.tahun_budget = DATE_FORMAT( CURDATE( ), '%Y' ) 
                AND e_biaya.bulan = DATE_FORMAT( CURDATE( ), '%m' ) 
                AND e_biaya.minggu = WEEK ( CURDATE( ), 1 ) - WEEK ( DATE_FORMAT( CURDATE( ), '%Y-%m-01' ), 1 ) + 1 
            )";
        } else {
            $where = "((
                e_biaya.tahun_budget = DATE_FORMAT( CURDATE( ), '%Y' ) 
                AND e_biaya.bulan = DATE_FORMAT( CURDATE( ), '%m' ) 
                AND e_biaya.minggu IS NULL 
            ) 
            OR (
                e_biaya.tahun_budget = DATE_FORMAT( CURDATE( ), '%Y' ) 
                AND e_biaya.bulan = DATE_FORMAT( CURDATE( ), '%m' ) 
                AND e_biaya.minggu = WEEK ( CURDATE( ), 1 ) - WEEK ( DATE_FORMAT( CURDATE( ), '%Y-%m-01' ), 1 ) + 1 
            )) AND e_biaya.id_budget = $id_budget";
        }

        return $this->db->query("SELECT
            e_biaya.id_biaya,
            e_biaya.nama_biaya,
            e_biaya.budget,
            e_biaya.id_budget,
            e_biaya.bulan,
            e_biaya.tahun_budget,
            e_biaya.minggu, 
            e_biaya.id_budget AS company_id,
						ecomp.company_kode 
        FROM
            e_eaf.e_biaya 
            LEFT JOIN e_eaf.e_company ecomp ON ecomp.company_id = e_biaya.company_id
        WHERE
            $where")->result();
        // $query = $this->db->query("SELECT id_approval FROM e_approval WHERE id_pengajuan = '$id' AND `status` IS NULL;");
        // $data['data'] = $query->row_array();
        // return $data;
    }

    function get_subbiaya($id)
    {
        return $this->db->query("SELECT
            e_jenis_biaya.id_jenis,
            CONCAT( e_jenis_biaya.jenis, ' (', COALESCE(e_m_akun.nama_akun,'tanpa akun'), ')' ) AS jenis,
            e_jenis_biaya.id_tipe_biaya 
        FROM
            e_eaf.e_jenis_biaya
            LEFT JOIN e_eaf.e_m_akun ON e_jenis_biaya.id_akun = e_m_akun.id_akun 
        WHERE
            e_jenis_biaya.id_budget = '$id'")->result();
        // AND e_jenis_biaya.jenis NOT LIKE 'XXX%' ")->result(); // Disable Faisal 22/12/2023
        // $query = $this->db->query("SELECT id_approval FROM e_approval WHERE id_pengajuan = '$id' AND `status` IS NULL;");
        // $data['data'] = $query->row_array();
        // return $data;
    }

    function get_subbiaya_all()
    {
        return $this->db->query("SELECT
            e_jenis_biaya.id_jenis,
            CONCAT(
			e_jenis_biaya.jenis,
			' (',
			-- e_m_akun.nama_akun,
            COALESCE(e_m_akun.nama_akun,'tanpa akun'),

			' - ',
			COALESCE ( REPLACE ( CONCAT( TRIM( emp.first_name ), ' ', TRIM( emp.last_name )), ',', ', ' ), '' ),
			')' 
		) AS jenis,
            e_jenis_biaya.id_tipe_biaya 
        FROM
            e_eaf.e_jenis_biaya
            -- JOIN `user` ON e_jenis_biaya.id_user_approval = `user`.id_user
            JOIN hris.xin_employees emp ON emp.user_id = e_jenis_biaya.id_user_approval
            LEFT JOIN e_eaf.e_m_akun ON e_jenis_biaya.id_akun = e_m_akun.id_akun")->result();
        // WHERE e_jenis_biaya.jenis NOT LIKE 'XXX%'")->result();  // Disable Faisal 22/12/2023
        // $query = $this->db->query("SELECT id_approval FROM e_approval WHERE id_pengajuan = '$id' AND `status` IS NULL;");
        // $data['data'] = $query->row_array();
        // return $data;
    }

    function get_history($id)
    {
        $query = $this->db->query("SELECT
                                        e_pengajuan.id_pengajuan,
                                        e_pengajuan.nama_penerima,
                                        e_kategori.nama_kategori,
                                        -- e_detail_keperluan.nama_keperluan,
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
                                        e_pengajuan.id_kategori 
                                    FROM
                                        e_eaf.e_pengajuan
                                        JOIN e_eaf.e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
                                        JOIN e_eaf.e_detail_keperluan ON e_pengajuan.id_pengajuan = e_detail_keperluan.id_pengajuan
                                        JOIN e_eaf.e_jenis_biaya ON e_pengajuan.id_sub_biaya = e_jenis_biaya.id_jenis
                                        JOIN (
                                        SELECT
                                            e_approval.id_pengajuan,
                                            SUBSTR( MIN( e_approval.update_approve ), 1, 10 ) AS tgl_approve 
                                        FROM
                                            e_eaf.e_approval 
                                        GROUP BY
                                            e_approval.id_pengajuan 
                                        ) AS approve ON approve.id_pengajuan = e_pengajuan.id_pengajuan
                                        LEFT JOIN ( SELECT e_pengajuan.id_pengajuan, e_pengajuan.total_pengajuan FROM e_eaf.e_pengajuan WHERE LEFT ( e_pengajuan.id_pengajuan, 3 ) = 'LPJ' ) AS lpj ON lpj.id_pengajuan = e_pengajuan.temp 
                                        LEFT JOIN rsp_project_live.m_project ON m_project.id_project = e_detail_keperluan.id_project
                                    WHERE
                                        e_pengajuan.id_biaya = '$id'
                                        AND SUBSTR( e_pengajuan.tgl_input, 1, 7 ) = SUBSTR(CURDATE(),1,7)
                                        AND e_pengajuan.id_kategori != 19");
        $data['data'] = $query->result();
        return $data;
    }

    function get_pengajuan($id, $bulan, $tahun, $tipe)
    {
        if ($tipe == 2) {
            $kondisi_query = "AND e_biaya.minggu = WEEK(DATE(e_pengajuan.tgl_input),1) - WEEK(DATE_FORMAT(e_pengajuan.tgl_input,'%Y-%m-01')) + 1";
        } else {
            $kondisi_query = "";
        }

        // return $this->db->query("SELECT
        //                                 IF (e_biaya.minggu IS NULL, NULL, WEEK(DATE(e_pengajuan.tgl_input),1) - WEEK(DATE_FORMAT(e_pengajuan.tgl_input,'%Y-%m-01')) + 1) AS minggu,
        //                                 SUBSTR( e_pengajuan.tgl_input, 6, 2 ) AS bulan,
        //                                 SUBSTR( e_pengajuan.tgl_input, 1, 4 ) AS tahun,
        //                                 e_biaya.id_biaya,
        //                                 e_biaya.id_budget,
        //                                 e_biaya.budget
        //                             FROM
        //                                 e_pengajuan
        //                                 JOIN e_biaya ON e_biaya.id_budget = e_pengajuan.budget
        //                                 $kondisi_query
        //                                 AND e_biaya.bulan = '$bulan' 
        //                                 AND e_biaya.tahun_budget = '$tahun'
        //                             WHERE
        //                                 e_pengajuan.temp = '$id'")->row_array();
        return $this->db->query("SELECT
                                    e_biaya.minggu,
                                    e_biaya.bulan,
                                    e_biaya.tahun_budget AS tahun,
                                    e_biaya.id_biaya,
                                    e_biaya.id_budget,
                                    e_biaya.budget
                                FROM
                                    e_pengajuan
                                    JOIN e_biaya ON e_biaya.id_biaya = e_pengajuan.id_biaya
                                WHERE
                                    e_pengajuan.temp = '$id'")->row_array();
    }

    function get_current_week()
    {
        return $this->db->query("SELECT WEEK(CURDATE(),1) - WEEK(DATE_FORMAT(CURDATE(),'%Y-%m-01')) + 1 as week_now")->row_array();
    }

    function check_sisa_budget($id)
    {
        return $this->db->query("SELECT id_biaya, budget FROM e_eaf.e_biaya WHERE id_biaya = '$id'")->row_array();
    }

    function get_approval_for_wa($id)
    {

        $user_id            = $this->session->userdata('user_id');
        return $this->db->query("SELECT
                                    e_pengajuan.id_pengajuan AS no_eaf,
                                    e_kategori.nama_kategori AS `type`,
                                    e_pengajuan.jenis,
                                    e_detail_keperluan.nama_keperluan AS need,
                                    e_detail_keperluan.note AS `description`,
                                    e_detail_keperluan.nominal_uang AS amount,
                                    e_approval.`status`,
                                    e_approval.note_approve AS note,
                                    e_approval.id_user AS id_user_approval,
                                    -- COALESCE(CONCAT( apr.first_name, ' ', apr.last_name ),'Id HR di RSP Kosong') AS approve_to,
                                    COALESCE(
                                        REPLACE(CONCAT(TRIM(apr.first_name), ' ', TRIM(apr.last_name)), ',', ', '),
                                        ''
                                    ) AS `approve_to`,
                                    e_approval.update_approve AS approved_at,
                                    e_pengajuan.pengaju,
                                    -- CONCAT( emp.first_name, ' ', emp.last_name ) AS requested_by,
                                    COALESCE(
                                        REPLACE(CONCAT(TRIM(emp.first_name), ' ', TRIM(emp.last_name)), ',', ', '),
                                        ''
                                    ) AS `requested_by`,
                                    emp.contact_no AS requested_contact,
                                    jn.id_user_approval AS id_user_biaya,
                                    COALESCE(
                                        REPLACE(CONCAT(TRIM(user_biaya.first_name), ' ', TRIM(user_biaya.last_name)), ',', ', '),
                                        ''
                                    ) AS employee_name,
                                    user_biaya.contact_no AS contact_user_biaya
                                    FROM
                                    e_eaf.e_pengajuan
                                    JOIN e_eaf.e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
                                    JOIN e_eaf.e_detail_keperluan ON e_detail_keperluan.id_pengajuan = e_pengajuan.id_pengajuan
                                    LEFT JOIN e_eaf.e_approval ON e_approval.`level` = 5
                                    AND e_approval.id_pengajuan = '$id'
                                    AND e_approval.id_pengajuan = e_pengajuan.id_pengajuan
                                    LEFT JOIN hris.xin_employees AS apr ON apr.user_id = e_approval.id_user
                                    JOIN hris.xin_employees AS emp ON emp.user_id = e_pengajuan.pengaju
                                    LEFT JOIN e_eaf.e_jenis_biaya jn ON jn.id_jenis = e_pengajuan.jenis
                                    LEFT JOIN xin_employees AS user_biaya ON jn.id_user_approval = user_biaya.user_id
                                    WHERE
                                    e_pengajuan.id_pengajuan = '$id'
                                    LIMIT 1")->row();
    }

    function get_lpj_for_wa($id)
    {
        $user_id            = $this->session->userdata('user_id');
        return $this->db->query("SELECT
                                    lpj.id_pengajuan as no_lpj,
                                    kat.nama_kategori as type,
                                    det.nama_lpj as need,
                                    det.note_lpj as description,
                                    det.nominal_lpj as amount,
                                    fin.`status`,
                                    fin.note_approve as note,
                                    -- user_fin.employee_name as approve_to,
                                    COALESCE(REPLACE(CONCAT(TRIM(user_fin.first_name), ' ', TRIM(user_fin.last_name)),',',', '),'') AS `approve_to`,
                                    fin.update_approve as approved_at,
                                    lpj.note as note_peng
                                FROM
                                    e_eaf.e_pengajuan AS lpj
                                    LEFT JOIN e_eaf.e_kategori AS kat ON lpj.id_kategori = kat.id_kategori
                                    LEFT JOIN e_eaf.e_header_lpj AS det ON det.id_lpj = lpj.id_pengajuan
                                    LEFT JOIN e_eaf.e_approval AS fin ON fin.id_pengajuan = lpj.id_pengajuan 
                                    AND fin.`level` = 5 
                                    -- AND fin.id_user_approval = 737 
                                    AND fin.id_user_approval = 1709 
                                    AND fin.`status` IS NOT NULL 
                                    -- LEFT JOIN `user` as user_fin ON user_fin.id_user = fin.id_user
                                    LEFT JOIN hris.xin_employees AS user_fin ON user_fin.user_id = fin.id_user
                                WHERE
                                    lpj.id_pengajuan = '$id'")->row();
    }

    function get_detail_lpj_for_wa($id)
    {
        return $this->db->query("SELECT
                                    e_pengajuan.id_pengajuan,
                                    e_pengajuan.pengaju as id_pengaju,
                                    CONCAT(em.first_name,' ',em.last_name) as pengaju,
                                    em.contact_no as contact_pengaju
                                FROM
                                    e_eaf.e_pengajuan
                                    JOIN hris.xin_employees AS em ON em.user_id = e_pengajuan.pengaju 
                                WHERE
                                    id_pengajuan = '$id'")->row();
    }

    function edit_blok($id)
    {
        return $this->db->query("SELECT
                                    det.id_pengajuan,
                                    det.nama_keperluan,
                                    det.note,
                                    det.id_project,
                                    pro.project,
                                    det.blok,
                                    aju.id_sub_biaya AS id_jenis,
                                    jen.blok AS tipe_blok 
                                FROM
                                    e_detail_keperluan AS det
                                    JOIN e_pengajuan AS aju ON aju.id_pengajuan = det.id_pengajuan
                                    JOIN e_jenis_biaya AS jen ON jen.id_jenis = aju.id_sub_biaya 
                                    AND jen.blok IS NOT NULL 
                                    JOIN m_project as pro ON pro.id_project = det.id_project
                                WHERE
                                    det.id_pengajuan = '$id'")->result();
    }

    function cek_lpj($id_lpj)
    {
        return $this->db->query("SELECT
                                    lpj.id_pengajuan as id_lpj,
                                    aju.id_pengajuan as id_aju,
                                    apr.id_approval,
                                    aju.id_biaya,
                                    aju.id_sub_biaya as id_jenis,
                                    bya.budget,
                                    bya.minggu,
                                    bya.bulan,
                                    bya.tahun_budget,
                                    jns.id_tipe_biaya,
                                    tp.nama_tipe_biaya,
                                    det_lpj.nominal_lpj,
                                    aju.total_pengajuan as nominal_aju,
                                    (aju.total_pengajuan - det_lpj.nominal_lpj) AS selisih_aju_lpj,
                                    IF((aju.total_pengajuan - det_lpj.nominal_lpj) < 0,'Kurang','Lebih') AS flag
                                FROM
                                    e_eaf.e_pengajuan AS lpj 
                                    JOIN e_eaf.e_pengajuan AS aju ON aju.temp = lpj.id_pengajuan
                                    JOIN e_eaf.e_approval AS apr ON apr.id_pengajuan = lpj.id_pengajuan AND apr.`status` IS NULL
                                    JOIN e_eaf.e_jenis_biaya AS jns ON jns.id_jenis = aju.id_sub_biaya
                                    JOIN e_eaf.e_header_lpj as det_lpj ON det_lpj.id_lpj = lpj.id_pengajuan
                                    JOIN e_eaf.e_biaya AS bya ON bya.id_biaya = aju.id_biaya
                                    JOIN e_eaf.e_tipe_biaya AS tp ON tp.id_tipe_biaya = jns.id_tipe_biaya
                                WHERE
                                    lpj.id_pengajuan = '$id_lpj'")->row_array();
    }

    // Integrasi Eces

    public function get_coa()
    {
        $eces = $this->load->database('db_eces_live', TRUE);
        $query = "SELECT coa_id, coa_kd, coa_nm FROM tm_coa";

        return $eces->query($query);
    }

    public function get_karyawan()
    {
        $eces = $this->load->database('db_eces_live', TRUE);
        $query = "SELECT kry_id, kry_kd, kry_nm FROM tm_karyawan WHERE kry_id > 3 ORDER BY kry_nm";

        return $eces->query($query);
    }

    public function get_rekanan()
    {
        $eces = $this->load->database('db_eces_live', TRUE);
        $query = "SELECT * FROM (SELECT
                        CONCAT( 'K', kry_id ) AS rsck,
                        kry_id AS rkn_id,
                        kry_kd AS rkn_kd,
                        kry_nm AS rkn_nm 
                    FROM
                        tm_karyawan 
                    WHERE
                        kry_id > 3
                        UNION ALL
                    SELECT CONCAT('S', sup_id) AS rsck,
                        sup_id AS rkn_id,
                        sup_kd AS rkn_kd,
                        sup_nm AS rkn_nm FROM tm_supplier WHERE sup_id > 0) AS rkn ORDER BY rkn_nm";
        return $eces->query($query);
    }

    // public function get_rekanan_lpj(){
    //     $eces = $this->load->database('db_eces_live', TRUE);
    //     $query = "SELECT * FROM (SELECT
    //                     CONCAT( 'K', kry_id ) AS rsck,
    //                     kry_id AS rkn_id,
    //                     kry_kd AS rkn_kd,
    //                     kry_nm AS rkn_nm 
    //                 FROM
    //                     tm_karyawan 
    //                 WHERE
    //                     kry_id > 3
    //                     UNION ALL
    //                 SELECT CONCAT('S', sup_id) AS rsck,
    //                     sup_id AS rkn_id,
    //                     sup_kd AS rkn_kd,
    //                     sup_nm AS rkn_nm FROM tm_supplier WHERE sup_id > 0) AS rkn ORDER BY rkn_nm";
    //     return $eces->query($query);
    // }

    public function get_rekening($type)
    {
        // $eces = $this->load->database('db_eces_live', TRUE);
        $eces = $this->load->database('db_eces_live', TRUE);

        if ($type == 'Tunai') {
            $kondisi = "(tm_rekening.rek_jenis = 'K' OR tm_rekening.rek_jenis = '') AND tm_rekening.rek_id != '5990'";
        } else {
            $kondisi = "(tm_rekening.rek_jenis = 'B' OR tm_rekening.rek_jenis = '') AND tm_rekening.rek_id != '5990'";
        }

        $query = "SELECT
			-- CONCAT( 'R', tm_rekening.rek_id ) rek_eces,
		    tm_rekening.rek_id,
			CONCAT( 'R', tm_rekening.bnk_id ) rek_eces,
			CONCAT( tm_rekening.rek_nomor, ' - ', tm_rekening.rek_add2, ' - ', tm_bank.bnk_nm  ) AS rekening,
			tm_rekening.rek_kd
		FROM
			tm_rekening 
        JOIN tm_bank ON tm_bank.bnk_id = tm_rekening.bnk_id
			WHERE
			$kondisi
		ORDER BY
			rek_id DESC 
			-- LIMIT 10
			";

        return $eces->query($query);
    }

    function cek_nominal_pinjaman($id_pengajuan)
    {
        return $this->db->query("SELECT
                                    id_pengajuan,
                                    pengaju,
                                    nominal_termin,
                                    CASE
                                        WHEN RIGHT ( periode_awal_termin, 2 )* 1 = MONTH (
                                            CURDATE()) THEN
                                            jumlah_termin 
                                            WHEN RIGHT ( periode_awal_termin, 2 )* 1 > MONTH (
                                                CURDATE()) THEN
                                                jumlah_termin + ((
                                                        RIGHT ( periode_awal_termin, 2 )* 1 
                                                        ) - MONTH (
                                                    CURDATE())) ELSE 0 
                                            END AS jumlah_termin,
                                            periode_awal_termin,
                                    CASE
                                            WHEN RIGHT ( periode_awal_termin, 2 )* 1 = MONTH (
                                                CURDATE()) THEN
                                                0 
                                                WHEN RIGHT ( periode_awal_termin, 2 )* 1 > MONTH (
                                                    CURDATE()) THEN
                                                    ( RIGHT ( periode_awal_termin, 2 )* 1 ) - MONTH (
                                                    CURDATE()) ELSE 0 
                                                END AS awal 
                                            FROM
                                                e_eaf.e_pengajuan 
                                        WHERE
                                    id_pengajuan = '$id_pengajuan'")->row_array();
    }

    function get_list_temp($id)
    {
        return $this->db->query("SELECT
        id_lpj,
        coa_id,
        debit,
        kredit,
        rekanan 
    FROM
        `t_ju_temp`
        WHERE id_lpj = '$id'")->result();
    }

    function get_e_parameter($id_param, $id_user)
    {
        return $this->db->query("SELECT * FROM e_eaf.e_parameter WHERE id = $id_param AND FIND_IN_SET($id_user,user_id) LIMIT 1");
    }
}

/* End of file model_eaf.php */
/* Location: ./application/models/model_divisi.php */