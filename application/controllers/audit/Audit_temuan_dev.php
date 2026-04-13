<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Audit_temuan_dev extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");
		$this->load->model('Model_audit_temuan', 'model');
		if ($this->session->userdata('user_id') != "") {
		} else {
			redirect('login', 'refresh');
		}
	}

	function index()
	{
		$data['content'] 			= "audit_temuan/index_dev";
		$data['pageTitle'] 			= "Audit Findings";
		$data['css'] 				= "audit_temuan/css";
		$data['js'] 				= "audit_temuan/js_dev";
		$data['department']			= $this->model->get_department();
		$data['plan'] 				= $this->model->get_plan();
		$data['status_audit']		= $this->model->get_status_audit();

		$this->load->view("layout/main", $data);
	}

	function get_karyawan($dep_id)
	{
		$karyawan 	= $this->model->get_karyawan($dep_id)->result();
		$row 		= $this->model->get_karyawan($dep_id)->num_rows();
		$result 	= "";

		if ($row > 0) {
			$result = '<option value="#" selected disabled>-Choose User-</option>';
			foreach ($karyawan as $kary) {
				$result .= '<option value="' . $kary->user_id . '">' . $kary->employee_name . '</option>';
			}
		} else {
			$result = '<option value="#" selected disabled>-Choose User-</option>';
		}

		echo json_encode($result);
	}

	function get_aturan($dep_id)
	{
		$aturan 	= $this->model->get_aturan($dep_id)->result();
		$row 		= $this->model->get_aturan($dep_id)->num_rows();
		$result 	= "";

		if ($row > 0) {
			$result = '<option value="#" selected disabled>-Choose Rule-</option>';
			foreach ($aturan as $atr) {
				$result .= '<option value="' . $atr->id_sop . '">' . $atr->nama_dokumen . '</option>';
			}
		} else {
			$result = '<option value="#" selected disabled>-Choose Rule-</option>';
		}

		echo json_encode($result);
	}

	function upload_lampiran()
	{
		$direktori = './uploads/audit_temuan/';

		$string = $_POST['file'];
		$file_name = str_replace('#', '', $_POST['file_name']);

		define('UPLOAD_DIR', $direktori);

		$string     = explode(',', $string);
		$img        = str_replace(' ', '+', $string[1]);
		$data       = base64_decode($img);
		$name       = $file_name . date('ymdHis') . '.' . $string[0];
		$file       = UPLOAD_DIR . $name;
		$success    = file_put_contents($file, $data);

		if (!$success) {
			echo $this->upload->display_errors();
		} else {
			echo $name;
		}
	}

	function upload_lampiran_file()
	{
		$config['upload_path']   = './uploads/audit_temuan/';
		$config['allowed_types'] = '*';
		$config['max_size']      = 0;
		$file_name = str_replace('#', '', $_POST['file_name']);
		$path = $_FILES['file']['name'];
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$config['file_name']	 = $file_name . date('ymdHis') . '.' . $ext;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file')) {
			$file = $this->upload->display_errors();
		} else {
			$file_file 	= $this->upload->data();
			$name		= $file_file['raw_name'] . $file_file['file_ext'];
			if (isset($file_file['file_name'])) {
				$file = $file_file['file_name'];
			} else {
				$file = '';
			}
		}
		$data = $string = trim(preg_replace('/\s\s+/', '', $file));
		echo $data;
	}

	function save_findings()
	{
		$id_temuan = $this->model->generate_id_findings();

		$alat_bukti = [];
		// $alat_bukti_array = [];
		for ($i = 0; $i < count($_POST['alat_bukti']); $i++) {
			$alat_bukti[$i] = array(
				'id_temuan'  => $id_temuan,
				'alat_bukti' => $_POST['alat_bukti'][$i],
			);
			if ($_POST['alat_bukti'][$i] != "") {
				$data['alat_bukti'][$i] = $this->db->insert('audit_alat_bukti_temuan', $alat_bukti[$i]);
				// array_push($alat_bukti_array, $_POST['alat_bukti'][$i]);
			}
		}

		$lampiran = [];
		// $lampiran_array = [];
		for ($i = 0; $i < count($_POST['lampiran']); $i++) {
			$lampiran[$i] = array(
				'id_temuan' => $id_temuan,
				'lampiran' 	=> $_POST['lampiran'][$i],
			);
			if ($_POST['lampiran'][$i] != "") {
				$data['lampiran'][$i] = $this->db->insert('audit_lampiran_temuan', $lampiran[$i]);
				// array_push($lampiran_array, $_POST['lampiran'][$i]);
			}
		}

		$data = array(
			'id_temuan' 		=> $id_temuan,
			'id_divisi' 		=> $_POST['department_id'],
			'company_id' 		=> $_POST['company_id'],
			'employee_id' 		=> $_POST['karyawan'],
			'proses_kerja' 		=> $_POST['proses_kerja'],
			'sub_proses_kerja' 	=> $_POST['sub_proses_kerja'],
			'temuan' 			=> $_POST['temuan'],
			'root_cause' 		=> $_POST['root_cause'],
			'tanggal_kejadian' 	=> $_POST['tanggal_kejadian'],
			'aturan_sop' 		=> isset($_POST['aturan']) ? $_POST['aturan'] : null,
			'category' 			=> $_POST['kategori_temuan'],
			'level_temuan' 		=> ($_POST['kategori_temuan'] == "Konfirmasi Audit") ? null : $_POST['level_temuan'],
			'status'			=> 1, // 1 : Waiting Feedback
			'created_by' 		=> $_SESSION['user_id'],
			'created_at' 		=> date('Y-m-d H:i:s'),
			'id_plan' 			=> $_POST['plan']
		);

		$result['insert_audit_temuan'] 	= $this->db->insert("audit_temuan", $data);
		$result['send'] 				= $this->send_wa_temuan($id_temuan);
		echo json_encode($result);
	}

	function list_findings()
	{
		$start 	= $_POST['start'];
		$end 	= $_POST['end'];

		$result['data'] = $this->model->list_findings($start, $end);
		echo json_encode($result);
	}

	public function send_wa_temuan($id_temuan)
	{
		$result_text['wa_api'] 	= "";

		$dt = $this->model->get_send_wa($id_temuan)->row_array();

		if ($dt['category'] == "Konfirmasi Audit") {
			$level_temuan = "";
		} else {
			$level_temuan = "\nLevel Temuan : " . $dt['level_temuan'] . "";
		}

		$msg = "🔔 *Pemberitahuan " . $dt['category'] . "* ⚠️
			
ID : " . $dt['id_temuan'] . "
Nama : *" . rtrim($dt['employee_name']) . "* 
Divisi : " . $dt['department_name'] . "
Temuan : " . $dt['temuan'] . "
Tanggal Kejadian : " . $dt['tanggal_kejadian'] . "" . $level_temuan . "

Segera input konfirmasi tanggapan terkait temuan di atas. klik link di bawah ini:
https://trusmiverse.com/apps/fdbk-audit/" . $dt['kode_temuan'] . "
Terimakasih.

Auditor
" . $dt['auditor'];

		if ($_SESSION['user_id'] == 1) {
			$list_contact = [
				// $dt['employee_contact'],
				// '628993036965', // Faisal IT
				'6285640279721'
			];
		}
		// } else {
		// 	$list_contact = [
		// 		$dt['employee_contact'],
		// 		$dt['head_contact'],
		// 		$dt['auditor_contact'],
		// 		'6281120005224', // official audit
		// 		'6281298884313', // Najmatul1273
		// 		'6281804446610', // Ilham Adhi Pangestu
		// 		'6285694447437', // Mr Syekh Farhan Robbani 
		// 		// '6281120005224', // CS Audit
		// 		'628993036965', // Faisal IT
		// 	];
		// }


		foreach ($list_contact as $key => $value) {

			$url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

			$data_text = array(
				// "channelID" => "2319536345",
				"channelID" => "2225082380",
				"phone" => $value,
				"messageType" => "text",
				"body" => $msg,
				"withCase" => true
			);

			$options_text = array(
				'http' => array(
					"method"  => 'POST',
					"content" => json_encode($data_text),
					"header" =>  "Content-Type: application/json\r\n" .
						"Accept: application/json\r\n" .
						"API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
				)
			);

			$context_text   			= stream_context_create($options_text);
			$result_text['wa_api']    	= file_get_contents($url, false, $context_text);
		}

		return $result_text;
	}

	function get_detail_keterangan_audit($id_temuan)
	{
		$result = $this->model->get_detail_feedback($id_temuan, 'keterangan');
		echo json_encode($result);
	}

	function save_keterangan_audit()
	{
		$id_temuan = $_POST['id_temuan'];

		$data = array(
			'keterangan_pic' 			=> $_POST['keterangan_audit'],
			'status'					=> $_POST['status_audit'],
			'tanggal_keterangan_pic' 	=> date('Y-m-d H:i:s')
		);

		$this->db->where("id_temuan", $id_temuan);
		$result['update_audit'] 	= $this->db->update("audit_temuan", $data);
		$result['send'] 			= $this->send_wa_keterangan($id_temuan);
		echo json_encode($result);
	}

	public function send_wa_keterangan($id_temuan)
	{
		$result_text['wa_api'] 	= "";

		$dt = $this->model->get_send_wa_keterangan($id_temuan)->row_array();

		$msg = "";
		if ($dt['id_status'] == 3) { // Solve
			$msg = "Kami mengucapkan terima kasih atas jawaban anda terkait " . $dt['category'] . ", berupa *" . $dt['keterangan_pic'] . "* 😉.";
		} else if ($dt['id_status'] == 4) { // Reject
			$msg = "Kami mengucapkan terima kasih atas jawaban anda terkait " . $dt['category'] . ", dimohon untuk menghubungi SPV Audit terkait status reject dari jawaban anda yang tidak sesuai dengan " . $dt['category'] . " yakni *" . $dt['keterangan_pic'] . "* 😔.";
		} else if ($dt['id_status'] == 10) { // OFI
			$msg = "Kami mengucapkan terima kasih atas jawaban anda terkait " . $dt['category'] . ", dimohon untuk melakukan perbaikan agar tidak terulang Kembali ketidaksesuaian pemeriksaan. dengan catatan : \n" . $dt['keterangan_pic'];
		}

		if ($_SESSION['user_id'] == 1) {
			$list_contact = [
				$dt['employee_contact'],
				'628993036965', // Faisal IT
			];
		} else {
			$list_contact = [
				$dt['employee_contact'],
				'6281298884313', // Najmatul1273				
				'6281804446610', // Ilham Adhi Pangestu
				'6285694447437', // Mr Syekh Farhan Robbani 
				'628993036965', // Faisal IT
			];
		}


		foreach ($list_contact as $key => $value) {

			$url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

			$data_text = array(
				// "channelID" => "2319536345",
				"channelID" => "2225082380",
				"phone" => $value,
				"messageType" => "text",
				"body" => $msg,
				"withCase" => true
			);

			$options_text = array(
				'http' => array(
					"method"  => 'POST',
					"content" => json_encode($data_text),
					"header" =>  "Content-Type: application/json\r\n" .
						"Accept: application/json\r\n" .
						"API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
				)
			);

			$context_text   = stream_context_create($options_text);
			$result_text['wa_api']    = file_get_contents($url, false, $context_text);
		}

		return $result_text;
	}

	function print_ba($id_temuan)
	{
		$data['data'] = $this->model->list_findings(null, null, $id_temuan);

		$this->load->view("audit_temuan/print_ba", $data);
	}
	function get_plan()
	{
		$plan = $_POST['plan'];
		$data['plan'] = $this->model->get_plan($plan);
		echo json_encode($data);
	}
}
