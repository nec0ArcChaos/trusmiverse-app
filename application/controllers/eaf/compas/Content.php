<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('compas/model_content');
        $this->load->model('compas/model_campaign');
        $this->load->model('compas/model_activation');
        if (!$this->session->userdata('user_id')) {
            echo json_encode(['status' => false, 'message' => 'Session expired']);
            exit;
        }
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
            'phase' => 'content',
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
        $campaigns = $this->model_content->get_campaigns_by_date($start, $end);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'data' => $campaigns,
            ]));
    }

    public function detail()
    {
        $campaign_id = $this->input->post('campaign_id');
        $content_plan = $this->model_content->get_content_plan($campaign_id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'campaign_id' => $campaign_id,
                'content' => $content_plan,
            ]));
    }

    public function get_approved_activations()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $campaign_id = $this->input->get('campaign_id');
        $page = $this->input->get('page') ? (int) $this->input->get('page') : 1;
        $limit = 3;
        $start = ($page - 1) * $limit;

        if (empty($campaign_id)) {
            echo json_encode(['status' => false, 'message' => 'Campaign ID required']);
            return;
        }

        $activations = $this->model_content->get_approved_activations($campaign_id, $limit, $start);
        $total_records = $this->model_content->count_approved_activations($campaign_id);
        $total_pages = ceil($total_records['total'] / $limit);

        echo json_encode([
            'status' => true,
            'data' => $activations,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $total_pages,
                'total_records' => $total_records
            ]
        ]);
    }

    public function get_activation_detail()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id = $this->input->get('id');

        if (empty($id)) {
            echo json_encode(['status' => false, 'message' => 'ID required']);
            return;
        }

        $activation_data = $this->model_content->get_activation_by_id($id);
        $campaign_data = $this->model_campaign->get_campaign_by_id($activation_data['campaign_id']);

        if ($activation_data && $campaign_data) {
            echo json_encode([
                'status' => true,
                'data' => [
                    'campaign' => $campaign_data,
                    'activation' => $activation_data,
                ]
            ]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Data not found']);
        }
    }

    function get_content_team()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $campaign_id = $this->input->get('campaign_id');

        if (empty($campaign_id)) {
            echo json_encode(['status' => false, 'message' => 'Campaign ID required']);
            return;
        }

        $content_team = $this->model_content->get_content_team($campaign_id);
        foreach ($content_team as $key => $value) {
            // string by , to array tapi ambil hanya 5 jika data lebih dari 5
            $avatars = $value->profile_picture_team ? explode(',', $value->profile_picture_team) : [];
            $count_avatars = count($avatars);
            if ($count_avatars > 5) {
                $more_users = max(0, $value->jml_team - 5);
                $avatars = array_slice($avatars, 0, 5);
            } else {
                $more_users = max(0, $value->jml_team - 5);
            }

            // add https://trusmiverse.com/hr/uploads/profile/ to each avatar
            $avatars = array_map(function ($avatar) {
                if ($avatar != '') {
                    return 'https://trusmiverse.com/hr/uploads/profile/' . $avatar;
                } else {
                    return 'https://trusmiverse.com/hr/uploads/profile/anonim.jpg';
                }
            }, $avatars);
            $content_team[$key]->profile_picture_team = $avatars;
            $content_team[$key]->more_users = $more_users;
        }
        if ($content_team) {
            echo json_encode([
                'status' => true,
                'data' => $content_team[0],
            ]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Data not found']);
        }
    }

    public function get_employees()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $employees = $this->model_content->get_all_employees();
        echo json_encode(['status' => true, 'data' => $employees]);
    }

    public function save_content_team()
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

        // Convert array to comma separated string if it's an array
        if (is_array($team)) {
            $team_str = implode(',', $team);
        } else {
            $team_str = $team; // Should be empty or string if coming from select2/chosen sometimes
        }

        if ($this->model_content->update_content_team($campaign_id, $team_str)) {
            echo json_encode(['status' => true, 'message' => 'Team updated successfully']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to update team']);
        }
    }

    public function delete_content_plan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id = $this->input->post('id');

        if (empty($id)) {
            echo json_encode(['status' => false, 'message' => 'ID required']);
            return;
        }

        // Get details for log before delete? Or just delete.
        // Let's get campaign_id for log
        $detail = $this->model_content->get_content_detail($id);

        if ($this->model_content->delete_content_plan($id)) {
            if ($detail) {
                $log_data = [
                    'campaign_id' => $detail['campaign_id'],
                    'phase_id' => $id, // ID is deleted but we keep track
                    'phase' => 'content',
                    'user_id' => $this->session->userdata('user_id'),
                    'action_type' => 'DELETED', // Make sure enum supports DELETED or just use UPDATED with desc
                    'description' => 'Content plan has been deleted',
                    'details' => json_encode(['id' => $id, 'title' => $detail['title']]),
                ];
                // Check if action_type allows DELETED, schema comment said: STATUS_CHANGE, PROGRESS_UPDATE, NOTE_ADDED, FILE_UPLOADED, CREATED, UPDATED
                // Let's use UPDATED for now or check schema. Schema comment is just comment.
                $log_data['action_type'] = 'UPDATED';
                $this->db->insert('t_cmp_activity_logs', $log_data);
            }

            echo json_encode(['status' => true, 'message' => 'Plan deleted successfully']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to delete plan']);
        }
    }

    public function get_content_plan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $campaign_id = empty($this->input->post('campaign_id')) ? $this->input->get('campaign_id') : $this->input->post('campaign_id');
        if (empty($campaign_id)) {
            // Check GET as fallback or for initial load if passed via URL? 
            // User asked for "ajax post", let's strict to POST or check both.
            $campaign_id = $this->input->get('campaign_id');
        }

        if (empty($campaign_id)) {
            echo json_encode(['data' => []]); // Empty data for DataTables
            return;
        }

        $content_plan = $this->model_content->get_content_plan($campaign_id);
        foreach ($content_plan as $key => $value) {
            // string by , to array tapi ambil hanya 3 jika data lebih dari 3
            $avatars = $value['profile_picture_team'] ? explode(',', $value['profile_picture_team']) : [];
            $count_avatars = count($avatars);
            if ($count_avatars > 3) {
                $more_users = max(0, $value['jml_team'] - 3);
                $avatars = array_slice($avatars, 0, 3);
            } else {
                $more_users = max(0, $value['jml_team'] - 3);
            }

            // add https://trusmiverse.com/hr/uploads/profile/ to each avatar
            $avatars = array_map(function ($avatar) {
                return 'https://trusmiverse.com/hr/uploads/profile/' . $avatar;
            }, $avatars);
            $content_plan[$key]['profile_picture_team'] = $avatars;
            $content_plan[$key]['more_users'] = $more_users;
        }
        echo json_encode(['data' => $content_plan]);
    }

    public function get_content_detail()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $content_id = $this->input->get('content_id');

        $content_detail = $this->model_content->get_content_detail($content_id);

        if (!$content_detail) {
            echo json_encode(['status' => false, 'message' => 'Data not found']);
            return;
        }

        // string by , to array tapi ambil hanya 3 jika data lebih dari 3
        $avatars = $content_detail['profile_picture_team'] ? explode(',', $content_detail['profile_picture_team']) : [];
        // add https://trusmiverse.com/hr/uploads/profile/ to each avatar
        $avatars = array_map(function ($avatar) {
            return 'https://trusmiverse.com/hr/uploads/profile/' . $avatar;
        }, $avatars);
        $content_detail['profile_picture_team'] = $avatars;

        // Get AI Analysis if exists
        $analysis = $this->model_content->get_content_analysis($content_id);
        if ($analysis && isset($analysis['analysis_json'])) {
            $analysis_data = $analysis['analysis_json'];
            if (is_string($analysis_data)) {
                $analysis_data = json_decode($analysis_data, true);
            }
            // If wrapped in array
            if (isset($analysis_data[0])) {
                $analysis_data = $analysis_data[0];
            }
            $analysis = $analysis_data;
        }

        // Get logs
        $logs = $this->model_content->get_activity_logs($content_id);
        // Process logs avatar
        foreach ($logs as &$log) {
            if ($log['profile_picture']) {
                $log['profile_picture'] = 'https://trusmiverse.com/hr/uploads/profile/' . $log['profile_picture'];
            } else {
                $log['profile_picture'] = 'https://trusmiverse.com/hr/uploads/profile/anonim.jpg';
            }
            $log['time_ago'] = $this->time_elapsed_string($log['created_at']);
        }

        echo json_encode([
            'status' => true,
            'data' => $content_detail,
            'analysis' => $analysis,
            'logs' => $logs
        ]);
    }

    private function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $weeks = floor($diff->d / 7);
        $days = $diff->d - ($weeks * 7);

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($k === 'w') {
                $value = $weeks;
            } elseif ($k === 'd') {
                $value = $days;
            } else {
                $value = $diff->$k;
            }

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
    public function approve_content_plan()
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

        if ($this->model_content->approve_content_plan($id)) {
            // Activity Log
            // Get campaign_id first (we could implement a quick fetch or trust the ID for now)
            // Ideally we need campaign_id for the log, let's fetch basic info
            $detail = $this->model_content->get_content_detail($id);

            $log_data = [
                'campaign_id' => $detail['campaign_id'],
                'phase_id' => $id,
                'phase' => 'content',
                'user_id' => $this->session->userdata('user_id'),
                'action_type' => 'STATUS_CHANGE',
                'description' => 'Content plan status changed to Approved',
                'details' => json_encode(['status_from' => $detail['status'], 'status_to' => 3]),
            ];
            $this->db->insert('t_cmp_activity_logs', $log_data);
            $contents = $this->model_content->getContentsBySubStatus($detail['campaign_id'], '3');
            $campaign = $this->model_campaign->get_campaign_statuses($detail['campaign_id']);
            $update_campaign = [];
            if (count($contents) >= $target) {
                $update_campaign = [
                    'content_status' => '3',
                    'content_approved_at' => date('Y-m-d H:i:s'),
                ];
            } elseif (count($contents) < $target) {
                $update_campaign = [
                    'content_status' => '2',
                ];
            }
            $update_campaign['content_actual'] = count($contents);
            if (!$campaign['talent_status'] || empty($campaign['talent_status'])) {
                $update_campaign['talent_status'] = '1';
            }
            if (!$campaign['distribution_status'] || empty($campaign['distribution_status'])) {
                $update_campaign['distribution_status'] = '1';
            }
            if (!$campaign['optimization_status'] || empty($campaign['optimization_status'])) {
                $update_campaign['optimization_status'] = '1';
            }

            $this->db->where('campaign_id', $detail['campaign_id']);
            $this->db->update('t_cmp_campaign', $update_campaign);

            echo json_encode(['status' => true, 'message' => 'Plan approved successfully']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to approve plan']);
        }
    }

    public function cancel_approve_plan()
    {
        if (!$this->input->is_ajax_request())
            show_404();
        $id = $this->input->post('id');
        $target = $this->input->post('target');
        if (empty($id)) {
            echo json_encode(['status' => false, 'message' => 'ID required']);
            return;
        }

        if ($this->model_content->cancel_approve_plan($id)) {
            $detail = $this->model_content->get_content_detail($id);
            $log_data = [
                'campaign_id' => $detail['campaign_id'],
                'phase_id' => $id,
                'phase' => 'content',
                'user_id' => $this->session->userdata('user_id'),
                'action_type' => 'STATUS_CHANGE',
                'description' => 'Content approval cancelled (Reverted to Draft)',
                'details' => json_encode(['status_from' => 3, 'status_to' => 1]),
            ];
            $this->db->insert('t_cmp_activity_logs', $log_data);

            $contents = $this->model_content->getContentsBySubStatus($detail['campaign_id'], '3');
            $update_campaign['content_actual'] = count($contents);
            if (count($contents) < $target) {
                $update_campaign['content_status'] = '2';
            }

            $this->db->where('campaign_id', $detail['campaign_id']);
            $this->db->update('t_cmp_campaign', $update_campaign);
            echo json_encode(['status' => true, 'message' => 'Approval cancelled']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to cancel approval']);
        }
    }

    public function reject_content_plan()
    {
        if (!$this->input->is_ajax_request())
            show_404();
        $id = $this->input->post('id');
        $note = $this->input->post('note');
        $status = $this->input->post('status') ?: 4;

        if (empty($id)) {
            echo json_encode(['status' => false, 'message' => 'ID required']);
            return;
        }

        if ($this->model_content->reject_plan($id, $status)) {
            $detail = $this->model_content->get_content_detail($id);
            $action_desc = ($status == 4) ? 'Rejected' : 'Revision';
            $this->_log_activity($detail['campaign_id'], $id, 'STATUS_CHANGE', "Updated content plan $id status to $action_desc. Note: " . ($note ?: 'No note'), ['status_from' => $detail['status'], 'status_to' => $status, 'note' => $note]);
            return $this->_json_response(true, "Plan $action_desc successfully");
        }
        return $this->_json_response(false, 'Failed to reject plan status');
    }
    public function get_content_logs()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $campaign_id = $this->input->get('campaign_id');
        if (empty($campaign_id)) {
            echo json_encode(['status' => false, 'message' => 'Campaign ID required']);
            return;
        }

        $logs = $this->model_content->get_content_logs($campaign_id);

        foreach ($logs as &$log) {
            if ($log['profile_picture']) {
                $log['profile_picture'] = 'https://trusmiverse.com/hr/uploads/profile/' . $log['profile_picture'];
            } else {
                $log['profile_picture'] = 'https://trusmiverse.com/hr/uploads/profile/anonim.jpg';
            }
            $log['time_ago'] = $this->time_elapsed_string($log['created_at']);
        }

        echo json_encode(['status' => true, 'data' => $logs]);
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
            ->where('c.phase', 'content')
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
            'phase' => 'content',
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

    public function get_content_stats()
    {
        $stats = $this->model_content->getContentStats();
        return $this->_json_response(true, 'Stats fetched', [
            'data' => [
                'avg_lead_days' => $stats['avg_lead_days'] ?? 0,
                'avg_ai_score' => $stats['avg_ai_score'] ?? 0,
                'total_submissions' => $stats['total_submissions'] ?? 0,
                'approved_plans' => $stats['approved_plans'] ?? 0,
            ]
        ]);
    }

    public function analysis_ai()
    {
        header('Content-Type: application/json');
        $content_id = $this->input->post('content_id');
        $re_analyze = $this->input->post('re_analyze');

        if (!$content_id) {
            echo json_encode(['status' => 'error', 'message' => 'Content ID is required']);
            return;
        }

        if ($re_analyze !== 'true') {
            $existing = $this->model_content->get_content_analysis($content_id);
            if ($existing) {
                $data = json_decode($existing['analysis_json'], true);
                if (isset($data[0]))
                    $data = $data[0];
                echo json_encode(['status' => 'success', 'data' => $data]);
                return;
            }
        }

        $result = $this->analysis_content($content_id);
        echo json_encode($result);
    }
    private function analysis_content($content_id)
    {
        $content_data = $this->model_content->get_content_analysis_data($content_id);
        $activation_data = $this->model_activation->getActivationForAnalysis($content_data['activation_id']);
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

        $data = [
            "campaign_data" => $campaign_data,
            "activation_data" => $activation_data,
            "content_data" => $content_data,
            "phase" => 'content'
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

            // Extract viability score
            $score = 0;
            if (isset($n8n_result['skor_keseluruhan'])) {
                $score = (int) $n8n_result['skor_keseluruhan'];
            }

            // Prepare DB Data
            $db_data = [
                'content_id' => $content_id,
                'viability_score' => $score,
                'analysis_json' => json_encode($n8n_data) // Store exactly what n8n returns or the normalized object
            ];
            // Map JSON to DB columns
            // $db_data = [
            //     'content_id' => $content_id,
            //     'analysis_date' => date('Y-m-d'),
            //     'event_name' => $n8n_result['nama_event'] ?? null,
            //     'overall_score' => $n8n_result['skor_keseluruhan'] ?? null,
            //     'strategic_score' => $n8n_result['skor_kesesuaian_strategis'] ?? null,
            //     'detail_alignment' => isset($n8n_result['detail_alignment']) ? json_encode($n8n_result['detail_alignment']) : null,
            //     'swot_strengths' => isset($n8n_result['analisis_swot']['strengths']) ? json_encode($n8n_result['analisis_swot']['strengths']) : null,
            //     'swot_weaknesses' => isset($n8n_result['analisis_swot']['weaknesses']) ? json_encode($n8n_result['analisis_swot']['weaknesses']) : null,
            //     'swot_opportunities' => isset($n8n_result['analisis_swot']['opportunities']) ? json_encode($n8n_result['analisis_swot']['opportunities']) : null,
            //     'swot_threats' => isset($n8n_result['analisis_swot']['threats']) ? json_encode($n8n_result['analisis_swot']['threats']) : null,
            //     'funnel_impact' => isset($n8n_result['dampak_funnel']) ? json_encode($n8n_result['dampak_funnel']) : null,
            //     'performance_estimation' => isset($n8n_result['estimasi_performa']) ? json_encode($n8n_result['estimasi_performa']) : null,
            //     'budget_analysis' => isset($n8n_result['analisis_anggaran']) ? json_encode($n8n_result['analisis_anggaran']) : null,
            //     'risk_analysis' => isset($n8n_result['analisis_risiko']) ? json_encode($n8n_result['analisis_risiko']) : null,
            //     'recommendations' => isset($n8n_result['rekomendasi']) ? json_encode($n8n_result['rekomendasi']) : null,
            //     'executive_summary' => isset($n8n_result['ringkasan_eksekutif']) ? json_encode($n8n_result['ringkasan_eksekutif']) : null,
            // ];

            // Save to database
            $this->model_content->save_content_analysis($db_data);

            return $n8n_result;

        } else {
            return ['status' => 'error', 'message' => 'Failed to retrieve analysis from AI service.'];
        }

    }
    public function get_team_performance_stats()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $campaign_id = $this->input->get('campaign_id');
        if (empty($campaign_id)) {
            echo json_encode(['status' => false, 'message' => 'Campaign ID required']);
            return;
        }

        $stats = $this->model_content->get_content_performance_stats($campaign_id);
        echo json_encode(['status' => true, 'data' => $stats]);
    }




    public function save_content_plan()
    {
        if (!$this->input->is_ajax_request() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            show_404();
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('campaign_id', 'Campaign ID', 'required');
        $this->form_validation->set_rules('activation_id', 'Activation Strategy', 'required');
        $this->form_validation->set_rules('title', 'Title', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => false, 'message' => validation_errors()]);
            return;
        }

        $content_id = $this->input->post('content_id');

        // Helper to handle array inputs
        $handleArray = function ($input) {
            return is_array($input) ? implode(',', $input) : $input;
        };

        $data = [
            'campaign_id' => $this->input->post('campaign_id'),
            'activation_id' => $this->input->post('activation_id'),
            'title' => $this->input->post('title'),

            // Multiple Selects
            'platform' => $handleArray($this->input->post('platform')),
            'placement_type' => $handleArray($this->input->post('placement_type')),
            'format' => $handleArray($this->input->post('format')),
            'content_pillar' => $handleArray($this->input->post('content_pillar')),
            'talent_type' => $handleArray($this->input->post('talent_type')),

            // Dates and Duration
            'publish_date' => $this->input->post('publish_date'),
            'deadline_publish' => $this->input->post('deadline_publish'),
            'duration_desc' => $this->input->post('duration_desc'),

            // Talent Details
            'talent_cost' => str_replace('.', '', $this->input->post('talent_cost')),
            'talent_persona' => $this->input->post('talent_persona'),
            'talent_target' => (int) ($this->input->post('talent_target') ?: 0),

            // Content Strategy
            'pain_point' => $this->input->post('pain_point'),
            'trigger_emotion' => $this->input->post('trigger_emotion'),
            'consumption_behavior' => $this->input->post('consumption_behavior'),
            'hook' => $this->input->post('hook'),

            // Creative Assets
            'script_content' => $this->input->post('script_content'),
            'storyboard' => $this->input->post('storyboard'),
            'audio_notes' => $this->input->post('audio_notes'),
            'reference_link' => $this->input->post('reference_link'),

            // Other fields (handle if they exist in form or default to null/empty)
            'status' => $this->input->post('status') ? $this->input->post('status') : 1, // Default status?
            'team_involved' => $this->input->post('team_involved'),

            // Fields seemingly removed or not in current modal logic, but keeping if DB requires them or logic needs them
            // 'trigger_consequence', 'consequence_action', 'ai_scoring_rules', 'sla_desc' - removed from modal?
            // If they are not in the form, input->post will be null.
        ];

        if (empty($content_id)) {
            $data['created_by'] = $this->session->userdata('user_id');
            $insert_id = $this->model_content->save_content_plan($data);

            if ($insert_id) {
                // Activity Log
                $log_data = [
                    'campaign_id' => $data['campaign_id'],
                    'phase_id' => $insert_id,
                    'phase' => 'content',
                    'user_id' => $this->session->userdata('user_id'),
                    'action_type' => 'CREATED',
                    'description' => 'Content plan has been created',
                    'details' => json_encode($data),
                ];
                $this->db->insert('t_cmp_activity_logs', $log_data);
                $campaign = $this->model_campaign->get_campaign_statuses($data['campaign_id']);
                if ($campaign['content_status'] <= 1) {
                    $this->db->where('campaign_id', $data['campaign_id']);
                    $this->db->update('t_cmp_campaign', ['content_status' => 2]);
                }
                echo json_encode(['status' => true, 'message' => 'Content plan saved successfully']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Failed to save content plan']);
            }
        } else {
            if ($this->model_content->update_content_plan($content_id, $data)) {
                // Activity Log
                $log_data = [
                    'campaign_id' => $data['campaign_id'],
                    'phase_id' => $content_id,
                    'phase' => 'content',
                    'user_id' => $this->session->userdata('user_id'),
                    'action_type' => 'UPDATED',
                    'description' => 'Content plan has been updated',
                    'details' => json_encode($data),
                ];
                $this->db->insert('t_cmp_activity_logs', $log_data);

                echo json_encode(['status' => true, 'message' => 'Content plan updated successfully']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Failed to update content plan']);
            }
        }
    }

    public function get_plan_options()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $campaign_id = $this->input->get('campaign_id');
        if (empty($campaign_id)) {
            echo json_encode(['status' => false, 'message' => 'Campaign ID required']);
            return;
        }

        $activations = $this->model_content->get_activation_strategies_dropdown($campaign_id);
        $platforms = $this->model_content->get_platforms_dropdown();
        $placement_types = $this->model_content->get_placements_dropdown();
        $pillars = $this->model_content->get_content_pillars_dropdown();
        $formats = $this->model_content->get_content_formats_dropdown();
        $talent_types = $this->model_content->get_talent_type_dropdown();

        echo json_encode([
            'status' => true,
            'data' => [
                'activations' => $activations,
                'platforms' => $platforms,
                'placement_types' => $placement_types,
                'pillars' => $pillars,
                'formats' => $formats,
                'talent_types' => $talent_types
            ]
        ]);
    }

    // ─── AI Content Plan Generation ───────────────────────────────────────────

    public function generate_ai_content()
    {
        header('Content-Type: application/json');

        if (!$this->input->is_ajax_request() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => false, 'message' => 'Invalid request']);
            return;
        }

        $campaign_id = $this->input->post('campaign_id');
        $activation_id = $this->input->post('activation_id');
        $user_prompt = $this->input->post('user_prompt') ?? '';

        // ── Master Data ──────────────────────────────────────────────────────
        $platforms = $this->db
            ->select('platform_id, platform_name')
            ->get('m_platform')
            ->result_array();

        $placements = $this->db
            ->select('placement_id, placement_name')
            ->get('m_placement_type')
            ->result_array();

        $pillars = $this->db
            ->select('pillar_id, pillar_name')
            ->get('m_content_pillar')
            ->result_array();

        $formats = $this->db
            ->select('format_id, format_name')
            ->get('m_content_format')
            ->result_array();

        $talent_types = $this->db
            ->select('talent_type_id, talent_type_name')
            ->get('m_talent_type')
            ->result_array();

        $employees = $this->db
            ->select('user_id, CONCAT(first_name, " ", last_name) as full_name, email')
            ->from('xin_employees')
            ->where('is_active', 1)
            ->get()
            ->result_array();

        // ── Activation Context ────────────────────────────────────────────────
        $activation_context = null;
        if (!empty($activation_id)) {
            $activation_context = $this->db
                ->select('activation_id, title, description, target_audience, period_start, period_end, budget')
                ->where('activation_id', $activation_id)
                ->get('t_cmp_activation')
                ->row_array();
        }

        // ── Campaign Context ──────────────────────────────────────────────────
        $campaign_context = null;
        if (!empty($campaign_id)) {
            $campaign_context = $this->db
                ->select('campaign_id, campaign_name, campaign_desc, campaign_start_date, campaign_end_date,
                          target_audience, audience_problem, key_message, call_to_action, content_angle,
                          reason_to_believe, production_cost, placement_cost, target_views, target_leads, target_transactions')
                ->where('campaign_id', $campaign_id)
                ->get('t_cmp_campaign')
                ->row_array();
        }

        $master_data = [
            'platforms' => $platforms,
            'placements' => $placements,
            'content_pillars' => $pillars,
            'content_formats' => $formats,
            'talent_types' => $talent_types,
            'employees' => $employees,
            'activation' => $activation_context,
            'campaign' => $campaign_context,
        ];

        $master_data_str = json_encode($master_data, JSON_UNESCAPED_UNICODE);

        $system_prompt = "Anda adalah Konsultan Konten Pemasaran Digital Senior dengan keahlian mendalam di pasar Indonesia.
Tugas Anda adalah menghasilkan rencana konten (content plan) yang komprehensif, kreatif, dan berdampak tinggi dalam format JSON berdasarkan input pengguna dan MASTER DATA yang disediakan.

---

🎯 PERAN & KONTEKS:
Anda berpengalaman lebih dari 10 tahun dalam merancang konten digital, skrip video, dan strategi distribusi konten di berbagai platform (TikTok, Instagram, YouTube, dll.). Anda memahami perilaku audiens Indonesia, tren konten terkini, serta teknik persuasi dan storytelling yang efektif.

---

📋 INSTRUKSI UTAMA:

1. **Analisis Input Pengguna**
   - Pahami tema, tujuan, dan konteks konten dari input yang diberikan.
   - Jika input tidak lengkap, asumsikan konteks yang paling sesuai berdasarkan data campaign dan activation di MASTER DATA.
   - Jika input kosong, buat rencana konten kreatif yang selaras dengan kampanye yang ada.

2. **Kontekstualisasi Campaign & Activation**
   - Gunakan data `campaign` dan `activation` dari MASTER DATA sebagai acuan utama.
   - Pastikan konten mendukung tujuan aktivasi dan kampanye secara keseluruhan.

3. **Pemilihan Platform, Placement, Pillar & Format**
   - Pilih `platform_id` yang relevan dari daftar `platforms`.
   - Pilih `placement_id` dari daftar `placements`.
   - Pilih `pillar_id` dari daftar `content_pillars`.
   - Pilih `format_id` dari daftar `content_formats`.
   - Kembalikan sebagai Array of IDs.

4. **Pemilihan Talent Type**
   - Pilih `talent_type_id` dari daftar `talent_types` yang paling sesuai dengan konten.

5. **Tanggal Publikasi**
   - Tanggal saat ini adalah: " . date('Y-m-d H:i:s') . "
   - Tentukan `publish_date` dan `deadline_publish` yang realistis.
   - `deadline_publish` harus lebih awal dari `publish_date` (minimal 1–3 hari sebelumnya).
   - Format: YYYY-MM-DD HH:MM:00

6. **Strategi Konten**
   - Buat `hook` yang menarik perhatian dalam 1–2 kalimat pertama.
   - Identifikasi `pain_point` audiens yang relevan.
   - Tentukan `trigger_emotion` yang ingin dibangkitkan.
   - Jelaskan `consumption_behavior` audiens target.
   - Buat `script_content` dengan struktur Intro–Isi–CTA (minimal 3 paragraf).
   - Buat `storyboard` berupa deskripsi visual scene per scene.
   - Tentukan `audio_notes` (musik latar, voice-over, efek suara).
   - Sertakan `talent_persona` yang spesifik dan relevan.

7. **Biaya & Target**
   - `talent_cost`: estimasi biaya talent dalam Rupiah (integer).
   - `talent_target`: jumlah talent yang dibutuhkan (integer 1–10).

8. **Standar Kualitas Output**
   - Semua teks WAJIB menggunakan **Bahasa Indonesia** yang natural, profesional, dan persuasif.
   - Semua angka WAJIB realistis untuk skala pasar Indonesia.

---

📊 MASTER DATA:
$master_data_str

---

📤 FORMAT OUTPUT JSON (Wajib diikuti secara ketat):
{
    \"title\": \"String – judul konten yang spesifik dan menarik\",
    \"platform_ids\": [Array of platform_id],
    \"placement_ids\": [Array of placement_id],
    \"content_pillar_ids\": [Array of pillar_id],
    \"format_ids\": [Array of format_id],
    \"talent_type_ids\": [Array of talent_type_id],
    \"publish_date\": \"YYYY-MM-DD HH:MM:00\",
    \"deadline_publish\": \"YYYY-MM-DD HH:MM:00\",
    \"duration_desc\": \"String – durasi konten, misal: 60 detik, 3 menit\",
    \"talent_cost\": Integer,
    \"talent_target\": Integer,
    \"talent_persona\": \"String – deskripsi persona talent yang ideal\",
    \"pain_point\": \"String – masalah yang dirasakan audiens\",
    \"trigger_emotion\": \"String – emosi yang ingin dibangkitkan\",
    \"consumption_behavior\": \"String – cara audiens mengonsumsi konten ini\",
    \"hook\": \"String – kalimat pembuka yang menarik perhatian\",
    \"script_content\": \"String – skrip konten lengkap dengan Intro–Isi–CTA\",
    \"storyboard\": \"String – deskripsi visual scene per scene\",
    \"audio_notes\": \"String – catatan audio, musik, dan voice-over\",
    \"reference_link\": \"String – URL referensi konten serupa (opsional)\"
}

⚠️ CONSTRAINT AKHIR:
- Output HANYA berupa JSON murni — tanpa penjelasan tambahan, tanpa markdown, tanpa komentar.
- Seluruh nilai string menggunakan Bahasa Indonesia.
- Seluruh nilai numerik dalam satuan yang sesuai (Rupiah untuk biaya).
- Pastikan JSON valid dan dapat langsung di-parse.";

        // ── Payload ke n8n ────────────────────────────────────────────────────
        $payload = [
            'system_prompt' => $system_prompt,
            'user_prompt' => $user_prompt ?: 'Buat rencana konten yang kreatif dan engaging untuk kampanye ini',
        ];

        $n8n_url = "https://n8n.trustcore.id/webhook/compas-dynamic-generative-input-c8769381-40ab-46bd-8c9b-7a773f88c162";

        $ch = curl_init($n8n_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code === 200 && $response) {
            $result = json_decode($response, true);
            $data = isset($result['output']) ? $result['output'] : $result;

            if (is_string($data)) {
                $decoded = json_decode($data, true);
                if ($decoded) {
                    $data = $decoded;
                }
            }

            echo json_encode(['status' => true, 'data' => $data]);
            return;
        }

        // ── Fallback / Dummy Data ─────────────────────────────────────────────
        $dummy_data = [
            'title' => 'AI Content: ' . ($user_prompt ? substr($user_prompt, 0, 30) . '...' : 'Konten Kreatif Berdampak Tinggi'),
            'platform_ids' => !empty($platforms) ? [($platforms[0]['platform_id'] ?? 1)] : [1],
            'placement_ids' => !empty($placements) ? [($placements[0]['placement_id'] ?? 1)] : [1],
            'content_pillar_ids' => !empty($pillars) ? [($pillars[0]['pillar_id'] ?? 1)] : [1],
            'format_ids' => !empty($formats) ? [($formats[0]['format_id'] ?? 1)] : [1],
            'talent_type_ids' => !empty($talent_types) ? [($talent_types[0]['talent_type_id'] ?? 1)] : [1],
            'publish_date' => date('Y-m-d', strtotime('+10 days')) . ' 10:00:00',
            'deadline_publish' => date('Y-m-d', strtotime('+7 days')) . ' 17:00:00',
            'duration_desc' => '60 detik',
            'talent_cost' => 3500000,
            'talent_target' => 2,
            'talent_persona' => 'Kreator konten muda (22–30 tahun) yang energetik, autentik, dan memiliki audiens yang engaged di niche relevan.',
            'pain_point' => 'Audiens kesulitan menemukan solusi yang terpercaya dan mudah dipahami untuk kebutuhan mereka.',
            'trigger_emotion' => 'Rasa penasaran, antusias, dan kepercayaan terhadap produk/brand.',
            'consumption_behavior' => 'Menonton hingga selesai karena konten informatif, mengalami scroll-stop di detik pertama.',
            'hook' => 'Kamu pasti pernah merasakan ini... tapi sekarang ada solusinya!',
            'script_content' => "Intro: Hook audiens dengan masalah yang relatable.\nIsi: Perkenalkan produk/layanan sebagai solusi dengan demonstrasi nyata.\nCTA: Ajak audiens untuk segera mencoba dan bagikan pengalaman mereka.",
            'storyboard' => "Scene 1: Close-up ekspresi frustrasi talent.\nScene 2: Transisi ke penggunaan produk.\nScene 3: Ekspresi puas dan testimonial singkat.\nScene 4: Logo brand + CTA overlay.",
            'audio_notes' => 'Musik latar upbeat dan modern. Voice-over talent natural tanpa efek. Tambahkan sound effect transisi yang trendy.',
            'reference_link' => 'https://www.tiktok.com/trending',
        ];

        echo json_encode(['status' => true, 'data' => $dummy_data]);
    }

}