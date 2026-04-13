<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Master_jenis_biaya extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		// $this->load->model('model1');
		$this->load->model('eaf/model_master_jenis_biaya', 'model_master_jenis_biaya');
		$this->load->library("session");
		$this->load->library('FormatJson');

		//cek login
		if ($this->session->userdata('user_id') != "") {
			$user_id = $this->session->userdata('user_id');
		} else {
			redirect('login', 'refresh');
		}
		// $username = $this->session->userdata("username");
		// $password = $this->session->userdata("password");
		// $id_user  = $this->session->userdata("id_user");

		// $cek_auth = $this->model1->cek_auth($username, $password);

		// if ($cek_auth > 0) {
		// 	//cek hak navigasi
		// 	$access 	= 7;
		// 	$cek_status = $this->model1->cek_status_navigasi($id_user, $access);

		// 	if ($cek_status == '0') {
		// 		redirect("access_denied");
		// 	} else {
		// 		//do nothing
		// 	}
		// } else {
		// 	redirect("login");
		// }
	}

	function index()
	{

		$user_id			= $this->session->userdata('user_id');
		// Memeriksa apakah variabel sesi tertentu ada
		if (isset($user_id)) {
			$data['content'] 		= "eaf/master_jenis_biaya/index";
			$data['pageTitle'] 	= "Jenis Biaya | EAF";
			$data['css'] 		= "eaf/master_jenis_biaya/css";
			$data['js'] 		= "eaf/master_jenis_biaya/js";

			$data['akun'] 			=  $this->model_master_jenis_biaya->get_akun();
			$data['company'] 		=  $this->model_master_jenis_biaya->get_company();
			$data['tipe_biaya'] 	=  $this->model_master_jenis_biaya->get_tipe_biaya();
			$data['user_approval'] 	=  $this->model_master_jenis_biaya->get_user_approval();

			$data['button_edit'] 	=  $this->model_master_jenis_biaya->get_e_parameter($user_id);

			$this->load->view("layout/main", $data);
		} else {
			redirect("login");
		}
	}

	function get_list_jenis_biaya()
	{
		$data['data'] = $this->model_master_jenis_biaya->get_list_jenis_biaya(0, 0);
		echo json_encode($data);
	}

	function get_jenis_biaya()
	{
		$id = $_POST['id_jenis'];
		$data['data'] = $this->model_master_jenis_biaya->get_list_jenis_biaya(1, $id);
		echo json_encode($data);
	}

	function insert_jenis_biaya()
	{
		$tipe_crud  		= $_POST['tipe_crud'];

		if ($tipe_crud == 'update') {
			$company_id  		= $_POST['company_id_hidden'];
		} else {
			$company_id  		= $_POST['company_id'];
		}
		$id_jenis  			= $_POST['id_jenis'];
		$jenis  			= $_POST['jenis_biaya'];
		// $id_akun  			= $_POST['akun'];
		$id_budget	    	= $_POST['budget'];
		$id_tipe_biaya		= $_POST['tipe_biaya'];
		$id_user_approval1	= $_POST['user_approval1'];
		$id_user_approval2	= $_POST['user_approval2'];
		$max_approve		= str_replace(".", "", $_POST['max_nominal']);
		$nominal_approve	= str_replace(".", "", $_POST['nominal_app']);
		$created_at			= date('Y-m-d H:i:s');
		$created_by			= $this->session->userdata('user_id');
		$updated_at			= date('Y-m-d H:i:s');
		$updated_by			= $this->session->userdata('user_id');

		// if ($id_user_approval == "2") {
		// 331 feronita
		// if ($id_user_approval == "331") {
		// $id_user_verified = 737;
		// 79 ade yulianti
		// $id_user_verified = 79;
		// } else {
		$id_user_verified = null;
		// }


		$id_akun = null;

		if ($id_jenis == "0") {

			$data = array(
				'id_akun'  			=> $id_akun,
				'id_budget'  		=> $id_budget,
				'jenis'  			=> $jenis,
				'id_tipe_biaya'  	=> $id_tipe_biaya,
				'id_user_approval'  => $id_user_approval1,
				'id_user_approval2' => $id_user_approval2,
				'id_user_verified'  => $id_user_verified,
				'project'	  		=> 1,
				'created_at'  		=> $created_at,
				'created_by'  		=> $created_by,
				'company_id'  		=> $company_id,
				'nominal_app_2'		=> $nominal_approve,
				'max_approve'		=> $max_approve
			);

			$result['insert_jenis_biaya'] = $this->db->insert('e_eaf.e_jenis_biaya', $data);
		} else {

			$data = array(
				'id_akun'  			=> $id_akun,
				'id_budget'  		=> $id_budget,
				'jenis'  			=> $jenis,
				'id_tipe_biaya'  	=> $id_tipe_biaya,
				'id_user_approval'  => $id_user_approval1,
				'id_user_approval2' => $id_user_approval2,
				'updated_at'  		=> $updated_at,
				'updated_by'  		=> $updated_by,
				'company_id'  		=> $company_id,
				'nominal_app_2'		=> $nominal_approve,
				'max_approve'		=> $max_approve
			);

			$this->db->where('id_jenis', $id_jenis);
			$result['update_jenis_biaya'] = $this->db->update('e_eaf.e_jenis_biaya', $data);
		}
		echo json_encode($result);
	}

	function insert_budget()
	{
		$nama_budget	   	= $_POST['add_budget'];
		$company_budgetid	   	= $_POST['company_budgetid'];

		$created_at			= date('Y-m-d H:i:s');
		$created_by			= $this->session->userdata('user_id');

		$data = array(
			'budget'	  		=> $nama_budget,
			'created_at'  		=> $created_at,
			'created_by'  		=> $created_by,
			'company_id'  		=> $company_budgetid

		);

		$result['insert_jenis_biaya'] = $this->db->insert('e_eaf.e_budget', $data);
		if ($result) {
			$budget = $this->model_master_jenis_biaya->get_no_last_budget();
			echo json_encode($budget['id_budget']);
		}
	}

	function delete_jenis_biaya()
	{
		$id = $_POST['id_jenis_biaya'];

		// 1. Ambil data nama jenis biaya saat ini berdasarkan ID
		$this->db->select('jenis');
		$this->db->where('id_jenis', $id);
		$query = $this->db->get('e_eaf.e_jenis_biaya');
		$row = $query->row();

		if ($row) {
			$nama_lama = $row->jenis;

			// Cek apakah sudah ada "XXX" agar tidak double (misal: XXX XXX Biaya)
			if (strpos($nama_lama, 'XXX') === false) {
				$nama_baru = "XXX" . $nama_lama;

				$data = array(
					'jenis'      => $nama_baru,
					// Opsional: Catat siapa dan kapan dihapus
					'updated_at' => date('Y-m-d H:i:s'),
					'updated_by' => $this->session->userdata('user_id')
				);

				$this->db->where('id_jenis', $id);
				$result['status'] = $this->db->update('e_eaf.e_jenis_biaya', $data);
				$result['msg'] = "Data berhasil dinonaktifkan (XXX).";
			} else {
				$result['status'] = false;
				$result['msg'] = "Data sudah dinonaktifkan sebelumnya.";
			}
		} else {
			$result['status'] = false;
			$result['msg'] = "Data tidak ditemukan.";
		}

		echo json_encode($result);
	}

	function reload_budget($value)
	{
		$data = $this->model_master_jenis_biaya->get_budget();
		$budget = '<option data-placeholder="true">-- Pilih Budget --</option>';
		foreach ($data as $row) {
			$selected = ($value == $row->id_budget) ? "selected" : "";
			$budget .= '<option value="' . $row->id_budget . '" ' . $selected . '> ' . $row->budget . ' </option>';
		}
		echo $budget;
	}

	function insert_kategori()
	{
		$data = array(
			'kategori_motif'		=> $_POST['master_kategori'],
			'created_at'			=> date('Y-m-d H:i:s'),
			'created_by'			=> $this->session->userdata('id_user')
		);

		$result = $this->db->insert('m_kategori_motif', $data);
	}

	function get_tipe_biaya($id)
	{
		$cek = $this->model_master_jenis_biaya->cek_tipe_biaya($id);
		if ($cek['tipe'] == 'Unlimited') {
			$tipe = "1,4"; // Unlimited dan Per Pengajuan
		} else if ($cek['tipe'] == 'Limited') {
			$tipe = "2,3"; // Limited (Per Minggu dan Per Bulan)
		} else {
			$tipe = "1,2,3,4";
		}

		$data = $this->model_master_jenis_biaya->get_tipe_biaya_new($tipe);
		$option = '<option data-placeholder="true">-- Pilih Tipe Biaya --</option>';
		foreach ($data as $row) {
			$option .= '<option value="' . $row->id . '">' . $row->tipe . '</option>';
		}

		// if ($tipe == "0") {
		// 	$option .='<option value="0">Nominal Budget Belum di Buat</option>';
		// }

		echo $option;
	}

	function get_lVwfiYHslXSBboCV_duit()
	{
		$company_id		= $_POST['company_id'];
		$data['budget'] 		=  $this->model_master_jenis_biaya->get_budget_det($company_id)->result();
		// $data		=  $this->model_master_jenis_biaya->get_budget_det($company_id)->result();

		echo json_encode($data);
	}
}
