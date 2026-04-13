<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Read_memo extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("Model_trusmi_memo", 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }
    function publish(){
        $tgl = $this->uri->segment(3);
        $judul = $this->uri->segment(4);
        $url = $tgl.'/'.$judul;
        $data = [
            'content'=>$this->model->read($url)
        ];
        $this->load->view('trusmi_memo/read.php',$data);
    }
}