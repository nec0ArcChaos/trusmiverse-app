<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Office_shift extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('Model_office_shift', 'model');
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
		$data['pageTitle']        = "Office Shift";
		$data['css']              = "office_shift/css";
		$data['js']               = "office_shift/js";
		$data['content']          = "office_shift/index";
		$data['shift'] = $this->model->get_shift()->result();
		$data['companies'] = $this->db->select('company_id,`name` AS company')->from('xin_companies')->get()->result();

		$this->load->view('layout/main', $data);
	}

	function data_shift_office()
	{

		$data = $this->model->get_office_shifts();

		echo json_encode([
			'status' => true,
			'message' => 'Data shift office',
			'data' => $data
		]);
	}

	function get_shift($id)
	{
		$data = $this->db->select('*')->from('xin_office_shift')->where('office_shift_id', $id)->get()->row();

		echo json_encode($data);
	}

	public function update_shift($id)
	{

		$data = array(
			'shift_name' => $this->input->post('shift_name'),
			'company_id' => $this->input->post('company_id'),
			'monday_in_time' => $this->input->post('monday_in_time'),
			'monday_out_time' => $this->input->post('monday_out_time'),
			'tuesday_in_time' => $this->input->post('tuesday_in_time'),
			'tuesday_out_time' => $this->input->post('tuesday_out_time'),
			'wednesday_in_time' => $this->input->post('wednesday_in_time'),
			'wednesday_out_time' => $this->input->post('wednesday_out_time'),
			'thursday_in_time' => $this->input->post('thursday_in_time'),
			'thursday_out_time' => $this->input->post('thursday_out_time'),
			'friday_in_time' => $this->input->post('friday_in_time'),
			'friday_out_time' => $this->input->post('friday_out_time'),
			'saturday_in_time' => $this->input->post('saturday_in_time'),
			'saturday_out_time' => $this->input->post('saturday_out_time'),
			'sunday_in_time' => $this->input->post('sunday_in_time'),
			'sunday_out_time' => $this->input->post('sunday_out_time')
		);

		$this->db->where('office_shift_id', $id);
		$result = $this->db->update('xin_office_shift', $data);

		if ($result) {
			$Return['result'] = 'Shift successfully updated.';
		} else {
			$Return['error'] = 'Failed to update shift.';
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($Return));
	}

	public function delete_shift()
	{
		$id = $this->input->post('office_shift_id');
		if (!$id) {
			$Return['error'] = 'ID tidak ditemukan.';
			echo json_encode($Return);
			return;
		}

		$this->db->where('office_shift_id', $id);
		$deleted = $this->db->delete('xin_office_shift');

		if ($deleted) {
			$Return['result'] = 'Data shift berhasil dihapus.';
		} else {
			$Return['error'] = 'Gagal menghapus shift.';
		}

		echo json_encode($Return);
	}

	public function add_shift()
	{

		$data = array(
			'company_id' => $this->input->post('company_id'),
			'shift_name' => $this->input->post('shift_name'),
			'monday_in_time' => $this->input->post('monday_in_time'),
			'monday_out_time' => $this->input->post('monday_out_time'),
			'tuesday_in_time' => $this->input->post('tuesday_in_time'),
			'tuesday_out_time' => $this->input->post('tuesday_out_time'),
			'wednesday_in_time' => $this->input->post('wednesday_in_time'),
			'wednesday_out_time' => $this->input->post('wednesday_out_time'),
			'thursday_in_time' => $this->input->post('thursday_in_time'),
			'thursday_out_time' => $this->input->post('thursday_out_time'),
			'friday_in_time' => $this->input->post('friday_in_time'),
			'friday_out_time' => $this->input->post('friday_out_time'),
			'saturday_in_time' => $this->input->post('saturday_in_time'),
			'saturday_out_time' => $this->input->post('saturday_out_time'),
			'sunday_in_time' => $this->input->post('sunday_in_time'),
			'sunday_out_time' => $this->input->post('sunday_out_time')
		);

		$result = $this->db->insert('xin_office_shift', $data);

		if ($result) {
			$Return['result'] = 'Shift berhasil ditambahkan.';
		} else {
			$Return['error'] = 'Gagal menyimpan shift.';
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($Return));
	}
}
