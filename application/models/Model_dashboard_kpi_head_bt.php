<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_dashboard_kpi_head_bt extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        // $this->db_pos_batik = $this->load->database('pos_batik', TRUE); // Load database pos_batik
        // $this->db_hris = $this->load->database('hris', TRUE); // Load database hris
    }

    // BT OPERASIONAL
    public function get_kpi_bt_operasional($periode)
    {
        // Ambil periode sebelumnya untuk mendapatkan data history
        $prev_period = DateTime::createFromFormat('Y-m', $periode)->modify('-1 month')->format('Y-m');

        // Get tanggal start dan end per week
        // $data_week = $this->data_kpi_week($periode)->row_array();
        // $start_w1 = $data_week['start_w1'];
        // $start_w2 = $data_week['start_w2'];
        // $start_w3 = $data_week['start_w3'];
        // $start_w4 = $data_week['start_w4'];
        // $start_w5 = $data_week['start_w5'];
        // $start_w6 = $data_week['start_w6'];

        // $end_w1 = $data_week['end_w1'];
        // $end_w2 = $data_week['end_w2'];
        // $end_w3 = $data_week['end_w3'];
        // $end_w4 = $data_week['end_w4'];
        // $end_w5 = $data_week['end_w5'];
        // $end_w6 = $data_week['end_w6'];

        // BT Operasional KPI REVENUE SALES
        $data_op_bt_revenue_sales = $this->get_data_bt_revenue_sales($periode)->row_array();
        $op_bt_revenue_sales_indicator = $data_op_bt_revenue_sales["indicator"];
        $op_bt_revenue_sales_actual_w1 = $data_op_bt_revenue_sales["persen_w1"];
        $op_bt_revenue_sales_actual_w2 = $data_op_bt_revenue_sales["persen_w2"];
        $op_bt_revenue_sales_actual_w3 = $data_op_bt_revenue_sales["persen_w3"];
        $op_bt_revenue_sales_actual_w4 = $data_op_bt_revenue_sales["persen_w4"];
        $op_bt_revenue_sales_actual_w5 = $data_op_bt_revenue_sales["persen_w5"];
        $op_bt_revenue_sales_actual_w6 = $data_op_bt_revenue_sales["persen_w6"];
        $op_bt_revenue_sales_actual = $data_op_bt_revenue_sales["actual"];

        // BT Operasional Marketting Offline
        $data_op_bt_mk_offline = $this->data_mk_offline($periode)->row_array();
        $op_bt_mk_offline_indicator = $data_op_bt_mk_offline["indicator"];
        $mk_offline_bt_w1 = $data_op_bt_mk_offline["persen_w1"];
        $mk_offline_bt_w2 = $data_op_bt_mk_offline["persen_w2"];
        $mk_offline_bt_w3 = $data_op_bt_mk_offline["persen_w3"];
        $mk_offline_bt_w4 = $data_op_bt_mk_offline["persen_w4"];
        $mk_offline_bt_w5 = $data_op_bt_mk_offline["persen_w5"];
        $mk_offline_bt_w6 = $data_op_bt_mk_offline["persen_w6"];
        $mk_offline_bt = $data_op_bt_mk_offline["actual"];

        // BT Operasional KPI COST
        $data_cost_op_bt = $this->get_data_cost_bt($periode)->row_array();
        $data_act_cost_op_bt = $this->get_cost_sales($periode)->row_array();
        $cost_op_bt_actual = $data_cost_op_bt['act_budget'] / $data_act_cost_op_bt['target'] * 100;
        $cost_op_bt_indicator = $data_cost_op_bt["indicator"];
        
        $cost_op_bt_actual_w1 = $data_cost_op_bt["act_w1"];
        // $cost_op_bt_actual_w1 = $data_cost_op_bt["act_w1"] / $data_act_cost_op_bt['target'] * 100;
        $cost_op_bt_actual_w2 = $data_cost_op_bt["act_w2"];
        $cost_op_bt_actual_w3 = $data_cost_op_bt["act_w3"];
        $cost_op_bt_actual_w4 = $data_cost_op_bt["act_w4"];
        $cost_op_bt_actual_w5 = $data_cost_op_bt["act_w5"];
        //BT Operasional KPI COST data bulan lalu
        $data_cost_op_bt_prev = $this->get_data_cost_bt($prev_period)->row_array();
        $data_act_cost_op_bt_prev = $this->get_cost_sales($prev_period)->row_array();
        $cost_op_bt_actual_prev = $data_cost_op_bt_prev['act_budget'] / $data_act_cost_op_bt_prev['target'] * 100;

        // BT operasional KPI Service Excellent

        // SPG Excellent
        $dt_temuan_cctv = $this->data_temuan_cctv($periode)->row_array();
        $temuan_cctv_indicator = $dt_temuan_cctv['indicator'];
        $temuan_cctv_actual = $dt_temuan_cctv['actual'];
        $temuan_cctv_actual_w1 = $dt_temuan_cctv['actual_w1'];
        $temuan_cctv_actual_w2 = $dt_temuan_cctv['actual_w2'];
        $temuan_cctv_actual_w3 = $dt_temuan_cctv['actual_w3'];
        $temuan_cctv_actual_w4 = $dt_temuan_cctv['actual_w4'];
        $temuan_cctv_actual_w5 = $dt_temuan_cctv['actual_w5'];
        $temuan_cctv_actual_w6 = $dt_temuan_cctv['actual_w6'];

        $dt_roleplay = $this->data_roleplay($periode)->row_array();
        $roleplay_indicator = $dt_roleplay['indicator'];
        $roleplay_actual = $dt_roleplay['actual'];
        $roleplay_actual_w1 = $dt_roleplay['actual_w1'];
        $roleplay_actual_w2 = $dt_roleplay['actual_w2'];
        $roleplay_actual_w3 = $dt_roleplay['actual_w3'];
        $roleplay_actual_w4 = $dt_roleplay['actual_w4'];
        $roleplay_actual_w5 = $dt_roleplay['actual_w5'];
        $roleplay_actual_w6 = $dt_roleplay['actual_w6'];

        // Kueri gabung SPG Excellent
        $query_gabung_spg = "SELECT 
                                'Peningkatan SPG Excellent' AS indicator,
                                SUM(actual_w1) AS actual_w1,
                                SUM(actual_w2) AS actual_w2,
                                SUM(actual_w3) AS actual_w3,
                                SUM(actual_w4) AS actual_w4,
                                SUM(actual_w5) AS actual_w5,
                                SUM(actual_w6) AS actual_w6,
                                SUM(actual) AS actual 
                            FROM (
                                -- Temuan CCTV
                                SELECT '$temuan_cctv_indicator' AS indicator, 
                                    $temuan_cctv_actual_w1 AS actual_w1,
                                    $temuan_cctv_actual_w2 AS actual_w2,
                                    $temuan_cctv_actual_w3 AS actual_w3,
                                    $temuan_cctv_actual_w4 AS actual_w4,
                                    $temuan_cctv_actual_w5 AS actual_w5,
                                    $temuan_cctv_actual_w6 AS actual_w6,
                                    $temuan_cctv_actual AS actual
                                UNION ALL
                                SELECT '$roleplay_indicator' AS indicator, 
                                    $roleplay_actual_w1 AS actual_w1,
                                    $roleplay_actual_w2 AS actual_w2,
                                    $roleplay_actual_w3 AS actual_w3,
                                    $roleplay_actual_w4 AS actual_w4,
                                    $roleplay_actual_w5 AS actual_w5,
                                    $roleplay_actual_w6 AS actual_w6,
                                    $roleplay_actual AS actual
                            ) dtx_spg";
        // var_dump($query_gabung_spg); die();

        // Kasir Excellent
        $dt_kasir_excellent_1_4 = $this->data_kasir_excellent_1_4($periode)->result_array();
        // var_dump($dt_kasir_excellent_1_4); echo '<br>';

        $kecepatan_kasir_indicator = $dt_kasir_excellent_1_4[0]['indicator'];
        $kecepatan_kasir_target = $dt_kasir_excellent_1_4[0]['target'];
        $kecepatan_kasir_actual = $dt_kasir_excellent_1_4[0]['actual'];
        $kecepatan_kasir_persen_acv = $dt_kasir_excellent_1_4[0]['persen_acv'];
        $kecepatan_kasir_nilai = $dt_kasir_excellent_1_4[0]['nilai'];

        $kecepatan_kasir_target_w1 = $dt_kasir_excellent_1_4[0]['target_w1'];
        $kecepatan_kasir_actual_w1 = $dt_kasir_excellent_1_4[0]['actual_w1'];
        $kecepatan_kasir_persen_acv_w1 = $dt_kasir_excellent_1_4[0]['persen_acv_w1'];
        $kecepatan_kasir_nilai_w1 = $dt_kasir_excellent_1_4[0]['nilai_w1'];

        $kecepatan_kasir_target_w2 = $dt_kasir_excellent_1_4[0]['target_w2'];
        $kecepatan_kasir_actual_w2 = $dt_kasir_excellent_1_4[0]['actual_w2'];
        $kecepatan_kasir_persen_acv_w2 = $dt_kasir_excellent_1_4[0]['persen_acv_w2'];
        $kecepatan_kasir_nilai_w2 = $dt_kasir_excellent_1_4[0]['nilai_w2'];

        $kecepatan_kasir_target_w3 = $dt_kasir_excellent_1_4[0]['target_w3'];
        $kecepatan_kasir_actual_w3 = $dt_kasir_excellent_1_4[0]['actual_w3'];
        $kecepatan_kasir_persen_acv_w3 = $dt_kasir_excellent_1_4[0]['persen_acv_w3'];
        $kecepatan_kasir_nilai_w3 = $dt_kasir_excellent_1_4[0]['nilai_w3'];

        $kecepatan_kasir_target_w4 = $dt_kasir_excellent_1_4[0]['target_w4'];
        $kecepatan_kasir_actual_w4 = $dt_kasir_excellent_1_4[0]['actual_w4'];
        $kecepatan_kasir_persen_acv_w4 = $dt_kasir_excellent_1_4[0]['persen_acv_w4'];
        $kecepatan_kasir_nilai_w4 = $dt_kasir_excellent_1_4[0]['nilai_w4'];

        $kecepatan_kasir_target_w5 = $dt_kasir_excellent_1_4[0]['target_w5'];
        $kecepatan_kasir_actual_w5 = $dt_kasir_excellent_1_4[0]['actual_w5'];
        $kecepatan_kasir_persen_acv_w5 = $dt_kasir_excellent_1_4[0]['persen_acv_w5'];
        $kecepatan_kasir_nilai_w5 = $dt_kasir_excellent_1_4[0]['nilai_w5'];

        $kecepatan_kasir_target_w6 = $dt_kasir_excellent_1_4[0]['target_w6'];
        $kecepatan_kasir_actual_w6 = $dt_kasir_excellent_1_4[0]['actual_w6'];
        $kecepatan_kasir_persen_acv_w6 = $dt_kasir_excellent_1_4[0]['persen_acv_w6'];
        $kecepatan_kasir_nilai_w6 = $dt_kasir_excellent_1_4[0]['nilai_w6'];



        // Selisih Kasir
        $selisih_kasir_indicator = $dt_kasir_excellent_1_4[1]['indicator'];
        $selisih_kasir_target = $dt_kasir_excellent_1_4[1]['target'];
        $selisih_kasir_actual = $dt_kasir_excellent_1_4[1]['actual'];
        $selisih_kasir_persen_acv = $dt_kasir_excellent_1_4[1]['persen_acv'];
        $selisih_kasir_nilai = $dt_kasir_excellent_1_4[1]['nilai'];
        for ($w = 1; $w <= 6; $w++) {
            ${"selisih_kasir_target_w{$w}"} = $dt_kasir_excellent_1_4[1]["target_w{$w}"];
            ${"selisih_kasir_actual_w{$w}"} = $dt_kasir_excellent_1_4[1]["actual_w{$w}"];
            ${"selisih_kasir_persen_acv_w{$w}"} = $dt_kasir_excellent_1_4[1]["persen_acv_w{$w}"];
            ${"selisih_kasir_nilai_w{$w}"} = $dt_kasir_excellent_1_4[1]["nilai_w{$w}"];
        }

        // Scaleup Kasir
        $scaleup_kasir_indicator = $dt_kasir_excellent_1_4[2]['indicator'];
        $scaleup_kasir_target = $dt_kasir_excellent_1_4[2]['target'];
        $scaleup_kasir_actual = $dt_kasir_excellent_1_4[2]['actual'];
        $scaleup_kasir_persen_acv = $dt_kasir_excellent_1_4[2]['persen_acv'];
        $scaleup_kasir_nilai = $dt_kasir_excellent_1_4[2]['nilai'];
        for ($w = 1; $w <= 6; $w++) {
            ${"scaleup_kasir_target_w{$w}"} = $dt_kasir_excellent_1_4[2]["target_w{$w}"];
            ${"scaleup_kasir_actual_w{$w}"} = $dt_kasir_excellent_1_4[2]["actual_w{$w}"];
            ${"scaleup_kasir_persen_acv_w{$w}"} = $dt_kasir_excellent_1_4[2]["persen_acv_w{$w}"];
            ${"scaleup_kasir_nilai_w{$w}"} = $dt_kasir_excellent_1_4[2]["nilai_w{$w}"];
        }
        // var_dump($scaleup_kasir_nilai_w5); die;

        // Kelolosan Tag
        $kelolosan_tag_indicator = $dt_kasir_excellent_1_4[3]['indicator'];
        $kelolosan_tag_target = $dt_kasir_excellent_1_4[3]['target'];
        $kelolosan_tag_actual = $dt_kasir_excellent_1_4[3]['actual'];
        $kelolosan_tag_persen_acv = $dt_kasir_excellent_1_4[3]['persen_acv'];
        $kelolosan_tag_nilai = $dt_kasir_excellent_1_4[3]['nilai'];
        for ($w = 1; $w <= 6; $w++) {
            ${"kelolosan_tag_target_w{$w}"} = $dt_kasir_excellent_1_4[3]["target_w{$w}"];
            ${"kelolosan_tag_actual_w{$w}"} = $dt_kasir_excellent_1_4[3]["actual_w{$w}"];
            ${"kelolosan_tag_persen_acv_w{$w}"} = $dt_kasir_excellent_1_4[3]["persen_acv_w{$w}"];
            ${"kelolosan_tag_nilai_w{$w}"} = $dt_kasir_excellent_1_4[3]["nilai_w{$w}"];
        }

        // Temuan CCTV Kasir
        $dt_kasir_excellent_5 = $this->data_temuan_cctv_kasir($periode)->row_array();

        $temuan_cctv_kasir_indicator = $dt_kasir_excellent_5['indicator'];
        $temuan_cctv_kasir_target = $dt_kasir_excellent_5['target'];
        $temuan_cctv_kasir_actual = $dt_kasir_excellent_5['actual'];
        $temuan_cctv_kasir_persen_acv = $dt_kasir_excellent_5['persen_acv'];
        $temuan_cctv_kasir_nilai = $dt_kasir_excellent_5['nilai'];
        for ($w = 1; $w <= 6; $w++) {
            ${"temuan_cctv_kasir_target_w{$w}"} = $dt_kasir_excellent_5["target_w{$w}"];
            ${"temuan_cctv_kasir_actual_w{$w}"} = $dt_kasir_excellent_5["actual_w{$w}"];
            ${"temuan_cctv_kasir_persen_acv_w{$w}"} = $dt_kasir_excellent_5["persen_acv_w{$w}"];
            ${"temuan_cctv_kasir_nilai_w{$w}"} = $dt_kasir_excellent_5["nilai_w{$w}"];
        }

        // Kueri gabung Kasir Excellent
        $query_gabung_kasir = "SELECT
                                'Peningkatan Kasir Excellent' AS indicator,
                                ROUND(AVG(persen_acv_w1)) AS actual_w1,
                                ROUND(AVG(persen_acv_w3)) AS actual_w2,
                                ROUND(AVG(persen_acv_w3)) AS actual_w3,
                                ROUND(AVG(persen_acv_w4)) AS actual_w4,
                                COALESCE(ROUND(AVG(persen_acv_w5)), 0) AS actual_w5,
                                COALESCE(ROUND(AVG(persen_acv_w6)), 0) AS actual_w6,
                                ROUND(AVG(persen_acv)) AS actual
                            FROM (
                                SELECT
                                    indicator,
                                    `target`,
                                    actual,
                                    persen_acv,
                                    nilai,
                                    target_w1, actual_w1, persen_acv_w1, nilai_w1,
                                    target_w2, actual_w2, persen_acv_w2, nilai_w2,
                                    target_w3, actual_w3, persen_acv_w3, nilai_w3,
                                    target_w4, actual_w4, persen_acv_w4, nilai_w4,
                                    target_w5, actual_w5, persen_acv_w5, nilai_w5,
                                    target_w6, actual_w6, persen_acv_w6, nilai_w6
                                FROM (
                                    SELECT
                                        '$kecepatan_kasir_indicator' AS indicator,
                                        $kecepatan_kasir_target AS `target`,
                                        $kecepatan_kasir_actual AS actual,
                                        $kecepatan_kasir_persen_acv AS persen_acv,
                                        $kecepatan_kasir_nilai AS nilai,
                                        $kecepatan_kasir_target_w1 AS target_w1,
                                        $kecepatan_kasir_actual_w1 AS actual_w1,
                                        $kecepatan_kasir_persen_acv_w1 AS persen_acv_w1,
                                        $kecepatan_kasir_nilai_w1 AS nilai_w1,
                                        $kecepatan_kasir_target_w2 AS target_w2,
                                        $kecepatan_kasir_actual_w2 AS actual_w2,
                                        $kecepatan_kasir_persen_acv_w2 AS persen_acv_w2,
                                        $kecepatan_kasir_nilai_w2 AS nilai_w2,
                                        $kecepatan_kasir_target_w3 AS target_w3,
                                        $kecepatan_kasir_actual_w3 AS actual_w3,
                                        $kecepatan_kasir_persen_acv_w3 AS persen_acv_w3,
                                        $kecepatan_kasir_nilai_w3 AS nilai_w3,
                                        $kecepatan_kasir_target_w4 AS target_w4,
                                        $kecepatan_kasir_actual_w4 AS actual_w4,
                                        $kecepatan_kasir_persen_acv_w4 AS persen_acv_w4,
                                        $kecepatan_kasir_nilai_w4 AS nilai_w4,
                                        $kecepatan_kasir_target_w5 AS target_w5,
                                        $kecepatan_kasir_actual_w5 AS actual_w5,
                                        $kecepatan_kasir_persen_acv_w5 AS persen_acv_w5,
                                        $kecepatan_kasir_nilai_w5 AS nilai_w5,
                                        $kecepatan_kasir_target_w6 AS target_w6,
                                        $kecepatan_kasir_actual_w6 AS actual_w6,
                                        $kecepatan_kasir_persen_acv_w6 AS persen_acv_w6,
                                        $kecepatan_kasir_nilai_w6 AS nilai_w6
                                    UNION ALL
                                    SELECT
                                        '$selisih_kasir_indicator' AS indicator,
                                        $selisih_kasir_target AS `target`,
                                        $selisih_kasir_actual AS actual,
                                        $selisih_kasir_persen_acv AS persen_acv,
                                        $selisih_kasir_nilai AS nilai,
                                        $selisih_kasir_target_w1 AS target_w1,
                                        $selisih_kasir_actual_w1 AS actual_w1,
                                        $selisih_kasir_persen_acv_w1 AS persen_acv_w1,
                                        $selisih_kasir_nilai_w1 AS nilai_w1,
                                        $selisih_kasir_target_w2 AS target_w2,
                                        $selisih_kasir_actual_w2 AS actual_w2,
                                        $selisih_kasir_persen_acv_w2 AS persen_acv_w2,
                                        $selisih_kasir_nilai_w2 AS nilai_w2,
                                        $selisih_kasir_target_w3 AS target_w3,
                                        $selisih_kasir_actual_w3 AS actual_w3,
                                        $selisih_kasir_persen_acv_w3 AS persen_acv_w3,
                                        $selisih_kasir_nilai_w3 AS nilai_w3,
                                        $selisih_kasir_target_w4 AS target_w4,
                                        $selisih_kasir_actual_w4 AS actual_w4,
                                        $selisih_kasir_persen_acv_w4 AS persen_acv_w4,
                                        $selisih_kasir_nilai_w4 AS nilai_w4,
                                        $selisih_kasir_target_w5 AS target_w5,
                                        $selisih_kasir_actual_w5 AS actual_w5,
                                        $selisih_kasir_persen_acv_w5 AS persen_acv_w5,
                                        $selisih_kasir_nilai_w5 AS nilai_w5,
                                        $selisih_kasir_target_w6 AS target_w6,
                                        $selisih_kasir_actual_w6 AS actual_w6,
                                        $selisih_kasir_persen_acv_w6 AS persen_acv_w6,
                                        $selisih_kasir_nilai_w6 AS nilai_w6
                                    UNION ALL
                                    SELECT
                                        '$scaleup_kasir_indicator' AS indicator,
                                        $scaleup_kasir_target AS `target`,
                                        $scaleup_kasir_actual AS actual,
                                        $scaleup_kasir_persen_acv AS persen_acv,
                                        $scaleup_kasir_nilai AS nilai,
                                        $scaleup_kasir_target_w1 AS target_w1,
                                        $scaleup_kasir_actual_w1 AS actual_w1,
                                        $scaleup_kasir_persen_acv_w1 AS persen_acv_w1,
                                        $scaleup_kasir_nilai_w1 AS nilai_w1,
                                        $scaleup_kasir_target_w2 AS target_w2,
                                        $scaleup_kasir_actual_w2 AS actual_w2,
                                        $scaleup_kasir_persen_acv_w2 AS persen_acv_w2,
                                        $scaleup_kasir_nilai_w2 AS nilai_w2,
                                        $scaleup_kasir_target_w3 AS target_w3,
                                        $scaleup_kasir_actual_w3 AS actual_w3,
                                        $scaleup_kasir_persen_acv_w3 AS persen_acv_w3,
                                        $scaleup_kasir_nilai_w3 AS nilai_w3,
                                        $scaleup_kasir_target_w4 AS target_w4,
                                        $scaleup_kasir_actual_w4 AS actual_w4,
                                        $scaleup_kasir_persen_acv_w4 AS persen_acv_w4,
                                        $scaleup_kasir_nilai_w4 AS nilai_w4,
                                        $scaleup_kasir_target_w5 AS target_w5,
                                        $scaleup_kasir_actual_w5 AS actual_w5,
                                        $scaleup_kasir_persen_acv_w5 AS persen_acv_w5,
                                        $scaleup_kasir_nilai_w5 AS nilai_w5,
                                        $scaleup_kasir_target_w6 AS target_w6,
                                        $scaleup_kasir_actual_w6 AS actual_w6,
                                        $scaleup_kasir_persen_acv_w6 AS persen_acv_w6,
                                        $scaleup_kasir_nilai_w6 AS nilai_w6
                                    UNION ALL
                                    SELECT
                                        '$kelolosan_tag_indicator' AS indicator,
                                        $kelolosan_tag_target AS `target`,
                                        $kelolosan_tag_actual AS actual,
                                        $kelolosan_tag_persen_acv AS persen_acv,
                                        $kelolosan_tag_nilai AS nilai,
                                        $kelolosan_tag_target_w1 AS target_w1,
                                        $kelolosan_tag_actual_w1 AS actual_w1,
                                        $kelolosan_tag_persen_acv_w1 AS persen_acv_w1,
                                        $kelolosan_tag_nilai_w1 AS nilai_w1,
                                        $kelolosan_tag_target_w2 AS target_w2,
                                        $kelolosan_tag_actual_w2 AS actual_w2,
                                        $kelolosan_tag_persen_acv_w2 AS persen_acv_w2,
                                        $kelolosan_tag_nilai_w2 AS nilai_w2,
                                        $kelolosan_tag_target_w3 AS target_w3,
                                        $kelolosan_tag_actual_w3 AS actual_w3,
                                        $kelolosan_tag_persen_acv_w3 AS persen_acv_w3,
                                        $kelolosan_tag_nilai_w3 AS nilai_w3,
                                        $kelolosan_tag_target_w4 AS target_w4,
                                        $kelolosan_tag_actual_w4 AS actual_w4,
                                        $kelolosan_tag_persen_acv_w4 AS persen_acv_w4,
                                        $kelolosan_tag_nilai_w4 AS nilai_w4,
                                        $kelolosan_tag_target_w5 AS target_w5,
                                        $kelolosan_tag_actual_w5 AS actual_w5,
                                        $kelolosan_tag_persen_acv_w5 AS persen_acv_w5,
                                        $kelolosan_tag_nilai_w5 AS nilai_w5,
                                        $kelolosan_tag_target_w6 AS target_w6,
                                        $kelolosan_tag_actual_w6 AS actual_w6,
                                        $kelolosan_tag_persen_acv_w6 AS persen_acv_w6,
                                        $kelolosan_tag_nilai_w6 AS nilai_w6
                                    UNION ALL
                                    SELECT
                                        '$temuan_cctv_kasir_indicator' AS indicator,
                                        $temuan_cctv_kasir_target AS `target`,
                                        $temuan_cctv_kasir_actual AS actual,
                                        $temuan_cctv_kasir_persen_acv AS persen_acv,
                                        $temuan_cctv_kasir_nilai AS nilai,
                                        $temuan_cctv_kasir_target_w1 AS target_w1,
                                        $temuan_cctv_kasir_actual_w1 AS actual_w1,
                                        $temuan_cctv_kasir_persen_acv_w1 AS persen_acv_w1,
                                        $temuan_cctv_kasir_nilai_w1 AS nilai_w1,
                                        $temuan_cctv_kasir_target_w2 AS target_w2,
                                        $temuan_cctv_kasir_actual_w2 AS actual_w2,
                                        $temuan_cctv_kasir_persen_acv_w2 AS persen_acv_w2,
                                        $temuan_cctv_kasir_nilai_w2 AS nilai_w2,
                                        $temuan_cctv_kasir_target_w3 AS target_w3,
                                        $temuan_cctv_kasir_actual_w3 AS actual_w3,
                                        $temuan_cctv_kasir_persen_acv_w3 AS persen_acv_w3,
                                        $temuan_cctv_kasir_nilai_w3 AS nilai_w3,
                                        $temuan_cctv_kasir_target_w4 AS target_w4,
                                        $temuan_cctv_kasir_actual_w4 AS actual_w4,
                                        $temuan_cctv_kasir_persen_acv_w4 AS persen_acv_w4,
                                        $temuan_cctv_kasir_nilai_w4 AS nilai_w4,
                                        $temuan_cctv_kasir_target_w5 AS target_w5,
                                        $temuan_cctv_kasir_actual_w5 AS actual_w5,
                                        $temuan_cctv_kasir_persen_acv_w5 AS persen_acv_w5,
                                        $temuan_cctv_kasir_nilai_w5 AS nilai_w5,
                                        $temuan_cctv_kasir_target_w6 AS target_w6,
                                        $temuan_cctv_kasir_actual_w6 AS actual_w6,
                                        $temuan_cctv_kasir_persen_acv_w6 AS persen_acv_w6,
                                        $temuan_cctv_kasir_nilai_w6 AS nilai_w6
                                ) AS combined_data
                            ) AS kasir_excellent";

        // WH excellent
        $dt_wh_excellent = $this->data_wh_excellent($periode);
        
        $wh_excellent_indicator = $dt_wh_excellent['indicator'];
        $wh_excellent_actual_w1 = $dt_wh_excellent['actual_w1'];
        $wh_excellent_actual_w2 = $dt_wh_excellent['actual_w2'];
        $wh_excellent_actual_w3 = $dt_wh_excellent['actual_w3'];
        $wh_excellent_actual_w4 = $dt_wh_excellent['actual_w4'];
        $wh_excellent_actual_w5 = $dt_wh_excellent['actual_w5'];
        $wh_excellent_actual_w6 = $dt_wh_excellent['actual_w6'];
        $wh_excellent_actual = $dt_wh_excellent['actual'];

        $query_gabung_wh = "SELECT indicator, actual_w1, actual_w2, actual_w3, actual_w4, actual_w5, actual_w6, actual FROM (
                                    SELECT
                                        '$wh_excellent_indicator' AS indicator,
                                        $wh_excellent_actual_w1 AS actual_w1,
                                        $wh_excellent_actual_w2 AS actual_w2,
                                        $wh_excellent_actual_w3 AS actual_w3,
                                        $wh_excellent_actual_w4 AS actual_w4,
                                        $wh_excellent_actual_w5 AS actual_w5,
                                        $wh_excellent_actual_w6 AS actual_w6,
                                        $wh_excellent_actual AS actual
                                ) wh_excellent";
        // var_dump($query_gabung_wh); die();

        // SERVICE EXCELLENT
        $query_gabung_service_excellent = "SELECT
                                                ROUND(AVG(actual), 2) AS actual,
                                                'Service Excellent' AS indicator,
                                                ROUND(AVG(actual_w1), 2) AS actual_w1,
                                                ROUND(AVG(actual_w2), 2) AS actual_w2,
                                                ROUND(AVG(actual_w3), 2) AS actual_w3,
                                                ROUND(AVG(actual_w4), 2) AS actual_w4,
                                                COALESCE(ROUND(AVG(actual_w5), 2), 0) AS actual_w5, 
                                                COALESCE(ROUND(AVG(actual_w6), 2), 0) AS actual_w6 
                                            FROM (

                                                $query_gabung_kasir
                                                UNION ALL
                                                $query_gabung_spg
                                                UNION ALL
                                                $query_gabung_wh
                                                    
                                            ) AS final";

        // var_dump($query_gabung_service_excellent); die;

        $data_op_bt_service_excellent = $this->db->query($query_gabung_service_excellent)->row_array();
        // var_dump($data_op_bt_service_excellent); die;

        $service_excellent_actual = $data_op_bt_service_excellent['actual'];
        $service_excellent_indicator = $data_op_bt_service_excellent['indicator'];
        $service_excellent_actual_w1 = $data_op_bt_service_excellent['actual_w1'];
        $service_excellent_actual_w2 = $data_op_bt_service_excellent['actual_w2'];
        $service_excellent_actual_w3 = $data_op_bt_service_excellent['actual_w3'];
        $service_excellent_actual_w4 = $data_op_bt_service_excellent['actual_w4'];
        $service_excellent_actual_w5 = $data_op_bt_service_excellent['actual_w5'];


        // KUERI GABUNGAN
        $query_gabung = "SELECT actual, indicator, periode, actual_w1, persen_w1, actual_w2, persen_w2, actual_w3, persen_w3, actual_w4, persen_w4, actual_w5, persen_w5 FROM (
                            -- Oprasional BT
                            SELECT $cost_op_bt_actual AS actual, '$cost_op_bt_indicator' AS indicator, '$periode' AS periode,
                                $cost_op_bt_actual_w1 AS actual_w1, 0 AS persen_w1,
                                $cost_op_bt_actual_w2 AS actual_w2, 0 AS persen_w2, 
                                $cost_op_bt_actual_w3 AS actual_w3, 0 AS persen_w3,
                                $cost_op_bt_actual_w4 AS actual_w4, 0 AS persen_w4,
                                $cost_op_bt_actual_w5 AS actual_w5, 0 AS persen_w5
                            UNION ALL
                            SELECT $op_bt_revenue_sales_actual AS actual, '$op_bt_revenue_sales_indicator' AS indicator, '$periode' AS periode,
                                $op_bt_revenue_sales_actual_w1 AS actual_w1, 0 AS persen_w1,
                                $op_bt_revenue_sales_actual_w2 AS actual_w2, 0 AS persen_w2, 
                                $op_bt_revenue_sales_actual_w3 AS actual_w3, 0 AS persen_w3,
                                $op_bt_revenue_sales_actual_w4 AS actual_w4, 0 AS persen_w4,
                                $op_bt_revenue_sales_actual_w5 AS actual_w5, 0 AS persen_w5
                            UNION ALL
                            SELECT $service_excellent_actual AS actual, '$service_excellent_indicator' AS indicator, '$periode' AS periode,
                                $service_excellent_actual_w1 AS actual_w1, 0 AS persen_w1,
                                $service_excellent_actual_w2 AS actual_w2, 0 AS persen_w2, 
                                $service_excellent_actual_w3 AS actual_w3, 0 AS persen_w3,
                                $service_excellent_actual_w4 AS actual_w4, 0 AS persen_w4,
                                $service_excellent_actual_w5 AS actual_w5, 0 AS persen_w5
                            UNION ALL
                            SELECT $mk_offline_bt AS actual, '$op_bt_mk_offline_indicator' AS indicator, '$periode' AS periode,
                                $mk_offline_bt_w1 AS actual_w1, 0 AS persen_w1,
                                $mk_offline_bt_w2 AS actual_w2, 0 AS persen_w2, 
                                $mk_offline_bt_w3 AS actual_w3, 0 AS persen_w3,
                                $mk_offline_bt_w4 AS actual_w4, 0 AS persen_w4,
                                $mk_offline_bt_w5 AS actual_w5, 0 AS persen_w5
                        ) dtx";

        // KUERI GABUNGAN HISTORY
        $query_gabung_history = "SELECT actual, indicator, periode FROM (
                                SELECT $cost_op_bt_actual_prev AS actual, '$cost_op_bt_indicator' AS indicator, '$prev_period' AS periode 
                        ) dtx";

        // Kueri clean dari comment
        $query = "SELECT
                            kpi.periode,
                            kpi.id AS id_kpi,
                            kpi.indicator,
                            CASE 
                                WHEN kpi.indicator = 'Missing Product' THEN -((kpi.target / 100) * kpi30.actual_kpi_30)
                                ELSE kpi.target
                            END AS `target`, 
                            kpi.tipe_target,
                            kpi.jenis_target,
                            kpi.bobot,
                            t.actual,
                            
                            CASE
                                WHEN kpi.indicator = 'Missing Product' THEN
                                    ROUND( 100 - ((t.actual / ( -(kpi.target / 100) * kpi30.actual_kpi_30 )  ) * 100), 2 )
                                ELSE
                                    IF(kpi.jenis_target = 'up', ROUND((t.actual / kpi.target) * 100, 2), 
                                    ROUND((1 - ((t.actual-kpi.target) / kpi.target)) * 100, 2) )  
                            END AS achieve, 

                            get_measurement.measurement AS measurement,
                            sq_skor.skor,
                            IF(get_measurement.measurement IS NOT NULL, 
                                (kpi.bobot / sq_measurement.total) * sq_skor.skor, 
                                CASE
                                    WHEN kpi.indicator = 'Missing Product' THEN
                                        ROUND( ( (100 - ((t.actual / ( -((kpi.target / 100) * kpi30.actual_kpi_30) )  ) * 100)) / 100 ) * kpi.bobot, 2 )
                                    ELSE
                                        ROUND((( 
                                            IF(kpi.jenis_target = 'up', ROUND((t.actual / kpi.target) * 100, 2), 
                                                            ROUND((1 - ((t.actual-kpi.target) / kpi.target)) * 100, 2) )
                                            / 100) * (kpi.bobot/100)) * 100, 2)
                                END
                        ) AS realisasi,

                            SUBSTR(CONCAT(kpi.periode, '-01') - INTERVAL 1 MONTH, 1, 7) AS last_periode,
                            sq_prev_period.prev_target,
                            sq_prev_period.prev_actual,
                            sq_prev_period.prev_achieve,
                            
                            -- from felisa
                            t.target_per_week,
                            t.jumlah_week,
                            -- weekdev
                            t.actual_w1,
                            t.actual_w2,
                            t.actual_w3,
                            t.actual_w4,
                            t.actual_w5,
                            CASE
                                WHEN kpi.indicator IN('Revenue Sales', 'Cost', 'Service Excellent', 'Marketing Offline') THEN
                                ROUND(kpi.target, 2)
                                ELSE
                                ROUND((t.actual_w1 / NULLIF(t.actual_w1 + t.actual_w2 + t.actual_w3 + t.actual_w4, 0)) * kpi.target, 2)
                            END AS target_w1,
                            CASE
                                WHEN kpi.indicator IN('Revenue Sales', 'Cost', 'Service Excellent', 'Marketing Offline') THEN
                                ROUND(kpi.target, 2)
                                ELSE
                                ROUND((t.actual_w2 / NULLIF(t.actual_w1 + t.actual_w2 + t.actual_w3 + t.actual_w4, 0)) * kpi.target, 2)
                            END AS target_w2,
                            CASE
                                WHEN kpi.indicator IN('Revenue Sales', 'Cost', 'Service Excellent', 'Marketing Offline') THEN
                                ROUND(kpi.target, 2)
                                ELSE
                                ROUND((t.actual_w3 / NULLIF(t.actual_w1 + t.actual_w2 + t.actual_w3 + t.actual_w4, 0)) * kpi.target, 2)
                            END AS target_w3,
                            CASE
                                WHEN kpi.indicator IN('Revenue Sales', 'Cost', 'Service Excellent', 'Marketing Offline') THEN
                                ROUND(kpi.target, 2)
                                ELSE
                                ROUND((t.actual_w4 / NULLIF(t.actual_w1 + t.actual_w2 + t.actual_w3 + t.actual_w4, 0)) * kpi.target, 2)
                            END AS target_w4,
                            CASE
                                WHEN kpi.indicator IN('Revenue Sales', 'Cost', 'Service Excellent', 'Marketing Offline') THEN
                                ROUND(kpi.target, 2)
                                ELSE
                                ROUND((t.actual_w5 / NULLIF(t.actual_w1 + t.actual_w2 + t.actual_w3 + t.actual_w4 + t.actual_w5, 0)) * kpi.target, 2)
                            END AS target_w5,
                            
                            LEAST(
                                CASE
                                    WHEN kpi.indicator IN('Revenue Sales', 'Cost', 'Service Excellent', 'Marketing Offline') THEN
                                    ROUND((t.actual_w1 / kpi.target) * 100, 2)
                                    ELSE
                                    ROUND((t.actual_w1 / t.target_per_week) * 100, 2)
                                END
                            , 100) AS persen_w1,
                            LEAST(
                            CASE
                                WHEN kpi.indicator IN('Revenue Sales', 'Cost', 'Service Excellent', 'Marketing Offline') THEN
                                ROUND((t.actual_w2 / kpi.target) * 100, 2)
                                ELSE
                                ROUND((t.actual_w2 / t.target_per_week) * 100, 2)
                            END 
                            , 100) AS persen_w2,
                            LEAST(
                            CASE
                                WHEN kpi.indicator IN('Revenue Sales', 'Cost', 'Service Excellent', 'Marketing Offline') THEN
                                ROUND((t.actual_w3 / kpi.target) * 100, 2)
                                ELSE
                                ROUND((t.actual_w3 / t.target_per_week) * 100, 2)
                            END 
                            , 100) AS persen_w3,
                            LEAST(
                            CASE
                                WHEN kpi.indicator IN('Revenue Sales', 'Cost', 'Service Excellent', 'Marketing Offline') THEN
                                ROUND((t.actual_w4 / kpi.target) * 100, 2)
                                ELSE
                                ROUND((t.actual_w4 / t.target_per_week) * 100, 2)
                            END 
                            , 100) AS persen_w4,

                            LEAST(CASE
                                WHEN kpi.indicator IN('Revenue Sales', 'Cost', 'Service Excellent', 'Marketing Offline') THEN
                                ROUND((t.actual_w5 / kpi.target) * 100, 2)
                                ELSE
                                ROUND((t.actual_w5 / t.target_per_week) * 100, 2)
                            END, 100) AS persen_w5

                    FROM
                            hris.m_kpi_retail kpi
                            JOIN (
                                SELECT 
                                    m_kpi_retail.id AS id_kpi,
                                    m_kpi_retail.indicator, 
                                    CASE 
                                        WHEN sq_dt_actual.actual IS NOT NULL THEN sq_dt_actual.actual
                                        ELSE ROUND(t_kpi_retail.actual,2) END AS actual,
                                    -- from felisa
                                    kpi_week.jumlah_week,
                                    ROUND(m_kpi_retail.target / kpi_week.jumlah_week, 2) AS target_per_week,
                                    sq_dt_actual.actual_w1,
                                    sq_dt_actual.persen_w1,
                                    sq_dt_actual.actual_w2,
                                    sq_dt_actual.persen_w2,
                                    sq_dt_actual.actual_w3,
                                    sq_dt_actual.persen_w3,
                                    sq_dt_actual.actual_w4,
                                    sq_dt_actual.persen_w4,
                                    sq_dt_actual.actual_w5,
                                    sq_dt_actual.persen_w5
                                FROM 
                                    hris.t_kpi_retail AS t_kpi_retail
                                    JOIN hris.m_kpi_retail ON t_kpi_retail.id_kpi = m_kpi_retail.id

                                    LEFT JOIN (
                                        SELECT
                                            periode,
                                            COUNT(*) AS jumlah_week
                                        FROM hris.m_kpi_week
                                        GROUP BY periode
                                    ) kpi_week ON kpi_week.periode = m_kpi_retail.periode
                                    
                                    LEFT JOIN (
                                            SELECT actual, indicator, periode, actual_w1, persen_w1, actual_w2, persen_w2, actual_w3, persen_w3, actual_w4, persen_w4, actual_w5, persen_w5  FROM (
                                                        $query_gabung
                                                    ) dt_actual
                                    ) sq_dt_actual ON m_kpi_retail.indicator = sq_dt_actual.indicator AND m_kpi_retail.periode = sq_dt_actual.periode
                            ) t ON kpi.id = t.id_kpi 

                            LEFT JOIN (
                                    SELECT
                                            id_kpi,
                                            GROUP_CONCAT( DISTINCT skor, '|', START, '|', END ) AS measurement 
                                    FROM
                                            hris.m_kpi_retail_measurement 
                                    GROUP BY id_kpi
                            ) AS get_measurement ON get_measurement.id_kpi = kpi.id
                            LEFT JOIN (
                                SELECT
                                    kpi.id AS id_kpi,
                                    CASE
                                            WHEN kpi.id = 1 THEN 
                                                    CASE
                                                            WHEN t.actual = 100 THEN '4'
                                                            WHEN t.actual >= 95 THEN '3'
                                                            WHEN t.actual >= 91 THEN '2'
                                                            ELSE '1'
                                                    END
                                            WHEN kpi.id = 2 THEN 
                                                    CASE
                                                            WHEN t.actual <= 0 THEN '4'
                                                            WHEN t.actual > 0 AND t.actual <= 2 THEN '3'
                                                            WHEN t.actual >= 3 AND t.actual <= 4 THEN '2'
                                                            ELSE '1'
                                                    END
                                            WHEN kpi.id =	3 THEN
                                                    CASE
                                                            WHEN t.actual <= 54 THEN '4'
                                                            WHEN t.actual >= 55 AND t.actual < 56 THEN '3'
                                                            WHEN t.actual >= 56 AND t.actual <= 57 THEN '2'
                                                            ELSE '1'
                                                    END
                                            WHEN kpi.id =	4 THEN
                                                    CASE
                                                            WHEN t.actual = 100 THEN '4'
                                                            WHEN t.actual >= 99 AND t.actual < 100 THEN '3'
                                                            WHEN t.actual >= 90 AND t.actual <= 98 THEN '2'
                                                            ELSE '1'
                                                    END
                                    END AS skor
                                FROM
                                    hris.m_kpi_retail kpi
                                    JOIN hris.t_kpi_retail t ON kpi.id = t.id_kpi
                                WHERE
                                    kpi.periode = '$periode'
                                    AND kpi.company = 5
                                    AND kpi.divisi = 2
                            ) AS sq_skor ON sq_skor.id_kpi = kpi.id
                            LEFT JOIN (
                                SELECT
                                    id_kpi,
                                    COUNT(id) AS total
                                FROM
                                    hris.m_kpi_retail_measurement
                                GROUP BY id_kpi
                            ) AS sq_measurement ON sq_measurement.id_kpi = kpi.id

                            -- sq_prev_period comprev
                            LEFT JOIN (
                                SELECT
                                    kpi.periode,
                                    kpi.id AS id_kpi,
                                    kpi.indicator,
                                    CASE 
                                        WHEN kpi.indicator = 'Missing Product' THEN -((kpi.target / 100) * kpi30.actual_kpi_30)
                                        ELSE kpi.target
                                    END AS prev_target,
                                    t.actual AS prev_actual,
                                    CASE
                                        WHEN kpi.indicator = 'Missing Product' THEN
                                                ROUND( 100 - ((t.actual / ( -(kpi.target / 100) * kpi30.actual_kpi_30 )  ) * 100), 2 )
                                        ELSE
                                                IF(kpi.jenis_target = 'up', ROUND((t.actual / kpi.target) * 100, 2), 
                                                ROUND((1 - ((t.actual-kpi.target) / kpi.target)) * 100, 2) ) 
                                    END AS prev_achieve
                                FROM
                                    hris.m_kpi_retail kpi
                                    JOIN (
                                        SELECT 
                                            m_kpi_retail.id AS id_kpi,
                                            m_kpi_retail.indicator, 
                                            CASE 
                                                WHEN sq_dt_actual.actual IS NOT NULL THEN sq_dt_actual.actual
                                                ELSE ROUND(t_kpi_retail.actual,2) END AS actual
                                        FROM 
                                                        hris.t_kpi_retail AS t_kpi_retail
                                                        JOIN hris.m_kpi_retail ON t_kpi_retail.id_kpi = m_kpi_retail.id
                                                        LEFT JOIN (
                                                            SELECT actual, indicator, periode FROM (
                                                                                                        
                                                                $query_gabung_history                                                  
                                                                                                        
                                                            ) dt_actual
                                                        ) sq_dt_actual ON m_kpi_retail.indicator = sq_dt_actual.indicator AND m_kpi_retail.periode = sq_dt_actual.periode
                                ) t ON kpi.id = t.id_kpi
                                    LEFT JOIN (
                                        SELECT 
                                            actual AS actual_kpi_30,
                                            periode
                                        FROM (
                                        
                                            SELECT 
                                                m_kpi_retail.id AS id_kpi,
                                                CASE 
                                                    WHEN sq_dt_actual.actual IS NOT NULL THEN sq_dt_actual.actual
                                                    ELSE ROUND(t_kpi_retail.actual, 2)
                                                END AS actual,
                                                m_kpi_retail.periode
                                            FROM hris.t_kpi_retail AS t_kpi_retail
                                            JOIN hris.m_kpi_retail ON t_kpi_retail.id_kpi = m_kpi_retail.id
                                            LEFT JOIN (
                                                SELECT actual, indicator, periode FROM (
                                                    $query_gabung_history
                                                ) dt_actual
                                            ) sq_dt_actual ON m_kpi_retail.indicator = 'Missing Product' 
                                            AND m_kpi_retail.periode = sq_dt_actual.periode
                                            WHERE 
                                                m_kpi_retail.indicator  = 'Peningkatan Sales Store'
                                                AND m_kpi_retail.periode = SUBSTR(CONCAT('$periode', '-01') - INTERVAL 1 MONTH, 1, 7)
                                                
                                        ) AS sub
                                    ) AS kpi30 ON kpi.periode = kpi30.periode

                            WHERE
                                    kpi.periode = SUBSTR(CONCAT('$periode', '-01') - INTERVAL 1 MONTH, 1, 7)
                                    AND kpi.company = 5
                                    AND kpi.divisi = 2
                            ) AS sq_prev_period ON sq_prev_period.indicator = kpi.indicator

                            LEFT JOIN (
                                SELECT 
                                    actual AS actual_kpi_30,
                                    periode
                                FROM (
                                
                                    SELECT 
                                        m_kpi_retail.id AS id_kpi,
                                        CASE 
                                            WHEN sq_dt_actual.actual IS NOT NULL THEN sq_dt_actual.actual
                                            ELSE ROUND(t_kpi_retail.actual, 2)
                                        END AS actual,
                                        m_kpi_retail.periode
                                    FROM hris.t_kpi_retail AS t_kpi_retail
                                    JOIN hris.m_kpi_retail ON t_kpi_retail.id_kpi = m_kpi_retail.id
                                    LEFT JOIN (
                                        SELECT actual, indicator, periode FROM (
                                            $query_gabung
                                        ) dt_actual
                                    ) sq_dt_actual ON m_kpi_retail.indicator = sq_dt_actual.indicator AND m_kpi_retail.periode = sq_dt_actual.periode
                                    WHERE 
                                        m_kpi_retail.indicator = 'Peningkatan Sales Store'
                                        AND m_kpi_retail.periode = '$periode'
                                        
                                ) AS sub
                            ) AS kpi30 ON kpi.periode = kpi30.periode

                    WHERE
                            kpi.periode = '$periode'
                            AND kpi.company = 5
                            AND kpi.divisi = 2";

        return $this->db->query($query)->result();
    }

    // BT Operasional DATA
    function get_data_bt_revenue_sales($periode)
    {
        $bulan = substr($periode, 5, 2);
        $tahun = substr($periode, 0, 4);

        $query = "SELECT
                    'Revenue Sales' AS indicator,
                    ROUND( SUM( achieve ) / 5, 2 ) AS actual,
                    ROUND(
                    SUM( actual )) AS actual_nominal,
                    ROUND(
                    SUM( target )) AS total_target,
                    ROUND( SUM( skor ), 2 ) AS total_skor,
                    ROUND( SUM( actual / NULLIF( target, 0 ) * bobot ) * 0.4, 2 ) AS actual_new,
                    '$periode' AS periode,
                    (
                    SELECT COALESCE
                        ( SUM( ts.amount_payment ), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 185955 ), ts.amount_payment, 0 )), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 184330, 186971, 186972 ), ts.amount_payment, 0 )), 0 ) - COALESCE (
                            SUM(
                            IF
                                (
                                    ts.customer_id IN ( 86868, 162311, 199618, 266597, 301885, 344361, 360833, 406818, 483755, 484928, 485034, 498234, 503268 ),
                                    ts.amount_payment,
                                    0 
                                )),
                            0 
                        ) AS transaksi 
                    FROM
                        t_sale ts
                        JOIN m_week_kpi wk ON wk.WEEK = '1' 
                        AND wk.periode = '$periode' 
                    WHERE
                        ts.sale_mode = 'S' 
                        AND DATE ( ts.created_at ) BETWEEN wk.START 
                        AND wk.
                    END 
                    ) AS actual_w1,
                    (
                    SELECT
                        ROUND(((
                                    COALESCE ( SUM( ts.amount_payment ), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 185955 ), ts.amount_payment, 0 )), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 184330, 186971, 186972 ), ts.amount_payment, 0 )), 0 ) - COALESCE (
                                        SUM(
                                        IF
                                            (
                                                ts.customer_id IN ( 86868, 162311, 199618, 266597, 301885, 344361, 360833, 406818, 483755, 484928, 485034, 498234, 503268 ),
                                                ts.amount_payment,
                                                0 
                                            )),
                                        0 
                                    ) 
                                    ) / ( target.target / target.jml_minggu )) * 100,
                            2 
                        ) AS persen_actual 
                    FROM
                        t_sale ts
                        JOIN m_week_kpi wk ON wk.WEEK = '1' AND wk.periode = '$periode'
                        LEFT JOIN (
                        SELECT
                            SUM( sales ) AS target,
                            ( SELECT COUNT(*) FROM m_week_kpi WHERE periode = '$periode' ) AS jml_minggu 
                        FROM
                            target_global 
                        WHERE
                            periode = '$periode' 
                        ) AS target ON 1 = 1 
                    WHERE
                        ts.sale_mode = 'S' 
                        AND DATE ( ts.created_at ) BETWEEN wk.START AND wk.END 
                    ) AS persen_w1,
                    (
                    SELECT COALESCE
                        ( SUM( ts.amount_payment ), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 185955 ), ts.amount_payment, 0 )), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 184330, 186971, 186972 ), ts.amount_payment, 0 )), 0 ) - COALESCE (
                            SUM(
                            IF
                                (
                                    ts.customer_id IN ( 86868, 162311, 199618, 266597, 301885, 344361, 360833, 406818, 483755, 484928, 485034, 498234, 503268 ),
                                    ts.amount_payment,
                                    0 
                                )),
                            0 
                        ) 
                    FROM
                        t_sale ts
                        JOIN m_week_kpi wk ON wk.WEEK = '2' AND wk.periode = '$periode' 
                    WHERE
                        ts.sale_mode = 'S' 
                        AND DATE ( ts.created_at ) BETWEEN wk.START AND wk.END 
                    ) AS actual_w2,
                    (
                    SELECT
                        ROUND(((
                                    COALESCE ( SUM( ts.amount_payment ), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 185955 ), ts.amount_payment, 0 )), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 184330, 186971, 186972 ), ts.amount_payment, 0 )), 0 ) - COALESCE (
                                        SUM(
                                        IF
                                            (
                                                ts.customer_id IN ( 86868, 162311, 199618, 266597, 301885, 344361, 360833, 406818, 483755, 484928, 485034, 498234, 503268 ),
                                                ts.amount_payment,
                                                0 
                                            )),
                                        0 
                                    ) 
                                    ) / ( target.target / target.jml_minggu )) * 100,
                            2 
                        ) AS persen_actual 
                    FROM
                        t_sale ts
                        JOIN m_week_kpi wk ON wk.WEEK = '2' AND wk.periode = '$periode'
                        LEFT JOIN (
                        SELECT
                            SUM( sales ) AS target,
                            ( SELECT COUNT(*) FROM m_week_kpi WHERE periode = '$periode' ) AS jml_minggu 
                        FROM
                            target_global 
                        WHERE
                            periode = '$periode' 
                        ) AS target ON 1 = 1 
                    WHERE
                        ts.sale_mode = 'S' 
                        AND DATE ( ts.created_at ) BETWEEN wk.START AND wk.END 
                    ) AS persen_w2,
                    (
                    SELECT COALESCE
                        ( SUM( ts.amount_payment ), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 185955 ), ts.amount_payment, 0 )), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 184330, 186971, 186972 ), ts.amount_payment, 0 )), 0 ) - COALESCE (
                            SUM(
                            IF
                                (
                                    ts.customer_id IN ( 86868, 162311, 199618, 266597, 301885, 344361, 360833, 406818, 483755, 484928, 485034, 498234, 503268 ),
                                    ts.amount_payment,
                                    0 
                                )),
                            0 
                        ) 
                    FROM
                        t_sale ts
                        JOIN m_week_kpi wk ON wk.WEEK = '3' AND wk.periode = '$periode' 
                    WHERE
                        ts.sale_mode = 'S' 
                        AND DATE ( ts.created_at ) BETWEEN wk.START AND wk.END 
                    ) AS actual_w3,-- Subquery untuk persen_w1
                    (
                    SELECT
                        ROUND(((
                                    COALESCE ( SUM( ts.amount_payment ), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 185955 ), ts.amount_payment, 0 )), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 184330, 186971, 186972 ), ts.amount_payment, 0 )), 0 ) - COALESCE (
                                        SUM(
                                        IF
                                            (
                                                ts.customer_id IN ( 86868, 162311, 199618, 266597, 301885, 344361, 360833, 406818, 483755, 484928, 485034, 498234, 503268 ),
                                                ts.amount_payment,
                                                0 
                                            )),
                                        0 
                                    ) 
                                    ) / ( target.target / target.jml_minggu )) * 100,
                            2 
                        ) AS persen_actual 
                    FROM
                        t_sale ts
                        JOIN m_week_kpi wk ON wk.WEEK = '3' AND wk.periode = '$periode'
                        LEFT JOIN (
                        SELECT
                            SUM( sales ) AS target,
                            ( SELECT COUNT(*) FROM m_week_kpi WHERE periode = '$periode' ) AS jml_minggu 
                        FROM
                            target_global 
                        WHERE
                            periode = '$periode' 
                        ) AS target ON 1 = 1 
                    WHERE
                        ts.sale_mode = 'S' 
                        AND DATE ( ts.created_at ) BETWEEN wk.START AND wk.END 
                    ) AS persen_w3,
                    (
                    SELECT COALESCE
                        ( SUM( ts.amount_payment ), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 185955 ), ts.amount_payment, 0 )), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 184330, 186971, 186972 ), ts.amount_payment, 0 )), 0 ) - COALESCE (
                            SUM(
                            IF
                                (
                                    ts.customer_id IN ( 86868, 162311, 199618, 266597, 301885, 344361, 360833, 406818, 483755, 484928, 485034, 498234, 503268 ),
                                    ts.amount_payment,
                                    0 
                                )),
                            0 
                        ) 
                    FROM
                        t_sale ts
                        JOIN m_week_kpi wk ON wk.WEEK = '4' AND wk.periode = '$periode' 
                    WHERE
                        ts.sale_mode = 'S' 
                        AND DATE ( ts.created_at ) BETWEEN wk.START AND wk.END 
                    ) AS actual_w4,
                    (
                    SELECT
                        ROUND(((
                                    COALESCE ( SUM( ts.amount_payment ), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 185955 ), ts.amount_payment, 0 )), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 184330, 186971, 186972 ), ts.amount_payment, 0 )), 0 ) - COALESCE (
                                        SUM(
                                        IF
                                            (
                                                ts.customer_id IN ( 86868, 162311, 199618, 266597, 301885, 344361, 360833, 406818, 483755, 484928, 485034, 498234, 503268 ),
                                                ts.amount_payment,
                                                0 
                                            )),
                                        0 
                                    ) 
                                    ) / ( target.target / target.jml_minggu )) * 100,
                            2 
                        ) AS persen_actual 
                    FROM
                        t_sale ts
                        JOIN m_week_kpi wk ON wk.WEEK = '4' AND wk.periode = '$periode'
                        LEFT JOIN (
                        SELECT
                            SUM( sales ) AS target,
                            ( SELECT COUNT(*) FROM m_week_kpi WHERE periode = '$periode' ) AS jml_minggu 
                        FROM
                            target_global 
                        WHERE
                            periode = '$periode' 
                        ) AS target ON 1 = 1 
                    WHERE
                        ts.sale_mode = 'S' 
                        AND DATE ( ts.created_at ) BETWEEN wk.START AND wk.END 
                    ) AS persen_w4,
                    (
                    SELECT COALESCE
                        ( SUM( ts.amount_payment ), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 185955 ), ts.amount_payment, 0 )), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 184330, 186971, 186972 ), ts.amount_payment, 0 )), 0 ) - COALESCE (
                            SUM(
                            IF
                                (
                                    ts.customer_id IN ( 86868, 162311, 199618, 266597, 301885, 344361, 360833, 406818, 483755, 484928, 485034, 498234, 503268 ),
                                    ts.amount_payment,
                                    0 
                                )),
                            0 
                        ) 
                    FROM
                        t_sale ts
                        JOIN m_week_kpi wk ON wk.WEEK = '5' AND wk.periode = '$periode' 
                    WHERE
                        ts.sale_mode = 'S' 
                        AND DATE ( ts.created_at ) BETWEEN wk.START AND wk.END 
                    ) AS actual_w5,
                    COALESCE((
                    SELECT
                        ROUND(((
                                    COALESCE ( SUM( ts.amount_payment ), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 185955 ), ts.amount_payment, 0 )), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 184330, 186971, 186972 ), ts.amount_payment, 0 )), 0 ) - COALESCE (
                                        SUM(
                                        IF
                                            (
                                                ts.customer_id IN ( 86868, 162311, 199618, 266597, 301885, 344361, 360833, 406818, 483755, 484928, 485034, 498234, 503268 ),
                                                ts.amount_payment,
                                                0 
                                            )),
                                        0 
                                    ) 
                                    ) / ( target.target / target.jml_minggu )) * 100,
                            2 
                        ) AS persen_actual 
                    FROM
                        t_sale ts
                        JOIN m_week_kpi wk ON wk.WEEK = '5' AND wk.periode = '$periode'
                        LEFT JOIN (
                        SELECT
                            SUM( sales ) AS target,
                            ( SELECT COUNT(*) FROM m_week_kpi WHERE periode = '$periode' ) AS jml_minggu 
                        FROM
                            target_global 
                        WHERE
                            periode = '$periode' 
                        ) AS target ON 1 = 1 
                    WHERE
                        ts.sale_mode = 'S' 
                        AND DATE ( ts.created_at ) BETWEEN wk.START AND wk.END 
                    ), 0) AS persen_w5,

                    (
                    SELECT COALESCE
                        ( SUM( ts.amount_payment ), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 185955 ), ts.amount_payment, 0 )), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 184330, 186971, 186972 ), ts.amount_payment, 0 )), 0 ) - COALESCE (
                            SUM(
                            IF
                                (
                                    ts.customer_id IN ( 86868, 162311, 199618, 266597, 301885, 344361, 360833, 406818, 483755, 484928, 485034, 498234, 503268 ),
                                    ts.amount_payment,
                                    0 
                                )),
                            0 
                        ) 
                    FROM
                        t_sale ts
                        JOIN m_week_kpi wk ON wk.WEEK = '6' AND wk.periode = '$periode' 
                    WHERE
                        ts.sale_mode = 'S' 
                        AND DATE ( ts.created_at ) BETWEEN wk.START AND wk.END 
                    ) AS actual_w6,
                    (
                    SELECT
                        ROUND(((
                                    COALESCE ( SUM( ts.amount_payment ), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 185955 ), ts.amount_payment, 0 )), 0 ) - COALESCE ( SUM( IF ( ts.customer_id IN ( 184330, 186971, 186972 ), ts.amount_payment, 0 )), 0 ) - COALESCE (
                                        SUM(
                                        IF
                                            (
                                                ts.customer_id IN ( 86868, 162311, 199618, 266597, 301885, 344361, 360833, 406818, 483755, 484928, 485034, 498234, 503268 ),
                                                ts.amount_payment,
                                                0 
                                            )),
                                        0 
                                    ) 
                                    ) / ( target.target / target.jml_minggu )) * 100,
                            2 
                        ) AS persen_actual 
                    FROM
                        t_sale ts
                        JOIN m_week_kpi wk ON wk.WEEK = '6' AND wk.periode = '$periode'
                        LEFT JOIN (
                        SELECT
                            SUM( sales ) AS target,
                            ( SELECT COUNT(*) FROM m_week_kpi WHERE periode = '$periode' ) AS jml_minggu 
                        FROM
                            target_global 
                        WHERE
                            periode = '$periode' 
                        ) AS target ON 1 = 1 
                    WHERE
                        ts.sale_mode = 'S' 
                        AND DATE ( ts.created_at ) BETWEEN wk.START AND wk.END 
                    ) AS persen_w6
                FROM
                    (
                    SELECT
                        'Achivement Sales' AS indicator,
                        actual AS actual,
                        target AS target,
                        40 AS bobot,
                        ROUND( achieve, 2 ) AS achieve,
                        ROUND( skor, 2 ) AS skor 
                    FROM
                        (
                        SELECT
                            'Achivement Sales' AS indicator,
                            COALESCE ( x.sale, 0 ) - COALESCE ( x.ppn, 0 ) - COALESCE ( x.souv, 0 ) - COALESCE ( x.onl, 0 ) - COALESCE ( x.bk, 0 ) - COALESCE ( x.b2b, 0 ) AS actual,
                            x.target,
                            40 AS bobot,
                        CASE
                                
                                WHEN ROUND((
                                        (
                                        COALESCE ( x.sale, 0 ) - COALESCE ( x.ppn, 0 ) - COALESCE ( x.souv, 0 ) - COALESCE ( x.onl, 0 ) - COALESCE ( x.bk, 0 )) / x.target 
                                        ) * 100,
                                    2 
                                    ) > 100 THEN
                                    100 ELSE ROUND((
                                            (
                                            COALESCE ( x.sale, 0 ) - COALESCE ( x.ppn, 0 ) - COALESCE ( x.souv, 0 ) - COALESCE ( x.onl, 0 ) - COALESCE ( x.bk, 0 )) / x.target 
                                            ) * 100,
                                        2 
                                    ) 
                                END AS achieve,
                                ROUND((
                                    CASE
                                            
                                            WHEN ROUND((
                                                    (
                                                    COALESCE ( x.sale, 0 ) - COALESCE ( x.ppn, 0 ) - COALESCE ( x.souv, 0 ) - COALESCE ( x.onl, 0 ) - COALESCE ( x.bk, 0 )) / x.target 
                                                    ) * 100,
                                                2 
                                                ) > 100 THEN
                                                100 ELSE ROUND((
                                                        (
                                                        COALESCE ( x.sale, 0 ) - COALESCE ( x.ppn, 0 ) - COALESCE ( x.souv, 0 ) - COALESCE ( x.onl, 0 ) - COALESCE ( x.bk, 0 )) / x.target 
                                                        ) * 100,
                                                    2 
                                                ) 
                                            END * 40 / 100 
                                        ),
                                        2 
                                        ) AS skor 
                                FROM
                                    (
                                    SELECT
                                        SUM( t_sale.amount_payment ) AS sale,
                                        SUM(
                                        IF
                                            (
                                                t_sale.customer_id NOT IN (185955,184330,186971,186972,86868,162311,199618,266597,301885,344361,360833,406818,483755,484928,485034,498234,503268),
                                                t_sale.ppn,
                                                0 
                                            )) AS ppn,
                                        SUM(
                                        IF
                                        ( t_sale.customer_id IN ( 185955 ), t_sale.amount_payment, 0 )) AS souv,
                                        SUM(
                                        IF
                                        ( t_sale.customer_id IN ( 184330, 186971, 186972 ), t_sale.amount_payment, 0 )) AS onl,
                                        SUM(
                                        IF
                                            (
                                                t_sale.customer_id IN ( 86868, 162311, 199618, 266597, 301885, 344361, 360833, 406818, 483755, 484928, 485034, 498234, 503268 ),
                                                t_sale.amount_payment,
                                                0 
                                            )) AS bk,
                                        SUM(
                                        IF
                                        ( t_sale.customer_id = 879720, t_sale.amount_payment, 0 )) AS b2b,
                                        target.target,
                                        ROUND(( SUM( t_sale.amount_payment )/ target.target )* 100, 2 ) AS persen,-- Penjualan bulan lalu dan dua bulan lalu
                                        last.sale AS last_sale,
                                        ROUND(( SUM( t_sale.amount_payment )/ last.sale )* 100, 2 ) AS prs_last,
                                        mlast.sale AS mlast_sale,
                                        ROUND(( SUM( t_sale.amount_payment )/ mlast.sale )* 100, 2 ) AS prs_mlast 
                                    FROM
                                        t_sale,
                                        ( SELECT SUM( sales ) AS target FROM target_global WHERE SUBSTR( periode, 1, 7 ) = '$periode' ) AS target,-- Penjualan bulan lalu
                                        (
                                        SELECT
                                            SUM(
                                            IF
                                                (
                                                    t_sale.customer_id NOT IN (185955,184330,186971,186972,86868,162311,199618,266597,301885,344361,360833,406818,483755,484928,485034,498234,503268),
                                                    t_sale.amount_payment,
                                                    0 
                                                )) - SUM(
                                            IF
                                                (
                                                    t_sale.customer_id NOT IN (185955,184330,186971,186972,86868,162311,199618,266597,301885,344361,360833,406818,483755,484928,485034,498234,503268),
                                                    t_sale.ppn,
                                                    0 
                                                )) AS sale 
                                        FROM
                                            t_sale 
                                        WHERE
                                            t_sale.sale_mode = 'S' 
                                            AND SUBSTR( t_sale.created_at, 1, 7 ) = SUBSTR( DATE_ADD( '$periode-01', INTERVAL - 1 MONTH ), 1, 7 ) 
                                        ) AS last,
                                        (
                                        SELECT
                                            SUM(
                                            IF
                                                (
                                                    t_sale.customer_id NOT IN (185955,184330,186971,186972,86868,162311,199618,266597,301885,344361,360833,406818,483755,484928,485034,498234,503268),
                                                    t_sale.amount_payment,
                                                    0 
                                                )) - SUM(
                                            IF
                                                (
                                                    t_sale.customer_id NOT IN (185955,184330,186971,186972,86868,162311,199618,266597,301885,344361,360833,406818,483755,484928,485034,498234,503268),
                                                    t_sale.ppn,
                                                    0 
                                                )) AS sale 
                                        FROM
                                            t_sale 
                                        WHERE
                                            t_sale.sale_mode = 'S' 
                                            AND SUBSTR( t_sale.created_at, 1, 7 ) = SUBSTR( DATE_ADD( '$periode-01', INTERVAL - 2 MONTH ), 1, 7 ) 
                                        ) AS mlast 
                                    WHERE
                                        t_sale.sale_mode = 'S' 
                                        AND SUBSTR( t_sale.created_at, 1, 7 ) = '$periode' 
                                    ) AS x 
                                ) AS data1 UNION ALL
                            SELECT
                                'trx' AS indicator,
                                actual_trx AS actual,
                                target_trx AS target,
                                10 AS bobot,
                                ROUND( actual_trx / NULLIF( target_trx, 0 ) * 100, 2 ) AS achieve,
                                ROUND( LEAST( actual_trx / NULLIF( target_trx, 0 ), 1 ) * 10, 2 ) AS skor 
                            FROM
                                (
                                SELECT
                                    COUNT( sale_id ) AS actual_trx,
                                    ( SELECT SUM( trx ) FROM target_global WHERE periode = '$periode' ) AS target_trx 
                                FROM
                                    t_sale 
                                WHERE
                                    sale_mode = 'S' 
                                    AND created_at BETWEEN '$periode-01' 
                                    AND LAST_DAY(CONCAT( '$periode', '-01' )) 
                                ) AS data2 UNION ALL
                            SELECT
                                'hit_rate' AS indicator,
                                trx.actual_trx AS actual,
                                traffic.actual_traffic AS target,
                                5 AS bobot,
                                ROUND(( trx.actual_trx / NULLIF( traffic.actual_traffic, 0 )) * 100, 2 ) AS achieve,
                                ROUND( LEAST(( trx.actual_trx / NULLIF( traffic.actual_traffic, 0 )), 1 ) * 5, 2 ) AS skor 
                            FROM
                                ( SELECT COUNT( sale_id ) AS actual_trx FROM t_sale WHERE sale_mode = 'S' AND created_at BETWEEN '$periode-01' AND LAST_DAY( CONCAT( '$periode', '-01' )) ) AS trx,
                                (
                                SELECT
                                    ( b.traffic_system + b.traffic_sticker ) * 0.3 AS actual_traffic 
                                FROM
                                    (
                                    SELECT COALESCE
                                        ( SUM( traffic_system ), 0 ) AS traffic_system,
                                        COALESCE ( SUM( traffic_sticker ), 0 ) AS traffic_sticker 
                                    FROM
                                        traffic 
                                    WHERE
                                        periode BETWEEN '$periode-01' 
                                        AND LAST_DAY(
                                        CONCAT( '$periode', '-01' )) 
                                    ) AS b 
                                ) AS traffic UNION ALL
                            SELECT
                                'basket_size' AS indicator,
                                ROUND(( sale - ppn - souv - onl - bk ) / NULLIF( sum_trx, 0 ), 2 ) AS actual,
                                target_basket_size AS target,
                                20 AS bobot,
                                ROUND(((
                                            sale - ppn - souv - onl - bk 
                                            ) / NULLIF( sum_trx, 0 )) / NULLIF( target_basket_size, 0 ) * 100,
                                    2 
                                ) AS achieve,
                                ROUND(
                                    LEAST((( sale - ppn - souv - onl - bk ) / NULLIF( sum_trx, 0 )) / NULLIF( target_basket_size, 0 ), 1 ) * 20,
                                    2 
                                ) AS skor 
                            FROM
                                (
                                SELECT
                                    SUM( t.amount_payment ) AS sale,
                                    SUM(
                                    IF
                                        (
                                            t.customer_id NOT IN ( 86868, 162311, 199618, 266597, 301885, 344361, 360833, 406818, 483755, 484928, 485034, 498234, 503268 ),
                                            t.ppn,
                                            0 
                                        )) AS ppn,
                                    SUM(
                                    IF
                                    ( t.customer_id = 185955, t.amount_payment, 0 )) AS souv,
                                    SUM(
                                    IF
                                    ( t.customer_id IN ( 184330, 186971, 186972 ), t.amount_payment, 0 )) AS onl,
                                    SUM(
                                    IF
                                        (
                                            t.customer_id IN ( 86868, 162311, 199618, 266597, 301885, 344361, 360833, 406818, 483755, 484928, 485034, 498234, 503268 ),
                                            t.amount_payment,
                                            0 
                                        )) AS bk,
                                    COUNT(*) AS sum_trx,
                                    ( SELECT SUM( basket_size ) FROM target_global WHERE periode = '$periode' ) AS target_basket_size 
                                FROM
                                    t_sale t 
                                WHERE
                                    t.sale_mode = 'S' 
                                    AND SUBSTR( t.created_at, 1, 10 ) BETWEEN '$periode-01' 
                                    AND LAST_DAY(CONCAT( '$periode', '-01' )) 
                                ) AS data4 UNION ALL
                            SELECT
                                'Inbound_Traffic' AS indicator,
                                ( b.traffic_system + b.traffic_sticker ) AS actual,
                                data5.target AS target,
                                25 AS bobot,
                                ROUND((( b.traffic_system + b.traffic_sticker ) / NULLIF( data5.target, 1 )) * 100, 2 ) AS achieve,
                                ROUND((
                                    CASE
                                            
                                            WHEN ROUND((( b.traffic_system + b.traffic_sticker ) / NULLIF( data5.target, 1 )) * 100, 2 ) > 100 THEN
                                            100 ELSE ROUND((( b.traffic_system + b.traffic_sticker ) / NULLIF( data5.target, 1 )) * 100, 2 ) 
                                        END * 25 / 100 
                                        ),
                                    2 
                                ) AS skor 
                            FROM
                                (
                                SELECT COALESCE
                                    ( SUM( traffic_system ), 0 ) AS traffic_system,
                                    COALESCE ( SUM( traffic_sticker ), 0 ) AS traffic_sticker 
                                FROM
                                    traffic 
                                WHERE
                                    periode BETWEEN '$periode-01' AND LAST_DAY(CONCAT( '$periode', '-01' )) 
                                ) AS b,
                                ( SELECT traffic_manual AS target FROM target_global WHERE periode = '$periode' ) AS data5 
                ) AS acv_actual";

        return $this->db_pos_batik->query($query);
    }

    function get_data_cost_bt($periode)
    {
        $bulan = substr($periode, 5, 2);
        $tahun = substr($periode, 0, 4);

        $query = "SELECT
                'Cost' AS indicator,
                COALESCE(ROUND(SUM(act_budget) / 2), 0) AS act_budget,
                COALESCE(ROUND(SUM(act_w1) / 2), 0) AS act_w1,
                COALESCE(ROUND(SUM(act_w2) / 2), 0) AS act_w2,
                COALESCE(ROUND(SUM(act_w3) / 2), 0) AS act_w3,
                COALESCE(ROUND(SUM(act_w4) / 2), 0) AS act_w4,
                COALESCE(ROUND(SUM(act_w5) / 2), 0) AS act_w5,
                COALESCE(ROUND(SUM(act_w6) / 2), 0) AS act_w6
                FROM
                (
                    SELECT
                    e_biaya.id_budget,
                    e_biaya.id_biaya,
                    m_0.sudah_lpj + m_0.rembers AS act_budget,
                    COALESCE(w_1.sudah_lpj, 0) + COALESCE(w_1.rembers, 0) AS act_w1,
                    COALESCE(w_2.sudah_lpj, 0) + COALESCE(w_2.rembers, 0) AS act_w2,
                    COALESCE(w_3.sudah_lpj, 0) + COALESCE(w_3.rembers, 0) AS act_w3,
                    COALESCE(w_4.sudah_lpj, 0) + COALESCE(w_4.rembers, 0) AS act_w4,
                    COALESCE(w_5.sudah_lpj, 0) + COALESCE(w_5.rembers, 0) AS act_w5,
                    COALESCE(w_6.sudah_lpj, 0) + COALESCE(w_6.rembers, 0) AS act_w6
                    FROM
                    e_eaf.e_biaya
                    LEFT JOIN e_eaf.e_company ON e_company.company_id = e_biaya.company_id
                    LEFT JOIN (
                        SELECT
                        id_pengajuan,
                        id_biaya,
                        SUM(total) AS total,
                        SUM(IF(id_kategori = 17, total_pengajuan_eaf, 0)) AS rembers,
                        SUM(IF(id_kategori = 18 AND total_pengajuan_lpj IS NULL, total_pengajuan_eaf, 0)) AS belum_lpj,
                        SUM(IF(id_kategori = 18 AND total_pengajuan_lpj IS NOT NULL, COALESCE(total_pengajuan_lpj, total_pengajuan_eaf), 0)) AS sudah_lpj
                        FROM
                        (
                            SELECT
                            e_pengajuan.id_pengajuan,
                            approval.update_approve AS update_approve,
                            e_pengajuan.id_biaya AS id_biaya,
                            lpj.created_at AS tgl_LPJ,
                            lpj.id_lpj,
                            e_pengajuan.id_kategori,
                            lpj.total_pengajuan AS total_pengajuan_lpj,
                            e_pengajuan.total_pengajuan AS total_pengajuan_eaf,
                            COALESCE(lpj.total_pengajuan, e_pengajuan.total_pengajuan) AS total
                            FROM
                            e_eaf.`e_pengajuan`
                            LEFT JOIN (SELECT id_pengajuan AS id_lpj, total_pengajuan, created_at FROM e_eaf.e_pengajuan WHERE id_kategori = 19) AS lpj ON e_pengajuan.temp = lpj.id_lpj
                            LEFT JOIN (SELECT id_pengajuan, update_approve FROM e_eaf.e_approval WHERE e_approval.`level` = 5 AND `status` = 'Approve') AS approval ON approval.id_pengajuan = e_pengajuan.id_pengajuan
                            WHERE
                            substr(approval.update_approve, 1, 7) = '$periode'
                            AND e_pengajuan.`status` = 3
                        ) x
                        GROUP BY
                        id_biaya
                    ) AS m_0 ON m_0.id_biaya = e_biaya.id_biaya
                    -- week 1
                    LEFT JOIN (
                        SELECT
                        id_biaya,
                        SUM(total) AS total,
                        SUM(IF(id_kategori = 17, total_pengajuan_eaf, 0)) AS rembers,
                        SUM(IF(id_kategori = 18 AND total_pengajuan_lpj IS NULL, total_pengajuan_eaf, 0)) AS belum_lpj,
                        SUM(IF(id_kategori = 18 AND total_pengajuan_lpj IS NOT NULL, COALESCE(total_pengajuan_lpj, total_pengajuan_eaf), 0)) AS sudah_lpj,
                        x.`week`,
                        x.periode
                        FROM
                        (
                            SELECT
                            e_pengajuan.id_pengajuan,
                            approval.update_approve AS update_approve,
                            w.`week`,
                            w.periode,
                            e_pengajuan.id_biaya AS id_biaya,
                            lpj.created_at AS tgl_LPJ,
                            lpj.id_lpj,
                            e_pengajuan.id_kategori,
                            lpj.total_pengajuan AS total_pengajuan_lpj,
                            e_pengajuan.total_pengajuan AS total_pengajuan_eaf,
                            COALESCE(lpj.total_pengajuan, e_pengajuan.total_pengajuan) AS total
                            FROM
                            e_eaf.`e_pengajuan`
                            LEFT JOIN (SELECT id_pengajuan AS id_lpj, total_pengajuan, created_at FROM e_eaf.e_pengajuan WHERE id_kategori = 19) AS lpj ON e_pengajuan.temp = lpj.id_lpj
                            LEFT JOIN (SELECT id_pengajuan, update_approve FROM e_eaf.e_approval WHERE e_approval.`level` = 5 AND `status` = 'Approve') AS approval ON approval.id_pengajuan = e_pengajuan.id_pengajuan
                            LEFT JOIN m_kpi_week w ON DATE(approval.update_approve) BETWEEN w.`start`
                            AND w.`end`
                            WHERE
                            substr(approval.update_approve, 1, 7) = '$periode'
                            AND e_pengajuan.`status` = 3
                            AND id_biaya IN (5545, 5555)
                            GROUP BY
                            id_pengajuan
                        ) x
                        WHERE
                        x.`week` = 1
                        GROUP BY
                        id_biaya
                    ) w_1 ON w_1.id_biaya = e_biaya.id_biaya
                    -- week 2
                    LEFT JOIN (
                        SELECT
                        id_biaya,
                        SUM(total) AS total,
                        SUM(IF(id_kategori = 17, total_pengajuan_eaf, 0)) AS rembers,
                        SUM(IF(id_kategori = 18 AND total_pengajuan_lpj IS NULL, total_pengajuan_eaf, 0)) AS belum_lpj,
                        SUM(IF(id_kategori = 18 AND total_pengajuan_lpj IS NOT NULL, COALESCE(total_pengajuan_lpj, total_pengajuan_eaf), 0)) AS sudah_lpj,
                        x.`week`,
                        x.periode
                        FROM
                        (
                            SELECT
                            e_pengajuan.id_pengajuan,
                            approval.update_approve AS update_approve,
                            w.`week`,
                            w.periode,
                            e_pengajuan.id_biaya AS id_biaya,
                            lpj.created_at AS tgl_LPJ,
                            lpj.id_lpj,
                            e_pengajuan.id_kategori,
                            lpj.total_pengajuan AS total_pengajuan_lpj,
                            e_pengajuan.total_pengajuan AS total_pengajuan_eaf,
                            COALESCE(lpj.total_pengajuan, e_pengajuan.total_pengajuan) AS total
                            FROM
                            e_eaf.`e_pengajuan`
                            LEFT JOIN (SELECT id_pengajuan AS id_lpj, total_pengajuan, created_at FROM e_eaf.e_pengajuan WHERE id_kategori = 19) AS lpj ON e_pengajuan.temp = lpj.id_lpj
                            LEFT JOIN (SELECT id_pengajuan, update_approve FROM e_eaf.e_approval WHERE e_approval.`level` = 5 AND `status` = 'Approve') AS approval ON approval.id_pengajuan = e_pengajuan.id_pengajuan
                            LEFT JOIN m_kpi_week w ON DATE(approval.update_approve) BETWEEN w.`start`
                            AND w.`end`
                            WHERE
                            substr(approval.update_approve, 1, 7) = '$periode'
                            AND e_pengajuan.`status` = 3
                            AND id_biaya IN (5545, 5555)
                            GROUP BY
                            id_pengajuan
                        ) x
                        WHERE
                        x.`week` = 2
                        GROUP BY
                        id_biaya
                    ) w_2 ON w_2.id_biaya = e_biaya.id_biaya
                    -- week 3
                    LEFT JOIN (
                        SELECT
                        id_biaya,
                        SUM(total) AS total,
                        SUM(IF(id_kategori = 17, total_pengajuan_eaf, 0)) AS rembers,
                        SUM(IF(id_kategori = 18 AND total_pengajuan_lpj IS NULL, total_pengajuan_eaf, 0)) AS belum_lpj,
                        SUM(IF(id_kategori = 18 AND total_pengajuan_lpj IS NOT NULL, COALESCE(total_pengajuan_lpj, total_pengajuan_eaf), 0)) AS sudah_lpj,
                        x.`week`,
                        x.periode
                        FROM
                        (
                            SELECT
                            e_pengajuan.id_pengajuan,
                            approval.update_approve AS update_approve,
                            w.`week`,
                            w.periode,
                            e_pengajuan.id_biaya AS id_biaya,
                            lpj.created_at AS tgl_LPJ,
                            lpj.id_lpj,
                            e_pengajuan.id_kategori,
                            lpj.total_pengajuan AS total_pengajuan_lpj,
                            e_pengajuan.total_pengajuan AS total_pengajuan_eaf,
                            COALESCE(lpj.total_pengajuan, e_pengajuan.total_pengajuan) AS total
                            FROM
                            e_eaf.`e_pengajuan`
                            LEFT JOIN (SELECT id_pengajuan AS id_lpj, total_pengajuan, created_at FROM e_eaf.e_pengajuan WHERE id_kategori = 19) AS lpj ON e_pengajuan.temp = lpj.id_lpj
                            LEFT JOIN (SELECT id_pengajuan, update_approve FROM e_eaf.e_approval WHERE e_approval.`level` = 5 AND `status` = 'Approve') AS approval ON approval.id_pengajuan = e_pengajuan.id_pengajuan
                            LEFT JOIN m_kpi_week w ON DATE(approval.update_approve) BETWEEN w.`start`
                            AND w.`end`
                            WHERE
                            substr(approval.update_approve, 1, 7) = '$periode'
                            AND e_pengajuan.`status` = 3
                            AND id_biaya IN (5545, 5555)
                            GROUP BY
                            id_pengajuan
                        ) x
                        WHERE
                        x.`week` = 3
                        GROUP BY
                        id_biaya
                    ) w_3 ON w_3.id_biaya = e_biaya.id_biaya
                    -- week 4
                    LEFT JOIN (
                        SELECT
                        id_biaya,
                        SUM(total) AS total,
                        SUM(IF(id_kategori = 17, total_pengajuan_eaf, 0)) AS rembers,
                        SUM(IF(id_kategori = 18 AND total_pengajuan_lpj IS NULL, total_pengajuan_eaf, 0)) AS belum_lpj,
                        SUM(IF(id_kategori = 18 AND total_pengajuan_lpj IS NOT NULL, COALESCE(total_pengajuan_lpj, total_pengajuan_eaf), 0)) AS sudah_lpj,
                        x.`week`,
                        x.periode
                        FROM
                        (
                            SELECT
                            e_pengajuan.id_pengajuan,
                            approval.update_approve AS update_approve,
                            w.`week`,
                            w.periode,
                            e_pengajuan.id_biaya AS id_biaya,
                            lpj.created_at AS tgl_LPJ,
                            lpj.id_lpj,
                            e_pengajuan.id_kategori,
                            lpj.total_pengajuan AS total_pengajuan_lpj,
                            e_pengajuan.total_pengajuan AS total_pengajuan_eaf,
                            COALESCE(lpj.total_pengajuan, e_pengajuan.total_pengajuan) AS total
                            FROM
                            e_eaf.`e_pengajuan`
                            LEFT JOIN (SELECT id_pengajuan AS id_lpj, total_pengajuan, created_at FROM e_eaf.e_pengajuan WHERE id_kategori = 19) AS lpj ON e_pengajuan.temp = lpj.id_lpj
                            LEFT JOIN (SELECT id_pengajuan, update_approve FROM e_eaf.e_approval WHERE e_approval.`level` = 5 AND `status` = 'Approve') AS approval ON approval.id_pengajuan = e_pengajuan.id_pengajuan
                            LEFT JOIN m_kpi_week w ON DATE(approval.update_approve) BETWEEN w.`start`
                            AND w.`end`
                            WHERE
                            substr(approval.update_approve, 1, 7) = '$periode'
                            AND e_pengajuan.`status` = 3
                            AND id_biaya IN (5545, 5555)
                            GROUP BY
                            id_pengajuan
                        ) x
                        WHERE
                        x.`week` = 4
                        GROUP BY
                        id_biaya
                    ) w_4 ON w_4.id_biaya = e_biaya.id_biaya
                    -- week 5
                    LEFT JOIN (
                        SELECT
                        id_biaya,
                        SUM(total) AS total,
                        SUM(IF(id_kategori = 17, total_pengajuan_eaf, 0)) AS rembers,
                        SUM(IF(id_kategori = 18 AND total_pengajuan_lpj IS NULL, total_pengajuan_eaf, 0)) AS belum_lpj,
                        SUM(IF(id_kategori = 18 AND total_pengajuan_lpj IS NOT NULL, COALESCE(total_pengajuan_lpj, total_pengajuan_eaf), 0)) AS sudah_lpj,
                        x.`week`,
                        x.periode
                        FROM
                        (
                            SELECT
                            e_pengajuan.id_pengajuan,
                            approval.update_approve AS update_approve,
                            w.`week`,
                            w.periode,
                            e_pengajuan.id_biaya AS id_biaya,
                            lpj.created_at AS tgl_LPJ,
                            lpj.id_lpj,
                            e_pengajuan.id_kategori,
                            lpj.total_pengajuan AS total_pengajuan_lpj,
                            e_pengajuan.total_pengajuan AS total_pengajuan_eaf,
                            COALESCE(lpj.total_pengajuan, e_pengajuan.total_pengajuan) AS total
                            FROM
                            e_eaf.`e_pengajuan`
                            LEFT JOIN (SELECT id_pengajuan AS id_lpj, total_pengajuan, created_at FROM e_eaf.e_pengajuan WHERE id_kategori = 19) AS lpj ON e_pengajuan.temp = lpj.id_lpj
                            LEFT JOIN (SELECT id_pengajuan, update_approve FROM e_eaf.e_approval WHERE e_approval.`level` = 5 AND `status` = 'Approve') AS approval ON approval.id_pengajuan = e_pengajuan.id_pengajuan
                            LEFT JOIN m_kpi_week w ON DATE(approval.update_approve) BETWEEN w.`start`
                            AND w.`end`
                            WHERE
                            substr(approval.update_approve, 1, 7) = '$periode'
                            AND e_pengajuan.`status` = 3
                            AND id_biaya IN (5545, 5555)
                            GROUP BY
                            id_pengajuan
                        ) x
                        WHERE
                        x.`week` = 5
                        GROUP BY
                        id_biaya
                    ) w_5 ON w_5.id_biaya = e_biaya.id_biaya
                    -- week 6
                    LEFT JOIN (
                        SELECT
                        id_biaya,
                        SUM(total) AS total,
                        SUM(IF(id_kategori = 17, total_pengajuan_eaf, 0)) AS rembers,
                        SUM(IF(id_kategori = 18 AND total_pengajuan_lpj IS NULL, total_pengajuan_eaf, 0)) AS belum_lpj,
                        SUM(IF(id_kategori = 18 AND total_pengajuan_lpj IS NOT NULL, COALESCE(total_pengajuan_lpj, total_pengajuan_eaf), 0)) AS sudah_lpj,
                        x.`week`,
                        x.periode
                        FROM
                        (
                            SELECT
                            e_pengajuan.id_pengajuan,
                            approval.update_approve AS update_approve,
                            w.`week`,
                            w.periode,
                            e_pengajuan.id_biaya AS id_biaya,
                            lpj.created_at AS tgl_LPJ,
                            lpj.id_lpj,
                            e_pengajuan.id_kategori,
                            lpj.total_pengajuan AS total_pengajuan_lpj,
                            e_pengajuan.total_pengajuan AS total_pengajuan_eaf,
                            COALESCE(lpj.total_pengajuan, e_pengajuan.total_pengajuan) AS total
                            FROM
                            e_eaf.`e_pengajuan`
                            LEFT JOIN (SELECT id_pengajuan AS id_lpj, total_pengajuan, created_at FROM e_eaf.e_pengajuan WHERE id_kategori = 19) AS lpj ON e_pengajuan.temp = lpj.id_lpj
                            LEFT JOIN (SELECT id_pengajuan, update_approve FROM e_eaf.e_approval WHERE e_approval.`level` = 5 AND `status` = 'Approve') AS approval ON approval.id_pengajuan = e_pengajuan.id_pengajuan
                            LEFT JOIN m_kpi_week w ON DATE(approval.update_approve) BETWEEN w.`start`
                            AND w.`end`
                            WHERE
                            substr(approval.update_approve, 1, 7) = '$periode'
                            AND e_pengajuan.`status` = 3
                            AND id_biaya IN (5545, 5555)
                            GROUP BY
                            id_pengajuan
                        ) x
                        WHERE
                        x.`week` = 6
                        GROUP BY
                        id_biaya
                    ) w_6 ON w_6.id_biaya = e_biaya.id_biaya
                    WHERE
                    bulan = $bulan
                    AND tahun_budget = $tahun
                    AND e_company.company_kode = 'BT'
                    AND e_biaya.id_biaya IN (5545, 5555)
                    GROUP BY
                    id_biaya
                ) result";

        return $this->db->query($query);
    }

    function get_cost_sales($periode)
    {
        $query = "SELECT
                    COALESCE(ROUND(SUM(total) * 0.015), 0) AS target
                    FROM
                    (
                        SELECT
                        t_sale_item.created_at AS tgl,
                        CASE
                            WHEN t_sale_item.discount = 1 THEN
                            (t_sale_item.quantity * - 1)
                            ELSE
                            ((t_sale_item.cost_price - t_sale_item.discount) * t_sale_item.quantity)
                        END AS total
                        FROM
                        t_sale_item
                        LEFT JOIN t_sale ON t_sale.sale_number = t_sale_item.sale_id
                        LEFT JOIN t_sale_voucher ON t_sale.sale_number = t_sale_voucher.sale_number
                        AND t_sale_voucher.promotion = 1
                        LEFT JOIN m_product ON m_product.item_id = t_sale_item.item_id
                        WHERE
                        DATE_FORMAT(t_sale.created_at, '%Y-%m') = '$periode'
                        AND t_sale.sale_mode = 'S'
                        AND COALESCE(m_product.category_id, 0) NOT IN (11, 12, 13, 14, 102, 103)
                    ) result";
        return $this->db_pos_batik->query($query);
    }

    // SPG Excellent
    function data_temuan_cctv($periode)
    {
        $query = "SELECT
            'Temuan CCTV PG Store' AS indicator,
            -- ROUND(MAX(CASE WHEN week=1 THEN actual END), 2) AS actual_w1,
            IF( MAX(CASE WHEN week=1 THEN actual END) <= 15, 100 * 0.5, ROUND( (15 / MAX(CASE WHEN week=1 THEN actual END) ) * 100 , 2) * 0.5 ) AS actual_w1,
            -- ROUND(MAX(CASE WHEN week=2 THEN actual END), 2) AS actual_w2,
            IF( MAX(CASE WHEN week=2 THEN actual END) <= 15, 100 * 0.5, ROUND( (15 / MAX(CASE WHEN week=2 THEN actual END) ) * 100 , 2) * 0.5 ) AS actual_w2,
            -- ROUND(MAX(CASE WHEN week=3 THEN actual END), 2) AS actual_w3,
            IF( MAX(CASE WHEN week=3 THEN actual END) <= 15, 100 * 0.5, ROUND( (15 / MAX(CASE WHEN week=3 THEN actual END) ) * 100 , 2) * 0.5 ) AS actual_w3,
            -- 	ROUND(MAX(CASE WHEN week=4 THEN actual END), 2) AS actual_w4,
            IF( MAX(CASE WHEN week=4 THEN actual END) <= 15, 100 * 0.5, ROUND( (15 / MAX(CASE WHEN week=4 THEN actual END) ) * 100 , 2) * 0.5 ) AS actual_w4,
            -- 	COALESCE(ROUND(MAX(CASE WHEN week=5 THEN actual END), 2), 0) AS actual_w5,
            COALESCE(IF( MAX(CASE WHEN week=5 THEN actual END) <= 15, 100 * 0.5, ROUND( (15 / MAX(CASE WHEN week=5 THEN actual END) ) * 100 , 2) * 0.5 ), 0) AS actual_w5,
            -- 	COALESCE(ROUND(MAX(CASE WHEN week=6 THEN actual END), 2), 0) AS actual_w6,
            COALESCE(
                IF( MAX(CASE WHEN week=6 THEN actual END) <= 15, 100 * 0.5, ROUND( (15 / MAX(CASE WHEN week=6 THEN actual END) ) * 100 , 2) * 0.5 
            ), 0) AS actual_w6,
            -- 	ROUND( (SUM(jml_temuan_acc) / SUM(total_cek)) * 100, 2) AS actual,
                IF( (SUM(jml_temuan_acc) / SUM(total_cek)) * 100 <= 15, 100 * 0.5, ROUND( (15 / ((SUM(jml_temuan_acc) / SUM(total_cek)) * 100) ) * 100, 2 ) * 0.5 ) AS actual
            FROM (
            SELECT
                    w.week,
                    SUM(1) AS total_cek,
                    SUM(CASE WHEN a.id_kategori_temuan != 1 AND a.status = 1 THEN 1 ELSE 0 END) AS jml_temuan_acc,
                    (SUM(CASE WHEN a.id_kategori_temuan != 1 AND a.status = 1 THEN 1 ELSE 0 END) / NULLIF(SUM(1),0)) * 100 AS actual
            FROM daily_checklist.t_temuan_cctv a
            LEFT JOIN hris.m_kpi_week w ON DATE(a.waktu_temuan) BETWEEN w.start AND w.end
            WHERE
                    DATE(a.waktu_temuan) BETWEEN '$periode-01' AND LAST_DAY('$periode-01')
                    AND w.periode = '$periode'
                    AND a.designation_id IN (84,94,119,332,334,635,855,1019)
            GROUP BY w.week
            ) AS dt";
        
        return $this->db->query($query);
    }

    function data_roleplay($periode)
    {
        $query = "SELECT
                    'Roleplay' AS indicator,
                    COUNT(DISTINCT mwk.week) AS total_week,

                    ROUND(CASE 
                        WHEN AVG(CASE WHEN mwk.week = 1 THEN s.nilai END) >= 30 THEN 100 * 0.5
                        ELSE AVG(CASE WHEN mwk.week = 1 THEN s.nilai END) / 30 * 100 * 0.5
                    END, 2) AS actual_w1,

                    ROUND(CASE 
                        WHEN AVG(CASE WHEN mwk.week = 2 THEN s.nilai END) >= 30 THEN 100 * 0.5
                        ELSE AVG(CASE WHEN mwk.week = 2 THEN s.nilai END) / 30 * 100 * 0.5
                    END, 2) AS actual_w2,

                    ROUND(CASE 
                        WHEN AVG(CASE WHEN mwk.week = 3 THEN s.nilai END) >= 30 THEN 100 * 0.5
                        ELSE AVG(CASE WHEN mwk.week = 3 THEN s.nilai END) / 30 * 100 * 0.5
                    END, 2) AS actual_w3,

                    ROUND(CASE 
                        WHEN AVG(CASE WHEN mwk.week = 4 THEN s.nilai END) >= 30 THEN 100 * 0.5
                        ELSE AVG(CASE WHEN mwk.week = 4 THEN s.nilai END) / 30 * 100 * 0.5
                    END, 2) AS actual_w4,

                    COALESCE(ROUND(CASE 
                        WHEN AVG(CASE WHEN mwk.week = 5 THEN s.nilai END) >= 30 THEN 100 * 0.5
                        ELSE AVG(CASE WHEN mwk.week = 5 THEN s.nilai END) / 30 * 100 * 0.5
                    END, 2), 0) AS actual_w5,

                    COALESCE(ROUND(CASE 
                        WHEN AVG(CASE WHEN mwk.week = 6 THEN s.nilai END) >= 30 THEN 100 * 0.5
                        ELSE AVG(CASE WHEN mwk.week = 6 THEN s.nilai END) / 30 * 100 * 0.5
                    END, 2), 0) AS actual_w6,

                    ROUND(CASE 
                        WHEN AVG(CASE WHEN mwk.week = 7 THEN s.nilai END) >= 30 THEN 100 * 0.5
                        ELSE AVG(CASE WHEN mwk.week = 7 THEN s.nilai END) / 30 * 100 * 0.5
                    END, 2) AS actual_w7,

                    -- Total actual dibobotin juga 50%
                    ROUND(((
                        COALESCE(AVG(CASE WHEN mwk.week = 1 THEN LEAST(s.nilai, 30) END), 0) +
                        COALESCE(AVG(CASE WHEN mwk.week = 2 THEN LEAST(s.nilai, 30) END), 0) +
                        COALESCE(AVG(CASE WHEN mwk.week = 3 THEN LEAST(s.nilai, 30) END), 0) +
                        COALESCE(AVG(CASE WHEN mwk.week = 4 THEN LEAST(s.nilai, 30) END), 0) +
                        COALESCE(AVG(CASE WHEN mwk.week = 5 THEN LEAST(s.nilai, 30) END), 0) +
                        COALESCE(AVG(CASE WHEN mwk.week = 6 THEN LEAST(s.nilai, 30) END), 0) +
                        COALESCE(AVG(CASE WHEN mwk.week = 7 THEN LEAST(s.nilai, 30) END), 0)
                    ) / 30 / NULLIF(COUNT(DISTINCT mwk.week), 0)) * 100 * 0.5, 2) AS actual

                    FROM t_sdm s
                    JOIN t_sdm_item si ON s.id_sdm = si.id_t_sdm
                    JOIN m_week_kpi mwk ON DATE(s.periode) BETWEEN mwk.start AND mwk.end
                    WHERE s.periode BETWEEN '$periode-01' AND '$periode-30'";
        
        return $this->db_pos_batik->query($query);
    }
    // end SPG Excelent

    // Kasir Excellent
    // KUERI GABUNGAN (KECEPATAN KASIR, SELISIH KASIR, SCALEUP KASIR, KELOLOSAN TAG)
    function data_kasir_excellent_1_4($periode)
    {
        $query = "SELECT
                    'Kecepatan Kasir' AS indicator,
                    -- BULANAN
                    2 AS target,
                    actual,
                    CASE 
                        WHEN actual <= 2 THEN 100
                        ELSE (2 / actual) * 100
                    END AS persen_acv,
                    ROUND((actual / 2) * 100 * 0.0099, 0) AS nilai,
                    
                    target_w1,
                    actual_w1,
                    CASE 
                        WHEN actual_w1 <= 2 THEN 100
                        ELSE (2 / actual_w1) * 100
                    END AS persen_acv_w1,
                    nilai_w1,
                    
                    target_w2,
                    actual_w2,
                    CASE 
                        WHEN actual_w2 <= 2 THEN 100
                        ELSE (2 / actual_w2) * 100
                    END AS persen_acv_w2,
                    nilai_w2,
                    
                    target_w3,
                    actual_w3,
                    CASE 
                        WHEN actual_w2 <= 2 THEN 100
                        ELSE (2 / actual_w3) * 100
                    END AS persen_acv_w3,
                    nilai_w3,
                    
                    target_w4,
                    actual_w4,
                    CASE 
                        WHEN actual_w4 <= 2 THEN 100
                        ELSE (2 / actual_w4) * 100
                    END AS persen_acv_w4,
                    nilai_w4,
                    
                    target_w5,
                    actual_w5,
                    CASE 
                        WHEN actual_w5 <= 2 THEN 100
                        ELSE (2 / actual_w5) * 100
                    END AS persen_acv_w5,
                    nilai_w5,
                    
                    target_w6,
                    actual_w6,
                    CASE 
                        WHEN actual_w6 <= 2 THEN 100
                        ELSE (2 / actual_w6) * 100
                    END AS persen_acv_w6,
                    nilai_w6
                FROM (

                    SELECT
                        -- actual bulan = jumlah actual mingguan
                        ROUND(
                                IFNULL(actual_w1, 0) +
                                IFNULL(actual_w2, 0) +
                                IFNULL(actual_w3, 0) +
                                IFNULL(actual_w4, 0) +
                                IFNULL(actual_w5, 0) +
                                IFNULL(actual_w6, 0), 0
                        ) AS actual,

                        -- MINGGUAN
                        COALESCE(target_w1, 0) AS target_w1, COALESCE(actual_w1, 0) AS actual_w1, 
                -- 		COALESCE(persen_acv_w1, 0) AS persen_acv_w1, 
                        COALESCE(nilai_w1, 0) AS nilai_w1,
                        COALESCE(target_w2, 0) AS target_w2, COALESCE(actual_w2, 0) AS actual_w2,
                -- 		COALESCE(persen_acv_w2, 0) AS persen_acv_w2, 
                        COALESCE(nilai_w2, 0) AS nilai_w2,
                        COALESCE(target_w3, 0) AS target_w3, COALESCE(actual_w3, 0) AS actual_w3, 
                -- 		COALESCE(persen_acv_w3, 0) AS persen_acv_w3, 
                        COALESCE(nilai_w3, 0) AS nilai_w3,
                        COALESCE(target_w4, 0) AS target_w4, COALESCE(actual_w4, 0) AS actual_w4, 
                -- 		COALESCE(persen_acv_w4, 0) AS persen_acv_w4, 
                        COALESCE(nilai_w4, 0) AS nilai_w4,
                        COALESCE(target_w5, 0) AS target_w5, COALESCE(actual_w5, 0) AS actual_w5, 
                -- 		COALESCE(persen_acv_w5, 0) AS persen_acv_w5, 
                        COALESCE(nilai_w5, 0) AS nilai_w5,
                        COALESCE(target_w6, 0) AS target_w6, COALESCE(actual_w6, 0) AS actual_w6, 
                -- 		COALESCE(persen_acv_w6, 0) AS persen_acv_w6, 
                        COALESCE(nilai_w6, 0) AS nilai_w6

                        FROM (
                       
                        SELECT
                                
                        -- WEEK 1
                        2 AS target_w1,

                        ROUND(
                                COUNT(CASE WHEN m.week = 1 AND TIME_TO_SEC(TIMEDIFF(
                                SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(ts.end_time, ts.start_time)) -
                                TIME_TO_SEC(COALESCE(TIMEDIFF(tst.pause_end, tst.pause_start), 0))
                                ),
                                SEC_TO_TIME(ROUND(item.time, 0))
                                )) > 5 THEN 1 END) * 100.0 /
                                NULLIF(COUNT(CASE WHEN m.week = 1 THEN ts.sale_number END), 0)
                        , 0) AS actual_w1,

                        ROUND(
                                (
                                (
                                        ROUND(
                                        COUNT(CASE WHEN m.week = 1 AND TIME_TO_SEC(TIMEDIFF(
                                                SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(ts.end_time, ts.start_time)) -
                                                TIME_TO_SEC(COALESCE(TIMEDIFF(tst.pause_end, tst.pause_start), 0))
                                        ),
                                        SEC_TO_TIME(ROUND(item.time, 0))
                                        )) > 5 THEN 1 END) * 100.0 /
                                        NULLIF(COUNT(CASE WHEN m.week = 1 THEN ts.sale_number END), 0)
                                        , 0) / 2 * 100
                                ) * 0.33 * 0.15
                                ), 0
                        ) AS nilai_w1,

                        -- WEEK 2
                        2 AS target_w2,

                        ROUND(
                                COUNT(CASE WHEN m.week = 2 AND TIME_TO_SEC(TIMEDIFF(
                                SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(ts.end_time, ts.start_time)) -
                                TIME_TO_SEC(COALESCE(TIMEDIFF(tst.pause_end, tst.pause_start), 0))
                                ),
                                SEC_TO_TIME(ROUND(item.time, 0))
                                )) > 5 THEN 1 END) * 100.0 /
                                NULLIF(COUNT(CASE WHEN m.week = 2 THEN ts.sale_number END), 0)
                        , 0) AS actual_w2,

                        ROUND(
                                (
                                (
                                        ROUND(
                                        COUNT(CASE WHEN m.week = 2 AND TIME_TO_SEC(TIMEDIFF(
                                                SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(ts.end_time, ts.start_time)) -
                                                TIME_TO_SEC(COALESCE(TIMEDIFF(tst.pause_end, tst.pause_start), 0))
                                        ),
                                        SEC_TO_TIME(ROUND(item.time, 0))
                                        )) > 5 THEN 1 END) * 100.0 /
                                        NULLIF(COUNT(CASE WHEN m.week = 2 THEN ts.sale_number END), 0)
                                        , 0) / 2 * 100
                                ) * 0.33 * 0.15
                                ), 0
                        ) AS nilai_w2,
                        
                        
                        -- WEEK 3
                                2 AS target_w3,

                        ROUND(
                                COUNT(CASE WHEN m.week = 3 AND TIME_TO_SEC(TIMEDIFF(
                                SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(ts.end_time, ts.start_time)) -
                                TIME_TO_SEC(COALESCE(TIMEDIFF(tst.pause_end, tst.pause_start), 0))
                                ),
                                SEC_TO_TIME(ROUND(item.time, 0))
                                )) > 5 THEN 1 END) * 100.0 /
                                NULLIF(COUNT(CASE WHEN m.week = 3 THEN ts.sale_number END), 0)
                        , 0) AS actual_w3,

                        ROUND(
                                (
                                (
                                        ROUND(
                                        COUNT(CASE WHEN m.week = 3 AND TIME_TO_SEC(TIMEDIFF(
                                                SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(ts.end_time, ts.start_time)) -
                                                TIME_TO_SEC(COALESCE(TIMEDIFF(tst.pause_end, tst.pause_start), 0))
                                        ),
                                        SEC_TO_TIME(ROUND(item.time, 0))
                                        )) > 5 THEN 1 END) * 100.0 /
                                        NULLIF(COUNT(CASE WHEN m.week = 3 THEN ts.sale_number END), 0)
                                        , 0) / 2 * 100
                                ) * 0.33 * 0.15
                                ), 0
                        ) AS nilai_w3,
                        
                        -- WEEK 4
                                2 AS target_w4,

                        ROUND(
                                COUNT(CASE WHEN m.week = 4 AND TIME_TO_SEC(TIMEDIFF(
                                SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(ts.end_time, ts.start_time)) -
                                TIME_TO_SEC(COALESCE(TIMEDIFF(tst.pause_end, tst.pause_start), 0))
                                ),
                                SEC_TO_TIME(ROUND(item.time, 0))
                                )) > 5 THEN 1 END) * 100.0 /
                                NULLIF(COUNT(CASE WHEN m.week = 4 THEN ts.sale_number END), 0)
                        , 0) AS actual_w4,

                        ROUND(
                                (
                                (
                                        ROUND(
                                        COUNT(CASE WHEN m.week = 4 AND TIME_TO_SEC(TIMEDIFF(
                                                SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(ts.end_time, ts.start_time)) -
                                                TIME_TO_SEC(COALESCE(TIMEDIFF(tst.pause_end, tst.pause_start), 0))
                                        ),
                                        SEC_TO_TIME(ROUND(item.time, 0))
                                        )) > 5 THEN 1 END) * 100.0 /
                                        NULLIF(COUNT(CASE WHEN m.week = 4 THEN ts.sale_number END), 0)
                                        , 0) / 2 * 100
                                ) * 0.33 * 0.15
                                ), 0
                        ) AS nilai_w4,
                        
                        -- WEEK 5
                                2 AS target_w5,

                        ROUND(
                                COUNT(CASE WHEN m.week = 5 AND TIME_TO_SEC(TIMEDIFF(
                                SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(ts.end_time, ts.start_time)) -
                                TIME_TO_SEC(COALESCE(TIMEDIFF(tst.pause_end, tst.pause_start), 0))
                                ),
                                SEC_TO_TIME(ROUND(item.time, 0))
                                )) > 5 THEN 1 END) * 100.0 /
                                NULLIF(COUNT(CASE WHEN m.week = 5 THEN ts.sale_number END), 0)
                        , 0) AS actual_w5,

                        ROUND(
                                (
                                (
                                        ROUND(
                                        COUNT(CASE WHEN m.week = 5 AND TIME_TO_SEC(TIMEDIFF(
                                                SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(ts.end_time, ts.start_time)) -
                                                TIME_TO_SEC(COALESCE(TIMEDIFF(tst.pause_end, tst.pause_start), 0))
                                        ),
                                        SEC_TO_TIME(ROUND(item.time, 0))
                                        )) > 5 THEN 1 END) * 100.0 /
                                        NULLIF(COUNT(CASE WHEN m.week = 5 THEN ts.sale_number END), 0)
                                        , 0) / 2 * 100
                                ) * 0.33 * 0.15
                                ), 0
                        ) AS nilai_w5,
                        
                        -- WEEK 6
                        2 AS target_w6,

                        IFNULL(ROUND(
                                COUNT(CASE WHEN m.week = 6 AND TIME_TO_SEC(TIMEDIFF(
                                SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(ts.end_time, ts.start_time)) -
                                TIME_TO_SEC(COALESCE(TIMEDIFF(tst.pause_end, tst.pause_start), 0))
                                ),
                                SEC_TO_TIME(ROUND(item.time, 0))
                                )) > 5 THEN 1 END) * 100.0 /
                                NULLIF(COUNT(CASE WHEN m.week = 6 THEN ts.sale_number END), 0)
                        , 0), 0) AS actual_w6,

                        IFNULL(ROUND(
                                (
                                (
                                        ROUND(
                                        COUNT(CASE WHEN m.week = 6 AND TIME_TO_SEC(TIMEDIFF(
                                                SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(ts.end_time, ts.start_time)) -
                                                TIME_TO_SEC(COALESCE(TIMEDIFF(tst.pause_end, tst.pause_start), 0))
                                        ),
                                        SEC_TO_TIME(ROUND(item.time, 0))
                                        )) > 5 THEN 1 END) * 100.0 /
                                        NULLIF(COUNT(CASE WHEN m.week = 6 THEN ts.sale_number END), 0)
                                        , 0) / 2 * 100
                                ) * 0.33 * 0.15
                                ), 0
                        ), 0) AS nilai_w6
                        
                        
                        FROM m_week_kpi m
                        JOIN t_sale ts 
                        ON ts.created_at >= m.start 
                                AND ts.created_at < DATE_ADD(m.end, INTERVAL 1 DAY)
                                AND DATE(ts.created_at) BETWEEN '$periode-01' AND LAST_DAY('$periode-01')
                                AND ts.sale_mode = 'S'
                                AND ts.created_by NOT IN (50, 51)

                        LEFT JOIN t_sale_time tst 
                        ON ts.sale_number = tst.sale_number

                        LEFT JOIN (
                        SELECT 
                                tsi.sale_id,
                                SUM(
                                CASE 
                                        WHEN item_id IN (
                                        '20221','20222','30','32','33','19798','19970','20193','34','35','31','405','406','407','468','5904',
                                        '4385','4604','5910','5905','5906','5907','5908','5909','337','19799','19971','20194','8587','477',
                                        '19973','20195','476','469','470','20227','22763','471','472','473','474','758','478','475','4258',
                                        '17077','20047','19903','19736','4292','4293','4294','4295','20049','2225','5013','454','18246','3040',
                                        '3182','6820','6834','8520','8598','8599','8668','12157','12707','12733','13111','13112','13424','14983',
                                        '22281','22282','14999','15001','15002','15003','15004','15006','17038','17070','17317','17448','22562',
                                        '17898','18451','19072','7173','6346','6344','8316','6345','6417','8315','18724','17758','17756','17759',
                                        '17757','6418','1917','1900','1901','1902','1903','1904','1905','1906','1907','1908','1909','1910','1911',
                                        '1912','1913','1914','1915','1916'
                                        ) THEN 30 
                                        ELSE ROUND(quantity * 30, 0)
                                END
                                ) + 95 AS time
                        FROM t_sale_item tsi
                        WHERE DATE(created_at) BETWEEN '$periode-01' AND LAST_DAY('$periode-01')
                        GROUP BY tsi.sale_id
                        ) AS item 
                        ON item.sale_id = ts.sale_number
                        WHERE m.id_tag = 1
                        ) AS mingguan_summary
                        
                ) final_combined

                    UNION ALL

                    SELECT
                        'Selisih Kasir' AS indicator,

                        -- bulanan
                        300000 AS target,
                        SUM(sls.minus_payment) AS actual,
                        IF(
                            -(SUM(sls.minus_payment)) <= 3000000, 100,
                            ROUND(-300000 / SUM(sls.minus_payment) * 100, 2)
                        ) AS persen_acv,
                        ROUND(
                            IF(
                                -(SUM(sls.minus_payment)) <= 3000000, 100,
                                ROUND(-300000 / SUM(sls.minus_payment) * 100, 2)
                            ) * 0.2 * 0.15 * 0.33
                        ) AS nilai, -- nilai = persen_acv * bobot kasir excelent (20%) * bobot service excelent (15%) * bobot peningkatan kasir excelent (33%)
                        
                        -- week 1
                        ROUND(300000 / w.total_week) AS target_w1,
                        SUM(CASE WHEN mwk.week = 1 THEN sls.minus_payment END) AS actual_w1,
                        IF(
                            -(SUM(CASE WHEN mwk.week = 1 THEN sls.minus_payment END)) <= 300000/w.total_week, 100,
                            ROUND((-300000/w.total_week) / SUM(CASE WHEN mwk.week = 1 THEN sls.minus_payment END) * 100, 2)
                        ) AS persen_acv_w1,
                        ROUND(
                            IF(
                            -(SUM(CASE WHEN mwk.week = 1 THEN sls.minus_payment END)) <= 300000/w.total_week, 100,
                            ROUND((-300000/w.total_week) / SUM(CASE WHEN mwk.week = 1 THEN sls.minus_payment END) * 100, 2)
                            ) * 0.2 * 0.15 * 0.33
                        ) AS nilai_w1,
                        
                        -- week 2
                        ROUND(300000 / w.total_week) AS target_w2,
                        SUM(CASE WHEN mwk.week = 2 THEN sls.minus_payment END) AS actual_w2,
                        IF(
                            -(SUM(CASE WHEN mwk.week = 2 THEN sls.minus_payment END)) <= 300000/w.total_week, 100,
                            ROUND((-300000/w.total_week) / SUM(CASE WHEN mwk.week = 2 THEN sls.minus_payment END) * 100, 2)
                        ) AS persen_acv_w2,
                        ROUND(
                            IF(
                                -(SUM(CASE WHEN mwk.week = 2 THEN sls.minus_payment END)) <= 300000/w.total_week, 100,
                                ROUND((-300000/w.total_week) / SUM(CASE WHEN mwk.week = 2 THEN sls.minus_payment END) * 100, 2)
                            ) * 0.2 * 0.15 * 0.33
                        ) AS nilai_w2,
                        
                        -- week 3
                        ROUND(300000 / w.total_week) AS target_w3,
                        SUM(CASE WHEN mwk.week = 3 THEN sls.minus_payment END) AS actual_w3,
                        IF(
                            -(SUM(CASE WHEN mwk.week = 3 THEN sls.minus_payment END)) <= 300000/w.total_week, 100,
                            ROUND((-300000/w.total_week) / SUM(CASE WHEN mwk.week = 3 THEN sls.minus_payment END) * 100, 2)
                        ) AS persen_acv_w3,
                        ROUND(
                            IF(
                                -(SUM(CASE WHEN mwk.week = 3 THEN sls.minus_payment END)) <= 300000/w.total_week, 100,
                                ROUND((-300000/w.total_week) / SUM(CASE WHEN mwk.week = 3 THEN sls.minus_payment END) * 100, 2)
                            ) * 0.2 * 0.15 * 0.33
                        ) AS nilai_w3,
                        
                        -- week 4
                        ROUND(300000 / w.total_week) AS target_w4,
                        SUM(CASE WHEN mwk.week = 4 THEN sls.minus_payment END) AS actual_w4,
                        IF(
                            -(SUM(CASE WHEN mwk.week = 4 THEN sls.minus_payment END)) <= 300000/w.total_week, 100,
                            ROUND((-300000/w.total_week) / SUM(CASE WHEN mwk.week = 4 THEN sls.minus_payment END) * 100, 2)
                        ) AS persen_acv_w4,
                        0 AS nilai_w4,
                        
                        -- week 5
                        ROUND(300000 / w.total_week) AS target_w5,
                        COALESCE(SUM(CASE WHEN mwk.week = 5 THEN sls.minus_payment END), 0) AS actual_w5,
                        COALESCE(
                        IF(
                            -(SUM(CASE WHEN mwk.week = 5 THEN sls.minus_payment END)) <= 300000/w.total_week, 100,
                            ROUND((-300000/w.total_week) / SUM(CASE WHEN mwk.week = 5 THEN sls.minus_payment END) * 100, 2)
                        ), 0) AS persen_acv_w5,
                        0 AS nilai_w5,
                        
                        -- week 6
                        ROUND(300000 / w.total_week) AS target_w6,
                        COALESCE(-SUM(CASE WHEN mwk.week = 6 THEN sls.minus_payment END), 0) AS actual_w6,
                        COALESCE(
                        IF(
                            -(SUM(CASE WHEN mwk.week = 6 THEN sls.minus_payment END)) <= 300000/w.total_week, 100,
                            ROUND((-300000/w.total_week) / SUM(CASE WHEN mwk.week = 6 THEN sls.minus_payment END) * 100, 2)
                        ), 0) AS persen_acv_w6,
                        0 AS nilai_w6
                    FROM
                        t_selisih_kasir AS sls
                        JOIN m_week_kpi mwk ON sls.tgl_struk BETWEEN mwk.start AND mwk.end
                        LEFT JOIN (
                            SELECT
                                MAX(week) AS total_week
                            FROM
                                m_week_kpi
                            WHERE periode = '$periode'
                        ) AS w ON 1 = 1
                    WHERE
                        sls.tgl_struk BETWEEN '$periode-01' AND LAST_DAY('$periode-01')
                        
                    UNION ALL

                    SELECT
                        'Scaleup Kasir' AS indicator,
                        
                        targetall AS target,
                        actualall AS actual,
                        achieveall AS persen_acv,
                        nilaiall AS nilai,

                        targetw1 AS target_w1,
                        actualw1 AS actual_w1,
                        achievew1 AS persen_acv_w1,
                        nilaiw1 AS nilai_w1,

                        targetw2,
                        actualw2,
                        achievew2,
                        nilaiw2,

                        targetw3,
                        actualw3,
                        achievew3,
                        nilaiw3,

                        targetw4,
                        actualw4,
                        achievew4,
                        nilaiw4,
                        
                        targetw5,
                        actualw5,
                        achievew5,
                        nilaiw5,
                        
                        targetw6,
                        actualw6,
                        COALESCE(achievew6, 0) AS achievew6,
                        COALESCE(nilaiw6, 0) AS nilaiw6
                    FROM
                        (
                        SELECT
                            *,
                            -- Menambahkan kolom nilai berdasarkan kolom achieve yang sudah dibulatkan
                            ROUND( ( achieveall * 0.0099 ), 4 ) AS nilaiall,
                            ROUND( ( achievew1 * 0.0099 ), 4 ) AS nilaiw1,
                            ROUND( ( achievew2 * 0.0099 ), 4 ) AS nilaiw2,
                            ROUND( ( achievew3 * 0.0099 ), 4 ) AS nilaiw3,
                            ROUND( ( achievew4 * 0.0099 ), 4 ) AS nilaiw4,
                            ROUND( ( achievew5 * 0.0099 ), 4 ) AS nilaiw5,
                            ROUND( ( achievew6 * 0.0099 ), 4 ) AS nilaiw6 
                        FROM
                            (
                            -- Lapisan ini menghitung target dan achieve dengan pembulatan
                            SELECT
                                *,
                                -- Membulatkan kolom target ke 0 desimal
                                ROUND( ( transaksiall * 0.3 ), 0 ) AS targetall,
                                ROUND( ( transaksiw1 * 0.3 ), 0 ) AS targetw1,
                                ROUND( ( transaksiw2 * 0.3 ), 0 ) AS targetw2,
                                ROUND( ( transaksiw3 * 0.3 ), 0 ) AS targetw3,
                                ROUND( ( transaksiw4 * 0.3 ), 0 ) AS targetw4,
                                ROUND( ( transaksiw5 * 0.3 ), 0 ) AS targetw5,
                                ROUND( ( transaksiw6 * 0.3 ), 0 ) AS targetw6,
                                -- Membulatkan kolom achieve ke 2 desimal
                                ROUND( ( actualall / NULLIF(( transaksiall * 0.3 ), 0) * 100 ), 2 ) AS achieveall,
                                ROUND( ( actualw1 / NULLIF(( transaksiw1 * 0.3 ), 0) * 100 ), 2 ) AS achievew1,
                                ROUND( ( actualw2 / NULLIF(( transaksiw2 * 0.3 ), 0) * 100 ), 2 ) AS achievew2,
                                ROUND( ( actualw3 / NULLIF(( transaksiw3 * 0.3 ), 0) * 100 ), 2 ) AS achievew3,
                                ROUND( ( actualw4 / NULLIF(( transaksiw4 * 0.3 ), 0) * 100 ), 2 ) AS achievew4,
                                ROUND( ( actualw5 / NULLIF(( transaksiw5 * 0.3 ), 0) * 100 ), 2 ) AS achievew5,
                                ROUND( ( actualw6 / NULLIF(( transaksiw6 * 0.3 ), 0) * 100 ), 2 ) AS achievew6 
                            FROM
                                (
                                -- Kueri asli Anda sebagai dasar
                                SELECT
                                    created_by,
                                    wik,
                                    SUM( COALESCE ( transaksi, 0 ) ) AS transaksiall,
                                    SUM( IF ( wik = 1, COALESCE ( transaksi, 0 ), 0 ) ) AS transaksiw1,
                                    SUM( IF ( wik = 2, COALESCE ( transaksi, 0 ), 0 ) ) AS transaksiw2,
                                    SUM( IF ( wik = 3, COALESCE ( transaksi, 0 ), 0 ) ) AS transaksiw3,
                                    SUM( IF ( wik = 4, COALESCE ( transaksi, 0 ), 0 ) ) AS transaksiw4,
                                    SUM( IF ( wik = 5, COALESCE ( transaksi, 0 ), 0 ) ) AS transaksiw5,
                                    SUM( IF ( wik = 6, COALESCE ( transaksi, 0 ), 0 ) ) AS transaksiw6,
                                    SUM( COALESCE ( transaksi1, 0 ) ) + SUM( COALESCE ( transaksi2, 0 ) ) + SUM( COALESCE ( transaksi3, 0 ) ) AS actualall,
                                    SUM( IF ( wik = 1, COALESCE ( transaksi1, 0 ), 0 ) ) + SUM( IF ( wik = 1, COALESCE ( transaksi2, 0 ), 0 ) ) + SUM( IF ( wik = 1, COALESCE ( transaksi3, 0 ), 0 ) ) AS actualw1,
                                    SUM( IF ( wik = 2, COALESCE ( transaksi1, 0 ), 0 ) ) + SUM( IF ( wik = 2, COALESCE ( transaksi2, 0 ), 0 ) ) + SUM( IF ( wik = 2, COALESCE ( transaksi3, 0 ), 0 ) ) AS actualw2,
                                    SUM( IF ( wik = 3, COALESCE ( transaksi1, 0 ), 0 ) ) + SUM( IF ( wik = 3, COALESCE ( transaksi2, 0 ), 0 ) ) + SUM( IF ( wik = 3, COALESCE ( transaksi3, 0 ), 0 ) ) AS actualw3,
                                    SUM( IF ( wik = 4, COALESCE ( transaksi1, 0 ), 0 ) ) + SUM( IF ( wik = 4, COALESCE ( transaksi2, 0 ), 0 ) ) + SUM( IF ( wik = 4, COALESCE ( transaksi3, 0 ), 0 ) ) AS actualw4,
                                    SUM( IF ( wik = 5, COALESCE ( transaksi1, 0 ), 0 ) ) + SUM( IF ( wik = 5, COALESCE ( transaksi2, 0 ), 0 ) ) + SUM( IF ( wik = 5, COALESCE ( transaksi3, 0 ), 0 ) ) AS actualw5,
                                    SUM( IF ( wik = 6, COALESCE ( transaksi1, 0 ), 0 ) ) + SUM( IF ( wik = 6, COALESCE ( transaksi2, 0 ), 0 ) ) + SUM( IF ( wik = 6, COALESCE ( transaksi3, 0 ), 0 ) ) AS actualw6 
                                FROM
                                    (
                                    SELECT
                                        dt.created_by,
                                        dt.wik,
                                        dt.transaksi,
                                        dt.total_bayar,
                                        quantity1,
                                        sales1,
                                        transaksi1,
                                        quantity2,
                                        sales2,
                                        transaksi2,
                                        quantity3,
                                        sales3,
                                        transaksi3,
                                        ROUND( ( transaksi * ( sc.target ) ), 4 ) AS target,
                                        COALESCE ( transaksi1, 0 ) + COALESCE ( transaksi2, 0 ) + COALESCE ( transaksi3, 0 ) AS totaltr,
                                        COALESCE ( sales1, 0 ) + COALESCE ( sales2, 0 ) + COALESCE ( sales3, 0 ) AS totalsales,
                                        ROUND( ( ( COALESCE ( transaksi1, 0 ) + COALESCE ( transaksi2, 0 ) + COALESCE ( transaksi3, 0 ) ) / ( transaksi * ( sc.target ) ) ) * 100, 4 ) AS acv 
                                    FROM
                                        (
                                        SELECT
                                            quantity1,
                                            sales1,
                                            transaksi1,
                                            quantity2,
                                            sales2,
                                            transaksi2,
                                            quantity3,
                                            sales3,
                                            transaksi3,
                                            dta.created_by,
                                            dta.wik,
                                            dta.transaksi,
                                            dta.total_bayar 
                                        FROM
                                            (
                                            SELECT
                                                SUM( amount_payment ) AS total_bayar,
                                                created_by,
                                                wik,
                                                COUNT( amount_payment ) AS transaksi 
                                            FROM
                                                (
                                                SELECT
                                                    sale_number,
                                                    amount_payment,
                                                    created_by,
                                                    created_at,
                                                    ( WEEK ( SUBSTR( t_sale.created_at, 1, 10 ), 4 ) + 1 ) - WEEK(
                                                        DATE_SUB( SUBSTR( t_sale.created_at, 1, 10 ), INTERVAL DAYOFMONTH( SUBSTR( t_sale.created_at, 1, 10 ) ) - 1 DAY ),
                                                        4 
                                                    ) AS wik 
                                                FROM
                                                    t_sale 
                                                WHERE
                                                    DATE(t_sale.created_at) BETWEEN '$periode-01' AND LAST_DAY('$periode-01') 
                                                    AND SUBSTR( t_sale.sale_number, 1, 1 ) = 'S' 
                                                    AND t_sale.created_by NOT IN ( 50, 51 ) 
                                                ) dtaa 
                                            GROUP BY
                                                created_by,
                                                wik 
                                            ORDER BY
                                                created_by,
                                                wik 
                                            ) dta
                                            LEFT JOIN (
                                            SELECT
                                                dt.created_by,
                                                dt.employee_name,
                                                SUM( dt.quantity ) AS quantity1,
                                                SUM( amount_payment ) AS sales1,
                                                count( amount_payment ) AS transaksi1,
                                                wik,
                                                'item1' AS jenis 
                                            FROM
                                                (
                                                SELECT
                                                    t_sale.created_by,
                                                    `user`.employee_name,
                                                    t_sale_item.quantity,
                                                    t_sale_item.quantity * t_sale_item.cost_price AS amount_payment,
                                                    ( WEEK ( SUBSTR( t_sale_item.created_at, 1, 10 ), 4 ) + 1 ) - WEEK(
                                                        DATE_SUB( SUBSTR( t_sale_item.created_at, 1, 10 ), INTERVAL DAYOFMONTH( SUBSTR( t_sale_item.created_at, 1, 10 ) ) - 1 DAY ),
                                                        4 
                                                    ) AS wik 
                                                FROM
                                                    pos_batik.t_sale
                                                    JOIN pos_batik.t_sale_item ON t_sale_item.sale_id = t_sale.sale_number
                                                    JOIN pos_batik.`user` ON `user`.id_user = t_sale.created_by 
                                                WHERE
                                                    SUBSTR( t_sale_item.sale_id, 1, 1 ) = 'S' 
                                                    AND DATE(t_sale_item.created_at) BETWEEN '$periode-01' AND LAST_DAY('$periode-01') 
                                                    AND t_sale_item.item_id IN ( 93 ) 
                                                    AND t_sale.created_by NOT IN ( 50, 51 ) 
                                                ORDER BY
                                                    `user`.employee_name ASC 
                                                ) dt 
                                            GROUP BY
                                                dt.created_by,
                                                wik 
                                            ORDER BY
                                                employee_name,
                                                wik 
                                            ) dt1 ON dt1.created_by = dta.created_by 
                                            AND dt1.wik = dta.wik
                                            LEFT JOIN (
                                            SELECT
                                                dt.created_by,
                                                dt.employee_name,
                                                SUM( dt.quantity ) AS quantity2,
                                                SUM( amount_payment ) AS sales2,
                                                count( amount_payment ) AS transaksi2,
                                                wik,
                                                'item2' AS jenis 
                                            FROM
                                                (
                                                SELECT
                                                    t_sale.created_by,
                                                    `user`.employee_name,
                                                    t_sale_item.quantity,
                                                    t_sale_item.quantity * t_sale_item.cost_price AS amount_payment,
                                                    ( WEEK ( SUBSTR( t_sale_item.created_at, 1, 10 ), 4 ) + 1 ) - WEEK(
                                                        DATE_SUB( SUBSTR( t_sale_item.created_at, 1, 10 ), INTERVAL DAYOFMONTH( SUBSTR( t_sale_item.created_at, 1, 10 ) ) - 1 DAY ),
                                                        4 
                                                    ) AS wik 
                                                FROM
                                                    pos_batik.t_sale
                                                    JOIN pos_batik.t_sale_item ON t_sale_item.sale_id = t_sale.sale_number
                                                    JOIN pos_batik.`user` ON `user`.id_user = t_sale.created_by 
                                                WHERE
                                                    SUBSTR( t_sale_item.sale_id, 1, 1 ) = 'S' 
                                                    AND DATE(t_sale_item.created_at) BETWEEN '$periode-01' AND LAST_DAY('$periode-01') 
                                                    AND t_sale_item.item_id IN ( 6770, 6769, 6768 ) 
                                                    AND t_sale.created_by NOT IN ( 50, 51 ) 
                                                ORDER BY
                                                    `user`.employee_name ASC 
                                                ) dt 
                                            GROUP BY
                                                dt.created_by,
                                                wik 
                                            ORDER BY
                                                employee_name,
                                                wik 
                                            ) dt2 ON dt2.created_by = dta.created_by 
                                            AND dt2.wik = dta.wik
                                            LEFT JOIN (
                                            SELECT
                                                dt.created_by,
                                                dt.employee_name,
                                                SUM( dt.quantity ) AS quantity3,
                                                SUM( amount_payment ) AS sales3,
                                                count( amount_payment ) AS transaksi3,
                                                wik,
                                                'item3' AS jenis 
                                            FROM
                                                (
                                                SELECT
                                                    t_sale.created_by,
                                                    `user`.employee_name,
                                                    t_sale_item.quantity,
                                                    t_sale_item.quantity * t_sale_item.cost_price AS amount_payment,
                                                    ( WEEK ( SUBSTR( t_sale_item.created_at, 1, 10 ), 4 ) + 1 ) - WEEK(
                                                        DATE_SUB( SUBSTR( t_sale_item.created_at, 1, 10 ), INTERVAL DAYOFMONTH( SUBSTR( t_sale_item.created_at, 1, 10 ) ) - 1 DAY ),
                                                        4 
                                                    ) AS wik 
                                                FROM
                                                    pos_batik.t_sale
                                                    JOIN pos_batik.t_sale_item ON t_sale_item.sale_id = t_sale.sale_number
                                                    JOIN pos_batik.`user` ON `user`.id_user = t_sale.created_by 
                                                WHERE
                                                    SUBSTR( t_sale_item.sale_id, 1, 1 ) = 'S' 
                                                    AND DATE(t_sale_item.created_at) BETWEEN '$periode-01' AND LAST_DAY('$periode-01') 
                                                    AND t_sale_item.item_id IN ( 37 ) 
                                                    AND t_sale.created_by NOT IN ( 50, 51 ) 
                                                ORDER BY
                                                    `user`.employee_name ASC 
                                                ) dt 
                                            GROUP BY
                                                dt.created_by,
                                                wik 
                                            ORDER BY
                                                employee_name,
                                                wik 
                                            ) dt3 ON dt3.created_by = dta.created_by 
                                            AND dt3.wik = dta.wik 
                                        ) dt,
                                        (
                                        SELECT
                                            tahun,
                                            target 
                                        FROM
                                            m_target_scaleup_kasir 
                                        WHERE
                                            LEFT ( tahun, 7 ) = '$periode' 
                                        ) AS sc 
                                    ) dtx 
                                ) AS final_results 
                            ) AS data_with_achieve 
                        ) AS final_output
                        
                        UNION ALL
                        
                        SELECT
                        'Kelolosan Tag' AS indicator,
                        targetall,
                        actualall,
                        achieveall,
                        nilaiall,
                        targetw1, actualw1, achievew1, nilaiw1,
                        targetw2, actualw2, achievew2, nilaiw2,
                        targetw3, actualw3, achievew3, nilaiw3,
                        targetw4, actualw4, achievew4, nilaiw4,
                        targetw5, actualw5, achievew5, nilaiw5,
                        targetw6, actualw6, achievew6, nilaiw6
                    FROM (
                        SELECT
                            *,
                            ROUND(achieveall * 0.0099, 4) AS nilaiall,
                            ROUND(achievew1 * 0.0099, 4) AS nilaiw1,
                            ROUND(achievew2 * 0.0099, 4) AS nilaiw2,
                            ROUND(achievew3 * 0.0099, 4) AS nilaiw3,
                            ROUND(achievew4 * 0.0099, 4) AS nilaiw4,
                            ROUND(achievew5 * 0.0099, 4) AS nilaiw5,
                            ROUND(achievew6 * 0.0099, 4) AS nilaiw6
                        FROM (
                            SELECT
                                2 AS targetall,
                                base.actualall,
                                LEAST(GREATEST(ROUND((1 - (base.actualall / 2)) * 100, 2), 0), 100) AS achieveall,

                                2 AS targetw1,
                                base.actualw1,
                                LEAST(GREATEST(ROUND((1 - (base.actualw1 / 2)) * 100, 2), 0), 100) AS achievew1,

                                2 AS targetw2,
                                base.actualw2,
                                LEAST(GREATEST(ROUND((1 - (base.actualw2 / 2)) * 100, 2), 0), 100) AS achievew2,

                                2 AS targetw3,
                                base.actualw3,
                                LEAST(GREATEST(ROUND((1 - (base.actualw3 / 2)) * 100, 2), 0), 100) AS achievew3,

                                2 AS targetw4,
                                base.actualw4,
                                LEAST(GREATEST(ROUND((1 - (base.actualw4 / 2)) * 100, 2), 0), 100) AS achievew4,

                                2 AS targetw5,
                                base.actualw5,
                                LEAST(GREATEST(ROUND((1 - (base.actualw5 / 2)) * 100, 2), 0), 100) AS achievew5,

                                2 AS targetw6,
                                base.actualw6,
                                LEAST(GREATEST(ROUND((1 - (base.actualw6 / 2)) * 100, 2), 0), 100) AS achievew6
                            FROM (
                                SELECT
                                    COUNT(DISTINCT tag.id) AS actualall,
                                    COUNT(DISTINCT CASE WHEN mwk.`week` = 1 THEN tag.id END) AS actualw1,
                                    COUNT(DISTINCT CASE WHEN mwk.`week` = 2 THEN tag.id END) AS actualw2,
                                    COUNT(DISTINCT CASE WHEN mwk.`week` = 3 THEN tag.id END) AS actualw3,
                                    COUNT(DISTINCT CASE WHEN mwk.`week` = 4 THEN tag.id END) AS actualw4,
                                    COUNT(DISTINCT CASE WHEN mwk.`week` = 5 THEN tag.id END) AS actualw5,
                                    COUNT(DISTINCT CASE WHEN mwk.`week` = 6 THEN tag.id END) AS actualw6
                                FROM
                                    t_lolos_tag AS tag
                                    JOIN `user` AS usr ON usr.id_user = tag.kasir
                                    JOIN t_sale AS sale ON sale.sale_number = tag.no_struk
                                    JOIN m_week_kpi mwk ON SUBSTR(sale.created_at, 1, 10) BETWEEN mwk.`start` AND mwk.`end` AND mwk.id_tag = 1
                                WHERE
                                    SUBSTR(sale.created_at, 1, 10) BETWEEN '$periode-01' AND LAST_DAY('$periode-01')
                                    AND mwk.periode = '$periode'
                                    AND tag.qty_tag > 0
                            ) AS base
                        ) AS calc
                    ) AS final";
        
        return $this->db_pos_batik->query($query);
    }

    // Kasir excellent - Temuan CCTV kasir
    function data_temuan_cctv_kasir($periode)
    {
        $query = "SELECT
                    'Temuan CCTV Kasir' AS indicator,
                    `target`,
                    actual,
                    persen_acv,
                    ROUND(persen_acv * 0.0099, 2) AS nilai,
                    target_w1,
                    actual_w1,
                    persen_acv_w1,
                    ROUND(persen_acv_w1 * 0.0099, 2) AS nilai_w1,
                    
                    target_w2,
                    actual_w2,
                    persen_acv_w2,
                    ROUND(persen_acv_w2 * 0.0099, 2) AS nilai_w2,
                    
                    target_w3,
                    actual_w3,
                    persen_acv_w3,
                    ROUND(persen_acv_w3 * 0.0099, 2) AS nilai_w3,
                    
                    target_w4,
                    actual_w4,
                    persen_acv_w4,
                    ROUND(persen_acv_w4 * 0.0099, 2) AS nilai_w4,
                    
                    target_w5,
                    COALESCE(actual_w5, 0) AS actual_w5,
                    COALESCE(persen_acv_w5, 0) AS persen_acv_w5,
                    COALESCE(ROUND(persen_acv_w5 * 0.0099, 2), 0) AS nilai_w5,
                    
                    target_w6,
                    COALESCE(actual_w6, 0) AS actual_w6,
                    COALESCE(persen_acv_w6, 0) AS persen_acv_w6,
                    COALESCE(ROUND(persen_acv_w6 * 0.0099, 2), 0) AS nilai_w6
                FROM (

                    SELECT
                        10 AS target,
                        actual,
                        IF( actual <= 10, 100, ROUND((10 / actual) * 100) ) AS persen_acv,
                        10 AS target_w1,
                        actual_w1,
                        IF( actual_w1 <= 10, 100, ROUND((10 / actual_w1) * 100) ) AS persen_acv_w1,
                        10 AS target_w2,
                        actual_w2,
                        IF( actual_w1 <= 10, 100, ROUND((10 / actual_w1) * 100) ) AS persen_acv_w2,
                        
                        10 AS target_w3,
                        actual_w3,
                        IF( actual_w3 <= 10, 100, ROUND((10 / actual_w3) * 100) ) AS persen_acv_w3,
                        
                        10 AS target_w4,
                        actual_w4,
                        IF( actual_w4 <= 10, 100, ROUND((10 / actual_w4) * 100) ) AS persen_acv_w4,
                        
                        10 AS target_w5,
                        actual_w5,
                        IF( actual_w5 <= 10, 100, ROUND((10 / actual_w5) * 100) ) AS persen_acv_w5,
                        
                        10 AS target_w6,
                        actual_w6,
                        IF( actual_w6 <= 10, 100, ROUND((10 / actual_w6) * 100) ) AS persen_acv_w6
                        
                    FROM (

                        SELECT		
                            ROUND( (SUM(jml_temuan_acc) / SUM(total_cek)) * 100, 2) AS actual,

                            ROUND(MAX(CASE WHEN week=1 THEN actual END), 2) AS actual_w1,
                            ROUND(MAX(CASE WHEN week=2 THEN actual END), 2) AS actual_w2,
                            ROUND(MAX(CASE WHEN week=3 THEN actual END), 2) AS actual_w3,
                            ROUND(MAX(CASE WHEN week=4 THEN actual END), 2) AS actual_w4,
                            ROUND(MAX(CASE WHEN week=5 THEN actual END), 2) AS actual_w5,
                            ROUND(MAX(CASE WHEN week=6 THEN actual END), 2) AS actual_w6
                            FROM (
                                SELECT
                                                w.week,
                                                SUM(1) AS total_cek,
                                                SUM(CASE WHEN a.id_kategori_temuan != 1 AND a.status = 1 THEN 1 ELSE 0 END) AS jml_temuan_acc,
                                                (SUM(CASE WHEN a.id_kategori_temuan != 1 AND a.status = 1 THEN 1 ELSE 0 END) / NULLIF(SUM(1),0)) * 100 AS actual
                                FROM daily_checklist.t_temuan_cctv a
                                LEFT JOIN hris.m_kpi_week w ON DATE(a.waktu_temuan) BETWEEN w.start AND w.end
                                WHERE
                                                DATE(a.waktu_temuan) BETWEEN '$periode-01' AND LAST_DAY('$periode-01')
                                                AND w.periode = '$periode'
                                                AND a.designation_id IN (82,85,91,93,103,1020)
                                GROUP BY w.week
                            ) AS dt
                        
                    ) AS calc

                ) final";
        
        return $this->db->query($query);
    }

    // WH Excellent
    function data_wh_excellent($periode)
    {
        $query = "SELECT
                    'Peningkatan WH Excellent' AS indicator,
                    achievement_w1 AS actual_w1,
                    achievement_w2 AS actual_w2,
                    achievement_w3 AS actual_w3,
                    achievement_w4 AS actual_w4,
                    achievement_w5 AS actual_w5,
                    achievement_w6 AS actual_w6,
                    achievement AS actual 
                FROM (
                    SELECT
                -- WEEK 1
                COUNT( * ) AS jumlah,
                COUNT(IF(COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) < 7201, 1, NULL)) AS ontime,
                COUNT(IF(COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) > 7200, 1, NULL)) AS late,
                    ROUND( COUNT(IF(COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) < 7201, 1, NULL)) / COUNT(*) * 100 , 0) AS achievement,
                    
                100 AS target_w1,
                COUNT(CASE WHEN mkpi.week = 1 THEN 1 END) AS jumlah_w1,
                COUNT(CASE 
                        WHEN mkpi.week = 1 AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) < 7201 
                        THEN 1 
                        ELSE NULL 
                    END) AS ontime_w1,
                COUNT(CASE 
                        WHEN mkpi.week = 1 AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) > 7200
                        THEN 1 
                        ELSE NULL 
                    END) AS late_w1,
                ROUND(
                    (COUNT(CASE 
                    WHEN mkpi.week = 1 
                        AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) < 7201 
                    THEN 1 
                    END) * 100) / 
                NULLIF(COUNT(CASE WHEN mkpi.week = 1 THEN 1 END), 0), 
                0
                ) AS achievement_w1,

                ROUND(
                    (
                    (
                        COUNT(CASE 
                        WHEN mkpi.week = 1 
                            AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) < 7201 
                        THEN 1 
                        END) * 100
                    ) / NULLIF(COUNT(CASE WHEN mkpi.week = 1 THEN 1 END), 0)
                    ) * 1 * 0.2 * 0.2, 
                0
                ) AS nilai_w1,

                -- WEEK 2
                100 AS target_w2,
                COUNT(CASE WHEN mkpi.week = 2 THEN 1 END) AS jumlah_w2,
                COUNT(CASE 
                    WHEN mkpi.week = 2 AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) < 7201 
                    THEN 1 
                        ELSE NULL 
                    END) AS ontime_w2,
                COUNT(CASE 
                    WHEN mkpi.week = 2 AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) > 7200
                    THEN 1 
                        ELSE NULL 
                    END) AS late_w2,
                ROUND(
                    (COUNT(CASE 
                    WHEN mkpi.week = 2 
                        AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) < 7201 
                    THEN 1 
                    END) * 100) / 
                NULLIF(COUNT(CASE WHEN mkpi.week = 2 THEN 1 END), 0), 
                0
                ) AS achievement_w2,

                ROUND(
                    (
                    (
                        COUNT(CASE 
                        WHEN mkpi.week = 2 
                            AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) < 7201 
                        THEN 1 
                        END) * 100
                    ) / NULLIF(COUNT(CASE WHEN mkpi.week = 2 THEN 1 END), 0)
                    ) * 1 * 0.2 * 0.2, 
                    0
                ) AS nilai_w2,

                -- WEEK 3
                100 AS target_w3,
                COUNT(CASE WHEN mkpi.week = 3 THEN 1 END) AS jumlah_w3,
                COUNT(CASE 
                        WHEN mkpi.week = 3 AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) < 7201 
                        THEN 1 
                        ELSE NULL 
                    END) AS ontime_w3,
                COUNT(CASE 
                        WHEN mkpi.week = 3 AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) > 7200
                        THEN 1 
                        ELSE NULL 
                    END) AS late_w3,
                ROUND(
                    (COUNT(CASE 
                    WHEN mkpi.week = 3
                        AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) < 7201 
                    THEN 1 
                    END) * 100) / 
                    NULLIF(COUNT(CASE WHEN mkpi.week = 3 THEN 1 END), 0), 
                0
                ) AS achievement_w3,

                ROUND(
                    (
                    (
                        COUNT(CASE 
                        WHEN mkpi.week = 3
                            AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) < 7201 
                        THEN 1 
                        END) * 100
                    ) / NULLIF(COUNT(CASE WHEN mkpi.week = 3 THEN 1 END), 0)
                    ) * 1 * 0.2 * 0.2, 
                0
                ) AS nilai_w3,

                -- WEEK 4
                100 AS target_w4,
                COUNT(CASE WHEN mkpi.week = 4 THEN 1 END) AS jumlah_w4,
                COUNT(CASE 
                WHEN mkpi.week = 4 AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) < 7201 
                    THEN 1 
                    ELSE NULL 
                END) AS ontime_w4,
                COUNT(CASE 
                WHEN mkpi.week = 4 AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) > 7200
                    THEN 1 
                    ELSE NULL 
                END) AS late_w4,
                ROUND(
                    (COUNT(CASE 
                    WHEN mkpi.week = 4
                        AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) < 7201 
                    THEN 1 
                    END) * 100) / 
                    NULLIF(COUNT(CASE WHEN mkpi.week = 4 THEN 1 END), 0), 
                0
                ) AS achievement_w4,

                ROUND(
                    (
                    (
                        COUNT(CASE 
                        WHEN mkpi.week = 4
                            AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) < 7201 
                        THEN 1 
                        END) * 100
                    ) / NULLIF(COUNT(CASE WHEN mkpi.week = 4 THEN 1 END), 0)
                    ) * 1 * 0.2 * 0.2, 
                0
                ) AS nilai_w4,

                -- WEEK 5
                100 AS target_w5,
                COUNT(CASE WHEN mkpi.week = 5 THEN 1 END) AS jumlah_w5,
                COUNT(CASE 
                    WHEN mkpi.week = 5 AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) < 7201 
                    THEN 1 
                    END) AS ontime_w5,
                COUNT(CASE 
                    WHEN mkpi.week = 5 AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) > 7200
                    THEN 1 
                    END) AS late_w5,

                IF(
                COUNT(CASE WHEN mkpi.week = 5 THEN 1 END) = 0,
                0,
                ROUND(
                    (COUNT(CASE 
                    WHEN mkpi.week = 5 AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) < 7201 
                    THEN 1 
                    END) * 100) / 
                    NULLIF(COUNT(CASE WHEN mkpi.week = 5 THEN 1 END), 0),
                0)
                ) AS achievement_w5,

                IF(
                COUNT(CASE WHEN mkpi.week = 5 THEN 1 END) = 0,
                '-',
                ROUND(
                    (
                    (
                        COUNT(CASE 
                        WHEN mkpi.week = 5 AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) < 7201 
                        THEN 1 
                        END) * 100
                    ) / NULLIF(COUNT(CASE WHEN mkpi.week = 5 THEN 1 END), 0)
                    ) * 0.2 * 0.2,
                0)
                ) AS nilai_w5,

                -- WEEK 6
                100 AS target_w6,
                COUNT(CASE WHEN mkpi.week = 6 THEN 1 END) AS jumlah_w6,
                COUNT(CASE 
                    WHEN mkpi.week = 6 AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) < 7201 
                    THEN 1 
                    END) AS ontime_w6,
                COUNT(CASE 
                    WHEN mkpi.week = 6 AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) > 7200
                    THEN 1 
                    END) AS late_w6,

                IF(
                COUNT(CASE WHEN mkpi.week = 6 THEN 1 END) = 0,
                -- '-',
                0,
                ROUND(
                    (COUNT(CASE 
                    WHEN mkpi.week = 6 AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) < 7201 
                    THEN 1 
                    END) * 100) / 
                    NULLIF(COUNT(CASE WHEN mkpi.week = 6 THEN 1 END), 0),
                0)
                ) AS achievement_w6,

                IF(
                COUNT(CASE WHEN mkpi.week = 6 THEN 1 END) = 0,
                '-',
                ROUND(
                    (
                    (
                        COUNT(CASE 
                        WHEN mkpi.week = 6 AND COALESCE(TIME_TO_SEC(TIMEDIFF(item.created_at, item.last_nsafe)), 0) < 7201 
                        THEN 1 
                        END) * 100
                    ) / NULLIF(COUNT(CASE WHEN mkpi.week = 6 THEN 1 END), 0)
                    ) * 0.2 * 0.2,
                0)
                ) AS nilai_w6

                FROM t_wh_distribusi dist
                JOIN t_wh_distribusi_item item 
                ON item.id_distribusi = dist.id_distribusi 
                AND dist.distribusi = 1
                LEFT JOIN pos_batik.m_product ON item.id_produk = m_product.item_number
                LEFT JOIN pos_batik.m_week_kpi mkpi 
                ON DATE(item.created_at) BETWEEN mkpi.start AND mkpi.end
                WHERE
                mkpi.periode = '$periode'
                AND mkpi.id_tag = 1
                AND SUBSTR(dist.created_at,1,7) = '$periode'
                --   AND item.last_nsafe IS NOT NULL
                --   AND item.created_at IS NOT NULL
                AND SUBSTR(item.id_produk, 1, 2) != 'XX'
                AND SUBSTR(item.nama_produk, 1, 3) != 'SP '
                    AND item.stock_store <= m_product.minimum_stock 
                ORDER BY mkpi.week
                ) wh_excellent";

        return $this->db_purchasing_crb->query($query)->row_array();
    }

    //Marketing Offline
    function data_mk_offline($periode)
    {
        $query = "SELECT 
                    'Marketing Offline' AS indicator,
                    COUNT(DISTINCT mwk.week) AS total_week,
                    SUM(tr.traffic_sticker) AS actual,
                    SUM(CASE WHEN mwk.week = 1 THEN tr.traffic_sticker ELSE 0 END) AS actual_w1,
                    SUM(CASE WHEN mwk.week = 2 THEN tr.traffic_sticker ELSE 0 END) AS actual_w2,
                    SUM(CASE WHEN mwk.week = 3 THEN tr.traffic_sticker ELSE 0 END) AS actual_w3,
                    SUM(CASE WHEN mwk.week = 4 THEN tr.traffic_sticker ELSE 0 END) AS actual_w4,
                    SUM(CASE WHEN mwk.week = 5 THEN tr.traffic_sticker ELSE 0 END) AS actual_w5,
                    SUM(CASE WHEN mwk.week = 6 THEN tr.traffic_sticker ELSE 0 END) AS actual_w6,

                    -- Persentase per minggu
                    CASE 
                        WHEN SUM(tr.traffic_sticker) = 0 THEN 0
                        ELSE ROUND(SUM(CASE WHEN mwk.week = 1 THEN tr.traffic_sticker ELSE 0 END) * 100.0 
                                / SUM(tr.traffic_sticker), 2)
                    END AS persen_w1,

                    CASE 
                        WHEN SUM(tr.traffic_sticker) = 0 THEN 0
                        ELSE ROUND(SUM(CASE WHEN mwk.week = 2 THEN tr.traffic_sticker ELSE 0 END) * 100.0 
                                / SUM(tr.traffic_sticker), 2)
                    END AS persen_w2,

                    CASE 
                        WHEN SUM(tr.traffic_sticker) = 0 THEN 0
                        ELSE ROUND(SUM(CASE WHEN mwk.week = 3 THEN tr.traffic_sticker ELSE 0 END) * 100.0 
                                / SUM(tr.traffic_sticker), 2)
                    END AS persen_w3,

                    CASE 
                        WHEN SUM(tr.traffic_sticker) = 0 THEN 0
                        ELSE ROUND(SUM(CASE WHEN mwk.week = 4 THEN tr.traffic_sticker ELSE 0 END) * 100.0 
                                / SUM(tr.traffic_sticker), 2)
                    END AS persen_w4,

                    CASE 
                        WHEN SUM(tr.traffic_sticker) = 0 THEN 0
                        ELSE ROUND(SUM(CASE WHEN mwk.week = 5 THEN tr.traffic_sticker ELSE 0 END) * 100.0 
                                / SUM(tr.traffic_sticker), 2)
                    END AS persen_w5,

                    CASE 
                        WHEN SUM(tr.traffic_sticker) = 0 THEN 0
                        ELSE ROUND(SUM(CASE WHEN mwk.week = 6 THEN tr.traffic_sticker ELSE 0 END) * 100.0 
                                / SUM(tr.traffic_sticker), 2)
                    END AS persen_w6

                FROM traffic tr
                JOIN pos_batik.m_week_kpi mwk 
                    ON DATE(tr.periode) BETWEEN mwk.start AND mwk.end
                WHERE mwk.periode = '$periode'
        ";
        return $this->db_pos_batik->query($query);
    }

    // ----------------------------------------- END --------------------------------------------


    // Fungsi dari model dashboard review sistem
    // Ticket per Divisi
    function dt_ticket_perdivisi($periode)
    {
        $query = "SELECT 
                    dep.department_name AS divisi,
                    com.`name` AS company,
                    COUNT(tt.id_task) AS total_pengajuan, 
                    SUM(CASE WHEN tt.status = 1 THEN 1 ELSE 0 END) AS total_notstarted,
                    SUM(CASE WHEN tt.status = 5 THEN 1 ELSE 0 END) AS total_workingon,
                    SUM(CASE WHEN tt.status = 12 THEN 1 ELSE 0 END) AS total_uat,
                    SUM(CASE WHEN tt.status = 3 THEN 1 ELSE 0 END) AS total_done,
                    SUM(CASE WHEN tt.status = 4 THEN 1 ELSE 0 END) AS total_cancel,
                    SUM(CASE WHEN tt.status = 7 THEN 1 ELSE 0 END) AS total_hold,
                    SUM(CASE WHEN tt.status = 8 THEN 1 ELSE 0 END) AS total_waitinglist,
                    SUM(CASE WHEN tt.status = 3 THEN 1 ELSE 0 END) + SUM(CASE WHEN tt.status = 12 THEN 1 ELSE 0 END) + SUM(CASE WHEN tt.status = 5 THEN 1 ELSE 0 END) AS total_progres
                FROM
                    ticket_task tt
                    JOIN xin_employees emp ON tt.created_by = emp.user_id
                    JOIN xin_departments dep ON dep.department_id = emp.department_id
                    JOIN xin_companies com ON com.company_id = dep.company_id
                WHERE
                    (DATE(tt.created_at) BETWEEN '$periode-01' AND LAST_DAY('$periode-01'))
                    OR (tt.due_date BETWEEN '$periode-01' AND LAST_DAY('$periode-01') AND tt.type IN (1,2))
                GROUP BY dep.department_id, dep.department_name, com.name";

        return $this->db->query($query)->result();
    }

    // Statistik Progres Tiket
    function get_pencapaian_progres_tiket($periode)
    {
        $query = "SELECT 
                    '$periode' AS periode,
                    COUNT(tt.id_task) AS total_tiket,
                    SUM(CASE WHEN tt.status IN(3, 12) THEN 1 ELSE 0 END) AS total_done,
                    ROUND( ( SUM(CASE WHEN tt.status IN(3, 12) THEN 1 ELSE 0 END) / COUNT(tt.id_task) ) * 100, 2 ) AS persen_done,
                    SUM(CASE WHEN tt.status = 5 THEN 1 END) AS total_onprogress,
                    ROUND(SUM(CASE WHEN tt.status = 5 THEN 1 END) / COUNT(tt.id_task) * 100, 2) AS persen_onprogress
                FROM
                    ticket_task tt
                    JOIN xin_employees emp ON tt.created_by = emp.user_id
                    JOIN xin_departments dep ON dep.department_id = emp.department_id
                    JOIN xin_companies com ON com.company_id = dep.company_id
                WHERE
                    (DATE(tt.created_at) BETWEEN '$periode-01' AND LAST_DAY('$periode-01'))
                    OR (tt.due_date BETWEEN '$periode-01' AND LAST_DAY('$periode-01') AND tt.type IN (1,2))";

        return $this->db->query($query)->row();
    }

    // Tracking System Error : Resume
    function get_tracking_system_error($periode)
    {
        $query = "SELECT
                    COUNT(
                    IF
                    ( id_category = 2, id_category, NULL )) eror,
                    COUNT(
                    IF
                    ( id_category = 6, id_category, NULL )) bug,
                    COUNT( id_category ) total,
                    COUNT(
                    IF
                    ( (id_category = 2 OR id_category = 6) AND id_status = 3, id_category, NULL )) total_solved,
                    ROUND(
                        COUNT(IF( (id_category = 2 OR id_category = 6) AND id_status = 3, id_category, NULL )) /
                        COUNT( id_category )
                    , 2) * 100 AS persen_solved
                FROM
                    (
                    SELECT
                        t.id_task,
                        t.task,
                        t.description,
                        DATE_FORMAT( t.created_at, '%d %b %y' ) AS tgl_dibuat,
                        COALESCE ( DATE_FORMAT( t.START, '%d %b %y' ), '' ) AS tgl_diproses,
                        SUBSTR( t.created_at, 12, 5 ) AS jam_dibuat,
                        CONCAT( em.first_name, ' ', em.last_name ) AS owner_name,
                        GROUP_CONCAT(
                        DISTINCT CONCAT( ' ', e.first_name, ' ', e.last_name )) AS pic,
                        t.progress,
                        COALESCE ( SUBSTR( t.START, 1, 10 ), '' ) AS START,
                    COALESCE ( SUBSTR( t.END, 1, 10 ), '' ) AS 
                    END,
                    t.type AS id_type,
                    t.category AS id_category,
                    c.category,
                    o.object,
                    s.STATUS,
                    s.id AS id_status,
                    pic AS id_pic,
                    e.user_id 
                FROM
                    ticket_task t
                    LEFT JOIN xin_employees e ON FIND_IN_SET( e.user_id, t.pic )
                    LEFT JOIN xin_employees em ON em.user_id = t.created_by
                    LEFT JOIN xin_companies cmp ON cmp.company_id = em.company_id
                    LEFT JOIN xin_departments d ON d.department_id = em.department_id
                    LEFT JOIN ticket_type ty ON ty.id = t.type
                    LEFT JOIN ticket_category c ON c.id = t.category
                    LEFT JOIN ticket_object o ON o.id = t.object
                    LEFT JOIN ticket_status s ON s.id = t.`status`
                    LEFT JOIN ticket_priority p ON p.id = t.priority 
                WHERE
                    t.category IN ( 2, 6 ) 
                    AND t.STATUS != 4 
                    AND ( SUBSTR( t.`end`, 1, 7 ) = '$periode' OR SUBSTR( t.due_date, 1, 7 ) = '$periode' ) 
                GROUP BY
                    t.id_task 
                ORDER BY
                    t.category 
                    ) dt";

        return $this->db->query($query)->row();
    }

    // Tracking System Error : Detail List
    function get_list_ticket_error($periode)
    {
        $query = "SELECT
                    t.task AS bug_error,
                    CONCAT( em.first_name, ' ', em.last_name ) AS `user`,
                    o.object,
                    s.`status`,
                    l.level,
                    pic AS id_pic,
                    GROUP_CONCAT(
                        DISTINCT CONCAT( ' ', e.first_name, ' ', e.last_name )) AS pic,
                    t.created_at,
                    p.priority
                FROM
                    ticket_task t
                    LEFT JOIN xin_employees e ON FIND_IN_SET( e.user_id, t.pic )
                    LEFT JOIN xin_employees em ON em.user_id = t.created_by
                    LEFT JOIN xin_companies cmp ON cmp.company_id = em.company_id
                    LEFT JOIN xin_departments d ON d.department_id = em.department_id
                    LEFT JOIN ticket_type ty ON ty.id = t.type
                    LEFT JOIN ticket_category c ON c.id = t.category
                    LEFT JOIN ticket_object o ON o.id = t.object
                    LEFT JOIN ticket_status s ON s.id = t.`status`
                    LEFT JOIN ticket_priority p ON p.id = t.priority
                    LEFT JOIN ticket_level l ON l.id = t.level 
                WHERE
                    t.category IN ( 2, 6 ) 
                    -- t.category IN ( 2, 3, 6 ) 
                    AND t.STATUS != 4 
                    AND ( SUBSTR( t.`end`, 1, 7 ) = '$periode' OR SUBSTR( t.due_date, 1, 7 ) = '$periode' ) 
                GROUP BY
                    t.id_task 
                ORDER BY
                    t.category";

        return $this->db->query($query)->result();
    }

    // Resume Ticket by PIC
    function get_resume_ticket_by_pic($periode)
    {
        $query = "SELECT 
                    CONCAT(pic.first_name, ' ', pic.last_name) AS pic,
                    COUNT(tt.id_task) AS total_ticket,
                    COALESCE(SUM(CASE WHEN tt.status = 3 THEN 1 END), 0) AS ticket_done,
                    COALESCE(
                        ROUND(
                            (SUM(CASE WHEN tt.status = 3 THEN 1 END) / COUNT(tt.id_task)) * 100,
                            1
                        )
                    , 0) AS persen_done,

                    -- Ticket Done On-Time
                    SUM(
                        CASE 
                            WHEN tt.status = 3 AND substr(tt.done_date, 1, 10) <= tt.due_date 
                            THEN 1 
                        END
                    ) AS ticket_done_ontime,

                    -- Persentase Leadtime
                    COALESCE(
                        ROUND(
                            (SUM(
                                CASE 
                                    WHEN tt.status = 3 AND substr(tt.done_date, 1, 10) <= tt.due_date 
                                    THEN 1 
                                END
                            ) / NULLIF(SUM(CASE WHEN tt.status = 3 THEN 1 END), 0)) * 100,
                            1
                        )
                    , 0) AS persen_leadtime

                FROM ticket_task tt
                JOIN xin_employees pic 
                    ON tt.pic = pic.user_id
                WHERE
                    pic.department_id = 68
                    -- AND pic.is_active = 1
                    AND (DATE(tt.created_at) BETWEEN '$periode-01' AND LAST_DAY('$periode-01'))
                    OR (tt.due_date BETWEEN '$periode-01' AND LAST_DAY('$periode-01') AND tt.type IN (1,2))
                GROUP BY pic.user_id";

        return $this->db->query($query)->result();
    }

    // Traffic System Overview
    function resume_traffic_system_overview($periode)
    {
        $query = "SELECT
                     'All Divisi' AS divisi,
                     COUNT(*) AS jumlah_sistem,
                     SUM( CASE WHEN jumlah_traffic IS NOT NULL THEN 1 END ) AS jumlah_sistem_digunakan,
                     ROUND( SUM( CASE WHEN jumlah_traffic IS NOT NULL THEN 1 END ) / COUNT(*) * 100, 2 ) AS persen_sistem_digunakan,
                 -- 	COUNT( * ) AS jml_traffic_all,
                     COUNT( IF(kategori_traffic = 'Sering', 1, NULL) ) AS jml_traffic_sering,
                     ROUND( COUNT( IF(kategori_traffic = 'Sering', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_sering,
                     COUNT( IF(kategori_traffic = 'Jarang', 1, NULL) ) AS jml_traffic_jarang,
                     ROUND( COUNT( IF(kategori_traffic = 'Jarang', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_jarang,
                     COUNT( IF(kategori_traffic = 'Tidak digunakan', 1, NULL) ) AS jml_traffic_tidak_digunakan,
                     ROUND( COUNT( IF(kategori_traffic = 'Tidak digunakan', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_tidak_digunakan
                 FROM (
                     SELECT 
                         m.*,
                         h.jumlah_traffic,
                         CASE 
                             WHEN jumlah_traffic >= 1000 THEN 'Sering'
                             WHEN jumlah_traffic IS NULL THEN 'Tidak digunakan'
                             ELSE 'Jarang' 
                         END AS kategori_traffic
                     FROM
                         rsp_project_live.m_menu_rsp m
                         LEFT JOIN(
                             SELECT 
                                 menu,title,link, COUNT(id) AS jumlah_traffic 
                             FROM 
                                 rsp_project_live.history_menu 
                             WHERE
                                 DATE(accessed_at) BETWEEN '$periode-01' AND LAST_DAY('$periode-01') GROUP BY menu,title,link
                         ) AS h ON h.menu = m.menu AND h.title = m.title AND h.link = m.link
                 ) sq_traffic";

        return $this->db->query($query)->result();
    }

     function dt_traffic_system_overview($periode)
    {
        $query = "SELECT
                    divisi,
                    COUNT(*) AS jumlah_sistem,
                    SUM( CASE WHEN jumlah_traffic IS NOT NULL THEN 1 END ) AS jumlah_sistem_digunakan,
                    ROUND( SUM( CASE WHEN jumlah_traffic IS NOT NULL THEN 1 END ) / COUNT(*) * 100, 2 ) AS persen_sistem_digunakan,
                    -- 	COUNT( * ) AS jml_traffic_all,
                    COUNT( IF(kategori_traffic = 'Sering', 1, NULL) ) AS jml_traffic_sering,
                    ROUND( COUNT( IF(kategori_traffic = 'Sering', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_sering,
                    COUNT( IF(kategori_traffic = 'Jarang', 1, NULL) ) AS jml_traffic_jarang,
                    ROUND( COUNT( IF(kategori_traffic = 'Jarang', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_jarang,
                    COUNT( IF(kategori_traffic = 'Tidak digunakan', 1, NULL) ) AS jml_traffic_tidak_digunakan,
                    ROUND( COUNT( IF(kategori_traffic = 'Tidak digunakan', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_tidak_digunakan
                FROM (
                    SELECT 
                        m.*,
                        h.jumlah_traffic,
                        CASE 
                            WHEN jumlah_traffic >= 1000 THEN 'Sering'
                            WHEN jumlah_traffic IS NULL THEN 'Tidak digunakan'
                            ELSE 'Jarang' 
                        END AS kategori_traffic
                    FROM
                        rsp_project_live.m_menu_rsp m
                        LEFT JOIN(
                            SELECT 
                                menu,title,link, COUNT(id) AS jumlah_traffic 
                            FROM 
                                rsp_project_live.history_menu 
                            WHERE
                                DATE(accessed_at) BETWEEN '$periode-01' AND LAST_DAY('$periode-01') GROUP BY menu,title,link
                        ) AS h ON h.menu = m.menu AND h.title = m.title AND h.link = m.link
                ) sq_traffic
                WHERE
	                divisi IS NOT NULL
                GROUP BY divisi";

        return $this->db->query($query)->result();
    }

    // function get_list_traffic_system_overview($periode)
    // {
    //     $query = "SELECT
    //                 divisi,
    //                 COUNT(*) AS jumlah_sistem,
    //                 SUM( CASE WHEN jumlah_traffic IS NOT NULL THEN 1 END ) AS jumlah_sistem_digunakan,
    //                 ROUND( SUM( CASE WHEN jumlah_traffic IS NOT NULL THEN 1 END ) / COUNT(*) * 100, 2 ) AS persen_sistem_digunakan,
    //                 -- 	COUNT( * ) AS jml_traffic_all,
    //                 COUNT( IF(kategori_traffic = 'Sering', 1, NULL) ) AS jml_traffic_sering,
    //                 ROUND( COUNT( IF(kategori_traffic = 'Sering', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_sering,
    //                 COUNT( IF(kategori_traffic = 'Jarang', 1, NULL) ) AS jml_traffic_jarang,
    //                 ROUND( COUNT( IF(kategori_traffic = 'Jarang', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_jarang,
    //                 COUNT( IF(kategori_traffic = 'Tidak digunakan', 1, NULL) ) AS jml_traffic_tidak_digunakan,
    //                 ROUND( COUNT( IF(kategori_traffic = 'Tidak digunakan', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_tidak_digunakan
    //             FROM (
    //                 SELECT 
    //                     m.*,
    //                     h.jumlah_traffic,
    //                     CASE 
    //                         WHEN jumlah_traffic >= 1000 THEN 'Sering'
    //                         WHEN jumlah_traffic IS NULL THEN 'Tidak digunakan'
    //                         ELSE 'Jarang' 
    //                     END AS kategori_traffic
    //                 FROM
    //                     rsp_project_live.m_menu_rsp m
    //                     LEFT JOIN(
    //                         SELECT 
    //                             menu,title,link, COUNT(id) AS jumlah_traffic 
    //                         FROM 
    //                             rsp_project_live.history_menu 
    //                         WHERE
    //                             DATE(accessed_at) BETWEEN '$periode-01' AND LAST_DAY('$periode-01') GROUP BY menu,title,link
    //                     ) AS h ON h.menu = m.menu AND h.title = m.title AND h.link = m.link
    //             ) sq_traffic
    //             WHERE
	//                 divisi IS NOT NULL
    //             GROUP BY divisi

    //             UNION ALL

    //             SELECT
    //                 'All Divisi' AS divisi,
    //                 COUNT(*) AS jumlah_sistem,
    //                 SUM( CASE WHEN jumlah_traffic IS NOT NULL THEN 1 END ) AS jumlah_sistem_digunakan,
    //                 ROUND( SUM( CASE WHEN jumlah_traffic IS NOT NULL THEN 1 END ) / COUNT(*) * 100, 2 ) AS persen_sistem_digunakan,
    //             -- 	COUNT( * ) AS jml_traffic_all,
    //                 COUNT( IF(kategori_traffic = 'Sering', 1, NULL) ) AS jml_traffic_sering,
    //                 ROUND( COUNT( IF(kategori_traffic = 'Sering', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_sering,
    //                 COUNT( IF(kategori_traffic = 'Jarang', 1, NULL) ) AS jml_traffic_jarang,
    //                 ROUND( COUNT( IF(kategori_traffic = 'Jarang', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_jarang,
    //                 COUNT( IF(kategori_traffic = 'Tidak digunakan', 1, NULL) ) AS jml_traffic_tidak_digunakan,
    //                 ROUND( COUNT( IF(kategori_traffic = 'Tidak digunakan', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_tidak_digunakan
    //             FROM (
    //                 SELECT 
    //                     m.*,
    //                     h.jumlah_traffic,
    //                     CASE 
    //                         WHEN jumlah_traffic >= 1000 THEN 'Sering'
    //                         WHEN jumlah_traffic IS NULL THEN 'Tidak digunakan'
    //                         ELSE 'Jarang' 
    //                     END AS kategori_traffic
    //                 FROM
    //                     rsp_project_live.m_menu_rsp m
    //                     LEFT JOIN(
    //                         SELECT 
    //                             menu,title,link, COUNT(id) AS jumlah_traffic 
    //                         FROM 
    //                             rsp_project_live.history_menu 
    //                         WHERE
    //                             DATE(accessed_at) BETWEEN '$periode-01' AND LAST_DAY('$periode-01') GROUP BY menu,title,link
    //                     ) AS h ON h.menu = m.menu AND h.title = m.title AND h.link = m.link
    //             ) sq_traffic";

    //     return $this->db->query($query)->result();
    // }

    // Progress Review System
    function resume_progress_review_system($periode)
    {
        $query = "SELECT
                    COUNT(*) AS jumlah_sistem,
                    sq_sdh_review.jml_sistem_sudah_direview,
                    ROUND(sq_sdh_review.jml_sistem_sudah_direview / COUNT(*) * 100, 2) AS persen_progres_review,
                    sq_sdh_sesuai.jml_sistem_sudah_sesuai AS sudah_sesuai,
                    sq_tdk_sesuai.jml_sistem_tidak_sesuai + sq_krg_sesuai.jml_sistem_kurang_sesuai AS tidak_sesuai,
                    ROUND(sq_sdh_sesuai.jml_sistem_sudah_sesuai / sq_sdh_review.jml_sistem_sudah_direview * 100) AS persen_sesuai,
                    
                    sq_kepuasan.jml_sudah_puas,
                    ROUND(sq_kepuasan.jml_sudah_puas / sq_sdh_review.jml_sistem_sudah_direview * 100)  AS persen_kepuasan
                FROM
                    review_m_navigation
                    LEFT JOIN (
                        SELECT
                            COUNT(*) AS jml_sistem_sudah_direview
                        FROM (
                            SELECT
                                id_navigation
                            FROM
                                review_t_menu_item 
                            GROUP BY
                                id_navigation
                        ) AS nav
                    ) AS sq_sdh_review ON 1 = 1
                    
                    LEFT JOIN (
                        SELECT
                            COUNT(*) AS jml_sistem_sudah_sesuai
                        FROM (
                            SELECT
                                id_navigation, kesesuaian_aplikasi
                            FROM
                                review_t_menu_item
                            WHERE kesesuaian_aplikasi = 'Sesuai' 
                            GROUP BY
                                id_navigation
                        ) AS nav
                    ) AS sq_sdh_sesuai ON 1 = 1
                    
                    LEFT JOIN (
                        SELECT
                            COUNT(*) AS jml_sistem_tidak_sesuai
                        FROM (
                            SELECT
                                id_navigation, kesesuaian_aplikasi
                            FROM
                                review_t_menu_item
                            WHERE kesesuaian_aplikasi = 'Tidak Sesuai' 
                            GROUP BY
                                id_navigation
                        ) AS nav
                    ) AS sq_tdk_sesuai ON 1 = 1
                    
                    LEFT JOIN (
                        SELECT
                            COUNT(*) AS jml_sistem_kurang_sesuai
                        FROM (
                            SELECT
                                id_navigation, kesesuaian_aplikasi
                            FROM
                                review_t_menu_item
                            WHERE kesesuaian_aplikasi = 'Kurang Sesuai' 
                            GROUP BY
                                id_navigation
                        ) AS nav
                    ) AS sq_krg_sesuai ON 1 = 1
                    
                    LEFT JOIN (
                        SELECT
                            COUNT(*) AS jml_sudah_puas
                        FROM (
                            SELECT * FROM review_t_menu_item WHERE kepuasan_aplikasi IN(5,4) GROUP BY id_navigation
                        ) AS puas
                    ) AS sq_kepuasan ON 1 = 1";

        return $this->db->query($query)->row();
    }
    
    function dt_system_reviewed($periode)
    {
        $query = "SELECT
                    menu
                FROM (
                    SELECT 
                        link, m.menu, m.sub_menu, m.sub_sub_menu
                    FROM 
                        review_t_menu_item t
                        JOIN review_m_navigation m ON m.id = t.id_navigation
                    GROUP BY id_navigation
                    ORDER BY id_navigation ASC
                ) list_reviewed
                GROUP BY menu";

        return $this->db->query($query)->result();
    }

    function dt_system_not_reviewed($periode)
    {
        $query = "SELECT 
                    menu
                FROM (
                    SELECT menu FROM review_m_navigation GROUP BY menu
                ) sq
                WHERE menu NOT IN (
                    SELECT
                        menu
                    FROM (
                        SELECT 
                            link, m.menu, m.sub_menu, m.sub_sub_menu
                        FROM 
                            review_t_menu_item t
                            JOIN review_m_navigation m ON m.id = t.id_navigation
                        GROUP BY id_navigation
                        ORDER BY id_navigation ASC
                    ) list_reviewed
                    GROUP BY menu
                )";

        return $this->db->query($query)->result();
    }

    function list_kepuasan_pengguna($periode)
    {
        $query = "SELECT CASE 
                    WHEN q.question = 'Saya merasa navigasi dan antarmuka (UI) aplikasi mudah digunakan.' THEN 'UI'
                    WHEN q.question = 'Kecepatan dan stabilitas kinerja aplikasi memuaskan.' THEN 'Kecepatan'
                    WHEN q.question = 'Data yang dihasilkan dari aplikasi akurat' THEN 'Akurasi'
                    WHEN q.question = 'Apakah aplikasi yang ada saat ini sesuai dengan kebutuhan pekerjaan saat ini?' THEN 'Kesesuaian kebutuhan pekerjaan'
                    WHEN q.question = 'Seberapa efektif sistem saat ini dalam meningkatkan produktivitas dan efisiensi pekerjaan Anda?' THEN 'Produktivitas'
                    WHEN q.question = 'Bagaimana Anda menilai kemampuan divisi IT dalam menyediakan solusi yang inovatif dan efisien?' THEN 'Efisien'
                    WHEN q.question = 'Seberapa puas Anda dengan penggunaan aplikasi secara keseluruhan?' THEN 'Rating'
                END AS jenis_pertanyaan,
                SUM(ai.bobot) AS total_bobot, COUNT(ai.bobot) AS jumlah_data,
                ROUND(SUM(ai.bobot) / COUNT(ai.bobot), 2) AS rata_rata
                FROM qna_answer_item ai
                JOIN qna_answer qa ON qa.id_answer = ai.id_answer
                JOIN qna_m_question_item q ON q.id_question_item = ai.id_question_item
                WHERE DATE(qa.created_at) BETWEEN '$periode-01' AND LAST_DAY('$periode-01')
                AND q.question IN (
                    'Saya merasa navigasi dan antarmuka (UI) aplikasi mudah digunakan.',
                    'Kecepatan dan stabilitas kinerja aplikasi memuaskan.',
                    'Data yang dihasilkan dari aplikasi akurat',
                    'Apakah aplikasi yang ada saat ini sesuai dengan kebutuhan pekerjaan saat ini?',
                    'Seberapa efektif sistem saat ini dalam meningkatkan produktivitas dan efisiensi pekerjaan Anda?',
                    'Bagaimana Anda menilai kemampuan divisi IT dalam menyediakan solusi yang inovatif dan efisien?',
                    'Seberapa puas Anda dengan penggunaan aplikasi secara keseluruhan?'
                )
                GROUP BY jenis_pertanyaan";

        return $this->db->query($query)->result();
    }

}
