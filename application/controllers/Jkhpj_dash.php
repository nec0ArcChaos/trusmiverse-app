<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jkhpj_dash extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("model_jkhpj_dash", 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }


    public function index()
    {
        $user_id = $this->session->userdata("user_id");
        $data['pageTitle']        = "Dashboard Jadwal Kerja Harian Per Jam";
        $data['css']              = "jkhpj_dash/css";
        $data['content']          = "jkhpj_dash/index";
        $data['js']               = "jkhpj_dash/js";
        $data['user_id'] = $user_id;
        $data['is_head'] = $this->db->query("SELECT * FROM xin_departments WHERE head_id = '$user_id'")->num_rows() > 0 ? true : false;
        $data['is_manager'] = $this->db->query("SELECT * FROM xin_employees WHERE user_id = '$user_id' AND is_active = 1 AND user_role_id = 3")->num_rows() > 0 ? true : false;
        $data['departments'] = $this->model->getDepartments();

        $this->load->view('layout/main', $data);
    }

    public function get_data_dashboard()
    {
        $periode = $this->input->post('periode');
        $department_id = $this->input->post('department_id');
        $data = $this->model->get_data_dashboard($periode, $department_id);
        $res = [
            'data' => $data,
            'status' => 'success',
            'message' => 'Data dashboard berhasil diambil',
        ];
        header('Content-type: application/json');
        echo json_encode($res);
    }
}
