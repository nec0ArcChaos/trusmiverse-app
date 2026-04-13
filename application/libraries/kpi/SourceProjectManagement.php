<?php
class SourceProjectManagement
{

    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function calculate($user_id, $periode, $week, $value)
    {
        $type = $value['type'] ?? "";
        if (empty($value['categories'])) {
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
        $role = $value['role'] ?? "";
        $user_ids = $user_id;
        if ($role == "spv") {
            // gabungkan dua user id dan team_ids
            $user_ids = $user_id . "," . $value['team_ids'];
        }
        $get_task = $this->getTaskCompletion($user_ids, $periode, $week, $value);
        if (empty($get_task)) {
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
        switch ($type) {
            case 'task_completion':
                $ach_value = ROUND($get_task['ach'] / $value['target_percent'] * 100);
                if ($ach_value > $value['target_percent']) {
                    $ach_value = 100;
                }
                $ach_weight = ROUND($get_task['ach'] / $value['target_percent'] * $value['weight']);
                $score = ROUND(4 * $ach_value / 100, 2);
                $final_ach = ROUND($ach_value * $value['weight'] / 100);
                $final_score = ROUND($score * $value['weight'] / 100, 2);
                $task_completion = [
                    'target_value' => $get_task['jml_task'] ?? 0,
                    'actual_value' => $get_task['done_task'] ?? 0,
                    'ach' => $get_task['ach'] ?? 0,
                    'ach_value' => $ach_value,
                    'ach_weight' => $ach_weight,
                    'score' => $score,
                    'final_ach' => $final_ach,
                    'final_score' => $final_score
                ];
                return $task_completion;
            case 'task_completion_rsp':
                $ach_value = ROUND($get_task['ach'] / $value['target_percent'] * 100);
                if ($ach_value > $value['target_percent']) {
                    $ach_value = 100;
                }
                $ach_weight = ROUND($get_task['ach'] / $value['target_percent'] * $value['weight']);
                $score = ROUND(4 * $ach_value / 100, 2);
                $final_ach = ROUND($ach_value * $value['weight'] / 100);
                $final_score = ROUND($score * $value['weight'] / 100, 2);
                $task_completion = [
                    'target_value' => $get_task['jml_task'] ?? 0,
                    'actual_value' => $get_task['done_task'] ?? 0,
                    'ach' => $get_task['ach'] ?? 0,
                    'ach_value' => $ach_value,
                    'ach_weight' => $ach_weight,
                    'score' => $score,
                    'final_ach' => $final_ach,
                    'final_score' => $final_score
                ];
                return $task_completion;
            case 'task_completion_bt':
                $ach_value = ROUND($get_task['ach'] / $value['target_percent'] * 100);
                if ($ach_value > $value['target_percent']) {
                    $ach_value = 100;
                }
                $ach_weight = ROUND($get_task['ach'] / $value['target_percent'] * $value['weight']);
                $score = ROUND(4 * $ach_value / 100, 2);
                $final_ach = ROUND($ach_value * $value['weight'] / 100);
                $final_score = ROUND($score * $value['weight'] / 100, 2);
                $task_completion = [
                    'target_value' => $get_task['jml_task'] ?? 0,
                    'actual_value' => $get_task['done_task'] ?? 0,
                    'ach' => $get_task['ach'] ?? 0,
                    'ach_value' => $ach_value,
                    'ach_weight' => $ach_weight,
                    'score' => $score,
                    'final_ach' => $final_ach,
                    'final_score' => $final_score
                ];
                return $task_completion;
            case 'ontime_delivery':
                $ach_value = ROUND($get_task['ach_leadtime'] / $value['target_percent'] * 100);
                if ($ach_value > $value['target_percent']) {
                    $ach_value = 100;
                }
                $ach_weight = ROUND($get_task['ach_leadtime'] / $value['target_percent'] * $value['weight']);
                $score = ROUND(4 * $ach_value / 100, 2);
                $final_ach = ROUND($ach_value * $value['weight'] / 100);
                $final_score = ROUND($score * $value['weight'] / 100, 2);
                $ontime_delivery = [
                    'target_value' => $get_task['jml_task'] ?? 0,
                    'actual_value' => $get_task['ontime'] ?? 0,
                    'ach' => $get_task['ach_leadtime'] ?? 0,
                    'ach_value' => $ach_value,
                    'ach_weight' => $ach_weight,
                    'score' => $score,
                    'final_ach' => $final_ach,
                    'final_score' => $final_score
                ];
                return $ontime_delivery;
            case 'downtime':
                $ach_value = ROUND($get_task['ach_leadtime'] / $value['target_percent'] * 100);
                if ($ach_value > $value['target_percent']) {
                    $ach_value = 100;
                }
                $ach_weight = ROUND($get_task['ach_leadtime'] / $value['target_percent'] * $value['weight']);
                $score = ROUND(4 * $ach_value / 100, 2);
                $final_ach = ROUND($ach_value * $value['weight'] / 100);
                $final_score = ROUND($score * $value['weight'] / 100, 2);
                $downtime_delivery = [
                    'target_value' => $get_task['target_downtime'] ?? 0,
                    'actual_value' => $get_task['actual_downtime'] ?? 0,
                    'ach' => $get_task['ach_downtime'] ?? 0,
                    'ach_value' => $ach_value,
                    'ach_weight' => $ach_weight,
                    'score' => $score,
                    'final_ach' => $final_ach,
                    'final_score' => $final_score
                ];
                return $downtime_delivery;
            case 'incident':
                // spesial case perhitungan terbalik semakin besar semakin jelek
                $ach_value = $get_task['ach_incident'];
                if ($ach_value > 100) {
                    $ach_value = 100;
                }
                $ach_weight = ROUND($get_task['ach_incident'] / 1 * $value['weight']);
                $score = ROUND(4 * $ach_value / 100, 2);
                $final_ach = ROUND($ach_value * $value['weight'] / 100);
                $final_score = ROUND($score * $value['weight'] / 100, 2);
                $incident = [
                    'target_value' => $get_task['target_incident'] ?? 0,
                    'actual_value' => $get_task['actual_incident'] ?? 0,
                    'ach' => $get_task['ach_incident'] ?? 0,
                    'ach_value' => $ach_value,
                    'ach_weight' => $ach_weight,
                    'score' => $score,
                    'final_ach' => $final_ach,
                    'final_score' => $final_score
                ];
                return $incident;
            default:
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
    }

    private function getTaskCompletion($user_ids, $periode, $week, $value)
    {
        if ($week == "all") {
            $condition_week = "";
        } else {
            $condition_week = "AND ti.week = '$week'";
        }

        $categories = $value['categories'] ?? [];
        if ($value['role'] == "manager" && $value['type'] == 'task_completion_rsp' && $value['team_rsp_ids'] != "") {
            $user_ids = $user_ids . "," . $value['team_rsp_ids'];
        }
        if ($value['role'] == "manager" && $value['type'] == 'task_completion_bt' && $value['team_bt_ids'] != "") {
            $user_ids = $user_ids . "," . $value['team_bt_ids'];
        }
        return $this->CI->db->query("SELECT
                    x.employee_id,
                    x.employee_name,
                    COUNT(DISTINCT x.task_id) AS jml_task,
                    COUNT(IF(x.`status` = '3',1,NULL)) AS done_task,
                    ROUND(COUNT(IF(x.`status` = '3',1,NULL)) / COUNT(DISTINCT x.task_id) * 100) AS ach,
                    COUNT(IF(x.`status_leadtime` = 'ontime',1,NULL)) AS ontime,
                    COUNT(IF(x.`status_leadtime` = 'late',1,NULL)) AS late,
                    ROUND(COUNT(IF(x.`status_leadtime` = 'ontime',1,NULL)) / COUNT(DISTINCT x.task_id) * 100) AS ach_leadtime,
                    x.target_downtime,
                    SUM(x.actual_downtime) AS actual_downtime,
                    ROUND(CASE WHEN SUM(x.actual_downtime)  = 0 THEN 100 
                    WHEN SUM(x.actual_downtime)  > 0 AND SUM(x.actual_downtime)  <= 6 THEN 97 ELSE 100 - ((SUM(x.actual_downtime)  / 6 * 100) - 100) END) AS ach_downtime,
                    x.target_incident,
                    SUM(x.actual_incident) AS actual_incident,
                    ROUND(CASE WHEN SUM(x.actual_incident)  <= 1 THEN 100 ELSE 100 - ((SUM(x.actual_incident)  / 1.5 * 100) - 100) END) AS ach_incident                    
                FROM
                    (
                        SELECT
                        e.user_id AS employee_id,
                        CONCAT(e.first_name, ' ', e.last_name) AS employee_name,
                        ti.project_id,
                        ti.id AS task_id,
                        ti.task_name,
                        SUBSTR(ti.`start_date`, 1, 7) AS periode,
                        ti.`start_date`,
                        ti.deadline,
                        ti.`status`,
                        ti.progress,
                        ti.end_date,
                        TIMESTAMPDIFF(DAY, ti.`start_date`, ti.`deadline`) AS work_day,
                        TIMESTAMPDIFF(DAY, ti.`deadline`, COALESCE(ti.`end_date`, CURRENT_TIME)) AS late_day,
                        IF
                        (TIMESTAMPDIFF(DAY, ti.`deadline`, COALESCE(ti.`end_date`, CURRENT_TIME)) > 0, 'late', 'ontime') AS status_leadtime,
                        6 AS target_downtime,
                        TIMESTAMPDIFF(HOUR, ti.start_date, COALESCE(ti.`end_date`, CURRENT_TIME)) AS actual_downtime,
                        1 AS target_incident,
                        IF(ti.category = 11,1,0) AS actual_incident
                        FROM
                        `t_pm_tasklist` ti
                        LEFT JOIN t_pm_projects t ON t.id = ti.project_id
                        LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id, ti.pic)
                        WHERE
                        e.user_id IN ($user_ids) 
                        AND SUBSTR(ti.`start_date`, 1, 7) = '$periode' AND ti.`status` != '6' AND ti.category IN ($categories) $condition_week
                    GROUP BY ti.id
                    ) AS x
                    GROUP BY x.employee_id")->row_array();
    }
}
