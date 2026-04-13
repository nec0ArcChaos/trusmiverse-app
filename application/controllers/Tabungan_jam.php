<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tabungan_jam extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("Model_tabungan_jam", "model");
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $data['pageTitle']        = "Resume Tabungan Jam";
        $data['js']               = "tabungan_jam/js";
        $data['css']              = "tabungan_jam/css";
        $data['content']          = "tabungan_jam/index";
        $this->load->view('layout/main', $data);
    }

    function list_tabungan_jam()
    {
        $periode = $_POST['periode'];
        $data['data'] = $this->model->list_tabungan_jam($periode);
        echo json_encode($data);
    }

    function list_detail()
    {
        $id = $_POST['id'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $data['data'] = $this->model->get_leave_details($id, $start, $end);
        echo json_encode($data);
    }

    function cekJumlahCuti()
    {
        $periode = $_POST['periode'];
        $id =  $this->session->userdata('user_id');
        $data = $this->model->cekJumlahCuti($id, $periode);
        echo json_encode($data);
    }

    function cekCuti()
    {
        $periode = $this->input->post('periode');
        $data = $this->model->getDataTabungan($periode);
        echo json_encode($data);
    }

    function save_leave()
    {
        $periode = $this->input->post('tgl_ph');
        $leave_type = $this->input->post('leave_type');
        $start_date = $this->input->post('start_date');
        $leave_reason = $this->input->post('leave_reason');
        $dataTabungan = $this->model->getDataTabungan($periode);
        $totalPengajuan = $this->model->getTotalPengajuan($periode);
        $totalHari = $this->model->cekTotalHari($periode);
        $totalJam = 11 * ($totalPengajuan->total_pengajuan + 1);
        // var_dump($totalHari);
        // die();
        $total_hours = 0;
        $used_ids = [];
        $remaining_hours = 0;

        foreach ($dataTabungan as $item) {
            if ($total_hours >= $totalJam) break;
            $needed_hours = $totalJam - $total_hours;
            if ($item['tabungan_jam'] <= $needed_hours) {
                $total_hours += $item['tabungan_jam'];
                $used_ids[] = $item['leave_id'];
            } else {
                $remaining_hours = $item['tabungan_jam'] - $needed_hours;
                $total_hours += $needed_hours;
                $used_ids[] = $item['leave_id'];
                break;
            }
        }

        // var_dump($totalPengajuan->total_pengajuan);
        // die(); 

        if ($totalPengajuan->total_pengajuan >= $totalHari->total_hari){
            $response['status'] = false;
            $response['error'] = 'Pengajuan sudah lebih dari ' . $totalHari->total_hari . ' hari';
        }else {

        if (!empty($_FILES['attachment']['tmp_name'])) {
            if (is_uploaded_file($_FILES['attachment']['tmp_name'])) {
                //checking image type
                $allowed =  array('png', 'jpg', 'jpeg', 'pdf', 'gif');
                $filename = $_FILES['attachment']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                if (in_array($ext, $allowed)) {
                    $tmp_name = $_FILES["attachment"]["tmp_name"];
                    // $profile = "/var/www/trusmiverse/hr/uploads/leave/";
                    $profile = "/var/www/trusmiverse/apps/uploads/leave/";

                    $set_img = base_url() . "uploads/leave/";

                    $name = basename($_FILES["attachment"]["name"]);
                    $newfilename = 'tv_leave_' . round(microtime(true)) . '.' . $ext;
                    move_uploaded_file($tmp_name, $profile . $newfilename);
                    $fname = $newfilename;
                } else {
                    $response['error'] = '';
                }
            }
        } else {
            $fname = '';
        }
        $data = array(
            'employee_id' => $this->session->userdata('user_id'),
            'company_id' => $this->session->userdata('company_id'),
            'department_id' => $this->session->userdata('department_id'),
            'leave_type_id' => $leave_type,
            'from_date' => $start_date,
            'to_date' => $start_date,
            'applied_on' => date('Y-m-d h:i:s'),
            'reason' => $leave_reason,
            'leave_attachment' => $fname,
            'status' => '1',
            'is_notify' => '1',
            'is_half_day' => '0',
            'tgl_ph' => $periode,
            'created_at' => date('Y-m-d h:i:s')
        );
        $this->db->insert('xin_leave_applications', $data);
        $response['insert_leave_applications'] = true;
        // Update ganti_hari untuk record yang digunakan
        if (!empty($used_ids)) {
            $this->db->where_in('leave_id', $used_ids);
            $this->db->update('xin_leave_applications', ['ganti_hari' => 1]);
            $response['update_ganti_hari'] = true;
        }
        $response['status'] = true;
    }
        echo json_encode($response);
    }
}
