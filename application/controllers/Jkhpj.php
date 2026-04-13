<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jkhpj extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("model_jkhpj", 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }


    public function index()
    {
        $user_id = $this->session->userdata("user_id");
        $data['pageTitle']        = "Jadwal Kerja Harian Per Jam";
        $data['css']              = "jkhpj/css";
        $data['content']          = "jkhpj/index";
        $data['js']               = "jkhpj/js";
        $data['user_id'] = $user_id;
        $data['is_head'] = $this->db->query("SELECT * FROM xin_departments WHERE head_id = '$user_id'")->num_rows() > 0 ? true : false;
        $data['is_manager'] = $this->db->query("SELECT * FROM xin_employees WHERE user_id = '$user_id' AND is_active = 1 AND user_role_id = 3")->num_rows() > 0 ? true : false;

        $this->load->view('layout/main', $data);
    }

    public function dt_resume_tasklist()
    {
        $datestart = $_POST['start'] ?? null;
        $dateend = $_POST['end'] ?? null;
        $status = $_POST['status'] ?? null;

        $res['data'] = $this->model->dt_resume_tasklist($datestart, $dateend, $status)->result();
        header('Content-type: application/json');
        echo json_encode($res);
    }

    public function dt_resume_tasklist_feedback()
    {
        $datestart = $_POST['start'] ?? null;
        $dateend = $_POST['end'] ?? null;
        $status = $_POST['status'] ?? null;

        $res['data'] = $this->model->dt_resume_tasklist_feedback($datestart, $dateend, $status)->result();
        header('Content-type: application/json');
        echo json_encode($res);
    }

    public function dt_list_detail_task()
    {
        $id = $_POST['id'];

        $res['data'] = $this->model->dt_list_detail_task($id)->result();
        header('Content-type: application/json');
        echo json_encode($res);
    }
    // public function list_task()
    //     {
    //         $data['pageTitle']        = "List Jadwal Kerja Harian Per Jam";
    //         $data['css']              = "jkhpj/css";
    //         $data['js']               = "jkhpj/js";
    //         $data['content']          = "jkhpj/list_task";

    //         $id_task = $this->input->get('id_task');

    //         $data['dt_list_task'] = $this->model->dt_list_detail_task($id_task)->result();

    //         $this->load->view('layout/main', $data);
    //     }

    public function list_task()
    {
        $data['pageTitle']        = "List Jadwal Kerja Harian Per Jam";
        $data['css']              = "jkhpj/css";
        $data['js']               = "jkhpj/js";
        $data['content']          = "jkhpj/list_task_kanban";

        $id_task = $this->input->get('id_task');
        $data['id_task'] = $id_task;
        $data['dt_list_task'] = $this->model->dt_list_detail_task($id_task)->result();

        $this->load->view('layout/main', $data);
    }

    public function detail_task_item()
    {
        $id = $_POST['id'];
        $res['data'] = $this->model->detail_task_item($id)->row();
        header('Content-type: application/json');
        echo json_encode($res);
    }

    function check_insert_task()
    {
        $id_user = $this->session->userdata('user_id');
        $designation_id = $this->db->query("SELECT designation_id FROM xin_employees WHERE user_id = '$id_user'")->row()->designation_id;

        $check_task = $this->model->check_task($designation_id, $id_user);
        if ($check_task->num_rows() > 0) {
            // Redirect tanpa insert
            $dt_task = $check_task->row();
            $res['message'] = 'Already, redirect';
            $res['id_task'] = $dt_task->id_task;
        } else {
            // Insert kemudian redirect
            $id_task = $this->model->generate_id_jkhpj_task();
            // INSERT to sc_t_task
            $data = [
                'id_task' => $id_task,
                'designation_id' => $designation_id,
                'created_by' => $this->session->userdata('user_id'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $res['insert_task'] = $this->db->insert('jkhpj_t_task', $data);

            // Insert to sc_t_task_item
            $get_m_item = $this->db->query("SELECT * FROM `jkhpj_m_item` WHERE designation_id = '$designation_id'");

            if ($get_m_item->num_rows() > 0) {

                foreach ($get_m_item->result() as $item) {

                    $data_item = [
                        'id_task' => $id_task,
                        'id_jkhpj_item' => $item->id_jkhpj_item,
                        'time_start' => $item->time_start,
                        'time_end' => $item->time_end,
                        'tasklist' => $item->tasklist,
                        'is_file' => $item->is_file,
                        'status' => 0,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => $this->session->userdata('user_id'),
                    ];

                    $insert_item = $this->db->insert('jkhpj_t_task_item', $data_item);
                }

                $res['insert_item'] = $insert_item;
            }

            $res['message'] = 'Success insert task';
            $res['id_task'] = $id_task;
        }

        header('Content-type: application/json');
        echo json_encode($res);
    }

    public function update_task_item()
    {
        $id_task = $_POST['id_task'];

        $id_task_item = $_POST['id_task_item'];
        $status = $_POST['status'];
        $note = $_POST['note'];
        $link = $_POST['link'];
        $photo = '';
        $time_actual = date('H:i:s');
        $updated_at = date('Y-m-d H:i:s');
        $updated_by = $this->session->userdata('user_id');

        if (!empty($_FILES['file']['name'])) {
            // Proses unggah file
            // $config['upload_path']   = './uploads/security/';
            $config['upload_path']   = '/var/www/trusmiverse/files/jkhpj/';
            // $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
            $config['allowed_types'] = '*';
            $new_name = 'jkhpj_' . time();
            $config['file_name']     = $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file')) {
                $response['error'] = array('error' => $this->upload->display_errors());
                $photo = $this->upload->display_errors();
            } else {
                $data = array('upload_data' => $this->upload->data());
                $photo = $data['upload_data']['file_name'];
            }
        } else {

            $photo = (isset($_POST['old_photo'])) ? $_POST['old_photo'] : '';
        }


        $data_item = [
            'status' => $status,
            'note' => $note,
            'file' => $photo ?? null,
            'link' => $link,
            'time_actual' => $time_actual,
            'updated_at' => $updated_at,
            'updated_by' => $updated_by
        ];
        $this->db->where('id', $id_task_item);
        $update_item = $this->db->update('jkhpj_t_task_item', $data_item);

        // Update juga task di jkhpj_t_task nya
        $data_total = $this->db->query("SELECT
                                            COUNT(item.id) AS total_item,
                                            (
                                                SELECT
                                                    COUNT(id) AS total
                                                FROM
                                                    jkhpj_t_task_item
                                                WHERE
                                                id_task = '$id_task' AND `status` = 1
                                            ) AS total_item_done 
                                        FROM
                                            `jkhpj_t_task_item` item
                                        WHERE
                                            item.id_task = '$id_task'")->row();

        $achievement = ($data_total->total_item_done / $data_total->total_item) * 100;

        $data_task = [
            'achievement' => $achievement,
            'updated_at' => $updated_at,
            'updated_by' => $updated_by
        ];
        $this->db->where('id_task', $id_task);
        $update_task = $this->db->update('jkhpj_t_task', $data_task);

        header('Content-type: application/json');
        echo json_encode([
            'update_item' => $update_item,
            'update_task' => $update_task,
            'photo' => $photo ?? null,
        ]);
    }

    function feedback_jkhpj()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];

            if (!empty($_FILES['files']['tmp_name'])) {
                if (is_uploaded_file($_FILES['files']['tmp_name'])) {
                    //checking file type
                    $allowed =  array('pdf', 'xls', 'xlsx', 'png', 'jpg', 'jpeg', 'doc', 'docx');
                    $filename = $_FILES['files']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);

                    if (in_array($ext, $allowed)) {
                        $tmp_name = $_FILES["files"]["tmp_name"];
                        $profile = "/var/www/trusmiverse/files/jkhpj/";
                        // basename() may prevent filesystem traversal attacks;
                        // further validation/sanitation of the filename may be appropriate
                        $newfilename = 'feedback_jkhpj_' . $this->session->userdata("user_id") . '_' . substr(time(), -5) . '.' . $ext;
                        $data['move'] = move_uploaded_file($tmp_name, $profile . $newfilename);
                        $fname = $newfilename;
                    } else {
                        $fname = null;
                    }
                }
            } else {
                $fname = null;
            }

            $dt_jkhpj = [
                'feedback' => $_POST['feedback'],
                'file_feedback' => $fname,
                'link_feedback' => $_POST['link_feedback'] ?? null,
                'feedback_at' => date('Y-m-d H:i:s'),
                'feedback_by' => $this->session->userdata("user_id"),
                'status_feedback' => $_POST['status_feedback']
            ];
            $this->db->where('id_task', $id);
            $data['update'] = $this->db->update('jkhpj_t_task', $dt_jkhpj);
            header('Content-type: application/json');
            echo json_encode($data);
        } else {
            $data['update'] = false;
            header('Content-type: application/json');
            echo json_encode($data);
        }
    }

    public function get_list_task_kanban()
    {
        $id_task = $this->input->post('id_task');
        if (empty($id_task)) {
            $id_task = $this->input->get('id_task');
        }

        $data = $this->model->dt_list_detail_task($id_task)->result();

        header('Content-type: application/json');
        echo json_encode(['data' => $data]);
    }
}
