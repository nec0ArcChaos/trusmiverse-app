<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wajs_notif_tkb_customer extends CI_Controller{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        $this->load->model('Model_wajs_notif_tkb_customer', 'model');
    }

    public function register()
    {
        $phone = $this->input->post('phone');
        $m_customer = $this->model->check_number($phone);
        if (!$m_customer) {
            $response = [
                'status' => 'error',
                'message' => 'Nomor whatsapp anda tidak ditemukan atau tidak aktif di database karyawan TGverse.',
                'data' => null
            ];
            echo json_encode($response);
            return;
        }
        if ($m_customer->registered == 1) {
            $response = [
                'status' => 'success',
                'message' => "Nomor telah terdaftar di Bot Notif WhatsApp atas nama $m_customer->full_name.",
                'data' => $m_customer
            ];
        } else {
            $this->db->where('customer_id', $m_customer->customer_id);
            $this->db->update('m_customer', ['log_register' => 1]);
            $response = [
                'status' => 'success',
                'message' => "Nomor berhasil didaftarkan di Bot Notif WhatsApp atas nama $m_customer->full_name.",
                'data' => $m_customer
            ];
        }

        echo json_encode($response);
    }

    public function check_number()
    {
        $phone = $this->input->post('phone');
        $m_customer = $this->model->check_number($phone);
        if (!$m_customer) {
            $response = [
                'status' => 'success',
                'message' => "Nomor ini nomor eksternal.",
                'data' => $phone
            ];
            echo json_encode($response);
            return;
        }
        if ($m_customer->registered == 1) {
            $response = [
                'status' => 'success',
                'message' => "Nomor telah terdaftar di Bot Notif WhatsApp atas nama $m_customer->full_name.",
                'data' => $m_customer
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => "Nomor belum didaftarkan di Bot Notif WhatsApp. Silakan daftar terlebih dahulu.",
                'data' => $m_customer
            ];
        }

        echo json_encode($response);
    }

    // 23-8-25
    public function insert_log()
    {
        $data = [
            'tipe_notif' => $this->input->post('type'),
            'domain'    => $this->input->post('domain'), // kosongkan dulu
            'sendTo' => $this->input->post('customer_id'),
            'phone' => $this->input->post('phone'),
            'message'       => $this->input->post('message'),
            'imageUrl'       => $this->input->post('imageUrl'),
            'status'       => 'pending',
            'created_at' => date("Y-m-d H:i:s")
        ];

        // Insert dulu → ambil id row baru
        $id = $this->model->insert_log($data);
        echo json_encode(['id' => $id]);
    }

    // 23-8-25
    public function update_log()
    {
        $status = $this->input->post('status') ?? 'pending';
        $executionId = $this->input->post('executionId') ?? '';
        $data = [
            'status'       => $status,
            'executionId'  => $executionId,
        ];

        $this->db->where('id', $this->input->post('id'));
        $update = $this->db->update('log_register', $data);
        echo json_encode(['status' => $update]);
    }
    
    public function update_created_at()
    {
        $data = [
            'created_at' => date("Y-m-d H:i:s"),
        ];

        $this->db->where('id', $this->input->post('id'));
        $update = $this->db->update('log_register', $data);
        echo json_encode(['status' => $update]);
    }

    // 23-8-25
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