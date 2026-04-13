<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_marcom_post extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_platform()
	{
		return $this->db->get_where('m_platform_marcom', ['is_active' => 1])->result();
	}

	public function get_account()
	{
		return $this->db->get_where('m_account', ['is_active' => 1])->result();
	}

	public function get_week()
	{
		return $this->db->get_where('m_week', ['is_active' => 1])->result();
	}

	public function get_content_type()
	{
		return $this->db->get_where('m_content_type', ['is_active' => 1])->result();
	}

	public function insert_post($data)
	{
		return $this->db->insert('t_content', $data);
	}

	public function get_list($start = null, $end = null)
	{
		$this->db->select("
        t_content.*,
        m_platform_marcom.platform_name,
        m_account.account_name,
        m_week.week_number,
        m_content_type.content_type_name,
		CONCAT(emp.first_name, ' ', emp.last_name) as created_by_name
    ");
		$this->db->from('t_content');
		$this->db->join('m_account', 'm_account.id = t_content.account_id');
		$this->db->join('m_platform_marcom', 'm_platform_marcom.id = m_account.platform_id');
		$this->db->join('m_week', 'm_week.id = t_content.week_id');
		$this->db->join('m_content_type', 'm_content_type.id = t_content.content_type_id');
		$this->db->join('xin_employees emp', 'emp.user_id = t_content.created_by', 'left');

		if ($start && $end) {
			$this->db->where('post_date >=', $start);
			$this->db->where('post_date <=', $end);
		}

		$this->db->order_by('t_content.id', 'DESC');

		$result = $this->db->get()->result();

		foreach ($result as &$row) {

			$engagement = $row->likes + $row->comments + $row->saves + $row->shares;

			$er = ($row->reach > 0)
				? round(($engagement / $row->reach) * 100, 2)
				: 0;

			$ach = ($row->target_engagement > 0)
				? round(($engagement / $row->target_engagement) * 100, 2)
				: 0;

			$row->engagement = $engagement;
			$row->er = $er . '%';
			$row->achievement = $ach . '%';
		}

		return $result;
	}

	// dashboard
	public function get_summary($start, $end)
	{
		// INSTAGRAM
		$this->db->select('
        COALESCE(COUNT(id), 0) as total,
        COALESCE(SUM(views), 0) as views,
        COALESCE(SUM(likes), 0) as likes,
        COALESCE(SUM(comments), 0) as comments
    ');
		$this->db->from('t_content');
		$this->db->where('platform_id', 1); // Instagram
		if (!empty($start)) $this->db->where('post_date >=', $start);
		if (!empty($end)) $this->db->where('post_date <=', $end);

		// PERBAIKAN: Ubah return ->result() menjadi $ig = ... ->row_array()
		$ig = $this->db->get()->row_array();

		// TIKTOK
		$this->db->select('
        COALESCE(SUM(views), 0) as views,
        COALESCE(SUM(likes), 0) as likes,
        COALESCE(SUM(shares), 0) as shares,
        COALESCE(SUM(saves), 0) as saves
    ');
		$this->db->from('t_content');
		$this->db->where('platform_id', 2); // TikTok
		if (!empty($start)) $this->db->where('post_date >=', $start);
		if (!empty($end)) $this->db->where('post_date <=', $end);

		// PERBAIKAN: Ubah ->result() menjadi ->row_array()
		$tt = $this->db->get()->row_array();

		// Karena $ig dan $tt sekarang sudah didefinisikan, array ini akan berjalan normal
		return [
			'instagram' => $ig,
			'tiktok'    => $tt,
			'cs'        => [
				'ceklok'  => 0,
				'booking' => 0
			]
		];
	}

	public function get_user_performance($start, $end)
	{
		$query = "SELECT
					t.created_by,
					CONCAT(e.first_name, ' ', e.last_name) as user_name,
					COUNT(t.id) as total_posts,
					SUM(CASE WHEN t.platform_id = 1 THEN t.views ELSE 0 END) as ig_views,
					SUM(CASE WHEN t.platform_id = 1 THEN t.likes ELSE 0 END) as ig_likes,
					SUM(CASE WHEN t.platform_id = 2 THEN t.views ELSE 0 END) as tt_views,
					SUM(CASE WHEN t.platform_id = 2 THEN t.likes ELSE 0 END) as tt_likes
					FROM
					t_content t
					JOIN xin_employees e ON e.user_id = t.created_by
					WHERE
					t.post_date >= '$start'
					AND t.post_date <= '$end'
					GROUP BY
					t.created_by
					ORDER BY
					total_posts DESC";

		return $this->db->query($query)->result();
	}

	public function get_user_detail($user_id, $start, $end)
	{
		$this->db->select("
        t.id,
        t.post_date,
        t.title,
        t.post_link,
        t.views,
        t.likes,
        t.comments,
        t.shares,
        t.saves,

        p.platform_name,
        a.account_name,
        c.content_type_name
    ");

		$this->db->from('t_content t');

		$this->db->join('m_platform_marcom p', 'p.id = t.platform_id', 'left');
		$this->db->join('m_account a', 'a.id = t.account_id', 'left');
		$this->db->join('m_content_type c', 'c.id = t.content_type_id', 'left');

		$this->db->where('t.created_by', $user_id);
		$this->db->where('t.post_date >=', $start);
		$this->db->where('t.post_date <=', $end);

		$this->db->order_by('t.post_date', 'DESC');

		return $this->db->get()->result_array();
	}

	public function get_top_pic($start, $end)
	{
		$this->db->select("
        t.created_by,
        CONCAT(e.first_name, ' ', e.last_name) as user_name,

        SUM(t.views) as total_views,
        SUM(t.likes + t.comments + t.shares + t.saves) as total_engagement
    ");

		$this->db->from('t_content t');
		$this->db->join('xin_employees e', 'e.user_id = t.created_by', 'left');

		$this->db->where('t.post_date >=', $start);
		$this->db->where('t.post_date <=', $end);

		$this->db->group_by('t.created_by');
		$this->db->order_by('total_engagement', 'DESC');
		$this->db->limit(3);

		return $this->db->get()->result_array();
	}

	public function get_summary_periode($start, $end)
	{
		$this->db->select("
        DATE_FORMAT(post_date, '%Y-%m') as periode,
        SUM(views) as total_views,
        SUM(likes + comments + shares + saves) as total_engagement
    ");

		$this->db->from('t_content');

		$this->db->where('post_date >=', $start);
		$this->db->where('post_date <=', $end);

		$this->db->group_by("DATE_FORMAT(post_date, '%Y-%m')");
		$this->db->order_by("periode", "ASC");

		return $this->db->get()->result_array();
	}

	public function get_platform_comparison($start, $end)
	{
		$this->db->select("
        p.platform_name,
        SUM(t.views) as total_views,
        SUM(t.likes + t.comments + t.shares + t.saves) as total_engagement
    ");

		$this->db->from('t_content t');
		$this->db->join('m_platform_marcom p', 'p.id = t.platform_id');

		$this->db->where('t.post_date >=', $start);
		$this->db->where('t.post_date <=', $end);

		$this->db->group_by('t.platform_id');

		return $this->db->get()->result_array();
	}

	public function get_er_per_account($start, $end)
	{
		$this->db->select("
        a.account_name,
        SUM(t.views) as total_views,
        SUM(t.likes + t.comments + t.shares + t.saves) as total_engagement,
        (SUM(t.likes + t.comments + t.shares + t.saves) / NULLIF(SUM(t.views),0)) * 100 as er
    ");

		$this->db->from('t_content t');
		$this->db->join('m_account a', 'a.id = t.account_id');

		$this->db->where('t.post_date >=', $start);
		$this->db->where('t.post_date <=', $end);

		$this->db->group_by('t.account_id');

		return $this->db->get()->result_array();
	}
}
