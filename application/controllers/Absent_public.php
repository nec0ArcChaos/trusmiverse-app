<?php
// Trusmi History Lock Absen
// Created At : 12-05-2023
defined('BASEPATH') or exit('No direct script access allowed');
class Absent_public extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_absent_public', 'model');
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
        // $user_it = array(1, 61, 62, 63, 64, 1161, 2041, 2063, 2969, 2969, 2070);
        // if (in_array($this->session->userdata('user_id'), $user_it)) {
        // } else {
        //     $this->session->set_flashdata('no_access', 1);
        //     redirect('dashboard', 'refresh');
        // }
    }

    public function index()
    {
        $data['pageTitle']        = "T - Absent Public";
        $data['css']              = "absent_public/css";
        $data['js']               = "absent_public/js";
        $data['content']          = "absent_public/index";

        $this->load->view('layout/main', $data);
    }

    function dt_list_department()
    {
        $response['data'] = $this->model->dt_list_department();
        echo json_encode($response);
    }

    function dt_list_employees()
    {
        $response['data'] = $this->model->dt_list_employees();
        echo json_encode($response);
    }

    function save_publik()
    {
        $publik = array(
            'publik' => $_POST['status']
        );
        $this->db->where('department_id', $_POST['department_id']);
        $data['update'] = $this->db->update('xin_departments', $publik);
        echo json_encode($data);
    }

    function save_publik_employee()
    {
        $publik = array(
            'publik' => $_POST['status']
        );
        $this->db->where('user_id', $_POST['user_id']);
        $data['update'] = $this->db->update('xin_employees', $publik);
        echo json_encode($data);
    }

    function dt_list_companies()
    {
        $response['data'] = $this->model->dt_list_companies();
        echo json_encode($response);
    }

    // TAMBAHAN: Endpoint Save Batch
    function save_company_batch()
    {
        $ids = $this->input->post('ids'); // Array ID yang dicentang
        $status = $this->input->post('status'); // 1 atau 0

        if (!empty($ids)) {
            $update = $this->model->update_company_batch($ids, $status);
            $response['status'] = true;
            $response['message'] = "Berhasil update " . count($ids) . " data.";
        } else {
            $response['status'] = false;
            $response['message'] = "Tidak ada data yang dipilih.";
        }
        echo json_encode($response);
    }

    function dt_list_working_locations()
    {
        $response['data'] = $this->model->dt_list_working_locations();
        echo json_encode($response);
    }

    // TAMBAHAN: Endpoint Save Batch Location
    function save_working_location_batch()
    {
        $ids = $this->input->post('ids');
        $status = $this->input->post('status');

        if (!empty($ids)) {
            $update = $this->model->update_working_location_batch($ids, $status);
            $response['status'] = true;
            $response['message'] = "Berhasil update " . count($ids) . " lokasi.";
        } else {
            $response['status'] = false;
            $response['message'] = "Tidak ada data yang dipilih.";
        }
        echo json_encode($response);
    }
}
