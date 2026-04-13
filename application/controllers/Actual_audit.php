<?php
defined('BASEPATH') or exit('No direct script access allowed');

class actual_audit extends CI_Controller //Formulir Dokumen Karyawan
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->library('Whatsapp_lib');
        $this->load->model('Model_actual_audit', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }
    function index()
    {
        $user = $this->session->userdata('user_id');
        $data['pageTitle']        = "Actual Audit";
        $data['css']              = "actual_audit/css";
        $data['js']               = "actual_audit/js";
        $data['content']          = "actual_audit/index";
        $this->load->view('layout/main', $data);
    }
    function get_plan_audit()
    {
        $data['data'] = $this->model->get_plan_audit();
        echo json_encode($data);
    }
    function get_actual_audit()
    {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $data['data'] = $this->model->get_actual_audit($start, $end);
        echo json_encode($data);
    }
    function save_audit()
    {
        $plan = $_POST['id_plan'];
        $actual = [
            "output" => $_POST['output'],
            "analisa" => $_POST['analisa'],
            "konfirmasi" => $_POST['konfirmasi'],
            "improvement" => $_POST['improvement'],
            "note" => $_POST['note'],
            "pemeriksaan_rekomendasi" => $_POST['rekomendasi'],
            "updated_by" => $this->session->userdata('user_id'),
            "updated_at" => date("Y-m-d H:i:s")
        ];
        $this->db->where('id_plan', $plan);
        $data['update'] = $this->db->update('t_audit_plan_monthly', $actual);
        echo json_encode($data);
    }
}
