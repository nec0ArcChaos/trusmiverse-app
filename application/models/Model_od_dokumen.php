<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_od_dokumen extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function data_user($id_user)
	{
		$query = "SELECT
			xin_employees.user_id,
			xin_employees.username,
			xin_employees.contact_no,
			CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) AS employee,
			xin_departments.department_name,
			xin_designations.designation_name,
			CONCAT( report.first_name, ' ', report.last_name ) AS report_to,
			xin_employees.ctm_report_to,
			com.name,
			com.company_id
		FROM
			xin_employees
			JOIN xin_designations ON xin_employees.designation_id = xin_designations.designation_id
			JOIN xin_departments ON xin_employees.department_id = xin_departments.department_id
			LEFT JOIN xin_employees AS report ON report.user_id = xin_employees.ctm_report_to
			LEFT JOIN xin_companies AS com ON com.company_id = xin_employees.company_id
		WHERE
			xin_employees.user_id = '$id_user'";
		return $this->db->query($query)->result();
	}

	function get_employees($company_id)
	{
		if ($company_id == 0) {
			$sort = "";
		} else {
			$sort = " AND company_id = $company_id ";
		}
		return $this->db->query("SELECT
				user_id,
				CONCAT(first_name, ' ', last_name) AS employee
			FROM
				xin_employees
			WHERE is_active = 1 AND user_id != 1 AND ( NOT ( ( `xin_employees`.`first_name` LIKE '%HRD%' ) ) )
			AND ( concat( `xin_employees`.`first_name`, ' ', `xin_employees`.`last_name` ) <> 'Ibnu Riyanto' ) $sort");
	}

	function get_companies()
	{
		return $this->db->query("SELECT company_id, name FROM xin_companies");
	}

	function get_departments($company_id)
	{
		if ($company_id == 0) {
			$sort = "";
		} else {
			$sort = "WHERE xin_departments.company_id = $company_id";
		}
		return $this->db->query("SELECT department_id, department_name FROM xin_departments $sort");
	}

	function get_designations($department_id)
	{
		return $this->db->query("SELECT designation_id, designation_name from xin_designations WHERE department_id = $department_id");
	}

	function get_master_od()
	{
		return $this->db->query("SELECT * FROM trusmi_m_od");
	}

	function get_approval_masters()
	{
		return $this->db->query("SELECT * FROM trusmi_m_od_approval WHERE is_active = '1' ORDER BY nama");
	}

	function generate_id_od()
	{
		$q = $this->db->query("SELECT MAX(RIGHT(id_od, 3)) AS kd_max
			FROM trusmi_t_od
			WHERE SUBSTR(created_at, 1, 10) = CURDATE()");
		$kd = "001";
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $k) {
				if ($k->kd_max !== null) {
					$tmp = ((int)$k->kd_max) + 1;
					$kd = sprintf("%03d", $tmp);
				}
			}
		}
		return 'OD' . date('ymd') . $kd;
	}

	function get_no_doc($doc_type_id, $div_id, $company_id, $department_id)
	{
		return $this->db->query("SELECT
				xin_companies.name,
				xin_departments.department_name,
				CONCAT( '$doc_type_id','/','$div_id','-',xin_departments.kode,'/',xin_companies.kode,'-TG/' ) AS no_doc
			FROM
				xin_companies
			JOIN xin_departments ON xin_companies.company_id = xin_departments.company_id
			WHERE xin_companies.company_id = '$company_id' and xin_departments.department_id = '$department_id'")->result();
	}

	function max_no_doc($department_id)
	{
		$q = $this->db->query("SELECT
			MAX( RIGHT ( trusmi_job_profile.no_dok, 3 ) ) AS kd_max
			FROM
			trusmi_job_profile
			WHERE trusmi_job_profile.departement_id = '$department_id'");
		$kd = "";
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $k) {
				$tmp = ((int)$k->kd_max) + 1;
				$kd = sprintf("%03s", $tmp);
			}
		} else {
			$kd = "001";
		}
		return $kd;
	}

	function data_od($start, $end, $department_id, $id_od = null)
	{
		if (isset($id_od)) {
			$where = "tod.id_od = '$id_od'";
		} else {
			if ($department_id == 0) {
				$where = "DATE(tod.created_at) BETWEEN '$start' AND '$end'";
			} else {
				$where = "DATE(tod.created_at) BETWEEN '$start' AND '$end' AND tod.department_id LIKE '%$department_id%'";
			}
		}

		return $this->db->query("SELECT
				tod.id_od,
				tod.nomer,
				tod.judul,
				tod.jenis,
				tod.priority,
				tod.category,
				tod.company_id,
				tod.department_id,
				tod.role_id,
				tod.cc,
				tod.tujuan,
				tod.note,
				tod.status_od,
				tod.id_approval,
				tod.lampiran,
				tod.tipe_od,
				tod.created_by,
				tod.created_at,
				tod.approve_at,
				tod.publish,
				tod.status_feedback,
				dept.department_name,
				comp.name AS company_name,
				CONCAT(emp.first_name, ' ', emp.last_name) AS created_by_name,
				moa.nama AS approval_name,
				mod_.jenis AS jenis_label,
				mod_.status AS status_label,
				mod_.color_status
			FROM trusmi_t_od AS tod
			LEFT JOIN xin_departments AS dept ON dept.department_id = tod.department_id
			LEFT JOIN xin_companies AS comp ON comp.company_id = tod.company_id
			LEFT JOIN xin_employees AS emp ON emp.user_id = tod.created_by
			LEFT JOIN trusmi_m_od_approval AS moa ON moa.id_approval = tod.id_approval
			LEFT JOIN trusmi_m_od AS mod_ ON mod_.id = tod.jenis
			WHERE $where
			ORDER BY tod.created_at DESC");
	}

	function insert_job_profile($url = null)
	{
		$id_od = $this->generate_id_od();
		$data = [
			'id_od'              => $id_od,
			'judul'              => $_POST['judul'],
			'jenis'              => $_POST['jenis'],
			'category'           => $_POST['category'],
			'nomer'              => isset($_POST['no_dokumen']) ? $_POST['no_dokumen'] : null,
			'priority'           => $_POST['priority'],
			'company_id'         => $_POST['company_id'],
			'department_id'      => is_array($_POST['department_id'])
									? implode(',', $_POST['department_id'])
									: $_POST['department_id'],
			'role_id'            => isset($_POST['role_id'])
									? (is_array($_POST['role_id']) ? implode(',', $_POST['role_id']) : $_POST['role_id'])
									: null,
			'cc'                 => isset($_POST['cc'])
									? (is_array($_POST['cc']) ? implode(',', $_POST['cc']) : $_POST['cc'])
									: null,
			'note'               => isset($_POST['note']) ? $_POST['note'] : null,
			'content'            => isset($_POST['content']) ? $_POST['content'] : null,
			'id_approval'        => isset($_POST['approval']) ? $_POST['approval'] : null,
			'url'                => $url,
			'status_od'          => 1,
			'created_by'         => $this->session->userdata('user_id'),
			'created_at'         => date('Y-m-d H:i:s'),
		];
		return $this->db->insert('trusmi_t_od', $data);
	}

	function update_job_profile()
	{
		$data = [
			'judul'         => $_POST['judul'],
			'jenis'         => $_POST['jenis'],
			'category'      => $_POST['category'],
			'nomer'         => isset($_POST['no_dokumen']) ? $_POST['no_dokumen'] : null,
			'priority'      => $_POST['priority'],
			'company_id'    => $_POST['company_id'],
			'department_id' => is_array($_POST['department_id'])
								? implode(',', $_POST['department_id'])
								: $_POST['department_id'],
			'role_id'       => isset($_POST['role_id'])
								? (is_array($_POST['role_id']) ? implode(',', $_POST['role_id']) : $_POST['role_id'])
								: null,
			'cc'            => isset($_POST['cc'])
								? (is_array($_POST['cc']) ? implode(',', $_POST['cc']) : $_POST['cc'])
								: null,
			'note'          => isset($_POST['note']) ? $_POST['note'] : null,
			'content'       => isset($_POST['content']) ? $_POST['content'] : null,
			'id_approval'   => isset($_POST['approval']) ? $_POST['approval'] : null,
			'updated_by'    => $this->session->userdata('user_id'),
			'updated_at'    => date('Y-m-d H:i:s'),
		];
		$this->db->where('id_od', $_POST['id_od']);
		return $this->db->update('trusmi_t_od', $data);
	}

	function delete_od()
	{
		$this->db->where('id_od', $_POST['id_od']);
		return $this->db->delete('trusmi_t_od');
	}

	function get_pic($id)
	{
		$query = "SELECT user_id, CONCAT( first_name, ' ', last_name ) AS employee_name, contact_no FROM xin_employees WHERE department_id=$id AND ctm_posisi IN ('Supervisor','Assisten Manager','Manager','Head','Direktur') AND is_active = 1 OR user_id IN (68,323,1186)";
		return $this->db->query($query)->result();
	}

	function get_employee_jp()
	{
		return $this->db->query("SELECT
									user_id,
									CONCAT( first_name, ' ', last_name ) AS employee_name
								FROM
									xin_employees AS em
								WHERE
									em.is_active = 1
									AND (user_role_id NOT IN ( 1, 6, 7, 8, 12, 13 )
									OR user_id IN (323,476))
								ORDER BY
									CONCAT( first_name, ' ', last_name )")->result();
	}
}
