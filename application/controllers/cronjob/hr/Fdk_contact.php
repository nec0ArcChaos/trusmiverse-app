<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Fdk_contact extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        $this->load->library('FormatJson');
        $this->load->model('model_fdk', 'model');
    }
    function index()
    {
        echo 'test';
    }

    function json_to_db()
    {
        $json_file = FCPATH . 'uploads/fdk/temp_phone.json';
        $json_data = file_get_contents($json_file);
        $contact = json_decode($json_data, true);
        // var_dump($contact);die();
        $skipped_names = ['cek pulsa', 'isi pulsa', 'cek bonus', 'info pelanggan', 'cek nomor', 'contact center', 'TELKOMSEL']; // contact skip
        if (!empty($contact)) {
            foreach ($contact as $item) {
                $data = [
                    'id' => '',
                    'employee_id' => $item['user_id'],
                    'name' => is_array($item['name']) ? implode(' ', $item['name']) : $item['name'],
                    'phone' => $item['phone'],
                    'email' => $item['email'],
                    'status' => 0,
                    'created_at' => $item['created_at'],
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                $this->model->insert_contact($data);
            }
            // Kosongkan file JSON setelah data berhasil di-insert
            file_put_contents($json_file, json_encode([]));
            $response = "Data berhasil di-insert dan file JSON sudah dikosongkan.";
        } else {
            $response = "File JSON kosong.";
        }
        echo json_encode($response);
    }

    function check()
    {
        $data = $this->model->get_all_contact();
        foreach ($data as $row) {
            // URL API
            $api_url = 'https://sender.whatshub.web.id/api/checkNumberStatus?phone=' . $row->phone . '&session=customer_rn';

            // Membuat header dengan 'x-api-key'
            $options = [
                'http' => [
                    'header' => "x-api-key: whatshubmaju\r\n"
                ]
            ];

            // Membuat stream context dengan opsi header
            $context = stream_context_create($options);

            // Mengambil data dari API dengan stream context
            $response = file_get_contents($api_url, false, $context);

            if ($response === FALSE) {
                // Tangani kesalahan jika gagal mengambil data
                echo 'Gagal mengambil data dari API';
                return;
            }

            // Decode JSON response
            $data = json_decode($response, true);

            // Periksa jika decoding JSON berhasil
            if (json_last_error() !== JSON_ERROR_NONE) {
                echo 'Gagal decode JSON';
                return;
            }

            $response = array();

            if ($data['numberExists'] == true) {
                $this->db->where('id', $row->id);
                $result['update'] = $this->db->update('fdk_contact', array('status' => 1));
                $response[] = $result;
            } else {
                $this->db->where('id', $row->id);
                $result['update'] = $this->db->update('fdk_contact', array('status' => 2));
                $response[] = $result;
            }
            echo json_encode($response);
        }
    }
}
