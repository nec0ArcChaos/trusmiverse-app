<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mind_map extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("model_mind_map");
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }


    public function index()
    {
        $data['pageTitle']        = "Mind Map";
        $data['css']              = "mind_map/css";
        $data['content']          = "mind_map/index";
        $data['js']               = "mind_map/js";
        $this->load->view('layout/main', $data);
    }

    public function add()
    {
        $data['pageTitle']        = "Mind Map";
        $data['css']              = "mind_map/add/css";
        $data['content']          = "mind_map/add/index";
        $data['js']               = "mind_map/add/js";
        $this->load->view('layout/main', $data);
    }
}
