<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_api_plan_infra extends CI_Model
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

    function kpi_corporate($periode) {
        $query = "SELECT
  'On-Time Contruction Rate (OTCR) Ketepatan waktu penyelesaian konstruksi (Infrastruktur)' AS corporate_kpi,
  COUNT(plan.id_plan) AS target,
  100 AS target_persentase,
  COALESCE(SUM(IF(plan.STATUS = 'Ontime', 1, 0)), 0)  AS actual,
  ROUND(COALESCE(SUM(IF(plan.STATUS = 'Ontime', 1, 0)), 0)  / COUNT(plan.id_plan) * 100, 0) AS achieve_persentase,
  CONCAT('Data : ', COALESCE(SUM(IF(plan.STATUS = 'Ontime', 1, 0)), 0) , '/' , COUNT(plan.id_plan) , ' (' , ROUND((COALESCE(SUM(IF(plan.STATUS = 'Ontime', 1, 0)), 0) / COUNT(plan.id_plan)) * 100, 1) , '%)' ) as data_text
FROM
  (
    SELECT
      plan_infra.id_plan,
      plan_infra.START,
      CONCAT(spk_infra_detail.spk_akhir, ' 23:59:59') AS spk_akhir,
      MAX(tasklist.created_at) AS tgl_progres_terakhir,
      MAX(spk_infra_detail.status_progres) AS status_spk,
      IF(MAX(tasklist.created_at) <= CONCAT(spk_infra_detail.spk_akhir, ' 23:59:59'), 'Ontime', 'Late') AS STATUS
    FROM
      rsp_project_live.t_plan_infra plan_infra
      LEFT JOIN rsp_project_live.t_infrastruktur_detail AS spk_infra_detail ON plan_infra.id_plan = spk_infra_detail.id_plan
      LEFT JOIN rsp_project_live.t_infrastruktur AS spk_infra ON spk_infra_detail.id_inf = spk_infra.id_inf
      LEFT JOIN (
        SELECT
          id_inf,
          id_infrastruktur,
          created_at
        FROM
          (
            SELECT
              task_infra.id_inf,
              task_infra.infrastruktur AS id_infrastruktur,
              task_infra.created_at,
              task_infra.id_infra
            FROM
              rsp_project_live.t_task_infra task_infra
            WHERE
              task_infra.id_infra IN (
                SELECT
                  MAX(task_infra.id_infra) AS id_infra
                FROM
                  rsp_project_live.t_task_infra task_infra
                WHERE
                  task_infra.id_inf IS NOT NULL
                  AND task_infra.id_inf != ''
                GROUP BY
                  task_infra.id_inf,
                  task_infra.infrastruktur
              )
          ) latest_tasks
        GROUP BY
          id_inf,
          id_infrastruktur
      ) AS tasklist ON tasklist.id_inf = spk_infra_detail.id_inf
      AND tasklist.id_infrastruktur = spk_infra_detail.id_infrastruktur
    WHERE
      LEFT(spk_infra_detail.spk_akhir, 7) = '$periode'
    GROUP BY
      plan_infra.id_plan,
      spk_infra.id_inf
    HAVING
      MAX(spk_infra_detail.status_progres) IN ('Complete', 'On Progres')
    ORDER BY
      IF(MAX(tasklist.created_at) <= CONCAT(spk_infra_detail.spk_akhir, ' 23:59:59'), 'Ontime', 'Late')
  ) plan";
        return $this->db->query($query)->row_array();
    }

    function kpi_project($project, $periode) {
        $query = "SELECT
  'On-Time Contruction Rate (OTCR) Ketepatan waktu penyelesaian konstruksi (Infrastruktur)' AS corporate_kpi,
  COUNT(plan.id_plan) AS target,
  100 AS target_persentase,
  COALESCE(SUM(IF(plan.STATUS = 'Ontime', 1, 0)), 0)  AS actual,
  ROUND(COALESCE(SUM(IF(plan.STATUS = 'Ontime', 1, 0)), 0)  / COUNT(plan.id_plan) * 100, 0) AS achieve_persentase,
  CONCAT('Data : ', COALESCE(SUM(IF(plan.STATUS = 'Ontime', 1, 0)), 0) , '/' , COUNT(plan.id_plan) , ' (' , ROUND((COALESCE(SUM(IF(plan.STATUS = 'Ontime', 1, 0)), 0) / COUNT(plan.id_plan)) * 100, 1) , '%)' ) as data_text
FROM
  (
    SELECT
      plan_infra.id_plan,
      plan_infra.START,
      CONCAT(spk_infra_detail.spk_akhir, ' 23:59:59') AS spk_akhir,
      MAX(tasklist.created_at) AS tgl_progres_terakhir,
      MAX(spk_infra_detail.status_progres) AS status_spk,
      IF(MAX(tasklist.created_at) <= CONCAT(spk_infra_detail.spk_akhir, ' 23:59:59'), 'Ontime', 'Late') AS STATUS
    FROM
      rsp_project_live.t_plan_infra plan_infra
      LEFT JOIN rsp_project_live.t_infrastruktur_detail AS spk_infra_detail ON plan_infra.id_plan = spk_infra_detail.id_plan
      LEFT JOIN rsp_project_live.t_infrastruktur AS spk_infra ON spk_infra_detail.id_inf = spk_infra.id_inf
      LEFT JOIN (
        SELECT
          id_inf,
          id_infrastruktur,
          created_at
        FROM
          (
            SELECT
              task_infra.id_inf,
              task_infra.infrastruktur AS id_infrastruktur,
              task_infra.created_at,
              task_infra.id_infra
            FROM
              rsp_project_live.t_task_infra task_infra
            WHERE
              task_infra.id_infra IN (
                SELECT
                  MAX(task_infra.id_infra) AS id_infra
                FROM
                  rsp_project_live.t_task_infra task_infra
                WHERE
                  task_infra.id_inf IS NOT NULL
                  AND task_infra.id_inf != ''
                GROUP BY
                  task_infra.id_inf,
                  task_infra.infrastruktur
              )
          ) latest_tasks
        GROUP BY
          id_inf,
          id_infrastruktur
      ) AS tasklist ON tasklist.id_inf = spk_infra_detail.id_inf
      AND tasklist.id_infrastruktur = spk_infra_detail.id_infrastruktur
    WHERE
      spk_infra_detail.project = $project
      AND LEFT(spk_infra_detail.spk_akhir, 7) = '$periode'
    GROUP BY
      plan_infra.id_plan,
      spk_infra.id_inf
    HAVING
      MAX(spk_infra_detail.status_progres) IN ('Complete', 'On Progres')
    ORDER BY
      IF(MAX(tasklist.created_at) <= CONCAT(spk_infra_detail.spk_akhir, ' 23:59:59'), 'Ontime', 'Late')
  ) plan";
        return $this->db->query($query)->row_array();
    }

    function mc0_mc100($project, $periode) {
        $query = "SELECT 
  COUNT(id_sry) AS target, 
  100 AS target_persentase, 
  COALESCE(SUM(
    CASE WHEN vol_spk > 0 THEN CASE WHEN (
      100 - (actual / vol_spk * 100)
    ) <= -5 THEN 1 WHEN (
      100 - (actual / vol_spk * 100)
    ) >= 0 
    AND (
      100 - (actual / vol_spk * 100)
    ) <= 5 THEN 1 ELSE 0 END ELSE 0 END
  ), 0) AS actual, 
  COALESCE(ROUND(
    (
      COALESCE(SUM(
        CASE WHEN vol_spk > 0 THEN CASE WHEN (
          100 - (actual / vol_spk * 100)
        ) <= -5 THEN 1 WHEN (
          100 - (actual / vol_spk * 100)
        ) >= 0 
        AND (
          100 - (actual / vol_spk * 100)
        ) <= 5 THEN 1 ELSE 0 END ELSE 0 END
      ), 0)/ COUNT(id_sry)
    ) * 100, 
    1
  ), 0) AS achieve_persentase,
  CONCAT('Data : ', COALESCE(SUM(
    CASE WHEN vol_spk > 0 THEN CASE WHEN (
      100 - (actual / vol_spk * 100)
    ) <= -5 THEN 1 WHEN (
      100 - (actual / vol_spk * 100)
    ) >= 0 
    AND (
      100 - (actual / vol_spk * 100)
    ) <= 5 THEN 1 ELSE 0 END ELSE 0 END
  ), 0) , '/' , COUNT(id_sry) , ' (' , ROUND((COALESCE(SUM(
    CASE WHEN vol_spk > 0 THEN CASE WHEN (
      100 - (actual / vol_spk * 100)
    ) <= -5 THEN 1 WHEN (
      100 - (actual / vol_spk * 100)
    ) >= 0 
    AND (
      100 - (actual / vol_spk * 100)
    ) <= 5 THEN 1 ELSE 0 END ELSE 0 END
  ), 0) / COUNT(id_sry)) * 100, 1) , '%)' ) as data_text
FROM 
  rsp_project_live.t_tasklist_surveyor tasklist_surveyor 
WHERE 
  tujuan = 3 
  AND project = $project
  AND id_inf IS NOT NULL 
  AND LEFT(created_at, 7) = '$periode'";
        return $this->db->query($query)->row_array();
    }

    function kesiapan_lahan($project, $periode){
        $query = "SELECT
  COUNT(lahan.id_lahan) AS target, 
  100 AS target_persentase, 
  COALESCE(SUM(IF(lahan.kesiapan_lahan = 'Siap',1,0)),0) as actual,
  ROUND((COALESCE(SUM(IF(lahan.kesiapan_lahan = 'Siap',1,0)),0) / COUNT(lahan.id_lahan)) * 100, 1) as achieve_persentase,
  CONCAT('Data : ', COALESCE(SUM(IF(lahan.kesiapan_lahan = 'Siap',1,0)),0) , '/' , COUNT(lahan.id_lahan) , ' (' , ROUND((COALESCE(SUM(IF(lahan.kesiapan_lahan = 'Siap',1,0)),0) / COUNT(lahan.id_lahan)) * 100, 1) , '%)' ) as data_text
FROM
  (
    SELECT
      lahan.id_lahan,
      lahan.id_plan,
      pr.project,
      lahan.id_project,
      je.infrastruktur AS pekerjaan,
      lahan.status_landclearing,
      lahan.status_stake_out,
      IF(lahan.status_landclearing = 1 AND lahan.status_stake_out = 1, 'Siap', 'Belum Siap') AS kesiapan_lahan
    FROM
      rsp_project_live.t_kesiapan_lahan_infra lahan
      JOIN rsp_project_live.t_plan_infra plan ON plan.id_plan = lahan.id_plan
      JOIN rsp_project_live.m_jenis_infra je ON plan.pekerjaan = je.id
      LEFT JOIN rsp_project_live.m_project pr ON lahan.id_project = pr.id_project
    WHERE
      lahan.id_project = $project
      AND LEFT(lahan.created_at, 7) = '$periode'
    GROUP BY
      lahan.id_lahan
  ) lahan";
        return $this->db->query($query)->row_array();
    }

    function plan_vs_spk($project, $periode){
        $query = "SELECT
  COUNT(plan_vs_spk.id_plan) AS target, 
  100 AS target_persentase, 
  COALESCE(SUM(IF(plan_vs_spk.ontime_vs_late = 'Ontime',1,0)),0) as actual,
  ROUND((COALESCE(SUM(IF(plan_vs_spk.ontime_vs_late = 'Ontime',1,0)),0) / COUNT(plan_vs_spk.id_plan)) * 100, 1) as achieve_persentase,
  CONCAT('Data : ', COALESCE(SUM(IF(plan_vs_spk.ontime_vs_late = 'Ontime',1,0)),0) , '/' , COUNT(plan_vs_spk.id_plan) , ' (' , ROUND((COALESCE(SUM(IF(plan_vs_spk.ontime_vs_late = 'Ontime',1,0)),0) / COUNT(plan_vs_spk.id_plan)) * 100, 1) , '%)' ) as data_text
FROM
(
SELECT 
  plan_infra.project as id_project,
  pr.project,
  plan_infra.id_plan,
  plan_infra.`start` as plan_start,
  plan_infra.`end` as plan_end,
  infra_detail.spk_awal,
  infra_detail.spk_akhir,
  DATEDIFF(infra_detail.spk_awal,plan_infra.`start`) as leadtime,
  IF(DATEDIFF(infra_detail.spk_awal,plan_infra.`start`) <= 5,'Ontime','Late') as ontime_vs_late
FROM rsp_project_live.`t_plan_infra` plan_infra
LEFT JOIN rsp_project_live.m_project pr ON pr.id_project = plan_infra.project
LEFT JOIN rsp_project_live.t_infrastruktur_detail infra_detail ON infra_detail.id_plan = plan_infra.id_plan
WHERE
  plan_infra.project = $project
  AND LEFT(plan_infra.`start`, 7) = '$periode'
) plan_vs_spk";
        return $this->db->query($query)->row_array();
    }

    function spk_vs_pelaksana($project, $periode){
        $query = "SELECT
  COUNT(plan.id_plan) AS target,
  100 AS target_persentase,
  COALESCE(SUM(IF(plan.STATUS = 'Ontime', 1, 0)),0) AS actual,
  ROUND(COALESCE(SUM(IF(plan.STATUS = 'Ontime', 1, 0)),0) / COUNT(plan.id_plan) * 100, 0) AS achieve_persentase,
  CONCAT('Data : ', COALESCE(SUM(IF(plan.STATUS = 'Ontime', 1, 0)),0) , '/' , COUNT(plan.id_plan) , ' (' , ROUND((COALESCE(SUM(IF(plan.STATUS = 'Ontime', 1, 0)),0) / COUNT(plan.id_plan)) * 100, 1) , '%)' ) as data_text
FROM
  (
    SELECT
      plan_infra.id_plan,
      plan_infra.START,
      CONCAT(spk_infra_detail.spk_awal, ' 23:59:59') AS spk_awal,
      MIN(tasklist.created_at) AS tgl_progres_awal,
      MIN(spk_infra_detail.status_progres) AS status_spk,
      IF(MIN(tasklist.created_at) <= CONCAT(spk_infra_detail.spk_awal, ' 23:59:59'), 'Ontime', 'Late') AS STATUS
    FROM
      rsp_project_live.t_plan_infra plan_infra
      LEFT JOIN rsp_project_live.t_infrastruktur_detail AS spk_infra_detail ON plan_infra.id_plan = spk_infra_detail.id_plan
      LEFT JOIN rsp_project_live.t_infrastruktur AS spk_infra ON spk_infra_detail.id_inf = spk_infra.id_inf
      LEFT JOIN (
        SELECT
          id_inf,
          id_infrastruktur,
          created_at
        FROM
          (
            SELECT
              task_infra.id_inf,
              task_infra.infrastruktur AS id_infrastruktur,
              task_infra.created_at,
              task_infra.id_infra
            FROM
              rsp_project_live.t_task_infra task_infra
            WHERE
              task_infra.id_infra IN (
                SELECT
                  MIN(task_infra.id_infra) AS id_infra
                FROM
                  rsp_project_live.t_task_infra task_infra
                WHERE
                  task_infra.id_inf IS NOT NULL
                  AND task_infra.id_inf != ''
                GROUP BY
                  task_infra.id_inf,
                  task_infra.infrastruktur
              )
          ) latest_tasks
        GROUP BY
          id_inf,
          id_infrastruktur
      ) AS tasklist ON tasklist.id_inf = spk_infra_detail.id_inf
      AND tasklist.id_infrastruktur = spk_infra_detail.id_infrastruktur
    WHERE
      spk_infra_detail.project = $project
      AND LEFT(spk_infra_detail.spk_akhir, 7) = '$periode'
    GROUP BY
      plan_infra.id_plan,
      spk_infra.id_inf
    HAVING
      MIN(spk_infra_detail.status_progres) IN ('Complete', 'On Progres')
    ORDER BY
      IF(MIN(tasklist.created_at) <= CONCAT(spk_infra_detail.spk_awal, ' 23:59:59'), 'Ontime', 'Late')
  ) plan";
        return $this->db->query($query)->row_array();
    }

    function leadtime_perencana_infra($project, $periode){
        $query = "SELECT
  COUNT(perencana.id_plan_infra) AS target,
  100 AS target_persentase,
  COALESCE(SUM(IF(perencana.lt_plan_vs_aktual = 'Ontime', 1, 0)),0) AS actual,
  ROUND(COALESCE(SUM(IF(perencana.lt_plan_vs_aktual = 'Ontime', 1, 0)),0) / COUNT(perencana.id_plan_infra) * 100, 0) AS achieve_persentase,
  CONCAT('Data : ', COALESCE(SUM(IF(perencana.lt_plan_vs_aktual = 'Ontime', 1, 0)),0) , '/' , COUNT(perencana.id_plan_infra) , ' (' , ROUND((COALESCE(SUM(IF(perencana.lt_plan_vs_aktual = 'Ontime', 1, 0)),0) / COUNT(perencana.id_plan_infra)) * 100, 1) , '%)' ) as data_text
FROM
  (
    SELECT
      perencana.no_pr,
      perencana.id_plan_infra,
      m_perencana.perencana,
      pr.project,
      perencana.type,
      perencana.divisi,
      IF(DATEDIFF(DATE(COALESCE(perencana.end,CURRENT_DATE)),DATE(perencana.plan_end)) <= 0, 'Ontime','Late') AS lt_plan_vs_aktual,
      perencana.plan_start,
      perencana.plan_end,
      perencana.`start`, 
      perencana.`end`,
      m_perencana.leadtime as standar,
      DATEDIFF(perencana.end,perencana.start)+1 as leadtime             
      FROM
      rsp_project_live.t_perencana perencana
      LEFT JOIN rsp_project_live.m_perencana m_perencana ON perencana.id_perencana = m_perencana.id
      LEFT JOIN rsp_project_live.m_project pr ON perencana.id_project = pr.id_project
    WHERE 
      perencana.id_project = $project
      AND perencana.divisi = 'Infrastruktur'
      AND (LEFT(perencana.plan_start, 7) = '$periode' 
      OR LEFT(perencana.plan_end, 7) = '$periode')
  ) perencana";
        return $this->db->query($query)->row_array();
    }
}