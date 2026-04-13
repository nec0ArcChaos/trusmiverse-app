<?php defined('BASEPATH') or exit('No direct script access allowed');


class Bsc_task extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('Filter');
        $this->load->library('Whatsapp_lib');
        $this->load->model('Model_bsc_task', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']        = "Tasklist BSC";
        $data['css']              = "bsc_task/css";
        $data['js']               = "bsc_task/js";
        $data['content']          = "bsc_task/index";

        $this->load->view('layout/main', $data);
    }

    function data_all_tasklist()
    {
        $periode    = $_POST['periode'];
        $pic        = $this->session->userdata('user_id');

        $data['data'] = $this->model->data_all_tasklist($periode, $pic);
        echo json_encode($data);
    }

    function data_tasklist()
    {
        $periode    = $_POST['periode'];
        $frekuensi  = $_POST['frekuensi'];
        $user_id    = $this->session->userdata('user_id');

        $data['data'] = $this->model->data_tasklist($periode, $frekuensi, $user_id);
        echo json_encode($data);
    }

    function data_tasklist_item_history()
    {
        $periode    = $_POST['periode'];
        $id  = $_POST['id'];

        $data['data'] = $this->model->data_tasklist_item_history($periode, $id);
        echo json_encode($data);
    }

    function insert_task()
    {
        if (!empty($_FILES['task_file']['name'])) {

            // Proses unggah file
            $config['upload_path']   = './uploads/tasklist/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
            $new_name = time();
            $config['file_name']     = $this->session->userdata('user_id') . "_" . $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('task_file')) {
                $response['error'] = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data['upload_data']['file_name'];
            }
        } else {
            $file_name = "";
        }

        $task = array(
            'actual'        => $this->filter->sanitaze_input($_POST['task_actual']),
            'achieve'       => $this->filter->sanitaze_input($_POST['task_acv']),
            'status'        => $this->filter->sanitaze_input($_POST['task_status']),
            'lampiran'      => $file_name,
            'link'          => $this->filter->sanitaze_input($_POST['task_link']),
            'resume'        => $this->filter->sanitaze_input($_POST['task_resume']),
            'updated_at'    => date('Y-m-d H:i:s'),
            'updated_by'    => $this->session->userdata('user_id')
        );

        $this->db->where('id', $_POST['task_id_task']);

        $result['update'] = $this->db->update('bsc_tasklist', $task);

        $task_item = $this->model->get_task_item($_POST['task_id_task']);

        $task_history = array(
            'id_task'           => $task_item['id'],
            'id_si'             => $task_item['id_si'],
            'id_so'             => $task_item['id_so'],
            'jabatan'           => $task_item['jabatan'],
            'pic'               => $task_item['pic'],
            'strategy'          => $task_item['strategy'],
            'target'            => $task_item['target'],
            'actual'            => $task_item['actual'],
            'achieve'           => $task_item['achieve'],
            'tasklist'          => $task_item['tasklist'],
            'actual_tasklist'   => $task_item['actual_tasklist'],
            'persen_tasklist'   => $task_item['persen_tasklist'],
            'status'            => $task_item['status'],
            'periode'           => $task_item['periode'],
            'lampiran'          => $task_item['lampiran'],
            'frekuensi'         => $task_item['frekuensi'],
            'link'              => $task_item['link'],
            'resume'            => $task_item['resume'],
            'spend'             => $task_item['spend'],
            'updated_by'        => $task_item['updated_by'],
            'updated_at'        => $task_item['updated_at'],
        );

        $result['insert'] = $this->db->insert('bsc_tasklist_h', $task_history);

        echo json_encode($result);
    }
}
