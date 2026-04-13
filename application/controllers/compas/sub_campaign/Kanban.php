<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kanban extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('compas/model_campaign', 'model_campaign');
    }

    public function get_draft_campaigns()
    {
        $start_date = $this->input->post('start_date') == "" ? date('Y-m-01') : $this->input->post('start_date');
        $end_date = $this->input->post('end_date') == "" ? date('Y-m-t') : $this->input->post('end_date');
        $status_id = $this->input->post('status_id') == "" ? 1 : $this->input->post('status_id');

        $campaigns = $this->model_campaign->get_campaign($start_date, $end_date, $status_id);

        $this->_output_campaigns($campaigns);
    }

    public function get_activations_campaigns()
    {
        $this->_get_campaigns_by_status(2);
    }

    public function get_pre_production_campaigns()
    {
        $this->_get_campaigns_by_status(3);
    }

    public function get_archived_campaigns()
    {
        $this->_get_campaigns_by_status('archive');
    }

    public function get_all_campaigns()
    {
        $start_date = $this->input->post('start_date') ?: date('Y-m-01');
        $end_date = $this->input->post('end_date') ?: date('Y-m-t');
        $search = $this->input->post('search') ?: '';
        $page = (int) ($this->input->post('page') ?: 1);
        $per_page = 10;

        $campaigns = $this->model_campaign->get_all_campaigns_list($start_date, $end_date, $search);

        if (!$campaigns)
            $campaigns = [];

        $all_data = [];
        foreach ($campaigns as $value) {
            $avatars = $value->profile_picture_team ? explode(',', $value->profile_picture_team) : [];
            $more_users = max(0, (int) $value->jml_team - 3);
            $avatars = array_slice($avatars, 0, 3);
            $avatars = array_map(function ($av) {
                return 'https://trusmiverse.com/hr/uploads/profile/' . $av;
            }, $avatars);

            $desc = strip_tags(str_replace(['<p>', '</p>'], '', $value->campaign_desc ?? ''));
            if (strlen($desc) > 100)
                $desc = substr($desc, 0, 100) . '...';

            $all_data[] = [
                'id' => $value->campaign_id,
                'title' => $value->campaign_name,
                'brand_name' => $value->brand_name ?? '',
                'campaign_status' => $value->campaign_status,
                'author' => $value->author,
                'description' => $desc,
                'campaign_period' => $value->campaign_period,
                'content_pilar' => $value->content_pilar,
                'time' => $value->time_display,
                'priority' => $value->status_leadtime,
                'image' => '',
                'avatars' => $avatars,
                'more_users' => $more_users,
                'activation_target' => $value->activation_target,
                'activation_actual' => $value->activation_actual,
                'content_target' => $value->content_target,
                'content_actual' => $value->content_actual,
                'distribution_target' => $value->distribution_target,
                'distribution_actual' => $value->distribution_actual,
                'optimization_target' => $value->optimization_target,
                'optimization_actual' => $value->optimization_actual,
            ];
        }

        $total = count($all_data);
        $total_pages = max(1, ceil($total / $per_page));
        $offset = ($page - 1) * $per_page;
        $paged = array_values(array_slice($all_data, $offset, $per_page));

        header('Content-Type: application/json');
        echo json_encode([
            'items' => $paged,
            'total' => $total,
            'per_page' => $per_page,
            'total_pages' => $total_pages,
            'current_page' => $page,
        ]);
    }

    private function _get_campaigns_by_status($default_status_id)
    {
        $start_date = $this->input->post('start_date') ?? date('Y-m-01');
        $end_date = $this->input->post('end_date') ?? date('Y-m-t');
        $status_id = $default_status_id;

        $campaigns = $this->model_campaign->get_campaign($start_date, $end_date, $status_id);

        $this->_output_campaigns($campaigns);
    }

    private function _output_campaigns($campaigns)
    {
        if ($campaigns == null) {
            $dummy_data = [];
        } else {
            $dummy_data = [];
            foreach ($campaigns as $key => $value) {
                // string by , to array tapi ambil hanya 3 jika data lebih dari 3
                $avatars = $value->profile_picture_team ? explode(',', $value->profile_picture_team) : [];
                $count_avatars = count($avatars);
                if ($count_avatars > 3) {
                    $more_users = max(0, $value->jml_team - 3);
                    $avatars = array_slice($avatars, 0, 3);
                } else {
                    $more_users = max(0, $value->jml_team - 3);
                }

                // add https://trusmiverse.com/hr/uploads/profile/ to each avatar
                $avatars = array_map(function ($avatar) {
                    return 'https://trusmiverse.com/hr/uploads/profile/' . $avatar;
                }, $avatars);

                // potong description jika lebih dari 150 karakter
                // remove <p> to ''
                $campaign_desc = str_replace('<p>', '', $value->campaign_desc);
                $campaign_desc = str_replace('</p>', '', $campaign_desc);
                $campaign_desc = strlen(strip_tags($campaign_desc)) > 100 ? substr(strip_tags($campaign_desc), 0, 100) . '...' : strip_tags($campaign_desc);

                $dummy_data[] = [
                    'id' => $value->campaign_id,
                    'title' => $value->campaign_name,
                    'author' => $value->author,
                    'description' => $campaign_desc,
                    'campaign_period' => $value->campaign_period,
                    'content_pilar' => $value->content_pilar,
                    'time' => $value->time_display,
                    'priority' => $value->status_leadtime,
                    'image' => '',
                    'avatars' => $avatars,
                    'more_users' => $more_users,
                    'status_leadtime' => $value->status_leadtime,
                    'activation_target' => $value->activation_target,
                    'activation_actual' => $value->activation_actual,
                    'content_target' => $value->content_target,
                    'content_actual' => $value->content_actual,
                    'distribution_target' => $value->distribution_target,
                    'distribution_actual' => $value->distribution_actual,
                    'optimization_target' => $value->optimization_target,
                    'optimization_actual' => $value->optimization_actual
                ];
            }
        }

        $title_filter = $this->input->post('title');
        $priority_filter = $this->input->post('priority');
        $page = $this->input->post('page') ? $this->input->post('page') : 1;
        $limit = 5;

        // Filter
        $filtered_data = array_filter($dummy_data, function ($item) use ($title_filter, $priority_filter) {
            $match_title = empty($title_filter) || stripos($item['title'], $title_filter) !== false;
            $match_priority = empty($priority_filter) || $item['priority'] == $priority_filter;
            return $match_title && $match_priority;
        });

        // Pagination
        $total_items = count($filtered_data);
        $total_pages = ceil($total_items / $limit);
        $offset = ($page - 1) * $limit;
        $paginated_data = array_slice($filtered_data, $offset, $limit);

        echo json_encode([
            'items' => array_values($paginated_data),
            'total_pages' => $total_pages,
            'current_page' => (int) $page
        ]);
    }
}
