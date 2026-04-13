<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lock_penyerahan_nota_rakon extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        echo "Cronjob insert to lock manual";
    }

    function insert_lock()
    {
        $this->load->database();

        // user pelaksana
        $users_pic_lock = [
            2435, // essen
            6454, // sigit
            4307, // m faizal
            2808, // taufiq isya
            5095, // hadi h
            4305, // yagung
            3599, // anggi n
            4602, // bayu akbar
            2711, // m saiful
            6813, // ariyanto
            2296, // rosid
            5237 // putra baliho
            // 6468, // kusnendar
            // 2806, // hamdan ali
            // 4368, // boby dwi
            // 6332 // m agung
        ];

        // $user_validation = 5267; // Retno - admin purchase
        // $user_validation = 5049; // Hayatunisa
        // $user_validation = 9537; // Tira nur asih 
        $user_validation = 10221; // nina7877 

        foreach ($users_pic_lock as $user) {
            $insert = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES ('nota', $user, 'Maaf, Anda harus menyerahkan bukti Nota ke bagian Administrasi Rakon', 1, '" . date('Y-m-d H:i:s') . "', $user_validation, NULL, NULL)");
            echo $insert;
        }
    }
}
