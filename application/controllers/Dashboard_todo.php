<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_todo extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("model_dashboard_todo", 'model');
        $this->load->model("hr/model_rekap_absen", "model_rekap_absen");
        $this->load->model("model_absen", "absen");
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']        = "Dashboard To-do";
        $data['js']               = "dashboard/to_do/js";
        $data['css']              = "dashboard/to_do/css";
        $data['content']          = "dashboard/to_do/index";
        $data['category'] = $this->db->get('m_todo_category')->result();
        $this->load->view('layout/main', $data);
    }

    public function data_todo()
    {
        $start = $this->input->post('start');
        $end = $this->input->post('end');

        $user_id = $this->input->post('user_id');
        $category = $this->input->post('category');
        $data = $this->model->data_todo($category, $start, $end, $user_id);
        echo json_encode($data);
    }

    public function get_task_resume()
    {
        $date = $this->input->post('yearMonth');
        $user_id = $this->input->post('user_id');

        $data = $this->model->get_task_resume($date, $user_id);

        echo json_encode(["success" => true, "data" => $data]);
    }

    public function get_task_pie()
    {
        $date = $this->input->post('yearMonth');
        $user_id = $this->input->post('user_id');

        $data = $this->model->get_task_pie($date, $user_id);

        echo json_encode(["success" => true, "data" => $data]);
    }

    public function lock_running()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $data = $this->model->lock_running($id, $status);
        $response = [
            'status' => 'success',
            'data' => $data
        ];
        echo json_encode($response);
    }

    public function lock_history()
    {
        $id = $this->input->post('id');
        $data = $this->model->lock_history($id);
        $response = [
            'status' => 'success',
            'data' => $data
        ];
        echo json_encode($response);
    }

    public function today_progress()
    {
        $id = $this->input->post('id');
        $data = $this->model->today_progress($id);
        $response = [
            'status' => 'success',
            'data' => $data
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function get_pic()
    {
        $user_id = $this->session->userdata('user_id');
        $user_role_id = $this->session->userdata('user_role_id');

        if ($user_id == 803 || $user_role_id == 1) {
            $con = "";
        } else {
            $con = "LIMIT 0";
        }
        $pic =  $this->db->query("SELECT
                                    CONCAT(
                                            CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ),
                                            ' | ',
                                            xin_companies.alias,
                                            ' | ',
                                            xin_departments.department_name 
                                    ) AS full_name,
                                    xin_employees.user_id AS `user_id`,
                                    xin_employees.contact_no,
                                    xin_employees.username
                                FROM
                                    xin_employees
                                    JOIN xin_companies ON xin_employees.company_id = xin_companies.company_id
                                    JOIN xin_departments ON xin_employees.department_id = xin_departments.department_id 
                                WHERE
                                    xin_employees.is_active = 1 AND xin_employees.user_id != 1
                                    AND (xin_employees.user_role_id IN (1,2,3,10)) $con")->result();
        echo json_encode($pic);
    }
}
