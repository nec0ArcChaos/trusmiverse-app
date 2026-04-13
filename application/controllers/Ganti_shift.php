<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Ganti_shift extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('Model_ganti_shift', 'model');
		$akses =
			[
				1, //super user
				2, //head
				3, //manager
				4, //Assistent Manager
				5 //Supervisor
			];

		if (!$this->session->userdata('user_id') || !in_array($this->session->userdata('user_role_id'), $akses)) {
			redirect('login', 'refresh');
		}
	}

	public function index()
	{
		$data['pageTitle']        = "Ganti Shift";
		$data['css']              = "ganti_shift/css";
		$data['js']               = "ganti_shift/js";
		$data['content']          = "ganti_shift/index";
		$data['shift'] = $this->model->get_shift()->result();

		$this->load->view('layout/main', $data);
	}

	function data_shift()
	{

		$data = $this->model->data_shift()->result();

		echo json_encode([
			'status' => true,
			'message' => 'Data employees',
			'data' => $data
		]);
	}

	public function update_shift()
	{
		$shift = $this->input->post('shift');
		$user_id = $this->input->post('user_id');
		// var_dump($shift);
		// die();

		$data = array('office_shift_id' => $shift);
		$this->db->where('user_id', $user_id);
		$update = $this->db->update('xin_employees', $data);

		if ($update) {
			$response = [
				'status' => true,
				'message' => "update success"
			];
		} else {
			$response = [
				'status' => false,
				'message' => "update fail"
			];
		}

		echo json_encode($response);
	}
}
