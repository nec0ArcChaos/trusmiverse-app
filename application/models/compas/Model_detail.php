<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_detail extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function update_campaign($campaign_id, $data)
    {
        $this->db->where('campaign_id', $campaign_id);
        return $this->db->update('t_cmp_campaign', $data);
    }

    public function log_activity($data)
    {
        return $this->db->insert('t_cmp_activity_logs', $data);
    }

    public function get_activity_log($phase_id, $phase)
    {
        $this->db->select('l.*, CONCAT(e.first_name, " ", e.last_name) as user_name, e.profile_picture');
        $this->db->from('t_cmp_activity_logs l');
        $this->db->join('xin_employees e', 'l.user_id = e.user_id', 'left');
        $this->db->where('l.phase_id', $phase_id);
        $this->db->where('l.phase', $phase);
        $this->db->order_by('l.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_all_activity_logs($limit = 10, $phase = null)
    {
        $this->db->select('l.*, CONCAT(e.first_name, " ", e.last_name) as user_name, e.profile_picture');
        // We might want title from respective tables, but standardizing join for all phases is complex in one query.
        // For now, let's fetch basic log info. If we need title, we might need separate queries or a UNION.
        // Or we join conditionally.
        // For simplicity and to match previous `activation` logic, let's try to join activation if phase is activation.

        $this->db->from('t_cmp_activity_logs l');
        $this->db->join('xin_employees e', 'l.user_id = e.user_id', 'left');

        // Simple optimization: Just select log and user info. Task title might need dynamic fetching or stored in log (which is not redundant but useful).
        // Previous implementation joined t_cmp_activation.
        // Let's keep it simple: just return log data. The frontend can handle "a task" if title is missing, or we can improve schema later to store title snapshot.
        // To strictly match previous behavior for activations:
        $this->db->select('l.*, CONCAT(e.first_name, " ", e.last_name) as user_name, e.profile_picture, a.title as activation_title');
        $this->db->join('t_cmp_activation a', 'l.phase_id = a.activation_id AND l.phase = "activation"', 'left');

        if ($phase) {
            $this->db->where('l.phase', $phase);
        }

        $this->db->order_by('l.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    // Generic Get Method
    public function get_task_detail($id, $phase)
    {
        $table = $this->get_table_by_phase($phase);
        $key = $this->get_key_by_phase($phase);

        if (!$table || !$key)
            return null;

        $this->db->where($key, $id);
        return $this->db->get($table)->row_array();
    }

    // Generic Update Method
    public function update_task($id, $data, $phase)
    {
        $table = $this->get_table_by_phase($phase);
        $key = $this->get_key_by_phase($phase);

        if (!$table || !$key)
            return false;

        $this->db->where($key, $id);
        return $this->db->update($table, $data);
    }

    // Helper to Get Table Name
    private function get_table_by_phase($phase)
    {
        switch ($phase) {
            case 'activation':
                return 't_cmp_activation';
            case 'content':
                return 't_cmp_content';
            case 'distribution':
                return 't_cmp_distribution';
            case 'optimization':
                return 't_cmp_optimization';
            // case 'talent': return 't_cmp_talent'; // If exists
            default:
                return null;
        }
    }

    // Helper to Get Primary Key Column
    private function get_key_by_phase($phase)
    {
        switch ($phase) {
            case 'activation':
                return 'activation_id';
            case 'content':
                return 'content_id';
            case 'distribution':
                return 'id';
            case 'optimization':
                return 'id';
            // case 'talent': return 'id';
            default:
                return null;
        }
    }

    public function get_tasks_by_status($campaign_id, $status, $phase)
    {
        $table = $this->get_table_by_phase($phase);
        // Assuming all have campaign_id and status columns
        if (!$table)
            return [];

        $this->db->where('campaign_id', $campaign_id);
        $this->db->where('status', $status);
        return $this->db->get($table)->result_array();
    }

    public function get_task_detail_with_pics($id, $phase)
    {
        $table = $this->get_table_by_phase($phase);
        $key = $this->get_key_by_phase($phase);

        if (!$table || !$key)
            return null;

        $this->db->select("t.*, 
            GROUP_CONCAT(DISTINCT e.user_id ORDER BY e.user_id ASC) AS pic_ids, 
            GROUP_CONCAT(DISTINCT CONCAT(e.first_name, ' ', e.last_name) ORDER BY e.user_id ASC) AS pic_names, 
            GROUP_CONCAT(DISTINCT e.profile_picture ORDER BY e.user_id ASC) AS pic_pictures");
        $this->db->from("$table t");
        $this->db->join('xin_employees e', "FIND_IN_SET(e.user_id, t.pic)", 'left');
        $this->db->where("t.$key", $id);
        $this->db->group_by("t.$key");

        return $this->db->get()->row_array();
    }
}
