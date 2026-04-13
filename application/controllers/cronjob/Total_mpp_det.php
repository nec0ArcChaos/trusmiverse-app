<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Total_mpp_det extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $date = date("Y-m-d"); // Tanggal tertentu

        // Mengonversi tanggal ke timestamp
        $timestamp = strtotime($date);

        // Mengambil hari, bulan, dan tahun dari tanggal
        $day = date('j', $timestamp);
        $month = date('m', $timestamp);
        $year = date('Y', $timestamp);

        // Mendapatkan tanggal pertama bulan tersebut
        $firstDayOfMonth = strtotime("$year-$month-01");

        // Menghitung nomor minggu berdasarkan hari pertama bulan tersebut
        // Pertama kita tentukan hari pertama bulan itu (Senin)
        $firstDayOfMonthWeekday = date('N', $firstDayOfMonth); // 'N' untuk mendapatkan nomor hari (1 = Senin, ..., 7 = Minggu)
        $weekStartDay = ($firstDayOfMonthWeekday == 1) ? 1 : (8 - $firstDayOfMonthWeekday);

        // Menghitung minggu dalam bulan
        $weekOfMonth = intval(($day + $weekStartDay - 1) / 7) + 1;

        $this->load->database();
        $get_emp = $this->db->query("SELECT ct.name AS status_karyawan, 
                        CASE WHEN ct.name IN ('Kontrak','Tetap') THEN 'Reguler'
                        ELSE 'Non Reguler' END AS jenis_karyawan,
                        CASE WHEN e.ctm_posisi IN ('Direktur','Head','Manager','Supervisor') THEN 'Leader Up'
                        ELSE 'Leader Below' END AS level_karyawan,
                        e.user_id, 
                                            CONCAT( e.first_name, ' ', e.last_name ) AS full_name, 
                                                                e.company_id, e.department_id, e.designation_id, e.ctm_posisi,
                                                                latest_contracts.contract_type_id
                                        FROM xin_employees e
                                        JOIN (
                                            SELECT ec1.employee_id, ec1.contract_type_id
                                            FROM xin_employee_contract ec1
                                            INNER JOIN (
                                                SELECT employee_id, MAX(created_at) AS max_created_at
                                                FROM xin_employee_contract
                                                WHERE is_active = 1
                                                GROUP BY employee_id
                                            ) ec2 ON ec1.employee_id = ec2.employee_id AND ec1.created_at = ec2.max_created_at
                                            WHERE ec1.is_active = 1
                                        ) latest_contracts ON e.user_id = latest_contracts.employee_id
                                        JOIN xin_contract_type ct ON latest_contracts.contract_type_id = ct.contract_type_id
                                        WHERE e.is_active = 1 AND ct.name != 'Engangement'");

        $non_aktif_counter = 0;
        if ($get_emp->num_rows() > 0) {
            $data_emp = $get_emp->result();
            foreach ($data_emp as $row) {
                $user_id = $row->user_id;
                $data_mpp = array(
                    'user_id'               => $row->user_id,
                    'periode'               => date("Y-m-d"),
                    'week'                  => $weekOfMonth,
                    'status_karyawan'       => $row->status_karyawan,
                    'jenis_karyawan'        => $row->jenis_karyawan,
                    'level_karyawan'        => $row->level_karyawan,
                    'company_id'            => $row->company_id,
                    'department_id'         => $row->department_id,
                    'designation_id'        => $row->designation_id,
                    'ctm_posisi'            => $row->ctm_posisi,
                    'contract_type_id'      => $row->contract_type_id,

                    'created_at'            => date("Y-m-d H:i:s"),
                );

                $response['insert'] = $this->db->insert('trusmi_mpp_det', $data_mpp);
                // echo json_encode($data_mpp);

            }
        }

        echo json_encode($response);
    }


}
