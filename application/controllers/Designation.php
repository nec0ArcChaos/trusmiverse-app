<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Designation extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('model_designation', 'model');
		if ($this->session->userdata('user_id') != "") {

		} else {
			redirect('login','refresh');
		}
	}

	function index()
	{
		$data['pageTitle'] 	= "Designation";
		$data['css'] 		= "od/css_designation";
		$data['js'] 		= "od/js_designation";
		$data['content'] 	= "od/index_designation";

		$data['companies'] = $this->model->get_companies()->result();

		$this->load->view('layout/main', $data);
	}

	function get_department($company_id, $department_id = null)
	{
		$data = $this->model->get_department($company_id)->result();

		if (isset($department_id)) {
			foreach ($data as $row) {
				$select = ($row->department_id == $department_id) ? "selected" : "" ;
				echo '<option value="'.$row->department_id.'" '.$select.'>'.$row->department_name.'</option>';
			}
		} else {
			echo '<option value="" selected>-- Select Department --</option>';

			foreach ($data as $row) {
				echo '<option value="'.$row->department_id.'">'.$row->department_name.'</option>';
			}
		}

	}

	function get_designation($department_id, $designation_id = null)
	{
		$data = $this->model->get_designation($department_id)->result();

		if (isset($designation_id)) {
			foreach ($data as $row) {
				$select = ($row->designation_id == $designation_id) ? "selected" : "" ;
				echo '<option value="'.$row->designation_id.'" '.$select.'>'.$row->designation_name.'</option>';
			}
		} else {
			echo '<option value="" selected>-- Select Designation --</option>';

			foreach ($data as $row) {
				echo '<option value="'.$row->designation_id.'">'.$row->designation_name.'</option>';
			}
		}
	}

	function list_designation()
	{
		$data['data'] = $this->model->list_designation()->result();

		echo json_encode($data);
	}

	function add_designation()
	{
		$designation = array(
			"department_id"			=> $_POST['department_id'],
			"company_id"			=> $_POST['company_id'],
			"designation_name"		=> $_POST['designation_name'],
			"added_by"				=> $this->session->userdata('user_id'),
			"created_at"			=> date('d-m-Y'),
			"report_to"				=> $_POST['report_to'],
			"sub_department_id"		=> 0,
			"top_designation_id"	=> 1,
			"status"				=> 1,
		);

		$data['add'] = $this->db->insert('xin_designations', $designation);

		echo json_encode($data);
	}

	function update_designation()
	{
		$designation = array(
			"department_id"			=> $_POST['department_id'],
			"company_id"			=> $_POST['company_id'],
			"designation_name"		=> $_POST['designation_name'],
			"report_to"				=> $_POST['report_to'],
		);

		$this->db->where('designation_id', $_POST['designation_id']);
		$data['update'] = $this->db->update('xin_designations', $designation);

		echo json_encode($data);
	}

	function delete_designation()
	{
		$this->db->where('designation_id', $_POST['designation_id']);
		$data['delete'] = $this->db->delete('xin_designations');

		echo json_encode($data);
	}

}
