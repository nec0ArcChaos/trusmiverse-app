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
        $end_date   = $this->input->get('end_date');
        $user_id    = $this->input->get('user_id');

        $projects = $this->model_beranda->get_gantt_projects($start_date, $end_date, $user_id);
        $data = [];

        foreach ($projects as $p) {
            $tasks     = $this->model_beranda->get_gantt_tasks($p['id'], $start_date, $end_date, $user_id);
            $task_list = [];

            foreach ($tasks as $t) {
                $start    = !empty($t['start_date']) ? $t['start_date'] : null;
                $deadline = !empty($t['deadline'])   ? $t['deadline']   : null;
                $end      = !empty($t['end_date'])   ? $t['end_date']   : null;

                $pic_id = str_replace(' ', '', $t['pic']);

                $task_list[] = [
                    'id'             => (int)$t['id'],
                    'type'           => 'task',
                    'text'           => $t['task_name'] ?? 'Untitled Task',
                    'company'        => $p['company_name'] ?? '-',
                    'pic_id'         => $pic_id,
                    'pic'            => $this->model_beranda->get_employee_initials($pic_id ?? ''),
                    'requester_id'   => $p['product_owner'] ?? '',
                    'requester'      => $this->model_beranda->get_employee_initials($p['product_owner'] ?? ''),
                    'spv_id'         => $t['spv'] ?? '',
                    'spv'            => $this->model_beranda->get_employee_initials($t['spv'] ?? ''),
                    'pm_id'          => $t['pm'] ?? '',
                    'pm'             => $this->model_beranda->get_employee_initials($t['pm'] ?? ''),
                    'status'         => $t['status_name'] ?? 'Not Started',
                    'status_icon'    => $t['status_icon'] ?? 'bi-search',
                    'status_style'   => $t['status_style'],
                    'category'       => $t['category_name'] ?? '-',
                    'category_style' => $t['category_style'],
                    'progress'       => (int)($t['progress'] ?? 0),
                    'start'          => $start,
                    'end'            => $deadline,
                    'tglSelesai'     => $end,
                    'estimasi'       => (int)($t['est_day'] ?? 0),
                    'color'          => $t['status_color'] ?? 'bar-blue',
                    'note'           => $t['note'] ?? '',
                    'evidence_count' => (int)($t['evidence_count'] ?? 0),
                    'score'          => (int)($t['score'] ?? 0),
                    // FIX: kirim updated_at ke frontend untuk optimistic locking
                    'updated_at'     => $t['updated_at'] ?? null,
                ];
            }

            $data[] = [
                'id'             => (int)$p['id'],
                'type'           => 'project',
                'text'           => $p['project_name'] ?? 'Untitled Project',
                'company'        => $p['company_name'] ?? '-',
                'company_style'  => $p['company_style'],
                'pic_id'         => '',
                'pic'            => '',
                'requester_id'   => $p['product_owner'] ?? '',
                'requester'      => $this->model_beranda->get_employee_initials($p['product_owner'] ?? ''),
                'spv_id'         => $p['spv'] ?? '',
                'spv'            => $this->model_beranda->get_employee_initials($p['spv'] ?? ''),
                'pm_id'          => $p['pm'] ?? '',
                'pm'             => $this->model_beranda->get_employee_initials($p['pm'] ?? ''),
                'status'         => $p['status_name'] ?? 'Not Started',
                'status_icon'    => $p['status_icon'] ?? 'bi-search',
                'status_style'   => $p['status_style'],
                'category'       => '-',
                'progress'       => 0,
                'start'          => $p['start_date'],
                'end'            => $p['deadline'],
                'tglSelesai'     => $p['end_date'],
                'estimasi'       => (int)($p['est_day'] ?? 0),
                'color'          => $p['status_color'] ?? 'bar-blue',
                'expanded'       => true,
                'note'           => $p['note'] ?? '',
                'evidence_count' => (int)($p['evidence_count'] ?? 0),
                // FIX: kirim updated_at ke frontend untuk optimistic locking
                'updated_at'     => $p['updated_at'] ?? null,
                'tasks'          => $task_list,
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
            'start_date'   => $this->input->post('start'),
            'deadline'     => $this->input->post('end'),
            'color'        => $this->input->post('color'),
            'status'       => $this->model_beranda->resolve_status_id($this->input->post('status')) ?? 1,
            'created_by'   => $this->session->userdata('user_id'),
        ];
        $id = $this->model_beranda->insert_project($data);
        echo json_encode(['status' => 'success', 'id' => $id]);
    }

    public function ajax_add_task()
    {
        $data = [
            'project_id' => $this->input->post('project_id'),
            'task_name'  => $this->input->post('text'),
            'start_date' => $this->input->post('start'),
            'deadline'   => $this->input->post('end'),
            'progress'   => $this->input->post('progress') ?? 0,
            'status'     => $this->model_beranda->resolve_status_id($this->input->post('status')) ?? 1,
            'category'   => $this->model_beranda->resolve_category_id($this->input->post('category')),
            'week'       => $this->input->post('week'),
            'created_by' => $this->session->userdata('user_id'),
        ];
        if ($this->input->post('menu') == 'tasklist_project') {
            $data['pic'] = $this->session->userdata('user_id');
        }
        $id = $this->model_beranda->insert_task($data);
        echo json_encode(['status' => 'success', 'id' => $id]);
    }

    // ─────────────────────────────────────────────────────────────────────
    // FIX: ajax_update_item tetap ada untuk satu-field update (backward-compat)
    // ─────────────────────────────────────────────────────────────────────
    public function ajax_update_item()
    {
        $id         = $this->input->post('id');
        $type       = $this->input->post('type');
        $field      = $this->input->post('field');
        $value      = $this->input->post('value');
        $updated_at = $this->input->post('updated_at'); // FIX: terima updated_at untuk conflict check

        $map = [
            'text'      => ($type == 'project' ? 'project_name' : 'task_name'),
            'start'     => 'start_date',
            'end'       => 'deadline',
            'tglSelesai' => 'end_date',
            'estimasi'  => 'est_day',
            'progress'  => 'progress',
            'status'    => 'status',
            'company'   => 'company_id',
            'color'     => 'color',
            'pic'       => 'pic',
            'requester' => 'product_owner',
            'week'      => 'week',
            'note'      => 'note',
            'spv'       => 'spv',
            'pm'        => 'pm',
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

        $update_data = [
            $db_field    => $db_value,
            'updated_by' => $this->session->userdata('user_id'),
        ];

        // FIX: optimistic locking — cek apakah record sudah diupdate user lain
        if ($updated_at) {
            $conflict = $this->model_beranda->check_conflict($id, $type, $updated_at);
            if ($conflict) {
                echo json_encode([
                    'status'  => 'conflict',
                    'message' => 'Data sudah diubah oleh pengguna lain. Refresh untuk melihat data terbaru.',
                ]);
                return;
            }
        }

        if ($type == 'project') {
            $result = $this->model_beranda->update_project($id, $update_data);
        } else {
            $result = $this->model_beranda->update_task($id, $update_data);
        }

        // Progress history
        if ($db_field == 'progress') {
            $note    = $this->input->post('note');
            $history = [
                'task_id'    => ($type == 'task'    ? $id : null),
                'project_id' => ($type == 'project' ? $id : null),
                'progress'   => $db_value,
                'note'       => $note,
                'updated_by' => $this->session->userdata('user_id'),
            ];
            $this->model_beranda->insert_progress_history($history);
        }

        // FIX: kembalikan updated_at baru supaya frontend bisa update snapshot-nya
        $new_updated_at = $this->model_beranda->get_updated_at($id, $type);
        echo json_encode([
            'status'     => 'success',
            'result'     => $result,
            'updated_at' => $new_updated_at,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────
    // FIX: endpoint baru — update banyak field sekaligus (atomic batch)
    //      Dipakai untuk drag (start+end+week) dan completion (progress+status+tglSelesai)
    // ─────────────────────────────────────────────────────────────────────
    public function ajax_update_batch()
    {
        $raw     = file_get_contents('php://input');
        $payload = json_decode($raw, true);

        if (!$payload || empty($payload['id']) || empty($payload['type']) || empty($payload['fields'])) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid payload']);
            return;
        }

        $id         = (int)$payload['id'];
        $type       = $payload['type'];
        $fields     = $payload['fields'];   // array: [ ['field'=>'start','value'=>'2025-01-01'], ... ]
        $updated_at = $payload['updated_at'] ?? null;
        $note       = $payload['note'] ?? '';

        // FIX: optimistic locking check sebelum batch update
        if ($updated_at) {
            $conflict = $this->model_beranda->check_conflict($id, $type, $updated_at);
            if ($conflict) {
                echo json_encode([
                    'status'  => 'conflict',
                    'message' => 'Data sudah diubah oleh pengguna lain. Refresh untuk melihat data terbaru.',
                ]);
                return;
            }
        }

        $map = [
            'text'       => ($type == 'project' ? 'project_name' : 'task_name'),
            'start'      => 'start_date',
            'end'        => 'deadline',
            'tglSelesai' => 'end_date',
            'estimasi'   => 'est_day',
            'progress'   => 'progress',
            'status'     => 'status',
            'company'    => 'company_id',
            'color'      => 'color',
            'pic'        => 'pic',
            'requester'  => 'product_owner',
            'week'       => 'week',
            'note'       => 'note',
            'spv'        => 'spv',
            'pm'         => 'pm',
        ];

        $update_data = ['updated_by' => $this->session->userdata('user_id')];
        $has_progress = false;
        $progress_val = null;

        foreach ($fields as $f) {
            $field    = $f['field'];
            $db_field = $map[$field] ?? $field;
            $db_value = $f['value'];

            if ($field == 'status') {
                $db_value = $this->model_beranda->resolve_status_id($db_value);
            } elseif ($field == 'company') {
                $db_value = $this->model_beranda->resolve_company_id($db_value);
            } elseif ($field == 'category') {
                if ($type == 'project') continue; // kategori project diabaikan
                $db_value = $this->model_beranda->resolve_category_id($db_value);
            }

            $update_data[$db_field] = $db_value;

            if ($db_field == 'progress') {
                $has_progress = true;
                $progress_val = $db_value;
            }
        }

        // Satu query update — atomic
        if ($type == 'project') {
            $result = $this->model_beranda->update_project($id, $update_data);
        } else {
            $result = $this->model_beranda->update_task($id, $update_data);
        }

        // Progress history (satu kali, bukan per field)
        if ($has_progress) {
            $history = [
                'task_id'    => ($type == 'task'    ? $id : null),
                'project_id' => ($type == 'project' ? $id : null),
                'progress'   => $progress_val,
                'note'       => $note,
                'updated_by' => $this->session->userdata('user_id'),
            ];
            $this->model_beranda->insert_progress_history($history);
        }

        $new_updated_at = $this->model_beranda->get_updated_at($id, $type);
        echo json_encode([
            'status'     => 'success',
            'result'     => $result,
            'updated_at' => $new_updated_at,
        ]);
    }

    public function ajax_delete()
    {
        $id   = $this->input->post('id');
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
        $id    = $this->input->post('id');
        $type  = $this->input->post('type');
        $items = $this->model_beranda->get_evidence($id, $type);
        echo json_encode(['status' => 'success', 'data' => $items]);
    }

    public function ajax_upload_evidence()
    {
        $task_id    = $this->input->post('task_id');
        $project_id = $this->input->post('project_id');
        $type       = $this->input->post('type');

        $data = [
            'task_id'    => $task_id    ?: null,
            'project_id' => $project_id ?: null,
            'type'       => $type,
            'created_by' => $this->session->userdata('user_id'),
        ];

        if ($type == 'url') {
            $url = $this->input->post('evidence_url');
            if (!$url) {
                echo json_encode(['status' => 'error', 'message' => 'URL is required']);
                return;
            }
            $data['evidence_path'] = $url;
        } else {
            $upload_path = 'uploads/project_management/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }

            $config['upload_path']   = $upload_path;
            $config['allowed_types'] = 'gif|jpg|jpeg|png|webp|svg|pdf|doc|docx|xls|xlsx|ppt|pptx|csv|txt|zip|rar|7z|mp4|mp3|html';
            $config['max_size']      = 20480;
            $config['file_name']     = time() . '_' . $_FILES['evidence_file']['name'];

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('evidence_file')) {
                echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors('', '')]);
                return;
            } else {
                $upload_data           = $this->upload->data();
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
            $end_date   = date('Y-m-t');
        }

        $stats = $this->model_beranda->get_dashboard_stats($start_date, $end_date);

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($stats));
    }

    public function get_gantt_view()
    {
        $user_id = $this->session->userdata('user_id');
        $row     = $this->model_beranda->get_gantt_view($user_id);
        echo json_encode($row ?: (object)[]);
    }

    public function save_gantt_view()
    {
        $user_id = $this->session->userdata('user_id');
        $raw     = file_get_contents('php://input');
        $payload = json_decode($raw, true);
        if (!$payload || !$user_id) {
            echo json_encode(['status' => 'error']);
            return;
        }

        $allowed = ['column_order', 'hidden_columns', 'column_widths', 'frozen_columns', 'sort_field', 'sort_dir', 'grid_width'];
        $data    = [];
        foreach ($allowed as $k) {
            if (!isset($payload[$k])) continue;
            $data[$k] = is_array($payload[$k]) ? json_encode($payload[$k]) : $payload[$k];
        }

        $this->model_beranda->save_gantt_view($user_id, $data);
        echo json_encode(['status' => 'success']);
    }
}
