<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Budget extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->model('eaf/model_budget', 'model_budget');
		$this->load->model('eaf/model_master_jenis_biaya', 'model_master_jenis_biaya');
		$this->load->library("session");
		$this->load->library('FormatJson');

		//cek login

		if ($this->session->userdata('user_id') != "") {
			$user_id = $this->session->userdata('user_id');			
		} else {
			redirect('login', 'refresh');
		}


		// $username = $this->session->userdata("username");
		// $password = $this->session->userdata("password");
		// $id_user  = $this->session->userdata("id_user");

		// if ($cek_auth > 0) {
		// 	//cek hak navigasi
		// 	$access 	= 14;
		// 	$cek_status = $this->model1->cek_status_navigasi($id_user, $access);

		// 	if ($cek_status == '0') {
		// 		redirect("access_denied");
		// 	} else {
		// 		//do nothing
		// 	}
		// } else {
		// 	redirect("login");
		// }
		
	}

	function index()
	{
		$user_id			= $this->session->userdata('user_id');
		if (isset($user_id)) {

			$data['content'] 			= "eaf/budget/index";
			$data['pageTitle'] 		= "Budget";
			$data['css'] 			= "eaf/budget/css";
			$data['js'] 			= "eaf/budget/js";
			// $data['budget']			= $this->model_budget->budget();
			$data['sisa']			= $this->model_budget->get_last_budget();
			$data['company']			= $this->model_master_jenis_biaya->get_company();

			// $data['level_approve'] 	= $this->session->userdata("id_user_approval");

			$this->load->view("layout/main", $data);
		} else {
			redirect("login");
		}
	}

	function data_budget_list()
	{
		$company_id = $_POST['company_id'];

		$data = $this->model_budget->data_budget_list($company_id)->result();
		echo json_encode($data);
	}

	function data_budget()
	{
		$y = $_POST['year'];
		$m = $_POST['month'];

		$data['data'] = $this->model_budget->data_budget($y, $m)->result();
		echo json_encode($data);
	}

	function data_budget_tambah()
	{
		$id_biayaa_s = $this->input->post('id_biayaa_s');
		$bulan_s = $this->input->post('bulan_s');
		$tahun_s = $this->input->post('tahun_s');
		$sisa_budget_s = $this->input->post('sisa_budget_s');
		$data = $this->model_budget->data_budget_tambah($id_biayaa_s, $bulan_s, $tahun_s, $sisa_budget_s);
		echo json_encode($data);
	}

	function insert()
	{
		$data = $this->model_budget->insert_budget();
		echo json_encode($data);
	}

	function insert_penambahan()
	{
		$data = $this->model_budget->insert_penambahan();
		echo json_encode($data);
	}

	function last_budget()
	{
		$data = $this->model_budget->get_last_budget();
		echo json_encode($data);
	}
}
