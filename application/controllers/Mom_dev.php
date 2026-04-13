<?php
// ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Mom_dev extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");
		$this->load->model('Model_mom', 'model');
		if ($this->session->userdata('user_id') != "") {
		} else {
			redirect('login', 'refresh');
		}
	}

	function index()
	{
		$data['content'] 	= "mom/index";
		$data['pageTitle'] 	= "Minutes of Meeting";
		$data['css'] 		= "mom/css";
		$data['js'] 		= "mom/js";
		$data['karyawan']	= $this->model->get_employee();
		$data['pic']		= $this->model->get_employee();
		$data['kategori']	= $this->model->get_kategori();
		$data['level']		= $this->model->get_level();
		$data['total']		= $this->model->get_total_kategori();
		$data['department']	= $this->model->get_department();

		$this->load->view("layout/main", $data);
	}

	function resume()
	{
		$data['content'] 	= "mom/resume/index";
		$data['pageTitle'] 	= "Minutes of Meeting";
		$data['css'] 		= "mom/resume/css";
		$data['js'] 		= "mom/resume/js";
		$data['karyawan']	= $this->model->get_employee();
		$data['pic']		= $this->model->get_employee();
		$data['kategori']	= $this->model->get_kategori_new();

		$this->load->view("layout/main", $data);
	}

	function get_list_mom()
	{
		$start 		= $_POST['datestart'];
		$end 		= $_POST['dateend'];
		$closed 	= $_POST['closed'];

		$result['data']   	= $this->model->get_list_mom($start, $end, $closed);
		echo json_encode($result);
	}

	function save_mom()
	{
		$id_mom			= $this->model->generate_id_mom();
		$judul			= $_POST['judul'];
		$tempat			= $_POST['tempat'];
		$tanggal		= $_POST['tanggal'];
		$start_time		= $_POST['start_time'];
		$end_time		= $_POST['end_time'];
		$meeting		= $_POST['meeting'];
		$department		= $_POST['list_department'];
		$agenda			= $_POST['agenda'];
		$peserta 		= $_POST['user'];
		$pembahasan		= $_POST['pembahasan'];
		$created_at		= date("Y-m-d H:i:s");
		$created_by		= $_SESSION['user_id'];

		$closed 		= $_POST['closed']; // Pembeda Draft/Finish

		if ($_POST['id_mom'] == "") {

			$data = array(
				"id_mom" 			=> $id_mom,
				"judul" 			=> $judul,
				"tempat" 			=> $tempat,
				"tgl" 				=> $tanggal,
				"start_time" 		=> $start_time,
				"end_time" 			=> $end_time,
				"meeting" 			=> $meeting,
				"department" 		=> $department,
				"agenda" 			=> $agenda,
				"peserta" 			=> $peserta,
				"pembahasan" 		=> $pembahasan,
				"created_at" 		=> $created_at,
				"created_by" 		=> $created_by,
				"closed"			=> $closed,
				"id_plan" 			=> ($_POST['id_plan'] == "") ? NULL : $_POST['id_plan'],
			);

			$result['data'] = $data;
			$result['insert_mom'] = $this->db->insert("mom_header", $data);
		} else {
			$update = array(
				"judul" 			=> $judul,
				"tempat" 			=> $tempat,
				"tgl" 				=> $tanggal,
				"start_time" 		=> $start_time,
				"end_time" 			=> $end_time,
				"meeting" 			=> $meeting,
				"department" 		=> $department,
				"agenda" 			=> $agenda,
				"peserta" 			=> $peserta,
				"pembahasan" 		=> $pembahasan,
				"created_at" 		=> $created_at,
				"created_by" 		=> $created_by,
				"closed"			=> $closed
			);

			$result['data'] = $update;
			$this->db->where("id_mom", $_POST['id_mom']);
			$result['update_mom'] = $this->db->update("mom_header", $update);
		}
		echo json_encode($result);
	}

	function save_closing()
	{
		$id_mom			= $_POST['id_mom'];
		$closing		= $_POST['closing'];
		$closed			= $_POST['closed']; // Pembeda antara Draft/Finish
		$created_at		= date("Y-m-d H:i:s");
		$created_by		= $_SESSION['user_id'];

		$update = array(
			"closing_statement"	=> $closing,
			"closed" 			=> $closed,
			"created_at" 		=> $created_at,
			"created_by" 		=> $created_by
		);

		$result['id'] 	= $id_mom;
		$result['data'] = $update;
		$this->db->where("id_mom", $id_mom);
		$result['update_mom'] = $this->db->update("mom_header", $update);

		if ($closed == 1) { // Finish
			// Insert to IBR Pro
			$issue 		= $this->model->get_issue_new($id_mom);
			foreach ($issue as $ibr) {
				$id_task 	= $this->model->generate_id_task();
				$data = [
					'id_task' => $id_task,
					'type' => 2, // Khusus MOM
					'category' => 1,
					'object' => 1,
					'status' => 1,
					'pic' => $ibr->pic,
					'priority' => 0,
					'due_date' => $ibr->deadline,
					// 'end' => $ibr->deadline,
					'task' => $ibr->issue,
					'description' => null,
					'created_at' => date("Y-m-d H:i:s"),
					'created_by' => $this->session->userdata('user_id'),
					'progress' => 0,
					'jenis_strategy' => 'Once'
				];
				$result['task'] = $this->db->insert('td_task', $data);

				$data_history = [
					'id_task' => $id_task,
					'progress' => 0,
					'status' => 1,
					'status_before' => 1,
					'note' => 'Goals Created',
					'created_at' => date('Y-m-d H:i:s'),
					'created_by' => $this->session->userdata('user_id')
				];
				$result['history_task'] = $this->db->insert('td_task_history', $data_history);

				$this->db->where("id_mom", $id_mom);
				$this->db->where("id_issue", $ibr->id_issue);
				$result['update_mom_id_task'] = $this->db->update("mom_issue", array("id_task" => $id_task));

				// Insert Strategy				
				$issue_item = $this->model->get_issue_item_new($id_mom, $ibr->id_issue);
				foreach ($issue_item as $item) {
					if ($item->kategori == 8) { // Daily
						$type_kategori = 1;
					} else if ($item->kategori == 9) { // Weekly
						$type_kategori = 2;
					} else { // Monthly
						$type_kategori = 3;
					}
					$id_sub_task = $this->model->generate_id_sub_task();
					$data = [
						'id_sub_task' => $id_sub_task,
						'id_task' => $id_task,
						'sub_task' => $item->action,
						'indicator' => '',
						'type' => $type_kategori,
						'start' => date('Y-m-d H:i:s'),
						'end' => $item->deadline,
						'file' => '',
						'created_at' => date("Y-m-d H:i:s"),
						'created_by' => $this->session->userdata('user_id'),
						'note' => 'Created from MOM',
						'target' => 1,
						'actual' => 0,
						'progress' => 0,
						'jam_notif' => '07:00',
						'day_per_week' => 0,
					];
					$result['sub_task'] = $this->db->insert('td_sub_task', $data);

					$data_history = [
						'id_task' => $id_task,
						'note' => 'Strategy Created : ' . $item->action,
						'created_at' => date('Y-m-d H:i_s'),
						'created_by' => $this->session->userdata('user_id')
					];
					$result['history_sub_task'] = $this->db->insert('td_task_history', $data_history);

					$dt_item = array(
						"id_task" => $id_task,
						"id_sub_task" => $id_sub_task
					);

					$this->db->where("id_mom", $id_mom);
					$this->db->where("id_issue", $ibr->id_issue);
					$this->db->where("id_issue_item", $item->id_issue_item);
					$result['update_mom'] = $this->db->update("mom_issue_item", $dt_item);

					// Kategori : Tasklist & Feedback
					if ($item->kategori == 11) {
						$new 	= $this->model->get_pic_for_approval($id_mom, $ibr->id_issue, $item->id_issue_item);

						foreach ($new as $n) {
							$no_app = $this->model->no_app();
							$approval = array(
								'no_app'            => $no_app,
								'subject'           => $ibr->issue,
								'description'       => "Issuenya " . $ibr->issue . " dan Strategynya " . $item->action,
								'approve_to'        => $n->pic,
								'status'            => 1,
								'tipe'            	=> "MoM", // Bedakan dari MoM
								'id_mom'            => $id_mom, // Bedakan dari MoM
								'id_issue'          => $ibr->id_issue, // Bedakan dari MoM
								'id_issue_item'     => $item->id_issue_item, // Bedakan dari MoM
								'created_at'        => date('Y-m-d', strtotime("+ 1 day")) . " 07:00:00",
								'created_by'        => $this->session->userdata('user_id')
							);

							$result['trusmi_approval'] = $this->db->insert('trusmi_approval', $approval);
							// $result['send_approval'] = $this->send_wa_trusmi_approval($no_app);
						}
					}
				}
				// End Strategy
			}
			// End to IBR Pro

			$result['send'] = $this->send_wa_mom($id_mom);
		}

		echo json_encode($result);
	}

	public function send_wa_mom($id_mom, $tipe = null)
	{
		$result_text['wa_api'] 	= "";
		$mom_wa       			= $this->model->get_send_wa($id_mom);

		$title = 'Result';
		if ($tipe == 'reminder') {
			$title = 'Reminder';
		}

		foreach ($mom_wa as $mom) {
			$tag_no = [
				'</li><li>'
			];
			$bahas = str_replace($tag_no, " | ", $mom['pembahasan']);
			$bahas = strip_tags($bahas);

			$closing = str_replace($tag_no, " | ", $mom['closing_statement']);
			$closing = strip_tags($closing);

			$msg = "📑 *Minutes of Meeting " . $title . "*
			
💡 Judul : " . $mom['judul'] . "
📍 Tempat : " . $mom['tempat'] . "
📆 Tanggal : " . $mom['tgl'] . "
🕗 Waktu : " . $mom['waktu'] . "
📚 Agenda : " . $mom['agenda'] . "
👥 Peserta : " . $mom['peserta'] . "
📝 Pembahasan : " . $bahas . "
🔖 Closing Statement : " . $closing . "

🔗 Detail : " . $mom['link'] . "";
			// echo $msg;

			$url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

			$data_text = array(
				// "channelID" => "2319536345",
				"channelID" => "2225082380",
				"phone" => $mom['kontak'],
				// "phone" => "628993036965",
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

	function cancel_mom($id_mom)
	{
		$result['cancel_mom'] 		= $this->db->delete("mom_header", array('id_mom' => $id_mom));
		$result['cancel_issue_mom'] = $this->db->delete("mom_issue", array('id_mom' => $id_mom));
		$result['cancel_item_mom'] 	= $this->db->delete("mom_issue_item", array('id_mom' => $id_mom));

		echo json_encode($result);
	}

	function save_topik()
	{
		$id_mom 	= $_POST['id_mom'];
		$id_issue 	= $_POST['id_issue'];
		$topik 		= $_POST['topik'];
		$id_issue_item 	= 1;
		$value 			= null;

		$cek_topik 	= $this->model->cek_topik($id_mom, $id_issue);
		$cek_issue_item	= $this->model->cek_issue_item($id_mom, $id_issue, $id_issue_item);

		if ($cek_topik < 1) {
			$mom_result = array(
				'id_mom' => $id_mom,
				'id_issue' => $id_issue,
				'topik' => $topik,
			);

			$result['issue_save'] = $this->db->insert('mom_issue', $mom_result);
		} else {
			$mom_result = array(
				'id_mom' => $id_mom,
				'id_issue' => $id_issue,
				'topik' => $topik,
			);

			$this->db->where('id_mom', $id_mom);
			$this->db->where('id_issue', $id_issue);
			$result['issue_update'] = $this->db->update('mom_issue', $mom_result);
		}

		if ($cek_issue_item < 1) {
			$mom_issue_item = array(
				'id_mom' => $id_mom,
				'id_issue' => $id_issue,
				'id_issue_item' => $id_issue_item,
				'action' => $value,
			);

			$result['issue_item_save'] = $this->db->insert('mom_issue_item', $mom_issue_item);
		}


		$result['cek'] = $cek_topik;

		echo json_encode($result);
	}

	function save_issue()
	{
		$id_mom 		= $_POST['id_mom'];
		$id_issue 		= $_POST['id_issue'];
		$issue 			= $_POST['issue'];
		$id_issue_item 	= 1;
		$value 			= null;

		$cek_issue 		= $this->model->cek_issue($id_mom, $id_issue);
		$cek_issue_item	= $this->model->cek_issue_item($id_mom, $id_issue, $id_issue_item);

		if ($cek_issue < 1) {
			$mom_result = array(
				'id_mom' => $id_mom,
				'id_issue' => $id_issue,
				'issue' => $issue,
			);

			$result['issue_save'] = $this->db->insert('mom_issue', $mom_result);
		} else {
			$mom_result = array(
				'id_mom' => $id_mom,
				'id_issue' => $id_issue,
				'issue' => $issue,
			);

			$this->db->where('id_mom', $id_mom);
			$this->db->where('id_issue', $id_issue);
			$result['issue_update'] = $this->db->update('mom_issue', $mom_result);
		}

		if ($cek_issue_item < 1) {
			$mom_issue_item = array(
				'id_mom' => $id_mom,
				'id_issue' => $id_issue,
				'id_issue_item' => $id_issue_item,
				'action' => $value,
			);

			$result['issue_item_save'] = $this->db->insert('mom_issue_item', $mom_issue_item);
		}

		$result['cek'] = $cek_issue;

		echo json_encode($result);
	}

	function save_issue_item()
	{
		$id_mom 		= $_POST['id_mom'];
		$id_issue 		= $_POST['id_issue'];
		$id_issue_item 	= $_POST['id_issue_item'];
		$input 			= $_POST['input'];
		$value 			= (is_array($_POST['value'])) ? implode(",", $_POST['value']) : $_POST['value'];

		$cek_issue 		= $this->model->cek_issue($id_mom, $id_issue);
		$cek_issue_item	= $this->model->cek_issue_item($id_mom, $id_issue, $id_issue_item);

		if ($cek_issue < 1) {
			$mom_result = array(
				'id_mom' => $id_mom,
				'id_issue' => $id_issue,
				'issue' => null,
			);

			$result['issue_save'] = $this->db->insert('mom_issue', $mom_result);
		}

		if ($cek_issue_item < 1) {
			$mom_issue_item = array(
				'id_mom' => $id_mom,
				'id_issue' => $id_issue,
				'id_issue_item' => $id_issue_item,
				$input => $value,
			);

			$result['issue_item_save'] = $this->db->insert('mom_issue_item', $mom_issue_item);
		} else {
			$mom_issue_item = array(
				$input => $value,
			);

			$this->db->where('id_mom', $id_mom);
			$this->db->where('id_issue', $id_issue);
			$this->db->where('id_issue_item', $id_issue_item);
			$result['issue_item_update'] = $this->db->update('mom_issue_item', $mom_issue_item);
		}

		$result['cek'] = $cek_issue_item;

		echo json_encode($result);
	}

	function get_list_rekap()
	{
		$start 				= $_POST['datestart'];
		$end 				= $_POST['dateend'];

		$result['data']   	= $this->model->get_list_rekap($start, $end);
		echo json_encode($result);
	}

	function get_detail_rekap()
	{
		$start 				= $_POST['datestart'];
		$end 				= $_POST['dateend'];
		$user_id 			= $_POST['user_id'];
		$tipe 				= $_POST['tipe'];

		$result['data']   	= $this->model->get_detail_rekap($start, $end, $user_id, $tipe);
		echo json_encode($result);
	}

	function resume_get_list_rekap()
	{
		$start 				= $_POST['datestart'];
		$end 				= $_POST['dateend'];

		$result['data']   	= $this->model->resume_get_list_rekap($start, $end);
		echo json_encode($result);
	}

	function resume_get_detail_rekap()
	{
		$start 				= $_POST['datestart'];
		$end 				= $_POST['dateend'];
		$user_id 			= $_POST['user_id'];
		$tipe 				= $_POST['tipe'];

		$result['data']   	= $this->model->resume_get_detail_rekap($start, $end, $user_id, $tipe);
		echo json_encode($result);
	}

	// Di pindahkan ke Controller Pr agar bisa diakses tanpa Login
	// function print($id)
	// {
	// 	$data['header']		= $this->model->print_header($id);
	// 	$data['peserta']	= $this->model->print_peserta($id);
	// 	$data['issue']		= $this->model->print_issue($id);

	// $this->load->view("mom/print/print", $data);

	// }	

	function get_result_meeting($id)
	{
		$result['data'] = $this->model->get_result_meeting($id);
		echo json_encode($result);
	}

	function update_result()
	{
		// Update ke MOM
		$id_mom 		= $_POST['id_mom'];
		$id_issue 		= $_POST['id_issue'];
		$id_issue_item 	= $_POST['id_issue_item'];
		$val 			= $_POST['val'];
		$tipe 			= $_POST['tipe'];

		$this->db->where('id_mom', $id_mom);
		$this->db->where('id_issue', $id_issue);
		$this->db->where('id_issue_item', $id_issue_item);
		$result['update_item'] = $this->db->update('mom_issue_item', array($tipe => $val));
		// End Update ke MOM

		if ($tipe == "deadline") {
			// Update ke IBR Pro
			$id_task 		= $_POST['id_task'];
			$id_sub_task 	= $_POST['id_sub_task'];

			$cek = $this->model->cek_due_date_task($id_task);
			if ($val > $cek['due_date']) {
				$this->db->where('id_task', $id_task);
				$result['update_task'] = $this->db->update('td_task', array('due_date' => $val, 'end' => $val));
			}

			$this->db->where('id_task', $id_task);
			$this->db->where('id_sub_task', $id_sub_task);
			$result['update_sub_task'] = $this->db->update('td_sub_task', array('end' => $val));
			// End Update ke IBR Pro
		}

		echo json_encode($result);
	}

	function get_draft_header($id)
	{
		$result = $this->model->get_draft_header($id);
		echo json_encode($result);
	}

	function save_mom_draft()
	{
		$id_mom			= $this->model->generate_id_mom();
		$judul			= $_POST['judul_draft'];
		$tempat			= $_POST['tempat_draft'];
		$tanggal		= $_POST['tanggal_draft'];
		$start_time		= $_POST['start_time_draft'];
		$end_time		= $_POST['end_time_draft'];
		$meeting		= $_POST['meeting_draft'];
		$department		= $_POST['list_department_draft'];
		$agenda			= $_POST['agenda_draft'];
		$peserta 		= $_POST['user_draft'];
		$pembahasan		= $_POST['pembahasan_draft'];
		// $created_at		= date("Y-m-d H:i:s");
		// $created_by		= $_SESSION['user_id'];

		$closed 		= $_POST['closed_draft']; // Pembeda Draft/Finish

		$update = array(
			"judul" 			=> $judul,
			"tempat" 			=> $tempat,
			"tgl" 				=> $tanggal,
			"start_time" 		=> $start_time,
			"end_time" 			=> $end_time,
			"meeting" 			=> $meeting,
			"department" 		=> $department,
			"agenda" 			=> $agenda,
			"peserta" 			=> $peserta,
			"pembahasan" 		=> $pembahasan,
			"closed"			=> $closed
		);

		$result['data'] = $update;
		$this->db->where("id_mom", $_POST['id_mom_draft']);
		$result['update_mom'] = $this->db->update("mom_header", $update);

		echo json_encode($result);
	}

	function save_closing_draft()
	{
		$id_mom			= $_POST['id_mom'];
		$closing		= $_POST['closing'];
		$closed			= $_POST['closed']; // Pembeda antara Draft/Finish
		// $created_at		= date("Y-m-d H:i:s");
		// $created_by		= $_SESSION['user_id'];

		$update = array(
			"closing_statement"	=> $closing,
			"closed" 			=> $closed
		);

		$result['id'] 	= $id_mom;
		$result['data'] = $update;
		$this->db->where("id_mom", $id_mom);
		$result['update_mom'] = $this->db->update("mom_header", $update);

		if ($closed == 1) { // Finish
			// Insert to IBR Pro
			$issue 		= $this->model->get_issue_new($id_mom);
			foreach ($issue as $ibr) {
				$id_task 	= $this->model->generate_id_task();
				$data = [
					'id_task' => $id_task,
					'type' => 2, // Khusus MOM
					'category' => 1,
					'object' => 1,
					'status' => 1,
					'pic' => $ibr->pic,
					'priority' => 0,
					'due_date' => $ibr->deadline,
					'task' => $ibr->issue,
					'description' => null,
					'created_at' => date("Y-m-d H:i:s"),
					'created_by' => $this->session->userdata('user_id'),
					'progress' => 0,
					'jenis_strategy' => 'Once'
				];
				$result['task'] = $this->db->insert('td_task', $data);

				$data_history = [
					'id_task' => $id_task,
					'progress' => 0,
					'status' => 1,
					'status_before' => 1,
					'note' => 'Goals Created',
					'created_at' => date('Y-m-d H:i:s'),
					'created_by' => $this->session->userdata('user_id')
				];
				$result['history_task'] = $this->db->insert('td_task_history', $data_history);

				$this->db->where("id_mom", $id_mom);
				$this->db->where("id_issue", $ibr->id_issue);
				$result['update_mom_id_task'] = $this->db->update("mom_issue", array("id_task" => $id_task));

				// Insert Strategy				
				$issue_item = $this->model->get_issue_item_new($id_mom, $ibr->id_issue);
				foreach ($issue_item as $item) {
					if ($item->kategori == 8) { // Daily
						$type_kategori = 1;
					} else if ($item->kategori == 9) { // Weekly
						$type_kategori = 2;
					} else { // Monthly
						$type_kategori = 3;
					}
					$id_sub_task = $this->model->generate_id_sub_task();
					$data = [
						'id_sub_task' => $id_sub_task,
						'id_task' => $id_task,
						'sub_task' => $item->action,
						'indicator' => '',
						'type' => $type_kategori,
						'start' => date('Y-m-d H:i:s'),
						'end' => $item->deadline,
						'file' => '',
						'created_at' => date("Y-m-d H:i:s"),
						'created_by' => $this->session->userdata('user_id'),
						'note' => 'Created from MOM',
						'target' => 1,
						'actual' => 0,
						'progress' => 0,
						'jam_notif' => '07:00',
						'day_per_week' => 0,
					];
					$result['sub_task'] = $this->db->insert('td_sub_task', $data);

					$data_history = [
						'id_task' => $id_task,
						'note' => 'Strategy Created : ' . $item->action,
						'created_at' => date('Y-m-d H:i_s'),
						'created_by' => $this->session->userdata('user_id')
					];
					$result['history_sub_task'] = $this->db->insert('td_task_history', $data_history);

					$dt_item = array(
						"id_task" => $id_task,
						"id_sub_task" => $id_sub_task
					);

					$this->db->where("id_mom", $id_mom);
					$this->db->where("id_issue", $ibr->id_issue);
					$this->db->where("id_issue_item", $item->id_issue_item);
					$result['update_mom'] = $this->db->update("mom_issue_item", $dt_item);

					// Kategori : Tasklist & Feedback
					if ($item->kategori == 11) {
						$new 	= $this->model->get_pic_for_approval($id_mom, $ibr->id_issue, $item->id_issue_item);

						foreach ($new as $n) {
							$no_app = $this->model->no_app();
							$approval = array(
								'no_app'            => $no_app,
								'subject'           => $ibr->issue,
								'description'       => "Issuenya " . $ibr->issue . " dan Strategynya " . $item->action,
								'approve_to'        => $n->pic,
								'status'            => 1,
								'tipe'            	=> "MoM", // Bedakan dari MoM
								'id_mom'            => $id_mom, // Bedakan dari MoM
								'id_issue'          => $ibr->id_issue, // Bedakan dari MoM
								'id_issue_item'     => $item->id_issue_item, // Bedakan dari MoM
								'created_at'        => date('Y-m-d', strtotime("+ 1 day")) . " 07:00:00",
								'created_by'        => $this->session->userdata('user_id')
							);

							$result['trusmi_approval'] = $this->db->insert('trusmi_approval', $approval);
							// $result['send_approval'] = $this->send_wa_trusmi_approval($no_app);
						}
					}
				}
				// End Strategy
			}
			// End to IBR Pro

			$result['send'] = $this->send_wa_mom($id_mom);
		}

		echo json_encode($result);
	}

	function get_issue_result($id_mom)
	{
		$issue 		= $this->model->get_issue_result($id_mom)->result();
		$cek_issue	= $this->model->get_issue_result($id_mom)->num_rows();
		$pic		= $this->model->get_employee();
		$kategori	= $this->model->get_kategori_new();
		$level		= $this->model->get_level();

		$data = "";
		$select_pic = array();

		if ($cek_issue > 0) {
			foreach ($issue as $val) {
				$data .= '<tr id="div_issue_draft_' . $val->id_issue . '">
						<input type="hidden" id="total_action_draft_' . $val->id_issue . '" value="' . $val->action . '">
						<td class="kolom_modif" id="td_topik_draft_' . $val->id_issue . '" data-id="topik_draft_' . $val->id_issue . '_1" rowspan="' . $val->rowspan . '">
							<span id="topik_draft_' . $val->id_issue . '_1">' . $val->topik . '</span>
							<textarea class="form-control" id="val_topik_draft_' . $val->id_issue . '_1" style="display: none;" class="excel" rows="1" value="' . $val->topik . '" onfocusin="expandTextarea_draft(&apos;val_topik_draft_' . $val->id_issue . '_1&apos;)" onfocusout="submit_update_draft(&apos;topik_draft_' . $val->id_issue . '_1&apos;)">' . $val->topik . '</textarea>
						</td>
						<td class="kolom_modif" id="td_issue_draft_' . $val->id_issue . '" data-id="issue_draft_' . $val->id_issue . '_1" rowspan="' . $val->rowspan . '">
							<span id="issue_draft_' . $val->id_issue . '_1">' . $val->issue . '</span>
							<textarea class="form-control" id="val_issue_draft_' . $val->id_issue . '_1" style="display: none;" class="excel" rows="1" value="' . $val->issue . '" onfocusin="expandTextarea_draft(&apos;val_issue_draft_' . $val->id_issue . '_1&apos;)" onfocusout="submit_update_draft(&apos;issue_draft_' . $val->id_issue . '_1&apos;)">' . $val->issue . '</textarea>
						</td>';

				$issue_item = $this->model->get_issue_item_result($id_mom, $val->id_issue);

				foreach ($issue_item as $val_item) {
					$tr = ($val_item->id_issue_item != 1) ? '<tr>' : '';
					$data .= $tr . '<td width="1%" id="no_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '">' . $val_item->id_issue_item . '.</td>
										<td class="kolom_modif" id="td_action_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '" data-id="action_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '">
											<span id="action_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '">' . $val_item->action . '</span>
											<textarea class="form-control" id="val_action_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '" value="' . $val_item->action . '" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea_draft(&apos;val_action_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '&apos;)" onfocusout="submit_update_draft(&apos;action_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '&apos;)">' . $val_item->action . '</textarea>
										</td>
										<td class="kolom_modif" id="td_kategori_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '" data-id="kategori_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '">
											<select class="form-control" id="val_kategori_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '" onchange="submit_update_draft(&apos;kategori_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '&apos;)">
												<option>- Choose -</option>';

					foreach ($kategori as $ktg) {
						if ($ktg->id == $val_item->kategori) {
							$data .=  '<option value="' . $ktg->id . '" selected>' . $ktg->kategori . '</option>';
						} else {
							$data .=  '<option value="' . $ktg->id . '">' . $ktg->kategori . '</option>';
						}
					}

					$data .= '</select>
										</td>
										<td class="kolom_modif" id="td_level_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '" data-id="level_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '">
											<select class="form-control" id="val_level_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '" onchange="submit_update_draft(&apos;level_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '&apos;)">
												<option value="">- Choose -</option>';

					foreach ($level as $lvl) {
						if ($lvl->id == $val_item->level) {
							$data .=  '<option value="' . $lvl->id . '|' . $lvl->day . '" selected>' . $lvl->leveling . '</option>';
						} else {
							$data .=  '<option value="' . $lvl->id . '|' . $lvl->day . '">' . $lvl->leveling . '</option>';
						}
					}

					$data .= '</select>
										</td>
										<td class="kolom_modif" id="td_deadline_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '" data-id="deadline_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '">
											<span id="deadline_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '">' . $val_item->deadline . '</span>
											<textarea class="form-control" id="val_deadline_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '" value="' . $val_item->deadline . '" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea_draft(&apos;val_deadline_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '&apos;)" onfocusout="submit_update_draft(&apos;deadline_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '&apos;)">' . $val_item->deadline . '</textarea>
											<input type="text" class="form-control tanggal" id="val_date_deadline_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '" value="' . $val_item->deadline . '" style="display: none;" onfocusout="submit_update_draft(&apos;deadline_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '&apos;)">
										</td>
										<td id="td_pic_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '">
											<select id="val_pic_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '" class="form-control pic" multiple onchange="submit_update_draft(&apos;pic_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '&apos;)">
												<option data-placeholder="true">-- Choose Employee --</option>';

					foreach ($pic as $row) {
						$data .=  '<option value="' . $row->user_id . '">' . $row->employee_name . '</option>';
					}

					$data .= '</select>
										</td>
									</tr>';

					$select_pic[] = array(
						'id' => 'val_pic_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item,
						'pic' => explode(',', $val_item->pic)
					);
				}

				if ($val->action > 1) {
					$hidden_btn_remove_action = '';
					$hidden_btn_remove_issue = 'style="display:none;"';
				} else {
					$hidden_btn_remove_action = 'style="display:none;"';
					$hidden_btn_remove_issue = '';
				}

				$data .= '<tr id="div_issue_action_draft_' . $val->id_issue . '">
							<td style="cursor: pointer;" colspan="6">
								<span class="btn btn-md btn-outline-success" onclick="add_action_draft(' . $val->id_issue . ')"><i class="bi bi-plus-square"></i> Strategy</span>
								<span class="btn btn-md btn-outline-danger" id="btn_remove_action_draft_' . $val->id_issue . '" ' . $hidden_btn_remove_action . ' onclick="remove_action_draft(' . $val->id_issue . ')"><i class="bi bi-dash-square"></i> Strategy</span>
							</td>
						</tr>
						';
			}

			$data .= '<tr id="div_issue_draft">
							<td style="cursor: pointer;" colspan="8">
								<span class="btn btn-md btn-outline-success" onclick="add_issue_draft(' . $val->id_issue . ')"><i class="bi bi-plus-square"></i></i> Issue</span>
								<span class="btn btn-md btn-outline-danger btn_remove_issue_draft" ' . $hidden_btn_remove_issue . ' onclick="remove_issue_draft(' . $val->id_issue . ')"><i class="bi bi-dash-square"></i></i> Issue</span>
							</td>
						</tr>';

			$result['pic'] = $select_pic;
		} else {
			$data .= '<tr id="div_issue_draft_1">
						<input type="hidden" id="total_action_draft_1" value="1">
						<td class="kolom_modif" id="td_topik_draft_1" data-id="topik_draft_1_1" rowspan="2">
							<span id="topik_draft_1_1">&nbsp;</span>
							<textarea class="form-control" id="val_topik_draft_1_1" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea_draft(&apos;val_topik_1_1&apos;)" onfocusout="submit_update_draft(&apos;topik_draft_1_1&apos;)"></textarea>
						</td>
						<td class="kolom_modif" id="td_issue_draft_1" data-id="issue_draft_1_1" rowspan="2">
							<span id="issue_draft_1_1">&nbsp;</span>
							<textarea class="form-control" id="val_issue_draft_1_1" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea_draft(&apos;val_issue_1_1&apos;)" onfocusout="submit_update_draft(&apos;issue_draft_1_1&apos;)"></textarea>
						</td>
						<td width="1%" id="no_draft_1_1">1.</td>
						<td class="kolom_modif" id="td_action_draft_1_1" data-id="action_draft_1_1">
							<span id="action_draft_1_1">&nbsp;</span>
							<textarea class="form-control" id="val_action_draft_1_1" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea_draft(&apos;val_action_1_1&apos;)" onfocusout="submit_update_draft(&apos;action_draft_1_1&apos;)"></textarea>
						</td>
						<td class="kolom_modif" id="td_kategori_draft_1_1" data-id="kategori_draft_1_1">
							<select class="form-control" id="val_kategori_draft_1_1" onchange="submit_update_draft(&apos;kategori_1_1&apos;)">
								<option>- Choose -</option>';
			foreach ($kategori as $ktg) {
				$data .= '<option value="' . $ktg->id . '">' . $ktg->kategori . '</option>';
			}

			$data .= '</select>
						</td>
						<td class="kolom_modif" id="td_level_draft_1_1" data-id="level_draft_1_1">
							<select class="form-control" id="val_level_draft_1_1" onchange="submit_update_draft(&apos;level_draft_1_1&apos;)">
								<option value="">- Choose -</option>';

			foreach ($level as $lvl) {
				$data .=  '<option value="' . $lvl->id . '|' . $lvl->day . '">' . $lvl->leveling . '</option>';
			}

			$data .= '</select>
						</td>
						<td class="kolom_modif" id="td_deadline_draft_1_1" data-id="deadline_draft_1_1">
							<span id="deadline_draft_1_1">&nbsp;</span>
							<textarea class="form-control" id="val_deadline_draft_1_1" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea_draft(&apos;val_deadline_1_1&apos;)" onfocusout="submit_update_draft(&apos;deadline_1_1&apos;)"></textarea>
							<input type="text" class="form-control tanggal" id="val_date_deadline_draft_1_1" style="display: none;" onfocusout="submit_update_draft(&apos;deadline_1_1&apos;)">
						</td>
						<td id="td_pic_draft_1_1">
							<select id="val_pic_draft_1_1" class="form-control pic" multiple onchange="submit_update_draft(&apos;pic_1_1&apos;)">
								<option data-placeholder="true">-- Choose Employee --</option>';
			foreach ($pic as $row) {
				$data .= '<option value="' . $row->user_id . '">' . $row->employee_name . '</option>';
			}
			$data .= 		'</select>
						</td>
					</tr>
					<tr id="div_issue_action_draft_1">
						<td style="cursor: pointer;" colspan="6">
							<span class="btn btn-md btn-outline-success" onclick="add_action_draft(1)"><i class="bi bi-plus-square"></i> Strategy</span>
							<span class="btn btn-md btn-outline-danger" id="btn_remove_action_draft_1" onclick="remove_action_draft(1)" style="display:none;"><i class="bi bi-dash-square"></i> Strategy</span>
						</td>
					</tr>
					<tr id="div_issue_draft">
						<td style="cursor: pointer;" colspan="8">
							<span class="btn btn-md btn-outline-success" onclick="add_issue_draft(1)"><i class="bi bi-plus-square"></i></i> Issue</span>
							<span class="btn btn-md btn-outline-danger btn_remove_issue_draft" onclick="remove_issue_draft(1)" style="display:none;"><i class="bi bi-dash-square"></i></i> Issue</span>
						</td>
					</tr>';
		}

		$result['table'] = $data;
		$result['result'] = $cek_issue;
		echo json_encode($result);
	}

	function clear_result()
	{
		$pic		= $this->model->get_employee();
		$kategori	= $this->model->get_kategori_new();
		$level		= $this->model->get_level();

		$data = "";
		$data .= '<tr id="div_issue_1">
					<input type="hidden" id="total_action_1" value="1">
					<td class="kolom_modif" id="td_topik_1" data-id="topik_1_1" rowspan="2">
						<span id="topik_1_1">&nbsp;</span>
						<textarea class="form-control" id="val_topik_1_1" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea(&apos;val_topik_1_1&apos;)" onfocusout="submit_update(&apos;topik_1_1&apos;)"></textarea>
					</td>
					<td class="kolom_modif" id="td_issue_1" data-id="issue_1_1" rowspan="2">
						<span id="issue_1_1">&nbsp;</span>
						<textarea class="form-control" id="val_issue_1_1" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea(&apos;val_issue_1_1&apos;)" onfocusout="submit_update(&apos;issue_1_1&apos;)"></textarea>
					</td>
					<td width="1%" id="no_1_1">1.</td>
					<td class="kolom_modif" id="td_action_1_1" data-id="action_1_1">
						<span id="action_1_1">&nbsp;</span>
						<textarea class="form-control" id="val_action_1_1" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea(&apos;val_action_1_1&apos;)" onfocusout="submit_update(&apos;action_1_1&apos;)"></textarea>
					</td>
					<td class="kolom_modif" id="td_kategori_1_1" data-id="kategori_1_1">
						<select class="form-control" id="val_kategori_1_1" onchange="submit_update(&apos;kategori_1_1&apos;)">
							<option>- Choose -</option>';
		foreach ($kategori as $ktg) {
			$data .= '<option value="' . $ktg->id . '">' . $ktg->kategori . '</option>';
		}
		$data .=		'</select>
					</td>
					<td class="kolom_modif" id="td_level_1_1" data-id="level_1_1">
						<select class="form-control" id="val_level_1_1" style="display: none;" onchange="submit_update(&apos;level_1_1&apos;)">
							<option value="">- Choose -</option>';
		foreach ($level as $lvl) {
			$data .= '<option value="' . $lvl->id . '|' . $lvl->day . '">' . $lvl->leveling . '</option>';
		}
		$data .=		'</select>
					</td>
					<td class="kolom_modif" id="td_deadline_1_1" data-id="deadline_1_1">
						<span id="deadline_1_1">&nbsp;</span>
						<textarea class="form-control" id="val_deadline_1_1" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea(&apos;val_deadline_1_1&apos;)" onfocusout="submit_update(&apos;deadline_1_1&apos;)"></textarea>
						<input type="text" class="form-control tanggal" id="val_date_deadline_1_1" style="display: none;" onfocusout="submit_update(&apos;deadline_1_1&apos;)">
					</td>
					<td id="td_pic_1_1">
						<select id="val_pic_1_1" class="form-control pic" multiple onchange="submit_update(&apos;pic_1_1&apos;)">
							<option data-placeholder="true">-- Choose Employee --</option>';
		foreach ($pic as $row) {
			$data .= '<option value="' . $row->user_id . '">' . $row->employee_name . '</option>';
		}
		$data .= 		'</select>
					</td>
				</tr>
				<tr id="div_issue_action_1">
					<td style="cursor: pointer;" colspan="6">
						<span class="btn btn-md btn-outline-success" onclick="add_action(1)"><i class="bi bi-plus-square"></i> Strategy</span>
						<span class="btn btn-md btn-outline-danger" id="btn_remove_action_1" onclick="remove_action(1)" style="display:none;"><i class="bi bi-dash-square"></i> Strategy</span>
					</td>
				</tr>
				<tr id="div_issue">
					<td style="cursor: pointer;" colspan="8">
						<span class="btn btn-md btn-outline-success" onclick="add_issue(1)"><i class="bi bi-plus-square"></i></i> Issue</span>
						<span class="btn btn-md btn-outline-danger btn_remove_issue" onclick="remove_issue(1)" style="display:none;"><i class="bi bi-dash-square"></i></i> Issue</span>
					</td>
				</tr>';

		$result = $data;
		echo json_encode($result);
	}

	function delete_issue()
	{
		$id_mom 	= $_POST['id_mom'];
		$id_issue 	= $_POST['id_issue'];

		if ($id_mom != "" || $id_mom != NULL) {
			$this->db->where('id_mom', $id_mom);
			$this->db->where('id_issue', $id_issue);
			$result['delete_issue'] = $this->db->delete('mom_issue');
		} else {
			$result['delete_issue'] = "Delete issue failed";
		}

		echo json_encode($result);
	}

	function delete_issue_item()
	{
		$id_mom 		= $_POST['id_mom'];
		$id_issue 		= $_POST['id_issue'];
		$id_issue_item 	= $_POST['id_issue_item'];

		if ($id_mom != "" || $id_mom != NULL) {
			$this->db->where('id_mom', $id_mom);
			$this->db->where('id_issue', $id_issue);
			$this->db->where('id_issue_item', $id_issue_item);
			$result['delete_issue_item'] = $this->db->delete('mom_issue_item');
		} else {
			$result['delete_issue_item'] = "Delete issue item failed";
		}

		echo json_encode($result);
	}

	function excel($id)
	{
		$data['header']		= $this->model->print_header($id);
		$data['peserta']	= $this->model->print_peserta($id);
		$data['issue']		= $this->model->print_issue($id);

		$this->load->view("mom/print/excel", $data);
	}

	function check_validasi_result($id_mom)
	{
		$data 	= $this->model->check_validasi_result($id_mom)->result_array();
		$row 	= $this->model->check_validasi_result($id_mom)->num_rows();

		$result['eksekusi'] = true;

		foreach ($data as $key) {
			if ($key['topik'] == '') {
				$result['warning'] 	= "Topik ke-" . $key['id_issue'] . " belum terisi!";
				$result['eksekusi'] = false;
				break;
			} else if ($key['issue'] == '') {
				$result['warning'] 	= "Issue ke-" . $key['id_issue'] . " belum terisi!";
				$result['eksekusi'] = false;
				break;
			} else if ($key['action'] == '') {
				$result['warning'] 	= "Topik ke-" . $key['id_issue'] . " Strategy ke-" . $key['id_issue_item'] . " belum terisi!";
				$result['eksekusi'] = false;
				break;
			} else if ($key['level'] == '' || $key['level'] == 0) {
				$result['warning'] 	= "Level untuk Topik ke-" . $key['id_issue'] . " Strategy ke-" . $key['id_issue_item'] . " belum terisi!";
				$result['eksekusi'] = false;
				break;
			} else if ($key['deadline'] == '') {
				$result['warning'] 	= "Deadline untuk Topik ke-" . $key['id_issue'] . " Strategy ke-" . $key['id_issue_item'] . " belum terisi!";
				$result['eksekusi'] = false;
				break;
			} else if ($key['pic'] == '') {
				$result['warning'] 	= "PIC untuk Topik ke-" . $key['id_issue'] . " Strategy ke-" . $key['id_issue_item'] . " belum terisi!";
				$result['eksekusi'] = false;
				break;
			}
		}

		echo json_encode($result);
	}

	function save_plan()
	{
		$id_plan		= $this->model->generate_id_plan();
		$judul			= $_POST['judul_plan'];
		$tempat			= $_POST['tempat_plan'];
		$tanggal		= substr($_POST['tanggal_plan'], 0, 10);
		$start_time		= substr($_POST['tanggal_plan'], 11, 5);
		$meeting		= $_POST['meeting_plan'];
		$department		= $_POST['list_department_plan'];
		$peserta 		= $_POST['user_plan'];
		$note 			= $_POST['note_plan'];
		$created_at		= date("Y-m-d H:i:s");
		$created_by		= $_SESSION['user_id'];

		$data = array(
			"id_plan" 			=> $id_plan,
			"judul" 			=> $judul,
			"tempat" 			=> $tempat,
			"tgl" 				=> $tanggal,
			"start_time" 		=> $start_time,
			"meeting" 			=> $meeting,
			"department" 		=> $department,
			"peserta" 			=> $peserta,
			"note" 				=> $note,
			"created_at" 		=> $created_at,
			"created_by" 		=> $created_by
		);

		$result['insert_plan'] = $this->db->insert("mom_plan", $data);

		$pic 		= explode(",", $peserta);

		$date = date_create($tanggal);
		date_sub($date, date_interval_create_from_date_string("1 days"));
		$deadline = date_format($date, "Y-m-d");

		foreach ($pic as $key) {
			$bahan = array(
				"id_plan" 		=> $id_plan,
				"pic" 			=> $key,
				"deadline" 		=> $deadline
			);

			$result['insert_bahan'] = $this->db->insert("mom_plan_bahan", $bahan);
		}

		$this->send_wa_plan($id_plan);
		echo json_encode($result);
	}

	public function send_wa_plan($id_plan)
	{
		$result_text['wa_api'] 	= "";
		$plan_wa       			= $this->model->get_plan_send_wa($id_plan);

		foreach ($plan_wa as $plan) {
			$msg = "📑 *New Agenda Meeting*
			
💡 Judul : " . $plan['judul'] . "
📍 Tempat : " . $plan['tempat'] . "
📆 Tanggal : " . $plan['tgl'] . "
🕗 Waktu : " . $plan['waktu'] . "
👥 Peserta : " . $plan['peserta'] . "
📝 Note : " . $plan['note'] . "

Mohon persiapkan data penunjang meeting maksimal tanggal *" . $plan['deadline'] . "*
melalui link berikut, jika tidak upload akan berlaku *Lock Absen*
" . $plan['link'];

			// echo $msg;

			$url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

			$data_text = array(
				// "channelID" => "2319536345",
				"channelID" => "2225082380",
				"phone" => $plan['kontak'],
				// "phone" => "628993036965",
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

	function get_list_plan()
	{
		// $start 		= $_POST['datestart'];
		// $end 		= $_POST['dateend'];
		// $closed 	= $_POST['closed'];

		$result['data']   	= $this->model->get_list_plan();
		echo json_encode($result);
	}

	function get_list_plan_bahan()
	{
		// $start 		= $_POST['datestart'];
		// $end 		= $_POST['dateend'];
		$id_plan		= $_POST['id_plan'];

		$result['data']   	= $this->model->get_list_plan_bahan($id_plan);
		echo json_encode($result);
	}

	function get_data_plan($id_plan)
	{
		$result = $this->model->get_data_plan($id_plan);
		echo json_encode($result);
	}

	function excel_detail($start, $end)
	{
		$data['issue']		= $this->model->print_issue_detail($start, $end);

		$this->load->view("mom/print/excel_detail", $data);
	}

	function hapus_draft($id_mom)
	{
		$result['hapus_draft_mom'] 			= $this->db->delete("mom_header", array('id_mom' => $id_mom));
		$result['hapus_draft_issue_mom'] 	= $this->db->delete("mom_issue", array('id_mom' => $id_mom));
		$result['hapus_draft_item_mom'] 	= $this->db->delete("mom_issue_item", array('id_mom' => $id_mom));

		echo json_encode($result);
	}

	// Send Notifikasi Trusmi Approval
	public function send_wa_trusmi_approval($no_app)
	{
		$result_text['wa_api'] 	= "";
		$data_wa_approval       = $this->model->get_send_wa_trusmi_approval($no_app);

		foreach ($data_wa_approval as $apr) {

			$msg = "📣 Alert!!!
*There is New Request Approval*
📝 Approve To : " . $apr->approve_to . "
👤 Requested By : " . $apr->requested_by . "
🕐 Requested At : " . $apr->requested_at . "

No. App : " . $apr->no_app . "
Subject : *" . $apr->subject . "*
Description : " . $apr->description . "

🌐 Link Approve : " . $apr->link_approve . "";
			// echo $msg;

			$url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

			$data_text = array(
				// "channelID" => "2319536345",
				"channelID" => "2225082380",
				"phone" => $apr->kontak,
				// "phone" => "628993036965",
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


	public function generate_head_resume_v3()
	{
		$start = date("Y-m-01");
		$end = date("Y-m-t");
		$data = $this->db->query("SELECT
                        CONCAT('W',@rank := @rank + 1) AS week_number,
                        CASE WHEN SUBSTR(calendar_week.tgl_awal,1,7) = SUBSTR(calendar_week.tgl_akhir,1,7)  THEN
                            DATE_FORMAT(calendar_week.tgl_awal,'%d')
                        WHEN SUBSTR(calendar_week.tgl_awal,1,4) != SUBSTR(calendar_week.tgl_akhir,1,4) THEN
                            DATE_FORMAT(calendar_week.tgl_awal,'%d %b %y')
                        ELSE
                            DATE_FORMAT(calendar_week.tgl_awal,'%d %b')
                        END AS f_tgl_awal,
	                    CASE WHEN SUBSTR(calendar_week.tgl_awal,1,7) = SUBSTR(calendar_week.tgl_akhir,1,7)  THEN
                            DATE_FORMAT(calendar_week.tgl_akhir,'%d %b %y')
                        WHEN SUBSTR(calendar_week.tgl_awal,1,4) != SUBSTR(calendar_week.tgl_akhir,1,4) THEN
                            DATE_FORMAT(calendar_week.tgl_akhir,'%d %b %y')
                        ELSE
                            DATE_FORMAT(calendar_week.tgl_akhir,'%d %b %y')
                        END AS f_tgl_akhir,
                        calendar_week.* 
                    FROM (
                        SELECT
                            start_date AS `tgl_awal`,
                            (start_date + INTERVAL 6 DAY) AS tgl_akhir
                        FROM 
                        (
                            SELECT 
                                ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                            FROM
                                (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                                (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                                (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                                (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                                (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                        ) v
                        WHERE start_date BETWEEN DATE_SUB('$start', INTERVAL 1 WEEK) AND '$end' AND WEEKDAY(start_date) = 6
                        GROUP BY (start_date)
                        ORDER BY (start_date)
                    ) AS calendar_week, 
                    (SELECT @rank := 0 ) AS num");
		$response['data'] = $data->result();

		$body_resume = $this->generate_body_resume_v3($start, $end, $data->num_rows());
		$response['body_resume'] = $body_resume;
		$response['jumlah_week'] = $data->num_rows();
		echo json_encode($response);
	}

	public function generate_body_resume_v3($start, $end, $jumlah_week)
	{
		$select = "";
		$week = 1;
		for ($i = 0; $i < $jumlah_week; $i++) {
			$select .= " CASE WHEN xx.user_id IN (118,637,116,998,4201) THEN COUNT(IF(xx.input >= 3 AND xx.w = '$week',1,NULL))
						ELSE COUNT(IF(xx.input >= 1 AND xx.w = '$week',1,NULL)) END AS w" . $week . ",";
			$select .= " SUM(IF(xx.w = '$week',COALESCE(xx.input,0),0)) AS input_w" . $week . ",";
			$week++;
		}

		$user_id        = $_SESSION['user_id'];
		$role_id        = $_SESSION['user_role_id'];

		$kondisi = "";
		if ($role_id == 1) { // Ittrusmi & Super Admin & Viky & Lintang(Sekdir) & Pak Ibnu
			$kondisi = "";
			// // } else if ($department_id == 117) { // PDCA RSP
			// // $kondisi = "";
		} else {
			$kondisi = "WHERE xx.user_id = $user_id ";
		}

		$query = "SELECT 
                    xx.user_id, 
                    xx.employee_name,
                    $select 
                    xx.company_name,
                    xx.jabatan
                FROM(
                    SELECT tm.user_id, tm.employee_name, tm.company_name, tm.jabatan, th.w, th.tgl_awal, th.tgl_akhir, SUM(IF(th.w IS NOT NULL,1,0)) AS input FROM
                      (
                      SELECT 
                      a.user_id,  CONCAT(a.first_name, ' ', a.last_name) AS employee_name,
                      a.company_id, a.department_id, a.designation_id, c.name AS company_name, ds.designation_name AS jabatan
                      FROM xin_employees a
                      LEFT JOIN xin_user_roles ur ON ur.role_id = a.user_role_id
                      LEFT JOIN xin_companies c ON c.company_id = a.company_id
                      LEFT JOIN xin_departments d ON d.department_id = a.department_id
                      LEFT JOIN xin_designations ds ON ds.designation_id = a.designation_id
                      WHERE a.is_active = 1 AND (user_id IN (118,637,116,998,4201) OR user_id IN (2108,2733,1294,1733,1369,2127,1844))
                      ) tm
                      LEFT JOIN mom_plan b ON FIND_IN_SET(tm.user_id, peserta)
                      LEFT JOIN (
                                          SELECT
                                              @rank := @rank + 1 AS w,
                                              calendar_week.* 
                                          FROM (
                                              SELECT
                                                  start_date AS `tgl_awal`,
                                                  (start_date + INTERVAL 6 DAY) AS tgl_akhir
                                              FROM 
                                              (
                                                  SELECT 
                                                      ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                                                  FROM
                                                      (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                                                      (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                                                      (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                                                      (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                                                      (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                                              ) v
                                              WHERE start_date BETWEEN DATE_SUB('$start', INTERVAL 1 WEEK) AND '$end' AND WEEKDAY(start_date) = 6
                                              GROUP BY (start_date)
                                              ORDER BY (start_date)
                                          ) AS calendar_week, 
                                          (SELECT @rank := 0 ) AS num
                    ) th ON SUBSTR(b.tgl,1,10) BETWEEN th.tgl_awal AND th.tgl_akhir
                    GROUP BY tm.user_id, th.w
                ) xx $kondisi GROUP BY xx.user_id";
		return $this->db->query($query)->result();
	}
	// public function sendEmail()
	// {
	// 	$email_config = array(
	// 		'protocol' => 'smtp',
	// 		'smtp_host' => 'ssl://smtp.googlemail.com',
	// 		'smtp_port' => 465,
	// 		'smtp_user' => 'sukilgd@gmail.com',
	// 		'smtp_pass' => 'windu123',
	// 		'mailtype' => 'html',
	// 		'charset' => 'iso-8859-1',
	// 		'wordwrap' => TRUE
	// 	);
	// 	// $ical = "BEGIN:VCALENDAR
	// 	// 		VERSION:2.0
	// 	// 		PRODID:-//ZContent.net//Zap Calendar 1.0//EN
	// 	// 		CALSCALE:GREGORIAN
	// 	// 		METHOD:PUBLISH
	// 	// 		BEGIN:VEVENT
	// 	// 		SUMMARY:{$sub_point}
	// 	// 		UID:c7614cff-3549-4a00-9152-d25cc1fe077d
	// 	// 		SEQUENCE:0
	// 	// 		STATUS:CONFIRMED
	// 	// 		TRANSP:TRANSPARENT
	// 	// 		ORGANIZER;CN={$cn}:MAILTO:{$email}
	// 	// 		DTSTART:{$deadline}
	// 	// 		DTEND:{$deadline}
	// 	// 		END:VEVENT
	// 	// 		END:VCALENDAR";
	// 	$this->email->clear(TRUE);
	// 	$this->email->set_newline("\r\n");
	// 	$this->email->from('sukilgd@gmail.com', 'Suki');  // email From
	// 	$this->email->to('winduaritonang2602@gmail.com');
	// 	$this->email->subject('Minute Of Meeting');  // Subject
	// 	$this->email->message($message);  // Message
	// 	$maill = $this->email->send(); // send mail
	// 	if ($maill > 0) {
	// 		echo 'Email sent.';  // success
	// 	} else {
	// 		show_error($this->email->print_debugger());
	// 	}
	// }
}
