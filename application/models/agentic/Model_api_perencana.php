<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_api_perencana extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_project($project)
    {
        if ($project == 'all') {
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

    function kpi_corporate($periode)
    {
        $query = "SELECT
			DATE_FORMAT( '$periode-01', '%Y-%m' ) AS periode,
			'Ontime dalam penyelesaian Gambar Teknik dan BoQ' AS nama,
			'Ontime dalam penyelesaian Gambar Teknik dan BoQ' AS goal,
			25 as bobot,
			COUNT(t_perencana.no_pr) as target,
			SUM(IF(DATEDIFF(DATE(COALESCE(t_perencana.end,CURRENT_DATE)),DATE(t_perencana.plan_end)) <= 0, 1,0)) as actual,
			ROUND((SUM(IF(DATEDIFF(DATE(COALESCE(t_perencana.end,CURRENT_DATE)),DATE(t_perencana.plan_end)) <= 0, 1,0)) / COUNT(t_perencana.no_pr)) * 100, 2) as achieve


		FROM
		rsp_project_live.t_perencana
		JOIN rsp_project_live.m_perencana ON t_perencana.id_perencana = m_perencana.id
		JOIN rsp_project_live.m_project ON t_perencana.id_project = m_project.id_project
		JOIN rsp_project_live.m_status_proses ON t_perencana.`status` = m_status_proses.id_status_proses
		JOIN rsp_project_live.m_status_proses AS status_verif ON status_verif.id_status_perencana = t_perencana.verified_status
		
		WHERE
		(DATE_FORMAT(t_perencana.plan_start, '%Y-%m') = DATE_FORMAT('$periode-01', '%Y-%m')
		OR DATE_FORMAT(t_perencana.plan_end, '%Y-%m') = DATE_FORMAT('$periode-01', '%Y-%m'))
		AND t_perencana.divisi IN ('Housing','Infrastruktur');
      ";
        return $this->db->query($query)->row_array();
    }

    function kpi_project($project, $periode)
    {
        $kondisi = "";
        if ($project != 'all') {
            $kondisi = "AND t_perencana.id_project = '$project'";
        }
        $query = "SELECT
                DATE_FORMAT( '$periode-01', '%Y-%m' ) AS periode,
                'Ontime dalam penyelesaian Gambar Teknik dan BoQ Housing & Infra' AS nama,
                'Ontime dalam penyelesaian Gambar Teknik dan BoQ' AS goal,
                25 as bobot,
                COUNT(t_perencana.no_pr) as target,
                COALESCE(SUM(IF(DATEDIFF(DATE(COALESCE(t_perencana.end,CURRENT_DATE)),DATE(t_perencana.plan_end)) <= 0, 1,0)),0) as actual,
                COALESCE(ROUND((SUM(IF(DATEDIFF(DATE(COALESCE(t_perencana.end,CURRENT_DATE)),DATE(t_perencana.plan_end)) <= 0, 1,0)) / COUNT(t_perencana.no_pr)) * 100, 2),0) as achieve

            FROM
            rsp_project_live.t_perencana
            JOIN rsp_project_live.m_perencana ON t_perencana.id_perencana = m_perencana.id
            JOIN rsp_project_live.m_project ON t_perencana.id_project = m_project.id_project
            JOIN rsp_project_live.m_status_proses ON t_perencana.`status` = m_status_proses.id_status_proses
            JOIN rsp_project_live.m_status_proses AS status_verif ON status_verif.id_status_perencana = t_perencana.verified_status
            
            WHERE
            (DATE_FORMAT(t_perencana.plan_start, '%Y-%m') = DATE_FORMAT('$periode-01', '%Y-%m')
            OR DATE_FORMAT(t_perencana.plan_end, '%Y-%m') = DATE_FORMAT('$periode-01', '%Y-%m'))
            AND t_perencana.divisi = 'Housing'
            $kondisi
            ";
        return $this->db->query($query)->row_array();
    }
    function boq_housing($project, $periode)
    {
        $kondisi = "";
        if ($project != 'all') {
            $kondisi = "AND t_perencana.id_project = '$project'";
        }
        $query = "SELECT
                DATE_FORMAT( '$periode-01', '%Y-%m' ) AS periode,
                'Ontime dalam penyelesaian Gambar Teknik dan BoQ Housing' AS nama,
                'Ontime dalam penyelesaian Gambar Teknik dan BoQ' AS goal,
                25 as bobot,
                COUNT(t_perencana.no_pr) as target,
                COALESCE(SUM(IF(DATEDIFF(DATE(COALESCE(t_perencana.end,CURRENT_DATE)),DATE(t_perencana.plan_end)) <= 0, 1,0)),0) as actual,
                COALESCE(ROUND((SUM(IF(DATEDIFF(DATE(COALESCE(t_perencana.end,CURRENT_DATE)),DATE(t_perencana.plan_end)) <= 0, 1,0)) / COUNT(t_perencana.no_pr)) * 100, 2),0) as achieve

            FROM
            rsp_project_live.t_perencana
            JOIN rsp_project_live.m_perencana ON t_perencana.id_perencana = m_perencana.id
            JOIN rsp_project_live.m_project ON t_perencana.id_project = m_project.id_project
            JOIN rsp_project_live.m_status_proses ON t_perencana.`status` = m_status_proses.id_status_proses
            JOIN rsp_project_live.m_status_proses AS status_verif ON status_verif.id_status_perencana = t_perencana.verified_status
            
            WHERE
            (DATE_FORMAT(t_perencana.plan_start, '%Y-%m') = DATE_FORMAT('$periode-01', '%Y-%m')
            OR DATE_FORMAT(t_perencana.plan_end, '%Y-%m') = DATE_FORMAT('$periode-01', '%Y-%m'))
            $kondisi
            AND t_perencana.divisi = 'Housing'";
        return $this->db->query($query)->row_object();
    }


    function boq_infra($project, $periode)
    {
        $kondisi = "";
        if ($project != 'all') {
            $kondisi = "AND t_perencana.id_project = '$project'";
        }
        $query = "SELECT
                DATE_FORMAT( '$periode-01', '%Y-%m' ) AS periode,
                'Ontime dalam penyelesaian Gambar Teknik dan BoQ Infrastruktur' AS nama,
                'Ontime dalam penyelesaian Gambar Teknik dan BoQ' AS goal,
                25 as bobot,
                COUNT(t_perencana.no_pr) as target,
                COALESCE(SUM(IF(DATEDIFF(DATE(COALESCE(t_perencana.end,CURRENT_DATE)),DATE(t_perencana.plan_end)) <= 0, 1,0)),0) as actual,
                COALESCE(ROUND((SUM(IF(DATEDIFF(DATE(COALESCE(t_perencana.end,CURRENT_DATE)),DATE(t_perencana.plan_end)) <= 0, 1,0)) / COUNT(t_perencana.no_pr)) * 100, 2),0) as achieve

            FROM
            rsp_project_live.t_perencana
            JOIN rsp_project_live.m_perencana ON t_perencana.id_perencana = m_perencana.id
            JOIN rsp_project_live.m_project ON t_perencana.id_project = m_project.id_project
            JOIN rsp_project_live.m_status_proses ON t_perencana.`status` = m_status_proses.id_status_proses
            JOIN rsp_project_live.m_status_proses AS status_verif ON status_verif.id_status_perencana = t_perencana.verified_status
            
            WHERE
            (DATE_FORMAT(t_perencana.plan_start, '%Y-%m') = DATE_FORMAT('$periode-01', '%Y-%m')
            OR DATE_FORMAT(t_perencana.plan_end, '%Y-%m') = DATE_FORMAT('$periode-01', '%Y-%m'))
            $kondisi
            AND t_perencana.divisi = 'Infrastruktur'";
        return $this->db->query($query)->row_object();
    }

    function penyelesaian_siteplan($project, $periode)
    {
        $kondisi = "";
        if ($project != 'all') {
            $kondisi = "AND pl.id_project = '$project'";
        }
        $query = "SELECT
            DATE_FORMAT( '$periode-01', '%Y-%m' ) AS periode,
                            'Data Waktu Penyelesain Siteplan' AS nama,
                            'Data Waktu Penyelesain Siteplan' AS goal,
                            25 as bobot,
            COUNT(pl.no_pr) AS target,
            COALESCE(SUM(IF(DATEDIFF(DATE(COALESCE(pl.end,CURRENT_DATE)),DATE(pl.plan_end)) <= 0, 1,0)),0) AS actual,
            ROUND(COALESCE(SUM(IF(DATEDIFF(DATE(COALESCE(pl.end,CURRENT_DATE)),DATE(pl.plan_end)) <= 0, 1,0)),0) / COUNT(pl.no_pr) * 100,2) AS achieve
            FROM
            rsp_project_live.`t_perencana` pl
            LEFT JOIN rsp_project_live.m_perencana ms ON ms.id = pl.id_perencana
            
            WHERE pl.id_perencana IN (149,158,26,33,34,37)
            $kondisi
            AND LEFT(pl.plan_start,7)  = '$periode' ";
        return $this->db->query($query)->row_object();
    }
    function plan_actual_gatek($project, $periode)
    {
        $kondisi = "";
        if ($project != 'all') {
            $kondisi = "AND plan.project = '$project'";
        }
        $query = "SELECT
            DATE_FORMAT( '$periode-01', '%Y-%m' ) AS periode,
                            'Ketersediaan Gambar Teknik  BOQ Housing & Infra Berdasarkan Plan Bangun ' AS nama,
                            'Ketersediaan Gambar Teknik  BOQ Housing & Infra Berdasarkan Plan Bangun ' AS goal,
                            25 as bobot,
            COUNT(*) AS target,
            SUM(CASE
                    WHEN (rec.`start` BETWEEN plan.`start` AND plan.`end`)
                        OR (rec.`start` < plan.`start`) 
                    THEN 1 
                    ELSE 0
                END) AS actual,
                ROUND(SUM(CASE
                    WHEN (rec.`start` BETWEEN plan.`start` AND plan.`end`)
                        OR (rec.`start` < plan.`start`) 
                    THEN 1 
                    ELSE 0
                END) / COUNT(*) * 100,2) AS achieve
            FROM
            rsp_project_live.t_plan_infra plan
            LEFT JOIN rsp_project_live.t_perencana rec ON plan.id_plan = rec.id_plan_infra
            WHERE
            LEFT(plan.created_at, 7) = '$periode'
           $kondisi
            ";
        return $this->db->query($query)->row_object();
    }
    function leadtime_plan_mc0($project, $periode)
    {
        $kondisi = "";
        if ($project != 'all') {
            $kondisi = "AND t_tasklist_surveyor.project = '$project'";
        }
        $query = "SELECT
        DATE_FORMAT('$periode-01', '%Y-%m') AS periode,
      'Lead Time Ketersediaan Plan MC 0 & MC 100' AS nama,
      'Lead Time Ketersediaan Plan MC 0 & MC 100' AS goal,
            50 AS bobot,
            COUNT(id_sry) AS target,
            SUM(CASE WHEN status_penyelesaian = 'Ontime' THEN 1 ELSE 0 END) AS actual,
            ROUND(SUM(CASE WHEN status_penyelesaian = 'Ontime' THEN 1 ELSE 0 END) / COUNT(id_sry) * 100) AS achieve
            
           
        FROM (
            SELECT
                id_sry,
                created_at,
                CASE
                    WHEN DATEDIFF(tgl_end, tgl_start) <= DATEDIFF(plan_end, plan_start) THEN 'Ontime'
                    ELSE 'Late'
                END AS status_penyelesaian
                
            FROM rsp_project_live.t_tasklist_surveyor
            WHERE DATE_FORMAT(created_at, '%Y-%m') = DATE_FORMAT('$periode-01', '%Y-%m')
            $kondisi
        ) AS surveyor_data_2";
        return $this->db->query($query)->row_object();
    }
    function tepat_plan_mco($project, $periode)
    {
        $kondisi = "";
        if ($project != 'all') {
            $kondisi = "AND t_tasklist_surveyor.project = '$project'";
        }
        $query = " SELECT
      DATE_FORMAT('$periode-01', '%Y-%m') AS periode,
      'Tepat dalam pengukuran plan MC0 dan MC100 Vs Aktual' AS nama,
      'Tepat dalam pengukuran plan MC0 dan MC100 Vs Aktual' AS goal,
      25 AS bobot,
      COUNT(id_sry) AS target,
      COALESCE(SUM(
        CASE
          WHEN vol_spk > 0 THEN -- Menghindari pembagian dengan nol
            CASE
              WHEN (100 - (actual / vol_spk * 100)) <= - 5 THEN
                1
              WHEN (100 - (actual / vol_spk * 100)) >= 0
                AND (100 - (actual / vol_spk * 100)) <= 5 THEN
                1
              ELSE
                0
            END
          ELSE
            0
        END
      ),0) AS actual,
      COALESCE(ROUND(
        (
          SUM(
            CASE
              WHEN vol_spk > 0 THEN
                CASE
                  WHEN (100 - (actual / vol_spk * 100)) <= - 5 THEN
                    1
                  WHEN (100 - (actual / vol_spk * 100)) >= 0
                    AND (100 - (actual / vol_spk * 100)) <= 5 THEN
                    1
                  ELSE
                    0
                END
              ELSE
                0
            END
          ) / COUNT(id_sry)
        ) * 100,
        2
      ),0) AS achieve
     
    FROM
      rsp_project_live.t_tasklist_surveyor
    WHERE
      tujuan = 3
      AND id_inf IS NOT NULL
      AND DATE_FORMAT(created_at, '%Y-%m') = DATE_FORMAT('$periode-01', '%Y-%m')
      $kondisi
      ";
        return $this->db->query($query)->row_object();
    }

}