<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ibr_update extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("Model_ibr_update", "model");
        $this->load->model("model_dashboard_ibr_pro");
    }

    public function index()
    {
        $data['pageTitle']        = "IBR Pro Update";
        $data['css']              = "ibr_update/css";
        $data['content']          = "ibr_update/index";
        $data['js']               = "ibr_update/js";

        $id_sub_task = $_GET['id'];
        $user_id = $_GET['u'];

        // $data_session = array(
        //     "user_id"            => $user_id,
        // );
        // $this->session->set_userdata($data_session);

        $data['profile'] = $this->model->profile_data($id_sub_task, $user_id);
        if($data['profile']['id_sub_task'] == null){
            $this->load->view('ibr_update/not_found', $data);
            
        }else{
            $data_consistency = $this->model_dashboard_ibr_pro->get_consistency($user_id);
            $data['profile']['consistency'] = $data_consistency[0]->consistency;
    
            $this->load->view('ibr_update/choose_action', $data);
        }
    }

    public function profile_data()
    {
        $id_sub_task = $_POST['id_sub_task'];
        $user_id = $_POST['user_id'];

        $data['profile'] = $this->model->profile_data($id_sub_task, $user_id);
        echo json_encode($data);
    }

    public function postpone()
    {
        $data_subtask = [
            'postponed_date' => $_POST['postponed_date'],
            'postponed_hour' => $_POST['postponed_hour'],
            'postponed_note' => $_POST['postponed_note'],
            'status' => $_POST['status'],
        ];
        $update_sub_task = $this->db->where('id_sub_task', $_POST['id_sub_task'])->update('td_sub_task', $data_subtask);

        $history = array(
            'id_sub_task' => $_POST['id_sub_task'],
            'id_task' => $_POST['id_task'],
            'progress' => $_POST['postponed_date'],
            'evaluasi' => $_POST['postponed_hour'],
            'note' => $_POST['postponed_note'],
            'is_postponed' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $_POST['user_id']
        );
        $insert_history = $this->db->insert('td_sub_task_history', $history);

        $response['postpone']  = $update_sub_task;
        $response['insert_history']  = $insert_history;
        echo json_encode($response);
    }

    function get_status_strategy(){
        $data = $this->db->query("SELECT id, status FROM td_status_strategy")->result();
        echo json_encode($data);
    }
}
