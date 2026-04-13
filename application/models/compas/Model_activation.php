<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_activation extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getCampaigns($start = null, $end = null)
    {
        $query = "SELECT 
                    c.*,
                    b.brand_name,
                    COUNT(DISTINCT emp.user_id) AS team_count,
                    GROUP_CONCAT(DISTINCT CONCAT(emp.first_name, ' ', emp.last_name) ORDER BY emp.first_name SEPARATOR ', ') AS team_names,
                    GROUP_CONCAT(COALESCE(emp.profile_picture, '') ORDER BY emp.first_name SEPARATOR ',') AS team_pictures
                  FROM t_cmp_campaign c
                  LEFT JOIN m_cmp_brand b ON b.brand_id = c.brand_id
                  LEFT JOIN xin_employees emp ON FIND_IN_SET(CAST(emp.user_id AS CHAR), IFNULL(c.activation_team, ''))
                  WHERE c.activation_status IS NOT NULL
                  GROUP BY c.campaign_id";
        return $this->db->query($query)->result();
    }

    public function get_campaigns_by_date($start, $end)
    {
        $query = "SELECT 
                    c.*,
                    b.brand_name,
                    COUNT(DISTINCT emp.user_id) AS team_count,
                    GROUP_CONCAT(DISTINCT CONCAT(emp.first_name, ' ', emp.last_name) ORDER BY emp.first_name SEPARATOR ', ') AS team_names,
                    GROUP_CONCAT(COALESCE(emp.profile_picture, '') ORDER BY emp.first_name SEPARATOR ',') AS team_pictures,
                    COUNT(DISTINCT com.id) AS comment_count,
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
                  LEFT JOIN xin_employees emp ON FIND_IN_SET(CAST(emp.user_id AS CHAR), IFNULL(c.activation_team, ''))
                  LEFT JOIN t_cmp_comments com ON com.campaign_id = c.campaign_id AND com.phase = 'activation'
                  WHERE c.activation_status IS NOT NULL
                  AND (c.campaign_start_date BETWEEN '$start' AND '$end' OR c.campaign_end_date BETWEEN '$start' AND '$end')
                  GROUP BY c.campaign_id";
        return $this->db->query($query)->result();
    }

    public function getCampaign($campaign_id)
    {
        $query = "SELECT
                    c.*,
                    CONCAT(emp.first_name, ' ', emp.last_name) AS created_by_name,
                    COUNT(ct.content_id) AS jml_content_approved,
                    GROUP_CONCAT(DISTINCT cp.cp_name ORDER BY cp.cp_name SEPARATOR ', ') AS content_pillars,
                    GROUP_CONCAT(DISTINCT o.objective_name ORDER BY o.objective_name SEPARATOR ', ') AS objectives,
                    GROUP_CONCAT(DISTINCT cg.cg_name ORDER BY cg.cg_name SEPARATOR ', ') AS content_generated,
                    GROUP_CONCAT(DISTINCT cf.cf_name ORDER BY cf.cf_name SEPARATOR ', ') AS content_formats,
                    CASE
                        WHEN MONTH(campaign_start_date) = MONTH(campaign_end_date) 
                        AND YEAR(campaign_start_date) = YEAR(campaign_end_date) THEN
                            CONCAT(DATE_FORMAT(campaign_start_date, '%b %d'), ' - ', DATE_FORMAT(campaign_end_date, '%d, %Y')) 
                        ELSE CONCAT(
                            DATE_FORMAT(campaign_start_date, '%b %d'),
                            ' - ',
                            DATE_FORMAT(campaign_end_date, '%b %d, %Y')) 
                        END AS campaign_period
                    FROM
                    t_cmp_campaign c
                    LEFT JOIN xin_employees emp ON emp.user_id = c.created_by
                    LEFT JOIN t_cmp_content ct ON ct.campaign_id = c.campaign_id 
                    AND ct.`status` = 3
                    LEFT JOIN m_cmp_brand b ON b.brand_id = c.brand_id
                    LEFT JOIN m_cmp_content_pillar cp ON FIND_IN_SET(cp.cp_id, c.cp_id)
                    LEFT JOIN m_cmp_objective o ON FIND_IN_SET(o.objective_id, c.objective_id)
                    LEFT JOIN m_cmp_content_generated cg ON FIND_IN_SET(cg.cg_id, c.cg_id)
                    LEFT JOIN m_cmp_content_format cf ON FIND_IN_SET(cf.cf_id, c.cf_id)
                    WHERE
                    c.campaign_id = '$campaign_id'
                    GROUP BY c.campaign_id";
        return $this->db->query($query)->row();
    }

    public function getActivations($campaign_id)
    {
        $query = "SELECT a.title, a.target_audience target_audience_activation, 
        a.description, a.budget, a.status, a.activation_id,
        GROUP_CONCAT(DISTINCT e.user_id ORDER BY e.user_id) AS pic_ids, 
        GROUP_CONCAT(DISTINCT CONCAT(e.first_name, ' ', e.last_name) ORDER BY e.user_id) AS pic_names,
        GROUP_CONCAT(DISTINCT e.profile_picture ORDER BY e.user_id) AS pic_pictures,
        GROUP_CONCAT(DISTINCT p.platform_name ORDER BY p.platform_id) AS platform_names,
        GROUP_CONCAT(DISTINCT cg.cg_name ORDER BY cg.cg_id) AS cg_names,
        a.progress,
        aa.overall_score
        FROM t_cmp_activation a
        LEFT JOIN t_cmp_activation_analysis aa ON aa.activation_id = a.activation_id
        LEFT JOIN xin_employees e 
        ON FIND_IN_SET(e.user_id,a.pic) 
        LEFT JOIN m_cmp_platform p 
        ON FIND_IN_SET(p.platform_id,a.platforms)
        LEFT JOIN m_cmp_content_generated cg 
        ON FIND_IN_SET(cg.cg_id,a.content_produced)
        WHERE a.campaign_id = '$campaign_id'
        GROUP BY activation_id";
        return $this->db->query($query)->result_array();
    }

    public function getActivationsCount($campaign_id)
    {
        $query = "SELECT a.activation_id
        FROM t_cmp_activation a 
        WHERE a.campaign_id = '$campaign_id'";
        return $this->db->query($query)->num_rows();
    }

    public function getActivationsBySubStatus($campaign_id, $status)
    {
        $query = "SELECT a.activation_id, a.status
        FROM t_cmp_activation a
        WHERE a.campaign_id = '$campaign_id'
        AND a.status = '$status'";
        return $this->db->query($query)->result_array();
    }

    public function update_campaign($campaign_id, $data)
    {
        $this->db->where('campaign_id', $campaign_id);
        return $this->db->update('t_cmp_campaign', $data);
    }

    public function generate_activation_id()
    {
        $q = $this->db->query("SELECT CONCAT('A',DATE_FORMAT(NOW(), '%y%m%d'),LPAD(COALESCE(MAX(CAST(SUBSTRING(activation_id, 8) AS UNSIGNED)), 0) + 1,3,'0')) AS new_id FROM t_cmp_activation WHERE DATE(created_at) = CURDATE()")->row();
        $next_number = ($q->new_id !== null) ? $q->new_id : 'A' . date('ymd') . '001';
        return $next_number;
    }

    public function insert_activation($data)
    {
        $id = $this->generate_activation_id();
        $data['activation_id'] = $id;
        if ($this->db->insert('t_cmp_activation', $data)) {
            return $id;
        }
        return false;
    }

    public function update_activation($activation_id, $data)
    {
        $this->db->where('activation_id', $activation_id);
        return $this->db->update('t_cmp_activation', $data);
    }

    public function getPics($campaign_id)
    {
        $query = "SELECT user_id pic_id, CONCAT(first_name, ' ', last_name) pic_name 
        FROM t_cmp_campaign c 
        LEFT JOIN xin_employees e 
        ON FIND_IN_SET(e.user_id,activation_team) 
        WHERE campaign_id = '$campaign_id'";
        return $this->db->query($query)->result();
    }

    public function getPlatforms($brand_id)
    {
        $this->db->select('platform_id, platform_name');
        $this->db->where('brand_id', $brand_id);
        $query = $this->db->get('m_cmp_platform');
        return $query->result();
    }

    public function getActivationStats()
    {
        $query = "SELECT
                    COUNT(a.activation_id)                                          AS total_submissions,
                    ROUND(AVG(DATEDIFF(a.approved_at, a.created_at)))              AS avg_sla_days,
                    ROUND(AVG(an.overall_score))                                    AS avg_ai_score,
                    COUNT(a.status = 3)         AS approved_plans
                  FROM t_cmp_activation a
                  LEFT JOIN t_cmp_activation_analysis an ON an.activation_id = a.activation_id";
        return $this->db->query($query)->row_array();
    }

    public function getActivation($activation_id)
    {
        $query = "SELECT a.*, 
        GROUP_CONCAT(DISTINCT e.user_id ORDER BY e.user_id ASC) AS pic_ids, 
        GROUP_CONCAT(DISTINCT CONCAT(e.first_name, ' ', e.last_name) ORDER BY e.user_id ASC) AS pic_names,
        GROUP_CONCAT(DISTINCT e.profile_picture ORDER BY e.user_id ASC) AS pic_pictures,
        GROUP_CONCAT(DISTINCT p.platform_name ORDER BY p.platform_id ASC SEPARATOR ', ') AS platform_names,
        GROUP_CONCAT(DISTINCT cg.cg_name ORDER BY cg.cg_id ASC SEPARATOR ', ') AS content_produced_names,
        emp_created.first_name as created_by_first_name, emp_created.last_name as created_by_last_name
        FROM t_cmp_activation a 
        LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id, a.pic) > 0
        LEFT JOIN xin_employees emp_created ON a.created_by = emp_created.user_id
        LEFT JOIN m_cmp_platform p ON FIND_IN_SET(p.platform_id, a.platforms) > 0
        LEFT JOIN m_cmp_content_generated cg ON FIND_IN_SET(cg.cg_id, a.content_produced) > 0
        WHERE a.activation_id = '$activation_id'
        GROUP BY a.activation_id";

        return $this->db->query($query)->row_array();
    }

    public function getActivationForAnalysis($activation_id)
    {
        $query = "SELECT a.campaign_id, a.title, a.target_audience target_audience_activation, 
        a.description running_activation, a.budget, a.activation_id, a.status,
        GROUP_CONCAT(DISTINCT p.platform_name ORDER BY p.platform_id) AS platform_names,
        GROUP_CONCAT(DISTINCT cg.cg_name ORDER BY cg.cg_id) AS cg_names
        FROM t_cmp_activation a 
        LEFT JOIN m_cmp_platform p 
        ON FIND_IN_SET(p.platform_id,a.platforms)
        LEFT JOIN m_cmp_content_generated cg 
        ON FIND_IN_SET(cg.cg_id,a.content_produced)
        WHERE a.activation_id = '$activation_id'
        GROUP BY activation_id";
        return $this->db->query($query)->row_array();
    }

    public function save_activation_analysis($data)
    {
        // Check if analysis already exists for this activation
        $this->db->where('activation_id', $data['activation_id']);
        $query = $this->db->get('t_cmp_activation_analysis');

        if ($query->num_rows() > 0) {
            // Update existing record
            $this->db->where('activation_id', $data['activation_id']);
            $this->db->update('t_cmp_activation_analysis', $data);
        } else {
            // Insert new record
            $this->db->insert('t_cmp_activation_analysis', $data);
        }

        // Always insert into history
        $history_data = $data;
        if (isset($history_data['id'])) {
            unset($history_data['id']);
        }
        $this->db->insert('t_cmp_activation_analysis_history', $history_data);
    }

    public function getAnalysis($activation_id)
    {
        $this->db->where('activation_id', $activation_id);
        return $this->db->get('t_cmp_activation_analysis')->row_array();
    }

    public function log_activity($data)
    {
        return $this->db->insert('t_cmp_activity_logs', $data);
    }

    public function get_activity_log($activation_id)
    {
        $this->db->select('l.*, CONCAT(e.first_name, " ", e.last_name) as user_name, e.profile_picture');
        $this->db->from('t_cmp_activity_logs l');
        $this->db->join('xin_employees e', 'l.user_id = e.user_id', 'left');
        $this->db->where('l.phase_id', $activation_id);
        $this->db->where('l.phase', 'activation');
        $this->db->order_by('l.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_all_activity_logs($limit = 10)
    {
        $this->db->select('l.*, CONCAT(e.first_name, " ", e.last_name) as user_name, e.profile_picture, a.title as activation_title');
        $this->db->from('t_cmp_activity_logs l');
        $this->db->join('xin_employees e', 'l.user_id = e.user_id', 'left');
        $this->db->join('t_cmp_activation a', 'l.phase_id = a.activation_id', 'left');
        $this->db->where('l.phase', 'activation');
        $this->db->order_by('l.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function get_activation_team($campaign_id)
    {
        $query = "SELECT
                    c.campaign_id,
                    c.activation_team,
                    COUNT(DISTINCT emp.user_id) AS jml_team,
                    GROUP_CONCAT(DISTINCT CONCAT(emp.first_name, ' ', emp.last_name) ORDER BY emp.first_name) AS team_name,
                    GROUP_CONCAT(COALESCE(emp.profile_picture,'') ORDER BY emp.first_name) AS profile_picture_team
                  FROM t_cmp_campaign c
                  LEFT JOIN xin_employees emp ON FIND_IN_SET(CAST(emp.user_id AS CHAR), CONVERT(
                            CONCAT_WS(',', c.activation_team)
                            USING utf8mb4
                        )) 
                  WHERE c.campaign_id = '$campaign_id'
                  GROUP BY c.campaign_id";

        return $this->db->query($query)->result();
    }

    public function update_activation_team($campaign_id, $team)
    {
        $this->db->where('campaign_id', $campaign_id);
        return $this->db->update('t_cmp_campaign', ['activation_team' => $team]);
    }

    public function get_all_employees()
    {
        $this->db->select("user_id, CONCAT(first_name, ' ', last_name) as full_name");
        $this->db->from('xin_employees');
        $this->db->where('is_active', 1);
        $this->db->order_by('first_name', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_activation_performance_stats($campaign_id)
    {
        // 1. Total Input (All activations for this campaign)
        $this->db->where('campaign_id', $campaign_id);
        $total_input = $this->db->count_all_results('t_cmp_activation');

        // 2. Total Approved/Done (Status >= 2)
        $this->db->where('campaign_id', $campaign_id);
        $this->db->where('status >=', 2);
        $total_approved = $this->db->count_all_results('t_cmp_activation');

        // 3. Activation Target from Campaign
        $this->db->select('activation_target');
        $this->db->where('campaign_id', $campaign_id);
        $campaign = $this->db->get('t_cmp_campaign')->row_array();
        $target = $campaign ? (int) $campaign['activation_target'] : 0;

        // 4. Efficiency
        $efficiency = ($total_input > 0) ? round(($total_approved / $total_input) * 100) : 0;

        return [
            'total_input' => $total_input,
            'total_approved' => $total_approved,
            'target' => $target,
            'efficiency' => $efficiency
        ];
    }

    public function approve_activation($id)
    {
        $this->db->where('activation_id', $id);
        return $this->db->update('t_cmp_activation', ['status' => 3, 'approved_at' => date('Y-m-d H:i:s')]);
    }

    public function cancel_approve_activation($id)
    {
        $this->db->where('activation_id', $id);
        return $this->db->update('t_cmp_activation', ['status' => 1, 'approved_at' => null]);
    }

    public function reject_activation($id, $status)
    {
        $this->db->where('activation_id', $id);
        return $this->db->update('t_cmp_activation', ['status' => $status]);
    }

    // public function getActivationStats($campaign_id)
    // {
    //     $query = "SELECT
    //                 COUNT(a.activation_id)                                          AS total_submissions,
    //                 ROUND(AVG(DATEDIFF(a.period_end, a.period_start)), 0)           AS avg_sla_days,
    //                 ROUND(AVG(an.overall_score), 1)                                 AS avg_ai_score,
    //                 SUM(CASE WHEN an.overall_score >= 70 THEN 1 ELSE 0 END)         AS approved_plans
    //               FROM t_cmp_activation a
    //               LEFT JOIN t_cmp_activation_analysis an ON an.activation_id = a.activation_id
    //               WHERE a.campaign_id = '$campaign_id'";
    //     return $this->db->query($query)->row_array();
    // }
}