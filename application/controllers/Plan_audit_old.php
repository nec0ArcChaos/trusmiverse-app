<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Plan_audit extends CI_Controller //Formulir Dokumen Karyawan
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->library('Whatsapp_lib');
        $this->load->model('Model_plan_audit', 'model');
    }
    function index()
    {
        $user = $this->session->userdata('user_id');
        $data['pageTitle']        = "Plan Audit";
        $data['css']              = "plan_audit/css";
        $data['js']               = "plan_audit/js";
        $data['content']          = "plan_audit/index";
        $this->load->view('layout/main', $data);
    }
    function get_id_plan()
    {
        $plan = $this->model->get_latest_plan()->row_array();
        $isset_plan = $this->model->get_latest_plan()->num_rows();
        if ($isset_plan > 0) {
            $sub_id = substr($plan['id_plan'], 6);
            $sub_id = sprintf("%04d", $sub_id + 1);
            $id = substr($plan['id_plan'], 0, 6) . $sub_id;
        } else {
            $date = explode('-', date("Y-m"));
            $year = substr($date[0], 2);
            $month = $date[1];
            $id = "PA" . $year . $month . "0001";
        }
        return $id;
    }
    function get_audit_employees()
    {
        $data['employees'] = $this->model->get_audit_employees();
        echo json_encode($data);
    }
    function get_pic()
    {
        $posisi = $_POST['posisi'];
        $data['employees'] = $this->model->get_pic($posisi);
        echo json_encode($data);
    }
    function get_dokumen_audit()
    {
        $id = $_POST['id'];
        $data['dokumen'] = $this->model->get_dokumen_audit($id);
        echo json_encode($data);
    }
    function get_plan_audit()
    {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $data['data'] = $this->model->get_plan_audit($start, $end);
        echo json_encode($data);
    }
    function save_audit()
    {
        $id_plan = $this->get_id_plan();
        $dt_audit = explode(',', $_POST['dokumen_hidden']);
        $dokumen = [];
        if ($_POST['dokumen_hidden'] != '') {
            foreach ($dt_audit as $dt) {
                $d = explode('|', $dt);
                $dokumen = [
                    'id_plan' => trim($id_plan),
                    'id_dokumen' => trim($d[0]),
                    'tipe_dokumen' => trim($d[2])
                ];
                $data['insert_audit_dt'] = $this->db->insert('t_audit_plan_monthly_detail', $dokumen);
            }
        }
        $data = [
            "id_plan" => $id_plan,
            "periode" => $_POST['periode'],
            "auditor" => $_POST['auditor'],
            "subject" => $_POST['subject'],
            "object" => $_POST['object'],
            "tool" => $_POST['tools'],
            "pic" => $_POST['pic_hidden'],
            "pemeriksaan" => $_POST['pemeriksaan'],
            "target" => $_POST['target'],
            "bobot" => $_POST['bobot'],
            "company_id" => $_POST['company'],
            "department_id" => $_POST['department'],
            "designation_id" => $_POST['posisi'],
            "created_by" => $this->session->userdata('user_id'),
            "created_at" => date("Y-m-d")
        ];
        $data['insert'] = $this->db->insert('t_audit_plan_monthly', $data);
        echo json_encode($data);
    }
    function get_company()
    {
        $data['company'] = $this->model->get_company();
        echo json_encode($data);
    }
    function get_department()
    {
        $company = $_POST['company'];
        $data['department'] = $this->model->get_department($company);
        echo json_encode($data);
    }
    function get_designations()
    {
        $company = $_POST['company'];
        $department = $_POST['department'];
        $data['designation'] = $this->model->get_designations($company, $department);
        echo json_encode($data);
    }
}
