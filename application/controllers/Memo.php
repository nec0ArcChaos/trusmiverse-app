<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Memo extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("model_memo", 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }


    public function index()
    {
        $data['pageTitle']        = "Library Memo";
        $data['css']              = "memo/css";
        $data['content']          = "memo/index";
        $data['js']               = "memo/js";
        $data['user_id'] = $this->session->userdata("user_id");
        $data['companies'] = $this->model->get_companies();
        $data['roles'] = $this->model->get_role();

        $id = $this->session->userdata("user_id");
        if ($id == 1 || $id == 2516 || $id == 2729 || $id == 803 || $id == 6466) {
            $this->load->view('layout/main', $data);
        } else {
            redirect('https://trusmiverse.com/apps/dashboard', 'refresh');
        }
        
    }

    function dt_memo()
    {
        $id = $this->session->userdata("user_id");
        $start = @$_REQUEST['start'] ?? null;
        $end = @$_REQUEST['end'] ?? null;
        $status_memo = @$_REQUEST['status_memo'];
        $user = $this->db->query("SELECT * FROM xin_employees WHERE user_id = '$id'")->row_array();
        $data['data'] = $this->model->dt_memo($start, $end, $user['department_id'], $user['user_role_id'], $status_memo, $id);
        header('Content-type: application/json');
        echo json_encode($data);
    }

    function get_companies()
    {
        $data['company'] = $this->model->get_companies();
        header('Content-type: application/json');
        echo json_encode($data);
    }

    function get_department()
    {
        $company_id = @$_REQUEST['company_id'] ?? null;
        $data['department'] = $this->model->get_department($company_id);
        header('Content-type: application/json');
        echo json_encode($data);
    }

    function get_role()
    {
        $data['role'] = $this->model->get_role();
        header('Content-type: application/json');
        echo json_encode($data);
    }

    function simpan_memo()
    {
        $id = $this->model->get_id_memo();
        if (isset($_POST['tipe_memo'])) {
            if (!empty($_FILES['files']['tmp_name'])) {
                if (is_uploaded_file($_FILES['files']['tmp_name'])) {
                    //checking file type
                    $allowed =  array('pdf', 'xls', 'xlsx');
                    $filename = $_FILES['files']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    
                    if (in_array($ext, $allowed)) {
                        $tmp_name = $_FILES["files"]["tmp_name"];
                        $profile = "./uploads/files_memo/";
                        // basename() may prevent filesystem traversal attacks;
                        // further validation/sanitation of the filename may be appropriate
                        $newfilename = 'memo_ba_' . $this->session->userdata("user_id") . '_' . substr(time(), -5) . '.' . $ext;
                        $data['move'] = move_uploaded_file($tmp_name, $profile . $newfilename);
                        $fname = $newfilename;

                        $dt_memo = [
                            'id_memo'       => $id,
                            'tipe_memo'     => $_POST['tipe_memo'],
                            'note'          => $_POST['note'],
                            'company_id'    => $_POST['company_id'],
                            'department_id' => $_POST['department_id'],
                            'role_id'       => $_POST['role_id'],
                            'created_by'    => $this->session->userdata("user_id"),
                            'created_at'    => date("Y-m-d H:i:s"),
                            'files_memo'    => $fname,
                            'status_memo'   => 0,
                            'start_feedback_at' => date('Y-m-01', strtotime('+3 months', strtotime(date('Y-m-01'))))
                        ];
                        $data['insert_memo'] = $this->db->insert('trusmi_t_memo', $dt_memo);
                        header('Content-type: application/json');
                        echo json_encode($data);
                    } else {
                        $data['insert_memo'] = false;
                        header('Content-type: application/json');
                        echo json_encode($data);
                    }
                }
            } else {
                $data['insert_memo'] = false;
                header('Content-type: application/json');
                echo json_encode($data);
            }

            
        } else {
            $data['insert_memo'] = false;
            header('Content-type: application/json');
            echo json_encode($data);
        }
        
    }

    function simpan_memo_approval()
    {
		$user_id = $_POST["user_id"];

    	$id = $this->model->get_id_memo();
        $dt_memo = [
            'id_memo'       => $id,
            'tipe_memo'     => $_POST['tipe_memo'],
            'note'          => $_POST['note'] . " - Approve by Ibnu Riyanto (" . $_POST['no_app'] . ")",
            'note_update'   => $_POST['note'] . " - Approve by Ibnu Riyanto (" . $_POST['no_app'] . ")",
            'company_id'    => $_POST['company_id'],
            'department_id' => $_POST['department_id'],
            'role_id'       => $_POST['role_id'],
            'created_by'    => $user_id,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_by'    => 803,
            'updated_at'    => date("Y-m-d H:i:s"),
            'files_memo'    => 'https://trusmiverse.com/apps/uploads/trusmi_approval/' . $_POST['file_1'],
            'status_memo'   => 1,
            'id_approval'   => $_POST['no_app'],
            'start_feedback_at' => date('Y-m-01', strtotime('+3 months', strtotime(date('Y-m-d'))))
        ];
        $data['insert_memo'] = $this->db->insert('trusmi_t_memo', $dt_memo);
        header('Content-type: application/json');
        echo json_encode($data);
    }

    function edit_memo()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $status = $_POST['status'];
            $note = $_POST['note'];
            $dt_memo = [
                'updated_at' => date("Y-m-d H:i:s"),
                'updated_by' => $this->session->userdata("user_id"),
                'note_update' => $note,
                'status_memo' => $status
            ];
            $this->db->where('id_memo', $id);
            $data['update'] = $this->db->update('trusmi_t_memo', $dt_memo);
            header('Content-type: application/json');
            echo json_encode($data);
        } else {
            $data['update'] = false;
            header('Content-type: application/json');
            echo json_encode($data);
        }
        
    }

    function feedback_memo()
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
                        $profile = "./uploads/files_memo/feedback/";
                        // basename() may prevent filesystem traversal attacks;
                        // further validation/sanitation of the filename may be appropriate
                        $newfilename = 'feedback_memo_ba_' . $this->session->userdata("user_id") . '_' . substr(time(), -5) . '.' . $ext;
                        $data['move'] = move_uploaded_file($tmp_name, $profile . $newfilename);
                        $fname = $newfilename;
                    } else {
                        $fname = null;
                    }
                }
            } else {
                $fname = null;
            }

            $dt_memo = [
                'status_feedback' => $_POST['status_feedback'],
                'feedback' => $_POST['feedback'],
                'file_feedback' => $fname,
                'link_feedback' => $_POST['link_feedback'] ?? null,
                'feedback_at' => date('Y-m-d H:i:s'),
                'feedback_by' => $this->session->userdata("user_id"),
                'status_feedback' => $_POST['status_feedback'],
                'start_feedback_at' => date('Y-m-01', strtotime('+3 months', strtotime(date('Y-m-d'))))
            ];
            $this->db->where('id_memo', $id);
            $data['update'] = $this->db->update('trusmi_t_memo', $dt_memo);
            unset($dt_memo['start_feedback_at']);
            $dt_memo['id_memo'] = $id;
            $this->db->insert('trusmi_t_memo_history', $dt_memo);
            header('Content-type: application/json');
            echo json_encode($data);
        } else {
            $data['update'] = false;
            header('Content-type: application/json');
            echo json_encode($data);
        }
        
    }

    function feedback_memo_history()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $data['status'] = true;
            $data['histories'] = $this->model->feedback_memo_history($id);

            header('Content-type: application/json');
            echo json_encode($data);
        } else {
            $data['status'] = false;

            header('Content-type: application/json');
            echo json_encode($data);
        }
    }

    function edit_file_memo()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];

            if (!empty($_FILES['files']['tmp_name'])) {
                if (is_uploaded_file($_FILES['files']['tmp_name'])) {
                    //checking file type
                    $allowed =  array('pdf', 'xls', 'xlsx');
                    $filename = $_FILES['files']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    
                    if (in_array($ext, $allowed)) {
                        $tmp_name = $_FILES["files"]["tmp_name"];
                        $profile = "./uploads/files_memo/";
                        // basename() may prevent filesystem traversal attacks;
                        // further validation/sanitation of the filename may be appropriate
                        $newfilename = 'memo_ba_' . $this->session->userdata("user_id") . '_' . substr(time(), -5) . '.' . $ext;
                        $data['move'] = move_uploaded_file($tmp_name, $profile . $newfilename);
                        $fname = $newfilename;
                        $dt_memo = [
                            'files_memo' => $fname,
                        ];
                        $this->db->where('id_memo', $id);
                        $data['update'] = $this->db->update('trusmi_t_memo', $dt_memo);
                        header('Content-type: application/json');
                        echo json_encode($data);
                    } else {
                        $data['update'] = false;
                        header('Content-type: application/json');
                        echo json_encode($data);
                    }
                }
            } else {
                $data['update'] = false;
                header('Content-type: application/json');
                echo json_encode($data);
            }
        } else {
            $data['update'] = false;
            header('Content-type: application/json');
            echo json_encode($data);
        }
        
    }
}
