<?php
// Trusmi History Lock Absen
// Created At : 12-05-2023
defined('BASEPATH') or exit('No direct script access allowed');
class Trusmi_masa_kerja extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_trusmi_masa_kerja', 'model');
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
        $data['pageTitle']        = "T - Masa Kerja";
        $data['css']              = "trusmi_masa_kerja/css";
        $data['js']               = "trusmi_masa_kerja/js";
        $data['content']          = "trusmi_masa_kerja/index";
        
        $this->load->view('layout/main', $data);
    }

    function dt_list_masa_kerja(){
        $type = $_POST['type'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $response['data'] = $this->model->dt_list_masa_kerja($type, $start, $end);
        echo json_encode($response);
    }


    // OLD
    public function dt_trusmi_resignation()
    {
        $tanggal = $this->validasi_tanggal();
        $response['data'] = $this->model->dt_trusmi_resignation($tanggal['start'], $tanggal['end'])->result();
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

    public function get_profile()
    {
        $get_profile = "";
        if ($this->input->post("user_id")) {
            $get_profile = $this->model->get_profile($this->input->post("user_id"))->row();
        }
        echo json_encode($get_profile);
    }

    public function store()
    {
        $reason = $this->input->post('reason');
        $qt_reason = htmlspecialchars(addslashes($reason), ENT_QUOTES);
        $note = $this->input->post('note');
        $qt_note = htmlspecialchars(addslashes($note), ENT_QUOTES);
        $employee_id = $this->session->userdata("user_id");
        if ($employee_id == null) {
            $response['status'] = 409; // conflict code
            $response['msg']    = "Sesi Login Anda Habis Silahkan Login Ulang";
            $response['data']   = "";
        } else {
            $data_resignation = [
                'employee_id'       => $employee_id,
                'company_id'        => $this->input->post('company_id'),
                'notice_date'       => $this->input->post('notice_date'),
                'resignation_date'  => $this->input->post('resignation_date'),
                'reason'            => $qt_reason,
                'note'              => $qt_note,
                'added_by'          => $employee_id,
                'created_at'        => date('d-m-Y'),
                'pernyataan_1'      => $this->input->post('pernyataan_1'),
                'pernyataan_2'      => $this->input->post('pernyataan_2'),
                'pernyataan_3'      => $this->input->post('pernyataan_3'),
                'pernyataan_4'      => $this->input->post('pernyataan_4'),
                'pernyataan_5'      => $this->input->post('pernyataan_5'),
                'pernyataan_6'      => $this->input->post('pernyataan_6'),
                'pernyataan_7'      => $this->input->post('pernyataan_7'),
                'pernyataan_8'      => $this->input->post('pernyataan_8'),
                'pernyataan_9'      => $this->input->post('pernyataan_9'),
                'pernyataan_10'     => $this->input->post('pernyataan_10')
            ];
            $store_resignation = $this->model->store($data_resignation);
            // $store_resignation = FALSE;
            if ($store_resignation == TRUE) {
                $id_resignation = $this->model->get_last_id_resignation_by_user_id($employee_id);
                $data_sub_clearance = $this->model->get_subclearance();
                foreach ($data_sub_clearance as $sc) {
                    $data_exit_clearance = [
                        'id_resignation' => $id_resignation,
                        'karyawan' =>  $employee_id,
                        'subclearance' => $sc->id,
                        'pic' => $sc->pic,
                        'status' => 0
                    ];
                    $this->db->insert("trusmi_exit_clearance", $data_exit_clearance);
                }
                $response['id_resignation'] = $id_resignation;
                $response['status'] = 200;
                $response['msg']    = "Success";
                $response['data']   = $data_resignation;
            } else {
                $response['status'] = 409; // conflict code
                $response['msg']    = "Failed";
                $response['data']   = $data_resignation;
            }
            echo json_encode($response);
        }
    }

    function verify_resignation($id_resignation)
    {
        // if (isset($_GET['id'])) {
        //     $id_resignation = $_GET['id'];
        //     $query = $this->model->get_trusmi_resignation_by_id($id_resignation);
        //     if ($query) {
        //         $data['data'] = $query;
        //         $data['id_resignation'] = $id_resignation;
        //     }
        // }
        $data['id_resignation'] = $id_resignation;
        $data['pageTitle']        = "T-Resignation";
        $data['css']              = "trusmi_resignation/css";
        $data['js']               = "trusmi_resignation/verify_resignation_js";
        $data['content']          = "trusmi_resignation/verify_resignation";
        $this->load->view('layout/main', $data);
    }

    public function dt_verify_resignation()
    {
        if ($this->input->post("id_resignation")) {
            $id_resignation = $this->input->post("id_resignation");
        }
        $response['data'] = $this->model->get_trusmi_resignation_by_id($id_resignation);
        echo json_encode($response);
    }

    public function get_profile_resignation()
    {
        $get_profile_resignation = "";
        if ($this->input->post("id_resignation")) {
            $get_profile_resignation = $this->model->get_profile_resignation($this->input->post("id_resignation"))->row();
        }
        echo json_encode($get_profile_resignation);
    }
}
