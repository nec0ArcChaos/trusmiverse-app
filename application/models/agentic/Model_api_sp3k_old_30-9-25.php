<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_api_sp3k extends CI_Model
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


    function get_all_rm()
    {

        $query = "SELECT
                    u.id_user,
                    u.employee_name AS `name`
                FROM
                    rsp_project_live.`user` u
                WHERE
                    u.id_user IN (18, 838, 24099)
                ";

        return $this->db->query($query)->result();

    }

    function get_rm($id_rm)
    {

        $query = "SELECT
                    u.id_user as id,
                    u.employee_name AS `name`
                FROM
                    rsp_project_live.`user` u
                WHERE
                    u.id_user = '$id_rm'
                ";

        return $this->db->query($query)->row_array();

    }

    // KPI corporate
    function kpi_corporate($periode)
    {

        $query = "SELECT
                    'Plan Berkas' AS goal,
                    COUNT(berkas.id_bic) AS jml_berkas,
                    ROUND(100, 1) AS target_persentase,
                    
                    tgt.target,
                    
                    COUNT(IF(berkas.hasil_inv = 1, 1, NULL)) AS actual,

                    CASE 
                        WHEN ROUND( ((COUNT(IF(berkas.hasil_inv = 1, 1, NULL)) / tgt.target) * 100), 2) >= 100 THEN 100
                    ELSE ROUND( ((COUNT(IF(berkas.hasil_inv = 1, 1, NULL)) / tgt.target) * 100), 2)
                    END AS achieve_persentase,

                    COUNT(IF(berkas.hasil_inv = 1 AND berkas.sts_ld = 'Ontime', 1, NULL)) AS hasil_ontime,
                    ROUND( ((COUNT(IF(berkas.hasil_inv = 1 AND berkas.sts_ld = 'Ontime', 1, NULL)) / COUNT(IF(berkas.hasil_inv = 1, 1, NULL))) * 100), 2) AS persentase_ontime,
                    
                    COUNT(IF(berkas.hasil_inv = 1 AND berkas.sts_ld = 'Late', 1, NULL)) AS hasil_late,
                    ROUND( ((COUNT(IF(berkas.hasil_inv = 1 AND berkas.sts_ld = 'Late', 1, NULL)) / COUNT(IF(berkas.hasil_inv = 1, 1, NULL))) * 100), 2) AS persentase_late

                FROM
                    (
                        SELECT
                            x.id_inv,
                            x.created_at,
                            x.updated_at,
                            x.leadtime,
                            x.leadtime_berkas,
                            CASE 
                                WHEN x.leadtime_berkas <= 14 THEN 'Ontime'
                            ELSE 'Late'
                            END AS sts_ld,
                            x.id_bic,
                            x.tgl_gci,
                            x.tgl_bic,
                            x.nama_konsumen,
                            x.lengkap,
                            x.hasil_inv,
                            x.id_konsumen,
                            x.id_gm,
                            x.gm,
                            x.id_project,
                            x.blok,
                            x.id_gci,
                            x.project
                        FROM
                            (
                                SELECT
                                    bic.id_bic,
                                    bic.id_gci,
                                    bic.tgl_bic,
                                    bic.hasil_bic,
                                    inv.id_inv,
                                    SUBSTR(inv.created_at,1,10) AS created_at,
                                    COALESCE((SUBSTR(inv.updated_at,1,10)),(SUBSTR(inv.created_at,1,10))) AS updated_at,
                                    DATEDIFF((COALESCE(inv.updated_at,inv.created_at)), inv.created_at) AS leadtime,
                                    DATEDIFF(SUBSTR(inv.created_at,1,10),SUBSTR(bic.tgl_bic,1,10)) AS leadtime_berkas,
                                    SUBSTR(gci.created_at,1,10) AS tgl_gci,
                                    kons.nama_konsumen,
                                    hasil_inv.lengkap AS lengkap,
                                    inv.hasil_inv,
                                    gci.id_konsumen,
                                    gci.id_gm,
                                    gm.username AS user_gm,
                                    gm.employee_name AS gm,
                                    gci.id_project,
                                    gci.blok,
                                    mp.project
                                FROM
                                    rsp_project_live.t_bic AS bic
                                LEFT JOIN rsp_project_live.t_gci AS gci ON bic.id_gci = gci.id_gci
                                LEFT JOIN rsp_project_live.t_inventory AS inv ON bic.id_bic = inv.id_bic
                                LEFT JOIN rsp_project_live.m_konsumen AS kons ON kons.id_konsumen = gci.id_konsumen
                                LEFT JOIN rsp_project_live.m_pekerjaan AS pekerjaan ON pekerjaan.id_pekerjaan = kons.id_pekerjaan
                                LEFT JOIN rsp_project_live.m_status AS hasil_inv ON hasil_inv.id_status = inv.hasil_inv
                                LEFT JOIN rsp_project_live.t_interview AS `int` ON `int`.id_inv = inv.id_inv
                                LEFT JOIN rsp_project_live.m_project AS mp ON mp.id_project = gci.id_project
                                LEFT JOIN rsp_project_live.user AS marketing ON marketing.id_user = gci.created_by
                                LEFT JOIN rsp_project_live.user AS gm ON gm.id_user = marketing.id_gm
                                WHERE SUBSTR(bic.created_at,1,7) = '$periode'
                                AND bic.hasil_bic IN (1,2)
                                AND gci.id_gm IN (18, 838, 24099)
                                ORDER BY inv.id_inv DESC
                            ) AS x
                    ) AS berkas
                LEFT JOIN
                    (
                        SELECT
                            periode,
                            SUM(target_sp3k) AS `target`
                        FROM rsp_project_live.m_target_monthly_rm
                        WHERE periode = '$periode'
                        AND id_rm IN (18, 838, 24099)
                    ) AS tgt
                ON '$periode' = tgt.periode

                ";

        return $this->db->query($query)->row_array();

    }

    // KPI corporate RM
    function kpi_rm($id_rm, $periode)
    {

        $query = "SELECT
                    'Plan Berkas' AS goal,
                    COUNT(berkas.id_bic) AS jml_berkas,
                    ROUND(100, 1) AS target_persentase,
                    
                    tgt.target,
                    
                    COUNT(IF(berkas.hasil_inv = 1, 1, NULL)) AS actual,

                    CASE 
                        WHEN ROUND( ((COUNT(IF(berkas.hasil_inv = 1, 1, NULL)) / tgt.target) * 100), 2) >= 100 THEN 100
                    ELSE ROUND( ((COUNT(IF(berkas.hasil_inv = 1, 1, NULL)) / tgt.target) * 100), 2)
                    END AS achieve_persentase,

                    COUNT(IF(berkas.hasil_inv = 1 AND berkas.sts_ld = 'Ontime', 1, NULL)) AS hasil_ontime,
                    ROUND( ((COUNT(IF(berkas.hasil_inv = 1 AND berkas.sts_ld = 'Ontime', 1, NULL)) / COUNT(IF(berkas.hasil_inv = 1, 1, NULL))) * 100), 2) AS persentase_ontime,
                    
                    COUNT(IF(berkas.hasil_inv = 1 AND berkas.sts_ld = 'Late', 1, NULL)) AS hasil_late,
                    ROUND( ((COUNT(IF(berkas.hasil_inv = 1 AND berkas.sts_ld = 'Late', 1, NULL)) / COUNT(IF(berkas.hasil_inv = 1, 1, NULL))) * 100), 2) AS persentase_late

                FROM
                    (
                        SELECT
                            x.id_inv,
                            x.created_at,
                            x.updated_at,
                            x.leadtime,
                            x.leadtime_berkas,
                            CASE 
                                WHEN x.leadtime_berkas <= 14 THEN 'Ontime'
                            ELSE 'Late'
                            END AS sts_ld,
                            x.id_bic,
                            x.tgl_gci,
                            x.tgl_bic,
                            x.nama_konsumen,
                            x.lengkap,
                            x.hasil_inv,
                            x.id_konsumen,
                            x.id_gm,
                            x.gm,
                            x.id_project,
                            x.blok,
                            x.id_gci,
                            x.project
                        FROM
                            (
                                SELECT
                                    bic.id_bic,
                                    bic.id_gci,
                                    bic.tgl_bic,
                                    bic.hasil_bic,
                                    inv.id_inv,
                                    SUBSTR(inv.created_at,1,10) AS created_at,
                                    COALESCE((SUBSTR(inv.updated_at,1,10)),(SUBSTR(inv.created_at,1,10))) AS updated_at,
                                    DATEDIFF((COALESCE(inv.updated_at,inv.created_at)), inv.created_at) AS leadtime,
                                    DATEDIFF(SUBSTR(inv.created_at,1,10),SUBSTR(bic.tgl_bic,1,10)) AS leadtime_berkas,
                                    SUBSTR(gci.created_at,1,10) AS tgl_gci,
                                    kons.nama_konsumen,
                                    hasil_inv.lengkap AS lengkap,
                                    inv.hasil_inv,
                                    gci.id_konsumen,
                                    gci.id_gm,
                                    gm.username AS user_gm,
                                    gm.employee_name AS gm,
                                    gci.id_project,
                                    gci.blok,
                                    mp.project
                                FROM
                                    rsp_project_live.t_bic AS bic
                                LEFT JOIN rsp_project_live.t_gci AS gci ON bic.id_gci = gci.id_gci
                                LEFT JOIN rsp_project_live.t_inventory AS inv ON bic.id_bic = inv.id_bic
                                LEFT JOIN rsp_project_live.m_konsumen AS kons ON kons.id_konsumen = gci.id_konsumen
                                LEFT JOIN rsp_project_live.m_pekerjaan AS pekerjaan ON pekerjaan.id_pekerjaan = kons.id_pekerjaan
                                LEFT JOIN rsp_project_live.m_status AS hasil_inv ON hasil_inv.id_status = inv.hasil_inv
                                LEFT JOIN rsp_project_live.t_interview AS `int` ON `int`.id_inv = inv.id_inv
                                LEFT JOIN rsp_project_live.m_project AS mp ON mp.id_project = gci.id_project
                                LEFT JOIN rsp_project_live.user AS marketing ON marketing.id_user = gci.created_by
                                LEFT JOIN rsp_project_live.user AS gm ON gm.id_user = marketing.id_gm
                                WHERE SUBSTR(bic.created_at,1,7) = '$periode'
                                AND gci.id_gm = '$id_rm'
                                AND bic.hasil_bic IN (1,2)
                                AND gci.id_gm IN (18, 838, 24099)
                                ORDER BY inv.id_inv DESC
                            ) AS x
                    ) AS berkas
                LEFT JOIN
                    (
                        SELECT
                            periode,
                            SUM(target_sp3k) AS `target`
                        FROM rsp_project_live.m_target_monthly_rm
                        WHERE periode = '$periode'
                        AND id_rm = '$id_rm'
                        AND id_rm IN (18, 838, 24099)
                    ) AS tgt
                ON '$periode' = tgt.periode

                ";

        return $this->db->query($query)->row_array();

    }

    // berkas belum lengkap dan leadtime berkas lengkap
    function data_berkas($id_rm, $periode)
    {

        $query = "SELECT
                    berkas.id_gm,
                    berkas.gm,

                    ROUND(100, 1) AS target_persentase,

                    --   COUNT(berkas.id_inv) AS jml_berkas,
                    COUNT(berkas.id_bic) AS jml_berkas,
                    
                    COUNT(IF(berkas.hasil_inv = 1, 1, NULL)) AS jml_berkas_lengkap,
                    ROUND( ((COUNT(IF(berkas.hasil_inv = 1, 1, NULL)) / COUNT(berkas.id_bic)) * 100), 2) AS p_jml_berkas_lengkap,
                    
                    COUNT(IF(berkas.hasil_inv != 1, 1, NULL)) AS jml_berkas_blengkap,
                    ROUND( ((COUNT(IF(berkas.hasil_inv != 1, 1, NULL)) / COUNT(berkas.id_bic)) * 100), 2) AS p_jml_berkas_blengkap,
                    
                    COUNT(IF(berkas.hasil_inv = 1 AND berkas.sts_ld = 'Ontime', 1, NULL)) AS ld_lengkap_ontime,
                    ROUND( ((COUNT(IF(berkas.hasil_inv = 1 AND berkas.sts_ld = 'Ontime', 1, NULL)) / COUNT(berkas.id_inv)) * 100), 2) AS p_ld_lengkap_ontime,
                    
                    COUNT(IF(berkas.hasil_inv = 1 AND berkas.sts_ld = 'Late', 1, NULL)) AS ld_lengkap_late,
                    ROUND( ((COUNT(IF(berkas.hasil_inv = 1 AND berkas.sts_ld = 'Late', 1, NULL)) / COUNT(berkas.id_inv)) * 100), 2) AS p_ld_lengkap_late

                    FROM
                    (
                        SELECT
                            x.id_inv,
                            x.created_at,
                            x.updated_at,
                            x.leadtime,
                            x.leadtime_berkas,
                            CASE 
                                WHEN x.leadtime_berkas <= 14 THEN 'Ontime'
                            ELSE 'Late'
                            END AS sts_ld,
                            x.id_bic,
                            x.tgl_gci,
                            x.tgl_bic,
                            x.nama_konsumen,
                            x.lengkap,
                            x.hasil_inv,
                            x.id_konsumen,
                            x.id_gm,
                            x.gm,
                            x.id_project,
                            x.blok,
                            x.id_gci,
                            x.project
                        FROM
                            (
                                SELECT
                                bic.id_bic,
                                bic.id_gci,
                                bic.tgl_bic,
                                bic.hasil_bic,
                                inv.id_inv,
                                SUBSTR(inv.created_at,1,10) AS created_at,
                                COALESCE((SUBSTR(inv.updated_at,1,10)),(SUBSTR(inv.created_at,1,10))) AS updated_at,
                                DATEDIFF((COALESCE(inv.updated_at,inv.created_at)), inv.created_at) AS leadtime,
                                DATEDIFF(SUBSTR(inv.created_at,1,10),SUBSTR(bic.tgl_bic,1,10)) AS leadtime_berkas,
                                SUBSTR(gci.created_at,1,10) AS tgl_gci,
                                kons.nama_konsumen,
                                hasil_inv.lengkap AS lengkap,
                                inv.hasil_inv,
                                gci.id_konsumen,
                                gci.id_gm,
                                gm.username AS user_gm,
                                gm.employee_name AS gm,
                                gci.id_project,
                                gci.blok,
                                mp.project
                                FROM
                                rsp_project_live.t_bic AS bic
                                LEFT JOIN rsp_project_live.t_gci AS gci ON bic.id_gci = gci.id_gci
                                LEFT JOIN rsp_project_live.t_inventory AS inv ON bic.id_bic = inv.id_bic
                                LEFT JOIN rsp_project_live.m_konsumen AS kons ON kons.id_konsumen = gci.id_konsumen
                                LEFT JOIN rsp_project_live.m_pekerjaan AS pekerjaan ON pekerjaan.id_pekerjaan = kons.id_pekerjaan
                                LEFT JOIN rsp_project_live.m_status AS hasil_inv ON hasil_inv.id_status = inv.hasil_inv
                                LEFT JOIN rsp_project_live.t_interview AS `int` ON `int`.id_inv = inv.id_inv
                                LEFT JOIN rsp_project_live.m_project AS mp ON mp.id_project = gci.id_project
                                LEFT JOIN rsp_project_live.user AS marketing ON marketing.id_user = gci.created_by
                                LEFT JOIN rsp_project_live.user AS gm ON gm.id_user = marketing.id_gm
                                WHERE SUBSTR(bic.created_at,1,7) = '$periode'
                                AND bic.hasil_bic IN (1,2)
                                AND gci.id_gm = '$id_rm' 
                                AND gci.id_gm IN (18, 838, 24099)
                                ORDER BY inv.id_inv DESC
                            ) AS x
                    ) AS berkas
                    GROUP BY berkas.id_gm
                ";

        return $this->db->query($query)->row_array();

    }

    // leadtime berkas lengkap
    function data_leadtime_berkas($id_rm, $periode)
    {

        $query = "SELECT
                    berkas.id_gm,
                    berkas.gm,

                    ROUND(100, 1) AS target_persentase,

                    COUNT(berkas.id_bic) AS jml_berkas,
                    
                    COUNT(IF(berkas.hasil_inv = 1, 1, NULL)) AS jml_berkas_lengkap,
                    ROUND( ((COUNT(IF(berkas.hasil_inv = 1, 1, NULL)) / COUNT(berkas.id_bic)) * 100), 2) AS p_jml_berkas_lengkap,
                    
                    COUNT(IF(berkas.hasil_inv != 1, 1, NULL)) AS jml_berkas_blengkap,
                    ROUND( ((COUNT(IF(berkas.hasil_inv != 1, 1, NULL)) / COUNT(berkas.id_bic)) * 100), 2) AS p_jml_berkas_blengkap,
                    
                    COUNT(IF(berkas.hasil_inv = 1 AND berkas.sts_ld = 'Ontime', 1, NULL)) AS ld_lengkap_ontime,
                    ROUND( ((COUNT(IF(berkas.hasil_inv = 1 AND berkas.sts_ld = 'Ontime', 1, NULL)) / COUNT(berkas.id_inv)) * 100), 2) AS p_ld_lengkap_ontime,
                    
                    COUNT(IF(berkas.hasil_inv = 1 AND berkas.sts_ld = 'Late', 1, NULL)) AS ld_lengkap_late,
                    ROUND( ((COUNT(IF(berkas.hasil_inv = 1 AND berkas.sts_ld = 'Late', 1, NULL)) / COUNT(berkas.id_inv)) * 100), 2) AS p_ld_lengkap_late

                FROM
                    (
                        SELECT
                            x.id_inv,
                            x.created_at,
                            x.updated_at,
                            x.leadtime,
                            x.leadtime_berkas,
                            CASE 
                                WHEN x.leadtime_berkas <= 14 THEN 'Ontime'
                            ELSE 'Late'
                            END AS sts_ld,
                            x.id_bic,
                            x.tgl_gci,
                            x.tgl_bic,
                            x.nama_konsumen,
                            x.lengkap,
                            x.hasil_inv,
                            x.id_konsumen,
                            x.id_gm,
                            x.gm,
                            x.id_project,
                            x.blok,
                            x.id_gci,
                            x.project
                        FROM
                            (
                                SELECT
                                    bic.id_bic,
                                    bic.id_gci,
                                    bic.tgl_bic,
                                    bic.hasil_bic,
                                    inv.id_inv,
                                    SUBSTR(inv.created_at,1,10) AS created_at,
                                    COALESCE((SUBSTR(inv.updated_at,1,10)),(SUBSTR(inv.created_at,1,10))) AS updated_at,
                                    DATEDIFF((COALESCE(inv.updated_at,inv.created_at)), inv.created_at) AS leadtime,
                                    DATEDIFF(SUBSTR(inv.created_at,1,10),SUBSTR(bic.tgl_bic,1,10)) AS leadtime_berkas,
                                    SUBSTR(gci.created_at,1,10) AS tgl_gci,
                                    kons.nama_konsumen,
                                    hasil_inv.lengkap AS lengkap,
                                    inv.hasil_inv,
                                    gci.id_konsumen,
                                    gci.id_gm,
                                    gm.username AS user_gm,
                                    gm.employee_name AS gm,
                                    gci.id_project,
                                    gci.blok,
                                    mp.project
                                FROM
                                    rsp_project_live.t_bic AS bic
                                LEFT JOIN rsp_project_live.t_gci AS gci ON bic.id_gci = gci.id_gci
                                LEFT JOIN rsp_project_live.t_inventory AS inv ON bic.id_bic = inv.id_bic
                                LEFT JOIN rsp_project_live.m_konsumen AS kons ON kons.id_konsumen = gci.id_konsumen
                                LEFT JOIN rsp_project_live.m_pekerjaan AS pekerjaan ON pekerjaan.id_pekerjaan = kons.id_pekerjaan
                                LEFT JOIN rsp_project_live.m_status AS hasil_inv ON hasil_inv.id_status = inv.hasil_inv
                                LEFT JOIN rsp_project_live.t_interview AS `int` ON `int`.id_inv = inv.id_inv
                                LEFT JOIN rsp_project_live.m_project AS mp ON mp.id_project = gci.id_project
                                LEFT JOIN rsp_project_live.user AS marketing ON marketing.id_user = gci.created_by
                                LEFT JOIN rsp_project_live.user AS gm ON gm.id_user = marketing.id_gm
                                WHERE SUBSTR(bic.created_at,1,7) = '$periode'
                                AND bic.hasil_bic IN (1,2)
                                AND gci.id_gm = '$id_rm' 
                                AND gci.id_gm IN (18, 838, 24099)
                                ORDER BY inv.id_inv DESC
                            ) AS x
                    ) AS berkas
                    GROUP BY berkas.id_gm
                ";

        return $this->db->query($query)->row_array();

    }

    // DP Customer : sisa ar bank
    function data_dp_customer($id_rm, $periode)
    {

        $query = "SELECT
                    dp.id_gm,
                    dp.gm,

                    ROUND(100, 1) AS target_persentase,
                    
                    COUNT(dp.id_spr) AS jml_data,
                    
                    COUNT(IF(dp.sisa_ar = 0, 1, NULL)) AS jml_ar_lunas,
                    ROUND( ((COUNT(IF(dp.sisa_ar = 0, 1, NULL)) / COUNT(dp.id_spr)) * 100), 2) AS p_jml_ar_lunas,
                    
                    COUNT(IF((dp.sisa_ar > 0 || dp.sisa_ar < 0), 1, NULL)) AS jml_ar_blunas,
                    ROUND( ((COUNT(IF((dp.sisa_ar > 0 || dp.sisa_ar < 0), 1, NULL)) / COUNT(dp.id_spr)) * 100), 2) AS p_jml_ar_blunas
                    
                FROM
                    (
                        SELECT
                            v_spr.id_spr,
                            v_spr.id_gci,
                            v_spr.booking,
                            v_spr.total_ar,
                            v_spr.total_ar_new,
                            v_spr.terima_kunci,
                            v_spr.dp,
                            v_spr.income,
                            v_spr.sisa_ar,
                            
                            gci.id_project,
                            gci.blok,
                            gci.id_konsumen,
                            gci.id_gm,
                            
                            gm.username AS nama_gm,
                            gm.employee_name AS gm,
                            
                            mp.project
                            
                        FROM
                            rsp_project_live.`view_spr` AS v_spr
                        JOIN rsp_project_live.t_gci AS gci ON v_spr.id_gci = gci.id_gci
                        JOIN rsp_project_live.m_project AS mp ON mp.id_project = gci.id_project
                        LEFT JOIN rsp_project_live.`user` AS gm ON gm.id_user = gci.id_gm
                        WHERE SUBSTR(v_spr.created_at, 1, 7) = '$periode'
                        AND gci.id_gm = '$id_rm'
                        AND gci.id_gm IN (18, 838, 24099)
                    ) AS dp
                GROUP BY dp.id_gm
                ";

        return $this->db->query($query)->row_array();

    }

    // credit scoring
    function data_credit_scoring($id_rm, $periode)
    {

        $query = "SELECT
                    SUBSTR(profilling.tgl_gci,1,7) AS bln,
                    profilling.id_gm,
                    profilling.gm,

                    ROUND(100, 1) AS target_persentase,
                    
                    COUNT(profilling.ket_prediksi) AS jml_prediksi,
                    
                    COUNT(IF(profilling.ket_prediksi = 'Layak', 1, NULL)) AS jml_prediksi_layak,
                    ROUND( ((COUNT(IF(profilling.ket_prediksi = 'Layak', 1, NULL)) / COUNT(profilling.ket_prediksi)) * 100), 2) AS p_jml_prediksi_layak,
                    
                    COUNT(IF(profilling.ket_prediksi = 'Tidak Layak', 1, NULL)) AS jml_prediksi_tlayak,
                    ROUND( ((COUNT(IF(profilling.ket_prediksi = 'Tidak Layak', 1, NULL)) / COUNT(profilling.ket_prediksi)) * 100), 2) AS p_jml_prediksi_tlayak

                FROM
                    (
                        SELECT
                            a.id_gci,
                            a.tgl_gci,
                            a.cicilan_bln,
                            a.total_cicilan,
                            a.blok,
                            a.tgl_bic,
                            a.tgl_sp3k,
                            a.hasil_bic,
                            a.id_project,
                            a.project,
                            a.kategori,
                            a.`event`,
                            a.nama_konsumen,
                            a.usia,
                            a.pendapatan,
                            a.biaya_hidup,
                            a.jenis,
                            a.prediksi_cicilan,
                            a.sisa_gaji,
                            a.`status`,
                            a.pekerjaan,
                            
                            a.id_gm,
                            a.gm,
                            
                            a.bobot_gaji,
                            a.bobot_s_gaji,
                            a.bobot_s_kons,
                            a.bobot_kerja,
                            a.bobot_all,
                            
                            a.sts_bic,
                            a.sp3k,
                            a.ket_prediksi,
                            a.kat_prospective,
                            a.id_kat_prospective,
                            
                            CASE 
                                WHEN ( (a.hasil_int = 1 AND a.ket_prediksi = 'Layak') OR (a.hasil_int IN (2,4,6,7,8,12,13,15) AND a.ket_prediksi = 'Tidak Layak') ) THEN 'Sesuai'
                                WHEN ( (a.hasil_int = 1 AND a.ket_prediksi = 'Tidak Layak') OR (a.hasil_int IN (2,4,6,7,8,12,13,15) AND a.ket_prediksi = 'Layak') ) THEN 'Tidak Sesuai'
                                WHEN ( a.hasil_int IS NULL AND (a.ket_prediksi = 'Layak' OR a.ket_prediksi = 'Tidak Layak') ) THEN 'Waiting SP3K'
                            ELSE 'Waiting SP3K'
                            END AS keterangan,

                            a.status_proses,
                            a.tgl_inv
                                                                                                                        
                        FROM rsp_project_live.v_credit_scoring AS a
                        WHERE SUBSTR(a.tgl_gci, 1, 7) = '$periode'
                        AND a.id_gm = '$id_rm'
                        AND a.id_gm IN (18, 838, 24099)
                    ) AS profilling
                    GROUP BY profilling.id_gm
                    ORDER BY COUNT(profilling.ket_prediksi) DESC
                ";

        return $this->db->query($query)->row_array();

    }

    // data reject after bic
    function data_reject($id_rm, $periode)
    {

        $query = "SELECT
                    reject.id_gm,
                    reject.gm,

                    ROUND(100, 1) AS target_persentase,
                    
                    COUNT(*) AS jml_data,
                    
                    COUNT(IF(reject.status_proses IN (33,44,48,49,50,51,52,54,442,444,445,446,448,449,450),1, NULL)) AS jml_reject,
                    ROUND( ((COUNT(IF(reject.status_proses IN (33,44,48,49,50,51,52,54,442,444,445,446,448,449,450),1, NULL)) / COUNT(*)) * 100), 2) AS p_jml_reject,
                    
                    COUNT(IF(reject.status_proses NOT IN (33,44,48,49,50,51,52,54,442,444,445,446,448,449,450),1, NULL)) AS jml_acc,
                    ROUND( ((COUNT(IF(reject.status_proses NOT IN (33,44,48,49,50,51,52,54,442,444,445,446,448,449,450),1, NULL)) / COUNT(*)) * 100), 2) AS p_jml_acc
                    
                FROM
                    (
                        SELECT
                            x.created_at,
                            x.id_gci,
                            x.id_kategori,
                            x.project,
                            x.blok,
                            x.progres,
                            x.id_gm,
                            x.gm,
                            x.kategori,
                            x.status_proses,
                            y.status_proses AS nama_proses,
                            x.nama_konsumen,
                            x.nama_lama,
                            x.no_hp,
                            x.pekerjaan,
                            x.hasil_bic,
                            x.status_bic,
                            x.tgl_inv,
                            x.hasil_inv,
                            x.status_inv
                        
                        FROM
                            (
                                SELECT
                                    gci.created_at,
                                    gci.id_gci,
                                    gci.id_kategori,
                                    mp.project,
                                    gci.blok,
                                    mpu.progres,
                                    gci.id_gm,
                                    gm.employee_name AS gm,
                                    kat.kategori,
                                    rsp_project_live.status_proses (
                                                    gci.id_kategori,
                                                    income.dp,
                                                    mp.id_project_tipe,
                                                    t_bic.hasil_bic,
                                                    inv.hasil_inv,
                                                    `int`.hasil_int,
                                                    `int`.tgl_interview,
                                                    akad.hasil_akad,
                                                    spr.jenis,
                                                    gci.blok,
                                                    gci.reject_berkas 
                                                ) AS status_proses,
                                    kons.nama_konsumen,
                                    ubah_kons.nama_lama,
                                    COALESCE(kons.no_hp, '-') AS no_hp,

                                    pekerjaan.pekerjaan,

                                    CASE
                                        WHEN gci.reject_berkas = 1 AND t_bic.hasil_bic IS NULL THEN 0
                                    ELSE t_bic.hasil_bic
                                    END AS hasil_bic,
                                    
                                    CASE
                                        WHEN sts_bic.id_status = 11 AND t_bic.hasil_bic_before = 1 THEN 'TA'
                                        WHEN sts_bic.id_status = 11 AND t_bic.hasil_bic_before = 2 THEN 'Coll 1'
                                    ELSE sts_bic.`status`
                                    END AS status_bic,

                                    SUBSTR(COALESCE(inv.updated_at, inv.created_at), 1, 10) AS tgl_inv,
                                    inv.hasil_inv,
                                    lengkap.lengkap AS status_inv

                                FROM
                                    rsp_project_live.t_gci AS gci
                                LEFT JOIN rsp_project_live.m_project AS mp ON mp.id_project = gci.id_project
                                LEFT JOIN rsp_project_live.m_project_unit AS mpu ON (mpu.id_project = gci.id_project AND REPLACE(gci.blok, 'RD-', '') = mpu.blok)
                                LEFT JOIN rsp_project_live.user AS view_manager ON view_manager.id_user = gci.manager
                                LEFT JOIN rsp_project_live.m_kategori AS kat ON kat.id_kategori = gci.id_kategori
                                LEFT JOIN rsp_project_live.m_konsumen AS kons ON kons.id_konsumen = gci.id_konsumen
                                LEFT JOIN rsp_project_live.m_pekerjaan AS pekerjaan ON pekerjaan.id_pekerjaan = kons.id_pekerjaan
                                LEFT JOIN rsp_project_live.t_bic ON t_bic.id_gci = gci.id_gci
                                LEFT JOIN rsp_project_live.t_inventory AS inv ON inv.id_bic = t_bic.id_bic
                                LEFT JOIN rsp_project_live.t_interview AS `int` ON `int`.id_gci = gci.id_gci
                                LEFT JOIN rsp_project_live.t_spk AS spk ON spk.id_gci = gci.id_gci
                                LEFT JOIN rsp_project_live.t_akad AS akad ON akad.id_konsumen = gci.id_konsumen
                                LEFT JOIN rsp_project_live.m_status_bic AS sts_bic ON sts_bic.id_status = t_bic.hasil_bic
                                LEFT JOIN rsp_project_live.m_status AS lengkap ON lengkap.id_status = inv.hasil_inv
                                LEFT JOIN rsp_project_live.m_status AS berkas ON berkas.id_status = inv.hasil_berkas
                                
                                LEFT JOIN rsp_project_live.t_spr AS spr ON spr.id_gci = gci.id_gci

                                LEFT JOIN rsp_project_live.t_perubahan_konsumen AS ubah_kons ON ubah_kons.id_konsumen = gci.id_konsumen
                                LEFT JOIN rsp_project_live.user AS gm ON gm.id_user = gci.id_gm
                                LEFT JOIN
                                    (
                                        SELECT
                                            t_income.id_gci,
                                            sum(t_income.nominal) AS dp
                                        FROM rsp_project_live.t_income AS t_income
                                        LEFT JOIN rsp_project_live.t_gci AS t_gci ON t_gci.id_gci = t_income.id_gci
                                        WHERE t_income.id_rek NOT IN ('640.01','640.05')
                                        GROUP BY t_income.id_gci
                                    ) income ON income.id_gci = gci.id_gci
                                LEFT JOIN
                                    (
                                        SELECT
                                            t_income.id_gci,
                                            COALESCE(t_income.channel,'') AS channel,
                                            SUM(t_income.nominal) AS booking
                                        FROM rsp_project_live.t_income AS t_income
                                        LEFT JOIN rsp_project_live.t_gci AS t_gci ON t_gci.id_gci = t_income.id_gci
                                        WHERE
                                            t_income.id_rek IN ('640.01')
                                        GROUP BY t_income.id_gci
                                    ) booking ON booking.id_gci = gci.id_gci
                                LEFT JOIN
                                    (
                                        SELECT
                                            t_bic.id_gci,
                                            SUBSTR(t_bic.updated_at, 1, 10) AS tgl_rjc
                                        FROM rsp_project_live.t_bic AS t_bic
                                        LEFT JOIN rsp_project_live.t_gci AS t_gci ON t_gci.id_gci = t_bic.id_gci
                                        WHERE t_bic.hasil_bic NOT IN (1, 2, 10, 11)
                                        AND t_gci.id_kategori IN (3, 4)
                                    ) AS bic ON bic.id_gci = gci.id_gci
                                LEFT JOIN 
                                    (
                                        SELECT
                                            (
                                                CASE
                                                    WHEN m_konsumen.usia >= 21 AND m_konsumen.usia <= 35 THEN 10
                                                    WHEN m_konsumen.usia >= 36 AND m_konsumen.usia <= 45 THEN 6
                                                    WHEN m_konsumen.usia > 45 THEN 4
                                                ELSE 4
                                                END + CASE m_konsumen.id_pekerjaan
                                                    WHEN 1 THEN 7 -- 1 : PNS
                                                    WHEN 2 THEN 6 -- 2 : TNI-POLRI
                                                    WHEN 3 THEN 10 -- 3 : Karyawan Swasta
                                                    WHEN 4 THEN 6 -- 4 : Wirausaha
                                                    WHEN 5 THEN 6 -- 5 : BUMN
                                                    WHEN 6 THEN 6 -- 6 : BUMD
                                                END + CASE
                                                    WHEN COALESCE(m_konsumen.pendapatan, 0) <= 3000000 THEN 0
                                                    WHEN COALESCE(m_konsumen.pendapatan, 0) > 3000000 AND COALESCE(m_konsumen.pendapatan, 0) < 4500000 THEN 6
                                                    WHEN COALESCE(m_konsumen.pendapatan, 0) >= 4500000 AND COALESCE(m_konsumen.pendapatan, 0) <= 6000000 THEN 10
                                                    ELSE 9
                                                END + CASE WHEN m_konsumen.id_status = 2 THEN 10
                                                    ELSE 5
                                                END
                                            ) AS value,
                                            m_konsumen.id_konsumen
                                        FROM
                                            rsp_project_live.m_konsumen AS m_konsumen
                                    ) peluang_akad ON peluang_akad.id_konsumen = gci.id_konsumen
                                WHERE SUBSTR(gci.created_at, 1, 7) = '$periode'
                                AND gci.id_gm = '$id_rm'
                                AND gci.id_kategori IN ( 2.1,3,4 )
                                GROUP BY gci.id_gci
                            ) AS x
                        LEFT JOIN rsp_project_live.m_status_proses AS y ON x.status_proses = y.id_status_proses
                        WHERE x.id_gm = '$id_rm'
                    ) AS reject
                GROUP BY reject.id_gm
                ";

        return $this->db->query($query)->row_array();

    }

    // bangunan < 30%
    function data_bangun_30($id_rm, $periode)
    {

        $query = "SELECT
                    bangun.id_gm,
                    bangun.gm,

                    ROUND(100, 1) AS target_persentase,
                    
                    COUNT(bangun.id_gci) AS jml_data,
                    
                    COUNT(IF(bangun.progres >= 30, 1, NULL)) AS jml_t30,
                    ROUND( ((COUNT(IF(bangun.progres >= 30, 1, NULL)) / COUNT(bangun.id_gci)) * 100), 2) AS p_jml_t30,
                    
                    COUNT(IF(bangun.progres < 30, 1, NULL)) AS jml_30,
                    ROUND( ((COUNT(IF(bangun.progres < 30, 1, NULL)) / COUNT(bangun.id_gci)) * 100), 2) AS p_jml_30
                    
                FROM
                    (
                        SELECT
                            t_gci.created_at,
                            t_gci.id_gci,
                            t_gci.id_kategori,
                            t_gci.id_gm,
                            gm.username AS nama_gm,
                            gm.employee_name AS gm,
                            m_project.project,
                            t_gci.blok,
                            m_project_unit.progres,
                            m_konsumen.nama_konsumen,
                            t_perubahan_konsumen.nama_lama,
                            m_project.leadtime,
                            CASE 
                                WHEN COALESCE(m_project_unit.progres,0) = 100 THEN CONCAT(DATEDIFF(CURRENT_DATE, m_project_unit.tgl_vendor),' Hari') 
                            ELSE '-'
                            END AS umur_bangunan
                        FROM rsp_project_live.t_gci AS t_gci
                        LEFT JOIN rsp_project_live.m_project AS m_project ON m_project.id_project = t_gci.id_project
                        LEFT JOIN rsp_project_live.m_project_unit AS m_project_unit ON (m_project_unit.id_project = t_gci.id_project AND REPLACE(t_gci.blok, 'RD-', '') = m_project_unit.blok)
                        LEFT JOIN rsp_project_live.m_konsumen AS m_konsumen ON m_konsumen.id_konsumen = t_gci.id_konsumen
                        LEFT JOIN rsp_project_live.t_perubahan_konsumen AS t_perubahan_konsumen ON t_perubahan_konsumen.id_konsumen = t_gci.id_konsumen
                        LEFT JOIN rsp_project_live.`user` AS gm ON t_gci.id_gm = gm.id_user
                        WHERE SUBSTR(t_gci.created_at, 1, 7) = '$periode'
                        AND t_gci.id_kategori IN ( 2.1,3,4 )
                        AND t_gci.id_gm = '$id_rm'
                        AND t_gci.id_gm IN (18, 838, 24099)
                        GROUP BY t_gci.id_gci
                    ) AS bangun
                WHERE bangun.id_gm IN (18, 838, 24099)
                GROUP BY bangun.id_gm
                ";

        return $this->db->query($query)->row_array();

    }

    
}