<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Psikotes_sidiq extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function get_candidates($start, $end, $id,$tipe)
	{
		if ($start == '') {
			$sub_query = '';
		} else {
			$sub_query = "AND SUBSTR(xja.created_at,1,10) BETWEEN '$start' AND '$end'";
		}
		if($tipe == 1){
			$kondisi = "AND xja.date_interview_hr IS NULL AND xja.time_interview_hr IS NULL";
		}else{
			$kondisi = "AND xja.date_interview_hr IS NOT NULL AND xja.time_interview_hr IS NOT NULL";

		}
		$query = "SELECT
					xja.full_name,
					xja.contact,
					xja.email,
					xja.application_status,
					DATE_FORMAT( SUBSTR( xja.created_at, 1, 10 ), '%d %M %Y' ) AS created_at,
					xja.job_resume,
					xja.job_id,
					xja.application_id,
					xin_jobs.job_title,
					xin_job_categories.category_name,
					trusmi_status_hasil.status_hasil,
					xja.id_user_talent,
					xja.date_interview_hr,
					xja.time_interview_hr
				FROM
					xin_job_applications AS xja
					LEFT JOIN xin_jobs ON xin_jobs.job_id = xja.job_id
					LEFT JOIN xin_job_categories ON xin_jobs.category_id = xin_job_categories.category_id
					LEFT JOIN trusmi_status_hasil ON trusmi_status_hasil.id_status = xja.application_status 
				WHERE
					xja.application_status IN ($id)
					$sub_query
					$kondisi
				GROUP BY
					xja.application_id";
		return $this->db->query($query)->result();
	}
	public function detail_psikotes($id)
	{
		$query = "SELECT
					iq,
					disc1,
					disc2,
					disc3,
					trusmi_psikotes.keterangan,
					xja.full_name,
					ti.keterangan AS keterangan_interview,
					CONCAT(e.first_name, ' ', e.last_name) AS user_interview
					
				FROM
					trusmi_psikotes
					LEFT JOIN xin_job_applications xja ON xja.application_id = trusmi_psikotes.application_id 
					LEFT JOIN trusmi_interview ti ON ti.application_id = xja.application_id
					LEFT JOIN xin_employees e ON e.user_id = ti.id_user_interview
				WHERE
					trusmi_psikotes.application_id = $id";
		return $this->db->query($query)->row_array();
	}
	public function get_loker()
	{
		$query = "SELECT
			xin_jobs.job_id,
			xin_jobs.job_title,
			CONCAT(
				xin_jobs.job_title,
				' | ',
				xin_jobs.date_of_closing,
				' | ',
				IF(xin_jobs.`status` = 1, 'Published', 'Un Published'),
				' | ',
				COALESCE ( CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ), 'User HR' ),
				' | ',
				xin_users.company_name 
			) AS loker 
		FROM
			xin_jobs
			LEFT JOIN xin_users ON xin_jobs.employer_id = xin_users.user_id
			LEFT JOIN trusmi_jobs_request ON xin_jobs.reff_job_id = trusmi_jobs_request.job_id
			LEFT JOIN xin_employees ON trusmi_jobs_request.created_by = xin_employees.user_id
		ORDER BY
			xin_jobs.job_id DESC";

		return $this->db->query($query)->result();
	}
	public function get_psikotes($id)
	{
		$query = "SELECT
					xja.application_id,
					xja.application_status,
					xja.job_id,
					xja.type,
					xja.grade,
					trusmi_psikotes.disc1,
					trusmi_psikotes.disc2,
					trusmi_psikotes.disc3,
					trusmi_psikotes.iq,
					trusmi_psikotes.keterangan,
					ti.keterangan AS keterangan_interview,
					ti.id_user_interview
					
				FROM
					xin_job_applications AS xja
					LEFT JOIN xin_jobs ON xin_jobs.job_id = xja.job_id
					LEFT JOIN trusmi_psikotes ON trusmi_psikotes.application_id = xja.application_id
					LEFT JOIN trusmi_interview ti ON ti.application_id = xja.application_id
				WHERE
					xja.application_id = $id";
		return $this->db->query($query)->row_array();
	}
	public function get_tiu($id)
	{
		return $this->db->query("SELECT * FROM trusmi_tiu_trx WHERE application_id = $id")->result();
	}
	public function get_tiu_talent_pool($id)
	{
		return $this->db->query("SELECT * FROM talent_pool.t_tiu WHERE application_id = $id")->result();
	}
	public function get_data_interview($id)
	{
		$query = "SELECT
						xja.application_id,
						xin_jobs.job_title,
						DATE_FORMAT( SUBSTR( xin_jobs.date_of_closing, 1, 10 ), '%d %M %Y' ) AS tgl,
						xja.full_name,
						xqal.NAME AS pendidikan,
						xja.masa_kerja_terakhir,
					IF
						( trusmi_psikotes.iq = ' ', 'Tidak Tersedia', trusmi_psikotes.iq ) AS iq,
					IF
						(
							trusmi_psikotes.disc1 = '',
							'Tidak Tersedia',
							CONCAT(
								'(Current : ',
								COALESCE ( trusmi_psikotes.disc1, '-' ),
								'), ',
								'(Presure : ',
								COALESCE ( trusmi_psikotes.disc2, '-' ),
								'), ',
								'(Self : ',
								COALESCE ( trusmi_psikotes.disc3, '-' ),
								')' 
							)) AS disc,
						trusmi_psikotes.keterangan,
						CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) AS `user`,
						IF (
							LEFT ( xin_employees.contact_no, 2 ) = '08',
							CONCAT( '628', RIGHT ( xin_employees.contact_no, LENGTH( xin_employees.contact_no ) - 2 ) ),
							CONCAT( '628', RIGHT ( xin_employees.contact_no, LENGTH( xin_employees.contact_no ) - 3 ) ) 
						) as contact_no,
						xin_employees.user_id -- addnew
					FROM
						xin_job_applications xja
						LEFT JOIN xin_jobs ON xin_jobs.job_id = xja.job_id
						LEFT JOIN trusmi_psikotes ON trusmi_psikotes.application_id = xja.application_id
						LEFT JOIN trusmi_jobs_request ON xin_jobs.reff_job_id = trusmi_jobs_request.job_id
						LEFT JOIN xin_employees ON xin_employees.user_id = trusmi_jobs_request.created_by
						LEFT JOIN xin_qualification_education_level xqal ON xqal.education_level_id = xja.pendidikan 
					WHERE
						xja.application_id = $id;";
		return $this->db->query($query);
	}

	public function get_alasan($type)
	{
		return $this->db->query("SELECT * FROM trusmi_m_gagal_join WHERE step = '$type'")->result();
	}
}
