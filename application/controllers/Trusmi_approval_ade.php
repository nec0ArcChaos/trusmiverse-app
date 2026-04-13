<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Trusmi_approval_ade extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_trusmi_approval_ade', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']        = "T-Approval";
        $data['css']              = "trusmi_approval/css";
        $data['js']               = "trusmi_approval/js_ade";
        $data['content']          = "trusmi_approval/index_ade";
        // $data['approve_to']       = $this->get_approve_to_php();
        $this->load->view('layout/main', $data);
    }

    // public function cron()
    // {
    //     $this->load->view('trusmi_approval/cront_job_follow_up_trusmi_approval.php');
    // }

    public function dt_trusmi_approval()
    {
        $id_status = $this->input->post('id_status');
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $data['data'] = $this->model->dt_trusmi_approval($id_status, $start, $end)->result();
        echo json_encode($data);
        // $department_id = $this->session->userdata('department_id');
        // $user_id = $this->session->userdata('user_id');
        // $user_role_id = $this->session->userdata('user_role_id');
        // echo ($department_id);
        // echo '<br>';
        // echo ($user_id);
        // echo '<br>';
        // echo ($user_role_id);
    }

    public function get_trusmi_approval_by_no_app()
    {
        $no_app = $this->input->post('no_app');
        $data = $this->model->get_trusmi_approval_by_no_app($no_app)->row();
        echo json_encode($data);
    }

    public function upload_file()
    {
        $string = $_POST['string'];
        define('UPLOAD_DIR', './uploads/trusmi_approval/temp/');

        $string     = explode(',', $string);
        $img        = str_replace(' ', '+', $string[1]);
        $data       = base64_decode($img);
        $name       = uniqid() . '.' . $string[0];
        $file       = UPLOAD_DIR . $name;
        $success    = file_put_contents($file, $data);

        echo $name;
    }

    public function save()
    {
        // Kelola Image / File
        if ($_POST['string_file_1'] == '') {
            $file_1 = NULL;
        } else {
            $file_1 = $_POST['string_file_1'];
            rename('uploads/trusmi_approval/temp/' . $_POST['string_file_1'], 'uploads/trusmi_approval/' . $_POST['string_file_1']);
        }
        if ($_POST['string_file_2'] == '') {
            $file_2 = NULL;
        } else {
            $file_2 = $_POST['string_file_2'];
            rename('uploads/trusmi_approval/temp/' . $_POST['string_file_2'], 'uploads/trusmi_approval/' . $_POST['string_file_2']);
        }

        $no_app = $this->model->no_app();

        $request = array(
            'no_app'            => $no_app,
            'subject'           => $_POST['subject'],
            'description'       => $_POST['description'],
            'approve_to'        => $_POST['approve_to'],
            'file_1'            => $file_1,
            'file_2'            => $file_2,
            'status'            => 1,
            'created_at'        => date('Y-m-d H:i:s'),
            'created_by'        => $this->session->userdata('user_id')
        );

        $result['request_approval'] = $this->model->save($request);
        $query_data = $this->model->get_trusmi_approval_by_no_app($no_app)->row();
        $result['no_app'] = $no_app;
        $result['user_id_approve_to'] = $query_data->user_id_approve_to;
        $result['approve_to'] = $query_data->approve_to;
        $result['created_by'] = $query_data->created_by;
        $result['created_at'] = $query_data->created_at;
        $result['created_hour'] = $query_data->created_hour;
        $result['leadtime'] = $query_data->leadtime;
        $result['subject'] = $query_data->subject;
        $result['description'] = $query_data->description;

        echo json_encode($result);
    }


    public function reject()
    {
        $no_app = $this->input->post('no_app');
        if ($no_app) {
            $data = array(
                'status'            => 3,
                'approve_note'      => $_POST['approve_note'],
                'approve_at'        => date('Y-m-d H:i:s'),
                'approve_by'        => $this->session->userdata('user_id')
            );
            $result['request_approval'] = $this->db->where('no_app', $no_app)->update('trusmi_approval', $data);
            $request = $this->model->get_trusmi_approval_by_no_app($no_app)->row();
            $result['no_app'] = $request->no_app;
            $result['subject'] = $request->subject;
            $result['user_id_approve_to'] = $request->user_id_approve_to;
            $result['description'] = $request->description;
            $result['created_by_contact'] = $request->created_by_contact;
            $result['created_by'] = $request->created_by;
            $result['created_at'] = $request->created_at;
            $result['created_hour'] = $request->created_hour;
            $result['approve_to'] = $request->approve_to;
            $result['approve_note'] = $_POST['approve_note'];
        } else {
            $result['approve_note'] = '';
            $result['request_approval'] = false;
        }
        echo json_encode($result);
    }

    public function approve()
    {
        $no_app = $this->input->post('no_app');
        if ($no_app) {
            $data = array(
                'status'            => 2,
                'approve_note'      => $_POST['approve_note'],
                'approve_at'        => date('Y-m-d H:i:s'),
                'approve_by'        => $this->session->userdata('user_id')
            );
            $result['request_approval'] = $this->db->where('no_app', $no_app)->update('trusmi_approval', $data);
            $request = $this->model->get_trusmi_approval_by_no_app($no_app)->row();
            $result['no_app'] = $request->no_app;
            $result['subject'] = $request->subject;
            $result['description'] = $request->description;
            $result['created_by_contact'] = $request->created_by_contact;
            $result['created_by'] = $request->created_by;
            $result['created_at'] = $request->created_at;
            $result['created_hour'] = $request->created_hour;
            $result['approve_to'] = $request->approve_to;
            $result['approve_note'] = $_POST['approve_note'];
        } else {
            $result['approve_note'] = '';
            $result['request_approval'] = false;
        }
        echo json_encode($result);
    }

    function get_approve_to_php()
    {
        $data = $this->db->query("SELECT
        CONCAT(
            CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ),
            ' | ',
            xin_companies.alias 
        ) AS full_name,
        xin_employees.user_id AS `user_id` 
    FROM
        xin_employees
        JOIN xin_companies ON xin_employees.company_id = xin_companies.company_id
        JOIN xin_departments ON xin_employees.department_id = xin_departments.department_id 
    WHERE
        xin_employees.is_active = 1 
        AND xin_employees.user_role_id IN (1,2,3,4,5,10,11,12)")->result();

        return $data;
    }

    function get_approve_to()
    {
        $data = $this->db->query("SELECT
        CONCAT(
            CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ),
            ' | ',
            xin_companies.alias,
            ' | ',
            xin_departments.department_name 
        ) AS full_name,
        xin_employees.user_id AS `user_id`,
        xin_employees.contact_no,
        xin_employees.username
    FROM
        xin_employees
        JOIN xin_companies ON xin_employees.company_id = xin_companies.company_id
        JOIN xin_departments ON xin_employees.department_id = xin_departments.department_id 
    WHERE
        xin_employees.is_active = 1 AND xin_employees.user_id != 1
        AND (xin_employees.user_role_id IN (1,2,3,4,5,6,10,11,12) OR xin_employees.department_id = 68 OR xin_employees.user_id = 1287)")->result();

        echo json_encode($data);
    }

    function verify_approval()
    {
        if (isset($_GET['id'])) {
            $no_app = $_GET['id'];
            $query = $this->model->get_trusmi_approval_by_no_app($no_app)->row();
            if ($query) {
                $data['data'] = $query;
            }
        }
        $data['pageTitle']        = "T-Approval";
        $data['css']              = "trusmi_approval/css";
        $data['js']               = "trusmi_approval/verify_approval_js";
        $data['content']          = "trusmi_approval/verify_approval";
        $this->load->view('layout/main', $data);
    }

    function resend_wa()
    {
        $no_app = $this->input->post("no_app");
        $request = $this->model->get_trusmi_approval_by_no_app($no_app)->row();
        $result['no_app'] = $request->no_app;
        $result['subject'] = $request->subject;
        $result['description'] = $request->description;
        $result['created_by_contact'] = $request->created_by_contact;
        $result['created_by'] = $request->created_by;
        $result['created_at'] = $request->created_at;
        $result['created_hour'] = $request->created_hour;
        $result['approve_to_user_id'] = $request->approve_to_user_id;
        $result['approve_to'] = $request->approve_to;
        $result['approve_to_contact'] = $request->approve_to_contact;
        $result['approve_to_username'] = $request->approve_to_username;
        $result['id_status'] = $request->id_status;
        $result['keterangan'] = $request->keterangan;
        $result['leadtime'] = $request->leadtime;
        echo json_encode($result);
    }
    function resubmit()
    {
        $old_no_app = $this->input->post('old_no_app');
        $subject = $this->input->post('subject');
        $tipe = $this->input->post('tipe');
        $description = $this->input->post('description');
        $approve_to = $this->input->post('id_approve_to');
        // Kelola Image / File
        if ($_POST['string_file_1'] == '') {
            $file_1 = NULL;
        } else {
            $file_1 = $_POST['string_file_1'];
            rename('uploads/trusmi_approval/temp/' . $_POST['string_file_1'], 'uploads/trusmi_approval/' . $_POST['string_file_1']);
        }
        if ($_POST['string_file_2'] == '') {
            $file_2 = NULL;
        } else {
            $file_2 = $_POST['string_file_2'];
            rename('uploads/trusmi_approval/temp/' . $_POST['string_file_2'], 'uploads/trusmi_approval/' . $_POST['string_file_2']);
        }
        $no_app = $this->model->no_app();

        $request = array(
            'no_app'            => $no_app,
            'subject'           => '('.$tipe.') '.$subject,
            'description'       => $description,
            'approve_to'        => $approve_to,
            'file_1'            => $file_1,
            'file_2'            => $file_2,
            'status'            => 1,
            'created_at'        => date('Y-m-d H:i:s'),
            'created_by'        => $this->session->userdata('user_id'),
            'old_no_app'=>$old_no_app
        );

        $result['request_approval'] = $this->model->save($request);
        $data = $this->model->get_trusmi_approval_by_no_app($no_app)->row_object();
        echo json_encode($data);
    }

    // addnew integrate Memo ke RSP
    function integrate_approval()
    {
        if (isset($_GET['id'])) {
            $no_app = $_GET['id'];
            $query = $this->model->get_trusmi_approval_by_no_app($no_app)->row();
            if ($query) {
                $data['data'] = $query;
            }
        }
        $data['pageTitle']        = "T-Approval";
        $data['css']              = "trusmi_approval/css";
        $data['js']               = "trusmi_approval/integrate_approval_js";
        $data['content']          = "trusmi_approval/integrate_approval";
        $this->load->view('layout/main', $data);
    }

    function get_divisi()
    {
        $query = "SELECT * FROM rsp_project_live.m_divisi";

        $data['divisi'] = $this->db->query($query)->result();

        echo json_encode($data);
    }

    function get_jabatan()
    {
        $data['jabatan'] = $this->db->query("SELECT * FROM xin_user_roles")->result();
        echo json_encode($data);
    }

    // function get_id_memo()
    // {
    //     $memo = $this->db->query("SELECT * FROM rsp_project_live.t_memo_new WHERE SUBSTR(created_at,1,10) = SUBSTR(CURDATE(),1,10) ORDER BY id_memo DESC LIMIT 1")->row_array();
    //     if ($memo == null) {
    //         $date = substr(date("Ymd"), 2);
    //         $id = "MEMO" . $date . "001";
    //     } else {
    //         $latest = substr($memo['id_memo'], 10);
    //         $current = sprintf("%03d", (int)$latest + 1);
    //         $date = substr(date("Ymd"), 2);
    //         $id = "MEMO" . $date . $current;
    //     }
    //     return $id;
    // }

    // function simpan_memo()
    // {
    //     // die($this->session->userdata("user_id"));
    //     $id = $this->get_id_memo();
    //     if (!empty($_FILES['files']['tmp_name'])) {
    //         if (is_uploaded_file($_FILES['files']['tmp_name'])) {
    //             //checking file type
    //             $allowed =  array('pdf', 'xls', 'xlsx');
    //             $filename = $_FILES['files']['name'];
    //             $ext = pathinfo($filename, PATHINFO_EXTENSION);

    //             if (in_array($ext, $allowed)) {
    //                 $tmp_name = $_FILES["files"]["tmp_name"];
    //                 $profile = "./uploads/files_memo_test/";
    //                 // basename() may prevent filesystem traversal attacks;
    //                 // further validation/sanitation of the filename may be appropriate
    //                 $newfilename = 'memo_ba_' . $this->session->userdata("id_user") . '_' . substr(time(), -5) . '.' . $ext;
    //                 $data['move'] = move_uploaded_file($tmp_name, $profile . $newfilename);
    //                 $fname = $newfilename;
    //             } else {
    //                 $Return['error'] = '';
    //             }
    //         }
    //     } else {
    //         $fname = '';
    //     }
    //     $dt_memo = [
    //         'id_memo'       => $id,
    //         'tipe_memo'     => $_POST['tipe_memo'],
    //         'note'          => $_POST['note'] . " - Approve by Ibnu Riyanto (" . $_POST['no_app'] . ")",
    //         'divisi'        => $_POST['divisi'],
    //         'jabatan'        => $_POST['jabatan'],
    //         'created_by'    => $this->session->userdata("user_id"),
    //         'created_at'    => date("Y-m-d"),
    //         'files_memo'    => $fname,
    //         'status_memo'   => 0
    //     ];
    //     $data['insert_memo'] = $this->db->insert('rsp_project_live.t_memo_new', $dt_memo);
    //     echo json_encode($data);
    // }

    function data_test()
    {
        echo json_encode([
            "message" => "Data Test",
            "name" => $_POST['nama']
        ]);
    }
}
