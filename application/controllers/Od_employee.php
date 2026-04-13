<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Od_employee extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('model_od_employee', 'model');
		if ($this->session->userdata('user_id') != "") {

		} else {
			redirect('login','refresh');
		}
	}

	function index()
	{
		$data['pageTitle'] 	= "Report To";
		$data['css'] 		= "od/css_employee";
		$data['js'] 		= "od/js_employee";
		$data['content'] 	= "od/index_employee";
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
