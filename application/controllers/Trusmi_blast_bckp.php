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
        $start = $_POST['start'];
        $end = $_POST['end'];
        $data['data'] = $this->model->dt_wa_blast($start, $end);
        echo json_encode($data);
    }

    function get_send_to(){
        $data = $this->model->get_send_to();
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
		$uploadDir = "./assets/whatsapp_blast/";
		$fileName = $uploadDir.$_POST['name'];  
		$remove = unlink($fileName); 
		$data['filename'] = $fileName;
		$data['remove'] = $remove;
		echo json_encode($data);
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


}
