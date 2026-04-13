<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main_dev extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('Filter');
        $this->load->library('Whatsapp_lib');
        $this->load->model('complaints/model_main', 'model_main');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function test_nomor()
    {
        $nomor_telepon = "+0 812-2000-0204";

        // Membersihkan nomor telepon dari karakter yang tidak diinginkan
        $nomor_telepon_bersih = preg_replace('/[^0-9]/', '', $nomor_telepon);

        // Jika nomor telepon dimulai dengan "08", ubah menjadi "628"
        if (substr($nomor_telepon_bersih, 0, 2) == "08") {
            $nomor_telepon_bersih = "628" . substr($nomor_telepon_bersih, 2);
        }

        echo "Nomor telepon bersih: " . $nomor_telepon_bersih;
    }

    public function view()
    {
        $data['user']             = $this->model_main->get_user();
        $data['pageTitle']        = "Complaints DEV";
        $data['css']              = "complaints/_main_css";
        $data['content']          = "complaints/main_dev";
        $data['js']               = "complaints/_main_js_dev";
        $this->load->view('layout/main', $data);
    }

    public function get_project()
    {
        $data     = $this->model_main->get_project()->result();
        echo json_encode($data);
    }

    public function get_blok_by_id_project()
    {
        $id_project = $this->input->post('id_project');
        $data['blok']     = $this->model_main->get_blok_by_id_project()->result();
        $data['pekerjaan'] = $this->db->get_where('m_pekerjaan')->result();
        echo json_encode($data);
    }

    public function get_konsumen()
    {
        $data     = $this->model_main->get_konsumen();
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode('');
        }
    }

    public function get_requester()
    {
        $data     = $this->model_main->get_requester()->result();
        echo json_encode($data);
    }

    public function get_category()
    {
        $type = $this->db->query("SELECT c.id AS id_category, c.`category`, c.head_id AS escalation_by, CONCAT(e.first_name,' ',e.last_name) AS escalation_name FROM cm_category c LEFT JOIN xin_employees e ON e.user_id = c.head_id ORDER BY c.category")->result();
        echo json_encode($type);
    }

    public function e_get_category()
    {
        $cond = "";
        if ($this->input->post('id_type')) {
            $id_type = $this->input->post('id_type');
            $cond = "WHERE type = '$id_type'";
        }
        $type = $this->db->query("SELECT id AS id_category, `category`, `type` AS id_type, sub_type AS id_sub_type FROM cm_category $cond ORDER BY category")->result();
        echo json_encode($type);
    }

    public function get_status()
    {
        $status = $this->db->query("SELECT id AS id_status, `status`, `color` FROM cm_status")->result();
        echo json_encode($status);
    }

    public function get_category_by_type()
    {
        $id_type = $this->input->post('id_type');
        $category = $this->db->query("SELECT id AS id_category, `category`, `type` AS id_type FROM cm_category WHERE `type` = '$id_type'")->result();
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
            cm_object o
            LEFT JOIN cm_category c ON o.category = c.id
            LEFT JOIN cm_type t ON t.id = o.type  WHERE o.`type` = '$id_type'
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
            cm_object o
            LEFT JOIN cm_category c ON o.category = c.id
            LEFT JOIN cm_type t ON t.id = o.type WHERE o.`category` = '$id_category'
        GROUP BY o.id")->result();
        echo json_encode($object);
    }

    public function get_pic()
    {
        $id_category = $this->input->post('id_category');
        $pic =  $this->db->query("SELECT e.user_id AS id_pic, CONCAT( e.first_name, ' ', e.last_name ) AS pic, COUNT(IF(tt.`id_task` IS NOT NULL,1,NULL)) AS ticket FROM `cm_category` t 
        LEFT JOIN xin_employees e ON FIND_IN_SET(e.designation_id,t.designation_id)  
		LEFT JOIN cm_task tt ON FIND_IN_SET(e.user_id,tt.pic) AND tt.`status` = 4
        AND e.is_active = 1 WHERE t.id ='$id_category' AND e.user_id != 1 AND e.is_active = 1
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

        $pic =  $this->db->query("SELECT 
        m.*,
        SUM(IF(verified.id_task IS NOT NULL, 1, 0) + IF(escalation.id_task IS NOT NULL, 1, 0) + IF(pic.id_task IS NOT NULL, 1, 0)) AS ticket
        FROM (
        SELECT
            e.user_id AS id_pic,
            CONCAT( e.first_name, ' ', e.last_name ) AS pic
        FROM
            `cm_category` t
        LEFT JOIN xin_employees e ON FIND_IN_SET( e.designation_id, t.designation_id )
        WHERE e.user_id != 1 AND e.is_active = 1
        GROUP BY e.user_id
        ) AS m
        LEFT JOIN cm_task verified ON verified.verified_by = m.id_pic AND verified.`status` = 1
        LEFT JOIN cm_task escalation ON escalation.escalation_by = m.id_pic AND escalation.`status` = 2
        LEFT JOIN cm_task pic ON FIND_IN_SET(m.id_pic,pic.pic) AND pic.`status` IN (4,8,9)
        GROUP BY m.id_pic
        ORDER BY m.pic")->result();
        echo json_encode($pic);
    }

    public function get_priority()
    {
        $priority = $this->db->query("SELECT id AS id_priority, `priority`, `color` FROM cm_priority ORDER BY id DESC")->result();
        echo json_encode($priority);
    }


    public function get_level()
    {
        $level = $this->db->query("SELECT id AS id_level, `level` FROM cm_level")->result();
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

    function get_log_history_for_konsumen()
    {
        $id_task = $_POST['id_task'];
        $response['log'] = $this->model_main->get_log_history_for_konsumen($id_task);
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
        $category = $this->input->post('category');
        $pic = $this->input->post('pic');
        if ($pic == "all") {
            $cond_pic = "";
        } else {
            $cond_pic = "AND FIND_IN_SET('$pic', t.pic)";
        }

        if ($category == "all") {
            $cond_category = "";
        } else {
            $cond_category = "AND t.id_category = '$category'";
        }
        $response['data'] = $this->db->query("SELECT 
            COALESCE ( SUM( IF ( `status` = 1, 1, 0 )), 0 ) AS waiting,
            COALESCE ( SUM( IF ( `status` = 2, 1, 0 )), 0 ) AS verified,
            COALESCE ( SUM( IF ( `status` = 3, 1, 0 )), 0 ) AS reject,
            COALESCE ( SUM( IF ( `status` = 4, 1, 0 )), 0 ) AS working_on,
            COALESCE ( SUM( IF ( `status` = 5, 1, 0 )), 0 ) AS reject_2,
            COALESCE ( SUM( IF ( `status` = 6, 1, 0 )), 0 ) AS done,
            COALESCE ( SUM( IF ( `status` = 7, 1, 0 )), 0 ) AS unsolved,
            COUNT( id_task ) AS total_task 
        FROM
            `cm_task` t
        WHERE substr(t.created_at,1,10) BETWEEN '$start' AND '$end' $cond_category $cond_pic")->row();
        // $response['team_solver'] = $this->db->query("SELECT COUNT( DISTINCT e.user_id ) AS total_solver FROM `cm_type` t 
        //                                     JOIN xin_employees e ON FIND_IN_SET(e.designation_id,t.designation_id) AND e.is_active = 1")->row();
        // $response['lt_progress'] = $this->db->query("SELECT COALESCE(SUM(TIMESTAMPDIFF( HOUR, t.`start`, CURRENT_DATE )),0) AS lt_hour 
        //                                                     FROM cm_task t WHERE t.`status` = 2 AND substr(t.created_at,1,10) BETWEEN '$start' AND '$end' $cond_category $cond_pic")->row();
        // $response['lt_late'] = $this->db->query("SELECT
        //         CONCAT(t.`due_date`,' 17:00:00') AS due_date,
        //         COALESCE(t.done_date,CURRENT_DATE) AS done_date,
        //         TIMESTAMPDIFF( HOUR, CONCAT(t.`due_date`,' 17:00:00'), COALESCE(t.done_date,CURRENT_DATE) ) diff_deadline,
        //         COUNT(IF(TIMESTAMPDIFF( HOUR, CONCAT(t.`due_date`,' 17:00:00'), COALESCE(t.done_date,CURRENT_DATE) ) < 0,1,NULL)) AS on_time,
        //         COUNT(IF(TIMESTAMPDIFF( HOUR, CONCAT(t.`due_date`,' 17:00:00'), COALESCE(t.done_date,CURRENT_DATE) ) > 0,1,NULL)) AS late,
        //         ROUND(COUNT(IF(TIMESTAMPDIFF( HOUR, CONCAT(t.`due_date`,' 17:00:00'), COALESCE(t.done_date,CURRENT_DATE) ) > 0,1,NULL)) / COUNT(IF(TIMESTAMPDIFF( HOUR, CONCAT(t.`due_date`,' 17:00:00'), COALESCE(t.done_date,CURRENT_DATE) ) < 0,1,NULL)) * 100) AS persen_late
        // FROM cm_task t WHERE t.`status` IN (3) AND substr(t.created_at,1,10) BETWEEN '$start' AND '$end' $cond_pic")->row();
        echo json_encode($response);
    }



    public function save_task()
    {
        $id_requester       = $this->session->userdata('user_id');
        $id_project         = $this->input->post('id_project') ?? '';
        $project            = $this->input->post('project') ?? '';
        $blok               = $this->input->post('blok') ?? '';
        $id_konsumen        = $this->input->post('id_konsumen') ?? '';
        $konsumen           = $this->input->post('konsumen') ?? '';
        $id_category        = $this->input->post('id_category') ?? '';
        $id_status          = 1;
        // if ($id_category == '12') {
        //     $head_request_id    = 1;
        //     $head_request_name  = "Super Administrator";
        // } else {
        if ($this->session->userdata("department_id") == '68') {
            $head_request_id    = 1;
            $head_request_name  = "Super Administrator";
        } else {
            $head_request_id    = $this->input->post('head_requester_id') ?? '';
            $head_request_name  = $this->input->post('head_requester_name') ?? '';
        }
        $escalation_by      = $this->input->post('escalation_by') ?? '';
        $escalation_name    = $this->input->post('escalation_name') ?? '';
        $task               = $this->input->post('task') ?? '';
        $description        = $this->input->post('description') ?? '';
        $id_task            = $this->model_main->generate_id_task();
        $link               = $this->input->post('link') ?? '';
        $pekerjaan               = $this->input->post('pekerjaan') ?? '';
        $sub_pekerjaan               = $this->input->post('sub_pekerjaan') ?? '';
        $detail_pekerjaan               = implode(",",$this->input->post('detail_pekerjaan') ?? '');

        // if (!empty($_FILES['file_complaints']['name'])) {
        //     // Proses unggah file
        //     $config['upload_path']   = './uploads/complaints/';
        //     // $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
        //     $config['allowed_types'] = '*';
        //     $new_name = $id_task . '_' . time();
        //     $config['file_name']     = $new_name;
        //     $this->load->library('upload', $config);

        //     if (!$this->upload->do_upload('file_complaints')) {
        //         $response['error'] = array('error' => $this->upload->display_errors());
        //     } else {
        //         $data = array('upload_data' => $this->upload->data());
        //         $file_name = $data['upload_data']['file_name'];
        //     }
        // } else {
        //     $file_name = "";
        // }

        $data = [
            'id_task'           => $id_task,
            'id_project'        => $id_project,
            'project'           => $project,
            'blok'              => $blok,
            'konsumen'          => $konsumen,
            'id_category'       => $id_category,
            'status'            => $id_status,
            'task'              => $task,
            'description'       => $description,
            'created_at'        => date("Y-m-d H:i:s"),
            'created_by'        => $id_requester,
            'progress'          => 0,
            // 'file'              => $file_name,
            'link'              => $link,
            'verified_by'       => $head_request_id,
            'verified_name'     => $head_request_name,
            'escalation_by'     => $escalation_by,
            'escalation_name'   => $escalation_name,
            'id_pekerjaan'=>$pekerjaan,
            'id_sub_pekerjaan'=>$sub_pekerjaan,
            'id_detail_pekerjaan'=>$detail_pekerjaan,
        ];

        if ($id_konsumen != '') {
            $data['id_konsumen'] = $id_konsumen;
        }

        $save_task = $this->db->insert('cm_task', $data);

        $status_attach = [];
        if (isset($_POST['file'])) {
            $attach = [];
            for ($i = 0; $i < count($_POST['file']); $i++) {
                $attach[$i] = array(
                    'id_task' => $id_task,
                    'attachment' => $_POST['file'][$i],
                    'size' => $_POST['size'][$i],
                    'ext' => $_POST['ext'][$i],
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $id_requester,
                );
                $status_attach[$i] = $this->db->insert('cm_task_attach', $attach[$i]);
            }
        }


        $data_history = [
            'id_task' => $id_task,
            'progress' => 0,
            'status' => $id_status,
            'status_before' => $id_status,
            'note' => 'Complaints Created',
            'created_at' => date('Y-m-d H:i_s'),
            'created_by' => $id_requester ?? $this->session->userdata('user_id')
        ];
        $save_history = $this->db->insert('cm_task_history', $data_history);

        $this->send_cm_notif_to_head_pic($id_task);

        $response['id_task']    = $id_task;
        $response['save_task']  = $save_task;
        $response['head_request_name']  = $head_request_name;
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

            $get_old_status = $this->db->query("SELECT `status` FROM cm_task WHERE id_task = '$id_task'")->row();
            $data_history = [
                'id_task'       => $id_task,
                'progress'      => $progress,
                'status'        => $id_status,
                'status_before' => $get_old_status->status,
                'note'          => $note,
                'created_at'    => date('Y-m-d H:i_s'),
                'created_by'    => $this->session->userdata('user_id')
            ];
            $save_history = $this->db->insert('cm_task_history', $data_history);
            $data = [
                'status'        => $id_status,
                'progress'      => $progress,
                'note'          => $note,
                'priority'      => $id_priority,
                'level'         => $id_level,
            ];

            if ($get_old_status->status == 1) {
                $data['due_date'] = $due_date;
                $data['start']    = $start;
                $data['end']      = $end;
            }

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


            if ($get_old_status->status == 1) {
                $data['pic'] = $id_pic;
            }
            if ($id_status == 3 || $id_status == 4) {
                $data['done_date'] = date("Y-m-d H:i:s");
            }
        }

        echo json_encode($update_task);
    }


    public function update_verifikasi()
    {
        $id_task = $this->input->post('id_task') ?? '';
        $update_task = "";
        if ($id_task != "") {
            $id_status      = strip_tags($this->input->post('id_status')) ?? '';
            $id_priority    = strip_tags($this->input->post('id_priority')) ?? '';
            $verified_note  = strip_tags($this->input->post('verified_note')) ?? '';

            $get_old_status = $this->db->query("SELECT `status` FROM cm_task WHERE id_task = '$id_task'")->row();
            $get_task = $this->model_main->get_cm_notif_verify($id_task);
            $data_history = [
                'id_task'       => $id_task,
                'status'        => $id_status,
                'status_before' => $get_old_status->status,
                'note'          => $verified_note,
                'created_at'    => date('Y-m-d H:i_s'),
                'created_by'    => $this->session->userdata('user_id')
            ];
            $save_history = $this->db->insert('cm_task_history', $data_history);
            $data = [
                'status'        => $id_status,
                'verified_by'   => $this->session->userdata('user_id'),
                'verified_name' => $this->session->userdata('nama'),
                'verified_at'   => date("Y-m-d H:i:s"),
                'verified_note' => $verified_note,
                'priority'      => $id_priority,
            ];

            $update_task = $this->db->where('id_task', $id_task)->update('cm_task', $data);

            // jika status verified / reject kirim notifikasi hasil verifikasi ke requester
            if ($get_old_status->status == 1 && in_array($id_status, [2, 3]) == 1) {
                $this->send_cm_notif_result_verify_to_requester($id_task);
            }

            // jika status verified kirim notifikasi hasil request eskalasi ke head eskalasi
            if ($get_old_status->status == 1 && in_array($id_status, [2]) == 1) {
                $this->send_cm_notif_result_verify_to_escalation($id_task);
            }
            $response['update_verifikasi'] = $update_task;
            $response['status'] = $id_status;
            $response['requester_name'] = $get_task->requester_name;
            $response['head_pic_name'] = $this->session->userdata('nama');
            $response['escalation_name'] = $get_task->escalation_name;
        }

        echo json_encode($response);
    }

    public function update_eskalasi()
    {
        $id_task = $this->input->post('id_task') ?? '';
        $update_task = "";
        if ($id_task != "") {
            $id_status          = strip_tags($this->input->post('id_status')) ?? '';
            $id_priority        = strip_tags($this->input->post('id_priority')) ?? '';
            $id_level           = strip_tags($this->input->post('id_level')) ?? '';
            $id_pic             = strip_tags($this->input->post('id_pic')) ?? '';
            $escalation_note   = strip_tags($this->input->post('escalation_note')) ?? '';
            $start              = strip_tags($this->input->post('start_timeline')) ?? '';
            $end                = strip_tags($this->input->post('end_timeline')) ?? '';
            $due_date           = strip_tags($this->input->post('due_date')) ?? '';

            $get_old_status = $this->db->query("SELECT `status` FROM cm_task WHERE id_task = '$id_task'")->row();
            $get_task = $this->model_main->get_cm_notif_verify($id_task);
            $data_history = [
                'id_task'       => $id_task,
                'status'        => $id_status,
                'status_before' => $get_old_status->status,
                'note'          => $escalation_note,
                'created_at'    => date('Y-m-d H:i_s'),
                'created_by'    => $this->session->userdata('user_id')
            ];
            $save_history = $this->db->insert('cm_task_history', $data_history);
            $data = [
                'status'            => $id_status,
                'escalation_by'     => $this->session->userdata('user_id'),
                'escalation_name'   => $this->session->userdata('nama'),
                'escalation_at'     => date("Y-m-d H:i:s"),
                'escalation_note'   => $escalation_note,
                'priority'          => $id_priority,
                'level'             => $id_level,
                'pic'               => $id_pic,
                'due_date'          => $due_date,
                'start'             => $start,
                'end'               => $end,
            ];

            $update_task = $this->db->where('id_task', $id_task)->update('cm_task', $data);
            // jika status working on / reject level 2 kirim notifikasi hasil eskalasi ke requester
            if ($get_old_status->status == 2 && in_array($id_status, [4, 5]) == 1) {
                $this->send_cm_notif_working_on_to_requester($id_task);
            }

            // jika status working on kirim notifikasi hasil eskalasi ke pic terkait
            if ($get_old_status->status == 2 && in_array($id_status, [4]) == 1) {
                $this->send_cm_notif_escalation_to_pic($id_task);
            }

            $response['update_eskalasi'] = $update_task;
            $response['status'] = $id_status;
            $response['requester_name'] = $get_task->requester_name;
            $response['head_pic_name'] = $this->session->userdata('nama');
            $response['escalation_name'] = $get_task->escalation_name;
            $response['pic_name'] = $get_task->pic_name;
        }

        echo json_encode($response);
    }


    public function update_pengerjaan()
    {
        $id_task = $this->input->post('id_task') ?? '';
        $update_task = "";
        if ($id_task != "") {
            $id_status          = strip_tags($this->input->post('id_status')) ?? '';
            $progress           = strip_tags($this->input->post('progress')) ?? '';
            $pic_note           = strip_tags($this->input->post('pic_note')) ?? '';
            $get_old_status     = $this->db->query("SELECT `status`, COALESCE(reschedule,0) AS reschedule FROM cm_task WHERE id_task = '$id_task'")->row();
            $get_task           = $this->model_main->get_cm_notif_verify($id_task);
            $data_history = [
                'id_task'       => $id_task,
                'status'        => $id_status,
                'status_before' => $get_old_status->status,
                'note'          => $pic_note,
                'created_at'    => date('Y-m-d H:i_s'),
                'created_by'    => $this->session->userdata('user_id')
            ];
            $save_history = $this->db->insert('cm_task_history', $data_history);
            $data = [
                'status'            => $id_status,
                'progress'          => $progress,
                'pic_note'          => $pic_note,
            ];

            // status done
            $status_done = ['6', '7'];
            if (in_array($id_status, $status_done) == 1) {
                $data['done_date'] = date("Y-m-d H:i:s");
            }

            // jika reschedule
            $status_reschedule = ['8', '9'];
            if (in_array($id_status, $status_reschedule) == 1) {
                $start              = strip_tags($this->input->post('start_timeline')) ?? '';
                $end                = strip_tags($this->input->post('end_timeline')) ?? '';
                $due_date           = strip_tags($this->input->post('due_date')) ?? '';
                $data['reschedule'] = $get_old_status->reschedule + 1;
                $data['due_date']   = $due_date;
                $data['start']      = $start;
                $data['end']        = $end;
            }

            $update_task = $this->db->where('id_task', $id_task)->update('cm_task', $data);
            if ($get_old_status->status == 4 && in_array($id_status, [6, 7]) == 1) {
                $this->send_notif_done($id_task);
            }

            if (in_array($id_status, [8, 9]) == 1) {
                $this->send_notif_reschedule($id_task);
            }

            $response['update_eskalasi'] = $update_task;
            $response['status'] = $id_status;
            $response['requester_name'] = $get_task->requester_name;
            $response['head_pic_name'] = $get_task->head_pic_name;
            $response['escalation_name'] = $get_task->escalation_name;
            $response['pic_name'] = $get_task->pic_name;
        }

        echo json_encode($response);
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
            $save_comment = $this->db->insert('cm_comment', $data_history);
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
            $save_reply = $this->db->insert('cm_comment', $data_history);
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
            $config['upload_path']   = './uploads/complaints/';
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
            $data['insert'] = $this->db->insert('cm_task_attach', $data_upload);
        } else {
            $file['data'] = $_FILES["file"]["error"];
            $data['file'] = $file;
            $data['insert'] = null;
        }

        echo json_encode($data);
    }

    public function send_manual($id_task)
    {
        $complaints = $this->model_main->get_cm_notif_verify($id_task);
        $msg = "🚨 Hey there!

There is a new complain from *" . trim(ucwords($complaints->requester_name)) . "* for you, please verify immediately.

📋 Category : *" . trim(ucwords($complaints->category)) . "*
🏚️ Project : *" . trim(ucwords($complaints->project)) . "*
📭 Blok : *" . trim(ucwords($complaints->blok)) . "*
🙍‍♂️ GM : *" . trim(ucwords($complaints->head_pic_name)) . "*
🙍‍♂️ SPV : *" . trim(ucwords($complaints->spv_name)) . "*
🗣️ Konsumen : *" . trim(ucwords($complaints->konsumen)) . "*
📝 Title : *" . trim(ucwords($complaints->task)) . "*
📄 Description : *" . trim(strip_tags(str_replace('<', ' <', $complaints->description))) . "*

link review :
https://trusmiverse.com/apps/my-complaints/" . $complaints->id_task . "
            
" . $complaints->created_at . "";
        $this->whatsapp_lib->send_single_msg('rsp', '085324409384', $msg);
    }



    public function send_cm_notif_to_head_pic($id_task)
    {
        $complaints = $this->model_main->get_cm_notif_verify($id_task);
        $msg = "🚨 Hey there!

There is a new complain from *" . trim(ucwords($complaints->requester_name)) . "* for you, please verify immediately.

📋 Category : *" . trim(ucwords($complaints->category)) . "*
🏚️ Project : *" . trim(ucwords($complaints->project)) . "*
📭 Blok : *" . trim(ucwords($complaints->blok)) . "*
🙍‍♂️ GM : *" . trim(ucwords($complaints->head_pic_name)) . "*
🙍‍♂️ SPV : *" . trim(ucwords($complaints->spv_name)) . "*
🗣️ Konsumen : *" . trim(ucwords($complaints->konsumen)) . "*
📝 Title : *" . trim(ucwords($complaints->task)) . "*
📄 Description : *" . trim(strip_tags(str_replace('<', ' <', $complaints->description))) . "*

link review :
https://trusmiverse.com/apps/my-complaints/" . $complaints->id_task . "
            
" . $complaints->created_at . "";
        // $this->whatsapp_lib->send_single_msg('rsp', '6289656108701', $msg);
        $this->whatsapp_lib->send_single_msg('rsp', $complaints->head_pic_contact_no, $msg);
        $this->whatsapp_lib->send_single_msg('rsp', '085324409384', $msg);
    }


    public function send_cm_notif_result_verify_to_escalation($id_task)
    {
        $complaints = $this->model_main->get_cm_notif_verify($id_task);
        $msg = "🚨 Hey there!

There is a new complain for you, please escalate immediately.

🗣️ Requested By : *" . trim(ucwords($complaints->requester_name)) . "*
✅ Verified By : *" . trim(ucwords($complaints->head_pic_name)) . "*
📋 Category : *" . trim(ucwords($complaints->category)) . "*
🏚️ Project : *" . trim(ucwords($complaints->project)) . "*
📭 Blok : *" . trim(ucwords($complaints->blok)) . "*
🙍‍♂️ GM : *" . trim(ucwords($complaints->head_pic_name)) . "*
🙍‍♂️ SPV : *" . trim(ucwords($complaints->spv_name)) . "*
🗣️ Konsumen : *" . trim(ucwords($complaints->konsumen)) . "*
📝 Title : *" . trim(ucwords($complaints->task)) . "*
📄 Description : *" . trim(strip_tags(str_replace('<', ' <', $complaints->description))) . "*

link review :
https://trusmiverse.com/apps/my-complaints/" . $complaints->id_task . "
            
" . $complaints->created_at . "";
        $this->whatsapp_lib->send_single_msg('rsp', $complaints->escalation_contact_no, $msg);
        $this->whatsapp_lib->send_single_msg('rsp', '085324409384', $msg); // aris
        // $this->whatsapp_lib->send_single_msg('rsp', '6289656108701', $msg); // complaint testing
    }


    public function send_cm_notif_result_verify_to_requester($id_task)
    {
        $complaints = $this->model_main->get_cm_notif_verify($id_task);
        $update_msg = "";
        if ($complaints->id_status == 2) {
            $update_msg = "Your complaint has been *verified* by *" . trim(ucwords($complaints->head_pic_name)) . "* and forwarded to *" . trim(ucwords($complaints->escalation_name)) . "* for *escalation*";
        }

        if ($complaints->id_status == 3) {
            $update_msg = "Sorry *" . trim(ucwords($complaints->requester_name)) . "*, your complaints is rejected by *" . trim(ucwords($complaints->head_pic_name)) . "*";
        }

        $msg = "🚨 Hey, there is an update regarding your complaint!

" . $update_msg . "

📋 Category : *" . trim(ucwords($complaints->category)) . "*
🏚️ Project : *" . trim(ucwords($complaints->project)) . "*
📭 Blok : *" . trim(ucwords($complaints->blok)) . "*
🗣️ Konsumen : *" . trim(ucwords($complaints->konsumen)) . "*
📝 Title : *" . trim(ucwords($complaints->task)) . "*
📄 Description : *" . trim(strip_tags(str_replace('<', ' <', $complaints->description))) . "*
💬 Verified Note : *" . trim(strip_tags(str_replace('<', ' <', $complaints->verified_note))) . "*

link review :
https://trusmiverse.com/apps/customer-complaints/" . $complaints->id_task . "
            
" . $complaints->created_at . "";
        $this->whatsapp_lib->send_single_msg('rsp', $complaints->requester_contact_no, $msg);
        $this->whatsapp_lib->send_single_msg('rsp', '085324409384', $msg); // complain testing
        // $this->whatsapp_lib->send_single_msg('rsp', '6289656108701', $msg); // complain testing
    }

    public function send_cm_notif_working_on_to_requester($id_task)
    {
        $complaints = $this->model_main->get_cm_notif_verify($id_task);
        $update_msg = "";
        if ($complaints->id_status == 4) {
            $update_msg = "Your complaint has been *escalated* by *" . trim(ucwords($complaints->escalation_name)) . "* and forwarded to *" . trim(ucwords($complaints->pic_name)) . "* to be *resolved*";
        }

        if ($complaints->id_status == 5) {
            $update_msg = "Sorry *" . trim(ucwords($complaints->requester_name)) . "*, your complaints is rejected by *" . trim(ucwords($complaints->escalation_name)) . "*";
        }

        $msg = "🚨 Hello *" . trim(ucwords($complaints->requester_name)) . "*, there is an update regarding your complaint!

" . $update_msg . "

📋 Category : *" . trim(ucwords($complaints->category)) . "*
🏚️ Project : *" . trim(ucwords($complaints->project)) . "*
📭 Blok : *" . trim(ucwords($complaints->blok)) . "*
🗣️ Konsumen : *" . trim(ucwords($complaints->konsumen)) . "*
📝 Title : *" . trim(ucwords($complaints->task)) . "*
📄 Description : *" . trim(strip_tags(str_replace('<', ' <', $complaints->description))) . "*


✅ Verified By : *" . trim(ucwords($complaints->head_pic_name)) . "*
📆 Verified At : *" . trim(ucwords($complaints->verified_at)) . "*
📄 Verification Notes : *" . trim(strip_tags(str_replace('<', ' <', $complaints->verified_note))) . "*

✅ Escalated By : *" . trim(ucwords($complaints->escalation_name)) . "*
📆 Escalated At : *" . trim(ucwords($complaints->escalation_at)) . "*
🗂️ Priority : *" . trim(ucwords($complaints->priority)) . "*
📆 Timeline : *" . trim(ucwords($complaints->start_timeline)) . "* s/d *" . trim(ucwords($complaints->end_timeline)) . "*
📄 Escalation Notes : *" . trim(strip_tags(str_replace('<', ' <', $complaints->escalation_note))) . "*

link review :
https://trusmiverse.com/apps/customer-complaints/" . $complaints->id_task . "
            
" . $complaints->created_at . "";

        $this->whatsapp_lib->send_single_msg('rsp', $complaints->requester_contact_no, $msg);
        $this->whatsapp_lib->send_single_msg('rsp', '085324409384', $msg);
        // $this->whatsapp_lib->send_single_msg('rsp', '6289656108701', $msg);
    }

    public function send_cm_notif_escalation_to_pic($id_task)
    {
        $complaints = $this->model_main->get_cm_notif_pic($id_task);

        foreach ($complaints as $row) {
            $msg = "🚨 Hello, *" . trim(ucwords($row->pic_name)) . "*!

There is a new complain for you, please *resolve* immediately.

🗣️ Requested By : *" . trim(ucwords($row->requester_name)) . "*
📋 Category : *" . trim(ucwords($row->category)) . "*
🏚️ Project : *" . trim(ucwords($row->project)) . "*
📭 Blok : *" . trim(ucwords($row->blok)) . "*
🗣️ Konsumen : *" . trim(ucwords($row->konsumen)) . "*
📝 Title : *" . trim(ucwords($row->task)) . "*
📄 Description : *" . trim(strip_tags(str_replace('<', ' <', $row->description))) . "*

✅ Verified By : *" . trim(ucwords($row->head_pic_name)) . "*
📆 Verified At : *" . trim(ucwords($row->verified_at)) . "*
📄 Verification Notes : *" . trim(strip_tags(str_replace('<', ' <', $row->verified_note))) . "*

✅ Escalated By : *" . trim(ucwords($row->escalation_name)) . "*
📆 Escalated At : *" . trim(ucwords($row->escalation_at)) . "*
🗂️ Priority : *" . trim(ucwords($row->priority)) . "*
📆 Timeline : *" . trim(ucwords($row->start_timeline)) . "* s/d *" . trim(ucwords($row->end_timeline)) . "*
📄 Escalation Notes : *" . trim(strip_tags(str_replace('<', ' <', $row->escalation_note))) . "*

link review :
https://trusmiverse.com/apps/my-complaints/" . $row->id_task . "
            
" . $row->created_at . "";
            $this->whatsapp_lib->send_single_msg('rsp', $row->pic_contact_no, $msg);
            // $this->whatsapp_lib->send_single_msg('rsp', '6289656108701', $msg);
        }
    }

    public function send_notif_done($id_task)
    {
        $complaints = $this->model_main->get_cm_notif_verify($id_task);
        $update_msg = "";
        if ($complaints->id_status == 6) {
            $update_msg = "Your complaint has been *Done* by " . trim(ucwords($complaints->pic_name)) . "";
            $update_msg_to_pic = "Complaints from *" . trim(ucwords($complaints->requester_name)) . "*  has been *Done* by " . trim(ucwords($complaints->pic_name)) . "";
        }

        if ($complaints->id_status == 7) {
            $update_msg = "Sorry *" . trim(ucwords($complaints->requester_name)) . "*, your complaints is *Unsolved*";
            $update_msg_to_pic = "Complaints is *Unsolved*";
        }

        $msg_to_requester = "🚨 Hello *" . trim(ucwords($complaints->requester_name)) . "*, there is an update regarding your complaint!

" . $update_msg . "

📋 Category : *" . trim(ucwords($complaints->category)) . "*
🏚️ Project : *" . trim(ucwords($complaints->project)) . "*
📭 Blok : *" . trim(ucwords($complaints->blok)) . "*
🗣️ Konsumen : *" . trim(ucwords($complaints->konsumen)) . "*
📝 Title : *" . trim(ucwords($complaints->task)) . "*
📄 Description : *" . trim(strip_tags(str_replace('<', ' <', $complaints->description))) . "*

✅ Verified By : *" . trim(ucwords($complaints->head_pic_name)) . "*
📆 Verified At : *" . trim(ucwords($complaints->verified_at)) . "*
📄 Verification Notes : *" . trim(strip_tags(str_replace('<', ' <', $complaints->verified_note))) . "*

✅ Escalated By : *" . trim(ucwords($complaints->escalation_name)) . "*
📆 Escalated At : *" . trim(ucwords($complaints->escalation_at)) . "*
📄 Escalation Notes : *" . trim(strip_tags(str_replace('<', ' <', $complaints->escalation_note))) . "*

🗂️ Priority : *" . trim(ucwords($complaints->priority)) . "*
📆 Timeline : *" . trim(ucwords($complaints->start_timeline)) . "* s/d *" . trim(ucwords($complaints->end_timeline)) . "*
✅ Pic By : *" . trim(ucwords($complaints->pic_name)) . "*
📆 Pic At : *" . trim(ucwords($complaints->done_date)) . "*
📄 Pic Notes : *" . trim(strip_tags(str_replace('<', ' <', $complaints->pic_note))) . "*

link review :
https://trusmiverse.com/apps/customer-complaints/" . $complaints->id_task . "
            
" . $complaints->created_at . "";


        $msg_to_head_pic = "🚨 There is an update regarding *" . trim(ucwords($complaints->requester_name)) . "* complaint!

" . $update_msg_to_pic . "

📋 Category : *" . trim(ucwords($complaints->category)) . "*
🏚️ Project : *" . trim(ucwords($complaints->project)) . "*
📭 Blok : *" . trim(ucwords($complaints->blok)) . "*
🗣️ Konsumen : *" . trim(ucwords($complaints->konsumen)) . "*
📝 Title : *" . trim(ucwords($complaints->task)) . "*
📄 Description : *" . trim(strip_tags(str_replace('<', ' <', $complaints->description))) . "*

✅ Verified By : *" . trim(ucwords($complaints->head_pic_name)) . "*
📆 Verified At : *" . trim(ucwords($complaints->verified_at)) . "*
📄 Verification Notes : *" . trim(strip_tags(str_replace('<', ' <', $complaints->verified_note))) . "*

✅ Escalated By : *" . trim(ucwords($complaints->escalation_name)) . "*
📆 Escalated At : *" . trim(ucwords($complaints->escalation_at)) . "*
📄 Escalation Notes : *" . trim(strip_tags(str_replace('<', ' <', $complaints->escalation_note))) . "*

🗂️ Priority : *" . trim(ucwords($complaints->priority)) . "*
📆 Timeline : *" . trim(ucwords($complaints->start_timeline)) . "* s/d *" . trim(ucwords($complaints->end_timeline)) . "*
✅ Pic By : *" . trim(ucwords($complaints->pic_name)) . "*
📆 Pic At : *" . trim(ucwords($complaints->done_date)) . "*
📄 Pic Notes : *" . trim(strip_tags(str_replace('<', ' <', $complaints->pic_note))) . "*

link review :
https://trusmiverse.com/apps/my-complaints/" . $complaints->id_task . "
            
" . $complaints->created_at . "";

        // head pic or escalation by
        $this->whatsapp_lib->send_single_msg('rsp', '085324409384', $msg_to_head_pic);
        $this->whatsapp_lib->send_single_msg('rsp', $complaints->escalation_contact_no, $msg_to_head_pic);
        // $this->whatsapp_lib->send_single_msg('rsp', '6289656108701', $msg_to_head_pic);

        // head requester or verified by
        $this->whatsapp_lib->send_single_msg('rsp', '085324409384', $msg_to_head_pic);
        $this->whatsapp_lib->send_single_msg('rsp', $complaints->head_pic_contact_no, $msg_to_head_pic);
        // $this->whatsapp_lib->send_single_msg('rsp', '6289656108701', $msg_to_head_pic);
        // requester or created by or konsumen
        $this->whatsapp_lib->send_single_msg('rsp', '085324409384', $msg_to_requester);
        $this->whatsapp_lib->send_single_msg('rsp', $complaints->requester_contact_no, $msg_to_requester);
        // $this->whatsapp_lib->send_single_msg('rsp', '6289656108701', $msg_to_requester);
    }

    public function send_notif_reschedule($id_task)
    {
        $complaints = $this->model_main->get_cm_notif_verify($id_task);
        $update_msg = "";
        if ($complaints->id_status == 8) {
            $update_msg = "Your complaint has been *Rescheduled* by " . trim(ucwords($complaints->pic_name)) . "";
            $update_msg_to_pic = "Complaints from *" . trim(ucwords($complaints->requester_name)) . "*  has been *Rescheduled* by " . trim(ucwords($complaints->pic_name)) . "";
        }

        if ($complaints->id_status == 9) {
            $update_msg = "Your complaint has been *Rescheduled 2* by " . trim(ucwords($complaints->pic_name)) . "";
            $update_msg_to_pic = "Complaints from *" . trim(ucwords($complaints->requester_name)) . "*  has been *Rescheduled 2* by " . trim(ucwords($complaints->pic_name)) . "";
        }

        $msg_to_requester = "🚨 Hello *" . trim(ucwords($complaints->requester_name)) . "*, there is an update regarding your complaint!

" . $update_msg . "

📋 Category : *" . trim(ucwords($complaints->category)) . "*
🏚️ Project : *" . trim(ucwords($complaints->project)) . "*
📭 Blok : *" . trim(ucwords($complaints->blok)) . "*
🗣️ Konsumen : *" . trim(ucwords($complaints->konsumen)) . "*
📝 Title : *" . trim(ucwords($complaints->task)) . "*
📄 Description : *" . trim(strip_tags(str_replace('<', ' <', $complaints->description))) . "*

✅ Verified By : *" . trim(ucwords($complaints->head_pic_name)) . "*
📆 Verified At : *" . trim(ucwords($complaints->verified_at)) . "*
📄 Verification Notes : *" . trim(strip_tags(str_replace('<', ' <', $complaints->verified_note))) . "*

✅ Escalated By : *" . trim(ucwords($complaints->escalation_name)) . "*
📆 Escalated At : *" . trim(ucwords($complaints->escalation_at)) . "*
📄 Escalation Notes : *" . trim(strip_tags(str_replace('<', ' <', $complaints->escalation_note))) . "*

🗂️ Priority : *" . trim(ucwords($complaints->priority)) . "*
📆 Timeline : *" . trim(ucwords($complaints->start_timeline)) . "* s/d *" . trim(ucwords($complaints->end_timeline)) . "*
✅ Pic By : *" . trim(ucwords($complaints->pic_name)) . "*
📆 Done Date : *" . trim(ucwords($complaints->done_date)) . "*
📄 Pic Notes : *" . trim(strip_tags(str_replace('<', ' <', $complaints->pic_note))) . "*

link review :
https://trusmiverse.com/apps/customer-complaints/" . $complaints->id_task . "
            
" . $complaints->created_at . "";


        $msg_to_head_pic = "🚨 There is an update regarding *" . trim(ucwords($complaints->requester_name)) . "* complaint!

" . $update_msg_to_pic . "

📋 Category : *" . trim(ucwords($complaints->category)) . "*
🏚️ Project : *" . trim(ucwords($complaints->project)) . "*
📭 Blok : *" . trim(ucwords($complaints->blok)) . "*
🗣️ Konsumen : *" . trim(ucwords($complaints->konsumen)) . "*
📝 Title : *" . trim(ucwords($complaints->task)) . "*
📄 Description : *" . trim(strip_tags(str_replace('<', ' <', $complaints->description))) . "*

✅ Verified By : *" . trim(ucwords($complaints->head_pic_name)) . "*
📆 Verified At : *" . trim(ucwords($complaints->verified_at)) . "*
📄 Verification Notes : *" . trim(strip_tags(str_replace('<', ' <', $complaints->verified_note))) . "*

✅ Escalated By : *" . trim(ucwords($complaints->escalation_name)) . "*
📆 Escalated At : *" . trim(ucwords($complaints->escalation_at)) . "*
📄 Escalation Notes : *" . trim(strip_tags(str_replace('<', ' <', $complaints->escalation_note))) . "*

🗂️ Priority : *" . trim(ucwords($complaints->priority)) . "*
📆 Timeline : *" . trim(ucwords($complaints->start_timeline)) . "* s/d *" . trim(ucwords($complaints->end_timeline)) . "*
✅ Pic By : *" . trim(ucwords($complaints->pic_name)) . "*
📆 Done Date : *" . trim(ucwords($complaints->done_date)) . "*
📄 Pic Notes : *" . trim(strip_tags(str_replace('<', ' <', $complaints->pic_note))) . "*

link review :
https://trusmiverse.com/apps/my-complaints/" . $complaints->id_task . "
            
" . $complaints->created_at . "";

        // head pic or escalation by
        $this->whatsapp_lib->send_single_msg('rsp', '085324409384', $msg_to_head_pic);
        $this->whatsapp_lib->send_single_msg('rsp', $complaints->escalation_contact_no, $msg_to_head_pic);
        // $this->whatsapp_lib->send_single_msg('rsp', '6289656108701', $msg_to_head_pic);
        // head requester or verified by
        $this->whatsapp_lib->send_single_msg('rsp', '085324409384', $msg_to_head_pic);
        $this->whatsapp_lib->send_single_msg('rsp', $complaints->head_pic_contact_no, $msg_to_head_pic);
        // $this->whatsapp_lib->send_single_msg('rsp', '6289656108701', $msg_to_head_pic);
        // requester or created by or konsumen
        $this->whatsapp_lib->send_single_msg('rsp', '085324409384', $msg_to_requester);
        $this->whatsapp_lib->send_single_msg('rsp', $complaints->requester_contact_no, $msg_to_requester);
        // $this->whatsapp_lib->send_single_msg('rsp', '6289656108701', $msg_to_requester);
    }

    public function resend_notif_request()
    {
        //         $id_task = $this->input->post('id_task');
        //         $ticket = $this->model_main->get_cm_request($id_task);
        //         foreach ($ticket as $team) {
        //             $team_name[] = $team->employee_name;
        //         }
        //         $pic = trim(implode(", ", $team_name));
        //         foreach ($ticket as $row) {
        //             $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
        //             $data_text = array(
        //                 "channelID" => "2225082380", // Channel Trusmi Group
        //                 // "phone" => '6285324409384',
        //                 "phone" => $row->contact_no,
        //                 "messageType" => "text",
        //                 "body" => "🚨 Hey there!

        // There is a new request from *" . trim(ucwords($row->requester_name)) . "* for you, please review immediately.

        // 🏷️ Type : *" . trim(ucwords($row->type)) . "*
        // 📋 Category : *" . trim(ucwords($row->category)) . "*
        // 📝 Title : *" . trim(ucwords($row->task)) . "*
        // 💣 Priority : *" . trim(ucwords($row->priority)) . "*
        // 👤 PIC : *" . trim(ucwords($pic)) . "* 
        // 📄 Description : *" . trim(strip_tags($row->description)) . "*

        // link review :
        // https://trusmiverse.com/apps/my-complaints/" . $row->id_task . "

        // " . $row->created_at . "",
        //                 "withCase" => true
        //             );

        //             $options_text = array(
        //                 'http' => array(
        //                     "method"  => 'POST',
        //                     "content" => json_encode($data_text),
        //                     "header" =>  "Content-Type: application/json\r\n" .
        //                         "Accept: application/json\r\n" .
        //                         "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
        //                 )
        //             );
        //             $context_text  = stream_context_create($options_text);
        //             $result_text = file_get_contents($url, false, $context_text);
        //             $response['text'][] = json_decode($result_text);
        //         }

        //         $response['status'] = true;
        //         echo json_encode($response);
    }


    public function check_lsa()
    {
        // layanan -> waktu pelayanan ->  prioritas -> waktu eskalasi -> level -> waktu eksekusi
        $hour = date("H");
        $is_work_hour = (int) $hour <= 20 && (int) $hour >= 8 ? true : false;
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
            MIN(t.`end`) AS `end` 
        FROM
            (
            SELECT
                e.user_id,
                MAX( t.`end` ) AS max_end_timeline 
            FROM
                xin_employees e
                LEFT JOIN cm_task t ON FIND_IN_SET( e.user_id, t.pic ) 
                AND `status` = 2 
            WHERE
                FIND_IN_SET( e.`user_id`, '$id_pic' ) 
            GROUP BY
                e.user_id 
            ) AS x
            LEFT JOIN cm_task t ON t.end = x.max_end_timeline";
        $get_last_timeline = $this->db->query($sql)->row();
        if ($get_last_timeline) {
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

    function upload_file_complaint()
    {
        if (!empty($_FILES)) {
            $uploadDir = './uploads/complaints/';
            $fileName = basename($_FILES['file']['name']);
            $uploadFilePath = $uploadDir . $fileName;

            //upload file to server
            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath)) {
                $data['data'] = $fileName;
                $data['size'] = $_FILES['file']['size'];
                $data['ext'] = pathinfo($fileName, PATHINFO_EXTENSION);
            } else {
                $data['data'] = $_FILES["file"]["error"];
            }
        } else {
            $data['data'] = $_FILES["file"]["error"];
        }

        echo json_encode($data);
    }

    function remove_file_complaint()
    {
        $uploadDir = './uploads/complaints/';
        $fileName = $uploadDir . $_POST['name'];
        $remove = unlink($fileName);
        $data['filename'] = $fileName;
        $data['remove'] = $remove;
        echo json_encode($data);
    }
    function get_pekerjaan($id_project){
        $data = $this->db->get_where('m_pekerjaan');
        echo json_encode($data);
    }
    function get_sub_pekerjaan($pekerjaan){
        $data = $this->db->get_where('m_sub_pekerjaan',['id_pekerjaan'=>$pekerjaan])->result();
        echo json_encode($data);
    }
    function get_det_pekerjaan($id_sub_pekerjaan){
        $data = $this->db->get_where('t_detail_pekerjaan',['id_sub_pekerjaan'=>$id_sub_pekerjaan])->result();
        echo json_encode($data);
    }
}
