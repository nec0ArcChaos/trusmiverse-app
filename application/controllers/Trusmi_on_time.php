<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Trusmi_on_time extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('model_auth');
        // if(get_header('authorization')) jika ada do nothing 
    }

    public function index($id_user)
    {
        $get_user = $this->model_auth->get_user($id_user)->row();
        $user_id = $get_user->user_id;
        $username = $get_user->username;
        $password = $get_user->password;
        $user_id             = $get_user->user_id;
        $nama                  = $get_user->employee;
        $image                  = $get_user->profile_picture;
        $company_id          = $get_user->company_id;
        $department_id          = $get_user->department_id;
        $designation_id     = $get_user->designation_id;
        $jabatan              = $get_user->jabatan;
        $profile_picture    = $get_user->profile_picture;
        $user_role_id          = $get_user->user_role_id;
        $posisi              = $get_user->posisi;
        $contact_no          = $get_user->contact_no;
        $cutoff          = $get_user->cutoff;

        $data_session = array(
            "username"          => $username,
            "password"          => $password,
            "user_id"           => $user_id,
            "nama"              => $nama,
            "profile_picture"   => $image,
            "company_id"        => $company_id,
            "department_id"     => $department_id,
            "designation_id"    => $designation_id,
            "jabatan"           => $jabatan,
            "profile_picture"   => $profile_picture,
            "user_role_id"      => $user_role_id,
            "posisi"            => $posisi,
            "contact_no"        => $contact_no,
            "cutoff"            => $cutoff,
            "login_status"      => 1
        );

        $this->session->set_userdata($data_session);
        $url = base_url('dashboard');
        redirect($url);
        // $data['pageTitle']        = "Dashboard";
        // $data['js']               = "dashboard/js";
        // $data['content']          = "dashboard/index";
        // $this->load->view('layout/main', $data);
    }

     public function index2($id_user, $menu_id)
    {
        $get_user = $this->model_auth->get_user($id_user)->row();
        $user_id = $get_user->user_id;
        $username = $get_user->username;
        $password = $get_user->password;
        $user_id             = $get_user->user_id;
        $nama                  = $get_user->employee;
        $image                  = $get_user->profile_picture;
        $company_id          = $get_user->company_id;
        $department_id          = $get_user->department_id;
        $designation_id     = $get_user->designation_id;
        $jabatan              = $get_user->jabatan;
        $profile_picture    = $get_user->profile_picture;
        $user_role_id          = $get_user->user_role_id;
        $posisi              = $get_user->posisi;
        $contact_no          = $get_user->contact_no;

        $data_session = array(
            "username"            => $username,
            "password"            => $password,
            "user_id"            => $user_id,
            "nama"                => $nama,
            "profile_picture"    => $image,
            "company_id"        => $company_id,
            "department_id"        => $department_id,
            "designation_id"    => $designation_id,
            "jabatan"            => $jabatan,
            "profile_picture"    => $profile_picture,
            "user_role_id"        => $user_role_id,
            "posisi"            => $posisi,
            "contact_no"        => $contact_no,
            "login_status"         => 1
        );

        $this->session->set_userdata($data_session);
        if($menu_id == '' && $menu_id == null){
            $url = base_url('dashboard');
        } else {
            $url_menu = $this->db->query("SELECT * FROM trusmi_navigation WHERE menu_id = '$menu_id'")->row();
            $url = base_url('') . $url_menu->menu_url;
        }
        
        redirect($url);       
    }
}
