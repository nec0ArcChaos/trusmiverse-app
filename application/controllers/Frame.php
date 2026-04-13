<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Frame extends CI_Controller
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
		$data['content'] 			= "frame/index";
		$data['pageTitle'] 			= "Frame";
		$data['css'] 				= "frame/css";
		$data['js'] 				= "frame/js";
		$this->load->view("layout/main", $data);
	}
}
