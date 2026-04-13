<?php
class SourceReviewSystem
{

    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function calculate($user_id, $periode, $week, $value)
    {
        if ($value['company_ids'] == "") {
            return [
                'target_value' => 0,
                'actual_value' => 0,
                'ach' => 0,
                'ach_value' => 0,
                'ach_weight' => 0,
                'score' => 0,
                'final_ach' => 0,
                'final_score' => 0
            ];
        }
        $review_system = $this->getReviewSystem($user_id, $periode, $week, $value);
        if (empty($review_system)) {
            return [
                'target_value' => 0,
                'actual_value' => 0,
                'ach' => 0,
                'ach_value' => 0,
                'ach_weight' => $value['weight'],
                'score' => 0,
                'final_ach' => 0,
                'final_score' => 0
            ];
        }
        $ach = $review_system['ach'];
        if ($review_system['ach'] >= $value['target_percent']) {
            $ach = 100;
        }
        return [
            'target_value' => $review_system['target_value'],
            'actual_value' => $review_system['actual_value'],
            'ach' => $review_system['ach'],
            'ach_value' => $review_system['ach'],
            'ach_weight' => $value['weight'],
            'score' => ROUND(4 * $ach / 100, 2),
            'final_ach' => ROUND($ach * $value['weight'] / 100),
            'final_score' => ROUND(4 * $ach / 100, 2)
        ];
    }

    private function getReviewSystem($user_ids, $periode, $week, $value)
    {
        $company_ids = $value['company_ids'];
        return $this->CI->db->query("SELECT 
                                SUM(total_item) AS target_value, 
                                SUM(total_item) AS actual_value,
                                ROUND((x.score_kepuasan + x.score_uiux + x.score_impact + x.score_status + x.score_kesesuaian) / 5) AS ach 
                                FROM(
                                    SELECT
                                    rtm.id_review,
                                    xc.name AS company,
                                    xd.department_name AS department,
                                    CONCAT(head.first_name, ' ', head.last_name) AS head_name,
                                    CONCAT(pic.first_name, ' ', pic.last_name) AS pic_name,

                                    COUNT(rtmi.id) AS total_item,

                                    -- KPI Components
                                    ROUND(AVG(rtmi.kepuasan_aplikasi) / 5 * 100, 2) AS score_kepuasan,

                                    ROUND(AVG(
                                        CASE 
                                        WHEN rtmi.kesesuaian_uiux = 'Sesuai' THEN 100
                                        WHEN rtmi.kesesuaian_uiux = 'Tidak Sesuai' THEN 50
                                        ELSE 20
                                        END
                                    ), 2) AS score_uiux,

                                    ROUND(AVG(
                                        CASE 
                                        WHEN rtmi.impact_system = 'Sangat Berimpact' THEN 100
                                        WHEN rtmi.impact_system = 'Kurang Berimpact' THEN 80
                                        WHEN rtmi.impact_system = 'Tidak Berimpact' THEN 60
                                        ELSE 40
                                        END
                                    ), 2) AS score_impact,

                                    ROUND(AVG(
                                        CASE 
                                        WHEN rms.status = 'Digunakan Maksimal' THEN 100
                                        WHEN rms.status = 'Tidak Dipakai' THEN 80
                                        WHEN rms.status = 'Tidak Relevan' THEN 60
                                        WHEN rms.status = 'Perlu Perbaikan' THEN 40
                                        ELSE 20
                                        END
                                    ), 2) AS score_status,

                                    ROUND(AVG(
                                        CASE 
                                        WHEN rtmi.kesesuaian_aplikasi = 'Sesuai' THEN 100
                                        WHEN rtmi.kesesuaian_uiux = 'Kurang Sesuai' THEN 80
                                        WHEN rtmi.kesesuaian_uiux = 'Tidak Sesuai' THEN 60
                                        ELSE 40
                                        END
                                    ), 2) AS score_kesesuaian

                                    FROM review_t_menu_item rtmi

                                    LEFT JOIN review_m_status rms 
                                    ON rtmi.status = rms.id

                                    LEFT JOIN review_t_menu rtm 
                                    ON rtm.id_review = rtmi.id_review

                                    LEFT JOIN review_m_navigation rmn 
                                    ON rmn.id = rtmi.id_navigation

                                    LEFT JOIN review_m_aplikasi rma 
                                    ON rma.id = rmn.id_aplikasi

                                    LEFT JOIN xin_companies xc 
                                    ON xc.company_id = rtm.company_id

                                    LEFT JOIN xin_departments xd 
                                    ON xd.department_id = rtm.department_id

                                    LEFT JOIN xin_employees head 
                                    ON head.user_id = rtm.head_id

                                    LEFT JOIN xin_employees pic 
                                    ON pic.user_id = rtmi.pic

                                    LEFT JOIN xin_employees created 
                                    ON created.user_id = rtm.created_by 

                                    WHERE
                                        SUBSTR(rtmi.deadline_pic, 1, 7) = '$periode' AND xc.company_id IN ($company_ids)
                                ) AS x")->row_array();
    }
}
