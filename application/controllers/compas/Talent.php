<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Talent extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('compas/model_talent', 'model_talent');
        $this->load->model('compas/model_campaign', 'model_campaign');
        $this->load->model('compas/model_content', 'model_content');
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
            'phase' => 'talent',
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
        $campaigns = $this->model_talent->get_campaigns_by_date($start, $end);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'data' => $campaigns,
            ]));
    }

    public function detail()
    {
        $campaign_id = $this->input->post('campaign_id');
        $talents = $this->model_talent->getTalents($campaign_id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'campaign_id' => $campaign_id,
                'talents' => $talents,
            ]));
    }

    public function get_pics()
    {
        $campaign_id = $this->input->post('id');
        $pics = $this->model_talent->getPics($campaign_id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'data' => $pics,
            ]));
    }

    public function get_approved_contents()
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

        $contents = $this->model_talent->get_approved_contents($campaign_id, $limit, $start);
        $total_records = $this->model_talent->count_approved_contents($campaign_id);
        $total_pages = ceil($total_records['total'] / $limit);

        echo json_encode([
            'status' => true,
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
        // if (!$this->input->is_ajax_request()) {
        //     show_404();
        // }

        $id = $this->input->get('id');
        if (empty($id)) {
            return $this->_json_response(false, 'ID required');
        }

        $content_data = $this->model_talent->get_content_by_id($id);
        if (!$content_data) {
            return $this->_json_response(false, 'Data not found');
        }

        $campaign_data = $this->model_campaign->get_campaign_by_id($content_data['campaign_id']);

        return $this->_json_response(true, 'Data fetched', [
            'data' => [
                'campaign' => $campaign_data,
                'content' => $content_data,
            ]
        ]);
    }

    function get_talent_team()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $campaign_id = $this->input->get('campaign_id');

        if (empty($campaign_id)) {
            echo json_encode(['status' => false, 'message' => 'Campaign ID required']);
            return;
        }

        $talent_team = $this->model_talent->get_talent_team($campaign_id);
        foreach ($talent_team as $key => $value) {
            $avatars = $value->profile_picture_team ? explode(',', $value->profile_picture_team) : [];
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
            $talent_team[$key]->profile_picture_team = $avatars;
            $talent_team[$key]->more_users = $more_users;
        }
        if ($talent_team) {
            echo json_encode([
                'status' => true,
                'data' => $talent_team[0],
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
        $employees = $this->model_talent->get_all_employees();
        echo json_encode(['status' => true, 'data' => $employees]);
    }

    public function save_talent_team()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $campaign_id = $this->input->post('campaign_id');
        $team = $this->input->post('team');

        if (empty($campaign_id)) {
            echo json_encode(['status' => false, 'message' => 'Campaign ID required']);
            return;
        }

        if (is_array($team)) {
            $team_str = implode(',', $team);
        } else {
            $team_str = $team;
        }

        if ($this->model_talent->update_talent_team($campaign_id, $team_str)) {
            echo json_encode(['status' => true, 'message' => 'Team updated successfully']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to update team']);
        }
    }

    public function delete_talent()
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
        $detail = $this->model_talent->get_talent_detail($id);

        if ($this->model_talent->delete_talent($id)) {
            if ($detail) {
                $log_data = [
                    'campaign_id' => $detail['campaign_id'],
                    'phase_id' => $id, // ID is deleted but we keep track
                    'phase' => 'talent',
                    'user_id' => $this->session->userdata('user_id'),
                    'action_type' => 'DELETED', // Make sure enum supports DELETED or just use UPDATED with desc
                    'description' => 'Talent has been deleted',
                    'details' => json_encode(['id' => $id, 'title' => $detail['talent_name']]),
                ];
                // Check if action_type allows DELETED, schema comment said: STATUS_CHANGE, PROGRESS_UPDATE, NOTE_ADDED, FILE_UPLOADED, CREATED, UPDATED
                // Let's use UPDATED for now or check schema. Schema comment is just comment.
                $log_data['action_type'] = 'UPDATED';
                $this->db->insert('t_cmp_activity_logs', $log_data);
            }

            echo json_encode(['status' => true, 'message' => 'Plan deleted successfully']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to delete talent']);
        }
    }

    public function get_talent_list()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $campaign_id = empty($this->input->post('campaign_id')) ? $this->input->get('campaign_id') : $this->input->post('campaign_id');
        if (empty($campaign_id)) {
            echo json_encode(['data' => []]); // Empty data for DataTables
            return;
        }

        $talents = $this->model_talent->getTalents($campaign_id);
        foreach ($talents as $key => $value) {
            $pics = $value['pic_pictures'] ? explode(',', $value['pic_pictures']) : [''];
            $names = $value['pic_names'] ? explode(',', $value['pic_names']) : [];

            // Ensure JS compatibility
            $talents[$key]['pic_name'] = $value['pic_names'];

            $jml_team = count($pics);

            $avatars = [];
            if ($jml_team > 3) {
                $more_users = $jml_team - 3;
                $pics = array_slice($pics, 0, 3);
            } else {
                $more_users = 0;
            }

            foreach ($pics as $p) {
                if ($p != '') {
                    $avatars[] = 'https://trusmiverse.com/hr/uploads/profile/' . $p;
                } else {
                    $avatars[] = 'https://trusmiverse.com/hr/uploads/profile/anonim.jpg';
                }
            }

            $talents[$key]['profile_picture_team'] = $avatars;
            $talents[$key]['more_users'] = $more_users;
        }

        echo json_encode(['data' => $talents]);
    }

    public function get_talent_detail()
    {
        $talent_id = empty($this->input->post('talent_id')) ? $this->input->get('talent_id') : $this->input->post('talent_id');
        if (!$talent_id) {
            echo json_encode(['status' => false, 'message' => 'Data not found']);
            return;
        }

        $talent_detail = $this->model_talent->getTalent($talent_id);

        if (!$talent_detail) {
            echo json_encode(['status' => false, 'message' => 'Data not found']);
            return;
        }

        // string by , to array
        $avatars = $talent_detail['pic_pictures'] ? explode(',', $talent_detail['pic_pictures']) : [''];
        $avatars = array_map(function ($avatar) {
            if ($avatar != '') {
                return 'https://trusmiverse.com/hr/uploads/profile/' . $avatar;
            } else {
                return 'https://trusmiverse.com/hr/uploads/profile/anonim.jpg';
            }
        }, $avatars);
        $talent_detail['profile_picture_team'] = $avatars;

        // Ensure pic_name is available for JS
        if (isset($talent_detail['pic_names'])) {
            $talent_detail['pic_name'] = $talent_detail['pic_names'];
        }
        // Get AI Analysis if exists
        $analysis = $this->model_talent->getAnalysis($talent_id);
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
        $logs = $this->model_talent->get_activity_log($talent_id);
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
            'data' => $talent_detail,
            'analysis' => $analysis,
            'logs' => $logs
        ]);
    }

    private function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $weeks = floor($diff->days / 7);
        $days = $diff->days - ($weeks * 7);

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
    public function approve_talent()
    {
        // if (!$this->input->is_ajax_request())
        //     show_404();
        $id = $this->input->post('id');
        $target = $this->input->post('target');
        if (!$id)
            $id = $this->input->post('talent_id');

        if (empty($id)) {
            echo json_encode(['status' => false, 'message' => 'Talent ID required']);
            return;
        }

        if ($this->model_talent->update_talent($id, ['status' => 3, 'approved_at' => date('Y-m-d H:i:s')])) {
            $detail = $this->model_talent->getTalent($id);

            $log_data = [
                'campaign_id' => $detail['campaign_id'],
                'phase_id' => $id,
                'phase' => 'talent',
                'user_id' => $this->session->userdata('user_id'),
                'action_type' => 'STATUS_CHANGE',
                'description' => 'Talent plan status changed to Approved',
                'details' => json_encode(['status_from' => $detail['status'], 'status_to' => 3]),
            ];
            $this->model_talent->log_activity($log_data);

            $talents = $this->model_talent->getTalentsBySubStatus($detail['campaign_id'], '3');
            $update_campaign = [];
            if (count($talents) >= $target) {
                $update_campaign = [
                    'talent_status' => '3',
                    'talent_approved_at' => date('Y-m-d H:i:s'),
                ];
            } elseif (count($talents) < $target) {
                $update_campaign = [
                    'talent_status' => '2',
                ];
            }
            $update_campaign['talent_actual'] = count($talents);

            $this->db->where('campaign_id', $detail['campaign_id']);
            $this->db->update('t_cmp_campaign', $update_campaign);
            $this->db->where('content_id', $detail['content_id']);
            $this->db->update('t_cmp_content', ['talent_actual' => count($talents)]);
            echo json_encode(['status' => true, 'message' => 'Talent approved successfully']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to approve talent']);
        }
    }

    public function cancel_approve_talent()
    {
        // if (!$this->input->is_ajax_request())
        //     show_404();
        $id = $this->input->post('id');
        $target = $this->input->post('target');
        if (!$id)
            $id = $this->input->post('talent_id');

        if (empty($id)) {
            echo json_encode(['status' => false, 'message' => 'ID required']);
            return;
        }

        if ($this->model_talent->update_talent($id, ['status' => 1, 'approved_at' => null])) {
            $detail = $this->model_talent->getTalent($id);
            $log_data = [
                'campaign_id' => $detail['campaign_id'],
                'phase_id' => $id,
                'phase' => 'talent',
                'user_id' => $this->session->userdata('user_id'),
                'action_type' => 'STATUS_CHANGE',
                'description' => 'Talent approval cancelled (Reverted to Draft)',
                'details' => json_encode(['status_from' => 3, 'status_to' => 1]),
            ];
            $this->model_talent->log_activity($log_data);
            $talents = $this->model_talent->getTalentsBySubStatus($detail['campaign_id'], '3');
            $update_campaign = [];
            if (count($talents) >= $target) {
                $update_campaign = [
                    'talent_status' => '3',
                    'talent_approved_at' => date('Y-m-d H:i:s'),
                ];
            } elseif (count($talents) < $target) {
                $update_campaign = [
                    'talent_status' => '2',
                ];
            }
            $update_campaign['talent_actual'] = count($talents);

            $this->db->where('campaign_id', $detail['campaign_id']);
            $this->db->update('t_cmp_campaign', $update_campaign);
            $this->db->where('content_id', $detail['content_id']);
            $this->db->update('t_cmp_content', ['talent_actual' => count($talents)]);
            echo json_encode(['status' => true, 'message' => 'Approval cancelled']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to cancel approval']);
        }
    }

    public function reject_talent_plan()
    {
        // if (!$this->input->is_ajax_request())
        //     show_404();
        $id = $this->input->post('id');
        if (!$id)
            $id = $this->input->post('talent_id');

        $note = $this->input->post('note');
        $status = $this->input->post('status') ?: 4;

        if (empty($id)) {
            echo json_encode(['status' => false, 'message' => 'ID required']);
            return;
        }

        if ($this->model_talent->update_talent($id, ['status' => $status])) {
            $detail = $this->model_talent->getTalent($id);
            $action_desc = ($status == 4) ? 'Rejected' : 'Revision';
            $this->_log_activity($detail['campaign_id'], $id, 'STATUS_CHANGE', "Updated talent plan $id status to $action_desc. Note: " . ($note ?: 'No note'), ['status_from' => $detail['status'], 'status_to' => $status, 'note' => $note]);
            return $this->_json_response(true, "Plan $action_desc successfully");
        }
        return $this->_json_response(false, 'Failed to reject plan status');
    }
    public function get_talent_logs()
    {
        // if (!$this->input->is_ajax_request()) {
        //     show_404();
        // }

        $campaign_id = $this->input->get('campaign_id');
        if (empty($campaign_id)) {
            echo json_encode(['status' => false, 'message' => 'Campaign ID required']);
            return;
        }

        $logs = $this->model_talent->get_talent_logs($campaign_id);

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
            ->where('c.phase', 'talent')
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
            'phase' => 'talent',
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
        header('Content-Type: application/json');
        $talent_id = $this->input->post('talent_id');
        $re_analyze = $this->input->post('re_analyze');

        if (!$talent_id) {
            echo json_encode(['status' => 'error', 'message' => 'Talent ID is required']);
            return;
        }

        if ($re_analyze !== 'true') {
            $existing = $this->model_talent->getAnalysis($talent_id);
            if ($existing) {
                $data = json_decode($existing['analysis_json'], true);
                if (isset($data[0]))
                    $data = $data[0];
                echo json_encode(['status' => 'success', 'data' => $data]);
                return;
            }
        }

        $result = $this->analysis_talent($talent_id);
        echo json_encode(['status' => 'success', 'data' => $result]);
    }


    private function analysis_talent($talent_id)
    {
        $talent_data = $this->model_talent->getTalentForAnalysis($talent_id);
        $content_data = $this->model_content->get_content_analysis_data($talent_data['content_id']);
        $activation_data = $this->model_activation->getActivationForAnalysis($content_data['activation_id']);

        $talent_payload = [
            'talent_id' => $talent_data['talent_id'],
            'talent_name' => $talent_data['talent_name'],
            'rate' => $talent_data['rate'],
            'persona' => $talent_data['persona'],
            'communication_style' => $talent_data['communication_style'],
            'username_tiktok' => $talent_data['username_tiktok'],
            'username_ig' => $talent_data['username_ig'],
            'content_niche' => $talent_data['content_niche'],
            'status' => $talent_data['status'],
        ];

        $data = [
            "talent_data" => $talent_payload,
            "content_data" => $content_data,
            "activation_data" => $activation_data,
            "phase" => "talent",
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
            if (isset($n8n_result['skor_kecocokan_keseluruhan'])) {
                $score = (int) $n8n_result['skor_kecocokan_keseluruhan']['nilai'];
            }

            // Prepare DB Data
            $db_data = [
                'talent_id' => $talent_id,
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
            $this->model_talent->save_talent_analysis($db_data);

            return [
                'output' => $n8n_result
            ];

        } else {
            return ['status' => 'error', 'message' => 'Failed to retrieve analysis from AI service.'];
        }
    }
    public function get_team_performance_stats()
    {
        $campaign_id = $this->input->get('campaign_id');
        $content_id = $this->input->get('content_id');

        if ($content_id) {
            // Per-content: target comes from t_cmp_content.talent_target
            $content = $this->db
                ->select('SUM(talent_target) as talent_target')
                ->where('content_id', $content_id)
                ->get('t_cmp_content')
                ->row_array();

            $target = (int) ($content['talent_target'] ?? 0);

            $this->db->where('content_id', $content_id)->where('status', '3');
            $done = $this->db->count_all_results('t_cmp_talent');

            $this->db->where('content_id', $content_id);
            $total = $this->db->count_all_results('t_cmp_talent');

            $efficiency = $target > 0 ? round(($done / $target) * 100) : 0;

            echo json_encode([
                'status' => true,
                'data' => [
                    'efficiency' => $efficiency,
                    'total_approved' => $done,
                    'total' => $total,
                    'target' => $target,
                    'content_id' => $content_id,
                ]
            ]);
        } else {
            // Per-campaign fallback
            if (empty($campaign_id)) {
                echo json_encode(['status' => false, 'message' => 'campaign_id or content_id required']);
                return;
            }
            $stats = $this->model_talent->get_talent_performance_stats_full($campaign_id);
            echo json_encode(['status' => true, 'data' => $stats]);
        }
    }






    public function save_talent()
    {
        $id = $this->input->post('talent_id');
        if ($id) {
            $this->update();
        } else {
            $this->add();
        }
    }

    public function add()
    {
        // Get POST data
        $postData = $this->input->post();
        $user_id = $this->session->userdata('user_id') ?: 1;

        // Prepare data for insertion
        $data = [
            'content_id' => $postData['content_id'] ?? null,
            'campaign_id' => $postData['campaign_id'],
            'talent_name' => $postData['talent_name'],
            'rate' => str_replace('.', '', $postData['rate']),
            'persona' => $postData['persona'],
            'communication_style' => $postData['communication_style'],
            'username_tiktok' => $postData['username_tiktok'],
            'username_ig' => $postData['username_ig'],
            'content_niche' => $postData['content_niche'],
            'pic' => isset($postData['pic']) ? implode(',', $postData['pic']) : '',
            'status' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'created_by' => $user_id,
        ];

        $insert_id = $this->model_talent->insert_talent($data);

        if ($insert_id) {
            // Sync to master talent table (upsert)
            $master_talent_id = $postData['master_talent_id'] ?? null;
            if (!$master_talent_id) {
                // New talent – insert/update in master list
                $master_data = array_merge($data, ['user_id' => $user_id]);
                $master_talent_id = $this->model_talent->upsert_master_talent($master_data);
            }

            // Log activity
            $this->model_talent->log_activity([
                'campaign_id' => $data['campaign_id'],
                'phase_id' => $insert_id,
                'phase' => 'talent',
                'user_id' => $user_id,
                'action_type' => 'CREATED',
                'description' => 'Added talent: ' . $data['talent_name'],
            ]);

            // Update Campaign Status if target reached
            $campaign = $this->model_campaign->get_campaign_statuses($data['campaign_id']);
            if ($campaign['talent_status'] <= 1) {
                $this->db->where('campaign_id', $data['campaign_id']);
                $this->db->update('t_cmp_campaign', ['talent_status' => 2]);
            }

            // $analysis = $this->analysis_talent($insert_id);
            $data['talent_id'] = $insert_id;

            echo json_encode([
                'status' => true,
                'message' => 'Talent added successfully',
                'data' => $data,
                // 'analysis' => $analysis
            ]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to add talent']);
        }
    }

    public function update()
    {
        // Get POST data
        $postData = $this->input->post();
        $talent_id = $postData['talent_id'];
        $user_id = $this->session->userdata('user_id') ?: 1;

        if (!$talent_id) {
            echo json_encode(['status' => false, 'message' => 'Talent ID is required']);
            return;
        }

        // Prepare data for update
        $data = [
            'campaign_id' => $postData['campaign_id'],
            'content_id' => $postData['content_id'] ?? null,
            'talent_name' => $postData['talent_name'],
            'rate' => str_replace('.', '', $postData['rate']),
            'persona' => $postData['persona'],
            'communication_style' => $postData['communication_style'],
            'username_tiktok' => $postData['username_tiktok'],
            'username_ig' => $postData['username_ig'],
            'content_niche' => $postData['content_niche'],
            'pic' => isset($postData['pic']) ? implode(',', $postData['pic']) : '',
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $user_id,
        ];

        $update = $this->model_talent->update_talent($talent_id, $data);

        if ($update) {
            // Sync to master talent table (upsert)
            $master_talent_id = $postData['master_talent_id'] ?? null;
            if (!$master_talent_id) {
                $master_data = array_merge($data, ['user_id' => $user_id]);
                $this->model_talent->upsert_master_talent($master_data);
            }

            // Log activity
            $this->model_talent->log_activity([
                'campaign_id' => $data['campaign_id'],
                'phase_id' => $talent_id,
                'phase' => 'talent',
                'user_id' => $user_id,
                'action_type' => 'UPDATED',
                'description' => 'Updated talent: ' . $data['talent_name'],
            ]);

            // $analysis = $this->analysis_talent($talent_id);
            echo json_encode([
                'status' => true,
                'message' => 'Talent updated successfully',
                // 'analysis' => $analysis
            ]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to update talent']);
        }
    }


    public function update_task_sub_detail()
    {
        $talent_id = $this->input->post('talent_id');
        $status = $this->input->post('status');
        $progress = $this->input->post('progress');
        $note = $this->input->post('note');
        $target = $this->input->post('target');
        $user_id = $this->session->userdata('user_id') ? $this->session->userdata('user_id') : 1;

        if (!$talent_id) {
            echo json_encode(['status' => 'error', 'message' => 'Talent ID is required']);
            return;
        }

        // 1. Get Current Data
        $current_talent = $this->model_talent->getTalent($talent_id);
        if (!$current_talent) {
            echo json_encode(['status' => 'error', 'message' => 'Talent not found']);
            return;
        }

        // Determine if status actually changed
        $status_changed = ($current_talent['status'] != $status);
        $pic = in_array($user_id, explode(',', $current_talent['pic_ids'])) ? $current_talent['pic_ids'] : $current_talent['pic_ids'] . ',' . $user_id;

        // 2. Update Talent Record
        $update_data = [
            'status' => $status,
            // 'progress' => $progress, // Talent table has no progress column in schema provided? 
            // Wait, t_cmp_activation had progress. t_cmp_talent schema provided doesn't explicitly show 'progress'. 
            // I'll check schema again. Schema line 523: NO progress column.
            // I will skip progress update for now or add it to schema if I could.
            // But strict adherence to schema means no progress column.
            'pic' => $pic,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $user_id
        ];
        $this->model_talent->update_talent($talent_id, $update_data);

        // 3. Log Status Change
        if ($status_changed) {
            $this->model_talent->log_activity([
                'phase_id' => $talent_id,
                'phase' => 'talent', // explicitly set phase
                'user_id' => $user_id,
                'action_type' => 'STATUS_CHANGE',
                'description' => 'Changed status',
                'details' => json_encode([
                    'status_from' => $current_talent['status'],
                    'status_to' => $status
                ])
            ]);

            // Logic for completing the phase
            if ($status == '3') { // Assuming '3' is Completed/Approved
                $talents = $this->model_talent->getTalentsBySubStatus($current_talent['campaign_id'], '3');
                if (count($talents) >= $target) {
                    $this->model_talent->update_campaign(
                        $current_talent['campaign_id'],
                        [
                            'talent_status' => '3', // Completed
                            // 'talent_approved_at' => date('Y-m-d H:i:s'), // not in schema for talent but good to have if consistency needed
                            // 'talent_status' => '1',
                        ]
                    );
                }
            }
        }

        // 4. Log Note
        if (!empty($note)) {
            $this->model_talent->log_activity([
                'phase_id' => $talent_id,
                'phase' => 'talent',
                'user_id' => $user_id,
                'action_type' => 'NOTE_ADDED',
                'description' => $note
            ]);
        }

        // 5. Handle File Uploads (Generic)
        if (!empty($_FILES['file']['name'][0])) {
            $this->load->library('upload');

            $uploaded_files = [];
            $files = $_FILES['file'];
            $count = count($files['name']);

            for ($i = 0; $i < $count; $i++) {
                if (empty($files['name'][$i]))
                    continue;

                $_FILES['userfile']['name'] = $files['name'][$i];
                $_FILES['userfile']['type'] = $files['type'][$i];
                $_FILES['userfile']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['userfile']['error'] = $files['error'][$i];
                $_FILES['userfile']['size'] = $files['size'][$i];

                $config = [
                    'upload_path' => './uploads/talent_files/', // Separate folder
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

                $this->model_talent->log_activity([
                    'phase_id' => $talent_id,
                    'phase' => 'talent',
                    'user_id' => $user_id,
                    'action_type' => 'FILE_UPLOADED',
                    'description' => 'Uploaded ' . count($uploaded_files) . ' files',
                    'details' => json_encode($details)
                ]);
            }
        }

        echo json_encode(['status' => 'success', 'message' => 'Task updated']);
    }


    /**
     * Get all master talents from m_cmp_talent
     * Used to populate the existing talent picker in the form
     */
    public function get_master_talents()
    {
        $talents = $this->model_talent->get_master_talents();
        echo json_encode(['status' => true, 'data' => $talents]);
    }

    /**
     * Get list of contents for a campaign
     * Used to populate the content_id picker in talent form
     */
    public function get_contents_for_talent()
    {
        $campaign_id = $this->input->get('campaign_id');
        if (!$campaign_id)
            $campaign_id = $this->input->post('campaign_id');

        if (empty($campaign_id)) {
            echo json_encode(['status' => false, 'data' => [], 'message' => 'Campaign ID required']);
            return;
        }

        $contents = $this->model_talent->get_contents_by_campaign($campaign_id);
        echo json_encode(['status' => true, 'data' => $contents]);
    }

    // ─── AI Talent Generation ──────────────────────────────────────────────────

    public function generate_ai_talent()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => false, 'message' => 'Invalid request']);
            return;
        }

        $campaign_id = $this->input->post('campaign_id');
        $content_id = $this->input->post('content_id');
        $user_prompt = $this->input->post('user_prompt') ?? '';

        // ── Master Data ──────────────────────────────────────────────────────
        $employees = $this->db
            ->select('user_id, CONCAT(first_name, " ", last_name) as full_name, email')
            ->from('xin_employees')
            ->where('is_active', 1)
            ->get()
            ->result_array();

        // ── Content Context ───────────────────────────────────────────────────
        $content_context = null;
        if (!empty($content_id)) {
            $content_context = $this->db
                ->select('content_id, title, platform, placement_type, format, content_pillar,
                          talent_type, talent_persona, pain_point, trigger_emotion, consumption_behavior,
                          hook, script_content, publish_date, deadline_publish')
                ->where('content_id', $content_id)
                ->get('t_cmp_content')
                ->row_array();
        }

        // ── Campaign Context ──────────────────────────────────────────────────
        $campaign_context = null;
        if (!empty($campaign_id)) {
            $campaign_context = $this->db
                ->select('campaign_id, campaign_name, campaign_desc, campaign_start_date, campaign_end_date,
                          target_audience, audience_problem, key_message, call_to_action, content_angle,
                          reason_to_believe, target_views, target_leads, target_transactions')
                ->where('campaign_id', $campaign_id)
                ->get('t_cmp_campaign')
                ->row_array();
        }

        // ── Existing Talents for context ──────────────────────────────────────
        $existing_talents = [];
        if (!empty($campaign_id)) {
            $existing_talents = $this->db
                ->select('talent_name, content_niche, communication_style, username_tiktok, username_ig, rate')
                ->where('campaign_id', $campaign_id)
                ->limit(10)
                ->get('t_cmp_talent')
                ->result_array();
        }

        $master_data = [
            'employees' => $employees,
            'content_context' => $content_context,
            // 'campaign' => $campaign_context,
            'existing_talents' => $existing_talents,
        ];

        $master_data_str = json_encode($master_data, JSON_UNESCAPED_UNICODE);

        $system_prompt = "Anda adalah Konsultan Talent Marketing Senior dengan pengalaman mendalam dalam menyeleksi dan mengelola kreator konten (influencer/talent) di Indonesia.
Tugas Anda adalah menghasilkan profil talent ideal yang komprehensif dalam format JSON berdasarkan input pengguna dan MASTER DATA yang disediakan.

---

🎯 PERAN & KONTEKS:
Anda berpengalaman lebih dari 10 tahun dalam Influencer Marketing, Talent Management, dan Content Creator Ecosystem di Indonesia. Anda memahami lanskap kreator konten Indonesia di TikTok, Instagram, YouTube, dan platform lainnya, termasuk niche, persona, dan rate yang realistis.

---

📋 INSTRUKSI UTAMA:

1. **Analisis Kebutuhan Konten**
   - Gunakan `content_context` dari MASTER DATA sebagai acuan utama kebutuhan talent.
   - Sesuaikan persona, niche, dan style komunikasi talent dengan jenis konten yang akan dibuat.
   - Jika tidak ada content context, gunakan campaign context sebagai acuan.

2. **Profil Talent yang Ideal**
   - `talent_name`: Nama talent yang realistis (bisa nama asli atau username).
   - `content_niche`: Niche konten yang relevan (misal: Beauty, Tech Review, Food, Lifestyle, Finance, Gaming, dll).
   - `communication_style`: Gaya komunikasi (misal: Casual & Relatable, Professional & Edukatif, Humor & Witty, dll).
   - `persona`: Deskripsi karakter dan kepribadian talent (2–4 kalimat).
   - `username_tiktok`: Username TikTok yang realistis.
   - `username_ig`: Username Instagram yang realistis.
   - `rate`: Estimasi rate talent dalam Rupiah per konten (integer).

3. **Pemilihan PIC**
   - Pilih 1–3 `user_id` dari daftar `employees` sebagai PIC untuk talent ini.
   - Kembalikan sebagai Array of user_ids.

4. **Menghindari Duplikasi**
   - Periksa `existing_talents` agar talent baru tidak duplikasi dan memiliki value berbeda.

5. **Rate Realistis**
   - Nano influencer (1K–10K followers): Rp 500.000 – Rp 2.000.000
   - Micro influencer (10K–100K followers): Rp 2.000.000 – Rp 10.000.000
   - Mid-tier (100K–500K followers): Rp 10.000.000 – Rp 50.000.000
   - Sesuaikan dengan skala kampanye di MASTER DATA.

6. **Standar Kualitas Output**
   - Semua teks WAJIB menggunakan **Bahasa Indonesia** yang natural dan profesional.
   - Semua angka WAJIB realistis untuk pasar Indonesia.

---

📊 MASTER DATA:
$master_data_str

---

📤 FORMAT OUTPUT JSON (Wajib diikuti secara ketat):
{
    \"talent_name\": \"String – nama talent yang realistis\",
    \"content_niche\": \"String – niche konten utama\",
    \"communication_style\": \"String – gaya komunikasi\",
    \"persona\": \"String – deskripsi karakter dan kepribadian talent\",
    \"username_tiktok\": \"String – username TikTok (@username)\",
    \"username_ig\": \"String – username Instagram (@username)\",
    \"rate\": Integer,
    \"pic_ids\": [Array of user_id]
}

⚠️ CONSTRAINT AKHIR:
- Output HANYA berupa JSON murni — tanpa penjelasan tambahan, tanpa markdown, tanpa komentar.
- Seluruh nilai string menggunakan Bahasa Indonesia (kecuali username dan nama talent).
- Rate dalam satuan Rupiah (integer).
- Pastikan JSON valid dan dapat langsung di-parse.";

        // ── Payload ke n8n ────────────────────────────────────────────────────
        $payload = [
            'system_prompt' => $system_prompt,
            'user_prompt' => $user_prompt ?: 'Rekomendasikan profil talent yang ideal untuk konten ini',
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
        $first_names = ['Andi', 'Rizky', 'Siti', 'Dewi', 'Budi', 'Arif', 'Maya', 'Fajar'];
        $last_names = ['Pratama', 'Rahayu', 'Santoso', 'Wijaya', 'Kusuma', 'Nuraini', 'Hidayat'];
        $name = $first_names[array_rand($first_names)] . ' ' . $last_names[array_rand($last_names)];
        $username = strtolower(str_replace(' ', '', $name));

        $dummy_data = [
            'talent_name' => $name,
            'content_niche' => 'Lifestyle & Daily Vlog',
            'communication_style' => 'Casual & Relatable',
            'persona' => 'Kreator konten muda yang energetik dan autentik, dikenal karena kontennya yang relatable dan jujur. Memiliki komunitas yang loyal dan engaged di platform digital.',
            'username_tiktok' => '@' . $username . '_official',
            'username_ig' => '@' . $username,
            'rate' => 3500000,
            'pic_ids' => !empty($employees) ? [($employees[0]['user_id'] ?? 1)] : [1],
        ];

        echo json_encode(['status' => true, 'data' => $dummy_data]);
    }

    public function get_talent_stats()
    {
        $stats = $this->model_talent->getTalentStats();
        echo json_encode([
            'status' => true,
            'data' => [
                'unique_talents' => $stats['unique_talents'] ?? 0,
                'avg_ai_score' => $stats['avg_ai_score'] ?? 0,
                'total_submissions' => $stats['total_submissions'] ?? 0,
                'approved_plans' => $stats['approved_plans'] ?? 0,
            ]
        ]);
    }

}