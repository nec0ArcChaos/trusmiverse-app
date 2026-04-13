<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_job_candidates extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function get_candidates($start, $end)
	{
		$query = "SELECT
					xja.full_name,
					xja.gender,
					xja.contact,
					xja.email,
					TIMESTAMPDIFF(YEAR,xja.tgl_lahir,CURDATE()) as age,
					xja.domisili,
					xja.pendidikan,
					xja.jurusan,
					xja.tempat_pendidikan,
					xja.posisi_kerja_terakhir,
					xja.tempat_kerja_terakhir,
					xja.masa_kerja_terakhir,
					xja.salary,
					xja.application_status,
					xja.created_at,
					xja.job_id,
					xin_jobs.job_title,
					xin_user_roles.role_name,
					xin_job_categories.category_name,
					xin_users.company_name
				FROM
					xin_job_applications as xja
					LEFT JOIN xin_jobs ON xin_jobs.job_id = xja.job_id
					LEFT JOIN xin_designations ON xin_designations.designation_id = xja.job_id
					LEFT JOIN xin_job_categories ON xin_jobs.category_id = xin_job_categories.category_id
					LEFT JOIN xin_user_roles ON xin_user_roles.role_id = xin_jobs.position_id
					LEFT JOIN xin_users ON xin_users.user_id = xja.user_id
				WHERE
					SUBSTR(xja.created_at,1,10) BETWEEN '$start' AND '$end'";
		return $this->db->query($query)->result();
	}
}
