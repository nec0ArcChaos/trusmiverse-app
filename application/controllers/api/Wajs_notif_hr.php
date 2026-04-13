<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wajs_notif_hr extends CI_Controller{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        $this->load->model('Model_wajs_notif_hr', 'model');
    }


    // 8-10-25
    public function insert_log()
    {
        $data = [
            'tipe_notif'    => $this->input->post('type'),
            'domain'        => $this->input->post('domain'), // kosongkan dulu
            'sendTo'        => $this->input->post('user_id'),
            'phone'         => $this->input->post('phone'),
            'message'       => $this->input->post('message'),
            'imageUrl'      => $this->input->post('imageUrl'),
            'status'        => 'pending',
            'created_at'    => date("Y-m-d H:i:s")
        ];

        // Insert dulu → ambil id row baru
        $id = $this->model->insert_log($data);
        echo json_encode(['id' => $id]);
    }

    public function update_log()
    {
        $data = [
            'status'       => $this->input->post('status'),
        ];

        $this->db->where('id', $this->input->post('id'));
        $update = $this->db->update('wa_notif_hr_log', $data);
        echo json_encode(['status' => $update]);
    }
    
    public function update_created_at()
    {
        $data = [
            'created_at' => date("Y-m-d H:i:s"),
        ];

        $this->db->where('id', $this->input->post('id'));
        $update = $this->db->update('wa_notif_hr_log', $data);
        echo json_encode(['status' => $update]);
    }

    public function check_mpm() //message per minute
    {
        $mpm = $this->model->check_mpm();
        if ($mpm->total > 20) {
            echo json_encode(['status' => false, 'message' => 'Limit pengiriman notifikasi per menit telah tercapai. Silakan coba beberapa saat lagi.', 'mpm' => $mpm->total]);
        } else {
            echo json_encode(['status' => true, 'message' => 'OK', 'mpm' => $mpm->total]);
        }
    }


    

}