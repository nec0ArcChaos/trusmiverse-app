<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Parameter extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->model('eaf/model_parameter', 'model_parameter');
		$this->load->model('eaf/model_master_jenis_biaya', 'model_master_jenis_biaya');

		$this->load->library("session");
		$this->load->library('FormatJson');

		//cek login
		// $username = $this->session->userdata("username");
		// $password = $this->session->userdata("password");
		// $id_user  = $this->session->userdata("id_user");

		// if ($cek_auth > 0) {
		// 	//cek hak navigasi
		// 	$access 	= 14;
		// 	$cek_status = $this->model1->cek_status_navigasi($id_user, $access);

		// 	if ($cek_status == '0') {
		// 		redirect("access_denied");
		// 	} else {
		// 		//do nothing
		// 	}
		// } else {
		// 	redirect("login");
		// }
	}

	function index()
	{
		$user_id			= $this->session->userdata('user_id');
		if(isset($user_id)){

			$data['content'] 		= "eaf/parameter/index";
			$data['pageTitle'] 		= "Parameter Akses Menu";
			$data['css'] 			= "eaf/parameter/css";
			$data['js'] 			= "eaf/parameter/js";
			$data['list_menu']		= $this->model_parameter->list_menu()->result();
			$data['list_karyawan']		= $this->model_parameter->data_karyawan()->result();
			$data['list_fitur']		= $this->model_parameter->list_fitur()->result();

			$this->load->view("layout/main", $data);
		} else {
			redirect("login");
		}
	}

	function dt_akses_menu()
	{
		$data['data'] = $this->model_parameter->dt_akses_menu()->result();
		echo json_encode($data);
	}

	function data_karyawan()
	{
		$data = $this->model_parameter->data_karyawan($company_id)->result();
		echo json_encode($data);
	}

	function insert_akses_menu()
	{
		$menu_id  		= $_POST['menu_id'];
		$user  		= $_POST['user'];

		$query = "SELECT menu_id, menu_nm,
					nav.user_id AS list_user_id,
					em.user_id AS id_user,
					CONCAT( em.first_name, ' ', em.last_name ) AS employee_name
					FROM 
					xin_employees em
					LEFT JOIN trusmi_navigation nav ON FIND_IN_SET(em.user_id,nav.user_id)
					WHERE nav.menu_id IN ($menu_id) AND em.user_id = $user ";
		$cek_akses = $this->db->query($query)->row_array();
		if($cek_akses['id_user'] == $user ){
			$data['data_nav'] = '';
			$data['msg'] = 'User sudah punya akses';
			$data['status'] = false;
		} else {
			$query2 = "SELECT menu_id, menu_nm,
					nav.user_id AS list_user_id					
					FROM 
					trusmi_navigation nav
					WHERE nav.menu_id IN ($menu_id)";
			$cek_akses2 = $this->db->query($query2)->row_array();

			$data_update = array(
				'user_id'  			=> $cek_akses2['list_user_id'] . ',' . $user,
			);

			$this->db->where('menu_id', $menu_id);
			$data['update_nav'] = $this->db->update('trusmi_navigation', $data_update);
			$data['data_nav'] = $data_update;
			$data['msg'] = 'success';
			$data['status'] = true;

		}

		echo json_encode($data);
	}

	function dt_akses_fitur()
	{
		$data['data'] = $this->model_parameter->dt_akses_fitur()->result();
		echo json_encode($data);
	}

	function insert_akses_fitur()
	{
		$fitur_id  		= $_POST['fitur_id'];
		$user  		= $_POST['user2'];

		$query = "SELECT
					id AS menu_id,
					access AS menu_nm,
					nav.user_id AS list_user_id,
					em.user_id AS id_user,
					CONCAT( em.first_name, ' ', em.last_name ) AS employee_name 
				FROM
					xin_employees em
					LEFT JOIN e_eaf.e_parameter nav ON FIND_IN_SET( em.user_id, nav.user_id ) 
				WHERE
					nav.id IN ( $fitur_id ) 
					AND em.user_id = $user ";
		$cek_akses = $this->db->query($query)->row_array();
		if($cek_akses['id_user'] == $user ){
			$data['data_nav'] = '';
			$data['msg'] = 'User sudah punya akses';
			$data['status'] = false;
		} else {
			$query2 = "SELECT id AS menu_id, access AS menu_nm,
					nav.user_id AS list_user_id					
					FROM 
					e_eaf.e_parameter nav
					WHERE nav.id IN ($fitur_id)";
			$cek_akses2 = $this->db->query($query2)->row_array();

			$data_update = array(
				'user_id'  			=> $cek_akses2['list_user_id'] . ',' . $user,
			);

			$this->db->where('id', $fitur_id);
			$data['update_nav'] = $this->db->update('e_eaf.e_parameter', $data_update);
			$data['data_nav'] = $data_update;
			$data['msg'] = 'success';
			$data['status'] = true;

		}

		echo json_encode($data);
	}

	
}
