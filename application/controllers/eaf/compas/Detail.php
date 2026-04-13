<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('compas/model_activation', 'model_activation');
        $this->load->model('compas/model_detail', 'model_detail');
        $this->load->database();
    }

    public function load()
    {
        $campaign_id = $this->input->post('campaign_id');
        $campaign = $this->model_activation->getCampaign($campaign_id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'campaign' => $campaign,
            ]));
    }

    public function update_task_detail()
    {
        $phase = $this->input->post('phase'); // 'activation', 'content', etc.
        $task_id = $this->input->post('task_id'); // Generic ID
        $status = $this->input->post('status');
        $progress = $this->input->post('progress');
        $note = $this->input->post('note');
        $target = $this->input->post('target'); // Target number of approved tasks to complete phase
        $user_id = $this->session->userdata('user_id') ? $this->session->userdata('user_id') : 1;

        if (!$task_id || !$phase) {
            echo json_encode(['status' => 'error', 'message' => 'Task ID and Phase are required']);
            return;
        }

        // 1. Get Current Data
        $current_task = $this->model_detail->get_task_detail_with_pics($task_id, $phase);
        if (!$current_task) {
            echo json_encode(['status' => 'error', 'message' => 'Task not found']);
            return;
        }

        // Determine if status actually changed
        $status_changed = ($current_task['status'] != $status);

        // PIC Logic (Generic)
        // Assuming table has pic or pic_ids column.
        // Activation uses `pic_ids` in join result, but `pic` in table (comma separated).
        $pic = in_array($user_id, explode(',', $current_task['pic_ids'])) ? $current_task['pic_ids'] : $current_task['pic_ids'] . ',' . $user_id;


        // 2. Update Task Record
        $update_data = [
            'status' => $status,
            'progress' => $progress,
            'pic' => $pic,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $user_id
        ];
        $this->model_detail->update_task($task_id, $update_data, $phase);

        // 3. Log Status Change
        if ($status_changed) {
            $this->model_detail->log_activity([
                'campaign_id' => $current_task['campaign_id'],
                'phase_id' => $task_id,
                'phase' => $phase,
                'user_id' => $user_id,
                'action_type' => 'STATUS_CHANGE',
                'description' => 'Changed status',
                'details' => json_encode([
                    'status_from' => $current_task['status'],
                    'status_to' => $status
                ])
            ]);

            // Check if Phase Complete (All Approved)
            if ($status == '3') { // APPROVED
                $approved_tasks = $this->model_detail->get_tasks_by_status($current_task['campaign_id'], '3', $phase);

                // If we reach target (or all tasks), update campaign status for this phase
                if (count($approved_tasks) >= $target) {
                    $campaign_update = [];
                    $now = date('Y-m-d H:i:s');

                    // Logic: Update current phase status to 3 (Approved/Done)
                    // And potentially activate next phase?
                    // Let's stick to updating current phase status for now, or match Activation logic:

                    if ($phase == 'activation') {
                        $campaign_update = [
                            'activation_status' => '3',
                            'activation_approved_at' => $now,
                            'content_status' => '1',
                            'talent_status' => '1',
                            'distribution_status' => '1',
                            'optimization_status' => '1',
                        ];
                    } else if ($phase == 'content') {
                        $campaign_update = ['content_status' => '3', 'content_approved_at' => $now];
                    } else if ($phase == 'distribution') {
                        $campaign_update = ['distribution_status' => '3', 'distribution_approved_at' => $now];
                    } else if ($phase == 'optimization') {
                        $campaign_update = ['optimization_status' => '3', 'optimization_approved_at' => $now];
                    } else if ($phase == 'talent') {
                        $campaign_update = ['talent_status' => '3'];
                    }

                    if (!empty($campaign_update)) {
                        $this->model_detail->update_campaign($current_task['campaign_id'], $campaign_update);
                    }
                }
            }
        }

        // 4. Log Note
        if (!empty($note)) {
            $this->model_detail->log_activity([
                'phase_id' => $task_id,
                'phase' => $phase,
                'user_id' => $user_id,
                'action_type' => 'NOTE_ADDED',
                'description' => $note
            ]);
        }

        // 5. Handle File Uploads
        if (!empty($_FILES['file']['name'][0])) {
            $this->load->library('upload');

            $uploaded_files = [];
            $files = $_FILES['file'];
            $count = count($files['name']);

            // Dynamic Path
            $upload_path = "./uploads/{$phase}_files/";
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, TRUE);
            }

            // Iterate manually
            for ($i = 0; $i < $count; $i++) {
                if (empty($files['name'][$i]))
                    continue;

                $_FILES['userfile']['name'] = $files['name'][$i];
                $_FILES['userfile']['type'] = $files['type'][$i];
                $_FILES['userfile']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['userfile']['error'] = $files['error'][$i];
                $_FILES['userfile']['size'] = $files['size'][$i];

                $config = [
                    'upload_path' => $upload_path,
                    'allowed_types' => 'gif|jpg|png|pdf|doc|docx|xls|xlsx|ppt|pptx|txt',
                    'max_size' => 10240,
                    'encrypt_name' => TRUE
                ];

                $this->upload->initialize($config);

                if ($this->upload->do_upload('userfile')) {
                    $uploaded_files[] = $this->upload->data();
                }
            }

            if (count($uploaded_files) > 0) {
                $details = [
                    'file_count' => count($uploaded_files),
                    'files' => array_map(function ($file) {
                        return [
                            'file_name' => $file['file_name'],
                            'client_name' => $file['client_name']
                        ];
                    }, $uploaded_files)
                ];

                $this->model_detail->log_activity([
                    'phase_id' => $task_id,
                    'phase' => $phase,
                    'user_id' => $user_id,
                    'action_type' => 'FILE_UPLOADED',
                    'description' => 'Uploaded ' . count($uploaded_files) . ' files',
                    'details' => json_encode($details)
                ]);
            }
        }

        echo json_encode(['status' => 'success', 'message' => 'Task updated']);
    }

    public function get_activity_log()
    {
        $task_id = $this->input->post('task_id');
        $phase = $this->input->post('phase');
        $logs = $this->model_detail->get_activity_log($task_id, $phase);
        echo json_encode(['status' => 'success', 'data' => $logs]);
    }

    public function get_all_activity_logs()
    {
        $limit = $this->input->post('limit') ? $this->input->post('limit') : 10;
        $phase = $this->input->post('phase'); // Optional filter
        $logs = $this->model_detail->get_all_activity_logs($limit, $phase);
        echo json_encode(['status' => 'success', 'data' => $logs]);
    }
    public function get_task_detail()
    {
        $task_id = $this->input->post('task_id');
        $phase = $this->input->post('phase');

        if (!$task_id || !$phase) {
            echo json_encode(['status' => 'error', 'message' => 'Task ID and Phase are required']);
            return;
        }

        $task = $this->model_detail->get_task_detail_with_pics($task_id, $phase);

        if ($task) {
            echo json_encode(['status' => 'success', 'data' => $task]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Task not found']);
        }
    }
}