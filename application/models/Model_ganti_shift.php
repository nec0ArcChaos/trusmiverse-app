<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_ganti_shift extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function data_shift()
    {
        $department_id = $this->session->userdata('department_id');
        return $query = $this->db->query("SELECT
			xin_employees.user_id,
			CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) AS nama,
			xin_employees.office_shift_id,
			xin_employees.department_id,
			xin_employees.designation_id,
			xin_departments.department_name,
			xin_designations.designation_name,
			xin_office_shift.shift_name 
			FROM
			xin_employees
			JOIN xin_departments ON xin_employees.department_id = xin_departments.department_id
			JOIN xin_designations ON xin_employees.designation_id = xin_designations.designation_id
			JOIN xin_office_shift ON xin_office_shift.office_shift_id = xin_employees.office_shift_id
			WHERE
			xin_employees.department_id = $department_id
			AND xin_employees.is_active = 1");
    }

    public function get_shift()
    {
        return $this->db->query("SELECT xin_office_shift.office_shift_id, xin_office_shift.shift_name FROM xin_office_shift");
    }
}
