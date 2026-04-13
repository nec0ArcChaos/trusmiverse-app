<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Warning_letter extends CI_Controller //Formulir Dokumen Karyawan
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->model('Model_warning_letter', 'model');
        $this->load->model("model_profile");
        $this->load->library('FormatJson');
        $this->load->library('Filter');
        $this->load->library('Whatsapp_lib');
    }
    function kronologi($id_warning)
    {
        $warning = $this->model->get_data($id_warning);
        $data = [
            'pageTitle'=> 'Warning Letter',
            'css'=> 'warning_letter/css',
            'warning'=>$warning
        ];
        $this->load->view('warning_letter/index',$data);
    }
    function update_kronologi(){
        $data = [
            'description'=>$this->input->post('kronologi')
        ];
        $this->db->where('warning_id',$this->input->post('id_warning'));
        $this->db->update('xin_employee_warnings',$data);
        echo json_encode($_POST);
    }
}