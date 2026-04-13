<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Grd_fuji extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library("session");
        // $this->load->library('Whatsapp_lib');
        $this->load->database();
        $this->load->model('grd/bt/Model_grd_fuji', 'model');
        $this->load->model('grd/bt/Model_grd_manpower', 'model_manpower');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {

        $divisi = $this->input->post('divisi');
        $month   = $this->input->post('month');

        $data['pageTitle']  = "Dashboard GRD";
        $data['css']        = "grd/bt/css";
        $data['js']         = "grd/bt/js";
        $data['content']    = "grd/bt/grd";

        $data['status'] = $this->model->get_status();

        $data['goals']      = $this->model->data_goal($divisi, $month);

        $this->load->view('layout/main', $data);
    }

    public function get_company()
    {
        $data = $this->db->query("SELECT company_id, `name` FROM xin_companies ORDER BY `name`")->result();
        echo json_encode($data);
    }

    public function goal_pic()
    {
        $id_divisi = $this->input->post('id_divisi');

        if (strpos($id_divisi, 'all') !== false) {
            // do something
            $cond = "";
        } else {
            $cond = "AND e.divisi_id IN ($id_divisi)";
        }

        $data = [
            'goals'=>$this->db->query("SELECT 
                            id_goal, `nama_goal` 
                        FROM grd_m_goal 
                        WHERE `divisi` = '$id_divisi'
                        ORDER BY nama_goal")
                          ->result(),
            'pic'=>$this->db->query("SELECT
                    e.user_id,
                    CONCAT(e.first_name,' ',e.last_name, ' - ', ds.designation_name) AS pic_name 
                    FROM `xin_employees` e 
                    LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
                    WHERE e.user_id != 1 AND e.is_active = 1 
                    -- $cond 
                    AND e.user_role_id IN (3,4,5,6) AND e.company_id IN (5)
                    ORDER BY CONCAT(e.first_name,' ',e.last_name)")
                    ->result()
        ];
        echo json_encode($data);
    }

    public function get_so_by_goal()
    {
        $id_goal = $this->input->post('id_goal');

        $data = $this->db->query("SELECT 
                                    id_so, `so` 
                                FROM grd_m_so 
                                WHERE `id_goal` = '$id_goal'
                                ORDER BY so")
                ->result();
        echo json_encode($data);
    }

    public function get_si_by_so()
    {
        $id_so = $this->input->post('id_so');

        $data = $this->db->query("SELECT 
                                    id_si, `si` 
                                FROM grd_t_si 
                                WHERE `id_so` = '$id_so'
                                ORDER BY si")
                ->result();
        echo json_encode($data);
    }

    public function save_task()
    {
        $divisi = $this->input->post('divisi') ?? '';
        $id_si = $this->input->post('id_si') ?? '';
        $id_pic = $this->input->post('id_pic') ?? '';
        $start = $this->input->post('start') ?? '';
        $end = $this->input->post('end') ?? '';
        $detail = $this->input->post('detail') ?? '';
        $output = $this->input->post('output') ?? '';
        $target = $this->input->post('target') ?? '';
        $id_status = 1;


        $data = [
            'divisi' => $divisi,
            'id_si' => $id_si,
            'pic' => $id_pic,
            'start' => $start,
            'end' => $end,
            'detail' => $detail,
            'output' => $output,
            'target' => $target,
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $this->session->userdata('user_id'),
            'status' => $id_status,
        ];
        $save_task = $this->db->insert('grd_t_tasklist', $data);

        $id_tasklist = $this->db->insert_id();

        $data_history = [
            'id_tasklist' => $id_tasklist,
            'progress' => 0,
            'status' => $id_status,
            'status_before' => $id_status,
            'note' => 'Tasklist Created',
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id')
        ];
        $save_history = $this->db->insert('grd_t_tasklist_history', $data_history);

        $response['id_si']    = $id_si;
        $response['save_task']  = $save_task;
        echo json_encode($response);
    }

    public function milestone_pic()
    {
        $id_company = $this->input->post('id_company');

        if (strpos($id_company, 'all') !== false) {
            // do something
            $cond = "";
        } else {
            $cond = "AND e.company_id IN ($id_company)";
        }

        $data = [
            'milestone'=>$this->db->query("SELECT 
                                            id, `milestone` 
                                    FROM grd_m_milestone 
                                    WHERE `id_company` = '$id_company'
                                    ORDER BY milestone")
                          ->result(),
            'pic'=>$this->db->query("SELECT
                    e.user_id,
                    CONCAT(e.first_name,' ',e.last_name, ' - ', ds.designation_name) AS pic_name 
                    FROM `xin_employees` e 
                    LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
                    WHERE e.user_id != 1 AND e.is_active = 1 
                    -- $cond 
                    AND e.user_role_id IN (3,4,5,6) AND e.company_id IN (5)
                    ORDER BY CONCAT(e.first_name,' ',e.last_name)")
                    ->result()
        ];
        echo json_encode($data);
    }

    public function save_task_milestone()
    {
        $divisi = $this->input->post('divisi') ?? '';
        $id_milestone = $this->input->post('id_milestone') ?? '';
        $id_pic = $this->input->post('id_pic') ?? '';
        $start = $this->input->post('start') ?? '';
        $end = $this->input->post('end') ?? '';
        $detail = $this->input->post('detail') ?? '';
        $output = $this->input->post('output') ?? '';
        $target = $this->input->post('target') ?? '';
        $id_status = 1;


        $data = [
            'divisi' => $divisi,
            'id_milestone' => $id_milestone,
            'pic' => $id_pic,
            'start' => $start,
            'end' => $end,
            'detail' => $detail,
            'output' => $output,
            'target' => $target,
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $this->session->userdata('user_id'),
            'status' => $id_status,
        ];
        $save_task = $this->db->insert('grd_t_tasklist_milestone', $data);

        $id_tasklist = $this->db->insert_id();

        $data_history = [
            'id_tasklist' => $id_tasklist,
            'progress' => 0,
            'status' => $id_status,
            'status_before' => $id_status,
            'note' => 'Tasklist Created',
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id')
        ];
        $save_history = $this->db->insert('grd_t_tasklist_milestone_history', $data_history);

        $response['id_milestone']    = $id_milestone;
        $response['save_task']  = $save_task;
        echo json_encode($response);
    }

    public function get_detail_milestone()
    {
        $id_milestone = $this->input->post('id_milestone');

        $data = [
            'header' => $this->model->get_header_milestone($id_milestone),
            'tasklist' => $this->model->get_tasklist_milestone($id_milestone),
        ];

        echo json_encode($data);
    }

    public function update_milestone()
    {
        $id_milestone = $this->input->post('t_id_milestone');
        $actual = $this->input->post('actual');
        $target = $this->input->post('t_target');


        $data = [
            'actual' => $actual,
            'progress' => ($actual/$target) * 100
        ];

        $this->db->where('id', $id_milestone);
        $hasil = $this->db->update('grd_m_milestone', $data);

        // $data_history = [
        //     'id_tasklist' => $id_tasklist,
        //     'progress' => $this->input->post('actual'),
        //     'status' => $this->input->post('status'),
        //     'status_before' => $this->input->post('status_before'),
        //     'note' => $this->input->post('note'),
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'created_by' => $this->session->userdata('user_id'),

        // ];

        // $this->db->insert('grd_t_tasklist_history', $data_history);

        echo json_encode($hasil);
    }

    public function update_task_milestone()
    {
        $config['upload_path'] = 'uploads/grd/evidence/'; // Direktori untuk menyimpan file
        $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx'; // Tipe file yang diperbolehkan
        // $config['max_size'] = 2048; // Ukuran maksimal file dalam KB (2 MB)
        $this->load->library('upload', $config);

        $id_tasklist = $this->input->post('det_id_tasklist');

        // fuji start
        $actual = $this->input->post('actual');
        $actual_tipe = $this->input->post('actual_milestone_type');
        $target = $this->input->post('target_milestone');
        $target_tipe = $this->input->post('target_milestone_type');

        $actual_so_p = $this->hitungPencapaian($target, $actual, $actual_tipe, $target_tipe);
        // fuji end

        $data = [
            'status' => $this->input->post('status'),
            'actual' => $this->input->post('actual'),
            'note' => $this->input->post('note'),
        ];
        if ($this->input->post('status') == 3) {
            $data['done_at'] = date('Y-m-d H:i:s');
        }
        if (!empty($_FILES['evidence']['name'])) {
            $timestamp = time();
            $fileExtension = pathinfo($_FILES['evidence']['name'], PATHINFO_EXTENSION); // Ekstensi file
            $newFileName = $timestamp . '.' . $fileExtension; // Nama file baru dengan timestamp

            $config['file_name'] = $newFileName;
            $this->upload->initialize($config);

            if ($this->upload->do_upload('evidence')) {
                $uploadData = $this->upload->data();
                $data['evidence'] = $uploadData['file_name'];
            } else {
                echo $this->upload->display_errors();
                return;
            }
        }

        $this->db->where('id_tasklist', $id_tasklist);
        $hasil = $this->db->update('grd_t_tasklist_milestone', $data);

        $data_history = [
            'id_tasklist' => $id_tasklist,
            'progress' => $this->input->post('actual'),
            'status' => $this->input->post('status'),
            'status_before' => $this->input->post('status_before'),
            'note' => $this->input->post('note'),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id'),

        ];

        $this->db->insert('grd_t_tasklist_milestone_history', $data_history);

        echo json_encode($hasil);
    }

    public function reload()
    {

        $divisi = $this->input->post('divisi');
        $month   = $this->input->post('month');

        if ($this->input->is_ajax_request()) {
            $goals = $this->model->data_goal($divisi, $month);
            echo json_encode(['goals' => $goals]);
            exit;
        }
    }

    public function getMilestones()
    {
        $milestones = $this->db->query("SELECT 
                                                id,
                                                mile.milestone, 
                                                `start`, 
                                                `end`, 
                                                progress AS progress_old,
                                                CASE 
                                                        WHEN progress < 60 THEN 'FD97A4'
                                                        WHEN progress BETWEEN 60 AND 75 THEN 'FFE97B'
                                                ELSE 'BFEC78'
                                                END AS warna,
                                                COALESCE(SUM(prg.persen),0) AS progress
                                        FROM grd_m_milestone mile
                                        LEFT JOIN (
                                                SELECT
                                                        tm.id_tasklist,
                                                        tm.divisi,
                                                        tm.id_milestone,
                                                        m.milestone,
                                                        COALESCE(tm.target, 0),
                                                        COALESCE(tm.actual, 0) AS actual,
                                                        ROUND(COALESCE(tm.actual, 0)/COALESCE(tm.target, 0) * 100,0) AS persen
                                                FROM
                                                        grd_t_tasklist_milestone tm 
                                                LEFT JOIN grd_m_milestone m ON m.id = tm.id_milestone
                                        ) prg ON prg.id_milestone = mile.id

                                        GROUP BY mile.id
                                    ")
                                ->result();

        // Konversi tanggal ke format Y-m-d untuk JavaScript
        foreach ($milestones as &$m) {
            $m->start = date("Y-m-d", strtotime($m->start));
            $m->end = date("Y-m-d", strtotime($m->end));
        }

        echo json_encode($milestones);
    }

    public function get_milestone_task()
    {
        $id_tasklist = $this->input->post('id_tasklist');
        $data = [
            'header' => $this->model->get_tasklist($id_tasklist),
        ];

        echo json_encode($data);
    }


    public function data_grd()
    {
        // $divisi = $this->input->post('divisi');
        $divisi = "Operasional";
        // $month   = $this->input->post('month');
        $month   ="01-2025";
        $data_goal   = $this->model->data_goal($divisi, $month);
        $data_so     = $this->model->data_so($divisi, $month);
        $data_si     = $this->model->data_si($divisi, $month);

        $data_tasklist     = $this->model->data_tasklist($divisi, $month);

        $result = [];

        foreach ($data_goal as $dt_goal) {
            // Filter so berdasarkan goal
            $get_goal_so = array_filter($data_so, function ($so) use ($dt_goal) {
                return $so->id_goal === $dt_goal->id_goal;
            });

            // Tambahkan get_si dan get_tasklist ke setiap so
            foreach ($get_goal_so as $main) {
                $main->data_si = array_values(array_filter($data_si, function ($si) use ($main) {
                    return $si->id_so === $main->id_so; // Kecocokan antara id_so di get_so dan id_so di so
                }));

                foreach ($main->data_si as $si) {
                    $si->tasklist = array_values(array_filter($data_tasklist, function ($tasklist) use ($si) {
                        return $tasklist->id_si === $si->id_si; // Kecocokan antara id_si di get_si dan id_si di tasklist
                    }));
                }
            }

            // CHART PROGRESS SO
            $total_progress_so = array_sum(array_column($get_goal_so, 'progress_so_satuan'));
            $count_so = count($get_goal_so);
            $average_so = $count_so > 0 ? $total_progress_so / $count_so : 0;
            $dt_goal->average_so = round($average_so, 1);

            

            // Masukkan ke hasil dengan struktur goal
            $result[] = [
                'id_goal'       => $dt_goal->id_goal,
                'nama_goal'     => $dt_goal->nama_goal,
                'sos'           => array_values($get_goal_so),
                'target_goal'   => $dt_goal->target ?? 0,
                'actual_goal'   => $dt_goal->actual ?? 0,
                'progress_goal' => $dt_goal->prs ?? 0,
                // 'warna'         => $dt_goal->warna,

                'get_goal_so'         => $get_goal_so,
                'total_progress_so'         => $total_progress_so,
                'count_so'         => $count_so,


                'progress_so'   => min(100, $dt_goal->average_so) ?? 0,
                'progress_si'   => min(100, $dt_goal->progress_si) ?? 0,
                'progress_tasklist'   => min(100, $dt_goal->progress_tasklist) ?? 0,
            ];
        }

        echo json_encode($result);
    }

    public function get_detail_task()
    {
        $id_tasklist = $this->input->post('id_tasklist');
        $id_si = $this->input->post('id_si');
        $id_so = $this->input->post('id_so');
        $divisi = $this->input->post('divisi');
        $month = $this->input->post('month');

        $data = [
            'header' => $this->model->get_header_detail($id_tasklist),
            // 'mom' => $this->model->get_detail_mom($id_tasklist, $id_si, $id_so, $divisi, $month),
            // 'ibr' => $this->model->get_detail_ibr($id_tasklist, $id_si, $id_so, $divisi, $month),
            // 'genba' => $this->model->get_detail_genba($id_tasklist, $id_si, $id_so, $divisi, $month),
            // 'conco' => $this->model->get_detail_conco($id_tasklist, $id_si, $id_so, $divisi, $month),
            // 'complaint' => $this->model->get_detail_comp($id_tasklist, $id_si, $id_so, $divisi, $month),
            // 'teamtalk' => $this->model->get_detail_teamtalk($id_tasklist, $id_si, $id_so, $divisi, $month),
        ];

        echo json_encode($data);
    }

    public function update_task()
    {
        $config['upload_path'] = 'uploads/grd/evidence/'; // Direktori untuk menyimpan file
        $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx'; // Tipe file yang diperbolehkan
        // $config['max_size'] = 2048; // Ukuran maksimal file dalam KB (2 MB)
        $this->load->library('upload', $config);
        $id_tasklist = $this->input->post('id_tasklist');

        // fuji start
        // $target = $this->input->post('target');
        // $actual = $this->input->post('actual');
        // $target_tipe = $this->input->post('target_tipe');
        // $actual_tipe = $this->input->post('actual_tipe');

        // $actual_so_p = $this->hitungPencapaian($target, $actual, $actual_tipe, $target_tipe);
        // fuji end


        $data = [
            'status' => $this->input->post('status'),
            'actual' => $this->input->post('actual'),
            // 'actual_so_p' => $actual_so_p,

            'note' => $this->input->post('note'),
        ];
        if ($this->input->post('status') == 3) {
            $data['done_at'] = date('Y-m-d H:i:s');
        }
        if (!empty($_FILES['evidence']['name'])) {
            $timestamp = time();
            $fileExtension = pathinfo($_FILES['evidence']['name'], PATHINFO_EXTENSION); // Ekstensi file
            $newFileName = $timestamp . '.' . $fileExtension; // Nama file baru dengan timestamp

            $config['file_name'] = $newFileName;
            $this->upload->initialize($config);

            if ($this->upload->do_upload('evidence')) {
                $uploadData = $this->upload->data();
                $data['evidence'] = $uploadData['file_name'];
            } else {
                echo $this->upload->display_errors();
                return;
            }
        }

        $this->db->where('id_tasklist', $id_tasklist);
        $hasil = $this->db->update('grd_t_tasklist', $data);

        $data_history = [
            'id_tasklist' => $id_tasklist,
            'progress' => $this->input->post('actual'),
            'status' => $this->input->post('status'),
            'status_before' => $this->input->post('status_before'),
            'note' => $this->input->post('note'),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id'),

        ];

        $this->db->insert('grd_t_tasklist_history', $data_history);

        echo json_encode($hasil);
    }
    
    public function load_all_tab()
    {
        $id = $this->input->post('id_tasklist');
        $data = [
            'history' => $this->model->get_history($id),
            'file' => $this->model->get_file($id)
        ];
        echo json_encode($data);
    }

    public function load_all_tab_det()
    {
        $id = $this->input->post('id_tasklist');
        $data = [
            'history' => $this->model->get_history_det($id),
            'file' => $this->model->get_file_det($id)
        ];
        echo json_encode($data);
    }


    // content 2
    public function data_poin_check_bt()
    {
        $month  = $this->input->post('month');

        $data = [
            'bt' => $this->model->data_poin_check_bt($month)
        ];

        echo json_encode($data);
    }

    public function data_persen_bt()
    {
        $month  = $this->input->post('month');

        $data = [
            'prs_bt' => $this->model->data_persen_bt($month)
        ];

        echo json_encode($data);
    }

    public function data_support(){
        $month = $this->input->post('month');
        // var_dump($month);die();
        $data = $this->model_manpower->get_support($month);
        echo json_encode($data);
    }

    public function data_warning_manpower(){
        $month = $this->input->post('month');
        $data = [
            'header'=>$this->model_manpower->get_warning_manpower($month),
            'kehadiran'=>$this->model_manpower->get_warning_manpower_kehadiran($month),
            'task_undone'=>$this->model_manpower->get_warning_manpower_undone($month),
            'detail'=>$this->model_manpower->get_warning_manpower_detail($month),
        ];
        echo json_encode($data);

    }

    public function data_persen_bt_budget(){
        // $month = $this->input->post('month');
        $periode  = $this->input->post('month');

        $tahun = substr($periode, 0, 4); 
        $bulan = substr($periode, 5, 2); 

        $data = [
            'prs_bt_budget' => $this->model->get_budget_vs_actual($tahun, $bulan)
        ];

        echo json_encode($data);

    }

    public function kanban_data()
    {
        if (isset($_POST['divisi'])) {
            $divisi = $_POST['divisi'];
        } else {
            $divisi = null;
        }

        $month = $_POST['month'];
        $user_id = $this->session->userdata('user_id');

        $kanban_data = $this->model->kanban_data($divisi, $month);
        $myData = [];
        foreach ($kanban_data as $key => $value) {

            $myObject = [
                'id_task' => $value->id_task,
                'type' => $value->type,
                'task' => $value->task,
                'description' => $value->description,
                'id_pic' => $value->id_pic,
                'pic' => $value->pic,
                'profile_picture' => $value->profile_picture,
                'id_status' => $value->id_status,
                'status' => $value->status,
                'status_color' => $value->status_color,
                'progress' => $value->progress,
                'start' => $value->start,
                'end' => $value->end,
                'note' => $value->note,
                'created_at' => $value->created_at,
                'created_by' => $value->created_by,
                'attachment' => $value->attachment,
            ];

            $myData[] = $myObject;
        }

        $response['kanban'] = $myData;
        $response['user_id'] = $user_id;

        echo json_encode($response);
    }

    function hitungPencapaianTest(){
       
        $jsonInput = '{
            "data": [
                    {"id": 1, "target": 10000, "actual": 10000, "tipe": "up", "cat": "nominal", "harusnya": 100},
                    {"id": 1, "target": 10000, "actual": 5000, "tipe": "up", "cat": "nominal", "harusnya": 50},
                    {"id": 1, "target": 10000, "actual": 20000, "tipe": "up", "cat": "nominal", "harusnya": 100},
                    {"id": 1, "target": 10000, "actual": 0, "tipe": "up", "cat": "nominal", "harusnya": 0},


                    {"id": 2, "target": 10000, "actual": 10000, "tipe": "down", "cat": "nominal", "harusnya": 100},
                    {"id": 2, "target": 10000, "actual": 15000, "tipe": "down", "cat": "nominal", "harusnya": 50},
                    {"id": 2, "target": 10000, "actual": 0, "tipe": "down", "cat": "nominal", "harusnya": 100},
                    {"id": 2, "target": 10000, "actual": 20000, "tipe": "down", "cat": "nominal", "harusnya": 0},

                    
                    
                    {"id": 3, "target": 100, "actual": 100, "tipe": "up", "cat": "persen", "harusnya": 100},
                    {"id": 3, "target": 100, "actual": 50, "tipe": "up", "cat": "persen", "harusnya": 50},
                    {"id": 3, "target": 100, "actual": 200, "tipe": "up", "cat": "persen", "harusnya": 100},
                    {"id": 3, "target": 100, "actual": 0, "tipe": "up", "cat": "persen", "harusnya": 0},

                    {"id":4, "target": 100, "actual": 100, "tipe": "down", "cat": "persen", "harusnya": 100},
                    {"id":4, "target": 100, "actual": 150, "tipe": "down", "cat": "persen", "harusnya": 50},
                    {"id":4, "target": 100, "actual": 0, "tipe": "down", "cat": "persen", "harusnya": 100},
                    {"id":4, "target": 100, "actual": 200, "tipe": "down", "cat": "persen", "harusnya": 0}


            ]
        }';
        $dataArray = json_decode($jsonInput, true);

        // Periksa apakah data valid
        if (!isset($dataArray['data']) || !is_array($dataArray['data'])) {
            echo json_encode(["error" => "Invalid JSON input"]);
            exit;
        }

        $hasil = [];        
        foreach ($dataArray['data'] as $row) {
            $id = $row['id'];
            $target = $row['target'];
            $actual = $row['actual'];
            $tipe = $row['tipe'];
            $cat = $row['cat'];
            $harusnya = $row['harusnya'];
        
            $pencapaian_fix = $this->hitungPencapaian($target, $actual, $tipe, $cat);
        
            $hasil[] = [
                'id' => $id,
                'target' => $target,
                'actual' => $actual,
                'tipe' => $tipe,
                'cat' => $cat,
                'pencapaian_fix' => $pencapaian_fix,
                'harusnya' => $harusnya,
                'status' => ($pencapaian_fix == $harusnya) ? 'benar' : 'salah'


            ];
        }
        
        // Output hasil sebagai JSON
        echo json_encode(["hasil" => $hasil], JSON_PRETTY_PRINT);

    }

    function hitungPencapaian($target, $actual, $actual_tipe, $target_tipe) {
        if( $target_tipe == 'persen' && $actual_tipe == 'up'){
            if($actual > 100){
              $actual = 100;
            } else if ($actual < 0){
              $actual = 0;
            } else {
              $actual = $actual;
            }
        }
        
        if ($actual_tipe === 'up') {
            $pencapaian = round(($actual / $target) * 100);
        } elseif ($actual_tipe === 'down') {
            $pencapaian = round(max(0, 100 - (($actual - $target) / $target) * 100));
        } else {
            return 'x';
        }
    
        // Pastikan nilai di antara 0 - 100
        return min(100, max(0, $pencapaian));
    }
   
}
