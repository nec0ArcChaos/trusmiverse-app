<?php
defined('BASEPATH') or exit('No direct script access allowed');

class History_liga extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // 1. Wajib Load Database
        $this->load->database(); 
        
        // 2. Wajib Set Header CORS agar bisa ditembak dari server/IP manapun
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding, Authorization");
        
        // Handle preflight request dari browser
        if ( $_SERVER['REQUEST_METHOD'] == 'OPTIONS' ) {
            exit(0);
        }
    }

    public function insert_history()
    {
        // Tangkap inputan dari AJAX (mendukung format JSON dari Vanilla JS)
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        // Jika tidak ada data, kembalikan error
        if (empty($data)) {
            echo json_encode(['status' => 'error', 'message' => 'No data received']);
            return;
        }

        // Susun data untuk di insert (Sesuaikan field dengan file .sql Anda)
        // Asumsi field: user_id, company, divisi, link_akses, created_at
        $insert_data = [
            'user_id'    => isset($data['user_id']) ? $data['user_id'] : NULL, // Ambil dari session frontend
            'company'    => isset($data['company']) ? $data['company'] : '',
            'divisi'     => isset($data['divisi']) ? $data['divisi'] : '',
            'title'     => isset($data['title']) ? $data['title'] : '',
            'link_akses' => isset($data['link']) ? $data['link'] : '',
            'accessed_at' => date('Y-m-d H:i:s')
        ];

        // Ganti 'history_menu_dashboard' dengan nama tabel aktual di database Anda
        $insert = $this->db->insert('history_menu_dashboard', $insert_data);

        if ($insert) {
            echo json_encode(['status' => 'success', 'message' => 'History saved']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save history']);
        }
    }
}