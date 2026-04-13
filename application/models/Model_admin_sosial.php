<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_admin_sosial extends CI_Model
{

    private $db_dashboard_instagram;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->db_dashboard_instagram = $this->load->database('dashboard_instagram', TRUE);
    }

    public function generate_adsos_id()
    {
        $q = $this->db->query("SELECT CONCAT('AD',DATE_FORMAT(NOW(), '%y%m%d'),LPAD(COALESCE(MAX(CAST(SUBSTRING(adsos_id, 9) AS UNSIGNED)), 0) + 1,3,'0')) AS new_id FROM t_adsos_media WHERE DATE(created_at) = CURDATE()")->row();
        $next_number = ($q->new_id !== null) ? $q->new_id : 'AD' . date('ymd') . '001';
        return $next_number;
    }

    public function generate_engage_id()
    {
        $q = $this->db->query("SELECT CONCAT('EG',DATE_FORMAT(NOW(), '%y%m%d'),LPAD(COALESCE(MAX(CAST(SUBSTRING(engage_id, 9) AS UNSIGNED)), 0) + 1,3,'0')) AS new_id FROM t_adsos_engage WHERE DATE(created_at) = CURDATE()")->row();
        $next_number = ($q->new_id !== null) ? $q->new_id : 'EG' . date('ymd') . '001';
        return $next_number;
    }

    public function get_category($type, $company_id, $account_id, $start_date, $end_date)
    {
        $query = "SELECT
                    c.id,
                    c.company_id,
                    c.type,
                    c.category,
                    c.title,
                    c.short_desc,
                    c.category,
                    c.target * (DATEDIFF('$end_date', '$start_date') + 1) AS `target`,
                    COUNT(DISTINCT ad.adsos_id) AS actual,
                    ROUND(COUNT(DISTINCT ad.adsos_id) / c.target * (DATEDIFF('$end_date', '$start_date') + 1) * 100) AS pct
                    FROM
                    m_adsos_category c
                    LEFT JOIN `t_adsos_media` ad ON c.id = ad.adsos_category_id 
                    AND DATE(ad.`date`) BETWEEN '$start_date' 
                    AND '$end_date' AND ad.account_id = '$account_id'
                    WHERE c.company_id = '$company_id' AND c.type = '$type'
                    GROUP BY c.id";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_account()
    {
        $user_id = $this->session->userdata('user_id');
        $query = "SELECT id AS account_id, account_name, company_id, owner_id FROM m_adsos_account WHERE company_id in (2,5) AND FIND_IN_SET('$user_id', pic)";
        return $this->db->query($query)->result();
    }

    public function get_admin_sosial_media($company_id, $account_id, $start_date, $end_date)
    {
        $query = "SELECT
                    ad.adsos_id,
                    ad.company_id,
                    ad.adsos_category_id,
                    c.category AS adsos_category_name,
                    ad.account_id,
                    ac.account_name,
                    ad.profile_link,
                    ad.is_dm,
                    DATE_FORMAT(ad.`date`, '%d-%m-%Y %H:%i') AS date,
                    CONCAT(e.first_name, ' ', e.last_name) AS employee_name 
                    FROM
                    t_adsos_media ad
                    LEFT JOIN m_adsos_account ac ON ad.account_id = ac.id
                    LEFT JOIN m_adsos_category c ON c.id = ad.adsos_category_id
                    LEFT JOIN xin_employees e ON e.user_id = ad.created_by 
                    WHERE
                    ad.company_id = '$company_id' 
                    AND ad.account_id = '$account_id'
                    AND DATE(ad.DATE) BETWEEN '$start_date' 
                    AND '$end_date'";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function save_adsos($data, $adsos_id = null)
    {
        $user_id = $this->session->userdata('user_id');

        if ($adsos_id) {
            $data['updated_by'] = $user_id;
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->db->where('adsos_id', $adsos_id);
            return $this->db->update('t_adsos_media', $data);
        } else {
            $data['adsos_id'] = $this->generate_adsos_id();;
            $data['created_by'] = $user_id;
            $data['created_at'] = date('Y-m-d H:i:s');
            return $this->db->insert('t_adsos_media', $data);
        }
    }

    public function save_adsos_engage($data, $engage_id = null)
    {
        $user_id = $this->session->userdata('user_id');

        if ($engage_id) {
            $data['updated_by'] = $user_id;
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->db->where('engage_id', $engage_id);
            return $this->db->update('t_adsos_engage', $data);
        } else {
            $data['engage_id'] = $this->generate_engage_id();
            $data['created_by'] = $user_id;
            $data['created_at'] = date('Y-m-d H:i:s');
            return $this->db->insert('t_adsos_engage', $data);
        }
    }

    public function delete_adsos($adsos_id)
    {
        $this->db->where('adsos_id', $adsos_id);
        return $this->db->delete('t_adsos_media');
    }

    public function delete_adsos_engage($engage_id)
    {
        $this->db->where('engage_id', $engage_id);
        return $this->db->delete('t_adsos_engage');
    }

    function get_resume_official($periode, $owner_id)
    {
        $query = "SELECT
                        COALESCE(count( id_post ),0) AS total_konten,
                        COALESCE(SUM( commentsCount ),0) AS total_comment,
                        COALESCE(SUM( likesCount ),0) AS total_like,
                        COALESCE(SUM( videoPlayCount ),0) AS total_view,
                        COALESCE(SUM( videoViewCount ),0) AS total_viewers,
                        COALESCE(SUM( rate/COALESCE(videoPlayCount,1) ),0) AS total_cpv,
                        COALESCE(SUM( rate/COALESCE(commentsCount,1) ),0) AS total_cpl,
                        COALESCE(SUM( (likesCount+commentsCount)/followersCount ),0) as total_rate
                    FROM
                        ( SELECT id, MAX( scraped_at ) AS scraped_at FROM t_posts WHERE DATE_FORMAT(`timestamp`, '%Y-%m') = '$periode' 
                        AND ownerId = '$owner_id' GROUP BY id ) AS latest_posts
                        inner JOIN t_posts ON t_posts.id = latest_posts.id 
                        AND t_posts.scraped_at = latest_posts.scraped_at
						LEFT JOIN (
						SELECT
									t_profile.id,
									followersCount
							FROM
						(SELECT id, MAX( scraped_at ) AS scraped_at FROM t_profile WHERE id = '$owner_id' GROUP BY id) AS latest_profile
						inner JOIN t_profile ON latest_profile.id = t_profile.id
						AND latest_profile.scraped_at = t_profile.scraped_at
						) as latest_profile
						on t_posts.ownerId = latest_profile.id";
        return $this->db_dashboard_instagram->query($query)->row();
    }

    public function get_owner($owner_id)
    {
        $query = "SELECT t_profile.* FROM
                    (SELECT
                        id, MAX(scraped_at) AS scraped_at
                    FROM
                        t_profile
                    WHERE id = $owner_id
                    GROUP BY
                        id) AS latest_profile
                    INNER JOIN
                    t_profile
                    ON
                    t_profile.id = latest_profile.id AND
                    t_profile.scraped_at = latest_profile.scraped_at
                    group by latest_profile.id;";
        $result = $this->db_dashboard_instagram->query($query)->row();
        return $result;
    }

    public function get_prev_owner($owner_id, $prev_year_month)
    {
        $query = "SELECT t_profile.* FROM
                    (SELECT
                        id, MAX(scraped_at) AS scraped_at
                    FROM
                        t_profile
                    WHERE id = $owner_id AND SUBSTRING(scraped_at,1,7) != '$prev_year_month'
                    GROUP BY
                        id) AS latest_profile
                    INNER JOIN
                    t_profile
                    ON
                    t_profile.id = latest_profile.id AND
                    t_profile.scraped_at = latest_profile.scraped_at
                    group by latest_profile.id;";
        $result = $this->db_dashboard_instagram->query($query)->row();
        return $result;
    }

    public function get_owner_by_date($owner_id, $date)
    {
        $query = "SELECT prof
        .* FROM
                    dashboard_instagram.t_profile prof
                    where id = '$owner_id'
                    and scraped_at LIKE '$date%'
                    ORDER BY scraped_at DESC
                    LIMIT 1";
        $result = $this->db->query($query)->row();
        return $result;
    }

    function get_resume_kerjasama($periode, $kategori = '')
    {
        if (!empty($kategori)) {
            $condition = "AND kategori = $kategori";
        } else {
            $condition = "";
        }
        $query = "SELECT
        COUNT( id_post ) AS total_kerjasama,
        COALESCE(SUM( commentsCount ),0) AS total_comment,
        COALESCE(SUM( likesCount ),0) AS total_like,
        COALESCE(SUM( videoPlayCount ),0) AS total_view,
        COALESCE(SUM( videoViewCount ),0) AS total_viewers,
        COALESCE(SUM( rate/COALESCE(videoPlayCount,1) ),0) AS total_cpv,
        COALESCE(SUM( rate/COALESCE(commentsCount,1) ),0) AS total_cpl,
        COALESCE(AVG( rate/COALESCE(videoPlayCount,1) ),0) AS avg_cpv,
        COALESCE(SUM( (likesCount+commentsCount)/followersCount ),0) as total_rate
    FROM
        ( SELECT id, MAX( scraped_at ) AS scraped_at FROM t_kerjasama WHERE 
	DATE_FORMAT(`timestamp`, '%Y-%m') = '$periode' $condition GROUP BY id ) AS latest_kerjasama
        INNER JOIN t_kerjasama ON t_kerjasama.id = latest_kerjasama.id 
        AND t_kerjasama.scraped_at = latest_kerjasama.scraped_at
        LEFT JOIN 
        (SELECT * FROM t_profile GROUP BY id) t_profile ON t_kerjasama.ownerId = t_profile.id
        ";
        return $this->db_dashboard_instagram->query($query)->row();
    }

    public function get_pointchecks_monthly($yearmonth)
    {
        $query = "SELECT
                    *
                    FROM t_pointcheck
                    where periode = '$yearmonth'
                    ;";
        $result = $this->db_dashboard_instagram->query($query)->row();
        return $result;
    }

    public function get_timeline_activities($date, $company_id)
    {
        $query = "SELECT
                    eg.engage_id,
                    eg.company_id,
                    eg.adsos_category_id,
                    c.category AS type,
                    ac.account_name AS account_name,
                    eg.evidence_link,
                    eg.note,
                    DATE_FORMAT(eg.`date`, '%H:%i') AS time,
                    DATE_FORMAT(eg.`date`, '%H') AS hour,
                    CONCAT(e.first_name, ' ', e.last_name) AS employee_name,
                    c.color as badge_color,
                    c.title as description
                    FROM
                    t_adsos_engage eg
                    LEFT JOIN m_adsos_account ac ON eg.account_id = ac.id
                    LEFT JOIN m_adsos_category c ON c.id = eg.adsos_category_id
                    LEFT JOIN xin_employees e ON e.user_id = eg.created_by 
                    WHERE
                    eg.company_id = '$company_id' 
                    AND DATE(eg.DATE) = '$date'
                    ORDER BY eg.date ASC";
        $result = $this->db->query($query)->result();
        return $result;
    }

    public function get_team($company_id)
    {
        $query = "SELECT DISTINCT
                    e.user_id,
                    CONCAT(e.first_name, ' ', e.last_name) AS name,
                    LEFT(e.first_name, 1) AS initial
                    FROM
                    xin_employees e
                    JOIN t_adsos_media ad ON e.user_id = ad.created_by
                    WHERE ad.company_id = '$company_id' OR e.department_id = 12"; // Assuming department_id 12 is Medsos
        $result = $this->db->query($query)->result();
        return $result;
    }

    public function get_engage_by_id($engage_id)
    {
        $query = "SELECT
                    eg.engage_id,
                    eg.adsos_category_id,
                    c.category AS adsos_category_name,
                    eg.date,
                    eg.account_id,
                    ac.account_name AS account_name,
                    eg.evidence_link,
                    eg.note,
                    eg.company_id
                    FROM
                    t_adsos_engage eg
                    LEFT JOIN m_adsos_account ac ON eg.account_id = ac.id
                    LEFT JOIN m_adsos_category c ON c.id = eg.adsos_category_id
                    WHERE eg.engage_id = '$engage_id'";
        $result = $this->db->query($query)->row();
        return $result;
    }
}
