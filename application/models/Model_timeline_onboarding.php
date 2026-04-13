<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_timeline_onboarding extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_data(){
        $user_id = $this->session->userdata('user_id');
        $query = "SELECT
                emp.user_id,
                CONCAT(emp.first_name,' ',emp.last_name) AS nama,
                comp.`name` AS company_name,
                dep.department_name,
                des.designation_name,
                emp.date_of_joining
                FROM
                xin_employees emp
                LEFT JOIN xin_companies comp ON comp.company_id = emp.company_id
                LEFT JOIN xin_departments dep ON dep.department_id = emp.department_id
                LEFT JOIN xin_designations des ON des.designation_id = emp.designation_id
                WHERE emp.user_id = $user_id
                ";
        return $this->db->query($query)->row_object();
    }
    function get_day_1()
    {
        $user_id = $this->session->userdata('user_id');
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
            his.user_id,
            his.created_at,
            IF(his.validated_at IS NULL, 0 ,1) AS status_validated,
            his.validated_at,
            CONCAT(val.first_name,' ',val.last_name) AS validate_by
            FROM
            m_onboarding_item item
            LEFT JOIN m_onboarding onb ON onb.id = item.id_onboard
            LEFT JOIN t_history_onboarding his ON his.id_item_onboard = item.id AND his.user_id = $user_id
            LEFT JOIN xin_employees emp ON emp.user_id = $user_id
            LEFT JOIN xin_employees val ON val.user_id = his.validated_by
            WHERE onb.day = 1
            ";
        return $this->db->query($query)->result();
    }
    function get_day_2()
    {
        $user_id = $this->session->userdata('user_id');
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
            IF(his.user_id IS NULL, 0,1) AS done,
            his.user_id,
            his.created_at
            FROM
            m_onboarding_item item
            LEFT JOIN m_onboarding onb ON onb.id = item.id_onboard
            LEFT JOIN t_history_onboarding his ON his.id_item_onboard = item.id AND his.user_id = $user_id
            LEFT JOIN xin_employees emp ON emp.user_id = $user_id
            WHERE onb.day = 2
            ";
        return $this->db->query($query)->result();
    }

    function data_bantuan(){
        $user_id = $this->session->userdata('user_id');
        $query = "SELECT
                    CONCAT(emp.first_name,' ',emp.last_name) AS nama,
                    emp.contact_no,
                    des.designation_name,
                    emp.profile_picture
                FROM
                xin_employees emp
                LEFT JOIN xin_designations des ON des.designation_id = emp.designation_id
                JOIN xin_employees usr ON usr.user_id = $user_id AND usr.department_id = emp.department_id 
                WHERE emp.is_active = 1 AND emp.user_role_id >= 3 AND emp.user_role_id <8";
        return $this->db->query($query)->result();
    }
    function data_perlengkapan(){
        $user_id = $this->session->userdata('user_id');
        $query = "SELECT
                    'Absen Pertama Trusmi Ontime' AS label,
                    '' AS kode,
                    '' AS company_id,
                    '' AS department_id,
                    '' AS role_id,
                    IF(MIN(attendance_date) IS NULL, 0, 1) AS status,
                    CASE 
                     WHEN MIN(attendance_date) IS NULL THEN 'Waiting'
                     
                     ELSE 'Selesai'
                     END AS status_req
                    FROM
                    xin_attendance_time att
                    JOIN xin_employees emp ON att.employee_id = emp.user_id
                    WHERE
                    att.employee_id = $user_id
                    AND emp.date_of_joining <= CURDATE()
                    UNION 
                    SELECT
                    mtp.nama_request,
                    mtp.kode,
                    mtp.company_id,
                    mtp.department_id,
                    mtp.role_id,
                    req.status,
                    CASE req.status 
                        WHEN 0 THEN 'Diproses'
                        WHEN 1 THEN 'Selesai'
                        WHEN 2 THEN 'Ditolak'
                        ELSE 'Waiting'
                        END AS status_req
                    FROM
                    m_tipe_request_onboarding mtp
                    LEFT JOIN t_request_onboarding req ON req.id_tipe = mtp.id AND req.user_id = $user_id";
        return $this->db->query($query)->result();
    }


    // lutfiambar 28-8-25 chatbot hr
    public function get_chat_history($user_id)
    {
        return $this->db
                    ->where('created_by', $user_id)
                    ->order_by('created_at', 'ASC')
                    ->get('t_chatbot_hr')
                    ->result();
    }



}
