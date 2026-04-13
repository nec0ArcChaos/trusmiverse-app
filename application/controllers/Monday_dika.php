<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monday extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('whatsapp_lib');
        $this->load->model("model_monday");
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    function kokatto_login()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://portal.kokatto.com/api/v1/identity/auth/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "username": "8435api@kokatto.com",
                "password": "Trusmi2023"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $responseGetToken = curl_exec($curl);
        curl_close($curl);
        echo $responseGetToken;
        $myJSON = json_decode($responseGetToken);
        $token = $myJSON->token;
        $refresh_token = $myJSON->refreshToken;
    }


    function kokatto_get_token()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://portal.kokatto.com/api/v1/identity/auth/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "username": "8435api@kokatto.com",
                "password": "Trusmi2023"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $responseGetToken = curl_exec($curl);
        curl_close($curl);
        $myJSON = json_decode($responseGetToken);
        return $myJSON->token ?? "";
    }


    function kokatto_refresh()
    {
        // refresh Token
        $token = $this->kokatto_get_token();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://portal.kokatto.com/api/v1/identity/auth/refreshAccessToken',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "refreshToken": ""
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            ),
        ));
        $responseRefreshToken = curl_exec($curl);
        curl_close($curl);
    }

    function kokatto_follow_up()
    {
        $token = $this->kokatto_get_token();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://portal.kokatto.com/api/v1/livenotification/notifications?followUpNotificationId=98124cc4-479f-47e5-8d81-e45f66bee185&pageSize=10',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;
    }

    function kokatto($no_hp)
    {
        $token = $this->kokatto_get_token();
        // Create Single Transactional Notification
        $notificationData = array(
            "code" => "daily_ibrpro"
        );
        $POSTFIELDS = array(
            "clientIdCampaignName" => "8435|VR2",
            "notificationData" => json_encode($notificationData),
            "receiver" => $no_hp,
            "isTransactional" => true,
            "hasChat" => false
        );
        $stringPOSTFIELDS = json_encode($POSTFIELDS);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://portal.kokatto.com/api/v1/livenotification/notifications/followup',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $stringPOSTFIELDS,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            ),
        ));
        $responseCreateSingleTransactionalNotification = curl_exec($curl);
        curl_close($curl);
        echo $responseCreateSingleTransactionalNotification;
    }

    public function test()
    {
        // $date1 = date_create('2023-12-07');
        // $date2 = date_create('2023-12-08');
        // $diff  = date_diff($date1, $date2);
        // $target = $diff->format("%a");
        // echo $target;
        // $target_hari = $this->db->query("SELECT TIMESTAMPDIFF(DAY,'2023-12-07','2023-12-08') + 1 AS jml_hari")->row();
        // echo $target_hari->jml_hari;
        // $myObj = new stdClass();
        // $myObj->name = "John";
        // $myObj->age = 30;
        // $myObj->city = "New York";

        // $myJSON = json_encode($myObj);

        // echo $myJSON;
        // $data = json_decode($myJSON);
        // $name = $data->name;
        // echo "Nama: " . $name;
        $notificationData = array(
            "code" => "daily_ibrpro"
        );
        $POSTFIELDS = array(
            "clientIdCampaignName" => "8435|VR2",
            "notificationData" => json_encode($notificationData),
            "receiver" => "6285324409384",
            "isTransactional" => true,
            "hasChat" => false
        );
        $stringPOSTFIELDS = json_encode($POSTFIELDS);
        echo $stringPOSTFIELDS;
    }

    public function index()
    {
        $data['pageTitle']        = "IBR Pro";
        // $data['type_active']   = $this->model_monday->get_type_active($id_type);
        $data['data_type']        = $this->model_monday->get_type();
        $data['not_started']      = $this->db->query("SELECT COUNT(id_task) AS jml FROM `td_task` WHERE `status` = 1")->row();
        $data['working_on']       = $this->db->query("SELECT COUNT(id_task) AS jml FROM `td_task` WHERE `status` = 2")->row();
        $data['done']             = $this->db->query("SELECT COUNT(id_task) AS jml FROM `td_task` WHERE `status` = 3")->row();
        $data['stuck']            = $this->db->query("SELECT COUNT(id_task) AS jml FROM `td_task` WHERE `status` = 4")->row();
        // $data['project']            = $this->db->query("SELECT id_project, project FROM rsp_project_live.m_project WHERE `status` IS NULL ORDER BY project")->result();
        $data['project']            = $this->db->query("SELECT divisi AS project, divisi AS id_project FROM `grd_m_so` GROUP BY divisi")->result();
        // $data['data_status']      = $this->model_monday->get_status();
        $data['css']              = "monday/css";
        $data['content']          = "monday/index";
        $data['js']               = "monday/js";
        $this->load->view('layout/main', $data);
    }

    public function get_type()
    {
        $type = $this->model_monday->get_type();
        echo json_encode($type);
    }

    public function save_type()
    {
        $type_name = $this->input->post('type_name');
        $data = [
            'type' => $type_name
        ];
        $save_type = $this->db->insert("td_type", $data);
        echo json_encode($save_type);
    }

    public function get_all_category()
    {
        $type = $this->model_monday->get_all_category();
        echo json_encode($type);
    }

    public function get_all_object()
    {
        $type = $this->model_monday->get_all_object();
        echo json_encode($type);
    }

    public function get_category()
    {
        $type = "";
        $id_type = $this->input->post('id_type');
        if ($id_type) {
            $type = $this->model_monday->get_category($id_type);
        }
        echo json_encode($type);
    }

    public function save_category()
    {
        $id_type = $this->input->post('id_type');
        $category_name = $this->input->post('category_name');
        $data = [
            'category' => $category_name,
            'type' => $id_type
        ];
        $save_category = $this->db->insert("td_category", $data);
        echo json_encode($save_category);
    }

    public function get_object()
    {
        $type = "";
        $id_category = $this->input->post('id_category');
        if ($id_category) {
            $type = $this->model_monday->get_object($id_category);
        }
        echo json_encode($type);
    }

    public function save_object()
    {
        $id_category = $this->input->post('id_category');
        $object_name = $this->input->post('object_name');
        $data = [
            'object' => $object_name,
            'category' => $id_category
        ];
        $save_object = $this->db->insert("td_object", $data);
        echo json_encode($save_object);
    }

    public function get_status()
    {
        $status = $this->model_monday->get_status();
        echo json_encode($status);
    }

    public function get_pic()
    {
        $status = $this->model_monday->get_pic();
        echo json_encode($status);
    }

    public function get_priority()
    {
        $status = $this->model_monday->get_priority();
        echo json_encode($status);
    }


    public function save_task()
    {
        $id_type = $this->input->post('id_type') ?? '';
        $id_category = $this->input->post('id_category') ?? '';
        $id_object = $this->input->post('id_object') ?? '';
        $id_status = $this->input->post('id_status') ?? '';
        $id_pic = implode(",", $this->input->post('id_pic') ?? '');
        $id_priority = $this->input->post('id_priority') ?? '';
        $task = $this->input->post('task') ?? '';
        $description = $this->input->post('description') ?? '';
        $due_date = $this->input->post('due_date') ?? '';
        $indicator = $this->input->post('indicator') ?? '';
        $strategy = $this->input->post('strategy') ?? '';
        $jenis_strategy = $this->input->post('jenis_strategy') ?? '';
        $project = $this->input->post('project') ?? '';
        $pekerjaan = $this->input->post('pekerjaan') ?? '';
        $sub_pekerjaan = $this->input->post('sub_pekerjaan') ?? '';
        $detail_pekerjaan = $this->input->post('detail_pekerjaan');
        if (!isset($detail_pekerjaan) || empty($detail_pekerjaan)) {
            $detail_pekerjaan = null;
        } else {
            $detail_pekerjaan = implode(",", $detail_pekerjaan);
        }
        // $detail_pekerjaan = implode(",",$this->input->post('detail_pekerjaan') ?? '');

        $id_task = $this->model_monday->generate_id_task();
        $data = [
            'id_task' => $id_task,
            'type' => $id_type,
            'category' => $id_category,
            'object' => $id_object,
            'status' => $id_status,
            'pic' => $id_pic,
            'priority' => $id_priority,
            'due_date' => $due_date,
            'task' => $task,
            'description' => $description,
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $this->session->userdata('user_id'),
            'progress' => 0,
            'divisi' => $project,
            'so' => $pekerjaan,
            'si' => $sub_pekerjaan,
            'tasklist' => $detail_pekerjaan,
            // 'id_project' => $project,
            // 'id_pekerjaan' => $pekerjaan,
            // 'id_sub_pekerjaan' => $sub_pekerjaan,
            // 'id_detail_pekerjaan' => $detail_pekerjaan,
        ];

        if ($id_type == 1) {
            $data['indicator'] = $indicator;
            $data['strategy'] = $strategy;
            $data['jenis_strategy'] = $jenis_strategy;
        }
        $save_task = $this->db->insert('td_task', $data);
        $data_history = [
            'id_task' => $id_task,
            'progress' => 0,
            'status' => $id_status,
            'status_before' => $id_status,
            'note' => 'Goals Created',
            'created_at' => date('Y-m-d H:i_s'),
            'created_by' => $this->session->userdata('user_id')
        ];
        $save_history = $this->db->insert('td_task_history', $data_history);


        $response['id_task']    = $id_task;
        $response['save_task']  = $save_task;
        echo json_encode($response);
    }


    public function save_sub_task()
    {
        $id_task = $this->input->post('id_task') ?? '';
        $id_mom = $this->input->post('id_mom') ?? null;
        $sub_task = $this->input->post('sub_task') ?? '';
        $sub_indicator = $this->input->post('sub_indicator') ?? '';
        $sub_type = $this->input->post('sub_type') ?? '';
        $sub_day = $this->input->post('sub_day') ?? '';
        $jml_sub_day = $this->input->post('jml_sub_day') ?? '';
        $start_date = $this->input->post('start_date') ?? '';
        $end_date = $this->input->post('end_date') ?? '';
        $sub_note = $this->input->post('sub_note') ?? '';
        $jam_notif = $this->input->post('jam_notif') ?? '';
        $user_id = $this->session->userdata('user_id');


        if ($jam_notif == "") {
            $jam_notif = "07:00";
        }


        $id_sub_task = $this->model_monday->generate_id_sub_task();
        if ($id_mom != 'IBR Pro' && $id_mom != NULL) { // id mom
            $start = new DateTime($start_date);
            $end   = new DateTime($end_date);

            $diff       = $start->diff($end);
            $total_days = $diff->days; // total selisih dalam satuan hari

            if ($total_days == 2) {
                $level = 1; // Low
            } elseif ($total_days == 3) {
                $level = 2; // Medium
            } elseif ($total_days == 4) {
                $level = 3; // High
            } elseif ($total_days == 5) {
                $level = 4; // Complex
            } elseif ($total_days >= 6) {
                $level = 5; // Expert
            } else {
                $level = 1; // Tidak memenuhi kriteria (misal: < 2 hari)
            }
            $this->add_item_mom($id_mom, $id_task, $id_sub_task, $sub_task, $level, $end_date, $user_id);
        }

        if (!empty($_FILES['file_sub']['name'])) {
            // Proses unggah file
            $config['upload_path']   = './uploads/monday/sub_task/';
            // $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
            $config['allowed_types'] = '*';
            $new_name = $id_sub_task . '_' . time();
            $config['file_name']     = $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file_sub')) {
                $response['error'] = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data['upload_data']['file_name'];
            }
        } else {
            $file_name = "";
        }

        if ($sub_type == 1) {
            // $date1 = date_create($start_date);
            // $date2 = date_create($end_date);
            // $diff  = date_diff($date1, $date2);
            // $target = $diff->format("%a");
            $target_hari = $this->db->query("SELECT TIMESTAMPDIFF(DAY,'$start_date','$end_date') + 1 AS jml_hari")->row();
            $target = $target_hari->jml_hari;
        } else if ($sub_type == 2) {
            $target_week = $this->model_monday->get_target_week($start_date, $end_date, $sub_day);
            $target = $target_week->jml_week;
        } else if ($sub_type == 3) {
            $target_month = $this->db->query("SELECT TIMESTAMPDIFF(MONTH,'$start_date','$end_date') + 1 AS jml_month")->row();
            $target = $target_month->jml_month;
        } else if ($sub_type == 4) {
            $target = 2;
        } else {
            $target = 0;
        }

        $data = [
            'id_sub_task' => $id_sub_task,
            'id_task' => $id_task,
            'sub_task' => $sub_task,
            'indicator' => $sub_indicator,
            'type' => $sub_type,
            'start' => $start_date,
            'end' => $end_date,
            'file' => $file_name,
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $this->session->userdata('user_id'),
            'note' => $sub_note,
            'target' => $target,
            'actual' => 0,
            'progress' => 0,
            'jam_notif' => $jam_notif ?? '07:00',
            'day_per_week' => $sub_day ?? null,
        ];
        $save_sub_task = $this->db->insert('td_sub_task', $data);
        $data_history = [
            'id_task' => $id_task,
            'note' => 'Strategy Created : ' . $sub_task,
            'created_at' => date('Y-m-d H:i_s'),
            'created_by' => $this->session->userdata('user_id')
        ];
        $save_history = $this->db->insert('td_task_history', $data_history);
        $this->send_notif_tasklist($id_task);
        $response['id_task']    = $id_task;
        $response['save_sub_task']  = $save_sub_task;
        echo json_encode($response);
    }

    public function add_item_mom($id_mom, $id_task, $id_sub_task, $sub_task, $level, $end_date, $user_id)
    {
        $last = $this->model_monday->get_mom_issue_item($id_mom, $id_task);
        $data = [
            'id_mom' => $last->id_mom,
            'id_issue' => $last->id_issue,
            'id_issue_item' => $last->id_issue_item + 1,
            'action' => $sub_task,
            'kategori' => 1,
            'level' => $level,
            'deadline' => $end_date,
            'pic' => $user_id,
            'id_task' => $id_task,
            'id_sub_task' => $id_sub_task,
        ];
        $this->db->insert('mom_issue_item', $data);
    }


    public function update_strategy_sub_task()
    {
        $id_task = $this->input->post('id_task') ?? '';
        $id_sub_task = $this->input->post('id_sub_task') ?? '';
        $sub_task = $this->input->post('sub_task') ?? '';
        $sub_indicator = $this->input->post('sub_indicator') ?? '';
        $sub_type = $this->input->post('sub_type') ?? '';
        $sub_day = $this->input->post('sub_day') ?? '';
        $jml_sub_day = $this->input->post('jml_sub_day') ?? '';
        $start_date = $this->input->post('start_date') ?? '';
        $end_date = $this->input->post('end_date') ?? '';
        $sub_note = $this->input->post('sub_note') ?? '';
        $jam_notif = $this->input->post('jam_notif') ?? '';


        if (!empty($_FILES['file_sub']['name'])) {
            // Proses unggah file
            $config['upload_path']   = './uploads/monday/sub_task/';
            // $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
            $config['allowed_types'] = '*';
            $new_name = $id_sub_task . '_' . time();
            $config['file_name']     = $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file_sub')) {
                $response['error'] = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data['upload_data']['file_name'];
            }
        } else {
            $file_name = "";
        }

        if ($sub_type == 1) {
            // $date1 = date_create($start_date);
            // $date2 = date_create($end_date);
            // $diff  = date_diff($date1, $date2);
            // $target = $diff->format("%a");
            $target_hari = $this->db->query("SELECT TIMESTAMPDIFF(DAY,'$start_date','$end_date') + 1 AS jml_hari")->row();
            $target = $target_hari->jml_hari;
        } else if ($sub_type == 2) {
            $target_week = $this->model_monday->get_target_week($start_date, $end_date, $sub_day);
            $target = $target_week->jml_week;
        } else if ($sub_type == 3) {
            $target_month = $this->db->query("SELECT TIMESTAMPDIFF(MONTH,'$start_date','$end_date') + 1 AS jml_month")->row();
            $target = $target_month->jml_month;
        } else if ($sub_type == 4) {
            $target = 2;
        } else {
            $target = 0;
        }

        $data = [
            'sub_task' => $sub_task,
            'indicator' => $sub_indicator,
            'type' => $sub_type,
            'start' => $start_date,
            'end' => $end_date,
            'file' => $file_name,
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $this->session->userdata('user_id'),
            'note' => $sub_note,
            'target' => $target,
            'actual' => 0,
            'progress' => 0,
            'jam_notif' => $jam_notif ?? '07:00',
            'day_per_week' => $sub_day ?? null,
        ];
        $save_sub_task = $this->db->where('id_sub_task', $id_sub_task)->update('td_sub_task', $data);
        $data_history = [
            'id_task' => $id_task,
            'note' => 'Strategy Updated : ' . $sub_task,
            'created_at' => date('Y-m-d H:i_s'),
            'created_by' => $this->session->userdata('user_id')
        ];
        $save_history = $this->db->insert('td_task_history', $data_history);

        $response['id_task']    = $id_task;
        $response['save_sub_task']  = $save_sub_task;
        echo json_encode($response);
    }

    public function update_sub_task()
    {
        $id_task = $this->input->post('id_task') ?? '';
        $id_sub_task = $this->input->post('id_sub_task') ?? '';
        $history_sub_note = $this->input->post('history_sub_note') ?? '';
        $history_sub_evaluasi = $this->input->post('history_sub_evaluasi') ?? '';
        $history_progress = $this->input->post('history_progress') ?? '';
        $history_link_sub = $this->input->post('history_link_sub') ?? '';
        $week_number = $this->input->post('week_number') ?? '';
        $week_start_date = $this->input->post('week_start_date') ?? '';
        $week_end_date = $this->input->post('week_end_date') ?? '';
        $jam_notif = $this->input->post('jam_notif') ?? '07:00';
        $user_id = $this->input->post('user_id') ?? $this->session->userdata('user_id');
        // $cek_status_task = $this->db->query("SELECT td_sub_task.id_sub_task, td_sub_task.id_task, td_task.id_task, td_task.`status` FROM td_sub_task
        // LEFT JOIN td_task ON td_task.id_task = td_sub_task.id_task
        // WHERE id_sub_task = '$id_sub_task' AND td_task.`status` = 3;");
        // if ($cek_status_task) { //cek apakah sudah berstatus done maka revisi
        //     $this->db->query("UPDATE mom_issue_item SET verified_note = NULL, verified_status = NULL, verified_by = NULL WHERE id_sub_task = '$id_sub_task'");
        //     $this->db->query("UPDATE td_sub_task SET verified_note = NULL, verified_status = NULL, verified_by = NULL WHERE id_sub_task = '$id_sub_task'");
        // }
        $this->rollback_status($id_sub_task);
        if ($jam_notif == "") {
            $jam_notif = '07:00';
        }

        if (!empty($_FILES['history_file_sub']['name'])) {
            // Proses unggah file
            $config['upload_path']   = './uploads/monday/history_sub_task/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf|xls|xlsx|mp4|doc|docx';
            $new_name = $id_sub_task . '_' . time();
            $config['file_name']     = $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('history_file_sub')) {
                $response['error'] = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data['upload_data']['file_name'];
            }
        } else {
            $file_name = "";
        }
        $get_weekday = $this->db->query("SELECT weekday(CURRENT_DATE) AS number_day")->row();
        $check_progress = $this->db->query("SELECT COUNT(id_task) AS jml, MAX(COALESCE(no_urut,1)) AS no_urut FROM td_sub_task_history WHERE id_sub_task = '$id_sub_task' AND SUBSTR(created_at,1,10) = CURRENT_DATE")->row();
        if ($check_progress->jml > 0) {
            $progress_t = 0;
            $no_urut_t = $check_progress->no_urut;
        } else {
            $progress_t = $history_progress;
            $last_no_urut = $this->db->query("SELECT MAX(COALESCE(no_urut,1)) AS no_urut FROM td_sub_task_history WHERE id_sub_task = '$id_sub_task'")->row();
            $no_urut_t = $last_no_urut->no_urut + 1;
        }
        $weekday = $get_weekday->number_day;
        $data = [
            'id_sub_task' => $id_sub_task,
            'id_task' => $id_task,
            'note' => $history_sub_note,
            'progress' => $progress_t,
            'file' => $file_name,
            'link' => $history_link_sub,
            'evaluasi' => $history_sub_evaluasi ?? "",
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $user_id,
            'week_day' => $weekday,
            'week_number' => $week_number,
            'week_start_date' => $week_start_date,
            'week_end_date' => $week_end_date,
            'no_urut' => $no_urut_t,
        ];
        $save_history_sub_task = $this->db->insert('td_sub_task_history', $data);
        $get_data_sub_task_history = $this->db->query("SELECT xs.id_sub_task, ROUND(SUM(xs.progress),2) AS progress, COUNT(xs.progress) AS actual
                                                        FROM(
                                                            SELECT
                                                                id_sub_task,
                                                                progress
                                                            FROM
                                                                `td_sub_task_history` 
                                                            WHERE
                                                                id_sub_task = '$id_sub_task' 
                                                            GROUP BY
                                                                SUBSTR( created_at, 1, 10 ),
                                                                id_sub_task
                                                        ) AS xs GROUP BY id_sub_task")->row();
        $data_subtask = [
            'progress' => $get_data_sub_task_history->progress,
            'actual' => $get_data_sub_task_history->actual,
            'evaluasi' => $history_sub_evaluasi ?? "",
            'jam_notif' => $jam_notif ?? "07:00",
            'status'    => $this->input->post('status') ?? '',
        ];
        $update_sub_task = $this->db->where('id_sub_task', $id_sub_task)->update('td_sub_task', $data_subtask);

        $response['status_task'] = $this->auto_status_done($id_task,$user_id);
        $response['id_task']    = $id_task;
        $response['id_sub_task']    = $id_sub_task;
        $response['save_sub_task']  = $update_sub_task;
        $response['notif_mom']    = $this->send_notif_mom($id_sub_task);
        echo json_encode($response);
    }

    public function rollback_status($id_sub_task)
    {
        $this->db->trans_start();
        $this->db->query("UPDATE mom_issue_item SET verified_note = NULL, verified_status = NULL, verified_by = NULL, owner_verified_note = NULL, owner_verified_status = NULL, owner_verified_by = NULL WHERE id_sub_task = '$id_sub_task'");
        $this->db->query("UPDATE td_sub_task SET verified_note = NULL, verified_status = NULL, verified_by = NULL WHERE id_sub_task = '$id_sub_task'");
        $this->db->trans_complete();
    }

    public function update_task()
    {
        $id_task = $this->input->post('id_task') ?? '';
        $update_task = false;

        if ($id_task == "") {
            echo json_encode([
                'status' => false,
                'message' => 'ID task tidak ditemukan.'
            ]);
            return;
        }

        $cek = $this->model_monday->check_revisi($id_task); // cek apakah task direvisi
        $cek_consistency = $this->model_monday->check_consistency($id_task); // cek apakah task konsisten (daily/weekly)

        if ($cek > 0 && $this->input->post('id_status') == 3) {
            echo json_encode([
                'status' => false,
                'message' => 'Task tidak bisa done karena masih ada revisi.'
            ]);
            return;
        }

        if ($cek_consistency > 0 && $this->input->post('id_status') == 3) {
            echo json_encode([
                'status' => false,
                'message' => 'Task tidak bisa done sampai tanggal end terpenuhi.'
            ]);
            return;
        }

        $id_status = $this->input->post('id_status') ?? '';
        $progress = $this->input->post('progress') ?? '';
        $evaluation = $this->input->post('evaluation') ?? '';
        $note = $this->input->post('note') ?? '';
        $start = $this->input->post('start') ?? '';
        $end = $this->input->post('end') ?? '';

        $get_old_status = $this->db->query("SELECT `status` FROM td_task WHERE id_task = '$id_task'")->row();

        $data_history = [
            'id_task' => $id_task,
            'progress' => $progress,
            'status' => $id_status,
            'status_before' => $get_old_status->status ?? null,
            'note' => $note,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id')
        ];
        $this->db->insert('td_task_history', $data_history);

        $data = [
            'status' => $id_status,
            'progress' => $progress,
            'evaluation' => $evaluation,
            'note' => $note,
            'start' => $start,
            'end' => $end
        ];

        if ($id_status == 3) {
            $data['done_date'] = date("Y-m-d H:i:s");
        }

        $update_task = $this->db->where('id_task', $id_task)->update('td_task', $data);

        if ($update_task) {
            echo json_encode([
                'status' => true,
                'message' => 'Task berhasil diperbarui.'
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Gagal memperbarui task.'
            ]);
        }
    }


    function log_history_sub_task()
    {
        $id_sub_task = $_POST['id_sub_task'];
        $response['log'] = $this->model_monday->log_history_sub_task($id_sub_task);
        echo json_encode($response);
    }

    public function dt_task()
    {
        $start = $this->input->post('start') ?? date("Y-m-d");
        $end = $this->input->post('end') ?? date("Y-m-d");
        $response['data'] = $this->model_monday->dt_task($start, $end);
        echo json_encode($response);
    }

    public function dt_sub_task()
    {
        $id_task = $this->input->post('id_task') ?? "";
        $response['data'] = "";
        if ($id_task != "") {
            $response['data'] = $this->model_monday->dt_sub_task($id_task);
        }
        echo json_encode($response);
    }

    function update_priority()
    {
        $update = "";
        $id_task = $this->input->post('id_task') ?? "";
        $id_priority = $this->input->post('id_priority') ?? "";
        if ($id_task != "" && $id_priority != "") {
            $data = [
                'priority' => $id_priority
            ];

            $update =  $this->db->where('id_task', $id_task)->update('td_task', $data);
        }
        echo json_encode($update);
    }


    public function get_detail_task()
    {
        $id_task = $this->input->post('id_task') ?? "";
        $response['detail'] = "";
        $response['status'] = false;
        if ($id_task != "") {
            $response['detail'] = $this->model_monday->get_detail_task($id_task);
            $response['status'] = true;
        }
        echo json_encode($response);
    }

    public function get_detail_sub_task()
    {
        $id_sub_task = $this->input->post('id_sub_task') ?? "";
        $response['detail'] = "";
        $response['status'] = false;
        if ($id_sub_task != "") {
            $response['detail'] = $this->model_monday->get_detail_sub_task($id_sub_task);
            $response['status'] = true;
        }
        echo json_encode($response);
    }

    public function get_timeline()
    {
        $id_task = $this->input->post('id_task');
        $query = "SELECT MIN(`start`) AS start_timeline, MAX(`end`) AS end_timeline FROM td_sub_task WHERE id_task = '$id_task'";
        $data =  $this->db->query($query)->row();
        echo json_encode($data);
    }

    public function delete_strategy()
    {
        $id_sub_task = $this->input->post('id_sub_task');
        $response['delete'] = $this->db->where('id_sub_task', $id_sub_task)->delete("td_sub_task");
        $response['delete_history'] = $this->db->where('id_sub_task', $id_sub_task)->delete("td_sub_task_history");
        echo json_encode($response);
    }


    function get_pekerjaan($divisi)
    {
        // $data = $this->db->get_where('grd_m_so')->result();
        $divisi = urldecode($divisi);
        $query = "SELECT
            grd_m_so.id_so AS id,
            grd_m_so.so AS pekerjaan,
            CONCAT(' | ',grd_m_goal.nama_goal, ' | ',DATE_FORMAT( grd_m_so.created_at, '%b %Y' )) AS periode
        FROM
            `grd_m_so` 
            JOIN grd_m_goal ON grd_m_so.id_goal = grd_m_goal.id_goal
        WHERE
            grd_m_so.divisi = '$divisi'";
        $data = $this->db->query($query)->result();
        echo json_encode($data);
    }
    function get_sub_pekerjaan($pekerjaan)
    {
        $query = "SELECT id_si AS id, si AS sub_pekerjaan FROM `grd_t_si` WHERE id_so =  $pekerjaan";
        // $data = $this->db->get_where('m_sub_pekerjaan', ['id_pekerjaan' => $pekerjaan])->result();
        $data = $this->db->query($query)->result();
        echo json_encode($data);
    }
    function get_det_pekerjaan($id_sub_pekerjaan)
    {
        $query = "SELECT id_tasklist AS id, detail FROM `grd_t_tasklist` WHERE id_si = $id_sub_pekerjaan";
        $data = $this->db->query($query)->result();
        // $data = $this->db->query('t_detail_pekerjaan', ['id_sub_pekerjaan' => $id_sub_pekerjaan])->result();

        echo json_encode($data);
    }

    public function send_notif_mom($id_sub_task)
    {
        $solver = $this->model_monday->get_solver_ibr($id_sub_task);

        if ($solver['link'] > '2024') {
            $lampiran = '';

            if ($solver['file'] != NULL && $solver['link'] == NULL) {
                $lampiran = $solver['file'];
            } else if ($solver['file'] == NULL && $solver['link'] != NULL) {
                $lampiran = $solver['link'];
            } else if ($solver['file'] != NULL && $solver['link'] != NULL) {
                $lampiran = "1. " . $solver['file'] . "
                2. " . $solver['link'];
            }

            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
            $data_text = array(
                "channelID" => "2225082380", // Channel Trusmi Group 2507194023
                // "phone" => '6285324409384',
                "phone" => $solver['contact_no'],
                "messageType" => "text",
                "body" => "📢 *Notifikasi Pembaruan Tasklist IBR PRO (MOM)* 📢

    Tasklist *IBR PRO* telah diperbarui. Mohon segera melakukan verifikasi:
    🏆 *Goals / Issue* : " . $solver['task'] . "
    💡 *Strategi* : " . $solver['sub_task'] . "
    👤 *PIC* : " . $solver['pic'] . "
    📝 *Evaluasi* : " . $solver['evaluasi'] . "
    📌 *Status* : " . $solver['status'] . "
    🌐 *Lampiran* : " . $lampiran . "

    🔗 *Detail* : https://trusmiverse.com/apps/pr/mom/" . $solver['mom'] . "

    *Mohon verifikasi maksimal 1x 24 jam, jika tidak akan di berlakukan Lock Absen*",
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

            return json_decode($result_text, true);
        }
    }
    public function send_notif_tasklist($id)
    {
        $data = $this->model_monday->detail_tasklist($id);
        foreach ($data as $item) {
            $msg = "🚀*Notifikasi Tasklist IBR Pro*🚀

Hey *$item->pic*
Tasklist Baru dari *$item->created* dengan rincian berikut :
📝 Goals : *$item->task*
🏷 Jenis Strategy : *$item->jenis_strategy*
💣 Due Date : *$item->due_date*

Update Progres di link berikut :
https://trusmiverse.com/apps/ibr_update?id=$item->id_sub_task&u=$item->id_pic

Jangan lupa cek detail dan selesaikan tepat waktu ya! Semangat terus, kamu pasti bisa!💪✨
            ";
            // $this->whatsapp_lib->send_single_msg('rsp', '083824955357', $msg); 
            $this->whatsapp_lib->send_single_msg('rsp', $item->contact_pic, $msg);
            // echo json_encode($msg);
        }
    }
    public function list_verif()
    {
        $data = $this->model_monday->list_verif();
        echo json_encode($data);
    }

    function save_verified()
    {
        $id_sub_task = $this->input->post('id_sub_task');
        $status = $this->input->post('verified_status');
        $data_update = [
            'verified_status' => $this->input->post('verified_status'),
            'verified_note' => $this->input->post('verified_note'),
            'verified_by' => $this->session->userdata('user_id'),

        ];
        if ($status == 1) {
            $data_update['verified_at'] = date('Y-m-d H:i:s');
        }
        $this->db->where('id_sub_task', $id_sub_task);
        // var_dump($status);die();
        $hasil = $this->db->update('td_sub_task', $data_update);
        if ($status == 2) {
            $update = $this->db->query("UPDATE td_sub_task SET freq_revisi = COALESCE(freq_revisi,0) + 1 WHERE id_sub_task = '$id_sub_task';");
            // $update2 = $this->db->query("UPDATE td_sub_task_history SET progress = 0 WHERE id_sub_task = '$id_sub_task';");
            // $update = $this->db->query("UPDATE td_task SET status = 2 WHERE id_task = '$id_task';");
            // $data_history = [
            // 	'id_task' => $id_task,
            // 	'progress' => 0,
            // 	'status' => 3,
            // 	'status_before' => 3,
            // 	'note' => 'Revisi Tasklist',
            // 	'created_at' => date('Y-m-d H:i_s'),
            // 	'created_by' => $this->session->userdata('user_id')
            // ];
            // $this->db->insert('td_task_history',$data_history);
            if ($update == true) {
                $this->send_not_oke($id_sub_task);
            }
        } else {
            try {
                $get_sub = $this->db->query("SELECT id_ps FROM td_sub_task WHERE id_sub_task = '$id_sub_task'")->row();
                if (!is_null($get_sub->id_ps)) {
                    $this->db->where('id_ps', $get_sub->id_ps);
                    $this->db->update('ps_task', array(
                        "status" 			=> 3,
                        "updated_at" 		=> date('Y-m-d H:i:s'),
                        "updated_by" 		=> $this->session->userdata('user_id'),
                    ));
    
                    $ps_history = array(
                        "ps_id"				=> $get_sub->id_ps,
                        "status" 			=> 3,
                        "resume" 			=> '',
                        "created_at" 		=> date('Y-m-d H:i:s'),
                        "created_by" 		=> $this->session->userdata('user_id'),
                    );
    
                    $this->db->insert("ps_task_history", $ps_history);
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        
        echo json_encode($hasil);
    }
    public function send_not_oke($id)
    {
        $data = $this->model_monday->get_detail_ibr_for_notif($id);
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

            $msg = "📢 *Notifikasi Revisi Tasklist IBR PRO* 📢
	
Tasklist *IBR PRO* telah diverifikasi dan terdapat revisi di task :
🏆 Goals / Issue : *$value->task*
💡 Strategi : *$value->sub_task*
👤 PIC : *$value->pic_mom*
🌐 Lampiran : $lampiran

📑 Status : *Tidak Oke*
💬 Note : *$value->verified_note*
📝 Verify by : *$value->pdca*
📌 Verify at : *" . date('Y-m-d H:i:s') . "*

Mohon revisi maksimal 1x 24 jam, jika tidak akan di berlakukan Lock Absen";
            // $this->whatsapp_lib->send_single_msg('rsp', '083824955357', $msg); 
            $this->whatsapp_lib->send_single_msg('rsp', $value->contact_no_pic, $msg);
            // echo json_encode($msg);
        }
    }
    public function auto_status_done($id_task,$user_id)
    {
        $affected = $this->model_monday->update_status_done($id_task);
        if ($affected > 0) {
            $data_history = [
                'id_task' => $id_task,
                'progress' => 100,
                'status' => 3,
                'status_before' => 2,
                'note' => 'Done',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $user_id
            ];
            $this->db->insert('td_task_history', $data_history);
            return true;
        }
        return false;
    }
}
