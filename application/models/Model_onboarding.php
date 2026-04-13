<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_onboarding extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function get_data_comben($start,$end)
    {
        $user_id = $this->session->userdata('user_id');
        $query = "SELECT
                emp.user_id,
                comp.`name` AS company_name,
                CONCAT(emp.first_name,' ',emp.last_name) AS employee,
                dep.department_name,
                des.designation_name,
                rol.role_name,
                emp.date_of_joining,
                onb.nama,
                item.id,
                item.judul,
                his.created_at,
                his.created_by,
                his.validated_at,
                CONCAT(val.first_name,' ',val.last_name) AS validated_by,
                his.validated_by AS id_validate_by,
                his.validated_note
                FROM
                xin_employees emp
                LEFT JOIN xin_companies comp ON comp.company_id = emp.company_id
                LEFT JOIN xin_departments dep ON dep.department_id = emp.department_id
                LEFT JOIN xin_designations des ON des.designation_id = emp.designation_id
                LEFT JOIN xin_user_roles rol ON rol.role_id = emp.user_role_id
                LEFT JOIN m_onboarding onb ON onb.id_divisi = 1
                LEFT JOIN m_onboarding_item item ON item.id_onboard = onb.id
                LEFT JOIN t_history_onboarding his ON his.id_item_onboard = item.id AND emp.user_id = his.user_id
                LEFT JOIN xin_employees val ON val.user_id = his.validated_by
                
                WHERE
                emp.date_of_joining BETWEEN '$start' AND '$end' 
                ORDER BY emp.date_of_joining DESC
            ";
        return $this->db->query($query)->result();
    }
    function get_data_hr($start,$end){
        $user_id = $this->session->userdata('user_id');
        $query = "SELECT
                emp.user_id,
                comp.`name` AS company_name,
                CONCAT(emp.first_name,' ',emp.last_name) AS employee,
                dep.department_name,
                des.designation_name,
                rol.role_name,
                emp.date_of_joining,
                onb.nama,
                item.id,
                item.judul,
                SUM(IF(his.validated_at IS NULL,1,0)) AS waiting,
                his.created_at,
                his.created_by,
                his.validated_at,
                CONCAT(val.first_name,' ',val.last_name) AS validated_by,
                his.validated_by AS id_validate_by,
                his.validated_note
                FROM
                xin_employees emp
                LEFT JOIN xin_companies comp ON comp.company_id = emp.company_id
                LEFT JOIN xin_departments dep ON dep.department_id = emp.department_id
                LEFT JOIN xin_designations des ON des.designation_id = emp.designation_id
                LEFT JOIN xin_user_roles rol ON rol.role_id = emp.user_role_id
                LEFT JOIN m_onboarding onb ON onb.id_divisi = 2
                LEFT JOIN m_onboarding_item item ON item.id_onboard = onb.id
                LEFT JOIN t_history_onboarding his ON his.id_item_onboard = item.id AND emp.user_id = his.user_id
                LEFT JOIN xin_employees val ON val.user_id = his.validated_by
                
                WHERE
                emp.date_of_joining BETWEEN '$start' AND '$end' 
                GROUP BY emp.user_id
                ORDER BY emp.date_of_joining DESC";
        return $this->db->query($query)->result();
    }
    function get_data_ga($start,$end){
        $query = "SELECT
        req.id,
                    emp.user_id,
                    comp.`name` AS company_name,
                    CONCAT(emp.first_name, ' ', emp.last_name) AS employee,
                    dep.department_name,
                    des.designation_name,
                    emp.date_of_joining,
                    req.detail_request,
                    req.lokasi_kantor,
                    tp.nama_request,
                    req.`status`,
                    CASE req.status 
                    WHEN 0 THEN 'Waiting'
                    WHEN 1 THEN 'Approved'
                    WHEN 2 THEN 'Reject'
                    ELSE 'Pending'
                    END AS status_waiting,
                    req.created_at,
                    CONCAT(crt.first_name, ' ', crt.last_name) AS created_by,
                    req.created_by AS id_created_by,
                    req.validated_at,
                    CONCAT(val.first_name, ' ', val.last_name) AS validated_by,
                    req.validated_by AS id_validated_by
                    
                    FROM
                        t_request_onboarding req 
                        LEFT JOIN xin_employees emp ON req.user_id = emp.user_id
                        LEFT JOIN xin_companies comp ON comp.company_id = emp.company_id
                        LEFT JOIN xin_departments dep ON dep.department_id = emp.department_id
                        LEFT JOIN xin_designations des ON des.designation_id = emp.designation_id
                        LEFT JOIN xin_user_roles rol ON rol.role_id = emp.user_role_id
                        LEFT JOIN m_tipe_request_onboarding tp ON tp.id = req.id_tipe
                        LEFT JOIN xin_employees crt ON crt.user_id = req.created_by
                        LEFT JOIN xin_employees val ON val.user_id = req.validated_by
                    WHERE
                    req.created_at BETWEEN '$start' AND '$end' 
                    ORDER BY
                    emp.date_of_joining DESC";
        return $this->db->query($query)->result();
    }

    function get_detail_employee($user_id){
        $query = "SELECT
                emp.user_id,
                CONCAT(emp.first_name, ' ', emp.last_name) AS employee,
                des.designation_name,
                emp.date_of_joining,
                CONCAT('https://trusmiverse.com/hr/uploads/profile/',emp.profile_picture) AS foto_profile,
                loc.location_name,
                DATEDIFF(CURDATE(), emp.date_of_joining) AS date_diff,
                CONCAT( pic_req.first_name, ' ', pic_req.last_name ) AS pic_nama,
                CONCAT('https://trusmiverse.com/hr/uploads/profile/',pic_req.profile_picture) AS pic_foto
                FROM
                xin_employees emp
                LEFT JOIN xin_companies comp ON comp.company_id = emp.company_id
                LEFT JOIN xin_departments dep ON dep.department_id = emp.department_id
                LEFT JOIN xin_designations des ON des.designation_id = emp.designation_id
                LEFT JOIN xin_office_location loc ON loc.location_id = emp.location_id
                LEFT JOIN xin_job_applications jap ON jap.user_id_emp = $user_id 
                AND jap.application_status = 7
                LEFT JOIN xin_jobs job ON job.job_id = jap.job_id
                LEFT JOIN xin_employees pic_req ON pic_req.user_id = job.pic
                WHERE
                emp.user_id = $user_id;
                ";
        return $this->db->query($query)->row_object();
    }
    function get_detail_day_1($user_id){
        $query = "SELECT
            item.id,
            onb.id AS id_onboard,
            onb.nama,
            onb.day,
            item.tipe,
            item.judul,
            item.deskripsi,
            item.company_id,
            item.department_id,
            item.designation_id,
            CONCAT(item.link,emp.username,'/',item.id_referensi) AS link,
            item.id_referensi,
            IF( his.validated_at IS NULL, 0,1) AS done,
            emp.user_id,
            his.created_at,
            IF(his.validated_at IS NULL, 0 ,1) AS status_validated,
            his.validated_at,
            CONCAT(val.first_name,' ',val.last_name) AS validate_by
            FROM
                m_onboarding_item item
                LEFT JOIN m_onboarding onb ON onb.id = item.id_onboard AND id_divisi = 2
                LEFT JOIN t_history_onboarding his ON his.id_item_onboard = item.id AND his.user_id = $user_id
                LEFT JOIN xin_employees emp ON emp.user_id = $user_id
                LEFT JOIN xin_employees val ON val.user_id = his.validated_by
            WHERE onb.day = 1";
        return $this->db->query($query)->result();
    }
   



}
