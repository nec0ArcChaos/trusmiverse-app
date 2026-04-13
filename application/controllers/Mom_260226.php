<?php
// ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Mom extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");
		$this->load->library("whatsapp_lib");
		$this->load->model('Model_mom', 'model');
		if ($this->session->userdata('user_id') != "") {
		} else {
			redirect('login', 'refresh');
		}
	}

	function index()
	{
		$data['content'] 	= "mom/index";
		$data['pageTitle'] 	= "Minutes of Meeting | New";
		$data['css'] 		= "mom/css";
		$data['js'] 		= "mom/js";
		$data['karyawan']	= $this->model->get_employee();
		$data['pic']		= $this->model->get_employee();
		$data['goals']      = $this->model->get_goals();
		$data['kategori']	= $this->model->get_kategori_new2();
		$data['grdsi']		= $this->model->get_grd_si();
		$data['level']		= $this->model->get_level();
		$data['total']		= $this->model->get_total_kategori();
		$data['department']	= $this->model->get_department();
		// $data['project']	= $this->model->get_project();
		$data['project']	= $this->db->query("SELECT divisi AS project, divisi AS id_project FROM `grd_m_so` GROUP BY divisi")->result();;
		$data['pekerjaan']	= $this->db->query("SELECT id, pekerjaan FROM hris.m_pekerjaan;")->result();

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
		$data['kategori']	= $this->model->get_kategori_new2();

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
		if (isset($_POST['pekerjaan']) && $_POST['pekerjaan'] != '-- Choose Pekerjaan --') {
			$project 		= $_POST['project'];
			$pekerjaan 		= $_POST['pekerjaan'];
			$sub_pekerjaan 	= $_POST['sub_pekerjaan'];
			$detail_pekerjaan	= $_POST['list_det_pekerjaan'];
		} else {
			$project = null;
			$pekerjaan = null;
			$sub_pekerjaan = null;
			$detail_pekerjaan = null;
		}
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
				"divisi"            => $project,
				"so"                => $pekerjaan,
				"si"				=> $sub_pekerjaan,
				"tasklist"			=> $detail_pekerjaan
				// "project"			=> $project,
				// "pekerjaan"			=> $pekerjaan,
				// "sub_pekerjaan"		=> $sub_pekerjaan,
				// "detail_pekerjaan"	=> $detail_pekerjaan
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
				"closed"			=> $closed,
				"divisi"            => $project,
				"so"                => $pekerjaan,
				"si"				=> $sub_pekerjaan,
				"tasklist"			=> $detail_pekerjaan
				// "project"			=> $project,
				// "pekerjaan"			=> $pekerjaan,
				// "sub_pekerjaan"		=> $sub_pekerjaan,
				// "detail_pekerjaan"	=> $detail_pekerjaan
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
		$cc				= (isset($_POST['cc'])) ? implode(',', $_POST['cc']) : NULL;
		$closed			= $_POST['closed']; // Pembeda antara Draft/Finish
		$created_at		= date("Y-m-d H:i:s");
		$created_by		= $_SESSION['user_id'];
		if (isset($_POST['pekerjaan'])) {
			$project 		= $_POST['project'];
			$pekerjaan 		= $_POST['pekerjaan'];
			$sub_pekerjaan 	= $_POST['sub_pekerjaan'];
			$detail_pekerjaan	= $_POST['detail_pekerjaan'];
		} else {
			$project = null;
			$pekerjaan = null;
			$sub_pekerjaan = null;
			$detail_pekerjaan = null;
		}
		$update = array(
			"closing_statement"	=> $closing,
			"closed" 			=> $closed,
			"cc"				=> $cc,
			"created_at" 		=> $created_at,
			"created_by" 		=> $created_by
		);

		$result['id'] 	= $id_mom;
		$result['data'] = $update;
		$this->db->where("id_mom", $id_mom);
		$result['update_mom'] = $this->db->update("mom_header", $update);
		$dt_mom = $this->db->query("SELECT * FROM mom_header WHERE id_mom = '$id_mom'")->row_array();
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
					'jenis_strategy' => 'Once',
					// 'id_project'	=> $project,
					// 'id_pekerjaan'	=> $pekerjaan,
					// 'id_sub_pekerjaan'	=> $sub_pekerjaan,
					// 'id_detail_pekerjaan'	=> $detail_pekerjaan
					"divisi"            => $project,
					"so"                => $pekerjaan,
					"si"				=> $sub_pekerjaan,
					"tasklist"			=> $detail_pekerjaan
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

			// Insert to Tasklist GRD
			$tasklist_grd = $this->model->get_issue_item_grd($id_mom);
			foreach ($tasklist_grd as $grd) {
				// Kategori : Tasklist GRD
				if ($grd->kategori == 12) {
					$this->db->select_max('id_tasklist');
					$tasklist = $this->db->get('grd_t_tasklist')->row();
					$no_app = $tasklist->id_tasklist + 1;

					$grdsi = array(
						'id_tasklist'       => $no_app,
						'divisi'            => $grd->divisi,
						'id_si'           	=> $grd->grdsi,
						'pic'        		=> $grd->pic,
						'start'        		=> date('Y-m-d H:i:s'),
						'end'        		=> $grd->deadline . " " . date('H:i:s'),
						'detail'       		=> "Issuenya " . $grd->issue . " dan Strategynya " . $grd->action . " by MoM",
						'target'            => 1,
						'output'       		=> $grd->ekspektasi,
						'status'            => 1,
						'created_at'        => date('Y-m-d H:i:s'),
						'created_by'        => $this->session->userdata('user_id')
					);

					$result['grd_t_tasklist'] = $this->db->insert('grd_t_tasklist', $grdsi);

					$grdsi_history = array(
						'id_tasklist'       => $no_app,
						'progress'          => 0,
						'status'            => 1,
						'status_before'     => 1,
						'note'       		=> "Tasklist Created",
						'created_at'        => date('Y-m-d H:i:s'),
						'created_by'        => $this->session->userdata('user_id')
					);

					$result['grd_t_tasklist_history'] = $this->db->insert('grd_t_tasklist_history', $grdsi_history);
				}
			}

			$result['send'] = $this->send_wa_mom($id_mom);
			$result['send_email'] = $this->send_email_mom2($id_mom);
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

			// $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

			// $data_text = array(
			// 	// "channelID" => "2319536345",
			// 	"channelID" => "2225082380", //2507194023
			// 	"phone" => $mom['kontak'],
			// 	// "phone" => "628993036965",
			// 	"messageType" => "text",
			// 	"body" => $msg,
			// 	"withCase" => true
			// );

			// $options_text = array(
			// 	'http' => array(
			// 		"method"  => 'POST',
			// 		"content" => json_encode($data_text),
			// 		"header" =>  "Content-Type: application/json\r\n" .
			// 			"Accept: application/json\r\n" .
			// 			"API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
			// 	)
			// );

			// $context_text   = stream_context_create($options_text);
			// $result_text['wa_api']    = file_get_contents($url, false, $context_text);

			try {
				$this->load->library('WAJS');
				$response['wa'][] = $this->wajs->send_wajs_notif($mom['kontak'], $msg, 'text', 'trusmiverse', $mom['user_id']);
			} catch (\Throwable $th) {
				$response['wa'][] = "Error : " . $th;
			}
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

	function save_goals()
	{
		$id_mom 	= $_POST['id_mom'];
		$id_issue 	= $_POST['id_issue'];
		$id_goal 	= $_POST['id_goal'];
		$topik 	= $_POST['topik'];
		$id_issue_item 	= 1;
		$value 			= null;

		$cek_topik 	= $this->model->cek_topik($id_mom, $id_issue);
		$cek_issue_item	= $this->model->cek_issue_item($id_mom, $id_issue, $id_issue_item);

		if ($cek_topik < 1) {
			// Insert new topik jika belum ada
			$mom_result = array(
				'id_mom' => $id_mom,
				'id_issue' => $id_issue,
				'topik' => $topik,
			);

			$result['issue_save'] = $this->db->insert('mom_issue', $mom_result);
		} else {
			// Update topik jika sudah ada
			$mom_result = array(
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
				'id_goal' => $id_goal,
			);

			$result['issue_item_save'] = $this->db->insert('mom_issue_item', $mom_issue_item);
		} else {
			$mom_issue_item = array(
				'id_goal' => $id_goal,
			);

			$this->db->where('id_mom', $id_mom);
			$this->db->where('id_issue', $id_issue);
			$this->db->where('id_issue_item', $id_issue_item);
			$result['issue_item_update'] = $this->db->update('mom_issue_item', $mom_issue_item);
		}

		$result['cek_topik'] = $cek_topik;
		$result['cek_issue_item'] = $cek_issue_item;

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
		if (isset($_POST['pekerjaan'])) {
			$project 		= $_POST['project'];
			$pekerjaan 		= $_POST['pekerjaan'];
			$sub_pekerjaan 	= $_POST['sub_pekerjaan'];
			$detail_pekerjaan	= $_POST['list_det_pekerjaan'];
		} else {
			$project = null;
			$pekerjaan = null;
			$sub_pekerjaan = null;
			$detail_pekerjaan = null;
		}
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
			"closed"			=> $closed,
			"divisi"            => $project,
			"so"                => $pekerjaan,
			"si"				=> $sub_pekerjaan,
			"tasklist"			=> $detail_pekerjaan
			// "project"			=> $project,
			// "pekerjaan"			=> $pekerjaan,
			// "sub_pekerjaan"		=> $sub_pekerjaan,
			// "detail_pekerjaan"	=> $detail_pekerjaan
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

			// Insert to Tasklist GRD
			$tasklist_grd = $this->model->get_issue_item_grd($id_mom);
			foreach ($tasklist_grd as $grd) {
				// Kategori : Tasklist GRD
				if ($grd->kategori == 12) {
					$this->db->select_max('id_tasklist');
					$tasklist = $this->db->get('grd_t_tasklist')->row();
					$no_app = $tasklist->id_tasklist + 1;

					$grdsi = array(
						'id_tasklist'       => $no_app,
						'divisi'            => $grd->divisi,
						'id_si'           	=> $grd->grdsi,
						'pic'        		=> $grd->pic,
						'start'        		=> date('Y-m-d H:i:s'),
						'end'        		=> $grd->deadline . " " . date('H:i:s'),
						'detail'       		=> "Issuenya " . $grd->issue . " dan Strategynya " . $grd->action . " by MoM",
						'target'            => 1,
						'output'       		=> $grd->ekspektasi,
						'status'            => 1,
						'created_at'        => date('Y-m-d H:i:s'),
						'created_by'        => $this->session->userdata('user_id')
					);

					$result['grd_t_tasklist'] = $this->db->insert('grd_t_tasklist', $grdsi);

					$grdsi_history = array(
						'id_tasklist'       => $no_app,
						'progress'          => 0,
						'status'            => 1,
						'status_before'     => 1,
						'note'       		=> "Tasklist Created",
						'created_at'        => date('Y-m-d H:i:s'),
						'created_by'        => $this->session->userdata('user_id')
					);

					$result['grd_t_tasklist_history'] = $this->db->insert('grd_t_tasklist_history', $grdsi_history);
				}
			}

			$result['send'] = $this->send_wa_mom($id_mom);
		}

		echo json_encode($result);
	}

	function get_issue_result($id_mom)
	{
		$mom_header = $this->db->query("SELECT * FROM mom_header WHERE id_mom = '$id_mom'")->row();
		$is_owner_meeting = ($mom_header && $mom_header->meeting == 'Owner');
		$issue 		= $this->model->get_issue_result($id_mom)->result();
		$cek_issue	= $this->model->get_issue_result($id_mom)->num_rows();
		$pic		= $this->model->get_employee();
		$kategori	= $this->model->get_kategori_new2();
		$level		= $this->model->get_level();

		$grdsi		= $this->model->get_grd_si();
		$goals		= $this->model->get_goals();

		$data = "";
		$select_pic = array();

		if ($cek_issue > 0) {
			foreach ($issue as $val) {
				$data .= '<tr id="div_issue_draft_' . $val->id_issue . '">
						<input type="hidden" id="total_action_draft_' . $val->id_issue . '" value="' . $val->action . '">
						<td class="kolom_modif" id="td_topik_draft_' . $val->id_issue . '" data-id="topik_draft_' . $val->id_issue . '_1" rowspan="' . $val->rowspan . '">
						<select class="form-control goals_draft" id="val_goals_draft_' . $val->id_issue . '_1" onchange="handle_goals_draft_change(&apos;goals_draft_' . $val->id_issue . '_1&apos;)">
						<option>- Choose goal -</option>';

				foreach ($goals as $goal) {
					if ($goal->id_goal == $val->id_goal) {
						$data .=  '<option value="' . $goal->id_goal . '" selected>' . $goal->goal . '</option>';
					} else {
						$data .=  '<option value="' . $goal->id_goal . '">' . $goal->goal . '</option>';
					}
				}

				$data .= '</select>';

				$data .= '<span class="d-none" id="topik_draft_' . $val->id_issue . '_1">' . $val->topik . '</span>
							<textarea class="form-control ' . ($val->id_goal == '0' ? '' : 'd-none') . '" id="val_topik_draft_' . $val->id_issue . '_1" class="excel" rows="1" value="' . $val->topik . '" onfocusin="expandTextarea_draft(&apos;val_topik_draft_' . $val->id_issue . '_1&apos;)">' . $val->topik . '</textarea>
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
										<td class="kolom_modif" id="td_grdsi_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '" data-id="grdsi_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '">
											<select class="form-control" id="val_grdsi_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '" onchange="submit_update_draft(&apos;grdsi_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '&apos;)">
												<option>- Choose -</option>';

					foreach ($grdsi as $si) {
						if ($si->id_si == $val_item->grdsi) {
							$data .=  '<option value="' . $si->id_si . '" selected>' . $si->grdsi . '</option>';
						} else {
							$data .=  '<option value="' . $si->id_si . '">' . $si->grdsi . '</option>';
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
										</td>';
					$data .= '<td class="kolom_modif" id="td_ekspektasi_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '" data-id="ekspektasi_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '">
						<span id="ekspektasi_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '">' . $val_item->ekspektasi . '</span>
											<textarea class="form-control" id="val_ekspektasi_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '" value="' . $val_item->ekspektasi . '" class="excel" rows="1" onfocusin="expandTextarea_draft(&apos;val_ekspektasi_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '&apos;)" onfocusout="submit_update_draft(&apos;ekspektasi_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '&apos;)" style="height: 36px; display: none;">' . $val_item->ekspektasi . '</textarea></td>';


					$data .= '<td id="td_pic_draft_' . $val_item->id_issue . '_' . $val_item->id_issue_item . '">
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
							<td style="cursor: pointer;" colspan="8">
								<span class="btn btn-md btn-outline-success" onclick="add_action_draft(' . $val->id_issue . ')"><i class="bi bi-plus-square"></i> Strategy</span>
								<span class="btn btn-md btn-outline-danger" id="btn_remove_action_draft_' . $val->id_issue . '" ' . $hidden_btn_remove_action . ' onclick="remove_action_draft(' . $val->id_issue . ')"><i class="bi bi-dash-square"></i> Strategy</span>
							</td>
						</tr>
						';
			}

			$data .= '<tr id="div_issue_draft">
							<td style="cursor: pointer;" colspan="10">
								<span class="btn btn-md btn-outline-success" onclick="add_issue_draft(' . $val->id_issue . ')"><i class="bi bi-plus-square"></i></i> Issue</span>
								<span class="btn btn-md btn-outline-danger btn_remove_issue_draft" ' . $hidden_btn_remove_issue . ' onclick="remove_issue_draft(' . $val->id_issue . ')"><i class="bi bi-dash-square"></i></i> Issue</span>
							</td>
						</tr>';

			$result['pic'] = $select_pic;
		} else {
			$data .= '<tr id="div_issue_draft_1">
						<input type="hidden" id="total_action_draft_1" value="1">
						<td class="kolom_modif" id="td_topik_draft_1" data-id="topik_draft_1_1" rowspan="2">';

			$data .= '<select class="form-control goals_draft" id="val_goals_draft_1_1" onchange="handle_goals_draft_change(&apos;goals_draft_1_1&apos;)">
						<option>- Choose goal -</option>';

			foreach ($goals as $goal) {
				$data .=  '<option value="' . $goal->id_goal . '">' . $goal->goal . '</option>';
			}

			$data .=	'</select>';
			$data .= '<span id="topik_draft_1_1">&nbsp;</span>
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
						</td>';
			// if($is_owner_meeting){
			$data .= '<td class="kolom_modif" id="td_ekspektasi_draft_1_1" data-id="ekspektasi_draft_1_1"><span id="ekspektasi_draft_1_1">&nbsp;</span><textarea class="form-control" id="val_ekspektasi_draft_1_1" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea_draft(&apos;val_ekspektasi_1_1&apos;)" onfocusout="submit_update_draft(&apos;ekspektasi_1_1&apos;)"></textarea></td>';
			// }else{

			// }
			$data .= '<td id="td_pic_draft_1_1">
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
		$kategori	= $this->model->get_kategori_new2();
		$level		= $this->model->get_level();
		$grdsi		= $this->model->get_grd_si();
		$goals		= $this->model->get_goals();

		$data = "";
		$data .= '<tr id="div_issue_1">
				<input type="hidden" id="total_action_1" value="1">
				<td class="kolom_modif" id="td_topik_1" data-id="topik_1_1" rowspan="2">
					<select class="form-control goals" id="val_goals_1_1" onchange="handle_goals_change(&apos;goals_1_1&apos;)" onclick="event.stopPropagation();" onfocus="event.stopPropagation();" style="margin-bottom: 5px;">
						<option value="">- Choose Goals -</option>';
		foreach ($goals as $goal) {
			$data .= '<option value="' . $goal->id_goal . '">' . $goal->goal . '</option>';
		}
		$data .=			'</select>
					<span id="topik_1_1">&nbsp;</span>
					<textarea class="form-control d-none" id="val_topik_1_1" class="excel" rows="1" onfocusin="expandTextarea(&apos;val_topik_1_1&apos;)"></textarea>
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
		$data .=	'</select>
				</td>
				<td class="kolom_modif" id="td_grdsi_1_1" data-id="grdsi_1_1">
					<select class="form-control grdsi" id="val_grdsi_1_1" onchange="submit_update(&apos;grdsi_1_1&apos;)">
						<option>- Choose -</option>';
		foreach ($grdsi as $si) {
			$data .= '<option value="' . $si->id_si . '">' . $si->grdsi . '</option>';
		}
		$data .=	'</select>
				</td>
				<td class="kolom_modif" id="td_level_1_1" data-id="level_1_1">
					<select class="form-control" id="val_level_1_1" style="display: none;" onchange="submit_update(&apos;level_1_1&apos;)">
						<option value="">- Choose -</option>';
		foreach ($level as $lvl) {
			$data .= '<option value="' . $lvl->id . '|' . $lvl->day . '">' . $lvl->leveling . '</option>';
		}
		$data .=	'</select>
				</td>

				<td class="kolom_modif" id="td_deadline_1_1" data-id="deadline_1_1">
					<span id="deadline_1_1">&nbsp;</span>
					<textarea class="form-control" id="val_deadline_1_1" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea(&apos;val_deadline_1_1&apos;)" onfocusout="submit_update(&apos;deadline_1_1&apos;)"></textarea>
					<input type="text" class="form-control tanggal" id="val_date_deadline_1_1" style="display: none;" onfocusout="submit_update(&apos;deadline_1_1&apos;)">
				</td>
				<td class="kolom_modif" id="td_ekspektasi_1_1" data-id="ekspektasi_1_1">
					<span id="ekspektasi_1_1">&nbsp;</span>
					<textarea class="form-control" id="val_ekspektasi_1_1" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea(&apos;val_ekspektasi_1_1&apos;)" onfocusout="submit_update(&apos;ekspektasi_1_1&apos;)"></textarea>
				</td>
				<td id="td_pic_1_1">
					<select id="val_pic_1_1" class="form-control pic" multiple onchange="submit_update(&apos;pic_1_1&apos;)">
						<option data-placeholder="true">-- Choose Employee --</option>';
		foreach ($pic as $row) {
			$data .= '<option value="' . $row->user_id . '">' . $row->employee_name . '</option>';
		}
		$data .= 	'</select>
				</td>
			</tr>
			<tr id="div_issue_action_1">
				<td style="cursor: pointer;" colspan="8">
					<span class="btn btn-md btn-outline-success" onclick="add_action(1)"><i class="bi bi-plus-square"></i> Strategy</span>
					<span class="btn btn-md btn-outline-danger" id="btn_remove_action_1" onclick="remove_action(1)" style="display:none;"><i class="bi bi-dash-square"></i> Strategy</span>
				</td>
			</tr>
			<tr id="div_issue">
				<td style="cursor: pointer;" colspan="10">
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
			} else if ($key['kategori'] == 12 && ($key['grdsi'] == '' || $key['grdsi'] == 0)) {
				$result['warning'] 	= "SI untuk Topik ke-" . $key['id_issue'] . " Strategy ke-" . $key['id_issue_item'] . " belum terisi!";
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
			} else if ($key['ekspektasi'] == '') {
				$result['warning'] 	= "Ekspektasi ke-" . $key['id_issue'] . " Strategy ke-" . $key['id_issue_item'] . " belum terisi!";
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
                        WHERE start_date BETWEEN DATE_SUB('$start', INTERVAL 1 WEEK) AND '$end' AND WEEKDAY(start_date) = 0
                        GROUP BY (start_date)
                        ORDER BY (start_date)
                    ) AS calendar_week, 
                    (SELECT @rank := 0 ) AS num
					WHERE SUBSTR(tgl_akhir, 9, 2) != SUBSTR(LAST_DAY(tgl_akhir), 9, 2)");
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
			// $select .= " CASE WHEN xx.user_id IN (118,637,116,998,4201) THEN COUNT(IF(xx.input >= 3 AND xx.w = '$week',1,NULL))
			// 			ELSE COUNT(IF(xx.input >= 1 AND xx.w = '$week',1,NULL)) END AS w" . $week . ",";
			// $select .= " SUM(IF(xx.w = '$week',COALESCE(xx.input,0),0)) AS input_w" . $week . ",";

			$select .= "CASE WHEN SUM(IF(xx.w = '$week',COALESCE(xx.input,0),0)) >= target THEN 1 ELSE 0 END AS w" . $week . ",";
			$select .= " SUM(IF(xx.w = '$week',COALESCE(xx.input,0),0)) AS input_w" . $week . ",";
			$week++;
		}

		$user_id        = $_SESSION['user_id'];
		$role_id        = $_SESSION['user_role_id'];

		$kondisi = "";
		if ($role_id == 1) { // Ittrusmi & Super Admin & Viky & Lintang(Sekdir) & Pak Ibnu
			$kondisi = "";
		} else if (in_array($user_id, [4498, 10127])) {
			$kondisi = "";
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
                    SELECT tm.user_id, tm.employee_name, tm.company_name, tm.jabatan, th.w, th.tgl_awal, th.tgl_akhir, 
					`target`,
					SUM(IF(th.w IS NOT NULL,1,0)) AS input FROM
                      (
                      SELECT 
                      a.user_id,  CONCAT(a.first_name, ' ', a.last_name) AS employee_name,
                      a.company_id, a.department_id, a.designation_id, c.name AS company_name, ds.designation_name AS jabatan,
					  CASE 
											WHEN a.ctm_posisi = 'Manager' THEN 2
											WHEN a.ctm_posisi = 'Supervisor' THEN 1
											END AS `target`
                      FROM xin_employees a
                      LEFT JOIN xin_user_roles ur ON ur.role_id = a.user_role_id
                      LEFT JOIN xin_companies c ON c.company_id = a.company_id
                      LEFT JOIN xin_departments d ON d.department_id = a.department_id
                      LEFT JOIN xin_designations ds ON ds.designation_id = a.designation_id
                    --   WHERE a.is_active = 1 AND (user_id IN (118,637,116,998,4201) OR user_id IN (2108,2733,1294,1733,1369,2127,1844))
						WHERE a.is_active = 1  AND a.company_id IN (3,4,5) AND a.ctm_posisi IN ('Manager','Supervisor')
                      ) tm
                      LEFT JOIN mom_header b ON FIND_IN_SET(tm.user_id, peserta)
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
                                              WHERE start_date BETWEEN DATE_SUB('$start', INTERVAL 1 WEEK) AND '$end' AND WEEKDAY(start_date) = 0
                                              GROUP BY (start_date)
                                              ORDER BY (start_date)
                                          ) AS calendar_week, 
                                          (SELECT @rank := 0 ) AS num
										  WHERE SUBSTR(tgl_akhir, 9, 2) != SUBSTR(LAST_DAY(tgl_akhir), 9, 2)
                    ) th ON SUBSTR(b.tgl,1,10) BETWEEN th.tgl_awal AND th.tgl_akhir
                    GROUP BY tm.user_id, th.w
                ) xx $kondisi GROUP BY xx.user_id";
		return $this->db->query($query)->result();
	}
	private function formatICSDate($date, $timezone)
	{
		$dt = new \DateTime($date, new \DateTimeZone($timezone));
		$dt->setTimezone(new \DateTimeZone('America/Los_Angeles'));
		return $dt->format('Ymd\THis');
	}
	private function createICSFile($event)
	{
		$icsContent = "BEGIN:VCALENDAR\nVERSION:2.0\nCALSCALE:GREGORIAN\n";
		$icsContent .= "BEGIN:VEVENT\n";
		$icsContent .= "UID:" . uniqid() . "\n";
		$icsContent .= "DTSTAMP:" . $this->formatICSDate('now', 'UTC') . "\n";
		$icsContent .= "DTSTART:" . $this->formatICSDate($event['start'], $event['timezone']) . "\n";
		$icsContent .= "DTEND:" . $this->formatICSDate($event['end'], $event['timezone']) . "\n";
		$icsContent .= "SUMMARY:" . $event['summary'] . "\n";
		$icsContent .= "DESCRIPTION:" . $event['description'] . "\n";
		$icsContent .= "LOCATION:" . $event['location'] . "\n";
		$icsContent .= "BEGIN:VALARM\nTRIGGER:-PT10M\nACTION:DISPLAY\nDESCRIPTION:Reminder\nEND:VALARM\n";
		$icsContent .= "END:VEVENT\n";
		$icsContent .= "END:VCALENDAR";

		return $icsContent;
	}
	public function send_email_mom2($id_mom)
	{
		$mom = $this->model->get_send_email($id_mom);
		$mail = false;
		// die();
		foreach ($mom as $m) {
			$pic = explode(",", $m->pic);
			foreach ($pic as $p) {
				// $email = $this->db->query("SELECT email FROM xin_employees WHERE user_id = $p")->row();

				// Edited by Faisal 20 Juni 2024 | Agar ketika user tidak ada email, tidak terjadi error
				$email = $this->db->query("SELECT IF(email = '','ibrprotrusmi@gmail.com',COALESCE(LOWER(email),'ibrprotrusmi@gmail.com')) AS email FROM xin_employees WHERE user_id = $p")->row();
				if ($email != '') {
					$email_config = array(
						'protocol' => 'smtp',
						'smtp_host' => 'smtp.gmail.com',
						'smtp_port' => 465,
						'smtp_user' => 'ibrprotrusmi@gmail.com',
						'smtp_pass' => 'clsjhdlfocjhytha',
						'smtp_crypto' => 'ssl',
						'mailtype'  => 'html',
						'charset'   => 'utf-8',
						'wordwrap' => TRUE
					);
					$start = $m->start_time;
					$end = $m->end_time;
					$this->load->library('email', $email_config);
					$tgl_end = \DateTime::createFromFormat('Y-m-d', $m->deadline);
					$icsContent = $this->createICSFile([
						'summary' => $m->task,
						'description' => $m->action,
						'location' => $m->tempat,
						'start' => date("j F Y") . $start,
						'end' => $tgl_end->format('j F Y') . "23:59:59",
						'timezone' => 'America/Los_Angeles'
					]);
					$this->email->clear(true);
					$this->email->set_newline("\r\n");
					$this->email->from('trusmiibrpro@gmail.com', 'Trusmi IBRPRO');
					$this->email->to($email->email);
					$this->email->subject('Schedule IBR PRO ' . $m->action);
					$this->email->message(
						"Goal  : " . $m->task . ".<br>" .
							"Strategi  : " . $m->action . ".<br>" .
							"Tanggal  : " . date('j F Y', strtotime($m->tgl)) . " - " . $tgl_end->format('j F Y') . ".<br>" .
							"Waktu   : " . $start . "-" . $end . ".<br>" .
							"Pastikan untuk mengkonfirmasi invitation agar event muncul di kalender masing-masing"
					);
					$icsFile = tempnam(sys_get_temp_dir(), 'event') . '.ics';
					file_put_contents($icsFile, $icsContent);
					$this->email->attach($icsFile);
					$mail = $this->email->send();
					if (!$mail) {
						show_error($this->email->print_debugger());
					}
					unlink($icsFile);
				}
			}
		}
		return $mail;
	}

	function get_pekerjaan()
	{
		$id_project 	= $_POST['id_project'];
		$query = "SELECT id_so AS id, so AS pekerjaan,DATE_FORMAT(created_at, '%b %Y') AS periode FROM `grd_m_so` WHERE divisi = '$id_project'";
		$data['pekerjaan'] = $this->db->query($query)->result();
		// $data['pekerjaan'] = $this->db->query("SELECT id, pekerjaan FROM hris.m_pekerjaan;")->result();
		echo json_encode($data);
	}

	function get_sub_pekerjaan()
	{
		$id_pekerjaan = $_POST['id_pekerjaan'];
		$query = "SELECT id_si AS id, si AS sub_pekerjaan FROM `grd_t_si` WHERE id_so =  $id_pekerjaan";
		$data['sub_pekerjaan'] = $this->db->query($query)->result();
		// $data['sub_pekerjaan'] = $this->db->query("SELECT * FROM hris.m_sub_pekerjaan WHERE id_pekerjaan = '$id_pekerjaan'")->result();
		echo json_encode($data);
	}

	function get_detail_pekerjaan()
	{
		$id_sub_pekerjaan = $_POST['id_sub_pekerjaan'];
		$query = "SELECT id_tasklist AS id, detail FROM `grd_t_tasklist` WHERE id_si = $id_sub_pekerjaan";
		$data['detail_pekerjaan'] = $this->db->query($query)->result();
		// $data['detail_pekerjaan'] = $this->db->query("SELECT * FROM hris.t_detail_pekerjaan WHERE id_sub_pekerjaan = '$id_sub_pekerjaan'")->result();
		echo json_encode($data);
	}
	function save_verified()
	{
		$id = $this->input->post('id_item_issue');
		$id_sub_task = $this->input->post('id_sub_task');
		$tipe_mom = $this->input->post('tipe_mom');
		$id_task = $this->input->post('id_task');
		$status = $this->input->post('verified_status');
		$verified_tanggal = $this->input->post('verified_tanggal');
		$pdca_meeting = $this->input->post('pdca_meeting');
		$data_update = [
			'verified_status' => $this->input->post('verified_status'),
			'verified_note' => $this->input->post('verified_note'),
			'pdca_meeting' => $pdca_meeting,
			'verified_by' => $this->session->userdata('user_id'),
			'verified_by' => $this->session->userdata('user_id'),
			'verified_at' => date('Y-m-d H:i:s'),
			'owner_verified_status' => NULL,
			'owner_verified_note' => NULL,
			'owner_verified_by' => NULL,
			'owner_verified_at' => NULL,
			'owner_meeting' => NULL,
		];
		$this->db->where('id', $id);
		// var_dump($status);die();
		$hasil = $this->db->update('mom_issue_item', $data_update);
		if ($status == 2) {

			$this->db->trans_start();
			$this->rollback_revisi($id_task, $id_sub_task, $verified_tanggal);
			// $this->db->query("UPDATE mom_issue_item SET freq_revisi = COALESCE(freq_revisi,0) + 1 WHERE id_sub_task = '$id_sub_task'");
			// $this->db->query("UPDATE td_task SET status = 2 WHERE id_task = '$id_task'");
			$this->insert_history_task(1, $id_task, $id_sub_task, $this->input->post('verified_note'));
			$this->db->trans_complete();
			if ($this->db->trans_status() === TRUE) {
				$this->send_not_oke($id_sub_task, 1);
			}
		} else {
			if ($tipe_mom == 'MEETING OWNER') {
				$this->send_oke($id_sub_task);
			}
		}
		echo json_encode($hasil);
	}
	function save_verified_owner()
	{
		$id = $this->input->post('id_item_issue');
		$id_sub_task = $this->input->post('id_sub_task');
		$id_task = $this->input->post('id_task');
		$status = $this->input->post('verified_status');

		if ($status == 3) {
			$tanggal = $this->input->post('verified_tanggal');
			$bulan = [
				1 => 'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			];

			$parts = explode('-', $tanggal); // [0] => 2025, [1] => 05, [2] => 01

			$tanggal_formatted = (int)$parts[2] . ' ' . $bulan[(int)$parts[1]] . ' ' . $parts[0];

			$data_update = [
				'owner_verified_status' => $this->input->post('verified_status'),
				'owner_verified_note' => $tanggal_formatted,
				'owner_meeting' => $this->input->post('verified_tanggal'),
				'owner_verified_by' => $this->session->userdata('user_id'),

			];
		} else {
			$data_update = [
				'owner_verified_status' => $this->input->post('verified_status'),
				'owner_verified_note' => $this->input->post('verified_note'),
				'owner_verified_by' => $this->session->userdata('user_id'),

			];
		}

		if ($status == 1 || $status == 3) { // jika oke meeting dan oke result
			$data_update['owner_verified_at'] = date('Y-m-d H:i:s');
		}
		$this->db->where('id', $id);
		$hasil = $this->db->update('mom_issue_item', $data_update);
		if ($status == 2) { // jika not oke
			$this->db->trans_start();

			$this->rollback_revisi($id_task, $id_sub_task);
			$this->insert_history_task(2, $id_task, $id_sub_task, $this->input->post('verified_note'));
			$this->db->trans_complete();
			if ($this->db->trans_status() === TRUE) {
				$this->send_not_oke($id_sub_task, 2);
			}
		} else if ($status == 3) {
			$this->send_oke_meeting($id_sub_task);
		}
		echo json_encode($hasil);
	}

	public function send_not_oke($id, $tipe)
	{
		$data = $this->model->get_detail_ibr_for_notif($id);
		$lampiran = '';
		foreach ($data as $value) {
			if ($value->file != NULL && $value->link == NULL) {
				$lampiran = $value->file;
			} else if ($value->file == NULL && $value->link != NULL) {
				$lampiran = $value->link;
			} else if ($value->file != NULL && $value->link != NULL) {
				$lampiran = "1. " . $value->file . "
				2. " . $value->link;
			}
			if ($tipe == 1) {
				$tipe_notif = "📢 *Notifikasi Revisi Tasklist IBR PRO (MOM)* 📢";
				$verified_note = $value->verified_note;
				$verified = $value->pdca;
			} else {
				$tipe_notif = "🚨 *Notifikasi Revisi Tasklist IBR PRO (MOM) OWNER* 🚨 ";
				$verified_note = $value->owner_verified_note;
				$verified = $value->owner;
			}
			$msg = "$tipe_notif
	
Tasklist *IBR PRO* telah diverifikasi dan terdapat revisi di task :
🏆 Goals / Issue : *$value->task*
💡 Strategi : *$value->sub_task*
👤 PIC : *$value->pic_mom*
🌐 Lampiran : $lampiran

📑 Status : *Tidak Oke*
💣 Deadline : $value->deadline
💬 Note : *$verified_note*
📝 Verify by : *$verified*
📌 Verify at : *" . date('Y-m-d H:i:s') . "*

🔗 Detail : https://trusmiverse.com/apps/pr/mom/$value->mom

Mohon revisi maksimal 1x 24 jam, jika tidak akan di berlakukan Lock Absen";
			// $this->whatsapp_lib->send_single_msg('rsp', '083824955357', $msg); 
			if ($this->session->userdata('user_id') == 1) {
				$this->whatsapp_lib->send_single_msg('rsp', '6285860428016', $msg);
			} else {
				$this->whatsapp_lib->send_single_msg('rsp', $value->contact_no_pic, $msg);
			}
			// echo json_encode($msg);
		}
	}

	public function send_oke($id)
	{
		$data = $this->model->get_detail_ibr_for_notif($id);
		// var_dump($data);die();
		$lampiran = '';
		foreach ($data as $value) {
			if ($value->file != NULL && $value->link == NULL) {
				$lampiran = $value->file;
			} else if ($value->file == NULL && $value->link != NULL) {
				$lampiran = $value->link;
			} else if ($value->file != NULL && $value->link != NULL) {
				$lampiran = "1. " . $value->file . "
				2. " . $value->link;
			}
			$msg = "📢 *Notifikasi verified by PDACA Tasklist IBR PRO (MOM)* 📢
	
Tasklist *IBR PRO* telah diverifikasi oleh PDCA :
🏆 Goals / Issue : *$value->task*
💡 Strategi : *$value->sub_task*
👤 PIC : *$value->pic_mom*
🌐 Lampiran : $lampiran

📑 Status : *Oke*
💬 Note : *$value->verified_note*
📝 Verify by : *$value->pdca*
📌 Verify at : *" . date('Y-m-d H:i:s') . "*

🔗 Detail : https://trusmiverse.com/apps/pr/mom/$value->mom

Mohon di verifikasi kembali, jika tidak akan di berlakukan Lock Absen";
			$this->whatsapp_lib->send_single_msg('rsp', '0895422833253', $msg); // hilal
			$this->whatsapp_lib->send_single_msg('rsp', '085624444554', $msg); // owner
			// $this->whatsapp_lib->send_single_msg('rsp', $value->contact_no_pic, $msg);
			// echo json_encode($msg);
		}
	}

	public function send_oke_meeting($id)
	{
		$data = $this->model->get_detail_ibr_for_notif_meeting($id);
		// var_dump($data);die();
		$lampiran = '';
		foreach ($data as $value) {
			if ($value->file != NULL && $value->link == NULL) {
				$lampiran = $value->file;
			} else if ($value->file == NULL && $value->link != NULL) {
				$lampiran = $value->link;
			} else if ($value->file != NULL && $value->link != NULL) {
				$lampiran = "1. " . $value->file . "
				2. " . $value->link;
			}
			$msg = "📢 *Notifikasi Jadwal Meeting Owner Tasklist IBR PRO (MOM)* 📢
	
Tasklist *IBR PRO* telah diverifikasi oleh Owner :
🏆 Goals / Issue : *$value->task*
💡 Strategi : *$value->sub_task*
👤 PIC : *$value->pic_mom*
🌐 Lampiran : $lampiran

📑 Status : *Oke Meeting / Diskusi*
💬 Note : *$value->owner_verified_note*
📝 Verify by : *$value->owner*
📌 Verify at : *" . date('Y-m-d H:i:s') . "*

🔗 Detail : https://trusmiverse.com/apps/pr/mom/$value->mom";
			// $this->whatsapp_lib->send_single_msg('rsp', '6285860428016', $msg);
			$this->whatsapp_lib->send_single_msg('rsp', $value->contact_no_pic, $msg);
			// echo json_encode($msg);
		}
	}

	public function list_meeting_owner()
	{
		$user_id = $this->session->userdata('user_id');
		$start = $this->input->post('start');
		$end = $this->input->post('end');
		$data = $this->model->list_meeting_owner($user_id, $start, $end);
		echo json_encode($data);
	}
	public function list_verif_owner()
	{
		$filter = $this->input->post('filter');
		$data = $this->model->list_verif_owner($filter);
		echo json_encode($data);
	}
	public function list_verif_pdca()
	{
		$filter = $this->input->post('filter');
		$data = $this->model->list_verif_pdca($filter);
		echo json_encode($data);
	}
	public function list_eskalasi()
	{
		$data = $this->model->list_eskalasi();
		echo json_encode($data);
	}
	public function insert_history_task($tipe, $id_task, $id_sub_task, $note)
	{
		if ($tipe == 1) {
			$note_tipe = "Revisi PDCA";
		} else {
			$note_tipe = "Revisi Owner";
		}
		$data_history = [
			'id_task' => $id_task,
			'progress' => 0,
			'status' => 2,
			'status_before' => 3,
			'note' => $note_tipe . ' : ' . $note,
			'created_at' => date('Y-m-d H:i_s'),
			'created_by' => $this->session->userdata('user_id')
		];
		$this->db->insert('td_task_history', $data_history);

		$data_sub_history = [
			'id_sub_task' => $id_sub_task,
			'id_task' => $id_task,
			'progress' => 0,
			'note' => $note_tipe . ' : ' . $note,
			'created_at' => date('Y-m-d H:i_s'),
			'created_by' => $this->session->userdata('user_id')
		];
		$this->db->insert('td_sub_task_history', $data_sub_history);
	}

	//handika
	function save_eskalasi()
	{
		$totalIssue = $_POST['total_issue'];
		$id_mom = $_POST['id_mom_global'];
		$deadline = $_POST['deadline_global'];
		$reff_id_sub_task = $_POST['id_sub_task'];
		for ($i = 1; $i <= $totalIssue; $i++) {
			$countIssue = 0;
			$countAction = 0;
			$countKategori = 0;
			$countDeadline = 0;
			$countPic = 0;
			foreach ($_POST as $key => $value) {
				if (strpos($key, 'val_issue_' . $i) !== false) {
					if ($_POST['val_issue_' . $i] != '') {
						$countIssue++;
					}
				}
				if (strpos($key, 'val_action_' . $i) !== false) {
					$countAction++;
				}
				if (strpos($key, 'val_kategori_' . $i) !== false) {
					$countKategori++;
				}
				if (strpos($key, 'val_deadline_' . $i) !== false) {
					$countDeadline++;
				}
				if (strpos($key, 'val_pic_' . $i) !== false) {
					$countPic++;
				}
			}

			for ($iAction = 1; $iAction <= $countAction; $iAction++) {
				if (@$_POST['val_action_' . $i . '_' . $iAction] == '') {
					$result['status'] = 'error';
					$result['error'] = 'Tasklist tidak boleh kosong';
					echo json_encode($result);
					exit();
				}
			}
		}

		if ($countIssue == 0) {
			$result['status'] = 'error';
			$result['error'] = 'Issue tidak boleh kosong';
			echo json_encode($result);
			exit();
		}

		if ($countKategori == 0) {
			$result['status'] = 'error';
			$result['error'] = 'Kategori tidak boleh kosong';
			echo json_encode($result);
			exit();
		}

		if ($countDeadline == 0) {
			$result['status'] = 'error';
			$result['error'] = 'Deadline tidak boleh kosong';
			echo json_encode($result);
			exit();
		}

		if ($countPic == 0) {
			$result['status'] = 'error';
			$result['error'] = 'PIC tidak boleh kosong';
			echo json_encode($result);
			exit();
		}

		for ($i = 1; $i <= $totalIssue; $i++) {
			$countAction = 0;
			$countKategori = 0;
			$countDeadline = 0;
			$countPic = 0;
			foreach ($_POST as $key => $value) {
				if (strpos($key, 'val_action_' . $i) !== false) {
					$countAction++;
				}
				if (strpos($key, 'val_kategori_' . $i) !== false) {
					$countKategori++;
				}
				if (strpos($key, 'val_deadline_' . $i) !== false) {
					$countDeadline++;
				}
				if (strpos($key, 'val_pic_' . $i) !== false) {
					$countPic++;
				}
			}

			for ($iPic = 1; $iPic <= $countPic; $iPic++) {
				foreach ($_POST['val_pic_' . $i . '_' . $iPic] as $pic) {
					$id_task 	= $this->model->generate_id_task();
					$data = [
						'id_task' => $id_task,
						'type' => 2, // Khusus MOM
						'category' => 1,
						'object' => 1,
						'status' => 1,
						'pic' => $pic,
						'priority' => 0,
						'due_date' => @$_POST['val_deadline_' . $i . '_' . $iPic] ?? $deadline,
						'task' => $_POST['val_issue_' . $i],
						'description' => null,
						'created_at' => date("Y-m-d H:i:s"),
						'created_by' => $this->session->userdata('user_id'),
						'progress' => 0,
						'jenis_strategy' => 'Once'
					];
					$this->db->insert('td_task', $data);
					$result['task'][] = $data;
					$result['val_task_' . $i . '_' . $iPic][] = $id_task;

					$data_history = [
						'id_task' => $id_task,
						'progress' => 0,
						'status' => 1,
						'status_before' => 1,
						'note' => 'Goals Created',
						'created_at' => date('Y-m-d H:i:s'),
						'created_by' => $this->session->userdata('user_id')
					];
					$this->db->insert('td_task_history', $data_history);
					$result['history_task'][] = $data_history;

					if ($_POST['val_kategori_' . $i . '_' . $iPic] == 8) { // Daily
						$type_kategori = 1;
					} else if ($_POST['val_kategori_' . $i . '_' . $iPic] == 9) { // Weekly
						$type_kategori = 2;
					} else { // Monthly
						$type_kategori = 3;
					}

					$id_sub_task = $this->model->generate_id_sub_task();
					$data = [
						'id_sub_task' => $id_sub_task,
						'id_task' => $id_task,
						'sub_task' => $_POST['val_action_' . $i . '_' . $iPic],
						'indicator' => '',
						'type' => $type_kategori,
						'start' => date('Y-m-d H:i:s'),
						'end' => @$_POST['val_deadline_' . $i . '_' . $iPic] ?? $deadline,
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
					$this->db->insert('td_sub_task', $data);
					$result['sub_task'][] = $data;
					$result['val_sub_task_' . $i . '_' . $iPic][] = $id_sub_task;

					$data_history = [
						'id_task' => $id_task,
						'note' => 'Strategy Created : ' . $_POST['val_action_' . $i . '_' . $iPic],
						'created_at' => date('Y-m-d H:i_s'),
						'created_by' => $this->session->userdata('user_id')
					];
					$this->db->insert('td_task_history', $data_history);
					$result['history_sub_task'][] = $data_history;
				}
			}

			$dataIssue = array(
				'id_mom' => $id_mom,
				'issue' => @$_POST['val_issue_' . $i],
				'is_eskalasi' => 1,
				'id_eskalasi' => $i,
				'id_issue' => $i,
				'reff_id_sub_task' => $reff_id_sub_task
			);

			$this->db->insert('mom_issue', $dataIssue);
			$result['issue_save'][] = $dataIssue;

			for ($iAction = 1; $iAction <= $countAction; $iAction++) {
				$dataIssueItem = array(
					'id_mom' => $id_mom,
					'id_issue' => $i,
					'id_issue_item' => $iAction,
					'is_eskalasi' => 1,
					'id_eskalasi' => $i,
					'id_eskalasi_item' => $iAction,
					'deadline' => @$_POST['val_deadline_' . $i . '_' . $iAction] ?? $deadline,
					'action' => $_POST['val_action_' . $i . '_' . $iAction],
					'kategori' => $_POST['val_kategori_' . $i . '_' . $iAction],
					'pic' => implode(',', $_POST['val_pic_' . $i . '_' . $iAction]),
					'id_task' => implode(',', $result['val_task_' . $i . '_' . $iAction]),
					'id_sub_task' => implode(',', $result['val_sub_task_' . $i . '_' . $iAction]),
					'reff_id_sub_task' => $reff_id_sub_task,
					'eskalasi_by' => $this->session->userdata('user_id')
				);

				$this->db->insert('mom_issue_item', $dataIssueItem);
				$result['issue_item_save'][] = $dataIssueItem;

				// Kategori : Tasklist & Feedback
				if ($_POST['val_kategori_' . $i . '_' . $iAction] == 11) {
					$new 	= $this->model->get_pic_for_approval($id_mom, $i, $iAction);

					foreach ($new as $n) {
						$no_app = $this->model->no_app();
						$approval = array(
							'no_app'            => $no_app,
							'subject'           => $_POST['val_issue_' . $i],
							'description'       => "Issuenya " . $_POST['val_issue_' . $i] . " dan Strategynya " . $_POST['val_action_' . $i . '_' . $iAction],
							'approve_to'        => $n->pic,
							'status'            => 1,
							'tipe'            	=> "MoM", // Bedakan dari MoM
							'id_mom'            => $id_mom, // Bedakan dari MoM
							'id_issue'          => $i, // Bedakan dari MoM
							'id_issue_item'     => $iAction, // Bedakan dari MoM
							'created_at'        => date('Y-m-d', strtotime("+ 1 day")) . " 07:00:00",
							'created_by'        => $this->session->userdata('user_id')
						);

						$this->db->insert('trusmi_approval', $approval);
						$result['trusmi_approval'][] = $approval;
					}
				}
			}
		}

		$result['status'] = 'success';
		header('Content-type: application/json');
		echo json_encode($result);
	}
	public function notif_eskalasi($id_mom)
	{
		$data = $this->model->detail_notif_eskalasi($id_mom);
		foreach ($data as $item) {

			$actions = explode('#DELIM#', $item->actions);
			$deadlines = explode('#DELIM#', $item->deadlines);
			$id_sub_tasks = explode(',', $item->id_sub_task);

			// Format daftar tugas dengan deadline
			$task_list = "";
			foreach ($actions as $index => $action) {
				$deadline = $deadlines[$index] ?? 'N/A'; // Pastikan deadline tersedia
				$id_sub_task = $id_sub_tasks[$index] ?? end($id_sub_tasks);
				$task_list .= "- *Task :* " . htmlspecialchars($action) . " (Deadline: *" . htmlspecialchars($deadline) . "*)\n" . "https://trusmiverse.com/apps/ibr_update?id=" . $id_sub_task . "&u=" . $item->user_id . "\n\n";
			}
			$msg = "🚀*Notifikasi Eskalasi Tasklist IBR Pro*🚀

Hey *" . htmlspecialchars($item->pic_name) . "*
Tasklist Baru dari *$item->eskalasi_name* dengan rincian berikut :
$task_list Update Progres pada masing masing link di atas, atau di menu IBR Pro

Jangan lupa cek detail dan selesaikan tepat waktu ya! Semangat terus, kamu pasti bisa!💪✨
            ";
			$this->whatsapp_lib->send_single_msg('rsp', '083824955357', $msg);
			$this->whatsapp_lib->send_single_msg('rsp', $item->pic_contact, $msg);
			// echo json_encode($msg);
		}
	}
	public function rollback_revisi($id_task, $id_sub_task, $deadline = NULL)
	{
		if ($deadline != NULL) {
			$this->db->query("UPDATE mom_issue_item SET freq_revisi = COALESCE(freq_revisi,0) + 1, deadline = '$deadline', verified_at = NULL WHERE id_sub_task = '$id_sub_task'");
			$this->db->query("UPDATE td_task SET status = 2 WHERE id_task = '$id_task'");
			$this->db->query("UPDATE td_sub_task SET status = null, progress = 0, `end` = '$deadline' WHERE id_sub_task = '$id_sub_task'");
		} else {
			$this->db->query("UPDATE mom_issue_item SET freq_revisi = COALESCE(freq_revisi,0) + 1, verified_at = NULL WHERE id_sub_task = '$id_sub_task'");
			$this->db->query("UPDATE td_task SET status = 2 WHERE id_task = '$id_task'");
			$this->db->query("UPDATE td_sub_task SET status = null, progress = 0 WHERE id_sub_task = '$id_sub_task'");
		}
	}
}
