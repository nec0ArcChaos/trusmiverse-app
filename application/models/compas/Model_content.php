<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_content extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_campaigns()
    {
        $this->db->where('content_status IS NOT NULL');
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
                  LEFT JOIN xin_employees emp ON FIND_IN_SET(CAST(emp.user_id AS CHAR), IFNULL(c.content_team, ''))
                  WHERE c.content_status IS NOT NULL
                  AND (c.campaign_start_date BETWEEN '$start' AND '$end' OR c.campaign_end_date BETWEEN '$start' AND '$end')
                  GROUP BY c.campaign_id";
        return $this->db->query($query)->result();
    }

    public function generate_content_id()
    {
        $q = $this->db->query("SELECT CONCAT('CT',DATE_FORMAT(NOW(), '%y%m%d'),LPAD(COALESCE(MAX(CAST(SUBSTRING(content_id, 8) AS UNSIGNED)), 0) + 1,3,'0')) AS new_id FROM t_cmp_content WHERE DATE(created_at) = CURDATE()")->row();
        $next_number = ($q->new_id !== null) ? $q->new_id : 'CT' . date('ymd') . '001';
        return $next_number;
    }

    public function get_approved_activations($campaign_id, $limit = 3, $start = 0)
    {
        $query = "SELECT
                    activation_id,
                    campaign_id,
                    title,
                    description,
                    period_start,
                    period_end,
                    pic,
                    budget,
                    content_produced,
                    GROUP_CONCAT(DISTINCT g.cg_name ORDER BY g.cg_name) AS cg_name,
                    GROUP_CONCAT(DISTINCT g.cg_desc ORDER BY g.cg_name) AS cg_desc,
                    platforms,
                    GROUP_CONCAT(DISTINCT p.platform_name) AS platform_name,
                    `status`,
                    CASE
                        WHEN MONTH(period_start) = MONTH(period_end) 
                        AND YEAR(period_start) = YEAR(period_end) THEN
                            CONCAT(DATE_FORMAT(period_start, '%b %d'), ' - ', DATE_FORMAT(period_end, '%d, %Y')) 
                        ELSE CONCAT(
                            DATE_FORMAT(period_start, '%b %d'),
                            ' - ',
                            DATE_FORMAT(period_end, '%b %d, %Y')) 
                        END AS activation_period
                    FROM
                    `t_cmp_activation` a
                    LEFT JOIN m_cmp_content_generated g ON FIND_IN_SET(g.cg_id, a.content_produced)
                    LEFT JOIN m_cmp_platform p ON FIND_IN_SET(p.platform_id, a.platforms) 
                    WHERE
                    a.`status` = 3 AND a.campaign_id = '$campaign_id'
                    GROUP BY
                    activation_id
                    LIMIT $limit OFFSET $start";
        return $this->db->query($query)->result_array();
    }

    public function count_approved_activations($campaign_id)
    {
        $query = "SELECT
                    COUNT(activation_id) AS total
                    FROM
                    `t_cmp_activation` a
                    WHERE
                    a.`status` = 3 AND a.campaign_id = '$campaign_id'";
        return $this->db->query($query)->row_array();
    }

    public function get_activation_by_id($id)
    {

        $query = "SELECT
                    activation_id,
                    campaign_id,
                    title,
                    description,
                    period_start,
                    period_end,
                    pic,
                    budget,
                    content_produced,
                    GROUP_CONCAT(DISTINCT g.cg_name ORDER BY g.cg_name) AS cg_name,
                    GROUP_CONCAT(DISTINCT g.cg_desc ORDER BY g.cg_name) AS cg_desc,
                    platforms,
                    GROUP_CONCAT(DISTINCT p.platform_name) AS platform_name,
                    `status`,
                    CASE
                        WHEN MONTH(period_start) = MONTH(period_end) 
                        AND YEAR(period_start) = YEAR(period_end) THEN
                            CONCAT(DATE_FORMAT(period_start, '%b %d'), ' - ', DATE_FORMAT(period_end, '%d, %Y')) 
                        ELSE CONCAT(
                            DATE_FORMAT(period_start, '%b %d'),
                            ' - ',
                            DATE_FORMAT(period_end, '%b %d, %Y')) 
                        END AS activation_period
                    FROM
                    `t_cmp_activation` a
                    LEFT JOIN m_cmp_content_generated g ON FIND_IN_SET(g.cg_id, a.content_produced)
                    LEFT JOIN m_cmp_platform p ON FIND_IN_SET(p.platform_id, a.platforms) 
                    WHERE
                    a.`status` = 3 AND a.activation_id = '$id'
                    GROUP BY
                    activation_id";
        return $this->db->query($query)->row_array();
    }

    public function get_content_team($campaign_id)
    {
        $query = "SELECT
                    c.campaign_id,
                    c.content_team,
                    COUNT(DISTINCT emp.user_id) AS jml_team,
                    GROUP_CONCAT(DISTINCT CONCAT(emp.first_name, ' ', emp.last_name) ORDER BY emp.first_name) AS team_name,
                    GROUP_CONCAT(COALESCE(emp.profile_picture,'') ORDER BY emp.first_name) AS profile_picture_team
                  FROM t_cmp_campaign c
                  LEFT JOIN xin_employees emp ON FIND_IN_SET(CAST(emp.user_id AS CHAR), CONVERT(
                            CONCAT_WS(',', c.content_team)
                            USING utf8mb4
                        )) 
                  WHERE c.campaign_id = '$campaign_id'
                  GROUP BY c.campaign_id";

        return $this->db->query($query)->result();
    }

    public function update_content_team($campaign_id, $team)
    {
        $this->db->where('campaign_id', $campaign_id);
        return $this->db->update('t_cmp_campaign', ['content_team' => $team]);
    }

    public function get_all_employees()
    {
        $this->db->select("user_id, CONCAT(first_name, ' ', last_name) as full_name");
        $this->db->from('xin_employees');
        $this->db->where('is_active', 1);
        $this->db->order_by('first_name', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_platforms_dropdown()
    {
        $this->db->select('platform_id, platform_name');
        $this->db->from('m_cmp_platform');
        $this->db->where('is_active', 1);
        return $this->db->get()->result_array();
    }

    public function get_placements_dropdown()
    {
        $this->db->select('placement_id, placement_name');
        $this->db->from('m_cmp_placement');
        $this->db->where('is_active', 1);
        return $this->db->get()->result_array();
    }

    public function get_activation_strategies_dropdown($campaign_id)
    {
        $this->db->select('activation_id, title');
        $this->db->from('t_cmp_activation');
        $this->db->where('campaign_id', $campaign_id);
        $this->db->where('status', '3'); // Approved status
        return $this->db->get()->result_array();
    }

    public function get_content_pillars_dropdown()
    {
        $this->db->select('cp_id, cp_name');
        $this->db->from('m_cmp_content_pillar');
        $this->db->where('is_active', 1);
        return $this->db->get()->result_array();
    }

    public function get_content_formats_dropdown()
    {
        $this->db->select('cf_id, cf_name');
        $this->db->from('m_cmp_content_format');
        $this->db->where('is_active', 1);
        return $this->db->get()->result_array();
    }

    public function get_talent_type_dropdown()
    {
        $this->db->select('talent_type_id, talent_type_name');
        $this->db->from('m_cmp_talent_type');
        $this->db->where('is_active', 1);
        return $this->db->get()->result_array();
    }

    public function save_content_plan($data)
    {
        $id = $this->generate_content_id();
        $data['content_id'] = $id;
        if ($this->db->insert('t_cmp_content', $data)) {
            return $id;
        }
        return false;
    }

    public function get_content_plan($campaign_id)
    {
        $query = "SELECT
                    d.content_id AS content_id,
                    d.campaign_id,
                    d.activation_id,
                    MAX(d.title) AS title,
                    DATE_FORMAT(d.deadline_publish, '%d %b %Y') AS deadline_publish,
                    GROUP_CONCAT(DISTINCT p.platform_name) AS platform_name,
                    GROUP_CONCAT(DISTINCT pp.placement_name) AS placement_name,
                    MAX(cp.cp_name) AS content_pillar_name,
                    MAX(cf.cf_name) AS format_name,
                    d.publish_date,
                    DATE_FORMAT(d.publish_date, '%d %b %Y') AS publish_date_fmt,
                    d.format,
                    MAX(ss.sub_status_name) AS sub_status_name,
                    COUNT(DISTINCT emp.user_id) AS jml_team,
                    GROUP_CONCAT(DISTINCT CONCAT(emp.first_name, ' ', emp.last_name) ORDER BY CONCAT(emp.first_name, ' ', emp.last_name)) AS team_name,
                    GROUP_CONCAT(DISTINCT emp.profile_picture ORDER BY CONCAT(emp.first_name, ' ', emp.last_name)) AS profile_picture_team,
                    d.talent_type,
                    ca.viability_score
                    FROM
                    `t_cmp_content` d
                    LEFT JOIN t_cmp_content_analysis ca ON ca.content_id = d.content_id
                    LEFT JOIN t_cmp_activation a ON a.activation_id = d.activation_id
                    LEFT JOIN m_cmp_platform p ON FIND_IN_SET(p.platform_id, d.platform)
                    LEFT JOIN m_cmp_placement pp ON FIND_IN_SET(pp.placement_id, d.placement_type)
                    LEFT JOIN m_cmp_content_pillar cp ON FIND_IN_SET(cp.cp_id, d.content_pillar)
                    LEFT JOIN m_cmp_content_format cf ON FIND_IN_SET(cf.cf_id, d.format)
                    LEFT JOIN m_cmp_sub_status ss ON ss.sub_status_id = d.`status`
                    LEFT JOIN xin_employees emp ON FIND_IN_SET(CAST(emp.user_id AS CHAR), CONVERT(
                                                CONCAT_WS(',', d.created_by, d.team_involved)
                                                USING utf8mb4
                                            ))
                    WHERE d.campaign_id = '$campaign_id'
                    GROUP BY
                    d.content_id, d.campaign_id, d.activation_id, d.deadline_publish, d.publish_date, d.format";
        return $this->db->query($query)->result_array();
    }

    public function get_content_detail($content_id)
    {
        $query = "SELECT
                    d.*,
                    d.content_id AS content_id,
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
                FROM
                    `t_cmp_content` d
                    LEFT JOIN t_cmp_activation a ON a.activation_id = d.activation_id
                    LEFT JOIN t_cmp_campaign c ON c.campaign_id = d.campaign_id
                    LEFT JOIN m_cmp_platform p ON FIND_IN_SET(p.platform_id, d.platform)
                    LEFT JOIN m_cmp_placement pp ON FIND_IN_SET(pp.placement_id, d.placement_type)
                    LEFT JOIN m_cmp_content_pillar cp ON FIND_IN_SET(cp.cp_id, d.content_pillar)
                    LEFT JOIN m_cmp_content_format cf ON FIND_IN_SET(cf.cf_id, d.format)
                    LEFT JOIN m_cmp_talent_type tt ON FIND_IN_SET(tt.talent_type_id, d.talent_type)
                    LEFT JOIN m_cmp_sub_status ss ON ss.sub_status_id = d.`status`
                    LEFT JOIN xin_employees e ON FIND_IN_SET(CAST(e.user_id AS CHAR), CONVERT(
                                                CONCAT_WS(',', d.created_by, d.team_involved)
                                                USING utf8mb4
                                            ))
                WHERE
                    d.content_id = '$content_id'
                GROUP BY
                    d.content_id";
        return $this->db->query($query)->row_array();
    }
    public function getContentsBySubStatus($campaign_id, $status)
    {
        $query = "SELECT a.content_id, a.status
        FROM t_cmp_content a
        WHERE a.campaign_id = '$campaign_id'
        AND a.status = '$status'";
        return $this->db->query($query)->result_array();
    }
    public function approve_content_plan($id)
    {
        $this->db->where('content_id', $id);
        return $this->db->update('t_cmp_content', ['status' => 3, 'approved_at' => date('Y-m-d H:i:s')]);
    }

    public function cancel_approve_plan($id)
    {
        $this->db->where('content_id', $id);
        return $this->db->update('t_cmp_content', ['status' => 1, 'approved_at' => null]);
    }

    public function reject_plan($id, $status)
    {
        $this->db->where('content_id', $id);
        return $this->db->update('t_cmp_content', ['status' => $status]);
    }

    public function get_activity_logs($content_id)
    {
        $this->db->select('l.*, CONCAT(e.first_name, " ", e.last_name) as user_name, e.profile_picture');
        $this->db->from('t_cmp_activity_logs l');
        $this->db->join('xin_employees e', 'e.user_id = l.user_id', 'left');
        $this->db->where('l.phase_id', $content_id);
        $this->db->where('l.phase', 'content');
        $this->db->order_by('l.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_content_logs($campaign_id)
    {
        $this->db->select('l.*, CONCAT(e.first_name, " ", e.last_name) as user_name, e.profile_picture');
        $this->db->from('t_cmp_activity_logs l');
        $this->db->join('xin_employees e', 'e.user_id = l.user_id', 'left');
        $this->db->where('l.campaign_id', $campaign_id);
        $this->db->where('l.phase', 'content');
        $this->db->order_by('l.created_at', 'DESC');
        $this->db->limit(10); // Limit logs to recent ones
        return $this->db->get()->result_array();
    }

    public function update_content_plan($id, $data)
    {
        $this->db->where('content_id', $id);
        return $this->db->update('t_cmp_content', $data);
    }

    public function delete_content_plan($id)
    {
        $this->db->where('content_id', $id);
        return $this->db->delete('t_cmp_content');
    }

    public function get_content_performance_stats($campaign_id)
    {
        // 1. Total Input (All content for this campaign)
        $this->db->where('campaign_id', $campaign_id);
        $total_input = $this->db->count_all_results('t_cmp_content');

        // 2. Total Approved (Status = 3)
        $this->db->where('campaign_id', $campaign_id);
        $this->db->where('status', 3);
        $total_approved = $this->db->count_all_results('t_cmp_content');

        // 3. Content Target from Campaign (Assuming same target field or separate?)
        // Let's check campaign table for a potential field, or use distribution_target if shared
        $this->db->select('content_target');
        $this->db->where('campaign_id', $campaign_id);
        $campaign = $this->db->get('t_cmp_campaign')->row_array();
        $target = $campaign ? (int) $campaign['content_target'] : 0;

        // 4. Efficiency
        $efficiency = ($total_input > 0) ? round(($total_approved / $total_input) * 100) : 0;

        return [
            'total_input' => $total_input,
            'total_approved' => $total_approved,
            'target' => $target,
            'efficiency' => $efficiency
        ];
    }

    public function save_content_analysis($data)
    {
        $exists = $this->db->where('content_id', $data['content_id'])->count_all_results('t_cmp_content_analysis');
        if ($exists) {
            $this->db->where('content_id', $data['content_id']);
            return $this->db->update('t_cmp_content_analysis', $data);
        } else {
            return $this->db->insert('t_cmp_content_analysis', $data);
        }
    }

    public function get_content_analysis($content_id)
    {
        $this->db->where('content_id', $content_id);
        return $this->db->get('t_cmp_content_analysis')->row_array();
    }

    public function get_content_analysis_data($content_id)
    {
        $this->db->select("
            con.activation_id,
            c.campaign_name,
            c.campaign_desc,
            c.target_audience,
            c.key_message,
            a.title as strategy_title,
            a.description as strategy_desc,
            con.title as content_title,
            con.script_content,
            con.storyboard,
            con.audio_notes,
            con.talent_persona,
            con.pain_point,
            con.trigger_emotion,
            con.consumption_behavior,
            con.hook,
            con.publish_date,
            GROUP_CONCAT(DISTINCT p.platform_name SEPARATOR ' & ') as platform,
            GROUP_CONCAT(DISTINCT pl.placement_name SEPARATOR ', ') as placement_type
        ");
        $this->db->from('t_cmp_content con');
        $this->db->join('t_cmp_campaign c', 'c.campaign_id = con.campaign_id');
        $this->db->join('t_cmp_activation a', 'a.activation_id = con.activation_id', 'left');
        $this->db->join('m_cmp_platform p', 'FIND_IN_SET(p.platform_id, con.platform)', 'left');
        $this->db->join('m_cmp_placement pl', 'FIND_IN_SET(pl.placement_id, con.placement_type)', 'left');
        $this->db->where('con.content_id', $content_id);
        $this->db->group_by('con.content_id');

        $query = $this->db->get();
        return $query->row_array();
    }

    public function getContentStats()
    {
        $query = "SELECT
                    COUNT(c.content_id)                                          AS total_submissions,
                    ROUND(AVG(an.analysis_json->>'$.output.skor_keseluruhan.nilai'), 1)                              AS avg_ai_score,
                    COUNT(c.status = 3)   AS approved_plans,
                    ROUND(AVG(DATEDIFF(c.approved_at, c.created_at)), 0)  AS avg_lead_days
                  FROM t_cmp_content c
                  LEFT JOIN t_cmp_content_analysis an ON an.content_id = c.content_id";
        return $this->db->query($query)->row_array();
    }
}