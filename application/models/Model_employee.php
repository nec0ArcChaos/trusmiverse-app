<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_employee extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function list_employees()
	{
		return $this->db->query("SELECT
			xin_employees.user_id,
			xin_employees.username,
			CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) AS employee,
			xin_departments.department_name,
			xin_designations.designation_name,
			CONCAT( report.first_name, ' ', report.last_name ) AS report_to,
			xin_employees.ctm_report_to,
			com.name
		FROM
			xin_employees
			JOIN xin_designations ON xin_employees.designation_id = xin_designations.designation_id
			JOIN xin_departments ON xin_employees.department_id = xin_departments.department_id
			LEFT JOIN xin_employees AS report ON report.user_id = xin_employees.ctm_report_to
			LEFT JOIN xin_companies AS com ON com.company_id = xin_employees.company_id
		WHERE
			xin_employees.user_id != 1
			AND xin_employees.is_active = 1");
	}
}
