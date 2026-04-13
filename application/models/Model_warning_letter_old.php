<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_warning_letter extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function get_data($id_warning){
        $query = "SELECT 
			war.warning_id,
			TRIM(CONCAT(pic.first_name, ' ', pic.last_name)) AS pic,
			war.created_at,
			TRIM(CONCAT(emp.first_name, ' ', emp.last_name)) AS name,
			emp.contact_no,
			war.hasil_investigasi,
			war.description,
			com.alias AS company_name,
			ds.designation_name,
			dp.department_name,
			w_type.type,
			w_type.masa_berlaku
		FROM 
			xin_employee_warnings war
		JOIN xin_warning_type w_type ON war.warning_type_id = w_type.warning_type_id
		JOIN xin_employees emp ON emp.user_id = war.warning_to
		JOIN xin_employees pic ON pic.user_id = war.warning_by
		JOIN xin_companies com ON emp.company_id = com.company_id
		LEFT JOIN xin_departments dp ON dp.department_id = emp.department_id
		LEFT JOIN xin_designations ds ON emp.designation_id = ds.designation_id
		WHERE warning_id = $id_warning
		";
        return $this->db->query($query)->row_object();
    }
}