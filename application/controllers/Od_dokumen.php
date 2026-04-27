<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Od_dokumen extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('model_od_dokumen', 'model');
		$this->load->model('model_od_review', 'review');
		if ($this->session->userdata('user_id') != "") {
		} else {
			redirect('login', 'refresh');
		}
	}

	function index()
	{
		$data['pageTitle'] = "Dokumen OD";
		$data['css']       = "od/css_dokumen";
		$data['js']        = "od/js_dokumen";
		$data['content']   = "od/index_dokumen";

		$user = $this->model->data_user($this->session->userdata('user_id'));

		$data['user'] = [];
		foreach ($user as $items) {
			$value = [
				'user_id'       => $this->hashApplicantId($items->user_id),
				'employee_name' => $items->employee,
				'contact_no'    => $items->contact_no
			];
			$data['user'] = $value;
		}

		$data['companies']       = $this->model->get_companies()->result();
		$data['get_departments'] = $this->model->get_departments(0)->result();

		$this->load->view('layout/main', $data);
	}

	function form_add()
	{
		$data['pageTitle'] = "Tambah Dokumen OD";
		$data['css']       = "od/css_form_dokumen";
		$data['js']        = "od/js_form_dokumen";
		$data['content']   = "od/form_dokumen";

		$data['companies']  = $this->model->get_companies()->result();
		$data['roles']      = $this->db->where_not_in('role_id', [1, 11, 12, 13, 14])
			->get('xin_user_roles')->result();
		$data['master']     = $this->model->get_master_od()->result();
		$data['approvals']  = $this->model->get_approval_masters()->result();

		$this->load->view('layout/main', $data);
	}

	public function hashApplicantId($applicant_id)
	{
		$arr_applicant_id = str_split($applicant_id, 1);
		$hash = $this->generateRandomString();
		for ($i = 0; $i < COUNT($arr_applicant_id); $i++) {
			$hash .= $arr_applicant_id[$i];
			$hash .= $this->generateRandomString();
		}
		return $hash;
	}

	function generateRandomString($length = 2)
	{
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[random_int(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	function get_review($id_od)
	{
		$data['data'] = $this->review->get_review($id_od);
		echo json_encode($data);
	}

	function get_pic($id)
	{
		$user = $this->model->get_pic($id);
		$data = [];
		foreach ($user as $items) {
			$value = [
				'user_id'       => $this->hashApplicantId($items->user_id),
				'employee_name' => $items->employee_name,
				'contact_no'    => $items->contact_no
			];
			$data[] = $value;
		}
		echo json_encode($data);
	}

	function get_employees($company_id)
	{
		$data = $this->model->get_employees($company_id)->result();
		echo json_encode($data);
	}

	function get_departments($company_id)
	{
		$data = $this->model->get_departments($company_id)->result();
		echo json_encode($data);
	}

	function get_designations($department_id)
	{
		$data = $this->model->get_designations($department_id)->result();
		echo json_encode($data);
	}

	function insert_job_profile()
	{
		$judul = $this->input->post('judul');
		$url   = $this->generate_unique_slug($judul);
		$data['insert'] = $this->model->insert_job_profile($url);
		echo json_encode($data);
	}

	function update_job_profile()
	{
		$data['update'] = $this->model->update_job_profile();
		echo json_encode($data);
	}

	function data_od($start, $end, $department_id)
	{
		$data['data'] = $this->model->data_od($start, $end, $department_id)->result();
		echo json_encode($data);
	}

	function get_od()
	{
		$id_od = $_POST['id_od'];
		$data = $this->model->data_od(null, null, null, $id_od)->result();
		echo json_encode($data);
	}

	function delete_od()
	{
		$data['delete'] = $this->model->delete_od();
		echo json_encode($data);
	}

	function generate_unique_slug($judul)
	{
		$base_slug = strtolower($judul);
		$base_slug = str_replace(' ', '-', $base_slug);
		$base_slug = preg_replace('/[^a-z0-9\-]/', '', $base_slug);
		$base_slug = preg_replace('/-+/', '-', $base_slug);
		$base_slug = trim($base_slug, '-');

		if (empty($base_slug)) {
			$base_slug = 'od-document';
		}

		$slug    = $base_slug;
		$counter = 2;
		while (true) {
			$this->db->where("SUBSTRING_INDEX(url, '/', -1) =", $slug);
			$this->db->from('trusmi_t_od');
			if ($this->db->count_all_results() === 0) break;
			$slug = $base_slug . '_' . $counter++;
		}

		return date('Y-m-d') . '/' . $slug;
	}

	function get_approvals_json()
	{
		$rows = $this->model->get_approval_masters()->result();
		$data = [];
		foreach ($rows as $row) {
			$data[] = [
				'id'               => $row->id_approval,
				'nama'             => $row->nama,
				'nama_diverifikasi' => $row->diverifikasi ?? '',
				'nama_disetujui'   => $row->disetujui ?? '',
				'nama_mengetahui'  => $row->mengetahui ?? '',
			];
		}
		echo json_encode($data);
	}

	function get_no_doc()
	{
		$doc_type_id   = $_POST['doc_type_id'];
		$div_id        = $_POST['div_id'];
		$company_id    = $_POST['company_id'];
		$department_id = $_POST['department_id'];
		$no_doc = $this->model->get_no_doc($doc_type_id, $div_id, $company_id, $department_id);
		$max_no_doc = $this->model->max_no_doc($department_id);

		if (isset($no_doc)) {
			foreach ($no_doc as $row) {
				$no_dok = $row->no_doc . $max_no_doc;
			}
		}
		echo json_encode($no_dok ?? null);
	}
}
