<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_api_akad extends CI_Model
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

    function get_all_rm() {
        // $query = "SELECT id_user, employee_name AS `name` FROM rsp_project_live.`user` WHERE id_user = id_gm AND isActive = 1";
        $query = "SELECT id_user, employee_name AS `name` FROM rsp_project_live.`user` WHERE id_user IN (111,106,18,838,24099)";
        return $this->db->query($query)->result();
    }

    function get_rm($id_rm) {
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

    function kpi_corporate($periode) {
        $query = "SELECT
                    'Leadtime Akad' AS goal,
                    tgt.target,
                    COALESCE(COUNT(akad.hasil_akad),0) AS actual,
                    ROUND(100, 1) as target_persentase,
                    COALESCE(ROUND(COALESCE(COUNT(akad.hasil_akad),0) / tgt.target * 100, 1), 0) AS achieve_persentase,
                    COALESCE(COUNT(IF(akad.leadtime < 16 AND akad.hasil_akad IS NOT NULL, 1, NULL)),0) AS hasil_ontime,
                    COALESCE(COUNT(IF(akad.leadtime > 15 AND akad.hasil_akad IS NOT NULL, 1, NULL)),0) AS hasil_late,
                    COALESCE(ROUND(
                      COUNT(IF(akad.leadtime < 16 AND akad.hasil_akad IS NOT NULL, 1, NULL)) / tgt.target * 100,
                      1
                    ),0) AS persentase_ontime,
                    COALESCE(ROUND(
                      COUNT(IF(akad.leadtime > 15 AND akad.hasil_akad IS NOT NULL, 1, NULL)) / tgt.target * 100,
                      1
                    ),0) AS persentase_late
                  FROM
                    (
                      SELECT
                        x.id_akad,
                        x.hasil_akad,
                        x.tgl_akad,
                        x.jadwal_akad,
                        x.tgl_lpa,
                        x.leadtime,
                        x.id_gm,
                        gm.employee_name AS gm
                      FROM
                        (
                          SELECT
                            intv.id_akad,
                            intv.hasil_akad,
                            intv.jadwal_akad AS tgl_akad,
                            COALESCE(`int`.jadwal_akad_1,`int`.jadwal_akad_2) AS jadwal_akad,
                            COALESCE(lpa.tgl_lpa, intv.jadwal_akad) AS tgl_lpa,
                            DATEDIFF(intv.jadwal_akad, COALESCE(lpa.tgl_lpa, intv.jadwal_akad)) AS leadtime,
                            CASE 
                              WHEN tgci.manager IN (19,167) THEN 18
                              WHEN tgci.id_gm IN (238) THEN 838
                              WHEN tgci.manager IN (106,111) THEN tgci.manager
                            ELSE tgci.id_gm
                            END AS id_gm
                          FROM
                            rsp_project_live.t_akad AS intv
                            LEFT JOIN rsp_project_live.t_spk tspk ON tspk.id_spk = intv.id_spk
                            JOIN rsp_project_live.t_gci tgci ON tgci.id_gci = tspk.id_gci
                            LEFT JOIN t_interview AS `int` ON `int`.id_gci = tgci.id_gci
                            LEFT JOIN rsp_project_live.t_lpa lpa ON lpa.project = tgci.id_project
                            AND lpa.blok = tgci.blok
                          WHERE
                            intv.hasil_akad = 1
                          -- AND LEFT(intv.jadwal_akad, 7) = '$periode'
                          AND LEFT(COALESCE(`int`.jadwal_akad_1,`int`.jadwal_akad_2),7) = '$periode'
                          AND (tgci.manager IN (19,167,111,106)
                          OR (tgci.id_gm IN (18,238,838,24099)))
                        ) AS x
                      LEFT JOIN `user` AS gm ON gm.id_user = x.id_gm
                    ) AS akad
                  LEFT JOIN
                    (
                      SELECT
                        LEFT(COALESCE(jadwal_akad_1, jadwal_akad_2), 7) AS periode,
                        COUNT(id_int) AS `target`
                      FROM 
                        t_interview
                      WHERE 
                        LEFT(COALESCE(jadwal_akad_1, jadwal_akad_2), 7) = '$periode'
                      GROUP BY 
                        LEFT(COALESCE(jadwal_akad_1, jadwal_akad_2), 7)
                    ) AS tgt ON tgt.periode = '$periode'
                ";

        return $this->db->query($query)->row_array();
    }

    function kpi_rm($id_rm, $periode) {
        $query = "SELECT
                    'Leadtime Akad' AS goal,
                    tgt.target,
                    COALESCE(COUNT(akad.hasil_akad),0) AS actual,
                    ROUND(100, 1) as target_persentase,
                    COALESCE(ROUND(COALESCE(COUNT(akad.hasil_akad),0) / tgt.target * 100, 1), 0) AS achieve_persentase,
                    COALESCE(COUNT(IF(akad.leadtime < 16 AND akad.hasil_akad IS NOT NULL, 1, NULL)),0) AS hasil_ontime,
                    COALESCE(COUNT(IF(akad.leadtime > 15 AND akad.hasil_akad IS NOT NULL, 1, NULL)),0) AS hasil_late,
                    COALESCE(ROUND(
                      COUNT(IF(akad.leadtime < 16 AND akad.hasil_akad IS NOT NULL, 1, NULL)) / tgt.target * 100,
                      1
                    ),0) AS persentase_ontime,
                    COALESCE(ROUND(
                      COUNT(IF(akad.leadtime > 15 AND akad.hasil_akad IS NOT NULL, 1, NULL)) / tgt.target * 100,
                      1
                    ),0) AS persentase_late
                  FROM
                    (
                      SELECT
                        x.id_akad,
                        x.hasil_akad,
                        x.tgl_akad,
                        x.jadwal_akad,
                        x.tgl_lpa,
                        x.leadtime,
                        x.id_gm,
                        gm.employee_name AS gm
                      FROM
                        (
                          SELECT
                            intv.id_akad,
                            intv.hasil_akad,
                            intv.jadwal_akad AS tgl_akad,
                            COALESCE(`int`.jadwal_akad_1,`int`.jadwal_akad_2) AS jadwal_akad,
                            COALESCE(lpa.tgl_lpa, intv.jadwal_akad) AS tgl_lpa,
                            DATEDIFF(intv.jadwal_akad, COALESCE(lpa.tgl_lpa, intv.jadwal_akad)) AS leadtime,
                            CASE 
                              WHEN tgci.manager IN (19,167) THEN 18
                              WHEN tgci.id_gm IN (238) THEN 838
                              WHEN tgci.manager IN (106,111) THEN tgci.manager
                            ELSE tgci.id_gm
                            END AS id_gm
                          FROM
                            rsp_project_live.t_akad AS intv
                            LEFT JOIN rsp_project_live.t_spk tspk ON tspk.id_spk = intv.id_spk
                            JOIN rsp_project_live.t_gci tgci ON tgci.id_gci = tspk.id_gci
                            LEFT JOIN t_interview AS `int` ON `int`.id_gci = tgci.id_gci
                            LEFT JOIN rsp_project_live.t_lpa lpa ON lpa.project = tgci.id_project
                            AND lpa.blok = tgci.blok
                          WHERE
                            intv.hasil_akad = 1
                          -- AND LEFT(intv.jadwal_akad, 7) = '$periode'
                          AND LEFT(COALESCE(`int`.jadwal_akad_1,`int`.jadwal_akad_2),7) = '$periode'
                          AND (tgci.manager IN (19,167,111,106)
                          OR (tgci.id_gm IN (18,238,838,24099)))
                        ) AS x
                      LEFT JOIN `user` AS gm ON gm.id_user = x.id_gm
                      WHERE x.id_gm = '$id_rm'
                    ) AS akad
                  LEFT JOIN
                    (
                      SELECT
                        LEFT(COALESCE(jadwal_akad_1, jadwal_akad_2), 7) AS periode,
                        COUNT(id_int) AS `target`
                      FROM 
                        t_interview
                      WHERE 
                        LEFT(COALESCE(jadwal_akad_1, jadwal_akad_2), 7) = '$periode'
                      GROUP BY 
                        LEFT(COALESCE(jadwal_akad_1, jadwal_akad_2), 7)
                    ) AS tgt ON tgt.periode = '$periode'
                    ";

        return $this->db->query($query)->row_array();
    }

    function jumlah_berkas_bank($id_rm, $periode) {
      $query = "SELECT
                  ROUND(100, 1) as target_persentase,
                  COALESCE(COUNT(berkas.no_booking),1) AS total,
                  COALESCE(SUM(IF(berkas.status_berkas = 'LENGKAP', 1, 0)),0) AS lengkap,
                  COALESCE(ROUND(COALESCE(SUM(IF(berkas.status_berkas = 'LENGKAP', 1, 0)),0) / COALESCE(COUNT(berkas.no_booking),1) * 100), 0) AS persentase_lengkap,
                  COALESCE(SUM(IF(berkas.status_berkas = 'BELUM LENGKAP', 1, 0)),0) AS tidak_lengkap,
                  COALESCE(ROUND(COALESCE(SUM(IF(berkas.status_berkas = 'BELUM LENGKAP', 1, 0)),0) / COALESCE(COUNT(berkas.no_booking),1) * 100), 0) AS persentase_tidak_lengkap
                FROM
                  (
                    WITH RECURSIVE date_range AS (
                      SELECT DATE('$periode-01') AS tgl
                      UNION ALL
                      SELECT DATE_ADD(tgl, INTERVAL 1 DAY)
                      FROM date_range
                      WHERE tgl < LAST_DAY(DATE('$periode-01'))
                    )
                    SELECT
                      g.id_gci AS no_booking,
                      g.id_project,
                      p.project,
                      g.blok,
                      k.nama_konsumen,
                      CASE 
                        WHEN g.manager IN (19,167) THEN 18
                        WHEN g.id_gm IN (238) THEN 838
                        WHEN g.manager IN (106,111) THEN g.manager
                      ELSE g.id_gm
                      END AS id_gm,
                      -- rm.employee_name AS regional_manager,
                      -- mm.employee_name AS manager_sales,
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
                      IF(DATEDIFF(COALESCE(i.tgl_input_berkas,CURRENT_DATE), DATE(b.tgl_bic)) - COUNT(DISTINCT IF(CONCAT(kalendar.tgl, ' - ', kalendar.hari) = CONCAT(kalendar.tgl, ' - Minggu'), CONCAT(kalendar.tgl, ' - ', kalendar.hari), NULL)) <= 12, 'ONTIME', 'LATE') AS status_leadtime,
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
                    -- LEFT JOIN rsp_project_live.user rm ON rm.id_user = g.id_gm
                    -- LEFT JOIN rsp_project_live.user mm ON mm.id_user = g.manager
                    LEFT JOIN rsp_project_live.user spv ON spv.id_user = g.spv
                    LEFT JOIN rsp_project_live.user sales ON sales.id_user = g.created_by
                    LEFT JOIN rsp_project_live.user collect ON collect.id_user = i.created_by
                    LEFT JOIN rsp_project_live.user pic_bank ON pic_bank.id_user = inv.pic_bank
                    LEFT JOIN
                      (
                        SELECT 
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
                        FROM date_range
                      ) AS kalendar ON kalendar.tgl BETWEEN DATE(b.tgl_bic) AND DATE(COALESCE(i.tgl_input_berkas,CURRENT_DATE))
                    LEFT JOIN
                      (
                        SELECT 
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
                        FROM date_range
                      ) AS kalendar_berkas ON kalendar_berkas.tgl BETWEEN DATE(b.tgl_bic) AND DATE(COALESCE(COALESCE(inv.updated_at,inv.created_at),CURRENT_DATE))
                    WHERE g.created_at LIKE '$periode%' 
                    AND LEFT(LOWER(g.jenis_pembayaran),4) != 'cash'
                    AND g.id_kategori >= 3
                    AND LEFT(g.blok,2) != 'RD'
                    AND b.hasil_bic IN (1,2)
                    AND b.created_at LIKE '$periode%'
                    -- AND g.id_gm = $id_rm
                    GROUP BY g.id_gci
                  ) berkas
                LEFT JOIN `user` AS gm ON gm.id_user = berkas.id_gm
                WHERE berkas.id_gm = $id_rm
              ";

      return $this->db->query($query)->row_array();
    }

    function leadtime_berkas_bank_lengkap($id_rm, $periode) {
      $query = "SELECT
                  COALESCE(SUM(IF(berkas.status_berkas = 'LENGKAP' AND berkas.status_leadtime = 'ONTIME', 1, 0)),0) AS ontime,
                  COALESCE(ROUND(COALESCE(SUM(IF(berkas.status_berkas = 'LENGKAP' AND berkas.status_leadtime = 'ONTIME', 1, 0)),0) / COALESCE(SUM(IF(berkas.status_berkas = 'LENGKAP', 1, 0)),0) * 100), 0) AS persentase_ontime,
                  COALESCE(SUM(IF(berkas.status_berkas = 'LENGKAP' AND berkas.status_leadtime = 'LATE', 1, 0)),0) AS late,
                  COALESCE(ROUND(COALESCE(SUM(IF(berkas.status_berkas = 'LENGKAP' AND berkas.status_leadtime = 'LATE', 1, 0)),0) / COALESCE(SUM(IF(berkas.status_berkas = 'LENGKAP', 1, 0)),0) * 100), 0) AS persentase_late
                FROM
                  (
                    WITH RECURSIVE date_range AS (
                      SELECT DATE('$periode-01') AS tgl
                      UNION ALL
                      SELECT DATE_ADD(tgl, INTERVAL 1 DAY)
                      FROM date_range
                      WHERE tgl < LAST_DAY(DATE('$periode-01'))
                    )
                    SELECT
                      g.id_gci AS no_booking,
                      g.id_project,
                      p.project,
                      g.blok,
                      k.nama_konsumen,
                      CASE 
                        WHEN g.manager IN (19,167) THEN 18
                        WHEN g.id_gm IN (238) THEN 838
                        WHEN g.manager IN (106,111) THEN g.manager
                      ELSE g.id_gm
                      END AS id_gm,
                      -- rm.employee_name AS regional_manager,
                      -- mm.employee_name AS manager_sales,
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
                      IF(DATEDIFF(COALESCE(i.tgl_input_berkas,CURRENT_DATE), DATE(b.tgl_bic)) - COUNT(DISTINCT IF(CONCAT(kalendar.tgl, ' - ', kalendar.hari) = CONCAT(kalendar.tgl, ' - Minggu'), CONCAT(kalendar.tgl, ' - ', kalendar.hari), NULL)) <= 12, 'ONTIME', 'LATE') AS status_leadtime,
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
                    LEFT JOIN
                      (
                        SELECT 
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
                        FROM date_range
                      ) AS kalendar ON kalendar.tgl BETWEEN DATE(b.tgl_bic) AND DATE(COALESCE(i.tgl_input_berkas,CURRENT_DATE))
                    LEFT JOIN
                      (
                        SELECT 
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
                        FROM date_range
                      ) AS kalendar_berkas ON kalendar_berkas.tgl BETWEEN DATE(b.tgl_bic) AND DATE(COALESCE(COALESCE(inv.updated_at,inv.created_at),CURRENT_DATE))
                    WHERE g.created_at LIKE '$periode%' 
                    AND LEFT(LOWER(g.jenis_pembayaran),4) != 'cash'
                    AND g.id_kategori >= 3
                    AND LEFT(g.blok,2) != 'RD'
                    AND b.hasil_bic IN (1,2)
                    AND b.created_at LIKE '$periode%'
                    -- AND g.id_gm = $id_rm
                    GROUP BY g.id_gci
                  ) berkas
                LEFT JOIN `user` AS gm ON gm.id_user = berkas.id_gm
                WHERE berkas.id_gm = $id_rm
              ";

      return $this->db->query($query)->row_array();
    }

    function jumlah_sp3k($id_rm, $periode){
      $query = "SELECT
                  COALESCE(tgt.target,1) AS `target`,
                  ROUND(100, 1) as target_persentase,
                  COALESCE(COUNT(intv.hasil_int),0) AS actual,
                  COALESCE(ROUND(COALESCE(COUNT(intv.hasil_int),0) / COALESCE(tgt.target,1) * 100), 0) AS achieve_persentase
                FROM
                  rsp_project_live.t_interview AS intv
                JOIN rsp_project_live.t_gci tgci ON tgci.id_gci = intv.id_gci
                LEFT JOIN rsp_project_live.t_akad akad ON akad.id_konsumen = tgci.id_konsumen
                LEFT JOIN
                  (
                    SELECT
                      x.periode,
                      COUNT(x.target) AS `target`,
                      x.id_gm
                    FROM
                      (
                        SELECT
                          LEFT(COALESCE(t_interview.jadwal_sp3k_1, t_interview.jadwal_sp3k_2), 7) AS periode,
                          (t_interview.id_int) AS `target`,
                          CASE 
                            WHEN t_gci.manager IN (19,167) THEN 18
                            WHEN t_gci.id_gm IN (238) THEN 838
                            WHEN t_gci.manager IN (106,111) THEN t_gci.manager
                          ELSE t_gci.id_gm
                          END AS id_gm
                        FROM 
                          t_interview
                        LEFT JOIN t_gci ON t_gci.id_gci = t_interview.id_gci
                        WHERE LEFT(COALESCE(jadwal_sp3k_1, jadwal_sp3k_2), 7) = '$periode'
                        AND (t_gci.manager IN (19,167,111,106)
                        OR (t_gci.id_gm IN (18,238,838,24099)))
                      ) AS x
                    WHERE x.id_gm = '18'
                    GROUP BY x.periode, x.id_gm
                  ) AS tgt ON '$periode' = tgt.periode
                WHERE intv.hasil_int = 1
                AND akad.id_akad IS NULL
                AND LEFT(intv.tgl_sp3k, 7) = '$periode'
                AND tgt.id_gm = '18'
                AND LEFT(tgci.blok, 2) <> 'RD'
                AND LEFT(tgci.blok, 2) <> 'R-'
              ";
                
      return $this->db->query($query)->row_array();

    }

                      function leadtime_sp3k($id_rm, $periode){
                          $query = "SELECT
                    COUNT(IF(fix.leadtime < 11, 1, NULL)) AS ontime,
                    COUNT(IF(fix.leadtime > 10, 1, NULL)) AS late
                  FROM
                    (
                      SELECT
                        intv.id_int,
                        DATE(intv.tgl_sp3k) AS tgl_sp3k,
                        IF(intv.tgl_input_berkas = '0000-00-00', CURDATE(), DATE(intv.tgl_input_berkas)) AS tgl_bank,
                        DATEDIFF(DATE(intv.tgl_sp3k), IF(intv.tgl_input_berkas = '0000-00-00', CURDATE(), DATE(intv.tgl_input_berkas))) AS leadtime
                      FROM
                        rsp_project_live.t_interview AS intv
                        JOIN rsp_project_live.t_gci tgci ON tgci.id_gci = intv.id_gci
                      WHERE
                        intv.hasil_int = 1
                        AND LEFT(intv.tgl_sp3k, 7) = '$periode'
                        AND tgci.id_gm = '$id_rm'
                        AND LEFT(tgci.blok, 2) <> 'RD'
                        AND LEFT(tgci.blok, 2) <> 'R-'
                    ) fix
                  ";

        return $this->db->query($query)->row_array();
    }

    function usia_sp3k($id_rm, $periode){
        $query = "SELECT
  COUNT(IF(fix.leadtime < 16, 1, NULL)) AS under_16_hari,
  ROUND(COUNT(IF(fix.leadtime < 16, 1, NULL)) / COUNT(fix.id_int) * 100, 2) AS persentase_under_16_hari,
  COUNT(IF(fix.leadtime > 15 AND fix.leadtime < 31, 1, NULL)) AS under_30_hari,
  ROUND(
    COUNT(IF(fix.leadtime > 15 AND fix.leadtime < 31, 1, NULL)) / COUNT(fix.id_int) * 100,
    2
  ) AS persentase_under_30_hari,
  COUNT(IF(fix.leadtime > 30 AND fix.leadtime < 91, 1, NULL)) AS under_90_hari,
  ROUND(
    COUNT(IF(fix.leadtime > 30 AND fix.leadtime < 91, 1, NULL)) / COUNT(fix.id_int) * 100,
    2
  ) AS persentase_under_90_hari,
  COUNT(IF(fix.leadtime > 90, 1, NULL)) AS up_90_hari,
  ROUND(COUNT(IF(fix.leadtime > 90, 1, NULL)) / COUNT(fix.id_int) * 100, 2) AS persentase_up_90_hari
FROM
  (
    SELECT
      intv.id_int,
      intv.tgl_sp3k,
      akad.id_akad,
      akad.jadwal_akad,
      DATEDIFF(CURDATE(), intv.tgl_sp3k) AS leadtime
    FROM
      rsp_project_live.t_interview AS intv
      JOIN rsp_project_live.t_gci tgci ON tgci.id_gci = intv.id_gci
      LEFT JOIN rsp_project_live.t_akad akad ON akad.id_konsumen = tgci.id_konsumen
    WHERE
      intv.hasil_int = 1
      AND LEFT(intv.tgl_sp3k, 7) = '$periode'
      AND akad.id_akad IS NULL
      AND tgci.id_gm = '$id_rm'
      AND LEFT(tgci.blok, 2) <> 'RD'
      AND LEFT(tgci.blok, 2) <> 'R-'
  ) AS fix";
        return $this->db->query($query)->row_array();
    }

    function bangunan_under_30($id_rm, $periode){
        $query = "SELECT
  ROUND(100, 1) AS target_persentase,
  COUNT(bangun.id_gci) AS target,
  COUNT(IF(bangun.progres < 30, 1, NULL)) AS actual,
  ROUND(
    ((COUNT(IF(bangun.progres < 30, 1, NULL)) / COUNT(bangun.id_gci)) * 100),
    2
  ) AS achieve_persentase
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
        WHEN COALESCE(m_project_unit.progres, 0) = 100 THEN
          CONCAT(DATEDIFF(CURRENT_DATE, m_project_unit.tgl_vendor), ' Hari')
        ELSE
          '-'
      END AS umur_bangunan
    FROM
      rsp_project_live.t_gci AS t_gci
      LEFT JOIN rsp_project_live.m_project AS m_project ON m_project.id_project = t_gci.id_project
      LEFT JOIN rsp_project_live.m_project_unit AS m_project_unit ON (m_project_unit.id_project = t_gci.id_project AND REPLACE(t_gci.blok, 'RD-', '') = m_project_unit.blok)
      LEFT JOIN rsp_project_live.m_konsumen AS m_konsumen ON m_konsumen.id_konsumen = t_gci.id_konsumen
      LEFT JOIN rsp_project_live.t_perubahan_konsumen AS t_perubahan_konsumen ON t_perubahan_konsumen.id_konsumen = t_gci.id_konsumen
      LEFT JOIN rsp_project_live.`user` AS gm ON t_gci.id_gm = gm.id_user
      LEFT JOIN rsp_project_live.t_akad akad ON akad.id_konsumen = t_gci.id_konsumen
      LEFT JOIN rsp_project_live.t_interview intv ON intv.id_gci = t_gci.id_gci
    WHERE
      SUBSTR(intv.tgl_sp3k, 1, 7) = '$periode'
      AND t_gci.id_kategori IN (2.1, 3, 4)
      AND intv.hasil_int = 1
      AND akad.id_akad IS NULL
      AND LEFT(t_gci.blok, 2) <> 'RD'
      AND LEFT(t_gci.blok, 2) <> 'R-'
    GROUP BY
      t_gci.id_gci
  ) AS bangun
WHERE
  bangun.id_gm = '$id_rm'
GROUP BY
  bangun.id_gm";
        return $this->db->query($query)->row_array();
    }

    function pelunasan_dp($id_rm, $periode){
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

    function lpa($id_rm, $periode){
        $query = "SELECT
  COUNT(lpa.id_gci) as target,
  ROUND(100, 1) as target_persentase,
  COALESCE(SUM(IF(lpa.status_rencana = 1, 1, 0)), 0) AS actual,
  COALESCE(ROUND(COALESCE(SUM(IF(lpa.status_rencana = 1, 1, 0)), 0) / COUNT(lpa.id_gci) * 100, 1), 0) AS achieve_persentase
FROM
  (
  SELECT
  tgci.id_gci,
  mpu.id_project_unit,
  mpu.blok,
  lpa.`status` AS status_rencana,
  lpa.deadline_project,
  SUBSTR(lpa.created_at, 1, 16) AS created_at,
  SUBSTR(lpa.updated_at, 1, 16) AS updated_at,
  lpa.id,
  COALESCE(lpa.jadwal_reschedule, COALESCE(lpa.jadwal_lpa, lpa.rencana_lpa)) AS jadwal_lpa,
  mpu.type,
  mpu.id_project,
  mpu.progres
FROM
       rsp_project_live.t_gci AS tgci
      LEFT JOIN rsp_project_live.m_project AS project ON project.id_project = tgci.id_project
      LEFT JOIN rsp_project_live.t_rencana_lpa lpa ON lpa.project = tgci.id_project AND lpa.blok = tgci.blok
      LEFT JOIN rsp_project_live.m_project_unit mpu ON mpu.id_project = tgci.id_project AND mpu.blok = tgci.blok
      LEFT JOIN rsp_project_live.m_konsumen AS konsumen ON konsumen.id_konsumen = tgci.id_konsumen
      LEFT JOIN rsp_project_live.m_status status ON mpu.ready = status.id_status
      LEFT JOIN rsp_project_live.t_akad akad ON akad.id_konsumen = tgci.id_konsumen
      LEFT JOIN rsp_project_live.t_interview intv ON intv.id_gci = tgci.id_gci
    WHERE
      SUBSTR(intv.tgl_sp3k, 1, 7) = '$periode'
      AND tgci.id_kategori IN (2.1, 3, 4)
      AND intv.hasil_int = 1
      AND akad.id_akad IS NULL
      AND LEFT(tgci.blok, 2) <> 'RD'
      AND LEFT(tgci.blok, 2) <> 'R-'
      AND tgci.id_gm = '$id_rm'
    GROUP BY
      tgci.id_gci
  ) lpa";
        return $this->db->query($query)->row_array();
    }
}