<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_dashboard extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_performance_overview($start_date, $end_date)
    {
        // 1. All Campaign (all campaigns created in period)
        $this->db->where('DATE(created_at) >=', $start_date);
        $this->db->where('DATE(created_at) <=', $end_date);
        $all_campaign = $this->db->count_all_results('t_cmp_campaign');

        $last_month_start = date('Y-m-d', strtotime('-1 month', strtotime($start_date)));
        $last_month_end = date('Y-m-d', strtotime('-1 month', strtotime($end_date)));
        $this->db->where('DATE(created_at) >=', $last_month_start);
        $this->db->where('DATE(created_at) <=', $last_month_end);
        $all_campaign_last_month = $this->db->count_all_results('t_cmp_campaign');
        $all_campaign_change = $all_campaign - $all_campaign_last_month;

        // 2. Completed (campaign_status >= 4)
        $this->db->where('DATE(created_at) >=', $start_date);
        $this->db->where('DATE(created_at) <=', $end_date);
        $this->db->where('campaign_status >=', 4);
        $completed = $this->db->count_all_results('t_cmp_campaign');

        $this->db->where('DATE(created_at) >=', $start_date);
        $this->db->where('DATE(created_at) <=', $end_date);
        $this->db->where('campaign_status >=', 4);
        $this->db->group_start();
        $this->db->where('campaign_status >= 4 AND DATE(updated_at) < DATE_SUB(campaign_start_date, INTERVAL 7 DAY)', NULL, FALSE);
        $this->db->or_where('campaign_status < 4 AND CURRENT_DATE < DATE_SUB(campaign_start_date, INTERVAL 7 DAY)', NULL, FALSE);
        $this->db->group_end();
        $completed_on_time = $this->db->count_all_results('t_cmp_campaign');
        $completed_delayed = $completed - $completed_on_time;

        // 3. On Progress (campaign_status = 2)
        $this->db->where('DATE(created_at) >=', $start_date);
        $this->db->where('DATE(created_at) <=', $end_date);
        $this->db->where('campaign_status >=', 2);
        $this->db->where('campaign_status <', 4);
        $on_progress = $this->db->count_all_results('t_cmp_campaign');

        $this->db->where('DATE(created_at) >=', $start_date);
        $this->db->where('DATE(created_at) <=', $end_date);
        $this->db->where('campaign_status >=', 2);
        $this->db->where('campaign_status <', 4);
        $this->db->where('CURRENT_DATE >= DATE_ADD(campaign_start_date, INTERVAL 7 DAY)', NULL, FALSE);
        $on_progress_at_risk = $this->db->count_all_results('t_cmp_campaign');
        $on_progress_on_track = $on_progress - $on_progress_at_risk;

        // 4. Avg AI Score -> average overall_score from t_cmp_campaign_analysis
        $this->db->select_avg('overall_score');
        $this->db->from('t_cmp_campaign_analysis a');
        $this->db->join('t_cmp_campaign c', 'c.campaign_id = a.campaign_id');
        $this->db->where('DATE(c.created_at) >=', $start_date);
        $this->db->where('DATE(c.created_at) <=', $end_date);
        $query_ai = $this->db->get()->row();
        $avg_ai_score = $query_ai->overall_score ? round($query_ai->overall_score, 1) : 0;

        return [
            'all_campaign' => $all_campaign,
            'all_campaign_change' => $all_campaign_change,
            'completed' => $completed,
            'completed_on_time' => $completed_on_time,
            'completed_delayed' => $completed_delayed,
            'on_progress' => $on_progress,
            'on_progress_on_track' => $on_progress_on_track,
            'on_progress_at_risk' => $on_progress_at_risk,
            'avg_ai_score' => $avg_ai_score
        ];
    }

    public function get_campaign_stage_pipeline($start_date, $end_date)
    {
        // helper to get data for stages: Activation, Content, Distribution, Optimization, (and mock Talent).
        $data = [];

        // 1. Activation
        $this->db->select('
            SUM(activation_actual) as actual,
            SUM(activation_target) as target,
            AVG(
                CASE 
                    WHEN activation_actual >= activation_target THEN TIMESTAMPDIFF(MINUTE, campaign_approved_at, activation_approved_at)
                    ELSE TIMESTAMPDIFF(MINUTE, campaign_approved_at, NOW())
                END
            ) as avg_sla_minutes
        ');
        $this->db->from('t_cmp_campaign');
        $this->db->where('DATE(created_at) >=', $start_date);
        $this->db->where('DATE(created_at) <=', $end_date);
        $act_stats = $this->db->get()->row();

        $this->db->select('AVG(aa.overall_score) as avg_score');
        $this->db->from('t_cmp_campaign c');
        $this->db->join('t_cmp_activation a', 'a.campaign_id = c.campaign_id', 'left');
        $this->db->join('t_cmp_activation_analysis aa', 'aa.activation_id = a.activation_id', 'left');
        $this->db->where('DATE(c.created_at) >=', $start_date);
        $this->db->where('DATE(c.created_at) <=', $end_date);
        $act_ai = $this->db->get()->row()->avg_score;

        $data['activation'] = [
            'approved' => $act_stats->actual ? (int) $act_stats->actual : 0,
            'target' => $act_stats->target ? (int) $act_stats->target : 0,
            'avg_sla_minutes' => $act_stats->avg_sla_minutes ? (float) $act_stats->avg_sla_minutes : 0,
            'avg_ai_score' => $act_ai ? round($act_ai, 1) : 0,
        ];

        // 2. Content
        $this->db->select('
            SUM(content_actual) as actual,
            SUM(content_target) as target,
            AVG(
                CASE 
                    WHEN content_actual >= content_target THEN TIMESTAMPDIFF(MINUTE, activation_approved_at, content_approved_at)
                    ELSE TIMESTAMPDIFF(MINUTE, activation_approved_at, NOW())
                END
            ) as avg_sla_minutes
        ');
        $this->db->from('t_cmp_campaign');
        $this->db->where('DATE(created_at) >=', $start_date);
        $this->db->where('DATE(created_at) <=', $end_date);
        $cnt_stats = $this->db->get()->row();

        $this->db->select('AVG(ca.viability_score) as avg_score'); // assuming viability_score or overall_score in content analysis
        $this->db->from('t_cmp_campaign c');
        $this->db->join('t_cmp_content ct', 'ct.campaign_id = c.campaign_id', 'left');
        $this->db->join('t_cmp_content_analysis ca', 'ca.content_id = ct.id', 'left');
        $this->db->where('DATE(c.created_at) >=', $start_date);
        $this->db->where('DATE(c.created_at) <=', $end_date);
        $cnt_ai = $this->db->get()->row()->avg_score;

        $data['content'] = [
            'approved' => $cnt_stats->actual ? (int) $cnt_stats->actual : 0,
            'target' => $cnt_stats->target ? (int) $cnt_stats->target : 0,
            'avg_sla_minutes' => $cnt_stats->avg_sla_minutes ? (float) $cnt_stats->avg_sla_minutes : 0,
            'avg_ai_score' => $cnt_ai ? round($cnt_ai, 1) : 0,
        ];

        // 3. Talent (Using target from t_cmp_campaign, actual mocked or counted from t_cmp_talent)
        $this->db->select('SUM(talent_target) as target');
        $this->db->from('t_cmp_campaign');
        $this->db->where('DATE(created_at) >=', $start_date);
        $this->db->where('DATE(created_at) <=', $end_date);
        $tln_target = $this->db->get()->row()->target;

        $data['talent'] = [
            'approved' => 0, // Mocked for now due to missing column
            'target' => $tln_target ? (int) $tln_target : 0,
            'avg_sla_minutes' => 0,
            'avg_ai_score' => 0, // No analysis table for talent
        ];

        // 4. Distribution
        $this->db->select('
            SUM(distribution_actual) as actual,
            SUM(distribution_target) as target,
            AVG(
                CASE 
                    WHEN distribution_actual >= distribution_target THEN TIMESTAMPDIFF(MINUTE, content_approved_at, distribution_approved_at)
                    ELSE TIMESTAMPDIFF(MINUTE, content_approved_at, NOW())
                END
            ) as avg_sla_minutes
        ');
        $this->db->from('t_cmp_campaign');
        $this->db->where('DATE(created_at) >=', $start_date);
        $this->db->where('DATE(created_at) <=', $end_date);
        $dst_stats = $this->db->get()->row();

        // Using distribution analysis 
        $this->db->select('AVG(da.viability_score) as avg_score');
        $this->db->from('t_cmp_campaign c');
        $this->db->join('t_cmp_distribution d', 'd.campaign_id = c.campaign_id', 'left');
        $this->db->join('t_cmp_distribution_analysis da', 'da.distribution_id = d.distribution_id', 'left');
        $this->db->where('DATE(c.created_at) >=', $start_date);
        $this->db->where('DATE(c.created_at) <=', $end_date);
        $dst_ai = $this->db->get()->row()->avg_score;

        $data['distribution'] = [
            'approved' => $dst_stats->actual ? (int) $dst_stats->actual : 0,
            'target' => $dst_stats->target ? (int) $dst_stats->target : 0,
            'avg_sla_minutes' => $dst_stats->avg_sla_minutes ? (float) $dst_stats->avg_sla_minutes : 0,
            'avg_ai_score' => $dst_ai ? round($dst_ai, 1) : 0,
        ];

        // 5. Optimization
        $this->db->select('
            SUM(optimization_actual) as actual,
            SUM(optimization_target) as target,
            AVG(
                CASE 
                    WHEN optimization_actual >= optimization_target THEN TIMESTAMPDIFF(MINUTE, distribution_approved_at, optimization_approved_at)
                    ELSE TIMESTAMPDIFF(MINUTE, distribution_approved_at, NOW())
                END
            ) as avg_sla_minutes
        ');
        $this->db->from('t_cmp_campaign');
        $this->db->where('DATE(created_at) >=', $start_date);
        $this->db->where('DATE(created_at) <=', $end_date);
        $opt_stats = $this->db->get()->row();

        $this->db->select('AVG(oa.viability_score) as avg_score');
        $this->db->from('t_cmp_campaign c');
        $this->db->join('t_cmp_optimization o', 'o.campaign_id = c.campaign_id', 'left');
        $this->db->join('t_cmp_optimization_analysis oa', 'oa.optimization_id = o.optimization_id', 'left');
        $this->db->where('DATE(c.created_at) >=', $start_date);
        $this->db->where('DATE(c.created_at) <=', $end_date);
        $opt_ai = $this->db->get()->row()->avg_score;

        $data['optimization'] = [
            'approved' => $opt_stats->actual ? (int) $opt_stats->actual : 0,
            'target' => $opt_stats->target ? (int) $opt_stats->target : 0,
            'avg_sla_minutes' => $opt_stats->avg_sla_minutes ? (float) $opt_stats->avg_sla_minutes : 0,
            'avg_ai_score' => $opt_ai ? round($opt_ai, 1) : 0,
        ];

        // Calculate Completion Rates for all
        foreach ($data as $key => $stage) {
            $data[$key]['completion_rate'] = ($stage['target'] > 0) ? round(($stage['approved'] / $stage['target']) * 100, 1) : 0;
        }

        return $data;
    }

    public function get_campaign_stage_list_dt($postData)
    {
        $this->_get_datatables_query_stage_list($postData);
        if (isset($postData['length']) && $postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_stage_list($postData)
    {
        $this->_get_datatables_query_stage_list($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_stage_list($postData)
    {
        $this->db->from('t_cmp_campaign');
        if (!empty($postData['start_date']) && !empty($postData['end_date'])) {
            $this->db->where('DATE(created_at) >=', $postData['start_date']);
            $this->db->where('DATE(created_at) <=', $postData['end_date']);
        }
        if (!empty($postData['status']) && $postData['status'] != 'Semua Status') {
            if ($postData['status'] == 'Completed')
                $this->db->where('campaign_status >=', 4);
            if ($postData['status'] == 'On Progress') {
                $this->db->where('campaign_status >=', 2);
                $this->db->where('campaign_status <', 4);
            }
        }
        return $this->db->count_all_results();
    }

    private function _get_datatables_query_stage_list($postData)
    {
        $this->db->select("
            c.campaign_name,
            c.campaign_id,
            c.campaign_status,
            COALESCE(c.activation_actual, 0) as act_actual, COALESCE(c.activation_target, 0) as act_target,
            COALESCE(c.content_actual, 0) as cnt_actual, COALESCE(c.content_target, 0) as cnt_target,
            0 as tln_actual, COALESCE(c.talent_target, 0) as tln_target,
            COALESCE(c.distribution_actual, 0) as dst_actual, COALESCE(c.distribution_target, 0) as dst_target,
            COALESCE(c.optimization_actual, 0) as opt_actual, COALESCE(c.optimization_target, 0) as opt_target,
            
            CASE WHEN c.activation_actual >= c.activation_target THEN TIMESTAMPDIFF(MINUTE, c.campaign_approved_at, c.activation_approved_at)
                 ELSE TIMESTAMPDIFF(MINUTE, c.campaign_approved_at, NOW()) END as act_sla,
            CASE WHEN c.content_actual >= c.content_target THEN TIMESTAMPDIFF(MINUTE, c.activation_approved_at, c.content_approved_at)
                 ELSE TIMESTAMPDIFF(MINUTE, c.activation_approved_at, NOW()) END as cnt_sla,
            CASE WHEN c.distribution_actual >= c.distribution_target THEN TIMESTAMPDIFF(MINUTE, c.content_approved_at, c.distribution_approved_at)
                 ELSE TIMESTAMPDIFF(MINUTE, c.content_approved_at, NOW()) END as dst_sla,
            CASE WHEN c.optimization_actual >= c.optimization_target THEN TIMESTAMPDIFF(MINUTE, c.distribution_approved_at, c.optimization_approved_at)
                 ELSE TIMESTAMPDIFF(MINUTE, c.distribution_approved_at, NOW()) END as opt_sla,
                 
            (SELECT AVG(aa.overall_score) FROM t_cmp_activation a JOIN t_cmp_activation_analysis aa ON a.activation_id = aa.activation_id WHERE a.campaign_id = c.campaign_id) as act_ai,
            (SELECT AVG(ca.viability_score) FROM t_cmp_content ct JOIN t_cmp_content_analysis ca ON ct.id = ca.content_id WHERE ct.campaign_id = c.campaign_id) as cnt_ai,
            0 as tln_ai,
            (SELECT AVG(da.viability_score) FROM t_cmp_distribution d JOIN t_cmp_distribution_analysis da ON d.distribution_id = da.distribution_id WHERE d.campaign_id = c.campaign_id) as dst_ai,
            (SELECT AVG(oa.viability_score) FROM t_cmp_optimization o JOIN t_cmp_optimization_analysis oa ON o.optimization_id = oa.optimization_id WHERE o.campaign_id = c.campaign_id) as opt_ai
        ", FALSE);

        $this->db->from('t_cmp_campaign c');

        if (!empty($postData['start_date']) && !empty($postData['end_date'])) {
            $this->db->where('DATE(c.created_at) >=', $postData['start_date']);
            $this->db->where('DATE(c.created_at) <=', $postData['end_date']);
        }

        if (!empty($postData['status']) && $postData['status'] != 'Semua Status') {
            if ($postData['status'] == 'Completed')
                $this->db->where('c.campaign_status >=', 4);
            if ($postData['status'] == 'On Progress') {
                $this->db->where('c.campaign_status >=', 2);
                $this->db->where('c.campaign_status <', 4);
            }
        }

        $column_search = array('c.campaign_name');
        $i = 0;
        foreach ($column_search as $item) {
            if (isset($postData['search']['value']) && $postData['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                } else {
                    $this->db->or_like($item, $postData['search']['value']);
                }
                if (count($column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        $column_order = array('c.campaign_name', null, null, null, null, null, null, null, null);
        if (isset($postData['order'])) {
            $this->db->order_by($column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } else {
            $this->db->order_by('c.created_at', 'DESC');
        }
    }

    public function get_pic_activation_list_dt($postData)
    {
        $this->_get_datatables_query_pic_activation_list($postData);
        if (isset($postData['length']) && $postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_pic_activation_list($postData)
    {
        $this->_get_datatables_query_pic_activation_list($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_pic_activation_list($postData)
    {
        $this->db->from('t_cmp_activation a');
        if (!empty($postData['start_date']) && !empty($postData['end_date'])) {
            $this->db->where('DATE(a.created_at) >=', $postData['start_date']);
            $this->db->where('DATE(a.created_at) <=', $postData['end_date']);
        }
        return $this->db->count_all_results();
    }

    private function _get_datatables_query_pic_activation_list($postData)
    {
        $start_date = !empty($postData['start_date']) ? $postData['start_date'] : date('Y-m-01');
        $end_date = !empty($postData['end_date']) ? $postData['end_date'] : date('Y-m-t');

        $subquery_actual = "(SELECT SUM(sub_c.activation_actual) FROM t_cmp_campaign sub_c WHERE sub_c.campaign_id IN (SELECT DISTINCT sub_a.campaign_id FROM t_cmp_activation sub_a WHERE sub_a.created_by = a.created_by AND DATE(sub_a.created_at) >= '$start_date' AND DATE(sub_a.created_at) <= '$end_date'))";
        $subquery_target = "(SELECT SUM(sub_c.activation_target) FROM t_cmp_campaign sub_c WHERE sub_c.campaign_id IN (SELECT DISTINCT sub_a.campaign_id FROM t_cmp_activation sub_a WHERE sub_a.created_by = a.created_by AND DATE(sub_a.created_at) >= '$start_date' AND DATE(sub_a.created_at) <= '$end_date'))";

        $this->db->select("
            a.created_by,
            MAX(CONCAT(e.first_name, ' ', e.last_name)) as pic_name,
            $subquery_actual as act_actual,
            $subquery_target as act_target,
            AVG(
                CASE 
                    WHEN a.approved_at IS NOT NULL THEN TIMESTAMPDIFF(MINUTE, c.campaign_approved_at, a.approved_at)
                    ELSE TIMESTAMPDIFF(MINUTE, c.campaign_approved_at, NOW()) 
                END
            ) as avg_sla,
            AVG(aa.overall_score) as avg_ai
        ", FALSE);

        $this->db->from('t_cmp_activation a');
        $this->db->join('xin_employees e', 'e.user_id = a.created_by', 'left');
        $this->db->join('t_cmp_campaign c', 'c.campaign_id = a.campaign_id', 'left');
        $this->db->join('t_cmp_activation_analysis aa', 'aa.activation_id = a.activation_id', 'left');

        $this->db->where('DATE(a.created_at) >=', $start_date);
        $this->db->where('DATE(a.created_at) <=', $end_date);
        $this->db->group_by('a.created_by');

        $column_search = array("CONCAT(e.first_name, ' ', e.last_name)");
        $i = 0;
        foreach ($column_search as $item) {
            if (isset($postData['search']['value']) && $postData['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                } else {
                    $this->db->or_like($item, $postData['search']['value']);
                }
                if (count($column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }

        $column_order = array('pic_name', null, null, null, null);
        if (isset($postData['order'])) {
            $this->db->order_by($column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } else {
            $this->db->order_by('pic_name', 'ASC');
        }
    }

    // ========== CONTENT PIC LIST ==========

    public function get_pic_content_list_dt($postData)
    {
        $this->_get_datatables_query_pic_content_list($postData);
        if (isset($postData['length']) && $postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_pic_content_list($postData)
    {
        $this->_get_datatables_query_pic_content_list($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_pic_content_list($postData)
    {
        $this->db->from('t_cmp_content a');
        if (!empty($postData['start_date']) && !empty($postData['end_date'])) {
            $this->db->where('DATE(a.created_at) >=', $postData['start_date']);
            $this->db->where('DATE(a.created_at) <=', $postData['end_date']);
        }
        return $this->db->count_all_results();
    }

    private function _get_datatables_query_pic_content_list($postData)
    {
        $start_date = !empty($postData['start_date']) ? $postData['start_date'] : date('Y-m-01');
        $end_date = !empty($postData['end_date']) ? $postData['end_date'] : date('Y-m-t');

        $subquery_actual = "(SELECT SUM(sub_c.content_actual) FROM t_cmp_campaign sub_c WHERE sub_c.campaign_id IN (SELECT DISTINCT sub_a.campaign_id FROM t_cmp_content sub_a WHERE sub_a.created_by = a.created_by AND DATE(sub_a.created_at) >= '$start_date' AND DATE(sub_a.created_at) <= '$end_date'))";
        $subquery_target = "(SELECT SUM(sub_c.content_target) FROM t_cmp_campaign sub_c WHERE sub_c.campaign_id IN (SELECT DISTINCT sub_a.campaign_id FROM t_cmp_content sub_a WHERE sub_a.created_by = a.created_by AND DATE(sub_a.created_at) >= '$start_date' AND DATE(sub_a.created_at) <= '$end_date'))";

        $this->db->select("
            a.created_by,
            MAX(CONCAT(e.first_name, ' ', e.last_name)) as pic_name,
            $subquery_actual as act_actual,
            $subquery_target as act_target,
            AVG(
                CASE 
                    WHEN a.approved_at IS NOT NULL THEN TIMESTAMPDIFF(MINUTE, c.activation_approved_at, a.approved_at)
                    ELSE TIMESTAMPDIFF(MINUTE, c.activation_approved_at, NOW()) 
                END
            ) as avg_sla,
            AVG(aa.viability_score) as avg_ai
        ", FALSE);

        $this->db->from('t_cmp_content a');
        $this->db->join('xin_employees e', 'e.user_id = a.created_by', 'left');
        $this->db->join('t_cmp_campaign c', 'c.campaign_id = a.campaign_id', 'left');
        $this->db->join('t_cmp_content_analysis aa', 'aa.content_id = a.id', 'left');

        $this->db->where('DATE(a.created_at) >=', $start_date);
        $this->db->where('DATE(a.created_at) <=', $end_date);
        $this->db->group_by('a.created_by');

        $column_search = array("CONCAT(e.first_name, ' ', e.last_name)");
        $i = 0;
        foreach ($column_search as $item) {
            if (isset($postData['search']['value']) && $postData['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                } else {
                    $this->db->or_like($item, $postData['search']['value']);
                }
                if (count($column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }

        $column_order = array('pic_name', null, null, null, null);
        if (isset($postData['order'])) {
            $this->db->order_by($column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } else {
            $this->db->order_by('pic_name', 'ASC');
        }
    }


    // ========== TALENT PIC LIST ==========

    public function get_pic_talent_list_dt($postData)
    {
        $this->_get_datatables_query_pic_talent_list($postData);
        if (isset($postData['length']) && $postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_pic_talent_list($postData)
    {
        $this->_get_datatables_query_pic_talent_list($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_pic_talent_list($postData)
    {
        $this->db->from('t_cmp_talent a');
        if (!empty($postData['start_date']) && !empty($postData['end_date'])) {
            $this->db->where('DATE(a.created_at) >=', $postData['start_date']);
            $this->db->where('DATE(a.created_at) <=', $postData['end_date']);
        }
        return $this->db->count_all_results();
    }

    private function _get_datatables_query_pic_talent_list($postData)
    {
        $start_date = !empty($postData['start_date']) ? $postData['start_date'] : date('Y-m-01');
        $end_date = !empty($postData['end_date']) ? $postData['end_date'] : date('Y-m-t');

        $subquery_actual = "(SELECT SUM(sub_c.talent_actual) FROM t_cmp_campaign sub_c WHERE sub_c.campaign_id IN (SELECT DISTINCT sub_a.campaign_id FROM t_cmp_talent sub_a WHERE sub_a.created_by = a.created_by AND DATE(sub_a.created_at) >= '$start_date' AND DATE(sub_a.created_at) <= '$end_date'))";
        $subquery_target = "(SELECT SUM(sub_c.talent_target) FROM t_cmp_campaign sub_c WHERE sub_c.campaign_id IN (SELECT DISTINCT sub_a.campaign_id FROM t_cmp_talent sub_a WHERE sub_a.created_by = a.created_by AND DATE(sub_a.created_at) >= '$start_date' AND DATE(sub_a.created_at) <= '$end_date'))";

        $this->db->select("
            a.created_by,
            MAX(CONCAT(e.first_name, ' ', e.last_name)) as pic_name,
            $subquery_actual as act_actual,
            $subquery_target as act_target,
            0 as avg_sla,
            AVG(aa.viability_score) as avg_ai
        ", FALSE);

        $this->db->from('t_cmp_talent a');
        $this->db->join('xin_employees e', 'e.user_id = a.created_by', 'left');
        $this->db->join('t_cmp_campaign c', 'c.campaign_id = a.campaign_id', 'left');
        $this->db->join('t_cmp_talent_analysis aa', 'aa.talent_id = a.id', 'left');

        $this->db->where('DATE(a.created_at) >=', $start_date);
        $this->db->where('DATE(a.created_at) <=', $end_date);
        $this->db->group_by('a.created_by');

        $column_search = array("CONCAT(e.first_name, ' ', e.last_name)");
        $i = 0;
        foreach ($column_search as $item) {
            if (isset($postData['search']['value']) && $postData['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                } else {
                    $this->db->or_like($item, $postData['search']['value']);
                }
                if (count($column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }

        $column_order = array('pic_name', null, null, null, null);
        if (isset($postData['order'])) {
            $this->db->order_by($column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } else {
            $this->db->order_by('pic_name', 'ASC');
        }
    }


    // ========== DISTRIBUTION PIC LIST ==========

    public function get_pic_distribution_list_dt($postData)
    {
        $this->_get_datatables_query_pic_distribution_list($postData);
        if (isset($postData['length']) && $postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_pic_distribution_list($postData)
    {
        $this->_get_datatables_query_pic_distribution_list($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_pic_distribution_list($postData)
    {
        $this->db->from('t_cmp_distribution a');
        if (!empty($postData['start_date']) && !empty($postData['end_date'])) {
            $this->db->where('DATE(a.created_at) >=', $postData['start_date']);
            $this->db->where('DATE(a.created_at) <=', $postData['end_date']);
        }
        return $this->db->count_all_results();
    }

    private function _get_datatables_query_pic_distribution_list($postData)
    {
        $start_date = !empty($postData['start_date']) ? $postData['start_date'] : date('Y-m-01');
        $end_date = !empty($postData['end_date']) ? $postData['end_date'] : date('Y-m-t');

        $subquery_actual = "(SELECT SUM(sub_c.distribution_actual) FROM t_cmp_campaign sub_c WHERE sub_c.campaign_id IN (SELECT DISTINCT sub_a.campaign_id FROM t_cmp_distribution sub_a WHERE sub_a.created_by = a.created_by AND DATE(sub_a.created_at) >= '$start_date' AND DATE(sub_a.created_at) <= '$end_date'))";
        $subquery_target = "(SELECT SUM(sub_c.distribution_target) FROM t_cmp_campaign sub_c WHERE sub_c.campaign_id IN (SELECT DISTINCT sub_a.campaign_id FROM t_cmp_distribution sub_a WHERE sub_a.created_by = a.created_by AND DATE(sub_a.created_at) >= '$start_date' AND DATE(sub_a.created_at) <= '$end_date'))";

        $this->db->select("
            a.created_by,
            MAX(CONCAT(e.first_name, ' ', e.last_name)) as pic_name,
            $subquery_actual as act_actual,
            $subquery_target as act_target,
            AVG(
                CASE 
                    WHEN a.approved_at IS NOT NULL THEN TIMESTAMPDIFF(MINUTE, c.content_approved_at, a.approved_at)
                    ELSE TIMESTAMPDIFF(MINUTE, c.content_approved_at, NOW()) 
                END
            ) as avg_sla,
            AVG(aa.viability_score) as avg_ai
        ", FALSE);

        $this->db->from('t_cmp_distribution a');
        $this->db->join('xin_employees e', 'e.user_id = a.created_by', 'left');
        $this->db->join('t_cmp_campaign c', 'c.campaign_id = a.campaign_id', 'left');
        $this->db->join('t_cmp_distribution_analysis aa', 'aa.distribution_id = a.distribution_id', 'left');

        $this->db->where('DATE(a.created_at) >=', $start_date);
        $this->db->where('DATE(a.created_at) <=', $end_date);
        $this->db->group_by('a.created_by');

        $column_search = array("CONCAT(e.first_name, ' ', e.last_name)");
        $i = 0;
        foreach ($column_search as $item) {
            if (isset($postData['search']['value']) && $postData['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                } else {
                    $this->db->or_like($item, $postData['search']['value']);
                }
                if (count($column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }

        $column_order = array('pic_name', null, null, null, null);
        if (isset($postData['order'])) {
            $this->db->order_by($column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } else {
            $this->db->order_by('pic_name', 'ASC');
        }
    }


    // ========== OPTIMIZATION PIC LIST ==========

    public function get_pic_optimization_list_dt($postData)
    {
        $this->_get_datatables_query_pic_optimization_list($postData);
        if (isset($postData['length']) && $postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_pic_optimization_list($postData)
    {
        $this->_get_datatables_query_pic_optimization_list($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_pic_optimization_list($postData)
    {
        $this->db->from('t_cmp_optimization a');
        if (!empty($postData['start_date']) && !empty($postData['end_date'])) {
            $this->db->where('DATE(a.created_at) >=', $postData['start_date']);
            $this->db->where('DATE(a.created_at) <=', $postData['end_date']);
        }
        return $this->db->count_all_results();
    }

    private function _get_datatables_query_pic_optimization_list($postData)
    {
        $start_date = !empty($postData['start_date']) ? $postData['start_date'] : date('Y-m-01');
        $end_date = !empty($postData['end_date']) ? $postData['end_date'] : date('Y-m-t');

        $subquery_actual = "(SELECT SUM(sub_c.optimization_actual) FROM t_cmp_campaign sub_c WHERE sub_c.campaign_id IN (SELECT DISTINCT sub_a.campaign_id FROM t_cmp_optimization sub_a WHERE sub_a.created_by = a.created_by AND DATE(sub_a.created_at) >= '$start_date' AND DATE(sub_a.created_at) <= '$end_date'))";
        $subquery_target = "(SELECT SUM(sub_c.optimization_target) FROM t_cmp_campaign sub_c WHERE sub_c.campaign_id IN (SELECT DISTINCT sub_a.campaign_id FROM t_cmp_optimization sub_a WHERE sub_a.created_by = a.created_by AND DATE(sub_a.created_at) >= '$start_date' AND DATE(sub_a.created_at) <= '$end_date'))";

        $this->db->select("
            a.created_by,
            MAX(CONCAT(e.first_name, ' ', e.last_name)) as pic_name,
            $subquery_actual as act_actual,
            $subquery_target as act_target,
            AVG(
                CASE 
                    WHEN a.approved_at IS NOT NULL THEN TIMESTAMPDIFF(MINUTE, c.distribution_approved_at, a.approved_at)
                    ELSE TIMESTAMPDIFF(MINUTE, c.distribution_approved_at, NOW()) 
                END
            ) as avg_sla,
            AVG(aa.viability_score) as avg_ai
        ", FALSE);

        $this->db->from('t_cmp_optimization a');
        $this->db->join('xin_employees e', 'e.user_id = a.created_by', 'left');
        $this->db->join('t_cmp_campaign c', 'c.campaign_id = a.campaign_id', 'left');
        $this->db->join('t_cmp_optimization_analysis aa', 'aa.optimization_id = a.optimization_id', 'left');

        $this->db->where('DATE(a.created_at) >=', $start_date);
        $this->db->where('DATE(a.created_at) <=', $end_date);
        $this->db->group_by('a.created_by');

        $column_search = array("CONCAT(e.first_name, ' ', e.last_name)");
        $i = 0;
        foreach ($column_search as $item) {
            if (isset($postData['search']['value']) && $postData['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                } else {
                    $this->db->or_like($item, $postData['search']['value']);
                }
                if (count($column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }

        $column_order = array('pic_name', null, null, null, null);
        if (isset($postData['order'])) {
            $this->db->order_by($column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } else {
            $this->db->order_by('pic_name', 'ASC');
        }
    }
}