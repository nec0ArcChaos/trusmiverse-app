<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Head_division extends CI_Controller
{

    private $api_key = 'ittrusmi2025hd!';
    function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        // $this->load->library('FormatJson');

        $this->_check_auth();
        $this->load->model('api/Model_head_division', 'model');
    }

    private function _check_auth()
    {
        $token_header = $this->input->get_request_header('X-API-KEY', TRUE);
        $token_param = $this->input->get('key');
        $input_token = !empty($token_header) ? $token_header : $token_param;
        if ($input_token !== $this->api_key) {
            $this->output->set_status_header(401);
            $this->output->set_content_type('application/json');
            echo json_encode([
                'status' => false,
                'message' => 'Akses Ditolak: Token tidak valid atau tidak ditemukan.',
                'error_code' => 401
            ]);
            exit;
        }
    }


    public function mom($id_mom)
    {
        $header = $this->model->mom_header($id_mom);
        $task = $this->model->mom_task($id_mom);
        $data = (array) $header;
        $data['task'] = $task;
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function genba($id_mom)
    {
        $header = $this->model->genba_header($id_mom);
        $task = $this->model->genba_task($id_mom);
        $data = (array) $header;
        $data['task'] = $task;
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function coaching($id)
    {
        $data = $this->model->coaching($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function sharing_leader($id)
    {
        $data = $this->model->sharing_leader($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function briefing($id)
    {
        $data = $this->model->briefing($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function improvement($id)
    {
        $data = $this->model->improvement($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    
    public function insert()
    {
        $upload_path = './uploads/head_event/';
        
        // Cek apakah folder sudah ada, jika belum buat folder-nya
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $config['upload_path']   = $upload_path;
        $config['allowed_types'] = 'pdf|jpg|jpeg|png|doc|docx|xls|xlsx'; // Sesuaikan kebutuhan
        $config['max_size']      = 5120; // 5MB
        $config['encrypt_name']  = TRUE; // Rename file jadi hash (aman & unik)

        $this->load->library('upload', $config);

        // --- B. PROSES UPLOAD ---
        $filename = null; // Default null jika tidak ada file

        // 'files' adalah nama key di Postman/Form input type="file"
        if (!empty($_FILES['files']['name'])) {
            if (!$this->upload->do_upload('files')) {
                // Gagal Upload
                $this->output->set_status_header(400);
                echo json_encode([
                    'status' => false, 
                    'message' => 'Upload Gagal: ' . $this->upload->display_errors('', '')
                ]);
                return;
            } else {
                // Berhasil Upload
                $upload_data = $this->upload->data();
                $filename = $upload_data['file_name'];
            }
        }
        $pic = $this->input->post('pic');
        $tipe = $this->input->post('tipe');
        $periode = $this->input->post('periode');
        $freq = $this->input->post('freq');
        $ids = $this->input->post('ids');
        

        // Ambil Items (Detail Penilaian)
        $items_input = $this->input->post('items');
        $items_data = [];
        if (is_string($items_input)) {
            $items_data = json_decode($items_input, true);
        }
        else if (is_array($items_input)) {
            $items_data = $items_input;
        }

        // 3. Validasi Basic
        if (empty($pic) || empty($items_data)) {
            $this->output->set_status_header(400);
            echo json_encode(['status' => false, 'message' => 'Data PIC dan Items tidak boleh kosong']);
            return;
        }
        $data_header = [
            'pic'     => $pic,
            'tipe'    => $tipe,
            'periode' => $periode,
            'freq'    => $freq,
            'files'   => $filename, // Nama file hasil upload
            'ids'     => $ids
        ];
        $result = $this->model->insert_data($data_header, $items_data);
        if ($result['status']) {
            $this->model->update_bobot($result['id_event']);
            $this->output->set_status_header(201);
            echo json_encode([
                'status' => true,
                'message' => 'Data berhasil disimpan',
                'data' => [
                    'id_event' => $result['id_event'],
                    'file_uploaded' => $filename
                ]
            ]);
        } else {
            // Jika database gagal, hapus file yang sudah terlanjur diupload (Cleanup)
            if ($filename && file_exists($upload_path . $filename)) {
                unlink($upload_path . $filename);
            }
            
            $this->output->set_status_header(500);
            echo json_encode(['status' => false, 'message' => $result['msg']]);
        }
    }

    public function update()
    {
        // 1. Ambil ID Event (Kunci Utama)
        $id_event = $this->input->post('id_event');

        if (empty($id_event)) {
            $this->output->set_status_header(400);
            echo json_encode(['status' => false, 'message' => 'ID Event wajib diisi untuk proses update.']);
            return;
        }

        // --- A. PROSES UPLOAD (Logika Sama dengan Insert) ---
        $upload_path = './uploads/head_event/';
        if (!is_dir($upload_path)) mkdir($upload_path, 0777, true);

        $config['upload_path']   = $upload_path;
        $config['allowed_types'] = 'pdf|jpg|jpeg|png|doc|docx|xls|xlsx';
        $config['max_size']      = 5120; // 5MB
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);

        $filename = null; // Default null (artinya tidak ada file baru)

        // Cek apakah ada file baru yang dikirim
        if (!empty($_FILES['files']['name'])) {
            if (!$this->upload->do_upload('files')) {
                $this->output->set_status_header(400);
                echo json_encode([
                    'status' => false, 
                    'message' => 'Upload Gagal: ' . $this->upload->display_errors('', '')
                ]);
                return;
            } else {
                $upload_data = $this->upload->data();
                $filename = $upload_data['file_name'];
            }
        }

        // --- B. AMBIL DATA FORM ---
        $pic     = $this->input->post('pic');
        $tipe    = $this->input->post('tipe');
        $periode = $this->input->post('periode');
        $freq    = $this->input->post('freq');
        $ids     = $this->input->post('ids');

        // Ambil Items
        $items_input = $this->input->post('items');
        $items_data = [];
        if (is_string($items_input)) {
            $items_data = json_decode($items_input, true);
        } else if (is_array($items_input)) {
            $items_data = $items_input;
        }

        // Validasi
        if (empty($pic) || empty($items_data)) {
            // Hapus file baru jika validasi gagal
            if ($filename && file_exists($upload_path . $filename)) unlink($upload_path . $filename);

            $this->output->set_status_header(400);
            echo json_encode(['status' => false, 'message' => 'Data PIC dan Items tidak boleh kosong']);
            return;
        }

        // Siapkan Data Header
        $data_header = [
            'pic'     => $pic,
            'tipe'    => $tipe,
            'periode' => $periode,
            'freq'    => $freq,
            'files'   => $filename, // Bisa NULL (jika tidak update file) atau String (jika update file)
            'ids'     => $ids
        ];

        // --- C. PANGGIL MODEL UPDATE ---
        // Kita kirim $upload_path juga agar Model bisa menghapus file lama fisik
        $result = $this->model->update_data($id_event, $data_header, $items_data, $upload_path);

        if ($result['status']) {
            $this->model->update_bobot($id_event);
            $this->output->set_status_header(200);
            echo json_encode([
                'status' => true,
                'message' => 'Data berhasil diperbarui',
                'data' => [
                    'id_event' => $id_event,
                    'file_info' => $filename ? 'File diperbarui' : 'File tidak berubah'
                ]
            ]);
        } else {
            // Jika DB gagal, hapus file BARU yang terlanjur diupload
            if ($filename && file_exists($upload_path . $filename)) {
                unlink($upload_path . $filename);
            }

            $this->output->set_status_header(500);
            echo json_encode(['status' => false, 'message' => $result['msg']]);
        }
    }

    public function data_mom()
    {
        $periode = $_POST['periode'] ?? date('Y-m');
        $pic = $_POST['pic'];
        $tipe = $this->input->post('tipe');
        $data['data'] = $this->model->data_mom($periode, $pic, $tipe) ?? [];
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    
    public function data_genba()
    {
        $periode = $_POST['periode'] ?? date('Y-m');
        $pic = $_POST['pic'];
        $tipe = $this->input->post('tipe');
        $data['data'] = $this->model->data_genba($periode, $pic, $tipe) ?? [];
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function data_coaching()
    {
        $periode = $_POST['periode'] ?? date('Y-m');
        $pic = $_POST['pic'];
        $tipe = $this->input->post('tipe');
        $data['data'] = $this->model->data_coaching($periode, $pic, $tipe) ?? [];
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function data_sharing_leader()
    {
        $periode = $_POST['periode'] ?? date('Y-m');
        $pic = $_POST['pic'];
        $tipe = $this->input->post('tipe');
        $data['data'] = $this->model->data_sharing_leader($periode, $pic, $tipe) ?? [];
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function data_grd(){
        $periode = $_POST['periode'] ?? date('Y-m');
        $pic = $_POST['pic'];
        $data['data'] = $this->model->data_grd($periode, $pic) ?? [];
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function data_interview(){
        $periode = $_POST['periode'] ?? date('Y-m');
        $pic = $_POST['pic'];
        $data['data'] = $this->model->data_interview($periode, $pic) ?? [];
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function data_improvment_system(){
        $periode = $_POST['periode'] ?? date('Y-m');
        $pic = $_POST['pic'];
        $data['data'] = $this->model->data_improvment_system($periode, $pic) ?? [];
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function data_briefing(){
        $periode = $_POST['periode'] ?? date('Y-m');
        $pic = $_POST['pic'];
        $data['data'] = $this->model->data_briefing($periode, $pic) ?? [];
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function data_event_item(){
        $periode = $_POST['periode'] ?? date('Y-m');
        $pic = $_POST['pic'];
        $tipe = $this->input->post('tipe');
        if ($tipe == 'sharing_leader') {
            $tipe = 'sharing leader';
        } else if ($tipe == 'improvment_system') {
            $tipe = 'Improvement System';
        }

        $week = $this->input->post('week');
        $data['data'] = $this->model->data_event_item($periode, $pic, $tipe, $week) ?? [];
        $data['header'] =  $this->model->data_event_header($periode, $pic, $tipe, $week);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function data_achieve(){
        $periode = $_POST['periode'] ?? date('Y-m');
        $divisi = @$_POST['divisi'] ?? null;
        if ($divisi == 'all') {
            $divisi = null;
        }
        $data['data'] = $this->model->data_achieve($periode, $divisi) ?? [];
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function data_resume(){
        $periode = $_POST['periode'] ?? date('Y-m');
        $divisi = @$_POST['divisi'] ?? null;
        if ($divisi == 'all') {
            $divisi = null;
        }
        $data['data'] = $this->model->data_resume($periode, $divisi) ?? [];
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function data_event_header(){
        $periode = $_POST['periode'] ?? date('Y-m');
        $pic = $_POST['pic'];
        $tipe = $this->input->post('tipe');
        $week = $this->input->post('week');
        $data['data'] = $this->model->data_event_header($periode, $pic, $tipe, $week) ?? [];
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function data_file(){
        $file = $this->input->post('file');
        // $data['data'] = $this->model->data_file($id_event) ?? [];
        header('Content-Type: application/json');
        echo json_encode('https://trusmiverse.com/dashboard_mm/uploads/grd/'.$file);
    }

    public function update_bobot($id_event)
    {
        $result = $this->model->update_bobot($id_event);

        echo json_encode($result);
    }
}