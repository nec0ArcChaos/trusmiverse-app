<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Job_candidates extends CI_Controller //Formulir Dokumen Karyawan
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->library('Whatsapp_lib');
        $this->load->model('recruitment/Model_job_candidates', 'model');
        $this->load->model("model_profile");
    }
    function index()
    {
        $user = $this->session->userdata('user_id');
        $data['pageTitle']        = "Job Candidates";
        $data['css']              = "recruitment/job_candidates/css";
        $data['js']               = "recruitment/job_candidates/js";
        $data['content']          = "recruitment/job_candidates/index";
        $this->load->view('layout/main', $data);
    }
    function get_candidates()
    {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $data['data'] = $this->model->get_candidates($start, $end);
        echo json_encode($data);
    }
    function cover_letter()
    {
        $id = $_POST['id'];
        $data['cover_letter'] = $this->model->cover_letter($id);
        echo json_encode($data);
    }
}
