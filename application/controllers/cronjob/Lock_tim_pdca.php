<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lock_tim_pdca extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function index()
    {
        echo "Cronjob insert to lock manual";
    }

    function insert_lock()
    {
        $created_by = 8230; // alfian5982

        // Julydio 7839 : Senin jam 10:00
        $insert1 = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                    (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`, `activity`) 
                                    VALUES 
                                    ('other', 7839, 'Silahkan mengirimkan target mingguan OKR BT premium Cirebon, Jakarta dan Marketing Batik Kantoran - By Alfian Hidayat', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL, 'Target mingguan OKR - By Alfian Hidayat')");

        // Julydio 7839 : Sabtu jam 10:00
        $insert2 = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                    (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`, `activity`) 
                                    VALUES 
                                    ('other', 7839, 'Silahkan mengirimkan ceklist keterlaksanaan target mingguan OKR BT Premium Cirebon, Jakarta dan Marketing Batik Kantoran - By Alfian Hidayat', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL, 'Ceklist keterlaksanaan target mingguan OKR - By Alfian Hidayat')");


        // Adelia sef 6620 : Senin jam 10:00
        $insert3 = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                    (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`, `activity`) 
                                    VALUES 
                                    ('other', 6620, 'Silahkan mengirimkan target mingguan OKR B2B - By Alfian Hidayat', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL, 'target mingguan OKR B2B - By Alfian Hidayat')");

        // Adelia sef 6620 : Sabtu jam 10:00
        $insert1 = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                    (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`, `activity`) 
                                    VALUES 
                                    ('other', 6620, 'Silahkan mengirimkan ceklist keterlaksanaan target mingguan OKR B2B - By Alfian Hidayat', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL, 'ceklist keterlaksanaan target mingguan OKR B2B - By Alfian Hidayat')");




    }

    function lock_setiap_senin()
    {
        $created_by = 8230; // alfian5982

        // Julydio 7839 : Senin jam 10:00
        $insert1 = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                    (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`, `activity`) 
                                    VALUES 
                                    ('other', 7839, 'Silahkan mengirimkan target mingguan OKR BT premium Cirebon, Jakarta dan Marketing Batik Kantoran - By Alfian Hidayat', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL, 'Target mingguan OKR - By Alfian Hidayat')");

        // Adelia sef 6620 : Senin jam 10:00
        $insert2 = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                    (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`, `activity`) 
                                    VALUES 
                                    ('other', 6620, 'Silahkan mengirimkan target mingguan OKR B2B - By Alfian Hidayat', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL, 'target mingguan OKR B2B - By Alfian Hidayat')");
    }

    function lock_setiap_sabtu()
    {
        $created_by = 8230; // alfian5982

        // Julydio 7839 : Sabtu jam 10:00
        $insert2 = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                    (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`, `activity`) 
                                    VALUES 
                                    ('other', 7839, 'Silahkan mengirimkan ceklist keterlaksanaan target mingguan OKR BT Premium Cirebon, Jakarta dan Marketing Batik Kantoran - By Alfian Hidayat', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL, 'Ceklist keterlaksanaan target mingguan OKR - By Alfian Hidayat')");

        // Adelia sef 6620 : Sabtu jam 10:00
        $insert1 = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                    (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`, `activity`) 
                                    VALUES 
                                    ('other', 6620, 'Silahkan mengirimkan ceklist keterlaksanaan target mingguan OKR B2B - By Alfian Hidayat', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL, 'ceklist keterlaksanaan target mingguan OKR B2B - By Alfian Hidayat')");
    }

}
