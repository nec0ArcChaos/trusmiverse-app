<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employee extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('model_employee', 'model');
		if ($this->session->userdata('user_id') != "") {

		} else {
			redirect('login','refresh');
		}
	}

	function index()
	{
		$data['pageTitle'] 	= "Report To";
		$data['css'] 		= "employee/css";
		$data['js'] 		= "employee/js";
		$data['content'] 	= "employee/index";
		$data['emp'] = $this->model->list_employees()->result();

		$this->load->view('layout/main', $data);
	}

	function list_employees()
	{
		$data['data'] = $this->model->list_employees()->result();

		echo json_encode($data);
	}

	function update_report_to()
	{
		$this->db->where('user_id', $_POST['user_id']);
		$result = $this->db->update('xin_employees', array('ctm_report_to' => $_POST['report_to']));

		echo json_encode($result);
	}

}
