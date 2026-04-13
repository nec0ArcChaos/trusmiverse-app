<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tasklist_problem extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('project_management/model_tasklist_problem', 'model_tasklist_problem');
        $this->load->database();
    }

    /**
     * Endpoint for getting tasklist problem data via AJAX
     */
    public function get_problem_data()
    {
        $periode = $this->input->post('periode');
        $user_id = $this->input->post('user_id');

        $tasklist_problems = $this->model_tasklist_problem->get_tasklist_problem($periode, $user_id);

        $late_tasks = [];
        $past_deadline = 0;
        $potential_late = 0;
        $unsolved_problem = 0;
        $processing_problem = 0;
        $solved_problem = 0;
        foreach ($tasklist_problems as $tasklist_problem) {
            if ($tasklist_problem->is_late == 1) {
                $past_deadline++;
            }
            if ($tasklist_problem->is_potential_late >= 1) {
                $potential_late++;
            }
            if ($tasklist_problem->status_problem == 'Belum Solved') {
                $unsolved_problem++;
            }
            if ($tasklist_problem->status_problem == 'Diproses') {
                $processing_problem++;
            }
            if ($tasklist_problem->status_problem == 'Solved') {
                $solved_problem++;
            }
            if ($tasklist_problem->is_late == 1) {
                $late_tasks[] = [
                    'id' => $tasklist_problem->id,
                    'task_name' => $tasklist_problem->task_name,
                    'task_code' => $tasklist_problem->task_code,
                    'category' => $tasklist_problem->category,
                    'pic' => $tasklist_problem->pic,
                    'pic_name' => $tasklist_problem->pic_name,
                    'deadline_req' => $tasklist_problem->deadline_req,
                    'deadline_hint' => $tasklist_problem->deadline_hint,
                    'progress' => $tasklist_problem->progress ?? 0,
                    'progress_text' => $tasklist_problem->progress ?? 'Not Started - 0%',
                    'need_input_problem' => $tasklist_problem->need_input_problem,
                    'problem_desc' => isset($tasklist_problem->problem_desc) && $tasklist_problem->problem_desc != '' ? substr($tasklist_problem->problem_desc, 0, 250) . '...' : substr('AI Smart Problem mengidentifikasi bahwa task ini telah melewati tenggat waktu (Overdue). Harap segera selesaikan atau tambahkan respon kendala.', 0, 250) . '...',
                    'problem_detail' => [
                        'desc' => $tasklist_problem->problem_desc != '' ? $tasklist_problem->problem_desc : 'AI Smart Problem mengidentifikasi bahwa task ini telah melewati tenggat waktu (Overdue). Harap segera selesaikan atau tambahkan respon kendala.',
                        'update' => $tasklist_problem->problem_note == '' && $tasklist_problem->problem_desc == '' ? 'Terdeteksi otomatis karena telah melewati deadline.' : $tasklist_problem->problem_note,
                        'reporter' => $tasklist_problem->problem_reporter != '' ? $tasklist_problem->problem_reporter : 'AI Smart Problem'
                    ],
                    'status' => $tasklist_problem->status_problem ?? 'Belum Solved',
                    'status_type' => in_array($tasklist_problem->status_problem ?? 'Belum Solved', ['Belum Solved', 'Diproses']) ? 'danger' : 'warning',
                    'est_completion' => $tasklist_problem->est_date,
                    'est_completion_hint' => $tasklist_problem->est_hint
                ];
            }
        }

        // 3. Dummy "Proyeksi Telat" data
        $projection_tasks = [];
        foreach ($tasklist_problems as $tasklist_problem) {
            if ($tasklist_problem->is_late == 0 && $tasklist_problem->is_potential_late >= 1) {
                $projection_tasks[] = [
                    'id' => $tasklist_problem->id,
                    'task_name' => $tasklist_problem->task_name,
                    'task_code' => $tasklist_problem->task_code,
                    'category' => $tasklist_problem->category,
                    'pic' => $tasklist_problem->pic,
                    'pic_name' => $tasklist_problem->pic_name,
                    'deadline_req' => $tasklist_problem->deadline_req,
                    'deadline_hint' => $tasklist_problem->deadline_hint,
                    'progress' => $tasklist_problem->progress ?? 0,
                    'progress_text' => $tasklist_problem->progress ?? 'Not Started - 0%',
                    'need_input_problem' => $tasklist_problem->need_input_problem,
                    'problem_desc' => isset($tasklist_problem->problem_desc) && $tasklist_problem->problem_desc != '' ? substr($tasklist_problem->problem_desc, 0, 250) . '...' : substr('AI Smart Problem mengidentifikasi bahwa task ini berpotensi terlambat berdasarkan progress saat ini dan urutan pekerjaannya. Perhatian khusus disarankan.', 0, 250) . '...',
                    'problem_detail' => [
                        'desc' => $tasklist_problem->problem_desc != '' ? $tasklist_problem->problem_desc : 'AI Smart Problem mengidentifikasi bahwa task ini berpotensi terlambat berdasarkan progress saat ini dan urutan pekerjaannya. Perhatian khusus disarankan.',
                        'update' => $tasklist_problem->problem_note != '' ? $tasklist_problem->problem_note : 'Terdeteksi otomatis sebagai proyeksi keterlambatan.',
                        'reporter' => $tasklist_problem->problem_reporter != '' ? $tasklist_problem->problem_reporter : 'AI Smart Problem'
                    ],
                    'status' => $tasklist_problem->status_problem ?? 'Belum Solved',
                    'status_type' => in_array($tasklist_problem->status_problem ?? 'Belum Solved', ['Belum Solved', 'Diproses']) ? 'danger' : 'warning',
                    'est_completion' => $tasklist_problem->est_date,
                    'est_completion_hint' => $tasklist_problem->est_hint
                ];
            }
        }

        $metrics = [
            'past_deadline' => $past_deadline,
            'potential_late' => $potential_late,
            'unsolved_problem' => $unsolved_problem,
            'processing_problem' => $processing_problem,
            'solved_problem' => $solved_problem
        ];

        // Return JSON response
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'success',
                'data' => [
                    'metrics' => $metrics,
                    'late_tasks' => $late_tasks,
                    'projection_tasks' => $projection_tasks
                ]
            ]));
    }

    /**
     * Endpoint for adding new problem
     */
    public function add_problem()
    {
        $task_id = $this->input->post('task_id_hidden') ? $this->input->post('task_id_hidden') : $this->input->post('task_id');
        $problem_desc = $this->input->post('problem_desc');
        $problem_note = $this->input->post('problem_note');
        $status = $this->input->post('status') ? $this->input->post('status') : 'Belum Solved';
        $est_date = $this->input->post('est_date') ? $this->input->post('est_date') : null;
        $user_id = $this->session->userdata('user_id') ? $this->session->userdata('user_id') : 'System';

        $existing = $this->model_tasklist_problem->get_problem_by_task($task_id);

        if ($existing) {
            $data = [
                'problem_desc' => $problem_desc,
                'status' => $status
            ];
            if ($problem_note) $data['problem_note'] = $problem_note;
            if ($est_date) $data['est_date'] = $est_date;

            $this->model_tasklist_problem->update_problem($task_id, $data);
            $problem_id = $existing->id;
        } else {
            $data = [
                'task_id' => $task_id,
                'problem_desc' => $problem_desc,
                'problem_note' => $problem_note,
                'status' => $status,
                'est_date' => $est_date,
                'created_by' => $user_id,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $problem_id = $this->model_tasklist_problem->add_problem($data);
        }

        $this->model_tasklist_problem->add_problem_history([
            'problem_id' => $problem_id,
            'status' => $status,
            'note' => $problem_note,
            'est_date' => $est_date,
            'updated_by' => $user_id,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'success',
                'message' => 'Kendala task berhasil disimpan.'
            ]));
    }

    /**
     * Endpoint for updating problem status
     */
    public function update_status()
    {
        $task_id = $this->input->post('task_id');
        $status = $this->input->post('status');
        $note = $this->input->post('note');
        $est_date = $this->input->post('est_date') ? $this->input->post('est_date') : null;
        $user_id = $this->session->userdata('user_id') ? $this->session->userdata('user_id') : 'System';

        $existing = $this->model_tasklist_problem->get_problem_by_task($task_id);

        if ($existing) {
            $data = [
                'status' => $status,
            ];
            if ($note) $data['problem_note'] = $note;
            if ($est_date) $data['est_date'] = $est_date;

            $this->model_tasklist_problem->update_problem($task_id, $data);

            $this->model_tasklist_problem->add_problem_history([
                'problem_id' => $existing->id,
                'status' => $status,
                'note' => $note ?: 'Status updated to ' . $status,
                'est_date' => $est_date ?: $existing->est_date,
                'updated_by' => $user_id,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            $data = [
                'task_id' => $task_id,
                'status' => $status,
                'problem_desc' => 'Updated by Quick Status',
                'problem_note' => $note,
                'est_date' => $est_date,
                'created_by' => $user_id,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $problem_id = $this->model_tasklist_problem->add_problem($data);

            $this->model_tasklist_problem->add_problem_history([
                'problem_id' => $problem_id,
                'status' => $status,
                'note' => $note ?: 'Status updated to ' . $status,
                'est_date' => $est_date,
                'updated_by' => $user_id,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'success',
                'message' => 'Status berhasil diupdate.'
            ]));
    }

    /**
     * Endpoint for deleting problem
     */
    public function delete_problem()
    {
        $task_id = $this->input->post('task_id');
        $this->model_tasklist_problem->delete_problem($task_id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'success',
                'message' => 'Kendala berhasil dihapus.'
            ]));
    }

    /**
     * Endpoint for searching tasks/problems for Select2
     */
    public function search_tasks()
    {
        $q = $this->input->get('q');

        $this->db->select('t.id, CONCAT(t.task_code," - ", t.task_name, " - ", p.project_name) as text');
        $this->db->from('t_pm_tasklist t');
        $this->db->join('t_pm_projects p', 'p.id = t.project_id');
        $this->db->where('t.status !=', 'Done');
        $this->db->like('t.task_code', $q);
        $this->db->or_like('t.task_name', $q);
        $this->db->or_like('p.project_name', $q);
        $this->db->limit(10);
        $query = $this->db->get();
        $all_tasks = $query->result();

        // Filter response based on search term
        $results = [];
        if (trim($q) !== '') {
            foreach ($all_tasks as $task) {
                if (stripos($task->text, $q) !== false || stripos($task->id, $q) !== false) {
                    $results[] = $task;
                }
            }
        } else {
            // return all if empty or first 10
            $results = $all_tasks;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'results' => $results
            ]));
    }
}
