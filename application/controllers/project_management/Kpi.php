<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kpi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('project_management/model_kpi', 'model_kpi');
        $this->load->database();
    }

    public function get_weekly_kpi()
    {
        $user_id = $this->input->post('user_id') != "" ? $this->input->post('user_id') : $this->session->userdata('user_id');
        $periode = $this->input->post('periode');
        $week = $this->input->post('week');
        if (!$user_id || !$week || !$periode) {
            echo json_encode(['status' => false, 'message' => 'Invalid parameters user_id or week or periode']);
            return;
        }

        $data = $this->model_kpi->get_kpi_by_week($user_id);
        $this->load->library('KpiService');
        foreach ($data as $key => $value) {
            $data[$key]['type'] = ucwords(str_replace("_", " ", $value['type']));
            $kpi_result = $this->kpiservice->calculate($user_id, $periode, $week, $value);
            if ($kpi_result) {
                $data[$key]['employee_id'] = $user_id;
                $data[$key]['periode'] = $periode;
                $data[$key]['week'] = $week;
                $data[$key]['target_value'] = $kpi_result['target_value'] ?? 0;
                $data[$key]['actual_value'] = $kpi_result['actual_value'] ?? 0;
                $data[$key]['ach_value'] = $kpi_result['ach_value'] ?? 0;
                $data[$key]['ach_weight'] = $kpi_result['ach_weight'] ?? 0;
                $data[$key]['score'] = $kpi_result['score'] ?? 0;
                $data[$key]['final_ach'] = $kpi_result['final_ach'] ?? 0;
                $data[$key]['final_score'] = $kpi_result['final_score'] ?? 0;
            } else {
                $data[$key]['week'] = $week;
                $data[$key]['target_value'] = 0;
                $data[$key]['actual_value'] = 0;
                $data[$key]['ach_value'] = 0;
                $data[$key]['ach_weight'] = 0;
                $data[$key]['score'] = 0;
                $data[$key]['final_ach'] = 0;
                $data[$key]['final_score'] = 0;
            }
        }

        echo json_encode(['status' => true, 'data' => $data]);
    }

    public function get_kpi_review()
    {
        $employee_id = $this->input->post('employee_id');
        $periode = $this->input->post('periode');
        $week = $this->input->post('week');
        $kpi_id = $this->input->post('kpi_id');

        if (!$kpi_id) {
            echo json_encode(['status' => false, 'message' => 'Invalid parameter']);
            return;
        }

        $kpi_name = "";
        // $kpi_reviews_weekly_scores = $this->model_kpi->get_kpi_reviews_weekly_scores($employee_id, $periode, $week, $kpi_id);
        // if (empty($kpi_reviews_weekly_scores)) {
        $weekly_scores = $this->model_kpi->get_kpi_by_week($employee_id);
        $this->load->library('KpiService');
        foreach ($weekly_scores as $key => $value) {
            $kpi_name = $value['kpi_name'];
            $weekly_scores[$key]['type'] = ucwords(str_replace("_", " ", $value['type']));
            $kpi_result = $this->kpiservice->calculate($employee_id, $periode, $week, $value);
            if ($kpi_result) {
                $weekly_scores[$key]['employee_id'] = $employee_id;
                $weekly_scores[$key]['periode'] = $periode;
                $weekly_scores[$key]['week'] = $week;
                $weekly_scores[$key]['target_value'] = $kpi_result['target_value'];
                $weekly_scores[$key]['actual_value'] = $kpi_result['actual_value'];
                if ($kpi_result['ach'] >= $value['target_percent']) {
                    $weekly_scores[$key]['ach_value'] = 100;
                    $weekly_scores[$key]['ach_weight'] = $value['weight'];
                    $weekly_scores[$key]['score'] = 4;
                    $weekly_scores[$key]['final_ach'] = ROUND($weekly_scores[$key]['ach_value'] * $value['weight'] / 100);
                    $weekly_scores[$key]['final_score'] = ROUND($weekly_scores[$key]['score'] * $value['weight'] / 100, 2);
                } else {
                    $weekly_scores[$key]['ach_value'] = ROUND($kpi_result['ach'] / $value['target_percent'] * 100);
                    $weekly_scores[$key]['ach_weight'] = ROUND($kpi_result['ach'] / $value['target_percent'] * $value['weight']);
                    $weekly_scores[$key]['score'] = ROUND(4 * $weekly_scores[$key]['ach_value'] / 100, 2);
                    $weekly_scores[$key]['final_ach'] = ROUND($weekly_scores[$key]['ach_value'] * $value['weight'] / 100);
                    $weekly_scores[$key]['final_score'] = ROUND($weekly_scores[$key]['score'] * $value['weight'] / 100, 2);
                }
            } else {
                $weekly_scores[$key]['week'] = $week;
                $weekly_scores[$key]['target_value'] = 0;
                $weekly_scores[$key]['actual_value'] = 0;
                $weekly_scores[$key]['ach_value'] = 0;
                $weekly_scores[$key]['score'] = 0;
                $weekly_scores[$key]['final_ach'] = 0;
                $weekly_scores[$key]['final_score'] = 0;
            }
        }

        foreach ($weekly_scores as $key => $value) {
            $kpi_name = $value['kpi_name'];
            $prepared_kpi_weekly_scores[] = [
                'employee_id' => $employee_id,
                'kpi_id' => $value['kpi_id'],
                'kpi_item_id' => $value['kpi_item_id'],
                'kpi_item_name' => $value['kpi_item_name'],
                'reviewer_id' => $this->session->userdata('user_id'),
                'periode' => $periode,
                'week' => $week,
                'snapshot_target_percent' => $value['target_percent'],
                'snapshot_weight' => $value['weight'],
                'snapshot_target_value' => $value['target_value'],
                'snapshot_actual_value' => $value['actual_value'],
                'snapshot_achievement' => ROUND($value['ach_value']),
                'snapshot_achievement_weight' => ROUND($value['ach_weight']),
                'snapshot_score' => ROUND($value['score'], 2),
                'snapshot_final_score' => ROUND($value['final_score'], 2),
                'snapshot_kpi_met' => ROUND($value['ach_value'], 0) >= ROUND($value['target_percent'], 0) ? 1 : 0
            ];
        }
        // } else {
        //     foreach ($kpi_reviews_weekly_scores as $key => $value) {
        //         $prepared_kpi_weekly_scores[] = [
        //             'employee_id' => $employee_id,
        //             'kpi_id' => $value['kpi_id'],
        //             'kpi_item_id' => $value['kpi_item_id'],
        //             'kpi_item_name' => $value['kpi_item_name'],
        //             'reviewer_id' => $value['reviewer_id'],
        //             'periode' => $periode,
        //             'week' => $week,
        //             'snapshot_target_percent' => $value['snapshot_target_percent'],
        //             'snapshot_weight' => $value['snapshot_weight'],
        //             'snapshot_target_value' => $value['snapshot_target_value'],
        //             'snapshot_actual_value' => $value['snapshot_actual_value'],
        //             'snapshot_achievement' => $value['snapshot_achievement'],
        //             'snapshot_achievement_weight' => $value['snapshot_achievement_weight'],
        //             'snapshot_score' => $value['snapshot_score'],
        //             'snapshot_final_score' => $value['snapshot_final_score'],
        //             'snapshot_kpi_met' => $value['snapshot_kpi_met']
        //         ];
        //     }
        // }

        $kpi_reviews_weekly_feedback = $this->model_kpi->get_kpi_reviews_weekly_feedback($employee_id, $periode, $week, $kpi_id);
        if (empty($kpi_reviews_weekly_feedback['kendala_saat_ini'])) {
            $problems = $this->model_kpi->get_tasklist_problems($employee_id, $periode, $week);
            $kendala_saat_ini = $problems;
        } else {
            $kendala_saat_ini = $kpi_reviews_weekly_feedback['kendala_saat_ini'];
        }

        $employee_profile = $this->model_kpi->get_employee_profile($employee_id);
        // masa kerja dalam tahun bulan hari dari date_of_joining
        $masa_kerja = $this->model_kpi->get_employee_masa_kerja($employee_id);

        $rating_text = "";
        $rating = $kpi_reviews_weekly_feedback['rating'] ?? 0;
        if ($rating == 4) {
            $rating_text = "Sangat Baik";
        } else if ($rating == 3) {
            $rating_text = "Baik";
        } else if ($rating == 2) {
            $rating_text = "Cukup";
        } else if ($rating == 1) {
            $rating_text = "Kurang";
        }

        $kpi_review_data = [
            'id' => $kpi_id,
            'week' => $week,
            'employee_name' => $employee_profile['employee_name'],
            'department_name' => $employee_profile['department_name'],
            'badge1' => $employee_profile['designation_name'],
            'badge2' => $masa_kerja,
            'kpi_name' => $kpi_name,
            'review_title' => 'Review Atasan',
            'review_subtitle' => 'Week ' . str_replace("W", "", $week) . ' - ' . date('F Y'),
            'rating' => $kpi_reviews_weekly_feedback['rating'] ?? 3,
            'rating_text' => $rating_text,
            'kpi_scores' => $prepared_kpi_weekly_scores ?? [],
            'feedback' => isset($kpi_reviews_weekly_feedback['feedback']) ? $kpi_reviews_weekly_feedback['feedback'] : "",
            'gap_utama' => isset($kpi_reviews_weekly_feedback['gap_utama']) ? $kpi_reviews_weekly_feedback['gap_utama'] : "",
            'kendala_saat_ini' => $kendala_saat_ini,
            'plan_perbaikan' => isset($kpi_reviews_weekly_feedback['plan_perbaikan']) ? $kpi_reviews_weekly_feedback['plan_perbaikan'] : "",
            'target_week_berikutnya' => isset($kpi_reviews_weekly_feedback['target_week_berikutnya']) ? $kpi_reviews_weekly_feedback['target_week_berikutnya'] : "",
            'signature_name' => isset($kpi_reviews_weekly_feedback['reviewer_name']) ? $kpi_reviews_weekly_feedback['reviewer_name'] : "",
            'signature_role' => isset($kpi_reviews_weekly_feedback['reviewer_designation']) ? $kpi_reviews_weekly_feedback['reviewer_designation'] : "",
            'signature_date' => isset($kpi_reviews_weekly_feedback['reviewed_at']) ? date('d M Y', strtotime($kpi_reviews_weekly_feedback['reviewed_at'])) : date('d M Y'),
            'signature_img' => isset($kpi_reviews_weekly_feedback['signature_img']) && $kpi_reviews_weekly_feedback['signature_img'] != "" ? 'https://trusmiverse.com/apps/' . $kpi_reviews_weekly_feedback['signature_img'] : "",
            'user_avatar' => isset($employee_profile['profile_picture']) && $employee_profile['profile_picture'] != "" ? 'https://trusmiverse.com/hr/uploads/profile/' . $employee_profile['profile_picture'] : ""
        ];

        echo json_encode(['status' => true, 'data' => $kpi_review_data]);
    }

    public function save_kpi_review()
    {
        $employee_id = $this->input->post('employee_id');
        $kpi_id = $this->input->post('kpi_id');
        $kpi_name = $this->input->post('kpi_name');
        $periode = $this->input->post('periode');
        $week = $this->input->post('week');

        $kpi_scores = $this->input->post('kpi_scores');
        $data_score = [];
        $kpi_list = "";
        foreach ($kpi_scores as $key => $score) {
            $kpi_list .= $score['kpi_item_name'] . ", ";
            $data_score[] = [
                'employee_id' => $score['employee_id'],
                'kpi_id' => $score['kpi_id'],
                'kpi_item_id' => $score['kpi_item_id'],
                'kpi_item_name' => $score['kpi_item_name'],
                'reviewer_id' => $score['reviewer_id'],
                'periode' => $score['periode'],
                'week' => $score['week'],
                'snapshot_target_percent' => $score['snapshot_target_percent'],
                'snapshot_weight' => $score['snapshot_weight'],
                'snapshot_target_value' => $score['snapshot_target_value'],
                'snapshot_actual_value' => $score['snapshot_actual_value'],
                'snapshot_achievement' => $score['snapshot_achievement'],
                'snapshot_achievement_weight' => $score['snapshot_achievement_weight'],
                'snapshot_score' => $score['snapshot_score'],
                'snapshot_final_score' => $score['snapshot_final_score'],
                'snapshot_kpi_met' => $score['snapshot_kpi_met'],
                'reviewed_at' => date('Y-m-d H:i:s')
            ];
        }

        if ($data_score) {
            $this->model_kpi->upsert_kpi_scores($data_score);
        }

        $feedback = $this->input->post('feedback', false);
        $gap_utama = $this->input->post('gap_utama', false);
        $kendala_saat_ini = $this->input->post('kendala_saat_ini', false);
        $plan_perbaikan = $this->input->post('plan_perbaikan', false);
        $target_week_berikutnya = $this->input->post('target_week_berikutnya', false);
        $rating = $this->input->post('rating');
        $snapshot_achievement = $this->input->post('snapshot_achievement');
        $snapshot_final_score = $this->input->post('snapshot_final_score');
        $snapshot_kpi_met = $this->input->post('snapshot_kpi_met');



        // TODO: upsert into t_pm_kpi_reviews_weekly_feedback
        $data_feedback = [
            'employee_id' => $employee_id,
            'kpi_id' => $kpi_id,
            'kpi_name' => $kpi_name,
            'reviewer_id' => $this->session->userdata('user_id'),
            'periode' => $periode,
            'week' => $week,
            'rating' => $rating,
            'feedback' => $feedback,
            'gap_utama' => $gap_utama,
            'kendala_saat_ini' => $kendala_saat_ini,
            'plan_perbaikan' => $plan_perbaikan,
            'target_week_berikutnya' => $target_week_berikutnya,
            'snapshot_achievement' => $snapshot_achievement,
            'snapshot_final_score' => $snapshot_final_score,
            'snapshot_kpi_met' => $snapshot_kpi_met,
            'reviewed_at' => date('Y-m-d H:i:s')
        ];

        $this->model_kpi->upsert_kpi_feedback($data_feedback);


        $get_scores_periode = $this->model_kpi->get_kpi_scores_periode($employee_id, $kpi_id, $periode);
        $get_feedback_periode = $this->model_kpi->get_kpi_feedback_periode($employee_id, $kpi_id, $periode);

        $data_monthly = [
            'employee_id' => $employee_id,
            'kpi_id' => $kpi_id,
            'kpi_list' => $kpi_list,
            'reviewer_id' => $this->session->userdata('user_id'),
            'periode' => $periode,
            'rating' => $get_feedback_periode['rating'],
            'snapshot_ach' => $get_feedback_periode['snapshot_achievement'],
            'snapshot_final_score' => $get_feedback_periode['snapshot_final_score'],
            'snapshot_kpi_met' => $get_scores_periode['snapshot_kpi_met'] . '/' . $get_scores_periode['snapshot_kpi_count'],
        ];

        if ($week == 'W1') {
            $data_monthly['snapshot_ach_w1'] = $snapshot_achievement;
            $data_monthly['snapshot_final_score_w1'] = $snapshot_final_score;
        } else if ($week == 'W2') {
            $data_monthly['snapshot_ach_w2'] = $snapshot_achievement;
            $data_monthly['snapshot_final_score_w2'] = $snapshot_final_score;
        } else if ($week == 'W3') {
            $data_monthly['snapshot_ach_w3'] = $snapshot_achievement;
            $data_monthly['snapshot_final_score_w3'] = $snapshot_final_score;
        } else if ($week == 'W4') {
            $data_monthly['snapshot_ach_w4'] = $snapshot_achievement;
            $data_monthly['snapshot_final_score_w4'] = $snapshot_final_score;
        }
        // TODO: upsert t_pm_kpi_reviews_monthly

        $save = $this->model_kpi->upsert_kpi_monthly($data_monthly);



        // $save = $this->model_kpi->save_kpi_review($data);

        if ($save) {
            echo json_encode(['status' => true, 'message' => 'Review berhasil disimpan!']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Review gagal disimpan!']);
        }
        return;
    }
}
