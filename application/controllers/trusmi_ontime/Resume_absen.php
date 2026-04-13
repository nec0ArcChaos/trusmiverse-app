<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Resume_absen extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("model_dashboard");
        $this->load->model("model_dashboard_ibr_pro");
        $this->load->model("Model_dashboard_ibr_pro_calendar");
        $this->load->model("hr/model_rekap_absen", "model_rekap_absen");
        $this->load->model("model_absen", "absen");
        $this->load->model('Model_monday', 'monday');
    }

    public function index()
    {

        $periode = $this->input->post('periode');
        $user_id = $this->input->post('user_id');
        $emp = $this->db->query("SELECT company_id, department_id, designation_id FROM xin_employees WHERE user_id = '$user_id'")->row();
        $company_id = $emp->company_id;
        $department_id = $emp->department_id;
        $designation_id = $emp->designation_id;

        $month = date("m", strtotime($periode));
        if ($designation_id == 731) {
            if ($month == date("m") && date("d") <= date("t")) {
                $end_harus_hadir = date("Y-m-d", strtotime(date("Y-m-d") . " -1 days"));
            } else {
                $end_harus_hadir = date("Y-m-t", strtotime($periode . "-01"));
            }
        } else if ($month == date("m") && date("d") <= 20) {
            $end_harus_hadir = date("Y-m-d", strtotime(date("Y-m-d") . " -1 days"));
        } else {
            if ($company_id == 3) {
                $end_harus_hadir = date("Y-m-16", strtotime($periode . "-01"));
            } else {
                $end_harus_hadir = date("Y-m-20", strtotime($periode . "-01"));
            }
        }

        $today = date("Y-m-d", strtotime($periode));
        $start = date("Y-m-21", strtotime($today . " -1 months"));
        $end = date("Y-m-20", strtotime($periode));
        $sub_emp = 0;

        if ($designation_id == 731) {
            $start          = date($periode . "-01");
            $end            = date($periode . "-t");
            $response['end_cok'] = substr(date("Y-m-t"), 8, 2);
        } else if ($company_id == 3) {
            if ($month == date("m") && date("d") <= 20) {
                $start          = date("Y-m-16", strtotime("-1 month", strtotime(date($periode . '-d'))));
            } else {
                $start          = date("Y-m-16", strtotime("-1 month", strtotime(date($periode . '-30'))));
            }
            $end            = date($periode . "-15");
        } else {
            if ($month == date("m") && date("d") <= 20) {
                $start          = date("Y-m-21", strtotime("-1 month", strtotime(date($periode . '-d'))));
            } else {
                $start          = date("Y-m-21", strtotime("-1 month", strtotime(date($periode . '-30'))));
            }
            $end            = date($periode . "-20");
        }

        $response['resume'] = $this->model_rekap_absen->get_absensi($start, $end_harus_hadir, $company_id, $department_id, $user_id,  $sub_emp)->row(0);
        $response['month'] =  $month;
        $response['periode'] = $periode;
        $response['today'] = $today;
        $response['start'] = $start;
        $response['end_today'] = $end_harus_hadir;
        $response['start'] = $start;
        $response['end'] = $end;
        echo json_encode($response);
    }
}
