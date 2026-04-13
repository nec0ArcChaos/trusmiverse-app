<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Navigation_search extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_navigation', 'model');

        // jika user tidak punya session redirect ke login page
        if ($this->session->userdata('user_id') == "") {
            redirect('login', 'refresh');
        }
    }

    function index()
    {
        $menu_a = $this->model->menu(1);
        $menu_b = $this->model->menu(2);
        $menu_c = $this->model->menu(3);
        $menu_d = $this->model->menu(4); 
        $menu_e = $this->model->menu(5); 


        $role_id = $this->session->userdata("user_role_id");
        $company_id = $this->session->userdata("company_id");
        $department_id = $this->session->userdata("department_id");
        $designation_id = $this->session->userdata("designation_id");
        $user_id = $this->session->userdata("user_id");
        $user_id_blocked = $this->session->userdata("user_id");

        $result = array();

        $no_a = 0;
        foreach ($menu_a as $a) {
            $status_role_id = 0; // not allowed
            if ($a->a_role_id != "") {
                $allowed_a_role_id = explode(",", $a->a_role_id);
                if (in_array($role_id, $allowed_a_role_id)) {
                    $status_role_id = 1; // allowed
                }
            }

            $status_company_id = 0; // not allowed
            if ($a->a_company_id != "") {
                $allowed_a_company_id = explode(",", $a->a_company_id);
                if (in_array($company_id, $allowed_a_company_id)) {
                    $status_company_id = 1; // allowed
                }
            }

            $status_department_id = 0; // not allowed
            if ($a->a_department_id != "") {
                $allowed_a_department_id = explode(",", $a->a_department_id);
                if (in_array($department_id, $allowed_a_department_id)) {
                    $status_department_id = 1; // allowed
                }
            }

            $status_designation_id = 0; // not allowed
            if ($a->a_designation_id != "") {
                $allowed_a_designation_id = explode(",", $a->a_designation_id);
                if (in_array($designation_id, $allowed_a_designation_id)) {
                    $status_designation_id = 1; // allowed
                }
            }

            $status_user_id = 0; // not allowed
            if ($a->a_user_id != "") {
                $allowed_a_user_id = explode(",", $a->a_user_id);
                if (in_array($user_id, $allowed_a_user_id)) {
                    $status_user_id = 1; // allowed
                }
            }

            $status_user_id_blocked = 0; // not allowed
            if ($a->a_user_id_blocked != "") {
                $allowed_a_user_id_blocked = explode(",", $a->a_user_id_blocked);
                if (in_array($user_id_blocked, $allowed_a_user_id_blocked)) {
                    $status_user_id_blocked = 1; // allowed
                }
            }

            if (($status_role_id == 1 || $status_company_id == 1 || $status_department_id == 1 || $status_designation_id == 1 || $status_user_id == 1)
                && $status_user_id_blocked != 1) 
            {
                    if ($a->a_url != "#") {
                        $result[$no_a]['menu'] = $a->a_menu;
                        $result[$no_a]['url'] = $a->a_url;
                        $result[$no_a]['has_child'] = false;
                    }

                    if ($a->a_url == "#") {
                        $result[$no_a]['menu'] = $a->a_menu;
                        $result[$no_a]['url'] = $a->a_url;
                        $result[$no_a]['has_child'] = true;

                        $no_b = 0;
                        $no_b_child = 0;
                        foreach ($menu_b as $b) {
                            $status_role_id_b = 0; // not allowed
                            if ($b->b_role_id != "") {
                                $allowed_b_role_id = explode(",", $b->b_role_id);
                                if (in_array($role_id, $allowed_b_role_id)) {
                                    $status_role_id_b = 1; // allowed
                                }
                            }

                            $status_company_id_b = 0; // not allowed
                            if ($b->b_company_id != "") {
                                $allowed_b_company_id = explode(",", $b->b_company_id);
                                if (in_array($company_id, $allowed_b_company_id)) {
                                    $status_company_id_b = 1; // allowed
                                }
                            }

                            $status_department_id_b = 0; // not allowed
                            if ($b->b_department_id != "") {
                                $allowed_b_department_id = explode(",", $b->b_department_id);
                                if (in_array($department_id, $allowed_b_department_id)) {
                                    $status_department_id_b = 1; // allowed
                                }
                            }

                            $status_designation_id_b = 0; // not allowed
                            if ($b->b_designation_id != "") {
                                $allowed_b_designation_id = explode(",", $b->b_designation_id);
                                if (in_array($designation_id, $allowed_b_designation_id)) {
                                    $status_designation_id_b = 1; // allowed
                                }
                            }

                            $status_user_id_b = 0; // not allowed
                            if ($b->b_user_id != "") {
                                $allowed_b_user_id = explode(",", $b->b_user_id);
                                if (in_array($user_id, $allowed_b_user_id)) {
                                    $status_user_id_b = 1; // allowed
                                }
                            }

                            $status_user_id_blocked_b = 0; // not allowed
                            if ($b->b_user_id_blocked != "") {
                                $allowed_b_user_id_blocked = explode(",", $b->b_user_id_blocked);
                                if (in_array($user_id_blocked, $allowed_b_user_id_blocked)) {
                                    $status_user_id_blocked_b = 1; // allowed
                                }
                            }
                            if (($status_role_id_b == 1 || $status_company_id_b == 1 || $status_department_id_b == 1 || $status_designation_id_b == 1 || $status_user_id_b == 1)
                                && $status_user_id_blocked_b != 1) 
                            {
                                if ($b->b_url != "#" && $b->b_parent_id == $a->a_id) {
                                    $result[$no_a]['child'][$no_b]['menu'] = $b->b_menu;
                                    $result[$no_a]['child'][$no_b]['url'] = $b->b_url;
                                    $result[$no_a]['child'][$no_b]['has_child'] = false;
                                    $no_b++;
                                }

                                if ($b->b_url == "#" && $b->b_parent_id == $a->a_id) {
                                    $result[$no_a]['child'][$no_b_child]['menu'] = $b->b_menu;
                                    $result[$no_a]['child'][$no_b_child]['url'] = $b->b_url;
                                    $result[$no_a]['child'][$no_b_child]['has_child'] = true;

                                    $no_c = 0;
                                    foreach ($menu_c as $c) {
                                        $status_role_id_c = 0; // not allowed
                                        if ($c->c_role_id != "") {
                                            $allowed_c_role_id = explode(",", $c->c_role_id);
                                            if (in_array($role_id, $allowed_c_role_id)) {
                                                $status_role_id_c = 1; // allowed
                                            }
                                        }

                                        $status_company_id_c = 0; // not allowed
                                        if ($c->c_company_id != "") {
                                            $allowed_c_company_id = explode(",", $c->c_company_id);
                                            if (in_array($company_id, $allowed_c_company_id)) {
                                                $status_company_id_c = 1; // allowed
                                            }
                                        }

                                        $status_department_id_c = 0; // not allowed
                                        if ($c->c_department_id != "") {
                                            $allowed_c_department_id = explode(",", $c->c_department_id);
                                            if (in_array($department_id, $allowed_c_department_id)) {
                                                $status_department_id_c = 1; // allowed
                                            }
                                        }

                                        $status_designation_id_c = 0; // not allowed
                                        if ($c->c_designation_id != "") {
                                            $allowed_c_designation_id = explode(",", $c->c_designation_id);
                                            if (in_array($designation_id, $allowed_c_designation_id)) {
                                                $status_designation_id_c = 1; // allowed
                                            }
                                        }

                                        $status_user_id_c = 0; // not allowed
                                        if ($c->c_user_id != "") {
                                            $allowed_c_user_id = explode(",", $c->c_user_id);
                                            if (in_array($user_id, $allowed_c_user_id)) {
                                                $status_user_id_c = 1; // allowed
                                            }
                                        }

                                        $status_user_id_blocked_c = 0; // not allowed
                                        if ($c->c_user_id_blocked != "") {
                                            $allowed_c_user_id_blocked = explode(",", $c->c_user_id_blocked);
                                            if (in_array($user_id_blocked, $allowed_c_user_id_blocked)) {
                                                $status_user_id_blocked_c = 1; // allowed
                                            }
                                        }
                                        if (
                                            ($status_role_id_c == 1 || $status_company_id_c == 1 || $status_department_id_c == 1 || $status_designation_id_c == 1 || $status_user_id_c == 1)
                                            && $status_user_id_blocked_c != 1
                                        ) {
                                            if ($c->c_url != "#" && $c->c_parent_id == $b->b_id) {
                                                $result[$no_a]['child'][$no_b_child]['child']['menu'] = $c->c_menu;
                                                $result[$no_a]['child'][$no_b_child]['child']['url'] = $c->c_url;
                                                $result[$no_a]['child'][$no_b_child]['child']['has_child'] = false;
                                            }

                                            if ($c->c_url == "#" && $c->c_parent_id == $b->b_id) {
                                                $result[$no_a]['child'][$no_b_child]['child']['menu'] = $c->c_menu;
                                                $result[$no_a]['child'][$no_b_child]['child']['url'] = $c->c_url;
                                                $result[$no_a]['child'][$no_b_child]['child']['has_child'] = true;
                                            }
                                        }
                                        $no_c++;
                                    }
                                    $no_b_child++;
                                }
                            }
                        }
                    }
                $no_a++;
            }
        }

        header('Content-type: application/json');
        echo json_encode($result);
    }
}
