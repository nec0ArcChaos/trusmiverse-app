<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gantt extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("tickets/model_gantt", "model_gantt");
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function dt_gantt()
    {
        $start = $this->input->post('start') ?? date("Y-m-01");
        $end   = $this->input->post('end') ?? date("Y-m-d");
        $filter_type = $this->input->post('filter_type') ?? "";
        $filter_pic = $this->input->post('filter_pic') ?? "";
        $filter_status = $this->input->post('filter_status') ?? "";
        $response['data'] = "";
        if ($start != "" && $end != "") {
            $response['data_type'] = $this->model_gantt->dt_gantt_type_dev($start, $end, $filter_type, $filter_pic, $filter_status);
            $response['data_sub_type'] = $this->model_gantt->dt_gantt_sub_type_dev($start, $end, $filter_type, $filter_pic, $filter_status);
            $response['data_tickets'] = $this->model_gantt->dt_gantt_tickets_dev($start, $end, $filter_type, $filter_pic, $filter_status);
        }
        echo json_encode($response);
    }
}
