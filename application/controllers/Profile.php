<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("model_profile");
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']        = "Profile";
        $data['js']               = "profile/js";
        $data['content']          = "profile/index";
        $data['my_profile']       = $this->model_profile->get_my_profile()->row();
        $this->load->view('layout/main', $data);
    }

    public function training_list()
    {
        $user_id = $this->input->post('user_id');
        $data = $this->model_profile->training_list($user_id);
        echo json_encode($data);
    }
}
