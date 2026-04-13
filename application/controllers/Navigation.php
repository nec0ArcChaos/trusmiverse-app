<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Navigation extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_auth', 'm_auth');
        $this->load->model('Model_navigation', 'model');

        // jika user tidak punya session redirect ke login page
        if ($this->session->userdata('user_id') == "") {
            redirect('login', 'refresh');
        }

        // jika user tidak punya akses redirect ke not allowed page
        $user_id = $this->session->userdata("user_id");
        $check_hak_akses = $this->m_auth->check_hak_akses('navigation', $user_id);
        if ($check_hak_akses != "allowed") {
            redirect('forbidden_access', 'refresh');
        }
    }


    function index()
    {
        $data['pageTitle']        = "Navigation";
        $data['title']            = "Navigation <span class='text-gradient'>Builder</span> ";
        $data['js']               = "navigation/js";
        $data['css']              = "navigation/css";
        $data['content']          = "navigation/index";
        $data['menu_a']           = $this->model->menu(1);
        $data['menu_b']           = $this->model->menu(2);
        $data['menu_c']           = $this->model->menu(3);
        $this->load->view('layout/main', $data);
    }

    function dt_navigation()
    {
        $response['data'] = $this->model->dt_navigation();
        echo json_encode($response);
    }

    function get_parent()
    {
        $response['data'] = $this->model->get_parent();
        echo json_encode($response);
    }

    function get_role()
    {
        $response['data'] = $this->model->get_role();
        echo json_encode($response);
    }

    function get_company()
    {
        $response['data'] = $this->model->get_company();
        echo json_encode($response);
    }

    function get_department()
    {
        $response['data'] = $this->model->get_department();
        echo json_encode($response);
    }

    function get_designation()
    {
        $response['data'] = $this->model->get_designation();
        echo json_encode($response);
    }

    function get_user()
    {
        $response['data'] = $this->model->get_user();
        echo json_encode($response);
    }

    function store_navigation()
    {
        $parent_id = $this->input->post('parent_id');
        $level = $this->input->post('level');
        $menu_nm = $this->input->post('menu_nm');
        $menu_url = $this->input->post('menu_url');
        $menu_icon = $this->input->post('menu_icon');
        $role_id = $this->input->post('role_id');
        $company_id = $this->input->post('company_id');
        $department_id = $this->input->post('department_id');
        $designation_id = $this->input->post('designation_id');
        $user_id = $this->input->post('user_id');
        $user_id_blocked = $this->input->post('user_id_blocked');
        $get_no_urut = $this->db->query("SELECT MAX(no_urut) + 1 AS no_urut FROM trusmi_navigation")->row();
        $no_urut = $get_no_urut->no_urut;
        $data = [
            'parent_id' => $parent_id == 0 ? NULL : $parent_id,
            'level' => $level,
            'menu_nm' => $menu_nm,
            'menu_url' => $menu_url == '' ? NULL : $menu_url,
            'menu_icon' => $menu_icon,
            'role_id' => $role_id,
            'company_id' => $company_id,
            'department_id' => $department_id,
            'designation_id' => $designation_id,
            'user_id' => $user_id,
            'user_id_blocked' => $user_id_blocked,
            'no_urut' => $no_urut,
        ];
        $store = $this->db->insert("trusmi_navigation", $data);
        echo json_encode($store);
    }

    function e_store_navigation()
    {
        $menu_id = $this->input->post('menu_id');
        $parent_id = $this->input->post('parent_id');
        $level = $this->input->post('level');
        $menu_nm = $this->input->post('menu_nm');
        $menu_url = $this->input->post('menu_url');
        $menu_icon = $this->input->post('menu_icon');
        $role_id = $this->input->post('role_id');
        $company_id = $this->input->post('company_id');
        $department_id = $this->input->post('department_id');
        $designation_id = $this->input->post('designation_id');
        $user_id = $this->input->post('user_id');
        $user_id_blocked = $this->input->post('user_id_blocked');
        $data = [
            'parent_id' => $parent_id == 0 ? NULL : $parent_id,
            'level' => $level == '' ? NULL : $level,
            'menu_nm' => $menu_nm == '' ? NULL : $menu_nm,
            'menu_url' => $menu_url == '' ? NULL : $menu_url,
            'menu_icon' => $menu_icon == '' ? NULL : $menu_icon,
            'role_id' => $role_id == '' ? NULL : $role_id,
            'company_id' => $company_id == '' ? NULL : $company_id,
            'department_id' => $department_id == '' ? NULL : $department_id,
            'designation_id' => $designation_id == '' ? NULL : $designation_id,
            'user_id' => $user_id == '' ? NULL : $user_id,
            'user_id_blocked' => $user_id_blocked == '' ? NULL : $user_id_blocked,
        ];
        $store = $this->db->where('menu_id', $menu_id)->update("trusmi_navigation", $data);
        echo json_encode($store);
    }

    function update_menu_icon()
    {
        $menu_id = $this->input->post("menu_id");
        $menu_icon = $this->input->post("menu_icon");
        $update = $this->db->where("menu_id", $menu_id)->update("trusmi_navigation", array("menu_icon" => $menu_icon));
        echo json_encode($update);
    }
}
