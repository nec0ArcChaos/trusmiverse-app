<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_api_plan_housing extends CI_Model
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
		'On-Time Contruction Rate (OTCR) Ketepatan waktu penyelesaian konstruksi (Housing)' AS corporate_kpi,
		COUNT(unit.blok) AS target,
    100 AS target_persentase,
		COALESCE(COALESCE(COUNT(IF(DATE(unit.tgl_pelaksana) <= COALESCE(DATE_ADD(spk_detail.tgl_spk_akhir,INTERVAL t_peringatan_vendor.tambahan_waktu DAY), DATE(spk_detail.tgl_spk_akhir)) , 1, NULL))) ,0) AS actual,
		ROUND( COALESCE(COALESCE(COUNT(IF(DATE(unit.tgl_pelaksana) <= COALESCE(DATE_ADD(spk_detail.tgl_spk_akhir,INTERVAL t_peringatan_vendor.tambahan_waktu DAY), DATE(spk_detail.tgl_spk_akhir)) , 1, NULL))) ,0) / COUNT(unit.blok) * 100, 1 ) AS achieve_persentase,
    CONCAT('Data : ', COALESCE(COALESCE(COUNT(IF(DATE(unit.tgl_pelaksana) <= COALESCE(DATE_ADD(spk_detail.tgl_spk_akhir,INTERVAL t_peringatan_vendor.tambahan_waktu DAY), DATE(spk_detail.tgl_spk_akhir)) , 1, NULL))) ,0) , '/' , COUNT(unit.blok) , ' (' , ROUND( COALESCE(COALESCE(COUNT(IF(DATE(unit.tgl_pelaksana) <= COALESCE(DATE_ADD(spk_detail.tgl_spk_akhir,INTERVAL t_peringatan_vendor.tambahan_waktu DAY), DATE(spk_detail.tgl_spk_akhir)) , 1, NULL))) ,0) / COUNT(unit.blok) * 100, 1 ) , '%)' ) as data_text
	FROM
		rsp_project_live.m_project_unit unit 
		LEFT JOIN rsp_project_live.t_project_bangun_detail spk_detail ON spk_detail.id_project = unit.id_project AND spk_detail.blok = unit.blok
		LEFT JOIN rsp_project_live.m_project pr ON pr.id_project = unit.id_project
    LEFT JOIN rsp_project_live.t_project_bangun spk ON spk_detail.id_rencana = spk.id_rencana
    LEFT JOIN (
        SELECT
            peringatan_vendor.status,
            peringatan_vendor.id_rencana,
            peringatan_vendor.project,
            unit.blok,
            SUM(peringatan_vendor.tambahan_waktu) AS tambahan_waktu 
        FROM
           rsp_project_live.t_peringatan_vendor peringatan_vendor
        JOIN rsp_project_live.m_project_unit unit ON (unit.id_project = peringatan_vendor.project AND FIND_IN_SET(unit.blok,peringatan_vendor.blok))
        WHERE peringatan_vendor.`status` IN (4,8)
        GROUP BY unit.blok,unit.id_project
    ) t_peringatan_vendor ON t_peringatan_vendor.project = unit.id_project AND t_peringatan_vendor.blok = unit.blok
	WHERE
    LEFT(spk_detail.tgl_spk_akhir, 7) = '$periode'";
        return $this->db->query($query)->row_array();
    }

    function kpi_project($project, $periode) {
        $query = "SELECT
  'On-Time Contruction Rate (OTCR) Ketepatan waktu penyelesaian konstruksi (Housing)' AS corporate_kpi,
  COUNT(unit.blok) AS target,
  100 AS target_persentase,
  COALESCE(COALESCE(COUNT(IF(DATE(unit.tgl_pelaksana) <= COALESCE(DATE_ADD(spk_detail.tgl_spk_akhir,INTERVAL t_peringatan_vendor.tambahan_waktu DAY), DATE(spk_detail.tgl_spk_akhir)) , 1, NULL))) ,0) AS actual,
  ROUND( COALESCE(COALESCE(COUNT(IF(DATE(unit.tgl_pelaksana) <= COALESCE(DATE_ADD(spk_detail.tgl_spk_akhir,INTERVAL t_peringatan_vendor.tambahan_waktu DAY), DATE(spk_detail.tgl_spk_akhir)) , 1, NULL))) ,0) / COUNT(unit.blok) * 100, 1 ) AS achieve_persentase,
  CONCAT('Data : ', COALESCE(COALESCE(COUNT(IF(DATE(unit.tgl_pelaksana) <= COALESCE(DATE_ADD(spk_detail.tgl_spk_akhir,INTERVAL t_peringatan_vendor.tambahan_waktu DAY), DATE(spk_detail.tgl_spk_akhir)) , 1, NULL))) ,0) , '/' , COUNT(unit.blok) , ' (' , ROUND( COALESCE(COALESCE(COUNT(IF(DATE(unit.tgl_pelaksana) <= COALESCE(DATE_ADD(spk_detail.tgl_spk_akhir,INTERVAL t_peringatan_vendor.tambahan_waktu DAY), DATE(spk_detail.tgl_spk_akhir)) , 1, NULL))) ,0) / COUNT(unit.blok) * 100, 1 ) , '%)' ) as data_text
FROM
  rsp_project_live.m_project_unit unit 
		LEFT JOIN rsp_project_live.t_project_bangun_detail spk_detail ON spk_detail.id_project = unit.id_project AND spk_detail.blok = unit.blok
		LEFT JOIN rsp_project_live.m_project pr ON pr.id_project = unit.id_project
    LEFT JOIN rsp_project_live.t_project_bangun spk ON spk_detail.id_rencana = spk.id_rencana
    LEFT JOIN (
        SELECT
            peringatan_vendor.status,
            peringatan_vendor.id_rencana,
            peringatan_vendor.project,
            unit.blok,
            SUM(peringatan_vendor.tambahan_waktu) AS tambahan_waktu 
        FROM
           rsp_project_live.t_peringatan_vendor peringatan_vendor
        JOIN rsp_project_live.m_project_unit unit ON (unit.id_project = peringatan_vendor.project AND FIND_IN_SET(unit.blok,peringatan_vendor.blok))
        WHERE peringatan_vendor.`status` IN (4,8)
        GROUP BY unit.blok,unit.id_project
    ) t_peringatan_vendor ON t_peringatan_vendor.project = unit.id_project AND t_peringatan_vendor.blok = unit.blok
WHERE
  LEFT(spk_detail.tgl_spk_akhir, 7) = '$periode'
  AND spk_detail.id_project = $project";
        return $this->db->query($query)->row_array();
    }

    function sp3k_vs_lahan($project, $periode) {
        $query = "SELECT
  COUNT(plan_housing.id_int) AS target, 
  100 AS target_persentase, 
  COALESCE(SUM(IF(plan_housing.kesiapan_lahan = 'Siap',1,0)),0) as actual,
  ROUND((COALESCE(SUM(IF(plan_housing.kesiapan_lahan = 'Siap',1,0)),0) / COUNT(plan_housing.id_int)) * 100, 1) as achieve_persentase,
  CONCAT('Data : ', COALESCE(SUM(IF(plan_housing.kesiapan_lahan = 'Siap',1,0)),0) , '/' , COUNT(plan_housing.id_int) , ' (' , ROUND((COALESCE(SUM(IF(plan_housing.kesiapan_lahan = 'Siap',1,0)),0) / COUNT(plan_housing.id_int)) * 100, 1) , '%)' ) as data_text
FROM
  (
    SELECT
      inte.id_int,
      tgci.id_gci,
      pr.project,
      tgci.id_project,
      tgci.blok,
      inte.tgl_sp3k,
      bangun_detail.id_rencana,
      lahan.id_lahan,
      IF(bangun_detail.id_rencana IS NOT NULL, 'Terbit', 'Belum Terbit') AS spk_terbit,
      IF(lahan.id_lahan IS NOT NULL, 'Siap', 'Belum Siap') AS kesiapan_lahan
    FROM
      rsp_project_live.t_gci tgci
      LEFT JOIN rsp_project_live.t_akad akad ON akad.id_konsumen = tgci.id_konsumen
      LEFT JOIN rsp_project_live.t_bic bic ON bic.id_gci = tgci.id_gci
      LEFT JOIN rsp_project_live.t_inventory inv ON inv.id_bic = bic.id_bic
      LEFT JOIN rsp_project_live.t_interview inte ON inte.id_gci = tgci.id_gci
      LEFT JOIN (
        SELECT
          income.id_gci,
          sum(income.nominal) AS dp
        FROM
          rsp_project_live.t_income income
          LEFT JOIN rsp_project_live.t_gci tgci ON tgci.id_gci = income.id_gci
        WHERE
          income.id_rek NOT IN ('640.01')
        GROUP BY
          income.id_gci
      ) income ON income.id_gci = tgci.id_gci
      LEFT JOIN rsp_project_live.m_project pr ON pr.id_project = tgci.id_project
      LEFT JOIN rsp_project_live.t_project_bangun_detail bangun_detail ON bangun_detail.id_project = tgci.id_project
      AND bangun_detail.blok = tgci.blok
      LEFT JOIN rsp_project_live.t_kesiapan_lahan_housing_detail lahan_detail ON lahan_detail.id_project = tgci.id_project
      AND lahan_detail.blok = tgci.blok
      LEFT JOIN rsp_project_live.t_kesiapan_lahan_housing lahan ON lahan.id_lahan = lahan_detail.id_lahan
      LEFT JOIN rsp_project_live.t_spr spr ON spr.id_gci = tgci.id_gci
    WHERE
      LEFT(inte.tgl_sp3k, 7) = '$periode'
      AND tgci.id_project = $project
      AND (
        rsp_project_live.status_proses (
          tgci.id_kategori,
          income.dp,
          pr.id_project_tipe,
          bic.hasil_bic,
          inv.hasil_inv,
          inte.hasil_int,
          inte.tgl_interview,
          akad.hasil_akad,
          spr.jenis,
          tgci.blok,
          tgci.reject_berkas
        ) in (43, 45, 311)
      )
    GROUP BY
      tgci.id_project,
      tgci.blok
    ORDER BY
      bangun_detail.id_rencana DESC
  ) plan_housing";
        return $this->db->query($query)->row_array();
    }

    function sp3k_vs_spk($project, $periode){
        $query = "SELECT
  COUNT(plan_housing.id_int) AS target, 
  100 AS target_persentase, 
  COALESCE(SUM(IF(plan_housing.spk_terbit = 'Terbit',1,0)),0) as actual,
  ROUND((COALESCE(SUM(IF(plan_housing.spk_terbit = 'Terbit',1,0)),0) / COUNT(plan_housing.id_int)) * 100, 1) as achieve_persentase,
  CONCAT('Data : ', COALESCE(SUM(IF(plan_housing.spk_terbit = 'Terbit',1,0)),0) , '/' , COUNT(plan_housing.id_int) , ' (' , ROUND((COALESCE(SUM(IF(plan_housing.spk_terbit = 'Terbit',1,0)),0) / COUNT(plan_housing.id_int)) * 100, 1) , '%)' ) as data_text
FROM
  (
    SELECT
      inte.id_int,
      tgci.id_gci,
      pr.project,
      tgci.id_project,
      tgci.blok,
      inte.tgl_sp3k,
      bangun_detail.id_rencana,
      lahan.id_lahan,
      IF(bangun_detail.id_rencana IS NOT NULL, 'Terbit', 'Belum Terbit') AS spk_terbit,
      IF(lahan.id_lahan IS NOT NULL, 'Siap', 'Belum Siap') AS kesiapan_lahan
    FROM
      rsp_project_live.t_gci tgci
      LEFT JOIN rsp_project_live.t_akad akad ON akad.id_konsumen = tgci.id_konsumen
      LEFT JOIN rsp_project_live.t_bic bic ON bic.id_gci = tgci.id_gci
      LEFT JOIN rsp_project_live.t_inventory inv ON inv.id_bic = bic.id_bic
      LEFT JOIN rsp_project_live.t_interview inte ON inte.id_gci = tgci.id_gci
      LEFT JOIN (
        SELECT
          income.id_gci,
          sum(income.nominal) AS dp
        FROM
          rsp_project_live.t_income income
          LEFT JOIN rsp_project_live.t_gci tgci ON tgci.id_gci = income.id_gci
        WHERE
          income.id_rek NOT IN ('640.01')
        GROUP BY
          income.id_gci
      ) income ON income.id_gci = tgci.id_gci
      LEFT JOIN rsp_project_live.m_project pr ON pr.id_project = tgci.id_project
      LEFT JOIN rsp_project_live.t_project_bangun_detail bangun_detail ON bangun_detail.id_project = tgci.id_project
      AND bangun_detail.blok = tgci.blok
      LEFT JOIN rsp_project_live.t_kesiapan_lahan_housing_detail lahan_detail ON lahan_detail.id_project = tgci.id_project
      AND lahan_detail.blok = tgci.blok
      LEFT JOIN rsp_project_live.t_kesiapan_lahan_housing lahan ON lahan.id_lahan = lahan_detail.id_lahan
      LEFT JOIN rsp_project_live.t_spr spr ON spr.id_gci = tgci.id_gci
    WHERE
      LEFT(inte.tgl_sp3k, 7) = '$periode'
      AND tgci.id_project = $project
      AND (
        rsp_project_live.status_proses (
          tgci.id_kategori,
          income.dp,
          pr.id_project_tipe,
          bic.hasil_bic,
          inv.hasil_inv,
          inte.hasil_int,
          inte.tgl_interview,
          akad.hasil_akad,
          spr.jenis,
          tgci.blok,
          tgci.reject_berkas
        ) in (43, 45, 311)
      )
    GROUP BY
      tgci.id_project,
      tgci.blok
    ORDER BY
      bangun_detail.id_rencana DESC
  ) plan_housing";
        return $this->db->query($query)->row_array();
    }

    function spk_vs_pelaksana($project, $periode){
        $query = "SELECT
  COUNT(plan.id_int) AS target,
  100 AS target_persentase,
  COALESCE(SUM(IF(plan.STATUS = 'Ontime', 1, 0)),0) AS actual,
  ROUND(COALESCE(SUM(IF(plan.STATUS = 'Ontime', 1, 0)),0) / COUNT(plan.id_int) * 100, 1) AS achieve_persentase,
  CONCAT('Data : ', COALESCE(SUM(IF(plan.STATUS = 'Ontime', 1, 0)),0) , '/' , COUNT(plan.id_int) , ' (' , ROUND((COALESCE(SUM(IF(plan.STATUS = 'Ontime', 1, 0)),0) / COUNT(plan.id_int)) * 100, 1) , '%)' ) as data_text
FROM
  (
    SELECT
      inte.id_int,
      bangun_detail.id_rencana,
      bangun_detail.tgl_spk,
      MIN(task.created_at) AS tgl_progres_awal,
      IF(MIN(task.created_at) <= CONCAT(bangun_detail.tgl_spk, ' 23:59:59'), 'Ontime', 'Late') AS STATUS
      FROM
      rsp_project_live.t_gci tgci
      LEFT JOIN rsp_project_live.t_akad akad ON akad.id_konsumen = tgci.id_konsumen
      LEFT JOIN rsp_project_live.t_bic bic ON bic.id_gci = tgci.id_gci
      LEFT JOIN rsp_project_live.t_inventory inv ON inv.id_bic = bic.id_bic
      LEFT JOIN rsp_project_live.t_interview inte ON inte.id_gci = tgci.id_gci
      LEFT JOIN (
        SELECT
          income.id_gci,
          sum(income.nominal) AS dp
        FROM
          rsp_project_live.t_income income
          LEFT JOIN rsp_project_live.t_gci tgci ON tgci.id_gci = income.id_gci
        WHERE
          income.id_rek NOT IN ('640.01')
        GROUP BY
          income.id_gci
      ) income ON income.id_gci = tgci.id_gci
      LEFT JOIN rsp_project_live.m_project pr ON pr.id_project = tgci.id_project
      LEFT JOIN rsp_project_live.t_project_bangun_detail bangun_detail ON bangun_detail.id_project = tgci.id_project
      AND bangun_detail.blok = tgci.blok
      LEFT JOIN rsp_project_live.t_kesiapan_lahan_housing_detail lahan_detail ON lahan_detail.id_project = tgci.id_project
      AND lahan_detail.blok = tgci.blok
      LEFT JOIN rsp_project_live.t_kesiapan_lahan_housing lahan ON lahan.id_lahan = lahan_detail.id_lahan
      LEFT JOIN rsp_project_live.t_spr spr ON spr.id_gci = tgci.id_gci
      LEFT JOIN rsp_project_live.t_task_rumah task ON task.project = tgci.id_project AND task.blok = tgci.blok
    WHERE
      LEFT(inte.tgl_sp3k, 7) = '$periode'
      AND tgci.id_project = $project
      AND (
        rsp_project_live.status_proses (
          tgci.id_kategori,
          income.dp,
          pr.id_project_tipe,
          bic.hasil_bic,
          inv.hasil_inv,
          inte.hasil_int,
          inte.tgl_interview,
          akad.hasil_akad,
          spr.jenis,
          tgci.blok,
          tgci.reject_berkas
        ) in (43, 45, 311)
      )
    GROUP BY
      tgci.id_project,
      tgci.blok
    ORDER BY
      bangun_detail.id_rencana DESC
  ) plan";
        return $this->db->query($query)->row_array();
    }
}