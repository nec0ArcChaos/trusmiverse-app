<?php
// Trusmi History Lock Absen
// Created At : 12-05-2023
defined('BASEPATH') or exit('No direct script access allowed');
class Pembelajar extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_pembelajar', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $data['masa_kerja']       = $this->db->query("SELECT COALESCE(DATEDIFF(CURRENT_DATE,e.date_of_joining),0) AS masa_kerja FROM xin_employees e WHERE e.user_id = '$user_id'")->row();
        $data['pageTitle']        = "Si Pembelajar";
        $data['css']              = "pembelajar/css";
        $data['js']               = "pembelajar/js";
        $data['content']          = "pembelajar/index";

        $this->load->view('layout/main', $data);
    }

    function dt_pembelajar()
    {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $data['data'] = $this->model->dt_pembelajar($start, $end);
        echo json_encode($data);
    }

    public function get_soft_skill()
    {
        $data = $this->model->get_soft_skill();
        echo json_encode($data);
    }

    public function check_link()
    {
        $link = $_POST['link'];
        $cek = $this->db->query("SELECT COUNT(id) AS count FROM `pembelajar` WHERE link = '$link'")->row();
        $data['count'] = $cek->count;
        echo json_encode($data);
    }

    public function save_pembelajar()
    {

        $link = trim($_POST['link']);
        $user_id = $_SESSION['user_id'];
        $check_link_youtube = $this->db->query("SELECT * FROM pembelajar WHERE link = '$link' AND created_by = '$user_id'");
        $response['num_rows'] = $check_link_youtube->num_rows();
        if ($check_link_youtube->num_rows() > 0) {
            $response['status'] = 'failed';
            $response['message'] = 'Terdeteksi Link Youtube sama dengan sebelumnya';
            $response['insert'] = false;
        } else {
            $data = array(
                'id' => $this->model->generate_id_pembelajar(),
                'title' => trim($_POST['title']),
                'author' => trim($_POST['author']),
                'link' => trim($_POST['link']),
                'soft_skill' => $_POST['soft_skill'],
                'point' => trim($_POST['point']),
                'impact' => trim($_POST['impact']),
                'created_at' => $_POST['created_at'],
                'created_at_system' => date("Y-m-d H:i:s"),
                'created_by' => $_SESSION['user_id'],
            );
            $response['status'] = 'success';
            $response['message'] = 'success';
            $response['created_at'] = $_POST['created_at'];
            $response['insert'] = $this->db->insert('pembelajar', $data);
        }
        echo json_encode($response);
    }

    function dt_resume_pembelajar()
    {
        $periode = $_POST['periode'];
        $data['data'] = $this->model->dt_resume_pembelajar($periode);
        echo json_encode($data);
    }


    // OLD
    public function delete_request()
    {
        $this->db->where('time_request_id', $_POST['time_request_id']);
        $response['delete'] = $this->db->delete('xin_attendance_time_request');

        echo json_encode($response);
    }

    function approve_request()
    {

        $approval = array(
            'is_approved' => $_POST['status'],
            'approve_gm' => $_SESSION['user_id'],
            'gm_at' => date('Y-m-d H:i:s'),
        );
        $this->db->where('time_request_id', $_POST['time_request_id']);
        $response['approve'] = $this->db->update('xin_attendance_time_request', $approval);
        echo json_encode($response);
    }

    // 1633, 1448, 2987, 1272, 2675, 2525, 2506, 2396, 1426, 1483, 2529, 1568, 2547, 2399

    public function generate_head_resume()
    {
        // $start = $this->input->post('start') ?? date("Y-m-01");
        // $end = $this->input->post('end') ?? date("Y-m-t");
        $start = date("Y-m-01");
        $end = date("Y-m-t");
        $t_start = $this->db->query("SELECT CASE WHEN WEEKDAY('$start') != 0 THEN DATE_SUB('$start',INTERVAL WEEKDAY('$start')+1 DAY) ELSE '$start' END AS `start`")->row();
        $response['start'] = $t_start->start;
        $response['end'] = $end;
        $data = $this->db->query("SELECT CONCAT('W', ROW_NUMBER() OVER (ORDER BY WEEK(start_date))) AS `week_number`, 
        DATE_FORMAT(MIN(start_date), '%d %b') AS `week_start_date`, DATE_FORMAT(MAX(start_date), '%d %b') AS `week_end_date`
        FROM (
            SELECT ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
            FROM
                (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
            ) v
        WHERE start_date BETWEEN 
        CASE WHEN WEEKDAY('$start') != 0 THEN DATE_SUB('$start',INTERVAL WEEKDAY('$start')+1 DAY) ELSE '$start' END 
        AND '$end'
        GROUP BY WEEK(start_date)
        ORDER BY WEEK(start_date)");
        $response['data'] = $data->result();

        $body_resume = $this->generate_body_resume($t_start->start, $end, $data->num_rows());
        $response['body_resume'] = $body_resume;
        $response['jumlah_week'] = $data->num_rows();
        echo json_encode($response);
    }

    public function generate_head_resume_v3()
    {
        $start = date("Y-m-01");
        $end = date("Y-m-t");
        $data = $this->db->query("SELECT
                        CONCAT('W',@rank := @rank + 1) AS week_number,
                        CASE WHEN SUBSTR(calendar_week.tgl_awal,1,7) = SUBSTR(calendar_week.tgl_akhir,1,7)  THEN
                            DATE_FORMAT(calendar_week.tgl_awal,'%d')
                        WHEN SUBSTR(calendar_week.tgl_awal,1,4) != SUBSTR(calendar_week.tgl_akhir,1,4) THEN
                            DATE_FORMAT(calendar_week.tgl_awal,'%d %b %y')
                        ELSE
                            DATE_FORMAT(calendar_week.tgl_awal,'%d %b')
                        END AS f_tgl_awal,
	                    CASE WHEN SUBSTR(calendar_week.tgl_awal,1,7) = SUBSTR(calendar_week.tgl_akhir,1,7)  THEN
                            DATE_FORMAT(calendar_week.tgl_akhir,'%d %b %y')
                        WHEN SUBSTR(calendar_week.tgl_awal,1,4) != SUBSTR(calendar_week.tgl_akhir,1,4) THEN
                            DATE_FORMAT(calendar_week.tgl_akhir,'%d %b %y')
                        ELSE
                            DATE_FORMAT(calendar_week.tgl_akhir,'%d %b %y')
                        END AS f_tgl_akhir,
                        calendar_week.* 
                    FROM (
                        SELECT
                            start_date AS `tgl_awal`,
                            (start_date + INTERVAL 6 DAY) AS tgl_akhir
                        FROM 
                        (
                            SELECT 
                                ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                            FROM
                                (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                                (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                                (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                                (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                                (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                        ) v
                        WHERE start_date BETWEEN DATE_SUB('$start', INTERVAL 1 WEEK) AND '$end' AND WEEKDAY(start_date) = 1
                        GROUP BY (start_date)
                        ORDER BY (start_date)
                    ) AS calendar_week, 
                    (SELECT @rank := 0 ) AS num");
        $response['data'] = $data->result();

        $body_resume = $this->generate_body_resume_v3($start, $end, $data->num_rows());
        $response['body_resume'] = $body_resume;
        $response['jumlah_week'] = $data->num_rows();
        echo json_encode($response);
    }

    public function generate_body_resume($start, $end, $jumlah_week)
    {
        $select = "";
        $week = 1;
        for ($i = 0; $i < $jumlah_week; $i++) {
            $select .= "COUNT(IF(xx.input >= 1 AND xx.week_number = 'W" . $week . "',1,NULL)) AS w" . $week . ",";
            $week++;
        }
        $query = "SELECT 
                    xx.user_id, 
                    xx.employee_name,
                    $select 
                    -- COUNT(IF(xx.input = 1 AND xx.week_number = 'W1',1,NULL)) AS w1, 
                    -- COUNT(IF(xx.input >= 1 AND xx.week_number = 'W2',1,NULL)) AS w2, 
                    -- COUNT(IF(xx.input >= 1 AND xx.week_number = 'W3',1,NULL)) AS w3, 
                    -- COUNT(IF(xx.input >= 1 AND xx.week_number = 'W4',1,NULL)) AS w4, 
                    -- COUNT(IF(xx.input >= 1 AND xx.week_number = 'W5',1,NULL)) AS w5, 
                    -- COUNT(IF(xx.input >= 1 AND xx.week_number = 'W6',1,NULL)) AS w6,
                    xx.jabatan
                FROM(
                    SELECT 
                        x.*, 
                        GROUP_CONCAT(DISTINCT SUBSTR(p.created_at,1,10)) AS created_at, 
                        (IF(p.created_at IS NOT NULL,1,0)) AS input 
                    FROM 
                    (
                        SELECT 
                            * 
                        FROM 
                        (
                            SELECT 
                                e.user_id,
                                CONCAT(e.first_name,' ',e.last_name) AS employee_name,
                                ds.designation_name AS jabatan
                            FROM xin_employees e
                            LEFT JOIN xin_user_roles ur ON ur.role_id = e.user_role_id
                            LEFT JOIN xin_departments d ON d.department_id = e.department_id
                            LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
                            WHERE (e.company_id = 2 
                            -- AND e.user_role_id IN (2,3,4,5) 
                            AND ur.level_sto >= 4 
                            AND DATEDIFF(CURRENT_DATE,e.date_of_joining) > 30
                            AND e.is_active = 1) OR (e.user_id IN (1633, 1448, 2987, 1272, 2675, 2525, 2506, 2396, 1426, 1483, 2529, 1568, 2547, 2399, 68, 78, 1139, 1784, 2069, 2521, 2535, 476, 116, 118, 454, 573, 637, 638, 998, 1013, 1212, 1294, 1299, 1563, 1721, 1733, 1844, 2108, 3648, 3961, 4201, 77,5739) AND e.is_active = 1)
                        ) t_master, 
                        (
                            SELECT
							CONCAT('W', ROW_NUMBER() OVER (ORDER BY (start_date))) AS `week_number`,
                            start_date AS `start_week`, 
                            (start_date + INTERVAL 6 DAY) AS end_week
                        FROM 
                        (
                            SELECT 
                                ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                            FROM
                                (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                                (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                                (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                                (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                                (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                        ) v
                        WHERE start_date BETWEEN DATE_SUB('$start', INTERVAL 1 WEEK) AND '$end' AND WEEKDAY(start_date) = 1
                        GROUP BY (start_date)
                        ORDER BY (start_date)
										) AS t_tgl ORDER BY user_id
                    ) AS x
                    LEFT JOIN pembelajar p  ON p.created_by = x.user_id AND SUBSTR(created_at,1,10) BETWEEN x.start_week AND x.end_week
                    GROUP BY x.user_id, x.week_number
                ) xx GROUP BY xx.user_id";
        return $this->db->query($query)->result();
    }


    public function generate_body_resume_v3($start, $end, $jumlah_week)
    {

        $user_id = $this->session->userdata('user_id');
        $department_id = $this->session->userdata('department_id');

        $condition = "WHERE xx.user_id ='$user_id'";
        $department_hr = [
            1,
            72,
            73,
            156,
            157,
            167
        ];
        if ($user_id == 1 || in_array($department_id, $department_hr) == 1) {
            $condition = "";
        }

        $select = "";
        $week = 1;
        for ($i = 0; $i < $jumlah_week; $i++) {
            $select .= " COUNT(IF(xx.input >= 1 AND xx.w = '$week',1,NULL)) AS w" . $week . ",";
            $select .= " SUM(IF(xx.w = '$week',COALESCE(xx.input,0),0)) AS input_w" . $week . ",";
            $week++;
        }
        $query = "SELECT 
                    xx.user_id, 
                    xx.employee_name,
                    $select 
                    -- COUNT(IF(xx.input = 1 AND xx.week_number = 'W1',1,NULL)) AS w1, 
                    -- COUNT(IF(xx.input >= 1 AND xx.week_number = 'W2',1,NULL)) AS w2, 
                    -- COUNT(IF(xx.input >= 1 AND xx.week_number = 'W3',1,NULL)) AS w3, 
                    -- COUNT(IF(xx.input >= 1 AND xx.week_number = 'W4',1,NULL)) AS w4, 
                    -- COUNT(IF(xx.input >= 1 AND xx.week_number = 'W5',1,NULL)) AS w5, 
                    -- COUNT(IF(xx.input >= 1 AND xx.week_number = 'W6',1,NULL)) AS w6,
                    xx.company_name,
                    xx.jabatan
                FROM(
                    SELECT tm.user_id, tm.employee_name, tm.company_name, tm.jabatan, th.w, th.tgl_awal, th.tgl_akhir, SUM(IF(th.w IS NOT NULL,1,0)) AS input FROM
                    (SELECT 
                            e.user_id,
                            CONCAT(e.first_name,' ',e.last_name) AS employee_name,
                            c.name AS company_name,
                            ds.designation_name AS jabatan
                    FROM xin_employees e
                    LEFT JOIN xin_user_roles ur ON ur.role_id = e.user_role_id
                    LEFT JOIN xin_companies c ON c.company_id = e.company_id
                    LEFT JOIN xin_departments d ON d.department_id = e.department_id
                    LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
                    WHERE (
                    -- e.company_id NOT IN (3,4) 
                    -- AND e.user_role_id IN (2,3,4,5) 
                    -- AND 
                    ur.level_sto >= 4 
                    AND DATEDIFF(CURRENT_DATE,e.date_of_joining) > 30
                    AND e.is_active = 1) OR (e.user_id IN (2, 1633,1448,2987,1272,2675,2525,2506,2396,1426,1483,2529,1568,2547,2399,68,78,1139,1784,2069,2521,2535,476,116,118,454,573,637,638,998,1013,1212,1294,1299,1563,1721,1733,1844,2108,3648,3961,4201,77,321,2733,1369,2127,61,64,1161,1287,5739,5624, 5777, 5796) AND e.is_active = 1)
                    ) AS tm
                    LEFT JOIN pembelajar p ON p.created_by = tm.user_id
                    LEFT JOIN (
                                        SELECT
                                            @rank := @rank + 1 AS w,
                                            calendar_week.* 
                                        FROM (
                                            SELECT
                                                start_date AS `tgl_awal`,
                                                (start_date + INTERVAL 6 DAY) AS tgl_akhir
                                            FROM 
                                            (
                                                SELECT 
                                                    ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                                                FROM
                                                    (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                                                    (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                                                    (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                                                    (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                                                    (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                                            ) v
                                            WHERE start_date BETWEEN DATE_SUB('$start', INTERVAL 1 WEEK) AND '$end' AND WEEKDAY(start_date) = 1
                                            GROUP BY (start_date)
                                            ORDER BY (start_date)
                                        ) AS calendar_week, 
                                        (SELECT @rank := 0 ) AS num
                    ) th ON SUBSTR(p.created_at,1,10) BETWEEN th.tgl_awal AND th.tgl_akhir
                    GROUP BY tm.user_id, th.w
                ) xx $condition GROUP BY xx.user_id";
        return $this->db->query($query)->result();
    }

    public function generate_head_resume_v3_dev()
    {
        $start = date("Y-m-01");
        $end = date("Y-m-t");
        $data = $this->db->query("SELECT
                        CONCAT('W',@rank := @rank + 1) AS week_number,
                        CASE WHEN SUBSTR(calendar_week.tgl_awal,1,7) = SUBSTR(calendar_week.tgl_akhir,1,7)  THEN
                            DATE_FORMAT(calendar_week.tgl_awal,'%d')
                        WHEN SUBSTR(calendar_week.tgl_awal,1,4) != SUBSTR(calendar_week.tgl_akhir,1,4) THEN
                            DATE_FORMAT(calendar_week.tgl_awal,'%d %b %y')
                        ELSE
                            DATE_FORMAT(calendar_week.tgl_awal,'%d %b')
                        END AS f_tgl_awal,
	                    CASE WHEN SUBSTR(calendar_week.tgl_awal,1,7) = SUBSTR(calendar_week.tgl_akhir,1,7)  THEN
                            DATE_FORMAT(calendar_week.tgl_akhir,'%d %b %y')
                        WHEN SUBSTR(calendar_week.tgl_awal,1,4) != SUBSTR(calendar_week.tgl_akhir,1,4) THEN
                            DATE_FORMAT(calendar_week.tgl_akhir,'%d %b %y')
                        ELSE
                            DATE_FORMAT(calendar_week.tgl_akhir,'%d %b %y')
                        END AS f_tgl_akhir,
                        calendar_week.* 
                    FROM (
                        SELECT
                            start_date AS `tgl_awal`,
                            (start_date + INTERVAL 6 DAY) AS tgl_akhir
                        FROM 
                        (
                            SELECT 
                                ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                            FROM
                                (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                                (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                                (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                                (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                                (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                        ) v
                        WHERE start_date BETWEEN DATE_SUB('$start', INTERVAL 1 WEEK) AND '$end' AND WEEKDAY(start_date) = 1
                        GROUP BY (start_date)
                        ORDER BY (start_date)
                    ) AS calendar_week, 
                    (SELECT @rank := 0 ) AS num");
        $response['data'] = $data->result();

        $body_resume = $this->generate_body_resume_v3_dev($start, $end, $data->num_rows());
        $response['body_resume'] = $body_resume;
        $response['jumlah_week'] = $data->num_rows();
        echo json_encode($response);
    }

    public function generate_body_resume_v3_dev($start, $end, $jumlah_week)
    {
        $select = "";
        $week = 1;
        for ($i = 0; $i < $jumlah_week; $i++) {
            $select .= " COUNT(IF(xx.input >= 1 AND xx.w = '$week',1,NULL)) AS w" . $week . ",";
            $select .= " SUM(IF(xx.w = '$week',COALESCE(xx.input,0),0)) AS input_w" . $week . ",";
            $week++;
        }
        $query = "SELECT 
                    xx.user_id, 
                    xx.employee_name,
                    $select 
                    -- COUNT(IF(xx.input = 1 AND xx.week_number = 'W1',1,NULL)) AS w1, 
                    -- COUNT(IF(xx.input >= 1 AND xx.week_number = 'W2',1,NULL)) AS w2, 
                    -- COUNT(IF(xx.input >= 1 AND xx.week_number = 'W3',1,NULL)) AS w3, 
                    -- COUNT(IF(xx.input >= 1 AND xx.week_number = 'W4',1,NULL)) AS w4, 
                    -- COUNT(IF(xx.input >= 1 AND xx.week_number = 'W5',1,NULL)) AS w5, 
                    -- COUNT(IF(xx.input >= 1 AND xx.week_number = 'W6',1,NULL)) AS w6,
                    xx.jabatan
                FROM(
                    SELECT tm.user_id, tm.employee_name, tm.jabatan, th.w, th.tgl_awal, th.tgl_akhir, SUM(IF(th.w IS NOT NULL,1,0)) AS input FROM
                    (SELECT 
                            e.user_id,
                            CONCAT(e.first_name,' ',e.last_name) AS employee_name,
                            ds.designation_name AS jabatan
                    FROM xin_employees e
                    LEFT JOIN xin_user_roles ur ON ur.role_id = e.user_role_id
                    LEFT JOIN xin_departments d ON d.department_id = e.department_id
                    LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
                    WHERE (e.company_id = 2 
                    -- AND e.user_role_id IN (2,3,4,5) 
                    AND ur.level_sto >= 4 
                    AND DATEDIFF(CURRENT_DATE,e.date_of_joining) > 30
                    AND e.is_active = 1) OR e.user_id IN (2, 1633, 1448, 2987, 1272, 2675, 2525, 2506, 2396, 1426, 1483, 2529, 1568, 2547, 2399, 68,78,1139,1784,2069,2521,2535)
                    ) AS tm
                    LEFT JOIN pembelajar p ON p.created_by = tm.user_id
                    LEFT JOIN (
                                        SELECT
                                            @rank := @rank + 1 AS w,
                                            calendar_week.* 
                                        FROM (
                                            SELECT
                                                start_date AS `tgl_awal`,
                                                (start_date + INTERVAL 6 DAY) AS tgl_akhir
                                            FROM 
                                            (
                                                SELECT 
                                                    ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                                                FROM
                                                    (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                                                    (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                                                    (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                                                    (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                                                    (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                                            ) v
                                            WHERE start_date BETWEEN DATE_SUB('$start', INTERVAL 1 WEEK) AND '$end' AND WEEKDAY(start_date) = 2
                                            GROUP BY (start_date)
                                            ORDER BY (start_date)
                                        ) AS calendar_week, 
                                        (SELECT @rank := 0 ) AS num
                    ) th ON SUBSTR(p.created_at,1,10) BETWEEN th.tgl_awal AND th.tgl_akhir
                    GROUP BY tm.user_id, th.w
                ) xx GROUP BY xx.user_id";
        return $this->db->query($query)->result();
    }


    public function generate_body_resume_echo($start, $end, $jumlah_week)
    {
        $select = "";
        $week = 1;
        for ($i = 0; $i < $jumlah_week; $i++) {
            $select .= " COUNT(IF(xx.input >= 1 AND xx.week_number = 'W" . $week . "',1,NULL)) AS w" . $week . ",";
            $week++;
        }
        $query = "SELECT 
                    xx.user_id, 
                    xx.employee_name,
                    $select 
                    -- COUNT(IF(xx.input = 1 AND xx.week_number = 'W1',1,NULL)) AS w1, 
                    -- COUNT(IF(xx.input >= 1 AND xx.week_number = 'W2',1,NULL)) AS w2, 
                    -- COUNT(IF(xx.input >= 1 AND xx.week_number = 'W3',1,NULL)) AS w3, 
                    -- COUNT(IF(xx.input >= 1 AND xx.week_number = 'W4',1,NULL)) AS w4, 
                    -- COUNT(IF(xx.input >= 1 AND xx.week_number = 'W5',1,NULL)) AS w5, 
                    -- COUNT(IF(xx.input >= 1 AND xx.week_number = 'W6',1,NULL)) AS w6,
                    xx.jabatan
                FROM(
                    SELECT 
                        x.*, 
                        GROUP_CONCAT(DISTINCT SUBSTR(p.created_at,1,10)) AS created_at, 
                        SUM(IF(p.created_at IS NOT NULL,1,0)) AS input 
                    FROM 
                    (
                        SELECT 
                            * 
                        FROM 
                        (
                            SELECT 
                                e.user_id,
                                CONCAT(e.first_name,' ',e.last_name) AS employee_name,
                                ds.designation_name AS jabatan
                            FROM xin_employees e
                            LEFT JOIN xin_user_roles ur ON ur.role_id = e.user_role_id
                            LEFT JOIN xin_departments d ON d.department_id = e.department_id
                            LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
                            WHERE (e.company_id = 2 
                            -- AND e.user_role_id IN (2,3,4,5) 
                            AND ur.level_sto >= 4 
                            AND DATEDIFF(CURRENT_DATE,e.date_of_joining) > 30
                            AND e.is_active = 1) OR e.user_id IN (1633, 1448, 2987, 1272, 2675, 2525, 2506, 2396, 1426, 1483, 2529, 1568, 2547, 2399, 68,78,1139,1784,2069,2521,5624, 5777, 5796)
                        ) t_master, 
                        (
                            SELECT 
                                CONCAT('W', ROW_NUMBER() OVER (ORDER BY WEEK(start_date))) AS `week_number`, 
                                MIN(start_date) AS start_week,
                                MAX(start_date) AS end_week
                            FROM 
                            (
                                SELECT ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                                FROM
                                (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                                (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                                (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                                (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                                (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                            ) v
                            WHERE start_date BETWEEN CASE WHEN WEEKDAY('$start') != 0 THEN DATE_SUB('$start',INTERVAL WEEKDAY('$start')+1 DAY) ELSE '$start' END AND '$end'
                            GROUP BY WEEK(start_date)
                            ORDER BY WEEK(start_date)) AS t_tgl
                    ) AS x
                    LEFT JOIN pembelajar p  ON p.created_by = x.user_id AND SUBSTR(created_at,1,10) BETWEEN x.start_week AND x.end_week
                    GROUP BY x.user_id, x.week_number
                ) xx GROUP BY xx.user_id";
        return $this->db->query($query)->result();
    }
}
