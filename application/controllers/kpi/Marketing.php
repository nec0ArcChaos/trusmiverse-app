<?php
// Trusmi History Lock Absen
// Created At : 12-05-2023
defined('BASEPATH') or exit('No direct script access allowed');
class Marketing extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('kpi/Model_marketing', 'model');
       
    }

    public function index()
    {
        $user_id = $_POST['user_id'];
        $periode = $_POST['periode'];
        $response['count'] = $this->model->data_kpi($user_id, $periode)->num_rows();
        $response['data'] = $this->model->data_kpi($user_id, $periode)->result();
        echo json_encode($response);
    }


}
