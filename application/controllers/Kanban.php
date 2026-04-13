<?php
// Trusmi History Lock Absen
// Created At : 12-05-2023
defined('BASEPATH') or exit('No direct script access allowed');
class Kanban extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_kanban', 'model');
        $this->load->model('Model_monday', 'monday');
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
        $data['pageTitle']        = "Kanban";
        $data['css']              = "kanban/css";
        $data['js']               = "kanban/js";
        $data['content']          = "kanban/index";
        
        $this->load->view('layout/main', $data);
    }

    function kanban_data(){
        if(isset($_POST['id_task'])){
            $id_task = $_POST['id_task'];
        } else {
            $id_task = null;
        }

        if(isset($_POST['user_id'])){
            if($_POST['user_id'] == '' || $_POST['user_id'] == null){
                $user_id = $_SESSION['user_id'];
            }else{
                $user_id = $_POST['user_id'];
            }
        }else{
            $user_id = $_SESSION['user_id'];
        }
        
        
        $kanban_data = $this->model->kanban_data($id_task, $user_id);
        // $response['kanban'] = $kanban_data;
        $myData = [];
        foreach ($kanban_data as $key => $value) {

            $sub_task_data = $this->monday->dt_sub_task($value->id_task);
            $my_sub_task = [];
            foreach ($sub_task_data as $keys => $task) {
                $sub_task = [
                    'sub_task'=> $task->sub_task,
                    'id_type'=> $task->id_type,
                    'type'=> $task->sub_type,
                    'start'=> $task->start,
                    'end'=> $task->end,
                    'jml_progress'=> $task->jml_progress,
                    'consistency'=> $task->consistency,
                ];
                $my_sub_task[] = $sub_task;
            }

            $myObject = [
                'id_task' => $value->id_task,
                'id_type' => $value->id_type,
                'type' => $value->type,
                'id_category' => $value->id_category,
                'category' => $value->category,
                'id_object' => $value->id_object,
                'object' => $value->object,
                'task' => $value->task,
                'description' => $value->description,
                'id_pic' => $value->id_pic,
                'pic' => $value->pic,
                'profile_picture' => $value->profile_picture,
                'id_status' => $value->id_status,
                'status' => $value->status,
                'status_color' => $value->status_color,
                'progress' => $value->progress,
                'id_priority' => $value->id_priority,
                'start' => $value->start,
                'end' => $value->end,
                'due_date' => $value->due_date,
                'note' => $value->note,
                'created_at' => $value->created_at,
                'created_by' => $value->created_by,
                'indicator' => $value->indicator,
                'strategy' => $value->strategy,
                'jenis_strategy' => $value->jenis_strategy,
                'evaluation' => $value->evaluation,
                'attachment' => $value->attachment,
                'sub_task' => $my_sub_task,
            ];

            $myData[] = $myObject;
        }

        $response['kanban'] = $myData;
        $response['user_id'] = $user_id;

        $response['user_role_id'] = $_SESSION['user_role_id'];

        echo json_encode($response);
    }

    function get_sub_task(){
        $id_task = $_POST['id_task'];
        // $data['data'] = $this->model->get_sub_task($id_task);
        $data['data'] = $this->monday->dt_sub_task($id_task);
        echo json_encode($data);
    }

    function log_history(){
        $id_task = $_POST['id_task'];
        $response['log'] = $this->model->log_history($id_task);
        echo json_encode($response);
    }
    
    function get_evaluasi(){
        $id_task = $_POST['id_task'];
        $response['log'] = $this->model->get_evaluasi($id_task);
        echo json_encode($response);
    }
    
    function get_attachment(){
        $id_task = $_POST['id_task'];
        $response['attachment'] = $this->model->get_attachment($id_task);
        echo json_encode($response);
    }

    function upload_file(){
		if(!empty($_FILES)){
			$uploadDir = "./assets/attachment/";
			$fileName = basename($_FILES['file']['name']);
			$uploadFilePath = $uploadDir.$fileName;

			//upload file to server
			if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath)){
				$file['data'] = $fileName;
				$file['size'] = $_FILES['file']['size'];
				$file['ext'] = pathinfo($fileName, PATHINFO_EXTENSION);
			}else{
				$file['data'] = $_FILES["file"]["error"];
			}

            $data_upload = array(
                'id_task'       => $_POST['id_task'],
                'note'          => $_POST['nama_file'],
                'attachment'    => $fileName,
                'created_at'    => date('Y-m-d H:i:s'),
                'created_by'    => $_SESSION['user_id'],
            );
            $data['file'] = $file;
            $data['insert'] = $this->db->insert('td_task_attach', $data_upload);

		}else{
			$file['data'] = $_FILES["file"]["error"];
            $data['file'] = $file; 
            $data['insert'] = null; 
		}
        
		echo json_encode($data);
	}


}
