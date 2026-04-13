<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Problem_solving_update extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");
		$this->load->library("whatsapp_lib");
		$this->load->model('Model_problem_solving_new', 'model');
	}

	function index()
	{
		// $data['content'] 			= "problem_solving_new/update/index";
		$data['pageTitle'] 			= "Problem Solving";
		// $data['css'] 				= "problem_solving_new/update/css";
		// $data['js'] 				= "problem_solving_new/update/js";
		$data['status']				= $this->model->get_master('status');

		$id_ps = @$_GET['id'];
        $user_id = @$_GET['u'];
		// $data['pic']				= $this->model->get_pic_public($user_id);

		$data['task'] = $this->model->profile_data($id_ps, $user_id);
        if($data['task']['id_ps'] == null){
            $this->load->view('problem_solving_new/update/not_found', $data);
        }else{
            $this->load->view('problem_solving_new/update/choose_action', $data);
        }
	}

	function get_pic()
    {
        $department_id = $_POST['department_id'];
        $data['pic'] = $this->model->get_pic($department_id);
        header('Content-type: application/json');
        echo json_encode($data);
    }

	function get_detail_problem($id)
	{
		$result = $this->model->get_detail_problem($id);
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	function generate_id_task()
	{
		$q = $this->db->query("SELECT
								MAX( RIGHT ( td_task.id_task, 3 ) ) AS kd_max 
								FROM
								td_task 
								WHERE
								SUBSTR( td_task.created_at, 1, 10 ) = CURDATE( )");
		$kd = "";

		if ($q->num_rows() > 0) {
		foreach ($q->result() as $k) {
			$tmp = ((int) $k->kd_max) + 1;
			$kd = sprintf("%03s", $tmp);
		}
		} else {
		$kd = "001";
		}
		return 'T' . date('ymd') . $kd;
	}

	function generate_id_sub_task()
	{
		$q = $this->db->query("SELECT
			MAX( RIGHT ( td_sub_task.id_sub_task, 3 ) ) AS kd_max 
			FROM
			td_sub_task 
			WHERE
			SUBSTR( td_sub_task.created_at, 1, 10 ) = CURDATE( )");
		$kd = "";

		if ($q->num_rows() > 0) {
		foreach ($q->result() as $k) {
			$tmp = ((int) $k->kd_max) + 1;
			$kd = sprintf("%03s", $tmp);
		}
		} else {
		$kd = "001";
		}
		return 'ST' . date('ymd') . $kd;
	}

	function save_proses_resume()
	{
		$id				= $_POST['id_ps'];
		// $status			= $_POST['status_akhir'];
		$resume			= $_POST['resume'];
		$link_solution	= $_POST['link_solution'];
		$updated_at		= date("Y-m-d H:i:s");
		$updated_by		= $_POST['user_id'];

		$fname = null;
		if (is_uploaded_file(@$_FILES['files']['tmp_name'])) {
			//checking file type
			$allowed =  array('pdf', 'xls', 'xlsx', 'csv', 'png', 'jpg', 'jpeg');
			$filename = @$_FILES['files']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$fname = null;
			if (in_array($ext, $allowed)) {
				$tmp_name = $_FILES["files"]["tmp_name"];
				$profile = "./uploads/files_ps/";
				// basename() may prevent filesystem traversal attacks;
				// further validation/sanitation of the filename may be appropriate
				$newfilename = 'ps_proses_' . $updated_by . '_' . substr(time(), -5) . '.' . $ext;
				$data['move'] = move_uploaded_file($tmp_name, $profile . $newfilename);
				$fname = $newfilename;
			}
		}

		if (isset($_POST['check_tindakan']) && $_POST['check_tindakan'] == '1') {
			$tindakan		= $_POST['tindakan'];
			$tasklist		= $_POST['tasklist'];
			$delegate_escalate_to		= $_POST['delegate_escalate_to'];
			$deadline_solution		= $_POST['deadline_solution'];

			// auto set status jika pilihan status dari form di matikan
			$status			= 2;

			$data = array(
				"id_ps"				=> $id,
				"status" 			=> $status,
				"resume" 			=> $resume,
				"link_solution" 	=> $link_solution,
				'lampiran'			=> $fname,
				"tindakan" 			=> $tindakan,
				"tasklist" 			=> $tasklist,
				"delegate_escalate_to" => $delegate_escalate_to,
				"deadline_solution" => $deadline_solution,
				"updated_at" 		=> $updated_at,
				"updated_by" 		=> $updated_by
			);

			$this->db->insert("ps_task_delegate_history", [
				"id_ps" => $id,
				"delegate_escalate_to" => $delegate_escalate_to,
				"created_at" => date("Y-m-d H:i:s"),
				"created_by" => $updated_by
			]);

			$id_task 	= $this->generate_id_task();
			$data_task = [
				'id_task' => $id_task,
				'type' => 1,
				'category' => 1,
				'object' => 1,
				'status' => 1,
				'pic' => $delegate_escalate_to,
				'priority' => 0,
				'due_date' => $deadline_solution,
				'task' => strip_tags($tasklist),
				'description' => null,
				'created_at' => date("Y-m-d H:i:s"),
				'created_by' => $updated_by,
				'progress' => 0,
				'jenis_strategy' => 'Once'
			];
			$this->db->insert('td_task', $data_task);

			$data_history_task = [
				'id_task' => $id_task,
				'progress' => 0,
				'status' => 1,
				'status_before' => 1,
				'note' => 'Goals Created from Problem Solving : '. $id,
				'created_at' => date('Y-m-d H:i:s'),
				'created_by' => $updated_by
			];
			$this->db->insert('td_task_history', $data_history_task);

			$id_sub_task = $this->generate_id_sub_task();
			$data_sub = [
				'id_sub_task' => $id_sub_task,
				'id_task' => $id_task,
				'sub_task' => strip_tags($tasklist),
				'indicator' => '',
				'type' => 3,
				'start' => date('Y-m-d H:i:s'),
				'end' => $deadline_solution,
				'file' => '',
				'created_at' => date("Y-m-d H:i:s"),
				'created_by' => $updated_by,
				'note' => 'Created from Problem Solving : ' . $id,
				'target' => 1,
				'actual' => 0,
				'progress' => 0,
				'jam_notif' => '07:00',
				'day_per_week' => 0,
				'id_ps' => $id,
			];
			$this->db->insert('td_sub_task', $data_sub);

			$data_history_sub = [
				'id_task' => $id_task,
				'note' => 'Strategy Created : ' . strip_tags($tasklist),
				'created_at' => date('Y-m-d H:i_s'),
				'created_by' => $updated_by
			];
			$this->db->insert('td_task_history', $data_history_sub);

			$emp_delegate = $this->db->query("SELECT CONCAT(first_name,' ',last_name) as name, contact_no FROM xin_employees WHERE user_id = $delegate_escalate_to")->row();

			$task_list = "- *Task :* " . htmlspecialchars(strip_tags($tasklist)) . " (Deadline: *" . htmlspecialchars($deadline_solution) . "*)\n"."https://trusmiverse.com/apps/ibr_update?id=".$id_sub_task."&u=".$delegate_escalate_to."\n\n";
			$msg = "🚀*Notifikasi Tasklist IBR Pro*🚀

Hey *".htmlspecialchars($emp_delegate->name)."*
Tasklist Baru dari Menu Problem Solving dengan rincian berikut :
$task_list Update Progres pada link di atas, atau di menu IBR Pro dan juga di menu Problem Solving

Jangan lupa cek detail dan selesaikan tepat waktu ya! Semangat terus, kamu pasti bisa!💪✨
            ";

			$url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
            $data_text = array(
                "channelID" => "2225082380", // Channel Trusmi Group
                "phone" => $emp_delegate->contact_no,
                "messageType" => "text",
                "body" => $msg,
                "withCase" => true
            );

            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Accept: application/json',
                'API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1'
            ));
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_text));

            $result_text = curl_exec($ch);

            if (curl_errno($ch)) {
                // Handle error
                $error_msg = curl_error($ch);
                echo "cURL error: $error_msg";
            }

            curl_close($ch);

		} else {
			// auto set setatus jika pilihan status dari form di matikan
			$status			= 2;

			$data = array(
				"id_ps"				=> $id,
				"status" 			=> $status,
				"resume" 			=> $resume,
				"link_solution" 	=> $link_solution ?? null,
				'lampiran' 			=> $fname,
				"updated_at" 		=> $updated_at,
				"updated_by" 		=> $updated_by
			);

		}

		$this->db->where("id_ps", $id);
		$result['update_resume'] = $this->db->update("ps_task", $data);

		$history = array(
			"ps_id"				=> $id,
			"status" 			=> $status,
			"resume" 			=> $resume,
			"created_at" 		=> $updated_at,
			"created_by" 		=> $updated_by
		);

		$result['insert_history'] = $this->db->insert("ps_task_history", $history);
		header('Content-Type: application/json');
		echo json_encode($result);
	}
}
