<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('tickets/model_main', 'model_main');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function test_gantt()
    {
        $this->load->view('tickets/test_gantt');
    }
    public function test_gantt_2()
    {
        $this->load->view('tickets/test_gantt_2');
    }

    public function view()
    {
        $data['pageTitle']        = "Tickets";
        $data['css']              = "tickets/_main_css";
        $data['content']          = "tickets/main";
        $data['js']               = "tickets/_main_js";
        $this->load->view('layout/main', $data);
    }

    public function get_requester()
    {
        $data     = $this->model_main->get_requester()->result();
        echo json_encode($data);
    }

    public function get_type()
    {
        $type = $this->db->query("SELECT id AS id_type, `type` FROM ticket_type ORDER BY `type`")->result();
        echo json_encode($type);
    }

    public function get_impact()
    {
        $type = $this->db->query("SELECT id AS id_impact, `impact` FROM ticket_impact ORDER BY impact")->result();
        echo json_encode($type);
    }

    public function get_sub_type()
    {
        $type = $this->db->query("SELECT st.id AS id_sub_type, st.`sub_type` FROM ticket_sub_type st 
        LEFT JOIN ticket_category tc ON tc.sub_type = st.id 
        WHERE tc.type = 1 GROUP BY tc.sub_type ORDER BY sub_type")->result();
        echo json_encode($type);
    }
    public function get_category()
    {
        $type = $this->db->query("SELECT id AS id_category, `category`, `type` AS id_type, COALESCE(sub_type,'') AS id_sub_type FROM ticket_category ORDER BY category")->result();
        echo json_encode($type);
    }

    public function e_get_category()
    {
        $cond = "";
        if ($this->input->post('id_type')) {
            $id_type = $this->input->post('id_type');
            $cond = "WHERE type = '$id_type'";
        }
        $type = $this->db->query("SELECT id AS id_category, `category`, `type` AS id_type,  COALESCE(sub_type,'') AS id_sub_type FROM ticket_category $cond ORDER BY category")->result();
        echo json_encode($type);
    }

    public function get_object()
    {
        $type = $this->db->query("SELECT
            o.id AS id_object,
            o.`object`,
            COALESCE(c.id,'') AS id_category,
            COALESCE(t.id,'') AS id_type 
        FROM
            ticket_object o
            LEFT JOIN ticket_category c ON o.category = c.id
            LEFT JOIN ticket_type t ON t.id = o.type 
        GROUP BY
            o.id 
        ORDER BY
            o.`object`")->result();
        echo json_encode($type);
    }

    public function get_status()
    {
        $status = $this->db->query("SELECT id AS id_status, `status`, `color` FROM ticket_status WHERE id NOT IN (15,16) ORDER BY no_urut")->result();
        echo json_encode($status);
    }

    public function get_category_by_type()
    {
        $id_type = $this->input->post('id_type');
        $category = $this->db->query("SELECT
            c.id AS id_category,
        case when c.type = 1 THEN
        CONCAT(c.category, ' (', s.sub_type,')') ELSE
            c.`category` END AS category,
            c.`type` AS id_type,
            c.sub_type,
            COALESCE(c.sub_type,'') AS id_sub_type
        FROM
            ticket_category c
            LEFT JOIN ticket_sub_type s ON s.id = c.sub_type 
        WHERE
            `type` = '$id_type'")->result();
        echo json_encode($category);
    }
    public function get_category_by_sub_type()
    {
        $id_sub_type = $this->input->post('id_sub_type');
        $category = $this->db->query("SELECT
            c.id AS id_category,
        case when c.type = 1 THEN
        CONCAT(c.category, ' (', s.sub_type,')') ELSE
            c.`category` END AS category,
            c.`type` AS id_type,
            c.sub_type,
            COALESCE(c.sub_type,'') AS id_sub_type
        FROM
            ticket_category c
            LEFT JOIN ticket_sub_type s ON s.id = c.sub_type 
        WHERE
            c.`sub_type` = '$id_sub_type'")->result();
        echo json_encode($category);
    }

    public function get_object_by_type()
    {
        $id_type = $this->input->post('id_type');
        $object =  $this->db->query("SELECT
            o.id AS id_object,
            o.`object`,
            COALESCE(c.id,'') AS id_category,
            COALESCE(t.id,'') AS id_type 
        FROM
            ticket_object o
            LEFT JOIN ticket_category c ON o.category = c.id
            LEFT JOIN ticket_type t ON t.id = o.type  WHERE o.`type` = '$id_type'
        GROUP BY o.id")->result();
        echo json_encode($object);
    }

    public function get_object_by_category()
    {
        $id_category = $this->input->post('id_category');
        $object =  $this->db->query("SELECT
            o.id AS id_object,
            o.`object`,
            COALESCE(c.id,'') AS id_category,
            COALESCE(t.id,'') AS id_type 
        FROM
            ticket_object o
            LEFT JOIN ticket_category c ON o.category = c.id
            LEFT JOIN ticket_type t ON t.id = o.type WHERE o.`category` = '$id_category'
        GROUP BY o.id")->result();
        echo json_encode($object);
    }

    public function get_pic()
    {
        $id_type = $this->input->post('id_type');
        $pic =  $this->db->query("SELECT e.user_id AS id_pic, CONCAT( e.first_name, ' ', e.last_name ) AS pic, COUNT(IF(tt.`id_task` IS NOT NULL,1,NULL)) AS ticket FROM `ticket_type` t 
        LEFT JOIN xin_employees e ON FIND_IN_SET(e.designation_id,t.designation_id)  
		LEFT JOIN ticket_task tt ON FIND_IN_SET(e.user_id,tt.pic) AND tt.`status` < 3
        AND e.is_active = 1 WHERE t.id ='$id_type' AND e.user_id != 1 AND e.is_active = 1
		GROUP BY e.user_id ORDER BY CONCAT( e.first_name, ' ', e.last_name )")->result();
        echo json_encode($pic);
    }


    public function get_pic_ticket()
    {
        $user_id = $this->session->userdata('user_id');
        $department_id = $this->session->userdata('department_id');

        $cond = " AND e.user_id = '$user_id'";
        if (in_array($department_id, [68, 83]) == 1) {
            $cond = " AND e.user_id != '$user_id'";
        }

        $pic =  $this->db->query("SELECT e.user_id AS id_pic, CONCAT( e.first_name, ' ', e.last_name ) AS pic, COUNT(IF(tt.`id_task` IS NOT NULL,1,NULL)) AS ticket FROM `ticket_type` t 
        LEFT JOIN xin_employees e ON FIND_IN_SET(e.designation_id,t.designation_id)  
		LEFT JOIN ticket_task tt ON FIND_IN_SET(e.user_id,tt.pic) AND tt.`status` < 3
        AND e.is_active = 1 WHERE e.user_id != 1 AND e.is_active = 1
		GROUP BY e.user_id ORDER BY CONCAT( e.first_name, ' ', e.last_name )")->result();
        echo json_encode($pic);
    }

    public function get_priority()
    {
        $priority = $this->db->query("SELECT id AS id_priority, `priority`, `color` FROM ticket_priority ORDER BY id DESC")->result();
        echo json_encode($priority);
    }


    public function get_level()
    {
        $level = $this->db->query("SELECT id AS id_level, `level` FROM ticket_level")->result();
        echo json_encode($level);
    }

    public function get_detail_task()
    {
        $id_task = $this->input->post('id_task') ?? "";
        $response['detail'] = "";
        $response['status'] = false;
        if ($id_task != "") {
            $response['detail'] = $this->model_main->get_detail_task($id_task);
            $response['status'] = true;
        }
        echo json_encode($response);
    }

    function get_log_history()
    {
        $id_task = $_POST['id_task'];
        $response['log'] = $this->model_main->get_log_history($id_task);
        echo json_encode($response);
    }

    function get_comment()
    {
        $id_task = $_POST['id_task'];
        $response['comment'] = $this->model_main->get_comment($id_task);
        $response['reply'] = $this->model_main->get_reply($id_task);
        echo json_encode($response);
    }


    public function generate_progress_bar()
    {
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $type = $this->input->post('type');
        $pic = $this->input->post('pic');
        if ($pic == "all") {
            $cond_pic = "";
        } else {
            $cond_pic = "AND FIND_IN_SET('$pic', t.pic)";
        }

        if ($type == "all") {
            $cond_type = "";
        } else {
            $cond_type = "AND t.type = '$type'";
        }
        $response['data'] = $this->db->query("SELECT 
        COALESCE(SUM(IF(`status`=1,1,0)),0) AS not_started,
        ROUND(( SUM(IF(`status`=1,1,0)) / COUNT(id_task) ) * 100) AS persen_not_started,
        COALESCE(SUM(IF(`status`=2,1,0)),0) AS working_on,
        ROUND(( SUM(IF(`status`=2,1,0)) / COUNT(id_task) ) * 100) AS persen_working_on, 
        COALESCE(SUM(IF(`status`=3,1,0)),0) AS done,
        ROUND(( SUM(IF(`status`=3,1,0)) / COUNT(id_task) ) * 100) AS persen_done,
        COALESCE(SUM(IF(`status`=4,1,0)),0) AS cancel, 
        ROUND(( SUM(IF(`status`=4,1,0)) / COUNT(id_task) ) * 100) AS persen_cancel,
        COUNT(id_task) AS total_task
        FROM `ticket_task` t 
        WHERE substr(t.created_at,1,10) BETWEEN '$start' AND '$end' $cond_type $cond_pic")->row();
        $response['team_solver'] = $this->db->query("SELECT COUNT( DISTINCT e.user_id ) AS total_solver FROM `ticket_type` t 
                                            JOIN xin_employees e ON FIND_IN_SET(e.designation_id,t.designation_id) AND e.is_active = 1")->row();
        $response['lt_progress'] = $this->db->query("SELECT COALESCE(SUM(TIMESTAMPDIFF( HOUR, t.`start`, CURRENT_DATE )),0) AS lt_hour 
                                                            FROM ticket_task t WHERE t.`status` = 2 AND substr(t.created_at,1,10) BETWEEN '$start' AND '$end' $cond_type $cond_pic")->row();
        $response['lt_late'] = $this->db->query("SELECT
                CONCAT(t.`due_date`,' 17:00:00') AS due_date,
                COALESCE(t.done_date,CURRENT_DATE) AS done_date,
                TIMESTAMPDIFF( HOUR, CONCAT(t.`due_date`,' 17:00:00'), COALESCE(t.done_date,CURRENT_DATE) ) diff_deadline,
                COUNT(IF(TIMESTAMPDIFF( HOUR, CONCAT(t.`due_date`,' 17:00:00'), COALESCE(t.done_date,CURRENT_DATE) ) < 0,1,NULL)) AS on_time,
                COUNT(IF(TIMESTAMPDIFF( HOUR, CONCAT(t.`due_date`,' 17:00:00'), COALESCE(t.done_date,CURRENT_DATE) ) > 0,1,NULL)) AS late,
                ROUND(COUNT(IF(TIMESTAMPDIFF( HOUR, CONCAT(t.`due_date`,' 17:00:00'), COALESCE(t.done_date,CURRENT_DATE) ) > 0,1,NULL)) / COUNT(IF(TIMESTAMPDIFF( HOUR, CONCAT(t.`due_date`,' 17:00:00'), COALESCE(t.done_date,CURRENT_DATE) ) < 0,1,NULL)) * 100) AS persen_late
        FROM ticket_task t WHERE t.`status` IN (3) AND substr(t.created_at,1,10) BETWEEN '$start' AND '$end' $cond_pic")->row();
        echo json_encode($response);
    }



    public function save_task()
    {
        $id_object = $this->input->post('id_object') ?? '';
        $id_type = $this->input->post('id_type') ?? '';
        $id_category = $this->input->post('id_category') ?? '';
        $id_impact = $this->input->post('id_impact') ?? '';
        $id_status = 1;
        $id_priority = $this->input->post('id_priority') ?? '';
        $id_requester = $this->input->post('id_requester') ?? '';
        $id_pic = $this->input->post('id_pic') ?? '';
        $task = $this->input->post('task') ?? '';
        $location = $this->input->post('location') ?? '';
        $description = $this->input->post('description') ?? '';
        $dod = $this->input->post('dod') ?? '';

        $get_due_date_by_priority = $this->db->query("SELECT DATE_ADD(CURRENT_DATE,INTERVAL tp.deadline DAY ) AS due_date FROM `ticket_priority` tp WHERE id = '$id_priority'")->row();

        $id_task = $this->model_main->generate_id_task();


        if (!empty($_FILES['file_ticket']['name'])) {
            // Proses unggah file
            $config['upload_path']   = './uploads/tickets/';
            // $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
            $config['allowed_types'] = '*';
            $new_name = $id_task . '_' . time();
            $config['file_name']     = $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file_ticket')) {
                $response['error'] = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data['upload_data']['file_name'];
            }
        } else {
            $file_name = "";
        }

        $data = [
            'id_task' => $id_task,
            'type' => $id_type,
            'object' => $id_object,
            'category' => $id_category,
            'impact' => $id_impact,
            'status' => $id_status,
            'pic' => $id_pic,
            'priority' => $id_priority,
            'task' => $task,
            'location' => $location,
            'description' => $description,
            'dod' => $dod,
            'due_date' => $get_due_date_by_priority->due_date ?? "",
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $id_requester ?? $this->session->userdata('user_id'),
            'progress' => 0,
            'file' => $file_name
        ];
        $save_task = $this->db->insert('ticket_task', $data);
        $data_history = [
            'id_task' => $id_task,
            'progress' => 0,
            'status' => $id_status,
            'status_before' => $id_status,
            'note' => 'Tickets Created',
            'created_at' => date('Y-m-d H:i_s'),
            'created_by' => $id_requester ?? $this->session->userdata('user_id')
        ];
        $save_history = $this->db->insert('ticket_task_history', $data_history);

        $this->send_notif_request($id_task);

        $response['id_task']    = $id_task;
        $response['save_task']  = $save_task;
        echo json_encode($response);
    }


    public function update_task()
    {
        $id_task = $this->input->post('id_task') ?? '';
        $update_task = "";
        if ($id_task != "") {
            $id_status      = strip_tags($this->input->post('id_status')) ?? '';
            $id_priority    = strip_tags($this->input->post('id_priority')) ?? '';
            $id_level       = strip_tags($this->input->post('id_level')) ?? '';
            $id_pic         = strip_tags($this->input->post('id_pic')) ?? '';
            $progress       = strip_tags($this->input->post('progress')) ?? '';
            $note           = strip_tags($this->input->post('note')) ?? '';
            $start          = strip_tags($this->input->post('start_timeline')) ?? '';
            $end            = strip_tags($this->input->post('end_timeline')) ?? '';
            $due_date       = strip_tags($this->input->post('due_date')) ?? '';
            $uat_leadtime   = strip_tags($this->input->post('uat_leadtime')) ?? ''; //Windu || 09-08-2024

            $get_old_status = $this->db->query("SELECT `status` FROM ticket_task WHERE id_task = '$id_task'")->row();
            $data_history = [
                'id_task'       => $id_task,
                'progress'      => $progress,
                'status'        => $id_status,
                'status_before' => $get_old_status->status,
                'note'          => $note,
                'created_at'    => date('Y-m-d H:i_s'),
                'created_by'    => $this->session->userdata('user_id')
            ];
            $save_history = $this->db->insert('ticket_task_history', $data_history);
            $data = [
                'status'        => $id_status,
                'progress'      => $progress,
                'note'          => $note,
                'priority'      => $id_priority,
                'level'         => $id_level,
            ];

            if ($get_old_status->status == 1 || $id_status == 6) {
                $data['due_date'] = $due_date;
                $data['start']    = $start;
                $data['end']      = $end;
                $data['pic'] = $id_pic;



                // kondisi baru
                if ($this->input->post('id_type')) {
                    $id_type = strip_tags($this->input->post('id_type'));
                    if ($id_type != '') {
                        $data['type'] = $id_type;
                    }
                }

                if ($this->input->post('id_category')) {
                    $id_category = strip_tags($this->input->post('id_category'));
                    if ($id_category != '') {
                        $data['category'] = $id_category;
                    }
                }

                if ($this->input->post('id_object')) {
                    $id_object = strip_tags($this->input->post('id_object'));
                    if ($id_object != '') {
                        $data['object'] = $id_object;
                    }
                }
            }

            if ($id_status == 3 || $id_status == 4) {
                $data['done_date'] = date("Y-m-d H:i:s");
            } else {
                $data['done_date'] = null;
            }
            if ($id_status == 12) { //Windu || 09-08-2024
                $data['uat_leadtime'] = $uat_leadtime;
            }

            $update_task = $this->db->where('id_task', $id_task)->update('ticket_task', $data);
            if ($get_old_status->status == 1 && $id_status == 2) {
                $this->send_notif_scheduled($id_task);
            }

            if (in_array($get_old_status->status, [1, 8, 9, 10, 2,]) == 1 && $id_status == 5) {
                $this->send_notif_working_on($id_task);
            }

            if (in_array($get_old_status->status, [1, 2, 3, 4, 5, 6]) == 1 && $id_status == 7) {
                $this->send_notif_hold($id_task);
            }

            if (in_array($get_old_status->status, [1, 2, 3, 4, 5, 6]) == 1 && $id_status == 6) {
                $this->send_notif_rescheduled($id_task);
            }

            if (in_array($get_old_status->status, [1, 2, 4, 5, 6, 7, 8, 9, 10, 12, 13]) == 1 && $id_status == 11) {
                $this->send_notif_request_qa($id_task);
            }

            if (in_array($get_old_status->status, [1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]) == 1 && $id_status == 3) {
                $this->send_notif_done($id_task);
            }

            if (in_array($get_old_status->status, [1, 2, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]) == 1 && $id_status == 4) {
                $this->send_notif_cancel($id_task);
            }
            if ($get_old_status->status != 12 && $id_status == 12) {
                $this->send_notif_uat($id_task);
            }
        }

        echo json_encode($update_task);
    }

    public function save_comment()
    {
        $id_task = $this->input->post('id_task') ?? '';
        $comment = $this->input->post('comment') ?? '';
        $save_comment = "";
        if ($id_task != "") {
            $data_history = [
                'id_task' => $id_task,
                'comment' => $comment,
                'created_at' => date('Y-m-d H:i_s'),
                'created_by' => $this->session->userdata('user_id')
            ];
            $save_comment = $this->db->insert('ticket_comment', $data_history);
        }

        echo json_encode($save_comment);
    }

    public function save_reply()
    {
        $id_task = $this->input->post('id_task') ?? '';
        $id_comment = $this->input->post('id_comment') ?? '';
        $comment = $this->input->post('comment') ?? '';
        $save_reply = "";
        if ($id_task != "") {
            $data_history = [
                'id_task' => $id_task,
                'reply_to' => $id_comment,
                'comment' => $comment,
                'created_at' => date('Y-m-d H:i_s'),
                'created_by' => $this->session->userdata('user_id')
            ];
            $save_reply = $this->db->insert('ticket_comment', $data_history);
        }

        echo json_encode($save_reply);
    }


    function get_attachment()
    {
        $id_task = $_POST['id_task'];
        $response['attachment'] = $this->model_main->get_attachment($id_task);
        echo json_encode($response);
    }

    function upload_file()
    {
        if (!empty($_FILES)) {
            $id_task = $this->input->post('id_task');

            // Proses unggah file
            $config['upload_path']   = './uploads/tickets/';
            // $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
            $config['allowed_types'] = '*';
            $new_name = $id_task . '_' . time();
            $config['file_name']     = $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file')) {
                $file['data'] = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
                $fileName = $data['upload_data']['file_name'];
                $file['data'] = $fileName;
                $file['size'] = $_FILES['file']['size'];
                $file['ext'] = pathinfo($fileName, PATHINFO_EXTENSION);
            }
            $data_upload = array(
                'id_task'       => $_POST['id_task'],
                'note'          => $_POST['nama_file'],
                'attachment'    => $fileName,
                'created_at'    => date('Y-m-d H:i:s'),
                'created_by'    => $_SESSION['user_id'],
            );
            $data['file'] = $file;
            $data['insert'] = $this->db->insert('ticket_task_attach', $data_upload);
        } else {
            $file['data'] = $_FILES["file"]["error"];
            $data['file'] = $file;
            $data['insert'] = null;
        }

        echo json_encode($data);
    }


    public function send_notif_request($id_task)
    {
        $ticket = $this->model_main->get_ticket_request($id_task);
        foreach ($ticket as $team) {
            $team_name[] = $team->employee_name;
        }
        $pic = implode(", ", $team_name);
        foreach ($ticket as $row) {
            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
            $data_text = array(
                "channelID" => "2225082380", // Channel Trusmi Group
                // "phone" => '6285324409384',
                "phone" => $row->contact_no,
                "messageType" => "text",
                "body" => "🚨 Hey there!

There is a new request from *" . trim(ucwords($row->requester_name)) . "* for you, please review immediately.

🏷️ Type : *" . trim(ucwords($row->type)) . "*
📋 Category : *" . trim(ucwords($row->category)) . "*
📝 Title : *" . trim(ucwords($row->task)) . "*
💣 Priority : *" . trim(ucwords($row->priority)) . "*
👤 PIC : *" . trim(ucwords($pic)) . "* 
📄 Description : *" . trim(strip_tags(str_replace('<', ' <', $row->description))) . "*

link review :
https://trusmiverse.com/apps/my-tickets/" . $row->id_task . "
            
" . $row->created_at . "",
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
            $context_text  = stream_context_create($options_text);
            $result_text = file_get_contents($url, false, $context_text);
            $response['text'][] = json_decode($result_text);
        }
    }

    public function send_notif_scheduled($id_task)
    {
        $row_ticket = $this->model_main->get_ticket_request_working_on($id_task);
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
        $data_text = array(
            "channelID" => "2225082380", // Channel Trusmi Group
            // "phone" => '6285324409384',
            "phone" => $row_ticket->requester_contact_no,
            "messageType" => "text",
            "body" => "🚨 Hello, *" . trim(ucwords($row_ticket->requester_name)) . "*.

Your request is being *scheduled*. We try to provide you with the best solution as quickly as possible. Thank you for your patience.

Detail Request :
🏷️ Type : *" . trim(ucwords($row_ticket->type)) . "*
📋 Category : *" . trim(ucwords($row_ticket->category)) . "*
📝 Title : *" . trim(ucwords($row_ticket->task)) . "*
💣 Priority : *" . trim(ucwords($row_ticket->priority)) . "*
👤 PIC : *" . trim(ucwords($row_ticket->pic_name)) . "* 
📆 Timeline : *" . trim(($row_ticket->timeline)) . "* 
📄 Description : *" . trim(strip_tags(str_replace('<', ' <', $row_ticket->description))) . "*

need more detail about your request ? visit this link :
https://trusmiverse.com/apps/my-tickets/" . $row_ticket->id_task . "
            
" . $row_ticket->created_at . "",
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
        $context_text  = stream_context_create($options_text);
        $result_text = file_get_contents($url, false, $context_text);
        $response['text'][] = json_decode($result_text);
    }

    public function send_notif_working_on($id_task)
    {
        $row_ticket = $this->model_main->get_ticket_request_working_on($id_task);
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
        $data_text = array(
            "channelID" => "2225082380", // Channel Trusmi Group
            // "phone" => '6285324409384',
            "phone" => $row_ticket->requester_contact_no,
            "messageType" => "text",
            "body" => "🚨 Hello, *" . trim(ucwords($row_ticket->requester_name)) . "*.

Your request is being processed. We try to provide you with the best solution as quickly as possible. Thank you for your patience.

Detail Request :
🏷️ Type : *" . trim(ucwords($row_ticket->type)) . "*
📋 Category : *" . trim(ucwords($row_ticket->category)) . "*
📝 Title : *" . trim(ucwords($row_ticket->task)) . "*
💣 Priority : *" . trim(ucwords($row_ticket->priority)) . "*
👤 PIC : *" . trim(ucwords($row_ticket->pic_name)) . "* 
📆 Timeline : *" . trim(($row_ticket->timeline)) . "* 
📄 Description : *" . trim(strip_tags(str_replace('<', ' <', $row_ticket->description))) . "*

need more detail about your request ? visit this link :
https://trusmiverse.com/apps/my-tickets/" . $row_ticket->id_task . "
            
" . $row_ticket->created_at . "",
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
        $context_text  = stream_context_create($options_text);
        $result_text = file_get_contents($url, false, $context_text);
        $response['text'][] = json_decode($result_text);
    }

    public function send_notif_cancel($id_task)
    {
        $row_ticket = $this->model_main->get_ticket_request_cancel($id_task);
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
        $data_text = array(
            "channelID" => "2225082380", // Channel Trusmi Group
            // "phone" => '6285324409384',
            "phone" => $row_ticket->requester_contact_no,
            "messageType" => "text",
            "body" => "🚨 Hello, *" . trim(ucwords($row_ticket->requester_name)) . "*.

Sorry your request has been *cancel*.

Detail Request :
🏷️ Type : *" . trim(ucwords($row_ticket->type)) . "*
📋 Category : *" . trim(ucwords($row_ticket->category)) . "*
📝 Title : *" . trim(ucwords($row_ticket->task)) . "*
💣 Priority : *" . trim(ucwords($row_ticket->priority)) . "*
👤 PIC : *" . trim(ucwords($row_ticket->pic_name)) . "* 
📄 Description : *" . trim(strip_tags(str_replace('<', ' <', $row_ticket->description))) . "*
📄 Note Cancel : *" . trim(strip_tags(str_replace('<', ' <', $row_ticket->note))) . "*

need more detail about your request ? visit this link :
https://trusmiverse.com/apps/my-tickets/" . $row_ticket->id_task . "
            
" . $row_ticket->created_at . "",
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
        $context_text  = stream_context_create($options_text);
        $result_text = file_get_contents($url, false, $context_text);
        $response['text'][] = json_decode($result_text);
    }


    public function send_notif_rescheduled($id_task)
    {
        $row_ticket = $this->model_main->get_ticket_request_rescheduled($id_task);
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
        $data_text = array(
            "channelID" => "2225082380", // Channel Trusmi Group
            // "phone" => '6285324409384',
            "phone" => $row_ticket->requester_contact_no,
            "messageType" => "text",
            "body" => "🚨 Hello, *" . trim(ucwords($row_ticket->requester_name)) . "*.

Sorry your request has been *rescheduled*.

Detail Request :
🏷️ Type : *" . trim(ucwords($row_ticket->type)) . "*
📋 Category : *" . trim(ucwords($row_ticket->category)) . "*
📝 Title : *" . trim(ucwords($row_ticket->task)) . "*
💣 Priority : *" . trim(ucwords($row_ticket->priority)) . "*
👤 PIC : *" . trim(ucwords($row_ticket->pic_name)) . "* 
📄 Description : *" . trim(strip_tags(str_replace('<', ' <', $row_ticket->description))) . "*
📄 Note Rescheduled : *" . trim(strip_tags(str_replace('<', ' <', $row_ticket->note))) . "*

need more detail about your request ? visit this link :
https://trusmiverse.com/apps/my-tickets/" . $row_ticket->id_task . "
            
" . $row_ticket->created_at . "",
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
        $context_text  = stream_context_create($options_text);
        $result_text = file_get_contents($url, false, $context_text);
        $response['text'][] = json_decode($result_text);
    }


    public function send_notif_hold($id_task)
    {
        $row_ticket = $this->model_main->get_ticket_request_hold($id_task);
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
        $data_text = array(
            "channelID" => "2225082380", // Channel Trusmi Group
            // "phone" => '6285324409384',
            "phone" => $row_ticket->requester_contact_no,
            "messageType" => "text",
            "body" => "🚨 Hello, *" . trim(ucwords($row_ticket->requester_name)) . "*.

Sorry your request has been *hold*.

Detail Request :
🏷️ Type : *" . trim(ucwords($row_ticket->type)) . "*
📋 Category : *" . trim(ucwords($row_ticket->category)) . "*
📝 Title : *" . trim(ucwords($row_ticket->task)) . "*
💣 Priority : *" . trim(ucwords($row_ticket->priority)) . "*
👤 PIC : *" . trim(ucwords($row_ticket->pic_name)) . "* 
📄 Description : *" . trim(strip_tags(str_replace('<', ' <', $row_ticket->description))) . "*
📄 Note Hold : *" . trim(strip_tags(str_replace('<', ' <', $row_ticket->note))) . "*

need more detail about your request ? visit this link :
https://trusmiverse.com/apps/my-tickets/" . $row_ticket->id_task . "
            
" . $row_ticket->created_at . "",
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
        $context_text  = stream_context_create($options_text);
        $result_text = file_get_contents($url, false, $context_text);
        $response['text'][] = json_decode($result_text);
    }


    public function send_notif_done($id_task)
    {
        $row_ticket = $this->model_main->get_ticket_request_done($id_task);
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
        $data_text = array(
            "channelID" => "2225082380", // Channel Trusmi Group
            // "phone" => '6285324409384',
            "phone" => $row_ticket->requester_contact_no,
            "messageType" => "text",
            "body" => "🚨 Hello, *" . trim(ucwords($row_ticket->requester_name)) . "*.

Your request has been *completed*. Thank you for your patience.

Detail Request :
🏷️ Type : *" . trim(ucwords($row_ticket->type)) . "*
📋 Category : *" . trim(ucwords($row_ticket->category)) . "*
📝 Title : *" . trim(ucwords($row_ticket->task)) . "*
💣 Priority : *" . trim(ucwords($row_ticket->priority)) . "*
👤 PIC : *" . trim(ucwords($row_ticket->pic_name)) . "* 
📄 Description : *" . trim(strip_tags(str_replace('<', ' <', $row_ticket->description))) . "*

need more detail about your request ? visit this link :
https://trusmiverse.com/apps/my-tickets/" . $row_ticket->id_task . "
            
" . $row_ticket->created_at . "",
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
        $context_text  = stream_context_create($options_text);
        $result_text = file_get_contents($url, false, $context_text);
        $response['text'][] = json_decode($result_text);
    }



    public function resend_notif_request()
    {
        $id_task = $this->input->post('id_task');
        $ticket = $this->model_main->get_ticket_request($id_task);
        foreach ($ticket as $team) {
            $team_name[] = $team->employee_name;
        }
        $pic = trim(implode(", ", $team_name));
        foreach ($ticket as $row) {
            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
            $data_text = array(
                "channelID" => "2225082380", // Channel Trusmi Group
                // "phone" => '6285324409384',
                "phone" => $row->contact_no,
                "messageType" => "text",
                "body" => "🚨 Hey there!

There is a new request from *" . trim(ucwords($row->requester_name)) . "* for you, please review immediately.

🏷️ Type : *" . trim(ucwords($row->type)) . "*
📋 Category : *" . trim(ucwords($row->category)) . "*
📝 Title : *" . trim(ucwords($row->task)) . "*
💣 Priority : *" . trim(ucwords($row->priority)) . "*
👤 PIC : *" . trim(ucwords($pic)) . "* 
📄 Description : *" . trim(strip_tags($row->description)) . "*

link review :
https://trusmiverse.com/apps/my-tickets/" . $row->id_task . "
            
" . $row->created_at . "",
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
            $context_text  = stream_context_create($options_text);
            $result_text = file_get_contents($url, false, $context_text);
            $response['text'][] = json_decode($result_text);
        }

        $response['status'] = true;
        echo json_encode($response);
    }


    public function send_notif_request_qa($id_task)
    {
        $row_ticket = $this->model_main->get_ticket_request_qa($id_task);
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
        $data_text = array(
            "channelID" => "2225082380", // Channel Trusmi Group
            "phone" => '6282316041423',
            "messageType" => "text",
            "body" => "🚨 Hello....

There is a request for a quality check 

Detail Request :
🏷️ Type : *" . trim(ucwords($row_ticket->type)) . "*
📋 Category : *" . trim(ucwords($row_ticket->category)) . "*
📝 Title : *" . trim(ucwords($row_ticket->task)) . "*
💣 Priority : *" . trim(ucwords($row_ticket->priority)) . "*
👤 PIC : *" . trim(ucwords($row_ticket->pic_name)) . "* 
📆 Timeline : *" . trim(($row_ticket->timeline)) . "* 
📄 Description : *" . trim(strip_tags(str_replace('<', ' <', $row_ticket->description))) . "*

need more detail about your request ? visit this link :
https://trusmiverse.com/apps/my-tickets/" . $row_ticket->id_task . "
            
" . $row_ticket->created_at . "",
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
        $context_text  = stream_context_create($options_text);
        $result_text = file_get_contents($url, false, $context_text);
        $response['text'][] = json_decode($result_text);
    }
    public function send_notif_uat($id_task)
    {
        $row_ticket = $this->model_main->get_ticket_uat($id_task);
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
        $data_text = array(
            "channelID" => "2225082380", // Channel Trusmi Group
            "phone" => $row_ticket['contact'],
            "messageType" => "text",
            "body" => "🛰  *Notifikasi UAT Development System* 🛰 

Halo *" . $row_ticket['requester'] . "*,

Kami ingin menginformasikan bahwa tiket pengembangan sistem dengan nomor _" . $row_ticket['id_task'] . "_ telah selesai dikerjakan oleh tim development.

Silakan segera lakukan User Acceptance Testing (UAT) untuk memastikan bahwa semua fungsi berjalan dengan baik sesuai dengan spesifikasi yang telah disepakati.

Detail Ticket :

Nomor Ticket : " . trim(ucwords($row_ticket['id_task'])) . "
Task : " . trim(ucwords($row_ticket['task'])) . "
Deskripsi : " . trim(ucwords($row_ticket['description'])) . "
Deadline UAT : " . trim(ucwords($row_ticket['uat_leadtime'])) . "

Untuk memberikan hasil UAT, Anda dapat mengakses link berikut:
https://trusmiverse.com/apps/uat_form/index/" . $row_ticket['id_task'] . "

Jika ditemukan masalah atau ada hal yang perlu diperbaiki, harap lengkapi deskripsi melalui link diatas.

Terima kasih atas kerjasama dan dukungannya.",
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
        $context_text  = stream_context_create($options_text);
        $result_text = file_get_contents($url, false, $context_text);
        $response['text'][] = json_decode($result_text);
        // echo json_encode($response);
    }


    public function check_lsa()
    {
        // layanan -> waktu pelayanan ->  prioritas -> waktu eskalasi -> level -> waktu eksekusi
        $hour = date("H");
        $is_work_hour = (int) $hour <= 17 && (int) $hour >= 8 ? true : false;
        $id_pic       = $this->input->post('id_pic');
        $id_sub_type  = $this->input->post('id_sub_type');
        $id_priority  = $this->input->post('id_priority');
        $id_level     = $this->input->post('id_level');
        $eskalasi_time = 0;
        $eksekusi_time = 0;
        if ($id_sub_type == '1' && $is_work_hour === true) {
            if ($id_priority == 2) {
                $eskalasi_time = 1 * 24 * 60;
            }
            if ($id_priority == 3) {
                $eskalasi_time = 2 * 24 * 60;
            }
            if ($id_priority == 4) {
                $eskalasi_time = 3 * 24 * 60;
            }

            if ($id_level == 1) {
                $eksekusi_time = 1 * 24 * 60;
            }
            if ($id_level == 2) {
                $eksekusi_time = 2 * 24 * 60;
            }
            if ($id_level == 3) {
                $eksekusi_time = 3 * 24 * 60;
            }
            if ($id_level == 4) {
                $eksekusi_time = 7 * 24 * 60;
            }
            if ($id_level == 5) {
                $eksekusi_time = 14 * 24 * 60;
            }
        }


        if (in_array($id_sub_type, ['2', '3', '4']) == 1 && $is_work_hour === true) {
            if ($id_priority == 2) {
                $eskalasi_time = 1 * 1 * 15;
            }
            if ($id_priority == 3) {
                $eskalasi_time = 1 * 1 * 30;
            }
            if ($id_priority == 4) {
                $eskalasi_time = 1 * 2 * 60;
            }

            if ($id_level == 1) {
                $eksekusi_time = 1 * 1 * 60;
            }
            if ($id_level == 2) {
                $eksekusi_time = 1 * 2 * 60;
            }
            if ($id_level == 3) {
                $eksekusi_time = 1 * 3 * 60;
            }
            if ($id_level == 4) {
                $eksekusi_time = 1 * 5 * 60;
            }
            if ($id_level == 5) {
                $eksekusi_time = 1 * 24 * 60;
            }
        }


        if (in_array($id_sub_type, ['2', '3', '4']) == 1  && $is_work_hour === false) {
            if ($id_priority == 2) {
                $eskalasi_time = 1 * 1 * 60;
            }
            if ($id_priority == 3) {
                $eskalasi_time = 1 * 2 * 60;
            }
            if ($id_priority == 4) {
                $eskalasi_time = 1 * 3 * 60;
            }

            if ($id_level == 1) {
                $eksekusi_time = 1 * 2 * 60;
            }
            if ($id_level == 2) {
                $eksekusi_time = 1 * 3 * 60;
            }
            if ($id_level == 3) {
                $eksekusi_time = 1 * 5 * 60;
            }
            if ($id_level == 4) {
                $eksekusi_time = 1 * 24 * 60;
            }
            if ($id_level == 5) {
                $eksekusi_time = 1 * 36 * 60;
            }
        }

        $sql = "SELECT
            x.user_id,
            t.id_task,
            COALESCE(MIN(t.`end`), CURRENT_TIME) AS `end` 
        FROM
            (
            SELECT
                e.user_id,
                MAX( t.`end` ) AS max_end_timeline 
            FROM
                xin_employees e
                LEFT JOIN ticket_task t ON FIND_IN_SET( e.user_id, t.pic ) 
                AND `status` = 2 
            WHERE
                FIND_IN_SET( e.`user_id`, '$id_pic' ) 
            GROUP BY
                e.user_id 
            ) AS x
            LEFT JOIN ticket_task t ON t.end = x.max_end_timeline";
        $get_last_timeline = $this->db->query($sql)->row();
        if ($get_last_timeline && $id_sub_type == 1) {
            $due_date = date("Y-m-d", strtotime($get_last_timeline->end));
            $min_end_timeline = $get_last_timeline->end;
        } else {
            $due_date = date("Y-m-d");
            $min_end_timeline = date("Y-m-d H:i:00");
        }

        $response['min_end_timeline']   = $min_end_timeline;
        $response['hour']               = $hour;
        $response['is_work_hour']       = $is_work_hour;
        $response['eskalasi_time']      = $eskalasi_time;
        $response['due_date']           = date("Y-m-d", strtotime($due_date . ' +' . $eksekusi_time . ' minutes'));
        $response['eskalasi_deadline']  = date("Y-m-d H:i:00", strtotime($min_end_timeline . ' +' . $eskalasi_time . ' minutes'));
        $response['eksekusi_time']      = $eksekusi_time;
        $response['eksekusi_start']     = date("Y-m-d H:i:00", strtotime($min_end_timeline));
        $response['eksekusi_end']       = date("Y-m-d H:i:00", strtotime($min_end_timeline . ' +' . $eksekusi_time . ' minutes'));
        echo json_encode($response);
    }
}
