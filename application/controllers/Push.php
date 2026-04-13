<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Push extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper("url");
        $this->load->helper('fcm_helper');
        $this->load->model('Model_push_to', 'model');

    }

    // Halaman admin
    public function index() {
        // $this->load->view('push_view/index');
        $data['pageTitle']        = "Push Notif Trusmi Ontime";
        $data['css']              = "push_view/css";
        $data['js']               = "push_view/js";
        $data['content']          = "push_view/index";

        $data['list_employees'] = $this->model->list_employees();
        $data['list_departments'] = $this->model->list_departments();

        $this->load->view('layout/main', $data);
    }

    // Endpoint kirim notif
    // public function send() {

    //     // TOKEN dari Flutter
    //     $token = $this->input->post('token');
    //     $notifId = $this->input->post('notif_id');

    //     $title = $this->input->post('title');
    //     $body  = $this->input->post('body');

    //     $nama_menu = $this->input->post('nama_menu');
    //     $trx_id = $this->input->post('trx_id');


    //     $fileUrl  = '';
    //     $fileType = '';

    //     if (!$token) {
    //         echo json_encode([
    //             'status' => false,
    //             'msg' => 'FCM token kosong'
    //         ]);
    //         return;
    //     }

    //     if (!empty($_FILES['file']['name'])) {
    //         // $config['upload_path']   = FCPATH.'uploads/push';
    //         $config['upload_path']   = FCPATH.'assets/whatsapp_blast';

    //         $config['allowed_types'] = 'jpg|jpeg|png|pdf|xlsx';
    //         $config['encrypt_name']  = true;

    //         $this->load->library('upload', $config);

    //         if (!$this->upload->do_upload('file')) {
    //             echo json_encode(['status'=>false,'msg'=>$this->upload->display_errors()]);
    //             return;
    //         }

    //         $fileData = $this->upload->data();
    //         // $fileUrl  = base_url('uploads/push/'.$fileData['file_name']);
    //         $fileUrl  = base_url('assets/whatsapp_blast/'.$fileData['file_name']);

    //         $fileType = $fileData['file_ext']; // .pdf .png .xlsx
    //     }

    //     $res = send_fcm($token, $title, $body, $notifId, $nama_menu, $trx_id, $fileUrl, $fileType);

    //     echo json_encode([
    //         'status' => true,
    //         'response' => $res
    //     ]);
    // }

    public function send() {

        $tokens = json_decode($this->input->post('tokens'), true);
        $employees = json_decode($this->input->post('employees'), true);

        $notifId = $this->input->post('notif_id');
        $title = $this->input->post('title');
        $body  = $this->input->post('body');
        $nama_menu = $this->input->post('nama_menu');
        $trx_id = $this->input->post('trx_id');

        $fileUrl  = '';
        $fileType = '';

        if (empty($tokens)) {
            echo json_encode([
                'status' => false,
                'msg' => 'FCM token kosong'
            ]);
            return;
        }

        // upload file
        if (!empty($_FILES['file']['name'])) {
            $config['upload_path']   = FCPATH.'assets/whatsapp_blast';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf|xlsx';
            $config['encrypt_name']  = true;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file')) {
                echo json_encode(['status'=>false,'msg'=>$this->upload->display_errors()]);
                return;
            }

            $fileData = $this->upload->data();
            $fileUrl  = base_url('assets/whatsapp_blast/'.$fileData['file_name']);
            $fileType = $fileData['file_ext'];
        }

        // kirim ke banyak token
        $results = [];

        foreach ($tokens as $token) {
            $res = send_fcm($token, $title, $body, $notifId, $nama_menu, $trx_id, $fileUrl, $fileType);

            // pastikan array (kalau masih string JSON)
            if (is_string($res)) {
                $res = json_decode($res, true);
            }

            // cek sukses (ada 'name')
            if (isset($res['name'])) {

                // INSERT ke tabel to_notif_push
                $this->db->insert('to_notif_push', [
                    'user_id'       => $employees,
                    'token'       => $token,
                    'header_msg'       => $title,
                    'body_msg'        => $body,
                    'nama_menu'   => $nama_menu,
                    'file_url'    => $fileUrl,
                    'file_type'   => $fileType,
                    'fcm_name'    => $res['name'], // dari FCM
                    'created_at'  => date('Y-m-d H:i:s'),
                    'created_by'   => $created_by,
                ]);
            }

            $results[] = [
                'token' => $token,
                'response' => $res
            ];
        }

        echo json_encode([
            'status' => true,
            'total' => count($tokens),
            'response' => $results
        ]);
    }
}
