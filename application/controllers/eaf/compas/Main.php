<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('compas/model_campaign', 'model_campaign');
        $this->load->database();
    }
    public function index()
    {
        $menu = $this->input->get('menu');
        $detail_id = $this->input->get('detail_id');
        $kanban_status = $this->db->get('m_cmp_kanban_status')->result_array();
        $sub_status = $this->db->get('m_cmp_sub_status')->result_array();

        $data = [
            'menu' => $menu,
            'detail_id' => $detail_id,
            'kanban_status' => $kanban_status,
            'sub_status' => $sub_status,
        ];
        $this->load->view('compas/layout/main', $data);
    }
    public function get_global_activity_logs()
    {
        header('Content-Type: application/json');

        $search = $this->input->post('search');
        $date_range = $this->input->post('date_range');

        $this->db->select('t_cmp_activity_logs.*, xin_employees.first_name, xin_employees.last_name');
        $this->db->from('t_cmp_activity_logs');
        $this->db->join('xin_employees', 't_cmp_activity_logs.user_id = xin_employees.user_id', 'left');

        if ($search) {
            $this->db->group_start();
            $this->db->like('t_cmp_activity_logs.description', $search);
            $this->db->or_like('t_cmp_activity_logs.action_type', $search);
            $this->db->or_like('t_cmp_activity_logs.phase', $search);
            $this->db->group_end();
        }

        if ($date_range) {
            $dates = explode(' - ', $date_range);
            if (count($dates) == 2) {
                $start_date = date('Y-m-d', strtotime($dates[0]));
                $end_date = date('Y-m-d', strtotime($dates[1]));
                $this->db->where('DATE(t_cmp_activity_logs.created_at) >=', $start_date);
                $this->db->where('DATE(t_cmp_activity_logs.created_at) <=', $end_date);
            }
        }

        $this->db->limit(20);
        $this->db->order_by('t_cmp_activity_logs.created_at', 'DESC');

        $query = $this->db->get();
        $logs = $query->result_array();

        echo json_encode(['status' => true, 'data' => $logs]);
    }
}