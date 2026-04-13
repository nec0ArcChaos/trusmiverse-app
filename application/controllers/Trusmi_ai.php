<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Trusmi_ai extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        if ($this->session->userdata('user_id') != "") { } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']        = "Trusmi AI";
        $data['js']               = "trusmi_ai/js";
        $data['content']          = "trusmi_ai/index";
        $data['css']          = "trusmi_ai/css";


        $this->load->view('layout/main', $data);
    }
}
