<?php
// Trusmi History Lock Absen
// Created At : 12-05-2023
defined('BASEPATH') or exit('No direct script access allowed');
class Trusmi_renewal_contract_ade extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_trusmi_renewal_contract_ade', 'model');
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
        // $user_it = array(1, 61, 62, 63, 64, 1161, 2041, 2063, 2969, 2969, 2070);
        // if (in_array($this->session->userdata('user_id'), $user_it)) {
        // } else {
        //     $this->session->set_flashdata('no_access', 1);
        //     redirect('dashboard', 'refresh');
        // }
    }

    public function index()
    {
        $data['pageTitle']        = "Renewal Contract";
        $data['css']              = "trusmi_renewal_contract/css";
        $data['js']               = "trusmi_renewal_contract/js_ade";
        $data['content']          = "trusmi_renewal_contract/index_ade";
        // $user_id = $this->session->userdata('user_id');
        // var_dump($user_id);
        // die();
        $this->load->view('layout/main', $data);
    }

    function list_renewal()
    {
        $list_renewal = $this->model->list_renewal();
        $data['data'] = $list_renewal['data'];
        $data['query'] = $list_renewal['query'];
        echo json_encode($data);
    }

    function detail_renewal()
    {
        $id = $_POST['id'];
        $detail_renewal = $this->model->detail_renewal($id);
        if ($detail_renewal->num_rows() > 0) {
            $data['status'] = true;
            $data['data'] = $detail_renewal->row();
        } else {
            $data['status'] = false;
            $data['data'] = $detail_renewal->row();;
        }
        echo json_encode($data);
    }

    function verify()
    {
        $data['pageTitle']        = "T-renewal_contract";
        $data['css']              = "trusmi_renewal_contract/css";
        $data['content']          = "trusmi_renewal_contract/verify_renewal_ade";
        $data['js']               = "trusmi_renewal_contract/verify_renewal_js_ade";

        $id = $_GET['id'];
        $data['data'] = $this->model->data_renewal($id);

        // addnew
        $data['dt_penilaian_subjektif'] = $this->model->data_penilaian_subjektif($id);
        // print_r($data); die;

        $this->load->view('layout/main', $data);
    }

    public function save_renewal()
    {
        // addnew
        if (!empty($_FILES['file_kpi']['name'])) { // Jika company nya RSP pasti upload file KPI
            $config['upload_path']   = './uploads/trusmi_renewal/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|png';
            // $config['allowed_types'] = '*';
            $new_name = 'file_kpi_' . time();
            $config['file_name']     = $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file_kpi')) {
                $response['upload'] = 'error';
                $response['error_upload'] = array('error' => $this->upload->display_errors());
                // $file_name = $this->upload->display_errors();
                $id = $_POST['id'];

            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data['upload_data']['file_name'];

                $response['upload'] = 'success';

                $renewal = array(
                    'status' => $_POST['status'],
                    'feedback' => $_POST['feedback'],
                    'renewal' => $_POST['lama_kontrak'],
                    // addnew
                    'appropriate' => (isset($_POST['masih_sesuai'])) ? $_POST['masih_sesuai'] : null,
                    'file_kpi' => $file_name,

                    'feedback_by' => $_SESSION['user_id'],
                    'feedback_at' => date('Y-m-d H:i:s'),
                );

                $id = $_POST['id'];
                $this->db->where('id', $id);
                $response['update'] = $this->db->update('trusmi_renewal_contract', $renewal);

                // $company_id = $_POST['company_id'];
                // if ($company_id == 2) {
                    $penilaian_subjektif = array(
                        'id_renewal' => $id,
                        'proaktif_belajar' => $_POST['rating_proaktif_belajar'],
                        'proaktif_evaluasi' => $_POST['rating_proaktif_evaluasi'],
                        'proaktif_adaptasi' => $_POST['rating_proaktif_adaptasi'],
                        'pembelajar_berani' => $_POST['rating_pembelajar_berani'],
                        'pembelajar_berjuang' => $_POST['rating_pembelajar_berjuang'],
                        'pembelajar_melakukan' => $_POST['rating_pembelajar_melakukan'],
                        'energi_harmonis' => $_POST['rating_energi_harmonis'],
                        'energi_motivasi' => $_POST['rating_energi_motivasi'],
                        'energi_tauladan' => $_POST['rating_energi_tauladan'],
                        'internal_percepatan' => $_POST['rating_internal_percepatan'],
                        'internal_disiplin' => $_POST['rating_internal_disiplin'],
                    );
                    $response['insert_penilaian'] = $this->db->insert('t_penilaian_subjektif_renewal', $penilaian_subjektif);
                // }
            }
        } else {
            // $file_name = "";

            $renewal = array(
                'status' => $_POST['status'],
                'feedback' => $_POST['feedback'],
                'renewal' => $_POST['lama_kontrak'],
                // addnew
                // 'appropriate' => (isset($_POST['masih_sesuai'])) ? $_POST['masih_sesuai'] : null,
                // 'file_kpi' => $file_name,

                'feedback_by' => $_SESSION['user_id'],
                'feedback_at' => date('Y-m-d H:i:s'),
            );

            $id = $_POST['id'];
            $this->db->where('id', $id);
            $response['update'] = $this->db->update('trusmi_renewal_contract', $renewal);
        }


        $response['employee'] = $this->model->data_renewal($id);

        echo json_encode($response);
    }

    // JUST TEST
    public function test_save_renewal()
    {
        echo $_SESSION['user_id'];
        echo '<br>';
        die('test save renewal..');
        // addnew
        if (!empty($_FILES['file_kpi']['name'])) { // Jika company nya RSP pasti upload file KPI
            $config['upload_path']   = './uploads/trusmi_renewal/';
            // $config['allowed_types'] = 'gif|jpg|png|jpeg|png';
            $config['allowed_types'] = '*';
            $new_name = 'file_kpi_' . time();
            $config['file_name']     = $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file_kpi')) {
                $response['upload'] = 'error';
                $response['error_upload'] = array('error' => $this->upload->display_errors());
                // $file_name = $this->upload->display_errors();
                $id = $_POST['id'];
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data['upload_data']['file_name'];

                $response['upload'] = 'success';

                $renewal = array(
                    'status' => $_POST['status'],
                    'feedback' => $_POST['feedback'],
                    'renewal' => $_POST['lama_kontrak'],
                    // addnew
                    'appropriate' => (isset($_POST['masih_sesuai'])) ? $_POST['masih_sesuai'] : null,
                    'file_kpi' => $file_name,

                    'feedback_by' => $_SESSION['user_id'],
                    'feedback_at' => date('Y-m-d H:i:s'),
                );

                $id = $_POST['id'];
                $this->db->where('id', $id);
                $response['update'] = $this->db->update('trusmi_renewal_contract', $renewal);

                // $company_id = $_POST['company_id'];
                // if ($company_id == 2) {
                $penilaian_subjektif = array(
                    'id_renewal' => $id,
                    'proaktif_belajar' => $_POST['rating_proaktif_belajar'],
                    'proaktif_evaluasi' => $_POST['rating_proaktif_evaluasi'],
                    'proaktif_adaptasi' => $_POST['rating_proaktif_adaptasi'],
                    'pembelajar_berani' => $_POST['rating_pembelajar_berani'],
                    'pembelajar_berjuang' => $_POST['rating_pembelajar_berjuang'],
                    'pembelajar_melakukan' => $_POST['rating_pembelajar_melakukan'],
                    'energi_harmonis' => $_POST['rating_energi_harmonis'],
                    'energi_motivasi' => $_POST['rating_energi_motivasi'],
                    'energi_tauladan' => $_POST['rating_energi_tauladan'],
                    'internal_percepatan' => $_POST['rating_internal_percepatan'],
                    'internal_disiplin' => $_POST['rating_internal_disiplin'],
                );
                $response['insert_penilaian'] = $this->db->insert('t_penilaian_subjektif_renewal', $penilaian_subjektif);
                // }
            }
        } else {
            // $file_name = "";

            $renewal = array(
                'status' => $_POST['status'],
                'feedback' => $_POST['feedback'],
                'renewal' => $_POST['lama_kontrak'],
                // addnew
                // 'appropriate' => (isset($_POST['masih_sesuai'])) ? $_POST['masih_sesuai'] : null,
                // 'file_kpi' => $file_name,

                'feedback_by' => $_SESSION['user_id'],
                'feedback_at' => date('Y-m-d H:i:s'),
            );

            $id = $_POST['id'];
            $this->db->where('id', $id);
            $response['update'] = $this->db->update('trusmi_renewal_contract', $renewal);
        }


        $response['employee'] = $this->model->data_renewal($id);

        echo json_encode($response);
    }

    function insert_manual_renewal_contract($user_id)
    {

        $value = $this->model->data_perpanjangan_kontrak($user_id);
        $employee_id = $value->user_id;
        $query = "SELECT COALESCE(MAX(id),'') AS id FROM hris.trusmi_renewal_contract WHERE employee_id = $employee_id AND `status` IS NULL LIMIT 1";
        $cek_renewal_exist = $this->db->query($query)->row_array();

        if ($cek_renewal_exist['id'] == '') { // 0 : Belum ada, maka insert
            $renewal = array(
                'employee_id'   => $value->user_id,
                'contract_end'  => $value->habis_kontrak,
                'deadline'      => $value->deadline,
                'dept_head'     => $value->head_id,
                'created_at'    => date('Y-m-d H:i:s'),
                'created_first_at'    => date('Y-m-d H:i:s'),
            );
            $response['renewal'] = $this->db->insert('hris.trusmi_renewal_contract', $renewal);
        } else { // sudah ada, maka update

            $renewal = array(
                'contract_end'  => $value->habis_kontrak,
                'deadline'      => $value->deadline,
                'dept_head'     => $value->head_id,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            );
            $this->db->where('employee_id', $value->user_id);
            $response['renewal'] = $this->db->update('hris.trusmi_renewal_contract', $renewal);
        }

        $response['data'] = $this->db->query($query)->row_array();

        return $response;
    }

    // addnew
    public function list_contract_new()
    {
        $data['pageTitle']        = "Contract New";
        $data['css']              = "trusmi_renewal_contract/css";
        $data['js']               = "trusmi_renewal_contract/list_contract_js";
        $data['content']          = "trusmi_renewal_contract/list_contract";

        $this->load->view('layout/main', $data);
    }

    function dt_contract_new()
    {
        $list_renewal = $this->model->dt_contract_new();
        $data['data'] = $list_renewal['data'];
        $data['query'] = $list_renewal['query'];
        echo json_encode($data);
    }
}
