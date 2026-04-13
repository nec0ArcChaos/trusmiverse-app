<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_optimization extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all campaigns that have a optimization status
     */
    public function get_campaigns()
    {
        return $this->db->where('optimization_status IS NOT NULL')
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
                  LEFT JOIN xin_employees emp ON FIND_IN_SET(CAST(emp.user_id AS CHAR), IFNULL(c.optimization_team, ''))
                  WHERE c.optimization_status IS NOT NULL
                  AND (c.campaign_start_date BETWEEN '$start' AND '$end' OR c.campaign_end_date BETWEEN '$start' AND '$end')
                  GROUP BY c.campaign_id";
        return $this->db->query($query)->result();
    }

    /**
     * Generate a unique Optimization ID
     */
    public function generate_optimization_id()
    {
        $q = $this->db->query("SELECT CONCAT('OPT',DATE_FORMAT(NOW(), '%y%m%d'),LPAD(COALESCE(MAX(CAST(SUBSTRING(optimization_id, 7) AS UNSIGNED)), 0) + 1,3,'0')) AS new_id FROM t_cmp_optimization WHERE DATE(created_at) = CURDATE()")->row();
        $next_number = ($q->new_id !== null) ? $q->new_id : 'OPT' . date('ymd') . '001';
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
     * Get optimization team for a specific campaign
     */
    public function get_optimization_team($campaign_id)
    {
        $this->db->select("
            c.campaign_id,
            c.optimization_team,
            COUNT(DISTINCT emp.user_id) AS jml_team,
            GROUP_CONCAT(DISTINCT CONCAT(emp.first_name, ' ', emp.last_name) ORDER BY emp.first_name) AS team_name,
            GROUP_CONCAT(COALESCE(emp.profile_picture,'') ORDER BY emp.first_name) AS profile_picture_team
        ");
        $this->db->from('t_cmp_campaign c');
        $this->db->join('xin_employees emp', "FIND_IN_SET(CAST(emp.user_id AS CHAR), CONVERT(CONCAT_WS(',', c.optimization_team) USING utf8mb4))", 'left', FALSE);
        $this->db->where('c.campaign_id', $campaign_id);
        $this->db->group_by('c.campaign_id');

        return $this->db->get()->result();
    }

    public function update_optimization_team($campaign_id, $team)
    {
        return $this->db->where('campaign_id', $campaign_id)
            ->update('t_cmp_campaign', ['optimization_team' => $team]);
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
     * Optimization Plan CRUD
     */
    public function save_optimization_plan($data)
    {
        if ($this->db->insert('t_cmp_optimization', $data)) {
            return $data['optimization_id'];
        }
        return false;
    }

    public function get_optimization_plan($campaign_id)
    {
        $this->db->select("
            o.optimization_id,
            o.campaign_id,
            o.status,
            o.content_id,
            o.optimization_name,
            o.optimization_desc,
            c.title as content_title,
            MAX(a.title) AS title,
            DATE_FORMAT(o.deadline_optimization, '%d %b %Y') AS deadline_optimization,
            MAX(ss.sub_status_name) AS sub_status_name,
            COUNT(DISTINCT emp.user_id) AS jml_team,
            GROUP_CONCAT(DISTINCT CONCAT(emp.first_name, ' ', emp.last_name) ORDER BY CONCAT(emp.first_name, ' ', emp.last_name)) AS team_name,
            GROUP_CONCAT(DISTINCT emp.profile_picture ORDER BY CONCAT(emp.first_name, ' ', emp.last_name)) AS profile_picture_team,
            da.viability_score
        ");
        $this->db->from('t_cmp_optimization o');
        $this->db->join('t_cmp_optimization_analysis da', 'da.optimization_id = o.optimization_id', 'left');
        $this->db->join('t_cmp_content c', 'c.content_id = o.content_id', 'left');
        $this->db->join('t_cmp_activation a', 'a.activation_id = c.activation_id', 'left');
        $this->db->join('m_cmp_sub_status ss', 'ss.sub_status_id = o.status', 'left');
        $this->db->join('xin_employees emp', "FIND_IN_SET(CAST(emp.user_id AS CHAR), CONVERT(CONCAT_WS(',', o.created_by) USING utf8mb4))", 'left', FALSE);
        $this->db->where('o.campaign_id', $campaign_id);
        $this->db->group_by('o.optimization_id, o.campaign_id, o.activation_id, o.deadline_optimization');

        return $this->db->get()->result_array();
    }

    public function get_optimization_detail($optimization_id)
    {
        $this->db->select("
            d.*,
            d.optimization_id,
            c.title as content_title,
            a.title AS activation_title,
            a.description AS activation_description,
            DATE_FORMAT(d.deadline_optimization, '%d %M %Y') AS deadline_optimization_formatted,
            ss.sub_status_name,
            GROUP_CONCAT(DISTINCT CONCAT(emp.first_name, ' ', emp.last_name) ORDER BY CONCAT(emp.first_name, ' ', emp.last_name)) AS team_name,
            GROUP_CONCAT(DISTINCT emp.profile_picture ORDER BY CONCAT(emp.first_name, ' ', emp.last_name)) AS profile_picture_team
        ");
        $this->db->from('t_cmp_optimization d');
        $this->db->join('t_cmp_content c', 'c.content_id = d.content_id', 'left');
        $this->db->join('t_cmp_activation a', 'a.activation_id = c.activation_id', 'left');
        $this->db->join('m_cmp_sub_status ss', 'ss.sub_status_id = d.status', 'left');
        $this->db->join('xin_employees emp', "FIND_IN_SET(CAST(emp.user_id AS CHAR), CONVERT(CONCAT_WS(',', d.created_by) USING utf8mb4))", 'left', FALSE);
        $this->db->where('d.optimization_id', $optimization_id);
        $this->db->group_by('d.optimization_id');

        return $this->db->get()->row_array();
    }

    public function update_optimization_plan($id, $data)
    {
        return $this->db->where('optimization_id', $id)
            ->update('t_cmp_optimization', $data);
    }

    public function delete_optimization_plan($id)
    {
        return $this->db->where('optimization_id', $id)
            ->delete('t_cmp_optimization');
    }

    public function getOptimizationsBySubStatus($campaign_id, $status)
    {
        $query = "SELECT a.optimization_id, a.status
        FROM t_cmp_optimization a
        WHERE a.campaign_id = '$campaign_id'
        AND a.status = '$status'";
        return $this->db->query($query)->result_array();
    }
    /**
     * Approval Logic
     */
    public function approve_optimization_plan($id)
    {
        return $this->db->where('optimization_id', $id)
            ->update('t_cmp_optimization', ['status' => 3, 'note' => 'Approved', 'approved_at' => date('Y-m-d H:i:s')]);
    }

    public function cancel_approve_plan($id)
    {
        return $this->db->where('optimization_id', $id)
            ->update('t_cmp_optimization', ['status' => 1, 'approved_at' => null]);
    }

    /**
     * Activity Logs
     */
    public function get_activity_logs($optimization_id)
    {
        return $this->db->select('l.*, CONCAT(e.first_name, " ", e.last_name) as user_name, e.profile_picture')
            ->from('t_cmp_activity_logs l')
            ->join('xin_employees e', 'e.user_id = l.user_id', 'left')
            ->where('l.phase_id', $optimization_id)
            ->where('l.phase', 'optimization')
            ->order_by('l.created_at', 'DESC')
            ->get()
            ->result_array();
    }

    public function get_optimization_logs($campaign_id)
    {
        return $this->db->select('l.*, CONCAT(e.first_name, " ", e.last_name) as user_name, e.profile_picture')
            ->from('t_cmp_activity_logs l')
            ->join('xin_employees e', 'e.user_id = l.user_id', 'left')
            ->where('l.campaign_id', $campaign_id)
            ->where('l.phase', 'optimization')
            ->order_by('l.created_at', 'DESC')
            ->limit(10)
            ->get()
            ->result_array();
    }

    /**
     * Analysis Helpers
     */
    public function get_optimization_analysis_data($optimization_id)
    {
        $this->db->select("
            o.content_id,
            c.campaign_name as project_name,
            GROUP_CONCAT(DISTINCT obj.objective_name SEPARATOR ', ') as campaign_goal,
            o.optimization_name,
            o.optimization_desc,
            o.opt_budget_allocation,
            o.deadline_optimization
        ");
        $this->db->from('t_cmp_optimization o');
        $this->db->join('t_cmp_campaign c', 'c.campaign_id = o.campaign_id');
        $this->db->join('m_cmp_objective obj', 'FIND_IN_SET(obj.objective_id, c.objective_id)', 'left');
        $this->db->where('o.optimization_id', $optimization_id);
        $this->db->group_by('o.optimization_id');

        return $this->db->get()->row_array();
    }

    public function save_optimization_analysis($data)
    {
        $existing = $this->get_optimization_analysis($data['optimization_id']);
        if ($existing) {
            $this->db->insert('t_cmp_optimization_analysis_history', $existing);
            return $this->db->where('optimization_id', $data['optimization_id'])
                ->update('t_cmp_optimization_analysis', $data);
        } else {
            return $this->db->insert('t_cmp_optimization_analysis', $data);
        }
    }

    public function get_optimization_analysis($optimization_id)
    {
        return $this->db->where('optimization_id', $optimization_id)
            ->get('t_cmp_optimization_analysis')
            ->row_array();
    }

    /**
     * Dashboard Statistics
     */
    public function get_optimization_performance_stats($campaign_id)
    {
        // Total Input
        $total_input = $this->db->where('campaign_id', $campaign_id)->count_all_results('t_cmp_optimization');

        // Total Approved
        $total_approved = $this->db->where('campaign_id', $campaign_id)->where('status', 3)->count_all_results('t_cmp_optimization');

        // Target
        $campaign = $this->db->select('optimization_target')->where('campaign_id', $campaign_id)->get('t_cmp_campaign')->row_array();
        $target = $campaign ? (int) $campaign['optimization_target'] : 0;

        // Efficiency
        $efficiency = ($total_input > 0) ? round(($total_approved / $total_input) * 100) : 0;

        return [
            'total_input' => $total_input,
            'total_approved' => $total_approved,
            'target' => $target,
            'efficiency' => $efficiency
        ];
    }

    public function getOptimizationStats()
    {
        $query = "SELECT
                        COUNT(o.optimization_id)                                     AS total_submissions,
                        ROUND(AVG(an.viability_score), 1)                            AS avg_ai_score,
                        COUNT(o.status = 3)   AS approved_plans,
                        ROUND(AVG(DATEDIFF(o.approved_at, o.created_at)), 0)  AS avg_lead_days
                    FROM t_cmp_optimization o
                    LEFT JOIN t_cmp_optimization_analysis an ON an.optimization_id = o.optimization_id";
        return $this->db->query($query)->row_array();
    }
}