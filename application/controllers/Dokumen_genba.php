<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dokumen_genba extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('model_dokumen_genba', 'model');
		if ($this->session->userdata('user_id') != "") {
		} else {
			redirect('login', 'refresh');
		}
	}

	function index()
	{
		$data['pageTitle'] 	= "Dokumen Genba";
		$data['css'] 		= "od/css_genba";
		$data['js'] 		= "od/js_genba";
		$data['content'] 	= "od/index_genba";

		$this->load->view('layout/main', $data);
	}

	function listGenba()
	{
		$start = $_POST['start'];
		$end = $_POST['end'];
		$data['data'] = $this->model->getGenba($start, $end);
		echo json_encode($data);
	}

	function detailGenba()
	{
		$id = $_POST['id'];
		$data['data'] = $this->model->getDetailGenba($id);
		echo json_encode($data);
	}

	function add_genba()
	{
		$data['pageTitle'] = 'Dokumen Genba';
		$data['css'] = "od/add_css_genba";
		$data['js'] = "od/js_add_genba";
		$data['content'] = "od/add_genba";
		$data['pic'] = $this->model->getPic();
		$data['company'] = $this->model->getCompany();
		$data['rekomendasi'] = $this->model->getRekomendasi();
		$data['masalah'] = $this->model->getMasalah();
		$this->load->view('layout/main', $data);
	}

	function getDepartemen($id)
	{
		$data = $this->model->getDepartemen($id);
		echo json_encode($data);
	}

	function getNarasumber($id)
	{
		$data = $this->model->getNarasumber($id);
		echo json_encode($data);
	}

	function getDokumen($id)
	{
		$data = $this->model->getDokumen($id);
		echo json_encode($data);
	}

	function getIdGenba()
	{
		$boq = $this->db->query("SELECT * FROM trusmi_genba_od WHERE SUBSTR(created_at,1,10) = SUBSTR(CURDATE(),1,10) ORDER BY id_genba DESC LIMIT 1")->row_array();
		if ($boq == null) {
			$date = substr(date("Ymd"), 2);
			$id = "GNB" . $date . "0001";
		} else {
			$latest = substr($boq['id_genba'], 9);
			$current = sprintf("%04d", (int)$latest + 1);
			$date = substr(date("Ymd"), 2);
			$id = "GNB" . $date . $current;
		}
		return $id;
	}

	function simpanGenba()
	{
		$id_genba = $this->getIdGenba();
		$tanggal = DateTime::createFromFormat('d-m-Y', $_POST['tanggal']);
		$formatted_tanggal = $tanggal ? $tanggal->format('Y-m-d') : null;
		$config['upload_path']   = './assets/files/';
		$config['allowed_types'] = '*';
		$config['max_size']      = 0;
		$config['file_name']     = time();

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file')) {
			echo $this->upload->display_errors();
		} else {
			$files = $this->upload->data();
			$file_upload = $files['raw_name'] . $files['file_ext'];
		}

		$narasumber = implode(',', $_POST['narasumber']);
		$data = array(
			'id_genba'    => $id_genba,
			'pic'         => $_POST['pic'],
			'tanggal'     => $formatted_tanggal,
			'divisi'      => $_POST['divisi'],
			'company_id'  => $_POST['company_id'],
			'department_id' => $_POST['department_id'],
			'narasumber'  => $narasumber,
			'id_dokumen'  => $_POST['id_dokumen'],
			'temuan'      => $_POST['temuan'],
			'analisa'     => $_POST['analisa'],
			'solusi'      => $_POST['solusi'],
			'rekomendasi' => $_POST['rekomendasi'],
			'other'       => $_POST['other'],
			'masalah'     => $_POST['masalah'],
			'keluhan'     => $_POST['keluhan'],
			'keinginan'   => $_POST['keinginan'],
			'file'        => $file_upload,
			'evaluasi'    => $_POST['evaluasi'],
			'created_at'  => date("Y-m-d H:i:s"),
			'created_by'  => $this->session->userdata('user_id')
		);

		$insert = $this->db->insert('trusmi_genba_od', $data);
		if ($insert) {
			$response = ['status' => 200, 'message' => 'Data berhasil disimpan'];
		} else {
			$response = ['status' => 500, 'message' => 'Data gagal disimpan'];
		}
		echo json_encode($response);
	}
}
