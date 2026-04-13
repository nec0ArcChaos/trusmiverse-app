<?php
// Trusmi WA Blash to Karyawan
// Created At : 27-06-2023
defined('BASEPATH') or exit('No direct script access allowed');
class Push_notif extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_push_notif', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']        = "Push Notification";
        $data['css']              = "push_notif/css";
        $data['js']               = "push_notif/js";
        $data['content']          = "push_notif/index";

        $data['list_employees'] = $this->model->list_employees();
        $data['list_departments'] = $this->model->list_departments();
        
        $this->load->view('layout/main', $data);
    }


}
