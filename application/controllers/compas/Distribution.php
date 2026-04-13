<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distribution extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('compas/Model_distribution');
        $this->load->model('compas/Model_campaign');
        $this->_check_session();
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
            'phase' => 'distribution',
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
        $campaigns = $this->Model_distribution->get_campaigns_by_date($start, $end);
        return $this->_json_response(true, 'Data fetched', ['data' => $campaigns]);
    }

    public function detail()
    {
        $campaign_id = $this->input->post('campaign_id');
        return $this->_json_response(true, 'Data fetched', [
            'campaign_id' => $campaign_id,
            'distribution' => $this->Model_distribution->get_distribution_plan($campaign_id)
        ]);
    }

    public function get_approved_contents()
    {
        $this->_check_ajax();

        $campaign_id = $this->input->get('campaign_id');
        $page = $this->input->get('page') ? (int) $this->input->get('page') : 1;
        $limit = 3;
        $start = ($page - 1) * $limit;

        if (empty($campaign_id)) {
            return $this->_json_response(false, 'Campaign ID required');
        }

        $contents = $this->Model_distribution->get_approved_contents($campaign_id, $limit, $start);
        $total_records = $this->Model_distribution->count_approved_contents($campaign_id);
        $total_pages = ceil($total_records['total'] / $limit);

        return $this->_json_response(true, 'Data fetched', [
            'data' => $contents,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $total_pages,
                'total_records' => $total_records
            ]
        ]);
    }

    public function get_content_detail()
    {
        $this->_check_ajax();

        $id = $this->input->get('id');
        if (empty($id)) {
            return $this->_json_response(false, 'ID required');
        }

        $content_data = $this->Model_distribution->get_content_by_id($id);
        if (!$content_data) {
            return $this->_json_response(false, 'Data not found');
        }

        $campaign_data = $this->Model_campaign->get_campaign_by_id($content_data['campaign_id']);

        return $this->_json_response(true, 'Data fetched', [
            'data' => [
                'campaign' => $campaign_data,
                'content' => $content_data,
            ]
        ]);
    }

    public function get_distribution_team()
    {
        $this->_check_ajax();

        $campaign_id = $this->input->get('campaign_id');
        if (empty($campaign_id)) {
            return $this->_json_response(false, 'Campaign ID required');
        }

        $distribution_team = $this->Model_distribution->get_distribution_team($campaign_id);
        if (!$distribution_team) {
            return $this->_json_response(false, 'Data not found');
        }

        foreach ($distribution_team as &$team) {
            $avatars = $team->profile_picture_team ? explode(',', $team->profile_picture_team) : [];
            $team->more_users = max(0, $team->jml_team - 5);
            $team->profile_picture_team = array_map(function ($avatar) {
                return 'https://trusmiverse.com/hr/uploads/profile/' . ($avatar ?: 'anonim.jpg');
            }, array_slice($avatars, 0, 5));
        }

        return $this->_json_response(true, 'Data fetched', ['data' => $distribution_team[0]]);
    }

    public function get_employees()
    {
        $this->_check_ajax();
        return $this->_json_response(true, 'Data fetched', ['data' => $this->Model_distribution->get_all_employees()]);
    }

    public function save_distribution_team()
    {
        $this->_check_ajax();

        $campaign_id = $this->input->post('campaign_id');
        $team = $this->input->post('team');

        if (empty($campaign_id)) {
            return $this->_json_response(false, 'Campaign ID required');
        }

        $team_str = is_array($team) ? implode(',', $team) : $team;

        if ($this->Model_distribution->update_distribution_team($campaign_id, $team_str)) {
            return $this->_json_response(true, 'Team updated successfully');
        }
        return $this->_json_response(false, 'Failed to update team');
    }

    public function get_plan_options()
    {
        $this->_check_ajax();

        $campaign_id = $this->input->get('campaign_id');
        if (empty($campaign_id)) {
            return $this->_json_response(false, 'Campaign ID required');
        }

        return $this->_json_response(true, 'Data fetched', [
            'data' => [
                'platforms' => $this->Model_distribution->get_platforms_dropdown(),
                'placements' => $this->Model_distribution->get_placements_dropdown(),
                'contents' => $this->Model_distribution->get_content_dropdown($campaign_id)
            ]
        ]);
    }

    public function save_distribution_plan()
    {
        $this->_check_ajax();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            show_404();

        $this->load->library('form_validation');
        $this->form_validation->set_rules('campaign_id', 'Campaign ID', 'required');
        $this->form_validation->set_rules('content_id', 'Content', 'required');
        $this->form_validation->set_rules('platform_id[]', 'Platform', 'required');
        $this->form_validation->set_rules('placement_id[]', 'Placement Type', 'required');
        $this->form_validation->set_rules('deadline_publish', 'Deadline Publish', 'required');

        if ($this->form_validation->run() == FALSE) {
            return $this->_json_response(false, validation_errors());
        }

        $distribution_id = $this->input->post('distribution_id');
        $campaign_id = $this->input->post('campaign_id');

        $data = [
            'campaign_id' => $campaign_id,
            'content_id' => $this->input->post('content_id'),
            'platform' => implode(',', $this->input->post('platform_id')),
            'placement_type' => implode(',', $this->input->post('placement_id')),
            'collaboration_type' => $this->input->post('collaboration_type'),
            'ads_budget_allocation' => str_replace('.', '', $this->input->post('ads_budget_allocation')),
            'deadline_publish' => $this->input->post('deadline_publish'),
            'audience_age' => $this->input->post('audience_age'),
            'audience_location' => $this->input->post('audience_location'),
            'audience_segment' => $this->input->post('audience_segment_val'),
            'audience_characteristics' => $this->input->post('audience_characteristics_val'),
            'tone_of_communication' => $this->input->post('tone_of_communication_val'),
        ];

        if (empty($distribution_id)) {
            $data['created_by'] = $this->session->userdata('user_id');
            $data['distribution_id'] = $this->Model_distribution->generate_distribution_id();

            $id = $this->Model_distribution->save_distribution_plan($data);

            if ($id) {
                $this->_log_activity($campaign_id, $id, 'CREATED', "Distribution plan created ($id)", $data);
                $campaign = $this->Model_campaign->get_campaign_statuses($data['campaign_id']);
                if ($campaign['distribution_status'] <= 1) {
                    $this->db->where('campaign_id', $data['campaign_id']);
                    $this->db->update('t_cmp_campaign', ['distribution_status' => 2]);
                }
                return $this->_json_response(true, 'Distribution plan saved successfully');
            }
            return $this->_json_response(false, 'Failed to save distribution plan');
        } else {
            if ($this->Model_distribution->update_distribution_plan($distribution_id, $data)) {
                $this->_log_activity($campaign_id, $distribution_id, 'UPDATED', 'Distribution plan updated', $data);
                return $this->_json_response(true, 'Distribution plan updated successfully');
            }
            return $this->_json_response(false, 'Failed to update distribution plan');
        }
    }

    public function delete_distribution_plan()
    {
        $this->_check_ajax();

        $id = $this->input->post('id');
        if (empty($id)) {
            return $this->_json_response(false, 'ID required');
        }

        $detail = $this->Model_distribution->get_distribution_detail($id);
        if ($this->Model_distribution->delete_distribution_plan($id)) {
            if ($detail) {
                $this->_log_activity($detail['campaign_id'], $id, 'DELETED', "Distribution plan deleted ({$detail['content_title']})", $detail);
            }
            return $this->_json_response(true, 'Plan deleted successfully');
        }
        return $this->_json_response(false, 'Failed to delete plan');
    }

    public function get_distribution_plan()
    {
        $this->_check_ajax();

        $campaign_id = $this->input->post('campaign_id') ?: $this->input->get('campaign_id');
        if (empty($campaign_id)) {
            return $this->_json_response(true, 'No Campaign ID', ['data' => []]);
        }

        $plans = $this->Model_distribution->get_distribution_plan($campaign_id);
        foreach ($plans as &$plan) {
            $avatars = $plan['profile_picture_team'] ? explode(',', $plan['profile_picture_team']) : [];
            $plan['more_users'] = max(0, $plan['jml_team'] - 3);
            $plan['profile_picture_team'] = array_map(function ($avatar) {
                return 'https://trusmiverse.com/hr/uploads/profile/' . ($avatar ?: 'anonim.jpg');
            }, array_slice($avatars, 0, 3));
        }

        return $this->_json_response(true, 'Data fetched', ['data' => $plans]);
    }

    public function get_distribution_detail($distribution_id)
    {
        $this->_check_ajax();

        $detail = $this->Model_distribution->get_distribution_detail($distribution_id);
        if (!$detail) {
            return $this->_json_response(false, 'Data not found');
        }

        $avatars = $detail['profile_picture_team'] ? explode(',', $detail['profile_picture_team']) : [];
        $detail['profile_picture_team'] = array_map(function ($avatar) {
            return 'https://trusmiverse.com/hr/uploads/profile/' . ($avatar ?: 'anonim.jpg');
        }, $avatars);

        // Analysis
        $analysis = $this->Model_distribution->get_distribution_analysis($distribution_id);
        $analysis_data = null;
        if ($analysis && isset($analysis['analysis_json'])) {
            $analysis_data = is_string($analysis['analysis_json']) ? json_decode($analysis['analysis_json'], true) : $analysis['analysis_json'];
            if (is_array($analysis_data) && isset($analysis_data[0]))
                $analysis_data = $analysis_data[0];
        }

        // Logs
        $logs = $this->Model_distribution->get_activity_logs($distribution_id);
        foreach ($logs as &$log) {
            $log['profile_picture'] = 'https://trusmiverse.com/hr/uploads/profile/' . ($log['profile_picture'] ?: 'anonim.jpg');
            $log['time_ago'] = $this->_time_elapsed_string($log['created_at']);
        }

        return $this->_json_response(true, 'Data fetched', [
            'data' => $detail,
            'analysis' => $analysis_data,
            'logs' => $logs
        ]);
    }

    private function _time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $weeks = floor($diff->d / 7);
        $days = $diff->d - ($weeks * 7);

        $string = [
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        ];
        foreach ($string as $k => &$v) {
            $value = ($k === 'w') ? $weeks : (($k === 'd') ? $days : $diff->$k);
            if ($value) {
                $v = $value . ' ' . $v . ($value > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full)
            $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
    public function approve_distribution_plan()
    {
        $this->_check_ajax();

        $id = $this->input->post('id');
        $target = $this->input->post('target');
        $detail_before = $this->Model_distribution->get_distribution_detail($id);

        if ($this->Model_distribution->approve_distribution_plan($id)) {
            // Update Actual count in Campaign
            if (($detail_before['status'] ?? 0) != 3) {
                $this->db->query("UPDATE t_cmp_campaign SET distribution_actual = COALESCE(distribution_actual,0) + 1 WHERE campaign_id = ?", [$detail_before['campaign_id']]);
            }
            $this->_log_activity($detail_before['campaign_id'], $id, 'STATUS_CHANGE', 'Distribution plan status changed to Approved', ['status_from' => $detail_before['status'], 'status_to' => 3]);
            $distributions = $this->Model_distribution->getDistributionsBySubStatus($detail_before['campaign_id'], '3');
            $update_campaign = [];
            if (count($distributions) >= $target) {
                $update_campaign = [
                    'distribution_status' => '3',
                    'distribution_approved_at' => date('Y-m-d H:i:s'),
                ];
            } elseif (count($distributions) < $target) {
                $update_campaign = [
                    'distribution_status' => '2',
                ];
            }
            $update_campaign['distribution_actual'] = count($distributions);

            $this->db->where('campaign_id', $detail_before['campaign_id']);
            $this->db->update('t_cmp_campaign', $update_campaign);
            return $this->_json_response(true, 'Plan approved successfully', ['data' => $detail_before]);
        }
        return $this->_json_response(false, 'Failed to approve plan');
    }

    public function cancel_approve_plan()
    {
        $this->_check_ajax();

        $id = $this->input->post('id');
        $target = $this->input->post('target');
        $detail_before = $this->Model_distribution->get_distribution_detail($id);
        if (empty($id)) {
            return $this->_json_response(false, 'ID required');
        }

        if ($this->Model_distribution->cancel_approve_plan($id)) {
            // Update Actual count in Campaign
            if (($detail_before['status'] ?? 0) == 3) {
                $this->db->query("UPDATE t_cmp_campaign SET distribution_actual = GREATEST(0, COALESCE(distribution_actual, 0) - 1) WHERE campaign_id = ?", [$detail_before['campaign_id']]);
            }
            $this->_log_activity($detail_before['campaign_id'], $id, 'STATUS_CHANGE', 'Distribution approval cancelled (Reverted to In Progress)', ['status_from' => 3, 'status_to' => 1]);
            $distributions = $this->Model_distribution->getDistributionBySubStatus($detail_before['campaign_id'], '3');
            $update_campaign = [];
            if (count($distributions) >= $target) {
                $update_campaign = [
                    'distribution_status' => '3',
                    'distribution_approved_at' => date('Y-m-d H:i:s'),
                ];
            } elseif (count($distributions) < $target) {
                $update_campaign = [
                    'distribution_status' => '2',
                ];
            }
            $update_campaign['distribution_actual'] = count($distributions);

            $this->db->where('campaign_id', $detail_before['campaign_id']);
            $this->db->update('t_cmp_campaign', $update_campaign);
            return $this->_json_response(true, 'Approval cancelled');
        }
        return $this->_json_response(false, 'Failed to cancel approval');
    }

    public function reject_plan()
    {
        $this->_check_ajax();

        $id = $this->input->post('id');
        $note = $this->input->post('note');
        $status = $this->input->post('status') ?: 4;

        if (empty($id)) {
            return $this->_json_response(false, 'ID required');
        }

        $detail_before = $this->Model_distribution->get_distribution_detail($id);

        $this->db->where('distribution_id', $id);
        if ($this->db->update('t_cmp_distribution', ['status' => $status, 'note' => $note])) {
            // Update Actual count in Campaign if moving from Approved to Rejected/Revision
            if (($detail_before['status'] ?? 0) == 3) {
                $this->db->query("UPDATE t_cmp_campaign SET distribution_actual = GREATEST(0, COALESCE(distribution_actual, 0) - 1) WHERE campaign_id = ?", [$detail_before['campaign_id']]);
            }

            $action_desc = ($status == 4) ? 'Rejected' : 'Revision';
            $this->_log_activity($detail_before['campaign_id'], $id, 'STATUS_CHANGE', "Updated distribution plan $id status to $action_desc. Note: " . ($note ?: 'No note'), ['status_from' => $detail_before['status'], 'status_to' => $status, 'note' => $note]);
            return $this->_json_response(true, "Plan $action_desc successfully");
        }
        return $this->_json_response(false, 'Failed to update plan status');
    }
    public function get_distribution_logs()
    {
        $this->_check_ajax();

        $campaign_id = $this->input->get('campaign_id');
        if (empty($campaign_id)) {
            return $this->_json_response(false, 'Campaign ID required');
        }

        $logs = $this->Model_distribution->get_distribution_logs($campaign_id);
        foreach ($logs as &$log) {
            $log['profile_picture'] = 'https://trusmiverse.com/hr/uploads/profile/' . ($log['profile_picture'] ?: 'anonim.jpg');
            $log['time_ago'] = $this->_time_elapsed_string($log['created_at']);
        }

        return $this->_json_response(true, 'Data fetched', ['data' => $logs]);
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
            ->where('c.phase', 'distribution')
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
            'phase' => 'distribution',
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

    public function analysis_ai()
    {
        $this->_check_ajax();

        $distribution_id = $this->input->post('distribution_id');
        $re_analyze = $this->input->post('re_analyze');

        if (!$distribution_id) {
            return $this->_json_response(false, 'Distribution ID is required');
        }

        if ($re_analyze !== 'true') {
            $existing = $this->Model_distribution->get_distribution_analysis($distribution_id);
            if ($existing) {
                $data = is_string($existing['analysis_json']) ? json_decode($existing['analysis_json'], true) : $existing['analysis_json'];
                if (isset($data[0]))
                    $data = $data[0];
                return $this->_json_response(true, 'Cached analysis found', ['data' => $data]);
            }
        }

        $data_raw = $this->Model_distribution->get_distribution_analysis_data($distribution_id);
        $data_content = $this->Model_distribution->get_content_by_id($data_raw['content_id']);

        if (!$data_raw) {
            return $this->_json_response(false, 'Distribution data not found');
        }

        $payload = [
            'campaign_metadata' => [
                'project_name' => $data_raw['project_name'],
                'campaign_goal' => $data_raw['campaign_goal']
            ],
            'content_data' => [
                'title' => $data_content['title'],
                'platform' => $data_content['platform_name'],
                'format' => $data_content['format_name'],
                'content_pillar' => $data_content['content_pillar_name'],
                'talent_type' => $data_content['talent_type_name'],
                'hook' => $data_content['hook'],
                'pain_point' => $data_content['pain_point'],
                'trigger_emotion' => $data_content['trigger_emotion']
            ],
            'distribution_data' => [
                'audience_segment' => $data_raw['audience_segment'],
                'audience_age' => $data_raw['audience_age'],
                'audience_location' => $data_raw['audience_location'],
                'audience_characteristics' => $data_raw['audience_characteristics'],
                'tone_of_communication' => $data_raw['tone_of_communication'],
                'collaboration_type' => $data_raw['collaboration_type'],
                'ads_budget_allocation' => (int) $data_raw['ads_budget_allocation'],
                'deadline_publish' => $data_raw['deadline_publish'],
                'platform' => $data_raw['platform'],
                'placement_type' => $data_raw['placement_type']
            ]
        ];

        $ch = curl_init('https://n8n.trustcore.id/webhook/compas-swot-distribution-c8769381-40ab-46bd-8c9b-7a773f88c162');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $n8n_data = json_decode($response, true);
        if ($http_code == 200 && $n8n_data) {
            $result_object = (isset($n8n_data[0]) && is_array($n8n_data[0])) ? $n8n_data[0] : $n8n_data;
            $score = $result_object['viability_analysis']['score'] ?? 0;

            $this->Model_distribution->save_distribution_analysis([
                'distribution_id' => $distribution_id,
                'viability_score' => $score,
                'analysis_json' => json_encode($n8n_data)
            ]);

            return $this->_json_response(true, 'Analysis complete', ['data' => $result_object]);
        }

        return $this->_json_response(false, 'Failed to retrieve analysis from AI service', ['debug' => $response]);
    }

    public function get_team_performance_stats()
    {
        $this->_check_ajax();

        $campaign_id = $this->input->get('campaign_id');
        if (empty($campaign_id)) {
            return $this->_json_response(false, 'Campaign ID required');
        }

        return $this->_json_response(true, 'Data fetched', ['data' => $this->Model_distribution->get_distribution_performance_stats($campaign_id)]);
    }

    public function generate_ai_distribution_plan()
    {
        $this->_check_ajax();

        $user_prompt = $this->input->post('user_prompt');
        $content_context = $this->input->post('content_context');
        $content_id = $this->input->post('content_id');

        $content_detail_context = "";
        if (!empty($content_id)) {
            $content = $this->Model_distribution->get_content_by_id($content_id);
            if ($content) {
                $content_detail_context = "
---
📝 KONTEN YANG AKAN DIDISTRIBUSIKAN:
Berikut adalah detail konten yang sudah diproduksi dan PERLU didistribusikan. Gunakan informasi ini untuk menajamkan strategi distribusi agar relevan dengan isi konten.

- Judul Konten: " . ($content['title'] ?? '-') . "
- Platform Produksi: " . ($content['platform_name'] ?? '-') . "
- Format Konten: " . ($content['format_name'] ?? '-') . "
- Pilar Konten: " . ($content['content_pillar_name'] ?? '-') . "
- Tipe Talent: " . ($content['talent_type_name'] ?? '-') . "
- Hook (Daya Tarik): " . ($content['hook'] ?? '-') . "
- Pain Point Audiens: " . ($content['pain_point'] ?? '-') . "
- Trigger Emotion: " . ($content['trigger_emotion'] ?? '-') . "
---";
            }
        }

        $platforms = $this->db->select('platform_id, platform_name')->where('is_active', 1)->get('m_cmp_platform')->result_array();
        $placements = $this->db->select('placement_id, placement_name')->where('is_active', 1)->get('m_cmp_placement')->result_array();
        $master_data = json_encode(['platforms' => $platforms, 'placements' => $placements]);

        $system_prompt = "Anda adalah Konsultan Strategi Distribusi Konten Digital Senior.
Tugas Anda adalah merancang rencana distribusi konten yang efektif dan terukur untuk kampanye pemasaran digital, berdasarkan input pengguna dan MASTER DATA yang disediakan.

---

🎯 PERAN & KONTEKS:
Anda ahli dalam memilih saluran distribusi (platform & placement) yang tepat untuk mencapai target audiens spesifik di Indonesia. Anda memahami nuansa setiap platform (Instagram, TikTok, YouTube, dll.) dan format konten yang bekerja paling baik di masing-masing placement (Feed, Story, Reels, Shorts, dll.).

---

📋 INSTRUKSI UTAMA:

1. **Analisis Input Pengguna & Konteks Konten**
   - Gunakan `content_context` (jika ada) untuk memahami topik dan jenis konten yang akan didistribusikan.
   - PENTING: Gunakan DATA KONTEN DETAIL (jika tersedia) untuk menyesuaikan target audiens dan tone of communication agar selaras dengan 'Hook', 'Pain Point', dan 'Trigger Emotion' konten tersebut.
   - Gunakan `user_prompt` untuk memahami arahan spesifik pengguna (misal: 'fokus ke gen z', 'budget minim', dll.).
   - Jika input minim, buat rencana distribusi yang paling optimal untuk konten digital umum di Indonesia saat ini.

2. **Pemilihan Saluran Distribusi (Platform & Placement)**
   - Pilih `platform_id` dari daftar `platforms` di MASTER DATA. (Bisa array/multiple)
   - Pilih `placement_id` dari daftar `placements` di MASTER DATA. (Bisa array/multiple)
   - Pastikan pemilihan placement relevan dengan platform yang dipilih (meskipun ID-nya terpisah, gunakan logika umum: misal Reels cocok dengan Instagram, Shorts dengan YouTube).

3. **Detail Strategi & Audiens**
   - Tentukan `collaboration_type` (e.g., Paid, Organic, Barter, KOL Collaboration).
   - Tentukan `ads_budget_allocation` (Anggaran Iklan) yang realistis dalam Rupiah.
   - Tentukan profil audiens (`audience_age`, `audience_location`, `audience_segment`, `audience_characteristics`) secara spesifik dan mendetail.
   - Tentukan `tone_of_communication` yang sesuai dengan audiens dan platform.

4. **Waktu Tayang (Deadline Publish)**
   - Tanggal saat ini adalah: " . date('Y-m-d H:i:s') . "
   - Tentukan `deadline_publish` yang ideal, biasanya 3-7 hari dari sekarang atau sesuaikan dengan urgensi.

---

📊 MASTER DATA:
$master_data

---

📤 FORMAT OUTPUT JSON (Wajib diikuti secara ketat):
{
    \"platform_id\": [Array of Integers/Strings corresponding to platform_id],
    \"placement_id\": [Array of Integers/Strings corresponding to placement_id],
    \"collaboration_type\": \"String (e.g., Paid, Organic)\",
    \"ads_budget_allocation\": Integer (Rupiah, tanpa titik/koma),
    ne_publish\": \"YYYY-MM-DD HH:mm:ss\",
    \"audience_age\": \"String (e.g., 18-24, 25-34)\",
    \"audience_location\": \"String (e.g., Jabodetabek, Surabaya, Kota Besar di Indonesia)\",
    \"audience_segment\": \"String (Deskripsi segmen audiens, min. 2 kalimat)\",
    \"audience_characteristics\": \"String (Deskripsi psikografis & perilaku audiens, min. 2 kalimat)\",
    \"tone_of_communication\": \"String (Gaya bahasa & penyampaian, min. 1 kalimat)\"
}

⚠️ CONSTRAINT AKHIR:
- Output HANYA berupa JSON murni.
- Bahasa Indonesia yang profesional.
- JSON harus valid.";

        // Payload to send to n8n
        $final_user_prompt = "Context/Topic: $content_context. User Request: " . ($user_prompt ?: "Buatkan strategi distribusi yang efektif") . $content_detail_context;

        $payload = [
            'system_prompt' => $system_prompt,
            'user_prompt' => $final_user_prompt
        ];

        $ch = curl_init("https://n8n.trustcore.id/webhook/compas-dynamic-generative-input-c8769381-40ab-46bd-8c9b-7a773f88c162");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code === 200) {
            $result = json_decode($response, true);
            $data = $result['output'] ?? $result;
            if (is_string($data))
                $data = json_decode($data, true) ?: $data;
            return $this->_json_response(true, 'AI plan generated', ['data' => $data]);
        }

        // Fallback
        return $this->_json_response(true, 'Generated fallback (service unavailable)', [
            'data' => [
                'platform_id' => [1],
                'placement_id' => [2],
                'collaboration_type' => 'Organic',
                'ads_budget_allocation' => 500000,
                'deadline_publish' => date('Y-m-d H:i:s', strtotime('+3 days')),
                'audience_age' => '18-35',
                'audience_location' => 'Jabodetabek',
                'audience_segment' => 'Gen Z & Milenial',
                'audience_characteristics' => 'Aktif di sosmed',
                'tone_of_communication' => 'Kasual'
            ]
        ]);
    }

    public function get_distribution_stats()
    {
        $stats = $this->Model_distribution->getDistributionStats();
        return $this->_json_response(true, 'Stats fetched', [
            'data' => [
                'avg_lead_days' => $stats['avg_lead_days'] ?? 0,
                'avg_ai_score' => $stats['avg_ai_score'] ?? 0,
                'total_submissions' => $stats['total_submissions'] ?? 0,
                'approved_plans' => $stats['approved_plans'] ?? 0,
            ]
        ]);
    }
}