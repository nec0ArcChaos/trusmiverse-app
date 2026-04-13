<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Promotion extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('hr/model_promotion', 'model_promotion');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
        //  User IT
        //  61 Anggi
        //  62 Lutfi
        //  63 Said
        //  64 Lutfiedadi
        //  1161 Fujiyanto
        //  2041 Faisal
        //  2063 Aris
        //  2070 Kania
        //  2969 Ari Fadzri
        $user_it = array(1, 61, 62, 323, 979, 63, 64, 778, 1161, 2041, 2063, 2969, 2969, 2070, 2903, 1426, 321, 6486, 1139); 
        $level = array(1, 2, 3, 4, 5, 10);
        if (in_array($this->session->userdata('user_id'), $user_it) || in_array($this->session->userdata('user_role_id'), $level)) {
        } else {
            $this->session->set_flashdata('no_access', 1);
            redirect('dashboard', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']  = "Perubahan Jabatan";
        $data['css']        = "hr/promotion/css";
        $data['js']         = "hr/promotion/js";
        $data['content']    = "hr/promotion/index";


        $data['get_company']    = $this->model_promotion->get_company()->result();
        $data['get_roles']      = $this->model_promotion->get_roles()->result();
        $data['get_location']      = $this->model_promotion->get_location();
        $data['manager']        = $this->model_promotion->get_manager(2)->row_array();
        $this->load->view('layout/main', $data);
    }

    public function get_department()
    {
        $company_id     = $_POST['company_id'];
        $data           = $this->model_promotion->get_department($company_id)->result();

        echo json_encode($data);
    }

    public function get_employees()
    {
        $company_id     = $_POST['company_id'];
        $data           = $this->model_promotion->get_employees($company_id)->result();

        echo json_encode($data);
    }

    public function get_designation()
    {
        $company_id     = $_POST['company_id'];
        $data           = $this->model_promotion->get_designation($company_id)->result();

        echo json_encode($data);
    }
    public function get_designation_by_dep()
    {
        $company_id     = $_POST['dep_id'];
        $data           = $this->model_promotion->get_designation_by_dep($company_id)->result();

        echo json_encode($data);
    }

    public function get_promotion_list()
    {
        $company_id     = $_POST['company_id'];
        $department_id  = $_POST['department_id'];
        $start          = $_POST['start'];
        $end            = $_POST['end'];

        $data['data']   = $this->model_promotion->get_promotion_list($company_id, $department_id, $start, $end)->result();
        echo json_encode($data);
    }

    public function add_promotion()
    {
        $emp = explode('-', $_POST['employee']);
        $dsg = explode('-', $_POST['designation']);

        $data = array(
            'employee_id'           => $emp[0],
            'last_department_id'    => $emp[1],
            'last_designation_id'   => $emp[2],
            'type'                  => $_POST['type'],
            'company_id'            => $_POST['to_company'],
            'department_id'         => $dsg[0],
            'location_id'           => $dsg[1],
            'designation_id'        => $dsg[2],
            'title'                 => $_POST['title'],
            'promotion_date'        => $_POST['promotion_date'],
            'description'           => $_POST['description'],
            'last_target'           => $_POST['last_target'],
            'added_by'              => $this->session->userdata('user_id'),
            'created_at'            => date('d-m-Y'),
        );

        $result = $this->db->insert('xin_employee_promotions', $data);
        echo json_encode($result);
    }


    public function edit_promotion()
    {
        $data = array(
            'title' => $_POST['title'],
            'promotion_date' => $_POST['date'],
            'description' => $_POST['description'],
        );

        $this->db->where('promotion_id', $_POST['promotion_id']);
        $result = $this->db->update('xin_employee_promotions', $data);

        echo json_encode($result);
    }

    public function delete_promotion()
    {
        $this->db->where('promotion_id', $_POST['promotion_id']);
        $result = $this->db->delete('xin_employee_promotions');

        echo json_encode($result);
    }


    public function approval_promotion()
    {

        $approve = array(
            'status' => $_POST['status'],
            'approve_note' => $_POST['approve_note'],
            'target' => $_POST['target_actual'],
            'approve_by' => $this->session->userdata('user_id'),
            'approve_at' => date('Y-m-d')
        );

        $this->db->where('promotion_id', $_POST['promotion_id']);
        $this->db->limit(1);
        $result = $this->db->update('xin_employee_promotions', $approve);

        if ($result) {
            $response['status'] = true;
            $response['no_kontak'] = $_POST['no_kontak'];

            if ($_POST['status'] == 1) {
                $emp = array(
                    'company_id'        => $_POST['com_id'],
                    'department_id'     => $_POST['dep_id'],
                    'designation_id'    => $_POST['des_id'],
                    'location_id'       => $_POST['loc_id'],
                    'user_role_id'      => $_POST['user_role_id'],
                    'ctm_posisi'        => $_POST['ctm_posisi'],
                );

                $this->db->where('user_id', $_POST['user_id']);
                $this->db->limit(1);
                $response['data_emp'] = $this->db->update('xin_employees', $emp);
            }
        } else {
            $response['status'] = false;
            $response['no_kontak'] = NULL;
        }

        echo json_encode($response);
    }
}
