<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_api_aftersales extends CI_Model
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
        if ($project == '0' || $project == 'all') {
            $query = "SELECT 'all' AS id_project, 'All Project' AS project";
        } else {

            $query = "SELECT
            p.id_project,
            p.project
            FROM
            rsp_project_live.m_project p 
            WHERE
            p.id_project = $project";
        }
        return $this->db->query($query)->row_array();
    }

    function kpi_corporate($periode) {
//         $query = "SELECT
//         'Aftersales Claim Rate (Berat)' as corporate_kpi,
//         MAX(CASE WHEN week = (SELECT MAX(week) FROM (
//        SELECT @a2 := @a2 + 1 AS week
//        FROM `all_dates`, (SELECT @a2 := 0) v
//        WHERE `all_dates`.`date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
//        AND LAST_DAY('$periode-01')
//        AND DAYNAME(`all_dates`.`date`) = 'Sunday'
//    ) w ) THEN target END)  AS target,

//       5 as target_persentase,

//    MAX(CASE WHEN week = (SELECT MAX(week) FROM (
//        SELECT @a3 := @a3 + 1 AS week
//        FROM `all_dates`, (SELECT @a3 := 0) v
//        WHERE `all_dates`.`date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
//        AND LAST_DAY('$periode-01')
//        AND DAYNAME(`all_dates`.`date`) = 'Sunday'
//    ) w ) THEN actual END)  AS actual,
   
//    IF(ROUND(
//     NULLIF(MAX(CASE WHEN week = (SELECT MAX(week) FROM (
//        SELECT @a5 := @a5 + 1 AS week
//        FROM `all_dates`, (SELECT @a5 := 0) v
//        WHERE `all_dates`.`date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
//          AND LAST_DAY('$periode-01')
//          AND DAYNAME(`all_dates`.`date`) = 'Sunday'
//    ) w ) THEN target END),0)
//    / (MAX(CASE WHEN week = (SELECT MAX(week) FROM (
//        SELECT @a4 := @a4 + 1 AS week
//        FROM `all_dates`, (SELECT @a4 := 0) v
//        WHERE `all_dates`.`date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
//          AND LAST_DAY('$periode-01')
//          AND DAYNAME(`all_dates`.`date`) = 'Sunday'
//    ) w ) THEN actual END)
//    ) * 100, 1
// ) > 100, 100, ROUND(
//     NULLIF(MAX(CASE WHEN week = (SELECT MAX(week) FROM (
//        SELECT @a5 := @a5 + 1 AS week
//        FROM `all_dates`, (SELECT @a5 := 0) v
//        WHERE `all_dates`.`date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
//          AND LAST_DAY('$periode-01')
//          AND DAYNAME(`all_dates`.`date`) = 'Sunday'
//    ) w ) THEN target END),0)
//    / (MAX(CASE WHEN week = (SELECT MAX(week) FROM (
//        SELECT @a4 := @a4 + 1 AS week
//        FROM `all_dates`, (SELECT @a4 := 0) v
//        WHERE `all_dates`.`date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
//          AND LAST_DAY('$periode-01')
//          AND DAYNAME(`all_dates`.`date`) = 'Sunday'
//    ) w ) THEN actual END)
//    ) * 100, 1
// )) AS achieve_persentase
//  FROM (
//       SELECT
//           @a := @a + 1 AS week,
//           CONCAT(YEAR(NOW()), '-01-01') AS date_start,
//           `all_dates`.`date` AS date_end,
//           (
//             SELECT COUNT(*) FROM rsp_project_live.t_akad
//             -- LEFT JOIN rsp_project_live.t_after_sales ON rsp_project_live.t_after_sales.id_konsumen = rsp_project_live.t_akad.id_konsumen
//             -- LEFT JOIN rsp_project_live.t_after_sales_internal AS inter ON inter.id_after_sales = rsp_project_live.t_after_sales.id_after_sales
//             -- LEFT JOIN rsp_project_live.m_status ON rsp_project_live.m_status.id_status = rsp_project_live.t_after_sales.acc_reject
//             -- LEFT JOIN rsp_project_live.m_status ms ON ms.id_status = inter.`status`
//             -- LEFT JOIN rsp_project_live.m_tipe_temuan ON rsp_project_live.t_after_sales.level_kerusakan = rsp_project_live.m_tipe_temuan.id
//             -- WHERE rsp_project_live.t_after_sales.tgl_pengecekan IS NOT NULL
//             --   AND rsp_project_live.t_after_sales.tgl_komplain BETWEEN date_start AND date_end
//             LEFT JOIN rsp_project_live.t_gci ON t_gci.id_konsumen = t_akad.id_konsumen
//             WHERE t_akad.hasil_akad = 1
//               AND t_akad.jadwal_akad BETWEEN date_start AND date_end
//           ) AS af_all,
//           (
//             SELECT COUNT(*) FROM rsp_project_live.t_akad
//             LEFT JOIN rsp_project_live.t_after_sales ON rsp_project_live.t_after_sales.id_konsumen = rsp_project_live.t_akad.id_konsumen
//             LEFT JOIN rsp_project_live.t_after_sales_internal AS inter ON inter.id_after_sales = rsp_project_live.t_after_sales.id_after_sales
//             LEFT JOIN rsp_project_live.m_status ON rsp_project_live.m_status.id_status = rsp_project_live.t_after_sales.acc_reject
//             LEFT JOIN rsp_project_live.m_status ms ON ms.id_status = inter.`status`
//             LEFT JOIN rsp_project_live.m_tipe_temuan ON rsp_project_live.t_after_sales.level_kerusakan = rsp_project_live.m_tipe_temuan.id
//             WHERE rsp_project_live.m_tipe_temuan.STATUS = 'Berat'
//               AND rsp_project_live.t_after_sales.tgl_komplain BETWEEN date_start AND date_end
//           ) AS af_berat,
//           5 AS target,
//           ROUND((
//             (
//               SELECT COUNT(*) FROM rsp_project_live.t_akad
//               LEFT JOIN rsp_project_live.t_after_sales ON rsp_project_live.t_after_sales.id_konsumen = rsp_project_live.t_akad.id_konsumen
//               LEFT JOIN rsp_project_live.t_after_sales_internal AS inter ON inter.id_after_sales = rsp_project_live.t_after_sales.id_after_sales
//               LEFT JOIN rsp_project_live.m_status ON rsp_project_live.m_status.id_status = rsp_project_live.t_after_sales.acc_reject
//               LEFT JOIN rsp_project_live.m_status ms ON ms.id_status = inter.`status`
//               LEFT JOIN rsp_project_live.m_tipe_temuan ON rsp_project_live.t_after_sales.level_kerusakan = rsp_project_live.m_tipe_temuan.id
//               WHERE rsp_project_live.m_tipe_temuan.`status` = 'Berat'
//                 AND rsp_project_live.t_after_sales.tgl_pengecekan IS NOT NULL
//                 AND rsp_project_live.t_after_sales.tgl_komplain BETWEEN date_start AND date_end
//             ) / (
//               SELECT COUNT(*) FROM rsp_project_live.t_akad
//             --   LEFT JOIN rsp_project_live.t_after_sales ON rsp_project_live.t_after_sales.id_konsumen = rsp_project_live.t_akad.id_konsumen
//             --   LEFT JOIN rsp_project_live.t_after_sales_internal AS inter ON inter.id_after_sales = rsp_project_live.t_after_sales.id_after_sales
//             --   LEFT JOIN rsp_project_live.m_status ON rsp_project_live.m_status.id_status = rsp_project_live.t_after_sales.acc_reject
//             --   LEFT JOIN rsp_project_live.m_status ms ON ms.id_status = inter.`status`
//             --   LEFT JOIN rsp_project_live.m_tipe_temuan ON rsp_project_live.t_after_sales.level_kerusakan = rsp_project_live.m_tipe_temuan.id
//             --   WHERE rsp_project_live.t_after_sales.tgl_komplain BETWEEN date_start AND date_end
//             LEFT JOIN rsp_project_live.t_gci ON t_gci.id_konsumen = t_akad.id_konsumen
//             WHERE t_akad.hasil_akad = 1
//               AND t_akad.jadwal_akad BETWEEN date_start AND date_end
//             )
//           ) * 100, 1) AS actual
//       FROM `all_dates`, (SELECT @a := 0) vars
//       WHERE
//           `all_dates`.`date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
//           AND LAST_DAY('$periode-01')
//           AND DAYNAME(`all_dates`.`date`) = 'Sunday'
//   ) weekly_data";

        $query = "SELECT
          'Aftersales Claim Rate (Berat)' AS corporate_kpi,
          afs.akad_target AS target,
          5 as target_persentase,
          -- CONCAT(COALESCE(ROUND(( ROUND(COALESCE(( COUNT(IF(afs.num_week = 1, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 2, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 3, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 4, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 5, 1, NULL)) / afs.akad_target ) * 100,0), 1) ) / 5, 1),0)) AS actual,  
          -- IF(
          --   ROUND((5 / COALESCE(ROUND(( ROUND(COALESCE(( COUNT(IF(afs.num_week = 1, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 2, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 3, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 4, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 5, 1, NULL)) / afs.akad_target ) * 100,0), 1) ) / 5, 1),0)) * 100, 1) > 100,
          --   100,
          --   ROUND((5 / COALESCE(ROUND(( ROUND(COALESCE(( COUNT(IF(afs.num_week = 1, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 2, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 3, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 4, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 5, 1, NULL)) / afs.akad_target ) * 100,0), 1) ) / 5, 1),0)) * 100, 1)
          -- ) AS achieve_persentase

          COALESCE(COUNT(*), 0) AS actual,
          ROUND(COALESCE(( COUNT(*) / afs.akad_target ) * 100,0), 1) AS actual_persentase,
          IF(
            ROUND((5 / ROUND(COALESCE(( COUNT(*) / afs.akad_target ) * 100,0), 1)) * 100, 1) > 100,
            100,
            ROUND((5 / ROUND(COALESCE(( COUNT(*) / afs.akad_target ) * 100,0), 1)) * 100, 1)
          )  AS achieve_persentase
          
        FROM
          (
            SELECT
              a.id_after_sales,
              a.tgl_komplain,
              m_project_unit.id_project,
              (
                FLOOR(
                  (
                    DATEDIFF(
                      a.tgl_komplain,
                      DATE_SUB(DATE_FORMAT(a.tgl_komplain, '%Y-%m-01'), INTERVAL(DAYOFWEEK(DATE_FORMAT(a.tgl_komplain, '%Y-%m-01')) - 2) DAY)
                    ) / 7
                  )
                ) + 1
              ) AS num_week,
              (
                SELECT
                  COUNT(*)
                FROM
                  rsp_project_live.t_akad
                  JOIN rsp_project_live.t_gci ON t_akad.id_konsumen = t_gci.id_konsumen
                WHERE
                  DATE(jadwal_akad) BETWEEN DATE_SUB(DATE_FORMAT(CONCAT('$periode', '-01'), '%Y-%m-%d'), INTERVAL 1 MONTH)
                  AND LAST_DAY(CONCAT('$periode', '-01'))
              ) AS akad_target
            FROM
              rsp_project_live.t_after_sales a
              LEFT JOIN rsp_project_live.m_project_unit ON m_project_unit.id_project_unit = a.id_project_unit
            WHERE
              LEFT(a.created_at, 7) = '$periode'
              AND a.acc_reject = 1
              AND a.level_kerusakan = 3
          ) AS afs";

        return $this->db->query($query)->row_array();
    }

    function kpi_project($project, $periode) {
        $kondisi = "";
        if ($project != '0' && $project != 'all') {
            $kondisi = "AND m_project_unit.id_project = $project";
        }
//         $query = "SELECT
//         'Aftersales Claim Rate (Berat)' as corporate_kpi,
//         COALESCE(MAX(CASE WHEN week = (SELECT MAX(week) FROM (
//        SELECT @a2 := @a2 + 1 AS week
//        FROM `all_dates`, (SELECT @a2 := 0) v
//        WHERE `all_dates`.`date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
//        AND LAST_DAY('$periode-01')
//        AND DAYNAME(`all_dates`.`date`) = 'Sunday'
//    ) w ) THEN target END) ,0) AS target,

//    5 as target_persentase,

//    COALESCE(MAX(CASE WHEN week = (SELECT MAX(week) FROM (
//        SELECT @a3 := @a3 + 1 AS week
//        FROM `all_dates`, (SELECT @a3 := 0) v
//        WHERE `all_dates`.`date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
//        AND LAST_DAY('$periode-01')
//        AND DAYNAME(`all_dates`.`date`) = 'Sunday'
//    ) w ) THEN actual END),0) AS actual,
   
//    COALESCE(IF(ROUND(
//     COALESCE(MAX(CASE WHEN week = (SELECT MAX(week) FROM (
//        SELECT @a5 := @a5 + 1 AS week
//        FROM `all_dates`, (SELECT @a5 := 0) v
//        WHERE `all_dates`.`date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
//          AND LAST_DAY('$periode-01')
//          AND DAYNAME(`all_dates`.`date`) = 'Sunday'
//    ) w ) THEN target END),0)
//    / (MAX(CASE WHEN week = (SELECT MAX(week) FROM (
//        SELECT @a4 := @a4 + 1 AS week
//        FROM `all_dates`, (SELECT @a4 := 0) v
//        WHERE `all_dates`.`date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
//          AND LAST_DAY('$periode-01')
//          AND DAYNAME(`all_dates`.`date`) = 'Sunday'
//    ) w ) THEN actual END)
//    ) * 100, 1
// ) > 100, 100, ROUND(
//     COALESCE(MAX(CASE WHEN week = (SELECT MAX(week) FROM (
//        SELECT @a5 := @a5 + 1 AS week
//        FROM `all_dates`, (SELECT @a5 := 0) v
//        WHERE `all_dates`.`date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
//          AND LAST_DAY('$periode-01')
//          AND DAYNAME(`all_dates`.`date`) = 'Sunday'
//    ) w ) THEN target END),0)
//    / (MAX(CASE WHEN week = (SELECT MAX(week) FROM (
//        SELECT @a4 := @a4 + 1 AS week
//        FROM `all_dates`, (SELECT @a4 := 0) v
//        WHERE `all_dates`.`date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
//          AND LAST_DAY('$periode-01')
//          AND DAYNAME(`all_dates`.`date`) = 'Sunday'
//    ) w ) THEN actual END)
//    ) * 100, 1
// )),0) AS achieve_persentase
//  FROM (
//       SELECT
//           @a := @a + 1 AS week,
//           CONCAT(YEAR(NOW()), '-01-01') AS date_start,
//           `all_dates`.`date` AS date_end,
//           (
//             SELECT COUNT(*) FROM rsp_project_live.t_akad
//             -- LEFT JOIN rsp_project_live.t_after_sales ON rsp_project_live.t_after_sales.id_konsumen = rsp_project_live.t_akad.id_konsumen
//             -- LEFT JOIN rsp_project_live.m_project_unit ON rsp_project_live.m_project_unit.id_project_unit = rsp_project_live.t_after_sales.id_project_unit
//             -- LEFT JOIN rsp_project_live.t_after_sales_internal AS inter ON inter.id_after_sales = rsp_project_live.t_after_sales.id_after_sales
//             -- LEFT JOIN rsp_project_live.m_status ON rsp_project_live.m_status.id_status = rsp_project_live.t_after_sales.acc_reject
//             -- LEFT JOIN rsp_project_live.m_status ms ON ms.id_status = inter.`status`
//             -- LEFT JOIN rsp_project_live.m_tipe_temuan ON rsp_project_live.t_after_sales.level_kerusakan = rsp_project_live.m_tipe_temuan.id
//             -- WHERE rsp_project_live.t_after_sales.tgl_pengecekan IS NOT NULL
//             --   AND rsp_project_live.t_after_sales.tgl_komplain BETWEEN date_start AND date_end
//             --   AND rsp_project_live.m_project_unit.id_project = $project
//             LEFT JOIN rsp_project_live.t_gci ON t_gci.id_konsumen = t_akad.id_konsumen
//             WHERE t_akad.hasil_akad = 1
//               AND t_akad.jadwal_akad BETWEEN date_start AND date_end
//               $kondisi2
//           ) AS af_all,
//           (
//             SELECT COUNT(*) FROM rsp_project_live.t_akad
//             LEFT JOIN rsp_project_live.t_after_sales ON rsp_project_live.t_after_sales.id_konsumen = rsp_project_live.t_akad.id_konsumen
//             LEFT JOIN rsp_project_live.m_project_unit ON rsp_project_live.m_project_unit.id_project_unit = rsp_project_live.t_after_sales.id_project_unit
//             LEFT JOIN rsp_project_live.t_after_sales_internal AS inter ON inter.id_after_sales = rsp_project_live.t_after_sales.id_after_sales
//             LEFT JOIN rsp_project_live.m_status ON rsp_project_live.m_status.id_status = rsp_project_live.t_after_sales.acc_reject
//             LEFT JOIN rsp_project_live.m_status ms ON ms.id_status = inter.`status`
//             LEFT JOIN rsp_project_live.m_tipe_temuan ON rsp_project_live.t_after_sales.level_kerusakan = rsp_project_live.m_tipe_temuan.id
//             WHERE rsp_project_live.m_tipe_temuan.STATUS = 'Berat'
//               AND rsp_project_live.t_after_sales.tgl_komplain BETWEEN date_start AND date_end
//               $kondisi
//           ) AS af_berat,
//           5 AS target,
//           ROUND((
//             (
//               SELECT COUNT(*) FROM rsp_project_live.t_akad
//               LEFT JOIN rsp_project_live.t_after_sales ON rsp_project_live.t_after_sales.id_konsumen = rsp_project_live.t_akad.id_konsumen
//               LEFT JOIN rsp_project_live.m_project_unit ON rsp_project_live.m_project_unit.id_project_unit = rsp_project_live.t_after_sales.id_project_unit
//               LEFT JOIN rsp_project_live.t_after_sales_internal AS inter ON inter.id_after_sales = rsp_project_live.t_after_sales.id_after_sales
//               LEFT JOIN rsp_project_live.m_status ON rsp_project_live.m_status.id_status = rsp_project_live.t_after_sales.acc_reject
//               LEFT JOIN rsp_project_live.m_status ms ON ms.id_status = inter.`status`
//               LEFT JOIN rsp_project_live.m_tipe_temuan ON rsp_project_live.t_after_sales.level_kerusakan = rsp_project_live.m_tipe_temuan.id
//               WHERE rsp_project_live.m_tipe_temuan.`status` = 'Berat'
//                 AND rsp_project_live.t_after_sales.tgl_pengecekan IS NOT NULL
//                 AND rsp_project_live.t_after_sales.tgl_komplain BETWEEN date_start AND date_end
//                 $kondisi
//             ) / (
//               SELECT COUNT(*) FROM rsp_project_live.t_akad
//             --   LEFT JOIN rsp_project_live.t_after_sales ON rsp_project_live.t_after_sales.id_konsumen = rsp_project_live.t_akad.id_konsumen
//             --   LEFT JOIN rsp_project_live.m_project_unit ON rsp_project_live.m_project_unit.id_project_unit = rsp_project_live.t_after_sales.id_project_unit
//             --   LEFT JOIN rsp_project_live.t_after_sales_internal AS inter ON inter.id_after_sales = rsp_project_live.t_after_sales.id_after_sales
//             --   LEFT JOIN rsp_project_live.m_status ON rsp_project_live.m_status.id_status = rsp_project_live.t_after_sales.acc_reject
//             --   LEFT JOIN rsp_project_live.m_status ms ON ms.id_status = inter.`status`
//             --   LEFT JOIN rsp_project_live.m_tipe_temuan ON rsp_project_live.t_after_sales.level_kerusakan = rsp_project_live.m_tipe_temuan.id
//             --   WHERE rsp_project_live.t_after_sales.tgl_komplain BETWEEN date_start AND date_end
//             --   AND rsp_project_live.m_project_unit.id_project = $project
//              LEFT JOIN rsp_project_live.t_gci ON t_gci.id_konsumen = t_akad.id_konsumen
//             WHERE t_akad.hasil_akad = 1
//               AND t_akad.jadwal_akad BETWEEN date_start AND date_end
//               $kondisi2
//             )
//           ) * 100, 1) AS actual
//       FROM `all_dates`, (SELECT @a := 0) vars
//       WHERE
//           `all_dates`.`date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
//           AND LAST_DAY('$periode-01')
//           AND DAYNAME(`all_dates`.`date`) = 'Sunday'
//   ) weekly_data";

        $query = "SELECT
          'Aftersales Claim Rate (Berat)' AS corporate_kpi,
          afs.akad_target AS target,
          5 as target_persentase,
          -- CONCAT(COALESCE(ROUND(( ROUND(COALESCE(( COUNT(IF(afs.num_week = 1, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 2, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 3, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 4, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 5, 1, NULL)) / afs.akad_target ) * 100,0), 1) ) / 5, 1),0)) AS actual,  
          -- IF(
          --   ROUND((5 / COALESCE(ROUND(( ROUND(COALESCE(( COUNT(IF(afs.num_week = 1, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 2, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 3, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 4, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 5, 1, NULL)) / afs.akad_target ) * 100,0), 1) ) / 5, 1),0)) * 100, 1) > 100,
          --   100,
          --   ROUND((5 / COALESCE(ROUND(( ROUND(COALESCE(( COUNT(IF(afs.num_week = 1, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 2, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 3, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 4, 1, NULL)) / afs.akad_target ) * 100,0), 1) +
          -- ROUND(COALESCE(( COUNT(IF(afs.num_week = 5, 1, NULL)) / afs.akad_target ) * 100,0), 1) ) / 5, 1),0)) * 100, 1)
          -- ) AS achieve_persentase
          COALESCE(COUNT(*), 0) AS actual,
          ROUND(COALESCE(( COUNT(*) / afs.akad_target ) * 100,0), 1) AS actual_persentase,
          IF(
            ROUND((5 / ROUND(COALESCE(( COUNT(*) / afs.akad_target ) * 100,0), 1)) * 100, 1) > 100,
            100,
            ROUND((5 / ROUND(COALESCE(( COUNT(*) / afs.akad_target ) * 100,0), 1)) * 100, 1)
          )  AS achieve_persentase
          
        FROM
          (
            SELECT
              a.id_after_sales,
              a.tgl_komplain,
              m_project_unit.id_project,
              (
                FLOOR(
                  (
                    DATEDIFF(
                      a.tgl_komplain,
                      DATE_SUB(DATE_FORMAT(a.tgl_komplain, '%Y-%m-01'), INTERVAL(DAYOFWEEK(DATE_FORMAT(a.tgl_komplain, '%Y-%m-01')) - 2) DAY)
                    ) / 7
                  )
                ) + 1
              ) AS num_week,
              (
                SELECT
                  COUNT(*)
                FROM
                  rsp_project_live.t_akad
                  JOIN rsp_project_live.t_gci ON t_akad.id_konsumen = t_gci.id_konsumen
                WHERE
                  DATE(jadwal_akad) BETWEEN DATE_SUB(DATE_FORMAT(CONCAT('$periode', '-01'), '%Y-%m-%d'), INTERVAL 1 MONTH)
                  AND LAST_DAY(CONCAT('$periode', '-01'))
              ) AS akad_target
            FROM
              rsp_project_live.t_after_sales a
              LEFT JOIN rsp_project_live.m_project_unit ON m_project_unit.id_project_unit = a.id_project_unit
            WHERE
              LEFT(a.created_at, 7) = '$periode'
              AND a.acc_reject = 1
              AND a.level_kerusakan = 3
              $kondisi
          ) AS afs";
  
        return $this->db->query($query)->row_array();
    }

//     function akad_vs_aftersales($project, $periode) {
//         $kondisi = "";
//         $kondisi2 = "";
//         if ($project != '0' && $project != 'all') {
//             $kondisi = "AND rsp_project_live.m_project_unit.id_project = $project";
//             $kondisi2 = "AND t_gci.id_project = $project";
//         }
// //         $query = "SELECT
// //         COALESCE(MAX(CASE WHEN week = (SELECT MAX(week) FROM (
// //        SELECT @a2 := @a2 + 1 AS week
// //        FROM `all_dates`, (SELECT @a2 := 0) v
// //        WHERE `all_dates`.`date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
// //        AND LAST_DAY('$periode-01')
// //        AND DAYNAME(`all_dates`.`date`) = 'Sunday'
// //    ) w ) THEN target END) ,0) AS target,

// //     5 as target_persentase,

// //    COALESCE(MAX(CASE WHEN week = (SELECT MAX(week) FROM (
// //        SELECT @a3 := @a3 + 1 AS week
// //        FROM `all_dates`, (SELECT @a3 := 0) v
// //        WHERE `all_dates`.`date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
// //        AND LAST_DAY('$periode-01')
// //        AND DAYNAME(`all_dates`.`date`) = 'Sunday'
// //    ) w ) THEN actual END),0) AS actual,
   
// //    COALESCE(IF(ROUND(
// //     (MAX(CASE WHEN week = (SELECT MAX(week) FROM (
// //        SELECT @a4 := @a4 + 1 AS week
// //        FROM `all_dates`, (SELECT @a4 := 0) v
// //        WHERE `all_dates`.`date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
// //          AND LAST_DAY('$periode-01')
// //          AND DAYNAME(`all_dates`.`date`) = 'Sunday'
// //    ) w ) THEN actual END)
// //    / 
// //    COALESCE(MAX(CASE WHEN week = (SELECT MAX(week) FROM (
// //        SELECT @a5 := @a5 + 1 AS week
// //        FROM `all_dates`, (SELECT @a5 := 0) v
// //        WHERE `all_dates`.`date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
// //          AND LAST_DAY('$periode-01')
// //          AND DAYNAME(`all_dates`.`date`) = 'Sunday'
// //    ) w ) THEN target END),0)
// //    ) * 100, 1
// // ) > 100, 100, ROUND(
// //     (MAX(CASE WHEN week = (SELECT MAX(week) FROM (
// //        SELECT @a4 := @a4 + 1 AS week
// //        FROM `all_dates`, (SELECT @a4 := 0) v
// //        WHERE `all_dates`.`date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
// //          AND LAST_DAY('$periode-01')
// //          AND DAYNAME(`all_dates`.`date`) = 'Sunday'
// //    ) w ) THEN actual END)
// //    /
// //    COALESCE(MAX(CASE WHEN week = (SELECT MAX(week) FROM (
// //        SELECT @a5 := @a5 + 1 AS week
// //        FROM `all_dates`, (SELECT @a5 := 0) v
// //        WHERE `all_dates`.`date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
// //          AND LAST_DAY('$periode-01')
// //          AND DAYNAME(`all_dates`.`date`) = 'Sunday'
// //    ) w ) THEN target END),0)
// //    ) * 100, 1
// // )),0) AS achieve_persentase
// //  FROM (
// //       SELECT
// //           @a := @a + 1 AS week,
// //           CONCAT(YEAR(NOW()), '-01-01') AS date_start,
// //           `all_dates`.`date` AS date_end,
// //           (
// //             SELECT COUNT(*) FROM rsp_project_live.t_akad
// //             LEFT JOIN rsp_project_live.t_gci ON t_gci.id_konsumen = t_akad.id_konsumen
// //             WHERE t_akad.hasil_akad = 1
// //               AND t_akad.jadwal_akad BETWEEN date_start AND date_end
// //               $kondisi2
// //           ) AS target,
// //           (
// //             SELECT COUNT(*) FROM rsp_project_live.t_akad
// //             LEFT JOIN rsp_project_live.t_after_sales ON rsp_project_live.t_after_sales.id_konsumen = rsp_project_live.t_akad.id_konsumen
// //             LEFT JOIN rsp_project_live.m_project_unit ON rsp_project_live.m_project_unit.id_project_unit = rsp_project_live.t_after_sales.id_project_unit
// //             LEFT JOIN rsp_project_live.t_after_sales_internal AS inter ON inter.id_after_sales = rsp_project_live.t_after_sales.id_after_sales
// //             LEFT JOIN rsp_project_live.m_status ON rsp_project_live.m_status.id_status = rsp_project_live.t_after_sales.acc_reject
// //             LEFT JOIN rsp_project_live.m_status ms ON ms.id_status = inter.`status`
// //             LEFT JOIN rsp_project_live.m_tipe_temuan ON rsp_project_live.t_after_sales.level_kerusakan = rsp_project_live.m_tipe_temuan.id
// //             WHERE rsp_project_live.m_tipe_temuan.STATUS = 'Berat'
// //               AND rsp_project_live.t_after_sales.tgl_komplain BETWEEN date_start AND date_end
// //               $kondisi
// //           ) AS actual
// //       FROM `all_dates`, (SELECT @a := 0) vars
// //       WHERE
// //           `all_dates`.`date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
// //           AND LAST_DAY('$periode-01')
// //           AND DAYNAME(`all_dates`.`date`) = 'Sunday'
// //   ) weekly_data";

//         $query = "SELECT
//           afs.akad_target AS target,
//           5 as target_persentase,
//           -- COALESCE(ROUND(COALESCE(COUNT(IF(afs.num_week = 1, 1, NULL)), 0) +
//           -- COALESCE(COUNT(IF(afs.num_week = 2, 1, NULL)), 0) +
//           -- COALESCE(COUNT(IF(afs.num_week = 3, 1, NULL)), 0) +
//           -- COALESCE(COUNT(IF(afs.num_week = 4, 1, NULL)), 0) +
//           -- COALESCE(COUNT(IF(afs.num_week = 5, 1, NULL)), 0), 1),0) AS actual,  
//           -- IF(
//           --   ROUND((COALESCE(ROUND(COALESCE(COUNT(IF(afs.num_week = 1, 1, NULL)), 0) +
//           -- COALESCE(COUNT(IF(afs.num_week = 2, 1, NULL)), 0) +
//           -- COALESCE(COUNT(IF(afs.num_week = 3, 1, NULL)), 0) +
//           -- COALESCE(COUNT(IF(afs.num_week = 4, 1, NULL)), 0) +
//           -- COALESCE(COUNT(IF(afs.num_week = 5, 1, NULL)), 0), 1),0) / afs.akad_target) * 100, 1) > 100,
//           --   100,
//           --   ROUND((COALESCE(ROUND(COALESCE(COUNT(IF(afs.num_week = 1, 1, NULL)), 0) +
//           -- COALESCE(COUNT(IF(afs.num_week = 2, 1, NULL)), 0) +
//           -- COALESCE(COUNT(IF(afs.num_week = 3, 1, NULL)), 0) +
//           -- COALESCE(COUNT(IF(afs.num_week = 4, 1, NULL)), 0) +
//           -- COALESCE(COUNT(IF(afs.num_week = 5, 1, NULL)), 0), 1),0) / afs.akad_target) * 100, 1)
//           -- ) AS achieve_persentase
//           COALESCE(COUNT(*), 0) AS actual,
//           ROUND(COALESCE(( COUNT(*) / afs.akad_target ) * 100,0), 1) AS actual_persentase,
//           IF(
//             ROUND((5 / ROUND(COALESCE(( COUNT(*) / afs.akad_target ) * 100,0), 1)) * 100, 1) > 100,
//             100,
//             ROUND((5 / ROUND(COALESCE(( COUNT(*) / afs.akad_target ) * 100,0), 1)) * 100, 1)
//           )  AS achieve_persentase
          
//         FROM
//           (
//             SELECT
//               a.id_after_sales,
//               a.tgl_komplain,
//               m_project_unit.id_project,
//               (
//                 FLOOR(
//                   (
//                     DATEDIFF(
//                       a.tgl_komplain,
//                       DATE_SUB(DATE_FORMAT(a.tgl_komplain, '%Y-%m-01'), INTERVAL(DAYOFWEEK(DATE_FORMAT(a.tgl_komplain, '%Y-%m-01')) - 2) DAY)
//                     ) / 7
//                   )
//                 ) + 1
//               ) AS num_week,
//               (
//                 SELECT
//                   COUNT(*)
//                 FROM
//                   rsp_project_live.t_akad
//                   JOIN rsp_project_live.t_gci ON t_akad.id_konsumen = t_gci.id_konsumen
//                 WHERE
//                   DATE(jadwal_akad) BETWEEN DATE_SUB(DATE_FORMAT(CONCAT('$periode', '-01'), '%Y-%m-%d'), INTERVAL 1 MONTH)
//                   AND LAST_DAY(CONCAT('$periode', '-01'))
//               ) AS akad_target
//             FROM
//               rsp_project_live.t_after_sales a
//               LEFT JOIN rsp_project_live.m_project_unit ON m_project_unit.id_project_unit = a.id_project_unit
//             WHERE
//               LEFT(a.created_at, 7) = '$periode'
//               AND a.acc_reject = 1
//               AND a.level_kerusakan = 3
//               $kondisi
//           ) AS afs";

//         return $this->db->query($query)->row_array();
//     }

    function leadtime_perbaikan($project, $periode) {
        $kondisi = "";
        if ($project != '0' && $project != 'all') {
            $kondisi = "AND m_project.id_project = $project";
        }
        $query = "SELECT
  COALESCE(COUNT(afs.tgl_finance),0) as target,
  100 as target_persentase,
  COALESCE(SUM(IF(afs.tgl_finance < DATE(
  -- CASE
  --   WHEN afs.id_status_takeover IS NOT NULL AND afs.id_status_takeover != 5 THEN
  --     afs.tgl_deadline_takeover
  --   ELSE
      IF(afs.tgl_deadline_vendor > afs.tgl_deadline,afs.tgl_deadline_vendor,afs.tgl_deadline)
  -- END
  ), 1,0)),0) as actual,
  COALESCE(ROUND((COALESCE(SUM(IF(afs.tgl_finance < DATE(
  -- CASE
  --   WHEN afs.id_status_takeover IS NOT NULL AND afs.id_status_takeover != 5 THEN
  --     afs.tgl_deadline_takeover
  --   ELSE
      IF(afs.tgl_deadline_vendor > afs.tgl_deadline,afs.tgl_deadline_vendor,afs.tgl_deadline)
  -- END
  ), 1,0)),0) / COALESCE(COUNT(afs.tgl_finance),0)) * 100),0) as achieve_persentase
FROM
  (
    SELECT
      COALESCE(m_project.project, '') AS project,
      COALESCE(m_project_unit.blok, '') AS blok,
      t_after_sales.tgl_komplain,
      SUBSTR(t_after_sales.tgl_perbaikan, 1, 10) AS tgl_perbaikan,
      ms.id_status AS id_status_takeover,
      SUBSTR(t_after_sales.tgl_pengecekan, 1, 10) AS tgl_pengecekan,
      COALESCE(
        t_after_sales.tgl_deadline,
        DATE(t_after_sales.tgl_pengecekan) + INTERVAL(t_after_sales.leadtime) DAY + INTERVAL(
          SELECT
            COUNT(tgl) AS jumlah
          FROM
            rsp_project_live.view_tanggal_merah
          WHERE
            tgl BETWEEN DATE(t_after_sales.tgl_pengecekan)
            AND (
              DATE(t_after_sales.tgl_pengecekan) + INTERVAL(t_after_sales.leadtime) DAY + INTERVAL(
                SELECT
                  COUNT(tgl) AS jumlah
                FROM
                  rsp_project_live.view_tanggal_merah
                WHERE
                  tgl BETWEEN DATE(t_after_sales.tgl_pengecekan)
                  AND (DATE(t_after_sales.tgl_pengecekan) + INTERVAL(t_after_sales.leadtime) DAY)
              ) DAY
            )
        ) DAY
      ) AS tgl_deadline,
      (
        DATE(t_after_sales.tgl_pengecekan) + INTERVAL(t_after_sales.leadtime) DAY + INTERVAL(
          SELECT
            COUNT(tgl) AS jumlah
          FROM
            rsp_project_live.view_tanggal_merah
          WHERE
            tgl BETWEEN DATE(t_after_sales.tgl_pengecekan)
            AND (
              DATE(t_after_sales.tgl_pengecekan) + INTERVAL(t_after_sales.leadtime) DAY + INTERVAL(
                SELECT
                  COUNT(tgl) AS jumlah
                FROM
                  rsp_project_live.view_tanggal_merah
                WHERE
                  tgl BETWEEN DATE(t_after_sales.tgl_pengecekan)
                  AND (DATE(t_after_sales.tgl_pengecekan) + INTERVAL(t_after_sales.leadtime) DAY)
              ) DAY
            )
        ) DAY
      ) AS tgl_deadline_vendor,
      IF(
        t_after_sales.status_perbaikan = 3,
        IF(
          inter.id IS NOT NULL
          AND inter.STATUS != 5,
          IF(
            DATE(t_after_sales.tgl_perbaikan) > DATE(inter.finance_at),
            DATE(t_after_sales.tgl_perbaikan),
            DATE(inter.finance_at)
          ),
          DATE(t_after_sales.tgl_perbaikan)
        ),
        ''
      ) AS tgl_finance,
      COALESCE(t_after_sales.tgl_pengerjaan, '') AS tgl_pengerjaan,
      DATE(inter.created_at) AS tgl_take_over,
      inter.finance_at,
      IF(inter.finance_at IS NOT NULL AND inter.STATUS != 5, inter.finance_at, NULL) AS tgl_verif_takeover,
      (
        IF(
          inter.finance_at IS NOT NULL
          AND inter.STATUS != 5,
          (
            (
              inter.finance_at + INTERVAL(
                CASE
                  WHEN t_after_sales.leadtime = 7 THEN
                    2
                  WHEN t_after_sales.leadtime = 15 THEN
                    3
                  WHEN t_after_sales.leadtime = 21 THEN
                    6
                  ELSE
                    0
                END
              ) DAY
            ) + INTERVAL(t_after_sales.leadtime) DAY
          ),
          0
        ) - INTERVAL(
          CASE
            WHEN t_after_sales.leadtime = 7 THEN
              2
            WHEN t_after_sales.leadtime = 15 THEN
              3
            WHEN t_after_sales.leadtime = 21 THEN
              6
            ELSE
              0
          END
        ) DAY
      ) AS tgl_pengerjaan_takeover,
      IF(
        inter.finance_at IS NOT NULL
        AND inter.STATUS != 5,
        (inter.finance_at + INTERVAL(t_after_sales.leadtime) DAY),
        NULL
      ) AS tgl_deadline_takeover,
      t_after_sales.created_at AS tgl_created
    FROM
      rsp_project_live.t_after_sales
      LEFT JOIN rsp_project_live.t_after_sales_internal AS inter ON inter.id_after_sales = t_after_sales.id_after_sales
      LEFT JOIN rsp_project_live.m_project_unit ON t_after_sales.id_project_unit = m_project_unit.id_project_unit
      LEFT JOIN (
        SELECT
          *
        FROM
          rsp_project_live.m_project
          LEFT JOIN (SELECT id_user AS id_sm, employee_name AS sm FROM rsp_project_live.`user`) u ON u.id_sm = m_project.sm_approve
          LEFT JOIN (SELECT id_user AS id_pm, employee_name AS pm FROM rsp_project_live.`user`) u1 ON u1.id_pm = m_project.pm_housing
      ) m_project ON m_project_unit.id_project = m_project.id_project
      LEFT JOIN rsp_project_live.m_status_stok ON t_after_sales.status_perbaikan = m_status_stok.`status` 
      LEFT JOIN rsp_project_live.`user` ON t_after_sales.created_by = `user`.`id_user`
      -- LEFT JOIN rsp_project_live.m_konsumen ON m_konsumen.id_konsumen = t_after_sales.id_konsumen
      -- LEFT JOIN rsp_project_live.m_status ON m_status.id_status = t_after_sales.acc_reject
      LEFT JOIN rsp_project_live.m_status ms ON ms.id_status = inter.`status`
    WHERE
      LEFT(t_after_sales.created_at, 7) = '$periode'
      $kondisi
      -- AND t_after_sales.status_perbaikan = 3
      AND t_after_sales.level_kerusakan = 3
      AND t_after_sales.acc_reject = 1
      -- AND t_after_sales.id_konsumen IS NOT NULL
      -- AND t_after_sales.marketing IS NULL
    GROUP BY
      t_after_sales.id_after_sales
  ) afs";
        return $this->db->query($query)->row_array();
    }

    function rating_aftersales($project, $periode) {
        $kondisi = "";
        if ($project != '0' && $project != 'all') {
            $kondisi = "AND m_project.id_project = $project";
        }
        $query = "SELECT
  4.5 as target,
  100 as target_persentase,
  COALESCE(ROUND(SUM(afs.rating_afs) / COUNT(afs.id_after_sales)),0) as actual,
  COALESCE(ROUND((COALESCE(ROUND(SUM(afs.rating_afs) / COUNT(afs.id_after_sales)),0) / 4.5) * 100),0) as achieve_persentase
FROM
  (
    SELECT
      t_after_sales.id_after_sales,
      IF(
        t_after_sales.status_perbaikan = 3,
        IF(
          inter.id IS NOT NULL
          AND inter.STATUS != 5,
          IF(
            DATE(t_after_sales.tgl_perbaikan) > DATE(inter.finance_at),
            DATE(t_after_sales.tgl_perbaikan),
            DATE(inter.finance_at)
          ),
          DATE(t_after_sales.tgl_perbaikan)
        ),
        ''
      ) AS tgl_finance,
      COALESCE(t_after_sales.f_afs_pelayanan, '') AS f_afs_pelayanan,
      COALESCE(t_after_sales.f_afs_kualitas, '') AS f_afs_kualitas,
      COALESCE(t_after_sales.f_afs_respon, '') AS f_afs_respon,
      ROUND(
        (COALESCE(t_after_sales.f_afs_respon, 0) + COALESCE(t_after_sales.f_afs_pelayanan, 0) + COALESCE(t_after_sales.f_afs_kualitas, 0)) / 3
      ) AS rating_afs
    FROM
      rsp_project_live.t_after_sales
      LEFT JOIN rsp_project_live.t_after_sales_internal AS inter ON inter.id_after_sales = t_after_sales.id_after_sales
      LEFT JOIN rsp_project_live.m_project_unit ON t_after_sales.id_project_unit = m_project_unit.id_project_unit
      LEFT JOIN (
        SELECT
          *
        FROM
          rsp_project_live.m_project
          LEFT JOIN (SELECT id_user AS id_sm, employee_name AS sm FROM rsp_project_live.`user`) u ON u.id_sm = m_project.sm_approve
          LEFT JOIN (SELECT id_user AS id_pm, employee_name AS pm FROM rsp_project_live.`user`) u1 ON u1.id_pm = m_project.pm_housing
      ) m_project ON m_project_unit.id_project = m_project.id_project
      LEFT JOIN rsp_project_live.m_status_stok ON t_after_sales.status_perbaikan = m_status_stok.`status` 
      LEFT JOIN rsp_project_live.`user` ON t_after_sales.created_by = `user`.`id_user`
      LEFT JOIN rsp_project_live.m_konsumen ON m_konsumen.id_konsumen = t_after_sales.id_konsumen
      LEFT JOIN rsp_project_live.m_status ON m_status.id_status = t_after_sales.acc_reject
      LEFT JOIN rsp_project_live.m_status ms ON ms.id_status = inter.`status`
    WHERE
      LEFT(t_after_sales.created_at, 7) = '$periode'
      $kondisi
      -- AND t_after_sales.status_perbaikan = 3
      AND t_after_sales.level_kerusakan = 3
      AND t_after_sales.acc_reject = 1
      -- AND t_after_sales.id_konsumen IS NOT NULL
      -- AND t_after_sales.marketing IS NULL
    GROUP BY
      t_after_sales.id_after_sales
  ) afs";
        return $this->db->query($query)->row_array();
    }

    function leadtime_perbaikan_web($project, $periode) {
        $kondisi = "";
        if ($project != '0' && $project != 'all') {
            $kondisi = "AND t.id_project = $project";
        }
        $query = "SELECT
  COUNT(afs_web.id_task) as target,
  100 as target_persentase,
  COALESCE(SUM(IF(afs_web.leadtime_solver = 'Ontime', 1, 0)),0) as actual,
  COALESCE(ROUND((COALESCE(SUM(IF(afs_web.leadtime_solver = 'Ontime', 1, 0)),0) / COUNT(afs_web.id_task)) * 100),0) as achieve_persentase
FROM
  (SELECT
                t.created_at,
                t.created_by,
                t.verified_by,
                COALESCE(IF(t.project = '', null, t.project), m_project.project) AS project,
                t.blok,
                COALESCE(t.verified_at,'waiting') AS verified_at,
                t.escalation_by,
                t.escalation_name,
                COALESCE(t.escalation_at,'waiting') AS escalation_at,
                DATE_FORMAT(t.created_at, '%d %b %y') AS tgl_dibuat,
                DATEDIFF(DATE(t.escalation_at),t.created_at) as escalation_diff,
                IF(DATEDIFF(DATE(t.escalation_at),t.created_at) > 0,'Late','Ontime') as leadtime_escalation,
                COALESCE(DATE_FORMAT(t.start, '%d %b %y'),'') AS tgl_diproses,
                SUBSTR(t.created_at,12,5) AS jam_dibuat,
                t.id_task,
                t.task,
                t.progress,
                CASE WHEN TIMESTAMPDIFF( MINUTE, t.created_at, COALESCE(t.`start`,CURRENT_TIME) ) > (60*24) THEN
                        CONCAT(TIMESTAMPDIFF( DAY, t.created_at, COALESCE(t.`start`,CURRENT_TIME) ), ' days')
                    WHEN TIMESTAMPDIFF( MINUTE, t.created_at, COALESCE(t.`start`,CURRENT_TIME) ) > 60 THEN
                        CONCAT(TIMESTAMPDIFF( HOUR, t.created_at, COALESCE(t.`start`,CURRENT_TIME) ), ' hour')
                    WHEN TIMESTAMPDIFF( MINUTE, t.created_at, COALESCE(t.`start`,CURRENT_TIME) ) > 0 THEN
                        CONCAT(TIMESTAMPDIFF( MINUTE, t.created_at, COALESCE(t.`start`,CURRENT_TIME) ), ' minutes')
                    ELSE
                        ''
                END AS leadtime_process,
                CASE WHEN TIMESTAMPDIFF( MINUTE, COALESCE(t.`start`,CURRENT_TIME), COALESCE(t.`done_date`,CURRENT_TIME) ) > (60*24) THEN
                        CONCAT(TIMESTAMPDIFF( DAY, COALESCE(t.`start`,CURRENT_TIME), COALESCE(t.`done_date`,CURRENT_TIME) ), ' days')
                    WHEN TIMESTAMPDIFF( MINUTE, COALESCE(t.`start`,CURRENT_TIME), COALESCE(t.`done_date`,CURRENT_TIME) ) > 60 THEN
                        CONCAT(TIMESTAMPDIFF( HOUR, COALESCE(t.`start`,CURRENT_TIME), COALESCE(t.`done_date`,CURRENT_TIME) ), ' hour')
                    WHEN TIMESTAMPDIFF( MINUTE, COALESCE(t.`start`,CURRENT_TIME), COALESCE(t.`done_date`,CURRENT_TIME) ) > 0 THEN
                        CONCAT(TIMESTAMPDIFF( MINUTE, COALESCE(t.`start`,CURRENT_TIME), COALESCE(t.`done_date`,CURRENT_TIME) ), ' minutes')
                    ELSE
                        ''
                END AS leadtime_progress,
                COALESCE(t.evaluation,'') AS evaluation,
                COALESCE(t.start,'') AS `start`,
                COALESCE(SUBSTR(t.end,1,10),'') AS `end`,
                COALESCE(CASE WHEN DATE_FORMAT( t.START, '%b %y' ) = DATE_FORMAT( t.END, '%b %y' ) THEN CONCAT(DATE_FORMAT( t.START, '%d' ), '-', DATE_FORMAT( t.END, '%d %b %y' ))
        WHEN  DATE_FORMAT( t.START, '%y' ) = DATE_FORMAT( t.END, '%y' ) AND DATE_FORMAT( t.START, '%b' ) != DATE_FORMAT( t.END, '%b' ) THEN CONCAT(DATE_FORMAT( t.START, '%d %b' ), ' - ', DATE_FORMAT( t.END, '%d %b %y' ))
        ELSE CONCAT(DATE_FORMAT( t.START, '%d %b %y' ), ' - ', DATE_FORMAT( t.END, '%d %b %y' )) END,'') AS timeline,
                t.id_category,
                c.category,
                COALESCE(t.due_date,'') AS tgl_due_date,
                COALESCE(DATE_FORMAT(t.due_date, '%d %b %y'),'') AS due_date,
                COALESCE(t.done_date,'on process') AS solver_at,
                TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) AS due_diff,
                DATEDIFF(DATE(t.done_date),t.due_date) as solver_diff,
                IF(DATEDIFF(DATE(t.done_date),t.due_date) > 0,'Late','Ontime') as leadtime_solver,
                t.follow_up_at,
                t.follow_up_by,
                CONCAT(
                    FLOOR(TIMESTAMPDIFF(MINUTE, t.created_at, t.follow_up_at) / (60*24)), ' Hari, ',
                    FLOOR((TIMESTAMPDIFF(MINUTE, t.created_at, t.follow_up_at) % (60*24)) / 60), ' Jam, ',
                    TIMESTAMPDIFF(MINUTE, t.created_at, t.follow_up_at) % 60, ' menit'
                ) AS leadtime_follow_up
            FROM
                `cm_task` t
                LEFT JOIN cm_rating r ON r.id_task = t.id_task
                LEFT JOIN xin_employees e ON FIND_IN_SET( e.user_id, t.pic )
                LEFT JOIN xin_employees em ON em.user_id = t.created_by
                LEFT JOIN xin_employees vf ON vf.user_id = t.verified_by
                LEFT JOIN xin_employees es ON es.user_id = t.escalation_by
                LEFT JOIN xin_companies cmp ON cmp.company_id = em.company_id
                LEFT JOIN xin_departments d ON d.department_id = em.department_id
                LEFT JOIN cm_category c ON c.id = t.id_category
                LEFT JOIN cm_status s ON s.id = t.`status`
                LEFT JOIN cm_priority p ON p.id = t.priority
                LEFT JOIN rsp_project_live.m_konsumen k ON k.id_konsumen = t.id_konsumen
                LEFT JOIN rsp_project_live.t_project_bangun_detail spk_detail ON t.id_project = spk_detail.id_project AND t.blok = spk_detail.blok
                LEFT JOIN rsp_project_live.t_project_bangun spk ON spk.id_rencana = spk_detail.id_rencana
                LEFT JOIN rsp_project_live.m_vendor ven ON ven.id_vendor = spk.vendor
                LEFT JOIN rsp_project_live.t_infrastruktur_detail spk_infra_detail ON spk_infra_detail.project = t.id_project AND FIND_IN_SET(t.blok,spk_infra_detail.blok)
                LEFT JOIN rsp_project_live.t_infrastruktur spk_infra ON spk_infra_detail.id_inf = spk_infra.id_inf
                LEFT JOIN rsp_project_live.m_vendor ven_infra ON ven.id_vendor = spk_infra.vendor
                LEFT JOIN rsp_project_live.m_project m_project ON m_project.id_project = t.id_project
                WHERE 
                  LEFT(t.created_at,7) = '$periode' 
                  AND t.id_category = '10' 
                  $kondisi
                  AND t.`status` = 6
                GROUP BY t.id_task ORDER BY t.created_at DESC
) afs_web";
        return $this->db->query($query)->row_array();
    }

    function leadtime_respon_perbaikan($project, $periode) {
        $kondisi = "";
        if ($project != '0' && $project != 'all') {
            $kondisi = "AND m_project.id_project = $project";
        }
        $query = "SELECT
  COALESCE(COUNT(afs.tgl_finance),0) as target,
  100 as target_persentase,
  COALESCE(SUM(IF(afs.leadtime_pengecekan < 2, 1,0)),0) as actual,
  COALESCE(ROUND((COALESCE(SUM(IF(afs.leadtime_pengecekan < 2, 1,0)),0) / COALESCE(COUNT(afs.tgl_finance),0)) * 100),0) as achieve_persentase
FROM
  (
    SELECT
      COALESCE(m_project.project, '') AS project,
      COALESCE(m_project_unit.blok, '') AS blok,
      t_after_sales.tgl_komplain,
      SUBSTR(t_after_sales.tgl_perbaikan, 1, 10) AS tgl_perbaikan,
      COALESCE(`user`.employee_name, m_konsumen.nama_konsumen) AS USER,
      t_after_sales.status_perbaikan,
      COALESCE(m_status_stok.perbaikan, '') AS perbaikan,
      m_status.id_status AS id_acc_reject,
      m_status.aftersales AS acc_reject,
      ms.id_status AS id_status_takeover,
      IF(ms.id_status = 4, 'Verifikasi SM', ms.takeover) AS status_takeover,
      t_after_sales.ket_acc_reject,
      SUBSTR(t_after_sales.tgl_pengecekan, 1, 10) AS tgl_pengecekan,
      DATEDIFF(t_after_sales.tgl_pengecekan, t_after_sales.tgl_komplain) AS leadtime_pengecekan,
      DATEDIFF(t_after_sales.tgl_perbaikan, t_after_sales.tgl_pengecekan) AS leadtime_perbaikan,
      t_after_sales.leadtime,
      DATEDIFF(COALESCE(DATE(inter.finance_at), DATE(t_after_sales.tgl_perbaikan)), t_after_sales.tgl_pengecekan) AS leadtime_vendor,
      DATEDIFF(COALESCE(DATE(inter.finance_at), DATE(t_after_sales.tgl_perbaikan)), DATE(inter.created_at)) AS leadtime_takeover,
      COALESCE(
        t_after_sales.tgl_deadline,
        DATE(t_after_sales.tgl_pengecekan) + INTERVAL(t_after_sales.leadtime) DAY + INTERVAL(
          SELECT
            COUNT(tgl) AS jumlah
          FROM
            rsp_project_live.view_tanggal_merah
          WHERE
            tgl BETWEEN DATE(t_after_sales.tgl_pengecekan)
            AND (
              DATE(t_after_sales.tgl_pengecekan) + INTERVAL(t_after_sales.leadtime) DAY + INTERVAL(
                SELECT
                  COUNT(tgl) AS jumlah
                FROM
                  rsp_project_live.view_tanggal_merah
                WHERE
                  tgl BETWEEN DATE(t_after_sales.tgl_pengecekan)
                  AND (DATE(t_after_sales.tgl_pengecekan) + INTERVAL(t_after_sales.leadtime) DAY)
              ) DAY
            )
        ) DAY
      ) AS tgl_deadline,
      (
        DATE(t_after_sales.tgl_pengecekan) + INTERVAL(t_after_sales.leadtime) DAY + INTERVAL(
          SELECT
            COUNT(tgl) AS jumlah
          FROM
            rsp_project_live.view_tanggal_merah
          WHERE
            tgl BETWEEN DATE(t_after_sales.tgl_pengecekan)
            AND (
              DATE(t_after_sales.tgl_pengecekan) + INTERVAL(t_after_sales.leadtime) DAY + INTERVAL(
                SELECT
                  COUNT(tgl) AS jumlah
                FROM
                  rsp_project_live.view_tanggal_merah
                WHERE
                  tgl BETWEEN DATE(t_after_sales.tgl_pengecekan)
                  AND (DATE(t_after_sales.tgl_pengecekan) + INTERVAL(t_after_sales.leadtime) DAY)
              ) DAY
            )
        ) DAY
      ) AS tgl_deadline_vendor,
      IF(
        t_after_sales.status_perbaikan = 3,
        IF(
          inter.id IS NOT NULL
          AND inter.STATUS != 5,
          IF(
            DATE(t_after_sales.tgl_perbaikan) > DATE(inter.finance_at),
            DATE(t_after_sales.tgl_perbaikan),
            DATE(inter.finance_at)
          ),
          DATE(t_after_sales.tgl_perbaikan)
        ),
        ''
      ) AS tgl_finance,
      COALESCE(t_after_sales.feedback_rating, '') AS rating,
      COALESCE(t_after_sales.feedback_notes, '') AS rating_note,
      t_after_sales.feedback_kualitas AS rating_kualitas,
      t_after_sales.feedback_design AS rating_design,
      t_after_sales.feedback_pekerjaan AS rating_pekerjaan,
      COALESCE(t_after_sales.f_afs_respon, '') AS f_afs_respon,
      ROUND(
        (COALESCE(t_after_sales.f_afs_respon, 0) + COALESCE(t_after_sales.f_afs_pelayanan, 0) + COALESCE(t_after_sales.f_afs_kualitas, 0)) / 3
      ) AS rating_afs,
      COALESCE(inter.id, '') AS id_internal,
      COALESCE(t_after_sales.tgl_pengerjaan, '') AS tgl_pengerjaan,
      DATEDIFF(DATE(t_after_sales.tgl_pengecekan), DATE(t_after_sales.tgl_komplain)) AS leadtime_approve,
      DATE(inter.created_at) AS tgl_take_over,
      inter.finance_at,
      IF(inter.finance_at IS NOT NULL AND inter.STATUS != 5, inter.finance_at, NULL) AS tgl_verif_takeover,
      (
        IF(
          inter.finance_at IS NOT NULL
          AND inter.STATUS != 5,
          (
            (
              inter.finance_at + INTERVAL(
                CASE
                  WHEN t_after_sales.leadtime = 7 THEN
                    2
                  WHEN t_after_sales.leadtime = 15 THEN
                    3
                  WHEN t_after_sales.leadtime = 21 THEN
                    6
                  ELSE
                    0
                END
              ) DAY
            ) + INTERVAL(t_after_sales.leadtime) DAY
          ),
          0
        ) - INTERVAL(
          CASE
            WHEN t_after_sales.leadtime = 7 THEN
              2
            WHEN t_after_sales.leadtime = 15 THEN
              3
            WHEN t_after_sales.leadtime = 21 THEN
              6
            ELSE
              0
          END
        ) DAY
      ) AS tgl_pengerjaan_takeover,
      IF(
        inter.finance_at IS NOT NULL
        AND inter.STATUS != 5,
        (inter.finance_at + INTERVAL(t_after_sales.leadtime) DAY),
        NULL
      ) AS tgl_deadline_takeover,
      t_after_sales.created_at AS tgl_created
    FROM
      rsp_project_live.t_after_sales
      LEFT JOIN rsp_project_live.t_after_sales_internal AS inter ON inter.id_after_sales = t_after_sales.id_after_sales
      LEFT JOIN rsp_project_live.m_project_unit ON t_after_sales.id_project_unit = m_project_unit.id_project_unit
      LEFT JOIN (
        SELECT
          *
        FROM
          rsp_project_live.m_project
          LEFT JOIN (SELECT id_user AS id_sm, employee_name AS sm FROM rsp_project_live.`user`) u ON u.id_sm = m_project.sm_approve
          LEFT JOIN (SELECT id_user AS id_pm, employee_name AS pm FROM rsp_project_live.`user`) u1 ON u1.id_pm = m_project.pm_housing
      ) m_project ON m_project_unit.id_project = m_project.id_project
      LEFT JOIN rsp_project_live.m_status_stok ON t_after_sales.status_perbaikan = m_status_stok.`status` 
      LEFT JOIN rsp_project_live.`user` ON t_after_sales.created_by = `user`.`id_user`
      LEFT JOIN rsp_project_live.m_konsumen ON m_konsumen.id_konsumen = t_after_sales.id_konsumen
      LEFT JOIN rsp_project_live.m_status ON m_status.id_status = t_after_sales.acc_reject
      LEFT JOIN rsp_project_live.m_status ms ON ms.id_status = inter.`status`
    WHERE
      LEFT(t_after_sales.created_at, 7) = '$periode'
      $kondisi
      -- AND t_after_sales.status_perbaikan = 3
      AND t_after_sales.level_kerusakan = 3
      AND t_after_sales.acc_reject = 1
      -- AND t_after_sales.id_konsumen IS NOT NULL
      -- AND t_after_sales.marketing IS NULL
    GROUP BY
      t_after_sales.id_after_sales
  ) afs";
        return $this->db->query($query)->row_array();
    }

}