<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_auth extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function check_hak_akses_2($menu_id)
	{
		$user_id = $this->session->userdata('user_id');
		$role_id = $this->session->userdata('role_id');
		$company_id = $this->session->userdata('company_id');
		$department_id = $this->session->userdata('department_id');
		$designation_id = $this->session->userdata('designation_id');
		$query = "SELECT 
		menu_id 
		FROM trusmi_navigation 
		WHERE menu_id = '$menu_id' 
		AND 
		( 
			FIND_IN_SET('$user_id', user_id) 
			OR FIND_IN_SET('$company_id', company_id)
			OR FIND_IN_SET('$department_id', department_id)
			OR FIND_IN_SET('$designation_id', designation_id)
		)
		AND user_id_blocked NOT IN ('$user_id')
		";
	}

	function cek_auth($username, $password)
	{
		$this->db->select('user_id, employee, username, password, profile_picture, is_active, company_id, department_id, designation_id, jabatan, posisi, user_role_id, contact_no, cutoff');
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$this->db->where('is_active', 1);
		return $this->db->get("view_user");
	}

	function cek_auth_dewa($username)
	{
		$this->db->select('user_id, employee, username, password, profile_picture, is_active, company_id, department_id, designation_id, jabatan, posisi, user_role_id, contact_no, cutoff');
		$this->db->where('username', $username);
		$this->db->where('is_active', 1);
		return $this->db->get("view_user");
	}

	function get_user($id_user)
	{
		$this->db->select('user_id, employee, username, password, profile_picture, is_active, company_id, department_id, designation_id, jabatan, posisi, user_role_id, contact_no, cutoff');
		$this->db->where('user_id', $id_user);
		$this->db->where('is_active', 1);
		return $this->db->get("view_user");
	}

	function get_username_by_user_id($user_id)
	{
		$this->db->select('username');
		$this->db->where('user_id', $user_id);
		$this->db->where('is_active', 1);
		return $this->db->get("view_user");
	}

	function check_hak_akses($menu_url, $user_id)
	{
		$user = $this->db->query("SELECT e.user_role_id AS role_id, e.company_id, e.department_id, e.designation_id, e.user_id FROM xin_employees e WHERE user_id = '$user_id' AND is_active = 1")->row();
		$menu = $this->db->query("SELECT role_id, company_id, department_id, designation_id, user_id, user_id_blocked FROM trusmi_navigation WHERE menu_url = '$menu_url'")->row();
		$role_array = array();
		$company_id_array = array();
		$department_id_array = array();
		$designation_id_array = array();
		$user_id_array = array();
		$user_id_blocked_array = array();
		if (!empty($menu->role_id)) {
			$role_array = explode(",", $menu->role_id);
		}

		if (!empty($menu->company_id)) {
			$company_id_array = explode(",", $menu->company_id);
		}

		if (!empty($menu->department_id)) {
			$department_id_array = explode(",", $menu->department_id);
		}

		if (!empty($menu->designation_id)) {
			$designation_id_array = explode(",", $menu->designation_id);
		}

		if (!empty($menu->user_id)) {
			$user_id_array = explode(",", $menu->user_id);
		}

		if (!empty($menu->user_id_blocked)) {
			$user_id_blocked_array = explode(",", $menu->user_id_blocked);
		}

		if (
			(in_array($user->role_id, $role_array) || in_array($user->company_id, $company_id_array) || in_array($user->department_id, $department_id_array)
				|| in_array($user->designation_id, $designation_id_array)
				|| in_array($user->user_id, $user_id_array)
			) &&
			!in_array($user->user_id, $user_id_blocked_array)
		) {
			return "allowed";
		} else {
			return "not_allowed";
		}
	}

	function cek_tasklist()
	{
		// $user_id = $this->session->userdata('user_id');
		// $query = "SELECT
		// * 
		// FROM
		// 	`view_dashboard_todo` 
		// WHERE
		// 	end_date = CURRENT_DATE 
		// 	AND user_id = $user_id
		// 	AND status_lock = 'Locked'";

		// return $this->db->query($query)->num_rows();

		return [];
	}
}

/* End of file Model_auth.php */
/* Location: ./application/models/Model_auth.php */
