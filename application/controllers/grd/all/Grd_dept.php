<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Grd_dept extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library("session");
        // $this->load->library('Whatsapp_lib');
        $this->load->database();
        $this->load->model('grd/all/Model_grd_dept', 'model');
        $this->load->model('grd/all/Model_grd_manpower', 'model_manpower');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {

        $data['pageTitle']  = "Dashboard GRD by Company";
        $data['css']        = "grd/all_dept/css";
        $data['js']         = "grd/all_dept/js";
        $data['content']    = "grd/all_dept/grd";

        $data['status'] = $this->model->get_status();

        // Untuk Bedakan per Company
        $data['id_company'] = (empty($_GET['id'])) ? 0 : $_GET['id'];

        if($data['id_company'] == 0){
            $data['company_name'] = "No Company";
        }else{
            $data['company_name'] = $this->db->query("SELECT `name` FROM xin_companies WHERE company_id = $data[id_company] LIMIT 1")->row()->name;
        }

        $data['divisi'] = $this->model->get_divisi($data['id_company']);
        $data['divisi_select'] = (empty($_GET['divisi'])) ? 0 : $_GET['divisi'];


        // $data['pic_edit']	= $this->model->get_pic_edit();
        $data['pic_edit']	= $this->model->get_pic_edit($data['id_company']);


        $divisi = $this->input->post('divisi');
        $start   = $this->input->post('start');
        $end   = $this->input->post('end');
  
        $data['goals']  = $this->model->data_goal($divisi, $start, $end);

        $this->load->view('layout/main', $data);
    }

    public function index_dev()
    {

       

        // $data['status'] = $this->model->get_status();

        // Untuk Bedakan per Company
        $data['id_company'] = (empty($_GET['id'])) ? 0 : $_GET['id'];

        if($data['id_company'] == 0){
            $data['company_name'] = "No Company";
        }else{
            $data['company_name'] = $this->db->query("SELECT `name` FROM xin_companies WHERE company_id = $data[id_company] LIMIT 1")->row()->name;
        }

        // $data['divisi'] = $this->model->get_divisi($data['id_company']);
        // $data['divisi_select'] = (empty($_GET['divisi'])) ? 0 : $_GET['divisi'];


        // $data['pic_edit']	= $this->model->get_pic_edit($data['id_company']);


        // $divisi = 'Soft Launch';
        $divisi = 'Marketing Communication';
        $start   = '2025-06-01';
        $end   = '2025-06-30';
  
        $data['goals']  = $this->model->data_goal($divisi, $start, $end);
        $goals  = $this->model->data_goal($divisi, $start, $end);

        echo json_encode ($data);

    }

    public function get_company()
    {
        $id_divisi = $this->input->post('id_divisi');
        $id_company = $this->input->post('id_company');
        $data = $this->db->query("SELECT company_id, `name` FROM xin_companies WHERE company_id = $id_company ORDER BY `name`")->result();
        echo json_encode($data);
    }

    public function goal_pic()
    {
        $id_divisi = $this->input->post('id_divisi');
        $id_company = $this->input->post('id_company');

        if (strpos($id_divisi, 'all') !== false) {
            // do something
            $cond = "";
        } else {
            $cond = "AND e.divisi_id IN ($id_divisi)";
        }

        // Batik Group
        if ($id_company == 5) {
            $kondisi = "AND (e.company_id IN (5) OR (e.company_id IN (1) AND e.department_id = 10))";
        } else {
            $kondisi = "AND e.company_id = $id_company";
        }

        $data = [
            'goals' => $this->db->query("SELECT 
                            id_goal, `nama_goal`,DATE_FORMAT(created_at, '%b %Y') AS periode 
                        FROM grd_m_goal 
                        WHERE `divisi` = '$id_divisi'
                        AND DATE_FORMAT(enddate, '%Y-%m') =  DATE_FORMAT(CURRENT_DATE, '%Y-%m')
                        ORDER BY nama_goal")
                ->result(),
            'pic' => $this->db->query("SELECT
                    e.user_id,
                    CONCAT(e.first_name,' ',e.last_name, ' - ', ds.designation_name) AS pic_name 
                    FROM `xin_employees` e 
                    LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
                    WHERE e.user_id != 1 AND e.is_active = 1 
                    $kondisi
                    ORDER BY CONCAT(e.first_name,' ',e.last_name)")
                ->result()
        ];
        echo json_encode($data);
    }

    public function get_so_by_goal()
    {
        $id_goal = $this->input->post('id_goal');

        $data = $this->db->query("SELECT 
                                    id_so, `so`, DATE_FORMAT(created_at, '%b %Y') AS periode 
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
        $jenis = $this->input->post('id_jenis') ?? '';

        $tasklist_target_batas = $this->input->post('tasklist_target_batas') ?? 'up';


        $week = $this->input->post('week') ?? '';
        $start = $this->input->post('start') ?? '';
        $end = $this->input->post('end') ?? '';
        $id_status = 1;
        if ($jenis == 'Weekly') {
            $save_task = [];
            $detail = json_decode($this->input->post('detail'), true);
            $output = json_decode($this->input->post('output'), true);
            // $target = json_decode($this->input->post('target'), true);
            $target = round((float) str_replace(',', '.', str_replace('.', '', json_decode($this->input->post('target'), true) ?? '')),2);

            $date = date_create($start);
            for ($i=0; $i < $week; $i++) { 
                $start_date = $date->format('Y-m-d');
                $date->modify('+1 week -1 day');
                $end_date = $date->format('Y-m-d');
                $date->modify('+1 day');
                
                $data = [
                    'divisi' => $divisi,
                    'id_si' => $id_si,
                    'pic' => $id_pic,
                    'jenis_tasklist' => $jenis,
                    'target_tasklist_type' => $tasklist_target_batas,
                    'start' => $start_date,
                    'end' => $end_date,
                    'detail' => $detail[$i],
                    'output' => $output[$i],
                    'target' => $target[$i],
                    'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => $this->session->userdata('user_id'),
                    'status' => $id_status,
                ];
                $save_task[] = $this->db->insert('grd_t_tasklist', $data);
        
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
            }
            $response['id_si']    = $id_si;
            $response['save_task']  = $save_task;
            echo json_encode($response);
        }else{
            $detail = $this->input->post('detail') ?? '';
            $output = $this->input->post('output') ?? '';
            $target = $this->input->post('target') ?? '';
    
            $data = [
                'divisi' => $divisi,
                'id_si' => $id_si,
                'pic' => $id_pic,
                'jenis_tasklist' => $jenis,
                'target_tasklist_type' => $tasklist_target_batas,
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

    }

    public function milestone_pic()
    {
        $id_company = $this->input->post('id_company');

        // Batik Group
        if ($id_company == 5) {
            $kondisi = "AND (e.company_id IN (5) OR (e.company_id IN (1) AND e.department_id = 10))";
        } else {
            $kondisi = "AND e.company_id = $id_company";
        }

        $data = [
            'milestone' => $this->db->query("SELECT 
                                            id, `milestone` 
                                    FROM grd_m_milestone 
                                    WHERE `id_company` = '$id_company'
                                    ORDER BY milestone")
                ->result(),
            'pic' => $this->db->query("SELECT
                    e.user_id,
                    CONCAT(e.first_name,' ',e.last_name, ' - ', ds.designation_name) AS pic_name 
                    FROM `xin_employees` e 
                    LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
                    WHERE e.user_id != 1 AND e.is_active = 1 
                    $kondisi
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


        $milestone_target_batas = $this->input->post('detail') ?? 'up';

        $output = $this->input->post('output') ?? '';
        // $target = $this->input->post('target') ?? '';
        $target         = round((float) str_replace(',', '.', str_replace('.', '', $this->input->post('target') ?? '')),2);

        $id_status = 1;


        $data = [
            'divisi' => $divisi,
            'id_milestone' => $id_milestone,
            'pic' => $id_pic,
            'start' => $start,
            'end' => $end,
            'detail' => $detail,
            'actual_milestone_type' => $milestone_target_batas,

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
            'progress' => ($actual / $target) * 100
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

        $actual_p = $this->hitungPencapaian($target, $actual, $actual_tipe, $target_tipe);
        // fuji end

        $data = [
            'status' => $this->input->post('status'),
            'actual' => $this->input->post('actual'),
            'note' => $this->input->post('note'),
            'actual_milestone_p' => $actual_p,

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
        $hasil['grd_t_tasklist_milestone'] = $this->db->update('grd_t_tasklist_milestone', $data);

        $data_history = [
            'id_tasklist' => $id_tasklist,
            'progress' => $this->input->post('actual'),
            'status' => $this->input->post('status'),
            'status_before' => $this->input->post('status_before'),
            'note' => $this->input->post('note'),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id'),

        ];

        $hasil['grd_t_tasklist_milestone_history'] = $this->db->insert('grd_t_tasklist_milestone_history', $data_history);

        echo json_encode($hasil);
    }

    public function reload()
    {
        $divisi     = $this->input->post('divisi');
        // $month      = $this->input->post('month');
        $start      = $this->input->post('start');
        $end        = $this->input->post('end');

        if ($this->input->is_ajax_request()) {
            // $goals = $this->model->data_goal($divisi, $month, $start, $end);
            $goals = $this->model->data_goal($divisi, $start, $end);
            echo json_encode(['goals' => $goals]);
            exit;
        }
    }

    public function getMilestones($id_company)
    {
        $milestones = $this->db->query("SELECT
                                            id,
                                            mile.milestone,
                                            `start`,
                                            `end`,
                                            progress AS progress_old,
                                        CASE
                                                WHEN ROUND(
                                                    COALESCE ( SUM( prg.persen ), 0 ) / COALESCE ( COUNT( mile.id ), 0 )) < 70 THEN
                                                    'FD97A4' 
                                                    WHEN ROUND(
                                                    COALESCE ( SUM( prg.persen ), 0 ) / COALESCE ( COUNT( mile.id ), 0 )) BETWEEN 70 
                                                    AND 85 THEN
                                                        'FFE97B' ELSE 'BFEC78' 
                                                    END AS warna,
                                                    ROUND(
                                                    COALESCE ( SUM( prg.persen ), 0 ) / COALESCE ( COUNT( mile.id ), 0 )) AS progress 
                                                FROM
                                                    grd_m_milestone mile
                                                    LEFT JOIN (
                                                    SELECT
                                                        tm.id_tasklist,
                                                        tm.divisi,
                                                        tm.id_milestone,
                                                        m.milestone,
                                                        COALESCE ( tm.target, 0 ),
                                                        COALESCE ( tm.actual, 0 ) AS actual,
                                                        actual_milestone_p AS persen 
                                                    FROM
                                                        grd_t_tasklist_milestone tm
                                                        LEFT JOIN grd_m_milestone m ON m.id = tm.id_milestone 
                                                    ) prg ON prg.id_milestone = mile.id 
                                                WHERE
                                                    mile.id_company = $id_company
                                            GROUP BY
                                            mile.id")->result();

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
        $divisi     = $this->input->post('divisi');
        // $month      = $this->input->post('month');
        $start      = $this->input->post('start');
        $end        = $this->input->post('end');

        // $data_goal   = $this->model->data_goal($divisi, $month, $start, $end);
        // $data_so     = $this->model->data_so($divisi, $month, $start, $end);
        // $data_si     = $this->model->data_si($divisi, $month, $start, $end);
        // $data_tasklist     = $this->model->data_tasklist($divisi, $month, $start, $end);
        $data_goal   = $this->model->data_goal($divisi, $start, $end);
        $data_so     = $this->model->data_so($divisi, $start, $end);
        $data_si     = $this->model->data_si($divisi, $start, $end);
        $data_tasklist     = $this->model->data_tasklist($divisi, $start, $end);

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
                'warna'         => $dt_goal->warna,

                'total_progress_so'         => $total_progress_so,
                'count_so'         => $count_so,

                'progress_so'   => min(100, $dt_goal->average_so) ?? 0,
                'progress_si'   => min(100, $dt_goal->progress_si) ?? 0,
                'progress_si_tes'   => $dt_goal->progress_si,
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
        // $month = $this->input->post('month');
        $start = $this->input->post('start');
        $end = $this->input->post('end');

        $data = [
            'header' => $this->model->get_header_detail($id_tasklist),
            // 'mom' => $this->model->get_detail_mom($id_tasklist, $id_si, $id_so, $divisi, $month),
            // 'ibr' => $this->model->get_detail_ibr($id_tasklist, $id_si, $id_so, $divisi, $month),
            // 'genba' => $this->model->get_detail_genba($id_tasklist, $id_si, $id_so, $divisi, $month),
            // 'conco' => $this->model->get_detail_conco($id_tasklist, $id_si, $id_so, $divisi, $month),
            // 'complaint' => $this->model->get_detail_comp($id_tasklist, $id_si, $id_so, $divisi, $month),
            // 'teamtalk' => $this->model->get_detail_teamtalk($id_tasklist, $id_si, $id_so, $divisi, $month),
            'mom' => $this->model->get_detail_mom($id_tasklist, $id_si, $id_so, $divisi, $start, $end),
            'ibr' => $this->model->get_detail_ibr($id_tasklist, $id_si, $id_so, $divisi, $start, $end),
            'genba' => $this->model->get_detail_genba($id_tasklist, $id_si, $id_so, $divisi, $start, $end),
            'conco' => $this->model->get_detail_conco($id_tasklist, $id_si, $id_so, $divisi, $start, $end),
            'complaint' => $this->model->get_detail_comp($id_tasklist, $id_si, $id_so, $divisi, $start, $end),
            'teamtalk' => $this->model->get_detail_teamtalk($id_tasklist, $id_si, $id_so, $divisi, $start, $end),
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

        $actual         = round((float) str_replace(',', '.', str_replace('.', '', $this->input->post('actual') ?? '')),2);


        $data = [
            'status' => $this->input->post('status'),
            'actual' => $actual,
            'evidence_link' => $this->input->post('evidence_link'),
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

    // update SI by khael
    public function update_si()
    {
        $config['upload_path'] = 'uploads/grd/evidence/'; // Direktori untuk menyimpan file
        $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx'; // Tipe file yang diperbolehkan
        // $config['max_size'] = 2048; // Ukuran maksimal file dalam KB (2 MB)
        $this->load->library('upload', $config);
        $id_si = $this->input->post('id_si');

        $target = $this->input->post('target');

        // $actual = $this->input->post('actual');
        $actual         = round((float) str_replace(',', '.', str_replace('.', '', $this->input->post('actual') ?? '')),2);


        $actual_tipe = $this->input->post('actual_tipe');
        $target_tipe = $this->input->post('target_tipe');

        $actual_si_p = $this->hitungPencapaian($target, $actual, $actual_tipe, $target_tipe);


        $data = [
            'status' => $this->input->post('status'),
            'actual_si' => $this->input->post('actual'),
            'actual_si_p' => $actual_si_p,
            'note' => $this->input->post('note'),
            'evidence_link' => $this->input->post('evidence_link'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('user_id'),
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

        $this->db->where('id_si', $id_si);
        $hasil = $this->db->update('grd_t_si', $data);

        $data_history = [
            'id_tasklist' => $id_si,
            'progress' => $this->input->post('actual'),
            'status' => $this->input->post('status'),
            'status_before' => $this->input->post('status_before'),
            'note' => $this->input->post('note'),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id'),

        ];

        $this->db->insert('grd_t_si_history', $data_history);

        echo json_encode($hasil);
    }

    // update SI by khael
    public function update_so()
    {
        $config['upload_path'] = 'uploads/grd/evidence/'; // Direktori untuk menyimpan file
        $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx'; // Tipe file yang diperbolehkan
        // $config['max_size'] = 2048; // Ukuran maksimal file dalam KB (2 MB)
        $this->load->library('upload', $config);
        $id_so = $this->input->post('id_so');

        $target = $this->input->post('target');

        // $actual = $this->input->post('actual');
        $actual         = round((float) str_replace(',', '.', str_replace('.', '', $this->input->post('actual') ?? '')),2);


        $actual_tipe = $this->input->post('actual_tipe');
        $target_tipe = $this->input->post('target_tipe');

        $actual_so_p = $this->hitungPencapaian($target, $actual, $actual_tipe, $target_tipe);


        $data = [
            'status' => $this->input->post('status'),
            'actual_so' => $this->input->post('actual'),
            'actual_so_p' => $actual_so_p,
            'note' => $this->input->post('note'),
            'evidence_link' => $this->input->post('evidence_link'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('user_id'),
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

        $this->db->where('id_so', $id_so);
        $hasil = $this->db->update('grd_m_so', $data);

        $data_history = [
            'id_tasklist' => $id_so,
            'progress' => $this->input->post('actual'),
            'status' => $this->input->post('status'),
            'status_before' => $this->input->post('status_before'),
            'note' => $this->input->post('note'),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id'),

        ];

        $this->db->insert('grd_m_so_history', $data_history);

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
        // $month  = $this->input->post('month');
        $divisi = $this->input->post('divisi');
        $start  = $this->input->post('start');
        $end    = $this->input->post('end');

        $data = [
            // 'bt' => $this->model->data_poin_check_bt($month)
            'bt' => $this->model->data_poin_check_bt($divisi, $start, $end)
        ];

        echo json_encode($data);
    }

    public function data_persen_bt()
    {
        // $month  = $this->input->post('month');
        $divisi = $this->input->post('divisi');
        $start  = $this->input->post('start');
        $end    = $this->input->post('end');

        $data = [
            // 'prs_bt' => $this->model->data_persen_bt($month)
            'prs_bt' => $this->model->data_persen_bt($divisi, $start, $end)
        ];

        echo json_encode($data);
    }

    public function data_support()
    {
        // $month = $this->input->post('month');
        $divisi = $this->input->post('divisi');
        $start  = $this->input->post('start');
        $end    = $this->input->post('end');

        // var_dump($month);die();
        // $data = $this->model_manpower->get_support($month);
        $data = $this->model_manpower->get_support($divisi, $start, $end);
        echo json_encode($data);
    }

    public function data_warning_manpower()
    {
        // $month = $this->input->post('month');
        $start          = $this->input->post('start');
        $end            = $this->input->post('end');
        $id_company     = $this->input->post('id_company');
        $data = [
            'header' => $this->model_manpower->get_warning_manpower($start, $end, $id_company),
            'kehadiran' => $this->model_manpower->get_warning_manpower_kehadiran($start, $end, $id_company),
            'task_undone' => $this->model_manpower->get_warning_manpower_undone($start, $end, $id_company),
            'detail' => $this->model_manpower->get_warning_manpower_detail($start, $end, $id_company),
        ];
        echo json_encode($data);
    }

    public function data_persen_bt_budget()
    {

        if (isset($_POST['divisi'])) {
            $divisi = $_POST['divisi'];
        } else {
            $divisi = null;
        }


        // $month = $this->input->post('month');
        // $periode    = $this->input->post('month');
        $start      = $this->input->post('start');
        $end        = $this->input->post('end');

        // $tahun = substr($periode, 0, 4);
        // $bulan = substr($periode, 5, 2);

        $data = [
            // 'prs_bt_budget' => $this->model->get_budget_vs_actual($tahun, $bulan)
            'prs_bt_budget' => $this->model->get_budget_vs_actual($start, $end, $divisi)
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

        // $month = $_POST['month'];
        $start = $_POST['start'];
        $end = $_POST['end'];

        $user_id = $this->session->userdata('user_id');

        $kanban_data = $this->model->kanban_data($divisi, $start, $end);
        $myData = [];
        foreach ($kanban_data as $key => $value) {

            $myObject = [
                'id_task' => $value->id_task,
                'id_si' => $value->id_si,
                'id_so' => $value->id_so,
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

    function hitungPencapaianTest()
    {

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

    function hitungPencapaian($target, $actual, $actual_tipe, $target_tipe)
    {

        // Bersihkan dan ubah ke float
        $target = floatval(preg_replace('/[^\d.-]/', '', $target));
        $actual = floatval(preg_replace('/[^\d.-]/', '', $actual));


        if ($target_tipe == 'persentase' && $actual_tipe == 'up') {
            if ($actual > 100) {
                $actual = 100;
            } else if ($actual < 0) {
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

    // Get details data SI by khael
    public function get_detail_si()
    {
        $id_si = $this->input->post('id_si');
        $id_so = $this->input->post('id_so');
        $divisi = $this->input->post('divisi');
        $start = $this->input->post('start');
        $end = $this->input->post('end');

        // Note : parameter 0 untuk Bedakan bukan dari Tasklist tapi langsung dari SI
        $response = [
            'data' => $this->model->getDetailSi($id_si),            
            'mom' => $this->model->get_detail_mom(0, $id_si, $id_so, $divisi, $start, $end),
            'ibr' => $this->model->get_detail_ibr(0, $id_si, $id_so, $divisi, $start, $end),
            'genba' => $this->model->get_detail_genba(0, $id_si, $id_so, $divisi, $start, $end),
            'conco' => $this->model->get_detail_conco(0, $id_si, $id_so, $divisi, $start, $end),
            'complaint' => $this->model->get_detail_comp(0, $id_si, $id_so, $divisi, $start, $end),
            'teamtalk' => $this->model->get_detail_teamtalk(0, $id_si, $id_so, $divisi, $start, $end),
        ];

        echo json_encode($response);
    }

    // Get details data SO by khael
    public function get_detail_so()
    {
        $id_so = $this->input->post('id_so');

        $response = [
            'data' => $this->model->getDetailSo($id_so),
        ];

        echo json_encode($response);
    }

    // Get data tabs by khael
    public function load_data_tabs()
    {
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $data = [
            'history' => $this->model->get_history_update($id, $type),
            'file' => $this->model->get_files($id, $type)
        ];
        echo json_encode($data);
    }


    // 17-2-25
    // SO
    public function save_so()
    {
        $company        = $this->input->post('so_id_company') ?? '';
        $divisi         = $this->input->post('so_id_divisi') ?? '';
        $id_goal        = $this->input->post('so_id_goal') ?? '';
        $id_so          = $this->input->post('so_id_so') ?? '';
        $id_pic         = $this->input->post('so_id_pic') ?? '';
        $start          = $this->input->post('so_start') ?? '';
        $end            = $this->input->post('so_end') ?? '';
        // $target         = $this->input->post('so_target') ?? '';
        $target         = round((float) str_replace(',', '.', str_replace('.', '', $this->input->post('so_target') ?? '')),2);

        $target_so_type = $this->input->post('so_target_so_type') ?? '';
        $target_so_batas = $this->input->post('so_target_so_batas') ?? 'up';

        $id_status      = 1;

        $data = [
            'id_company'        => $company,
            'divisi'            => $divisi,
            'id_goal'           => $id_goal,
            'so'                => $id_so,
            'pic'               => $id_pic,
            'start'             => $start,
            'end'               => $end,
            'target_so'         => $target,
            'target_so_type'    => $target_so_type,
            'actual_so_type'    => $target_so_batas,
            'created_at'        => date("Y-m-d H:i:s"),
            'created_by'        => $this->session->userdata('user_id'),
            'status'            => $id_status,
        ];

        $save_m_so = $this->db->insert('grd_m_so', $data);

        $response['save_m_so']  = $save_m_so;
        // $response['save_m_so']  = $data;
        echo json_encode($response);
    }

    // SI
    public function save_si()
    {
        $id_so          = $this->input->post('si_id_so') ?? '';
        $id_si          = $this->input->post('si_id_si') ?? '';
        $id_pic         = $this->input->post('si_id_pic') ?? '';
        $start          = $this->input->post('si_start') ?? '';
        $end            = $this->input->post('si_end') ?? '';
        // $target         = $this->input->post('si_target') ?? '';
        $target         = round((float) str_replace(',', '.', str_replace('.', '', $this->input->post('si_target') ?? '')),2);

        $target_si_type = $this->input->post('si_target_si_type') ?? '';
        $target_si_batas = $this->input->post('si_target_si_batas') ?? 'up';

        $id_status      = 1;

        $data = [
            'id_so'             => $id_so,
            'si'                => $id_si,
            'pic'               => $id_pic,
            'start'             => $start,
            'end'               => $end,
            'target_si'         => $target,
            'target_si_type'    => $target_si_type,
            'actual_si_type'    => $target_si_batas,

            'created_at'        => date("Y-m-d H:i:s"),
            'created_by'        => $this->session->userdata('user_id'),
            'status'            => $id_status,
        ];

        $save_m_si = $this->db->insert('grd_t_si', $data);

        $response['save_m_si']  = $save_m_si;
        // $response['save_m_si']  = $data;
        echo json_encode($response);
    }


    // 8-3-25 Edit detail tasklist
    public function get_edit_detail_tasklist()
    {
        $id_tasklist = $this->input->post('id_tasklist');

        $data = [
            'edit_detail' => $this->model->get_edit_detail_tasklist($id_tasklist),
        ];

        echo json_encode($data);
    }

    // public function get_pic_edit()
    // {
    //     $data = [
    //         'pic_edit' => $this->model->get_pic_edit(),
    //     ];

    //     echo json_encode($data);
    // }

    // update tasklist GRD
    public function update_tasklist_grd()
    {
        $edit_id_tasklist   = $this->input->post('edit_id_tasklist');
        $id_pic             = $this->input->post('user_edit_pic');
        $tgl_start          = $this->input->post('tgl_start');
        $tgl_end            = $this->input->post('tgl_end');
        $detail             = $this->input->post('detail');
        $before_detail      = $this->input->post('before_detail');
        $output             = $this->input->post('output');
        $target             = $this->input->post('target');

        $progres            = $this->input->post('progres');
        $status             = $this->input->post('status');
        $status_before      = $this->input->post('status_before');
        $created_at         = date('Y-m-d H:i:s');
        $created_by         = $this->session->userdata('user_id');

        $data_update = array(
            'pic'       => $id_pic,
            'start'     => $tgl_start,
            'end'       => $tgl_end,
            'detail'    => $detail,
            'output'    => $output,
            'target'    => $target,
        );

        $this->db->where('id_tasklist', $edit_id_tasklist);
        $response['update'] = $this->db->update('grd_t_tasklist', $data_update);

        $data_insert = array(
            'id_tasklist'   => $edit_id_tasklist,
            'progress'      => 0,
            'status'        => 0,
            'status_before' => 0,
            'note'          => $detail,
            'detail_before' => $before_detail,
            'created_at'    => $created_at,
            'created_by'    => $created_by,
        );

        $response['insert'] = $this->db->insert('grd_t_tasklist_history', $data_insert);

        echo json_encode($response);
    }





}
