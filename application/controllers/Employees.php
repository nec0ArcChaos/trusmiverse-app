<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employees extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_auth', 'auth');
        $this->load->model('Model_employees', 'model');
        if ($this->session->userdata('user_id') != "") {
            $user_id = $this->session->userdata('user_id');
            $check_hak_akses = $this->auth->check_hak_akses('employees', $user_id);
            if ($check_hak_akses != 'allowed') {
                redirect('forbidden_access', 'refresh');
            }
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']        = "Employees";
        $data['css']              = "employees/css";
        $data['js']               = "employees/js";
        $data['content']          = "employees/index";
        $data['agama'] = $this->db->get('xin_ethnicity_type')->result();
        $data['shift'] = $this->db->get('xin_office_shift')->result();
        $this->load->view('layout/main', $data);
    }

    function dt_employees()
    {
        $data['data'] = $this->model->dt_employees();
        echo json_encode($data);
    }

    function get_detail_employee()
    {
        $user_id = $this->input->post('user_id');
        $data = [
            'basic' => $this->model->detail_employee($user_id, 1),
            'family' => $this->model->detail_employee($user_id, 2),
            'qualifi' => $this->model->detail_employee($user_id, 3),
            'work_exp' => $this->model->detail_employee($user_id, 4),
            'contract' => $this->model->detail_employee($user_id, 5),
        ];

        echo json_encode($data);
    }



    function reset_password()
    {
        $reset_password = $this->model->reset_password();
        echo json_encode($reset_password);
    }

    function insert_family()
    {
        echo json_encode($_POST);
    }
    function update_basic_info()
    {
        $data = [
            'office_shift_id' => $this->input->post('office_shift'),
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('email'),
            'martial_status' => $this->input->post('martial_status'),
            'city' => $this->input->post('city'),
            'zipcode' => $this->input->post('zipcode'),
            'ethnicity_type' => $this->input->post('agama'),
            'ctm_ayah' => $this->input->post('ayah'),
            'ctm_ibu' => $this->input->post('ibu'),
            'contact_no' => $this->input->post('contact'),
            'address' => $this->input->post('address'),
            'ctm_tempat_lahir' => $this->input->post('place_birth'),
            'ctm_nokk' => $this->input->post('no_kk'),
            'ctm_ktp' => $this->input->post('no_ktp'),
            'ctm_npwp' => $this->input->post('no_npwp'),
        ];
        $this->db->where('user_id', $this->input->post('user_id'));
        // $test = $this->db->set($data)->get_compiled_update('xin_employees');
        $this->db->limit(1);
        $hasil = $this->db->update('xin_employees', $data);
        echo json_encode($hasil);
    }
}
