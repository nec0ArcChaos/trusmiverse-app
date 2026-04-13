<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Trusmi_denda_ade extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");
		$this->load->model('Model_trusmi_denda', 'model');
		if ($this->session->userdata('user_id') != "") {
		} else {
			redirect('login', 'refresh');
		}
	}

	function index()
	{
		$data['content'] 	= "trusmi_denda/index_ade";
		$data['pageTitle'] 	= "T-Denda";
		$data['css'] 		= "trusmi_denda/css";
		$data['js'] 		= "trusmi_denda/js_ade";
		$data['karyawan']	= $this->model->get_employee();

		$this->load->view("layout/main", $data);
	}

	function get_dt_denda()
	{
		$periode 				= $_POST['periode'];
		// $end 				= $_POST['dateend'];
		$result['data']   	= $this->model->get_dt_denda($periode);
		echo json_encode($result);
	}

	function save_denda()
	{
		$user_id 		= $this->session->userdata('user_id');
		$employee_id	= $_POST['karyawan'];
		$user 			= explode(",", $_POST['user']);
		$alasan			= $_POST['alasan'];
		$nominal		= $_POST['nominal_denda'];
		$periode_denda	= $_POST['periode_denda'];

		$created_at		= date("Y-m-d H:i:s");
		$user_locked 	= $this->session->userdata('nama');

		if (isset($user)) {
			foreach ($user as $key => $value) {
				$data = array(
					"employee_id" 	=> $employee_id,
					"nominal" 		=> str_replace('.', '', $nominal) != '' ? str_replace('.', '', $nominal) : 0,
					"keterangan" 	=> $alasan . " - By " . $user_locked,
					"periode" 		=> $periode_denda,
					"created_at" 	=> $created_at,
					"created_by" 	=> $user_id
				);

				$result['data'] = $data;
				$result['insert_lock'] = $this->db->insert("trusmi_denda", $data);
			}
		}
		echo json_encode($result);
	}

	// addnew
	function dt_rekomendasi_denda()
	{
		$company = @$_REQUEST['company'];
		$department = @$_REQUEST['department'];
		$periode = @$_REQUEST['periode'];
		$data['data'] = $this->model->dt_rekomendasi_denda($periode, $company, $department);
		header('Content-type: application/json');
		echo json_encode($data);
	}

	function save_denda_rekom()
	{
		$user_id 		= $this->session->userdata('user_id');
		$employee_id	= $_POST['id_user_denda_rekom'];
		// $user 			= explode(",", $_POST['user']);
		$alasan			= $_POST['alasan_rekom'];
		$nominal		= $_POST['nominal_denda_rekom'];
		$periode_denda	= $_POST['periode_denda_rekom'];
		$id_rekomendasi	= $_POST['id_rekomendasi'];
		$status_denda	= $_POST['status_denda'];
		$note			= $_POST['reject_note'];

		$created_at		= date("Y-m-d H:i:s");
		$user_locked 	= $this->session->userdata('nama');

		$data = array(
			"employee_id" 	=> $employee_id,
			"nominal" 		=> str_replace('.', '', $nominal) != '' ? str_replace('.', '', $nominal) : 0,
			"keterangan" 	=> $alasan . " - By " . $user_locked,
			"periode" 		=> $periode_denda,
			"created_at" 	=> $created_at,
			"id_rekomendasi"=> $id_rekomendasi,
			"created_by" 	=> $user_id
		);

		$result['data'] = $data;
		if ($status_denda == 1) {
			$result['insert_lock'] = $this->db->insert("trusmi_denda", $data);
		}

		$this->db->where('id', $id_rekomendasi);
		$result['rekomen_denda'] = $this->db->update('trusmi_rekomen_denda', array('status' => $status_denda, 'note' => $note));

		echo json_encode($result);
	}
}
