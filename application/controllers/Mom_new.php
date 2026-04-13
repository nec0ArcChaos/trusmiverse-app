<?php
// ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Mom_new extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");
		$this->load->model('Model_mom_new', 'model');
		if ($this->session->userdata('user_id') != "") {
		} else {
			redirect('login', 'refresh');
		}
	}

	function index()
	{
		$data['content'] 	= "mom_new/index";
		$data['pageTitle'] 	= "Minutes of Meeting | Faisal";
		$data['css'] 		= "mom_new/css";
		$data['js'] 		= "mom_new/js";
		$data['karyawan']	= $this->model->get_employee();
		$data['pic']		= $this->model->get_employee();
		$data['kategori']	= $this->model->get_kategori();
		$data['total']		= $this->model->get_total_kategori();

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
		$data['kategori']	= $this->model->get_kategori();

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
				"agenda" 			=> $agenda,
				"peserta" 			=> $peserta,
				"pembahasan" 		=> $pembahasan,
				"created_at" 		=> $created_at,
				"created_by" 		=> $created_by,
				"closed"			=> $closed
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

	function save_issue()
	{
		$id_mom 	= $_POST['id_mom'];
		$id_issue 	= $_POST['id_issue'];
		$issue 		= $_POST['issue'];
		$cek_issue 	= $this->model->cek_issue($id_mom, $id_issue);

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
		$cek_issue 		= $this->model->cek_issue_item($id_mom, $id_issue, $id_issue_item);

		if ($cek_issue < 1) {
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


		$result['cek'] = $cek_issue;

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
				$result['update_task'] = $this->db->update('td_task', array('due_date' => $val));
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
		$kategori	= $this->model->get_kategori();

		$data = "";
		$select_pic = array();

		if ($cek_issue > 0) {
			foreach ($issue as $val) {
				$data .= '<tr id="div_issue_draft_' . $val->id_issue . '">
						<input type="hidden" id="total_action_draft_' . $val->id_issue . '" value="' . $val->action . '">
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
							<td style="cursor: pointer;" colspan="5">
								<span class="btn btn-md btn-outline-success" onclick="add_action_draft(' . $val->id_issue . ')"><i class="bi bi-plus-square"></i> Action</span>
								<span class="btn btn-md btn-outline-danger" id="btn_remove_action_draft_'. $val->id_issue .'" '. $hidden_btn_remove_action .' onclick="remove_action_draft(' . $val->id_issue . ')"><i class="bi bi-dash-square"></i> Action</span>
							</td>
						</tr>
						';
			}

			$data .= '<tr id="div_issue_draft">
							<td style="cursor: pointer;" colspan="6">
								<span class="btn btn-md btn-outline-success" onclick="add_issue_draft(' . $val->id_issue . ')"><i class="bi bi-plus-square"></i></i> Issue</span>
								<span class="btn btn-md btn-outline-danger btn_remove_issue_draft" '. $hidden_btn_remove_issue .' onclick="remove_issue_draft(' . $val->id_issue . ')"><i class="bi bi-dash-square"></i></i> Issue</span>
							</td>
						</tr>';

			$result['pic'] = $select_pic;
		} else {
			$data .= '<tr id="div_issue_draft_1">
						<input type="hidden" id="total_action_draft_1" value="1">
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
			$data .=		'</select>
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
						<td style="cursor: pointer;" colspan="5">
							<span class="btn btn-md btn-outline-success" onclick="add_action_draft(1)"><i class="bi bi-plus-square"></i> Action</span>
							<span class="btn btn-md btn-outline-danger" id="btn_remove_action_draft_1" onclick="remove_action_draft(1)"><i class="bi bi-dash-square"></i> Action</span>
						</td>
					</tr>
					<tr id="div_issue_draft">
						<td style="cursor: pointer;" colspan="6">
							<span class="btn btn-md btn-outline-success" onclick="add_issue_draft(1)"><i class="bi bi-plus-square"></i></i> Issue</span>
							<span class="btn btn-md btn-outline-danger btn_remove_issue_draft" onclick="remove_issue_draft(1)"><i class="bi bi-dash-square"></i></i> Issue</span>
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
		$kategori	= $this->model->get_kategori();

		$data = "";
		$data .= '<tr id="div_issue_1">
					<input type="hidden" id="total_action_1" value="1">
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
					<td style="cursor: pointer;" colspan="5">
						<span class="btn btn-md btn-outline-success" onclick="add_action(1)"><i class="bi bi-plus-square"></i> Action</span>
						<span class="btn btn-md btn-outline-danger" id="btn_remove_action_1" onclick="remove_action(1)" style="display:none;"><i class="bi bi-dash-square"></i> Action</span>
					</td>
				</tr>
				<tr id="div_issue">
					<td style="cursor: pointer;" colspan="6">
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
}
