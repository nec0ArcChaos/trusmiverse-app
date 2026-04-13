<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Activation extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('compas/model_activation', 'model_activation');
        $this->load->model('compas/model_campaign', 'model_campaign');
        $this->load->database();
    }

    private function _check_session()
    {
        if (!$this->session->userdata('user_id')) {
            return $this->_json_response(false, 'Session expired');
        }
    }

    private function _check_ajax()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
    }

    private function _json_response($status, $message = '', $data = [])
    {
        $response = ['status' => $status, 'message' => $message];
        if (!empty($data)) {
            $response = array_merge($response, (array) $data);
            if (isset($data['data']) && count($data) === 1) {
                $response = array_merge(['status' => $status, 'message' => $message], $data);
            }
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    private function _log_activity($campaign_id, $phase_id, $action_type, $description, $details = [])
    {
        $log_data = [
            'campaign_id' => $campaign_id,
            'phase_id' => $phase_id,
            'phase' => 'activation',
            'user_id' => $this->session->userdata('user_id'),
            'action_type' => $action_type,
            'description' => $description,
            'details' => json_encode($details),
        ];
        return $this->db->insert('t_cmp_activity_logs', $log_data);
    }
    public function load()
    {
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $campaigns = $this->model_activation->get_campaigns_by_date($start, $end);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'data' => $campaigns,
            ]));
    }

    public function detail()
    {
        $campaign_id = $this->input->post('campaign_id');
        // $campaign = $this->model_activation->getCampaign($campaign_id);
        $activations = $this->model_activation->getActivations($campaign_id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'campaign_id' => $campaign_id,
                'activations' => $activations,
                // 'campaign' => $campaign,
            ]));
    }

    public function get_activation_stats()
    {
        $stats = $this->model_activation->getActivationStats();

        // Format avg_sla_days → "Xd Yh"
        $avg_days = (int) ($stats['avg_sla_days'] ?? 0);
        $sla_display = ($avg_days > 0)
            ? floor($avg_days / 1) . 'd 0h'
            : '0d';

        return $this->_json_response(true, 'OK', [
            'data' => [
                'total_submissions' => (int) ($stats['total_submissions'] ?? 0),
                'avg_sla_days' => $avg_days,
                'avg_sla_display' => $sla_display,
                'avg_ai_score' => (int) ($stats['avg_ai_score'] ?? 0),
                'approved_plans' => (int) ($stats['approved_plans'] ?? 0),
            ]
        ]);
    }

    public function get_pics()
    {
        $campaign_id = $this->input->post('id');
        $pics = $this->model_activation->getPics($campaign_id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'data' => $pics,
            ]));
    }

    public function get_platforms()
    {
        $brand_id = $this->input->post('id');
        $platforms = $this->model_activation->getPlatforms($brand_id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'data' => $platforms,
            ]));
    }

    public function add()
    {
        // Get POST data
        $postData = $this->input->post();
        // Prepare data for insertion
        $data = [
            'campaign_id' => $postData['campaign_id'],
            'title' => $postData['title'],
            'description' => $postData['description'], // Mapping "Aktivasi yang Berjalan" to description
            'target_audience' => $postData['target_audience'],
            'period_start' => $postData['period_start'],
            'period_end' => $postData['period_end'],
            'pic' => isset($postData['pic']) ? implode(',', $postData['pic']) : '',
            'budget' => str_replace('.', '', $postData['budget']), // Remove dots if formatted
            'content_produced' => isset($postData['content_result']) ? implode(',', $postData['content_result']) : '',
            'platforms' => isset($postData['platform']) ? implode(',', $postData['platform']) : '',
            'status' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id') ? $this->session->userdata('user_id') : 1,
        ];

        $insert_id = $this->model_activation->insert_activation($data);

        $activations = $this->model_activation->getActivationsCount($postData['campaign_id']);
        if ($activations == 1) {
            $this->model_activation->update_campaign($postData['campaign_id'], ['activation_status' => '2']);
        }

        if ($insert_id) {
            $analysis = $this->analysis_activation($insert_id);
            $data['activation_id'] = $insert_id;
            echo json_encode(['status' => 'success', 'message' => 'Activation added successfully', 'data' => $data, 'analysis' => $analysis]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add activation']);
        }
    }

    public function get_activation_team()
    {
        // if (!$this->input->is_ajax_request()) {
        //     show_404();
        // }

        $campaign_id = $this->input->get('campaign_id');

        if (empty($campaign_id)) {
            echo json_encode(['status' => false, 'message' => 'Campaign ID required']);
            return;
        }

        $activation_team = $this->model_activation->get_activation_team($campaign_id);
        foreach ($activation_team as $key => $value) {
            $avatars = $value->profile_picture_team ? explode(',', $value->profile_picture_team) : [''];
            $count_avatars = count($avatars);
            if ($count_avatars > 5) {
                $more_users = max(0, $value->jml_team - 5);
                $avatars = array_slice($avatars, 0, 5);
            } else {
                $more_users = max(0, $value->jml_team - 5);
            }

            $avatars = array_map(function ($avatar) {
                if ($avatar != '') {
                    return 'https://trusmiverse.com/hr/uploads/profile/' . $avatar;
                } else {
                    return 'https://trusmiverse.com/hr/uploads/profile/anonim.jpg';
                }
            }, $avatars);
            $activation_team[$key]->profile_picture_team = $avatars;
            $activation_team[$key]->more_users = $more_users;
        }
        if ($activation_team) {
            echo json_encode([
                'status' => true,
                'data' => $activation_team[0],
            ]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Data not found']);
        }
    }

    public function update()
    {
        // Get POST data
        $postData = $this->input->post();
        $activation_id = $postData['activation_id'];

        if (!$activation_id) {
            echo json_encode(['status' => 'error', 'message' => 'Activation ID is required']);
            return;
        }

        // Prepare data for update
        $data = [
            'campaign_id' => $postData['campaign_id'],
            'title' => $postData['title'],
            'description' => $postData['description'], // Mapping "Aktivasi yang Berjalan" to description
            'target_audience' => $postData['target_audience'],
            'period_start' => $postData['period_start'],
            'period_end' => $postData['period_end'],
            'pic' => isset($postData['pic']) ? implode(',', $postData['pic']) : '',
            'budget' => str_replace('.', '', $postData['budget']), // Remove dots if formatted
            'content_produced' => isset($postData['content_result']) ? implode(',', $postData['content_result']) : '',
            'platforms' => isset($postData['platform']) ? implode(',', $postData['platform']) : '',
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('user_id') ? $this->session->userdata('user_id') : 1,
        ];

        $update = $this->model_activation->update_activation($activation_id, $data);

        // Optionally re-run analysis if needed, or just return success
        // For now, let's assume we just update the data.

        if ($update) {
            // Re-run analysis after update
            $analysis = $this->analysis_activation($activation_id);
            echo json_encode(['status' => 'success', 'message' => 'Activation updated successfully', 'analysis' => $analysis]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update activation']);
        }
    }

    public function get_activation_detail()
    {
        $activation_id = $this->input->post('activation_id');
        $activation = $this->model_activation->getActivation($activation_id);
        // var_dump($activation_id);
        $analysis = $this->model_activation->getAnalysis($activation_id);

        if ($analysis) {
            $json_fields = [
                'detail_alignment',
                'swot_strengths',
                'swot_weaknesses',
                'swot_opportunities',
                'swot_threats',
                'funnel_impact',
                'performance_estimation',
                'budget_analysis',
                'risk_analysis',
                'recommendations',
                'executive_summary'
            ];

            foreach ($json_fields as $field) {
                if (isset($analysis[$field])) {
                    $analysis[$field] = json_decode($analysis[$field], true);
                }
            }
        }

        if ($activation) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'success',
                    'data' => $activation,
                    'analysis' => $analysis ?? null
                ]));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => 'Activation not found'
                ]));
        }
    }

    private function analysis_activation($activation_id)
    {
        $activation_data = $this->model_activation->getActivationForAnalysis($activation_id);
        $campaign = $this->model_campaign->get_campaign_by_id($activation_data['campaign_id']);
        if ($campaign) {
            $strategy_and_concept = [
                'campaign_name' => $campaign->campaign_name,
                'campaign_description' => $campaign->campaign_desc,
                'brand_name' => $campaign->brand_name,
                'brand_desc' => $campaign->brand_desc,
                'campaign_start_date' => $campaign->campaign_start_date,
                'campaign_end_date' => $campaign->campaign_end_date,
                'objectives' => $campaign->objectives,
                'content_angle' => $campaign->content_angle,
            ];

            $message_and_audience = [
                'target_audience' => $campaign->target_audience,
                'audience_problem' => $campaign->audience_problem,
                'key_message' => $campaign->key_message,
                'reason_to_believe' => $campaign->reason_to_believe,
                'call_to_action' => $campaign->call_to_action,
            ];

            $creative_and_direction = [
                'content_generated' => $campaign->content_generated,
                'content_formats' => $campaign->content_formats,
            ];

            $kpi_and_budget = [
                'target_views' => $campaign->target_views,
                'target_leads' => $campaign->target_leads,
                'target_transactions' => $campaign->target_transactions,
                'production_cost' => $campaign->production_cost,
                'placement_cost' => $campaign->placement_cost,
            ];

            $campaign_data = [
                'current_time' => date('Y-m-d H:i:s'),
                'campaign_id' => $campaign->campaign_id,
                'strategy_and_concept' => $strategy_and_concept,
                'message_and_audience' => $message_and_audience,
                'creative_and_direction' => $creative_and_direction,
                'kpi_and_budget' => $kpi_and_budget,
            ];
        }

        // $activation_data = [
        //     'current_time' => date('Y-m-d H:i:s'),
        //     'activation_id' => $activation['activation_id'],
        //     'title' => $activation['title'],
        //     'description' => $activation['description'],
        //     'target_audience' => $activation['target_audience'],
        //     'period_start' => $activation['period_start'],
        //     'period_end' => $activation['period_end'],
        //     'pic' => $activation['pic'],
        //     'budget' => $activation['budget'],
        //     'content_produced' => $activation['content_produced'],
        //     'platforms' => $activation['platforms'],
        //     'status' => $activation['status'],
        //     'created_at' => $activation['created_at'],
        //     'updated_at' => $activation['updated_at'],
        //     'created_by' => $activation['created_by'],
        // ];

        $data = [
            "campaign_data" => $campaign_data,
            "activation_data" => $activation_data,
            "phase" => 'activation'
        ];

        // curl post to n8n
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook/compas-analysis-a7cd0275-b0a7-43eb-8a66-70f40d869d30');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $n8n_data = json_decode($response, true);

        if ($http_code == 200 && $n8n_data) {
            // Handle array wrap
            if (isset($n8n_data['output']) && is_array($n8n_data['output'])) {
                $n8n_result = $n8n_data['output'];
            } else {
                $n8n_result = $n8n_data;
            }
            // Map JSON to DB columns
            $db_data = [
                'activation_id' => $activation_id,
                'analysis_date' => date('Y-m-d'),
                'event_name' => $n8n_result['nama_event'] ?? null,
                'overall_score' => $n8n_result['skor_keseluruhan'] ?? null,
                'strategic_score' => $n8n_result['skor_kesesuaian_strategis'] ?? null,
                'detail_alignment' => isset($n8n_result['detail_alignment']) ? json_encode($n8n_result['detail_alignment']) : null,
                'swot_strengths' => isset($n8n_result['analisis_swot']['strengths']) ? json_encode($n8n_result['analisis_swot']['strengths']) : null,
                'swot_weaknesses' => isset($n8n_result['analisis_swot']['weaknesses']) ? json_encode($n8n_result['analisis_swot']['weaknesses']) : null,
                'swot_opportunities' => isset($n8n_result['analisis_swot']['opportunities']) ? json_encode($n8n_result['analisis_swot']['opportunities']) : null,
                'swot_threats' => isset($n8n_result['analisis_swot']['threats']) ? json_encode($n8n_result['analisis_swot']['threats']) : null,
                'funnel_impact' => isset($n8n_result['dampak_funnel']) ? json_encode($n8n_result['dampak_funnel']) : null,
                'performance_estimation' => isset($n8n_result['estimasi_performa']) ? json_encode($n8n_result['estimasi_performa']) : null,
                'budget_analysis' => isset($n8n_result['analisis_anggaran']) ? json_encode($n8n_result['analisis_anggaran']) : null,
                'risk_analysis' => isset($n8n_result['analisis_risiko']) ? json_encode($n8n_result['analisis_risiko']) : null,
                'recommendations' => isset($n8n_result['rekomendasi']) ? json_encode($n8n_result['rekomendasi']) : null,
                'executive_summary' => isset($n8n_result['ringkasan_eksekutif']) ? json_encode($n8n_result['ringkasan_eksekutif']) : null,
            ];

            // Save to database
            $this->model_activation->save_activation_analysis($db_data);

            return $n8n_result;

        } else {
            return ['status' => 'error', 'message' => 'Failed to retrieve analysis from AI service.'];
        }
    }
    public function get_analysis()
    {
        $activation_id = $this->input->post('activation_id');
        $analysis = $this->model_activation->getAnalysis($activation_id);

        if (!$analysis) {
            $this->analysis_activation($activation_id);
            $analysis = $this->model_activation->getAnalysis($activation_id);
        }

        if ($analysis) {
            $json_fields = [
                'detail_alignment',
                'swot_strengths',
                'swot_weaknesses',
                'swot_opportunities',
                'swot_threats',
                'funnel_impact',
                'performance_estimation',
                'budget_analysis',
                'risk_analysis',
                'recommendations',
                'executive_summary'
            ];

            foreach ($json_fields as $field) {
                if (isset($analysis[$field])) {
                    $analysis[$field] = json_decode($analysis[$field], true);
                }
            }

            echo json_encode(['status' => 'success', 'data' => $analysis]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Analysis not found']);
        }
    }

    public function reanalyze()
    {
        $activation_id = $this->input->post('activation_id');

        if (!$activation_id) {
            echo json_encode(['status' => 'error', 'message' => 'Activation ID is required']);
            return;
        }

        $result = $this->analysis_activation($activation_id);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Analysis re-run successfully', 'data' => $result]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Analysis failed']);
        }
    }

    public function update_task_sub_detail()
    {
        $activation_id = $this->input->post('activation_id');
        $status = $this->input->post('status');
        $progress = $this->input->post('progress');
        $note = $this->input->post('note');
        $target = $this->input->post('target');
        $user_id = $this->session->userdata('user_id') ? $this->session->userdata('user_id') : 1;

        if (!$activation_id) {
            echo json_encode(['status' => 'error', 'message' => 'Activation ID is required']);
            return;
        }

        // 1. Get Current Data
        $current_activation = $this->model_activation->getActivation($activation_id);
        if (!$current_activation) {
            echo json_encode(['status' => 'error', 'message' => 'Activation not found']);
            return;
        }

        // Determine if status actually changed to avoid spamming logs
        $status_changed = ($current_activation['status'] != $status);
        $pic = in_array($user_id, explode(',', $current_activation['pic_ids'])) ? $current_activation['pic_ids'] : $current_activation['pic_ids'] . ',' . $user_id;

        // 2. Update Activation Record
        $update_data = [
            'status' => $status,
            'progress' => $progress,
            'pic' => $pic,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $user_id
        ];
        $this->model_activation->update_activation($activation_id, $update_data);

        // 3. Log Status Change
        if ($status_changed) {
            $this->model_activation->log_activity([
                'phase_id' => $activation_id,
                'phase' => 'activation',
                'campaign_id' => $current_activation['campaign_id'],
                'user_id' => $user_id,
                'action_type' => 'STATUS_CHANGE',
                'description' => 'Changed status',
                'details' => json_encode([
                    'status_from' => $current_activation['status'],
                    'status_to' => $status
                ])
            ]);
            if ($status == '3') {
                $activations = $this->model_activation->getActivationsBySubStatus($current_activation['campaign_id'], '3');
                if (count($activations) >= $target) {
                    $this->model_activation->update_campaign(
                        $current_activation['campaign_id'],
                        [
                            'activation_status' => '3',
                            'activation_approved_at' => date('Y-m-d H:i:s'),
                            'content_status' => '1',
                            'talent_status' => '1',
                            'distribution_status' => '1',
                            'optimization_status' => '1',
                        ]
                    );
                }
            }
        }

        // 4. Log Note
        if (!empty($note)) {
            $this->model_activation->log_activity([
                'phase_id' => $activation_id,
                'phase' => 'activation',
                'campaign_id' => $current_activation['campaign_id'],
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
                    'upload_path' => './uploads/activation_files/',
                    'allowed_types' => 'gif|jpg|png|pdf|doc|docx|xls|xlsx|ppt|pptx|txt',
                    'max_size' => 10240,
                    'encrypt_name' => TRUE
                ];

                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, TRUE);
                }

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

                $this->model_activation->log_activity([
                    'phase_id' => $activation_id,
                    'phase' => 'activation',
                    'campaign_id' => $current_activation['campaign_id'],
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
        $activation_id = $this->input->post('activation_id');
        $logs = $this->model_activation->get_activity_log($activation_id);
        echo json_encode(['status' => 'success', 'data' => $logs]);
    }

    public function get_all_activity_logs()
    {
        // Optional: Filter by campaign if needed, passed via post
        $limit = $this->input->post('limit') ? $this->input->post('limit') : 10;
        $logs = $this->model_activation->get_all_activity_logs($limit);
        echo json_encode(['status' => 'success', 'data' => $logs]);
    }

    public function get_employees()
    {
        // if (!$this->input->is_ajax_request()) {
        //     show_404();
        // }
        $employees = $this->model_activation->get_all_employees();
        echo json_encode(['status' => true, 'data' => $employees]);
    }

    public function save_activation_team()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $campaign_id = $this->input->post('campaign_id');
        $team = $this->input->post('team'); // Array of user IDs

        if (empty($campaign_id)) {
            echo json_encode(['status' => false, 'message' => 'Campaign ID required']);
            return;
        }

        if (is_array($team)) {
            $team_str = implode(',', $team);
        } else {
            $team_str = $team;
        }

        if ($this->model_activation->update_activation_team($campaign_id, $team_str)) {
            echo json_encode(['status' => true, 'message' => 'Team updated successfully']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to update team']);
        }
    }
    public function approve_activation()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id = $this->input->post('id');
        $target = $this->input->post('target');

        if (empty($id)) {
            echo json_encode(['status' => false, 'message' => 'ID required']);
            return;
        }

        if ($this->model_activation->approve_activation($id)) {
            // Activity Log
            $detail = $this->model_activation->getActivation($id);
            $campaign_id = $detail['campaign_id'] ?? 0;

            $log_data = [
                'phase_id' => $id,
                'phase' => 'activation',
                'campaign_id' => $campaign_id,
                'user_id' => $this->session->userdata('user_id'),
                'action_type' => 'STATUS_CHANGE',
                'description' => 'Activation plan status changed to Approved',
                'details' => json_encode(['status_from' => $detail['status'], 'status_to' => 3]),
            ];
            $this->model_activation->log_activity($log_data);

            $activations = $this->model_activation->getActivationsBySubStatus($campaign_id, '3');
            $update_campaign = [];
            if (count($activations) >= $target) {
                $update_campaign = [
                    'activation_status' => '3',
                    'activation_approved_at' => date('Y-m-d H:i:s'),
                    'content_status' => '1',
                ];
            } elseif (count($activations) < $target) {
                $update_campaign = [
                    'activation_status' => '2',
                ];
            }
            $update_campaign['activation_actual'] = count($activations);
            $this->model_activation->update_campaign($campaign_id, $update_campaign);
            echo json_encode(['status' => true, 'message' => 'Plan approved successfully']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to approve plan']);
        }
    }

    public function cancel_approve_activation()
    {
        if (!$this->input->is_ajax_request())
            show_404();
        $id = $this->input->post('id');
        $target = $this->input->post('target');
        if (empty($id)) {
            echo json_encode(['status' => false, 'message' => 'ID required']);
            return;
        }

        if ($this->model_activation->cancel_approve_activation($id)) {
            $detail = $this->model_activation->getActivation($id);
            $campaign_id = $detail['campaign_id'] ?? 0;
            $log_data = [
                'phase_id' => $id,
                'phase' => 'activation',
                'campaign_id' => $campaign_id,
                'user_id' => $this->session->userdata('user_id'),
                'action_type' => 'STATUS_CHANGE',
                'description' => 'Activation approval cancelled (Reverted to Draft)',
                'details' => json_encode(['status_from' => 3, 'status_to' => 1]),
            ];
            $this->model_activation->log_activity($log_data);
            $activations = $this->model_activation->getActivationsBySubStatus($campaign_id, '3');
            $update_campaign = [];
            if (count($activations) >= $target) {
                $update_campaign = [
                    'activation_status' => '3',
                    'activation_approved_at' => date('Y-m-d H:i:s'),
                    'content_status' => '1',
                ];
            } elseif (count($activations) < $target) {
                $update_campaign = [
                    'activation_status' => '2',
                ];
            }
            $update_campaign['activation_actual'] = count($activations);
            $this->model_activation->update_campaign($campaign_id, $update_campaign);
            echo json_encode(['status' => true, 'message' => 'Approval cancelled']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to cancel approval']);
        }
    }

    public function reject_activation()
    {
        if (!$this->input->is_ajax_request())
            show_404();
        $id = $this->input->post('id');
        $note = $this->input->post('note');
        $status = $this->input->post('status') ?: 4;
        $target = $this->input->post('target');

        if (empty($id)) {
            echo json_encode(['status' => false, 'message' => 'ID required']);
            return;
        }

        if ($this->model_activation->reject_activation($id, $status)) {
            $detail = $this->model_activation->getActivation($id);
            $action_desc = ($status == 4) ? 'Rejected' : 'Revision';
            $activations = $this->model_activation->getActivationsBySubStatus($detail['campaign_id'], '3');
            $update_campaign = [];
            if (count($activations) >= $target) {
                $update_campaign = [
                    'activation_status' => '3',
                    'activation_approved_at' => date('Y-m-d H:i:s'),
                    'content_status' => '1',
                ];

            } elseif (count($activations) < $target) {
                $update_campaign = [
                    'activation_status' => '2',
                ];
            }
            $update_campaign['activation_actual'] = count($activations);
            $this->model_activation->update_campaign($detail['campaign_id'], $update_campaign);
            $this->_log_activity($detail['campaign_id'], $id, 'STATUS_CHANGE', "Updated activation plan $id status to $action_desc. Note: " . ($note ?: 'No note'), ['status_from' => $detail['status'], 'status_to' => $status, 'note' => $note]);
            return $this->_json_response(true, "Plan $action_desc successfully");
        }
        return $this->_json_response(false, 'Failed to reject plan status');
    }

    /* Comments Logic */
    public function get_comments()
    {
        $campaign_id = $this->input->get('campaign_id');
        $user_id = $this->session->userdata('user_id');

        $comments = $this->db->select('c.*, CONCAT(e.first_name, " ", e.last_name) as fullname, e.profile_picture')
            ->from('t_cmp_comments c')
            ->join('xin_employees e', 'e.user_id = c.user_id', 'left')
            ->where('c.campaign_id', $campaign_id)
            ->where('c.phase', 'activation')
            ->get()->result_array();

        $data = [];
        foreach ($comments as $comment) {
            $has_upvoted = $this->db->where('comment_id', $comment['id'])
                ->where('user_id', $user_id)
                ->count_all_results('t_cmp_comment_upvotes') > 0;

            $attachments = $this->db->where('comment_id', $comment['id'])->get('t_cmp_comment_attachments')->result_array();
            $file_attachments = array_map(function ($att) {
                return [
                    'id' => $att['id'],
                    'file' => $att['file_path'],
                    'url' => $att['file_path'],
                    'mime_type' => $att['file_mime_type'],
                    'created' => $att['created_at'],
                    'file_name' => $att['file_original_name'],
                    'file_size' => $att['file_size']
                ];
            }, $attachments);

            $data[] = [
                'id' => $comment['id'],
                'parent' => $comment['parent_id'],
                'created' => $comment['created_at'],
                'modified' => $comment['updated_at'],
                'content' => $comment['content'],
                'pings' => json_decode($comment['pings']),
                'attachments' => $file_attachments,
                'creator' => $comment['user_id'],
                'fullname' => $comment['fullname'] ?: 'Unknown',
                'profile_picture_url' => 'https://trusmiverse.com/hr/uploads/profile/' . ($comment['profile_picture'] ?: 'anonim.jpg'),
                'created_by_current_user' => ($comment['user_id'] == $user_id),
                'upvote_count' => (int) $comment['upvote_count'],
                'user_has_upvoted' => $has_upvoted
            ];
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function post_comment()
    {
        $this->_check_ajax();

        $data = [
            'campaign_id' => $this->input->post('campaign_id'),
            'phase' => 'activation',
            'user_id' => $this->session->userdata('user_id'),
            'parent_id' => $this->input->post('parent') ?: NULL,
            'content' => $this->input->post('content'),
            'pings' => $this->input->post('pings') ?: '[]',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->insert('t_cmp_comments', $data);
        $insert_id = $this->db->insert_id();

        if (!empty($_FILES['attachments_to_be_created']['name'][0])) {
            $this->_handle_comment_attachments($insert_id);
        }

        $new_comment = $this->db->select('c.*, CONCAT(e.first_name, " ", e.last_name) as fullname, e.profile_picture')
            ->from('t_cmp_comments c')
            ->join('xin_employees e', 'e.user_id = c.user_id', 'left')
            ->where('c.id', $insert_id)
            ->get()->row_array();

        return $this->output->set_content_type('application/json')->set_output(json_encode($this->_format_comment_response($new_comment)));
    }

    public function put_comment()
    {
        $this->_check_ajax();

        $id = $this->input->post('id');
        if (!$id)
            return $this->_json_response(false, 'Comment ID required');

        $this->db->where('id', $id)->update('t_cmp_comments', [
            'content' => $this->input->post('content'),
            'pings' => $this->input->post('pings') ?: '[]',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $keep_ids = array_filter(array_map('intval', explode(',', $this->input->post('existing_attachment_ids') ?: '')));
        if (!empty($keep_ids)) {
            $this->db->where('comment_id', $id)->where_not_in('id', $keep_ids)->delete('t_cmp_comment_attachments');
        } else {
            $this->db->where('comment_id', $id)->delete('t_cmp_comment_attachments');
        }

        if (!empty($_FILES['attachments_to_be_created']['name'][0])) {
            $this->_handle_comment_attachments($id);
        }

        $updated_comment = $this->db->select('c.*, CONCAT(e.first_name, " ", e.last_name) as fullname, e.profile_picture')
            ->from('t_cmp_comments c')
            ->join('xin_employees e', 'e.user_id = c.user_id', 'left')
            ->where('c.id', $id)
            ->get()->row_array();

        return $this->output->set_content_type('application/json')->set_output(json_encode($this->_format_comment_response($updated_comment)));
    }

    public function upload_comment_file()
    {
        $this->_check_ajax();
        if (empty($_FILES['file']['name']))
            return;

        $upload_path = FCPATH . 'uploads/comments/';
        if (!is_dir($upload_path))
            mkdir($upload_path, 0777, TRUE);

        $config = [
            'upload_path' => $upload_path,
            'allowed_types' => 'gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|ppt|pptx|txt|zip',
            'max_size' => 10240,
            'encrypt_name' => TRUE
        ];

        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
            $uploadData = $this->upload->data();
            $data = [
                'comment_id' => NULL,
                'user_id' => $this->session->userdata('user_id'),
                'file_name' => $uploadData['file_name'],
                'file_original_name' => $uploadData['client_name'],
                'file_mime_type' => $uploadData['file_type'],
                'file_size' => $uploadData['file_size'],
                'file_path' => base_url('uploads/comments/' . $uploadData['file_name']),
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->insert('t_cmp_comment_attachments', $data);
            return $this->_json_response(true, 'File uploaded', [
                'id' => $this->db->insert_id(),
                'file' => $data['file_path'],
                'url' => $data['file_path'],
                'mime_type' => $data['file_mime_type'],
                'file_name' => $data['file_original_name'],
            ]);
        }
        return $this->_json_response(false, $this->upload->display_errors());
    }


    public function upvote_comment()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $comment_id = $input['id'];
        $user_id = $this->session->userdata('user_id');

        if ($input['user_has_upvoted']) {
            $exists = $this->db->where('comment_id', $comment_id)->where('user_id', $user_id)->count_all_results('t_cmp_comment_upvotes');
            if (!$exists) {
                $this->db->insert('t_cmp_comment_upvotes', ['comment_id' => $comment_id, 'user_id' => $user_id]);
                $this->db->set('upvote_count', 'upvote_count+1', FALSE)->where('id', $comment_id)->update('t_cmp_comments');
            }
        } else {
            $this->db->where('comment_id', $comment_id)->where('user_id', $user_id)->delete('t_cmp_comment_upvotes');
            $this->db->set('upvote_count', 'upvote_count-1', FALSE)->where('id', $comment_id)->update('t_cmp_comments');
        }

        return $this->_json_response(true);
    }

    public function delete_comment()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? $this->uri->segment(4);

        if ($id) {
            $comment_ids = [$id];
            $replies = $this->db->where('parent_id', $id)->get('t_cmp_comments')->result_array();
            foreach ($replies as $reply)
                $comment_ids[] = $reply['id'];

            $this->db->where_in('comment_id', $comment_ids)->delete('t_cmp_comment_upvotes');

            $attachments = $this->db->where_in('comment_id', $comment_ids)->get('t_cmp_comment_attachments')->result_array();
            foreach ($attachments as $att) {
                $file_path = FCPATH . 'uploads/comments/' . $att['file_name'];
                if (file_exists($file_path))
                    unlink($file_path);
            }
            $this->db->where_in('comment_id', $comment_ids)->delete('t_cmp_comment_attachments');
            $this->db->where_in('id', $comment_ids)->delete('t_cmp_comments');
        }

        return $this->_json_response(true);
    }

    private function _handle_comment_attachments($comment_id)
    {
        $upload_path = FCPATH . 'uploads/comments/';
        if (!is_dir($upload_path))
            mkdir($upload_path, 0777, TRUE);

        $files = $_FILES['attachments_to_be_created'];
        for ($i = 0; $i < count($files['name']); $i++) {
            if ($files['error'][$i] !== UPLOAD_ERR_OK)
                continue;

            $ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
            $encrypted = md5(uniqid(rand(), TRUE)) . '.' . $ext;
            $destination = $upload_path . $encrypted;

            if (move_uploaded_file($files['tmp_name'][$i], $destination)) {
                $this->db->insert('t_cmp_comment_attachments', [
                    'comment_id' => $comment_id,
                    'user_id' => $this->session->userdata('user_id'),
                    'file_name' => $encrypted,
                    'file_original_name' => $files['name'][$i],
                    'file_mime_type' => $files['type'][$i],
                    'file_size' => $files['size'][$i],
                    'file_path' => base_url('uploads/comments/' . $encrypted),
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    private function _format_comment_response($comment)
    {
        $user_id = $this->session->userdata('user_id');
        $attachments = $this->db->where('comment_id', $comment['id'])->get('t_cmp_comment_attachments')->result_array();

        return [
            'id' => $comment['id'],
            'parent' => $comment['parent_id'],
            'created' => $comment['created_at'],
            'modified' => $comment['updated_at'],
            'content' => $comment['content'],
            'pings' => json_decode($comment['pings']),
            'attachments' => array_map(function ($att) {
                return [
                    'id' => $att['id'],
                    'file' => $att['file_path'],
                    'url' => $att['file_path'],
                    'mime_type' => $att['file_mime_type'],
                    'created' => $att['created_at'],
                    'file_name' => $att['file_original_name'],
                    'file_size' => $att['file_size']
                ];
            }, $attachments),
            'creator' => $comment['user_id'],
            'fullname' => $comment['fullname'],
            'profile_picture_url' => 'https://trusmiverse.com/hr/uploads/profile/' . ($comment['profile_picture'] ?: 'anonim.jpg'),
            'created_by_current_user' => ($comment['user_id'] == $user_id),
            'upvote_count' => (int) ($comment['upvote_count'] ?? 0),
            'user_has_upvoted' => false,
        ];
    }

    public function get_users_for_comments()
    {
        $this->_check_ajax();

        $users = $this->db->select('user_id as id, CONCAT(first_name, " ", last_name) as fullname, email, profile_picture as profile_picture_url')
            ->from('xin_employees')
            ->where('is_active', 1)
            ->get()->result_array();

        foreach ($users as &$u) {
            $u['profile_picture_url'] = 'https://trusmiverse.com/hr/uploads/profile/' . ($u['profile_picture_url'] ?: 'anonim.jpg');
        }

        return $this->_json_response(true, 'Data fetched', ['data' => $users]);
    }

    public function get_team_performance_stats()
    {
        $campaign_id = $this->input->get('campaign_id');
        if (empty($campaign_id)) {
            echo json_encode(['status' => false, 'message' => 'Campaign ID required']);
            return;
        }

        $stats = $this->model_activation->get_activation_performance_stats($campaign_id);
        echo json_encode(['status' => true, 'data' => $stats]);
    }

    public function generate_ai_activation()
    {
        header('Content-Type: application/json');

        $user_prompt = $this->input->post('user_prompt');
        $campaign_id = $this->input->post('campaign_id');

        // 1. Fetch Master Data

        // Platforms
        $platforms = $this->db
            ->select('platform_id, platform_name, brand_id')
            ->where('is_active', 1)
            ->get('m_cmp_platform')
            ->result_array();

        // Placements
        $placements = $this->db
            ->select('placement_id, placement_name, brand_id')
            ->where('is_active', 1)
            ->get('m_cmp_placement')
            ->result_array();

        // Content Generated (jenis konten yang akan diproduksi)
        $content_generated = $this->db
            ->select('cg_id, cg_name, brand_id')
            ->where('is_active', 1)
            ->get('m_cmp_content_generated')
            ->result_array();

        // Content Formats
        $content_formats = $this->db
            ->select('cf_id, cf_name, brand_id')
            ->where('is_active', 1)
            ->get('m_cmp_content_format')
            ->result_array();

        // Employees / PIC candidates
        $employees = $this->db
            ->select('user_id, CONCAT(first_name, " ", last_name) as full_name')
            ->from('xin_employees')
            ->where('is_active', 1)
            ->get()
            ->result_array();

        // Existing activations for this campaign (as context / reference)
        $existing_activations = [];
        if (!empty($campaign_id)) {
            $existing_activations = $this->db
                ->select('activation_id, title, description, period_start, period_end, status, budget')
                ->where('campaign_id', $campaign_id)
                ->get('t_cmp_activation')
                ->result_array();
        }

        // Campaign data for context
        $campaign_context = null;
        if (!empty($campaign_id)) {
            $campaign_context = $this->db
                ->select('campaign_id, campaign_name, campaign_desc, brand_id, campaign_start_date, campaign_end_date,
                          target_audience, audience_problem, key_message, call_to_action, content_angle,
                          activation_target, production_cost, placement_cost, target_views, target_leads, target_transactions')
                ->where('campaign_id', $campaign_id)
                ->get('t_cmp_campaign')
                ->row_array();
        }

        $master_data = [
            'platforms' => $platforms,
            'placements' => $placements,
            'content_generated' => $content_generated,
            'content_formats' => $content_formats,
            'employees' => $employees,
            'existing_activations' => $existing_activations,
            'campaign' => $campaign_context,
        ];

        $master_data_str = json_encode($master_data, JSON_UNESCAPED_UNICODE);

        $system_prompt = "Anda adalah Konsultan Strategi Aktivasi Pemasaran Senior dengan keahlian mendalam di pasar Indonesia.
Tugas Anda adalah menghasilkan rencana aktivasi kampanye yang komprehensif, realistis, dan berdampak tinggi dalam format JSON berdasarkan input pengguna dan MASTER DATA yang disediakan.

---

🎯 PERAN & KONTEKS:
Anda memiliki pengalaman lebih dari 10 tahun dalam merancang event, aktivasi brand, dan konten pemasaran digital & offline di Indonesia. Anda memahami perilaku konsumen lokal, tren platform digital, serta strategi eksekusi aktivasi yang efektif.

---

📋 INSTRUKSI UTAMA:

1. **Analisis Input Pengguna**
   - Pahami jenis aktivasi, tema, dan konteks bisnis dari input yang diberikan.
   - Jika input tidak lengkap, asumsikan konteks yang paling masuk akal berdasarkan data campaign di MASTER DATA.
   - Jika input kosong, buat rencana aktivasi berdampak tinggi yang selaras dengan kampanye yang ada.

2. **Kontekstualisasi Campaign**
   - Gunakan data `campaign` dari MASTER DATA sebagai acuan utama untuk memastikan aktivasi selaras dengan strategi kampanye.
   - Perhatikan `existing_activations` agar aktivasi baru tidak duplikasi dan saling melengkapi.

3. **Pemilihan Platform & Format Konten**
   - Pilih `platform_id` yang relevan dari daftar `platforms`.
   - Pilih `cg_id` (jenis konten) dari daftar `content_generated`.
   - Kembalikan sebagai Array of IDs.

4. **Pemilihan PIC**
   - Pilih 1–3 `user_id` dari daftar `employees` yang paling sesuai sebagai PIC aktivasi.
   - Kembalikan sebagai Array of user_ids.

5. **Tanggal & Periode**
   - Tanggal saat ini adalah: " . date('Y-m-d H:i:s') . "
   - Tentukan `period_start` dan `period_end` yang realistis dan sesuai dengan durasi aktivasi yang direkomendasikan.
   - Pertimbangkan `campaign_start_date` dan `campaign_end_date` dari data campaign sebagai batas waktu.

6. **Standar Kualitas Output**
   - Semua teks WAJIB menggunakan **Bahasa Indonesia** yang natural, profesional, dan persuasif.
   - Semua angka (budget, target) WAJIB realistis untuk skala pasar Indonesia (Rupiah).

---

📊 MASTER DATA:
$master_data_str

---

📐 PANDUAN PENGISIAN FIELD:

| Field | Panduan |
|---|---|
| `title` | Nama aktivasi yang spesifik, actionable, dan memorable (contoh: \"Live Demo Produk di Mall X\", \"Workshop Kreatif Ramadan\") |
| `description` | Deskripsi detail aktivasi: apa yang dilakukan, bagaimana cara kerjanya, dan apa yang ingin dicapai (3–5 kalimat) |
| `target_audience` | Deskripsi spesifik audiens: usia, gender, lokasi, minat, dan perilaku digital |
| `budget` | Estimasi biaya total aktivasi dalam Rupiah (integer, tanpa titik/koma) |

---

🔢 PANDUAN TARGET REALISTIS:

- `budget`: Estimasi total biaya aktivasi (100.000 – 50.000.000 Rupiah tergantung skala)
- `period_start` / `period_end`: Format YYYY-MM-DD, durasi wajar 3–30 hari

---

📤 FORMAT OUTPUT JSON (Wajib diikuti secara ketat):
{
    \"title\": \"String\",
    \"description\": \"String\",
    \"target_audience\": \"String\",
    \"period_start\": \"YYYY-MM-DD\",
    \"period_end\": \"YYYY-MM-DD\",
    \"budget\": Integer,
    \"platform_ids\": [Array of platform_id],
    \"content_produced_ids\": [Array of cg_id]
}

⚠️ CONSTRAINT AKHIR:
- Output HANYA berupa JSON murni — tanpa penjelasan tambahan, tanpa markdown, tanpa komentar.
- Seluruh nilai string menggunakan Bahasa Indonesia.
- Seluruh nilai numerik dalam satuan yang sesuai (Rupiah untuk budget).
- Pastikan JSON valid dan dapat langsung di-parse.";

        // Payload to send to n8n
        $payload = [
            'system_prompt' => $system_prompt,
            'user_prompt' => $user_prompt ?: 'Buat rencana aktivasi yang kreatif dan berdampak tinggi untuk kampanye ini',
        ];

        // START: N8N Integration
        $n8n_url = "https://n8n.trustcore.id/webhook/compas-dynamic-generative-input-c8769381-40ab-46bd-8c9b-7a773f88c162";

        if (!empty($n8n_url)) {
            $ch = curl_init($n8n_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($http_code === 200) {
                $result = json_decode($response, true);
                $data = isset($result['output']) ? $result['output'] : $result;

                // Decode JSON output if it's a string in the response
                if (is_string($data)) {
                    $decoded = json_decode($data, true);
                    if ($decoded) {
                        $data = $decoded;
                    }
                }

                echo json_encode(['status' => true, 'data' => $data]);
                return;
            }
        }
        // END: N8N Integration

        // Fallback / Simulation Data
        $dummy_data = [
            'title' => 'AI Concept: ' . ($user_prompt ? substr($user_prompt, 0, 30) . '...' : 'Aktivasi Brand Kreatif'),
            'description' => 'Aktivasi ini dirancang untuk meningkatkan brand awareness dan engagement audiens melalui pengalaman interaktif. ' .
                'Dibuat berdasarkan: ' . ($user_prompt ?: 'strategi kampanye yang sedang berjalan'),
            'target_audience' => 'Millenial dan Gen Z (18–35 tahun), pengguna aktif media sosial, berdomisili di kota besar Indonesia',
            'period_start' => date('Y-m-d'),
            'period_end' => date('Y-m-d', strtotime('+14 days')),
            'budget' => 5000000,
            'platform_ids' => !empty($platforms) ? [($platforms[0]['platform_id'] ?? 1)] : [1],
            'content_produced_ids' => !empty($content_generated) ? [($content_generated[0]['cg_id'] ?? 1)] : [1],
            'pic_ids' => !empty($employees) ? [($employees[0]['user_id'] ?? 1)] : [1],
        ];

        echo json_encode(['status' => true, 'data' => $dummy_data]);
    }

    // public function get_activation_stats()
    // {
    //     header('Content-Type: application/json');
    //     $campaign_id = $this->input->get('campaign_id') ?: $this->input->post('campaign_id');
    //     if (!$campaign_id) {
    //         echo json_encode(['status' => false, 'message' => 'Campaign ID required']);
    //         return;
    //     }
    //     $stats = $this->model_activation->getActivationStats($campaign_id);
    //     echo json_encode([
    //         'status' => true,
    //         'data' => [
    //             'avg_sla' => $stats['avg_sla_days'] ?? 0,
    //             'avg_ai_score' => $stats['avg_ai_score'] ?? 0,
    //             'total_submissions' => $stats['total_submissions'] ?? 0,
    //             'approved_plans' => $stats['approved_plans'] ?? 0,
    //         ]
    //     ]);
    // }
}
