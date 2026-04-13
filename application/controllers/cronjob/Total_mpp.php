<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Total_mpp extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    // function index()
    // {
    //     $date = date("Y-m-d"); // Tanggal tertentu

    //     // Mengonversi tanggal ke timestamp
    //     $timestamp = strtotime($date);

    //     // Mengambil hari, bulan, dan tahun dari tanggal
    //     $day = date('j', $timestamp);
    //     $month = date('m', $timestamp);
    //     $year = date('Y', $timestamp);

    //     // Mendapatkan tanggal pertama bulan tersebut
    //     $firstDayOfMonth = strtotime("$year-$month-01");

    //     // Menghitung nomor minggu berdasarkan hari pertama bulan tersebut
    //     // Pertama kita tentukan hari pertama bulan itu (Senin)
    //     $firstDayOfMonthWeekday = date('N', $firstDayOfMonth); // 'N' untuk mendapatkan nomor hari (1 = Senin, ..., 7 = Minggu)
    //     $weekStartDay = ($firstDayOfMonthWeekday == 1) ? 1 : (8 - $firstDayOfMonthWeekday);

    //     // Menghitung minggu dalam bulan
    //     $weekOfMonth = intval(($day + $weekStartDay - 1) / 7) + 1;

    //     $this->load->database();
    //     $get_emp = $this->db->query("SELECT ct.name AS status_karyawan, 
    //                     CASE WHEN ct.name IN ('Kontrak','Tetap') THEN 'Reguler'
    //                     ELSE 'Non Reguler' END AS jenis_karyawan,
    //                     CASE WHEN e.ctm_posisi IN ('Direktur','Head','Manager','Supervisor') THEN 'Leader Up'
    //                     ELSE 'Leader Below' END AS level_karyawan,
    //                     e.user_id, 
    //                                         CONCAT( e.first_name, ' ', e.last_name ) AS full_name, 
    //                                                             e.company_id, e.department_id, e.designation_id, e.ctm_posisi,
    //                                                             latest_contracts.contract_type_id
    //                                     FROM xin_employees e
    //                                     JOIN (
    //                                         SELECT ec1.employee_id, ec1.contract_type_id
    //                                         FROM xin_employee_contract ec1
    //                                         INNER JOIN (
    //                                             SELECT employee_id, MAX(created_at) AS max_created_at
    //                                             FROM xin_employee_contract
    //                                             WHERE is_active = 1
    //                                             GROUP BY employee_id
    //                                         ) ec2 ON ec1.employee_id = ec2.employee_id AND ec1.created_at = ec2.max_created_at
    //                                         WHERE ec1.is_active = 1
    //                                     ) latest_contracts ON e.user_id = latest_contracts.employee_id
    //                                     JOIN xin_contract_type ct ON latest_contracts.contract_type_id = ct.contract_type_id
    //                                     WHERE e.is_active = 1 AND ct.name != 'Engangement'");

    //     $non_aktif_counter = 0;
    //     if ($get_emp->num_rows() > 0) {
    //         $data_emp = $get_emp->result();
    //         foreach ($data_emp as $row) {
    //             $user_id = $row->user_id;
    //             $data_mpp = array(
    //                 'user_id'               => $row->user_id,
    //                 'periode'               => date("Y-m-d"),
    //                 'week'                  => $weekOfMonth,
    //                 'status_karyawan'       => $row->status_karyawan,
    //                 'jenis_karyawan'        => $row->jenis_karyawan,
    //                 'level_karyawan'        => $row->level_karyawan,
    //                 'company_id'            => $row->company_id,
    //                 'department_id'         => $row->department_id,
    //                 'designation_id'        => $row->designation_id,
    //                 'ctm_posisi'            => $row->ctm_posisi,
    //                 'contract_type_id'      => $row->contract_type_id,

    //                 'created_at'            => date("Y-m-d H:i:s"),
    //             );

    //             $response['insert'] = $this->db->insert('trusmi_mpp_det', $data_mpp);
    //             // echo json_encode($data_mpp);

    //         }
    //     }

    //     echo json_encode($response);
    // }

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
        $get_emp = $this->db->query("WITH EmployeeData AS (
                            SELECT 
                                ct.name AS status_karyawan, 
                                        CASE 
                                    WHEN ct.name = 'Tetap' THEN 1
                                    WHEN ct.name = 'Kontrak' THEN 2
                                    WHEN ct.name = 'Non Kontrak' THEN 3
                                    WHEN ct.name = 'Perjanjian' THEN 4
                                    ELSE '5' 
                                END AS sk_id,
                                CASE 
                                    WHEN ct.name IN ('Kontrak', 'Tetap') THEN 'Reguler'
                                    ELSE 'Non Reguler' 
                                END AS jenis_karyawan,
                                                        CASE 
                                    WHEN ct.name = 'Tetap' THEN 1            
                                    ELSE 2
                                END AS jk_id,
                                CASE 
                                    WHEN e.ctm_posisi IN ('Direktur', 'Head', 'Manager', 'Supervisor') THEN 'Leader Up'
                                    ELSE 'Leader Below' 
                                END AS level_karyawan,
                                        CASE 
                                            WHEN e.ctm_posisi IN ('Direktur', 'Head', 'Manager', 'Supervisor') THEN 2
                                            ELSE 1
                                END AS lk_id,
                                        CASE 
                                            WHEN e.ctm_posisi = 'Direktur' THEN 6
                                            WHEN e.ctm_posisi = 'Head' THEN 5
                                            WHEN e.ctm_posisi = 'Manager' THEN 4
                                            WHEN e.ctm_posisi = 'Supervisor' THEN 3
                                            WHEN e.ctm_posisi = 'Officer' THEN 2
                                            ELSE 1
                                END AS pk_id,
                                e.ctm_posisi,
                                e.user_id
                            FROM xin_employees e
                            JOIN (
                                SELECT 
                                    ec1.employee_id, 
                                    ec1.contract_type_id
                                FROM xin_employee_contract ec1
                                INNER JOIN (
                                    SELECT 
                                        employee_id, 
                                        MAX(created_at) AS max_created_at
                                    FROM xin_employee_contract
                                    WHERE is_active = 1
                                    GROUP BY employee_id
                                ) ec2 ON ec1.employee_id = ec2.employee_id AND ec1.created_at = ec2.max_created_at
                                WHERE ec1.is_active = 1
                            ) latest_contracts ON e.user_id = latest_contracts.employee_id
                            JOIN xin_contract_type ct ON latest_contracts.contract_type_id = ct.contract_type_id
                            WHERE e.is_active = 1
                        ),

                        Byposisi AS (
                            SELECT
                                pk_id,
                                status_karyawan,
                                level_karyawan,
                                        ctm_posisi,
                                COUNT(*) AS total_posisi_karyawan
                            FROM EmployeeData
                            GROUP BY status_karyawan, level_karyawan, ctm_posisi
                        ),

                        Bylevel AS (
                            SELECT
                                        lk_id,
                                status_karyawan,
                                level_karyawan,
                                COUNT(*) AS total_level_karyawan
                            FROM EmployeeData
                            GROUP BY status_karyawan, level_karyawan
                        ),

                        ByStatus AS (
                            SELECT
                                        sk_id,
                                status_karyawan,
                                COUNT(*) AS total_status_karyawan
                            FROM EmployeeData
                            GROUP BY status_karyawan
                        ),
                        Byall AS (
                            SELECT
                                COUNT(*) AS total_karyawan
                            FROM EmployeeData
                        )

                        SELECT
                                total_karyawan,
                                sk_id,
                            bl.status_karyawan AS sk,
                            bc.total_status_karyawan AS t_sk,
                            ROUND((bc.total_status_karyawan / total_karyawan ) * 100,2) p_sk,
                                bc.total_status_karyawan AS t_jk,
                            ROUND((bc.total_status_karyawan / total_karyawan ) * 100,2) p_jk,
                                lk_id,
                            bl.level_karyawan AS lk,
                            bl.total_level_karyawan AS t_lk,
                                ROUND((bl.total_level_karyawan / total_karyawan ) * 100,2) p_lk,
                                pk_id,
                                bp.ctm_posisi AS pk,
                                bp.total_posisi_karyawan AS t_pk,
                                ROUND((bp.total_posisi_karyawan / total_karyawan ) * 100,2) p_pk

                        FROM Bylevel bl
                        JOIN ByStatus bc
                            ON bl.status_karyawan = bc.status_karyawan
                        JOIN Byposisi bp
                            ON bl.status_karyawan = bp.status_karyawan AND bl.level_karyawan = bp.level_karyawan,
                        (SELECT total_karyawan FROM Byall) Byall
                        ORDER BY sk_id, lk_id, pk_id

                                    ");

        $non_aktif_counter = 0;
        if ($get_emp->num_rows() > 0) {
            $data_emp = $get_emp->result();
            foreach ($data_emp as $row) {
                $data_mpp = array(
                    'periode'               => date("Y-m-d"),
                    'week'                  => $weekOfMonth,
                    'total_karyawan'               => $row->total_karyawan,
                    'sk_id'                 => $row->sk_id,
                    'sk'                    => $row->sk,
                    't_sk'                  => $row->t_sk,
                    'p_sk'                  => $row->p_sk,
                    't_jk'         => $row->t_jk,
                    'p_jk'        => $row->p_jk,
                    'lk_id'            => $row->lk_id,
                    'lk'      => $row->lk,
                    't_lk'      => $row->t_lk,
                    'p_lk'      => $row->p_lk,
                    'pk_id'      => $row->pk_id,
                    'pk'      => $row->pk,
                    't_pk'      => $row->t_pk,
                    'p_pk'      => $row->p_pk,

                    'created_at'            => date("Y-m-d H:i:s"),
                );

                $response['insert'] = $this->db->insert('trusmi_mpp', $data_mpp);
                // echo json_encode($data_mpp);

            }
        }

        echo json_encode($response);
    }
}
