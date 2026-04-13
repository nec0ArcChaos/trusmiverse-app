<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Improvement_audit extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->library('Whatsapp_lib');
        $this->load->model('Model_improvement_audit', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    function index()
    {
        $data['pageTitle']        = "Improvement Audit";
        $data['css']              = "improvement_audit/css";
        $data['js']               = "improvement_audit/js";
        $data['content']          = "improvement_audit/index";
        $data['plan'] 			  = $this->model->get_plan();
        $this->load->view('layout/main', $data);
    }

    public function print($id_plan)
    {
        $data['improvement'] = $this->model->get_improvement_audit_detail($id_plan);
        
        $this->load->view("improvement_audit/print", $data);
    }

    function get_plan()
	{
		$plan = @$_POST['plan'];
		$data['plan'] = $this->model->get_plan($plan);
        header('Content-type:application/json');
		echo json_encode($data);
	}

    function get_improvement_audit() 
    {
        $start 	= @$_REQUEST['start'];
		$end 	= @$_REQUEST['end'];

        $data['data'] = $this->model->get_improvement_audit($start, $end);
        header('Content-type:application/json');
		echo json_encode($data);
    }

    function save_improvement()
	{
		$id_imp = $this->model->generate_id_imp();

        if (@$_FILES['file']) {
            $config['upload_path']   = './uploads/audit_temuan/';
            $config['allowed_types'] = '*';
            $config['max_size']      = 0;
            $path = $_FILES['file']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $file_name = str_replace('#', '', $path);
            $file_name = str_replace($ext, '', $file_name);
            $config['file_name']	 = $file_name . date('ymdHis') . '.' . $ext;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file')) {
                $file = $this->upload->display_errors();
            } else {
                $file_file 	= $this->upload->data();
                $name		= $file_file['raw_name'] . $file_file['file_ext'];
                if (isset($file_file['file_name'])) {
                    $file = $file_file['file_name'];
                } else {
                    $file = '';
                }
            }
            $data = trim(preg_replace('/\s\s+/', '', $file));
        } else {
            $data = null;
        }

		$data = array(
			'id_imp' 		=> $id_imp,
			'id_plan' 		=> $_POST['plan'],
			'tindak_lanjut' 		=> $_POST['tindak_lanjut'],
			'improvement' 		=> $_POST['improvement'],
			'attachment' 		=> $data,
			'created_by' 		=> $this->session->userdata('user_id'),
			'created_at' 		=> date('Y-m-d H:i:s')
		);

		$result['insert_audit_improvement'] 	= $this->db->insert("audit_improvement", $data);
		echo json_encode($result);
	}
}