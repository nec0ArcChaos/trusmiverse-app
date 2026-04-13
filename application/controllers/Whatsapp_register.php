<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Whatsapp_register extends CI_Controller //Formulir Dokumen Karyawan
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('Whatsapp_lib');
        $this->load->model('model_dashboard');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }
    function index()
    {
        $data['pageTitle']        = "Register Notif Whatsapp";
        $data['css']              = "whatsapp_register/css";
        $data['js']               = "whatsapp_register/js";
        $data['content']          = "whatsapp_register/index";
        $data['personal_info']    = $this->model_dashboard->personal_info();
        $this->load->view('layout/main', $data);
    }
}
