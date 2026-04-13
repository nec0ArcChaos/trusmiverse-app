<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		// $this->load->model('model1');
		$this->load->model('eaf/model_report', 'model_report');
		$this->load->library("session");
		$this->load->library('FormatJson');

		//cek login
		$username = $this->session->userdata("username");
		$password = $this->session->userdata("password");
		$id_user  = $this->session->userdata("user_id");

		$user_id			= $this->session->userdata('user_id');
		if (isset($user_id)) {
			// 		//do nothing
		} else {
			redirect("login");
		}
	}

	function index()
	{
		$data['content'] 		= "eaf/report/index";
		$data['pageTitle'] 	= "Report Budget";
		$data['css'] 		= "eaf/report/css";
		$data['js'] 		= "eaf/report/js";
		date_default_timezone_set('Asia/Jakarta');
		$tanggal = date("Y-m-d  H:i:s");
		$month = date("m", strtotime($tanggal));
		$year = date("Y", strtotime($tanggal));
		$data['month'] = $month;
		$data['year'] = $year;

		$this->load->view("layout/main", $data);
	}

	function data_report_budget()
	{
		$id_user 	= $this->session->userdata('user_id');
		$id_div 	= $this->session->userdata('id_divisi');
		$y = $_POST['year'];
		$m = $_POST['month'];

		$data['data'] = $this->model_report->report($y, $m)->result();
		echo json_encode($data);
	}

	function detail_budget()
	{
		$id_biaya = $_POST['id_biaya'];
		$y = $_POST['year'];
		$m = $_POST['month'];

		$data['data'] = $this->model_report->detail_budget($id_biaya, $y, $m)->result();
		echo json_encode($data);
	}

	function report($id_kategori, $tipe = null)
	{

		$data['content'] 		= "eaf/report/report";

		if ($id_kategori == 17) {
			$data['pageTitle'] 	= "Report Reimburse";
		} else {
			$data['pageTitle'] 	= "Report Pembawaan";
		}

		$data['id_kategori'] = $id_kategori;
		$data['tipe'] = $tipe;

		$data['css'] 		= "eaf/report/css";
		$data['js'] 		= "eaf/report/report_js";

		$this->load->view("layout/main", $data);
	}

	function data_report_eaf()
	{

		$stardate 		= $_POST['datestart'];
		$enddate 		= $_POST['dateend'];
		$id_kategori 	= $_POST['id_kategori'];
		$tipe 			= $_POST['tipe'];

		$data['data'] = $this->model_report->report_eaf($stardate, $enddate, $id_kategori, $tipe)->result();
		echo json_encode($data);
	}

	// rekap budget user

	function rekap_budget_user()
	{
		$data['content'] 		= "eaf/report/rekap_by_user";
		$data['pageTitle'] 	= "Report Budget by User";
		$data['css'] 		= "eaf/report/css";
		$data['js'] 		= "eaf/report/js";
		date_default_timezone_set('Asia/Jakarta');
		$tanggal = date("Y-m-d  H:i:s");
		$month = date("m", strtotime($tanggal));
		$year = date("Y", strtotime($tanggal));
		$data['month'] = $month;
		$data['year'] = $year;
		$id_user  = $this->session->userdata('user_id');

		$this->load->view("layout/main", $data);
	}

	// report budget by user

	function data_rb_user()
	{
		$id_user 	= $this->session->userdata('user_id');
		$id_div 	= $this->session->userdata('id_divisi');
		$y = $_POST['year'];
		$m = $_POST['month'];
		$data['id_user'] = $id_user;

		$data['data'] = $this->model_report->report_user($y, $m, $id_user)->result();
		echo json_encode($data);
	}



	// // daily report
	// function daily_report()
	// {
	// 	$data['view'] 		= "eaf/report/daily_report";
	// 	$data['pageTitle'] 	= "Daily Report";
	// 	$data['css'] 		= "eaf/report/css";
	// 	$data['js'] 		= "eaf/report/js";
	// 	// date_default_timezone_set('Asia/Jakarta');
	// 	// $tanggal = date("Y-m-d  H:i:s");
	// 	// $month = date("m", strtotime($tanggal));
	// 	// $year = date("Y", strtotime($tanggal));
	// 	// $data['month'] = $month;
	// 	// $data['year'] = $year;

	// 	$this->load->view("main", $data);
	// }

	// function data_daily()
	// {
	// 	$start		 	= $_POST['start'];
	// 	$end		 	= $_POST['end'];
	// 	$data['start']	= $_POST['start'];
	// 	$data['end']	= $_POST['end'];
	// 	$data['daily']	= $this->model_report->data_daily($start, $end)->row_array();

	// 	$this->load->view('eaf/report/data_daily', $data);
	// }

	// function data_daily_item()
	// {
	// 	$start		 	= $_POST['start'];
	// 	$end		 	= $_POST['end'];
	// 	$kategori		= $_POST['kategori'];
	// 	$status		 	= $_POST['status'];
	// 	$data['data'] 	= $this->model_report->data_daily_item($start, $end, $kategori, $status)->result();

	// 	echo json_encode($data);
	// }

	function report_daily()
	{
		$data['pageTitle'] 	= "Report Harian EAF";
		$data['content'] 		= "eaf/report/report_daily";
		$data['css'] 		= "eaf/report/css";
		$data['js'] 		= "eaf/report/report_daily_js";

		$this->load->view("layout/main", $data);
	}

	function data_daily()
	{
		$start		 	= $_POST['start'];
		$end		 	= $_POST['end'];
		$data['start']	= $_POST['start'];
		$data['end']	= $_POST['end'];

		// $start		 	= '2024-10-01';
		// $end		 	= '2024-10-31';
		// $data['start']	= '2024-10-01';
		// $data['end']	= '2024-10-31';

		$data['daily']	= $this->model_report->data_daily($start, $end)->row_array();

		$this->load->view('eaf/report/data_daily', $data);
	}

	function data_detail_daily()
	{
		$tipe 		= $_POST['tipe'];
		$kategori 	= $_POST['kategori'];
		$status 	= $_POST['status'];
		$start 		= $_POST['start'];
		$end 		= $_POST['end'];
		$tgl 		= $_POST['tgl'];
		$company 	= $_POST['company'];

		$data['data'] = $this->model_report->data_detail_daily($tipe, $kategori, $status, $start, $end, $tgl, $company)->result();

		echo json_encode($data);
	}

	function data_daily_item()
	{
		$start		 	= $_POST['start'];
		$end		 	= $_POST['end'];
		$kategori		= $_POST['kategori'];
		$status		 	= $_POST['status'];
		$data['data'] 	= $this->model_report->data_daily_item($start, $end, $kategori, $status)->result();

		echo json_encode($data);
	}

	function data_daily_resume()
	{
		$start		 	= $_POST['start'];
		$end		 	= $_POST['end'];
		$data['data'] 	= $this->model_report->data_daily_resume($start, $end)->result();

		echo json_encode($data);
	}
}
