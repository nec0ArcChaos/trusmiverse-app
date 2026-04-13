	
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_permintaan_karyawan extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function department_loker()
	{
		return $this->db->query("SELECT
			xin_departments.department_id,
			CONCAT( xin_departments.department_name, ' | ', xin_companies.`name` ) AS department_name
		FROM
			xin_departments
			JOIN xin_companies ON xin_departments.company_id = xin_companies.company_id
		WHERE
			xin_departments.hide = 0");
	}
	public function get_posisi1()
	{
		return $query = $this->db->query("SELECT
				xin_user_roles.role_id,
				xin_user_roles.role_name,
				xin_user_roles.target 
			FROM
				xin_user_roles 
			WHERE
				xin_user_roles.role_id != 1");
	}
	public function get_contract()
	{
		return $this->db->query("SELECT xin_contract_type.contract_type_id, xin_contract_type.`name` FROM xin_contract_type")->result();
	}
	public function get_education()
	{
		return $this->db->query("SELECT xin_qualification_education_level.education_level_id, xin_qualification_education_level.`name` FROM xin_qualification_education_level");
	}
	public function get_status_job()
	{
		return $this->db->query("SELECT * FROM trusmi_status");
	}
	public function get_all_employees()
	{
		$query = $this->db->get("xin_employees");
		return $query->result();
	}
	public function list_permintaan($start, $end, $status, $user_id = null)
	{
		if (isset($user_id)) {
			if ($user_id == 321) {
				$by_user = "AND xin_users.user_id != 3";
			} else if ($user_id == 2188) {
				$by_user = "AND xin_users.user_id = 2";
			} else if ($user_id == 2) {
				$by_user = "AND xin_users.user_id IN (1,3)";
			} else if ($user_id == 4498 || $user_id == 2535 || $user_id == 6466 || $user_id == 340) {
				$by_user = "";
			} else if($user_id == 70){
				$by_user = "AND xin_users.first_name = 'Batik Group'";
			} else {
				$by_user = "AND trusmi_jobs_request.created_by = $user_id";
			}
		} else {
			$by_user = "";
		}

		return $this->db->query("SELECT
			trusmi_jobs_request.job_id,
			jobs.job_id AS id_xin_job,
			trusmi_jobs_request.job_title,
			xin_users.first_name AS company,
			xin_departments.department_name AS department,
			xin_user_roles.role_name AS position,
			xin_user_roles.role_id AS id_role,
			trusmi_jobs_request.job_vacancy,
			COALESCE(pemenuhan.total, 0) AS pemenuhan,
			trusmi_jobs_request.`status` AS id_status,
			trusmi_status.`status`,
			DATE( trusmi_jobs_request.created_at ) AS created_at,
			CONCAT( created.first_name, ' ', created.last_name ) AS created,
			DATE( trusmi_jobs_request.verified_at ) AS verified_at,
			CONCAT( verified.first_name, ' ', verified.last_name ) AS verified,
			CONCAT( pic.first_name, ' ', pic.last_name ) AS pic,
			trusmi_jobs_request.alasan_reject,
			IF (
					TIMESTAMPDIFF( HOUR, trusmi_jobs_request.created_at, trusmi_jobs_request.verified_at ) > 24,
					CONCAT( DATEDIFF( trusmi_jobs_request.verified_at, trusmi_jobs_request.created_at ), ' Hari' ),
					CONCAT( TIMESTAMPDIFF( HOUR, trusmi_jobs_request.created_at, trusmi_jobs_request.verified_at ), ' Jam' ) 
			) AS lt_verif,
			IF (
					TIMESTAMPDIFF( HOUR, trusmi_jobs_request.verified_at, trusmi_jobs_request.approved_at ) > 24,
					CONCAT( DATEDIFF( trusmi_jobs_request.approved_at, trusmi_jobs_request.verified_at ), ' Hari' ),
					CONCAT( TIMESTAMPDIFF( HOUR, trusmi_jobs_request.verified_at, trusmi_jobs_request.approved_at ), ' Jam' ) 
			) AS lt_approve 
		FROM
			trusmi_jobs_request
			JOIN xin_users ON trusmi_jobs_request.employer_id = xin_users.user_id
			JOIN xin_departments ON trusmi_jobs_request.department_id = xin_departments.department_id
			JOIN xin_user_roles ON trusmi_jobs_request.position_id = xin_user_roles.role_id
			JOIN trusmi_status ON trusmi_jobs_request.`status` = trusmi_status.id
			JOIN xin_employees AS created ON created.user_id = trusmi_jobs_request.created_by
			LEFT JOIN xin_employees AS verified ON verified.user_id = trusmi_jobs_request.verified_by 
			LEFT JOIN xin_employees AS pic ON pic.user_id = trusmi_jobs_request.pic
			LEFT JOIN xin_jobs AS jobs ON jobs.reff_job_id = trusmi_jobs_request.job_id
			LEFT JOIN (
				SELECT 
					xj.reff_job_id,
					COUNT(fpd.application_id) AS total
				FROM 
					fack_personal_details fpd
					JOIN xin_job_applications ja ON ja.application_id = fpd.application_id
					JOIN xin_employees e ON e.user_id = ja.user_id_emp
					JOIN xin_jobs xj ON xj.job_id = ja.job_id
				WHERE 
					ja.application_status IN (5, 7)
					AND fpd.is_link_expired = 1
					AND e.user_id IS NOT NULL
					AND e.user_id != ''
				GROUP BY 
					xj.reff_job_id
			) AS pemenuhan ON pemenuhan.reff_job_id = trusmi_jobs_request.job_id
		WHERE
			trusmi_jobs_request.`status` = $status
            AND SUBSTR(trusmi_jobs_request.created_at,1,10) >= '$start'
			AND SUBSTR(trusmi_jobs_request.created_at,1,10) <= '$end'
			$by_user")->result();
	}
	public function detail_permintaan($job_id)
	{
		return $this->db->query("SELECT
			trusmi_jobs_request.job_id,
			trusmi_jobs_request.job_title,
			xin_users.first_name AS company,
			xin_departments.department_name AS department,
			xin_office_location.location_name AS location,
			xin_user_roles.role_name AS position,
			trusmi_jobs_request.job_vacancy,
			trusmi_status.`status`,
			DATE( trusmi_jobs_request.created_at ) AS created_at,
			CONCAT( created.first_name, ' ', created.last_name ) AS created,
			DATE( trusmi_jobs_request.verified_at ) AS verified_at,
			CONCAT( verified.first_name, ' ', verified.last_name ) AS verified,
			xin_job_type.type AS job_type,
			xin_contract_type.`name` AS type_contract,
			trusmi_jobs_request.gender,
			trusmi_jobs_request.perencanaan,
			trusmi_jobs_request.dasar,
			trusmi_jobs_request.pengganti,
			trusmi_jobs_request.salary,
			trusmi_jobs_request.latar_kebutuhan,
			trusmi_jobs_request.long_description,
			trusmi_jobs_request.kpi,
			trusmi_jobs_request.financial,
			trusmi_jobs_request.bawahan_langsung,
			trusmi_jobs_request.bawahan_tidak,
			trusmi_jobs_request.pendidikan,
			trusmi_jobs_request.minimum_experience,
			trusmi_jobs_request.kemampuan,
			trusmi_jobs_request.komp_kunci,
			trusmi_jobs_request.komp_pemimpin, 
			trusmi_jobs_request.status, 
			trusmi_jobs_request.pengganti 
		FROM
			trusmi_jobs_request
			JOIN xin_users ON trusmi_jobs_request.employer_id = xin_users.user_id
			JOIN xin_departments ON trusmi_jobs_request.department_id = xin_departments.department_id
			JOIN xin_user_roles ON trusmi_jobs_request.position_id = xin_user_roles.role_id
			JOIN trusmi_status ON trusmi_jobs_request.`status` = trusmi_status.id
			JOIN xin_employees AS created ON created.user_id = trusmi_jobs_request.created_by
			JOIN xin_office_location ON trusmi_jobs_request.location_id = xin_office_location.location_id
			JOIN xin_job_type ON trusmi_jobs_request.job_type = xin_job_type.job_type_id
			JOIN xin_contract_type ON trusmi_jobs_request.type_contract = xin_contract_type.contract_type_id
			LEFT JOIN xin_employees AS verified ON verified.user_id = trusmi_jobs_request.verified_by 
		WHERE
			trusmi_jobs_request.job_id = $job_id")->result();
	}
	public function get_perusahaan()
	{
		$query = "SELECT * FROM xin_users WHERE is_active = 1;";
		return $this->db->query($query)->result();
	}
	public function get_department($id)
	{
		$query = "SELECT * FROM xin_departments WHERE company_id = $id AND hide = 0;";
		return $this->db->query($query)->result();
	}
	public function get_posisi2($id_perusahaan, $id_department)
	{
		$query = "SELECT 
                *  
                FROM xin_designations 
                WHERE hide = 0 
                    AND company_id = $id_perusahaan 
                    AND department_id = $id_department;";
		return $this->db->query($query)->result();
	}
	public function get_location($id)
	{
		$query = "SELECT * FROM xin_office_location WHERE company_id = $id;";
		return $this->db->query($query)->result();
	}
	// Mengambil data kelompok posisi
	public function get_posisi3()
	{
		$query = "SELECT
				xin_user_roles.role_id,
				xin_user_roles.role_name,
				xin_user_roles.target 
			FROM
				xin_user_roles 
			WHERE
				xin_user_roles.role_id != 1";
		return $this->db->query($query)->result();
	}
	public function get_status_karyawan()
	{
		$query = "SELECT * FROM xin_job_type";
		return $this->db->query($query)->result();
	}
	public function get_tipe_kontrak()
	{
		$query = "SELECT xin_contract_type.contract_type_id, xin_contract_type.`name` FROM xin_contract_type";
		return $this->db->query($query)->result();
	}
	public function get_pengganti($id, $nama)
	{
		$query = "SELECT user_id,TRIM(CONCAT(first_name,' ',last_name)) as full_name,first_name,last_name,IF(TRIM(CONCAT(first_name,' ',last_name)) = TRIM('$nama'),1,0) as selected FROM xin_employees WHERE company_id = $id";
		return $this->db->query($query)->result();
	}
	// public function get_employee($id)
	// {
	//     $query = "SELECT CONCAT(first_name,' ' ,last_name) as nama, user_id  FROM xin_employees WHERE user_id = $id";
	//     return $this->db->query($query)->row_array();
	// }
	public function get_job_profil($department_id, $designation_id)
	{
		$query = "SELECT
			trusmi_job_profile.no_jp,
			trusmi_job_profile.kompetensi,
			trusmi_job_profile.bawahan,
			xin_user_roles.role_id 
		FROM
			trusmi_job_profile
			LEFT JOIN ( SELECT designation_id, ctm_posisi FROM xin_employees GROUP BY designation_id ) AS posisi ON posisi.designation_id = trusmi_job_profile.designation_id
			LEFT JOIN xin_user_roles ON xin_user_roles.role_name = posisi.ctm_posisi 
		WHERE
			trusmi_job_profile.departement_id = '$department_id' 
			AND trusmi_job_profile.designation_id = '$designation_id'";

		return $this->db->query($query);
	}

	public function get_job_task($no_jp)
	{
		$query = "SELECT
			GROUP_CONCAT( CONCAT( '<li>', trusmi_job_task.tugas, '</li>' ) SEPARATOR '' ) AS job_desc
		FROM
			trusmi_job_task 
		WHERE
			no_jp = '$no_jp'";

		return $this->db->query($query);
	}

	public function get_job_kpi($no_jp)
	{
		$query = "SELECT
			GROUP_CONCAT( REPLACE ( REPLACE ( trusmi_job_kpi.kpi, '&nbsp;', ' ' ), 'p>', 'li>' ) SEPARATOR '' ) AS job_kpi 
		FROM
			trusmi_job_kpi 
		WHERE
			trusmi_job_kpi.no_jp = '$no_jp'";

		return $this->db->query($query);
	}
	function edit_permintaan($id)
	{
		$query = "SELECT
                    * 
                FROM
                    trusmi_jobs_request
                    JOIN (SELECT
                    user_id,
                    user_role,
                    first_name,
                    last_name,
                    company_name,
                    email 
                FROM
                    xin_users) as xin_users ON xin_users.user_id = trusmi_jobs_request.employer_id
                    JOIN xin_designations ON xin_designations.designation_id = trusmi_jobs_request.designation_id 
                WHERE
                    job_id = $id;";
		return $this->db->query($query)->row_array();
	}
	function get_data_pengganti($nama)
	{
		$query = "SELECT
                    * 
                FROM
                    ( SELECT CONCAT( first_name, ' ', last_name ) AS nama, user_id FROM xin_employees ) AS pengganti 
                WHERE
                    pengganti.nama = TRIM('$nama')";
		return $this->db->query($query)->row_array();
	}
	public function job_profile($jabatan, $divisi, $user)
	{
		return $this->db->query("SELECT
			trusmi_sop.nama_dokumen AS jabatan,
			xin_departments.department_name AS divisi,
			xin_companies.company_id,
			xin_companies.`name` AS perusahaan,
			CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) AS `user` 
		FROM
			trusmi_sop
			JOIN xin_companies ON trusmi_sop.company = xin_companies.company_id
			JOIN xin_departments ON trusmi_sop.department = xin_departments.department_id
			JOIN xin_employees ON trusmi_sop.created_by = xin_employees.user_id 
		WHERE
			trusmi_sop.nama_dokumen = '$jabatan' 
			AND trusmi_sop.department = $divisi 
			AND trusmi_sop.created_by = $user");
	}
	public function detail_send_fpk($job_id)
	{
		return $this->db->query("SELECT
			trusmi_jobs_request.job_id,
			xin_users.first_name AS company,
			xin_departments.department_name AS department,
			trusmi_jobs_request.job_title AS position,
			xin_user_roles.role_name AS `level`,
			trusmi_jobs_request.job_vacancy AS need,
			xin_job_type.type AS `status`,
			trusmi_jobs_request.long_description AS jobdesk,
			CONCAT( created.first_name, ' ', created.last_name ) AS created,
			trusmi_jobs_request.created_at 
		FROM
			trusmi_jobs_request
			JOIN xin_users ON trusmi_jobs_request.employer_id = xin_users.user_id
			JOIN xin_departments ON trusmi_jobs_request.department_id = xin_departments.department_id
			JOIN xin_user_roles ON trusmi_jobs_request.position_id = xin_user_roles.role_id
			JOIN xin_job_type ON trusmi_jobs_request.job_type = xin_job_type.job_type_id
			JOIN xin_employees AS created ON created.user_id = trusmi_jobs_request.created_by 
		WHERE
			trusmi_jobs_request.job_id = $job_id")->row_array();
	}
	public function get_send_fpk_rejected_level_1($job_id)
	{
		return $this->db->query("SELECT
									job.job_id,
									comp.first_name AS company,
									dep.department_name AS department,
									job.job_title AS position,
									role.role_name AS `level`,
									job.job_vacancy AS need,
									type.type AS `status`,
									job.long_description AS jobdesk,
									req.employee_name AS requested_by,
								IF
									(
										LEFT ( req.contact_no, 1 ) = '0',
										CONCAT(
											REPLACE ( LEFT ( req.contact_no, 1 ), '0', '62' ),
										SUBSTR( req.contact_no, 2 )),
										req.contact_no 
									) AS req_contact,
									job.created_at AS requested_at,
									job.verified_at,
									verified.employee_name AS verified_by,
								IF
									(
										LEFT ( verified.contact_no, 1 ) = '0',
										CONCAT(
											REPLACE ( LEFT ( verified.contact_no, 1 ), '0', '62' ),
										SUBSTR( verified.contact_no, 2 )),
										verified.contact_no 
									) AS verified_contact,
								CASE
										role.`level` 
										WHEN 2 THEN
										DATE_ADD( DATE( job.created_at ), INTERVAL 30 DAY ) 
										WHEN 3 THEN
										DATE_ADD( DATE( job.created_at ), INTERVAL 21 DAY ) 
										WHEN 4 THEN
										DATE_ADD( DATE( job.created_at ), INTERVAL 14 DAY ) 
										WHEN 5 THEN
										DATE_ADD( DATE( job.created_at ), INTERVAL 10 DAY ) ELSE 0 
									END deadline 
								FROM
									trusmi_jobs_request AS job
									JOIN xin_users AS comp ON job.employer_id = comp.user_id
									JOIN xin_departments AS dep ON job.department_id = dep.department_id
									JOIN xin_user_roles AS role ON job.position_id = role.role_id
									JOIN xin_job_type AS type ON job.job_type = type.job_type_id
									LEFT JOIN (
									SELECT
										user_id,
										CONCAT( first_name, ' ', last_name ) AS employee_name,
										REPLACE ( REPLACE ( REPLACE ( contact_no, '+', '' ), '-', '' ), ' ', '' ) AS contact_no 
									FROM
										xin_employees 
									) AS req ON req.user_id = job.created_by
									LEFT JOIN xin_employees AS approved ON approved.user_id = job.verified_by
									LEFT JOIN (
									SELECT
										user_id,
										CONCAT( first_name, ' ', last_name ) AS employee_name,
										REPLACE ( REPLACE ( REPLACE ( contact_no, '+', '' ), '-', '' ), ' ', '' ) AS contact_no 
									FROM
										xin_employees 
									) AS verified ON verified.user_id = job.verified_by 
								WHERE
									job.job_id = '$job_id'")->row_array();
	}


	public function get_employee_prefill($employee_id)
	{
		return $this->db->query("
			SELECT 
				e.user_id AS employee_id,
				e.company_id,
				u.user_id AS employer_id,
				e.department_id,
				e.designation_id,
				d.designation_name,
				dep.department_name,
				c.name AS company_name,
				e.location_id
			FROM xin_employees e
			LEFT JOIN xin_designations d ON d.designation_id = e.designation_id
			LEFT JOIN xin_departments dep ON dep.department_id = e.department_id
			LEFT JOIN xin_companies c ON c.company_id = e.company_id
			LEFT JOIN xin_users u ON u.company_id = e.company_id
			WHERE e.user_id = ?
			LIMIT 1
		", array($employee_id))->row_array();
	}
}
