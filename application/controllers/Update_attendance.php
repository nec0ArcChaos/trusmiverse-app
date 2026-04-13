<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Update_attendance extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('Model_update_attendance', 'model');
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
		$data['pageTitle']        = "T - Attendance";
		$data['css']              = "update_attendance/css";
		$data['js']               = "update_attendance/js";
		$data['content']          = "update_attendance/index";
		$data['get_company']  = $this->model->get_company()->result();

		$this->load->view('layout/main', $data);
	}


	function dt_attendance()
	{
		$employee_id    = (isset($_POST['employee_id'])) ? $_POST['employee_id'] : NULL;
		$date          = $_POST['date'];

		$response['data']       = $this->model->dt_attendance($date, $employee_id);

		echo json_encode($response);
	}

	public function update_attendance()
	{
		$allowed_users =
			[
				1, //IT
				778, //personalia Bali
				979 //personalia
			];
		$user_id = $this->session->userdata('user_id');

		if (!in_array($user_id, $allowed_users)) {
			echo json_encode([
				'status' => false,
				'message' => 'Anda tidak memiliki akses.',
				'data' => null
			]);
			return;
		}

		$type = $this->input->post('type');

		if ($type === 'update') {
			$id = $this->input->post('time_attendance_id');
			$employee_id = $this->input->post('employee_id');
			$attendance_date = $this->input->post('attendance_date_e');
			$clock_in = $this->input->post('clock_in');
			$clock_out = $this->input->post('clock_out');

			// Validasi
			if (empty($id)) {
				echo json_encode([
					'status' => false,
					'message' => 'ID wajib dikirim untuk update.',
					'data' => null
				]);
				return;
			}

			if (empty($attendance_date)) {
				echo json_encode([
					'status' => false,
					'message' => 'Tanggal kehadiran wajib diisi.',
					'data' => null
				]);
				return;
			}

			if (empty($clock_in)) {
				echo json_encode([
					'status' => false,
					'message' => 'Jam masuk wajib diisi.',
					'data' => null
				]);
				return;
			}

			$clock_in_full = $attendance_date . ' ' . $clock_in . ':00';

			$data = [
				'employee_id' => $employee_id,
				'attendance_date' => $attendance_date,
				'clock_in' => $clock_in_full,
				'time_late' => '0:0',
				'early_leaving' => '0:0',
				'attendance_status' => 'Present',
				'clock_in_out' => '0'
			];

			if (!empty($clock_out)) {
				$clock_out_full = $attendance_date . ' ' . $clock_out . ':00';

				$start = new DateTime($clock_in_full);
				$end = new DateTime($clock_out_full);
				$interval = $end->diff($start);
				$total_work = $interval->format('%h:%i');

				$data['clock_out'] = $clock_out_full;
				$data['overtime'] = $clock_out_full;
				$data['total_work'] = $total_work;
			} else {

				// jika clock_out kosong maka
				$data['clock_out'] = null;
				$data['overtime'] = null;
				$data['total_work'] = null;
			}

			$this->db->where('time_attendance_id', $id);
			$update = $this->db->update('xin_attendance_time', $data);

			$response = $update ? [
				'status' => true,
				'message' => 'Data kehadiran berhasil diperbarui.',
				'data' => $data
			] : [
				'status' => false,
				'message' => 'Gagal memperbarui data.',
				'data' => null
			];

			echo json_encode($response);
			return;
		} elseif ($type === 'add') {
			$attendance_date = $this->input->post('attendance_date_e');
			$clock_in = $this->input->post('clock_in');
			$employee_id = $this->input->post('employee_id');
			$clock_out = $this->input->post('clock_out');

			if (empty($attendance_date) || empty($clock_in) || empty($employee_id)) {
				echo json_encode([
					'status' => false,
					'message' => 'Field wajib tidak lengkap (tanggal, jam masuk, atau karyawan).',
					'data' => null
				]);
				return;
			}

			$clock_in_full = $attendance_date . ' ' . $clock_in . ':00';

			$data = [
				'employee_id' => $employee_id,
				'attendance_date' => $attendance_date,
				'clock_in' => $clock_in_full,
				'attendance_status' => 'Present',
				'clock_in_out' => '0'
			];

			if (!empty($clock_out)) {
				$clock_out_full = $attendance_date . ' ' . $clock_out . ':00';

				$start = new DateTime($clock_in_full);
				$end = new DateTime($clock_out_full);
				$interval = $end->diff($start);
				$total_work = $interval->format('%h:%i');

				$data['clock_out'] = $clock_out_full;
				$data['overtime'] = $clock_out_full;
				$data['total_work'] = $total_work;
			}

			$insert = $this->db->insert('xin_attendance_time', $data);

			$response = $insert ? [
				'status' => true,
				'message' => 'Data kehadiran berhasil ditambahkan.',
				'data' => $data
			] : [
				'status' => false,
				'message' => 'Gagal menambahkan data.',
				'data' => null
			];

			echo json_encode($response);
			return;
		} else {
			echo json_encode([
				'status' => false,
				'message' => 'Tipe operasi tidak valid (harus add atau update).',
				'data' => null
			]);
			return;
		}
	}

	public function get_attendance_by_id()
	{
		$id = $this->input->post('id');

		if (empty($id)) {
			echo json_encode([
				'status' => false,
				'message' => 'ID wajib dikirim.',
				'data' => null
			]);
			return;
		}

		$this->db->select('attendance_date, clock_in, clock_out');
		$this->db->from('xin_attendance_time');
		$this->db->where('time_attendance_id', $id);
		$query = $this->db->get();

		if ($query->num_rows() === 0) {
			echo json_encode([
				'status' => false,
				'message' => 'Data tidak ditemukan.',
				'data' => null
			]);
			return;
		}

		$row = $query->row();

		$data = [
			'attendance_date' => $row->attendance_date,
			'clock_in' => !empty($row->clock_in) ? date('H:i', strtotime($row->clock_in)) : null,
			'clock_out' => !empty($row->clock_out) ? date('H:i', strtotime($row->clock_out)) : null,
		];

		echo json_encode([
			'status' => true,
			'message' => 'Data ditemukan.',
			'data' => $data
		]);
	}

	function get_department()
	{
		$company_id = $this->input->post('company_id');

		$data = $this->model->get_department($company_id)->result();

		echo json_encode([
			'status' => true,
			'message' => 'Data employees',
			'data' => $data
		]);
	}

	function get_employees()
	{
		$company_id = $this->input->post('company_id');
		$department_id = $this->input->post('department_id');

		$data = $this->model->get_employees($company_id, $department_id)->result();

		echo json_encode([
			'status' => true,
			'message' => 'Data employees',
			'data' => $data
		]);
	}

	public function delete_attendance()
	{
		$id = $this->input->post('id');

		if (empty($id)) {
			echo json_encode([
				'status' => false,
				'message' => 'ID tidak ditemukan.',
				'data' => null
			]);
			return;
		}

		$this->db->where('time_attendance_id', $id);
		$delete = $this->db->delete('xin_attendance_time');

		if ($delete) {
			echo json_encode([
				'status' => true,
				'message' => 'Data berhasil dihapus.',
				'data' => null
			]);
		} else {
			echo json_encode([
				'status' => false,
				'message' => 'Gagal menghapus data.',
				'data' => null
			]);
		}
	}
}
