<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Od_job_profile extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('model_od_job_profile', 'model');
		$this->load->model('model_od_review', 'review');
		if ($this->session->userdata('user_id') != "") {
		} else {
			redirect('login', 'refresh');
		}
	}

	function index()
	{
		$data['pageTitle'] 	= "Job Profile";
		$data['css'] 		= "od/css_job_profile";
		$data['js'] 		= "od/js_job_profile";
		$data['content'] 	= "od/index_job_profile";

		$user = $this->model->data_user($this->session->userdata('user_id'));

		$data['user'] = [];
		foreach ($user as $items) {
			$value = [
				'user_id'       => $this->hashApplicantId($items->user_id),
				'employee_name' => $items->employee,
				'contact_no'    => $items->contact_no
			];
			$data['user'] = $value;
		}

		$data['companies']       = $this->model->get_companies()->result();
		$data['get_departments'] = $this->model->get_departments(0)->result();
		$data['employee']        = $this->model->get_employee_jp();
		$data['golongan']        = $this->model->get_golongan_jp();

		$this->load->view('layout/main', $data);
	}

	function print_($no_jp, $level)
	{
		$data['jp']       = $this->model->data_jp(null, null, null, $no_jp)->row_array();
		$data['jt']       = $this->model->get_job_task($no_jp);
		$data['kpi']      = $this->model->get_kpi($no_jp);
		$data['internal'] = $this->model->get_internal($no_jp);
		$data['external'] = $this->model->get_external($no_jp);
		$this->load->view('od/print_job_profile', $data);
	}

	public function hashApplicantId($applicant_id)
	{
		$arr_applicant_id = str_split($applicant_id, 1);
		$hash = $this->generateRandomString();
		for ($i = 0; $i < COUNT($arr_applicant_id); $i++) {
			$hash .= $arr_applicant_id[$i];
			$hash .= $this->generateRandomString();
		}
		return $hash;
	}

	function generateRandomString($length = 2)
	{
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[random_int(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	function get_review($no_jp)
	{
		$data['data'] = $this->review->get_review($no_jp);
		echo json_encode($data);
	}

	function get_pic($id)
	{
		$user = $this->model->get_pic($id);
		$data = [];
		foreach ($user as $items) {
			$value = [
				'user_id'       => $this->hashApplicantId($items->user_id),
				'employee_name' => $items->employee_name,
				'contact_no'    => $items->contact_no
			];
			$data[] = $value;
		}
		echo json_encode($data);
	}

	function get_employees($company_id)
	{
		$data = $this->model->get_employees($company_id)->result();
		echo json_encode($data);
	}

	function get_departments($company_id)
	{
		$data = $this->model->get_departments($company_id)->result();
		echo json_encode($data);
	}

	function get_designations($department_id)
	{
		$data = $this->model->get_designations($department_id)->result();
		echo json_encode($data);
	}

	function get_no_doc()
	{
		$doc_type_id   = $_POST['doc_type_id'];
		$div_id        = $_POST['div_id'];
		$company_id    = $_POST['company_id'];
		$department_id = $_POST['department_id'];
		$no_doc = $this->model->get_no_doc($doc_type_id, $div_id, $company_id, $department_id);
		$max_no_doc = $this->model->max_no_doc($department_id);

		if (isset($no_doc)) {
			foreach ($no_doc as $row) {
				$no_dok = $row->no_doc . $max_no_doc;
			}
		}
		echo json_encode($no_dok);
	}

	function insert_job_profile()
	{
		$data['insert_jp'] = $this->model->insert_job_profile();
		echo json_encode($data);
	}

	function update_job_profile()
	{
		$data['update_jp'] = $this->model->update_job_profile();
		echo json_encode($data);
	}

	function data_jp($start, $end, $department_id)
	{
		$data['data'] = $this->model->data_jp($start, $end, $department_id)->result();
		echo json_encode($data);
	}

	function get_jp()
	{
		$no_jp = $_POST['no_jp'];
		$data = $this->model->data_jp(null, null, null, $no_jp)->result();
		echo json_encode($data);
	}

	function delete_jp()
	{
		$data['delete_jp'] = $this->model->delete_jp();
		echo json_encode($data);
	}

	function add_responsibility()
	{
		$data['add_responsibility'] = $this->model->add_responsibility();
		echo json_encode($data);
	}

	function get_job_task($no_jp)
	{
		$data['data'] = $this->model->get_job_task($no_jp);
		echo json_encode($data);
	}

	function delete_job_task()
	{
		$data['delete_job_task'] = $this->model->delete_job_task();
		echo json_encode($data);
	}

	function add_kpi()
	{
		$data['add_kpi'] = $this->model->add_kpi();
		echo json_encode($data);
	}

	function get_kpi($no_jp)
	{
		$data['data'] = $this->model->get_kpi($no_jp);
		echo json_encode($data);
	}

	function delete_kpi()
	{
		$data['delete_kpi'] = $this->model->delete_kpi();
		echo json_encode($data);
	}

	function add_internal()
	{
		$data['add_internal'] = $this->model->add_internal();
		echo json_encode($data);
	}

	function get_internal($no_jp)
	{
		$data['data'] = $this->model->get_internal($no_jp);
		echo json_encode($data);
	}

	function delete_internal()
	{
		$data['delete_internal'] = $this->model->delete_internal();
		echo json_encode($data);
	}

	function add_external()
	{
		$data['add_external'] = $this->model->add_external();
		echo json_encode($data);
	}

	function get_external($no_jp)
	{
		$data['data'] = $this->model->get_external($no_jp);
		echo json_encode($data);
	}

	function delete_external()
	{
		$data['delete_external'] = $this->model->delete_external();
		echo json_encode($data);
	}
}
