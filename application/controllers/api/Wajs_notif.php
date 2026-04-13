<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wajs_notif extends CI_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        $this->load->model('Model_wajs_notif', 'model');
    }

    public function register()
    {
        $phone = $this->input->post('phone');
        $user = $this->model->check_number($phone);
        if (!$user) {
            $response = [
                'status' => 'error',
                'message' => 'Nomor whatsapp anda tidak ditemukan atau tidak aktif di database karyawan TGverse.',
                'data' => null
            ];
            echo json_encode($response);
            return;
        }
        if ($user->registered == 1) {
            $response = [
                'status' => 'success',
                'message' => "Nomor telah terdaftar di Bot Notif WhatsApp atas nama $user->full_name.",
                'data' => $user
            ];
        } else {
            $this->db->where('user_id', $user->user_id);
            $this->db->update('xin_employees', ['wa_notif_reg' => 1]);
            $response = [
                'status' => 'success',
                'message' => "Nomor berhasil didaftarkan di Bot Notif WhatsApp atas nama $user->full_name.",
                'data' => $user
            ];
        }

        echo json_encode($response);
    }

    // public function register_dev()
    // {
    //     $phone = $this->input->post('phone');
    //     $user = $this->model->check_number($phone);
    //     var_dump($phone);
    //     if (!$user) {
    //         $response = [
    //             'status' => 'error',
    //             'message' => 'Nomor whatsapp anda tidak ditemukan atau tidak aktif di database karyawan TGverse.',
    //             'data' => null
    //         ];
    //         echo json_encode($response);
    //         return;
    //     }
    //     if ($user->registered == 1) {
    //         $response = [
    //             'status' => 'success',
    //             'message' => "Nomor telah terdaftar di Bot Notif WhatsApp atas nama $user->full_name.",
    //             'data' => $user
    //         ];
    //     } else {
    //         $this->db->where('user_id', $user->user_id);
    //         $this->db->update('xin_employees', ['wa_notif_reg' => 1]);
    //         $response = [
    //             'status' => 'success',
    //             'message' => "Nomor berhasil didaftarkan di Bot Notif WhatsApp atas nama $user->full_name.",
    //             'data' => $user
    //         ];
    //     }

    //     echo json_encode($response);
    // }

    public function check_number()
    {
        $phone = $this->input->post('phone');
        $user = $this->model->check_number($phone);
        if (!$user) {
            $response = [
                'status' => 'error',
                'message' => 'Nomor tidak ditemukan atau tidak aktif di database karyawan.',
                'data' => null
            ];
            echo json_encode($response);
            return;
        }
        if ($user->registered == 1) {
            $response = [
                'status' => 'success',
                'message' => "Nomor telah terdaftar di Bot Notif WhatsApp atas nama $user->full_name.",
                'data' => $user
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => "Nomor belum didaftarkan di Bot Notif WhatsApp. Silakan daftar terlebih dahulu.",
                'data' => $user
            ];
        }

        echo json_encode($response);
    }

    // 23-8-25
    public function insert_log()
    {
        $data = [
            'tipe_notif' => $this->input->post('type'),
            'domain' => $this->input->post('domain'), // kosongkan dulu
            'sendTo' => $this->input->post('user_id'),
            'phone' => $this->input->post('phone'),
            'message' => $this->input->post('message'),
            'imageUrl' => $this->input->post('imageUrl'),
            'status' => 'pending',
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
            'status' => $status,
            'executionId' => $executionId,
        ];

        $this->db->where('id', $this->input->post('id'));
        $update = $this->db->update('wa_notif_log', $data);
        echo json_encode(['status' => $update]);
    }

    public function update_created_at()
    {
        $data = [
            'created_at' => date("Y-m-d H:i:s"),
        ];

        $this->db->where('id', $this->input->post('id'));
        $update = $this->db->update('wa_notif_log', $data);
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

    public function get_error_executions()
    {
        $from = $this->input->post('from');
        $to = $this->input->post('to');
        $executions = $this->model->get_error_executions($from, $to);
        echo json_encode(['executions' => $executions]);
    }
}