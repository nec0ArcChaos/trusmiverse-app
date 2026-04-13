<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_trusmi_history extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function dt_trusmi_history($start, $end)
    {
        $user_it = array(1, 61, 323, 979, 62, 63, 64, 1161, 2041, 2063, 2969, 2969, 2070, 6486);
        if (in_array($this->session->userdata('user_id'), $user_it)) {
            $cond = "";
        } else {
            $company_id = $this->session->userdata('company_id');
            $cond = " AND c.company_id = '$company_id'";
        }
        $query = "SELECT
                SUBSTR( h.created_at, 1, 10 ) AS tanggal,
                h.employee_id,
                CONCAT(u.first_name,' ',u.last_name) AS employee_name,
                c.`name` AS perusahaan,
                d.department_name AS department,
                des.designation_name,
                h.lock_type,
                l.status_lock,
                h.reason,
                COUNT(id) AS attempp,
                atd.clock_out 
            FROM
                `trusmi_history_lock` h
                LEFT JOIN xin_attendance_time atd ON atd.employee_id = h.employee_id 
                AND atd.attendance_date = SUBSTR( h.created_at, 1, 10 )
                LEFT JOIN xin_employees u ON u.user_id = h.employee_id
                LEFT JOIN xin_companies c ON c.company_id = u.company_id
                LEFT JOIN xin_departments d ON d.department_id = u.department_id 
                AND d.company_id = u.company_id
                LEFT JOIN xin_designations des ON des.designation_id = u.designation_id 
                AND des.company_id = u.company_id 
                AND des.department_id = u.department_id
                LEFT JOIN trusmi_m_lock l ON l.id_lock = h.lock_type
            WHERE SUBSTR( h.created_at, 1, 10 ) BETWEEN '$start' AND '$end' $cond
            GROUP BY SUBSTR(created_at,1,10), h.lock_type, employee_id";
        return $this->db->query($query);
    }
}
