<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_od_monitoring_jp extends CI_Model
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
			com.name
		FROM
			xin_employees
			JOIN xin_designations ON xin_employees.designation_id = xin_designations.designation_id
			JOIN xin_departments ON xin_employees.department_id = xin_departments.department_id
			LEFT JOIN xin_employees AS report ON report.user_id = xin_employees.ctm_report_to
			LEFT JOIN xin_companies AS com ON com.company_id = xin_employees.company_id
		WHERE
			xin_employees.user_id = '$id_user'
			";
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
	AND ( concat( `xin_employees`.`first_name`, ' ', `xin_employees`.`last_name` ) <> 'Ibnu Riyanto' )  $sort");
	}

	function get_companies()
	{
		return $this->db->query("SELECT company_id, name  FROM xin_companies");
	}

	function get_departments($company_id)
	{
		if ($company_id == 0) {
			$sort = "";
		} else {
			$sort = "WHERE xin_departments.company_id = $company_id";
		}
		return $this->db->query("SELECT department_id, department_name  FROM xin_departments $sort");
	}

	function get_designations($department_id)
	{
		return $this->db->query("SELECT designation_id, designation_name from xin_designations WHERE department_id = $department_id");
	}

	function get_level()
	{
		return $this->db->query("SELECT role_name, `level` from xin_user_roles WHERE xin_user_roles.`level` != 0");
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

	public function no_jp()
	{
		$q = $this->db->query("SELECT
			MAX( RIGHT ( trusmi_job_profile.no_jp, 3 ) ) AS kd_max
			FROM
			trusmi_job_profile
			WHERE
			SUBSTR( trusmi_job_profile.created_at, 1, 10 ) = CURDATE()");
		$kd = "";
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $k) {
				$tmp = ((int)$k->kd_max) + 1;
				$kd = sprintf("%03s", $tmp);
			}
		} else {
			$kd = "001";
		}
		return 'JP' . date('ymd') . $kd;
	}

	public function max_no_doc($department_id)
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

	function data_jp($start, $end, $department_id, $no_jp = null)
	{
		if (isset($no_jp)) {
			$where = " jp.no_jp = '$no_jp'";
		} else {
			if ($department_id == 0) {
				$where = " DATE(jp.created_at) BETWEEN '$start' and '$end'";
			} else {
				$where = " DATE(jp.created_at) BETWEEN '$start' and '$end' AND jp.departement_id = $department_id ";
			}
		}

		return $this->db->query("SELECT
									jp.id,
									jp.no_jp,
									jp.no_dok,
									od_status.review AS status_rv,
									jabatan.designation_name AS jabatan,
									COALESCE ( gol.role_name, `role`.role_name ) AS posisi,
									COALESCE ( gol.level_sto, `role`.level_sto ) AS level_sto,
									COALESCE ( gol.level_romawi, `role`.`level_romawi` ) AS level_romawi,
									xin_departments.department_name,
									jp.created_at,
									'New' AS status_doc,
									jp.`status` AS id_status,
									trusmi_jp_status.`status`,
									jp.departement_id,
									jp.note,
									jp.tujuan,
									jp.bawahan,
									jp.area,
									jp.internal_relation,
									jp.tujuan_internal,
									jp.external_relation,
									jp.tujuan_external,
									jp.pendidikan,
									jp.pengalaman,
									jp.kompetensi,
									jp.softkompetensi,
									jp.teknikalkompetensi,
									jp.authority,
									jp.designation_id,
									jp.release_date,
									jp.penjelasan,
									jp.jadwal_diskusi,
									CONCAT(report_to.first_name,' ',report_to.last_name) AS report_to,
									COALESCE(preparedDep.department_name,'') AS preparedDep,
									CONCAT(preparedBy.first_name,' ',preparedBy.last_name) AS preparedBy,
									CONCAT(head.first_name,' ',head.last_name) AS head
								FROM
									trusmi_job_profile AS jp
									LEFT JOIN xin_employees AS report_to ON report_to.user_id = jp.report_to
									LEFT JOIN xin_employees AS preparedBy ON preparedBy.user_id = jp.prepared_by
									LEFT JOIN xin_departments AS preparedDep ON preparedDep.department_id = preparedBy.department_id
									LEFT JOIN xin_departments ON jp.departement_id = xin_departments.department_id
									LEFT JOIN xin_employees AS head ON head.user_id = xin_departments.head_id
									LEFT JOIN trusmi_jp_status ON jp.`status` = trusmi_jp_status.id
									LEFT JOIN xin_designations AS jabatan ON jabatan.designation_id = jp.designation_id
									LEFT JOIN ( SELECT designation_id, ctm_posisi FROM xin_employees GROUP BY designation_id ) AS posisi ON posisi.designation_id = jp.designation_id
									LEFT JOIN xin_user_roles AS role ON role.role_name = posisi.ctm_posisi
									LEFT JOIN (SELECT role_name, level_romawi, level_sto FROM xin_user_roles WHERE role_id NOT IN (1,11,12,13)) AS gol ON gol.level_romawi = jp.golongan
									LEFT JOIN od_review AS review ON jp.no_jp = review.id_dokumen
									LEFT JOIN od_status ON review.status = od_status.id_status
								WHERE
									$where
								GROUP BY jp.no_jp");
	}

	function insert_job_profile()
	{
		$no_jp = $this->no_jp();
		$data_jp = array(
			'no_jp'          => $no_jp,
			'no_dok'         => $_POST['no_dok'],
			'doc_type_id'    => $_POST['doc_type_id'],
			'div_id'         => $_POST['div_id'],
			'designation_id' => $_POST['designation_id'],
			'departement_id' => $_POST['departement_id'],
			'note'           => $_POST['note'],
			'golongan'       => $_POST['add_golongan'],
			'report_to'      => $_POST['add_report_to'],
			'prepared_by'    => $_POST['add_prepared_by'],
			'release_date'   => date('Y-m-d', strtotime($_POST['add_release_date'])),
			'status'         => 1,
			'created_at'     => date('Y-m-d H:i:s'),
			'created_by'     => $this->session->userdata('user_id')
		);
		return $this->db->insert('trusmi_job_profile', $data_jp);
	}

	function get_pic($id)
	{
		$query = "SELECT user_id, CONCAT( first_name, ' ', last_name ) AS employee_name, contact_no FROM xin_employees WHERE department_id=$id AND ctm_posisi IN ('Supervisor','Assisten Manager','Manager','Head','Direktur') AND is_active = 1 OR user_id IN (68,323,1186)";
		return $this->db->query($query)->result();
	}

	function update_job_profile()
	{
		$data_berkas = array(
			'report_to'  => $_POST['report_to'],
			'tujuan'     => $_POST['tujuan'],
			'bawahan'    => $_POST['bawahan'],
			'area'       => $_POST['area'],
			'pendidikan' => $_POST['pendidikan'],
			'pengalaman' => htmlentities($_POST['pengalaman']),
			'kompetensi' => htmlentities($_POST['kompetensi']),
			'authority'  => htmlentities($_POST['authority']),
			'status'     => 2
		);
		$this->db->where('no_jp', $_POST['no_jp']);
		return $this->db->update('trusmi_job_profile', $data_berkas);
	}

	function add_responsibility()
	{
		$data_responsibility = array(
			'no_jp'          => $_POST['no_jp'],
			'designation_id' => $_POST['designation_id'],
			'tugas'          => $_POST['tugas'],
			'aktifitas'      => $_POST['aktifitas']
		);
		return $this->db->insert('trusmi_job_task', $data_responsibility);
	}

	function delete_jp()
	{
		$this->db->where('no_jp', $_POST['no_jp']);
		return $this->db->delete('trusmi_job_profile');
	}

	function get_job_task($no_jp)
	{
		return $this->db->query("SELECT
				trusmi_job_task.id,
				trusmi_job_task.no_jp,
				trusmi_job_task.designation_id,
				trusmi_job_task.tugas,
				REPLACE ( aktifitas, '&nbsp;', ' ' ) as aktifitas
			FROM
				trusmi_job_task
			WHERE
				trusmi_job_task.no_jp = '$no_jp'")->result();
	}

	function delete_job_task()
	{
		$this->db->where('id', $_POST['id']);
		return $this->db->delete('trusmi_job_task');
	}

	function add_kpi()
	{
		$data_kpi = array(
			'no_jp'          => $_POST['no_jp'],
			'designation_id' => $_POST['designation_id'],
			'kpi'            => $_POST['nama_kpi'],
			'bobot'          => $_POST['bobot_kpi']
		);
		return $this->db->insert('trusmi_job_kpi', $data_kpi);
	}

	function get_kpi($no_jp)
	{
		return $this->db->query("SELECT
				trusmi_job_kpi.id,
				trusmi_job_kpi.no_jp,
				REPLACE ( trusmi_job_kpi.kpi, '&nbsp;', ' ' ) as kpi,
				trusmi_job_kpi.bobot
			FROM
				trusmi_job_kpi
			WHERE
				trusmi_job_kpi.no_jp = '$no_jp'")->result();
	}

	function delete_kpi()
	{
		$this->db->where('id', $_POST['id']);
		return $this->db->delete('trusmi_job_kpi');
	}

	function add_internal()
	{
		$data_work_internal = array(
			'no_jp'          => $_POST['no_jp'],
			'designation_id' => $_POST['designation_id'],
			'tugas'          => $_POST['hubungan_internal'],
			'tujuan'         => $_POST['tujuan_internal']
		);
		return $this->db->insert('trusmi_job_work_internal', $data_work_internal);
	}

	function get_internal($no_jp)
	{
		return $this->db->query("SELECT
				trusmi_job_work_internal.id,
				trusmi_job_work_internal.no_jp,
				trusmi_job_work_internal.designation_id,
				trusmi_job_work_internal.tugas,
				REPLACE ( tujuan, '&nbsp;', ' ' ) as tujuan
			FROM
				trusmi_job_work_internal
			WHERE
				trusmi_job_work_internal.no_jp = '$no_jp'")->result();
	}

	function delete_internal()
	{
		$this->db->where('id', $_POST['id']);
		return $this->db->delete('trusmi_job_work_internal');
	}

	function add_external()
	{
		$data_work_external = array(
			'no_jp'          => $_POST['no_jp'],
			'designation_id' => $_POST['designation_id'],
			'tugas'          => $_POST['hubungan_external'],
			'tujuan'         => $_POST['tujuan_external']
		);
		return $this->db->insert('trusmi_job_work_external', $data_work_external);
	}

	function get_external($no_jp)
	{
		return $this->db->query("SELECT
				trusmi_job_work_external.id,
				trusmi_job_work_external.no_jp,
				trusmi_job_work_external.designation_id,
				trusmi_job_work_external.tugas,
				REPLACE ( tujuan, '&nbsp;', ' ' ) as tujuan
			FROM
				trusmi_job_work_external
			WHERE
				trusmi_job_work_external.no_jp = '$no_jp'")->result();
	}

	function delete_external()
	{
		$this->db->where('id', $_POST['id']);
		return $this->db->delete('trusmi_job_work_external');
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

	function get_golongan_jp()
	{
		return $this->db->query("SELECT
									level_romawi AS `level`,
									role_name
								FROM
									xin_user_roles
								WHERE
									level_romawi IS NOT NULL AND role_id NOT IN (1,11,12,13)
								ORDER BY
									level_romawi")->result();
	}
}
