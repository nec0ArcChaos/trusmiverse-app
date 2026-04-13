<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_department extends CI_Model
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

	public function get_location($company_id)
	{
		return $this->db->query("SELECT location_id, company_id, location_name FROM xin_office_location WHERE company_id = '$company_id'");
	}

	public function get_department_head()
	{
		return $this->db->query("SELECT
									user_id,
									CONCAT( first_name, ' ', last_name ) AS employee_name,
									is_active
								FROM
									xin_employees 
								WHERE
									user_role_id IN ( 2, 3, 4, 5, 10 ) 
									AND is_active = 1");
	}

	public function list_department()
	{
		return $this->db->query("SELECT
									dep.department_id,
									dep.department_name,
									dep.company_id,
									com.`name` as company_name,
									dep.location_id,
									loc.location_name,
									dep.employee_id as head_id,
									COALESCE(CONCAT( emp.first_name, ' ', emp.last_name ),'-') AS department_head,
									dep.break,
									IF(dep.break = 0,'Non Akif','Aktif') as break_name,
									COALESCE(dep.kode,'-')  AS department_kode,
									dep.added_by AS created_by,
									dep.created_at,
									dep.`status` 
								FROM
									xin_departments AS dep
									LEFT JOIN xin_companies AS com ON com.company_id = dep.company_id
									LEFT JOIN xin_office_location AS loc ON loc.location_id = dep.location_id
									LEFT JOIN xin_employees AS emp ON emp.user_id = dep.employee_id
								WHERE
									dep.hide = 0");
	}
}

/* End of file Model_ticket.php */
/* Location: ./application/models/Model_ticket.php */
