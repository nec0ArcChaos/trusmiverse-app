<?php
// Trusmi History Lock Absen
// Created At : 12-05-2023
defined('BASEPATH') or exit('No direct script access allowed');
class Attendance extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('Model_attendance', 'model');
		if ($this->session->userdata('user_id') != "") {
		} else {
			redirect('login', 'refresh');
		}
		//  User IT
		//  61 Anggi
		//  62 Lutfi
		//  63 Said
		//  64 Lutfiedadi
		//  1161 Fujiyanto
		//  2041 Faisal
		//  2063 Aris
		//  2070 Kania
		//  2969 Ari Fadzri
		// $user_it = array(1, 61, 62, 63, 64, 1161, 2041, 2063, 2969, 2969, 2070);
		// if (in_array($this->session->userdata('user_id'), $user_it)) {
		// } else {
		//     $this->session->set_flashdata('no_access', 1);
		//     redirect('dashboard', 'refresh');
		// }
	}

	public function index()
	{
		$data['pageTitle']        = "T - Attendance";
		$data['css']              = "attendance/css";
		$data['js']               = "attendance/js";
		$data['content']          = "attendance/index";

		$data['start']      = date("Y-m-21", strtotime("-1 month", strtotime(date('Y-m-d'))));
		$data['end']        = date("Y-m-20");

		$data['tanggal_periode']  = $this->model->tanggal_periode(1, 2)->result();
		$data['get_company']  = $this->model->get_company()->result();

		$this->load->view('layout/main', $data);
	}


	function dt_attendance()
	{
		$company_id     = (isset($_POST['company_id'])) ? $_POST['company_id'] : NULL;
		$department_id  = (isset($_POST['department_id'])) ? $_POST['department_id'] : NULL;
		$employee_id    = (isset($_POST['employee_id'])) ? $_POST['employee_id'] : NULL;
		$start          = $_POST['start'];
		$end            = $_POST['end'];

		$data['data']       = $this->model->dt_attendance($company_id, $department_id, $employee_id, $start, $end);
		echo json_encode($data);
	}


	function dt_pembatalan_absensi()
	{
		$company_id     = (isset($_POST['company_id'])) ? $_POST['company_id'] : NULL;
		$department_id  = (isset($_POST['department_id'])) ? $_POST['department_id'] : NULL;
		$employee_id    = (isset($_POST['employee_id'])) ? $_POST['employee_id'] : NULL;
		$start          = $_POST['start'];
		$end            = $_POST['end'];

		$data['data']	= $this->model->dt_pembatalan_absensi($company_id, $department_id, $employee_id, $start, $end);
		echo json_encode($data);
	}


	function hapus_absen()
	{

		$time_attendance_id	= $this->input->post('time_attendance_id');
		$delete_by       	= $_SESSION['user_id'];
		$delete_at       	= date('Y-m-d H:i:s');

		$query = "SELECT
					hris.xin_attendance_time.time_attendance_id,
					hris.xin_attendance_time.employee_id,
					hris.xin_attendance_time.attendance_date,
					hris.xin_attendance_time.clock_in,
					hris.xin_attendance_time.photo_in,
					hris.xin_attendance_time.clock_in_ip_address,
					hris.xin_attendance_time.clock_out,
					hris.xin_attendance_time.photo_out,
					hris.xin_attendance_time.clock_out_ip_address,
					hris.xin_attendance_time.clock_in_out,
					hris.xin_attendance_time.clock_in_latitude,
					hris.xin_attendance_time.clock_in_longitude,
					hris.xin_attendance_time.clock_out_latitude,
					hris.xin_attendance_time.clock_out_longitude,
					hris.xin_attendance_time.time_late,
					hris.xin_attendance_time.early_leaving,
					hris.xin_attendance_time.overtime,
					hris.xin_attendance_time.total_work,
					hris.xin_attendance_time.total_rest,
					hris.xin_attendance_time.attendance_status,
					hris.xin_attendance_time.shift_in,
					hris.xin_attendance_time.shift_out,
					hris.xin_attendance_time.system_in,
					hris.xin_attendance_time.system_out 
				FROM
					hris.xin_attendance_time
				WHERE hris.xin_attendance_time.time_attendance_id = $time_attendance_id";

		$data_absen = $this->db->query($query)->result();

		foreach ($data_absen as $da) {
			$insert_absen = array(
				'time_attendance_id'	=> $da->time_attendance_id,
				'employee_id'			=> $da->employee_id,
				'attendance_date'		=> $da->attendance_date,
				'clock_in'				=> $da->clock_in,
				'photo_in'				=> $da->photo_in,
				'clock_in_ip_address'	=> $da->clock_in_ip_address,
				'clock_out'				=> $da->clock_out,
				'photo_out'				=> $da->photo_out,
				'clock_out_ip_address'	=> $da->clock_out_ip_address,
				'clock_in_out'			=> $da->clock_in_out,
				'clock_in_latitude'		=> $da->clock_in_latitude,
				'clock_in_longitude'	=> $da->clock_in_longitude,
				'clock_out_latitude'	=> $da->clock_out_latitude,
				'clock_out_longitude'	=> $da->clock_out_longitude,
				'time_late'				=> $da->time_late,
				'early_leaving'			=> $da->early_leaving,
				'overtime'				=> $da->overtime,
				'total_work'			=> $da->total_work,
				'total_rest'			=> $da->total_rest,
				'attendance_status'		=> $da->attendance_status,
				'shift_in'				=> $da->shift_in,
				'shift_out'				=> $da->shift_out,
				'system_in'				=> $da->system_in,
				'system_out'			=> $da->system_out,
				'delete_by'				=> $delete_by,
				'delete_at'				=> $delete_at
			);

			$data['data'] = $this->db->insert('hris.xin_attendance_delete', $insert_absen);
		}

		$this->db->where('time_attendance_id', $time_attendance_id);
		$data['data'] = $this->db->delete('hris.xin_attendance_time');

		echo json_encode($data);
	}

	function updateAbsen()
	{


		if (!isset($_REQUEST['employee_id'])) {
			echo json_encode(['status' => false, 'message' => 'Employee ID is required']);
			return;
		}


		$attendance_date = date('Y-m-d');


		$update_data = [
			'employee_id' => $_REQUEST['employee_id'],
			'attendance_date' => $attendance_date
		];


		if (isset($_REQUEST['clock_in']) && !empty($_REQUEST['clock_in'])) {
			$update_data['clock_in'] = $attendance_date . ' ' . $_REQUEST['clock_in'] . ':00';
		}


		if (isset($_REQUEST['clock_out']) && !empty($_REQUEST['clock_out'])) {
			$update_data['clock_out'] = $attendance_date . ' ' . $_REQUEST['clock_out'] . ':00';
		}


		$optional_fields = [
			'photo_in',
			'photo_out'
		];

		foreach ($optional_fields as $field) {
			if (isset($_REQUEST[$field]) && !empty($_REQUEST[$field])) {
				$update_data[$field] = $_REQUEST[$field];
			}
		}


		$this->db->where('employee_id', $_REQUEST['employee_id'])
			->where('attendance_date', $attendance_date)
			->update('hris.xin_attendance_time', $update_data);


		$affected_rows = $this->db->affected_rows();
		$response = [
			'status' => ($affected_rows > 0),
			'message' => ($affected_rows > 0) ? 'Update successful' : 'No records updated',
			'data' => $update_data
		];

		echo json_encode($response);
	}
}
