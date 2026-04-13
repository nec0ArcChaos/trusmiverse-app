<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Approvalori extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->model('model1');
		$this->load->model('eaf/model_approval', 'model_approval');
		$this->load->library("session");
		$this->load->library('FormatJson');

		//cek login
		$username = $this->session->userdata("username");
		$password = $this->session->userdata("password");
		$id_user  = $this->session->userdata("id_user");

		$cek_auth = $this->model1->cek_auth($username, $password);

		if ($cek_auth > 0) {
			//cek hak navigasi
			$access 	= 2;
			$cek_status = $this->model1->cek_status_navigasi($id_user, $access);

			if ($cek_status == '0') {
				redirect("access_denied");
			} else {
				//do nothing
			}
		} else {
			redirect("login");
		}
	}

	function index()
	{
		$data['view'] 		= "eaf/approval/index";
		$data['pageTitle'] 	= "Approval User | EAF";
		$data['css'] 		= "eaf/approval/css";
		$data['js'] 		= "eaf/approval/js";

		$this->load->view("main", $data);
	}

	function reject()
	{
		$data['view'] 		= "eaf/approval/index_reject";
		$data['pageTitle'] 	= "Reject User | EAF";
		$data['css'] 		= "eaf/approval/css";
		$data['js'] 		= "eaf/approval/js_reject";

		$this->load->view("main", $data);
	}

	function list_approval()
	{
		$data['view'] 		= "eaf/approval/index_all";
		$data['pageTitle'] 	= "List Approval | EAF";
		$data['css'] 		= "eaf/approval/css";
		$data['js'] 		= "eaf/approval/js_all";

		$this->load->view("main", $data);
	}

	function get_list_eaf()
	{
		$id_user 	= $this->session->userdata('id_user');
		$id_div 	= $this->session->userdata('id_divisi');
		$status		= $_POST['status'];
		$datestart	= $_POST['datestart'];
		$dateend	= $_POST['dateend'];

		$data = $this->model_approval->get_list_eaf($id_user, $id_div, $status, $datestart, $dateend);
		echo json_encode($data);
	}

	function get_list_eaf_my_approval()
	{
		$id_user 	= $this->session->userdata('id_user');
		$id_div 	= $this->session->userdata('id_divisi');
		$status		= $_POST['status'];
		$datestart	= $_POST['datestart'];
		$dateend	= $_POST['dateend'];

		$data = $this->model_approval->get_list_eaf_my_approval($id_user, $id_div, $status, $datestart, $dateend);
		echo json_encode($data);
	}

	function get_list_eaf_my_approval_test()
	{
		$id_user 	= $this->session->userdata('id_user');
		$id_div 	= $this->session->userdata('id_divisi');
		$status		= 1;
		$datestart	= 1;
		$dateend	= 1;

		$data = $this->model_approval->get_list_eaf_my_approval_test($id_user, $id_div, $status, $datestart, $dateend);
		echo json_encode($data);
	}

	function get_list_eaf_all()
	{
		$id_user 	= $this->session->userdata('id_user');
		$id_div 	= $this->session->userdata('id_divisi');
		$status		= $_POST['status'];
		$datestart	= $_POST['datestart'];
		$dateend	= $_POST['dateend'];

		$data = $this->model_approval->get_list_eaf_all($id_user, $id_div, $status, $datestart, $dateend);
		echo json_encode($data);
	}

	function get_tracking()
	{
		$id = $_POST['id'];
		$data = $this->model_approval->get_tracking($id);
		echo json_encode($data);
	}

	function get_lpj()
	{
		$id = $_POST['id'];
		$data = $this->model_approval->get_lpj($id);
		echo json_encode($data);
	}

	function insert_approval()
	{
        // date_default_timezone_set('Asia/Jakarta');
        // $tanggal        = date("Y-m-d  H:i:s");
		
		$id_user 				= $this->session->userdata('id_user');
		$dpr      				= $this->session->userdata('id_divisi');
		$tgl_approve	  		= date('Y-m-d H:i:s');
		
		$id_pengajuan 			= $_POST['id_pengajuan_hide'];
		$status			 		= $_POST['status'];

		$row 					= $this->model_approval->get_id_approval_null($id_pengajuan);
		$id_approval 			= $row['id_approval'];
		$id_usr_appr			= $row['id_user_approval'];

		
		$note_approval			= str_replace(array("\r", "\n"), ' ', $_POST['note_approval']);
		$note_approve 			= str_replace( array( '\'', '"' ), array( '`', '``' ), $note_approval);
		$nominal_new			= str_replace(".", "", $_POST['total']);

		if ($status == 2) {
			$status_approval = 'Approve';
			$id_user_approval = 737;
		} else if ($status == 4){
			$status_approval = 'Reject';
			$id_user_approval = $id_usr_appr;
		} else if ($status == 9){
			$status_approval = 'Revisi';
			$id_user_approval = $id_usr_appr;
		}

		if ( $status == 2 ) {

			$cek = $this->model_approval->cek_approval($id_pengajuan)->num_rows();
			if ($cek == 0) {
				$data_pengajuan = array(
					"status"	=> $status,
					"note"		=> $note_approve
				);

				$data_keperluan = array(
					"nominal_uang"	=> $nominal_new
				);

				$data_appr_update = array(
					'level'				=> 1,
					'status'			=> $status_approval,
					'update_approve'	=> $tgl_approve,
					"note_approve"		=> $note_approve,
					'flag'				=> 'Pengajuan',
					'id_user'			=> $id_user
				);

				$data_appr_insert = array(
					'id_pengajuan'		=> $id_pengajuan,
					'id_user_approval'	=> $id_user_approval,
					'flag'				=> 'Pengajuan'
				);

				$ck = $this->model_approval->cek_sisa_budget($id_pengajuan);
				if ($ck['jenis'] == "Limited" && intval($ck['budget']) < intval($nominal_new)) {
					$result['warning'] = "Budget tidak mencukupi, hubungi Finance untuk penambahan budget.";
					$result['update_pengajuan'] = false;
				} else {
					$result['warning'] = "";
					$this->db->where('id_pengajuan', $id_pengajuan);
					$result['update_pengajuan'] = $this->db->update('e_pengajuan', $data_pengajuan);
	
					$this->db->where('id_pengajuan', $id_pengajuan);
					$result['update_nominal'] = $this->db->update('e_detail_keperluan', $data_keperluan);
	
					$this->db->where('id_approval', $id_approval);
					$result['update_approval'] = $this->db->update('e_approval', $data_appr_update);
	
					$result['insert_approval'] = $this->db->insert('e_approval', $data_appr_insert);
				}

			} else {
				$result['update_pengajuan'] = false;
				$result['warning'] = "Pengajuan sudah di approve, harap refresh halaman.";
			}

		} else if ($status == 4){	

			$data_pengajuan = array(
				"status"	=> $status,
				"note"		=> $note_approve
			);

			$data_appr_update = array(
				'level' 			=> 4,
				'status' 			=> 'Reject',
				'update_approve' 	=> $tgl_approve,
				"note_approve"		=> $note_approve,
				'id_user'			=> $id_user
			);
	
			$this->db->where('id_pengajuan', $id_pengajuan);
			$result['update_pengajuan'] = $this->db->update('e_pengajuan', $data_pengajuan);
	
			$this->db->where('id_approval', $id_approval);
			$result['update_approval'] = $this->db->update('e_approval', $data_appr_update);

		} else if ( $status == 9 ) {

			$data_pengajuan = array(
				"status" 		=> $status
			);
	
			$data_appr_update = array(
				'level' 			=> 1,
				'status' 			=> 'Revisi',
				'update_approve' 	=> $tgl_approve,
				'note_approve'		=> $note_approve,
				'id_user'			=> $id_user
			);
	
			$this->db->where('id_pengajuan', $id_pengajuan);
			$result['update_pengajuan'] = $this->db->update('e_pengajuan', $data_pengajuan);
	
			$this->db->where('id_approval', $id_approval);
			$result['update_approval'] = $this->db->update('e_approval', $data_appr_update);

		}

		if ($result['update_pengajuan']){
			$result['data'] = $this->model_approval->get_approval_for_wa($id_pengajuan);
		}

		echo json_encode($result);
	}

	function insert_approval_lpj()
	{
		$id_user 				= $this->session->userdata('id_user');
		$dpr      				= $this->session->userdata('id_divisi');
		$tgl_approve	  		= date('Y-m-d H:i:s');
		
		$id_pengajuan 			= $_POST['id_pengajuan_lpj_hide'];
		$status 				= $_POST['status_lpj'];
		$note_approval 			= $_POST['note_approval_lpj'];

		$row 			= $this->model_approval->get_id_approval_null($id_pengajuan);
		$id_approval 	= $row['id_approval'];
		$id_usr_appr	= $row['id_user_approval'];

		if ($status == 6) {
			$status_approval = 'Approve';
			$id_user_approval = 737;
		} else if ($status == 4){
			$status_approval = 'Reject';
			$id_user_approval = $id_usr_appr;
		}

		if ($status == 6){
			$data_pengajuan = array(
				"status"	=> $status,
				"note" 		=> $note_approval
			);

			$data_appr_update = array(
				'level' 			=> 1,
				'status' 			=> $status_approval,
				'update_approve' 	=> $tgl_approve,
				"note_approve" 		=> $note_approval,
				'flag' 				=> 'LPJ',
				'id_user' 			=> $id_user
			);

			$data_appr_insert = array(
				'id_pengajuan' 		=> $id_pengajuan,
				'id_user_approval' 	=> $id_user_approval,
				'flag' 				=> 'LPJ'
			);

			$this->db->where('id_pengajuan', $id_pengajuan);
			$result['update_pengajuan'] = $this->db->update('e_pengajuan', $data_pengajuan);

			$this->db->where('id_approval', $id_approval);
			$result['update_approval'] = $this->db->update('e_approval', $data_appr_update);
			$result['insert_approval'] = $this->db->insert('e_approval', $data_appr_insert);
		} else if ($status == 4){
			$idp = $this->db->query("SELECT
				e_pengajuan.id_pengajuan 
				FROM
				e_pengajuan 
				WHERE
				e_pengajuan.temp = '$id_pengajuan'")->row_array();

			$this->db->where('id_pengajuan', $idp['id_pengajuan']);
			$this->db->update('e_pengajuan', array('temp' => NULL));

			$data_pengajuan = array(
				"status" 	=> $status,
				"note" 		=> $note_approval
			);
	
			$data_appr_update = array(
				'level' 			=> 4,
				'status' 			=> 'Reject',
				'update_approve' 	=> $tgl_approve,
				"note_approve" 		=> $note_approval,
				'flag' 				=> 'LPJ',
				'id_user' 			=> $id_user
			);
	
			$this->db->where('id_pengajuan', $id_pengajuan);
			$result['update_pengajuan'] = $this->db->update('e_pengajuan', $data_pengajuan);
	
			$this->db->where('id_approval', $id_approval);
			$result['update_approval'] = $this->db->update('e_approval', $data_appr_update);
		}
		echo json_encode($result);
	}

	function print_ba()
	{
		$id 			= $_GET['id'];
		$data['eaf'] 	= $this->model_approval->get_ba($id);
		$this->load->view("eaf/ba_lpj", $data);
	}

	function get_history()
	{
		$id = $_POST['id_biaya'];
		$data = $this->model_approval->get_history($id);
		echo json_encode($data);
	}

	function get_detail_approval($id_pengajuan)
	{
		$data = $this->model_approval->get_detail_approval($id_pengajuan);
		echo json_encode($data);
	}

	// function get_approval_for_wa($id)
	// {
	// 	$data = $this->model_approval->get_approval_for_wa($id);
	// 	echo json_encode($data);
	// }

}
