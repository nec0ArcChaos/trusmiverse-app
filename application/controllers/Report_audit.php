<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Report_audit extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        $this->load->library("session");
        $this->load->model('Model_report_audit', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    function index()
    {
        $data['content']             = "report_audit/index";
        $data['pageTitle']             = "Report Audit";
        $data['css']                 = "report_audit/css";
        $data['js']                 = "report_audit/js";
        // $data['category']            = $this->model->get_master('category');
        // $data['priority']            = $this->model->get_master('priority');
        // $data['status']                = $this->model->get_master('status');

        $this->load->view("layout/main", $data);
    }

    function dt_report()
    {
        $start     = $_POST['start'];
        $end     = $_POST['end'];

        $result['data'] = $this->model->dt_report($start, $end);
        echo json_encode($result);
    }

    function save_report()
    {

        $id        = $this->model->generate_id_report_audit();
        $note      = $_POST['note'];
        $created_at        = date("Y-m-d H:i:s");
        $created_by        = $_SESSION['user_id'];

        if (!empty($_FILES['attachment']['name'])) {
            // Proses unggah file
            $config['upload_path']   = './uploads/report_audit/';
            // $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
            $config['allowed_types'] = '*';
            $new_name = $id . '_' . time();
            $config['file_name']     = $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('attachment')) {
                $response['error'] = array('error' => $this->upload->display_errors());
                $file_name = $this->upload->display_errors();
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data['upload_data']['file_name'];
            }
        } else {
            $file_name = "";
        }

        $data = array(
            "id_report"           => $id,
            "status"             => 1,
            "attachment"         => $file_name,
            "created_at"         => $created_at,
            "created_by"         => $created_by,
            "note"               => $note,
        );

        $result['insert_report'] = $this->db->insert("report_audit_finance", $data);
        echo json_encode($result);
    }

    function dt_waiting_report()
    {
        // $start     = date('Y-m-d');
        // $end     = date('Y-m-d');

        $result['data'] = $this->model->dt_waiting_report();
        echo json_encode($result);
    }

    function save_verif_report()
    {
        $id_report       = $_POST['id_report'];
        $status_verif    = $_POST['status'];
        $note      = $_POST['note_verif'];
        $approved_at     = date("Y-m-d H:i:s");
        $approved_by     = $_SESSION['user_id'];

        // if (!empty($_FILES['file_verif']['name'])) {
        //     // Proses unggah file
        //     $config['upload_path']   = './uploads/pph21/';
        //     // $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
        //     $config['allowed_types'] = '*';
        //     $new_name = 'verif_' . $id_pajak . '_' . time();
        //     $config['file_name']     = $new_name;
        //     $this->load->library('upload', $config);

        //     if (!$this->upload->do_upload('file_verif')) {
        //         $response['error'] = array('error' => $this->upload->display_errors());
        //         $file_name = $this->upload->display_errors();
        //     } else {
        //         $data = array('upload_data' => $this->upload->data());
        //         $file_name = $data['upload_data']['file_name'];
        //     }
        // } else {
        //     $file_name = "";
        // }

        $data_update = array(
            "status"             => $status_verif,
            // "verified_file"         => $file_name,
            "approved_at"         => $approved_at,
            "approved_by"         => $approved_by,
            "approved_note"       => $note,
        );

        $this->db->where("id_report", $id_report);
        $result['update_report'] = $this->db->update("report_audit_finance", $data_update);
        echo json_encode($result);
    }

    // ------------------------------------------------------------------------------------



    function save_pph21()
    {

        $id        = $this->model->generate_id_pph21();
        $note      = $_POST['note'];
        $created_at        = date("Y-m-d H:i:s");
        $created_by        = $_SESSION['user_id'];

        if (!empty($_FILES['attachment']['name'])) {
            // Proses unggah file
            $config['upload_path']   = './uploads/pph21/';
            // $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
            $config['allowed_types'] = '*';
            $new_name = $id . '_' . time();
            $config['file_name']     = $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('attachment')) {
                $response['error'] = array('error' => $this->upload->display_errors());
                $file_name = $this->upload->display_errors();
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data['upload_data']['file_name'];
            }
        } else {
            $file_name = "";
        }

        $data = array(
            "id_pajak"           => $id,
            "status"             => 1,
            "attachment"         => $file_name,
            "created_at"         => $created_at,
            "created_by"         => $created_by,
            "note"               => $note,
        );

        $result['insert_pph21'] = $this->db->insert("trusmi_pph21", $data);
        echo json_encode($result);
    }

    function list_pph21()
    {
        $start     = $_POST['start'];
        $end     = $_POST['end'];

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
        $id_pajak       = $_POST['id_pajak'];
        $note           = $_POST['note_verif'];
        $verified_at     = date("Y-m-d H:i:s");
        $verified_by     = $_SESSION['user_id'];

        if (!empty($_FILES['file_verif']['name'])) {
            // Proses unggah file
            $config['upload_path']   = './uploads/pph21/';
            // $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
            $config['allowed_types'] = '*';
            $new_name = 'verif_' . $id_pajak . '_' . time();
            $config['file_name']     = $new_name;
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
            "status"             => 2,
            "verified_file"         => $file_name,
            "verified_at"         => $verified_at,
            "verified_by"         => $verified_by,
            "note"               => $note,
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
        $id_pajak       = $_POST['id_pajak_paid'];
        $note           = $_POST['note_paid'];
        $paid_at        = date("Y-m-d H:i:s");
        $paid_by        = $_SESSION['user_id'];

        if (!empty($_FILES['file_paid']['name'])) {
            // Proses unggah file
            $config['upload_path']   = './uploads/pph21/';
            // $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
            $config['allowed_types'] = '*';
            $new_name = 'paid_' . $id_pajak . '_' . time();
            $config['file_name']     = $new_name;
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
            "status"             => 3, // Paid
            "paid_file"         => $file_name,
            "paid_at"         => $paid_at,
            "paid_by"         => $paid_by,
            "note"               => $note,
        );

        $this->db->where("id_pajak", $id_pajak);
        $result['update_pph21'] = $this->db->update("trusmi_pph21", $data_update);
        echo json_encode($result);
    }
}
