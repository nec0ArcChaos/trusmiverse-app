<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_api_purchasing extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
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


    function get_all_project()
    {

        $query = "SELECT
                    mp.id_project,
                    mp.project
                FROM
                    rsp_project_live.m_project mp
                WHERE `status` IS NULL
                AND active = 1
                ";

        return $this->db->query($query)->result();

    }

    function get_project($id)
    {

        $query = "SELECT
                    mp.id_project,
                    mp.project
                FROM
                    rsp_project_live.m_project mp
                WHERE
                    mp.id_project = '$id'
                AND `status` IS NULL
                AND active = 1
                ";

        return $this->db->query($query)->row_array();

    }

    // KPI corporate
    function kpi_corporate($periode)
    {

        $query = "SELECT
                    'Reject PO' AS goal,
                    10 AS `target`,
                    ROUND(10, 1) AS target_persentase,
                    rcv.tgl_po,
                    COUNT(*) AS jml_po,
                    COUNT(*) AS actual,
                    
                    COUNT(IF(rcv.id_sts != 3,1,NULL)) AS jml_acc,
                    ROUND( ((COUNT(IF(rcv.id_sts != 3,1,NULL)) / COUNT(*)) * 100),1 ) AS p_jml_acc,
                    
                    COUNT(IF(rcv.id_sts = 3,1,NULL)) AS jml_rjc,
                    ROUND( ((COUNT(IF(rcv.id_sts = 3,1,NULL)) / COUNT(*)) * 100),1 ) AS p_jml_rjc,
                    ROUND( ((COUNT(IF(rcv.id_sts = 3,1,NULL)) / COUNT(*)) * 100),1 ) AS achieve_persentase
                    
                FROM
                    (
                        SELECT
                            x.purchase_number,
                            x.supplier AS id_supplier,
                            x.`status` AS id_sts,
                            z.`status` AS sts_po,
                            x.deadline,
                            SUBSTR(x.created_at,1,10) AS tgl_po,
                            x.estimasi_datang,
                            SUBSTR(x.gr_at,1,10) AS tgl_gr,
                            y.project,
                            DATEDIFF(SUBSTR(x.gr_at,1,10), x.estimasi_datang) AS leadtime,
                            CASE 
                                WHEN SUBSTR(x.gr_at,1,10) <= x.estimasi_datang THEN 'Ontime'
                            ELSE 'Late'
                            END AS sts_leadtime
                        FROM rsp_project_live.t_purchase AS x
                        LEFT JOIN rsp_project_live.m_project AS y ON x.project = y.id_project
                        LEFT JOIN rsp_project_live.m_status_po AS z ON z.id = x.`status`
                        WHERE SUBSTR(x.created_at,1,7) = '$periode'
                        AND x.`status` IN (3,4)
                    ) AS rcv
                ";

        return $this->db->query($query)->row_array();

    }

    // KPI corporate Project
    function kpi_project($id_project, $periode)
    {

        $query = "SELECT
                    'Reject PO' AS corporate_kpi,
                    10 AS `target`,
                    ROUND(10, 1) AS target_persentase,
                    rcv.tgl_po,
                    COUNT(*) AS jml_po,
                    
                    COUNT(IF(rcv.id_sts != 3,1,NULL)) AS jml_acc,
                    ROUND( ((COUNT(IF(rcv.id_sts != 3,1,NULL)) / COUNT(*)) * 100),1 ) AS p_jml_acc,
                    
                    COALESCE(COUNT(IF(rcv.id_sts = 3,1,NULL)),0) AS jml_rjc,
                    ROUND( ((COUNT(IF(rcv.id_sts = 3,1,NULL)) / COUNT(*)) * 100),1 ) AS p_jml_rjc,
                    ROUND( ((COUNT(IF(rcv.id_sts = 3,1,NULL)) / COUNT(*)) * 100),1 ) AS achieve_persentase
                    
                FROM
                    (
                        SELECT
                            x.purchase_number,
                            x.supplier AS id_supplier,
                            x.`status` AS id_sts,
                            z.`status` AS sts_po,
                            x.deadline,
                            SUBSTR(x.created_at,1,10) AS tgl_po,
                            x.estimasi_datang,
                            SUBSTR(x.gr_at,1,10) AS tgl_gr,
                            y.project,
                            DATEDIFF(SUBSTR(x.gr_at,1,10), x.estimasi_datang) AS leadtime,
                            CASE 
                                WHEN SUBSTR(x.gr_at,1,10) <= x.estimasi_datang THEN 'Ontime'
                            ELSE 'Late'
                            END AS sts_leadtime
                        FROM rsp_project_live.t_purchase AS x
                        LEFT JOIN rsp_project_live.m_project AS y ON x.project = y.id_project
                        LEFT JOIN rsp_project_live.m_status_po AS z ON z.id = x.`status`
                        WHERE SUBSTR(x.created_at,1,7) = '$periode'
                        AND x.project = '$id_project'
                    ) AS rcv
                ";

        return $this->db->query($query)->row_array();

    }

    // 1. leadtime plan housing vs tgl spk awal
    function leadtime_plan_housing ($id_project, $periode)
    {

        $query = "SELECT
                    SUBSTR(spk.tgl,1,7) AS bln,
                    COUNT(*) AS jml_po,
                    ROUND(100, 1) AS target_persentase,
                    
                    COUNT(IF(spk.sts_leadtime = 'Ontime',1,NULL)) AS jml_ontime,
                    ROUND( ((COUNT(IF(spk.sts_leadtime = 'Ontime',1,NULL)) / COUNT(*)) * 100),1 ) AS p_jml_ontime,
                    
                    COUNT(IF(spk.sts_leadtime = 'Late',1,NULL)) AS jml_late,
                    ROUND( ((COUNT(IF(spk.sts_leadtime = 'Late',1,NULL)) / COUNT(*)) * 100),1 ) AS p_jml_late,
                    ROUND( ((COUNT(IF(spk.sts_leadtime = 'Late',1,NULL)) / COUNT(*)) * 100),1 ) AS achieve_persentase
                    
                FROM
                    (
                        SELECT
                            x.id_spk,
                            x.tgl,
                            x.id_int,
                            x.tgl_awal,
                            DATEDIFF(x.tgl_awal, x.tgl) AS leadtime,
                            CASE 
                                WHEN DATEDIFF(x.tgl_awal, x.tgl) <= 3 THEN 'Ontime'
                            ELSE 'Late'
                            END AS sts_leadtime,
                            x.nama_konsumen,
                            x.project,
                            x.blok,
                            x.progres
                        FROM
                            (
                                SELECT
                                    t_spk.id_spk,
                                    SUBSTR( t_spk.created_at, 1, 10 ) AS tgl,
                                    t_spk.id_int,
                                    t_spk.tgl_awal,
                                    t_spk.id_project,
                                    m_konsumen.nama_konsumen,
                                    m_project.project,
                                    t_gci.blok,
                                    m_project_unit.progres
                                
                                FROM rsp_project_live.t_spk_new t_spk
                                JOIN rsp_project_live.t_gci ON t_gci.id_gci = t_spk.id_gci
                                JOIN rsp_project_live.m_konsumen ON m_konsumen.id_konsumen = t_gci.id_konsumen
                                JOIN rsp_project_live.m_project ON m_project.id_project = t_gci.id_project
                                LEFT JOIN rsp_project_live.m_project_unit ON m_project_unit.id_project = t_gci.id_project AND t_gci.blok = m_project_unit.blok 
                                WHERE SUBSTR( t_spk.created_at, 1, 7 ) = '$periode'  
                                AND m_project.id_project = '$id_project'
                                GROUP BY t_gci.id_project, t_gci.blok

                                UNION

                                SELECT
                                    t_spk.id_spk,
                                    SUBSTR( t_spk.created_at, 1, 10 ) AS tgl,
                                    'None' AS id_int,
                                    t_spk.tgl_awal,
                                    t_spk.id_project,
                                    '' AS nama_konsumen,
                                    m_project.project,
                                    m_project_unit.blok,
                                    m_project_unit.progres
                                
                                FROM rsp_project_live.t_spk_new t_spk
                                JOIN rsp_project_live.m_project ON m_project.id_project = t_spk.id_project
                                LEFT JOIN rsp_project_live.m_project_unit ON m_project_unit.id_project = t_spk.id_project
                                LEFT JOIN rsp_project_live.t_gci ON t_gci.id_project = m_project_unit.id_project AND t_gci.blok = m_project_unit.blok
                                WHERE t_spk.id_gci = ''
                                AND SUBSTR( t_spk.created_at, 1, 7 ) = '$periode' 
                                AND m_project.id_project = '$id_project'
                            ) AS x
                    ) AS spk
                ";

        return $this->db->query($query)->row_array();

    }

    // 2. leadtime spk awal vs tgl mulai
    function leadtime_spk_awal($id_project, $periode)
    {

        $query = "SELECT
                    SUBSTR(task.tgl_task,1,7) AS bln,
                    COUNT(*) AS jml_po,
                    ROUND(100, 1) AS target_persentase,
                    
                    COUNT(IF(task.sts_leadtime = 'Ontime',1,NULL)) AS jml_ontime,
                    ROUND( ((COUNT(IF(task.sts_leadtime = 'Ontime',1,NULL)) / COUNT(*)) * 100),1 ) AS p_jml_ontime,
                    
                    COUNT(IF(task.sts_leadtime = 'Late',1,NULL)) AS jml_late,
                    ROUND( ((COUNT(IF(task.sts_leadtime = 'Late',1,NULL)) / COUNT(*)) * 100),1 ) AS p_jml_late,
                    ROUND( ((COUNT(IF(task.sts_leadtime = 'Late',1,NULL)) / COUNT(*)) * 100),1 ) AS achieve_persentase
                    
                FROM
                    (
                        SELECT
                            x.id_task,
                            x.id_project,
                            x.project,
                            x.blok, 
                            x.tgl_task,
                            COALESCE(y.tgl_awal,CURRENT_DATE()) AS tgl_awal,
                            DATEDIFF(COALESCE(y.tgl_awal,CURRENT_DATE()), x.tgl_task) AS leadtime,
                            CASE 
                                WHEN DATEDIFF(COALESCE(y.tgl_awal,CURRENT_DATE()), x.tgl_task) <= 1 THEN 'Ontime'
                            ELSE 'Late'
                            END AS sts_leadtime
                        FROM
                            (
                                SELECT
                                    task.id_task,
                                    task.project AS id_project,
                                    task.blok,
                                    task.vendor,
                                    task.progres,
                                    SUBSTR(task.created_at,1,10) AS tgl_task,
                                    mp.project
                                FROM rsp_project_live.t_task_rumah AS task
                                LEFT JOIN rsp_project_live.m_project AS mp ON mp.id_project = task.project
                            --     WHERE task.project = 90 AND task.blok = 'J63'
                            ) AS x
                        LEFT JOIN rsp_project_live.t_spk_new AS y ON x.id_project = y.id_project AND x.blok = y.blok
                        WHERE SUBSTR(x.tgl_task,1,7) = '$periode'
                        AND x.id_project = '$id_project'
                        GROUP BY x.id_project, x.blok
                    ) AS task
                ";

        return $this->db->query($query)->row_array();

    }

    // 3. leadtime po vs receive
    function leadtime_po($id_project, $periode)
    {

        $query = "SELECT
                    SUBSTR(po.tgl_po,1,7) AS bln,
                    COUNT(*) AS jml_po,
                    ROUND(100, 1) AS target_persentase,
                    
                    COUNT(IF(po.sts_leadtime = 'Ontime',1,NULL)) AS jml_ontime,
                    ROUND( ((COUNT(IF(po.sts_leadtime = 'Ontime',1,NULL)) / COUNT(*)) * 100),1 ) AS p_jml_ontime,
                    
                    COUNT(IF(po.sts_leadtime = 'Late',1,NULL)) AS jml_late,
                    ROUND( ((COUNT(IF(po.sts_leadtime = 'Late',1,NULL)) / COUNT(*)) * 100),1 ) AS p_jml_late,
                    ROUND( ((COUNT(IF(po.sts_leadtime = 'Late',1,NULL)) / COUNT(*)) * 100),1 ) AS achieve_persentase

                FROM
                    (
                        SELECT
                            x.purchase_number,
                            x.supplier AS id_supplier,
                            x.deadline,
                            SUBSTR(x.created_at,1,10) AS tgl_po,
                            x.estimasi_datang,
                            SUBSTR(x.gr_at,1,10) AS tgl_gr,
                            y.project,
                            DATEDIFF(SUBSTR(x.gr_at,1,10), x.estimasi_datang) AS leadtime,
                            CASE 
                                WHEN SUBSTR(x.gr_at,1,10) <= x.estimasi_datang THEN 'Ontime'
                            ELSE 'Late'
                            END AS sts_leadtime
                        FROM rsp_project_live.t_purchase AS x
                        LEFT JOIN rsp_project_live.m_project AS y ON x.project = y.id_project
                        WHERE SUBSTR(x.created_at,1,7) = '$periode'
                        AND x.project = '$id_project'
                        AND x.status IN (4,5)
                    ) AS po
                ";

        return $this->db->query($query)->row_array();

    }

    // 4. jumlah reject material
    function jumlah_reject($id_project, $periode)
    {

        $query = "SELECT
                    'Reject PO' AS goal,
                    10 AS target,
                    rcv.tgl_po,
                    COUNT(*) AS jml_po,
                    ROUND(10, 1) AS target_persentase,
                    
                    COUNT(IF(rcv.id_sts != 3,1,NULL)) AS jml_acc,
                    ROUND( ((COUNT(IF(rcv.id_sts != 3,1,NULL)) / COUNT(*)) * 100),1 ) AS p_jml_acc,
                    
                    COUNT(IF(rcv.id_sts = 3,1,NULL)) AS jml_rjc,
                    ROUND( ((COUNT(IF(rcv.id_sts = 3,1,NULL)) / COUNT(*)) * 100),1 ) AS p_jml_rjc,
                    ROUND( ((COUNT(IF(rcv.id_sts = 3,1,NULL)) / COUNT(*)) * 100),1 ) AS achieve_persentase
                    
                FROM
                    (
                        SELECT
                            x.purchase_number,
                            x.supplier AS id_supplier,
                            x.`status` AS id_sts,
                            z.`status` AS sts_po,
                            x.deadline,
                            SUBSTR(x.created_at,1,10) AS tgl_po,
                            x.estimasi_datang,
                            SUBSTR(x.gr_at,1,10) AS tgl_gr,
                            y.project,
                            DATEDIFF(SUBSTR(x.gr_at,1,10), x.estimasi_datang) AS leadtime,
                            CASE 
                                WHEN SUBSTR(x.gr_at,1,10) <= x.estimasi_datang THEN 'Ontime'
                            ELSE 'Late'
                            END AS sts_leadtime
                        FROM rsp_project_live.t_purchase AS x
                        LEFT JOIN rsp_project_live.m_project AS y ON x.project = y.id_project
                        LEFT JOIN rsp_project_live.m_status_po AS z ON z.id = x.`status`
                        WHERE SUBSTR(x.created_at,1,7) = '$periode'
                        AND x.project = '$id_project'
                        AND x.status IN (2,3,4,5)
                    ) AS rcv
                ";

        return $this->db->query($query)->row_array();

    }


    
}