<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Input_head_event extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->model('Model_input_head');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }
    function index()
    {
        $user = $this->session->userdata('user_id');
        $data['pageTitle'] = "Update Event Head";
        $data['css'] = "input_head_event/css";
        $data['js'] = "input_head_event/js";
        $data['content'] = "input_head_event/index";
        $this->load->view('layout/main', $data);
    }
    function grd()
    {
        $user = $this->session->userdata('user_id');
        $data['pageTitle'] = "Update Event Head";
        $data['css'] = "input_head_event/css";
        $data['js'] = "input_head_event/grd_js";
        $data['content'] = "input_head_event/grd";
        $this->load->view('layout/main', $data);
    }
    public function get_mom()
    {
        $this->load->model('Model_input_head');
        $data = $this->Model_input_head->get_mom();
        
        echo json_encode(['data' => $data]); // DataTables butuh key 'data'
    }
public function save_mom_week()
{
    $week   = $this->input->post('week');
    $id_mom = $this->input->post('id_mom');

    $user_id = $this->session->userdata('user_id'); // SESUAI SESSION LO

    $data = [
        'ids'        => $id_mom,
        'freq'       => $week,
        'tipe'       => 'MOM',
        'created_by' => $user_id,
        'created_at'=> date('Y-m-d H:i:s')
    ];

    $this->db->insert('head_t_event_upload', $data);

    echo json_encode(['status' => true]);
}



 public function upload_grd()
{
    try {
        $validationRule = [
            'file_grd' => [
                'label' => 'File Dokumen',
                'rules' => 'uploaded[file_grd]|max_size[file_grd,10240]|ext_in[file_grd,pdf,xls,xlsx,csv]',
            ],
        ];

        if (!$this->validate($validationRule)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $this->validator->getError('file_grd')
            ]);
        }

        $file = $this->request->getFile('file_grd');

        if (!$file->isValid()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'File tidak valid'
            ]);
        }

        $uploadPath = ROOTPATH . '../uploads/grd/evidence';
        if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);

        $fileName = 'GRD_' . time() . '_' . $file->getClientName();

        if (!$file->move($uploadPath, $fileName)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal memindahkan file'
            ]);
        }

        $model  = new EventModel();
        $userId = session()->get('user_id') ?? 1;

        $data = [
            'tipe'       => 'GRD',
            'freq'       => 1,
            'periode'    => '2026-01',
            'files'      => $fileName,
            'created_by' => $userId,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if (!$model->insert($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menyimpan data ke database'
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Dokumen GRD Berhasil diproses!'
        ]);

    } catch (\Throwable $e) {
        return $this->response->setStatusCode(500)
            ->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
    }
}

}