<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_api_project_pm extends CI_Model
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

    function get_pm($id_pm)
    {
        $query = "SELECT
                p.pm_housing AS id,
                u.employee_name AS `name` 
            FROM
                rsp_project_live.m_project p
                LEFT JOIN rsp_project_live.`user` u ON u.id_user = p.pm_housing 
            WHERE
                p.pm_housing = $id_pm";
        return $this->db->query($query)->row();
    }

    function get_project($id_pm, $project_tipe)
    {
      $condition = "";
      if ($project_tipe == 'subsidi') {
          $condition = " AND mpu.project_tipe in (1,4)";
      } else if ($project_tipe == 'komersil') {
          $condition = " AND mpu.project_tipe in (2)";
      }

        $query = "SELECT
  p.id_project,
  p.project,
  'Lead Time Pekerjaan Housing' AS kpi_project_housing
FROM
  rsp_project_live.m_project p
  LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = p.id_project
WHERE
  p.pm_housing = $id_pm
  $condition
GROUP BY p.id_project";
        return $this->db->query($query)->result();
    }

    function get_problem($id_pm, $periode, $project_tipe)
    {
      $condition = "";
      if ($project_tipe == 'subsidi') {
          $condition = " AND mpu.project_tipe in (1,4)";
      } else if ($project_tipe == 'komersil') {
          $condition = " AND mpu.project_tipe in (2)";
      }

        $query = "SELECT
  pr_vendor.created_at AS tgl_input_problem,
  prj.project,
  pr_vendor.blok,
  REPLACE(REGEXP_REPLACE (note_pelaksana, '<[^>]*>', ''), '&nbsp;', '') AS problem_di_lapangan
FROM
  rsp_project_live.t_peringatan_vendor AS pr_vendor
  LEFT JOIN (SELECT
pr.*
FROM
 rsp_project_live.m_project pr 
 LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = pr.id_project
WHERE
  pr.pm_housing IS NOT NULL
  $condition
GROUP BY pr.id_project) prj ON prj.id_project = pr_vendor.project
WHERE
  pr_vendor.`status` = 4
  AND SUBSTR(pr_vendor.created_at, 1, 7) = '$periode'
  AND prj.pm_housing = $id_pm
GROUP BY
  pr_vendor.no_sp,
  pr_vendor.note_pelaksana
ORDER BY
  pr_vendor.created_at";
        return $this->db->query($query)->result();
    }

    function get_detail($id_pm, $periode, $project_tipe)
    {
      $condition = "";
      if ($project_tipe == 'subsidi') {
          $condition = " AND mpu.project_tipe in (1,4)";
      } else if ($project_tipe == 'komersil') {
          $condition = " AND mpu.project_tipe in (2)";
      }
        $query = "WITH detail_mpp AS (
    SELECT
        * 
    FROM
        (
        SELECT
            t.project,
            t.blok,
            t.progres,
            t.created_at,
            t.mpp,
            t.status_material,
            ROW_NUMBER() OVER (PARTITION BY DATE(t.created_at), t.project, t.blok ORDER BY t.id_task DESC) AS rn 
        FROM
            rsp_project_live.t_task_rumah t 
            LEFT JOIN rsp_project_live.m_project prj ON prj.id_project = t.project
        WHERE
        prj.pm_housing = $id_pm) tmp 
    WHERE
    rn = 1
),
range_date AS (
    SELECT
        MIN(spk.tgl_spk) AS start_date,
        MAX(spk.tgl_spk_akhir) AS end_date 
    FROM
        rsp_project_live.t_project_bangun_detail spk 
        LEFT JOIN rsp_project_live.m_project prj ON prj.id_project = spk.id_project
    WHERE
        prj.pm_housing = $id_pm
        AND spk.blok NOT LIKE 'X%' 
    AND (LEFT(spk.tgl_spk, 7) = '$periode' OR LEFT(spk.tgl_spk_akhir, 7) = '$periode')
),
data_cuaca AS (
    SELECT
        p.id_project,
        DATE(w.`datetime`) AS tanggal,
        8 AS jam_kerja,
        COUNT(DISTINCT HOUR(w.`datetime`)) AS perubahan_cuaca,
        COUNT(DISTINCT CASE WHEN w.weather_desc LIKE '%Hujan%' THEN HOUR(w.`datetime`) END) AS jam_hujan,
        8 - COUNT(DISTINCT CASE WHEN w.weather_desc LIKE '%Hujan%' THEN HOUR(w.`datetime`) END) AS jam_tidak_hujan,
        ROUND(
        COUNT(DISTINCT CASE WHEN w.weather_desc NOT LIKE '%Hujan%' THEN HOUR(w.`datetime`) END) / COUNT(DISTINCT HOUR(w.`datetime`)) * 100,
        2) AS persen_tidak_hujan 
    FROM
        rsp_project_live.m_project p
        JOIN range_date r
        LEFT JOIN rsp_project_live.weather_data w ON w.adm4 = p.kode_bmkg 
        AND DATE(w.`datetime`) BETWEEN r.start_date 
        AND r.end_date 
        AND TIME(w.`datetime`) BETWEEN '07:00:00' 
        AND '17:00:00' 
    WHERE
        p.pm_housing = $id_pm 
    GROUP BY
    DATE(w.`datetime`)
),
pengawasan AS (
    SELECT
        project,
        blok,
        MAX(p_10) AS p_10,
        MAX(p_30) AS p_30,
        MAX(p_60) AS p_60,
        MAX(p_85) AS p_85,
        MAX(p_100) AS p_100 
    FROM
        (
        SELECT
            tp.project,
            tp.blok,
        CASE
            
            WHEN tp.pengawasan = 1 THEN
            DATE(tp.approved_at) 
            END AS p_10,
        CASE
            
            WHEN tp.pengawasan = 2 THEN
            DATE(tp.approved_at) 
            END AS p_30,
        CASE
            
            WHEN tp.pengawasan = 4 THEN
            DATE(tp.approved_at) 
            END AS p_60,
        CASE
            
            WHEN tp.pengawasan = 5 THEN
            DATE(tp.approved_at) 
            END AS p_85,
        CASE
            
            WHEN tp.pengawasan = 6 THEN
            DATE(tp.approved_at) 
            END AS p_100 
        FROM
            rsp_project_live.t_pengawasan tp
            LEFT JOIN rsp_project_live.m_project prj ON prj.id_project = tp.project
        WHERE
            tp.approve = 2 
            AND tp.blok NOT LIKE 'X%' 
        AND prj.pm_housing = $id_pm
        ) x 
    GROUP BY
        tp.project,
    tp.blok
) 
SELECT
    x.id_project,
    x.blok,
    data_cuaca.tanggal,
    x.spk_awal,
    x.spk_akhir,
    x.expected_progres,
    x.progres_pelaksana AS current_progress,
    CASE
        
        WHEN x.expected_progres = 100 THEN
        IF
        (COALESCE(x.p_100, CURRENT_DATE) <= x.t_100, 'ontime', 'late') 
        WHEN x.expected_progres = 85 THEN
        IF
        (COALESCE(x.p_85, CURRENT_DATE) <= x.t_85, 'ontime', 'late') 
        WHEN x.expected_progres = 60 THEN
        IF
        (COALESCE(x.p_60, CURRENT_DATE) <= x.t_60, 'ontime', 'late') 
        WHEN x.expected_progres = 30 THEN
        IF
        (COALESCE(x.p_30, CURRENT_DATE) <= x.t_30, 'ontime', 'late') 
        WHEN x.expected_progres = 10 THEN
        IF
        (COALESCE(x.p_10, CURRENT_DATE) <= x.t_10, 'ontime', 'late') 
    END AS `status`,
    x.jumlah_hari_tukang_valid,
    x.jumlah_hari_total_kerja,
    COALESCE(x.produktifitas_tukang,0) AS avg_produktifitas_tukang,
    x.jml_hari_material_kosong,
    ROUND(SUM(data_cuaca.jam_hujan)/SUM(data_cuaca.jam_kerja)*100) avg_gangguan_cuaca
FROM
(
    SELECT
    spk.id_project,
    spk.blok,
    spk.tgl_spk AS spk_awal,
    spk.tgl_spk_akhir AS spk_akhir,
    DATE_ADD(spk.tgl_spk, INTERVAL 5 DAY) AS t_10,
    pengawasan.p_10,
    DATE_ADD(spk.tgl_spk, INTERVAL 11 DAY) AS t_30,
    pengawasan.p_30,
    DATE_ADD(spk.tgl_spk, INTERVAL 21 DAY) AS t_60,
    pengawasan.p_60,
    DATE_ADD(spk.tgl_spk, INTERVAL 28 DAY) AS t_85,
    pengawasan.p_85,
    spk.tgl_spk_akhir AS t_100,
    IF
    (
        MAX(ROUND(COALESCE(d.progres, 0))) = 100,
        DATE(mpu.tgl_vendor),
        pengawasan.p_100) AS p_100,
        MAX(ROUND(COALESCE(d.progres, 0))) AS progres_pelaksana,
        CASE
            
            WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 5 DAY) THEN
            10 
            WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 11 DAY) THEN
            30 
            WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 21 DAY) THEN
            60 
            WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 28 DAY) THEN
            85 ELSE 100 
        END AS expected_progres,
        SUM(IF(COALESCE(d.mpp, 0) >= 2, 1, 0)) AS jumlah_hari_tukang_valid,
        COUNT(DISTINCT DATE(d.created_at)) AS jumlah_hari_total_kerja,
        ROUND(
            (
            SUM(IF(COALESCE(d.mpp, 0) >= 2, 1, 0)) / NULLIF(COUNT(DISTINCT DATE(d.created_at)), 0)) * 100) AS produktifitas_tukang,
        SUM(IF(COALESCE(d.status_material, '') = 'On Site', 0, 1)) AS jml_hari_material_kosong 
    FROM
    rsp_project_live.t_project_bangun_detail spk
    LEFT JOIN detail_mpp d ON d.project = spk.id_project AND d.blok = spk.blok AND DATE(d.created_at) >= DATE(spk.tgl_spk)
    LEFT JOIN pengawasan ON pengawasan.project = spk.id_project AND pengawasan.blok = spk.blok
    LEFT JOIN rsp_project_live.t_project_bangun prj ON prj.id_rencana = spk.id_rencana
    LEFT JOIN rsp_project_live.m_vendor ON m_vendor.id_vendor = prj.vendor
    LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = spk.id_project AND mpu.blok = spk.blok 
    LEFT JOIN rsp_project_live.m_project pr ON pr.id_project = spk.id_project
    WHERE
    pr.pm_housing = $id_pm 
    AND spk.blok NOT LIKE 'X%' 
    AND (LEFT(spk.tgl_spk, 7) = '$periode' OR LEFT(spk.tgl_spk_akhir, 7) = '$periode') 
    $condition
    GROUP BY
    pr.pm_housing,
spk.blok) x
LEFT JOIN data_cuaca ON data_cuaca.tanggal BETWEEN x.spk_awal 
AND x.spk_akhir
GROUP BY x.id_project, x.blok
ORDER BY x.blok, x.spk_awal, data_cuaca.tanggal";
        return $this->db->query($query)->result();
    }

    // new query style

    function get_produktivitas($id_pm, $periode, $project_tipe)
    {
      $condition = "";
      if ($project_tipe == 'subsidi') {
          $condition = " AND mpu.project_tipe in (1,4)";
      } else if ($project_tipe == 'komersil') {
          $condition = " AND mpu.project_tipe in (2)";
      }
        $query = "SELECT
  r.project,
  SUM(r.produktif) AS produktif,
  100 * ROUND(
    SUM(r.produktif) / (SUM(r.produktif) + SUM(r.kurang_produktif) + SUM(r.tidak_produktif)),
    2
  ) AS persen_produktif,
  SUM(r.kurang_produktif) AS kurang_produktif,
  100 * ROUND(
    SUM(r.kurang_produktif) / (SUM(r.produktif) + SUM(r.kurang_produktif) + SUM(r.tidak_produktif)),
    2
  ) AS persen_kurang_produktif,
  SUM(r.tidak_produktif) AS tidak_produktif,
  100 * ROUND(
    SUM(r.tidak_produktif) / (SUM(r.produktif) + SUM(r.kurang_produktif) + SUM(r.tidak_produktif)),
    2
  ) AS persen_tidak_produktif
FROM
  (
    SELECT
      x.project,
      x.blok,
      SUM(x.produktif) AS produktif,
      ROUND(
        SUM(x.produktif) / (SUM(x.produktif) + SUM(x.kurang_produktif) + SUM(x.tidak_produktif)) * 100,
        2
      ) AS persen_produktif,
      SUM(x.kurang_produktif) AS kurang_produktif,
      ROUND(
        SUM(x.kurang_produktif) / (SUM(x.produktif) + SUM(x.kurang_produktif) + SUM(x.tidak_produktif)) * 100,
        2
      ) AS persen_kurang_produktif,
      SUM(x.tidak_produktif) AS tidak_produktif,
      ROUND(
        SUM(x.tidak_produktif) / (SUM(x.produktif) + SUM(x.kurang_produktif) + SUM(x.tidak_produktif)) * 100,
        2
      ) AS persen_tidak_produktif,
      SUM(x.produktif) + SUM(x.kurang_produktif) + SUM(x.tidak_produktif) AS total_hari_kerja
    FROM
      (
        SELECT
          t.project,
          t.blok,
          MIN(range_date.start_date) AS start_date,
          MAX(range_date.end_date) AS end_date,
          DATE(t.created_at) AS created_at,
          MAX(t.mpp) AS mpp,
          IF(COALESCE(MAX(t.mpp), 0) >= 2, 1, 0) AS produktif,
          IF(COALESCE(MAX(t.mpp), 0) = 1, 1, 0) AS kurang_produktif,
          IF(COALESCE(MAX(t.mpp), 0) = 0, 1, 0) AS tidak_produktif
        FROM
          rsp_project_live.t_task_rumah t
          JOIN (
            SELECT
              MIN(spk.tgl_spk) AS start_date,
              MAX(spk.tgl_spk_akhir) AS end_date
            FROM
              rsp_project_live.t_project_bangun_detail spk
              LEFT JOIN (SELECT
pr.*
FROM
 rsp_project_live.m_project pr 
 LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = pr.id_project
WHERE
  pr.pm_housing IS NOT NULL
  $condition
GROUP BY pr.id_project) pr ON pr.id_project = spk.id_project
            WHERE
              pr.pm_housing = $id_pm
              AND spk.blok NOT LIKE 'X%'
              AND (LEFT(spk.tgl_spk, 7) = '$periode' OR LEFT(spk.tgl_spk_akhir, 7) = '$periode')
          ) AS range_date ON DATE(t.created_at) BETWEEN range_date.start_date
          AND range_date.end_date
          LEFT JOIN (SELECT
pr.*
FROM
 rsp_project_live.m_project pr 
 LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = pr.id_project
WHERE
  pr.pm_housing IS NOT NULL
  $condition
GROUP BY pr.id_project) pr ON pr.id_project = t.project
        WHERE
          pr.pm_housing = $id_pm
        GROUP BY
          t.project,
          t.blok,
          DATE(t.created_at)
        ORDER BY
          DATE(t.created_at),
          t.blok
      ) AS x
    GROUP BY
      x.blok
  ) AS r";
        return $this->db->query($query)->row();
    }

    // ambil 5 blok dengan produktivitas terendah
    function get_5_blok_produktivitas_terendah($id_pm, $periode, $project_tipe)
    {
      $condition = "";
      if ($project_tipe == 'subsidi') {
          $condition = " AND mpu.project_tipe in (1,4)";
      } else if ($project_tipe == 'komersil') {
          $condition = " AND mpu.project_tipe in (2)";
      }

        $query = "SELECT
  xy.project AS id_project,
  xy.nama_project,
  xy.blok,
  xy.tidak_produktif AS hari_tanpa_kehadiran_tukang,
  xy.total_hari_kerja,
  v.vendor AS nama_vendor,
  CONCAT('Dari total ', xy.total_hari_kerja, ' hari kerja, terdapat ', xy.tidak_produktif, ' hari tanpa kehadiran tukang') AS keterangan
FROM
  (
    SELECT
      x.project,
      x.nama_project,
      x.blok,
      x.vendor,
      SUM(x.produktif) AS produktif,
      ROUND(
        SUM(x.produktif) / (SUM(x.produktif) + SUM(x.kurang_produktif) + SUM(x.tidak_produktif)) * 100,
        2
      ) AS persen_produktif,
      SUM(x.kurang_produktif) AS kurang_produktif,
      ROUND(
        SUM(x.kurang_produktif) / (SUM(x.produktif) + SUM(x.kurang_produktif) + SUM(x.tidak_produktif)) * 100,
        2
      ) AS persen_kurang_produktif,
      SUM(x.tidak_produktif) AS tidak_produktif,
      ROUND(
        SUM(x.tidak_produktif) / (SUM(x.produktif) + SUM(x.kurang_produktif) + SUM(x.tidak_produktif)) * 100,
        2
      ) AS persen_tidak_produktif,
      SUM(x.produktif) + SUM(x.kurang_produktif) + SUM(x.tidak_produktif) AS total_hari_kerja
    FROM
      (
        SELECT
          t.project,
          pr.project as nama_project,
          t.blok,
          range_date.vendor,
          MIN(range_date.start_date) AS start_date,
          MAX(range_date.end_date) AS end_date,
          DATE(t.created_at) AS created_at,
          MAX(t.mpp) AS mpp,
          IF(COALESCE(MAX(t.mpp), 0) >= 2, 1, 0) AS produktif,
          IF(COALESCE(MAX(t.mpp), 0) = 1, 1, 0) AS kurang_produktif,
          IF(COALESCE(MAX(t.mpp), 0) = 0, 1, 0) AS tidak_produktif
        FROM
          rsp_project_live.t_task_rumah t
          JOIN (
            SELECT
              MIN(spk.tgl_spk) AS start_date,
              MAX(spk.tgl_spk_akhir) AS end_date,
              sp.vendor
            FROM
              rsp_project_live.t_project_bangun_detail spk
              LEFT JOIN rsp_project_live.t_project_bangun sp ON sp.id_rencana = spk.id_rencana
              LEFT JOIN (SELECT
pr.*
FROM
 rsp_project_live.m_project pr 
 LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = pr.id_project
WHERE
  pr.pm_housing IS NOT NULL
  $condition
GROUP BY pr.id_project) pr ON pr.id_project = spk.id_project
            WHERE
              pr.pm_housing = $id_pm
              AND spk.blok NOT LIKE 'X%'
              AND (LEFT(spk.tgl_spk, 7) = '$periode' OR LEFT(spk.tgl_spk_akhir, 7) = '$periode')
          ) AS range_date ON DATE(t.created_at) BETWEEN range_date.start_date
          AND range_date.end_date
          LEFT JOIN (SELECT
pr.*
FROM
 rsp_project_live.m_project pr 
 LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = pr.id_project
WHERE
  pr.pm_housing IS NOT NULL
  $condition
GROUP BY pr.id_project) pr ON pr.id_project = t.project
        WHERE
          pr.pm_housing = $id_pm
        GROUP BY
          t.project,
          t.blok,
          DATE(t.created_at)
        ORDER BY
          DATE(t.created_at),
          t.blok
      ) AS x
    GROUP BY
      x.blok
  ) AS xy
  LEFT JOIN rsp_project_live.m_vendor v ON v.id_vendor = xy.vendor
ORDER BY
  xy.tidak_produktif DESC,
  xy.total_hari_kerja DESC
  LIMIT 5";
        return $this->db->query($query)->result();
    }

    function kpi_pm($id_pm, $periode, $project_tipe)
    {
      $condition = "";
      if ($project_tipe == 'subsidi') {
          $condition = " AND mpu.project_tipe in (1,4)";
      } else if ($project_tipe == 'komersil') {
          $condition = " AND mpu.project_tipe in (2)";
      }
        $query = "WITH pengawasan AS (
  SELECT
        project,
        blok,
        MAX(p_10) AS p_10,
        MAX(p_30) AS p_30,
        MAX(p_60) AS p_60,
        MAX(p_85) AS p_85,
        MAX(p_100) AS p_100 
    FROM
        (
        SELECT
            tp.project,
            tp.blok,
        CASE
            
            WHEN tp.pengawasan = 1 THEN
            DATE(tp.approved_at) 
            END AS p_10,
        CASE
            
            WHEN tp.pengawasan = 2 THEN
            DATE(tp.approved_at) 
            END AS p_30,
        CASE
            
            WHEN tp.pengawasan = 4 THEN
            DATE(tp.approved_at) 
            END AS p_60,
        CASE
            
            WHEN tp.pengawasan = 5 THEN
            DATE(tp.approved_at) 
            END AS p_85,
        CASE
            
            WHEN tp.pengawasan = 6 THEN
            DATE(tp.approved_at) 
            END AS p_100 
        FROM
            rsp_project_live.t_pengawasan tp
            LEFT JOIN (SELECT
pr.*
FROM
 rsp_project_live.m_project pr 
 LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = pr.id_project
WHERE
  pr.pm_housing IS NOT NULL
  $condition
GROUP BY pr.id_project) prj ON prj.id_project = tp.project
        WHERE
            tp.approve = 2 
            AND tp.blok NOT LIKE 'X%' 
        AND prj.pm_housing = $id_pm
        ) x 
    GROUP BY
        tp.project,
    tp.blok
) SELECT
  COALESCE(jml_blok,1) AS target,
  COALESCE(SUM(IF(xx.`status` = 'ontime', jml_blok, 0)),0) AS actual,
  ROUND(100, 1) as target_persentase,
  COALESCE(ROUND(COALESCE(SUM(IF(xx.`status` = 'ontime', jml_blok, 0)),0) / COALESCE(jml_blok,1) * 100, 1), 0) AS achieve_persentase,
  IF(
    ROUND(SUM(IF(xx.`status` = 'ontime', jml_blok, 0)) / SUM(jml_blok) * 100) >= 100,
    'Ontime',
    'Late'
  ) `status`
FROM
  (
    SELECT
      CASE
        WHEN
          x.expected_progres = 100 THEN
          IF(COALESCE(x.p_100, CURRENT_DATE) <= x.t_100 AND x.p_85 IS NOT NULL, 'ontime', 'late')
        WHEN x.expected_progres = 85 THEN
          IF(COALESCE(x.p_85, CURRENT_DATE) <= x.t_85 AND x.p_60 IS NOT NULL, 'ontime', 'late')
        WHEN x.expected_progres = 60 THEN
          IF(COALESCE(x.p_60, CURRENT_DATE) <= x.t_60 AND x.p_30 IS NOT NULL, 'ontime', 'late')
        WHEN x.expected_progres = 30 THEN
          IF(COALESCE(x.p_30, CURRENT_DATE) <= x.t_30 AND x.p_10 IS NOT NULL, 'ontime', 'late')
        WHEN x.expected_progres = 10 THEN
          IF(COALESCE(x.p_10, CURRENT_DATE) <= x.t_10, 'ontime', 'late')
      END AS `status`,
      COUNT(DISTINCT x.blok) jml_blok,
      ROUND(
        SUM(IF(x.deviasi_progres > 0, x.deviasi_progres, 0)) / COUNT(IF(x.deviasi_progres > 0, x.deviasi_progres, NULL))
      ) AS avg_deviasi_progres,
      ROUND(
        SUM(
          DATEDIFF(
            CURRENT_DATE,
            CASE
              WHEN x.expected_progres = 100 THEN
                CASE
                  WHEN p_10 IS NULL THEN
                    t_10
                  WHEN p_30 IS NULL THEN
                    t_30
                  WHEN p_60 IS NULL THEN
                    t_60
                  WHEN p_85 IS NULL THEN
                    t_85
                  ELSE
                    t_100
                END
              WHEN x.expected_progres = 85 THEN
                CASE
                  WHEN p_10 IS NULL THEN
                    t_10
                  WHEN p_30 IS NULL THEN
                    t_30
                  WHEN p_60 IS NULL THEN
                    t_60
                  ELSE
                    t_85
                END
              WHEN x.expected_progres = 60 THEN
                CASE
                  WHEN p_10 IS NULL THEN
                    t_10
                  WHEN p_30 IS NULL THEN
                    t_30
                  ELSE
                    t_60
                END
              WHEN x.expected_progres = 30 THEN
                CASE
                  WHEN p_10 IS NULL THEN
                    t_10
                  ELSE
                    t_30
                END
              WHEN x.expected_progres = 10 THEN
                t_10
            END
          )
        ) / COUNT(
          DATEDIFF(
            CURRENT_DATE,
            CASE
              WHEN x.expected_progres = 100 THEN
                CASE
                  WHEN p_10 IS NULL THEN
                    t_10
                  WHEN p_30 IS NULL THEN
                    t_30
                  WHEN p_60 IS NULL THEN
                    t_60
                  WHEN p_85 IS NULL THEN
                    t_85
                  ELSE
                    t_100
                END
              WHEN x.expected_progres = 85 THEN
                CASE
                  WHEN p_10 IS NULL THEN
                    t_10
                  WHEN p_30 IS NULL THEN
                    t_30
                  WHEN p_60 IS NULL THEN
                    t_60
                  ELSE
                    t_85
                END
              WHEN x.expected_progres = 60 THEN
                CASE
                  WHEN p_10 IS NULL THEN
                    t_10
                  WHEN p_30 IS NULL THEN
                    t_30
                  ELSE
                    t_60
                END
              WHEN x.expected_progres = 30 THEN
                CASE
                  WHEN p_10 IS NULL THEN
                    t_10
                  ELSE
                    t_30
                END
              WHEN x.expected_progres = 10 THEN
                t_10
            END
          )
        )
      ) AS rata_rata_telat_hari
    FROM
      (
        SELECT
          spk.id_project,
          spk.blok,
          spk.tgl_spk AS spk_awal,
          spk.tgl_spk_akhir AS spk_akhir,
          DATE_ADD(spk.tgl_spk, INTERVAL 5 DAY) AS t_10,
          pengawasan.p_10,
          DATE_ADD(spk.tgl_spk, INTERVAL 11 DAY) AS t_30,
          pengawasan.p_30,
          DATE_ADD(spk.tgl_spk, INTERVAL 21 DAY) AS t_60,
          pengawasan.p_60,
          DATE_ADD(spk.tgl_spk, INTERVAL 28 DAY) AS t_85,
          pengawasan.p_85,
          spk.tgl_spk_akhir AS t_100,
          IF(
            MAX(ROUND(COALESCE(d.progres, 0))) = 100,
            DATE(mpu.tgl_vendor),
            pengawasan.p_100
          ) AS p_100,
          CASE
            WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 5 DAY) THEN
              10
            WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 11 DAY) THEN
              30
            WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 21 DAY) THEN
              60
            WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 28 DAY) THEN
              85
            ELSE
              100
          END AS expected_progres,
          MAX(ROUND(COALESCE(d.progres, 0))) AS progres_saat_ini,
          CASE
            WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 5 DAY) THEN
              10
            WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 11 DAY) THEN
              30
            WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 21 DAY) THEN
              60
            WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 28 DAY) THEN
              85
            ELSE
              100
          END - MAX(ROUND(COALESCE(d.progres, 0))) AS deviasi_progres
        FROM
          rsp_project_live.t_project_bangun_detail spk
          LEFT JOIN (
            SELECT
              t.project AS id_project,
              t.blok,
              ROUND(MAX(progres)) AS progres
            FROM
              rsp_project_live.t_task_rumah t
              JOIN (
                SELECT
                  MIN(spk.tgl_spk) AS spk_awal,
                  MAX(spk.tgl_spk_akhir) AS spk_akhir
                FROM
                  rsp_project_live.t_project_bangun_detail spk
                  LEFT JOIN (SELECT
pr.*
FROM
 rsp_project_live.m_project pr 
 LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = pr.id_project
WHERE
  pr.pm_housing IS NOT NULL
  $condition
GROUP BY pr.id_project) prj ON prj.id_project = spk.id_project
                WHERE
                  prj.pm_housing = $id_pm
                  AND spk.blok NOT LIKE 'X%'
                  AND (LEFT(spk.tgl_spk, 7) = '$periode' OR LEFT(spk.tgl_spk_akhir, 7) = '$periode')
              ) range_date ON DATE(t.created_at) BETWEEN range_date.spk_awal
              AND range_date.spk_akhir
              LEFT JOIN (SELECT
pr.*
FROM
 rsp_project_live.m_project pr 
 LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = pr.id_project
WHERE
  pr.pm_housing IS NOT NULL
  $condition
GROUP BY pr.id_project) prj ON prj.id_project = t.project
            WHERE
              prj.pm_housing = $id_pm
            GROUP BY
              t.project,
              t.blok
          ) d ON d.id_project = spk.id_project
          AND d.blok = spk.blok
          LEFT JOIN pengawasan ON pengawasan.project = spk.id_project
          AND pengawasan.blok = spk.blok
          LEFT JOIN rsp_project_live.t_project_bangun prj ON prj.id_rencana = spk.id_rencana
          LEFT JOIN rsp_project_live.m_vendor ON m_vendor.id_vendor = prj.vendor
          LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = spk.id_project
          AND mpu.blok = spk.blok
          LEFT JOIN rsp_project_live.m_project pr ON pr.id_project = spk.id_project
        WHERE
          pr.pm_housing = $id_pm
          AND spk.blok NOT LIKE 'X%'
          AND (LEFT(spk.tgl_spk, 7) = '$periode' OR LEFT(spk.tgl_spk_akhir, 7) = '$periode')
          $condition
        GROUP BY
          spk.id_project,
          spk.blok
      ) AS x
    GROUP BY
      CASE
        WHEN x.expected_progres = 100 THEN
          IF(COALESCE(x.p_100, CURRENT_DATE) <= x.t_100 AND x.p_85 IS NOT NULL, 'ontime', 'late')
        WHEN x.expected_progres = 85 THEN
          IF(COALESCE(x.p_85, CURRENT_DATE) <= x.t_85 AND x.p_60 IS NOT NULL, 'ontime', 'late')
        WHEN x.expected_progres = 60 THEN
          IF(COALESCE(x.p_60, CURRENT_DATE) <= x.t_60 AND x.p_30 IS NOT NULL, 'ontime', 'late')
        WHEN x.expected_progres = 30 THEN
          IF(COALESCE(x.p_30, CURRENT_DATE) <= x.t_30 AND x.p_10 IS NOT NULL, 'ontime', 'late')
        WHEN x.expected_progres = 10 THEN
          IF(COALESCE(x.p_10, CURRENT_DATE) <= x.t_10, 'ontime', 'late')
      END
  ) xx";
        return $this->db->query($query)->row();
    }

    function kpi_corporate($periode, $project_tipe)
    {
      $condition = "";
      if ($project_tipe == 'subsidi') {
          $condition = " AND mpu.project_tipe in (1,4)";
      } else if ($project_tipe == 'komersil') {
          $condition = " AND mpu.project_tipe in (2)";
      }
      $query = "WITH pengawasan AS (
  SELECT
        project,
        blok,
        MAX(p_10) AS p_10,
        MAX(p_30) AS p_30,
        MAX(p_60) AS p_60,
        MAX(p_85) AS p_85,
        MAX(p_100) AS p_100 
    FROM
        (
        SELECT
            tp.project,
            tp.blok,
        CASE
            
            WHEN tp.pengawasan = 1 THEN
            DATE(tp.approved_at) 
            END AS p_10,
        CASE
            
            WHEN tp.pengawasan = 2 THEN
            DATE(tp.approved_at) 
            END AS p_30,
        CASE
            
            WHEN tp.pengawasan = 4 THEN
            DATE(tp.approved_at) 
            END AS p_60,
        CASE
            
            WHEN tp.pengawasan = 5 THEN
            DATE(tp.approved_at) 
            END AS p_85,
        CASE
            
            WHEN tp.pengawasan = 6 THEN
            DATE(tp.approved_at) 
            END AS p_100 
        FROM
            rsp_project_live.t_pengawasan tp
        WHERE
            tp.approve = 2 
            AND tp.blok NOT LIKE 'X%'
        ) x 
    GROUP BY
        tp.project,
    tp.blok
) SELECT
  COALESCE(jml_blok,1) AS target,
  COALESCE(SUM(IF(xx.`status` = 'ontime', jml_blok, 0)),0) AS actual,
  ROUND(100, 1) as target_persentase,
  COALESCE(ROUND(COALESCE(SUM(IF(xx.`status` = 'ontime', jml_blok, 0)),0) / COALESCE(jml_blok,1) * 100, 1), 0) AS achieve_persentase,
  IF(
    ROUND(SUM(IF(xx.`status` = 'ontime', jml_blok, 0)) / SUM(jml_blok) * 100) >= 100,
    'Ontime',
    'Late'
  ) `status`
FROM
  (
    SELECT
      CASE
        WHEN
          x.expected_progres = 100 THEN
          IF(COALESCE(x.p_100, CURRENT_DATE) <= x.t_100 AND x.p_85 IS NOT NULL, 'ontime', 'late')
        WHEN x.expected_progres = 85 THEN
          IF(COALESCE(x.p_85, CURRENT_DATE) <= x.t_85 AND x.p_60 IS NOT NULL, 'ontime', 'late')
        WHEN x.expected_progres = 60 THEN
          IF(COALESCE(x.p_60, CURRENT_DATE) <= x.t_60 AND x.p_30 IS NOT NULL, 'ontime', 'late')
        WHEN x.expected_progres = 30 THEN
          IF(COALESCE(x.p_30, CURRENT_DATE) <= x.t_30 AND x.p_10 IS NOT NULL, 'ontime', 'late')
        WHEN x.expected_progres = 10 THEN
          IF(COALESCE(x.p_10, CURRENT_DATE) <= x.t_10, 'ontime', 'late')
      END AS `status`,
      COUNT(DISTINCT x.blok) jml_blok,
      ROUND(
        SUM(IF(x.deviasi_progres > 0, x.deviasi_progres, 0)) / COUNT(IF(x.deviasi_progres > 0, x.deviasi_progres, NULL))
      ) AS avg_deviasi_progres,
      ROUND(
        SUM(
          DATEDIFF(
            CURRENT_DATE,
            CASE
              WHEN x.expected_progres = 100 THEN
                CASE
                  WHEN p_10 IS NULL THEN
                    t_10
                  WHEN p_30 IS NULL THEN
                    t_30
                  WHEN p_60 IS NULL THEN
                    t_60
                  WHEN p_85 IS NULL THEN
                    t_85
                  ELSE
                    t_100
                END
              WHEN x.expected_progres = 85 THEN
                CASE
                  WHEN p_10 IS NULL THEN
                    t_10
                  WHEN p_30 IS NULL THEN
                    t_30
                  WHEN p_60 IS NULL THEN
                    t_60
                  ELSE
                    t_85
                END
              WHEN x.expected_progres = 60 THEN
                CASE
                  WHEN p_10 IS NULL THEN
                    t_10
                  WHEN p_30 IS NULL THEN
                    t_30
                  ELSE
                    t_60
                END
              WHEN x.expected_progres = 30 THEN
                CASE
                  WHEN p_10 IS NULL THEN
                    t_10
                  ELSE
                    t_30
                END
              WHEN x.expected_progres = 10 THEN
                t_10
            END
          )
        ) / COUNT(
          DATEDIFF(
            CURRENT_DATE,
            CASE
              WHEN x.expected_progres = 100 THEN
                CASE
                  WHEN p_10 IS NULL THEN
                    t_10
                  WHEN p_30 IS NULL THEN
                    t_30
                  WHEN p_60 IS NULL THEN
                    t_60
                  WHEN p_85 IS NULL THEN
                    t_85
                  ELSE
                    t_100
                END
              WHEN x.expected_progres = 85 THEN
                CASE
                  WHEN p_10 IS NULL THEN
                    t_10
                  WHEN p_30 IS NULL THEN
                    t_30
                  WHEN p_60 IS NULL THEN
                    t_60
                  ELSE
                    t_85
                END
              WHEN x.expected_progres = 60 THEN
                CASE
                  WHEN p_10 IS NULL THEN
                    t_10
                  WHEN p_30 IS NULL THEN
                    t_30
                  ELSE
                    t_60
                END
              WHEN x.expected_progres = 30 THEN
                CASE
                  WHEN p_10 IS NULL THEN
                    t_10
                  ELSE
                    t_30
                END
              WHEN x.expected_progres = 10 THEN
                t_10
            END
          )
        )
      ) AS rata_rata_telat_hari
    FROM
      (
        SELECT
          spk.id_project,
          spk.blok,
          spk.tgl_spk AS spk_awal,
          spk.tgl_spk_akhir AS spk_akhir,
          DATE_ADD(spk.tgl_spk, INTERVAL 5 DAY) AS t_10,
          pengawasan.p_10,
          DATE_ADD(spk.tgl_spk, INTERVAL 11 DAY) AS t_30,
          pengawasan.p_30,
          DATE_ADD(spk.tgl_spk, INTERVAL 21 DAY) AS t_60,
          pengawasan.p_60,
          DATE_ADD(spk.tgl_spk, INTERVAL 28 DAY) AS t_85,
          pengawasan.p_85,
          spk.tgl_spk_akhir AS t_100,
          IF(
            MAX(ROUND(COALESCE(d.progres, 0))) = 100,
            DATE(mpu.tgl_vendor),
            pengawasan.p_100
          ) AS p_100,
          CASE
            WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 5 DAY) THEN
              10
            WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 11 DAY) THEN
              30
            WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 21 DAY) THEN
              60
            WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 28 DAY) THEN
              85
            ELSE
              100
          END AS expected_progres,
          MAX(ROUND(COALESCE(d.progres, 0))) AS progres_saat_ini,
          CASE
            WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 5 DAY) THEN
              10
            WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 11 DAY) THEN
              30
            WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 21 DAY) THEN
              60
            WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 28 DAY) THEN
              85
            ELSE
              100
          END - MAX(ROUND(COALESCE(d.progres, 0))) AS deviasi_progres
        FROM
          rsp_project_live.t_project_bangun_detail spk
          LEFT JOIN (
            SELECT
              t.project AS id_project,
              t.blok,
              ROUND(MAX(progres)) AS progres
            FROM
              rsp_project_live.t_task_rumah t
              JOIN (
                SELECT
                  MIN(spk.tgl_spk) AS spk_awal,
                  MAX(spk.tgl_spk_akhir) AS spk_akhir
                FROM
                  rsp_project_live.t_project_bangun_detail spk
                WHERE
                  spk.blok NOT LIKE 'X%'
                  AND (LEFT(spk.tgl_spk, 7) = '$periode' OR LEFT(spk.tgl_spk_akhir, 7) = '$periode')
              ) range_date ON DATE(t.created_at) BETWEEN range_date.spk_awal
              AND range_date.spk_akhir
            GROUP BY
              t.project,
              t.blok
          ) d ON d.id_project = spk.id_project
          AND d.blok = spk.blok
          LEFT JOIN pengawasan ON pengawasan.project = spk.id_project
          AND pengawasan.blok = spk.blok
          LEFT JOIN rsp_project_live.t_project_bangun prj ON prj.id_rencana = spk.id_rencana
          LEFT JOIN rsp_project_live.m_vendor ON m_vendor.id_vendor = prj.vendor
          LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = spk.id_project
          AND mpu.blok = spk.blok
        WHERE
          spk.blok NOT LIKE 'X%'
          AND (LEFT(spk.tgl_spk, 7) = '$periode' OR LEFT(spk.tgl_spk_akhir, 7) = '$periode')
          $condition
        GROUP BY
          spk.id_project,
          spk.blok
      ) AS x
    GROUP BY
      CASE
        WHEN x.expected_progres = 100 THEN
          IF(COALESCE(x.p_100, CURRENT_DATE) <= x.t_100 AND x.p_85 IS NOT NULL, 'ontime', 'late')
        WHEN x.expected_progres = 85 THEN
          IF(COALESCE(x.p_85, CURRENT_DATE) <= x.t_85 AND x.p_60 IS NOT NULL, 'ontime', 'late')
        WHEN x.expected_progres = 60 THEN
          IF(COALESCE(x.p_60, CURRENT_DATE) <= x.t_60 AND x.p_30 IS NOT NULL, 'ontime', 'late')
        WHEN x.expected_progres = 30 THEN
          IF(COALESCE(x.p_30, CURRENT_DATE) <= x.t_30 AND x.p_10 IS NOT NULL, 'ontime', 'late')
        WHEN x.expected_progres = 10 THEN
          IF(COALESCE(x.p_10, CURRENT_DATE) <= x.t_10, 'ontime', 'late')
      END
  ) xx";
      return $this->db->query($query)->row();
    }

    function get_leadtime($id_pm, $periode, $project_tipe)
    {
      $condition = "";
      if ($project_tipe == 'subsidi') {
          $condition = " AND mpu.project_tipe in (1,4)";
      } else if ($project_tipe == 'komersil') {
          $condition = " AND mpu.project_tipe in (2)";
      }
        $query = "WITH pengawasan AS (
  SELECT
        project,
        blok,
        MAX(p_10) AS p_10,
        MAX(p_30) AS p_30,
        MAX(p_60) AS p_60,
        MAX(p_85) AS p_85,
        MAX(p_100) AS p_100 
    FROM
        (
        SELECT
            tp.project,
            tp.blok,
        CASE
            
            WHEN tp.pengawasan = 1 THEN
            DATE(tp.approved_at) 
            END AS p_10,
        CASE
            
            WHEN tp.pengawasan = 2 THEN
            DATE(tp.approved_at) 
            END AS p_30,
        CASE
            
            WHEN tp.pengawasan = 4 THEN
            DATE(tp.approved_at) 
            END AS p_60,
        CASE
            
            WHEN tp.pengawasan = 5 THEN
            DATE(tp.approved_at) 
            END AS p_85,
        CASE
            
            WHEN tp.pengawasan = 6 THEN
            DATE(tp.approved_at) 
            END AS p_100 
        FROM
            rsp_project_live.t_pengawasan tp
            LEFT JOIN (SELECT
pr.*
FROM
 rsp_project_live.m_project pr 
 LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = pr.id_project
WHERE
  pr.pm_housing IS NOT NULL
  $condition
GROUP BY pr.id_project) prj ON prj.id_project = tp.project
        WHERE
            tp.approve = 2 
            AND tp.blok NOT LIKE 'X%' 
        AND prj.pm_housing = $id_pm
        ) x 
    GROUP BY
        tp.project,
    tp.blok
) SELECT
  CASE
    WHEN
      x.expected_progres = 100 THEN
      IF(COALESCE(x.p_100, CURRENT_DATE) <= x.t_100 AND x.p_85 IS NOT NULL, 'ontime', 'late')
    WHEN x.expected_progres = 85 THEN
      IF(COALESCE(x.p_85, CURRENT_DATE) <= x.t_85 AND x.p_60 IS NOT NULL, 'ontime', 'late')
    WHEN x.expected_progres = 60 THEN
      IF(COALESCE(x.p_60, CURRENT_DATE) <= x.t_60 AND x.p_30 IS NOT NULL, 'ontime', 'late')
    WHEN x.expected_progres = 30 THEN
      IF(COALESCE(x.p_30, CURRENT_DATE) <= x.t_30 AND x.p_10 IS NOT NULL, 'ontime', 'late')
    WHEN x.expected_progres = 10 THEN
      IF(COALESCE(x.p_10, CURRENT_DATE) <= x.t_10, 'ontime', 'late')
  END AS `status`,
  COUNT(DISTINCT x.blok) jml_blok,
  ROUND(
    SUM(IF(x.deviasi_progres > 0, x.deviasi_progres, 0)) / COUNT(IF(x.deviasi_progres > 0, x.deviasi_progres, NULL))
  ) AS avg_deviasi_progres,
  ROUND(
    SUM(
      DATEDIFF(
        CURRENT_DATE,
        CASE
          WHEN x.expected_progres = 100 THEN
            CASE
              WHEN p_10 IS NULL THEN
                t_10
              WHEN p_30 IS NULL THEN
                t_30
              WHEN p_60 IS NULL THEN
                t_60
              WHEN p_85 IS NULL THEN
                t_85
              ELSE
                t_100
            END
          WHEN x.expected_progres = 85 THEN
            CASE
              WHEN p_10 IS NULL THEN
                t_10
              WHEN p_30 IS NULL THEN
                t_30
              WHEN p_60 IS NULL THEN
                t_60
              ELSE
                t_85
            END
          WHEN x.expected_progres = 60 THEN
            CASE
              WHEN p_10 IS NULL THEN
                t_10
              WHEN p_30 IS NULL THEN
                t_30
              ELSE
                t_60
            END
          WHEN x.expected_progres = 30 THEN
            CASE
              WHEN p_10 IS NULL THEN
                t_10
              ELSE
                t_30
            END
          WHEN x.expected_progres = 10 THEN
            t_10
        END
      )
    ) / COUNT(
      DATEDIFF(
        CURRENT_DATE,
        CASE
          WHEN x.expected_progres = 100 THEN
            CASE
              WHEN p_10 IS NULL THEN
                t_10
              WHEN p_30 IS NULL THEN
                t_30
              WHEN p_60 IS NULL THEN
                t_60
              WHEN p_85 IS NULL THEN
                t_85
              ELSE
                t_100
            END
          WHEN x.expected_progres = 85 THEN
            CASE
              WHEN p_10 IS NULL THEN
                t_10
              WHEN p_30 IS NULL THEN
                t_30
              WHEN p_60 IS NULL THEN
                t_60
              ELSE
                t_85
            END
          WHEN x.expected_progres = 60 THEN
            CASE
              WHEN p_10 IS NULL THEN
                t_10
              WHEN p_30 IS NULL THEN
                t_30
              ELSE
                t_60
            END
          WHEN x.expected_progres = 30 THEN
            CASE
              WHEN p_10 IS NULL THEN
                t_10
              ELSE
                t_30
            END
          WHEN x.expected_progres = 10 THEN
            t_10
        END
      )
    )
  ) AS rata_rata_telat_hari
FROM
  (
    SELECT
      spk.id_project,
      spk.blok,
      spk.tgl_spk AS spk_awal,
      spk.tgl_spk_akhir AS spk_akhir,
      DATE_ADD(spk.tgl_spk, INTERVAL 5 DAY) AS t_10,
      pengawasan.p_10,
      DATE_ADD(spk.tgl_spk, INTERVAL 11 DAY) AS t_30,
      pengawasan.p_30,
      DATE_ADD(spk.tgl_spk, INTERVAL 21 DAY) AS t_60,
      pengawasan.p_60,
      DATE_ADD(spk.tgl_spk, INTERVAL 28 DAY) AS t_85,
      pengawasan.p_85,
      spk.tgl_spk_akhir AS t_100,
      IF(
        MAX(ROUND(COALESCE(d.progres, 0))) = 100,
        DATE(mpu.tgl_vendor),
        pengawasan.p_100
      ) AS p_100,
      CASE
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 5 DAY) THEN
          10
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 11 DAY) THEN
          30
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 21 DAY) THEN
          60
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 28 DAY) THEN
          85
        ELSE
          100
      END AS expected_progres,
      MAX(ROUND(COALESCE(d.progres, 0))) AS progres_saat_ini,
      CASE
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 5 DAY) THEN
          10
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 11 DAY) THEN
          30
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 21 DAY) THEN
          60
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 28 DAY) THEN
          85
        ELSE
          100
      END - MAX(ROUND(COALESCE(d.progres, 0))) AS deviasi_progres
    FROM
      rsp_project_live.t_project_bangun_detail spk
      LEFT JOIN (
        SELECT
          t.project AS id_project,
          t.blok,
          ROUND(MAX(progres)) AS progres
        FROM
          rsp_project_live.t_task_rumah t
          JOIN (
            SELECT
              MIN(spk.tgl_spk) AS spk_awal,
              MAX(spk.tgl_spk_akhir) AS spk_akhir
            FROM
              rsp_project_live.t_project_bangun_detail spk
              LEFT JOIN (SELECT
pr.*
FROM
 rsp_project_live.m_project pr 
 LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = pr.id_project
WHERE
  pr.pm_housing IS NOT NULL
  $condition
GROUP BY pr.id_project) prj ON prj.id_project = spk.id_project
            WHERE
              prj.pm_housing = $id_pm
              AND spk.blok NOT LIKE 'X%'
              AND (LEFT(spk.tgl_spk, 7) = '$periode' OR LEFT(spk.tgl_spk_akhir, 7) = '$periode')
          ) range_date ON DATE(t.created_at) BETWEEN range_date.spk_awal
          AND range_date.spk_akhir
          LEFT JOIN (SELECT
pr.*
FROM
 rsp_project_live.m_project pr 
 LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = pr.id_project
WHERE
  pr.pm_housing IS NOT NULL
  $condition
GROUP BY pr.id_project) prj ON prj.id_project = t.project
        WHERE
          prj.pm_housing = $id_pm
        GROUP BY
          t.project,
          t.blok
      ) d ON d.id_project = spk.id_project
      AND d.blok = spk.blok
      LEFT JOIN pengawasan ON pengawasan.project = spk.id_project
      AND pengawasan.blok = spk.blok
      LEFT JOIN rsp_project_live.t_project_bangun prj ON prj.id_rencana = spk.id_rencana
      LEFT JOIN rsp_project_live.m_vendor ON m_vendor.id_vendor = prj.vendor
      LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = spk.id_project
      AND mpu.blok = spk.blok
      LEFT JOIN rsp_project_live.m_project pr ON pr.id_project = spk.id_project
    WHERE
      pr.pm_housing = $id_pm
      AND spk.blok NOT LIKE 'X%'
      AND (LEFT(spk.tgl_spk, 7) = '$periode' OR LEFT(spk.tgl_spk_akhir, 7) = '$periode')
      $condition
    GROUP BY
      spk.id_project,
      spk.blok
  ) AS x
GROUP BY
  CASE
    WHEN x.expected_progres = 100 THEN
      IF(COALESCE(x.p_100, CURRENT_DATE) <= x.t_100 AND x.p_85 IS NOT NULL, 'ontime', 'late')
    WHEN x.expected_progres = 85 THEN
      IF(COALESCE(x.p_85, CURRENT_DATE) <= x.t_85 AND x.p_60 IS NOT NULL, 'ontime', 'late')
    WHEN x.expected_progres = 60 THEN
      IF(COALESCE(x.p_60, CURRENT_DATE) <= x.t_60 AND x.p_30 IS NOT NULL, 'ontime', 'late')
    WHEN x.expected_progres = 30 THEN
      IF(COALESCE(x.p_30, CURRENT_DATE) <= x.t_30 AND x.p_10 IS NOT NULL, 'ontime', 'late')
    WHEN x.expected_progres = 10 THEN
      IF(COALESCE(x.p_10, CURRENT_DATE) <= x.t_10, 'ontime', 'late')
  END";
        return $this->db->query($query)->result();
    }

    function get_5_blok_leadtime_terburuk($id_pm, $periode, $project_tipe)
    {
      $condition = "";
      if ($project_tipe == 'subsidi') {
          $condition = " AND mpu.project_tipe in (1,4)";
      } else if ($project_tipe == 'komersil') {
          $condition = " AND mpu.project_tipe in (2)";
      }
        $query = "WITH pengawasan AS (
  SELECT
        project,
        blok,
        MAX(p_10) AS p_10,
        MAX(p_30) AS p_30,
        MAX(p_60) AS p_60,
        MAX(p_85) AS p_85,
        MAX(p_100) AS p_100 
    FROM
        (
        SELECT
            tp.project,
            tp.blok,
        CASE
            
            WHEN tp.pengawasan = 1 THEN
            DATE(tp.approved_at) 
            END AS p_10,
        CASE
            
            WHEN tp.pengawasan = 2 THEN
            DATE(tp.approved_at) 
            END AS p_30,
        CASE
            
            WHEN tp.pengawasan = 4 THEN
            DATE(tp.approved_at) 
            END AS p_60,
        CASE
            
            WHEN tp.pengawasan = 5 THEN
            DATE(tp.approved_at) 
            END AS p_85,
        CASE
            
            WHEN tp.pengawasan = 6 THEN
            DATE(tp.approved_at) 
            END AS p_100 
        FROM
            rsp_project_live.t_pengawasan tp
            LEFT JOIN (SELECT
pr.*
FROM
 rsp_project_live.m_project pr 
 LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = pr.id_project
WHERE
  pr.pm_housing IS NOT NULL
  $condition
GROUP BY pr.id_project) prj ON prj.id_project = tp.project
        WHERE
            tp.approve = 2 
            AND tp.blok NOT LIKE 'X%' 
        AND prj.pm_housing = $id_pm
        ) x 
    GROUP BY
        tp.project,
    tp.blok
) SELECT
  x.id_project,
  x.nama_project,
  x.blok,
  x.expected_progres,
  x.progres_saat_ini,
  x.deviasi_progres,
  CASE
    WHEN x.expected_progres = 100 THEN
      t_100
    WHEN x.expected_progres = 85 THEN
      t_85
    WHEN x.expected_progres = 60 THEN
      t_60
    WHEN x.expected_progres = 30 THEN
      t_30
    WHEN x.expected_progres = 10 THEN
      t_10
  END AS deadline_progres,
  DATEDIFF(
    CURRENT_DATE,
    CASE
      WHEN x.expected_progres = 100 THEN
        CASE
          WHEN p_10 IS NULL THEN
            t_10
          WHEN p_30 IS NULL THEN
            t_30
          WHEN p_60 IS NULL THEN
            t_60
          WHEN p_85 IS NULL THEN
            t_85
          ELSE
            t_100
        END
      WHEN x.expected_progres = 85 THEN
        CASE
          WHEN p_10 IS NULL THEN
            t_10
          WHEN p_30 IS NULL THEN
            t_30
          WHEN p_60 IS NULL THEN
            t_60
          ELSE
            t_85
        END
      WHEN x.expected_progres = 60 THEN
        CASE
          WHEN p_10 IS NULL THEN
            t_10
          WHEN p_30 IS NULL THEN
            t_30
          ELSE
            t_60
        END
      WHEN x.expected_progres = 30 THEN
        CASE
          WHEN p_10 IS NULL THEN
            t_10
          ELSE
            t_30
        END
      WHEN x.expected_progres = 10 THEN
        t_10
    END
  ) AS hari_telat,
  CASE
    WHEN x.expected_progres = 100 THEN
      IF(COALESCE(x.p_100, CURRENT_DATE) <= x.t_100 AND x.p_85 IS NOT NULL, 'ontime', 'late')
    WHEN x.expected_progres = 85 THEN
      IF(COALESCE(x.p_85, CURRENT_DATE) <= x.t_85 AND x.p_60 IS NOT NULL, 'ontime', 'late')
    WHEN x.expected_progres = 60 THEN
      IF(COALESCE(x.p_60, CURRENT_DATE) <= x.t_60 AND x.p_30 IS NOT NULL, 'ontime', 'late')
    WHEN x.expected_progres = 30 THEN
      IF(COALESCE(x.p_30, CURRENT_DATE) <= x.t_30 AND x.p_10 IS NOT NULL, 'ontime', 'late')
    WHEN x.expected_progres = 10 THEN
      IF(COALESCE(x.p_10, CURRENT_DATE) <= x.t_10, 'ontime', 'late')
  END AS `status`
FROM
  (
    SELECT
      spk.id_project,
      pr.project as nama_project,
      spk.blok,
      spk.tgl_spk AS spk_awal,
      spk.tgl_spk_akhir AS spk_akhir,
      DATE_ADD(spk.tgl_spk, INTERVAL 5 DAY) AS t_10,
      pengawasan.p_10,
      DATE_ADD(spk.tgl_spk, INTERVAL 11 DAY) AS t_30,
      pengawasan.p_30,
      DATE_ADD(spk.tgl_spk, INTERVAL 21 DAY) AS t_60,
      pengawasan.p_60,
      DATE_ADD(spk.tgl_spk, INTERVAL 28 DAY) AS t_85,
      pengawasan.p_85,
      spk.tgl_spk_akhir AS t_100,
      IF(
        MAX(ROUND(COALESCE(d.progres, 0))) = 100,
        DATE(mpu.tgl_vendor),
        pengawasan.p_100
      ) AS p_100,
      CASE
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 5 DAY) THEN
          10
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 11 DAY) THEN
          30
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 21 DAY) THEN
          60
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 28 DAY) THEN
          85
        ELSE
          100
      END AS expected_progres,
      MAX(ROUND(COALESCE(d.progres, 0))) AS progres_saat_ini,
      CASE
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 5 DAY) THEN
          10
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 11 DAY) THEN
          30
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 21 DAY) THEN
          60
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 28 DAY) THEN
          85
        ELSE
          100
      END - MAX(ROUND(COALESCE(d.progres, 0))) AS deviasi_progres
    FROM
      rsp_project_live.t_project_bangun_detail spk
      LEFT JOIN (
        SELECT
          t.project AS id_project,
          t.blok,
          ROUND(MAX(progres)) AS progres
        FROM
          rsp_project_live.t_task_rumah t
          JOIN (
            SELECT
              MIN(spk.tgl_spk) AS spk_awal,
              MAX(spk.tgl_spk_akhir) AS spk_akhir
            FROM
              rsp_project_live.t_project_bangun_detail spk
              LEFT JOIN (SELECT
pr.*
FROM
 rsp_project_live.m_project pr 
 LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = pr.id_project
WHERE
  pr.pm_housing IS NOT NULL
  $condition
GROUP BY pr.id_project) prj ON prj.id_project = spk.id_project
            WHERE
              prj.pm_housing = $id_pm
              AND spk.blok NOT LIKE 'X%'
              AND (LEFT(spk.tgl_spk, 7) = '$periode' OR LEFT(spk.tgl_spk_akhir, 7) = '$periode')
          ) range_date ON DATE(t.created_at) BETWEEN range_date.spk_awal
          AND range_date.spk_akhir
          LEFT JOIN (SELECT
pr.*
FROM
 rsp_project_live.m_project pr 
 LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = pr.id_project
WHERE
  pr.pm_housing IS NOT NULL
  $condition
GROUP BY pr.id_project) prj ON prj.id_project = t.project
        WHERE
          prj.pm_housing = $id_pm
        GROUP BY
          t.project,
          t.blok
      ) d ON d.id_project = spk.id_project
      AND d.blok = spk.blok
      LEFT JOIN pengawasan ON pengawasan.project = spk.id_project
      AND pengawasan.blok = spk.blok
      LEFT JOIN rsp_project_live.t_project_bangun prj ON prj.id_rencana = spk.id_rencana
      LEFT JOIN rsp_project_live.m_vendor ON m_vendor.id_vendor = prj.vendor
      LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = spk.id_project
      AND mpu.blok = spk.blok
      LEFT JOIN rsp_project_live.m_project pr ON pr.id_project = spk.id_project
    WHERE
      pr.pm_housing = $id_pm
      AND spk.blok NOT LIKE 'X%'
      AND (LEFT(spk.tgl_spk, 7) = '$periode' OR LEFT(spk.tgl_spk_akhir, 7) = '$periode')
      $condition
    GROUP BY
      spk.id_project,
      spk.blok
  ) AS x
ORDER BY
  hari_telat DESC,
  x.deviasi_progres DESC
  LIMIT 5";
        return $this->db->query($query)->result();
    }

    function get_ketersediaan_material($id_pm, $periode, $project_tipe)
    {
      $condition = "";
      if ($project_tipe == 'subsidi') {
          $condition = " AND mpu.project_tipe in (1,4)";
      } else if ($project_tipe == 'komersil') {
          $condition = " AND mpu.project_tipe in (2)";
      }
        $query = "SELECT
  ROUND(SUM(xx.persen_ketersediaan_material) / COUNT(*)) AS persen_ketersediaan_material
FROM
  (
    SELECT
      x.project,
      x.blok,
      COUNT(*) AS total_hari,
      SUM(x.material_ada) AS jumlah_hari_ada_material,
      SUM(x.material_kosong) AS jumlah_hari_tidak_ada_material,
      ROUND(SUM(x.material_ada) / COUNT(*) * 100) AS persen_ketersediaan_material
    FROM
      (
        SELECT
          t.project,
          t.blok,
          MIN(range_date.start_date) AS start_date,
          MAX(range_date.end_date) AS end_date,
          DATE(t.created_at) AS created_at,
          GROUP_CONCAT(t.status_material) AS status_material,
          MAX(CASE WHEN t.status_material = 'On Site' THEN 1 ELSE 0 END) AS material_ada,
          MIN(CASE WHEN t.status_material = 'On Site' THEN 0 ELSE 1 END) AS material_kosong
        FROM
          rsp_project_live.t_task_rumah t
          JOIN (
            SELECT
              MIN(spk.tgl_spk) AS start_date,
              MAX(spk.tgl_spk_akhir) AS end_date
            FROM
              rsp_project_live.t_project_bangun_detail spk
              LEFT JOIN (SELECT
pr.*
FROM
 rsp_project_live.m_project pr 
 LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = pr.id_project
WHERE
  pr.pm_housing IS NOT NULL
  $condition
GROUP BY pr.id_project) prj ON prj.id_project = spk.id_project
            WHERE
              prj.pm_housing = $id_pm
              AND spk.blok NOT LIKE 'X%'
              AND (LEFT(spk.tgl_spk, 7) = '$periode' OR LEFT(spk.tgl_spk_akhir, 7) = '$periode')
          ) AS range_date ON DATE(t.created_at) BETWEEN range_date.start_date
          AND range_date.end_date
          LEFT JOIN (SELECT
pr.*
FROM
 rsp_project_live.m_project pr 
 LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = pr.id_project
WHERE
  pr.pm_housing IS NOT NULL
  $condition
GROUP BY pr.id_project) prj ON prj.id_project = t.project
        WHERE
          prj.pm_housing = $id_pm
        GROUP BY
          t.project,
          t.blok,
          DATE(t.created_at)
        ORDER BY
          DATE(t.created_at),
          t.blok
      ) AS x
    GROUP BY
      x.blok
  ) AS xx";
        return $this->db->query($query)->row();
    }

    function get_5_blok_paling_sering_material_kosong($id_pm, $periode, $project_tipe)
    {
      $condition = "";
      if ($project_tipe == 'subsidi') {
          $condition = " AND mpu.project_tipe in (1,4)";
      } else if ($project_tipe == 'komersil') {
          $condition = " AND mpu.project_tipe in (2)";
      }
        $query = "SELECT
  x.project,
  x.nama_project,
  x.blok,
  COUNT(*) AS total_hari,
  SUM(x.material_ada) AS jumlah_hari_ada_material,
  SUM(x.material_kosong) AS jumlah_hari_tidak_ada_material,
  ROUND(SUM(x.material_ada) / COUNT(*) * 100) AS persen_ketersediaan_material
FROM
  (
    SELECT
      t.project,
      prj.project as nama_project,
      t.blok,
      MIN(range_date.start_date) AS start_date,
      MAX(range_date.end_date) AS end_date,
      DATE(t.created_at) AS created_at,
      GROUP_CONCAT(t.status_material) AS status_material,
      MAX(CASE WHEN t.status_material = 'On Site' THEN 1 ELSE 0 END) AS material_ada,
      MIN(CASE WHEN t.status_material = 'On Site' THEN 0 ELSE 1 END) AS material_kosong
    FROM
      rsp_project_live.t_task_rumah t
      JOIN (
        SELECT
          MIN(spk.tgl_spk) AS start_date,
          MAX(spk.tgl_spk_akhir) AS end_date
        FROM
          rsp_project_live.t_project_bangun_detail spk
          LEFT JOIN (SELECT
pr.*
FROM
 rsp_project_live.m_project pr 
 LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = pr.id_project
WHERE
  pr.pm_housing IS NOT NULL
  $condition
GROUP BY pr.id_project) prj ON prj.id_project = spk.id_project
        WHERE
          prj.pm_housing = $id_pm
          AND spk.blok NOT LIKE 'X%'
          AND (LEFT(spk.tgl_spk, 7) = '$periode' OR LEFT(spk.tgl_spk_akhir, 7) = '$periode')
      ) AS range_date ON DATE(t.created_at) BETWEEN range_date.start_date
      AND range_date.end_date
      LEFT JOIN (SELECT
pr.*
FROM
 rsp_project_live.m_project pr 
 LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = pr.id_project
WHERE
  pr.pm_housing IS NOT NULL
  $condition
GROUP BY pr.id_project) prj ON prj.id_project = t.project
      WHERE
        prj.pm_housing = $id_pm
    GROUP BY
      t.project,
      t.blok,
      DATE(t.created_at)
    ORDER BY
      DATE(t.created_at),
      t.blok
  ) AS x
GROUP BY
  x.blok
ORDER BY
  jumlah_hari_tidak_ada_material DESC,
  persen_ketersediaan_material
  LIMIT 5";
        return $this->db->query($query)->result();
    }

    function get_gangguan_cuaca($id_pm, $periode, $project_tipe)
    {
      $condition = "";
      if ($project_tipe == 'subsidi') {
          $condition = " AND mpu.project_tipe in (1,4)";
      } else if ($project_tipe == 'komersil') {
          $condition = " AND mpu.project_tipe in (2)";
      }
        $query = "SELECT
  10 AS target,
  ROUND(SUM(c.persen_gangguan_cuaca) / count(c.persen_gangguan_cuaca)) AS avg_gangguan_cuaca
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
        2
      ) AS persen_gangguan_cuaca
    FROM
      (SELECT
pr.*
FROM
 rsp_project_live.m_project pr 
 LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = pr.id_project
WHERE
  pr.pm_housing IS NOT NULL
  $condition
GROUP BY pr.id_project) p
      LEFT JOIN (
        SELECT
          spk.id_project,
          MIN(spk.tgl_spk) AS start_date,
          MAX(spk.tgl_spk_akhir) AS end_date
        FROM
          rsp_project_live.t_project_bangun_detail spk
          LEFT JOIN (SELECT
pr.*
FROM
 rsp_project_live.m_project pr 
 LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = pr.id_project
WHERE
  pr.pm_housing IS NOT NULL
  $condition
GROUP BY pr.id_project) prj ON prj.id_project = spk.id_project
        WHERE
          prj.pm_housing = $id_pm
          AND spk.blok NOT LIKE 'X%'
          AND (LEFT(spk.tgl_spk, 7) = '$periode' OR LEFT(spk.tgl_spk_akhir, 7) = '$periode')
      ) AS r ON r.id_project = p.id_project
      LEFT JOIN rsp_project_live.weather_data w ON w.adm4 = p.kode_bmkg
      AND DATE(w.`datetime`) BETWEEN r.start_date
      AND r.end_date
      AND TIME(w.`datetime`) BETWEEN '07:00:00'
      AND '17:00:00'
    WHERE
      p.pm_housing = $id_pm
    GROUP BY
      DATE(w.`datetime`)
  ) c";
        return $this->db->query($query)->row();
    }

    function get_data_keterlambatan($id_pm, $periode, $project_tipe)
    {
      $condition = "";
      if ($project_tipe == 'subsidi') {
          $condition = " AND mpu.project_tipe in (1,4)";
      } else if ($project_tipe == 'komersil') {
          $condition = " AND mpu.project_tipe in (2)";
      }
        $query = "WITH pengawasan AS (
  SELECT
        project,
        blok,
        MAX(p_10) AS p_10,
        MAX(p_30) AS p_30,
        MAX(p_60) AS p_60,
        MAX(p_85) AS p_85,
        MAX(p_100) AS p_100 
    FROM
        (
        SELECT
            tp.project,
            tp.blok,
        CASE
            
            WHEN tp.pengawasan = 1 THEN
            DATE(tp.approved_at) 
            END AS p_10,
        CASE
            
            WHEN tp.pengawasan = 2 THEN
            DATE(tp.approved_at) 
            END AS p_30,
        CASE
            
            WHEN tp.pengawasan = 4 THEN
            DATE(tp.approved_at) 
            END AS p_60,
        CASE
            
            WHEN tp.pengawasan = 5 THEN
            DATE(tp.approved_at) 
            END AS p_85,
        CASE
            
            WHEN tp.pengawasan = 6 THEN
            DATE(tp.approved_at) 
            END AS p_100 
        FROM
            rsp_project_live.t_pengawasan tp
            LEFT JOIN (SELECT
pr.*
FROM
 rsp_project_live.m_project pr 
 LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = pr.id_project
WHERE
  pr.pm_housing IS NOT NULL
  $condition
GROUP BY pr.id_project) prj ON prj.id_project = tp.project
        WHERE
            tp.approve = 2 
            AND tp.blok NOT LIKE 'X%' 
        AND prj.pm_housing = $id_pm
        ) x 
    GROUP BY
        tp.project,
    tp.blok
) SELECT
  x.id_project,
  p.project,
  x.blok,
  x.spk_awal AS tgl_start_spk,
  x.spk_akhir AS tgl_end_spk,
  x.expected_progres AS target_milestone_progres,
  x.progres_saat_ini,
  CASE
    WHEN x.expected_progres = 100 THEN
      IF(x.p_100 IS NOT NULL, 'done', 'progres')
    WHEN x.expected_progres = 85 THEN
      IF(x.p_85 IS NOT NULL, 'done', 'progres')
    WHEN x.expected_progres = 60 THEN
      IF(x.p_60 IS NOT NULL, 'done', 'progres')
    WHEN x.expected_progres = 30 THEN
      IF(x.p_30 IS NOT NULL, 'done', 'progres')
    WHEN x.expected_progres = 10 THEN
      IF(x.p_10 IS NOT NULL, 'done', 'progres')
  END AS `status_pekerjaan`,
  CASE
    WHEN x.expected_progres = 100 THEN
      IF(COALESCE(x.p_100, CURRENT_DATE) <= x.t_100 AND x.p_85 IS NOT NULL, 'ontime', 'late')
    WHEN x.expected_progres = 85 THEN
      IF(COALESCE(x.p_85, CURRENT_DATE) <= x.t_85 AND x.p_60 IS NOT NULL, 'ontime', 'late')
    WHEN x.expected_progres = 60 THEN
      IF(COALESCE(x.p_60, CURRENT_DATE) <= x.t_60 AND x.p_30 IS NOT NULL, 'ontime', 'late')
    WHEN x.expected_progres = 30 THEN
      IF(COALESCE(x.p_30, CURRENT_DATE) <= x.t_30 AND x.p_10 IS NOT NULL, 'ontime', 'late')
    WHEN x.expected_progres = 10 THEN
      IF(COALESCE(x.p_10, CURRENT_DATE) <= x.t_10, 'ontime', 'late')
  END AS `status_leadtime`,
  CASE
    WHEN x.expected_progres = 100 THEN
      CASE
        WHEN p_100 IS NOT NULL THEN
          p_100
        ELSE
          CURRENT_DATE
      END
    WHEN x.expected_progres = 85 THEN
      CASE
        WHEN p_85 IS NOT NULL THEN
          p_85
        ELSE
          CURRENT_DATE
      END
    WHEN x.expected_progres = 60 THEN
      CASE
        WHEN p_60 IS NOT NULL THEN
          p_60
        ELSE
          CURRENT_DATE
      END
    WHEN x.expected_progres = 30 THEN
      CASE
        WHEN p_30 IS NOT NULL THEN
          p_30
        ELSE
          CURRENT_DATE
      END
    WHEN x.expected_progres = 10 THEN
      CASE
        WHEN p_10 IS NOT NULL THEN
          p_10
        ELSE
          CURRENT_DATE
      END
  END tgl_last_update,
  CASE
    WHEN x.expected_progres = 100 THEN
      CASE
        WHEN p_10 IS NULL THEN
          t_10
        WHEN p_30 IS NULL THEN
          t_30
        WHEN p_60 IS NULL THEN
          t_60
        WHEN p_85 IS NULL THEN
          t_85
        ELSE
          t_100
      END
    WHEN x.expected_progres = 85 THEN
      CASE
        WHEN p_10 IS NULL THEN
          t_10
        WHEN p_30 IS NULL THEN
          t_30
        WHEN p_60 IS NULL THEN
          t_60
        ELSE
          t_85
      END
    WHEN x.expected_progres = 60 THEN
      CASE
        WHEN p_10 IS NULL THEN
          t_10
        WHEN p_30 IS NULL THEN
          t_30
        ELSE
          t_60
      END
    WHEN x.expected_progres = 30 THEN
      CASE
        WHEN p_10 IS NULL THEN
          t_10
        ELSE
          t_30
      END
    WHEN x.expected_progres = 10 THEN
      t_10
  END AS deadline_progres,
  DATEDIFF (
    CASE
      WHEN x.expected_progres = 100 THEN
        CASE
          WHEN p_100 IS NOT NULL THEN
            p_100
          ELSE
            CURRENT_DATE
        END
      WHEN x.expected_progres = 85 THEN
        CASE
          WHEN p_85 IS NOT NULL THEN
            p_85
          ELSE
            CURRENT_DATE
        END
      WHEN x.expected_progres = 60 THEN
        CASE
          WHEN p_60 IS NOT NULL THEN
            p_60
          ELSE
            CURRENT_DATE
        END
      WHEN x.expected_progres = 30 THEN
        CASE
          WHEN p_30 IS NOT NULL THEN
            p_30
          ELSE
            CURRENT_DATE
        END
      WHEN x.expected_progres = 10 THEN
        CASE
          WHEN p_10 IS NOT NULL THEN
            p_10
          ELSE
            CURRENT_DATE
        END
    END,
    CASE
      WHEN x.expected_progres = 100 THEN
        CASE
          WHEN p_10 IS NULL THEN
            t_10
          WHEN p_30 IS NULL THEN
            t_30
          WHEN p_60 IS NULL THEN
            t_60
          WHEN p_85 IS NULL THEN
            t_85
          ELSE
            t_100
        END
      WHEN x.expected_progres = 85 THEN
        CASE
          WHEN p_10 IS NULL THEN
            t_10
          WHEN p_30 IS NULL THEN
            t_30
          WHEN p_60 IS NULL THEN
            t_60
          ELSE
            t_85
        END
      WHEN x.expected_progres = 60 THEN
        CASE
          WHEN p_10 IS NULL THEN
            t_10
          WHEN p_30 IS NULL THEN
            t_30
          ELSE
            t_60
        END
      WHEN x.expected_progres = 30 THEN
        CASE
          WHEN p_10 IS NULL THEN
            t_10
          ELSE
            t_30
        END
      WHEN x.expected_progres = 10 THEN
        t_10
    END
  ) AS keterlambatan_hari
FROM
  (
    SELECT
      spk.id_project,
      spk.blok,
      spk.tgl_spk AS spk_awal,
      spk.tgl_spk_akhir AS spk_akhir,
      DATE_ADD(spk.tgl_spk, INTERVAL 5 DAY) AS t_10,
      pengawasan.p_10,
      DATE_ADD(spk.tgl_spk, INTERVAL 11 DAY) AS t_30,
      pengawasan.p_30,
      DATE_ADD(spk.tgl_spk, INTERVAL 21 DAY) AS t_60,
      pengawasan.p_60,
      DATE_ADD(spk.tgl_spk, INTERVAL 28 DAY) AS t_85,
      pengawasan.p_85,
      spk.tgl_spk_akhir AS t_100,
      IF(
        MAX(ROUND(COALESCE(d.progres, 0))) = 100,
        DATE(mpu.tgl_vendor),
        pengawasan.p_100
      ) AS p_100,
      42 AS target_hari_selesai,
      DATEDIFF (
        COALESCE(
          IF(
            MAX(ROUND(COALESCE(d.progres, 0))) = 100,
            DATE(mpu.tgl_vendor),
            pengawasan.p_100
          ),
          CURRENT_DATE
        ),
        spk.tgl_spk
      ) AS total_hari_selesai,
      CASE
        WHEN DATEDIFF (
            COALESCE(
              IF(
                MAX(ROUND(COALESCE(d.progres, 0))) = 100,
                DATE(mpu.tgl_vendor),
                pengawasan.p_100
              ),
              CURRENT_DATE
            ),
            spk.tgl_spk
          ) > 42 THEN
          1
        ELSE
          0
      END AS punishment,
      CASE
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 5 DAY) THEN
          10
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 11 DAY) THEN
          30
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 21 DAY) THEN
          60
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 28 DAY) THEN
          85
        ELSE
          100
      END AS expected_progres,
      MAX(ROUND(COALESCE(d.progres, 0))) AS progres_saat_ini,
      CASE
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 5 DAY) THEN
          10
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 11 DAY) THEN
          30
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 21 DAY) THEN
          60
        WHEN CURRENT_DATE <= DATE_ADD(spk.tgl_spk, INTERVAL 28 DAY) THEN
          85
        ELSE
          100
      END - MAX(ROUND(COALESCE(d.progres, 0))) AS deviasi_progres
    FROM
      rsp_project_live.t_project_bangun_detail spk
      LEFT JOIN (
        SELECT
          t.project AS id_project,
          t.blok,
          ROUND(MAX(CAST(progres AS UNSIGNED))) AS progres
        FROM
          rsp_project_live.t_task_rumah t
          JOIN (
            SELECT
              MIN(spk.tgl_spk) AS spk_awal,
              MAX(spk.tgl_spk_akhir) AS spk_akhir
            FROM
              rsp_project_live.t_project_bangun_detail spk
              LEFT JOIN (SELECT
pr.*
FROM
 rsp_project_live.m_project pr 
 LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = pr.id_project
WHERE
  pr.pm_housing IS NOT NULL
  $condition
GROUP BY pr.id_project) prj ON prj.id_project = spk.id_project
            WHERE
              prj.pm_housing = $id_pm
              AND spk.blok NOT LIKE 'X%'
              AND (LEFT(spk.tgl_spk, 7) = '$periode' OR LEFT(spk.tgl_spk_akhir, 7) = '$periode')
          ) range_date ON DATE(t.created_at) BETWEEN range_date.spk_awal
          AND range_date.spk_akhir
          LEFT JOIN (SELECT
pr.*
FROM
 rsp_project_live.m_project pr 
 LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = pr.id_project
WHERE
  pr.pm_housing IS NOT NULL
  $condition
GROUP BY pr.id_project) prj ON prj.id_project = t.project
        WHERE
          prj.pm_housing = $id_pm
        GROUP BY
          t.project,
          t.blok
      ) d ON d.id_project = spk.id_project
      AND d.blok = spk.blok
      LEFT JOIN pengawasan ON pengawasan.project = spk.id_project
      AND pengawasan.blok = spk.blok
      LEFT JOIN rsp_project_live.t_project_bangun prj ON prj.id_rencana = spk.id_rencana
      LEFT JOIN rsp_project_live.m_vendor ON m_vendor.id_vendor = prj.vendor
      LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = spk.id_project
      AND mpu.blok = spk.blok
      LEFT JOIN rsp_project_live.m_project pr ON pr.id_project = spk.id_project
    WHERE
      pr.pm_housing = $id_pm
      AND spk.blok NOT LIKE 'X%'
      AND (LEFT(spk.tgl_spk, 7) = '$periode' OR LEFT(spk.tgl_spk_akhir, 7) = '$periode')
      $condition
    GROUP BY
      spk.id_project,
      spk.blok
  ) AS x
  LEFT JOIN rsp_project_live.m_project p ON p.id_project = x.id_project
WHERE
  DATEDIFF (
    CASE
      WHEN x.expected_progres = 100 THEN
        CASE
          WHEN p_100 IS NOT NULL THEN
            p_100
          ELSE
            CURRENT_DATE
        END
      WHEN x.expected_progres = 85 THEN
        CASE
          WHEN p_85 IS NOT NULL THEN
            p_85
          ELSE
            CURRENT_DATE
        END
      WHEN x.expected_progres = 60 THEN
        CASE
          WHEN p_60 IS NOT NULL THEN
            p_60
          ELSE
            CURRENT_DATE
        END
      WHEN x.expected_progres = 30 THEN
        CASE
          WHEN p_30 IS NOT NULL THEN
            p_30
          ELSE
            CURRENT_DATE
        END
      WHEN x.expected_progres = 10 THEN
        CASE
          WHEN p_10 IS NOT NULL THEN
            p_10
          ELSE
            CURRENT_DATE
        END
    END,
    CASE
      WHEN x.expected_progres = 100 THEN
        CASE
          WHEN p_10 IS NULL THEN
            t_10
          WHEN p_30 IS NULL THEN
            t_30
          WHEN p_60 IS NULL THEN
            t_60
          WHEN p_85 IS NULL THEN
            t_85
          ELSE
            t_100
        END
      WHEN x.expected_progres = 85 THEN
        CASE
          WHEN p_10 IS NULL THEN
            t_10
          WHEN p_30 IS NULL THEN
            t_30
          WHEN p_60 IS NULL THEN
            t_60
          ELSE
            t_85
        END
      WHEN x.expected_progres = 60 THEN
        CASE
          WHEN p_10 IS NULL THEN
            t_10
          WHEN p_30 IS NULL THEN
            t_30
          ELSE
            t_60
        END
      WHEN x.expected_progres = 30 THEN
        CASE
          WHEN p_10 IS NULL THEN
            t_10
          ELSE
            t_30
        END
      WHEN x.expected_progres = 10 THEN
        t_10
    END
  ) > 2
ORDER BY
  DATEDIFF (
    CASE
      WHEN x.expected_progres = 100 THEN
        CASE
          WHEN p_100 IS NOT NULL THEN
            p_100
          ELSE
            CURRENT_DATE
        END
      WHEN x.expected_progres = 85 THEN
        CASE
          WHEN p_85 IS NOT NULL THEN
            p_85
          ELSE
            CURRENT_DATE
        END
      WHEN x.expected_progres = 60 THEN
        CASE
          WHEN p_60 IS NOT NULL THEN
            p_60
          ELSE
            CURRENT_DATE
        END
      WHEN x.expected_progres = 30 THEN
        CASE
          WHEN p_30 IS NOT NULL THEN
            p_30
          ELSE
            CURRENT_DATE
        END
      WHEN x.expected_progres = 10 THEN
        CASE
          WHEN p_10 IS NOT NULL THEN
            p_10
          ELSE
            CURRENT_DATE
        END
    END,
    CASE
      WHEN x.expected_progres = 100 THEN
        CASE
          WHEN p_10 IS NULL THEN
            t_10
          WHEN p_30 IS NULL THEN
            t_30
          WHEN p_60 IS NULL THEN
            t_60
          WHEN p_85 IS NULL THEN
            t_85
          ELSE
            t_100
        END
      WHEN x.expected_progres = 85 THEN
        CASE
          WHEN p_10 IS NULL THEN
            t_10
          WHEN p_30 IS NULL THEN
            t_30
          WHEN p_60 IS NULL THEN
            t_60
          ELSE
            t_85
        END
      WHEN x.expected_progres = 60 THEN
        CASE
          WHEN p_10 IS NULL THEN
            t_10
          WHEN p_30 IS NULL THEN
            t_30
          ELSE
            t_60
        END
      WHEN x.expected_progres = 30 THEN
        CASE
          WHEN p_10 IS NULL THEN
            t_10
          ELSE
            t_30
        END
      WHEN x.expected_progres = 10 THEN
        t_10
    END
  ) DESC";
        return $this->db->query($query)->result();
    }
}
