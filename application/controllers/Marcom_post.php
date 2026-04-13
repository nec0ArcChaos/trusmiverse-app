<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Marcom_post extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->model('Model_marcom_post', 'model');
        $this->load->library('FormatJson');
        $this->load->library('Filter');

        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }


    function index()
    {
        $data['pageTitle']        = "Marcom Posting";
        $data['css']              = "marcom_post/css";
        $data['js']               = "marcom_post/js";
        $data['content']          = "marcom_post/index";

        $data['platform']     = $this->model->get_platform();
        $data['account']      = $this->model->get_account();
        $data['week']         = $this->model->get_week();
        $data['content_type'] = $this->model->get_content_type();


        $this->load->view('layout/main', $data);
    }

    function dashboard()
    {
        $data['pageTitle']        = "Marcom Dashboard";
        $data['css']              = "marcom_dashboard/css";
        $data['js']               = "marcom_dashboard/js";
        $data['content']          = "marcom_dashboard/index";


        $this->load->view('layout/main', $data);
    }

    public function get_accounts_by_platform()
    {
        $platform_id = $this->input->get('platform_id');

        $this->db->where('platform_id', $platform_id);
        $this->db->where('is_active', 1);
        $data = $this->db->get('m_account')->result();

        echo json_encode([
            'status' => true,
            'data' => $data
        ]);
    }

    public function store()
    {
        $post = $this->input->post();

        $data = [
            'platform_id'     => $post['platform'],
            'account_id'      => $post['account'],
            'week_id'         => $post['week'],
            'content_type_id' => $post['content_type'],
            'title'           => $post['title'],
            'caption'         => $post['caption'],
            'post_link'       => $post['post_link'],
            'post_date'       => $post['post_date'],
            'target_engagement' => $post['target_engagement'],
            'target_view'     => $post['target_view'],
            'post_link'       => $post['post_link'],
            'views'           => $post['views'],
            'reach'           => $post['reach'],
            'likes'           => $post['likes'],
            'comments'        => $post['comments'],
            'saves'           => $post['saves'],
            'shares'          => $post['shares'],
            'created_at'      => date('Y-m-d H:i:s'),
            'created_by'      => $this->session->userdata('user_id')
        ];

        $insert = $this->model->insert_post($data);

        if ($insert) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }

    public function list()
    {
        $start = $this->input->get('start_date');
        $end   = $this->input->get('end_date');

        $data = $this->model->get_list($start, $end);

        echo json_encode([
            "data" => $data
        ]);
    }

    public function store_platform()
    {
        $data = [
            'platform_name' => $this->input->post('platform_name'),
            'created_at'    => date('Y-m-d H:i:s')
        ];

        $this->db->insert('m_platform_marcom', $data);

        echo json_encode(['status' => true]);
    }

    public function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('t_content');

        echo json_encode(['status' => true]);
    }

    public function get_by_id($id)
    {
        $data = $this->db->get_where('t_content', ['id' => $id])->row();

        echo json_encode([
            'status' => true,
            'data' => $data
        ]);
    }

    public function update()
    {
        $id = $this->input->post('id');

        $data = [
            'platform_id'     => $this->input->post('platform'),
            'account_id'      => $this->input->post('account'),
            'week_id'         => $this->input->post('week'),
            'content_type_id' => $this->input->post('content_type'),
            'title'           => $this->input->post('title'),
            'caption'         => $this->input->post('caption'),
            'post_link'       => $this->input->post('post_link'),
            'post_date'       => $this->input->post('post_date'),
            'target_view'     => $this->input->post('target_view'),
            'target_engagement' => $this->input->post('target_engagement'),
            'views'           => $this->input->post('views'),
            'reach'           => $this->input->post('reach'),
            'likes'           => $this->input->post('likes'),
            'comments'        => $this->input->post('comments'),
            'saves'           => $this->input->post('saves'),
            'shares'          => $this->input->post('shares'),
            'updated_at'      => date('Y-m-d H:i:s')
        ];

        $this->db->where('id', $id);
        $this->db->update('t_content', $data);

        echo json_encode(['status' => true]);
    }

    public function list_platform()
    {
        $data = $this->db->get('m_platform_marcom')->result();
        echo json_encode(['data' => $data]);
    }

    public function delete_platform()
    {
        $this->db->where('id', $this->input->post('id'));
        $this->db->delete('m_platform_marcom');

        echo json_encode(['status' => true]);
    }

    public function list_content_type()
    {
        $data = $this->db->get('m_content_type')->result();
        echo json_encode(['data' => $data]);
    }

    public function store_content_type()
    {
        $name = $this->input->post('content_type_name');

        $exists = $this->db
            ->where('content_type_name', $name)
            ->get('m_content_type')
            ->row();

        if ($exists) {
            echo json_encode([
                'status' => false,
                'message' => 'Jenis Konten sudah ada.'
            ]);
            return;
        }

        $this->db->insert('m_content_type', [
            'content_type_name' => $name,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        echo json_encode(['status' => true]);
    }

    public function delete_content_type()
    {
        $this->db->where('id', $this->input->post('id'));
        $this->db->delete('m_content_type');

        echo json_encode(['status' => true]);
    }

    public function list_account()
    {
        $this->db->select('m_account.*, m_platform_marcom.platform_name');
        $this->db->from('m_account');
        $this->db->join('m_platform_marcom', 'm_platform_marcom.id = m_account.platform_id');
        $data = $this->db->get()->result();

        echo json_encode(['data' => $data]);
    }

    public function store_account()
    {
        $platform_id = $this->input->post('platform_id');
        $account_name = $this->input->post('account_name');
        $username = $this->input->post('username');

        $exists = $this->db
            ->where('platform_id', $platform_id)
            ->where('username', $username)
            ->get('m_account')
            ->row();

        if ($exists) {
            echo json_encode([
                'status' => false,
                'message' => 'Username ini sudah terdaftar di platform tersebut.'
            ]);
            return;
        }

        $this->db->insert('m_account', [
            'platform_id' => $platform_id,
            'account_name' => $account_name,
            'username' => $username,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        echo json_encode(['status' => true]);
    }

    public function delete_account()
    {
        $this->db->where('id', $this->input->post('id'));
        $this->db->delete('m_account');

        echo json_encode(['status' => true]);
    }

    public function list_week()
    {
        $data = $this->db
            ->get('m_week')
            ->result();

        echo json_encode(['data' => $data]);
    }

    public function store_week()
    {
        $week_number = $this->input->post('week_number');
        $period      = $this->input->post('period');

        $exists = $this->db
            ->where('week_number', $week_number)
            ->where('periode', $period)
            ->get('m_week')
            ->row();

        if ($exists) {
            echo json_encode([
                'status' => false,
                'message' => 'Week sudah ada di periode ini.'
            ]);
            return;
        }

        $this->db->insert('m_week', [
            'week_number' => $week_number,
            'periode' => $period,
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        echo json_encode(['status' => true]);
    }

    public function delete_week()
    {
        $this->db->where('id', $this->input->post('id'));
        $this->db->delete('m_week');

        echo json_encode(['status' => true]);
    }

    public function get_scrap($id)
    {
        $data = $this->db
            ->select('id, views, reach, likes, comments, saves, shares')
            ->where('id', $id)
            ->get('t_content')
            ->row();

        echo json_encode([
            'status' => true,
            'data' => $data
        ]);
    }

    public function update_scrap()
    {
        $id = $this->input->post('id');

        $data = [
            'views' => $this->input->post('views'),
            'reach' => $this->input->post('reach'),
            'likes' => $this->input->post('likes'),
            'comments' => $this->input->post('comments'),
            'saves' => $this->input->post('saves'),
            'shares' => $this->input->post('shares'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->db->where('id', $id);
        $this->db->update('t_content', $data);

        echo json_encode(['status' => true]);
    }

    // dashboard
    public function get_summary()
    {
        $start = $this->input->get('start_date');
        $end   = $this->input->get('end_date');

        $data = $this->model->get_summary($start, $end);

        echo json_encode($data);
    }

    public function get_user_performance()
    {
        $start = $this->input->get('start_date');
        $end   = $this->input->get('end_date');

        $data = $this->model->get_user_performance($start, $end);

        echo json_encode([
            'data' => $data
        ]);
    }

    public function get_user_detail()
    {
        $user_id = $this->input->get('user_id');
        $start   = $this->input->get('start_date');
        $end     = $this->input->get('end_date');

        $data = $this->model->get_user_detail($user_id, $start, $end);

        echo json_encode([
            'data' => $data
        ]);
    }

    public function get_top_pic()
    {
        $start = $this->input->get('start_date');
        $end   = $this->input->get('end_date');

        $data = $this->model->get_top_pic($start, $end);

        echo json_encode($data);
    }
    public function get_summary_periode()
    {
        $start = $this->input->get('start_date');
        $end   = $this->input->get('end_date');

        echo json_encode(
            $this->model->get_summary_periode($start, $end)
        );
    }

    public function get_platform_comparison()
    {
        $start = $this->input->get('start_date');
        $end   = $this->input->get('end_date');

        echo json_encode(
            $this->model->get_platform_comparison($start, $end)
        );
    }

    public function get_er_per_account()
    {
        $start = $this->input->get('start_date');
        $end   = $this->input->get('end_date');

        echo json_encode(
            $this->model->get_er_per_account($start, $end)
        );
    }
}
