<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_designation extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_companies()
	{
		return $this->db->get('xin_companies');
	}

	public function get_department($company_id)
	{
		return $this->db->query("SELECT xin_departments.department_id, xin_departments.department_name FROM xin_departments WHERE xin_departments.company_id = $company_id");
	}

	public function get_designation($department_id)
	{
		$kondisi = ($department_id == 0) ? "" : " WHERE xin_designations.department_id = $department_id";

		return $this->db->query("SELECT
		xin_designations.designation_id, CONCAT(xin_designations.designation_name,' | ', xin_departments.department_name) AS designation_name
		FROM xin_designations
		LEFT JOIN xin_departments ON xin_departments.department_id = xin_designations.department_id $kondisi");
	}

	public function list_designation()
	{
		return $this->db->query("SELECT
			xin_designations.designation_id,
			xin_designations.designation_name,
			xin_companies.`name` AS company_name,
			xin_departments.department_name,
			xin_departments.department_id,
			xin_companies.company_id,
			xin_designations.report_to
		FROM
			xin_designations
			JOIN xin_departments ON xin_designations.department_id = xin_departments.department_id
			JOIN xin_companies ON xin_departments.company_id = xin_companies.company_id
		WHERE
			xin_designations.hide = 0");
	}
}
