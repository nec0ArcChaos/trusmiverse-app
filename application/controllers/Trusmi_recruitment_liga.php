<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Trusmi_recruitment_liga extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");
		$this->load->model('Model_trusmi_recruitment_liga', 'model');
        if ($this->session->userdata('user_id') != "") { } else {
			redirect('login', 'refresh');
        }
	}

	function index()
	{
		// ── Filter bulan & tahun (default: bulan ini) ──
		$bulan = $this->input->post('bulan') ?: date('m');
		$tahun = $this->input->post('tahun') ?: date('Y');
		$company_id = $this->input->post('company_id') ?: '';

		// ── Query data dari model ──
		$data['unit_summary']      = $this->model->get_unit_summary($bulan, $tahun, $company_id);
		$data['pic_performance']   = $this->model->get_pic_performance($bulan, $tahun, $company_id);
		$data['open_positions']    = $this->model->get_open_positions($bulan, $tahun, $company_id);
		$data['funnel_detail']     = $this->model->get_funnel_detail($bulan, $tahun, $company_id);
		$data['kebutuhan_detail']  = $this->model->get_kebutuhan_detail_per_pic($bulan, $tahun, $company_id);
		$data['pemenuhan_detail']  = $this->model->get_pemenuhan_detail_per_pic($bulan, $tahun, $company_id);
		$data['frck_done_summary'] = $this->model->get_frck_done_summary($bulan, $tahun, $company_id);
		$data['company_list'] = $this->model->get_company_list();
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['company_id']   = $company_id;
		$data['content'] 	= "trusmi_recruitment_liga/index";
		$data['pageTitle'] 	= "Dashboard Recruitment LIGA";
		$data['css'] 		= "trusmi_recruitment_liga/css";
		$data['js'] 		= "trusmi_recruitment_liga/js";

		$this->load->view("layout/main", $data);
	}

	
}
