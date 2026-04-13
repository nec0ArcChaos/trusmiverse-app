<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard_kpi_head_bt extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_dashboard_kpi_head_bt', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']        = "Dashboard KPI Head BT";
        $data['css']              = "dashboard_kpi_head_bt/css";
        $data['js']               = "dashboard_kpi_head_bt/js";
        $data['content']          = "dashboard_kpi_head_bt/index";

        // $data['start']      = date("Y-m-21", strtotime("-1 month", strtotime(date('Y-m-d'))));
        // $data['end']        = date("Y-m-20");

        // $data['tanggal_periode']  = $this->model->tanggal_periode(1,2)->result();
        // $data['get_company']  = $this->model->get_company()->result();
        
        $this->load->view('layout/main', $data);
    }

    public function get_kpi_bt_operasional($periode)
    {
        $data = $this->model->get_kpi_bt_operasional($periode);
        print_r($data);
    }

    // ========================= END ============================

    // Traffic System Overview
    public function resume_traffic_system_overview($periode)
    {
        $data = $this->model->resume_traffic_system_overview($periode);
        echo json_encode($data);
    }

    // List table traffic system overview
    public function dt_traffic_system()
    {
        $periode     = $_POST['periode'];

        $result['data'] = $this->model->dt_traffic_system_overview($periode);
        echo json_encode($result);
    }

    // Progress Review System
    public function resume_progress_review_system($periode)
    {
        $data = $this->model->resume_progress_review_system($periode);
        echo json_encode($data);
    }

    // List Sistem yg sudah direview dan belum direview
    public function get_system_reviewed_notreviewed($periode)
    {
        $data['reviewed'] = $this->model->dt_system_reviewed($periode);
        $data['not_reviewed'] = $this->model->dt_system_not_reviewed($periode);
        
        echo json_encode($data);
    }


    // Ticket per Divisi
    public function dt_ticket_perdivisi()
    {
        $periode     = $_POST['periode'];

        $result['data'] = $this->model->dt_ticket_perdivisi($periode);
        echo json_encode($result);
    }

    // Statistik progres tiket
    public function get_pencapaian_progres_tiket($periode)
    {
        $data = $this->model->get_pencapaian_progres_tiket($periode);
        echo json_encode($data);
    }

    public function get_tracking_system_error()
    {
        $periode = $this->input->post('periode');
        
        $data = $this->model->get_tracking_system_error($periode);
        echo json_encode($data);
    }
    
    public function get_list_ticket_error()
    {
        $periode = $this->input->post('periode');
        
        $data = $this->model->get_list_ticket_error($periode);
        echo json_encode($data);
    }

    public function get_resume_ticket_by_pic()
    {
        $periode     = $_POST['periode'];

        $result['data'] = $this->model->get_resume_ticket_by_pic($periode);
        echo json_encode($result);
    }

    // Kepuasan Pengguna
    public function list_kepuasan_pengguna()
    {
        $periode = $this->input->post('periode');
        
        $data = $this->model->list_kepuasan_pengguna($periode);
        echo json_encode($data);
    }

}
