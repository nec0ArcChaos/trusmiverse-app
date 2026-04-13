<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Table_dev extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("tickets/model_table_dev", "model_table");
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function dt_tickets()
    {
        $start = $this->input->post('start') ?? date("Y-m-01");
        $end   = $this->input->post('end') ?? date("Y-m-d");
        $filter_type = $this->input->post('filter_type') ?? "";
        $filter_pic = $this->input->post('filter_pic') ?? "";
        $filter_status = $this->input->post('filter_status') ?? "";
        $response['data'] = "";
        if ($start != "" && $end != "") {
            $response['data'] = $this->model_table->dt_tickets($start, $end, $filter_type, $filter_pic, $filter_status);
        }
        echo json_encode($response);
    }
}
