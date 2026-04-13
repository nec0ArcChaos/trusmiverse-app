<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Problem_solving extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");
		$this->load->model('Model_problem_solving', 'model');
		if ($this->session->userdata('user_id') != "") {
		} else {
			redirect('login', 'refresh');
		}
	}

	function index()
	{
		$data['content'] 			= "problem_solving/index";
		$data['pageTitle'] 			= "Problem Solving";
		$data['css'] 				= "problem_solving/css";
		$data['js'] 				= "problem_solving/js";
		$data['category']			= $this->model->get_master('category');
		$data['priority']			= $this->model->get_master('priority');
		$data['status']				= $this->model->get_master('status');
		$data['pic']				= $this->model->get_pic();
		$data['project']			= $this->db->query("SELECT divisi AS project, divisi AS id_project FROM `grd_m_so` GROUP BY divisi")->result();

		$this->load->view("layout/main", $data);
	}

	function save_problem()
	{
		$id				= $this->model->generate_id_problem_solving();
		$problem		= $_POST['problem'];
		$category		= $_POST['category'];
		$priority		= $_POST['priority'];
		$deadline		= $_POST['deadline'];
		$factor			= $_POST['factor'];
		$pic			= $_POST['pic'];
		$created_at		= date("Y-m-d H:i:s");
		$created_by		= $_SESSION['user_id'];

		$det = $this->model->get_detail_user($created_by);

		$company_id		= $det['company_id'];
		$department_id	= $det['department_id'];
		$designation_id	= $det['designation_id'];
		$role_id		= $det['role_id'];
		if (isset($_POST['addition'])) {
			$data = array(
				"id_ps"				=> $id,
				"problem" 			=> $problem,
				"category_id" 		=> $category,
				"priority_id" 		=> $priority,
				"deadline" 			=> $deadline,
				"factor" 			=> $factor,
				"pic" 				=> $pic,
				"status" 			=> 1,
				"company_id" 		=> $company_id,
				"department_id" 	=> $department_id,
				"designation_id" 	=> $designation_id,
				"role_id" 			=> $role_id,
				"created_at" 		=> $created_at,
				"created_by" 		=> $created_by,
				"divisi"         => $_POST['id_project'],
				"so"         => isset($_POST['id_pekerjaan']) ? $_POST['id_pekerjaan'] : '',
				"si"         => isset($_POST['id_sub_pekerjaan']) ? $_POST['id_sub_pekerjaan'] : '',
				"tasklist"         => implode(",", isset($_POST['id_detail_pekerjaan']) ? $_POST['id_detail_pekerjaan'] : '')
			);
		} else {
			$data = array(
				"id_ps"				=> $id,
				"problem" 			=> $problem,
				"category_id" 		=> $category,
				"priority_id" 		=> $priority,
				"deadline" 			=> $deadline,
				"factor" 			=> $factor,
				"pic" 				=> $pic,
				"status" 			=> 1,
				"company_id" 		=> $company_id,
				"department_id" 	=> $department_id,
				"designation_id" 	=> $designation_id,
				"role_id" 			=> $role_id,
				"created_at" 		=> $created_at,
				"created_by" 		=> $created_by
			);
		}

		$result['insert_problem'] = $this->db->insert("ps_task", $data);
		echo json_encode($result);
	}

	function list_problem()
	{
		$start 	= $_POST['start'];
		$end 	= $_POST['end'];

		$result['data'] = $this->model->list_problem($start, $end);
		echo json_encode($result);
	}

	function save_proses_resume()
	{
		$id				= $_POST['id_ps'];
		$status			= $_POST['status_akhir'];
		$resume			= $_POST['resume'];
		$updated_at		= date("Y-m-d H:i:s");
		$updated_by		= $_SESSION['user_id'];

		$data = array(
			"id_ps"				=> $id,
			"status" 			=> $status,
			"resume" 			=> $resume,
			"updated_at" 		=> $updated_at,
			"updated_by" 		=> $updated_by
		);

		$this->db->where("id_ps", $id);
		$result['update_resume'] = $this->db->update("ps_task", $data);

		$history = array(
			"ps_id"				=> $id,
			"status" 			=> $status,
			"resume" 			=> $resume,
			"created_at" 		=> $updated_at,
			"created_by" 		=> $updated_by
		);

		$result['insert_history'] = $this->db->insert("ps_task_history", $history);
		echo json_encode($result);
	}

	function get_detail_problem($id)
	{
		$result = $this->model->get_detail_problem($id);
		echo json_encode($result);
	}

	function get_pekerjaan()
	{
		$divisi = $this->input->post('id_project');
		$divisi = urldecode($divisi);
		$query = "SELECT
		grd_m_so.id_so AS id,
		grd_m_so.so AS pekerjaan,
		CONCAT(grd_m_goal.nama_goal, ' | ',DATE_FORMAT( grd_m_so.created_at, '%b %Y' )) AS periode
	FROM
		`grd_m_so` 
		JOIN grd_m_goal ON grd_m_so.id_goal = grd_m_goal.id_goal
	WHERE
		grd_m_so.divisi = '$divisi'";
		$data = $this->db->query($query)->result();
		echo json_encode($data);
	}

	function get_sub_pekerjaan()
	{
		$pekerjaan = $this->input->post('id_pekerjaan');
		$query = "SELECT id_si AS id, si AS sub_pekerjaan FROM `grd_t_si` WHERE id_so =  $pekerjaan";
		// $data = $this->db->get_where('m_sub_pekerjaan', ['id_pekerjaan' => $pekerjaan])->result();
		$data = $this->db->query($query)->result();
		echo json_encode($data);
	}

	function get_det_pekerjaan()
	{
		$id_sub_pekerjaan = $this->input->post('id_sub_pekerjaan');
		$query = "SELECT id_tasklist AS id, detail FROM `grd_t_tasklist` WHERE id_si = $id_sub_pekerjaan";
		$data = $this->db->query($query)->result();
		// $data = $this->db->query('t_detail_pekerjaan', ['id_sub_pekerjaan' => $id_sub_pekerjaan])->result();

		echo json_encode($data);
	}
}
