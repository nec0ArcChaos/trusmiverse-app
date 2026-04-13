<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_api_drbm extends CI_Model
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
        $query = "SELECT
                u.id_user,
                u.employee_name AS `name`
            FROM
                rsp_project_live.`user` u
            WHERE
                u.id_user IN (61, 18, 238, 23609)";
        return $this->db->query($query)->result();
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

    function kpi_corporate($periode){
      $query = "SELECT
      'Non Performing Loan (NPL) Tingkat kredit konsumen bermasalah' AS corporate_kpi,
      10 AS presentase_target,
      COALESCE(COUNT(gci.id_gci),0) AS total_akad,
      COALESCE(COUNT(drbm.id),0) AS total_drbm,
      COALESCE(ROUND((COUNT(drbm.id) * 100.0 / NULLIF(COUNT(gci.id_gci), 0)),2),0) AS presentase
    FROM
      rsp_project_live.t_gci gci
      JOIN rsp_project_live.t_akad akd ON akd.id_konsumen = gci.id_konsumen AND akd.hasil_akad = 1
      LEFT JOIN rsp_project_live.t_drbm drbm ON drbm.id_gci = gci.id_gci
      WHERE
      SUBSTR(akd.jadwal_akad,1,4) = YEAR('$periode-01')";

      return $this->db->query($query)->row_array();
    }

    function kpi_rm($id_rm, $periode){
      $query = "SELECT
      'Non Performing Loan (NPL) Tingkat kredit konsumen bermasalah' AS corporate_kpi,
      10 AS presentase_target,
      ROUND(COALESCE(COUNT(gci.id_gci),0)*0.1,0) AS target,
      COALESCE(COUNT(gci.id_gci),0) AS total_akad,
      COALESCE(COUNT(drbm.id),0) AS total_drbm,
      COALESCE(ROUND((COUNT(drbm.id) * 100.0 / NULLIF(COUNT(gci.id_gci), 0)),2),0) AS presentase
    FROM
      rsp_project_live.t_gci gci
      JOIN rsp_project_live.t_akad akd ON akd.id_konsumen = gci.id_konsumen AND akd.hasil_akad = 1
      LEFT JOIN rsp_project_live.t_drbm drbm ON drbm.id_gci = gci.id_gci
      WHERE
      SUBSTR(akd.jadwal_akad,1,4) = YEAR('$periode-01')
      AND gci.id_gm = '$id_rm'";

      return $this->db->query($query)->row_array();
    }

    function jumlah_drbm($id_rm, $periode) {
        $query = "SELECT
        100 AS target,
        COUNT(y.id_gci) AS total_drbm,
        COALESCE(SUM(IF(y.status_payment = 'Lunas',1,0)),0) AS total_lunas,
        ROUND(SUM(IF(y.status_payment = 'Lunas',1,0))/COUNT(y.id_gci)*100,0) AS persen_lunas,
        SUM(IF(y.status_payment = 'Belum',1,0)) AS total_belum_bayar,
        ROUND(SUM(IF(y.status_payment = 'Belum',1,0))/COUNT(y.id_gci)*100,0) AS persen_belum_bayar,
        SUM(IF(y.status = 'On Time',1,0)) AS total_on_time_lunas,
        ROUND(SUM(IF(y.status = 'On Time',1,0))/SUM(IF(y.status_payment = 'Lunas',1,0))*100,0) AS persen_on_time_lunas,
        SUM(IF(y.status = 'Late',1,0)) AS total_late_lunas,
        ROUND(SUM(IF(y.status = 'Late',1,0))/SUM(IF(y.status_payment = 'Lunas',1,0))*100,0) AS persen_late_lunas
        FROM (SELECT
          x.id_gci,
          x.id_gm,
          x.id,
          x.nominal,
          x.periode,
          x.expected_payment,
          x.payment_date,
          x.nominal_payment,
          x.presentase_payment,
          CASE
          WHEN x.payment_date IS NULL THEN 'Belum Bayar'
          WHEN x.presentase_payment = 100 AND x.expected_payment >= x.payment_date THEN 'On Time'
          ELSE 'Late' END AS status,
          IF(x.presentase_payment = 100, 'Lunas', 'Belum') AS status_payment
        FROM
          (
          SELECT
            gci.id_gci,
            gci.id_gm,
            drbm.id,
            drbm.nominal,
            drbm.periode,
            DATE_ADD( drbm.periode, INTERVAL 1 month ) AS expected_payment,
            inc.tgl_bayar AS payment_date,
            inc.nominal AS nominal_payment,
            ROUND( COALESCE ( inc.nominal, 0 )/ drbm.nominal * 100, 0 ) AS presentase_payment 
          FROM
            rsp_project_live.t_drbm drbm
            JOIN rsp_project_live.t_gci gci ON gci.id_gci = drbm.id_gci
            LEFT JOIN (SELECT * FROM rsp_project_live.t_income_sph GROUP BY id_drbm) inc ON inc.id_gci = gci.id_gci
            AND inc.id_drbm = drbm.id 
          ORDER BY
          gci.id_gci 
          ) x
          WHERE x.id_gm = '$id_rm'
          AND SUBSTR(x.expected_payment,1,7) = '$periode'
          ) y";
        return $this->db->query($query)->row_array();
    }

    function jumlah_sph($id_rm, $periode){
        $query = "SELECT
        100 AS target,
        COUNT(y.id_gci) AS total_sph,
        SUM(IF(y.status_payment = 'Lunas',1,0)) AS total_lunas,
        COALESCE(ROUND(SUM(IF(y.status_payment = 'Lunas',1,0))/COUNT(y.id_gci)*100,0),0) AS persen_lunas,
        SUM(IF(y.status_payment = 'Belum',1,0)) AS total_belum_bayar,
        COALESCE(ROUND(SUM(IF(y.status_payment = 'Belum',1,0))/COUNT(y.id_gci)*100,0),0) AS persen_belum_bayar,
        SUM(IF(y.status = 'On Time',1,0)) AS total_on_time_lunas,
        COALESCE(ROUND(SUM(IF(y.status = 'On Time',1,0))/SUM(IF(y.status_payment = 'Lunas',1,0))*100,0),0) AS persen_on_time_lunas,
        SUM(IF(y.status = 'Late',1,0)) AS total_late_lunas,
        COALESCE(ROUND(SUM(IF(y.status = 'Late',1,0))/SUM(IF(y.status_payment = 'Lunas',1,0))*100,0),0) AS persen_late_lunas
        FROM (SELECT
          x.id_gci,
          x.id_gm,
          x.id,
          x.nominal,
          x.periode,
          x.expected_payment,
          x.payment_date,
          x.nominal_payment,
          x.presentase_payment,
          CASE
          WHEN x.payment_date IS NULL OR x.presentase_payment < 100 THEN 'Belum Bayar'
          WHEN x.presentase_payment = 100 AND x.expected_payment >= x.payment_date THEN 'On Time'
          ELSE 'Late' END AS status,
          IF(x.presentase_payment = 100, 'Lunas', 'Belum') AS status_payment
        FROM
          (
          SELECT
            gci.id_gci,
            gci.id_gm,
            sph.id_sph AS id,
            sph.nominal_sph AS nominal,
            sph.created_at AS periode,
            COALESCE(sph.jtp, DATE_ADD( sph.created_at, INTERVAL 1 month )) AS expected_payment,
            inc.tgl_bayar AS payment_date,
            inc.nominal AS nominal_payment,
            ROUND( COALESCE ( inc.nominal, 0 )/ sph.nominal_sph * 100, 0 ) AS presentase_payment 
          FROM
          rsp_project_live.t_sph sph
            JOIN rsp_project_live.t_gci gci ON gci.id_gci = sph.id_gci
            LEFT JOIN (SELECT * FROM rsp_project_live.t_income_sph GROUP BY id_sph) inc ON inc.id_gci = gci.id_gci AND inc.id_sph = sph.id_sph
          ORDER BY
          gci.id_gci 
          ) x
          WHERE x.id_gm = '$id_rm'
          AND SUBSTR(x.expected_payment,1,7) = '$periode'
          ) y";
        return $this->db->query($query)->row_array();
    }

    function credit_scoring($id_rm, $periode){
        $query = "SELECT
        100 AS target,
        COUNT( x.id_gci ) AS total_konsumen_loan,
        COALESCE(SUM(IF(cs.ket_prediksi = 'Layak',1,0)),0) AS total_konsumen_layak,
        COALESCE(ROUND((SUM(IF(cs.ket_prediksi = 'Layak',1,0))/COUNT( x.id_gci ))*100,0),0) AS persen_konsumen_layak,
        COALESCE(SUM(IF(cs.ket_prediksi = 'Tidak Layak',1,0)),0) AS total_konsumen_tidak_layak,
        COALESCE(ROUND((SUM(IF(cs.ket_prediksi = 'Tidak Layak',1,0))/COUNT( x.id_gci ))*100,0),0) AS persen_konsumen_tidak_layak,
        COALESCE(SUM(IF(cs.sisa_gaji >= 800000,1,0)),0) AS total_sisa_gaji_standar_up,
        COALESCE(ROUND((SUM(IF(cs.sisa_gaji >= 800000,1,0))/COUNT( x.id_gci ))*100,0),0) AS persen_sisa_gaji_standar_up,
        COALESCE(SUM(IF(cs.sisa_gaji < 800000,1,0)),0) AS total_sisa_gaji_standar_bawah,
        COALESCE(ROUND((SUM(IF(cs.sisa_gaji < 800000,1,0))/COUNT( x.id_gci ))*100,0),0) AS persen_sisa_gaji_standar_bawah
      FROM
        ( SELECT drbm.id, drbm.id_gci, drbm.periode, DATE_ADD(drbm.periode,INTERVAL 1 month) AS expected_date FROM rsp_project_live.t_drbm drbm
            UNION ALL
            SELECT sph.id_sph AS id, sph.id_gci, SUBSTR(sph.created_at,1,10) AS periode, SUBSTR(COALESCE(sph.jtp, DATE_ADD(sph.created_at,INTERVAL 1 month)),1,10) AS expected_date FROM rsp_project_live.t_sph sph
        ) x
        JOIN rsp_project_live.t_gci gci ON gci.id_gci = x.id_gci
        JOIN rsp_project_live.v_credit_scoring cs ON cs.id_gci = x.id_gci
        WHERE
        gci.id_gm = '$id_rm'
        AND SUBSTR(x.expected_date,1,7) = '$periode'";
        return $this->db->query($query)->row_array();
    }
}