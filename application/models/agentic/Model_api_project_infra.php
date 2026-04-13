<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_api_project_infra extends CI_Model
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

    function get_data_resume_all_project($start_date, $end_date)
    {
        $query = "SELECT
                x.id_project,
                'Lead Time Pekerjaan Infrastruktur' AS corporate_kpi,
                COUNT(*) AS total_pekerjaan,
                COUNT(IF(x.status_pekerjaan = 'COMPLETE', 1, NULL)) AS done,
                COUNT(IF(x.status_pekerjaan != 'COMPLETE', 1, NULL)) AS inprogress,
                COUNT(IF(x.status_leadtime = 'ONTIME', 1, NULL)) AS ontime,
                COUNT(IF(x.status_leadtime = 'LATE', 1, NULL)) AS late,
                ROUND(COUNT(IF(x.status_leadtime = 'ONTIME', 1, NULL)) / COUNT(*) * 100) AS avg_ontime
               FROM
                (
                   SELECT
                    td.id_inf,
                    RTRIM(pic.employee_name) AS pengawas,
                    RTRIM(pm.employee_name) AS pm_name,
                    RTRIM(m.vendor) AS vendor,
                    t.judul,
                    td.project AS id_project,
                    p.project,
                    td.id_infrastruktur,
                    ma.infrastruktur AS pekerjaan_infrastruktur,
                    td.spk_awal,
                    td.spk_akhir,
                    COALESCE(ti.created_at,CURRENT_DATE) AS last_update,
                    IF
                    (
                        COALESCE(td.progres_pelaksana, 0) >= COALESCE(td.progres, 0),
                        COALESCE(td.progres_pelaksana, 0),
                    COALESCE(td.progres, 0)) AS progress,
                    CASE
                        
                        WHEN td.status_progres = 'Complete' THEN
                        'COMPLETE' ELSE 'ON PROGRESS' 
                    END AS status_pekerjaan,
                    CASE
                        
                        WHEN COALESCE(ti.created_at,CURRENT_DATE) <= td.spk_akhir THEN 'ONTIME' 
                        WHEN COALESCE(ti.created_at,CURRENT_DATE) > td.spk_akhir THEN
                        'LATE' ELSE '' 
                    END AS status_leadtime,
                    COALESCE(ti.jml_hari_kerja,0) AS jml_hari_kerja,
                    COALESCE(ti.ada_tukang,0) AS ada_tukang,
                    COALESCE(ti.tidak_ada_tukang,0) AS tidak_ada_tukang,
                    COALESCE(ti.ketersediaan_mpp,0) AS ketersediaan_mpp
                        FROM
                        rsp_project_live.t_infrastruktur_detail td
                        JOIN rsp_project_live.t_infrastruktur t ON t.id_inf = td.id_inf
                        LEFT JOIN (
                            SELECT
                            x.id_inf,
                            x.id_project,
                            x.id_infrastruktur,
                            MAX(DATE(x.created_at)) AS created_at,
                            COUNT(DISTINCT DATE(x.created_at)) AS jml_hari_kerja,
                            SUM(x.ada_tukang) AS ada_tukang,
                            SUM(x.tidak_ada_tukang) AS tidak_ada_tukang,
                            ROUND(SUM(x.ada_tukang) / COUNT(DISTINCT DATE(x.created_at)) * 100) AS ketersediaan_mpp 
                            FROM
                            (
                                SELECT
                                t.id_inf,
                                t.project AS id_project,
                                t.infrastruktur AS id_infrastruktur,
                                ma.infrastruktur,
                                MAX(t.created_at) AS created_at,
                                IF
                                (COALESCE(t.mpp, 0) > 0, 1, 0) AS ada_tukang,
                                IF
                                (COALESCE(t.mpp, 0) = 0, 1, 0) AS tidak_ada_tukang 
                                FROM
                                rsp_project_live.t_task_infra t
                                LEFT JOIN rsp_project_live.m_jenis_infra ma ON ma.id = t.infrastruktur 
                                GROUP BY
                            DATE(t.created_at), t.id_inf, t.project, t.infrastruktur
                            ) AS x 
                            GROUP BY
                            x.id_inf,
                            x.id_project,
                        x.id_infrastruktur) ti ON ti.id_inf = td.id_inf 
                        AND ti.id_project = td.project 
                        AND ti.id_infrastruktur = td.id_infrastruktur
                        LEFT JOIN rsp_project_live.m_vendor m ON t.vendor = m.id_vendor
                        LEFT JOIN rsp_project_live.m_jenis_infra ma ON ma.id = td.id_infrastruktur
                        LEFT JOIN rsp_project_live.m_project p ON p.id_project = td.project
                        LEFT JOIN rsp_project_live.`user` pic ON pic.id_user = td.pic 
                        LEFT JOIN rsp_project_live.`user` pm ON pm.id_user = p.pm_infra
                        WHERE
                        td.spk_awal != '0000-00-00' 
                        AND (td.spk_awal BETWEEN '$start_date' AND '$end_date' OR td.spk_akhir BETWEEN '$start_date' AND '$end_date') 
                    ORDER BY
                        td.spk_awal) AS x";
        return $this->db->query($query)->row();
    }

    function get_data_resume($id_project, $start_date, $end_date)
    {
        $query = "SELECT
                x.id_project,
                'Lead Time Pekerjaan Infrastruktur' AS corporate_kpi,
                x.project AS project_name,
                x.pm_name AS project_manager,
                GROUP_CONCAT(DISTINCT RTRIM(x.pengawas)) AS pengawas,
                GROUP_CONCAT(DISTINCT RTRIM(x.vendor)) AS vendor,
                COUNT(*) AS total_pekerjaan,
                COUNT(IF(x.status_pekerjaan = 'COMPLETE', 1, NULL)) AS done,
                COUNT(IF(x.status_pekerjaan != 'COMPLETE', 1, NULL)) AS inprogress,
                COUNT(IF(x.status_leadtime = 'ONTIME', 1, NULL)) AS ontime,
                COUNT(IF(x.status_leadtime = 'LATE', 1, NULL)) AS late,
                ROUND(COUNT(IF(x.status_leadtime = 'ONTIME', 1, NULL)) / COUNT(*) * 100) AS avg_ontime,
                SUM(x.jml_hari_kerja) AS jml_hari_kerja,
                SUM(x.ada_tukang) AS realisasi_manpower,
                SUM(x.tidak_ada_tukang) AS absen_manpower,
                ROUND(SUM(x.ada_tukang) / SUM(x.jml_hari_kerja) * 100) AS avg_ketersediaan_manpower
                FROM
                (
                   SELECT
                    td.id_inf,
                    RTRIM(pic.employee_name) AS pengawas,
                    RTRIM(pm.employee_name) AS pm_name,
                    RTRIM(m.vendor) AS vendor,
                    t.judul,
                    td.project AS id_project,
                    p.project,
                    td.id_infrastruktur,
                    ma.infrastruktur AS pekerjaan_infrastruktur,
                    td.spk_awal,
                    td.spk_akhir,
                    COALESCE(ti.created_at,CURRENT_DATE) AS last_update,
                    IF
                    (
                        COALESCE(td.progres_pelaksana, 0) >= COALESCE(td.progres, 0),
                        COALESCE(td.progres_pelaksana, 0),
                    COALESCE(td.progres, 0)) AS progress,
                    CASE
                        
                        WHEN td.status_progres = 'Complete' THEN
                        'COMPLETE' ELSE 'ON PROGRESS' 
                    END AS status_pekerjaan,
                    CASE
                        
                        WHEN COALESCE(ti.created_at,CURRENT_DATE) <= td.spk_akhir THEN 'ONTIME' 
                        WHEN COALESCE(ti.created_at,CURRENT_DATE) > td.spk_akhir THEN
                        'LATE' ELSE '' 
                    END AS status_leadtime,
                    COALESCE(ti.jml_hari_kerja,0) AS jml_hari_kerja,
                    COALESCE(ti.ada_tukang,0) AS ada_tukang,
                    COALESCE(ti.tidak_ada_tukang,0) AS tidak_ada_tukang,
                    COALESCE(ti.ketersediaan_mpp,0) AS ketersediaan_mpp
                        FROM
                        rsp_project_live.t_infrastruktur_detail td
                        JOIN rsp_project_live.t_infrastruktur t ON t.id_inf = td.id_inf
                        LEFT JOIN (
                            SELECT
                            x.id_inf,
                            x.id_project,
                            x.id_infrastruktur,
                            MAX(DATE(x.created_at)) AS created_at,
                            COUNT(DISTINCT DATE(x.created_at)) AS jml_hari_kerja,
                            SUM(x.ada_tukang) AS ada_tukang,
                            SUM(x.tidak_ada_tukang) AS tidak_ada_tukang,
                            ROUND(SUM(x.ada_tukang) / COUNT(DISTINCT DATE(x.created_at)) * 100) AS ketersediaan_mpp 
                            FROM
                            (
                                SELECT
                                t.id_inf,
                                t.project AS id_project,
                                t.infrastruktur AS id_infrastruktur,
                                ma.infrastruktur,
                                MAX(t.created_at) AS created_at,
                                IF
                                (COALESCE(t.mpp, 0) > 0, 1, 0) AS ada_tukang,
                                IF
                                (COALESCE(t.mpp, 0) = 0, 1, 0) AS tidak_ada_tukang 
                                FROM
                                rsp_project_live.t_task_infra t
                                LEFT JOIN rsp_project_live.m_jenis_infra ma ON ma.id = t.infrastruktur 
                                WHERE
                                project = $id_project 
                                GROUP BY
                            DATE(t.created_at), t.id_inf, t.project, t.infrastruktur
                            ) AS x 
                            GROUP BY
                            x.id_inf,
                            x.id_project,
                        x.id_infrastruktur) ti ON ti.id_inf = td.id_inf 
                        AND ti.id_project = td.project 
                        AND ti.id_infrastruktur = td.id_infrastruktur
                        LEFT JOIN rsp_project_live.m_vendor m ON t.vendor = m.id_vendor
                        LEFT JOIN rsp_project_live.m_jenis_infra ma ON ma.id = td.id_infrastruktur
                        LEFT JOIN rsp_project_live.m_project p ON p.id_project = td.project
                        LEFT JOIN rsp_project_live.`user` pic ON pic.id_user = td.pic 
                        LEFT JOIN rsp_project_live.`user` pm ON pm.id_user = p.pm_infra
                        WHERE
                        td.project = $id_project 
                        AND td.spk_awal != '0000-00-00' 
                        AND (td.spk_awal BETWEEN '$start_date' AND '$end_date' OR td.spk_akhir BETWEEN '$start_date' AND '$end_date') 
                    ORDER BY
                        td.spk_awal) AS x";
        return $this->db->query($query)->row();
    }

    function check_spk($id_project, $start_date, $end_date)
    {
        $query = "SELECT td.id_inf FROM rsp_project_live.t_infrastruktur_detail td WHERE td.project = '$id_project' 
                        AND td.spk_awal != '0000-00-00' 
                        AND (td.spk_awal BETWEEN '$start_date' AND '$end_date' OR td.spk_akhir BETWEEN '$start_date' AND '$end_date')";
        return $this->db->query($query)->num_rows();
    }

    function get_data_resume_gangguan_cuaca($id_project, $start_date, $end_date)
    {
        $query = "SELECT
                    -- SUM(c.jam_kerja) AS total_jam_kerja,
                    -- SUM(c.jam_hujan) AS jml_jam_terjadi_hujan,
                    '10%' AS target_gangguan_cuaca,
                    CONCAT(ROUND(SUM(c.jam_hujan) / SUM(c.jam_kerja) * 100),'%') AS avg_gangguan_cuaca
                    FROM
                    (
                        SELECT
                        p.id_project,
                        DATE(w.`datetime`) AS tanggal,
                        8 AS jam_kerja,
                        COUNT(DISTINCT HOUR(w.`datetime`)) AS perubahan_cuaca,
                        COUNT(DISTINCT CASE WHEN w.weather_desc LIKE '%Hujan%' THEN HOUR(w.`datetime`) END) AS jam_hujan,
                        8 - COUNT(DISTINCT CASE WHEN w.weather_desc LIKE '%Hujan%' THEN HOUR(w.`datetime`) END) AS jam_tidak_hujan,
                        100 - ROUND(
                            COUNT(DISTINCT CASE WHEN w.weather_desc NOT LIKE '%Hujan%' THEN HOUR(w.`datetime`) END) / COUNT(DISTINCT HOUR(w.`datetime`)) * 100,
                        2) AS persen_gangguan_cuaca 
                        FROM
                        rsp_project_live.m_project p
                        LEFT JOIN (
                            SELECT
                            spk.project AS id_project,
                            MIN(spk.spk_awal) AS start_date,
                            MAX(spk.spk_akhir) AS end_date 
                            FROM
                            rsp_project_live.t_infrastruktur_detail spk 
                            WHERE
                            spk.project = $id_project 
                            AND spk.blok NOT LIKE 'X%' 
                            AND (spk.spk_awal BETWEEN '$start_date' AND '$end_date' OR spk.spk_akhir BETWEEN '$start_date' AND '$end_date')
                        ) AS r ON r.id_project = p.id_project
                        LEFT JOIN rsp_project_live.weather_data w ON w.adm4 = p.kode_bmkg 
                        AND DATE(w.`datetime`) BETWEEN r.start_date 
                        AND r.end_date 
                        AND TIME(w.`datetime`) BETWEEN '07:00:00' 
                        AND '17:00:00' 
                        WHERE
                        p.id_project = $id_project 
                        GROUP BY
                    DATE(w.`datetime`)) c";
        return $this->db->query($query)->row();
    }

    function get_data_detail_gangguan_cuaca($id_project, $start_date, $end_date)
    {
        $query = "SELECT
                        p.id_project,
                        DATE(w.`datetime`) AS tanggal,
                        8 AS jam_kerja,
                        COUNT(DISTINCT HOUR(w.`datetime`)) AS perubahan_cuaca,
                        COUNT(DISTINCT CASE WHEN w.weather_desc LIKE '%Hujan%' THEN HOUR(w.`datetime`) END) AS jam_hujan,
                        8 - COUNT(DISTINCT CASE WHEN w.weather_desc LIKE '%Hujan%' THEN HOUR(w.`datetime`) END) AS jam_tidak_hujan,
                        100 - ROUND(
                            COUNT(DISTINCT CASE WHEN w.weather_desc NOT LIKE '%Hujan%' THEN HOUR(w.`datetime`) END) / COUNT(DISTINCT HOUR(w.`datetime`)) * 100,
                        2) AS persen_gangguan_cuaca 
                        FROM
                        rsp_project_live.m_project p
                        LEFT JOIN (
                            SELECT
                            spk.project AS id_project,
                            MIN(spk.spk_awal) AS start_date,
                            MAX(spk.spk_akhir) AS end_date 
                            FROM
                            rsp_project_live.t_infrastruktur_detail spk 
                            WHERE
                            spk.project = $id_project 
                            AND spk.blok NOT LIKE 'X%' 
                            AND (spk.spk_awal BETWEEN '$start_date' AND '$end_date' OR spk.spk_akhir BETWEEN '$start_date' AND '$end_date')
                        ) AS r ON r.id_project = p.id_project
                        LEFT JOIN rsp_project_live.weather_data w ON w.adm4 = p.kode_bmkg 
                        AND DATE(w.`datetime`) BETWEEN r.start_date 
                        AND r.end_date 
                        AND TIME(w.`datetime`) BETWEEN '07:00:00' 
                        AND '17:00:00' 
                        WHERE
                        p.id_project = $id_project 
                        GROUP BY
                    DATE(w.`datetime`)
                    ORDER BY
                    DATE(w.`datetime`)";
        return $this->db->query($query)->result();
    }

    function get_problem($id_project, $periode)
    {
        $query = "SELECT
                    created_at AS tgl_input_problem,
                    id_infrastruktur,
                    @rownum := @rownum + 1 AS no_urut,
                    REPLACE(REGEXP_REPLACE (note_pelaksana, '<[^>]*>', ''), '&nbsp;', '') AS problem_di_lapangan 
                FROM
                    rsp_project_live.t_peringatan_vendor_infra,
                    (SELECT @rownum := 0) r 
                WHERE
                    `status` = 4 
                    AND SUBSTR(created_at, 1, 7) = '$periode' 
                    AND project = '$id_project' 
                GROUP BY
                    no_sp,
                    note_pelaksana 
                ORDER BY
                    created_at";
        return $this->db->query($query)->result();
    }

    function get_data_detail($id_project, $start_date, $end_date)
    {
        $query = "SELECT
                td.id_inf,
                RTRIM(pic.employee_name) AS pengawas,
                RTRIM(m.vendor) AS vendor,
                t.judul,
                td.project AS id_project,
                p.project,
                td.id_infrastruktur,
                ma.infrastruktur AS pekerjaan_infrastruktur,
                td.spk_awal,
                td.spk_akhir,
                ti.created_at AS last_update,
                IF(COALESCE(td.progres_pelaksana,0) >= COALESCE(td.progres,0), COALESCE(td.progres_pelaksana,0), COALESCE(td.progres,0)) AS progress,
                CASE WHEN td.status_progres = 'Complete' THEN 'COMPLETE' ELSE 'ON PROGRESS' END AS status_pekerjaan,
                CASE WHEN td.status_progres = 'Complete' AND ti.created_at <= td.spk_akhir THEN 'ONTIME' 
                WHEN td.status_progres = 'Complete' AND ti.created_at > td.spk_akhir THEN 'LATE' 
                ELSE '' END AS status_leadtime
                FROM
                rsp_project_live.t_infrastruktur_detail td
                JOIN rsp_project_live.t_infrastruktur t ON t.id_inf = td.id_inf
                LEFT JOIN (
                    SELECT
                    x.id_inf,
                    x.id_project,
                    x.id_infrastruktur,
                    MAX(DATE(x.created_at)) AS created_at,
                    COUNT(DISTINCT DATE(x.created_at)) AS jml_hari_kerja,
                    SUM(x.ada_tukang) AS ada_tukang,
                    SUM(x.tidak_ada_tukang) AS tidak_ada_tukang,
                    ROUND(SUM(x.ada_tukang) / COUNT(DISTINCT DATE(x.created_at)) * 100) AS ketersediaan_mpp 
                    FROM
                    (
                        SELECT
                        t.id_inf,
                        t.project AS id_project,
                        t.infrastruktur AS id_infrastruktur,
                        ma.infrastruktur,
                        MAX(t.created_at) AS created_at,
                        IF
                        (COALESCE(t.mpp, 0) > 0, 1, 0) AS ada_tukang,
                        IF
                        (COALESCE(t.mpp, 0) = 0, 1, 0) AS tidak_ada_tukang 
                        FROM
                        rsp_project_live.t_task_infra t
                        LEFT JOIN rsp_project_live.m_jenis_infra ma ON ma.id = t.infrastruktur 
                        WHERE
                        project = $id_project 
                        GROUP BY
                    DATE(t.created_at)) AS x 
                    GROUP BY
                    x.id_inf,
                    x.id_project,
                x.id_infrastruktur) ti ON ti.id_inf = td.id_inf AND ti.id_project = td.project AND ti.id_infrastruktur = td.id_infrastruktur
                LEFT JOIN rsp_project_live.m_vendor m ON t.vendor = m.id_vendor
                LEFT JOIN rsp_project_live.m_jenis_infra ma ON ma.id = td.id_infrastruktur
                LEFT JOIN rsp_project_live.m_project p ON p.id_project = td.project
                LEFT JOIN rsp_project_live.`user` pic ON pic.id_user = td.pic
                WHERE
                td.project = $id_project AND td.spk_awal != '0000-00-00' AND (td.spk_awal BETWEEN '$start_date' AND '$end_date' OR td.spk_akhir BETWEEN '$start_date' AND '$end_date') ORDER BY td.spk_awal";
        return $this->db->query($query)->result();
    }
}
