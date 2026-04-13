<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Trusmi_lock extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");
		$this->load->model('Model_trusmi_lock', 'model');
		if ($this->session->userdata('user_id') != "") {
		} else {
			redirect('login', 'refresh');
		}
	}

	function index()
	{
		$data['content'] 	= "trusmi_lock/index";
		$data['pageTitle'] 	= "T-Lock";
		$data['css'] 		= "trusmi_lock/css";
		$data['js'] 		= "trusmi_lock/js";
		$data['karyawan']	= $this->model->get_employee();

		$this->load->view("layout/main", $data);
	}

	function get_lock_absen()
	{
		$start 				= $_POST['datestart'];
		$end 				= $_POST['dateend'];
		$result['data']   	= $this->model->get_lock_absen($start, $end);
		echo json_encode($result);
	}

	function save_lock()
	{
		$user_id 		= $this->session->userdata('user_id');
		$type_lock		= $_POST['lock_type'];
		$user 			= explode(",", $_POST['user']);
		$alasan			= $_POST['alasan'];
		$alasan			= preg_replace('/[^a-zA-Z0-9\s]/', '', $alasan);

        // Hilangkan multiple whitespace (termasuk newline)
        $alasan			= preg_replace('/\s+/', ' ', $alasan);
		$activity			= $_POST['activity'];
		$activity			= preg_replace('/[^a-zA-Z0-9\s]/', '', $activity);

        // Hilangkan multiple whitespace (termasuk newline)
        $activity			= preg_replace('/\s+/', ' ', $activity);
		$created_at		= date("Y-m-d H:i:s");
		$user_locked 	= $this->session->userdata('nama');

		if (isset($user)) {
			foreach ($user as $key => $value) {
				$data = array(
					"type_lock" 	=> $type_lock,
					"employee_id" 	=> $value,
					"alasan_lock" 	=> $alasan . " - By " . $user_locked,
					"activity" 	=> $activity . " - By " . $user_locked,
					"status" 		=> 1,
					"created_at" 	=> $created_at,
					"created_by" 	=> $user_id
				);

				$result['data'] = $data;
				$result['insert_lock'] = $this->db->insert("trusmi_lock_absen_manual", $data);
				if ($result['insert_lock'] == true) {
					$this->send_notif_lock($value, $user_id, $alasan, $activity, $created_at, 1);
				}
			}
		}
		echo json_encode($result);
	}

	function update_lock()
	{
		$id 		= $_POST['e_id'];
		$updated_at = date('Y-m-d H:i:s');
		$updated_by	= $this->session->userdata('user_id');
		$alasan = $_POST['e_alasan'];
		$activity = $_POST['e_activity'];

		$data = array(
			"status" 		=> 0,
			"updated_at" 	=> $updated_at,
			"updated_by" 	=> $updated_by
		);

		$this->db->where('id', $id);
		$result['update_lock'] = $this->db->update("trusmi_lock_absen_manual", $data);
		if ($result['update_lock'] == true) {
			$user = $this->db->query("SELECT employee_id FROM trusmi_lock_absen_manual WHERE id = $id")->row_array();
			$this->send_notif_lock($user['employee_id'], $updated_by, $alasan, $activity, $updated_at, 0);
		}
		echo json_encode($result);
	}
// 	function send_notif_lock($lock_at, $lock_by, $alasan, $tgl, $status)
// 	{
// 		$data_msg = $this->model->get_data_msg($lock_at, $lock_by);
// 		if ($status == 1) {
// 			$ket = "🔒 *Lock Absen* 🔒  
    
// Halo *" . trim(ucwords($data_msg['name_lock_at'])) . "*,

// Kami ingin memberitahukan bahwa sistem absensi akan *dikunci*.";
// 		} else {
// 			$ket = "🔓 *Unlock Absen* 🔓  
    
// Halo *" . trim(ucwords($data_msg['name_lock_at'])) . "*,
			
// Kami ingin memberitahukan bahwa penguncian sistem absensi akan *dibuka*.";
// 		}
// 		$url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
// 		$data_text = array(
// 			"channelID" => "2507194023", // Channel Trusmi Group
// 			"phone" => $data_msg['contact_lock_at'],
// 			// "phone" => "6285640279721",
// 			"messageType" => "text",
// 			"body" => "" . $ket . "

// ⌛ Tanggal : " . $tgl . "
// 📜 Alasan : " . trim(ucwords($alasan)) . "

// Jika ada pertanyaan atau kendala, silakan hubungi :
// Nama : " . trim(ucwords($data_msg['name_lock_by'])) . "
// Departemen : " . trim(ucwords($data_msg['department_lock_by'])) . "
// No HP : " . trim(ucwords($data_msg['contact_lock_by'])) . "

// _Terima kasih atas perhatian dan kerjasamanya._",
// 			"withCase" => true
// 		);

// 		$options_text = array(
// 			'http' => array(
// 				"method"  => 'POST',
// 				"content" => json_encode($data_text),
// 				"header" =>  "Content-Type: application/json\r\n" .
// 					"Accept: application/json\r\n" .
// 					"API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
// 			)
// 		);
// 		$context_text  = stream_context_create($options_text);
// 		$result_text = file_get_contents($url, false, $context_text);
// 		$response['text'][] = json_decode($result_text);
// 	}

public function send_notif_lock($lock_at, $lock_by, $alasan, $activity, $tgl, $status)
{
    // Ambil data penerima & pengirim dari model
    $data_msg = $this->model->get_data_msg($lock_at, $lock_by);

    // Tentukan jenis pesan
    if ($status == 1) {
        $ket = "🔒 *Lock Absen* 🔒\n\nHalo *" . trim(ucwords($data_msg['name_lock_at'])) . "*,\n\nKami ingin memberitahukan bahwa sistem absensi akan *dikunci*.";
    } else {
        $ket = "🔓 *Unlock Absen* 🔓\n\nHalo *" . trim(ucwords($data_msg['name_lock_at'])) . "*,\n\nKami ingin memberitahukan bahwa penguncian sistem absensi akan *dibuka*.";
    }

    // Susun isi pesan lengkap
    $msg = $ket . "\n\n⌛ *Tanggal* : " . $tgl .
        "\n📜 *Alasan* : " . trim(ucwords($alasan)) .
		"\n📝 *Aktivitas* : " . trim(ucwords($activity)) .
        "\n\nJika ada pertanyaan atau kendala, silakan hubungi:" .
        "\n👤 *Nama* : " . trim(ucwords($data_msg['name_lock_by'])) .
        "\n🏢 *Departemen* : " . trim(ucwords($data_msg['department_lock_by'])) .
        "\n📞 *No HP* : " . trim($data_msg['contact_lock_by']) .
        "\n\n_Terima kasih atas perhatian dan kerjasamanya._";

    // Kirim lewat WAJS (trusmicorp)
    $this->send_wa(
        $data_msg['contact_lock_at'],
        $msg,
        $lock_by // user_id opsional
    );
}


	public function send_wa($phone, $msg, $user_id = '')
	{
		try {
			$this->load->library('WAJS');
			$result = $this->wajs->send_wajs_notif(
				$phone,
				$msg,
				'text',
				'trusmicorp',
				$user_id
			);

			return [
				'status' => true,
				'message' => 'Pesan berhasil dikirim',
				'response' => $result
			];
		} catch (\Throwable $th) {
			return [
				'status' => false,
				'message' => 'Server WAJS Error: ' . $th->getMessage()
			];
		}
	}
}
