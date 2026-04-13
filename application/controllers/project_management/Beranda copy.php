<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Beranda extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('project_management/model_beranda', 'model_beranda');
        $this->load->database();
    }
    public function index()
    {
        $this->load->view('project_management/menus/beranda');
    }

    public function get_gantt_data()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $user_id = $this->input->get('user_id');
        
        $projects = $this->model_beranda->get_gantt_projects($start_date, $end_date, $user_id);
        $data = [];

        foreach ($projects as $p) {
            $tasks = $this->model_beranda->get_gantt_tasks($p['id'], $start_date, $end_date, $user_id);
            $task_list = [];
            
            foreach ($tasks as $t) {
                // Ensure dates are formatted correctly or null
                $start = !empty($t['start_date']) ? $t['start_date'] : null;
                $deadline = !empty($t['deadline']) ? $t['deadline'] : null;
                $end = !empty($t['end_date']) ? $t['end_date'] : null;

                $task_list[] = [
                    'id' => (int)$t['id'],
                    'type' => 'task',
                    'text' => $t['task_name'] ?? 'Untitled Task',
                    'company' => $p['company_name'] ?? '-',
                    'pic_id' => $t['pic'] ?? '',
                    'pic' => $this->model_beranda->get_employee_initials($t['pic'] ?? ''),
                    'requester_id' => $p['product_owner'] ?? '',
                    'requester' => $this->model_beranda->get_employee_initials($p['product_owner'] ?? ''),
                    'spv_id' => $t['spv'] ?? '',
                    'spv' => $this->model_beranda->get_employee_initials($t['spv'] ?? ''),
                    'pm_id' => $t['pm'] ?? '',
                    'pm' => $this->model_beranda->get_employee_initials($t['pm'] ?? ''),
                    'status' => $t['status_name'] ?? 'Not Started',
                    'status_icon' => $t['status_icon'] ?? 'bi-search',
                    'status_style' => $t['status_style'],
                    'category' => $t['category_name'] ?? '-',
                    'category_style' => $t['category_style'],
                    'progress' => (int)($t['progress'] ?? 0),
                    'start' => $start,
                    'end' => $deadline,
                    'tglSelesai' => $end,
                    'estimasi' => (int)($t['est_day'] ?? 0),
                    'color' => $t['status_color'] ?? 'bar-blue',
                    'note' => $t['note'] ?? '',
                    'evidence_count' => (int)($t['evidence_count'] ?? 0),
                    'score' => (int)($t['score'] ?? 0)
                ];
            }

            $data[] = [
                'id' => (int)$p['id'],
                'type' => 'project',
                'text' => $p['project_name'] ?? 'Untitled Project',
                'company' => $p['company_name'] ?? '-',
                'company_style' => $p['company_style'],
                'pic_id' => '', // Accumulated in JS
                'pic' => '', // Accumulated in JS
                'requester_id' => $p['product_owner'] ?? '',
                'requester' => $this->model_beranda->get_employee_initials($p['product_owner'] ?? ''),
                'spv_id' => $p['spv'] ?? '',
                'spv' => $this->model_beranda->get_employee_initials($p['spv'] ?? ''),
                'pm_id' => $p['pm'] ?? '',
                'pm' => $this->model_beranda->get_employee_initials($p['pm'] ?? ''),
                'status' => $p['status_name'] ?? 'Not Started',
                'status_icon' => $p['status_icon'] ?? 'bi-search',
                'status_style' => $p['status_style'],
                'category' => '-',
                'progress' => 0, // Calculated in JS
                'start' => $p['start_date'],
                'end' => $p['deadline'],
                'tglSelesai' => $p['end_date'],
                'estimasi' => (int)($p['est_day'] ?? 0),
                'color' => $p['status_color'] ?? 'bar-blue',
                'expanded' => true,
                'note' => $p['note'] ?? '',
                'evidence_count' => (int)($p['evidence_count'] ?? 0),
                'tasks' => $task_list
            ];
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_lookup_options()
    {
        $data = $this->model_beranda->get_lookup_options();
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    public function ajax_add_project()
    {
        $data = [
            'project_name' => $this->input->post('text'),
            'start_date' => $this->input->post('start'),
            'deadline' => $this->input->post('end'),
            'color' => $this->input->post('color'),
            'status' => $this->model_beranda->resolve_status_id($this->input->post('status')) ?? 1
        ];
        $id = $this->model_beranda->insert_project($data);
        echo json_encode(['status' => 'success', 'id' => $id]);
    }

    public function ajax_add_task()
    {
        $data = [
            'project_id' => $this->input->post('project_id'),
            'task_name' => $this->input->post('text'),
            'start_date' => $this->input->post('start'),
            'deadline' => $this->input->post('end'),
            'progress' => $this->input->post('progress') ?? 0,
            'status' => $this->model_beranda->resolve_status_id($this->input->post('status')) ?? 1,
            'category' => $this->model_beranda->resolve_category_id($this->input->post('category')),
            'week' => $this->input->post('week')
        ];
        $id = $this->model_beranda->insert_task($data);
        echo json_encode(['status' => 'success', 'id' => $id]);
    }

    public function ajax_update_item()
    {
        $id = $this->input->post('id');
        $type = $this->input->post('type'); // 'project' or 'task'
        $field = $this->input->post('field');
        $value = $this->input->post('value');

        // Map JS fields to DB columns
        $map = [
            'text' => ($type == 'project' ? 'project_name' : 'task_name'),
            'start' => 'start_date',
            'end' => 'deadline',
            'tglSelesai' => 'end_date',
            'estimasi' => 'est_day',
            'progress' => 'progress',
            'status' => 'status',
            'company' => 'company_id',
            'color' => 'color',
            'pic' => 'pic',
            'requester' => 'product_owner',
            'spv' => 'spv',
            'pm' => 'pm',
            'week' => 'week',
            'score' => 'score'
        ];

        $db_field = $map[$field] ?? $field;
        $db_value = $value;

        if ($field == 'status') {
            $db_value = $this->model_beranda->resolve_status_id($value);
        } elseif ($field == 'company') {
            $db_value = $this->model_beranda->resolve_company_id($value);
        } elseif ($field == 'category') {
            if ($type == 'project') {
                echo json_encode(['status' => 'success']);
                return;
            }
            $db_value = $this->model_beranda->resolve_category_id($value);
        }

        $update_data = [$db_field => $db_value];

        if ($type == 'project') {
            $this->model_beranda->update_project($id, $update_data);
        } else {
            $this->model_beranda->update_task($id, $update_data);
        }

        echo json_encode(['status' => 'success']);
    }
    public function ajax_delete()
    {
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        
        if ($id && $type) {
            $this->model_beranda->delete_item($id, $type);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
        }
    }

    public function ajax_get_evidence()
    {
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $items = $this->model_beranda->get_evidence($id, $type);
        echo json_encode(['status' => 'success', 'data' => $items]);
    }

    public function ajax_upload_evidence()
    {
        $task_id = $this->input->post('task_id');
        $project_id = $this->input->post('project_id');
        $type = $this->input->post('type');
        
        $data = [
            'task_id' => $task_id ?: null,
            'project_id' => $project_id ?: null,
            'type' => $type,
            'created_by' => $this->session->userdata('user_id')
        ];

        if ($type == 'url') {
            $url = $this->input->post('evidence_url');
            if (!$url) {
                echo json_encode(['status' => 'error', 'message' => 'URL is required']);
                return;
            }
            $data['evidence_path'] = $url;
        } else {
            // file upload
            $upload_path = 'uploads/project_management/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }

            $config['upload_path']   = $upload_path;
            $config['allowed_types'] = 'gif|jpg|jpeg|png|webp|svg|pdf|doc|docx|xls|xlsx|ppt|pptx|csv|txt|zip|rar|7z|mp4|mp3|html';
            $config['max_size']      = 20480; // 20MB
            $config['file_name']     = time() . '_' . $_FILES['evidence_file']['name'];

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('evidence_file')) {
                echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors('','')]);
                return;
            } else {
                $upload_data = $this->upload->data();
                $data['evidence_path'] = $upload_path . $upload_data['file_name'];
            }
        }

        $this->model_beranda->insert_evidence($data);
        echo json_encode(['status' => 'success']);
    }

    public function ajax_delete_evidence()
    {
        $id = $this->input->post('id');
        $ev = $this->model_beranda->get_evidence_by_id($id);
        
        if ($ev) {
            if ($ev->type == 'file' && file_exists($ev->evidence_path)) {
                unlink($ev->evidence_path);
            }
            $this->model_beranda->delete_evidence($id);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function ajax_dashboard_stats()
    {
        $start_date = $this->input->post('start_date');
        $end_date   = $this->input->post('end_date');
        
        if (empty($start_date)) {
            $start_date = date('Y-m-01');
            $end_date = date('Y-m-t');
        }
        
        $stats = $this->model_beranda->get_dashboard_stats($start_date, $end_date);
        
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($stats));
    }
    public function get_gantt_view()
    {
        $user_id = $this->session->userdata('user_id');
        $row = $this->model_beranda->get_gantt_view($user_id);
        echo json_encode($row ?: (object)[]);
    }

    public function save_gantt_view()
    {
        $user_id = $this->session->userdata('user_id');
        $raw = file_get_contents('php://input');
        $payload = json_decode($raw, true);
        if (!$payload || !$user_id) { echo json_encode(['status'=>'error']); return; }

        $allowed = ['column_order','hidden_columns','column_widths','frozen_columns','sort_field','sort_dir','grid_width'];
        $data = [];
        foreach ($allowed as $k) {
            if (!isset($payload[$k])) continue;
            $data[$k] = is_array($payload[$k]) ? json_encode($payload[$k]) : $payload[$k];
        }

        $this->model_beranda->save_gantt_view($user_id, $data);
        echo json_encode(['status'=>'success']);
    }
}
