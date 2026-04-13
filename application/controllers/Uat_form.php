<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Uat_form extends CI_Controller //Formulir Dokumen Karyawan
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->model('Model_uat', 'model');
        $this->load->library('FormatJson');
        $this->load->library('Filter');
        $this->load->library('Whatsapp_lib');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }
    function index($id_task = null)
    {
        $data = [
            'pageTitle' => 'UAT Form',
            'css' => 'uat_form/css',
            'ticket' => $this->model->get_data($id_task),
            'session' => $this->session->userdata('user_id')
        ];
        $this->load->view('uat_form/index', $data);
    }
    function insert_uat()
    {
        $id_uat = $this->get_id_uat();
        if (!empty($_FILES['attachment']['tmp_name'])) {
            if (is_uploaded_file($_FILES['attachment']['tmp_name'])) {
                //checking file type
                $allowed =  array('png', 'jpg', 'jpeg', 'pdf', 'xls', 'xlsx');
                $filename = $_FILES['attachment']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                if (in_array($ext, $allowed)) {
                    $tmp_name = $_FILES["attachment"]["tmp_name"];
                    // $profile = "/opt/lampp/htdocs/apps/uploads/tickets/";
                    $profile = "/var/www/trusmiverse/apps/uploads/tickets/";
                    // basename() may prevent filesystem traversal attacks;
                    // further validation/sanitation of the filename may be appropriate
                    $newfilename = 'UAT_' . $_POST['ticket'] . '_' . round(microtime(true)) . '.' . $ext;
                    $move = move_uploaded_file($tmp_name, $profile . $newfilename);
                    $fname = $newfilename;
                } else {
                    $Return['error'] = '';
                }
            }
        } else {
            $fname = '';
        }
        if ($_POST['status'] == 0) {
            $update = [
                'status' => 15
            ];
            $this->db->where('id_task', $_POST['ticket']);
            $data['update'] = $this->db->update('ticket_task', $update);
        } else if ($_POST['status'] == 1) {
            $update = [
                'status' => 16
            ];
            $this->db->where('id_task', $_POST['ticket']);
            $data['update'] = $this->db->update('ticket_task', $update);
        }
        $ticket = [
            'id_uat' => $id_uat,
            'id_task' => $_POST['ticket'],
            'status' => $_POST['status'],
            'note' => $_POST['note'],
            'files' => $fname,
            'created_at' => date('Y-m-d'),
            'created_by' => $this->session->userdata('user_id')
        ];
        $data['insert'] = $this->db->insert('ticket_uat', $ticket);
        $data_history = [
            'id_task'       => $_POST['ticket'],
            'progress'      => $_POST['progress'],
            'status'        => ($_POST['status'] == 0) ? 15 : 16,
            'status_before' => $_POST['status_before'],
            'note'          => $_POST['note'],
            'created_at'    => date('Y-m-d H:i_s'),
            'created_by'    => $this->session->userdata('user_id')
        ];
        $data['save_history'] = $this->db->insert('ticket_task_history', $data_history);
        $this->send_wa_uat($_POST['ticket']);
        echo json_encode($data);
    }
    function get_id_uat()
    {
        $uat = $this->db->query("SELECT * FROM ticket_uat WHERE SUBSTR(created_at,1,10) = SUBSTR(CURDATE(),1,10) ORDER BY id_uat DESC LIMIT 1")->row_array();
        if ($uat == null) {
            $date = substr(date("Ymd"), 2);
            $id = "UAT" . $date . "0001";
        } else {
            $latest = substr($uat['id_uat'], 9);
            $current = sprintf("%04d", (int)$latest + 1);
            $date = substr(date("Ymd"), 2);
            $id = "UAT" . $date . $current;
        }
        return $id;
    }
    function send_wa_uat($id_task)
    {
        $pics = $this->model->get_pic_ticket($id_task);
        $pic = explode(",", $pics['pic']);
        $total_pic = count($pic);
        for ($i = 0; $i < $total_pic; $i++) {
            $row_ticket = $this->model->get_ticket_uat($id_task, $pic[$i]);
            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
            $data_text = array(
                "channelID" => "2225082380", // Channel Trusmi Group
                "phone" => $row_ticket['contact'],
                "messageType" => "text",
                "body" => "🛰  *Notifikasi Hasil UAT* 🛰 
    
Halo *" . trim(ucwords($row_ticket['pic'])) . "*,

Kami telah menyelesaikan User Acceptance Testing (UAT) untuk tiket pengembangan sistem dengan nomor _" . $row_ticket['id_task'] . "_. Berikut adalah hasil dari UAT yang telah dilakukan:

Detail Ticket :

*Nomor Ticket*  : " . trim(ucwords($row_ticket['id_task'])) . "
*Task*          : " . trim(ucwords($row_ticket['task'])) . "
*Deskripsi*     : " . trim(ucwords($row_ticket['description'])) . "

_Hasil UAT_

*Status*        : " . $row_ticket['status'] . "
*Deskripsi*     : " . trim(ucwords($row_ticket['note'])) . "

_Silakan tindak lanjuti sesuai dengan hasil UAT di atas._",
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
}
