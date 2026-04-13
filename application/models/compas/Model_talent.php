<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_talent extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_approved_contents($campaign_id, $limit = 3, $start = 0)
    {
        $this->db->select("
            d.content_id,
            a.title AS activation_title,
            a.description AS activation_description,
            d.title AS content_title,
            DATE_FORMAT(d.deadline_publish, '%d %M %Y') AS deadline_publish_formatted,
            GROUP_CONCAT(DISTINCT p.platform_name SEPARATOR ', ') AS platform_name,
            GROUP_CONCAT(DISTINCT pp.placement_name SEPARATOR ', ') AS placement_name,
            GROUP_CONCAT(DISTINCT cp.cp_name SEPARATOR ', ') AS content_pillar_name,
            GROUP_CONCAT(DISTINCT cf.cf_name SEPARATOR ', ') AS format_name,
            GROUP_CONCAT(DISTINCT tt.talent_type_name SEPARATOR ', ') AS talent_type_name,
            ss.sub_status_name,
            GROUP_CONCAT(DISTINCT CONCAT(e.first_name, ' ', e.last_name) ORDER BY e.first_name SEPARATOR ', ') AS team_name,
            GROUP_CONCAT(DISTINCT e.profile_picture ORDER BY e.first_name SEPARATOR ', ') AS profile_picture_team
        ");
        $this->db->from('t_cmp_content d');
        $this->db->join('t_cmp_activation a', 'a.activation_id = d.activation_id', 'left');
        $this->db->join('t_cmp_campaign c', 'c.campaign_id = d.campaign_id', 'left');
        $this->db->join('m_cmp_platform p', 'FIND_IN_SET(p.platform_id, d.platform)', 'left');
        $this->db->join('m_cmp_placement pp', 'FIND_IN_SET(pp.placement_id, d.placement_type)', 'left');
        $this->db->join('m_cmp_content_pillar cp', 'FIND_IN_SET(cp.cp_id, d.content_pillar)', 'left');
        $this->db->join('m_cmp_content_format cf', 'FIND_IN_SET(cf.cf_id, d.format)', 'left');
        $this->db->join('m_cmp_talent_type tt', 'FIND_IN_SET(tt.talent_type_id, d.talent_type)', 'left');
        $this->db->join('m_cmp_sub_status ss', 'ss.sub_status_id = d.status', 'left');
        $this->db->join('xin_employees e', 'FIND_IN_SET(e.user_id, c.content_team)', 'left');
        $this->db->where('d.campaign_id', $campaign_id);
        $this->db->where('d.status', 3);
        $this->db->group_by('d.content_id');
        $this->db->limit($limit, $start);

        return $this->db->get()->result_array();
    }

    public function count_approved_contents($campaign_id)
    {
        $this->db->where('campaign_id', $campaign_id);
        $this->db->where('status', 3);
        return ['total' => $this->db->count_all_results('t_cmp_content')];
    }

    public function get_content_by_id($id)
    {
        $this->db->select("
            d.*,
            d.content_id,
            a.title AS activation_title,
            a.description AS activation_description,
            DATE_FORMAT(d.deadline_publish, '%d %M %Y') AS deadline_publish_formatted,
            GROUP_CONCAT(DISTINCT p.platform_name SEPARATOR ', ') AS platform_name,
            GROUP_CONCAT(DISTINCT pp.placement_name SEPARATOR ', ') AS placement_name,
            GROUP_CONCAT(DISTINCT cp.cp_name SEPARATOR ', ') AS content_pillar_name,
            GROUP_CONCAT(DISTINCT cf.cf_name SEPARATOR ', ') AS format_name,
            GROUP_CONCAT(DISTINCT tt.talent_type_name SEPARATOR ', ') AS talent_type_name,
            ss.sub_status_name,
            GROUP_CONCAT(DISTINCT CONCAT(e.first_name, ' ', e.last_name) ORDER BY e.first_name SEPARATOR ', ') AS team_name,
            GROUP_CONCAT(DISTINCT e.profile_picture ORDER BY e.first_name SEPARATOR ', ') AS profile_picture_team
        ");
        $this->db->from('t_cmp_content d');
        $this->db->join('t_cmp_activation a', 'a.activation_id = d.activation_id', 'left');
        $this->db->join('t_cmp_campaign c', 'c.campaign_id = d.campaign_id', 'left');
        $this->db->join('m_cmp_platform p', 'FIND_IN_SET(p.platform_id, d.platform)', 'left');
        $this->db->join('m_cmp_placement pp', 'FIND_IN_SET(pp.placement_id, d.placement_type)', 'left');
        $this->db->join('m_cmp_content_pillar cp', 'FIND_IN_SET(cp.cp_id, d.content_pillar)', 'left');
        $this->db->join('m_cmp_content_format cf', 'FIND_IN_SET(cf.cf_id, d.format)', 'left');
        $this->db->join('m_cmp_talent_type tt', 'FIND_IN_SET(tt.talent_type_id, d.talent_type)', 'left');
        $this->db->join('m_cmp_sub_status ss', 'ss.sub_status_id = d.status', 'left');
        $this->db->join('xin_employees e', 'FIND_IN_SET(e.user_id, c.content_team)', 'left');
        $this->db->where('d.content_id', $id);
        $this->db->group_by('d.content_id');

        return $this->db->get()->row_array();
    }

    public function get_talent_team($campaign_id)
    {
        $query = "SELECT
                    c.campaign_id,
                    c.talent_team,
                    COUNT(DISTINCT emp.user_id) AS jml_team,
                    GROUP_CONCAT(DISTINCT CONCAT(emp.first_name, ' ', emp.last_name) ORDER BY emp.first_name) AS team_name,
                    GROUP_CONCAT(COALESCE(emp.profile_picture,'') ORDER BY emp.first_name) AS profile_picture_team
                  FROM t_cmp_campaign c
                  LEFT JOIN xin_employees emp ON FIND_IN_SET(CAST(emp.user_id AS CHAR), CONVERT(
                            CONCAT_WS(',', c.talent_team)
                            USING utf8mb4
                        )) 
                  WHERE c.campaign_id = '$campaign_id'
                  GROUP BY c.campaign_id";

        return $this->db->query($query)->result();
    }

    public function update_talent_team($campaign_id, $team)
    {
        $this->db->where('campaign_id', $campaign_id);
        return $this->db->update('t_cmp_campaign', ['talent_team' => $team]);
    }

    public function get_all_employees()
    {
        $this->db->select("user_id, CONCAT(first_name, ' ', last_name) as full_name");
        $this->db->from('xin_employees');
        $this->db->where('is_active', 1);
        $this->db->order_by('first_name', 'ASC');
        return $this->db->get()->result_array();
    }

    public function getCampaigns()
    {
        $this->db->where('talent_status IS NOT NULL');
        $query = $this->db->get('t_cmp_campaign');
        return $query->result();
    }

    public function get_campaigns_by_date($start, $end)
    {
        $query = "SELECT 
                    c.*,
                    b.brand_name,
                    COUNT(DISTINCT emp.user_id) AS team_count,
                    GROUP_CONCAT(DISTINCT CONCAT(emp.first_name, ' ', emp.last_name) ORDER BY emp.first_name SEPARATOR ', ') AS team_names,
                    GROUP_CONCAT(COALESCE(emp.profile_picture, '') ORDER BY emp.first_name SEPARATOR ',') AS team_pictures,
                    CASE
                        WHEN NOW() > DATE_ADD(c.created_at, INTERVAL 7 DAY)
                            THEN 'Late'
                        WHEN DATEDIFF(
                                DATE_ADD(c.created_at, INTERVAL 7 DAY),
                                NOW()
                            ) <= 2
                            THEN 'At Risk'
                        ELSE 'On Track'
                    END AS status_leadtime
                  FROM t_cmp_campaign c
                  LEFT JOIN m_cmp_brand b ON b.brand_id = c.brand_id
                  LEFT JOIN xin_employees emp ON FIND_IN_SET(CAST(emp.user_id AS CHAR), IFNULL(c.talent_team, ''))
                  WHERE c.talent_status IS NOT NULL
                  AND (c.campaign_start_date BETWEEN '$start' AND '$end' OR c.campaign_end_date BETWEEN '$start' AND '$end')
                  GROUP BY c.campaign_id";
        return $this->db->query($query)->result();
    }

    public function getTalents($campaign_id)
    {
        $query = "SELECT
            t.*,
            MAX(ss.sub_status_name) AS sub_status_name,
            GROUP_CONCAT(DISTINCT e.user_id ORDER BY e.user_id) AS pic_ids,
            GROUP_CONCAT(DISTINCT CONCAT(e.first_name, ' ', e.last_name) ORDER BY e.user_id) AS pic_names,
            GROUP_CONCAT(DISTINCT e.profile_picture ORDER BY e.user_id) AS pic_pictures,

            /* Linked content basic info */
            c.content_id AS linked_content_id,
            c.title AS content_title,
            c.format AS content_format,
            c.publish_date AS content_publish_date,

            /* Resolve platform IDs stored comma-separated in t_cmp_content.platform */
            GROUP_CONCAT(DISTINCT p.platform_name ORDER BY p.platform_name) AS platform_name,

            /* Resolve content pillar IDs stored comma-separated in t_cmp_content.content_pillar */
            GROUP_CONCAT(DISTINCT cp.cp_name ORDER BY cp.cp_name) AS content_pillar_name,

            /* Resolve placement IDs stored comma-separated in t_cmp_content.placement */
            GROUP_CONCAT(DISTINCT pl.placement_name ORDER BY pl.placement_name) AS placement_name,

            /* Resolve format IDs stored comma-separated in t_cmp_content.format */
            GROUP_CONCAT(DISTINCT cf.cf_name ORDER BY cf.cf_name) AS format_name,
            ta.viability_score

        FROM t_cmp_talent t
        LEFT JOIN t_cmp_talent_analysis ta ON ta.talent_id = t.talent_id
        LEFT JOIN xin_employees e
            ON FIND_IN_SET(e.user_id, t.pic)
        LEFT JOIN m_cmp_sub_status ss
            ON ss.sub_status_id = t.`status`

        /* Join linked content */
        LEFT JOIN t_cmp_content c
            ON c.content_id = t.content_id

        /* Resolve platform names (platform stores comma-sep platform_ids) */
        LEFT JOIN m_cmp_platform p
            ON FIND_IN_SET(p.platform_id, IFNULL(c.platform, ''))

        /* Resolve content pillar names (content_pillar stores comma-sep cp_ids) */
        LEFT JOIN m_cmp_content_pillar cp
            ON FIND_IN_SET(cp.cp_id, IFNULL(c.content_pillar, ''))
            
        LEFT JOIN m_cmp_content_format cf
            ON FIND_IN_SET(cf.cf_id, IFNULL(c.format, ''))

        LEFT JOIN m_cmp_placement pl
            ON FIND_IN_SET(pl.placement_id, IFNULL(c.placement_type, ''))

        WHERE t.campaign_id = '$campaign_id'
        GROUP BY t.talent_id";

        return $this->db->query($query)->result_array();
    }

    public function getTalentsBySubStatus($campaign_id, $status)
    {
        $query = "SELECT t.talent_id, t.status
        FROM t_cmp_talent t
        WHERE t.campaign_id = '$campaign_id'
        AND t.status = '$status'";
        return $this->db->query($query)->result_array();
    }

    public function update_campaign($campaign_id, $data)
    {
        $this->db->where('campaign_id', $campaign_id);
        return $this->db->update('t_cmp_campaign', $data);
    }

    public function generate_talent_id()
    {
        $q = $this->db->query("SELECT CONCAT('T',DATE_FORMAT(NOW(), '%y%m%d'),LPAD(COALESCE(MAX(CAST(SUBSTRING(talent_id, 8) AS UNSIGNED)), 0) + 1,3,'0')) AS new_id FROM t_cmp_talent WHERE DATE(created_at) = CURDATE()")->row();
        $next_number = ($q->new_id !== null) ? $q->new_id : 'T' . date('ymd') . '001';
        return $next_number;
    }

    public function insert_talent($data)
    {
        $id = $this->generate_talent_id();
        $data['talent_id'] = $id;
        if ($this->db->insert('t_cmp_talent', $data)) {
            return $id;
        }
        return false;
    }

    public function update_talent($talent_id, $data)
    {
        $this->db->where('talent_id', $talent_id);
        return $this->db->update('t_cmp_talent', $data);
    }

    public function getPics($campaign_id)
    {
        $query = "SELECT user_id pic_id, CONCAT(first_name, ' ', last_name) pic_name 
        FROM t_cmp_campaign c 
        LEFT JOIN xin_employees e 
        ON FIND_IN_SET(e.user_id,talent_team) 
        WHERE campaign_id = '$campaign_id'";
        return $this->db->query($query)->result();
    }

    public function getTalent($talent_id)
    {
        $query = "SELECT
            t.*,
            GROUP_CONCAT(DISTINCT e.user_id ORDER BY e.user_id ASC)                          AS pic_ids,
            GROUP_CONCAT(DISTINCT CONCAT(e.first_name, ' ', e.last_name) ORDER BY e.user_id ASC) AS pic_names,
            GROUP_CONCAT(DISTINCT e.profile_picture ORDER BY e.user_id ASC)                  AS pic_pictures,

            /* Linked content */
            c.content_id                                                                     AS linked_content_id,
            c.title                                                                          AS content_title,
            c.format                                                                         AS content_format,
            c.publish_date                                                                   AS content_publish_date,

            /* Resolve platform IDs → names */
            GROUP_CONCAT(DISTINCT p.platform_name ORDER BY p.platform_name)                  AS platform_name,

            /* Resolve content pillar IDs → names */
            GROUP_CONCAT(DISTINCT cp.cp_name ORDER BY cp.cp_name)                            AS content_pillar_name,

            /* Resolve format IDs → names */
            GROUP_CONCAT(DISTINCT cf.cf_name ORDER BY cf.cf_name)                            AS format_name,

            /* Resolve placement IDs → names */
            GROUP_CONCAT(DISTINCT pl.placement_name ORDER BY pl.placement_name)                AS placement_name

        FROM t_cmp_talent t
        LEFT JOIN xin_employees e
            ON FIND_IN_SET(e.user_id, t.pic)
        LEFT JOIN t_cmp_content c
            ON c.content_id = t.content_id
        LEFT JOIN m_cmp_platform p
            ON FIND_IN_SET(p.platform_id, IFNULL(c.platform, ''))
        LEFT JOIN m_cmp_content_pillar cp
            ON FIND_IN_SET(cp.cp_id, IFNULL(c.content_pillar, ''))
        LEFT JOIN m_cmp_content_format cf
            ON FIND_IN_SET(cf.cf_id, IFNULL(c.format, ''))
        LEFT JOIN m_cmp_placement pl
            ON FIND_IN_SET(pl.placement_id, IFNULL(c.placement_type, ''))
        WHERE t.talent_id = '$talent_id'
        GROUP BY t.talent_id";

        return $this->db->query($query)->row_array();
    }

    public function log_activity($data)
    {
        // Add phase if not present
        if (!isset($data['phase'])) {
            $data['phase'] = 'talent';
        }
        if (!isset($data['phase_id'])) {
            // Assuming phase_id maps to talent_id
            $data['phase_id'] = $data['talent_id'] ?? '';
            // If data has talent_id set phase_id to it.
            if (isset($data['talent_id']))
                $data['phase_id'] = $data['talent_id'];
        }
        // Remove talent_id from data if it exists to avoid error if column doesn't exist in log table
        if (isset($data['talent_id']))
            unset($data['talent_id']);

        return $this->db->insert('t_cmp_activity_logs', $data);
    }

    public function get_activity_log($talent_id)
    {
        $this->db->select('l.*, CONCAT(e.first_name, " ", e.last_name) as user_name, e.profile_picture');
        $this->db->from('t_cmp_activity_logs l');
        $this->db->join('xin_employees e', 'l.user_id = e.user_id', 'left');
        $this->db->where('l.phase_id', $talent_id);
        $this->db->where('l.phase', 'talent');
        $this->db->order_by('l.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_all_activity_logs($limit = 10)
    {
        $this->db->select('l.*, CONCAT(e.first_name, " ", e.last_name) as user_name, e.profile_picture, t.talent_name as activation_title');
        $this->db->from('t_cmp_activity_logs l');
        $this->db->join('xin_employees e', 'l.user_id = e.user_id', 'left');
        $this->db->join('t_cmp_talent t', 'l.phase_id = t.talent_id', 'left');
        $this->db->where('l.phase', 'talent');
        $this->db->order_by('l.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }


    public function delete_talent($id)
    {
        $this->db->where('talent_id', $id);
        return $this->db->delete('t_cmp_talent');
    }

    // Analysis Methods
    public function getTalentForAnalysis($talent_id)
    {
        return $this->db->get_where('t_cmp_talent', ['talent_id' => $talent_id])->row_array();
    }

    public function save_talent_analysis($data)
    {
        $this->db->where('talent_id', $data['talent_id']);
        $query = $this->db->get('t_cmp_talent_analysis');

        if ($query->num_rows() > 0) {
            $this->db->where('talent_id', $data['talent_id']);
            $this->db->update('t_cmp_talent_analysis', $data);
        } else {
            $this->db->insert('t_cmp_talent_analysis', $data);
        }

        $history_data = $data;
        if (isset($history_data['id']))
            unset($history_data['id']);
        $this->db->insert('t_cmp_talent_analysis_history', $history_data);
    }

    public function getAnalysis($talent_id)
    {
        $this->db->where('talent_id', $talent_id);
        return $this->db->get('t_cmp_talent_analysis')->row_array();
    }
    public function get_talent_performance_stats($campaign_id)
    {
        // Efficiency: Based on completed talents vs total target
        // Done: Total approved talents

        $this->db->select('talent_target');
        $this->db->where('campaign_id', $campaign_id);
        $campaign = $this->db->get('t_cmp_campaign')->row_array();
        $target = $campaign['talent_target'] ?? 0;

        $this->db->where('campaign_id', $campaign_id);
        $this->db->where('status', '3'); // Approved
        $done = $this->db->count_all_results('t_cmp_talent');

        $efficiency = $target > 0 ? round(($done / $target) * 100) : 0;

        return [
            'efficiency' => $efficiency . '%',
            'done' => $done
        ];
    }

    public function get_comments($campaign_id, $phase = 'talent')
    {
        $this->db->select('c.*, CONCAT(e.first_name, " ", e.last_name) as fullname, e.profile_picture');
        $this->db->from('t_cmp_comments c');
        $this->db->join('xin_employees e', 'e.user_id = c.user_id', 'left');
        $this->db->where('c.campaign_id', $campaign_id);
        $this->db->where('c.phase', $phase);
        return $this->db->get()->result_array();
    }

    public function get_comment_upvote_status($comment_id, $user_id)
    {
        return $this->db->where('comment_id', $comment_id)
            ->where('user_id', $user_id)
            ->count_all_results('t_cmp_comment_upvotes') > 0;
    }

    public function get_comment_attachments($comment_id)
    {
        return $this->db->where('comment_id', $comment_id)
            ->get('t_cmp_comment_attachments')
            ->result_array();
    }

    public function insert_comment($data)
    {
        $this->db->insert('t_cmp_comments', $data);
        return $this->db->insert_id();
    }

    public function update_comment_attachments($attachment_ids, $comment_id)
    {
        $this->db->where_in('id', $attachment_ids);
        return $this->db->update('t_cmp_comment_attachments', ['comment_id' => $comment_id]);
    }

    public function get_comment_with_user($comment_id)
    {
        return $this->db->select('c.*, CONCAT(e.first_name, " ", e.last_name) as fullname, e.profile_picture')
            ->from('t_cmp_comments c')
            ->join('xin_employees e', 'e.user_id = c.user_id', 'left')
            ->where('c.id', $comment_id)
            ->get()->row_array();
    }

    public function insert_comment_attachment($data)
    {
        $this->db->insert('t_cmp_comment_attachments', $data);
        return $this->db->insert_id();
    }

    public function delete_comment($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('t_cmp_comments');
    }

    public function upvote_comment($comment_id, $user_id, $has_upvoted)
    {
        if ($has_upvoted) {
            $exists = $this->db->where('comment_id', $comment_id)
                ->where('user_id', $user_id)
                ->count_all_results('t_cmp_comment_upvotes');
            if (!$exists) {
                $this->db->insert('t_cmp_comment_upvotes', ['comment_id' => $comment_id, 'user_id' => $user_id]);
                $this->db->set('upvote_count', 'upvote_count+1', FALSE)
                    ->where('id', $comment_id)
                    ->update('t_cmp_comments');
            }
        } else {
            $this->db->where('comment_id', $comment_id)
                ->where('user_id', $user_id)
                ->delete('t_cmp_comment_upvotes');
            $this->db->set('upvote_count', 'upvote_count-1', FALSE)
                ->where('id', $comment_id)
                ->update('t_cmp_comments');
        }
        return true;
    }

    public function get_comment_users()
    {
        return $this->db->select('user_id as id, CONCAT(first_name, " ", last_name) as fullname, email, profile_picture as profile_picture_url')
            ->from('xin_employees')
            ->where('is_active', 1)
            ->get()->result_array();
    }

    public function get_talent_logs($campaign_id)
    {
        $this->db->select('l.*, CONCAT(e.first_name, " ", e.last_name) as user_name, e.profile_picture');
        $this->db->from('t_cmp_activity_logs l');
        $this->db->join('xin_employees e', 'l.user_id = e.user_id', 'left');
        $this->db->where('l.campaign_id', $campaign_id);
        $this->db->where('l.phase', 'talent');
        $this->db->order_by('l.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    /**
     * Get all talents from master table m_cmp_talent
     * Used for existing talent picker in the form
     */
    public function get_master_talents()
    {
        $this->db->select('id, talent_id, talent_name, rate, persona, communication_style, username_tiktok, username_ig, content_niche');
        $this->db->from('m_cmp_talent');
        $this->db->order_by('talent_name', 'ASC');
        return $this->db->get()->result_array();
    }

    /**
     * Insert or update master talent record in m_cmp_talent
     * If talent_name already exists, update it. Otherwise insert a new record.
     */
    public function upsert_master_talent($data)
    {
        // Check by talent_name and tiktok/ig for uniqueness
        $this->db->where('talent_name', $data['talent_name']);
        $existing = $this->db->get('m_cmp_talent')->row_array();

        $master_data = [
            'talent_name' => $data['talent_name'],
            'rate' => $data['rate'] ?? 0,
            'persona' => $data['persona'] ?? null,
            'communication_style' => $data['communication_style'] ?? null,
            'username_tiktok' => $data['username_tiktok'] ?? null,
            'username_ig' => $data['username_ig'] ?? null,
            'content_niche' => $data['content_niche'] ?? null,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $data['user_id'] ?? null,
        ];

        if ($existing) {
            $this->db->where('talent_id', $existing['talent_id']);
            $this->db->update('m_cmp_talent', $master_data);
            return $existing['talent_id'];
        } else {
            // Generate new master talent_id
            $prefix = 'MT' . date('ymd');
            $q = $this->db->query("SELECT MAX(CAST(SUBSTRING(talent_id, 9) AS UNSIGNED)) AS kd_max
                                    FROM m_cmp_talent
                                    WHERE talent_id LIKE '$prefix%'");
            $row = $q->row();
            $next_number = ($row->kd_max !== null) ? (int) $row->kd_max + 1 : 1;
            $new_id = $prefix . sprintf('%03d', $next_number);

            $master_data['talent_id'] = $new_id;
            $master_data['created_at'] = date('Y-m-d H:i:s');
            $master_data['created_by'] = $data['user_id'] ?? null;

            $this->db->insert('m_cmp_talent', $master_data);
            return $new_id;
        }
    }

    /**
     * Get content list for a campaign (for the content_id picker in talent form).
     * Resolves platform IDs and format IDs to human-readable names via JOINs.
     */
    public function get_contents_by_campaign($campaign_id)
    {
        $query = "SELECT
            c.content_id,
            c.title,
            c.publish_date,
            c.talent_target,

            GROUP_CONCAT(DISTINCT p.platform_name ORDER BY p.platform_name SEPARATOR ', ') AS platform,

            COALESCE(f.cf_name, c.format)                                              AS format

        FROM t_cmp_content c
        LEFT JOIN m_cmp_platform p
            ON FIND_IN_SET(p.platform_id, IFNULL(c.platform, ''))
        LEFT JOIN m_cmp_content_format f
            ON FIND_IN_SET(f.cf_id, IFNULL(c.format, ''))
        WHERE c.campaign_id = '$campaign_id'
        GROUP BY c.content_id
        ORDER BY c.created_at DESC";

        return $this->db->query($query)->result_array();
    }


    /**
     * Get talent performance stats - total approved taken from t_cmp_talent
     */
    public function get_talent_performance_stats_full($campaign_id)
    {
        $this->db->select('SUM(talent_target) as talent_target');
        $this->db->where('campaign_id', $campaign_id);
        $campaign = $this->db->get('t_cmp_content')->row_array();
        $target = $campaign['talent_target'] ?? 0;

        $this->db->where('campaign_id', $campaign_id);
        $this->db->where('status', '3');
        $done = $this->db->count_all_results('t_cmp_talent');

        $this->db->where('campaign_id', $campaign_id);
        $total = $this->db->count_all_results('t_cmp_talent');

        $efficiency = $target > 0 ? round(($done / $target) * 100) : 0;

        return [
            'efficiency' => $efficiency,
            'total_approved' => $done,
            'total' => $total,
            'target' => $target,
        ];
    }

    public function getTalentStats()
    {
        $query = "SELECT
                    COUNT(t.talent_id)                                           AS total_submissions,
                    ROUND(AVG(an.analysis_json->>'$.output.skor_kecocokan_keseluruhan.nilai'), 1)                              AS avg_ai_score,
                    SUM(CASE WHEN an.analysis_json->>'$.output.skor_kecocokan_keseluruhan.nilai' >= 70 THEN 1 ELSE 0 END)     AS approved_plans,
                    COUNT(DISTINCT t.talent_name)                                AS unique_talents
                  FROM t_cmp_talent t
                  LEFT JOIN t_cmp_talent_analysis an ON an.talent_id = t.talent_id";
        return $this->db->query($query)->row_array();
    }
}