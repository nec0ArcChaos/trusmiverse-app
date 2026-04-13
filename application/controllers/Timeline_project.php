<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Timeline_project extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library("session");
        $this->load->library('Whatsapp_lib');
        $this->load->database();
        $this->load->model('Model_timeline_project', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']  = "Dashboard Portal";
        $data['css']        = "timeline_project/css";
        $data['js']         = "timeline_project/js";
        $data['content']    = "timeline_project/index";
        $data['status'] = $this->model->get_status();
        $data['project'] = $this->db->query("SELECT id_project, project FROM rsp_project_live.m_project WHERE `status` IS NULL ORDER BY project")->result();

        $this->load->view('layout/main', $data);
    }

    public function get_project()
    {
        $data = $this->db->query("SELECT id_project, project FROM rsp_project_live.m_project WHERE `status` IS NULL ORDER BY project")->result();
        echo json_encode($data);
    }

    public function get_department()
    {
        $data = $this->model->get_department();
        echo json_encode($data);
    }

    public function pekerjaan_pic()
    {
        $id_department = $this->input->post('id_department');

        if (strpos($id_department, 'all') !== false) {
            // do something
            $cond = "";
        } else {
            $cond = "AND e.department_id IN ($id_department)";
        }

        $data = [
            'pekerjaan'=>$this->db->query("SELECT 
                            id, `pekerjaan` 
                        FROM m_pekerjaan 
                        WHERE `department_id` = '$id_department'
                        ORDER BY pekerjaan")
                          ->result(),
            'pic'=>$this->db->query("SELECT
                    e.user_id,
                    CONCAT(e.first_name,' ',e.last_name, ' - ', ds.designation_name) AS pic_name 
                    FROM `xin_employees` e 
                    LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
                    WHERE e.user_id != 1 AND e.is_active = 1 
                    -- $cond 
                    AND e.user_role_id IN (3,4,5,6) AND e.company_id IN (1,2)
                    ORDER BY CONCAT(e.first_name,' ',e.last_name)")
                    ->result()
        ];
        echo json_encode($data);
    }

    public function get_sub_pekerjaan_by_pekerjaan()
    {
        $id_pekerjaan = $this->input->post('id_pekerjaan');

        $data = $this->db->query("SELECT 
                                    id, `sub_pekerjaan` 
                                FROM m_sub_pekerjaan 
                                WHERE `id_pekerjaan` = '$id_pekerjaan'
                                ORDER BY sub_pekerjaan")
            ->result();
        echo json_encode($data);
    }


    public function save_task()
    {
        $id_project = $this->input->post('id_project') ?? '';
        $id_department = $this->input->post('id_department') ?? '';
        $id_pekerjaan = $this->input->post('id_pekerjaan') ?? '';
        $id_sub_pekerjaan = $this->input->post('id_sub_pekerjaan') ?? '';
        $id_pic = $this->input->post('id_pic') ?? '';
        $start = $this->input->post('start') ?? '';
        $end = $this->input->post('end') ?? '';
        $detail = $this->input->post('detail') ?? '';
        $output = $this->input->post('output') ?? '';
        $target = $this->input->post('target') ?? '';
        $id_status = 1;

        $id_detail_pekerjaan = $this->model->generate_id_task();

        $data = [
            'id_detail_pekerjaan' => $id_detail_pekerjaan,
            'id_project' => $id_project,
            'id_sub_pekerjaan' => $id_sub_pekerjaan,
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
        $save_task = $this->db->insert('t_detail_pekerjaan', $data);

        $data_history = [
            'id_detail_pekerjaan' => $id_detail_pekerjaan,
            'progress' => 0,
            'status' => $id_status,
            'status_before' => $id_status,
            'note' => 'Detail Pekerjaan Created',
            'created_at' => date('Y-m-d H:i_s'),
            'created_by' => $this->session->userdata('user_id')
        ];
        $save_history = $this->db->insert('t_detail_pekerjaan_history', $data_history);

        $response['id_detail_pekerjaan']    = $id_detail_pekerjaan;
        $response['save_task']  = $save_task;
        echo json_encode($response);
    }

    public function get_pekerjaan_data()
    {
        $project = $this->input->post('project');
        $year = $this->input->post('year');
        $data = [
            'status' => $this->model->get_resume_pekerjaan_status($project, $year),
            'progres' => $this->model->get_resume_pekerjaan_progres($project, $year),
            'leadtime' => $this->model->get_resume_pekerjaan_leadtime($project, $year)
        ];
        echo json_encode($data);
    }

    public function get_list_task()
    {
        $project = $this->input->post('project');
        $year = $this->input->post('year');

        $dep = $this->model->get_detail_department($project, $year);
        $task_main = $this->model->get_task_main($project, $year);
        $sub_task = $this->model->get_sub_task($project, $year);
        $detail_task = $this->model->get_detail_task($project, $year);
        
        $result = [];
        foreach ($dep as $department) {
            // Filter task_main berdasarkan department_id
            $department_tasks = array_filter($task_main, function ($task) use ($department) {
                return $task->department_id === $department->department_id;
            });

            // Tambahkan sub_task dan detail_task ke setiap task_main
            foreach ($department_tasks as $main) {
                $main->sub_task = array_values(array_filter($sub_task, function ($sub) use ($main) {
                    return $sub->id_pekerjaan === $main->id; // Kecocokan antara id di task_main dan id di sub_task
                }));

                foreach ($main->sub_task as $sub) {
                    $sub->details = array_values(array_filter($detail_task, function ($detail) use ($sub) {
                        return $detail->id_sub_pekerjaan === $sub->id; // Kecocokan antara id_sub_pekerjaan di detail_task dan id_sub_pekerjaan di sub_task
                    }));
                }
            }

            // Masukkan ke hasil dengan struktur departemen
            $result[] = [
                'department_id' => $department->department_id,
                'department_name' => $department->department_name,
                'tasks' => array_values($department_tasks),
                'progres'=>$department->progres,
                'warna'=>$department->warna
            ];
        }
        echo json_encode($result);
    }
    public function get_detail_task()
    {
        $id = $this->input->post('id');
        $id_detail = $this->input->post('id_detail');
        $id_sub = $this->input->post('id_sub');
        $id_pekerjaan = $this->input->post('id_pekerjaan');
        $id_project = $this->input->post('id_project');
        $year = $this->input->post('year');
        $data = [
            'header' => $this->model->get_header_detail($id),
            'mom' => $this->model->get_detail_mom($id, $id_detail, $id_sub, $id_pekerjaan, $id_project, $year),
            'ibr' => $this->model->get_detail_ibr($id, $id_detail, $id_sub, $id_pekerjaan, $id_project, $year),
            'genba' => $this->model->get_detail_genba($id, $id_detail, $id_sub, $id_pekerjaan, $id_project, $year),
            'conco' => $this->model->get_detail_conco($id, $id_detail, $id_sub, $id_pekerjaan, $id_project, $year),
            'complaint' => $this->model->get_detail_comp($id, $id_detail, $id_sub, $id_pekerjaan, $id_project, $year),
            'teamtalk' => $this->model->get_detail_teamtalk($id, $id_detail, $id_sub, $id_pekerjaan, $id_project, $year),
        ];
        echo json_encode($data);
    }
    public function update_task()
    {
        $config['upload_path'] = 'uploads/evidence/'; // Direktori untuk menyimpan file
        $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx'; // Tipe file yang diperbolehkan
        // $config['max_size'] = 2048; // Ukuran maksimal file dalam KB (2 MB)
        $this->load->library('upload', $config);
        $id_detail_pekerjaan = $this->input->post('id_detail_pekerjaan');


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
        $this->db->where('id_detail_pekerjaan', $id_detail_pekerjaan);
        $hasil = $this->db->update('t_detail_pekerjaan', $data);
        $data_history = [
            'id_detail_pekerjaan' => $id_detail_pekerjaan,
            'progress' => $this->input->post('actual'),
            'status' => $this->input->post('status'),
            'status_before' => $this->input->post('status_before'),
            'note' => $this->input->post('note'),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id'),

        ];
        $this->db->insert('t_detail_pekerjaan_history', $data_history);
        echo json_encode($hasil);
    }

    public function get_pekerjaan_minggu_ini()
    {
        $project = $this->input->post('project');
        $year = $this->input->post('year');
        $data = [
            'deadline' => $this->model->get_pekerjaan_deadline($project, $year),
            'undone' => $this->model->get_pekerjaan_undone($project, $year),
            'dimulai' => $this->model->get_pekerjaan_dimulai($project, $year)
        ];
        echo json_encode($data);
    }

    public function get_resume_data_all()
    {
        $project = $this->input->post('project');
        $year = $this->input->post('year');
        $data = [
            'header' => $this->model->get_resume_data_header($project, $year),
            'data' => $this->model->get_resume_data_all($project, $year)
        ];
        echo json_encode($data);
    }
    public function get_resume_activity()
    {
        $project = $this->input->post('project');
        $year = $this->input->post('year');
        $data = $this->model->get_resume_activity($project, $year);
        echo json_encode($data);
    }
    public function load_all_tab()
    {
        $id = $this->input->post('id_detail_pekerjaan');
        $data = [
            'history' => $this->model->get_history($id),
            'file' => $this->model->get_file($id)
        ];
        echo json_encode($data);
    }
    public function get_request()
    {
        $data = $this->model->get_request();
        echo json_encode($data);
    }
    public function request_change()
    {
        $request_to = [5203];
        $id = $this->input->post('id_detail');
        $id_req = $this->model->req_id();
        $data = [
            'id_req'=>$id_req,
            'id_detail' => $id,
            'start' => $this->input->post('start'),
            'end' => $this->input->post('end'),
            'note' => $this->input->post('note'),
            'status' => 1,
            'request_to' => implode(',', $request_to),
            'created_by' => $this->session->userdata('user_id'),
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $this->db->insert('t_detail_req', $data);
        // $this->notif_request($id);
        echo json_encode($data);
    }
    public function update_approve(){
        $status = $this->input->post('status');
        $id_req = $this->input->post('id_req');
        $id_detail = $this->input->post('id_detail');
        $request = $this->db->get_where('t_detail_req',['id_req'=>$id_req])->row_object();
        if($status == 2){
            $data_update = [
                'start'=>$request->start,
                'end'=>$request->end,
            ];
            $this->db->where('id',$id_detail);
            $this->db->update('t_detail_pekerjaan',$data_update);
        }
        $data = [
            'status'=> $status,
            'approve_note'=>$this->input->post('note'),
            'approve_by'=>$this->session->userdata('user_id'),
            'approve_at'=>date('Y-m-d H:i:s')
        ];
        $this->db->where('id_req',$id_req);
        $hasil = $this->db->update('t_detail_req',$data);
        echo json_encode($hasil);
    }

    public function notif_request($id)
    {
        $data = $this->model->get_request($id);
        $msg = "🔔Request Change Timeline Project
*Pengajuan Pergantian Deadline*

Dear Bpk / Ibu : *$data->request_to*
🏣Project : *$data->project*
🚜Pekerjaan : *$data->pekerjaan*
⏺Sub Pekerjaan : *$data->sub_pekerjaan*
#️⃣Detail Pekerjaan : *$data->detail*
👤Request By : *$data->created_by*

Request date:
Start                  End
*$data->req_start* ▶ *$data->req_end* 

Note Perubahan : 
$data->note

Mohon melakukan feedback di menu *Timeline Project* > Approval

Terima kasih atas perhatian dan kerjasamanya.";
        $hasil = $this->whatsapp_lib->send_single_msg('rsp', $data->request_contact, $msg);
        echo json_encode($hasil);
    }
    public function get_resume_head(){
        $project = $this->input->post('project');
        $year = $this->input->post('year');
        $data = $this->model->get_resume_head($project,$year);
        echo json_encode($data);
    }
    public function get_resume_hr(){
        $periode = date('Y-m');
        $project = $this->input->post('project') ;
        $data = [
            'rekrut'=>$this->model->resume_rekrut($periode, $project),
            'training'=>$this->model->resume_training($periode,$project),
            'department'=>$this->model->resume_department($periode,$project),
            'table'=>$this->model->table_footer_hr(),
        ];
        echo json_encode($data);
    }
}
