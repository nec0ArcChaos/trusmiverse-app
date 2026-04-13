<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Co_co extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");
		$this->load->model('Model_co_co', 'model');
		if ($this->session->userdata('user_id') != "") {
		} else {
			redirect('login', 'refresh');
		}
	}

	function index()
	{
		$data['content'] 			= "co_co/index";
		$data['pageTitle'] 			= "Coaching & Counseling";
		$data['css'] 				= "co_co/css";
		$data['js'] 				= "co_co/js";
		$data['karyawan']			= $this->model->get_karyawan();
		$data['atasan']				= $this->model->get_atasan();
		$data['project']            = $this->db->query("SELECT id_project, project FROM rsp_project_live.m_project WHERE `status` IS NULL ORDER BY project")->result();
		$data['pekerjaan']            = $this->model->get_pekerjaan();
		$this->load->view("layout/main", $data);
	}
	function print($id)
	{
		$data = $this->model->detail_print($id);
		$this->load->view("co_co/print", $data);
	}

	function save_coaching()
	{
		$id				= $this->model->generate_id_coaching();
		$karyawan		= $_POST['karyawan'];
		$tempat			= $_POST['tempat'];
		$tanggal		= $_POST['tanggal'];
		$atasan			= $_POST['atasan'];
		$review			= $_POST['review'];
		$goals			= $_POST['goals'] ?? '';
		$reality		= $_POST['reality'] ?? '';
		$option			= $_POST['option'] ?? '';
		$will			= $_POST['will'] ?? '';
		$komitmen		= $_POST['komitmen'] ?? '';
		$link_video		= $_POST['link_video'] ?? '';
		$created_at		= date("Y-m-d H:i:s");
		$created_by		= $_SESSION['user_id'];
		$id_project = $_POST['id_project'] ?? '';
		$id_pekerjaan = $_POST['id_pekerjaan'] ?? '';
		$id_sub_pekerjaan = $_POST['id_sub_pekerjaan'] ?? '';
		$id_detail_pekerjaan = $_POST['id_detail_pekerjaan'] ?? '';

		$det = $this->model->get_detail_user($karyawan);

		$company_id		= $det['company_id'];
		$department_id	= @$_SESSION['department_id'] ?? $det['department_id'];
		$designation_id	= $det['designation_id'];
		$role_id		= $det['role_id'];

		if (!empty($_FILES['foto']['name'])) {
			// Proses unggah file
			$config['upload_path']   = './uploads/coaching/';
			// $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
			$config['allowed_types'] = '*';
			$new_name = $id . '_' . time();
			$config['file_name']     = $new_name;
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('foto')) {
				$response['error'] = array('error' => $this->upload->display_errors());
			} else {
				$data = array('upload_data' => $this->upload->data());
				$file_name = $data['upload_data']['file_name'];
			}
		} else {
			$file_name = "";
		}

		$data = array(
			"id_coaching"		=> $id,
			"karyawan" 			=> $karyawan,
			"tempat" 			=> $tempat,
			"tanggal" 			=> $tanggal,
			"atasan" 			=> $atasan,
			"review" 			=> $review,
			"goals" 			=> $goals,
			"reality" 			=> $reality,
			"option" 			=> $option,
			"will" 				=> $will,
			"komitmen" 			=> $komitmen,
			"foto" 				=> $file_name,
			"company_id" 		=> $company_id,
			"department_id" 	=> $department_id,
			"designation_id" 	=> $designation_id,
			"role_id" 			=> $role_id,
			"created_at" 		=> $created_at,
			"created_by" 		=> $created_by,
			"link_video" 		=> $link_video,
			"id_project" 		=> $id_project,
			"id_pekerjaan"        => $id_pekerjaan,
			"id_sub_pekerjaan"    => $id_sub_pekerjaan,
			"id_detail_pekerjaan"    => $id_detail_pekerjaan
		);

		$result['insert_coaching'] = $this->db->insert("coaching", $data);
		echo json_encode($result);
	}

	function list_coaching()
	{
		$start 	= $_POST['start'];
		$end 	= $_POST['end'];

		$result['data'] = $this->model->list_coaching($start, $end);
		echo json_encode($result);
	}

	// function get_atasan($dep_id)
	// {
	// 	$atasan = $this->model->get_atasan($dep_id);
	// 	$result = "";

	// 	$result = '<option value="#">-Choose Employee-</option>';
	// 	foreach ($atasan as $up) {
	// 		$result .= '<option value="'. $up->user_id .'">'. $up->employee_name .'</option>';
	// 	}

	// 	echo json_encode($result);
	// }

	function get_detail_mkt_rsp($id_hr)
	{
		$rsp 	= $this->model->get_id_rsp($id_hr);
		$id_rsp = $rsp['id_user'];

		$result = $this->model->get_detail_mkt_rsp($id_rsp);
		echo json_encode($result);
	}

	public function generate_head_resume_v3()
	{
		// $start 	= $_POST['start'];
		// $end 	= $_POST['end'];

		// $start = date("Y-m-01");
		// $end = date("Y-m-t");

		if (isset($_POST['start'])) {
			if ($_POST['start'] == '') {
				$start 	= date('Y-m-01');
				$end 	= date('Y-m-t');
			} else {
				$start	= $_POST['start'];
				$end	= $_POST['end'];
			}
		} else {
			$start 	= date('Y-m-01');
			$end 	= date('Y-m-t');
		}

		$data = $this->db->query("SELECT
                        CONCAT('W',@rank := @rank + 1) AS week_number,
                        CASE WHEN SUBSTR(calendar_week.tgl_awal,1,7) = SUBSTR(calendar_week.tgl_akhir,1,7)  THEN
                            DATE_FORMAT(calendar_week.tgl_awal,'%d')
                        WHEN SUBSTR(calendar_week.tgl_awal,1,4) != SUBSTR(calendar_week.tgl_akhir,1,4) THEN
                            DATE_FORMAT(calendar_week.tgl_awal,'%d %b %y')
                        ELSE
                            DATE_FORMAT(calendar_week.tgl_awal,'%d %b')
                        END AS f_tgl_awal,
	                    CASE WHEN SUBSTR(calendar_week.tgl_awal,1,7) = SUBSTR(calendar_week.tgl_akhir,1,7)  THEN
                            DATE_FORMAT(calendar_week.tgl_akhir,'%d %b %y')
                        WHEN SUBSTR(calendar_week.tgl_awal,1,4) != SUBSTR(calendar_week.tgl_akhir,1,4) THEN
                            DATE_FORMAT(calendar_week.tgl_akhir,'%d %b %y')
                        ELSE
                            DATE_FORMAT(calendar_week.tgl_akhir,'%d %b %y')
                        END AS f_tgl_akhir,
                        calendar_week.* 
                    FROM (
                        SELECT
                            start_date AS `tgl_awal`,
                            (start_date + INTERVAL 6 DAY) AS tgl_akhir
                        FROM 
                        (
                            SELECT 
                                ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                            FROM
                                (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                                (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                                (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                                (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                                (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                        ) v
                        WHERE start_date BETWEEN DATE_SUB('$start', INTERVAL 1 WEEK) AND '$end' AND WEEKDAY(start_date) = 6
                        GROUP BY (start_date)
                        ORDER BY (start_date)
                    ) AS calendar_week, 
                    (SELECT @rank := 0 ) AS num");
		$response['data'] = $data->result();

		$body_resume = $this->generate_body_resume_v3($start, $end, $data->num_rows());
		$response['body_resume'] = $body_resume;
		$response['jumlah_week'] = $data->num_rows();
		echo json_encode($response);
	}

	public function generate_body_resume_v3($start, $end, $jumlah_week)
	{
		$select = "";
		$week = 1;
		for ($i = 0; $i < $jumlah_week; $i++) {
			$select .= " COUNT(IF(xx.input >= 2 AND xx.w = '$week',1,NULL)) AS w" . $week . ",";
			$select .= " SUM(IF(xx.w = '$week',COALESCE(xx.input,0),0)) AS input_w" . $week . ",";
			$week++;
		}

		$user_id        = $_SESSION['user_id'];
		$role_id        = $_SESSION['user_role_id'];

		$kondisi = "";
		if ($role_id == 1 || $user_id == 803) { // Ittrusmi & Super Admin & Viky & Lintang(Sekdir) & Pak Ibnu
			$kondisi = "";
			// // } else if ($department_id == 117) { // PDCA RSP
			// // $kondisi = "";
		} else {
			$kondisi = "WHERE xx.user_id = $user_id ";
		}

		$query = "SELECT 
                    xx.user_id, 
                    xx.employee_name,
                    $select 
                    xx.company_name,
                    xx.jabatan
                FROM(
                    SELECT tm.user_id, tm.employee_name, tm.company_name, tm.jabatan, th.w, th.tgl_awal, th.tgl_akhir, SUM(IF(th.w IS NOT NULL,1,0)) AS input FROM
                      (
                      SELECT 
                      a.user_id,  CONCAT(a.first_name, ' ', a.last_name) AS employee_name,
                      a.company_id, a.department_id, a.designation_id, c.name AS company_name, ds.designation_name AS jabatan
                      FROM xin_employees a
                      LEFT JOIN xin_user_roles ur ON ur.role_id = a.user_role_id
                      LEFT JOIN xin_companies c ON c.company_id = a.company_id
                      LEFT JOIN xin_departments d ON d.department_id = a.department_id
                      LEFT JOIN xin_designations ds ON ds.designation_id = a.designation_id
                      WHERE a.is_active = 1 AND (user_id IN (0)) 
                      ) tm
                      LEFT JOIN coaching b ON FIND_IN_SET(tm.user_id, b.created_by)
                      LEFT JOIN (
                                          SELECT
                                              @rank := @rank + 1 AS w,
                                              calendar_week.* 
                                          FROM (
                                              SELECT
                                                  start_date AS `tgl_awal`,
                                                  (start_date + INTERVAL 6 DAY) AS tgl_akhir
                                              FROM 
                                              (
                                                  SELECT 
                                                      ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                                                  FROM
                                                      (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                                                      (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                                                      (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                                                      (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                                                      (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                                              ) v
                                              WHERE start_date BETWEEN DATE_SUB('$start', INTERVAL 1 WEEK) AND '$end' AND WEEKDAY(start_date) = 6
                                              GROUP BY (start_date)
                                              ORDER BY (start_date)
                                          ) AS calendar_week, 
                                          (SELECT @rank := 0 ) AS num
                    ) th ON SUBSTR(b.created_at,1,10) BETWEEN th.tgl_awal AND th.tgl_akhir
                    GROUP BY tm.user_id, th.w
                ) xx $kondisi GROUP BY xx.user_id";
		return $this->db->query($query)->result();
	}

	public function generate_body_resume_m_v3()
	{
		if (isset($_POST['start'])) {
			if ($_POST['start'] == '') {
				$start 	= date('Y-m-01');
				$end 	= date('Y-m-t');
			} else {
				$start	= $_POST['start'];
				$end	= $_POST['end'];
			}
		} else {
			$start 	= date('Y-m-01');
			$end 	= date('Y-m-t');
		}

		$data['data'] = $this->model->generate_body_resume_m_v3($start, $end)->result();
		echo json_encode($data);
	}

	//dev add pekerjaan by umam
	function get_pekerjaan()
	{
		$data = $this->model->get_pekerjaan();
		echo json_encode($data);
	}
	function get_sub_pekerjaan($pekerjaan)
	{
		$data = $this->model->get_sub_pekerjaan($pekerjaan);
		echo json_encode($data);
	}
	function get_det_pekerjaan($id_sub_pekerjaan)
	{
		$data = $this->model->get_det_pekerjaan($id_sub_pekerjaan);
		echo json_encode($data);
	}

	public function resume_ketercapaian()
	{
		if (isset($_POST['start'])) {
			if ($_POST['start'] == '') {
				$start 	= date('Y-m-01');
				$end 	= date('Y-m-t');
			} else {
				$start	= $_POST['start'];
				$end	= $_POST['end'];
			}
		} else {
			$start 	= date('Y-m-01');
			$end 	= date('Y-m-t');
		}

		$data = $this->db->query("SELECT
                        CONCAT('W',@rank := @rank + 1) AS week_number,
                        CASE WHEN SUBSTR(calendar_week.tgl_awal,1,7) = SUBSTR(calendar_week.tgl_akhir,1,7)  THEN
                            DATE_FORMAT(calendar_week.tgl_awal,'%d')
                        WHEN SUBSTR(calendar_week.tgl_awal,1,4) != SUBSTR(calendar_week.tgl_akhir,1,4) THEN
                            DATE_FORMAT(calendar_week.tgl_awal,'%d %b %y')
                        ELSE
                            DATE_FORMAT(calendar_week.tgl_awal,'%d %b')
                        END AS f_tgl_awal,
	                    CASE WHEN SUBSTR(calendar_week.tgl_awal,1,7) = SUBSTR(calendar_week.tgl_akhir,1,7)  THEN
                            DATE_FORMAT(calendar_week.tgl_akhir,'%d %b %y')
                        WHEN SUBSTR(calendar_week.tgl_awal,1,4) != SUBSTR(calendar_week.tgl_akhir,1,4) THEN
                            DATE_FORMAT(calendar_week.tgl_akhir,'%d %b %y')
                        ELSE
                            DATE_FORMAT(calendar_week.tgl_akhir,'%d %b %y')
                        END AS f_tgl_akhir,
                        calendar_week.* 
                    FROM (
                        SELECT
                            start_date AS `tgl_awal`,
                            (start_date + INTERVAL 6 DAY) AS tgl_akhir
                        FROM 
                        (
                            SELECT 
                                ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                            FROM
                                (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                                (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                                (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                                (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                                (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                        ) v
                        WHERE start_date BETWEEN DATE_SUB('$start', INTERVAL 1 WEEK) AND '$end' AND WEEKDAY(start_date) = 6
                        GROUP BY (start_date)
                        ORDER BY (start_date)
                    ) AS calendar_week, 
                    (SELECT @rank := 0 ) AS num");
		$response['data'] = $data->result();

		$body_resume = $this->generate_body_resume_ketercapaian($start, $end, $data->num_rows());
		$response['body_resume'] = $body_resume;
		$response['jumlah_week'] = $data->num_rows();
		header('Content-type: application/json');
		echo json_encode($response);
	}

	public function generate_body_resume_ketercapaian($start, $end, $jumlah_week)
	{
		$select = "";
		$week = 1;
		for ($i = 0; $i < $jumlah_week; $i++) {
			$select .= " COUNT(IF(xx.input >= 1 AND xx.w = '$week',1,NULL)) AS w" . $week . ",";
			$select .= " SUM(IF(xx.w = '$week',COALESCE(xx.input,0),0)) AS input_w" . $week . ",";
			$week++;
		}

		$user_id        = $_SESSION['user_id'];
		$role_id        = $_SESSION['user_role_id'];

		$kondisi = "";
		if ($role_id == 1 || $user_id == 803) { // Ittrusmi & Super Admin & Viky & Lintang(Sekdir) & Pak Ibnu
			$kondisi = "";
		} else {
			$kondisi = "WHERE xx.user_id = $user_id ";
		}

		$query = "SELECT 
                    xx.user_id, 
                    xx.employee_name,
                    $select 
                    xx.company_name,
                    xx.department_name,
                    xx.jabatan
                FROM(
                    SELECT tm.user_id, tm.employee_name, tm.company_name, tm.department_name, tm.jabatan, th.w, th.tgl_awal, th.tgl_akhir, SUM(IF(th.w IS NOT NULL,1,0)) AS input FROM
                      (
                      SELECT 
                      a.user_id,  CONCAT(a.first_name, ' ', a.last_name) AS employee_name,
                      a.company_id, a.department_id, a.designation_id, c.name AS company_name, d.department_name, ds.designation_name AS jabatan
                      FROM xin_employees a
                      LEFT JOIN xin_user_roles ur ON ur.role_id = a.user_role_id
                      LEFT JOIN xin_companies c ON c.company_id = a.company_id
                      LEFT JOIN xin_departments d ON d.department_id = a.department_id
                      LEFT JOIN xin_designations ds ON ds.designation_id = a.designation_id
                      WHERE a.is_active = 1 AND (user_id IN (2951, 4138, 1637, 1293, 8066, 2842, 1449, 3529)) 
                      ) tm
                      LEFT JOIN coaching b ON FIND_IN_SET(tm.user_id, b.created_by)
                      LEFT JOIN (
                                          SELECT
                                              @rank := @rank + 1 AS w,
                                              calendar_week.* 
                                          FROM (
                                              SELECT
                                                  start_date AS `tgl_awal`,
                                                  (start_date + INTERVAL 6 DAY) AS tgl_akhir
                                              FROM 
                                              (
                                                  SELECT 
                                                      ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                                                  FROM
                                                      (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                                                      (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                                                      (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                                                      (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                                                      (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                                              ) v
                                              WHERE start_date BETWEEN DATE_SUB('$start', INTERVAL 1 WEEK) AND '$end' AND WEEKDAY(start_date) = 6
                                              GROUP BY (start_date)
                                              ORDER BY (start_date)
                                          ) AS calendar_week, 
                                          (SELECT @rank := 0 ) AS num
                    ) th ON SUBSTR(b.created_at,1,10) BETWEEN th.tgl_awal AND th.tgl_akhir
                    GROUP BY tm.user_id, th.w
                ) xx $kondisi GROUP BY xx.user_id";
		return $this->db->query($query)->result();
	}
}
