<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_api_qc extends CI_Model
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
        if ($project == '0') {
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
//   'Product Unit Complaint Rate' as corporate_kpi,
//   COALESCE(COUNT(t_akad.id_akad), 0) as target,
//   5 as target_persentase,
//   IF(ROUND(( SUM(IF(t.id_category IN(2,3,10), 1, 0)) / COUNT(t_akad.id_akad) ) * 100, 1) > 100, 100, ROUND(( SUM(IF(t.id_category IN(2,3,10), 1, 0)) / COUNT(t_akad.id_akad) ) * 100, 1)) as actual,
//   IF(ROUND(( 5 / ROUND(( SUM(IF(t.id_category IN(2,3,10), 1, 0)) / COUNT(t_akad.id_akad) ) * 100, 1) ) * 100, 1) > 100, 100, ROUND(( 5 / ROUND(( SUM(IF(t.id_category IN(2,3,10), 1, 0)) / COUNT(t_akad.id_akad) ) * 100, 1) ) * 100, 1)) AS achieve_persentase
// FROM
//   rsp_project_live.t_akad
//   LEFT JOIN rsp_project_live.t_gci ON t_gci.id_konsumen = t_akad.id_konsumen
//   LEFT JOIN hris.`cm_task` t ON t.id_project = t_gci.id_project AND t.blok = t_gci.blok AND DATE(t.created_at) >= CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
//   LEFT JOIN hris.cm_rating r ON r.id_task = t.id_task
//   LEFT JOIN hris.cm_category c ON c.id = t.id_category
// WHERE 
//   t_akad.jadwal_akad BETWEEN CAST(DATE_FORMAT('$periode-01' - INTERVAL 1 MONTH, '%Y-%m-01') AS DATE)
//   AND LAST_DAY('$periode-01')";
        
        $query = "SELECT
        'Product Unit Complaint Rate' as corporate_kpi,
        MAX(CASE WHEN week = (SELECT MAX(week) FROM (
       SELECT @a2 := @a2 + 1 AS week
       FROM hris.all_dates, (SELECT @a2 := 0) v
       WHERE `date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
       AND LAST_DAY('$periode-01')
       AND DAYNAME(`date`) = 'Sunday'
   ) w ) THEN target END)  AS target,

      5 as target_persentase,

   MAX(CASE WHEN week = (SELECT MAX(week) FROM (
       SELECT @a3 := @a3 + 1 AS week
       FROM hris.all_dates, (SELECT @a3 := 0) v
       WHERE `date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
       AND LAST_DAY('$periode-01')
       AND DAYNAME(`date`) = 'Sunday'
   ) w ) THEN aktual END)  AS actual,

   IF(
          ROUND( 5 / (MAX(CASE WHEN week = (SELECT MAX(week) FROM (
                 SELECT @a4 := @a4 + 1 AS week
                 FROM hris.all_dates, (SELECT @a4 := 0) v
                 WHERE `date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
                   AND LAST_DAY('$periode-01')
                   AND DAYNAME(`date`) = 'Sunday'
             ) w ) THEN actual END) ) * 100, 1 ) 
        > 100, 
        100, 
          ROUND( 5 / (MAX(CASE WHEN week = (SELECT MAX(week) FROM (
               SELECT @a4 := @a4 + 1 AS week
               FROM hris.all_dates, (SELECT @a4 := 0) v
               WHERE `date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
                 AND LAST_DAY('$periode-01')
                 AND DAYNAME(`date`) = 'Sunday'
           ) w ) THEN actual END) ) * 100, 1)
        ) AS achieve_persentase
 FROM (
      SELECT
          @a := @a + 1 AS week,
          CONCAT(YEAR(NOW()), '-01-01') AS date_start,
          `date` AS date_end,
          (
            SELECT COUNT(*) FROM rsp_project_live.t_akad
        LEFT JOIN rsp_project_live.t_gci ON t_gci.id_konsumen = t_akad.id_konsumen
            WHERE t_akad.hasil_akad = 1
              AND t_akad.jadwal_akad BETWEEN date_start AND date_end
          ) AS target,
          (
            SELECT COUNT(*)
            FROM hris.`cm_task` t
            LEFT JOIN hris.cm_rating r ON r.id_task = t.id_task
            LEFT JOIN hris.cm_category c ON c.id = t.id_category
            WHERE DATE(t.created_at) BETWEEN date_start AND date_end
            AND t.id_category IN (2,3,10)
          ) AS aktual,
          ROUND((
            (
              SELECT COUNT(*)
            FROM hris.`cm_task` t
            LEFT JOIN hris.cm_rating r ON r.id_task = t.id_task
            LEFT JOIN hris.cm_category c ON c.id = t.id_category
            WHERE DATE(t.created_at) BETWEEN date_start AND date_end
            AND t.id_category IN (2,3,10)
            ) / (
              SELECT COUNT(*) FROM rsp_project_live.t_akad
        LEFT JOIN rsp_project_live.t_gci ON t_gci.id_konsumen = t_akad.id_konsumen
            WHERE t_akad.hasil_akad = 1
              AND t_akad.jadwal_akad BETWEEN date_start AND date_end
            )
          ) * 100, 1) AS actual
      FROM hris.`all_dates`, (SELECT @a := 0) vars
      WHERE
          `date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
          AND LAST_DAY('$periode-01')
          AND DAYNAME(`date`) = 'Sunday'
  ) weekly_data";


        return $this->db->query($query)->row_array();
    }

    function kpi_project($project, $periode) {
        $kondisi = "";
        $kondisi2 = "";
        if ($project != '0') {
            $kondisi = "AND t.id_project = $project";
            $kondisi2 = "AND t_gci.id_project = $project";
        }
//         $query = "SELECT
//   'Product Unit Complaint Rate' as corporate_kpi,
//   COALESCE(COUNT(t_akad.id_akad), 0) as target,
//   5 as target_persentase,
//   IF(ROUND(( SUM(IF(t.id_category IN(2,3,10), 1, 0)) / COUNT(t_akad.id_akad) ) * 100, 1) > 100, 100, ROUND(( SUM(IF(t.id_category IN(2,3,10), 1, 0)) / COUNT(t_akad.id_akad) ) * 100, 1)) as actual,
//   IF(ROUND(( 5 / ROUND(( SUM(IF(t.id_category IN(2,3,10), 1, 0)) / COUNT(t_akad.id_akad) ) * 100, 1) ) * 100, 1) > 100, 100, ROUND(( 5 / ROUND(( SUM(IF(t.id_category IN(2,3,10), 1, 0)) / COUNT(t_akad.id_akad) ) * 100, 1) ) * 100, 1)) AS achieve_persentase
// FROM
//   rsp_project_live.t_akad
//   LEFT JOIN rsp_project_live.t_gci ON t_gci.id_konsumen = t_akad.id_konsumen
//   LEFT JOIN hris.`cm_task` t ON t.id_project = t_gci.id_project AND t.blok = t_gci.blok AND DATE(t.created_at) >= CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
//   LEFT JOIN hris.cm_rating r ON r.id_task = t.id_task
//   LEFT JOIN hris.cm_category c ON c.id = t.id_category
// WHERE 
//   t_akad.jadwal_akad BETWEEN CAST(DATE_FORMAT('$periode-01' - INTERVAL 1 MONTH, '%Y-%m-01') AS DATE)
//   AND LAST_DAY('$periode-01')
//   $kondisi";

        $query = "SELECT
       'Product Unit Complaint Rate' as corporate_kpi,
       MAX(CASE WHEN week = (SELECT MAX(week) FROM (
           SELECT @a2 := @a2 + 1 AS week
           FROM hris.all_dates, (SELECT @a2 := 0) v
           WHERE `date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
           AND LAST_DAY('$periode-01')
           AND DAYNAME(`date`) = 'Sunday'
       ) w ) THEN target END)  AS target,

      5 as target_persentase,

       MAX(CASE WHEN week = (SELECT MAX(week) FROM (
           SELECT @a3 := @a3 + 1 AS week
           FROM hris.all_dates, (SELECT @a3 := 0) v
           WHERE `date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
           AND LAST_DAY('$periode-01')
           AND DAYNAME(`date`) = 'Sunday'
       ) w ) THEN aktual END)  AS actual,
   
       IF(
          ROUND( 5 / (MAX(CASE WHEN week = (SELECT MAX(week) FROM (
                 SELECT @a4 := @a4 + 1 AS week
                 FROM hris.all_dates, (SELECT @a4 := 0) v
                 WHERE `date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
                   AND LAST_DAY('$periode-01')
                   AND DAYNAME(`date`) = 'Sunday'
             ) w ) THEN actual END) ) * 100, 1 ) 
        > 100, 
        100, 
          ROUND( 5 / (MAX(CASE WHEN week = (SELECT MAX(week) FROM (
               SELECT @a4 := @a4 + 1 AS week
               FROM hris.all_dates, (SELECT @a4 := 0) v
               WHERE `date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
                 AND LAST_DAY('$periode-01')
                 AND DAYNAME(`date`) = 'Sunday'
           ) w ) THEN actual END) ) * 100, 1)
        ) AS achieve_persentase
 FROM (
      SELECT
      @a := @a + 1 AS WEEK,
      CONCAT(YEAR(NOW()), '-01-01') AS date_start,
      `date` AS date_end,
      (
        SELECT
          COUNT(*)
        FROM
          rsp_project_live.t_akad
          LEFT JOIN rsp_project_live.t_gci ON t_gci.id_konsumen = t_akad.id_konsumen
        WHERE
          t_akad.hasil_akad = 1
          AND t_akad.jadwal_akad BETWEEN date_start
          AND date_end
          $kondisi2
      ) AS target,
      (
        SELECT
          COUNT(*)
        FROM
          hris.`cm_task` t
          LEFT JOIN hris.cm_rating r ON r.id_task = t.id_task
          LEFT JOIN hris.cm_category c ON c.id = t.id_category
        WHERE
          DATE(t.created_at) BETWEEN date_start
          AND date_end
          AND t.id_category IN (2, 3, 10)
          $kondisi
      ) AS aktual,
      ROUND(
        (
          (
            SELECT
              COUNT(*)
            FROM
              hris.`cm_task` t
              LEFT JOIN hris.cm_rating r ON r.id_task = t.id_task
              LEFT JOIN hris.cm_category c ON c.id = t.id_category
            WHERE
              DATE(t.created_at) BETWEEN date_start
              AND date_end
              AND t.id_category IN (2, 3, 10)
              $kondisi
          ) / (
            SELECT
              COUNT(*)
            FROM
              rsp_project_live.t_akad
              LEFT JOIN rsp_project_live.t_gci ON t_gci.id_konsumen = t_akad.id_konsumen
            WHERE
              t_akad.hasil_akad = 1
              AND t_akad.jadwal_akad BETWEEN date_start
              AND date_end
              $kondisi2
          )
        ) * 100,
        1
      ) AS actual
      FROM hris.`all_dates`, (SELECT @a := 0) vars
      WHERE
          `date` BETWEEN CAST(DATE_FORMAT('$periode-01', '%Y-%m-01') AS DATE)
          AND LAST_DAY('$periode-01')
          AND DAYNAME(`date`) = 'Sunday'
  ) weekly_data";
  
        return $this->db->query($query)->row_array();
    }

    function leadtime_qc($project, $periode) {
        $kondisi = "";
        if ($project != '0') {
            $kondisi = "AND data_final.id_project = $project";
        }
        $query = "SELECT
  COALESCE(COUNT(*), 0) as target,
  COALESCE(SUM(CASE WHEN status_kesiapan_unit_qc_pass = 'SUDAH QC PASS' THEN 1 ELSE 0 END), 0) as actual,
  IF(ROUND((SUM(CASE WHEN status_kesiapan_unit_qc_pass = 'SUDAH QC PASS' THEN 1 ELSE 0 END) / COUNT(*)) * 100) > 100, 100, ROUND((SUM(CASE WHEN status_kesiapan_unit_qc_pass = 'SUDAH QC PASS' THEN 1 ELSE 0 END) / COUNT(*)) * 100)) AS achieve_persentase
FROM
  (WITH data_unit_progres AS (
				SELECT
					*,
					GREATEST(
					CAST(REPLACE(COALESCE(progres, 0), ',', '.') AS DECIMAL (5, 2)),
					CAST(REPLACE(COALESCE(progres_pelaksana, 0), ',', '.') AS DECIMAL (5, 2))
					) AS max_progres
				FROM
					rsp_project_live.m_project_unit
				),
				data_spk AS (SELECT id_project, blok, tgl_spk_akhir FROM rsp_project_live.t_project_bangun_detail),
				data_opname AS (SELECT project, blok, DATE(MAX(created_at)) AS tgl_opname FROM rsp_project_live.t_pengawasan WHERE approve = 2 GROUP BY project, blok),
				data_booking AS (
				SELECT
					gci.id_project,
					gci.blok,
					MAX(inter.tgl_sp3k) AS tgl_sp3k
				FROM
					rsp_project_live.t_gci AS gci
					LEFT JOIN rsp_project_live.t_interview AS inter ON gci.id_gci = inter.id_gci
				GROUP BY
					gci.id_project,
					gci.blok
				),
				data_kunci AS (
				SELECT
					tsk.id_project,
					tsk.blok,
					msk.lokasi
				FROM
					rsp_project_live.t_status_kunci AS tsk
					JOIN rsp_project_live.m_status_kunci AS msk ON msk.id = tsk.STATUS
				),
				data_after_sales AS (SELECT tas.id_project_unit FROM rsp_project_live.t_after_sales AS tas WHERE tas.status_perbaikan IS NOT NULL AND tas.status_perbaikan <> ''),
				data_final AS (
				SELECT
					mpu.id_project,
					mpu.blok,
					mpu.max_progres,
					qc.created_at AS tgl_visit_qc_pass,
					CASE
					WHEN qc.`status` IN (1, 2, 3, 4, 5) THEN
						'SUDAH QC PASS'
					WHEN mpu.max_progres < 100 THEN
						'BELUM 100%'
					WHEN kunci.lokasi = 'Di Konsumen' THEN
						'KUNCI DI KONSUMEN'
					WHEN afs.id_project_unit IS NOT NULL THEN
						'SUDAH MASUK AFTERSALES'
					WHEN mpu.tgl_pelaksana IS NULL
						OR opname.tgl_opname IS NULL
						OR spk.tgl_spk_akhir IS NULL
						OR booking.tgl_sp3k IS NULL
						OR booking.tgl_sp3k = '0000-00-00' THEN
						'DATA TANGGAL TIDAK LENGKAP'
					ELSE
						'SIAP QC PASS'
					END AS status_kesiapan_unit_qc_pass,
					CASE
					WHEN qc.STATUS IS NULL
						AND mpu.max_progres >= 100
						AND (kunci.lokasi <> 'Di Konsumen' OR kunci.lokasi IS NULL)
						AND afs.id_project_unit IS NULL
						AND mpu.tgl_pelaksana IS NOT NULL
						AND opname.tgl_opname IS NOT NULL
						AND spk.tgl_spk_akhir IS NOT NULL
						AND booking.tgl_sp3k IS NOT NULL
						AND booking.tgl_sp3k <> '0000-00-00' THEN
						DATE_FORMAT(
						DATE_ADD(
							GREATEST(
							COALESCE(mpu.tgl_pelaksana, '1900-01-01'),
							COALESCE(opname.tgl_opname, '1900-01-01'),
							COALESCE(booking.tgl_sp3k, '1900-01-01'),
							COALESCE(spk.tgl_spk_akhir, '1900-01-01')
							),
							INTERVAL 4 DAY
						),
						'%Y-%m-%d'
						)
					ELSE
						NULL
					END AS tgl_target_qc_pass
				FROM
					data_unit_progres AS mpu
					JOIN rsp_project_live.m_project ON m_project.id_project = mpu.id_project
					JOIN rsp_project_live.m_project_tipe ON m_project_tipe.id_project_tipe = mpu.project_tipe
					LEFT JOIN rsp_project_live.t_task_qc AS qc ON qc.project = mpu.id_project
					AND qc.blok = mpu.blok
					LEFT JOIN data_spk AS spk ON spk.id_project = mpu.id_project
					AND spk.blok = mpu.blok
					LEFT JOIN data_opname AS opname ON opname.project = mpu.id_project
					AND opname.blok = mpu.blok
					LEFT JOIN data_booking AS booking ON booking.id_project = mpu.id_project
					AND booking.blok = mpu.blok
					LEFT JOIN data_kunci AS kunci ON kunci.id_project = mpu.id_project
					AND kunci.blok = mpu.blok
					LEFT JOIN data_after_sales AS afs ON afs.id_project_unit = mpu.id_project_unit
				GROUP BY
					mpu.id_project_unit
				) SELECT
				*,
				 (
				WEEK(COALESCE(tgl_visit_qc_pass, tgl_target_qc_pass), 0)
				- WEEK(DATE_SUB(COALESCE(tgl_visit_qc_pass, tgl_target_qc_pass), INTERVAL DAYOFMONTH(COALESCE(tgl_visit_qc_pass, tgl_target_qc_pass))-1 DAY), 0)
				+ 1
				) AS week_of_month
				FROM
				data_final
				WHERE
				COALESCE(tgl_visit_qc_pass, tgl_target_qc_pass) IS NOT NULL
				AND DATE_FORMAT(COALESCE(tgl_visit_qc_pass, tgl_target_qc_pass), '%Y-%m') = '$periode'
                $kondisi
			) AS base_query_qc";
        return $this->db->query($query)->row_array();
    }

    function jumlah_temuan_qc($project, $periode) {
        $kondisi = "";
        if ($project != '0') {
            $kondisi = "AND t_task_qc.project = $project";
        }
        $query = "SELECT
  COUNT(t_ceklis_qc.ceklis) as target,
  100 as target_persentase,
  COALESCE(SUM(IF(t_ceklis_qc.`status` = 1,1,0)),0) as temuan_sesuai,
  COALESCE(
    ROUND((COALESCE(SUM(IF(t_ceklis_qc.`status` = 1,1,0)),0) / COUNT(t_ceklis_qc.ceklis)) * 100)
  ,0) persentase_temuan_sesuai,
  COALESCE(SUM(IF(t_ceklis_qc.`status` = 2,1,0)),0) as temuan_tidak_sesuai,
  COALESCE(
    ROUND((COALESCE(SUM(IF(t_ceklis_qc.`status` = 2,1,0)),0) / COUNT(t_ceklis_qc.ceklis)) * 100)
  ,0) persentase_temuan_tidak_sesuai
FROM
  rsp_project_live.m_ceklis_qc
  LEFT JOIN rsp_project_live.t_ceklis_qc ON m_ceklis_qc.id_ceklis = t_ceklis_qc.ceklis
  LEFT JOIN rsp_project_live.t_task_qc ON t_ceklis_qc.project = t_task_qc.project AND t_ceklis_qc.blok = t_task_qc.blok
WHERE
  LEFT(t_ceklis_qc.created_at, 7) = '$periode'
  $kondisi
  AND t_task_qc.is_progres IS NULL";
        return $this->db->query($query)->row_array();
    }

//     function leadtime_perbaikan_qc($project, $periode) {
//         $query = "SELECT
//   COALESCE(COUNT(t_task_qc.id_task),0) as target,
//   COALESCE(SUM(IF(DATEDIFF(pel.act_selesai_perbaikan,pel.plan_selesai_perbaikan) < 1,1,0)),0) as actual,
//   COALESCE(ROUND( (SUM(IF(DATEDIFF(pel.act_selesai_perbaikan,pel.plan_selesai_perbaikan) < 1,1,0)) / COUNT(t_task_qc.id_task)) * 100 ),0) as achieve_persentase
// FROM
//   rsp_project_live.t_task_qc
//   LEFT JOIN rsp_project_live.t_task_rumah_qc pel ON pel.id_task_qc = t_task_qc.id_task 
// WHERE
//   LEFT(t_task_qc.created_at, 7) = '$periode'
//   AND t_task_qc.project = $project
//   AND t_task_qc.is_progres IS NULL";
//         return $this->db->query($query)->row_array();
//     }

    function qc_vs_aftersales($project, $periode) {
        $kondisi = "";
        if ($project != '0') {
            $kondisi = "AND m_project_unit.id_project = $project";
        }
//         $periode_before = date('Y-m', strtotime('-1 month', strtotime($periode.'-01')));
//         $query = "SELECT
//   COALESCE(COUNT(t_task_qc.id_task), 0) AS target,
//   COALESCE(
//     (
//       SELECT
//         COUNT(*)
//       FROM
//         rsp_project_live.t_after_sales
//         LEFT JOIN rsp_project_live.m_project_unit ON m_project_unit.id_project_unit = t_after_sales.id_project_unit
//       WHERE
//         LEFT(t_after_sales.tgl_komplain, 7) = '$periode'
//         AND t_after_sales.acc_reject = 1
//         $kondisi
//     ),
//     0
//   ) AS actual,
//   COALESCE(
//     ROUND(
//       (
//         (
//           SELECT
//             COUNT(*)
//           FROM
//             rsp_project_live.t_after_sales
//             LEFT JOIN rsp_project_live.m_project_unit ON m_project_unit.id_project_unit = t_after_sales.id_project_unit
//           WHERE
//             LEFT(t_after_sales.tgl_komplain, 7) = '$periode'
//             AND t_after_sales.acc_reject = 1
//             $kondisi
//         ) / COUNT(t_task_qc.id_task)
//       ) * 100
//     ), 0
//   ) achieve_persentase
// FROM
//   rsp_project_live.t_task_qc
//   LEFT JOIN rsp_project_live.t_task_rumah_qc pel ON pel.id_task_qc = t_task_qc.id_task
// WHERE
//   LEFT(t_task_qc.created_at, 7) = '$periode_before'
//   $kondisi2
//   AND t_task_qc.is_progres IS NULL";
        
        $query = "WITH qc as (
  SELECT
     t_task_qc.*
  FROM
    rsp_project_live.t_task_qc
    LEFT JOIN rsp_project_live.t_task_rumah_qc pel ON pel.id_task_qc = t_task_qc.id_task
  WHERE
    YEAR(t_task_qc.created_at) = YEAR('$periode-01')
    AND t_task_qc.is_progres IS NULL
)SELECT
  COALESCE(COUNT(t_after_sales.id_after_sales), 0) AS target,
  COALESCE(COUNT(qc.id_task), 0) as actual,
  COALESCE(ROUND( (COALESCE(COUNT(qc.id_task), 0) / COALESCE(COUNT(t_after_sales.id_after_sales), 0)) * 100), 0) as achieve_persentase
FROM
  rsp_project_live.t_after_sales
  LEFT JOIN rsp_project_live.m_project_unit ON m_project_unit.id_project_unit = t_after_sales.id_project_unit
  LEFT JOIN qc ON qc.project = m_project_unit.id_project and qc.blok = m_project_unit.blok
WHERE
  LEFT(t_after_sales.tgl_komplain, 7) = '$periode'
  AND t_after_sales.acc_reject = 1
  AND t_after_sales.level_kerusakan = 3
  $kondisi";

        return $this->db->query($query)->row_array();
    }

    function temuan_berulang($project, $periode) {
        $kondisi = "";
        $kondisi2 = "";
        if ($project != '0') {
            $kondisi = "AND qc.project = $project";
            $kondisi2 = "AND t_task_qc.project = $project";
        }
        $query = "SELECT
  COALESCE(COUNT(t_ceklis_qc.ceklis),0) as target,
  COALESCE((SELECT
  COUNT(temuan_berulang.total)
FROM
(SELECT
  COUNT(qc.ceklis) AS total,
  spk.id_vendor,
  COALESCE(ck.pekerjaan, ckn.pekerjaan) AS area
FROM
  rsp_project_live.t_ceklis_qc AS qc
  JOIN (
    SELECT
      spk.vendor AS id_vendor,
      det.id_project,
      det.blok
    FROM
      rsp_project_live.t_project_bangun AS spk
      JOIN rsp_project_live.t_project_bangun_detail AS det ON det.id_rencana = spk.id_rencana
  ) AS spk ON spk.id_project = qc.project
  AND spk.blok = qc.blok
  LEFT JOIN rsp_project_live.m_ceklis_qc AS ck ON ck.id_ceklis = qc.ceklis
  LEFT JOIN rsp_project_live.m_ceklis_qc_new AS ckn ON ckn.id_ceklis = qc.ceklis
WHERE
  qc.`status` = 2
  AND qc.created_by <> 1
  $kondisi
  AND LEFT(qc.created_at, 7) = '$periode'
GROUP BY
  COALESCE(ck.pekerjaan, ckn.pekerjaan),
  spk.id_vendor
  ) temuan_berulang),0) as actual,
  
  COALESCE(ROUND( (COALESCE((SELECT
  COUNT(temuan_berulang.total)
FROM
(SELECT
  COUNT(qc.ceklis) AS total,
  spk.id_vendor,
  COALESCE(ck.pekerjaan, ckn.pekerjaan) AS area
FROM
  rsp_project_live.t_ceklis_qc AS qc
  JOIN (
    SELECT
      spk.vendor AS id_vendor,
      det.id_project,
      det.blok
    FROM
      rsp_project_live.t_project_bangun AS spk
      JOIN rsp_project_live.t_project_bangun_detail AS det ON det.id_rencana = spk.id_rencana
  ) AS spk ON spk.id_project = qc.project
  AND spk.blok = qc.blok
  LEFT JOIN rsp_project_live.m_ceklis_qc AS ck ON ck.id_ceklis = qc.ceklis
  LEFT JOIN rsp_project_live.m_ceklis_qc_new AS ckn ON ckn.id_ceklis = qc.ceklis
WHERE
  qc.`status` = 2
  AND qc.created_by <> 1
  $kondisi
  AND LEFT(qc.created_at, 7) = '$periode'
GROUP BY
  COALESCE(ck.pekerjaan, ckn.pekerjaan),
  spk.id_vendor
  ) temuan_berulang),0) / COALESCE(COUNT(t_ceklis_qc.ceklis),0)) * 100 ),0) as achieve_persentase
FROM
  rsp_project_live.m_ceklis_qc
  LEFT JOIN rsp_project_live.t_ceklis_qc ON m_ceklis_qc.id_ceklis = t_ceklis_qc.ceklis
  LEFT JOIN rsp_project_live.t_task_qc ON t_ceklis_qc.project = t_task_qc.project AND t_ceklis_qc.blok = t_task_qc.blok
WHERE
  LEFT(t_ceklis_qc.created_at, 7) = '$periode'
  $kondisi2
  AND t_task_qc.is_progres IS NULL
  AND t_ceklis_qc.`status` = 2
  AND t_ceklis_qc.created_by <> 1
  ";
        return $this->db->query($query)->row_array();
    }

    function vendor_temuan_berulang($project, $periode) {
        $kondisi = "";
        $kondisi2 = "";
        if ($project != '0') {
            $kondisi = "AND qc.project = $project";
            $kondisi2 = "WHERE t_project_bangun_detail.id_project = $project";
        }
        $query = "SELECT
  COALESCE(COUNT(all_vendor_project.vendor),0) as target,
  COALESCE((SELECT
  COUNT(vendor_berulang.id_vendor)
FROM
(
SELECT
  temuan_berulang.id_vendor
FROM
(SELECT
  COUNT(qc.ceklis) AS total,
  spk.id_vendor,
  COALESCE(ck.pekerjaan, ckn.pekerjaan) AS area
FROM
  rsp_project_live.t_ceklis_qc AS qc
  JOIN (
    SELECT
      spk.vendor AS id_vendor,
      det.id_project,
      det.blok
    FROM
      rsp_project_live.t_project_bangun AS spk
      JOIN rsp_project_live.t_project_bangun_detail AS det ON det.id_rencana = spk.id_rencana
  ) AS spk ON spk.id_project = qc.project
  AND spk.blok = qc.blok
  LEFT JOIN rsp_project_live.m_ceklis_qc AS ck ON ck.id_ceklis = qc.ceklis
  LEFT JOIN rsp_project_live.m_ceklis_qc_new AS ckn ON ckn.id_ceklis = qc.ceklis
WHERE
  qc.`status` = 2
  AND qc.created_by <> 1
  $kondisi
  AND LEFT(qc.created_at, 7) = '$periode'
GROUP BY
  spk.id_vendor
  ) temuan_berulang
GROUP BY
  temuan_berulang.id_vendor
) vendor_berulang),0) as actual,
COALESCE(ROUND((COALESCE((SELECT
  COUNT(vendor_berulang.id_vendor)
FROM
(
SELECT
  temuan_berulang.id_vendor
FROM
(SELECT
  COUNT(qc.ceklis) AS total,
  spk.id_vendor,
  COALESCE(ck.pekerjaan, ckn.pekerjaan) AS area
FROM
  rsp_project_live.t_ceklis_qc AS qc
  JOIN (
    SELECT
      spk.vendor AS id_vendor,
      det.id_project,
      det.blok
    FROM
      rsp_project_live.t_project_bangun AS spk
      JOIN rsp_project_live.t_project_bangun_detail AS det ON det.id_rencana = spk.id_rencana
  ) AS spk ON spk.id_project = qc.project
  AND spk.blok = qc.blok
  LEFT JOIN rsp_project_live.m_ceklis_qc AS ck ON ck.id_ceklis = qc.ceklis
  LEFT JOIN rsp_project_live.m_ceklis_qc_new AS ckn ON ckn.id_ceklis = qc.ceklis
WHERE
  qc.`status` = 2
  AND qc.created_by <> 1
  $kondisi
  AND LEFT(qc.created_at, 7) = '$periode'
GROUP BY
  spk.id_vendor
  ) temuan_berulang
GROUP BY
  temuan_berulang.id_vendor
) vendor_berulang),0) / COALESCE(COUNT(all_vendor_project.vendor),0)) * 100),0) as achieve_persentase
FROM
(
SELECT 
  t_project_bangun.vendor
FROM
  rsp_project_live.t_project_bangun_detail
  JOIN rsp_project_live.t_project_bangun ON t_project_bangun.id_rencana = t_project_bangun_detail.id_rencana
$kondisi2
GROUP BY t_project_bangun.vendor
) all_vendor_project";
        return $this->db->query($query)->row_array();
    }
}