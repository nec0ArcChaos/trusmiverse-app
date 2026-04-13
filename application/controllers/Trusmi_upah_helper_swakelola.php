<?php
// ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Trusmi_upah_helper_swakelola extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");
		$this->load->model('Model_trusmi_upah_helper_swakelola', 'model');
		if ($this->session->userdata('user_id') != "") {
		} else {
			redirect('login', 'refresh');
		}
	}

	function index()
	{
		$data['content'] 	= "trusmi_upah_helper_swakelola/index";
		$data['pageTitle'] 	= "Trusmi Upah Helper Swakelola";
		$data['css'] 		= "trusmi_upah_helper_swakelola/css";
		$data['js'] 		= "trusmi_upah_helper_swakelola/js";

		$this->load->view("layout/main", $data);
	}

	function get_data_karyawan()
	{
		$user_id = $this->session->userdata('user_id');
		$user_access = [1, 2842, 321, 6717]; // IT, Aris Kurniawan, Andre Imam Prayoga, Fardan Andhika
		if (in_array($user_id, $user_access)) {
			$data['data'] = $this->model->get_employee();
		} else {
			$data['data'] = [];
		}
		
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	function save_upah()
	{
		$created_by 		= $this->session->userdata('user_id');
		$user_id 			= $this->input->post('user_id');
		$upah 				= $this->input->post('upah');

		$cek_upah = $this->db->query("SELECT * FROM trusmi_upah_helper_swakelola WHERE user_id = '$user_id'")->num_rows();
		if ($cek_upah > 0) {
			$data = array(
				'upah' => $upah,
				'updated_by' => $created_by,
				'updated_at' => date('Y-m-d H:i:s')
			);

			$this->db->where('user_id', $user_id);
			$status = $this->db->update('trusmi_upah_helper_swakelola', $data);

			$log = array(
				'user_id' => $user_id,
				'upah' => $upah,
				'keterangan' => 'Update Upah',
				'created_by' => $created_by,
				'created_at' => date('Y-m-d H:i:s'),
			);

			$this->db->insert('trusmi_upah_helper_swakelola_log', $log);
		} else {
			$data = array(
				'user_id' => $user_id,
				'upah' => $upah,
				'created_by' => $created_by,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => null,
				'updated_by' => null
			);

			$status = $this->db->insert('trusmi_upah_helper_swakelola', $data);

			$log = array(
				'user_id' => $user_id,
				'upah' => $upah,
				'keterangan' => 'Insert Upah',
				'created_by' => $created_by,
				'created_at' => date('Y-m-d H:i:s'),
			);

			$this->db->insert('trusmi_upah_helper_swakelola_log', $log);
		}

		header('Content-Type: application/json');
		echo json_encode(array("status" => $status));
	}

	function get_log_upah($user_id)
	{	
		$data['data'] = $this->model->get_log($user_id);
		header('Content-Type: application/json');
		echo json_encode($data);
	}
}
