<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Table extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("complaints/model_table", "model_table");
        $this->load->helper('hashids');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function dt_complaints()
    {
        $start = $this->input->post('start') ?? date("Y-m-01");
        $end   = $this->input->post('end') ?? date("Y-m-d");
        $filter_category = $this->input->post('filter_category') ?? "";
        $filter_pic = $this->input->post('filter_pic') ?? "";
        $response['data'] = "";
        if ($start != "" && $end != "") {
            $data = $this->model_table->dt_complaints($start, $end, $filter_category, $filter_pic);
            foreach ($data as $row) {
                // encrypt id_task
                $row->id_task_encrypted = hashids_encode($row->id_task);
            }
            $response['data'] = $data;
        }
        echo json_encode($response);
    }

    public function print_complaint($id_task)
    {
        $data['complaint'] = $this->model_table->get_complaints_by_id($id_task);
        // echo json_encode($response);

        $this->load->view("complaints/table/print_komplain", $data);
    }
}
