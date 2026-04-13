<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('compas/Model_dashboard', 'Model_dashboard');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['content'] = 'compas/dashboard';
        $this->load->view('compas/layout', $data);
    }

    public function get_performance_overview()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        if (empty($start_date) || empty($end_date)) {
            $start_date = date('Y-m-01');
            $end_date = date('Y-m-t');
        }

        $overview_data = $this->Model_dashboard->get_performance_overview($start_date, $end_date);

        echo json_encode(['status' => 'success', 'data' => $overview_data]);
    }

    public function get_pipeline_overview()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        if (empty($start_date) || empty($end_date)) {
            $start_date = date('Y-m-01');
            $end_date = date('Y-m-t');
        }

        $pipeline_data = $this->Model_dashboard->get_campaign_stage_pipeline($start_date, $end_date);

        echo json_encode(['status' => 'success', 'data' => $pipeline_data]);
    }

    public function get_campaign_stage_list()
    {
        $postData = $this->input->post();
        if (empty($postData['start_date']) || empty($postData['end_date'])) {
            $postData['start_date'] = date('Y-m-01');
            $postData['end_date'] = date('Y-m-t');
        }

        $list = $this->Model_dashboard->get_campaign_stage_list_dt($postData);
        $data = array();

        foreach ($list as $val) {
            $row = array();

            $total_target = $val->act_target + $val->cnt_target + $val->tln_target + $val->dst_target + $val->opt_target;
            $total_actual = $val->act_actual + $val->cnt_actual + $val->tln_actual + $val->dst_actual + $val->opt_actual;
            $cpr = $total_target > 0 ? round(($total_actual / $total_target) * 100, 1) : 0;

            $act_sla_m = $val->act_sla ?: 0;
            $cnt_sla_m = $val->cnt_sla ?: 0;
            $dst_sla_m = $val->dst_sla ?: 0;
            $opt_sla_m = $val->opt_sla ?: 0;
            $avg_sla = ROUND(($act_sla_m + $cnt_sla_m + $dst_sla_m + $opt_sla_m) / 4);
            $days = floor($avg_sla / (24 * 60));
            $remaining_mins = $avg_sla % (24 * 60);
            $hours = floor($remaining_mins / 60);
            $mins = floor($remaining_mins % 60);
            $sla_str = "";
            if ($days > 0) {
                $sla_str .= "{$days}h ";
            }
            $sla_str .= "{$hours}j {$mins}m";

            $act_ai = (float) ($val->act_ai ?: 0);
            $cnt_ai = (float) ($val->cnt_ai ?: 0);
            $tln_ai = (float) ($val->tln_ai ?: 0);
            $dst_ai = (float) ($val->dst_ai ?: 0);
            $opt_ai = (float) ($val->opt_ai ?: 0);
            $avg_ai = round(($act_ai + $cnt_ai + $tln_ai + $dst_ai + $opt_ai) / 5, 1);

            $row[] = "<div class='camp-name'>{$val->campaign_name}</div>";
            $row[] = "<div class='text-center'>{$val->act_actual} / {$val->act_target}</div>";
            $row[] = "<div class='text-center'>{$val->cnt_actual} / {$val->cnt_target}</div>";
            $row[] = "<div class='text-center'>{$val->tln_actual} / {$val->tln_target}</div>";
            $row[] = "<div class='text-center'>{$val->dst_actual} / {$val->dst_target}</div>";
            $row[] = "<div class='text-center'>{$val->opt_actual} / {$val->opt_target}</div>";
            $row[] = "<div class='text-center'>{$sla_str}</div>";
            $row[] = "<div class='text-center'>{$avg_ai}%</div>";
            $row[] = "<div class='text-center'>
                        <div class='d-flex align-items-center justify-content-center'>
                            <div class='mini-bar'>
                                <div class='mini-track'>
                                    <div class='mini-fill mf-g' style='width:{$cpr}%;'></div>
                                </div><span class='tg'>{$cpr}%</span>
                            </div>
                        </div>
                      </div>";

            $data[] = $row;
        }

        $output = array(
            "draw" => isset($postData['draw']) ? intval($postData['draw']) : 0,
            "recordsTotal" => $this->Model_dashboard->count_all_stage_list($postData),
            "recordsFiltered" => $this->Model_dashboard->count_filtered_stage_list($postData),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function get_pic_activation_list()
    {
        $postData = $this->input->post();
        if (empty($postData['start_date']) || empty($postData['end_date'])) {
            $postData['start_date'] = date('Y-m-01');
            $postData['end_date'] = date('Y-m-t');
        }

        $list = $this->Model_dashboard->get_pic_activation_list_dt($postData);
        $data = array();

        foreach ($list as $val) {
            $row = array();

            $cpr = $val->act_target > 0 ? round(($val->act_actual / $val->act_target) * 100, 1) : 0;

            $avg_sla = ROUND($val->avg_sla ?: 0);
            $days = floor($avg_sla / (24 * 60));
            $remaining_mins = $avg_sla % (24 * 60);
            $hours = floor($remaining_mins / 60);
            $mins = floor($remaining_mins % 60);
            $sla_str = "";
            if ($days > 0) {
                $sla_str .= "{$days}h ";
            }
            $sla_str .= "{$hours}j {$mins}m";

            $avg_ai = (float) ($val->avg_ai ?: 0);
            $ai_round = round($avg_ai);

            if ($ai_round >= 90) {
                $sp_class = 'sp-g'; // green
            } elseif ($ai_round >= 80) {
                $sp_class = 'sp-y'; // yellow
            } else {
                $sp_class = 'sp-r'; // red
            }

            if ($cpr >= 100) {
                $mf_class = 'mf-g';
            } elseif ($cpr >= 50) {
                $mf_class = 'mf-y';
            } else {
                $mf_class = 'mf-r';
            }

            $pic_name = $val->pic_name ?: 'Unknown';

            $color_completion_rate = "";
            if ($cpr >= 100) {
                $color_completion_rate = "text-success";
            } elseif ($cpr >= 50) {
                $color_completion_rate = "text-warning";
            } else {
                $color_completion_rate = "text-danger";
            }

            $row[] = "<div class='pic-name'>{$pic_name}</div>";
            $row[] = "<div class='text-center {$color_completion_rate}'>{$val->act_actual}/{$val->act_target}</div>";
            $row[] = "<div class='text-center'>{$sla_str}</div>";
            $row[] = "<div class='text-center'><span class='score-pill {$sp_class}'>{$ai_round}</span></div>";
            $row[] = "<div class='text-center'>
                        <div class='d-flex align-items-center justify-content-center'>
                            <div class='mini-bar'>
                                <div class='mini-track'>
                                    <div class='mini-fill {$mf_class}' style='width:{$cpr}%;'></div>
                                </div><span class='tg {$color_completion_rate}'>{$cpr}%</span>
                            </div>
                        </div>
                      </div>";

            $data[] = $row;
        }

        $output = array(
            "draw" => isset($postData['draw']) ? intval($postData['draw']) : 0,
            "recordsTotal" => $this->Model_dashboard->count_all_pic_activation_list($postData),
            "recordsFiltered" => $this->Model_dashboard->count_filtered_pic_activation_list($postData),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function get_pic_content_list()
    {
        $postData = $this->input->post();
        if (empty($postData['start_date']) || empty($postData['end_date'])) {
            $postData['start_date'] = date('Y-m-01');
            $postData['end_date'] = date('Y-m-t');
        }

        $list = $this->Model_dashboard->get_pic_content_list_dt($postData);
        $data = array();

        foreach ($list as $val) {
            $row = array();

            $cpr = $val->act_target > 0 ? round(($val->act_actual / $val->act_target) * 100, 1) : 0;

            $avg_sla = ROUND($val->avg_sla ?: 0);
            $days = floor($avg_sla / (24 * 60));
            $remaining_mins = $avg_sla % (24 * 60);
            $hours = floor($remaining_mins / 60);
            $mins = floor($remaining_mins % 60);
            $sla_str = "";
            if ($days > 0) {
                $sla_str .= "{$days}h ";
            }
            $sla_str .= "{$hours}j {$mins}m";

            $avg_ai = (float) ($val->avg_ai ?: 0);
            $ai_round = round($avg_ai);

            if ($ai_round >= 90) {
                $sp_class = 'sp-g'; // green
            } elseif ($ai_round >= 80) {
                $sp_class = 'sp-y'; // yellow
            } else {
                $sp_class = 'sp-r'; // red
            }

            if ($cpr >= 100) {
                $mf_class = 'mf-g';
            } elseif ($cpr >= 50) {
                $mf_class = 'mf-y';
            } else {
                $mf_class = 'mf-r';
            }

            $pic_name = $val->pic_name ?: 'Unknown';

            $color_completion_rate = "";
            if ($cpr >= 100) {
                $color_completion_rate = "text-success";
            } elseif ($cpr >= 50) {
                $color_completion_rate = "text-warning";
            } else {
                $color_completion_rate = "text-danger";
            }

            $row[] = "<div class='pic-name'>{$pic_name}</div>";
            $row[] = "<div class='text-center {$color_completion_rate}'>{$val->act_actual}/{$val->act_target}</div>";
            $row[] = "<div class='text-center'>{$sla_str}</div>";
            $row[] = "<div class='text-center'><span class='score-pill {$sp_class}'>{$ai_round}</span></div>";
            $row[] = "<div class='text-center'>
                        <div class='d-flex align-items-center justify-content-center'>
                            <div class='mini-bar'>
                                <div class='mini-track'>
                                    <div class='mini-fill {$mf_class}' style='width:{$cpr}%;'></div>
                                </div><span class='tg {$color_completion_rate}'>{$cpr}%</span>
                            </div>
                        </div>
                      </div>";

            $data[] = $row;
        }

        $output = array(
            "draw" => isset($postData['draw']) ? intval($postData['draw']) : 0,
            "recordsTotal" => $this->Model_dashboard->count_all_pic_content_list($postData),
            "recordsFiltered" => $this->Model_dashboard->count_filtered_pic_content_list($postData),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function get_pic_talent_list()
    {
        $postData = $this->input->post();
        if (empty($postData['start_date']) || empty($postData['end_date'])) {
            $postData['start_date'] = date('Y-m-01');
            $postData['end_date'] = date('Y-m-t');
        }

        $list = $this->Model_dashboard->get_pic_talent_list_dt($postData);
        $data = array();

        foreach ($list as $val) {
            $row = array();

            $cpr = $val->act_target > 0 ? round(($val->act_actual / $val->act_target) * 100, 1) : 0;

            $avg_sla = ROUND($val->avg_sla ?: 0);
            $days = floor($avg_sla / (24 * 60));
            $remaining_mins = $avg_sla % (24 * 60);
            $hours = floor($remaining_mins / 60);
            $mins = floor($remaining_mins % 60);
            $sla_str = "-";

            $avg_ai = (float) ($val->avg_ai ?: 0);
            $ai_round = round($avg_ai);

            if ($ai_round >= 90) {
                $sp_class = 'sp-g'; // green
            } elseif ($ai_round >= 80) {
                $sp_class = 'sp-y'; // yellow
            } else {
                $sp_class = 'sp-r'; // red
            }

            if ($cpr >= 100) {
                $mf_class = 'mf-g';
            } elseif ($cpr >= 50) {
                $mf_class = 'mf-y';
            } else {
                $mf_class = 'mf-r';
            }

            $pic_name = $val->pic_name ?: 'Unknown';

            $color_completion_rate = "";
            if ($cpr >= 100) {
                $color_completion_rate = "text-success";
            } elseif ($cpr >= 50) {
                $color_completion_rate = "text-warning";
            } else {
                $color_completion_rate = "text-danger";
            }

            $row[] = "<div class='pic-name'>{$pic_name}</div>";
            $row[] = "<div class='text-center {$color_completion_rate}'>{$val->act_actual}/{$val->act_target}</div>";
            $row[] = "<div class='text-center'>{$sla_str}</div>";
            $row[] = "<div class='text-center'><span class='score-pill {$sp_class}'>{$ai_round}</span></div>";
            $row[] = "<div class='text-center'>
                        <div class='d-flex align-items-center justify-content-center'>
                            <div class='mini-bar'>
                                <div class='mini-track'>
                                    <div class='mini-fill {$mf_class}' style='width:{$cpr}%;'></div>
                                </div><span class='tg {$color_completion_rate}'>{$cpr}%</span>
                            </div>
                        </div>
                      </div>";

            $data[] = $row;
        }

        $output = array(
            "draw" => isset($postData['draw']) ? intval($postData['draw']) : 0,
            "recordsTotal" => $this->Model_dashboard->count_all_pic_talent_list($postData),
            "recordsFiltered" => $this->Model_dashboard->count_filtered_pic_talent_list($postData),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function get_pic_distribution_list()
    {
        $postData = $this->input->post();
        if (empty($postData['start_date']) || empty($postData['end_date'])) {
            $postData['start_date'] = date('Y-m-01');
            $postData['end_date'] = date('Y-m-t');
        }

        $list = $this->Model_dashboard->get_pic_distribution_list_dt($postData);
        $data = array();

        foreach ($list as $val) {
            $row = array();

            $cpr = $val->act_target > 0 ? round(($val->act_actual / $val->act_target) * 100, 1) : 0;

            $avg_sla = ROUND($val->avg_sla ?: 0);
            $days = floor($avg_sla / (24 * 60));
            $remaining_mins = $avg_sla % (24 * 60);
            $hours = floor($remaining_mins / 60);
            $mins = floor($remaining_mins % 60);
            $sla_str = "";
            if ($days > 0) {
                $sla_str .= "{$days}h ";
            }
            $sla_str .= "{$hours}j {$mins}m";

            $avg_ai = (float) ($val->avg_ai ?: 0);
            $ai_round = round($avg_ai);

            if ($ai_round >= 90) {
                $sp_class = 'sp-g'; // green
            } elseif ($ai_round >= 80) {
                $sp_class = 'sp-y'; // yellow
            } else {
                $sp_class = 'sp-r'; // red
            }

            if ($cpr >= 100) {
                $mf_class = 'mf-g';
            } elseif ($cpr >= 50) {
                $mf_class = 'mf-y';
            } else {
                $mf_class = 'mf-r';
            }

            $pic_name = $val->pic_name ?: 'Unknown';

            $color_completion_rate = "";
            if ($cpr >= 100) {
                $color_completion_rate = "text-success";
            } elseif ($cpr >= 50) {
                $color_completion_rate = "text-warning";
            } else {
                $color_completion_rate = "text-danger";
            }

            $row[] = "<div class='pic-name'>{$pic_name}</div>";
            $row[] = "<div class='text-center {$color_completion_rate}'>{$val->act_actual}/{$val->act_target}</div>";
            $row[] = "<div class='text-center'>{$sla_str}</div>";
            $row[] = "<div class='text-center'><span class='score-pill {$sp_class}'>{$ai_round}</span></div>";
            $row[] = "<div class='text-center'>
                        <div class='d-flex align-items-center justify-content-center'>
                            <div class='mini-bar'>
                                <div class='mini-track'>
                                    <div class='mini-fill {$mf_class}' style='width:{$cpr}%;'></div>
                                </div><span class='tg {$color_completion_rate}'>{$cpr}%</span>
                            </div>
                        </div>
                      </div>";

            $data[] = $row;
        }

        $output = array(
            "draw" => isset($postData['draw']) ? intval($postData['draw']) : 0,
            "recordsTotal" => $this->Model_dashboard->count_all_pic_distribution_list($postData),
            "recordsFiltered" => $this->Model_dashboard->count_filtered_pic_distribution_list($postData),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function get_pic_optimization_list()
    {
        $postData = $this->input->post();
        if (empty($postData['start_date']) || empty($postData['end_date'])) {
            $postData['start_date'] = date('Y-m-01');
            $postData['end_date'] = date('Y-m-t');
        }

        $list = $this->Model_dashboard->get_pic_optimization_list_dt($postData);
        $data = array();

        foreach ($list as $val) {
            $row = array();

            $cpr = $val->act_target > 0 ? round(($val->act_actual / $val->act_target) * 100, 1) : 0;

            $avg_sla = ROUND($val->avg_sla ?: 0);
            $days = floor($avg_sla / (24 * 60));
            $remaining_mins = $avg_sla % (24 * 60);
            $hours = floor($remaining_mins / 60);
            $mins = floor($remaining_mins % 60);
            $sla_str = "";
            if ($days > 0) {
                $sla_str .= "{$days}h ";
            }
            $sla_str .= "{$hours}j {$mins}m";

            $avg_ai = (float) ($val->avg_ai ?: 0);
            $ai_round = round($avg_ai);

            if ($ai_round >= 90) {
                $sp_class = 'sp-g'; // green
            } elseif ($ai_round >= 80) {
                $sp_class = 'sp-y'; // yellow
            } else {
                $sp_class = 'sp-r'; // red
            }

            if ($cpr >= 100) {
                $mf_class = 'mf-g';
            } elseif ($cpr >= 50) {
                $mf_class = 'mf-y';
            } else {
                $mf_class = 'mf-r';
            }

            $pic_name = $val->pic_name ?: 'Unknown';

            $color_completion_rate = "";
            if ($cpr >= 100) {
                $color_completion_rate = "text-success";
            } elseif ($cpr >= 50) {
                $color_completion_rate = "text-warning";
            } else {
                $color_completion_rate = "text-danger";
            }

            $row[] = "<div class='pic-name'>{$pic_name}</div>";
            $row[] = "<div class='text-center {$color_completion_rate}'>{$val->act_actual}/{$val->act_target}</div>";
            $row[] = "<div class='text-center'>{$sla_str}</div>";
            $row[] = "<div class='text-center'><span class='score-pill {$sp_class}'>{$ai_round}</span></div>";
            $row[] = "<div class='text-center'>
                        <div class='d-flex align-items-center justify-content-center'>
                            <div class='mini-bar'>
                                <div class='mini-track'>
                                    <div class='mini-fill {$mf_class}' style='width:{$cpr}%;'></div>
                                </div><span class='tg {$color_completion_rate}'>{$cpr}%</span>
                            </div>
                        </div>
                      </div>";

            $data[] = $row;
        }

        $output = array(
            "draw" => isset($postData['draw']) ? intval($postData['draw']) : 0,
            "recordsTotal" => $this->Model_dashboard->count_all_pic_optimization_list($postData),
            "recordsFiltered" => $this->Model_dashboard->count_filtered_pic_optimization_list($postData),
            "data" => $data,
        );

        echo json_encode($output);
    }
}