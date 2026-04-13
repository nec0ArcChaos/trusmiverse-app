<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_api_pemberkasan extends CI_Model
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

    function get_rm($id_rm) {
        $query = "SELECT
                u.id_user as id,
                u.employee_name AS `name`
            FROM
                rsp_project_live.`user` u
            WHERE
                u.id_user = '$id_rm'";
        return $this->db->query($query)->row_array();
    }
    function kpi_rm($id_rm,$periode){
        $query = "SELECT
            'Plan SP3K' AS goal,
            tgci.id_gm AS id_rm,
            tgt.target AS target,
            ROUND(100, 1) as target_persentase,
            COUNT(intv.hasil_int) AS actual,
            COALESCE(ROUND(COUNT(intv.hasil_int) / tgt.target * 100), 0) AS achieve_persentase
            --   ROUND(tgt.target / DAY(LAST_DAY(CURRENT_DATE)) * DAY(CURRENT_DATE), 0) AS target_mtd
            FROM
            rsp_project_live.t_interview AS intv
            JOIN rsp_project_live.t_gci tgci ON tgci.id_gci = intv.id_gci
            LEFT JOIN (
                SELECT
                periode,
                SUM(target_sp3k) AS `target`
                FROM
                rsp_project_live.m_target_monthly_rm
                WHERE
                periode = '$periode'
                  AND id_rm = '$id_rm'
            ) AS tgt ON '$periode' = tgt.periode
            WHERE
            intv.hasil_int = 1
            AND LEFT(intv.tgl_sp3k, 7) = '$periode'
              AND tgci.id_gm = '$id_rm'
            AND LEFT(tgci.blok, 2) <> 'RD'
            AND LEFT(tgci.blok, 2) <> 'R-'";
        return $this->db->query($query)->row_array();
    }
    function kpi_corporate($periode){
        $query = "SELECT
            'Plan SP3K' AS goal,
            tgt.target AS target,
            ROUND(100, 1) as target_persentase,
            COUNT(intv.hasil_int) AS actual,
            COALESCE(ROUND(COUNT(intv.hasil_int) / tgt.target * 100), 0) AS achieve_persentase
            --   ROUND(tgt.target / DAY(LAST_DAY(CURRENT_DATE)) * DAY(CURRENT_DATE), 0) AS target_mtd
            FROM
            rsp_project_live.t_interview AS intv
            JOIN rsp_project_live.t_gci tgci ON tgci.id_gci = intv.id_gci
            LEFT JOIN (
                SELECT
                periode,
                SUM(target_sp3k) AS `target`
                FROM
                rsp_project_live.m_target_monthly_rm
                WHERE
                periode = '$periode'
            --       AND id_rm = ''
            ) AS tgt ON '$periode' = tgt.periode
            WHERE
            intv.hasil_int = 1
            AND LEFT(intv.tgl_sp3k, 7) = '$periode'
            --   AND tgci.id_gm = ''
            AND LEFT(tgci.blok, 2) <> 'RD'
            AND LEFT(tgci.blok, 2) <> 'R-'";
        return $this->db->query($query)->row_array();
    }

    function progres_berkas($id_rm,$periode){
        $query = "SELECT 
        ROUND(100, 1) as target_persentase,
                    COUNT(DISTINCT x.no_booking) AS target,
                    COUNT(IF(x.status_berkas = 'LENGKAP',1,NULL)) AS actual,
                    ROUND(COUNT(IF(x.status_berkas = 'LENGKAP',1,NULL)) / COUNT(DISTINCT x.no_booking) * 100,1) AS persentase 
                    
                    FROM 
                    
                    (WITH RECURSIVE date_range AS (
                        SELECT DATE('$periode-01') AS tgl
                        UNION ALL
                        SELECT DATE_ADD(tgl, INTERVAL 1 DAY)
                        FROM date_range
                        WHERE tgl < '$periode-30'
                    )
                    SELECT
                    g.id_gci AS no_booking,
                    g.id_project,
                    p.project,
                    g.blok,
                    k.nama_konsumen,
                    rm.employee_name AS regional_manager,
                    mm.employee_name AS manager_sales,
                    spv.employee_name AS spv_sales,
                    sales.employee_name AS sales,
                    DATE(g.created_at) AS tgl_booking,
                    IF(b.hasil_bic IN (1,2), 'BIC ACC', 'REJECT BIC') AS status_bic,
                    DATE(b.tgl_bic) AS tgl_bic_acc,
                    IF(inv.hasil_inv = 1, 'LENGKAP', 'BELUM LENGKAP') AS status_berkas,
                    DATE(COALESCE(inv.updated_at, inv.created_at)) AS tgl_berkas_lengkap,
                    COUNT(DISTINCT IF(CONCAT(kalendar_berkas.tgl, ' - ', kalendar_berkas.hari) = CONCAT(kalendar_berkas.tgl, ' - Minggu'), CONCAT(kalendar_berkas.tgl, ' - ', kalendar_berkas.hari), NULL)) AS jml_hari_libur_proses_berkas,
                    DATEDIFF(COALESCE(COALESCE(inv.updated_at,inv.created_at),CURRENT_DATE), DATE(b.tgl_bic)) - COUNT(DISTINCT IF(CONCAT(kalendar_berkas.tgl, ' - ', kalendar_berkas.hari) = CONCAT(kalendar_berkas.tgl, ' - Minggu'), CONCAT(kalendar_berkas.tgl, ' - ', kalendar_berkas.hari), NULL)) AS leadtime_hari_proses_kelengkapan_berkas,
                    CASE WHEN COALESCE(inv.status_approve,'') = '' THEN 'INPROGRESS'
                    WHEN COALESCE(inv.status_approve,'') = '1' THEN 'ACC'
                    ELSE 'REJECT' END AS status_verifikasi_berkas,
                    DATE(inv.approve_at) AS tgl_verifikasi_berkas,
                    i.tgl_input_berkas AS tgl_masuk_bank,
                    COUNT(DISTINCT IF(CONCAT(kalendar.tgl, ' - ', kalendar.hari) = CONCAT(kalendar.tgl, ' - Minggu'), CONCAT(kalendar.tgl, ' - ', kalendar.hari), NULL)) AS jml_hari_libur_proses_bank,
                    IF(i.tgl_input_berkas IS NOT NULL, 'PROSES PENGAJUAN',NULL) AS status_bank,
                    DATEDIFF(COALESCE(i.tgl_input_berkas,CURRENT_DATE), DATE(b.tgl_bic)) - COUNT(DISTINCT IF(CONCAT(kalendar.tgl, ' - ', kalendar.hari) = CONCAT(kalendar.tgl, ' - Minggu'), CONCAT(kalendar.tgl, ' - ', kalendar.hari), NULL)) AS leadtime_hari_proses_bank,
                    IF(DATEDIFF(COALESCE(i.tgl_input_berkas,CURRENT_DATE), DATE(b.tgl_bic)) - COUNT(IF(kalendar.hari = 'Minggu', 1, NULL)) <= 15, 'ONTIME', 'LATE') AS status_leadtime,
                    collect.employee_name AS pic_collect,
                    pic_bank.employee_name AS pic_bank
                    FROM
                    rsp_project_live.t_gci g
                    LEFT JOIN rsp_project_live.t_bic b ON b.id_gci = g.id_gci
                    LEFT JOIN rsp_project_live.t_inventory inv ON inv.id_bic = b.id_bic
                    LEFT JOIN rsp_project_live.t_interview i ON i.id_inv = inv.id_inv AND i.id_gci = g.id_gci
                    LEFT JOIN rsp_project_live.m_status si ON si.id_status = i.hasil_int
                    LEFT JOIN rsp_project_live.m_konsumen k ON k.id_konsumen = g.id_konsumen
                    LEFT JOIN rsp_project_live.m_project p  ON p.id_project = g.id_project
                    LEFT JOIN rsp_project_live.user rm ON rm.id_user = g.id_gm
                    LEFT JOIN rsp_project_live.user mm ON mm.id_user = g.manager
                    LEFT JOIN rsp_project_live.user spv ON spv.id_user = g.spv
                    LEFT JOIN rsp_project_live.user sales ON sales.id_user = g.created_by
                    LEFT JOIN rsp_project_live.user collect ON collect.id_user = i.created_by
                    LEFT JOIN rsp_project_live.user pic_bank ON pic_bank.id_user = inv.pic_bank
                    LEFT JOIN (SELECT 
                        tgl,
                        CASE DAYOFWEEK(tgl)
                            WHEN 1 THEN 'Minggu'
                            WHEN 2 THEN 'Senin'
                            WHEN 3 THEN 'Selasa'
                            WHEN 4 THEN 'Rabu'
                            WHEN 5 THEN 'Kamis'
                            WHEN 6 THEN 'Jumat'
                            WHEN 7 THEN 'Sabtu'
                        END AS hari,
                        CASE DAYOFWEEK(tgl)
                            WHEN 1 THEN 'Libur'
                            ELSE 'Hari Kerja'
                        END AS status
                    FROM date_range) AS kalendar ON kalendar.tgl BETWEEN DATE(b.tgl_bic) AND DATE(COALESCE(i.tgl_input_berkas,CURRENT_DATE))
                    LEFT JOIN (SELECT 
                        tgl,
                        CASE DAYOFWEEK(tgl)
                            WHEN 1 THEN 'Minggu'
                            WHEN 2 THEN 'Senin'
                            WHEN 3 THEN 'Selasa'
                            WHEN 4 THEN 'Rabu'
                            WHEN 5 THEN 'Kamis'
                            WHEN 6 THEN 'Jumat'
                            WHEN 7 THEN 'Sabtu'
                        END AS hari,
                        CASE DAYOFWEEK(tgl)
                            WHEN 1 THEN 'Libur'
                            ELSE 'Hari Kerja'
                        END AS status
                    FROM date_range) AS kalendar_berkas ON kalendar_berkas.tgl BETWEEN DATE(b.tgl_bic) AND DATE(COALESCE(COALESCE(inv.updated_at,inv.created_at),CURRENT_DATE))
                    WHERE
                    g.created_at LIKE '$periode%' 
                    AND LEFT(LOWER(g.jenis_pembayaran),4) != 'cash'
                    AND g.id_kategori >= 3
                    -- AND LEFT(g.blok,2) != 'RD'
                    AND b.hasil_bic IN (1,2)
                    AND b.created_at LIKE '$periode%'
                    AND g.id_gm = $id_rm
                    GROUP BY g.id_gci) AS x";
        return $this->db->query($query)->row_array();
    }
    function berkas_tidak_lengkap($id_rm,$periode){
        $query = "SELECT 
         ROUND(100, 1) as target_persentase,
            COUNT(DISTINCT x.no_booking) AS target,
            COUNT(IF(x.status_berkas <> 'LENGKAP',1,NULL)) AS actual,
            ROUND(COUNT(IF(x.status_berkas <> 'LENGKAP',1,NULL)) / COUNT(DISTINCT x.no_booking) * 100,1) AS persentase
            
            FROM
            
            (WITH RECURSIVE date_range AS (
                SELECT DATE('$periode-01') AS tgl
                UNION ALL
                SELECT DATE_ADD(tgl, INTERVAL 1 DAY)
                FROM date_range
                WHERE tgl < '$periode-30'
            )
            SELECT
            g.id_gci AS no_booking,
            g.id_project,
            p.project,
            g.blok,
            k.nama_konsumen,
            rm.employee_name AS regional_manager,
            mm.employee_name AS manager_sales,
            spv.employee_name AS spv_sales,
            sales.employee_name AS sales,
            DATE(g.created_at) AS tgl_booking,
            IF(b.hasil_bic IN (1,2), 'BIC ACC', 'REJECT BIC') AS status_bic,
            DATE(b.tgl_bic) AS tgl_bic_acc,
            IF(inv.hasil_inv = 1, 'LENGKAP', 'BELUM LENGKAP') AS status_berkas,
            DATE(COALESCE(inv.updated_at, inv.created_at)) AS tgl_berkas_lengkap,
            COUNT(DISTINCT IF(CONCAT(kalendar_berkas.tgl, ' - ', kalendar_berkas.hari) = CONCAT(kalendar_berkas.tgl, ' - Minggu'), CONCAT(kalendar_berkas.tgl, ' - ', kalendar_berkas.hari), NULL)) AS jml_hari_libur_proses_berkas,
            DATEDIFF(COALESCE(COALESCE(inv.updated_at,inv.created_at),CURRENT_DATE), DATE(b.tgl_bic)) - COUNT(DISTINCT IF(CONCAT(kalendar_berkas.tgl, ' - ', kalendar_berkas.hari) = CONCAT(kalendar_berkas.tgl, ' - Minggu'), CONCAT(kalendar_berkas.tgl, ' - ', kalendar_berkas.hari), NULL)) AS leadtime_hari_proses_kelengkapan_berkas,
            CASE WHEN COALESCE(inv.status_approve,'') = '' THEN 'INPROGRESS'
            WHEN COALESCE(inv.status_approve,'') = '1' THEN 'ACC'
            ELSE 'REJECT' END AS status_verifikasi_berkas,
            DATE(inv.approve_at) AS tgl_verifikasi_berkas,
            i.tgl_input_berkas AS tgl_masuk_bank,
            COUNT(DISTINCT IF(CONCAT(kalendar.tgl, ' - ', kalendar.hari) = CONCAT(kalendar.tgl, ' - Minggu'), CONCAT(kalendar.tgl, ' - ', kalendar.hari), NULL)) AS jml_hari_libur_proses_bank,
            IF(DATEDIFF(COALESCE(i.tgl_input_berkas,CURRENT_DATE), DATE(b.tgl_bic)) - COUNT(DISTINCT IF(CONCAT(kalendar.tgl, ' - ', kalendar.hari) = CONCAT(kalendar.tgl, ' - Minggu'), CONCAT(kalendar.tgl, ' - ', kalendar.hari), NULL)) <= 15, 'ONTIME', 'LATE') AS status_leadtime,
            collect.employee_name AS pic_collect,
            pic_bank.employee_name AS pic_bank
            FROM
            rsp_project_live.t_gci g
            LEFT JOIN rsp_project_live.t_bic b ON b.id_gci = g.id_gci
            LEFT JOIN rsp_project_live.t_inventory inv ON inv.id_bic = b.id_bic
            LEFT JOIN rsp_project_live.t_interview i ON i.id_inv = inv.id_inv AND i.id_gci = g.id_gci
            LEFT JOIN rsp_project_live.m_status si ON si.id_status = i.hasil_int
            LEFT JOIN rsp_project_live.m_konsumen k ON k.id_konsumen = g.id_konsumen
            LEFT JOIN rsp_project_live.m_project p  ON p.id_project = g.id_project
            LEFT JOIN rsp_project_live.user rm ON rm.id_user = g.id_gm
            LEFT JOIN rsp_project_live.user mm ON mm.id_user = g.manager
            LEFT JOIN rsp_project_live.user spv ON spv.id_user = g.spv
            LEFT JOIN rsp_project_live.user sales ON sales.id_user = g.created_by
            LEFT JOIN rsp_project_live.user collect ON collect.id_user = i.created_by
            LEFT JOIN rsp_project_live.user pic_bank ON pic_bank.id_user = inv.pic_bank
            LEFT JOIN (SELECT 
                tgl,
                CASE DAYOFWEEK(tgl)
                    WHEN 1 THEN 'Minggu'
                    WHEN 2 THEN 'Senin'
                    WHEN 3 THEN 'Selasa'
                    WHEN 4 THEN 'Rabu'
                    WHEN 5 THEN 'Kamis'
                    WHEN 6 THEN 'Jumat'
                    WHEN 7 THEN 'Sabtu'
                END AS hari,
                CASE DAYOFWEEK(tgl)
                    WHEN 1 THEN 'Libur'
                    ELSE 'Hari Kerja'
                END AS status
            FROM date_range) AS kalendar ON kalendar.tgl BETWEEN DATE(b.tgl_bic) AND DATE(COALESCE(i.tgl_input_berkas,CURRENT_DATE))
            LEFT JOIN (SELECT 
                tgl,
                CASE DAYOFWEEK(tgl)
                    WHEN 1 THEN 'Minggu'
                    WHEN 2 THEN 'Senin'
                    WHEN 3 THEN 'Selasa'
                    WHEN 4 THEN 'Rabu'
                    WHEN 5 THEN 'Kamis'
                    WHEN 6 THEN 'Jumat'
                    WHEN 7 THEN 'Sabtu'
                END AS hari,
                CASE DAYOFWEEK(tgl)
                    WHEN 1 THEN 'Libur'
                    ELSE 'Hari Kerja'
                END AS status
            FROM date_range) AS kalendar_berkas ON kalendar_berkas.tgl BETWEEN DATE(b.tgl_bic) AND DATE(COALESCE(COALESCE(inv.updated_at,inv.created_at),CURRENT_DATE))
            WHERE
            g.created_at LIKE '$periode%' 
            AND LEFT(LOWER(g.jenis_pembayaran),4) != 'cash'
            AND g.id_kategori >= 3
            -- AND LEFT(g.blok,2) != 'RD'
            AND b.hasil_bic IN (1,2)
            AND b.created_at LIKE '$periode%'
            AND g.id_gm = $id_rm
            GROUP BY g.id_gci) AS x";
        return $this->db->query($query)->row_array();
    }
    function berkas_real($id_rm,$periode){
        $query = "SELECT
                ROUND(100,0) AS target_persen,
                COUNT(gci.id_gci) AS target,
                SUM(IF(kon.jenis_berkas <> 'Not Real (Wayang)',1,0)) AS jumlah,
                ROUND(SUM(IF(kon.jenis_berkas <> 'Not Real (Wayang)',1,0))  / COUNT(gci.id_gci) * 100,1) AS persentase
                FROM
                rsp_project_live.t_gci gci
                LEFT JOIN rsp_project_live.m_konsumen kon ON kon.id_konsumen = gci.id_konsumen
                WHERE LEFT(gci.created_at,7) = '$periode'
                AND gci.id_kategori = 3
                AND id_gm = $id_rm
                ";
        return $this->db->query($query)->row_array();
    }
    function dp_customer($id_rm,$periode){
        $query = "SELECT
            COUNT(spr.id_gci) as target,
            ROUND(100, 1) as target_persentase,
            COALESCE(SUM(IF(spr.dp_persen >= 100, 1, 0)), 0) AS actual,
            COALESCE(ROUND(COALESCE(SUM(IF(spr.dp_persen >= 100, 1, 0)), 0) / COUNT(spr.id_gci) * 100, 1), 0) AS achieve_persentase
            FROM
            (
                SELECT
                v_spr.id_gci,
                v_spr.jenis,
                v_spr.total_ar_new,
                v_spr.sisa_ar,
                v_spr.terima_kunci,
                v_spr.dp,
                v_spr.income,
                ROUND(((v_spr.income) / v_spr.terima_kunci) * 100) AS dp_persen,
                mpu.project_tipe,
                v_spr.created_at
                FROM
                rsp_project_live.view_spr v_spr
                LEFT JOIN rsp_project_live.t_gci tgci ON tgci.id_gci = v_spr.id_gci
                LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_konsumen = tgci.id_konsumen
                LEFT JOIN rsp_project_live.t_akad akad ON akad.id_konsumen = tgci.id_konsumen
                LEFT JOIN rsp_project_live.t_interview intv ON intv.id_gci = tgci.id_gci
                WHERE
                LEFT(intv.tgl_sp3k, 7) = '$periode'
                AND (v_spr.jenis LIKE '%KPR%' OR v_spr.jenis LIKE '%CASH%')
                AND intv.hasil_int = 1
                AND akad.id_akad IS NULL
                AND LEFT(tgci.blok, 2) <> 'RD'
                AND LEFT(tgci.blok, 2) <> 'R-'
                AND tgci.id_gm = '$id_rm'
            ) AS spr";
        return $this->db->query($query)->row_array();
    }
    function leadtime_pemberkasan($id_rm,$periode){
        $query = "SELECT 
         ROUND(100, 1) as target_persentase,
                COUNT(DISTINCT x.no_booking) AS target,
                COUNT(IF(x.leadtime_hari_proses_kelengkapan_berkas <= 10,1,NULL)) AS actual,
                ROUND(COUNT(IF(x.leadtime_hari_proses_kelengkapan_berkas <= 10,1,NULL)) / COUNT(DISTINCT x.no_booking) * 100,1) AS persentase
                FROM
                (
                WITH RECURSIVE date_range AS (
                    SELECT DATE('$periode-01') AS tgl
                    UNION ALL
                    SELECT DATE_ADD(tgl, INTERVAL 1 DAY)
                    FROM date_range
                    WHERE tgl < '$periode-30'
                )
                SELECT
                g.id_gci AS no_booking,
                g.id_project,
                p.project,
                g.blok,
                k.nama_konsumen,
                rm.employee_name AS regional_manager,
                mm.employee_name AS manager_sales,
                spv.employee_name AS spv_sales,
                sales.employee_name AS sales,
                DATE(g.created_at) AS tgl_booking,
                IF(b.hasil_bic IN (1,2), 'BIC ACC', 'REJECT BIC') AS status_bic,
                DATE(b.tgl_bic) AS tgl_bic_acc,
                IF(inv.hasil_inv = 1, 'LENGKAP', 'BELUM LENGKAP') AS status_berkas,
                DATE(COALESCE(inv.updated_at, inv.created_at)) AS tgl_berkas_lengkap,
                COUNT(DISTINCT IF(CONCAT(kalendar_berkas.tgl, ' - ', kalendar_berkas.hari) = CONCAT(kalendar_berkas.tgl, ' - Minggu'), CONCAT(kalendar_berkas.tgl, ' - ', kalendar_berkas.hari), NULL)) AS jml_hari_libur_proses_berkas,
                DATEDIFF(COALESCE(COALESCE(inv.updated_at,inv.created_at),CURRENT_DATE), DATE(b.tgl_bic)) - COUNT(DISTINCT IF(CONCAT(kalendar_berkas.tgl, ' - ', kalendar_berkas.hari) = CONCAT(kalendar_berkas.tgl, ' - Minggu'), CONCAT(kalendar_berkas.tgl, ' - ', kalendar_berkas.hari), NULL)) AS leadtime_hari_proses_kelengkapan_berkas,
                CASE WHEN COALESCE(inv.status_approve,'') = '' THEN 'INPROGRESS'
                WHEN COALESCE(inv.status_approve,'') = '1' THEN 'ACC'
                ELSE 'REJECT' END AS status_verifikasi_berkas,
                DATE(inv.approve_at) AS tgl_verifikasi_berkas,
                i.tgl_input_berkas AS tgl_masuk_bank,
                COUNT(DISTINCT IF(CONCAT(kalendar.tgl, ' - ', kalendar.hari) = CONCAT(kalendar.tgl, ' - Minggu'), CONCAT(kalendar.tgl, ' - ', kalendar.hari), NULL)) AS jml_hari_libur_proses_bank,
                IF(DATEDIFF(COALESCE(i.tgl_input_berkas,CURRENT_DATE), DATE(b.tgl_bic)) - COUNT(DISTINCT IF(CONCAT(kalendar.tgl, ' - ', kalendar.hari) = CONCAT(kalendar.tgl, ' - Minggu'), CONCAT(kalendar.tgl, ' - ', kalendar.hari), NULL)) <= 15, 'ONTIME', 'LATE') AS status_leadtime,
                collect.employee_name AS pic_collect,
                pic_bank.employee_name AS pic_bank
                FROM
                rsp_project_live.t_gci g
                LEFT JOIN rsp_project_live.t_bic b ON b.id_gci = g.id_gci
                LEFT JOIN rsp_project_live.t_inventory inv ON inv.id_bic = b.id_bic
                LEFT JOIN rsp_project_live.t_interview i ON i.id_inv = inv.id_inv AND i.id_gci = g.id_gci
                LEFT JOIN rsp_project_live.m_status si ON si.id_status = i.hasil_int
                LEFT JOIN rsp_project_live.m_konsumen k ON k.id_konsumen = g.id_konsumen
                LEFT JOIN rsp_project_live.m_project p  ON p.id_project = g.id_project
                LEFT JOIN rsp_project_live.user rm ON rm.id_user = g.id_gm
                LEFT JOIN rsp_project_live.user mm ON mm.id_user = g.manager
                LEFT JOIN rsp_project_live.user spv ON spv.id_user = g.spv
                LEFT JOIN rsp_project_live.user sales ON sales.id_user = g.created_by
                LEFT JOIN rsp_project_live.user collect ON collect.id_user = i.created_by
                LEFT JOIN rsp_project_live.user pic_bank ON pic_bank.id_user = inv.pic_bank
                LEFT JOIN (SELECT 
                    tgl,
                    CASE DAYOFWEEK(tgl)
                        WHEN 1 THEN 'Minggu'
                        WHEN 2 THEN 'Senin'
                        WHEN 3 THEN 'Selasa'
                        WHEN 4 THEN 'Rabu'
                        WHEN 5 THEN 'Kamis'
                        WHEN 6 THEN 'Jumat'
                        WHEN 7 THEN 'Sabtu'
                    END AS hari,
                    CASE DAYOFWEEK(tgl)
                        WHEN 1 THEN 'Libur'
                        ELSE 'Hari Kerja'
                    END AS status
                FROM date_range) AS kalendar ON kalendar.tgl BETWEEN DATE(b.tgl_bic) AND DATE(COALESCE(i.tgl_input_berkas,CURRENT_DATE))
                LEFT JOIN (SELECT 
                    tgl,
                    CASE DAYOFWEEK(tgl)
                        WHEN 1 THEN 'Minggu'
                        WHEN 2 THEN 'Senin'
                        WHEN 3 THEN 'Selasa'
                        WHEN 4 THEN 'Rabu'
                        WHEN 5 THEN 'Kamis'
                        WHEN 6 THEN 'Jumat'
                        WHEN 7 THEN 'Sabtu'
                    END AS hari,
                    CASE DAYOFWEEK(tgl)
                        WHEN 1 THEN 'Libur'
                        ELSE 'Hari Kerja'
                    END AS status
                FROM date_range) AS kalendar_berkas ON kalendar_berkas.tgl BETWEEN DATE(b.tgl_bic) AND DATE(COALESCE(COALESCE(inv.updated_at,inv.created_at),CURRENT_DATE))
                WHERE
                g.created_at LIKE '$periode%' 
                AND LEFT(LOWER(g.jenis_pembayaran),4) != 'cash'
                AND g.id_kategori >= 3
                AND LEFT(g.blok,2) != 'RD'
                AND b.hasil_bic IN (1,2)
                AND b.created_at LIKE '$periode%'
                AND g.id_gm = $id_rm
                GROUP BY g.id_gci) AS x
        ";
        return $this->db->query($query)->row_array();
    }
    function hasil_feedback($id_rm,$periode){
        $query = "WITH RECURSIVE date_range AS (SELECT DATE('2025-09-01') AS tgl UNION ALL SELECT DATE_ADD(tgl, INTERVAL 1 DAY) FROM date_range WHERE tgl < '2025-09-30') SELECT
                g.id_gci AS no_booking,
                g.id_project,
                p.project,
                g.blok,
                k.nama_konsumen,
                rm.employee_name AS regional_manager,
                mm.employee_name AS manager_sales,
                spv.employee_name AS spv_sales,
                sales.employee_name AS sales,
                DATE(g.created_at) AS tgl_booking,
                IF
                (b.hasil_bic IN (1, 2), 'BIC ACC', 'REJECT BIC') AS status_bic,
                DATE(b.tgl_bic) AS tgl_bic_acc,
                CASE
                    
                    WHEN COALESCE(inv.status_approve, '') = '' THEN
                    'INPROGRESS' 
                    WHEN COALESCE(inv.status_approve, '') = '1' THEN
                    'ACC' ELSE 'REJECT' 
                END AS status_berkas,
                DATE(inv.approve_at) AS tgl_acc_berkas,
                i.tgl_input_berkas AS tgl_proses_bank,
                COUNT(IF(kalendar.hari = 'Minggu', 1, NULL)) AS jml_hari_libur,
                IF(i.tgl_input_berkas IS NOT NULL, 'PROSES MASUK BANK', 'WAITING') AS kategori,
                DATEDIFF(COALESCE(i.tgl_input_berkas, CURRENT_DATE), DATE(b.tgl_bic)) - COUNT(IF(kalendar.hari = 'Minggu', 1, NULL)) AS leadtime_hari,
                IF
                (
                    DATEDIFF(COALESCE(i.tgl_input_berkas, CURRENT_DATE), DATE(b.tgl_bic)) - COUNT(IF(kalendar.hari = 'Minggu', 1, NULL)) <= 15,
                    'ONTIME',
                'LATE') AS status_leadtime,
                collect.employee_name AS pic_collect,
                pic_bank.employee_name AS pic_bank,
                s.total_ar,
                s.sisa_ar,
                s.jtp AS jtp_bayar,
                inc.tgl_bayar_terakhir,
                IF
                (s.sisa_ar <= 0, 'LUNAS', 'BELUM LUNAS') AS status_ar,
                DATEDIFF(IF(s.sisa_ar <= 0, inc.tgl_bayar_terakhir, CURRENT_DATE), s.jtp) AS jml_hari_telat_bayar,
                IF
                (
                    DATEDIFF(IF(s.sisa_ar <= 0, inc.tgl_bayar_terakhir, CURRENT_DATE), s.jtp) > 0,
                    'LATE',
                'ONTIME') AS status_leadtime_bayar,
                GROUP_CONCAT(DISTINCT iact.created_at, ' - ', iact.note) AS history_bank,
                status_int.sp3k 
                FROM
                rsp_project_live.t_gci g
                LEFT JOIN rsp_project_live.t_bic b ON b.id_gci = g.id_gci
                LEFT JOIN rsp_project_live.t_inventory inv ON inv.id_bic = b.id_bic
                LEFT JOIN rsp_project_live.t_interview i ON i.id_inv = inv.id_inv 
                AND i.id_gci = g.id_gci
                LEFT JOIN rsp_project_live.m_konsumen k ON k.id_konsumen = g.id_konsumen
                LEFT JOIN rsp_project_live.m_project p ON p.id_project = g.id_project
                LEFT JOIN rsp_project_live.user rm ON rm.id_user = g.id_gm
                LEFT JOIN rsp_project_live.user mm ON mm.id_user = g.manager
                LEFT JOIN rsp_project_live.user spv ON spv.id_user = g.spv
                LEFT JOIN rsp_project_live.user sales ON sales.id_user = g.created_by
                LEFT JOIN rsp_project_live.user collect ON collect.id_user = i.created_by
                LEFT JOIN rsp_project_live.user pic_bank ON pic_bank.id_user = inv.pic_bank
                LEFT JOIN rsp_project_live.view_spr s ON s.id_gci = g.id_gci
                LEFT JOIN rsp_project_live.t_interview_activity iact ON iact.id_int = i.id_int
                LEFT JOIN (
                    SELECT
                    g.id_gci,
                    DATE(MAX(i.created_at)) AS tgl_bayar_terakhir 
                    FROM
                    rsp_project_live.t_gci g
                    LEFT JOIN rsp_project_live.t_income i ON i.id_gci = g.id_gci 
                    WHERE
                    g.created_at LIKE '2025-09%' 
                    AND g.id_gm = '18' 
                    AND LEFT(LOWER(g.jenis_pembayaran), 4) != 'cash' 
                    AND g.id_kategori >= 3 
                    AND LEFT(g.blok, 2) != 'RD' 
                    GROUP BY
                g.id_gci) AS inc ON inc.id_gci = g.id_gci
                LEFT JOIN rsp_project_live.m_status status_int ON status_int.id_status = i.hasil_int
                LEFT JOIN (
                    SELECT
                    tgl,
                    CASE
                        DAYOFWEEK(tgl) 
                        WHEN 1 THEN
                        'Minggu' 
                        WHEN 2 THEN
                        'Senin' 
                        WHEN 3 THEN
                        'Selasa' 
                        WHEN 4 THEN
                        'Rabu' 
                        WHEN 5 THEN
                        'Kamis' 
                        WHEN 6 THEN
                        'Jumat' 
                        WHEN 7 THEN
                        'Sabtu' 
                    END AS hari,
                    CASE
                        DAYOFWEEK(tgl) 
                        WHEN 1 THEN
                        'Libur' ELSE 'Hari Kerja' 
                    END AS status 
                    FROM
                date_range) AS kalendar ON kalendar.tgl BETWEEN DATE(b.tgl_bic) 
                AND DATE(COALESCE(i.tgl_input_berkas, CURRENT_DATE)) 
                WHERE
                g.created_at LIKE '$periode%' 
                AND LEFT(LOWER(g.jenis_pembayaran), 4) != 'cash' 
                AND g.id_kategori >= 3 
                AND LEFT(g.blok, 2) != 'RD' 
                AND b.hasil_bic IN (1, 2) 
                AND b.created_at LIKE '$periode%' 
                AND g.id_gm = '$id_rm'
                -- GROUP BY g.id_gci
                ";
        return $this->db->query($query)->row_array();
    }

    
}