<?php
// Trusmi WA Blash to Karyawan
// Created At : 27-06-2023
defined('BASEPATH') or exit('No direct script access allowed');
class Trusmi_blast extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_trusmi_blast', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
        //  User IT
        //  61 Anggi
        //  62 Lutfi
        //  63 Said
        //  64 Lutfiedadi
        //  1161 Fujiyanto
        //  2041 Faisal
        //  2063 Aris
        //  2070 Kania
        //  2969 Ari Fadzri
        // $user_it = array(1, 61, 62, 63, 64, 1161, 2041, 2063, 2969, 2969, 2070);
        // if (in_array($this->session->userdata('user_id'), $user_it)) {
        // } else {
        //     $this->session->set_flashdata('no_access', 1);
        //     redirect('dashboard', 'refresh');
        // }
    }

    public function index()
    {
        $data['pageTitle']        = "T - WA BLast";
        $data['css']              = "trusmi_blast/css";
        $data['js']               = "trusmi_blast/js";
        $data['content']          = "trusmi_blast/index";
        
        $this->load->view('layout/main', $data);
    }

    function dt_wa_blast(){
        if(isset($_POST['id'])){
            $id = $_POST['id'];
            $start = NULL;
            $end = NULL;
        }else{
            $id = NULL;
            $start = $_POST['start'];
            $end = $_POST['end'];
        }
        $wa = $this->model->dt_wa_blast($start, $end, $id);
        $data['data'] = $wa['result'];
        $data['query'] = $wa['query'];
        echo json_encode($data);
    }

    function get_send_to(){
        $data = $this->model->get_send_to();
        echo json_encode($data);
    }
    
    function send_wa_blast(){
        $data = json_decode($this->input->raw_input_stream, true); // assoc array
        // var_dump($data);
        $phone  = $data['phone'] ?? null;
        $user_id  = $data['user_id'] ?? null;
        $tipe       = $data['tipe'] ?? null;
        $url        = $data['url'] ?? '';
        $filename    = $data['filename'] ?? null;
        $msg         = $data['msg'] ?? null;

        $id_user = $this->session->userdata('user_id');

        // if($id_user == 1){
            // $this->load->library('WAJS_hr');
            // $data['wa_status'] = $this->wajs_hr->send_wajs_notif_hr($phone, $msg, $tipe, 'trusmiverse', $url);
        // }else{
            $this->load->library('WAJS');
            $data['wa_status'] = $this->wajs->send_wajs_notif($phone, $msg, $tipe, 'trusmiverse', $user_id, $url);
        // }

        // $this->load->library('WAJS');
        // $data['wa_status'] = $this->wajs->send_wajs_notif($phone, $msg, $tipe, 'trusmiverse', $user_id, $url);
        echo json_encode($data);
    }
    
    function upload_file(){
		if(!empty($_FILES)){
			$uploadDir = "./assets/whatsapp_blast/";
			$originalName = basename($_FILES['file']['name']);
            $tempFilePath = $_FILES['file']['tmp_name'];
            $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
			$fileName = 'blast' . date('ymdHis') . '_' . substr(uniqid(),6) . '.' . $fileExtension;
			$uploadFilePath = $uploadDir.$fileName;

			//upload file to server
			if(move_uploaded_file($tempFilePath, $uploadFilePath)){
				$data['data'] = $fileName;
				$data['size'] = $_FILES['file']['size'];
				$data['ext'] = pathinfo($fileName, PATHINFO_EXTENSION);
			}else{
				$data['data'] = $_FILES["file"]["error"];
			}
		}else{
			$data['data'] = $_FILES["file"]["error"];
		}
		echo json_encode($data);
	}

	function remove_file(){
    $uploadDir = realpath("./assets/whatsapp_blast/");

    $name = basename($_POST['name']); // cegah ../../
    $filePath = realpath($uploadDir . '/' . $name);

    if (!$filePath || strpos($filePath, $uploadDir) !== 0) {
        echo json_encode(['remove'=>false,'error'=>'Invalid path']);
        return;
    }

    if (!file_exists($filePath)) {
        echo json_encode(['remove'=>false,'error'=>'File not found']);
        return;
    }

    $remove = unlink($filePath);

    echo json_encode([
        'filename' => $filePath,
        'remove' => $remove
    ]);
}


    function save_wa_blast(){
        $title = $_POST['title'];
        $employees = $_POST['employees'];
        $message = $_POST['message'];
        $attachment = $_POST['attachment'];

        $blast = array(
            'title'      => $title,
            'employees'  => implode(",",$employees),
            'message'    => $message,
            'attachment' => $attachment,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $_SESSION['user_id'],
        );

        $data['insert'] = $this->db->insert('trusmi_blast', $blast);

        echo json_encode($data);
    }
    
    function update_wa_blast(){
        $title = $_POST['title'];
        $employees = $_POST['employees'];
        $message = $_POST['message'];
        $attachment = $_POST['attachment'];

        $blast = array(
            'title'      => $title,
            'employees'  => implode(",",$employees),
            'message'    => $message,
            'attachment' => $attachment,
        );

        $this->db->where('id', $_POST['id']);
        $data['insert'] = $this->db->update('trusmi_blast', $blast);

        echo json_encode($data);
    }


}
