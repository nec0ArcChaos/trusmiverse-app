<?php
// Trusmi History Lock Absen
// Created At : 12-05-2023
defined('BASEPATH') or exit('No direct script access allowed');
class Overtime_request extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_overtime_request', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']        = "Overtime Request";
        $data['css']              = "overtime_request/css";
        $data['js']               = "overtime_request/js";
        $data['content']          = "overtime_request/index";
        $data_level_sto           = $this->model->get_level_sto();
        $data['level_sto']        = $data_level_sto['level_sto'];

        $data['list_head'] = $this->model->list_head();

        $this->load->view('layout/main', $data);
    }

    public function dt_overtime_request()
    {
        if (isset($_POST['time_request_id'])) {
            $start = null;
            $end = null;
            $time_request_id = $_POST['time_request_id'];
            // $status = null;
            // }else if(isset($_POST['status'])){
            //     $start = null;
            //     $end = null;
            //     $time_request_id = null;
            // $status = $_POST['status'];

        } else {
            $start = $_POST['start'];
            $end = $_POST['end'];
            $time_request_id = null;
            // $status = null;
        }

        if (isset($_POST['status'])) {
            $status = $_POST['status'];
        } else {
            $status = null;
        }


        $data['data'] = $this->model->dt_overtime_request($start, $end, $time_request_id, $status);
        echo json_encode($data);
    }

    // add by Ade
    public function get_overtime_request()
    {
        $time_request_id = $_POST['time_request_id'];
        $query = "SELECT
                    request_date AS date,
                    TIME_FORMAT(request_clock_in, '%H:%i') AS in_time,
                    TIME_FORMAT(request_clock_out, '%H:%i') AS out_time,
                    request_reason AS reason
                FROM
                    `xin_attendance_time_request` 
                WHERE
                    time_request_id = $time_request_id";
        $data = $this->db->query($query)->row();

        echo json_encode($data);
    }

    // add by Ade
    public function update_request_new()
    {
        $request_clock_in = $_POST['edit_request_date'] . ' ' . $_POST['edit_in_time'] . ':00';
        $request_clock_out = $_POST['edit_request_date'] . ' ' . $_POST['edit_out_time'] . ':00';

        //total work
        $total_work_cin =  new DateTime($request_clock_in);
        $total_work_cout =  new DateTime($request_clock_out);

        $interval_cin = $total_work_cout->diff($total_work_cin);
        $hours_in   = $interval_cin->format('%h');
        $minutes_in = $interval_cin->format('%i');
        $total_work = $hours_in . ":" . $minutes_in;

        $data = array(
            'request_date' => $_POST['edit_request_date'],
            'request_clock_in' => $request_clock_in,
            'request_clock_out' => $request_clock_out,
            'total_hours' => $total_work,
            'request_reason' => $_POST['edit_reason'],
        );

        $this->db->where('time_request_id', $_POST['time_request_id']);
        $response['update'] = $this->db->update('xin_attendance_time_request', $data);

        echo json_encode($response);
    }


    public function save_request()
    {


        $user_id = $_SESSION['user_id'];
        $data_employee = $this->db->query("SELECT user_id, company_id, department_id, designation_id, user_role_id FROM xin_employees WHERE user_id = '$user_id' LIMIT 1")->row_array();


        $request_clock_in = $_POST['request_date'] . ' ' . $_POST['in_time'] . ':00';
        $request_clock_out = $_POST['request_date'] . ' ' . $_POST['out_time'] . ':00';

        //total work
        $total_work_cin =  new DateTime($request_clock_in);
        $total_work_cout =  new DateTime($request_clock_out);

        // if $total_work_cout < $total_work_cin then add 1 day to $total_work_cout
        if ($total_work_cout < $total_work_cin) {
            $total_work_cout->modify('+1 day');
            // add 1 day to $_POST['request_date']
            $clock_out_date = date('Y-m-d', strtotime('+1 day', strtotime($_POST['request_date'])));
            $request_clock_out = $clock_out_date . ' ' . $_POST['out_time'] . ':00';
        }

        $interval_cin = $total_work_cout->diff($total_work_cin);
        $hours_in   = $interval_cin->format('%h');
        $minutes_in = $interval_cin->format('%i');
        $total_work = $hours_in . ":" . $minutes_in;

        // add upload dokumen devnew
        $uploaded_file = null; // default jika tidak ada file

		// 🔥 Cek apakah file dikirim
		if (!empty($_FILES['dokumen']['name'])) {
			// var_dump($_FILES['dokumen']['name']);
			// die();
			$config['upload_path']   = './uploads/overtime_request/';
			$config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx';
			$config['max_size']      = 5120; // 5 MB
			$config['encrypt_name']  = TRUE;

			// pastikan folder ada
			if (!is_dir($config['upload_path'])) {
				mkdir($config['upload_path'], 0777, TRUE);
			}

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('dokumen')) {
				$uploadData    = $this->upload->data();
				$uploaded_file = $uploadData['file_name']; // simpan nama file
			} else {
				// Jika gagal upload: kirim error
				echo json_encode([
					'status' => false,
					'error' => $this->upload->display_errors()
				]);
				return;
			}
		}

        $data = array(
            'company_id' => $data_employee['company_id'],
            'department_id' => $data_employee['department_id'],
            'employee_id' => $data_employee['user_id'],
            'request_date' => $_POST['request_date'],
            'request_date_request' => substr($_POST['request_date'], 0, 7),
            'request_clock_in' => $request_clock_in,
            'request_clock_out' => $request_clock_out,
            'total_hours' => $total_work,
            'request_reason' => $_POST['reason'],
            "dokumen"       => $uploaded_file, // nullable
            'created_at' => date('Y-m-d H:i:s'),
            'is_approved' => 1
        );

        $response['insert'] = $this->db->insert('xin_attendance_time_request', $data);

        echo json_encode($response);
    }

    public function update_request()
    {


        $user_id = $_SESSION['user_id'];
        $data_employee = $this->db->query("SELECT user_id, company_id, department_id, designation_id, user_role_id FROM xin_employees WHERE user_id = '$user_id' LIMIT 1")->row_array();


        $request_clock_in = $_POST['request_date'] . ' ' . $_POST['in_time'] . ':00';
        $request_clock_out = $_POST['request_date'] . ' ' . $_POST['out_time'] . ':00';

        //total work
        $total_work_cin =  new DateTime($request_clock_in);
        $total_work_cout =  new DateTime($request_clock_out);

        $interval_cin = $total_work_cout->diff($total_work_cin);
        $hours_in   = $interval_cin->format('%h');
        $minutes_in = $interval_cin->format('%i');
        $total_work = $hours_in . ":" . $minutes_in;

        $data = array(
            'request_date' => $_POST['request_date'],
            'request_clock_in' => $request_clock_in,
            'request_clock_out' => $request_clock_out,
            'total_hours' => $total_work,
            'request_reason' => $_POST['reason'],
        );


        // if ($data_employee['user_role_id'] == 3 || ( $data_employee['user_role_id'] == 5 &&  $data_employee['user_id'] == 1844) || $data_employee['user_role_id'] == 1) {
        //     $data = array(
        //         'company_id' => $this->input->post('company_id'),
        //         'employee_id' => $this->input->post('employee_id'),
        //         'request_date' => $_POST['request_date'],
        //         'request_clock_in' => $request_clock_in,
        //         'request_clock_out' => $request_clock_out,
        //         'total_hours' => $total_work,
        //         'request_reason' => $_POST['reason'],
        //         'is_approved' => $this->input->post('status'),
        //         'approve_gm' => $data_employee['user_id'],
        //         'gm_at' => date('Y-m-d'),
        //     );
        // } else if ($data_employee['user_role_id'] == 10) {
        //     $data = array(
        //         'company_id' => $this->input->post('company_id'),
        //         'employee_id' => $this->input->post('employee_id'),
        //         'request_date' => $_POST['request_date'],
        //         'request_clock_in' => $request_clock_in,
        //         'request_clock_out' => $request_clock_out,
        //         'total_hours' => $total_work,
        //         'request_reason' => $_POST['reason'],
        //         'is_approved' => $this->input->post('status'),
        //         'approve_dirut' => $data_employee['user_id'],
        //         'dirut_at' => date('Y-m-d'),
        //     );
        // } else {
        $data = array(
            'request_date' => $_POST['request_date'],
            'request_clock_in' => $request_clock_in,
            'request_clock_out' => $request_clock_out,
            'total_hours' => $total_work,
            'request_reason' => $_POST['reason'],
        );
        // }

        $this->db->where('time_request_id', $_POST['time_request_id']);
        $response['update'] = $this->db->update('xin_attendance_time_request', $data);

        echo json_encode($response);
    }


    public function delete_request()
    {
        $this->db->where('time_request_id', $_POST['time_request_id']);
        $response['delete'] = $this->db->delete('xin_attendance_time_request');

        echo json_encode($response);
    }

    function approve_request()
    {
        // add by Ade
        //total work
        $request_clock_in = $_POST['request_date'] . ' ' . $_POST['in_time'] . ':00';
        $request_clock_out = $_POST['request_date'] . ' ' . $_POST['out_time'] . ':00';

        $total_work_cin =  new DateTime($request_clock_in);
        $total_work_cout =  new DateTime($request_clock_out);

        $interval_cin = $total_work_cout->diff($total_work_cin);
        $hours_in   = $interval_cin->format('%h');
        $minutes_in = $interval_cin->format('%i');
        $total_work = $hours_in . ":" . $minutes_in;

        $approval = array(
            // add by Ade
            'request_clock_in' => $request_clock_in,
            'request_clock_out' => $request_clock_out,
            'request_reason' => $_POST['reason'],
            'total_hours' => $total_work,
            // end
            'is_approved' => $_POST['status'],
            'approve_gm' => $_SESSION['user_id'],
            'gm_at' => date('Y-m-d H:i:s'),
        );
        $this->db->where('time_request_id', $_POST['time_request_id']);
        $response['approve'] = $this->db->update('xin_attendance_time_request', $approval);
        echo json_encode($response);
    }
}
