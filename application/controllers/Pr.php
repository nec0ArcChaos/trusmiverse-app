<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Pr extends CI_Controller
{
	// Controller Khusus Print
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");
		$this->load->model('Model_mom', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            $id_mom = $this->uri->segment(3);
            $link = array(
                'previus_link'  => 'pr/mom/' . $id_mom,
            );
            $this->session->set_userdata($link);
            redirect('login', 'refresh');
        }
	}

	function mom_old($id)
	{
		$data['header']		= $this->model->print_header($id);
		$data['peserta']	= $this->model->print_peserta($id);
		$data['issue']		= $this->model->print_issue($id);

		$this->load->view("mom/print/print", $data);

	}

	function mom($id)
	{
		$data['header']		= $this->model->print_header($id);
		$data['peserta']	= $this->model->print_peserta($id);
		$data['issue']		= $this->model->print_issue($id);

		// $data['karyawan']	= $this->model->get_employee();
		$data['pic']		= $this->model->get_employee();
		$data['kategori']	= $this->db->query("SELECT * FROM mom_kategori WHERE id IN (1,8,9,10)")->result();
		$data['grdsi']		= $this->model->get_grd_si();
		$data['level']		= $this->model->get_level();
		$data['total']		= $this->model->get_total_kategori();
		$data['department']	= $this->model->get_department();
		// $data['project']	= $this->model->get_project();
		$data['project']	= $this->db->query("SELECT divisi AS project, divisi AS id_project FROM `grd_m_so` GROUP BY divisi")->result();;
		$data['pekerjaan']	= $this->db->query("SELECT id, pekerjaan FROM hris.m_pekerjaan;")->result();

		$this->load->view("mom/print/print_new", $data);

	}

	function mom_dev($id)
	{
		$data['header']		= $this->model->print_header($id);
		$data['peserta']	= $this->model->print_peserta($id);
		$data['issue']		= $this->model->print_issue($id);

		$this->load->view("mom/print/print_dev", $data);
	}

}
