<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Resume_izin extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('hr/model_resume_izin', 'model_resume_izin');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
        //  User IT
        //  61 Anggi
        //  62 Lutfi
        //  63 Said
        //  64 Lutfiedadi
        //  1161 Fujiyanto
        //  2041 Faisal
        //  2063 Aris
        //  2070 Kania
        //  2969 Ari Fadzri
        $user_it = array(1, 61, 62, 323, 979, 63, 64, 1161, 2041, 2063, 2969, 2969, 2070, 778, 6486, 1139);
        if (in_array($this->session->userdata('user_id'), $user_it)) {
        } else {
            $this->session->set_flashdata('no_access', 1);
            redirect('dashboard', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']  = "Resume Izin";
        $data['css']        = "hr/resume_izin/css";
        $data['js']         = "hr/resume_izin/js";
        $data['content']    = "hr/resume_izin/index";

        $data['get_company']  = $this->model_resume_izin->get_company()->result();
        $this->load->view('layout/main', $data);
    }

    public function get_department()
    {
        $company_id     = $_POST['company_id'];
        $data           = $this->model_resume_izin->get_department($company_id)->result();

        echo json_encode($data);
    }

    public function get_employees()
    {
        $company_id     = $_POST['company_id'];
        $department_id  = $_POST['department_id'];
        $data           = $this->model_resume_izin->get_employees($company_id, $department_id)->result();

        echo json_encode($data);
    }

    public function get_resume_izin()
    {
        $company_id     = $_POST['company_id'];
        $department_id  = $_POST['department_id'];
        $employee_id    = $_POST['employee_id'];
        $start          = $_POST['start'];
        $end            = $_POST['end'];

        $data['data']   = $this->model_resume_izin->get_resume_izin($company_id, $department_id, $employee_id, $start, $end)->result();
        echo json_encode($data);
    }
}
