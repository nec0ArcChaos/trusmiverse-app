<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Resume_resignation extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_resume_resignation', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']        = "Resume Resignation";
        $data['css']              = "resume_resignation/css";
        $data['js']               = "resume_resignation/js";
        $data['content']          = "resume_resignation/index";
        $data['companies']        = $this->db->query("SELECT company_id,name FROM xin_companies")->result();
        $this->load->view('layout/main', $data);
    }

    public function dashboard_1()
    {
        $start = @$_REQUEST['start'];
        $end = @$_REQUEST['end'];
        $company_id = @$_REQUEST['company_id'];
        if ($company_id == 'all') {
            $company_id = null;
        }
        $data = $this->model->dashboard_1($start,$end,$company_id);

        $groupedData = [];

        foreach ($data as $item) {
            $masa_kerja = $item['masa_kerja'];
            $company_id = $item['company_id'];
            $department_id = $item['department_id'];
            
            if (!isset($groupedData[$masa_kerja])) {
                $groupedData[$masa_kerja] = ['masa_kerja' => $masa_kerja, 'data' => []];
            }
            
            $companyIndex = array_search($company_id, array_column($groupedData[$masa_kerja]['data'], 'company_id'));
            
            if ($companyIndex === false) {
                $groupedData[$masa_kerja]['data'][] = [
                    'company_id' => $company_id,
                    'company_name' => $item['company_name'],
                    'data' => []
                ];
                $companyIndex = count($groupedData[$masa_kerja]['data']) - 1;
            }
            
            $groupedData[$masa_kerja]['data'][$companyIndex]['data'][] = [
                'department_id' => $department_id,
                'department_name' => $item['department_name'],
                'mp' => $item['mp']
            ];
        }

        ksort($groupedData, SORT_NUMERIC);

        header('Content-type: application/json');
        echo json_encode(array_values($groupedData), JSON_PRETTY_PRINT);
    }

    public function dashboard_2()
    {
        $start = @$_REQUEST['start'];
        $end = @$_REQUEST['end'];
        $company_id = @$_REQUEST['company_id'];
        if ($company_id == 'all') {
            $company_id = null;
        }
        $data = $this->model->dashboard_2($start,$end,$company_id);

        header('Content-type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function dashboard_3()
    {
        $start = @$_REQUEST['start'];
        $end = @$_REQUEST['end'];
        $company_id = @$_REQUEST['company_id'];
        if ($company_id == 'all') {
            $company_id = null;
        }
        $data = $this->model->dashboard_3($start,$end,$company_id);

        header('Content-type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function dashboard_4()
    {
        $start = @$_REQUEST['start'];
        $end = @$_REQUEST['end'];
        $company_id = @$_REQUEST['company_id'];
        if ($company_id == 'all') {
            $company_id = null;
        }
        $data = $this->model->dashboard_4($start,$end,$company_id);

        header('Content-type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
}