<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Refreshment extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('hr/model_refreshment', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
   
    }

    public function index()
    {
        $data['pageTitle']  = "Dashboard Refreshment";
        $data['css']        = "hr/refreshment/css";
        $data['js']         = "hr/refreshment/js";
        $data['content']    = "hr/refreshment/index";

        $this->load->view('layout/main_agentic', $data);
    }
    public function resume(){
        $periode = $this->input->post('periode');
        $data = $this->model->resume($periode);
        header('Content-Type: application/json');
        echo json_encode($data);

    }
    public function upcoming(){
        $periode = $this->input->post('periode');
        $data = $this->model->upcoming($periode);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function data_monitoring(){
        $periode = $this->input->post('periode');
        $data = $this->model->data_monitoring($periode);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    

}
