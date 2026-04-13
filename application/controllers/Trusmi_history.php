<?php
// Trusmi History Lock Absen
// Created At : 12-05-2023
defined('BASEPATH') or exit('No direct script access allowed');
class Trusmi_history extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_trusmi_history', 'model');
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
        // 6486 Bella Hans Namira
        $user_it = array(1, 61, 62, 323, 979, 63, 64, 1161, 2041, 2063, 2969, 2969, 2070, 2903, 2774, 778, 5647, 321, 6486, 1139);
        if (in_array($this->session->userdata('user_id'), $user_it)) {
        } else {
            $this->session->set_flashdata('no_access', 1);
            redirect('dashboard', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']        = "T-History";
        $data['css']              = "trusmi_history/css";
        $data['js']               = "trusmi_history/js";
        $data['content']          = "trusmi_history/index";
        $this->load->view('layout/main', $data);
    }

    public function dt_trusmi_history()
    {
        $tanggal = $this->validasi_tanggal();
        $response['data'] = $this->model->dt_trusmi_history($tanggal['start'], $tanggal['end'])->result();
        echo json_encode($response);
    }

    public function validasi_tanggal()
    {
        if ($this->input->post("start")) {
            $data['start'] = $this->input->post("start");
            $data['end']   = $this->input->post("end");
        } else {
            $data['start'] = date("Y-m-01");
            $data['end']   = date("Y-m-t");
        }
        return $data;
    }
}
