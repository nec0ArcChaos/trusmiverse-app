<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Push_notification_TrusmiOntime extends CI_Controller
{
	function __construct()
	{
		parent::__construct(); 
		$this->load->helper("url");
		$this->load->library("session");
		$this->load->model('Model_push_notification_TrusmiOntime', 'model');
        if ($this->session->userdata('user_id') != "") { } else {
					redirect('login', 'refresh');
        }
	}

	// Function untuk mengirim push notification
	function sendPush($user_id, $to, $title, $body, $icon, $url) 
	{
		// Untuk Ambil Token OAuth dari Google Cloud Firebase
		$accessToken = $this->get_oauth_token();

		// Format Data untuk dikirim ke Push Notification
		$jsonData = json_encode([
			"message" => [
				"token" => $to,
				"notification" => [
					"body" => $body,
					"title" => $title,
					"image" => $icon
				],
				"data" => [
					"click_action" => $url,
					"additional_info" => "Optional data payload"
				],
				"apns" => [
					"payload" => [
						"aps" => [
							"mutable-content" => 1
						]
					]
				]
			]
		]);

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://fcm.googleapis.com/v1/projects/trusmiontimepushnotification/messages:send',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $jsonData,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Bearer '. $accessToken
			),
		));

		$response = curl_exec($curl);

		if (curl_errno($curl)) {
			$error = curl_error($curl);
			$result['status'] = false; 
			$result['warning'] = "Error: " . curl_error($curl);
		} else {
			$responseData = json_decode($response, true);
			if (isset($responseData['error'])) {
				$result['status'] = false; 
				$result['warning'] = "Error: " . $responseData['error']['message'];
			} else {
				// echo json_encode(['success' => 'Push notification sent successfully']);
				$result['status'] = true; 
				$result['warning'] = 'Push notification sent successfully';
				// echo "Success : ". $responseData['name'];
			}
		}		

		$data = array(
			'judul' 	=> $title,
			'pesan' 	=> $body,
			'image' 	=> $icon,
			'url' 		=> $url,
			'category_id' 	=> 1,
			'user_id' 	=> $user_id,
			'status'	=> $result['status'],
			'warning'	=> $result['warning'],
			'created_at' => date('Y-m-d H:i:s'),
			'created_by' => $_SESSION['user_id']
		);

		$this->db->insert('trusmi_ontime_notification', $data);

		curl_close($curl);

		return $result;
	}

	// Function untuk get Token Google Cloud
	function get_oauth_token() 
	{
		// $serviceAccountFile = APPPATH . 'third_party/pushnotification-f654b-0d89a7e2c2cc.json'; // Lokasi file JSON di Trusmiverse
		$serviceAccountFile = APPPATH . 'third_party/trusmiontimepushnotification-a820f5b2bfe9.json'; // Lokasi file JSON di Trusmiverse

		// URL token API
		$url = 'https://oauth2.googleapis.com/token';
		
		// Baca file JSON dan ambil informasi client
		$serviceAccount = json_decode(file_get_contents($serviceAccountFile), true);

		// Buat JWT (JSON Web Token)
		$iat = time();
		$exp = $iat + 3600; // Berlaku selama 1 jam
		$header = json_encode(['alg' => 'RS256', 'typ' => 'JWT']);
		$payload = json_encode([
			'iss' => $serviceAccount['client_email'],
			'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
			'aud' => $url,
			'iat' => $iat,
			'exp' => $exp,
		]);
		$jwt = base64_encode($header) . '.' . base64_encode($payload);
		$signature = '';
		openssl_sign($jwt, $signature, $serviceAccount['private_key'], 'sha256');
		$jwt .= '.' . base64_encode($signature);

		// Permintaan token
		$postFields = [
			'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
			'assertion' => $jwt,
		];

		// Kirim permintaan cURL
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/x-www-form-urlencoded',
		]);

		$response = curl_exec($ch);
		$error = curl_error($ch);

		if ($error) {
			log_message('error', 'Error generating OAuth token: ' . $error);
			return null;
		}

		curl_close($ch);
		$response = json_decode($response, true);
		return $response['access_token'] ?? null;
	}

	function sendPushNotif()
	{
		$user_id = $_POST['karyawan'];		
		$i = 0;
		// Persiapan untuk kirim Push Array
		foreach ($user_id as $id) {
			$dt = $this->model->getToken($id);
			$token_client = $dt['token'];

			$title = (isset($_POST['judul']) && $_POST['judul'] != "") ? $_POST['judul'] : "Push Notification Default";
			$body = (isset($_POST['pesan']) && $_POST['pesan'] != "") ? $_POST['pesan'] : "Ini adalah pesan default dari Push Notification";
			$icon = "https://rumahningrat.com/wp-content/uploads/2023/06/render-muka-7.5-TL-AWN-3-subsidi-plus-kanopi-min.png";
			$url = "https://rumahningrat.com/wp-content/uploads/2023/06/render-muka-7.5-TL-AWN-3-subsidi-plus-kanopi-min.png";

			$result['data'][$i] = $this->sendPush($id, $token_client, $title, $body, $icon, $url);
			$i++;
		}

		$data = array(
			'judul' 	=> $title,
			'pesan' 	=> $body,
			'image' 	=> $icon,
			'url' 		=> $url,
			'user_id' 	=> implode(',', $user_id),
			'created_at' => date('Y-m-d H:i:s'),
			'created_by' => $_SESSION['user_id']
		);

		$this->db->insert('trusmi_ontime_notif_push', $data);

		echo json_encode($result);
	}

	function index()
	{
		$data['content'] 			= "push_notification_TrusmiOntime/index";
		$data['pageTitle'] 			= "Push Notification";
		$data['css'] 				= "push_notification_TrusmiOntime/css";
		$data['js'] 				= "push_notification_TrusmiOntime/js";
		$data['list_employees']		= $this->model->get_employee();

		$this->load->view("layout/main", $data);
	}
	
	function list_push_notification()
	{
		$start 	= $_POST['start'];
		$end 	= $_POST['end'];

		$result['data'] = $this->model->list_push_notification($start,$end);
		echo json_encode($result);
	}

	// function save_problem()
	// {
	// 	$id				= $this->model->generate_id_problem_solving();
	// 	$problem		= $_POST['problem'];
	// 	$category		= $_POST['category'];
	// 	$priority		= $_POST['priority'];
	// 	$deadline		= $_POST['deadline'];
	// 	$factor			= $_POST['factor'];
	// 	$pic			= $_POST['pic'];
	// 	$created_at		= date("Y-m-d H:i:s");
	// 	$created_by		= $_SESSION['user_id'];	

	// 	$det = $this->model->get_detail_user($created_by);

	// 	$company_id		= $det['company_id'];		
	// 	$department_id	= $det['department_id'];		
	// 	$designation_id	= $det['designation_id'];		
	// 	$role_id		= $det['role_id'];	

	// 	$data = array (
	// 		"id_ps"				=> $id,
	// 		"problem" 			=> $problem,
	// 		"category_id" 		=> $category,
	// 		"priority_id" 		=> $priority,
	// 		"deadline" 			=> $deadline,
	// 		"factor" 			=> $factor,
	// 		"pic" 				=> $pic,
	// 		"status" 			=> 1,
	// 		"company_id" 		=> $company_id,
	// 		"department_id" 	=> $department_id,
	// 		"designation_id" 	=> $designation_id,
	// 		"role_id" 			=> $role_id,
	// 		"created_at" 		=> $created_at,
	// 		"created_by" 		=> $created_by
	// 	);

	// 	$result['insert_problem'] = $this->db->insert("ps_task", $data);		
	// 	echo json_encode($result);
	// // }
	
	// function list_problem()
	// {
	// 	$start 	= $_POST['start'];
	// 	$end 	= $_POST['end'];

	// 	$result['data'] = $this->model->list_problem($start,$end);
	// 	echo json_encode($result);
	// }

	// function save_proses_resume()
	// {
	// 	$id				= $_POST['id_ps'];
	// 	$status			= $_POST['status_akhir'];
	// 	$resume			= $_POST['resume'];
	// 	$updated_at		= date("Y-m-d H:i:s");
	// 	$updated_by		= $_SESSION['user_id'];	

	// 	$data = array (
	// 		"id_ps"				=> $id,
	// 		"status" 			=> $status,
	// 		"resume" 			=> $resume,
	// 		"updated_at" 		=> $updated_at,
	// 		"updated_by" 		=> $updated_by
	// 	);

	// 	$this->db->where("id_ps", $id);
	// 	$result['update_resume'] = $this->db->update("ps_task", $data);		

	// 	$history = array (
	// 		"ps_id"				=> $id,
	// 		"status" 			=> $status,
	// 		"resume" 			=> $resume,
	// 		"created_at" 		=> $updated_at,
	// 		"created_by" 		=> $updated_by
	// 	);

	// 	$result['insert_history'] = $this->db->insert("ps_task_history", $history);		
	// 	echo json_encode($result);
	// }

	// function get_detail_problem($id)
	// {
	// 	$result = $this->model->get_detail_problem($id);
	// 	echo json_encode($result);
	// }

	
}
