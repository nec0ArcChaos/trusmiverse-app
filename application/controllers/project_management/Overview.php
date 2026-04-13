<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Overview extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->database();
    }

    /**
     * Get data for overview cards
     */
    public function get_overview_data()
    {
        $data = [
            'status' => 'success',
            'data' => [
                'weekly_progress' => [
                    'avg_percentage' => 96.5,
                    'weeks' => [
                        ['week' => 1, 'total' => 5, 'finished' => 5, 'percentage' => 100],
                        ['week' => 2, 'total' => 5, 'finished' => 5, 'percentage' => 100],
                        ['week' => 3, 'total' => 5, 'finished' => 5, 'percentage' => 100],
                        ['week' => 4, 'total' => 4, 'finished' => 2, 'percentage' => 88.5],
                    ]
                ],
                'task_summary' => [
                    'overall_percentage' => 85,
                    'ontime' => 100,
                    'ontime_percentage' => 85,
                    'late' => 26,
                    'late_percentage' => 15,
                ],
                'task_by_status' => [
                    ['value' => 1048, 'name' => 'Belum Dikerjakan'],
                    ['value' => 735, 'name' => 'Sedang Dikerjakan'],
                    ['value' => 580, 'name' => 'Selesai'],
                    ['value' => 484, 'name' => 'Tertunda'],
                    ['value' => 300, 'name' => 'Ditolak'],
                ]
            ]
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
