<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Timeline_onboarding extends CI_Controller //Formulir Dokumen Karyawan
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->model('Model_timeline_onboarding', 'model');
        $this->load->library('FormatJson');
        $this->load->library('Whatsapp_lib');
    }
    function index()
    {
        $user_id = $this->session->userdata('user_id');
        // $data['modal_awal'] = count($this->db->query("SELECT * FROM t_history_onboarding WHERE user_id = $user_id AND id_item_onboard = 5")->result());
        $data['data_karyawan']= $this->model->get_data();
        $data['pageTitle'] = "Timeline Onboarding";
        $data['css'] = "timeline_onboarding/css";
        $data['js'] = "timeline_onboarding/js";
        $data['content'] = "timeline_onboarding/index";
        // $data['fdk']= $this->model_fdk->get_data();


        // 28-8-25 lutfiambar chatbot hr
        $data['chats'] = $this->model->get_chat_history($user_id);

        $this->load->view('layout/main', $data);
    }
    function get_data_day()
    {
        // $day = $this->input->post('day');

        $data = [
            'day_1' => $this->model->get_day_1(),
            'day_2' => $this->model->get_day_2(),
            'day_3' => 0

        ];
        // $data['data'] = $this->model->get_data($start, $end);
        echo json_encode($data);
    }
    function add_history()
    {
        $id = $this->input->post('id');
        $link = $this->input->post('link');
        $user_id = $this->session->userdata('user_id');
        $this->db->where('id_item_onboard', $id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('t_history_onboarding');
        if ($query->num_rows() > 0) {
            $response = [
                'status' => 'exists',
                'message' => 'Data sudah pernah disimpan sebelumnya.'
            ];
        } else {
            // Jika data belum ada, lakukan proses insert
            $data = [
                'id_item_onboard' => $id,
                'link' => $link,
                'user_id' => $user_id,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $user_id
            ];

            $insert_success = $this->db->insert('t_history_onboarding', $data);

            // Kirim response berdasarkan hasil insert
            if ($insert_success) {
                $response = [
                    'status' => 'success',
                    'message' => 'Data berhasil disimpan.'
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat menyimpan data.'
                ];
            }
        }
        echo json_encode($response);
    }
    function data_bantuan(){
        $data = $this->model->data_bantuan();
        echo json_encode($data);
    }
    function data_perlengkapan(){
        $data = $this->model->data_perlengkapan();
        echo json_encode($data);
    }

    function insert_request(){
        $tipe = $this->input->post('tipe');
        $result = false;
        if($tipe == 'id_card'){
            $data = [
                'id_tipe'=>1,
                'user_id'=>$this->session->userdata('user_id'),
                'lokasi_kantor'=>$this->input->post('lokasi'),
                'status'=>0,
                'created_at'=>date('Y-m-d H:i:s'),
                'created_by'=>$this->session->userdata('user_id'),
            ];
            $result = $this->db->insert('t_request_onboarding',$data);
        }else if($tipe == 'kursi'){
            $data = [
                'id_tipe'=>2,
                'user_id'=>$this->session->userdata('user_id'),
                'lokasi_kantor'=>$this->input->post('lokasi'),
                'status'=>0,
                'created_at'=>date('Y-m-d H:i:s'),
                'created_by'=>$this->session->userdata('user_id'),
            ];
            $result = $this->db->insert('t_request_onboarding',$data);
        }
        else if($tipe == 'seragam'){
            $data = [
                'id_tipe'=>3,
                'user_id'=>$this->session->userdata('user_id'),
                'lokasi_kantor'=>$this->input->post('lokasi'),
                'detail'=>$this->input->post('seragam') . ' '.$this->input->post('detail'),
                'status'=>0,
                'created_at'=>date('Y-m-d H:i:s'),
                'created_by'=>$this->session->userdata('user_id'),
            ];
            $result = $this->db->insert('t_request_onboarding',$data);
        }
        else if($tipe == 'akun_email'){
            $data = [
                'id_tipe'=>4,
                'user_id'=>$this->session->userdata('user_id'),
                'detail'=>$this->input->post('email_usulan') ,
                'status'=>0,
                'created_at'=>date('Y-m-d H:i:s'),
                'created_by'=>$this->session->userdata('user_id'),
            ];
            $result = $this->db->insert('t_request_onboarding',$data);
        
        }else if($tipe == 'laptop'){
            $data = [
                'id_tipe'=>5,
                'user_id'=>$this->session->userdata('user_id'),
                'lokasi_kantor'=>$this->input->post('lokasi'),
                'detail'=>$this->input->post('detail'),
                'status'=>0,
                'created_at'=>date('Y-m-d H:i:s'),
                'created_by'=>$this->session->userdata('user_id'),
            ];
            $result = $this->db->insert('t_request_onboarding',$data);
        }
        echo json_encode($result);
    }


    // 28-8-25 lutfiambar chatbot hr
    public function chatbot_history()
    {
        $user_id = $this->session->userdata('user_id');

        $data['chats'] = $this->model->get_chat_history($user_id);
    }



}
