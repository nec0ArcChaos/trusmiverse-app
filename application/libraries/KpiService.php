<?php
require_once APPPATH . 'libraries/kpi/SourceProjectManagement.php';
require_once APPPATH . 'libraries/kpi/SourceTicket.php';
require_once APPPATH . 'libraries/kpi/SourceReviewSystem.php';

class KpiService
{

    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function calculate($user_id, $periode, $week, $value)
    {
        if (empty($value)) {
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

        $handler = $this->resolveSource($value['source']);

        if (!$handler) {
            throw new Exception("Source KPI tidak ditemukan");
        }

        return $handler->calculate($user_id, $periode, $week, $value);
    }

    private function resolveSource($source)
    {
        switch ($source) {
            case 'project_management':
                return new SourceProjectManagement();
            case 'ticket':
                return new SourceTicket();
            case 'review_system':
                return new SourceReviewSystem();
            default:
                return null;
        }
    }
}
