<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_campaign extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function generate_campaign_id()
    {
        $q = $this->db->query("SELECT CONCAT('C',DATE_FORMAT(NOW(), '%y%m%d'),LPAD(COALESCE(MAX(CAST(SUBSTRING(campaign_id, 8) AS UNSIGNED)), 0) + 1,3,'0')) AS new_id FROM t_cmp_campaign WHERE DATE(created_at) = CURDATE()")->row();
        $next_number = ($q->new_id !== null) ? $q->new_id : 'C' . date('ymd') . '001';
        return $next_number;
    }

    public function insert_campaign($data)
    {
        $data['campaign_id'] = $this->generate_campaign_id();
        return $this->db->insert('t_cmp_campaign', $data);
    }

    public function get_campaign($start_date, $end_date, $status_id)
    {
        $query = "SELECT
                    c.campaign_id,
                    b.brand_name,
                    c.campaign_name,
                    c.campaign_desc,
                    c.campaign_start_date,
                    c.campaign_end_date,
                    c.campaign_status AS status_id,
                    s.status_name,
                    CASE
                        WHEN NOW() > DATE_ADD(c.created_at, INTERVAL 7 DAY)
                            THEN 'Late'
                        WHEN DATEDIFF(
                                DATE_ADD(c.created_at, INTERVAL 7 DAY),
                                NOW()
                            ) <= 2
                            THEN 'At Risk'
                        ELSE 'On Track'
                    END AS status_leadtime,
                    c.created_at,
                    CONCAT(
                        DATE_FORMAT(c.created_at, '%l:%i %p'),
                        ' | ',
                        CASE
                            WHEN TIMESTAMPDIFF(MINUTE, c.created_at, NOW()) < 60 THEN
                                CONCAT(TIMESTAMPDIFF(MINUTE, c.created_at, NOW()), ' mins')
                            WHEN TIMESTAMPDIFF(HOUR, c.created_at, NOW()) < 24 THEN
                                CONCAT(TIMESTAMPDIFF(HOUR, c.created_at, NOW()), ' hrs')
                            ELSE
                                CONCAT(TIMESTAMPDIFF(DAY, c.created_at, NOW()), ' days')
                        END) AS time_display,
                    CASE
                        WHEN MONTH(campaign_start_date) = MONTH(campaign_end_date) 
                        AND YEAR(campaign_start_date) = YEAR(campaign_end_date) THEN
                            CONCAT(DAY(campaign_start_date), '-', DAY(campaign_end_date), ' ', DATE_FORMAT(campaign_start_date, '%M %Y')) 
                        ELSE CONCAT(
                            DAY(campaign_start_date),   
                            ' ',
                            DATE_FORMAT(campaign_start_date, '%b'),
                            ' - ',
                            DAY(campaign_end_date),
                            ' ',
                            DATE_FORMAT(campaign_end_date, '%b %Y')) 
                        END AS campaign_period,
                    CONCAT(e.first_name, ' ', e.last_name) AS author,
                    c.content_angle,
                    GROUP_CONCAT(DISTINCT cp.cp_name ORDER BY cp.cp_name) AS content_pilar,
                    GROUP_CONCAT(DISTINCT o.objective_name ORDER BY o.objective_name) AS objective,
                    GROUP_CONCAT(DISTINCT cg.cg_name ORDER BY cg.cg_name) AS content_generated,
                    COUNT(DISTINCT emp.user_id) AS jml_team,
                    GROUP_CONCAT(DISTINCT CONCAT(emp.first_name, ' ', emp.last_name) ORDER BY emp.first_name) AS team_name,
                    GROUP_CONCAT(DISTINCT emp.profile_picture ORDER BY emp.first_name) AS profile_picture_team,
                    COALESCE(c.activation_target,0) AS activation_target,
                    COALESCE(c.activation_actual,0) AS activation_actual,
                    COALESCE(c.content_target,0) AS content_target,
                    COALESCE(c.content_actual,0) AS content_actual,
                    COALESCE(c.distribution_target,0) AS distribution_target,
                    COALESCE(c.distribution_actual,0) AS distribution_actual,
                    COALESCE(c.optimization_target,0) AS optimization_target,
                    COALESCE(c.optimization_actual,0) AS optimization_actual
                    FROM
                    t_cmp_campaign c
                    LEFT JOIN m_cmp_status s ON s.status_id = c.campaign_status
                    LEFT JOIN m_cmp_brand b ON b.brand_id = c.brand_id
                    LEFT JOIN xin_employees e ON e.user_id = c.created_by
                    LEFT JOIN m_cmp_content_pillar cp ON FIND_IN_SET(cp.cp_id, c.cp_id)
                    LEFT JOIN m_cmp_objective o ON FIND_IN_SET(o.objective_id, c.objective_id)
                    LEFT JOIN m_cmp_content_generated cg ON FIND_IN_SET(cg.cg_id, c.cg_id)
                    LEFT JOIN xin_employees emp ON FIND_IN_SET(CAST(emp.user_id AS CHAR), CONVERT(
                            CONCAT_WS(',', c.activation_team, c.content_team, c.talent_team, c.optimization_team)
                            USING utf8mb4
                        )) 
                    WHERE c.campaign_id != 'C260211001' AND DATE(c.created_at) BETWEEN '$start_date' AND '$end_date'";

        if ($status_id === 'archive') {
            $query .= " AND c.campaign_status > 3";
        } else {
            $query .= " AND c.campaign_status = '$status_id'";
        }

        $query .= " GROUP BY
                    c.campaign_id";
        return $this->db->query($query)->result();
    }

    public function get_employees($brand_id = null)
    {
        $company_id = '';
        if ($brand_id) {
            $brand = $this->get_brands($brand_id);
            $company_id = $brand[0]->company_id;
        }
        $this->db->select('user_id, CONCAT(first_name, " ", last_name, " - ", xin_designations.designation_name) AS employee_name');
        $this->db->from('xin_employees');
        $this->db->join('xin_designations', 'xin_employees.designation_id = xin_designations.designation_id', 'left');
        $this->db->where('is_active', 1);
        if ($company_id) {
            $this->db->where("xin_employees.company_id IN ($company_id)");
        }
        $this->db->order_by('employee_name', 'ASC');
        return $this->db->get()->result();
    }

    public function get_brands($brand_id = null)
    {
        $this->db->select('m_cmp_brand.brand_id, m_cmp_brand.brand_name, m_cmp_brand.brand_desc, m_cmp_brand.company_id, GROUP_CONCAT(xin_companies.name) AS company_name, m_cmp_brand.is_active');
        $this->db->from('m_cmp_brand');
        $this->db->join('xin_companies', 'FIND_IN_SET(xin_companies.company_id, m_cmp_brand.company_id)', 'left');
        if ($brand_id) {
            $this->db->where("m_cmp_brand.brand_id = '$brand_id'");
        }
        $this->db->group_by('m_cmp_brand.brand_id');
        $this->db->order_by('m_cmp_brand.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_content_pillars($brand_id)
    {
        $this->db->select('m_cmp_content_pillar.cp_id, m_cmp_content_pillar.cp_name, m_cmp_content_pillar.cp_desc');
        $this->db->from('m_cmp_content_pillar');
        if ($brand_id) {
            $this->db->where("FIND_IN_SET('$brand_id', m_cmp_content_pillar.brand_id) >", 0);
        }
        $this->db->where('m_cmp_content_pillar.is_active', 1);
        $this->db->order_by('m_cmp_content_pillar.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_generated_contents($brand_id)
    {
        $this->db->select('m_cmp_content_generated.cg_id, m_cmp_content_generated.cg_name, m_cmp_content_generated.cg_desc');
        $this->db->from('m_cmp_content_generated');
        if ($brand_id) {
            $this->db->where("FIND_IN_SET('$brand_id', m_cmp_content_generated.brand_id) >", 0);
        }
        $this->db->where('m_cmp_content_generated.is_active', 1);
        $this->db->order_by('m_cmp_content_generated.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_content_formats($brand_id)
    {
        $this->db->select('m_cmp_content_format.cf_id, m_cmp_content_format.cf_name, m_cmp_content_format.cf_desc');
        $this->db->from('m_cmp_content_format');
        if ($brand_id) {
            $this->db->where("FIND_IN_SET('$brand_id', m_cmp_content_format.brand_id) >", 0);
        }
        $this->db->where('m_cmp_content_format.is_active', 1);
        $this->db->order_by('m_cmp_content_format.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_objectives($brand_id)
    {
        $this->db->select('m_cmp_objective.objective_id, m_cmp_objective.objective_name, m_cmp_objective.objective_desc');
        $this->db->from('m_cmp_objective');
        if ($brand_id) {
            $this->db->where("FIND_IN_SET('$brand_id', m_cmp_objective.brand_id) >", 0);
        }
        $this->db->where('m_cmp_objective.is_active', 1);
        $this->db->order_by('m_cmp_objective.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_campaign_by_id($campaign_id)
    {
        $query = "SELECT
                    c.*,
                    s.status_id AS campaign_status_id,
                    s.status_name AS campaign_status,
                    b.brand_name,
                    b.brand_desc,
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
                  FROM t_cmp_campaign c
                  LEFT JOIN m_cmp_status s ON s.status_id = c.campaign_status
                  LEFT JOIN m_cmp_brand b ON b.brand_id = c.brand_id
                  LEFT JOIN m_cmp_content_pillar cp ON FIND_IN_SET(cp.cp_id, c.cp_id)
                  LEFT JOIN m_cmp_objective o ON FIND_IN_SET(o.objective_id, c.objective_id)
                  LEFT JOIN m_cmp_content_generated cg ON FIND_IN_SET(cg.cg_id, c.cg_id)
                  LEFT JOIN m_cmp_content_format cf ON FIND_IN_SET(cf.cf_id, c.cf_id)
                  WHERE c.campaign_id = '$campaign_id'
                  GROUP BY c.campaign_id";

        return $this->db->query($query)->row();
    }

    public function save_swot_analysis($data)
    {
        // Jika proses berat di sini > 20 detik...
        $this->db->close();       // Tutup koneksi yang sudah timeout
        $this->db->initialize();  // Buka koneksi baru dengan konfigurasi yang sama

        $campaign_id = $data['campaign_id'];

        // Check if analysis exists
        // $this->db->where('campaign_id', $campaign_id);
        // $query = $this->db->get('t_cmp_campaign_analysis');
        $query = "SELECT * FROM t_cmp_campaign_analysis WHERE campaign_id = '$campaign_id'";
        $existing = $this->db->query($query)->row_array();

        if ($existing) {
            // Move to history
            $this->db->insert('t_cmp_campaign_analysis_history', $existing);

            // Delete from main table
            $this->db->where('id', $existing['id']);
            $this->db->delete('t_cmp_campaign_analysis');
        }

        // Generate ID (using microtime to ensure uniqueness as bigint)
        $data['id'] = (int) (microtime(true) * 10000);

        return $this->db->insert('t_cmp_campaign_analysis', $data);
    }

    public function get_swot_analysis($campaign_id)
    {
        $this->db->where('campaign_id', $campaign_id);
        return $this->db->get('t_cmp_campaign_analysis')->row_array();
    }

    public function update_campaign($campaign_id, $data)
    {
        $this->db->where('campaign_id', $campaign_id);
        return $this->db->update('t_cmp_campaign', $data);
    }

    public function getCampaignStats()
    {

        $query = "SELECT
                    COUNT(a.campaign_id)                                          AS total_submissions,
                    ROUND(AVG(DATEDIFF(a.campaign_approved_at, a.created_at)))              AS avg_sla_days,
                    ROUND(AVG(an.overall_score))                                    AS avg_ai_score,
                    SUM(CASE WHEN a.campaign_approved_at IS NOT NULL THEN 1 ELSE 0 END)         AS approved_plans
                  FROM t_cmp_campaign a
                  LEFT JOIN t_cmp_campaign_analysis an ON an.campaign_id = a.campaign_id";
        return $this->db->query($query)->row_array();
    }

    public function get_campaign_statuses($campaign_id)
    {
        $query = "SELECT a.campaign_id, campaign_status,
                    activation_status,
                    content_status,
                    talent_status,
                    distribution_status,
                    optimization_status
                FROM t_cmp_campaign a
                WHERE a.campaign_id = '$campaign_id'";
        return $this->db->query($query)->row_array();
    }

    public function get_all_campaigns_list($start_date, $end_date, $search = '')
    {
        $search_escaped = $this->db->escape_like_str($search);
        $query = "SELECT
                    c.campaign_id,
                    c.campaign_name,
                    c.campaign_desc,
                    c.campaign_status,
                    c.campaign_start_date,
                    c.campaign_end_date,
                    c.created_at,
                    b.brand_name,
                    CASE
                        WHEN NOW() > DATE_ADD(c.created_at, INTERVAL 7 DAY) THEN 'Late'
                        WHEN DATEDIFF(DATE_ADD(c.created_at, INTERVAL 7 DAY), NOW()) <= 2 THEN 'At Risk'
                        ELSE 'On Track'
                    END AS status_leadtime,
                    CONCAT(DATE_FORMAT(c.created_at,'%l:%i %p'),' | ',
                        CASE
                            WHEN TIMESTAMPDIFF(MINUTE,c.created_at,NOW()) < 60 THEN CONCAT(TIMESTAMPDIFF(MINUTE,c.created_at,NOW()),' mins')
                            WHEN TIMESTAMPDIFF(HOUR,c.created_at,NOW()) < 24 THEN CONCAT(TIMESTAMPDIFF(HOUR,c.created_at,NOW()),' hrs')
                            ELSE CONCAT(TIMESTAMPDIFF(DAY,c.created_at,NOW()),' days')
                        END) AS time_display,
                    CASE
                        WHEN MONTH(c.campaign_start_date)=MONTH(c.campaign_end_date) AND YEAR(c.campaign_start_date)=YEAR(c.campaign_end_date)
                            THEN CONCAT(DAY(c.campaign_start_date),'-',DAY(c.campaign_end_date),' ',DATE_FORMAT(c.campaign_start_date,'%M %Y'))
                        ELSE CONCAT(DAY(c.campaign_start_date),' ',DATE_FORMAT(c.campaign_start_date,'%b'),' - ',DAY(c.campaign_end_date),' ',DATE_FORMAT(c.campaign_end_date,'%b %Y'))
                    END AS campaign_period,
                    CONCAT(e.first_name,' ',e.last_name) AS author,
                    GROUP_CONCAT(DISTINCT cp.cp_name ORDER BY cp.cp_name) AS content_pilar,
                    COUNT(DISTINCT emp.user_id) AS jml_team,
                    GROUP_CONCAT(DISTINCT emp.profile_picture ORDER BY emp.first_name) AS profile_picture_team,
                    COALESCE(c.activation_target,0)   AS activation_target,
                    COALESCE(c.activation_actual,0)   AS activation_actual,
                    COALESCE(c.content_target,0)      AS content_target,
                    COALESCE(c.content_actual,0)      AS content_actual,
                    COALESCE(c.distribution_target,0) AS distribution_target,
                    COALESCE(c.distribution_actual,0) AS distribution_actual,
                    COALESCE(c.optimization_target,0) AS optimization_target,
                    COALESCE(c.optimization_actual,0) AS optimization_actual
                FROM t_cmp_campaign c
                LEFT JOIN m_cmp_brand       b   ON b.brand_id        = c.brand_id
                LEFT JOIN xin_employees     e   ON e.user_id         = c.created_by
                LEFT JOIN m_cmp_content_pillar cp ON FIND_IN_SET(cp.cp_id, c.cp_id)
                LEFT JOIN xin_employees emp ON FIND_IN_SET(CAST(emp.user_id AS CHAR),
                    CONVERT(CONCAT_WS(',', c.activation_team, c.content_team, c.talent_team, c.optimization_team) USING utf8mb4))
                WHERE c.campaign_id != 'C260211001'
                  AND DATE(c.created_at) BETWEEN '$start_date' AND '$end_date'";

        if (!empty($search)) {
            $query .= " AND (c.campaign_name LIKE '%{$search_escaped}%' OR b.brand_name LIKE '%{$search_escaped}%')";
        }

        $query .= " GROUP BY c.campaign_id ORDER BY c.created_at DESC";

        return $this->db->query($query)->result();
    }
}