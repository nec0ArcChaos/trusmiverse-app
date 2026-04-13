<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_content extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getCampaigns()
    {
        $this->db->where('content_status IS NOT NULL');
        $query = $this->db->get('t_cmp_campaign');
        return $query->result();
    }

    public function getContentPlans($campaign_id)
    {
        $query = "SELECT c.*, 
        GROUP_CONCAT(DISTINCT e.user_id ORDER BY e.user_id) AS pic_ids, 
        GROUP_CONCAT(DISTINCT CONCAT(e.first_name, ' ', e.last_name) ORDER BY e.user_id) AS pic_names,
        GROUP_CONCAT(DISTINCT e.profile_picture ORDER BY e.user_id) AS pic_pictures,
        p.platform_name
        FROM t_cmp_content c 
        LEFT JOIN xin_employees e 
        ON FIND_IN_SET(e.user_id,c.content_pillar)
        LEFT JOIN m_cmp_platform p 
        ON c.platform = p.platform_id
        WHERE c.campaign_id = '$campaign_id'
        GROUP BY c.content_id";

        return $this->db->query($query)->result_array();
    }

    public function getContentPlansBySubStatus($campaign_id, $status)
    {
        // Status in content is enum('Draft','In Production','Ready','Published')
        // We need to map this or query directly.
        $query = "SELECT c.content_id, c.status
        FROM t_cmp_content c
        WHERE c.campaign_id = '$campaign_id'
        AND c.status = '$status'";
        return $this->db->query($query)->result_array();
    }

    public function update_campaign($campaign_id, $data)
    {
        $this->db->where('campaign_id', $campaign_id);
        return $this->db->update('t_cmp_campaign', $data);
    }

    public function generate_content_id()
    {
        $prefix = 'CT' . date('ymd');
        $q = $this->db->query("SELECT MAX(CAST(SUBSTRING(content_id, 8) AS UNSIGNED)) AS kd_max 
                               FROM t_cmp_content 
                               WHERE content_id LIKE '$prefix%'");
        $row = $q->row();
        $next_number = ($row->kd_max !== null) ? (int) $row->kd_max + 1 : 1;

        return $prefix . sprintf("%03d", $next_number);
    }

    public function insert_content($data)
    {
        $id = $this->generate_content_id();
        $data['content_id'] = $id;
        if ($this->db->insert('t_cmp_content', $data)) {
            return $id;
        }
        return false;
    }

    public function update_content($content_id, $data)
    {
        $this->db->where('content_id', $content_id);
        return $this->db->update('t_cmp_content', $data);
    }

    public function getContent($content_id)
    {
        $query = "SELECT c.*
        FROM t_cmp_content c 
        WHERE c.content_id = '$content_id'";
        return $this->db->query($query)->row_array();
    }

    public function getPics($campaign_id)
    {
        // Use content_team from campaign
        $query = "SELECT user_id pic_id, CONCAT(first_name, ' ', last_name) pic_name 
        FROM t_cmp_campaign c 
        LEFT JOIN xin_employees e 
        ON FIND_IN_SET(e.user_id,content_team) 
        WHERE campaign_id = '$campaign_id'";
        return $this->db->query($query)->result();
    }

    public function getPlatforms($brand_id = null)
    {
        // platform table
        $this->db->select('platform_id, platform_name');
        if ($brand_id) {
            $this->db->where('brand_id', $brand_id);
        }
        $query = $this->db->get('m_cmp_platform');
        return $query->result();
    }

    public function log_activity($data)
    {
        if (!isset($data['phase'])) {
            $data['phase'] = 'content';
        }
        if (!isset($data['phase_id'])) {
            $data['phase_id'] = $data['content_id'] ?? '';
        }
        return $this->db->insert('t_cmp_activity_logs', $data);
    }

    public function get_activity_log($content_id)
    {
        $this->db->select('l.*, CONCAT(e.first_name, " ", e.last_name) as user_name, e.profile_picture');
        $this->db->from('t_cmp_activity_logs l');
        $this->db->join('xin_employees e', 'l.user_id = e.user_id', 'left');
        $this->db->where('l.phase_id', $content_id);
        $this->db->where('l.phase', 'content');
        $this->db->order_by('l.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_all_activity_logs($limit = 10)
    {
        $this->db->select('l.*, CONCAT(e.first_name, " ", e.last_name) as user_name, e.profile_picture, c.title as activation_title');
        $this->db->from('t_cmp_activity_logs l');
        $this->db->join('xin_employees e', 'l.user_id = e.user_id', 'left');
        $this->db->join('t_cmp_content c', 'l.phase_id = c.content_id', 'left');
        $this->db->where('l.phase', 'content');
        $this->db->order_by('l.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    // Analysis Methods
    public function getContentForAnalysis($content_id)
    {
        return $this->db->get_where('t_cmp_content', ['content_id' => $content_id])->row_array();
    }

    public function save_content_analysis($data)
    {
        $this->db->where('content_id', $data['content_id']);
        $query = $this->db->get('t_cmp_content_analysis');

        if ($query->num_rows() > 0) {
            $this->db->where('content_id', $data['content_id']);
            $this->db->update('t_cmp_content_analysis', $data);
        } else {
            $this->db->insert('t_cmp_content_analysis', $data);
        }

        $history_data = $data;
        if (isset($history_data['id']))
            unset($history_data['id']);
        $this->db->insert('t_cmp_content_analysis_history', $history_data);
    }

    public function getAnalysis($content_id)
    {
        $this->db->where('content_id', $content_id);
        return $this->db->get('t_cmp_content_analysis')->row_array();
    }
}