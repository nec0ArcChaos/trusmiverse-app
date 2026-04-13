<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_job_post_handika extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	function dt_job_post($start, $end)
	{
		$query = "SELECT
					req.job_id,
					jobs.job_id AS id_xin_job,
					jobs.job_title,
					-- dsg.designation_name,
					dep.department_name,
					xin_users.company_name AS company,
					xin_office_location.location_name AS location,
					rol.role_name AS employer,
					jobs.status AS id_status,
					CASE
						WHEN jobs.status = 1 THEN 'Published'
						WHEN jobs.status = 2 THEN 'Un Published'
						ELSE ''
					END AS status,
					-- trusmi_status.status,
					DATE(jobs.created_at) AS posted_date,
					DATE(jobs.date_of_closing) AS closing_date,
					COALESCE ( CONCAT( em.first_name, ' ', em.last_name ) ) AS requester,
					COALESCE(jobs.job_url,'') AS job_url,
					req.`status` AS id_status_approval,
					CASE req.`status`
						WHEN 4 THEN
							'Approve HR'
						WHEN 5 THEN
							'Reject HR'
						ELSE
							'No Data'
					END AS status_approval
				FROM
					xin_jobs AS jobs
					JOIN trusmi_jobs_request AS req ON req.job_id = jobs.reff_job_id
					LEFT JOIN xin_users ON req.employer_id = xin_users.user_id
					LEFT JOIN xin_user_roles AS rol ON rol.role_id = jobs.position_id
					LEFT JOIN xin_departments dep ON dep.department_id = req.department_id
					-- LEFT JOIN xin_designations dsg ON dsg.designation_id = jobs.designation_id
					-- LEFT JOIN trusmi_status ON req.status = trusmi_status.id
					LEFT JOIN xin_employees em ON em.user_id = req.created_by
					LEFT JOIN xin_office_location ON req.location_id = xin_office_location.location_id
					WHERE DATE(jobs.created_at) BETWEEN '$start' AND '$end'
					ORDER BY jobs.created_at DESC";
		return $this->db->query($query)->result();
	}


	function dt_list_permintaan($job_id = null, $start = null, $end = null)
	{

		if ($job_id != null) {
			$kondisi = "WHERE trusmi_jobs_request.job_id = $job_id LIMIT 1";
		} else {
			$kondisi = "WHERE trusmi_jobs_request.`status` = 2 
						AND SUBSTR(trusmi_jobs_request.verified_at,1,10) BETWEEN '$start' AND '$end' ";
		}

		$query = "SELECT
			trusmi_jobs_request.job_id,
			trusmi_jobs_request.job_title,
			trusmi_jobs_request.designation_id,
			xin_users.user_id AS id_perusahaan,
			xin_office_location.location_name AS location,
			xin_users.company_id AS company_id,
			xin_users.company_name AS company,
			xin_departments.department_id AS id_department,
			xin_departments.department_name AS department,
			trusmi_jobs_request.position_id,
			xin_user_roles.role_name AS position,
			xin_user_roles.role_id AS id_role,
			trusmi_jobs_request.job_vacancy,
			trusmi_jobs_request.location_id,
			trusmi_jobs_request.job_type,
			trusmi_jobs_request.type_contract,
			trusmi_jobs_request.gender,
			trusmi_jobs_request.perencanaan,
			trusmi_jobs_request.dasar AS permohonan,
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
			) AS lt_approve,

			xin_jobs.category_id,
			xin_jobs.date_of_closing AS closing_date,
			xin_jobs.status AS status_publish,
			xin_jobs.pic AS pic_recruiter
		FROM
			trusmi_jobs_request
			JOIN xin_users ON trusmi_jobs_request.employer_id = xin_users.user_id
			JOIN xin_departments ON trusmi_jobs_request.department_id = xin_departments.department_id
			JOIN xin_user_roles ON trusmi_jobs_request.position_id = xin_user_roles.role_id
			JOIN trusmi_status ON trusmi_jobs_request.`status` = trusmi_status.id
			JOIN xin_employees AS created ON created.user_id = trusmi_jobs_request.created_by
			LEFT JOIN xin_employees AS verified ON verified.user_id = trusmi_jobs_request.verified_by 
			LEFT JOIN xin_employees AS pic ON pic.user_id = trusmi_jobs_request.pic 
			LEFT JOIN xin_jobs ON trusmi_jobs_request.job_id = xin_jobs.reff_job_id
			LEFT JOIN xin_office_location ON trusmi_jobs_request.location_id = xin_office_location.location_id
		$kondisi";

		return $this->db->query($query)->result();
	}


	function get_pic_recruiter()
	{
		$query = "SELECT
					pic.user_id,
					pic.karyawan,
					IF(
						LEFT ( pic.contact_no, 1 ) = '0',
						CONCAT(
							REPLACE ( LEFT ( pic.contact_no, 1 ), '0', '62' ),
						SUBSTR( pic.contact_no, 2 )),
						pic.contact_no 
					) AS contact
					
				FROM
				(SELECT
						xin_employees.user_id,
						CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) AS karyawan,
						REPLACE ( REPLACE ( REPLACE ( contact_no, '+', '' ), '-', '' ), ' ', '' ) AS contact_no 
					FROM xin_employees 
					WHERE user_role_id = 11 
					AND is_active = 1
					ORDER BY CONCAT( xin_employees.first_name, ' ', xin_employees.last_name )
				) pic";
		return $this->db->query($query);
	}

	public function get_category()
	{
		//$query = $this->db->query("SELECT jc.*, j.* FROM xin_job_categories as jc, xin_jobs as j where jc.category_id = j.category_id group by jc.category_id");
		$query = $this->db->query("SELECT category_id, category_name FROM xin_job_categories");
		return $query;
	}

	public function get_send_fpk_approved($job_id)
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
									CONCAT( approved.first_name, ' ', approved.last_name ) AS approved_by,
									job.approved_at,
									pic.employee_name AS pic_by,
								IF
									(
										LEFT ( pic.contact_no, 1 ) = '0',
										CONCAT(
											REPLACE ( LEFT ( pic.contact_no, 1 ), '0', '62' ),
										SUBSTR( pic.contact_no, 2 )),
										pic.contact_no 
									) AS pic_contact,
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
									LEFT JOIN xin_employees AS approved ON approved.user_id = job.approved_by
									LEFT JOIN (
									SELECT
										user_id,
										CONCAT( first_name, ' ', last_name ) AS employee_name,
										REPLACE ( REPLACE ( REPLACE ( contact_no, '+', '' ), '-', '' ), ' ', '' ) AS contact_no 
									FROM
										xin_employees 
									) AS pic ON pic.user_id = job.pic 
								WHERE
									job.job_id = '$job_id'")->row_array();
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







	// OLD
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

	public function detail_permintaan($job_id)
	{
		return $this->db->query("SELECT
			trusmi_jobs_request.job_id,
			trusmi_jobs_request.job_title,
			xin_users.company_name AS company,
			xin_departments.department_name AS department,
			trusmi_jobs_request.designation_id,
			xin_designations.designation_name AS designation,
			trusmi_jobs_request.location_id,
			xin_office_location.location_name AS location,
			xin_user_roles.role_name AS position,
			trusmi_jobs_request.job_vacancy,
			xin_contract_type.contract_type_id,
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
			JOIN xin_designations ON trusmi_jobs_request.designation_id = xin_designations.department_id
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
	public function get_jabatan($id_perusahaan, $id_department)
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
	public function get_kel_posisi()
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
	public function get_pengganti($id)
	{
		$query = "SELECT * FROM xin_employees WHERE company_id = $id";
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

	function cek_job($designation_id, $position_id, $location_id)
	{
		$query = "SELECT 
					job_id,
					job_title,
					designation_id,
					position_id,
					location_id,
					date_of_closing,
					status
				FROM xin_jobs
				WHERE status = 1
				AND	designation_id = $designation_id
				AND position_id = $position_id
				AND	location_id = $location_id
				AND date_of_closing > CURRENT_DATE
				ORDER BY created_at DESC";

		return $this->db->query($query);
	}
}
