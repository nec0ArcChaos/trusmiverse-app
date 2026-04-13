<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Resume_lock_absen extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->model('Model_resume_lock_absen');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }
    function index()
    {
        $user = $this->session->userdata('user_id');
        $data['pageTitle'] = "Resume Lock Absen";
        $data['css'] = "resume_lock_absen/css";
        $data['js'] = "resume_lock_absen/js";
        $data['content'] = "resume_lock_absen/index";

        // $data['data_masuk'] = $this->Model_resume_absen_manual->get_data_masuk();
        // $data['data_keluar'] = $this->Model_resume_absen_manual->get_data_keluar();
        // $data['karyawan_list'] = $this->Model_resume_absen_manual->get_detail_karyawan();
        // $data['company']         = $this->model->get_company();
        // $data['aplikasi']         = $this->model->get_aplikasi();
        $this->load->view('layout/main', $data);
    }
    public function lock_absen()
    {
        $this->load->model('Model_resume_lock_absen');
        $data = $this->Model_resume_lock_absen->lock_absen();
        echo json_encode(['data' => $data]);
    }

}