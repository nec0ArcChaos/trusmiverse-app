<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_api_proses_bank extends CI_Model
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

    function get_rm($id_rm)
    {
        $query = "SELECT
                u.id_user as id,
                u.employee_name AS `name`
            FROM
                rsp_project_live.`user` u
            WHERE
                u.id_user = '$id_rm'";
        return $this->db->query($query)->row_array();
    }

    function get_all_data($periode)
    {
        $periode = date('Y-m', strtotime($periode . ' first day of this month'));
        $start_date =  date('y-m-d', strtotime($periode . ' first day of this month'));
        $end_date = date('y-m-d', strtotime($periode . ' last day of this month'));

        $query = "SELECT
                    x.*,
                    s.total_ar,
                    s.sisa_ar,
                    s.jtp AS jtp_bayar,
                    IF(s.sisa_ar > 0,DATEDIFF(CURRENT_DATE,s.jtp), DATEDIFF(x.tgl_terakhir_bayar,s.jtp)) AS jml_hari_telat_bayar,
                    IF(IF(s.sisa_ar > 0,DATEDIFF(CURRENT_DATE,s.jtp), DATEDIFF(x.tgl_terakhir_bayar,s.jtp)) > 0, 'LATE', 'ONTIME') AS status_leadtime_bayar
                    FROM
                    (
                        WITH RECURSIVE date_range AS (SELECT DATE('$start_date') AS tgl UNION ALL SELECT DATE_ADD(tgl, INTERVAL 1 DAY) FROM date_range WHERE tgl < '$end_date') SELECT
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
                        IF
                        (inv.hasil_inv = 1, 'LENGKAP', 'BELUM LENGKAP') AS status_berkas,
                        DATE(COALESCE(inv.updated_at, inv.created_at)) AS tgl_berkas_lengkap,
                        COUNT(
                            DISTINCT
                            IF
                            (
                                CONCAT(kalendar_berkas.tgl, ' - ', kalendar_berkas.hari) = CONCAT(kalendar_berkas.tgl, ' - Minggu'),
                                CONCAT(kalendar_berkas.tgl, ' - ', kalendar_berkas.hari),
                            NULL)) AS jml_hari_libur_proses_berkas,
                        DATEDIFF(COALESCE(COALESCE(inv.updated_at, inv.created_at), CURRENT_DATE), DATE(b.tgl_bic)) - COUNT(
                            DISTINCT
                            IF
                            (
                                CONCAT(kalendar_berkas.tgl, ' - ', kalendar_berkas.hari) = CONCAT(kalendar_berkas.tgl, ' - Minggu'),
                                CONCAT(kalendar_berkas.tgl, ' - ', kalendar_berkas.hari),
                            NULL)) AS leadtime_hari_proses_kelengkapan_berkas,
                        CASE
                            
                            WHEN COALESCE(inv.status_approve, '') = '' THEN
                            'INPROGRESS' 
                            WHEN COALESCE(inv.status_approve, '') = '1' THEN
                            'ACC' ELSE 'REJECT' 
                        END AS `status_verifikasi_berkas`,
                        DATE(inv.approve_at) AS tgl_verifikasi_berkas,
                        i.tgl_input_berkas AS tgl_masuk_bank,
                        COUNT(
                            DISTINCT
                            IF
                            (
                                CONCAT(kalendar.tgl, ' - ', kalendar.hari) = CONCAT(kalendar.tgl, ' - Minggu'),
                                CONCAT(kalendar.tgl, ' - ', kalendar.hari),
                            NULL)) AS jml_hari_libur_proses_bank,
                        IF
                        (i.tgl_input_berkas IS NOT NULL, 'PROSES PENGAJUAN', NULL) AS status_bank,
                        DATEDIFF(COALESCE(i.tgl_input_berkas, CURRENT_DATE), DATE(b.tgl_bic)) - COUNT(
                            DISTINCT
                            IF
                            (
                                CONCAT(kalendar.tgl, ' - ', kalendar.hari) = CONCAT(kalendar.tgl, ' - Minggu'),
                                CONCAT(kalendar.tgl, ' - ', kalendar.hari),
                            NULL)) AS leadtime_hari_proses_bank,
                        IF
                        (
                            DATEDIFF(COALESCE(i.tgl_input_berkas, CURRENT_DATE), DATE(b.tgl_bic)) - COUNT(
                                DISTINCT
                                IF
                                (
                                    CONCAT(kalendar.tgl, ' - ', kalendar.hari) = CONCAT(kalendar.tgl, ' - Minggu'),
                                    CONCAT(kalendar.tgl, ' - ', kalendar.hari),
                                NULL)) <= 15,
                            'ONTIME',
                        'LATE') AS status_leadtime,
                        collect.employee_name AS pic_collect,
                        pic_bank.employee_name AS pic_bank,
                        DATE(MAX(inc.created_at)) AS tgl_terakhir_bayar
                        FROM
                        rsp_project_live.t_gci g
                        LEFT JOIN rsp_project_live.t_bic b ON b.id_gci = g.id_gci
                        LEFT JOIN rsp_project_live.t_inventory inv ON inv.id_bic = b.id_bic
                        LEFT JOIN rsp_project_live.t_interview i ON i.id_inv = inv.id_inv 
                        AND i.id_gci = g.id_gci
                        LEFT JOIN rsp_project_live.t_income inc ON inc.id_gci = g.id_gci
                        LEFT JOIN rsp_project_live.m_status si ON si.id_status = i.hasil_int
                        LEFT JOIN rsp_project_live.m_konsumen k ON k.id_konsumen = g.id_konsumen
                        LEFT JOIN rsp_project_live.m_project p ON p.id_project = g.id_project
                        LEFT JOIN rsp_project_live.`user` rm ON rm.id_user = g.id_gm
                        LEFT JOIN rsp_project_live.`user` mm ON mm.id_user = g.manager
                        LEFT JOIN rsp_project_live.`user` spv ON spv.id_user = g.spv
                        LEFT JOIN rsp_project_live.`user` sales ON sales.id_user = g.created_by
                        LEFT JOIN rsp_project_live.`user` collect ON collect.id_user = i.created_by
                        LEFT JOIN rsp_project_live.`user` pic_bank ON pic_bank.id_user = inv.pic_bank
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
                            END AS `status` 
                            FROM
                        date_range) AS kalendar ON kalendar.tgl BETWEEN DATE(b.tgl_bic) 
                        AND DATE(COALESCE(i.tgl_input_berkas, CURRENT_DATE))
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
                            END AS `status` 
                            FROM
                        date_range) AS kalendar_berkas ON kalendar_berkas.tgl BETWEEN DATE(b.tgl_bic) 
                        AND DATE(COALESCE(COALESCE(inv.updated_at, inv.created_at), CURRENT_DATE)) 
                        WHERE
                        g.created_at LIKE '$periode%' 
                        AND LEFT(LOWER(g.jenis_pembayaran), 4) != 'cash' 
                        AND g.id_kategori >= 3 
                        AND LEFT(g.blok, 2) != 'RD' 
                        AND b.hasil_bic IN (1, 2) 
                        AND b.created_at LIKE '$periode%' 
                        GROUP BY
                        g.id_gci) AS x
                    LEFT JOIN rsp_project_live.view_spr s ON s.id_gci = x.no_booking";

        return $this->db->query($query)->result();
    }

    function get_leadtime($id_rm, $periode)
    {
        $periode = date('Y-m', strtotime($periode . ' first day of this month'));
        $start_date =  date('y-m-d', strtotime($periode . ' first day of this month'));
        $end_date = date('y-m-d', strtotime($periode . ' last day of this month'));

        $query = "SELECT
                    x.*,
                    s.total_ar,
                    s.sisa_ar,
                    s.jtp AS jtp_bayar,
                    IF(s.sisa_ar > 0,DATEDIFF(CURRENT_DATE,s.jtp), DATEDIFF(x.tgl_terakhir_bayar,s.jtp)) AS jml_hari_telat_bayar,
                    IF(IF(s.sisa_ar > 0,DATEDIFF(CURRENT_DATE,s.jtp), DATEDIFF(x.tgl_terakhir_bayar,s.jtp)) > 0, 'LATE', 'ONTIME') AS status_leadtime_bayar
                    FROM
                    (
                        WITH RECURSIVE date_range AS (SELECT DATE('$start_date') AS tgl UNION ALL SELECT DATE_ADD(tgl, INTERVAL 1 DAY) FROM date_range WHERE tgl < '$end_date') SELECT
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
                        IF
                        (inv.hasil_inv = 1, 'LENGKAP', 'BELUM LENGKAP') AS status_berkas,
                        DATE(COALESCE(inv.updated_at, inv.created_at)) AS tgl_berkas_lengkap,
                        COUNT(
                            DISTINCT
                            IF
                            (
                                CONCAT(kalendar_berkas.tgl, ' - ', kalendar_berkas.hari) = CONCAT(kalendar_berkas.tgl, ' - Minggu'),
                                CONCAT(kalendar_berkas.tgl, ' - ', kalendar_berkas.hari),
                            NULL)) AS jml_hari_libur_proses_berkas,
                        DATEDIFF(COALESCE(COALESCE(inv.updated_at, inv.created_at), CURRENT_DATE), DATE(b.tgl_bic)) - COUNT(
                            DISTINCT
                            IF
                            (
                                CONCAT(kalendar_berkas.tgl, ' - ', kalendar_berkas.hari) = CONCAT(kalendar_berkas.tgl, ' - Minggu'),
                                CONCAT(kalendar_berkas.tgl, ' - ', kalendar_berkas.hari),
                            NULL)) AS leadtime_hari_proses_kelengkapan_berkas,
                        CASE
                            
                            WHEN COALESCE(inv.status_approve, '') = '' THEN
                            'INPROGRESS' 
                            WHEN COALESCE(inv.status_approve, '') = '1' THEN
                            'ACC' ELSE 'REJECT' 
                        END AS `status_verifikasi_berkas`,
                        DATE(inv.approve_at) AS tgl_verifikasi_berkas,
                        i.tgl_input_berkas AS tgl_masuk_bank,
                        COUNT(
                            DISTINCT
                            IF
                            (
                                CONCAT(kalendar.tgl, ' - ', kalendar.hari) = CONCAT(kalendar.tgl, ' - Minggu'),
                                CONCAT(kalendar.tgl, ' - ', kalendar.hari),
                            NULL)) AS jml_hari_libur_proses_bank,
                        IF
                        (i.tgl_input_berkas IS NOT NULL, 'PROSES PENGAJUAN', NULL) AS status_bank,
                        DATEDIFF(COALESCE(i.tgl_input_berkas, CURRENT_DATE), DATE(b.tgl_bic)) - COUNT(
                            DISTINCT
                            IF
                            (
                                CONCAT(kalendar.tgl, ' - ', kalendar.hari) = CONCAT(kalendar.tgl, ' - Minggu'),
                                CONCAT(kalendar.tgl, ' - ', kalendar.hari),
                            NULL)) AS leadtime_hari_proses_bank,
                        IF
                        (
                            DATEDIFF(COALESCE(i.tgl_input_berkas, CURRENT_DATE), DATE(b.tgl_bic)) - COUNT(
                                DISTINCT
                                IF
                                (
                                    CONCAT(kalendar.tgl, ' - ', kalendar.hari) = CONCAT(kalendar.tgl, ' - Minggu'),
                                    CONCAT(kalendar.tgl, ' - ', kalendar.hari),
                                NULL)) <= 15,
                            'ONTIME',
                        'LATE') AS status_leadtime,
                        collect.employee_name AS pic_collect,
                        pic_bank.employee_name AS pic_bank,
                        DATE(MAX(inc.created_at)) AS tgl_terakhir_bayar
                        FROM
                        rsp_project_live.t_gci g
                        LEFT JOIN rsp_project_live.t_bic b ON b.id_gci = g.id_gci
                        LEFT JOIN rsp_project_live.t_inventory inv ON inv.id_bic = b.id_bic
                        LEFT JOIN rsp_project_live.t_interview i ON i.id_inv = inv.id_inv 
                        AND i.id_gci = g.id_gci
                        LEFT JOIN rsp_project_live.t_income inc ON inc.id_gci = g.id_gci
                        LEFT JOIN rsp_project_live.m_status si ON si.id_status = i.hasil_int
                        LEFT JOIN rsp_project_live.m_konsumen k ON k.id_konsumen = g.id_konsumen
                        LEFT JOIN rsp_project_live.m_project p ON p.id_project = g.id_project
                        LEFT JOIN rsp_project_live.`user` rm ON rm.id_user = g.id_gm
                        LEFT JOIN rsp_project_live.`user` mm ON mm.id_user = g.manager
                        LEFT JOIN rsp_project_live.`user` spv ON spv.id_user = g.spv
                        LEFT JOIN rsp_project_live.`user` sales ON sales.id_user = g.created_by
                        LEFT JOIN rsp_project_live.`user` collect ON collect.id_user = i.created_by
                        LEFT JOIN rsp_project_live.`user` pic_bank ON pic_bank.id_user = inv.pic_bank
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
                            END AS `status` 
                            FROM
                        date_range) AS kalendar ON kalendar.tgl BETWEEN DATE(b.tgl_bic) 
                        AND DATE(COALESCE(i.tgl_input_berkas, CURRENT_DATE))
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
                            END AS `status` 
                            FROM
                        date_range) AS kalendar_berkas ON kalendar_berkas.tgl BETWEEN DATE(b.tgl_bic) 
                        AND DATE(COALESCE(COALESCE(inv.updated_at, inv.created_at), CURRENT_DATE)) 
                        WHERE
                        g.created_at LIKE '$periode%' 
                        AND LEFT(LOWER(g.jenis_pembayaran), 4) != 'cash' 
                        AND g.id_kategori >= 3 
                        AND LEFT(g.blok, 2) != 'RD' 
                        AND b.hasil_bic IN (1, 2) 
                        AND b.created_at LIKE '$periode%' 
                        AND g.id_gm = $id_rm
                        GROUP BY
                        g.id_gci) AS x
                    LEFT JOIN rsp_project_live.view_spr s ON s.id_gci = x.no_booking";

        return $this->db->query($query)->result();
    }

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
                        LEFT JOIN rsp_project_live.t_gci g ON g.id_gci = a.id_gci
                        LEFT JOIN rsp_project_live.t_bic b ON b.id_gci = g.id_gci
                        WHERE SUBSTR(a.tgl_gci, 1, 7) = '$periode'
                        AND LEFT(LOWER(g.jenis_pembayaran), 4) != 'cash'
                        AND g.id_kategori >= 3
                        AND LEFT(g.blok, 2) != 'RD'
                        AND b.hasil_bic IN (1, 2)
                        AND a.id_gm = '$id_rm'
                        AND a.id_gm IN (18, 61, 238, 24099)
                    ) AS profilling
                    GROUP BY profilling.id_gm
                    ORDER BY COUNT(profilling.ket_prediksi) DESC
                ";

        return $this->db->query($query)->row();
    }
}
