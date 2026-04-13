<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monitoring_absen_mkt extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_monitoring_absen_mkt', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']        = "Monitoring Nonaktif Sales Auto";
        $data['css']              = "monitoring_absen_mkt/css";
        $data['js']               = "monitoring_absen_mkt/js";
        $data['content']          = "monitoring_absen_mkt/index";
        // $data['approve_to']       = $this->get_approve_to_php();
        $this->load->view('layout/main', $data);
    }

    function dt_monitoring_absen_mkt()
    {
        $data['data'] = $this->model->dt_monitoring_absen_mkt();
        echo json_encode($data);
    }

    function dt_monitoring_absen_mkt_nonaktif()
    {
        $data['data'] = $this->model->dt_monitoring_absen_mkt_nonaktif();
        echo json_encode($data);
    }

    function activated_user()
    {
        $activated_user = $this->model->activated_user();
        echo json_encode($activated_user);
    }

    public function detail_absen()
    {
        if ($this->session->userdata("user_id") == '2063' || $this->session->userdata("user_id") == '1' || $this->session->userdata("user_role_id") == '1') {
            $employee_id = $this->input->post('employee_id');
        } else {
            $employee_id = $this->session->userdata("user_id");
        }
        $data['data'] = $this->model->detail_absen($this->input->post('periode') ?? date("Y-m"), $employee_id);
        echo json_encode($data);
    }
}
