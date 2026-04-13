<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Capaian extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('project_management/model_capaian', 'model_capaian');
        $this->load->model('project_management/model_kpi', 'model_kpi');
        $this->load->model("hr/model_rekap_absen", "model_rekap_absen");
        $this->load->model("model_dashboard");
        $this->load->database();
    }

    /**
     * Get user capaian summary
     */
    public function get_user_capaian()
    {
        $user_id = $this->input->post('user_id');
        $periode = $this->input->post('periode') ? $this->input->post('periode') : date('Y-m');

        $employee = $this->model_kpi->get_employee_profile($user_id);
        $resume_absen = $this->resume_absen($periode, 1, $user_id);
        $total_tasklist = $this->model_capaian->get_total_tasklist($periode, $user_id);
        $overall_kpi = $this->get_overall_kpi($periode, $user_id);
        // Untuk membuktikan bahwa parameter berhasil dikirim via AJAX
        $name = $employee['employee_name'];
        $position = $employee['designation_name'];

        $telat = $resume_absen['data']->telat . " (" . $resume_absen['data']->menit_telat . " mnt)";
        $total_hadir = $resume_absen['data']->total_hadir;
        $bolos = $resume_absen['data']->bolos;
        $total_izin_pc_dt = $resume_absen['data']->total_izin_pc_dt;
        // Dummy data untuk capaian user
        $data = [
            'status' => 'success',
            'data' => [
                'name' => $name,
                'position' => $position,
                'overall_kpi_desc' => $overall_kpi . '% Overall KPI (Periode ' . $periode . ')',
                'overall_kpi' => $overall_kpi . "%",
                'total_tasklist' => $total_tasklist,
                'total_kehadiran' => $total_hadir,
                'total_alfa' => $bolos,
                'total_telat' => $telat,
                'total_ijin' => $total_izin_pc_dt,
                'avatar_url' => 'https://trusmiverse.com/hr/uploads/profile/' . $employee['profile_picture'] ?? "",
                'companies' => [
                    [
                        'name' => 'Company RSP',
                        'icon' => '<i class="bi bi-circle-fill text-primary small"></i>',
                        'icon_bg' => ''
                    ],
                    [
                        'name' => 'BT Trusmi',
                        'icon' => '<i class="bi bi-star-fill text-warning fs-10" style="font-size: 8px;"></i>',
                        'icon_bg' => 'bg-dark rounded-circle d-flex align-items-center justify-content-center'
                    ]
                ]
            ]
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function resume_absen($periode, $cutoff, $employee_id)
    {
        $month = date("m", strtotime($periode));
        $today = date("Y-m-01", strtotime($periode));
        if ($cutoff == 1) { // 21-20
            if ($month == date("m") && date("d") <= 20) {
                $end_harus_hadir = date("Y-m-d", strtotime(date("Y-m-d") . " -1 days"));
            } else {
                $end_harus_hadir = date("Y-m-19");
            }
            $start = date("Y-m-21", strtotime($today . " -1 months"));
            $end = date("Y-m-20", strtotime($periode));
        } else if ($cutoff == 2) { // 16-15
            if ($month == date("m") && date("d") <= 20) {
                $end_harus_hadir = date("Y-m-16", strtotime($periode . "-01"));
            } else {
                $end_harus_hadir = date("Y-m-14");
            }
            $start = date("Y-m-16", strtotime($today . " -1 months"));
            $end = date("Y-m-15", strtotime($periode));
        } else { // 01-eom
            if ($month == date("m") && date("d") <= date("t")) {
                $end_harus_hadir = date("Y-m-d", strtotime(date("Y-m-d") . " -1 days"));
            } else {
                $end_harus_hadir = date("Y-m-t", strtotime($periode . "-01"));
            }
            $start = date("Y-m-01", strtotime($periode));
            $end = date("Y-m-t", strtotime($periode));
        }
        $sub_emp = 0;
        $periode_cutoff = $this->periode_cutoff($periode, $cutoff, $start, $end, $employee_id);
        $response['data'] = $periode_cutoff['absensi'];
        $response['total_hadir'] = $periode_cutoff['absensi'];
        $response['total_warning'] = $this->total_warning($periode, $employee_id);
        $response['month'] =  $month;
        $response['periode'] = $periode;
        $response['today'] = $today;
        $response['start'] = $start;
        $response['end_today'] = $end_harus_hadir;
        // $response['start'] = $start;
        $response['end'] = $end;
        return $response;
    }

    public function periode_cutoff($periode, $cutoff, $start, $end, $employee_id)
    {
        $emp = $this->db->query("SELECT company_id, department_id, designation_id FROM xin_employees WHERE user_id = '$employee_id'")->row();
        $company_id = $emp->company_id;
        $department_id = $emp->department_id;
        $designation_id = $emp->designation_id;
        $sub_emp = 0;
        $time = strtotime($periode);
        $today = date("Y-m-t",  $time);
        if ($today < $end && $today >= $start) {
            $end = $today;
        }

        $data_absen = $this->model_rekap_absen->get_absensi($start, $end, $company_id, $department_id, $employee_id,  $sub_emp, NULL, $cutoff)->row(0);
        $data_detail_absen = $this->model_dashboard->new_detail_absen($start, $end, $employee_id);
        $response['start'] = $start;
        $response['end'] = $end;
        $response['absensi'] = $data_absen;
        $response['detail'] = $data_detail_absen;
        return $response;
    }

    public function total_warning($periode, $employee_id)
    {
        $month = date("m", strtotime($periode));

        $today = date("Y-m-d", strtotime($periode));
        $start = date("Y-m-21", strtotime($today . " -1 months"));
        $end = date("Y-m-20", strtotime($periode));

        $query = "SELECT COUNT(x.reason) AS total_warning FROM (SELECT
                        h.created_at,
                        SUBSTR(h.created_at,1,10) AS tgl_warning,
                        SUBSTR(h.created_at,12,5) AS jam_warning,
                        h.employee_id,
                        CONCAT(e.first_name,' ',e.last_name) AS employee_name,
                        h.reason,
                        COUNT(h.employee_id) AS attempt
                    FROM
                        trusmi_history_lock h
                        LEFT JOIN xin_employees e ON e.user_id = h.employee_id
                    WHERE
                        SUBSTR( h.created_at, 1, 10 ) BETWEEN '$start' 
                        AND '$end' AND h.employee_id = '$employee_id'
                    GROUP BY h.employee_id, SUBSTR( h.created_at, 1, 10 ), h.reason
                    ) AS x GROUP BY x.reason";
        $data = $this->db->query($query)->row();
        return $data->total_warning ?? 0;
    }

    /**
     * Get data for progress cards
     */
    public function get_progress_cards()
    {
        $user_id = $this->input->post('user_id');
        $periode = $this->input->post('periode');
        $capaian_progress = $this->model_capaian->get_capaian_progress($user_id, $periode);
        $ticket_progress = $this->model_capaian->get_ticket_progress($user_id, $periode);
        $data = [
            'status' => 'success',
            'data' => [
                'leadtime_percent' => $capaian_progress['ach_leadtime'] ?? 0,
                'achievement_percent' => $capaian_progress['ach'] ?? 0,
                'tasklist_done' => $capaian_progress['done_task'] ?? 0,
                'tasklist_total' => $capaian_progress['jml_task'] ?? 0,
                'ticket_done' => $ticket_progress['done_ticket'] ?? 0,
                'ticket_total' => $ticket_progress['total_ticket'] ?? 0
            ]
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    function get_employees()
    {
        $search = $this->input->post('search');
        $employee = $this->model_capaian->get_employees($search);

        $data = [];
        foreach ($employee as $emp) {
            $data[] = [
                'id' => $emp['user_id'],
                'text' => $emp['employee_name']
            ];
        }

        echo json_encode(['status' => true, 'results' => $data]);
    }

    function get_overall_kpi($periode, $employee_id)
    {
        $weekly_scores = $this->model_kpi->get_kpi_by_week($employee_id);
        $this->load->library('KpiService');
        $overall_kpi = 0;
        $count = 0;
        foreach ($weekly_scores as $key => $value) {
            $kpi_name = $value['kpi_name'];
            $weekly_scores[$key]['type'] = ucwords(str_replace("_", " ", $value['type']));
            $kpi_result = $this->kpiservice->calculate($employee_id, $periode, "all", $value);
            if ($kpi_result) {
                $weekly_scores[$key]['employee_id'] = $employee_id;
                $weekly_scores[$key]['periode'] = $periode;
                $weekly_scores[$key]['week'] = "all";
                $weekly_scores[$key]['target_value'] = $kpi_result['target_value'] ?? 0;
                $weekly_scores[$key]['actual_value'] = $kpi_result['actual_value'] ?? 0;
                $weekly_scores[$key]['ach_value'] = $kpi_result['ach_value'] ?? 0;
                $weekly_scores[$key]['ach_weight'] = $kpi_result['ach_weight'] ?? 0;
                $weekly_scores[$key]['score'] = $kpi_result['score'] ?? 0;
                $weekly_scores[$key]['final_ach'] = $kpi_result['final_ach'] ?? 0;
                $weekly_scores[$key]['final_score'] = $kpi_result['final_score'] ?? 0;
            } else {
                $weekly_scores[$key]['week'] = "all";
                $weekly_scores[$key]['target_value'] = 0;
                $weekly_scores[$key]['actual_value'] = 0;
                $weekly_scores[$key]['ach_value'] = 0;
                $weekly_scores[$key]['ach_weight'] = 0;
                $weekly_scores[$key]['score'] = 0;
                $weekly_scores[$key]['final_ach'] = 0;
                $weekly_scores[$key]['final_score'] = 0;
            }

            $count++;
            $overall_kpi += $weekly_scores[$key]['ach_weight'];
        }
        return $overall_kpi == 0 ? 0 : ROUND($overall_kpi / $count, 2);
    }
}
