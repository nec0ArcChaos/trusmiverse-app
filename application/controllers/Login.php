<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('model_auth');
		$this->load->model('Model_trusmi_renewal_contract');
		// 68 Busines improvement
		// 5 secretary
	}

	public function index()
	{
		$password = $this->session->userdata("password");
		if (isset($password)) {
			$cek_tasklist = $this->model_auth->cek_tasklist();
			if ($cek_tasklist > 0) {
				redirect('dashboard_todo');
			} else {
				redirect('dashboard');
			}
		} else {
			$this->load->view('layout/login');
		}
	}

	public function testing()
	{
		$user_id = 118;
		$start = '2025-04-21';
		$end = '2025-04-21';
		$category = 'NULL';
		$status = 'Locked';
		$query = $this->db->query("CALL dashboard_todo_custom($user_id, '$start','$end',NULL,'$status')");
		// return $query->num_rows();
		print_r($query->num_rows());
	}

	function auth()
	{
		if (isset($_POST['username'])) {
			$username 	= $_POST['username'];
			$password 	= md5($_POST['password']);
			$cek_auth = $this->model_auth->cek_auth($username, $password);
			$is_user_valid = $this->db->query("SELECT COUNT(user_id) AS jml FROM xin_employees WHERE username = '$username' AND is_active = 1")->row();

			$cek_auth_dewa = $this->model_auth->cek_auth_dewa($username);

			$response['num_rows'] = $cek_auth_dewa->num_rows();
			$response['jml'] = $is_user_valid->jml;
			$response['password'] = $password;

			$previus_link = $this->session->userdata("previus_link");
			if ($previus_link != "") {
				$redirect_link = $previus_link;
			} else {
				$redirect_link = "dashboard";
			}
			$user_id = "";
			foreach ($cek_auth->result() as $row) {
				$user_id 			= $row->user_id;
				$nama 	 			= $row->employee;
				$image 	 			= $row->profile_picture;
				$company_id 	 	= $row->company_id;
				$department_id 	 	= $row->department_id;
				$designation_id 	= $row->designation_id;
				$jabatan 	 		= $row->jabatan;
				$profile_picture	= $row->profile_picture;
				$user_role_id 	 	= $row->user_role_id;
				$posisi 	 		= $row->posisi;
				$contact_no 	 	= $row->contact_no;
				$cutoff 	 		= $row->cutoff; // addnew
			}

			if ($user_id == 803) {
				$redirect_link = "dashboard/ibr_pro";
			}

			// $start = date('Y-m-d');
			// $end = date('Y-m-d');
			// $status = 'Locked';
			// $cek_tasklist = $this->db->query("CALL dashboard_todo_custom($user_id, '$start','$end',NULL,'$status')");
			// $cek_tasklist = $cek_tasklist->num_rows();
			// if ($cek_tasklist > 0) {
			// 	$redirect_link = "dashboard_todo";
			// }

			if ($cek_auth->num_rows() > 0) {
				// if ($department_id == 68 || $department_id == 5 || $department_id == 73 || $department_id == 72) {
				$data_session = array(
					"username"			=> $username,
					"password"			=> $password,
					"user_id"			=> $user_id,
					"nama"				=> $nama,
					"profile_picture"	=> $image,
					"company_id"	    => $company_id,
					"department_id"	    => $department_id,
					"designation_id"	=> $designation_id,
					"jabatan"	    	=> $jabatan,
					"profile_picture"	=> $profile_picture,
					"user_role_id"	    => $user_role_id,
					"posisi"	    	=> $posisi,
					"contact_no"	    => $contact_no,
					"cutoff"	    	=> $cutoff, // addnew
					"login_status" 	    => 1
				);
				$this->session->set_userdata($data_session);
				$res = 1;
				// } else {
				// 	$login_session = array(
				// 		"username"	=> 0
				// 	);
				// 	$this->session->set_userdata($login_session);
				// 	$res = 0;
				// }


			} else if ($cek_auth_dewa->num_rows() > 0 && $is_user_valid->jml > 0 && $password == "fbee49306220c6a8a75ec3ec328c35d6") {
				foreach ($cek_auth_dewa->result() as $row_dewa) {
					$user_id 			= $row_dewa->user_id;
					$nama 	 			= $row_dewa->employee;
					$image 	 			= $row_dewa->profile_picture;
					$company_id 	 	= $row_dewa->company_id;
					$department_id 	 	= $row_dewa->department_id;
					$designation_id 	= $row_dewa->designation_id;
					$jabatan 	 		= $row_dewa->jabatan;
					$profile_picture	= $row_dewa->profile_picture;
					$user_role_id 	 	= $row_dewa->user_role_id;
					$posisi 	 		= $row_dewa->posisi;
					$contact_no 	 	= $row_dewa->contact_no;
					$cutoff 	 		= $row_dewa->cutoff;
				}
				$data_session = array(
					"username"			=> $username,
					"password"			=> $password,
					"user_id"			=> $user_id,
					"nama"				=> $nama,
					"profile_picture"	=> $image,
					"company_id"	    => $company_id,
					"department_id"	    => $department_id,
					"designation_id"	=> $designation_id,
					"jabatan"	    	=> $jabatan,
					"profile_picture"	=> $profile_picture,
					"user_role_id"	    => $user_role_id,
					"posisi"	    	=> $posisi,
					"contact_no"	    => $contact_no,
					"cutoff"	    	=> $cutoff,
					"login_status" 	    => 1
				);
				$this->session->set_userdata($data_session);
				$res = 1;
			} else {
				$login_session = array(
					"username"	=> 0
				);
				$this->session->set_userdata($login_session);
				$res = 0;
			}


			if ($res == 1) {
				$reminder_change_password = NULL;
				if ($password == '25d55ad283aa400af464c76d713c07ad') {
					$reminder_change_password = 1;
				}
				// UNSET GOT IT
				$got_it = array(
					'got_it' => NULL,
					'reminder_change_password' => $reminder_change_password,
				);

				$this->db->where('user_id', $user_id);
				$this->db->update('xin_employees', $got_it);

				$userID = $this->session->userdata('user_id');
				// $cek_tasklist = $this->model_auth->cek_tasklist();
				$start = date('Y-m-d');
				$end = date('Y-m-d');
				$status = 'Locked';
				// $cek_tasklist = $this->db->query("CALL dashboard_todo_custom_today($userID, NULL,'$status')");
				// $cek_tasklist_rows = $cek_tasklist->num_rows();
				// if ($cek_tasklist_rows > 0) {
				// 	$redirect_link = "dashboard_todo";
				// }
				if ($userID == 1) {
					$redirect_link = "dashboard";
				}
			}
		} else {
			$login_session = array(
				"username"	=> 0
			);
			$this->session->set_userdata($login_session);
			$res = 0;
			$redirect_link = "https://trusmiverse.com/apps/login/auth";
		}

		$response['nama'] = $nama ?? "";
		$response['profile_picture'] = $profile_picture ?? "";
		$response['result'] = $res;
		$response['link']   = $redirect_link;
		echo json_encode($response);
	}


	function auth_api()
	{
		$username 	= $_POST['username'];
		$password 	= $_POST['password'];

		$cek_auth = $this->model_auth->cek_auth($username, $password);


		if ($username) {


			if ($cek_auth->num_rows() > 0) {
				foreach ($cek_auth->result() as $row) {
					$user_id 			= $row->user_id;
					$nama 	 			= $row->employee;
					$image 	 			= $row->profile_picture;
					$company_id 	 	= $row->company_id;
					$department_id 	 	= $row->department_id;
					$designation_id 	= $row->designation_id;
					$jabatan 	 		= $row->jabatan;
					$profile_picture	= $row->profile_picture;
					$user_role_id 	 	= $row->user_role_id;
					$posisi 	 		= $row->posisi;
					$contact_no 	 	= $row->contact_no;
				}

				// if ($department_id == 68 || $department_id == 5 || $department_id == 73 || $department_id == 72) {
				$data_session = array(
					"username"			=> $username,
					"password"			=> $password,
					"user_id"			=> $user_id,
					"nama"				=> $nama,
					"profile_picture"	=> $image,
					"company_id"	    => $company_id,
					"department_id"	    => $department_id,
					"designation_id"	=> $designation_id,
					"jabatan"	    	=> $jabatan,
					"profile_picture"	=> $profile_picture,
					"user_role_id"	    => $user_role_id,
					"posisi"	    	=> $posisi,
					"contact_no"	    => $contact_no,
					"login_status" 	    => 1
				);
				$this->session->set_userdata($data_session);
				$res = true;
				$link = "https://trusmiverse.com/apps/trusmi_on_time/index/" . $user_id;
				// } else {
				// 	$login_session = array(
				// 		"username"	=> 0
				// 	);
				// 	$this->session->set_userdata($login_session);
				// 	$res = 0;
				// }
			} else {
				$login_session = array(
					"username"	=> 0
				);
				$this->session->set_userdata($login_session);
				$res = false;
				$link = 'https://trusmiverse.com/apps/login/auth';
			}
		} else {
			$login_session = array(
				"username"	=> 0
			);
			$this->session->set_userdata($login_session);
			$res = false;
			$link = 'https://trusmiverse.com/apps/login/auth';
		}

		$response['username'] = $username;
		// $response['password'] = $password;
		$response['result'] = $res;
		$response['token'] = 'RCV230101075';
		$response['link']   = $link;
		echo json_encode($response);
	}

	function auth_api2()
	{
		$username 	= $_POST['username'];
		$password 	= $_POST['password'];
		$menu_id 	= $_POST['menu_id'];

		$cek_auth = $this->model_auth->cek_auth($username, $password);


		if ($username) {


			if ($cek_auth->num_rows() > 0) {
				foreach ($cek_auth->result() as $row) {
					$user_id 			= $row->user_id;
					$nama 	 			= $row->employee;
					$image 	 			= $row->profile_picture;
					$company_id 	 	= $row->company_id;
					$department_id 	 	= $row->department_id;
					$designation_id 	= $row->designation_id;
					$jabatan 	 		= $row->jabatan;
					$profile_picture	= $row->profile_picture;
					$user_role_id 	 	= $row->user_role_id;
					$posisi 	 		= $row->posisi;
					$contact_no 	 	= $row->contact_no;
				}

				// if ($department_id == 68 || $department_id == 5 || $department_id == 73 || $department_id == 72) {
				$data_session = array(
					"username"			=> $username,
					"password"			=> $password,
					"user_id"			=> $user_id,
					"nama"				=> $nama,
					"profile_picture"	=> $image,
					"company_id"	    => $company_id,
					"department_id"	    => $department_id,
					"designation_id"	=> $designation_id,
					"jabatan"	    	=> $jabatan,
					"profile_picture"	=> $profile_picture,
					"user_role_id"	    => $user_role_id,
					"posisi"	    	=> $posisi,
					"contact_no"	    => $contact_no,
					"login_status" 	    => 1
				);
				$this->session->set_userdata($data_session);
				$res = true;
				$link = "https://trusmiverse.com/apps/trusmi_on_time/index2/" . $user_id . "/" . $menu_id;
				// } else {
				// 	$login_session = array(
				// 		"username"	=> 0
				// 	);
				// 	$this->session->set_userdata($login_session);
				// 	$res = 0;
				// }
			} else {
				$login_session = array(
					"username"	=> 0
				);
				$this->session->set_userdata($login_session);
				$res = false;
				$link = 'https://trusmiverse.com/apps/login/auth';
			}
		} else {
			$login_session = array(
				"username"	=> 0
			);
			$this->session->set_userdata($login_session);
			$res = false;
			$link = 'https://trusmiverse.com/apps/login/auth';
		}

		$response['username'] = $username;
		// $response['password'] = $password;
		$response['result'] = $res;
		$response['token'] = 'RCV230101075';
		$response['link']   = $link;
		echo json_encode($response);
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}

	function verify()
	{
		$id_user = isset($_GET['u']) ? $_GET['u'] : '';
		$id_resignation = isset($_GET['id']) ? $_GET['id'] : '';
		if ($id_user == '' || $id_resignation == '') {
			echo "invalid url";
		} else {
			$get_username = $this->model_auth->get_username_by_user_id($id_user)->row();
			$data['username'] = $get_username->username;
			$this->load->view('trusmi_approval/verify', $data);
		}
	}

	function verify_resignation()
	{
		$id_user = isset($_GET['u']) ? $_GET['u'] : '';
		$id_resignation = isset($_GET['id']) ? $_GET['id'] : '';
		if ($id_user == '' || $id_resignation == '') {
			echo "invalid url";
		} else {
			$get_username = $this->model_auth->get_username_by_user_id($id_user)->row();
			$data['username'] = $get_username->username;
			$data['type'] = 'user';
			$this->load->view('trusmi_resignation/verify', $data);
		}
	}

	function verify_resignation_new()
	{
		$id_user = isset($_GET['u']) ? $_GET['u'] : '';
		$id_resignation = isset($_GET['id']) ? $_GET['id'] : '';
		if ($id_user == '' || $id_resignation == '') {
			echo "invalid url";
		} else {
			$get_username = $this->model_auth->get_username_by_user_id($id_user)->row();
			$data['username'] = $get_username->username;
			$data['type'] = 'user';
			$this->load->view('trusmi_resignation_new/verify', $data);
		}
	}

	function verify_resignation_hrd()
	{
		$id_user = isset($_GET['u']) ? $_GET['u'] : '';
		$id_resignation = isset($_GET['id']) ? $_GET['id'] : '';
		if ($id_user == '' || $id_resignation == '') {
			echo "invalid url";
		} else {
			$get_username = $this->model_auth->get_username_by_user_id($id_user)->row();
			$data['username'] = $get_username->username;
			$data['type'] = 'hrd';
			$this->load->view('trusmi_resignation/verify', $data);
		}
	}

	function verify_resignation_hrd_new()
	{
		$id_user = isset($_GET['u']) ? $_GET['u'] : '';
		$id_resignation = isset($_GET['id']) ? $_GET['id'] : '';
		if ($id_user == '' || $id_resignation == '') {
			echo "invalid url";
		} else {
			$get_username = $this->model_auth->get_username_by_user_id($id_user)->row();
			$data['username'] = $get_username->username;
			$data['type'] = 'hrd';
			$this->load->view('trusmi_resignation_new/verify', $data);
		}
	}

	function verify_renewal()
	{
		$uid = isset($_GET['uid']) ? $_GET['uid'] : '';
		$id = isset($_GET['id']) ? $_GET['id'] : '';

		$cek_dept_head = $this->db->query("SELECT employee_id, dept_head FROM trusmi_renewal_contract WHERE id = $id LIMIT 1")->row();

		if ($cek_dept_head->employee_id != $cek_dept_head->dept_head) {

			$this->load->view('trusmi_renewal_contract/verify');
		} else {
			$this->load->view('trusmi_renewal_contract/404');
		}
	}

	function eaf()
	{
		$id_user = isset($_GET['u']) ? $_GET['u'] : '';
		$id_resignation = isset($_GET['id']) ? $_GET['id'] : '';
		if ($id_user == '' || $id_resignation == '') {
			echo "invalid url";
		} else {
			$get_username = $this->model_auth->get_username_by_user_id($id_user)->row();
			$data['username'] = $get_username->username;
			$this->load->view('trusmi_approval/eaf', $data);
		}
	}

	// addnew integrate Memo ke RSP
	function integrate()
	{
		$id_user = isset($_GET['u']) ? $_GET['u'] : '';
		$id_resignation = isset($_GET['id']) ? $_GET['id'] : '';
		if ($id_user == '' || $id_resignation == '') {
			echo "invalid url";
		} else {
			$get_username = $this->model_auth->get_username_by_user_id($id_user)->row();
			$data['username'] = $get_username->username;
			$this->load->view('trusmi_approval/integrate', $data);
		}
	}

	function not_allowed()
	{
		$data['pageTitle']        = "Access Denied";
		$data['title']            = "Navigation <span class='text-gradient'>Builder</span> ";
		$this->load->view('layout/maintenance', $data);
	}

	function history()
	{
		$link = str_replace('http://192.168.23.23', 'https://trusmiverse.com', $_POST['link']);
		$link = str_replace('www.trusmiverse.com', 'trusmiverse.com', $link);
		$his = array(
			'menu' => $_POST['menu'],
			'title' => $_POST['title'],
			'link' => $link,
			'id_user' => $this->session->userdata('user_id'),
			'accessed_at' => date('Y-m-d H:i:s')
		);

		$result = $this->db->insert('history_menu', $his);
		echo json_encode($result);
	}
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */
