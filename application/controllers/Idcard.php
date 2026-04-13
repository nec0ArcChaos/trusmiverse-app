<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Idcard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("model_profile");
        if (!$this->session->userdata('user_id')) {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']        = "ID Card";
        $data['js']               = "idcard/js";
        $data['content']          = "idcard/index";
        $data['my_profile']       = $this->model_profile->get_my_profile()->row();
        // var_dump($data['my_profile']);
        // die;
        $this->load->view('layout/main', $data);
    }

    public function print()
    {
        $data['my_profile']       = $this->model_profile->get_my_profile()->row();
        $this->load->view('idcard/print', $data);
    }
}
