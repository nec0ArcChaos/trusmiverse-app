<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class ClassUpload extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('image_lib');
    }

    public function upload_file() {

        $url = $this->input->post('url');
        $now = time();
        $config['upload_path']          = $url;
        $config['allowed_types']        = 'jpg|jpeg|png';
        $config['max_size']             = 7000;
        $config['file_name']             = $now;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('photo')) {
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
        } else {
            $data = $this->upload->data();

            // Cek ukuran file, jika lebih besar dari 500KB, kompresi
            if ($data['file_size'] > 500) {
                $this->compress_image($data['full_path']);
            }

            echo json_encode([
                'file_path' => $data['full_path'],
                'upload_data' => $data
            ]);
        }
    }
    private function compress_image($path) {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $path;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 900;
        $config['quality']       = '80%';  // Kompresi kualitas gambar

        $this->image_lib->clear();
        $this->image_lib->initialize($config);

        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
        }
    }
}