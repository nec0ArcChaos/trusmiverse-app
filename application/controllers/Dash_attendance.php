<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dash_attendance extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('Model_dash_attendance', 'model');
		$akses =
			[
				1, //IT
				778, //personalia Bali
				979 //personalia
			];
		if (!$this->session->userdata('user_id') || !in_array($this->session->userdata('user_id'), $akses)) {
			redirect('login', 'refresh');
		}
	}

	public function index()
	{
		$data['pageTitle']        = "Dashboard Attendance";
		$data['css']              = "dash_attendance/css";
		$data['js']               = "dash_attendance/js";
		$data['content']          = "dash_attendance/index";

		$this->load->view('layout/main', $data);
	}


	function dt_dash_attendance_all()
	{
		$start = $this->input->post('start');
		$end = $this->input->post('end');

		$data = $this->model->dash_absen($start, $end);

		if ($data) {
			$response = [
				'status' => true,
				'message' => "data resume absen all",
				'data' => $data
			];
		} else {
			$response = [
				'status' => false,
				'message' => "data resume absen all",
				'data' => null
			];
		}

		header('Content-Type: application/json');

		echo json_encode($response);
	}

	function dt_dash_attendance_dept()
	{
		$start = $this->input->post('start');
		$end = $this->input->post('end');

		$data = $this->model->absen_dept($start, $end);

		if ($data) {
			$response = [
				'status' => true,
				'message' => "data resume absen department",
				'data' => $data
			];
		} else {
			$response = [
				'status' => false,
				'message' => "data resume absen department",
				'data' => null
			];
		}

		header('Content-Type: application/json');

		echo json_encode($response);
	}

	function dt_detail_attendance()
	{
		$start = $this->input->post('start');
		$end = $this->input->post('end');
		$company_id = $this->input->post('company_id');

		$data = $this->model->list_absen_company($company_id, $start, $end)->result();

		if ($data) {
			$response = [
				'status' => true,
				'message' => "data resume absen department",
				'data' => $data
			];
		} else {
			$response = [
				'status' => false,
				'message' => "data resume absen department",
				'data' => $data
			];
		}

		header('Content-Type: application/json');

		echo json_encode($response);
	}

	function dt_detail_dept()
	{
		$start = $this->input->post('start');
		$end = $this->input->post('end');
		$department_id = $this->input->post('department_id');

		$data = $this->model->list_absen_department($department_id, $start, $end)->result();

		if ($data) {
			$response = [
				'status' => true,
				'message' => "data resume absen department",
				'data' => $data
			];
		} else {
			$response = [
				'status' => false,
				'message' => "data resume absen department",
				'data' => $data
			];
		}

		header('Content-Type: application/json');

		echo json_encode($response);
	}
}
