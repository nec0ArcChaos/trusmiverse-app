<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Janji_konsumen extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("Model_janji_konsumen", 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {

            redirect('login', 'refresh');
        }
    }


    public function index()
    {
        $data['view_janji_konsumen']=$this->model->view_janji_konsumen();
        $data['pageTitle'] = "Pelanggaran Terhapan Konsumen";
        $data['css'] = "janji_konsumen/css";
        $data['content'] = "janji_konsumen/index";
        $data['js'] = "janji_konsumen/js";
        $this->load->view('layout/main', $data);

    }
    public function data(){
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        echo json_encode($this->model->get_data($start,$end));
    }
    public function get_komplain(){
        $periode = $this->input->post('periode');
        $week = $this->input->post('week');
        $jenis = $this->input->post('jenis');
        echo json_encode($this->model->get_komplain($periode,$week,$jenis));

    }
    public function insert(){
        $id_komplain = $this->input->post('komplain');
        $periode = $this->input->post('tahun').'-'.$this->input->post('bulan');
        $value = $this->input->post('value');
        $week = $this->input->post('week');
        $data = [
            'id_komplain'=>$id_komplain,
            'periode'=>$periode,
            'week'=>$week,
            'value'=>$value,
            'created_at'=>date('Y-m-d H:i:s'),
            'created_by'=>$this->session->userdata('user_id')
        ];
        $result = $this->db->insert('t_janji_konsumen',$data);
        echo json_encode($result);
    }

}