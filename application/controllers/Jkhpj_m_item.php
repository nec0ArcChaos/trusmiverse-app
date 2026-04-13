<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jkhpj_m_item extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("model_jkhpj_m_item", 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }


    public function index()
    {
        $user_id = $this->session->userdata("user_id");
        $data['pageTitle']        = "Master JKHPJ";
        $data['css']              = "jkhpj_m_item/css";
        $data['content']          = "jkhpj_m_item/index";
        $data['js']               = "jkhpj_m_item/js";
        $data['user_id'] = $user_id;
        $data['companies'] = $this->model->get_company();
        if (!in_array($user_id, [1, 2, 6466, 4498, 2521, 3651, 4770, 4954, 5121, 6717, 8305, 3690, 1186, 321, 4499])) {
            redirect('jkhpj', 'refresh');
        }
        $this->load->view('layout/main', $data);
    }

    // function get_company()
    // {
    //     $data['company'] = $this->model->get_company();
    //     header('Content-type: application/json');
    //     echo json_encode($data);
    // }

    function get_department()
    {
        $id = $_POST['id'];
        $data['department'] = $this->model->get_department($id);
        header('Content-type: application/json');
        echo json_encode($data);
    }

    function get_designation()
    {
        $company_id = $_POST['company_id'];
        $department_id = $_POST['department_id'];
        $data['designation'] = $this->model->get_designation($company_id, $department_id);
        header('Content-type: application/json');
        echo json_encode($data);
    }

    function dt_jkhpj_m_item()
    {
        $data['data'] = $this->model->dt_jkhpj_m_item();
        header('Content-type: application/json');
        echo json_encode($data);
    }

    function dt_jkhpj_m_item_detail()
    {
        $designation = $_POST['designation_id'];
        $data['data'] = $this->model->dt_jkhpj_m_item_detail($designation);
        header('Content-type: application/json');
        echo json_encode($data);
    }

    function simpan_item()
    {
        if (isset($_POST['tasklist'])) {
            for ($i = 0; $i < count($_POST['tasklist']); $i++) {
                $dt_jkhpj = [
                    'designation_id' => $_POST['designation_id'],
                    'is_file' => $_POST['is_file'][$i],
                    'tasklist' => $_POST['tasklist'][$i],
                    'description' => $_POST['description'][$i],
                    'time_start' => $_POST['time_start'][$i],
                    'time_end' => $_POST['time_end'][$i],
                ];

                $insert = $this->db->insert('jkhpj_m_item', $dt_jkhpj);
            }


            $data['insert'] = $insert;
            header('Content-type: application/json');
            echo json_encode($data);
        } else {
            $data['insert'] = false;
            header('Content-type: application/json');
            echo json_encode($data);
        }
    }

    function update_item()
    {
        // Ambil data dari POST
        $id = $this->input->post('id_jkhpj_item');
        $data = [
            'tasklist'    => $this->input->post('tasklist'),
            'description' => $this->input->post('description'),
            'time_start'  => $this->input->post('time_start'),
            'time_end'    => $this->input->post('time_end'),
            'is_file'     => $this->input->post('is_file'),
        ];

        // Panggil fungsi model untuk update
        $update = $this->model->update_item($id, $data);

        // Kirim response
        header('Content-type: application/json');
        echo json_encode(['update' => $update]);
    }
}
