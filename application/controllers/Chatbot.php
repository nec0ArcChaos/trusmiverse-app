<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chatbot extends CI_Controller //Formulir Dokumen Karyawan
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

    // function index()
    // {
    //     $user_id = $this->session->userdata('user_id');
    //     $data['modal_awal'] = count($this->db->query("SELECT * FROM t_history_onboarding WHERE user_id = $user_id AND id_item_onboard = 5")->result());
    //     $data['tgl_join']= $this->db->query("SELECT date_of_joining FROM xin_employees WHERE user_id = $user_id")->result();
    //     $data['pageTitle'] = "Timeline Onboarding";
    //     $data['css'] = "timeline_onboarding/css";
    //     $data['js'] = "timeline_onboarding/js";
    //     $data['content'] = "timeline_onboarding/index";
    //     // $data['fdk']= $this->model_fdk->get_data();


    //     // 28-8-25 lutfiambar chatbot hr
    //     $data['chats'] = $this->model->get_chat_history($user_id);

    //     $this->load->view('layout/main', $data);
    // }


    // 28-8-25 lutfiambar chatbot hr
    public function chatbot_history()
    {
        $user_id = $this->session->userdata('user_id');

        $data['chats'] = $this->model->get_chat_history($user_id);
        echo json_encode($data);
    }



}
