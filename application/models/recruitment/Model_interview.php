<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_interview extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function approve_status($recruiter_id)
	{
		$application_id 	= $this->input->post('application_id_e');
		$tgl_interview 		= $this->input->post('tgl_interview');
		$jam_interview 		= $this->input->post('jam_interview');
		$lokasi_interview 	= $this->input->post('lokasi_interview');

		$update_status = array(
			'status_interview'	=> 1,
			'tgl_interview'		=> $tgl_interview,
			'jam_interview'		=> $jam_interview,
			'lokasi_interview'	=> $lokasi_interview,
		);

		$this->db->where('application_id', $application_id);
		$result = $this->db->update('xin_job_applications', $update_status);


		//data untuk pesan
		$sqlContact = "SELECT 
							full_name,
							DATE_FORMAT(tgl_interview, '%d %M %Y') AS tgl_interview,
							SUBSTR(jam_interview, 1, 5) AS jam_interview,
							lokasi_interview,
							e.first_name AS pic,
							e.contact_no,
							j.job_title
						FROM xin_job_applications ja
						LEFT JOIN xin_jobs j ON j.job_id = ja.job_id
						LEFT JOIN xin_employees e ON e.user_id = j.pic

						WHERE application_id = $application_id";

		$query = $this->db->query($sqlContact);

		$contactRow = $query->row();

		$sqlUser = "SELECT CONCAT(first_name, ' ', last_name) AS recruiter FROM xin_employees WHERE user_id = $recruiter_id";
		$userRow = $this->db->query($sqlUser)->row();
		$recruiter = $userRow->recruiter;

		// Check if the contact number starts with 0 and replace it with 62
		if ($contactRow) {
			$name = $contactRow->full_name;
			$tgl = $contactRow->tgl_interview; 
			$jam = $contactRow->jam_interview; 
			$no_pic = $contactRow->contact_no;
			$job = $contactRow->job_title;

			if (substr($no_pic, 0, 1) === '0') {
				$contact = '62' . substr($no_pic, 1);
			}			
		}
		

		$url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

		$data_text = array(
			"channelID" => "2225082380",
			"phone" => $contact,
			// "phone" => '6282316041423', //mas ari
			// "phone" => '6285353625600',
			"messageType" => "text",
			"body" => "🙋‍♀️Halo Tim Rekrutmen,

Saya " . $recruiter . ", ingin memberitahukan bahwa telah *menyetujui*✅ untuk melakukan *interview* dengan kandidat untuk posisi *" . $job . "*.

Berikut adalah detail jadwal interview yang telah diatur:
💁 Kandidat: *" . $name . "*
📆 Tanggal: *" . $tgl . "*
🕰️ Waktu: *" . $jam . "*
📌 Lokasi: *" . $lokasi_interview . "*

Mohon untuk menginformasikan kepada kandidat dan memastikan semua persiapan terkait interview telah disiapkan. Jika ada hal yang perlu dikomunikasikan lebih lanjut atau koordinasi tambahan yang dibutuhkan, silakan beritahukan saya.

Terima kasih atas kerja sama Tim Rekrutmen dalam proses ini.

Salam,
" . $recruiter . "",
                "withCase" => true
            );

            $options_text = array(
                'http' => array(
                    "method"  => 'POST',
                    "content" => json_encode($data_text),
                    "header" =>  "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n" .
                        "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
                )
            );

            $context_text   		= stream_context_create($options_text);
            $result_text['wa_api']  = file_get_contents($url, false, $context_text);

		return $result;
	}

	public function reject_status($recruiter_id)
	{
		$application_id 	= $this->input->post('application_id_e');
		$alasan 	= $this->input->post('alasan');

		$update_status = array(
			'status_interview'	=> 0,
			'alasan_interview'	=> $alasan,
		);

		$this->db->where('application_id', $application_id);
		$result = $this->db->update('xin_job_applications', $update_status);


		//data untuk pesan
		$sqlContact = "SELECT 
							full_name,
							DATE_FORMAT(tgl_interview, '%d %M %Y') AS tgl_interview,
							SUBSTR(jam_interview, 1, 5) AS jam_interview,
							lokasi_interview,
							e.first_name AS pic,
							e.contact_no,
							j.job_title,
							ja.alasan_interview
						FROM xin_job_applications ja
						LEFT JOIN xin_jobs j ON j.job_id = ja.job_id
						LEFT JOIN xin_employees e ON e.user_id = j.pic

						WHERE application_id = $application_id";

		$query = $this->db->query($sqlContact);

		$contactRow = $query->row();

		$sqlUser = "SELECT 
						CONCAT(e.first_name, ' ', e.last_name) AS recruiter,
						d.department_name,
						des.designation_name

					FROM xin_employees e 
					LEFT JOIN xin_departments d ON d.department_id = e.department_id
					LEFT JOIN xin_designations des ON des.designation_id = e.designation_id

					WHERE e.user_id = $recruiter_id";

		$userRow = $this->db->query($sqlUser)->row();

		$recruiter = $userRow->recruiter;
		$department = $userRow->department_name;
		$designation = $userRow->designation_name;

		// Check if the contact number starts with 0 and replace it with 62
		if ($contactRow) {
			$name = $contactRow->full_name;
			$no_pic = $contactRow->contact_no;
			$job = $contactRow->job_title;
			$alasan_interview = $contactRow->alasan_interview;
			
			if (substr($no_pic, 0, 1) === '0') {
				$contact = '62' . substr($no_pic, 1);
			}			
		}
		

		$url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

		$data_text = array(
			"channelID" => "2225082380",
			"phone" => $contact,
			// "phone" => '6282316041423', //mas ari
			// "phone" => '6285353625600',
			"messageType" => "text",
			"body" => "🚫 Pemberitahuan Tidak Setuju untuk Interview

Halo Tim Rekrutment,

Saya *" . $recruiter . "*, dari " . $department . " sebagai " . $designation . ", ingin memberitahukan bahwa *Tidak Menyetujui* untuk melanjutkan proses interview kandidat:

🙋‍♂ Nama: *" . $name . "*
📝 Posisi : *" . $job . "*
🗒 Alasan : *" . $alasan_interview . "*

🙏 Terima kasih",
                "withCase" => true
            );

            $options_text = array(
                'http' => array(
                    "method"  => 'POST',
                    "content" => json_encode($data_text),
                    "header" =>  "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n" .
                        "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
                )
            );

            $context_text   		= stream_context_create($options_text);
            $result_text['wa_api']  = file_get_contents($url, false, $context_text);

		return $result;
	}

	public function get_candidates($start, $end, $id, $job_id)
	{
		if ($start == '') {
			$sub_query = '';
		} else {
			$sub_query = "AND SUBSTR(xja.created_at,1,10) BETWEEN '$start' AND '$end'";
		}

		if ($id == '') {
			$where_id = ' xja.application_status IN (1,2,3,4,5,6,7,8,9,10)';
		} else {
			$where_id = " xja.application_status = $id";
		}

		if ($job_id == '') {
			$where_job = '';
		} else {
			$where_job = "AND xja.job_id = $job_id";
		}

		$query = "SELECT
					xja.full_name,
					xja.contact,
					xja.email,
					xja.application_status,
					DATE_FORMAT( SUBSTR( xja.created_at, 1, 10 ), '%d %M %Y' ) AS created_at,
					xja.job_resume,
					xja.job_id,
					xja.job_id_before,
					xja.application_id,
					xin_jobs.job_title,
					xin_job_categories.category_name,
					trusmi_status_hasil.status_hasil,

					xja.status_interview,
					DATE_FORMAT( SUBSTR( xja.tgl_interview, 1, 10 ), '%d %M %Y' ) AS tgl_interview,
					SUBSTR(xja.jam_interview, 1,5) AS jam_interview,
					xja.lokasi_interview,
					xja.alasan_interview,
					xja.is_lolos,
					xja.hasil_interview
				FROM
					xin_job_applications AS xja
					LEFT JOIN xin_jobs ON xin_jobs.job_id = xja.job_id
					LEFT JOIN xin_job_categories ON xin_jobs.category_id = xin_job_categories.category_id
					LEFT JOIN trusmi_status_hasil ON trusmi_status_hasil.id_status = xja.application_status 
				WHERE
					$where_id
					$sub_query
					$where_job
				GROUP BY
					xja.application_id";
		return $this->db->query($query)->result();
	}

	public function data_karyawan()
	{
		return $query = $this->db->query("SELECT
												xin_employees.user_id,
												xin_employees.first_name,
												xin_employees.last_name 
											FROM
												xin_employees
											WHERE xin_employees.user_id != 1
											AND xin_employees.user_role_id NOT IN (7,8)");
	}

	public function get_loker()
	{
		$query = "SELECT
			xin_jobs.job_id,
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
		WHERE CURRENT_DATE <= xin_jobs.date_of_closing
		ORDER BY
			xin_jobs.job_id DESC";

		return $this->db->query($query)->result();
	}


	public function get_send_interview_result($application_id)
	{
		return $this->db->query("SELECT
									comp.first_name AS company,
									dep.department_name AS department,
									job.job_title AS position,
									loc.location_name,
									role.role_name AS `level`,
									job.job_vacancy AS need,
									type.type AS `status`,
									job.long_description AS jobdesk,
									req.user_id AS requested_by,
									req.employee_name AS requester,
								IF
									( LEFT ( req.contact_no, 1 ) = '0', CONCAT( '62', SUBSTR( req.contact_no, 2 )), req.contact_no ) AS contact_request,
									UPPER( app.full_name ) AS full_name,
									intv.keterangan 
								FROM
									hris.trusmi_interview AS intv
									JOIN hris.xin_job_applications AS app ON app.application_id = intv.application_id
									JOIN hris.xin_jobs AS jobs ON jobs.job_id = app.job_id
									LEFT JOIN hris.xin_office_location AS loc ON loc.location_id = jobs.location_id
									LEFT JOIN hris.trusmi_jobs_request AS job ON job.job_id = jobs.reff_job_id
									JOIN (
									SELECT
										user_id,
										CONCAT( first_name, ' ', last_name ) AS employee_name,
										REPLACE ( REPLACE ( REPLACE ( contact_no, '+', '' ), '-', '' ), ' ', '' ) AS contact_no 
									FROM
										hris.xin_employees 
									WHERE
										is_active = 1 
									) AS req ON req.user_id = job.created_by
									JOIN hris.xin_users AS comp ON comp.user_id = job.employer_id
									JOIN hris.xin_departments AS dep ON dep.department_id = job.department_id
									JOIN hris.xin_user_roles AS role ON role.role_id = job.position_id
									JOIN hris.xin_job_type AS type ON type.job_type_id = job.job_type 
								WHERE
									intv.application_id = '$application_id'")->row_array();
	}

	public function get_history($name)
	{
		$query = "SELECT 
					ja.full_name,
					SUBSTR(ja.created_at, 1, 10) AS apply_at,
					ja.application_status,
					s.status_hasil,
					j.job_title  
				FROM xin_job_applications ja
				LEFT JOIN xin_jobs j ON j.job_id = ja.job_id
				LEFT JOIN trusmi_status_hasil s ON s.id_status = ja.application_status

				WHERE full_name = '$name'";

		return $this->db->query($query)->result();
	}

	public function get_alasan($type)
	{
		return $this->db->query("SELECT * FROM trusmi_m_gagal_join WHERE step = '$type'")->result();
	}

	// addnew
	public function get_candidates_for_feedback($start, $end, $id, $job_id, $user_id)
	{
		if ($start == '') {
			$sub_query = '';
		} else {
			$sub_query = "AND SUBSTR(xja.created_at,1,10) BETWEEN '$start' AND '$end'";
		}

		if ($id == '') {
			$where_id = ' xja.application_status IN (1,2,3,4,5,6,7,8,9,10)';
		} else {
			$where_id = " xja.application_status = $id";
		}

		if ($job_id == '') {
			$where_job = '';
		} else {
			$where_job = "AND xja.job_id = $job_id";
		}

		// addnew
		if ($user_id == 1) {
			$where_usr_interview = '';
		} else {
			$where_usr_interview = "AND xja.user_interview = '$user_id'";
		}

		$query = "SELECT
					xja.full_name,
					xja.contact,
					xja.email,
					xja.application_status,
					DATE_FORMAT( SUBSTR( xja.created_at, 1, 10 ), '%d %M %Y' ) AS created_at,
					xja.job_resume,
					xja.job_id,
					xja.job_id_before,
					xja.application_id,
					xin_jobs.job_title,
					xin_job_categories.category_name,
					trusmi_status_hasil.status_hasil,

					xja.status_interview,
					DATE_FORMAT( SUBSTR( xja.tgl_interview, 1, 10 ), '%d %M %Y' ) AS tgl_interview,
					SUBSTR(xja.jam_interview, 1,5) AS jam_interview,
					xja.lokasi_interview,
					xja.alasan_interview,
					xja.is_lolos,
					xja.hasil_interview
				FROM
					xin_job_applications AS xja
					LEFT JOIN xin_jobs ON xin_jobs.job_id = xja.job_id
					LEFT JOIN xin_job_categories ON xin_jobs.category_id = xin_job_categories.category_id
					LEFT JOIN trusmi_status_hasil ON trusmi_status_hasil.id_status = xja.application_status 
				WHERE
					$where_id
					$sub_query
					$where_job
					-- addnew
					AND xja.status_interview IS NULL
					AND xja.application_status = 3 -- yg statusnya interview user saja
					AND xja.deadline_feedback <= CURDATE()
					$where_usr_interview
				GROUP BY
					xja.application_id";
		return $this->db->query($query)->result();
	}
}
