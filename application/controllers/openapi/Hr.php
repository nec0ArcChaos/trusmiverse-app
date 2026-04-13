<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Hr extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('hr/model_rekap_absen', 'model_rekap_absen');
    }

    public function report_absen()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $phone_number = $input['phone_number'];
        $phone_number = str_replace('@c.us', '', $phone_number);
        $employee = $this->db->query("SELECT 
            e.user_id,
            CONCAT( e.first_name, ' ', e.last_name ) AS employee_name, 
            e.ctm_cutoff, 
            e.company_id, 
            e.department_id, 
            e.designation_id
        FROM xin_employees e 
        WHERE IF( LEFT ( e.contact_no, 1 ) = '0', CONCAT( '62', SUBSTRING( e.contact_no, 2 )), e.contact_no ) = '$phone_number'")->row();

        if (!$employee) {
            echo json_encode(['status' => 'error', 'message' => 'Employee not found'], 404);
            return;
        }

        $employee_id = $employee->user_id;
        $company_id = $employee->company_id;
        $department_id = $employee->department_id;
        $designation_id = $employee->designation_id;
        $employee_name = $employee->employee_name;
        $cutoff = $employee->ctm_cutoff;
        $today = date("Y-m-d");
        $periode = date("Y-m", strtotime($today));
        $month = date("m", strtotime($today));
        if ($cutoff == 1) { // 21-20
            if ($month == date("m") && date("d") <= 20) {
                $end_harus_hadir = date("Y-m-d", strtotime(date("Y-m-d") . " -1 days"));
            } else {
                $end_harus_hadir = date("Y-m-19");
            }
            $start = date("Y-m-21", strtotime($today . " -1 months"));
            $end = date("Y-m-20", strtotime($periode));
        } else if ($cutoff == 2) { // 16-15
            if ($month == date("m") && date("d") <= 20) {
                $end_harus_hadir = date("Y-m-16", strtotime($periode . "-01"));
            } else {
                $end_harus_hadir = date("Y-m-14");
            }
            $start = date("Y-m-16", strtotime($today . " -1 months"));
            $end = date("Y-m-15", strtotime($periode));
        } else { // 01-eom
            if ($month == date("m") && date("d") <= date("t")) {
                $end_harus_hadir = date("Y-m-d", strtotime(date("Y-m-d") . " -1 days"));
            } else {
                $end_harus_hadir = date("Y-m-t", strtotime($periode . "-01"));
            }
            $start = date("Y-m-01", strtotime($periode));
            $end = date("Y-m-t", strtotime($periode));
        }

        $sub_emp = 0;
        $data_absen = $this->model_rekap_absen->get_absensi($start, $end, $company_id, $department_id, $employee_id,  $sub_emp, NULL, $cutoff)->row(0);

        $data = [
            "nama" => $employee_name,
            "lokasi" => $data_absen->location,
            "periode" => date("F Y", strtotime($today)),
            "jumlah_hari_kerja" => $data_absen->harus_hadir,
            "jumlah_hadir" => $data_absen->total_hadir,
            "tidak_hadir" => $data_absen->bolos,
            "telat" => $data_absen->telat,
            "menit_telat" => $data_absen->menit_telat,
            "izin_dinas" => [
                "DL" => 2,
                "DT" => 1,
                "PC" => 1
            ],
            "cuti" => [
                "tahunan" => 0,
                "khusus" => 0
            ],
            "libur_nasional" => 2,
            "keterangan_harian" => [] // array 30 elemen
        ];


        echo json_encode([
            'status' => 'success',
            'employee_name' => $employee_name,
            'data_absen' => $data_absen
        ], 200);
    }
}
