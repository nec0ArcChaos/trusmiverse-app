<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Qna extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");
		$this->load->model('Model_qna', 'model');
        if ($this->session->userdata('user_id') != "") { } else {
			redirect('login', 'refresh');
        }
	}

	function index()
	{
		$data['content'] 			= "qna/index";
		$data['pageTitle'] 			= "Question and Answer (QnA)";
		$data['css'] 				= "qna/css";
		$data['js'] 				= "qna/js";

		$data['periode'] 			= date('Y-m');

		$this->load->view("layout/main", $data);
	}

	function list_qna($periode)
	{
		$result['data'] = $this->model->list_qna_new($periode);
		echo json_encode($result);
	}

	function list_result_qna()
	{
		$start 	= $_POST['start'];
		$end 	= $_POST['end'];

		$result['data'] = $this->model->list_result_qna($start,$end);
		echo json_encode($result);
	}
	
	function get_result_qna()
	{
		$id_answer 	= $_POST['id_answer'];

		$result['data'] = $this->model->get_result_qna($id_answer);
		echo json_encode($result);
	}

	function get_resume_by_sub()
	{
		$start 	= $_POST['start'];
		$end 	= $_POST['end'];

		$result['data'] = $this->model->get_resume_by_sub($start,$end);
		echo json_encode($result);
	}

	function get_resume_by_question()
	{
		$start 	= $_POST['start'];
		$end 	= $_POST['end'];

		$result['data'] = $this->model->get_resume_by_question($start,$end);
		echo json_encode($result);
	}

}
