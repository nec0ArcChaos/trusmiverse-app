<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_medsos extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('model_admin_sosial');
        $this->load->database();
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle'] = "Admin Medsos";
        $data['css'] = "admin_medsos/adsos_css";
        $data['js'] = "admin_medsos/adsos_js";
        $data['account'] = $this->model_admin_sosial->get_account();
        $data['team'] = $this->model_admin_sosial->get_team('2');
        $data['content'] = "admin_medsos/adsos_index";
        $this->load->view('layout/main', $data);
    }

    public function admin_sosial_media()
    {
        $type = $this->input->get('type') != '' ? $this->input->get('type') : 'admin_sosial_media';
        $company_id = $this->input->post('company_id') != '' ? $this->input->post('company_id') : '2';
        $account_id = $this->input->post('account_id') != '' ? $this->input->post('account_id') : '1';
        $start_date = $this->input->post('start_date') != '' ? $this->input->post('start_date') : date('Y-m-d');
        $end_date = $this->input->post('end_date') != '' ? $this->input->post('end_date') : date('Y-m-d');
        $categories = $this->model_admin_sosial->get_category($type, $company_id, $account_id, $start_date, $end_date);
        $admin_sosial_media = $this->model_admin_sosial->get_admin_sosial_media($company_id, $account_id, $start_date, $end_date);
        $periodeMonth = date('Y-m', strtotime($end_date));
        $owner_id = $this->input->get('owner_id') != '' ? $this->input->get('owner_id') : '4210696234';
        $resume  = $this->get_resume($periodeMonth, $owner_id);

        $data = [];

        if (!empty($categories)) {
            foreach ($categories as $cat) {
                $data[] = [
                    'id' => isset($cat->id) ? $cat->id : '',
                    'type' => isset($cat->type) ? $cat->type : '',
                    'category' => isset($cat->category) ? $cat->category : '',
                    'title' => isset($cat->title) ? $cat->title : '',
                    'short_desc' => isset($cat->short_desc) ? $cat->short_desc : '',
                    'target' => isset($cat->target) ? $cat->target : 6,
                    'actual' => isset($cat->actual) ? $cat->actual : 0,
                    'pct' => isset($cat->pct) ? $cat->pct : 0
                ];
            }
        } else {
            // Fallback for dummy display apabila data db masih kosong
            $data = [
                ['id' => 1, 'type' => 'admin_media_sosial', 'title' => 'Go To Peers Account', 'short_desc' => 'Reach out followers baru', 'actual' => 4, 'target' => 6, 'pct' => 66],
                ['id' => 2, 'type' => 'admin_media_sosial', 'title' => 'Reply / Engage Comments', 'short_desc' => 'Reach out reply by DM', 'actual' => 4, 'target' => 6, 'pct' => 66],
                ['id' => 3, 'type' => 'admin_media_sosial', 'title' => 'Reciprocrate', 'short_desc' => 'Komentar di Postingan populer', 'actual' => 4, 'target' => 6, 'pct' => 66],
                ['id' => 4, 'type' => 'admin_media_sosial', 'title' => 'Engage Big Account', 'short_desc' => 'Komentar di akun populer', 'actual' => 4, 'target' => 6, 'pct' => 66],
                ['id' => 5, 'type' => 'admin_media_sosial', 'title' => 'React To Story Followers', 'short_desc' => 'Reach out story followers', 'actual' => 4, 'target' => 6, 'pct' => 66]
            ];
        }

        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'data' => $data, 'table_data' => $admin_sosial_media, 'resume' => $resume]);
    }

    public function engage_instagram()
    {
        $type = $this->input->get('type') ?: 'engage_instagram';
        $company_id = $this->input->post('company_id') ?: '2';
        $account_id = $this->input->post('account_id') ?: '1';
        $start_date = $this->input->post('start_date') ?: date('Y-m-d');
        $end_date = $this->input->post('end_date') ?: date('Y-m-d');
        $categories = $this->model_admin_sosial->get_category($type, $company_id, $account_id, $start_date, $end_date);
        $periodeMonth = date('Y-m', strtotime($end_date));
        $owner_id = $this->input->get('owner_id') != '' ? $this->input->get('owner_id') : '4210696234';
        $resume  = $this->get_resume($periodeMonth, $owner_id);

        $data = [];

        if (!empty($categories)) {
            foreach ($categories as $cat) {
                $data[] = [
                    'id' => isset($cat->id) ? $cat->id : '',
                    'type' => isset($cat->type) ? $cat->type : '',
                    'title' => isset($cat->title) ? $cat->title : '',
                    'short_desc' => isset($cat->short_desc) ? $cat->short_desc : '',
                    'target' => isset($cat->target) ? $cat->target : 6,
                    'actual' => isset($cat->actual) ? $cat->actual : 0,
                    'pct' => isset($cat->pct) ? $cat->pct : 0
                ];
            }
        } else {
            // Fallback for dummy display apabila data db masih kosong
            $data = [
                ['id' => 1, 'type' => 'engage_instagram', 'title' => 'Go To Peers Account', 'short_desc' => 'Reach out followers baru', 'actual' => 4, 'target' => 6, 'pct' => 66],
                ['id' => 2, 'type' => 'engage_instagram', 'title' => 'Reply / Engage Comments', 'short_desc' => 'Reach out reply by DM', 'actual' => 4, 'target' => 6, 'pct' => 66],
                ['id' => 3, 'type' => 'engage_instagram', 'title' => 'Reciprocrate', 'short_desc' => 'Komentar di Postingan populer', 'actual' => 4, 'target' => 6, 'pct' => 66],
                ['id' => 4, 'type' => 'engage_instagram', 'title' => 'Engage Big Account', 'short_desc' => 'Komentar di akun populer', 'actual' => 4, 'target' => 6, 'pct' => 66],
                ['id' => 5, 'type' => 'engage_instagram', 'title' => 'React To Story Followers', 'short_desc' => 'Reach out story followers', 'actual' => 4, 'target' => 6, 'pct' => 66]
            ];
        }

        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'categories' => $categories,
            'top_metrics' => [
                ['title' => 'Profile Visit', 'actual' => isset($resume['totalProfileVisit']) ? $resume['totalProfileVisit'] : 0, 'target' => '500', 'percent' => isset($resume['totalProfileVisit']) ? ROUND($resume['totalProfileVisit'] / 500 * 100, 2) : 0],
                ['title' => 'Engagement Rate', 'actual' => isset($resume['totalEngagementRate']) ? $resume['totalEngagementRate'] . '%' : 0, 'target' => '5%', 'percent' => isset($resume['totalEngagementRate']) ? ROUND($resume['totalEngagementRate'] / 5 * 100, 2) : 0],
                ['title' => 'Growth Followers', 'actual' => isset($resume['totalFollowersDiff']) ? number_format($resume['totalFollowersDiff'], 0, ',', '.') : 0, 'target' => '150', 'percent' => isset($resume['totalFollowersDiff']) ? ROUND($resume['totalFollowersDiff'] / 150 * 100, 2) : 0]
            ],
            'activities' => $data,
            'resume' => [
                'totalProfileVisit' => isset($resume['totalProfileVisit']) ? $resume['totalProfileVisit'] : 0,
                'totalProfileVisitPrevious' => isset($resume['totalProfileVisitPrevious']) ? $resume['totalProfileVisitPrevious'] : 0,
                'totalProfileVisitDiff' => isset($resume['totalProfileVisitDiff']) ? $resume['totalProfileVisitDiff'] : 0,
                'totalEngagementRate' => isset($resume['totalEngagementRate']) ? $resume['totalEngagementRate'] : 0,
                'totalEngagementRatePrevious' => isset($resume['totalEngagementRatePrevious']) ? $resume['totalEngagementRatePrevious'] : 0,
                'totalEngagementRateDiff' => isset($resume['totalEngagementRateDiff']) ? $resume['totalEngagementRateDiff'] : 0,
                'totalFollowers' => isset($resume['totalFollowers']) ? $resume['totalFollowers'] : 0,
                'totalFollowersPrevious' => isset($resume['totalFollowersPrevious']) ? $resume['totalFollowersPrevious'] : 0,
                'totalFollowersDiff' => isset($resume['totalFollowersDiff']) ? $resume['totalFollowersDiff'] : 0,
            ]
        ]);
    }

    public function save_adsos_media()
    {
        $adsos_id = $this->input->post('adsos_id');
        $data = [
            'adsos_category_id' => $this->input->post('adsos_category_id'),
            'company_id' => $this->input->post('company_id'),
            'date' => $this->input->post('date'),
            'account_id' => $this->input->post('adsos_account_id'),
            'profile_link' => $this->input->post('profile_link'),
            'is_dm' => $this->input->post('is_dm'),
        ];

        $save = $this->model_admin_sosial->save_adsos($data, $adsos_id);

        header('Content-Type: application/json');
        if ($save) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data']);
        }
    }

    public function delete_adsos_media()
    {
        $adsos_id = $this->input->post('adsos_id');
        $delete = $this->model_admin_sosial->delete_adsos($adsos_id);

        header('Content-Type: application/json');
        if ($delete) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data']);
        }
    }

    public function get_resume($yearMonth, $owner_id)
    {
        $data['kerjasama'] = $this->model_admin_sosial->get_resume_kerjasama($yearMonth);
        $data['official'] = $this->model_admin_sosial->get_resume_official($yearMonth, $owner_id);
        $data['official']->owner = $this->model_admin_sosial->get_owner($owner_id);
        $previousMonth = date('Y-m', strtotime("$yearMonth -1 month"));
        $data['prev_kerjasama'] = $this->model_admin_sosial->get_resume_kerjasama($previousMonth);
        $prev_official = $this->model_admin_sosial->get_resume_official($previousMonth, $owner_id);
        $prev_owner = $this->model_admin_sosial->get_owner_by_date($owner_id, $previousMonth);
        if (empty($prev_owner)) {
            $prev_owner = (object) [
                "followersCount" => $prev_owner->followersCount ? $prev_owner->followersCount : 79488
            ];
        }

        $prev_official->owner = $prev_owner;
        $data['prev_official'] = $prev_official;

        $pointchecks = $this->model_admin_sosial->get_pointchecks_monthly($yearMonth);
        $prevPointchecks = $this->model_admin_sosial->get_pointchecks_monthly($previousMonth);
        $official = $this->model_admin_sosial->get_resume_official($yearMonth, $owner_id);
        $official->owner = $this->model_admin_sosial->get_owner($owner_id);

        $rateAct = (($official->total_like + $official->total_comment) / ($official->total_konten == 0 ? 1 : $official->total_konten)) / $official->owner->followersCount * 100;
        $rate = $this->safe_divide($rateAct, $pointchecks->engagement_target ?? 0, $rateAct) * 100;
        $previousRateAct = (($prev_official->total_like + $prev_official->total_comment) / ($prev_official->total_konten == 0 ? 1 : $prev_official->total_konten)) / $prev_official->owner->followersCount * 100;
        $previousRate = $this->safe_divide($previousRateAct, ($prevPointchecks ? $prevPointchecks->engagement_target : $pointchecks->engagement_target), $previousRateAct) * 100;
        $rateDiff = $rateAct - $previousRateAct;


        $data['totalKonten'] = $data['kerjasama']->total_kerjasama + $data['official']->total_konten;
        $data['prev_totalKonten'] = $data['prev_kerjasama']->total_kerjasama + $data['prev_official']->total_konten;
        $data['totalKontenDiff'] = $data['totalKonten'] - $data['prev_totalKonten'];
        $data['totalViews'] = $data['kerjasama']->total_view + $data['official']->total_view;
        $data['prev_totalViews'] = $data['prev_kerjasama']->total_view + $data['prev_official']->total_view;
        $data['totalViewsDiff'] = $data['totalViews'] - $data['prev_totalViews'];
        $data['totalFollowers'] = $data['official']->owner->followersCount;
        $data['pref_totalFollowers'] = $data['prev_official']->owner->followersCount;
        $data['totalFollowersDiff'] = $data['totalFollowers'] - $data['pref_totalFollowers'];

        return [
            'owner' => $data['official']->owner,
            'totalKonten' => $data['totalKonten'],
            'totalKontenPrevious' => $data['prev_totalKonten'],
            'totalKontenDiff' => $data['totalKontenDiff'],
            'totalViews' => $data['totalViews'],
            'totalViewsPrevious' => $data['prev_totalViews'],
            'totalViewsDiff' => $data['totalViewsDiff'],
            'totalFollowers' => $data['totalFollowers'],
            'totalFollowersPrevious' => $data['pref_totalFollowers'],
            'totalFollowersDiff' => $data['totalFollowersDiff'],
            'totalEngagementRate' => ROUND($rateAct, 2),
            'totalEngagementRatePrevious' => ROUND($previousRateAct, 2),
            'totalEngagementRateDiff' => ROUND($rateDiff, 2),
        ];
    }
    private function safe_divide($numerator, $denominator, $default = 0)
    {
        return $denominator == 0 ? $default : $numerator / $denominator;
    }

    public function get_timeline_activities()
    {
        $date = $this->input->post('date');
        $company_id = $this->input->post('company_id') ?: '2';

        $activities = $this->model_admin_sosial->get_timeline_activities($date, $company_id);

        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'data' => $activities]);
    }

    public function save_adsos_engage()
    {
        $engage_id = $this->input->post('engage_id');
        $data = [
            'adsos_category_id' => $this->input->post('adsos_category_id'),
            'date' => $this->input->post('date'),
            'account_id' => $this->input->post('engage_account_id'),
            'evidence_link' => $this->input->post('evidence_link'),
            'note' => $this->input->post('note'),
            'company_id' => $this->input->post('company_id'),
        ];

        $save = $this->model_admin_sosial->save_adsos_engage($data, $engage_id);

        header('Content-Type: application/json');
        if ($save) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data']);
        }
    }

    public function delete_adsos_engage()
    {
        $engage_id = $this->input->post('engage_id');
        $delete = $this->model_admin_sosial->delete_adsos_engage($engage_id);

        header('Content-Type: application/json');
        if ($delete) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data']);
        }
    }

    public function get_engage_by_id()
    {
        $engage_id = $this->input->post('engage_id');
        $data = $this->model_admin_sosial->get_engage_by_id($engage_id);

        header('Content-Type: application/json');
        if ($data) {
            echo json_encode(['status' => 'success', 'data' => $data]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
    }
}
