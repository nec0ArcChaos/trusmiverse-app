<?php defined('BASEPATH') or exit('No direct script access allowed');


class Sosi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('Filter');
        $this->load->library('Whatsapp_lib');
        $this->load->model('Model_sosi', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']        = "Strategi Objektif - Strategi Inisiatif";
        $data['css']              = "sosi/css";
        $data['js']               = "sosi/js";
        $data['content']          = "sosi/index";

        $this->load->view('layout/main', $data);
    }

    public function get_strategi_objektif()
    {
        $response = $this->model->get_strategi_objektif();
        echo json_encode($response);
    }

    public function get_strategi_inisiatif()
    {
        $response = $this->model->get_strategi_inisiatif();
        echo json_encode($response);
    }

    public function get_strategi_task()
    {
        $response = $this->model->get_strategi_task();
        echo json_encode($response);
    }

    public function get_strategi_ketercapaian()
    {
        $response = $this->model->get_strategi_ketercapaian();
        echo json_encode($response);
    }

    public function get_detail_ketercapaian()
    {
        $response = $this->model->get_detail_ketercapaian();
        echo json_encode($response);
    }

    public function dt_sosi()
    {
        $response['data'] = $this->model->dt_sosi();
        echo json_encode($response);
    }

    public function dt_detail_ketercapaian()
    {
        $response['data'] = $this->model->dt_detail_ketercapaian();
        echo json_encode($response);
    }

    public function save()
    {
        if (!empty($_FILES['file']['name'])) {

            // Proses unggah file
            $config['upload_path']   = './uploads/sosi/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
            $new_name = time();
            $config['file_name']     = $this->session->userdata('user_id') . "_" . $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file')) {
                $response['error'] = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data['upload_data']['file_name'];
            }
        } else {
            $file_name = "";
        }

        $week = $this->model->get_week();

        $data = array(
            'ketercapaian'      => $this->filter->sanitaze_input($this->input->post('ketercapaian')),
            'status'            => $this->filter->sanitaze_input($this->input->post('status')),
            'actual'            => $this->filter->sanitaze_input($this->input->post('actual')),
            'resume'            => $this->filter->sanitaze_input($this->input->post('resume')),
            'file'              => $file_name,
            'link'              => $this->filter->sanitaze_input($this->input->post('link')),
            'created_at'        => date("Y-m-d H:i:s"),
            'created_by'        => $this->session->userdata('user_id'),
            'periode'           => date("Y-m"),
            'week'              => $week
        );
        $response['status']     = 'success';
        $response['message']    = 'success';
        $response['update']     = $this->db->insert('t_strategi_actual', $data);
        echo json_encode($response);
    }
}
