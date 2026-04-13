<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("model_dashboard");
        $this->load->model("hr/model_rekap_absen", "model_rekap_absen");
        $this->load->model("model_absen", "absen");
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']        = "Dashboard";
        $data['js']               = "m/dashboard/js";
        $data['css']              = "m/dashboard/css";
        $data['content']          = "m/dashboard/index";
        $this->load->view('m/layout/main', $data);
    }
}
