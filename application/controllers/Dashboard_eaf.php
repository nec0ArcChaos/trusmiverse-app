<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_eaf extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		// $this->load->model('model1');
		$this->load->model('Model_auth', 'auth');
		$this->load->model('eaf/model_dashboard_eaf', 'model_dashboard');
		$this->load->library("session");
		$this->load->library('FormatJson');
		// if ($this->session->userdata('user_id') != "") {
		// } else {
		// 	redirect('login', 'refresh');
		// }

		if ($this->session->userdata('user_id') != "") {
			$user_id = $this->session->userdata('user_id');
			$check_hak_akses = $this->auth->check_hak_akses('eaf/pengajuan', $user_id);
			if ($check_hak_akses != 'allowed') {
				redirect('forbidden_access', 'refresh');
			}
		} else {
			redirect('login', 'refresh');
		}

		//cek login
		// $username = $this->session->userdata("username");
		// $password = $this->session->userdata("password");
		// $id_user  = $this->session->userdata("id_user");

		// $cek_auth = $this->model1->cek_auth($username, $password);

		// if ($cek_auth > 0) {
		// 	//cek hak navigasi
		// 	$access 	= 22;
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
			$data['content'] 	= "eaf/Dashboard_eaf/index";
			$data['pageTitle'] 	= "Dashboard EAF";
			$data['css'] 		= "eaf/Dashboard_eaf/css";
			$data['js'] 		= "eaf/Dashboard_eaf/js";

			// $data['pengaju'] 		=  $this->model_dashboard->get_pengaju()->result();
			// $data['kategori'] 		=  $this->model_dashboard->get_kategori()->result();
			// // $data['jenis_biaya'] 	=  $this->model_dashboard->jenis_biaya()->result();
			// $data['company'] 	=  $this->model_dashboard->get_company()->result();
			// $data['tipe'] 			=  1;
			// $data['project'] 		=  $this->model_dashboard->get_project();

			$this->load->view("layout/main", $data);
		} else {
			redirect("login");
		}
	}


}
