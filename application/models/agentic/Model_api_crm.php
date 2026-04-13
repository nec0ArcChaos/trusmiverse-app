<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_api_crm extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->database();
    }

    public function DB($conn = 'default')
    {
        // load the database connection with TRUE to return the instance
        return $this->load->database($conn, TRUE);
    }

    public function get_ids($tbl, $col= 'id')
    {
        $query = "SELECT $col FROM $tbl";
        $result = $this->db->query($query)->result_array();
        $posts_id = [];
        foreach ($result as $key => $row) {
            $posts_id[] = $row[$col];
        }
        return $posts_id;
    }

    public function exists_row($table, $colval)
    {
        foreach ($colval as $column => $value){
            $this->db->where($column, $value);
        }
        $query = $this->db->get($table);
        return $query->num_rows() > 0;
    }

    public function get_data_by($table, $colval)
    {
        foreach ($colval as $column => $value){
            $this->db->where($column, $value);
        }
        $query = $this->db->get($table);
        return $query;
    }

    public function countRows($table, $colval = [])
    {
        // var_dump($colval);
        foreach ($colval as $column => $value){
            $this->db->where($column, $value);
        }
        $query = $this->db->count_all_results($table);
        return $query;
    }

    public function generate_kpi_id()
    {
        $prefix = 'AC' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.1_kpi_data');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    public function generate_kpi_health_id()
    {
        $prefix = 'KH' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.2_kpi_health');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    public function generate_kpi_system_analysis_id()
    {
        $prefix = 'SA' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.3_system_analysis');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    public function generate_kpi_governance_id()
    {
        $prefix = 'SA' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.4_governance_check');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    public function generate_kpi_4M_id()
    {
        $prefix = 'FM' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.5_four_m_analysis');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    public function generate_kpi_action_plan_id()
    {
        $prefix = 'TL' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.6_timeline_tracking');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    public function generate_kpi_rule_consequence_id()
    {
        $prefix = 'RC' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.7_rules_consequence');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    public function generate_kpi_reward_id()
    {
        $prefix = 'RW' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.8_reward');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    public function generate_kpi_tech_ccp_id()
    {
        $prefix = 'TA' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.9_tech_ccp_accountability');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    public function generate_kpi_ringkasan_eks_id()
    {
        $prefix = 'EX' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.10_executive_summary');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    public function generate_kpi_resiko_kritis_id()
    {
        $prefix = 'ER' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.11_executive_risks');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    public function generate_kpi_fokus_minggu_ini_id()
    {
        $prefix = 'EF' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.12_executive_focus');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    function get_project($project)
    {
        $query = "SELECT
            p.id_project,
            p.project
            FROM
            rsp_project_live.m_project p 
            WHERE
            p.id_project = $project";
        return $this->db->query($query)->row_array();
    }

    function get_project_with_complaint($periode)
    {
        $query = "SELECT
                pr.id_project,
                pr.project
                FROM
                rsp_project_live.m_project pr
                JOIN cm_task ct ON pr.id_project = ct.id_project AND DATE_FORMAT(ct.created_at, '%Y-%m') = '$periode'
                WHERE pr.status IS NULL AND pr.active = 1
                group by pr.id_project
                ";
        return $this->db->query($query)->result();
    }

    function kpi_corporate($periode) {
        $query = "SELECT
          'Customer Satisfaction Index (Rating CRM)' AS corporate_kpi,
          4.5 AS target_persentase,
          round(AVG(COALESCE(avg_rating, 0)), 2) as achieve_persentase,
          80 AS target,
          ROUND(round(AVG(COALESCE(avg_rating, 0)), 2) / 4.5 * 100, 0) AS achieve,
          round(AVG(COALESCE(kualitas, 0)), 2) as rating_kualitas,
          round(AVG(COALESCE(respons, 0)), 2) as rating_respons,
          round(AVG(COALESCE(rekomendasi, 0)), 2) as rating_rekomendasi
        --   COUNT(*) AS target,
        --   SUM(IF(COALESCE(avg_rating, 0) > 4.5, 1, 0)) AS actual,
        --   ROUND(SUM(IF(COALESCE(avg_rating, 0) > 4.5, 1, 0)) / COUNT(*) * 100, 0) AS achieve_persentase,
        FROM
          cm_task ct
        LEFT JOIN cm_rating cr
        ON ct.id_task = cr.id_task
        WHERE DATE_FORMAT(ct.created_at, '%Y-%m') = '$periode'";
        return $this->db->query($query)->row_array();
    }

    function kpi_project($project, $periode) {
        $query = "SELECT
          'Customer Satisfaction Index (Rating CRM)' AS corporate_kpi,
          4.5 AS target_persentase,
          round(AVG(COALESCE(avg_rating, 0)), 2) as achieve_persentase,
          100 AS target,
          ROUND(round(AVG(COALESCE(avg_rating, 0)), 2) / 4.5 * 100, 0) AS achieve,
          round(AVG(COALESCE(kualitas, 0)), 2) as rating_kualitas,
          round(AVG(COALESCE(respons, 0)), 2) as rating_respons,
          round(AVG(COALESCE(rekomendasi, 0)), 2) as rating_rekomendasi
        --   COUNT(*) AS target,
        --   SUM(IF(COALESCE(avg_rating, 0) > 4.5, 1, 0)) AS actual,
        --   ROUND(SUM(IF(COALESCE(avg_rating, 0) > 4.5, 1, 0)) / COUNT(*) * 100, 0) AS achieve_persentase,
        FROM
          cm_task ct
        LEFT JOIN cm_rating cr
        ON ct.id_task = cr.id_task
        WHERE DATE_FORMAT(ct.created_at, '%Y-%m') = '$periode'
        AND id_project = $project";
        return $this->db->query($query)->row_array();
    }

    function leadtime_complaint_to_escalate($project, $periode) {
        $query = "SELECT *, 
          late_escalation + ontime_escalation 'total_escalation',
          ontime_escalation,
          late_escalation,
          80 as target_persentase,
          ROUND(ontime_escalation/(late_escalation + ontime_escalation) * 100) 'achieve_persentase'
          from 
          (
          SELECT 
          SUM(if(TIMESTAMPDIFF(HOUR,created_at,escalation_at) > 48, 1, 0)) 'late_escalation',
          SUM(if(TIMESTAMPDIFF(HOUR,created_at,escalation_at) <= 48, 1, 0)) 'ontime_escalation'
          FROM
            cm_task ct
          WHERE 
          DATE_FORMAT(ct.created_at, '%Y-%m') = '$periode' AND 
          id_project = $project
          ) resume";
        return $this->db->query($query)->row_array();
    }

    function leadtime_complaint_to_done($project, $periode) {
        $query = "SELECT *, 
          late_done + ontime_done 'total_done',
          ontime_done,
          late_done,
          80 as target_persentase,
          ROUND(ontime_done/(late_done + ontime_done) * 100) 'achieve_persentase'
          from 
          (
          SELECT 
          SUM(if(done_date > due_date, 1, 0)) 'late_done',
          SUM(if(done_date <= due_date, 1, 0)) 'ontime_done'
          FROM
            cm_task ct
          WHERE 
          DATE_FORMAT(ct.created_at, '%Y-%m') = '$periode' AND 
          id_project = $project
          ) resume";
        return $this->db->query($query)->row_array();
    }
    
    function jumlah_complaint_by_status($project, $periode) {
        $query = "SELECT 
          SUM(if(ct.status in (5), 1, 0)) 'reject',
          SUM(if(ct.status = 4, 1, 0)) 'working_on',
          SUM(if(ct.status = 6, 1, 0)) 'done',
          SUM(if(ct.status in (8,9), 1, 0)) 'reschedule'
          FROM
            cm_task ct
          WHERE 
          DATE_FORMAT(ct.created_at, '%Y-%m') = '$periode' AND 
          id_project = $project";
        return $this->db->query($query)->row_array();
    }
    
    function complaintVSaftersalesVSqcVSpelaksana($project, $periode) {
        $query = "SELECT cm.blok,
                cm.complaints, 
                COALESCE(afs.after_sales, 'Tidak ada after sales') after_sales,
                COALESCE(qc.qc, 'Tidak ada temuan QC') qc,
                COALESCE(tp.temuan_pelaksana, 'Tidak ada temuan pelaksana') temuan_pelaksana
                FROM
                (
                SELECT ct.id_project, ct.blok, id_project_unit, konsumen, 
                GROUP_CONCAT(task SEPARATOR ';') as complaint_tasks, 
                GROUP_CONCAT(description SEPARATOR ';') as complaints
                FROM cm_task ct
                LEFT JOIN rsp_project_live.m_project_unit mpu on ct.id_project = mpu.id_project and ct.blok = mpu.blok
                WHERE 
                ct.id_project = $project
                AND 
                DATE_FORMAT(ct.created_at, '%Y-%m') = '$periode' 
                AND 
                ct.id_project <> 0 
                GROUP BY mpu.id_project_unit ORDER BY mpu.id_project_unit
                ) cm LEFT JOIN
                (
                SELECT mpu.id_project_unit,
                tas.id_after_sales,
                tass.sub_poin,
                GROUP_CONCAT(DISTINCT CONCAT(area_poin,' - ',area_sub_poin) SEPARATOR ';') after_sales 
                FROM rsp_project_live.m_project_unit mpu
                LEFT JOIN rsp_project_live.t_after_sales tas on  mpu.id_project_unit = tas.id_project_unit
                LEFT JOIN rsp_project_live.t_after_sales_sub_detail tass on tas.id_after_sales = tass.id_after_sales AND tass.hasil = 2
                LEFT JOIN rsp_project_live.m_area_sub_poin mas on tass.sub_poin = mas.id
                LEFT JOIN rsp_project_live.m_area_poin map on mas.id_area_poin = map.id
                WHERE 
                mpu.id_project = $project
                GROUP BY mpu.id_project_unit
                ) afs ON cm.id_project_unit = afs.id_project_unit LEFT JOIN
                (
                SELECT
                tcq.project,
                tcq.blok,
                mcq.id_ceklis,
                GROUP_CONCAT(DISTINCT mcq.item_pekerjaan SEPARATOR ';') qc
                FROM
                rsp_project_live.m_ceklis_qc mcq
                LEFT JOIN rsp_project_live.t_ceklis_qc tcq ON mcq.id_ceklis = tcq.ceklis 
                AND tcq.project = $project
                WHERE status = 2
                GROUP BY project,blok
                ) qc ON cm.id_project = qc.project AND cm.blok = qc.blok LEFT JOIN
                (
                WITH isswakelola as (
                SELECT 
                blok,
                CASE WHEN vendor = 231 THEN 1
                ELSE 0 
                END as swakelola,
                CASE WHEN (tgl_spk > '2025-09-15' OR (id_project = 70 AND tgl_spk > '2025-05-23')) OR vendor = 231 THEN 1
                ELSE NULL 
                END as modified,
                id_project
                from rsp_project_live.t_project_bangun_detail pbd join rsp_project_live.t_project_bangun pb ON pbd.id_rencana = pb.id_rencana where id_project = $project
                )
                SELECT
                    t.blok,
                    t.project,
                    GROUP_CONCAT(DISTINCT m.item_pekerjaan SEPARATOR ';') temuan_pelaksana,
                    t.`status`
                FROM
                rsp_project_live.t_ceklis_pelaksana t
                LEFT JOIN rsp_project_live.m_ceklis_pelaksana_new m ON t.ceklis = m.id_ceklis 
                LEFT JOIN isswakelola i ON ((m.swakelola <=> i.swakelola
                AND m.modified <=> i.modified) OR m.project = i.id_project) AND t.blok = i.blok
                LEFT JOIN rsp_project_live.user pm ON pm.id_user = t.approve_by
                WHERE t.project = $project 
                AND status <> 1
                GROUP BY t.project, t.blok
                ) tp ON cm.id_project = tp.project AND cm.blok = tp.blok";
        return $this->db->query($query)->result_array();
    }

    function temuan_complaint_terbanyak($project, $periode) {
        $query = "SELECT 
                description as complaints
                FROM cm_task ct
                LEFT JOIN rsp_project_live.m_project_unit mpu on ct.id_project = mpu.id_project and ct.blok = mpu.blok
                WHERE 
                ct.id_project = $project
                AND 
                DATE_FORMAT(ct.created_at, '%Y-%m') = '$periode' 
                AND 
                ct.id_project <> 0 
                -- GROUP BY mpu.id_project_unit
                ORDER BY mpu.id_project_unit
                ";
        return $this->db->query($query)->result_array();
    }
    
    function kategori() {
        $query="SELECT DISTINCT CONCAT(area_poin,' - ',area_sub_poin) kategori FROM
                rsp_project_live.m_area_sub_poin mas
                LEFT JOIN rsp_project_live.m_area_poin map on mas.id_area_poin = map.id
                ";
        return $this->db->query($query)->result_array();
        
    }
}