<?php
class SourceTicket
{

    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function calculate($user_id, $periode, $week, $value)
    {
        $type = $value['type'] ?? "";
        $get_ticket = $this->getTicketCompletion($user_id, $periode, $week, $value);
        if (empty($get_ticket)) {
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
            case 'ticket_completion':
                $ach_value = ROUND($get_ticket['ach'] / $value['target_percent'] * 100);
                if ($ach_value > 100) {
                    $ach_value = 100;
                }
                $ach_weight = ROUND($get_ticket['ach'] / $value['target_percent'] * $value['weight']);
                $score = ROUND(4 * $ach_value / 100, 2);
                $final_ach = ROUND($ach_value * $value['weight'] / 100);
                $final_score = ROUND($score * $value['weight'] / 100, 2);
                $ticket_completion = [
                    'target_value' => $get_ticket['jml_ticket'] ?? 0,
                    'actual_value' => $get_ticket['done_ticket'] ?? 0,
                    'ach' => $get_ticket['ach'] ?? 0,
                    'ach_value' => $ach_value,
                    'ach_weight' => $ach_weight,
                    'score' => $score,
                    'final_ach' => $final_ach,
                    'final_score' => $final_score
                ];
                return $ticket_completion;
            case 'ontime_delivery':
                $ach_value = ROUND($get_ticket['ach_leadtime'] / $value['target_percent'] * 100);
                if ($ach_value > 100) {
                    $ach_value = 100;
                }
                $ach_weight = ROUND($get_ticket['ach_leadtime'] / $value['target_percent'] * $value['weight']);
                $score = ROUND(4 * $ach_value / 100, 2);
                $final_ach = ROUND($ach_value * $value['weight'] / 100);
                $final_score = ROUND($score * $value['weight'] / 100, 2);
                $ontime_delivery = [
                    'target_value' => $get_ticket['jml_ticket'] ?? 0,
                    'actual_value' => $get_ticket['ontime'] ?? 0,
                    'ach' => $get_ticket['ach_leadtime'] ?? 0,
                    'ach_value' => $ach_value,
                    'ach_weight' => $ach_weight,
                    'score' => $score,
                    'final_ach' => $final_ach,
                    'final_score' => $final_score
                ];
                return $ontime_delivery;
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

    private function getTicketCompletion($user_id, $periode, $week, $value)
    {
        if ($week == "all") {
            $condition_week = "";
        } else {
            $condition_week = "AND CONCAT(
                    'W',
                    LEAST(
                        4,
                        FLOOR((DAY(t.due_date) - 1) / (DAY(LAST_DAY(t.due_date)) / 4)) + 1
                    )
                ) = '$week'";
        }

        $role = $value['role'] ?? "";
        if ($role == "manager") {
            $condition_user = "";
        } else {
            $condition_user = "AND FIND_IN_SET($user_id, t.pic)";
        }
        return $this->CI->db->query("SELECT 
                COUNT(DISTINCT t.id_task) AS jml_ticket,
                SUM(IF(t.`status` IN (3,4), 1,0)) AS done_ticket,
                ROUND(SUM(IF(t.`status` IN (3,4), 1,0)) / COUNT(DISTINCT t.id_task) * 100) AS ach,
                SUM(IF(t.`status` = 3 AND DATE(t.done_date) <= DATE(t.due_date), 1, 0)) AS ontime,
                ROUND(SUM(IF(t.`status` = 3 AND DATE(t.done_date) <= DATE(t.due_date), 1, 0)) / COUNT(DISTINCT t.id_task) * 100) AS ach_leadtime
                FROM ticket_task t
                WHERE
                SUBSTR(t.`due_date`, 1, 7) = '$periode'
                AND t.type IN (1,2,10)
                $condition_user
                $condition_week
                ORDER BY t.due_date")->row_array();
    }
}
