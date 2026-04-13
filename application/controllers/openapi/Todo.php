<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Todo extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("model_dashboard_todo", 'model');
    }

    public function today()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $username = $input['username'];

        $get_user_id = $this->db->query("SELECT user_id FROM xin_employees WHERE username = '$username'");
        if ($get_user_id->num_rows() == 0) {
            $response = [
                'status' => 'error',
                'data' => []
            ];
        } else {
            $id = $get_user_id->row_array()['user_id'];
            $data = $this->model->data_todo('all', date('Y-m-d'), date('Y-m-d'), $id);
            $response = [
                'status' => 'success',
                'data' => $data
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    
    }
}
