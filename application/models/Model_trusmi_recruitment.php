<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_trusmi_recruitment extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  function get_recruitment($start, $end)
  {
      return $this->db->query("SELECT
                                IF ( tg.target IS NULL, 1, 2 ) AS tipe,
                                xin_jobs.job_id,
                                xin_jobs.job_title,
                                xin_jobs.category_id,
                                tg.id AS id_target_mkt,
                                COALESCE ( tg.target, xin_jobs.job_vacancy ) AS `target`,
                                xin_jobs.created_at,
                                DATEDIFF( administrasi.tgl_administrasi, xin_jobs.created_at ) AS leadtime,
                                xin_user_roles.target AS leadtime_tgt,
                                xin_job_categories.category_name AS kategori,
                                xin_user_roles.role_name,
                                xin_users.first_name AS company,
                                COALESCE ( lamar.total_lamar, 0 ) AS total_lamar,
                                COALESCE ( kry_mkt.total_karyawan, karyawan.total_karyawan ) AS total_karyawan,
                                COALESCE ( psi_mkt.total_psikotes, psikotes.total_psikotes ) AS total_psikotes,
                                COALESCE ( int_mkt.total_interview, interview.total_interview ) AS total_interview,
                                COALESCE ( adm_mkt.total_administrasi, administrasi.total_administrasi ) AS total_administrasi,
                                COALESCE ( tg.pic, xin_jobs.pic ) AS id_pic,
                                COALESCE (
                                  CONCAT( mkt.first_name, ' ', mkt.last_name ),
                                CONCAT( pc.first_name, ' ', pc.last_name )) AS pic,
                                xin_jobs.reff_job_id AS trusmi_request_id,
                                ROUND(( COALESCE ( kry_mkt.total_karyawan, karyawan.total_karyawan )/ COALESCE ( tg.target, xin_jobs.job_vacancy ))* 100, 0 ) AS ach,
                                DATE(xin_jobs.created_at) as tgl_posting
                              FROM
                                xin_jobs
                                JOIN xin_job_categories ON xin_jobs.category_id = xin_job_categories.category_id
                                JOIN xin_user_roles ON xin_jobs.position_id = xin_user_roles.role_id
                                JOIN xin_users ON xin_jobs.employer_id = xin_users.user_id
                                LEFT JOIN ( SELECT xin_job_applications.application_id, xin_job_applications.job_id, COUNT( xin_job_applications.job_id ) AS total_lamar FROM xin_job_applications GROUP BY xin_job_applications.job_id ) AS lamar ON xin_jobs.job_id = lamar.job_id
                                LEFT JOIN (
                                SELECT
                                  jba.application_id,
                                  jba.job_id,
                                  COUNT( jba.user_id_emp ) AS total_karyawan 
                                FROM
                                  xin_job_applications AS jba
                                  LEFT JOIN xin_jobs AS jb ON jb.job_id = jba.job_id
                                  LEFT JOIN trusmi_administrasi AS adm ON adm.application_id = jba.application_id
                                  LEFT JOIN trusmi_target_marketing AS tg ON tg.job_id = jba.job_id 
                                WHERE
                                  jba.user_id_emp IS NOT NULL 
                                  AND tg.job_id IS NULL 
                                GROUP BY
                                  jba.job_id 
                                ) AS karyawan ON xin_jobs.job_id = karyawan.job_id
                                LEFT JOIN (
                                SELECT
                                  trusmi_psikotes.application_id,
                                  Count( trusmi_psikotes.application_id ) AS total_psikotes,
                                  xin_job_applications.job_id 
                                FROM
                                  trusmi_psikotes
                                  JOIN xin_job_applications ON xin_job_applications.application_id = trusmi_psikotes.application_id
                                  LEFT JOIN trusmi_target_marketing AS tg ON tg.job_id = xin_job_applications.job_id 
                                WHERE
                                  tg.job_id IS NULL 
                                GROUP BY
                                  xin_job_applications.job_id 
                                ) AS psikotes ON xin_jobs.job_id = psikotes.job_id
                                LEFT JOIN (
                                SELECT
                                  trusmi_interview.application_id,
                                  COUNT( trusmi_interview.application_id ) AS total_interview,
                                  xin_job_applications.job_id 
                                FROM
                                  trusmi_interview
                                  JOIN xin_job_applications ON xin_job_applications.application_id = trusmi_interview.application_id
                                  LEFT JOIN trusmi_target_marketing AS tg ON tg.job_id = xin_job_applications.job_id 
                                  AND tg.pic = trusmi_interview.created_by 
                                WHERE
                                  tg.job_id IS NULL 
                                GROUP BY
                                  xin_job_applications.job_id 
                                ) AS interview ON xin_jobs.job_id = interview.job_id
                                LEFT JOIN (
                                SELECT
                                  trusmi_administrasi.application_id,
                                  COUNT( trusmi_administrasi.application_id ) AS total_administrasi,
                                  xin_job_applications.job_id,
                                  MAX( trusmi_administrasi.created_at ) AS tgl_administrasi 
                                FROM
                                  trusmi_administrasi
                                  JOIN xin_job_applications ON xin_job_applications.application_id = trusmi_administrasi.application_id
                                  LEFT JOIN trusmi_target_marketing AS tg ON tg.job_id = xin_job_applications.job_id 
                                  AND tg.pic = trusmi_administrasi.created_by 
                                WHERE
                                  tg.job_id IS NULL 
                                GROUP BY
                                  xin_job_applications.job_id 
                                ) AS administrasi ON xin_jobs.job_id = administrasi.job_id
                                LEFT JOIN xin_employees AS pc ON pc.user_id = xin_jobs.pic
                                LEFT JOIN trusmi_target_marketing AS tg ON tg.job_id = xin_jobs.job_id 
                                AND tg.periode = SUBSTR( '$start', 1, 7 )
                                LEFT JOIN xin_employees AS mkt ON mkt.user_id = tg.pic
                                LEFT JOIN (
                                SELECT
                                  trusmi_psikotes.application_id,
                                  Count( trusmi_psikotes.application_id ) AS total_psikotes,
                                  xin_job_applications.job_id,
                                  trusmi_psikotes.created_by 
                                FROM
                                  trusmi_psikotes
                                  JOIN xin_job_applications ON xin_job_applications.application_id = trusmi_psikotes.application_id
                                  LEFT JOIN trusmi_target_marketing AS tg ON tg.job_id = xin_job_applications.job_id 
                                  AND tg.pic = trusmi_psikotes.created_by 
                                  AND tg.periode = SUBSTR( '$start', 1, 7 ) 
                                WHERE
                                  tg.job_id IS NOT NULL 
                                GROUP BY
                                  xin_job_applications.job_id,
                                  trusmi_psikotes.created_by 
                                ) AS psi_mkt ON psi_mkt.job_id = tg.job_id 
                                AND psi_mkt.created_by = tg.pic
                                LEFT JOIN (
                                SELECT
                                  trusmi_interview.application_id,
                                  COUNT( trusmi_interview.application_id ) AS total_interview,
                                  xin_job_applications.job_id,
                                  trusmi_interview.created_by 
                                FROM
                                  trusmi_interview
                                  JOIN xin_job_applications ON xin_job_applications.application_id = trusmi_interview.application_id
                                  LEFT JOIN trusmi_target_marketing AS tg ON tg.job_id = xin_job_applications.job_id 
                                  AND tg.pic = trusmi_interview.created_by 
                                  AND tg.periode = SUBSTR( '$start', 1, 7 ) 
                                WHERE
                                  tg.job_id IS NOT NULL 
                                GROUP BY
                                  xin_job_applications.job_id,
                                  trusmi_interview.created_by 
                                ) AS int_mkt ON int_mkt.job_id = tg.job_id 
                                AND int_mkt.created_by = tg.pic
                                LEFT JOIN (
                                SELECT
                                  trusmi_administrasi.application_id,
                                  COUNT( trusmi_administrasi.application_id ) AS total_administrasi,
                                  xin_job_applications.job_id,
                                  MAX( trusmi_administrasi.created_at ) AS tgl_administrasi,
                                  trusmi_administrasi.created_by 
                                FROM
                                  trusmi_administrasi
                                  JOIN xin_job_applications ON xin_job_applications.application_id = trusmi_administrasi.application_id
                                  LEFT JOIN trusmi_target_marketing AS tg ON tg.job_id = xin_job_applications.job_id 
                                  AND tg.pic = trusmi_administrasi.created_by 
                                  AND tg.periode = SUBSTR( '$start', 1, 7 ) 
                                WHERE
                                  tg.job_id IS NOT NULL 
                                GROUP BY
                                  xin_job_applications.job_id,
                                  trusmi_administrasi.created_by 
                                ) AS adm_mkt ON adm_mkt.job_id = tg.job_id 
                                AND adm_mkt.created_by = tg.pic
                                LEFT JOIN (
                                SELECT
                                  jba.application_id,
                                  jba.job_id,
                                  COUNT( jba.user_id_emp ) AS total_karyawan,
                                  adm.created_by 
                                FROM
                                  xin_job_applications AS jba
                                  LEFT JOIN xin_jobs AS jb ON jb.job_id = jba.job_id
                                  LEFT JOIN trusmi_administrasi AS adm ON adm.application_id = jba.application_id
                                  LEFT JOIN trusmi_target_marketing AS tg ON tg.job_id = jba.job_id 
                                  AND tg.pic = adm.created_by 
                                  AND tg.periode = SUBSTR( '$start', 1, 7 ) 
                                WHERE
                                  jba.user_id_emp IS NOT NULL 
                                  AND tg.job_id IS NOT NULL 
                                GROUP BY
                                  jba.job_id,
                                  adm.created_by 
                                ) AS kry_mkt ON kry_mkt.job_id = tg.job_id 
                                AND kry_mkt.created_by = tg.pic 
                              WHERE
                                SUBSTR( xin_jobs.created_at, 1, 10 ) BETWEEN '$start' 
                                AND '$end'")->result();
  }

  function get_employee()
  {
    return $this->db->query("SELECT
                                user_id,
                                CONCAT( first_name, ' ', last_name ) AS employee_name
                              FROM
                                xin_employees 
                              WHERE
                                department_id IN (72,73,156) 
                                AND is_active = 1 
                                AND user_id NOT IN ( 779,2903,3062,780,2774 )")->result();
  }

  function get_jobs($periode = null)
  {
    if ($periode != null) {
      $kondisi = "AND SUBSTR(jb.created_at,1,7) = '$periode'";
    } else {
      $kondisi = "";
    }
    return $this->db->query("SELECT
                              jb.job_id,
                              jb.employer_id,
                              emp.company_name,
                              CONCAT(jb.job_title,' | ',emp.company_name,' | ',jb.date_of_closing) as job_title,
                              jb.date_of_closing,
                              jb.reff_job_id,
                              jb.pic 
                            FROM
                              xin_jobs AS jb
                              JOIN xin_users AS emp ON emp.user_id = jb.employer_id 
                            WHERE
                              jb.job_title LIKE '%marketing%' 
                              AND jb.date_of_closing > CURDATE()
                              $kondisi")->result();
  }

  function data_lamar($job_id)
	{
		$sql = "SELECT
					xin_job_applications.job_id,
					xin_job_applications.full_name,
					xin_job_applications.message,
					xin_job_applications.contact,
					xin_job_applications.email
				FROM
					xin_job_applications 
				WHERE
					xin_job_applications.job_id = $job_id";

		$data['data'] = $this->db->query($sql)->result();
		return $data;
	}

	public function data_psikotes($job_id,$tipe,$id_pic)
	{
    if ($tipe == 2) {
      $kondisi = "WHERE xin_job_applications.job_id = '$job_id' AND trusmi_psikotes.created_by = '$id_pic'";  
    } else {
      $kondisi = "WHERE xin_job_applications.job_id = '$job_id'";
    }

		$sql = "SELECT
					xin_job_applications.job_id,
					xin_job_applications.full_name,
					trusmi_psikotes.iq,
					CONCAT('Current (',trusmi_psikotes.disc1, ') Presure (', trusmi_psikotes.disc2, ') Self (', trusmi_psikotes.disc3, ')') AS disc,
					trusmi_psikotes.keterangan 
				FROM
					trusmi_psikotes
					JOIN xin_job_applications ON xin_job_applications.application_id = trusmi_psikotes.application_id
				$kondisi";

		$data['data'] = $this->db->query($sql)->result();
		return $data;
	}

	public function data_interview($job_id,$tipe,$id_pic)
	{
    if ($tipe == 2) {
      $kondisi = "WHERE xin_job_applications.job_id = '$job_id' AND trusmi_interview.created_by = '$id_pic'";  
    } else {
      $kondisi = "WHERE xin_job_applications.job_id = '$job_id'";
    }
		$sql = "SELECT
					xin_job_applications.job_id,
					xin_job_applications.full_name,
					trusmi_interview.keterangan 
				FROM
					trusmi_interview
					JOIN xin_job_applications ON xin_job_applications.application_id = trusmi_interview.application_id
				$kondisi";

		$data['data'] = $this->db->query($sql)->result();
		return $data;
	}

	public function data_administrasi($job_id,$tipe,$id_pic)
	{
    if ($tipe == 2) {
      $kondisi = "WHERE xin_job_applications.job_id = '$job_id' AND trusmi_administrasi.created_by = '$id_pic'";  
    } else {
      $kondisi = "WHERE xin_job_applications.job_id = '$job_id'";
    }

		$sql = "SELECT
					xin_job_applications.job_id,
					xin_job_applications.full_name,
					trusmi_administrasi.keterangan 
				FROM
					trusmi_administrasi
					JOIN xin_job_applications ON xin_job_applications.application_id = trusmi_administrasi.application_id
				$kondisi";

		$data['data'] = $this->db->query($sql)->result();
		return $data;
	}

	public function data_karyawan($job_id,$tipe,$id_pic)
	{
    if ($tipe == 2) {
      $kondisi = "WHERE xin_job_applications.job_id = '$job_id' 
                  AND xin_job_applications.user_id_emp IS NOT NULL 
                  AND trusmi_administrasi.created_by = '$id_pic'";  
    } else {
      $kondisi = "WHERE xin_job_applications.job_id = '$job_id' 
                  AND xin_job_applications.user_id_emp IS NOT NULL";
    }

		$sql = "SELECT
			xin_job_applications.application_id,
			xin_job_applications.job_id,
			xin_job_applications.full_name,
			trusmi_administrasi.created_at AS tgl_administrasi,
			xin_jobs.created_at AS tgl_job,
			DATEDIFF( trusmi_administrasi.created_at, xin_jobs.created_at ) AS leadtime 
		FROM
			xin_job_applications
			JOIN xin_jobs ON xin_job_applications.job_id = xin_jobs.job_id
			JOIN trusmi_administrasi ON xin_job_applications.application_id = trusmi_administrasi.application_id 
		$kondisi";

		$data['data'] = $this->db->query($sql)->result();
		return $data;
	}
}
