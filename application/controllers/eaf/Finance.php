<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Finance extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		// $this->load->model('model1');
		$this->load->model('eaf/model_finance', 'model_finance');
		$this->load->library("session");
		$this->load->library('FormatJson');

		//cek login
		$username = $this->session->userdata("username");
		$password = $this->session->userdata("password");
		$id_user = $this->session->userdata("user_id");

		$user_id = $this->session->userdata('user_id');
		if (isset($user_id)) {
			// 		//do nothing
		} else {
			redirect("login");
		}
	}

	function index($tipe)
	{
		$data['content'] = "eaf/finance/index";
		if ($tipe == 1) {
			$data['pageTitle'] = "Approval Finance | EAF";
			$data['type'] = 1;
		} else if ($tipe == 2) {
			$data['pageTitle'] = "Approval Finance | LPJ";
			$data['type'] = 2;
		} else if ($tipe == 3) {
			$data['pageTitle'] = "Konfirmasi Finance | LPJ"; // My Konfirmasi LPJ
			$data['type'] = 3;
		}
		$data['css'] = "eaf/finance/css";
		$data['js'] = "eaf/finance/js";
		$user_id = $this->session->userdata('user_id');

		$data['biaya'] = $this->model_finance->get_biaya();
		$data['jenis'] = $this->model_finance->get_subbiaya_all();
		$cek_param = $this->model_finance->get_e_parameter(7, $user_id)->row_array();
		if ($cek_param['id'] != Null) {
			$data['cek_akses_btn_save'] = 1;
		} else {
			$data['cek_akses_btn_save'] = 0;
		}

		$this->load->view("layout/main", $data);
	}

	function list_konfirmasi($tipe)
	{
		// Untuk Akses ini harus pakai $tipe = 2
		$data['content'] = "eaf/finance/index";
		$data['pageTitle'] = "Konfirmasi Finance | LPJ";
		$data['type'] = $tipe;
		$data['css'] = "eaf/finance/css";
		$data['js'] = "eaf/finance/js";

		$data['biaya'] = $this->model_finance->get_biaya();
		$data['jenis'] = $this->model_finance->get_subbiaya_all();
		$this->load->view("layout/main", $data);
	}

	function faisal($tipe)
	{
		$data['view'] = "eaf/finance/index_faisal";
		if ($tipe == 1) {
			$data['pageTitle'] = "Approval Finance | EAF";
		} else {
			$data['pageTitle'] = "Approval Finance | LPJ";
		}
		$data['css'] = "eaf/finance/css";
		$data['js'] = "eaf/finance/js_faisal";

		$data['biaya'] = $this->model_finance->get_biaya();
		$data['jenis'] = $this->model_finance->get_subbiaya_all();
		$this->load->view("main", $data);
	}

	function get_biaya()
	{
		$id_budget = $this->model_finance->check_id_budget($_POST['id_jenis']);
		$data = $this->model_finance->get_biaya($id_budget);

		echo '<option value="0" disabled>- Pilih Biaya -</option>';
		foreach ($data as $row) {
			$slc = ($id_budget == $row->id_budget) ? "selected" : "";
			echo '<option value="' . $row->id_biaya . '|' . $row->id_budget . '|' . $row->budget . '" ' . $slc . '>' . $row->nama_biaya . '</option>';
		}
	}

	function get_biaya_json()
	{
		$id_budget = $this->model_finance->check_id_budget($_POST['id_jenis']);
		$datas = $this->model_finance->get_biaya($id_budget);

		// echo '<option value="0" disabled>- Pilih Biaya -</option>';
		foreach ($datas as $row) {
			$data[] = array(
				"dtext" => $row->nama_biaya . ' | ' . $row->company_kode,
				"dvalue" => $row->id_biaya . '|' . $row->id_budget . '|' . $row->budget . '|' . $row->company_id . '|' . $row->company_kode,
			);
		}
		echo json_encode($data);
	}

	function reject()
	{
		$data['view'] = "eaf/finance/index_reject";
		$data['pageTitle'] = "Reject Finance | EAF";
		$data['css'] = "eaf/finance/css";
		$data['js'] = "eaf/finance/js_reject";

		$this->load->view("main", $data);
	}

	function list_reject()
	{
		$data['content'] = "eaf/finance/list_reject";
		$data['pageTitle'] = "Reject Finance | EAF";
		$data['css'] = "eaf/finance/css";
		$data['js'] = "eaf/finance/list_reject_js";

		$this->load->view("layout/main", $data);
	}

	function list_approval()
	{
		$data['content'] = "eaf/finance/list_approval";
		$data['pageTitle'] = "List Approval Finance | EAF";
		$data['css'] = "eaf/finance/css";
		$data['js'] = "eaf/finance/list_approval_js";

		$this->load->view("layout/main", $data);
	}

	function get_list_approval()
	{
		$datestart = $_POST['datestart'];
		$dateend = $_POST['dateend'];
		$status = $_POST['status'];

		$result['data'] = $this->model_finance->get_list_approval($datestart, $dateend, $status);
		echo json_encode($result);
	}

	function get_detail_list_approval($id, $type)
	{
		if ($type == 1) {
			$result = $this->model_finance->get_detail_list_approval($id);
		} else if ($type == 2) {
			$result = $this->model_finance->get_detail_list_approval_lpj($id);
		}
		echo json_encode($result);
	}

	function get_list_eaf()
	{
		$id_user = $this->session->userdata('user_id');
		$id_div = $this->session->userdata('id_divisi');
		$status = $_POST['status'];
		$datestart = $_POST['datestart'];
		$dateend = $_POST['dateend'];

		$data = $this->model_finance->get_list_eaf($id_user, $id_div, $status, $datestart, $dateend);
		echo json_encode($data);
	}

	function get_list_eaf_my_approval($tipe)
	{
		$id_user = $this->session->userdata('user_id');
		$id_div = $this->session->userdata('id_divisi');
		$status = $_POST['status'];
		$datestart = $_POST['datestart'];
		$dateend = $_POST['dateend'];

		$data = $this->model_finance->get_list_eaf_my_approval($id_user, $id_div, $status, $datestart, $dateend, $tipe);
		echo json_encode($data);
	}

	function get_list_eaf_all()
	{
		$id_user = $this->session->userdata('user_id');
		$id_div = $this->session->userdata('id_divisi');
		$status = $_POST['status'];
		$datestart = $_POST['datestart'];
		$dateend = $_POST['dateend'];

		$data = $this->model_finance->get_list_eaf_all($id_user, $id_div, $status, $datestart, $dateend);
		echo json_encode($data);
	}

	function get_tracking()
	{
		$id = $_POST['id'];
		$data = $this->model_finance->get_tracking($id);
		echo json_encode($data);
	}

	function get_history()
	{
		$id = $_POST['id_biaya'];
		$data = $this->model_finance->get_history($id);
		echo json_encode($data);
	}

	function get_lpj()
	{
		$id = $_POST['id'];
		$data = $this->model_finance->get_lpj($id);
		echo json_encode($data);
	}

	function get_subbiaya()
	{
		$id = $_POST['id_jenis'];
		$data = $this->model_finance->get_subbiaya($id);
		echo json_encode($data);
	}

	function insert_approval_finance()
	{
		// date_default_timezone_set('Asia/Jakarta');
		// $tanggal        = date("Y-m-d  H:i:s");

		$id_user = $this->session->userdata('user_id');
		// $dpr      				= $this->session->userdata('id_divisi');
		$tgl_approve = date('Y-m-d H:i:s');

		$id_pengajuan = $_POST['id_pengajuan_hide'];
		$status = $_POST['status'];
		$id_biaya = $_POST['get_id_biaya'];
		$id_budget = $_POST['get_id_budget'];
		$id_subbiaya = $_POST['get_id_subbiaya'];

		if ($status == 3) {
			$status_approval = 'Approve';
		} else if ($status == 5) {
			$status_approval = 'Reject';
		}

		$row = $this->model_finance->get_id_approval_null($id_pengajuan);
		$id_approval = $row['id_approval'];

		$note_approve = str_replace(array('\'', '"'), array('`', '``'), $_POST['note_approval']);
		$nominal_new = str_replace(".", "", $_POST['get_nominal']);

		$this->db->trans_start();

		try {
			if ($status == 3) {

				if ($_POST['sisa_new'] == '~' || $status == 5) {
					$sisa = null;
				} else {
					// $sisa = str_replace(".", "", $_POST['sisa_new']);
					$cek_sisa = $this->model_finance->check_sisa_budget($id_biaya);
					$sisa = $cek_sisa['budget'] - intval($nominal_new);
					$this->db->where('id_biaya', $id_biaya);
					$result['update_biaya'] = $this->db->update('e_eaf.e_biaya', array('budget' => $sisa));
				}

				if ($_POST['nota'] == "" || $_POST['nota'] == null) {
					$name = NULL;
				} else {
					$string = $_POST['nota'];
					define('UPLOAD_DIR', './uploads/eaf/');
					$string = explode(',', $string);
					$img = str_replace(' ', '+', $string[1]);
					$data = base64_decode($img);
					$name = uniqid() . '.' . $string[0];
					$file = UPLOAD_DIR . $name;
					$success = file_put_contents($file, $data);
				}

				$data_pengajuan = array(
					"status" => $status,
					"id_biaya" => $id_biaya,
					"id_sub_biaya" => $id_subbiaya,
					// "budget"			=> $id_budget,
					// "sub_biaya"			=> $id_subbiaya,
					"note" => $note_approve,
					'total_pengajuan' => $nominal_new,
					'bukti_tf' => $name
				);

				$data_keperluan = array(
					"nominal_uang" => $nominal_new,
					"nama_keperluan" => $_POST['keperluan']
				);

				$data_appr_update = array(
					'level' => 5,
					'status' => $status_approval,
					'update_approve' => $tgl_approve,
					"note_approve" => $note_approve,
					'id_user' => $id_user
				);

				$data_appr_insert = array(
					'id_biaya' => $id_biaya,
					"id_sub_biaya" => $id_subbiaya,
					'nominal_approve' => $nominal_new,
					'flag' => 'Pengajuan'
				);

				$this->db->where('id_pengajuan', $id_pengajuan);
				$result['update_pengajuan'] = $this->db->update('e_eaf.e_pengajuan', $data_pengajuan);

				$this->db->where('id_approval', $id_approval);
				$result['update_approval'] = $this->db->update('e_eaf.e_approval', $data_appr_update);

				$this->db->where('id_pengajuan', $id_pengajuan);
				$result['update_nominal'] = $this->db->update('e_eaf.e_detail_keperluan', $data_keperluan);

				$result['insert_detail_biaya'] = $this->db->insert('e_eaf.e_detail_biaya', $data_appr_insert);
				// if($id_user != 1){
				// 	$result['data']['insert_eces'] = $this->save_to_eces();
				// }

				if ($_POST['kategori'] == 'Pinjaman Karyawan (CR)') {
					$ck = $this->model_finance->cek_nominal_pinjaman($id_pengajuan);
					for ($i = $ck['awal']; $i < $ck['jumlah_termin']; $i++) {
						$data_pinjaman_karyawan = array(
							'id_pengajuan' => $id_pengajuan,
							'id_hr' => $ck['pengaju'],
							'nominal' => $ck['nominal_termin'],
							'periode' => date('Y-m', strtotime('+' . $i . ' months')),
							'status' => 'Belum Terbayar',
							'created_at' => date('Y-m-d H:i:s'),
							'created_by' => $id_user,
						);
						$result['insert_pinjaman_karyawan'] = $this->db->insert('e_eaf.e_pinjaman_karyawan', $data_pinjaman_karyawan);
					}
				}
			} else if ($status == 5) {
				$data_pengajuan = array(
					"status" => $status,
					"note" => $note_approve
				);
				$data_appr_update = array(
					'level' => 5,
					'status' => 'Reject',
					'update_approve' => $tgl_approve,
					"note_approve" => $note_approve,
					'id_user' => $id_user
				);
				$this->db->where('id_pengajuan', $id_pengajuan);
				$result['update_pengajuan'] = $this->db->update('e_eaf.e_pengajuan', $data_pengajuan);

				$this->db->where('id_approval', $id_approval);
				$result['update_approval'] = $this->db->update('e_eaf.e_approval', $data_appr_update);
			}

			if ($result['update_pengajuan']) {
				$result['data'] = $this->model_finance->get_approval_for_wa($id_pengajuan);
			}

			$this->db->trans_commit();

			echo json_encode($result);
		} catch (Exception $e) {
			// An error occurred, roll back the transaction
			$this->db->trans_rollback();

			// echo 'Transaction failed. Error: ' . $e->getMessage();
			$result['update_pengajuan'] = null;
			$result['update_approval'] = null;
			$result['update_nominal'] = null;
			$result['insert_detail_biaya'] = null;
			// $result['data']['insert_eces'] = null;

			echo json_encode($result);
		}
	}

	function insert_app_reject()
	{
		$id_user = $this->session->userdata('user_id');
		// $dpr      				= $this->session->userdata('id_divisi');
		$tgl_approve = date('Y-m-d H:i:s');

		$id_pengajuan = $_POST['id_pengajuan_hide'];
		$id_biaya = $_POST['id_biaya'];
		$note_reject = $_POST['note_reject'];
		$nominal_old = str_replace(".", "", $_POST['nominal_old']);

		$data_pengajuan = array(
			"status" => 2,
			// "id_biaya"			=> null,
			// "id_sub_biaya"		=> null,
			// "total_pengajuan"	=> null,
		);

		// $data_appr_insert = array(
		// 		'id_pengajuan' 		=> $id_pengajuan,
		// 		'id_user_approval'	=> 737,
		// 		'level' 			=> 5,
		// 		'status' 			=> 'Reject',
		// 		'update_approve' 	=> $tgl_approve,
		// 		"note_approve" 		=> $note_reject,
		// 		'flag'				=> 'Pengajuan',
		// 		'id_user' 			=> $id_user
		// 	);

		$data_appr_update = array(
			// 'level' 			=> null,
			'status' => null,
			'update_approve' => null,
			"note_approve" => null,
			// 'flag'				=> 'Pengajuan',
			'id_user' => null
		);


		$this->db->where('id_pengajuan', $id_pengajuan);
		$result['update_pengajuan'] = $this->db->update('e_eaf.e_pengajuan', $data_pengajuan);

		$this->db->where('id_pengajuan', $id_pengajuan);
		// $this->db->where('id_user_approval', 737);
		$this->db->where('status', 'Approve');
		$this->db->where('level', '5');
		$result['update_approval'] = $this->db->update('e_eaf.e_approval', $data_appr_update);

		$cek_sisa = $this->model_finance->check_sisa_budget($id_biaya);
		if ($cek_sisa['budget'] != null) {
			$sisa = $cek_sisa['budget'] + intval($nominal_old);
			$this->db->where('id_biaya', $id_biaya);
			$result['update_biaya'] = $this->db->update('e_eaf.e_biaya', array('budget' => $sisa));
		}

		// if ($result['update_pengajuan']){
		// 	$result['data'] = $this->model_finance->get_approval_for_wa($id_pengajuan);
		// }

		echo json_encode($result);
	}



	// Update oleh Faisal 08.08 15/08/2023
	function insert_approval_lpj()
	{
		$id_lpj = $_POST['id_pengajuan_lpj_hide'];
		$lpj = $this->model_finance->cek_lpj($id_lpj);
		$budget = $lpj['budget'];
		$id_biaya = $lpj['id_biaya'];
		// $selisih_aju_lpj 		= $lpj['selisih_aju_lpj'];
		$flag = $lpj['flag'];
		$id_tipe_biaya = $lpj['id_tipe_biaya'];
		$nama_tipe_biaya = $lpj['nama_tipe_biaya'];
		$id_approval = $lpj['id_approval'];
		$id_aju = $lpj['id_aju'];

		$nominal_aju = str_replace('.', '', $_POST['total_kep']); // Nominal Pengajuan

		// Insert e_pengajuan
		$status = $_POST['status_lpj'];
		$nominal_lpj = str_replace('.', '', $_POST['budget_lpj']); // Nominal LPJ

		// New Selisih
		$selisih_aju_lpj = intval($nominal_aju) - intval($nominal_lpj);

		// Update e_approval
		$tgl_approve = date('Y-m-d H:i:s');
		$note_approve = $_POST['note_approval_lpj'];
		$id_user = $this->session->userdata('user_id');

		// Insert detail_biaya
		$nominal_selisih = str_replace('.', '', $_POST['total_lpj']); // Selisih Pengajuan dan Budget

		// Untuk Kondisional Eksekusi Warning
		$eksekusi = true;

		if ($status == 7) {
			if (($id_tipe_biaya == 2 || $id_tipe_biaya == 3) && $budget != null) {
				$eksekusi = false;
				$cek_sisa = $this->model_finance->check_sisa_budget($id_biaya);
				$budget_akhir = $cek_sisa['budget'] + $selisih_aju_lpj;
				if ($budget_akhir >= $selisih_aju_lpj && $budget_akhir >= 0) {
					$eksekusi = true;
					$this->db->where('id_biaya', $id_biaya);
					$result['update_biaya_now'] = $this->db->update('e_eaf.e_biaya', array('budget' => $budget_akhir));
				}
			}

			// 1	Unlimited
			// 2	Mingguan
			// 3	Bulanan
			// 4	Pengajuan
			if ((($id_tipe_biaya == 2 || $id_tipe_biaya == 3) && $budget != null && $eksekusi) || (($id_tipe_biaya == 1 || $id_tipe_biaya == 4) && $budget == null)) {
				$data_lpj = array(
					"status" => '7',
					// "note" 				=> $note_approve,
					'total_pengajuan' => $nominal_lpj,
					// 'cashback'			=> $cashback
				);

				$data_appr_update = array(
					'level' => 5,
					'status' => 'Approve',
					'update_approve' => $tgl_approve,
					"note_approve" => $note_approve,
					'id_user' => $id_user
				);

				$data_appr_insert = array(
					'id_biaya' => $id_biaya,
					'nominal_approve' => $nominal_selisih,
					'flag' => $flag
				);

				// echo "<pre>";
				// print_r($data_appr_insert);
				// echo "</pre>";

				// When Oke, Aktifkan ini (Insert ke Eces)
				// $this->save_to_eces($id_pengajuan_lpj);

				$this->db->where('id_pengajuan', $id_lpj);
				$result['update_pengajuan'] = $this->db->update('e_eaf.e_pengajuan', $data_lpj);

				$this->db->where('id_lpj', $id_lpj);
				$result['update_pengajuan'] = $this->db->update('e_eaf.e_header_lpj', array('nominal_lpj' => $nominal_lpj));

				$this->db->where('id_pengajuan', $id_lpj);
				$this->db->where('id_approval', $id_approval);
				$result['update_approval'] = $this->db->update('e_eaf.e_approval', $data_appr_update);
				$result['insert_detail_biaya'] = $this->db->insert('e_eaf.e_detail_biaya', $data_appr_insert);
			} else if (!$eksekusi) {
				$result['update_pengajuan'] = false;
				$result['warning'] = "Nominal LPJ lebih " . "Rp " . number_format(ltrim($budget_akhir, '-'), 0, ',', '.') . " dan Budget Tidak Cukup !!";
			} else {
				$result['update_pengajuan'] = false;
				$tipe_budget = ($budget == null) ? "Unlimited" : "" . $budget . "|Limited";
				$result['warning'] = "Tipe Biaya (" . $nama_tipe_biaya . ") di Menu Jenis Biaya tidak sesuai dengan Sisa Budget (" . $tipe_budget . ") di Menu Budget !!";
			}
		} else if ($status == 13) {
			// Waiting Konfirmasi
			$data_pengajuan = array(
				"status" => 13,
				// "note" 			=> $note_approve
			);

			$data_appr_update = array(
				'level' => 5,
				'status' => 'Konfirmasi',
				'update_approve' => $tgl_approve,
				"note_approve" => $note_approve,
				'id_user' => $id_user
			);

			$data_appr_insert = array(
				'id_pengajuan' => $id_lpj,
				// 'id_user_approval'	=> 737,
				'id_user_approval' => $user_id,
				'level' => 5,
				'flag' => 'LPJ'
			);

			$this->db->where('id_pengajuan', $id_lpj);
			$result['update_pengajuan'] = $this->db->update('e_eaf.e_pengajuan', $data_pengajuan);

			$this->db->where('id_approval', $id_approval);
			$result['update_approval'] = $this->db->update('e_eaf.e_approval', $data_appr_update);
			$result['insert_approval'] = $this->db->insert('e_eaf.e_approval', $data_appr_insert);
		} else {
			// Reject Finance
			$this->db->where('id_pengajuan', $id_aju);
			$this->db->update('e_eaf.e_pengajuan', array('temp' => NULL, 'lpj_pertama' => $id_lpj));

			$data_pengajuan = array(
				"status" => '5',
				// "note" 			=> $note_approve
			);
			$data_appr_update = array(
				'level' => 5,
				'status' => 'Reject',
				'update_approve' => $tgl_approve,
				"note_approve" => $note_approve,
				'id_user' => $id_user
			);
			$this->db->where('id_pengajuan', $id_lpj);
			$result['update_pengajuan'] = $this->db->update('e_eaf.e_pengajuan', $data_pengajuan);

			$this->db->where('id_approval', $id_approval);
			$result['update_approval'] = $this->db->update('e_eaf.e_approval', $data_appr_update);
		}

		$result['eksekusi'] = $eksekusi;

		if ($result['update_pengajuan'] && $eksekusi) {
			$result['det'] = $this->model_finance->get_detail_lpj_for_wa($id_aju); // untuk get data pengaju tanpa id_pengajuan
			$result['data'] = $this->model_finance->get_lpj_for_wa($id_lpj); // untuk get data send wa dengan id_lpj
		}

		echo json_encode($result);
	}


	// public function save_to_eces($id_pengajuan)
	// {
	// 	// $id_pengajuan = $this->uri->segment(4);
	// 	// echo $id_pengajuan;
	// 	// die();
	// 	$dataPengajuan = $this->db->query("SELECT
	// 		e_pengajuan.id_pengajuan,
	// 		eaf.pengaju,
	// 		e_pengajuan.nama_penerima,
	// 		e_kategori.nama_kategori,
	// 		e_detail_keperluan.nama_keperluan,
	// 		e_pengajuan.total_pengajuan,
	// 		e_m_akun.id_coa_eces,
	// 		e_pengajuan.jurnal_eces
	// 		FROM
	// 		e_pengajuan
	// 		LEFT JOIN e_pengajuan eaf on eaf.temp = e_pengajuan.id_pengajuan
	// 		LEFT JOIN e_detail_keperluan ON e_detail_keperluan.id_lpj = e_pengajuan.id_pengajuan
	// 		LEFT JOIN e_jenis_biaya ON e_jenis_biaya.id_jenis = e_pengajuan.jenis
	// 		LEFT JOIN e_m_akun ON e_m_akun.id_akun = e_jenis_biaya.id_akun
	// 		LEFT JOIN e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
	// 		WHERE
	// 		e_pengajuan.id_pengajuan = '$id_pengajuan'")->row();

	// 	if ($dataPengajuan->jurnal_eces == null) {
	// 		$eces = $this->load->database('db_eces_live', TRUE);
	// 		$user_id = $dataPengajuan->pengaju;
	// 		$cari__nama_pemohon = $this->db->query("SELECT CONCAT( hris.xin_employees.first_name, ' ', hris.xin_employees.last_name ) AS pemohon FROM `hris.xin_employees` WHERE user_id = '$user_id'")->row();
	// 		$paid_at = date("Y-m-d");
	// 		$rincian = $dataPengajuan->nama_keperluan;
	// 		$pemohon = $cari__nama_pemohon->pemohon;
	// 		$penerima = $dataPengajuan->nama_penerima;
	// 		$kategori = $dataPengajuan->nama_kategori;
	// 		$ju_desc = '-';

	// 		$nominal_paid = $dataPengajuan->total_pengajuan;


	// 		$coa_id_d = $dataPengajuan->id_coa_eces;
	// 		$tgl_bayar_eces = $paid_at . ' 00:00:00';
	// 		$tgl_input_eces = date('Y-m-d') . ' 00:00:00';
	// 		$tahun_eces = date('Y', strtotime($paid_at));
	// 		$ju_no = $this->last_ju_no($paid_at);
	// 		$ju_no_bkt = '';
	// 		$keterangan_eces = "[Pemohon : " . $pemohon . "] [Penerima : " . $penerima . "] [" . $kategori . "] " . $rincian;
	// 		$ju_id = $this->last_ju_id();


	// 		$ju_id_no = 0;
	// 		$ju_id_no = $ju_id_no + 1;


	// 		$debit = array(
	// 			"ju_id" => $ju_id,
	// 			"ju_idno" => $ju_id_no,
	// 			"ju_idurut" => $ju_id_no,
	// 			"coa_id_d" => $coa_id_d,
	// 			"coa_id_k" => $coa_id_d,
	// 			"ju_nom_d" => $nominal_paid, // jumlah nominal paid
	// 			"ju_nom_k" => 0,
	// 			"tran_jns" => 1302,
	// 			"ju_tgl" => $tgl_bayar_eces,
	// 			"ju_no" => $ju_no,
	// 			"ju_tgl_bkt" => $tgl_bayar_eces,
	// 			"ju_no_bkt" => '',
	// 			"ju_desc" => $ju_desc,
	// 			"ju_ket" => $keterangan_eces,
	// 			"ju_jns" => 704,
	// 			"ju_stat" => 2,
	// 			"ju_app" => 2,
	// 			"cf_id" => 0,
	// 			"ju_rate" => 1,
	// 			"mtu_id" => 1,
	// 			"cab_id" => 59,
	// 			"prj_id" => 1,
	// 			"org_id" => '591',
	// 			"ang_thn" => $tahun_eces,
	// 			"usr_id" => 50, // user id siapa?
	// 			"ju_update" => $tgl_input_eces,
	// 			"ma_id" => $coa_id_d,
	// 			"by_id" => 0,
	// 			"rsck_id" => 'S197', // id vendor di eces
	// 			"ju_nom_d2" => $nominal_paid, // jumlah nominal paid
	// 			"ju_nom_k2" => 0,
	// 			"mtu_id2" => 1,
	// 			"ju_ket2" => $ju_desc,
	// 		);
	// 		$data['insert_tt_ju_temp_debit'] = $eces->insert('tt_ju_temp', $debit);
	// 		$data['debit'] = $debit;


	// 		$bk_d = array(
	// 			"bk_id" => $ju_id,
	// 			"bkd_id" => $ju_id_no,
	// 			"coa_id" => $coa_id_d,
	// 			"bkd_ref" => '',
	// 			"bkd_tgl" => $tgl_bayar_eces,
	// 			"bkd_debet" => 0,
	// 			"bkd_kredit" => $nominal_paid,
	// 			"bkd_ket" => $keterangan_eces,
	// 			"mtu_id" => 1,
	// 			"org_id" => 0,
	// 			"by_id" => 0,
	// 			"prop_id" => NULL,
	// 		);

	// 		$data['bk_d'] = $bk_d;

	// 		$data['insert_tt_bk_d'] = $eces->insert('tt_bk_d', $bk_d);


	// 		// update field jurnal_eces t_tagihan
	// 		$jurnal_eces = array(
	// 			'jurnal_eces' => $ju_no
	// 		);
	// 		$this->db->where('id_pengajuan', $id_pengajuan);
	// 		$data['update_jurnal_eces'] = $this->db->update('e_pengajuan', $jurnal_eces);

	// 		$ju_id_no = $ju_id_no + 1;
	// 		$kredit = array(
	// 			"ju_id" => $ju_id,
	// 			"ju_idno" => $ju_id_no,
	// 			"ju_idurut" => $ju_id_no,
	// 			"coa_id_d" => 4, // cash
	// 			"coa_id_k" => 0,
	// 			"ju_nom_d" => 0,
	// 			"ju_nom_k" => $nominal_paid,
	// 			"tran_jns" => 1302,
	// 			"ju_tgl" => $tgl_bayar_eces,
	// 			"ju_no" => $ju_no,
	// 			"ju_tgl_bkt" => $tgl_bayar_eces,
	// 			"ju_no_bkt" => '',
	// 			"ju_desc" => $ju_desc,
	// 			"ju_ket" => $keterangan_eces,
	// 			"ju_jns" => 704,
	// 			"ju_stat" => 2,
	// 			"ju_app" => 2,
	// 			"cf_id" => 0,
	// 			"ju_rate" => 1,
	// 			"mtu_id" => 1,
	// 			"cab_id" => 59,
	// 			"prj_id" => 1,
	// 			"org_id" => '591',
	// 			"ang_thn" => $tahun_eces,
	// 			"usr_id" => 50,
	// 			"ju_update" => $tgl_input_eces,
	// 			"ma_id" => 0,
	// 			"by_id" => 0,
	// 			"rsck_id" => 'R491', // RSP
	// 			"ju_nom_d2" => 0,
	// 			"ju_nom_k2" => $nominal_paid,
	// 			"mtu_id2" => 1,
	// 			"ju_ket2" => $keterangan_eces,
	// 		);
	// 		$data['kredit'] = $kredit;
	// 		$data['insert_tt_ju_temp_kredit'] = $eces->insert('tt_ju_temp', $kredit);


	// 		$kasbank = array(
	// 			"id" => $ju_id,
	// 			"tran_jns" => '1302',
	// 			"no_trx" => $ju_no,
	// 		);

	// 		$data['kasbank'] = $kasbank;

	// 		$data['insert_tt_no_kasbank_kasbank'] = $eces->insert('tt_no_kasbank', $kasbank);

	// 		$bk_h = array(
	// 			"bk_id" => $ju_id,
	// 			"tran_jns" => 1302,
	// 			"bk_no" => $ju_no,
	// 			"bk_tgl" => $tgl_bayar_eces,
	// 			"bk_nm" => $ju_desc,
	// 			"bk_rate" => 1,
	// 			"bk_rek" => 'KAS RSP',
	// 			"bk_giro" => '',
	// 			"prj_id" => 1,
	// 			"prj_nm" => 'RSP001*HOLDING',
	// 			"bnk_id" => 491,
	// 			"bnk_nm" => 'KAS001*KAS',
	// 			"bk_ket" => $keterangan_eces,
	// 			"coa_id" => 4,
	// 			"ma_id" => 0,
	// 			"mtu_id" => 1,
	// 			"org_id" => '591',
	// 			"org_nm" => 'RSP000*-',
	// 			"cab_id" => 59,
	// 			"bk_bk" => 'K',
	// 			"bk_crbyr" => 25,
	// 			"usr_id" => 50,
	// 			"by_id" => 0,
	// 			"rekanan_id" => '197',
	// 			"rekanan_tipe" => 'S',
	// 			"bk_nom" => $nominal_paid,
	// 			"bk_ppnnom" => 0,
	// 			"bk_pph" => 0,
	// 			"bk_pph_persen" => 0,
	// 			"bk_pphnom" => 0,
	// 			"bk_materai" => 0,
	// 			"bk_pot_pph" => 0,
	// 			"bk_pot_nom" => 0,
	// 			"coa_id_pot" => 0,
	// 			"bk_e_nom" => $nominal_paid,
	// 			"bk_e_nomppn" => 0,
	// 			"bk_e_nommaterai" => 0,
	// 			"bk_e_nompph" => 0,
	// 			"bk_e_pot_nom" => 0,
	// 			"bk_selisihkurs_nom" => 0,
	// 			"coa_id_selisihkurs" => 0,
	// 			"bk_isgiro" => 0,
	// 			"bk_noref" => NULL,
	// 			"bk_tglref" => NULL,
	// 			"ppn_persen" => 0,
	// 		);

	// 		$data['bk_h'] = $bk_h;

	// 		$data['insert_tt_bk_h'] = $eces->insert('tt_bk_h', $bk_h);

	// 		$uid = array(
	// 			"trx_id" => $ju_id,
	// 			"trx_no" => $ju_no,
	// 			"mn_id" => '710',
	// 			"insert_usr" => 50,
	// 			"update_usr" => NULL,
	// 			"delete_usr" => NULL,
	// 			"insert_wkt" => '2022-12-20 09:53:34',
	// 			"update_wkt" => NULL,
	// 			"delete_wkt" => NULL,
	// 			"insert_pc" => 'DESKTOP-632GKFC / 192.168.23.2',
	// 			"update_pc" => NULL,
	// 			"delete_pc" => NULL,
	// 			"ver_update_insert" => '2017-10-05 08:05',
	// 			"ver_update_update" => NULL,
	// 			"ver_update_delete" => NULL,
	// 			"ip_update_insert" => NULL,
	// 			"ip_update_update" => NULL,
	// 			"ip_update_delete" => NULL,
	// 			"trx_ket" => NULL,
	// 			"trx_ket_del" => NULL,
	// 		);

	// 		$data['uid'] = $uid;

	// 		$data['tt_uid_log'] = $eces->insert('tt_uid_log', $uid);
	// 	} else {
	// 		$data['jurnal_eces'] = "sudah pernah input";
	// 	}
	// 	// echo json_encode($data);
	// }

	// public function last_ju_id()
	// {
	// 	$eces = $this->load->database('db_eces_live', TRUE);
	// 	$data = $eces->query("SELECT max( tt_ju_temp.ju_id ) + 1 AS ju_id FROM tt_ju_temp")->row_array();
	// 	return $data['ju_id'];
	// }

	// public function last_ju_no($tahun_bulan)
	// {
	// 	$eces = $this->load->database('db_eces_live', TRUE);
	// 	$kode_kas = 'KCPLST';
	// 	$kode_terima = 'KK';
	// 	$tahun_bulan = date('ym', strtotime($tahun_bulan));

	// 	$ju_no = $kode_kas . '-' . $kode_terima . '-' . $tahun_bulan;


	// 	$date = date('ymd');
	// 	$q = $eces->query("SELECT
	// 		MAX( RIGHT ( tt_ju_temp.ju_no, 5 ) ) AS kd_max
	// 		FROM
	// 		tt_ju_temp
	// 		WHERE
	// 		tt_ju_temp.ju_no LIKE '$ju_no%'");
	// 	$kd = "";
	// 	if ($q->num_rows() > 0) {
	// 		foreach ($q->result() as $k) {
	// 			$tmp = ((int) $k->kd_max) + 1;
	// 			$max_ju_no = sprintf("%05s", $tmp);
	// 		}
	// 	} else {
	// 		$max_ju_no = "00001";
	// 	}
	// 	return $ju_no . '-' . $max_ju_no;
	// }

	function print_ba()
	{
		$this->load->model('eaf/model_approval', 'model_approval');
		$id = $_GET['id'];
		$data['eaf'] = $this->model_approval->get_ba($id);
		$this->load->view("eaf/ba_lpj", $data);
	}

	function print_ba_reimburse()
	{
		$this->load->model('eaf/model_approval', 'model_approval');
		$id = $_GET['id'];
		$data['eaf'] = $this->model_approval->get_ba_reimburse($id);
		$this->load->view("eaf/ba_reimburse", $data);
	}

	function save_pengajuan($id_pengajuan, $id_kategori, $flag)
	{
		$this->load->model('eaf/model_pengajuan', 'model_pengajuan');

		// $mpdf = new \Mpdf\Mpdf();

		// $mpdf = new \Mpdf\Mpdf([
		// 	    'tempDir' => __DIR__ . '/tmp', // uses the current directory's parent "tmp" subfolder
		// 	]);
		// $pdfFilePath = time().".pdf";

		$id_divisi = $this->session->userdata('id_divisi');

		$id_user_approval = 162;

		date_default_timezone_set('Asia/Jakarta');
		$tanggal = $time = date("Y-m-d  H:i:s");

		$getideaf = $this->model_pengajuan->getideaf();
		$id_user = $this->session->userdata('user_id');

		$data['id_divisi'] = $id_divisi;
		$data['tanggal'] = $tanggal;
		$data['id_user'] = $id_user;
		$data['flag'] = $flag;
		$data['id_pengajuan'] = $id_pengajuan;
		$data['id_kategori'] = $id_kategori;
		$data['nama_divisi'] = $this->model_pengajuan->get_divisi($id_user)->result();
		$data['kategori'] = $this->model_pengajuan->get_kategori()->result();
		if ($flag == 'Pengajuan' || $flag == 'Reject') {
			if ($id_kategori == 17) {
				$data['photo_ba'] = $this->model_pengajuan->get_ba_reimbust($id_pengajuan);
				$data['photo_nota'] = $this->model_pengajuan->get_nota_reimbust($id_pengajuan);
				$data['photo_acc'] = $this->model_pengajuan->get_acc_reimbust($id_pengajuan);
			}
			$data['photo_owner'] = $this->model_pengajuan->get_photo_acc($id_pengajuan);
			$data['detail_eaf'] = $this->model_pengajuan->get_detail_eaf($id_pengajuan);
			$data['detail_keperluan'] = $this->model_pengajuan->get_detail_keperluan_4($id_pengajuan);
			$data['sub_total'] = $this->model_pengajuan->get_sub_total($id_pengajuan);
		} else if ($flag == 'LPJ' || $flag == 'Reject-LPJ') {
			$data['detail_lpj'] = $this->model_pengajuan->get_detail_eaf_lpj($id_pengajuan);
			$data['detail_kep_lpj'] = $this->model_pengajuan->get_kep_lpj($id_pengajuan);
			$data['sub_total_2'] = $this->model_pengajuan->get_sub_total_lpj($id_pengajuan);
			$data['detail_keperluan_2'] = $this->model_pengajuan->get_detail_keperluan($id_pengajuan);
			$data['get_nota'] = $this->model_pengajuan->get_nota_lpj($id_pengajuan);
			$data['get_owner'] = $this->model_pengajuan->get_owner_lpj($id_pengajuan);
			$data['detail_approval_peng'] = $this->model_pengajuan->get_approval_peng($id_pengajuan)->result_array();
		}

		$nama_approve = $this->model_pengajuan->get_approval_2($id_pengajuan, $id_user_approval)->result_array();

		foreach ($nama_approve as $key_approve) {
			$nama_finance = $key_approve['name'];
		}
		if (empty($nama_approve)) {
			$data['nama_finance'] = 'Belum Approve Finance';
		} else {
			$data['nama_finance'] = $nama_finance;
		}
		$nama_penerima = $this->model_pengajuan->get_nama_penerima($id_pengajuan)->result_array();

		foreach ($nama_penerima as $key_penerima) {
			$penerima = $key_penerima['nama_penerima'];
		}
		if (empty($nama_penerima)) {
			$data['penerima'] = '';
		} else {
			$data['penerima'] = $penerima;
		}
		$nama_pembuat = $this->model_pengajuan->get_nama_pembuat_new($id_pengajuan)->row_array();
		$nama_approve = $this->model_pengajuan->get_nama_approve($id_pengajuan)->row_array();
		$nama_finance = $this->model_pengajuan->get_nama_approve_finance($id_pengajuan)->row_array();


		$data['pembuat'] = $nama_pembuat['nama_penerima'];
		$data['tgl_pembuat'] = $nama_pembuat['tgl_input'];

		$data['approve'] = $nama_approve['name'];
		$data['tgl_approve'] = $nama_approve['update_approve'];

		$data['finance'] = $nama_finance['name'];
		$data['note_finance'] = $nama_finance['note_approve'];
		$data['tgl_finance'] = $nama_finance['update_approve'];

		$data['detail_approval'] = $this->model_pengajuan->get_approval($id_pengajuan)->result_array();


		// $this->load->view('eaf/temp_pdf_dev', $data);
		$this->load->view("eaf/temp_pdf", $data);


		// $mpdf->WriteHTML($html);
		// $mpdf->Output();
	}



	function get_karyawan()
	{
		$data = $this->model_finance->get_karyawan()->result();
		echo json_encode($data);
	}

	// function get_rekanan()
	// {
	// 	$data = $this->model_finance->get_rekanan()->result();
	// 	echo json_encode($data);
	// }

	// function get_rekening()
	// {
	// 	$type = $_POST['tipe'];

	// 	$data = $this->model_finance->get_rekening($type)->result();
	// 	echo json_encode($data);
	// }

	// public function last_ju_no($rek_kd, $type_bayar_eces, $tahun_bulan)
	// {
	// 	$eces = $this->load->database('db_eces_live', TRUE);
	// 	$kode_kas = $rek_kd;
	// 	$kode_bayar = $type_bayar_eces;
	// 	$tahun_bulan = date('ym', strtotime($tahun_bulan));

	// 	$ju_no =  $kode_kas . '-' . $kode_bayar . '-' . $tahun_bulan;


	// 	$date = date('ymd');
	// 	$q = $eces->query("SELECT
	// 		MAX( RIGHT ( tt_ju_temp.ju_no, 5 ) ) AS kd_max 
	// 	FROM
	// 		tt_ju_temp 
	// 	WHERE
	// 		tt_ju_temp.ju_no LIKE '$ju_no%'");
	// 	$kd = "";
	// 	if ($q->num_rows() > 0) {
	// 		foreach ($q->result() as $k) {
	// 			$tmp = ((int) $k->kd_max) + 1;
	// 			$max_ju_no = sprintf("%05s", $tmp);
	// 		}
	// 	} else {
	// 		$max_ju_no = "00001";
	// 	}
	// 	return $ju_no . '-' . $max_ju_no;
	// }

	// public function last_ju_no_bkt($tahun_bulan)
	// {
	// 	$eces = $this->load->database('db_eces_live', TRUE);
	// 	$kode_kas = 'KCLPST';
	// 	$kode_terima = 'KK';
	// 	$tahun_bulan = date('ym', strtotime($tahun_bulan));

	// 	$ju_no =  $kode_kas . '-' . $kode_terima . '-' . $tahun_bulan;


	// 	$date = date('ymd');
	// 	$q = $eces->query("SELECT
	// 		MAX( RIGHT ( tt_ju_temp.ju_no, 5 ) ) AS kd_max 
	// 	FROM
	// 		tt_ju_temp 
	// 	WHERE
	// 		tt_ju_temp.ju_no LIKE '$ju_no%'");
	// 	$kd = "";
	// 	if ($q->num_rows() > 0) {
	// 		foreach ($q->result() as $k) {
	// 			$tmp = ((int) $k->kd_max) + 1;
	// 			$max_ju_no = sprintf("%05s", $tmp);
	// 		}
	// 	} else {
	// 		$max_ju_no = "00001";
	// 	}
	// 	return $ju_no . '-' . $max_ju_no;
	// }

	// public function last_ju_id()
	// {
	// 	$eces = $this->load->database('db_eces_live', TRUE);

	// 	$data = $eces->query("SELECT
	// 	CASE
	// 		WHEN
	// 			max( tt_uid_log.trx_id ) != '' THEN
	// 				CONCAT( DATE_FORMAT( CURRENT_DATE, '%y%m' ), SUBSTR(max( tt_uid_log.trx_id ),5) + 2) ELSE CONCAT( DATE_FORMAT( CURRENT_DATE, '%y%m' ), 1 ) 
	// 				END AS ju_id 
	// 		FROM
	// 			tt_uid_log 
	// 		WHERE
	// 			SUBSTR(trx_id,1,4) = REPLACE(SUBSTR(CURRENT_DATE,3,5),'-','')")->row_array();

	// 	return $data['ju_id'];
	// }

	// public function save_to_eces()
	// {
	// 	// Create Connection to database ECES
	// 	$id_eces = $this->session->userdata('id_eces');
	// 	if ($id_eces != null || $id_eces != '') {
	// 		$usr_id = $id_eces;
	// 	} else {
	// 		$usr_id = 52;
	// 	}

	// 	$eces = $this->load->database('db_eces_live', TRUE);

	// 	// Tipe Bayar Cash = KK (Kas Keluar) | Transfer = BK (Bank Keluar)
	// 	$tipe_bayar = $this->input->post('tipe');
	// 	if ($tipe_bayar == 'Tunai') {
	// 		$type_bayar_eces = 'KK';
	// 	} else {
	// 		$type_bayar_eces = 'BK';
	// 	}

	// 	$rek_id = $this->input->post('rek_eces');
	// 	$get_rek_kd = $eces->query("SELECT rek_kd, bnk_id, rek_nomor FROM tm_rekening WHERE rek_id = '$rek_id'")->row();
	// 	$rek_kd = $get_rek_kd->rek_kd;
	// 	$bnk_id = $get_rek_kd->bnk_id;
	// 	$rek_nomor = $get_rek_kd->rek_nomor;
	// 	$get_bank = $eces->query("SELECT bnk_id, bnk_kd, bnk_nm FROM tm_bank WHERE bnk_id = '$bnk_id'")->row();
	// 	$bnk_nm = $get_bank->bnk_kd . "*" . $get_bank->bnk_nm;
	// 	$paid_at = date('Y-m-d') . ' 00:00:00';
	// 	$ju_no = $this->last_ju_no($rek_kd, $type_bayar_eces, $paid_at);


	// 	$rincian = $this->input->post('note_approval_eces');

	// 	$nominal_paid = $this->input->post('total');
	// 	$penerima_eces = $this->input->post('penerima_eces');
	// 	$keterangan_global = $this->input->post('note_approval_eces');
	// 	$paid_at = date('Y-m-d') . ' 00:00:00';
	// 	// $prj_eces_array = $this->input->post('prj_eces');
	// 	$prj_eces = $this->input->post('id_project_eces');
	// 	$id_coa		  = $this->input->post('coa_id');
	// 	if ($type_bayar_eces == 'KK') {
	// 		$coa_id_d              = 4;
	// 		$bk_crbyr              = 25;
	// 	} else {
	// 		$coa_id_d              = 5;
	// 		$bk_crbyr              = 27;
	// 	}
	// 	$tgl_bayar_eces        = date('Y-m-d') . ' 00:00:00';
	// 	$tgl_input_eces        = date('Y-m-d') . ' 00:00:00';
	// 	$tahun_eces            = date('Y');
	// 	$ju_no                 = $ju_no;
	// 	$keterangan_eces       = $keterangan_global;
	// 	$ju_ket 				= $this->input->post('note_approval_eces');
	// 	$ju_id 					= $this->last_ju_id();

	// 	// $kry_id = ltrim($penerima_eces, 'K');
	// 	// $generateJuDesc = $eces->query("SELECT CONCAT( tm_karyawan.kry_kd, '*', tm_karyawan.kry_nm ) AS ju_desc FROM tm_karyawan WHERE kry_id = '$kry_id'")->row();

	// 	$rekanan_id = substr($penerima_eces,1);
	// 	$generateJuDesc = $eces->query("SELECT ju_desc FROM (SELECT CONCAT('K',kry_id) AS rekanan_id, CONCAT( tm_karyawan.kry_kd, '*', tm_karyawan.kry_nm ) AS ju_desc FROM tm_karyawan UNION SELECT CONCAT('S',sup_id) AS rekanan_id, CONCAT( tm_supplier.sup_kd, '*', tm_supplier.sup_nm ) AS ju_desc FROM tm_supplier) rekanan WHERE rekanan_id = '$penerima_eces'")->row();
	// 	$ju_desc = $generateJuDesc->ju_desc;

	// 	$generatePrjNm = $eces->query("SELECT CONCAT( tm_project.prj_kd, '*', tm_project.prj_nm ) AS prj_nm FROM tm_project WHERE tm_project.prj_id = '$prj_eces'")->row();
	// 	$prj_nm = $generatePrjNm->prj_nm;
	// 	$total = $this->input->post('total');
	// 	$jum_no_d 		= str_replace('.', '', $total);
	// 	$total_paid     = str_replace('.', '', $total);

	// 	$this->db->trans_start();
	// 	// coa id = 243
	// 	$ju_id_no = 0;
	// 	$ju_id_no = $ju_id_no + 1;
	// 	$debit = array(
	// 		"ju_id"            => $ju_id,
	// 		"ju_idno"          => $ju_id_no,
	// 		"ju_idurut"        => $ju_id_no,
	// 		"coa_id_d"         => $id_coa,
	// 		"coa_id_k"         => $id_coa,
	// 		"ju_nom_d"         => $jum_no_d, // jumlah nominal paid
	// 		"ju_nom_k"         => 0,
	// 		"tran_jns"         => 1302,
	// 		"ju_tgl"           => $tgl_bayar_eces,
	// 		"ju_no"            => $ju_no,
	// 		"ju_tgl_bkt"       => $tgl_bayar_eces,
	// 		"ju_no_bkt"        => '',
	// 		"ju_desc"          => $ju_desc,
	// 		"ju_ket"           => $keterangan_global,
	// 		"ju_jns"           => 704,
	// 		"ju_stat"          => 0,
	// 		"ju_app"           => -1,
	// 		"cf_id"            => 0,
	// 		"ju_rate"          => 1,
	// 		"mtu_id"           => 1,
	// 		"cab_id"           => 59,
	// 		"prj_id"           => $prj_eces,
	// 		"org_id"           => 591,
	// 		"ang_thn"          => $tahun_eces,
	// 		"usr_id"           => $usr_id, // user id siapa?
	// 		"ju_update"        => $tgl_input_eces,
	// 		"ma_id"            => 43,
	// 		"by_id"            => 0,
	// 		"rsck_id"          => $penerima_eces, // id karyawan di eces 
	// 		// "rsck_id"          => 'S0',
	// 		"ju_nom_d2"        => $jum_no_d, // jumlah nominal paid
	// 		"ju_nom_k2"        => 0,
	// 		"mtu_id2"          => 1,
	// 		"ju_ket2"          => $ju_ket,
	// 	);
	// 	$data['insert_tt_ju_temp_debit'] =  $eces->insert('tt_ju_temp', $debit);
	// 	$data['debit'] = $debit;


	// 	$bk_d = array(
	// 		"bk_id"         => $ju_id,
	// 		"bkd_id"        => $ju_id_no,
	// 		"coa_id"        => $id_coa,
	// 		"bkd_ref"       => '',
	// 		"bkd_tgl"       => $tgl_bayar_eces,
	// 		"bkd_debet"     => 0,
	// 		"bkd_kredit"    => $jum_no_d,
	// 		"bkd_ket"       => $ju_ket,
	// 		"mtu_id"        => 1,
	// 		"org_id"        => 0,
	// 		"by_id"         => 0,
	// 		"prop_id"       => NULL,
	// 	);

	// 	$data['bk_d'] = $bk_d;

	// 	$data['insert_tt_bk_d'] = $eces->insert('tt_bk_d', $bk_d);


	// 	// update field jurnal_eces t_tagihan
	// 	$jurnal_eces  = array(
	// 		'jurnal_eces'	=> $ju_no,
	// 		'ju_id_eces'	=> $ju_id
	// 	);

	// 	$id_pengajuan = $_POST['id_pengajuan_hide'];
	// 	$this->db->where('id_pengajuan', $id_pengajuan);
	// 	$data['update_jurnal_eces'] = $this->db->update('e_pengajuan', $jurnal_eces);

	// 	$ju_id_no = $ju_id_no + 1;
	// 	$kredit = array(
	// 		"ju_id"         => $ju_id,
	// 		"ju_idno"       => $ju_id_no,
	// 		"ju_idurut"     => $ju_id_no,
	// 		"coa_id_d"      => $coa_id_d, // cash
	// 		"coa_id_k"      => 0,
	// 		"ju_nom_d"      => 0,
	// 		"ju_nom_k"      => $total_paid,
	// 		"tran_jns"      => 1302,
	// 		"ju_tgl"        => $tgl_bayar_eces,
	// 		"ju_no"         => $ju_no,
	// 		"ju_tgl_bkt"    => $tgl_bayar_eces,
	// 		"ju_no_bkt"     => '',
	// 		"ju_desc"       => $ju_desc,
	// 		"ju_ket"        => $keterangan_global,
	// 		"ju_jns"        => 704,
	// 		"ju_stat"       => 0,
	// 		"ju_app"        => -1,
	// 		"cf_id"         => 0,
	// 		"ju_rate"       => 1,
	// 		"mtu_id"        => 1,
	// 		"cab_id"        => 59,
	// 		"prj_id"        => $prj_eces,
	// 		"org_id"        => 591,
	// 		"ang_thn"       => $tahun_eces,
	// 		"usr_id"        => $usr_id,
	// 		"ju_update"     => $tgl_input_eces,
	// 		"ma_id"         => 0,
	// 		"by_id"         => 0,
	// 		"rsck_id"       => "R" . $rek_id, // R = Kode Rekening dari tm_rekening ambil rek_id
	// 		"ju_nom_d2"     => 0,
	// 		"ju_nom_k2"     => $total_paid,
	// 		"mtu_id2"       => 1,
	// 		"ju_ket2"       => $ju_ket,
	// 	);
	// 	$data['kredit'] = $kredit;
	// 	$data['insert_tt_ju_temp_kredit'] = $eces->insert('tt_ju_temp', $kredit);


	// 	$kasbank = array(
	// 		"id"        => $ju_id,
	// 		"tran_jns"  => '1302',
	// 		"no_trx"    => $ju_no,
	// 	);

	// 	$data['kasbank'] = $kasbank;

	// 	$data['insert_tt_no_kasbank_kasbank'] = $eces->insert('tt_no_kasbank', $kasbank);

	// 	$bk_h = array(
	// 		"bk_id"                   => $ju_id,
	// 		"tran_jns"                => 1302,
	// 		"bk_no"                   => $ju_no,
	// 		"bk_tgl"                  => $tgl_bayar_eces,
	// 		"bk_nm"                   => $ju_desc,
	// 		"bk_rate"                 => 1,
	// 		"bk_rek"                  => $rek_nomor,
	// 		"bk_giro"                 => '',
	// 		"prj_id"                  => $prj_eces,
	// 		"prj_nm"                  => $prj_nm,
	// 		"bnk_id"                  => $rek_id,
	// 		"bnk_nm"                  => $bnk_nm,
	// 		"bk_ket"                  => $keterangan_eces,
	// 		"coa_id"                  => $coa_id_d,
	// 		"ma_id"                   => 0,
	// 		"mtu_id"                  => 1,
	// 		"org_id"                  => 591,
	// 		"org_nm"                  => 'RSP000*',
	// 		"cab_id"                  => 59,
	// 		"bk_bk"                   => substr($type_bayar_eces, 0, 1),
	// 		"bk_crbyr"                => $bk_crbyr,
	// 		"usr_id"                  => $usr_id,
	// 		"by_id"                   => 0,
	// 		"rekanan_id"              => $rekanan_id,
	// 		"rekanan_tipe"            => substr($penerima_eces, 0, 1),
	// 		"bk_nom"                  => $total_paid,
	// 		"bk_ppnnom"               => 0,
	// 		"bk_pph"                  => 0,
	// 		"bk_pph_persen"           => 0,
	// 		"bk_pphnom"               => 0,
	// 		"bk_materai"              => 0,
	// 		"bk_pot_pph"              => 0,
	// 		"bk_pot_nom"              => 0,
	// 		"coa_id_pot"              => 0,
	// 		"bk_e_nom"                => $total_paid,
	// 		"bk_e_nomppn"            => 0,
	// 		"bk_e_nommaterai"        => 0,
	// 		"bk_e_nompph"            => 0,
	// 		"bk_e_pot_nom"          => 0,
	// 		"bk_selisihkurs_nom"    => 0,
	// 		"coa_id_selisihkurs"    => 0,
	// 		"bk_isgiro"             => 0,
	// 		"bk_noref"              => NULL,
	// 		"bk_tglref"             => $tgl_bayar_eces,
	// 		"ppn_persen"            => 0,
	// 	);

	// 	$data['bk_h'] = $bk_h;

	// 	$data['insert_tt_bk_h'] = $eces->insert('tt_bk_h', $bk_h);


	// 	$uid = array(
	// 		"trx_id"                => $ju_id,
	// 		"trx_no"                => $ju_no,
	// 		"mn_id"                 => '710',
	// 		"insert_usr"            => $usr_id,
	// 		"update_usr"            => NULL,
	// 		"delete_usr"            => NULL,
	// 		"insert_wkt"            => date("Y-m-d H:i:s"),
	// 		"update_wkt"            => NULL,
	// 		"delete_wkt"            => NULL,
	// 		"insert_pc"             => 'DESKTOP-632GKFC / 192.168.23.2',
	// 		"update_pc"             => NULL,
	// 		"delete_pc"             => NULL,
	// 		"ver_update_insert"     => date("Y-m-d H:i:s"),
	// 		"ver_update_update"     => NULL,
	// 		"ver_update_delete"     => NULL,
	// 		"ip_update_insert"      => NULL,
	// 		"ip_update_update"      => NULL,
	// 		"ip_update_delete"      => NULL,
	// 		"trx_ket"               => NULL,
	// 		"trx_ket_del"           => NULL,
	// 	);

	// 	$data['uid'] = $uid;

	// 	$data['tt_uid_log'] = $eces->insert('tt_uid_log', $uid);

	// 	$this->db->trans_complete();
	// 	$data['trans_status'] = $this->db->trans_status();

	// 	if ($this->db->trans_status() === FALSE) {
	// 		// generate an error... or use the log_message() function to log your error
	// 		$data['status_inject'] = 'gagal';
	// 		return $data;
	// 	} else {
	// 		$data['status_inject'] = 'berhasil';
	// 		return $data;
	// 	}
	// }


}
