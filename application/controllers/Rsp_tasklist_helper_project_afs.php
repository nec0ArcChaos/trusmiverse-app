<?php
defined('BASEPATH') or exit('No direct script access allowed');


/*
Company : RSP
Menu    : Tasklist Helper Project Aftersales
terhubung dengan : http://192.168.23.195/rspproject/tasklist_helper_project_afs
*/


class Rsp_tasklist_helper_project_afs extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_rsp_tasklist_helper_project_afs', 'model');

        $previus_link = $this->uri->segment(1);
        if ($this->session->userdata('user_id') != "") {
        } else {
            if ($previus_link != "") {
                $data_session = array(
                    "previus_link" => $previus_link
                );
                $this->session->set_userdata($data_session);
            }
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']        = "Tasklist Helper Project Aftersales / Estate";
        $data['title']            = "<span class='text-gradient'>Tasklist Helper Project Aftersales / Estate</span>";
        $data['css']              = "rsp_tasklist_helper_project_afs/css";
        $data['js']               = "rsp_tasklist_helper_project_afs/js";
        $data['content']          = "rsp_tasklist_helper_project_afs/index";
        $this->load->view('layout/main', $data);
    }

    function data_tasklist()
    {
        $start     = $_POST['start'];
        $end       = $_POST['end'];
        $tipe      = 1; // Get Data All
        $id_user = $_SESSION['user_id'];

        $result['data'] = $this->model->data_tasklist($start, $end, $tipe, $id_user, null)->result();
        echo json_encode($result);
    }

    function data_proses()
    {
        $tipe    = 2; // Get Data Proses
        $id_user = $_SESSION['user_id'];
        $result['data'] = $this->model->data_tasklist(null, null, $tipe, $id_user, null)->result();
        echo json_encode($result);
    }

    function data_proses_detail($no_ph)
    {
        $tipe   = 3; // Get Proses Detail
        $id_user = $_SESSION['user_id'];
        $result = $this->model->data_tasklist(null, null, $tipe, $id_user, $no_ph)->row();
        echo json_encode($result);
    }

    // Update Proses Tasklist
    function update_tasklist()
    {
        $no_ph          = $_POST['no_ph_proses'];
        $status         = $_POST['status'];
        $foto_proses    = $_POST['foto_proses'];
        $note_proses    = $_POST['note_proses'];
        $updated_at     = date('Y-m-d H:i:s');
        $updated_by     = $_SESSION['user_id'];

        if ($status == 1) { // dari Waiting update ke Progres
            $data = array(
                "foto_start"    => $foto_proses,
                "note_start"    => $note_proses,
                "status"        => 2,
                "start_at"      => $updated_at,
                "start_by"      => $updated_by
            );
        } else if ($status == 2) { // dari Progres update ke Done
            $data = array(
                "foto_end"          => $foto_proses,
                "note_end"          => $note_proses,
                "status"            => 3,
                "end_at"            => $updated_at,
                "end_by"            => $updated_by,
                "status_approval"   => null,
                "note_approval"     => null,
                "approval_at"       => null,
                "approval_by"       => null
            );
        }

        $this->db->where("no_ph", $no_ph);
        $result['update']     = $this->db->update("rsp_project_live.t_helper_project_afs", $data);

        echo json_encode($result);
    }
}
