<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_karyawan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->model('Model_fack', 'model_fack');
        $this->load->model("model_profile");
    }

    public function index()
    {
        if ($this->session->userdata('user_id')) {
            $data['pageTitle']        = "Data Karyawan";
            $data['css']              = "Data_karyawan/css";
            $data['js']               = "Data_karyawan/js";
            $data['content']          = "Data_karyawan/index";
            $this->load->view('layout/main', $data);
        } else {
            redirect('login', 'refresh');
        }
    }

    public function karyawan_list()
    {
        $start = $this->input->post('start') ?? date("Y-m-01");
        $end = $this->input->post('end') ?? date("Y-m-t");
        $id_user = $this->input->post('id_user');
        $response['data'] = $this->model_fack->dt_fack_card($start, $end, $id_user);
        echo json_encode($response);
    }
}
