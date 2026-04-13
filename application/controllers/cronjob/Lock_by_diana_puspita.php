<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lock_by_diana_puspita extends CI_Controller
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
        $created_by = 9909; // Diana Puspita

        // Dhewana 5121
        $insert1 = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                    (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`, `activity`) 
                                    VALUES 
                                    ('other', 5121, 'Silahkan mengirimkan Data KPI Corp (Sales, IT, Complain) - By Diana Puspita', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL, 'Data KPI Corp (Sales, IT, Complain) - By Diana Puspita')");

        // Yeyen 76
        $insert2 = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                    (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`, `activity`) 
                                    VALUES 
                                    ('other', 76, 'Silahkan mengirimkan Data KPI Corp (Finance) - By Diana Puspita', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL, 'Data KPI Corp (Finance) - By Diana Puspita')");

        // Feronita 331
        $insert3 = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                    (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`, `activity`) 
                                    VALUES 
                                    ('other', 331, 'Silahkan mengirimkan Data KPI Corp (Pencairan Dajam) - By Diana Puspita', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL, 'Data KPI Corp (Pencairan Dajam) - By Diana Puspita')");

        // Firman 2397
        $insert4 = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                    (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`, `activity`) 
                                    VALUES 
                                    ('other', 2397, 'Silahkan mengirimkan Data KPI Corp (SP3K dan Akad) - By Diana Puspita', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL, 'Data KPI Corp (SP3K dan Akad) - By Diana Puspita')");

        // Rizki 10231
        $insert5 = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                    (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`, `activity`) 
                                    VALUES 
                                    ('other', 10231, 'Silahkan mengirimkan Data KPI Corp (HR) - By Diana Puspita', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL, 'Data KPI Corp (HR) - By Diana Puspita')");

    }

}
