<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_distribution extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all campaigns that have a distribution status
     */
    public function get_campaigns()
    {
        return $this->db->where('distribution_status IS NOT NULL')
            ->get('t_cmp_campaign')
            ->result();
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
                  LEFT JOIN xin_employees emp ON FIND_IN_SET(CAST(emp.user_id AS CHAR), IFNULL(c.distribution_team, ''))
                  WHERE c.distribution_status IS NOT NULL
                  AND (c.campaign_start_date BETWEEN '$start' AND '$end' OR c.campaign_end_date BETWEEN '$start' AND '$end')
                  GROUP BY c.campaign_id";
        return $this->db->query($query)->result();
    }


    /**
     * Generate a unique Distribution ID
     */
    public function generate_distribution_id()
    {
        $q = $this->db->query("SELECT CONCAT('DT',DATE_FORMAT(NOW(), '%y%m%d'),LPAD(COALESCE(MAX(CAST(SUBSTRING(distribution_id, 8) AS UNSIGNED)), 0) + 1,3,'0')) AS new_id FROM t_cmp_distribution WHERE DATE(created_at) = CURDATE()")->row();
        $next_number = ($q->new_id !== null) ? $q->new_id : 'DT' . date('ymd') . '001';
        return $next_number;
    }

    /**
     * Get approved contents for a campaign with pagination
     */
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

    /**
     * Get single content detail by ID
     */
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

    /**
     * Get distribution team for a specific campaign
     */
    public function get_distribution_team($campaign_id)
    {
        $this->db->select("
            c.campaign_id,
            c.distribution_team,
            COUNT(DISTINCT emp.user_id) AS jml_team,
            GROUP_CONCAT(DISTINCT CONCAT(emp.first_name, ' ', emp.last_name) ORDER BY emp.first_name) AS team_name,
            GROUP_CONCAT(COALESCE(emp.profile_picture,'') ORDER BY emp.first_name) AS profile_picture_team
        ");
        $this->db->from('t_cmp_campaign c');
        $this->db->join('xin_employees emp', "FIND_IN_SET(CAST(emp.user_id AS CHAR), CONVERT(CONCAT_WS(',', c.distribution_team) USING utf8mb4))", 'left', FALSE);
        $this->db->where('c.campaign_id', $campaign_id);
        $this->db->group_by('c.campaign_id');

        return $this->db->get()->result();
    }

    public function update_distribution_team($campaign_id, $team)
    {
        return $this->db->where('campaign_id', $campaign_id)
            ->update('t_cmp_campaign', ['distribution_team' => $team]);
    }

    /**
     * Dropdowns helpers
     */
    public function get_all_employees()
    {
        return $this->db->select("user_id, CONCAT(first_name, ' ', last_name) as full_name")
            ->where('is_active', 1)
            ->order_by('first_name', 'ASC')
            ->get('xin_employees')
            ->result_array();
    }

    public function get_platforms_dropdown()
    {
        return $this->db->select('platform_id, platform_name')
            ->where('is_active', 1)
            ->get('m_cmp_platform')
            ->result_array();
    }

    public function get_placements_dropdown()
    {
        return $this->db->select('placement_id, placement_name')
            ->where('is_active', 1)
            ->get('m_cmp_placement')
            ->result_array();
    }

    public function get_content_dropdown($campaign_id)
    {
        return $this->db->select('content_id, title')
            ->where('campaign_id', $campaign_id)
            ->where('status', 3)
            ->get('t_cmp_content')
            ->result_array();
    }

    /**
     * Distribution Plan CRUD
     */
    public function save_distribution_plan($data)
    {
        if ($this->db->insert('t_cmp_distribution', $data)) {
            return $data['distribution_id'];
        }
        return false;
    }

    public function get_distribution_plan($campaign_id)
    {
        $this->db->select("
            d.distribution_id,
            d.campaign_id,
            d.status,
            d.activation_id,
            d.content_id,
            c.title as content_title,
            MAX(a.title) AS title,
            DATE_FORMAT(d.deadline_publish, '%d %b %Y') AS deadline_publish,
            GROUP_CONCAT(DISTINCT p.platform_name) AS platform_name,
            GROUP_CONCAT(DISTINCT pp.placement_name) AS placement_name,
            d.audience_age,
            MAX(ss.sub_status_name) AS sub_status_name,
            COUNT(DISTINCT emp.user_id) AS jml_team,
            GROUP_CONCAT(DISTINCT CONCAT(emp.first_name, ' ', emp.last_name) ORDER BY CONCAT(emp.first_name, ' ', emp.last_name)) AS team_name,
            GROUP_CONCAT(DISTINCT emp.profile_picture ORDER BY CONCAT(emp.first_name, ' ', emp.last_name)) AS profile_picture_team,
            da.viability_score
        ");
        $this->db->from('t_cmp_distribution d');
        $this->db->join('t_cmp_distribution_analysis da', 'da.distribution_id = d.distribution_id', 'left');
        $this->db->join('t_cmp_content c', 'c.content_id = d.content_id', 'left');
        $this->db->join('t_cmp_activation a', 'a.activation_id = d.activation_id', 'left');
        $this->db->join('m_cmp_platform p', 'FIND_IN_SET(p.platform_id, d.platform)', 'left');
        $this->db->join('m_cmp_placement pp', 'FIND_IN_SET(pp.placement_id, d.placement_type)', 'left');
        $this->db->join('m_cmp_sub_status ss', 'ss.sub_status_id = d.status', 'left');
        $this->db->join('xin_employees emp', "FIND_IN_SET(CAST(emp.user_id AS CHAR), CONVERT(CONCAT_WS(',', d.created_by, d.team_involved) USING utf8mb4))", 'left', FALSE);
        $this->db->where('d.campaign_id', $campaign_id);
        $this->db->group_by('d.distribution_id, d.campaign_id, d.activation_id, d.deadline_publish');

        return $this->db->get()->result_array();
    }

    public function get_distribution_detail($distribution_id)
    {
        $this->db->select("
            d.*,
            d.distribution_id,
            c.title as content_title,
            a.title AS activation_title,
            a.description AS activation_description,
            DATE_FORMAT(d.deadline_publish, '%d %M %Y') AS deadline_publish_formatted,
            GROUP_CONCAT(DISTINCT p.platform_name) AS platform_name,
            GROUP_CONCAT(DISTINCT pp.placement_name) AS placement_name,
            ss.sub_status_name,
            GROUP_CONCAT(DISTINCT CONCAT(emp.first_name, ' ', emp.last_name) ORDER BY CONCAT(emp.first_name, ' ', emp.last_name)) AS team_name,
            GROUP_CONCAT(DISTINCT emp.profile_picture ORDER BY CONCAT(emp.first_name, ' ', emp.last_name)) AS profile_picture_team
        ");
        $this->db->from('t_cmp_distribution d');
        $this->db->join('t_cmp_content c', 'c.content_id = d.content_id', 'left');
        $this->db->join('t_cmp_activation a', 'a.activation_id = d.activation_id', 'left');
        $this->db->join('m_cmp_platform p', 'FIND_IN_SET(p.platform_id, d.platform)', 'left');
        $this->db->join('m_cmp_placement pp', 'FIND_IN_SET(pp.placement_id, d.placement_type)', 'left');
        $this->db->join('m_cmp_sub_status ss', 'ss.sub_status_id = d.status', 'left');
        $this->db->join('xin_employees emp', "FIND_IN_SET(CAST(emp.user_id AS CHAR), CONVERT(CONCAT_WS(',', d.created_by, d.team_involved) USING utf8mb4))", 'left', FALSE);
        $this->db->where('d.distribution_id', $distribution_id);
        $this->db->group_by('d.distribution_id');

        return $this->db->get()->row_array();
    }

    public function update_distribution_plan($id, $data)
    {
        return $this->db->where('distribution_id', $id)
            ->update('t_cmp_distribution', $data);
    }

    public function delete_distribution_plan($id)
    {
        return $this->db->where('distribution_id', $id)
            ->delete('t_cmp_distribution');
    }
    public function getDistributionsBySubStatus($campaign_id, $status)
    {
        $query = "SELECT a.distribution_id, a.status
        FROM t_cmp_distribution a
        WHERE a.campaign_id = '$campaign_id'
        AND a.status = '$status'";
        return $this->db->query($query)->result_array();
    }

    /**
     * Approval Logic
     */
    public function approve_distribution_plan($id)
    {
        return $this->db->where('distribution_id', $id)
            ->update('t_cmp_distribution', ['status' => 3, 'note' => 'Approved', 'approved_at' => date('Y-m-d H:i:s')]);
    }

    public function cancel_approve_plan($id)
    {
        return $this->db->where('distribution_id', $id)
            ->update('t_cmp_distribution', ['status' => 1, 'approved_at' => null]);
    }

    /**
     * Activity Logs
     */
    public function get_activity_logs($distribution_id)
    {
        return $this->db->select('l.*, CONCAT(e.first_name, " ", e.last_name) as user_name, e.profile_picture')
            ->from('t_cmp_activity_logs l')
            ->join('xin_employees e', 'e.user_id = l.user_id', 'left')
            ->where('l.phase_id', $distribution_id)
            ->where('l.phase', 'distribution')
            ->order_by('l.created_at', 'DESC')
            ->get()
            ->result_array();
    }

    public function get_distribution_logs($campaign_id)
    {
        return $this->db->select('l.*, CONCAT(e.first_name, " ", e.last_name) as user_name, e.profile_picture')
            ->from('t_cmp_activity_logs l')
            ->join('xin_employees e', 'e.user_id = l.user_id', 'left')
            ->where('l.campaign_id', $campaign_id)
            ->where('l.phase', 'distribution')
            ->order_by('l.created_at', 'DESC')
            ->limit(10)
            ->get()
            ->result_array();
    }

    /**
     * Analysis Helpers
     */
    public function get_distribution_analysis_data($distribution_id)
    {
        $this->db->select("
            d.content_id,
            c.campaign_name as project_name,
            GROUP_CONCAT(DISTINCT o.objective_name SEPARATOR ', ') as campaign_goal,
            d.audience_segment,
            d.audience_age,
            d.audience_location,
            d.audience_characteristics,
            d.tone_of_communication,
            d.collaboration_type,
            d.ads_budget_allocation,
            d.deadline_publish,
            GROUP_CONCAT(DISTINCT p.platform_name SEPARATOR ' & ') as platform,
            GROUP_CONCAT(DISTINCT pl.placement_name SEPARATOR ', ') as placement_type
        ");
        $this->db->from('t_cmp_distribution d');
        $this->db->join('t_cmp_campaign c', 'c.campaign_id = d.campaign_id');
        $this->db->join('m_cmp_objective o', 'FIND_IN_SET(o.objective_id, c.objective_id)', 'left');
        $this->db->join('m_cmp_platform p', 'FIND_IN_SET(p.platform_id, d.platform)', 'left');
        $this->db->join('m_cmp_placement pl', 'FIND_IN_SET(pl.placement_id, d.placement_type)', 'left');
        $this->db->where('d.distribution_id', $distribution_id);
        $this->db->group_by('d.distribution_id');

        return $this->db->get()->row_array();
    }

    public function save_distribution_analysis($data)
    {
        $existing = $this->get_distribution_analysis($data['distribution_id']);
        if ($existing) {
            $this->db->insert('t_cmp_distribution_analysis_history', $existing);
            return $this->db->where('distribution_id', $data['distribution_id'])
                ->update('t_cmp_distribution_analysis', $data);
        } else {
            return $this->db->insert('t_cmp_distribution_analysis', $data);
        }
    }

    public function get_distribution_analysis($distribution_id)
    {
        return $this->db->where('distribution_id', $distribution_id)
            ->get('t_cmp_distribution_analysis')
            ->row_array();
    }

    /**
     * Dashboard Statistics
     */
    public function get_distribution_performance_stats($campaign_id)
    {
        // Total Input
        $total_input = $this->db->where('campaign_id', $campaign_id)->count_all_results('t_cmp_distribution');

        // Total Approved
        $total_approved = $this->db->where('campaign_id', $campaign_id)->where('status', 3)->count_all_results('t_cmp_distribution');

        // Target
        $campaign = $this->db->select('distribution_target')->where('campaign_id', $campaign_id)->get('t_cmp_campaign')->row_array();
        $target = $campaign ? (int) $campaign['distribution_target'] : 0;

        // Efficiency
        $efficiency = ($total_input > 0) ? round(($total_approved / $total_input) * 100) : 0;

        return [
            'total_input' => $total_input,
            'total_approved' => $total_approved,
            'target' => $target,
            'efficiency' => $efficiency
        ];
    }

    public function getDistributionStats()
    {
        $query = "SELECT
                    COUNT(d.distribution_id)                                     AS total_submissions,
                    ROUND(AVG(an.viability_score), 1)                            AS avg_ai_score,
                    COUNT(d.status = 3)   AS approved_plans,
                    ROUND(AVG(DATEDIFF(d.approved_at, d.created_at)), 0)  AS avg_lead_days
                  FROM t_cmp_distribution d
                  LEFT JOIN t_cmp_distribution_analysis an ON an.distribution_id = d.distribution_id";
        return $this->db->query($query)->row_array();
    }
}