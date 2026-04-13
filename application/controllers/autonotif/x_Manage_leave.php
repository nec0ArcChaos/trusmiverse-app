<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_leave extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");
		$this->load->model('./autonotif/Model_manage_leave', 'model');
        if ($this->session->userdata('user_id') != "") { } else {
			redirect('login', 'refresh');
        }
	}

	function index()
	{
		$data['content'] 	= "trusmi_lock/index";
		$data['pageTitle'] 	= "T-Lock";
		$data['css'] 		= "trusmi_lock/css";
		$data['js'] 		= "trusmi_lock/js";
		$data['karyawan']	= $this->model->get_employee();

		$this->load->view("layout/main", $data);
	}

	function get_lock_absen()
	{
		$start 				= $_POST['datestart'];
		$end 				= $_POST['dateend'];
		$result['data']   	= $this->model->get_lock_absen($start, $end);
		echo json_encode($result);
	}

	function save_lock()
	{
		$user_id 		= $this->session->userdata('user_id');
		$type_lock		= $_POST['lock_type'];
		$user 			= explode(",",$_POST['user']);
		$alasan			= $_POST['alasan'];
		$created_at		= date("Y-m-d H:i:s");
		$user_locked 	= $this->session->userdata('nama');

		if (isset($user)) {
			foreach ($user as $key => $value) {
				$data = array (
					"type_lock" 	=> $type_lock,
					"employee_id" 	=> $value,
					"alasan_lock" 	=> $alasan." - By ".$user_locked,
					"status" 		=> 1,
					"created_at" 	=> $created_at,
					"created_by" 	=> $user_id
				);

				$result['data'] = $data;
				$result['insert_lock'] = $this->db->insert("trusmi_lock_absen_manual", $data);
			}
		}
		echo json_encode($result);
	}

	function update_lock()
	{		
		$id 		= $_POST['e_id'];
		$updated_at = date('Y-m-d H:i:s');
		$updated_by	= $this->session->userdata('user_id');

		$data = array (
			"status" 		=> 0,
			"updated_at" 	=> $updated_at,
			"updated_by" 	=> $updated_by
		);

		$this->db->where('id', $id);
		$result['update_lock'] = $this->db->update("trusmi_lock_absen_manual", $data);
		echo json_encode($result);
	}
}
