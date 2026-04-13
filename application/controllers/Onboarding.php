<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Onboarding extends CI_Controller //Formulir Dokumen Karyawan
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->model('Model_onboarding', 'model');
        $this->load->library('FormatJson');
        $this->load->library('Whatsapp_lib');
    }
    function index()
    {
        $user_id = $this->session->userdata('user_id');
        $data['pageTitle'] = "Timeline Onboarding";
        $data['css'] = "onboarding/css";
        $data['js'] = "onboarding/js";
        $data['content'] = "onboarding/index";

        $this->load->view('layout/main', $data);
    }
    function load_data()
    {
        $divisi = $this->input->post('divisi');
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        if($divisi == 'comben'){
            $data = $this->model->get_data_comben($start,$end);
        }
        if($divisi == 'hr'){
            $data = $this->model->get_data_hr($start,$end);
        }
        if($divisi == 'ga'){
            $data = $this->model->get_data_ga($start,$end);
        }
        echo json_encode($data);
    }
    function detail(){
        $user_id = $this->input->post('user_id');
        $data = [
            'employee'=>$this->model->get_detail_employee($user_id),
            'day_1'=>$this->model->get_detail_day_1($user_id)
        ];
        echo json_encode($data);
    }


    function insert_validasi(){
        $user_id = $this->input->post('user_id');
        $status = $this->input->post('status');
        $id_item = $this->input->post('id_item');
        $note = $this->input->post('note');
        $divisi = $this->input->post('divisi');
        if($divisi == 'comben'){
            $data = [
                'id_item_onboard'=> $id_item,
                'user_id'=>$user_id,
                'validated_note'=>$note,
                'created_at'=>date('Y-m-d H:i:s'),
                'validated_at'=>date('Y-m-d H:i:s'),
                'validated_by'=>$this->session->userdata('user_id')
            ];
            $this->db->insert('t_history_onboarding',$data);
        }
        if($divisi == 'hr'){
            $data = [
                'id_item_onboard'=> $id_item,
                'user_id'=>$user_id,
                'validated_note'=>$note,
                'created_at'=>date('Y-m-d H:i:s'),
                'validated_at'=>date('Y-m-d H:i:s'),
                'validated_by'=>$this->session->userdata('user_id')
            ];
            $this->db->insert('t_history_onboarding',$data);
        }
        if($divisi == 'ga'){
            $data = [
                'status'=> $status,
                'validated_at'=>date('Y-m-d H:i:s'),
                'validated_by'=>$this->session->userdata('user_id')
            ];
            $this->db->where('id',$id_item);
            $this->db->update('t_request_onboarding',$data);
        }
        echo json_encode($this->input->post()); 
    }


}
