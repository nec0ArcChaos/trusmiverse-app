<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Birthday_monitoring extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->database();
        $this->load->model('Model_birthday_monitoring', 'model');

        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    function index()
    {
        $data['content']   = "birthday_monitoring/index";
        $data['pageTitle'] = "Birthday Monitoring";
        $data['css']       = "birthday_monitoring/css";
        $data['js']        = "birthday_monitoring/js";

        $this->load->view("layout/main", $data);
    }

    function get_birthday_notif_log()
    {
        $startdate = $this->input->post('start');
        $enddate = $this->input->post('end');

        $data = $this->model->get_birthday_notif_log($startdate, $enddate);

        $res['data'] = $data;
        header('Content-Type: application/json');
        echo json_encode($res);
    }
}
