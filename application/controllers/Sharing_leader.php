<?php
// Trusmi History Lock Absen
// Created At : 12-05-2023
defined('BASEPATH') or exit('No direct script access allowed');
class Sharing_leader extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_sharing_leader', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $data['masa_kerja'] = $this->db->query("SELECT COALESCE(DATEDIFF(CURRENT_DATE,e.date_of_joining),0) AS masa_kerja FROM xin_employees e WHERE e.user_id = '$user_id'")->row();
        $data['pageTitle'] = "Sharing Leader";
        $data['css'] = "sharing_leader/css";
        $data['js'] = "sharing_leader/js";
        $data['content'] = "sharing_leader/index";
        $data['peserta'] = $this->model->get_peserta();
        $data['project'] = $this->db->query("SELECT divisi AS project, divisi AS id_project FROM `grd_m_so` GROUP BY divisi")->result();

        $this->load->view('layout/main', $data);
    }

    function dt_sharing_leader()
    {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $data['data'] = $this->model->dt_sharing_leader($start, $end);
        echo json_encode($data);
    }

    public function get_klasifikasi()
    {
        $data = $this->model->get_klasifikasi();
        echo json_encode($data);
    }

    public function check_link()
    {
        $link = $_POST['link'];
        $cek = $this->db->query("SELECT COUNT(id) AS count FROM pembelajar WHERE link = '$link'")->row();
        $data['count'] = $cek->count;
        echo json_encode($data);
    }

    public function save_sharing_leader()
    {
        $response = [];

        $namaFileMateri = '';

        // CEK FILE WAJIB UPLOAD
        if (!isset($_FILES['file_materi']) || $_FILES['file_materi']['error'] != 0) {
            $response['status'] = 'error';
            $response['message'] = 'File materi wajib diupload!';
            echo json_encode($response);
            return;
        }

        $uploadPath = './uploads/sharing_leader/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, TRUE);
        }

        $config['upload_path']   = $uploadPath;
        $config['allowed_types'] = 'pdf|doc|docx|ppt|pptx|xls|xlsx|jpg|png';
        $config['max_size']      = 0;
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('file_materi')) {
            $uploadData = $this->upload->data();
            $namaFileMateri = $uploadData['file_name'];
        } else {
            // AMBIL ERROR DARI CI UPLOAD
            $response['status'] = 'error';
            $response['message'] = strip_tags($this->upload->display_errors());
            echo json_encode($response);
            return;
        }

        // ------------------ INSERT DATABASE ------------------
        $baseData = [
            'id_sl' => $this->model->generate_id_sharing_leader(),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $_SESSION['user_id'],
            'designation' => $_SESSION['designation_id'],
            'judul' => trim($this->input->post('judul')),
            'klasifikasi' => $this->input->post('klasifikasi'),
            'impact' => trim($this->input->post('impact')),
            'lampiran' => trim($this->input->post('lampiran')),
            'file_materi' => $namaFileMateri,
            'peserta' => isset($_POST['peserta']) ? implode(',', $_POST['peserta']) : ''
        ];

        if (isset($_POST['addition'])) {
            $additionalData = [
                "divisi" => $this->input->post('id_project'),
                "so" => $this->input->post('id_pekerjaan') ?? '',
                "si" => $this->input->post('id_sub_pekerjaan') ?? '',
                "tasklist" => isset($_POST['id_detail_pekerjaan']) ? implode(',', $_POST['id_detail_pekerjaan']) : ''
            ];
            $data = array_merge($baseData, $additionalData);
        } else {
            $data = $baseData;
        }

        $insertStatus = $this->db->insert('t_sharing_leader', $data);

        $response['status'] = 'success';
        $response['message'] = 'Data berhasil disimpan!';
        $response['insert'] = $insertStatus;

        echo json_encode($response);
    }

    function dt_resume_sharing_leader()
    {
        $periode = $_POST['periode'];
        $data['data'] = $this->model->dt_resume_sharing_leader($periode);
        echo json_encode($data);
    }


    function upload_lampiran()
    {
        if (!empty($_FILES)) {
            $uploadDir = './uploads/sharing_leader/';
            $fileName = basename($_FILES['file']['name']);
            $uploadFilePath = $uploadDir . $fileName;

            //upload file to server
            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath)) {
                $data['data'] = $fileName;
                $data['size'] = $_FILES['file']['size'];
                $data['ext'] = pathinfo($fileName, PATHINFO_EXTENSION);
            } else {
                $data['data'] = $_FILES["file"]["error"];
            }
        } else {
            $data['data'] = $_FILES["file"]["error"];
        }

        echo json_encode($data);
    }

    function delete_lampiran()
    {
        $uploadDir = './uploads/sharing_leader/';
        $fileName = $uploadDir . $_POST['name'];
        $remove = unlink($fileName);
        $data['filename'] = $fileName;
        $data['remove'] = $remove;
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
                            AND e.is_active = 1) OR e.user_id IN (1633, 1448, 2987, 1272, 2675, 2525, 2506, 2396, 1426, 1483, 2529, 1568, 2547, 2399, 68, 78, 1139, 1784, 2069, 2521, 2535, 476 116, 118, 454, 573, 637, 638, 998, 1013, 1212, 1294, 1299, 1563, 1721, 1733, 1844, 2108, 3648, 3961, 4201, 77, 5624, 5777, 5796)
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
                    -- COUNT(IF(xx.input = 1 AND xx.w = '1',1,NULL)) AS w1, 
                    -- SUM(IF(xx.w = '1',COALESCE(xx.input,0),0)) AS input_w1,
                    -- COUNT(IF(xx.input >= 1 AND xx.w = '2',1,NULL)) AS w2, 
                    -- SUM(IF(xx.w = '2',COALESCE(xx.input,0),0)) AS input_w2,
                    -- COUNT(IF(xx.input >= 1 AND xx.w = '3',1,NULL)) AS w3, 
                    -- SUM(IF(xx.w = '3',COALESCE(xx.input,0),0)) AS input_w3,
                    -- COUNT(IF(xx.input >= 1 AND xx.w = '4',1,NULL)) AS w4, 
                    -- SUM(IF(xx.w = '4',COALESCE(xx.input,0),0)) AS input_w4,
                    -- COUNT(IF(xx.input >= 1 AND xx.w = '5',1,NULL)) AS w5, 
                    -- SUM(IF(xx.w = '5',COALESCE(xx.input,0),0)) AS input_w5,
                    -- COUNT(IF(xx.input >= 1 AND xx.w = '6',1,NULL)) AS w6,
                    -- SUM(IF(xx.w = '6',COALESCE(xx.input,0),0)) AS input_w6,
                    xx.company_name,
                    xx.jabatan
                FROM(
                    SELECT 
                                            tm.user_id, 
                                            tm.employee_name, 
                                            tm.company_name, 
                                            tm.jabatan, 
                                            th.w, 
                                            th.tgl_awal, 
                                            th.tgl_akhir, 
                                            SUM(IF(th.w IS NOT NULL,1,0)) AS input 
                                        FROM
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
                    WHERE (e.company_id = 2 
                    -- AND e.user_role_id IN (2,3,4,5) 
                    AND ur.level_sto >= 4 
                    AND DATEDIFF(CURRENT_DATE,e.date_of_joining) > 30
                    AND e.is_active = 1) OR e.user_id IN (1,1633,1448,2987,1272,2675,2525,2506,2396,1426,1483,2529,1568,2547,2399,68,78,1139,1784,2069,2521,2535,476,116,118,454,573,637,638,998,1013,1212,1294,1299,1563,1721,1733,1844,2108,3648,3961,4201,77,321,2733,1369,2127,61,64,1161,1287,5624, 5777, 5796)
                    ) AS tm
                    LEFT JOIN t_sharing_leader p ON p.created_by = tm.user_id
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
                ) xx GROUP BY xx.user_id";
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
                    AND e.is_active = 1) OR e.user_id IN (1633, 1448, 2987, 1272, 2675, 2525, 2506, 2396, 1426, 1483, 2529, 1568, 2547, 2399, 68,78,1139,1784,2069,2521,2535)
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
                            AND e.is_active = 1) OR e.user_id IN (1633, 1448, 2987, 1272, 2675, 2525, 2506, 2396, 1426, 1483, 2529, 1568, 2547, 2399, 68,78,1139,1784,2069,2521)
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

    function get_pekerjaan()
    {
        $divisi = $_POST['id_project'];
        // $data = $this->db->get_where('grd_m_so')->result();
        $query = "SELECT
        grd_m_so.id_so AS id,
        grd_m_so.so AS pekerjaan,
        CONCAT(' | ',grd_m_goal.nama_goal, ' | ',DATE_FORMAT( grd_m_so.created_at, '%b %Y' )) AS periode
    FROM
        `grd_m_so` 
        JOIN grd_m_goal ON grd_m_so.id_goal = grd_m_goal.id_goal
    WHERE
        grd_m_so.divisi = '$divisi'";
        $data = $this->db->query($query)->result();
        echo json_encode($data);
    }

    // sub pekerjaan / SI
    function get_sub_pekerjaan()
    {
        $pekerjaan = $_POST['id_pekerjaan'];
        $query = "SELECT id_si AS id, si AS sub_pekerjaan FROM `grd_t_si` WHERE id_so =  $pekerjaan";
        // $data = $this->db->get_where('m_sub_pekerjaan', ['id_pekerjaan' => $pekerjaan])->result();
        $data = $this->db->query($query)->result();
        echo json_encode($data);
    }

    // Detail pekerjaan / tasklist
    function get_det_pekerjaan()
    {
        $id_sub_pekerjaan = $_POST['id_sub_pekerjaan'];
        $query = "SELECT id_tasklist AS id, detail FROM `grd_t_tasklist` WHERE id_si = $id_sub_pekerjaan";
        $data = $this->db->query($query)->result();
        // $data = $this->db->query('t_detail_pekerjaan', ['id_sub_pekerjaan' => $id_sub_pekerjaan])->result();

        echo json_encode($data);
    }
}
