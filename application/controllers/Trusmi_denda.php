<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Trusmi_denda extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");
		$this->load->model('Model_trusmi_denda', 'model');
        if ($this->session->userdata('user_id') != "") { } else {
			redirect('login', 'refresh');
        }
	}

	function index()
	{
		$data['content'] 	= "trusmi_denda/index";
		$data['pageTitle'] 	= "T-Denda & Reward";
		$data['css'] 		= "trusmi_denda/css";
		$data['js'] 		= "trusmi_denda/js";
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

	// update 12/12/25
	function save_denda()
	{
		$user_id        = $this->session->userdata('user_id');
		$employee_id    = $this->input->post('karyawan');
		$user           = explode(",", $this->input->post('user'));
		$alasan         = $this->input->post('alasan');
		$tipe           = $this->input->post('tipe');
		$nominal        = $this->input->post('nominal_denda');
		$periode_denda  = $this->input->post('periode_denda');

		$created_at     = date("Y-m-d H:i:s");
		$user_locked    = $this->session->userdata('nama');

		$uploaded_file = null; // default jika tidak ada file

		// Cek apakah file dikirim
		if (!empty($_FILES['dokumen']['name'])) {
			// var_dump($_FILES['dokumen']['name']);
			// die();
			$config['upload_path']   = './uploads/trusmi_denda/';
			$config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx';
			$config['max_size']      = 2048; // 2 MB
			$config['encrypt_name']  = TRUE;

			// pastikan folder ada
			if (!is_dir($config['upload_path'])) {
				mkdir($config['upload_path'], 0777, TRUE);
			}

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('dokumen')) {
				$uploadData    = $this->upload->data();
				$uploaded_file = $uploadData['file_name']; // simpan nama file
			} else {
				// Jika gagal upload: kirim error
				echo json_encode([
					'status' => false,
					'error' => $this->upload->display_errors()
				]);
				return;
			}
		}

		if (isset($user)) {
			foreach ($user as $value) {

				$data = array(
					"employee_id"   => $employee_id,
					"nominal"       => str_replace('.', '', $nominal) ?: 0,
					"keterangan"    => $alasan." - By ".$user_locked,
					"periode"       => $periode_denda,
					"created_at"    => $created_at,
					"created_by"    => $user_id,
					"tipe"          => $tipe,
					"dokumen"       => $uploaded_file // nullable
				);

				$this->db->insert("trusmi_denda", $data);
			}
		}

		echo json_encode([
			'status' => true,
			'message' => 'Data saved successfully'
		]);
	}

	// function save_denda()
	// {
	// 	$user_id 		= $this->session->userdata('user_id');
	// 	$employee_id	= $_POST['karyawan'];
	// 	$user 			= explode(",",$_POST['user']);
	// 	$alasan			= $_POST['alasan'];
	// 	$tipe			= $_POST['tipe'];
	// 	$nominal		= $_POST['nominal_denda'];
	// 	$periode_denda	= $_POST['periode_denda'];

	// 	$created_at		= date("Y-m-d H:i:s");
	// 	$user_locked 	= $this->session->userdata('nama');

	// 	if (isset($user)) {
	// 		foreach ($user as $key => $value) {
	// 			$data = array (
	// 				"employee_id" 	=> $employee_id,
	// 				"nominal" 		=> str_replace('.','',$nominal) != '' ? str_replace('.','',$nominal) : 0,
	// 				"keterangan" 	=> $alasan." - By ".$user_locked,
	// 				"periode" 		=> $periode_denda,
	// 				"created_at" 	=> $created_at,

	// 				"created_by" 	=> $user_id,
	// 				'tipe'=>$tipe
	// 			);

	// 			$result['data'] = $data;
	// 			$result['insert_lock'] = $this->db->insert("trusmi_denda", $data);
	// 		}
	// 	}
	// 	echo json_encode($result);
	// }

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
			"tipe"			=> "Denda",
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

	// devnew
	function index_dev()
	{
		$data['content'] 	= "trusmi_denda/index_dev";
		$data['pageTitle'] 	= "T-Denda & Reward";
		$data['css'] 		= "trusmi_denda/css";
		$data['js'] 		= "trusmi_denda/js_dev";
		$data['karyawan']	= $this->model->get_employee();

		$this->load->view("layout/main", $data);
	}

	function save_denda_dev()
	{
		$user_id        = $this->session->userdata('user_id');
		$employee_id    = $this->input->post('karyawan');
		$user           = explode(",", $this->input->post('user'));
		$alasan         = $this->input->post('alasan');
		$tipe           = $this->input->post('tipe');
		$nominal        = $this->input->post('nominal_denda');
		$periode_denda  = $this->input->post('periode_denda');

		$created_at     = date("Y-m-d H:i:s");
		$user_locked    = $this->session->userdata('nama');

		$uploaded_file = null; // default jika tidak ada file

		// Cek apakah file dikirim
		if (!empty($_FILES['dokumen']['name'])) {
			// var_dump($_FILES['dokumen']['name']);
			// die();
			$config['upload_path']   = './uploads/trusmi_denda/';
			$config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx';
			$config['max_size']      = 2048; // 2 MB
			$config['encrypt_name']  = TRUE;

			// pastikan folder ada
			if (!is_dir($config['upload_path'])) {
				mkdir($config['upload_path'], 0777, TRUE);
			}

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('dokumen')) {
				$uploadData    = $this->upload->data();
				$uploaded_file = $uploadData['file_name']; // simpan nama file
			} else {
				// Jika gagal upload: kirim error
				echo json_encode([
					'status' => false,
					'error' => $this->upload->display_errors()
				]);
				return;
			}
		}

		if (isset($user)) {
			foreach ($user as $value) {

				$data = array(
					"employee_id"   => $employee_id,
					"nominal"       => str_replace('.', '', $nominal) ?: 0,
					"keterangan"    => $alasan." - By ".$user_locked,
					"periode"       => $periode_denda,
					"created_at"    => $created_at,
					"created_by"    => $user_id,
					"tipe"          => $tipe,
					"dokumen"       => $uploaded_file // nullable
				);

				$this->db->insert("trusmi_denda", $data);
			}
		}

		echo json_encode([
			'status' => true,
			'message' => 'Data saved successfully'
		]);
	}

	function delete_denda()
	{
		$user_id        = $this->session->userdata('user_id');
		$id = $this->input->post('id');
		if (in_array($user_id, array(1,778,979))) {
			$delete = $this->db->delete('trusmi_denda', array('id' => $id));
			if ($delete) {
				echo json_encode([
					'status' => true,
					'message' => 'Data deleted successfully'
				]);
			} else {
				echo json_encode([
					'status' => false,
					'message' => 'Failed to delete data'
				]);
			}
		} else {
			echo json_encode([
				'status' => false,
				'message' => 'Unauthorized'
			]);
		}
	}

}
