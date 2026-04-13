<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_eaf extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->model('eaf/model_dashboard_eaf', 'model_dashboard');
		// $this->load->model('eaf/model_master_jenis_biaya', 'model_master_jenis_biaya');
		$this->load->library("session");
		$this->load->library('FormatJson');

		//cek login

		if ($this->session->userdata('user_id') != "") {
			$user_id = $this->session->userdata('user_id');			
		} else {
			redirect('login', 'refresh');
		}
		
	}

	function index()
	{
		$user_id = $this->session->userdata('user_id');

		if (isset($user_id)) {

			/* ================= DEFAULT PERIODE ================= */

			$data['bulan'] = date('n'); // bulan sekarang
			$data['tahun'] = date('Y'); // tahun sekarang

			$data['content']   = "eaf/dashboard_eaf/index";
			$data['pageTitle'] = "Dashboard EAF";
			$data['css']       = "eaf/dashboard_eaf/css";
			$data['js']        = "eaf/dashboard_eaf/js";

			$this->load->view("layout/main", $data);

		} else {
			redirect("login");
		}
	}

	public function get_budget_overview()
	{
		$y = $this->input->post('tahun');
		$m = $this->input->post('bulan');

		if(!$y){
			$y = date('Y');
		}

		if(!$m){
			$m = date('m');
		}

		/* ================= SUMMARY ================= */
		$result = $this->model_dashboard->get_dashboard($y,$m);

		/* ================= DETAIL BIAYA ================= */
		$detail = $this->model_dashboard->get_dashboard_detail($y,$m);

		/* ================= MAPPING DETAIL ================= */
		$map_detail = [];

		foreach($detail as $d){
			$map_detail[$d->company_kode][] = [
				'nama_biaya'   => $d->nama_biaya,
				'actual_biaya' => $d->actual_biaya
			];
		}

		/* ================= BUILD RESPONSE ================= */
		$data = [];

		foreach($result as $row){

			/* STATUS KPI */
			if($row->persen_mtd > 100){
				$status = 'danger';
				$alert  = '<span class="status-dot danger"></span>';
			}
			elseif($row->persen_mtd >= 60){
				$status = 'warning';
				$alert  = '<span class="status-dot warning"></span>';
			}
			else{
				$status = 'success';
				$alert  = '<span class="status-dot success"></span>';
			}

			$data[] = [
				'company_kode' => $row->company_kode,
				'budget_ytd'   => number_format($row->budget_ytd),
				'budget_mtd'   => number_format($row->budget_mtd),
				'actual_store' => number_format($row->actual_store),
				'persen_mtd'   => $row->persen_mtd,
				'alert'        => $alert,
				'sisa_budget'  => number_format($row->sisa_budget),
				'status_color' => $status,

				/* ⭐ DETAIL UNTUK CARD OVERBUDGET */
				'detail_biaya' =>
					isset($map_detail[$row->company_kode])
					? $map_detail[$row->company_kode]
					: []
			];
		}

		echo json_encode([
			"data" => $data
		]);
	}

	public function get_detail_company()
	{
		$y = $this->input->post('tahun');
		$m = $this->input->post('bulan');

		if(!$y){
			$y = date('Y');
		}

		if(!$m){
			$m = date('m');
		}
		$company = $this->input->post('company_kode');

		$data = $this->model_dashboard->get_detail_company($y, $m, $company);

		echo json_encode([
			'data'=>$data
		]);
	}
	
}
