<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_profile extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_my_profile()
    {
        $user_id = $this->session->userdata("user_id");
        $query = "SELECT
                    e.user_id,
                    CONCAT( e.first_name, ' ', e.last_name ) AS employee_name,
                    e.company_id,
                    c.`name` AS company_name,
                    e.department_id,
                    d.department_name,
                    e.designation_id,
                    ds.designation_name,
                    e.address,
                    e.email,
                    e.contact_no,
	                e.profile_picture
                FROM
                    xin_employees e
                    LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id 
                    AND ds.company_id = e.company_id 
                    AND ds.department_id = e.department_id
                    LEFT JOIN xin_departments d ON d.department_id = e.department_id 
                    AND d.company_id = e.company_id
                    LEFT JOIN xin_companies c ON c.company_id = e.company_id 
                WHERE
                    user_id = '$user_id' LIMIT 1";
        return $this->db->query($query);
    }
    public function training_list($user_id)
    {
        $query = "SELECT
                    p.id_test,
                    mt.training,
                    materi_selesai
                FROM
                    `trusmi_pretest` p
                LEFT JOIN trusmi_materi_training mt ON mt.id = p.id_training
                WHERE
                    employe_id = '$user_id' ORDER BY p.materi_selesai DESC LIMIT 4";
        return $this->db->query($query)->result();
    }

    public function get_profile_by_id($id)
    {
        $query = "SELECT
                    e.user_id,
                    e.employee_id,
                    CONCAT( e.first_name, ' ', e.last_name ) AS employee_name,
                    e.company_id,
                    c.`name` AS company_name,
                    e.department_id,
                    d.department_name,
                    e.designation_id,
                    ds.designation_name,
                    e.address,
                    e.email,
                    e.contact_no,
	                e.profile_picture
                FROM
                    xin_employees e
                    LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id 
                    AND ds.company_id = e.company_id 
                    AND ds.department_id = e.department_id
                    LEFT JOIN xin_departments d ON d.department_id = e.department_id 
                    AND d.company_id = e.company_id
                    LEFT JOIN xin_companies c ON c.company_id = e.company_id 
                WHERE
                    user_id = '$id' LIMIT 1";
        return $this->db->query($query);
    }
}
