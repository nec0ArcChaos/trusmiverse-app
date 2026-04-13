<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Onboarding extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('hr/model_onboarding', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
   
    }

    public function index()
    {
        $data['pageTitle']  = "Dashboard Onboarding";
        $data['css']        = "hr/onboarding/css";
        $data['js']         = "hr/onboarding/js";
        $data['content']    = "hr/onboarding/index";

        $this->load->view('layout/main_agentic', $data);
    }
    public function resume(){
        $periode = $this->input->post('periode');
        $data =  $this->model->resume($periode);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function funnel(){
        $periode = $this->input->post('periode');
        $data = $this->model->funnel($periode);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function overall(){
        $periode = $this->input->post('periode');
        $data = $this->model->overall($periode);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function onboarding_monitoring(){
        $periode = $this->input->post('periode');
        $data = $this->model->onboarding_monitoring($periode);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function control_status(){
        $data = $this->model->control_status();
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function list_onboarding(){
        $data = $this->model->list_onboarding();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

}
