<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Theme extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']        = "Personalization";
        $data['js']               = "theme/js";
        $data['css']              = "theme/css";
        $data['content']          = "theme/index";
        $this->load->view('layout/main', $data);
    }
}
