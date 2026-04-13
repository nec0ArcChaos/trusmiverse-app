<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Report_tkb extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		// $this->load->model('model1');
		$this->load->model('eaf/model_report_tkb', 'model_report');
		$this->load->library("session");
		$this->load->library('FormatJson');

		//cek login
		$username = $this->session->userdata("username");
		$password = $this->session->userdata("password");
		$id_user  = $this->session->userdata("user_id");

		$user_id			= $this->session->userdata('user_id');
		if (isset($user_id)) {
			// 		//do nothing
		} else {
			redirect("login");
		}
	}

	function index()
	{
		$data['content'] 		= "eaf/report_tkb/index";
		$data['pageTitle'] 	= "Report Budget TKB";
		$data['css'] 		= "eaf/report_tkb/css";
		$data['js'] 		= "eaf/report_tkb/js";
		$this->load->view("layout/main", $data);
	}

	function detail_budget()
	{
		$y = $_POST['year'];
		$m = $_POST['month'];
		$data['data'] = $this->model_report->detail_budget($y, $m)->result();
		echo json_encode($data);
	}
}
