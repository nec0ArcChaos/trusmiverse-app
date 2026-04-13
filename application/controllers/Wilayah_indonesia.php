<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wilayah_indonesia extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("Model_wilayah_indonesia", "model");
        // $this->load->model("model_dashboard_ibr_pro");

    }

    public function index()
    {
        $data['pageTitle']        = "Wilayah Indonesia";
        $data['css']              = "wilayah_indonesia/css";
        $data['content']          = "wilayah_indonesia/index";
        $data['js']               = "wilayah_indonesia/js";

        // $data['province'] = $this->model->get_province();

        $this->load->view('wilayah_indonesia/index', $data);
    }

}
