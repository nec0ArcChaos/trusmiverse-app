<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Pajak extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        $this->load->library("session");
        $this->load->model('Model_pajak', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    function index()
    {
        $data['content'] = "pajak/index";
        $data['pageTitle'] = "PAJAK";
        $data['css'] = "pajak/css";
        $data['js'] = "pajak/js";
        // $data['category']            = $this->model->get_master('category');
        // $data['priority']            = $this->model->get_master('priority');
        // $data['status']                = $this->model->get_master('status');

        $this->load->view("layout/main", $data);
    }

    function save_pph21()
    {
        $id = $this->model->generate_id_pph21();
        $note = $_POST['note'];
        $kategori_id = $_POST['kategori'];
        $created_at = date("Y-m-d H:i:s");
        $created_by = $_SESSION['user_id'];

        if (!empty($_FILES['attachment']['name'])) {
            $config['upload_path'] = './uploads/pph21/';
            $config['allowed_types'] = '*';
            $new_name = $id . '_' . time();
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('attachment')) {
                $response['error'] = array('error' => $this->upload->display_errors());
                $file_name = '';
            } else {
                $data_upload = $this->upload->data();
                $file_name = $data_upload['file_name'];
            }
        } else {
            $file_name = "";
        }

        $data = array(
            "id_pajak" => $id,
            "status" => 1,
            "attachment" => $file_name,
            "created_at" => $created_at,
            "created_by" => $created_by,
            "note" => $note,
            "category" => $kategori_id,
        );

        $result['insert_pph21'] = $this->db->insert("trusmi_pph21", $data);
        echo json_encode($result);
    }


    public function get_category_pph()
    {
        $query = $this->db->order_by('id', 'ASC')->get('trusmi_pph_category')->result();
        echo json_encode($query);
    }


    function list_pph21()
    {
        $start = $_POST['start'];
        $end = $_POST['end'];

        $result['data'] = $this->model->list_pph21($start, $end);
        echo json_encode($result);
    }

    function dt_verif_pph21()
    {
        // $start     = $_POST['start'];
        // $end     = $_POST['end'];
        $result['data'] = $this->model->dt_verif_pph21();
        echo json_encode($result);
    }

    function verif_pph21()
    {
        $id_pajak = $_POST['id_pajak'];
        $note = $_POST['note_verif'];
        $verified_at = date("Y-m-d H:i:s");
        $verified_by = $_SESSION['user_id'];

        $get_data = $this->db->get_where('trusmi_pph21', ['id_pajak' => $id_pajak])->row();
        $category = $get_data ? $get_data->category : null;

        if (!empty($_FILES['file_verif']['name'])) {
            $config['upload_path'] = './uploads/pph21/';
            $config['allowed_types'] = '*';
            $new_name = 'verif_' . $id_pajak . '_' . time();
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file_verif')) {
                $response['error'] = array('error' => $this->upload->display_errors());
                $file_name = $this->upload->display_errors();
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data['upload_data']['file_name'];
            }
        } else {
            $file_name = "";
        }

        $data_update = array(
            "status" => 2,
            "verified_file" => $file_name,
            "verified_at" => $verified_at,
            "verified_by" => $verified_by,
            "note" => $note,
            "category" => $category
        );

        $this->db->where("id_pajak", $id_pajak);
        $result['update_pph21'] = $this->db->update("trusmi_pph21", $data_update);
        echo json_encode($result);
    }


    function dt_paid_pph21()
    {
        $result['data'] = $this->model->dt_paid_pph21();
        echo json_encode($result);
    }

    function save_paid_pph21()
    {
        $id_pajak = $_POST['id_pajak_paid'];
        $note = $_POST['note_paid'];
        $paid_at = date("Y-m-d H:i:s");
        $paid_by = $_SESSION['user_id'];

        $get_data = $this->db->get_where('trusmi_pph21', ['id_pajak' => $id_pajak])->row();
        $category = $get_data ? $get_data->category : null;

        if (!empty($_FILES['file_paid']['name'])) {
            $config['upload_path'] = './uploads/pph21/';
            $config['allowed_types'] = '*';
            $new_name = 'paid_' . $id_pajak . '_' . time();
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file_paid')) {
                $response['error'] = array('error' => $this->upload->display_errors());
                $file_name = $this->upload->display_errors();
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data['upload_data']['file_name'];
            }
        } else {
            $file_name = "";
        }

        $data_update = array(
            "status" => 3,
            "paid_file" => $file_name,
            "paid_at" => $paid_at,
            "paid_by" => $paid_by,
            "note" => $note,
            "category" => $category
        );

        $this->db->where("id_pajak", $id_pajak);
        $result['update_pph21'] = $this->db->update("trusmi_pph21", $data_update);
        echo json_encode($result);
    }

    // ---------------------------------------------

    function save_proses_resume()
    {
        $id = $_POST['id_ps'];
        $status = $_POST['status_akhir'];
        $resume = $_POST['resume'];
        $updated_at = date("Y-m-d H:i:s");
        $updated_by = $_SESSION['user_id'];

        $data = array(
            "id_ps" => $id,
            "status" => $status,
            "resume" => $resume,
            "updated_at" => $updated_at,
            "updated_by" => $updated_by
        );

        $this->db->where("id_ps", $id);
        $result['update_resume'] = $this->db->update("ps_task", $data);

        $history = array(
            "ps_id" => $id,
            "status" => $status,
            "resume" => $resume,
            "created_at" => $updated_at,
            "created_by" => $updated_by
        );

        $result['insert_history'] = $this->db->insert("ps_task_history", $history);
        echo json_encode($result);
    }

    // function get_detail_problem($id)
    // {
    //     $result = $this->model->get_detail_problem($id);
    //     echo json_encode($result);
    // }
}
