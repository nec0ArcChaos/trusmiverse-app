<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Pengajuan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		// $this->load->model('model1');
		$this->load->model('Model_auth', 'auth');
		$this->load->model('eaf/model_pengajuan', 'model_pengajuan');
		$this->load->library("session");
		$this->load->library('FormatJson');
		// if ($this->session->userdata('user_id') != "") {
		// } else {
		// 	redirect('login', 'refresh');
		// }

		if ($this->session->userdata('user_id') != "") {
			$user_id = $this->session->userdata('user_id');
			$check_hak_akses = $this->auth->check_hak_akses('eaf/pengajuan', $user_id);
			if ($check_hak_akses != 'allowed') {
				redirect('forbidden_access', 'refresh');
			}
		} else {
			redirect('login', 'refresh');
		}

		//cek login
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
	}

	function index()
	{

		$user_id			= $this->session->userdata('user_id');
		if (isset($user_id)) {
			$data['content'] 		= "eaf/pengajuan/index";
			$data['pageTitle'] 	= "Pengajuan EAF";
			$data['css'] 		= "eaf/pengajuan/css";
			$data['js'] 		= "eaf/pengajuan/js";

			$data['pengaju'] 		=  $this->model_pengajuan->get_pengaju()->result();
			$data['kategori'] 		=  $this->model_pengajuan->get_kategori()->result();
			// $data['jenis_biaya'] 	=  $this->model_pengajuan->jenis_biaya()->result();
			$data['company'] 	=  $this->model_pengajuan->get_company()->result();
			$data['tipe'] 			=  1;
			$data['project'] 		=  $this->model_pengajuan->get_project();

			$this->load->view("layout/main", $data);
		} else {
			redirect("login");
		}
	}

	function list_revisi()
	{

		$data['content'] 		= "eaf/pengajuan/revisi";
		$data['pageTitle'] 	= "Revisi EAF";
		$data['css'] 		= "eaf/pengajuan/css";
		$data['js'] 		= "eaf/pengajuan/revisi_js";
		$data['tipe'] 		=  2;


		$this->load->view("layout/main", $data);
	}

	function save_revisi()
	{
		$id_pengajuan = $_POST['id_pengajuan'];
		$revisi_approval = $this->model_pengajuan->get_revisi_approval($id_pengajuan);

		if ($revisi_approval['level'] == 1) {
			$status = 1;
		} else if ($revisi_approval['level'] == 10) {
			$status = 10;
		} else {
			$status = 2;
		}

		$pengajuan = array('status' => $status);

		$this->db->where('id_pengajuan', $id_pengajuan);
		$result['pengajuan'] 		= $this->db->update('e_eaf.e_pengajuan', $pengajuan);

		$detail_keperluan = array(
			'nominal_uang' => str_replace(".", "", $_POST['nominal_revisi']),
			'note' => str_replace(array("\r", "\n"), ' ', $_POST['note_revisi']),
		);

		$this->db->where('id_pengajuan', $id_pengajuan);
		$result['detail_keperluan'] = $this->db->update('e_eaf.e_detail_keperluan', $detail_keperluan);

		$approval = array(
			'id_pengajuan'      => $id_pengajuan,
			'id_user_approval'  => $revisi_approval['id_user_approval'],
			'level'             => $revisi_approval['level'],
			'flag'              => 'Pengajuan'
		);

		$result['approval'] = $this->db->insert('e_eaf.e_approval', $approval);
		if ($result['detail_keperluan']) {
			$result = $this->model_pengajuan->get_pengajuan_for_wa($id_pengajuan, $status);
		}
		echo json_encode($result);
	}

	function list_reject()
	{

		$data['content'] 		= "eaf/pengajuan/list_reject";
		$data['pageTitle'] 	= "Reject EAF";
		$data['css'] 		= "eaf/pengajuan/css";
		$data['js'] 		= "eaf/pengajuan/list_reject_js";
		$data['tipe'] 		=  3;


		$this->load->view("layout/main", $data);
	}

	function get_list_eaf()
	{
		$id_user 	= $this->session->userdata('user_id');
		$id_div 	= $this->session->userdata('id_divisi');
		$startdate 	= $_POST['datestart'];
		$enddate 	= $_POST['dateend'];
		$tipe 		= $_POST['tipe'];

		$data = $this->model_pengajuan->get_list_eaf($id_user, $id_div, $startdate, $enddate, $tipe);
		echo json_encode($data);
	}

	function data_detail_pengajuan()
	{
		$id_pengajuan = $_POST['id_pengajuan'];

		$data['detail_pengajuan'] = $this->model_pengajuan->detail_pengajuan($id_pengajuan);
		$data['tracking_approval'] = $this->model_pengajuan->tracking_approval($id_pengajuan);


		$this->load->view('eaf/pengajuan/detail_pengajuan', $data);
	}

	function data_detail_revisi()
	{
		$id_pengajuan = $_POST['id_pengajuan'];

		$data['detail_pengajuan'] = $this->model_pengajuan->detail_pengajuan($id_pengajuan);
		$data['tracking_approval'] = $this->model_pengajuan->tracking_approval($id_pengajuan);


		$this->load->view('eaf/pengajuan/detail_revisi', $data);
	}



	function insert_pengajuan()
	{
		$tgl_pengajuan  = date('Y-m-d');
		$getideaf       = $this->model_pengajuan->getideaf();
		$id_pengajuan   = $getideaf;
		// date_default_timezone_set('Asia/Jakarta');
		// $tanggal     = date("Y-m-d  H:i:s");

		$nama_penerima  = str_replace(array('\'', '"'), array('`', '``'), $_POST['nama_penerima']);
		$pengaju  		= $_POST['pengaju'];
		$id_kategori    = $_POST['kategori'];
		// $id_divisi   = $this->session->userdata('id_divisi');
		$id_divisi      = 1;
		// $id_user        = $this->session->userdata('id_user');
		$id_user        = $this->session->userdata('user_id');
		$nama_tipe      = $_POST['tipe'];
		$leave_id		= $_POST['leave_id'];

		$keperluan      = explode('|', $_POST['keperluan']);
		$jenis          = $keperluan[0];
		$budget         = $keperluan[1];
		$user_approval 	= $keperluan[3];
		$user_verified 	= $keperluan[8];
		$nama_bank      = (isset($_POST['nama_bank'])) ? $_POST['nama_bank'] : "";
		$no_rek         = (isset($_POST['rekening'])) ? $_POST['rekening'] : "";

		// Pilihan BA - Faisal
		$pilihan_ba 	= (isset($_POST['pilihan_ba'])) ? $_POST['pilihan_ba'] : "";


		// 1483 id user rsp Nadila Silviany | 4231 employees id hr Nadila Silviany
		// 237 id user rsp Pak i | 803 employees id hr pak i
		// 286 id user rsp Idham Nurhakim Dipura | 1186 employees id hr Idham Nurhakim Dipura

		// old if ($pengaju == "1483" && $user_approval == "237") {
		// if ($pengaju == "4231" && $user_approval == "803") {
		// 	$status_app = 10;
		// 	//old $id_user_approval = 286;
		// 	$id_user_approval = 1186;
		// } else 
		if ($user_verified == "") {
			$status_app = 1;
			$id_user_approval = $user_approval;
		} else {
			$status_app = 10;
			$id_user_approval = $user_verified;
		}

		if (isset($_POST['tanggal_2']) && !empty($_POST['tanggal_2'])) {
			$tanggal2 = $_POST['tanggal_2'];
		} else {
			date_default_timezone_set('Asia/Jakarta');
			$tanggal2 = date("Y-m-d H:i:s");
		}

		$result['warning'] 		= "";
		if ($this->session->userdata('user_id') != "") {
			// Kondisi untuk Pinjaman Karyawan
			if ($id_kategori == 20) {
				$ck = $this->model_pengajuan->cek_validasi_pinjaman($pengaju);

				if ($ck['masa_kerja'] < 4) {
					$result['warning'] 		= "Masa Kerja Minimal 4 Bulan";
				} else if ($ck['jenis_karyawan'] != "reguler") {
					$result['warning'] 		= "Pinjaman hanya untuk karyawan Reguler";
					// } else if ($ck['tgl_pinjam'] > 14 && $id_user != 747) { // Akun Fafricony bisa ajukan tanggal berapapun
					// 78 id hr mba fafri 
				} else if ($ck['tgl_pinjam'] > 14 && $id_user != 78) { // Akun Fafricony bisa ajukan tanggal berapapun

					$result['warning'] 		= "Input Pinjaman tidak boleh lebih dari tanggal 14";
				} else if ($ck['status'] == "Belum Terbayar" && $id_user != 78) { // Akun Fafricony bisa ajukan hutang yang belum lunas
					$result['warning'] 		= "Pinjaman sebelumnya, Belum Terbayar Lunas";
				} else {
					$result['warning'] 		= "";
					// Start
					$pengajuan = array(
						'id_pengajuan'  	=> $id_pengajuan,
						'tgl_input'     	=> $tanggal2,
						'nama_penerima' 	=> $nama_penerima,
						'pengaju' 			=> $pengaju,
						'id_kategori'   	=> $id_kategori,
						'status'        	=> $status_app,
						'id_divisi'     	=> $id_divisi,
						'id_user'       	=> $id_user,
						'flag'          	=> 'Pengajuan',
						'jenis'         	=> $jenis,
						'budget'        	=> $budget,
						'leave_id'			=> $leave_id,
						'jumlah_termin'  	=> $_POST['jumlah_termin'],
						'nominal_termin'    => str_replace(".", "", $_POST['nominal_termin'])
					);

					$result['pengajuan'] = $this->db->insert('e_eaf.e_pengajuan', $pengajuan);

					$pembayaran = array(
						'id_pengajuan'  => $id_pengajuan,
						'nama_tipe'     => $nama_tipe,
						'nama_bank'     => $nama_bank,
						'no_rek'        => $no_rek,
					);

					$result['tipe_pembayaran'] = $this->db->insert('e_eaf.e_tipe_pembayaran', $pembayaran);

					$approval = array(
						'id_pengajuan'      => $id_pengajuan,
						'id_user_approval'  => $id_user_approval,
						'level'             => $status_app,
						'flag'              => 'Pengajuan'
					);

					$result['approval'] = $this->db->insert('e_eaf.e_approval', $approval);

					$note_clear1		= str_replace(array("\r", "\n", '\'', '"'), array(" ", " ", '`', '``'), $_POST['note']);
					$nkeperluan = explode('|', $_POST['keperluan']);
					// $project 	= ($_POST['project'] == 0) ? null : $_POST['project'];
					$project 	=  null;

					// $list_blok 	= ($_POST['list_blok'] == "") ? null : $_POST['list_blok'];
					$entries = array(
						'id_pengajuan'      => $id_pengajuan,
						'nama_keperluan'    => $nkeperluan[2],
						'nominal_uang'      => str_replace('.', '', $_POST['total']),
						'note'              => str_replace("'", "`", $note_clear1),
						'tgl_nota'          => $_POST['tgl_nota'],
						// 'id_project' 		=> $project,
						// 'blok' 				=> Null
					);

					$result['detail_keperluan'] = $this->db->insert('e_eaf.e_detail_keperluan', $entries);

					$string = $_POST['nota'];
					if ($string != "") {

						define('UPLOAD_DIR', './uploads/eaf/');
						define('UPLOAD_DIR', './uploads/eaf/');

						$string     = explode(',', $string);
						$img        = str_replace(' ', '+', $string[1]);
						$data       = base64_decode($img);
						$name       = uniqid() . '.' . $string[0];
						$file       = UPLOAD_DIR . $name;
						$success    = file_put_contents($file, $data);


						$entries_foto = array(
							'id_pengajuan'  => $id_pengajuan,
							'photo_acc'     => $name,
							'flag'          => 'BUKTI_NOTA'
						);

						$result['photo_acc'] = $this->db->insert('e_eaf.e_photo_acc', $entries_foto);
					}
					if ($result['pengajuan']) {
						$result['id_pengajuan'] = $this->model_pengajuan->get_no_last_pengajuan();
					}
					// End
				}
			} else {

				// Start
				$pengajuan = array(
					'id_pengajuan'  	=> $id_pengajuan,
					'tgl_input'     	=> $tanggal2,
					'nama_penerima' 	=> $nama_penerima,
					'pengaju' 			=> $pengaju,
					'id_kategori'   	=> $id_kategori,
					'status'        	=> $status_app,
					'id_divisi'     	=> $id_divisi,
					'id_user'       	=> $id_user,
					'flag'          	=> 'Pengajuan',
					'jenis'         	=> $jenis,
					'budget'        	=> $budget,
					'leave_id'			=> $leave_id
				);

				$result['pengajuan'] = $this->db->insert('e_eaf.e_pengajuan', $pengajuan);

				$pembayaran = array(
					'id_pengajuan'  => $id_pengajuan,
					'nama_tipe'     => $nama_tipe,
					'nama_bank'     => $nama_bank,
					'no_rek'        => $no_rek,
				);

				$result['tipe_pembayaran'] = $this->db->insert('e_eaf.e_tipe_pembayaran', $pembayaran);

				$approval = array(
					'id_pengajuan'      => $id_pengajuan,
					'id_user_approval'  => $id_user_approval,
					'level'             => $status_app,
					'flag'              => 'Pengajuan'
				);

				$result['approval'] = $this->db->insert('e_eaf.e_approval', $approval);

				$note_clear1		= str_replace(array("\r", "\n", '\'', '"'), array(" ", " ", '`', '``'), $_POST['note']);
				// $note_clear2		= str_replace(array( '\'', '"' ), '', $note_clear1);

				$nkeperluan = explode('|', $_POST['keperluan']);
				// $project 	= ($_POST['project'] == 0) ? null : $_POST['project'];
				// $list_blok 	= ($_POST['list_blok'] == "") ? null : $_POST['list_blok'];
				$entries = array(
					'id_pengajuan'      => $id_pengajuan,
					'nama_keperluan'    => $nkeperluan[2],
					'nominal_uang'      => str_replace('.', '', $_POST['total']),
					'note'              => str_replace("'", "`", $note_clear1),
					'tgl_nota'          => $_POST['tgl_nota'],
					// 'id_project' 		=> Null,
					// 'blok' 				=> Null
				);

				$result['detail_keperluan'] = $this->db->insert('e_eaf.e_detail_keperluan', $entries);

				$string = $_POST['nota'];
				if ($string != "") {

					define('UPLOAD_DIR', './uploads/eaf/');

					$string     = explode(',', $string);
					$img        = str_replace(' ', '+', $string[1]);
					$data       = base64_decode($img);
					$name       = uniqid() . '.' . $string[0];
					$file       = UPLOAD_DIR . $name;
					$success    = file_put_contents($file, $data);


					$entries_foto = array(
						'id_pengajuan'  => $id_pengajuan,
						'photo_acc'     => $name,
						'flag'          => 'BUKTI_NOTA'
					);

					$result['photo_acc'] = $this->db->insert('e_eaf.e_photo_acc', $entries_foto);
				}

				// Pilihan BA - Faisal
				if ($pilihan_ba == 'ba') {
					$data_ba = array(
						'id_pengajuan'  => $id_pengajuan,
						'photo_acc'     => 'ba',
						'flag'          => 'EAF-BA'
					);

					$result['photo_acc'] = $this->db->insert('e_eaf.e_photo_acc', $data_ba);
				}

				if ($result['pengajuan']) {
					$result['id_pengajuan'] = $this->model_pengajuan->get_no_last_pengajuan();
				}
				// End
			}

			echo json_encode($result);
		} else {
			redirect('login', 'refresh');
		}
	}

	function list_lpj()
	{

		$data['content'] 		= "eaf/pengajuan/lpj";
		$data['pageTitle'] 	= "Pengajuan LPJ";
		$data['css'] 		= "eaf/pengajuan/css";
		$data['js'] 		= "eaf/pengajuan/lpj_js";

		$this->load->view("layout/main", $data);
	}

	function get_list_lpj()
	{
		$id_user 	= $this->session->userdata('user_id');

		$data['data'] = $this->model_pengajuan->get_list_lpj($id_user);
		echo json_encode($data);
	}

	function detail_lpj()
	{
		$id_user = $this->session->userdata('user_id');
		$tanggal = date("Y-m-d  H:i:s");
		$id_pengajuan = $_POST['id_pengajuan'];
		$id_biaya = $_POST['id_biaya'];
		$id_temp = $this->model_pengajuan->getidtemp();

		$temp = array(
			'id_temp' 	=> $id_temp,
			'nama_temp' => 'LPJ Ke-' . $id_temp
		);

		$pengajuan = array(
			'temp'			=> $id_temp,
			'id_pengajuan' 	=> $id_pengajuan
		);

		$detail_keperluan = array(
			'id_lpj'		=> $id_temp,
			'id_pengajuan' 	=> $id_pengajuan,
			'id_biaya_lpj' 	=> $id_biaya
		);

		$this->db->insert('e_eaf.e_temp', $temp);

		$this->db->where('id_pengajuan', $id_pengajuan);
		$this->db->update('e_eaf.e_pengajuan', $pengajuan);

		$this->db->where('id_pengajuan', $id_pengajuan);
		$this->db->update('e_eaf.e_detail_keperluan', $detail_keperluan);


		$id_user = $this->session->userdata('user_id');
		$id_divisi = $this->session->userdata('id_divisi');

		$data['id_temp'] = $id_temp;
		$data['id_pengajuan'] = $id_pengajuan;
		$data['get_detail_keperluan_2'] = $this->model_pengajuan->get_detail_keperluan($id_temp);
		$data['penerima'] = $this->model_pengajuan->get_nama($id_temp);
		$data['kategori'] =  $this->model_pengajuan->get_kategori_2()->result();
		$data['id_biaya_lpj'] =  $this->model_pengajuan->get_id_biayaa_lpj($id_temp)->result();

		$data['nama_divisi'] =  $this->model_pengajuan->get_divisi($id_user)->result();
		$data['id_user'] 	= $id_user;
		$data['id_divisi'] 	= $id_divisi;

		$this->load->view('eaf/pengajuan/detail_lpj', $data);
		// $this->load->view("layout/main", $data);

	}

	public function remove_temp()
	{
		$id_temp = $_POST['id_temp'];
		$data_update = array(
			'temp' => ''
		);

		$data_update_2 = array(
			'id_lpj' => ''
		);

		$this->db->where('id_temp', $id_temp)->delete('e_eaf.e_temp');
		$this->db->where('temp', $id_temp);
		$this->db->update('e_eaf.e_pengajuan', $data_update);
		$this->db->where('id_lpj', $id_temp);
		$result = $this->db->update('e_eaf.e_detail_keperluan', $data_update_2);
		echo json_encode($result);
	}

	public function save_lpj()
	{
		$id_lpj     = $this->model_pengajuan->getidlpj();
		$tanggal    = date("Y-m-d  H:i:s");

		$string 	= $_POST['string'];
		define('UPLOAD_DIR', './uploads/eaf/');

		if ($string != '' || $string != null) {
			$string     = explode(',', $string);
			$img        = str_replace(' ', '+', $string[1]);
			$data       = base64_decode($img);
			$name       = uniqid() . '.' . $string[0];
			$file       = UPLOAD_DIR . $name;
			$success    = file_put_contents($file, $data);
		}
		$attachment = $_POST['attachment'];
		if ($attachment == 1) {
			$name_new = $name;
			$flag_new = 'LPJ-BUKTI-NOTA';
		} else {
			$name_new = null;
			$flag_new = 'LPJ-BA';
		}
		$entries_foto = array(
			'id_pengajuan'  => $id_lpj,
			'photo_acc'     => $name_new,
			'flag'          => $flag_new
		);

		$this->db->insert('e_eaf.e_photo_acc', $entries_foto);

		$id_temp = $_POST['id_temp'];

		$usera = $this->model_pengajuan->eaf_usera($id_temp);

		// 737 id user db rsp finance
		// 711 jenis pengajuan DLK 81
		if ($usera['jenis'] == "81" && ($name_new == null || $name_new != null)) {
			$status_app         = 6;
			// 747 id user db rsp mba fafri | 78 id hr nya
			// $id_user_approval   = 747;
			$id_user_approval   = 78;

			$level				= 10;
		} else if ($name_new == null && $usera['jenis'] != "81") {
			$status_app         = $usera['status'];
			$id_user_approval   = $usera['user'];
			$level				= 1;
		} else if (str_replace('.', '', $_POST['nominal_lpj']) > str_replace('.', '', $_POST['nominal_pengajuan'])) {
			$status_app         = $usera['status'];
			$id_user_approval   = $usera['user'];
			$level				= 1;
		} else {
			$status_app         = 6;
			// $id_user_approval   = 737;
			// 488 id hr ade nofianti safira
			// 1709bu secil mgr finance
			$id_user_approval   = 1709;
			$level				= 5;
		}

		if ($_SESSION['user_id'] == 1) {
			$div = 1;
		} else {
			$div = $_POST['id_divisi'];
		}

		$data_lpj = array(
			"id_pengajuan"      => $id_lpj,
			"id_divisi"         => $div,
			"id_kategori"       => $_POST['kategori'],
			"id_user"           => $_POST['id_user'],
			"status"            => $status_app,
			"flag"              => "LPJ",
			"nama_penerima"     => $_POST['nama_penerima'],
			'tgl_input'         => $tanggal,
			'id_biaya_lpj'      => $_POST['id_biaya_lpj'],
			'jenis'             => $usera['jenis'],
			'sub_biaya'         => $usera['sub_biaya'],
			'budget'            => $usera['budget'],
			'note'				=> $_POST['keterangan'],
		);

		$result['pengajuan_lpj'] = $this->db->insert('e_eaf.e_pengajuan', $data_lpj);

		$data_approv = array(
			"id_pengajuan"      => $id_lpj,
			"id_user_approval"  => $id_user_approval,
			"level"             => $level,
			"flag"              => 'LPJ'
		);

		$result['approval_lpj'] = $this->db->insert('e_eaf.e_approval', $data_approv);

		$data_update = array(
			'temp'              => $id_lpj
		);

		$this->db->where('id_pengajuan', $_POST['id_pengajuan_satu']);
		$this->db->where('temp', $_POST['id_temp']);
		$result['pengajuan'] = $this->db->update('e_eaf.e_pengajuan', $data_update);

		$detail_keperluan = array(
			'id_lpj' => $id_lpj
		);

		$this->db->where('id_lpj', $_POST['id_temp']);
		$result['detail_keperluan'] = $this->db->update('e_eaf.e_detail_keperluan', $detail_keperluan);

		$header_lpj = array(
			'id_lpj'        => $id_lpj,
			'id_pengajuan'  => $_POST['id_pengajuan'],
			'nama_lpj'      => $_POST['nama_lpj'],
			'note_lpj'      => str_replace(array("\r", "\n"), ' ', $_POST['note_lpj']),
			'nominal_lpj'   => str_replace('.', '', $_POST['nominal_lpj']),
		);

		$result['header_lpj'] = $this->db->insert('e_eaf.e_header_lpj', $header_lpj);

		$approval = array(
			'id_temp_lpj'   => $id_lpj,
			'id_pengajuan'  => $_POST['id_pengajuan']
		);

		$result['approval'] = $this->db->update('e_eaf.e_approval', $approval, 'id_pengajuan');

		if ($result['approval']) {
			$result['data'] = $this->model_pengajuan->get_lpj_for_wa($id_lpj);
		}
		echo json_encode($result);
	}

	function get_pengajuan_for_wa($id)
	{
		$check 				= $this->model_pengajuan->get_level($id);
		$result['level'] 	= $check['level'];
		$result['data'] 	= $this->model_pengajuan->get_pengajuan_for_wa($id, $check['level']);
		echo json_encode($result);
	}

	// function get_de_blok()
	// {
	// 	$id 		= $_POST['id_project'];
	// 	$type 		= $_POST['blok'];
	// 	$id_jenis 	= $_POST['id_jenis'];
	// 	$data 	= $this->model_pengajuan->get_de_blok($id, $type, $id_jenis);
	// 	echo json_encode($data);
	// }

	function cek_dlk($id_hr)
	{
		$cek = $this->model_pengajuan->cek_dlk($id_hr);

		if ($cek->num_rows() > 0) {
			$dlk = $cek->result();
			$jenis_biaya = $this->model_pengajuan->jenis_biaya_dlk()->row_array();

			// foreach ($dlk as $row) {
			// 	echo '<option value="'. $jenis_biaya['id_jenis'].'|'.$jenis_biaya['id_biaya'].'|'.$jenis_biaya['jenis'].'|'.$jenis_biaya['id_user_approval'].'|'.$jenis_biaya['id_tipe_biaya'].'|'.$jenis_biaya['budget'].'|'.$jenis_biaya['project'].'|'.$jenis_biaya['blok'].'|'.$jenis_biaya['id_user_verified'].'|'.$row->leave_id.'-'.$row->total_eaf.'-'.$row->reason .'" class="dlk_makan">'. $jenis_biaya['jenis'] .  ' (' . $row->total_makan . 'x makan di ' . $row->kota . ' dari ' . $row->from_date . ' ' . substr($row->start_time, 0, 5) . ' sampai ' . $row->to_date . ' ' . substr($row->end_time, 0, 5) . ') (' . $jenis_biaya['employee'] . ')' .'</option>';
			// }
			foreach ($dlk as $row) {
				$data[] = array(
					"dtext" 		=> $jenis_biaya['jenis'] .  ' (' . $row->total_makan . 'x makan di ' . $row->kota . ' dari ' . $row->from_date . ' ' . substr($row->start_time, 0, 5) . ' sampai ' . $row->to_date . ' ' . substr($row->end_time, 0, 5) . ') (' . $jenis_biaya['employee'] . ')',
					"dvalue" 		=> $jenis_biaya['id_jenis'] . '|' . $jenis_biaya['id_biaya'] . '|' . $jenis_biaya['jenis'] . '|' . $jenis_biaya['id_user_approval'] . '|' . $jenis_biaya['id_tipe_biaya'] . '|' . $jenis_biaya['budget'] . '|' . $jenis_biaya['project'] . '|' . $jenis_biaya['blok'] . '|' . $jenis_biaya['id_user_verified'] . '|' . $row->leave_id . '-' . $row->total_eaf . '-' . $row->reason,
				);
			}

			// $data = $this->model_pengajuan->jenis_biaya_dlk()->result();
			echo json_encode($data);
		} else {
			echo "tidak ada";
		}
	}

	// Start | Tambah Edit Blok dan Note Setelah Pengajuan EAF
	function faisal()
	{
		$data['view'] 		= "eaf/pengajuan/index_faisal";
		$data['pageTitle'] 	= "Pengajuan EAF";
		$data['css'] 		= "eaf/pengajuan/css";
		$data['js'] 		= "eaf/pengajuan/js_faisal";

		$data['pengaju'] 		=  $this->model_pengajuan->get_pengaju()->result();
		$data['kategori'] 		=  $this->model_pengajuan->get_kategori()->result();
		$data['jenis_biaya'] 	=  $this->model_pengajuan->jenis_biaya()->result();
		$data['tipe'] 			=  1;
		$data['project'] 		=  $this->model_pengajuan->get_project();

		$this->load->view("main", $data);
	}

	function edit_blok($id)
	{
		$res = $this->model_pengajuan->edit_blok($id);
		echo json_encode($res);
	}

	// function get_de_blok_new()
	// {
	// 	$id 	= $_POST['id'];
	// 	$type 	= $_POST['type'];
	// 	$jenis 	= $_POST['jenis'];
	// 	$blok 	= $_POST['blok'];

	// 	$data = $this->model_pengajuan->get_de_blok($id, $type, $jenis);
	// 	// echo json_encode($data);

	// 	echo '<option data-placeholder="true" disabled>- Pilih Blok -</option>';
	// 	foreach ($data as $row) {
	// 		echo '<option value="' . $row->blok . '">' . $row->blok . '</option>';
	// 	}

	// 	for ($i = 0; $i < count($blok); $i++) {
	// 		echo '<option value="' . $blok[$i] . '">' . $blok[$i] . '</option>';
	// 	}
	// }

	function simpan_edit_blok()
	{
		$id 		= $_POST['id_aju'];
		$blok_old	= $_POST['blok_old'];
		$blok_new 	= ($_POST['list_blok_edit'] == "" ? NULL : $_POST['list_blok_edit']);
		$note 		= $_POST['note_pengajuan'];

		$data = array(
			"note" 		=> $note,
			"blok" 		=> $blok_new,
			"blok_old" 	=> $blok_old,
			"updated_blok_by" => $_SESSION['id_user'],
			"updated_blok_at" => date('Y-m-d H:i:s')
		);

		$this->db->where("id_pengajuan", $id);
		$data['update_blok'] = $this->db->update("e_detail_keperluan", $data);
		echo json_encode($data);
	}
	// End | Tambah Edit Blok dan Note Setelah Pengajuan EAF

	function edit_nota()
	{
		$id_pengajuan 	= $_POST['id_nota'];
		$string 		= $_POST['nota_new'];

		if ($string != "") {

			define('UPLOAD_DIR', './uploads/eaf/');

			$string     = explode(',', $string);
			$img        = str_replace(' ', '+', $string[1]);
			$data       = base64_decode($img);
			$name       = uniqid() . '.' . $string[0];
			$file       = UPLOAD_DIR . $name;
			$success    = file_put_contents($file, $data);


			if ($_POST['proses'] == 'update') {
				$photo = array(
					'photo_acc' => $name
				);
				$this->db->where('id_pengajuan', $id_pengajuan);
				$result['photo_acc'] = $this->db->update('e_eaf.e_photo_acc', $photo);
			} else {
				$photo = array(
					'id_pengajuan' 	=> $id_pengajuan,
					'photo_acc' 	=> $name,
					'flag' 			=> 'BUKTI_NOTA'
				);
				$result['photo_acc'] = $this->db->insert('e_eaf.e_photo_acc', $photo);
			}
		}

		echo json_encode($result);
	}

	function jenis_biaya_by_company()
	{
		$company_id 		= $_POST['company_id'];
		// $nominal 			= $_POST['b_nominal'];
		$nominal = preg_replace("/[^0-9]/", "", $_POST['b_nominal']);

		$data = $this->model_pengajuan->jenis_biaya_by_company($company_id, $nominal)->result();

		echo json_encode($data);
	}
}
