<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kanban extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("complaints/model_kanban", "model");
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function kanban_data()
    {
        if (isset($_POST['id_task'])) {
            $id_task = $_POST['id_task'];
        } else {
            $id_task = null;
        }

        if (isset($_POST['user_id'])) {
            if ($_POST['user_id'] == '' || $_POST['user_id'] == null) {
                $user_id = $_SESSION['user_id'];
            } else {
                $user_id = $_POST['user_id'];
            }
        } else {
            $user_id = $_SESSION['user_id'];
        }

        $category = $_POST['category'];
        $pic = $_POST['pic'];

        $start = $_POST['start'];
        $end = $_POST['end'];


        $kanban_data = $this->model->kanban_data($id_task, $user_id, $category, $pic, $start, $end);
        // $response['kanban'] = $kanban_data;
        $myData = [];
        foreach ($kanban_data as $key => $value) {

            // $sub_task_data = $this->monday->dt_sub_task($value->id_task);
            // $my_sub_task = [];
            // foreach ($sub_task_data as $keys => $task) {
            //     $sub_task = [
            //         'sub_task'=> $task->sub_task,
            //         'id_type'=> $task->id_type,
            //         'type'=> $task->sub_type,
            //         'start'=> $task->start,
            //         'end'=> $task->end,
            //         'jml_progress'=> $task->jml_progress,
            //         'consistency'=> $task->consistency,
            //     ];
            //     $my_sub_task[] = $sub_task;
            // }

            $myObject = [
                'id_task' => $value->id_task,
                'id_category' => $value->id_category,
                'category' => $value->category,
                'task' => $value->task,
                'description' => $value->description,
                'id_pic' => $value->id_pic,
                'level' => $value->level,
                'pic' => $value->pic,
                'profile_picture' => $value->profile_picture,
                'id_status' => $value->id_status,
                'status' => $value->status,
                'status_color' => $value->status_color,
                'progress' => $value->progress,
                'id_priority' => $value->id_priority,
                'priority' => $value->priority,
                'start' => $value->start,
                'end' => $value->end,
                'due_date' => $value->due_date,
                'note' => $value->note,
                'created_at' => $value->created_at,
                'created_by' => $value->created_by,
                // 'indicator' => $value->indicator,
                // 'strategy' => $value->strategy,
                // 'jenis_strategy' => $value->jenis_strategy,
                // 'evaluation' => $value->evaluation,
                'attachment' => $value->attachment,
            ];

            $myData[] = $myObject;
        }

        $response['kanban'] = $myData;
        $response['user_id'] = $user_id;

        echo json_encode($response);
    }
}
