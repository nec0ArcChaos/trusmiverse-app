<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Department extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('model_department', 'model');
		if ($this->session->userdata('user_id') != "") {
			
		} else {
			redirect('login','refresh');
		}
	}

	function index()
	{
		$data['pageTitle'] 	= "Department";
		$data['css'] 		= "department/css";
		$data['js'] 		= "department/js";
		$data['content'] 	= "department/index";

		// $user_id  = $this->session->userdata("user_id");

		$data['companies'] = $this->model->get_companies()->result(); 
		$data['department_head'] = $this->model->get_department_head()->result(); 

		$this->load->view('layout/main', $data);
	}

	function get_location($company_id, $location_id = null)
	{
		$data = $this->model->get_location($company_id)->result();

		if (isset($location_id)) {
			foreach ($data as $row) {
				$select = ($row->location_id == $location_id) ? "selected" : "" ;
				echo '<option value="'.$row->location_id.'" '.$select.'>'.$row->location_name.'</option>';
			}
		} else {
			echo '<option value="" selected>- Select Location -</option>';

			foreach ($data as $row) {
				echo '<option value="'.$row->location_id.'">'.$row->location_name.'</option>';
			}
		}
		
	}

	// function get_department($department_id, $department_id = null)
	// {
	// 	$data = $this->model->get_department($department_id)->result();


	// 	if (isset($department_id)) {
	// 		foreach ($data as $row) {
	// 			$select = ($row->department_id == $department_id) ? "selected" : "" ;
	// 			echo '<option value="'.$row->department_id.'" '.$select.'>'.$row->department_name.'</option>';
	// 		}
	// 	} else {
	// 		echo '<option value="" selected>-- Select Department --</option>';

	// 		foreach ($data as $row) {
	// 			echo '<option value="'.$row->department_id.'">'.$row->department_name.'</option>';
	// 		}
	// 	}
	// }

	function list_department()
	{
		$data['data'] = $this->model->list_department()->result();

		echo json_encode($data);
	}

	function add_department()
	{
		$department = array(
			"department_name"		=> $_POST['department_name'],
			"company_id"			=> $_POST['company_id'],
			"location_id"			=> $_POST['location_id'],
			"employee_id"			=> $_POST['head_id'],
			"added_by"				=> $this->session->userdata('user_id'),
			"created_at"			=> date('Y-m-d H:i:s'),
			"status"				=> 1,
			"break"					=> $_POST['break'],
			"kode"					=> $_POST['department_kode']
		);

		$data['add'] = $this->db->insert('xin_departments', $department);

		echo json_encode($data);
	}

	function update_department()
	{
		$department = array(
			"department_name"		=> $_POST['department_name'],
			"company_id"			=> $_POST['company_id'],
			"location_id"			=> $_POST['location_id'],
			"employee_id"			=> $_POST['head_id'],
			"added_by"				=> $this->session->userdata('user_id'),
			"created_at"			=> date('Y-m-d H:i:s'),
			"break"					=> $_POST['break'],
			"kode"					=> $_POST['department_kode']
		);

		$this->db->where('department_id', $_POST['department_id']);
		$data['update'] = $this->db->update('xin_departments', $department);

		echo json_encode($data);
	}

	function delete_department()
	{
		$this->db->where('department_id', $_POST['department_id']);
		$data['delete'] = $this->db->delete('xin_departments');

		echo json_encode($data);
	}

}

/* End of file Landing.php */
/* Location: ./application/controllers/Landing.php */