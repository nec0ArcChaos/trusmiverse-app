<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Verified extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		// $this->load->model('model1');
		$this->load->model('eaf/model_verified', 'model_verified');
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
		// 	$access 	= 22;
		// 	$cek_status = $this->model1->cek_status_navigasi($id_user, $access);

		// 	if ($cek_status == '0') {
		// 		redirect("access_denied");
		// 	} else {
		// 		//do nothing
		// 	}
		// } else {
		// 	redirect("login");
		// }
		$user_id			= $this->session->userdata('user_id');
		if(isset($user_id)){
			// 		//do nothing
		} else {
			redirect("login");
		}
	}

	function index()
	{


			$data['content'] 		= "eaf/verified/index";
			$data['pageTitle'] 	= "Verification | EAF";
			$data['css'] 		= "eaf/verified/css";
			$data['js'] 		= "eaf/verified/js";

			$this->load->view("layout/main", $data);

	}

	// New Query for Reject and Approval Verifikatur
	function list_reject()
	{

			$data['content'] 		= "eaf/verified/list_reject";
			$data['pageTitle'] 	= "Reject by Verificator | EAF";
			$data['css'] 		= "eaf/verified/css";
			$data['js'] 		= "eaf/verified/list_reject_js";

			$this->load->view("layout/main", $data);

	}

	function list_approval()
	{
		$data['content'] 		= "eaf/verified/list_verified";
		$data['pageTitle'] 	= "List Verified | EAF";
		$data['css'] 		= "eaf/verified/css";
		$data['js'] 		= "eaf/verified/list_verified_js";

		$this->load->view("layout/main", $data);
	}

	function get_list_approval()
	{
		$datestart	= $_POST['datestart'];
		$dateend	= $_POST['dateend'];
		$status		= $_POST['status'];

		$result['data'] = $this->model_verified->get_list_approval($datestart, $dateend, $status);
		echo json_encode($result);
	}

	function get_detail_list_approval($id, $type)
	{
		if ($type == 1) {
			$result = $this->model_verified->get_detail_list_approval($id);
		} else if ($type == 2){
			$result = $this->model_verified->get_detail_list_approval_lpj($id);
	}
		echo json_encode($result);
	}
	// End New Query for Reject and Approval Verifikatur

	function get_list_my_approval()
	{
		$id_user 	= $this->session->userdata('user_id');
		$id_div 	= $this->session->userdata('id_divisi');
		$status		= $_POST['status'];
		$datestart	= $_POST['datestart'];
		$dateend	= $_POST['dateend'];

		$data['data'] = $this->model_verified->get_list_my_approval($id_user, $id_div, $status, $datestart, $dateend);
		echo json_encode($data);
	}
	// End My Approval Verifikatur

	function get_list_eaf_list_approval()
	{
		$id_user 	= $this->session->userdata('user_id');
		$id_div 	= $this->session->userdata('id_divisi');
		$status		= $_POST['status'];
		$datestart	= $_POST['datestart'];
		$dateend	= $_POST['dateend'];

		$data = $this->model_verified->get_list_eaf_list_approval($id_user, $id_div, $status, $datestart, $dateend);
		echo json_encode($data);
	}

	function get_list_eaf_reject_approval()
	{
		$id_user 	= $this->session->userdata('user_id');
		$id_div 	= $this->session->userdata('id_divisi');
		$status		= $_POST['status'];
		$datestart	= $_POST['datestart'];
		$dateend	= $_POST['dateend'];

		$data = $this->model_verified->get_list_eaf_reject_approval($id_user, $id_div, $status, $datestart, $dateend);
		echo json_encode($data);
	}

	function get_tracking()
	{
		$id = $_POST['id'];
		$data = $this->model_verified->get_tracking($id);
		echo json_encode($data);
	}

	function get_lpj()
	{
		$id 	= $_POST['id'];
		$data 	= $this->model_verified->get_lpj($id);
		echo json_encode($data);
	}

	function insert_approval()
	{
        // date_default_timezone_set('Asia/Jakarta');
        // $tanggal        = date("Y-m-d  H:i:s");
		
		$id_user 				= $this->session->userdata('user_id');
		$tgl_approve	  		= date('Y-m-d H:i:s');
		
		$id_pengajuan 			= $_POST['id_pengajuan_hide'];
		$status			 		= $_POST['status'];

		$id_approval 			= $_POST['id_approval_hide'];
		$id_user_approval		= $_POST['id_user_approval_hide'];

		$note_approval			= str_replace(array("\r", "\n"), ' ', $_POST['note_approval']);
		$note_approve 			= str_replace( array( '\'', '"' ), array( '`', '``' ), $note_approval);
		$nominal_new			= str_replace(".", "", $_POST['total']);

		if ( $status == 1 ) {
			
			$id_kategori = $_POST['id_kategori'];
			$cek = $this->model_verified->cek_verified($id_pengajuan)->num_rows();
			if ($cek == 0) {			

				$level = $status; // Default Level = 1 ke User Approval
				// Jika LPJ DLK Uang Makan maka ke Mba Fafri kemudian ke Finance
				// $cek_dlk = $this->model_verified->cek_pengajuan_dlk($id_pengajuan);
				// if ($cek_dlk['id_jenis'] == "711") {
				// 	$id_user_approval 	= 737; // Finance
				// 	$level				= 5;
				// 	$status				= 2;
				// }

				if ($id_kategori == 20) {
					$data_pengajuan = array(
						"status"				=> $status,
						"note"					=> $note_approve,
						"jumlah_termin"			=> $_POST['jumlah_termin'],
						"nominal_termin"		=> str_replace(".", "", $_POST['nominal_termin']),
						"periode_awal_termin"	=> $_POST['periode_termin'],
					);
				} else {
					$data_pengajuan = array(
						"status"	=> $status,
						"note"		=> $note_approve
					);
				}

				$data_keperluan = array(
					"nominal_uang"	=> $nominal_new
				);

				$data_appr_update = array(
					'level'				=> 10,
					'status'			=> 'Approve',
					'update_approve'	=> $tgl_approve,
					"note_approve"		=> $note_approve,
					'flag'				=> 'Pengajuan',
					'id_user'			=> $id_user
				);

				$data_appr_insert = array(
					'id_pengajuan'		=> $id_pengajuan,
					'id_user_approval'	=> $id_user_approval,
					'level'				=> $level,
					'flag'				=> 'Pengajuan'
				);

				$this->db->where('id_pengajuan', $id_pengajuan);
				$result['update_pengajuan'] = $this->db->update('e_eaf.e_pengajuan', $data_pengajuan);

				$this->db->where('id_pengajuan', $id_pengajuan);
				$result['update_nominal'] = $this->db->update('e_eaf.e_detail_keperluan', $data_keperluan);

				$this->db->where('id_approval', $id_approval);
				$result['update_approval'] = $this->db->update('e_eaf.e_approval', $data_appr_update);
				$result['insert_approval'] = $this->db->insert('e_eaf.e_approval', $data_appr_insert);

				if ($result['update_pengajuan']){
					$check 				= $this->model_verified->get_verified_idham($id_pengajuan);
					$result['stat']		= $status;
					$result['data']		= $this->model_verified->get_verified_for_wa($id_pengajuan,$check['pengaju'],$check['id_user_approval']);
				}
			} else {
				$result['update_pengajuan'] = false;
			}

		} else if ($status == 11) {	

			$data_pengajuan = array(
				"status"	=> $status,
				"note"		=> $note_approve
			);

			$data_appr_update = array(
				'level' 			=> 10,
				'status' 			=> 'Reject',
				'update_approve' 	=> $tgl_approve,
				"note_approve"		=> $note_approve,
				'id_user'			=> $id_user
			);
	
			$this->db->where('id_pengajuan', $id_pengajuan);
			$result['update_pengajuan'] = $this->db->update('e_eaf.e_pengajuan', $data_pengajuan);
	
			$this->db->where('id_approval', $id_approval);
			$result['update_approval'] = $this->db->update('e_eaf.e_approval', $data_appr_update);

		} else if ( $status == 12 ) {

			$data_pengajuan = array(
				"status" 		=> $status
			);
	
			$data_appr_update = array(
				'level' 			=> 10,
				'status' 			=> 'Revisi',
				'update_approve' 	=> $tgl_approve,
				'note_approve'		=> $note_approve,
				'id_user'			=> $id_user
			);
	
			$this->db->where('id_pengajuan', $id_pengajuan);
			$result['update_pengajuan'] = $this->db->update('e_eaf.e_pengajuan', $data_pengajuan);
	
			$this->db->where('id_approval', $id_approval);
			$result['update_approval'] = $this->db->update('e_eaf.e_approval', $data_appr_update);
		}

		if ($result['update_pengajuan']) {
			$result['wa_pengaju'] = $this->model_verified->get_verified_for_wa_pengaju($id_pengajuan);
		}

		echo json_encode($result);
	}

	function print_ba()
	{
		$id 			= $_GET['id'];
		$data['eaf'] 	= $this->model_verified->get_ba($id);
		$this->load->view("eaf/ba_lpj", $data);
	}

	function get_history()
	{
		$id = $_POST['id_biaya'];
		$data = $this->model_verified->get_history($id);
		echo json_encode($data);
	}

	// New Query for Detail Verified
	function get_detail_verified($id)
	{
		$res = $this->model_verified->get_detail_verified($id);
		echo json_encode($res);
	}
	// End New Query for Detail Verified
	
	function insert_verified_lpj()
	{
        // date_default_timezone_set('Asia/Jakarta');
        // $tanggal        = date("Y-m-d  H:i:s");
		
		$id_user 				= $this->session->userdata('user_id');
		$tgl_approve	  		= date('Y-m-d H:i:s');
		
		$id_pengajuan 			= $_POST['id_pengajuan_lpj_hide'];
		$status			 		= $_POST['status_lpj'];

		$row 					= $this->model_verified->get_id_approval_null($id_pengajuan);
		$id_approval 			= $row['id_approval'];

		$id_user_approval		= $_POST['id_user_approval_lpj_hide'];

		$note_approval			= str_replace(array("\r", "\n"), ' ', $_POST['note_approval_lpj']);
		$note_approve 			= str_replace( array( '\'', '"' ), array( '`', '``' ), $note_approval);
		$nominal_new			= str_replace(".", "", $_POST['nominal_lpj_rev']);

		$lev 					= $this->model_verified->get_leave_id($id_pengajuan);
		$leave_id 				= $lev['leave_id'];

		$waktu 					= explode(" ",$_POST['tgl_datang_rev']);
		$tgl_leave 				= $waktu[0];
		$jam_leave 				= $waktu[1];

		if ( $status == 6 ) {
			
			$cek = $this->model_verified->cek_verified($id_pengajuan)->num_rows();
			if ($cek == 0) {
				$data_pengajuan = array(
					"status"	=> $status,
					"note"		=> $note_approve
				);

				$data_keperluan = array(
					"nominal_lpj"	=> $nominal_new
				);

				$data_appr_update = array(
					'status'			=> 'Approve',
					'update_approve'	=> $tgl_approve,
					"note_approve"		=> $note_approve,
					'flag'				=> 'LPJ',
					'id_user'			=> $id_user
				);

				$level = 1; // Default ke User Approval
				// Jika LPJ DLK Uang Makan maka ke Mba Fafri kemudian ke Finance
				$cek_dlk = $this->model_verified->cek_dlk($id_pengajuan);
				// if ($cek_dlk['id_jenis'] == "711" && $cek_dlk['nota'] == "") {
				if ($cek_dlk['is_dlk'] == "dlk" && $cek_dlk['flag'] == "LPJ-BUKTI-NOTA") {
					$id_user_approval 	= 1709; // Finance
					$level				= 5;
				}

				$result['id_pengajuan'] = $id_pengajuan;
				$result['cek_dlk'] = $cek_dlk;
				$result['is_dlk'] =$cek_dlk['is_dlk'];
				$result['id_user_approval'] = $id_user_approval;
				$result['level'] = $level;

				$data_appr_insert = array(
					'id_pengajuan'		=> $id_pengajuan,
					'id_user_approval'	=> $id_user_approval,
					'level'				=> $level,
					'flag'				=> 'LPJ'
				);

				$data_leave = array(
					'to_date' => $tgl_leave,
					'end_time' => $jam_leave
				);

				$this->db->where('id_pengajuan', $id_pengajuan);
				$result['update_pengajuan'] = $this->db->update('e_eaf.e_pengajuan', $data_pengajuan);

				$this->db->where('id_lpj', $id_pengajuan);
				$result['update_nominal'] = $this->db->update('e_eaf.e_header_lpj', $data_keperluan);

				$this->db->where('id_approval', $id_approval);
				$result['update_approval'] = $this->db->update('e_eaf.e_approval', $data_appr_update);
				$result['insert_approval'] = $this->db->insert('e_eaf.e_approval', $data_appr_insert);
				

				$this->db->where('leave_id', $leave_id);
				$result['update_leave'] = $this->db->update('xin_leave_applications', $data_leave);

				// if ($result['update_pengajuan']){
				// 	$check 				= $this->model_verified->get_verified_idham($id_pengajuan);
				// 	$result['stat']		= $status;
				// 	$result['data']		= $this->model_verified->get_verified_for_wa($id_pengajuan,$check['pengaju'],$check['id_user_approval']);
				// }
				$result['update_pengajuan'] = true;
			} else {
				$result['update_pengajuan'] = false;
			}

		} else if ($status == 4){
			$idp = $this->db->query("SELECT
				e_pengajuan.id_pengajuan 
				FROM
				e_pengajuan 
				WHERE
				e_pengajuan.temp = '$id_pengajuan'")->row_array();

			$this->db->where('id_pengajuan', $idp['id_pengajuan']);
			$this->db->update('e_eaf.e_pengajuan', array('temp' => NULL));

			$data_pengajuan = array(
				"status"	=> $status,
				"note"		=> $note_approve
			);

			$data_appr_update = array(
				'status' 			=> 'Reject',
				'update_approve' 	=> $tgl_approve,
				"note_approve"		=> $note_approve,
				'id_user'			=> $id_user
			);
	
			$this->db->where('id_pengajuan', $id_pengajuan);
			$result['update_pengajuan'] = $this->db->update('e_eaf.e_pengajuan', $data_pengajuan);
	
			$this->db->where('id_approval', $id_approval);
			$result['update_approval'] = $this->db->update('e_eaf.e_approval', $data_appr_update);

		}

		echo json_encode($result);
	}

	function insert_verified_lpj_dev()
	{

		
		$id_user 				= $this->session->userdata('user_id');
		$tgl_approve	  		= date('Y-m-d H:i:s');
		
		$id_pengajuan 			= 'lpj2502220064';
		$status			 		= 6;

		// $row 					= $this->model_verified->get_id_approval_null_dev($id_pengajuan);
		$id_approval 			= '24687';

		// 1369 abyan
		$id_user_approval		= '1369';

		$note_approval			= str_replace(array("\r", "\n"), ' ', 'note_approval_lpj');
		$note_approve 			= str_replace( array( '\'', '"' ), array( '`', '``' ), $note_approval);
		$nominal_new			= str_replace(".", "", '105000');

		$lev 					= $this->model_verified->get_leave_id($id_pengajuan);
		$leave_id 				= $lev['leave_id'];

		$waktu 					= explode(" ",'2025-02-19 02:00:00');
		$tgl_leave 				= $waktu[0];
		$jam_leave 				= $waktu[1];

		// if ( $status == 6 ) {
			
			// $cek = $this->model_verified->cek_verified($id_pengajuan)->num_rows();
			$cek = 0;

			if ($cek == 0) {
				$data_pengajuan = array(
					"status"	=> $status,
					"note"		=> $note_approve
				);

				$data_keperluan = array(
					"nominal_lpj"	=> $nominal_new
				);

				$data_appr_update = array(
					'status'			=> 'Approve',
					'update_approve'	=> $tgl_approve,
					"note_approve"		=> $note_approve,
					'flag'				=> 'LPJ',
					'id_user'			=> $id_user
				);

				$level = 1; // Default ke User Approval
				// Jika LPJ DLK Uang Makan maka ke Mba Fafri kemudian ke Finance
				$cek_dlk = $this->model_verified->cek_dlk($id_pengajuan);
				// if ($cek_dlk['id_jenis'] == "711" && $cek_dlk['nota'] == "") {
				if ($cek_dlk['is_dlk'] == "dlk" && $cek_dlk['nota'] == "") {
					$id_user_approval 	= 1709; // Finance
					$level				= 5;
				}

				$data_appr_insert = array(
					'id_pengajuan'		=> $id_pengajuan,
					'id_user_approval'	=> $id_user_approval,
					'level'				=> $level,
					'flag'				=> 'LPJ'
				);

				$data_leave = array(
					'to_date' => $tgl_leave,
					'end_time' => $jam_leave
				);

				// $this->db->where('id_pengajuan', $id_pengajuan);
				// $result['update_pengajuan'] = $this->db->update('e_eaf.e_pengajuan', $data_pengajuan);
				$result['update_pengajuan'] = $data_pengajuan;

				// $this->db->where('id_lpj', $id_pengajuan);
				// $result['update_nominal'] = $this->db->update('e_eaf.e_header_lpj', $data_keperluan);
				$result['update_nominal'] = $data_keperluan;

				// $this->db->where('id_approval', $id_approval);
				// $result['update_approval'] = $this->db->update('e_eaf.e_approval', $data_appr_update);
				// $result['insert_approval'] = $this->db->insert('e_eaf.e_approval', $data_appr_insert);
				$result['update_approval'] = $data_appr_update;
				$result['insert_approval'] = $data_appr_insert;

				// $this->db->where('leave_id', $leave_id);
				// $result['update_leave'] = $this->db->update('xin_leave_applications', $data_leave);
				$result['update_leave'] = $data_leave;

				// if ($result['update_pengajuan']){
				// 	$check 				= $this->model_verified->get_verified_idham($id_pengajuan);
				// 	$result['stat']		= $status;
				// 	$result['data']		= $this->model_verified->get_verified_for_wa($id_pengajuan,$check['pengaju'],$check['id_user_approval']);
				// }
				$result['update_pengajuan'] = true;
			} else {
				$result['update_pengajuan'] = false;
			}

		// } else if ($status == 4){
		// 	$idp = $this->db->query("SELECT
		// 		e_pengajuan.id_pengajuan 
		// 		FROM
		// 		e_pengajuan 
		// 		WHERE
		// 		e_pengajuan.temp = '$id_pengajuan'")->row_array();

		// 	$this->db->where('id_pengajuan', $idp['id_pengajuan']);
		// 	$this->db->update('e_eaf.e_pengajuan', array('temp' => NULL));

		// 	$data_pengajuan = array(
		// 		"status"	=> $status,
		// 		"note"		=> $note_approve
		// 	);

		// 	$data_appr_update = array(
		// 		'status' 			=> 'Reject',
		// 		'update_approve' 	=> $tgl_approve,
		// 		"note_approve"		=> $note_approve,
		// 		'id_user'			=> $id_user
		// 	);
	
		// 	$this->db->where('id_pengajuan', $id_pengajuan);
		// 	$result['update_pengajuan'] = $this->db->update('e_eaf.e_pengajuan', $data_pengajuan);
	
		// 	$this->db->where('id_approval', $id_approval);
		// 	$result['update_approval'] = $this->db->update('e_eaf.e_approval', $data_appr_update);

		// }

		echo json_encode($result);
	}
	
	function insert_verified_lpj_faisal()
	{
        // date_default_timezone_set('Asia/Jakarta');
        // $tanggal        = date("Y-m-d  H:i:s");
		
		$id_user 				= $this->session->userdata('user_id');
		$tgl_approve	  		= date('Y-m-d H:i:s');
		
		$id_pengajuan 			= $_POST['id_pengajuan_lpj_hide'];
		$status			 		= $_POST['status_lpj'];

		$row 					= $this->model_verified->get_id_approval_null($id_pengajuan);
		$id_approval 			= $row['id_approval'];

		$id_user_approval		= $_POST['id_user_approval_lpj_hide'];

		$note_approval			= str_replace(array("\r", "\n"), ' ', $_POST['note_approval_lpj']);
		$note_approve 			= str_replace( array( '\'', '"' ), array( '`', '``' ), $note_approval);
		$nominal_new			= str_replace(".", "", $_POST['nominal_lpj_rev']);

		$lev 					= $this->model_verified->get_leave_id($id_pengajuan);
		$leave_id 				= $lev['leave_id'];

		$waktu 					= explode(" ",$_POST['tgl_datang_rev']);
		$tgl_leave 				= $waktu[0];
		$jam_leave 				= $waktu[1];

		if ( $status == 6 ) {
			
			$cek = $this->model_verified->cek_verified($id_pengajuan)->num_rows();
			if ($cek == 0) {
				$data_pengajuan = array(
					"status"	=> $status,
					"note"		=> $note_approve
				);

				$data_keperluan = array(
					"nominal_lpj"	=> $nominal_new
				);

				$data_appr_update = array(
					'status'			=> 'Approve',
					'update_approve'	=> $tgl_approve,
					"note_approve"		=> $note_approve,
					'flag'				=> 'LPJ',
					'id_user'			=> $id_user
				);

				$level = 1; // Default ke User Approval
				$cek_dlk = $this->model_verified->cek_dlk($id_pengajuan);
				if ($cek_dlk['id_jenis'] == "711" && $cek_dlk['nota'] == "") {
					$id_user_approval 	= 737; // Finance
					$level				= 5;
				}

				$data_appr_insert = array(
					'id_pengajuan'		=> $id_pengajuan,
					'id_user_approval'	=> $id_user_approval,
					'level'				=> $level,
					'flag'				=> 'LPJ'
				);

				$data_leave = array(
					'to_date' => $tgl_leave,
					'end_time' => $jam_leave
				);

				$this->db->where('id_pengajuan', $id_pengajuan);
				$result['update_pengajuan'] = $this->db->update('e_pengajuan', $data_pengajuan);

				$this->db->where('id_lpj', $id_pengajuan);
				$result['update_nominal'] = $this->db->update('e_header_lpj', $data_keperluan);

				$this->db->where('id_approval', $id_approval);
				$result['update_approval'] = $this->db->update('e_approval', $data_appr_update);
				$result['insert_approval'] = $this->db->insert('e_approval', $data_appr_insert);
				

				$this->db->where('leave_id', $leave_id);
				$result['update_leave'] = $this->db->update('xin_leave_applications', $data_leave);

				// if ($result['update_pengajuan']){
				// 	$check 				= $this->model_verified->get_verified_idham($id_pengajuan);
				// 	$result['stat']		= $status;
				// 	$result['data']		= $this->model_verified->get_verified_for_wa($id_pengajuan,$check['pengaju'],$check['id_user_approval']);
				// }
				$result['update_pengajuan'] = true;
			} else {
				$result['update_pengajuan'] = false;
			}

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
				"status"	=> $status,
				"note"		=> $note_approve
			);

			$data_appr_update = array(
				'status' 			=> 'Reject',
				'update_approve' 	=> $tgl_approve,
				"note_approve"		=> $note_approve,
				'id_user'			=> $id_user
			);
	
			$this->db->where('id_pengajuan', $id_pengajuan);
			$result['update_pengajuan'] = $this->db->update('e_pengajuan', $data_pengajuan);
	
			$this->db->where('id_approval', $id_approval);
			$result['update_approval'] = $this->db->update('e_approval', $data_appr_update);

		}

		echo json_encode($result);
	}
	
	// New Query for Detail DLK
	function get_detail_dlk($id)
	{
		$res = $this->model_verified->get_detail_dlk($id);
		echo json_encode($res);
	}
	// End New Query for Detail DLK

}
