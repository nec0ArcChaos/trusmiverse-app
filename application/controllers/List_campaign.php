<?php
defined('BASEPATH') or exit('No direct script access allowed');

class List_campaign extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->model('Model_campaign');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }
    function index()
    {
        $user = $this->session->userdata('user_id');
        $data['pageTitle'] = "List Campaign";
        $data['css'] = "list_campaign/css";
        $data['js'] = "list_campaign/js";
        $data['content'] = "list_campaign/index";

        // $data['data_masuk'] = $this->Model_campaign->get_data_masuk();
        // $data['data_keluar'] = $this->Model_campaign->get_data_keluar();
        // $data['karyawan_list'] = $this->Model_campaign->get_detail_karyawan();
        // $data['company']         = $this->model->get_company();
        // $data['aplikasi']         = $this->model->get_aplikasi();
        $this->load->view('layout/main', $data);
    }
    public function get_campaign()
    {
        $this->load->model('Model_campaign');
        $data = $this->Model_campaign->get_campaign();
        echo json_encode(['data' => $data]); // DataTables butuh key 'data'
    }

    // public function get_all_karyawan()
    // {
    //     $this->load->model('Model_campaign');
    //     $data = $this->Model_campaign->get_all_karyawan();
    //     echo json_encode(['data' => $data]); // DataTables butuh key 'data'
    // }


    public function get_data_keluar()
    {
        $result = $this->Model_campaign->get_data_keluar();
        echo json_encode(['data' => $result]);
    }


    // public function get_all_users()
    // {
    //     $this->db->select('e.user_id, e.nama, j.nama_jabatan, c.nama_company');
    //     $this->db->from('xin_employees e');
    //     $this->db->join('m_jabatan j', 'e.jabatan_id = j.id_jabatan', 'left');
    //     $this->db->join('xin_company c', 'e.company_id = c.company_id', 'left');
    //     return $this->db->get()->result();
    // }

    public function update_username_masuk()
    {
        $id = $this->input->post('id'); // id absen
        $username = $this->input->post('username');

        $this->db->where('id', $id)
            ->update('xin_attendance_time_manual_masuk', [
                'username' => $username
            ]);

        if ($this->db->affected_rows() > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'failed']);
        }
    }


    public function update_username_keluar()
    {
        $id = $this->input->post('id'); // id absen keluar
        $username = $this->input->post('username');

        $this->db->where('id', $id)
            ->update('xin_attendance_time_manual_keluar', [
                'username' => $username
            ]);

        if ($this->db->affected_rows() > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'failed']);
        }
    }

    public function get_detail_karyawan_ajax()
    {
        $id = $this->input->post('id'); // ambil dari POST
        $data = $this->Model_campaign->get_detail_karyawan_masuk($id);

        echo json_encode($data);
    }

    public function get_detail_karyawan_keluar_ajax()
    {
        $id = $this->input->post('id'); // ambil dari POST
        $this->load->model('Model_campaign');

        $data = $this->Model_campaign->get_detail_karyawan_keluar($id);

        echo json_encode($data);
    }

    public function get_all_karyawan_null_ajax()
    {
        $data = $this->Model_campaign->get_all_karyawan_null();
        echo json_encode($data);
    }

    public function get_all_karyawan_null_ajax_keluar()
    {
        $data = $this->Model_campaign->get_all_karyawan_null_keluar();
        echo json_encode($data);
    }

}
