<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Lock extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		// $this->load->model('model1');
		$this->load->model('eaf/model_lock', 'model_lock');
		$this->load->library("session");
		$this->load->library('FormatJson');
		if ($this->session->userdata('user_id') != "") {
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
			$data['content'] 	= "eaf/lock/index";
			$data['pageTitle'] 	= "Lock EAF";
			$data['css'] 		= "eaf/lock/css";
			$data['js'] 		= "eaf/lock/js";
			$this->load->view("layout/main", $data);
		} else {
			redirect("login");
		}
	}

	function get_list_eaf_lock_apv()
	{
		$id_user 	= $this->session->userdata('user_id');
		

		$data = $this->model_lock->get_list_eaf_lock_apv($id_user);
		echo json_encode($data);
	}

	function get_list_eaf_lock_verif()
	{
		$id_user 	= $this->session->userdata('user_id');
		

		$data = $this->model_lock->get_list_eaf_lock_verif($id_user);
		echo json_encode($data);
	}

	function get_list_eaf_lock_lpj1()
	{
		$id_user 	= $this->session->userdata('user_id');
		

		$data = $this->model_lock->get_list_eaf_lock_lpj1($id_user);
		echo json_encode($data);
	}

	function get_list_eaf_lock_lpj2()
	{
		$id_user 	= $this->session->userdata('user_id');
		

		$data = $this->model_lock->get_list_eaf_lock_lpj2($id_user);
		echo json_encode($data);
	}

	
}
