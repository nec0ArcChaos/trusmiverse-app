<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Trusmi_recruitment extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");
		$this->load->model('Model_trusmi_recruitment', 'model');
        if ($this->session->userdata('user_id') != "") { } else {
			redirect('login', 'refresh');
        }
	}

	function index()
	{
		$data['content'] 	= "trusmi_recruitment/index";
		$data['pageTitle'] 	= "Dashboard Recruitment";
		$data['css'] 		= "trusmi_recruitment/css";
		$data['js'] 		= "trusmi_recruitment/js";
		$data['pic']		= $this->model->get_employee();
		$data['jobs']		= $this->model->get_jobs();

		$this->load->view("layout/main", $data);
	}

	function get_jobs($period)
	{
		$data = $this->model->get_jobs($period);
		echo '<option data-placeholder="true">-- Choose Job --</option>';
		foreach ($data as $row) {
			echo '<option value="'. $row->job_id .'">'. $row->job_title .'</option>';
		}
	}

	function get_recruitment()
	{
		$start 				= $_POST['datestart'];
		$end 				= $_POST['dateend'];
		$result['data']   	= $this->model->get_recruitment($start, $end);
		echo json_encode($result);
	}

	function save_target()
	{
		$period			= $_POST['period'];
		$pic			= $_POST['pic'];
		$target			= $_POST['target'];
		$jobs			= $_POST['jobs'];
		$created_at		= date("Y-m-d H:i:s");
		$created_by		= $this->session->userdata('user_id');

		$data = array (
			"periode" 		=> $period,
			"pic" 			=> $pic,
			"target" 		=> $target,
			"job_id" 		=> $jobs,
			"created_at" 	=> $created_at,
			"created_by" 	=> $created_by
		);

		$result['data'] 					= $data;
		$result['insert_target_marketing'] 	= $this->db->insert("trusmi_target_marketing", $data);
		echo json_encode($result);
	}

    public function data_lamar($job_id)
    {
        $data = $this->model->data_lamar($job_id);
        echo json_encode($data);
    }

    public function data_psikotes($job_id,$tipe,$id_pic)
    {
        $data = $this->model->data_psikotes($job_id,$tipe,$id_pic);
        echo json_encode($data);
    }

    public function data_interview($job_id,$tipe,$id_pic)
    {
        $data = $this->model->data_interview($job_id,$tipe,$id_pic);
        echo json_encode($data);
    }

    public function data_administrasi($job_id,$tipe,$id_pic)
    {
        $data = $this->model->data_administrasi($job_id,$tipe,$id_pic);
        echo json_encode($data);
    }

    public function data_karyawan($job_id,$tipe,$id_pic)
    {
        $data = $this->model->data_karyawan($job_id,$tipe,$id_pic);
        echo json_encode($data);
    }

    public function edit_target_sdm()
    {
		$job_id = $_POST['target_job_id'];
		$target = $_POST['target_sdm'];
		$tipe 	= $_POST['target_tipe'];
		$id 	= $_POST['e_id_target_mkt'];

		if ($tipe == 1) { // Xin Job
			$this->db->where('job_id', $job_id);
			$data['target'] = $this->db->update('xin_jobs', array('job_vacancy' => $target));
		} else if ($tipe == 2) { // Target Marketing
			$data = array (
				"target" => $target,
				"updated_at" => date("Y-m-d H:i:s"),
				"updated_by" => $_SESSION['user_id']
			);
			
			$this->db->where('id', $id);
			$data['target'] = $this->db->update('trusmi_target_marketing', $data);
		}
        echo json_encode($data);
    }

    public function edit_pic()
    {
		$tri 	= $_POST['trusmi_request_id_pic'];
		$job_id = $_POST['job_id_pic'];
		$tipe 	= $_POST['tipe_pic'];
		$pic 	= $_POST['e_pic'];
		$id 	= $_POST['id_target_mkt'];

		if ($tipe == 1) { // Xin Job
			$this->db->where('job_id', $job_id);
			$data['update_xin_jobs'] = $this->db->update('xin_jobs', array('pic' => $pic));
		} else if ($tipe == 2) { // Target Marketing
			$data = array (
				"pic" => $pic,
				"updated_at" => date("Y-m-d H:i:s"),
				"updated_by" => $_SESSION['user_id']
			);
			
			$this->db->where('id', $id);
			$data['update_target_mkt'] = $this->db->update('trusmi_target_marketing', $data);
		}
        echo json_encode($data);
    }
}
