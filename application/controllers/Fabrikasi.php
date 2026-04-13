<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Fabrikasi extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('model_fabrikasi', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']  = "Master Fabrikasi";
        $data['css']        = "fabrikasi/css";
        $data['js']         = "fabrikasi/js";
        $data['content']    = "fabrikasi/index";
        $data['helper']     = $this->model->getHelper();
        $this->load->view('layout/main', $data);
    }

    public function getHelper()
    {
        $data = $this->model->getHelper();
        echo json_encode($data);
    }

    public function saveUpah()
    {
        $employee_id = $this->input->post('employee_id');
        $upah = $this->input->post('upah');
        $lembur = $this->input->post('lembur');

        // Check if employee_id already exists in trusmi_upah_helper
        $existingData = $this->db->get_where('trusmi_upah_helper', array('employee_id' => $employee_id))->row();
        if ($existingData) {
            // Employee already has an existing record
            $response = [
                'status' => 'error',
                'message' => 'Karyawan sudah memiliki data upah'
            ];
            echo json_encode($response);
            exit();
        }

        $data = array(
            'employee_id' => $employee_id,
            'nominal' => $upah,
            'lembur' => $lembur
        );
        $response['status'] = $this->db->insert('trusmi_upah_helper', $data);
        $response['message'] = 'Data upah berhasil disimpan';
        echo json_encode($response);
    }

    public function destroyUpah()
    {
        $role = $this->session->userdata('user_role_id');
        if ($role != 1) {
            echo json_encode('error');
            exit();
        }
        $employee_id = $this->input->post('employee_id');
        $data = $this->db->delete('trusmi_upah_helper', array('employee_id' => $employee_id));
        echo json_encode($data);
    }

    public function getDataUpah()
    {
        $response['data'] = $this->model->getDataUpah();
        echo json_encode($response);
    }
}
