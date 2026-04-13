<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Emp_new extends CI_Controller
{

    private $api_key = 'ittrusmi2026en!';
    function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        // $this->load->library('FormatJson');

        $this->_check_auth();
        $this->load->model('api/Model_head_division', 'model');
    }

    private function _check_auth()
    {
        $token_header = $this->input->get_request_header('X-API-KEY', TRUE);
        $token_param = $this->input->get('key');
        $input_token = !empty($token_header) ? $token_header : $token_param;
        if ($input_token !== $this->api_key) {
            $this->output->set_status_header(401);
            $this->output->set_content_type('application/json');
            echo json_encode([
                'status' => false,
                'message' => 'Akses Ditolak: Token tidak valid atau tidak ditemukan.',
                'error_code' => 401
            ]);
            exit;
        }
    }


    public function data($max_id)
    {
        $emp = $this->model->data_emp($max_id);
        $data['Employees'] = $emp;
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}