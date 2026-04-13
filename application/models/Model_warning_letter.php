<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_warning_letter extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	function get_data($id_warning)
	{
		$query = "SELECT 
			war.warning_id,
			TRIM(CONCAT(pic.first_name, ' ', pic.last_name)) AS pic,
			war.created_at,
			TRIM(CONCAT(emp.first_name, ' ', emp.last_name)) AS name,
			emp.contact_no,
			war.hasil_investigasi,
			war.description,
			war.kronologis,
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

	function dt_warning_letter($start, $end, $company, $department)
	{
		$id_user = $this->session->userdata('user_id');
		if (in_array($id_user, [1, 778, 979])) {
			$sub_query2 = '';
		} else {
			$sub_query2 = "AND (xew.warning_to = $id_user OR xew.warning_by = $id_user)";
		}

		if ($department != null AND $department != 'null') {
			$sub_query = "WHERE DATE(xew.created_at) BETWEEN '$start' AND '$end' AND xew.company_id = '$company' AND xe.department_id = $department";
		} else if ($company != null AND $company != 'null') {
			$sub_query = "WHERE DATE(xew.created_at) BETWEEN '$start' AND '$end' AND xew.company_id = '$company'";
		} 
		// else if ($company == 'null' AND $department == '') {
		// 	$sub_query = "WHERE DATE(xew.created_at) BETWEEN '$start' AND '$end'";
		// } 
		else {
			$sub_query = "WHERE DATE(xew.created_at) BETWEEN '$start' AND '$end'";
		}
		$query = "SELECT
						xew.*,
						TRIM(CONCAT(xe.first_name,' ',xe.last_name)) as employee_to, 
						TRIM(CONCAT(xe2.first_name,' ',xe2.last_name)) as employee_by, 
						xc.`name` as company_name,
						xwt.type as warning_name
					FROM
						xin_employee_warnings xew
						JOIN xin_employees xe ON xew.warning_to = xe.user_id
						JOIN xin_employees xe2 ON xew.warning_by = xe2.user_id
						JOIN xin_companies xc ON xew.company_id = xc.company_id
						JOIN xin_warning_type xwt ON xwt.warning_type_id = xew.warning_type_id $sub_query $sub_query2";
		return $this->db->query($query)->result();
	}

	function get_data_notification($warning_to, $warning_by)
	{
		$query = "SELECT
						xew.*,
						TRIM(
						CONCAT( xe.first_name, ' ', xe.last_name )) AS employee_to,
						TRIM(CONCAT( xe2.first_name, ' ', xe2.last_name )) AS employee_by,
						xd.designation_name,
						xde.department_name,
						xwt.type,
						xwt.masa_berlaku,
					IF
						(
							LEFT ( xe.contact_no, 2 ) = '08',
							CONCAT( '628', RIGHT ( xe.contact_no, LENGTH( xe.contact_no ) - 2 ) ),
							CONCAT( '628', RIGHT ( xe.contact_no, LENGTH( xe.contact_no ) - 3 ) ) 
						) AS contact	
					FROM
						`xin_employee_warnings` xew
						JOIN xin_employees xe ON xew.warning_to = xe.user_id
						JOIN xin_employees xe2 ON xew.warning_by = xe2.user_id
						LEFT JOIN xin_designations xd ON xd.designation_id = xe.designation_id 
						LEFT JOIN xin_departments xde ON xde.department_id = xe.department_id
						LEFT JOIN xin_warning_type xwt ON xwt.warning_type_id = xew.warning_type_id
					WHERE
						xew.warning_to = $warning_to AND xew.warning_by = $warning_by AND SUBSTR(xew.created_at,1,10) = CURDATE()
						ORDER BY xew.warning_id DESC LIMIT 1";
		return $this->db->query($query)->row_array();
	}

	function dt_rekomendasi_warning($start, $end, $company, $department)
	{
		// addnew 14/05/25
		$kondisi = "";
		$id_user = $this->session->userdata('user_id');
		if (!in_array($id_user, [1])) {
			$kondisi = "AND head_id = '$id_user'";
		}

		// if ($department != null) {
		// 	$sub_query = "WHERE DATE(created_at) BETWEEN '$start' AND '$end' AND company_id = '$company' AND department_id = '$department' $kondisi";
		// } else if ($company != null) {
		// 	$sub_query = "WHERE DATE(created_at) BETWEEN '$start' AND '$end' AND company_id = '$company' $kondisi";
		// } else {
			$sub_query = "WHERE DATE(created_at) BETWEEN '$start' AND '$end' $kondisi";
		// }
		$query = "SELECT * FROM view_penalty $sub_query AND status = '0'";
		return $this->db->query($query)->result();
	}
}
