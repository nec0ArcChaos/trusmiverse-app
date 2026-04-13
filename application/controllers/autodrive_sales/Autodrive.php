<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autodrive extends CI_Controller{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        $this->load->model('Model_autodrive', 'model');
    }

    // 23-8-25
public function check_nomor()
{
    // $nomor = $this->input->post('from');
    // $nomor = str_replace('@c.us', '', $nomor); // bersihkan format WA

    $mpm = $this->model->check_nomor();

    if ($mpm && $mpm->contact > 0) {
        echo json_encode([
            'status' => true,
            'message' => 'OK',
            'total' => $mpm->contact
        ]);
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'Nomor anda tidak terdaftar sebagai karyawan',
            'total' => 0
        ]);
    }
}
 

}