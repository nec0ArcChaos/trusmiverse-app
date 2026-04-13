<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('project_management/model_beranda', 'model_beranda');
        $this->load->database();
        if ($this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
        // $session_dummy = $this->db->select('user_id, employee, username, password, profile_picture, is_active, company_id, department_id, designation_id, jabatan, posisi, user_role_id, contact_no, cutoff')->where('user_id', 2063)->get('view_user')->row();
        // $this->session->set_userdata('user_id', 2063);
        // $this->session->set_userdata('username', $session_dummy->username);
        // $this->session->set_userdata('password', $session_dummy->password);
        // $this->session->set_userdata('nama', $session_dummy->employee);
        // $this->session->set_userdata('profile_picture', $session_dummy->profile_picture);
        // $this->session->set_userdata('company_id', $session_dummy->company_id);
        // $this->session->set_userdata('department_id', $session_dummy->department_id);
        // $this->session->set_userdata('designation_id', $session_dummy->designation_id);
        // $this->session->set_userdata('jabatan', $session_dummy->jabatan);
    }
    public function index()
    {
        $menu = $this->input->get('menu');
        // $detail_id = $this->input->get('detail_id');
        // $kanban_status = $this->model_beranda->get_kanban_status();
        // $sub_status = $this->model_beranda->get_sub_status();

        $data = [
            'menu' => $menu,
            // 'detail_id' => $detail_id,
            // 'kanban_status' => $kanban_status,
            // 'sub_status' => $sub_status,
        ];
        $this->load->view('project_management/layout/main', $data);
    }

    public function get_capaian_data()
    {
        $month = $this->input->get('month');
        $year = $this->input->get('year');

        // Mock data logic
        // If year is 2023, return empty to show "no data" state
        if ($year == '2023') {
            $data = [
                'summary' => [
                    'total_projects' => 0,
                    'completed' => 0,
                    'in_progress' => 0,
                    'avg_achievement' => 0,
                    'leadtime_percent' => 0,
                    'achievement_percent' => 0,
                    'tasklist_done' => 0,
                    'tasklist_total' => 0,
                    'ticket_done' => 0,
                    'ticket_total' => 0,
                ],
                'projects' => []
            ];
        } else {
            $data = [
                'summary' => [
                    'total_projects' => 12,
                    'completed' => 5,
                    'in_progress' => 7,
                    'avg_achievement' => 68,
                    'overall_kpi' => '99%',
                    'total_tasklist' => 240,
                    'total_attendance' => 24,
                    'total_alfa' => 10,
                    'total_tardy' => 5,
                    'total_leave' => 4,
                    'leadtime_percent' => 90,
                    'achievement_percent' => 50,
                    'tasklist_done' => 2,
                    'tasklist_total' => 20,
                    'ticket_done' => 15,
                    'ticket_total' => 20,
                ],
                'projects' => [
                    [
                        'name' => 'Website E-Commerce',
                        'category' => 'Web Development',
                        'status' => 'In Progress',
                        'progress' => 75,
                        'last_update' => '2024-03-20'
                    ],
                    [
                        'name' => 'Sistem Payroll',
                        'category' => 'Enterprise System',
                        'status' => 'Completed',
                        'progress' => 100,
                        'last_update' => '2024-03-15'
                    ],
                    [
                        'name' => 'Mobile App Sales',
                        'category' => 'Mobile App',
                        'status' => 'In Progress',
                        'progress' => 45,
                        'last_update' => '2024-03-18'
                    ],
                    [
                        'name' => 'Data Migration Phase 2',
                        'category' => 'Data Engineering',
                        'status' => 'In Progress',
                        'progress' => 90,
                        'last_update' => '2024-03-21'
                    ],
                    [
                        'name' => 'API Integration Partner X',
                        'category' => 'Backend Services',
                        'status' => 'Completed',
                        'progress' => 100,
                        'last_update' => '2024-03-10'
                    ]
                ]
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
